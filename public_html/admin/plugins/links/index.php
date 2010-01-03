<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Links Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog Links Plugin administration page.                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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

/**
 * Geeklog links administration page.
 *
 * @package Links
 * @subpackage admin
 * @filesource
 * @version 2.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2007
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Trinity Bays <trinity93@gmail.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 */

/** 
* Geeklog common function library and Admin authentication
*/
require_once '../../../lib-common.php';
require_once '../../auth.inc.php';

// Uncomment the lines below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);
// exit;

$display = '';

if (!SEC_hasRights('links.edit')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the links administration screen.");
    COM_output($display);
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
    $link_templates->set_var( 'xhtml', XHTML );
    $link_templates->set_var('site_url', $_CONF['site_url']);
    $link_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $link_templates->set_var('layout_url',$_CONF['layout_url']);

    $link_templates->set_var('lang_pagetitle', $LANG_LINKS_ADMIN[28]);
    $link_templates->set_var('lang_link_list', $LANG_LINKS_ADMIN[53]);
    $link_templates->set_var('lang_new_link', $LANG_LINKS_ADMIN[51]);
    $link_templates->set_var('lang_validate_links', $LANG_LINKS_ADMIN[26]);
    $link_templates->set_var('lang_list_categories', $LANG_LINKS_ADMIN[50]);
    $link_templates->set_var('lang_new_category', $LANG_LINKS_ADMIN[52]);
    $link_templates->set_var('lang_admin_home', $LANG_ADMIN['admin_home']);
    $link_templates->set_var('instructions', $LANG_LINKS_ADMIN[29]);

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
            $A['cid'] = '';
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

    $token = SEC_createToken();

    $retval .= COM_startBlock($LANG_LINKS_ADMIN[1], '',
                              COM_getBlockTemplate('_admin_block', 'header'));
    $retval .= SEC_getTokenExpiryNotice($token);

    $link_templates->set_var('link_id', $A['lid']);
    if (!empty($lid) && SEC_hasRights('links.edit')) {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s' . XHTML . '>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $link_templates->set_var ('delete_option',
                                  sprintf ($delbutton, $jsconfirm));
        $link_templates->set_var ('delete_option_no_confirmation',
                                  sprintf ($delbutton, ''));
        if ($mode == 'editsubmission') {
            $link_templates->set_var('submission_option',
                '<input type="hidden" name="type" value="submission"'
                . XHTML . '>');
        }
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
    $othercategory = links_select_box (3,$A['cid']);
    $link_templates->set_var('category_options', $othercategory);
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
    $link_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $link_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $link_templates->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);
    $link_templates->set_var('lang_lockmsg', $LANG_ACCESS['permmsg']);
    $link_templates->set_var('gltoken_name', CSRF_TOKEN);
    $link_templates->set_var('gltoken', $token);
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
* @param    string  $cid            cid of category link belongs to
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
function savelink ($lid, $old_lid, $cid, $categorydd, $url, $description, $title, $hits, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon)
{
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $MESSAGE, $LANG_LINKS_ADMIN, $_LI_CONF;

    $retval = '';

    // Convert array values to numeric permission values
    if (is_array($perm_owner) OR is_array($perm_group) OR is_array($perm_members) OR is_array($perm_anon)) {
        list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
    }

    // clean 'em up
    $description = addslashes(COM_checkHTML(COM_checkWords($description),
                              'links.edit'));
    $title = addslashes(strip_tags(COM_checkWords($title)));
    $cid = addslashes($cid);

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

    $lid = COM_sanitizeID($lid);
    $old_lid = COM_sanitizeID($old_lid);
    if (empty($lid)) {
        if (empty($old_lid)) {
            $lid = COM_makeSid();
        } else {
            $lid = $old_lid;
        }
    }

    // check for link id change
    if (!empty($old_lid) && ($lid != $old_lid)) {
        // check if new lid is already in use
        if (DB_count($_TABLES['links'], 'lid', $lid) > 0) {
            // TBD: abort, display editor with all content intact again
            $lid = $old_lid; // for now ...
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
    if (($access < 3) || !SEC_inGroup($group_id)) {
        $display .= COM_siteHeader('menu', $MESSAGE[30])
                 . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
                 . COM_siteFooter();
        COM_accessLog("User {$_USER['username']} tried to illegally submit or edit link $lid.");
        COM_output($display);
        exit;
    } elseif (!empty($title) && !empty($description) && !empty($url)) {

        if ($categorydd != $LANG_LINKS_ADMIN[7] && !empty($categorydd)) {
            $cid = addslashes ($categorydd);
        } else if ($categorydd != $LANG_LINKS_ADMIN[7]) {
            echo COM_refresh($_CONF['site_admin_url'] . '/plugins/links/index.php');
        }

        DB_delete ($_TABLES['linksubmission'], 'lid', $old_lid);
        DB_delete ($_TABLES['links'], 'lid', $old_lid);

        DB_save ($_TABLES['links'], 'lid,cid,url,description,title,date,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon', "'$lid','$cid','$url','$description','$title',NOW(),'$hits',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon");

        if (empty($old_lid) || ($old_lid == $lid)) {
            PLG_itemSaved($lid, 'links');
        } else {
            PLG_itemSaved($lid, 'links', $old_lid);
        }

        // Get category for rdf check
        $category = DB_getItem ($_TABLES['linkcategories'],"category","cid='{$cid}'");
        COM_rdfUpToDateCheck ('links', $category, $lid);

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
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG_LINKS_ADMIN, $LANG_ACCESS,
           $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG_LINKS_ADMIN[2], 'field' => 'lid', 'sort' => true),
        array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
        array('text' => $LANG_ACCESS['access'], 'field' => 'access', 'sort' => false),
        array('text' => $LANG_LINKS_ADMIN[14], 'field' => 'category', 'sort' => true)
    );

    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'] . '/plugins/links/index.php?mode=edit',
              'text' => $LANG_LINKS_ADMIN[51])
    );

    $validate = '';
    if (isset($_GET['validate'])) {
        $token = SEC_createToken();
        $menu_arr[] = array('url' => $_CONF['site_admin_url'] . '/plugins/links/index.php',
            'text' => $LANG_LINKS_ADMIN[53]);
        $dovalidate_url = $_CONF['site_admin_url'] . '/plugins/links/index.php?validate=validate' . '&amp;'.CSRF_TOKEN.'='.$token;
        $dovalidate_text = $LANG_LINKS_ADMIN[58];
        $form_arr['top'] = COM_createLink($dovalidate_text, $dovalidate_url);
        if ($_GET['validate'] == 'enabled') {
            $header_arr[] = array('text' => $LANG_LINKS_ADMIN[27], 'field' => 'beforevalidate', 'sort' => false);
            $validate = '?validate=enabled';
        } else if ($_GET['validate'] == 'validate') {
            $header_arr[] = array('text' => $LANG_LINKS_ADMIN[27], 'field' => 'dovalidate', 'sort' => false);
            $validate = '?validate=validate&amp;'.CSRF_TOKEN.'='.$token;
        }
        $validate_help = $LANG_LINKS_ADMIN[59];
    } else {
        $menu_arr[] = array('url' => $_CONF['site_admin_url'] . '/plugins/links/index.php?validate=enabled',
              'text' => $LANG_LINKS_ADMIN[26]);
        $form_arr = array();
        $validate_help = '';
    }

    $defsort_arr = array('field' => 'title', 'direction' => 'asc');

    $menu_arr[] = array('url' => $_CONF['site_admin_url'] . '/plugins/links/category.php',
              'text' => $LANG_LINKS_ADMIN[50]);
    $menu_arr[] = array('url' => $_CONF['site_admin_url'] . '/plugins/links/category.php?mode=edit',
              'text' => $LANG_LINKS_ADMIN[52]);
    $menu_arr[] = array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']);

    $retval .= COM_startBlock($LANG_LINKS_ADMIN[11], '',
                              COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu($menu_arr, $LANG_LINKS_ADMIN[12] . $validate_help, plugin_geticon_links());

    $text_arr = array(
        'has_extras' => true,
        'form_url' => $_CONF['site_admin_url'] . "/plugins/links/index.php$validate"
    );

    $query_arr = array('table' => 'links',
        'sql' => "SELECT l.lid AS lid, l.cid as cid, l.title AS title, "
            . "c.category AS category, l.url AS url, l.description AS description, "
            . "l.owner_id, l.group_id, l.perm_owner, l.perm_group, l.perm_members, l.perm_anon "
            . "FROM {$_TABLES['links']} AS l "
            . "LEFT JOIN {$_TABLES['linkcategories']} AS c "
            . "ON l.cid=c.cid WHERE 1=1",
        'query_fields' => array('title', 'category', 'url', 'l.description'),
        'default_filter' => COM_getPermSql ('AND', 0, 3, 'l')
    );

    $retval .= ADMIN_list('links', 'plugin_getListField_links', $header_arr,
                    $text_arr, $query_arr, $defsort_arr, '', '', '', $form_arr);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
* Delete a link
*
* @param    string  $lid    id of link to delete
* @param    string  $type   'submission' when attempting to delete a submission
* @return   string          HTML redirect
*
*/
function deleteLink($lid, $type = '')
{
    global $_CONF, $_TABLES, $_USER;

    if (empty($type)) { // delete regular link
        $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']} WHERE lid ='$lid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon']);
        if ($access < 3) {
            COM_accessLog("User {$_USER['username']} tried to illegally delete link $lid.");
            return COM_refresh($_CONF['site_admin_url']
                               . '/plugins/links/index.php');
        }

        DB_delete($_TABLES['links'], 'lid', $lid);

        PLG_itemDeleted($lid, 'links');

        return COM_refresh($_CONF['site_admin_url']
                           . '/plugins/links/index.php?msg=3');
    } elseif ($type == 'submission') {
        if (plugin_ismoderator_links()) {
            DB_delete($_TABLES['linksubmission'], 'lid', $lid);

            return COM_refresh($_CONF['site_admin_url']
                               . '/plugins/links/index.php?msg=3');
        } else {
            COM_accessLog("User {$_USER['username']} tried to illegally delete link submission $lid.");
        }
    } else {
        COM_accessLog("User {$_USER['username']} tried to illegally delete link $lid of type $type.");
    }

    return COM_refresh($_CONF['site_admin_url'] . '/plugins/links/index.php');
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
    } elseif (SEC_checkToken()) {
        $type = '';
        if (isset($_POST['type'])) {
            $type = COM_applyFilter($_POST['type']);
        }
        $display .= deleteLink($lid, $type);
    } else {
        COM_accessLog("User {$_USER['username']} tried to illegally delete link $lid and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
    }
} elseif (($mode == $LANG_ADMIN['save']) && !empty($LANG_ADMIN['save']) && SEC_checkToken()) {
    $cid = '';
    if (isset($_POST['cid'])) {
        $cid = $_POST['cid'];
    }
    $display .= savelink (COM_applyFilter ($_POST['lid']),
            COM_applyFilter ($_POST['old_lid']),
            $cid, $_POST['categorydd'],
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
    $display .= COM_siteHeader('menu', $LANG_LINKS_ADMIN[11]);
    if (isset($_GET['msg'])) {
        $msg = COM_applyFilter($_GET['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage($msg, 'links');
        }
    }
    $display .= listlinks();
    $display .= COM_siteFooter();
}

COM_output($display);

?>
