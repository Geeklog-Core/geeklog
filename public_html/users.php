<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | users.php                                                                 |
// |                                                                           |
// | User authentication module.                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
//
// $Id: users.php,v 1.85 2004/08/15 12:06:07 dhaun Exp $

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
require_once ('lib-common.php');
require_once ($_CONF['path_system'] . 'lib-user.php');

$VERBOSE = false;

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

// echo COM_debug($HTTP_POST_VARS);

/**
* Shows a profile for a user
*
* This grabs the user profile for a given user and displays it
*
* @param    int     $user   User ID of profile to get
* @param    int     $msg    Message to display (if != 0)
* @return   string          HTML for user profile page
*
*/
function userprofile ($user, $msg) 
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG04, $LANG_LOGIN;

    if (empty ($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['profileloginrequired'] == 1))) {
        $retval .= COM_startBlock ($LANG_LOGIN[1], '',
                           COM_getBlockTemplate ('_msg_block', 'header'));
        $login = new Template($_CONF['path_layout'] . 'submit');
        $login->set_file (array ('login'=>'submitloginrequired.thtml'));
        $login->set_var ('login_message', $LANG_LOGIN[2]);
        $login->set_var ('site_url', $_CONF['site_url']);
        $login->set_var ('lang_login', $LANG_LOGIN[3]);
        $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
        $login->parse ('output', 'login');
        $retval .= $login->finish ($login->get_var('output'));
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
 
        return $retval;
    }

    $retval = '';

    $result = DB_query("SELECT username,fullname,regdate,homepage,about,pgpkey,photo FROM {$_TABLES['userinfo']},{$_TABLES["users"]} WHERE {$_TABLES['userinfo']}.uid = {$_TABLES['users']}.uid AND {$_TABLES['users']}.uid = $user");
    $nrows = DB_numRows($result);
    if ($nrows == 0) { // no such user
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }
    $A = DB_fetchArray($result);

    $retval .= COM_siteHeader ('menu', $LANG04[1] . ' ' . $A['username']);
    if ($msg > 0) {
        $retval .= COM_showMessage ($msg);
    }

    // format date/time to user preference
    $curtime = COM_getUserDateTimeFormat($A["regdate"]);
    $A['regdate'] = $curtime[0];

    $user_templates = new Template($_CONF['path_layout'] . 'users');
    $user_templates->set_file(array('profile'=>'profile.thtml','row'=>'commentrow.thtml','strow'=>'storyrow.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('start_block_userprofile', COM_startBlock($LANG04[1] . ' ' . $A['username']));
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('username', $A['username']);
    if (!empty($A['photo']) AND $_CONF['allow_user_photo'] == 1) {
        if (strstr ($_CONF['path_images'], $_CONF['path_html'])) {
            $imgpath = substr ($_CONF['path_images'],
                               strlen ($_CONF['path_html']));
            $user_templates->set_var ('user_photo', '<img src="'
                . $_CONF['site_url'] . '/' . $imgpath . 'userphotos/'
                . $A['photo'] . '" alt="">');
        } else {
            $user_templates->set_var ('user_photo', '<img src="' . $_CONF['site_url'] . '/getimage.php?mode=userphotos&amp;image=' . $A['photo'] . '" alt="">');
        }
    } else {
        $user_templates->set_var('user_photo','');
    }
    $user_templates->set_var('user_fullname', $A['fullname']);
    $user_templates->set_var('lang_membersince', $LANG04[67]);
    $user_templates->set_var('user_regdate', $A['regdate']);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('user_id', $user);
    $user_templates->set_var('lang_sendemail', $LANG04[81]);
    $user_templates->set_var('lang_homepage', $LANG04[6]);
    $user_templates->set_var('user_homepage', COM_killJS ($A['homepage']));
    $user_templates->set_var('lang_bio', $LANG04[7]);
    $user_templates->set_var('user_bio', nl2br(stripslashes($A['about']))); 
    $user_templates->set_var('lang_pgpkey', $LANG04[8]);
    $user_templates->set_var('user_pgp', nl2br($A['pgpkey']));
    $user_templates->set_var('start_block_last10stories',
            COM_startBlock($LANG04[82] . ' ' . $A['username']));
    $user_templates->set_var('start_block_last10comments',
            COM_startBlock($LANG04[10] . ' ' . $A['username']));
    $user_templates->set_var('start_block_postingstats',
            COM_startBlock($LANG04[83] . ' ' . $A['username']));
    // for alternative layouts: use these as headlines instead of block titles
    $user_templates->set_var('headline_last10stories', $LANG04[82]);
    $user_templates->set_var('headline_last10comments', $LANG04[10]);
    $user_templates->set_var('headline_postingstats', $LANG04[83]);

    $result = DB_query ("SELECT tid FROM {$_TABLES['topics']}"
            . COM_getPermSQL ());
    $nrows = DB_numRows ($result);
    $tids = array ();
    for ($i = 0; $i < $nrows; $i++) {
        $T = DB_fetchArray ($result);
        $tids[] = $T['tid'];
    }
    $topics = "'" . implode ("','", $tids) . "'";

    // list of last 10 stories by this user
    if (sizeof ($tids) > 0) {
        $sql = "SELECT sid,title,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['stories']} WHERE (uid = $user) AND (draft_flag = 0) AND (date <= NOW()) AND (tid IN ($topics))" . COM_getPermSQL ('AND');
        $sql .= " ORDER BY unixdate DESC LIMIT 10";
        $result = DB_query($sql);
        $nrows = DB_numRows($result);
    } else {
        $nrows = 0;
    }
    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $C = DB_fetchArray($result);
            $user_templates->set_var('row_number', $i . '.');
            $user_templates->set_var('story_begin_href', '<a href="' .
                $_CONF['site_url'] . '/article.php?story=' . $C['sid'] . '">');
            $C['title'] = str_replace('$','&#36;',$C['title']);
            $user_templates->set_var('story_title', stripslashes($C['title']));
            $user_templates->set_var('story_end_href', '</a>');
            $storytime = COM_getUserDateTimeFormat($C['unixdate']);
            $user_templates->set_var('story_date', $storytime[0]);
            $user_templates->parse('story_row','strow',true);
        }
    } else {
        $user_templates->set_var('story_row','<tr><td>' . $LANG01[37] . '</td></tr>');
    }

    // list of last 10 comments by this user
    $sidArray = array();
    if (sizeof ($tids) > 0) {
        // first, get a list of all stories the current visitor has access to
        $sql = "SELECT sid FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) AND (tid IN ($topics))" . COM_getPermSQL ('AND');
        $result = DB_query($sql);
        $numsids = DB_numRows($result);
        for ($i = 1; $i <= $numsids; $i++) {
            $S = DB_fetchArray ($result);
            $sidArray[] = $S['sid'];
        }
    }

    // add all polls the current visitor has access to
    $sql = "SELECT qid FROM {$_TABLES['pollquestions']}" . COM_getPermSQL ();
    $result = DB_query($sql);
    $numqids = DB_numRows($result);

    for ($i = 1; $i <= $numqids; $i++) {
        $Q = DB_fetchArray ($result);
        $sidArray[] = $Q['qid'];
    }

    $sidList = implode("', '",$sidArray);
    $sidList = "'$sidList'";

    // then, find all comments by the user in those stories and polls
    $sql = "SELECT sid,title,pid,type,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['comments']} WHERE (uid = $user)";

    // SQL NOTE:  Using a HAVING clause is usually faster than a where if the
    // field is part of the select
    // if (!empty ($sidList)) {
    //     $sql .= " AND (sid in ($sidList))";
    // }
    if (!empty ($sidList)) {
        $sql .= " HAVING sid in ($sidList)";
    }
    $sql .= " ORDER BY unixdate DESC LIMIT 10";

    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $C = DB_fetchArray($result);
            $user_templates->set_var('row_number', $i . '.');
            if ($C['type'] == 'article') {
                $user_templates->set_var('comment_begin_href',
                    '<a href="' . $_CONF['site_url'] .
                    '/comment.php?mode=display&amp;sid=' . $C['sid'] .
                    '&amp;type=' . $C['type'] . '&amp;title=' .
                    urlencode($C['title']) . '&amp;pid=' .  $C['pid'] . '">');
            } else {
                $user_templates->set_var('comment_begin_href',
                    '<a href="' . $_CONF['site_url'] .
                    '/comment.php?mode=display&amp;sid=' . $C['sid'] .
                    '&amp;type=' . $C['type'] . '&amp;title=' .
                    urlencode($C['title']) . '&amp;pid=' .  $C['pid'] .
                    '&amp;qid=' . $C['sid'] . '">');
            }
            $C['title'] = str_replace('$','&#36;',$C['title']);
            $user_templates->set_var('comment_title', stripslashes($C['title']));
            $user_templates->set_var('comment_end_href', '</a>');
            $commenttime = COM_getUserDateTimeFormat($C['unixdate']);
            $user_templates->set_var('comment_date', $commenttime[0]); 
            $user_templates->parse('comment_row','row',true);
        }
    } else {
        $user_templates->set_var('comment_row','<tr><td>' . $LANG01[29] . '</td></tr>');
    }

    // posting stats for this user
    $user_templates->set_var ('lang_number_stories', $LANG04[84]);
    $sql = "SELECT count(*) AS count FROM {$_TABLES['stories']} WHERE (uid = $user) AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND');
    $result = DB_query($sql);
    $N = DB_fetchArray ($result);
    $user_templates->set_var('number_stories', $N['count']);
    $user_templates->set_var ('lang_number_comments', $LANG04[85]);
    $sql = "SELECT count(*) AS count FROM {$_TABLES['comments']} WHERE (uid = $user)";
    if (!empty ($sidList)) {
        $sql .= " AND (sid in ($sidList))";
    }
    $result = DB_query($sql);
    $N = DB_fetchArray ($result);
    $user_templates->set_var('number_comments', $N['count']);
    $user_templates->set_var ('lang_all_postings_by', $LANG04[86] . ' ' . $A['username']);

    // Call custom registration function if enabled and exists
    if ($_CONF['custom_registration'] AND (function_exists(custom_userdisplay)) ) {
        $user_templates->set_var ('customfields', custom_userdisplay($user) );
    }
    PLG_profileVariablesDisplay ($user, $user_templates);

    $user_templates->parse('output', 'profile');
    $retval .= $user_templates->finish($user_templates->get_var('output'));	

    $retval .= PLG_profileBlocksDisplay ($user);
    $retval .= COM_siteFooter ();

    return $retval;
}

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
function emailpassword($username,$msg=0) 
{
    global $_CONF, $_TABLES, $LANG04;

    $result = DB_query("SELECT email,passwd FROM {$_TABLES['users']} WHERE username = '$username'");
    $nrows = DB_numRows($result);
    if ($nrows == 1) {
        $A = DB_fetchArray($result);
        if (($_CONF['usersubmission'] == 1) && ($A['passwd'] == md5(''))) {
            return COM_refresh ($_CONF['site_url'] . '/index.php?msg=48');
        }

        USER_createAndSendPassword ($username, $A['email']);

        if ($msg) {
            $retval .= COM_refresh("{$_CONF['site_url']}/index.php?msg=$msg");
        } else {
            $retval .= COM_refresh("{$_CONF['site_url']}/index.php");
        }
    } else {
        $retval .= COM_siteHeader('menu') . defaultform($LANG04[17]) . COM_siteFooter();
    }

    return $retval;
}

/**
* User request for a new password - send email with a link and request id
*
* @param username string   name of user who requested the new password
* @param msg      int      index of message to display (if any)
* @return         string   form or meta redirect
*
*/
function requestpassword ($username, $msg = 0)
{
    global $_CONF, $_TABLES, $LANG04;

    $result = DB_query ("SELECT uid,email,passwd FROM {$_TABLES['users']} WHERE username = '$username'");
    $nrows = DB_numRows ($result);
    if ($nrows == 1) {
        $A = DB_fetchArray ($result);
        if (($_CONF['usersubmission'] == 1) && ($A['passwd'] == md5 (''))) {
            return COM_refresh ($_CONF['site_url'] . '/index.php?msg=48');
        }
        $reqid = substr (md5 (uniqid (rand (), 1)), 1, 16);
        DB_change ($_TABLES['users'], 'pwrequestid', "$reqid",
                   'username', $username);

        $mailtext = sprintf ($LANG04[88], $username);
        $mailtext .= $_CONF['site_url'] . '/users.php?mode=newpwd&uid=' . $A['uid'] . '&rid=' . $reqid . "\n\n";
        $mailtext .= $LANG04[89];
        $mailtext .= "{$_CONF["site_name"]}\n";
        $mailtext .= "{$_CONF['site_url']}\n";

        $subject = $_CONF['site_name'] . ': ' . $LANG04[16];
        COM_mail ($A['email'], $subject, $mailtext);

        if ($msg) {
            $retval .= COM_refresh ($_CONF['site_url'] . "/index.php?msg=$msg");
        } else {
            $retval .= COM_refresh ($_CONF['site_url'] . '/index.php');
        }
        COM_updateSpeedlimit ('password');
    } else {
        $retval .= COM_siteHeader ('menu')
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
    $pwform->set_var ('site_url', $_CONF['site_url']);
    $pwform->set_var ('layout_url', $_CONF['layout_url']);

    $pwform->set_var ('user_id', $uid);
    $pwform->set_var ('user_name', DB_getItem ($_TABLES['users'], 'username',
                                               "uid = '{$uid}'"));
    $pwform->set_var ('request_id', $requestid);

    $pwform->set_var ('lang_explain', $LANG04[90]);
    $pwform->set_var ('lang_username', $LANG04[2]);
    $pwform->set_var ('lang_newpassword', $LANG04[4]);
    $pwform->set_var ('lang_setnewpwd', $LANG04[91]);

    $retval = COM_startBlock ($LANG04[92]);
    $retval .= $pwform->finish ($pwform->parse ('output', 'newpw'));
    $retval .= COM_endBlock ();

    return $retval;
}

/**
* Send an email notification when a new user registers with the site.
*
* @param username string      User name of the new user
* @param email    string      Email address of the new user
* @param uid      int         User id of the new user
* @param queued   bool        true = user was added to user submission queue
*
*/
function sendNotification ($username, $email, $uid, $queued = false)
{
    global $_CONF, $_TABLES, $LANG01, $LANG04, $LANG08, $LANG28, $LANG29;

    $mailbody = "$LANG04[2]: $username\n"
              . "$LANG04[5]: $email\n"
              . "$LANG28[14]: " . strftime ($_CONF['date']) . "\n\n";
    if ($queued) {
        $mailbody .= "$LANG01[10] <{$_CONF['site_admin_url']}/moderation.php>\n\n";
    } else {
        $mailbody .= "$LANG29[4] <{$_CONF['site_url']}/users.php?mode=profile&uid={$uid}>\n\n";
    }
    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[40];
    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
* Creates a user
*
* Creates a user with the give username and email address
*
* @param    string      $username       username to create user for
* @param    string      $email          email address to assign to user
* @return   string      HTML for the form again if error occurs, otherwise nothing.
*
*/
function createuser($username,$email) 
{
    global $_CONF, $_TABLES, $LANG01, $LANG04;

    $username = trim ($username);

    if (COM_isEmail ($email) && !empty ($username)) {

        $ucount = DB_count($_TABLES['users'],'username',$username);
        $ecount = DB_count($_TABLES['users'],'email',$email);

        if ($ucount == 0 AND $ecount == 0) {
            $regdate = strftime('%Y-%m-%d %H:%M:$S',time());
            DB_save($_TABLES['users'],'username,email,regdate,cookietimeout',"'$username','$email','$regdate','{$_CONF['default_perm_cookie_timeout']}'");
            $uid = DB_getItem($_TABLES['users'],'uid',"username = '$username'");

            // Add user to Logged-in group (i.e. members) and the All Users
            // group (which includes anonymous users
            $normal_grp = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='Logged-in Users'");
            $all_grp = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='All Users'");
            DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) values ($normal_grp, $uid)");
            DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) values ($all_grp, $uid)");
            DB_query("INSERT INTO {$_TABLES['userprefs']} (uid) VALUES ($uid)");
            if ($_CONF['emailstoriesperdefault'] == 1) {
                DB_query("INSERT INTO {$_TABLES['userindex']} (uid) VALUES ($uid)");
            } else {
                DB_query("INSERT INTO {$_TABLES['userindex']} (uid,etids) VALUES ($uid, '-')");
            }
            DB_query("INSERT INTO {$_TABLES['usercomment']} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES['userinfo']} (uid) VALUES ($uid)");
            if ($_CONF['usersubmission'] == 1) {
                $queueUser = true;
                if (!empty ($_CONF['allow_domains'])) {
                    $allowed = explode (',', $_CONF['allow_domains']);
                    // Note: We already made sure $email is a valid address
                    $domain = substr ($email, strpos ($email, '@') + 1);
                    if (in_array ($domain, $allowed)) {
                        $queueUser = false;
                    }
                }
                if ($queueUser) {
                    $passwd = md5('');
                    DB_change($_TABLES['users'],'passwd',"$passwd",'username',$username);
                    $msg = 48;
                } else {
                    emailpassword($username, 1);
                    $msg = 1;
                }
                if (isset ($_CONF['notification']) && in_array ('user', $_CONF['notification'])) {
                    sendNotification ($username, $email, $uid, $queueUser);
                }
            } else {
                emailpassword($username, 1);
                $msg = 1;
                if (isset ($_CONF['notification']) && in_array ('user', $_CONF['notification'])) {
                    sendNotification ($username, $email, $uid, false);
                }
            }
            DB_change($_TABLES['usercomment'],'commentmode',$_CONF['comment_mode'],'uid',$uid);
            DB_change($_TABLES['usercomment'],'commentlimit',$_CONF['comment_limit'],'uid',$uid); 

            // Call custom registration and account record create function
            // if enabled and exists
  	        if ($_CONF['custom_registration'] AND (function_exists(custom_usercreate))) {
                custom_usercreate($uid);
            }

            PLG_createUser ($uid);

            return COM_refresh($_CONF['site_url'] . '/index.php?msg=' . $msg);
        } else {
            $retval .= COM_siteHeader ('Menu');
            if ($_CONF['custom_registration'] AND (function_exists(custom_userform))) {
                $retval .= custom_userform ($LANG04[19]);
            } else {
                $retval .= newuserform ($LANG04[19]);
            }
            $retval .= COM_siteFooter ();
        }
    } else {
        if (empty ($username)) {
            $msg = $LANG01[32]; // invalid username
        } else {
            $msg = $LANG04[18]; // invalid email address
        }
        $retval .= COM_siteHeader ('menu');
        if ($_CONF['custom_registration'] && function_exists(custom_userform)) {
            $retval .= custom_userform ($msg);
        } else {
            $retval .= newuserform ($msg);
        }
        $retval .= COM_siteFooter();
    }

    return $retval;
}

/**
* Shows the user login form after failed attempts to either login or access a page
* requiring login. 
*
* @return   string      HTML for login form
*
*/
function loginform ($hide_forgotpw_link = false)
{
    global $_CONF, $LANG04;

    $retval = '';

    $user_templates = new Template ($_CONF['path_layout'] . 'users');
    $user_templates->set_file('login', 'loginform.thtml');
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('start_block_loginagain', COM_startBlock($LANG04[65]));
    $user_templates->set_var('lang_message', $LANG04[66]);
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('lang_password', $LANG04[4]);
    if ($hide_forgotpw_link) {
        $user_templates->set_var('lang_forgetpassword', '');
    } else {
        $user_templates->set_var('lang_forgetpassword', $LANG04[25]);
    }
    $user_templates->set_var('lang_login', $LANG04[80]);
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->parse('output', 'login');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
* Shows the user registration form
*
* @param    int     $msg        message number to show
* @param    string  $referrer   page to send user to after registration
* @return   string  HTML for user registration page
*/
function newuserform($msg = '')
{
    global $LANG04, $_CONF;

    $retval = '';
    
    if (!empty ($msg)) {
        $retval .= COM_startBlock ($LANG04[21], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
                . $msg
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }
    $user_templates = new Template($_CONF['path_layout'] . 'users');
    $user_templates->set_file('regform','registrationform.thtml');
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('start_block', COM_startBlock($LANG04[22]));
    $user_templates->set_var('lang_instructions', $LANG04[23]);
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('lang_warning', $LANG04[24]);
    $user_templates->set_var('lang_register', $LANG04[27]);
    $user_templates->set_var('end_block', COM_endBlock());
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
    $user_templates->set_var('site_url', $_CONF['site_url']);
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
* Shows user their account info form
*
* @param    string  $msg        message to display if one is needed
* @return   string  HTML for form
*
*/
function defaultform ($msg)
{
    global $LANG04;

    $retval = '';

    if (!empty ($msg)) {
        $retval .= COM_startBlock ($LANG04[21], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
                . $msg
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    $retval .= loginform (true);

    $retval .= newuserform ();

    $retval .= getpasswordform ();

    return $retval;
}


// MAIN
if (isset ($HTTP_POST_VARS['mode'])) {
    $mode = $HTTP_POST_VARS['mode'];
}
elseif (isset ($HTTP_GET_VARS['mode'])) {
    $mode = $HTTP_GET_VARS['mode'];
}
else {
    $mode = "";
}

$display = '';

switch ($mode) {
case 'logout':
    if (!empty($_USER['uid']) AND $_USER['uid'] > 1) {
        SESS_endUserSession($_USER['uid']);
    }
    setcookie ($_CONF['cookie_session'], '', time() - 10000,
               $_CONF['cookie_path'], $_CONF['cookiedomain'],
               $_CONF['cookiesecure']);
    setcookie ($_CONF['cookie_name'], '', time() - 10000, $_CONF['cookie_path'],
               $_CONF['cookiedomain'], $_CONF['cookiesecure']);
    $display = COM_refresh($_CONF['site_url'] . '/index.php?msg=8');
    break;

case 'profile':
    $uid = COM_applyFilter ($HTTP_GET_VARS['uid'], true);
    if (is_numeric ($uid) && ($uid > 0)) {
        $msg = COM_applyFilter ($HTTP_GET_VARS['msg'], true);
        $display .= userprofile ($uid, $msg);
    } else {
        $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
    }
    break;

case 'create':
    $display .= createuser (COM_applyFilter ($HTTP_POST_VARS['username']),
                            COM_applyFilter ($HTTP_POST_VARS['email']));
    break;

case 'getpassword':
    $display .= COM_siteHeader ('menu');
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
    $uid = COM_applyFilter ($HTTP_GET_VARS['uid'], true);
    $reqid = COM_applyFilter ($HTTP_GET_VARS['rid']);
    if (!empty ($uid) && is_numeric ($uid) && ($uid > 0) &&
            !empty ($reqid) && (strlen ($reqid) == 16)) {
        $valid = DB_count ($_TABLES['users'], array ('uid', 'pwrequestid'),
                           array ($uid, $reqid));
        if ($valid == 1) {
            $display .= COM_siteHeader ('menu');
            $display .= newpasswordform ($uid, $reqid);
            $display .= COM_siteFooter ();
        } else { // request invalid or expired
            $display .= COM_siteHeader ('menu');
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
    if (empty ($HTTP_POST_VARS['passwd'])) {
        $display = COM_refresh ($_CONF['site_url']
                 . '/users.php?mode=newpwd&uid=' . $HTTP_POST_VARS['uid']
                 . '&rid=' . $HTTP_POST_VARS['rid']);
    } else {
        $uid = COM_applyFilter ($HTTP_POST_VARS['uid'], true);
        $reqid = COM_applyFilter ($HTTP_POST_VARS['rid']);
        if (!empty ($uid) && is_numeric ($uid) && ($uid > 0) &&
                !empty ($reqid) && (strlen ($reqid) == 16)) {
            $valid = DB_count ($_TABLES['users'], array ('uid', 'pwrequestid'),
                               array ($uid, $reqid));
            if ($valid == 1) {
                $passwd = md5 ($HTTP_POST_VARS['passwd']);
                DB_change ($_TABLES['users'], 'passwd', "$passwd",
                           "uid", $uid);
                DB_delete ($_TABLES['sessions'], 'uid', $uid);
                DB_change ($_TABLES['users'], 'pwrequestid', "NULL",
                           'username', $username);
                $display = COM_refresh ($_CONF['site_url'] . '/users.php?msg=53');
            } else { // request invalid or expired
                $display .= COM_siteHeader ('menu');
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
        $display .= COM_siteHeader ('menu')
                 . COM_startBlock ($LANG12[26], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
                 . sprintf ($LANG04[93], $last, $_CONF['passwordspeedlimit'])
                 . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                 . COM_siteFooter ();
    } else {
        $username = COM_applyFilter ($HTTP_POST_VARS['username']);
        $email = COM_applyFilter ($HTTP_POST_VARS['email']);
        if (empty ($username) && !empty ($email)) {
            $username = DB_getItem ($_TABLES['users'], 'username',
                                    "email = '$email'");
        }
        if (!empty ($username)) {
            $display .= requestpassword ($username, 55);
        } else {
            $display = COM_refresh ($_CONF['site_url']
                                    . '/users.php?mode=getpassword');
        }
    }
    break;

case 'new':
    $display .= COM_siteHeader('menu');
    // Call custom registration and account record create function
    // if enabled and exists
    if ($_CONF['custom_registration'] AND (function_exists('custom_userform'))) {
        $display .= custom_userform('new');
    } else {
        $display .= newuserform();
    }	
    $display .= COM_siteFooter();
    break;

default:
    if (isset ($HTTP_POST_VARS['loginname'])) {
        $loginname = COM_applyFilter ($HTTP_POST_VARS['loginname']);
    } else {
        $loginname = COM_applyFilter ($HTTP_GET_VARS['loginname']);
    }
    if (isset ($HTTP_POST_VARS['passwd'])) {
        $passwd = COM_applyFilter ($HTTP_POST_VARS['passwd']);
    }
    if (!empty($loginname) && !empty($passwd)) {
        $mypasswd = COM_getPassword($loginname);
    } else {
        srand((double)microtime()*1000000);
        $mypasswd = rand();
    }
    if (!empty ($passwd) && !empty ($mypasswd) && ($mypasswd == md5($passwd))) {
        DB_change($_TABLES['users'],'pwrequestid',"NULL",'username',$loginname);
        $userdata = SESS_getUserData($loginname);
        $_USER=$userdata;
        $sessid = SESS_newSession($_USER['uid'], $HTTP_SERVER_VARS['REMOTE_ADDR'], $_CONF['session_cookie_timeout'], $_CONF['cookie_ip']);
        SESS_setSessionCookie($sessid, $_CONF['session_cookie_timeout'], $_CONF['cookie_session'], $_CONF['cookie_path'], $_CONF['cookiedomain'], $_CONF['cookiesecure']);

        // Now that we handled session cookies, handle longterm cookie
        if (!isset($HTTP_COOKIE_VARS[$_CONF['cookie_name']]) || !isset($HTTP_COOKIE_VARS['password'])) {
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
                setcookie ($_CONF['cookie_name'], $_USER['uid'],
                           time() + $cooktime, $_CONF['cookie_path'],
                           $_CONF['cookiedomain'], $_CONF['cookiesecure']);
                setcookie ($_CONF['cookie_password'], md5 ($passwd),
                           time() + $cooktime, $_CONF['cookie_path'],
                           $_CONF['cookiedomain'], $_CONF['cookiesecure']);
            }
        } else {
            $userid = $HTTP_COOKIE_VARS[$_CONF['cookie_name']];
            if (empty ($userid) || ($userid == 'deleted')) {
                unset ($userid);
            } else {
                if ($VERBOSE) {
                    COM_errorLog('NOW trying to set permanent cookie',1);
                    COM_errorLog('Got '.$userid.' from perm cookie in users.php',1);
                }
                if ($userid) {
                    $user_logged_in = 1;
                    // Create new session
                    $userdata = SESS_getUserDataFromId($userid);
                    $_USER = $userdata;
                    if ($VERBOSE) {
                        COM_errorLog('Got '.$_USER['username'].' for the username in user.php',1);
                    }
                }
            }
        }

        // Now that we have users data see if their theme cookie is set.
        // If not set it
        setcookie ($_CONF['cookie_theme'], $_USER['theme'], time() + 31536000,
                   $_CONF['cookie_path'], $_CONF['cookiedomain'],
                   $_CONF['cookiesecure']);

        if (($HTTP_REFERER) && (strstr ($HTTP_REFERER, '/users.php') === false)) {
            $indexMsg = $_CONF['site_url'] . '/index.php?msg=';
            if (substr ($HTTP_REFERER, 0, strlen ($indexMsg)) == $indexMsg) {
                $display .= COM_refresh($_CONF['site_url'] . '/index.php');
            } else {
                $display .= COM_refresh($HTTP_REFERER);
            }
        } else {
            $display .= COM_refresh($_CONF['site_url'] . '/index.php');
        }
    } else {
        $display .= COM_siteHeader('menu');

        if (isset ($HTTP_POST_VARS['msg'])) {
            $msg = $HTTP_POST_VARS['msg'];
        } else if (isset ($HTTP_GET_VARS['msg'])) {
            $msg = $HTTP_GET_VARS['msg'];
        } else {
            $msg = 0;
        }
        if ($msg > 0) {
            $display .= COM_showMessage($msg);
        }

        switch ($mode) {
        case 'create':
            // Got bad account info from registration process, show error
            // message and display form again
            if ($_CONF['custom_registration'] AND (function_exists(custom_userform))) {
                $display .= custom_userform ('new');
            } else {
                $display .= newuserform ();
            }
            break;
        default:
            // Show login form
            $display .= loginform();
            break;
        }

        $display .= COM_siteFooter();
    }
    break;
}

echo $display;

?>
