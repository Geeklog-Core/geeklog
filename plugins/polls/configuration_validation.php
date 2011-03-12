<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls                                                              |
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

// General Polls Settings
$_CONF_VALIDATE['polls']['pollsloginrequired'] = array('rule' => 'boolean');
$_CONF_VALIDATE['polls']['hidepollsmenu'] = array('rule' => 'boolean');
$_CONF_VALIDATE['polls']['maxquestions'] = array('rule' => 'numeric');
$_CONF_VALIDATE['polls']['maxanswers'] = array('rule' => 'numeric');
$_CONF_VALIDATE['polls']['answerorder'] = array(
    'rule' => array('inList', array('submitorder', 'voteorder'), true)
);
$_CONF_VALIDATE['polls']['pollcookietime'] = array('rule' => 'numeric');
$_CONF_VALIDATE['polls']['polladdresstime'] = array('rule' => 'numeric');
$_CONF_VALIDATE['polls']['delete_polls'] = array('rule' => 'boolean');
$_CONF_VALIDATE['polls']['aftersave'] = array(
    'rule' => array('inList', array('item', 'list', 'plugin', 'home', 'admin'), true)
);
$_CONF_VALIDATE['polls']['meta_tags'] = array('rule' => 'boolean');

// What's New Block
$_CONF_VALIDATE['polls']['newpollsinterval'] = array('rule' => 'numeric');
$_CONF_VALIDATE['polls']['hidenewpolls'] = array(    
    'rule' => array('inList', array('hide', 'modified', 'created'), true)
);
$_CONF_VALIDATE['polls']['title_trim_length'] = array('rule' => 'numeric');

// Default Permissions
$_CONF_VALIDATE['polls']['default_permissions[0]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['polls']['default_permissions[1]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['polls']['default_permissions[2]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);
$_CONF_VALIDATE['polls']['default_permissions[3]'] = array(
    'rule' => array('inList', array(0, 2, 3), true)
);

// Autotag Usage Permissions
$_CONF_VALIDATE['polls']['autotag_permissions_poll[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['polls']['autotag_permissions_poll[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['polls']['autotag_permissions_poll[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['polls']['autotag_permissions_poll[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);

$_CONF_VALIDATE['polls']['autotag_permissions_poll_vote[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['polls']['autotag_permissions_poll_vote[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['polls']['autotag_permissions_poll_vote[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['polls']['autotag_permissions_poll_vote[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);

$_CONF_VALIDATE['polls']['autotag_permissions_poll_result[0]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['polls']['autotag_permissions_poll_result[1]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['polls']['autotag_permissions_poll_result[2]'] = array(
    'rule' => array('inList', array(0, 2), true)
);
$_CONF_VALIDATE['polls']['autotag_permissions_poll_result[3]'] = array(
    'rule' => array('inList', array(0, 2), true)
);

?>
