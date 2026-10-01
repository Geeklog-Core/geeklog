<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 2.0                                                     |
// +---------------------------------------------------------------------------+
// | chinese_traditional_utf-8.php                                             |
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
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

global $LANG32;

$LANG_XMLSMAP = array(
    'plugin' => 'XMLSitemap',
    'admin' => 'XMLSitemap 管理',
    'description' => '通常，在新增、修改或刪除項目時，所有網站地圖檔案都會自動更新。如果發生問題，請使用下方按鈕手動更新網站地圖檔案。',
    'filename' => '檔案名稱',
    'updated' => '已更新',
    'not_saved' => '未儲存',
    'update_now' => '立即更新所有網站地圖檔案！',
    'update_success' => '所有網站地圖檔案已成功更新。',
    'update_fail' => '無法更新網站地圖檔案。詳細資訊請查看 "error.log"。',
);

$LANG_configsections['xmlsitemap'] = array('label' => 'XMLSitemap', 'title' => 'XMLSitemap 設定');

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => '網站地圖檔案名稱',
    'mobile_sitemap_file' => '行動網站地圖檔案名稱',
    'include_homepage' => '在網站地圖中包含首頁',
    'types' => '網站地圖內容',
    'lastmod' => '包含 lastmod 元素的內容類型',
    'priorities' => '優先順序',
    'frequencies' => '頻率',
    'ping_google' => '向 Google 傳送 Ping',
    'indexnow' => '啟用 IndexNow',
    'indexnow_key' => 'IndexNow 金鑰',
    'indexnow_key_location' => 'IndexNow 金鑰位置',
    'news_sitemap_file' => '新聞網站地圖檔案名稱',
    'news_sitemap_topics' => '包含這些主題中的文章',
    'news_sitemap_age' => '文章最長時效',
);

$LANG_configsubgroups['xmlsitemap'] = array('sg_main' => '主要設定');

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap 主要設定',
    'tab_pri' => '優先順序',
    'tab_freq' => '更新頻率',
    'tab_ping' => 'Ping',
    'tab_news' => '新聞網站地圖',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'XMLSitemap 主要設定',
    'fs_pri' => '優先順序（預設 = 0.5，最低 = 0.0，最高 = 1.0）',
    'fs_freq' => '更新頻率',
    'fs_ping' => '內容變更時傳送 Ping',
    'fs_news' => '新聞網站地圖設定',
);

$LANG_configselects['xmlsitemap'] = array(
    0 => array('是' => 1, '否' => 0),
    1 => array('是' => TRUE, '否' => FALSE),
    9 => array('前往頁面' => 'item', '顯示清單' => 'list', '顯示首頁' => 'home', '顯示管理頁面' => 'admin'),
    12 => array('無權存取' => 0, '唯讀' => 2, '讀寫' => 3),
    20 => array('總是' => 'always', '每小時' => 'hourly', '每天' => 'daily', '每週' => 'weekly', '每月' => 'monthly', '每年' => 'yearly', '從不' => 'never', '隱藏' => 'hidden'),
);
