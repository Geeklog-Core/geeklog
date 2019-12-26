<?php

###############################################################################
# korean_utf-8.php
# This is the english language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Tranlated by IvySOHO Ivy(KOMMA Tetsuko/Kim Younghie)
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
    'newpage' => '½Å±ÔÆäÀÌÁö',
    'adminhome' => '°ü¸®È­¸é',
    'staticpages' => 'Á¤Àû ÆäÀÌÁö',
    'staticpageeditor' => 'Á¤Àû ÆäÀÌÁöÀÇ ÆíÁı',
    'writtenby' => '¼ÒÀ¯ÀÚ',
    'date' => 'ÃÖÁ¾°»½ÅÀÏ',
    'title' => 'Á¦¸ñ',
    'page_title' => 'Page Title',
    'content' => '³»¿ë',
    'hits' => 'Á¶È¸°Ç¼ö',
    'staticpagelist' => 'Á¤Àû ÆäÀÌÁö °ü¸®',
    'url' => 'URL',
    'edit' => 'ÆíÁı',
    'lastupdated' => 'ÃÖÁ¾°»½ÅÀÏ',
    'pageformat' => 'ÆäÀÌÁö Æ÷¸ä',
    'leftrightblocks' => 'ÁÂ¿ìºí·Î±× ÀÖ½À´Ï´Ù',
    'blankpage' => 'ÀüÃ¼ È­¸éÇ¥½Ã',
    'noblocks' => 'ºí·Î±× ¾ø½À´Ï´Ù',
    'leftblocks' => '¿ŞÆíºí·Î±× ÀÖ½À´Ï´Ù(¿À¸¥Æíºí·Î±×´Â ¾ø½À´Ï´Ù)',
    'addtomenu' => '¿ŞÆíºí·Î±× ¸Ş´º¿¡ Ãß°¡',
    'label' => '¸Ş´ºÀÌ¸§',
    'nopages' => 'Á¤Àû ÆäÀÌÁö°¡ ¾ø½À´Ï´Ù',
    'save' => 'º¸Á¸',
    'preview' => '¹Ì¸®º¸±â',
    'delete' => '»èÁ¦',
    'cancel' => 'Ãë¼Ò',
    'access_denied' => 'ÁË¼ÛÇÕ´Ï´Ù¸¸, ¸ÕÀú ·Î±×ÀÎ ÇÏ½Ã±â ¹Ù¶ø´Ï´Ù',
    'access_denied_msg' => 'Ã¼Å©¸¦ ÇÏ¸é Á¢¼Ó±ÇÇÑÀÌ ¾ø´Â °æ¿ì, È­¸éÀÌ ·Î±×ÀÎ È­¸éÀ¸·Î ÀÚµ¿ÀûÀ¸·Î Ç¥½ÃµË´Ï´Ù.  Ã¼Å©¸¦ ÇÏÁö ¾Ê´Â °æ¿ì¿¡´Â ¡¸°ü¸®±ÇÇÑÀÌ ¾ø½À´Ï´Ù¡¹¶ó´Â ¸Ş¼¼Áö°¡ Ç¥½Ã µË´Ï´Ù',
    'all_html_allowed' => '¸ğµç HTML À» ÀÌ¿ë ÇÒ ¼ö ÀÖ½À´Ï´Ù',
    'results' => 'Á¤Àû ÆäÀÌÁö °Ë»ö°á°ú',
    'author' => '¼ÒÀ¯ÀÚ',
    'no_title_or_content' => ' <b> Á¦¸ñ</b> ¿Í  <b> ³»¿ë</b> ¸¦ Àû¾îÁÖ½Ã±â ¹Ù¶ø´Ï´Ù.',
    'title_error_saving' => 'Error Saving Page',
    'template_xml_error' => 'You have an <em>error in your XML markup</em>. This page is set to use another page as a template and therefore requires template variables to be defined using XML markup. Please see our <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog Wiki</a> for more information on how to do this as it must be corrected before the page can be saved.',
    'no_such_page_anon' => '·Î±×ÀÎ ÇÏ½Ã±â ¹Ù¶ø´Ï´Ù.',
    'no_page_access_msg' => "ÀÌ ¹®Á¦´Â ¾ÆÁ÷ ·Î±×ÀÎ ÇÏÁö ¾Ê¾Ò°Å³ª ¾Æ¸¶µµ ÀÌ »çÀÌÆ® {$_CONF['site_name']} ÀÇ È¸¿øÀÌ ¾Æ´Ï±â ¶§¹®ÀÎ °ÍÀ¸·Î ¿©°ÜÁı´Ï´Ù.  {$_CONF['site_name']} ¿¡ <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> È¸¿øµî·Ï</a>À» ÇÏ½Ã°Å³ª, ÀûÀıÇÑ Á¢¼Ó±ÇÀ» °ü¸®ÀÚ·Î ºÎÅÍ ÃëµæÇÏ½Ã±â ¹Ù¶ø´Ï´Ù",
    'php_msg' => 'PHP: ',
    'php_warn' => '<br' . XHTML . '>ÁÖÀÇ: ÀÌ ¿É¼ÇÀÌ À¯È¿ÇÏ±â µÇ¸é ´ç½ÅÀÇ ÆäÀÌÁö¿¡ µé¾îÀÖ´Â PHP ÄÚµå°¡ ½ÇÇàµË´Ï´Ù.  Á¤Àû ÆäÀÌÁö¸¦ ÀÌ¿ëÇÏ´Â °æ¿ì¿¡´Â ´Ù½ÃÇÑ¹ø °ü¸®È­¸é ¡¸±×·ì:Static Page Admin¡¹¿¡¼­ ±ÇÇÑ¡¸Staticpages. PHP¡¹ ¿¡ Ã¼Å©ÇÏ½Ã±â ¹Ù¶ø´Ï´Ù.  PHP¸¦ »ç¿ëÇÏ´Â °æ¿ì Åë»ó(return) ¾øÀÌ ±×´ë·Î ¡¸PHP ½ÇÇàÇÏ±â¡¹ ¸ğµå¿¡¼­ ÀÌ¿ëÇÒ ¼ö ÀÖ½À´Ï´Ù.  ÀÌ¿ë¿¡´Â ¼¼½ÉÇÑ ÁÖÀÇ¸¦ ±â¿ïÀÌ½Ã±â ¹Ù¶ø´Ï´Ù !!',
    'exit_msg' => 'Á¶È¸±ÇÇÑÀÌ ¾ø´Â °æ¿ì: ',
    'exit_info' => 'Ã¼Å©¸¦ ÇÏ¸é Á¶È¸±ÇÇÑÀÌ ¾ø´Â °æ¿ì, ·Î±×ÀÎ ¿ä±¸È­¸éÀÌ Ç¥½ÃµË´Ï´Ù. Ã¼Å©¸¦ ÇÏÁö ¾Ê´Â °æ¿ì¿¡´Â ¡¸±ÇÇÑÀÌ ¾ø½À´Ï´Ù¡¹ ¶ó´Â ¸Ş¼¼Áö°¡ Ç¥½ÃµË´Ï´Ù.',
    'deny_msg' => 'ÆäÀÌÁö Á¢¼Ó¿¡ ½ÇÆĞ ÇÏ¿´½À´Ï´Ù.  ÆäÀÌÁö°¡ ÀÌµ¿ È¤Àº »èÁ¦µÇ°Å³ª, ¾Æ´Ï¸é ±ÇÇÑÀÌ ¾ø°Å³ª ¾î´À ÇÑ ÂÊÀÏ °ÍÀÔ´Ï´Ù.',
    'stats_headline' => 'Á¤Àû ÆäÀÌÁö Åé 10',
    'stats_page_title' => 'Á¦¸ñ',
    'stats_hits' => 'Á¶È¸°Ç¼ö',
    'stats_no_hits' => 'Á¤Àû ÆäÀÌÁö°¡ ¾ø°Å³ª, Á¶È¸ÀÚ°¡ ¾ø°Å³ª ¾î´À ÂÊÀÏ °ÍÀÔ´Ï´Ù.',
    'id' => 'ID',
    'duplicate_id' => 'ÁöÁ¤ÇÑ ID ´Â ÀÌ¹Ì »ç¿ë µÇ°í ÀÖ½À´Ï´Ù. ´Ù¸¥ ID¸¦ »ç¿ëÇÏ½Ã±â ¹Ù¶ø´Ï´Ù.',
    'instructions' => 'ÆäÀÌÁö¸¦ ÆíÁı, »èÁ¦´Â °¢ ÆäÀÌÁö ¸Ó¸®ºÎºĞÀÇ ÆíÁı¾ÆÀÌÄÜÀ» Å¬¸¯.  ÆäÀÌÁö Á¶È¸´Â Á¦¸ñÀ» Å¬¸¯, »õ·Î¿î ÆäÀÌÁö¸¦ ÀÛ¼º ÇÒ °æ¿ì¿¡´Â ¡¸½Å±ÔÀÛ¼º¡¹¸µÅ©¸¦ Å¬¸¯. ÆäÀÌÁö º¹»ç´Â ¡¸C¡¹¸¦ Å¬¸¯ ÇÏ½Ã±â ¹Ù¶ø´Ï´Ù.',
    'centerblock' => 'Áß½É¿µ¿ª Ç¥½Ã: ',
    'centerblock_msg' => 'Ã¼Å©¸¦ ÇÏ¸é Ã³À½ÆäÀÌÁö È¤Àº È­Á¦ÀÇ ¸Ó¸® ÆäÀÌÁö Áß½É¿µ¿ª¿¡ Ç¥½ÃµË´Ï´Ù. Ç¥½Ã´Â ID·Î ºĞ·ù µË´Ï´Ù.',
    'topic' => 'ÅäÇÈ: ',
    'position' => 'Ç¥½ÃÀå¼Ò: ',
    'all_topics' => 'ÀüºÎ',
    'no_topic' => 'È¨ÆäÀÌÁö¸¸',
    'position_top' => 'ÆäÀÌÁö ¸Ó¸´ºÎºĞ',
    'position_feat' => 'ÁÖ¸ñ±â»ç ¾Æ·§ºÎºĞ',
    'position_bottom' => 'ÆäÀÌÁö ¾Æ·¡',
    'position_entire' => 'ÆäÀÌÁö ÀüÃ¼',
    'head_centerblock' => '¸Ó¸® Ç¥½Ã',
    'centerblock_no' => '¾Æ´Ï¿À',
    'centerblock_top' => '¸Ó¸®',
    'centerblock_feat' => 'ÁÖ¸ñ±â»ç',
    'centerblock_bottom' => '¾Æ·§ºÎºĞ',
    'centerblock_entire' => 'ÆäÀÌÁö ÀüÃ¼',
    'inblock_msg' => 'ºí·Î±×·Î µÑ·¯½×ÀÓ: ',
    'inblock_info' => 'Ã¼Å©¸¦ ÇÏ¸é Á¦¸ñÀÌ Ç¥½ÃµÇ¸ç, ³»¿ëÀº »óÀÚ¾È¿¡ ´ã°ÜÁı´Ï´Ù.',
    'title_edit' => 'ÆíÁı',
    'title_copy' => 'º¹»ç¸¦ ÀÛ¼º',
    'title_display' => 'ÆäÀÌÁö Ç¥½Ã',
    'select_php_none' => 'PHP¸¦ ½ÇÇàÇÏÁö ¾Ê½À´Ï´Ù',
    'select_php_return' => 'PHP¸¦ ½ÇÇàÇÕ´Ï´Ù (return)',
    'select_php_free' => ' PHP¸¦ ½ÇÇàÇÕ´Ï´Ù',
    'php_not_activated' => "Á¤Àû ÆäÀÌÁö¿¡¼­  PHP´Â »ç¿ëÇÏÁö ¾Ê´Â ¼³Á¤À¸·Î µÇ¾î ÀÖ½À´Ï´Ù.  ÀÚ¼¼ÇÑ °ÍÀº  <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\"> °ü·Ã µµÅ¥¸àÆ® </a> ¸¦ º¸½Ã±â ¹Ù¶ø´Ï´Ù.",
    'printable_format' => 'ÀÎ¼â¿ë Æ÷¸ä',
    'copy' => 'º¹»ç',
    'limit_results' => 'Á¼Çô°¡¸ç °Ë»ö',
    'search' => '°Ë»ö',
    'submit' => 'µî·Ï',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages',
    'comments' => 'Comments',
    'template' => 'Template',
    'use_template' => 'Use Template',
    'template_msg' => 'When checked, this Static Page will be marked as a template.',
    'none' => 'None',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No',
    'show_on_page' => 'Show on Page',
    'show_on_page_disabled' => 'Note: This is currently disabled for all pages in the Staticpage Configuration.',
    'cache_time' => 'Cache Time',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled (3600 = 1 hour,  86400 = 1 day). Staticpages with PHP enabled or are a template will not be cached.',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.',
    'autotag_desc_page' => '[page: id alternate title] - Displays a link to a page (from the Static Page plugin) using the page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_page_content' => '[page_content: id] - Displays the contents of a page. (from Static Page plugin)',
    'yes' => 'Yes',
    'used_by' => 'This template is assigned to %s page(s). It is possible this template is used more than specified here if the template is being retrieved via an autotag in another template.',
    'prev_page' => 'Previous page',
    'next_page' => 'Next page',
    'parent_page' => 'Parent page',
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel=â€nextâ€ and rel=â€prevâ€ to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s Page(s)'
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
    'allow_php' => 'Allow PHP?',
    'sort_by' => 'Sort Centerblocks by',
    'sort_menu_by' => 'Sort Menu Entries by',
    'sort_list_by' => 'Sort Admin List by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'structured_data_type_default' => 'Structured Data Type Default',
    'draft_flag' => 'Draft Flag Default',
    'disable_breadcrumbs_staticpages' => 'Disable Breadcrumbs',
    'default_cache_time' => 'Default Cache Time',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP',
    'includesearchtemplate' => 'Include Template Static Pages'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Static Pages Main Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_search' => 'Search Results',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    4 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Author' => 'author'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1),
    39 => array('None' => 0, 'WebPage' => 1, 'Article' => 2, 'NewsArticle' => 3, 'BlogPosting' => 4)
);
