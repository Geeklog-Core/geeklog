<?php
/* Intial Installation Defaults used when loading the online configuration records
*  These settings are only used during the initial installation and not referenced
*  once the plugin is installed
*/


// If you don't plan on using PHP code in static pages, you should set this
// to 0, thus disabling the execution of PHP.

$_SP_DEFAULT['allow_php'] = 1;


// If you have more than one static page that is to be displayed in Geeklog's
// center area, you can specify how to sort them:

$_SP_DEFAULT['sort_by'] = 'id'; // can be 'id', 'title', 'date'


// sort the static pages that are listed in the site's menu
// (assuming you're using a theme that uses the {plg_menu_elements} variable)

$_SP_DEFAULT['sort_menu_by'] = 'label'; // can be 'id', 'label', 'title', 'date'


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
$_SP_DEFAULT['aftersave'] = 'item';

// Static pages can optionally be wrapped in a block. This setting defines
// the default for that option (1 = wrap in a block, 0 = don't).
$_SP_DEFAULT['in_block'] = 1;

// Do you want to show the hits on static pages?
// the default for that option (1 = show hits, 0 = don't).
$_SP_DEFAULT['show_hits'] = 1;

// Do you want to show the last update date/time on static pages?
// the default for that option (1 = show date, 0 = don't).
$_SP_DEFAULT['show_date'] = 1;

// If you experience timeout issues, you may need to set both of the
// following values to 0 as they are intensive

// NOTE: using filter_html will render any blank pages useless
$_SP_DEFAULT['filter_html'] = 0;
$_SP_DEFAULT['censor'] = 1;

// Define default permissions for new pages created from the Admin panel.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 3 = read + write permissions (perm_owner and perm_group only)
// 2 = read-only
// 0 = neither read nor write permissions
// (a value of 1, ie. write-only, does not make sense and is not allowed)
$_SP_DEFAULT['default_permissions'] = array (3, 2, 2, 2);

// The maximum number of items displayed when an Atom feed is requested
$_SP_DEFAULT['atom_max_items'] = 10;

?>