<?php

###############################################################################
# korean_utf-8.php
# This is the english language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Tranlated by IvySOHO Ivy(KOMMA Tetsuko/Kim Younghie)
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
    'newpage' => '신규페이지',
    'adminhome' => '관리화면',
    'staticpages' => '정적 페이지',
    'staticpageeditor' => '정적 페이지의 편집',
    'writtenby' => '소유자',
    'date' => '최종갱신일',
    'title' => '제목',
    'page_title' => 'Page Title',
    'content' => '내용',
    'hits' => '조회건수',
    'staticpagelist' => '정적 페이지 관리',
    'url' => 'URL',
    'edit' => '편집',
    'lastupdated' => '최종갱신일',
    'pageformat' => '페이지 포멧',
    'leftrightblocks' => '좌우블로그 있습니다',
    'blankpage' => '전체 화면표시',
    'noblocks' => '블로그 없습니다',
    'leftblocks' => '왼편블로그 있습니다(오른편블로그는 없습니다)',
    'addtomenu' => '왼편블로그 메뉴에 추가',
    'label' => '메뉴이름',
    'nopages' => '정적 페이지가 없습니다',
    'save' => '보존',
    'preview' => '미리보기',
    'delete' => '삭제',
    'cancel' => '취소',
    'access_denied' => '죄송합니다만, 먼저 로그인 하시기 바랍니다',
    'access_denied_msg' => '체크를 하면 접속권한이 없는 경우, 화면이 로그인 화면으로 자동적으로 표시됩니다.  체크를 하지 않는 경우에는 「관리권한이 없습니다」라는 메세지가 표시 됩니다',
    'all_html_allowed' => '모든 HTML 을 이용 할 수 있습니다',
    'results' => '정적 페이지 검색결과',
    'author' => '소유자',
    'no_title_or_content' => ' <b> 제목</b> 와  <b> 내용</b> 를 적어주시기 바랍니다.',
    'no_such_page_anon' => '로그인 하시기 바랍니다.',
    'no_page_access_msg' => "이 문제는 아직 로그인 하지 않았거나 아마도 이 사이트 {$_CONF['site_name']} 의 회원이 아니기 때문인 것으로 여겨집니다.  {$_CONF['site_name']} 에 <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> 회원등록</a>을 하시거나, 적절한 접속권을 관리자로 부터 취득하시기 바랍니다",
    'php_msg' => 'PHP: ',
    'php_warn' => '<br' . XHTML . '>주의: 이 옵션이 유효하기 되면 당신의 페이지에 들어있는 PHP 코드가 실행됩니다.  정적 페이지를 이용하는 경우에는 다시한번 관리화면 「그룹:Static Page Admin」에서 권한「Staticpages. PHP」 에 체크하시기 바랍니다.  PHP를 사용하는 경우 통상(return) 없이 그대로 「PHP 실행하기」 모드에서 이용할 수 있습니다.  이용에는 세심한 주의를 기울이시기 바랍니다 !!',
    'exit_msg' => '조회권한이 없는 경우: ',
    'exit_info' => '체크를 하면 조회권한이 없는 경우, 로그인 요구화면이 표시됩니다. 체크를 하지 않는 경우에는 「권한이 없습니다」 라는 메세지가 표시됩니다.',
    'deny_msg' => '페이지 접속에 실패 하였습니다.  페이지가 이동 혹은 삭제되거나, 아니면 권한이 없거나 어느 한 쪽일 것입니다.',
    'stats_headline' => '정적 페이지 톱 10',
    'stats_page_title' => '제목',
    'stats_hits' => '조회건수',
    'stats_no_hits' => '정적 페이지가 없거나, 조회자가 없거나 어느 쪽일 것입니다.',
    'id' => 'ID',
    'duplicate_id' => '지정한 ID 는 이미 사용 되고 있습니다. 다른 ID를 사용하시기 바랍니다.',
    'instructions' => '페이지를 편집, 삭제는 각 페이지 머리부분의 편집아이콘을 클릭.  페이지 조회는 제목을 클릭, 새로운 페이지를 작성 할 경우에는 「신규작성」링크를 클릭. 페이지 복사는 「C」를 클릭 하시기 바랍니다.',
    'centerblock' => '중심영역 표시: ',
    'centerblock_msg' => '체크를 하면 처음페이지 혹은 화제의 머리 페이지 중심영역에 표시됩니다. 표시는 ID로 분류 됩니다.',
    'topic' => '토픽: ',
    'position' => '표시장소: ',
    'all_topics' => '전부',
    'no_topic' => '홈페이지만',
    'position_top' => '페이지 머릿부분',
    'position_feat' => '주목기사 아랫부분',
    'position_bottom' => '페이지 아래',
    'position_entire' => '페이지 전체',
    'head_centerblock' => '머리 표시',
    'centerblock_no' => '아니오',
    'centerblock_top' => '머리',
    'centerblock_feat' => '주목기사',
    'centerblock_bottom' => '아랫부분',
    'centerblock_entire' => '페이지 전체',
    'inblock_msg' => '블로그로 둘러쌓임: ',
    'inblock_info' => '체크를 하면 제목이 표시되며, 내용은 상자안에 담겨집니다.',
    'title_edit' => '편집',
    'title_copy' => '복사를 작성',
    'title_display' => '페이지 표시',
    'select_php_none' => 'PHP를 실행하지 않습니다',
    'select_php_return' => 'PHP를 실행합니다 (return)',
    'select_php_free' => ' PHP를 실행합니다',
    'php_not_activated' => "정적 페이지에서  PHP는 사용하지 않는 설정으로 되어 있습니다.  자세한 것은  <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\"> 관련 도큐멘트 </a> 를 보시기 바랍니다.",
    'printable_format' => '인쇄용 포멧',
    'copy' => '복사',
    'limit_results' => '좁혀가며 검색',
    'search' => '검색',
    'submit' => '등록',
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
