<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Spam-X Plugin 1.2                                                         |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tom Willett       - tomw AT pigstye DOT net                      |
// |          Randy Kolenko     - randy AT nextide DOT ca                      |
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
* @package Spam-X
*/

$_SQL[] = "
CREATE TABLE [dbo].[{$_TABLES['spamx']}] (
    [name] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
    [value] [varchar] (255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL 
) ON [PRIMARY]
";

$DEFVALUES[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('spamx.counter', '0')";

?>
