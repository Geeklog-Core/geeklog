<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Blaine Lang      - blaine AT portalparts DOT com                 |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* Install data and defaults for the Static Pages plugin configuration
*
* @package StaticPages
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Static Pages default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */
global $_SP_DEFAULT;
$_SP_DEFAULT = array();

// If you don't plan on using PHP code in static pages, you should set this
// to 0, thus disabling the execution of PHP.
$_SP_DEFAULT['allow_php'] = 1;

// If you have more than one static page that is to be displayed in Geeklog's
// center area, you can specify how to sort them:
$_SP_DEFAULT['sort_by'] = 'id'; // can be 'id', 'title', 'date'

// sort the static pages that are listed in the site's menu
// (assuming you're using a theme that uses the {plg_menu_elements} variable)
$_SP_DEFAULT['sort_menu_by'] = 'label'; // can be 'id', 'label', 'title', 'date'

// Sort admin list by which field?
$_SP_DEFAULT['sort_list_by'] = 'title'; // can be 'id', 'title', 'date', 'author'

// When a user is deleted, ownership of static pages created by that user can
// be transfered to a user in the Root group (= 0) or the pages can be
// deleted (= 1).
$_SP_DEFAULT['delete_pages'] = 0;

/** What to show after a page has been saved? Possible choices:
 * 'item' -> forward to the static page
 * 'list' -> display the admin-list of the static pages
 * 'home' -> display the site homepage
 * 'admin' -> display the site admin homepage
 */
$_SP_DEFAULT['aftersave'] = 'list';

// Static pages can optionally be wrapped in a block. This setting defines
// the default for that option (1 = wrap in a block, 0 = don't).
$_SP_DEFAULT['in_block'] = 1;

// Do you want to show the hits on static pages?
// the default for that option (1 = show hits, 0 = don't).
$_SP_DEFAULT['show_hits'] = 1;

// Do you want to show the last update date/time on static pages?
// the default for that option (1 = show date, 0 = don't).
$_SP_DEFAULT['show_date'] = 1;

// Whether to filter HTML or naughty words
$_SP_DEFAULT['filter_html'] = 0;
$_SP_DEFAULT['censor'] = 0;

// What's New Block
$_SP_DEFAULT['new_staticpages_interval'] = 1209600; // 2 weeks
$_SP_DEFAULT['hide_new_staticpages'] = 'hide'; // 'hide', 'created', 'modified'
$_SP_DEFAULT['title_trim_length'] = 20;
$_SP_DEFAULT['include_centerblocks'] = 0;
$_SP_DEFAULT['include_PHP'] = 0;

// Search Results Filter
$_SP_DEFAULT['include_search'] = 1;
$_SP_DEFAULT['include_search_centerblocks'] = 0;
$_SP_DEFAULT['include_search_PHP'] = 0;

// The maximum number of items displayed when an Atom feed is requested
$_SP_DEFAULT['atom_max_items'] = 10;

// Display Meta Tags for static pages (1 = show, 0 = don't) 
$_SP_DEFAULT['meta_tags'] = 0;

// Whether to enable (0) or disable (-1) comments by default
$_SP_DEFAULT['comment_code'] = -1;

// Whether to set the draft flag by default for new pages
$_SP_DEFAULT['draft_flag'] = 0;

// Define default permissions for new pages created from the Admin panel.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 3 = read + write permissions (perm_owner and perm_group only)
// 2 = read-only
// 0 = neither read nor write permissions
// (a value of 1, ie. write-only, does not make sense and is not allowed)
$_SP_DEFAULT['default_permissions'] = array(3, 2, 2, 2);

// Define default usuage permissions for the staticpage autotags.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 2 = use
// 0 = cannot use
// (a value of 1 is not allowed)
$_SP_DEFAULT['autotag_permissions_staticpage'] = array (2, 2, 2, 2);
$_SP_DEFAULT['autotag_permissions_staticpage_content'] = array (2, 2, 0, 0);

/**
* Initialize Static Pages plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_SP_CONF if available (e.g. from
* an old config.php), uses $_SP_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_staticpages()
{
    global $_SP_CONF, $_SP_DEFAULT;

    if (is_array($_SP_CONF) && (count($_SP_CONF) > 1)) {
        $_SP_DEFAULT = array_merge($_SP_DEFAULT, $_SP_CONF);
    }

    $c = config::get_instance();
    if (!$c->group_exists('staticpages')) {

        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'staticpages', 0);
        $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'staticpages', 0);
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, true, 'staticpages', 0);
        $c->add('allow_php', $_SP_DEFAULT['allow_php'], 'select',
                0, 0, 0, 10, true, 'staticpages', 0);
        $c->add('sort_by', $_SP_DEFAULT['sort_by'], 'select',
                0, 0, 2, 20, true, 'staticpages', 0);
        $c->add('sort_menu_by', $_SP_DEFAULT['sort_menu_by'], 'select',
                0, 0, 3, 30, true, 'staticpages', 0);
        $c->add('sort_list_by', $_SP_DEFAULT['sort_list_by'], 'select',
                0, 0, 4, 35, true, 'staticpages', 0);
        $c->add('delete_pages', $_SP_DEFAULT['delete_pages'], 'select',
                0, 0, 0, 40, true, 'staticpages', 0);
        $c->add('in_block', $_SP_DEFAULT['in_block'], 'select',
                0, 0, 0, 50, true, 'staticpages', 0);
        $c->add('show_hits', $_SP_DEFAULT['show_hits'], 'select',
                0, 0, 0, 60, true, 'staticpages', 0);
        $c->add('show_date', $_SP_DEFAULT['show_date'], 'select',
                0, 0, 0, 70, true, 'staticpages', 0);
        $c->add('filter_html', $_SP_DEFAULT['filter_html'], 'select',
                0, 0, 0, 80, true, 'staticpages', 0);
        $c->add('censor', $_SP_DEFAULT['censor'], 'select',
                0, 0, 0, 90, true, 'staticpages', 0);
        $c->add('aftersave', $_SP_DEFAULT['aftersave'], 'select',
                0, 0, 9, 100, true, 'staticpages', 0);
        $c->add('atom_max_items', $_SP_DEFAULT['atom_max_items'], 'text',
                0, 0, null, 110, true, 'staticpages', 0);
        $c->add('meta_tags', $_SP_DEFAULT['meta_tags'], 'select',
                0, 0, 0, 120, true, 'staticpages', 0);
        $c->add('comment_code', $_SP_DEFAULT['comment_code'], 'select',
                0, 0, 17, 125, true, 'staticpages', 0);
        $c->add('draft_flag', $_SP_DEFAULT['draft_flag'], 'select',
                0, 0, 0, 127, true, 'staticpages', 0);

        $c->add('tab_whatsnew', NULL, 'tab', 0, 1, NULL, 0, true, 'staticpages', 1);
        $c->add('fs_whatsnew', NULL, 'fieldset', 0, 1, NULL, 0, true, 'staticpages', 1);
        $c->add('newstaticpagesinterval',$_SP_DEFAULT['new_staticpages_interval'],'text',
                0, 1, NULL, 10, TRUE, 'staticpages', 1);
        $c->add('hidenewstaticpages',$_SP_DEFAULT['hide_new_staticpages'],'select',
                0, 1, 5, 20, TRUE, 'staticpages', 1);
        $c->add('title_trim_length',$_SP_DEFAULT['title_trim_length'],'text',
                0, 1, NULL, 30, TRUE, 'staticpages', 1);
        $c->add('includecenterblocks',$_SP_DEFAULT['include_centerblocks'],'select',
                0, 1, 0, 40, TRUE, 'staticpages', 1);
        $c->add('includephp',$_SP_DEFAULT['include_PHP'],'select',
                0, 1, 0, 50, TRUE, 'staticpages', 1);        
        
        $c->add('tab_search', NULL, 'tab', 0, 2, NULL, 0, true, 'staticpages', 2);
        $c->add('fs_search', NULL, 'fieldset', 0, 2, NULL, 0, true, 'staticpages', 2);
        $c->add('includesearch', $_SP_DEFAULT['include_search'], 'select',
                0, 2, 0, 10, true, 'staticpages', 2);
        $c->add('includesearchcenterblocks',$_SP_DEFAULT['include_search_centerblocks'],'select',
                0, 2, 0, 20, TRUE, 'staticpages', 2);
        $c->add('includesearchphp',$_SP_DEFAULT['include_search_PHP'],'select',
                0, 2, 0, 30, TRUE, 'staticpages', 2);   
        
        $c->add('tab_permissions', NULL, 'tab', 0, 3, NULL, 0, true, 'staticpages', 3);
        $c->add('fs_permissions', NULL, 'fieldset', 0, 3, NULL, 0, true, 'staticpages', 3);
        $c->add('default_permissions', $_SP_DEFAULT['default_permissions'],'@select',
                0, 3, 12, 130, true, 'staticpages', 3);
        
        $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'staticpages', 10);
        $c->add('fs_autotag_permissions', NULL, 'fieldset', 0, 10, NULL, 0, true, 'staticpages', 10);
        $c->add('autotag_permissions_staticpage', $_SP_DEFAULT['autotag_permissions_staticpage'], '@select', 
                0, 10, 13, 10, true, 'staticpages', 10);       
        $c->add('autotag_permissions_staticpage_content', $_SP_DEFAULT['autotag_permissions_staticpage_content'], '@select', 
                0, 10, 13, 10, true, 'staticpages', 10);          
    }

    return true;
}

?>
