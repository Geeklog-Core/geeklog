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
    'page_title' => '頁面標題',
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
    'label' => '標籤',
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
    'title_error_saving' => '儲存頁面時發生錯誤',
    'template_xml_error' => 'XML 標記中存在<em>錯誤</em>。此頁面設定為使用另一個頁面作為範本，因此範本變數必須使用 XML 標記定義。詳細資訊請參閱 <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog Wiki</a>。必須先修正此錯誤才能儲存頁面。',
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
    'likes' => '讚',
    'submit' => '提交',
    'no_new_pages' => '沒有新頁面',
    'pages' => '頁面',
    'comments' => '評論',
    'template' => '範本',
    'use_template' => '使用範本',
    'template_msg' => '勾選後，此靜態頁面將標記為範本。',
    'none' => '無',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => '草稿',
    'draft_yes' => '是',
    'draft_no' => '否',
    'show_on_page' => '在頁面上顯示',
    'show_on_page_disabled' => '注意：目前已在靜態頁面設定中對所有頁面停用此選項。',
    'cache_time' => '快取時間',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled (3600 = 1 hour,  86400 = 1 day). Staticpages with PHP enabled or are a template will not be cached.',
    'autotag_desc_staticpage' => '[staticpage: id 替代標題] - 顯示指向靜態頁面的連結，並使用靜態頁面標題作為連結標題。可指定替代標題，但不是必要的。',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.',
    'autotag_desc_page' => '[page: id 替代標題] - 顯示指向靜態頁面外掛頁面的連結，並使用頁面標題作為連結標題。可指定替代標題，但不是必要的。',
    'autotag_desc_page_content' => '[page_content: id] - 顯示靜態頁面外掛中頁面的內容。',
    'yes' => '是',
    'used_by' => '此範本已指派給 %s 個頁面。如果其他範本透過自動標籤呼叫此範本，實際使用它的頁面可能更多。',
    'prev_page' => '上一頁',
    'next_page' => '下一頁',
    'parent_page' => '父頁面',
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel=”next” and rel=”prev” to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s 個頁面',
    'search_desc' => 'Control if page appears in search. Default depends on setting in Configuration and depends on page type (if it is a Center Block, Uses a Template, or Uses PHP).',
    'likes_desc' => '決定頁面是否顯示「喜歡」控制項以及顯示方式。預設值取決於外掛設定。以中央區塊顯示的頁面不會顯示此控制項。範本頁面不使用此設定。'
);

$LANG_staticpages_search = array(
    0  => '排除',
    1  => '使用預設值',
    2  => '包含'
);

$LANG_staticpages_likes = array(
    -1 => '使用預設值',
    0  => '停用',
    1  => '喜歡和不喜歡',
    2  => '僅喜歡',
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';
$PLG_staticpages_MESSAGE22 = 'You could not delete the page. It is a template staticpage and it is currently assigned to 1 or more staticpages.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Static Pages',
    'title' => 'Static Pages Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => '允許 PHP？',
    'enable_eval_php_save' => '儲存頁面時解析 PHP',
    'sort_by' => '中央區塊排序依據',
    'sort_menu_by' => '選單項目排序依據',
    'sort_list_by' => '管理清單排序依據',
    'delete_pages' => '刪除擁有者時同時刪除頁面？',
    'in_block' => '將頁面包在區塊中？',
    'show_hits' => '顯示瀏覽次數？',
    'show_date' => '顯示日期？',
    'filter_html' => '過濾 HTML？',
    'censor' => '審查內容？',
    'default_permissions' => '頁面預設權限',
    'autotag_permissions_staticpage' => '[staticpage: ] 權限',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] 權限',
    'aftersave' => '儲存頁面後',
    'atom_max_items' => 'Web 服務摘要中的最大頁面數',
    'meta_tags' => '啟用 Meta 標籤',
    'likes_pages' => '頁面喜歡',
    'comment_code' => '評論默認',
    'structured_data_type_default' => '預設結構化資料類型',
    'draft_flag' => '草稿標記預設',
    'disable_breadcrumbs_staticpages' => '停用麵包屑導覽',
    'default_cache_time' => '預設快取時間',
    'newstaticpagesinterval' => '新靜態頁面時間範圍',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => '題目長度裁減',
    'includecenterblocks' => '包含中央區塊靜態頁面',
    'includephp' => '包含使用 PHP 的靜態頁面',
    'includesearch' => '在搜尋中啟用靜態頁面',
    'includesearchcenterblocks' => '包含中央區塊靜態頁面',
    'includesearchphp' => '包含使用 PHP 的靜態頁面',
    'includesearchtemplate' => '包含範本靜態頁面'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => '主要設定'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => '靜態頁面主要設定',
    'tab_whatsnew' => '有什麼新的 組件',
    'tab_search' => '搜尋結果',
    'tab_permissions' => '預設權限',
    'tab_autotag_permissions' => '自動標籤使用權限'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => '靜態頁面主要設定',
    'fs_whatsnew' => '有什麼新的 組件',
    'fs_search' => '搜尋結果',
    'fs_permissions' => '預設權限',
    'fs_autotag_permissions' => '自動標籤使用權限'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('是' => 1, '否' => 0),
    1 => array('是' => TRUE, '否' => FALSE),
    2 => array('日期' => 'date', '頁面 ID' => 'id', '標題' => 'title'),
    3 => array('日期' => 'date', '頁面 ID' => 'id', '標題' => 'title', '標籤' => 'label'),
    4 => array('日期' => 'date', '頁面 ID' => 'id', '標題' => 'title', '作者' => 'author'),
    5 => array('隱藏' => 'hide', '顯示 - 使用修改日期' => 'modified', '顯示 - 使用建立日期' => 'created'),
    9 => array('轉到頁面' => 'item', '顯示清單' => 'list', '顯示首頁' => 'home', '顯示管理頁' => 'admin'),
    12 => array('無權限' => 0, '唯讀' => 2, '讀寫' => 3),
    13 => array('無權限' => 0, '使用' => 2),
    17 => array('啟用評論' => 0, '停用評論' => -1),
    39 => array('無' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting'),
    41 => array('否' => 0, '喜歡和不喜歡' => 1, '僅喜歡' => 2)
);
