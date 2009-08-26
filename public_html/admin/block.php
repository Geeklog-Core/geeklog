<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | block.php                                                                 |
// |                                                                           |
// | Geeklog block administration.                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
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

require_once '../lib-common.php';
require_once 'auth.inc.php';

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

$display = '';

if (!SEC_hasRights('block.edit')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the block administration screen");
    COM_output($display);
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
    global $_CONF, $_TABLES, $_USER, $LANG21, $LANG_ACCESS, $LANG_ADMIN;

    $retval = '';

    $retval .= COM_startBlock ($LANG21[3], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $block_templates = new Template($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file('editor','defaultblockeditor.thtml');
    $block_templates->set_var('xhtml', XHTML);
    $block_templates->set_var('site_url', $_CONF['site_url']);
    $block_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $block_templates->set_var('layout_url', $_CONF['layout_url']);
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
    $block_templates->set_var('lang_homeonly', $LANG21[43]);
    if ($A['tid'] == 'all') {
        $block_templates->set_var('all_selected', 'selected="selected"');
    } else if ($A['tid'] == 'homeonly') {
        $block_templates->set_var('homeonly_selected', 'selected="selected"');
    }
    $block_templates->set_var('topic_options',
                              COM_topicList ('tid,topic', $A['tid'], 1, true));
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
    $block_templates->set_var('gltoken', SEC_createToken());
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
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $LANG01, $LANG21, $LANG_ACCESS,
           $LANG_ADMIN, $MESSAGE;

    $retval = '';

    if (!empty($bid)) {
        $sql['mysql'] = "SELECT * FROM {$_TABLES['blocks']} WHERE bid ='$bid'";

        $sql['mssql'] = "SELECT bid, is_enabled, name, type, title, tid, blockorder, cast(content as text) as content, rdfurl, ";
        $sql['mssql'] .= "rdfupdated, rdflimit, onleft, phpblockfn, help, owner_id,group_id, ";
        $sql['mssql'] .= "perm_owner, perm_group, perm_members, perm_anon, allow_autotags FROM {$_TABLES['blocks']} WHERE bid ='$bid'";

        $result = DB_query($sql);
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access == 2 || $access == 0 || hasBlockTopicAccess ($A['tid']) < 3) {
            $retval .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
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
        $A['is_enabled'] = 1;
        $A['name'] = '';
        $A['type'] = 'normal';
        $A['title'] = '';
        $A['tid'] = 'All';
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

    $block_templates = new Template($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file('editor','blockeditor.thtml');
    $block_templates->set_var('site_url', $_CONF['site_url']);
    $block_templates->set_var('xhtml', XHTML);
    $block_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $block_templates->set_var('layout_url', $_CONF['layout_url']);
    $block_templates->set_var('start_block_editor', COM_startBlock ($LANG21[3],
            '', COM_getBlockTemplate ('_admin_block', 'header')));

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
    $block_templates->set_var('lang_all', $LANG21[7]);
    $block_templates->set_var('lang_homeonly', $LANG21[43]);
    if ($A['tid'] == 'all') {
        $block_templates->set_var('all_selected', 'selected="selected"');
    } else if ($A['tid'] == 'homeonly') {
        $block_templates->set_var('homeonly_selected', 'selected="selected"');
    }
    $block_templates->set_var('topic_options',
                              COM_topicList('tid,topic', $A['tid'], 1, true));
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
    $block_templates->set_var ('lang_normalblockoptions', $LANG21[16]);
    $block_templates->set_var ('lang_blockcontent', $LANG21[17]);
    $block_templates->set_var ('lang_autotags', $LANG21[66]);
    $block_templates->set_var ('lang_use_autotags', $LANG21[67]);
    $block_templates->set_var ('block_content',
                               htmlspecialchars (stripslashes ($A['content'])));
    if ($A['allow_autotags'] == 1) {
        $block_templates->set_var ('allow_autotags', 'checked="checked"');
    } else {
        $block_templates->set_var ('allow_autotags', '');
    }
    $block_templates->set_var('gltoken_name', CSRF_TOKEN);
    $block_templates->set_var('gltoken', SEC_createToken());
    $block_templates->set_var ('end_block',
            COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));
    $block_templates->parse('output', 'editor');
    $retval .= $block_templates->finish($block_templates->get_var('output'));

    return $retval;
}

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
    
    // writing the list
    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG21[65], 'field' => 'blockorder', 'sort' => true),
        array('text' => $LANG21[46], 'field' => 'move', 'sort' => false),
        array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
        array('text' => $LANG_ADMIN['type'], 'field' => 'type', 'sort' => true),
        array('text' => $LANG_ADMIN['topic'], 'field' => 'tid', 'sort' => true),
        array('text' => $LANG_ADMIN['enabled'], 'field' => 'is_enabled', 'sort' => true)
    );

    $defsort_arr = array('field' => 'blockorder', 'direction' => 'asc');

    $text_arr = array(
        'has_extras' => true,
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
    $form_arr = array('bottom' => '<input type="hidden" name="blockenabler" value="1"' . XHTML . '>');

    $retval .= ADMIN_list(
        'blocks', 'ADMIN_getListField_blocks', $header_arr, $text_arr,
        $query_arr, $defsort_arr, '', $token, '', $form_arr
    );

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    $query_arr = array(
        'table' => 'blocks',
        'sql' => "SELECT * FROM {$_TABLES['blocks']} WHERE onleft = 0",
        'query_fields' => array('title', 'content'),
        'default_filter' => COM_getPermSql ('AND')
    );

    $text_arr = array(
        'has_extras' => true,
        'title'      => "$LANG21[19] ($LANG21[41])",
        'form_url'   => $_CONF['site_admin_url'] . '/block.php'
    );

    // this is a dummy-variable so we know the form has been used if all blocks should be disabled
    // on one side in order to disable the last one. The value is the onleft var
    $form_arr = array('bottom' => '<input type="hidden" name="blockenabler" value="0"' . XHTML . '>');

    $retval .= ADMIN_list (
        'blocks', 'ADMIN_getListField_blocks', $header_arr, $text_arr,
        $query_arr, $defsort_arr, '', $token, '', $form_arr
    );

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
function saveblock ($bid, $name, $title, $help, $type, $blockorder, $content, $tid, $rdfurl, $rdfupdated, $rdflimit, $phpblockfn, $onleft, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon, $is_enabled, $allow_autotags)
{
    global $_CONF, $_TABLES, $LANG01, $LANG21, $MESSAGE;

    $retval = '';

    $title = addslashes (COM_stripslashes (strip_tags ($title)));
    $phpblockfn = addslashes (COM_stripslashes (trim ($phpblockfn)));
    if (empty($title)) {
        $retval .= COM_siteHeader ('menu', $LANG21[63])
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
    if (($access < 3) || !hasBlockTopicAccess($tid) || !SEC_inGroup($group_id)) {
        $retval .= COM_siteHeader('menu', $MESSAGE[30])
                . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
                . COM_siteFooter();
        COM_accessLog("User {$_USER['username']} tried to illegally create or edit block $bid.");

        return $retval;
    } elseif (($type == 'normal' && !empty($title) && !empty($content)) OR ($type == 'portal' && !empty($title) && !empty($rdfurl)) OR ($type == 'gldefault' && (strlen($blockorder)>0)) OR ($type == 'phpblock' && !empty($phpblockfn) && !empty($title))) {
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
            } else if (substr ($rdfurl, 0, 5) == 'feed:') {
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
                $retval .= COM_siteHeader ('menu', $LANG21[37])
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
        if (!empty ($rdfurl)) {
            $rdfurl = addslashes ($rdfurl);
        }
        if (empty ($rdfupdated)) {
            $rdfupdated = '0000-00-00 00:00:00';
        }

        if ($bid > 0) {
            DB_save($_TABLES['blocks'],'bid,name,title,help,type,blockorder,content,tid,rdfurl,rdfupdated,rdflimit,phpblockfn,onleft,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled,allow_autotags,rdf_last_modified,rdf_etag',"$bid,'$name','$title','$help','$type','$blockorder','$content','$tid','$rdfurl','$rdfupdated','$rdflimit','$phpblockfn',$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled,$allow_autotags,NULL,NULL");
        } else {
            $sql = "INSERT INTO {$_TABLES['blocks']} "
             .'(name,title,help,type,blockorder,content,tid,rdfurl,rdfupdated,rdflimit,phpblockfn,onleft,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled,allow_autotags) '
             ."VALUES ('$name','$title','$help','$type','$blockorder','$content','$tid','$rdfurl','$rdfupdated','$rdflimit','$phpblockfn',$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled,$allow_autotags)";
             DB_query($sql);
             $bid = DB_insertId();
        }

        if (($type == 'gldefault') && ($name == 'older_stories')) {
            COM_olderStuff ();
        }

        return COM_refresh ($_CONF['site_admin_url'] . '/block.php?msg=11');
    } else {
        $retval .= COM_siteHeader ('menu', $LANG21[32])
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
* Move blocks UP, Down and Switch Sides - Left and Right
*
*/
function moveBlock()
{
    global $_CONF, $_TABLES, $LANG21;

    $retval = '';

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
    echo COM_refresh($_CONF['site_admin_url'] . "/block.php");
    exit;
    return $retval;
}


/**
* Enable and Disable block
*/
function changeBlockStatus($side, $bid_arr)
{
    global $_CONF, $_TABLES;

    // first, disable all on the requested side
    $side = COM_applyFilter($side, true);
    $sql = "UPDATE {$_TABLES['blocks']} SET is_enabled = '0' WHERE onleft='$side';";
    DB_query($sql);
    if (isset($bid_arr)) {
        foreach ($bid_arr as $bid => $side) {
            $bid = COM_applyFilter($bid, true);
            // the enable those in the array
            $sql = "UPDATE {$_TABLES['blocks']} SET is_enabled = '1' WHERE bid='$bid' AND onleft='$side'";
            DB_query($sql);
        }
    }
    return;
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
    changeBlockStatus($_POST['blockenabler'], $enabledblocks);
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
                    COM_applyFilter ($_POST['tid']), $rdfurl, $rdfupdated,
                    $rdflimit, $phpblockfn, $_POST['onleft'],
                    COM_applyFilter ($_POST['owner_id'], true),
                    COM_applyFilter ($_POST['group_id'], true),
                    $_POST['perm_owner'], $_POST['perm_group'],
                    $_POST['perm_members'], $_POST['perm_anon'],
                    $is_enabled, $allow_autotags);
} else if ($mode == 'edit') {
    $display .= COM_siteHeader ('menu', $LANG21[3])
             . editblock ($bid)
             . COM_siteFooter ();
} else if ($mode == 'move') {
    $display .= COM_siteHeader('menu', $LANG21[19]);
    if(SEC_checkToken()) {
        $display .= moveBlock();
    }
    $display .= listblocks();
    $display .= COM_siteFooter();
} else {  // 'cancel' or no mode at all
    $display .= COM_siteHeader('menu', $LANG21[19]);
    $display .= COM_showMessageFromParameter();
    $display .= listblocks();

    $display .= COM_siteFooter();
}

COM_output($display);

?>
