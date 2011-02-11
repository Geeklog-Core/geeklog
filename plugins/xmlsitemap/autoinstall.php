<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 1.0                                                     |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
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
* Autoinstall API functions for the XMLSitemap plugin
*
* @package XMLSitemap
*/

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_xmlsitemap($pi_name)
{
    $pi_name         = 'xmlsitemap';
    $pi_display_name = 'XMLSitemap';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '1.0.1',
        'pi_gl_version'   => '1.8.0',
        'pi_homepage'     => 'http://www.geeklog.net/',
    );
    
    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );

    $features = array(
        'config.' . $pi_name . '.tab_main'   => 'Access to configure general XMLSitemap settings',
        'config.' . $pi_name . '.tab_pri'    => 'Access to configure XMLSitemap priorities',
        'config.' . $pi_name . '.tab_freq'   => 'Access to configure XMLSitemap update frequency'
    );

    $mappings = array(
        'config.' . $pi_name . '.tab_main'   => array($pi_admin),
        'config.' . $pi_name . '.tab_pri'    => array($pi_admin),
        'config.' . $pi_name . '.tab_freq'   => array($pi_admin)
    );

    $inst_parms = array(
        'info'      => $info,
        'groups'    => $groups,
        'features'  => $features,
        'mappings'  => $mappings
    );

    return $inst_parms;
}

/**
* Load plugin configuration from database
*
* @param    string  $pi_name    Plugin name
* @return   boolean             TRUE on success, otherwise FALSE
* @see      plugin_initconfig_xmlsitemap
*
*/
function plugin_load_configuration_xmlsitemap($pi_name)
{
    global $_CONF;
    
    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';
    
    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';
    
    return plugin_initconfig_xmlsitemap();
}

/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             TRUE: plugin compatible; FALSE: not compatible
*
*/
function plugin_compatible_with_this_version_xmlsitemap($pi_name)
{
    global $_CONF, $_DB_dbms;

    // check if we support the DBMS the site is running on
    $dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/'
            . $_DB_dbms . '_install.php';
    if (! file_exists($dbFile)) {
        return false;
    }

    return function_exists('PLG_itemDeleted');
}

/**
* Perform post-install operations
*
* @param    string  $pi_name    Plugin name
* @return   boolean             TRUE: plugin compatible; FALSE: not compatible
*/
function plugin_postinstall_xmlsitemap($pi_name)
{
    global $_CONF, $_XMLSMAP_CONF;
    
    require_once $_CONF['path'] . 'plugins/xmlsitemap/functions.inc';
    
    // Create an XML sitemap for the first time
    return XMLSMAP_update();
}

?>
