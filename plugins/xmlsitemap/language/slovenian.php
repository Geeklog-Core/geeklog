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
    'admin' => 'Skrbnikovo XML kazalo strani',
    'description' => 'Usually, all the sitemap files will automatically be updated whenever an item is added, changed or deleted.  If something went wrong, please update sitemap files manually by pressing the button bellow.',
    'filename' => 'File name',
    'updated' => 'Updated',
    'not_saved' => 'Not Saved',
    'update_now' => 'Update all the sitemap files now!',
    'update_success' => 'All the sitemap files were successfully updated.',
    'update_fail' => 'Failed to update sitemap files.  Please refer to the "error.log" for details.'
);

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = array(
    'label' => 'XML kazalo strani (Sitemap)',
    'title' => 'Konfiguracija za XML kazalo strani'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'Ime kazala strani',
    'mobile_sitemap_file' => 'Mobilno ime kazala strani',
    'include_homepage' => 'Homepage in Sitemap',
    'types' => 'Vsebina kazala strani',
    'lastmod' => 'Content Types to include lastmod element',
    'priorities' => 'Priority',
    'frequencies' => 'Frequency',
    'ping_google' => 'Send ping to Google',
    'ping_bing' => 'Send ping to Bing',
    'news_sitemap_file' => 'News Sitemap file name',
    'news_sitemap_topics' => 'Include Articles from these Topics',
    'news_sitemap_age' => 'Max Age of Articles'
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'Glavne nastavitve'
);

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap Main Settings',
    'tab_pri' => 'Priority',
    'tab_freq' => 'Update frequency',
    'tab_ping' => 'Ping',
    'tab_news' => 'News Sitemap'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => ' Glavne nastavitve XML kazala strani',
    'fs_pri' => 'Prioriteta (prednastavljena = 0.5, najni�ja = 0.0, najvi�ja = 1.0)',
    'fs_freq' => 'Pogostost posodobitev',
    'fs_ping' => 'Send ping on updating sitemap',
    'fs_news' => 'News Sitemap Settings'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('Da' => 1, 'Ne' => 0),
    1 => array('Da' => 'velja', 'Ne' => 'ne velja'),
    9 => array('Naprej na stran' => 'item', 'Prika�i seznam' => 'list', 'Prika�i vstopno stran' => 'home', 'Prika�i skrbnikovo stran' => 'admin'),
    12 => array('Ni dostopa' => 0, 'Samo za branje' => 2, 'Branje-pisanje' => 3),
    20 => array('vedno' => 'always', 'ob uri' => 'hourly', 'dnevno' => 'daily', 'tedensko' => 'weekly', 'mese�no' => 'monthly', 'letno' => 'yearly', 'nikoli' => 'never', 'hidden' => 'hidden')
);
