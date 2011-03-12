<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Links                                                              |
// +---------------------------------------------------------------------------+
// | configuration_validation.php                                              |
// |                                                                           |
// | List of validation rules for the Links plugin configurations                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Akeda Bagus       - admin AT gedex DOT web DOT id                |
// |          Tom Homer         - tomhomer AT gmail DOT com                    |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'configuration_validation.php') !== false) {
    die('This file can not be used on its own!');
}

// Public Links List Settings
$_CONF_VALIDATE['links']['linksloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['links']['linkcols'] = array('rule' => 'numeric');
$_CONF_VALIDATE['links']['linksperpage'] = array('rule' => 'numeric');
$_CONF_VALIDATE['links']['show_top10'] = array('rule' => 'boolean');
$_CONF_VALIDATE['links']['show_category_descriptions'] = array('rule' => 'boolean');
$_CONF_VALIDATE['links']['new_window'] = array('rule' => 'boolean');

// Links Admin Settings
$_CONF_VALIDATE['links']['hidenewlinks'] = array('rule' => 'boolean');
$_CONF_VALIDATE['links']['newlinksinterval'] = array('rule' => 'numeric');
$_CONF_VALIDATE['links']['hidelinksmenu'] = array('rule' => 'boolean');
$_CONF_VALIDATE['links']['linksubmission'] = array('rule' => 'boolean');
$_CONF_VALIDATE['links']['notification'] = array('rule' => 'boolean');
$_CONF_VALIDATE['links']['delete_links'] = array('rule' => 'boolean');
$_CONF_VALIDATE['links']['aftersave'] = array(
    'rule' => array('inList', array('item', 'list', 'plugin', 'home', 'admin'), true)
);
$_CONF_VALIDATE['links']['root'] = array('rule' => 'notEmpty');

// Link Permissions
$_CONF_VALIDATE['links']['default_permissions[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['links']['default_permissions[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['links']['default_permissions[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['links']['default_permissions[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);

// Category Permissions
$_CONF_VALIDATE['links']['category_permissions[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['links']['category_permissions[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['links']['category_permissions[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['links']['category_permissions[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);

// Autotag Usage Permissions
$_CONF_VALIDATE['links']['autotag_permissions_link[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['links']['autotag_permissions_link[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['links']['autotag_permissions_link[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['links']['autotag_permissions_link[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);

?>
