<?php

###############################################################################
# persian_utf-8.php
#
# This is the Persian language file for Geeklog calendar plugin
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

# index.php
$LANG_CAL_1 = array(
    1 => 'تقویم وقایع',
    2 => 'با عرض پوزش، هیچ رویدادی برای نمایش وجود ندارد.',
    3 => 'چه زمانی',
    4 => 'چه مکانی',
    5 => 'شرح',
    6 => 'افزودن یک رویداد',
    7 => 'وقایع پیش رو',
    8 => 'با افزودن این رویداد به تقویم خود به سرعت می توانید فقط وقایعی که علاقه مند می باشید را با کلیک روی "تقویم من" از ناحیه وظایف کاربر ببینید.',
    9 => 'افزودن به تقویم من',
    10 => 'برداشتن از تقویم من',
    11 => 'افزودن رویداد به تقویم %s',
    12 => 'رویداد',
    13 => 'شروع می شود',
    14 => 'پایان می یابد',
    15 => 'بازگشت به تقویم',
    16 => 'تقویم',
    17 => 'تاریخ شروع',
    18 => 'تاریخ پایان',
    19 => 'ارسالات تقویم',
    20 => 'عنوان',
    21 => 'تاریخ شروع',
    22 => 'نشانی اینترنتی',
    23 => 'وقایع شما',
    24 => 'وقایع سایت',
    25 => 'هیچ وقایع پیش رویی وجود ندارد',
    26 => 'ارسال یک رویداد',
    27 => "ارسال یک رویداد به {$_CONF['site_name']} رویداد شما را در تقویم اصلی قرار خواهد داد جایی که کاربران می توانند به صورت اختیاری رویداد شما را به تقویم شخصی خود بیافزایند. این ویژگی به معنای اندوختن وقایع شخصی شما مانند زادرور و سالگرد ها <b>نمی باشد</b>.<br" . XHTML . "><br" . XHTML . ">یکبار که رویداد خود را ارسال می کنید به مدیران ما ارسال خواهد شد و اگر تایید شده باشد، رویداد شما در تقویم اصلی ظاهر خواهد شد.",
    28 => 'عنوان',
    29 => 'زمان پایان',
    30 => 'زمان شروع',
    31 => 'رویداد تمام روز',
    32 => 'خط نشانی ۱',
    33 => 'خط نشانی ۲',
    34 => 'شهر/شهرک',
    35 => 'استان',
    36 => 'کد پستی',
    37 => 'نوع رویداد',
    38 => 'ویرایش انواع رویداد',
    39 => 'موقعیت',
    40 => 'افزودن رویداد به',
    41 => 'تقویم اصلی',
    42 => 'تقویم شخصی',
    43 => 'پیوند',
    44 => 'برچسب های HTML مجاز نمی باشند',
    45 => 'ارسال',
    46 => 'وقایع در سیستم',
    47 => 'ده وقایع برتر',
    48 => 'بازدید',
    49 => 'به نظر می رسد که هیچ رویدادی در این سایت وجود ندارد یا هیچکس همواره روی یکی کلیک نکرده است.',
    50 => 'وقایع',
    51 => 'حذف',
    'autotag_desc_event' => '[event: id alternate title] - یک پیوند به یک پیوند رویداد از تقویم با استفاده از عنوان رویداد مانند عنوان را نمایش می دهد. عنوان جایگزین ممکن است مشخص شود اما نیاز نمی باشد.'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'نتایج تقویم',
    'title' => 'عنوان',
    'date_time' => 'تاریخ و زمان',
    'location' => 'موقعیت',
    'description' => 'شرح'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'افزودن رویداد شخصی',
    9 => '%s رویداد',
    10 => 'وقایع برای',
    11 => 'تقویم اصلی',
    12 => 'تقویم من',
    25 => 'بازگشت به ',
    26 => 'تمام روز',
    27 => 'هفته',
    28 => 'تقویم شخصی برای',
    29 => 'تقویم عمومی',
    30 => 'حذف رویداد',
    31 => 'افزودن',
    32 => 'رویداد',
    33 => 'تاریخ',
    34 => 'زمان',
    35 => 'افزودن سریع',
    36 => 'ارسال',
    37 => 'با عرض پوزش، ویژگی تقویم شخصی در این سایت فعال نمی باشد',
    38 => 'ویرایشگر رویداد شخصی',
    39 => 'روز',
    40 => 'هفته',
    41 => 'ماه',
    42 => 'افزودن رویداد اصلی',
    43 => 'ارسالات رویداد'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'ویرایشگر رویداد',
    2 => 'خطا',
    3 => 'حالت پست',
    4 => 'نشانی اینترنتی رویداد',
    5 => 'تاریخ شروع رویداد',
    6 => 'تاریخ پایان رویداد',
    7 => 'موقعیت رویداد',
    8 => 'شرح رویداد',
    9 => '(شامل http://)',
    10 => 'باید تاریخ ها/زمان ها، عنوان رویداد و شرح ارائه دهید',
    11 => 'مدیریت تقویم',
    12 => 'برای تغییر یا حذف یک رویداد، روی نقشک ویرایش آن رویداد در زیر کلیک کنید. برای ایجاد یک رویداد جدید، روی "ایجاد جدید" در بالا کلیک کنید. برای ایجاد یک نسخه از یک رویداد موجود روی نقشک نسخه کلیک کنید.',
    13 => 'نویسنده',
    14 => 'تاریخ شروع',
    15 => 'تاریخ پایان',
    16 => '',
    17 => "شما در حال تلاش برای دسترسی به یک رویداد می باشید که حق آن را ندارید. این تلاش ضبط شده است. لطفا <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">به صفحه مدیریت رویداد بازگردید</a>.",
    18 => '',
    19 => '',
    20 => 'ذخیره',
    21 => 'لغو',
    22 => 'حذف',
    23 => 'تاریخ شروع بد.',
    24 => 'تاریخ پایان بد.',
    25 => 'تاریخ پایان قبل از تاریخ شروع است.',
    26 => 'حذف ورودی های قدیمی',
    27 => 'اینها وقایعی می باشند قدیمی تر از ',
    28 => ' ماه ها. لطفا روی نقشک سطل زباله در زیر کلیک کنید تا آنها را حذف کنید یا یک مدت زمان متفاوت را انتخاب کنید: <br' . XHTML . '> یافتن همه ورودی های قدیمی تر از ',
    29 => ' ماه ها.',
    30 => 'بروزرسانی فهرست',
    31 => 'آیا مطمئن هستید که می خواهید همه کاربران انتخابی را به صورت دائمی حذف کنید؟',
    32 => 'فهرست همه',
    33 => 'هیچ رویدادی برای حذف انتخاب نشده است',
    34 => 'شناسه رویداد',
    35 => 'نمی توان حذف کرد',
    36 => 'با موفقیت حذف شد',
    'num_events' => '%s Event(s)'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'رویداد شما با موفقیت ذخیره شده است.',
    'delete' => 'رویداد با موفقیت حذف شده است.',
    'private' => 'رویداد در تقویم شما ذخیره شده است',
    'login' => 'تقویم شخصی شما را نمی تواند باز کرد تا هنگامی که وارد شوید',
    'removed' => 'رویداد با موفقیت از تقویم شخصی شما برداشته شد',
    'noprivate' => 'با عرض پوزش، تقویم های شخصی در این سایت فعال نمی باشند',
    'unauth' => 'با عرض پوزش، به صفحه مدیریت رویداد دسترسی ندارید. لطفا توجه داشته باشید که همه تلاش ها برای دسترسی به ویژگی های غیر مجاز ضبط شده اند'
);

$PLG_calendar_MESSAGE4 = "سپاس از شما برای ارسال یک رویداد به {$_CONF['site_name']}. برای تأیید به کارکنان ما ارسال شده است. اگر تأیید شده باشد، رویداد شما در اینجا در بخش <a href=\"{$_CONF['site_url']}/calendar/index.php\">تقویم</a> ما دیده خواهد شد.";
$PLG_calendar_MESSAGE17 = 'رویداد شما با موفقیت ذخیره شده است.';
$PLG_calendar_MESSAGE18 = 'رویداد با موفقیت حذف شده است.';
$PLG_calendar_MESSAGE24 = 'رویداد در تقویم شما ذخیره شده است.';
$PLG_calendar_MESSAGE26 = 'رویداد با موفقیت حذف شده است.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'ارتقا افزونه پشتیبانی نمی شود.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'تقویم',
    'title' => 'پیکربندی تقویم'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'برای تقویم ورود نیاز است؟',
    'hidecalendarmenu' => 'پنهان کردن ورودی منو تقویم؟',
    'personalcalendars' => 'فعال کردن تقویم های شخصی؟',
    'eventsubmission' => 'فعال کردن صف ارسالی؟',
    'showupcomingevents' => 'نمایش وقایع پیش رو؟',
    'upcomingeventsrange' => 'محدوده وقایع پیش رو',
    'event_types' => 'انواع رویداد',
    'hour_mode' => 'حالت ساعت',
    'notification' => 'اطلاع از طریق ایمیل؟',
    'delete_event' => 'حذف وقایع با مالک؟',
    'aftersave' => 'پس از ذخیره رویداد',
    'recaptcha' => 'reCAPTCHA',
    'recaptcha_score' => 'reCAPTCHA Score',
    'default_permissions' => 'مجوز های پیشفرض رویداد',
    'autotag_permissions_event' => '[رویداد: ] مجوز ها',
    'block_enable' => 'فعال شده',
    'block_isleft' => 'نمایش بلوک در چپ',
    'block_order' => 'ترتیب بلوک',
    'block_topic_option' => 'گزینه های موضوع',
    'block_topic' => 'موضوع',
    'block_group_id' => 'گروه',
    'block_permissions' => 'مجوز ها'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'تنظیمات اصلی'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'تنظیمات عمومی تقویم',
    'tab_permissions' => 'مجوز های پیشفرض',
    'tab_autotag_permissions' => 'مجوز های استفاده از برچسب خودکار',
    'tab_events_block' => 'بلوک وقایع'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'تنظیمات عمومی تقویم',
    'fs_permissions' => 'مجوز های پیشفرض',
    'fs_autotag_permissions' => 'مجوز های استفاده از برچسب خودکار',
    'fs_block_settings' => 'تنظیمات بلوک',
    'fs_block_permissions' => 'مجوز های بلوک'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'all', 'Homepage Only' => 'homeonly', 'Select Topics' => 'selectedtopics'),
    16 => array('Disabled' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4)
);
