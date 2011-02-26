<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin                                                         |
// +---------------------------------------------------------------------------+
// | german_utf-8.php                                                          |
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
    'title' => 'XMLSitemap Konfiguration'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'Dateiname der Sitemap',
    'mobile_sitemap_file' => 'Dateiname der Mobile Sitemap',
    'types' => 'Inhalt der Sitemap',
    'exclude' => 'Plugins, die nicht in der Sitemap erscheinen sollen',
    'priorities' => '',
    'frequencies' => ''
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'Haupteinstellung'
);

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap Main Settings',
    'tab_pri' => 'Priority',
    'tab_freq' => 'Update frequency'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'XMLSitemap Haupteinstellung',
    'fs_pri' => 'Vorrang (Grundeinstellung = 0.5, niedrigste = 0.0, höchste = 1.0)',
    'fs_freq' => 'Updatehäufigkeit'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('Richtig' => 1, 'Falsch' => 0),
    1 => array('Richtig' => true, 'Falsch' => false),
    9 => array('Weiterleiten zu Seite' => 'item', 'Liste anzeigen' => 'list', 'Home anzeigen' => 'home', 'Admin anzeigen' => 'admin'),
    12 => array('Kein Zugang' => 0, 'Nur lesen' => 2, 'Lesen-schreiben' => 3),
    20 => array('immer' => 'always', 'stündlich' => 'hourly', 'täglich' => 'daily', 'wöchentlich' => 'weekly', 'monatlich' => 'monthly', 'jährlich' => 'yearly', 'nie' => 'never')
);

?>
