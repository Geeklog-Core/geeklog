<?php

###############################################################################
# persian_utf-8.php
#
# This is the Persian language file for Geeklog recaptcha plugin
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
    die('This file cannot be used on its own!');
}

$LANG_RECAPTCHA = [
    'plugin'      => 'ری‌کپچا',
    'admin'       => 'ری‌کپچا',
    'msg_error'   => 'خطا، ری‌کپچا نامعتبر بود.',
    'entry_error' => 'یک رشته ری‌کپچا نامعتبر وارد شد در %1s - نشانی آیپی: %2s - کد های خطا: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'ری‌کپچا',
    'title' => 'پیکربندی ری‌کپچا',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'کلید سایت ری‌کپچا نسخه ۲',
    'secret_key'           => 'کلید رمز ری‌کپچا نسخه ۲',
    'invisible_site_key'   => 'کلید سایت ری‌کپچا مخفی',
    'invisible_secret_key' => 'کلید رمز ری‌کپچا مخفی',
    'logging'              => 'ثبت تلاش های ری‌کپچا نامعتبر',
    'anonymous_only'       => 'فقط ناشناس',
    'remoteusers'          => 'تحمیل ری‌کپچا برای همه کاربران از راه دور',
    'enable_comment'       => 'فعال کردن پشتیبانی نظر',
    'enable_contact'       => 'فعال کردن پشتیبانی تماس',
    'enable_emailstory'    => 'فعال کردن پشتیبانی داستان ایمیل',
    'enable_forum'         => 'فعال کردن پشتیبانی انجمن',
    'enable_registration'  => 'فعال کردن پشتیبانی ثبت نام',
    'enable_loginform'     => 'فعال کردن پشتیبانی فرم ورود',
    'enable_getpassword'   => 'فعال کردن پشتیبانی فرم دریافت رمز عبور',
    'enable_mediagallery'  => 'فعال کردن پشتیبانی گالری رسانه (کارت پستال ها)',
    'enable_rating'        => 'فعال کردن پشتیبانی رتبه بندی',
    'enable_story'         => 'فعال کردن پشتیبانی داستان',
    'enable_calendar'      => 'فعال کردن پشتیبانی افزونه تقویم',
    'enable_links'         => 'فعال کردن پشتیبانی افزونه پیوند ها',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => 'تنظیمات اصلی',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'تنظیمات ری‌کپچا',
    'tab_integration' => 'ادغام گیکلاگ',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'سیستم',
    'fs_location'    => 'جای استفاده از ری‌کپچا',
    'fs_integration' => 'ادغام گیکلاگ'
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['Yes' => 1, 'No' => 0],
    2 => ['Disabled' => 0, 'reCAPTCHA v2' => 1, 'Invisible reCAPTCHA' => 2],
];
