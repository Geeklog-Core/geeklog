<?php

###############################################################################
# usersettings.php
# This is the user configuration module.
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
# displays the add/edit form

function edituser() {
	global $CONF,$LANG04,$USER;
	$result = dbquery("SELECT fullname,email,homepage,sig,emailstories,about,pgpkey FROM {$CONF["db_prefix"]}users,{$CONF["db_prefix"]}userprefs,{$CONF["db_prefix"]}userinfo WHERE users.uid = {$USER["uid"]} && userprefs.uid = {$USER["uid"]} && userinfo.uid = {$USER["uid"]}");
	$A = mysql_fetch_array($result);
	startblock("{$LANG04[1]} {$USER["username"]}","");
	print "<form action={$CONF["site_url"]}/usersettings.php method=post>\n";
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[3]}:</b><br><small>{$LANG04[34]}</small></td><td><input type=text name=fullname size=32 maxlength=80 value=\"{$A["fullname"]}\"></td></tr>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[4]}:</b><br><small>{$LANG04[35]}</small></td><td><input type=password name=passwd size=16 maxlength=32 value=\"{$A["passwd"]}\"></td></tr>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[5]}:</b><br><small>{$LANG04[33]}</small></td><td><input type=text name=email size=32 maxlength=96 value=\"{$A["email"]}\"></td></tr>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[6]}:</b><br><small>{$LANG04[36]}</small></td><td><input type=text name=homepage size=32 maxlength=96 value=\"{$A["homepage"]}\"></td></tr>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[32]}:</b><br><small>{$LANG04[37]}</small></td><td><textarea name=sig cols=45 rows=3 wrap=virtual>{$A["sig"]}</textarea></td></tr>\n";
#	print "<tr valign=top><td align=right><b>{$LANG04[13]}:</b><br><small>{$LANG04[53]}</small></td><td><select name=emailstories>";
#	optionlist("maillist","code,name",$A["emailstories"]);
#	print "</select></td></tr>\n";
	$result = dbquery("SELECT about,pgpkey FROM {$CONF["db_prefix"]}userinfo WHERE uid = {$USER["uid"]}");
	$A = mysql_fetch_array($result);
	print "<tr valign=top><td align=right><b>{$LANG04[7]}:</b><br><small>{$LANG04[38]}</small></td><td><textarea name=about cols=45 rows=6 wrap=virtual>{$A["about"]}</textarea></td></tr>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[8]}:</b><br><small>{$LANG04[39]}</small></td><td><textarea name=pgpkey cols=45 rows=6 wrap=virtual>{$A["pgpkey"]}</textarea></td></tr>\n";
	print "<tr valign=top><td align=center colspan=2><input type=hidden name=uid value=$user><input type=hidden name=mode value=saveuser>";
	print "<input type=hidden name=username value=\"{$USER["username"]}\"><input type=submit value=\"{$LANG04[9]}\"></td></tr>\n";
	print "</table></form>";
	endblock();
}

###############################################################################
# displays the preferences

function editpreferences() {
	global $CONF,$LANG04,$USER;
	$result = dbquery("SELECT noicons,willing,dfid,tzid,noboxes,maxstories,tids,aids,boxes FROM {$CONF["db_prefix"]}userprefs,userindex WHERE userindex.uid = {$USER["uid"]} AND userprefs.uid = {$USER["uid"]}");
	$A = mysql_fetch_array($result);
	if ($A["maxstories"] < 5) $A["maxstories"] = 5;
	startblock("{$LANG04[45]} {$USER["username"]}","");
	print "<form action={$CONF["site_url"]}/usersettings.php method=post>\n";
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[40]}:</b><br><small>{$LANG04[49]}</small></td><td><input type=checkbox name=noicons";
	if ($A["noicons"] == "1") {
		print " checked";
	}
	print "></td></tr>\n";
#	print "<tr valign=top><td align=right><b>{$LANG04[41]}:</b><br><small>{$LANG04[50]}</small></td><td><input type=checkbox name=willing";
#	if ($A["willing"] == 1) {
#		print " checked";
#	}
#	print "></td></tr>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[44]}:</b><br><small>{$LANG04[51]}</small></td><td><input type=checkbox name=noboxes";
	if ($A["noboxes"] == 1) {
		print " checked";
	}
	print "></td></tr>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[43]}:</b><br><small>{$LANG04[52]}</small></td><td>";
	print "<input type=text size=3 maxlength=3 name=maxstories value={$A["maxstories"]}></td></tr>\n";

	print "<tr valign=top><td align=right><b>{$LANG04[42]}:</b></td><td><select name=dfid>";
	optionlist("dateformats","dfid,description",$A["dfid"]);
#	print "</select><select name=tzid>";
#	optionlist("tzcodes","tz,description",$A["tzid"]);
	print "</select></td></tr></table>\n";
	endblock();
	startblock("{$LANG04[46]} {$USER["username"]}","");
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	print "<tr><td colspan=3>{$LANG04[54]}</td></tr>";
	print "<tr valign=top><td><b>{$LANG04[48]}</b><br>";
	checklist("topics","tid,topic","",$A["tids"]);
	print "</td><td><img src={$CONF["site_url"]}/images/speck.gif width=40 height=1></td>";
	if ($CONF["contributedbyline"] == 1) {
		print "<td><b>{$LANG04[56]}</b><br>";
		$result = dbquery("SELECT DISTINCT uid FROM {$CONF["db_prefix"]}stories");
		$nrows = mysql_num_rows($result);
		unset($where);
		for ($i=0; $i<$nrows; $i++) {
			$W = mysql_fetch_row($result);
			$where .= "uid = '$W[0]' OR ";
		}
		$where .= "uid = '1'";
		checklist("users","uid,username",$where,$A["aids"]);
		print "</td>";
	}
	print "</tr></table>";
	endblock();
	startblock("{$LANG04[47]} {$USER["username"]}","");
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	print "<tr><td>{$LANG04[55]}</td></tr>";
	print "<tr><td>";
	checklist("blocks","bid,title,blockorder","(type != 'layout' AND type != 'gldefault') OR (type='gldefault' AND title in ('Whats New Block','Poll Block','Events Block')) ORDER BY onleft desc,blockorder,title",$A["boxes"]);
	print "</td></tr></table>";
	endblock();
	print "<center><input type=hidden name=mode value=savepreferences>";
	print "<input type=submit value=\"{$LANG04[9]}\"></center>\n";
	print "</form>";
}

###############################################################################
# displays the comment preferences

function editcommentprefs() {
	global $CONF,$LANG04,$USER;
	$result = dbquery("SELECT commentmode,commentorder,commentlimit FROM {$CONF["db_prefix"]}usercomment WHERE uid = {$USER["uid"]}");
	$A = mysql_fetch_array($result);
	if (empty($A["commentmode"])) $A["commentmode"] = "threaded";
	if (empty($A["commentorder"])) $A["commentorder"] = 0;
	if (empty($A["commentlimit"])) $A["commentlimit"] = 100;
	startblock("{$LANG04[64]} {$USER["username"]}","");
	print "<form action={$CONF["site_url"]}/usersettings.php method=post>\n";
	print "<table border=0 cellspacing=0 cellpadding=3>\n";
	print "<tr valign=top><td align=right><b>{$LANG04[57]}:</b><br><small>{$LANG04[60]}</small></td><td><select name=commentmode>";
	optionlist("commentmodes","mode,name",$A["commentmode"]);
	print "</select></td></tr>";
	print "<tr valign=top><td align=right><b>{$LANG04[58]}:</b><br><small>{$LANG04[61]}</small></td><td><select name=commentorder>";
	optionlist("sortcodes","code,name",$A["commentorder"]);
	print "</select></td></tr>";
	print "<tr valign=top><td align=right><b>{$LANG04[59]}:</b><br><small>{$LANG04[62]}</small></td><td>";
	print "<input type=text size=5 maxlength=5 name=commentlimit value={$A["commentlimit"]}></td></tr>\n";
	print "<tr><td align=right colspan=2><input type=hidden name=mode value=savecomments>";
	print "<input type=submit value=\"{$LANG04[9]}\"></td></tr>\n";
	print "</table></form>";
	endblock();
}

###############################################################################
# saves stuff

function saveuser($A) {
	global $CONF,$USER;
	if (!empty($A["passwd"])) {
		$passwd = md5($A["passwd"]);
		dbchange("users","passwd","'$passwd'","uid",$USER["uid"]);
		setcookie("gl_password",$passwd,0,"/");
	}
	if (isemail($A["email"])) {
		dbquery("UPDATE users SET fullname='{$A["fullname"]}',email='{$A["email"]}',homepage='{$A["homepage"]}',sig='{$A["sig"]}' WHERE uid={$USER["uid"]}");
		dbquery("UPDATE userprefs SET emailstories='{$A["emailstories"]}' WHERE uid={$USER["uid"]}");
		dbquery("UPDATE userinfo SET pgpkey='" . strip_tags($A["pgpkey"]) . "',about='{$A["about"]}' WHERE uid={$USER["uid"]}");
		refresh("{$CONF["site_url"]}/usersettings.php?mode=edit&msg=5");
	}
}

###############################################################################
# saves stuff

function savepreferences($A) {
	global $CONF,$USER;
	if ($A["noicons"] == "on") $A["noicons"] = 1;
	if ($A["willing"] == "on") $A["willing"] = 1;
	if ($A["noboxes"] == "on") $A["noboxes"] = 1;
	if ($A["maxstories"] < 5) $A["maxstories"] = 5;
	unset($tids);
	unset($aids);
	unset($boxes);
	$TIDS = @array_values($A["topics"]);
	$AIDS = @array_values($A["users"]);
	$BOXES = @array_values($A["blocks"]);
	if (sizeof($TIDS) > 0) {
		for ($i=0; $i<sizeof($TIDS); $i++) {
		$tids .= $TIDS[$i] . " ";
		}
	}
	if (sizeof($AIDS) > 0) {
		for ($i=0; $i<sizeof($AIDS); $i++) {
		$aids .= $AIDS[$i] . " ";
		}
	}
	if (sizeof($BOXES) > 0) {
		for ($i=0; $i<sizeof($BOXES); $i++) {
		$boxes .= $BOXES[$i] . " ";
		}
	}
	dbquery("UPDATE userprefs SET noicons='{$A["noicons"]}', willing='{$A["willing"]}', dfid='{$A["dfid"]}', tzid='{$A["tzid"]}' WHERE uid='{$USER["uid"]}'");
	dbsave("userindex","uid,tids,aids,boxes,noboxes,maxstories","'{$USER["uid"]}','$tids','$aids','$boxes','{$A["noboxes"]}','{$A["maxstories"]}'","usersettings.php?mode=preferences&msg=6");
}

###############################################################################
# MAIN

if (!empty($USER["username"]) && !empty($mode)) {
	switch ($mode) {
		case "preferences":
			site_header("menu");
			showmessage($msg);
			editpreferences();
			site_footer();
			break;
		case "comments":
			site_header("menu");
			showmessage($msg);
			editcommentprefs();
			site_footer();
			break;
		case "edit":
			site_header("menu");
			showmessage($msg);
			edituser();
			site_footer();
			break;
		case "saveuser":
			saveuser($HTTP_POST_VARS);
			break;
		case "savepreferences":
			savepreferences($HTTP_POST_VARS);
			break;
		case "savecomments":
			dbsave("usercomment","uid,commentmode,commentorder,commentlimit","'{$USER["uid"]}','$commentmode','$commentorder','$commentlimit'","usersettings.php?mode=comments&msg=7");
			break;
	}
} else {
	refresh("{$CONF["site_url"]}/index.php");
}

?>
