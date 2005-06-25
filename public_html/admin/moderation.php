<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | moderation.php                                                            |
// |                                                                           |
// | Geeklog main administration page.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: moderation.php,v 1.58 2005/06/25 17:14:34 dhaun Exp $

require_once ('../lib-common.php');
require_once ('auth.inc.php');
require_once ($_CONF['path_system'] . 'lib-user.php');
require_once ($_CONF['path_system'] . 'lib-story.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

define ('ICONS_PER_ROW', 6);

/**
* Renders an entry (icon) for the "Command and Control" center
*
* @param    template    $template   template to use
* @param    string      $url        URL the entry links to
* @param    string      $image      URL of the icon
* @param    string      $label      text to use under the icon
* @return   void
*
*/
function render_cc_item (&$template, $url = '', $image = '', $label = '')
{
    static $cols = 0;

    if (!empty ($url)) {
        $template->set_var ('page_url', $url);
        $template->set_var ('page_image', $image);
        $template->set_var ('option_label', $label);
        $template->set_var ('cell_width', ((int)(100 / ICONS_PER_ROW)) . '%');
        $template->parse ('cc_main_options', 'ccitem', true);
        $cols++;
    }

    if (($cols == ICONS_PER_ROW) || empty ($url)) {
        $template->parse ('cc_rows', 'ccrow', true);
        $template->clear_var ('cc_main_options');
        $cols = 0;
    }
}

/**
* Prints the command & control block at the top
*
*/
function commandcontrol() 
{
    global $_CONF, $_TABLES, $LANG01, $LANG29, $_IMAGE_TYPE;

    $retval = '';

    $admin_templates = new Template($_CONF['path_layout'] . 'admin/moderation');
    $admin_templates->set_file (array ('cc'     => 'moderation.thtml',
                                       'ccrow'  => 'ccrow.thtml',
                                       'ccitem' => 'ccitem.thtml'));
    
    $retval .= COM_startBlock ('Geeklog ' . VERSION . ' -- ' . $LANG29[34], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    if (SEC_hasRights('story.edit')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/story.php',
                        $_CONF['layout_url'] . '/images/icons/story.' . $_IMAGE_TYPE,
                        $LANG01[11]);
    }
    if (SEC_hasRights('block.edit')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/block.php',
                        $_CONF['layout_url'] . '/images/icons/block.' . $_IMAGE_TYPE,
                        $LANG01[12]);
    }
    if (SEC_hasRights('topic.edit')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/topic.php',
                        $_CONF['layout_url'] . '/images/icons/topic.' . $_IMAGE_TYPE,
                        $LANG01[13]);
    }
    if (SEC_hasRights('event.edit')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/event.php',
                        $_CONF['layout_url'] . '/images/icons/event.' . $_IMAGE_TYPE,
                        $LANG01[15]);
    }
    if (SEC_hasRights('poll.edit')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/poll.php',
                        $_CONF['layout_url'] . '/images/icons/poll.' . $_IMAGE_TYPE,
                        $LANG01[16]);
    }
    if (SEC_hasRights ('user.edit')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/user.php',
                        $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE,
                        $LANG01[17]);
    }
    if (SEC_hasRights ('group.edit')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/group.php',
                        $_CONF['layout_url'] . '/images/icons/group.' . $_IMAGE_TYPE,
                        $LANG01[96]);
    }
    if (SEC_hasRights ('user.mail')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/mail.php',
                        $_CONF['layout_url'] . '/images/icons/mail.' . $_IMAGE_TYPE,
                        $LANG01[105]);
    }
    if (SEC_inGroup ('Root')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/syndication.php',
                        $_CONF['layout_url'] . '/images/icons/syndication.' . $_IMAGE_TYPE,
                        $LANG01[38]);
    }
    if (SEC_hasRights ('story.ping')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/trackback.php',
                        $_CONF['layout_url'] . '/images/icons/trackback.' . $_IMAGE_TYPE,
                        $LANG01[116]);
    }
    if (SEC_hasRights ('plugin.edit')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/plugins.php',
                        $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE,
                        $LANG01[98]);
    }

    // now add the plugins
    $plugins = PLG_getCCOptions ();
    for ($i = 0; $i < count ($plugins); $i++) {
    	$cur_plugin = current ($plugins);
        render_cc_item ($admin_templates, $cur_plugin->adminurl,
                        $cur_plugin->plugin_image, $cur_plugin->adminlabel);
        next ($plugins);
    }

    if (($_CONF['allow_mysqldump'] == 1) && SEC_inGroup ('Root')) {
        render_cc_item ($admin_templates,
                        $_CONF['site_admin_url'] . '/database.php',
                        $_CONF['layout_url'] . '/images/icons/database.' . $_IMAGE_TYPE,
                        $LANG01[103]);
    }

    if ($_CONF['link_documentation'] == 1) {
        render_cc_item ($admin_templates,
                        $_CONF['site_url'] . '/docs/',
                        $_CONF['layout_url'] . '/images/icons/docs.' . $_IMAGE_TYPE,
                        $LANG01[113]);
    }

    if (SEC_inGroup ('Root')) {
        render_cc_item ($admin_templates,
                'http://www.geeklog.net/versionchecker.php?version=' . VERSION,
                $_CONF['layout_url'] . '/images/icons/versioncheck.' . $_IMAGE_TYPE,
                $LANG01[107]);
    }

    // logout is always the last entry
    render_cc_item ($admin_templates,
                    $_CONF['site_url'] . '/users.php?mode=logout',
                    $_CONF['layout_url'] . '/images/icons/logout.' . $_IMAGE_TYPE,
                    $LANG01[35]);

    // "flush out" any unrendered entries
    render_cc_item ($admin_templates);

    $retval .= $admin_templates->parse('output','cc');

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    if (SEC_hasRights('story.moderate')) {
        $retval .= itemlist('story');

        if ($_CONF['listdraftstories'] == 1) {
            $retval .= draftlist ();
        }
    }
    if (SEC_hasRights('event.moderate')) {
        $retval .= itemlist('event');
    }
    if ($_CONF['usersubmission'] == 1) {
        if (SEC_hasRights ('user.edit') && SEC_hasRights ('user.delete')) {
            $retval .= userlist ();
        }
    }

    $retval .= PLG_showModerationList();

    return $retval;
}

/**
* Diplays items needing moderation
*
* Displays the moderation list of items from the submission tables
*
* @type     string      Type of object to build list for
*
*/
function itemlist($type) 
{
    global $_TABLES, $LANG29, $_CONF;

    $isplugin = false;
    $retval = '';

    switch ($type) {
    case 'event':
        $retval .= COM_startBlock ($LANG29[37], 'cceventsubmission.html',
                COM_getBlockTemplate ('_admin_block', 'header'));
        $sql = "SELECT eid AS id,title,datestart as day,url FROM {$_TABLES['eventsubmission']} ORDER BY datestart ASC";
        $H = array($LANG29[10],$LANG29[11],$LANG29[12]);
        break;
    default:
        if ((strlen($type) > 0) && ($type <> 'story')) {
            $function = 'plugin_itemlist_' . $type;
            if (function_exists($function)) {
                // Great, we found the plugin, now call it's itemlist method
                $plugin = new Plugin();
                $plugin = $function();
                $helpfile = $plugin->submissionhelpfile;
                $retval .= COM_startBlock ($plugin->submissionlabel, $helpfile,
                               COM_getBlockTemplate ('_admin_block', 'header'));
                $sql = $plugin->getsubmissionssql;
                $H = $plugin->submissionheading;
                $isplugin = true;
                break;
            }
        } else {
            $retval .= COM_startBlock ($LANG29[35], 'ccstorysubmission.html',
                    COM_getBlockTemplate ('_admin_block', 'header'));
            $sql = "SELECT sid AS id,title,UNIX_TIMESTAMP(date) AS day,tid FROM {$_TABLES['storysubmission']}" . COM_getTopicSQL ('WHERE') . " ORDER BY date ASC";
            $H =  array($LANG29[10],$LANG29[14],$LANG29[15]);
            break;
        }
    }

    // run SQL but this time ignore any errors
    if (!empty ($sql)) {
        $result = DB_query($sql,1);
    }
    if (empty ($sql) || DB_error()) {
        // was more than likely a plugin that doesn't need moderation
        //$nrows = -1;
        return;
    } else {
        $nrows = DB_numRows($result);
    }

    if ($nrows > 0) {
        $mod_templates = new Template($_CONF['path_layout'] . 'admin/moderation');
        $mod_templates->set_file(array('itemlist'=>'itemlist.thtml',
                                       'itemrows'=>'itemlistrows.thtml'));
        $mod_templates->set_var('form_action', $_CONF['site_admin_url'] . '/moderation.php');
        $mod_templates->set_var('item_type', $type);
        $mod_templates->set_var('num_rows', $nrows);
        $mod_templates->set_var('heading_col1', $H[0]);
        $mod_templates->set_var('heading_col2', $H[1]);
        $mod_templates->set_var('heading_col3', $H[2]);
        $mod_templates->set_var('lang_approve', $LANG29[2]);
        $mod_templates->set_var('lang_delete', $LANG29[1]);
 
        for ($i = 1; $i <= $nrows; $i++) {
            $A = DB_fetchArray($result, true);
            if ($type == 'story') {
                $A[2] = strftime("%c",$A[2]);
            }
            if ($isplugin)  {
                $mod_templates->set_var ('edit_submission_url',
                    $_CONF['site_admin_url'] . '/plugins/' . $type
                    . '/index.php?mode=editsubmission&amp;id=' . $A['id']);
            } else {
                $mod_templates->set_var('edit_submission_url', $_CONF['site_admin_url'] . '/' .  $type
                    . '.php?mode=editsubmission&amp;id=' . $A['id']); 
            }
            $mod_templates->set_var('lang_edit', $LANG29[3]);

            for ($j = 1; $j <= 3; $j++) {
                $A[$j] = COM_makeClickableLinks (stripslashes ($A[$j]));
            }
            $mod_templates->set_var('data_col1', $A[1]);
            $mod_templates->set_var('data_col2', $A[2]);
            $mod_templates->set_var('data_col3', $A[3]);
            $mod_templates->set_var('cur_row', $i);
            $mod_templates->set_var('item_id', $A[0]);
            $mod_templates->parse('list_of_items','itemrows',true);
        }
        $mod_templates->set_var('lang_submit', $LANG29[38]);
        $mod_templates->parse('output','itemlist');
        $retval .= $mod_templates->finish($mod_templates->get_var('output'));
    } else {
        if ($nrows <> -1) {
            $retval .= $LANG29[39];
        }
    }

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Displays new user submissions
*
* When enabled, this will list all the new users which have applied for a
* site membership. When approving an application, an email containing the
* password is sent out immediately.
*
*/
function userlist ()
{
    global $_CONF, $_TABLES, $LANG29;

    $retval = COM_startBlock ($LANG29[40], '',
                              COM_getBlockTemplate ('_admin_block', 'header'));
    $result = DB_query ("SELECT uid,username,fullname,email FROM {$_TABLES['users']} WHERE status = 2");
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        $mod_templates = new Template($_CONF['path_layout'] . 'admin/moderation');
        $mod_templates->set_file(array('itemlist'=>'itemlist.thtml',
                                       'itemrows'=>'itemlistrows.thtml'));
        $mod_templates->set_var('form_action', $_CONF['site_admin_url'] . '/moderation.php');
        $mod_templates->set_var('item_type', 'user');
        $mod_templates->set_var('num_rows', $nrows);
        $mod_templates->set_var('heading_col1', $LANG29[16]);
        $mod_templates->set_var('heading_col2', $LANG29[17]);
        $mod_templates->set_var('heading_col3', $LANG29[18]);
        $mod_templates->set_var('lang_approve', $LANG29[2]);
        $mod_templates->set_var('lang_delete', $LANG29[1]);
 
        for ($i = 1; $i <= $nrows; $i++) {
            $A = DB_fetchArray($result);
            $mod_templates->set_var ('edit_submission_url',
                $_CONF['site_admin_url'] . '/user.php?mode=edit&amp;uid='
                . $A['uid']);
            $mod_templates->set_var('lang_edit', $LANG29[3]);
            $mod_templates->set_var ('data_col1', '<a href="'
                . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid='
                . $A['uid'] . '">' . stripslashes ($A['username']) . '</a>');
            $mod_templates->set_var('data_col2', stripslashes($A['fullname']));
            $mod_templates->set_var('data_col3', stripslashes($A['email']));
            $mod_templates->set_var('cur_row', $i);
            $mod_templates->set_var('item_id', $A['uid']);
            $mod_templates->parse('list_of_items','itemrows',true);
        }
        $mod_templates->set_var('lang_submit', $LANG29[38]);
        $mod_templates->parse('output','itemlist');
        $retval .= $mod_templates->finish($mod_templates->get_var('output'));
    } else {
        if ($nrows <> -1) {
            $retval .= $LANG29[39];
        }
    }
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Displays a list of all the stories that have the 'draft' flag set.
*
* When enabled, this will list all the stories that have been marked as
* 'draft'. Approving a story from this list will clear the draft flag and
* thus publish the story.
*
*/
function draftlist ()
{
    global $_CONF, $_TABLES, $LANG24, $LANG29;

    $retval = COM_startBlock ($LANG29[35] . ' (' . $LANG24[34] . ')', '',
            COM_getBlockTemplate ('_admin_block', 'header'));

    $result = DB_query ("SELECT sid AS id,title,UNIX_TIMESTAMP(date) AS day,tid FROM {$_TABLES['stories']} WHERE (draft_flag = 1)" . COM_getTopicSQL ('AND') . COM_getPermSQL ('AND', 0, 3) . " ORDER BY date ASC");
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        $mod_templates = new Template($_CONF['path_layout'] . 'admin/moderation');
        $mod_templates->set_file(array('itemlist'=>'itemlist.thtml',
                                       'itemrows'=>'itemlistrows.thtml'));
        $mod_templates->set_var('form_action', $_CONF['site_admin_url'] . '/moderation.php');
        $mod_templates->set_var('item_type', 'draft');
        $mod_templates->set_var('num_rows', $nrows);
        $mod_templates->set_var('heading_col1', $LANG29[10]);
        $mod_templates->set_var('heading_col2', $LANG29[14]);
        $mod_templates->set_var('heading_col3', $LANG29[15]);
        $mod_templates->set_var('lang_approve', $LANG29[2]);
        $mod_templates->set_var('lang_delete', $LANG29[1]);
 
        for ($i = 1; $i <= $nrows; $i++) {
            $A = DB_fetchArray($result);
            $mod_templates->set_var('edit_submission_url',
                    $_CONF['site_admin_url'] . '/story.php?mode=edit&amp;sid='
                    . $A['id']);
            $mod_templates->set_var('lang_edit', $LANG29[3]);
            $mod_templates->set_var('data_col1', stripslashes($A['title']));
            $mod_templates->set_var('data_col2', strftime ("%c", $A['day']));
            $mod_templates->set_var('data_col3', stripslashes($A['tid']));
            $mod_templates->set_var('cur_row', $i);
            $mod_templates->set_var('item_id', $A['id']);
            $mod_templates->parse('list_of_items','itemrows',true);
        }
        $mod_templates->set_var('lang_submit', $LANG29[38]);
        $mod_templates->parse('output','itemlist');
        $retval .= $mod_templates->finish($mod_templates->get_var('output'));
    } else {
        if ($nrows <> -1) {
            $retval .= $LANG29[39];
        }
    }
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Delete a story.
*
* This is used to delete a story from the list of stories with the 'draft' flag
* set (see function draftlist() above).
* Note: This code has been lifted from admin/story.php and should be kept in
*       sync with the code there.
*
* @sid      string      ID of the story to delete
*
*/
function deletestory ($sid)
{
    global $_TABLES, $_CONF;

    $result = DB_query ("SELECT ai_filename FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid'");
    $nrows = DB_numRows ($result);
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray ($result);
        $filename = $_CONF['path_html'] . 'images/articles/' . $A['ai_filename'];
        if (!unlink ($filename)) {
            echo COM_errorLog ('Unable to remove the following image from the article: ' . $filename);
            exit;
        }

        // remove unscaled image, if it exists
        $lFilename_large = substr_replace ($A['ai_filename'], '_original.',
                strrpos ($A['ai_filename'], '.'), 1);
        $lFilename_large_complete = $_CONF['path_html'] . 'images/articles/'
                                  . $lFilename_large;
        if (file_exists ($lFilename_large_complete)) {
            if (!unlink ($lFilename_large_complete)) {
                echo COM_errorLog ('Unable to remove the following image from the article: ' . $lFilename_large_complete);
                exit;
            }
        }
    }
    DB_delete ($_TABLES['article_images'], 'ai_sid', $sid);
    DB_delete ($_TABLES['comments'], 'sid', $sid);
    DB_delete ($_TABLES['stories'], 'sid', $sid);
}

/**
* Moderates an item
*
* This will actually perform moderation (approve or delete) one or more items
*
* @mid          array       Array of items
* @action       array       Array of actions to perform on items
* @count        int         Number of items to moderate
*
*/
function moderation($mid,$action,$type,$count) 
{
    global $_CONF, $_TABLES;

    $retval = '';

    switch ($type) {
    case 'event':
        $id = 'eid';
        $table = $_TABLES['events'];
        $submissiontable = $_TABLES['eventsubmission'];
        $fields = 'eid,title,description,location,address1,address2,city,state,zipcode,datestart,timestart,dateend,timeend,url';
        break;
    case 'story':
        $id = 'sid';
        $table = $_TABLES['stories'];
        $submissiontable = $_TABLES['storysubmission'];
        $fields = 'sid,uid,tid,title,introtext,date,postmode';
        break;
    default:
        if (strlen($type) <= 0) {
            // something is terribly wrong, bail
            $retval .= COM_errorLog("Unable to find type of $type in moderation() in moderation.php");
            return $retval;
        }
        list($id, $table, $fields, $submissiontable) = PLG_getModerationValues($type);
	}

    for ($i = 1; $i <= $count; $i++) {
        switch ($action[$i]) {
        case 'delete':
            if ((strlen($type) > 0) && ($type <> 'story') && ($type <> 'draft')) {
                // There may be some plugin specific processing that needs to
                // happen first.
                $retval .= PLG_deleteSubmission($type, $mid[$i]);
            }
            if (empty($mid[$i])) {
                $retval .= COM_errorLog("moderation.php just tried deleting everything in table $submissiontable because it got an empty id.  Please report this immediately to your site administrator");
                return $retval;
            }
            if ($type == 'draft') {
                deletestory ($mid[$i]);
            } else {
                DB_delete($submissiontable,"$id",$mid[$i]);
            }
            break;
        case 'approve':
            if ($type == 'story') {
                $result = DB_query ("SELECT * FROM {$_TABLES['storysubmission']} where sid = '$mid[$i]'");
                $A = DB_fetchArray ($result);
                $A['related'] = addslashes (implode ("\n", STORY_extractLinks ($A['introtext'])));
                $A['owner_id'] = $A['uid'];
                $A['title'] = addslashes ($A['title']);
                $A['introtext'] = addslashes ($A['introtext']);
                $result = DB_query ("SELECT group_id,perm_owner,perm_group,perm_members,perm_anon,archive_flag FROM {$_TABLES['topics']} WHERE tid = '{$A['tid']}'");
                $T = DB_fetchArray ($result);
                if ($T['archive_flag'] == 1) {
                    $frontpage = 0;
                } else {
                    $frontpage = 1;
                }
                DB_save ($_TABLES['stories'],'sid,uid,tid,title,introtext,related,date,commentcode,postmode,frontpage,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',
                "{$A['sid']},{$A['uid']},'{$A['tid']}','{$A['title']}','{$A['introtext']}','{$A['related']}','{$A['date']}',{$_CONF['comment_code']},'{$A['postmode']}',$frontpage,{$A['owner_id']},{$T['group_id']},{$T['perm_owner']},{$T['perm_group']},{$T['perm_members']},{$T['perm_anon']}");
                DB_delete($_TABLES['storysubmission'],"$id",$mid[$i]);

                COM_rdfUpToDateCheck ();
                COM_olderStuff ();
            } else if ($type == 'draft') {
                DB_query ("UPDATE {$_TABLES['stories']} SET draft_flag = 0 WHERE sid = {$mid[$i]}");

                COM_rdfUpToDateCheck ();
                COM_olderStuff ();
            } else {
                // This is called in case this is a plugin. There may be some
                // plugin specific processing that needs to happen.
                DB_copy($table,$fields,$fields,$submissiontable,$id,$mid[$i]);
                $retval .= PLG_approveSubmission($type,$mid[$i]);
            }
            break;
        }
    }

    $retval .= commandcontrol();

    return $retval;
}

/**
* Moderate user submissions
*
* Users from the user submission queue are either appoved (an email containing
* the password is sent out) or deleted.
*
* Note: The code for sending the password is coped&pasted from users.php
*
* @param    uid      int      array of items
* @param    action   string   action to perform ('delete', 'approve')
* @param    count    int      number of items
* @return            string   HTML for "command and control" page
*
*/
function moderateusers ($uid, $action, $count)
{
    global $_CONF, $_TABLES, $LANG04;

    $retval = '';

    for ($i = 1; $i <= $count; $i++) {
        switch ($action[$i]) {
            case 'delete': // Ok, delete everything related to this user
                if ($uid[$i] > 1) {
                    USER_deleteAccount ($uid[$i]);
                }
                break;
            case 'approve':
                $result = DB_query ("SELECT email,username, uid FROM {$_TABLES['users']} WHERE uid = $uid[$i]");
                $nrows = DB_numRows($result);
                if ($nrows == 1) {
                    $A = DB_fetchArray($result);

                    USER_createAndSendPassword ($A['username'], $A['email'], $A['uid']);
                }
                break;
        }
    }

    $retval .= commandcontrol();

    return $retval;
}

// MAIN

$display = '';
$display .= COM_siteHeader();
if (isset ($_GET['msg'])) {
    $display .= COM_showMessage ($_GET['msg']);
}

if (isset ($_POST['mode']) && ($_POST['mode'] == 'moderation')) {
    if ($_POST['type'] == 'user') {
        $display .= moderateusers ($_POST['id'], $_POST['action'],
                                   $_POST['count']);
    } else {
        $display .= moderation ($_POST['id'], $_POST['action'], $_POST['type'],
                                $_POST['count']);
    }
} else {
    $display .= commandcontrol();
}

$display .= COM_siteFooter();

echo $display;

?>
