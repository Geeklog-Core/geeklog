<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Geeklog Plugin 1.4.3                                         |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Administration page.                                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
//
// $Id: index.php,v 1.68 2006/07/08 19:58:43 dhaun Exp $

require_once ('../../../lib-common.php');
require_once ('../../auth.inc.php');

if (!SEC_hasRights ('staticpages.edit')) {
    $display = COM_siteHeader ('menu', $LANG_STATIC['access_denied']);
    $display .= COM_startBlock ($LANG_STATIC['access_denied'], '',
                        COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $LANG_STATIC['access_denied_msg'];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    COM_accessLog ("User {$_USER['username']} tried to illegally access the static pages administration screen.");
    echo $display;
    exit;
}


/**
* Displays the static page form 
*
* @param    array   $A      Data to display
* @param    string  $error  Error message to display
*
*/ 
function form ($A, $error = false) 
{
    global $_CONF, $_TABLES, $_USER, $_GROUPS, $_SP_CONF, $mode, $sp_id,
           $LANG_STATIC, $LANG_ACCESS, $LANG_ADMIN, $LANG24, $MESSAGE;

    if (!empty($sp_id) && $mode=='edit') {
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
    } else {
        $A['owner_id'] = $_USER['uid'];
        if (isset ($_GROUPS['Static Page Admin'])) {
            $A['group_id'] = $_GROUPS['Static Page Admin'];
        } else {
            $A['group_id'] = SEC_getFeatureGroup ('staticpages.edit');
        }
        SEC_setDefaultPermissions ($A, $_SP_CONF['default_permissions']);
        $A['sp_inblock'] = $_SP_CONF['in_block'];
        $access = 3;
    }
    $retval = '';

    if (empty ($A['owner_id'])) {
        $error = COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                        COM_getBlockTemplate ('_msg_block', 'header'));
        $error .= $LANG_STATIC['deny_msg'];
        $error .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }
    
    if ($error) {
        $retval .= $error . '<br><br>';
    } else {
        $template_path = staticpages_templatePath ('admin');
        $sp_template = new Template ($template_path);
        if (isset ($_CONF['advanced_editor']) && ($_CONF['advanced_editor'] == 1)
&& file_exists ($template_path . '/editor_advanced.thtml')) {
            $sp_template->set_file ('form', 'editor_advanced.thtml');
            $sp_template->set_var ('lang_expandhelp', $LANG24[67]);
            $sp_template->set_var ('lang_reducehelp', $LANG24[68]);
            $sp_template->set_var ('lang_toolbar', $LANG24[70]);
            $sp_template->set_var ('toolbar1', $LANG24[71]);
            $sp_template->set_var ('toolbar2', $LANG24[72]);
            $sp_template->set_var ('toolbar3', $LANG24[73]);
            $sp_template->set_var ('toolbar4', $LANG24[74]);
            $sp_template->set_var ('toolbar5', $LANG24[75]);
            $sp_template->set_var('lang_nojavascript',$LANG24[77]);
        } else {
            $sp_template->set_file ('form', 'editor.thtml');
        }
        $sp_template->set_var('layout_url', $_CONF['layout_url']);
        
        $sp_template->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
        $sp_template->set_var('lang_owner', $LANG_ACCESS['owner']);
        $ownername = COM_getDisplayName ($A['owner_id']);
        $sp_template->set_var('owner_username', DB_getItem($_TABLES['users'],
                              'username',"uid = {$A['owner_id']}"));
        $sp_template->set_var('owner_name', $ownername);
        $sp_template->set_var('owner', $ownername);
        $sp_template->set_var('owner_id', $A['owner_id']);

        $sp_template->set_var('lang_group', $LANG_ACCESS['group']);
        $usergroups = SEC_getUserGroups();
        $groupdd = '';
        if ($access == 3) {
            $groupdd .= '<select name="group_id">';
            for ($i = 0; $i < count($usergroups); $i++) {
                $groupdd .= '<option value="' . $usergroups[key($usergroups)] . '"';
                if ($A['group_id'] == $usergroups[key($usergroups)]) {
                    $groupdd .= ' selected="selected"';
                }
                $groupdd .= '>' . key($usergroups) . '</option>';
                next($usergroups);
            }
            $groupdd .= '</select>';
        } else {
            // they can't set the group then
            $groupdd .= DB_getItem($_TABLES['groups'],'grp_name',"grp_id = {$A['group_id']}");
            $groupdd .= '<input type="hidden" name="group_id" value="' . $A['group_id'] . '">';
        }
        $sp_template->set_var('group_dropdown', $groupdd);
        $sp_template->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
        $sp_template->set_var('lang_permissions', $LANG_ACCESS['permissions']);
        $sp_template->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
        $sp_template->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
        $sp_template->set_var('site_url', $_CONF['site_url']);
        $sp_template->set_var('site_admin_url', $_CONF['site_admin_url']);
        $sp_template->set_var('start_block_editor',
                COM_startBlock($LANG_STATIC['staticpageeditor']), '',
                        COM_getBlockTemplate ('_admin_block', 'header'));
        $sp_template->set_var('lang_save', $LANG_STATIC['save']);
        $sp_template->set_var('lang_cancel', $LANG_STATIC['cancel']);
        $sp_template->set_var('lang_preview', $LANG_STATIC['preview']);
        if (SEC_hasRights ('staticpages.delete') && ($mode != 'clone') &&
                !empty ($A['sp_old_id'])) {
            $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                       . '" name="mode"%s>';
            $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
            $sp_template->set_var ('delete_option',
                                   sprintf ($delbutton, $jsconfirm));
            $sp_template->set_var ('delete_option_no_confirmation',
                                   sprintf ($delbutton, ''));
        } else {
            $sp_template->set_var('delete_option','');
        }
        $sp_template->set_var('lang_writtenby', $LANG_STATIC['writtenby']);
        $sp_template->set_var('username', DB_getItem($_TABLES['users'],
                              'username', "uid = {$A['sp_uid']}"));
        $authorname = COM_getDisplayName ($A['sp_uid']);
        $sp_template->set_var ('name', $authorname);
        $sp_template->set_var ('author', $authorname);
        $sp_template->set_var ('lang_url', $LANG_STATIC['url']);
        $sp_template->set_var ('lang_id', $LANG_STATIC['id']);
        $sp_template->set_var('sp_uid', $A['sp_uid']);
        $sp_template->set_var('sp_id', $A['sp_id']);
        $sp_template->set_var('sp_old_id', $A['sp_old_id']);
        $sp_template->set_var ('example_url', COM_buildURL ($_CONF['site_url']
                               . '/staticpages/index.php?page=' . $A['sp_id']));

        $sp_template->set_var ('lang_centerblock', $LANG_STATIC['centerblock']);
        $sp_template->set_var ('lang_centerblock_msg', $LANG_STATIC['centerblock_msg']);
        if ($A['sp_centerblock'] == 1) {
            $sp_template->set_var('centerblock_checked', 'checked="checked"');
        } else {
            $sp_template->set_var('centerblock_checked', '');
        }
        $sp_template->set_var ('lang_topic', $LANG_STATIC['topic']);
        $sp_template->set_var ('lang_position', $LANG_STATIC['position']);
        $current_topic = $A['sp_tid'];
        if (empty ($current_topic)) {
            $current_topic = 'none';
        }
        $topics = COM_topicList ('tid,topic', $current_topic);
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
        $sp_template->set_var ('topic_selection', '<select name="sp_tid">'
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
        $sp_template->set_var ('pos_selection', $position);

        if (($_SP_CONF['allow_php'] == 1) && SEC_hasRights ('staticpages.PHP')) {
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
            $sp_template->set_var ('php_selector', $selection);
            $sp_template->set_var ('php_warn', $LANG_STATIC['php_warn']);
        } else {
            $sp_template->set_var ('php_selector', '');
            $sp_template->set_var ('php_warn', $LANG_STATIC['php_not_activated']);
        }
        $sp_template->set_var ('php_msg', $LANG_STATIC['php_msg']);

        // old variables (for the 1.3-type checkbox)
        $sp_template->set_var ('php_checked', '');
        $sp_template->set_var ('php_type', 'hidden');

        if ($A['sp_nf'] == 1) {
            $sp_template->set_var('exit_checked','checked="checked"');
        } else {
            $sp_template->set_var('exit_checked','');
        }
        $sp_template->set_var('exit_msg',$LANG_STATIC['exit_msg']);
        $sp_template->set_var('exit_info',$LANG_STATIC['exit_info']);

        if ($A['sp_inblock'] == 1) {
            $sp_template->set_var ('inblock_checked', 'checked="checked"');
        } else {
            $sp_template->set_var ('inblock_checked', '');
        }
        $sp_template->set_var ('inblock_msg', $LANG_STATIC['inblock_msg']);
        $sp_template->set_var ('inblock_info', $LANG_STATIC['inblock_info']);

        $curtime = COM_getUserDateTimeFormat();

        $sp_template->set_var('lang_lastupdated', $LANG_STATIC['date']);
        $sp_template->set_var('sp_formateddate', $curtime[0]);
        $sp_template->set_var('sp_date', $curtime[1]);
        $sp_template->set_var('lang_title', $LANG_STATIC['title']);
        $sp_template->set_var('sp_title',
                htmlspecialchars (stripslashes ($A['sp_title'])));
        $sp_template->set_var('lang_addtomenu', $LANG_STATIC['addtomenu']);
        if ($A['sp_onmenu'] == 1) {
            $sp_template->set_var('onmenu_checked', 'checked="checked"');
        } else {
            $sp_template->set_var('onmenu_checked', '');
        }
        $sp_template->set_var('lang_label', $LANG_STATIC['label']);
        $sp_template->set_var('sp_label', $A['sp_label']);
        $sp_template->set_var('lang_pageformat', $LANG_STATIC['pageformat']);
        $sp_template->set_var('lang_blankpage', $LANG_STATIC['blankpage']);
        $sp_template->set_var('lang_noblocks', $LANG_STATIC['noblocks']);
        $sp_template->set_var('lang_leftblocks', $LANG_STATIC['leftblocks']);
        $sp_template->set_var('lang_leftrightblocks', $LANG_STATIC['leftrightblocks']);
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
        $sp_template->set_var('sp_content', htmlspecialchars (stripslashes($A['sp_content'])));
        if ($_SP_CONF['filter_html'] == 1) {
            $sp_template->set_var('lang_allowedhtml', COM_allowedHTML()); 
        } else {
            $sp_template->set_var('lang_allowedhtml', $LANG_STATIC['all_html_allowed']);
        }
        $sp_template->set_var ('lang_hits', $LANG_STATIC['hits']);
        if (empty ($A['sp_hits'])) {
            $sp_template->set_var ('sp_hits', '0');
            $sp_template->set_var ('sp_hits_formatted', '0');
        } else {
            $sp_template->set_var ('sp_hits', $A['sp_hits']);
            $sp_template->set_var ('sp_hits_formatted',
                                   COM_numberFormat ($A['sp_hits']));
        }
        $sp_template->set_var('end_block',
                COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));
        $retval .= $sp_template->parse('output','form');
    }

    return $retval;
}

function liststaticpages()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG_ADMIN, $LANG_STATIC;
    require_once( $_CONF['path_system'] . 'lib-admin.php' );
    $retval = '';

    $header_arr = array(      # dislay 'text' and use table field 'field'
                    array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
                    array('text' => $LANG_ADMIN['copy'], 'field' => 'copy', 'sort' => false),
                    array('text' => $LANG_STATIC['id'], 'field' => 'sp_id', 'sort' => true),
                    array('text' => $LANG_ADMIN['title'], 'field' => 'sp_title', 'sort' => true),
                    array('text' => $LANG_STATIC['writtenby'], 'field' => 'sp_uid', 'sort' => false),
                    array('text' => $LANG_STATIC['head_centerblock'], 'field' => 'sp_centerblock', 'sort' => true),
                    array('text' => $LANG_STATIC['date'], 'field' => 'unixdate', 'sort' => true)
    );
    $defsort_arr = array('field' => 'sp_title', 'direction' => 'desc');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'] . '/plugins/staticpages/index.php?mode=edit',
                          'text' => $LANG_ADMIN['create_new']),
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home'])
    );

     $text_arr = array('has_menu' =>  true,
                       'has_extras'   => true,
                       'title' => $LANG_STATIC['staticpagelist'],
                       'instructions' => $LANG_STATIC['instructions'],
                       'icon' => $_CONF['site_url'] . '/staticpages/images/staticpages.png',
                       'form_url' => $_CONF['site_admin_url'] . "/plugins/staticpages/index.php");

    $query_arr = array('table' => 'staticpage',
                       'sql' => "SELECT *,UNIX_TIMESTAMP(sp_date) AS unixdate "
                               ."FROM {$_TABLES['staticpage']} WHERE 1 ",
                       'query_fields' => array('sp_title', 'sp_id'),
                       'default_filter' => COM_getPermSQL ('AND', 0, 3));

    $retval = ADMIN_list ("static_pages", "plugin_getListField_staticpages", $header_arr, $text_arr,
                            $query_arr, $menu_arr, $defsort_arr);
    return $retval;

}

/**
* Displays the Static Page Editor
*
* @sp_id        string      ID of static page to edit
* @mode         string      Mode
*
*/
function staticpageeditor ($sp_id, $mode = '', $editor = '')
{
    global $_CONF, $_TABLES, $_USER;

    if (!empty ($sp_id) && $mode == 'edit') {
        $result = DB_query ("SELECT *,UNIX_TIMESTAMP(sp_date) AS unixdate FROM {$_TABLES['staticpage']} WHERE sp_id = '$sp_id'" . COM_getPermSQL ('AND', 0, 3));
        $A = DB_fetchArray ($result);
        $A['sp_old_id'] = $A['sp_id'];
    } elseif ($mode == 'edit') {
        $A['sp_id'] = COM_makesid ();
        $A['sp_uid'] = $_USER['uid'];
        $A['unixdate'] = time ();
        $A['sp_old_id'] = '';
        $A['sp_where'] = 1; // default new pages to "top of page"
    } elseif (!empty ($sp_id) && $mode == 'clone') {
        $result = DB_query ("SELECT *,UNIX_TIMESTAMP(sp_date) AS unixdate FROM {$_TABLES['staticpage']} WHERE sp_id = '$sp_id'" . COM_getPermSQL ('AND', 0, 3));
        $A = DB_fetchArray ($result);
        $A['sp_id'] = COM_makesid ();
        $A['sp_uid'] = $_USER['uid'];
        $A['unixdate'] = time ();
        $A['sp_hits'] = 0;
        $A['sp_old_id'] = '';
    } else {
        $A = $_POST;
        $A['sp_content'] = COM_checkHTML (COM_checkWords ($A['sp_content']));
    }
    $A['sp_title'] = strip_tags ($A['sp_title']);
    $A['editor'] = $editor;
    return form ($A);
}

/** 
* Saves a Static Page to the database
*
* @param sp_id           string  ID of static page
* @param sp_uid          string  ID of user that created page
* @param sp_title        string  title of page
* @param sp_content      string  page content
* @param unixdate        string  date page was last updated
* @param sp_hits         int     Number of page views
* @param sp_format       string  HTML or plain text
* @param sp_onmenu       string  Flag to place entry on menu
* @param sp_label        string  Menu Entry
* @param owner_id        int     Permission bits
* @param group_id        int
* @param perm_owner      int
* @param perm_members    int
* @param perm_anon       int
* @param sp_php          int     Flag to indicate PHP usage
* @param sp_nf           string  Flag to indicate type of not found message
* @param sp_old_id       string  original ID of this static page
* @param sp_centerblock  string  Flag to indicate display as a center block
* @param sp_tid          string  topid id (for center block)
* @param sp_where        int     position of center block
* @param sp_inblock      string  Flag: wrap page in a block (or not)
*
*/
function submitstaticpage ($sp_id, $sp_uid, $sp_title, $sp_content, $unixdate, $sp_hits, $sp_format, $sp_onmenu, $sp_label, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon, $sp_php, $sp_nf, $sp_old_id, $sp_centerblock, $sp_tid, $sp_where, $sp_inblock)
{
    global $_CONF, $LANG12, $LANG_STATIC, $_SP_CONF, $_TABLES;

    $sp_id = COM_sanitizeID ($sp_id);

    // Check for unique page ID
    $duplicate_id = false;
    $delete_old_page = false;
    if (DB_count ($_TABLES['staticpage'], 'sp_id', $sp_id) > 0) {
        if ($sp_id != $sp_old_id) {
            $duplicate_id = true;
        }
    } elseif (!empty ($sp_old_id)) {
        if ($sp_id != $sp_old_id) {
            $delete_old_page = true;
        }
    }

    if ($duplicate_id) {
        $retval .= COM_siteHeader ('menu', $LANG_STATIC['staticpageeditor']);
        $retval .= COM_errorLog ($LANG_STATIC['duplicate_id'], 2);
        $retval .= staticpageeditor ($sp_id);
        $retval .= COM_siteFooter ();
        echo $retval;
    } elseif (!empty ($sp_title) && !empty ($sp_content)) {
        $date = date ('Y-m-d H:i:s', $unixdate);

        if (empty ($sp_hits)) {
            $sp_hits = 0;
        }

        if ($sp_onmenu == 'on') {
            $sp_onmenu = 1;
        } else {
            $sp_onmenu = 0;
        }
        if ($sp_nf == 'on') {
            $sp_nf = 1;
        } else {
            $sp_nf = 0;
        }
        if ($sp_centerblock == 'on') {
            $sp_centerblock = 1;
        } else {
            $sp_centerblock = 0;
        }
        if ($sp_inblock == 'on') {
            $sp_inblock = 1;
        } else {
            $sp_inblock = 0;
        }

        // Clean up the text
        if ($_SP_CONF['censor'] == 1) {
            $sp_content = COM_checkWords ($sp_content); 
            $sp_title = COM_checkWords ($sp_title);
        }
        if ($_SP_CONF['filter_html'] == 1) {
            $sp_content = COM_checkHTML ($sp_content);
        }
        $sp_title = strip_tags ($sp_title);
        $sp_label = strip_tags ($sp_label);

        $sp_content = addslashes ($sp_content);
        $sp_title = addslashes ($sp_title);
        $sp_label = addslashes ($sp_label);

        // If user does not have php edit perms, then set php flag to 0.
        if (($_SP_CONF['allow_php'] != 1) || !SEC_hasRights ('staticpages.PHP')) {
            $sp_php = 0;
        }

        // make sure there's only one "entire page" static page per topic
        if (($sp_centerblock == 1) && ($sp_where == 0)) {
            DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_centerblock = 0 WHERE sp_centerblock = 1 AND sp_where = 0 AND sp_tid = '$sp_tid'");
        }

        list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
        DB_save ($_TABLES['staticpage'], 'sp_id,sp_uid,sp_title,sp_content,sp_date,sp_hits,sp_format,sp_onmenu,sp_label,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,sp_php,sp_nf,sp_centerblock,sp_tid,sp_where,sp_inblock', "'$sp_id',$sp_uid,'$sp_title','$sp_content','$date',$sp_hits,'$sp_format',$sp_onmenu,'$sp_label',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,'$sp_php','$sp_nf',$sp_centerblock,'$sp_tid',$sp_where,'$sp_inblock'");
        if ($delete_old_page && !empty ($sp_old_id)) {
            DB_delete ($_TABLES['staticpage'], 'sp_id', $sp_old_id);
        }
        echo COM_refresh ($_CONF['site_admin_url']
                          . '/plugins/staticpages/index.php');
    } else {
        $retval .= COM_siteHeader ('menu', $LANG_STATIC['staticpageeditor']);
        $retval .= COM_errorLog ($LANG_STATIC['no_title_or_content'], 2);
        $retval .= staticpageeditor ($sp_id);
        $retval .= COM_siteFooter ();
        echo $retval;
    }
}


// MAIN
$mode = '';
if (isset($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}
$sp_id = '';
if (isset($_REQUEST['sp_id'])) {
    $sp_id = COM_applyFilter ($_REQUEST['sp_id']);
}


if (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) {
    if (empty ($sp_id) || (is_numeric ($sp_id) && ($sp_id == 0))) {
        COM_errorLog ('Attempted to delete static page sp_id=' . $sp_id);
    } else {
        DB_delete ($_TABLES['staticpage'], 'sp_id', $sp_id,
                $_CONF['site_admin_url'] . '/plugins/staticpages/index.php');
    }
} else if ($mode == 'edit') {
    $display .= COM_siteHeader ('menu', $LANG_STATIC['staticpageeditor']);
    if (isset ($_GET['editor'])) {
        $editor = COM_applyFilter ($_GET['editor']);
    }
    $display .= staticpageeditor ($sp_id, $mode,$editor);
    $display .= COM_siteFooter ();
} else if ($mode == 'clone') {
    if (!empty ($sp_id)) {
        $display .= COM_siteHeader('menu', $LANG_STATIC['staticpageeditor']);
        $display .= staticpageeditor($sp_id,$mode);
        $display .= COM_siteFooter();
    } else {
        $display = COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    }
} else if (($mode == $LANG_STATIC['save']) && !empty ($LANG_STATIC['save'])) {
    if (!empty ($sp_id)) {
        submitstaticpage ($sp_id, $_POST['sp_uid'], $_POST['sp_title'],
            $_POST['sp_content'], $_POST['unixdate'], $_POST['sp_hits'],
            $_POST['sp_format'], $_POST['sp_onmenu'], $_POST['sp_label'],
            $_POST['owner_id'], $_POST['group_id'], $_POST['perm_owner'],
            $_POST['perm_group'], $_POST['perm_members'], $_POST['perm_anon'],
            $_POST['sp_php'], $_POST['sp_nf'], $_POST['sp_old_id'],
            $_POST['sp_centerblock'], $_POST['sp_tid'], $_POST['sp_where'],
            $_POST['sp_inblock']);
    } else {
        $display = COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    }
} else {
    $display .= COM_siteHeader ('menu', $LANG_STATIC['staticpagelist']);
    $display .= liststaticpages();
    $display .= COM_siteFooter ();
}

echo $display;

?>
