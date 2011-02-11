<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Links Plugin 2.0                                                          |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Trinity Bays      - trinity93 AT gmail DOT com                   |
// |          Tom Homer         - tomhomer AT gmail DOT com                   |
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
* @package Links
*/

$_UPDATES = array(

    '2.1.0' => array(
        // Set new Tab column to whatever fieldset is
        "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'links'",   
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_public', 'Access to configure public links list settings', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_admin', 'Access to configure links admin settings', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_permissions', 'Access to configure link permissions', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_cpermissions', 'Access to configure link\'s category permissions', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_autotag_permissions', 'Access to configure link\'s autotag usage permissions', 0)"        
    )    
    
);

/**
 * Add is new security rights for the Group "Links Admin"
 *
 */
function links_update_ConfigSecurity_2_1_0()
{
    global $_TABLES;
    
    // Add in security rights for Links Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Links Admin'");

    if ($group_id > 0) {
        $ft_names[] = 'config.links.tab_public';
        $ft_names[] = 'config.links.tab_admin';
        $ft_names[] = 'config.links.tab_permissions';
        $ft_names[] = 'config.links.tab_cpermissions';
        $ft_names[] = 'config.links.tab_autotag_permissions';
        
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
