<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | topic.php                                                                 |
// |                                                                           |
// | Geeklog topic administration page.                                        |
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
// $Id: topic.php,v 1.37 2003/06/28 11:29:03 dhaun Exp $

require_once('../lib-common.php');
require_once('auth.inc.php');

if (!SEC_hasRights('topic.edit')) {
    $display = COM_siteHeader ('menu');
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[32];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    echo $display;
    exit;
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($HTTP_POST_VARS);

/**
* Show topic administration form
*
* @tid      string      ID of topic to edit
* 
*/ 
function edittopic($tid='') 
{
    global $_TABLES, $LANG27, $_CONF, $_USER, $LANG_ACCESS;

    if (!empty($tid)) {
        $result = DB_query("SELECT * FROM {$_TABLES['topics']} WHERE tid ='$tid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access == 0 OR $access == 2) {
            $retval .= COM_startBlock ($LANG27[12], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
            $retval .= $LANG27[13]; 
            $retval .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
            return $retval; 
        }
    }

    $retval .= COM_startBlock ($LANG27[1], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
    if (!is_array ($A) || empty ($A['owner_id'])) {
        $A['owner_id'] = $_USER['uid'];

        // this is the one instance where we default the group
        // most topics should belong to the Topic Admin group 
        // and the private flag should be turned OFF
        $A['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Topic Admin'");
        $A['perm_owner'] = 3;
        $A['perm_group'] = 2;
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
    $topic_templates->set_var('lang_accessrights',$LANG_ACCESS['accessrights']);
    $topic_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $topic_templates->set_var('owner_username', DB_getItem($_TABLES['users'],'username',"uid = {$A['owner_id']}")); 
    $topic_templates->set_var('owner_id', $A['owner_id']);
    $topic_templates->set_var('lang_group', $LANG_ACCESS['group']);
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

    $topic_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $topic_templates->set_var('lang_permissions_key', $LANG_ACCESS['permissionskey']);
    $topic_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));

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
    $topic_templates->set_var('topic_name', stripslashes ($A['topic']));
	if (empty($A['tid'])) { 
        $A['imageurl'] = '/images/icons/'; 
    }
    $topic_templates->set_var('lang_topicimage', $LANG27[4]);
    $topic_templates->set_var('image_url', $A['imageurl']); 
    $topic_templates->set_var('warning_msg', $LANG27[6]);

    $topic_templates->set_var ('lang_defaulttopic', $LANG27[22]);
    $topic_templates->set_var ('lang_defaulttext', $LANG27[23]);
    if ($A['is_default'] == 1) {
        $topic_templates->set_var ('default_checked', 'checked="checked"');
    } else {
        $topic_templates->set_var ('default_checked', '');
    }

    $topic_templates->parse('output', 'editor');
    $retval .= $topic_templates->finish($topic_templates->get_var('output'));
	$retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

	return $retval;
}

###############################################################################
# Saves $tid to the database
function savetopic($tid,$topic,$imageurl,$sortnum,$limitnews,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_default)
{
    global $_TABLES, $_CONF, $LANG27, $MESSAGE;

    // Convert array values to numeric permission values
    list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);

    $tid = str_replace (' ', '', $tid); // silently remove spaces from topic id

    $access = 0;
    if (DB_count ($_TABLES['topics'], 'tid', $tid) > 0) {
        $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['topics']} WHERE tid = '{$tid}'");
        $A = DB_fetchArray ($result);
        $access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
                $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                $A['perm_anon']);
    } else {
        $access = SEC_hasAccess ($owner_id, $group_id, $perm_owner, $perm_group,
                $perm_members, $perm_anon);
    }
    if (($access < 3) || !SEC_inGroup ($group_id)) {
        $display .= COM_siteHeader ('menu');
        $display .= COM_startBlock ($MESSAGE[30], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $MESSAGE[31];
        $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= COM_siteFooter ();
        COM_errorLog("User {$_USER['username']} tried to illegally create or edit topic $tid",1);
        echo $display;
        exit;
    } elseif (!empty($tid) && !empty($topic)) {
		if ($imageurl == '/images/topics/') { 
			$imageurl = ''; 
		}	
        $topic = addslashes ($topic);

        if ($is_default == 'on') {
            $is_default = 1;
            DB_query ("UPDATE {$_TABLES['topics']} SET is_default = 0 WHERE is_default = 1");
        } else {
            $is_default = 0;
        }

		DB_save($_TABLES['topics'],'tid, topic, imageurl, sortnum, limitnews, is_default, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon',"'$tid', '$topic', '$imageurl','$sortnum','$limitnews',$is_default,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon",$_CONF['site_admin_url'] . "/topic.php?msg=13");
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
function listtopics()
{
	global $_TABLES, $LANG27, $_CONF, $LANG_ACCESS, $_THEME_URL;

	$retval = '';

	$retval .= COM_startBlock ($LANG27[8], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

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
                $access = $LANG_ACCESS['edit'];
            } else {
                $access = $LANG_ACCESS['readonly'];
            }

            $topic_templates->set_var('topic_id', $A['tid']);
            $topic_templates->set_var('topic_name', stripslashes ($A['topic']));
            $topic_templates->set_var('topic_access', $access);
            if ($A['is_default'] == 1) {
                $topic_templates->set_var ('default_topic', $LANG27[24]);
            } else {
                $topic_templates->set_var ('default_topic', '');
            }
		    if (!empty($A["imageurl"])) {
                if (isset ($_THEME_URL)) {
                    $imagebase = $_THEME_URL;
                } else {
                    $imagebase = $_CONF['site_url'];
                }
                $topic_templates->set_var('image_tag', '<img src="' . $imagebase . $A['imageurl'] . '" border="0" alt=""><br>');
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
	}
    $topic_templates->set_var('end_row','</tr>');
    $topic_templates->parse('output', 'list');
    $retval .= $topic_templates->finish($topic_templates->get_var('output'));
	$retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

	return $retval;
}

###############################################################################
# MAIN
$display = '';

if (($mode == $LANG27[21]) && !empty ($LANG27[21])) { // delete
    if (!isset ($tid) || empty ($tid)) {
        COM_errorLog ('Attempted to delete topic tid=' . $tid);
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/topic.php');
    } else {
        DB_delete($_TABLES['stories'],'tid',$tid);
        DB_delete($_TABLES['storysubmission'],'tid',$tid);
        DB_delete($_TABLES['blocks'],'tid',$tid);
        DB_delete($_TABLES['topics'],'tid',$tid,$_CONF['site_admin_url'] . '/topic.php?msg=14');
    }
} else if (($mode == $LANG27[19]) && !empty ($LANG27[19])) { // save
    savetopic($tid,$topic,$imageurl,$sortnum,$limitnews,$owner_id,$group_id,
            $perm_owner,$perm_group,$perm_members,$perm_anon,$is_default);
} else if ($mode == 'edit') {
    $display .= COM_siteHeader('menu');
    $display .= edittopic($tid);
    $display .= COM_siteFooter();
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader('menu');
    $display .= COM_showMessage($msg);
    $display .= listtopics();
    $display .= COM_siteFooter();
}

echo $display;

?>
