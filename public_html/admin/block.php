<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | block.php                                                                 |
// | Geeklog block administration.                                             |
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
// $Id: block.php,v 1.28 2002/04/14 20:16:07 dhaun Exp $

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

include('../lib-common.php');
include('auth.inc.php');

if (!SEC_hasrights('block.edit')) {
    $display .= COM_siteHeader()
        . COM_startBlock($MESSAGE[30])
        . $MESSAGE[31]
        . COM_endBlock()
        . COM_siteFooter();
    echo $display;
    exit;
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

    $retval .= COM_startBlock($LANG21[3]);

    $block_templates = new Template($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file('editor','defaultblockeditor.thtml');
    $block_templates->set_var('site_url', $_CONF['site_url']);
    $block_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $block_templates->set_var('layout_url', $_CONF['layout_url']);
    $block_templates->set_var('block_id', $A['bid']);
    $block_templates->set_var('lang_blocktitle', $LANG21[5]);
    $block_templates->set_var('block_title', $A['title']);
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
    $retval .= COM_endBlock();

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
        if ($access == 2 || $access == 0) {
            $retval .= COM_startBlock($LANG21[44])
                .$LANG21[45]
                .COM_endBlock();

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
        $A['perm_owner'] = 3;
        $A['perm_group'] = 3;
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
    $block_templates->set_var('start_block_editor', COM_startBlock($LANG21[3]));
		
    if ($A['type'] != 'layout') {
        if (!empty($bid) && SEC_hasrights('block.delete')) {
            $block_templates->set_var('delete_option','<input type="submit" value="delete" name="mode">');
        }
    }

    $block_templates->set_var('block_bid', $A['bid']);
    $block_templates->set_var('lang_blocktitle', $LANG21[5]);
    $block_templates->set_var('block_title', $A['title']);
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
    $block_templates->set_var('topic_options', COM_optionList($_TABLES['topics'],'tid,topic',$A['tid']));
    $block_templates->set_var('lang_side', $LANG21[39]);
    $block_templates->set_var('lang_left', $LANG21[40]);
    $block_templates->set_var('lang_right', $LANG21[41]);
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
    $block_templates->set_var('block_content', $A['content']);
    $block_templates->set_var('end_block', COM_endBlock());
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
	global $_TABLES, $_CONF,$LANG21,$LANG01,$HTTP_POST_VARS;

    if (($type == 'normal' && !empty($title) && !empty($content)) OR ($type == 'portal' && !empty($title) && !empty($rdfurl)) OR ($type == 'layout' && !empty($content)) OR ($type == 'gldefault' && (strlen($blockorder)>0)) OR ($type == 'phpblock' && !empty($phpblockfn) && !empty($title))) {
        if ($is_enabled == 'on') {
            $is_enabled = 1;
        } else {
            $is_enabled = 0;
        }
        
        if ($type == 'portal') {
            $content = '';
            $phpblockfn = '';
        }
        if ($type == 'gldefault') {
            $content = '';
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
                    .COM_startBlock($LANG21[37])
                    .$LANG21[38]
                    .COM_endBlock()
                    .editblock($bid)
                    .COM_siteFooter();
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
        }
        if ($type == 'layout') {
            $rdfurl = '';
            $rdfupdated = '';
            $phpblockfn = '';
        }

        // Convert array values to numeric permission values
		list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
	
        DB_save($_TABLES['blocks'],'bid,name,title,help,type,blockorder,content,tid,rdfurl,rdfupdated,phpblockfn,onleft,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled',"$bid,'$name','$title','$help','$type','$blockorder','$content','$tid','$rdfurl','$rdfupdated','$phpblockfn',$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled","admin/block.php?msg=11");


    } else {
        $retval .= COM_siteHeader()
            .COM_startBlock($LANG21[32]);
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
        $retval .= COM_endBlock()
            .editblock($bid)
            .COM_siteFooter();
    }
	
    return $retval;
}

/**
* Lists all block in the system
*
*/
function listblocks() 
{
    global $_TABLES, $LANG21, $_CONF, $LANG_ACCESS;

    $retval = '';

    $block_templates = new Template($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file(array('list'=>'listblocks.thtml', 'row'=>'listitem.thtml'));

    $retval .= COM_startBlock($LANG21[19]);
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
 
    $result = DB_query("SELECT * FROM {$_TABLES['blocks']} ORDER BY onleft DESC,blockorder");
    $nrows = DB_numRows($result);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);

        $block_templates->set_var('block_id', $A['bid']);
        $block_templates->set_var('block_title', $A['title']);

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
        $block_templates->set_var('block_access', $access);
        $block_templates->set_var('block_type',$A['type']);

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

    $block_templates->parse('output','list');
    $retval .= $block_templates->finish($block_templates->get_var('output'));
    $retval .= COM_endBlock();
		
    return $retval;
}

// MAIN

switch ($mode) {
case 'delete':
    $display .= DB_delete($_TABLES['blocks'],'bid',$bid,'admin/block.php?msg=12');
        break;
case 'save':
	$display .= saveblock($bid,$name,$title,$help,$type,$blockorder,$content,$tid,$rdfurl,$rdfupdated,$phpblockfn,$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled);
    break;
case 'edit':
    $display .= COM_siteHeader()
        .editblock($bid)
        .COM_siteFooter();
	break;
case 'cancel':
default:
    $display .= COM_siteHeader()
        .COM_showMessage($msg)
        .listblocks()
        .COM_siteFooter();
    break;
}

echo $display;

?>
