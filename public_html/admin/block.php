<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | block.php                                                                 |
// |                                                                           |
// | Geeklog block administration.                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Michael Jervis    - mike AT fuckingbrit DOT com                  |
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
// $Id: block.php,v 1.69 2005/10/13 08:40:23 ospiess Exp $

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

require_once ('../lib-common.php');
require_once ('auth.inc.php');

if (!SEC_hasrights ('block.edit')) {
    $display .= COM_siteHeader ()
        . COM_startBlock ($MESSAGE[30], '',
                          COM_getBlockTemplate ('_msg_block', 'header'))
        . $MESSAGE[31]
        . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
        . COM_siteFooter ();
    COM_accessLog ("User {$_USER['username']} tried to illegally access the block administration screen");
    echo $display;
    exit;
}

/**
* Check for block topic access (need to handle 'all' and 'homeonly' as
* special cases)
*
* @param    string  $tid    ID for topic to check on
* @return   int             returns 3 for read/edit 2 for read only 0 for no access
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
* @param    array   $A      Array of data to show on form
* @param    int     $access Permissions this user has
* @return   string          HTML for default block editor
*
*/ 
function editdefaultblock ($A, $access) 
{
    global $_CONF, $_TABLES, $_USER, $LANG21, $LANG_ACCESS;

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
    $block_templates->set_var('lang_homeonly', $LANG21[43]);
    if ($A['tid'] == 'all') {
        $block_templates->set_var('all_selected', 'selected="selected"');
    } else if ($A['tid'] == 'homeonly') {
        $block_templates->set_var('homeonly_selected', 'selected="selected"');
    }
    $block_templates->set_var('topic_options', COM_topicList('tid,topic',$A['tid']));
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
* @param    string  $bid    ID of block to edit
* @return   string          HTML for block editor
*
*/
function editblock ($bid = '') 
{
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $LANG21, $LANG_ACCESS;

    $retval = '';

    if (!empty($bid)) {
        $result = DB_query("SELECT * FROM {$_TABLES['blocks']} WHERE bid ='$bid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access == 2 || $access == 0 || hasBlockTopicAccess ($A['tid']) < 3) {
            $retval .= COM_startBlock ($LANG21[44], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                    . $LANG21[45]
                    . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            COM_accessLog("User {$_USER['username']} tried to illegally create or edit block $bid.");

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
        if (isset ($_GROUPS['Block Admin'])) {
            $A['group_id'] = $_GROUPS['Block Admin'];
        } else {
            $A['group_id'] = SEC_getFeatureGroup ('block.edit');
        }
        SEC_setDefaultPermissions ($A, $_CONF['default_permissions_block']);
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
    $block_templates->set_var('max_url_length', 255);
    $block_templates->set_var('block_rdfurl', $A['rdfurl']);
    $block_templates->set_var('lang_rdflimit', $LANG21[62]);
    $block_templates->set_var('block_rdflimit', $A['rdflimit']);
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
* @param    string  $bid            Block ID
* @param    string  $title          Block title
* @param    string  $type           Type of block
* @param    int     $blockorder     Order block appears relative to the others
* @param    string  $content        Content of block
* @param    string  $tid            Topic block should appear in
* @param    string  $rdfurl         URL to headline feed for portal blocks
* @param    string  $rdfupdated     Date RSS/RDF feed was last updated
* @param    string  $rdflimit       max. number of entries to import from feed
* @param    string  $phpblockfn     Name of php function to call to get content
* @param    int     $onleft         Flag indicates if block shows up on left or right
* @param    int     $owner_id       ID of owner
* @param    int     $group_id       ID of group block belongs to
* @param    array   $perm_owner     Permissions the owner has on the object
* @param    array   $perm_group     Permissions the group has on the object
* @param    array   $perm_members   Permissions the logged in members have
* @param    array   $perm_anon      Permissinos anonymous users have
* @param    int     $is_enabled     Flag, indicates if block is enabled or not
* @return   string                  HTML redirect or error message
*
*/
function saveblock ($bid, $name, $title, $help, $type, $blockorder, $content, $tid, $rdfurl, $rdfupdated, $rdflimit, $phpblockfn, $onleft, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon, $is_enabled) 
{
    global $_CONF, $_TABLES, $LANG01, $LANG21, $MESSAGE, $_POST;

    $retval = '';

    $title = addslashes (COM_stripslashes (strip_tags ($title)));
    $phpblockfn = addslashes (COM_stripslashes ($phpblockfn));
    if (empty($title)) {
        $retval .= COM_siteHeader()
                . COM_startBlock ($LANG21[63], '',
                          COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG21[64]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block',
                                                      'footer'))
                . editblock ($bid)
                . COM_siteFooter ();
        return $retval;
    }
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
        $retval .= COM_siteHeader('menu');
        $retval .= COM_startBlock ($MESSAGE[30], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= $MESSAGE[31];
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval .= COM_siteFooter();
        COM_accessLog("User {$_USER['username']} tried to illegally create or edit block $bid.");

        return $retval;
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
            $rdflimit = 0;
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
            $rdflimit = 0;
        }
        if ($type == 'normal') {
            $rdfurl = '';
            $rdfupdated = '';
            $rdflimit = 0;
            $phpblockfn = '';
            $content = addslashes ($content);
        }
        if ($rdflimit < 0) {
            $rdflimit = 0;
        }

        DB_save($_TABLES['blocks'],'bid,name,title,help,type,blockorder,content,tid,rdfurl,rdfupdated,rdflimit,phpblockfn,onleft,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled',"$bid,'$name','$title','$help','$type','$blockorder','$content','$tid','$rdfurl','$rdfupdated','$rdflimit','$phpblockfn',$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled");

        if (($type == 'gldefault') && ($name == 'older_stories')) {
            COM_olderStuff ();
        }

        return COM_refresh ($_CONF['site_admin_url'] . '/block.php?msg=11');
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
*
* Re-orders all blocks in steps of 10
*
*/
function reorderblocks()
{
    global $_TABLES;
    $sql = "SELECT * FROM {$_TABLES['blocks']} ORDER BY onleft asc, blockorder asc;";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    
    $lastside = 0;
    $blockOrd = 10;
    $stepNumber = 10;
    
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
    
        if ($lastside != $A['onleft']) { // we are switching left/right blocks
            $blockOrd = 10;              // so start with 10 again
        }
        if ($A['blockorder'] != $blockOrd) {  // only update incorrect ones
            $q = "UPDATE " . $_TABLES['blocks'] . " SET blockorder = '" .
                  $blockOrd . "' WHERE bid = '" . $A['bid'] ."'";
            DB_query($q);
        }
        $blockOrd += $stepNumber;
        $lastside = $A['onleft'];       // save variable for next round
    }
}

/**
* Lists all block in the system
*
* @return   string      HTML with list of blocks
*
*/
function listblocks ($offset, $curpage, $query = '', $query_limit = 50)
{
    global $_CONF, $_TABLES, $LANG21, $LANG32, $LANG_ACCESS, $_IMAGE_TYPE;

    // Added enhanced Block admin based on concept from stratosfear
    $retval = '';
    
    reorderblocks(); // re-assign block order numbers to 10, 20, etc.

    $order = COM_applyFilter ($_GET['order'], true);
    $prevorder = COM_applyFilter ($_GET['prevorder'], true);
    $direction = COM_applyFilter ($_GET['direction']);

    $block_templates = new Template($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file(array('list'=>'listblocks.thtml', 'row'=>'listitem.thtml', 'leftRight'=>'listside.thtml'));

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
    $block_templates->set_var('lang_blocktopic', $LANG21[24]);
    $block_templates->set_var('lang_enabled', $LANG21[53]);
    $block_templates->set_var('lang_move', "Move");
    $block_templates->set_var('lang_side', "Side");
    $block_templates->set_var('lang_order', "Order");
    $block_templates->set_var('lang_edit', "Edit");
    $block_templates->set_var('lang_search', "Search");
    $block_templates->set_var('lang_submit', "Submit");
    $block_templates->set_var('last_query', $query);
    $block_templates->set_var('lang_limit_results', "Limit Results");
    $editico = '<img src="' . $_CONF['layout_url'] . '/images/edit.'
             . $_IMAGE_TYPE . '" border="0" alt="' . $LANG01[4] . '" title="'
             . $LANG01[4] . '">';
    $block_templates->set_var('edit_icon', $editico);
 
    for ($i = 1; $i < 8; $i++) {
        $block_templates->set_var ('img_arrow' . $i, '');
    }
    
    
    if (empty ($direction)) {
        $direction = 'desc';
    } else if ($order == $prevorder) {
        $direction = ($direction == 'desc') ? 'asc' : 'desc';
    } else {
        $direction = ($direction == 'desc') ? 'desc' : 'asc';
    }
    
    switch($order) {
        case 1:
            $orderby = "onleft $direction, blockorder, title";
            break;
        case 2:
            $orderby = 'title';
            break;
        case 3:
            $orderby = 'type';
            break;
        case 4:
            $orderby = 'tid';
            break;
        case 5:
            $orderby = 'is_enabled';
            break;
        default:
            $orderby = "onleft $direction, blockorder, title";
            $order = 1;
            break;
    }


    if ($direction == 'asc') {
        $arrow = 'bararrowdown';
    } else {
        $arrow = 'bararrowup';
    }
    $block_templates->set_var ('img_arrow' . $order, '&nbsp;<img src="'
            . $_CONF['layout_url'] . '/images/' . $arrow . '.' . $_IMAGE_TYPE
            . '" border="0" alt="">');

    $block_templates->set_var ('direction', $direction);
    $block_templates->set_var ('page', $page);
    $block_templates->set_var ('prevorder', $order);
    if (empty($query_limit)) {
        $limit = 50;
    } else {
        $limit = $query_limit;
    }
    if ($query != '') {
        $block_templates->set_var ('query', urlencode($query) );
    } else {
        $block_templates->set_var ('query', '');
    }
    $block_templates->set_var ('query_limit', $query_limit);
    $block_templates->set_var($limit . '_selected', 'selected="selected"');
    
    $sql = "SELECT * FROM {$_TABLES['blocks']} ";
    if (!empty($query)) {
         $sql .= " WHERE (title LIKE '%$query%' OR content LIKE '%$query%')";
    }
    $sql.= " ORDER BY $orderby $direction LIMIT $offset,$limit";
    echo $sql;

    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    $block_templates->parse('blocklist_item', 'leftRight', true);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $block_templates->set_var('cssid', ($i%2)+1);

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
                $block_templates->set_var('enabled', 'checked="checked"');
            } else {
                $block_templates->set_var('enabled', '');
            }
            // $block_templates->set_var ('block_enabled', $enabled);

            if ($A['onleft'] == 1) {
                $side = $LANG21[40];
                $blockcontrol_image = 'block-right.' . $_IMAGE_TYPE;
                $moveTitleMsg = $LANG21[59];
                $block_templates->set_var('side', $LANG21[40]);
            } else {
                $blockcontrol_image = 'block-left.' . $_IMAGE_TYPE;
                $moveTitleMsg = $LANG21[60];
                $block_templates->set_var('side', $LANG21[41]);
            }
            
            $block_templates->set_var('blockcontrol_image', $blockcontrol_image);
            $block_templates->set_var('switchside', $switchside);
            $block_templates->set_var('upTitleMsg', $LANG21[58]);
            $block_templates->set_var('moveTitleMsg', $moveTitleMsg);
            $block_templates->set_var('dnTitleMsg', $LANG21[57]);
            
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

/**
* Move blocks UP, Down and Switch Sides - Left and Right
*
*/
function moveBlock()
{
    global $_CONF, $_TABLES, $LANG21, $_GET;

    $retval = '';

    $bid = $_GET['bid'];
    $where = $_GET['where'];

    // if the block id exists
    if (DB_count($_TABLES['blocks'], "bid", $bid) == 1) {

        switch ($where) {

            case ("up"): $q = "UPDATE " . $_TABLES['blocks'] . " SET blockorder = blockorder-11 WHERE bid = '" . $bid . "'";
                         DB_query($q);
                         break;

            case ("dn"): $q = "UPDATE " . $_TABLES['blocks'] . " SET blockorder = blockorder+11 WHERE bid = '" . $bid . "'";
                         DB_query($q);
                         break;

            case ("0"):  $q = "UPDATE " . $_TABLES['blocks'] . " SET onleft = '1', blockorder = blockorder-1 WHERE bid = '" . $bid ."'";
                         DB_query($q);
                         break;

            case ("1"):  $q = "UPDATE " . $_TABLES['blocks'] . " SET onleft = '0',blockorder = blockorder-1 WHERE bid = '" . $bid ."'";
                         DB_query($q);
                         break;
        }

    } else {
        COM_errorLOG("block admin error: Attempt to move an non existing block id: $bid");
    }
    echo COM_refresh($_CONF['site_admin_url'] . "/block.php");
    exit;
    return $retval;
}


/**
* Enable and Disable block
*/
function changeBlockStatus ($bid)
{
    global $_CONF, $_TABLES;

    if (DB_getItem($_TABLES['blocks'],"is_enabled", "bid=$bid")) {
        DB_query("UPDATE {$_TABLES['blocks']} set is_enabled = '0' WHERE bid=$bid");
        return;
    } else {
        DB_query("UPDATE {$_TABLES['blocks']} set is_enabled = '1' WHERE bid=$bid");
        return;
    }
}

/**
* Delete a block
*
* @param    string  $bid    id of block to delete
* @return   string          HTML redirect or error message
*
*/
function deleteBlock ($bid)
{
    global $_CONF, $_TABLES, $_USER;

    $result = DB_query ("SELECT tid,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['blocks']} WHERE bid ='$bid'");
    $A = DB_fetchArray($result);
    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
            $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    if (($access < 3) || (hasBlockTopicAccess ($A['tid']) < 3)) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete block $bid.");
        return COM_refresh ($_CONF['site_admin_url'] . '/block.php');
    }

    DB_delete ($_TABLES['blocks'], 'bid', $bid);

    return COM_refresh ($_CONF['site_admin_url'] . '/block.php?msg=12');
}

// MAIN
$mode = $_REQUEST['mode'];
$bid = COM_applyFilter ($_REQUEST['bid']);

if (isset ($_POST['blkChange'])) {
    changeBlockStatus ($_POST['blkChange']);
}

if (($mode == $LANG21[56]) && !empty ($LANG21[56])) { // delete
    if (!isset ($bid) || empty ($bid) || ($bid == 0)) {
        COM_errorLog ('Attempted to delete block, bid empty or null, value =' . $bid);
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/block.php');
    } else {
        $display .= deleteBlock ($bid);
    }
} else if (($mode == $LANG21[54]) && !empty ($LANG21[54])) { // save
    $display .= saveblock ($bid, $_POST['name'], $_POST['title'],
                $_POST['help'], $_POST['type'], $_POST['blockorder'],
                $_POST['content'], $_POST['tid'], $_POST['rdfurl'],
                $_POST['rdfupdated'],
                COM_applyFilter ($_POST['rdflimit'], true),
                $_POST['phpblockfn'], $_POST['onleft'],
                $_POST['owner_id'], $_POST['group_id'], $_POST['perm_owner'],
                $_POST['perm_group'], $_POST['perm_members'],
                $_POST['perm_anon'], $_POST['is_enabled']);
} else if ($mode == 'edit') {
    $display .= COM_siteHeader ()
             . editblock ($bid)
             . COM_siteFooter ();
} else if ($mode == 'move') {
    $display .= COM_siteHeader();
    $display .= moveBlock();
    $display .= listblocks();
    $display .= COM_siteFooter();
} else {  // 'cancel' or no mode at all
    $display .= COM_siteHeader ();
    $msg = 0;
    if (isset ($_POST['msg'])) {
        $msg = COM_applyFilter ($_POST['msg'], true);
    } else if (isset ($_GET['msg'])) {
        $msg = COM_applyFilter ($_GET['msg'], true);
    }
    if ($msg > 0) {
        $display .= COM_showMessage ($msg);
    }
    $offset = 0;
    if (isset ($_REQUEST['offset'])) {
        $offset = COM_applyFilter ($_REQUEST['offset'], true);
    }
    $page = 1;
    if (isset ($_REQUEST['page'])) {
        $page = COM_applyFilter ($_REQUEST['page'], true);
    }
    if ($page < 1) {
        $page = 1;
    }
    $display .= listblocks ($offset, $page, $_REQUEST['q'],
                           COM_applyFilter ($_REQUEST['query_limit'], true));
        $display .= COM_siteFooter();
}

echo $display;

?>
