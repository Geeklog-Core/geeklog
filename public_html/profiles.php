<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | profiles.php                                                              |
// |                                                                           |
// | This pages lets GL users communicate with each other without risk of      |
// | their email address being intercepted by spammers.                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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

/**
* Geeklog common function library
*/
require_once 'lib-common.php';

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
    global $_CONF, $_TABLES, $_USER, $LANG04, $LANG08;

    $retval = '';

    // check for correct $_CONF permission
    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
                             ($_CONF['emailuserloginrequired'] == 1))
                         && ($uid != 2)) {
        return COM_refresh($_CONF['site_url'] . '/index.php?msg=85');
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
        return COM_refresh ($_CONF['site_url'] . '/index.php?msg=85');
    }

    // check mail speedlimit
    COM_clearSpeedlimit ($_CONF['speedlimit'], 'mail');
    if (COM_checkSpeedlimit ('mail') > 0) {
        return COM_refresh ($_CONF['site_url'] . '/index.php?msg=85');
    }

    if (!empty($author) && !empty($subject) && !empty($message)) {
        if (COM_isemail($authoremail) && (strpos($author, '@') === false)) {
            $result = DB_query("SELECT username,fullname,email FROM {$_TABLES['users']} WHERE uid = $uid");
            $A = DB_fetchArray($result);

            // Append the user's signature to the message
            $sig = '';
            if (!COM_isAnonUser()) {
                $sig = DB_getItem($_TABLES['users'], 'sig',
                                  "uid={$_USER['uid']}");
                if (!empty ($sig)) {
                    $sig = strip_tags (COM_stripslashes ($sig));
                    $sig = "\n\n-- \n" . $sig;
                }
            }

            $subject = COM_stripslashes ($subject);
            $message = COM_stripslashes ($message);

            // do a spam check with the unfiltered message text and subject
            $mailtext = $subject . "\n" . $message . $sig;
            $result = PLG_checkforSpam ($mailtext, $_CONF['spamx']);
            if ($result > 0) {
                COM_updateSpeedlimit ('mail');
                COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
            }

            $msg = PLG_itemPreSave ('contact', $message);
            if (!empty ($msg)) {
                $retval .= COM_siteHeader ('menu', '')
                        . COM_errorLog ($msg, 2)
                        . contactform ($uid, $subject, $message)
                        . COM_siteFooter ();

                return $retval;
            }

            $subject = strip_tags ($subject);
            $subject = substr ($subject, 0, strcspn ($subject, "\r\n"));
            $message = strip_tags ($message) . $sig;
            if (!empty ($A['fullname'])) {
                $to = COM_formatEmailAddress ($A['fullname'], $A['email']);
            } else {
                $to = COM_formatEmailAddress ($A['username'], $A['email']);
            }
            $from = COM_formatEmailAddress ($author, $authoremail);

            $sent = COM_mail($to, $subject, $message, $from);

            if ($sent && isset($_POST['cc']) && ($_POST['cc'] == 'on')) {
                $ccmessage = sprintf($LANG08[38], COM_getDisplayName($uid,
                                            $A['username'], $A['fullname']));
                $ccmessage .= "\n------------------------------------------------------------\n\n" . $message;

                $sent = COM_mail($from, $subject, $ccmessage, $from);
            }

            COM_updateSpeedlimit('mail');

            $retval .= COM_refresh($_CONF['site_url']
                                   . '/users.php?mode=profile&amp;uid=' . $uid
                                   . '&amp;msg=' . ($sent ? '27' : '85'));
        } else {
            $subject = strip_tags ($subject);
            $subject = substr ($subject, 0, strcspn ($subject, "\r\n"));
            $subject = htmlspecialchars (trim ($subject), ENT_QUOTES);
            $retval .= COM_siteHeader ('menu', $LANG04[81])
                    . COM_errorLog ($LANG08[3], 2)
                    . contactform ($uid, $subject, $message)
                    . COM_siteFooter ();
        }
    } else {
        $subject = strip_tags ($subject);
        $subject = substr ($subject, 0, strcspn ($subject, "\r\n"));
        $subject = htmlspecialchars (trim ($subject), ENT_QUOTES);
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
function contactform ($uid, $subject = '', $message = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG08;

    $retval = '';

    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
                             ($_CONF['emailuserloginrequired'] == 1))) {
        $retval .= SEC_loginRequiredForm();
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

            $retval = COM_startBlock($LANG08[10] . ' ' . $displayname);
            $mail_template = new Template($_CONF['path_layout'] . 'profiles');
            $mail_template->set_file('form', 'contactuserform.thtml');
            $mail_template->set_var('xhtml', XHTML);
            $mail_template->set_var('site_url', $_CONF['site_url']);
            $mail_template->set_var('site_admin_url', $_CONF['site_admin_url']);
            $mail_template->set_var('layout_url', $_CONF['layout_url']);
            $mail_template->set_var('lang_description', $LANG08[26]);
            $mail_template->set_var('lang_username', $LANG08[11]);
            if (COM_isAnonUser()) {
                $sender = '';
                if (isset ($_POST['author'])) {
                    $sender = strip_tags ($_POST['author']);
                    $sender = substr ($sender, 0, strcspn ($sender, "\r\n"));
                    $sender = htmlspecialchars (trim ($sender), ENT_QUOTES);
                }
                $mail_template->set_var ('username', $sender);
            } else {
                $mail_template->set_var ('username',
                        COM_getDisplayName ($_USER['uid'], $_USER['username'],
                                            $_USER['fullname']));
            }
            $mail_template->set_var ('lang_useremail', $LANG08[12]);
            if (COM_isAnonUser()) {
                $email = '';
                if (isset ($_POST['authoremail'])) {
                    $email = strip_tags ($_POST['authoremail']);
                    $email = substr ($email, 0, strcspn ($email, "\r\n"));
                    $email = htmlspecialchars (trim ($email), ENT_QUOTES);
                }
                $mail_template->set_var ('useremail', $email);
            } else {
                $mail_template->set_var ('useremail', $_USER['email']);
            }
            $mail_template->set_var('lang_cc', $LANG08[36]);
            $mail_template->set_var('lang_cc_description', $LANG08[37]);
            $mail_template->set_var('lang_subject', $LANG08[13]);
            $mail_template->set_var('subject', $subject);
            $mail_template->set_var('lang_message', $LANG08[14]);
            $mail_template->set_var('message', htmlspecialchars($message));
            $mail_template->set_var('lang_nohtml', $LANG08[15]);
            $mail_template->set_var('lang_submit', $LANG08[16]);
            $mail_template->set_var('uid', $uid);
            PLG_templateSetVars('contact', $mail_template);
            $mail_template->parse('output', 'form');
            $retval .= $mail_template->finish($mail_template->get_var('output'));
            $retval .= COM_endBlock();
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
* Date        Author        Description
* ----        ------        -----------
* 4/17/01    Tony Bibbs    Code now allows anonymous users to send email
*                and it allows user to input a message as well
*                Thanks to Yngve Wassvik Bergheim for some of
*                this code
*
*/
function mailstory($sid, $to, $toemail, $from, $fromemail, $shortmsg)
{
    global $_CONF, $_TABLES, $LANG01, $LANG08;

    require_once $_CONF['path_system'] . 'lib-story.php';

    $storyurl = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $sid);
    if ($_CONF['url_rewrite']) {
        $retval = COM_refresh($storyurl . '?msg=85');
    } else {
        $retval = COM_refresh($storyurl . '&amp;msg=85');
    }

    // check for correct $_CONF permission
    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
                             ($_CONF['emailstoryloginrequired'] == 1))) {
        return $retval;
    }

    // check if emailing of stories is disabled
    if ($_CONF['hideemailicon'] == 1) {
        return $retval;
    }

    // check mail speedlimit
    COM_clearSpeedlimit($_CONF['speedlimit'], 'mail');
    if (COM_checkSpeedlimit('mail') > 0) {
        return $retval;
    }

    $story = new Story();
    $result = $story->loadFromDatabase($sid, 'view');

    if ($result != STORY_LOADED_OK) {
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }

    $shortmsg = COM_stripslashes ($shortmsg);
    $mailtext = sprintf ($LANG08[23], $from, $fromemail) . LB;
    if (strlen ($shortmsg) > 0) {
        $mailtext .= LB . sprintf ($LANG08[28], $from) . $shortmsg . LB;
    }

    // just to make sure this isn't an attempt at spamming users ...
    $result = PLG_checkforSpam ($mailtext, $_CONF['spamx']);
    if ($result > 0) {
        COM_updateSpeedlimit ('mail');
        COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
    }

    $mailtext .= '------------------------------------------------------------'
              . LB . LB
              . COM_undoSpecialChars($story->displayElements('title')) . LB
              . strftime ($_CONF['date'], $story->DisplayElements('unixdate')) . LB;

    if ($_CONF['contributedbyline'] == 1) {
        $author = COM_getDisplayName($story->displayElements('uid'));
        $mailtext .= $LANG01[1] . ' ' . $author . LB;
    }

    $introtext = $story->DisplayElements('introtext');
    $bodytext  = $story->DisplayElements('bodytext');
    $introtext = COM_undoSpecialChars(strip_tags($introtext));
    $bodytext  = COM_undoSpecialChars(strip_tags($bodytext));

    $introtext = str_replace(array("\012\015", "\015"), LB, $introtext);
    $bodytext  = str_replace(array("\012\015", "\015"), LB, $bodytext);

    $mailtext .= LB . $introtext;
    if (! empty($bodytext)) {
        $mailtext .= LB . LB . $bodytext;
    }
    $mailtext .= LB . LB 
        . '------------------------------------------------------------' . LB;

    if ($story->DisplayElements('commentcode') == 0) { // comments allowed
        $mailtext .= $LANG08[24] . LB
                  . COM_buildUrl ($_CONF['site_url'] . '/article.php?story='
                                  . $sid . '#comments');
    } else { // comments not allowed - just add the story's URL
        $mailtext .= $LANG08[33] . LB
                  . COM_buildUrl ($_CONF['site_url'] . '/article.php?story='
                                  . $sid);
    }

    $mailto = COM_formatEmailAddress($to, $toemail);
    $mailfrom = COM_formatEmailAddress($from, $fromemail);
    $subject = 'Re: ' . COM_undoSpecialChars(strip_tags($story->DisplayElements('title')));

    $sent = COM_mail($mailto, $subject, $mailtext, $mailfrom);

    if ($sent && isset($_POST['cc']) && ($_POST['cc'] == 'on')) {
        $ccmessage = sprintf($LANG08[38], $to);
        $ccmessage .= "\n------------------------------------------------------------\n\n" . $mailtext;

        $sent = COM_mail($mailfrom, $subject, $ccmessage, $mailfrom);
    }

    COM_updateSpeedlimit ('mail');

    // Increment numemails counter for story
    DB_query ("UPDATE {$_TABLES['stories']} SET numemails = numemails + 1 WHERE sid = '$sid'");

    if ($_CONF['url_rewrite']) {
        $retval = COM_refresh($storyurl . '?msg=' . ($sent ? '27' : '85'));
    } else {
        $retval = COM_refresh($storyurl . '&amp;msg=' . ($sent ? '27' : '85'));
    }

    return $retval;
}

/**
* Display form to email a story to someone.
*
* @param    string  $sid    ID of article to email
* @return   string          HTML for email story form
*
*/
function mailstoryform ($sid, $to = '', $toemail = '', $from = '',
                        $fromemail = '', $shortmsg = '', $msg = 0)
{
    global $_CONF, $_TABLES, $_USER, $LANG08;

    require_once $_CONF['path_system'] . 'lib-story.php';

    $retval = '';

    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
                             ($_CONF['emailstoryloginrequired'] == 1))) {
        $retval .= SEC_loginRequiredForm();

        return $retval;
    }

    $story = new Story();
    $result = $story->loadFromDatabase($sid, 'view');

    if ($result != STORY_LOADED_OK) {
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }

    if ($msg > 0) {
        $retval .= COM_showMessage ($msg);
    }

    if (empty ($from) && empty ($fromemail)) {
        if (!COM_isAnonUser()) {
            $from = COM_getDisplayName ($_USER['uid'], $_USER['username'],
                                        $_USER['fullname']);
            $fromemail = DB_getItem ($_TABLES['users'], 'email',
                                     "uid = {$_USER['uid']}");
        }
    }

    $mail_template = new Template($_CONF['path_layout'] . 'profiles');
    $mail_template->set_file('form', 'contactauthorform.thtml');
    $mail_template->set_var('xhtml', XHTML);
    $mail_template->set_var('site_url', $_CONF['site_url']);
    $mail_template->set_var('site_admin_url', $_CONF['site_admin_url']);
    $mail_template->set_var('layout_url', $_CONF['layout_url']);
    $mail_template->set_var('start_block_mailstory2friend',
                            COM_startBlock($LANG08[17]));
    $mail_template->set_var('lang_title', $LANG08[31]);
    $mail_template->set_var('story_title', $story->displayElements('title'));
    $url = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $sid);
    $mail_template->set_var('story_url', $url);
    $link = COM_createLink($story->displayElements('title'), $url);
    $mail_template->set_var('story_link', $link);
    $mail_template->set_var('lang_fromname', $LANG08[20]);
    $mail_template->set_var('name', $from);
    $mail_template->set_var('lang_fromemailaddress', $LANG08[21]);
    $mail_template->set_var('email', $fromemail);
    $mail_template->set_var('lang_toname', $LANG08[18]);
    $mail_template->set_var('toname', $to);
    $mail_template->set_var('lang_toemailaddress', $LANG08[19]);
    $mail_template->set_var('toemail', $toemail);
    $mail_template->set_var('lang_cc', $LANG08[36]);
    $mail_template->set_var('lang_cc_description', $LANG08[37]);
    $mail_template->set_var('lang_shortmessage', $LANG08[27]);
    $mail_template->set_var('shortmsg', htmlspecialchars($shortmsg));
    $mail_template->set_var('lang_warning', $LANG08[22]);
    $mail_template->set_var('lang_sendmessage', $LANG08[16]);
    $mail_template->set_var('story_id',$sid);
    $mail_template->set_var('end_block', COM_endBlock());
    PLG_templateSetVars('emailstory', $mail_template);
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
        $sid = COM_applyFilter($_POST['sid']);
        if (empty($sid)) {
            $display = COM_refresh($_CONF['site_url'] . '/index.php');
        } else {
            if (empty($_POST['toemail']) || empty($_POST['fromemail']) ||
                    !COM_isEmail($_POST['toemail']) ||
                    !COM_isEmail($_POST['fromemail']) ||
                    (strpos($_POST['to'], '@') !== false) ||
                    (strpos($_POST['from'], '@') !== false)) {
                $display .= COM_siteHeader('menu', $LANG08[17])
                         . mailstoryform ($sid, COM_applyFilter($_POST['to']),
                                COM_applyFilter($_POST['toemail']),
                                COM_applyFilter($_POST['from']),
                                COM_applyFilter($_POST['fromemail']),
                                $_POST['shortmsg'], 52)
                         . COM_siteFooter();
            } else if (empty($_POST['to']) || empty($_POST['from']) ||
                    empty($_POST['shortmsg'])) {
                $display .= COM_siteHeader ('menu', $LANG08[17])
                         . COM_showMessageText($LANG08[22])
                         . mailstoryform($sid, COM_applyFilter($_POST['to']),
                                COM_applyFilter($_POST['toemail']),
                                COM_applyFilter($_POST['from']),
                                COM_applyFilter($_POST['fromemail']),
                                $_POST['shortmsg'])
                         . COM_siteFooter();
            } else {
                $msg = PLG_itemPreSave('emailstory', $_POST['shortmsg']);
                if (!empty($msg)) {
                    $display .= COM_siteHeader('menu', $LANG08[17])
                             . COM_errorLog($msg, 2)
                             . mailstoryform($sid, COM_applyFilter($_POST['to']),
                                COM_applyFilter($_POST['toemail']),
                                COM_applyFilter($_POST['from']),
                                COM_applyFilter($_POST['fromemail']),
                                $_POST['shortmsg'])
                             . COM_siteFooter();
                } else {
                    $display .= mailstory($sid, $_POST['to'], $_POST['toemail'],
                        $_POST['from'], $_POST['fromemail'], $_POST['shortmsg']);
                }
            }
        }
        break;

    default:
        if (isset ($_GET['uid'])) {
            $uid = COM_applyFilter ($_GET['uid'], true);
        } else {
            $uid = 0;
        }
        if ($uid > 1) {
            $subject = '';
            if (isset ($_GET['subject'])) {
                $subject = strip_tags ($_GET['subject']);
                $subject = substr ($subject, 0, strcspn ($subject, "\r\n"));
                $subject = htmlspecialchars (trim ($subject), ENT_QUOTES);
            }
            $display .= COM_siteHeader ('menu', $LANG04[81])
                     . contactform ($uid, $subject)
                     . COM_siteFooter ();
        } else {
            $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
        }
        break;
}

COM_output($display);

?>
