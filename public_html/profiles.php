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
include('lib-common.php');
###############################################################################
# Sends the contents of the contact form to the author
function contactemail($uid,$author,$authoremail,$subject,$message) {
	global $CONF,$LANG08, $VERSION;
	
	if (!empty($author) && !empty($subject) && !empty($message)) {
		if (isemail($authoremail)) {
			$result = dbquery("SELECT * FROM {$CONF['db_prefix']}users WHERE uid = $uid");
			$A = mysql_fetch_array($result);
			$tmp = urlencode($LANG08[1]);
			$RET = @mail($A['username'].' <'.$A['email'].'>'
				,strip_tags(stripslashes($subject))
				,strip_tags(stripslashes($message))
				,"From: $author <$authoremail>\n"
				."Return-Path: <$authoremail>\n"
				."X-Mailer: GeekLog $VERSION");
			$retval .= refresh($CONF['site_url'] . "/index.php?msg=27");
		} else {
			$retval .= site_header("menu")
				.errorlog($LANG08[3],2)
				.contactform($uid,$subject,$message)
				.site_footer();
		}
	} else {
		$retval .= site_header("menu")
			.errorlog($LANG08[4],2)
			.contactform($uid,$subject,$message)
			.site_footer();
	}
	return $retval;
}

###############################################################################
# Sends the contents of the contact form to the author
function contactform($uid,$subject='',$message='') {
	global $HTTP_COOKIE_VARS,$CONF,$LANG08;
	
	
	$result = dbquery("SELECT username FROM {$CONF['db_prefix']}users WHERE uid = $uid");
	$A = mysql_fetch_array($result);
	
	$retval .= '<form action="'.$CONF['site_url'].'/profiles.php" method="POST" name="contact">'.LB
		.startblock($LANG08[10].' '.$A['username'])
		.'<table cellspacing="0" cellpadding="0" border="0" width="100%">'.LB
		.'<tr><td colspan="2">'.$LANG08[26].'</td></tr>'.LB
		.'<tr><td>'.$LANG08[11].'</td><td><input type="text" name="author" size="32" value="'.$USER[0].'" maxlength="32"></td></tr>'.LB
		.'<tr><td>'.$LANG08[12].'</td><td><input type="text" name="authoremail" size="32" value="'.$USER[1].'" maxlength="96"></td></tr>'.LB
		.'<tr><td>'.$LANG08[13].'</td><td><input type="text" name="subject" size="32" maxlength="96" value="'.$subject.'"></td></tr>'.LB
		.'<tr><td>'.$LANG08[14].'</td><td><textarea name="message" wrap="physical" rows="10" cols="50">'.$message.'</textarea></td></tr>'.LB
		.'<tr><td colspan="2" class="warning">'$LANG08[15].'<br><input type="hidden" name="what" value="contact">'
		.'<input type="hidden" name="uid" value="'.$uid.'"><input type="submit" value="'.$LANG08[16].'"></td></tr>'.LB
		.'</table>'
		.endblock()
		.'</form>';
	
	return $retval
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
 	$mailtext = $LANG08[23].LB;
	if (strlen($shortmsg) > 0) {
		$mailtext .= $LANG08[28].LB;
	}
	
	$mailtext .= '------------------------------------------------------------'.LB.LB
		.$A['title'].LB
		.strftime($CONF['date'],$A['day']).LB
		.$LANG01[1].' '.$A['author'].LB.LB
		.stripslashes(strip_tags($A['introtext'])).LB
		.stripslashes(strip_tags($A['bodytext'])).LB.LB
		.'------------------------------------------------------------'.LB
		.$LANG08[24].' '.$CONF['site_url'].'/article.php?story=$sid#comments';
	
 	$mailto = $to.' <'.$toemail.'>';
 	$mailfrom = 'From: '.$from.' <'.$fromemail.'>';
 	$subject = strip_tags(stripslashes('Re: '.$A['title']));
	
 	@mail($toemail,$subject,$mailtext,$mailfrom);
 	$retval .= refresh("{$CONF['site_url']}/article.php?story=$sid");
	# Increment numemails counter for story
	$result = dbquery("SELECT numemails FROM stories WHERE sid = '$sid'");
	$A = mysql_fetch_array($result);
	$numemails = $A['numemails'] + 1;
	dbchange('stories','numemails',$numemails,'sid',$sid);
	
	return $retval;
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
	
	
 	$retval .= startblock($LANG08[17]); 
	
 	if (!empty($USER['name'])) {
  		$result = dbquery("SELECT email FROM {$CONF['db_prefix']}users WHERE uid = {$USER['uid']}");
  		$A = mysql_fetch_array($result);
  		$from = $USER['name'];
  		$fromemail = $A['email'];
 	}
	
  	$retval .= '<table>'.LB
		.'<form action="'.$CONF['site_url'].'/profiles.php" method="POST" name="contact">'
		.'<table cellspacing="0" cellpadding="3" border="0" width="100%">'.LB;
  
 	if (!empty($USER['name'])) {
  		$retval .= '<tr>'.LB
			.'<td align="right"><b>'.$LANG08[20].':</b></td>'.LB
			.'<td><input type="hidden" name="from" value="'.$from.'"><input type="hidden" name="fromemail" value="'.$fromemail.'">'.$from.'</td>'.LB
			.'</tr>'.LB
 	} else {
  		$retval .= '<tr>'.LB
			.'<td align="right"><b>'.$LANG08[20].':</b></td>'.LB
			.'<td><input type="text" name="from" size="20" maxlength="96"></td>'.LB
			.'</tr>'.LB
			.'<tr>'.LB
			.'<td align="right"><b>'.$LANG08[21].':</b></td>'.LB
			.'<td><input type="text" name="fromemail" size="20" maxlength="96"></td>'.LB
			.'</tr>'.LB
 	}
	
  	$retval .= '<tr>'.LB
		.'<td align="right"><b>'.$LANG08[18].':</b></td>'.LB
		.'<td><input type="text" name="to" size="20" maxlength="96" value="'.$to.'"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="righ"><b>'.$LANG08[19].':</b></td>'.LB
		.'<td><input type="text" name="toemail" size="20" maxlength="96" value="'.$toemail.'"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right" valign="top"><b>'.$LANG08[27].':</b></td>'.LB
		.'<td><textarea name="shortmsg" rows="8" cols="30" wrap="virtual"></textarea></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2" class="warning"><br>'.$LANG08[22].'<br>'.LB
		.'<br><input type="hidden" name="sid" value="'.$sid.'">'
		.'<input type="hidden" name="what" value="sendstory">'
		.'<input type="submit" value="'.$LANG08[16].'"></td>'.LB
		.'</tr>'.LB
		.'</table>'.LB
		.'</form>'
		.endblock();
		
	return $retval;
}

###############################################################################
# MAIN
switch ($what) {
	case 'contact':
		$display .= contactemail($uid,$author,$authoremail,$subject,$message);
		break;
	case 'emailstory':
		$display .= site_header()
			.mailstoryform($sid)
			.site_footer();
		break;
	case 'sendstory':
		$display .= mailstory($sid,$to,$toemail,$from,$fromemail,$sid,$shortmsg);
		break;
	default:
		if (!empty($uid)) {
			$display .= site_header()
				.contactform($uid)
				.site_footer();
		} else {
			$display .= refresh($CONF['site_url']);
		}
}
echo $dislay;
?>
