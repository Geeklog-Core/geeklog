<?php

###############################################################################
# persian_utf-8.php
#
# This is the Persian language file for Geeklog links plugin
# Special thanks to Mahdi Montazeri for his work on this project
#
# Copyright (C) 2018 geeklog.ir
# info AT mahdimontazeri DOT com
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

$LANG_LINKS = array(
    10 => 'ارسالات',
    14 => 'پیوند ها',
    84 => 'پیوند ها',
    88 => 'No recent new links',
    114 => 'پیوند ها',
    116 => 'افزودن یک پیوند',
    117 => 'Report Broken Link',
    118 => 'Broken Link Report',
    119 => 'The following link has been reported to be broken: ',
    120 => 'To edit the link, click here: ',
    121 => 'The broken Link was reported by: ',
    122 => 'Thank you for reporting this broken link. The administrator will correct the problem as soon as possible',
    123 => 'Thank you',
    124 => 'Go',
    125 => 'Categories',
    126 => 'You are here:',
    'autotag_desc_link' => '[link: id alternate title] - Displays a link to a Link from the Links Plugin using the Link Title as the title. An alternate title may be specified but is not required.',
    'root' => 'ریشه'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'پیوند ها (کلیک ها) در سیستم',
    'stats_headline' => 'ده پیوند برتر',
    'stats_page_title' => 'پیوند ها',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'It appears that there are no links on this site or no one has ever clicked on one.'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => 'نتایج پیوند',
    'title' => 'عنوان',
    'date' => 'Date Added',
    'author' => 'Submitted by',
    'hits' => 'کلیک ها'
);

###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'ارسال یک پیوند',
    2 => 'پیوند',
    3 => 'Category',
    4 => 'Other',
    5 => 'If other, please specify',
    6 => 'Error: Missing Category',
    7 => 'When selecting "Other" please also provide a category name',
    8 => 'عنوان',
    9 => 'نشانی اینترنتی',
    10 => 'Category',
    11 => 'Link Submissions'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Thank-you for submitting a link to {$_CONF['site_name']}.  It has been submitted to our staff for approval.  If approved, your link will be seen in the <a href={$_CONF['site_url']}/links/index.php>links</a> section.";
$PLG_links_MESSAGE2 = 'Your link has been successfully saved.';
$PLG_links_MESSAGE3 = 'The link has been successfully deleted.';
$PLG_links_MESSAGE4 = "Thank-you for submitting a link to {$_CONF['site_name']}.  You can see it now in the <a href={$_CONF['site_url']}/links/index.php>links</a> section.";
$PLG_links_MESSAGE5 = 'You do not have sufficient access rights to view this category.';
$PLG_links_MESSAGE6 = 'You do not have sufficient rights to edit this category.';
$PLG_links_MESSAGE7 = 'Please enter a Category Name and Description.';
$PLG_links_MESSAGE10 = 'Your category has been successfully saved.';
$PLG_links_MESSAGE11 = 'You are not allowed to set the id of a category to "site" or "user" - these are reserved for internal use.';
$PLG_links_MESSAGE12 = 'You are trying to make a parent category the child of it\'s own subcategory. This would create an orphan category, so please first move the child category or categories up to a higher level.';
$PLG_links_MESSAGE13 = 'The category has been successfully deleted.';
$PLG_links_MESSAGE14 = 'Category contains links and/or categories. Please remove these first.';
$PLG_links_MESSAGE15 = 'You do not have sufficient rights to delete this category.';
$PLG_links_MESSAGE16 = 'No such category exists.';
$PLG_links_MESSAGE17 = 'This category id is already in use.';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'ارتقا افزونه پشتیبانی نمی شود.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

$LANG_LINKS_ADMIN = array(
    1 => 'ویرایشگر پیوند',
    2 => 'شناسه پیوند',
    3 => 'عنوان پیوند',
    4 => 'نشانی اینترنتی پیوند',
    5 => 'دسته بندی',
    6 => '(شامل http://)',
    7 => 'Other',
    8 => 'بازدید پیوند',
    9 => 'شرح پیوند',
    10 => 'You need to provide a link Title, URL and Description.',
    11 => 'مدیریت پیوند',
    12 => 'To modify or delete a link, click on that link\'s edit icon below.  To create a new link or a new category, click on "New link" or "New category" above. To edit multiple categories, click on "List categories" above.',
    14 => 'دسته بندی پیوند',
    16 => 'دسترسی ممنوع است',
    17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">go back to the link administration screen</a>.",
    20 => 'If other, specify',
    21 => 'ذخیره',
    22 => 'لغو',
    23 => 'حذف',
    24 => 'Link not found',
    25 => 'The link you selected for editing could not be found.',
    26 => 'Validate Links',
    27 => 'HTTP Status',
    28 => 'ویرایش دسته بندی',
    29 => 'Enter or edit the details below.',
    30 => 'دسته بندی',
    31 => 'شرح',
    32 => 'شناسه دسته بندی',
    33 => 'موضوع',
    34 => 'اصلی',
    35 => 'همه',
    40 => 'ویرایش این دسته بندی',
    41 => 'Create child category',
    42 => 'حذف این دسته بندی',
    43 => 'دسته بندی های سایت',
    44 => 'Add&nbsp;child',
    46 => 'User %s tried to delete a category to which they do not have access rights',
    50 => 'List categories',
    51 => 'پیوند جدید',
    52 => 'دسته بندی جدید',
    53 => 'List links',
    54 => 'مدیریت دسته بندی',
    55 => 'Edit categories below. Note that you cannot delete a category that contains other categories or links - you should delete these first, or move them to another category.',
    56 => 'ویرایشگر دسته بندی',
    57 => 'Not validated yet',
    58 => 'Validate now',
    59 => '<p>To validate all links displayed, please click on the "Validate now" link below. Please note that this might take some time depending on the amount of links displayed.</p>',
    60 => 'User %s tried illegally to edit category %s.',
    61 => 'Links in Category',
    'num_links' => '%s Link(s)'
);


$LANG_LINKS_STATUS = array(
    100 => 'Continue',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    999 => 'Connection Timed out'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => 'پیوند ها',
    'title' => 'پیکربندی پیوند ها'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => 'برای پیوند ها ورود نیاز است؟',
    'linksubmission' => 'فعال کردن صف ارسالی؟',
    'newlinksinterval' => 'فاصله پیوند های جدید',
    'hidenewlinks' => 'پنهان کردن پیوند های جدید؟',
    'hidelinksmenu' => 'پنهان کردن ورودی منو پیوند ها؟',
    'linkcols' => 'Categories per Column',
    'linksperpage' => 'پیوند ها در هر صفحه',
    'show_top10' => 'نمایش ده پیوند برتر؟',
    'notification' => 'اطلاع از طریق ایمیل؟',
    'delete_links' => 'حذف پیوند ها با مالک؟',
    'aftersave' => 'پس از ذخیره پیوند',
    'show_category_descriptions' => 'Show Category Description?',
    'new_window' => 'Open external links in new window?',
    'recaptcha' => 'reCAPTCHA',
    'recaptcha_score' => 'reCAPTCHA Score',
    'root' => 'ID of Root Category',
    'default_permissions' => 'مجوز های پیشفرض پیوند',
    'category_permissions' => 'Category Default Permissions',
    'autotag_permissions_link' => '[پیوند: ] مجوز ها'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'تنظیمات اصلی'
);

$LANG_tab['links'] = array(
    'tab_public' => 'Public Links List Settings',
    'tab_admin' => 'Links Admin Settings',
    'tab_permissions' => 'مجوز های پیوند',
    'tab_cpermissions' => 'Category Permissions',
    'tab_autotag_permissions' => 'مجوز های استفاده از برچسب خودکار'
);

$LANG_fs['links'] = array(
    'fs_public' => 'Public Links List Settings',
    'fs_admin' => 'Links Admin Settings',
    'fs_permissions' => 'مجوز های پیوند',
    'fs_cpermissions' => 'Category Permissions',
    'fs_autotag_permissions' => 'مجوز های استفاده از برچسب خودکار'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    9 => array('Forward to Linked Site' => 'item', 'Display Admin List' => 'list', 'Display Public List' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('Disabled' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4)
);
