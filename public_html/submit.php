<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | submit.php                                                                |
// |                                                                           |
// | Let users submit stories and plugin stuff.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2008 by the following authors:                         |
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
// $Id: submit.php,v 1.123 2008/07/07 18:24:00 dhaun Exp $

require_once 'lib-common.php';
require_once $_CONF['path_system'] . 'lib-story.php';

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

/**
* Shows a given submission form
*
* This is the submission it is modular to allow us to write as little as
* possible.  It takes a type and formats a form for the user.  Currently the
* types is story.  If no type is provided, Story is assumed.
*
* @param    string  $type   type of submission ('story')
* @param    string  $mode   calendar mode ('personal' or empty string)
* @param    string  $topic  topic (for stories)
* @return   string          HTML for submission form
*
*/
function submissionform($type='story', $mode = '', $topic = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG12, $LANG_LOGIN;

    $retval = '';

    COM_clearSpeedlimit ($_CONF['speedlimit'], 'submit');

    $last = COM_checkSpeedlimit ('submit');

    if ($last > 0) {
        $retval .= COM_startBlock ($LANG12[26], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[30]
            . $last
            . $LANG12[31]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    } else {
        if (empty ($_USER['username']) &&
            (($_CONF['loginrequired'] == 1) || ($_CONF['submitloginrequired'] == 1))) {
            $retval .= COM_startBlock ($LANG_LOGIN[1], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
            $loginreq = new Template($_CONF['path_layout'] . 'submit');
            $loginreq->set_file('loginreq', 'submitloginrequired.thtml');
            $loginreq->set_var('xhtml', XHTML);
            $loginreq->set_var('site_url', $_CONF['site_url']);
            $loginreq->set_var('site_admin_url', $_CONF['site_admin_url']);
            $loginreq->set_var('layout_url', $_CONF['layout_url']);
            $loginreq->set_var('login_message', $LANG_LOGIN[2]);
            $loginreq->set_var('lang_login', $LANG_LOGIN[3]);
            $loginreq->set_var('lang_newuser', $LANG_LOGIN[4]);
            $loginreq->parse('errormsg', 'loginreq');
            $retval .= $loginreq->finish($loginreq->get_var('errormsg'));
            $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            return $retval;
        } else {
            $retval .= COM_startBlock($LANG12[19])
                    . $LANG12[9]
                    . COM_endBlock();

            if ((strlen($type) > 0) && ($type <> 'story')) {
                $formresult = PLG_showSubmitForm($type);
                if ($formresult == false) {
                    COM_errorLog("Someone tried to submit an item to the $type-plugin, which cannot be found.", 1);
                    COM_displayMessageAndAbort (79, '', 410, 'Gone');
                } else {
                    $retval .= $formresult;
                }
            } else {
                $retval .= submitstory($topic);
            }
        }
    }

    return $retval;
}

/**
* Shows the story submission form
*
*/
function submitstory($topic = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG12, $LANG24;

    $retval = '';

    $story = new Story();

    if( isset( $_POST['mode'] ) && ( $_POST['mode'] == $LANG12[32] ) )
    {
        // preview
        $story->loadSubmission();
        $retval .= COM_startBlock($LANG12[32])
                . STORY_renderArticle ($story, 'p')
                . COM_endBlock();
    } else {
        $story->initSubmission($topic);
    }

    $retval .= COM_startBlock($LANG12[6],'submitstory.html');

    $storyform = new Template($_CONF['path_layout'] . 'submit');
    if (isset ($_CONF['advanced_editor']) && ($_CONF['advanced_editor'] == 1) &&
        file_exists ($_CONF['path_layout'] . 'submit/submitstory_advanced.thtml')) {
        $storyform->set_file('storyform','submitstory_advanced.thtml');
        $storyform->set_var ('change_editormode', 'onchange="change_editmode(this);"');
        $storyform->set_var ('lang_expandhelp', $LANG24[67]);
        $storyform->set_var ('lang_reducehelp', $LANG24[68]);
        if ($story->EditElements('postmode') == 'html') {
            $storyform->set_var ('show_texteditor', 'none');
            $storyform->set_var ('show_htmleditor', '');
        } else {
            $storyform->set_var ('show_texteditor', '');
            $storyform->set_var ('show_htmleditor', 'none');
        }
    } else {
        $storyform->set_file('storyform','submitstory.thtml');
        if ($story->EditElements('postmode') == 'html') {
            $storyform->set_var ('show_texteditor', 'none');
            $storyform->set_var ('show_htmleditor', '');
        } else {
            $storyform->set_var ('show_texteditor', '');
            $storyform->set_var ('show_htmleditor', 'none');
        }
    }
    $storyform->set_var ('xhtml', XHTML);
    $storyform->set_var ('site_url', $_CONF['site_url']);
    $storyform->set_var ('site_admin_url', $_CONF['site_admin_url']);
    $storyform->set_var ('layout_url', $_CONF['layout_url']);
    $storyform->set_var ('lang_username', $LANG12[27]);

    if (!empty($_USER['username'])) {
        $storyform->set_var('story_username', $_USER['username']);
        $storyform->set_var('author', COM_getDisplayName ());
        $storyform->set_var('status_url', $_CONF['site_url']
                                          . '/users.php?mode=logout');
        $storyform->set_var('lang_loginout', $LANG12[34]);
    } else {
        $storyform->set_var('status_url', $_CONF['site_url'] . '/users.php');
        $storyform->set_var('lang_loginout', $LANG12[2]);
        if (!$_CONF['disable_new_user_registration']) {
            $storyform->set_var('separator', ' | ');
            $storyform->set_var('seperator', ' | ');
            $storyform->set_var(
                'create_account',
                COM_createLink(
                    $LANG12[53],
                    $_CONF['site_url'] . '/users.php?mode=new',
                    array('rel'=>"nofollow")
                )
            );
        }
    }

    $storyform->set_var('lang_title', $LANG12[10]);
    $storyform->set_var('story_title', $story->EditElements('title'));
    $storyform->set_var('lang_topic', $LANG12[28]);

    $storyform->set_var('story_topic_options', COM_topicList('tid,topic',$story->EditElements('tid')));
    $storyform->set_var('lang_story', $LANG12[29]);
    $storyform->set_var('lang_introtext', $LANG12[54]);
    $storyform->set_var('lang_bodytext', $LANG12[55]);
    $storyform->set_var('story_introtext', $story->EditElements('introtext'));
    $storyform->set_var('story_bodytext', $story->EditElements('bodytext'));
    $storyform->set_var('lang_postmode', $LANG12[36]);
    $storyform->set_var('story_postmode_options', COM_optionList($_TABLES['postmodes'],'code,name',$story->EditElements('postmode')));
    $storyform->set_var('allowed_html', COM_allowedHTML());
    $storyform->set_var('story_uid', $story->EditElements('uid'));
    $storyform->set_var('story_sid', $story->EditElements('sid'));
    $storyform->set_var('story_date', $story->EditElements('unixdate'));

    if (($_CONF['skip_preview'] == 1) ||
            (isset($_POST['mode']) && ($_POST['mode'] == $LANG12[32]))) {
        PLG_templateSetVars ('story', $storyform);
        $storyform->set_var('save_button', '<input name="mode" type="submit" value="' . $LANG12[8] . '"' . XHTML . '>');
    }

    $storyform->set_var('lang_preview', $LANG12[32]);
    $storyform->parse('theform', 'storyform');
    $retval .= $storyform->finish($storyform->get_var('theform'));
    $retval .= COM_endBlock();

    return $retval;
}

/**
* Send an email notification for a new submission.
*
* @param    string  $table  Table where the new submission can be found
* @param    string  $story  Story object that was submitted.
*
*/
function sendNotification ($table, $story)
{
    global $_CONF, $_TABLES, $LANG01, $LANG08, $LANG24, $LANG29, $LANG_ADMIN;

    $title = COM_undoSpecialChars( $story->displayElements('title') );
    if ($A['postmode'] == 'html') {
        $A['introtext'] = strip_tags ($A['introtext']);
    }
    $introtext = COM_undoSpecialChars( $story->displayElements('introtext') . "\n" . $story->displayElements('bodytext') );
    $storyauthor = COM_getDisplayName( $story->displayelements('uid') );
    $topic = stripslashes(DB_getItem ($_TABLES['topics'], 'topic',
                                       'tid = \''.$story->displayElements('tid').'\''));
    $mailbody = "$LANG08[31]: {$title}\n"
              . "$LANG24[7]: {$storyauthor}\n"
              . "$LANG08[32]: " . strftime ($_CONF['date']) . "\n"
              . "{$LANG_ADMIN['topic']}: {$topic}\n\n";

    if ($_CONF['emailstorieslength'] > 0) {
        if ($_CONF['emailstorieslength'] > 1) {
            $introtext = MBYTE_substr ($introtext, 0,
                    $_CONF['emailstorieslength']) . '...';
        }
        $mailbody .= $introtext . "\n\n";
    }
    if ($table == $_TABLES['storysubmission']) {
        $mailbody .= "$LANG01[10] <{$_CONF['site_admin_url']}/moderation.php>\n\n";
    } else {
        $articleUrl = COM_buildUrl ($_CONF['site_url']
                                . '/article.php?story=' . $story->getSid() );
        $mailbody .= $LANG08[33] . ' <' . $articleUrl . ">\n\n";
    }
    $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[35];
    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
* Saves a story submission
*
* @param    array   $A  Data for that submission
* @return   string      HTML redirect
*
*/
function savestory ($A)
{
    global $_CONF, $_TABLES, $_USER;

    $retval = '';

    $story = new Story();
    $story->loadSubmission();

    // pseudo-formatted story text for the spam check
    $result = PLG_checkforSpam ($story->GetSpamCheckFormat(), $_CONF['spamx']);
    if ($result > 0)
    {
        COM_updateSpeedlimit ('submit');
        COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
    }

    COM_updateSpeedlimit ('submit');

    $result = $story->saveSubmission();
    if( $result == STORY_NO_ACCESS_TOPIC )
    {
        // user doesn't have access to this topic - bail
        $retval = COM_refresh ($_CONF['site_url'] . '/index.php');
    } elseif( ( $result == STORY_SAVED ) || ( $result == STORY_SAVED_SUBMISSION ) ) {
        if (isset ($_CONF['notification']) &&
                in_array ('story', $_CONF['notification']))
        {
            sendNotification ($_TABLES['storysubmission'], $story);
        }

        if( $result == STORY_SAVED )
        {
            $retval = COM_refresh( COM_buildUrl( $_CONF['site_url']
                               . '/article.php?story=' . $story->getSid() ) );
        } else {
            $retval = COM_refresh( $_CONF['site_url'] . '/index.php?msg=2' );
        }
    }

    return $retval;
}

/**
* This will save a submission
*
* @param    string  $type   Type of submission we are dealing with
* @param    array   $A      Data for that submission
*
*/
function savesubmission($type, $A)
{
    global $_CONF, $_TABLES, $_USER, $LANG12;

    $retval = COM_siteHeader ();

    COM_clearSpeedlimit ($_CONF['speedlimit'], 'submit');

    $last = COM_checkSpeedlimit ('submit');

    if ($last > 0) {
        $retval .= COM_startBlock ($LANG12[26], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[30]
            . $last
            . $LANG12[31]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
            . COM_siteFooter ();

        return $retval;
    }

    if (!empty ($type) && ($type != 'story')) {
        // Update the submitspeedlimit for user - assuming Plugin approves
        // submission record
        COM_updateSpeedlimit ('submit');

        // see if this is a submission that needs to be handled by a plugin
        // and should include its own redirect
        $retval = PLG_saveSubmission ($type, $A);

        if ($retval === false) {
            COM_errorLog ("Could not save your submission. Bad type: $type");
        } elseif (empty ($retval)) {
            // plugin should include its own redirect - but in case handle
            // it here and redirect to the main page
            return COM_refresh ($_CONF['site_url'] . '/index.php');
        } else {
            return $retval;
        }
    }

    if (!empty ($A['title']) && !empty ($A['introtext'])) {
        $retval = savestory ($A);
    } else {
        $retval .= COM_startBlock ($LANG12[22], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[23] // return missing fields error
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
            . submissionform($type)
            . COM_siteFooter ();
    }

    return $retval;
}

// MAIN

$display = '';

// note that 'type' _may_ come in through $_GET even when the
// other parameters are in $_POST
if (isset ($_POST['type'])) {
    $type = COM_applyFilter ($_POST['type']);
} else {
    $type = COM_applyFilter ($_GET['type']);
}

$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}

if (($mode == $LANG12[8]) && !empty ($LANG12[8])) { // submit
    if (empty ($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['submitloginrequired'] == 1))) {
        $display = COM_refresh ($_CONF['site_url'] . '/index.php');
    } else {
        if ($type == 'story') {
            $msg = PLG_itemPreSave ($type, $_POST);
            if (!empty ($msg)) {
                $_POST['mode'] =  $LANG12[32];
                $display .= COM_siteHeader ('menu', $pagetitle)
                         . COM_errorLog ($msg, 2)
                         . submitstory ($topic)
                         . COM_siteFooter();
                echo $display;
                exit;
            }
        }
        $display .= savesubmission ($type, $_POST);
    }
} else {
    if ((strlen ($type) > 0) && ($type <> 'story')) {
        if (SEC_hasRights ("$type.edit") ||
            SEC_hasRights ("$type.admin"))  {
            echo COM_refresh ($_CONF['site_admin_url']
                    . "/plugins/$type/index.php?mode=edit");
            exit;
        }
    } elseif (SEC_hasRights ('story.edit')) {
        $topic = '';
        if (isset ($_REQUEST['topic'])) {
            $topic = '&topic=' . urlencode(COM_applyFilter($_REQUEST['topic']));
        }
        echo COM_refresh ($_CONF['site_admin_url']
                . '/story.php?mode=edit' . $topic);
        exit;
    }
    $topic = '';
    if (isset ($_REQUEST['topic'])) {
        $topic = COM_applyFilter ($_REQUEST['topic']);
    }

    switch ($type) {
        case 'story':
            $pagetitle = $LANG12[6];
            break;
        default:
            $pagetitle = '';
            break;
    }
    $display .= COM_siteHeader ('menu', $pagetitle);
    $display .= submissionform($type, $mode, $topic);
    $display .= COM_siteFooter();
}

echo $display;

?>
