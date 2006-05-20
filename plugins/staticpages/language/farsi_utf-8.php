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
$LANG_CHARSET = 'utf-8';
###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_STATIC= array(
    'newpage' => 'صفحه جديد',
    'adminhome' => 'خانه رييس',
    'staticpages' => 'آمار صفحات',
    'staticpageeditor' => 'ويرايشگر آمار صفحات',
    'writtenby' => 'نوشته شده بويسله',
    'date' => 'آخرين به روز آوري',
    'title' => 'عنوان',
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
    'printable_format' => 'فرمت قابل پرينت'
);
#YA hagh
#Doostan  Agar  Moshkeli  BOOd  BA  MAN  TAmas  BEgirid------By:Hesam.H
#e-mail: info1@4shir.com OR ir.security@gmail.com
?>
