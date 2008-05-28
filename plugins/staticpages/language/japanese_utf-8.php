<?php

###############################################################################
# japanese_utf-8.php
# This is the Japanese language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
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

$LANG_STATIC = array(
    'newpage' => '新規ページ',
    'adminhome' => '管理画面',
    'staticpages' => '静的ページ',
    'staticpageeditor' => '静的ページの編集',
    'writtenby' => '所有者',
    'date' => '最終更新日',
    'title' => 'タイトル',
    'content' => '内容',
    'hits' => '閲覧件数',
    'staticpagelist' => '静的ページ管理',
    'url' => 'URL',
    'edit' => '編集',
    'lastupdated' => '最終更新日：',
    'pageformat' => 'ページレイアウト',
    'leftrightblocks' => 'ヘッダ・フッタ・左右ブロックあり',
    'blankpage' => '全画面表示（ヘッダ・フッタ・ブロックなし）',
    'noblocks' => 'ヘッダ・フッタあり（ブロックなし）',
    'leftblocks' => 'ヘッダ・フッタ・左側ブロックあり（右側ブロックなし）',
    'addtomenu' => 'ヘッダメニューに追加',
    'label' => 'メニュー名',
    'nopages' => '静的ページがありません',
    'save' => '保存',
    'preview' => 'プレビュー',
    'delete' => '削除',
    'cancel' => 'キャンセル',
    'access_denied' => '申し訳ありませんが，先にログインしてください。',
    'access_denied_msg' => 'チェックするとアクセス権限がない場合に画面が自動的に遷移してログイン画面が表示されます。チェックをしない場合には「権限がない」というメッセージが表示されます。',
    'all_html_allowed' => 'すべてのHTMLが利用できます。',
    'results' => '静的ページ検索結果',
    'author' => '所有者',
    'no_title_or_content' => '<b>タイトル</b>と<b>内容</b>を記入してください。',
    'no_such_page_anon' => 'ログインしてください。',
    'no_page_access_msg' => "この問題は，まだログインしていないか，そもそもこのサイト（{$_CONF['site_name']}）のメンバーではないためだと考えられます。{$_CONF['site_name']}に<a href=\"{$_CONF['site_url']}/users.php?mode=new\"> メンバー登録</a>するか，適切なアクセス権を管理者から取得してください。",
    'php_msg' => 'PHP: ',
    'php_warn' => '<br' . XHTML . '>注意：このオプションを有効にすると，あなたのページに含まれるPHPコードが実行されます。静的ページPHPを利用する場合には，あらかじめ管理画面「グループ:Static Page Admin」で，権限「staticpages.PHP」にチェックしてください。PHPを使う場合，通常(return)なしの「PHPを実行する」モードで利用します。利用には細心の注意を払ってください。',
    'exit_msg' => '閲覧権限がない場合: ',
    'exit_info' => 'チェックすると，閲覧権限がない場合にログイン要求画面が表示されます。<br' . XHTML . '>　　　チェックをしない場合には「権限がない」というメッセージが表示されます。',
    'deny_msg' => 'ページへのアクセスは拒否されました。ページが移動または削除されたか，権限がないかのいずれかです。',
    'stats_headline' => '静的ページ（上位10件）',
    'stats_page_title' => 'タイトル',
    'stats_hits' => '閲覧数',
    'stats_no_hits' => '静的ページがないか，閲覧者がいないかのどちらかです。',
    'id' => 'ID',
    'duplicate_id' => '指定したIDはすでに使われています。別のIDをご使用ください。',
    'instructions' => 'ページを編集・削除は，各ページの先頭の編集アイコンをクリック。ページの閲覧は，タイトルをクリック。新しいページを作成する場合は「新規作成」リンクをクリック。ページのコピーは[C]をクリックしてください。',
    'centerblock' => 'センターエリア表示: ',
    'centerblock_msg' => 'チェックすると，トップページまたは話題のトップページのセンターエリアに表示されます。表示はIDでソートされます。',
    'topic' => '話題: ',
    'position' => '表示場所: ',
    'all_topics' => 'すべて',
    'no_topic' => 'ホームページのみ',
    'position_top' => 'ページの最上部',
    'position_feat' => '注目記事の下',
    'position_bottom' => 'ページの下',
    'position_entire' => 'ページ全体',
    'head_centerblock' => 'トップ表示',
    'centerblock_no' => 'いいえ',
    'centerblock_top' => '上部',
    'centerblock_feat' => '注目記事',
    'centerblock_bottom' => '下部',
    'centerblock_entire' => 'ページ全体',
    'inblock_msg' => 'ブロックで囲む: ',
    'inblock_info' => 'チェックすると，タイトルが表示され，コンテンツがブロックで囲まれます。',
    'title_edit' => '編集',
    'title_copy' => 'コピーを作成',
    'title_display' => 'ページを表示する',
    'select_php_none' => 'PHPを実行しない',
    'select_php_return' => 'PHPを実行する (return)',
    'select_php_free' => 'PHPを実行する',
    'php_not_activated' => "静的ページでPHPは使用しない設定になっています。詳細については <a href=\"{$_CONF['site_url']}/docs/staticpages.html#php\">関連ドキュメント</a> をご覧下さい。",
    'printable_format' => '印刷用フォーマット',
    'copy' => 'コピー',
    'limit_results' => '絞込検索',
    'search' => '検索',
    'submit' => '登録'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'プラグインのアップグレードはサポートされていません。';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => '静的ページ',
    'title' => '静的ページの設定'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'PHPを許可?',
    'sort_by' => '中央ブロックのソート',
    'sort_menu_by' => 'メニュー項目のソート',
    'delete_pages' => '所有者と共にページを削除?',
    'in_block' => 'ブロック中のページをくるむ?',
    'show_hits' => 'ヒット数を表示?',
    'show_date' => '日付を表示?',
    'filter_html' => 'HTMLをフィルタ?',
    'censor' => '内容を検閲?',
    'default_permissions' => 'ページのデフォルトのパーミッション',
    'aftersave' => 'ページの保存後',
    'atom_max_items' => 'Webサービスのフィードの最大ページ数'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => '主な設定'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => '静的ページの主な設定',
    'fs_permissions' => 'デフォルトのパーミッション'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => true, 'いいえ' => false),
    2 => array('日付' => 'date', 'ページID' => 'id', 'タイトル' => 'title'),
    3 => array('日付' => 'date', 'ページID' => 'id', 'タイトル' => 'title', 'ラベル' => 'label'),
      9 => array('ページに進む' => 'item', 'リストを表示' => 'list', 'HOMEページを表示' => 'home', '管理画面を表示' => 'admin'),
    12 => array('アクセス不可' => 0, '書き込み禁止' => 2, '読み書き可能' => 3)
);

?>