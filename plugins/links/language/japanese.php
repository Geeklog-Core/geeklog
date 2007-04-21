<?php

###############################################################################
# japanese.php
# This is the Japanese language page for the Geeklog links Plug-in!
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
# $Id: japanese.php,v 1.8 2007/04/21 19:19:23 dhaun Exp $
# Last Update 2007/01/30 by Ivy (Geeklog Japanese)

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
    88 => '-',
    114 => 'リンク',
    116 => 'リンクの追加'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => '登録されているリンク（クリック数）',
    'stats_headline' => 'リンク(上位10件)',
    'stats_page_title' => 'リンク',
    'stats_hits' => 'ヒット',
    'stats_no_hits' => 'このサイトにはリンクがないか，クリックした人がいないかのどちらかのようです。',
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
    11 => 'リンクの登録申請'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "{$_CONF['site_name']}にリンク登録ありがとうございます。スタッフが内容を確認します。承認されたら<a href={$_CONF['site_url']}/links/index.php>リンク</a>セクションに表示されます。";
$PLG_links_MESSAGE2 = 'リンクは無事登録されました。';
$PLG_links_MESSAGE3 = 'リンクの削除が完了しました。';
$PLG_links_MESSAGE4 = "{$_CONF['site_name']}にリンク登録ありがとうございます。<a href={$_CONF['site_url']}/links/index.php>リンク</a>でご確認ください。";

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
    10 => 'タイトル，URL，説明が必要です',
    11 => 'リンクの管理',
    12 => 'リンクを修正，削除する場合は各リンクの「編集」アイコンをクリックしてください。新規作成は上の「新規」をクリックしてください。',
    14 => 'カテゴリ',
    16 => 'アクセスが拒否されました',
    17 => "権限のないリンクにアクセスしようとしましたのでログに記録しました。<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">リンクの管理画面に戻って</a>ください。",
    20 => 'その他を指定',
    21 => '保存',
    22 => 'キャンセル',
    23 => '削除'
);

?>