<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
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
* Autoinstall API functions for the Polls plugin
*
* @package Polls
*/

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_polls($pi_name)
{
    $pi_name         = 'polls';
    $pi_display_name = 'Polls';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '2.1.2',
        'pi_gl_version'   => '1.6.1',
        'pi_homepage'     => 'http://www.geeklog.net/'
    );

    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );

    $features = array(
        $pi_name . '.edit'      => 'Access to ' . $pi_name . ' editor'
    );

    $mappings = array(
        $pi_name . '.edit'      => array($pi_admin)
    );

    $tables = array(
        'pollanswers',
        'pollquestions',
        'polltopics',
        'pollvoters'
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
* @see      plugin_initconfig_polls
*
*/
function plugin_load_configuration_polls($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_polls();
}

/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*
*/
function plugin_compatible_with_this_version_polls($pi_name)
{
    global $_CONF, $_DB_dbms;

    // check if we support the DBMS the site is running on
    $dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/'
            . $_DB_dbms . '_install.php';
    if (! file_exists($dbFile)) {
        return false;
    }

    if (function_exists('COM_showPoll') || function_exists('COM_pollVote')) {
        // if these functions exist, then someone's trying to install the
        // plugin on Geeklog 1.3.11 or older - sorry, but that won't work
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

?>
