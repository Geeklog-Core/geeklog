<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | portal.php                                                                |
// |                                                                           |
// | Geeklog portal page that tracks link click throughs.                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users.sourceforge DOT net        |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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
 * Geeklog portal page that tracks link click throughs. 
 * 
 * @package Links
 * @subpackage public_html
 * @filesource
 * @version 2.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2008
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Trinity Bays, trinity93 AT gmail.com
 * @author Tony Bibbs, tony AT tonybibbs DOT com
 * @author Tom Willett, twillett AT users DOT sourceforge DOT net
 * @author Blaine Lang, langmail AT sympatico DOT ca
 * @author Dirk Haun, dirk AT haun-online DOT de
 * 
 */

/**
* Geeklog common function library 
*/
require_once '../lib-common.php';

if (!in_array('links', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}


// MAIN

$url = '';

COM_setArgNames(array('what', 'item'));
$what = COM_getArgument('what');

if ($what == 'link') {

    $item = COM_applyFilter(COM_getArgument('item'));
    if (!empty($item)) {
        // Hack: due to PLG_afterSaveSwitch settings, we may get
        // an attached &msg - strip it off
        $i = explode('&', $item);
        $item = $i[0];
    }

    if (!empty($item)) {
        $url = DB_getItem($_TABLES['links'], 'url', "lid = '{$item}'");
        if (!empty($url)) {
            DB_change($_TABLES['links'], 'hits','hits + 1', 'lid',$item, '', true);
        }
    }

}

if (empty($url)) {
    $url = $_CONF['site_url'];
}
header('HTTP/1.1 301 Moved');
header('Location: ' . $url);
header('Connection: close');

?>
