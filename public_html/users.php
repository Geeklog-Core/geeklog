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

include("common.php");
include("custom_code.php");

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

###############################################################################
# displays the profile form

function userprofile($user) {
	global $CONF,$LANG04;
	$result = dbquery("SELECT username,fullname,homepage FROM users WHERE uid = $user");
	$A = mysql_fetch_array($result);
	startblock("{$LANG04[1]} {$A["username"]}");
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	print "<tr><td align=right><b>{$LANG04[2]}:</b></td><td>{$A["username"]} ({$A["fullname"]})</td></tr>\n";
	print "<tr><td align=right><b>{$LANG04[5]}:</b></td><td><a href={$CONF["site_url"]}/profiles.php?uid=$user>Send Email</a></td></tr>\n";
	print "<tr><td align=right><b>{$LANG04[6]}:</b></td><td><a href={$A["homepage"]}>{$A["homepage"]}</a></td></tr>\n";
	$result = dbquery("SELECT about,pgpkey FROM userinfo WHERE uid = $user");
	$B = mysql_fetch_array($result);
	print "<tr><td valign=top align=right><b>{$LANG04[7]}:</b></td><td>{$B["about"]}</td></tr>\n";
	print "<tr><td valign=top align=right><b>{$LANG04[8]}:</b></td><td>" . nl2br($B["pgpkey"]) . "</td></tr>\n";
	print "</table>";
	endblock();
	startblock("{$LANG04[10]} {$A["username"]}");
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	$result = dbquery("SELECT sid,title,pid,UNIX_TIMESTAMP(date) AS unixdate FROM comments WHERE uid = $user ORDER BY unixdate desc LIMIT 10");
	$nrows = mysql_num_rows($result);
	if ($nrows > 0) {
		for ($i=1; $i <= $nrows; $i++) {
			$C = mysql_fetch_array($result);
			print "<tr align=left><td>$i. <a href={$CONF["site_url"]}/comment.php?mode=display&sid={$C["sid"]}&title=" . urlencode($C["title"]) . "&pid={$C["pid"]}><b>{$C["title"]}</b></a></td><td>" . strftime($CONF["date"],$C["unixdate"]) . "</td></tr>\n";
		}
	} else {
		print "<tr><td align=right>{$LANG04[11]}</td></tr>\n";
	}
	print "</table>";
	endblock();
}

###############################################################################
#

function emailpassword($username,$msg=0) {
	global $CONF,$LANG04;
	$result = dbquery("SELECT email FROM users WHERE username = '$username'");
	$nrows = mysql_num_rows($result);
	if ($nrows == 1) {
		srand((double)microtime()*1000000);
		$passwd = rand();
		$passwd = md5($passwd);
		$passwd = substr($passwd,1,8);
		$passwd2 = md5($passwd);
		dbchange("users","passwd","'$passwd2'","username","$username");
		$A = mysql_fetch_array($result);
		$mailtext = "{$LANG04[15]}\n\n";
		$mailtext .= "{$LANG04[2]}: $username\n";
		$mailtext .= "{$LANG04[4]}: $passwd\n\n";
		$mailtext .= "{$LANG04[14]}\n\n";
		# $mailtext .= "{$CONF["site_url"]}/users.php?mode=edit\n\n";
		$mailtext .= "{$CONF["site_name"]}\n";
		$mailtext .= "{$CONF["site_url"]}\n";
                mail($A["email"],"{$CONF["site_name"]}: {$LANG04[16]}",$mailtext,
		"From: {$CONF["site_name"]} <{$CONF["site_mail"]}>\nReturn-Path: <{$CONF["site_mail"]}>\nX-Mailer: GeekLog $VERSION");
		if ($msg)
			refresh("{$CONF["site_url"]}/index.php?msg=$msg");
		else
			refresh("{$CONF["site_url"]}/index.php");
	} else {
		include("layout/header.php");
		defaultform($LANG04[17]);
		include("layout/footer.php");
	}
}

###############################################################################
# saves stuff

function createuser($username,$email) {
	global $LANG04,$CONF;
	$ucount = dbcount("users","username",$username);
	$ecoutn = dbcount("users","email",$email);
	if ($ucount == 0 && ecount == 0) {
		if (isemail($email)) {
			dbsave("users","username,seclev,email","'$username',0,'$email'");
			dbquery("INSERT INTO userprefs (uid) SELECT uid FROM users WHERE username = '$username'");
			dbquery("INSERT INTO userindex (uid) SELECT uid FROM users WHERE username = '$username'");
			dbquery("INSERT INTO usercomment (uid) SELECT uid FROM users WHERE username = '$username'");
			dbquery("INSERT INTO userinfo (uid) SELECT uid FROM users WHERE username = '$username'");
			emailpassword($username, 1);
		} else {
			include("layout/header.php");
			defaultform($LANG04[18]);
			include("layout/footer.php");
		}
	} else {
		include("layout/header.php");
		defaultform($LANG04[19]);
		include("layout/footer.php");
	}
}


###############################################################################
# Default form

function defaultform($msg, $referrer="") {
	global $LANG04,$CONF;
	if (!empty($msg)) {
		startblock($LANG04[21]);
		print $msg;
		endblock();
	}
	startblock($LANG04[65]);
	print "<form action={$CONF["site_url"]}/users.php method=post>\n";
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	print "<tr><td colspan=2>{$LANG04[66]}</td></tr>";
	print "<tr><td align=right><b>{$LANG04[2]}:</b></td><td><input type=text size=16 name=loginname></td></tr>";
	print "<tr><td align=right><b>{$LANG04[4]}:</b></td><td><input type=password name=passwd size=16></td></tr>";
	print "<tr><td align=center colspan=2><input type=submit value=Login></td></tr></table></form>";
	endblock();
	startblock($LANG04[22]);
	print "<form action={$CONF["site_url"]}/users.php method=post>\n";
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	print "<tr><td colspan=2>{$LANG04[23]}</td></tr>";
	print "<tr><td align=right><b>{$LANG04[2]}:</b></td><td><input type=text size=16 maxlength=16 name=username></td></tr>\n";
	print "<tr><td align=right><b>{$LANG04[5]}:</b></td><td><input type=text size=16 maxlength=32 name=email></td></tr>\n";
	print "<tr><td align=center class=warning colspan=2>{$LANG04[24]}</td></tr>\n";
	print "<tr><td align=center colspan=2><input type=hidden name=mode value=create><input type=submit value=\"{$LANG04[27]}\"></td></tr>\n";
	print "</table></form>";
	endblock();
	startblock($LANG04[25]);
	print "<form action={$CONF["site_url"]}/users.php method=post>\n";
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	print "<tr><td colspan=2>{$LANG04[26]}</td></tr>";
	print "<tr><td align=right><b>{$LANG04[2]}:</b></td><td><input type=text size=16 maxlength=16 name=username></td></tr>\n";
	print "<tr><td align=center colspan=2><input type=hidden name=mode value=emailpasswd><input type=submit value=\"{$LANG04[28]}\"></td></tr>\n";
	print "</table></form>";
	endblock();
}

###############################################################################
# MAIN

switch ($mode) {
	case "logout":
		if ($user_logged_in) {
                        end_user_session($userdata[uid], $db);
                }
		if ($USER["seclev"] >= $CONF["sec_lowest"]) {
			accesslog("{$HTTP_COOKIE_VARS["gl_loginname"]} {$LANG04[29]} $REMOTE_ADDR.");
		}
                refresh("{$CONF["site_url"]}/index.php?msg=8");
                break;
	case "profile":
		include("layout/header.php");
		userprofile($uid);
		include("layout/footer.php");
		break;
	case "create":
		createuser($username,$email);
		break;
	case "emailpasswd":
		emailpassword($username, 1);
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
                        $sessid = new_session($USER[uid], $REMOTE_ADDR, $CONF["cookie_timeout"], $CONF["cookie_ip"]);
                        set_session_cookie($sessid, $CONF["cookie_timeout"], $CONF["cookie_session"], $CONF["cookie_path"], $CONF["cookiedomain"], $CONF["cookiesecure"]);
                        // increment the numlogins counter for this user
                        //dbchange("users","numlogins","numlogins + 1","username","$loginname");

                        if (($HTTP_REFERER) && ($HTTP_REFERER <> ($CONF["site_url"] . "/users.php"))) {
                                refresh("$HTTP_REFERER");
                        } else {
                                refresh("{$CONF["site_url"]}/index.php");
                        }
                } else {
                        include("layout/header.php");
                        if ($mode != "new" && empty($msg)) $msg = $LANG04[31];
                        defaultform($msg);
                        include("layout/footer.php");

                }
                break;
}

?>
