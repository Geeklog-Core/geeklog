<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | profiles.php                                                              |
// | This pages let's GL user communicate with each other without risk of      |
// | their email address being intercepted by spammers.                        |
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
// $Id: profiles.php,v 1.9 2001/12/18 21:40:34 tony_bibbs Exp $

include('lib-common.php');

/**
* Mails the contents of the author contact form to that author
*
* @uid          int         User ID of person to send email to
* @author       string      The name of the person sending the email
* @authoremail  string      Email address of person sending the email
* @subject      string      Subject of email
* @message      string      Text of message to send
*
*/
function contactemail($uid,$author,$authoremail,$subject,$message) 
{
	global $_TABLES, $_CONF, $LANG08;
	
	if (!empty($author) && !empty($subject) && !empty($message)) {
		if (COM_isemail($authoremail)) {
			$result = DB_query("SELECT * FROM {$_TABLES['users']} WHERE uid = $uid");
			$A = DB_fetchArray($result);
			$tmp = urlencode($LANG08[1]);
			$RET = @mail($A['username'].' <'.$A['email'].'>'
				,strip_tags(stripslashes($subject))
				,strip_tags(stripslashes($message))
				,"From: $author <$authoremail>\n"
				."Return-Path: <$authoremail>\n"
				. "X-Mailer: GeekLog " . VERSION);
			$retval .= COM_refresh($_CONF['site_url'] . '/index.php?msg=27');
		} else {
			$retval .= COM_siteHeader("menu")
				.COM_errorLog($LANG08[3],2)
				.contactform($uid,$subject,$message)
				.COM_siteFooter();
		}
	} else {
		$retval .= COM_siteHeader("menu")
			.COM_errorLog($LANG08[4],2)
			.contactform($uid,$subject,$message)
			.COM_siteFooter();
	}
	return $retval;
}

/**
* Shows the email author form
*
* @uid          int         User ID of article author
* @subject      string      Subject of email
* @message      string      Text of message to send
*
*/
function contactform($uid, $subject='', $message='') 
{
	global $_TABLES, $HTTP_COOKIE_VARS, $_CONF, $LANG08;

    $retval = '';
	
	$result = DB_query("SELECT username FROM {$_TABLES['users']} WHERE uid = $uid");
	$A = DB_fetchArray($result);
	
	$retval .= '<form action="'.$_CONF['site_url'].'/profiles.php" method="POST" name="contact">'.LB
		.COM_startBlock($LANG08[10].' '.$A['username'])
		.'<table cellspacing="0" cellpadding="0" border="0" width="100%">'.LB
		.'<tr><td colspan="2">'.$LANG08[26].'</td></tr>'.LB
		.'<tr><td>'.$LANG08[11].'</td><td><input type="text" name="author" size="32" value="'.$_USER[0].'" maxlength="32"></td></tr>'.LB
		.'<tr><td>'.$LANG08[12].'</td><td><input type="text" name="authoremail" size="32" value="'.$_USER[1].'" maxlength="96"></td></tr>'.LB
		.'<tr><td>'.$LANG08[13].'</td><td><input type="text" name="subject" size="32" maxlength="96" value="'.$subject.'"></td></tr>'.LB
		.'<tr><td>'.$LANG08[14].'</td><td><textarea name="message" wrap="physical" rows="10" cols="50">'.$message.'</textarea></td></tr>'.LB
		.'<tr><td colspan="2" class="warning">'.$LANG08[15].'<br><input type="hidden" name="what" value="contact">'
		.'<input type="hidden" name="uid" value="'.$uid.'"><input type="submit" value="'.$LANG08[16].'"></td></tr>'.LB
		.'</table>'
		.COM_endBlock()
		.'</form>';
	
	return $retval;
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

function mailstory($sid,$to,$toemail,$from,$fromemail,$sid, $shortmsg) 
{
 	global $_TABLES, $_CONF, $LANG01, $LANG08, $A;
	
 	$sql = "SELECT *,UNIX_TIMESTAMP(date) AS day FROM {$_TABLES['stories']} WHERE sid = '$sid' ";
 	$result = DB_query($sql);
 	$A = DB_fetchArray($result);
    $shortmsg = stripslashes($shortmsg);
 	$mailtext = $LANG08[23].LB;
	if (strlen($shortmsg) > 0) {
		$mailtext .= $LANG08[28].LB;
	}
	
	$mailtext .= '------------------------------------------------------------'.LB.LB
		.$A['title'].LB
		.strftime($_CONF['date'],$A['day']).LB
		.$LANG01[1].' '.$A['author'].LB.LB
		.stripslashes(strip_tags($A['introtext'])).LB.LB
		.stripslashes(strip_tags($A['bodytext'])).LB.LB
		.'------------------------------------------------------------'.LB
		.$LANG08[24].' '.$_CONF['site_url'].'/article.php?story='.$sid.'#comments';
	
 	$mailto = $to.' <'.$toemail.'>';
 	$mailfrom = 'From: '.$from.' <'.$fromemail.'>';
 	$subject = strip_tags(stripslashes('Re: '.$A['title']));
	
 	@mail($toemail,$subject,$mailtext,$mailfrom);
 	$retval .= COM_refresh("{$_CONF['site_url']}/article.php?story=$sid");
	// Increment numemails counter for story
	$result = DB_query("SELECT numemails FROM {$_TABLES['stories']} WHERE sid = '$sid'");
	$A = DB_fetchArray($result);
	$numemails = $A['numemails'] + 1;
	DB_change($_TABLES['stories'],'numemails',$numemails,'sid',$sid);
	
	return $retval;
}

/**
* Sends the contents of the contact form to the author
*
* @sid      string      ID of article to email
*
*/
function mailstoryform($sid) 
{
    global $_TABLES, $HTTP_COOKIE_VARS, $_CONF, $LANG08, $_USER;

    $retval = '';
	
    if (!empty($_USER['username'])) {
        $result = DB_query("SELECT email FROM {$_TABLES['users']} WHERE uid = {$_USER['uid']}");
        $A = DB_fetchArray($result);
        $from = $_USER['username'];
        $fromemail = $A['email'];
    }

    $mail_template = new Template($_CONF['path_layout'] . 'profiles');
    $mail_template->set_file('form', 'contactauthorform.thtml');	
    $mail_template->set_var('site_url', $_CONF['site_url']);
    $mail_template->set_var('start_block_mailstory2friend', COM_startBlock($LANG08[17]));
    $mail_template->set_var('lang_fromname', $LANG08[20]);
    $mail_template->set_var('name', $from);
    $mail_template->set_var('lang_fromemailaddress', $LANG08[21]);
    $mail_template->set_var('email', $fromemail);
    $mail_template->set_var('lang_toname', $LANG08[18]);
    $mail_template->set_var('lang_toemailaddress', $LANG08[19]);
    $mail_template->set_var('lang_shortmessage', $LANG08[27]);
    $mail_template->set_var('lang_warning', $LANG08[22]);
    $mail_template->set_var('lang_sendmessage', $LANG08[16]);
    $mail_template->set_var('story_id',$sid);
    $mail_template->set_var('end_block', COM_endBlock());
    $mail_template->parse('output', 'form');
    $retval .= $mail_template->finish($mail_template->get_var('output'));
		
    return $retval;
}

###############################################################################
# MAIN
switch ($what) {
	case 'contact':
		$display .= contactemail($uid,$author,$authoremail,$subject,$message);
		break;
	case 'emailstory':
		$display .= COM_siteHeader() . mailstoryform($sid) . COM_siteFooter();
		break;
	case 'sendstory':
		$display .= mailstory($sid,$to,$toemail,$from,$fromemail,$sid,$shortmsg);
		break;
	default:
		if (!empty($uid)) {
			$display .= COM_siteHeader()
				.contactform($uid)
				.COM_siteFooter();
		} else {
			$display .= COM_refresh($_CONF['site_url']);
		}
}

echo $display;

?>
