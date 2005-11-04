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
// $Id: moderation.php,v 1.66 2005/11/04 11:04:58 ospiess Exp $

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

    if (!empty ($url)) {
        $template->set_var ('page_url', $url);
        $template->set_var ('page_image', $image);
        $template->set_var ('option_label', $label);
        $template->set_var ('cell_width', ((int)(100 / ICONS_PER_ROW)) . '%');
        return $template->parse ('cc_main_options', 'ccitem', false);
    } else {
        return '';
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
                               
    $cc_arr = array(
                  array('condition' => SEC_hasRights('story.edit'),
                        'url' => $_CONF['site_admin_url'] . '/story.php',
                        'lang' => $LANG01[11], 'image' => '/images/icons/story.'),
                  array('condition' => SEC_hasRights('block.edit'),
                        'url' => $_CONF['site_admin_url'] . '/block.php',
                        'lang' => $LANG01[12], 'image' => '/images/icons/block.'),
                  array('condition' => SEC_hasRights('topic.edit'),
                        'url' => $_CONF['site_admin_url'] . '/topic.php',
                        'lang' => $LANG01[13], 'image' => '/images/icons/topic.'),
                  array('condition' => SEC_hasRights('event.edit'),
                        'url' => $_CONF['site_admin_url'] . '/event.php',
                        'lang' => $LANG01[15], 'image' => '/images/icons/event.'),
                  array('condition' => SEC_hasRights('user.edit'),
                        'url' => $_CONF['site_admin_url'] . '/user.php',
                        'lang' => $LANG01[17], 'image' => '/images/icons/user.'),
                  array('condition' => SEC_hasRights('group.edit'),
                        'url' => $_CONF['site_admin_url'] . '/group.php',
                        'lang' => $LANG01[96], 'image' => '/images/icons/group.'),
                  array('condition' => SEC_inGroup('Root'),
                        'url' => $_CONF['site_admin_url'] . '/syndication.php',
                        'lang' => $LANG01[38], 'image' => '/images/icons/syndication.'),
                  array('condition' => SEC_hasRights('story.ping'),
                        'url' => $_CONF['site_admin_url'] . '/trackback.php',
                        'lang' => $LANG01[116], 'image' => '/images/icons/trackback.'),
                  array('condition' => SEC_hasRights('plugin.edit'),
                        'url' => $_CONF['site_admin_url'] . '/plugins.php',
                        'lang' => $LANG01[98], 'image' => '/images/icons/plugins.'),
                  array('condition' => ($_CONF['allow_mysqldump'] == 1) && SEC_inGroup ('Root'),
                        'url' => $_CONF['site_admin_url'] . '/database.php',
                        'lang' => $LANG01[103], 'image' => '/images/icons/database.'),
                  array('condition' => ($_CONF['link_documentation'] == 1),
                        'url' => $_CONF['site_url'] . '/docs/',
                        'lang' => $LANG01[113], 'image' => '/images/icons/docs.'),
                  array('condition' => (SEC_inGroup ('Root')),
                        'url' => 'http://www.geeklog.net/versionchecker.php?version=' . VERSION,
                        'lang' => $LANG01[107], 'image' => '/images/icons/versioncheck.')
    );

    for ($i=0; $i < count ($cc_arr); $i++) {
        if ($cc_arr[$i]['condition']) {
            $item = render_cc_item ($admin_templates,
                            $_CONF['site_admin_url'] . $cc_arr[$i]['url'],
                            $_CONF['layout_url'] . $cc_arr[$i]['image'] . $_IMAGE_TYPE,
                            $cc_arr[$i]['lang']);
            $items[$cc_arr[$i]['lang']] = $item;
        }
    }

    // now add the plugins
    $plugins = PLG_getCCOptions ();
    for ($i = 0; $i < count ($plugins); $i++) {
        $cur_plugin = current ($plugins);
        $item = render_cc_item ($admin_templates, $cur_plugin->adminurl,
                        $cur_plugin->plugin_image, $cur_plugin->adminlabel);
        $items[$cur_plugin->adminlabel] = $item;
        next ($plugins);
    }

    if ($_CONF['sort_admin'])
    {
        ksort($items);
    }
     // logout is always the last entry
    $item = render_cc_item ($admin_templates,
                    $_CONF['site_url'] . '/users.php?mode=logout',
                    $_CONF['layout_url'] . '/images/icons/logout.' . $_IMAGE_TYPE,
                    $LANG01[35]);
    $items[$LANG01[35]] = $item;
    reset($items);
    $cols = 0;
    while (list($key, $val) = each($items))
    {
        $cc_main_options .= "$val\n";
        $cols++;
        if ($cols == ICONS_PER_ROW)
        {
            $admin_templates->set_var('cc_main_options', $cc_main_options);
            $admin_templates->parse ('cc_rows', 'ccrow', true);
            $admin_templates->clear_var ('cc_main_options');
            $cc_main_options = '';
            $cols = 0;
        }
    }
    // "flush out" any unrendered entries
    $admin_templates->set_var('cc_main_options', $cc_main_options);
    $admin_templates->parse ('cc_rows', 'ccrow', true);
    $admin_templates->clear_var ('cc_main_options');

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
    global $_TABLES, $LANG29, $_CONF, $LANG_ADMIN;

    $isplugin = false;
    $retval = '';

    switch ($type) {
    case 'event':
        // $retval .= COM_startBlock ($LANG29[37], 'cceventsubmission.html',
        //         COM_getBlockTemplate ('_admin_block', 'header'));
        $sql = "SELECT eid AS id,title,datestart as day,url FROM {$_TABLES['eventsubmission']} ORDER BY datestart ASC";
        $H = array($LANG29[10],$LANG29[11],$LANG29[12]);
        $section_title = $LANG29[37];
        $section_help = 'cceventsubmission.html';
        break;
    default:
        if ((strlen($type) > 0) && ($type <> 'story')) {
            $function = 'plugin_itemlist_' . $type;
            if (function_exists($function)) {
                // Great, we found the plugin, now call it's itemlist method
                $plugin = new Plugin();
                $plugin = $function();
                $helpfile = $plugin->submissionhelpfile;
                // $retval .= COM_startBlock ($plugin->submissionlabel, $helpfile,
                //                COM_getBlockTemplate ('_admin_block', 'header'));
                $sql = $plugin->getsubmissionssql;
                $H = $plugin->submissionheading;
                $isplugin = true;
                $section_title = $plugin->submissionlabel;
                $section_help = $helpfile;
                break;
            }
        } else { # story submission
            //$retval .= COM_startBlock ($LANG29[35], 'ccstorysubmission.html',
            //        COM_getBlockTemplate ('_admin_block', 'header'));
            $sql = "SELECT sid AS id,title,UNIX_TIMESTAMP(date) AS day,tid FROM {$_TABLES['storysubmission']}" . COM_getTopicSQL ('WHERE') . " ORDER BY date ASC";
            $H =  array($LANG29[10],$LANG29[14],$LANG29[15]);
            $section_title = $LANG29[35];
            $section_help = 'ccstorysubmission.html';
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
        
        $header_arr = array(      # dislay 'text' and use table field 'field'
            array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
            array('text' => $H[0], 'field' => 1, 'sort' => false),
            array('text' => $H[1], 'field' => 2, 'sort' => false),
            array('text' => $H[2], 'field' => 3, 'sort' => false),
            array('text' => $LANG29[2], 'field' => 'delete', 'sort' => false),
            array('text' => $LANG29[1], 'field' => 'approve', 'sort' => false)
        );
        
        $defsort_arr = array('field' => '',
                         'direction' => '');

        $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home'])
        );
        
        $text_arr = array('has_menu'     =>  false,
                          'title'        => $section_title,
                          'help_url' => $section_help,
        );
        
        $query_arr = array('table' => '',
                           'sql' => $sql
        );
        
        $retval .="<form action=\"{$_CONF['site_admin_url']}/moderation.php\" method=\"POST\">"
                    ."<input type=\"hidden\" name=\"type\" value=\"$type\">"
                    ."<input type=\"hidden\" name=\"mode\" value=\"moderation\">";

        $retval .= ADMIN_list ($type, ADMIN_getListField_moderation, $header_arr, $text_arr,
                                $query_arr, $menu_arr, $defsort_arr);
        $retval .= "<center><input type=\"submit\" value=\"{$LANG_ADMIN['submit']}\"></center></form>\n\n";

        
    } else {
        if ($nrows <> -1) {
            $retval .= $LANG29[39] . "<br>";
        }
    }

    # $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

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
            $retval .= $LANG29[39] . "<br>";
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
            $retval .= $LANG29[39] . "<br>";
        }
    }
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
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
function moderation($mid,$action,$type)
{
    global $_CONF, $_TABLES;

    $retval = '';
    
    echo phpinfo();

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

    for ($i = 0; $i < count($action); $i++) {
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
                STORY_deleteStory($mid[$i]);
            } else {
                DB_delete($submissiontable,"$id",$mid[$i]);
            }
            break;
        case 'approve':
            if ($type == 'story') {
                $result = DB_query ("SELECT * FROM {$_TABLES['storysubmission']} WHERE sid = '$mid[$i]'");
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
                DB_save ($_TABLES['stories'],'sid,uid,tid,title,introtext,related,date,commentcode,trackbackcode,postmode,frontpage,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',
                "{$A['sid']},{$A['uid']},'{$A['tid']}','{$A['title']}','{$A['introtext']}','{$A['related']}','{$A['date']}','{$_CONF['comment_code']}','{$_CONF['trackback_code']}','{$A['postmode']}',$frontpage,{$A['owner_id']},{$T['group_id']},{$T['perm_owner']},{$T['perm_group']},{$T['perm_members']},{$T['perm_anon']}");
                DB_delete($_TABLES['storysubmission'],"$id",$mid[$i]);

                COM_rdfUpToDateCheck ();
                COM_olderStuff ();
            } else if ($type == 'event') {
                // first, copy entry from the submission to the events table
                DB_copy ($table, $fields, $fields, $submissiontable, $id,
                         $mid[$i]);
                // then set the default permissions
                $A = array ();
                SEC_setDefaultPermissions ($A,
                                           $_CONF['default_permissions_event']);
                DB_query ("UPDATE {$_TABLES['events']} SET perm_owner = {$A['perm_owner']}, perm_group = {$A['perm_group']}, perm_members = {$A['perm_members']}, perm_anon = {$A['perm_anon']} WHERE eid = {$mid[$i]}");
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
                    $sql = "UPDATE {$_TABLES['users']} SET status=3 WHERE uid={$A['uid']}";
                    DB_Query($sql);
                    USER_sendActivationEmail($A['username'], $A['email']);
                    //USER_createAndSendPassword ($A['username'], $A['email'], $A['uid']);
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
        $display .= moderation ($_POST['id'], $_POST['action'], $_POST['type']);
    }
} else {
    $display .= commandcontrol();
}

$display .= COM_siteFooter();

echo $display;

?>
