<?php

###############################################################################
# japanese_utf-8.php
#
# This is the Japanese language file for the Geeklog Polls plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony AT tonybibbs DOT com
# Copyright (C) 2005 Trinity Bays
# trinity93 AT gmail DOT com
# Tranlated by Geeklog Japanese group SaY and Ivy
# Copyright (C) 2008 Takahiro Kambe
# Additional translation to Japanese by taca AT back-street DOT net
# Copyright (C) 2006,2007,2008 Geeklog.jp group
# Additional translation to Japanese by Geeklog.jp group info AT geeklog DOT jp
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
    'poll' => 'Poll',
    'results' => '結果',
    'pollresults' => '投票結果',
    'votes' => '投票',
    'voters' => 'voters',
    'vote' => '投票する',
    'pastpolls' => 'アンケートの一覧',
    'savedvotetitle' => '投票ありがとうございました',
    'savedvotemsg' => 'テーマ:',
    'pollstitle' => 'アンケート一覧',
    'polltopics' => '他のアンケートを見る',
    'stats_top10' => 'アンケート(上位10件)',
    'stats_topics' => 'アンケートの質問',
    'stats_votes' => '投票',
    'stats_none' => 'このサイトにはアンケートがないか、まだ誰も投票していないようです。',
    'stats_summary' => 'アンケート数(投票数)',
    'open_poll' => '投票可否',
    'answer_all' => '残りのすべての質問にお答えください',
    'not_saved' => '結果は保存されませんでした',
    'upgrade1' => 'アンケートプラグインの新しいバージョンをインストールしました。',
    'upgrade2' => 'アップグレードしてください。',
    'editinstructions' => 'アンケートIDを入力してください。少なくとも1つの質問と2つの回答を用意してください。',
    'pollclosed' => 'このアンケートは投票を終了しました。',
    'pollhidden' => 'あなたは既に投票済みです。このアンケートの結果は投票終了後に公開します。',
    'start_poll' => '投稿する',
    'no_new_polls' => '新しいアンケートはありません',
    'autotag_desc_poll' => '[poll: id alternate title] - Displays a link to a poll using the Poll Topic as the title. An alternate title may be specified but is not required.',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] - アンケートの投票リンクを表示。Class と showall は必須ではありません。Class は css class を。Showall が 1ならすべての投票を表示',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] - 投票結果を表示。Class は必須ではありません。Claはcss classを指定します',
    'deny_msg' => 'このアンケートにアクセスできません。(このアンケートを移動や削除しているか、アクセス権がありません。)'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'モード',
    2 => 'テーマと質問と少なくとも1つの回答を入力してください。',
    3 => '作成日時',
    4 => 'アンケート( %s )を保存しました',
    5 => 'アンケートの編集',
    6 => 'アンケートID',
    7 => '(スペースを含まないこと)',
    8 => 'ホームページに表示する',
    9 => 'テーマ',
    10 => '回答 / 投票数 / 備考',
    11 => 'アンケート( %s )の選択肢にエラーがありました',
    12 => 'アンケート( %s )の質問項目にエラーがありました',
    13 => 'アンケートの作成',
    14 => '保存',
    15 => '中止',
    16 => '削除',
    17 => 'アンケートIDを入力してください',
    18 => 'アンケート管理',
    19 => 'アンケートの編集・削除は編集アイコンをクリック、アンケートの作成は上の「新規作成」をクリックしてください。',
    20 => '投票者',
    21 => 'アクセスできません',
    22 => "管理権限のないアンケートを編集しようとしました。このアクセスを記録しました。<a href=\"{$_CONF['site_admin_url']}/poll.php\">投票の管理画面</a>に戻ってください。",
    23 => '新規アンケート',
    24 => '管理画面',
    25 => 'はい',
    26 => 'いいえ',
    27 => '編集',
    28 => '検索',
    29 => '検索条件',
    30 => '表示件数',
    31 => '質問',
    32 => 'この質問をアンケートから削除するには、質問のテキストを削除してください。',
    33 => '投票可能',
    34 => 'テーマ:',
    35 => 'このアンケートにはさらにもう',
    36 => '件、質問があります。',
    37 => '投票時は結果非公開',
    38 => 'アンケート実施中は、オーナーとルート管理者だけが結果を見ることができます。',
    39 => 'テーマは1つ以上の質問がある場合に表示します。',
    40 => 'アンケートの結果を見る'
);

$PLG_polls_MESSAGE15 = 'あなたのコメントはスタッフによる承認待ちとなっていて、承認が済むとサイトに表示します。';
$PLG_polls_MESSAGE19 = 'アンケートを登録しました。';
$PLG_polls_MESSAGE20 = 'アンケートを削除しました。';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'プラグインはアップグレードをサポートしていません。';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'アンケート',
    'title' => 'アンケートの設定'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'ログインを要求する',
    'hidepollsmenu' => 'メニューに表示しない',
    'maxquestions' => 'アンケート毎の質問の最大数',
    'maxanswers' => '質問毎の選択肢の最大数',
    'answerorder' => 'アンケート結果の表示順',
    'pollcookietime' => '投票者のクッキーの有効期間',
    'polladdresstime' => '投票者のIPアドレスの有効期間',
    'delete_polls' => '所有者の削除と共に削除する',
    'aftersave' => 'アンケート保存後の画面遷移',
    'default_permissions' => 'パーミッション',
    'autotag_permissions_poll' => '[poll: ] パーミッション',
    'autotag_permissions_poll_vote' => '[poll_vote: ] パーミッション',
    'autotag_permissions_poll_result' => '[poll_result: ] パーミッション',
    'newpollsinterval' => 'アンケートの"新着"期間',
    'hidenewpolls' => '新着アンケート',
    'title_trim_length' => 'タイトル最大長',
    'meta_tags' => 'メタタグを有効にする',
    'block_enable' => '有効',
    'block_isleft' => '左ブロックで表示する',
    'block_order' => 'ブロックの順番',
    'block_topic_option' => '話題オプション',
    'block_topic' => '話題',
    'block_group_id' => 'グループ',
    'block_permissions' => 'パーミッション'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'メイン'
);

$LANG_tab['polls'] = array(
    'tab_main' => 'アンケートのメイン設定',
    'tab_whatsnew' => '新着情報ブロック',
    'tab_permissions' => 'パーミッションのデフォルト',
    'tab_autotag_permissions' => '自動タグのパーミッション',
    'tab_poll_block' => 'アンケートブロック'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'アンケートのメイン設定',
    'fs_whatsnew' => '新着情報ブロック',
    'fs_permissions' => 'アンケートのパーミッションのデフォルト([0]所有者 [1]グループ [2]メンバー [3]ゲスト)',
    'fs_autotag_permissions' => '自動タグのパーミッション([0]所有者 [1]グループ [2]メンバー [3]ゲスト)',
    'fs_block_settings' => 'ブロックの設定',
    'fs_block_permissions' => 'ブロックのパーミッション ([0]所有者 [1]グループ [2]メンバー [3]ゲスト)'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => true, 'いいえ' => false),
    2 => array('登録順' => 'submitorder', '得票順' => 'voteorder'),
    5 => array('表示しない' => 'hide', '編集日付によって表示する' => 'modified', '作成日付によって表示する' => 'created'),
    9 => array('ページを表示' => 'item', 'リストを表示' => 'list', 'プラグイントップを表示' => 'plugin', 'ホームを表示' => 'home', '管理画面のトップを表示' => 'admin'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
    13 => array('アクセス不可' => 0, '利用する' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('すべて' => TOPIC_ALL_OPTION, 'ホームページのみ' => TOPIC_HOMEONLY_OPTION, '話題を選択する' => TOPIC_SELECTED_OPTION)
);

?>
