<?php

###############################################################################
# japanese_utf-8.php
#
# This is the Japanese UTF-8 language file for the Geeklog Calendar plugin
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

# index.php
$LANG_CAL_1 = array(
    1 => 'イベントカレンダー',
    2 => '-',
    3 => '日時',
    4 => '場所',
    5 => '詳細',
    6 => 'イベントの追加',
    7 => 'これからのイベント',
    8 => '個人カレンダーにこのイベントを追加すると、「個人カレンダー」をユーザー管理メニューから選択することで見ることができます。',
    9 => '個人カレンダーに追加',
    10 => '個人カレンダーから削除',
    11 => 'このイベントを %sの個人カレンダーに追加',
    12 => 'イベント',
    13 => '開始',
    14 => '終了',
    15 => 'カレンダーに戻る',
    16 => 'カレンダー',
    17 => '開始',
    18 => '終了',
    19 => 'イベントの投稿申請',
    20 => 'タイトル',
    21 => '開始',
    22 => 'URL',
    23 => '個人イベント',
    24 => '全体イベント',
    25 => '-',
    26 => 'イベントを投稿する',
    27 => "{$_CONF['site_name']}にイベントを投稿すると、サイト全体のカレンダーに登録します。<br" . XHTML . ">全体カレンダーのイベントは、各ユーザーが必要に応じて個人カレンダーに登録できます。",
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
    40 => 'イベントを登録:',
    41 => '全体カレンダー',
    42 => '個人カレンダー',
    43 => 'リンク',
    44 => 'HTMLタグは使用できません',
    45 => '投稿',
    46 => 'イベント数',
    47 => 'イベント(上位10件)',
    48 => '表示回数',
    49 => 'このサイトにはイベントがないか、誰もイベントをクリックしていないかどちらかのようです。',
    50 => 'イベント',
    51 => '削除',
    'autotag_desc_event' => '[event: id alternate title] - イベントタイトルでイベントへのリンクを表示。アンカーテキストの指定は任意。'
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
    8 => '個人イベント登録',
    9 => '%s イベント',
    10 => 'イベント:',
    11 => '全体カレンダー',
    12 => '個人カレンダー',
    25 => '戻る:',
    26 => '全日',
    27 => '週',
    28 => '個人カレンダー:',
    29 => '全体カレンダー',
    30 => 'イベントを削除',
    31 => '追加',
    32 => 'イベント',
    33 => '日付',
    34 => '時間',
    35 => '簡単追加',
    36 => '投稿',
    37 => 'このサイトでは、個人カレンダーは無効です。',
    38 => '個人イベントの編集',
    39 => '日',
    40 => '週',
    41 => '月',
    42 => '全体イベント投稿',
    43 => 'イベント投稿'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'イベントの編集',
    2 => 'エラー',
    3 => '投稿モード',
    4 => 'URL',
    5 => '開始',
    6 => '終了',
    7 => '場所',
    8 => '詳細',
    9 => '(http://から始めてください)',
    10 => 'イベントの日付・時間、タイトル、詳細を入力してください。',
    11 => 'カレンダー管理',
    12 => 'イベントの編集・削除は編集アイコンをクリック、コピーはコピーアイコンをクリックしてください。イベントの作成は上の「新規作成」をクリックしてください。',
    13 => '投稿者',
    14 => '時間',
    15 => '時間',
    16 => '',
    17 => "管理権限のないイベントを編集しようとしました。このアクセスを記録しました。<a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">イベント編集画面</a>に戻ってください。",
    18 => '',
    19 => '',
    20 => '保存',
    21 => 'キャンセル',
    22 => '削除',
    23 => '開始日時を正しく入力してください。',
    24 => '終了日時を正しく入力してください。',
    25 => '終了日時を正しく入力してください。',
    26 => '古いイベントの削除',
    27 => '以下のリストは ',
    28 => ' ヶ月以上前のイベントです。 これらを削除する場合はゴミ箱アイコンをクリックしてください。または、異なる期間を選択してください:<br' . XHTML . '> ',
    29 => ' ヶ月以上前のイベントを検索します。',
    30 => 'リストの更新',
    31 => '選択したユーザーを本当に削除してもよろしいですか?',
    32 => 'すべてのリスト',
    33 => '削除対象のイベントを選択していません。',
    34 => 'イベント ID',
    35 => '削除できませんでした。',
    36 => '削除したイベント'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'イベントを保存しました。',
    'delete' => 'イベントを削除しました。',
    'private' => 'イベントを個人カレンダーに保存しました。',
    'login' => '個人カレンダーを開くには、最初にログインしてください。',
    'removed' => '個人カレンダーからイベントを削除しました。',
    'noprivate' => 'このサイトでは、個人カレンダーは無効です。',
    'unauth' => 'イベント管理ページにアクセスする権限がありません。すべての許可していない機能へのアクセスは記録していることに注意してください。'
);

$PLG_calendar_MESSAGE4 = "{$_CONF['site_name']}にイベントを投稿していただき、ありがとうございます。イベントはスタッフによる承認待ちとなっています。承認が済むと、このサイトの<a href=\"{$_CONF['site_url']}/calendar/index.php\">カレンダー</a>セクションにイベントを表示します。";
$PLG_calendar_MESSAGE17 = 'イベントを保存しました。';
$PLG_calendar_MESSAGE18 = 'イベントを削除しました。';
$PLG_calendar_MESSAGE24 = 'イベントを個人カレンダーに保存しました。';
$PLG_calendar_MESSAGE26 = 'イベントを削除しました。';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'プラグインはアップグレードをサポートしていません。';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'カレンダー',
    'title' => 'カレンダーの設定'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'ログインを要求する',
    'hidecalendarmenu' => 'メニューに表示しない',
    'personalcalendars' => '個人カレンダーを有効にする',
    'eventsubmission' => 'イベント投稿を管理者が承認する',
    'showupcomingevents' => 'イベント予告を表示する',
    'upcomingeventsrange' => 'イベント予告を表示する期間',
    'event_types' => 'イベントの種類',
    'hour_mode' => '時間制',
    'notification' => 'メールで通知する',
    'delete_event' => '所有者の削除と共に削除する',
    'aftersave' => 'イベント保存後の画面遷移',
    'default_permissions' => 'パーミッション',
    'autotag_permissions_event' => '[event: ] パーミッション',
    'block_enable' => '有効',
    'block_isleft' => '左ブロックで表示する',
    'block_order' => 'ブロックの順番',
    'block_topic_option' => '話題オプション',
    'block_topic' => '話題',
    'block_group_id' => 'グループ',
    'block_permissions' => 'パーミッション'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'メイン'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'カレンダーのメイン設定',
    'tab_permissions' => 'パーミッションのデフォルト',
    'tab_autotag_permissions' => '自動タグのパーミッション',
    'tab_events_block' => 'イベントブロック'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'カレンダーのメイン設定',
    'fs_permissions' => 'カレンダーのパーミッションのデフォルト([0]所有者 [1]グループ [2]メンバー [3]ゲスト)',
    'fs_autotag_permissions' => '自動タグのパーミッション',
    'fs_block_settings' => 'ブロック設定',
    'fs_block_permissions' => 'ブロックのパーミッション'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => true, 'いいえ' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('ページを表示' => 'item', 'リストを表示' => 'list', 'プラグイントップを表示' => 'plugin', 'ホームを表示' => 'home', '管理画面のトップを表示' => 'admin'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
    13 => array('アクセス不可' => 0, '利用する' => 2),
    14 => array('アクセス不可' => 0, '表示' => 2),
    15 => array('すべて' => TOPIC_ALL_OPTION, 'ホームページのみ' => TOPIC_HOMEONLY_OPTION, '話題を選択する' => TOPIC_SELECTED_OPTION)
);

?>
