<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/japanese_utf-8.php                  |
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
    'msg_error'   => 'エラー: reCAPTCHA の検証に失敗しました。',
    'entry_error' => '%1s で無効な reCAPTCHA 文字列が入力されました - IPアドレス: %2s - エラーコード: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'reCAPTCHA の設定',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'reCAPTCHA V2 サイトキー',
    'secret_key'           => 'reCAPTCHA V2 シークレットキー',
    'invisible_site_key'   => 'Invisible reCAPTCHA サイトキー',
    'invisible_secret_key' => 'Invisible reCAPTCHA シークレットキー',
    'site_key_v3'          => 'reCAPTCHA V3 サイトキー',
    'secret_key_v3'        => 'reCAPTCHA V3 シークレットキー',
    'logging'              => '無効な reCAPTCHA 試行を記録する',
    'anonymous_only'       => 'ゲストユーザーのみ',
    'remoteusers'          => 'すべてのリモートユーザーに reCAPTCHA を強制する',
    'enable_comment'       => 'コメント保護を有効にする',
    'enable_contact'       => 'お問い合わせフォーム保護を有効にする',
    'enable_emailstory'    => '記事のメール送信保護を有効にする',
    'enable_registration'  => 'ユーザー登録保護を有効にする',
    'enable_loginform'     => 'ログインフォーム保護を有効にする',
    'enable_getpassword'   => 'パスワード再設定フォーム保護を有効にする',
    'enable_story'         => '記事保護を有効にする',
    'score_comment'        => 'コメントのスコアしきい値',
    'score_contact'        => 'お問い合わせのスコアしきい値',
    'score_emailstory'     => '記事メール送信のスコアしきい値',
    'score_registration'   => 'ユーザー登録のスコアしきい値',
    'score_loginform'      => 'ログインフォームのスコアしきい値',
    'score_getpassword'    => 'パスワード再設定のスコアしきい値',
    'score_story'          => '記事のスコアしきい値',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => '主要設定',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'reCAPTCHA 設定',
    'tab_integration' => 'Geeklog 統合',
    'tab_score'       => 'スコアしきい値',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'システム',
    'fs_integration' => 'Geeklog 統合',
    'fs_score'       => 'スコアしきい値',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['はい' => 1, 'いいえ' => 0],
    2 => ['無効' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4],
];
