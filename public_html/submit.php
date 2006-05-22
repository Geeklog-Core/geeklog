<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | submit.php                                                                |
// |                                                                           |
// | Let users submit stories and plugin stuff.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
// $Id: submit.php,v 1.105 2006/05/22 03:34:05 ospiess Exp $

require_once ('lib-common.php');
require_once ($_CONF['path_system'] . 'lib-story.php');

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
            $loginreq->set_var('login_message', $LANG_LOGIN[2]);
            $loginreq->set_var('site_url', $_CONF['site_url']);
            $loginreq->set_var('layout_url', $_CONF['layout_url']);
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
                    $retval = $LANG12[54];
                    COM_errorLog("Someone tried to submit an item to the $type-plugin, which cannot be found.", 1);
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

    if (isset ($_POST['mode']) && ($_POST['mode'] == $LANG12[32])) { // preview
        $A = $_POST;
    } else {
        $A['sid'] = COM_makeSid();
        $A['unixdate'] = time();
    }
    if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
        $A['uid'] = $_USER['uid'];
    } else {
        $A['uid'] = 1;
    }

    if (empty ($A['postmode'])) {
        $A['postmode'] = $_CONF['postmode'];
    }

    if (!empty ($topic)) {
        $allowed = DB_getItem ($_TABLES['topics'], 'tid',
            "tid = '" . addslashes ($topic) . "'" . COM_getTopicSql ('AND'));

        if ($allowed != $topic) {
            $topic = '';
        }
    }

    $title = '';
    $introtext = '';

    if (!empty($A['title'])) {
        $introtext = stripslashes ($A['introtext']);
        $introtext = htmlspecialchars ($introtext);
        $introtext = str_replace('$','&#36;',$introtext);
        $title = stripslashes ($A['title']);
        $title = str_replace('$','&#36;',$title);

        if ($A['postmode'] == 'html') {
            $A['introtext'] = addslashes(COM_checkHTML(COM_checkWords($A['introtext'])));
            $A['title'] = addslashes(COM_checkHTML(COM_checkWords($A['title'])));
        } else {
            $A['introtext'] = htmlspecialchars(COM_checkWords($A['introtext']));
            $A['introtext'] = str_replace('$','&#36;',$A['introtext']);

            $A['title'] = htmlspecialchars(COM_checkWords($A['title']));
            $A['title'] = str_replace('$','&#36;',$A['title']);
        }
        $introtext = str_replace('{','&#123;',$introtext);
        $introtext = str_replace('}','&#125;',$introtext);
        $A['introtext'] = str_replace('{','&#123;',$A['introtext']);
        $A['introtext'] = str_replace('}','&#125;',$A['introtext']);

        if (isset ($_CONF['show_topic_icon'])) {
            $A['show_topic_icon'] = $_CONF['show_topic_icon'];
        } else {
            $A['show_topic_icon'] = 1;
        }
        $A['hits'] = 0;
        $res = DB_query("SELECT username, fullname, photo FROM {$_TABLES['users']} WHERE uid = {$A['uid']}");
        $A += DB_fetchArray($res);
        $A['tid'] = COM_applyFilter($A['tid']);
        $res = DB_query("SELECT topic, imageurl FROM {$_TABLES['topics']} WHERE tid = '{$A['tid']}'");
        $A += DB_fetchArray($res);
        if ($A['postmode'] == 'plaintext') {
            $A['introtext'] = COM_makeClickableLinks ($A['introtext']);
        }
        $retval .= COM_startBlock($LANG12[32])
                . STORY_renderArticle ($A, 'p')
                . COM_endBlock();
    }

    $retval .= COM_startBlock($LANG12[6],'submitstory.html');

    $storyform = new Template($_CONF['path_layout'] . 'submit');
    if (isset ($_CONF['advanced_editor']) && ($_CONF['advanced_editor'] == 1) &&
        file_exists ($_CONF['path_layout'] . 'submit/submitstory_advanced.thtml')) { 
        $storyform->set_file('storyform','submitstory_advanced.thtml');
        $storyform->set_var ('change_editormode', 'onChange="change_editmode(this);"');
        $storyform->set_var ('lang_expandhelp', $LANG24[67]);
        $storyform->set_var ('lang_reducehelp', $LANG24[68]);
        $storyform->set_var ('show_texteditor', 'none');
        $storyform->set_var ('show_htmleditor', '');
    } else {
        $storyform->set_file('storyform','submitstory.thtml');
        if ($A['postmode'] == 'html') {
            $storyform->set_var ('show_texteditor', 'none');
            $storyform->set_var ('show_htmleditor', '');
        } else {
            $storyform->set_var ('show_texteditor', '');
            $storyform->set_var ('show_htmleditor', 'none');
        }
    }
    $storyform->set_var ('site_url', $_CONF['site_url']);
    $storyform->set_var ('layout_url', $_CONF['layout_url']);
    $storyform->set_var ('lang_username', $LANG12[27]);

    if (!empty($_USER['username'])) {
        $storyform->set_var('story_username', $_USER['username']);
        $storyform->set_var('status_url', $_CONF['site_url'] . '/users.php?mode=logout');
        $storyform->set_var('lang_loginout', $LANG12[34]);
    } else {
        $storyform->set_var('status_url', $_CONF['site_url'] . '/users.php');
        $storyform->set_var('lang_loginout', $LANG12[2]);
        $storyform->set_var('separator', ' | ');
        $storyform->set_var('seperator', ' | ');
        $storyform->set_var('create_account','<a href="' . $_CONF['site_url'] . '/users.php?mode=new">' . $LANG12[53] . '</a>');
    }
    
    $storyform->set_var('lang_title', $LANG12[10]);
    $storyform->set_var('story_title', htmlspecialchars ($title));
    $storyform->set_var('lang_topic', $LANG12[28]);
    if (empty ($A['tid']) && !empty ($topic)) {
        $A['tid'] = $topic;
    }
    if (empty ($A['tid'])) {
        $A['tid'] = DB_getItem ($_TABLES['topics'], 'tid', 'is_default = 1' . COM_getPermSQL ('AND'));
    }
    $storyform->set_var('story_topic_options', COM_topicList('tid,topic',$A['tid']));
    $storyform->set_var('lang_story', $LANG12[29]);
    $storyform->set_var('story_introtext', $introtext);
    $storyform->set_var('lang_postmode', $LANG12[36]);
    $storyform->set_var('story_postmode_options', COM_optionList($_TABLES['postmodes'],'code,name',$A['postmode']));
    $storyform->set_var('allowed_html', COM_allowedHTML());
    $storyform->set_var('story_uid', $A['uid']);
    $storyform->set_var('story_sid', $A['sid']);
    $storyform->set_var('story_date', $A['unixdate']);

    if (($_CONF['skip_preview'] == 1) || ($A['mode'] == $LANG12[32])) {
        $storyform->set_var('save_button', '<input name="mode" type="submit" value="' . $LANG12[8] . '">');
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
* @param    string  $id     Id of the new submission
*
*/
function sendNotification ($table, $A)
{
    global $_CONF, $_TABLES, $LANG01, $LANG08, $LANG24, $LANG29, $LANG_ADMIN;
           
    $title = COM_undoSpecialChars (stripslashes ($A['title']));
    if ($A['postmode'] == 'html') {
        $A['introtext'] = strip_tags ($A['introtext']);
    }
    $introtext = COM_undoSpecialChars (stripslashes ($A['introtext']));
    $storyauthor = DB_getItem ($_TABLES['users'], 'username',
                                "uid = {$A['uid']}");
    $topic = stripslashes (DB_getItem ($_TABLES['topics'], 'topic',
                                        "tid = '{$A['tid']}'"));

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
                                . '/article.php?story=' . $A['sid']);
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

    $A['title'] = COM_stripslashes ($A['title']);
    $A['introtext'] = COM_stripslashes ($A['introtext']);

    // pseudo-formatted story text for the spam check
    $spamcheck = '<h1>' . $A['title'] . '</h1><p>' . $A['introtext'] . '</p>';
    $result = PLG_checkforSpam ($spamcheck, $_CONF['spamx']);
    if ($result > 0) {
        COM_updateSpeedlimit ('submit');
        COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
    }

    $A['title'] = strip_tags (COM_checkWords ($A['title']));
    $A['title'] = addslashes (str_replace ('$', '&#36;', $A['title']));

    if ($A['postmode'] == 'html') {
        $introtext = COM_checkHTML (COM_checkWords ($A['introtext']));
    } else {
        $introtext = COM_makeClickableLinks (htmlspecialchars (COM_checkWords ($A['introtext'])));
        $A['postmode'] = 'plaintext';
    }

    $A['sid'] = addslashes (COM_makeSid ());
    if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
        $A['uid'] = $_USER['uid'];
    } else {
        $A['uid'] = 1;
    }
    COM_updateSpeedlimit ('submit');

    $A['tid'] = addslashes (COM_sanitizeID ($A['tid']));

    $result = DB_query ("SELECT group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['topics']} WHERE tid = '{$A['tid']}'" . COM_getTopicSQL ('AND'));
    if (DB_numRows ($result) == 0) {
        // user doesn't have access to this topic - bail
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }
    $T = DB_fetchArray ($result);

    if (($_CONF['storysubmission'] == 1) && !SEC_hasRights ('story.submit')) {
        $introtext = addslashes ($introtext);
        DB_save ($_TABLES['storysubmission'],
            'sid,tid,uid,title,introtext,date,postmode',
            "{$A['sid']},'{$A['tid']}',{$A['uid']},'{$A['title']}','$introtext',NOW(),'{$A['postmode']}'");

        if (isset ($_CONF['notification']) &&
                in_array ('story', $_CONF['notification'])) {
            sendNotification ($_TABLES['storysubmission'], $A);
        }

        $retval .= COM_refresh ($_CONF['site_url'] . '/index.php?msg=2');
    } else { // post this story directly
        $related = addslashes (implode ("\n", STORY_extractLinks ($introtext)));

        $introtext = addslashes ($introtext);
        DB_save ($_TABLES['stories'], 'sid,uid,tid,title,introtext,related,date,commentcode,trackbackcode,postmode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon', "{$A['sid']},{$A['uid']},'{$A['tid']}','{$A['title']}','$introtext','{$related}',NOW(),'{$_CONF['comment_code']}','{$_CONF['trackback_code']}','{$A['postmode']}',{$A['uid']},{$T['group_id']},{$T['perm_owner']},{$T['perm_group']},{$T['perm_members']},{$T['perm_anon']}");

        COM_rdfUpToDateCheck ();
        COM_olderStuff ();

        if (isset ($_CONF['notification']) &&
                in_array ('story', $_CONF['notification'])) {
            sendNotification ($_TABLES['stories'], $A);
        }

        $retval = COM_refresh (COM_buildUrl ($_CONF['site_url']
                               . '/article.php?story=' . $A['sid']));
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

    if ((strlen($type) > 0) && ($type <> 'story')) {
        // Update the submitspeedlimit for user - assuming Plugin approves
        // submission record
        COM_updateSpeedlimit ('submit');

        // see if this is a submission that needs to be handled by a plugin
        // and should include its own redirect
        $retval = PLG_saveSubmission ($type, $A);

        if (!$retval) {
            COM_errorLog("Could not save your submission. Bad type: $type");
        } elseif (empty($retval)) {
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
