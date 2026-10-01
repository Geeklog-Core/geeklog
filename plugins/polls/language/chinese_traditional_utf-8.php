<?php

###############################################################################
# chinese_traditional_utf-8.php
# This is the Chinese Traditional UTF-8 language page for 
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
    'polls' => '民意調查',
    'poll' => '投票',
    'results' => '結果',
    'pollresults' => '調查結果',
    'votes' => '票',
    'voters' => '投票者',
    'vote' => '票',
    'pastpolls' => '過去的調查',
    'savedvotetitle' => '投票已存續',
    'savedvotemsg' => '你投的票已經收存了',
    'pollstitle' => '個民意調查在這系統裏',
    'polltopics' => '其他投票',
    'stats_top10' => '最高十個民意調查',
    'stats_topics' => '投票主題',
    'stats_votes' => '投票數',
    'stats_none' => '看來此站沒有民意調查，或沒有人曾投過票.',
    'stats_summary' => '這系統裏的調查(答案)',
    'open_poll' => '開放投票',
    'answer_all' => '請回答所有剩餘問題',
    'not_saved' => '結果未儲存',
    'upgrade1' => '您安裝了新版 Polls 外掛。請',
    'upgrade2' => '升級',
    'editinstructions' => '請填寫投票 ID、至少一個問題以及兩個答案。',
    'pollclosed' => '此投票已關閉。',
    'pollhidden' => '您已經投票。結果會在投票結束後顯示。',
    'start_poll' => '開始投票',
    'no_new_polls' => '沒有新投票',
    'autotag_desc_poll' => '[poll: id 可選標題] - 顯示指向投票的連結，並使用投票主題作為標題。可選標題不是必需的。',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] - 顯示用於投票的投票。class 與 showall 可選；class 指定 CSS 類別，showall:1 顯示所有問題。',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] - 顯示投票結果。class 可選，用於指定 CSS 類別。',
    'deny_msg' => '無權存取此投票。投票可能已被移動或刪除，或您沒有足夠權限。'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '模式',
    2 => '請輸入主題、至少一個問題以及一個答案。',
    3 => '投票已建立',
    4 => '投票 %s 已儲存',
    5 => '編輯投票',
    6 => '投票 ID',
    7 => '（不要使用空格）',
    8 => '顯示於投票區塊',
    9 => '主題',
    10 => '答案 / 票數 / 備註',
    11 => '取得投票 %s 的答案資料時發生錯誤',
    12 => '取得投票 %s 的問題資料時發生錯誤',
    13 => '建立投票',
    14 => '儲存',
    15 => '取消',
    16 => '刪除',
    17 => '請輸入投票 ID',
    18 => '投票清單',
    19 => '要修改或刪除投票，請點選其編輯圖示。要建立新投票，請點選上方的「新增」。',
    20 => '投票者',
    21 => '存取被拒絕',
    22 => "您正在嘗試存取無權存取的投票。此操作已記錄。請 <a href=\"{$_CONF['site_admin_url']}/poll.php\">返回投票管理頁面</a>。",
    23 => '新投票',
    24 => '管理首頁',
    25 => '是',
    26 => '否',
    27 => '編輯',
    28 => '提交',
    29 => '搜尋',
    30 => '限制結果',
    31 => '問題',
    32 => '要從投票中刪除此問題，請刪除問題文字',
    33 => '開放投票',
    34 => '投票主題：',
    35 => '此投票有',
    36 => '個其他問題。',
    37 => '投票開放時隱藏結果',
    38 => '投票開放時，僅擁有者與 root 可查看結果',
    39 => 'The topic will be only displayed if there is more than 1 question.',
    40 => '查看此投票的所有答案',
    1001 => '允許多個答案',
    1002 => '描述',
    1003 => '描述'
);

$PLG_polls_MESSAGE15 = '您的留言已提交審核，並會在版主核准後發布。';
$PLG_polls_MESSAGE19 = '你的民意調查已順利的存續了.';
$PLG_polls_MESSAGE20 = '您的投票已成功刪除。';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = '不支援外掛升級。';
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
    'block_topic' => '主題',
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
