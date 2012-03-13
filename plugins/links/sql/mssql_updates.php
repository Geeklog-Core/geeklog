<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Links Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | Installation SQL                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
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

    '1.0.1' => array(
        "CREATE TABLE [dbo].[{$_TABLES['linkcategories']}] (
          [cid] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
          [pid] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
          [category] [varchar] (32) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL ,
          [description] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
          [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NULL ,
          [created] [datetime] NULL ,
          [modified] [datetime] NULL ,
          [owner_id] [numeric](8, 0) NOT NULL ,
          [group_id] [numeric](8, 0) NOT NULL ,
          [perm_owner] [tinyint] NOT NULL ,
          [perm_group] [tinyint] NOT NULL ,
          [perm_members] [tinyint] NOT NULL ,
          [perm_anon] [tinyint] NOT NULL
        ) ON [PRIMARY]",
        "ALTER TABLE [dbo].[{$_TABLES['linkcategories']}] ADD
          CONSTRAINT [PK_{$_TABLES['linkcategories']}] PRIMARY KEY  CLUSTERED
          (
            [pid]
          )  ON [PRIMARY]",
        "ALTER TABLE {$_TABLES['linksubmission']} ADD owner_id INTEGER NOT NULL default '1'",
        "EXEC sp_rename '{$_TABLES['linksubmission']}.category', 'cid', 'COLUMN'",
        "ALTER TABLE {$_TABLES['linksubmission']} ALTER COLUMN [cid] varchar(32) NOT NULL",
        "EXEC sp_rename '{$_TABLES['links']}.category', 'cid', 'COLUMN'",
        "ALTER TABLE {$_TABLES['links']} ALTER COLUMN [cid] varchar(32) NOT NULL"
    ),

    '2.1.0' => array(
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_public', 'Access to configure public links list settings', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_admin', 'Access to configure links admin settings', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_permissions', 'Access to configure link permissions', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_cpermissions', 'Access to configure link\'s category permissions', 0)",
        "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('config.links.tab_autotag_permissions', 'Access to configure link\'s autotag usage permissions', 0)"        
    )    
    
);

/**
* Add "root" category and fix categories
*
*/
function links_update_set_categories()
{
    global $_TABLES, $_LI_CONF;

    if (empty($_LI_CONF['root'])) {
        $_LI_CONF['root'] = 'site';
    }
    $root = addslashes($_LI_CONF['root']);

    DB_query("INSERT INTO {$_TABLES['linkcategories']} (cid, pid, category, description, tid, created, modified, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('{$root}', 'root', 'Root', 'Website root', NULL, NOW(), NOW(), 5, 2, 3, 3, 2, 2)");

    // get Links admin group number
    $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                           "grp_name = 'Links Admin'");

    // loop through adding to category table, then update links table with cids
    $result = DB_query("SELECT DISTINCT cid AS category FROM {$_TABLES['links']}");
    $nrows = DB_numRows($result);
    for ($i = 0; $i < $nrows; $i++) {

        $A = DB_fetchArray($result);
        $category = addslashes($A['category']);
        $cid = $category;
        $sql = "INSERT INTO {$_TABLES['linkcategories']} (cid,pid,category,description,tid,owner_id,group_id,created,modified, perm_owner, perm_group, perm_members, perm_anon) VALUES ('{$cid}','{$root}','{$category}','{$category}','all',2,'{$group_id}',NOW(),NOW(), 3, 3, 2, 2)";
        DB_query($sql,0);
        if ($cid != $category) { // still experimenting ...
            $sql = "UPDATE {$_TABLES['links']} SET cid='{$cid}' WHERE cid='{$category}'";
            DB_query($sql,0);
        }
        if (DB_error()) {
            echo "Error inserting categories into linkcategories table";
            return false;
        }
    }
}

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
