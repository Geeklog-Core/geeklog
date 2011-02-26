<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin                                                         |
// +---------------------------------------------------------------------------+
// | english_utf-8.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// +---------------------------------------------------------------------------|
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

if (strpos(strtolower($_SERVER['PHP_SELF']), strtolower(__FILE__)) !== FALSE) {
    die ('This file can not be used on its own.');
}

global $LANG32;

$LANG_XMLSMAP = array(
    'plugin'            => 'XMLSitemap',
    'admin'		        => 'XMLSitemap Admin',
);

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = array(
    'label' => 'XMLSitemap',
    'title' => 'XMLSitemap Configuration'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file'        => 'Sitemap file name',
    'mobile_sitemap_file' => 'Mobile Sitemap file name',
    'types'               => 'Contents of sitemap',
    'exclude'             => 'Plugins to exclude from sitemap',
    'priorities'          => '',
    'frequencies'         => '',
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'Main Settings',
);

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap Main Settings',
    'tab_pri'  => 'Priority',
    'tab_freq' => 'Update frequency',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'XMLSitemap Main Settings',
    'fs_pri'  => 'Priority (default = 0.5, lowest = 0.0, highest = 1.0)',
    'fs_freq' => 'Update frequency',
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => TRUE, 'False' => FALSE),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    20 => array('always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never'),
);

?>
