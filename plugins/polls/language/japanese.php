<?php

###############################################################################
# english.php
# This is the english language page for the Geeklog Polls Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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
    'polls'     => 'アンケート',
    'results'   => '結果',
    'pollresults'   => '投票結果',
    'votes'     => '投票',
    'vote'      => '投票する',
    'pastpolls' => 'アンケートの一覧',
    'savedvotetitle'    => '投票が登録されました',
    'savedvotemsg'  => '今の投票が登録されました',
    'pollstitle'    => '募集中のアンケート',
    'pollquestions' => '他のアンケートを見る'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'モード',
    2 => '質問と最低一つの選択肢を入力してください',
    3 => '作成日時',
    4 => "アンケート（ %s ）が保存されました",
    5 => 'アンケートの編集',
    6 => 'アンケートの ID',
    7 => '(スペースを含まないこと)',
    8 => 'ホームページに表示する',
    9 => '質問すること',
    10 => '回答 ／ 投票数',
    11 => "アンケート( %s )における選択肢にエラーがありました",
    12 => "アンケート( %s )における質問項目にエラーがありました",
    13 => 'アンケートの作成',
    14 => '保存',
    15 => '中止',
    16 => '削除',
    17 => '投票IDを入力してください',
    18 => 'アンケート一覧',
    19 => 'アンケートを削除・編集するためには、タイトル左のアイコンをクリックしてください。新規に作成する場合は、「新規作成」をクリックしてください。タイトルをクリックするとアンケートを閲覧できます。',
    20 => '投票者',
    21 => 'アクセスが拒否されました',
    22 => "管理権限のないアンケートを編集しようとしました。この行為は記録されます。<a href=\"{$_CONF['site_admin_url']}/poll.php\">投票の管理画面</a>に戻ってください。",
    23 => '新規アンケート',
    24 => '管理画面',
    25 => 'はい',
    26 => 'いいえ',
    27 => '編集',
    28 => '検索',
    29 => '検索条件',
    30 => '表示件数'

);

$PLG_polls_MESSAGE19 = 'アンケートが登録されました。';

?>
