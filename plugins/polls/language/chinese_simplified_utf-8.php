<?php

###############################################################################
# chinese_simplified_utf-8.php
# This is the Chinese Simplified UTF-8 language page for 
# the Geeklog Polls Plug-in!
#
# Last updated on January 10, 2006
#
# Copyright (C) 2005 Samuel Maung Stone
# sam@stonemicro.com
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

$LANG_POLLS = array(
    'polls' => '民意调查',
    'poll' => '投票',
    'results' => '结果',
    'pollresults' => '调查结果',
    'votes' => '票',
    'voters' => '投票者',
    'vote' => '票',
    'pastpolls' => '过去的调查',
    'savedvotetitle' => '投票已存续',
    'savedvotemsg' => '你投的票已经收存了',
    'pollstitle' => '个民意调查在这系统里',
    'polltopics' => '其他投票',
    'stats_top10' => '最高十个民意调查',
    'stats_topics' => '投票主题',
    'stats_votes' => '投票数',
    'stats_none' => '看来此站没有民意调查，或没有人曾投过票.',
    'stats_summary' => '这系统里的调查(答案)',
    'open_poll' => '开放投票',
    'answer_all' => '请回答所有剩余问题',
    'not_saved' => '结果未保存',
    'upgrade1' => '您安装了新版 Polls 插件。请',
    'upgrade2' => '升级',
    'editinstructions' => '请填写投票 ID、至少一个问题以及两个答案。',
    'pollclosed' => '此投票已关闭。',
    'pollhidden' => '您已经投票。结果将在投票结束后显示。',
    'start_poll' => '开始投票',
    'no_new_polls' => '没有新投票',
    'autotag_desc_poll' => '[poll: id 可选标题] - 显示指向投票的链接，并使用投票主题作为标题。可选标题不是必需的。',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] - 显示用于投票的投票。class 和 showall 可选；class 指定 CSS 类，showall:1 显示所有问题。',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] - 显示投票结果。class 可选，用于指定 CSS 类。',
    'deny_msg' => '无权访问此投票。投票可能已被移动或删除，或者您没有足够的权限。'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '模式',
    2 => '请输入主题、至少一个问题以及一个答案。',
    3 => '投票已创建',
    4 => '投票 %s 已保存',
    5 => '编辑投票',
    6 => '投票 ID',
    7 => '（不要使用空格）',
    8 => '显示在投票区块中',
    9 => '主题',
    10 => '答案 / 票数 / 备注',
    11 => '获取投票 %s 的答案数据时发生错误',
    12 => '获取投票 %s 的问题数据时发生错误',
    13 => '创建投票',
    14 => '保存',
    15 => '取消',
    16 => '删除',
    17 => '请输入投票 ID',
    18 => '投票列表',
    19 => '要修改或删除投票，请点击其编辑图标。要创建新投票，请点击上方的“新建”。',
    20 => '投票者',
    21 => '访问被拒绝',
    22 => "您正在尝试访问无权访问的投票。此操作已记录。请 <a href=\"{$_CONF['site_admin_url']}/poll.php\">返回投票管理页面</a>。",
    23 => '新投票',
    24 => '管理首页',
    25 => '是',
    26 => '否',
    27 => '编辑',
    28 => '提交',
    29 => '搜索',
    30 => '限制结果',
    31 => '问题',
    32 => '要从投票中删除此问题，请删除问题文本',
    33 => '开放投票',
    34 => '投票主题：',
    35 => '此投票有',
    36 => '个其他问题。',
    37 => '投票开放时隐藏结果',
    38 => '投票开放时，仅所有者和 root 可以查看结果',
    39 => '仅当问题超过一个时才显示主题。',
    40 => '查看此投票的所有答案',
    1001 => '允许多个答案',
    1002 => '描述',
    1003 => '描述'
);

$PLG_polls_MESSAGE15 = '您的评论已提交审核，并将在版主批准后发布。';
$PLG_polls_MESSAGE19 = '你的民意调查已顺利的存续了.';
$PLG_polls_MESSAGE20 = '您的投票已成功删除。';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = '不支持插件升级。';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'Polls',
    'title' => 'Polls Configuration'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'Polls Login Required?',
    'hidepollsmenu' => 'Hide Polls Menu Entry?',
    'maxquestions' => 'Max. Questions per Poll',
    'maxanswers' => 'Max. Options per Question',
    'answerorder' => 'Sort Results ...',
    'pollcookietime' => 'Voter Cookie valid for',
    'polladdresstime' => 'Voter IP Address valid for',
    'delete_polls' => 'Delete Polls with Owner?',
    'aftersave' => 'After Saving Poll',
    'default_permissions' => 'Poll Default Permissions',
    'autotag_permissions_poll' => '[poll: ] Permissions',
    'autotag_permissions_poll_vote' => '[poll_vote: ] Permissions',
    'autotag_permissions_poll_result' => '[poll_result: ] Permissions',
    'newpollsinterval' => 'New Polls Interval',
    'hidenewpolls' => 'New Polls',
    'title_trim_length' => 'Title Trim Length',
    'meta_tags' => 'Enable Meta Tags',
    'likes_polls' => 'Poll Likes',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => '主题',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['polls'] = array(
    'tab_main' => 'General Polls Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_poll_block' => 'Poll Block'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'General Polls Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('As Submitted' => 'submitorder', 'By Votes' => 'voteorder'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to Poll' => 'item', 'Display Admin List' => 'list', 'Display Public List' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'all', 'Homepage Only' => 'homeonly', 'Select Topics' => 'selectedtopics'),
    41 => array('False' => 0, 'Likes and Dislikes' => 1, 'Likes Only' => 2)
);
