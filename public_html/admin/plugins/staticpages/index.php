<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Geeklog Plugin 0.1                                           |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// | Administration page.                                                      |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
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
// $Id: index.php,v 1.11 2002/10/16 17:16:16 dhaun Exp $

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
function form($A, $error=false) 
{
	global $_TABLES, $PHP_SELF, $_CONF, $HTTP_POST_VARS, $_USER, $LANG_STATIC,$_SP_CONF;

    $retval = '';

    if ($error) {
        $retval .= $error . "<br><br>";
    } else {
        $sp_template = new Template($_CONF['path'] . 'plugins/staticpages/templates/admin');
        $sp_template->set_file('form','editor.thtml');
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
        $sp_template->set_var('sp_uid', $A['sp_uid']);

		$curtime = COM_getUserDateTimeFormat();

        $sp_template->set_var('lang_lastupdated', $LANG_STATIC['date']);
        $sp_template->set_var('sp_formateddate', $curtime[0]);
        $sp_template->set_var('sp_date', $curtime[1]);
        $sp_template->set_var('lang_title', $LANG_STATIC['title']);
        $sp_template->set_var('sp_title', stripslashes($A['sp_title']));
        $sp_template->set_var('lang_addtomenu', $LANG_STATIC['addtomenu']);
        if ($A['sp_onmenu'] == 1) {
            $sp_template->set_var('onmenu_checked', 'checked="CHECKED"');
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
        $sp_template->set_var('sp_id', $A['sp_id']);
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
function staticpageeditor($sp_id, $mode = '') 
{
	global $HTTP_POST_VARS, $_USER, $_CONF, $_TABLES, $LANG50;

	if (!empty($sp_id) && $mode == 'edit') {
		$result = DB_query("SELECT *,UNIX_TIMESTAMP(sp_date) AS unixdate FROM {$_TABLES['staticpage']} WHERE sp_id = '$sp_id'");
		$A = DB_fetchArray($result);
	} elseif ($mode == 'edit') {
		$A['sp_id'] = COM_makesid();
		$A['sp_uid'] = $_USER["uid"];
		$A['unixdate'] = time();
	} else {
		$A = $HTTP_POST_VARS;
		$A['sp_content'] = COM_checkHTML(COM_checkWords($A['sp_content']));
		$A['sp_title'] = strip_tags($A['sp_title']);
	}
	return form($A);
}

###############################################################################
# Displays a list of static pages 

function liststaticpages($page = 1) 
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
    $sp_templates->set_var('lang_title', $LANG_STATIC['title']);
    $sp_templates->set_var('lang_writtenby', $LANG_STATIC['writtenby']);
    $sp_templates->set_var('lang_lastupdated', $LANG_STATIC['date']);
    $sp_templates->set_var('lang_url', $LANG_STATIC['url']);

	//if (empty($page)) $page = 1;
	//$limit = (50 * $page) - 50;
	//$result = DB_query("SELECT *,UNIX_TIMESTAMP(sp_date) AS unixdate FROM {$_TABLES['staticpage']} ORDER BY sp_date DESC LIMIT $limit,50");
	$result = DB_query("SELECT *,UNIX_TIMESTAMP(sp_date) AS unixdate FROM {$_TABLES['staticpage']} ORDER BY sp_date DESC");
	$nrows = DB_numRows($result);
	if ($nrows > 0) {
 		for ($i = 1; $i <= $nrows; $i++) {
			//$scount = (50 * $page) - 50 + $i;
			$A = DB_fetchArray($result);
            $sp_templates->set_var('sp_id', $A['sp_id']);
            $sp_templates->set_var('page_edit_url',COM_buildURL($_CONF['site_admin_url'] . '/plugins/staticpages/index.php?mode=edit&amp;sp_id=' . $A['sp_id']));
            $sp_templates->set_var('row_number', $i);
            $sp_templates->set_var('page_display_url',COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page=' . $A['sp_id']));
            $sp_templates->set_var('sp_title', $A['sp_title']);
            $sp_templates->set_var('username', DB_getItem($_TABLES['users'],'username',"uid = {$A["sp_uid"]}"));
			$curtime = COM_getUserDateTimeFormat($A['unixdate']);
            $sp_templates->set_var('sp_date', $curtime[0]);
            $sp_templates->parse('list_item', 'row', true);
		}
        $sp_templates->set_var('lang_nopages_msg', '');
        /*
		$retval .= "<tr><td colspan=6>";
		if (DB_count($_TABLES['staticpage']) > 50) {
			$prevpage = $page - 1; 
			$nextpage = $page + 1;
			$num_pages = DB_count($_TABLES['staticpage']) / 50;
			if ($page > 1) {
				$retval .= "<a href={$_CONF["site_admin_url"]}/plugins/staticpages/index.php?mode=list&page=$prevpage>{$LANG50[1]}</a>&nbsp;&nbsp";
			}
			if ($page < $num_pages) {
				$retval .= "<a href={$_CONF["site_admin_url"]}/plugins/staticpages/index.php?mode=list&page=$nextpage>{$LANG50[2]}</a> ";
			}
		}
		$retval .= "</td></tr>
        */
	} else {
        $sp_templates->set_var('lang_nopages_msg', $LANG_STATIC['nopages']);
        $sp_templates->set_var('list_item', '');
    }
	$sp_templates->set_var('end_block', COM_endBlock());	

    $retval .= $sp_templates->parse('output', 'list');

    return $retval;
}

/** 
* Saves a Static Page to the database
*
* @sp_id        string      ID of static page
* @sp_uid       string      ID of user that created page
* @sp_title     string      title of page
* @sp_content   string      page content
* @unixdate     string      date page was last updated
* @sp_hits      int         Number of page views
* @sp_format    string      HTML or plain text
*
*/
function submitstaticpage($sp_id,$sp_uid,$sp_title,$sp_content,$unixdate,$sp_hits,$sp_format, $sp_onmenu, $sp_label) 
{
	global $_CONF, $LANG12, $LANG50, $_SP_CONF, $_TABLES;

	if (!empty($sp_title) && !empty($sp_content)) {
		$date = date("Y-m-d H:i:s",$unixdate);

		if (empty($sp_hits)) $sp_hits = 0;

        if ($sp_onmenu== 'on') {
            $sp_onmenu = 1;
        } else {
            $sp_onmenu = 0;
        }

		// Clean up the text
        if ($_SP_CONF['censor'] == 1) {
            $sp_content = COM_checkWords($sp_content); 
            $sp_title = COM_checkWords($sp_title);
            $sp_label = COM_checkWords($sp_label);
        }
        if ($_SP_CONF['filter_html'] == 1) {
            $sp_content = COM_checkHTML($sp_content);
            $sp_title = COM_checkHTML($sp_title);
            $sp_label = COM_checkHTML($sp_label);
        }
        $sp_content = addslashes($sp_content);
        $sp_title = addslashes($sp_title);
        $sp_label = addslashes($sp_label);

		//$sp_content= addslashes(COM_checkHTML(COM_checkWords($sp_content)));
		//$sp_title = addslashes(htmlspecialchars(strip_tags(COM_checkWords($sp_title))));
		//$sp_label = addslashes(htmlspecialchars(strip_tags(COM_checkWords($sp_label))));

		DB_save($_TABLES['staticpage'],'sp_id,sp_uid,sp_title,sp_content,sp_date,sp_hits,sp_format,sp_onmenu,sp_label',"$sp_id,$sp_uid,'$sp_title','$sp_content','$date',$sp_hits,'$sp_format',$sp_onmenu,'$sp_label'",$_CONF['site_admin_url'] . '/plugins/staticpages/index.php');

	} else {
        $retval .= COM_siteHeader();
		$retval .= COM_errorLog($LANG50[31],2);
		$retval .= staticpageeditor($sp_id);
        $retval .= COM_siteFooter();
        return $retval;
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
} else if (($mode == $LANG_STATIC['save']) && !empty ($LANG_STATIC['save'])) {
    submitstaticpage($sp_id,$sp_uid,$sp_title,$sp_content,$unixdate,$sp_hits,$sp_format,$sp_onmenu,$sp_label);
} else {
    $display .= COM_siteHeader('menu');
    $display .= liststaticpages($sp_id);
    $display .= COM_siteFooter();
}

echo $display;

?>
