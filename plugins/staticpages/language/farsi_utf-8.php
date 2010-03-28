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
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';

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
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'draft_flag' => 'Draft Flag Default',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions'
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
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1)
);

?>
