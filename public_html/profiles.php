<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | profiles.php                                                              |
// |                                                                           |
// | This pages lets GL users communicate with each other without risk of      |
// | their email address being intercepted by spammers.                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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
// $Id: profiles.php,v 1.42 2005/08/31 11:30:31 dhaun Exp $

require_once ('lib-common.php');

/**
* Mails the contents of the contact form to that user
*
* @param    int     $uid            User ID of person to send email to
* @param    string  $author         The name of the person sending the email
* @param    string  $authoremail    Email address of person sending the email
* @param    string  $subject        Subject of email
* @param    string  $message        Text of message to send
* @return   string                  Meta redirect or HTML for the contact form
*/
function contactemail($uid,$author,$authoremail,$subject,$message) 
{
    global $_CONF, $_TABLES, $_USER, $LANG08;

    // check for correct $_CONF permission
    if (empty ($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['emailuserloginrequired'] == 1))
        && ($uid != 2)) {
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    // check for correct 'to' user preferences
    $result = DB_query ("SELECT emailfromadmin,emailfromuser FROM {$_TABLES['userprefs']} WHERE uid = '$uid'");
    $P = DB_fetchArray ($result);
    if (SEC_inGroup ('Root') || SEC_hasRights ('user.mail')) {
        $isAdmin = true;
    } else {
        $isAdmin = false;
    }
    if ((($P['emailfromadmin'] != 1) && $isAdmin) ||
        (($P['emailfromuser'] != 1) && !$isAdmin)) {
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    // check mail speedlimit
    COM_clearSpeedlimit ($_CONF['speedlimit'], 'mail');
    if (COM_checkSpeedlimit ('mail') > 0) {
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    if (!empty($author) && !empty($subject) && !empty($message)) {
        if (COM_isemail($authoremail)) {
            $result = DB_query("SELECT username,fullname,email FROM {$_TABLES['users']} WHERE uid = $uid");
            $A = DB_fetchArray($result);

            // Append the user's signature to the message
            $sig = '';
            if ($_USER['uid'] > 1) {
                $sig = DB_getItem ($_TABLES['users'], 'sig', "uid={$_USER['uid']}");
                if (!empty ($sig)) {
                    $sig = strip_tags (COM_stripslashes ($sig));
                    $sig = "\n\n-- \n" . $sig;
                }
            }

            $subject = strip_tags (COM_stripslashes ($subject));
            $subject = substr ($subject, 0, strcspn ($subject, "\r\n"));
            $message = strip_tags (COM_stripslashes ($message)) . $sig;
            if (!empty ($A['fullname'])) {
                $to = COM_formatEmailAddress ($A['fullname'], $A['email']);
            } else {
                $to = COM_formatEmailAddress ($A['username'], $A['email']);
            }
            $from = COM_formatEmailAddress ($author, $authoremail);
            COM_mail ($to, $subject, $message, $from);
            COM_updateSpeedlimit ('mail');

            $retval .= COM_refresh($_CONF['site_url'] . '/index.php?msg=27');
		} else {
            $retval .= COM_siteHeader ('menu', $LANG04[81])
                    . COM_errorLog ($LANG08[3], 2)
                    . contactform ($uid, $subject, $message)
                    . COM_siteFooter ();
		}
	} else {
        $retval .= COM_siteHeader ('menu', $LANG04[81])
                . COM_errorLog ($LANG08[4], 2)
                . contactform ($uid, $subject, $message)
                . COM_siteFooter ();
	}

	return $retval;
}

/**
* Displays the contact form
*
* @param    int     $uid        User ID of article author
* @param    string  $subject    Subject of email
* @param    string  $message    Text of message to send
* @return   string              HTML for the contact form
*
*/
function contactform($uid, $subject='', $message='') 
{
    global $_CONF, $_TABLES, $_USER, $LANG08, $LANG_LOGIN;

    $retval = '';

    if (empty ($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['emailuserloginrequired'] == 1))) {
        $retval = COM_startBlock ($LANG_LOGIN[1], '',
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
    } else {
        $result = DB_query ("SELECT emailfromadmin,emailfromuser FROM {$_TABLES['userprefs']} WHERE uid = '$uid'");
        $P = DB_fetchArray ($result);
        if (SEC_inGroup ('Root') || SEC_hasRights ('user.mail')) {
            $isAdmin = true;
        } else {
            $isAdmin = false;
        }

        $displayname = COM_getDisplayName ($uid);
        if ((($P['emailfromadmin'] == 1) && $isAdmin) ||
            (($P['emailfromuser'] == 1) && !$isAdmin)) {

            $retval = COM_startBlock ($LANG08[10] . ' ' . $displayname);
            $mail_template = new Template ($_CONF['path_layout'] . 'profiles');
            $mail_template->set_file ('form', 'contactuserform.thtml');	
            $mail_template->set_var ('site_url', $_CONF['site_url']);
            $mail_template->set_var ('lang_description', $LANG08[26]);
            $mail_template->set_var ('lang_username', $LANG08[11]);
            $mail_template->set_var ('username', $_USER['username']);
            $mail_template->set_var ('lang_useremail', $LANG08[12]);
            $mail_template->set_var ('useremail', $_USER['email']);
            $mail_template->set_var ('lang_subject', $LANG08[13]);
            $mail_template->set_var ('subject', $subject);
            $mail_template->set_var ('lang_message', $LANG08[14]);
            $mail_template->set_var ('message', $message);
            $mail_template->set_var ('lang_nohtml', $LANG08[15]);
            $mail_template->set_var ('lang_submit', $LANG08[16]);
            $mail_template->set_var ('uid', $uid);
            $mail_template->parse ('output', 'form');
            $retval .= $mail_template->finish ($mail_template->get_var ('output'));
            $retval .= COM_endBlock ();
        } else {
            $retval = COM_startBlock ($LANG08[10] . ' ' . $displayname, '',
                              COM_getBlockTemplate ('_msg_block', 'header'));
            $retval .= $LANG08[35];
            $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block',
                                                           'footer'));
        }
    }

    return $retval;
}

/**
* Email story to a friend
*
* @param    string  $sid        id of story to email
* @param    string  $to         name of person / friend to email
* @param    string  $toemail    friend's email address
* @param    string  $from       name of person sending the email
* @param    string  $fromemail  sender's email address
* @param    string  $shortmsg   short intro text to send with the story
* @return   string              Meta refresh
*
* Modification History
*
* Date		Author		Description
* ----		------		-----------
* 4/17/01	Tony Bibbs	Code now allows anonymous users to send email
*				and it allows user to input a message as well
*				Thanks to Yngve Wassvik Bergheim for some of
*				this code
*
*/
function mailstory ($sid, $to, $toemail, $from, $fromemail, $shortmsg) 
{
 	global $_CONF, $_TABLES, $_USER, $LANG01, $LANG08;

    $retval = COM_refresh (COM_buildUrl ($_CONF['site_url']
                                         . '/article.php?story=' . $sid));

    // check for correct $_CONF permission
    if (empty ($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['emailstoryloginrequired'] == 1))) {
        return $retval;
    }

    // check if emailing of stories is disabled
    if ($_CONF['hideemailicon'] == 1) {
        return $retval;
    }

    // check mail speedlimit
    COM_clearSpeedlimit ($_CONF['speedlimit'], 'mail');
    if (COM_checkSpeedlimit ('mail') > 0) {
        return $retval;
    }

    $sql = "SELECT uid,title,introtext,bodytext,UNIX_TIMESTAMP(date) AS day FROM {$_TABLES['stories']} WHERE sid = '$sid'";
    $result = DB_query ($sql);
    $A = DB_fetchArray ($result);
    $shortmsg = COM_stripslashes ($shortmsg);
    $mailtext = sprintf ($LANG08[23], $from, $fromemail) . LB;
    if (strlen ($shortmsg) > 0) {
        $mailtext .= LB . sprintf ($LANG08[28], $from) . $shortmsg . LB;
    }

    // just to make sure this isn't an attempt at spamming users ...
    $result = PLG_checkforSpam ($mailtext, $_CONF['spamx']);
    if ($result > 0) {
        $retval = COM_refresh ($_CONF['site_url'] . '/index.php?msg=' . $result
                               . '&amp;plugin=spamx');

        return $retval;
    }

    $mailtext .= '------------------------------------------------------------'
              . LB . LB
              . COM_undoSpecialChars (stripslashes ($A['title'])) . LB
              . strftime ($_CONF['date'], $A['day']) . LB;

    if ($_CONF['contributedbyline'] == 1) {
        $author = DB_getItem ($_TABLES['users'], 'username', "uid={$A['uid']}");
        $mailtext .= $LANG01[1] . ' ' . $author . LB;
    }
    $mailtext .= LB
		. COM_undoSpecialChars(stripslashes(strip_tags($A['introtext']))).LB.LB
		. COM_undoSpecialChars(stripslashes(strip_tags($A['bodytext']))).LB.LB
		. '------------------------------------------------------------'.LB
		. $LANG08[24] . LB
        . COM_buildUrl ($_CONF['site_url'] . '/article.php?story=' . $sid
                        . '#comments');

    $mailto = COM_formatEmailAddress ($to, $toemail);
    $mailfrom = COM_formatEmailAddress ($from, $fromemail);
 	$subject = COM_undoSpecialChars(strip_tags(stripslashes('Re: '.$A['title'])));

    COM_mail ($mailto, $subject, $mailtext, $mailfrom);
    COM_updateSpeedlimit ('mail');

	// Increment numemails counter for story
    DB_query ("UPDATE {$_TABLES['stories']} SET numemails = numemails + 1 WHERE sid = '$sid'");

	return $retval;
}

/**
* Display form to email a story to someone.
*
* @param    string  $sid    ID of article to email
* @return   string          HTML for email story form
*
*/
function mailstoryform($sid)
{
    global $_CONF, $_TABLES, $_USER, $LANG08, $LANG_LOGIN;

    $retval = '';

    if (empty($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['emailstoryloginrequired'] == 1))) {
        $retval = COM_startBlock ($LANG_LOGIN[1], '',
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

    if (!empty ($_USER['username'])) {
        $result = DB_query("SELECT email FROM {$_TABLES['users']} WHERE uid = {$_USER['uid']}");
        $A = DB_fetchArray($result);

        $from = $_USER['username'];
        if (($_CONF['show_fullname'] == 1) && !empty ($_USER['fullname'])) {
            $from = $_USER['fullname'];
        }
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


// MAIN
$display = '';

if (isset ($_POST['what'])) {
    $what = COM_applyFilter ($_POST['what']);
} else if (isset ($_GET['what'])) {
    $what = COM_applyFilter ($_GET['what']);
} else {
    $what = '';
}

switch ($what) {
    case 'contact':
        $uid = COM_applyFilter ($_POST['uid'], true);
        if ($uid > 1) {
            $display .= contactemail ($uid, $_POST['author'],
                    $_POST['authoremail'], $_POST['subject'],
                    $_POST['message']);
        } else {
            $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
        }
        break;

    case 'emailstory':
        $sid = COM_applyFilter ($_GET['sid']);
        if (empty ($sid)) {
            $display = COM_refresh ($_CONF['site_url'] . '/index.php');
        } else if ($_CONF['hideemailicon'] == 1) {
            $display = COM_refresh (COM_buildUrl ($_CONF['site_url']
                                    . '/article.php?story=' . $sid));
        } else {
            $display .= COM_siteHeader ('menu', $LANG08[17])
                     . mailstoryform ($sid)
                     . COM_siteFooter ();
        }
        break;

    case 'sendstory':
        $sid = COM_applyFilter ($_POST['sid']);
        if (empty ($sid)) {
            $display = COM_refresh ($_CONF['site_url'] . '/index.php');
        } else {
            $display .= mailstory ($sid, $_POST['to'], $_POST['toemail'],
                    $_POST['from'], $_POST['fromemail'], $_POST['shortmsg']);
        }
        break;

    default:
        if (isset ($_GET['uid'])) {
            $uid = COM_applyFilter ($_GET['uid'], true);
        } else {
            $uid = 0;
        }
        if ($uid > 1) {
            $display .= COM_siteHeader ('menu', $LANG04[81])
                     . contactform ($uid)
                     . COM_siteFooter ();
        } else {
            $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
        }
        break;
}

echo $display;

?>
