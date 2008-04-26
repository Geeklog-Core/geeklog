<?php

###############################################################################
# turkish.php
# This is the turkish language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2003 ScriptEvi.com
# webmaster@scriptevi.com
# http://www.scriptevi.com
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
    newpage => 'Yeni Sayfa',
    adminhome => 'Yönetim Sayfasý',
    staticpages => 'Statik Sayfalar',
    staticpageeditor => 'Statik Sayfa Düzenleyicisi',
    writtenby => 'Yazan',
    date => 'Son Güncelleme',
    title => 'Baþlýk',
    content => 'Ýçerik',
    hits => 'Hit',
    staticpagelist => 'Statik Sayfa Listesi',
    url => 'URL',
    edit => 'Düzenle',
    lastupdated => 'Son Güncelleme',
    pageformat => 'Sayfa Formatý',
    leftrightblocks => 'Sol & Sað Bloklar',
    blankpage => 'Boþ Sayfa',
    noblocks => 'Bloklar Yok',
    leftblocks => 'Sol Bloklar',
    addtomenu => 'Menüye Ekle',
    label => 'Etiket',
    nopages => 'Henüz sistemde statik sayfalar yok',
    save => 'kaydet',
    preview => 'önizleme',
    delete => 'sil',
    cancel => 'vazgeç',
    access_denied => 'Giriþ Engellendi',
    access_denied_msg => 'Statik Sayfalar yönetim sayfalarýna yetkisiz giriþ demesi yapýyorsunuz. Not: Bu sayfalara yetkisiz giriþ denemelerinin hepsi kaydedilmektedir',
    all_html_allowed => 'Bütün HTML kodlarý kullanýlabilir',
    results => 'Statik Sayfalar Sonuçlarý',
    author => 'Yazar',
    no_title_or_content => 'En azýndan <b>Baþlýk</b> ve <b>Ýçerik</b> bölümlerini doldurmalýsýnýz.',
    no_such_page_anon => 'Lütfen giriþ yapýn..',
    no_page_access_msg => "Bu olabilir çünkü giriþ yapmadýnýz yada {$_CONF["site_name"]} nin kayýtlý bir üyesi deðilsiniz. {$_CONF["site_name"]} nin tüm üyelik giriþlerini elde etmek için lütfen <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> yeni bir üye olun</a>",
    php_msg => 'PHP: ',
    php_warn => 'Uyarý: Þayet bu seçeneði kullanýrsanýz, sayfanýz PHP kodunda deðerlendirilir. Dikkatli kullanýn !!',
    exit_msg => 'Çýkýþ Tipi: ',
    exit_info => 'Giriþ Mesajý Ýstemeyi olanaklý kýlar. Normal güvenlik kontrolü ve mesajý için iþareti kaldýrýn.',
    deny_msg => 'Bu sayfaya giriþ engellendi. Bu sayfa taþýndý yada kaldýrýldý veya yeterli izniniz yok.',
    stats_headline => 'Top On Statik Sayfa',
    stats_page_title => 'Sayfa Baþlýðý',
    stats_hits => 'Hit',
    stats_no_hits => 'It appears that there are no static pages on this site or no one has ever viewed them.',
    id => 'ID',
    duplicate_id => 'Bu statik sayfa için seçtiðiniz ID zaten kullanýlýyor. Lütfen baþka ID seçin.',
    instructions => 'Bir statik sayfayý düzenlemek yada silmek isterseniz, aþaðýdaki sayfa numarasýna týklayýnýz. Bir statik sayfayý görüntüleme, görmek istediðiniz sayfanýn baþlýðýna týklyýnýz. Yeni bir statik sayfa yaratmak için üstteki Yeni Sayfa linkine týklayýn. [C] \'ye týklayarak varolan sayfanýn bir kopyasýný yaratýrsýnýz.',
    centerblock => 'Ortablok: ',
    centerblock_msg => 'Ýþaretlenirse, bu statik sayfa index sayfasýnda bir orta blokda görüntülenecektir.',
    topic => 'Konu: ',
    position => 'Pozisyon: ',
    all_topics => 'Hepsi',
    no_topic => 'Sadece Ana Sayfa',
    position_top => 'Sayfanýn Üstü',
    position_feat => 'Günün Yazýsýndan Sonra',
    position_bottom => 'Sayfanýn Altý',
    position_entire => 'Tam Sayfa',
    head_centerblock => 'Ortablok',
    centerblock_no => 'Yok',
    centerblock_top => 'Üst',
    centerblock_feat => 'Gün. Yazýsý',
    centerblock_bottom => 'Alt',
    centerblock_entire => 'Tam Sayfa',
    'inblock_msg' => 'In a block: ',
    'inblock_info' => 'Wrap Static Page in a block.',
    'title_edit' => 'Edit page',
    'title_copy' => 'Make a copy of this page',
    'select_php_none' => 'do not execute PHP',
    'select_php_return' => 'execute PHP (return)',
    'select_php_free' => 'execute PHP',
    'title_display' => 'Display page',
    'php_not_activated' => 'The use of PHP in static pages is not activated. Please see the <a href="' . $_CONF['site_url'] . '/docs/staticpages.html#php">documentation</a> for details.',
    'printable_format' => 'Printable Format'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>
