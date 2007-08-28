<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | category.php                                                              |
// |                                                                           |
// | Geeklog links category administration page.                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
// |          Euan McKay        - info@heatherengineering.com                  |
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
// $Id: 

require_once ('../../../lib-common.php');
require_once($_CONF['path'] . 'plugins/links/config.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

$display = '';

if (!SEC_hasRights('links.edit')) {
    $display .= COM_siteHeader ('menu');
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[34];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    COM_accessLog("User {$_USER['username']} tried to illegally access the link administration screen.");
    echo $display;
    exit;
}



// MAIN

$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

$root = 'site';

// delete category
if ((($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) || ($mode=="delete")) {
    $cid = COM_applyFilter ($_REQUEST['cid']);
    if (!isset ($cid) || empty ($cid)) {  // || ($cid == 0)
        COM_errorLog ('Attempted to delete category cid=' . $cid );
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/plugins/links/category.php');
    } else {
        $display .= COM_siteHeader ('menu', $LANG_LINKS_ADMIN[11]);
        $result  = links_delete_category ($cid);

        $display .= COM_startBlock ($LANG_LINKS[41], '', COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $result;
        $display .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= links_list_categories($root);
        $display .= COM_siteFooter();

    }

// save category
} else if (($mode == $LANG_ADMIN['save']) && !empty ($LANG_ADMIN['save'])) {
    $display .= COM_siteHeader ('menu', $LANG_LINKS_ADMIN[11]);
    $result = links_save_category (COM_applyFilter ($_POST['cid']), 
            COM_applyFilter ($_POST['old_cid']), 
            COM_applyFilter ($_POST['pid']), $_POST['category'], $_POST['description'],
            COM_applyFilter ($_POST['tid']),
            COM_applyFilter ($_POST['owner_id'], true),
            COM_applyFilter ($_POST['group_id'], true),
            $_POST['perm_owner'], $_POST['perm_group'],
            $_POST['perm_members'], $_POST['perm_anon']);
    $display .= COM_startBlock ($LANG_LINKS[41], '', COM_getBlockTemplate ('_msg_block', 'header'));
    if ($result==1) {
        $display .= $LANG_LINKS_ADMIN[39];
    } else {
        $display .= $result;
    }
    $display .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));

    $display .= links_list_categories($root);
    $display .= COM_siteFooter();

// edit category
} else if ($mode == "edit") {
    $display .= COM_siteHeader ('menu', $LANG_LINKS_ADMIN[11]);
    $pid   = COM_applyFilter ($_GET['pid']);
    $cid   = COM_applyFilter ($_GET['cid']);
    $display .= links_edit_category ($cid,$pid);
    $display .= COM_siteFooter();

// nothing, so list categories
} else {
    $display .= COM_siteHeader ('menu', $LANG_LINKS_ADMIN[11]);
    if (isset ($_REQUEST['msg'])) {
        $msg = COM_applyFilter ($_REQUEST['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage ($msg, 'links');
        }
    }
    $display .= links_list_categories($root);
    $display .= COM_siteFooter();
}

echo $display;

?>
