<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | portal.php                                                                |
// |                                                                           |
// | Geeklog portal page that tracks link click throughs.                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
//

/** 
 * Geeklog portal page that tracks link click throughs. 
 * 
 * @package Links
 * @subpackage public_html
 * @filesource
 * @version 1.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License 
 * @author Trinity Bays <trinity93@steubentech.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 * 
 */

// $Id: portal.php,v 1.5 2007/12/31 10:41:47 dhaun Exp $

require_once('../lib-common.php');

// MAIN

$url = '';

COM_setArgNames (array ('what', 'item'));
$what = COM_getArgument ('what');

if ($what == 'link') {

    $item = COM_applyFilter (COM_getArgument ('item'));

    if (!empty ($item)) {
        $url = DB_getItem ($_TABLES['links'], 'url', "lid = '{$item}'");
        if (!empty ($url)) {
            DB_change ($_TABLES['links'], 'hits','hits + 1', 'lid',$item, '', true);
        }
    }
} elseif ($what == 'category') {

    $item = COM_applyFilter (COM_getArgument ('item'));

    if (!empty ($item)) {
        $url = COM_buildURL("{$_CONF['site_url']}/links/index.php?category=" . urlencode($item));
    }
}

if (empty ($url)) {
    $url = $_CONF['site_url'];
}
header ('HTTP/1.1 301 Moved');
header ('Location: ' . $url);
header ('Connection: close');

?>
