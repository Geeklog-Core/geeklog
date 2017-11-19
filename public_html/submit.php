<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | submit.php                                                                |
// |                                                                           |
// | Let users submit stories and plugin stuff.                                |
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

require_once 'lib-common.php';
require_once $_CONF['path_system'] . 'lib-article.php';

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
 * @param    string $type type of submission ('story')
 * @param    string $mode calendar mode ('personal' or empty string)
 * @return   string          HTML for submission form
 *
 */
function submissionform($type = 'story', $mode = '')
{
    global $_CONF, $_TABLES, $LANG12;

    $retval = '';

    COM_clearSpeedlimit($_CONF['speedlimit'], 'submit');
    $last = COM_checkSpeedlimit('submit');

    if ($last > 0) {
        $retval .= COM_showMessageText($LANG12[30] . $last . $LANG12[31], $LANG12[26]);
    } else {
        if (COM_isAnonUser() &&
            (($_CONF['loginrequired'] == 1) || ($_CONF['submitloginrequired'] == 1))) {
            $retval .= SEC_loginRequiredForm();

            return $retval;
        } else {
            $retval .= COM_startBlock($LANG12[19])
                . $LANG12[9]
                . COM_endBlock();

            if ((strlen($type) > 0) && ($type !== 'story')) {
                $formresult = PLG_showSubmitForm($type);
                if ($formresult == false) {
                    COM_errorLog("Someone tried to submit an item to the {$type}-plugin, which cannot be found.", 1);
                    COM_displayMessageAndAbort(79, '', 410, 'Gone');
                } else {
                    $retval .= $formresult;
                }
            } else {
                $retval .= submitstory();
            }
        }
    }

    return $retval;
}

/**
 * Shows the story submission form
 *
 */
function submitstory()
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG12, $LANG24, $LANG_ADMIN, $_SCRIPTS;

    // Add JavaScript
    $_SCRIPTS->setJavaScriptFile('postmode_control', '/javascript/postmode_control.js');

    $retval = '';

    $story = new Article();

    if (Geeklog\Input::post('mode') === $LANG12[32]) {
        // preview
        $story->loadSubmission();
        $retval .= COM_startBlock($LANG12[32])
            . STORY_renderArticle($story, 'p')
            . COM_endBlock();
    } else {
        $story->initSubmission();
    }

    $storyForm = COM_newTemplate($_CONF['path_layout'] . 'submit');
    if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
        $storyForm->set_file('storyform', 'submitarticle_advanced.thtml');
        $storyForm->set_var('change_editormode', 'onchange="change_editmode(this);"');
        $storyForm->set_var('lang_expandhelp', $LANG24[67]);
        $storyForm->set_var('lang_reducehelp', $LANG24[68]);
        $link_message = COM_isAnonUser() ? '' : $LANG01[138];
        $storyForm->set_var('noscript', COM_getNoScript(false, '', $link_message));

        // Setup Advanced Editor
        COM_setupAdvancedEditor('/javascript/submitstory_adveditor.js');

        if ($story->EditElements('postmode') === 'html') {
            $storyForm->set_var('show_texteditor', 'none');
            $storyForm->set_var('show_htmleditor', '');
        } else {
            $storyForm->set_var('show_texteditor', '');
            $storyForm->set_var('show_htmleditor', 'none');
        }
    } else {
        $storyForm->set_file('storyform', 'submitarticle.thtml');
        if ($story->EditElements('postmode') === 'html') {
            $storyForm->set_var('show_texteditor', 'none');
            $storyForm->set_var('show_htmleditor', '');
        } else {
            $storyForm->set_var('show_texteditor', '');
            $storyForm->set_var('show_htmleditor', 'none');
        }
    }
    $storyForm->set_var('lang_username', $LANG12[27]);

    if (!COM_isAnonUser()) {
        $storyForm->set_var('story_username', $_USER['username']);
        $storyForm->set_var('author', COM_getDisplayName());
        $storyForm->set_var('status_url', $_CONF['site_url']
            . '/users.php?mode=logout');
        $storyForm->set_var('lang_loginout', $LANG12[34]);
    } else {
        $storyForm->set_var('status_url', $_CONF['site_url'] . '/users.php');
        $storyForm->set_var('lang_loginout', $LANG12[2]);
        if (!$_CONF['disable_new_user_registration']) {
            $storyForm->set_var('separator', ' | ');
            $storyForm->set_var('seperator', ' | ');
            $storyForm->set_var(
                'create_account',
                COM_createLink(
                    $LANG12[53],
                    $_CONF['site_url'] . '/users.php?mode=new',
                    array('rel' => 'nofollow')
                )
            );
        }
    }

    $storyForm->set_var('lang_title', $LANG12[10]);
    $storyForm->set_var('story_title', $story->EditElements('title'));
    $storyForm->set_var(array(
        'lang_metadescription' => $LANG_ADMIN['meta_description'],
        'meta_description'     => $story->EditElements('meta_description'),
        'lang_metakeywords'    => $LANG_ADMIN['meta_keywords'],
        'meta_keywords'        => $story->EditElements('meta_keywords'),
        'hide_meta'            => (($_CONF['meta_tags'] > 0) ? '' : ' style="display:none;"'),
    ));
    $storyForm->set_var('lang_topic', $LANG12[28]);

    $tlist = TOPIC_getTopicSelectionControl('article', '', false, false, false);
    $storyForm->set_var('topic_selection', $tlist);
    if (empty($tlist)) {
        $retval .= COM_showMessage(101);

        return $retval;
    }
    $storyForm->set_var('story_topic_options', $tlist);
    $storyForm->set_var('lang_story', $LANG12[29]);
    $storyForm->set_var('lang_introtext', $LANG12[54]);
    $storyForm->set_var('lang_bodytext', $LANG12[55]);
    $storyForm->set_var('story_introtext', $story->EditElements('introtext'));
    $storyForm->set_var('story_bodytext', $story->EditElements('bodytext'));
    $storyForm->set_var('lang_postmode', $LANG12[36]);
    $postmode = $story->EditElements('postmode');
    $storyForm->set_var(
        'story_postmode_options',
        COM_optionList($_TABLES['postmodes'], 'code,name', $postmode)
    );
    $allowed_html = '';
    foreach (array('plaintext', 'html') as $pm) {
        $allowed_html .= COM_allowedHTML('story.edit', false, 1, $pm);
    }
    $allowed_html .= COM_allowedAutotags();
    $storyForm->set_var('allowed_html', $allowed_html);
    $storyForm->set_var('story_uid', $story->EditElements('uid'));
    $storyForm->set_var('story_sid', $story->EditElements('sid'));
    $storyForm->set_var('story_date', $story->EditElements('unixdate'));
    $storyForm->set_var('lang_preview', $LANG12[32]);

    PLG_templateSetVars('story', $storyForm);
    if (($_CONF['skip_preview'] == 1) || (Geeklog\Input::post('mode') === $LANG12[32])) {
        $storyForm->set_var(
            'save_button',
            '<input name="mode" type="submit" value="' . $LANG12[8] . '"' . XHTML . '>'
        );
    }

    $retval .= COM_startBlock($LANG12[6], 'submitstory.html');
    $storyForm->parse('theform', 'storyform');
    $retval .= $storyForm->finish($storyForm->get_var('theform'));
    $retval .= COM_endBlock();

    return $retval;
}

/**
 * Send an email notification for a new submission.
 *
 * @param    string $table Table where the new submission can be found
 * @param    string $story Story object that was submitted.
 *
 */
function sendNotification($table, $story)
{
    global $_CONF, $_TABLES, $LANG01, $LANG08, $LANG24, $LANG29, $LANG_ADMIN;

    $title = COM_undoSpecialChars($story->displayElements('title'));
    $introtext = COM_undoSpecialChars($story->displayElements('introtext') . "\n" . $story->displayElements('bodytext'));
    if ($story->_postmode === 'html') {
        $introtext = GLText::stripTags($introtext);
    } else {
        $introtext = str_replace('<br' . XHTML . '>', "\n", $introtext);
    }
    $storyauthor = COM_getDisplayName($story->displayelements('uid'));
    $topic = TOPIC_getTopicAdminColumn('article', $story->getSid());
    $mailbody = "$LANG08[31]: {$title}\n"
        . "$LANG24[7]: {$storyauthor}\n"
        . "$LANG08[32]: " . strftime($_CONF['date']) . "\n"
        . "{$LANG_ADMIN['topic']}: {$topic}\n\n";

    if ($_CONF['emailstorieslength'] > 0) {
        if ($_CONF['emailstorieslength'] > 1) {
            $introtext = MBYTE_substr($introtext, 0,
                    $_CONF['emailstorieslength']) . '...';
        }
        $mailbody .= $introtext . "\n\n";
    }
    if ($table == $_TABLES['storysubmission']) {
        $mailbody .= "$LANG01[10] <{$_CONF['site_admin_url']}/moderation.php>\n\n";
    } else {
        $articleUrl = COM_buildUrl($_CONF['site_url']
            . '/article.php?story=' . $story->getSid()
        );
        $mailbody .= $LANG08[33] . ' <' . $articleUrl . ">\n\n";
    }
    $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[35];
    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    COM_mail($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
 * Saves a story submission
 *
 * @param  array $A Data for that submission
 * @return string   HTML redirect
 *
 */
function savestory(array $A)
{
    global $_CONF, $_TABLES;

    $retval = '';

    $story = new Article();
    $story->loadSubmission();

    // pseudo-formatted story text for the spam check
    $url = COM_buildURL($_CONF['site_url'] . '/article.php?story=' . $story->getSid());
    $result = PLG_checkForSpam(
        $story->getSpamCheckFormat(), $_CONF['spamx'], $url, Geeklog\Akismet::COMMENT_TYPE_BLOG_POST
    );

    if ($result > PLG_SPAM_NOT_FOUND) {
        COM_updateSpeedlimit('submit');
        COM_displayMessageAndAbort($result, 'spamx', 403, 'Forbidden');
    }

    COM_updateSpeedlimit('submit');

    $result = $story->saveSubmission();
    if ($result == STORY_NO_ACCESS_TOPIC) {
        // user doesn't have access to this topic - bail
        COM_redirect($_CONF['site_url'] . '/index.php');
    } elseif (($result == STORY_SAVED) || ($result == STORY_SAVED_SUBMISSION)) {
        if (isset($_CONF['notification']) &&
            (in_array('article', $_CONF['notification']) || in_array('story', $_CONF['notification']))) {
            sendNotification($_TABLES['storysubmission'], $story);
        }

        if ($result == STORY_SAVED) {
            COM_redirect(COM_buildUrl($_CONF['site_url']
                . '/article.php?story=' . $story->getSid()));
        } else {
            COM_redirect($_CONF['site_url'] . '/index.php?msg=2');
        }
    }

    return $retval;
}

/**
 * This will save a submission
 *
 * @param  string $type Type of submission we are dealing with
 * @param  array  $A    Data for that submission
 * @return string
 */
function savesubmission($type, $A)
{
    global $_CONF, $LANG12;

    COM_clearSpeedlimit($_CONF['speedlimit'], 'submit');
    $last = COM_checkSpeedlimit('submit');

    if ($last > 0) {
        $retval = COM_showMessageText($LANG12[30] . $last . $LANG12[31], $LANG12[26]);
        $retval = COM_createHTMLDocument($retval);

        return $retval;
    }

    if (!empty($type) && ($type !== 'story')) {
        // Update the submitspeedlimit for user - assuming Plugin approves
        // submission record
        COM_updateSpeedlimit('submit');

        // see if this is a submission that needs to be handled by a plugin
        // and should include its own redirect
        $retval = PLG_saveSubmission($type, $A);

        if ($retval === false) {
            COM_errorLog("Could not save your submission. Bad type: $type");
        } elseif (empty($retval)) {
            // plugin should include its own redirect - but in case handle
            // it here and redirect to the main page
            PLG_submissionSaved($type);
            COM_redirect($_CONF['site_url'] . '/index.php');
        } else {
            PLG_submissionSaved($type);

            return $retval;
        }
    }


    if (!empty($A['title']) && !empty($A['introtext']) && TOPIC_checkTopicSelectionControl()) {
        $retval = savestory($A);
        PLG_submissionSaved($type);
    } else {
        $retval = COM_showMessageText($LANG12[23], $LANG12[22]) // return missing fields error
            . submissionform($type);
        $retval = COM_createHTMLDocument($retval);
    }

    return $retval;
}

// MAIN

$display = '';

// note that 'type' _may_ come in through $_GET even when the
// other parameters are in $_POST
$type = Geeklog\Input::fPostOrGet('type', '');
$mode = Geeklog\Input::fRequest('mode', '');

// Get last topic
TOPIC_getTopic();

if (!empty($LANG12[8]) && ($mode === $LANG12[8])) { // submit
    if (COM_isAnonUser() &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['submitloginrequired'] == 1))) {
        COM_redirect($_CONF['site_url'] . '/index.php');
    } else {
        if ($type === 'story') {
            $msg = PLG_itemPreSave($type, $_POST);
            if (!empty($msg)) {
                $_POST['mode'] = $LANG12[32];
                $display = COM_errorLog($msg, 2) . submitstory();
                $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG12[6]));
                COM_output($display);
                exit;
            }
        }
        $display .= savesubmission($type, $_POST);
    }
} else {
    if ((strlen($type) > 0) && ($type !== 'story')) {
        if (SEC_hasRights("$type.edit") ||
            SEC_hasRights("$type.admin")) {
            COM_redirect($_CONF['site_admin_url'] . "/plugins/$type/index.php?mode=edit");
        }
    } elseif (SEC_hasRights('story.edit')) {
        COM_redirect($_CONF['site_admin_url'] . '/article.php?mode=edit');
    }

    switch ($type) {
        case 'story':
            $pagetitle = $LANG12[6];
            break;

        default:
            $pagetitle = '';
            break;
    }

    $noindex = '<meta name="robots" content="noindex"' . XHTML . '>' . LB;
    $display .= submissionform($type, $mode);
    $display = COM_createHTMLDocument(
        $display,
        array(
            'pagetitle'  => $pagetitle,
            'headercode' => $noindex,
        )
    );
}

COM_output($display);
