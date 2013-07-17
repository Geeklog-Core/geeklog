<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | mssql_updates.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 by the following authors:                         |
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
* PG SQL updates
*
* @package Polls
*/

$_UPDATES = array(

    '2.1.2' => array(
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.polls.tab_whatsnew', 'Access to configure polls what\'s new block', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.polls.tab_main', 'Access to configure general polls settings', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.polls.tab_permissions', 'Access to configure polls default permissions', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.polls.tab_autotag_permissions', 'Access to configure polls autotag usage permissions', 0)"        
    ),     

    '2.1.3' => array(
        // Delete Poll block since moved to dynamic
        "DELETE FROM {$_TABLES['blocks']} WHERE phpblockfn = 'phpblock_polls'", 
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.polls.tab_poll_block', 'Access to configure poll block', 0)"
    ), 
    
    '2.1.4' => array(
        // Poll Id now 128 characters
        "ALTER TABLE {$_TABLES['pollanswers']} CHANGE `pid` `pid` VARCHAR(128) NOT NULL DEFAULT ''", 
        "ALTER TABLE {$_TABLES['pollquestions']} CHANGE `pid` `pid` VARCHAR(128) NOT NULL DEFAULT ''",
        "ALTER TABLE {$_TABLES['polltopics']} CHANGE `pid` `pid` VARCHAR(128) NOT NULL DEFAULT ''",
        "ALTER TABLE {$_TABLES['pollvoters']} CHANGE `pid` `pid` VARCHAR(128) NOT NULL"
    )
    
);

/**
 * Add is new security rights for the Group "Polls Admin"
 *
 */
function polls_update_ConfigSecurity_2_1_2()
{
    global $_TABLES;
    
    // Add in security rights for Polls Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Polls Admin'");

    if ($group_id > 0) {
        $ft_names[] = 'config.polls.tab_whatsnew';
        $ft_names[] = 'config.polls.tab_main';
        $ft_names[] = 'config.polls.tab_permissions';
        $ft_names[] = 'config.polls.tab_autotag_permissions';
        
        foreach ($ft_names as $name) {
            $ft_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$name'");         
            if ($ft_id > 0) {
                $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $group_id)";
                DB_query($sql);
            }
        }        
    }    

}

/**
 * Add in new security rights for the Group "Polls Admin"
 *
 */
function polls_update_ConfigSecurity_2_1_3()
{
    global $_TABLES;
    
    // Add in security rights for Polls Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Polls Admin'");

    if ($group_id > 0) {
        $ft_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'config.polls.tab_poll_block'");   
        $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $group_id)";
        DB_query($sql);    
    }    

}

?>
