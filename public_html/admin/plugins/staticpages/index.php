<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Geeklog Plugin 1.7                                           |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Administration page.                                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Phill Gillespie  - phill AT mediaaustralia DOT com DOT au        |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
 * Static Pages plugin administration page
 *
 * @package    StaticPages
 * @subpackage admin
 */

global $_CONF, $_USER, $_SP_CONF, $MESSAGE, $LANG_ADMIN, $sp_help;

// Geeklog common function library and Admin authentication
require_once '../../../lib-common.php';
require_once '../../auth.inc.php';

$display = '';

if (!SEC_hasRights('staticpages.edit')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the static pages administration screen.");
    COM_output($display);
    exit;
}

/**
 * Return if the given page exists
 *
 * @param  string $id
 * @return bool
 */
function staticPageIdExists($id)
{
    global $_TABLES;

    $retval = false;

    $id = DB_escapeString(trim($id));
    $sql = "SELECT COUNT(sp_id) AS cnt FROM {$_TABLES['staticpage']} "
        . "WHERE (sp_id = '{$id}') AND (template_flag = 0) AND (draft_flag = 0) "
        . COM_getPermSQL('AND', 0, 3);
    $result = DB_query($sql);

    if (!DB_error()) {
        $A = DB_fetchArray($result, false);
        $retval = ((int) $A['cnt'] === 1);
    }

    return $retval;
}

/**
 * Return <option> tags for page selectors
 *
 * @param  string $sp_id
 * @param  string $selectedId
 * @return string
 */
function staticPageGetIdOptions($sp_id, $selectedId)
{
    global $_TABLES;

    $ids = array('-----' => '');
    $sp_id = DB_escapeString($sp_id);
    $sql = "SELECT sp_id, sp_title FROM {$_TABLES['staticpage']} "
        . "WHERE (sp_id <> '{$sp_id}') AND (template_flag = 0) AND (draft_flag = 0) "
        . COM_getPermSQL('AND', 0, 3)
        . " ORDER BY sp_title, sp_id";
    $result = DB_query($sql);

    if (!DB_error()) {
        while (($A = DB_fetchArray($result, false))) {
            $id = stripslashes($A['sp_id']);
            $title = stripslashes($A['sp_title']);
            $ids[$title] = $id;
        }
    }

    $retval = '';

    foreach ($ids as $title => $id) {
        $retval .= sprintf(
            '<option value="%s"%s>%s</option>' . PHP_EOL,
            htmlspecialchars($id, ENT_QUOTES),
            ($id === $selectedId ? ' selected="selected"' : ''),
            htmlspecialchars($title, ENT_QUOTES)
        );
    }

    return $retval;
}

/**
 * Displays the static page editor form
 *
 * @param    array $A Data to display
 * @return   string          HTML for the static page editor
 */
function staticpageeditor_form(array $A)
{
    global $_CONF, $_TABLES, $_USER, $_GROUPS, $_SP_CONF, $mode, $sp_id,
           $LANG21, $LANG_STATIC, $LANG_ACCESS, $LANG_ADMIN, $LANG01, $LANG24,
           $LANG_postmodes, $LANG_STRUCT_DATA,
           $MESSAGE, $_IMAGE_TYPE, $_SCRIPTS;

    if (!empty($sp_id) && $mode === 'edit') {
        $access = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    } else {
        if ($mode !== 'clone') {
            $A['sp_inblock'] = $_SP_CONF['in_block'];
        }
        $A['owner_id'] = $_USER['uid'];
        if (isset($_GROUPS['Static Page Admin'])) {
            $A['group_id'] = $_GROUPS['Static Page Admin'];
        } else {
            $A['group_id'] = SEC_getFeatureGroup('staticpages.edit');
        }
        SEC_setDefaultPermissions($A, $_SP_CONF['default_permissions']);
        $access = 3;
        if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
            $A['advanced_editor_mode'] = 1;
        }
    }
    $retval = '';

    $sp_template = COM_newTemplate(CTL_plugin_templatePath('staticpages', 'admin'));
    if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
        $sp_template->set_file('form', 'editor_advanced.thtml');

        // Shouldn't really have to check if anonymous user but who knows...
        if (COM_isAnonUser()) {
            $link_message = '';
        } else {
            $link_message = $LANG01[138];
        }
        $sp_template->set_var('noscript', COM_getNoScript(false, '', $link_message));

        // Setup Advanced Editor
        COM_setupAdvancedEditor('/staticpages/adveditor.js', 'staticpages.edit');

        $sp_template->set_var('lang_expandhelp', $LANG24[67]);
        $sp_template->set_var('lang_reducehelp', $LANG24[68]);
        $sp_template->set_var('lang_toolbar', $LANG24[70]);
        $sp_template->set_var('toolbar1', $LANG24[71]);
        $sp_template->set_var('toolbar2', $LANG24[72]);
        $sp_template->set_var('toolbar3', $LANG24[73]);
        $sp_template->set_var('toolbar4', $LANG24[74]);
        $sp_template->set_var('toolbar5', $LANG24[75]);
        $sp_template->set_var('lang_nojavascript', $LANG24[77]);
        $sp_template->set_var('lang_postmode', $LANG24[4]);
        if (isset($A['postmode']) && ($A['postmode'] == 'adveditor')) {
            $sp_template->set_var('show_adveditor', '');
            $sp_template->set_var('show_htmleditor', 'none');
        } else {
            $sp_template->set_var('show_adveditor', 'none');
            $sp_template->set_var('show_htmleditor', '');
        }
        $post_options = '<option value="html" selected="selected">'
            . $LANG_postmodes['html'] . '</option>';
        if (isset($A['postmode']) && ($A['postmode'] == 'adveditor')) {
            $post_options .= '<option value="adveditor" selected="selected">'
                . $LANG24[86] . '</option>';
        } else {
            $post_options .= '<option value="adveditor">'
                . $LANG24[86] . '</option>';
        }
        $sp_template->set_var('post_options', $post_options);
        $sp_template->set_var('change_editormode',
            'onchange="change_editmode(this);"');
    } else {
        $sp_template->set_file('form', 'editor.thtml');
    }

    // Add JavaScript
    // Only use title_2_id if enabled, new staticpage or clone (basically any staticpage that does not exist yet)  - $mode = 'edit', 'clone'
    if ($_CONF['titletoid'] && (empty($sp_id) || $mode == 'clone')) {
        $_SCRIPTS->setJavaScriptFile('title_2_id', '/javascript/title_2_id.js');
        $sp_template->set_var('titletoid', true);
    }

    $sp_template->set_var('lang_mode', $LANG24[3]);
    $sp_template->set_var(
        'comment_options',
        COM_optionList($_TABLES['commentcodes'], 'code,name', $A['commentcode'])
    );

    $sp_template->set_var('lang_structured_data_type', $LANG_STRUCT_DATA['lang_structured_data_type']);
    $sp_template->set_var('structured_data_options',
        COM_optionListFromLangVariables('LANG_structureddatatypes', $A['structured_data_type'])
    );

    $sp_template->set_var('lang_search', $LANG_STATIC['search']);
    $sp_template->set_var('lang_search_desc', $LANG_STATIC['search_desc']);
    $sp_template->set_var('search_options',
        COM_optionListFromLangVariables('LANG_staticpages_search', $A['search'])
    );
	
    $sp_template->set_var('lang_likes', $LANG_STATIC['likes']);
    $sp_template->set_var('lang_likes_desc', $LANG_STATIC['likes_desc']);
    $sp_template->set_var('likes_options',
        COM_optionListFromLangVariables('LANG_staticpages_likes', $A['likes'])
    );	

    $sp_template->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $sp_template->set_var('lang_owner', $LANG_ACCESS['owner']);

    $owner_name = COM_getDisplayName($A['owner_id']);
    $owner_username = DB_getItem($_TABLES['users'], 'username',
        "uid = {$A['owner_id']}");
    $sp_template->set_var('owner_id', $A['owner_id']);
    $sp_template->set_var('owner', $owner_name);
    $sp_template->set_var('owner_name', $owner_name);
    $sp_template->set_var('owner_username', $owner_username);

    if ($A['owner_id'] > 1) {
        $ownerDisplayTag = COM_getProfileLink($A['owner_id'], $owner_username, $owner_name, '');
        $sp_template->set_var('start_owner_anchortag', $ownerDisplayTag);
        $sp_template->set_var('end_owner_anchortag', '');
        $sp_template->set_var('owner_link', $ownerDisplayTag);

        $photo = '';
        if ($_CONF['allow_user_photo']) {
            $photo = DB_getItem($_TABLES['users'], 'photo',
                "uid = {$A['owner_id']}");
            if (!empty($photo)) {
                $camera_icon = '<img src="' . $_CONF['layout_url']
                    . '/images/smallcamera.' . $_IMAGE_TYPE
                    . '" alt=""' . XHTML . '>';
                $profile_link = $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['owner_id'];
                $sp_template->set_var('camera_icon',
                    COM_createLink($camera_icon, $profile_link));
            }
        }
        if (empty($photo)) {
            $sp_template->set_var('camera_icon', '');
        }
    } else {
        $sp_template->set_var('start_owner_anchortag', '');
        $sp_template->set_var('end_owner_anchortag', '');
        $sp_template->set_var('owner_link', $owner_name);
    }

    $sp_template->set_var('lang_group', $LANG_ACCESS['group']);
    $sp_template->set_var(
        'group_dropdown',
        SEC_getGroupDropdown($A['group_id'], $access)
    );
    $sp_template->set_var(
        'permissions_editor',
        SEC_getPermissionsHTML($A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon'])
    );
    $sp_template->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $sp_template->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $sp_template->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
    $sp_template->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);

    $token = SEC_createToken();
    $start_block = COM_startBlock($LANG_STATIC['staticpageeditor'], '',
        COM_getBlockTemplate('_admin_block', 'header')
    );
    $start_block .= SEC_getTokenExpiryNotice($token);

    $sp_template->set_var('start_block_editor', $start_block);
    $sp_template->set_var('lang_save', $LANG_ADMIN['save']);
    $sp_template->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $sp_template->set_var('lang_preview', $LANG_ADMIN['preview']);
    if (SEC_hasRights('staticpages.delete') && ($mode !== 'clone') && !empty($A['sp_old_id'])) {
        $sp_template->set_var('allow_delete', true);
        $sp_template->set_var('lang_delete', $LANG_ADMIN['delete']);
        $sp_template->set_var('confirm_message', $MESSAGE[76]);
    } else {
        $sp_template->set_var('delete_option', '');
    }
    $sp_template->set_var('lang_writtenby', $LANG_STATIC['writtenby']);
    $sp_template->set_var(
        'username',
        DB_getItem($_TABLES['users'], 'username', "uid = {$A['owner_id']}")
    );
    $authorname = COM_getDisplayName($A['owner_id']);
    $sp_template->set_var('name', $authorname);
    $sp_template->set_var('author', $authorname);
    $sp_template->set_var('lang_url', $LANG_STATIC['url']);
    $sp_template->set_var('lang_id', $LANG_STATIC['id']);
    $sp_template->set_var('sp_uid', $A['owner_id']);
    $sp_template->set_var('sp_id', $A['sp_id']);
    $sp_template->set_var('sp_old_id', $A['sp_old_id']);
    $sp_template->set_var(
        'example_url',
        COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page=' . $A['sp_id'])
    );

    $sp_template->set_var('lang_centerblock', $LANG_STATIC['centerblock']);
    $sp_template->set_var('lang_centerblock_help', $LANG_ADMIN['help_url']);
    $sp_template->set_var('lang_centerblock_include', $LANG21[51]);
    $sp_template->set_var('lang_centerblock_desc', $LANG21[52]);
    $sp_template->set_var('centerblock_help', $A['sp_help']);
    $sp_template->set_var('lang_centerblock_msg', $LANG_STATIC['centerblock_msg']);
    if (isset($A['sp_centerblock']) && ($A['sp_centerblock'] == 1)) {
        $sp_template->set_var('centerblock_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('centerblock_checked', '');
    }

    $sp_template->set_var('lang_position', $LANG_STATIC['position']);
    $position = '<option value="1"';
    if ($A['sp_where'] == 1) {
        $position .= ' selected="selected"';
    }
    $position .= '>' . $LANG_STATIC['position_top'] . '</option>';
    $position .= '<option value="2"';
    if ($A['sp_where'] == 2) {
        $position .= ' selected="selected"';
    }
    $position .= '>' . $LANG_STATIC['position_feat'] . '</option>';
    $position .= '<option value="3"';
    if ($A['sp_where'] == 3) {
        $position .= ' selected="selected"';
    }
    $position .= '>' . $LANG_STATIC['position_bottom'] . '</option>';
    $position .= '<option value="0"';
    if ($A['sp_where'] == 0) {
        $position .= ' selected="selected"';
    }
    $position .= '>' . $LANG_STATIC['position_entire'] . '</option>';
    $position = COM_createControl('type-select', array(
        'name'         => 'sp_where',
        'select_items' => $position,
    ));
    $sp_template->set_var('pos_selection', $position);
    if (($_SP_CONF['allow_php'] == 1) && SEC_hasRights('staticpages.PHP')) {
        if (!isset($A['sp_php'])) {
            $A['sp_php'] = 0;
        }
        $selection = '<option value="0"';
        if (($A['sp_php'] <= 0) || ($A['sp_php'] > 2)) {
            $selection .= ' selected="selected"';
        }
        $selection .= '>' . $LANG_STATIC['select_php_none'] . '</option>' . LB;
        $selection .= '<option value="1"';
        if ($A['sp_php'] == 1) {
            $selection .= ' selected="selected"';
        }
        $selection .= '>' . $LANG_STATIC['select_php_return'] . '</option>' . LB;
        $selection .= '<option value="2"';
        if ($A['sp_php'] == 2) {
            $selection .= ' selected="selected"';
        }
        $selection .= '>' . $LANG_STATIC['select_php_free'] . '</option>' . LB;
        $selection = COM_createControl('type-select', array(
            'name'         => 'sp_php',
            'select_items' => $selection,
        ));
        $sp_template->set_var('php_selector', $selection);
        $sp_template->set_var('php_warn', $LANG_STATIC['php_warn']);
    } else {
        $sp_template->set_var('php_selector', '');
        $sp_template->set_var('php_warn', $LANG_STATIC['php_not_activated']);
    }
    $sp_template->set_var('php_msg', $LANG_STATIC['php_msg']);

    // old variables (for the 1.3-type checkbox)
    $sp_template->set_var('php_checked', '');
    $sp_template->set_var('php_type', 'hidden');

    if (isset($A['sp_nf']) && ($A['sp_nf'] == 1)) {
        $sp_template->set_var('exit_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('exit_checked', '');
    }
    $sp_template->set_var('exit_msg', $LANG_STATIC['exit_msg']);
    $sp_template->set_var('exit_info', $LANG_STATIC['exit_info']);

    if ($A['sp_inblock'] == 1) {
        $sp_template->set_var('inblock_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('inblock_checked', '');
    }
    $sp_template->set_var('inblock_msg', $LANG_STATIC['inblock_msg']);
    $sp_template->set_var('inblock_info', $LANG_STATIC['inblock_info']);

    if ($A['draft_flag'] == 1) {
        $sp_template->set_var('draft_flag_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('draft_flag_checked', '');
    }
    $sp_template->set_var('lang_draft', $LANG_STATIC['draft']);

    $sp_template->set_var('lang_cache_time', $LANG_STATIC['cache_time']);
    $sp_template->set_var('lang_cache_time_desc', $LANG_STATIC['cache_time_desc']);
    $sp_template->set_var('cache_time', $A['cache_time']);

    $curtime = COM_getUserDateTimeFormat($A['unixdate']);
    $sp_template->set_var('lang_lastupdated', $LANG_STATIC['date']);
    $sp_template->set_var('sp_formateddate', $curtime[0]);
    $sp_template->set_var('sp_date', $curtime[1]);

    $sp_template->set_var('lang_title', $LANG_STATIC['title']);
    $sp_template->set_var('lang_page_title', $LANG_STATIC['page_title']);
    $title = '';
    $page_title = '';
    if (isset($A['sp_title'])) {
        $title = htmlspecialchars(stripslashes($A['sp_title']));
    }
    if (isset($A['sp_page_title'])) {
        $page_title = htmlspecialchars(stripslashes($A['sp_page_title']));
    }
    $sp_template->set_var('sp_title', $title);
    $sp_template->set_var('sp_page_title', $page_title);

    $sp_template->set_var('lang_topic', $LANG_STATIC['topic']);
    if ($mode != 'clone') {
        // want to use default topic selection if new staticpage so pass in blank id
        $topic_sp_id = $A['sp_id'];
        if (empty($sp_id) && $mode == 'edit') { // means new
            $topic_sp_id = '';
        }
		
		if ($mode == $LANG_ADMIN['save']) { // This can happen if error on save for example with missing data like title
			// Reload from control on page		
			$sp_template->set_var('topic_selection',
				TOPIC_getTopicSelectionControl('staticpages', '', true, false, true, true, 2));
		} else {
			$sp_template->set_var('topic_selection',
				TOPIC_getTopicSelectionControl('staticpages', $topic_sp_id, true, false, true, true, 2));
		}
    } else {
        $sp_template->set_var('topic_selection',
            TOPIC_getTopicSelectionControl('staticpages', $A['clone_sp_id'], true, false, true, true, 2));
    }

    $sp_template->set_var('lang_metadescription',
        $LANG_ADMIN['meta_description']);
    $sp_template->set_var('lang_metakeywords', $LANG_ADMIN['meta_keywords']);
    if (!empty($A['meta_description'])) {
        $sp_template->set_var('meta_description', $A['meta_description']);
    }
    if (!empty($A['meta_keywords'])) {
        $sp_template->set_var('meta_keywords', $A['meta_keywords']);
    }
    if (($_CONF['meta_tags'] > 0) && ($_SP_CONF['meta_tags'] > 0)) {
        $sp_template->set_var('hide_meta', '');
    } else {
        $sp_template->set_var('hide_meta', ' style="display:none;"');
    }
    if ($A['template_flag'] == 1) {
        $sp_template->set_var('template_flag_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('template_flag_checked', '');
    }
    $sp_template->set_var('lang_template', $LANG_STATIC['template']);
    $sp_template->set_var('lang_template_flag_msg', $LANG_STATIC['template_msg']);

    $template_list = templatelist($A['template_id']);
    $template_none = '<option value=""';
    if ($A['template_id'] == "") {
        $template_none .= ' selected="selected"';
    }
    $template_none .= '>' . $LANG_STATIC['none'] . '</option>';
    $selection = COM_createControl('type-select', array(
        'name'         => 'template_id',
        'select_items' => $template_none . $template_list,
    ));
    $sp_template->set_var('use_template_selection', $selection);
    $sp_template->set_var('lang_use_template', $LANG_STATIC['use_template']);
    $sp_template->set_var('lang_use_template_msg', $LANG_STATIC['use_template_msg']);

    $sp_template->set_var('lang_addtomenu', $LANG_STATIC['addtomenu']);
    if (isset($A['sp_onmenu']) && ($A['sp_onmenu'] == 1)) {
        $sp_template->set_var('onmenu_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('onmenu_checked', '');
    }
    if (isset($A['sp_onhits']) && ($A['sp_onhits'] == 1)) {
        $sp_template->set_var('onhits_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('onhits_checked', '');
    }
    if (isset($A['sp_onlastupdate']) && ($A['sp_onlastupdate'] == 1)) {
        $sp_template->set_var('onlastupdate_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('onlastupdate_checked', '');
    }
    if ($_SP_CONF['show_date'] != 1) {
        $sp_template->set_var('lang_show_on_page_date_disabled', $LANG_STATIC['show_on_page_disabled']);
    }

    $sp_template->set_var('lang_label', $LANG_STATIC['label']);
    if (isset($A['sp_label'])) {
        $sp_template->set_var('sp_label', $A['sp_label']);
    } else {
        $sp_template->set_var('sp_label', '');
    }
    $sp_template->set_var('lang_pageformat', $LANG_STATIC['pageformat']);
    $sp_template->set_var('lang_blankpage', $LANG_STATIC['blankpage']);
    $sp_template->set_var('lang_noblocks', $LANG_STATIC['noblocks']);
    $sp_template->set_var('lang_leftblocks', $LANG_STATIC['leftblocks']);
    $sp_template->set_var('lang_leftrightblocks', $LANG_STATIC['leftrightblocks']);
    if (!isset($A['sp_format'])) {
        $A['sp_format'] = '';
    }
    if ($A['sp_format'] === 'noblocks') {
        $sp_template->set_var('noblock_selected', 'selected="selected"');
    } else {
        $sp_template->set_var('noblock_selected', '');
    }
    if ($A['sp_format'] === 'leftblocks') {
        $sp_template->set_var('leftblocks_selected', 'selected="selected"');
    } else {
        $sp_template->set_var('leftblocks_selected', '');
    }
    if ($A['sp_format'] == 'blankpage') {
        $sp_template->set_var('blankpage_selected', 'selected="selected"');
    } else {
        $sp_template->set_var('blankpage_selected', '');
    }
    if (($A['sp_format'] === 'allblocks') || empty($A['sp_format'])) {
        $sp_template->set_var('allblocks_selected', 'selected="selected"');
    } else {
        $sp_template->set_var('allblocks_selected', '');
    }

    $sp_template->set_var('lang_content', $LANG_STATIC['content']);
    $content = '';
    if (isset($A['sp_content'])) {
        $content = htmlspecialchars(stripslashes($A['sp_content']));
        $content = str_replace(array('{', '}'), array('&#123;', '&#125;'),
            $content);
    }
    $sp_template->set_var('sp_content', $content);
    $allowed = COM_allowedHTML('staticpages.edit', false, $_SP_CONF['filter_html'])
        . COM_allowedAutotags();
    $sp_template->set_var('lang_allowedhtml', $allowed);
    $sp_template->set_var('lang_allowed_html', $allowed);
    $sp_template->set_var('lang_show_on_page', $LANG_STATIC['show_on_page']);
    if ($_SP_CONF['show_hits'] != 1) {
        $sp_template->set_var('lang_show_on_page_hits_disabled', $LANG_STATIC['show_on_page_disabled']);
    }
    $sp_template->set_var('lang_hits', $LANG_STATIC['hits']);
    if (empty($A['sp_hits'])) {
        $sp_template->set_var('sp_hits', '0');
        $sp_template->set_var('sp_hits_formatted', '0');
    } else {
        $sp_template->set_var('sp_hits', $A['sp_hits']);
        $sp_template->set_var('sp_hits_formatted', COM_numberFormat($A['sp_hits']));
    }
    $sp_template->set_var('lang_comments', $LANG_STATIC['comments']);
    if ($A['commentcode'] == -1) {
        $sp_template->set_var('sp_comments', $LANG_ADMIN['na']);
    } else {
        $num_comments = DB_count($_TABLES['comments'], array('sid', 'type'),
            array(DB_escapeString($A['sp_id']), 'staticpages'));
        $sp_template->set_var('sp_comments', COM_numberFormat($num_comments));
    }
    $sp_template->set_var(
        'end_block',
        COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'))
    );

    // Set previous pages, next pages, and parent pages
    $sp_template->set_var(array(
        'lang_prev_page'   => $LANG_STATIC['prev_page'],
        'lang_next_page'   => $LANG_STATIC['next_page'],
        'lang_parent_page' => $LANG_STATIC['parent_page'],
        'lang_page_desc'   => $LANG_STATIC['page_desc'],
        'sp_prev_pages'    => staticPageGetIdOptions($sp_id, $A['sp_prev']),
        'sp_next_pages'    => staticPageGetIdOptions($sp_id, $A['sp_next']),
        'sp_parent_pages'  => staticPageGetIdOptions($sp_id, $A['sp_parent']),
    ));

    // Security token
    $sp_template->set_var('gltoken_name', CSRF_TOKEN);
    $sp_template->set_var('gltoken', $token);
    $sp_template->parse('output', 'form');

    $retval .= $sp_template->finish($sp_template->get_var('output'));

    return $retval;
}

/**
 * List all template static pages. For use with a dropdown.
 *
 * @param  string $selected
 * @return string      HTML for the list
 */
function templatelist($selected = '')
{
    global $_TABLES;

    $retval = '';

    $perms = SP_getPerms();
    if (!empty($perms)) {
        $perms = ' AND ' . $perms;
    }

    $sql = "SELECT sp_id, sp_title FROM {$_TABLES['staticpage']} WHERE template_flag = 1 AND (draft_flag = 0)" . $perms . " ORDER BY sp_title";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if ($nrows > 0) {
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);

            $retval .= '<option value="' . $A['sp_id'] . '"';
            if ($A['sp_id'] == $selected) {
                $retval .= ' selected="selected"';
            }
            $retval .= '>' . $A['sp_title'] . '</option>';
        }
    }

    return $retval;
}

/**
 * List all static pages that the user has access to
 *
 * @retun    string      HTML for the list
 */
function liststaticpages()
{
    global $_CONF, $_TABLES, $LANG_ACCESS, $LANG_ADMIN, $LANG_STATIC, $_SP_CONF;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    $header_arr = array(      // display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG_ADMIN['copy'], 'field' => 'copy', 'sort' => false),
        //array('text' => $LANG_STATIC['id'], 'field' => 'sp_id', 'sort' => true),
        array('text' => $LANG_ADMIN['title'], 'field' => 'sp_title', 'sort' => true),
        array('text' => $LANG_ACCESS['access'], 'field' => 'access', 'sort' => false),
        array('text' => $LANG_STATIC['draft'], 'field' => 'draft_flag', 'sort' => true),
    );
    if ($_CONF['show_fullname'] == 1) {
        $header_arr[] = array('text' => $LANG_STATIC['writtenby'], 'field' => 'fullname', 'sort' => true);
    } else {
        $header_arr[] = array('text' => $LANG_STATIC['writtenby'], 'field' => 'username', 'sort' => true);
    }
    $header_arr[] = array('text' => $LANG_STATIC['date'], 'field' => 'unixdate', 'sort' => true);
    $header_arr[] = array('text' => $LANG_STATIC['head_centerblock'], 'field' => 'sp_centerblock', 'sort' => true);
    $header_arr[] = array('text' => $LANG_STATIC['template'], 'field' => 'template_id', 'sort' => true);

    switch ($_SP_CONF['sort_list_by']) {
        case 'author':
            if ($_CONF['show_fullname'] == 1) {
                $defsort_arr = array('field' => 'fullname', 'direction' => 'asc');
            } else {
                $defsort_arr = array('field' => 'username', 'direction' => 'asc');
            }
            break;

        case 'date':
            $defsort_arr = array('field' => 'unixdate', 'direction' => 'desc');
            break;

        case 'id':
            $defsort_arr = array('field' => 'sp_id', 'direction' => 'asc');
            break;

        case 'title':
            $defsort_arr = array('field' => 'sp_title', 'direction' => 'asc');
            break;
    }

    $menu_arr = array(
        array('url'  => $_CONF['site_admin_url'] . '/plugins/staticpages/index.php?mode=edit',
              'text' => $LANG_ADMIN['create_new']),
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']),
    );

    $help_url = COM_getDocumentUrl('docs', "staticpages.html");

    $retval .= COM_startBlock($LANG_STATIC['staticpagelist'], $help_url,
        COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu($menu_arr, $LANG_STATIC['instructions'],
        plugin_geticon_staticpages());

    $text_arr = array(
        'has_extras' => true,
        'form_url'   => $_CONF['site_admin_url'] . '/plugins/staticpages/index.php',
    );

    $sql = "SELECT *,UNIX_TIMESTAMP(modified) AS unixdate, {$_TABLES['users']}.username, {$_TABLES['users']}.fullname "
        . "FROM {$_TABLES['staticpage']} "
        . "LEFT JOIN {$_TABLES['users']} ON {$_TABLES['staticpage']}.owner_id = {$_TABLES['users']}.uid "
        . "WHERE 1=1 ";

    $query_arr = array(
        'table'          => 'staticpage',
        'sql'            => $sql,
        'query_fields'   => array('sp_title', 'sp_id'),
        'default_filter' => COM_getPermSQL('AND'), // COM_getPermSQL('AND', 0, 3),
    );

    $retval .= ADMIN_list('static_pages', 'plugin_getListField_staticpages',
        $header_arr, $text_arr, $query_arr, $defsort_arr);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
 * Displays the Static Page Editor
 *
 * @param    string $sp_id  ID of static page to edit
 * @param    string $mode   Mode
 * @param    string $editor Editor mode? (unused?)
 * @return   string              HTML for static pages editor
 */
function staticpageeditor($sp_id, $mode = '', $editor = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG_ACCESS, $LANG_STATIC, $_SP_CONF;

    $retval = '';

    if (!empty($sp_id) && $mode == 'edit') {
        $result = DB_query("SELECT *,UNIX_TIMESTAMP(modified) AS unixdate FROM {$_TABLES['staticpage']} WHERE sp_id = '$sp_id'" . COM_getPermSQL('AND', 0, 3));
        if (DB_numRows($result) == 1) {
            $A = DB_fetchArray($result);
            $A['sp_old_id'] = $A['sp_id'];
        }
    } elseif ($mode == 'edit') {
        // check if a new sp_id has been suggested
        $sp_new_id = Geeklog\Input::fGet('sp_new_id', '');
        if (empty($sp_new_id)) {
            $A['sp_id'] = COM_makesid(true);
        } else {
            $A['sp_id'] = $sp_new_id;
        }
        $A['owner_id'] = $_USER['uid'];
        $A['unixdate'] = time();
        $A['sp_help'] = '';
        $A['sp_old_id'] = '';
        $A['commentcode'] = $_SP_CONF['comment_code'];
        $A['structured_data_type'] = $_SP_CONF['structured_data_type_default'];
        $A['search'] = 1; // Use Default config setting
		$A['likes'] = -1; // Use Default config setting
        $A['sp_where'] = 1; // default new pages to "top of page"
        $A['draft_flag'] = $_SP_CONF['draft_flag'];
        $A['cache_time'] = $_SP_CONF['default_cache_time'];
        $A['sp_php'] = 0;
        $A['template_flag'] = ''; // Defaults to not a template
        $A['template_id'] = ''; // Defaults to None

        if ($_USER['advanced_editor'] == 1) {
            $A['postmode'] = 'adveditor';
        }

        $A['sp_prev'] = '';
        $A['sp_next'] = '';
        $A['sp_parent'] = '';
    } elseif (!empty($sp_id) && $mode == 'clone') {
        $result = DB_query("SELECT *,UNIX_TIMESTAMP(modified) AS unixdate FROM {$_TABLES['staticpage']} WHERE sp_id = '$sp_id'" . COM_getPermSQL('AND', 0, 3));
        if (DB_numRows($result) == 1) {
            $A = DB_fetchArray($result);
            $A['sp_id'] = COM_makesid(true);
            $A['clone_sp_id'] = $sp_id; // need this so we can load the correct topics
            $A['owner_id'] = $_USER['uid'];
            $A['unixdate'] = time();
            $A['sp_hits'] = 0;
            $A['sp_old_id'] = '';
            $A['sp_prev'] = '';
            $A['sp_next'] = '';
            $A['sp_parent'] = '';
        }
    } else {
        $A = $_POST;
        if (empty($A['unixdate'])) {
            $A['unixdate'] = time();
        }

        // If error out in editor and uses checkbox reset to how it is stored in db so function staticpageeditor_form can process it properly
        if ($A['sp_onmenu'] == 'on') {
            $A['sp_onmenu'] = 1;
        }
        if ($A['sp_onhits'] == 'on') {
            $A['sp_onhits'] = 1;
        }
        if ($A['sp_onlastupdate'] == 'on') {
            $A['sp_onlastupdate'] = 1;
        }
        if ($A['template_flag'] == 'on') {
            $A['template_flag'] = 1;
        }
        if ($A['draft_flag'] == 'on') {
            $A['draft_flag'] = 1;
        }
        if ($A['sp_nf'] == 'on') {
            $A['sp_nf'] = 1;
        }
        if ($A['sp_php'] == 'on') {
            $A['sp_php'] = 1;
        }
        if ($A['sp_where'] == 'on') {
            $A['sp_where'] = 1;
        }
        if ($A['sp_centerblock'] == 'on') {
            $A['sp_centerblock'] = 1;
        }
        if ($A['sp_inblock'] == 'on') {
            $A['sp_inblock'] = 1;
        }

        $A['sp_content'] = COM_checkHTML(COM_checkWords($A['sp_content']), 'staticpages.edit');
    }

    if (isset($A)) {
        if (isset($A['sp_title'])) {
            $A['sp_title'] = GLText::stripTags($A['sp_title']);
        }
        if (isset($A['sp_page_title'])) {
            $A['sp_page_title'] = GLText::stripTags($A['sp_page_title']);
        }
        if (isset($A['meta_description'])) {
            $A['meta_description'] = GLText::stripTags($A['meta_description']);
        }
        if (isset($A['meta_keywords'])) {
            $A['meta_keywords'] = GLText::stripTags($A['meta_keywords']);
        }

        $A['editor'] = $editor;

        if ($A['template_id'] != '' OR $A['template_flag'] OR $A['sp_php']) {
            if ($mode != '') { // this can happen if error on save and the staticpage editor is reloaded
                $A['sp_content'] = $A['page_data'];
            }
        }

        $retval = staticpageeditor_form($A);
    } else {
        $retval = COM_showMessageText($LANG_STATIC['deny_msg'], $LANG_ACCESS['accessdenied']);
    }

    return $retval;
}

/**
 * Saves a Static Page to the database
 *
 * @param  string $sp_id           ID of static page
 * @param  string $sp_title        title of page
 * @param  string $sp_page_title   page title of the staticpage
 * @param  string $sp_content      page content
 * @param  int    $sp_hits         Number of page views
 * @param  string $sp_format       HTML or plain text
 * @param  string $sp_onmenu       Flag to place entry on menu
 * @param  string $sp_onhits       Flag to shot hits
 * @param  string $sp_onlastupdate Flag to show last update
 * @param  string $sp_label        Menu Entry
 * @param  int    $commentCode     Comment Code
 * @param  int    $structured_data_type     Structured Data Type
 * @param  int    $search          Search option
 * @param  int    $likes          Likes option
 * @param  int    $owner_id        Permission bits
 * @param  int    $group_id
 * @param  int    $perm_owner
 * @param  int    $perm_members
 * @param  int    $perm_anon
 * @param  int    $sp_php          Flag to indicate PHP usage
 * @param  string $sp_nf           Flag to indicate type of not found message
 * @param  string $sp_old_id       original ID of this static page
 * @param  string $sp_centerblock  Flag to indicate display as a center block
 * @param  string $sp_help         Help URL that displays in the block
 * @param  int    $sp_where        position of center block
 * @param  string $sp_inblock      Flag: wrap page in a block (or not)
 * @param  string $postMode
 * @param  string $meta_description
 * @param  string $meta_keywords
 * @param  string $draft_flag      Flag: save as draft
 * @param  string $cache_time      Cache time of page
 * @param  string $sp_prev         Previous page ID
 * @param  string $sp_next         Next page ID
 * @param  string $sp_parent       Parent page ID
 * @return int
 */
function submitstaticpage($sp_id, $sp_title, $sp_page_title, $sp_content, $sp_hits,
                          $sp_format, $sp_onmenu, $sp_onhits, $sp_onlastupdate, $sp_label, $commentCode, $structured_data_type,
                          $owner_id, $group_id, $perm_owner, $perm_group,
                          $perm_members, $perm_anon, $sp_php, $sp_nf,
                          $sp_old_id, $sp_centerblock, $sp_help,
                          $sp_where, $sp_inblock, $postMode, $meta_description,
                          $meta_keywords, $draft_flag, $search, $likes, $template_flag, $template_id, $cache_time,
                          $sp_prev, $sp_next, $sp_parent)
{
    $retval = '';

    $args = array(
        'sp_id'            => $sp_id,
        'sp_title'         => $sp_title,
        'sp_page_title'    => $sp_page_title,
        'sp_content'       => $sp_content,
        'sp_hits'          => $sp_hits,
        'sp_format'        => $sp_format,
        'sp_onmenu'        => $sp_onmenu,
        'sp_onhits'        => $sp_onhits,
        'sp_onlastupdate'  => $sp_onlastupdate,
        'sp_label'         => $sp_label,
        'commentcode'      => $commentCode,
        'structured_data_type'      => $structured_data_type,
        'meta_description' => $meta_description,
        'meta_keywords'    => $meta_keywords,
        'template_flag'    => $template_flag,
        'template_id'      => $template_id,
        'draft_flag'       => $draft_flag,
        'search'           => $search,
		'likes'           => $likes,
        'cache_time'       => $cache_time,
        'owner_id'         => $owner_id,
        'group_id'         => $group_id,
        'perm_owner'       => $perm_owner,
        'perm_group'       => $perm_group,
        'perm_members'     => $perm_members,
        'perm_anon'        => $perm_anon,
        'sp_php'           => $sp_php,
        'sp_nf'            => $sp_nf,
        'sp_old_id'        => $sp_old_id,
        'sp_centerblock'   => $sp_centerblock,
        'sp_help'          => $sp_help,
        'sp_where'         => $sp_where,
        'sp_inblock'       => $sp_inblock,
        'postmode'         => $postMode,
        'sp_prev'          => $sp_prev,
        'sp_next'          => $sp_next,
        'sp_parent'        => $sp_parent,
    );
    PLG_invokeService('staticpages', 'submit', $args, $retval, $svc_msg);

    return $retval;
}

// MAIN
$mode = Geeklog\Input::fRequest('mode', '');
$sp_id = Geeklog\Input::fRequest('sp_id', '');
$display = '';

if (!empty($LANG_ADMIN['delete']) && ($mode === $LANG_ADMIN['delete']) && SEC_checkToken()) {
    if (empty($sp_id) || (is_numeric($sp_id) && ($sp_id == 0))) {
        COM_errorLog('Attempted to delete static page sp_id=' . $sp_id);
    } else {
        $args = array(
            'sp_id' => $sp_id,
        );

        PLG_invokeService('staticpages', 'delete', $args, $display, $svc_msg);
    }
} elseif ($mode === 'edit') {
    if (isset($_GET['msg'])) {
        $msg = (int) Geeklog\Input::fGet('msg', 0);
        if ($msg > 0) {
            $display .= COM_showMessage($msg, 'staticpages');
        }
    }
    $editor = Geeklog\Input::fGet('editor', '');
    $display .= staticpageeditor($sp_id, $mode, $editor);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_STATIC['staticpageeditor']));
} elseif ($mode === 'clone') {
    if (!empty($sp_id)) {
        $display .= staticpageeditor($sp_id, $mode);
        $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_STATIC['staticpageeditor']));
    } else {
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    }
} elseif (!empty($LANG_ADMIN['save']) && ($mode === $LANG_ADMIN['save']) && SEC_checkToken()) {
    if (!empty($sp_id)) {
        if (!isset($_POST['sp_onmenu'])) {
            $_POST['sp_onmenu'] = '';
        }
        if (!isset($_POST['sp_onhits'])) {
            $_POST['sp_onhits'] = '';
        }
        if (!isset($_POST['sp_onlastupdate'])) {
            $_POST['sp_onlastupdate'] = '';
        }
        if (!isset($_POST['sp_php'])) {
            $_POST['sp_php'] = '';
        }
        if (!isset($_POST['sp_nf'])) {
            $_POST['sp_nf'] = '';
        }
        if (!isset($_POST['sp_centerblock'])) {
            $_POST['sp_centerblock'] = '';
        }
        if (!isset($_POST['sp_inblock'])) {
            $_POST['sp_inblock'] = '';
        }
        if (!isset($_POST['postmode'])) {
            $_POST['postmode'] = '';
        }
        if (!isset($_POST['draft_flag'])) {
            $_POST['draft_flag'] = '';
        }
        if (!isset($_POST['cache_time'])) {
            $_POST['cache_time'] = $_SP_CONF['default_cache_time'];
        }
        if (!isset($_POST['template_flag'])) {
            $_POST['template_flag'] = '';
        }

        $display .= submitstaticpage(
            $sp_id,
            Geeklog\Input::post('sp_title'),
            Geeklog\Input::post('sp_page_title'),
            Geeklog\Input::post('sp_content'),
            (int) Geeklog\Input::fPost('sp_hits'),
            Geeklog\Input::fPost('sp_format'),
            Geeklog\Input::post('sp_onmenu'),
            Geeklog\Input::post('sp_onhits'),
            Geeklog\Input::post('sp_onlastupdate'),
            Geeklog\Input::post('sp_label'),
            (int) Geeklog\Input::fPost('commentcode'),
            Geeklog\Input::fPost('structured_data_type'),
            (int) Geeklog\Input::fPost('owner_id'),
            (int) Geeklog\Input::fPost('group_id'),
            Geeklog\Input::post('perm_owner'),
            Geeklog\Input::post('perm_group'),
            Geeklog\Input::post('perm_members'),
            Geeklog\Input::post('perm_anon'),
            Geeklog\Input::post('sp_php'),
            Geeklog\Input::post('sp_nf'),
            Geeklog\Input::fPost('sp_old_id'),
            Geeklog\Input::post('sp_centerblock'),
            Geeklog\Input::post('sp_help'),
            (int) Geeklog\Input::fPost('sp_where'),
            Geeklog\Input::post('sp_inblock'),
            Geeklog\Input::fPost('postmode'),
            Geeklog\Input::post('meta_description'),
            Geeklog\Input::post('meta_keywords'),
            Geeklog\Input::post('draft_flag'),
            (int) Geeklog\Input::fPost('search'),
			(int) Geeklog\Input::fPost('likes'),
            Geeklog\Input::post('template_flag'),
            Geeklog\Input::post('template_id'),
            (int) Geeklog\Input::fPost('cache_time'),
            Geeklog\Input::post('sp_prev'),
            Geeklog\Input::post('sp_next'),
            Geeklog\Input::post('sp_parent')
        );
    } else {
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    }
} else {
    $msg = (int) Geeklog\Input::fRequest('msg', 0);
    if ($msg > 0) {
        $display .= COM_showMessage($msg, 'staticpages');
    }
    $display .= liststaticpages();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_STATIC['staticpagelist']));
}

COM_output($display);
