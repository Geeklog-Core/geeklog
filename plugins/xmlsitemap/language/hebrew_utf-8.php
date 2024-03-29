<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin                                                         |
// +---------------------------------------------------------------------------+
// | hebrew_utf-8.php                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: http://lior.weissbrod.com                                        |
// |          Version: 1.6#1                                                   |
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
    'admin' => 'ניהול XMLSitemap',
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
    'label' => 'XMLSitemap',
    'title' => 'כיוון XMLSitemap'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'שם קובץ Sitemap',
    'mobile_sitemap_file' => 'שם קובץ Mobile Sitemap',
    'include_homepage' => 'Homepage in Sitemap',
    'types' => 'תוכן ה-sitemap',
    'lastmod' => 'Content Types to include lastmod element',
    'priorities' => 'Priority',
    'frequencies' => 'Frequency',
    'ping_google' => 'Send ping to Google',
    'indexnow' => 'Enable IndexNow',
    'indexnow_key' => 'IndexNow Key',
    'indexnow_key_location' => 'IndexNow Key Location',
    'news_sitemap_file' => 'News Sitemap file name',
    'news_sitemap_topics' => 'Include Articles from these Topics',
    'news_sitemap_age' => 'Max Age of Articles'
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'הגדרות כלליות'
);

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'הגדרות כלליות של XMLSitemap',
    'tab_pri' => 'עדיפות',
    'tab_freq' => 'תכיפות עדכונים',
    'tab_ping' => 'Ping',
    'tab_news' => 'News Sitemap'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'ההגדרות הכלליות של XMLSitemap',
    'fs_pri' => 'עדיפות (ברירת המחדל = 0.5, הכי נמוך = 0.0, הכי גבוה = 1.0)',
    'fs_freq' => 'תדירות עדכונים',
    'fs_ping' => 'Send ping on updating sitemap',
    'fs_news' => 'News Sitemap Settings'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('כן' => 1, 'לא' => 0),
    1 => array('כן' => true, 'לא' => false),
    9 => array('הפנייה לעמוד' => 'item', 'הצגת רשימה' => 'list', 'הצגת דף הבית' => 'home', 'הצגת דף הניהול' => 'admin'),
    12 => array('אין גישה' => 0, 'קריאה בלבד' => 2, 'קריאה וכתיבה' => 3),
    20 => array('תמיד' => 'always', 'כל שעה' => 'hourly', 'יומי' => 'daily', 'שבועי' => 'weekly', 'חודשי' => 'monthly', 'שנתי' => 'yearly', 'אף פעם' => 'never', 'hidden' => 'hidden')
);
