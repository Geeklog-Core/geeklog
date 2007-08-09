<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 1.0                                                          |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// |                                                                           |
// | Polls plugin configuration file                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT steubentech DOT com             |
// |          Oliver Spiesshofer - oliver AT spiesshofer DOT com               |
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
// $Id: config.php,v 1.12 2007/08/09 07:03:34 ospiess Exp $

$_PO_CONF['version']            = '2.0.1'; // Plugin Version

// Poll Settings

// when set to 1 will only allow logged-in users to view the list of past polls
// (also see $_CONF['loginrequired'] in Geeklog's config.php)
$_PO_CONF['pollsloginrequired'] = 0;


// Set to 1 to hide the "Polls" entry from the top menu:
$_PO_CONF['hidepollsmenu']      = 0;

$_PO_CONF['maxquestions']       = 10; // max. number of questions in a poll
$_PO_CONF['splitpages']         = false;
// show all questions for one poll on
// the same page or one question per page?
$_PO_CONF['maxanswers']         = 10; // max. number of options in a question

// 'submitorder' is the order in which answers are saved in admin/poll.php
// 'voteorder' will list answers ordered by number of votes (highest->lowest);
$_PO_CONF['answerorder']        = 'submitorder';

// how long a poll is closed for a user after they've voted
$_PO_CONF['pollcookietime']     = 86400;  // seconds (= 24 hours)
$_PO_CONF['polladdresstime']    = 604800; // seconds (= 7 days)

// When a user is deleted, ownership of polls created by that user can
// be transfered to a user in the Root group (= 0) or the polls can be
// deleted (= 1).
$_PO_CONF['delete_polls'] = 0;

/** What to show after a poll has been saved? Possible choices:
 * 'item' -> forward to the poll
 * 'list' -> display the admin-list of poll
 * 'plugin' -> display the public homepage of the poll plugin
 * 'home' -> display the site homepage
 * 'admin' -> display the site admin homepage
 */
$_PO_CONF['aftersave'] = 'plugin';

// Define default permissions for new polls created from the Admin panel.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 3 = read + write permissions (perm_owner and perm_group only)
// 2 = read-only
// 0 = neither read nor write permissions
// (a value of 1, ie. write-only, does not make sense and is not allowed)
$_PO_CONF['default_permissions'] = array (3, 2, 2, 2);

// database table names - don't change
$_TABLES['pollanswers']         = $_DB_table_prefix . 'pollanswers';
$_TABLES['pollquestions']       = $_DB_table_prefix . 'pollquestions';
$_TABLES['polltopics']          = $_DB_table_prefix . 'polltopics';
$_TABLES['pollvoters']          = $_DB_table_prefix . 'pollvoters';

?>
