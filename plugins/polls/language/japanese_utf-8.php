<?php

###############################################################################
# japanese_utf-8.php
# This is the Japanese language page for the Geeklog Polls Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
# Tranlated by Geeklog Japanese group SaY and Ivy
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
# Last Update 2007/01/30 by Ivy (Geeklog Japanese)

$LANG_POLLS = array(
    'polls'             => 'アンケート',
    'results'           => '結果',
    'pollresults'       => '投票結果',
    'votes'             => '投票',
    'vote'              => '投票する',
    'pastpolls'         => 'アンケートの一覧',
    'savedvotetitle'    => '投票が登録されました',
    'savedvotemsg'      => '今の投票が登録されました',
    'pollstitle'        => '募集中のアンケート',
    'polltopics'        => 'Other polls',
    'stats_top10'       => 'Top Ten Polls',
    'stats_topics'      => 'Poll Topic',
    'stats_votes'       => 'Votes',
    'stats_none'        => 'It appears that there are no polls on this site or no one has ever voted.',
    'stats_summary'     => 'Polls (Answers) in the system',
    'open_poll'         => 'Open for Voting',
    'answer_all'        => 'Please answer all remaining questions',
    'not_saved'         => 'Result not saved',
    'upgrade1'          => 'You installed a new version of the Polls plugin. Please',
    'upgrade2'          => 'upgrade',
    'editinstructions'  => 'Please fill in the Poll ID, at least one question and two answers for it.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'モード',
    2 => '質問と少なくとも一つの選択肢を入力してください',
    3 => '作成日時',
    4 => "アンケート（ %s ）が保存されました",
    5 => 'アンケートの編集',
    6 => 'アンケートID',
    7 => '(スペースを含まないこと)',
    8 => 'ホームページに表示する',
    9 => '質問すること',
    10 => '回答 ／ 投票数',
    11 => "アンケート( %s )の選択肢にエラーがありました",
    12 => "アンケート( %s )の質問項目にエラーがありました",
    13 => 'アンケートの作成',
    14 => '保存',
    15 => '中止',
    16 => '削除',
    17 => 'アンケートIDを入力してください',
    18 => 'アンケート一覧',
    19 => 'アンケートの削除・編集はタイトル左のアイコンをクリック，新規に作成する場合は「新規作成」をクリックしてください。タイトルをクリックするとアンケートを閲覧できます。',
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
    30 => '表示件数',
    31 => 'Question',
    32 => 'To remove this question from the poll, remove its question text',
    33 => 'Open for voting',
    34 => 'Poll Topic:',
    35 => 'This poll has',
    36 => 'more questions.',
    37 => 'Hide results while poll is open',
    38 => 'While the poll is open, only the owner &amp; root can see the results',
    39 => 'The topic will be only displayed if there are more than 1 questions.',
    40 => 'See all answers to this poll'
);

$PLG_polls_MESSAGE19 = 'アンケートが登録されました。';
$PLG_polls_MESSAGE20 = 'アンケートは削除されました。';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
