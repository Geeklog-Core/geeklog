<?php

###############################################################################
# persian_utf-8.php
#
# This is the Persian language file for Geeklog staticpages plugin
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

$LANG_STATIC = array(
    'newpage' => 'صفحه جدید',
    'adminhome' => 'خانه مدیر',
    'staticpages' => 'صفحات ایستا',
    'staticpageeditor' => 'ویرایشگر صفحه ایستا',
    'writtenby' => 'نوشته‌شده توسط',
    'date' => 'آخرین به‌روزرسانی',
    'title' => 'عنوان',
    'page_title' => 'عنوان صفحه',
    'content' => 'محتوا',
    'hits' => 'بازدیدها',
    'staticpagelist' => 'فهرست صفحات ایستا',
    'url' => 'URL',
    'edit' => 'ویرایش',
    'lastupdated' => 'آخرین به‌روزرسانی',
    'pageformat' => 'قالب صفحه',
    'leftrightblocks' => 'بلوک‌های چپ و راست',
    'blankpage' => 'صفحه خالی',
    'noblocks' => 'بدون بلوک',
    'leftblocks' => 'بلوک‌های چپ',
    'addtomenu' => 'افزودن به منو',
    'label' => 'برچسب',
    'nopages' => 'هنوز هیچ صفحه ایستایی در سیستم وجود ندارد',
    'save' => 'ذخیره',
    'preview' => 'پیش‌نمایش',
    'delete' => 'حذف',
    'cancel' => 'لغو',
    'access_denied' => 'دسترسی ممنوع است',
    'access_denied_msg' => 'شما به‌صورت غیرمجاز در تلاش برای دسترسی به یکی از صفحات مدیریت صفحات ایستا هستید. توجه داشته باشید که همه تلاش‌های دسترسی غیرمجاز ثبت می‌شوند.',
    'all_html_allowed' => 'استفاده از همه HTML مجاز است',
    'results' => 'نتایج صفحات ایستا',
    'author' => 'نویسنده',
    'no_title_or_content' => 'حداقل باید فیلدهای <b>عنوان</b> و <b>محتوا</b> را تکمیل کرده و یک <b>موضوع</b> را انتخاب کنید.',
    'title_error_saving' => 'خطا هنگام ذخیره صفحه',
    'template_xml_error' => 'در نشانه‌گذاری XML شما <em>خطا</em> وجود دارد. این صفحه برای استفاده از صفحه‌ای دیگر به‌عنوان الگو تنظیم شده است، بنابراین متغیرهای الگو باید با نشانه‌گذاری XML تعریف شوند. برای اطلاعات بیشتر به <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">ویکی Geeklog</a> مراجعه کنید. این خطا باید پیش از ذخیره صفحه اصلاح شود.',
    'no_such_page_anon' => 'لطفاً وارد شوید.',
    'no_page_access_msg' => "ممکن است وارد سایت نشده باشید یا عضو {$_CONF['site_name']} نباشید. برای دسترسی کامل، لطفاً <a href=\"{$_CONF['site_url']}/users.php?mode=new\">عضو {$_CONF['site_name']} شوید</a>.",
    'php_msg' => 'PHP: ',
    'php_warn' => 'هشدار: اگر این گزینه را فعال کنید، کد PHP موجود در صفحه اجرا خواهد شد. با احتیاط استفاده کنید!',
    'exit_msg' => 'نوع خروج: ',
    'exit_info' => 'برای نمایش پیام «ورود الزامی است» فعال کنید. برای بررسی امنیتی و پیام معمولی، آن را غیرفعال بگذارید.',
    'deny_msg' => 'دسترسی به این صفحه مجاز نیست. ممکن است صفحه جابه‌جا یا حذف شده باشد، یا مجوز کافی برای مشاهده آن نداشته باشید.',
    'stats_headline' => 'ده صفحه ایستای برتر',
    'stats_page_title' => 'عنوان صفحه',
    'stats_hits' => 'بازدیدها',
    'stats_no_hits' => 'به نظر می‌رسد در این سایت صفحه ایستایی وجود ندارد یا هنوز کسی آن‌ها را مشاهده نکرده است.',
    'id' => 'شناسه',
    'duplicate_id' => 'شناسه‌ای که برای این صفحه ایستا انتخاب کرده‌اید قبلاً استفاده شده است. لطفاً شناسه دیگری انتخاب کنید.',
    'instructions' => 'برای ویرایش یا حذف یک صفحه ایستا، روی نماد ویرایش آن کلیک کنید. برای مشاهده صفحه، روی عنوان آن کلیک کنید. برای ایجاد صفحه جدید، روی «ایجاد جدید» کلیک کنید. نماد کپی یک نسخه از صفحه موجود ایجاد می‌کند.',
    'centerblock' => 'بلوک مرکزی: ',
    'centerblock_msg' => 'در صورت انتخاب، این صفحه ایستا به‌صورت بلوک مرکزی در صفحه اصلی موضوع‌های اختصاص‌یافته نمایش داده می‌شود.',
    'topic' => 'موضوع',
    'position' => 'موقعیت: ',
    'all_topics' => 'همه',
    'no_topic' => 'فقط صفحه اصلی',
    'position_top' => 'بالای صفحه',
    'position_feat' => 'پس از مطلب ویژه',
    'position_bottom' => 'پایین صفحه',
    'position_entire' => 'کل صفحه',
    'head_centerblock' => 'بلوک مرکزی',
    'centerblock_no' => 'خیر',
    'centerblock_top' => 'بالا',
    'centerblock_feat' => 'مطلب ویژه',
    'centerblock_bottom' => 'پایین',
    'centerblock_entire' => 'کل صفحه',
    'inblock_msg' => 'در یک بلوک: ',
    'inblock_info' => 'صفحه ایستا را داخل یک بلوک نمایش دهید.',
    'title_edit' => 'ویرایش صفحه',
    'title_copy' => 'ایجاد یک نسخه از این صفحه',
    'title_display' => 'نمایش صفحه',
    'select_php_none' => 'PHP اجرا نشود',
    'select_php_return' => 'اجرای PHP (return)',
    'select_php_free' => 'اجرای PHP',
    'php_not_activated' => 'استفاده از PHP در صفحات ایستا فعال نیست. برای جزئیات به <a href="' . $_CONF['site_url'] . '/docs/english/staticpages.html#php">مستندات</a> مراجعه کنید.',
    'printable_format' => 'قالب مناسب چاپ',
    'copy' => 'نسخه',
    'limit_results' => 'محدود کردن نتایج',
    'search' => 'جستجو',
    'likes' => 'پسندها',
    'submit' => 'ارسال',
    'no_new_pages' => 'صفحه جدیدی وجود ندارد',
    'pages' => 'صفحات',
    'comments' => 'نظرات',
    'template' => 'الگو',
    'use_template' => 'استفاده از الگو',
    'template_msg' => 'در صورت انتخاب، این صفحه ایستا به‌عنوان الگو علامت‌گذاری می‌شود.',
    'none' => 'هیچ‌کدام',
    'use_template_msg' => 'اگر این صفحه ایستا الگو نیست، می‌توانید آن را به یک الگو اختصاص دهید. در صورت انتخاب الگو، محتوای صفحه باید قالب صحیح XML را رعایت کند. برای اطلاعات بیشتر به <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">ویکی Geeklog</a> مراجعه کنید.',
    'draft' => 'پیش‌نویس',
    'draft_yes' => 'بله',
    'draft_no' => 'خیر',
    'show_on_page' => 'نمایش در صفحه',
    'show_on_page_disabled' => 'توجه: این گزینه در حال حاضر برای همه صفحات در تنظیمات صفحات ایستا غیرفعال است.',
    'cache_time' => 'زمان حافظه نهان',
    'cache_time_desc' => 'محتوای این صفحه ایستا حداکثر به مدت این تعداد ثانیه در حافظه نهان نگهداری می‌شود. مقدار 0 حافظه نهان را غیرفعال می‌کند و مقدار -1 تا زمان ویرایش دوباره صفحه آن را نگه می‌دارد. صفحات دارای PHP یا صفحات الگو در حافظه نهان قرار نمی‌گیرند. (3600 = یک ساعت، 86400 = یک روز)',
    'autotag_desc_staticpage' => '[staticpage: id عنوان جایگزین] - پیوندی به یک صفحه ایستا با استفاده از عنوان صفحه نمایش می‌دهد. عنوان جایگزین اختیاری است.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id] - محتوای یک صفحه ایستا را نمایش می‌دهد.',
    'autotag_desc_page' => '[page: id عنوان جایگزین] - پیوندی به یک صفحه از افزونه صفحات ایستا با استفاده از عنوان صفحه نمایش می‌دهد. عنوان جایگزین اختیاری است.',
    'autotag_desc_page_content' => '[page_content: id] - محتوای یک صفحه از افزونه صفحات ایستا را نمایش می‌دهد.',
    'yes' => 'بله',
    'used_by' => 'این الگو به %s صفحه اختصاص داده شده است. اگر این الگو از طریق autotag در الگویی دیگر فراخوانی شود، ممکن است صفحات بیشتری از آن استفاده کنند.',
    'prev_page' => 'صفحه قبلی',
    'next_page' => 'صفحه بعدی',
    'parent_page' => 'صفحه والد',
    'page_desc' => 'تنظیم صفحه قبلی و/یا بعدی، رابطه میان صفحات یک مجموعه صفحه‌بندی‌شده را مشخص می‌کند. پیوندهای ناوبری به‌صورت خودکار به صفحه افزوده نمی‌شوند و باید آن‌ها را خودتان اضافه کنید. توجه: صفحه والد در حال حاضر استفاده نمی‌شود.',
    'num_pages' => '%s صفحه',
    'search_desc' => 'مشخص می‌کند آیا صفحه در نتایج جستجو نمایش داده شود یا نه. مقدار پیش‌فرض به تنظیمات افزونه و نوع صفحه بستگی دارد؛ برای مثال بلوک مرکزی، استفاده از الگو یا استفاده از PHP.',
    'likes_desc' => 'تعیین می‌کند کنترل پسندیدن در صفحه نمایش داده شود یا نه و به چه صورت. مقدار پیش‌فرض به تنظیمات افزونه بستگی دارد. صفحاتی که به‌صورت بلوک مرکزی نمایش داده می‌شوند این کنترل را نشان نمی‌دهند. صفحات الگو از این تنظیم استفاده نمی‌کنند.'
);

$LANG_staticpages_search = array(
    0  => 'حذف‌شده',
    1  => 'استفاده از پیش‌فرض',
    2  => 'شامل‌شده'
);

$LANG_staticpages_likes = array(
    -1 => 'استفاده از پیش‌فرض',
    0  => 'غیرفعال',
    1  => 'پسندیدن و نپسندیدن',
    2  => 'فقط پسندیدن',
);

$PLG_staticpages_MESSAGE15 = 'نظر شما برای بررسی ارسال شد و پس از تأیید مدیر منتشر خواهد شد.';
$PLG_staticpages_MESSAGE19 = 'صفحه با موفقیت ذخیره شد.';
$PLG_staticpages_MESSAGE20 = 'صفحه با موفقیت حذف شد.';
$PLG_staticpages_MESSAGE21 = 'این صفحه هنوز وجود ندارد. برای ایجاد آن، فرم زیر را تکمیل کنید. اگر اشتباهی به این صفحه آمده‌اید، روی لغو کلیک کنید.';
$PLG_staticpages_MESSAGE22 = 'امکان حذف صفحه وجود ندارد؛ این صفحه یک الگو است و در حال حاضر به یک یا چند صفحه ایستا اختصاص داده شده است.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'ارتقای افزونه پشتیبانی نمی‌شود.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'صفحات ایستا',
    'title' => 'پیکربندی صفحات ایستا'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'اجازه PHP؟',
    'enable_eval_php_save' => 'تحلیل PHP هنگام ذخیره صفحه',
    'sort_by' => 'مرتب‌سازی بلوک‌های مرکزی بر اساس',
    'sort_menu_by' => 'مرتب‌سازی موارد منو بر اساس',
    'sort_list_by' => 'مرتب‌سازی فهرست مدیریت بر اساس',
    'delete_pages' => 'حذف صفحات همراه با مالک؟',
    'in_block' => 'نمایش صفحات در بلوک؟',
    'show_hits' => 'نمایش بازدیدها؟',
    'show_date' => 'نمایش تاریخ؟',
    'filter_html' => 'فیلتر HTML؟',
    'censor' => 'سانسور محتوا؟',
    'default_permissions' => 'مجوزهای پیش‌فرض صفحه',
    'autotag_permissions_staticpage' => 'مجوزهای [staticpage: ]',
    'autotag_permissions_staticpage_content' => 'مجوزهای [staticpage_content: ]',
    'aftersave' => 'پس از ذخیره صفحه',
    'atom_max_items' => 'حداکثر صفحات در خوراک خدمات وب',
    'meta_tags' => 'فعال‌سازی متاتگ‌ها',
    'likes_pages' => 'پسندهای صفحه',
    'comment_code' => 'حالت پیش‌فرض نظرات',
    'structured_data_type_default' => 'نوع پیش‌فرض داده ساخت‌یافته',
    'draft_flag' => 'حالت پیش‌فرض پیش‌نویس',
    'disable_breadcrumbs_staticpages' => 'غیرفعال‌سازی مسیر راهنما',
    'default_cache_time' => 'زمان پیش‌فرض حافظه نهان',
    'newstaticpagesinterval' => 'بازه صفحات ایستای جدید',
    'hidenewstaticpages' => 'صفحات ایستای جدید',
    'title_trim_length' => 'حداکثر طول عنوان',
    'includecenterblocks' => 'شامل کردن صفحات ایستا به‌صورت بلوک مرکزی',
    'includephp' => 'شامل کردن صفحات ایستا دارای PHP',
    'includesearch' => 'فعال‌سازی صفحات ایستا در جستجو',
    'includesearchcenterblocks' => 'شامل کردن صفحات ایستا به‌صورت بلوک مرکزی',
    'includesearchphp' => 'شامل کردن صفحات ایستا دارای PHP',
    'includesearchtemplate' => 'شامل کردن صفحات ایستای الگو'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'تنظیمات اصلی'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'تنظیمات اصلی صفحات ایستا',
    'tab_whatsnew' => 'بلوک موارد جدید',
    'tab_search' => 'نتایج جستجو',
    'tab_permissions' => 'مجوزهای پیش‌فرض',
    'tab_autotag_permissions' => 'مجوزهای استفاده از برچسب خودکار'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'تنظیمات اصلی صفحات ایستا',
    'fs_whatsnew' => 'بلوک موارد جدید',
    'fs_search' => 'نتایج جستجو',
    'fs_permissions' => 'مجوزهای پیش‌فرض',
    'fs_autotag_permissions' => 'مجوزهای استفاده از برچسب خودکار'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('درست' => 1, 'نادرست' => 0),
    1 => array('درست' => true, 'نادرست' => false),
    2 => array('تاریخ' => 'date', 'شناسه صفحه' => 'id', 'عنوان' => 'title'),
    3 => array('تاریخ' => 'date', 'شناسه صفحه' => 'id', 'عنوان' => 'title', 'برچسب' => 'label'),
    4 => array('تاریخ' => 'date', 'شناسه صفحه' => 'id', 'عنوان' => 'title', 'نویسنده' => 'author'),
    5 => array('پنهان' => 'hide', 'نمایش - استفاده از تاریخ ویرایش' => 'modified', 'نمایش - استفاده از تاریخ ایجاد' => 'created'),
    9 => array('رفتن به صفحه' => 'item', 'نمایش فهرست' => 'list', 'نمایش خانه' => 'home', 'نمایش مدیریت' => 'admin'),
    12 => array('بدون دسترسی' => 0, 'فقط خواندنی' => 2, 'خواندن و نوشتن' => 3),
    13 => array('بدون دسترسی' => 0, 'استفاده' => 2),
    17 => array('نظرات فعال' => 0, 'نظرات غیرفعال' => -1),
    39 => array('هیچ‌کدام' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting'),
    41 => array('نادرست' => 0, 'پسندیدن و نپسندیدن' => 1, 'فقط پسندیدن' => 2)
);
