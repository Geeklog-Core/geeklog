<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | moderation.php                                                            |
// | Geeklog main administration page.                                         |
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
// $Id: moderation.php,v 1.14 2001/11/19 22:39:30 tony_bibbs Exp $

include_once('../lib-common.php');
include_once('auth.inc.php');
include_once($_CONF['path_system'] . 'classes/plugin.class.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

/**
* Prints the command & control block at the top
*
*/
function commandcontrol() 
{
    global $_CONF,$LANG01,$LANG29;

    $retval = '';

    $admin_templates = new Template($_CONF['path_layout'] . 'admin/moderation');
    $admin_templates->set_file(array('cc'=>'moderation.thtml',
                                        'ccitem' => 'ccitem.thtml'));
    
    $retval .= COM_startBlock($LANG29[34]);

    if (SEC_hasRights('story.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_url'] . '/admin/story.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/story.gif');
        $admin_templates->set_var('option_label', $LANG01[11]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('block.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_url'] . '/admin/block.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/block.gif');
        $admin_templates->set_var('option_label',$LANG01[12]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('topic.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_url'] . '/admin/topic.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/topic.gif');
        $admin_templates->set_var('option_label', $LANG01[13]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('link.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_url'] . '/admin/link.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/link.gif');
        $admin_templates->set_var('option_label', $LANG01[14]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('event.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_url'] . '/admin/event.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/event.gif');
        $admin_templates->set_var('option_label', $LANG01[15]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('poll.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_url'] . '/admin/poll.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/poll.gif');
        $admin_templates->set_var('option_label', $LANG01[16]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('user.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_url'] . '/admin/user.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/user.gif');
        $admin_templates->set_var('option_label', $LANG01[17]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('group.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_url'] . '/admin/group.php');
        $admin_templates->set_var('page_image', $_CONF['layout_url'] . '/images/icons/group.gif');
        $admin_templates->set_var('option_label', $LANG01[96]);
        $admin_templates->parse('cc_main_options','ccitem',true);
    }
    if (SEC_hasRights('plugin.edit')) {
        $admin_templates->set_var('page_url', $_CONF['site_url'] . '/admin/plugins.php');
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

    $retval .= COM_endBlock();
		
    if (SEC_hasRights('story.moderate')) {
        $retval .= itemlist('story');
    }
    if (SEC_hasRights('link.moderate')) {
        $retval .= itemlist('link');
    }
    if (SEC_hasRights('event.moderate')) {
        $retval .= itemlist('event');
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
        $retval .= COM_startBlock($LANG29[37],'cceventsubmission.html');
        $sql = "SELECT eid AS id,title,datestart,url FROM {$_TABLES['eventsubmission']} ORDER BY datestart ASC";
        $H = array("Title","Start Date","URL");
        break;
    case 'link':
        $retval .= COM_startBlock($LANG29[36],'cclinksubmission.html');
        $sql = "SELECT lid AS id,title,category,url FROM {$_TABLES['linksubmission']} ORDER BY title ASC";
        $H = array("Title","Category","URL");
        break;
    default:
        if ((strlen($type) > 0) && ($type <> 'story')) {
            $function = 'plugin_itemlist_' . $type;
            if (function_exists($function)) {
                // Great, we found the plugin, now call it's itemlist method
                $plugin = new Plugin();
                $plugin = $function();
                if (!empty($plugin->submissionhelpfile)) {
                    $retval .= COM_startBlock($plugin->submissionlabel, $plugin->submissionhelpfile);
                } else {
                    $retval .= COM_startBlock($plugin->submissionlabel);
                }
                $sql = $plugin->getsubmissionssql;
                $H = $plugin->submissionheading;
                $isplugin = true;
                break;
            }
        } else {
            $retval .= COM_startBlock($LANG29[35],'ccstorysubmission.html');
            $sql = "SELECT sid AS id,title,UNIX_TIMESTAMP(date) AS day,tid FROM {$_TABLES['storysubmission']} ORDER BY date ASC";
            $H =  array("Title","Date","Topic");
            break;
        }
    }

    // run SQL but this time ignore any errors
    $result = DB_query($sql,1);

    if (DB_error()) {
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
        $mod_templates->set_var('form_action', $_CONF['site_url'] . '/admin/moderation.php');
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
                $mod_templates->set_var('edit_submission_url', $_CONF['site_url'] . '/admin/plugins/' . $type . '/' 
                    . $type . '.php?mode=editsubmission&id=' . $A['id']);
            } else {
                $mod_templates->set_var('edit_submission_url', $_CONF['site_url'] . '/admin/' .  $type
                    . '.php?mode=editsubmission&id=' . $A['id']); 
            }
            $mod_templates->set_var('lang_edit', $LANG29[3]);
            $mod_templates->set_var('data_col1', stripslashes($A[1]));
            $mod_templates->set_var('data_col2', stripslashes($A[2]));
            $mod_templates->set_var('data_col3', stripslashes($A[3]));
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
	
    $retval .= COM_endBlock();
	
    return $retval;
}

/**
* Moderates an item
*
* This will actually perform moderation (approve or delete) one or more items
*
* @mid          array       Array of items
* @action       array?      Array of actions to perform on items
* @count        int         Number of items to moderate
*
*/
function moderation($mid,$action,$type,$count) 
{
    global $_TABLES;

    $retval = '';

    switch ($type) {
    case 'event':
        $id = 'eid';
        $table = $_TABLES['events'];
        $fields = 'eid,title,description,location,datestart,dateend,url';
        break;
    case 'link':
        $id = 'lid';
        $table = $_TABLES['links'];
        $fields = 'lid,category,url,description,title';
        break;
	case 'story':
        $id = 'sid';
        $table = $_TABLES['stories'];
        $fields = 'sid,uid,tid,title,introtext,date';
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
            if ((strlen($type) > 0) && ($type <> 'story')) {
                //There may be some plugin specific processing that needs to happen first.
                $retval .= PLG_deleteSubmission($type, $mid[$i]);
            }
            if (empty($mid[$i])) {
                $retval .= COM_errorLog("moderation.php just tried deleting everyting in table {$type}submission because it got an empty id.  Please report this immediately to your site administrator");
                return $retval;
            }
            DB_delete($_TABLES["{$type}submission"],"$id",$mid[$i]);
            break;
        case 'approve':
            if ((strlen($type) > 0) && ($type <> 'story')) {
                //There may be some plugin specific processing that needs to happen first.
                $retval .= PLG_approveSubmission($type,$mid[$i]);
                DB_copy("$table","$fields","$fields",$submissiontable,"$id",$mid[$i]);
            } else {
                DB_copy("$table","$fields","$fields",$_TABLES["{$type}submission"],"$id",$mid[$i]);
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

switch ($mode) {
case 'moderation':
    $display .= moderation($id,$action,$type,$count);
    break;
default:
    $display .= commandcontrol();
    break;
}

$display .= COM_siteFooter();

echo $display;

?>
