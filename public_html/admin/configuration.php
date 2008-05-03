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
// $Id: configuration.php,v 1.13 2008/05/03 15:09:13 mjervis Exp $

require_once '../lib-common.php';
require_once 'auth.inc.php';

$conf_group = array_key_exists('conf_group', $_POST) ? $_POST['conf_group'] : 'Core';

$config =& config::get_instance();

/**
* Helper function: Provide language dropdown
*
* @return   Array   Array of (filename, displayname) pairs
*
* @note     Note that key/value are being swapped!
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
* @return   Array   Array of (filename, displayname) pairs
*
* @note     Beautifying code duplicated from usersettings.php
*
*/
function configmanager_select_theme_helper()
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

$tokenstate = SEC_checkToken();

// MAIN
if (array_key_exists('set_action', $_POST) && $tokenstate){
    if (SEC_inGroup('Root')) {
        if ($_POST['set_action'] == 'restore') {
            $config->restore_param($_POST['name'], $conf_group);
        } elseif ($_POST['set_action'] == 'unset') {
            $config->unset_param($_POST['name'], $conf_group);
        }
    }
}

if (array_key_exists('form_submit', $_POST) && $tokenstate) {
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
