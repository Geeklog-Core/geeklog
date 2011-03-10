<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Spam-X Plugin 1.2                                                         |
// +---------------------------------------------------------------------------+
// | Upgrade SQL                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 by the following authors:                              |
// |                                                                           |
// | Authors: Tom Homer        - websitemaster AT cogeco DOT net               |
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
* MySQL updates
*
* @package Spam-X
*/

$_UPDATES = array(

    '1.2.0' => array(
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) VALUES ('spamx.skip', 'Skip checking posts for Spam')",
        "UPDATE {$_TABLES['plugins']} SET pi_homepage = 'http://www.geeklog.net/' WHERE pi_name = 'spamx'"
    ),
    
    '1.2.1' => array(
        // Set new Tab column to whatever fieldset is
        "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'spamx'",   
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.spamx.tab_main', 'Access to configure Spam-x main settings', 0)",
        // Rename the action config option since it is causes JavaScript issues in the config and IE 8
        "UPDATE {$_TABLES['conf_values']} SET name = 'spamx_name' WHERE name = 'action'"
    )    
    
);

/**
 * Add is new security rights for the Group "Spamx Admin"
 *
 */
function spamx_update_ConfigSecurity_1_2_1()
{
    global $_TABLES;
    
    // Add in security rights for Spam-x Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Spamx Admin'");

    if ($group_id > 0) {
        $ft_names[] = 'config.spamx.tab_main';
        
        foreach ($ft_names as $name) {
            $ft_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$name'");         
            if ($ft_id > 0) {
                $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $group_id)";
                DB_query($sql);
            }
        }        
    }    

}

?>
