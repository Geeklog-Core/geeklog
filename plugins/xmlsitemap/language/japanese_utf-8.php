<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 2.0                                                     |
// +---------------------------------------------------------------------------+
// | japanese_utf-8.php                                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2020 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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
    'admin' => 'XMLSitemap管理',
    'description' => '通常、項目が追加・変更・削除されるたびに、すべてのサイトマップファイルは自動的に更新されます。問題が発生した場合は、下のボタンを押して手動で更新してください。',
    'filename' => 'ファイル名',
    'updated' => '更新日時',
    'not_saved' => '未保存',
    'update_now' => 'すべてのサイトマップファイルを今すぐ更新！',
    'update_success' => 'すべてのサイトマップファイルを正常に更新しました。',
    'update_fail' => 'サイトマップファイルの更新に失敗しました。詳細は "error.log" を確認してください。',
);

$LANG_configsections['xmlsitemap'] = array('label' => 'XMLSitemap', 'title' => 'XMLSitemap設定');

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'サイトマップファイル名',
    'mobile_sitemap_file' => 'モバイルサイトマップファイル名',
    'include_homepage' => 'サイトマップにホームページを含める',
    'types' => 'サイトマップの内容',
    'lastmod' => 'lastmod要素を含めるコンテンツタイプ',
    'priorities' => '優先度',
    'frequencies' => '頻度',
    'ping_google' => 'GoogleへPingを送信',
    'indexnow' => 'IndexNowを有効にする',
    'indexnow_key' => 'IndexNowキー',
    'indexnow_key_location' => 'IndexNowキーの場所',
    'news_sitemap_file' => 'ニュースサイトマップファイル名',
    'news_sitemap_topics' => 'これらの話題の記事を含める',
    'news_sitemap_age' => '記事の最大経過日数',
);

$LANG_configsubgroups['xmlsitemap'] = array('sg_main' => '基本設定');

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap基本設定',
    'tab_pri' => '優先度',
    'tab_freq' => '更新頻度',
    'tab_ping' => 'Ping',
    'tab_news' => 'ニュースサイトマップ',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'XMLSitemap基本設定',
    'fs_pri' => '優先度（既定 = 0.5、最低 = 0.0、最高 = 1.0）',
    'fs_freq' => '更新頻度',
    'fs_ping' => '変更時にPingを送信',
    'fs_news' => 'ニュースサイトマップ設定',
);

$LANG_configselects['xmlsitemap'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => TRUE, 'いいえ' => FALSE),
    9 => array('ページへ転送' => 'item', '一覧を表示' => 'list', 'ホームを表示' => 'home', '管理画面を表示' => 'admin'),
    12 => array('アクセス不可' => 0, '読み取り専用' => 2, '読み書き' => 3),
    20 => array('常時' => 'always', '毎時' => 'hourly', '毎日' => 'daily', '毎週' => 'weekly', '毎月' => 'monthly', '毎年' => 'yearly', 'なし' => 'never', '非表示' => 'hidden'),
);
