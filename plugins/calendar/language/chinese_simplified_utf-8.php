<?php

###############################################################################
# chinese_simplified_utf-8.php
#
# This is the Simplified Chinese language file for the Geeklog Calendar plugin
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
    1 => '活动日历',
    2 => '抱歉，没有可显示的活动。',
    3 => '时间',
    4 => '地点',
    5 => '描述',
    6 => '添加活动',
    7 => '即将举行的活动',
    8 => '将此活动添加到您的日历后，可在用户功能区点击“我的日历”，快速查看您感兴趣的活动。',
    9 => '添加到我的日历',
    10 => '从我的日历移除',
    11 => "正在将活动添加到 %s 的日历",
    12 => '活动',
    13 => '开始',
    14 => '结束',
    15 => '返回日历',
    16 => '日历',
    17 => '开始日期',
    18 => '结束日期',
    19 => '日历活动提交',
    20 => '标题',
    21 => '开始日期',
    22 => 'URL',
    23 => '您的活动',
    24 => '网站活动',
    25 => '没有即将举行的活动',
    26 => '提交活动',
    27 => "向 {$_CONF['site_name']} 提交活动后，该活动会进入主日历，用户可以选择将其添加到个人日历。此功能<b>不用于</b>保存生日、纪念日等个人活动。<br" . XHTML . "><br" . XHTML . ">活动提交后会发送给管理员审核，审核通过后将显示在主日历中。",
    28 => '标题',
    29 => '结束时间',
    30 => '开始时间',
    31 => '全天活动',
    32 => '地址第1行',
    33 => '地址第2行',
    34 => '城市/城镇',
    35 => '省/州',
    36 => '邮政编码',
    37 => '活动类型',
    38 => '编辑活动类型',
    39 => '地点',
    40 => '将活动添加到',
    41 => '主日历',
    42 => '个人日历',
    43 => '链接',
    44 => '不允许使用 HTML 标签',
    45 => '提交',
    46 => '系统中的活动',
    47 => '十大活动',
    48 => '点击次数',
    49 => '此网站似乎没有活动，或者尚无人点击任何活动。',
    50 => '活动',
    51 => '删除',
    'autotag_desc_event' => '[event: id 可选标题] - 显示指向日历活动的链接，并使用活动标题作为链接标题。可以指定替代标题，但不是必需的。'
);

$_LANG_CAL_SEARCH = array(
    'results' => '日历结果',
    'title' => '标题',
    'date_time' => '日期和时间',
    'location' => '地点',
    'description' => '描述'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '添加个人活动',
    9 => '%s 活动',
    10 => '活动：',
    11 => '主日历',
    12 => '我的日历',
    25 => '返回 ',
    26 => '全天',
    27 => '周',
    28 => '个人日历：',
    29 => '公共日历',
    30 => '删除活动',
    31 => '添加',
    32 => '活动',
    33 => '日期',
    34 => '时间',
    35 => '快速添加',
    36 => '提交',
    37 => '抱歉，此网站未启用个人日历功能',
    38 => '个人活动编辑器',
    39 => '日',
    40 => '周',
    41 => '月',
    42 => '添加主日历活动',
    43 => '活动提交',
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => '活动编辑器',
    2 => '错误',
    3 => '发布模式',
    4 => '活动 URL',
    5 => '活动开始日期',
    6 => '活动结束日期',
    7 => '活动地点',
    8 => '活动描述',
    9 => '（包括 http://）',
    10 => '必须提供日期/时间、活动标题和描述',
    11 => '日历管理',
    12 => '要修改或删除活动，请点击下方该活动的编辑图标。要创建新活动，请点击上方的“新建”。点击复制图标可复制现有活动。',
    13 => '作者',
    14 => '开始日期',
    15 => '结束日期',
    16 => '',
    17 => "您正在尝试访问无权查看的活动，此次尝试已被记录。请<a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">返回活动管理页面</a>。",
    18 => '',
    19 => '',
    20 => '保存',
    21 => '取消',
    22 => '删除',
    23 => '开始日期无效。',
    24 => '结束日期无效。',
    25 => '结束日期早于开始日期。',
    26 => '删除旧条目',
    27 => '以下活动早于 ',
    28 => ' 个月。请点击底部的垃圾桶图标删除这些活动，或选择其他时间范围：<br' . XHTML . '>查找早于以下时间的所有条目：',
    29 => ' 个月。',
    30 => '更新列表',
    31 => '确定要永久删除所有选中的项目吗？',
    32 => '列出全部',
    33 => '未选择要删除的活动',
    34 => '活动 ID',
    35 => '无法删除',
    36 => '已成功删除',
    'num_events' => '%s 个活动'
);

$LANG_CAL_MESSAGE = array(
    'save'      => '您的活动已成功保存。',
    'delete'    => '活动已成功删除。',
    'private'   => '活动已保存到您的日历',
    'login'     => '登录后才能打开个人日历',
    'removed'   => '活动已成功从您的个人日历移除',
    'noprivate' => '抱歉，此网站未启用个人日历',
    'unauth'    => '抱歉，您无权访问活动管理页面。所有未经授权的访问尝试都会被记录',
);

$PLG_calendar_MESSAGE4  = "感谢您向 {$_CONF['site_name']} 提交活动。活动已提交给工作人员审核。审核通过后，您的活动将显示在<a href=\"{$_CONF['site_url']}/calendar/index.php\">日历</a>中。";
$PLG_calendar_MESSAGE17 = '您的活动已成功保存。';
$PLG_calendar_MESSAGE18 = '活动已成功删除。';
$PLG_calendar_MESSAGE24 = 'The event has been saved to your calendar.';
$PLG_calendar_MESSAGE26 = '活动已成功删除。';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = '不支持插件升级。';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => '日历',
    'title' => '日历配置'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => '访问日历需要登录？',
    'hidecalendarmenu' => '隐藏日历菜单项？',
    'personalcalendars' => '启用个人日历？',
    'eventsubmission' => '启用提交队列？',
    'showupcomingevents' => '显示即将举行的活动？',
    'upcomingeventsrange' => '即将举行活动的时间范围',
    'event_types' => '活动类型',
    'hour_mode' => '时间格式',
    'notification' => '发送通知邮件？',
    'delete_event' => '删除所有者时同时删除活动？',
    'aftersave' => '保存活动后',
    'recaptcha' => 'reCAPTCHA',
    'recaptcha_score' => 'reCAPTCHA 分数',
    'default_permissions' => '活动默认权限',
    'autotag_permissions_event' => '[event: ] 权限',
    'block_enable' => '启用',
    'block_isleft' => '在左侧显示区块',
    'block_order' => '区块顺序',
    'block_topic_option' => '主题选项',
    'block_topic' => '主题',
    'block_group_id' => '组',
    'block_permissions' => '权限'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => '主要设置'
);

$LANG_tab['calendar'] = array(
    'tab_main' => '日历常规设置',
    'tab_permissions' => '默认权限',
    'tab_autotag_permissions' => '自动标签使用权限',
    'tab_events_block' => '活动区块'
);

$LANG_fs['calendar'] = array(
    'fs_main' => '日历常规设置',
    'fs_permissions' => '默认权限',
    'fs_autotag_permissions' => '自动标签使用权限',
    'fs_block_settings' => '区块设置',
    'fs_block_permissions' => '区块权限'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('是' => 1, '否' => 0),
    1 => array('是' => TRUE, '否' => FALSE),
    6 => array('12' => '12', '24' => '24'),
    9 => array('转到活动' => 'item', '显示管理列表' => 'list', '显示日历' => 'plugin', '显示首页' => 'home', '显示管理页' => 'admin'),
    12 => array('无访问权限' => 0, '只读' => 2, '读写' => 3),
    13 => array('无访问权限' => 0, '使用' => 2),
    14 => array('无访问权限' => 0, '只读' => 2),
    15 => array('全部' => TOPIC_ALL_OPTION, '仅首页' => TOPIC_HOMEONLY_OPTION, '选择主题' => TOPIC_SELECTED_OPTION),
    16 => array('禁用' => RECAPTCHA_NO_SUPPORT, 'reCAPTCHA V2' => RECAPTCHA_SUPPORT_V2, 'reCAPTCHA V2 Invisible' => RECAPTCHA_SUPPORT_V2_INVISIBLE, 'reCAPTCHA V3' => RECAPTCHA_SUPPORT_V3)
);
