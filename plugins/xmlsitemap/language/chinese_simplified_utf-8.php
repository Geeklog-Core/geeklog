<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 2.0                                                     |
// +---------------------------------------------------------------------------+
// | chinese_simplified_utf-8.php                                              |
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
    'description' => '通常，在添加、修改或删除项目时，所有站点地图文件都会自动更新。如果出现问题，请使用下方按钮手动更新站点地图文件。',
    'filename' => '文件名',
    'updated' => '已更新',
    'not_saved' => '未保存',
    'update_now' => '立即更新所有站点地图文件！',
    'update_success' => '所有站点地图文件已成功更新。',
    'update_fail' => '更新站点地图文件失败。详情请查看 "error.log"。',
);

$LANG_configsections['xmlsitemap'] = array('label' => 'XMLSitemap', 'title' => 'XMLSitemap 配置');

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => '站点地图文件名',
    'mobile_sitemap_file' => '移动站点地图文件名',
    'include_homepage' => '在站点地图中包含首页',
    'types' => '站点地图内容',
    'lastmod' => '包含 lastmod 元素的内容类型',
    'priorities' => '优先级',
    'frequencies' => '频率',
    'ping_google' => '向 Google 发送 Ping',
    'indexnow' => '启用 IndexNow',
    'indexnow_key' => 'IndexNow 密钥',
    'indexnow_key_location' => 'IndexNow 密钥位置',
    'news_sitemap_file' => '新闻站点地图文件名',
    'news_sitemap_topics' => '包含这些主题中的文章',
    'news_sitemap_age' => '文章最大时效',
);

$LANG_configsubgroups['xmlsitemap'] = array('sg_main' => '主要设置');

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap 主要设置',
    'tab_pri' => '优先级',
    'tab_freq' => '更新频率',
    'tab_ping' => 'Ping',
    'tab_news' => '新闻站点地图',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'XMLSitemap 主要设置',
    'fs_pri' => '优先级（默认 = 0.5，最低 = 0.0，最高 = 1.0）',
    'fs_freq' => '更新频率',
    'fs_ping' => '内容变化时发送 Ping',
    'fs_news' => '新闻站点地图设置',
);

$LANG_configselects['xmlsitemap'] = array(
    0 => array('是' => 1, '否' => 0),
    1 => array('是' => TRUE, '否' => FALSE),
    9 => array('转到页面' => 'item', '显示列表' => 'list', '显示首页' => 'home', '显示管理页面' => 'admin'),
    12 => array('无权访问' => 0, '只读' => 2, '读写' => 3),
    20 => array('总是' => 'always', '每小时' => 'hourly', '每天' => 'daily', '每周' => 'weekly', '每月' => 'monthly', '每年' => 'yearly', '从不' => 'never', '隐藏' => 'hidden'),
);
