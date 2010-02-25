<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | users.php                                                                 |
// |                                                                           |
// | User authentication module.                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* This file handles user authentication
*
* @author   Tony Bibbs <tony@tonybibbs.com>
* @author   Mark Limburg <mlimburg@users.sourceforge.net>
* @author   Jason Whittenburg
*
*/

/**
* Geeklog common function library
*/
require_once 'lib-common.php';
require_once $_CONF['path_system'] . 'lib-user.php';
$VERBOSE = false;

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

// echo COM_debug($_POST);

/**
* Emails password to a user
*
* This will email the given user their password.
*
* @param    string      $username       Username for which to get and email password
* @param    int         $msg            Message number of message to show when done
* @return   string      Optionally returns the HTML for the default form if the user info can't be found
*
*/
function emailpassword ($username, $msg = 0)
{
    global $_CONF, $_TABLES, $LANG04;

    $retval = '';

    $username = addslashes ($username);
    // don't retrieve any remote users!
    $result = DB_query ("SELECT uid,email,status FROM {$_TABLES['users']} WHERE username = '$username' AND ((remoteservice is null) OR (remoteservice = ''))");
    $nrows = DB_numRows ($result);
    if ($nrows == 1) {
        $A = DB_fetchArray ($result);
        if (($_CONF['usersubmission'] == 1) && ($A['status'] == USER_ACCOUNT_AWAITING_APPROVAL))
        {
            return COM_refresh ($_CONF['site_url'] . '/index.php?msg=48');
        }

        $mailresult = USER_createAndSendPassword ($username, $A['email'], $A['uid']);

        if ($mailresult == false) {
            $retval = COM_refresh ("{$_CONF['site_url']}/index.php?msg=85");
        } else if ($msg) {
            $retval = COM_refresh ("{$_CONF['site_url']}/index.php?msg=$msg");
        } else {
            $retval = COM_refresh ("{$_CONF['site_url']}/index.php?msg=1");
        }
    } else {
        $retval = COM_siteHeader ('menu', $LANG04[17])
                . defaultform ($LANG04[17])
                . COM_siteFooter ();
    }

    return $retval;
}

/**
* User request for a new password - send email with a link and request id
*
* @param username string   name of user who requested the new password
* @return         string   form or meta redirect
*
*/
function requestpassword($username)
{
    global $_CONF, $_TABLES, $LANG04;

    $retval = '';

    // no remote users!
    $result = DB_query ("SELECT uid,email,passwd,status FROM {$_TABLES['users']} WHERE username = '$username' AND ((remoteservice IS NULL) OR (remoteservice=''))");
    $nrows = DB_numRows ($result);
    if ($nrows == 1) {
        $A = DB_fetchArray ($result);
        if (($_CONF['usersubmission'] == 1) && ($A['status'] == USER_ACCOUNT_AWAITING_APPROVAL)) {
            return COM_refresh ($_CONF['site_url'] . '/index.php?msg=48');
        }
        $reqid = substr (md5 (uniqid (rand (), 1)), 1, 16);
        DB_change ($_TABLES['users'], 'pwrequestid', "$reqid",
                   'uid', $A['uid']);

        $mailtext = sprintf ($LANG04[88], $username);
        $mailtext .= $_CONF['site_url'] . '/users.php?mode=newpwd&uid=' . $A['uid'] . '&rid=' . $reqid . "\n\n";
        $mailtext .= $LANG04[89];
        $mailtext .= "{$_CONF['site_name']}\n";
        $mailtext .= "{$_CONF['site_url']}\n";

        $subject = $_CONF['site_name'] . ': ' . $LANG04[16];
        if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
            $mailfrom = $_CONF['noreply_mail'];
            $mailtext .= LB . LB . $LANG04[159];
        } else {
            $mailfrom = $_CONF['site_mail'];
        }
        if (COM_mail ($A['email'], $subject, $mailtext, $mailfrom)) {
            $msg = 55; // message sent
        } else {
            $msg = 85; // problem sending the email
        }

        $retval .= COM_refresh ($_CONF['site_url'] . "/index.php?msg=$msg");
        COM_updateSpeedlimit ('password');
    } else {
        $retval .= COM_siteHeader ('menu', $LANG04[17])
                . defaultform ($LANG04[17]) . COM_siteFooter ();
    }

    return $retval;
}

/**
* Display a form where the user can enter a new password.
*
* @param uid       int      user id
* @param requestid string   request id for password change
* @return          string   new password form
*
*/
function newpasswordform ($uid, $requestid)
{
    global $_CONF, $_TABLES, $LANG04;

    $pwform = new Template ($_CONF['path_layout'] . 'users');
    $pwform->set_file (array ('newpw' => 'newpassword.thtml'));
    $pwform->set_var ('xhtml', XHTML);
    $pwform->set_var ('site_url', $_CONF['site_url']);
    $pwform->set_var ('site_admin_url', $_CONF['site_admin_url']);
    $pwform->set_var ('layout_url', $_CONF['layout_url']);

    $pwform->set_var ('user_id', $uid);
    $pwform->set_var ('user_name', DB_getItem ($_TABLES['users'], 'username',
                                               "uid = '{$uid}'"));
    $pwform->set_var ('request_id', $requestid);

    $pwform->set_var ('lang_explain', $LANG04[90]);
    $pwform->set_var ('lang_username', $LANG04[2]);
    $pwform->set_var ('lang_newpassword', $LANG04[4]);
    $pwform->set_var ('lang_newpassword_conf', $LANG04[108]);
    $pwform->set_var ('lang_setnewpwd', $LANG04[91]);

    $retval = COM_startBlock ($LANG04[92]);
    $retval .= $pwform->finish ($pwform->parse ('output', 'newpw'));
    $retval .= COM_endBlock ();

    return $retval;
}

/**
* Creates a user
*
* Creates a user with the give username and email address
*
* @param    string      $username       username to create user for
* @param    string      $email          email address to assign to user
* @param    string      $email_conf     confirmation email address check
* @return   string      HTML for the form again if error occurs, otherwise nothing.
*
*/
function createuser ($username, $email, $email_conf)
{
    global $_CONF, $_TABLES, $LANG01, $LANG04;

    $retval = '';

    $username = trim ($username);
    $email = trim ($email);
    $email_conf = trim ($email_conf);

    if (!isset ($_CONF['disallow_domains'])) {
        $_CONF['disallow_domains'] = '';
    }

    if (COM_isEmail ($email) && !empty ($username) && ($email === $email_conf)
            && !USER_emailMatches ($email, $_CONF['disallow_domains'])
            && (strlen ($username) <= 16)) {

        $ucount = DB_count ($_TABLES['users'], 'username',
                            addslashes ($username));
        $ecount = DB_count ($_TABLES['users'], 'email', addslashes ($email));

        if ($ucount == 0 AND $ecount == 0) {

            // For Geeklog, it would be okay to create this user now. But check
            // with a custom userform first, if one exists.
            if ($_CONF['custom_registration'] &&
                    function_exists ('CUSTOM_userCheck')) {
                $ret = CUSTOM_userCheck ($username, $email);
                if (!empty ($ret)) {
                    // no, it's not okay with the custom userform
                    $retval = COM_siteHeader ('menu')
                            . CUSTOM_userForm ($ret['string'])
                            . COM_siteFooter ();

                    return $retval;
                }
            }

            // Let plugins have a chance to decide what to do before creating the user, return errors.
            $msg = PLG_itemPreSave ('registration', $username);
            if (!empty ($msg)) {
                $retval .= COM_siteHeader ('menu', $LANG04[22]);
                if ($_CONF['custom_registration'] && function_exists ('CUSTOM_userForm')) {
                    $retval .= CUSTOM_userForm ($msg);
                } else {
                    $retval .= newuserform ($msg);
                }
                $retval .= COM_siteFooter();

                return $retval;
            }

            $uid = USER_createAccount ($username, $email);

            if ($_CONF['usersubmission'] == 1) {
                if (DB_getItem ($_TABLES['users'], 'status', "uid = $uid")
                        == USER_ACCOUNT_AWAITING_APPROVAL) {
                    $retval = COM_refresh ($_CONF['site_url']
                                           . '/index.php?msg=48');
                } else {
                    $retval = emailpassword ($username, 1);
                }
            } else {
                $retval = emailpassword ($username, 1);
            }

            return $retval;
        } else {
            $retval .= COM_siteHeader ('menu', $LANG04[22]);
            if ($_CONF['custom_registration'] &&
                    function_exists ('CUSTOM_userForm')) {
                $retval .= CUSTOM_userForm ($LANG04[19]);
            } else {
                $retval .= newuserform ($LANG04[19]);
            }
            $retval .= COM_siteFooter ();
        }
    } else if ($email !== $email_conf) {
        $msg = $LANG04[125];
        $retval .= COM_siteHeader ('menu', $LANG04[22]);
        if ($_CONF['custom_registration'] && function_exists('CUSTOM_userForm')) {
            $retval .= CUSTOM_userForm ($msg);
        } else {
            $retval .= newuserform ($msg);
        }
        $retval .= COM_siteFooter();
    } else { // invalid username or email address

        if ((empty ($username)) || (strlen($username) > 16)) {
            $msg = $LANG01[32]; // invalid username
        } else {
            $msg = $LANG04[18]; // invalid email address
        }
        $retval .= COM_siteHeader ('menu', $LANG04[22]);
        if ($_CONF['custom_registration'] && function_exists('CUSTOM_userForm')) {
            $retval .= CUSTOM_userForm ($msg);
        } else {
            $retval .= newuserform ($msg);
        }
        $retval .= COM_siteFooter();
    }

    return $retval;
}

/**
* Shows the user login form
* after failed attempts to either login or access a page requiring login.
*
* @param    boolean $hide_forgotpw_link whether to hide "forgot password?" link
* @param    int     $userstatus         status of the user's account
* @return   string                      HTML for login form
*
*/
function loginform($hide_forgotpw_link = false, $userstatus = -1)
{
    global $LANG04;

    $cfg = array(
        'hide_forgotpw_link' => $hide_forgotpw_link
    );

    if ($userstatus == USER_ACCOUNT_DISABLED) {
        $cfg['title']   = $LANG04[114];
        $cfg['message'] = $LANG04[115];
        $cfg['hide_forgotpw_link'] = true;
        $cfg['no_newreg_link']     = true;
    } elseif ($userstatus == USER_ACCOUNT_AWAITING_APPROVAL) {
        $cfg['title']   = $LANG04[116];
        $cfg['message'] = $LANG04[117];
        $cfg['hide_forgotpw_link'] = true;
        $cfg['no_newreg_link']     = true;
    } else {
        $cfg['title']   = $LANG04[65];
        $cfg['message'] = $LANG04[66];
    }

    return SEC_loginForm($cfg);
}

/**
* Shows the user registration form
*
* @param    int     $msg        message number to show
* @param    string  $referrer   page to send user to after registration
* @return   string  HTML for user registration page
*/
function newuserform ($msg = '')
{
    global $_CONF, $LANG04;

    $retval = '';

    if (!empty ($msg)) {
        $retval .= COM_startBlock ($LANG04[21], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
                . $msg
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }
    $user_templates = new Template($_CONF['path_layout'] . 'users');
    $user_templates->set_file('regform', 'registrationform.thtml');
    $user_templates->set_var('xhtml', XHTML);
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('start_block', COM_startBlock($LANG04[22]));
    $user_templates->set_var('lang_instructions', $LANG04[23]);
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('lang_email_conf', $LANG04[124]);
    $user_templates->set_var('lang_warning', $LANG04[24]);
    $user_templates->set_var('lang_register', $LANG04[27]);
    PLG_templateSetVars ('registration', $user_templates);
    $user_templates->set_var('end_block', COM_endBlock());

    $username = '';
    if (!empty ($_POST['username'])) {
        $username = COM_applyFilter ($_POST['username']);
    }
    $user_templates->set_var ('username', $username);

    $email = '';
    if (!empty ($_POST['email'])) {
        $email = COM_applyFilter ($_POST['email']);
    }
    $user_templates->set_var ('email', $email);

    $email_conf = '';
    if (!empty ($_POST['email_conf'])) {
        $email_conf = COM_applyFilter ($_POST['email_conf']);
    }
    $user_templates->set_var ('email_conf', $email_conf);


    $user_templates->parse('output', 'regform');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
* Shows the password retrieval form
*
* @return   string  HTML for form used to retrieve user's password
*
*/
function getpasswordform()
{
    global $_CONF, $LANG04;

    $retval = '';

    $user_templates = new Template($_CONF['path_layout'] . 'users');
    $user_templates->set_file('form', 'getpasswordform.thtml');
    $user_templates->set_var('xhtml', XHTML);
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('start_block_forgetpassword', COM_startBlock($LANG04[25]));
    $user_templates->set_var('lang_instructions', $LANG04[26]);
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('lang_emailpassword', $LANG04[28]);
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->parse('output', 'form');

    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
* Account does not exist - show both the login and register forms
*
* @param    string  $msg        message to display if one is needed
* @return   string  HTML for form
*
*/
function defaultform($msg)
{
    global $_CONF, $LANG04;

    $retval = '';

    if (! empty($msg)) {
        $retval .= COM_showMessageText($msg, $LANG04[21]);
    }

    $retval .= loginform(true);

    if (! $_CONF['disable_new_user_registration']) {
        $retval .= newuserform();
    }

    $retval .= getpasswordform();

    return $retval;
}

/**
* Display message after a login error
*
* @param    int     $msg            message number for custom handler
* @param    string  $message_title  title for the message box
* @param    string  $message_text   text of the message box
* @return   void                    function does not return!
*
*/
function displayLoginErrorAndAbort($msg, $message_title, $message_text)
{
    global $_CONF;

    if ($_CONF['custom_registration'] &&
            function_exists('CUSTOM_loginErrorHandler')) {
        // Typically this will be used if you have a custom main site page
        // and need to control the login process
        CUSTOM_loginErrorHandler($msg);
    } else {
        $retval = COM_siteHeader('menu', $message_title)
                . COM_startBlock($message_title, '',
                                 COM_getBlockTemplate('_msg_block', 'header'))
                . $message_text
                . COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'))
                . COM_siteFooter();

        header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
        header('Status: 403 Forbidden');
        echo $retval;
    }

    // don't return
    exit;
}


/**
* Re-send a request after successful re-authentication
*
* Re-creates a GET or POST request based on data passed along in a form. Used
* in case of an expired security token so that the user doesn't lose changes.
*
*/
function resend_request()
{
    global $_CONF;

    require_once 'HTTP/Request.php';

    $method = '';
    if (isset($_POST['token_requestmethod'])) {
        $method = COM_applyFilter($_POST['token_requestmethod']);
    }
    $returnurl = '';
    if (isset($_POST['token_returnurl'])) {
        $returnurl = urldecode($_POST['token_returnurl']);
        if (substr($returnurl, 0, strlen($_CONF['site_url'])) !=
                $_CONF['site_url']) {
            // only accept URLs on our site
            $returnurl = '';
        }
    }
    $postdata = '';
    if (isset($_POST['token_postdata'])) {
        $postdata = urldecode($_POST['token_postdata']);
    }
    $getdata = '';
    if (isset($_POST['token_getdata'])) {
        $getdata = urldecode($_POST['token_getdata']);
    }
    $files = '';
    if (isset($_POST['token_files'])) {
        $files = urldecode($_POST['token_files']);
    }

    if (SECINT_checkToken() && !empty($method) && !empty($returnurl) &&
            ((($method == 'POST') && !empty($postdata)) ||
             (($method == 'GET') && !empty($getdata)))) {

        $req = new HTTP_Request($returnurl);
        if ($method == 'POST') {
            $req->setMethod(HTTP_REQUEST_METHOD_POST);
            $data = unserialize($postdata);
            foreach ($data as $key => $value) {
                if ($key == CSRF_TOKEN) {
                    $req->addPostData($key, SEC_createToken());
                } else {
                    $req->addPostData($key, $value);
                }
            }
            if (! empty($files)) {
                $files = unserialize($files);
            }
            if (! empty($files)) {
                foreach ($files as $key => $value) {
                    $req->addPostData('_files_' . $key, $value);
                }
            }
        } else {
            $req->setMethod(HTTP_REQUEST_METHOD_GET);
            $data = unserialize($getdata);
            foreach ($data as $key => $value) {
                if ($key == CSRF_TOKEN) {
                    $req->addQueryString($key, SEC_createToken());
                } else {
                    $req->addQueryString($key, $value);
                }
            }
        }
        $req->addHeader('User-Agent', 'Geeklog/' . VERSION);
        // need to fake the referrer so the new token matches
        $req->addHeader('Referer', COM_getCurrentUrl());
        foreach ($_COOKIE as $cookie => $value) {
            $req->addCookie($cookie, $value);
        }
        $response = $req->sendRequest();

        if (PEAR::isError($response)) {
            if (! empty($files)) {
                SECINT_cleanupFiles($files);
            }
            trigger_error("Resending $method request failed: " . $response->getMessage());
        } else {
            COM_output($req->getResponseBody());
        }
    } else {
        if (! empty($files)) {
            SECINT_cleanupFiles($files);
        }
        echo COM_refresh($_CONF['site_url'] . '/index.php');
    }

    // don't return
    exit;
}

// MAIN
if (isset ($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
} else {
    $mode = '';
}

$display = '';

switch ($mode) {
case 'logout':
    if (!empty ($_USER['uid']) AND $_USER['uid'] > 1) {
        SESS_endUserSession ($_USER['uid']);
        PLG_logoutUser ($_USER['uid']);
    }
    SEC_setCookie($_CONF['cookie_session'], '', time() - 10000);
    SEC_setCookie($_CONF['cookie_password'], '', time() - 10000);
    SEC_setCookie($_CONF['cookie_name'], '', time() - 10000);
    $display = COM_refresh($_CONF['site_url'] . '/index.php?msg=8');
    break;

case 'profile':
    $uid = COM_applyFilter ($_GET['uid'], true);
    if (is_numeric ($uid) && ($uid > 0)) {
        $msg = 0;
        if (isset($_GET['msg'])) {
            $msg = COM_applyFilter($_GET['msg'], true);
        }
        $plugin = '';
        if (($msg > 0) && isset($_GET['plugin'])) {
            $plugin = COM_applyFilter($_GET['plugin']);
        }
        $display .= USER_showProfile($uid, false, $msg, $plugin);
    } else {
        $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
    }
    break;

case 'user':
    $username = COM_applyFilter ($_GET['username']);
    if (!empty ($username)) {
        $username = addslashes ($username);
        $uid = DB_getItem ($_TABLES['users'], 'uid', "username = '$username'");
        if ($uid > 1) {
            $display .= USER_showProfile($uid);
        } else {
            $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
        }
    } else {
        $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
    }
    break;

case 'create':
    if ($_CONF['disable_new_user_registration']) {
        $display .= COM_siteHeader ('menu', $LANG04[22]);
        $display .= COM_startBlock ($LANG04[22], '',
                            COM_getBlockTemplate ('_msg_block', 'header'))
                 . $LANG04[122]
                 . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= COM_siteFooter ();
    } else {
        $email = COM_applyFilter ($_POST['email']);
        $email_conf = COM_applyFilter ($_POST['email_conf']);
        $display .= createuser(COM_applyFilter ($_POST['username']), $email, $email_conf);
    }
    break;

case 'getpassword':
    $display .= COM_siteHeader ('menu', $LANG04[25]);
    if ($_CONF['passwordspeedlimit'] == 0) {
        $_CONF['passwordspeedlimit'] = 300; // 5 minutes
    }
    COM_clearSpeedlimit ($_CONF['passwordspeedlimit'], 'password');
    $last = COM_checkSpeedlimit ('password');
    if ($last > 0) {
        $display .= COM_startBlock ($LANG12[26], '',
                            COM_getBlockTemplate ('_msg_block', 'header'))
                 . sprintf ($LANG04[93], $last, $_CONF['passwordspeedlimit'])
                 . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    } else {
        $display .= getpasswordform ();
    }
    $display .= COM_siteFooter ();
    break;

case 'newpwd':
    $uid = COM_applyFilter ($_GET['uid'], true);
    $reqid = COM_applyFilter ($_GET['rid']);
    if (!empty ($uid) && is_numeric ($uid) && ($uid > 0) &&
            !empty ($reqid) && (strlen ($reqid) == 16)) {
        $valid = DB_count ($_TABLES['users'], array ('uid', 'pwrequestid'),
                           array ($uid, $reqid));
        if ($valid == 1) {
            $display .= COM_siteHeader ('menu', $LANG04[92]);
            $display .= newpasswordform ($uid, $reqid);
            $display .= COM_siteFooter ();
        } else { // request invalid or expired
            $display .= COM_siteHeader ('menu', $LANG04[25]);
            $display .= COM_showMessage (54);
            $display .= getpasswordform ();
            $display .= COM_siteFooter ();
        }
    } else {
        // this request doesn't make sense - ignore it
        $display = COM_refresh ($_CONF['site_url']);
    }
    break;

case 'setnewpwd':
    if ( (empty ($_POST['passwd']))
            or ($_POST['passwd'] != $_POST['passwd_conf']) ) {
        $display = COM_refresh ($_CONF['site_url']
                 . '/users.php?mode=newpwd&amp;uid=' . $_POST['uid']
                 . '&amp;rid=' . $_POST['rid']);
    } else {
        $uid = COM_applyFilter ($_POST['uid'], true);
        $reqid = COM_applyFilter ($_POST['rid']);
        if (!empty ($uid) && is_numeric ($uid) && ($uid > 0) &&
                !empty ($reqid) && (strlen ($reqid) == 16)) {
            $valid = DB_count ($_TABLES['users'], array ('uid', 'pwrequestid'),
                               array ($uid, $reqid));
            if ($valid == 1) {
                $passwd = SEC_encryptPassword($_POST['passwd']);
                DB_change ($_TABLES['users'], 'passwd', "$passwd",
                           "uid", $uid);
                DB_delete ($_TABLES['sessions'], 'uid', $uid);
                DB_change ($_TABLES['users'], 'pwrequestid', "NULL",
                           'uid', $uid);
                $display = COM_refresh ($_CONF['site_url'] . '/users.php?msg=53');
            } else { // request invalid or expired
                $display .= COM_siteHeader ('menu', $LANG04[25]);
                $display .= COM_showMessage (54);
                $display .= getpasswordform ();
                $display .= COM_siteFooter ();
            }
        } else {
            // this request doesn't make sense - ignore it
            $display = COM_refresh ($_CONF['site_url']);
        }
    }
    break;

case 'emailpasswd':
    if ($_CONF['passwordspeedlimit'] == 0) {
        $_CONF['passwordspeedlimit'] = 300; // 5 minutes
    }
    COM_clearSpeedlimit ($_CONF['passwordspeedlimit'], 'password');
    $last = COM_checkSpeedlimit ('password');
    if ($last > 0) {
        $display .= COM_siteHeader ('menu', $LANG12[26])
                 . COM_startBlock ($LANG12[26], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
                 . sprintf ($LANG04[93], $last, $_CONF['passwordspeedlimit'])
                 . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                 . COM_siteFooter ();
    } else {
        $username = COM_applyFilter ($_POST['username']);
        $email = COM_applyFilter ($_POST['email']);
        if (empty ($username) && !empty ($email)) {
            $username = DB_getItem ($_TABLES['users'], 'username',
                                    "email = '$email' AND ((remoteservice IS NULL) OR (remoteservice = ''))");
        }
        if (!empty ($username)) {
            $display .= requestpassword($username);
        } else {
            $display = COM_refresh ($_CONF['site_url']
                                    . '/users.php?mode=getpassword');
        }
    }
    break;

case 'new':
    $display .= COM_siteHeader ('menu', $LANG04[22]);
    if ($_CONF['disable_new_user_registration']) {
        $display .= COM_startBlock ($LANG04[22], '',
                            COM_getBlockTemplate ('_msg_block', 'header'))
                 . $LANG04[122]
                 . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    } else {
        // Call custom registration and account record create function
        // if enabled and exists
        if ($_CONF['custom_registration'] AND (function_exists('CUSTOM_userForm'))) {
            $display .= CUSTOM_userForm();
        } else {
            $display .= newuserform();
        }
    }
    $display .= COM_siteFooter();
    break;

case 'tokenexpired':
// deliberate fallthrough (see below)
default:

    // prevent dictionary attacks on passwords
    COM_clearSpeedlimit($_CONF['login_speedlimit'], 'login');
    if (COM_checkSpeedlimit('login', $_CONF['login_attempts']) > 0) {
        displayLoginErrorAndAbort(82, $LANG12[26], $LANG04[112]);
    }

    $loginname = '';
    if (isset ($_POST['loginname'])) {
        $loginname = COM_applyFilter ($_POST['loginname']);
    }
    $passwd = '';
    if (isset ($_POST['passwd'])) {
        $passwd = $_POST['passwd'];
    }
    $service = '';
    if (isset ($_POST['service'])) {
        $service = COM_applyFilter($_POST['service']);
    }
    $uid = '';
    if (!empty($loginname) && !empty($passwd) && empty($service)) {
        if (empty($service) && $_CONF['user_login_method']['standard']) {
            $status = SEC_authenticate($loginname, $passwd, $uid);
        } else {
            $status = -1;
        }

    } elseif (( $_CONF['usersubmission'] == 0) && $_CONF['user_login_method']['3rdparty'] && ($service != '')) {
        /* Distributed Authentication */
        //pass $loginname by ref so we can change it ;-)
        $status = SEC_remoteAuthentication($loginname, $passwd, $service, $uid);

    } elseif ($_CONF['user_login_method']['openid'] &&
            ($_CONF['usersubmission'] == 0) &&
            !$_CONF['disable_new_user_registration'] &&
            (isset($_GET['openid_login']) && ($_GET['openid_login'] == '1'))) {
        // Here we go with the handling of OpenID authentification.

        $query = array_merge($_GET, $_POST);

        if (isset($query['identity_url']) &&
                ($query['identity_url'] != 'http://')) {
            $property = sprintf('%x', crc32($query['identity_url']));
            COM_clearSpeedlimit($_CONF['login_speedlimit'], 'openid');
            if (COM_checkSpeedlimit('openid', $_CONF['login_attempts'],
                                    $property) > 0) {
                displayLoginErrorAndAbort(82, $LANG12[26], $LANG04[112]);
            }
        }

        require_once $_CONF['path_system'] . 'classes/openidhelper.class.php';

        $consumer = new SimpleConsumer();
        $handler = new SimpleActionHandler($query, $consumer);

        if (isset($query['identity_url']) && $query['identity_url'] != 'http://') {
            $identity_url = $query['identity_url'];
            $ret = $consumer->find_identity_info($identity_url);
            if (!$ret) {
                COM_updateSpeedlimit('login');
                $property = sprintf('%x', crc32($query['identity_url']));
                COM_updateSpeedlimit('openid', $property);
                COM_errorLog('Unable to find an OpenID server for the identity URL ' . $identity_url);
                echo COM_refresh($_CONF['site_url'] . '/users.php?msg=89');
                exit;
            } else {
                // Found identity server info.
                list($identity_url, $server_id, $server_url) = $ret;

                // Redirect the user-agent to the OpenID server
                // which we are requesting information from.
                header('Location: ' . $consumer->handle_request(
                        $server_id, $server_url,
                        oidUtil::append_args($_CONF['site_url'] . '/users.php',
                            array('openid_login' => '1',
                                  'open_id' => $identity_url)), // Return to.
                        $_CONF['site_url'], // Trust root.
                        null,
                        "email,nickname,fullname")); // Required fields.
                exit;
            }
        } elseif (isset($query['openid.mode']) || isset($query['openid_mode'])) {
            $openid_mode = '';
            if (isset($query['openid.mode'])) {
                $openid_mode = $query['openid.mode'];
            } else if(isset($query['openid_mode'])) {
                $openid_mode = $query['openid_mode'];
            }
            if ($openid_mode == 'cancel') {
                COM_updateSpeedlimit('login');
                echo COM_refresh($_CONF['site_url'] . '/users.php?msg=90');
                exit;
            } else {
               $openid = $handler->getOpenID();
               $req = new ConsumerRequest($openid, $query, 'GET');
               $response = $consumer->handle_response($req);
               $response->doAction($handler);
            }
        } else {
            COM_updateSpeedlimit('login');
            echo COM_refresh($_CONF['site_url'] . '/users.php?msg=91');
            exit;
        }
    } else {
        $status = -1;
    }

    if ($status == USER_ACCOUNT_ACTIVE) { // logged in AOK.
        if ($mode == 'tokenexpired') {
            resend_request(); // won't come back
        }
        DB_change($_TABLES['users'],'pwrequestid',"NULL",'uid',$uid);
        $userdata = SESS_getUserDataFromId($uid);
        $_USER = $userdata;
        $sessid = SESS_newSession($_USER['uid'], $_SERVER['REMOTE_ADDR'], $_CONF['session_cookie_timeout'], $_CONF['cookie_ip']);
        SESS_setSessionCookie($sessid, $_CONF['session_cookie_timeout'], $_CONF['cookie_session'], $_CONF['cookie_path'], $_CONF['cookiedomain'], $_CONF['cookiesecure']);
        PLG_loginUser ($_USER['uid']);

        // Now that we handled session cookies, handle longterm cookie
        if (!isset($_COOKIE[$_CONF['cookie_name']]) || !isset($_COOKIE['password'])) {
            // Either their cookie expired or they are new
            $cooktime = COM_getUserCookieTimeout();
            if ($VERBOSE) {
                COM_errorLog("Trying to set permanent cookie with time of $cooktime",1);
            }
            if ($cooktime > 0) {
                // They want their cookie to persist for some amount of time so set it now
                if ($VERBOSE) {
                    COM_errorLog('Trying to set permanent cookie',1);
                }
                SEC_setCookie($_CONF['cookie_name'], $_USER['uid'],
                              time() + $cooktime);
                SEC_setCookie($_CONF['cookie_password'],
                              SEC_encryptPassword($passwd), time() + $cooktime);
            }
        } else {
            $userid = $_COOKIE[$_CONF['cookie_name']];
            if (empty ($userid) || ($userid == 'deleted')) {
                unset ($userid);
            } else {
                $userid = COM_applyFilter ($userid, true);
                if ($userid > 1) {
                    if ($VERBOSE) {
                        COM_errorLog ('NOW trying to set permanent cookie',1);
                        COM_errorLog ('Got '.$userid.' from perm cookie in users.php',1);
                    }
                    // Create new session
                    $userdata = SESS_getUserDataFromId ($userid);
                    $_USER = $userdata;
                    if ($VERBOSE) {
                        COM_errorLog ('Got '.$_USER['username'].' for the username in user.php',1);
                    }
                }
            }
        }

        // Now that we have users data see if their theme cookie is set.
        // If not set it
        if (! empty($_USER['theme'])) {
            setcookie($_CONF['cookie_theme'], $_USER['theme'],
                      time() + 31536000, $_CONF['cookie_path'],
                      $_CONF['cookiedomain'], $_CONF['cookiesecure']);
        }

        if (!empty($_SERVER['HTTP_REFERER'])
                && (strstr($_SERVER['HTTP_REFERER'], '/users.php') === false)
                && (substr($_SERVER['HTTP_REFERER'], 0,
                        strlen($_CONF['site_url'])) == $_CONF['site_url'])) {
            $indexMsg = $_CONF['site_url'] . '/index.php?msg=';
            if (substr ($_SERVER['HTTP_REFERER'], 0, strlen ($indexMsg)) == $indexMsg) {
                $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
            } else {
                // If user is trying to login - force redirect to index.php
                if (strstr ($_SERVER['HTTP_REFERER'], 'mode=login') === false) {
                    $display .= COM_refresh ($_SERVER['HTTP_REFERER']);
                } else {
                    $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
                }
            }
        } else {
            $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
        }
    } else {
        // On failed login attempt, update speed limit
        if (!empty($loginname) || !empty($passwd) || !empty($service) ||
                ($mode == 'tokenexpired')) {
            COM_updateSpeedlimit('login');
        }

        $display .= COM_siteHeader('menu');

        $msg = 0;
        if (isset($_REQUEST['msg'])) {
            $msg = COM_applyFilter($_REQUEST['msg'], true);
        }
        if ($msg > 0) {
            $display .= COM_showMessage($msg);
        }

        switch ($mode) {
        case 'create':
            // Got bad account info from registration process, show error
            // message and display form again
            if ($_CONF['custom_registration'] AND
                    function_exists('CUSTOM_userForm')) {
                $display .= CUSTOM_userForm();
            } else {
                $display .= newuserform();
            }
            break;

        case 'tokenexpired':
            // check to see if this was the last allowed attempt
            if (COM_checkSpeedlimit('login', $_CONF['login_attempts']) > 0) {
                $files = '';
                if (isset($_POST['token_files'])) {
                    $files = urldecode($_POST['token_files']);
                }
                if (! empty($files)) {
                    SECINT_cleanupFiles($files);
                }
                displayLoginErrorAndAbort(82, $LANG04[163], $LANG04[164]);
            } else {
                $returnurl = '';
                if (isset($_POST['token_returnurl'])) {
                    $returnurl = urldecode($_POST['token_returnurl']);
                }
                $method = '';
                if (isset($_POST['token_requestmethod'])) {
                    $method = COM_applyFilter($_POST['token_requestmethod']);
                }
                $postdata = '';
                if (isset($_POST['token_postdata'])) {
                    $postdata = urldecode($_POST['token_postdata']);
                }
                $getdata = '';
                if (isset($_POST['token_getdata'])) {
                    $getdata = urldecode($_POST['token_getdata']);
                }
                $files = '';
                if (isset($_POST['token_files'])) {
                    $files = urldecode($_POST['token_files']);
                }
                if (SECINT_checkToken() && !empty($method) &&
                        !empty($returnurl) &&
                        ((($method == 'POST') && !empty($postdata)) ||
                        (($method == 'GET') && !empty($getdata)))) {
                    $display .= COM_showMessage(81);
                    $display .= SECINT_authform($returnurl, $method,
                                                $postdata, $getdata, $files);
                } else {
                    if (! empty($files)) {
                        SECINT_cleanupFiles($files);
                    }
                    echo COM_refresh($_CONF['site_url'] . '/index.php');
                    exit;
                }
            }
            break;

        default:
            // check to see if this was the last allowed attempt
            if (COM_checkSpeedlimit('login', $_CONF['login_attempts']) > 0) {
                displayLoginErrorAndAbort(82, $LANG04[113], $LANG04[112]);
            } else { // Show login form
                if(($msg != 69) && ($msg != 70)) {
                    if ($_CONF['custom_registration'] AND
                            function_exists('CUSTOM_loginErrorHandler')) {
                        // Typically this will be used if you have a custom
                        // main site page and need to control the login process
                        $display .= CUSTOM_loginErrorHandler($msg);
                    } else {
                        $display .= loginform(false, $status);
                    }
                }
            }
            break;
        }

        $display .= COM_siteFooter();
    }
    break;
}

COM_output($display);

?>
