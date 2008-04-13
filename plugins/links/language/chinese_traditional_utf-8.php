<?php

###############################################################################
# chinese_traditional_utf-8.php
#
# This is the Chinese Traditional (UTF-8) language set for GeekLog Links plugin
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

global $LANG32;

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
$LANG_LINKS = array(
    10 => '提交物',
    14 => '連結',
    84 => '連結',
    88 => '沒有新的連結',
    114 => '網際資源',
    116 => '加一聯結'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => '系統裏的聯結(點擊)',
    'stats_headline' => '頭十個聯結',
    'stats_page_title' => '聯結',
    'stats_hits' => '採樣數',
    'stats_no_hits' => '看來本站沒有連結或是沒人點擊過本站的連結。',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => '聯結結果',
 'title' => '標題',
 'date' => '加入日其',
 'author' => '提交者',
 'hits' => '點擊'
);

###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => '提交一個聯結',
    2 => '聯結',
    3 => '類別',
    4 => '其他',
    5 => '若其他, 情指定',
    6 => '錯誤: 無類別',
    7 => '若選 "其他" 請提供類別名稱',
    8 => '標題',
    9 => '網址',
    10 => '類別',
    11 => '提交聯結'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "謝謝你給本站提交一個聯結. 此聯結已提交到管理員處等待批准. 若批准，你的聯結將顯示在<a href={$_CONF['site_url']}/links/index.php>聯結</a>處.";
$PLG_links_MESSAGE2 = '你的連接已存續成功.';
$PLG_links_MESSAGE3 = '聯結已成功的刪除.';
$PLG_links_MESSAGE4 = "謝謝你為本站提交一個聯結.  你的連接現在已顯現在<a href={$_CONF['site_url']}/links/index.php>聯結</a>處.";

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
    1 => '聯結編輯器',
    2 => '聯結ID',
    3 => '聯結標題',
    4 => '聯結網址',
    5 => '類別',
    6 => '(請包括 http://)',
    7 => '其他',
    8 => '聯結採樣數',
    9 => '聯結描述',
    10 => '你需要提供聯結得標題, 網址及描述.',
    11 => '聯結管理器',
    12 => '若要更改或刪除一個聯結，請點擊一下那聯結的編輯標圖.  若要建立一個新的聯結請點擊以上的 "建新".',
    14 => '聯結類別',
    16 => '拒絕進入',
    17 => "你再使用一個你沒有權的聯結.  此企圖已被記錄. 請<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">回到連接管理處</a>.",
    20 => '若是其他, 請注明',
    21 => '存續',
    22 => '取消',
    23 => '刪除',
);

?>
