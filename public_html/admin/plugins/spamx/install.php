<?php

// +---------------------------------------------------------------------------+
// | Universal Plugin 1.0 for Geeklog - The Ultimate Weblog                    |
// +---------------------------------------------------------------------------+
// | install.php for spamx plugin                                              |
// |                                                                           |
// | This file installs and removes the data structures for the                |
// | plugin for Geeklog.                                                       |
// | This is a complete functioning install routine.  All you have to do is    |
// | remove the sample data from the arrays and fill in the $NEWTABLE,         |
// | $DEFVALUES, and $NEWFEATURE arrays with your data.  Then replace all      |
// | occurances of spamx with the name of your plugin and you will have a   |
// | functioning install page for your plugin.  Then customize the install     |
// | display language in english.php and you are ready to distribute your      |
// | plugin.                                                                   |
// | Simply put here is what this install does:                                |
// | 1) It creates the tables                                                  |
// | 2) It creates an admin security group for you plugin                      |
// | 3) It adds the security features and adds them to the admin group         |
// | 4) It adds the plugin to the gl_plugins table                             |
// | 5) It adds any default data you have provided                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002 by the following authors:                              |
// |                                                                           |
// | Author:                                                                   |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
// +---------------------------------------------------------------------------+
// | Spamx Plugin Copyright (C) 2004 by                                        |
// | Tom Willett             -   tomw@pigstye.net                              |
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

require_once('../../../lib-common.php');
require_once($_CONF['path'] . 'plugins/spamx/config.php');
require_once($_CONF['path'] . 'plugins/spamx/functions.inc');

//
// Universal plugin install variables
// Change these to match your plugin
//

$pi_name = 'spamx';             // Plugin name  Must be 15 chars or less
$pi_version = '1.0.1';          // Plugin Version
$gl_version = '1.3.10';         // GL Version plugin for
$pi_url = 'http://www.pigstye.net/gplugs/staticpages/index.php/spamx';      // Plugin Homepage

//
// $NEWTABLE contains table name(s) and sql to create it(them)
// Fill it in and you are ready to go.
// Note: you must put the table names in the uninstall routine in functions.inc 
// and in the $_TABLES array in config.php.
// Note: Be sure to replace table1, table2 with the actual names of your tables.
// and the table definition with the definition of your table
//

$NEWTABLE = array();
$NEWTABLE['spamx'] = "CREATE TABLE {$_TABLES['spamx']} ("
	. " name varchar(20) NOT NULL default '',"
	. " value varchar(255) NOT NULL default '',"
	. " INDEX name (name)"
	. ") TYPE=MyISAM";
	
//
// Default data
// Insert table name and sql to insert default data for your plugin.
//
$DEFVALUES = array();
$DEFVALUES[]="INSERT INTO {$_TABLES['spamx']} VALUES ('Action','DeleteComment')";
$DEFVALUES[]="INSERT INTO {$_TABLES['spamx']} VALUES ('Examine','BlackList')";
$DEFVALUES[]="INSERT INTO {$_TABLES['spamx']} VALUES ('Examine','MTBlackList')";
$DEFVALUES[]="INSERT INTO {$_TABLES['spamx']} VALUES ('Personal','zaraz.com')";
 
//
// Security Feature to add
// Fill in your security features here
// Note you must add these features to the uninstall routine in function.inc so that they will
// be removed when the uninstall routine runs.
// You do not have to use these particular features.  You can edit/add/delete them
// to fit your plugins security model
//

$NEWFEATURE = array();
$NEWFEATURE['spamx.admin']="spamx Admin";

// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the spamx install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
    $display = COM_siteHeader();
    $display .= COM_startBlock($LANG_SX00['access_denied']);
    $display .= $LANG_SX00['access_denied_msg'];
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
* @return   boolean True if successful False otherwise
*
*/
function plugin_install_spamx()
{
    global $pi_name, $pi_version, $gl_version, $pi_url, $NEWTABLE, $DEFVALUES, $NEWFEATURE;
    global $_TABLES, $_CONF;

    COM_errorLog("Attempting to install the $pi_name Plugin",1);

    // Create the Plugins Tables
    
    foreach ($NEWTABLE as $table => $sql) {
        COM_errorLog("Creating $table table",1);
        DB_query($sql,1);
        if (DB_error()) {
            COM_errorLog("Error Creating $table table",1);
            plugin_uninstall_{plugin}();
            return false;
            exit;
        }
        COM_errorLog("Success - Created $table table",1);
    }
     
    // Insert Default Data
    
    foreach ($DEFVALUES as $sql) {
		$table = $_TABLES['spamx'];
        COM_errorLog("Inserting default data into $table table",1);
        DB_query($sql,1);
        if (DB_error()) {
            COM_errorLog("Error inserting default data into $table table",1);
            plugin_uninstall_{plugin}();
            return false;
            exit;
        }
        COM_errorLog("Success - inserting data into $table table",1);
    }

    // Create the plugin admin security group
    COM_errorLog("Attempting to create $pi_name admin group", 1);
    DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) "
        . "VALUES ('$pi_name Admin', 'Users in this group can administer the $pi_name plugin')",1);
    if (DB_error()) {
        plugin_uninstall_spamx();
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    $group_id = DB_insertId();
    
    // Save the grp id for later uninstall
    COM_errorLog('About to save group_id to vars table for use during uninstall',1);
    DB_query("INSERT INTO {$_TABLES['vars']} VALUES ('{$pi_name}_gid', $group_id)",1);
    if (DB_error()) {
        plugin_uninstall_spamx();
        return false;
        exit;
    }
    COM_errorLog('...success',1);
    
    // Add plugin Features
    foreach ($NEWFEATURE as $feature => $desc) {
        COM_errorLog("Adding $feature feature",1);
        DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
            . "VALUES ('$feature','$desc')",1);
        if (DB_error()) {
            COM_errorLog("Failure adding $feature feature",1);
            plugin_uninstall_spamx();
            return false;
            exit;
        }
        $feat_id = DB_insertId();
        COM_errorLog("Success",1);
        COM_errorLog("Adding $feature feature to admin group",1);
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($feat_id, $group_id)");
        if (DB_error()) {
            COM_errorLog("Failure adding $feature feature to admin group",1);
            plugin_uninstall_spamx();
            return false;
            exit;
        }
        COM_errorLog("Success",1);
    }        
    
    // OK, now give Root users access to this plugin now! NOTE: Root group should always be 1
    COM_errorLog("Attempting to give all users in Root group access to $pi_name admin group",1);
    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES ($group_id, NULL, 1)");
    if (DB_error()) {
        plugin_uninstall_spamx();
        return false;
        exit;
    }

    // Register the plugin with Geeklog
    COM_errorLog("Registering $pi_name plugin with Geeklog", 1);
    DB_delete($_TABLES['plugins'],'pi_name','spamx');
    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
        . "VALUES ('$pi_name', '$pi_version', '$gl_version', '$pi_url', 1)");

    if (DB_error()) {
        plugin_uninstall_spamx();
        return false;
        exit;
    }

    COM_errorLog("Succesfully installed the $pi_name Plugin!",1);
    return true;
}

/* 
* Main Function
*/

$display = COM_siteHeader();
$T = new Template($_CONF['path'] . 'plugins/spamx/templates');
$T->set_file('install', 'install.thtml');
$T->set_var('install_header', $LANG_SX00['install_header']);
$T->set_var('img',$_CONF['site_url'] . '/spamx/images/spamx.gif');
$T->set_var('cgiurl', $_CONF['site_admin_url'] . '/plugins/spamx/install.php');
$T->set_var('admin_url', $_CONF['site_admin_url'] . '/plugins/spamx/index.php');

if ($action == 'install') {
    if (plugin_install_spamx()) {
        $T->set_var('installmsg1',$LANG_SX00['install_success']);
    } else {
        $T->set_var('installmsg1',$LANG_SX00['install_failed']);
    }
} else if ($action == "uninstall") {
   plugin_uninstall_spamx('installed');
   $T->set_var('installmsg1',$LANG_SX00['uninstall_msg']);
}

if (DB_count($_TABLES['plugins'], 'pi_name', 'spamx') == 0) {
    $T->set_var('installmsg2', $LANG_SX00['uninstalled']);
    $T->set_var('readme', $LANG_SX00['readme']);
    $T->set_var('installdoc', $LANG_SX00['installdoc']);
	$T->set_var('btnmsg', $LANG_SX00['install']);
	$T->set_var('action','install');
} else {
    $T->set_var('installmsg2', $LANG_SX00['installed']);
	$T->set_var('btnmsg', $LANG_SX00['uninstall']);
	$T->set_var('action','uninstall');
}
$T->parse('output','install');
$display .= $T->finish($T->get_var('output'));
$display .= COM_siteFooter(true);

echo $display;

?>
