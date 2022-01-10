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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

global $LANG32;

$LANG_XMLSMAP = [
    'plugin' => 'نقشه سایت اکس ام ال',
    'admin'  => 'مدیریت نقشه سایت اکس ام ال',
];

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = [
    'label' => 'نقشه سایت اکس ام ال',
    'title' => 'پیکربندی نقشه سایت اکس ام ال'
];

$LANG_confignames['xmlsitemap'] = [
    'sitemap_file'        => 'نام پرونده نقشه سایت',
    'mobile_sitemap_file' => 'نام پرونده نقشه سایت موبایلی',
    'types'               => 'محتویات نقشه سایت',
    'exclude'             => 'افزونه های مستثنی از نقشه سایت',
    'lastmod'             => 'انواع محتوا برای در برداشتن عنصر lastmod',
    'priorities'          => 'اولویت',
    'frequencies'         => 'بسامد',
    'ping_google'         => 'ارسال پینگ به گوگل',
    'ping_bing'           => 'ارسال پینگ به بینگ',
];

$LANG_configsubgroups['xmlsitemap'] = [
    'sg_main' => 'تنظیمات اصلی',
];

$LANG_tab['xmlsitemap'] = [
    'tab_main' => 'تنظیمات اصلی نقشه سایت اکس ام ال',
    'tab_pri'  => 'اولویت',
    'tab_freq' => 'بروزرسانی بسامد',
    'tab_ping' => 'پینگ',
];

$LANG_fs['xmlsitemap'] = [
    'fs_main' => 'تنظیمات اصلی نقشه سایت اکس ام ال',
    'fs_pri'  => 'اولویت (پیشفرض = 0.5, پایین ترین = 0.0, بالا ترین = 1.0)',
    'fs_freq' => 'بروزرسانی بسامد',
    'fs_ping' => 'ارسال پینگ برای بروزرسانی نقشه سایت',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = [
    0  => ['True' => 1, 'False' => 0],
    1  => ['True' => true, 'False' => false],
    9  => ['Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'],
    12 => ['No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3],
    20 => ['always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never', 'hidden' => 'hidden'],
];
