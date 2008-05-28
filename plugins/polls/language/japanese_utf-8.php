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
# Copyright (C) 2008 Takahiro Kambe
# Additional translation to Japanese by taca AT back-street DOT net
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

$LANG_POLLS = array(
    'polls' => 'アンケート',
    'results' => '結果',
    'pollresults' => '投票結果',
    'votes' => '投票',
    'vote' => '投票する',
    'pastpolls' => 'アンケートの一覧',
    'savedvotetitle' => '投票が登録されました',
    'savedvotemsg' => '今の投票が登録されました',
    'pollstitle' => '募集中のアンケート',
    'polltopics' => '他のアンケート',
    'stats_top10' => '上位10のアンケート',
    'stats_topics' => 'アンケートの話題',
    'stats_votes' => '投票',
    'stats_none' => 'このサイトにはアンケートがないか、誰も投票していないようです。',
    'stats_summary' => 'アンケート (回答) in the system',
    'open_poll' => '投票を受け付け中',
    'answer_all' => '残りの質問にすべて答えてください。',
    'not_saved' => '結果は保存されませんでした。',
    'upgrade1' => '新しいアンケートのプラグインをインストールされえいます。どうか、',
    'upgrade2' => 'アップグレードして下さい。',
    'editinstructions' => 'アンケートのIDと少なくとも1つの質問、その質問に対応した2つの回答が必要です。',
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'モード',
    2 => '話題と少なくとも1つの質問、その質問に対応した2つの回答を入力して下さい。',
    3 => '作成日',
    4 => 'アンケート %s を保存しました',
    5 => 'アンケートを編集',
    6 => 'アンケートのID',
    7 => '(スペースを使用しないでください)',
    8 => 'アンケート・ブロックに表示',
    9 => '話題',
    10 => '回答 / 投票 / 注意',
    11 => 'アンケート%sの回答のデータの取得でエラーが発生しました。',
    12 => 'アンケート%sの質問のデータの取得でエラーが発生しました。',
    13 => 'アンケートを作成',
    14 => '保存',
    15 => 'キャンセル',
    16 => '削除',
    17 => 'アンケートのIDを入力して下さい',
    18 => '|アンケートの|リスト',
    19 => 'アンケートの編集や削除するには、アンケートの編集アイコンをクリックして下さい。新しいアンケートを作成するには上の「新規作成」をクリックして下さい。',
    20 => '投票者',
    21 => 'アクセスを拒否されました',
    22 => "アクセス権を持たないアンケートにアクセスしようとされました。この試みは記録されています。どうぞ<a href=\"{$_CONF['site_admin_url']}/poll.php\">アンケートの管理の画面に戻って下さい。</a>",
    23 => '新しいアンケート',
    24 => '管理Home',
    25 => 'はい',
    26 => 'いいえ',
    27 => '編集',
    28 => '投票',
    29 => '検索',
    30 => '結果を制限',
    31 => '質問',
    32 => '質問をアンケートから削除するには、質問のテキストを空にしてください。',
    33 => '投票受け付け中',
    34 => 'アンケートの話題:',
    35 => 'このアンケートは、あと',
    36 => '個の質問があります。',
    37 => '受け付け中は結果を隠す',
    38 => 'アンケートが受け付け中の間は、所有者とrootだけが結果を見れます。',
    39 => '話題は1つ以上の質問がある場合だけ表示されます。',
    40 => 'このアンケートのすべての回答を見る。'
);

$PLG_polls_MESSAGE19 = 'アンケートを登録しました。';
$PLG_polls_MESSAGE20 = 'アンケートを削除しました。';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'プラグインのアップグレードはサポートされていません。';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'アンケート',
    'title' => 'アンケートの設定'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'アンケートにログインが必要?',
    'hidepollsmenu' => 'アンケートのメニュー項目を隠す?',
    'maxquestions' => 'アンケートあたりの設問の最大数',
    'maxanswers' => '設問あたりの回答の最大数',
    'answerorder' => 'アンケートの結果...',
    'pollcookietime' => 'アンケートのCookieの有効期間',
    'polladdresstime' => 'アンケートのIPアドレスの有効期間',
    'delete_polls' => '所有者と共にアンケートを削除?',
    'aftersave' => 'アンケートの保存後',
    'default_permissions' => 'アンケートのデフォルトのパーミッション'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => '主な設定'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'アンケートの一般的な設定',
    'fs_permissions' => 'デフォルトのパーミッション'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => true, 'いいえ' => false),
    2 => array('アンケート順' => 'submitorder', '投票順' => 'voteorder'),
    9 => array('アンケートに進む' => 'item', '管理リストを表示' => 'list', '公開されたリストを表示' => 'plugin', 'HOMEページを表示' => 'home', '管理画面を表示' => 'admin'),
    12 => array('アクセス不可' => 0, '書き込み禁止' => 2, '読み書き可能' => 3)
);

?>