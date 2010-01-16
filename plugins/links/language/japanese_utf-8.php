<?php

###############################################################################
# japanese_utf-8.php
#
# This is the Japanese language file for the Geeklog Links Plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony AT tonybibbs DOT com
# Copyright (C) 2005 Trinity Bays
# trinity93 AT gmail DOT com
# Tranlated by Geeklog Japanese group
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

/**
 * This is the Japanese language page for the Geeklog links Plug-in!
 *
 * @package Links
 * @subpackage Language
 * @filesource
 * @version 2.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2007
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Trinity Bays, trinity93 AT gmail DOT com
 * @author Tony Bibbs, tony AT tonybibbs DOT com
 * @author Tom Willett, twillett AT users DOT sourceforge DOT net
 *
 */

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_LINKS = array(
    10 => '投稿',
    14 => 'リンク',
    84 => 'リンク',
    88 => '新しいリンクはありません',
    114 => 'リンク',
    116 => 'リンク投稿',
    117 => 'リンク切れをご報告ください。',
    118 => 'リンク切れの報告',
    119 => '次のリンクは切れていると報告されました:',
    120 => 'リンクの編集は、ここをクリック:',
    121 => 'リンク切れの報告者:',
    122 => 'リンク切れをご報告いただきありがとうございます。できるだけ速やかに修正いたします。',
    123 => 'ありがとうございます。',
    124 => '表示',
    125 => 'カテゴリ',
    126 => '現在の位置:',
    'root' => 'トップ'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'リンク数（クリック数）',
    'stats_headline' => 'リンク（上位10件）',
    'stats_page_title' => 'リンク',
    'stats_hits' => 'ヒット',
    'stats_no_hits' => 'このサイトにはリンクがないか、クリックした人がいないかのどちらかのようです。'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => 'リンクの検索結果',
    'title' => 'タイトル',
    'date' => '投稿した日時',
    'author' => '投稿者',
    'hits' => 'クリック数'
);

###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'リンクを投稿する',
    2 => 'リンク',
    3 => 'カテゴリ',
    4 => 'その他',
    5 => '新しいカテゴリ名',
    6 => 'エラー: カテゴリを選んでください',
    7 => '「その他」を選択する場合には新しいカテゴリ名を記入してください。',
    8 => 'タイトル',
    9 => 'URL',
    10 => 'カテゴリ',
    11 => 'リンクの投稿申請'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "{$_CONF['site_name']}にリンクを登録していただき、ありがとうございます。このリンクは承認のためにスタッフに送られました。承認されますと、あなたのリンクは<a href={$_CONF['site_url']}/links/index.php>リンクセクション</a>に表示されます。";
$PLG_links_MESSAGE2 = 'リンクは保存されました。';
$PLG_links_MESSAGE3 = 'リンクは削除されました。';
$PLG_links_MESSAGE4 = "{$_CONF['site_name']}にリンクを登録していただき、ありがとうございます。<a href={$_CONF['site_url']}/links/index.php>リンク</a>セクションでご覧いただけます。";
$PLG_links_MESSAGE5 = 'あなたには、このカテゴリを見るための十分なアクセス権がありません。';
$PLG_links_MESSAGE6 = 'あなたには、このカテゴリを編集する十分な権利がありません。';
$PLG_links_MESSAGE7 = 'カテゴリの名前と説明を入力してください。';
$PLG_links_MESSAGE10 = 'カテゴリは保存されました。';
$PLG_links_MESSAGE11 = 'カテゴリ IDを「site」または「user」に設定することはできません。これらは内部で使用するために予約されています。';
$PLG_links_MESSAGE12 = 'あなたは、編集中のカテゴリ自身のサブカテゴリを、親カテゴリに設定しようとしています。これは孤立するカテゴリを作成することになりますので、先に子カテゴリまたはカテゴリを、より高いレベルへ移動させてください。';
$PLG_links_MESSAGE13 = 'カテゴリは削除されました。';
$PLG_links_MESSAGE14 = 'カテゴリはリンクやカテゴリを含んでいます。先にそれらを取り除いてください。';
$PLG_links_MESSAGE15 = 'あなたには、このカテゴリを削除する十分な権利がありません。';
$PLG_links_MESSAGE16 = 'そのようなカテゴリは存在しません。';
$PLG_links_MESSAGE17 = 'このカテゴリIDはすでに使われています。';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'プラグインのアップグレードはサポートされていません。';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

$LANG_LINKS_ADMIN = array(
    1 => 'リンクの編集',
    2 => 'リンクID',
    3 => 'タイトル',
    4 => 'URL',
    5 => 'カテゴリ',
    6 => '(http://を含む)',
    7 => 'その他',
    8 => 'ヒット数',
    9 => '説明',
    10 => 'タイトル、URL、説明の入力が必要です',
    11 => 'リンク管理',
    12 => 'リンクの編集・削除は編集アイコンをクリック、リンクまたはカテゴリの作成は上の「リンクの作成」または「カテゴリの作成」をクリックしてください。マルチカテゴリを編集する場合は、上の「カテゴリの編集」をクリックしてください。',
    14 => 'カテゴリ',
    16 => 'アクセスが拒否されました',
    17 => "権限のないリンクにアクセスしようとしましたのでログに記録しました。<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">リンクの管理画面に戻って</a>ください。",
    20 => 'その他を指定',
    21 => '保存',
    22 => 'キャンセル',
    23 => '削除',
    24 => 'リンク先が見つかりません',
    25 => '編集対象のリンクが見つかりませんでした.',
    26 => 'リンクの確認',
    27 => 'HTMLステータス',
    28 => 'カテゴリの編集',
    29 => '以下の項目を入力または編集してください。',
    30 => 'カテゴリ',
    31 => '説明',
    32 => 'カテゴリID',
    33 => '話題',
    34 => '親カテゴリ',
    35 => 'すべて',
    40 => 'このカテゴリを編集する',
    41 => '子カテゴリを作成する',
    42 => 'このカテゴリを削除する',
    43 => 'サイトカテゴリ',
    44 => '子カテゴリの追加',
    46 => 'ユーザ %s は、アクセス権がないカテゴリを削除しようとしました。',
    50 => 'カテゴリのリスト',
    51 => 'リンクの作成',
    52 => 'カテゴリの作成',
    53 => 'リンクのリスト',
    54 => 'カテゴリの管理',
    55 => '以下のカテゴリを編集してください。 リンクやカテゴリを含むカテゴリは削除できません。先にこれらを削除するか、ほかのカテゴリに移す必要があります。',
    56 => 'カテゴリの編集',
    57 => 'まだ確認されていません。',
    58 => 'リンクの確認',
    59 => '<p>表示されている全てのリンクを確認する場合は、下の「リンクの確認」をクリックしてください。この処理はリンクの数に応じてかなりの時間がかかるかもしれません。</p>',
    60 => 'ユーザ %s は権限なしにカテゴリ %s を編集しようとしました。',
    61 => 'このカテゴリのリンク数'
);


$LANG_LINKS_STATUS = array(
    100 => '継続',
    101 => 'プロトコル切替',
    200 => 'OK',
    201 => '作成',
    202 => '受理',
    203 => '信頼できない情報',
    204 => '内容なし',
    205 => '内容のリセット',
    206 => '部分的内容',
    300 => '複数の選択',
    301 => '永久に移動した',
    302 => '発見した',
    303 => '他を参照せよ',
    304 => '未更新',
    305 => 'プロキシを使用せよ',
    307 => '一時的リダイレクト',
    400 => 'リクエストが不正である',
    401 => '認証が必要である',
    402 => '支払いが必要である',
    403 => '禁止されている',
    404 => '未検出',
    405 => '許可されていないメソッド',
    406 => '受理できない',
    407 => 'プロキシ認証が必要である',
    408 => 'リクエストタイムアウト',
    409 => '矛盾',
    410 => '消滅した',
    411 => '長さが必要',
    412 => '前提条件で失敗した',
    413 => 'リクエストエンティティが大きすぎる',
    414 => 'リクエストURIが大きすぎる',
    415 => 'サポートしていないメディアタイプ',
    416 => 'リクエストしたレンジは範囲外にある',
    417 => '期待するヘッダに失敗',
    500 => 'サーバ内部エラー',
    501 => '実装されていない',
    502 => '不正なゲートウェイ',
    503 => 'サービス利用不可',
    504 => 'ゲートウェイタイムアウト',
    505 => 'サポートしていないHTTPバージョン',
    999 => '接続がタイムアウト'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => 'リンク',
    'title' => 'リンクの設定'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => 'ログインを要求する',
    'linksubmission' => 'リンクの投稿を管理者が承認する',
    'newlinksinterval' => '新規リンクと見なす期間',
    'hidenewlinks' => '新着情報ブロックに表示しない',
    'hidelinksmenu' => 'メニューに表示しない',
    'linkcols' => 'カテゴリの表示カラム数',
    'linksperpage' => 'ページあたりのリンク数',
    'show_top10' => 'トップ10を表示する',
    'notification' => 'メールで通知する',
    'delete_links' => '所有者の削除と共に削除する',
    'aftersave' => 'リンク保存後の画面遷移',
    'show_category_descriptions' => 'カテゴリの説明を表示する',
    'new_window' => 'リンクを新しいウィンドウで開く',
    'root' => 'トップカテゴリのID',
    'default_permissions' => 'パーミッション',
    'category_permissions' => 'パーミッション'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'メイン'
);

$LANG_fs['links'] = array(
    'fs_public' => 'リンクの表示',
    'fs_admin' => 'リンクの管理',
    'fs_permissions' => 'リンクのパーミッションのデフォルト（[0]所有者 [1]グループ [2]メンバー [3]ゲスト）',
    'fs_cpermissions' => 'カテゴリのパーミッションのデフォルト（[0]所有者 [1]グループ [2]メンバー [3]ゲスト）'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => TRUE, 'いいえ' => FALSE),
    9 => array('リンク先サイトを表示する' => 'item', 'リンク管理を表示する' => 'list', '公開リンクリストを表示する' => 'plugin', 'ホームを表示する' => 'home', '管理画面トップを表示する' => 'admin'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3)
);

?>
