<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin                                                         |
// +---------------------------------------------------------------------------+
// | slovenian.php                                                             |
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
    'plugin' => 'XML kazalo strani (Sitemap)',
    'admin' => 'Skrbnikovo XML kazalo strani'
);

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = array(
    'label' => 'XML kazalo strani (Sitemap)',
    'title' => 'Konfiguracija za XML kazalo strani'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'Ime kazala strani',
    'mobile_sitemap_file' => 'Mobilno ime kazala strani',
    'types' => 'Vsebina kazala strani',
    'exclude' => 'Vtièniki za ikljuèitev iz kazala strani',
    'priorities' => '',
    'frequencies' => ''
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'Glavne nastavitve'
);

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap Main Settings',
    'tab_pri' => 'Priority',
    'tab_freq' => 'Update frequency'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => ' Glavne nastavitve XML kazala strani',
    'fs_pri' => 'Prioriteta (prednastavljena = 0.5, najnižja = 0.0, najvišja = 1.0)',
    'fs_freq' => 'Pogostost posodobitev'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('Da' => 1, 'Ne' => 0),
    1 => array('Da' => 'velja', 'Ne' => 'ne velja'),
    9 => array('Naprej na stran' => 'item', 'Prikaži seznam' => 'list', 'Prikaži vstopno stran' => 'home', 'Prikaži skrbnikovo stran' => 'admin'),
    12 => array('Ni dostopa' => 0, 'Samo za branje' => 2, 'Branje-pisanje' => 3),
    20 => array('vedno' => 'always', 'ob uri' => 'hourly', 'dnevno' => 'daily', 'tedensko' => 'weekly', 'meseèno' => 'monthly', 'letno' => 'yearly', 'nikoli' => 'never')
);

?>
