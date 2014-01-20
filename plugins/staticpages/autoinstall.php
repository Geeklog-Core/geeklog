<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun         - dirk AT haun-online DOT de                   |
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
* Autoinstall API functions for the Static Pages plugin
*
* @package StaticPages
*/

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_staticpages($pi_name)
{
    $pi_name         = 'staticpages';
    $pi_display_name = 'Static Pages';
    $pi_admin        = 'Static Page Admin'; // "Page"(!), not "Pages"

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '1.6.6',
        'pi_gl_version'   => '2.1.0',
        'pi_homepage'     => 'http://www.geeklog.net/'
    );

    $groups = array(
        $pi_admin => 'Users in this group can administer the '
                     . $pi_display_name . ' plugin'
    );

    $features = array(
        $pi_name . '.edit'                                  => 'Access to ' . $pi_display_name . ' editor',
        $pi_name . '.delete'                                => 'Ability to delete static pages',
        $pi_name . '.PHP'                                   => 'Ability to use PHP in static pages',
        'config.' . $pi_name . '.tab_main'                  => 'Access to configure static pages main settings',
        'config.' . $pi_name . '.tab_whatsnew'              => 'Access to configure static pages what\'s new block',
        'config.' . $pi_name . '.tab_search'                => 'Access to configure static pages search results',
        'config.' . $pi_name . '.tab_permissions'           => 'Access to configure static pages default permissions', 
        'config.' . $pi_name . '.tab_autotag_permissions'   => 'Access to configure static pages autotag usage permissions'
    );

    $mappings = array(
        $pi_name . '.edit'                                  => array($pi_admin),
        $pi_name . '.delete'                                => array($pi_admin), 
        // Note: 'staticpages.PHP' is not assigned to any group by default
        'config.' . $pi_name . '.tab_main'                  => array($pi_admin),
        'config.' . $pi_name . '.tab_whatsnew'              => array($pi_admin),
        'config.' . $pi_name . '.tab_search'                => array($pi_admin),
        'config.' . $pi_name . '.tab_permissions'           => array($pi_admin),        
        'config.' . $pi_name . '.tab_autotag_permissions'   => array($pi_admin)
    );

    $tables = array(
        'staticpage'
    );

    $inst_parms = array(
        'info'      => $info,
        'groups'    => $groups,
        'features'  => $features,
        'mappings'  => $mappings,
        'tables'    => $tables
    );

    return $inst_parms;
}

/**
* Load plugin configuration from database
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true on success, otherwise false
* @see      plugin_initconfig_staticpages
*
*/
function plugin_load_configuration_staticpages($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_staticpages();
}

/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*
*/
function plugin_compatible_with_this_version_staticpages($pi_name)
{
    global $_CONF, $_DB_dbms;

    // check if we support the DBMS the site is running on
    $dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/'
            . $_DB_dbms . '_install.php';
    if (! file_exists($dbFile)) {
        return false;
    }

    if (! function_exists('SEC_getGroupDropdown')) {
        return false;
    }

    if (! function_exists('SEC_createToken')) {
        return false;
    }

    if (! function_exists('COM_showMessageText')) {
        return false;
    }

    if (! function_exists('COM_setLangIdAndAttribute')) {
        return false;
    }

    if (! isset($_CONF['meta_tags'])) {
        return false;
    }

    if (! function_exists('SEC_getTokenExpiryNotice')) {
        return false;
    }

    if (! function_exists('SEC_loginRequiredForm')) {
        return false;
    }

    return true;
}

/**
* Give "filemanager.admin" feature to Static Page Admin
*
* @param   string   $pi_name   plugin name, i.e., 'staticpages'
* @return  boolean             TRUE = success, FALSE = otherwise
*/
function plugin_postinstall_staticpages($pi_name)
{
    global $_CONF, $_TABLES;

    if (DB_count($_TABLES['features'], 'ft_name', 'filemanager.admin') == 1) {
        $featureId = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'filemanager.admin' ");
        $staticPageAdminId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin' ");
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureId}, {$staticPageAdminId}) ");
    }
}

?>
