<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 0.2 for Geeklog - The Ultimate Weblog                 |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// |                                                                           |
// | This file installs and removes the data structures for the Static Pages   |
// | plugin for Geeklog.                                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002 by the following authors:                              |
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
// $Id: install.php,v 1.2 2002/04/23 04:22:03 mlimburg Exp $

require_once('../../../lib-common.php');
require_once($_CONF['path'] . 'plugins/staticpages/lang.php');
require_once($_CONF['path'] . 'plugins/staticpages/staticpages.cfg');

// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the Static Pages install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
    $display = COM_siteHeader();
    $display .= COM_startBlock($LANG_STATIC['access_denied']);
    $display .= $LANG_STATIC['access_denied_msg'];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    echo $display;
    exit;
}
 
/**
* Puts the datastructures for this plugin into the Geeklog database
*
*/
function plugin_install_staticpages()
{
    global $_TABLES, $_CONF, $_SP_CONF;

    COM_errorLog('Attempting to install the Static Page Plugin',1);

    // Installs the static pages plugin

    $createsql = "CREATE TABLE staticpage(sp_id varchar(20) DEFAULT '' NOT NULL,"
        . "sp_uid mediumint(8) DEFAULT '1' NOT NULL,"
        . "sp_title varchar(128) DEFAULT '' NOT NULL,"
        . "sp_content text DEFAULT '' NOT NULL,"
        . "sp_hits mediumint(8) unsigned DEFAULT '0' NOT NULL,"
        . "sp_date datetime NOT NULL,"
        . "sp_format varchar(20) NOT NULL,"
        . "sp_onmenu tinyint(1) unsigned NOT NULL DEFAULT '0',"
        . "sp_label varchar(64),"
        . "PRIMARY KEY (sp_id)"
        . ")";

    COM_errorLog("Attempting to create table staticpage for Static Page plugin", 1);
    DB_query($createsql,1);

    if (DB_error()) {
        return false;
    }

    COM_errorLog('...success',1);
    $steps['createtable'] = 1;

    // Create the static page admin security group
    COM_errorLog("Attempting to create Static Page admin group", 1);
    DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) "
        . "VALUES ('Static Page Admin', 'Users in this group can administer the Static Pages plugin')",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    $steps['insertgroup'] = 1;

    // Save the grp id for later uninstall
    COM_errorLog('About to save group_id to vars table for use during uninstall',1);
    DB_query("INSERT INTO {$_TABLES['vars']} VALUES ('sp_group_id', LAST_INSERT_ID())",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    $steps['savedgroupid'] = 1;

    $group_id = DB_getItem($_TABLES['vars'], 'value', "name = 'sp_group_id'");

    // Add static page features
    COM_errorLog('Attempting to add staticpages.edit feature',1);
    DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
        . "VALUES ('staticpages.edit','Access to Static Pages editor')",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
        exit;
    }
    $edit_id = DB_insertId();
    COM_errorLog('...success',1);
    $steps['insertedfeatureedit'] = 1;

    COM_errorLog('Attempting to add staticpages.delete feature',1);
    DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
        . "VALUES ('staticpages.delete','Ability to delete static pages')",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
        exit;
    }
    $delete_id = DB_insertId();
    COM_errorLog('...success',1);
    $steps['insertedfeaturedelete'] = 1;

    // Now add the features to the group
    COM_errorLog('Attempting to give Static Page Admin group access to staticpages.edit feature',1);
    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($edit_id, $group_id)");
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    $steps['addededittogroup'] = 1;

    COM_errorLog('Attempting to give Static Page Admin group access to staticpages.delete feature',1);
    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($delete_id, $group_id)",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    $steps['addeddeletetogroup'] = 1;

    // OK, now give Root users access to this plugin now! NOTE: Root group should always be 1
    COM_errorLog('Attempting to give all users in Root group access static page admin group',1);
    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES ($group_id, NULL, 1)");
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    $steps['addedrootuserstogroup'] = 1;

    // Register the plugin with Geeklog
    if (DB_count($_TABLES['plugins'],'pi_name','staticpages') > 0) {
        COM_errorLog('Attempting to remove staticpage rentry prior to adding an updated entry',1);
        DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'staticpages'");
        if (DB_error()) {
            plugin_uninstall_staticpages($steps);
            return false;
            exit;
        }
        COM_errorLog('...success',1);
    } else {
        // Only install data on a fresh installation
        // This plugin has no install data
    }

    COM_errorLog('Registering Static Page plugin with Geeklog', 1);
    DB_delete($_TABLES['plugins'],'pi_name','staticpages');
    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
        . "VALUES ('staticpages', '{$_SP_CONF['version']}', '1.3.4', 'http://www.tonybibbs.com', 1)");
    DB_query("INSERT INTO {$_TABLES['vars']} VALUES ('staticpages','1')");

    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    COM_errorLog('Succesfully installed the Static Page Plugin!',1);

    return true;
}

/**
* Removes the datastructures for this plugin from the Geeklog database
*
* This may get called by the install routine to undue anything done to this
* point.  To do that, $steps will have a list of steps to undo
*
* @steps   Array    Holds all the steps that have been completed by the install
*
*/  
function plugin_uninstall_staticpages($steps = '')
{
    global $_TABLES;

    // Uninstalls the static pages plugin

    if (empty($steps) OR $steps['createtable'] == 1) {
        // Remove the staticpage table 
        COM_errorLog('Dropping staticpage table',1);
        DB_query('DROP TABLE staticpage');
        COM_errorLog('...success',1);
    }

    // Remove security for this plugin

    // Remove the static page admin group
    $grp_id = DB_getItem($_TABLES['vars'], 'value', "name = 'sp_group_id'");

    if (empty($steps) OR $steps['insertgroup'] == 1) {
        COM_errorLog('Attempting to remove the Static Page Admin Group', 1);
        DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id");
        COM_errorLog('...success',1);
    }

    // Remove related features
    $edit_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'staticpages.edit'");
    $delete_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'staticpages.delete'");

    if (empty($steps) OR $steps['addededittogroup'] == 1) {
        // Remove access to those features 
        COM_errorLog('Attempting to remove rights to staticpage.edit from all groups',1);
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $edit_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['addeddeletetogroup'] == 1) {
        // Remove access to those features 
        COM_errorLog('Attempting to remove rights to staticpage.delete from all groups',1);
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $delete_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['addedrootuserstogroup'] == 1) {
        // Remove root users from the group
        COM_errorLog('Attempting to remove root users from admin of static pages');
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['insertedfeatureedit'] == 1) {
        COM_errorLog('Attempting to remove the staticpage.edit feature',1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $edit_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['insertedfeaturedelete'] == 1) {
        COM_errorLog('Attempting to remove the staticpage.delete feature',1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $delete_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['savedgroupid']) {
        COM_errorLog('Attempting to remove the group id from the vars table',1);
        DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = 'sp_group_id'");
        COM_errorLog('success',1);
    }

    // Unregister the plugin with Geeklog
    if (empty($steps)) {
        COM_errorLog('Attempting to unregister the plugin from Geeklog',1);
        DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'staticpages'");
        DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = 'staticpages'");
        COM_errorLog('...success',1);

        COM_errorLog('leaving plugin_uninstall_staticpages',1);
        return true;
    } else {
        return false;
    }
}

/* 
MAIN:  OK, I wanted to keep this simple so this is how this works.  When ran for the first
time, this file will attempt to install the datastructures immediately.  When that is complete,
it will insert a record into the Geeklog vars table (name = 'staticpages', value = 1) which will
lock this file from being executed at by anyone.

If you want to remove this plugin you would set the value in that record to 0 and then this script
will uninstall the plugin.  All this is outlined in the INSTALL and UNINSTALL documents.
*/

$display = COM_siteHeader();

if (DB_count($_TABLES['vars'], 'name', 'staticpages') == 0) {
    // Record in vars table doesn' exit, install this plugin
    if (plugin_install_staticpages()) {
        $display .= COM_startBlock($LANG_STATIC['installation_complete']);
        $display .= $LANG_STATIC['installation_complete_msg'];
        $display .= COM_endBlock();
    } else {
        // Error occured
        $display .= COM_startBlock($LANG_STATIC['installation_failed']);
        $display .= $LANG_STATIC['installation_failed_msg'];
        $display .= COM_endBlock();
    }   
} else {
    // This plugin is installed, see if it is locked or not
    if (DB_getItem($_TABLES['vars'],'value',"name = 'staticpages'") == 1) {
        // This is locked, do nothing
        $display .= COM_startBlock($LANG_STATIC['system_locked']);
        $display .= $LANG_STATIC['system_locked_msg'];
        $display .= COM_endBlock();
    } else {
        // Uninstall plugin
        if (plugin_uninstall_staticpages()) {
            // Uninstall worked
            $display .= COM_startBlock($LANG_STATIC['uninstall_complete']);
            $display .= $LANG_STATIC['uninstall_complete_msg'];
            $display .= COM_endBlock();
        } else {
            // Uninstall failed
            $display .= COM_startBlock($LANG_STATIC['uninstall_failed']);
            $display .= $LANG_STATIC['uninstall_failed_msg'];
            $display .= COM_endBlock();
        }
    }
}

$display .= COM_siteFooter();

echo $display;

?>
