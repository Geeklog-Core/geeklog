<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | configuration.php                                                         |
// |                                                                           |
// | Loads the administration UI and sends input to config.class               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
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
// $Id: configuration.php,v 1.4 2008/01/13 21:47:15 blaine Exp $

require_once '../lib-common.php';
require_once 'auth.inc.php';

$conf_group = array_key_exists('conf_group', $_POST) ? $_POST['conf_group'] : 'Core';

$config =& config::get_instance();


function configmanager_menu() {
    global $config,$conf_group,$LANG_configsubgroups;

    $retval = COM_startBlock( 'Config Sections', '', 'blockheader.thtml');

    $groups = $config->_get_groups();
    if (count($groups) > 0) {
        foreach ($groups as $group) {
            $group_display = ucwords($group);
            $retval .= "<div><a href=\"#\" onclick='open_group(\"$group\")'>$group_display</a></div>";
        }
    }
    $retval .= COM_endBlock('blockfooter.thtml');

    $subgroup_title = ucwords($conf_group);
    $retval .= COM_startBlock( $subgroup_title, '', 'blockheader.thtml');

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
