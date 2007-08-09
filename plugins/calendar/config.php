<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendar Plugin 1.0                                                       |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// |                                                                           |
// | Calendar plugin configuration file                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT steubentech DOT com             |
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
// $Id: config.php,v 1.11 2007/08/09 07:09:29 ospiess Exp $

$_CA_CONF['version']            = '1.0.2'; // Plugin Version

// Calendar Settings

// when set to 1 will only allow logged-in users to view the list of past events
// (also see $_CONF['loginrequired'] in Geeklog's config.php)
$_CA_CONF['calendarloginrequired']   = 0;

// enable (set to 1) or disable (set to 0) submission queues:
$_CA_CONF['eventsubmission'] = 1;

/**
 * Set to 1 to hide the "Calendar" entry from the top menu:
 *
 * @global array $_CA_CONF['hidecalendarmenu']
 */
$_CA_CONF['hidecalendarmenu']    = 0;

// Calendar Settings
$_CA_CONF['personalcalendars']     = 1;
$_CA_CONF['showupcomingevents']    = 1;
$_CA_CONF['upcomingeventsrange']   = 14; // days
$_CA_CONF['event_types']           = "Anniversary,Appointment,Birthday,Business,"
                                    ."Education,Holiday,Meeting,Miscellaneous,"
                                    ."Personal,Phone Call,Special Occasion,"
                                    ."Travel,Vacation";

// Whether to use 12 hour (am/pm) or 24 hour mode
$_CA_CONF['hour_mode'] = $_CONF['hour_mode']; // 12 hour am/pm or 24 hour format

// notify when a new event was submitted for the site calendar (when set = 1)
$_CA_CONF['notification'] = 0;

// When a user is deleted, ownership of events created by that user can
// be transfered to a user in the Root group (= 0) or the events can be
// deleted (= 1).
$_CA_CONF['delete_event'] = 0;

/** What to show after a event has been saved? Possible choices:
 * 'item' -> forward to the event
 * 'list' -> display the admin-list of the calendar
 * 'plugin' -> display the public homepage of the calendar plugin
 * 'home' -> display the site homepage
 * 'admin' -> display the site admin homepage
 */
$_CA_CONF['aftersave'] = 'item';

// Define default permissions for new events created from the Admin panel.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 3 = read + write permissions (perm_owner and perm_group only)
// 2 = read-only
// 0 = neither read nor write permissions
// (a value of 1, ie. write-only, does not make sense and is not allowed)
$_CA_CONF['default_permissions'] = array (3, 2, 2, 2);

// database table names - don't change
$_TABLES['events']              = $_DB_table_prefix . 'events';
$_TABLES['eventsubmission']     = $_DB_table_prefix . 'eventsubmission';
$_TABLES['personal_events']     = $_DB_table_prefix . 'personal_events';

?>
