<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Links Plugin 1.0                                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog Links Plugin administration page.                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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

/**
 * Geeklog links administration page.
 *
 * @package Links
 * @subpackage admin
 * @filesource
 * @version 1.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2006
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Trinity Bays <trinity93@steubentech.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 */

// $Id: index.php,v 1.44 2007/08/09 06:48:05 ospiess Exp $

require_once ('../../../lib-common.php');
require_once ('../../auth.inc.php');

// Uncomment the lines below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);
// exit;

$display = '';

if (!SEC_hasRights ('links.edit')) {
    $display .= COM_siteHeader ('menu', $MESSAGE[30]);
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
* @param  string  $mode   Used to see if we are moderating a link or simply editing one
* @param  string  $lid    ID of link to edit
* @global array core config vars
* @global array core group data
* @global array core table data
* @global array core user data
* @global array links plugin config vars
* @global array links plugin lang vars
* @global array core lang access vars
* @return string HTML for the link editor form
*
*/
function editlink ($mode, $lid = '')
{
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $_LI_CONF,
           $LANG_LINKS_ADMIN, $LANG_ACCESS, $LANG_ADMIN, $MESSAGE;

    $retval = '';

    $link_templates = new Template($_CONF['path'] . 'plugins/links/templates/admin/');
    $link_templates->set_file('editor','linkeditor.thtml');
    $link_templates->set_var('site_url', $_CONF['site_url']);
    $link_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $link_templates->set_var('layout_url',$_CONF['layout_url']);
    if ($mode <> 'editsubmission' AND !empty($lid)) {
        $result = DB_query("SELECT * FROM {$_TABLES['links']} WHERE lid ='$lid'");
        if (DB_numRows($result) !== 1) {
            $msg = COM_startBlock ($LANG_LINKS_ADMIN[24], '',
                COM_getBlockTemplate ('_msg_block', 'header'));
            $msg .= $LANG_LINKS_ADMIN[25];
            $msg .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            return $msg;
        }
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
        } else {
            $A['lid'] = COM_makesid();
            $A['category'] = '';
            $A['url'] = '';
            $A['description'] = '';
            $A['title']= '';
            $A['owner_id'] = $_USER['uid'];
        }
        $A['hits'] = 0;
        if (isset ($_GROUPS['Links Admin'])) {
            $A['group_id'] = $_GROUPS['Links Admin'];
        } else {
            $A['group_id'] = SEC_getFeatureGroup ('links.edit');
        }
        SEC_setDefaultPermissions ($A, $_LI_CONF['default_permissions']);
        $access = 3;
    }
    $retval .= COM_startBlock ($LANG_LINKS_ADMIN[1], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $link_templates->set_var('link_id', $A['lid']);
    if (!empty($lid) && SEC_hasRights('links.edit')) {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $link_templates->set_var ('delete_option',
                                  sprintf ($delbutton, $jsconfirm));
        $link_templates->set_var ('delete_option_no_confirmation',
                                  sprintf ($delbutton, ''));
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
    $othercategory = $A['category'];
    $link_templates->set_var('category_options',
                             links_getCategoryList ($othercategory));
    $link_templates->set_var('lang_ifotherspecify', $LANG_LINKS_ADMIN[20]);
    $link_templates->set_var('category', $othercategory);
    $link_templates->set_var('lang_linkhits', $LANG_LINKS_ADMIN[8]);
    $link_templates->set_var('link_hits', $A['hits']);
    $link_templates->set_var('lang_linkdescription', $LANG_LINKS_ADMIN[9]);
    $link_templates->set_var('link_description', stripslashes($A['description']));
    $link_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $link_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);

    // user access info
    $link_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $link_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $ownername = COM_getDisplayName ($A['owner_id']);
    $link_templates->set_var('owner_username', DB_getItem($_TABLES['users'],
                             'username', "uid = {$A['owner_id']}"));
    $link_templates->set_var('owner_name', $ownername);
    $link_templates->set_var('owner', $ownername);
    $link_templates->set_var('link_ownerid', $A['owner_id']);
    $link_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $link_templates->set_var('group_dropdown',
                             SEC_getGroupDropdown ($A['group_id'], $access));
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
* @global array core config vars
* @global array core group data
* @global array core table data
* @global array core user data
* @global array core msg data
* @global array links plugin lang admin vars
*
*/
function savelink ($lid, $old_lid, $category, $categorydd, $url, $description, $title, $hits, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon)
{
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $MESSAGE, $LANG_LINKS_ADMIN, $_LI_CONF;

    $retval = '';

    // Convert array values to numeric permission values
    if (is_array($perm_owner) OR is_array($perm_group) OR is_array($perm_members) OR is_array($perm_anon)) {
        list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
    }

    // clean 'em up
    $description = addslashes (COM_checkHTML (COM_checkWords ($description)));
    $title = addslashes (COM_checkHTML (COM_checkWords ($title)));
    $category = addslashes ($category);

    if (empty ($owner_id)) {
        // this is new link from admin, set default values
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

    $lid = COM_sanitizeID ($lid);
    if (empty ($lid)) {
        if (empty ($old_lid)) {
            $lid = COM_makeSid ();
        } else {
            $lid = $old_lid;
        }
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
        $display .= COM_siteHeader ('menu', $MESSAGE[30]);
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
        COM_rdfUpToDateCheck ('links', $category, $lid);

        // return COM_refresh ($_CONF['site_admin_url'] . '/plugins/links/index.php?msg=2');
        return PLG_afterSaveSwitch (
            $_LI_CONF['aftersave'],
            COM_buildURL ("{$_CONF['site_url']}/links/portal.php?what=link&item=$lid"),
            'links',
            2
        );
    } else { // missing fields
        $retval .= COM_siteHeader('menu', $LANG_LINKS_ADMIN[1]);
        $retval .= COM_errorLog($LANG_LINKS_ADMIN[10],2);
        if (DB_count ($_TABLES['links'], 'lid', $old_lid) > 0) {
            $retval .= editlink ('edit', $old_lid);
        } else {
            $retval .= editlink ('edit', '');
        }
        $retval .= COM_siteFooter();

        return $retval;
    }
}

/**
 * List links
 * @global array core config vars
 * @global array core table data
 * @global array core user data
 * @global array core lang admin vars
 * @global array links plugin lang vars
 * @global array core lang access vars
 */
function listlinks ()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG_LINKS_ADMIN, $LANG_ACCESS, $_IMAGE_TYPE;
    require_once( $_CONF['path_system'] . 'lib-admin.php' );
    $retval = '';

    $header_arr = array(      # display 'text' and use table field 'field'
                    array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
                    array('text' => $LANG_LINKS_ADMIN[2], 'field' => 'lid', 'sort' => true),
                    array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
                    array('text' => $LANG_ACCESS['access'], 'field' => 'access', 'sort' => false),
                    array('text' => $LANG_LINKS_ADMIN[14], 'field' => 'category', 'sort' => true));

    $validate = '';
    if (isset($_GET['checkhtml'])) {
        $header_arr[] = array('text' => $LANG_LINKS_ADMIN[27], 'field' => 'htmlcode', 'sort' => false);
        $validate = '?checkhtml=true';
    }

    $defsort_arr = array('field' => 'title', 'direction' => 'asc');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'] . '/plugins/links/index.php?mode=edit',
                          'text' => $LANG_ADMIN['create_new']),
                    array('url' => $_CONF['site_admin_url'] . '/plugins/links/index.php?checkhtml=true',
                          'text' => $LANG_LINKS_ADMIN[26]),
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home']));

    $text_arr = array('has_menu' =>  true,
                      'has_extras'   => true,
                      'title' => $LANG_LINKS_ADMIN[11], 'instructions' => $LANG_LINKS_ADMIN[12],
                      'icon' => plugin_geticon_links(),
                      'form_url' => $_CONF['site_admin_url'] . "/plugins/links/index.php$validate");

    $query_arr = array('table' => 'links',
                       'sql' => "SELECT * FROM {$_TABLES['links']} WHERE 1=1",
                       'query_fields' => array('title', 'category', 'url', 'description'),
                       'default_filter' => COM_getPermSql ('AND'));

    $retval .= ADMIN_list ("links", "plugin_getListField_links", $header_arr, $text_arr,
                            $query_arr, $menu_arr, $defsort_arr);

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

    return COM_refresh ($_CONF['site_admin_url']
                        . '/plugins/links/index.php?msg=3');
}

// MAIN
$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

if (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) {
    $lid = COM_applyFilter ($_POST['lid']);
    if (!isset ($lid) || empty ($lid)) {  // || ($lid == 0)
        COM_errorLog ('Attempted to delete link lid=' . $lid );
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/plugins/links/index.php');
    } else {
        $display .= deleteLink ($lid);
    }
} else if (($mode == $LANG_ADMIN['save']) && !empty ($LANG_ADMIN['save'])) {
    $display .= savelink (COM_applyFilter ($_POST['lid']),
            COM_applyFilter ($_POST['old_lid']),
            $_POST['category'], $_POST['categorydd'],
            $_POST['url'], $_POST['description'], $_POST['title'],
            COM_applyFilter ($_POST['hits'], true),
            COM_applyFilter ($_POST['owner_id'], true),
            COM_applyFilter ($_POST['group_id'], true),
            $_POST['perm_owner'], $_POST['perm_group'],
            $_POST['perm_members'], $_POST['perm_anon']);
} else if ($mode == 'editsubmission') {
    $display .= COM_siteHeader ('menu', $LANG_LINKS_ADMIN[1]);
    $display .= editlink ($mode, COM_applyFilter ($_GET['id']));
    $display .= COM_siteFooter ();
} else if ($mode == 'edit') {
    $display .= COM_siteHeader ('menu', $LANG_LINKS_ADMIN[1]);
    if (empty ($_GET['lid'])) {
        $display .= editlink ($mode);
    } else {
        $display .= editlink ($mode, COM_applyFilter ($_GET['lid']));
    }
    $display .= COM_siteFooter ();
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader ('menu', $LANG_LINKS_ADMIN[11]);
    if (isset ($_REQUEST['msg'])) {
        $msg = COM_applyFilter ($_REQUEST['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage ($msg, 'links');
        }
    }
    $display .= listlinks();
    $display .= COM_siteFooter ();
}

echo $display;

?>
