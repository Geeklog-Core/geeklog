<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | users.php                                                                 |
// |                                                                           |
// | User authentication module.                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2019 by the following authors:                         |
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
 */

use Geeklog\Session;

/**
 * Geeklog common function library
 */
require_once 'lib-common.php';
require_once $_CONF['path_system'] . 'lib-user.php';
$USER_VERBOSE = COM_isEnableDeveloperModeLog('user');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

// echo COM_debug($_POST);

/**
 * Emails password to a user
 * This will email the given user their password.
 *
 * @param    string $username Username for which to get and email password
 * @param    int    $msg      Message number of message to show when done
 * @return   string      Optionally returns the HTML for the default form if the user info can't be found
 */
function USER_emailPassword($username, $msg = 0)
{
    global $_CONF, $_TABLES, $LANG04;

    $retval = '';

    $username = DB_escapeString($username);
    // don't retrieve any remote users!
    $result = DB_query("SELECT uid,email,status FROM {$_TABLES['users']} WHERE username = '$username' AND ((remoteservice is NULL) OR (remoteservice = ''))");
    $nrows = DB_numRows($result);
    if ($nrows == 1) {
        $A = DB_fetchArray($result);
        if (($_CONF['usersubmission'] == 1) && ($A['status'] == USER_ACCOUNT_AWAITING_APPROVAL)) {
            COM_redirect($_CONF['site_url'] . '/index.php?msg=48');
        }

        $mailresult = USER_createAndSendPassword($username, $A['email'], $A['uid']);

        if ($mailresult == false) {
            COM_redirect("{$_CONF['site_url']}/index.php?msg=85");
        } elseif ($msg) {
            COM_redirect("{$_CONF['site_url']}/index.php?msg=$msg");
        } else {
            COM_redirect("{$_CONF['site_url']}/index.php?msg=1");
        }
    } else {
        COM_redirect("{$_CONF['site_url']}/index.php?msg=85");
    }

    return $retval;
}

/**
 * User request for a new password - send email with a link and request id
 *
 * @param  string $username name of user who requested the new password
 * @return string           form or meta redirect
 */
function USER_requestPassword($username)
{
    global $_CONF, $_TABLES, $LANG04, $LANG31;

    $retval = '';

    // no remote users!
    $result = DB_query("SELECT uid,email,passwd,status FROM {$_TABLES['users']} WHERE username = '$username' AND ((remoteservice IS NULL) OR (remoteservice=''))");
    $numRows = DB_numRows($result);
    if ($numRows == 1) {
        $A = DB_fetchArray($result);
        if (($_CONF['usersubmission'] == 1) && ($A['status'] == USER_ACCOUNT_AWAITING_APPROVAL)) {
			COM_updateSpeedlimit('password');
            COM_redirect($_CONF['site_url'] . '/index.php?msg=48');
        } elseif (($_CONF['usersubmission'] == 0) && ($A['status'] != USER_ACCOUNT_ACTIVE && $A['status'] != USER_ACCOUNT_AWAITING_APPROVAL)) {
            // Don't send password for these accounts with statuses of Locked, Disabled, New Email, New Password
			COM_updateSpeedlimit('password');
            COM_redirect($_CONF['site_url'] . '/index.php?msg=47');
        }
        $reqid = substr(md5(uniqid(rand(), 1)), 1, 16);
        DB_change($_TABLES['users'], 'pwrequestid', "$reqid",
            'uid', $A['uid']);
			
		// Create HTML and plaintext version of email
		$t = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'emails/'));
		
		$t->set_file(array('email_html' => 'user_request_password-html.thtml'));
		// Remove line feeds from plain text templates since required to use {LB} template variable
		$t->preprocess_fn = "CTL_removeLineFeeds"; // Set preprocess_fn before the template file you want to use it on		
		$t->set_file(array('email_plaintext' => 'user_request_password-plaintext.thtml'));

		$t->set_var('email_divider', $LANG31['email_divider']);
		$t->set_var('email_divider_html', $LANG31['email_divider_html']);
		$t->set_var('LB', LB);
		
		$t->set_var('lang_user_request_msg', sprintf($LANG04[88], $username)); 
		$t->set_var('lang_user_action_msg', $LANG04['user_password_action_msg']); 
		$t->set_var('new_password_url', $_CONF['site_url'] . '/users.php?mode=newpwd&uid=' . $A['uid'] . '&rid=' . $reqid);
		$t->set_var('lang_ignore_request_msg', $LANG04[89]);
		$t->set_var('site_name', $_CONF['site_name']);
		$t->set_var('site_url', $_CONF['site_url']);
		$t->set_var('site_slogan', $_CONF['site_slogan']);
		
		// Output final content
		$message[] = $t->parse('output', 'email_html');	
		$message[] = $t->parse('output', 'email_plaintext');	
		
		$mailSubject = $_CONF['site_name'] . ': ' . $LANG04[16];
		
        if (COM_mail($A['email'], $mailSubject, $message, '', true)) {
            $msg = 55; // message sent
        } else {
            $msg = 85; // problem sending the email
        }
		
        $redirect = $_CONF['site_url'] . "/index.php?msg=$msg";
        COM_updateSpeedlimit('password');
        COM_redirect($redirect);
    } else {
        // Username not found so error out
		COM_updateSpeedlimit('password');
		COM_redirect($_CONF['site_url'] . '/index.php?msg=46');
        //COM_redirect($_CONF['site_url'] . "/users.php?mode=getpassword&msg=46");
    }

    return $retval;
}

/**
 * Display a form where the user can enter a new email address.
 *
 * @return string             new email form
 */
function USER_newEmailForm()
{
    global $_CONF, $_TABLES, $LANG04, $_USER;

    $emailForm = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'users'));
    $emailForm->set_file(array('newemail' => 'newemail.thtml'));

    $uid = $_USER['uid'];
    $emailForm->set_var('user_id', $uid);
    $emailForm->set_var('user_name', DB_getItem($_TABLES['users'], 'username', "uid = '{$uid}'"));


    $emailForm->set_var('lang_explain', $LANG04['desc_new_email_status']);
    $emailForm->set_var('mode', 'setnewemailstatus');

    $emailForm->set_var('lang_username', $LANG04[2]);
    $emailForm->set_var('lang_newemail', $LANG04['new_email']);
    $emailForm->set_var('lang_newemail_conf', $LANG04['confirm_new_email']);
    $emailForm->set_var('lang_setnewemail', $LANG04['set_new_email']);

    $retval = COM_startBlock($LANG04['enter_new_email'])
        . $emailForm->finish($emailForm->parse('output', 'newemail'))
        . COM_endBlock();

    return $retval;
}

/**
 * Display a form where the user can enter a new password.
 *
 * @param  int    $uid       user id
 * @param  string $requestId request id for password change
 * @return string             new password form
 */
function USER_newPasswordForm($uid, $requestId = "")
{
    global $_CONF, $_TABLES, $LANG04;

    $passwordForm = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'users'));
    $passwordForm->set_file(array('newpw' => 'newpassword.thtml'));

    $passwordForm->set_var('user_id', $uid);
    $passwordForm->set_var('user_name', DB_getItem($_TABLES['users'], 'username', "uid = '{$uid}'"));
    if (!empty($requestId)) {
        // Used for form if User requests to set a new password
        $passwordForm->set_var('request_id', $requestId);
        $passwordForm->set_var('lang_explain', $LANG04[90]);
        $passwordForm->set_var('mode', 'setnewpwd');
    } else {
        // Used for form if User status is set to require a new password on next login
        $passwordForm->set_var('lang_explain', $LANG04['desc_new_pwd_status']);
        $passwordForm->set_var('mode', 'setnewpwdstatus');
    }
    $passwordForm->set_var('lang_username', $LANG04[2]);
    $passwordForm->set_var('lang_newpassword', $LANG04[4]);
    $passwordForm->set_var('lang_newpassword_conf', $LANG04[108]);
    $passwordForm->set_var('lang_setnewpwd', $LANG04[91]);

    $retval = COM_startBlock($LANG04[92])
        . $passwordForm->finish($passwordForm->parse('output', 'newpw'))
        . COM_endBlock();

    return $retval;
}

/**
 * Creates a user
 * Creates a user with the give username and email address
 *
 * @param    string $username   username to create user for
 * @param    string $email      email address to assign to user
 * @param    string $email_conf confirmation email address check
 * @return   string             HTML for the form again if error occurs, otherwise nothing.
 */
function USER_createUser($username, $email, $email_conf)
{
    global $_CONF, $_TABLES, $LANG01, $LANG04;

    $retval = '';

    $username = trim($username);
    $email = trim($email);
    $email_conf = trim($email_conf);

    if (!isset($_CONF['disallow_domains'])) {
        $_CONF['disallow_domains'] = '';
    }

    // USER_isValidEmailAddress checks if actually proper format and if it exists in the user table and if domain has been banned plus a few other things
    if (USER_isValidEmailAddress($email) && !empty($username) && ($email === $email_conf) &&
        (strlen($username) <= 16)) {

        // Remember some database collations are case and accent insensitive and some are not. They would consider "nina", "nina  ", "Nina", and, "niña" as the same
        $ucount = DB_getItem($_TABLES['users'], 'COUNT(*)', "TRIM(LOWER(username)) = TRIM(LOWER('$username'))");
        if ($ucount == 0) {
            // For Geeklog, it would be okay to create this user now. But check
            // with a custom userform first, if one exists.
            if ($_CONF['custom_registration'] && function_exists('CUSTOM_userCheck')) {
                $ret = CUSTOM_userCheck($username, $email);
                if (!empty($ret)) {
                    // no, it's not okay with the custom userform
                    $retval = COM_createHTMLDocument(CUSTOM_userForm($ret['string']));

                    return $retval;
                }
            }

            // Let plugins like captcha have a chance to decide what to do before creating the user, return errors.
            $msg = PLG_itemPreSave('registration', $username);
            if (!empty($msg)) {
                if ($_CONF['custom_registration'] && function_exists('CUSTOM_userForm')) {
                    $retval .= CUSTOM_userForm($msg);
                } else {
                    $retval .= USER_newUserForm($msg);
                }
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[22]));

                return $retval;
            }

            $uid = USER_createAccount($username, $email);

            if ($_CONF['usersubmission'] == 1) {
                if (DB_getItem($_TABLES['users'], 'status', "uid = $uid")
                    == USER_ACCOUNT_AWAITING_APPROVAL
                ) {
                    COM_redirect($_CONF['site_url'] . '/index.php?msg=48');
                } else {
                    $retval = USER_emailPassword($username, 1);
                }
            } else {
                $retval = USER_emailPassword($username, 1);
            }

            return $retval;
        } else {
            if ($_CONF['custom_registration'] &&
                function_exists('CUSTOM_userForm')
            ) {
                $retval .= CUSTOM_userForm($LANG04[19]);
            } else {
                $retval .= USER_newUserForm($LANG04[19]);
            }
            $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[22]));
        }
    } elseif ($email !== $email_conf) {
        $msg = $LANG04[125];
        if ($_CONF['custom_registration'] && function_exists('CUSTOM_userForm')) {
            $retval .= CUSTOM_userForm($msg);
        } else {
            $retval .= USER_newUserForm($msg);
        }
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[22]));
    } else { // invalid username or email address
        if ((empty($username)) || (strlen($username) > 16)) {
            $msg = $LANG01[32]; // invalid username
        } else {
            if (!COM_isEmail($email)) {
                $msg = $LANG04[18]; // invalid email address
            } else {
                $msg = $LANG04[20];
            }
        }
        if ($_CONF['custom_registration'] && function_exists('CUSTOM_userForm')) {
            $retval .= CUSTOM_userForm($msg);
        } else {
            $retval .= USER_newUserForm($msg);
        }
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[22]));
    }

    return $retval;
}

/**
 * Shows the user login form
 * after failed attempts to either login or access a page requiring login.
 *
 * @param    boolean $hide_forgotpw_link whether to hide "forgot password?" link
 * @param    int     $userStatus         status of the user's account
 * @param    string  $message            Text message passed by plugin. userStatus needs be set to -2 to display
 * @return   string                      HTML for login form
 */
function USER_loginForm($hide_forgotpw_link = false, $userStatus = -1, $message = '')
{
    global $LANG04;

    $cfg = array(
        'hide_forgotpw_link' => $hide_forgotpw_link,
    );

    $display = '';

    if ($userStatus == USER_ACCOUNT_DISABLED) {
        $cfg['title'] = $LANG04[114];
        $cfg['message'] = $LANG04[115];
        $cfg['hide_forgotpw_link'] = true;
        $cfg['no_newreg_link'] = true;
    } elseif ($userStatus == USER_ACCOUNT_AWAITING_APPROVAL) {
        $cfg['title'] = $LANG04[116];
        $cfg['message'] = $LANG04[117];
        $cfg['hide_forgotpw_link'] = true;
        $cfg['no_newreg_link'] = true;
    } elseif ($userStatus == -2) { // No error user just visited page to login
        $cfg['title'] = $LANG04['user_login'];
        $cfg['message'] = $LANG04['user_login_message'];
        $display = COM_errorLog($message, 2);
    } else { // Status should be -1 which is login error
        $cfg['title'] = $LANG04[65];
        $cfg['message'] = $LANG04[66];
    }

    $display .= SEC_loginForm($cfg);

    return $display;
}

/**
 * Shows the user registration form
 *
 * @param   int $msg message number to show
 * @return  string      HTML for user registration page
 */
function USER_newUserForm($msg = 0)
{
    global $_CONF, $LANG04;

    $retval = '';

    if (!empty($msg)) {
        $retval .= COM_showMessageText($msg, $LANG04[21]);
    }
    $user_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'users'));
    $user_templates->set_file('regform', 'registrationform.thtml');
    $user_templates->set_var('start_block', COM_startBlock($LANG04[22]));
    $user_templates->set_var('lang_instructions', $LANG04[23]);
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('lang_email_conf', $LANG04[124]);
    $user_templates->set_var('lang_warning', $LANG04[24]);
    $user_templates->set_var('lang_register', $LANG04[27]);
	
	// Is Remote Logins Enabled?
    if (($_CONF['user_login_method']['oauth'] || $_CONF['user_login_method']['openid']) && 
	($_CONF['usersubmission'] == 0) && !$_CONF['disable_new_user_registration']) {
		$user_templates->set_var('lang_remote_register_instructions', $LANG04['remote_register_instructions']);
			
	}
	
    PLG_templateSetVars('registration', $user_templates);
    $user_templates->set_var('end_block', COM_endBlock());

    $username = Geeklog\Input::fPost('username', '');
    $user_templates->set_var('username', $username);

    $email = Geeklog\Input::fPost('email', '');
    $user_templates->set_var('email', $email);

    $email_conf = Geeklog\Input::fPost('email_conf', '');
    $user_templates->set_var('email_conf', $email_conf);

    $user_templates->parse('output', 'regform');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
 * Shows the password retrieval form
 *
 * @return string HTML for form used to retrieve user's password
 */
function USER_getPasswordForm()
{
    global $_CONF, $LANG04;

    $retval = '';

    $user_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'users'));
    $user_templates->set_file('form', 'getpasswordform.thtml');
    $user_templates->set_var('start_block_forgetpassword', COM_startBlock($LANG04[25]));
    $user_templates->set_var('lang_instructions', $LANG04[26]);
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('lang_emailpassword', $LANG04[28]);
    PLG_templateSetVars('getpassword', $user_templates);
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->parse('output', 'form');

    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
 * Display message after a login error
 *
 * @param    int    $msg           message number for custom handler
 * @param    string $message_title title for the message box
 * @param    string $message_text  text of the message box
 * @return   void                  function does not return!
 */
function USER_displayLoginErrorAndAbort($msg, $message_title, $message_text)
{
    global $_CONF;

    if ($_CONF['custom_registration'] && function_exists('CUSTOM_loginErrorHandler')) {
        // Typically this will be used if you have a custom main site page
        // and need to control the login process
        CUSTOM_loginErrorHandler($msg);
    } else {
        $retval = COM_showMessageText($message_text, $message_title);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $message_title));

        header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
        header('Status: 403 Forbidden');
        echo $retval;
    }

    // don't return
    exit;
}

/**
 * Re-send a request after successful re-authentication
 * Re-creates a GET or POST request based on data passed along in a form. Used
 * in case of an expired security token so that the user doesn't lose changes.
 */
function USER_resendRequest()
{
    global $_CONF, $LANG_ADMIN;

    $method = Geeklog\Input::fRequest('token_requestmethod', '');
    $returnUrl = Geeklog\Input::fRequest('token_returnurl', '');
    if (!empty($returnUrl)) {
        $returnUrl = urldecode($returnUrl);
        if (substr($returnUrl, 0, strlen($_CONF['site_url'])) !== $_CONF['site_url']) {
            // only accept URLs on our site
            $returnUrl = '';
        }
    }

    $postData = Geeklog\Input::fRequest('token_postdata', '');
    if (!empty($postData)) {
        $postData = urldecode($postData);
    }

    $getData = Geeklog\Input::fRequest('token_getdata', '');
    if (!empty($getData)) {
        $getData = urldecode($getData);
    }

    $files = Geeklog\Input::fRequest('token_files', '');
    if (!empty($files)) {
        $files = urldecode($files);
    }

    if (SECINT_checkToken() && !empty($method) && !empty($returnUrl) &&
        ((($method === 'POST') && !empty($postData)) ||
            (($method === 'GET') && !empty($getData)))
    ) {
        // Close the current session and write any session variables so session file unlocks
        // This allows the seperate HTTP_Request2 to access the same session as it is not locked
        Session::close();

        if ($method === 'POST') {
            $req = new HTTP_Request2($returnUrl, HTTP_Request2::METHOD_POST);

            $data = unserialize($postData);
            foreach ($data as $key => &$value) {
                if ($key == CSRF_TOKEN) {
                    $req->addPostParameter($key, SEC_createToken());
                    $value = SEC_createToken();
                } else {
                    $req->addPostParameter($key, $value);
                }
            }

            if (!empty($files)) {
                $files = unserialize($files);
            }
            if (!empty($files)) {
                foreach ($files as $key => $value) {
                    $req->addPostParameter('_files_' . $key, $value);
                }
            }
        } else { // $method === 'GET'
            // Note: $returnUrl will contain query string as well but setQueryVariables function will overwrite them
            $data = unserialize($getData);

            foreach ($data as $key => &$value) {
                if ($key == CSRF_TOKEN) {
                    $value = SEC_createToken();
                }
            }

            $req = new HTTP_Request2($returnUrl, HTTP_Request2::METHOD_GET);
            $url = $req->getUrl();
            $url->setQueryVariables($data);
        }

        $options = array(
// Let's use Socks (which is the default for HTTP_Request2) so curl is not a required php extension for Geeklog
//            'adapter'           => 'curl',
            'connect_timeout'   => 15,
            'timeout'           => 15,
            'follow_redirects'  => true,
            'max_redirects'     => 1,
        );
        if (stripos($returnUrl, 'https:') === 0) {
            $options['ssl_verify_peer'] = true;

            $hasCaFile = is_readable(@ini_get('openssl.cafile')) ||
                is_dir(@ini_get('openssl.capath'));

            if ($hasCaFile !== true) {
                $options['ssl_cafile'] = $_CONF['path_data'] . 'cacert.pem';
            }
        }
        $req->setConfig($options);

        $req->setHeader('User-Agent', 'Geeklog/' . VERSION);
        // need to fake the referrer so the new token matches
        $req->setHeader('Referer', COM_getCurrentUrl());

        foreach ($_COOKIE as $name => $value) {
            $cookie = $name . '=' . $value;

            if (preg_match(HTTP_Request2::REGEXP_INVALID_COOKIE, $cookie)) {
                COM_errorLog(__FUNCTION__ . " detected invalid cookie: {$cookie}", 1);
            } else {
                $req->addCookie($name, $value);
            }
        }

        try {
            $response = $req->send();
            $status = $response->getStatus();

            if ($status == 200) {
                COM_output($response->getBody());
            } else {
                throw new HTTP_Request2_Exception('HTTP error: status code = ' . $status);
            }
        } catch (HTTP_Request2_Exception $e) {
            if (!empty($files)) {
                SECINT_cleanupFiles($files);
            }

            COM_errorLog(__METHOD__ . ': ' . $e->getMessage());
            COM_setSystemMessage($LANG_ADMIN['token_re_authentication_error']);
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
    } else {
        if (!empty($files)) {
            SECINT_cleanupFiles($files);
        }
        COM_redirect($_CONF['site_url'] . '/index.php');
    }

    // don't return
    exit;
}

/**
 * Return a form for two factor authentication
 *
 * @return string
 */
function USER_getTwoFactorAuthForm()
{
    global $_CONF, $_USER, $LANG04;

    $T = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'users'));
    $T->set_file('form', 'twofactorauthform.thtml');
    $T->set_var(array(
        'start_block'                           => COM_startBlock($LANG04['tfa_two_factor_auth']),
        'lang_tfa_enter_code'                   => sprintf($LANG04['tfa_enter_code'], Geeklog\TwoFactorAuthentication::NUM_DIGITS),
        'lang_tfa_backup_code_msg'              => $LANG04['tfa_backup_code_desc'],
        'lang_tfa_code'                         => $LANG04['tfa_code'],
        'lang_tfa_authenticate'                 => $LANG04['tfa_authenticate'],
        'uid'                                   => $_USER['uid'],
        'token_name'                            => CSRF_TOKEN,
        'token_value'                           => SEC_createToken(),
        'end_block'                             => COM_endBlock(),
    ));
    $T->parse('output', 'form');

    return $T->finish($T->get_var('output'));
}

/**
 * Process after the user is authenticated
 *
 * @note This function does NOT return
 */
function USER_doLogin()
{
    global $_CONF, $_USER, $USER_VERBOSE;

    COM_resetSpeedlimit('login');
    SESS_newSession($_USER['uid'], \Geeklog\IP::getIPAddress());
    PLG_loginUser($_USER['uid']);

    // Issue an auto-login key user cookie and record hash in db if needed
    SESS_issueAutoLogin($_USER['uid']);

    // Now that we have user's data see if their theme cookie is set.
    // If not set it
    if (!empty($_USER['theme'])) {
        SEC_setCookie($_CONF['cookie_theme'], $_USER['theme'], time() + 31536000);
    }

    if (!empty($_SERVER['HTTP_REFERER'])
        && (strstr($_SERVER['HTTP_REFERER'], '/users.php') === false)
        && (substr($_SERVER['HTTP_REFERER'], 0,
                strlen($_CONF['site_url'])) == $_CONF['site_url'])
    ) {
        $indexMsg = $_CONF['site_url'] . '/index.php?msg=';
        if (substr($_SERVER['HTTP_REFERER'], 0, strlen($indexMsg)) == $indexMsg) {
            COM_redirect($_CONF['site_url'] . '/index.php');
        } else {
            // If user is trying to login - force redirect to index.php
            // Some pages will not work though for this so filter out
            if (strstr($_SERVER['HTTP_REFERER'], 'mode=login') === false &&
                strstr($_SERVER['HTTP_REFERER'], '/comment.php') === false // Happens if Comment Editor on own page. Missing info so will 404
                ) {
                COM_redirect($_SERVER['HTTP_REFERER']);
            } else {
                COM_redirect($_CONF['site_url'] . '/index.php');
            }
        }
    }

    COM_redirect($_CONF['site_url'] . '/index.php');
}

/**
 * Process after the user failed to login
 *
 * @param  string $loginName
 * @param  string $password
 * @param  string $service
 * @param  string $mode
 * @param  int    $status
 * @param  string $message
 * @return string
 */
function USER_loginFailed($loginName, $password, $service, $mode, $status, $message = '')
{
    global $_CONF, $LANG04;

    $display = '';

    // On failed login attempt, update speed limit
    if (!empty($loginName) || !empty($password) || !empty($service) || ($mode === 'tokenexpired')) {
        COM_updateSpeedlimit('login');
    }

    $msg = (int) Geeklog\Input::fRequest('msg', 0);
    if ($msg > 0) {
        $display .= COM_showMessage($msg);
    }

    switch ($mode) {
        case 'create':
            // Got bad account info from registration process, show error
            // message and display form again
            if ($_CONF['custom_registration'] && function_exists('CUSTOM_userForm')) {
                $display .= CUSTOM_userForm();
            } else {
                $display .= USER_newUserForm();
            }
            break;

        case 'tokenexpired':
            // check to see if this was the last allowed attempt
            if (COM_checkSpeedlimit('login', $_CONF['login_attempts']) > 0) {
                $files = Geeklog\Input::post('token_files', '');
                if (!empty($files)) {
                    $files = urldecode($files);
                }
                if (!empty($files)) {
                    SECINT_cleanupFiles($files);
                }
                USER_displayLoginErrorAndAbort(82, $LANG04[163], $LANG04[164]);
            } else {
                $returnURL = Geeklog\Input::post('token_returnurl', '');

                if (!empty($returnURL)) {
                    $returnURL = urldecode($returnURL);
                }

                $method = Geeklog\Input::fPost('token_requestmethod', '');

                $postData = Geeklog\Input::post('token_postdata', '');
                if (!empty($postData)) {
                    $postData = urldecode($postData);
                }

                $getData = Geeklog\Input::post('token_getdata', '');
                if (!empty($getData)) {
                    $getData = urldecode($getData);
                }

                $files = Geeklog\Input::post('token_files', '');
                if (!empty($files)) {
                    $files = urldecode($files);
                }
                if (SECINT_checkToken() && !empty($method) &&
                    !empty($returnURL) &&
                    ((($method === 'POST') && !empty($postData)) ||
                        (($method === 'GET') && !empty($getData)))
                ) {
                    $display .= COM_showMessage(81);
                    $display .= SECINT_authform($returnURL, $method, $postData, $getData, $files);
                } else {
                    if (!empty($files)) {
                        SECINT_cleanupFiles($files);
                    }

                    COM_redirect($_CONF['site_url'] . '/index.php');
                }
            }
            break;

        default:
            // check to see if this was the last allowed attempt
            if (COM_checkSpeedlimit('login', $_CONF['login_attempts']) > 0) {
                USER_displayLoginErrorAndAbort(82, $LANG04[113], $LANG04[112]);
            } else {
                // Show login form
                if (($msg != 69) && ($msg != 70)) {
                    if (COM_isAnonUser()) {
                        if ($_CONF['custom_registration'] && function_exists('CUSTOM_loginErrorHandler')) {
                            // Typically this will be used if you have a custom
                            // main site page and need to control the login process
                            $display .= CUSTOM_loginErrorHandler($msg);
                        } else {
                            $display .= USER_loginForm(false, $status, $message);
                        }
                    } else {
                        // user is already logged in
                        $display .= COM_startBlock($LANG04['user_login']);
                        $display .= '<p>' . $LANG04['user_logged_in_message'] . '</p>';
                        $display .= COM_endBlock();
                    }
                }
            }
            break;
    }

    return COM_createHTMLDocument($display);
}

/**
 * Try to authenticate the user against the code given after user name and password is confirmed
 *
 * @return string
 * @throws LogicException
 */
function USER_tryTwoFactorAuth()
{
    global $_CONF, $_USER, $LANG04, $LANG12;

    $retval = '';

    // Is Two Factor Auth enabled?
    if (!isset($_CONF['enable_twofactorauth']) || !$_CONF['enable_twofactorauth']) {
        throw new LogicException(__FUNCTION__ . ': Two Factor Authentication is disabled.');
    }

    // Check security token
    $_USER['uid'] = (int) Geeklog\Input::fPost('uid', 0);
    SEC_checkToken();

    // Check login speed limit
    COM_clearSpeedlimit($_CONF['login_speedlimit'], 'login');
    $last = COM_checkSpeedlimit('login', $_CONF['login_attempts']);

    if ($last > 0) {
        $display = COM_showMessageText(
            sprintf($LANG04[112], $last, $_CONF['passwordspeedlimit']),
            $LANG12[26]
        );
        $retval = COM_createHTMLDocument($display, array('pagetitle' => $LANG12[26]));
    } else {
        $tfaCode = Geeklog\Input::fPost('tfa_code', '');
        $tfa = new Geeklog\TwoFactorAuthentication($_USER['uid']);
        if ($tfa->authenticate($tfaCode)) {
            // Successfully authenticated the user
            USER_doLogin(); // Never return
        } else {
            // Failed to authenticate the user
            COM_updateSpeedlimit('login');
            $content = USER_getTwoFactorAuthForm();
            $retval = COM_createHTMLDocument($content, array('pagetitle' => $LANG04['tfa_two_factor_auth']));
        }
    }

    return $retval;
}

// MAIN
$mode = Geeklog\Input::request('mode', '');
$display = '';

switch ($mode) {
    case 'logout':
        if (!empty($_USER['uid']) && ($_USER['uid'] > 1)) {
            SESS_endCurrentUserSession();
            PLG_logoutUser($_USER['uid']);
        }

        $msg = (int) Geeklog\Input::fGet('msg', 0);
        if ($msg == 0) {
            $msg = 8;
        }

        COM_redirect($_CONF['site_url'] . "/index.php?msg=$msg");
        break;

    case 'profile':
        $uid = (int) Geeklog\Input::fGet('uid', 0);
        if ($uid > 1) {
            $msg = (int) Geeklog\Input::fGet('msg', 0);
            $plugin = '';
            if (($msg > 0) && isset($_GET['plugin'])) {
                $plugin = Geeklog\Input::fGet('plugin');
            }
            $display .= USER_showProfile($uid, false, $msg, $plugin);
        } else {
            // Redirect crawlers and the like to the site's homepage (feature request #520)
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
        break;

    case 'user':
        $username = Geeklog\Input::fGet('username');
        if (!empty($username)) {
            $username = DB_escapeString($username);
            // Remember some database collations are case and accent insensitive and some are not. They would consider "nina", "nina  ", "Nina", and, "niña" as the same
            $uid = DB_getItem($_TABLES['users'], 'uid', "TRIM(LOWER(username)) = TRIM(LOWER('$username'))");
            if ($uid > 1) {
                $display .= USER_showProfile($uid);
            } else {
                COM_redirect($_CONF['site_url'] . '/index.php');
            }
        } else {
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
        break;

    case 'create':
        if ($_CONF['disable_new_user_registration']) {
            $display .= COM_showMessageText($LANG04[122], $LANG04[22]);
            $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[22]));
        } else {
            $userName = Geeklog\Input::fPost('username');
            $email = Geeklog\Input::fPost('email');
            $email_conf = Geeklog\Input::fPost('email_conf');
            $display .= USER_createUser($userName, $email, $email_conf);
        }
        break;

    case 'getpassword':
        if ($_CONF['passwordspeedlimit'] == 0) {
            $_CONF['passwordspeedlimit'] = 300; // 5 minutes
        }
        COM_clearSpeedlimit($_CONF['passwordspeedlimit'], 'password');
        $last = COM_checkSpeedlimit('password', SPEED_LIMIT_MAX_PASSWORD);
        if ($last > 0) {
            $display .= COM_showMessageText(
                sprintf($LANG04[93], $last, $_CONF['passwordspeedlimit']),
                $LANG12[26]
            );
        } else {
            $msg = (int) Geeklog\Input::fRequest('msg', 0);
            if ($msg > 0) {
                $display .= COM_showMessage($msg);
            }
			
			$display .= USER_getPasswordForm();
        }
        $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[25]));
        break;

    case 'newpwd':
        $uid = (int) Geeklog\Input::fGet('uid', 0);
        $reqid = Geeklog\Input::fGet('rid');
        if (!empty($uid) && ($uid > 0) && !empty($reqid) && (strlen($reqid) === 16)) {
            $valid = DB_count($_TABLES['users'], array('uid', 'pwrequestid'), array($uid, $reqid));
            if ($valid == 1) {
                $msg = (int) Geeklog\Input::fGet('msg', 0);
                if ($msg > 0) {
                    $display .= COM_showMessage($msg);
                }
                $display .= USER_newPasswordForm($uid, $reqid);
                $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[92]));
            } else { // request invalid or expired
                $display .= COM_showMessage(54);
                $display .= USER_getPasswordForm();
                $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[25]));
            }
        } else {
            // this request doesn't make sense - ignore it
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
        break;

    case 'setnewpwd':
        $passwd = Geeklog\Input::post('passwd');
        $passwd_conf = Geeklog\Input::post('passwd_conf');

        if ((empty($passwd)) || ($passwd != $passwd_conf)) {
            COM_redirect(
                $_CONF['site_url'] . '/users.php?'
                . http_build_query(array(
                    'mode' => 'newpwd',
                    'uid'  => (int) Geeklog\Input::fPost('uid'),
                    'rid'  => Geeklog\Input::post('rid'),
                    'msg'  => 23
                ))
            );
        } elseif (!SEC_checkPasswordStrength($passwd)) {
            COM_redirect(
                $_CONF['site_url'] . '/users.php?'
                . http_build_query(array(
                    'mode' => 'newpwd',
                    'uid'  => (int) Geeklog\Input::fPost('uid'),
                    'rid'  => Geeklog\Input::post('rid'),
                    'msg'  => 504
                ))
            );
        } else {
            $uid = (int) Geeklog\Input::fPost('uid', 0);
            $reqid = Geeklog\Input::fPost('rid');
            if (!empty($uid) && ($uid > 0) && !empty($reqid) && (strlen($reqid) === 16)) {
                $valid = DB_count($_TABLES['users'], array('uid', 'pwrequestid'), array($uid, $reqid));
                if ($valid == 1) {
                    SEC_updateUserPassword($passwd, $uid);

                    DB_delete($_TABLES['sessions'], 'uid', $uid);
                    DB_query("UPDATE {$_TABLES['users']} SET pwrequestid = NULL WHERE uid = $uid");
                    COM_redirect($_CONF['site_url'] . '/users.php?msg=53');
                } else { // request invalid or expired
                    $display .= COM_showMessage(54);
                    $display .= USER_getPasswordForm();
                    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[25]));
                }
            } else {
                // this request doesn't make sense - ignore it
                COM_redirect($_CONF['site_url'] . '/index.php');
            }
        }
        break;

    case 'newpwdstatus':
        if (!empty($_USER['uid']) && ($_USER['uid'] > 1) && ($_USER['status'] == USER_ACCOUNT_NEW_PASSWORD)) {
            $msg = (int) Geeklog\Input::fRequest('msg', 0);
            if ($msg > 0) {
                $display .= COM_showMessage($msg);
            }

            $display .= USER_newPasswordForm($_USER['uid']);
            $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[92]));
        } else {
            // this request doesn't make sense - ignore it
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
        break;

    case 'setnewpwdstatus':
        $passwd = Geeklog\Input::post('passwd');
        $passwd_conf = Geeklog\Input::post('passwd_conf');

        if (!empty($_USER['uid']) && ($_USER['uid'] > 1) && ($_USER['status'] == USER_ACCOUNT_NEW_PASSWORD)) {
            if ((empty($passwd)) || ($passwd != $passwd_conf)) {
                COM_redirect(
                    $_CONF['site_url'] . '/users.php?'
                    . http_build_query(array(
                        'mode' => 'newpwdstatus',
                        'msg'  => 23
                    ))
                );
            } elseif (!SEC_checkPasswordStrength($passwd)) {
                COM_redirect(
                    $_CONF['site_url'] . '/users.php?'
                    . http_build_query(array(
                        'mode' => 'newpwdstatus',
                        'msg'  => 504
                    ))
                );
            } else {
                SEC_updateUserPassword(Geeklog\Input::post('passwd'), $_USER['uid']);
                DB_change($_TABLES['users'], 'status', USER_ACCOUNT_ACTIVE, 'uid', $uid);
                DB_delete($_TABLES['sessions'], 'uid', $_USER['uid']);
                COM_redirect($_CONF['site_url'] . '/users.php?msg=53');
            }
        } else {
            // this request doesn't make sense - ignore it
            COM_redirect($_CONF['site_url'] . '/index.php');
        }

        break;

    case 'emailpasswd':
        if ($_CONF['passwordspeedlimit'] == 0) {
            $_CONF['passwordspeedlimit'] = 300; // 5 minutes
        }
        COM_clearSpeedlimit($_CONF['passwordspeedlimit'], 'password');
        $last = COM_checkSpeedlimit('password', SPEED_LIMIT_MAX_PASSWORD);
        if ($last > 0) {
            $display .= COM_showMessageText(
                sprintf($LANG04[93], $last, $_CONF['passwordspeedlimit']),
                $LANG12[26]
            );
            $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG12[26]));
        } else {
            $username = Geeklog\Input::fPost('username');
            $email = Geeklog\Input::fPost('email');

            // Let plugins like captcha have a chance to decide what to do before creating the user, return errors.
            $msg = PLG_itemPreSave('getpassword', $username);
            if (!empty($msg)) {
                $display = COM_errorLog($msg, 2);
                $display .= USER_getPasswordForm();
                $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[25]));
            } else {
                if (empty($username) && !empty($email)) {
                    $username = DB_getItem($_TABLES['users'], 'username',
                        "email = '$email' AND ((remoteservice IS NULL) OR (remoteservice = ''))");
                }
                if (!empty($username)) {
                    $display .= USER_requestPassword($username);
                } else {
					// Username for email not found so error out
					COM_updateSpeedlimit('password');
					COM_redirect($_CONF['site_url'] . '/index.php?msg=46');
					//COM_redirect($_CONF['site_url'] . "/users.php?mode=getpassword&msg=46");
                }
            }
        }
        break;

    case 'newemailstatus':
        $uid = (int) Geeklog\Input::fGet('uid', 0);
        $ecid = Geeklog\Input::fGet('ecid');
        if (!empty($uid) && ($uid > 0) && !empty($ecid) && (strlen($ecid) === 16)) {
            $valid = DB_count($_TABLES['users'], array('uid', 'emailconfirmid'), array($uid, $ecid));
            if ($valid == 1) {
                $confirmed_email = DB_getItem($_TABLES['users'], 'emailtoconfirm', "uid = $uid");
                $user_status = DB_getItem($_TABLES['users'], 'status', "uid = $uid");

                DB_delete($_TABLES['sessions'], 'uid', $uid);

                DB_change($_TABLES['users'], 'email', $confirmed_email, 'uid', $uid);
                if ($user_status == USER_ACCOUNT_NEW_EMAIL) {
                    DB_change($_TABLES['users'], 'status', USER_ACCOUNT_ACTIVE, 'uid', $uid);
                }
                DB_query("UPDATE {$_TABLES['users']} SET emailconfirmid = NULL, emailtoconfirm = NULL WHERE uid = $uid");

                COM_redirect($_CONF['site_url'] . '/users.php?msg=503');
            } else {
                // Not valid emailconfirmid
                COM_handle404();
            }
        } elseif (!empty($_USER['uid']) && ($_USER['uid'] > 1) && ($_USER['status'] == USER_ACCOUNT_NEW_EMAIL)) {
            $msg = (int) Geeklog\Input::fRequest('msg', 0);
            if ($msg > 0) {
                $display .= COM_showMessage($msg);
            }

            $display .= USER_newEmailForm();
            $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04['new_email']));
        } else {
            // this request doesn't make sense - ignore it
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
        break;

    case 'setnewemailstatus':
        if (!empty($_USER['uid']) && ($_USER['uid'] > 1) && ($_USER['status'] == USER_ACCOUNT_NEW_EMAIL)) {
            $email = trim(Geeklog\Input::fPost('email'));
            $email_conf = trim(Geeklog\Input::fPost('email_conf'));
            if ($email != $email_conf) {
                COM_redirect($_CONF['site_url'] . '/users.php?mode=newemailstatus&msg=24');
            } elseif (empty($email) || !COM_isEmail($email)) {
                COM_redirect($_CONF['site_url'] . '/users.php?mode=newemailstatus&msg=25');
            } elseif (USER_emailMatches($email, $_CONF['disallow_domains'])) {
                COM_redirect($_CONF['site_url'] . '/users.php?mode=newemailstatus&msg=26');
            } else {
                // Send out confirmation email of new address
                USER_emailConfirmation($email);
            }
        } else {
            // this request doesn't make sense - ignore it
            COM_redirect($_CONF['site_url'] . '/index.php');
        }

        break;

    case 'new':
        if ($_CONF['disable_new_user_registration']) {
            $display .= COM_showMessageText($LANG04[122], $LANG04[22]);
        } else {
            // Call custom registration and account record create function
            // if enabled and exists
            if ($_CONF['custom_registration'] && (function_exists('CUSTOM_userForm'))) {
                $display .= CUSTOM_userForm();
            } else {
                $display .= USER_newUserForm();
            }
        }

        $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[22]));
        break;

    case 'twofactorauth':
        $display = USER_tryTwoFactorAuth();
        break;
    case 'tokenexpired':
        // deliberate fallthrough (see below)
    default: 
        // prevent dictionary attacks on passwords
        COM_clearSpeedlimit($_CONF['login_speedlimit'], 'login');
        if (COM_checkSpeedlimit('login', $_CONF['login_attempts']) > 0) {
            USER_displayLoginErrorAndAbort(82, $LANG12[26], $LANG04[112]);
        }

        $loginname = Geeklog\Input::fPost('loginname', '');
        $passwd = Geeklog\Input::post('passwd', '');
        $service = Geeklog\Input::fPost('service', '');
        $uid = '';
        if (!empty($loginname) && !empty($passwd) && empty($service)) {

            // Let plugins like captcha have a chance to decide what to do before creating the user, return errors.
            $msg = PLG_itemPreSave('loginform', $loginname);
            if (!empty($msg)) {
                $status = -2; // captcha error but no login error so set as normal
                $display .= USER_loginFailed($loginname, $passwd, $service, $mode, $status, $msg);
                break;
            } else {
                if (empty($service) && $_CONF['user_login_method']['standard']) {
                    $status = SEC_authenticate($loginname, $passwd, $uid);
                } else {
                    $status = -1;
                }
            }
        } elseif (($_CONF['usersubmission'] == 0) && $_CONF['user_login_method']['3rdparty'] && ($service != '')) {
            // Distributed Authentication
            // pass $loginname by ref so we can change it ;-)
            $status = SEC_remoteAuthentication($loginname, $passwd, $service, $uid);
        } elseif ($_CONF['user_login_method']['openid'] &&
            ($_CONF['usersubmission'] == 0) &&
            !$_CONF['disable_new_user_registration'] &&
            (Geeklog\Input::get('openid_login') == '1')
        ) {
            // Here we go with the handling of OpenID authentication.
            $query = array_merge($_GET, $_POST);

            if (isset($query['identity_url']) && ($query['identity_url'] != 'http://')) {
                $property = sprintf('%x', crc32($query['identity_url']));
                COM_clearSpeedlimit($_CONF['login_speedlimit'], 'openid');
                if (COM_checkSpeedlimit('openid', $_CONF['login_attempts'], $property) > 0) {
                    USER_displayLoginErrorAndAbort(82, $LANG12[26], $LANG04[112]);
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
                    COM_redirect($_CONF['site_url'] . '/users.php?msg=89');
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
                                      'open_id'      => $identity_url)), // Return to.
                            $_CONF['site_url'], // Trust root.
                            null,
                            "email,nickname,fullname")); // Required fields.
                    exit;
                }
            } elseif (isset($query['openid.mode']) || isset($query['openid_mode'])) {
                $openid_mode = '';
                if (isset($query['openid.mode'])) {
                    $openid_mode = $query['openid.mode'];
                } elseif (isset($query['openid_mode'])) {
                    $openid_mode = $query['openid_mode'];
                }
                if ($openid_mode === 'cancel') {
                    COM_updateSpeedlimit('login');
                    COM_redirect($_CONF['site_url'] . '/users.php?msg=90');
                } else {
                    $openid = $handler->getOpenID();
                    $req = new ConsumerRequest($openid, $query, 'GET');
                    $response = $consumer->handle_response($req);
                    $response->doAction($handler);
                }
            } else {
                COM_updateSpeedlimit('login');
                COM_redirect($_CONF['site_url'] . '/users.php?msg=91');
            }

        } elseif ($_CONF['user_login_method']['oauth'] &&
            ($_CONF['usersubmission'] == 0) &&
            !$_CONF['disable_new_user_registration'] &&
            isset($_GET['oauth_login'])
        ) {
            // Here we go with the handling of OAuth authentication.
			$oauth_login = Geeklog\Input::fGet('oauth_login');
            $modules = SEC_collectRemoteOAuthModules();
            $active_service = (count($modules) == 0) ? false : in_array($oauth_login, $modules);
            if (!$active_service) {
                $status = -1;
                COM_errorLog("OAuth login failed - there was no consumer available for the service:" . $oauth_login, 1);
            } else {
				// Remember these super global variables have not been validated beyond if the oauth login exists and has been enabled
                $query = array_merge($_GET, $_POST);
                $service = $query['oauth_login'];

                COM_clearSpeedlimit($_CONF['login_speedlimit'], $service);
                if (COM_checkSpeedlimit($service, $_CONF['login_attempts']) > 0) {
                    USER_displayLoginErrorAndAbort(82, $LANG12[26], $LANG04[112]);
                }

                require_once $_CONF['path_system'] . 'classes/oauthhelper.class.php';

                $consumer = new OAuthConsumer($service);

                $callback_url = $_CONF['site_url'] . '/users.php?oauth_login=' . $service;

                $consumer->setRedirectURL($callback_url);
                $oauth_userinfo = $consumer->authenticate_user();

                if ($oauth_userinfo === false) {
                    COM_updateSpeedlimit('login');
                    COM_errorLog("OAuth Error: " . $consumer->error, 1);
                    COM_redirect($_CONF['site_url'] . '/users.php?msg=111'); // OAuth authentication error
                }

                if ($consumer->doAction($oauth_userinfo) == null) {
                    COM_errorLog("Oauth: Error creating new user in OAuth authentication", 1);
                    COM_redirect($_CONF['site_url'] . '/users.php?msg=111'); // OAuth authentication error
                }
            }
        } else {
            $status = -2; // User just visited login page no error. -1 = error
        }

        if ($status == USER_ACCOUNT_ACTIVE OR $status == USER_ACCOUNT_NEW_EMAIL OR $status == USER_ACCOUNT_NEW_PASSWORD) { // logged in AOK.
            if ($mode === 'tokenexpired') {
                USER_resendRequest(); // won't come back
            }

            DB_query("UPDATE {$_TABLES['users']} SET pwrequestid = NULL WHERE uid = $uid");
            $_USER = SESS_getUserDataFromId($uid);

            if (isset($_CONF['enable_twofactorauth']) && $_CONF['enable_twofactorauth'] &&
                isset($_USER['twofactorauth_enabled']) && $_USER['twofactorauth_enabled']) {
                $content = USER_getTwoFactorAuthForm();
                $display = COM_createHTMLDocument($content, array('pagetitle' => $LANG04['tfa_two_factor_auth']));
            } else {
                USER_doLogin(); // Never return
            }
        }elseif ($status == USER_ACCOUNT_LOCKED) {
            COM_redirect($_CONF['site_url'] . '/index.php?msg=17');
        } else {
            $display = USER_loginFailed($loginname, $passwd, $service, $mode, $status);
        }
        break;
}

COM_output($display);
