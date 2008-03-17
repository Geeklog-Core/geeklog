<?php

###############################################################################
# korean_utf-8.php
# This is the english language page for the Geeklog Polls Plug-in!
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
# Last Update 2007/02/12 by Ivy (Geeklog Japanese)

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => '앙케이트',
    'results'           => '결과',
    'pollresults'       => '앙케이트 결과',
    'votes'             => '투표',
    'vote'              => '투표하기',
    'pastpolls'         => '앙케이트 전체보기',
    'savedvotetitle'    => '투표가 등록 되었습니다',
    'savedvotemsg'      => '지금의 투표가 등록 되었습니다',
    'pollstitle'        => '모집 중인 앙케이트',
    'pollquestions'     => '다른 앙케이트 보기',
    'stats_top10'       => '앙케이트 톱 10',
    'stats_questions'   => '앙케이트 질문',
    'stats_votes'       => '투표',
    'stats_none'        => '이 사이트에는 앙케이트가 없거나 앙케이트에 클릭한 사람이 없거나 어느 쪽일 것입니다.',
    'stats_summary'     => 'Polls (Answers) in the system',
    'open_poll'         => '공개 앙케이트'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => '모드',
    2 => '질문과 적어도 한가지 주요선택을 입력하시기 바랍니다.',
    3 => '작성일시',
    4 => "앙케이트 %s 가 보존 되었습니다",
    5 => '앙케이트의 편집',
    6 => '앙케이트ID',
    7 => '(스페이스 두지 않도록)',
    8 => '홈페이지에 표시하기',
    9 => '질문하기',
    10 => '응답 / 투표수 / 확인',
    11 => "앙케이트(%s)의 주요선택에 에러가 있었습니다 ",
    12 => "앙케이트(%s)의 질문항목에 에러가 있었습니다",
    13 => '앙케이트 작성',
    14 => '보존',
    15 => '중지',
    16 => '삭제',
    17 => '앙케이트ID를 입력하시기 바랍니다',
    18 => '앙케이트 전체보기',
    19 => '앙케이트의 삭제, 편집은 제목의 왼편 아이콘을 클릭, 신규작성일 경우는 「신규작성」을 클릭 하시기 바랍니다. 제목을 클릭하시면 앙케이트 보기가 가능합니다.',
    20 => '글쓴이',
    21 => '접속에 실패 하였습니다',
    22 => "관리권한이 없는 앙케이트를 편집하려고 하셨습니다.  이 행위는 기록 됩니다.  <a 
href=\"{$_CONF['site_admin_url']}/poll.php\"> 덧글의 관리화면으로 </a>으로 돌아가시기 바랍니다.",
    23 => '신규 앙케이트',
    24 => '관리화면',
    25 => '예',
    26 => '아니오',
    27 => '편집',
    28 => '검색',
    29 => '검색조건',
    30 => '표시건수',
);

$PLG_polls_MESSAGE19 = '앙케이트가 등록 되었습니다.';
$PLG_polls_MESSAGE20 = '앙케이트가 삭제 되었습니다.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
