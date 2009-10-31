<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2009 by the following authors:                         |
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
        'pi_version'      => '1.6.1',
        'pi_gl_version'   => '1.6.1',
        'pi_homepage'     => 'http://www.geeklog.net/'
    );

    $groups = array(
        $pi_admin => 'Users in this group can administer the '
                     . $pi_display_name . ' plugin'
    );

    $features = array(
        $pi_name . '.edit'      => 'Access to ' . $pi_display_name . ' editor',
        $pi_name . '.delete'    => 'Ability to delete static pages',
        $pi_name . '.PHP'       => 'Ability to use PHP in static pages'
    );

    $mappings = array(
        $pi_name . '.edit'      => array($pi_admin),
        $pi_name . '.delete'    => array($pi_admin)
        // Note: 'staticpages.PHP' is not assigned to any group by default
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

    return true;
}

?>
