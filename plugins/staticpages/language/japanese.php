<?php

###############################################################################
# lang.php
# This is the english language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Tranlated by SaY
# sakata@ecofirm.com
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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_STATIC= array(
    newpage => '新規ページ',
    adminhome => '管理ページ',
    staticpages => '静的（固定）ページ',
    staticpageeditor => '静的ページの編集',
    writtenby => '著者：',
    date => '最終更新日：',
    title => 'タイトル',
    content => '内容',
    hits => '件の閲覧',
    staticpagelist => '静的ページ一覧',
    url => 'URL',
    edit => '編集',
    lastupdated => '最終更新日：',
    pageformat => 'ページフォーマット',
    leftrightblocks => '左右のブロック付き',
    blankpage => '空白ページ',
    noblocks => 'ブロックなし',
    leftblocks => '左側ブロックのみ',
    addtomenu => 'メニューに追加する',
    label => 'ラベル',
    nopages => '静的ページがシステムにありません',
    save => '保存',
    preview => 'プレビュー',
    delete => '削除',
    cancel => 'キャンセル',
    access_denied => 'アクセスが拒否されました',
    access_denied_msg => '静的ページの管理ページに権限なしでアクセスしようとしました。権限のないアクセスはすべて記録されますのでご注意ください。',
    all_html_allowed => 'すべてのHTMLが利用できます。',
    results => 'Static Pages Results',
    author => '著者：',
    no_title_or_content => '少なくとも、<b>タイトル</b>と<b>内容</b>は記入してください。',
    no_such_page_logged_in => $_USER['username'].'さん、ごめんなさい',
    no_such_page_anon => 'まずログインしてください。',
    no_page_access_msg => "この問題は、まだログインしていないか、そもそもこのサイト（{$_CONF["site_name"]}）のメンバーではないためだと考えられます。{$_CONF["site_name"]}に<a href=\"{$_CONF['site_url']}/users.php?mode=new\"> メンバー登録</a>するか、適切なアクセス権を管理者から取得してください。",
    php_msg => 'PHP: ',
    php_warn => '注意：このオプションを有効にすると、あなたのページに含まれるPHPコードが実行されます。利用には最新の注意を払ってください。',
    exit_msg => 'Exit Type: ',
    exit_info => '「要ログイン」：チェックをしない場合には通常のセキュリティチェックが適用され、メッセージが表示されます。',
    deny_msg => 'ページへのアクセスは拒否されました。ページが移動または削除されたか、権限がないかのいずれかです。',
    stats_headline => '静的ページ（上位１０）',
    stats_page_title => 'タイトル',
    stats_hits => '件の閲覧',
    stats_no_hits => '静的ページがないか、閲覧者がいないかのどちらかです。',
    id => 'ID（ページ名）',
    duplicate_id => '指定したIDはすでに使われています。別のIDをご使用ください。',
    instructions => 'ページを編集・削除するためには、以下のページ番号をクリックしてください。ページを閲覧する場合は、タイトルをクリックしてください。新しいページを作成する場合には、「新規」ボタンを押してください。[C]を押すと、既存のページのコピーを作成できます。',
    centerblock => 'センターブロック: ',
    centerblock_msg => 'チェックすると、トップページの中心部分に表示されます。',
    topic => '話題: ',
    position => '市: ',
    all_topics => 'すべて',
    no_topic => 'ホームページのみ',
    position_top => 'ページの最上部',
    position_feat => '注目記事の下',
    position_bottom => 'ページの下',
    position_entire => 'ページ全体',
    head_centerblock => 'センターブロック',
    centerblock_no => 'いいえ',
    centerblock_top => '上部',
    centerblock_feat => '注目記事',
    centerblock_bottom => '下部',
    centerblock_entire => 'ページ全体'
);

?>
