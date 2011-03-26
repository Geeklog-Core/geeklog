<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 1.0                                                     |
// +---------------------------------------------------------------------------+
// | mssql_updates.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2011 by the following authors:                         |
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
* MS SQL updates
*
* @package XMLsitemap
*/

$_UPDATES = array(

    '1.0.0' => array(
        // Set new Tab column to whatever fieldset is
        "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'xmlsitemap'",

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

    /*
     * For some time, from Geeklog 1.6.0 through to 1.7.0, we already had
     * an XMLSitemap Admin group in the database. It was dropped in 1.7.1
     * but not removed from the database. This is now coming back to haunt
     * us ... We also need to remove the unused xmlsitemap.edit permission
     * while we're at it.
     */

    if (empty($group_id)) { // cover: null, false, 0, etc. - doesn't exist yet
        // Add new Core Admin Group for Configuration
        DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr, grp_gl_core) VALUES ('XMLSitemap Admin', 'Has full access to XMLSitemap features', 0);");
        $group_id = DB_insertId();

        // Assign XMLSitemap Admin group to Root group
        DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES ($group_id, NULL, 1)");
    } else {
        // if the XMLSitemap Admin group already exists, then there will
        // probably also be a xmlsitemap.edit permission - remove it
        SEC_removeFeatureFromDB('xmlsitemap.edit');
    }

    // now that we cleaned this up, add the new stuff

    if ($group_id > 0) {
        $ft_names[] = 'config.xmlsitemap.tab_main';
        $ft_names[] = 'config.xmlsitemap.tab_pri';
        $ft_names[] = 'config.xmlsitemap.tab_freq';

        foreach ($ft_names as $name) {
            $ft_id = DB_getItem($_TABLES['features'], 'ft_id',
                                "ft_name = '$name'");
            if ($ft_id > 0) {
                $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($ft_id, $group_id)";
                DB_query($sql);
            }
        }
    }

}

?>
