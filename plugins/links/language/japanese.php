<?php

###############################################################################
# english.php
# This is the english language page for the Geeklog links Plug-in!
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
# $Id: japanese.php,v 1.1 2005/11/19 13:23:25 dhaun Exp $

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_LINKS= array(
    1 => '投稿者:',
    2 => '続きを読む',
    3 => 'コメント',
    4 => '編集',
    5 => '投票',
    6 => '結果',
    7 => '投票結果',
    8 => '投票',
    9 => '管理者機能:',
    10 => '投稿',
    11 => '記事',
    12 => 'ブロック',
    13 => 'トピック',
    14 => 'リンク',
    15 => 'イベント',
    16 => '投票',
    17 => 'ユーザ',
    18 => 'SQL Query',
    19 => 'ログアウト',
    20 => 'ユーザーの情報：',
    21 => 'ユーザー名',
    22 => 'ユーザーID',
    23 => 'Security Level',
    24 => '匿名',
    25 => '返事',
    26 => 'コメントはコメントの投稿者の責任によるものです。本サイトはコメントの内容には責任を持ちません。',
    27 => '最近の登録',
    28 => '削除',
    29 => 'コメントはありません',
    30 => '過去の記事',
    31 => '許可しているHTMLタグ：',
    32 => 'エラー：無効なユーザー名です',
    33 => 'エラー：ログファイルに書き込めません',
    34 => 'エラー',
    35 => 'ログアウト',
    36 => 'on',
    37 => '記事がありません',
    38 => 'Content Syndication',
    39 => '更新',
    40 => '<tt>php.ini</tt>の設定が<tt>register_globals = Off</tt>になっています。Geeklogでは、<tt>register_globals</tt>が<strong>on</strong>になっている必要があります。続行するためには、register_globalsを<strong>on</strong>にして、Webサーバーを再起動してください。',
    41 => 'Guest Users',
    42 => '投稿者：',
    43 => 'コメントを書く',
    44 => '元の記事',
    45 => 'MySQL Error Number',
    46 => 'MySQL Error Message',
    47 => 'User Functions',
    48 => 'アカウントの情報',
    49 => '設定',
    50 => 'Error with SQL statement',
    51 => 'ヘルプ',
    52 => 'New',
    53 => '管理画面',
    54 => 'ファイルを開けませんでした。',
    55 => '次の場所でエラー：',
    56 => '投票',
    57 => 'Password',
    58 => 'ログイン',
    59 => "アカウントを持っていない場合には、ユーザー登録を<a href=\"{$_CONF['site_url']}/users.php?mode=new\">こちらから</a>どうぞ。",
    60 => 'コメントを投稿する',
    61 => 'アカウントを作成する',
    62 => '段落（程度）',
    63 => 'コメントの設定',
    64 => '友達にメールで知らせる',
    65 => '印刷用ページを表示',
    66 => 'カレンダー',
    67 => 'ようこそ。',
    68 => 'ホーム',
    69 => 'Contact',
    70 => '検索',
    71 => 'Contribute',
    72 => 'Training Provider Directory',
    73 => 'Past Polls',
    74 => 'Training Calendar',
    75 => 'Advanced Search',
    76 => 'Site Statistics',
    77 => 'Plugins',
    78 => 'Upcoming Training Events',
    79 => 'What\'s New',
    80 => 'articles in last',
    81 => 'article in last',
    82 => 'hours',
    83 => 'COMMENTS',
    84 => 'TRAINING PROVIDER DIRECTORY',
    85 => 'last 48 hrs',
    86 => 'No new comments',
    87 => 'last 2 wks',
    88 => 'No recent new providers',
    89 => 'There are no upcoming training events',
    90 => 'Home',
    91 => 'Created this page in',
    92 => 'seconds',
    93 => 'Copyright',
    94 => 'All trademarks and copyrights on this page are owned by their respective owners.',
    95 => 'Powered By',
    96 => 'Groups',
    97 => 'Word List',
    98 => 'Plug-ins',
    99 => 'ARTICLES',
    100 => 'No new articles',
    101 => 'Your Events',
    102 => 'Site Events',
    103 => 'DB Backups',
    104 => 'by',
    105 => 'Mail Users',
    106 => 'Views',
    107 => 'GL Version Test',
    108 => 'Clear Cache',
    109 => 'Report abuse',
    110 => 'Report this post to the site admin',
    111 => 'View PDF Version',
    112 => 'Registered Users',
    113 => 'Documentation',
    114 => 'リンク',
    115 => 'There are no resources to display.',
    116 => 'リンクの追加'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => '登録されているリンク（クリック数）',
    'stats_headline' => 'リンク(上位10件)',
    'stats_page_title' => 'リンク',
    'stats_hits' => 'ヒット',
    'stats_no_hits' => 'このサイトにはリンクが一つもないか、クリックした人がいないかのどちらかのようです。',
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
    5 => '特記事項',
    6 => 'エラー：カテゴリを選んでください',
    7 => '「その他」を選択する場合には新しいカテゴリ名を記入してください。',
    8 => 'タイトル',
    9 => 'URL',
    10 => 'カテゴリ',
    11 => 'リンクを登録する'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "{$_CONF['site_name']}にリンクを登録してくれてありがとう。スタッフが内容を確認して受け入れるかどうか判断いたします。受け入れられた場合、<a href={$_CONF['site_url']}/links.php>リンク</a>セクションにリンクが表示されます。";
$PLG_links_MESSAGE2 = 'リンクは無事登録されました。';
$PLG_links_MESSAGE3 = 'リンクの削除が完了しました。';
$PLG_links_MESSAGE4 = "{$_CONF['site_name']}にリンクを登録してくれてありがとうございます。リンクは<a href={$_CONF['site_url']}/links.php>links</a>で確認できます。";

###############################################################################
# admin/link.php

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
    13 => 'タイトル',
    14 => 'カテゴリ',
    15 => 'URL',
    16 => 'アクセスが拒否されました',
    17 => "権限のないリンクにアクセスしようとしましたのでログに記録しました。<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">リンクの管理画面に戻って</a>ください。",
    18 => '新規',
    19 => '管理画面',
    20 => 'その他を指定',
    21 => '保存',
    22 => 'キャンセル',
    23 => '削除',
    24 => '編集',
    25 => '絞込み検索',
    26 => '送信',
    27 => '検索'
);

?>
