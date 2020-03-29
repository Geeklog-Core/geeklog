<?php

###############################################################################
# farsi.php
# This is the farsi language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2004 Hesm.H
# hesam@4shir.com
# www.4shir.com
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
    'newpage' => 'صفحه جديد',
    'adminhome' => 'خانه رييس',
    'staticpages' => 'آمار صفحات',
    'staticpageeditor' => 'ويرايشگر آمار صفحات',
    'writtenby' => 'نوشته شده بويسله',
    'date' => 'آخرين به روز آوري',
    'title' => 'عنوان',
    'page_title' => 'Page Title',
    'content' => 'محتويات',
    'hits' => 'مشاهده',
    'staticpagelist' => 'صفحه ليست آمار',
    'url' => 'URL',
    'edit' => 'ويرايش',
    'lastupdated' => 'آخرين به روز رساني',
    'pageformat' => 'فرمت صفحه',
    'leftrightblocks' => 'بلاكهاي راست و چپ',
    'blankpage' => 'صفحه خالي',
    'noblocks' => 'بدون بلاك',
    'leftblocks' => 'بلاكهاي راست',
    'addtomenu' => 'افزودن به فهرست',
    'label' => 'اتيكت',
    'nopages' => 'هنوز هيچ صفحه در سيستم براي آمار در صفحه موجود نيست',
    'save' => 'ذخيره',
    'preview' => 'پيش نمايش',
    'delete' => 'حذف',
    'cancel' => 'لغو',
    'access_denied' => 'غير قابل دسترسي ',
    'access_denied_msg' => 'شما در حال تلاش براي دسترسي به صفحه اي از صفحات آماري هستيدكه براي شما مجاز نميباشد. اين تلاش شما براي ادمين فرستاده شد',
    'all_html_allowed' => 'تمام كدهاي |Html | اجازه دارند',
    'results' => 'نتيجه آمار صفحات',
    'author' => 'نويسنده',
    'no_title_or_content' => 'شما بايد حداقل فيلد<b>عنوان</b>و<b>محتوي</b> پر نماييد',
    'title_error_saving' => 'Error Saving Page',
    'template_xml_error' => 'You have an <em>error in your XML markup</em>. This page is set to use another page as a template and therefore requires template variables to be defined using XML markup. Please see our <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog Wiki</a> for more information on how to do this as it must be corrected before the page can be saved.',
    'no_such_page_anon' => 'لطفا وارد شويد',
    'no_page_access_msg' => "اين صفحه قابل دسترسي است يا شما وارد نشده ايد يا عضو سايت {$_CONF['site_name']} نيستيد.لطفا <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> عضو ما شويد</a> of {$_CONF['site_name']} براي دسترسي كامل و استفاده از سايت مانند اعضاي ما",
    'php_msg' => 'PHP: ',
    'php_warn' => 'اخطار: |Html| در صفحه شما ارزيابي ميشود اگر شما اين گزينه را فعال كنيد . با دقت استفاده كنيد',
    'exit_msg' => 'نوع خروج ',
    'exit_info' => 'فعالسازي پيام  لازم الورود . ترك بدون چك كردن براي امنيت پايين و چك كردن پيامها',
    'deny_msg' => 'اين صفحه غير قابل دسترسي است. يا مكان صفحه تغيير كرده يا شما اجازه دسترسي به آن را نداريد',
    'stats_headline' => '10 صفحه برتر از نظر آمار',
    'stats_page_title' => 'عنوان صفحه',
    'stats_hits' => 'مشاهده',
    'stats_no_hits' => 'اين هنگامي ظاهر ميشود كه هيچ صفحه آماري در سايت موجود نميباشد يا تا به حال ديده نشده است',
    'id' => 'شناسه',
    'duplicate_id' => 'شناسه اي كه شما براي استفاده از صفحه آمارها وارد نموده ايد قبلا استفاده شده. لطفا يكي ديگر وارد كنيد',
    'instructions' => 'براي تغيير يا پاك كردن صفحه آمار سايت روي شماره صفحه مربوطه كليك كنيد. براي ديدن آمار سايت روي عنوان صفحه مورد نظرتان كليك كنيد. رو ي [C]  براي كپي كردن از يك صفحه موجود كليك كنيد',
    'centerblock' => 'شمارنده بلاك: ',
    'centerblock_msg' => 'اگر علامت زده شود اين صفحه آماري در بلاك وسط سايت و ايندكس به نمايش در خواهد آمد',
    'topic' => 'موضوع/تاپيك: ',
    'position' => 'موقعيت: ',
    'all_topics' => 'همه',
    'no_topic' => 'فقط صفحه خانگي',
    'position_top' => 'بالاي صفحه',
    'position_feat' => 'بعد از نمايان كردن مقالات',
    'position_bottom' => 'پايين صفحه',
    'position_entire' => 'همگي صفحه',
    'head_centerblock' => 'بلاك وسط',
    'centerblock_no' => 'خير',
    'centerblock_top' => 'بالا',
    'centerblock_feat' => 'بهترين . مقاله',
    'centerblock_bottom' => 'پايين',
    'centerblock_entire' => 'همكي صفحه',
    'inblock_msg' => 'در يك بلاك: ',
    'inblock_info' => 'قرار دادن كل آمار در يك بلاك',
    'title_edit' => 'ويرايش صفحه',
    'title_copy' => 'گرفتن يك كپي از اين صفحه',
    'title_display' => 'نمايش صفحه',
    'select_php_none' => 'را اجرا نكنيدPHP',
    'select_php_return' => 'اجرا كنيدPHP (،پس فرستادن)',
    'select_php_free' => 'اجرا كنيدPHP',
    'php_not_activated' => 'استفاده از |PhP| در آمار صفحات فعال نيست . لطفا به مستندات يك نگاه بياندازيد !!',
    'printable_format' => 'فرمت قابل پرينت',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit',
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
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel=”next” and rel=”prev” to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s Page(s)',
    'search_desc' => 'Control if page appears in search. Default depends on setting in Configuration and depends on page type (if it is a Center Block, Uses a Template, or Uses PHP).'
);

$LANG_staticpages_search = array(
    0 => 'Excluded',
    1 => 'Use Default',
    2 => 'Included'
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
    'enable_eval_php_save' => 'Parse PHP on Save of Page',
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
    39 => array('None' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting')
);
