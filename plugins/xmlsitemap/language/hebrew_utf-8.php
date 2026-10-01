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
    'description' => 'בדרך כלל כל קובצי מפת האתר מתעדכנים אוטומטית כאשר פריט נוסף, משתנה או נמחק. אם אירעה בעיה, עדכן את קובצי מפת האתר ידנית באמצעות הכפתור למטה.',
    'filename' => 'שם קובץ',
    'updated' => 'עודכן',
    'not_saved' => 'לא נשמר',
    'update_now' => 'עדכן עכשיו את כל קובצי מפת האתר!',
    'update_success' => 'כל קובצי מפת האתר עודכנו בהצלחה.',
    'update_fail' => 'עדכון קובצי מפת האתר נכשל. לפרטים עיין ב-"error.log".',
);

$LANG_configsections['xmlsitemap'] = array('label' => 'XMLSitemap', 'title' => 'הגדרות XMLSitemap');

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'שם קובץ מפת האתר',
    'mobile_sitemap_file' => 'שם קובץ מפת האתר לנייד',
    'include_homepage' => 'דף הבית במפת האתר',
    'types' => 'תוכן מפת האתר',
    'lastmod' => 'סוגי תוכן שיכללו את רכיב lastmod',
    'priorities' => 'עדיפות',
    'frequencies' => 'תדירות',
    'ping_google' => 'שלח ping ל-Google',
    'indexnow' => 'הפעל IndexNow',
    'indexnow_key' => 'מפתח IndexNow',
    'indexnow_key_location' => 'מיקום מפתח IndexNow',
    'news_sitemap_file' => 'שם קובץ מפת אתר לחדשות',
    'news_sitemap_topics' => 'כלול מאמרים מנושאים אלה',
    'news_sitemap_age' => 'גיל מרבי של מאמרים',
);

$LANG_configsubgroups['xmlsitemap'] = array('sg_main' => 'הגדרות ראשיות');

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'הגדרות ראשיות של XMLSitemap',
    'tab_pri' => 'עדיפות',
    'tab_freq' => 'תדירות עדכון',
    'tab_ping' => 'Ping',
    'tab_news' => 'מפת אתר לחדשות',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'הגדרות ראשיות של XMLSitemap',
    'fs_pri' => 'עדיפות (ברירת מחדל = 0.5, הנמוכה ביותר = 0.0, הגבוהה ביותר = 1.0)',
    'fs_freq' => 'תדירות עדכון',
    'fs_ping' => 'שלח ping בעת שינוי',
    'fs_news' => 'הגדרות מפת אתר לחדשות',
);

$LANG_configselects['xmlsitemap'] = array(
    0 => array('כן' => 1, 'לא' => 0),
    1 => array('כן' => TRUE, 'לא' => FALSE),
    9 => array('העבר לדף' => 'item', 'הצג רשימה' => 'list', 'הצג דף בית' => 'home', 'הצג ניהול' => 'admin'),
    12 => array('ללא גישה' => 0, 'קריאה בלבד' => 2, 'קריאה-כתיבה' => 3),
    20 => array('תמיד' => 'always', 'כל שעה' => 'hourly', 'יומי' => 'daily', 'שבועי' => 'weekly', 'חודשי' => 'monthly', 'שנתי' => 'yearly', 'לעולם לא' => 'never', 'מוסתר' => 'hidden'),
);
