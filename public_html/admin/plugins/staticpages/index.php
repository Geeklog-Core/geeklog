<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Geeklog Plugin 1.3                                           |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Administration page.                                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Phill Gillespie  - phill@mediaaustralia.com.au                   |
// |          Tom Willett      - twillett@users.sourceforge.net                |
// |          Dirk Haun        - dirk@haun-online.de                           |
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
// $Id: index.php,v 1.25 2003/08/02 17:19:35 dhaun Exp $

require_once('../../../lib-common.php');
require_once('../../auth.inc.php');

if (!SEC_hasRights('staticpages.edit')) {
    $display = COM_siteHeader('menu');
    $display .= COM_startBlock($LANG_STATIC['access_denied']);
    $display .= $LANG_STATIC['access_denied_msg'];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    echo $display;
    exit;
}


/**
* Displays the static page form 
*
* @A        array       Data to display
* @error    string      Error message to display
*
*/ 
function form ($A, $error = false) 
{
	global $_TABLES, $PHP_SELF, $_CONF, $HTTP_POST_VARS, $_USER, $LANG_STATIC,$_SP_CONF, $LANG_ACCESS, $mode, $sp_id;

	if (!empty($sp_id) && $mode=='edit') {
    	$access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
	} else {
    	$A['owner_id'] = $_USER['uid'];
		$A['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Static Page Admin'");
		$A['perm_owner'] = 3;
		$A['perm_group'] = 2;
		$A['perm_members'] = 2;
		$A['perm_anon'] = 2;
		$access = 3;
	}
    $retval = '';

    if (empty($A['owner_id'])) {
	    $error = COM_startBlock($LANG_ACCESS['accessdenied']);
    	$error .= $LANG_STATIC['deny_msg'];
	    $error .= COM_endBlock();
    }
    
    if ($error) {
        $retval .= $error . "<br><br>";
    } else {
        $sp_template = new Template($_CONF['path'] . 'plugins/staticpages/templates/admin');
        if (($_CONF['advanced_editor'] == 1) && file_exists ($_CONF['path'] . 'plugins/staticpages/templates/admin/editor_advanced.thtml')) {
            $sp_template->set_file ('form', 'editor_advanced.thtml');
        } else {
            $sp_template->set_file ('form', 'editor.thtml');
        }
        $sp_template->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    	$sp_template->set_var('lang_owner', $LANG_ACCESS['owner']);
        $sp_template->set_var('owner_username', DB_getItem($_TABLES['users'],'username',"uid = {$A['owner_id']}"));
        $sp_template->set_var('owner_id', $A['owner_id']);
        $sp_template->set_var('lang_group', $LANG_ACCESS['group']);
    	$usergroups = SEC_getUserGroups();
    	if ($access == 3) {
			$groupdd .= '<select name="group_id">';
        	for ($i = 0; $i < count($usergroups); $i++) {
            	$groupdd .= '<option value="' . $usergroups[key($usergroups)] . '"';
            	if ($A['group_id'] == $usergroups[key($usergroups)]) {
                	$groupdd .= ' SELECTED';
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
    	$sp_template->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
		$sp_template->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
        $sp_template->set_var('site_url', $_CONF['site_url']);
        $sp_template->set_var('site_admin_url', $_CONF['site_admin_url']);
        $sp_template->set_var('start_block_editor', COM_startBlock($LANG_STATIC['staticpageeditor']));
        $sp_template->set_var('lang_save', $LANG_STATIC['save']);
        $sp_template->set_var('lang_preview', $LANG_STATIC['preview']);
        if (SEC_hasRights('staticpages.delete')) {
            $sp_template->set_var('delete_option',"<input type=\"submit\" value=\"{$LANG_STATIC['delete']}\" name=\"mode\">");
        } else {
            $sp_template->set_var('delete_option','');
        }
        $sp_template->set_var('lang_writtenby', $LANG_STATIC['writtenby']);
        $sp_template->set_var('username', DB_getItem($_TABLES['users'],'username',"uid = {$A["sp_uid"]}"));
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

        if (SEC_hasRights ('staticpages.PHP')) {
            if ($A['sp_php'] == 1) {
    	        $sp_template->set_var('php_checked','checked');
    	        $sp_template->set_var('php_type','checkbox');
            } else {
                $sp_template->set_var('php_checked','');
            }
            $sp_template->set_var('php_type','checkbox');
            $sp_template->set_var('php_warn',$LANG_STATIC['php_warn']);
            $sp_template->set_var('php_msg',$LANG_STATIC['php_msg']);
        } else {
  	        $sp_template->set_var('php_type','hidden');
            $sp_template->set_var('php_warn','');
            $sp_template->set_var('php_msg','');
            $sp_template->set_var('php_checked','');
        }
        $sp_template->set_var('exit_msg',$LANG_STATIC['exit_msg']);
        if ($A['sp_nf'] == 1) {
            $sp_template->set_var('exit_checked','checked');
        } else {
            $sp_template->set_var('exit_checked','');
        }
        $sp_template->set_var('exit_info',$LANG_STATIC['exit_info']);

        $curtime = COM_getUserDateTimeFormat();

        $sp_template->set_var('lang_lastupdated', $LANG_STATIC['date']);
        $sp_template->set_var('sp_formateddate', $curtime[0]);
        $sp_template->set_var('sp_date', $curtime[1]);
        $sp_template->set_var('lang_title', $LANG_STATIC['title']);
        $sp_template->set_var('sp_title', stripslashes($A['sp_title']));
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
			$sp_template->set_var('noblock_selected', 'selected="SELECTED"');
		} else {
			$sp_template->set_var('noblock_selected', '');
		}
		if ($A['sp_format'] == 'leftblocks') {
			$sp_template->set_var('leftblocks_selected', 'selected="SELECTED"');
		} else {
			$sp_template->set_var('leftblocks_selected', '');
		}
        if ($A['sp_format'] == 'blankpage') {
            $sp_template->set_var('blankpage_selected', 'selected="SELECTED"');
        } else {
            $sp_template->set_var('blankpage_selected', '');
        }
		if (($A['sp_format'] == 'allblocks') OR empty($A['sp_format'])) {
			$sp_template->set_var('allblocks_selected', 'selected="SELECTED"');
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
        $sp_template->set_var('lang_hits', $LANG_STATIC['hits']);
        if (empty($A['sp_hits'])) {
            $sp_template->set_var('sp_hits', '0');
        } else {
            $sp_template->set_var('sp_hits', $A['sp_hits']);
        }
        $sp_template->set_var('end_block', COM_endblock());
        $retval .= $sp_template->parse('output','form');
	}

    return $retval;
}

/**
* Displays the Static Page Editor
*
* @sp_id        string      ID of static page to edit
* @mode         string      Mode
*
*/
function staticpageeditor ($sp_id, $mode = '') 
{
    global $HTTP_POST_VARS, $_USER, $_CONF, $_TABLES;

    if (!empty ($sp_id) && $mode == 'edit') {
        $perms = SP_getPerms ('', '3');
        if (!empty ($perms)) {
            $perms = ' AND ' . $perms;
        }
        $result = DB_query ("SELECT *,UNIX_TIMESTAMP(sp_date) AS unixdate FROM {$_TABLES['staticpage']} WHERE sp_id = '$sp_id'" . $perms);
        $A = DB_fetchArray ($result);
        $A['sp_old_id'] = $A['sp_id'];
    } elseif ($mode == 'edit') {
        $A['sp_id'] = COM_makesid ();
        $A['sp_uid'] = $_USER['uid'];
        $A['unixdate'] = time ();
        $A['sp_old_id'] = '';
        $A['sp_where'] = 1; // default new pages to "top of page"
    } elseif (!empty ($sp_id) && $mode == 'clone') {
        $perms = SP_getPerms ('', '3');
        if (!empty ($perms)) {
            $perms = ' AND ' . $perms;
        }
        $result = DB_query ("SELECT *,UNIX_TIMESTAMP(sp_date) AS unixdate FROM {$_TABLES['staticpage']} WHERE sp_id = '$sp_id'" . $perms);
        $A = DB_fetchArray ($result);
        $A['sp_id'] = COM_makesid ();
        $A['sp_uid'] = $_USER['uid'];
        $A['unixdate'] = time ();
        $A['sp_hits'] = 0;
        $A['sp_old_id'] = '';
    } else {
        $A = $HTTP_POST_VARS;
        $A['sp_content'] = COM_checkHTML (COM_checkWords ($A['sp_content']));
        $A['sp_old_id'] = $HTTP_POST_VARS['sp_old_id'];
    }
    $A['sp_title'] = strip_tags ($A['sp_title']);

    return form ($A);
}

###############################################################################
# Displays a list of static pages 

function liststaticpages ($page = 1) 
{
    global $_TABLES, $LANG_STATIC, $_CONF;

    $retval = '';

    $sp_templates = new Template($_CONF['path'] . '/plugins/staticpages/templates/admin');
    $sp_templates->set_file(array('list'=>'list.thtml','row'=>'row.thtml'));
    $sp_templates->set_var('site_url', $_CONF['site_url']);
    $sp_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $sp_templates->set_var('start_block_list', COM_startBlock($LANG_STATIC['staticpagelist']));
    $sp_templates->set_var('new_page_url', COM_buildURL($_CONF['site_admin_url'] . '/plugins/staticpages/index.php?mode=edit'));
    $sp_templates->set_var('lang_newpage', $LANG_STATIC['newpage']);
    $sp_templates->set_var('lang_adminhome', $LANG_STATIC['adminhome']);
    $sp_templates->set_var('lang_instructions', $LANG_STATIC['instructions']);
    $sp_templates->set_var('lang_title', $LANG_STATIC['title']);
    $sp_templates->set_var('lang_writtenby', $LANG_STATIC['writtenby']);
    $sp_templates->set_var('lang_lastupdated', $LANG_STATIC['date']);
    $sp_templates->set_var('lang_url', $LANG_STATIC['url']);
    $sp_templates->set_var('lang_centerblock', $LANG_STATIC['head_centerblock']);

    $perpage = 50;
    if ($page <= 0) {
        $page = 1;
    }

    $perms = SP_getPerms ('', '3');
    if (!empty ($perms)) {
       $perms = ' WHERE ' . $perms;
    }

    $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['staticpage']}" . $perms);
    $C = DB_fetchArray ($result);
    $numpages = ceil ($C['count'] / $perpage);

    if ($page > $numpages) {
        $page = 1;
    }
    $start = ($page - 1) * $perpage;

    $result = DB_query ("SELECT *,UNIX_TIMESTAMP(sp_date) AS unixdate FROM {$_TABLES['staticpage']}" . $perms . " ORDER BY sp_date DESC LIMIT $start,$perpage");
    $nrows = DB_numRows ($result);
    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $A = DB_fetchArray($result);
            $sp_templates->set_var ('sp_id', $A['sp_id']);
            $sp_templates->set_var ('page_edit_url',
                    COM_buildURL ($_CONF['site_admin_url']
                    . '/plugins/staticpages/index.php?mode=edit&amp;sp_id='
                    . $A['sp_id']));
            $sp_templates->set_var ('row_number', $i + $start);
            $sp_templates->set_var ('page_display_url',
                    COM_buildURL ($_CONF['site_url']
                    . '/staticpages/index.php?page=' . $A['sp_id']));
            $sp_templates->set_var ('page_clone_url',
                    COM_buildURL ($_CONF['site_admin_url']
                    . '/plugins/staticpages/index.php?mode=clone&amp;sp_id='
                    . $A['sp_id']));
            $sp_templates->set_var ('sp_title', stripslashes ($A['sp_title']));

            $nresult = DB_query ("SELECT username,fullname FROM {$_TABLES['users']} WHERE uid = {$A['sp_uid']}");
            $N = DB_fetchArray ($nresult);
            $sp_templates->set_var ('username', $N['username']);
            if (empty ($N['fullname'])) {
                $sp_templates->set_var ('fullname', $N['username']);
            } else {
                $sp_templates->set_var ('fullname', $N['fullname']);
            }

            if ($A['sp_centerblock']) {
                switch ($A['sp_where']) {
                    case '1': $where = $LANG_STATIC['centerblock_top']; break;
                    case '2': $where = $LANG_STATIC['centerblock_feat']; break;
                    case '3': $where = $LANG_STATIC['centerblock_bottom']; break;
                    default:  $where = $LANG_STATIC['centerblock_entire']; break;
                }
                $sp_templates->set_var ('sp_centerblock', $where);
            } else {
                $sp_templates->set_var ('sp_centerblock', $LANG_STATIC['centerblock_no']);
            }
            $curtime = COM_getUserDateTimeFormat ($A['unixdate']);
            $sp_templates->set_var ('sp_date', $curtime[0]);
            $sp_templates->parse ('list_item', 'row', true);
        }
        $sp_templates->set_var ('lang_nopages_msg', '');

        $baseurl = $_CONF['site_admin_url'] . '/plugins/staticpages/index.php';
        if ($numpages > 1) {
            $sp_templates->set_var ('google_paging',
                    COM_printPageNavigation ($baseurl, $page, $numpages));
        } else {
            $sp_templates->set_var ('google_paging', '');
        }
    } else {
        $sp_templates->set_var ('lang_nopages_msg', $LANG_STATIC['nopages']);
        $sp_templates->set_var ('list_item', '');
        $sp_templates->set_var ('google_paging', '');
    }
    $sp_templates->set_var ('end_block', COM_endBlock ());	

    $retval .= $sp_templates->parse('output', 'list');

    return $retval;
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
* @param sp_onmenu       int     Flag to place entry on menu
* @param sp_label        string  Menu Entry
* @param owner_id        int     Permission bits
* @param group_id        int
* @param perm_owner      int
* @param perm_members    int
* @param perm_anon       int
* @param sp_php          int     Flag to indicate PHP usage
* @param sp_nf           int     Flag to indicate type of not found message
* @param sp_old_id       string  original ID of this static page
* @param sp_centerblock  int     Flag to indicate display as a center block
* @param sp_tid          string  topid id (for center block)
* @param sp_where        int     position of center block
*
*/
function submitstaticpage ($sp_id, $sp_uid, $sp_title, $sp_content, $unixdate, $sp_hits, $sp_format, $sp_onmenu, $sp_label, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon, $sp_php, $sp_nf, $sp_old_id, $sp_centerblock, $sp_tid, $sp_where)
{
    global $_CONF, $LANG12, $LANG_STATIC, $_SP_CONF, $_TABLES;

    $sp_id = str_replace (' ', '', $sp_id);
    $sp_id = str_replace (array ('_', '/', '\\', ':'), '-', $sp_id);
    if (empty ($sp_id)) {
        $sp_id = COM_makesid ();
    }

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
        $retval .= COM_siteHeader ();
        $retval .= COM_errorLog ($LANG_STATIC['duplicate_id'], 2);
        $retval .= staticpageeditor ($sp_id);
        $retval .= COM_siteFooter ();
        echo $retval;
    } elseif (!empty ($sp_title) && !empty ($sp_content)) {
        $date = date ("Y-m-d H:i:s", $unixdate);

        if (empty ($sp_hits)) $sp_hits = 0;

        if ($sp_onmenu== 'on') {
            $sp_onmenu = 1;
        } else {
            $sp_onmenu = 0;
        }
        if ($sp_centerblock== 'on') {
            $sp_centerblock = 1;
        } else {
            $sp_centerblock = 0;
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
        if (!SEC_hasRights ('staticpages.PHP')) {
            $sp_php = 0;
        }

        // make sure there's only one "entire page" static page per topic
        if (($sp_centerblock == 1) && ($sp_where == 0)) {
            DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_centerblock = 0 WHERE sp_centerblock = 1 AND sp_where = 0 AND sp_tid = '$sp_tid'");
        }

        list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
		DB_save ($_TABLES['staticpage'], 'sp_id,sp_uid,sp_title,sp_content,sp_date,sp_hits,sp_format,sp_onmenu,sp_label,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,sp_php,sp_nf,sp_centerblock,sp_tid,sp_where', "'$sp_id',$sp_uid,'$sp_title','$sp_content','$date',$sp_hits,'$sp_format',$sp_onmenu,'$sp_label',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,'$sp_php','$sp_nf',$sp_centerblock,'$sp_tid',$sp_where");
        if ($delete_old_page && !empty ($sp_old_id)) {
            DB_delete ($_TABLES['staticpage'], 'sp_id', $sp_old_id);
        }
        echo COM_refresh ($_CONF['site_admin_url']
                          . '/plugins/staticpages/index.php');
    } else {
        $retval .= COM_siteHeader ();
        $retval .= COM_errorLog ($LANG_STATIC['no_title_or_content'], 2);
        $retval .= staticpageeditor ($sp_id);
        $retval .= COM_siteFooter ();
        echo $retval;
    }
}


// MAIN

if (empty($mode) OR empty($sp_id)) {
    COM_setArgNames(array('mode','sp_id'));    
    $mode = COM_getArgument('mode');
    $sp_id = COM_getArgument('sp_id');
}

if (($mode == $LANG_STATIC['delete']) && !empty ($LANG_STATIC['delete'])) {
    if (empty ($sp_id) || (is_numeric ($sp_id) && ($sp_id == 0))) {
        COM_errorLog ('Attempted to delete static page sp_id=' . $sp_id);
    } else {
        DB_delete($_TABLES['staticpage'],'sp_id',$sp_id,$_CONF['site_admin_url'] . '/plugins/staticpages/index.php');
    }
} else if ($mode == 'edit') {
    $display .= COM_siteHeader('menu');
    $display .= staticpageeditor($sp_id,$mode);
    $display .= COM_siteFooter();
} else if ($mode == 'clone') {
    $display .= COM_siteHeader ('menu');
    $display .= staticpageeditor ($sp_id,$mode);
    $display .= COM_siteFooter ();
} else if (($mode == $LANG_STATIC['save']) && !empty ($LANG_STATIC['save'])) {
    submitstaticpage ($sp_id, $sp_uid, $sp_title, $sp_content, $unixdate,
            $sp_hits, $sp_format, $sp_onmenu, $sp_label, $owner_id, $group_id,
            $perm_owner, $perm_group, $perm_members, $perm_anon, $sp_php,
            $sp_nf, $sp_old_id, $sp_centerblock, $sp_tid, $sp_where);
} else {
    $display .= COM_siteHeader ('menu');
    $display .= liststaticpages ($page);
    $display .= COM_siteFooter ();
}

echo $display;

?>
