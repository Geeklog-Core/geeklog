<?php

###############################################################################
# persian_utf-8.php
#
# This is the Persian language file for Geeklog xmlsitemap plugin
# Special thanks to Mahdi Montazeri for his work on this project
#
# Copyright (C) 2018 geeklog.ir
# info AT mahdimontazeri DOT com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

global $LANG32;

$LANG_XMLSMAP = array(
    'plugin' => 'نقشه سایت اکس ام ال',
    'admin' => 'مدیریت نقشه سایت اکس ام ال',
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
    'label' => 'نقشه سایت اکس ام ال',
    'title' => 'پیکربندی نقشه سایت اکس ام ال'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'نام پرونده نقشه سایت',
    'mobile_sitemap_file' => 'نام پرونده نقشه سایت موبایلی',
    'include_homepage' => 'Homepage in Sitemap',
    'types' => 'محتویات نقشه سایت',
    'lastmod' => 'انواع محتوا برای در برداشتن عنصر lastmod',
    'priorities' => 'اولویت',
    'frequencies' => 'بسامد',
    'ping_google' => 'ارسال پینگ به گوگل',
    'indexnow' => 'Enable IndexNow',
    'indexnow_key' => 'IndexNow Key',
    'indexnow_key_location' => 'IndexNow Key Location',
    'news_sitemap_file' => 'News Sitemap file name',
    'news_sitemap_topics' => 'Include Articles from these Topics',
    'news_sitemap_age' => 'Max Age of Articles'
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'تنظیمات اصلی'
);

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'تنظیمات اصلی نقشه سایت اکس ام ال',
    'tab_pri' => 'اولویت',
    'tab_freq' => 'بروزرسانی بسامد',
    'tab_ping' => 'پینگ',
    'tab_news' => 'News Sitemap'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'تنظیمات اصلی نقشه سایت اکس ام ال',
    'fs_pri' => 'اولویت (پیشفرض = 0.5, پایین ترین = 0.0, بالا ترین = 1.0)',
    'fs_freq' => 'بروزرسانی بسامد',
    'fs_ping' => 'ارسال پینگ برای بروزرسانی نقشه سایت',
    'fs_news' => 'News Sitemap Settings'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    20 => array('always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never', 'hidden' => 'hidden')
);
