<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | /admin/plugins/links/index.php                                            |
// |                                                                           |
// | Geeklog links administration page.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: index.php,v 1.9 2005/08/09 11:04:08 ospiess Exp $

require_once ('../../../lib-common.php');
require_once ('../../auth.inc.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

// number of links to list per page
define ('LINKS_PER_PAGE', 50);

$display = '';

if (!SEC_hasRights ('links.edit')) {
    $display .= COM_siteHeader ('menu');
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[34];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    COM_accessLog ("User {$_USER['username']} tried to illegally access the links administration screen.");
    echo $display;
    exit;
}

/**
* Shows the links editor
*
* @param    string  $mode   Used to see if we are moderating a link or simply editing one 
* @param    string  $lid    ID of link to edit
* @return   string          HTML for the link editor form
*
*/
function editlink ($mode, $lid = '') 
{
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $LANG_LINKS_ADMIN, $LANG_ACCESS;

    $retval = '';

    $link_templates = new Template($_CONF['path'] . 'plugins/links/templates/admin/');
    $link_templates->set_file('editor','linkeditor.thtml');
    $link_templates->set_var('site_url', $_CONF['site_url']);
    $link_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $link_templates->set_var('layout_url',$_CONF['layout_url']);
    if ($mode <> 'editsubmission' AND !empty($lid)) {
        $result = DB_query("SELECT * FROM {$_TABLES['links']} WHERE lid ='$lid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access == 0 OR $access == 2) {
            $retval .= COM_startBlock($LANG_LINKS_ADMIN[16], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
            $retval .= $LANG_LINKS_ADMIN[17];
            $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            COM_accessLog("User {$_USER['username']} tried to illegally submit or edit link $lid.");
            return $retval;
        }
    } else {
        if ($mode == 'editsubmission') {
            $result = DB_query ("SELECT * FROM {$_TABLES['linksubmission']} WHERE lid = '$lid'");
            $A = DB_fetchArray($result);
        }
        $A['hits'] = 0;
        $A['lid'] = COM_makesid();
        $A['owner_id'] = $_USER['uid'];
        if (isset ($_GROUPS['Links Admin'])) {
            $A['group_id'] = $_GROUPS['Links Admin'];
        } else {
            $A['group_id'] = SEC_getFeatureGroup ('links.edit');
        }
        $A['perm_owner'] = 3;
        $A['perm_group'] = 2;
        $A['perm_members'] = 2;
        $A['perm_anon'] = 2;
        $access = 3;
    }
    $retval .= COM_startBlock ($LANG_LINKS_ADMIN[1], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $link_templates->set_var('link_id', $A['lid']);
    if (!empty($lid) && SEC_hasRights('links.edit')) {
        $link_templates->set_var ('delete_option', '<input type="submit" value="' . $LANG_LINKS_ADMIN[23] . '" name="mode">');
    }
    $link_templates->set_var('lang_linktitle', $LANG_LINKS_ADMIN[3]);
    $link_templates->set_var('link_title',
                             htmlspecialchars (stripslashes ($A['title'])));
    $link_templates->set_var('lang_linkid', $LANG_LINKS_ADMIN[2]);
    $link_templates->set_var('lang_linkurl', $LANG_LINKS_ADMIN[4]);
    $link_templates->set_var('max_url_length', 255);
    $link_templates->set_var('link_url', $A['url']);
    $link_templates->set_var('lang_includehttp', $LANG_LINKS_ADMIN[6]);
    $link_templates->set_var('lang_category', $LANG_LINKS_ADMIN[5]);
    $result    = DB_query("SELECT DISTINCT category FROM {$_TABLES['links']} GROUP BY category");
    $nrows    = DB_numRows($result);

    $catdd = '<option value="' . $LANG_LINKS_ADMIN[7] . '">' . $LANG_LINKS_ADMIN[7] . '</option>';
    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $C = DB_fetchArray($result);
            $category = $C['category'];
            $catdd .= '<option value="' . $category . '"';
            if ($A['category'] == $category) {
                $catdd .= ' selected="selected"'; 
            }
            $catdd .= '>' . $category . '</option>';
        }
    }
    $link_templates->set_var('category_options', $catdd); 
    $link_templates->set_var('lang_ifotherspecify', $LANG_LINKS_ADMIN[20]);
    $link_templates->set_var('lang_linkhits', $LANG_LINKS_ADMIN[8]);
    $link_templates->set_var('link_hits', $A['hits']);
    $link_templates->set_var('lang_linkdescription', $LANG_LINKS_ADMIN[9]);
    $link_templates->set_var('link_description', stripslashes($A['description']));
    $link_templates->set_var('lang_save', $LANG_LINKS_ADMIN[21]);
    $link_templates->set_var('lang_cancel', $LANG_LINKS_ADMIN[22]);

    // user access info
    $link_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $link_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $link_templates->set_var('owner_username', DB_getItem($_TABLES['users'],'username',"uid = {$A['owner_id']}")); 
    $link_templates->set_var('link_ownerid', $A['owner_id']);
    $link_templates->set_var('lang_group', $LANG_ACCESS['group']);

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
    $link_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $link_templates->set_var('lang_permissionskey', $LANG_ACCESS['permissionskey']);
    $link_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $link_templates->set_var('lang_lockmsg', $LANG_ACCESS['permmsg']);
    $link_templates->parse('output', 'editor');
    $retval .= $link_templates->finish($link_templates->get_var('output'));

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Saves link to the database
*
* @param    string  $lid            ID for link
* @param    string  $old_lid        old ID for link
* @param    string  $category       Category link belongs to
* @param    string  $categorydd     Category links belong to
* @param    string  $url            URL of link to save
* @param    string  $description    Description of link
* @param    string  $title          Title of link
* @param    int     $hits           Number of hits for link
* @param    int     $owner_id       ID of owner
* @param    int     $group_id       ID of group link belongs to
* @param    int     $perm_owner     Permissions the owner has
* @param    int     $perm_group     Permissions the group has
* @param    int     $perm_members   Permissions members have
* @param    int     $perm_anon      Permissions anonymous users have
* @return   string                  HTML redirect or error message
*
*/
function savelink ($lid, $old_lid, $category, $categorydd, $url, $description, $title, $hits, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon)
{
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $MESSAGE, $LANG_LINKS_ADMIN;

    // Convert array values to numeric permission values
    if (is_array($perm_owner) OR is_array($perm_group) OR is_array($perm_members) OR is_array($perm_anon)) {
        list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
    }

    // clean 'em up 
    $description = addslashes (COM_checkHTML (COM_checkWords ($description)));
    $title = addslashes (COM_checkHTML (COM_checkWords ($title)));
    $category = addslashes ($category);

    if (empty ($owner_id)) {
        // this is new link form admin, set default values
        $owner_id = $_USER['uid'];
        if (isset ($_GROUPS['Links Admin'])) {
            $group_id = $_GROUPS['Links Admin'];
        } else {
            $group_id = SEC_getFeatureGroup ('links.edit');
        }
        $perm_owner = 3;
        $perm_group = 2;
        $perm_members = 2;
        $perm_anon = 2;
    }

    $access = 0;
    $old_lid = addslashes ($old_lid);
    if (DB_count ($_TABLES['links'], 'lid', $old_lid) > 0) {
        $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']} WHERE lid = '{$old_lid}'");
        $A = DB_fetchArray ($result);
        $access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
                $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                $A['perm_anon']);
    } else {
        $access = SEC_hasAccess ($owner_id, $group_id, $perm_owner, $perm_group,
                $perm_members, $perm_anon);
    }
    if (($access < 3) || !SEC_inGroup ($group_id)) {
        $display .= COM_siteHeader ('menu');
        $display .= COM_startBlock ($MESSAGE[30], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $MESSAGE[31];
        $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= COM_siteFooter ();
        COM_accessLog("User {$_USER['username']} tried to illegally submit or edit link $lid.");
        echo $display;
        exit;
    } elseif (!empty($title) && !empty($description) && !empty($url)) {

        if ($categorydd != $LANG_LINKS_ADMIN[7] && !empty($categorydd)) {
            $category = addslashes ($categorydd);
        } else if ($categorydd != $LANG_LINKS_ADMIN[7]) {
            echo COM_refresh($_CONF['site_admin_url'] . '/plugins/links/index.php');
        }

        DB_delete ($_TABLES['linksubmission'], 'lid', $old_lid);
        DB_delete ($_TABLES['links'], 'lid', $old_lid);

        DB_save ($_TABLES['links'], 'lid,category,url,description,title,date,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon', "'$lid','$category','$url','$description','$title',NOW(),'$hits',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon");
        COM_rdfUpToDateCheck ();

        return COM_refresh ($_CONF['site_admin_url'] . '/plugins/links/index.php?msg=3');
    } else { // missing fields
        $retval .= COM_siteHeader('menu');
        $retval .= COM_errorLog($LANG_LINKS_ADMIN[10],2);
        if (DB_count ($_TABLES['links'], 'lid', $old_lid) > 0) {
            $retval .= editlink ($mode, $old_lid);
        } else {
            $retval .= editlink ($mode, '');
        }
        $retval .= COM_siteFooter();
        return $retval;
    }
}

/**
* Lists all the links in the database
*
* @param    int     $page   page number to display
* @return   string          HTML for list of links
*
*/
function listlinks ($offset, $curpage, $query = '', $query_limit = 50)
{
    global $_CONF, $_TABLES, $LANG_LINKS_ADMIN, $LANG_ACCESS, $_IMAGE_TYPE,
           $order, $prevorder, $direction;

    $retval = '';

    if ($page <= 0) {
        $page = 1;
    }

    $retval .= COM_startBlock ($LANG23[11], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $link_templates = new Template($_CONF['path'] . 'plugins/links/templates/admin/');
    $link_templates->set_file(array('list'=>'linklist.thtml', 'row'=>'listitem.thtml'));
    $link_templates->set_var('site_url', $_CONF['site_url']);
    $link_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $link_templates->set_var('layout_url', $_CONF['layout_url']);
    $link_templates->set_var('lang_newlink', $LANG_LINKS_ADMIN[18]);
    $link_templates->set_var('lang_adminhome', $LANG_LINKS_ADMIN[19]);
    $link_templates->set_var('lang_instructions', $LANG_LINKS_ADMIN[12]);
    $link_templates->set_var('lang_linktitle', $LANG_LINKS_ADMIN[13]);
    $link_templates->set_var('lang_access', $LANG_ACCESS['access']);
    $link_templates->set_var('lang_linkcategory', $LANG_LINKS_ADMIN[14]);
    $link_templates->set_var('lang_linkurl', $LANG_LINKS_ADMIN[15]);
    $link_templates->set_var('lang_edit', $LANG_LINKS_ADMIN[24]);
    $link_templates->set_var('lang_lid', $LANG_LINKS_ADMIN[2]);
    $link_templates->set_var('lang_submit', $LANG_LINKS_ADMIN[26]);
    $link_templates->set_var('lang_search', $LANG_LINKS_ADMIN[27]);
    $link_templates->set_var('lang_limit_results', $LANG_LINKS_ADMIN[25]);
    $link_templates->set_var('last_query', $query);
    $editico = '<img src="' . $_CONF['layout_url'] . '/images/edit.'
             . $_IMAGE_TYPE . '">';
    $link_templates->set_var('edit_icon', $editico);
    
    switch($order) {
        case 1:
            $orderby = 'lid';
            break;
        case 2:
            $orderby = 'title';
            break;
        case 3:
            $orderby = 'category';
            break;
        case 4:
            $orderby = 'url';
            break;
        default:
            $orderby = 'title';
            $order = 2;
            break;
    }
    if ($order == $prevorder) {
        $direction = ($direction == 'desc') ? 'asc' : 'desc';
    } else {
        $direction = ($direction == 'desc') ? 'desc' : 'asc';
    }

    if ($direction == 'asc') {
        $arrow = 'bararrowdown';
    } else {
        $arrow = 'bararrowup';
    }
    $link_templates->set_var ('img_arrow' . $order,
        '&nbsp;<img src="' . $_CONF['layout_url'] . '/images/' . $arrow . '.'
        . $_IMAGE_TYPE . '" border="0" alt="">');

    $link_templates->set_var ('direction', $direction);
    $link_templates->set_var ('page', $page);
    $link_templates->set_var ('prevorder', $order);
    if (empty($query_limit)) {
        $limit = 50;
    } else {
        $limit = $query_limit;
    }
    if (!empty ($query)) {
        $link_templates->set_var ('query', urlencode($query) );
    } else {
        $link_templates->set_var ('query', '');
    }
    $link_templates->set_var ('query_limit', $query_limit);
    $link_templates->set_var($limit . '_selected', 'selected="selected"');

    if (!empty ($query)) {
        $query = addslashes (str_replace ('*', '%', $query));
        $num_pages = ceil (DB_getItem ($_TABLES['links'], 'COUNT(*)',
                "(title LIKE '$query' OR category LIKE '$query' OR url LIKE '$query')" . COM_getPermSql ('AND')) / $limit);
    } else {
        $num_pages = ceil (DB_getItem ($_TABLES['links'], 'COUNT(*)', COM_getPermSql ('')) / $limit);
    }
    if ($num_pages < $curpage) {
        $curpage = 1;
    }

    $offset = (($curpage - 1) * $limit);

    $sql = "SELECT * FROM {$_TABLES['links']}";
    if (empty ($query)) {
        $sql .= COM_getPermSql ();
    } else {
         $sql .= " WHERE (title LIKE '$query' OR category LIKE '$query' OR url LIKE '$query')" . COM_getPermSql ('AND');
    }
    $sql.= " ORDER BY $orderby $direction LIMIT $offset,$limit";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access > 0) {
            if ($access == 3) {
               $access = $LANG_ACCESS['edit'];
            } else {
               $access = $LANG_ACCESS['readonly'];
            }
            $link_templates->set_var('cssid', ($i%2)+1);
            $link_templates->set_var('link_id', $A['lid']);
            $link_templates->set_var('link_name', stripslashes($A['title']));
            $link_templates->set_var('link_access', $access);
            $link_templates->set_var('link_category', $A['category']);
            $link_templates->set_var('link_url', $A['url']);
            $link_templates->parse('link_row', 'row', true);
        }
    }
    if (!empty ($query)) {
        $base_url = $_CONF['site_admin_url'] . '/plugins/links/index.php?q=' . urlencode($query) . "&amp;query_limit={$query_limit}&amp;order={$order}&amp;direction={$prevdirection}";
    } else {
        $base_url = $_CONF['site_admin_url'] . "/plugins/links/index.php?query_limit={$query_limit}&amp;order={$order}&amp;direction={$prevdirection}";
    }

    if ($num_pages > 1) {
        $link_templates->set_var ('google_paging',
                COM_printPageNavigation ($base_url, $curpage, $num_pages));
    } else {
        $link_templates->set_var ('google_paging', '');
    }

    $link_templates->parse('output','list');
    $retval .= $link_templates->finish($link_templates->get_var('output'));

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Delete a link
*
* @param    string  $lid    id of link to delete
* @return   string          HTML redirect
*
*/
function deleteLink ($lid)
{
    global $_CONF, $_TABLES, $_USER;

    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']} WHERE lid ='$lid'");
    $A = DB_fetchArray ($result);
    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
            $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    if ($access < 3) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete link $lid.");
        return COM_refresh ($_CONF['site_admin_url'] . '/plugins/links/index.php');
    }

    DB_delete ($_TABLES['links'], 'lid', $lid);

    return COM_refresh ($_CONF['site_admin_url'] . '/plugins/links/index.php?msg=3');
}

// MAIN
if (isset ($_REQUES['mode'])) {
    $mode = $_REQUES['mode'];
}

if (($mode == $LANG_LINKS_ADMIN[23]) && !empty ($LANG_LINKS_ADMIN[23])) { // delete
    $lid = COM_applyFilter ($_POST['lid']);
    if (!isset ($lid) || empty ($lid)) {  // || ($lid == 0)
        COM_errorLog ('Attempted to delete link lid=' . $lid );
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/plugins/links/index.php');
    } else {
        $display .= deleteLink ($lid);
    }
} else if (($mode == $LANG_LINKS_ADMIN[21]) && !empty ($LANG_LINKS_ADMIN[21])) { // save
    $display .= savelink (COM_applyFilter ($_POST['lid']),
            COM_applyFilter ($_POST['old_lid']),
            $_POST['category'], $_POST['categorydd'],
            $_POST['url'], $_POST['description'], $_POST['title'],
            COM_applyFilter ($_POST['hits'], true),
            $_POST['owner_id'], $_POST['group_id'],
            $_POST['perm_owner'], $_POST['perm_group'],
            $_POST['perm_members'], $_POST['perm_anon']);
} else if ($mode == 'editsubmission') {
    $display .= COM_siteHeader ('menu');
    $display .= editlink ($mode, COM_applyFilter ($_GET['id']));
    $display .= COM_siteFooter ();
} else if ($mode == 'edit') {
    $display .= COM_siteHeader ('menu');
    $display .= editlink ($mode, COM_applyFilter ($_GET['lid']));
    $display .= COM_siteFooter ();
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader ('menu');
    if (isset ($_REQUEST['msg'])) {
        $msg = COM_applyFilter ($_REQUEST['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage ($msg, 'links');
        }
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
    $display .= listlinks ($offset, $page, $_REQUEST['q'],
                           COM_applyFilter ($_REQUEST['query_limit'], true));
    $display .= COM_siteFooter ();
}

echo $display;

?>
