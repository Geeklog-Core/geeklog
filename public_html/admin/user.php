<?php

###############################################################################
# user.php
# This is the admin users interface!
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

include("../common.php");
include("../custom_code.php");
include("auth.inc.php");

###############################################################################
# Displays the user editor

function edituser($uid="") {
	global $LANG28,$CONF;
	startblock($LANG28[1]);
	if (!empty($uid)) {
		$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}users where uid ='$uid'");
		$A = mysql_fetch_array($result);
		$curtime = getuserdatetimeformat($A["regdate"]);
	}
	if ($A["uid"] == "") {
                $tmp = dbquery("SELECT MAX(uid) AS max FROM {$CONF["db_prefix"]}users");
                $T = mysql_fetch_array($tmp);
                $A["uid"] = $T["max"] + 1;
		$curtime =  getuserdatetimeformat();
        }
	$A["regdate"] = $curtime[0];
	print "<form action={$CONF["site_url"]}/admin/user.php name=storyeditor method=post>";
	print "<table border=0 cellspacing=0 cellpadding=3>";
	print "<tr><td colspan=2><input type=submit value=save name=mode> ";
	if ($A["uid"] > 1) { print "<input type=submit value=changepw name=mode> "; }
	print "<input type=submit value=cancel name=mode> ";
	if (!empty($uid))
		print "<input type=submit value=delete name=mode>";
	print "<tr></td>";
	print "<tr><td align=right>{$LANG28[2]}:</td><td>{$A["uid"]}<input type=hidden name=uid value={$A["uid"]}></td></tr>";
	print "<tr><td align=\"right\">{$LANG28[14]}:</td><td><input type=hidden name=regdate value=\"{$A["regdate"]}\">{$A["regdate"]}</td></tr>";
	print "<tr><td align=right>{$LANG28[3]}:</td><td><input type=text size=16 name=username value=\"{$A["username"]}\"> {$LANG28[9]}</td></tr>";
	print "<tr><td align=right>{$LANG28[4]}:</td><td><input type=text size=48 maxlength=80 name=fullname value=\"{$A["fullname"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG28[5]}:</td><td><input type=password size=16 name=passwd value=\"{$A["password"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG28[6]}:</td><td><input type=text size=3 name=seclev value=\"{$A["seclev"]}\"> 0 - 255</td></tr>";
	print "<tr><td align=right>{$LANG28[7]}:</td><td><input type=text size=48 maxlength=255 name=email value=\"{$A["email"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG28[8]}:</td><td><input type=text size=48 maxlength=255 name=homepage value=\"{$A["homepage"]}\"></td></tr>";
	print "</table></form>";
	endblock();
}

###############################################################################
# Changes $uid's password

function changepw($uid,$passwd) {
	global $CONF; 
	if (!empty($passwd) && !empty($uid)) {
		$passwd = md5($passwd);
		$result = dbchange("users","passwd","'$passwd'","uid",$uid,"admin/user.php?mode=none");	
	} else {
		site_header("menu");
		errorlog("CHANGEPW ERROR: There was nothing to do!",3);
		site_footer();
	}
}

###############################################################################
# Saves $uid to the database

function saveusers($uid,$username,$fullname,$passwd,$seclev,$email,$regdate,$homepage) {
	global $CONF,$LANG28;
	if (!empty($username) && !empty($email)) {
		if (($uid == 1) or !empty($passwd)) { 
			$passwd = md5($passwd);
			$sql = "REPLACE INTO {$CONF["db_prefix"]}users (uid,username,fullname,passwd,seclev,email,homepage) VALUES ($uid,'$username','$fullname','$passwd','$seclev','$email','$homepage')";
		} else {
			$sql = "SELECT passwd FROM {$CONF["db_prefix"]}users WHERE uid = $uid";
			$result = dbquery($sql);
			$A = mysql_fetch_array($result);
			$sql = "REPLACE INTO {$CONF["db_prefix"]}users (uid,username,fullname,passwd,seclev,email,homepage) VALUES ($uid,'$username','$fullname','" . $A["passwd"] . "','$seclev','$email','$homepage')";
		} 
		$result = dbquery($sql);
		dbsave("userprefs","uid",$uid);
		dbsave("usercomment","uid",$uid);
		dbsave("userindex","uid",$uid);
		dbsave("userinfo","uid",$uid);
		$tmp = mysql_errno();
		if ($tmp == 0) { 
			refresh("{$CONF["site_url"]}/admin/user.php?msg=21");
		} else {
			site_header("menu");
			$tmp = "SAVEUSERS ERROR <BR>" . $sql . " <BR> " . mysql_error();
			errorlog($tmp,3);
			site_footer();
		}
	} else {
		site_header("menu");
		errorlog($LANG28[10],2);
		edituser($uid);
		site_footer();
	}
}

###############################################################################
# Displays a list of users

function listusers() {
	global $LANG28,$CONF;
	startblock($LANG28[11]);
	adminedit("user",$LANG28[12]);
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr><th align=left>{$LANG28[3]}</th><th>{$LANG28[4]}</th><th>{$LANG28[13]}</th><th>{$LANG28[7]}</th></tr>";
	$result = dbquery("SELECT uid,username,fullname,seclev,email FROM {$CONF["db_prefix"]}users WHERE uid > 1");
	$nrows = mysql_num_rows($result);
	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
		print "<tr align=center><td align=left><a href={$CONF["site_url"]}/admin/user.php?mode=edit&uid={$A["uid"]}>{$A["username"]}</a></td>";
		print "<td>{$A["fullname"]}</td><td>{$A["seclev"]}</td><td>{$A["email"]}</td></tr>";
	}
	print "</table></form>";
	endblock();
}

###############################################################################
# MAIN

switch ($mode) {
	case "delete":
		dbdelete("users","uid",$uid,"admin/user.php?msg=22");
		break;
	case "save":
		saveusers($uid,$username,$fullname,$passwd,$seclev,$email,$regdate,$homepage);
		break;
	case "changepw":
		errorlog("user id = " . $uid . " pass = " . $passwd);
		changepw($uid,$passwd);
		break;
	case "edit":
		site_header("menu");
		edituser($uid);
		site_footer();
		break;
	case "cancel":
	default:
		site_header("menu");
		showmessage($msg);
		listusers();
		site_footer();
		break;
}

?>
