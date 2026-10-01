<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/chinese_traditional_utf-8.php       |
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
    'msg_error'   => '錯誤：reCAPTCHA 驗證無效。',
    'entry_error' => '在 %1s 中輸入了無效的 reCAPTCHA 字串 - IP 位址：%2s - 錯誤代碼：%3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'reCAPTCHA 設定',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'reCAPTCHA V2 網站金鑰',
    'secret_key'           => 'reCAPTCHA V2 密鑰',
    'invisible_site_key'   => '隱形 reCAPTCHA 網站金鑰',
    'invisible_secret_key' => '隱形 reCAPTCHA 密鑰',
    'site_key_v3'          => 'reCAPTCHA V3 網站金鑰',
    'secret_key_v3'        => 'reCAPTCHA V3 密鑰',
    'logging'              => '記錄無效的 reCAPTCHA 嘗試',
    'anonymous_only'       => '僅匿名使用者',
    'remoteusers'          => '對所有遠端使用者強制使用 reCAPTCHA',
    'enable_comment'       => '啟用留言支援',
    'enable_contact'       => '啟用聯絡表單支援',
    'enable_emailstory'    => '啟用文章郵件寄送支援',
    'enable_registration'  => '啟用註冊支援',
    'enable_loginform'     => '啟用登入表單支援',
    'enable_getpassword'   => '啟用密碼取回表單支援',
    'enable_story'         => '啟用文章支援',
    'score_comment'        => '留言分數門檻',
    'score_contact'        => '聯絡表單分數門檻',
    'score_emailstory'     => '文章郵件寄送分數門檻',
    'score_registration'   => '註冊分數門檻',
    'score_loginform'      => '登入表單分數門檻',
    'score_getpassword'    => '密碼取回表單分數門檻',
    'score_story'          => '文章分數門檻',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => '主要設定',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'reCAPTCHA 設定',
    'tab_integration' => 'Geeklog 整合',
    'tab_score'       => '分數門檻',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => '系統',
    'fs_integration' => 'Geeklog 整合',
    'fs_score'       => '分數門檻',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['是' => 1, '否' => 0],
    2 => ['已停用' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 隱形' => 2, 'reCAPTCHA V3' => 4],
];
