<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/persian_utf-8.php                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014-2020 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Based on the CAPTCHA Plugin by Ben                                        |
// |                                                - ben AT geeklog DOT fr    |
// | Based on the original CAPTCHA Plugin by Mark R. Evans                     |
// |                                                - mark AT glfusion DOT org |
// | Constructed with the Universal Plugin                                     |
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
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own!');
}

$LANG_RECAPTCHA = [
    'plugin'      => 'reCAPTCHA',
    'admin'       => 'reCAPTCHA',
    'msg_error'   => 'خطا: اعتبارسنجی reCAPTCHA نامعتبر بود.',
    'entry_error' => 'یک رشته نامعتبر reCAPTCHA در %1s وارد شد - نشانی IP: %2s - کدهای خطا: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'پیکربندی reCAPTCHA',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'کلید سایت reCAPTCHA V2',
    'secret_key'           => 'کلید مخفی reCAPTCHA V2',
    'invisible_site_key'   => 'کلید سایت reCAPTCHA نامرئی',
    'invisible_secret_key' => 'کلید مخفی reCAPTCHA نامرئی',
    'site_key_v3'          => 'کلید سایت reCAPTCHA V3',
    'secret_key_v3'        => 'کلید مخفی reCAPTCHA V3',
    'logging'              => 'ثبت تلاش‌های نامعتبر reCAPTCHA',
    'anonymous_only'       => 'فقط کاربران ناشناس',
    'remoteusers'          => 'اجباری کردن reCAPTCHA برای همه کاربران راه دور',
    'enable_comment'       => 'فعال کردن محافظت از نظرها',
    'enable_contact'       => 'فعال کردن محافظت از فرم تماس',
    'enable_emailstory'    => 'فعال کردن محافظت از ارسال مطلب با ایمیل',
    'enable_registration'  => 'فعال کردن محافظت از ثبت‌نام',
    'enable_loginform'     => 'فعال کردن محافظت از فرم ورود',
    'enable_getpassword'   => 'فعال کردن محافظت از فرم بازیابی گذرواژه',
    'enable_story'         => 'فعال کردن محافظت از مطلب',
    'score_comment'        => 'آستانه امتیاز برای نظر',
    'score_contact'        => 'آستانه امتیاز برای تماس',
    'score_emailstory'     => 'آستانه امتیاز برای ارسال مطلب با ایمیل',
    'score_registration'   => 'آستانه امتیاز برای ثبت‌نام',
    'score_loginform'      => 'آستانه امتیاز برای ورود',
    'score_getpassword'    => 'آستانه امتیاز برای بازیابی گذرواژه',
    'score_story'          => 'آستانه امتیاز برای مطلب',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => 'تنظیمات اصلی',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'تنظیمات reCAPTCHA',
    'tab_integration' => 'یکپارچه‌سازی Geeklog',
    'tab_score'       => 'آستانه‌های امتیاز',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'سیستم',
    'fs_integration' => 'یکپارچه‌سازی Geeklog',
    'fs_score'       => 'آستانه‌های امتیاز',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['بله' => 1, 'خیر' => 0],
    2 => ['غیرفعال' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 نامرئی' => 2, 'reCAPTCHA V3' => 4],
];
