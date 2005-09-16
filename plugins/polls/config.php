<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 1.0                                                          |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// |                                                                           |
// | Polls plugin configuration file                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
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
// $Id: config.php,v 1.4 2005/09/16 08:13:15 dhaun Exp $

$_PO_CONF['version']            = '1.0'; // Plugin Version

// Poll Settings

// when set to 1 will only allow logged-in users to view the list of past polls
// (also see $_CONF['loginrequired'] in Geeklog's config.php)
$_PO_CONF['pollsloginrequired'] = 0;

$_PO_CONF['maxanswers']         = 10; // max. number of options in a poll

// 'submitorder' is the order in which answers are saved in admin/poll.php
// 'voteorder' will list answers ordered by number of votes (highest->lowest);
$_PO_CONF['answerorder']        = 'submitorder';

// how long a poll is closed for a user after they've voted
$_PO_CONF['pollcookietime']     = 86400;  // seconds (= 24 hours)
$_PO_CONF['polladdresstime']    = 604800; // seconds (= 7 days)

// database table names - don't change
$_TABLES['pollanswers']         = $_DB_table_prefix . 'pollanswers';
$_TABLES['pollquestions']       = $_DB_table_prefix . 'pollquestions';
$_TABLES['pollvoters']          = $_DB_table_prefix . 'pollvoters';

?>
