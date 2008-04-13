<?php

###############################################################################
# japanese_utf-8.php
# This is the Japanese UTF-8 language page for the Geeklog Calendar Plug-in!
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
# Last Update 2007/02/19 by Ivy (Geeklog Japanese)

global $LANG32;

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'イベントカレンダ',
    2 => '-',
    3 => '日時',
    4 => '場所',
    5 => '詳細',
    6 => 'イベントの追加',
    7 => 'これからのイベント',
    8 => '個人カレンダにこのイベントを追加すると，「個人カレンダ」をユーザ管理メニューから選択することで見ることができます。',
    9 => '個人カレンダに追加',
    10 => '個人カレンダから削除',
    11 => "このイベントを %sの個人カレンダに追加",
    12 => 'イベント',
    13 => '開始',
    14 => '終了',
    15 => 'カレンダに戻る',
    16 => 'カレンダ',
    17 => '開始',
    18 => '終了',
    19 => 'イベントの登録申請',
    20 => 'タイトル',
    21 => '開始',
    22 => 'URL',
    23 => '個人のイベント',
    24 => 'サイトのイベント',
    25 => '-',
    26 => 'イベントを投稿',
    27 => "{$_CONF['site_name']}にイベントを投稿すると，サイト全体のカレンダに登録されます。<br>全体カレンダのイベントは，各ユーザが必要に応じて個人カレンダに登録できます。",
    28 => 'タイトル',
    29 => '日時',
    30 => '日時',
    31 => '全日',
    32 => '住所1',
    33 => '住所2',
    34 => '市町村名',
    35 => '都道府県',
    36 => '郵便番号',
    37 => '種類',
    38 => 'イベントの種類を編集',
    39 => '場所',
    40 => 'イベントを追加：',
    41 => '全体カレンダ',
    42 => '個人カレンダ',
    43 => 'リンク',
    44 => 'HTMLタグは使用できません',
    45 => '投稿',
    46 => 'システムのイベント',
    47 => 'イベント上位10件',
    48 => '閲覧数',
    49 => 'このサイトにはイベントがないか，誰もイベントをクリックしていないかどちらかのようです。',
    50 => 'イベント',
    51 => '削除'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'イベント情報の検索結果',
    'title' => 'タイトル',
    'date_time' => '日時',
    'location' => '場所',
    'description' => '詳細'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '個人のイベントを追加',
    9 => '%s イベント',
    10 => 'イベント：',
    11 => '全体カレンダ',
    12 => '個人カレンダ',
    25 => '戻る：',
    26 => '全日',
    27 => '週',
    28 => '個人カレンダ：',
    29 => '全体カレンダ',
    30 => 'イベントを削除',
    31 => '追加',
    32 => 'イベント',
    33 => '日付',
    34 => '時間',
    35 => '簡単追加',
    36 => '投稿',
    37 => 'このサイトでは，個人カレンダを有効にしていません。',
    38 => '個人イベントエディタ',
    39 => '日',
    40 => '週',
    41 => '月',
    42 => '全体イベントを追加',
    43 => 'イベント投稿',
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'イベントエディタ',
    2 => 'エラー',
    3 => '投稿モード',
    4 => 'URL',
    5 => '開始',
    6 => '終了',
    7 => '場所',
    8 => '詳細',
    9 => '(http://から始めてください)',
    10 => 'イベントの日付・時間，タイトル，詳細を入力してください。',
    11 => 'カレンダ管理',
    12 => 'イベントの編集・削除は，下のイベントの編集アイコンをクリックしてください。新しいイベントを作る場合，上の「新規イベント」をクリックしてください。コピーを作る場合は既存イベントのコピーアイコンをクリックしてください。',
    13 => '投稿者',
    14 => '時間',
    15 => '時間',
    16 => '',
    17 => "管理権限のないイベントを編集しようとしました。この行為は記録されました。<a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">イベント編集画面</a>に戻ってください。",
    18 => '',
    19 => '',
    20 => '保存',
    21 => 'キャンセル',
    22 => '削除',
    23 => '開始日時をただしく入力してください。',
    24 => '終了日時をただしく入力してください。',
    25 => '終了日時をただしく入力してください。',
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
    'save'      => 'イベントが保存されました。',
    'delete'    => 'イベントが削除されました。',
    'private'   => 'イベントが個人カレンダに保存されました。',
    'login'     => '個人カレンダを開くには，最初にログインしてください。',
    'removed'   => '個人カレンダからイベントが削除されました。',
    'noprivate' => '申し訳ありませんが，このサイトでは，個人カレンダが無効です。',
    'unauth'    => '申し訳ありませんが，イベント管理ページにアクセスする権限がありません。このアクセスは記録させていただきましたのでご了承ください。',
);

$PLG_calendar_MESSAGE4  = "{$_CONF['site_name']}にイベントを投稿していただき，ありがとうございます。スタッフに送信され，承認待ちの状態になりました。承認された場合，このサイトの<a href=\"{$_CONF['site_url']}/calendar/index.php\">カレンダ</a>セクションに表示されます。";
$PLG_calendar_MESSAGE17 = 'イベントが保存されました。';
$PLG_calendar_MESSAGE18 = 'イベントが削除されました。';
$PLG_calendar_MESSAGE24 = 'イベントが個人カレンダに保存されました。';
$PLG_calendar_MESSAGE26 = 'イベントが削除されました。';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

?>
