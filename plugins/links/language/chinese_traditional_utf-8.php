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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_LINKS = array(
    10 => '提交物',
    14 => '連結',
    84 => '連結',
    88 => '沒有新的連結',
    114 => '網際資源',
    116 => '加一聯結',
    117 => 'Report Broken Link',
    118 => 'Broken Link Report',
    119 => 'The following link has been reported to be broken: ',
    120 => 'To edit the link, click here: ',
    121 => 'The broken Link was reported by: ',
    122 => 'Thank you for reporting this broken link. The administrator will correct the problem as soon as possible',
    123 => 'Thank you',
    124 => 'Go',
    125 => 'Categories',
    126 => 'You are here:',
    'root' => 'Root'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => '系統裏的聯結(點擊)',
    'stats_headline' => '頭十個聯結',
    'stats_page_title' => '聯結',
    'stats_hits' => '採樣數',
    'stats_no_hits' => '看來本站沒有連結或是沒人點擊過本站的連結。'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => '聯結結果',
    'title' => '標題',
    'date' => '加入日其',
    'author' => '提交者',
    'hits' => '點擊'
);

###############################################################################
# for the submission form

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
$PLG_links_MESSAGE5 = 'You do not have sufficient access rights to view this category.';
$PLG_links_MESSAGE6 = 'You do not have sufficient rights to edit this category.';
$PLG_links_MESSAGE7 = 'Please enter a Category Name and Description.';
$PLG_links_MESSAGE10 = 'Your category has been successfully saved.';
$PLG_links_MESSAGE11 = 'You are not allowed to set the id of a category to "site" or "user" - these are reserved for internal use.';
$PLG_links_MESSAGE12 = 'You are trying to make a parent category the child of it\'s own subcategory. This would create an orphan category, so please first move the child category or categories up to a higher level.';
$PLG_links_MESSAGE13 = 'The category has been successfully deleted.';
$PLG_links_MESSAGE14 = 'Category contains links and/or categories. Please remove these first.';
$PLG_links_MESSAGE15 = 'You do not have sufficient rights to delete this category.';
$PLG_links_MESSAGE16 = 'No such category exists.';
$PLG_links_MESSAGE17 = 'This category id is already in use.';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

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
    24 => 'Link not found',
    25 => 'The link you selected for editing could not be found.',
    26 => 'Validate Links',
    27 => 'HTTP Status',
    28 => 'Edit category',
    29 => 'Enter or edit the details below.',
    30 => 'Category',
    31 => 'Description',
    32 => 'Category ID',
    33 => 'Topic',
    34 => 'Parent',
    35 => 'All',
    40 => 'Edit this category',
    41 => 'Create child category',
    42 => 'Delete this category',
    43 => 'Site categories',
    44 => 'Add&nbsp;child',
    46 => 'User %s tried to delete a category to which they do not have access rights',
    50 => 'List categories',
    51 => 'New link',
    52 => 'New category',
    53 => 'List links',
    54 => 'Category Manager',
    55 => 'Edit categories below. Note that you cannot delete a category that contains other categories or links - you should delete these first, or move them to another category.',
    56 => 'Category Editor',
    57 => 'Not validated yet',
    58 => 'Validate now',
    59 => '<p>To validate all links displayed, please click on the "Validate now" link below. Please note that this might take some time depending on the amount of links displayed.</p>',
    60 => 'User %s tried illegally to edit category %s.',
    61 => 'Links in Category'
);


$LANG_LINKS_STATUS = array(
    100 => 'Continue',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    999 => 'Connection Timed out'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => 'Links',
    'title' => 'Links Configuration'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => 'Links Login Required?',
    'linksubmission' => 'Enable Submission Queue?',
    'newlinksinterval' => 'New Links Interval',
    'hidenewlinks' => 'Hide New Links?',
    'hidelinksmenu' => 'Hide Links Menu Entry?',
    'linkcols' => 'Categories per Column',
    'linksperpage' => 'Links per Page',
    'show_top10' => 'Show Top 10 Links?',
    'notification' => 'Notification Email?',
    'delete_links' => 'Delete Links with Owner?',
    'aftersave' => 'After Saving Link',
    'show_category_descriptions' => 'Show Category Description?',
    'new_window' => 'Open external links in new window?',
    'root' => 'ID of Root Category',
    'default_permissions' => 'Link Default Permissions',
    'category_permissions' => 'Category Default Permissions'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['links'] = array(
    'fs_public' => 'Public Links List Settings',
    'fs_admin' => 'Links Admin Settings',
    'fs_permissions' => 'Default Permissions',
    'fs_cpermissions' => 'Category Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    9 => array('Forward to Linked Site' => 'item', 'Display Admin List' => 'list', 'Display Public List' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
