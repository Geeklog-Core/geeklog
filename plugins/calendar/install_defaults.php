<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendar plugin 1.0                                                       |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT gmail DOT com                   |
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
// $Id: install_defaults.php,v 1.8 2008/09/21 08:37:08 dhaun Exp $

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * Calendar default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */
global $_CA_DEFAULT;
$_CA_DEFAULT = array();

// when set to 1 will only allow logged-in users to view the list of past events
// (also see $_CONF['loginrequired'] in Geeklog's main configuration)
$_CA_DEFAULT['calendarloginrequired']   = 0;

// enable (set to 1) or disable (set to 0) submission queues:
$_CA_DEFAULT['eventsubmission'] = 1;

// Set to 1 to hide the "Calendar" entry from the top menu:
$_CA_DEFAULT['hidecalendarmenu']    = 0;

// Calendar Settings
$_CA_DEFAULT['personalcalendars']     = 1;
$_CA_DEFAULT['showupcomingevents']    = 1;
$_CA_DEFAULT['upcomingeventsrange']   = 14; // days
$_CA_DEFAULT['event_types']           = "Anniversary,Appointment,Birthday,Business,"
                                    ."Education,Holiday,Meeting,Miscellaneous,"
                                    ."Personal,Phone Call,Special Occasion,"
                                    ."Travel,Vacation";

// Whether to use 12 hour (am/pm) or 24 hour mode
$_CA_DEFAULT['hour_mode'] = 12; // 12 hour am/pm or 24 hour format

// notify when a new event was submitted for the site calendar (when set = 1)
$_CA_DEFAULT['notification'] = 0;

// When a user is deleted, ownership of events created by that user can
// be transfered to a user in the Root group (= 0) or the events can be
// deleted (= 1).
$_CA_DEFAULT['delete_event'] = 0;

/** What to show after a event has been saved? Possible choices:
 * 'item' -> forward to the event
 * 'list' -> display the admin-list of the calendar
 * 'plugin' -> display the public homepage of the calendar plugin
 * 'home' -> display the site homepage
 * 'admin' -> display the site admin homepage
 */
$_CA_DEFAULT['aftersave'] = 'list';

// Events Block
$_CA_DEFAULT['block_isleft'] = 1;
$_CA_DEFAULT['block_order'] = 50;
$_CA_DEFAULT['block_topic_option'] = TOPIC_ALL_OPTION;
$_CA_DEFAULT['block_topic'] = array();
$_CA_DEFAULT['block_enable'] = true;
$_CA_DEFAULT['block_permissions'] = array (2, 2, 2, 2);

// Define default permissions for new events created from the Admin panel.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 3 = read + write permissions (perm_owner and perm_group only)
// 2 = read-only
// 0 = neither read nor write permissions
// (a value of 1, ie. write-only, does not make sense and is not allowed)
$_CA_DEFAULT['default_permissions'] = array(3, 2, 2, 2);

// Define default usuage permissions for the calendar autotags.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 2 = use
// 0 = cannot use
// (a value of 1 is not allowed)
$_CA_DEFAULT['autotag_permissions_event'] = array (2, 2, 2, 2);

/**
* Initialize Calendar plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_CA_CONF if available (e.g. from
* an old config.php), uses $_CA_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_calendar()
{
    global $_CONF, $_CA_CONF, $_CA_DEFAULT, $_TABLES, $_GROUPS;

    if (is_array($_CA_CONF) && (count($_CA_CONF) > 1)) {
        $_CA_DEFAULT = array_merge($_CA_DEFAULT, $_CA_CONF);
    }

    $c = config::get_instance();
    if (!$c->group_exists('calendar')) {

        if (isset($_CONF['hour_mode'])) {
            $_CA_DEFAULT['hour_mode'] = $_CONF['hour_mode'];
        }

        // 'event_types' used to be a comma-separated list but that would be
        // clumsy to handle in the GUI, so let's make it an array
        if (!is_array($_CA_DEFAULT['event_types'])) {
            $_CA_DEFAULT['event_types'] = explode(',', $_CA_DEFAULT['event_types']);

            $num_types = count($_CA_DEFAULT['event_types']);
            for ($i = 0; $i < $num_types; $i++) {
                $_CA_DEFAULT['event_types'][$i] = trim($_CA_DEFAULT['event_types'][$i]);
            }
        }

        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'calendar', 0);
        $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'calendar', 0);
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, true, 'calendar', 0);
        $c->add('calendarloginrequired', $_CA_DEFAULT['calendarloginrequired'],
                'select', 0, 0, 0, 10, true, 'calendar', 0);
        $c->add('hidecalendarmenu', $_CA_DEFAULT['hidecalendarmenu'],
                'select', 0, 0, 1, 20, true, 'calendar', 0);
        $c->add('personalcalendars', $_CA_DEFAULT['personalcalendars'],
                'select', 0, 0, 1, 30, true, 'calendar', 0);
        $c->add('eventsubmission', $_CA_DEFAULT['eventsubmission'],
                'select', 0, 0, 0, 40, true, 'calendar', 0);
        $c->add('showupcomingevents', $_CA_DEFAULT['showupcomingevents'],
                'select', 0, 0, 0, 50, true, 'calendar', 0);
        $c->add('upcomingeventsrange', $_CA_DEFAULT['upcomingeventsrange'],
                'text', 0, 0, 0, 60, true, 'calendar', 0);
        $c->add('hour_mode', $_CA_DEFAULT['hour_mode'],
                'select', 0, 0, 6, 70, true, 'calendar', 0);
        $c->add('event_types', $_CA_DEFAULT['event_types'],
                '%text', 0, 0, NULL, 80, true, 'calendar', 0);
        $c->add('notification', $_CA_DEFAULT['notification'],
                'select', 0, 0, 0, 90, true, 'calendar', 0);
        $c->add('delete_event', $_CA_DEFAULT['delete_event'],
                'select', 0, 0, 0, 100, true, 'calendar', 0);
        $c->add('aftersave', $_CA_DEFAULT['aftersave'],
                'select', 0, 0, 9, 110, true, 'calendar', 0);

        $c->add('tab_permissions', NULL, 'tab', 0, 1, NULL, 0, true, 'calendar', 1);
        $c->add('fs_permissions', NULL, 'fieldset', 0, 1, NULL, 0, true, 'calendar', 1);
        $c->add('default_permissions', $_CA_DEFAULT['default_permissions'],
                '@select', 0, 1, 12, 120, true, 'calendar', 1);
        
        $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'calendar', 10);
        $c->add('fs_autotag_permissions', NULL, 'fieldset', 0, 10, NULL, 0, true, 'calendar', 10);
        $c->add('autotag_permissions_event', $_CA_DEFAULT['autotag_permissions_event'], '@select', 
                0, 10, 13, 10, true, 'calendar', 10);   
        
        $c->add('tab_events_block', NULL, 'tab', 0, 20, NULL, 0, true, 'calendar', 20);
        $c->add('fs_block_settings', NULL, 'fieldset', 0, 10, NULL, 0, true, 'calendar', 20);
        $c->add('block_enable', $_CA_DEFAULT['block_enable'], 'select', 
                0, 10, 0, 10, true, 'calendar', 20);
        $c->add('block_isleft', $_CA_DEFAULT['block_isleft'], 'select', 
                0, 10, 0, 20, true, 'calendar', 20);
        $c->add('block_order', $_CA_DEFAULT['block_order'], 'text',
                0, 10, 0, 30, true, 'calendar', 20);
        $c->add('block_topic_option', $_CA_DEFAULT['block_topic_option'],'select',
                0, 10, 15, 40, true, 'calendar', 20);  
        $c->add('block_topic', $_CA_DEFAULT['block_topic'], '%select',
                0, 10, NULL, 50, true, 'calendar', 20);
        
        $c->add('fs_block_permissions', NULL, 'fieldset', 0, 20, NULL, 0, true, 'calendar', 20);
        $new_group_id = 0;
        if (isset($_GROUPS['Calendar Admin'])) {
            $new_group_id = $_GROUPS['Calendar Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Calendar Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }         
        $c->add('block_group_id', $new_group_id,'select',
                0, 20, NULL, 10, TRUE, 'calendar', 20);        
        $c->add('block_permissions', $_CA_DEFAULT['block_permissions'], '@select', 
                0, 20, 14, 20, true, 'calendar', 20);         
    }

    return true;
}

?>
