<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendar                                                                  |
// +---------------------------------------------------------------------------+
// | configuration_validation.php                                              |
// |                                                                           |
// | List of validation rules for the Links plugin configurations              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2020 by the following authors:                         |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// General Calendar Settings
$_CONF_VALIDATE['calendar']['calendarloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendar']['hidecalendarmenu'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendar']['personalcalendars'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendar']['eventsubmission'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendar']['showupcomingevents'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendar']['upcomingeventsrange'] = array('rule' => 'numeric');
$_CONF_VALIDATE['calendar']['hour_mode'] = array(
    'rule' => array('inList', array('12', '24'), true)
);
$_CONF_VALIDATE['calendar']['event_types'] = array('rule' => 'stringOrEmpty');
$_CONF_VALIDATE['calendar']['notification'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendar']['delete_event'] = array('rule' => 'boolean');
$_CONF_VALIDATE['calendar']['aftersave'] = array(
    'rule' => array('inList', array('item', 'list', 'plugin', 'home', 'admin'), true)
);
$_CONF_VALIDATE['calendar']['recaptcha'] = ['rule' => ['inList', ['0', '1', '2', '4'], true]];
$_CONF_VALIDATE['calendar']['recaptcha_score'] = ['rule' => ['range', 0, 1]];

// Default Permissions
$_CONF_VALIDATE['calendar']['default_permissions[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['calendar']['default_permissions[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['calendar']['default_permissions[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['calendar']['default_permissions[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);

// Autotag Usage Permissions
$_CONF_VALIDATE['calendar']['autotag_permissions_event[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['calendar']['autotag_permissions_event[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['calendar']['autotag_permissions_event[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['calendar']['autotag_permissions_event[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
