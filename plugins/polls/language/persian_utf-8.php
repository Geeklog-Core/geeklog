<?php

###############################################################################
# persian_utf-8.php
#
# This is the Persian language file for Geeklog polls plugin
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

$LANG_POLLS = array(
    'polls' => 'نظرسنجی ها',
    'poll' => 'نظرسنجی',
    'results' => 'نتایج',
    'pollresults' => 'نتایج نظرسنجی',
    'votes' => 'آرا',
    'voters' => 'رای دهندگان',
    'vote' => 'رای',
    'pastpolls' => 'نظرسنجی های گذشته',
    'savedvotetitle' => 'رای ذخیره شد',
    'savedvotemsg' => 'رای شما ذخیره شد برای نظرسنجی',
    'pollstitle' => 'نظرسنجی ها در سیستم',
    'polltopics' => 'نظرسنجی های دیگر',
    'stats_top10' => 'ده نظرسنجی برتر',
    'stats_topics' => 'موضوع نظرسنجی',
    'stats_votes' => 'آرا',
    'stats_none' => 'به نظر می رسد که هیچ نظرسنجی در این سایت وجود ندارد یا هیچکس همواره رای نداده است.',
    'stats_summary' => 'نظرسنجی ها (پاسخ ها) در سیستم',
    'open_poll' => 'برای رای دادن باز است',
    'answer_all' => 'لطفا به همه سوالات باقی مانده پاسخ دهید',
    'not_saved' => 'نتیجه ذخیره نشد',
    'upgrade1' => 'یک نسخه جدید از افزونه نظرسنجی را نصب کردید. لطفا',
    'upgrade2' => 'ارتقا دهید',
    'editinstructions' => 'لطفا شناسه نظرسنجی را پر کنید، حداقل یک پرسش و دو پاسخ برای آن.',
    'pollclosed' => 'این نظرسنجی برای رای دادن بسته است.',
    'pollhidden' => 'شما از قبل رای داده اید. نتایج این نظرسنجی فقط هنگامی نشان داده خواهد شد که رأی گیری بسته باشد.',
    'start_poll' => 'شروع نظرسنجی',
    'no_new_polls' => 'بدون نظرسنجی ها جدید',
    'autotag_desc_poll' => '[poll: id alternate title] - یک پیوند به یک نظرسنجی با استفاده از موضوع نظرسنجی مانند عنوان را نمایش می دهد. عنوان جایگزین ممکن است مشخص شود اما نیاز نمی باشد.',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] - یک نظرسنجی برای رای دادن را نمایش می دهد. کلاس و نمایش همه نیاز نمی باشد. کلاس مشخص می کند کلاس سی اس اس و نمایش همه اگر به ۱ تنظیم شود، همه سوالات را نمایش می دهد',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] - نتایج نظرسنجی را نمایش می دهد. کلاس نیاز نمی باشد. کلاس مشخص می کند کلاس سی اس اس را.',
    'deny_msg' => 'دسترسی به این نظرسنجی ممنوع است. نظرسنجی منتقل/برداشته شده است یا مجوز های کافی ندارید.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'حالت',
    2 => 'لطفا یک موضوع را وارد کنید، حداقل یک پرسش و حداقل یک پاسخ برای آن سوال.',
    3 => 'نظرسنجی ایجاد شد',
    4 => 'نظرسنجی %s ذخیره شد',
    5 => 'ویرایش نظرسنجی',
    6 => 'شناسه نظرسنجی',
    7 => '(از فضا استفاده نکنید)',
    8 => 'در بلوک نظرسنجی ظاهر می شود',
    9 => 'موضوع',
    10 => 'پاسخ ها / آرا / یادداشت',
    11 => 'یک خطا در دریافت داده پاسخ نظرسنجی درباره نتایج نظرسنجی وجود داشت %s',
    12 => 'یک خطا در دریافت داده پرسش نظرسنجی درباره نتایج نظرسنجی وجود داشت %s',
    13 => 'ایجاد نظرسنجی',
    14 => 'ذخیره',
    15 => 'لغو',
    16 => 'حذف',
    17 => 'لطفا یک شناسه نظرسنجی وارد کنید',
    18 => 'فهرست نظرسنجی',
    19 => 'برای تغییر یا حذف یک نظرسنجی، روی نقشک ویرایش نظرسنجی کلیک کنید. برای ایجاد یک نظرسنجی جدید، روی "ایجاد جدید" در بالا کلیک کنید.',
    20 => 'رای دهندگان',
    21 => 'دسترسی ممنوع است',
    22 => "شما در حال تلاش برای دسترسی به یک نظرسنجی می باشید که حق آن را ندارید. این تلاش ضبط شده است. لطفا <a href=\"{$_CONF['site_admin_url']}/poll.php\">به صفحه مدیریت نظرسنجی بازگردید</a>.",
    23 => 'نظرسنجی جدید',
    24 => 'خانه مدیر',
    25 => 'بله',
    26 => 'خیر',
    27 => 'ویرایش',
    28 => 'ارسال',
    29 => 'جستجو',
    30 => 'محدود کردن نتایج',
    31 => 'پرسش',
    32 => 'برای حذف این پرسش از نظرسنجی، متن پرسش آن را بردارید',
    33 => 'برای رای دادن باز است',
    34 => 'موضوع نظرسنجی:',
    35 => 'این نظرسنجی دارد',
    36 => 'سوالات بیشتر.',
    37 => 'پنهان کردن نتایج هنگامی که نظرسنجی باز است',
    38 => 'هنگامی که نظرسنجی باز است، تنها مالک و ریشه می توانند نتایج را ببینند',
    39 => 'موضوع نمایش داده خواهد شد اگر بیشتر از یک پرسش وجود داشته باشد.',
    40 => 'همه پاسخ ها به این نظرسنجی را ببینید',
    1001 => 'اجازه پاسخ های چندگانه',
    1002 => 'شرح',
    1003 => 'شرح'
);

$PLG_polls_MESSAGE15 = 'نظر شما برای بازدید ارسال شده است و هنگامی که توسط یک ناظر تایید شده منتشر خواهد شد.';
$PLG_polls_MESSAGE19 = 'نظرسنجی شما با موفقیت ذخیره شده است.';
$PLG_polls_MESSAGE20 = 'نظرسنجی شما با موفقیت حذف شده است.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'ارتقا افزونه پشتیبانی نمی شود.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'نظرسنجی ها',
    'title' => 'پیکربندی نظرسنجی ها'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'برای نظرسنجی ها ورود نیاز است؟',
    'hidepollsmenu' => 'پنهان کردن ورودی منو نظرسنجی ها؟',
    'maxquestions' => 'حداکثر سوالات در هر نظرسنجی',
    'maxanswers' => 'حداکثر گزینه ها در هر پرسش',
    'answerorder' => 'مرتب سازی نتایج ...',
    'pollcookietime' => 'کوکی رای دهنده معتبر برای',
    'polladdresstime' => 'نشانی آیپی رای دهنده معتبر برای',
    'delete_polls' => 'حذف نظرسنجی ها با مالک؟',
    'aftersave' => 'پس از ذخیره نظرسنجی',
    'default_permissions' => 'مجوز های پیشفرض نظرسنجی',
    'autotag_permissions_poll' => '[نظرسنجی: ] مجوز ها',
    'autotag_permissions_poll_vote' => '[رای_نظرسنجی: ] مجوز ها',
    'autotag_permissions_poll_result' => '[نتیجه_نظرسنجی: ] مجوز ها',
    'newpollsinterval' => 'فاصله نظرسنجی های جدید',
    'hidenewpolls' => 'نظرسنجی های جدید',
    'title_trim_length' => 'عنوان کوتاه کردن طول',
    'meta_tags' => 'فعال کردن برچسب های متا',
    'block_enable' => 'فعال شده',
    'block_isleft' => 'نمایش بلوک در چپ',
    'block_order' => 'ترتیب بلوک',
    'block_topic_option' => 'گزینه های موضوع',
    'block_topic' => 'موضوع',
    'block_group_id' => 'گروه',
    'block_permissions' => 'مجوز ها'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'تنظیمات اصلی'
);

$LANG_tab['polls'] = array(
    'tab_main' => 'تنظیمات عمومی نظرسنجی ها',
    'tab_whatsnew' => 'بلوک موارد جدید',
    'tab_permissions' => 'مجوز های پیشفرض',
    'tab_autotag_permissions' => 'مجوز های استفاده از برچسب خودکار',
    'tab_poll_block' => 'بلوک نظرسنجی'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'تنظیمات عمومی نظرسنجی ها',
    'fs_whatsnew' => 'بلوک موارد جدید',
    'fs_permissions' => 'مجوز های پیشفرض',
    'fs_autotag_permissions' => 'مجوز های استفاده از برچسب خودکار',
    'fs_block_settings' => 'تنظیمات بلوک',
    'fs_block_permissions' => 'مجوز های بلوک'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('As Submitted' => 'submitorder', 'By Votes' => 'voteorder'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to Poll' => 'item', 'Display Admin List' => 'list', 'Display Public List' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'all', 'Homepage Only' => 'homeonly', 'Select Topics' => 'selectedtopics')
);
