<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | block.php                                                                 |
// |                                                                           |
// | Geeklog block administration.                                             |
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
// $Id: block.php,v 1.52 2003/07/31 12:10:44 dhaun Exp $

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($HTTP_POST_VARS);

include('../lib-common.php');
include('auth.inc.php');

if (!SEC_hasrights('block.edit')) {
    $display .= COM_siteHeader()
        . COM_startBlock ($MESSAGE[30], '',
                          COM_getBlockTemplate ('_msg_block', 'header'))
        . $MESSAGE[31]
        . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
        . COM_siteFooter ();
    echo $display;
    exit;
}

/**
* Check for block topic access (need to handle 'all' and 'homeonly' as
* special cases)
*
* @param        string      $tid        ID for topic to check on
* @return       int     returns 3 for read/edit 2 for read only 0 for no access
*
*/
function hasBlockTopicAccess ($tid)
{
    $access = 0;

    if (($tid == 'all') || ($tid == 'homeonly')) {
        $access = 3;
    } else {
        $access = SEC_hasTopicAccess ($tid);
    }

    return $access;
}

/**
* Shows default block editor
*
* Default blocks are those blocks that Geeklog requires to function
* properly.  Because of their special role, they have restricted
* edit properties so this form shows that.
*
* @A        array       Array of data to show on form
* @access   int         Permissions this user has
*
*/ 
function editdefaultblock($A,$access) 
{
    global $_TABLES, $_USER, $LANG21, $_CONF, $LANG_ACCESS;

    $retval = '';

    $retval .= COM_startBlock ($LANG21[3], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $block_templates = new Template($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file('editor','defaultblockeditor.thtml');
    $block_templates->set_var('site_url', $_CONF['site_url']);
    $block_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $block_templates->set_var('layout_url', $_CONF['layout_url']);
    $block_templates->set_var('block_id', $A['bid']);
    $block_templates->set_var('lang_blocktitle', $LANG21[5]);
    $block_templates->set_var('block_title', stripslashes ($A['title']));
    $block_templates->set_var('lang_enabled', $LANG21[53]);
    if ($A['is_enabled'] == 1) {
        $block_templates->set_var('is_enabled', 'checked="CHECKED"');
    } else {
        $block_templates->set_var('is_enabled', '');
    }
    $block_templates->set_var('lang_blockhelpurl', $LANG21[50]);
    $block_templates->set_var('block_help', $A['help']);
    $block_templates->set_var('lang_includehttp', $LANG21[51]);
    $block_templates->set_var('lang_explanation', $LANG21[52]);
    $block_templates->set_var('block_name',$A['name']);
    $block_templates->set_var('lang_blockname', $LANG21[48]);
    $block_templates->set_var('lang_topic', $LANG21[6]);
    $block_templates->set_var('lang_all', $LANG21[7]);
    $block_templates->set_var('lang_side', $LANG21[39]);
    $block_templates->set_var('lang_left', $LANG21[40]);
    $block_templates->set_var('lang_right', $LANG21[41]);
    $block_templates->set_var('lang_save', $LANG21[54]);
    $block_templates->set_var('lang_cancel', $LANG21[55]);
    if ($A['onleft'] == 1) {
        $block_templates->set_var('left_selected', 'selected="selected"');
    } else if ($A['onleft'] == 0) {
        $block_templates->set_var('right_selected', 'selected="selected"');
    }
    $block_templates->set_var('lang_blockorder', $LANG21[9]);
    $block_templates->set_var('block_order', $A['blockorder']);
    $block_templates->set_var('lang_blocktype', $LANG21[10]);
    $block_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $block_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $block_templates->set_var('owner_username', DB_getItem($_TABLES['users'],'username',"uid = '{$A['owner_id']}'"));
    $block_templates->set_var('owner_id', $A['owner_id']);
    $block_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $block_templates->set_var('group_name', DB_getItem($_TABLES['groups'],'grp_name', "grp_id = '{$A['group_id']}'"));
    $block_templates->set_var('group_id', $A['group_id']);
    $block_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $block_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $block_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $block_templates->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
    $block_templates->parse('output','editor');
    $retval .= $block_templates->finish($block_templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Shows the block editor
*
* This will show a block edit form.  If this is a Geeklog default block it will
* send it off to editdefaultblock.
*
* @bid      string      ID of block to edit
*
*/
function editblock($bid='') 
{
    global $_TABLES, $_USER, $LANG21, $_CONF, $LANG_ACCESS;

    if (!empty($bid)) {
        $result = DB_query("SELECT * FROM {$_TABLES['blocks']} where bid ='$bid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access == 2 || $access == 0 || hasBlockTopicAccess ($A['tid']) < 3) {
            $retval .= COM_startBlock ($LANG21[44], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                    . $LANG21[45]
                    . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

                return $retval;
        } 
        if ($A['type'] == 'gldefault') {
            $retval .= editdefaultblock($A,$access);
            return $retval;
        }
    } else {
        $A['bid'] = 0;
        $A['blockorder'] = 0;
        $A['owner_id'] = $_USER['uid'];
        $A['group_id'] = DB_getItem ($_TABLES['groups'], 'grp_id',
                                     "grp_name = 'Block Admin'");
        $A['perm_owner'] = 3;
        $A['perm_group'] = 2;
        $A['perm_members'] = 2;
        $A['perm_anon'] = 2;
        $A['is_enabled'] = 1;
        $access = 3;
    }

    $block_templates = new Template($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file('editor','blockeditor.thtml');
    $block_templates->set_var('site_url', $_CONF['site_url']);
    $block_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $block_templates->set_var('layout_url', $_CONF['layout_url']);
    $block_templates->set_var('start_block_editor', COM_startBlock ($LANG21[3],
            '', COM_getBlockTemplate ('_admin_block', 'header')));
		
    if ($A['type'] != 'layout') {
        if (!empty($bid) && SEC_hasrights('block.delete')) {
            $block_templates->set_var('delete_option',"<input type=\"submit\" value=\"$LANG21[56]\" name=\"mode\">");
        }
    }

    $block_templates->set_var('block_bid', $A['bid']);
    $block_templates->set_var('lang_blocktitle', $LANG21[5]);
    $block_templates->set_var('block_title', stripslashes ($A['title']));
    $block_templates->set_var('lang_enabled', $LANG21[53]);
    if ($A['is_enabled'] == 1) {
        $block_templates->set_var('is_enabled', 'checked="CHECKED"');
    } else {
        $block_templates->set_var('is_enabled', '');
    }
    $block_templates->set_var('block_help', $A['help']);
    $block_templates->set_var('lang_blockhelpurl', $LANG21[50]);
    $block_templates->set_var('lang_includehttp', $LANG21[51]);
    $block_templates->set_var('lang_explanation', $LANG21[52]);
    $block_templates->set_var('block_name', $A['name']);
    $block_templates->set_var('lang_blockname', $LANG21[48]);
    $block_templates->set_var('lang_nospaces', $LANG21[49]);
    $block_templates->set_var('lang_topic', $LANG21[6]);
    $block_templates->set_var('lang_all', $LANG21[7]);
    $block_templates->set_var('lang_homeonly', $LANG21[43]);
    if ($A['tid'] == 'all') {
        $block_templates->set_var('all_selected', 'selected="selected"');
    } else if ($A['tid'] == 'homeonly') {
        $block_templates->set_var('homeonly_selected', 'selected="selected"');
    }
    $block_templates->set_var('topic_options', COM_topicList('tid,topic',$A['tid']));
    $block_templates->set_var('lang_side', $LANG21[39]);
    $block_templates->set_var('lang_left', $LANG21[40]);
    $block_templates->set_var('lang_right', $LANG21[41]);
    $block_templates->set_var('lang_save', $LANG21[54]);
    $block_templates->set_var('lang_cancel', $LANG21[55]);
    if ($A['onleft'] == 1) {
        $block_templates->set_var('left_selected', 'selected="selected"');
    } else if ($A['onleft'] == 0) {
        $block_templates->set_var('right_selected', 'selected="selected"');
    }
    $block_templates->set_var('lang_blockorder', $LANG21[9]);
    $block_templates->set_var('block_order', $A['blockorder']);
    $block_templates->set_var('lang_blocktype', $LANG21[10]);
    $block_templates->set_var('lang_normalblock', $LANG21[12]);
    $block_templates->set_var('lang_phpblock', $LANG21[27]);
    $block_templates->set_var('lang_portalblock', $LANG21[11]);
    if ($A['type'] == 'normal') {
        $block_templates->set_var('normal_selected', 'selected="selected"');
    } else if ($A['type'] == 'phpblock') {
        $block_templates->set_var('php_selected', 'selected="selected"');
    } else if ($A['type'] == 'portal') {
        $block_templates->set_var('portal_selected', 'selected="selected"');
    } 
    $block_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $block_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $block_templates->set_var('owner_username', DB_getItem($_TABLES['users'],'username',"uid = '{$A['owner_id']}'"));
    $block_templates->set_var('owner_id', $A['owner_id']);
    $block_templates->set_var('lang_group', $LANG_ACCESS['group']);

    $usergroups = SEC_getUserGroups();

    $groupdd = '';
    if ($access == 3) {
        $groupdd .= '<select name="group_id">' . LB;
        for ($i = 0; $i < count($usergroups); $i++) {
            $groupdd .= '<option value="'.$usergroups[key($usergroups)].'"';
            if ($A['group_id'] == $usergroups[key($usergroups)]) {
                $groupdd .= ' selected="selected"';
            }
            $groupdd .= '>'.key($usergroups).'</option>' . LB;
            next($usergroups);
        }
	$groupdd .= '</select>' . LB;
    } else {
        // They can't set the group then
        $groupdd.= DB_getItem($_TABLES['groups'],'grp_name',"grp_id = '{$A['group_id']}'")
			.'<input type="hidden" name="group_id" value="'.$A['group_id'].'">';
    }
    $block_templates->set_var('group_dropdown', $groupdd);
    $block_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $block_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $block_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));	
    $block_templates->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);
    $block_templates->set_var('lang_phpblockoptions', $LANG21[28]);
    $block_templates->set_var('lang_blockfunction', $LANG21[29]);
    $block_templates->set_var('block_phpblockfn', $A['phpblockfn']);
    $block_templates->set_var('lang_phpblockwarning', $LANG21[30]);
    $block_templates->set_var('lang_portalblockoptions', $LANG21[13]);
    $block_templates->set_var('lang_rdfurl', $LANG21[14]);
    $block_templates->set_var('block_rdfurl', $A['rdfurl']);
    $block_templates->set_var('lang_lastrdfupdate', $LANG21[15]);
    $block_templates->set_var('block_rdfupdated', $A['rdfupdated']);
    $block_templates->set_var('lang_normalblockoptions', $LANG21[16]);
    $block_templates->set_var('lang_blockcontent', $LANG21[17]);
    $block_templates->set_var('block_content', htmlspecialchars (stripslashes ($A['content'])));
    $block_templates->set_var ('end_block',
            COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));
    $block_templates->parse('output', 'editor');
    $retval .= $block_templates->finish($block_templates->get_var('output')); 

    return $retval;
}

/**
* Saves a block
*
* @bid          string      Block ID
* @title        string      Block title
* @type         string      Type of block
* @blockorder   int         Order block appears relative to the others
* @content      string      Content of block
* @tid          string      Topic block should appear in
* @rdfurl       string      URL to headline feed for portal blocks
* @rdfupdated   string      Date RSS/RDF feed was last updated
* @phpblockfn   string      Name of php function to call to get content
* @onleft       int         Flag indicates if block shows up on left or right
* @owner_id     int         ID of owner
* @group_id     int         ID of group block belongs to
* @perm_owner   array       Permissions the owner has on the object
* @perm_group   array       Permissions the group has on the object
* @perm_members array       Permissions the logged in members have
* @perm_anon    array       Permissinos anonymous users have
* @is_enabled   int         Flag, indicates if block is enabled or not
*
*/
function saveblock($bid,$name,$title,$help,$type,$blockorder,$content,$tid,$rdfurl,$rdfupdated,$phpblockfn,$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled) 
{
    global $_TABLES, $_CONF, $LANG21, $LANG01, $MESSAGE, $HTTP_POST_VARS;

    // Convert array values to numeric permission values
    list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);

    $access = 0;
    if (($bid > 0) && DB_count ($_TABLES['blocks'], 'bid', $bid) > 0) {
        $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['blocks']} WHERE bid = '{$bid}'");
        $A = DB_fetchArray ($result);
        $access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
                $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                $A['perm_anon']);
    } else {
        $access = SEC_hasAccess ($owner_id, $group_id, $perm_owner, $perm_group,
                $perm_members, $perm_anon);
    }
    if (($access < 3) || !hasBlockTopicAccess ($tid) || !SEC_inGroup ($group_id)) {
        $display .= COM_siteHeader('menu');
        $display .= COM_startBlock ($MESSAGE[30], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $MESSAGE[31];
        $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= COM_siteFooter();
        COM_errorLog("User {$_USER['username']} tried to illegally create or edit block $bid",1);
        echo $display;
        exit;
    } elseif (($type == 'normal' && !empty($title) && !empty($content)) OR ($type == 'portal' && !empty($title) && !empty($rdfurl)) OR ($type == 'layout' && !empty($content)) OR ($type == 'gldefault' && (strlen($blockorder)>0)) OR ($type == 'phpblock' && !empty($phpblockfn) && !empty($title))) {
        if ($is_enabled == 'on') {
            $is_enabled = 1;
        } else {
            $is_enabled = 0;
        }
        
        if ($type == 'portal') {
            $content = '';
            $rdfupdated = '';
            $phpblockfn = '';
        }
        if ($type == 'gldefault') {
            if ($name != 'older_stories') {
                $content = '';
            }
            $rdfurl = '';
            $rdfupdated = '';
            $phpblockfn = '';
        }
        if ($type == 'phpblock') {

            // NOTE: PHP Blocks must be within a function and the function
            // must start with phpblock_ as the prefix.  This will prevent
            // the arbitrary execution of code
            if (!(stristr($phpblockfn,'phpblock_'))) {
                $retval .= COM_siteHeader()
                        . COM_startBlock ($LANG21[37], '',
                                  COM_getBlockTemplate ('_msg_block', 'header'))
                        . $LANG21[38]
                        . COM_endBlock (COM_getBlockTemplate ('_msg_block',
                                                              'footer'))
                        . editblock ($bid)
                        . COM_siteFooter ();
                return $retval;
            }
            $content = '';
            $rdfurl = '';
            $rdfupdated = '';
        }
        if ($type == 'normal') {
            $rdfurl = '';
            $rdfupdated = '';
            $phpblockfn = '';
            $content = addslashes ($content);
        }
        if ($type == 'layout') {
            $rdfurl = '';
            $rdfupdated = '';
            $phpblockfn = '';
        }

        $title = addslashes (COM_stripslashes ($title));
        DB_save($_TABLES['blocks'],'bid,name,title,help,type,blockorder,content,tid,rdfurl,rdfupdated,phpblockfn,onleft,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled',"$bid,'$name','$title','$help','$type','$blockorder','$content','$tid','$rdfurl','$rdfupdated','$phpblockfn',$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled",$_CONF['site_admin_url'] . "/block.php?msg=11");

        if (($type == 'gldefault') && ($name == 'older_stories')) {
            COM_olderStuff ();
        }

    } else {
        $retval .= COM_siteHeader()
                . COM_startBlock ($LANG21[32], '',
                          COM_getBlockTemplate ('_msg_block', 'header'));
        if ($type == 'portal') {
            // Portal block is missing fields
            $retval .= $LANG21[33];
        } else if ($type == 'phpblock') {
            // PHP Block is missing field
            $retval .= $LANG21[34];
        } else if ($type == 'normal') {
            // Normal block is missing field
            $retval .= $LANG21[35];
        } else if ($type == 'gldefault') {
            // Default geeklog field missing 
            $retval .= $LANG21[42];
        } else {
            // Layout block missing content
            $retval .= $LANG21[36];
        }
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                . editblock ($bid)
                . COM_siteFooter ();
    }
	
    return $retval;
}

/**
* Lists all block in the system
*
*/
function listblocks() 
{
    global $_CONF, $_TABLES, $LANG21, $LANG32, $LANG_ACCESS;

    $retval = '';

    $block_templates = new Template($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file(array('list'=>'listblocks.thtml', 'row'=>'listitem.thtml'));

    $retval .= COM_startBlock ($LANG21[19], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
    $block_templates->set_var('site_url', $_CONF['site_url']);
    $block_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $block_templates->set_var('layout_url', $_CONF['layout_url']);
    $block_templates->set_var('lang_newblock', $LANG21[46]);
    $block_templates->set_var('lang_adminhome', $LANG21[47]);
    $block_templates->set_var('lang_instructions', $LANG21[25]);
    $block_templates->set_var('lang_blocktitle', $LANG21[20]);
    $block_templates->set_var('lang_access', $LANG_ACCESS['access']);
    $block_templates->set_var('lang_blocktype', $LANG21[22]);
    $block_templates->set_var('lang_side', $LANG21[39]);
    $block_templates->set_var('lang_blockorder', $LANG21[23]);
    $block_templates->set_var('lang_blocktopic', $LANG21[24]);
    $block_templates->set_var('lang_enabled', $LANG21[53]);
 
    $result = DB_query("SELECT * FROM {$_TABLES['blocks']} ORDER BY onleft DESC,blockorder");
    $nrows = DB_numRows($result);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);

        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if (($access > 0) && (hasBlockTopicAccess ($A['tid']) > 0)) {
            if ($access == 3) {
                $access = $LANG_ACCESS['edit'];
            } else {
                $access = $LANG_ACCESS['readonly'];
            }
            $block_templates->set_var('block_access', $access);
            $block_templates->set_var('block_type',$A['type']);
            $block_templates->set_var('block_id', $A['bid']);
            $btitle = stripslashes ($A['title']);
            if (empty ($btitle)) {
                $btitle = '(' . $A['name'] . ')';
            }
            $block_templates->set_var('block_title', $btitle);

            if ($A['is_enabled'] == 1) {
                $enabled = $LANG32[20];
            } else {
                $enabled = $LANG32[21];
            }
            $block_templates->set_var ('block_enabled', $enabled);

            if ($A['onleft'] == 1) {
                $side = $LANG21[40];
            } else {
                $side = $LANG21[41];
            }
            $block_templates->set_var('block_side', $side);
            $block_templates->set_var('block_order', $A['blockorder']);
            $block_templates->set_var('block_topic', $A['tid']); 
            $block_templates->parse('blocklist_item', 'row', true);
        }
    }

    $block_templates->parse('output','list');
    $retval .= $block_templates->finish($block_templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

// MAIN
if (isset ($HTTP_POST_VARS['mode'])) {
    $mode = $HTTP_POST_VARS['mode'];
}
elseif (isset ($HTTP_GET_VARS['mode'])) {
    $mode = $HTTP_GET_VARS['mode'];
}
if (isset ($HTTP_POST_VARS['bid'])) {
    $bid = $HTTP_POST_VARS['bid'];
}
elseif (isset ($HTTP_GET_VARS['bid'])) {
    $bid = $HTTP_GET_VARS['bid'];
}

if (($mode == $LANG21[56]) && !empty ($LANG21[56])) { // delete
    if (!isset ($bid) || empty ($bid) || ($bid == 0)) {
        COM_errorLog ('Attempted to delete block bid=' . $bid);
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/block.php');
    } else {
        DB_delete($_TABLES['blocks'],'bid',$bid,$_CONF['site_admin_url'] . '/block.php?msg=12');
    }
} else if (($mode == $LANG21[54]) && !empty ($LANG21[54])) { // save
    $display .= saveblock($bid,$name,$title,$help,$type,$blockorder,$content,
        $tid,$rdfurl,$rdfupdated,$phpblockfn,$onleft,$owner_id,$group_id,
        $perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled);
} else if ($mode == 'edit') {
    $display .= COM_siteHeader()
        .editblock($bid)
        .COM_siteFooter();
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader()
        .COM_showMessage($msg)
        .listblocks()
        .COM_siteFooter();
}

echo $display;

?>
