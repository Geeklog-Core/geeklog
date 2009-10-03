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
* MS SQL updates
*
* @package StaticPages
*/

$_UPDATES = array(

    '1.6.0' => array(
        "ALTER TABLE {$_TABLES['staticpage']} ADD meta_description [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL AFTER commentcode, ADD meta_keywords [meta_keywords] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL AFTER meta_description"
    )

);

/**
* Handle update to plugin version 1.6.0: introduce meta tags option
*
*/
function update_ConfValues_1_6_0()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    // meta tag config options.
    $c->add('meta_tags', $_SP_DEFAULT['meta_tags'], 'select', 0, 0, 0, 120, true, 'staticpages');

    // check for wrong Admin group name
    $wrong_id = DB_getItem($_TABLES['groups'], 'grp_id',
                           "grp_name = 'Static Pages Admin'"); // wrong name
    if (! empty($wrong_id)) {
        $grp_id = DB_getItem($_TABLES['groups'], 'grp_id',
                             "grp_name = 'Static Page Admin'"); // correct name
        if (empty($grp_id)) {
            // correct name not found - probably a fresh install: rename
            DB_query("UPDATE {$_TABLES['groups']} SET grp_name = 'Static Page Admin' WHERE grp_name = 'Static Pages Admin'");
        } else {
            // both names exist: delete wrong group & assignments
            DB_delete($_TABLES['access'], 'acc_grp_id', $wrong_id);
            DB_delete($_TABLES['group_assignments'], 'ug_grp_id', $wrong_id);
            DB_delete($_TABLES['group_assignments'], 'ug_main_grp_id', $wrong_id);
            DB_delete($_TABLES['groups'], 'grp_name', 'Static Pages Admin');
        }
    }

    return true;
}

?>
