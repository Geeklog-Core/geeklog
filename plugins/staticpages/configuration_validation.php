<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages                                                              |
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

// Static Pages Main Settings
$_CONF_VALIDATE['staticpages']['allow_php'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['sort_by'] = array(
    'rule' => array('inList', array('date', 'id', 'title'), true)
);    
$_CONF_VALIDATE['staticpages']['sort_menu_by'] = array(
    'rule' => array('inList', array('date', 'id', 'title', 'label'), true)
);    
$_CONF_VALIDATE['staticpages']['sort_list_by'] = array(
    'rule' => array('inList', array('date', 'id', 'title', 'author'), true)
);    
$_CONF_VALIDATE['staticpages']['delete_pages'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['in_block'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['show_hits'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['show_date'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['filter_html'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['censor'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['aftersave'] = array(
    'rule' => array('inList', array('item', 'list', 'plugin', 'home', 'admin'), true)
);
$_CONF_VALIDATE['staticpages']['atom_max_items'] = array('rule' => 'numeric');
$_CONF_VALIDATE['staticpages']['meta_tags'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['comment_code'] = array(
    'rule' => array('inList', array('0', '-1'), true)
);
$_CONF_VALIDATE['staticpages']['draft_flag'] = array('rule' => 'boolean');

// What's New Block
$_CONF_VALIDATE['staticpages']['newstaticpagesinterval'] = array('rule' => 'numeric');
$_CONF_VALIDATE['staticpages']['hidenewstaticpages'] = array(
    'rule' => array('inList', array('hide', 'modified', 'created'), true)
);
$_CONF_VALIDATE['staticpages']['title_trim_length'] = array('rule' => 'numeric');
$_CONF_VALIDATE['staticpages']['includecenterblocks'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['includephp'] = array('rule' => 'boolean');

// Search Results
$_CONF_VALIDATE['staticpages']['includesearch'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['includesearchcenterblocks'] = array('rule' => 'boolean');
$_CONF_VALIDATE['staticpages']['includesearchphp'] = array('rule' => 'boolean');

// Default Permissions
$_CONF_VALIDATE['staticpages']['default_permissions[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['staticpages']['default_permissions[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['staticpages']['default_permissions[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['staticpages']['default_permissions[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);

// Autotag Usage Permissions
$_CONF_VALIDATE['staticpages']['autotag_permissions_staticpage[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['staticpages']['autotag_permissions_staticpage[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['staticpages']['autotag_permissions_staticpage[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['staticpages']['autotag_permissions_staticpage[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);

$_CONF_VALIDATE['staticpages']['autotag_permissions_staticpage_content[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['staticpages']['autotag_permissions_staticpage_content[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['staticpages']['autotag_permissions_staticpage_content[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['staticpages']['autotag_permissions_staticpage_content[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);

?>
