<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin                                                         |
// +---------------------------------------------------------------------------+
// | estonian.php                                                              |
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

global $LANG32;

$LANG_XMLSMAP = array(
    'plugin' => 'XMLSitemap',
    'admin' => 'XMLSitemap Admin'
);

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = array(
    'label' => 'XMLSitemap',
    'title' => 'XMLSitemap seaded'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'Saidikaardi faili nimi',
    'mobile_sitemap_file' => 'Mobile Saidikaardi faili nimi',
    'types' => 'Saidikaardi sisu',
    'exclude' => 'Saidikaardilt väljajäätavad pluginad',
    'priorities' => '',
    'frequencies' => ''
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'Peaseaded'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'XMLSitemap peaseaded',
    'fs_pri' => 'Prioriteet (vaikimisi = 0,5, madalaim = 0,0, kõrgeim= 1,0)',
    'fs_freq' => 'Uuendamise sagedus'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('Jah' => 1, 'Ei' => 0),
    1 => array('Jah' => true, 'Ei' => false),
    9 => array('Suuna edasi lehele' => 'item', 'Näita loetelu' => 'list', 'Näita avalehte' => 'home', 'Näita admini lehte' => 'admin'),
    12 => array('Pole ligipääsu' => 0, 'Ainult loetav' => 2, 'Loetav ja muudetav' => 3),
    20 => array('Alati' => 'always', 'Tunni tagant' => 'hourly', 'päeva tagant' => 'daily', 'nädala tagant' => 'weekly', 'kuu tagant' => 'monthly', 'aasta tagant' => 'yearly', 'mitte kunagi' => 'never')
);

?>
