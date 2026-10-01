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
    'plugin' => 'XMLSitemap',
    'admin' => 'مدیریت XMLSitemap',
    'description' => 'معمولاً همه فایل‌های نقشه سایت هنگام افزودن، تغییر یا حذف یک مورد به‌طور خودکار به‌روزرسانی می‌شوند. اگر مشکلی رخ داد، فایل‌های نقشه سایت را با دکمه زیر به‌صورت دستی به‌روزرسانی کنید.',
    'filename' => 'نام فایل',
    'updated' => 'به‌روزرسانی‌شده',
    'not_saved' => 'ذخیره نشده',
    'update_now' => 'همه فایل‌های نقشه سایت را اکنون به‌روزرسانی کن!',
    'update_success' => 'همه فایل‌های نقشه سایت با موفقیت به‌روزرسانی شدند.',
    'update_fail' => 'به‌روزرسانی فایل‌های نقشه سایت ناموفق بود. برای جزئیات به "error.log" مراجعه کنید.',
);

$LANG_configsections['xmlsitemap'] = array('label' => 'XMLSitemap', 'title' => 'پیکربندی XMLSitemap');

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'نام فایل نقشه سایت',
    'mobile_sitemap_file' => 'نام فایل نقشه سایت موبایل',
    'include_homepage' => 'صفحه اصلی در نقشه سایت',
    'types' => 'محتوای نقشه سایت',
    'lastmod' => 'انواع محتوا برای درج عنصر lastmod',
    'priorities' => 'اولویت',
    'frequencies' => 'تناوب',
    'ping_google' => 'ارسال ping به Google',
    'indexnow' => 'فعال‌کردن IndexNow',
    'indexnow_key' => 'کلید IndexNow',
    'indexnow_key_location' => 'محل کلید IndexNow',
    'news_sitemap_file' => 'نام فایل نقشه سایت اخبار',
    'news_sitemap_topics' => 'مقاله‌های این موضوعات را شامل کن',
    'news_sitemap_age' => 'حداکثر سن مقاله‌ها',
);

$LANG_configsubgroups['xmlsitemap'] = array('sg_main' => 'تنظیمات اصلی');

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'تنظیمات اصلی XMLSitemap',
    'tab_pri' => 'اولویت',
    'tab_freq' => 'تناوب به‌روزرسانی',
    'tab_ping' => 'Ping',
    'tab_news' => 'نقشه سایت اخبار',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'تنظیمات اصلی XMLSitemap',
    'fs_pri' => 'اولویت (پیش‌فرض = 0.5، کمترین = 0.0، بیشترین = 1.0)',
    'fs_freq' => 'تناوب به‌روزرسانی',
    'fs_ping' => 'ارسال ping هنگام تغییر',
    'fs_news' => 'تنظیمات نقشه سایت اخبار',
);

$LANG_configselects['xmlsitemap'] = array(
    0 => array('بله' => 1, 'خیر' => 0),
    1 => array('بله' => TRUE, 'خیر' => FALSE),
    9 => array('هدایت به صفحه' => 'item', 'نمایش فهرست' => 'list', 'نمایش صفحه اصلی' => 'home', 'نمایش مدیریت' => 'admin'),
    12 => array('بدون دسترسی' => 0, 'فقط خواندنی' => 2, 'خواندن-نوشتن' => 3),
    20 => array('همیشه' => 'always', 'ساعتی' => 'hourly', 'روزانه' => 'daily', 'هفتگی' => 'weekly', 'ماهانه' => 'monthly', 'سالانه' => 'yearly', 'هرگز' => 'never', 'پنهان' => 'hidden'),
);
