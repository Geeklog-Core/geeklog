<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin                                                         |
// +---------------------------------------------------------------------------+
// | german_formal_utf-8.php                                                   |
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
    'admin' => 'XMLSitemap-Verwaltung',
    'description' => 'Normalerweise werden alle Sitemap-Dateien automatisch aktualisiert, wenn ein Eintrag hinzugefügt, geändert oder gelöscht wird. Falls etwas schiefgeht, aktualisieren Sie die Sitemap-Dateien bitte manuell mit der Schaltfläche unten.',
    'filename' => 'Dateiname',
    'updated' => 'Aktualisiert',
    'not_saved' => 'Nicht gespeichert',
    'update_now' => 'Alle Sitemap-Dateien jetzt aktualisieren!',
    'update_success' => 'Alle Sitemap-Dateien wurden erfolgreich aktualisiert.',
    'update_fail' => 'Die Sitemap-Dateien konnten nicht aktualisiert werden. Einzelheiten finden Sie in der "error.log".',
);

$LANG_configsections['xmlsitemap'] = array('label' => 'XMLSitemap', 'title' => 'XMLSitemap-Konfiguration');

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'Name der Sitemap-Datei',
    'mobile_sitemap_file' => 'Name der mobilen Sitemap-Datei',
    'include_homepage' => 'Startseite in Sitemap',
    'types' => 'Inhalt der Sitemap',
    'lastmod' => 'Inhaltstypen mit lastmod-Element',
    'priorities' => 'Priorität',
    'frequencies' => 'Häufigkeit',
    'ping_google' => 'Ping an Google senden',
    'indexnow' => 'IndexNow aktivieren',
    'indexnow_key' => 'IndexNow-Schlüssel',
    'indexnow_key_location' => 'Speicherort des IndexNow-Schlüssels',
    'news_sitemap_file' => 'Name der News-Sitemap-Datei',
    'news_sitemap_topics' => 'Artikel aus diesen Themen einbeziehen',
    'news_sitemap_age' => 'Maximales Alter der Artikel',
);

$LANG_configsubgroups['xmlsitemap'] = array('sg_main' => 'Haupteinstellungen');

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap-Haupteinstellungen',
    'tab_pri' => 'Priorität',
    'tab_freq' => 'Aktualisierungshäufigkeit',
    'tab_ping' => 'Ping',
    'tab_news' => 'News-Sitemap',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'XMLSitemap-Haupteinstellungen',
    'fs_pri' => 'Priorität (Standard = 0,5, niedrigste = 0,0, höchste = 1,0)',
    'fs_freq' => 'Aktualisierungshäufigkeit',
    'fs_ping' => 'Bei Änderung Ping senden',
    'fs_news' => 'News-Sitemap-Einstellungen',
);

$LANG_configselects['xmlsitemap'] = array(
    0 => array('Ja' => 1, 'Nein' => 0),
    1 => array('Ja' => TRUE, 'Nein' => FALSE),
    9 => array('Zur Seite weiterleiten' => 'item', 'Liste anzeigen' => 'list', 'Startseite anzeigen' => 'home', 'Administration anzeigen' => 'admin'),
    12 => array('Kein Zugriff' => 0, 'Nur Lesen' => 2, 'Lesen-Schreiben' => 3),
    20 => array('immer' => 'always', 'stündlich' => 'hourly', 'täglich' => 'daily', 'wöchentlich' => 'weekly', 'monatlich' => 'monthly', 'jährlich' => 'yearly', 'nie' => 'never', 'versteckt' => 'hidden'),
);
