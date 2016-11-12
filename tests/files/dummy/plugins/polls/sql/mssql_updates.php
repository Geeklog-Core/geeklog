<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | mssql_updates.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun         - dirk AT haun-online DOT de                   |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* MS SQL updates
*
* @package Polls
*/

$_UPDATES = array(

    '2.0.1' => array(
        "ALTER TABLE {$_TABLES['pollanswers']} ALTER COLUMN [pid] VARCHARS(40)",
        "ALTER TABLE {$_TABLES['pollquestions']} ALTER COLUMN [pid] VARCHARS(40)",
        "ALTER TABLE {$_TABLES['polltopics']} ALTER COLUMN [pid] VARCHARS(40)",
        "ALTER TABLE {$_TABLES['pollvoters']} ALTER COLUMN [pid] VARCHARS(40)"
    )

);

?>
