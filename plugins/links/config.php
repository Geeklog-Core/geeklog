<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | config.php   Links plugin configuration file                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
// $Id: config.php,v 1.17 2007/08/28 05:33:56 ospiess Exp $
/**
 * Links plugin configuration file
 *
 * @package Links
 * @filesource
 * @version 1.0.1
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2006
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Trinity Bays <trinity93@steubentech.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 *
 */

/**
* the link plugin's config aray
*
* @global array $_LI_CONF
*/
$_LI_CONF = array();

/**
* the link plugin's version setting
*
* @global array $_LI_CONF['version']
*/
$_LI_CONF['version'] = '1.0.1';          // Plugin Version

/**
 * this lets you select which functions are available for registered users only
 *
 * @global array $_LI_CONF['linksloginrequired']
 */
$_LI_CONF['linksloginrequired'] = 0;

/**
 * Submission Settings
 * enable (set to 1) or disable (set to 0) submission queues:
 *
 * @global array $_LI_CONF['linksubmission']
 */
$_LI_CONF['linksubmission']  = 1;

/**
 * Following times are in seconds
 *
 * @global array $_LI_CONF['newlinksinterval']
 */
$_LI_CONF['newlinksinterval']    = 1209600; // = 14 days

/**
 * Set to 1 to hide a section from the What's New block:
 *
 * @global array $_LI_CONF['hidenewlinks']
 */
$_LI_CONF['hidenewlinks']    = 0;

/**
 * Set to 1 to hide the "Web Resources" entry from the top menu:
 *
 * @global array $_LI_CONF['hidelinksmenu']
 */
$_LI_CONF['hidelinksmenu']    = 0;

/**
 * categories per column
 * You can set this and $_LI_CONF['linksperpage'] to 0 to get back the old
 * (pre-1.3.6) style of the links section. Setting only linkcols to 0 will hide
 * the categories but keep the paging. Setting only linksperpage to 0 will list
 * all the links of the selected category on one page.
 *
 * @global array $_LI_CONF['linkcols']
 */
$_LI_CONF['linkcols']     =  3;

/**
 * links per page
 * You can set this and $_LI_CONF['linkcols'] to 0 to get back the old
 * (pre-1.3.6) style of the links section. Setting only linkcols to 0 will hide
 * the categories but keep the paging. Setting only linksperpage to 0 will list
 * all the links of the selected category on one page.
 *
 * @global array $_LI_CONF['linksperpage']
 */
$_LI_CONF['linksperpage'] = 10;

/**
 * show top ten links
 * Whether to show the Top Ten Links on the main page or not.
 *
 * @global array $_LI_CONF['show_top10']
 */
$_LI_CONF['show_top10']   = true;

/**
 * notify when a new link was submitted
 *
 * @global array $_LI_CONF['notification']
 */
$_LI_CONF['notification'] = 0;

/**
 * should we remove links submited by users if account is removed? (1)
 * or change owner to root (0)
 *
 * @global array $_LI_CONF['delete_links']
 */
$_LI_CONF['delete_links'] = 0;

/** What to show after a link has been saved? Possible choices:
 * 'item' -> forward to the target of the link
 * 'list' -> display the admin-list of links
 * 'plugin' -> display the public homepage of the links plugin
 * 'home' -> display the site homepage
 * 'admin' -> display the site admin homepage
 */
$_LI_CONF['aftersave'] = 'list';

/**
 * Define default permissions for new links created from the Admin panel.
 * Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
 * order). Possible values:<br>
 * - 3 = read + write permissions (perm_owner and perm_group only)
 * - 2 = read-only
 * - 0 = neither read nor write permissions
 * (a value of 1, ie. write-only, does not make sense and is not allowed)
 *
 * @global array $_LI_CONF['default_permissions']
 */
$_LI_CONF['default_permissions'] = array (3, 2, 2, 2);

// database table names - don't change
$_TABLES['links']               = $_DB_table_prefix . 'links';
$_TABLES['linksubmission']      = $_DB_table_prefix . 'linksubmission';

?>
