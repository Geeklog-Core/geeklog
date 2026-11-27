<?php

###############################################################################
# chinese_traditional_utf-8.php
#
# This is the Traditional Chinese language file for the Geeklog Calendar plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony AT tonybibbs DOT com
# Copyright (C) 2005 Trinity Bays
# trinity93 AT gmail DOT com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => '活動行事曆',
    2 => '抱歉，沒有可顯示的活動。',
    3 => '時間',
    4 => '地點',
    5 => '描述',
    6 => '添加活動',
    7 => '即將举行的活動',
    8 => '將此活動添加到您的行事曆後，可在用戶功能區點擊“我的行事曆”，快速查看您感興趣的活動。',
    9 => '添加到我的行事曆',
    10 => '從我的行事曆移除',
    11 => "正在將活動添加到 %s 的行事曆",
    12 => '活動',
    13 => '開始',
    14 => '結束',
    15 => '返回行事曆',
    16 => '行事曆',
    17 => '開始日期',
    18 => '結束日期',
    19 => '行事曆活動提交',
    20 => '標題',
    21 => '開始日期',
    22 => 'URL',
    23 => '您的活動',
    24 => '網站活動',
    25 => '沒有即將举行的活動',
    26 => '提交活動',
    27 => "向 {$_CONF['site_name']} 提交活動後，該活動會進入主行事曆，用戶可以選擇將其添加到個人行事曆。此功能<b>不用於</b>保存生日、紀念日等個人活動。<br" . XHTML . "><br" . XHTML . ">活動提交後會發送給管理員審核，審核通過後將顯示在主行事曆中。",
    28 => '標題',
    29 => '結束時間',
    30 => '開始時間',
    31 => '全天活動',
    32 => '地址第1行',
    33 => '地址第2行',
    34 => '城市/城鎮',
    35 => '縣市/州',
    36 => '郵遞區號',
    37 => '活動類型',
    38 => '編輯活動類型',
    39 => '地點',
    40 => '將活動添加到',
    41 => '主行事曆',
    42 => '個人行事曆',
    43 => '鏈接',
    44 => '不允許使用 HTML 標簽',
    45 => '提交',
    46 => '系統中的活動',
    47 => '十大活動',
    48 => '點擊次數',
    49 => '此網站似乎沒有活動，或者尚無人點擊任何活動。',
    50 => '活動',
    51 => '刪除',
    'autotag_desc_event' => '[event: id 可選標題] - 顯示指向行事曆活動的鏈接，並使用活動標題作為鏈接標題。可以指定替代標題，但不是必需的。'
);

$_LANG_CAL_SEARCH = array(
    'results' => '行事曆結果',
    'title' => '標題',
    'date_time' => '日期和時間',
    'location' => '地點',
    'description' => '描述'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '添加個人活動',
    9 => '%s 活動',
    10 => '活動：',
    11 => '主行事曆',
    12 => '我的行事曆',
    25 => '返回 ',
    26 => '全天',
    27 => '周',
    28 => '個人行事曆：',
    29 => '公共行事曆',
    30 => '刪除活動',
    31 => '添加',
    32 => '活動',
    33 => '日期',
    34 => '時間',
    35 => '快速添加',
    36 => '提交',
    37 => '抱歉，此網站未啟用個人行事曆功能',
    38 => '個人活動編輯器',
    39 => '日',
    40 => '周',
    41 => '月',
    42 => '添加主行事曆活動',
    43 => '活動提交',
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => '活動編輯器',
    2 => '錯誤',
    3 => '發布模式',
    4 => '活動 URL',
    5 => '活動開始日期',
    6 => '活動結束日期',
    7 => '活動地點',
    8 => '活動描述',
    9 => '（包括 http://）',
    10 => '必須提供日期/時間、活動標題和描述',
    11 => '行事曆管理',
    12 => '要修改或刪除活動，請點擊下方該活動的編輯圖標。要創建新活動，請點擊上方的“新建”。點擊復制圖標可復制現有活動。',
    13 => '作者',
    14 => '開始日期',
    15 => '結束日期',
    16 => '',
    17 => "您正在嘗試訪問無權查看的活動，此次嘗試已被記錄。請<a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">返回活動管理頁面</a>。",
    18 => '',
    19 => '',
    20 => '保存',
    21 => '取消',
    22 => '刪除',
    23 => '開始日期無效。',
    24 => '結束日期無效。',
    25 => '結束日期早於開始日期。',
    26 => '刪除舊條目',
    27 => '以下活動早於 ',
    28 => ' 個月。請點擊底部的垃圾桶圖標刪除這些活動，或選擇其他時間範圍：<br' . XHTML . '>查找早於以下時間的所有條目：',
    29 => ' 個月。',
    30 => '更新列表',
    31 => '確定要永久刪除所有選中的項目嗎？',
    32 => '列出全部',
    33 => '未選擇要刪除的活動',
    34 => '活動 ID',
    35 => '無法刪除',
    36 => '已成功刪除',
    'num_events' => '%s 個活動'
);

$LANG_CAL_MESSAGE = array(
    'save'      => '您的活動已成功保存。',
    'delete'    => '活動已成功刪除。',
    'private'   => '活動已保存到您的行事曆',
    'login'     => '登錄後才能打開個人行事曆',
    'removed'   => '活動已成功從您的個人行事曆移除',
    'noprivate' => '抱歉，此網站未啟用個人行事曆',
    'unauth'    => '抱歉，您無權訪問活動管理頁面。所有未經授權的訪問嘗試都會被記錄',
);

$PLG_calendar_MESSAGE4  = "感謝您向 {$_CONF['site_name']} 提交活動。活動已提交給工作人員審核。審核通過後，您的活動將顯示在<a href=\"{$_CONF['site_url']}/calendar/index.php\">行事曆</a>中。";
$PLG_calendar_MESSAGE17 = '您的活動已成功保存。';
$PLG_calendar_MESSAGE18 = '活動已成功刪除。';
$PLG_calendar_MESSAGE24 = 'The event has been saved to your calendar.';
$PLG_calendar_MESSAGE26 = '活動已成功刪除。';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = '不支持插件升級。';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => '行事曆',
    'title' => '行事曆配置'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => '訪問行事曆需要登錄？',
    'hidecalendarmenu' => '隱藏行事曆菜單項？',
    'personalcalendars' => '啟用個人行事曆？',
    'eventsubmission' => '啟用提交隊列？',
    'showupcomingevents' => '顯示即將举行的活動？',
    'upcomingeventsrange' => '即將举行活動的時間範圍',
    'event_types' => '活動類型',
    'hour_mode' => '時間格式',
    'notification' => '發送通知郵件？',
    'delete_event' => '刪除所有者時同時刪除活動？',
    'aftersave' => '保存活動後',
    'recaptcha' => 'reCAPTCHA',
    'recaptcha_score' => 'reCAPTCHA 分數',
    'default_permissions' => '活動預設權限',
    'autotag_permissions_event' => '[event: ] 權限',
    'block_enable' => '啟用',
    'block_isleft' => '在左側顯示區塊',
    'block_order' => '區塊順序',
    'block_topic_option' => '主題選項',
    'block_topic' => '主題',
    'block_group_id' => '組',
    'block_permissions' => '權限'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => '主要設置'
);

$LANG_tab['calendar'] = array(
    'tab_main' => '行事曆常規設置',
    'tab_permissions' => '預設權限',
    'tab_autotag_permissions' => '自動標簽使用權限',
    'tab_events_block' => '活動區塊'
);

$LANG_fs['calendar'] = array(
    'fs_main' => '行事曆常規設置',
    'fs_permissions' => '預設權限',
    'fs_autotag_permissions' => '自動標簽使用權限',
    'fs_block_settings' => '區塊設置',
    'fs_block_permissions' => '區塊權限'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('是' => 1, '否' => 0),
    1 => array('是' => TRUE, '否' => FALSE),
    6 => array('12' => '12', '24' => '24'),
    9 => array('轉到活動' => 'item', '顯示管理列表' => 'list', '顯示行事曆' => 'plugin', '顯示首頁' => 'home', '顯示管理頁' => 'admin'),
    12 => array('無訪問權限' => 0, '只讀' => 2, '讀寫' => 3),
    13 => array('無訪問權限' => 0, '使用' => 2),
    14 => array('無訪問權限' => 0, '只讀' => 2),
    15 => array('全部' => TOPIC_ALL_OPTION, '僅首頁' => TOPIC_HOMEONLY_OPTION, '選擇主題' => TOPIC_SELECTED_OPTION),
    16 => array('禁用' => RECAPTCHA_NO_SUPPORT, 'reCAPTCHA V2' => RECAPTCHA_SUPPORT_V2, 'reCAPTCHA V2 Invisible' => RECAPTCHA_SUPPORT_V2_INVISIBLE, 'reCAPTCHA V3' => RECAPTCHA_SUPPORT_V3)
);
