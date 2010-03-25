<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Geeklog Plugin 1.6                                           |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Administration page.                                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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
* @package StaticPages
* @subpackage admin
*/

/**
* Geeklog common function library and Admin authentication
*/
require_once '../../../lib-common.php';
require_once '../../auth.inc.php';

$display = '';

if (!SEC_hasRights('staticpages.edit')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the static pages administration screen.");
    COM_output($display);
    exit;
}


/**
* Displays the static page editor form
*
* @param    array   $A  Data to display
* @return   string      HTML for the static page editor
*
*/
function staticpageeditor_form($A, $error = false)
{
    global $_CONF, $_TABLES, $_USER, $_GROUPS, $_SP_CONF, $mode, $sp_id,
           $LANG21, $LANG_STATIC, $LANG_ACCESS, $LANG_ADMIN, $LANG24,
           $LANG_postmodes, $MESSAGE, $_IMAGE_TYPE;

    $template_path = staticpages_templatePath('admin');
    if (!empty($sp_id) && $mode=='edit') {
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
    } else {
        if ($mode != 'clone') {
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

    $sp_template = new Template($template_path);
    if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
        $sp_template->set_file('form', 'editor_advanced.thtml');

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
        $sp_template->set_var('post_options', $post_options );
        $sp_template->set_var('change_editormode',
                              'onchange="change_editmode(this);"');
    } else {
        $sp_template->set_file('form', 'editor.thtml');
    }

    $sp_template->set_var('xhtml', XHTML);
    $sp_template->set_var('site_url', $_CONF['site_url']);
    $sp_template->set_var('site_admin_url', $_CONF['site_admin_url']);
    $sp_template->set_var('layout_url', $_CONF['layout_url']);

    $sp_template->set_var('lang_mode', $LANG24[3]);
    $sp_template->set_var('comment_options',
                          COM_optionList($_TABLES['commentcodes'], 'code,name',
                                         $A['commentcode']));

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
        $profile_link = $_CONF['site_url']
                      . '/users.php?mode=profile&amp;uid=' . $A['owner_id'];

        $sp_template->set_var('start_owner_anchortag',
                              '<a href="' . $profile_link . '">' );
        $sp_template->set_var('end_owner_anchortag', '</a>');
        $sp_template->set_var('owner_link',
                              COM_createLink($owner_name, $profile_link));

        $photo = '';
        if ($_CONF['allow_user_photo']) {
            $photo = DB_getItem($_TABLES['users'], 'photo',
                                "uid = {$A['owner_id']}");
            if (! empty($photo)) {
                $camera_icon = '<img src="' . $_CONF['layout_url']
                             . '/images/smallcamera.' . $_IMAGE_TYPE
                             . '" alt=""' . XHTML . '>';
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
    $sp_template->set_var('group_dropdown',
                          SEC_getGroupDropdown($A['group_id'], $access));
    $sp_template->set_var('permissions_editor',
        SEC_getPermissionsHTML($A['perm_owner'], $A['perm_group'],
                               $A['perm_members'], $A['perm_anon']));
    $sp_template->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $sp_template->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $sp_template->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
    $sp_template->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);

    $token = SEC_createToken();
    $start_block = COM_startBlock($LANG_STATIC['staticpageeditor'], '',
                        COM_getBlockTemplate('_admin_block', 'header'));
    $start_block .= SEC_getTokenExpiryNotice($token);

    $sp_template->set_var('start_block_editor', $start_block);
    $sp_template->set_var('lang_save', $LANG_ADMIN['save']);
    $sp_template->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $sp_template->set_var('lang_preview', $LANG_ADMIN['preview']);
    if (SEC_hasRights('staticpages.delete') && ($mode != 'clone') &&
            !empty($A['sp_old_id'])) {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s' . XHTML . '>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $sp_template->set_var('delete_option',
                              sprintf($delbutton, $jsconfirm));
        $sp_template->set_var('delete_option_no_confirmation',
                              sprintf($delbutton, ''));
    } else {
        $sp_template->set_var('delete_option', '');
    }
    $sp_template->set_var('lang_writtenby', $LANG_STATIC['writtenby']);
    $sp_template->set_var('username', DB_getItem($_TABLES['users'],
                          'username', "uid = {$A['owner_id']}"));
    $authorname = COM_getDisplayName($A['owner_id']);
    $sp_template->set_var('name', $authorname);
    $sp_template->set_var('author', $authorname);
    $sp_template->set_var('lang_url', $LANG_STATIC['url']);
    $sp_template->set_var('lang_id', $LANG_STATIC['id']);
    $sp_template->set_var('sp_uid', $A['owner_id']);
    $sp_template->set_var('sp_id', $A['sp_id']);
    $sp_template->set_var('sp_old_id', $A['sp_old_id']);
    $sp_template->set_var('example_url', COM_buildURL($_CONF['site_url']
                          . '/staticpages/index.php?page=' . $A['sp_id']));

    $sp_template->set_var('lang_centerblock', $LANG_STATIC['centerblock']);
    $sp_template->set_var('lang_centerblock_help', $LANG_ADMIN['help_url']);
    $sp_template->set_var('lang_centerblock_include', $LANG21[51]);
    $sp_template->set_var('lang_centerblock_desc', $LANG21[52]);
    $sp_template->set_var('centerblock_help', $A['sp_help']);
    $sp_template->set_var('lang_centerblock_msg',
                          $LANG_STATIC['centerblock_msg']);
    if (isset($A['sp_centerblock']) && ($A['sp_centerblock'] == 1)) {
        $sp_template->set_var('centerblock_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('centerblock_checked', '');
    }
    $sp_template->set_var('lang_topic', $LANG_STATIC['topic']);
    $sp_template->set_var('lang_position', $LANG_STATIC['position']);
    $current_topic = '';
    if (isset($A['sp_tid'])) {
        $current_topic = $A['sp_tid'];
    }
    if (empty($current_topic)) {
        $current_topic = 'none';
    }
    $topics = COM_topicList('tid,topic', $current_topic, 1, true);
    $alltopics = '<option value="all"';
    if ($current_topic == 'all') {
        $alltopics .= ' selected="selected"';
    }
    $alltopics .= '>' . $LANG_STATIC['all_topics'] . '</option>' . LB;
    $notopic = '<option value="none"';
    if ($current_topic == 'none') {
        $notopic .= ' selected="selected"';
    }
    $notopic .= '>' . $LANG_STATIC['no_topic'] . '</option>' . LB;
    $sp_template->set_var('topic_selection', '<select name="sp_tid">'
                          . $alltopics . $notopic . $topics . '</select>');
    $position = '<select name="sp_where">';
    $position .= '<option value="1"';
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
    $position .= '</select>';
    $sp_template->set_var('pos_selection', $position);

    if (($_SP_CONF['allow_php'] == 1) && SEC_hasRights('staticpages.PHP')) {
        if (! isset($A['sp_php'])) {
            $A['sp_php'] = 0;
        }
        $selection = '<select name="sp_php">' . LB;
        $selection .= '<option value="0"';
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
        $selection .= '</select>';
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
    $sp_template->set_var('lang_addtomenu', $LANG_STATIC['addtomenu']);
    if (isset($A['sp_onmenu']) && ($A['sp_onmenu'] == 1)) {
        $sp_template->set_var('onmenu_checked', 'checked="checked"');
    } else {
        $sp_template->set_var('onmenu_checked', '');
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
    $sp_template->set_var('lang_leftrightblocks',
                          $LANG_STATIC['leftrightblocks']);
    if (!isset($A['sp_format'])) {
        $A['sp_format'] = '';
    }
    if ($A['sp_format'] == 'noblocks') {
        $sp_template->set_var('noblock_selected', 'selected="selected"');
    } else {
        $sp_template->set_var('noblock_selected', '');
    }
    if ($A['sp_format'] == 'leftblocks') {
        $sp_template->set_var('leftblocks_selected', 'selected="selected"');
    } else {
        $sp_template->set_var('leftblocks_selected', '');
    }
    if ($A['sp_format'] == 'blankpage') {
        $sp_template->set_var('blankpage_selected', 'selected="selected"');
    } else {
        $sp_template->set_var('blankpage_selected', '');
    }
    if (($A['sp_format'] == 'allblocks') OR empty($A['sp_format'])) {
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
    if ($_SP_CONF['filter_html'] == 1) {
        $allowed = COM_allowedHTML('staticpages.edit');
        $sp_template->set_var('lang_allowedhtml', $allowed);
        $sp_template->set_var('lang_allowed_html', $allowed);
    } else {
        $sp_template->set_var('lang_allowedhtml',
                              $LANG_STATIC['all_html_allowed']);
        $allowed = '<span class="warningsmall">'
                 . $LANG_STATIC['all_html_allowed'] . ',</span>' . LB
                 . '<div dir="ltr" class="warningsmall">';
        $autotags = array_keys(PLG_collectTags());
        $allowed .= '[' . implode(':], [', $autotags) . ':]';
        $allowed .= '</div>';
        $sp_template->set_var('lang_allowed_html', $allowed);
    }
    $sp_template->set_var('lang_hits', $LANG_STATIC['hits']);
    if (empty($A['sp_hits'])) {
        $sp_template->set_var('sp_hits', '0');
        $sp_template->set_var('sp_hits_formatted', '0');
    } else {
        $sp_template->set_var('sp_hits', $A['sp_hits']);
        $sp_template->set_var('sp_hits_formatted',
                              COM_numberFormat($A['sp_hits']));
    }
    $sp_template->set_var('lang_comments', $LANG_STATIC['comments']);
    if ($A['commentcode'] == -1) {
        $sp_template->set_var('sp_comments', $LANG_ADMIN['na']);
    } else {
        $num_comments = DB_count($_TABLES['comments'], array('sid', 'type'),
            array(addslashes($A['sp_id']), 'staticpages'));
        $sp_template->set_var('sp_comments', COM_numberFormat($num_comments));
    }
    $sp_template->set_var('end_block',
            COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer')));
    $sp_template->set_var('gltoken_name', CSRF_TOKEN);
    $sp_template->set_var('gltoken', $token);
    $sp_template->parse('output', 'form');

    $retval .= $sp_template->finish($sp_template->get_var('output'));

    return $retval;
}

/**
* List all static pages that the user has access to
*
* @retun    string      HTML for the list
*
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
        array('text' => $LANG_STATIC['draft'], 'field' => 'draft_flag', 'sort' => true)
    );
    if ($_CONF['show_fullname'] == 1) {
        $header_arr[] = array('text' => $LANG_STATIC['writtenby'], 'field' => 'fullname', 'sort' => true);
    } else {
        $header_arr[] = array('text' => $LANG_STATIC['writtenby'], 'field' => 'username', 'sort' => true);
    }
    $header_arr[] = array('text' => $LANG_STATIC['date'], 'field' => 'unixdate', 'sort' => true);
    $header_arr[] = array('text' => $LANG_STATIC['head_centerblock'], 'field' => 'sp_centerblock', 'sort' => true);

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
        array('url' => $_CONF['site_admin_url'] . '/plugins/staticpages/index.php?mode=edit',
              'text' => $LANG_ADMIN['create_new']),
        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $retval .= COM_startBlock($LANG_STATIC['staticpagelist'], '',
                              COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu($menu_arr, $LANG_STATIC['instructions'],
                                plugin_geticon_staticpages());

    $text_arr = array(
        'has_extras' => true,
        'form_url' => $_CONF['site_admin_url'] . '/plugins/staticpages/index.php'
    );

    $query_arr = array(
        'table' => 'staticpage',
        'sql' => "SELECT *,UNIX_TIMESTAMP(modified) AS unixdate, {$_TABLES['users']}.username, {$_TABLES['users']}.fullname "
                ."FROM {$_TABLES['staticpage']} "
                ."LEFT JOIN {$_TABLES['users']} ON {$_TABLES['staticpage']}.owner_id = {$_TABLES['users']}.uid "
                ."WHERE 1=1 ",
        'query_fields' => array('sp_title', 'sp_id'),
        'default_filter' => COM_getPermSQL('AND', 0, 3)
    );

    $retval .= ADMIN_list('static_pages', 'plugin_getListField_staticpages',
                          $header_arr, $text_arr, $query_arr, $defsort_arr);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
* Displays the Static Page Editor
*
* @param    string  $sp_id      ID of static page to edit
* @param    string  $mode       Mode
* @param    string  $editor     Editor mode? (unused?)
* @return   string              HTML for static pages editor
*
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
        $sp_new_id = '';
        if (isset($_GET['sp_new_id'])) {
            $sp_new_id = COM_applyFilter($_GET['sp_new_id']);
        }
        if (empty($sp_new_id)) {
            $A['sp_id'] = COM_makesid();
        } else {
            $A['sp_id'] = $sp_new_id;
        }
        $A['owner_id'] = $_USER['uid'];
        $A['unixdate'] = time();
        $A['sp_help'] = '';
        $A['sp_old_id'] = '';
        $A['commentcode'] = $_SP_CONF['comment_code'];
        $A['sp_where'] = 1; // default new pages to "top of page"
        $A['draft_flag'] = $_SP_CONF['draft_flag'];
    } elseif (!empty($sp_id) && $mode == 'clone') {
        $result = DB_query("SELECT *,UNIX_TIMESTAMP(modified) AS unixdate FROM {$_TABLES['staticpage']} WHERE sp_id = '$sp_id'" . COM_getPermSQL('AND', 0, 3));
        if (DB_numRows($result) == 1) {
            $A = DB_fetchArray($result);
            $A['sp_id'] = COM_makesid();
            $A['owner_id'] = $_USER['uid'];
            $A['unixdate'] = time();
            $A['sp_hits'] = 0;
            $A['sp_old_id'] = '';
            $A['commentcode'] = $_SP_CONF['comment_code'];
        }
    } else {
        $A = $_POST;
        if (empty($A['unixdate'])) {
            $A['unixdate'] = time();
        }
        $A['sp_content'] = COM_checkHTML(COM_checkWords($A['sp_content']),
                                         'staticpages.edit');
    }

    if (isset($A)) {
        if (isset($A['sp_title'])) {
            $A['sp_title'] = strip_tags($A['sp_title']);
        }
        if (isset($A['sp_page_title'])) {
            $A['sp_page_title'] = strip_tags($A['sp_page_title']);
        }
        if (isset($A['meta_description'])) {
            $A['meta_description'] = strip_tags($A['meta_description']);
        }
        if (isset($A['meta_keywords'])) {
            $A['meta_keywords'] = strip_tags($A['meta_keywords']);
        }    

        $A['editor'] = $editor;

        $retval = staticpageeditor_form($A);
    } else {
        $retval = COM_startBlock($LANG_ACCESS['accessdenied'], '',
                        COM_getBlockTemplate('_msg_block', 'header'))
                . $LANG_STATIC['deny_msg']
                . COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
    }

    return $retval;
}

/**
* Saves a Static Page to the database
*
* @param string sp_id            ID of static page
* @param string sp_title         title of page
* @param string sp_page_title    page title of the staticpage
* @param string sp_content       page content
* @param int    sp_hits          Number of page views
* @param string sp_format        HTML or plain text
* @param string sp_onmenu        Flag to place entry on menu
* @param string sp_label         Menu Entry
* @param int    commentcode      Comment Code
* @param int    owner_id         Permission bits
* @param int    group_id
* @param int    perm_owner
* @param int    perm_members
* @param int    perm_anon
* @param int    sp_php           Flag to indicate PHP usage
* @param string sp_nf            Flag to indicate type of not found message
* @param string sp_old_id        original ID of this static page
* @param string sp_centerblock   Flag to indicate display as a center block
* @param string sp_help          Help URL that displays in the block
* @param string sp_tid           topid id (for center block)
* @param int    sp_where         position of center block
* @param string sp_inblock       Flag: wrap page in a block (or not)
* @param string postmode
* @param string meta_description
* @param string meta_keywords
* @param string draft_flag       Flag: save as draft
*
*/
function submitstaticpage($sp_id, $sp_title,$sp_page_title, $sp_content, $sp_hits,
                          $sp_format, $sp_onmenu, $sp_label, $commentcode,
                          $owner_id, $group_id, $perm_owner, $perm_group,
                          $perm_members, $perm_anon, $sp_php, $sp_nf,
                          $sp_old_id, $sp_centerblock, $sp_help, $sp_tid,
                          $sp_where, $sp_inblock, $postmode, $meta_description,
                          $meta_keywords, $draft_flag)
{
    $retval = '';

    $args = array(
                'sp_id' => $sp_id,
                'sp_title' => $sp_title,
                'sp_page_title' => $sp_page_title,
                'sp_content' => $sp_content,
                'sp_hits' => $sp_hits,
                'sp_format' => $sp_format,
                'sp_onmenu' => $sp_onmenu,
                'sp_label' => $sp_label,
                'commentcode' => $commentcode,
                'meta_description' => $meta_description,
                'meta_keywords' => $meta_keywords,                
                'draft_flag' => $draft_flag,
                'owner_id' => $owner_id,
                'group_id' => $group_id,
                'perm_owner' => $perm_owner,
                'perm_group' => $perm_group,
                'perm_members' => $perm_members,
                'perm_anon' => $perm_anon,
                'sp_php' => $sp_php,
                'sp_nf' => $sp_nf,
                'sp_old_id' => $sp_old_id,
                'sp_centerblock' => $sp_centerblock,
                'sp_help' => $sp_help,
                'sp_tid' => $sp_tid,
                'sp_where' => $sp_where,
                'sp_inblock' => $sp_inblock,
                'postmode' => $postmode
                 );

    PLG_invokeService('staticpages', 'submit', $args, $retval, $svc_msg);

    return $retval;
}


// MAIN
$mode = '';
if (isset($_REQUEST['mode'])) {
    $mode = COM_applyFilter($_REQUEST['mode']);
}
$sp_id = '';
if (isset($_REQUEST['sp_id'])) {
    $sp_id = COM_applyFilter($_REQUEST['sp_id']);
}

$display = '';

if (($mode == $LANG_ADMIN['delete']) && !empty($LANG_ADMIN['delete']) && SEC_checkToken()) {
    if (empty($sp_id) || (is_numeric($sp_id) && ($sp_id == 0))) {
        COM_errorLog('Attempted to delete static page sp_id=' . $sp_id);
    } else {
        $args = array(
                    'sp_id' => $sp_id
                     );
        PLG_invokeService('staticpages', 'delete', $args, $display, $svc_msg);
    }
} elseif ($mode == 'edit') {
    $display .= COM_siteHeader('menu', $LANG_STATIC['staticpageeditor']);
    if (isset($_GET['msg'])) {
        $msg = COM_applyFilter($_GET['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage($msg, 'staticpages');
        }
    }
    $editor = '';
    if (isset($_GET['editor'])) {
        $editor = COM_applyFilter($_GET['editor']);
    }
    $display .= staticpageeditor($sp_id, $mode, $editor);
    $display .= COM_siteFooter();
} elseif ($mode == 'clone') {
    if (!empty($sp_id)) {
        $display .= COM_siteHeader('menu', $LANG_STATIC['staticpageeditor']);
        $display .= staticpageeditor($sp_id,$mode);
        $display .= COM_siteFooter();
    } else {
        $display = COM_refresh($_CONF['site_admin_url'] . '/index.php');
    }
} elseif (($mode == $LANG_ADMIN['save']) && !empty($LANG_ADMIN['save']) && SEC_checkToken()) {
    if (!empty($sp_id)) {
        if (!isset($_POST['sp_onmenu'])) {
            $_POST['sp_onmenu'] = '';
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
        $help = '';
        if (isset($_POST['sp_help'])) {
            $sp_help = COM_sanitizeUrl($_POST['sp_help'], array('http', 'https'));
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
        $display .= submitstaticpage($sp_id, $_POST['sp_title'], $_POST['sp_page_title'],
            $_POST['sp_content'], COM_applyFilter($_POST['sp_hits'], true),
            COM_applyFilter($_POST['sp_format']), $_POST['sp_onmenu'],
            $_POST['sp_label'], COM_applyFilter($_POST['commentcode'], true),
            COM_applyFilter($_POST['owner_id'], true),
            COM_applyFilter($_POST['group_id'], true), $_POST['perm_owner'],
            $_POST['perm_group'], $_POST['perm_members'], $_POST['perm_anon'],
            $_POST['sp_php'], $_POST['sp_nf'],
            COM_applyFilter($_POST['sp_old_id']), $_POST['sp_centerblock'],
            $sp_help, COM_applyFilter($_POST['sp_tid']),
            COM_applyFilter($_POST['sp_where'], true), $_POST['sp_inblock'],
            COM_applyFilter($_POST['postmode']), $_POST['meta_description'],
            $_POST['meta_keywords'], $_POST['draft_flag']); 
    } else {
        $display = COM_refresh($_CONF['site_admin_url'] . '/index.php');
    }
} else {
    $display .= COM_siteHeader('menu', $LANG_STATIC['staticpagelist']);
    if (isset($_REQUEST['msg'])) {
        $msg = COM_applyFilter($_REQUEST['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage($msg, 'staticpages');
        }
    }
    $display .= liststaticpages();
    $display .= COM_siteFooter();
}

COM_output($display);

?>
