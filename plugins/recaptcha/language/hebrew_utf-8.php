<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/hebrew_utf-8.php                    |
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
    'msg_error'   => 'שגיאה: אימות reCAPTCHA נכשל.',
    'entry_error' => 'מחרוזת reCAPTCHA לא תקינה הוזנה ב-%1s - כתובת IP: %2s - קודי שגיאה: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'הגדרות reCAPTCHA',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'מפתח אתר reCAPTCHA V2',
    'secret_key'           => 'מפתח סודי reCAPTCHA V2',
    'invisible_site_key'   => 'מפתח אתר reCAPTCHA בלתי נראה',
    'invisible_secret_key' => 'מפתח סודי reCAPTCHA בלתי נראה',
    'site_key_v3'          => 'מפתח אתר reCAPTCHA V3',
    'secret_key_v3'        => 'מפתח סודי reCAPTCHA V3',
    'logging'              => 'רישום ניסיונות reCAPTCHA לא תקינים',
    'anonymous_only'       => 'משתמשים אנונימיים בלבד',
    'remoteusers'          => 'כפיית reCAPTCHA על כל המשתמשים המרוחקים',
    'enable_comment'       => 'הפעלת הגנה על תגובות',
    'enable_contact'       => 'הפעלת הגנה על טופס יצירת קשר',
    'enable_emailstory'    => 'הפעלת הגנה על שליחת כתבה בדוא״ל',
    'enable_registration'  => 'הפעלת הגנה על הרשמה',
    'enable_loginform'     => 'הפעלת הגנה על טופס התחברות',
    'enable_getpassword'   => 'הפעלת הגנה על טופס שחזור סיסמה',
    'enable_story'         => 'הפעלת הגנה על כתבות',
    'score_comment'        => 'סף ציון לתגובות',
    'score_contact'        => 'סף ציון לטופס יצירת קשר',
    'score_emailstory'     => 'סף ציון לשליחת כתבה בדוא״ל',
    'score_registration'   => 'סף ציון להרשמה',
    'score_loginform'      => 'סף ציון לטופס התחברות',
    'score_getpassword'    => 'סף ציון לשחזור סיסמה',
    'score_story'          => 'סף ציון לכתבות',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => 'הגדרות ראשיות',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'הגדרות reCAPTCHA',
    'tab_integration' => 'שילוב Geeklog',
    'tab_score'       => 'ספי ציון',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'מערכת',
    'fs_integration' => 'שילוב Geeklog',
    'fs_score'       => 'ספי ציון',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['כן' => 1, 'לא' => 0],
    2 => ['מושבת' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 בלתי נראה' => 2, 'reCAPTCHA V3' => 4],
];
