<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | topic.php                                                                 |
// | Geeklog topic administration page.                                        |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@users.sourceforge.net                |
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
// $Id: topic.php,v 1.23 2002/07/30 13:52:31 dhaun Exp $

require_once('../lib-common.php');
require_once('auth.inc.php');

if (!SEC_hasRights('topic.edit')) {
    $display = COM_siteHeader('menu');
    $display .= COM_startBlock($MESSAGE[30]);
    $display .= $MESSAGE[32];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    echo $display;
    exit;
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

/**
* Show topic administration form
*
* @tid      string      ID of topic to edit
* 
*/ 
function edittopic($tid='') 
{
    global $_TABLES, $LANG27, $_CONF, $_USER, $LANG_ACCESS;

    $retval .= COM_startBlock($LANG27[1]);
    if (!empty($tid)) {
        $result = DB_query("SELECT * FROM {$_TABLES['topics']} WHERE tid ='$tid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access == 0 OR $access == 2) {
            $retval .= COM_startBlock($LANG27[12]);
            $retval .= $LANG27[13]; 
            $retval .= COM_endBlock();
            return $retval; 
        }
    }
    if (!is_array ($A) || empty ($A['owner_id'])) {
        $A['owner_id'] = $_USER['uid'];

        // this is the one instance where we default the group
        // most topics should belong to the Topic Admin group 
        // and the private flag should be turned OFF
        $A['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Topic Admin'");
        $A['perm_owner'] = 3;
        $A['perm_group'] = 3;
        $A['perm_members'] = 2;
        $A['perm_anon'] = 2;
        $access = 3;
    }
    $topic_templates = new Template($_CONF['path_layout'] . 'admin/topic');
    $topic_templates->set_file('editor','topiceditor.thtml');
    $topic_templates->set_var('site_url', $_CONF['site_url']);
    $topic_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $topic_templates->set_var('layout_url', $_CONF['layout_url']);
    if (!empty($tid) && SEC_hasRights('topic.edit')) {
        $topic_templates->set_var('delete_option',"<input type=\"submit\" value=\"$LANG27[21]\" name=\"mode\">");
    }
    $topic_templates->set_var('lang_topicid', $LANG27[2]);
    $topic_templates->set_var('topic_id', $A['tid']);
    $topic_templates->set_var('lang_donotusespaces', $LANG27[5]);
    $topic_templates->set_var('lang_accessrights', $LANG_ACCESS[accessrights]);
    $topic_templates->set_var('lang_owner', $LANG_ACCESS[owner]);
    $topic_templates->set_var('owner_username', DB_getItem($_TABLES['users'],'username',"uid = {$A['owner_id']}")); 
    $topic_templates->set_var('owner_id', $A['owner_id']);
    $topic_templates->set_var('lang_group', $LANG_ACCESS[group]);
    $topic_templates->set_var('lang_save', $LANG27[19]);
    $topic_templates->set_var('lang_cancel', $LANG27[20]);

    $usergroups = SEC_getUserGroups();

    if ($access == 3) {
        $groupdd = '<select name="group_id">';
        for ($i = 0; $i < count($usergroups); $i++) {
            $groupdd .= '<option value="' . $usergroups[key($usergroups)] . '"';
            if ($A['group_id'] == $usergroups[key($usergroups)]) {
                $groupdd .= ' selected="selected"';
            }
            $groupdd .= '>' . key($usergroups) . '</option>';
            next($usergroups);
        }
        $groupdd .= "</select>";
    } else { 
		// they can't set the group then
        $groupdd = DB_getItem($_TABLES['groups'],'grp_name',"grp_id = {$A['group_id']}");
        $groupdd .= '<input type="hidden" name="group_id" value="' . $A['group_id'] . '">';
	}
    $topic_templates->set_var('group_dropdown', $groupdd);

    $topic_templates->set_var('lang_permissions', $LANG_ACCESS[permissions]);
    $topic_templates->set_var('lang_permissions_key', $LANG_ACCESS[permissionskey]);
    $topic_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $topic_templates->set_var('lang_lockmsg', $LANG_ACCESS[lockmsg]);

	// show sort order only if they specified sortnum as the sort method
	if ($_CONF["sortmethod"] <> 'alpha') {
        $topic_templates->set_var('lang_sortorder', $LANG27[10]);
        $topic_templates->set_var('sort_order', '<input type="text" size="3" maxlength="3" name="sortnum" value="' . $A['sortnum'] . '">');
    } else {
        $topic_templates->set_var('lang_sortorder', $LANG27[14]);
        $topic_templates->set_var('sort_order', $LANG27[15]);
    }
    $topic_templates->set_var('lang_storiesperpage', $LANG27[11]);
    $topic_templates->set_var('story_limit', $A['limitnews']);
    $topic_templates->set_var('lang_defaultis', $LANG27[16]);
    $topic_templates->set_var('lang_topicname', $LANG27[3]);
    $topic_templates->set_var('topic_name', $A['topic']);
	if (empty($A['tid'])) { 
        $A['imageurl'] = '/images/icons/'; 
    }
    $topic_templates->set_var('lang_topicimage', $LANG27[4]);
    $topic_templates->set_var('image_url', $A['imageurl']); 
    $topic_templates->set_var('warning_msg', $LANG27[6]);
    $topic_templates->parse('output', 'editor');
    $retval .= $topic_templates->finish($topic_templates->get_var('output'));
	$retval .= COM_endBlock();
	return $retval;
}

###############################################################################
# Saves $tid to the database
function savetopic($tid,$topic,$imageurl,$sortnum,$limitnews,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) {
	global $_TABLES, $_CONF, $LANG27;

	if (!empty($tid) && !empty($topic)) {
		if ($imageurl == '/images/topics/') { 
			$imageurl = ''; 
		}	
		//Convert array values to numeric permission values
                list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
		DB_save($_TABLES['topics'],'tid, topic, imageurl, sortnum, limitnews, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon',"'$tid', '$topic', '$imageurl','$sortnum','$limitnews',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon",$_CONF['site_admin_url'] . "/topic.php?msg=13");
	} else {
		$retval .= COM_siteHeader('menu');
		$retval .= COM_errorLog($LANG27[7],2);
		$retval .= edittopic($tid);
		$retval .= COM_siteFooter();
		echo $retval;
	}
}

###############################################################################
# Displays a list of topics
function listtopics() {
	global $_TABLES, $LANG27, $_CONF, $LANG_ACCESS;
	
	$retval = '';

	$retval .= COM_startBlock($LANG27[8]);

    $topic_templates = new Template($_CONF['path_layout'] . 'admin/topic');
    $topic_templates->set_file(array('list'=>'topiclist.thtml', 'item'=>'listitem.thtml'));
    $topic_templates->set_var('site_url', $_CONF['site_url']);
    $topic_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $topic_templates->set_var('layout_url', $_CONF['layout_url']);
    $topic_templates->set_var('lang_newtopic', $LANG27[17]);
    $topic_templates->set_var('lang_adminhome', $LANG27[18]);
    $topic_templates->set_var('lang_instructions', $LANG27[9]); 
    $topic_templates->set_var('begin_row', '<tr align="center" valign="bottom">');

	$result = DB_query("SELECT * FROM {$_TABLES['topics']}");
	$nrows = DB_numRows($result);
	$counter = 1;

	for ($i = 0; $i < $nrows; $i++) {
		$A = DB_fetchArray($result);
        
		$access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);

        if ($access > 0) {
            if ($access == 3) {
                $access = $LANG_ACCESS[edit];
            } else {
                $access = $LANG_ACCESS[readonly];
            }
        } else {
            $access = $LANG_ACCESS[none];
        }   
     
        $topic_templates->set_var('topic_id', $A['tid']);
        $topic_templates->set_var('topic_name', $A['topic']);
        $topic_templates->set_var('topic_access', $access);
		if (!empty($A["imageurl"])) {
            $topic_templates->set_var('image_tag', '<img src="' . $_CONF['site_url'] . $A['imageurl'] . '" border="0" alt=""><br>');
		} else {
            $topic_templates->set_var('image_tag', '');
		}
		if ($counter == 5) {
			$counter = 1;
            $topic_templates->set_var('end_row','</tr>');
            $topic_templates->parse('list_row','item',true);
            $topic_templates->set_var('begin_row','<tr align="center" valign="bottom">');
		} else {
            $topic_templates->set_var('end_row','');
            $topic_templates->parse('list_row','item',true);
            $topic_templates->set_var('begin_row','');
			$counter = $counter + 1;
		}			
	}
    $topic_templates->set_var('end_row','</tr>');
    $topic_templates->parse('output', 'list');
    $retval .= $topic_templates->finish($topic_templates->get_var('output'));
	$retval .= COM_endBlock();

	return $retval;
}

###############################################################################
# MAIN
$display = '';

switch ($mode) {
	case "$LANG27[21]":
		DB_delete($_TABLES['stories'],'tid',$tid);
		DB_delete($_TABLES['blocks'],'tid',$tid);
		DB_delete($_TABLES['topics'],'tid',$tid,$_CONF['site_admin_url'] . '/topic.php?msg=14');
		break;
	case "$LANG27[19]":
		savetopic($tid,$topic,$imageurl,$sortnum,$limitnews,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
		break;
	case 'edit':
		$display .= COM_siteHeader('menu');
		$display .= edittopic($tid);
		$display .= COM_siteFooter();
		break;
	case "$LANG27[20]":
	default:
		$display .= COM_siteHeader('menu');
		$display .= COM_showMessage($msg);
		$display .= listtopics();
		$display .= COM_siteFooter();
		break;
}

echo $display;

?>
