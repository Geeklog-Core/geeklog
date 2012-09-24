<?php

###############################################################################
# korean_utf-8.php
# This is the Korean UTF-8 language page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
# Translated by IvySOHO Ivy(KOMMA Tetsuko/Kim Younghie)
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

# index.php
$LANG_CAL_1 = array(
    1 => ' 이벤트스캐줄',
    2 => '-',
    3 => '일시',
    4 => '장소',
    5 => '설명',
    6 => '이벤트의 추가',
    7 => '앞으로의 이벤트',
    8 => '개인스캐줄에 이 이벤트를 추가하면, 「개인스캐줄」을 사용자 관리메뉴에서 선택하여 손쉽게 볼 수 있습니다。',
    9 => '개인스캐줄에 추가',
    10 => '개인스캐줄에서 삭제',
    11 => '이 이벤트를 %s씨의 개인스캐줄에 추가',
    12 => '이벤트',
    13 => '개시',
    14 => '종료',
    15 => '스캐줄로 돌아가기',
    16 => '스캐줄',
    17 => '개시일',
    18 => '종료일',
    19 => '이벤트의 등록신청',
    20 => '제목',
    21 => '개시일',
    22 => 'URL',
    23 => '개인 이벤트',
    24 => '사이트의 이벤트',
    25 => '-',
    26 => '이벤트에 덧글쓰기',
    27 => "{$_CONF['site_name']} 에 이벤트를 투고하면，사이트 전체스캐줄에 등록됩니다。<br" . XHTML . ">전체스캐줄의 이벤트는 각 사용자가 필요에 따라 개인스캐줄에 등록 할 수 있습니다。",
    28 => '제목',
    29 => '종료일시',
    30 => '개시일시',
    31 => '하루종일의 이벤트',
    32 => '주소1',
    33 => '주소2',
    34 => '지역이름',
    35 => '도시구분',
    36 => '우편번호',
    37 => '이벤트의 종류',
    38 => '이벤트의 종류를 편집',
    39 => '장소',
    40 => '이벤트를 추가：',
    41 => '전체스캐줄',
    42 => '개인스캐줄',
    43 => '링크',
    44 => 'HTML태그는 사용할 수 없습니다',
    45 => '덧글',
    46 => '시스템의 이벤트',
    47 => '이벤트의 상위 10건',
    48 => '검색수',
    49 => '이 사이트에는 이벤트가 없거나, 아무도 이벤트를 클릭한 적 없거나 어느 쪽일 것으로 생각됩니다。',
    50 => '이벤트',
    51 => '삭제',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
);

$_LANG_CAL_SEARCH = array(
    'results' => '이벤트정보의 검색결과',
    'title' => '제목',
    'date_time' => '일시',
    'location' => '장소',
    'description' => '자세한 설명'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '개인이벤트를 추가 ',
    9 => '%s 씨 이벤트',
    10 => '이벤트：',
    11 => '전체스캐줄',
    12 => '개인스캐줄',
    25 => '돌아가기：',
    26 => '하루종일',
    27 => '주',
    28 => '개인스캐줄：',
    29 => '전체스캐줄',
    30 => '이벤트 추가',
    31 => '추가',
    32 => '이벤트',
    33 => '날짜',
    34 => '시간',
    35 => '간단추가',
    36 => '덧글',
    37 => '이 사이트에는 개인스캐줄이 유효하지 않습니다。',
    38 => '개인이벤트 에디터',
    39 => '일',
    40 => '주',
    41 => '월',
    42 => '전체이벤트 추가',
    43 => '이벤트 덧글'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => '이벤트에디터',
    2 => '에러',
    3 => '덧글모드',
    4 => '이벤트URL',
    5 => '이벤트 개시일시',
    6 => '이벤트 종료일시',
    7 => '이벤트 장소',
    8 => '이벤트에 대한 설명',
    9 => '(http://부터 시작하시기 바랍니다)',
    10 => '이벤트 날짜・시간，제목，설명을 입력하시기 바랍니다。',
    11 => '스캐줄 관리',
    12 => '이벤트의 편집・삭제는，다음의 이벤트 편집아이콘을 클릭 하시기 바랍니다。 새로운 이벤트를 작성할 경우, 위의 「신규이벤트」를 클릭 하시기 바랍니다。',
    13 => '글쓴이',
    14 => '개시일시',
    15 => '종료일시',
    16 => '',
    17 => "관리권한이 없는 이벤트를 편집하려고 하셨습니다。 이 행위는 기록 됩니다. <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\"> 이벤트 편집화면</a>으로 돌아가시기 바랍니다.。",
    18 => '',
    19 => '',
    20 => '보존',
    21 => '취소',
    22 => '삭제',
    23 => '개시일시를 정확하게 입력해 주시기 바랍니다。',
    24 => '종료일시를 정확하게 입력해 주시기 바랍니다。',
    25 => '종료일시를 정확하게 입력해 주시기 바랍니다。',
    26 => 'Delete old entries',
    27 => 'These are the events that are older than ',
    28 => ' months. Please click on the trashcan Icon on the bottom to delete them, or select a different timespan:<br' . XHTML . '>Find all entries that are older than ',
    29 => ' months.',
    30 => 'Update List',
    31 => 'Are You sure you want to permanently delete ALL selected users?',
    32 => 'List all',
    33 => 'No events selected for deletion',
    34 => 'Event ID',
    35 => 'could not be deleted',
    36 => 'Sucessfully deleted'
);

$LANG_CAL_MESSAGE = array(
    'save' => '이벤트가 보존 되었습니다。',
    'delete' => '이벤트가 삭제 되었습니다。',
    'private' => '이벤트가 개인스캐줄에 보존 되었습니다。',
    'login' => '개인스캐줄을 열때에는，먼저 로그인 해 주시기 바랍니다。',
    'removed' => '개인스캐줄에서 이벤트가 삭제 되었습니다。',
    'noprivate' => '죄송합니다만，이 사이트에서는，개인스캐줄이 무효합니다。',
    'unauth' => '죄송합니다만，이벤트 관리페이지에 접속할 권한이 없습니다。 이 접속이 기록 된다는 점을 양해해 주시기 바랍니다.'
);

$PLG_calendar_MESSAGE4 = "{$_CONF['site_name']} 에 이벤트를 투고해 주셔서 대단히 감사합니다。스탭에게 보내어져，승인을 기다리고 있는 상태입니다。 승인이 되면 이 사이트의 <a href=\"{$_CONF['site_url']}/calendar/index.php\">스캐줄</a> 부문에 표시 됩니다。";
$PLG_calendar_MESSAGE17 = '이벤트가 보존 되었습니다。';
$PLG_calendar_MESSAGE18 = '이벤트가 삭제 되었습니다。';
$PLG_calendar_MESSAGE24 = '이벤트가 개인스캐줄에 보존 되었습니다。';
$PLG_calendar_MESSAGE26 = '이벤트가 삭제 되었습니다。';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendar',
    'title' => 'Calendar Configuration'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Calendar Login Required?',
    'hidecalendarmenu' => 'Hide Calendar Menu Entry?',
    'personalcalendars' => 'Enable Personal Calendars?',
    'eventsubmission' => 'Enable Submission Queue?',
    'showupcomingevents' => 'Show upcoming Events?',
    'upcomingeventsrange' => 'Upcoming Events Range',
    'event_types' => 'Event Types',
    'hour_mode' => 'Hour Mode',
    'notification' => 'Notification Email?',
    'delete_event' => 'Delete Events with Owner?',
    'aftersave' => 'After Saving Event',
    'default_permissions' => 'Event Default Permissions',
    'autotag_permissions_event' => '[event: ] Permissions',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'General Calendar Settings',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_events_block' => 'Events Block'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
