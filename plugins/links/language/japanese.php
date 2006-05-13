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
# $Id: japanese.php,v 1.5 2006/05/13 17:13:08 dhaun Exp $

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

$LANG_LINKS= array(
    10 => '投稿',
    14 => 'リンク',
    84 => 'リンク',
    88 => '新しいリンクはありません',
    114 => 'リンク集',
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

// Messages for the plugin upgrade
$PLG_links_MESSAGE3002 = $LANG32[9];

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
    14 => 'カテゴリ',
    16 => 'アクセスが拒否されました',
    17 => "権限のないリンクにアクセスしようとしましたのでログに記録しました。<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">リンクの管理画面に戻って</a>ください。",
    20 => 'その他を指定',
    21 => '保存',
    22 => 'キャンセル',
    23 => '削除'
);

?>
