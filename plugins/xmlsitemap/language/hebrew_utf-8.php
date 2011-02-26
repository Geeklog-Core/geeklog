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
    'admin' => 'ניהול XMLSitemap'
);

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = array(
    'label' => 'XMLSitemap',
    'title' => 'כיוון XMLSitemap'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'שם קובץ Sitemap',
    'mobile_sitemap_file' => 'שם קובץ Mobile Sitemap',
    'types' => 'תוכן ה-sitemap',
    'exclude' => 'Plugins שלא יכללו ב-sitemap',
    'priorities' => '',
    'frequencies' => ''
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'הגדרות כלליות'
);

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap Main Settings',
    'tab_pri' => 'Priority',
    'tab_freq' => 'Update frequency'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'ההגדרות הכלליות של XMLSitemap',
    'fs_pri' => 'עדיפות (ברירת המחדל = 0.5, הכי נמוך = 0.0, הכי גבוה = 1.0)',
    'fs_freq' => 'תדירות עדכונים'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('כן' => 1, 'לא' => 0),
    1 => array('כן' => true, 'לא' => false),
    9 => array('הפנייה לעמוד' => 'item', 'הצגת רשימה' => 'list', 'הצגת דף הבית' => 'home', 'הצגת דף הניהול' => 'admin'),
    12 => array('אין גישה' => 0, 'קריאה בלבד' => 2, 'קריאה וכתיבה' => 3),
    20 => array('תמיד' => 'always', 'כל שעה' => 'hourly', 'יומי' => 'daily', 'שבועי' => 'weekly', 'חודשי' => 'monthly', 'שנתי' => 'yearly', 'אף פעם' => 'never')
);

?>
