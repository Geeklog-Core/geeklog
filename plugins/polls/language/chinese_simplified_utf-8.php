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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => '民意调查',
    'results'           => '结果',
    'pollresults'       => '调查结果',
    'votes'             => '票',
    'vote'              => '票',
    'pastpolls'         => '过去的调查',
    'savedvotetitle'    => '投票已存续',
    'savedvotemsg'      => '你投的票已经收存了',
    'pollstitle'        => '个民意调查在这系统里',
    'pollquestions'     => '看其他调查问题',
    'stats_top10'       => '最高十个民意调查',
    'stats_questions'   => '调查题目',
    'stats_votes'       => '投票数',
    'stats_none'        => '看来此站没有民意调查，或没有人曾投过票.',
    'stats_summary'     => '这系统里的调查(答案)',
    'open_poll'         => '开放投票'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '方式',
    2 => '请输入一个题目和最少一个答案.',
    3 => '调查已建立',
    4 => "调查 %s 已存了",
    5 => '修改调查',
    6 => '调查 ID',
    7 => '(不可用空键)',
    8 => '显示在主页',
    9 => '问题',
    10 => '答案 / 投票',
    11 => "索取调查 %s 答案资料是出了错误",
    12 => "索取调查 %s 问题资料是出了错误",
    13 => '建立一个民意调查',
    14 => '存',
    15 => '取消',
    16 => '删除',
    17 => '请输入一个民意调查 ID',
    18 => '民意调查目录',
    19 => '若要修改或删除一个民意调查, 点击它旁边的修改图.  若要建立一个新的民意调查, 点击以上的 "建新".',
    20 => '投票者',
    21 => '拒绝进入',
    22 => "你在进入一个你没权进入得投票调查。此企图以备记录。 请回到 <a href=\"{$_CONF['site_admin_url']}/poll.php\">民意调查管理处</a>.",
    23 => '新民意调查',
    24 => '管理处',
    25 => '是',
    26 => '否',
    27 => '修改',
    28 => '提交',
    29 => '搜寻',
    30 => '限制结果',
);

$PLG_polls_MESSAGE19 = '你的民意调查已顺利的存续了.';
$PLG_polls_MESSAGE20 = 'Your poll has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
