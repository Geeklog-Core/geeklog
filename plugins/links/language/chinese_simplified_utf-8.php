<?php

###############################################################################
# chinese_simplified_utf-8.php
#
# This is the Chinese Simplified (UTF-8) language set for GeekLog Links plugin
# 
# Last updated January 10, 2006
#
# Copyright (C) 2005 Samuel M. Stone
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
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
###############################################################################
/**
* the link plugin's lang array
* 
* @global array $LANG_LINKS 
*/
$LANG_LINKS= array(
    10 => '提交物',
    14 => '连结',
    84 => '连结',
    88 => '没有新的连结',
    114 => '网际资源',
    116 => '加一联结'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => '系统里的联结(点击)',
    'stats_headline' => '头十个联结',
    'stats_page_title' => '联结',
    'stats_hits' => '采样数',
    'stats_no_hits' => '看来本站没有连结或是没人点击过本站的连结。',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => '联结结果',
 'title' => '标题',
 'date' => '加入日其',
 'author' => '提交者',
 'hits' => '点击'
);

###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => '提交一个联结',
    2 => '联结',
    3 => '类别',
    4 => '其他',
    5 => '若其他, 情指定',
    6 => '错误: 无类别',
    7 => '若选 "其他" 请提供类别名称',
    8 => '标题',
    9 => '网址',
    10 => '类别',
    11 => '提交联结'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "谢谢你给本站提交一个联结. 此联结已提交到管理员处等待批准. 若批准，你的联结将显示在<a href={$_CONF['site_url']}/links/index.php>联结</a>处.";
$PLG_links_MESSAGE2 = '你的连接已存续成功.';
$PLG_links_MESSAGE3 = '联结已成功的删除.';
$PLG_links_MESSAGE4 = "谢谢你为本站提交一个联结.  你的连接现在已显现在<a href={$_CONF['site_url']}/links/index.php>联结</a>处.";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php
/**
* the link plugin's lang admin array
* 
* @global array $LANG_LINKS_ADMIN 
*/
$LANG_LINKS_ADMIN = array(
    1 => '联结编辑器',
    2 => '联结ID',
    3 => '联结标题',
    4 => '联结网址',
    5 => '类别',
    6 => '(请包括 http://)',
    7 => '其他',
    8 => '联结采样数',
    9 => '联结描述',
    10 => '你需要提供联结得标题, 网址及描述.',
    11 => '联结管理器',
    12 => '若要更改或删除一个联结，请点击一下那联结的编辑标图.  若要建立一个新的联结请点击以上的 "建新".',
    14 => '联结类别',
    16 => '拒绝进入',
    17 => "你再使用一个你没有权的联结.  此企图已被记录. 请<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">回到连接管理处</a>.",
    20 => '若是其他, 请注明',
    21 => '存续',
    22 => '取消',
    23 => '删除',
);

?>
