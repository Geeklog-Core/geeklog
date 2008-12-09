<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Spam-X plugin 1.1                                                         |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// |                                                                           |
// | This file installs and removes the data structures for the                |
// | Spam-X plugin for Geeklog.                                                |
// +---------------------------------------------------------------------------+
// | Based on the Universal Plugin and prior work by the following authors:    |
// |                                                                           |
// | Copyright (C) 2002-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Tom Willett       - tom AT pigstye DOT net                       |
// |          Blaine Lang       - blaine AT portalparts DOT com                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Vincent Furia     - vinny01 AT users DOT sourceforge DOT net     |
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
// $Id: install.php,v 1.26 2008/05/23 13:36:12 dhaun Exp $

require_once '../../../lib-common.php';

// Plugin information
//
// ----------------------------------------------------------------------------
//
$pi_display_name = 'Spam-X';
$pi_name         = 'spamx';
$pi_version      = '1.1.1';
$gl_version      = '1.5.0';
$pi_url          = 'http://www.pigstye.net/gplugs/staticpages/index.php/spamx';

$base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

// name of the Admin group
$pi_admin        = $pi_name . ' Admin';

// the plugin's groups - assumes first group to be the Admin group
$GROUPS = array();
$GROUPS[$pi_admin] = 'Users in this group can administer the Spam-X plugin';

$FEATURES = array();
$FEATURES['spamx.admin']    = 'Full access to Spam-X plugin';

$MAPPINGS = array();
$MAPPINGS['spamx.admin']    = array ($pi_admin);

// (optional) data to pre-populate tables with
// Insert table name and sql to insert default data for your plugin.
// Note: '#group#' will be replaced with the id of the plugin's admin group.
$DEFVALUES = array();
$DEFVALUES[] = "INSERT INTO {$_TABLES['vars']} VALUES ('spamx.counter', '0')";

/**
* Checks the requirements for this plugin and if it is compatible with this
* version of Geeklog.
*
* @return   boolean     true = proceed with install, false = not compatible
*
*/
function plugin_compatible_with_this_geeklog_version()
{
    if (function_exists('PLG_spamAction')) {
        return true;
    }

    if (function_exists('SEC_createToken')) {
        return true;
    }

    if (function_exists('COM_showMessageText')) {
        return true;
    }

    return false;
}

/**
* Add plugin configuration
*
*/
function plugin_load_configuration()
{
    global $_CONF, $base_path;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_spamx();
}


//
// ----------------------------------------------------------------------------
//
// The code below should be the same for most plugins and usually won't
// require modifications.

$langfile = $base_path . $_CONF['language'] . '.php';
if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $base_path . 'language/english.php';
}
require_once $base_path . 'functions.inc';


// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_accessLog("Someone has tried to illegally access the {$pi_display_name} install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);

    $display = COM_siteHeader('menu', $LANG_ACCESS['accessdenied'])
             . COM_startBlock($LANG_ACCESS['accessdenied'])
             . $LANG_ACCESS['plugin_access_denied_msg']
             . COM_endBlock()
             . COM_siteFooter();

    echo $display;
    exit;
}


/**
* Puts the datastructures for this plugin into the Geeklog database
*
*/
function plugin_install_now()
{
    global $_CONF, $_TABLES, $_USER, $_DB_dbms,
           $GROUPS, $FEATURES, $MAPPINGS, $DEFVALUES, $base_path,
           $pi_name, $pi_display_name, $pi_version, $gl_version, $pi_url;

    COM_errorLog("Attempting to install the $pi_display_name plugin", 1);

    // create the plugin's groups
    $admin_group_id = 0;
    foreach ($GROUPS as $name => $desc) {
        COM_errorLog("Attempting to create $name group", 1);

        $grp_name = addslashes($name);
        $grp_desc = addslashes($desc);
        DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) VALUES ('$grp_name', '$grp_desc')", 1);
        if (DB_error()) {
            PLG_uninstall($pi_name);

            return false;
        }

        // replace the description with the new group id so we can use it later
        $GROUPS[$name] = DB_insertId();

        // assume that the first group is the plugin's Admin group
        if ($admin_group_id == 0) {
            $admin_group_id = $GROUPS[$name];
        }
    }

    // Create the plugin's table(s)
    $_SQL = array();
    if (file_exists($base_path . 'sql/' . $_DB_dbms . '_install.php')) {
        require_once $base_path . 'sql/' . $_DB_dbms . '_install.php';
    }

    if (count($_SQL) > 0) {
        $use_innodb = false;
        if (($_DB_dbms == 'mysql') &&
            (DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'")
                == 'InnoDB')) {
            $use_innodb = true;
        }
        foreach ($_SQL as $sql) {
            $sql = str_replace('#group#', $admin_group_id, $sql);
            if ($use_innodb) {
                $sql = str_replace('MyISAM', 'InnoDB', $sql);
            }
            DB_query($sql);
            if (DB_error()) {
                COM_errorLog('Error creating table', 1);
                PLG_uninstall($pi_name);

                return false;
            }
        }
    }

    // Add the plugin's features
    COM_errorLog("Attempting to add $pi_display_name feature(s)", 1);

    foreach ($FEATURES as $feature => $desc) {
        $ft_name = addslashes($feature);
        $ft_desc = addslashes($desc);
        DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
                 . "VALUES ('$ft_name', '$ft_desc')", 1);
        if (DB_error()) {
            PLG_uninstall($pi_name);

            return false;
        }

        $feat_id = DB_insertId();

        if (isset($MAPPINGS[$feature])) {
            foreach ($MAPPINGS[$feature] as $group) {
                COM_errorLog("Adding $feature feature to the $group group", 1);
                DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($feat_id, {$GROUPS[$group]})");
                if (DB_error()) {
                    PLG_uninstall($pi_name);

                    return false;
                }
            }
        }
    }

    // Add plugin's Admin group to the Root user group
    // (assumes that the Root group's ID is always 1)
    COM_errorLog("Attempting to give all users in the Root group access to the $pi_display_name's Admin group", 1);

    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES "
             . "($admin_group_id, NULL, 1)");
    if (DB_error()) {
        PLG_uninstall($pi_name);

        return false;
    }

    // Pre-populate tables or run any other SQL queries
    COM_errorLog('Inserting default data', 1);
    foreach ($DEFVALUES as $sql) {
        $sql = str_replace('#group#', $admin_group_id, $sql);
        DB_query($sql, 1);
        if (DB_error()) {
            PLG_uninstall($pi_name);

            return false;
        }
    }

    // Load the online configuration records
    if (function_exists('plugin_load_configuration')) {
        if (!plugin_load_configuration()) {
            PLG_uninstall($pi_name);

            return false;
        }
    }

    // Finally, register the plugin with Geeklog
    COM_errorLog("Registering $pi_display_name plugin with Geeklog", 1);

    // silently delete an existing entry
    DB_delete($_TABLES['plugins'], 'pi_name', $pi_name);

    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) VALUES "
        . "('$pi_name', '$pi_version', '$gl_version', '$pi_url', 1)");

    if (DB_error()) {
        PLG_uninstall($pi_name);

        return false;
    }

    // give the plugin a chance to perform any post-install operations
    if (function_exists('plugin_postinstall')) {
        if (!plugin_postinstall()) {
            PLG_uninstall($pi_name);

            return false;
        }
    }

    COM_errorLog("Successfully installed the $pi_display_name plugin!", 1);

    return true;
}


// MAIN
$display = '';

if (SEC_checkToken()) {
    if ($_REQUEST['action'] == 'uninstall') {
        $uninstall_plugin = 'plugin_uninstall_' . $pi_name;
        if ($uninstall_plugin()) {
            $display = COM_refresh($_CONF['site_admin_url']
                                   . '/plugins.php?msg=45');
        } else {
            $display = COM_refresh($_CONF['site_admin_url']
                                   . '/plugins.php?msg=73');
        }
    } else if (DB_count($_TABLES['plugins'], 'pi_name', $pi_name) == 0) {
        // plugin not installed
    
        if (plugin_compatible_with_this_geeklog_version()) {
            if (plugin_install_now()) {
                $display = COM_refresh($_CONF['site_admin_url']
                                       . '/plugins.php?msg=44');
            } else {
                $display = COM_refresh($_CONF['site_admin_url']
                                       . '/plugins.php?msg=72');
            }
        } else {
            // plugin needs a newer version of Geeklog
            $display .= COM_siteHeader('menu', $LANG32[8])
                     . COM_startBlock($LANG32[8])
                     . '<p>' . $LANG32[9] . '</p>'
                     . COM_endBlock()
                     . COM_siteFooter();
        }
    } else {
        // plugin already installed
        $display .= COM_siteHeader('menu', $LANG01[77])
                 . COM_startBlock($LANG32[6])
                 . '<p>' . $LANG32[7] . '</p>'
                 . COM_endBlock()
                 . COM_siteFooter();
    }
} else {
    $display = COM_refresh($_CONF['site_admin_url'].'/plugins.php');
}

echo $display;

?>
