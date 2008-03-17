<?php

###############################################################################
# korean_utf-8.php
# This is the Japanese language page for the Geeklog links Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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
# $Id: korean_utf-8.php,v 1.2 2008/03/17 21:12:54 dhaun Exp $
# Last Update 2007/01/30 by Ivy (Geeklog Japanese)

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

$LANG_LINKS= array(
    10 => '덧글',
    14 => '링크',
    84 => '링크',
    88 => '-',
    114 => '링크',
    116 => '링크 추가'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => '등록된 링크(링크수)',
    'stats_headline' => '링크(상위 10건)',
    'stats_page_title' => '링크',
    'stats_hits' => '힛트',
    'stats_no_hits' => '이 사이트에는 링크가 없거나, 클릭한 사람이 없거나 어느 쪽일 것입니다。',
); 
 
###############################################################################
# for the search
 
$LANG_LINKS_SEARCH = array(
 'results' => '링크 검색결과',
 'title' => '제목',
 'date' => '추가한 일시',
 'author' => '글쓴이',
 'hits' => '링크수'
);
###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => '링크의 등록',
    2 => '링크',
    3 => '카테고리',
    4 => '그 외',
    5 => '새로운 카테고리 이름',
    6 => '에러：카테고리를 선택하기기 바랍니다',
    7 => '「그 외」를 선택할 경우 새로운 카테고리 이름을 적어주시기 바랍니다。',
    8 => '제목',
    9 => 'URL',
    10 => '카테고리',
    11 => '링크의 등록신청'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "{$_CONF['site_name']} 의 링크에 등록해 주셔서 감사합니다。 스탭이 내용을 확인하고 있습니다。 승인이 되면 <a 
href={$_CONF['site_url']}/links/index.php> 링크</a> 부문에 표시됩니다。";
$PLG_links_MESSAGE2 = '링크는 무사히 등록 되었습니다。';
$PLG_links_MESSAGE3 = '링크의 삭제가 완료 되었습니다。';
$PLG_links_MESSAGE4 = "{$_CONF['site_name']} 의 링크에 등록해 주셔서 감사합니다。<a href={$_CONF['site_url']}/links/index.php>링크</a>에서 확인 하시기 바랍니다。";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php

$LANG_LINKS_ADMIN = array(
    1 => '링크의 편집',
    2 => 'ID',
    3 => '제목',
    4 => 'URL',
    5 => '카테고리',
    6 => '(http://를 넣어주시기 바랍니다)',
    7 => '그 외',
    8 => '링크의 참조',
    9 => '설명',
    10 => '제목，URL，설명이 필요합니다',
    11 => '링크의 관리',
    12 => '링크를 수정，삭제 할 경우에는 각 링크의 「편집」아이콘을 클릭 하시기 바랍니다。신규작성은 위의「신규」를 클릭하시기 바랍니다。',
    14 => '카테고리',
    16 => '접속에 실패했습니다',
    17 => "권한이 없는 링크에 접속하려고 하셨기 때문에 로그에 기록 되었습니다.<aref=\"{$_CONF['site_admin_url']}/plugins/links/index.php\"> 링크의 관리화면으로 돌아가시기</a>바랍니다。",
    20 => '그 외를 지정',
    21 => '보존',
    22 => '취소',
    23 => '삭제'
);

?>
