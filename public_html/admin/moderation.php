<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | moderation.php                                                            |
// |                                                                           |
// | Geeklog main administration page.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
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
// $Id: moderation.php,v 1.41 2003/07/14 10:35:09 dhaun Exp $

require_once('../lib-common.php');
require_once('auth.inc.php');
require_once($_CONF['path_system'] . 'classes/plugin.class.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($HTTP_POST_VARS);

/**
* Prints the command & control block at the top
*
*/
function commandcontrol() 
{
    global $_CONF,$_TABLES,$LANG01,$LANG29;

    $retval = '';

    $admin_templates = new Template($_CONF['path_layout'] . 'admin/moderation');
    $admin_templates->set_file (array ('cc' => 'moderation.thtml',
                                       'ccitem' => 'ccitem.thtml'));
    
    $retval .= COM_startBlock ('Geeklog ' . VERSION . ' -- ' . $LANG29[34], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    if (SEC_hasRights('story.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_admin_url'] . '/story.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/story.gif');
        $admin_templates->set_var('option_label', $LANG01[11]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('block.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_admin_url'] . '/block.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/block.gif');
        $admin_templates->set_var('option_label',$LANG01[12]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('topic.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_admin_url'] . '/topic.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/topic.gif');
        $admin_templates->set_var('option_label', $LANG01[13]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('link.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_admin_url'] . '/link.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/link.gif');
        $admin_templates->set_var('option_label', $LANG01[14]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('event.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_admin_url'] . '/event.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/event.gif');
        $admin_templates->set_var('option_label', $LANG01[15]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('poll.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_admin_url'] . '/poll.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/poll.gif');
        $admin_templates->set_var('option_label', $LANG01[16]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('user.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_admin_url'] . '/user.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/user.gif');
        $admin_templates->set_var('option_label', $LANG01[17]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('group.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_admin_url'] . '/group.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/group.gif');
        $admin_templates->set_var('option_label', $LANG01[96]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('plugin.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_admin_url'] . '/plugins.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/plugins.gif');
        $admin_templates->set_var('option_label', $LANG01[98]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }

    $admin_templates->set_var('page_url', $_CONF['site_url'] . '/users.php?mode=logout');
    $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/logout.gif');
    $admin_templates->set_var('option_label',$LANG01[35]);
    $admin_templates->parse('cc_main_options','ccitem',true);

    $plugins = PLG_getCCOptions();
    for ($i = 1; $i <= count($plugins); $i++) {
    	$cur_plugin = current($plugins);
        $admin_templates->set_var('page_url', $cur_plugin->adminurl);
        $admin_templates->set_var('page_image', $cur_plugin->plugin_image);
        $admin_templates->set_var('option_label', $cur_plugin->adminlabel);
        $admin_templates->parse('plugin_options','ccitem',true);
	next($plugins);
    }

    if (count($plugins) == 0) {
        $admin_templates->set_var('plugin_options','');
    }

    $retval .= $admin_templates->parse('output','cc');

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
		
    if (SEC_hasRights('story.moderate')) {
        $retval .= itemlist('story');

        if ($_CONF['listdraftstories'] == 1) {
            $retval .= draftlist ();
        }
    }
    if (SEC_hasRights('link.moderate')) {
        $retval .= itemlist('link');
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
* Build part of an SQL request to check the topic permissions of current user.
*
* @return   string   SQL request to check for topic permissions (can be empty)
*
*/
function buildTopicSql ()
{
    global $_TABLES;

    $topicsql = '';
    $tresult = DB_query ("SELECT tid FROM {$_TABLES['topics']}"
                         . COM_getPermSQL ());
    $trows = DB_numRows ($tresult);
    if ($trows > 0) {
        $tids = array ();
        for ($i = 0; $i < $trows; $i++) {
            $T = DB_fetchArray ($tresult);
            $tids[] = $T['tid'];
        }
        if (sizeof ($tids) > 0) {
            $topicsql = " (tid IN ('" . implode ("','", $tids) . "'))";
        }
    }

    return $topicsql;
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
    case 'link':
        $retval .= COM_startBlock ($LANG29[36], 'cclinksubmission.html',
                COM_getBlockTemplate ('_admin_block', 'header'));
        $sql = "SELECT lid AS id,title,category,url FROM {$_TABLES['linksubmission']} ORDER BY title ASC";
        $H = array($LANG29[10],$LANG29[13],$LANG29[12]);
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
            $topicsql = buildTopicSql ();
            if (!empty ($topicsql)) {
                $topicsql = ' WHERE' . $topicsql;
            }
            $sql = "SELECT sid AS id,title,UNIX_TIMESTAMP(date) AS day,tid FROM {$_TABLES['storysubmission']}" . $topicsql . " ORDER BY date ASC";
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
            $A = DB_fetchArray($result);
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

            // Hack for clickable URLs. From a posting by Andreas Schwarz in
            // news:de.comp.lang.php <aieq4p$12jn2i$3@ID-16486.news.dfncis.de>
            for ($j = 1; $j <= 3; $j++) {
                $A[$j] = preg_replace("/((((ht|f)tps?):(\/\/)|www)[a-z0-9%&_\-\+,;=:@~#\/.\?\[\]]+(\/|[+0-9a-z]))/is",
                "<a href=\"\\1\" target=\"_BLANK\">\\1</a>", stripslashes ($A[$j]));
                $A[$j] = str_replace("<a href=\"www","<a href=\"http://www", $A[$j]);
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
    global $_TABLES, $_CONF, $LANG29;

    $retval .= COM_startBlock ($LANG29[40], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
    $emptypwd = md5('');
    $result = DB_query ("SELECT uid,username,fullname,email FROM {$_TABLES['users']} WHERE passwd = '$emptypwd'");
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
            $mod_templates->set_var('edit_submission_url', $_CONF['site_url'] .
                '/users.php?mode=profile&amp;uid=' . $A['uid']);
            $mod_templates->set_var('lang_edit', $LANG29[4]);
            $mod_templates->set_var('data_col1', stripslashes($A['username']));
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
    global $_TABLES, $_CONF, $LANG24, $LANG29;

    $retval .= COM_startBlock ($LANG29[35] . ' (' . $LANG24[34] . ')', '',
            COM_getBlockTemplate ('_admin_block', 'header'));

    $topicsql = buildTopicSql ();
    if (!empty ($topicsql)) {
        $topicsql = ' AND' . $topicsql;
    }

    $result = DB_query ("SELECT sid AS id,title,UNIX_TIMESTAMP(date) AS day,tid FROM {$_TABLES['stories']} WHERE (draft_flag = 1)" . $topicsql . COM_getPermSQL ('AND', 0, 3) . " ORDER BY date ASC");
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
            $mod_templates->set_var('data_col2', strftime ("%c", $A[day]));
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
    global $_TABLES, $_CONF;

    $retval = '';

    switch ($type) {
    case 'event':
        $id = 'eid';
        $table = $_TABLES['events'];
        $submissiontable = $_TABLES['eventsubmission'];
        $fields = 'eid,title,description,location,address1,address2,city,state,zipcode,datestart,timestart,dateend,timeend,url';
        break;
    case 'link':
        $id = 'lid';
        $table = $_TABLES['links'];
        $submissiontable = $_TABLES['linksubmission'];
        $fields = 'lid,category,url,description,title,date';
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
                $A['related'] = addslashes (COM_whatsRelated ($A['introtext'], $A['uid'], $A['tid']));
                $A['owner_id'] = $A['uid'];
                $A['title'] = addslashes ($A['title']);
                $A['introtext'] = addslashes ($A['introtext']);
                $result = DB_query ("SELECT group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['topics']} WHERE tid = '{$A['tid']}'");
                $T = DB_fetchArray ($result);
                DB_save ($_TABLES['stories'],'sid,uid,tid,title,introtext,related,date,commentcode,postmode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',
                "{$A['sid']},{$A['uid']},'{$A['tid']}','{$A['title']}','{$A['introtext']}','{$A['related']}','{$A['date']}',{$_CONF['comment_code']},'{$A['postmode']}',{$A['owner_id']},{$T['group_id']},{$T['perm_owner']},{$T['perm_group']},{$T['perm_members']},{$T['perm_anon']}");
                DB_delete($_TABLES["storysubmission"],"$id",$mid[$i]);
            } else if ($type == 'draft') {
                DB_query ("UPDATE {$_TABLES['stories']} SET draft_flag = 0 WHERE sid = {$mid[$i]}");
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
*/
function moderateusers ($uid, $action, $count)
{
    global $_TABLES, $_CONF, $LANG_CHARSET, $LANG04;

    for ($i = 1; $i <= $count; $i++) {
        switch ($action[$i]) {
            case 'delete': // Ok, delete everything related to this user
                // first, remove from all security groups
                DB_delete($_TABLES['group_assignments'],'ug_uid',$uid[$i]);
                DB_delete($_TABLES['userprefs'],'uid',$uid[$i]);
                DB_delete($_TABLES['userindex'],'uid',$uid[$i]);
                DB_delete($_TABLES['usercomment'],'uid',$uid[$i]);
                DB_delete($_TABLES['userinfo'],'uid',$uid[$i]);

                // now delete the user itself
                DB_delete($_TABLES['users'],'uid',$uid[$i]);
                break;
            case 'approve':
                $result = DB_query ("SELECT email,username FROM {$_TABLES['users']} WHERE uid = $uid[$i]");
                $nrows = DB_numRows($result);
                if ($nrows == 1) {
                    $A = DB_fetchArray($result);
                    srand((double)microtime()*1000000);
                    $passwd = rand();
                    $passwd = md5($passwd);
                    $passwd = substr($passwd,1,8);
                    $passwd2 = md5($passwd);
                    DB_change($_TABLES['users'],'passwd',"$passwd2",'username',$A['username']);

                    $mailtext = "{$LANG04[15]}\n\n";
                    $mailtext .= "{$LANG04[2]}: {$A['username']}\n";
                    $mailtext .= "{$LANG04[4]}: $passwd\n\n";
                    $mailtext .= "{$LANG04[14]}\n\n";
                    $mailtext .= "{$_CONF["site_name"]}\n";
                    $mailtext .= "{$_CONF['site_url']}\n";
                    if (empty ($LANG_CHARSET)) {
                        $charset = $_CONF['default_charset'];
                        if (empty ($charset)) {
                            $charset = "iso-8859-1";
                        }
                    }
                    else {
                        $charset = $LANG_CHARSET;
                    }
                    mail($A["email"], "{$_CONF["site_name"]}: {$LANG04[16]}",
                        $mailtext,
                        "From: {$_CONF["site_name"]} <{$_CONF["site_mail"]}>\r\nReturn-Path: <{$_CONF["site_mail"]}>\r\nX-Mailer: GeekLog " . VERSION . "\r\nContent-Type: text/plain; charset={$charset}");
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
$display .= COM_showMessage($msg);

switch ($mode) {
case 'moderation':
    if ($type == 'user') {
        $display .= moderateusers($id,$action,$count);
    } else {
        $display .= moderation($id,$action,$type,$count);
    }
    break;
default:
    $display .= commandcontrol();
    break;
}

$display .= COM_siteFooter();

echo $display;

?>
