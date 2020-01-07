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
    'admin' => 'XMLSitemap管理'
);

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = array(
    'label' => 'XMLSitemap',
    'title' => 'XMLSitemapの設定'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'サイトマップファイル名',
    'mobile_sitemap_file' => 'モバイルサイトマップ名',
    'include_homepage' => 'トップページをサイトマップに含める',
    'types' => 'サイトマップの内容',
    'exclude' => '除外するプラグイン',
    'lastmod' => '最終編集日',
    'priorities' => '優先度',
    'frequencies' => '頻度',
    'ping_google' => 'Googleにpingを送信する',
    'ping_bing' => 'Bingにpingを送信する',
    'news_sitemap_file' => 'ニュースサイトマップ名',
    'news_sitemap_topics' => 'この話題の記事を含める',
    'news_sitemap_age' => '記事の古さの最大値'
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => '主要設定'
);

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemapの主要設定',
    'tab_pri' => '優先度',
    'tab_freq' => '更新頻度',
    'tab_ping' => 'Ping送信',
    'tab_news' => 'ニュースサイトマップ'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'XMLSitemapのメイン設定',
    'fs_pri' => '優先度(既定値 = 0.5、0.0 = 最低、1.0 = 最高)',
    'fs_freq' => '更新頻度',
    'fs_ping' => 'サイトマップ更新時にPingを送信する',
    'fs_news' => 'ニュースサイトマップの設定'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => true, 'いいえ' => false),
    9 => array('ページを表示' => 'item', 'リストを表示' => 'list', 'ホームを表示' => 'home', '管理画面のトップを表示' => 'admin'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
    20 => array('常時' => 'always', '毎時間' => 'hourly', '毎日' => 'daily', '毎週' => 'weekly', '毎月' => 'monthly', '毎年' => 'yearly', '更新しない' => 'never', 'hidden' => 'hidden')
);
