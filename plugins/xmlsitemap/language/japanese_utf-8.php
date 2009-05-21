<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin                                                         |
// +---------------------------------------------------------------------------+
// | japanese_utf-8.php                                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), strtolower(__FILE__)) !== FALSE) {
    die ('This file can not be used on its own.');
}

global $LANG32;

$LANG_XMLSMAP = array (
    'plugin'            => 'XMLSitemap',
    'admin'		        => 'XMLSitemap管理',
);

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = array(
    'label' => $LANG_XMLSMAP['plugin'],
    'title' => $LANG_XMLSMAP['plugin'] . 'の設定',
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file'        => 'サイトマップファイル名',
    'mobile_sitemap_file' => 'モバイルサイトマップ名',
    'types'               => 'サイトマップの内容',
    'exclude'             => 'Plugins to exclude from sitemap',
    'priorities'          => '',
    'frequencies'         => '',
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => '主要設定',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => $LANG_XMLSMAP['plugin'] . 'の主要設定',
    'fs_pri'  => '優先度（既定値 = 0.5、0.0 = 最低、1.0 = 最高）',
    'fs_freq' => '更新頻度',
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => TRUE, 'いいえ' => FALSE),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
    20 => array('常時' => 'always', '毎時間' => 'hourly', '毎日' => 'daily', '毎週' => 'weekly', '毎月' => 'monthly', '毎年' => 'yearly', '更新しない' => 'never'),
);

?>
