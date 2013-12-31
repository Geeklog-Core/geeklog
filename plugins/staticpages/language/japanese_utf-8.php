<?php

###############################################################################
# japanese_utf-8.php
# This is the Japanese language file for the Geeklog Static Page plugin!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
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

$LANG_STATIC = array(
    'newpage' => '新規ページ',
    'adminhome' => '管理画面',
    'staticpages' => '静的ページ',
    'staticpageeditor' => '静的ページの編集',
    'writtenby' => '所有者',
    'date' => '最終更新日',
    'title' => 'タイトル',
    'page_title' => 'ページタイトル',
    'content' => 'コンテンツ',
    'hits' => '表示回数',
    'staticpagelist' => '静的ページ管理',
    'url' => 'URL',
    'edit' => '編集',
    'lastupdated' => '最終更新日:',
    'pageformat' => 'レイアウト',
    'leftrightblocks' => 'ヘッダー・フッター・左右ブロックあり',
    'blankpage' => '全画面表示(ヘッダー・フッター・ブロックなし)',
    'noblocks' => 'ヘッダー・フッターあり(ブロックなし)',
    'leftblocks' => 'ヘッダー・フッター・左ブロックあり(右ブロックなし)',
    'addtomenu' => 'ヘッダーメニュー',
    'label' => 'メニュー名',
    'nopages' => '静的ページがありません',
    'save' => '保存',
    'preview' => 'プレビュー',
    'delete' => '削除',
    'cancel' => 'キャンセル',
    'access_denied' => '先にログインしてください。',
    'access_denied_msg' => 'チェックするとアクセス権がない場合に画面が自動的に遷移してログイン画面を表示します。チェックをしない場合には「権限がない」というメッセージを表示します。',
    'all_html_allowed' => 'すべてのHTMLが利用できます。',
    'results' => '静的ページ検索結果',
    'author' => '所有者',
    'no_title_or_content' => 'タイトルとコンテンツを入力し、話題を少なくとも1つ選択してください。',
    'no_such_page_anon' => 'ログインしてください。',
    'no_page_access_msg' => "この問題は、まだログインしていないか、そもそもこのサイト({$_CONF['site_name']})のメンバーではないためだと考えられます。{$_CONF['site_name']}に<a href=\"{$_CONF['site_url']}/users.php?mode=new\"> メンバー登録</a>するか、適切なアクセス権を管理者から取得してください。",
    'php_msg' => 'PHP: ',
    'php_warn' => '<br' . XHTML . '>注意: このオプションを有効にすると、あなたのページが含んでいるPHPコードを実行します。静的ページPHPを利用する場合には、あらかじめ管理画面「グループ:Static Page Admin」で、権限「staticpages.PHP」にチェックしてください。PHPを使う場合、通常(return)なしの「PHPを実行する」モードで利用します。利用には細心の注意を払ってください。',
    'exit_msg' => 'ログイン要求: ',
    'exit_info' => 'チェックすると表示する権限がない場合にログイン要求画面を表示します。<br' . XHTML . '> チェックをしない場合には「権限がない」というメッセージを表示します。',
    'deny_msg' => 'このページにアクセスできません。ページを移動や削除しているか、アクセス権がありません。',
    'stats_headline' => '静的ページ(上位10件)',
    'stats_page_title' => 'タイトル',
    'stats_hits' => '表示回数',
    'stats_no_hits' => 'サイトに静的ページがないか、静的ページを表示した人がいません。',
    'id' => 'ID',
    'duplicate_id' => '指定したIDは既に使われています。別のIDをご使用ください。',
    'instructions' => '静的ページの編集・削除は編集アイコンをクリック、静的ページのコピーはコピーアイコンをクリックしてください。静的ページの作成は上の「新規作成」をクリックしてください。',
    'centerblock' => 'センターエリア: ',
    'centerblock_msg' => 'チェックすると、トップページまたは話題のトップページのセンターエリアに表示します。',
    'topic' => '話題: ',
    'position' => '表示エリア: ',
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
    'inblock_info' => 'タイトルを表示して、コンテンツをブロックで囲みます。',
    'title_edit' => '編集',
    'title_copy' => 'コピーを作成',
    'title_display' => 'ページを表示する',
    'select_php_none' => 'PHPを実行しない',
    'select_php_return' => 'PHPを実行する (return)',
    'select_php_free' => 'PHPを実行する',
    'php_not_activated' => "静的ページでPHPは使用しない設定になっています。詳細については <a href=\"{$_CONF['site_url']}/docs/japanese/staticpages.html#php\">関連ドキュメント</a> を参照してください。",
    'printable_format' => '印刷用フォーマット',
    'copy' => 'コピー',
    'limit_results' => '絞込検索',
    'search' => '検索',
    'submit' => '登録',
    'no_new_pages' => '-',
    'pages' => 'ページ',
    'comments' => 'コメント',
    'template' => 'テンプレート',
    'use_template' => '選択',
    'template_msg' => 'チェックした場合、静的ページをテンプレートとしてします。',
    'none' => 'なし',
    'use_template_msg' => 'この静的ページがテンプレートでなければ、テンプレートを選んで利用できます。利用する場合は、このページのコンテンツをXML形式で記述しなければならないので注意してください。',
    'draft' => 'ドラフト',
    'draft_yes' => '○',
    'draft_no' => '-',
    'cache_time' => 'キャッシュタイム',
    'cache_time_desc' => 'この静的ページコンテンツはここで指定された秒数以上にキャッシュされることはありません。もしキャッシュが0ならキャッシュ無効 (3600 = 1時間,  86400 = 1日)。静的ページPHPまたはテンプレートの場合はキャッシュされません。',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - 静的ページタイトルで静的ページへのリンクを表示。アンカーテキストの指定は任意です。',
    'autotag_desc_staticpage_content' => '[staticpage_content: id] - 静的ページのコンテンツを表示します。'
);

$PLG_staticpages_MESSAGE15 = 'あなたのコメントは投稿スタッフによる承認待ちとなっていて、承認が済むとサイトに表示します。';
$PLG_staticpages_MESSAGE19 = '静的ページを保存しました。';
$PLG_staticpages_MESSAGE20 = '静的ページを削除しました。';
$PLG_staticpages_MESSAGE21 = 'このページはまだ存在しません。ページを作成するには、下のフォームにすべてを入力してください。何かの間違いでしたらキャンセルボタンをクリックしてください。';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'プラグインはアップグレードをサポートしていません。';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => '静的ページ',
    'title' => '静的ページの設定'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'PHPを許可する',
    'sort_by' => 'センターブロックの並べ替え',
    'sort_menu_by' => 'メニューの並べ替え',
    'sort_list_by' => '管理者ページの並べ替え',
    'delete_pages' => '所有者の削除と共に削除する',
    'in_block' => 'ページをブロックで囲む',
    'show_hits' => '表示回数を表示する',
    'show_date' => '日時を表示する',
    'filter_html' => 'HTMLフィルターを適用する',
    'censor' => 'コンテンツを検閲する',
    'default_permissions' => 'パーミッション',
    'autotag_permissions_staticpage' => '[staticpage: ] パーミッション',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] パーミッション',
    'aftersave' => 'ページ保存後の画面遷移',
    'atom_max_items' => 'フィードに書き出す最大ページ数',
    'meta_tags' => 'メタタグを有効にする',
    'comment_code' => '新規作成時のデフォルト',
    'draft_flag' => 'ドラフトモードをデフォルトにする',
    'disable_breadcrumbs_staticpages' => 'パンくずリストを無効にする',
    'default_cache_time' => 'デフォルトキャッシュタイム',
    'newstaticpagesinterval' => '静的ページの"新着"期間',
    'hidenewstaticpages' => '新着ブロック表示',
    'title_trim_length' => 'タイトル最大長',
    'includecenterblocks' => 'センターブロックの静的ページを含む',
    'includephp' => 'PHPモードの静的ページを含む',
    'includesearch' => '静的ページを検索する',
    'includesearchcenterblocks' => 'センターブロックの静的ページを含む',
    'includesearchphp' => '静的ページPHPを含む'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'メイン'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => '静的ページのメイン設定',
    'tab_whatsnew' => '新着情報ブロック',
    'tab_search' => '検索',
    'tab_permissions' => 'パーミッションのデフォルト',
    'tab_autotag_permissions' => '自動タグのパーミッション'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => '静的ページのメイン設定',
    'fs_whatsnew' => '新着情報ブロック',
    'fs_search' => '検索結果',
    'fs_permissions' => '静的ページのパーミッションのデフォルト([0]所有者 [1]グループ [2]メンバー [3]ゲスト)',
    'fs_autotag_permissions' => '自動タグのパーミッション([0]所有者 [1]グループ [2]メンバー [3]ゲスト)'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('はい' => 1, 'いいえ' => 0),
    1 => array('はい' => true, 'いいえ' => false),
    2 => array('日付' => 'date', 'ページID' => 'id', 'タイトル' => 'title'),
    3 => array('日付' => 'date', 'ページID' => 'id', 'タイトル' => 'title', 'ラベル' => 'label'),
    4 => array('日付' => 'date', 'ページID' => 'id', 'タイトル' => 'title', '所有者' => 'author'),
    5 => array('表示しない' => 'hide', '編集日付によって表示する' => 'modified', '作成日付によって表示する' => 'created'),
    9 => array('ページを表示' => 'item', 'リストを表示' => 'list', 'ホームを表示' => 'home', '管理画面のトップを表示' => 'admin'),
    12 => array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3),
    13 => array('アクセス不可' => 0, '利用する' => 2),
    17 => array('コメント有効' => 0, 'コメント無効' => -1)
);

?>
