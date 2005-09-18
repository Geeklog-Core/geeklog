<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | config.php   Links plugin configuration file                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users.sourceforge DOT net        |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
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
//
// $Id: config.php,v 1.5 2005/09/18 12:09:45 dhaun Exp $

$_LI_CONF['version'] = '1.0';          // Plugin Version

// this lets you select which functions are available for registered users only
$_LI_CONF['linksloginrequired'] = 0;

// Submission Settings
// enable (set to 1) or disable (set to 0) submission queues:
$_LI_CONF['linksubmission']  = 1;

// Following times are in seconds
$_LI_CONF['newlinksinterval']    = 1209600; // = 14 days
// Set to 1 to hide a section from the What's New block:
$_LI_CONF['hidenewlinks']    = 0;


// You can set both of the following to 0 to get back the old (pre-1.3.6)
// style of the links section. Setting only linkcols to 0 will hide the
// categories but keep the paging. Setting only linksperpage to 0 will list
// all the links of the selected category on one page.
$_LI_CONF['linkcols']     =  3; // categories per column
$_LI_CONF['linksperpage'] = 10; // links per page

$_LI_CONF['notification'] = 0; // notify when a new link was submitted

// should be remove links submited by users if account is removed? (1)
// or change owner to root (0)
$_LI_CONF['delete_links'] = 0; 

// Define default permissions for new links created from the Admin panel.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 3 = read + write permissions (perm_owner and perm_group only)
// 2 = read-only
// 0 = neither read nor write permissions
// (a value of 1, ie. write-only, does not make sense and is not allowed)
$_LI_CONF['default_permissions'] = array (3, 2, 2, 2);

// database table names - don't change
$_TABLES['links']               = $_DB_table_prefix . 'links';
$_TABLES['linksubmission']      = $_DB_table_prefix . 'linksubmission';

?>
