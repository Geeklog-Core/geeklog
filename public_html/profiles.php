<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | profiles.php                                                              |
// |                                                                           |
// | This pages lets GL users communicate with each other without risk of      |
// | their email address being intercepted by spammers.                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2021 by the following authors:                         |
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
* @param    bool    $cc             Whether to send a copy of the message to the author
* @param    string  $author         The name of the person sending the email
* @param    string  $authorEmail    Email address of person sending the email
* @param    string  $subject        Subject of email
* @param    string  $message        Text of message to send
* @return   string                  Meta redirect or HTML for the contact form
*/
function contactemail($uid, $cc, $author, $authorEmail, $subject, $message)
{
    global $_CONF, $_TABLES, $_USER, $LANG04, $LANG08, $LANG12;

    $retval = '';

    // check for correct $_CONF permission
    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
                             ($_CONF['emailuserloginrequired'] == 1))
                         && ($uid != 2)) {
        COM_redirect($_CONF['site_url'] . '/index.php?msg=85');
    }

    // check for correct 'to' user preferences
    $result = DB_query("SELECT emailfromadmin,emailfromuser FROM {$_TABLES['userprefs']} WHERE uid = '$uid'");
    $P = DB_fetchArray($result);
    $isAdmin = SEC_inGroup('Root') || SEC_hasRights('user.mail');
    if ((($P['emailfromadmin'] != 1) && $isAdmin) ||
        (($P['emailfromuser'] != 1) && !$isAdmin)) {
        COM_redirect($_CONF['site_url'] . '/index.php?msg=85');
    }

    // check mail speedlimit
    COM_clearSpeedlimit($_CONF['speedlimit'], 'mail');
    $last = COM_checkSpeedlimit('mail');
    if ($last > 0) {
        $retval = COM_showMessageText($LANG08[39] . $last . $LANG08[40], $LANG12[26]);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[81]));

        return $retval;
    }

    if (!empty($author) && !empty($subject) && !empty($message)) {
        if (COM_isemail($authorEmail) && (strpos($author, '@') === false)) {
            $result = DB_query("SELECT username,fullname,email FROM {$_TABLES['users']} WHERE uid = $uid");
            $A = DB_fetchArray($result);

            // Append the user's signature to the message
            $sig = '';
            if (!COM_isAnonUser()) {
                $sig = DB_getItem($_TABLES['users'], 'sig',
                                  "uid={$_USER['uid']}");
                if (!empty($sig)) {
                    $sig = GLText::stripTags($sig);
                    $sig = "\n\n-- \n" . $sig;
                }
            }

            // do a spam check with the unfiltered message text and subject
            $mailtext = $subject . "\n" . $message . $sig;
            $permanentlink = null; // Setting this to null as this is a stand alone email. There is no permantlink that the email is being added too (like a comment on a blog post)
            $result = PLG_checkForSpam(
                $mailtext, $_CONF['spamx'], $permanentlink, Geeklog\Akismet::COMMENT_TYPE_CONTACT_FORM,
                $author, $authorEmail
            );
            if ($result > PLG_SPAM_NOT_FOUND) {
                COM_updateSpeedlimit('mail');
                COM_displayMessageAndAbort($result, 'spamx', 403, 'Forbidden');
            }

            $msg = PLG_itemPreSave('contact', $message);
            if (!empty($msg)) {
                $retval = COM_errorLog($msg, 2)
                        . contactform($uid, $cc, $subject, $message);
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[81]));

                return $retval;
            }

            $subject = GLText::stripTags($subject);
            $subject = substr($subject, 0, strcspn($subject, "\r\n"));
            $message = GLText::stripTags($message) . $sig;
            if (!empty($A['fullname'])) {
                $to = array($A['email'] => $A['fullname']);
            } else {
                $to = array($A['email'] => $A['username']);
            }
            $from = array($authorEmail => $author);

            $sent = COM_mail($to, $subject, $message, $from);

            if ($sent && $_CONF['mail_cc_enabled'] && (Geeklog\Input::post('cc') === 'on')) {
                $ccmessage = sprintf($LANG08[38], COM_getDisplayName($uid, $A['username'], $A['fullname'])) . "\n"
                           . $LANG08[45]
                           . "\n------------------------------------------------------------\n\n" . $message;

                $sent = COM_mail($from, $subject, $ccmessage, $_CONF['noreply_mail']);
            }

            COM_updateSpeedlimit('mail');
            COM_redirect(
                $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $uid . '&amp;msg='
                . ($sent ? '27' : '85')
            );
        } else {
            $subject = GLText::stripTags($subject);
            $subject = substr($subject, 0, strcspn($subject, "\r\n"));
            $subject = htmlspecialchars(trim($subject), ENT_QUOTES);
            $retval = COM_errorLog($LANG08[3], 2)
                    . contactform($uid, $cc, $subject, $message);
            $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[81]));
        }
    } else {
        $subject = GLText::stripTags($subject);
        $subject = substr($subject, 0, strcspn($subject, "\r\n"));
        $subject = htmlspecialchars(trim($subject), ENT_QUOTES);
        $retval = COM_errorLog($LANG08[4], 2)
                . contactform($uid, $cc, $subject, $message);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[81]));
    }

    return $retval;
}

/**
* Displays the contact form
*
* @param    int     $uid        User ID of article author
* @param    bool    $cc         Whether to send a copy of the message to the author
* @param    string  $subject    Subject of email
* @param    string  $message    Text of message to send
* @return   string              HTML for the contact form
*
*/
function contactform($uid, $cc = false, $subject = '', $message = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG08;

    $retval = '';

    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
                             ($_CONF['emailuserloginrequired'] == 1))) {
        $retval .= SEC_loginRequiredForm();
    } else {
        $isAdmin = SEC_inGroup('Root') || SEC_hasRights('user.mail');

        // Check email address okay and user preference regarding email
        $continue = false;
        $msg_no_mail = $LANG08[35];

        $result = DB_query("SELECT email, status FROM {$_TABLES['users']} WHERE uid = '$uid'");
        $nrows = DB_numRows($result);                                     
        
        if ($nrows == 1) {
            $P = DB_fetchArray($result);
            
            if ($P['status'] == USER_ACCOUNT_ACTIVE || $P['status'] == USER_ACCOUNT_NEW_PASSWORD) {
                if (!empty($P['email'])) {
                    if (COM_isEMail($P['email'])) {
                        $continue = true;
                    } elseif ($isAdmin) {
                        $msg_no_mail = $LANG08[43]; // Email invalid
                    }
                } elseif ($isAdmin) {
                    $msg_no_mail = $LANG08[42]; // Email doesn't exist
                }
            } elseif ($isAdmin) {
                $msg_no_mail = $LANG08[44]; // User Status issues, assume bad email
            }
        } elseif ($isAdmin) {
            $msg_no_mail = $LANG08[41]; // User doesn't exist
        }
        
        // Check if User wants mail from someone
        if ($continue) {
            $result = DB_query("SELECT emailfromadmin,emailfromuser FROM {$_TABLES['userprefs']} WHERE uid = '$uid'");
            $P = DB_fetchArray($result);
            
            if ($continue && ((($P['emailfromadmin'] == 1) && $isAdmin) || (($P['emailfromuser'] == 1) && !$isAdmin))) {
                $continue = true;
            } else {
                $continue = false;
            }
        }
        
        $displayname = COM_getDisplayName($uid);
        if ($continue) {
            if ($cc) {
                $cc = ' checked="checked"';
            } else {
                $cc = '';
            }
            $retval = COM_startBlock($LANG08[10] . ' ' . $displayname);
            $mail_template = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'profiles'));
            $mail_template->set_file('form', 'contactuserform.thtml');
            $mail_template->set_var('lang_description', $LANG08[26]);
            $mail_template->set_var('lang_username', $LANG08[11]);
            if (COM_isAnonUser()) {
                $sender = Geeklog\Input::post('author', '');
                if (!empty($sender)) {
                    $sender = GLText::stripTags($sender);
                    $sender = substr($sender, 0, strcspn($sender, "\r\n"));
                    $sender = htmlspecialchars(trim($sender), ENT_QUOTES);
                }
                $mail_template->set_var('username', $sender);
            } else {
                $mail_template->set_var('username',
                        COM_getDisplayName($_USER['uid'], $_USER['username'],
                                            $_USER['fullname']));
            }
            $mail_template->set_var('lang_useremail', $LANG08[12]);
            if (COM_isAnonUser()) {
                $email = Geeklog\Input::post('authoremail', '');
                if (!empty($email)) {
                    $email = GLText::stripTags($email);
                    $email = substr($email, 0, strcspn($email, "\r\n"));
                    $email = htmlspecialchars(trim($email), ENT_QUOTES);
                }
                $mail_template->set_var('useremail', $email);
            } else {
                $mail_template->set_var('useremail', $_USER['email']);
            }
            if (!$_CONF['mail_cc_enabled']) {
                $mail_template->set_var('cc_enabled', ' style="display: none"');
            } else {
                $mail_template->set_var('cc', $cc);
                $mail_template->set_var('lang_cc', $LANG08[36]);
                $mail_template->set_var('lang_cc_description', $LANG08[37]);
            }
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
            $retval = COM_showMessageText($msg_no_mail, $LANG08[10] . ' ' . $displayname);
        }
    }

    return $retval;
}

/**
* Email story to a friend
*
* @param    string  $sid        id of story to email
* @param    string  $to         name of person / friend to email
* @param    string  $toEmail    friend's email address
* @param    string  $from       name of person sending the email
* @param    string  $fromEmail  sender's email address
* @param    string  $shortMessage   short intro text to send with the story
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
function mailstory($sid, $to, $toEmail, $from, $fromEmail, $shortMessage)
{
    global $_CONF, $_TABLES, $LANG01, $LANG08;

    require_once $_CONF['path_system'] . 'lib-article.php';

    $storyUrl = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $sid);

    if ($_CONF['url_rewrite']) {
        $redirect = $storyUrl . '?msg=153';
    } else {
        $redirect = $storyUrl . '&amp;msg=153';
    }

    // check for correct $_CONF permission
    if (COM_isAnonUser() &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['emailstoryloginrequired'] == 1))) {
        COM_redirect($redirect);
    }

    // check if emailing of stories is disabled
    if ($_CONF['hideemailicon'] == 1) {
        COM_redirect($redirect);
    }

    // check mail speedlimit
    COM_clearSpeedlimit($_CONF['speedlimit'], 'mail');
    $speedLimit = COM_checkSpeedlimit('mail');
    if ($speedLimit > 0) {
        $redirect .= '&amp;speedlimit=' . $speedLimit;
        COM_redirect($redirect);
    }

    $story = new Article();
    $result = $story->loadFromDatabase($sid, 'view');

    if ($result != STORY_LOADED_OK) {
        COM_redirect($_CONF['site_url'] . '/index.php');
    }

    $mailText = sprintf($LANG08[23], $from, $fromEmail) . LB;
    if (strlen($shortMessage) > 0) {
        $mailText .= LB . sprintf($LANG08[28], $from) . $shortMessage . LB;
    }

    // just to make sure this isn't an attempt at spamming users ...
    $permanentlink = null; // Setting this to null as this is a stand alone email. There is no permantlink that the email is being added too (like a comment on a blog post)
    $result = PLG_checkForSpam(
        $mailText, $_CONF['spamx'], $permanentlink, Geeklog\Akismet::COMMENT_TYPE_CONTACT_FORM,
        $from, $fromEmail
    );
    if ($result > PLG_SPAM_NOT_FOUND) {
        COM_updateSpeedlimit('mail');
        COM_displayMessageAndAbort($result, 'spamx', 403, 'Forbidden');
    }

    $mailText .= '------------------------------------------------------------'
              . LB . LB
              . COM_undoSpecialChars($story->displayElements('title')) . LB
              . COM_strftime($_CONF['date'], $story->DisplayElements('unixdate')) . LB;

    if ($_CONF['contributedbyline'] == 1) {
        $author = COM_getDisplayName($story->displayElements('uid'));
        $mailText .= $LANG01[1] . ' ' . $author . LB;
    }

    $introtext = $story->DisplayElements('introtext');
    $bodytext  = $story->DisplayElements('bodytext');
    $introtext = COM_undoSpecialChars(GLText::stripTags($introtext));
    $bodytext  = COM_undoSpecialChars(GLText::stripTags($bodytext));

    $introtext = str_replace(array("\012\015", "\015"), LB, $introtext);
    $bodytext  = str_replace(array("\012\015", "\015"), LB, $bodytext);

    $mailText .= LB . $introtext;
    if (! empty($bodytext)) {
        $mailText .= LB . LB . $bodytext;
    }
    $mailText .= LB . LB
        . '------------------------------------------------------------' . LB;

    if ($story->DisplayElements('commentcode') == 0) { // comments allowed
        $mailText .= $LANG08[24] . LB
                  . COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                                  . $sid . '#comments');
    } else { // comments not allowed - just add the story's URL
        $mailText .= $LANG08[33] . LB
                  . COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                                  . $sid);
    }

    $mailto = array($toEmail => $to);
    $mailfrom = array($fromEmail => $from);
    $subject = 'Re: ' . COM_undoSpecialChars(GLText::stripTags($story->DisplayElements('title')));

    $sent = COM_mail($mailto, $subject, $mailText, $mailfrom);

    if ($sent && $_CONF['mail_cc_enabled'] && (Geeklog\Input::post('cc') === 'on')) {
        $ccmessage = sprintf($LANG08[38], $to) . "\n"
                   . $LANG08[45]
                   . "\n------------------------------------------------------------\n\n" . $mailText;

        $sent = COM_mail($mailfrom, $subject, $ccmessage, $_CONF['noreply_mail']);
    }

    COM_updateSpeedlimit('mail');

    // Increment numemails counter for story
    DB_query("UPDATE {$_TABLES['stories']} SET numemails = numemails + 1 WHERE sid = '$sid'");

    if ($_CONF['url_rewrite']) {
        $redirect = $storyUrl . '?msg=' . ($sent ? '27' : '85');
    } else {
        $redirect = $storyUrl . '&amp;msg=' . ($sent ? '27' : '85');
    }

    COM_redirect($redirect);
}

/**
* Display form to email a story to someone.
*
* @param    string  $sid        ID of article to email
* @param    bool    $cc         Whether to send a copy of the message to the author
* @param    string  $to         name of person / friend to email
* @param    string  $toemail    friend's email address
* @param    string  $from       name of person sending the email
* @param    string  $fromemail  sender's email address
* @param    string  $shortmsg   short intro text to send with the story
* @param    int     $msg        Error message code
* @return   string              HTML for email story form
*
*/
function mailstoryform($sid, $cc = false, $to = '', $toemail = '', $from = '',
                        $fromemail = '', $shortmsg = '', $msg = 0)
{
    global $_CONF, $_TABLES, $_USER, $LANG08;

    require_once $_CONF['path_system'] . 'lib-article.php';

    $retval = '';

    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
                             ($_CONF['emailstoryloginrequired'] == 1))) {
        $retval .= SEC_loginRequiredForm();

        return $retval;
    }

    $story = new Article();
    $result = $story->loadFromDatabase($sid, 'view');

    if ($result != STORY_LOADED_OK) {
        COM_redirect($_CONF['site_url'] . '/index.php');
    }

    if ($msg > 0) {
        $retval .= COM_showMessage ($msg);
    }

    if (empty($from) && empty($fromemail)) {
        if (!COM_isAnonUser()) {
            $from = COM_getDisplayName($_USER['uid'], $_USER['username'],
                                        $_USER['fullname']);
            $fromemail = DB_getItem ($_TABLES['users'], 'email',
                                     "uid = {$_USER['uid']}");
        }
    }

    $cc = $cc ? ' checked="checked"' : '';

    $mail_template = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'profiles'));
    $mail_template->set_file('form', 'contactauthorform.thtml');
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
    if (!$_CONF['mail_cc_enabled']) {
        $mail_template->set_var('cc_enabled', ' style="display: none"');
    } else {
        $mail_template->set_var('cc', $cc);
        $mail_template->set_var('lang_cc', $LANG08[36]);
        $mail_template->set_var('lang_cc_description', $LANG08[37]);
    }
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

$what = Geeklog\Input::fPostOrGet('what', '');

// Remember if user wants to get a copy of the message
$cc = isset($_POST['cc']);

switch ($what) {
    case 'contact':
        $uid = (int) Geeklog\Input::fPost('uid', 0);
        if ($uid > 1) {
            $display .= contactemail(
                $uid, $cc,
                Geeklog\Input::post('author'), Geeklog\Input::post('authoremail'),
                Geeklog\Input::post('subject'), Geeklog\Input::post('message')
            );
        } else {
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
        break;

    case 'emailstory':
        $sid = Geeklog\Input::fGet('sid');

        if (empty($sid)) {
            COM_redirect($_CONF['site_url'] . '/index.php');
        } elseif ($_CONF['hideemailicon'] == 1) {
            COM_redirect(COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $sid));
        } else {
            $display = mailstoryform($sid, $_CONF['mail_cc_default']);
            $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG08[17]));
        }
        break;

    case 'sendstory':
        $sid = Geeklog\Input::fPost('sid');

        if (empty($sid)) {
            $display = COM_redirect($_CONF['site_url'] . '/index.php');
        } else {
            if (empty($_POST['toemail']) || empty($_POST['fromemail']) ||
                    !COM_isEmail($_POST['toemail']) ||
                    !COM_isEmail($_POST['fromemail']) ||
                    (strpos($_POST['to'], '@') !== false) ||
                    (strpos($_POST['from'], '@') !== false)) {
                $display = mailstoryform(
                    $sid, $cc,
                    Geeklog\Input::fPost('to'),
                    Geeklog\Input::fPost('toemail'),
                    Geeklog\Input::fPost('from'),
                    Geeklog\Input::fPost('fromemail'),
                    Geeklog\Input::post('shortmsg'),
                    52
                );
                $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG08[17]));
            } elseif (empty($_POST['to']) || empty($_POST['from']) || empty($_POST['shortmsg'])) {
                $display = COM_showMessageText($LANG08[22])
                     . mailstoryform(
                        $sid, $cc,
                        Geeklog\Input::fPost('to'),
                        Geeklog\Input::fPost('toemail'),
                        Geeklog\Input::fPost('from'),
                        Geeklog\Input::fPost('fromemail'),
                        Geeklog\Input::post('shortmsg')
                    );
                $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG08[17]));
            } else {
                $msg = PLG_itemPreSave('emailstory', Geeklog\Input::post('shortmsg'));
                if (!empty($msg)) {
                    $display = COM_errorLog($msg, 2)
                         . mailstoryform(
                            $sid, $cc,
                            Geeklog\Input::fPost('to'),
                            Geeklog\Input::fPost('toemail'),
                            Geeklog\Input::fPost('from'),
                            Geeklog\Input::fPost('fromemail'),
                            Geeklog\Input::post('shortmsg')
                        );
                    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG08[17]));
                } else {
                    $display .= mailstory(
                        $sid,
                        Geeklog\Input::fPost('to'),
                        Geeklog\Input::fPost('toemail'),
                        Geeklog\Input::fPost('from'),
                        Geeklog\Input::fPost('fromemail'),
                        Geeklog\Input::post('shortmsg')
                    );
                }
            }
        }
        break;

    default:
        $uid = (int) Geeklog\Input::fGet('uid', 0);
        if ($uid > 1) {
            $subject = Geeklog\Input::get('subject', '');
            if (!empty($subject)) {
                $subject = GLText::stripTags($subject);
                $subject = substr($subject, 0, strcspn($subject, "\r\n"));
                $subject = htmlspecialchars(trim($subject), ENT_QUOTES);
            }
            $display = contactform($uid, $_CONF['mail_cc_default'], $subject);
            $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[81]));
        } else {
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
        break;
}

COM_output($display);
