<?php

###############################################################################
# chinese_traditional_utf-8.php
# This is the Chinese Traditional Unicode (utf-8) language set
# for the Geeklog Static Page Plug-in!
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

$LANG_STATIC = array(
    'newpage' => '新頁',
    'adminhome' => '管理處',
    'staticpages' => '靜態頁',
    'staticpageeditor' => '靜態頁編輯器',
    'writtenby' => '作者',
    'date' => '更新日期',
    'title' => '標題',
    'page_title' => 'Page Title',
    'content' => '內容',
    'hits' => '採樣數',
    'staticpagelist' => '靜態頁目錄',
    'url' => '網址',
    'edit' => '編輯',
    'lastupdated' => '更新日期',
    'pageformat' => '網頁各式',
    'leftrightblocks' => '左右組件',
    'blankpage' => '空頁',
    'noblocks' => '無組件',
    'leftblocks' => '左組件',
    'addtomenu' => '加入菜單',
    'label' => '標簽',
    'nopages' => '此系統無靜態頁',
    'save' => '存續',
    'preview' => '預覽',
    'delete' => '刪除',
    'cancel' => '取消',
    'access_denied' => '拒絕入門',
    'access_denied_msg' => '你在非法進入靜態頁管理處. 請注意，你企圖非法的進入此頁的資料會被記錄下來',
    'all_html_allowed' => '所有 HTML 代號讀可用',
    'results' => '靜態頁結果',
    'author' => '作者',
    'no_title_or_content' => '你最少要填入<b>標題</b> 和 <b>內容</b>.',
    'no_such_page_anon' => '請登入..',
    'no_page_access_msg' => "這也許是你未登入, 或不是此站的用戶. 請 <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> 申請成為用戶 </a> 來得到登入權",
    'php_msg' => 'PHP: ',
    'php_warn' => '注意: 你的靜態頁上的 PHP 代號將會被評價. 請小心 !!',
    'exit_msg' => 'Exit 類型: ',
    'exit_info' => '啟動 需要登入 的通知.  不勾此框便即用正常安全檢查.',
    'deny_msg' => '拒絕進入此頁.  也許此頁也被搬移，刪除，或你無足夠許可進入此頁.',
    'stats_headline' => '頭十個靜態頁',
    'stats_page_title' => '網頁標題',
    'stats_hits' => '採樣數',
    'stats_no_hits' => '看來此站沒有靜態頁或無人曾看過任何靜態頁.',
    'id' => 'ID',
    'duplicate_id' => '你選的 ID 已經被用，請選另一個.',
    'instructions' => '若要更改或刪除一個靜態頁，在它旁邊的編輯圖上點擊。若要看一個靜態頁，在它的標題上點擊。若要建立一個新的靜態頁，在以上的‘建新’上點距。若要複製一個靜態頁，再它旁邊的複製圖上點擊。',
    'centerblock' => '中組件: ',
    'centerblock_msg' => '若勾此匡，此靜態頁便會顯為‘中組件’，就是變成網頁中間的框框。',
    'topic' => '主題: ',
    'position' => '位置: ',
    'all_topics' => '所有',
    'no_topic' => '只顯在主頁',
    'position_top' => '頂部',
    'position_feat' => '在重要文章下面',
    'position_bottom' => '底部',
    'position_entire' => '整頁',
    'head_centerblock' => '中組件',
    'centerblock_no' => '不',
    'centerblock_top' => '頂',
    'centerblock_feat' => '重要文章',
    'centerblock_bottom' => '底',
    'centerblock_entire' => '整頁',
    'inblock_msg' => '在一個組件內: ',
    'inblock_info' => '將靜態頁包在組件框裏.',
    'title_edit' => '編輯此頁',
    'title_copy' => '複製此頁',
    'title_display' => '顯示此頁',
    'select_php_none' => '不要執行PHP',
    'select_php_return' => '執行 PHP (return)',
    'select_php_free' => '執行 PHP',
    'php_not_activated' => '使用 PHP 的功能為開啟.',
    'printable_format' => '打印格式',
    'copy' => '複製',
    'limit_results' => '限制結果',
    'search' => '搜尋',
    'submit' => '提交',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages',
    'comments' => 'Comments',
    'template' => 'Template',
    'use_template' => 'Use Template',
    'template_msg' => 'When checked, this Static Page will be marked as a template.',
    'none' => 'None',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Static Pages',
    'title' => 'Static Pages Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Allow PHP?',
    'sort_by' => 'Sort Centerblocks by',
    'sort_menu_by' => 'Sort Menu Entries by',
    'sort_list_by' => 'Sort Admin List by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'draft_flag' => 'Draft Flag Default',
    'disable_breadcrumbs_staticpages' => 'Disable Breadcrumbs',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Static Pages Main Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_search' => 'Search Results',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    4 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Author' => 'author'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1)
);

?>
