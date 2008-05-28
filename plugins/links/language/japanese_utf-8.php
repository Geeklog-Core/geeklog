<?php

###############################################################################
# japanese_utf-8.php
# This is the Japanese language page for the Geeklog links Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
# Tranlated by Geeklog Japanese group
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

$LANG_LINKS = array(
    10 => '投稿',
    14 => 'リンク',
    84 => 'リンク',
    88 => '新しいリンクはありません',
    114 => 'リンク',
    116 => 'リンクの追加',
    117 => '壊れたリンクを報告',
    118 => '壊れたリンクのレポート',
    119 => '以下のリンクが壊れています: ',
    120 => 'リンクを編集するにはここをクリック: ',
    121 => '壊れたリンクの報告者: ',
    122 => '壊れたリンクを報告していただき、ありがとうございます。管理者はできるだけ早く問題を直すでしょう。',
    123 => 'ありがとうございます',
    124 => '移動',
    125 => 'カテゴリ',
    126 => '現在位置:',
    'root' => 'ルート'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => '登録されているリンク（クリック数）',
    'stats_headline' => 'リンク(上位10件)',
    'stats_page_title' => 'リンク',
    'stats_hits' => 'ヒット',
    'stats_no_hits' => 'このサイトにはリンクがないか、クリックした人がいないかのどちらかのようです。'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => 'リンクの検索結果',
    'title' => 'タイトル',
    'date' => '追加した日時',
    'author' => '投稿者',
    'hits' => 'クリック数'
);

###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'リンクの登録',
    2 => 'リンク',
    3 => 'カテゴリ',
    4 => 'その他',
    5 => '新しいカテゴリ名',
    6 => 'エラー：カテゴリを選んでください',
    7 => '「その他」を選択する場合には新しいカテゴリ名を記入してください。',
    8 => 'タイトル',
    9 => 'URL',
    10 => 'カテゴリ',
    11 => 'リンクを登録する'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "{$_CONF['site_name']}にリンク登録ありがとうございます。スタッフが内容を確認します。承認されたら<a href={$_CONF['site_url']}/links/index.php>リンク</a>セクションに表示されます。";
$PLG_links_MESSAGE2 = 'リンクは無事登録されました。';
$PLG_links_MESSAGE3 = 'リンクの削除が完了しました。';
$PLG_links_MESSAGE4 = "{$_CONF['site_name']}にリンク登録ありがとうございます。<a href={$_CONF['site_url']}/links/index.php>リンク</a>でご確認ください。";
$PLG_links_MESSAGE5 = 'このカテゴリを見る十分なアクセス権がありません。';
$PLG_links_MESSAGE6 = 'このカテゴリを編集する十分なアクセス権がありません。';
$PLG_links_MESSAGE7 = 'カテゴリの名前と説明を入力して下さい。';
$PLG_links_MESSAGE10 = 'カテゴリの保存に成功しました。';
$PLG_links_MESSAGE11 = 'カテゴリのIDを"site"や"user"とすることは許可されていません。これらの名前は内部的な使用のために予約されています。';
$PLG_links_MESSAGE12 = '親のカテゴリを、カテゴリ自身のサブカテゴリにしようとしました。これはまいごのカテゴリを作成してしまいますので、まず最初に子のカテゴリを移動するか、より高位のカテゴリから親カテゴリを選んで下さい。';
$PLG_links_MESSAGE13 = 'カテゴリの削除に成功しました。';
$PLG_links_MESSAGE14 = 'カテゴリはリンクやはカテゴリを含んでいます。まず、それらを削除して下さい。';
$PLG_links_MESSAGE15 = 'このカテゴリを削除すするのに十分なアクセス権がありません。';
$PLG_links_MESSAGE16 = 'そのようなカテゴリは存在しません。';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'プラグインのアップグレードはサポートされていません。';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

$LANG_LINKS_ADMIN = array(
    1 => 'リンクの編集',
    2 => 'ID',
    3 => 'タイトル',
    4 => 'URL',
    5 => 'カテゴリ',
    6 => '(http://を含む)',
    7 => 'その他',
    8 => 'リンクの参照',
    9 => '説明',
    10 => 'タイトル、URL、説明が必要です',
    11 => 'リンクの管理',
    12 => 'リンクを修正、削除する場合は各リンクの「編集」アイコンをクリックしてください。新規作成は上の「新規」をクリックしてください。',
    14 => 'カテゴリ',
    16 => 'アクセスが拒否されました',
    17 => "権限のないリンクにアクセスしようとしましたのでログに記録しました。<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">リンクの管理画面に戻って</a>ください。",
    20 => 'その他を指定',
    21 => '保存',
    22 => 'キャンセル',
    23 => '削除',
    24 => 'リンクが見つかりません',
    25 => '編集しようと選択されたリンクは見つかりませんでした。',
    26 => 'リンクを検証',
    27 => 'HTMLの状態',
    28 => 'カテゴリを編集',
    29 => '以下の詳細を入力または編集して下さい。',
    30 => 'カテゴリ',
    31 => '説明',
    32 => 'カテゴリID',
    33 => '話題',
    34 => '親',
    35 => 'カテゴリのIDを"site"や"user"とすることは許可されていません。これらの名前は内部的な使用のために予約されています。',
    40 => 'このカテゴリを編集',
    41 => '子のカテゴリを作成',
    42 => 'このカテゴリを削除',
    43 => 'Siteカテゴリ',
    44 => '子を追加',
    46 => 'ユーザ %s が、アクセス権を持たないカテゴリを削除しようとしました。',
    50 => 'カテゴリのリスト',
    51 => '新しいリンク',
    52 => '新しいカテゴリ',
    53 => 'リンクのリスト',
    54 => 'カテゴリ・マネージャ',
    55 => '下のカテゴリを編集して下さい。他のカテゴリやリンクを含んでいるカテゴリは削除できないことに注意して下さい。このようなカテゴリを削除するには、先に含まれているものを削除するか、他のカテゴリに移動する必要があります。',
    56 => 'カテゴリ・エディタ',
    57 => '未検証',
    58 => '今すぐ検証',
    59 => '<p>表示されているすべてのリンクを検証するには、下の「今すぐ検証」のリンクをクリックしてください。リンクの検証には、表示されているリンクの数によって、ある程度の時間が掛かることに注意して下さい。</p>',
    60 => 'ユーザ %s がカテゴリ %s を不正に編集しようとしました。'
);


$LANG_LINKS_STATUS = array(
    100 => 'Continue',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    999 => 'Connection Timed out'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => 'リンク',
    'title' => 'リンクの設定'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => 'リンクにログインが必要?',
    'linksubmission' => 'リンクの申し込みキューを有効?',
    'newlinksinterval' => '新しいリンク作成の間隔',
    'hidenewlinks' => '新しいリンクを隠す?',
    'hidelinksmenu' => 'リンクのメニュー項目を隠す?',
    'linkcols' => '行毎のカテゴリ数',
    'linksperpage' => 'ページ毎のリンクの数',
    'show_top10' => '上位10のリンクを表示?',
    'notification' => '電子メールで通知?',
    'delete_links' => '所有者と共にリンクを削除?',
    'aftersave' => 'リンクの保存後',
    'show_category_descriptions' => 'カテゴリの説明を表示?',
    'root' => 'ルートのカテゴリのID',
    'default_permissions' => 'リンクのデフォルトのパーミッション'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => '主な設定'
);

$LANG_fs['links'] = array(
    'fs_public' => '公開されたリンクのリストの設定',
    'fs_admin' => 'リンクの管理設定',
    'fs_permissions' => 'デフォルトのパーミッション'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => true, 'いいえ' => false),
    9 => array('リンクされたサイトに進む' => 'item', '管理リストを表示' => 'list', '公開されたリストを表示' => 'plugin', 'HOMEページを表示' => 'home', '管理画面を表示' => 'admin'),
    12 => array('アクセス不可' => 0, '書き込み禁止' => 2, '読み書き可能' => 3)
);

?>