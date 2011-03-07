<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Links Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                   |
// |          Mark Limburg       - mlimburg AT users.sourceforge DOT net       |
// |          Jason Whittenburg  - jwhitten AT securitygeeks DOT com           |
// |          Dirk Haun          - dirk AT haun-online DOT de                  |
// |          Trinity Bays       - trinity93 AT gmail DOT com                  |
// |          Oliver Spiesshofer - oliver AT spiesshofer DOT com               |
// |          Euan McKay         - info AT heatherengineering DOT com          |
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
* Install data and defaults for the Links plugin configuration
*
* @package Links
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/*
 * Links default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */

/**
* the link plugin's config array
*/
global $_LI_DEFAULT;
$_LI_DEFAULT = array();

/**
 * this lets you select which functions are available for registered users only
 */
$_LI_DEFAULT['linksloginrequired'] = 0;

/**
 * Submission Settings
 * enable (set to 1) or disable (set to 0) submission queues:
 */
$_LI_DEFAULT['linksubmission']  = 1;

/**
 * Following times are in seconds
 */
$_LI_DEFAULT['newlinksinterval']    = 1209600; // = 14 days

/**
 * Set to 1 to hide a section from the What's New block:
 */
$_LI_DEFAULT['hidenewlinks']    = 0;

/**
 * Set to 1 to hide the "Links" entry from the top menu:
 */
$_LI_DEFAULT['hidelinksmenu']    = 0;

/**
 * categories per column
 * You can set this and $_LI_DEFAULT['linksperpage'] to 0 to get back the old
 * (pre-1.3.6) style of the links section. Setting only linkcols to 0 will hide
 * the categories but keep the paging. Setting only linksperpage to 0 will list
 * all the links of the selected category on one page.
 */
$_LI_DEFAULT['linkcols']     =  3;

/**
 * links per page
 * You can set this and $_LI_DEFAULT['linkcols'] to 0 to get back the old
 * (pre-1.3.6) style of the links section. Setting only linkcols to 0 will hide
 * the categories but keep the paging. Setting only linksperpage to 0 will list
 * all the links of the selected category on one page.
 */
$_LI_DEFAULT['linksperpage'] = 10;

/**
 * show top ten links
 * Whether to show the Top Ten Links on the main page or not.
 */
$_LI_DEFAULT['show_top10']   = true;

/**
 * notify when a new link was submitted
 */
$_LI_DEFAULT['notification'] = 0;

/**
 * should we remove links submitted by users if account is removed? (1)
 * or change owner to root (0)
 */
$_LI_DEFAULT['delete_links'] = 0;

/** What to show after a link has been saved? Possible choices:
 * 'item' -> forward to the target of the link
 * 'list' -> display the admin-list of links
 * 'plugin' -> display the public homepage of the links plugin
 * 'home' -> display the site homepage
 * 'admin' -> display the site admin homepage
 */
$_LI_DEFAULT['aftersave'] = 'list';

/**
 * show category descriptions
 * Whether to show subcategory descriptions when viewing a category or not.
 */
$_LI_DEFAULT['show_category_descriptions'] = true;

/**
 * open links in new window
 * Whether to open external links in a new window or not.
 */
$_LI_DEFAULT['new_window'] = false;

/**
 * Links root category id
 */
$_LI_DEFAULT['root'] = 'site';

/**
 * Define default permissions for new links created from the Admin panel.
 * Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
 * order). Possible values:<br>
 * - 3 = read + write permissions (perm_owner and perm_group only)
 * - 2 = read-only
 * - 0 = neither read nor write permissions
 * (a value of 1, ie. write-only, does not make sense and is not allowed)
 */
$_LI_DEFAULT['default_permissions'] = array (3, 2, 2, 2);

/**
 * Define default permissions for new link categories.
 * Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
 * order). Possible values:<br>
 * - 3 = read + write permissions (perm_owner and perm_group only)
 * - 2 = read-only
 * - 0 = neither read nor write permissions
 * (a value of 1, ie. write-only, does not make sense and is not allowed)
 */
$_LI_DEFAULT['category_permissions'] = array (3, 2, 2, 2);

// Define default usuage permissions for the links autotags.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 2 = use
// 0 = cannot use
// (a value of 1 is not allowed)
$_LI_DEFAULT['autotag_permissions_link'] = array (2, 2, 2, 2);


/**
* Initialize Links plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_LI_CONF if available (e.g. from
* an old config.php), uses $_LI_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_links()
{
    global $_LI_CONF, $_LI_DEFAULT;

    if (is_array($_LI_CONF) && (count($_LI_CONF) > 1)) {
        $_LI_DEFAULT = array_merge($_LI_DEFAULT, $_LI_CONF);
    }

    $c = config::get_instance();
    if (!$c->group_exists('links')) {

        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'links', 0);
        $c->add('tab_public', NULL, 'tab', 0, 0, NULL, 0, true, 'links', 0);
        $c->add('fs_public', NULL, 'fieldset', 0, 0, NULL, 0, true, 'links', 0);
        $c->add('linksloginrequired', $_LI_DEFAULT['linksloginrequired'],
                'select', 0, 0, 0, 10, true, 'links', 0);
        $c->add('linkcols', $_LI_DEFAULT['linkcols'], 'text',
                0, 0, 0, 20, true, 'links', 0);
        $c->add('linksperpage', $_LI_DEFAULT['linksperpage'], 'text',
                0, 0, 0, 30, true, 'links', 0);
        $c->add('show_top10', $_LI_DEFAULT['show_top10'], 'select',
                0, 0, 1, 40, true, 'links', 0);
        $c->add('show_category_descriptions', $_LI_DEFAULT['show_category_descriptions'], 
                'select', 0, 0, 1, 50, true, 'links', 0);
        $c->add('new_window', $_LI_DEFAULT['new_window'], 'select',
                0, 0, 1, 55, true, 'links',0);

        $c->add('tab_admin', NULL, 'tab', 0, 1, NULL, 0, true, 'links', 1);
        $c->add('fs_admin', NULL, 'fieldset', 0, 1, NULL, 0, true, 'links', 1);
        $c->add('hidenewlinks', $_LI_DEFAULT['hidenewlinks'], 'select',
                0, 1, 0, 60, true, 'links', 1);
        $c->add('newlinksinterval', $_LI_DEFAULT['newlinksinterval'], 'text',
                0, 1, 0, 70, true, 'links', 1);
        $c->add('hidelinksmenu', $_LI_DEFAULT['hidelinksmenu'], 'select',
                0, 1, 0, 80, true, 'links', 1);
        $c->add('linksubmission', $_LI_DEFAULT['linksubmission'], 'select',
                0, 1, 0, 90, true, 'links', 1);
        $c->add('notification', $_LI_DEFAULT['notification'], 'select',
                0, 1, 0, 100, true, 'links', 1);
        $c->add('delete_links', $_LI_DEFAULT['delete_links'], 'select',
                0, 1, 0, 110, true, 'links', 1);
        $c->add('aftersave', $_LI_DEFAULT['aftersave'], 'select',
                0, 1, 9, 120, true, 'links', 1);
        $c->add('root', $_LI_DEFAULT['root'], 'text',
                0, 1, 0, 130, true, 'links', 1);

        $c->add('tab_permissions', NULL, 'tab', 0, 2, NULL, 0, true, 'links', 2);
        $c->add('fs_permissions', NULL, 'fieldset', 0, 2, NULL, 0, true, 'links', 2);
        $c->add('default_permissions', $_LI_DEFAULT['default_permissions'],
                '@select', 0, 2, 12, 140, true, 'links', 2);

        $c->add('tab_cpermissions', NULL, 'tab', 0, 3, NULL, 0, true, 'links', 3);
        $c->add('fs_cpermissions', NULL, 'fieldset', 0, 3, NULL, 0, true, 'links', 3);
        $c->add('category_permissions', $_LI_DEFAULT['category_permissions'],
                '@select', 0, 3, 12, 150, true, 'links', 3);
        
        $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'links', 10);
        $c->add('fs_autotag_permissions', NULL, 'fieldset', 0, 10, NULL, 0, true, 'links', 10);
        $c->add('autotag_permissions_link', $_LI_DEFAULT['autotag_permissions_link'], '@select', 
                0, 10, 13, 10, true, 'links', 10);             

    }

    return true;
}

?>
