<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/japanese_utf-8.php                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014-2020 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Based on the CAPTCHA Plugin by Ben                                        |
// |                                                   - ben AT geeklog DOT fr |
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
// +---------------------------------------------------------------------------|

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own!');
}

$LANG_RECAPTCHA = [
    'plugin'      => 'reCAPTCHA',
    'admin'       => 'reCAPTCHA',
    'msg_error'   => 'エラーが発生しました。reCAPTCHAがリクエストを拒否しました。',
    'entry_error' => '%1sで無効な入力を検出しました。IPアドレス: %2s  エラーコード: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'reCAPTCHAの設定',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'reCAPTCHA V2 Site Key',
    'secret_key'           => 'reCAPTCHA V2 Secret Key',
    'invisible_site_key'   => 'Invisible reCAPTCHA Site Key',
    'invisible_secret_key' => 'Invisible reCAPTCHA Secret Key',
    'site_key_v3'          => 'reCAPTCHA V3 Site Key',
    'secret_key_v3'        => 'reCAPTCHA V3 Secret Key',
    'logging'              => '無効な入力をログファイルに記録する',
    'anonymous_only'       => 'ゲストユーザーに対してのみ使用する',
    'remoteusers'          => 'リモートユーザー全員に強制する',
    'enable_comment'       => 'コメントをサポートする',
    'enable_contact'       => 'メール送信をサポートする',
    'enable_emailstory'    => '「記事をメールする」をサポートする',
    'enable_registration'  => 'ユーザー登録をサポートする',
    'enable_loginform'     => 'ログインフォームをサポートする',
    'enable_getpassword'   => 'パスワード再設定フォームをサポートする',
    'enable_story'         => '記事投稿をサポートする',
    'score_comment'        => 'コメント用のスコア',
    'score_contact'        => 'メール送信用のスコア',
    'score_emailstory'     => '「記事をメールする」用のスコア',
    'score_registration'   => 'ユーザー登録用のスコア',
    'score_loginform'      => 'ログインフォーム用のスコア',
    'score_getpassword'    => 'パスワード再設定フォーム用のスコア',
    'score_story'          => '記事投稿用のスコア',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => '主要設定',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'reCAPTCHA設定',
    'tab_integration' => 'Geeklogへの統合',
    'tab_score'       => 'スコア',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'システム',
    'fs_integration' => 'Geeklogへの統合',
    'fs_score'       => 'スコア',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['はい' => 1, 'いいえ' => 0],
    2 => ['無効' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4],
];
