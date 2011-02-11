<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Links Plugin 2.1                                                          |
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
* Autoinstall API functions for the Links plugin
*
* @package Links
*/

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_links($pi_name)
{
    $pi_name         = 'links';
    $pi_display_name = 'Links';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '2.1.1',
        'pi_gl_version'   => '1.8.0',
        'pi_homepage'     => 'http://www.geeklog.net/'
    );

    $groups = array(
        $pi_admin => 'Has full access to ' . $pi_display_name . ' features'
    );

    $features = array(
        $pi_name . '.edit'                                  => 'Access to links editor',
        $pi_name . '.moderate'                              => 'Ability to moderate pending links',
        $pi_name . '.submit'                                => 'May skip the links submission queue', 
        'config.' . $pi_name . '.tab_public'                => 'Access to configure public links list settings',
        'config.' . $pi_name . '.tab_admin'                 => 'Access to configure links admin settings',
        'config.' . $pi_name . '.tab_permissions'           => 'Access to configure link permissions',
        'config.' . $pi_name . '.tab_cpermissions'          => 'Access to configure link\'s category permissions',
        'config.' . $pi_name . '.tab_autotag_permissions'   => 'Access to configure link\'s autotag usage permissions'
    );

    $mappings = array(
        $pi_name . '.edit'                                  => array($pi_admin),
        $pi_name . '.moderate'                              => array($pi_admin),
        $pi_name . '.submit'                                => array($pi_admin),
        'config.' . $pi_name . '.tab_public'                => array($pi_admin),
        'config.' . $pi_name . '.tab_admin'                 => array($pi_admin),
        'config.' . $pi_name . '.tab_permissions'           => array($pi_admin),
        'config.' . $pi_name . '.tab_cpermissions'          => array($pi_admin),
        'config.' . $pi_name . '.tab_autotag_permissions'   => array($pi_admin)        
    );

    $tables = array(
        'linkcategories',
        'links',
        'linksubmission'
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
* @see      plugin_initconfig_links
*
*/
function plugin_load_configuration_links($pi_name)
{
    global $_CONF;

    $base_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $base_path . 'install_defaults.php';

    return plugin_initconfig_links();
}

/**
* Plugin postinstall
*
* We're inserting our default data here since it depends on other stuff that
* has to happen first ...
*
* @return   boolean     true = proceed with install, false = an error occured
*
*/
function plugin_postinstall_links($pi_name)
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $li_config = config::get_instance();
    $_LI_CONF = $li_config->get_config('links');

    $inst_parms = plugin_autoinstall_links($pi_name);
    $pi_admin = key($inst_parms['groups']);

    $admin_group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                 "grp_name = '{$pi_admin}'");
    $blockadmin_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                "grp_name = 'Block Admin'");

    $L_SQL = array();
    $L_SQL[] = "INSERT INTO {$_TABLES['linkcategories']} (cid, pid, category, description, tid, created, modified, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('{$_LI_CONF['root']}', 'root', 'Root', 'Website root', '', NOW(), NOW(), #group#, 2, 3, 3, 2, 2)";

    $L_SQL[] = "INSERT INTO {$_TABLES['linkcategories']} (cid, pid, category, description, tid, created, modified, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklog-sites', '{$_LI_CONF['root']}', 'Geeklog Sites', 'Sites using or related to the Geeklog CMS', NULL, NOW(), NOW(), #group#, 2, 3, 3, 2, 2)";

    $L_SQL[] = "INSERT INTO {$_TABLES['links']} (lid, cid, url, description, title, hits, date, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklog.net', 'geeklog-sites', 'http://www.geeklog.net/', 'Visit the Geeklog homepage for support, FAQs, updates, add-ons, and a great community.', 'Geeklog Project Homepage', 123, NOW(), 1, #group#, 3, 3, 2, 2);";

    foreach ($L_SQL as $sql) {
        $sql = str_replace('#group#', $admin_group_id, $sql);
        DB_query($sql, 1);
        if (DB_error()) {
            COM_errorLog("SQL error in Links plugin postinstall, SQL: " . $sql);
            return false;
        }
    }

    return true;
}

/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*
*/
function plugin_compatible_with_this_version_links($pi_name)
{
    global $_CONF, $_DB_dbms;

    // check if we support the DBMS the site is running on
    $dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/'
            . $_DB_dbms . '_install.php';
    if (! file_exists($dbFile)) {
        return false;
    }

    if (!function_exists('COM_truncate') || !function_exists('MBYTE_strpos')) {
        return false;
    }

    if (!function_exists('SEC_createToken')) {
        return false;
    }

    if (!function_exists('COM_showMessageText')) {
        return false;
    }

    if (!function_exists('SEC_getTokenExpiryNotice')) {
        return false;
    }

    if (!function_exists('SEC_loginRequiredForm')) {
        return false;
    }

    return true;
}

?>
