<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | Upgrade SQL                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
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
* PostgreSQL updates
*
* @package StaticPages
*/

$_UPDATES = array(

    '1.6.2' => array(
        "ALTER TABLE {$_TABLES['staticpage']} ADD template_flag int default '0' AFTER meta_keywords",
        "ALTER TABLE {$_TABLES['staticpage']} ADD template_id varchar(40) NOT NULL default '' AFTER template_flag"
    ),
    
    '1.6.3' => array(
        // Set new Tab column to whatever fieldset is
        "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'staticpages'",   
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.staticpages.tab_main', 'Access to configure static pages main settings', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.staticpages.tab_whatsnew', 'Access to configure static pages what\'s new block', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.staticpages.tab_search', 'Access to configure static pages search results', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.staticpages.tab_permissions', 'Access to configure static pages default permissions', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.staticpages.tab_autotag_permissions', 'Access to configure static pages autotag usage permissions', 0)"
    )    
);

/**
 * Add is new security rights for the Group "Static Page Admin"
 *
 */
function sp_update_ConfigSecurity_1_6_3()
{
    global $_TABLES;
    
    // Add in security rights for Static Page Admin
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                            "grp_name = 'Static Page Admin'");

    if ($group_id > 0) {
        $ft_names[] = 'config.staticpages.tab_main';
        $ft_names[] = 'config.staticpages.tab_whatsnew';
        $ft_names[] = 'config.staticpages.tab_search';
        $ft_names[] = 'config.staticpages.tab_permissions';
        $ft_names[] = 'config.staticpages.tab_autotag_permissions';
        
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
