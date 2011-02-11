<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 1.0                                                     |
// +---------------------------------------------------------------------------+
// | mysql_install.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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
* @package XMLsitemap
*/

$_UPDATES = array(
    
    '1.0.0' => array(
        // Set new Tab column to whatever fieldset is
        "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'xmlsitemap'",   

        // Add new Core Admin Group for Configuration
        "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr, grp_gl_core) VALUES ('XMLSitemap Admin', 'Has full access to XMLSitemap features', 0);",
        
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.xmlsitemap.tab_main', 'Access to configure general XMLSitemap settings', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.xmlsitemap.tab_pri', 'Access to configure XMLSitemap priorities', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.xmlsitemap.tab_freq', 'Access to configure XMLSitemap update frequency', 0)"        
    )    
    
);

/**
 * Add is new security rights for the Group "XMLSitemap Admin"
 *
 */
function xmlsitemap_update_ConfigSecurity_1_0_0()
{
    global $_TABLES;
    
    // Add in security rights for XMLSitemap Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'XMLSitemap Admin'");

    if ($group_id > 0) {
        // Assign XMLSitemap Group to Root Group
        DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES ($group_id,NULL,1)");
        
        $ft_names[] = 'config.xmlsitemap.tab_main';
        $ft_names[] = 'config.xmlsitemap.tab_pri';
        $ft_names[] = 'config.xmlsitemap.tab_freq';
        
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
