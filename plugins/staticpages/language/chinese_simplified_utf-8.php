<?php

###############################################################################
# chinese_simplified_utf-8.php
# This is the Chinese Simplified Unicode (utf-8) language set
# for the Geeklog Static Page Plug-in!
#
# Last updated January 10, 2006
#
# Copyright (C) 2005 Samuel M. Stone
# sam@stonemicro.com
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
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_STATIC= array(
    'newpage' => '新页',
    'adminhome' => '管理处',
    'staticpages' => '静态页',
    'staticpageeditor' => '静态页编辑器',
    'writtenby' => '作者',
    'date' => '更新日期',
    'title' => '标题',
    'content' => '内容',
    'hits' => '采样数',
    'staticpagelist' => '静态页目录',
    'url' => '网址',
    'edit' => '编辑',
    'lastupdated' => '更新日期',
    'pageformat' => '网页各式',
    'leftrightblocks' => '左右组件',
    'blankpage' => '空页',
    'noblocks' => '无组件',
    'leftblocks' => '左组件',
    'addtomenu' => '加入菜单',
    'label' => '标签',
    'nopages' => '此系统无静态页',
    'save' => '存续',
    'preview' => '预览',
    'delete' => '删除',
    'cancel' => '取消',
    'access_denied' => '拒绝入门',
    'access_denied_msg' => '你在非法进入静态页管理处. 请注意，你企图非法的进入此页的资料会被记录下来',
    'all_html_allowed' => '所有 HTML 代号读可用',
    'results' => '静态页结果',
    'author' => '作者',
    'no_title_or_content' => '你最少要填入<b>标题</b> 和 <b>内容</b>.',
    'no_such_page_anon' => '请登入..',
    'no_page_access_msg' => "这也许是你未登入, 或不是此站的用户. 请 <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> 申请成为用户 </a> 来得到登入权",
    'php_msg' => 'PHP: ',
    'php_warn' => '注意: 你的静态页上的 PHP 代号将会被评价. 请小心 !!',
    'exit_msg' => 'Exit 类型: ',
    'exit_info' => '启动 需要登入 的通知.  不勾此框便即用正常安全检查.',
    'deny_msg' => '拒绝进入此页.  也许此页也被搬移，删除，或你无足够许可进入此页.',
    'stats_headline' => '头十个静态页',
    'stats_page_title' => '网页标题',
    'stats_hits' => '采样数',
    'stats_no_hits' => '看来此站没有静态页或无人曾看过任何静态页.',
    'id' => 'ID',
    'duplicate_id' => '你选的 ID 已经被用，请选另一个.',
    'instructions' => '若要更改或删除一个静态页，在它旁边的编辑图上点击。若要看一个静态页，在它的标题上点击。若要建立一个新的静态页，在以上的‘建新’上点距。若要复制一个静态页，再它旁边的复制图上点击。',
    'centerblock' => '中组件: ',
    'centerblock_msg' => '若勾此匡，此静态页便会显为‘中组件’，就是变成网页中间的框框。',
    'topic' => '主题: ',
    'position' => '位置: ',
    'all_topics' => '所有',
    'no_topic' => '只显在主页',
    'position_top' => '顶部',
    'position_feat' => '在重要文章下面',
    'position_bottom' => '底部',
    'position_entire' => '整页',
    'head_centerblock' => '中组件',
    'centerblock_no' => '不',
    'centerblock_top' => '顶',
    'centerblock_feat' => '重要文章',
    'centerblock_bottom' => '底',
    'centerblock_entire' => '整页',
    'inblock_msg' => '在一个组件内: ',
    'inblock_info' => '将静态页包在组件框里.',
    'title_edit' => '编辑此页',
    'title_copy' => '复制此页',
    'title_display' => '显示此页',
    'select_php_none' => '不要执行PHP',
    'select_php_return' => '执行 PHP (return)',
    'select_php_free' => '执行 PHP',
    'php_not_activated' => '使用 PHP 的功能为开启.',
    'printable_format' => '打印格式',
    'edit' => '编辑',
    'copy' => '复制',
    'limit_results' => '限制结果',
    'search' => '搜寻',
    'submit' => '提交'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>
