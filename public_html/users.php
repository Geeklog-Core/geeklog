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
// $Id: users.php,v 1.9 2001/10/17 23:35:47 tony_bibbs Exp $

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
	
    $result = DB_query("SELECT username,fullname,regdate,homepage FROM {$_TABLES["users"]} WHERE uid = $user");
    $A = DB_fetchArray($result);

    // format date/time to user preference
    $curtime = COM_getUserDateTimeFormat($A["regdate"]);
    $A['regdate'] = $curtime[0];

    $result = DB_query("SELECT about,pgpkey FROM {$_TABLES['userinfo']} WHERE uid = $user");
    $B = DB_fetchArray($result);
	
    $retval .= COM_startBlock($LANG04[1] . ' ' . $A['username'])
        . '<table border="0" cellspacing="0" cellpadding="3">' . LB
        . '<tr valign="top"><td align="right"><b>' . $LANG04[2] . ':</b></td><td>' . $A['username']
        . ' (' .$A['fullname'] . ')</td></tr>' . LB
        . '<tr valign="top"><td align="right"><b>' . $LANG04[67] . ':</b></td><td>' . $A['regdate']
        . '</td></tr>' . LB
        . '<tr valign="top"><td align="right"><b>' . $LANG04[5] . ':</b></td><td><a href="' . $_CONF['site_url']
        . '/profiles.php?uid=' . $user . '">Send Email</a></td></tr>' . LB
        . '<tr valign="top"><td align="right"><b>' . $LANG04[6] . ':</b></td><td><a href="' . $A['homepage'] 
        . '">' . $A['homepage'] . '</a></td></tr>' . LB
        . '<tr valign="top"><td align="right"><b>' . $LANG04[7] . ':</b></td><td>' . $B['about'] . '</td></tr>' . LB
        . '<tr valign="top"><td align="right"><b>' . $LANG04[8] . ':</b></td><td>' . nl2br($B['pgpkey']) . '</td></tr>' . LB
        . '</table>' . LB
        . COM_endBlock();

    $retval .= COM_startBlock($LANG04[10] . ' ' . $A['username'])
        . '<table border="0" cellspacing="0" cellpadding="3">' . LB;

    $result = DB_query("SELECT sid,title,pid,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['comments']} WHERE uid = $user ORDER BY unixdate desc LIMIT 10");
    $nrows = DB_numRows($result);

    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $C = DB_fetchArray($result);
            $retval .= '<tr><td>' . $i . '. <a href="' .$_CONF['site_url'] . '/comment.php?mode=display&sid=' 
                . $C['sid'] . '&title=' . urlencode($C['title']) . '&pid=' . $C['pid'] . '"><b>' . $C['title']
                . '</b></a></td><td>' . strftime($_CONF['date'],$C['unixdate']) . '</td></tr>' . LB;
        }
    } else {
        $retval .= '<tr><td align="right">' . $LANG04[11] . '</td></tr>' . LB;
    }

    $retval .= '</table>' . LB . COM_endBlock();
		
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
        DB_change($_TABLES['users'],'passwd',"'$passwd2'",'username',$username);
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
        $retval .= site_header('Menu') . defaultform($LANG04[17]) . site_footer();
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
        if (isemail($email)) {
            DB_save($_TABLES['users'],'username,email',"'$username','$email'");
            $uid = DB_getItem($_TABLES['users'],'uid',"username = '$username'");
            $normal_grp = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='Normal User'");
            DB_query("INSERT INTO {$_TABLES["group_assignments"]} (ug_main_grp_id,ug_uid) values ($normal_grp, $uid)");
            DB_query("INSERT INTO {$_TABLES["userprefs"]} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES["userindex"]} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES["usercomment"]} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES["userinfo"]} (uid) VALUES ($uid)");
            emailpassword($username, 1);
        } else {
            $retval .= site_header('Menu') . defaultform($LANG04[18]) . site_footer();
        }
    } else {
        $retval .= site_header('Menu') . defaultform($LANG04[19]) . site_footer();
    }
	
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
    if ($user_logged_in) {
        // end_user_session($userdata[uid], $db);
        end_user_session($_USER['uid'], $db);
        COM_accessLog("userid = {$HTTP_COOKIE_VARS[$_CONF["cookie_session"]]} {$LANG04[29]} $REMOTE_ADDR.");
    }
    setcookie($_CONF['cookie_session'],'',time() - 10000,$_CONF['cookie_path']);
    setcookie($_CONF['cookie_name'],'',time() - 10000,$_CONF['cookie_path']);
    $display .= COM_refresh($_CONF['site_url'] . '/index.php?msg=8');
    break;
case 'profile':
    $display .= site_header('menu') . userprofile($uid) . site_footer();
    break;
case 'create':
    $display .= createuser($username,$email);
    break;
case 'emailpasswd':
    $display .= emailpassword($username, 1);
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
        if (!isset($HTTP_COOKIE_VARS[$_CONF["cookie_name"]])) {
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
            }
        } else {
            if ($VERBOSE) {
                COM_errorLog('NOT trying to set permanent cookie',1);
            }
            $userid = $HTTP_COOKIE_VARS[$_CONF['cookie_name']];
            COM_errorLog('Got '.$userid.' from perm cookie in users.php',1);
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
	
        // Increment the numlogins counter for this user
        // DB_change("users","numlogins","numlogins + 1","username","$loginname");
        if (($HTTP_REFERER) && ($HTTP_REFERER <> ($_CONF['site_url']."/users.php"))) {
            $display .= COM_refresh($HTTP_REFERER);
        } else {
            $display .= COM_refresh($_CONF['site_url'] . '/index.php');
        }
    } else {
        $display .= site_header('menu');
        if ($mode != "new" && empty($msg)) {
            $msg = $LANG04[31];
        }
        $display .= defaultform($msg) . site_footer();
    }
    break;
}

echo $display;

?>
