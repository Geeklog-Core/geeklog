<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | link.php                                                                  |
// | Geeklog links administration page.                                        |
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
// $Id: link.php,v 1.10 2001/12/06 21:52:03 tony_bibbs Exp $

include('../lib-common.php');
include('auth.inc.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

$display = '';

if (!SEC_hasRights('link.edit')) {
    $display .= COM_siteHeader('menu');
    $display .= COM_startBlock($MESSAGE[30]);
    $display .= $MESSAGE[34];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
	$display .= COM_errorLog("User {$_USER['username']} tried to illegally access the link administration screen",1);
    echo $display;
    exit;
}

/**
* Shows the link editor
*
* $mode     string      Used to see if we are moderating a link or simply editing one 
* $lid      string      ID of link to edit
*
*/
function editlink($mode, $lid = '') 
{
	global $_TABLES, $LANG23, $_CONF, $_USER, $LANG_ACCESS;

    $retval = '';

	$retval .= COM_startBlock($LANG23[1]);

    $link_templates = new Template($_CONF['path_layout'] . 'admin/link');
    $link_templates->set_file('editor','linkeditor.thtml');
    $link_templates->set_var('site_url', $_CONF['site_url']);
	if ($mode <> 'editsubmission' AND !empty($lid)) {
		$result = DB_query("SELECT * FROM {$_TABLES['links']} WHERE lid ='$lid'");
		$A = DB_fetchArray($result);
		$access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access == 0 OR $access == 2) {
            $retval .= COM_startBlock($LANG24[16]);
            $retval .= $LANG23[17];
            $retval .= COM_endBlock();
            return;
        }
	} else {
		if ($mode == 'editsubmission') {
			$result = DB_query ("SELECT * FROM {$_TABLES['linksubmission']}linksubmission WHERE lid = '$lid'");
			$A = DB_fetchArray($result);
		}
		$A['hits'] = 0;
		$A['owner_id'] = $_USER['uid'];
		$A['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Link Admin'");
		$A['perm_owner'] = 3;
        $A['perm_group'] = 3;
        $A['perm_members'] = 2;
        $A['perm_anon'] = 2;
		$access = 3;
	}
    $link_templates->set_var('link_id', $A['lid']);
	if (!empty($lid) && SEC_hasRights('link.edit')) {
		$link_templates->set_var('delete_option','<input type="submit" value="delete" name="mode">');
    }
    $link_templates->set_var('lang_linktitle', $LANG23[3]);
    $link_templates->set_var('link_title', $A['title']);
    $link_templates->set_var('lang_linkurl', $LANG23[4]);
    $link_templates->set_var('link_url', $A['url']);
    $link_templates->set_var('lang_category', $LANG23[5]);
    $result	= DB_query("SELECT DISTINCT category FROM {$_TABLES['links']}");
    $nrows	= DB_numRows($result);
    $catdd = '<option value="' . $LANG23[7] . '">' . $LANG23[7] . '</option>';
	if ($nrows > 0) {
		for ($i = 1; $i <= $nrows; $i++) {
            $C = DB_fetchArray($result);
            $category = $C['category'];
			$catdd .= '<option value="' . $category . '"';
			if ($A["category"] == $category) {
                $catdd .= ' selected="selected"'; 
            }
			$catdd .= '>' . $category . '</option>';
		}
	}
    $link_templates->set_var('category_options', $catdd); 
    $link_templates->set_var('lang_ifotherspecify', $LANG23[20]);
    $link_templates->set_var('lang_linkhits', $LANG23[8]); 
    $link_templates->set_var('link_hits', $A['hits']);
    $link_templates->set_var('lang_linkdescription', $LANG23[9]);
    $link_templates->set_var('link_description', $A['description']);

	// user access info
    $link_templates->set_var('lang_accessrights', $LANG_ACCESS[accessrights]);
    $link_templates->set_var('lang_owner', $LANG_ACCESS[owner]);
    $link_templates->set_var('owner_username', DB_getItem($_TABLES['users'],'username',"uid = {$A['owner_id']}")); 
    $link_templates->set_var('link_ownerid', $A['owner_id']);
    $link_templates->set_var('lang_group', $LANG_ACCESS[group]);

    $usergroups = SEC_getUserGroups();
    if ($access == 3) {
        $groupdd = '<select name="group_id">' . LB;
        for ($i = 0; $i < count($usergroups); $i++) {
            $groupdd .= '<option value="' . $usergroups[key($usergroups)] . '"';
            if ($A['group_id'] == $usergroups[key($usergroups)]) {
               $groupdd .= ' selected="selected"';
            }
            $groupdd.= '>' . key($usergroups) . '</option>' . LB;
            next($usergroups);
        }
        $groupdd .= '</select>' . LB;
	} else {
		// they can't set the group then
        $groupdd .= DB_getItem($_TABLES['groups'],'grp_name',"grp_id = {$A['group_id']}");
		$groupdd .= '<input type="hidden" name="group_id" value="' . $A['group_id'] . '">';
	}
    $link_templates->set_var('group_dropdown', $groupdd);
    $link_templates->set_var('lang_permissions', $LANG_ACCESS[permissions]);
    $link_templates->set_var('lang_permissionskey', $LANG_ACCESS[permissionskey]);
    $link_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $link_templates->set_var('lang_lockmsg', $LANG_ACCESS[lockmsg]);
    $link_templates->parse('output', 'editor');
    $retval .= $link_templates->finish($link_templates->get_var('output'));

	$retval .= COM_endBlock();

    return $retval;
}

###############################################################################
# Svaes the links to the database
/**
* Saves link to the database
*
* $lid          string          ID for link
* $category     string          Category link belongs to
* $categorydd   string          Category links belong to
* $url          string          URL of link to save
* $description  string          Description of link
* $title        string          Title of link
* $hits         int             Number of hits for link
* $owner_id     string          ID of owner
* $group_id     string          ID of group link belongs to
* $perm_owner   string          Permissions the owner has
* $perm_group   string          Permissions the group has
* $perm_members string          Permissions members have
* $perm_anon    string          Permissions anonymous users have
*
*/
function savelink($lid,$category,$categorydd,$url,$description,$title,$hits,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) 
{
	global $_TABLES, $_CONF, $LANG23, $_USER; 
    

	// clean 'em up 
	$description = addslashes(COM_checkHTML(COM_checkWords($description)));
	$title = addslashes(COM_checkHTML(COM_checkWords($title)));

	if (!empty($title) && !empty($description) && !empty($url)) {
		if (!empty($lid)) {
			DB_delete($_TABLES['linksubmission'],'lid',$lid);
			DB_delete($_TABLES['links'],'lid',$lid);
		} else {
			// this is a submission, set default values
			$lid = COM_makesid();
			$owner_id = $_USER['uid'];
			$group_id = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Link Admin'");
            $perm_owner = 3;
            $perm_group = 3;
            $perm_members = 2;
            $perm_anon = 2;		
		}

		if ($categorydd != $LANG23[7] && !empty($categorydd)) {
			$category = $categorydd;
		} else if ($categorydd != $LANG23[7]) {
			echo COM_refresh($_CONF['site_url'] . '/admin/link.php');
		}

		// Convert array values to numeric permission values
        list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
		DB_save($_TABLES['links'],'lid,category,url,description,title,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',"$lid,'$category','$url','$description','$title','$hits',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon",'admin/link.php?msg=15');
	} else {
		$retval .= COM_siteHeader('menu');
		$retval .= COM_errorLog($LANG23[10],2);
        print "title = $title, url = $url, descr = $description \n";
		editlink($mode,$lid);
		$retval .= COM_siteFooter();
        return $retval;
	}
}

/**
* Lists all the links in the database
*
*/
function listlinks() 
{
	global $_TABLES, $LANG23, $LANG_ACCESS, $_CONF;

    $retavl .= '';

	$retval .= COM_startBlock($LANG23[11]);

    $link_templates = new Template($_CONF['path_layout'] . 'admin/link');
    $link_templates->set_file(array('list'=>'linklist.thtml', 'row'=>'listitem.thtml'));
    $link_templates->set_var('site_url', $_CONF['site_url']);
    $link_templates->set_var('lang_newlink', $LANG23[18]);
    $link_templates->set_var('lang_adminhome', $LANG23[19]);
    $link_templates->set_var('lang_instructions', $LANG23[12]);
    $link_templates->set_var('lang_linktitle', $LANG23[13]);
    $link_templates->set_var('lang_access', $LANG_ACCESS[access]);
    $link_templates->set_var('lang_linkcategory', $LANG23[14]);
    $link_templates->set_var('lang_linkurl', $LANG23[15]); 

	$result = DB_query("SELECT * FROM {$_TABLES['links']} ORDER BY category ASC,title");
	$nrows = DB_numRows($result);
	for ($i = 0; $i < $nrows; $i++) {
		$A = DB_fetchArray($result);
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
        $link_templates->set_var('link_id', $A['lid']);
        $link_templates->set_var('link_name', $A['title']);
        $link_templates->set_var('link_access', $access);
        $link_templates->set_var('link_category', $A['category']);
        $link_templates->set_var('link_url', $A['url']);
        $link_templates->parse('link_row', 'row', true);
	}
    $link_templates->parse('output','list');
    $retval .= $link_templates->finish($link_templates->get_var('output'));

	$retval .= COM_endBlock();

    return $retval;
}

// MAIN

switch ($mode) {
	case 'delete':
		DB_delete($_TABLES['links'],'lid',$lid,'admin/link.php?msg=16');
		break;
	case 'save':
		$display .= savelink($lid,$category,$categorydd,$url,$description,$title,$hits,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
		break;
	case 'editsubmission':
		$display .= COM_siteHeader('menu');
		$display .= editlink($mode,$id);
		$display .= COM_siteFooter();
		break;
	case 'edit':
		$display .= COM_siteHeader('menu');
		$display .= editlink($mode,$lid);
		$display .= COM_siteFooter();
		break;
	case 'cancel':
	default:
		$display .= COM_siteHeader('menu');
		$display .= COM_showMessage($msg);
		$display .= listlinks();
		$display .= COM_siteFooter();
		break;
}

echo $display;

?>
