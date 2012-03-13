<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | Upgrade SQL                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2011 by the following authors:                         |
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
* @package StaticPages
*/

$_UPDATES = array(

    '1.4.3' => array(
        "ALTER TABLE {$_TABLES['staticpage']} ADD commentcode tinyint(4) NOT NULL default '0' AFTER sp_label",
        // disable comments on all existing static pages
        "UPDATE {$_TABLES['staticpage']} SET commentcode = -1"
    ),

    '1.6.0' => array(
        "ALTER TABLE {$_TABLES['staticpage']} ADD meta_description TEXT NULL AFTER commentcode",
        "ALTER TABLE {$_TABLES['staticpage']} ADD meta_keywords TEXT NULL AFTER meta_description"
    ),

    '1.6.1' => array(
        "ALTER TABLE {$_TABLES['staticpage']} DROP COLUMN sp_uid",
        "ALTER TABLE {$_TABLES['staticpage']} ADD draft_flag tinyint(1) unsigned default '0' AFTER meta_keywords",

        "ALTER TABLE {$_TABLES['staticpage']} CHANGE sp_date `created` datetime default NULL",
        "ALTER TABLE {$_TABLES['staticpage']} ADD modified datetime NOT NULL default '0000-00-00 00:00:00' AFTER `created`",
        "UPDATE {$_TABLES['staticpage']} SET modified = `created`",

        "ALTER TABLE {$_TABLES['staticpage']} ADD sp_page_title varchar(128) NOT NULL default '' AFTER sp_title"
    ),
    
    '1.6.2' => array(
        "ALTER TABLE {$_TABLES['staticpage']} ADD `template_flag` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `meta_keywords`",
        "ALTER TABLE {$_TABLES['staticpage']} ADD `template_id` VARCHAR( 40 ) NOT NULL DEFAULT '' AFTER `template_flag`"
    ),
    
    '1.6.3' => array(
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
function SP_update_ConfigSecurity_1_6_3()
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

/**
* Handle update to plugin version 1.6.0: introduce meta tags option
*
*/
function SP_update_ConfValues_1_6_0()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

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

    // move Default Permissions fieldset
    DB_query("UPDATE {$_TABLES['conf_values']} SET fieldset = 3 WHERE (group_name = 'staticpages') AND (fieldset = 1)");

    // What's New Block
    $c->add('fs_whatsnew', NULL, 'fieldset', 0, 1, NULL, 0, true, 'staticpages');
    $c->add('newstaticpagesinterval',$_SP_DEFAULT['new_staticpages_interval'],'text', 0, 1, NULL, 10, TRUE, 'staticpages');
    $c->add('hidenewstaticpages',$_SP_DEFAULT['hide_new_staticpages'],'select', 0, 1, 0, 20, TRUE, 'staticpages');
    $c->add('title_trim_length',$_SP_DEFAULT['title_trim_length'],'text', 0, 1, NULL, 30, TRUE, 'staticpages');
    $c->add('includecenterblocks',$_SP_DEFAULT['include_centerblocks'],'select', 0, 1, 0, 40, TRUE, 'staticpages');
    $c->add('includephp',$_SP_DEFAULT['include_PHP'],'select', 0, 1, 0, 50, TRUE, 'staticpages');        
    
    // Search Results
    $c->add('fs_search', NULL, 'fieldset', 0, 2, NULL, 0, true, 'staticpages');
    $c->add('includesearch', $_SP_DEFAULT['include_search'], 'select', 0, 2, 0, 10, true, 'staticpages');
    $c->add('includesearchcenterblocks',$_SP_DEFAULT['include_search_centerblocks'],'select', 0, 2, 0, 20, TRUE, 'staticpages');
    $c->add('includesearchphp',$_SP_DEFAULT['include_search_PHP'],'select', 0, 2, 0, 30, TRUE, 'staticpages');   

    return true;
}

/**
* Handle update to plugin version 1.6.1
*
*/
function SP_update_ConfValues_1_6_1()
{
    global $_CONF, $_TABLES, $_SP_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/staticpages/install_defaults.php';

    $c->add('comment_code', $_SP_DEFAULT['comment_code'], 'select',
            0, 0, 17, 125, true, 'staticpages');
    $c->add('draft_flag', $_SP_DEFAULT['draft_flag'], 'select',
            0, 0, 0, 127, true, 'staticpages');
    $c->add('sort_list_by', $_SP_DEFAULT['sort_list_by'], 'select',
            0, 0, 4, 35, true, 'staticpages');
    
    $c->del('hidenewstaticpages','staticpages');
    $c->add('hidenewstaticpages',$_SP_DEFAULT['hide_new_staticpages'],'select', 
        0, 1, 5, 20, TRUE, 'staticpages');
    
    return true;
}

?>
