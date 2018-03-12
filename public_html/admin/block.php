<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | block.php                                                                 |
// |                                                                           |
// | Geeklog block administration.                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
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
 * Default blocks are those blocks that Geeklog requires to function
 * properly.  Because of their special role, they have restricted
 * edit properties so this form shows that.
 *
 * @param    array $A      Array of data to show on form
 * @param    int   $access Permissions this user has
 * @return   string          HTML for default block editor
 */
function editdefaultblock($A, $access)
{
    global $_CONF, $_TABLES, $LANG21, $LANG_ACCESS, $LANG_ADMIN;

    $retval = COM_startBlock($LANG21[3], '', COM_getBlockTemplate('_admin_block', 'header'));
    $token = SEC_createToken();
    $retval .= SEC_getTokenExpiryNotice($token);

    $block_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file('editor', 'defaultblockeditor.thtml');
    $block_templates->set_var('block_id', $A['bid']);
    // standard Admin strings
    $block_templates->set_var('lang_blocktitle', $LANG_ADMIN['title']);
    $block_templates->set_var('lang_enabled', $LANG_ADMIN['enabled']);
    $block_templates->set_var('lang_blockhelpurl', $LANG_ADMIN['help_url']);
    $block_templates->set_var('lang_topic', $LANG_ADMIN['topic']);
    $block_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $block_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $block_templates->set_var('lang_blocktype', $LANG_ADMIN['type']);

    $block_templates->set_var('block_title', stripslashes($A['title']));
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

    $block_templates->set_var('topic_selection',
        TOPIC_getTopicSelectionControl('block', $A['bid'], true, true));

    $block_templates->set_var('lang_position', $LANG21['position']);
    $block_templates->set_var('lang_left', $LANG21[40]);
    $block_templates->set_var('lang_right', $LANG21[41]);
    $block_templates->set_var('lang_none', $LANG21[47]);
    
    if ($A['onleft'] == BLOCK_LEFT_POSITION) {
        $block_templates->set_var('left_selected', 'selected="selected"');
    } elseif ($A['onleft'] == BLOCK_RIGHT_POSITION) {
        $block_templates->set_var('right_selected', 'selected="selected"');
    } elseif ($A['onleft'] == BLOCK_NONE_POSITION && empty($A['location'])) {
        $block_templates->set_var('none_selected', 'selected="selected"');
    }
    // Add in rest of block position options if any
    $block_locations = PLG_getBlockLocations();
    $position_options = '';
    foreach ($block_locations as $location) {
        if ($A['onleft'] == BLOCK_NONE_POSITION && $A['location'] == $location['id'] ) {
            $selected = ' selected="selected"';
        } else {
            $selected = '';
        }
        $position_options .= '<option value="' . $location['id'] . '"' . $selected . '>' . $location['name'] . '</option>';        
    }
    $block_templates->set_var('position_options', $position_options);
    
    $block_templates->set_var('lang_blockorder', $LANG21[9]);
    $block_templates->set_var('block_order', $A['blockorder']);

    $block_templates->set_var('lang_device', $LANG_ADMIN['device']);
    $block_templates->set_var('lang_all', $LANG_ADMIN['for_all']);
    if ($A['device'] == Device::ALL) {
        $block_templates->set_var('for_all', 'checked="checked"');
    } else {
        $block_templates->set_var('for_all', '');
    }
    $block_templates->set_var('lang_for_mobile', $LANG_ADMIN['for_mobile']);
    if ($A['device'] == Device::MOBILE) {
        $block_templates->set_var('for_mobile', 'checked="checked"');
    } else {
        $block_templates->set_var('for_mobile', '');
    }
    $block_templates->set_var('lang_for_computer', $LANG_ADMIN['for_computer']);
    if ($A['device'] == Device::COMPUTER) {
        $block_templates->set_var('for_computer', 'checked="checked"');
    } else {
        $block_templates->set_var('for_computer', '');
    }
    $block_templates->set_var('lang_device_desc', $LANG_ADMIN['device_desc']);

    // CSS id and classes (both optional)
    $block_templates->set_var(array(
        'css_id'                => $A['css_id'],
        'css_classes'           => $A['css_classes'],
        'lang_css_id'           => $LANG21[70],
        'lang_css_id_desc'      => $LANG21[71],
        'lang_css_classes'      => $LANG21[72],
        'lang_css_classes_desc' => $LANG21[73],
    ));

    $block_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $block_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $ownername = COM_getDisplayName($A['owner_id']);
    $block_templates->set_var('owner_username', DB_getItem($_TABLES['users'],
        'username', "uid = '{$A['owner_id']}'"));
    $block_templates->set_var('owner_name', $ownername);
    $block_templates->set_var('owner', $ownername);
    $block_templates->set_var('owner_id', $A['owner_id']);

    $block_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $block_templates->set_var('group_dropdown',
        SEC_getGroupDropdown($A['group_id'], $access));
    $block_templates->set_var('group_name', DB_getItem($_TABLES['groups'],
        'grp_name', "grp_id = '{$A['group_id']}'"));
    $block_templates->set_var('group_id', $A['group_id']);
    $block_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $block_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $block_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']));
    $block_templates->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
    $block_templates->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);
    $block_templates->set_var('max_url_length', 255);
    $block_templates->set_var('gltoken_name', CSRF_TOKEN);
    $block_templates->set_var('gltoken', $token);
    $block_templates->parse('output', 'editor');

    $retval .= $block_templates->finish($block_templates->get_var('output'));
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
 * Override the post data to the data given in the parameter
 * This is helper function for editblock function
 *
 * @param    array $A Array of data by reference
 * @return   void
 */
function overridePostdata(&$A)
{
    if (isset($_POST['name'])) {
        $A['name'] = COM_sanitizeID(Geeklog\Input::post('name'));
    }
    if (isset($_POST['title'])) {
        $A['title'] = GLText::stripTags(Geeklog\Input::post('title'));
    }
    if (isset($_POST['help'])) {
        $A['help'] = GLText::stripTags(Geeklog\Input::post('help'));
    }
    if (in_array($_POST['type'], array('normal', 'portal', 'phpblock', 'gldefault'))) {
        $A['type'] = Geeklog\Input::post('type');
    }
    if (isset($_POST['blockorder'])) {
        $A['blockorder'] = (int) Geeklog\Input::fPost('blockorder', 0);
    }
    if (isset($_POST['device'])) {
        $A['device'] = Geeklog\Input::fPost('device');
    }
    if (isset($_POST['content'])) {
        $A['content'] = Geeklog\Input::post('content'); // to be sanitized when saving
    }
    if (isset($_POST['rdfurl'])) {
        $A['rdfurl'] = Geeklog\Input::post('rdfurl'); // to be sanitized when saving
    }
    if (isset($_POST['rdflimit'])) {
        $A['rdflimit'] = (int) Geeklog\Input::fPost('rdflimit');
    }
    if (isset($_POST['phpblockfn'])) {
        $A['phpblockfn'] = Geeklog\Input::post('phpblockfn'); // to be sanitized when saving
    }
    if (isset($_POST['owner_id'])) {
        $A['owner_id'] = (int) Geeklog\Input::fPost('owner_id', 0);
    }
    if (isset($_POST['group_id'])) {
        $A['group_id'] = (int) Geeklog\Input::fPost('group_id', 0);
    }

    list($A['perm_owner'], $A['perm_group'],
        $A['perm_members'], $A['perm_anon']) =
        SEC_getPermissionValues(
            Geeklog\Input::post('perm_owner'), Geeklog\Input::post('perm_group'),
            Geeklog\Input::post('perm_members'), Geeklog\Input::post('perm_anon')
        );

    $A['onleft'] = ($_POST['onleft'] == 1) ? 1 : 0;
    $A['location'] = '';
    $A['is_enabled'] = ($_POST['is_enabled'] == 'on') ? 1 : 0;
    
    if (isset($_POST['allow_autotags'])) {
        $A['allow_autotags'] = ($_POST['allow_autotags'] == 'on') ? 1 : 0;
    } else {
        $A['allow_autotags'] = 0;
    }
    
    if (isset($_POST['convert_newlines'])) {
        $A['convert_newlines'] = ($_POST['convert_newlines'] == 'on') ? 1 : 0;
    } else {
        $A['convert_newlines'] = 0;
    }    

    if (isset($_POST['cache_time'])) {
        $A['cache_time'] = (int) Geeklog\Input::fPost('cache_time', 0);
    }
}

/**
 * Shows the block editor
 * This will show a block edit form.  If this is a Geeklog default block it will
 * send it off to editdefaultblock.
 *
 * @param    string $bid ID of block to edit
 * @return   string          HTML for block editor
 */
function editblock($bid = '')
{
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $LANG01, $LANG21, $LANG_ACCESS,
           $LANG_ADMIN, $MESSAGE, $_SCRIPTS;

    $retval = '';

    if (!empty($bid)) {
        $bid = DB_escapeString($bid);
        $sql['mysql'] = "SELECT * FROM {$_TABLES['blocks']} WHERE bid ='{$bid}'";
        $sql['pgsql'] = "SELECT * FROM {$_TABLES['blocks']} WHERE bid ='{$bid}'";

        $result = DB_query($sql);
        $A = DB_fetchArray($result);

        $access = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']);
        if (($access == 2) || ($access == 0) ||
            (TOPIC_hasMultiTopicAccess('block', $bid) < 3)
        ) {
            $retval .= COM_showMessageText($LANG21[45],
                $LANG_ACCESS['accessdenied']);
            COM_accessLog("User {$_USER['username']} tried to illegally create or edit block $bid.");

            return $retval;
        }
        if ($A['type'] === 'gldefault') {
            $retval .= editdefaultblock($A, $access);

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
        $A['device'] = Device::ALL;
        $A['cache_time'] = $_CONF['default_cache_time_block'];
        $A['content'] = '';
        $A['allow_autotags'] = 0;
        $A['convert_newlines'] = 0;
        $A['rdfurl'] = '';
        $A['rdfupdated'] = '';
        $A['rdflimit'] = 0;
        $A['onleft'] = 0;
        $A['phpblockfn'] = '';
        $A['help'] = '';
        $A['css_id'] = '';
        $A['css_classes'] = '';
        $A['owner_id'] = $_USER['uid'];
        if (isset($_GROUPS['Block Admin'])) {
            $A['group_id'] = $_GROUPS['Block Admin'];
        } else {
            $A['group_id'] = SEC_getFeatureGroup('block.edit');
        }
        SEC_setDefaultPermissions($A, $_CONF['default_permissions_block']);
        $access = 3;
        if (!empty($LANG_ADMIN['save']) && (Geeklog\Input::post('mode') === $LANG_ADMIN['save'])) {
            overridePostdata($A);
        }
    }

    $token = SEC_createToken();

    $block_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/block');
    $block_templates->set_file('editor', 'blockeditor.thtml');
    $block_start = COM_startBlock($LANG21[3], '',
        COM_getBlockTemplate('_admin_block', 'header'));
    $block_start .= LB . SEC_getTokenExpiryNotice($token);
    $block_templates->set_var('start_block_editor', $block_start);

    if (!empty($bid) && SEC_hasRights('block.delete')) {
        $block_templates->set_var('allow_delete', true);
        $block_templates->set_var('lang_delete', $LANG_ADMIN['delete']);
        $block_templates->set_var('confirm_message', $MESSAGE[76]);
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

    $block_templates->set_var('block_title', stripslashes($A['title']));
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
        TOPIC_getTopicSelectionControl('block', $A['bid'], true, true));

    $block_templates->set_var('lang_position', $LANG21['position']);
    $block_templates->set_var('lang_left', $LANG21[40]);
    $block_templates->set_var('lang_right', $LANG21[41]);
    $block_templates->set_var('lang_none', $LANG21[47]);

    
    
    if ($A['onleft'] == BLOCK_LEFT_POSITION) {
        $block_templates->set_var('left_selected', 'selected="selected"');
    } elseif ($A['onleft'] == BLOCK_RIGHT_POSITION) {
        $block_templates->set_var('right_selected', 'selected="selected"');
    } elseif ($A['onleft'] == BLOCK_NONE_POSITION && empty($A['location'])) {
        $block_templates->set_var('none_selected', 'selected="selected"');
    }
    // Add in rest of block position options if any
    $block_locations = PLG_getBlockLocations();
    $position_options = '';
    foreach ($block_locations as $location) {
        if ($A['onleft'] == BLOCK_NONE_POSITION && $A['location'] == $location['id'] ) {
            $selected = ' selected="selected"';
        } else {
            $selected = '';
        }
        $position_options .= '<option value="' . $location['id'] . '"' . $selected . '>' . $location['name'] . '</option>';        
    }
    $block_templates->set_var('position_options', $position_options);    
    
    
    
    $block_templates->set_var('lang_blockorder', $LANG21[9]);
    $block_templates->set_var('block_order', $A['blockorder']);

    $block_templates->set_var('lang_device', $LANG_ADMIN['device']);
    $block_templates->set_var('lang_all', $LANG_ADMIN['for_all']);
    if ($A['device'] == Device::ALL) {
        $block_templates->set_var('for_all', 'checked="checked"');
    } else {
        $block_templates->set_var('for_all', '');
    }
    $block_templates->set_var('lang_for_mobile', $LANG_ADMIN['for_mobile']);
    if ($A['device'] == Device::MOBILE) {
        $block_templates->set_var('for_mobile', 'checked="checked"');
    } else {
        $block_templates->set_var('for_mobile', '');
    }
    $block_templates->set_var('lang_for_computer', $LANG_ADMIN['for_computer']);
    if ($A['device'] == Device::COMPUTER) {
        $block_templates->set_var('for_computer', 'checked="checked"');
    } else {
        $block_templates->set_var('for_computer', '');
    }
    $block_templates->set_var('lang_device_desc', $LANG_ADMIN['device_desc']);

    $block_templates->set_var('lang_normalblock', $LANG21[12]);
    $block_templates->set_var('lang_phpblock', $LANG21[27]);
    $block_templates->set_var('lang_portalblock', $LANG21[11]);
    if ($A['type'] === 'normal') {
        $block_templates->set_var('normal_selected', 'selected="selected"');
    } elseif ($A['type'] === 'phpblock') {
        $block_templates->set_var('php_selected', 'selected="selected"');
    } elseif ($A['type'] === 'portal') {
        $block_templates->set_var('portal_selected', 'selected="selected"');
    }
    $block_templates->set_var('lang_cachetime', $LANG21['cache_time']);
    $block_templates->set_var('lang_cachetime_desc', $LANG21['cache_time_desc']);
    $block_templates->set_var('cache_time', $A['cache_time']);

    // CSS id and classes (both optional)
    $block_templates->set_var(array(
        'css_id'                => $A['css_id'],
        'css_classes'           => $A['css_classes'],
        'lang_css_id'           => $LANG21[70],
        'lang_css_id_desc'      => $LANG21[71],
        'lang_css_classes'      => $LANG21[72],
        'lang_css_classes_desc' => $LANG21[73],
    ));

    $block_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $block_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $ownername = COM_getDisplayName($A['owner_id']);
    $block_templates->set_var('owner_username', DB_getItem($_TABLES['users'],
        'username', "uid = '{$A['owner_id']}'"));
    $block_templates->set_var('owner_name', $ownername);
    $block_templates->set_var('owner', $ownername);
    $block_templates->set_var('owner_id', $A['owner_id']);

    $block_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $block_templates->set_var('group_dropdown',
        SEC_getGroupDropdown($A['group_id'], $access));
    $block_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $block_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $block_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']));
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
    if (empty($A['rdfupdated'])) {
        $block_templates->set_var('block_rdfupdated', '');
    } else {
        $block_templates->set_var('block_rdfupdated', $A['rdfupdated']);
    }
    $block_templates->set_var('lang_normalblockoptions', $LANG21[16]);
    $block_templates->set_var('lang_blockcontent', $LANG21[17]);
    $block_templates->set_var('lang_autotags', $LANG21[66]);
    $block_templates->set_var('lang_use_autotags', $LANG21[67]);
    $block_templates->set_var('lang_newlines', $LANG21['newlines']);
    $block_templates->set_var('lang_convert_newlines', $LANG21['convert_newlines']);
    
    $content = htmlspecialchars(stripslashes($A['content']));
    $content = str_replace(array('{', '}'), array('&#123;', '&#125;'),
        $content);
    $block_templates->set_var('block_content', $content);

    if ($A['allow_autotags'] == 1) {
        $block_templates->set_var('allow_autotags', 'checked="checked"');
    } else {
        $block_templates->set_var('allow_autotags', '');
    }
    if ($A['convert_newlines'] == 1) {
        $block_templates->set_var('convert_newlines', 'checked="checked"');
    } else {
        $block_templates->set_var('convert_newlines', '');
    }    
    $block_templates->set_var('gltoken_name', CSRF_TOKEN);
    $block_templates->set_var('gltoken', $token);
    $block_templates->set_var('end_block',
        COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer')));
    $block_templates->parse('output', 'editor');
    $retval .= $block_templates->finish($block_templates->get_var('output'));

    // Shows/Hides relevant block options dynamically
    $_SCRIPTS->setJavaScript("
jQuery(function () {
    var $ = jQuery;
    $('#admin-blockeditor-type').on('change', function () {
        var fs, i, fieldsets = ['normal', 'phpblock', 'portal'];

        for (i = 0; i < 3; i++) {
            if (this.value === fieldsets[i]) {
                $('#fs-' + fieldsets[i] + '-options').show();
            } else {
                $('#fs-' + fieldsets[i] + '-options').hide();
            }
        }
    })
    .trigger('change');
});", true, true);

    return $retval;
}

/**
 * Display two lists of blocks, separated by left and right
 *
 * @param  int $position
 * @return string  HTML for the two lists
 */
function listblocks($position = BLOCK_ALL_POSITIONS)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG21, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
    $token = SEC_createToken();

    // writing the menu on top
    $menu_arr = array(
        array(
            'url'  => $_CONF['site_admin_url'] . '/block.php?mode=edit',
            'text' => $LANG_ADMIN['create_new'],
        ),
        array(
            'url'  => $_CONF['site_admin_url'],
            'text' => $LANG_ADMIN['admin_home'],
        ),
    );

    $retval .= COM_startBlock($LANG21[19], '', COM_getBlockTemplate('_admin_block', 'header'));
    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG21[25],
        $_CONF['layout_url'] . '/images/icons/block.' . $_IMAGE_TYPE
    );

    reorderblocks();

    // Regular Blocks
    switch ($position) {
        case BLOCK_NONE_POSITION:
        case BLOCK_LEFT_POSITION:
        case BLOCK_RIGHT_POSITION:
            break;

        default:
            $position = BLOCK_ALL_POSITIONS;
            break;
    }

    $show_position = '';
    $position_filter = '<option value="' . BLOCK_ALL_POSITIONS . '" title="' . $LANG21[7] . '"';
    if ($position == BLOCK_ALL_POSITIONS) {
        $position_filter .= ' selected="selected"';
    } else {
        $show_position = ' AND onleft = ' . $position;
    }
    $position_filter .= '>' . $LANG21[7] . '</option>';
    $position_filter .= '<option value="' . BLOCK_LEFT_POSITION . '" title="' . $LANG21[40] . '"';
    if ($position == BLOCK_LEFT_POSITION) {
        $position_filter .= ' selected="selected"';
    }
    $position_filter .= '>' . $LANG21[40] . '</option>';
    $position_filter .= '<option value="' . BLOCK_RIGHT_POSITION . '" title="' . $LANG21[41] . '"';
    if ($position == BLOCK_RIGHT_POSITION) {
        $position_filter .= ' selected="selected"';
    }
    $position_filter .= '>' . $LANG21[41] . '</option>';
    $position_filter .= '<option value="' . BLOCK_NONE_POSITION . '" title="' . $LANG21[47] . '"';
    if ($position == BLOCK_NONE_POSITION) {
        $position_filter .= ' selected="selected"';
    }
    $position_filter .= '>' . $LANG21[47] . '</option>';
    /* // CAN'T DO rest of positions since rely on another field 
    // Add in rest of block position options if any
    $block_locations = PLG_getBlockLocations();
    foreach ($block_locations as $block_location) {
        if ($position == $block_location['id']) {
            $selected = ' selected="selected"';
        } else {
            $selected = '';
        }
        $position_filter .= '<option value="' . $block_location['id'] . '"' . $selected . '>' . $block_location['name'] . '</option>';        
    }
    */

    $filter = $LANG21['position']
        . ': <select name="position" style="width: 125px" onchange="this.form.submit()">'
        . $position_filter . '</select>';

    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG21['position'], 'field' => 'onleft', 'sort' => false),
        array('text' => $LANG21[65], 'field' => 'blockorder', 'sort' => true, 'sort_field' => 'onleft DESC, blockorder'),
        array('text' => $LANG21[46], 'field' => 'move', 'sort' => false),
        array('text' => $LANG_ADMIN['device'], 'field' => 'device', 'sort' => true),
        array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
        array('text' => $LANG21[48], 'field' => 'name', 'sort' => true),
        array('text' => $LANG_ADMIN['type'], 'field' => 'type', 'sort' => true),
        array('text' => $LANG_ADMIN['topic'], 'field' => 'topic', 'sort' => true),
        array('text' => $LANG_ADMIN['enabled'], 'field' => 'is_enabled', 'sort' => true),
    );

    // Sort by position and then order for default
    $defsort_arr = array('field' => 'onleft DESC, location DESC, blockorder', 'direction' => 'asc');

    $text_arr = array(
        'has_extras' => true,
        'title'      => $LANG21[20],
        'form_url'   => $_CONF['site_admin_url'] . '/block.php',
    );


    $query_arr = array(
        'table'          => 'blocks',
        'sql'            => "SELECT * FROM {$_TABLES['blocks']} WHERE 1=1 ",
        'query_fields'   => array('title', 'content'),
        'default_filter' => $show_position . COM_getPermSQL('AND'),
    );

    // this is a dummy variable so we know the form has been used if all blocks
    // should be disabled on one side in order to disable the last one.
    // The value is the onleft var
    $form_arr = array(
        'top'    => '<input type="hidden" name="' . CSRF_TOKEN . '" value="'
            . $token . '"' . XHTML . '>',
        'bottom' => '<input type="hidden" name="blockenabler" value="1"'
            . XHTML . '>',
    );

    // Add in position filter so it is remembered with paging
    $pagenavurl = '&amp;position=' . $position;

    $retval .= ADMIN_list(
        'blocks', 'ADMIN_getListField_blocks', $header_arr, $text_arr,
        $query_arr, $defsort_arr, $filter, $token, '', $form_arr, true, $pagenavurl
    );

    // Dynamic blocks
    $dyn_header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG21['position'], 'field' => 'onleft'),
        array('text' => $LANG21[65], 'field' => 'blockorder'),
        array('text' => $LANG21[69], 'field' => 'plugin'),
        array('text' => $LANG_ADMIN['title'], 'field' => 'title'),
        array('text' => $LANG21[48], 'field' => 'name'),
        array('text' => $LANG_ADMIN['type'], 'field' => 'type'),
        array('text' => $LANG_ADMIN['topic'], 'field' => 'topic'),
        array('text' => $LANG_ADMIN['enabled'], 'field' => 'is_enabled'),
    );

    $dyn_text_arr = array(
        'title'    => $LANG21[22],
        'form_url' => $_CONF['site_admin_url'] . '/block.php',
    );

    $leftblocks = PLG_getBlocksConfig('left', '');
    // Sort Dynamic Blocks on Block Order
    usort($leftblocks, "cmpDynamicBlocks");

    $rightblocks = PLG_getBlocksConfig('right', '');
    // Sort Dynamic Blocks on Block Order
    usort($rightblocks, "cmpDynamicBlocks");

    $dynamicblocks = array_merge($leftblocks, $rightblocks);

    $retval .= ADMIN_simpleList('ADMIN_getListField_dynamicblocks', $dyn_header_arr, $dyn_text_arr,
        $dynamicblocks, '', $form_arr);

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
 * Used by listblocks function when sorting the dynamic block array using the
 * usort function
 *
 * @return   boolean
 */
function cmpDynamicBlocks($a, $b)
{
    return $a["blockorder"] > $b["blockorder"];
}

/**
 * Saves a block
 *
 * @param    string $bid          Block ID
 * @param    string $name         Block name
 * @param    string $title        Block title
 * @param    string $help         Block help
 * @param    string $type         Type of block
 * @param    int    $blockOrder   Order block appears relative to the others
 * @param    string $device       Device type
 * @param    string $content      Content of block
 * @param    string $rdfUrl       URL to headline feed for portal blocks
 * @param    string $rdfLimit     max. number of entries to import from feed
 * @param    string $phpBlockFn   Name of php function to call to get content
 * @param    int    $onLeft       Flag indicates if block shows up on left or right
 * @param    int    $owner_id     ID of owner
 * @param    int    $group_id     ID of group block belongs to
 * @param    array  $perm_owner   Permissions the owner has on the object
 * @param    array  $perm_group   Permissions the group has on the object
 * @param    array  $perm_members Permissions the logged in members have
 * @param    array  $perm_anon    Permissions anonymous users have
 * @param    int    $is_enabled   Flag, indicates if block is enabled or not
 * @param    bool   $allow_autotags
 * @param    bool   $convert_newlines
 * @param    int    $cache_time
 * @param    string $cssId        CSS ID (since GL 2.2.0)
 * @param    string $cssClasses   CSS class names separated by space (since GL 2.2.0)
 * @return   string               HTML redirect or error message
 */
function saveblock($bid, $name, $title, $help, $type, $blockOrder, $device, $content, $rdfUrl, $rdfLimit,
                   $phpBlockFn, $onLeft, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon,
                   $is_enabled, $allow_autotags, $convert_newlines, $cache_time, $cssId, $cssClasses)
{
    global $_CONF, $_TABLES, $LANG21, $MESSAGE, $_USER;

    $retval = '';

    $title = DB_escapeString(COM_stripslashes(GLText::stripTags($title)));
    $phpBlockFn = DB_escapeString(COM_stripslashes(trim($phpBlockFn)));
    if (empty($title) || !TOPIC_checkTopicSelectionControl()) {
        $retval .= COM_showMessageText($LANG21[64], $LANG21[63])
            . editblock($bid);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG21[63]));

        return $retval;
    }

    // Convert array values to numeric permission values
    list($perm_owner, $perm_group, $perm_members, $perm_anon) = SEC_getPermissionValues($perm_owner, $perm_group, $perm_members, $perm_anon);

    if (($bid > 0) && DB_count($_TABLES['blocks'], 'bid', $bid) > 0) {
        $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['blocks']} WHERE bid = '{$bid}'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'], $A['group_id'],
            $A['perm_owner'], $A['perm_group'], $A['perm_members'],
            $A['perm_anon']
        );
    } else {
        $access = SEC_hasAccess($owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon);
    }

    if (($access < 3) || !TOPIC_hasMultiTopicAccess('topic') || !SEC_inGroup($group_id)) {
        $retval .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $MESSAGE[30]));
        COM_accessLog("User {$_USER['username']} tried to illegally create or edit block $bid.");

        return $retval;
    } elseif (!empty($name) &&
        (($type == 'normal' && !empty($title) && !empty($content))
            || ($type === 'portal' && !empty($title) && !empty($rdfUrl))
            || ($type === 'phpblock' && !empty($phpBlockFn) && !empty($title))
            || ($type === 'gldefault' && (strlen($blockOrder) > 0)))
    ) {
        if ($is_enabled === 'on') {
            $is_enabled = 1;
        } else {
            $is_enabled = 0;
        }

        if ($device != Device::MOBILE && $device != Device::COMPUTER) {
            $device = Device::ALL;
        }
        
        $location = '';
        if ($onLeft === (string)BLOCK_LEFT_POSITION || $onLeft === (string)BLOCK_RIGHT_POSITION || $onLeft === (string)BLOCK_LEFT_POSITION) {
            // value okay
        } else {
            $block_locations = PLG_getBlockLocations();
            $key = array_search($onLeft, array_column($block_locations, 'id'));
            if (is_numeric($key)) {
                $onLeft = BLOCK_NONE_POSITION;
                $location = $block_locations[$key]['id'];
            } else {
                // Block Position doesn't exist anymore for some reason so set to none
                $onLeft = BLOCK_NONE_POSITION;
            }
        }
            
        if ($allow_autotags == 'on') {
            $allow_autotags = 1;
        } else {
            $allow_autotags = 0;
        }
        
        if ($convert_newlines == 'on') {
            $convert_newlines = 1;
        } else {
            $convert_newlines = 0;
        }        

        if ($cache_time < -1) {
            $cache_time = $_CONF['default_cache_time_block'];
        }

        // Check for CSS id
        $cssId = trim($cssId);
        if (!preg_match('/^[a-zA-Z][0-9a-zA-Z_-]*$/', $cssId)) {
            $cssId = '';
        }
        $cssId = DB_escapeString($cssId);

        // Check for CSS classes
        $cssClasses = trim($cssClasses);
        $temp = array();

        foreach (preg_split('/\s+/', $cssClasses) as $item) {
            if (preg_match('/^[a-zA-Z][0-9a-zA-Z_-]*$/', $item)) {
                $temp[] = $item;
            }
        }

        $cssClasses = implode(' ', $temp);
        $cssClasses = DB_escapeString($cssClasses);
        
        if ($type === 'portal') {
            $content = '';
            $phpBlockFn = '';

            // get rid of possible extra prefixes (e.g. "feed://http://...")
            if (substr($rdfUrl, 0, 4) == 'rss:') {
                $rdfUrl = substr($rdfUrl, 4);
            } elseif (substr($rdfUrl, 0, 5) == 'feed:') {
                $rdfUrl = substr($rdfUrl, 5);
            }
            if (substr($rdfUrl, 0, 2) == '//') {
                $rdfUrl = substr($rdfUrl, 2);
            }
            $rdfUrl = COM_sanitizeUrl($rdfUrl, array('http', 'https'));
        }
        if ($type === 'gldefault') {
            $content = '';
            $rdfUrl = '';
            $rdfLimit = 0;
            $phpBlockFn = '';
        }
        if ($type === 'phpblock') {
            // NOTE: PHP Blocks must be within a function and the function
            // must start with phpblock_ as the prefix.  This will prevent
            // the arbitrary execution of code
            if (!(stristr($phpBlockFn, 'phpblock_'))) {
                $retval .= COM_showMessageText($LANG21[38], $LANG21[37])
                    . editblock($bid);
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG21[37]));

                return $retval;
            }
            $content = '';
            $rdfUrl = '';
            $rdfLimit = 0;
        }
        if ($type === 'normal') {
            $rdfUrl = '';
            $rdfLimit = 0;
            $phpBlockFn = '';

            if ($allow_autotags == 1) {
                // Remove any autotags the user doesn't have permission to use
                $content = PLG_replaceTags($content, '', true);
            }
            $content = DB_escapeString($content);
        }
        if ($rdfLimit < 0) {
            $rdfLimit = 0;
        }
        if (!empty($rdfUrl)) {
            $rdfUrl = DB_escapeString($rdfUrl);
        }

        $rdfUpdated = 'CURRENT_TIMESTAMP';

        if ($bid > 0) {
            DB_save(
                $_TABLES['blocks'],
                'bid,name,title,help,type,blockorder,device,content,rdfurl,rdfupdated,rdflimit,phpblockfn,onleft,location,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled,allow_autotags,convert_newlines,cache_time,css_id,css_classes,rdf_last_modified,rdf_etag',
                "$bid,'$name','$title','$help','$type','$blockOrder','$device','$content','$rdfUrl',$rdfUpdated,'$rdfLimit','$phpBlockFn',$onLeft,'$location',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled,$allow_autotags,$convert_newlines,$cache_time,'{$cssId}','{$cssClasses}',NULL,NULL"
            );
        } else {
            $sql = array();
            $sql['mysql'] = "INSERT INTO {$_TABLES['blocks']} "
                . '(name,title,help,type,blockorder,device,content,rdfurl,rdfupdated,rdflimit,phpblockfn,onleft,location,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled,allow_autotags,convert_newlines,cache_time,css_id,css_classes) '
                . "VALUES ('$name','$title','$help','$type','$blockOrder','$device','$content','$rdfUrl',$rdfUpdated,'$rdfLimit','$phpBlockFn',$onLeft,'$location',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled,$allow_autotags,$convert_newlines,$cache_time,'{$cssId}','{$cssClasses}')";

            $sql['pgsql'] = "INSERT INTO {$_TABLES['blocks']} "
                . '(bid,name,title,help,type,blockorder,device,content,rdfurl,rdfupdated,rdflimit,phpblockfn,onleft,location,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,is_enabled,allow_autotags,convert_newlines,cache_time,css_id,css_classes) '
                . "VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),'$name','$title','$help','$type','$blockOrder','$device','$content','$rdfUrl',CURRENT_TIMESTAMP,'$rdfLimit','$phpBlockFn',$onLeft,'$location',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_enabled,$allow_autotags,$convert_newlines,$cache_time,'{$cssId}','{$cssClasses}')";

            DB_query($sql);
            $bid = DB_insertId();
        }

        TOPIC_saveTopicSelectionControl('block', $bid);

        $cacheInstance = 'block__' . $bid . '__';  // remove any of this blocks instances if exists
        CACHE_remove_instance($cacheInstance);
        COM_redirect($_CONF['site_admin_url'] . '/block.php?msg=11');
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
 */
function reorderblocks()
{
    global $_TABLES;

    $sql = "SELECT * FROM {$_TABLES['blocks']} ORDER BY onleft ASC, location ASC, blockorder ASC;";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    $lastside = 0;
    $lastlocation = '';
    $blockOrd = 10;
    $stepNumber = 10;

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);

        if ($lastside != $A['onleft'] || $lastlocation != $A['location']) { // we are switching left/right blocks or template location
            $blockOrd = 10;              // so start with 10 again
        }
        if ($A['blockorder'] != $blockOrd) {  // only update incorrect ones
            $q = "UPDATE " . $_TABLES['blocks'] . " SET blockorder = '" .
                $blockOrd . "' WHERE bid = '" . $A['bid'] . "'";
            DB_query($q);
        }
        $blockOrd += $stepNumber;
        $lastside = $A['onleft'];       // save variable for next round
        $lastlocation = $A['location'];       // save variable for next round
    }
}

/**
 * Move blocks UP, Down and Switch Sides - Left and Right
 * NOTE: Does not return.
 */
function moveBlock()
{
    global $_CONF, $_TABLES;

    $bid = Geeklog\Input::fGet('bid');
    $where = Geeklog\Input::fGet('where');

    // if the block id exists
    if (DB_count($_TABLES['blocks'], "bid", $bid) == 1) {
        switch ($where) {
            case ("up"):
                $q = "UPDATE " . $_TABLES['blocks'] . " SET blockorder = blockorder-11 WHERE bid = '" . $bid . "' AND blockorder > 10";
                DB_query($q);
                break;

            case ("dn"):
                $q = "UPDATE " . $_TABLES['blocks'] . " SET blockorder = blockorder+11 WHERE bid = '" . $bid . "'";
                DB_query($q);
                break;

            case ("0"):
                $q = "UPDATE " . $_TABLES['blocks'] . " SET onleft = '1', blockorder = blockorder-1 WHERE bid = '" . $bid . "'";
                DB_query($q);
                break;

            case ("1"):
                $q = "UPDATE " . $_TABLES['blocks'] . " SET onleft = '0',blockorder = blockorder-1 WHERE bid = '" . $bid . "'";
                DB_query($q);
                break;
        }

    } else {
        COM_errorLog("block admin error: Attempt to move an non existing block id: $bid");
    }

    COM_redirect($_CONF['site_admin_url'] . '/block.php');
}

/**
 * Enable and Disable blocks
 *
 * @param    array $enabledBlocks array containing ids of enabled blocks
 * @param    array $visibleBlocks array containing ids of visible blocks
 * @return   void
 */
function changeBlockStatus($enabledBlocks, $visibleBlocks)
{
    global $_TABLES;

    $disabled = array_diff($visibleBlocks, $enabledBlocks);

    // disable blocks
    $in = implode(',', $disabled);
    if (!empty($in)) {
        $sql = "UPDATE {$_TABLES['blocks']} SET is_enabled = 0 WHERE bid IN ($in)";
        DB_query($sql);
    }

    // enable blocks
    $in = implode(',', $enabledBlocks);
    if (!empty($in)) {
        $sql = "UPDATE {$_TABLES['blocks']} SET is_enabled = 1 WHERE bid IN ($in)";
        DB_query($sql);
    }
}

/**
 * Delete a block
 *
 * @param    string $bid id of block to delete
 * @return   string          HTML redirect or error message
 */
function deleteBlock($bid)
{
    global $_CONF, $_TABLES, $_USER;

    $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['blocks']} WHERE bid ='$bid'");
    $A = DB_fetchArray($result);
    $access = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'],
        $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    if (($access < 3) || (TOPIC_hasMultiTopicAccess('block', $bid) < 3)) {
        COM_accessLog("User {$_USER['username']} tried to illegally delete block $bid.");
        COM_redirect($_CONF['site_admin_url'] . '/block.php');
    }

    TOPIC_deleteTopicAssignments('block', $bid);

    DB_delete($_TABLES['blocks'], 'bid', $bid);

    $cacheInstance = 'block__' . $bid . '__';  // remove any of this blocks instances if exists
    CACHE_remove_instance($cacheInstance);
    COM_redirect($_CONF['site_admin_url'] . '/block.php?msg=12');
}

// MAIN
$mode = Geeklog\Input::request('mode', '');
$position = Geeklog\Input::fRequest('position', BLOCK_ALL_POSITIONS);
$bid = Geeklog\Input::fRequest('bid', '');

if (isset($_POST['blockenabler']) && SEC_checkToken()) {
    $enabledblocks = Geeklog\Input::post('enabledblocks', array());
    $visibleblocks = Geeklog\Input::post('visibleblocks', array());
    changeBlockStatus($enabledblocks, $visibleblocks);
}

if (($mode == $LANG_ADMIN['delete']) && !empty($LANG_ADMIN['delete'])) {
    if (!isset($bid) || empty($bid) || ($bid == 0)) {
        COM_errorLog('Attempted to delete block, bid empty or null, value =' . $bid);
        COM_redirect($_CONF['site_admin_url'] . '/block.php');
    } elseif (SEC_checkToken()) {
        $display .= deleteBlock($bid);
    } else {
        COM_accessLog("User {$_USER['username']} tried to illegally delete block $bid and failed CSRF checks.");
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    }
} elseif (!empty($LANG_ADMIN['save']) && ($mode === $LANG_ADMIN['save']) && SEC_checkToken()) {
    $name = Geeklog\Input::post('name', '');
    if (!empty($name)) {
        $name = COM_sanitizeID($name);
    }
    $help = Geeklog\Input::post('help', '');
    $blockorder = (int) Geeklog\Input::fPost('blockorder', 0);
    $device = Geeklog\Input::fPost('device', Device::ALL);
    $content = Geeklog\Input::post('content', '');
    $rdfurl = Geeklog\Input::post('rdfurl', '');    // to be sanitized later
    $rdflimit = (int) Geeklog\Input::fPost('rdflimit', 0);
    $phpblockfn = Geeklog\Input::post('phpblockfn', '');
    $is_enabled = Geeklog\Input::post('is_enabled', '');
    $allow_autotags = Geeklog\Input::post('allow_autotags', '');
    $convert_newlines = Geeklog\Input::post('convert_newlines', '');
    // $cache_time = (int) Geeklog\Input::fPost('cache_time', $_CONF['default_cache_time_block']); // Doesn't work as cache_time can be zero
    $cache_time = (int) Geeklog\Input::fPost('cache_time');
    $cssId = Geeklog\Input::post('css_id', '');
    $cssClasses = Geeklog\Input::post('css_classes', '');
    $display .= saveblock(
        $bid, $name, Geeklog\Input::post('title'), $help, Geeklog\Input::post('type'), $blockorder,
        $device, $content, $rdfurl, $rdflimit, $phpblockfn, Geeklog\Input::post('onleft'),
        (int) Geeklog\Input::fPost('owner_id', 0), (int) Geeklog\Input::fPost('group_id', 0),
        Geeklog\Input::post('perm_owner'), Geeklog\Input::post('perm_group'),
        Geeklog\Input::post('perm_members'), Geeklog\Input::post('perm_anon'),
        $is_enabled, $allow_autotags, $convert_newlines, $cache_time, $cssId, $cssClasses);
} elseif ($mode === 'edit') {
    $tmp = editblock($bid);
    $display = COM_createHTMLDocument($tmp, array('pagetitle' => $LANG21[3]));
} elseif ($mode === 'move') {
    if (SEC_checkToken()) {
        $display .= moveBlock();
    }
    $display .= listblocks($position);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG21[19]));
} else {  // 'cancel' or no mode at all
    $display .= COM_showMessageFromParameter();
    $display .= listblocks($position);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG21[19]));
}

COM_output($display);
