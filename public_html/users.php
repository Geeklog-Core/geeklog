<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | users.php                                                                 |
// | User authentication module.                                               |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
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
// $Id: users.php,v 1.21 2002/03/09 19:36:57 dhaun Exp $

include_once('lib-common.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

#debug($HTTP_POST_VARS);

/**
* Shows a profile for a user
*
* This grabs the user profile for a given user and displays it
*
* @user		int	User ID of profile to get
*
*/
function userprofile($user) 
{
    global $_TABLES, $_CONF, $LANG04;

    $retval .= '';
	
    $result = DB_query("SELECT username,fullname,regdate,homepage,about,pgpkey FROM {$_TABLES['userinfo']},{$_TABLES["users"]} WHERE {$_TABLES['userinfo']}.uid = {$_TABLES['users']}.uid AND {$_TABLES['users']}.uid = $user");
    $A = DB_fetchArray($result);

    // format date/time to user preference
    $curtime = COM_getUserDateTimeFormat($A["regdate"]);
    $A['regdate'] = $curtime[0];

    $user_templates = new Template($_CONF['path_layout'] . 'users');
    $user_templates->set_file(array('profile'=>'profile.thtml','row'=>'commentrow.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('start_block_userprofile', COM_startBlock($LANG04[1] . ' ' . $A['username']));
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('username', $A['username']);
    $user_templates->set_var('user_fullname', $A['fullname']);
	$user_templates->set_var('lang_membersince', $LANG04[67]);
    $user_templates->set_var('user_regdate', $A['regdate']);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('user_id', $user);
    $user_templates->set_var('lang_sendemail', 'Send Email');
    $user_templates->set_var('lang_homepage', $LANG04[6]);
    $user_templates->set_var('user_homepage', $A['homepage']);
    $user_templates->set_var('lang_bio', $LANG04[7]);
    $user_templates->set_var('user_bio', nl2br(stripslashes($A['about']))); 
    $user_templates->set_var('lang_pgpkey', $LANG04[8]);
    $user_templates->set_var('user_pgp', nl2br($A['pgpkey']));
    $user_templates->set_var('start_block_last10comments', COM_startBlock($LANG04[10] . ' ' . $A['username']));
    $result = DB_query("SELECT sid,title,pid,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['comments']} WHERE uid = $user ORDER BY unixdate desc LIMIT 10");
    $nrows = DB_numRows($result);

    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $C = DB_fetchArray($result);
            $user_templates->set_var('row_number', $i . '.');
            $user_templates->set_var('comment_begin_href', '<a href="' .$_CONF['site_url'] 
                . '/comment.php?mode=display&amp;sid=' . $C['sid'] . '&amp;title=' . urlencode($C['title']) 
                . '&amp;pid=' . $C['pid'] . '">');
            $user_templates->set_var('comment_title', stripslashes($C['title']));
            $user_templates->set_var('comment_end_href', '</a>');
            $commenttime = COM_getUserDateTimeFormat($C['unixdate']);
            $user_templates->set_var('comment_date', $commenttime[0]); 
            $user_templates->parse('comment_row','row',true);
        }
    } else {
        $user_templates->set_var('comment_row','<tr><td>No user comments</td></tr>');
    }

	$user_templates->parse('output', 'profile');
    $retval .= $user_templates->finish($user_templates->get_var('output'));	

    return $retval;
}

/**
* Emails password to a user
*
* This will email the given user their password.
*
* @username     string      Username for which to get and email password
* @msg          int         Message number of message to show when done
*
*/
function emailpassword($username,$msg=0) 
{
    global $_TABLES, $_CONF, $LANG04;
	
    $result = DB_query("SELECT email FROM {$_TABLES['users']} WHERE username = '$username'");
    $nrows = DB_numRows($result);
    if ($nrows == 1) {
        srand((double)microtime()*1000000);
        $passwd = rand();
        $passwd = md5($passwd);
        $passwd = substr($passwd,1,8);
        $passwd2 = md5($passwd);
        DB_change($_TABLES['users'],'passwd',"$passwd2",'username',$username);
        $A = DB_fetchArray($result);
        $mailtext = "{$LANG04[15]}\n\n";
        $mailtext .= "{$LANG04[2]}: $username\n";
        $mailtext .= "{$LANG04[4]}: $passwd\n\n";
        $mailtext .= "{$LANG04[14]}\n\n";
        $mailtext .= "{$_CONF["site_name"]}\n";
        $mailtext .= "{$_CONF['site_url']}\n";
        mail($A["email"]
            ,"{$_CONF["site_name"]}: {$LANG04[16]}"
            ,$mailtext
            ,"From: {$_CONF["site_name"]} <{$_CONF["site_mail"]}>\nReturn-Path: <{$_CONF["site_mail"]}>\nX-Mailer: GeekLog $VERSION"
            );
			
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
* Creates a user
*
* Creates a user with the give username and email address
*
* @username     string      username to create user for
* @email        string      email address to assign to user
*
*/
function createuser($username,$email) 
{
    global $_TABLES, $LANG04, $_CONF;
	
    $ucount = DB_count($_TABLES['users'],'username',$username);
    $ecount = DB_count($_TABLES['users'],'email',$email);
	
    if ($ucount == 0 && ecount == 0) {
        if (COM_isEmail($email)) {
            $regdate = strftime('%Y-%m-%d %H:%M:$S',time());
            DB_save($_TABLES['users'],'username,email,regdate',"'$username','$email','$regdate'");
            $uid = DB_getItem($_TABLES['users'],'uid',"username = '$username'");

            // Add user to Logged-in group (i.e. members) and the All Users group (which includes
            // anonymous users
            $normal_grp = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='Logged-in Users'");
            $all_grp = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='All Users'");
            DB_query("INSERT INTO {$_TABLES["group_assignments"]} (ug_main_grp_id,ug_uid) values ($normal_grp, $uid)");
            DB_query("INSERT INTO {$_TABLES["group_assignments"]} (ug_main_grp_id,ug_uid) values ($all_grp, $uid)");
            DB_query("INSERT INTO {$_TABLES["userprefs"]} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES["userindex"]} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES["usercomment"]} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES["userinfo"]} (uid) VALUES ($uid)");
            emailpassword($username, 1);
            return COM_refresh($_CONF['site_url'] . '/index.php?msg=1');
        } else {
            $retval .= COM_siteHeader('Menu') . newuserform($LANG04[18]) . COM_siteFooter();
        }
    } else {
        $retval .= COM_siteHeader('Menu') . newuserform($LANG04[19]) . COM_siteFooter();
    }
    return $retval;
}

/**
* Shows the user login form after failed attempts to either login or access a page
* requiring login. 
*
*/
function loginform()
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
    $user_templates->set_var('lang_forgetpassword', $LANG04[25]);
    $user_templates->set_var('lang_login', 'Login');
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->parse('output', 'login');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
* Shows the user registration form
*
* @msg          int         message number to show
* @referrer     string      page to send user to after registration
* 
*/
function newuserform($msg = '')
{
    global $LANG04, $_CONF;

    $retval = '';
    
	if (!empty($msg)) {
		$retval .= COM_startBlock($LANG04[21]) . $msg . COM_endBlock();
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
    $user_templates->set_var('lang_emailpassword', $LANG04[28]);
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->parse('output', 'form');

    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
* Shows user their account info form
*
* @msg
* @referrer
*
*/
function defaultform($msg, $referrer='') 
{
    global $LANG04, $_CONF;
	
	if (!empty($msg)) {
		$retval .= COM_startBlock($LANG04[21]) . $msg . COM_endBlock();
	}
	
	$retval .= COM_startBlock($LANG04[65])
		. '<form action="' . $_CONF['site_url'] . '/users.php" method="post">' . LB
		. '<table border="0" cellspacing="0" cellpadding="3">' . LB
		. '<tr><td colspan="2">' . $LANG04[66] . '</td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[2] . ':</b></td><td><input type="text" size="16" name="loginname"></td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[4] . ':</b></td><td><input type="password" name="passwd" size="16"></td></tr>' . LB
		. '<tr><td align="center" colspan="2"><input type="submit" value="Login"></td></tr>' . LB
		. '</table></form>'
		. COM_endBlock();
	
	$retval .= COM_startBlock($LANG04[22])
		. '<form action="' . $_CONF['site_url'] . '/users.php" method="post">' . LB
		. '<table border="0" cellspacing="0" cellpadding="3">' . LB
		. '<tr><td colspan="2">' . $LANG04[23] . '</td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[2] 
        . ':</b></td><td><input type="text" size="16" maxlength="16" name="username"></td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[5] 
        . ':</b></td><td><input type="text" size="16" maxlength="32" name="email"></td></tr>' . LB
		. '<tr><td align="center" class="warning" colspan="2">' . $LANG04[24] . '</td></tr>' . LB
		. '<tr><td align="center" colspan="2"><input type="hidden" name="mode" value="create"><input type="submit" value="'
        . $LANG04[27] . '"></td></tr>' . LB 
        . '</table></form>' 
        . COM_endBlock();
	
	$retval .= COM_startBlock($LANG04[25])
		. '<form action="' . $_CONF['site_url'] . '/users.php" method="post">' . LB
		. '<table border="0" cellspacing="0" cellpadding="3">' . LB
		. '<tr><td colspan="2">' . $LANG04[26] . '</td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[2] 
        . ':</b></td><td><input type="text" size="16" maxlength="16" name="username"></td></tr>' . LB
		. '<tr><td align="center" colspan="2"><input type="hidden" name="mode" value="emailpasswd">'
        . '<input type="submit" value="' . $LANG04[28] . '"></td></tr>' . LB
		. '</table></form>'
		. COM_endBlock();
	
	return $retval;
}

// MAIN

switch ($mode) {
case 'logout':
    if (!empty($_USER['uid']) AND $_USER['uid'] > 1) {
        SESS_endUserSession($_USER['uid']);
        COM_accessLog("userid = {$HTTP_COOKIE_VARS[$_CONF["cookie_session"]]} {$LANG04[29]} $REMOTE_ADDR.");
    }
    setcookie($_CONF['cookie_session'],'',time() - 10000,$_CONF['cookie_path']);
    setcookie($_CONF['cookie_name'],'',time() - 10000,$_CONF['cookie_path']);
    $display .= COM_refresh($_CONF['site_url'] . '/index.php?msg=8');
    break;
case 'profile':
    $display .= COM_siteHeader('menu') . userprofile($uid) . COM_siteFooter();
    break;
case 'create':
    $display .= createuser($username,$email);
    break;
case 'getpassword':
    $display .= COM_siteHeader('menu');
    $display .= getpasswordform();
    $display .= COM_siteFooter();
    break;
case 'emailpasswd':
    $display .= emailpassword($username, 1);
    break;
case 'new':
    $display .= COM_siteHeader('menu');
    $display .= newuserform($msg);
    $display .= COM_siteFooter();
    break;
default:
    if (!empty($loginname) && !empty($passwd)) {
        $mypasswd = COM_getPassword($loginname);
    } else {
        srand((double)microtime()*1000000);
        $mypasswd = rand();
    }
    if (!empty($passwd) && $mypasswd == md5($passwd)) {
        $userdata = SESS_getUserData($loginname);
        $_USER=$userdata;
        $sessid = SESS_newSession($_USER['uid'], $REMOTE_ADDR, $_CONF['session_cookie_timeout'], $_CONF['cookie_ip']);
        SESS_setSessionCookie($sessid, $_CONF['session_cookie_timeout'], $_CONF['cookie_session'], $_CONF['cookie_path'], $_CONF['cookiedomain'], $_CONF['cookiesecure']);

        // Now that we handled session cookies, handle longterm cookie
        if (!isset($HTTP_COOKIE_VARS[$_CONF["cookie_name"]]) || !isset($HTTP_COOKIE_VARS['password'])) {
            // Either their cookie expired or they are new
            $cooktime = COM_getUserCookieTimeout();
            if ($VERBOSE) {
                COM_errorLog("Trying to set permanent cookie with time of $cooktime",1);
            }
            if (!empty($cooktime)) {
                // They want their cookie to persist for some amount of time so set it now
                if ($VERBOSE) {
                    COM_errorLog('Trying to set permanent cookie',1);
                }
                setcookie($_CONF['cookie_name'],$_USER['uid'],time() + $cooktime,$_CONF['cookie_path']);
                setcookie('password',md5($passwd),time() + $cooktime,$_CONF['cookie_path']);
            }
        } else {
            $userid = $HTTP_COOKIE_VARS[$_CONF['cookie_name']];
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

        // Now that we have users data see if their theme cookie is set.  If not set it
        setcookie('theme',$_USER['theme'],time() + 31536000,$_CONF['cookie_path']);
	
        // Increment the numlogins counter for this user
        // DB_change("users","numlogins","numlogins + 1","username","$loginname");
        if (($HTTP_REFERER) && ($HTTP_REFERER <> ($_CONF['site_url']."/users.php"))) {
            $display .= COM_refresh($HTTP_REFERER);
        } else {
            $display .= COM_refresh($_CONF['site_url'] . '/index.php');
        }
    } else {
        $display .= COM_siteHeader('menu');

        $display .= COM_showMessage($msg);

        switch ($mode) {
        case 'create':
            // Got bad account info from registration process, show error message
            // and display form again
            $display .= newuserform();
            break;
        default:
            // Show login form
            $display .= loginform();
            break;
        }

        if ($mode != "new" && empty($msg)) {
            $msg = $LANG04[31];
        }

        //$display .= defaultform($msg) . COM_siteFooter();
        $display .= COM_siteFooter();
    }
    break;
}

echo $display;

?>
