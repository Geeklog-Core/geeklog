<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | configuration.php                                                         |
// |                                                                           |
// | Loads the administration UI and sends input to config.class               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Aaron Blankstein  - kantai AT gmail DOT com                      |
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
* Geeklog common function library
*/
require_once '../lib-common.php';
require_once 'auth.inc.php';

/**
* Helper function: Provide language dropdown
*
* NOTE:     Note that key/value are being swapped!
*
* @return   array   Array of (filename, displayname) pairs
*
*/
function configmanager_select_language_helper()
{
    global $_CONF;

    return array_flip(MBYTE_languageList($_CONF['default_charset']));
}

/**
* Helper function: Provide themes dropdown
*
* NOTE:     Beautifying code duplicated from usersettings.php
*
* @return   array   Array of (filename, displayname) pairs
*
*/
function configmanager_select_theme_helper()
{
    $themes = array();

    $themeFiles = COM_getThemes(true);
    usort($themeFiles, 'strcasecmp');

    foreach ($themeFiles as $theme) {
        $words = explode('_', $theme);
        $bwords = array();
        foreach ($words as $th) {
            if ((strtolower($th[0]) == $th[0]) &&
                (strtolower($th[1]) == $th[1])) {
                $bwords[] = ucfirst($th);
            } else {
                $bwords[] = $th;
            }
        }

        $themes[implode(' ', $bwords)] = $theme;
    }

    return $themes;
}

/**
* Helper function: Provide timezone dropdown
*
* @return   array   Array of (timezone-long-name, timezone-short-name) pairs
*
*/
function configmanager_select_timezone_helper()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/timezoneconfig.class.php';

    return array_flip(TimeZoneConfig::listAvailableTimeZones());
}

/**
* Helper function: Provide dropdown for Permanent Cookie Timeout
*
* @return   array   Array of (description, timeout-in-seconds) pairs
*
*/
function configmanager_select_default_perm_cookie_timeout_helper()
{
    global $_TABLES, $LANG_cookiecodes;

    $retval = array();

    $result = DB_query("SELECT cc_value,cc_descr FROM {$_TABLES['cookiecodes']}");
    $num_values = DB_numRows($result);

    for ($i = 0; $i < $num_values; $i++) {
        list($cc_value, $cc_descr) = DB_fetchArray($result);
        $cc_descr = $LANG_cookiecodes[$cc_value];
        $retval[$cc_descr] = $cc_value;
    }
    
    return $retval;
}


// MAIN
$display = '';

$conf_group = array_key_exists('conf_group', $_POST)
            ? $_POST['conf_group'] : 'Core';
$config =& config::get_instance();

if (array_key_exists('set_action', $_POST) && SEC_checkToken()){
    if (SEC_inGroup('Root')) {
        if ($_POST['set_action'] == 'restore') {
            $config->restore_param($_POST['name'], $conf_group);
        } elseif ($_POST['set_action'] == 'unset') {
            $config->unset_param($_POST['name'], $conf_group);
        }
    }
    $display = $config->get_ui($conf_group, array_key_exists('subgroup', $_POST)
                                            ?  $_POST['subgroup'] : null);
} elseif (array_key_exists('form_submit', $_POST) && SEC_checkToken()) {
    $result = null;
    if (! array_key_exists('form_reset', $_POST)) {
        $result = $config->updateConfig($_POST, $conf_group);

        // notify plugins
        if (is_array($result) && (count($result) > 0)) {
            PLG_configChange($conf_group, array_keys($result));
        }
    }
    $display = $config->get_ui($conf_group, $_POST['sub_group'], $result);
} else {
    $display = $config->get_ui($conf_group, array_key_exists('subgroup', $_POST)
                                            ?  $_POST['subgroup'] : null);
}

COM_output($display);

?>
