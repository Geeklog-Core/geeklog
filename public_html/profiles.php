<?php

###############################################################################
# profiles.php
# This is the profiles page to protect us from spammers!
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
# Sends the contents of the contact form to the author

function contactemail($uid,$author,$authoremail,$subject,$message) {
	global $CONF,$LANG08;
	if (!empty($author) && !empty($subject) && !empty($message)) {
		if (isemail($authoremail)) {
			$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}users WHERE uid = $uid");
			$A = mysql_fetch_array($result);
			$tmp	= urlencode($LANG08[1]);
			$RET	= @mail("{$A["username"]} <{$A["email"]}>",
			strip_tags(stripslashes($subject)),
			strip_tags(stripslashes($message)),
			"From: $author <$authoremail>\nReturn-Path: <$authoremail>\nX-Mailer: GeekLog $VERSION");
			refresh($CONF["site_url"] . "/index.php?msg=27");
		} else {
			site_header("menu");
			errorlog($LANG08[3],2);
			contactform($uid,$subject,$message);
			site_footer();
		}
	} else {
		site_header("menu");
		errorlog($LANG08[4],2);
		contactform($uid,$subject,$message);
		site_footer();
	}
}

###############################################################################
# Sends the contents of the contact form to the author

function contactform($uid,$subject="",$message="") {
	global $HTTP_COOKIE_VARS,$CONF,$LANG08;
	$result = dbquery("SELECT username FROM {$CONF["db_prefix"]}users WHERE uid = $uid");
	$A = mysql_fetch_array($result);
	print "<form action={$CONF["site_url"]}/profiles.php method=POST name=contact>";
	startblock("{$LANG08[10]} {$A["username"]}");
	print "<table cellspacing=0 cellpadding=0 border=0 width=\"100%\">";
	print "<tr><td colspan=2>{$LANG08[26]}<p></td></tr>";
	print "<tr><td>{$LANG08[11]}</td><td><input type=text name=author size=32 value=\"$USER[0]\" maxlength=32></td></tr>";
	print "<tr><td>{$LANG08[12]}</td><td><input type=text name=authoremail size=32 value=\"$USER[1]\" maxlength=96></td></tr>";
	print "<tr><td>{$LANG08[13]}</td><td><input type=text name=subject size=32 maxlength=96 value=\"$subject\"></td></tr>";
	print "<tr><td>{$LANG08[14]}</td><td><textarea name=message wrap=physical rows=10 cols=40>$message</textarea></td></tr>";
	print "<tr><td colspan=2 class=warning><br>{$LANG08[15]}<br><br><input type=hidden name=what value=contact>";
	print "<input type=hidden name=uid value=$uid><input type=submit value=\"{$LANG08[16]}\"></td></tr></table>";
	endblock();
	print "</form>";
}

###############################################################################
# Sends the contents of the contact form to the author
#
# Modification History
#
# Date		Author		Description
# ----		------		-----------
# 4/17/01	Tony Bibbs	Code now allows anonymous users to send email
#				and it allows user to input a message as well
#				Thanks to Yngve Wassvik Bergheim for some of
#				this code
#

function mailstory($sid,$to,$toemail,$from,$fromemail,$sid, $shortmsg) {
 	global $CONF,$LANG01,$LANG08,$A;
 	$sql = "SELECT *,UNIX_TIMESTAMP(date) AS day from stories WHERE sid = '$sid' ";
 	$result = dbquery($sql);
 	$A = mysql_fetch_array($result);
 	$mailtext ="{$LANG08[23]}\n";
	if (strlen($shortmsg) > 0)
		$mailtext = $mailtext . "{$LANG08[28]}\n";
	$mailtext = $mailtext . "------------------------------------------------------------\n\n{$A["title"]}\n";
 	$mailtext .= strftime($CONF["date"],$A["day"]) . "\n";
 	$mailtext .= "{$LANG01[1]} {$A["author"]}\n\n";
	# removed the nl2br(). Just a bug 
	$mailtext .= (stripslashes(strip_tags($A["introtext"]))) . "\n";
 	$mailtext .= (stripslashes(strip_tags($A["bodytext"])));
 	$mailtext .= "\n\n------------------------------------------------------------\n";
 	$mailtext .= "{$LANG08[24]} {$CONF["site_url"]}/article.php?story=$sid#comments";
 	$mailto = "{$to} <{$toemail}>";
 	$mailfrom = "From: {$from} <{$fromemail}>";
 	$subject = strip_tags(stripslashes("Re: {$A["title"]}"));
 	@mail($toemail,$subject,$mailtext,$mailfrom);
 	refresh("{$CONF["site_url"]}/article.php?story=$sid");
}

###############################################################################
# Sends the contents of the contact form to the author
#
# Modification History
#
# Date          Author          Description
# ----          ------          -----------
# 4/17/01       Tony Bibbs      Code now allows anonymous users to send email
#                               and it allows user to input a message as well
#                               Thanks to Yngve Wassvik Bergheim for some of
#                               this code
#

function mailstoryform($sid) {
 	global $HTTP_COOKIE_VARS,$CONF,$LANG08,$USER;
 	startblock($LANG08[17]); 
 	if (!empty($USER["name"])) {
  		$result = dbquery("SELECT email FROM {$CONF["db_prefix"]}users WHERE uid = {$USER["uid"]}");
  		$A = mysql_fetch_array($result);
  		$from = $USER["name"];
  		$fromemail = $A["email"];
 	}
  	print "<table>\n";
  	print "<form action={$CONF["site_url"]}/profiles.php method=POST name=contact>";
  	print "<table cellspacing=0 cellpadding=3 border=0 width=\"100%\">";
  
 	if (!empty($USER["name"])) {
  		print "<tr><td align=right><b>{$LANG08[20]}:</b></td><td>";
  		print "<input type=hidden name=from value=\"$from\">$from</td></tr>\n";
  		print "<input type=hidden name=fromemail value=\"$fromemail\">\n";
 	} else {
  		print "<tr><td align=right><b>{$LANG08[20]}:</b></td><td><input type=text name=from size=20 maxlength=96></td></tr>\n";
  		print "<tr><td align=right><b>{$LANG08[21]}:</b></td><td><input type=text name=fromemail size=20 maxlength=96></td></tr>\n";
 	}
  	print "<tr><td align=right><b>{$LANG08[18]}:</b></td><td><input type=text name=to size=20
	maxlength=96 value=\"$to\"></td></tr>\n";
  	print "<tr><td align=right><b>{$LANG08[19]}:</b></td><td><input type=text name=toemail size=20 maxlength=96 value=\"$toemail\"></td></tr>\n";
 	print "<tr><td align=right valign=top><b>{$LANG08[27]}:</b></td><td><textarea name=shortmsg rows=8 cols=30 wrap=virtual></textarea></td></tr>\n";	
  	print "<tr><td colspan=2 class=warning><br>{$LANG08[22]}<br><br>\n";  
  	print "<input type=hidden name=sid value=$sid>";
  	print "<input type=hidden name=what value=sendstory>\n";
  	print "<input type=submit value=\"{$LANG08[16]}\"></td></tr></table>\n";
  	print "</form>\n";
 	endblock();
}

###############################################################################
# MAIN

switch ($what) {
	case "contact":
		contactemail($uid,$author,$authoremail,$subject,$message);
		break;
	case "emailstory":
		site_header("menu");
		mailstoryform($sid);
		site_footer();
		break;
	case "sendstory":
		mailstory($sid,$to,$toemail,$from,$fromemail,$sid,$shortmsg);
		break;
	default:
		if (!empty($uid)) {
			site_header("menu");
			contactform($uid);
			site_footer();
		} else {
			refresh($CONF["site_url"]);
		}
}

?>
