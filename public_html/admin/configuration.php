<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | configuration.php                                                         |
// |                                                                           |
// | Loads the administration UI and sends input to config.class               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Aaron Blankstein  - kantai AT gmail DOT com                      |
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
// $Id: configuration.php,v 1.7 2008/01/26 11:59:36 dhaun Exp $

require_once '../lib-common.php';
require_once 'auth.inc.php';

$conf_group = array_key_exists('conf_group', $_POST) ? $_POST['conf_group'] : 'Core';

$config =& config::get_instance();


function configmanager_menu()
{
    global $_CONF, $config, $conf_group,
           $LANG01, $LANG_ADMIN, $LANG_config, $LANG_configsubgroups;

    $retval = COM_startBlock($LANG01[131], '', 'blockheader.thtml');
    $retval .= '<div><a href="' . $_CONF['site_admin_url'] . '">'
            . $LANG_ADMIN['admin_home'] . '</a></div>';

    $groups = $config->_get_groups();
    if (count($groups) > 0) {
        foreach ($groups as $group) {
            if (empty($LANG_config[$group]['label'])) {
                $group_display = ucwords($group);
            } else {
                $group_display = $LANG_config[$group]['label'];
            }
            $retval .= "<div><a href=\"#\" onclick='open_group(\"$group\")'>$group_display</a></div>";
        }
    }
    $retval .= COM_endBlock('blockfooter.thtml');

    if (empty($LANG_config[$conf_group]['title'])) {
        $subgroup_title = ucwords($conf_group);
    } else {
        $subgroup_title = $LANG_config[$conf_group]['title'];
    }
    $retval .= COM_startBlock($subgroup_title, '', 'blockheader.thtml');

    $groups = $config->get_sgroups($conf_group);
    if (count($groups) > 0) {
        foreach ($groups as $group) {
            $group_display =  $LANG_configsubgroups[$conf_group][$group];
            $retval .= "<div><a href=\"#\" onclick='open_subgroup(\"$conf_group\",\"$group\")'>$group_display</a></div>";
        }
    }
    $retval .= COM_endBlock('blockfooter.thtml');

    return $retval;
}

/**
* Helper function: Provide language dropdown
*
* @return   Array   Array of (filename, displayname) pairs
*
* @note     Note that key/value are being swapped!
*
*/
function configmanager_languageList()
{
    global $_CONF;

    return array_flip(MBYTE_languageList($_CONF['default_charset']));
}

/**
* Helper function: Provide themes dropdown
*
* @return   Array   Array of (filename, displayname) pairs
*
* @note     Beautifying code duplicated from usersettings.php
*
*/
function configmanager_themeList()
{
    $themes = array();

    $themeFiles = COM_getThemes(true);
    usort($themeFiles,
          create_function('$a,$b', 'return strcasecmp($a,$b);'));

    foreach ($themeFiles as $theme) {
        $words = explode ('_', $theme);
        $bwords = array ();
        foreach ($words as $th) {
            if ((strtolower ($th{0}) == $th{0}) &&
                (strtolower ($th{1}) == $th{1})) {
                $bwords[] = strtoupper ($th{0}) . substr ($th, 1);
            } else {
                $bwords[] = $th;
            }
        }

        $themes[implode(' ', $bwords)] = $theme;
    }

    return $themes;
}


// MAIN
if (array_key_exists('set_action', $_POST)){
    if (SEC_inGroup('Root')) {
        if ($_POST['set_action'] == 'restore') {
            $config->restore_param($_POST['name'], $conf_group);
        } elseif ($_POST['set_action'] == 'unset') {
            $config->unset_param($_POST['name'], $conf_group);
        }
    }
}

if (array_key_exists('form_submit', $_POST)) {
    $result = null;
    if (! array_key_exists('form_reset', $_POST)) {
        $result = $config->updateConfig($_POST, $conf_group);
    }
    echo $config->get_ui($conf_group, $_POST['sub_group'], $result);
} else {
    echo $config->get_ui($conf_group, array_key_exists('subgroup', $_POST) ?
                         $_POST['subgroup'] : null);
}

?>
