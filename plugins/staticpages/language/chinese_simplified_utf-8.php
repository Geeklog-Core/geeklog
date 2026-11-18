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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => '新页',
    'adminhome' => '管理处',
    'staticpages' => '静态页',
    'staticpageeditor' => '静态页编辑器',
    'writtenby' => '作者',
    'date' => '更新日期',
    'title' => '标题',
    'page_title' => '页面标题',
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
    'title_error_saving' => '保存页面时出错',
    'template_xml_error' => 'XML 标记中存在<em>错误</em>。此页面被设置为使用另一个页面作为模板，因此模板变量必须使用 XML 标记定义。有关详细信息，请参阅 <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog Wiki</a>。必须先修正此错误才能保存页面。',
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
    'copy' => '复制',
    'limit_results' => '限制结果',
    'search' => '搜寻',
    'likes' => '赞',
    'submit' => '提交',
    'no_new_pages' => '没有新页面',
    'pages' => '页面',
    'comments' => '评论',
    'template' => '模板',
    'use_template' => '使用模板',
    'template_msg' => '选中后，此静态页面将被标记为模板。',
    'none' => '无',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => '草稿',
    'draft_yes' => '是',
    'draft_no' => '否',
    'show_on_page' => '在页面上显示',
    'show_on_page_disabled' => '注意：当前已在静态页面配置中为所有页面禁用此选项。',
    'cache_time' => '缓存时间',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled (3600 = 1 hour,  86400 = 1 day). Staticpages with PHP enabled or are a template will not be cached.',
    'autotag_desc_staticpage' => '[staticpage: id 备用标题] - 显示指向静态页面的链接，并使用静态页面标题作为链接标题。可以指定备用标题，但不是必需的。',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.',
    'autotag_desc_page' => '[page: id 备用标题] - 显示指向静态页面插件页面的链接，并使用页面标题作为链接标题。可以指定备用标题，但不是必需的。',
    'autotag_desc_page_content' => '[page_content: id] - 显示静态页面插件中页面的内容。',
    'yes' => '是',
    'used_by' => '此模板已分配给 %s 个页面。如果其他模板通过自动标签调用此模板，实际使用它的页面可能更多。',
    'prev_page' => '上一页',
    'next_page' => '下一页',
    'parent_page' => '父页面',
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel=”next” and rel=”prev” to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s 个页面',
    'search_desc' => 'Control if page appears in search. Default depends on setting in Configuration and depends on page type (if it is a Center Block, Uses a Template, or Uses PHP).',
    'likes_desc' => '决定页面是否显示“喜欢”控件以及显示方式。默认值取决于插件配置。作为中央区块显示的页面不会显示此控件。模板页面不使用此设置。'
);

$LANG_staticpages_search = array(
    0  => '排除',
    1  => '使用默认值',
    2  => '包含'
);

$LANG_staticpages_likes = array(
    -1 => '使用默认值',
    0  => '禁用',
    1  => '喜欢和不喜欢',
    2  => '仅喜欢',
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';
$PLG_staticpages_MESSAGE22 = 'You could not delete the page. It is a template staticpage and it is currently assigned to 1 or more staticpages.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Static Pages',
    'title' => 'Static Pages Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => '允许 PHP？',
    'enable_eval_php_save' => '保存页面时解析 PHP',
    'sort_by' => '中央区块排序依据',
    'sort_menu_by' => '菜单项排序依据',
    'sort_list_by' => '管理列表排序依据',
    'delete_pages' => '删除所有者时同时删除页面？',
    'in_block' => '将页面包装在区块中？',
    'show_hits' => '显示点击数？',
    'show_date' => '显示日期？',
    'filter_html' => '过滤 HTML？',
    'censor' => '审查内容？',
    'default_permissions' => '页面默认权限',
    'autotag_permissions_staticpage' => '[staticpage: ] 权限',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] 权限',
    'aftersave' => '保存页面后',
    'atom_max_items' => 'Web 服务订阅中的最大页面数',
    'meta_tags' => '启用 Meta 标签',
    'likes_pages' => '页面喜欢',
    'comment_code' => '评论默认',
    'structured_data_type_default' => '默认结构化数据类型',
    'draft_flag' => '草稿标记预设',
    'disable_breadcrumbs_staticpages' => '禁用面包屑导航',
    'default_cache_time' => '默认缓存时间',
    'newstaticpagesinterval' => '新静态页面时间范围',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => '题目长度裁减',
    'includecenterblocks' => '包含中央区块静态页面',
    'includephp' => '包含使用 PHP 的静态页面',
    'includesearch' => '在搜索中启用静态页面',
    'includesearchcenterblocks' => '包含中央区块静态页面',
    'includesearchphp' => '包含使用 PHP 的静态页面',
    'includesearchtemplate' => '包含模板静态页面'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => '主要设置'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => '静态页面主要设置',
    'tab_whatsnew' => '有什么新的 组件',
    'tab_search' => '搜索结果',
    'tab_permissions' => '默认权限',
    'tab_autotag_permissions' => '自动标签使用权限'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => '静态页面主要设置',
    'fs_whatsnew' => '有什么新的 组件',
    'fs_search' => '搜索结果',
    'fs_permissions' => '默认权限',
    'fs_autotag_permissions' => '自动标签使用权限'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('是' => 1, '否' => 0),
    1 => array('是' => TRUE, '否' => FALSE),
    2 => array('日期' => 'date', '页面 ID' => 'id', '标题' => 'title'),
    3 => array('日期' => 'date', '页面 ID' => 'id', '标题' => 'title', '标签' => 'label'),
    4 => array('日期' => 'date', '页面 ID' => 'id', '标题' => 'title', '作者' => 'author'),
    5 => array('隐藏' => 'hide', '显示 - 使用修改日期' => 'modified', '显示 - 使用创建日期' => 'created'),
    9 => array('转到页面' => 'item', '显示列表' => 'list', '显示首页' => 'home', '显示管理页' => 'admin'),
    12 => array('无权限' => 0, '只读' => 2, '读写' => 3),
    13 => array('无权限' => 0, '使用' => 2),
    17 => array('启用评论' => 0, '禁用评论' => -1),
    39 => array('无' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting'),
    41 => array('否' => 0, '喜欢和不喜欢' => 1, '仅喜欢' => 2)
);
