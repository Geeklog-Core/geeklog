<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | block.php                                                                 |
// |                                                                           |
// | Geeklog block administration.                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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

/**
* Block administration page: Create, edit, delete, move, enable/disable blocks
* for the left and right sidebars of your Geeklog site.
*
*/

/**
* Geeklog common function library
*/
require_once '../lib-common.php';

/**
* Security check to ensure user even belongs on this page
*/
require_once 'auth.inc.php';

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

$display = '';

if (!SEC_hasRights('block.edit')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the block administration screen");
    COM_output($display);
    exit;
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
    global $_CONF, $_TABLES, $_USER, $LANG21, $LANG_ACCESS, $LANG_ADMIN;

    $retval = '';

    $retval .= COM_startBlock ($LANG21[3], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
    $token = SEC_createToken();
    $retval .= SEC_getTokenExpiryNotice($token);

    $block_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file('editor','defaultblockeditor.thtml');
    $block_templates->set_var('block_id', $A['bid']);
    // standard Admin strings
    $block_templates->set_var('lang_blocktitle', $LANG_ADMIN['title']);
    $block_templates->set_var('lang_enabled', $LANG_ADMIN['enabled']);
    $block_templates->set_var('lang_blockhelpurl', $LANG_ADMIN['help_url']);
    $block_templates->set_var('lang_topic', $LANG_ADMIN['topic']);
    $block_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $block_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $block_templates->set_var('lang_blocktype', $LANG_ADMIN['type']);

    $block_templates->set_var('block_title', stripslashes ($A['title']));
    if ($A['is_enabled'] == 1) {
        $block_templates->set_var('is_enabled', 'checked="checked"');
    } else {
        $block_templates->set_var('is_enabled', '');
    }
    $block_templates->set_var('block_help', $A['help']);
    $block_templates->set_var('lang_includehttp', $LANG21[51]);
    $block_templates->set_var('lang_explanation', $LANG21[52]);
    $block_templates->set_var('block_name',$A['name']);
    $block_templates->set_var('lang_blockname', $LANG21[48]);
    
    $block_templates->set_var('topic_selection',
                          TOPIC_getTopicSelectionControl ('block', $A['bid'], true, true));
    
    $block_templates->set_var('lang_side', $LANG21[39]);
    $block_templates->set_var('lang_left', $LANG21[40]);
    $block_templates->set_var('lang_right', $LANG21[41]);

    if ($A['onleft'] == 1) {
        $block_templates->set_var('left_selected', 'selected="selected"');
    } elseif ($A['onleft'] == 0) {
        $block_templates->set_var('right_selected', 'selected="selected"');
    }
    $block_templates->set_var('lang_blockorder', $LANG21[9]);
    $block_templates->set_var('block_order', $A['blockorder']);
    $block_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $block_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $ownername = COM_getDisplayName ($A['owner_id']);
    $block_templates->set_var('owner_username', DB_getItem($_TABLES['users'],
                                    'username', "uid = '{$A['owner_id']}'"));
    $block_templates->set_var('owner_name', $ownername);
    $block_templates->set_var('owner', $ownername);
    $block_templates->set_var('owner_id', $A['owner_id']);

    $block_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $block_templates->set_var('group_dropdown',
                              SEC_getGroupDropdown ($A['group_id'], $access));
    $block_templates->set_var('group_name', DB_getItem ($_TABLES['groups'],
                                    'grp_name', "grp_id = '{$A['group_id']}'"));
    $block_templates->set_var('group_id', $A['group_id']);
    $block_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $block_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $block_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $block_templates->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
    $block_templates->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);
    $block_templates->set_var('max_url_length', 255);
    $block_templates->set_var('gltoken_name', CSRF_TOKEN);
    $block_templates->set_var('gltoken', $token);
    $block_templates->parse('output','editor');

    $retval .= $block_templates->finish($block_templates->get_var('output'));
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

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
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $LANG01, $LANG21, $LANG_ACCESS,
           $LANG_ADMIN, $MESSAGE;

    $retval = '';

    if (!empty($bid)) {
        $sql['mysql'] = "SELECT * FROM {$_TABLES['blocks']} WHERE bid ='$bid'";

        $sql['mssql'] = "SELECT bid, is_enabled, name, type, title, blockorder, cast(content as text) as content, rdfurl, ";
        $sql['mssql'] .= "rdfupdated, rdflimit, onleft, phpblockfn, help, owner_id,group_id, ";
        $sql['mssql'] .= "perm_owner, perm_group, perm_members, perm_anon, allow_autotags FROM {$_TABLES['blocks']} WHERE bid ='$bid'";

        $sql['pgsql'] = "SELECT * FROM {$_TABLES['blocks']} WHERE bid ='$bid'";
        
        $result = DB_query($sql);
        $A = DB_fetchArray($result);
        
        $access = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']);
        if (($access == 2) || ($access == 0) ||
                (TOPIC_hasMultiTopicAccess('block', $bid) < 3)) {
            $retval .= COM_showMessageText($LANG21[45],
                                           $LANG_ACCESS['accessdenied']);
            COM_accessLog("User {$_USER['username']} tried to illegally create or edit block $bid.");

            return $retval;
        }
        if ($A['type'] == 'gldefault') {
            $retval .= editdefaultblock($A,$access);
            return $retval;
        }
    } else {
        $A['bid'] = 0;
        $A['is_enabled'] = 1;
        $A['name'] = '';
        $A['type'] = 'normal';
        $A['title'] = '';
        $A['tid'] = '';
        $A['blockorder'] = 0;
        $A['content'] = '';
        $A['allow_autotags'] = 0;
        $A['rdfurl'] = '';
        $A['rdfupdated'] = '';
        $A['rdflimit'] = 0;
        $A['onleft'] = 0;
        $A['phpblockfn'] = '';
        $A['help'] = '';
        $A['owner_id'] = $_USER['uid'];
        if (isset ($_GROUPS['Block Admin'])) {
            $A['group_id'] = $_GROUPS['Block Admin'];
        } else {
            $A['group_id'] = SEC_getFeatureGroup ('block.edit');
        }
        SEC_setDefaultPermissions ($A, $_CONF['default_permissions_block']);
        $access = 3;
    }

    $token = SEC_createToken();

    $block_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file('editor','blockeditor.thtml');
    $block_start = COM_startBlock($LANG21[3], '',
                        COM_getBlockTemplate('_admin_block', 'header'));
    $block_start .= LB . SEC_getTokenExpiryNotice($token);
    $block_templates->set_var('start_block_editor', $block_start);

    if (!empty($bid) && SEC_hasrights('block.delete')) {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s' . XHTML . '>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $block_templates->set_var ('delete_option',
                                   sprintf ($delbutton, $jsconfirm));
        $block_templates->set_var ('delete_option_no_confirmation',
                                   sprintf ($delbutton, ''));
    }

    $block_templates->set_var('block_bid', $A['bid']);
    // standard Admin strings
    $block_templates->set_var('lang_blocktitle', $LANG_ADMIN['title']);
    $block_templates->set_var('lang_enabled', $LANG_ADMIN['enabled']);
    $block_templates->set_var('lang_blockhelpurl', $LANG_ADMIN['help_url']);
    $block_templates->set_var('lang_topic', $LANG_ADMIN['topic']);
    $block_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $block_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $block_templates->set_var('lang_blocktype', $LANG_ADMIN['type']);
    $block_templates->set_var('lang_allowed_html', $LANG01[123]);

    $block_templates->set_var('block_title', stripslashes ($A['title']));
    $block_templates->set_var('lang_enabled', $LANG21[53]);
    if ($A['is_enabled'] == 1) {
        $block_templates->set_var('is_enabled', 'checked="checked"');
    } else {
        $block_templates->set_var('is_enabled', '');
    }
    $block_templates->set_var('block_help', $A['help']);
    $block_templates->set_var('lang_includehttp', $LANG21[51]);
    $block_templates->set_var('lang_explanation', $LANG21[52]);
    $block_templates->set_var('block_name', $A['name']);
    $block_templates->set_var('lang_blockname', $LANG21[48]);
    $block_templates->set_var('lang_nospaces', $LANG21[49]);
    
    $block_templates->set_var('topic_selection',
                          TOPIC_getTopicSelectionControl ('block', $A['bid'], true, true));    

    $block_templates->set_var('lang_side', $LANG21[39]);
    $block_templates->set_var('lang_left', $LANG21[40]);
    $block_templates->set_var('lang_right', $LANG21[41]);
    if ($A['onleft'] == 1) {
        $block_templates->set_var('left_selected', 'selected="selected"');
    } elseif ($A['onleft'] == 0) {
        $block_templates->set_var('right_selected', 'selected="selected"');
    }
    $block_templates->set_var('lang_blockorder', $LANG21[9]);
    $block_templates->set_var('block_order', $A['blockorder']);
    $block_templates->set_var('lang_normalblock', $LANG21[12]);
    $block_templates->set_var('lang_phpblock', $LANG21[27]);
    $block_templates->set_var('lang_portalblock', $LANG21[11]);
    if ($A['type'] == 'normal') {
        $block_templates->set_var('normal_selected', 'selected="selected"');
    } elseif ($A['type'] == 'phpblock') {
        $block_templates->set_var('php_selected', 'selected="selected"');
    } elseif ($A['type'] == 'portal') {
        $block_templates->set_var('portal_selected', 'selected="selected"');
    }
    $block_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $block_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $ownername = COM_getDisplayName ($A['owner_id']);
    $block_templates->set_var('owner_username', DB_getItem($_TABLES['users'],
                                    'username', "uid = '{$A['owner_id']}'"));
    $block_templates->set_var('owner_name', $ownername);
    $block_templates->set_var('owner', $ownername);
    $block_templates->set_var('owner_id', $A['owner_id']);

    $block_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $block_templates->set_var('group_dropdown',
                              SEC_getGroupDropdown ($A['group_id'], $access));
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
    if ($A['rdfupdated'] == '0000-00-00 00:00:00') {
        $block_templates->set_var ('block_rdfupdated', '');
    } else {
        $block_templates->set_var ('block_rdfupdated', $A['rdfupdated']);
    }
    $block_templates->set_var('lang_normalblockoptions', $LANG21[16]);
    $block_templates->set_var('lang_blockcontent', $LANG21[17]);
    $block_templates->set_var('lang_autotags', $LANG21[66]);
    $block_templates->set_var('lang_use_autotags', $LANG21[67]);

    $content = htmlspecialchars(stripslashes($A['content']));
    $content = str_replace(array('{', '}'), array('&#123;', '&#125;'),
                           $content);
    $block_templates->set_var('block_content', $content);

    if ($A['allow_autotags'] == 1) {
        $block_templates->set_var ('allow_autotags', 'checked="checked"');
    } else {
        $block_templates->set_var ('allow_autotags', '');
    }
    $block_templates->set_var('gltoken_name', CSRF_TOKEN);
    $block_templates->set_var('gltoken', $token);
    $block_templates->set_var('end_block',
            COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer')));
    $block_templates->parse('output', 'editor');
    $retval .= $block_templates->finish($block_templates->get_var('output'));

    return $retval;
}

/**
* Display two lists of blocks, separated by left and right
*
* @return   string  HTML for the two lists
*
*/
function listblocks()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG21, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
    $token = SEC_createToken();

    // writing the menu on top
    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'] . '/block.php?mode=edit',
              'text' => $LANG_ADMIN['create_new']),
        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $retval .= COM_startBlock($LANG21[19], '',
                              COM_getBlockTemplate('_admin_block', 'header'));
    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG21[25],
        $_CONF['layout_url'] . '/images/icons/block.'. $_IMAGE_TYPE
    );

    reorderblocks();
    
    // Left
    // Regular Blocks
    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG21[65], 'field' => 'blockorder', 'sort' => true),
        array('text' => $LANG21[46], 'field' => 'move', 'sort' => false),
        array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
        array('text' => $LANG21[48], 'field' => 'name', 'sort' => true),
        array('text' => $LANG_ADMIN['type'], 'field' => 'type', 'sort' => true),
        array('text' => $LANG_ADMIN['topic'], 'field' => 'topic', 'sort' => true),
        array('text' => $LANG_ADMIN['enabled'], 'field' => 'is_enabled', 'sort' => true)
    );

    $defsort_arr = array('field' => 'blockorder', 'direction' => 'asc');

    $text_arr = array(
        'has_extras' => true,
		'title'      => "$LANG21[20] ($LANG21[40])",
        'form_url'   => $_CONF['site_admin_url'] . '/block.php'
    );

    $query_arr = array(
        'table' => 'blocks',
        'sql' => "SELECT * FROM {$_TABLES['blocks']} WHERE onleft = 1",
        'query_fields' => array('title', 'content'),
        'default_filter' => COM_getPermSql ('AND')
    );

    // this is a dummy variable so we know the form has been used if all blocks
    // should be disabled on one side in order to disable the last one.
    // The value is the onleft var
    $form_arr = array(
        'top'    => '<input type="hidden" name="' . CSRF_TOKEN . '" value="'
                    . $token . '"' . XHTML . '>',
        'bottom' => '<input type="hidden" name="blockenabler" value="1"'
                    . XHTML . '>'
    );

	$retval .= ADMIN_list(
        'blocks', 'ADMIN_getListField_blocks', $header_arr, $text_arr,
        $query_arr, $defsort_arr, '', $token, '', $form_arr
    );
    

    // Dynamic blocks 
    $dyn_header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG21[65], 'field' => 'blockorder', 'sort' => true),
        array('text' => $LANG21[69], 'field' => 'plugin', 'sort' => true),
        array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
        array('text' => $LANG21[48], 'field' => 'name', 'sort' => true),
        array('text' => $LANG_ADMIN['type'], 'field' => 'type', 'sort' => true),
        array('text' => $LANG_ADMIN['topic'], 'field' => 'topic', 'sort' => true),
        array('text' => $LANG_ADMIN['enabled'], 'field' => 'is_enabled', 'sort' => true)
    );    

	
	$dyn_text_arr = array(
        'title'      => "$LANG21[22] ($LANG21[40])",
    );
	
	$leftblocks = PLG_getBlocksConfig('left', '', true);    
	
	// Sort Dynamic Blocks on Block Order
    usort($leftblocks, "cmpDynamicBlocks");

	$retval .= ADMIN_simpleList('ADMIN_getListField_dynamicblocks', $dyn_header_arr, $dyn_text_arr,
                    $leftblocks, '', $form_arr);
	

    // Right
    // Regular Blocks	
    $query_arr = array(
        'table' => 'blocks',
        'sql' => "SELECT * FROM {$_TABLES['blocks']} WHERE onleft = 0",
        'query_fields' => array('title', 'content'),
        'default_filter' => COM_getPermSql ('AND')
    );

    $text_arr = array(
        'has_extras' => true,
        'title'      => "$LANG21[20] ($LANG21[41])",
        'form_url'   => $_CONF['site_admin_url'] . '/block.php'
    );

    // this is a dummy-variable so we know the form has been used if all blocks should be disabled
    // on one side in order to disable the last one. The value is the onleft var
    $form_arr = array(
        'top'    => '<input type="hidden" name="' . CSRF_TOKEN . '" value="'
                    . $token . '"' . XHTML . '>',
        'bottom' => '<input type="hidden" name="blockenabler" value="0"'
                    . XHTML . '>'
    );

    $retval .= ADMIN_list (
        'blocks', 'ADMIN_getListField_blocks', $header_arr, $text_arr,
        $query_arr, $defsort_arr, '', $token, '', $form_arr
    );

	// Dynamic blocks
	$dyn_text_arr = array(
        'title'      => "$LANG21[22] ($LANG21[41])",
    );
	
	$rightblocks = PLG_getBlocksConfig('right', '', true);
	
	// Sort Dynamic Blocks on Block Order
    usort($rightblocks, "cmpDynamicBlocks");

	$retval .= ADMIN_simpleList('ADMIN_getListField_dynamicblocks', $dyn_header_arr, $dyn_text_arr,
                    $rightblocks, '', $form_arr);
	
	$retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
	
    return $retval;
}

/**
* Used by listblocks function when sorting the dynamic block array using the 
* usort function
*
* @return   boolean
*
*/
function cmpDynamicBlocks($a, $b)
{
    return $a["blockorder"] > $b["blockorder"];
}

/**
* Saves a block
*
* @param    string  $bid            Block ID
* @param    string  $title          Block title
* @param    string  $type           Type of block
* @param    int     $blockorder     Order block appears relative to the others
* @param    string  $content        Content of block
* @param    string  $tid            Ids of topics block is assigned to
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
function saveblock($bid, $name, $title, $help, $type, $blockorder, $content, $rdfurl, $rdfupdated, $rdflimit, $phpblockfn, $onleft, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon, $is_enabled, $allow_autotags)
{
    global $_CONF, $_TABLES, $LANG01, $LANG21, $MESSAGE, $_USER;

    $retval = '';

    $title = addslashes (COM_stripslashes (strip_tags ($title)));
    $phpblockfn = addslashes (COM_stripslashes (trim ($phpblockfn)));
    if (empty($title) || !TOPIC_checkTopicSelectionControl()) {
        $retval .= COM_showMessageText($LANG21[64], $LANG21[63])
                . editblock($bid);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG21[63]));
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
    
    if (($access < 3) || !TOPIC_hasMultiTopicAccess('topic') || !SEC_inGroup($group_id)) {
        $retval .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $MESSAGE[30]));
        COM_accessLog("User {$_USER['username']} tried to illegally create or edit block $bid.");

        return $retval;
    } elseif (!empty($name) AND
             ( ($type == 'normal' && !empty($title) && !empty($content))
            OR ($type == 'portal' && !empty($title) && !empty($rdfurl))
            OR ($type == 'phpblock' && !empty($phpblockfn) && !empty($title))
            OR ($type == 'gldefault' && (strlen($blockorder) > 0)) )) {
        if ($is_enabled == 'on') {
            $is_enabled = 1;
        } else {
            $is_enabled = 0;
        }
        if ($allow_autotags == 'on') {
            $allow_autotags = 1;
        } else {
            $allow_autotags = 0;
        }

        if ($type == 'portal') {
            $content = '';
            $rdfupdated = '';
            $phpblockfn = '';

            // get rid of possible extra prefixes (e.g. "feed://http://...")
            if (substr ($rdfurl, 0, 4) == 'rss:') {
                $rdfurl = substr ($rdfurl, 4);
            } elseif (substr ($rdfurl, 0, 5) == 'feed:') {
                $rdfurl = substr ($rdfurl, 5);
            }
            if (substr ($rdfurl, 0, 2) == '//') {
                $rdfurl = substr ($rdfurl, 2);
            }
            $rdfurl = COM_sanitizeUrl ($rdfurl, array ('http', 'https'));
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
                $retval .= COM_showMessageText($LANG21[38], $LANG21[37])
                        . editblock($bid);
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG21[37]));
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
            
            if ($allow_autotags == 1) {
                // Remove any autotags the user doesn't have permission to use
                $content = PLG_replaceTags($content, '', true);
            }
            $content = addslashes ($content);
        }
        if ($rdflimit < 0) {
            $rdflimit = 0;
        }
        if (!empty ($rdfurl)) {
            $rdfurl = addslashes ($rdfurl);
        }
        if (empty ($rdfupdated)) {
            $rdfupdated = '0000-00-00 00:00:00';
        }

        if ($bid > 0) {
            DB_save($_TABLES['blocks'],'bid,name,title,help,type,blockorder,content,rdfurl,rdfupdated,rdflimit,phpblockfn,onleft,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled,allow_autotags,rdf_last_modified,rdf_etag',"$bid,'$name','$title','$help','$type','$blockorder','$content','$rdfurl','$rdfupdated','$rdflimit','$phpblockfn',$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled,$allow_autotags,NULL,NULL");
        } else {
            $sql = array();
            $sql['mysql'] = $sql['mssql'] = "INSERT INTO {$_TABLES['blocks']} "
             .'(name,title,help,type,blockorder,content,rdfurl,rdfupdated,rdflimit,phpblockfn,onleft,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled,allow_autotags) '
             ."VALUES ('$name','$title','$help','$type','$blockorder','$content','$rdfurl','$rdfupdated','$rdflimit','$phpblockfn',$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled,$allow_autotags)";
            
             $sql['pgsql'] = "INSERT INTO {$_TABLES['blocks']} "
             .'(bid,name,title,help,type,blockorder,content,rdfurl,rdfupdated,rdflimit,phpblockfn,onleft,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled,allow_autotags) '
             ."VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),'$name','$title','$help','$type','$blockorder','$content','$rdfurl','$rdfupdated','$rdflimit','$phpblockfn',$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled,$allow_autotags)";
             
             DB_query($sql);
             $bid = DB_insertId();
        }

        if (($type == 'gldefault') && ($name == 'older_stories')) {
            COM_olderStuff ();
        }
        
        TOPIC_saveTopicSelectionControl('block', $bid);
        
        return COM_refresh ($_CONF['site_admin_url'] . '/block.php?msg=11');
    } else {
        if (empty($name)) {
            // empty block name
            $msgtxt = $LANG21[50];
        } elseif ($type == 'portal') {
            // Portal block is missing fields
            $msgtxt = $LANG21[33];
        } elseif ($type == 'phpblock') {
            // PHP Block is missing field
            $msgtxt = $LANG21[34];
        } elseif ($type == 'normal') {
            // Normal block is missing field
            $msgtxt = $LANG21[35];
        } elseif ($type == 'gldefault') {
            // Default geeklog field missing
            $msgtxt = $LANG21[42];
        } else {
            // Layout block missing content
            $msgtxt = $LANG21[36];
        }
        $retval .= COM_showMessageText($msgtxt, $LANG21[32])
                . editblock($bid);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG21[32]));
    }

    return $retval;
}

/**
* Re-orders all blocks in increments of 10
*
*/
function reorderblocks()
{
    global $_TABLES;

    $sql = "SELECT * FROM {$_TABLES['blocks']} ORDER BY onleft ASC, blockorder ASC;";
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
* Move blocks UP, Down and Switch Sides - Left and Right
*
* NOTE: Does not return.
*
*/
function moveBlock()
{
    global $_CONF, $_TABLES, $LANG21;

    $bid = COM_applyFilter($_GET['bid']);
    $where = COM_applyFilter($_GET['where']);

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
        COM_errorLog("block admin error: Attempt to move an non existing block id: $bid");
    }
    echo COM_refresh($_CONF['site_admin_url'] . '/block.php');
    exit;
}


/**
* Enable and Disable blocks
*
* @param    array   $enabledblocks  array containing ids of enabled blocks
* @param    array   $visibleblocks  array containing ids of visible blocks
* @return   void
*
*/
function changeBlockStatus($enabledblocks, $visibleblocks)
{
    global $_CONF, $_TABLES;

    $disabled = array_diff($visibleblocks, $enabledblocks);

    // disable blocks
    $in = implode(',', $disabled);
    if (! empty($in)) {
        $sql = "UPDATE {$_TABLES['blocks']} SET is_enabled = 0 WHERE bid IN ($in)";
        DB_query($sql);
    }

    // enable blocks
    $in = implode(',', $enabledblocks);
    if (! empty($in)) {
        $sql = "UPDATE {$_TABLES['blocks']} SET is_enabled = 1 WHERE bid IN ($in)";
        DB_query($sql);
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

    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['blocks']} WHERE bid ='$bid'");
    $A = DB_fetchArray($result);
    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
            $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    if (($access < 3) || (TOPIC_hasMultiTopicAccess('block', $bid) < 3)) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete block $bid.");
        return COM_refresh ($_CONF['site_admin_url'] . '/block.php');
    }

    TOPIC_deleteTopicAssignments('block', $bid);
    
    DB_delete ($_TABLES['blocks'], 'bid', $bid);

    return COM_refresh ($_CONF['site_admin_url'] . '/block.php?msg=12');
}

// MAIN
$mode = '';
if (!empty($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

$bid = '';
if (!empty($_REQUEST['bid'])) {
    $bid = COM_applyFilter ($_REQUEST['bid']);
}

if (isset($_POST['blockenabler']) && SEC_checkToken()) {
    $enabledblocks = array();
    if (isset($_POST['enabledblocks'])) {
        $enabledblocks = $_POST['enabledblocks'];
    }
    $visibleblocks = array();
    if (isset($_POST['visibleblocks'])) {
        $visibleblocks = $_POST['visibleblocks'];
    }
    changeBlockStatus($enabledblocks, $visibleblocks);
}
    
if (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) {
    if (!isset ($bid) || empty ($bid) || ($bid == 0)) {
        COM_errorLog ('Attempted to delete block, bid empty or null, value =' . $bid);
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/block.php');
    } elseif (SEC_checkToken()) {
        $display .= deleteBlock ($bid);
    } else {
        COM_accessLog("User {$_USER['username']} tried to illegally delete block $bid and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
    }
} elseif (($mode == $LANG_ADMIN['save']) && !empty($LANG_ADMIN['save']) && SEC_checkToken()) {
    $help = '';
    if (isset ($_POST['help'])) {
        $help = COM_sanitizeUrl ($_POST['help'], array ('http', 'https'));
    }
    $content = '';
    if (isset ($_POST['content'])) {
        $content = $_POST['content'];
    }
    $rdfurl = '';
    if (isset ($_POST['rdfurl'])) {
        $rdfurl = $_POST['rdfurl']; // to be sanitized later
    }
    $rdfupdated = '';
    if (isset ($_POST['rdfupdated'])) {
        $rdfupdated = $_POST['rdfupdated'];
    }
    $rdflimit = 0;
    if (isset ($_POST['rdflimit'])) {
        $rdflimit = COM_applyFilter ($_POST['rdflimit'], true);
    }
    $phpblockfn = '';
    if (isset ($_POST['phpblockfn'])) {
        $phpblockfn = $_POST['phpblockfn'];
    }
    $is_enabled = '';
    if (isset ($_POST['is_enabled'])) {
        $is_enabled = $_POST['is_enabled'];
    }
    $allow_autotags = '';
    if (isset ($_POST['allow_autotags'])) {
        $allow_autotags = $_POST['allow_autotags'];
    }
    $display .= saveblock ($bid, $_POST['name'], $_POST['title'],
                    $help, $_POST['type'], $_POST['blockorder'], $content,
                    $rdfurl, $rdfupdated,
                    $rdflimit, $phpblockfn, $_POST['onleft'],
                    COM_applyFilter ($_POST['owner_id'], true),
                    COM_applyFilter ($_POST['group_id'], true),
                    $_POST['perm_owner'], $_POST['perm_group'],
                    $_POST['perm_members'], $_POST['perm_anon'],
                    $is_enabled, $allow_autotags);
} elseif ($mode == 'edit') {
    $display = COM_createHTMLDocument(editblock($bid), array('pagetitle' => $LANG21[3]));
} elseif ($mode == 'move') {
    if(SEC_checkToken()) {
        $display .= moveBlock();
    }
    $display .= listblocks();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG21[19]));
} else {  // 'cancel' or no mode at all
    $display .= COM_showMessageFromParameter();
    $display .= listblocks();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG21[19]));
}

COM_output($display);

?>
