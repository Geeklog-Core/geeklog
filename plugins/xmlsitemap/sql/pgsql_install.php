<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 1.0                                                     |
// +---------------------------------------------------------------------------+
// | pgsql_install.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
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

/**
* XMLSitemap plugin installation SQL
*
* @package XMLSitemap
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), strtolower(basename(__FILE__))) !== FALSE) {
    die('This file can not be used on its own!');
}

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '../install_defaults.php';

global $_XMLSMAP_DEFAULT;

$DEFVALUES = array();

$DEFVALUES[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('xmlsitemap_filename', '" . addslashes($_XMLSMAP_DEFAULT['sitemap_file']) . "')";
$DEFVALUES[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('xmlsitemap_mobile', '" . addslashes($_XMLSMAP_DEFAULT['mobile_sitemap_file']) . "')";

?>
