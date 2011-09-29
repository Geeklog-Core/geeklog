<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.9.0                                                             |
// +---------------------------------------------------------------------------+
// | lib-block.php                                                             |
// |                                                                           |
// | Geeklog syndication library.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tom Homer        - tomhomer AT gmail DOT com                     |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-block.php') !== false) {
    die('This file can not be used on its own!');
}

// set to true to enable debug output in error.log
$_BLOCK_DEBUG = false;

/**
* This function is called to inform plugins when a group's information has
* changed or a new group has been created.
*
* @param    int     $grp_id     Group ID
* @param    string  $mode       type of change: 'new', 'edit', or 'delete'
* @return   void
*
*/
function plugin_group_changed_block($grp_id, $mode)
{
    global $_TABLES, $_GROUPS;
    
    if ($mode == 'delete') {
        // Change any deleted group ids to Block Admin if exist, if does not change to root group
        $new_group_id = 0;
        if (isset($_GROUPS['Block Admin'])) {
            $new_group_id = $_GROUPS['Block Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Block Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }    
        
        // Update Block with new group id
        $sql = "UPDATE {$_TABLES['blocks']} SET group_id = $new_group_id WHERE group_id = $grp_id";        
        $result = DB_query($sql);
   }
}

?>