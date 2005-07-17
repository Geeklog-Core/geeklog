<?php

// +---------------------------------------------------------------------------+
// | Universal Plugin 1.0 for Geeklog - The Ultimate Weblog                    |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// |                                                                           |
// | This file installs the data structures for the links Plugin               |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002 by the following authors:                              |
// |                                                                           |
// | Author:                                                                   |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    tomw@pigstye.net                         |
// | Blaine Lang                 -    geeklog@langfamily.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
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
// $Id: install.php,v 1.4 2005/07/17 09:37:42 dhaun Exp $

require_once('../../../lib-common.php');
require_once($_CONF['path'] . 'plugins/links/config.php');
require_once($_CONF['path'] . 'plugins/links/functions.inc');

//
// Universal plugin install variables
// Change these to match your plugin
//

$pi_name = 'links';                      // Plugin name
$pi_version = $_LI_CONF['version'];      // Plugin Version
$gl_version = '1.3.12';                  // GL Version plugin for
$pi_url = 'http://www.geeklog.net/';  // Plugin Homepage


// Default data
// Insert table name and sql to insert default data for your plugin.

$DEFVALUES = array();

//
// Security Feature to add
// Fill in your security features here
// Note you must add these features to the uninstall routine in function.inc so that they will
// be removed when the uninstall routine runs.
// You do not have to use these particular features.  You can edit/add/delete them
// to fit your plugins security model
//


$NEWFEATURE = array();
$NEWFEATURE['links.edit']       = 'Access to links editor';
$NEWFEATURE['links.moderate']   = 'Ablility to moderate pending links';
$NEWFEATURE['links.submit']     = 'May skip the links submission queue';

// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_accessLog("Someone has tried to illegally access the links install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
    $display = COM_siteHeader();
    $display .= COM_startBlock($LANG_REG00['access_denied']);
    $display .= $LANG_REG00['access_denied_msg'];
    $display .= COM_endBlock();
    $display .= COM_siteFooter(true);
    echo $display;
    exit;
}

/**
* Puts the datastructures for this plugin into the Geeklog database
*
* Note: Corresponding uninstall routine is in functions.inc
*
* @return    boolean    True if successful False otherwise
*
*/
function plugin_install_links()
{
    global $_CONF, $_TABLES, $NEWTABLE, $DEFVALUES, $NEWFEATURE, $_ENV,
           $pi_name, $pi_version, $gl_version, $pi_url;

    COM_errorLog("Attempting to install the $pi_name Plugin",1);

    // Create the Plugins Tables

    require_once($_CONF['path'] . 'plugins/links/sql/links_install_1.0.php');

    COM_errorLOG("executing " . $_SQL[1]);
    DB_query($_SQL[1]);
    if (DB_error()) {
        COM_errorLog("Error Creating $table table",1);
        plugin_uninstall_links();
        return false;
        exit;
    }

	COM_errorLOG("executing " . $_SQL[2]);
    DB_query($_SQL[2]);
    if (DB_error()) {
        COM_errorLog("Error Creating $table table",1);
        plugin_uninstall_links();
        return false;
        exit;
    }

    // Create the plugin admin security group
    COM_errorLog("Attempting to create $pi_name admin group", 1);
    DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) "
        . "VALUES ('Links Admin', 'Has full access to $pi_name features')",1);
    if (DB_error()) {
        plugin_uninstall_links();
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    $group_id = DB_insertId();

    // Add plugin Features
    foreach ($NEWFEATURE as $feature => $desc) {
        COM_errorLog("Adding $feature feature",1);
        DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
            . "VALUES ('$feature','$desc')",1);
        if (DB_error()) {
            COM_errorLog("Failure adding $feature feature",1);
            plugin_uninstall_links();
            return false;
            exit;
        }
        $feat_id = DB_insertId();
        COM_errorLog("Success",1);
        COM_errorLog("Adding $feature feature to admin group",1);
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($feat_id, $group_id)");
        if (DB_error()) {
            COM_errorLog("Failure adding $feature feature to admin group",1);
            plugin_uninstall_links();
            return false;
            exit;
        }
        COM_errorLog("Success",1);
    }

    // OK, now give Root users access to this plugin now! NOTE: Root group should always be 1
    COM_errorLog("Attempting to give all users in Root group access to $pi_name admin group",1);
    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES ($group_id, NULL, 1)");
    if (DB_error()) {
        plugin_uninstall_links();
        return false;
        exit;
    }

    // Register the plugin with Geeklog
    COM_errorLog("Registering $pi_name plugin with Geeklog", 1);
    DB_delete ($_TABLES['plugins'], 'pi_name', $pi_name);
    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
        . "VALUES ('$pi_name', '$pi_version', '$gl_version', '$pi_url', 1)");

    if (DB_error()) {
        plugin_uninstall_links();
        return false;
        exit;
    }

    COM_errorLog("Succesfully installed the $pi_name Plugin!",1);

    return true;
}

//*
/* Main Function
*/

$display = COM_siteHeader();
$T = new Template($_CONF['path'] . 'plugins/links/templates/admin');
$T->set_file('install', 'install.thtml');
$T->set_var('install_header', $LANG_REG00['install_header']);
$T->set_var('img',$_CONF['site_url'] . '/links/images/links.png');
$T->set_var('cgiurl', $_CONF['site_admin_url'] . '/plugins/links/install.php');
$T->set_var('admin_url', $_CONF['site_admin_url']);

if ($_REQUEST['action'] == 'install') {
    if (plugin_install_links()) {
        $install_msg = sprintf($LANG_REG00['install_success'],$_CONF['site_admin_url'] .'/plugins/links/install_doc.htm');
        $T->set_var('installmsg1',$install_msg);
        $T->set_var('editor',$LANG_REG00['editor']);
    } else {
        $T->set_var('installmsg1',$LANG_REG00['install_failed']);
    }
} else if ($_REQUEST['action'] == 'uninstall') {
   plugin_uninstall_links();
   $T->set_var('installmsg1',$LANG_REG00['uninstall_msg']);
}

if (DB_count($_TABLES['plugins'], 'pi_name', 'links') == 0) {
    $T->set_var('installmsg2', $LANG_REG00['uninstalled']);
    $T->set_var('btnmsg', $LANG_REG00['install']);
    $T->set_var('action','install');
} else {
    $T->set_var('installmsg2', $LANG_REG00['installed']);
    $T->set_var('btnmsg', $LANG_REG00['uninstall']);
    $T->set_var('action','uninstall');
}
$T->parse('output','install');
$display .= $T->finish($T->get_var('output'));
$display .= COM_siteFooter(true);

echo $display;

?>
