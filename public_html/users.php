<?php
###############################################################################
# users.php
# This is the user authentication module.
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################
include('lib-common.php');

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

###############################################################################
# displays the profile form

function userprofile($user) {
	global $CONF,$LANG04;
	
	$result = dbquery("SELECT username,fullname,regdate,homepage FROM {$CONF['db_prefix']}users WHERE uid = $user");
	$A = mysql_fetch_array($result);
	$curtime = getuserdatetimeformat($A["regdate"]);
	$A['regdate'] = $curtime[0];
	$result = dbquery("SELECT about,pgpkey FROM {$CONF['db_prefix']}userinfo WHERE uid = $user");
	$B = mysql_fetch_array($result);
	
	$retval .= startblock($LANG04[1].' '.$A['username'])
		.'<table border="0" cellspacing="0" cellpadding="3">'.LB
		.'<tr valign="top"><td align="right"><b>'.$LANG04[2].':</b></td><td>'.$A['username'].' ('.$A['fullname'].')</td></tr>'.LB
		.'<tr valign="top"><td align="right"><b>'.$LANG04[67].':</b></td><td>'.$A['regdate'].'</td></tr>'.LB
		.'<tr valign="top"><td align="right"><b>'.$LANG04[5].':</b></td><td><a href="'.$CONF['site_url'].'/profiles.php?uid='.$user.'">Send Email</a></td></tr>'.LB
		.'<tr valign="top"><td align="right"><b>'.$LANG04[6].':</b></td><td><a href="'.$A['homepage'].'">'.$A['homepage'].'</a></td></tr>'.LB
		.'<tr valign="top"><td align="right"><b>'.$LANG04[7].':</b></td><td>'.$B['about'].'</td></tr>'.LB
		.'<tr valign="top"><td align="right"><b>'.$LANG04[8].':</b></td><td>'.nl2br($B['pgpkey']).'</td></tr>'.LB
		.'</table>'.LB
		.endblock();

	$retval .= startblock($LANG04[10].' '.$A['username'])
		.'<table border="0" cellspacing="0" cellpadding="3">'.LB;

	$result = dbquery("SELECT sid,title,pid,UNIX_TIMESTAMP(date) AS unixdate FROM {$CONF['db_prefix']}comments WHERE uid = $user ORDER BY unixdate desc LIMIT 10");
	$nrows = mysql_num_rows($result);

	if ($nrows > 0) {
		for ($i=1; $i <= $nrows; $i++) {
			$C = mysql_fetch_array($result);
			$retval .= '<tr><td>'.$i.'. <a href="'.$CONF['site_url'].'/comment.php?mode=display&sid='.$C['sid'].'&title='.urlencode($C['title']).'&pid='.$C['pid'].'"><b>'.$C['title'].'</b></a></td><td>'.strftime($CONF['date'],$C['unixdate']).'</td></tr>'.LB;
		}
	} else {
		$retval .= '<tr><td align="right">'.$LANG04[11].'</td></tr>'.LB;
	}

	$retval .= '</table>'.LB
		.endblock();
		
	return $retval;
}

###############################################################################
#

function emailpassword($username,$msg=0) {
	global $CONF,$LANG04;
	
	$result = dbquery("SELECT email FROM {$CONF['db_prefix']}users WHERE username = '$username'");
	$nrows = mysql_num_rows($result);
	if ($nrows == 1) {
		srand((double)microtime()*1000000);
		$passwd = rand();
		$passwd = md5($passwd);
		$passwd = substr($passwd,1,8);
		$passwd2 = md5($passwd);
		dbchange('users','passwd',"'$passwd2'",'username',$username);
		$A = mysql_fetch_array($result);
		$mailtext = "{$LANG04[15]}\n\n";
		$mailtext .= "{$LANG04[2]}: $username\n";
		$mailtext .= "{$LANG04[4]}: $passwd\n\n";
		$mailtext .= "{$LANG04[14]}\n\n";
		# $mailtext .= "{$CONF['site_url']}/users.php?mode=edit\n\n";
		$mailtext .= "{$CONF["site_name"]}\n";
		$mailtext .= "{$CONF['site_url']}\n";
		mail($A["email"]
			,"{$CONF["site_name"]}: {$LANG04[16]}"
			,$mailtext
			,"From: {$CONF["site_name"]} <{$CONF["site_mail"]}>\nReturn-Path: <{$CONF["site_mail"]}>\nX-Mailer: GeekLog $VERSION"
			);
			
		if ($msg)
			$retval .= refresh("{$CONF['site_url']}/index.php?msg=$msg");
		else
			$retval .= refresh("{$CONF['site_url']}/index.php");
	} else {
		$retval .= site_header('Menu')
			.defaultform($LANG04[17])
			.site_footer();
	}
	
	return $retval;
}

###############################################################################
# saves stuff

function createuser($username,$email) {
	global $LANG04,$CONF;
	
	$ucount = dbcount('users','username',$username);
	$ecoutn = dbcount('users','email',$email);
	
	if ($ucount == 0 && ecount == 0) {
		if (isemail($email)) {
			dbsave('users','username,email',"'$username','$email'");
			$uid = getitem('users','uid',"username = '$username'");
			$normal_grp = getitem('groups','grp_id',"grp_name='Normal User'");
			dbquery("INSERT INTO group_assignments (ug_main_grp_id,ug_uid) values ($normal_grp, $uid)");
			dbquery("INSERT INTO userprefs (uid) VALUES ($uid)");
			dbquery("INSERT INTO userindex (uid) VALUES ($uid)");
			dbquery("INSERT INTO usercomment (uid) VALUES ($uid)");
			dbquery("INSERT INTO userinfo (uid) VALUES ($uid)");
			emailpassword($username, 1);
		} else {
			$retval .= site_header('Menu')
				.defaultform($LANG04[18])
				.site_footer();
		}
	} else {
		$retval .= site_header('Menu')
			.defaultform($LANG04[19])
			.site_footer();
	}
	
	return $retval;
}

###############################################################################
# Default form

function defaultform($msg, $referrer='') {
	global $LANG04,$CONF;
	
	if (!empty($msg)) {
		$retval .= startblock($LANG04[21])
			.$msg
			.endblock();
	}
	
	$retval .= startblock($LANG04[65])
		.'<form action="'.$CONF['site_url'].'/users.php" method="post">'.LB
		.'<table border="0" cellspacing="0" cellpadding="3">'.LB
		.'<tr><td colspan="2">'.$LANG04[66].'</td></tr>'.LB
		.'<tr><td align="right"><b>'.$LANG04[2].':</b></td><td><input type="text" size="16" name="loginname"></td></tr>'.LB
		.'<tr><td align="right"><b>'.$LANG04[4].':</b></td><td><input type="password" name="passwd" size="16"></td></tr>'.LB
		.'<tr><td align="center" colspan="2"><input type="submit" value="Login"></td></tr>'.LB
		.'</table></form>'
		.endblock();
	
	$retval .= startblock($LANG04[22])
		.'<form action="'.$CONF['site_url'].'/users.php" method="post">'.LB
		.'<table border="0" cellspacing="0" cellpadding="3">'.LB
		.'<tr><td colspan="2">'.$LANG04[23].'</td></tr>'.LB
		.'<tr><td align="right"><b>'.$LANG04[2].':</b></td><td><input type="text" size="16" maxlength="16" name="username"></td></tr>'.LB
		.'<tr><td align="right"><b>'.$LANG04[5].':</b></td><td><input type="text" size="16" maxlength="32" name="email"></td></tr>'.LB
		.'<tr><td align="center" class="warning" colspan="2">'.$LANG04[24].'</td></tr>'.LB
		.'<tr><td align="center" colspan="2"><input type="hidden" name="mode" value="create"><input type="submit" value="'.$LANG04[27].'"></td></tr>'.LB
		.'</table></form>'
		.endblock();
	
	$retval .= startblock($LANG04[25])
		.'<form action="'.$CONF['site_url'].'/users.php" method="post">'.LB
		.'<table border="0" cellspacing="0" cellpadding="3">'.LB
		.'<tr><td colspan="2">'.$LANG04[26].'</td></tr>'.LB
		.'<tr><td align="right"><b>'.$LANG04[2].':</b></td><td><input type="text" size="16" maxlength="16" name="username"></td></tr>'.LB
		.'<tr><td align="center" colspan="2"><input type="hidden" name="mode" value="emailpasswd"><input type="submit" value="'.$LANG04[28].'"></td></tr>'.LB
		.'</table></form>'
		.endblock();
	
	return $retval;
}

###############################################################################
# MAIN

switch ($mode) {
	case 'logout':
		if ($user_logged_in) {
			end_user_session($userdata[uid], $db);
			accesslog("userid = {$HTTP_COOKIE_VARS[$CONF["cookie_session"]]} {$LANG04[29]} $REMOTE_ADDR.");
		}
		setcookie($CONF['cookie_session'],'',time() - 10000,$CONF['cookie_path']);
		setcookie($CONF['cookie_name'],'',time() - 10000,$CONF['cookie_path']);
		$display .= refresh($CONF['site_url'].'/index.php?msg=8');
		break;
	case 'profile':
		$display .= site_header('menu')
			.userprofile($uid)
			.site_footer();
		break;
	case 'create':
		$display .= createuser($username,$email);
		break;
	case 'emailpasswd':
		$display .= emailpassword($username, 1);
		break;
	default:
		if (!empty($loginname) && !empty($passwd)) {
			$mypasswd = getpassword($loginname);
		} else {
			srand((double)microtime()*1000000);
			$mypasswd = rand();
		}
		if (!empty($passwd) && $mypasswd == md5($passwd)) {
			$userdata = get_userdata($loginname);
			$USER=$userdata;
			$sessid = new_session($USER[uid], $REMOTE_ADDR, $CONF['session_cookie_timeout'], $CONF['cookie_ip']);
			set_session_cookie($sessid, $CONF['session_cookie_timeout'], $CONF['cookie_session'], $CONF['cookie_path'], $CONF['cookiedomain'], $CONF['cookiesecure']);
			// Now that we handled session cookies, handle longterm cookie
			
			if (!isset($HTTP_COOKIE_VARS[$CONF["cookie_name"]])) {
				// Either their cookie expired or they are new
				$cooktime = getusercookietimeout();
				if ($VERBOSE) {
					errorlog("Trying to set permanent cookie with time of $cooktime",1);
				}
				if (!empty($cooktime)) {
					// They want their cookie to persist for some amount of time so set it now
					if ($VERBOSE) {
						errorlog('Trying to set permanent cookie',1);
					}
					setcookie($CONF['cookie_name'],$USER['uid'],time() + $cooktime,$CONF['cookie_path']);
				}
			} else {
				if ($VERBOSE) {
					errorlog('NOT trying to set permanent cookie',1);
				}
				$userid = $HTTP_COOKIE_VARS[$CONF['cookie_name']];
				errorlog('Got '.$userid.' from perm cookie in users.php',1);
				if ($userid) {
					$user_logged_in = 1;
					// Create new session
					$userdata = get_userdata_from_id($userid);
					$USER = $userdata;
					if ($VERBOSE) {
						errorlog('Got '.$USER['username'].' for the username in user.php',1);
					}
				}
			}
	
            // Increment the numlogins counter for this user
            // dbchange("users","numlogins","numlogins + 1","username","$loginname");
            if (($HTTP_REFERER) && ($HTTP_REFERER <> ($CONF['site_url']."/users.php"))) {
            	$display .= refresh($HTTP_REFERER);
			} else {
				$display .= refresh($CONF['site_url'].'/index.php');
			}
		} else {
        	$display .= site_header('menu');
			if ($mode != "new" && empty($msg)) {
				$msg = $LANG04[31];
			}
			$display .= defaultform($msg)
				.site_footer();
		}
		break;
}
echo $display;
?>