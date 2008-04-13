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
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => '民意調查',
    'results'           => '結果',
    'pollresults'       => '調查結果',
    'votes'             => '票',
    'vote'              => '票',
    'pastpolls'         => '過去的調查',
    'savedvotetitle'    => '投票已存續',
    'savedvotemsg'      => '你投的票已經收存了',
    'pollstitle'        => '個民意調查在這系統裏',
    'pollquestions'     => '看其他調查問題',
    'stats_top10'       => '最高十個民意調查',
    'stats_questions'   => '調查題目',
    'stats_votes'       => '投票數',
    'stats_none'        => '看來此站沒有民意調查，或沒有人曾投過票.',
    'stats_summary'     => '這系統裏的調查(答案)',
    'open_poll'         => '開放投票'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '方式',
    2 => '請輸入一個題目和最少一個答案.',
    3 => '調查已建立',
    4 => "調查 %s 已存了",
    5 => '修改調查',
    6 => '調查 ID',
    7 => '(不可用空鍵)',
    8 => '顯示在主頁',
    9 => '問題',
    10 => '答案 / 投票',
    11 => "索取調查 %s 答案資料是出了錯誤",
    12 => "索取調查 %s 問題資料是出了錯誤",
    13 => '建立一個民意調查',
    14 => '存',
    15 => '取消',
    16 => '刪除',
    17 => '請輸入一個民意調查 ID',
    18 => '民意調查目錄',
    19 => '若要修改或刪除一個民意調查, 點擊它旁邊的修改圖.  若要建立一個新的民意調查, 點擊以上的 "建新".',
    20 => '投票者',
    21 => '拒絕進入',
    22 => "你在進入一個你沒權進入得投票調查。此企圖以備記錄。 請回到 <a href=\"{$_CONF['site_admin_url']}/poll.php\">民意調查管理處</a>.",
    23 => '新民意調查',
    24 => '管理處',
    25 => '是',
    26 => '否',
    27 => '修改',
    28 => '提交',
    29 => '搜尋',
    30 => '限制結果',
);

$PLG_polls_MESSAGE19 = '你的民意調查已順利的存續了.';
$PLG_polls_MESSAGE20 = 'Your poll has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
