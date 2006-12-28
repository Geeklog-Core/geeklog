<?php

###############################################################################
# turkish.php
# This is the turkish language page for GeekLog 1.4.0
# Translated by Kemal CELLAT
# kemal@moderntalking.biz
# http://www.moderntalking.biz
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
# - root (user)
###############################################################################

$LANG_CHARSET = 'utf-8';

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# lib-common.php

$LANG01 = array(
    1 => 'Ekleyen:',
    2 => 'devamý',
    3 => 'yorum',
    4 => 'Deðiþtir',
    5 => 'Oy Kullan',
    6 => 'Sonuçlar',
    7 => 'Anket Sonuçlarý',
    8 => 'oy',
    9 => 'Yönetici kontrolleri:',
    10 => 'Gönderilenler',
    11 => 'Yazýlar',
    12 => 'Bloklar',
    13 => 'Konular',
    14 => 'Internet Adresleri',
    15 => 'Etkinlikler',
    16 => 'Anketler',
    17 => 'Kullanýcýlar',
    18 => 'SQL Sorgusu',
    19 => 'Sistemden Çýk',
    20 => 'Kullanýcý Bilgileri:',
    21 => 'Kullanýcý Adý',
    22 => 'Kullanýcý Tanýmlayýcýsý',
    23 => 'Güvenlik Seviyesi',
    24 => 'Ýsimsiz Kullanýcý',
    25 => 'Yorum Ekle',
    26 => 'Aþaðýdaki yorumlarýn sorumluluðu gönderene aittir. Sitemiz herhangi bir sorumluluk kabul etmez.',
    27 => 'En Son',
    28 => 'Sil',
    29 => 'Hiç yorum yapýlmamýþ.',
    30 => 'Eski Yazýlar',
    31 => 'Kabul edilen HTML komutlarý:',
    32 => 'Kullanýcý adýnýz yanlýþ',
    33 => 'Hata, kayýt dosyasýna yazýlamýyor',
    34 => 'Hata',
    35 => 'Çýkýþ Yap',
    36 => 'on',
    37 => 'Kullanýcýlardan hiç bir yazý gelmemiþ',
    38 => 'Content Syndication',
    39 => 'Yenile',
    40 => 'php.ini parametlerinizden <tt>register_globals = Off</tt> konumundadýr. ancak, Geeklog  için <tt>register_globals</tt>parametresinin <strong>on</strong> konumunda olmasý gerekmektedir. Before you continue, please set it to <strong>on</strong> and restart your web server.Lütfen servis saðlayýcýnýz ile kontakt kurunuz',
    41 => 'Misafirler',
    42 => 'Yazar:',
    43 => 'Cevap Ver',
    44 => 'Üst',
    45 => 'MySQL Hata Numarasý',
    46 => 'MySQL Hata Mesajý',
    47 => 'Kullanýcý',
    48 => 'Kayýt Bilgileriniz',
    49 => 'Görünüm Özellikleri',
    50 => 'SQL komutunda hata var',
    51 => 'yardým',
    52 => 'Yeni',
    53 => 'Kontrol Ana Sayfasý',
    54 => 'Dosya açýlamýyor.',
    55 => 'Hata',
    56 => 'Oy kullan',
    57 => 'Þifre',
    58 => 'Sisteme Gir',
    59 => "Hala üye deðilmisiniz?<br><a href=\"{$_CONF['site_url']}/users.php?mode=new\">Üye olun</a>",
    60 => 'Yorum Gönder',
    61 => 'Yeni ',
    62 => 'kelime',
    63 => 'Yorum Ayarlarý',
    64 => 'Bu Yazýyý bir Arkadaþýna Gönder',
    65 => 'Basýlabilir Hali',
    66 => 'Takvimim',
    67 => 'Hoþ Geldiniz',
    68 => 'Ana Sayfa',
    69 => 'iletiþim',
    70 => 'ara',
    71 => 'yazý ekle',
    72 => 'web kaynaklarý',
    73 => 'geçmiþ anketler',
    74 => 'takvim',
    75 => 'geliþmiþ arama',
    76 => 'site istatistikleri',
    77 => 'Eklentiler',
    78 => 'Gelecek Etkinlikler',
    79 => 'Yenilikler',
    80 => 'hikaye son',
    81 => 'hikaye son',
    82 => 'saat',
    83 => 'YORUMLAR',
    84 => 'Adresler',
    85 => 'son 48 saat',
    86 => 'Hiç yeni yorum yok',
    87 => 'son 2 hafta',
    88 => 'Hiç yeni adres yok',
    89 => 'Hiç etkinlik yok',
    90 => 'Ana Sayfa',
    91 => 'Yaratýlma süresi:',
    92 => 'saniye',
    93 => 'Copyright',
    94 => 'Bu sayfalarda yayýmlanan materyalin tüm haklarý sahiplerine aittir.',
    95 => 'Powered By:',
    96 => 'Gruplar',
    97 => 'Kelime Listesi',
    98 => 'Eklentiler',
    99 => 'Yazýlar',
    100 => 'Hiç yeni yazý yok',
    101 => 'Etkinliklerim',
    102 => 'Site Etkinlikleri',
    103 => 'Veritabaný Yedekleri',
    104 => 'ta. Gönderen:',
    105 => 'Kullanýcýlara Mesaj',
    106 => 'Okunma',
    107 => 'GL Sürüm Testi',
    108 => 'Önbelleði Temizle',
    109 => 'Uygunsuz içerik',
    110 => 'Bu iletiyi site adminine bildirin',
    111 => 'PDF Versiyonu göster',
    112 => 'Kayýtlý Üyeler',
    113 => 'Dökümantasyon',
    114 => 'TRACKBACKS',
    115 => 'Yeni trackback iletisi yok',
    116 => 'Trackback',
    117 => 'Dizin',
    118 => 'Lütfen sýradaki sayfayý okuyunuz:',
    119 => "Þifrenizi mi <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">unuttunuz</a>?",
    120 => 'Permanent link to this comment',
    121 => 'Yorumlar (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'Tüm HTML kodlarý izinli',
    124 => 'Seçili tüm öðeleri Silmek için Týklayýn',
    125 => 'Seçili tüm öðeleri silmek istediðinize emin misiniz?',
    126 => 'Tüm Öðeleri Ýþaretle veya iþareti kaldýr '
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Yorum ekle',
    2 => 'Biçim Methodu',
    3 => 'Sistemden Çýk',
    4 => 'Sisteme Üye ol',
    5 => 'Kullanýcý Adý',
    6 => 'Yorum koyabilmeniz için sisteme giriþ yapmanýz gerekiyor. Eðer bir kullanýcý adýnýz yoksa aþaðýdaki formu kullanarak kendinize bir tane yaratýn.',
    7 => 'Son yorumunuz ',
    8 => " saniye önceydi.  Bu sitede iki yorum arasýnda minimum {$_CONF['commentspeedlimit']} saniye olmalýdýr.",
    9 => 'Yorum',
    10 => 'Rapor Et',
    11 => 'Yorumu Ekle',
    12 => 'Lütfen Baþlýk ve Yorum bloklarýný doldurunuz.',
    13 => 'Bilgileriniz',
    14 => 'Ön Ýzleme',
    15 => 'Bu iletiyi Rapor Et',
    16 => 'Baþlýk',
    17 => 'Hata',
    18 => 'Önemli Bilgiler',
    19 => 'Yorumlarýnýzýn konuyla ilgili olmasýna dikkat ediniz.',
    20 => 'Yeni bir yorum baþlýðý açmaktansa baþka insanlarýn yorumlarýna cevap vermeyi tercih ediniz.',
    21 => 'Baþka insanlarýn yorumlarýný okuyunuz ki ayný þeyleri bir de siz söylememiþ olun.',
    22 => 'Yorumunuzun konusunu içeriðini iyi anlatan bir þekilde seçiniz.',
    23 => 'Email adresiniz diðer kullanýcýlara GÖSTERÝLMEYECEKTÝR.',
    24 => 'Herhangi Kullanýcý',
    25 => 'Bu iletiyi site adminine bildirmek istediðinize emin misiniz?',
    26 => '%s Bu ileti site adminine bildirilmiþtir:',
    27 => 'Þikayet Et'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Kullanýcý Profili:',
    2 => 'Kullanýcý Adý',
    3 => 'Gerçek Ad',
    4 => 'Þifre',
    5 => 'Email',
    6 => 'Web Sitesi',
    7 => 'Hakkýnda',
    8 => 'PGP Anahtarý',
    9 => 'Kaydet',
    10 => 'Bu kullanýcý için son 10 yorum -',
    11 => 'Hiç Yorum Yok',
    12 => 'Kullanýcý Özellikleri:',
    13 => 'Her Gece Özet Email',
    14 => 'Bu þifre rastgele yatarýlmýþtýr. Bu þifreyi olabildiðince çabuk deðiþtirmeniz önerilir. Þifrenizi deðiþtirmek için sisteme giriþ yapýp Kullanýcý menüsünden Kayýt Bilgilerine gidiniz.',
    15 => "{$_CONF['site_name']} sitesindeki kullanýcý hesabýnýz baþarýyla yaratýldý. Bu hesabý kullanmak için sitemize aþaðýdaki bilgiler dahilinde giriþ yapýnýz. Bu maili ileride referans olarak kullanmak için kaydediniz.",
    16 => 'Kullanýcý Hesap Bilgileriniz',
    17 => 'Hesap yok',
    18 => 'Belirttiðiniz email adresi gerçek bir email adresine benzemiyor',
    19 => 'Kullanýcý adýnýz veye email adresiniz sistemde kullanýlýyor',
    20 => 'Belirttiðiniz email adresi gerçek bir email adresine benzemiyor',
    21 => 'Hata',
    22 => "{$_CONF['site_name']} üye ol!",
    23 => "Bir kullanýcý hesabý yaratmanýz size {$_CONF['site_name']} üyeliði saðlar. Bu sayede siteye kendinize ait yorumlarýnýzý gönderebilir ve kendi içeriðinizi düzenleyebilirsiniz. Eðer kullanýcý hesabýnýz yoksa sadece Herhangi Birisi-Ýsimsiz Kullanýcý olarak içerik ve yorum gönderebilirsiniz. Sistemimize verdiðiniz email adresi <b><i>hiç bir zaman</i></b> sitede görüntülenmeyecektir.",
    24 => 'Þifreniz verdiðiniz email adresinize gönderilecektir.',
    25 => 'Þifrenizi mi unuttunuz?',
    26 => 'Kullanýcý adýnýzý girin ve Þifremi Gönder tuþuna basýn. Yeni yaratýlacak bir þifre sistemimize kayýtlý olan email adresinize gönderilecektir.',
    27 => 'Üye Ol!',
    28 => 'Þifremi Gönder',
    29 => 'Sistemden çýktýnýz:',
    30 => 'Sisteme girdiniz:',
    31 => 'Seçtiðini bu kontrol sisteme giriþ yapmýþ olmanýzý gerektirmektedir',
    32 => 'Ýmza',
    33 => 'Site misafirlerine asla gösterilmeyecektir',
    34 => 'Adýnýz ve soyadýnýz',
    35 => 'Þifrenizi deðiþtirmek için',
    36 => 'http:// ile baþlamalý',
    37 => 'Yorumlarýnýza uygulanýr',
    38 => 'Hakkýnýzla ilgili herþey! Herkes bunu okuyabilir',
    39 => 'Paylaþacaðýnýz PGP anahtarýnýz',
    40 => 'Konu Sembolü Kullanma',
    41 => 'Yönetime Katýlmak Ýstiyorum',
    42 => 'Tarih Biçimi',
    43 => 'En Fazla Yazý Sayýsý',
    44 => 'Bloklar Olmasýn',
    45 => 'Görünüm Özellikleri -',
    46 => 'Görmek Ýstemediðiniz Konu ve Yazarlar -',
    47 => 'Haber Ayarlarý -',
    48 => 'Konular',
    49 => 'Yazýlarda semboller kullanýlmayacak',
    50 => 'Ýlgilenmiyorsanýz iþareti kaldýrýn',
    51 => 'Sadece haberler ile ilgili yazýlar',
    52 => 'Varsayýlan:',
    53 => 'Günün yazýlarýný her akþam al',
    54 => 'Görmek istemediðiniz konu ve kullanýcýlar ile ilgili seçenekleri seçiniz.',
    55 => 'Site tarafýndan varsayýlan seçim deðerlerini kullanmak istiyorsanýz, seçeneklerin tamamýný boþ býrakýrsanýz. Eðer herhangi bir seçim yaparsanýz, varsayýlan seçimler kullanýlmaz, bu yüzden görmek istediðiniz tüm özellikleri seçmeniz gerekir. Varsayýlan seçimler kalýn yazý tipi ile belirtilmiþtir.',
    56 => 'Yazarlar',
    57 => 'Görünüm Þekli',
    58 => 'Sýralama Þekli',
    59 => 'Yorum Sayýsý Limiti',
    60 => 'Yorumlarýnýzýn nasýl görüntülenmesini istersiniz?',
    61 => 'Ýlk en yeni mi, yoksa en eski mi gösterilsin?',
    62 => 'Varsayýlan deðer 100',
    63 => "Þifreniz email adresinize gönderildi. Lütfen, email mesajýnýzda belirtilen adýmlarý uygulayýn. {$_CONF['site_name']} kullandýðýnýz için teþekkür ederiz!",
    64 => 'Yorum Ayarlarý -',
    65 => 'Bir Daha Sisteme Girmeyi Deneyin',
    66 => "Kullanýcý adýnýzý veya þifrenizi yanlýþ girdiniz. Lütfen aþaðýdaki formu kullanarak bir daha sisteme giriþ yapmayý deneyin. <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Yeni bir kullanýcý</a> mýsýnýz?",
    67 => 'Üyelik Tarihi',
    68 => 'Beni hatýrla:',
    69 => 'Sizi sisteme giriþ yaptýktan sonra hatýrlama süresi',
    70 => "{$_CONF['site_name']} için içerik ve görünüm ayarlarý düzenleyin",
    71 => "{$_CONF['site_name']} nin en büyük özelliði, içeriðinizi özelleþtirebilir, bu sitenin tüm görüntüsünü deðiþtirebilirsiniz.  Bu büyük avantajlardan yararlanmak için öncelikle {$_CONF['site_name']} ne <a href=\"{$_CONF['site_url']}/users.php?mode=new\">kayýt yapmalýsýnýz</a>.  Zaten kayýtlý bir üyemisiniz?  O zaman sol taraftaki formu kullanarak giriþ yapýnýz!",
    72 => 'Tema',
    73 => 'Dil',
    74 => 'Sitenin görünümünü deðiþtirin!',
    75 => 'Email ile Gönderilecek Konular -',
    76 => 'If you select a topic from the list below you will receive any new stories posted to that topic at the end of each day.  Choose only the topics that interest you!',
    77 => 'Resim',
    78 => 'Resminizi Ekleyin!',
    79 => 'Resmi silmek için burayý seçin',
    80 => 'Siteye Giriþ',
    81 => 'Email Yolla',
    82 => 'Son 10 Mesaj -',
    83 => 'Yazý gönderme istatistikleri -',
    84 => 'Yazýlan yazýlarýn toplamý:',
    85 => 'Yazýlan yorumlarýn toplamý:',
    86 => 'Gönderdiði tüm mesajlar:',
    87 => 'Giriþ Adýnýz',
    88 => "Birisi (belki siz) {$_CONF['site_name']}, sitesindeki \"%s\" hesabýnýz için yeni bir þifre istedi <{$_CONF['site_url']}>.\n\nÞayet siz gerçekten bu þifreyi almak istiyorsanýz, lütfen bu linki týklayýn:\n\n",
    89 => "Þayet bu þifreyi almak istemiyorsanýz, bu mesajý dikkate almayýn ve bu isteði önemsemeyin (þifreniz deðiþmeyecek ve olduðu gibi kalacaktýr).\n\n",
    90 => 'Aþaðýdaki hesabýnýz için yeni bir þifre girmelisiniz. Not: bu formu gönderinceye kadar eski þifreniz geçerlidir.',
    91 => 'Yeni Þifre Belirle',
    92 => 'Yeni Þifre Gir',
    93 => 'Yeni bir þifre isteðiniz %d saniye önceydi. Bu site þifre istekleri arasýnda en az %d saniye olmasýný aramaktadýr.',
    94 => '"%s" isimli üyenin Hesabýný Sil',
    95 => 'Aþaðýdaki "hesabý sil" butonuna týklayýnca hesabýnýz, veritabanýmýzdan kaldýrýlacaktýr. Not, bu hesabýnýz altýnda gönderdiðiniz yazýlar ve yorumlar <strong>silinmeyecektir</strong> fakat iletiler "Ýsimsiz Kullanýcý" olarak görüntülenecektir.',
    96 => 'hesabý sil',
    97 => 'Hesap Silme Onayý',
    98 => 'Hesabýnýzý silmek istediðinize eminmisiniz? Böylece yeni bir hesap yaratýncaya kadar bu siteye kayýtlý kullanýcý olarak giremeyeceksiniz. Þayet eminseniz aþaðýdaki formda ki "hesabý sil" butonuna tekrar týklayýnýz.',
    99 => 'isimli üyenin Gizlilik Seçenekleri',
    100 => 'Yöneticiden Email',
    101 => 'Site yöneticilerinden email izni',
    102 => 'Üyelerden Email',
    103 => 'Diðer üyelerden email izni',
    104 => 'Aktifliðinizin Görüntülenmesi',
    105 => 'Aktif Kullanýcýlar Bloðunda görüntülenme',
    106 => 'Þehir',
    107 => 'Kiþisel profilinizde görüntülenir',
    108 => 'Yeni þifre tekrar',
    109 => 'Yeni þifrenizi tekrar yazýn',
    110 => 'Þuan ki Þifreniz',
    111 => 'Lütfen þuan kullanmakta olduðunuz þifreyi girin',
    112 => 'Ýzin verilen giriþ sayýsýný aþmýþ bulunuyorsunuz.  Lütfen daha sonra tekrar deneyiniz.',
    113 => 'Login Attempt Failed',
    114 => 'Kapalý Hesap',
    115 => 'Hesabýnýz kapatýlmýþtýr, uzun süredir diriþ yapmamýþ olabilirsiniz. Lütfen site admini ile iletiþime geçiniz.',
    116 => 'Hesabýnýz Aktivasyon bekliyor',
    117 => 'Hesabýnýz site yönetimi tarafýndan onay beklemektedir. Hesabýnýz onaylanýncaya kadar giriþ yapmazsýnýz.',
    118 => "{$_CONF['site_name']}hesabýnýz site yönetimi tarafýndan aktifleþtirildi. Aþaðadaki linkten kullanýcý adýnýz: (<username>) ve size daha önce gönderilen þifrenizle giriþ yapabilirsiniz.",
    119 => 'Eðer þifrenizi unuttuysanýz, bu linkten yeni bir þifre belirleyebilirsiniz:',
    120 => 'Aktif Hesap',
    121 => 'Servis',
    122 => 'Üzgünüm, Yeni Kullanýcý kaydý kapatýlmýþtýr',
    123 => "<a href=\"{$_CONF['site_url']}/users.php?mode=new\">Yeni Üye misiniz?</a>?",
    124 => 'Email Tekrar ',
    125 => 'Girdiðiniz E-mail adresleri ayný deðil!',
    126 => 'Doðrulama için lütfen tekrar yazýn',
    127 => 'Burada ki ayarlardan herhangi birini deðiþtirmek için þifrenizi girmeniz gerekiyor.',
    128 => 'Adýnýz',
    129 => 'Þifre &amp; Email',
    130 => 'Hakkýnýzda',
    131 => 'Günlük Özet Ayarlarý',
    132 => 'Günlük Özet Özelliði',
    133 => 'Yorum Ekraný',
    134 => 'Yorum Ayarlarý',
    135 => '<li>Yorumlarýnýn nasýl gösterileceðine ait ayarlar</li><li>Yorumlarýn sýralanma þekline ait ayar</li><li>En fazla gösterilecek yorum sayýsý - geçerli sayý 100</li>',
    136 => 'Gösterilmeyecek Konu ve Yazarlar',
    137 => 'Yazý Ýçeriði Filtreleme',
    138 => 'Diðer Ayarlar',
    139 => 'Görünüm ve Language',
    140 => '<li>No Topic Icons if checked will not display the story topic icons</li><li>No boxes if checked will only show the Admin Menu, User Menu and Topics<li>Set the maximum number of stories to show per page</li><li>Set your theme and perferred date format</li>',
    141 => 'Eriþilebilirlik Ayarlarý',
    142 => 'Geçerli site ayarlarý üyelerden ve yöneticiden üye almanýza izin vermekte ve online kullanýlar bloðunda görünmenize izin vermektedir.Kutuda iþareti kaldýrarak istemediðiniz özelliði iptal edebilirsiniz.',
    143 => 'Block Ýçeriði Filtresi',
    144 => 'Göster & Gizle Bloklarý',
    145 => 'Kiþisel Profilimi Göster',
    146 => 'Þifre ve E-mail',
    147 => 'Þifrenizi, emailinizi ve beni hatýrla özelliklerini düzenleyin. Doðrulama için þifrenizi veya e-mail adresinizi iki kez girmeniz gerekmektedir.',
    148 => 'Kullanýcý Bilgileri',
    149 => 'Diðer Kullanýcýlarýn da göreceði kullanýcý bilgilerinizi düzenleyin.<li>Ýmzanýz yorumlarýnýza ve forumda ki mesajlarýnýzýn altýna otomatik olarak eklenir</li><li>Kendiniz hakkýnda paylaþmak istediklerinizi BIO bölümüne yazabilirsiniz</li><li>PGP Anahtarý (Boþ Býrakabilirsiniz)</li>',
    150 => 'DÝKKAT: Javascript recommended for enhanced functionality',
    151 => 'ÖnÝzleme',
    152 => 'Kullanýcý Adý & Þifre',
    153 => 'Görünüm & Language',
    154 => 'Ýçerik',
    155 => 'Eriþilebilirlil',
    156 => 'Hesabýmý Sil'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Gösterilecek hiç haber yok',
    2 => 'Gösterilecek hiç haber yazýsý yok. Bu konu hakkýnda hiç haber olmayabilir, veya belirlediðiniz ayarlar yüzünden gösterilemiyor olabilir',
    3 => ' %s için',
    4 => 'Günün Yazýsý',
    5 => 'Sonraki',
    6 => 'Önceki',
    7 => 'Ýlk',
    8 => 'Son'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Mesaj gönderilirken bir hata oluþtu. Lütfen bir daha deneyin.',
    2 => 'Mesajýnýz baþarýyla gönderildi.',
    3 => 'Cevap Adresi alanýna doðru bir email adresi girdiðinizden emin olunuz.',
    4 => 'Lütfen, Adýnýzý, Cevap Adresinizi, Konu ve Mesaj alanlarýný doldurunuz',
    5 => 'Hata: Böyle bir kullanýcý yok.',
    6 => 'Hata oluþtu.',
    7 => 'Kullanýcý Profili:',
    8 => 'Kullanýcý Adý',
    9 => 'Kullanýcý URL\'ý',
    10 => 'Mail yolla:',
    11 => 'Adýnýz:',
    12 => 'Cevap Adresi:',
    13 => 'Konu:',
    14 => 'Mesaj:',
    15 => 'HTML kodu çevrilmeyecektir.',
    16 => 'Mesajý Gönder',
    17 => 'Bu Yazýyý bir Arkadaþýna Gönder',
    18 => 'Alýcýnýn Adý',
    19 => 'Alýcýnýn Email Adresi',
    20 => 'Gönderen Adý',
    21 => 'Gönderen Emaili',
    22 => 'Bütün alanlarý doldurmalýsýnýz',
    23 => "Bu email size %s (%s) tarafýndan gönderilmiþtir. Sizin bu yazý {$_CONF['site_url']} ile ilgilenebileceðinizi düþündü. Bu bir SPAM deðildir, ve sizin email adresiniz herhangi bir þekilde bir listeye eklenmemiþtir.",
    24 => 'Bu yazýya yorum ekle',
    25 => 'Bu özelliði kullanabilmeniz için sisteme giriþ yapmanýz gerekmektedir. Sitemize giriþ yapmanýz sayesinde sitemizin kötü kullanýmýný önlemiþ olursunuz',
    26 => 'Bu form sizin seçtiðiniz kullanýcýya email yollamanýzý saðlar. Tüm alanlar mecburidir.',
    27 => 'Mesaj',
    28 => '%s: ',
    29 => "Bu mesaj {$_CONF['site_name']} günlük özetidir. ",
    30 => ' Günlük Haber Özeti ',
    31 => 'Baþlýk',
    32 => 'Tarih',
    33 => 'Yazýnýn tamamý için:',
    34 => 'Mesajýn Sonu',
    35 => 'Üzgünüz, bu kullanýcý hiç mail almamayý tercih etmiþ.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Geliþmiþ Arama',
    2 => 'Anahtar Kelimeler',
    3 => 'Konu',
    4 => 'Tamamý',
    5 => 'Tipi',
    6 => 'Yazýlar',
    7 => 'Yorumlar',
    8 => 'Yazarlar',
    9 => 'Tamamý',
    10 => 'Ara',
    11 => 'Arama Sonuçlarý',
    12 => 'bulundu',
    13 => 'Arama Sonuçlarý: Hiç kayýt bulunamadý',
    14 => 'Arama kriteriniz ile hiç kayýt bulunamadý:',
    15 => 'Lütfen bir daha deneyin.',
    16 => 'Baþlýk',
    17 => 'Tarih',
    18 => 'Yazar',
    19 => "{$_CONF['site_name']} sitesinin veri tabanýnda bütün yazýlarý ara.",
    20 => 'Tarih',
    21 => '-',
    22 => '(Tarih yapýsý YYYY-AA-GG)',
    23 => 'Okunma Sayýsý',
    24 => '%d adet kayýt bulundu',
    25 => 'kayýt bulundu. Toplam',
    26 => 'kayýt var. Arama süresi',
    27 => 'saniye.',
    28 => 'Aramanýz sonucunda herhangi bir yazý veya yorum bulunamadý',
    29 => 'Yazý ve Yorum Arama Sonuçlarý',
    30 => 'Aramanýz sonucunda herhangi bir link bulunamadý.',
    31 => 'Bu eklenti herhangi bir sonuç döndürmedi',
    32 => 'Etkinlik',
    33 => 'URL',
    34 => 'Yer',
    35 => 'Tüm Gün',
    36 => 'Aramanýz sonucunda herhangi bir etkinlik bulunamadý.',
    37 => 'Etkinlik Arama Sonuçlarý',
    38 => 'Internet Adresleri Arama Sonuçlarý',
    39 => 'Adresler',
    40 => 'Etkinlikler',
    41 => 'Arama yapabilmeniz için en az 3 harften oluþan bir arama sorgusu girmeniz gerekmektedir.',
    42 => 'Lütfen YYYY-AA-GG (Yýl-Ay-Gün) þeklinde düzenlenmiþ bir tarhi kullanýnýz.',
    43 => 'tam cümle',
    44 => 'bütün kelimeler',
    45 => 'herhangi bir kelime',
    46 => 'Sonraki',
    47 => 'Önceki',
    48 => 'Yazar',
    49 => 'Tarih',
    50 => 'Hit',
    51 => 'Link',
    52 => 'Konum',
    53 => 'Yazý Sonuçlarý',
    54 => 'Yorum Sonuçlarý',
    55 => 'ibare',
    56 => 'VE',
    57 => 'YADA',
    58 => 'Daha fazla sonuç &gt;&gt;',
    59 => 'Sonuçlar',
    60 => 'sayfa',
    61 => 'Basit Arama'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Site Ýstatistikleri',
    2 => 'Siteye gelen toplam trafik',
    3 => 'Sitedeki Yazýlar(Yorumlar)',
    4 => 'Sitedeki Anketler(Cevaplar)',
    5 => 'Sitedeki Internet Adresleri(Gidilme Sayýsý)',
    6 => 'Sitedeki Etkinlikler',
    7 => 'Ýlk 10 Yazý',
    8 => 'Yazý Baþlýðý',
    9 => 'Okunma&nbsp;Sayýsý',
    10 => 'Sitenizde ya hiç yazý yok yada daha hiçkimse, hiçbir yazýyý okumamýþ.',
    11 => 'En Çok Yorum Alan 10 Yazý',
    12 => 'Yorum&nbsp;Sayýsý',
    13 => 'Sitenizde ya hiç yazý yok yada daha hiç kimse yazýlara yorum yazmamýþ.',
    14 => 'Ýlk 10 Anket',
    15 => 'Anket Sorusu',
    16 => 'Kullanýlan&nbsp;Oy&nbsp;Sayýsý',
    17 => 'Sitenizde ya hiç anket yok yada daha hiç kimse herhangi bir ankete oy vermemiþ.',
    18 => 'Ýlk 10 Ýnternet Adresi',
    19 => 'Adresler',
    20 => 'Kullaným&nbsp;Sayýsý',
    21 => 'Sitenizde ya hiç Ýnternet Adresi yok yada hiç kimse herhangi bir adresi kullanmamýþ.',
    22 => 'En çok e-mail ile gönderilen 10 Yazý',
    23 => 'Email&nbsp;Sayýsý',
    24 => 'Hiç kimse sitenizdeki bir yazýyý bir arkadaþýna göndermemiþ.',
    25 => 'Top 10 Trackback Commented Stories',
    26 => 'Traback iletisi yok.',
    27 => 'Aktif Kullanýcý Sayýsý',
    28 => 'Top 10 Etkinlikler',
    29 => 'Etkinlik',
    30 => 'Hitler',
    31 => 'Öyle görünüyor ki sitede yeni etkinlik yok veya henüz kimse bir etkinliðe týklamamýþ.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Ýlgili',
    2 => 'Arkadaþýna Gönder',
    3 => 'Basýlmaya Uygun Þekli',
    4 => 'Seçenekler',
    5 => 'PDF Yazý Formatý'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => '%s gönderebilmek için sisteme bir kullanýcý olarak giriþ yapmýþ olmanýz gerekiyor.',
    2 => 'Sisteme gir',
    3 => 'Yeni Kullanýcý',
    4 => 'Etkinlik Ekle',
    5 => 'Ýnternet Adresi Ekle',
    6 => 'Yazý Ekle',
    7 => 'Sisteme giriþ yapmýþ olmanýz gerekiyor',
    8 => 'Gönder',
    9 => 'Bir bilgi gönderirken, þu önerileri dikkate almanýzý rica ederiz:<ul><li>Bütün alanlarý doldurmanýz mecburidir.<li>Tam ve doðru bilgi veriniz<li>Ýnternet Adresi girerken iki kere kontrol ediniz</ul>',
    10 => 'Baþlýk',
    11 => 'Ýnternet Adresi',
    12 => 'Baþlangýç Tarihi',
    13 => 'Bitiþ Tarihi',
    14 => 'Yer',
    15 => 'Açýklama',
    16 => 'Farklý ise lütfen belirtiniz',
    17 => 'Kategori',
    18 => 'Diðer',
    19 => 'Önce Okuyun',
    20 => 'Hata: Kategori girilmemiþ',
    21 => '"Diðer"\'i seçtiðinizde lütfen kategori adýný girin',
    22 => 'Hata: Boþ alanlar var',
    23 => 'Formdaki tüm alanlarý doldurunuz. Hepsinin doldurulmasý gerekmektedir.',
    24 => 'Gönderiniz Kaydedildi',
    25 => '%s gönderiniz baþarýyla kaydedildi.',
    26 => 'Hýz Limiti',
    27 => 'Kullanýcý Acý',
    28 => 'Konu',
    29 => 'Yazý',
    30 => 'En son gönderiniz ',
    31 => " saniye önceydi. Bu sitede iki gönderi arasýnda en az {$_CONF['speedlimit']} saniye geçmesi gerekmektedir",
    32 => 'Öz Ýzleme',
    33 => 'Yazý Ön Ýzleme',
    34 => 'Sistemden çýk',
    35 => 'HTML kodlarýnýn kullanýmýna izin verilmemektedir',
    36 => 'Gönderi Tipi',
    37 => "{$_CONF['site_name']} sitesine bir etkinlik göndermeniz halinde, gönderiniz sitenin Genel Takvim'ine eklenecektir. Genel Takvimi tüm kullanýcýlar görür ve takvimde ilgilerini çeken etkinlikleri özel takvimlerine ekleyebilirler. Sitenin bu özelliði, kiþisel etkinliklerinizi (doðum günleri, veya yýldönümlerini) eklemek için <b>deðildir</b>. Etkinliði gönderdikten sonra, sitenin yönetiminin onayýna gidecektir. Onay verildikten sonra Genel Takvim'de etkinliðinizi görebilirsiniz.",
    38 => 'Etkinlik Ekle:',
    39 => 'Genel Takvim',
    40 => 'Kiþisel Takvim',
    41 => 'Bitiþ Saati',
    42 => 'Baþlangýç Saati',
    43 => 'Tüm Gün Etkinliði',
    44 => 'Adres Satýrý 1',
    45 => 'Adres Satýrý 2',
    46 => 'Þehir',
    47 => 'Ýlçe',
    48 => 'Posta Kodu',
    49 => 'Etkinlik Tipi',
    50 => 'Etkinlik Tiplerini Düzenle',
    51 => 'Yer',
    52 => 'Sil',
    53 => 'Hesap Yarat'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Sisteme Giriþ Yapmýþ Olmanýz Gerekiyor',
    2 => 'Engellendi! Sisteme Giriþ Bilgileriniz Yanlýþ',
    3 => 'Þifre kullanýcý için yanlýþ:',
    4 => 'Kullanýcý Adý:',
    5 => 'Þifre:',
    6 => 'Sitenin yönetim alanlarýnda yapýlan tüm iþlemler kaydedilir ve kontrol edilir.<br>Bu sayfa sadece yetkili kiþiler tarafýndan kullanýlabilir.',
    7 => 'sisteme giriþ yap'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Yetersiz Yönetici Haklarý',
    2 => 'Bu bloðu düzenlemek için yeterli haklara sahip deðilsiniz.',
    3 => 'Blok Düzenleyicisi',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Blok Baþlýðý',
    6 => 'Konu',
    7 => 'Tamamý',
    8 => 'Blok Güvenlik Seviyesi',
    9 => 'Blok Sýrasý',
    10 => 'Blok Tipi',
    11 => 'Portal Blok',
    12 => 'Normal Blok',
    13 => 'Portal Blok Özellikleri',
    14 => 'RDF Adresi',
    15 => 'Son RDF Deðiþikliði',
    16 => 'Normal Blok Özellikleri',
    17 => 'Blok Ýçeriði',
    18 => 'Lütfen Blok Baþlýðý, Güvenlik Seviyesi ve Ýçerik alanlarýný doldurunuz.',
    19 => 'Blok Yöneticisi',
    20 => 'Blok Baþlýðý',
    21 => 'Blok Güv. Sev.',
    22 => 'Blok Tipi',
    23 => 'Blok Sýrasý',
    24 => 'Blok Konusu',
    25 => 'Bir bloðu silmek veya deðiþtirmek istiyorsanýz, bloðun ismine basýnýz. Yeni bir blok yaratmak için yukarýdaki Yeni Blok düðmesine basýnýz.',
    26 => 'Düzenleme Bloðu',
    27 => 'PHP Blok',
    28 => 'PHP Blok Özellikleri',
    29 => 'Blok Fonksiyonu',
    30 => 'Eðer bloklarýnýzdan birinin PHP kodu kullanmasýný istiyorsanýz, PHP fonksiyonunun adýný yukarýya giriniz. Fonksiyon adýnýz "phpblock_" ile baþlamalýdýr(örn. phpblock_getweather). Eðer bu þekilde baþlamýyorsa, fonkisyonunuz çaðrýlmayacaktýr. Bunu yapmamýzýn nedeni, Geeklog sürümünü deðiþtiren insanlarýn sisteme zarar verebilecek fonksiyonlarý kullanmalarýný önlemek içindir. Fonkisyon adýndan sonra boþ parantez  "()" koymamaya dikkat edin. Son olarak, tüm PHP kodlarýnýzý /path/to/geeklog/system/lib-custom.php dosyasýna koymanýzý öneririz. Bu sayede sistemin yeni sürümünü yükleseniz bile yazdýðýný kiþisel PHP kodlarý silinmez.',
    31 => 'PHP Bloðunda hata. %s fonksiyonu yok.',
    32 => 'Hata: Eksik alan(lar)',
    33 => 'Portal Bloklarý için .rdf dosyasýna olan adresi girmeniz gerekmektedir.',
    34 => 'PHP Bloklarý için baþlýk ve fonkisyonu girmeniz gerekmektedir.',
    35 => 'Normal bloklar için baþlýk ve içeriði girmeniz gerekmektedir.',
    36 => 'Düzenleme bloðu için içerik girmelisiniz',
    37 => 'PHP Blok fonksiyonunun adý uygun deðil',
    38 => 'PHP Bloklar için çaðrýlacak fonksiyonlar \'phpblock_\' ile baþlamalýdýr (örn. phpblock_getweather). Bu ön ek herhangi bir fonksiyonun çaðrýlmasýný önlemek içindir.',
    39 => 'Kenar',
    40 => 'Sol',
    41 => 'Sað',
    42 => 'Geeklog varsayýlan bloklarý için, blok sýrasý ve güvenlik seviyesini girmelisiniz',
    43 => 'Sadece Ana Sayfa',
    44 => 'Eriþim Engellendi',
    45 => "Eriþim hakkýnýz olmayan bir yazýya eriþmek istiyorsunuz. Bu eyleminiz kayýtlara eklenmiþtir. Lütfen <a href=\"{$_CONF['site_admin_url']}/alan.php\">kontrol ana sayfasýna geri dönün</a>.",
    46 => 'Yeni Blok',
    47 => 'Kontrol Ana Sayfasý',
    48 => 'Alan Adý',
    49 => ' (boþluk kullanýlmamalý ve tek olmalý)',
    50 => 'Yardým Dosyasý Adresi',
    51 => 'http:// ile baþlayýn',
    52 => 'Bu alaný boþ býrakýrsanýz, blok ile iliþkili yardým düðmesi gösterilmeyecektir',
    53 => 'Kullanýma Açýk',
    54 => 'Kaydet',
    55 => 'Vazgeç',
    56 => 'Sil',
    57 => 'Bloðu Aþaðý Taþý',
    58 => 'Bloðu Yukarý Taþý',
    59 => 'Bloðu Saða Taþý',
    60 => 'Bloðu Sola Taþý',
    61 => 'Baþlýk Yok',
    62 => 'Yazý Limiti',
    63 => 'Geçersiz Blok Baþlýðý',
    64 => 'Baþlýðýnýz boþ olamaz ve HTML kodu içeremez!',
    65 => 'Sýra',
    66 => 'Autotaglar',
    67 => 'Autýtag izini için iþaretleyin'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Önceki Yazý',
    2 => 'Sonraki Yazý',
    3 => 'Özellikler',
    4 => 'Gönderi Þekli',
    5 => 'Yazý Düzenle',
    6 => 'Sisteme kayýtlý hiç bir yazý bulunmamakta.',
    7 => 'Yazar',
    8 => 'kaydet',
    9 => 'ön izleme',
    10 => 'vazgeç',
    11 => 'sil',
    12 => 'ID',
    13 => 'Baþlýk',
    14 => 'Konu',
    15 => 'Tarih',
    16 => 'Özet',
    17 => 'Ýçerik',
    18 => 'Toplam okunma sayýsý',
    19 => 'Yorumlar',
    20 => 'Ping',
    21 => 'Ping Gönder',
    22 => 'Yazý Listesi',
    23 => 'Bir yazýyý deðiþtirmek veya silmek istiyorsanýz, yazýnýn numarasýna basýnýz. Bir yazýyý görüntülemek istiyorsanýz, yazýnýn baþlýðýna basýnýz. Yeni bir yazý yaratmak istiyorsanýz, yukarýdaki Yeni Yazý düðmesine basýnýz.',
    24 => 'Seçtiðiniz ID kullanýlýyor. Lütfen baþka bir ID seçiniz.',
    25 => 'Yazýyý kaydederken hata oluþtu!',
    26 => 'Yazý Ön Ýzleme',
    27 => 'eðer [imageX]yerine [unscaledX] kodunu kullanýrsanýz , eklediðiniz resim orjinal boyutunda görüntülenir.',
    28 => '<p><b>ÖNÝZLEME</b>: Eðer yazýnýza bir resim eklediyseniz Önizleme yapmak yerine Taslak olarak kaydetmeniz gerekir. ÖnÝzleme seçeneði yalnýzca resim ataçlanmamýþ iken kullanýlabilir.',
    29 => 'Trackbacks',
    30 => 'Dosya Upload Hatalarý',
    31 => 'Lütfen, Yazar, Baþlýk ve Konu alanlarýný doldurunuz.',
    32 => 'Öncelikli',
    33 => 'Sadece bir tane Öncelikli yazý olabilir.',
    34 => 'Taslak',
    35 => 'Evet',
    36 => 'Hayýr',
    37 => 'Yazdýklarý:',
    38 => 'Yazýlanlar:',
    39 => 'Emailler',
    40 => 'Eriþiminiz Engellendi',
    41 => "Eriþim hakkýnýz olmayan bir yazýya eriþmek istiyorsunuz. Bu eyleminiz kayýtlara eklenmiþtir. Bu yazýya salt okunur þekilde aþaðýdan eriþebilirsiniz. Ýþiniz bittiði zaman lütfen <a href=\"{$_CONF['site_admin_url']}/story.php\">kontrol ekranýna dönünüz</a>.",
    42 => "Eriþim hakkýnýz olmayan bir yazýya eriþmek istiyorsunuz.  Bu eyleminiz kayýtlara eklenmiþtir.  Lütfen <a href=\"{$_CONF['site_admin_url']}/story.php\">kontrol ekranýna geri dönünüz</a>.",
    43 => 'Yeni Yazý',
    44 => 'Kontrol Ana Sayfasý',
    45 => 'Aç(eriþim)',
    46 => '<b>NOT:</b> eðer ileride bir tarih verirseniz, yazýnýz o tarihe kadar yayýmlanmayacaktýr. Bu ayný zamanda bu yazýnýn RDF baþlýklarýnda ve arama ve istatistik sayfalarda görüntülenmeyecektir.',
    47 => 'Resimler',
    48 => 'resim',
    49 => 'sað',
    50 => 'sol',
    51 => 'Bu resimlerden birini yazmakta olduðunuz yazýya eklemek istiyorsanýz, eklemek istediðiniz yere: [imageX], [imageX_right] veya [imageX_left] yazýn. Burada, X eklediðiniz resimin numarasýdýr. left ve right ekleri imajýn sola veya saða dayalý olarak çýkmasýna neden olur. NOT: Sadece eklediðiniz resimleri kullanabilirsiniz.  Eðer eklediðiniz resimleri kullanmazsanýz yazýnýzý kaydedemezsiniz.<BR><P><B>Ön Ýzleme</B>:  Resim eklenmiþ bir yazýyý Ön Ýzlem\'de görüntülemenin en iyi yolu: önce yazýnýzý Taslak olarak kaydetmenizdir. Bir yazýyý eðer resimleri eklenmediyse Ön Ýzleme butonunu kullanarak görüntüleyebilirsiniz.',
    52 => 'Sil',
    53 => 'kullanýlmadý. Bu resmi özet veya yazý bölümlerinden birinde kullanmadan deðiþiklikleri kaydedemezsiniz',
    54 => 'Eklenen Resimler Kullanýlmadý',
    55 => 'Aþaðýdaki hatalar yazýnýzý kaydetmeye çalýþýrken oluþtu.  Lütfen listelenen hatalarý kontrol edip düzeltiniz',
    56 => 'Sembolü Göster',
    57 => 'Ölçeksiz resim göster',
    58 => 'Yazý Yönetimi',
    59 => 'Ayar',
    60 => 'Ýzinli',
    61 => 'Auto Archive',
    62 => 'Otomatik Silme',
    63 => '',
    64 => '',
    65 => '',
    66 => '',
    67 => 'Ýçerik Düzenleme Alanýný Geniþlet',
    68 => 'Ýçerik Düzenleme Alanýný Daralt',
    69 => 'Yazý Yayým Tarihi',
    70 => 'Toolbar Seçimi',
    71 => 'Basit Toolbar',
    72 => 'Genel Toolbar',
    73 => 'Geliþmiþ Toolbar',
    74 => 'Geliþmiþ II Toolbar',
    75 => 'Full Özellikli',
    76 => 'Yayým Özellikleri',
    77 => 'Advanced Editorü çalýþtýrabilmek için Javascript gereksinimi vardýr.  config.php den gerekli ayarlarý yapabilirsiniz',
    78 => 'Click <a href="%s/story.php?mode=edit&amp;sid=%s&amp;editopt=default">here</a> to use default editor',
    79 => 'Ön Ýzleme',
    80 => 'Editör',
    81 => 'Yayým Ayarlarý',
    82 => 'Resimler',
    83 => 'Arþivleme Ayarlarý',
    84 => 'Eriþim Haklarý',
    85 => 'Tümünü Göster',
    86 => 'Geliþmiþ Editor',
    87 => 'Yazý Ýstatistikleri'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Konu Düzenle',
    2 => 'Konu Tanýmlayýcý',
    3 => 'Konu Adý',
    4 => 'Konu Resmi',
    5 => '(boþluk kullanmayýn)',
    6 => 'Bir konuyu sildiðiniz zaman o konuyla iliþkili tüm yazýlar ve bloklar silinecektir',
    7 => 'Lütfen Konu Tanýmlayýcý ve  Konu Adý alanlarýný doldurunuz',
    8 => 'Konu Yöneticisi',
    9 => 'Bir konuyu deðiþtirmek veya silmek istiyorsanýz, konunun adýna basýnýz.  Yeni bir konu yaratmak istiyorsanýz, soldaki Yeni Konu düðmesine basýnýz. Her konuya olan eriþim haklarýnýzý parantez içinde görebilirsiniz',
    10 => 'Sýralama',
    11 => 'Yazý/Sayfa',
    12 => 'Eriþim Engellendi',
    13 => "Eriþim hakkýnýz olmayan bir konuya eriþmek istiyorsunuz.  Bu eyleminiz kayýtlara eklenmiþtir. Lütfen <a href=\"{$_CONF['site_admin_url']}/topic.php\">konu kontrol ekranýna geri dönünüz</a>.",
    14 => 'Sýralama yöntemi',
    15 => 'alfabetik',
    16 => 'standart',
    17 => 'Yeni Konu',
    18 => 'Kontrol Ana Sayfasý',
    19 => 'kaydet',
    20 => 'vazgeç',
    21 => 'sil',
    22 => 'Varsayýlan',
    23 => 'bildirilen yeni yazý için bunu varsayýlan baþlýk yap',
    24 => '(*)',
    25 => 'Archive Topic',
    26 => 'Arþivlenmiþ yazýlar için geçerli baþlýk yap.Sadece bir konu izinli.',
    27 => 'Veya Konu Simgesi Upload Et',
    28 => 'EN Fazla',
    29 => 'Dosya Upload Hatalarý'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Kullanýcý Düzenle',
    2 => 'Kullanýcý Tanýmlayýcýsý',
    3 => 'Kullanýcý Adý',
    4 => 'Gerçek Adý',
    5 => 'Þifresi',
    6 => 'Güvenlik Seviyesi',
    7 => 'Email Adresi',
    8 => 'Web Sitesi',
    9 => '(boþluk kullanmayýn)',
    10 => 'Lütfen Kullanýcý Adý, Gerçek Adý, Güvenlik Seviyesi, ve Email Adresi alanlarýný doldurunuz',
    11 => 'Kullanýcý Düzenleyici',
    12 => 'Bir kullanýcýnýn bilgilerini deðiþtirmek veya silmek istiyorsanýz, kullanýcý adýna basýnýz.  Yeni bir kullanýcý yaratmak istiyorsanýz, soldaki Yeni Kullanýcý düðmesine basýnýz. Aþaðýdaki formda kullanýcý adýný, email adresini veya gerçek adýný girerek basit aramalar yapabilirsiniz (örneðin *son* or *.edu).',
    13 => 'Güvenlik Seviyesi',
    14 => 'Kayýt Tarihi',
    15 => 'Yeni Kullanýcý',
    16 => 'Kontrol Ana Sayfasý',
    17 => 'þifre deðiþtir',
    18 => 'vazgeç',
    19 => 'sil',
    20 => 'kaydet',
    21 => 'Seçtiðiniz kullanýcý adý kullanýlmakta.',
    22 => 'Hata',
    23 => 'Birden Fazla Kullanýcý Ekleme',
    24 => 'Birden Fazla Kullanýcý Ekleme',
    25 => 'Geeklog programýna birden fazla kullanýcýyý ekleyebilirsiniz. Sekme ile ayrýlmýþ bir metin dosyasýnýn içine alanlarý þu sýra ile ekleyin: gerçek adý, kullanýcý adý, email adresi.  Eklenen her kullanýcýya rasgele atanmýþ bir þifre, kullanýcýnýn email adresine gönderilecektir. Her satýra sadece bir kullanýcý adýnýn eklenmiþ olmasýna dikkat ediniz. Herhangi bir yanlýþlýkta eklenen her kullanýcýyý tek tek düzeltmek zorunda kalabilirsiniz. Bu yüzden dosyanýzý iki kere kontrol edin!',
    26 => 'Ara',
    27 => 'Sonuçlarý Sýnýrla',
    28 => 'Resmi silmek için burayý seçin',
    29 => 'Adres',
    30 => 'Dýþarýdan al',
    31 => 'Yeni Kullanýcýlar',
    32 => 'Ekleme iþlemi tamamlandý. %d kullanýcý eklendi ve %d hata oluþtu',
    33 => 'gönder',
    34 => 'Hata: Yükleme yapmak için bir dosya seçmiþ olmanýz gerekiyor.',
    35 => 'Son Giriþ',
    36 => '(asla)',
    37 => 'UID',
    38 => 'Grup Listeleniyor',
    39 => 'Þifre (tekrar)',
    40 => 'Kayýt Tarihi',
    41 => 'Son Login Tarihi',
    42 => 'Yasaklandý',
    43 => 'Aktivasyon Bekliyor',
    44 => 'Yetkilendirilme ',
    45 => 'Aktif',
    46 => 'Üye Durumu',
    47 => 'Düzenle',
    48 => 'Admin Gruplarýný Göster',
    49 => 'Admin Gruplarý',
    50 => 'Check to allow filtering this group as an Admin Use Group',
    51 => 'Online Günler',
    52 => '<br>Note: "Online Günler" Ýlk üye olunan tarih ve son giriþ tarihi arasýnda ki gün sayýsýdýr.',
    53 => 'Üye Oldu',
    54 => 'Toplu Silme',
    55 => 'Bu iþlem yalnýzca config.php de <code>$_CONF[\'lastlogin\'] = true;</code> þeklinde ayarladýðýnýzda çalýþýr',
    56 => 'Silmek istediðiniz kullanýcý tipini seçip "Listeyi Güncelle" butonuna basýnýz. Ardýndan, silmek istemediðiniz kullanýcýlarýn iþaretini kaldýrýp "Sil" butonuna basýnýz. Please note that you will only delete those that are currently visible in case the list spans over several pages.',
    57 => 'Phantom Üyeler',
    58 => 'Kýsa Süreli Üyeler',
    59 => 'Eski Üyeler',
    60 => 'Þu kadar zaman önce Üye olanlar ',
    61 => ' ay önce , fakat hiç giriþ yapmayanlar.',
    62 => 'Þu kadar zaman önce Üye olanlar  ',
    63 => ' ay önce üye olan ve 24 saat içinde giriþ yapan ancak bu tarihten sonra tekrar giriþ yapmayan üyeler.',
    64 => 'Normal Üyeler, þu kadar zamandýr siteye uðramayanlar ',
    65 => ' ay.',
    66 => 'Listeyi Güncelle',
    67 => 'Aydýr Üye',
    68 => 'Online Saatler',
    69 => 'Offline Aylar',
    70 => 'Silinemedi',
    71 => 'Baþarýyla Silindi',
    72 => 'Silinecek Üye Seçilmedi',
    73 => 'Seçtiðiniz TÜM Kullanýcýlarý silmek istediðinize emin misiniz?',
    74 => 'Son Üyeler',
    75 => 'Son Kaydolan Üyeler ',
    76 => ' ay'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Onayla',
    2 => 'Sil',
    3 => 'Deðiþtir',
    4 => 'Profil',
    10 => 'Baþlýk',
    11 => 'Baþlangýç Tarihi',
    12 => 'URL',
    13 => 'Kategori',
    14 => 'Tarih',
    15 => 'Konu',
    16 => 'Kullanýcý adý',
    17 => 'Gerçek adý',
    18 => 'Email',
    34 => 'Kontrol',
    35 => 'Eklenen Yazýlar',
    36 => 'Eklenen Adresler',
    37 => 'Eklenen Etkinlikler',
    38 => 'Gönder',
    39 => 'Onaylamanýz gereken herhangi bir eklenti yok',
    40 => 'Kullanýcýlarýn ekledikleri'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Mesaj Programý",
    2 => 'Kimden',
    3 => 'Cevaplama Adresi',
    4 => 'Konu',
    5 => 'Ýçerik',
    6 => 'Gönderim:',
    7 => 'Kullanýcý Ekle',
    8 => 'Admin',
    9 => 'Özellikler',
    10 => 'HTML',
    11 => 'Acil Mesaj!',
    12 => 'Gönder',
    13 => 'Temizle',
    14 => 'Kullanýcý ayarlarýný dikkate alma',
    15 => 'Kullanýcý(lar)a gönderilemiyor: ',
    16 => 'Kullanýcý(lar)a baþarýyla gönderildi: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Bir mesaj daha gönder</a>",
    18 => 'Kime',
    19 => 'NOT: eðer bütün site üyelerine mesaj göndermek istiyorsanýz, seçim listesinden Sitedeki Kullanýcýlar grubunu seçiniz.',
    20 => "<successcount> mesaj baþarýyla gönderildi ama <failcount> mesajýn gönderilmesinde sorun çýktý. Her gönderme denemesinin ayrýntýlarý aþaðýda bulunmaktadýr. <a href=\"{$_CONF['site_admin_url']}/mail.php\">Baþka bir mesaj gönderebilir</a>, veya <a href=\"{$_CONF['site_admin_url']}/moderation.php\">Kontrol Ana Sayfasý</a>na geri dönebilirisiniz.",
    21 => 'Baþarýsýz',
    22 => 'Baþarýlý',
    23 => 'Baþarýsýz olan gönderim yok',
    24 => 'Baþarýlý olan gönderim yok',
    25 => '-- Grup seçin --',
    26 => 'Lütfen formun tüm alanlarýný doldurun ve þeçim listesinden bir kullanýcý grubu seçin.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Sisteme eklenti (plug-in) yükleyerek Geeklog\'un çalýþmasýný ve belki sisteminizi bozabilirsiniz. Sadece <a href="http://www.geeklog.net" target="_blank">Geeklog Ana Sayfasý</a>\'ndan yüklediðiniz eklentileri yüklemeniz tavsiye edilir, çünkü bize ulaþan tüm eklentileri çeþitli iþletim sistemleriyle ayrýntýlý testlere sokuyoruz. Özellikle üçüncü firmalardan yüklediðiniz eklentilerin yüklenirken sisteminize zarar verebilecek programlar çalýþtýrabileceðini ve bunlarýn güvenlik açýklarýna neden olabileceðini anlamanýz önemlidir. Bu uyarýya raðmen, biz bu eklentinin yüklenmesinin baþarýyla tamamlanacaðýný garanti etmiyoruz, ve sisteminizde doðacak herhangi bir hasardan dolayý sorumluluk kabul etmiyoruz. Baþka bir deyiþle eklentiyi yüklerken doðacak tüm riskler size aittir.  Ayrýntýlarý öðrenmek isteyenler için her eklenti paketinde yüklemenin el ile yapýlabilmesi için ayrýntýlar ve adýmlar mevcuttur.',
    2 => 'Eklenti Yükleme ile Ýlgili Yükümler',
    3 => 'Eklenti Yükleme Formu',
    4 => 'Eklenti Dosyasý',
    5 => 'Eklenti Listesi',
    6 => 'Uyarý: Eklenti zaten yüklenmiþ!',
    7 => 'Yüklemeye çalýþtýðýnýz eklenti zaten yüklenmiþ. Eðer yeniden yüklemek istiyorsanýz, eklentiyi önce silin.',
    8 => 'Eklenti uyumluluk kontrolü baþarýsýz.',
    9 => 'Bu eklenti Geeklog\'un yeni bir versiyonun istemekte. Elinizdeki kopyayý ya <a href="http://www.geeklog.net">Geeklog</a> adresinden yenileyin ya da eklentinin yeni bir versiyonunu bulmalýsýnýz.',
    10 => '<br><b>Þu anda hiç bir eklenti yüklenmemiþ.</b><br><br>',
    11 => 'Bir eklentiyi deðiþtirmek veya silmek istiyorsanýz eklentinin numarasýna basýn. Eklenti hakkýnda daha fazla bilgi edinmek için eklentinin adýna basýn. Bu eklentinin web sitesini açar. Bir eklenti yüklemek veya sürümünü yenilemek için dokümantasyonuna baþvurun.',
    12 => 'plugineditor()\'e hiç bir eklenti adý saðlanmadý',
    13 => 'Eklenti Düzenle',
    14 => 'Yeni Eklenti',
    15 => 'Kontrol Ana Sayfasý',
    16 => 'Eklenti Adý',
    17 => 'Eklenti Sürümü',
    18 => 'Geeklog Sürümü',
    19 => 'Kullanýmda',
    20 => 'Evet',
    21 => 'Hayýr',
    22 => 'Yükle',
    23 => 'Kaydet',
    24 => 'Vazgeç',
    25 => 'Sil',
    26 => 'Eklenti adý',
    27 => 'Eklenti Web Sitesi',
    28 => 'Eklenti Sürümü',
    29 => 'Geeklog Sürümü',
    30 => 'Eklentiyi Sil?',
    31 => 'Bu eklentiyi silmek istediðinizden eminmisiniz? Bunu yaparsanýz eklentinin kullandýðý tüm veriler ve veri yapýlarý da silinecektir. Eminseniz Sil düðmesine bir daha basýnýz.',
    32 => '<p><b>Hata: AutoLink tag doðru formatta deðil</b></p>',
    33 => 'Yazýlým versionu',
    34 => 'Güncelle',
    35 => 'Düzenle',
    36 => 'Code',
    37 => 'Data',
    38 => 'Güncelle!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'Oluþtur feed',
    2 => 'Kaydet',
    3 => 'Sil',
    4 => 'Vazgeç',
    10 => 'Content Syndication',
    11 => 'Yeni Feed',
    12 => 'Admin Home',
    13 => 'Bir feedi silmek veya düzenlemek için , aþaðýdaki feed\'in  baþlýðýna týklayýn. Yeni bir feed oluþturmak için , yukarýda ki Yeni Feed e týklayýn.',
    14 => 'Baþlýk',
    15 => 'Tip',
    16 => 'Dosya Adý',
    17 => 'Format',
    18 => 'Son Güncelleme',
    19 => 'Ýzinli',
    20 => 'Evet',
    21 => 'Hyýr',
    22 => '<i>(feed yok)</i>',
    23 => 'Tüm Yazýlar',
    24 => 'Feed Düzenleyici',
    25 => 'Feed Baþlýðý',
    26 => 'Limit',
    27 => 'Giriþ uzunluðu',
    28 => '(0 = no text, 1 = full text, other = limit to that number of chars.)',
    29 => 'Açýklama',
    30 => 'Son Güncelleme',
    31 => 'Karakter Set',
    32 => 'Dil',
    33 => 'Ýçerik',
    34 => 'Entries',
    35 => 'Saat',
    36 => 'feedin Tipini seçin',
    37 => 'You have at least one plugin installed that supports content syndication. Below you will need to select whether you want to create a Geeklog feed or a feed from one of the plugins.',
    38 => 'Hata: Boþ Býrakýlan Alanlar',
    39 => 'Lütfen Feed Baþlýðý, Açýklama ve Dosya Adý alanlarýný doldurunuz.',
    40 => 'Lütfen bir sayý girin of entries or number of Saat.',
    41 => 'Linkler',
    42 => 'Etkinlikler',
    43 => 'Hepsi',
    44 => 'Hiçbirisi',
    45 => 'Header-link in topic',
    46 => 'Sonuç Limiti',
    47 => 'Arama',
    48 => 'Düzenle',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})",
    51 => 'The filename you have chosen is already used by another feed. Please choose a different one.',
    52 => 'HATA: Bu Dosya Adý var'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Þifreniz email adresinize gönderilmiþtir. Lütfen, email adresinize gelen mesajdaki adýmlarý uygulayýn. (Eðer Þifreniz elinize ulaþmadýysa lütfen Junk-Bulk Mail Klasörünüzü kontrol edin) {$_CONF['site_name']} kullandýðýnýz için teþekkür ederiz.",
    2 => 'Yazýnýzý sitemize gönderdiðiniz için teþekkür ederiz.  Yazýnýz, site yönetimi tarafýndan onaylandýktan sonra yayýmlanacaktýr.',
    3 => "Ýnternet adresini sitemize gönderdiðiniz için teþekkür ederiz. Adresiniz, site yönetimi tarafýndan onaylandýktan sonra yayýmlanacaktýr. Onaylandýktan sonra gönderdiðiniz adresi<a href={$_CONF['site_url']}/links.php>Adresler</a> bölümünde görebilirsiniz.",
    4 => "Sitemize eklediðiniz etkinlik için teþekkür ederiz.  Gönderdiðiniz etkinlik, site yönetimi tarafýndan onaylandýktan sonra yayýmlanacaktýr. Onaylandýktan sonra <a href={$_CONF['site_url']}/calendar.php>takvim</a> bölümünde görebilirsiniz.",
    5 => 'Kayýt bilgileriniz baþarýlý bir þekilde kaydedildi.',
    6 => 'Görünüm ayarlarýnýz baþarýlý bir þekilde kaydedildi.',
    7 => 'Yorum tercihleriniz baþarýlý bir þekilde kaydedildi.',
    8 => 'Sistemden baþarýyla çýktýnýz.',
    9 => 'Yazýnýz baþarýyla kaydedildi.',
    10 => 'Yazýnýz baþarýyla silindi.',
    11 => 'Bloðunuz baþarýyla kaydedildi.',
    12 => 'Bloðunuz baþarýyla silindi.',
    13 => 'Konunuz baþarýyla kaydedildi.',
    14 => 'Konunuz ve bütün yazýlarý ve alanlarý baþarýyla silindi.',
    15 => 'Internet Adresiniz baþarýyla kaydedildi.',
    16 => 'Internet Adresiniz baþarýyla silindi.',
    17 => 'Etkinliðiniz baþarýyla kaydedildi.',
    18 => 'Etkinliðiniz baþarýyla silindi.',
    19 => 'Anketiniz baþarýyla kaydedildi.',
    20 => 'Anketiniz baþarýyla silindi.',
    21 => 'Yeni kullanýcý baþarýyla kaydedildi.',
    22 => 'Yeni kullanýcý baþarýyla silindi.',
    23 => 'Takviminize etkinlik eklerken sorun oluþtu. Etkinlik tanýmlayýcýsý tanýmlanmamýþ.',
    24 => 'Takviminize etkinlik baþarýyla eklendi.',
    25 => 'Sisteme giriþ yapmadan kiþisel takviminizi açamazsýnýz.',
    26 => 'Kiþisel takviminizden etkinlik baþarýyla silinmiþtir.',
    27 => 'Mesaj baþarýlya iletildi.',
    28 => 'Eklenti baþarýyla eklendi.',
    29 => 'Üzgünüm, kiþisel takvimler bu sitede kullanýlamýyor.',
    30 => 'Eriþim Engellendi',
    31 => 'Yazý kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    32 => 'Konu kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    33 => 'Blok kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    34 => 'Internet Adresi kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    35 => 'Etkinlik kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    36 => 'Anket kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    37 => 'Kullanýcý kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    38 => 'Eklenti kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    39 => 'Mesaj kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    40 => 'Sistem Mesajý',
    41 => 'Kelime deðiþtirme sayfasýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    42 => 'Kelimeniz baþarýyla kaydedildi.',
    43 => 'Kelimeniz  baþarýyla silindi.',
    44 => 'Eklenti baþarýlya yüklendi!',
    45 => 'Eklenti baþarýyla silindi.',
    46 => 'Veri tabaný yedekleme programýna eriþimiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.',
    47 => 'Bu özellik sadece Linux, Unix gibi iþletim sistemlerinde çalýþýr.  Eðer Linux, Unix gibi bir iþletim sistemi kullanýyorsanýz, önbelleðiniz baþarýyla temizlenmiþtir. Eðer Windows kullanýyorsanýz, adodb_*.php  dosyalarýný aratýn ve silin.',
    48 => "{$_CONF['site_name']} sitesine üyelik baþvurunuz için teþekkür ederiz. Site yönetimi baþvurunuzu inceleyecektir. Eðer kabul alýrsanýz þifreniz belirttiðiniz eðmail adreisne gönderilecektir.",
    49 => 'Grubunuz baþarýyla kaydedildi.',
    50 => 'Grup baþarýyla silindi.',
    51 => 'Bu kullanýcý adý zaten kullanýlýyor. Lütfen baþka bir tane seçin.',
    52 => 'Saðlanan email adresi geçerli bir email adresi olarak gözükmüyor.',
    53 => 'Yeni þifreniz kabul edildi. Lütfen aþaðýdan yeni þifrenizi kullanarak þimdi giriþ yapýn.',
    54 => 'Yeni bir þifre isteme süreniz doldu. Lütfen aþaðýdan tekrar deneyin.',
    55 => 'Size bir email gönderildi ve az önce yerine ulaþtý. Hesabýnýza yeni bir þifre tayin etmek için mesajdaki talimatlarý lütfen takip ediniz.',
    56 => 'Saðlanan email adresi zaten baþka bir hesap tarafýndan kullanýlýyor.',
    57 => 'Hesabýnýz baþarýyla silindi.',
    58 => 'Your feed baþarýyla kaydedildi.',
    59 => 'The feed baþarýyla silindi.',
    60 => 'Eklenti baþarýyla güncellendi',
    61 => 'Plugin %s: Unknown message placeholder',
    62 => 'Trackback iletisi silindi.',
    63 => 'Trackback iletisi silinirken hata oluþtu.',
    64 => 'Trackback iletiniz baþarýyla gönderildi.',
    65 => 'Weblog dizin servisi baþarýyla saved.',
    66 => 'Weblog dizin servisi  silindi.',
    67 => 'Yeni þifreniz does not match the confirmation password!',
    68 => 'You have to enter the correct current password.',
    69 => 'Üyeliðiniz Bloke edildi!',
    70 => 'Üyeliðiniz yönetici onayý bekliyor.',
    71 => 'Üyeliðiniz teyid edildi ve yönetici onayý bekliyor.',
    72 => 'Eklenti kurulumunda hata oluþtu. Ayrýntýlar için  error.log dosyasýna bakýnýz.',
    73 => 'Eklenti kaldýrýlýrken bir hata oluþtu. Ayrýntýlar için  error.log dosyasýna bakýnýz',
    74 => 'pingback baþarýyla gönderildi.',
    75 => 'Trackbacklar POST sorgulamasý gerektirmektedir.',
    76 => 'Bu Öðeyi gerçekten silmek istiyor musunuz?',
    77 => 'DÝKKAT:<br>Geçerli dil kodlamanýz UTF-8 dir. Ancak, serverýnýz bu kodlamayý desteklememektedir. Lütefen PHP için mbstring fonsiyonunu kurunuz veya farklý bir dil kodlamasý/dil seçiniz.',
    78 => 'Girdiðiniz iki mail adresininde ayný olduðuna emin olun.',
    79 => 'The page you have been trying to open refers to a function that no longer exists on this site.',
    80 => 'The plugin that created this feed is currently disabled. You will not be able to edit this feed until you re-enable the parent plugin.',
    81 => 'You may have mistyped your login credentials.  Lütfen yeniden giriþ yapmayý deneyin.',
    82 => 'Ýzin verilen giriþ sayýsýný aþtýnýz.  Lütfen daha sonra tekrar deneyin.',
    83 => 'Þifrenizi, e-mail adresini deðiþtirmek veya ne sistemin þifrenizi kadar hatýrlayacaðýný belirlemek için lütfen þifrenizi girin.',
    84 => 'Hesabýnýza silmek için þifrenizi giriniz.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Eriþim',
    'ownerroot' => 'Sahibi/Root',
    'group' => 'Grup',
    'readonly' => 'Salt Okunur',
    'accessrights' => 'Eriþim Haklarý',
    'owner' => 'Sahibi',
    'grantgrouplabel' => 'Yukarýdaki Grup Deðiþtirme Haklarýna Ýzin Ver',
    'permmsg' => 'NOT: Üyeler bu sitenin, siteye girmiþ olan üyelerine denir, ve Herhangi ise sitede bulundan ama siteye giriþ yapmamýþ herhangi bir kullanýcýya denir.',
    'securitygroups' => 'Güvenlik Gruplarý',
    'editrootmsg' => "Kullanýcý Yöneticisi olmanýza raðmen root kullanýcýsýný, root kullanýcýsý olmadan deðiþtiremezsiniz. Root kullanýcýsý dýþýnda herhangi bir kullanýcýyý deðiþtirebiliriniz. Root kullanýcýsýna olan izinsiz tüm etkinlikler kaydedilmektedir. Lütfen <a href=\"{$_CONF['site_admin_url']}/user.php\">Kullarnýcý Kontrol Sayfasý</a>'na geri dönün.",
    'securitygroupsmsg' => 'Kullanýcýnýn bulunmasýný istediðiniz gruplarý lütfen seçiniz.',
    'groupeditor' => 'Grup Düzenleyicisi',
    'description' => 'Taným',
    'name' => 'Ad',
    'rights' => 'Haklar',
    'missingfields' => 'Eksik Bloklar',
    'missingfieldsmsg' => 'Gruba bir Ad ve Taným vermelisiniz.',
    'groupmanager' => 'Grup Düzenleyicisi',
    'newgroupmsg' => 'Bir grubu deðiþtirmek veya silmek istiyorsanýz, grubun adýna basýnýz. Yeni bir grup yaratmak için yukarýdan Yeni Grup düðmesine basýnýz. Sistem tarafýndan yaratýlmýþ temel gruplar sistem tarafýndan kullanýldýðý için silinemez.',
    'groupname' => 'Grup Adý',
    'coregroup' => 'Temel Grubu',
    'yes' => 'Evet',
    'no' => 'Hayýr',
    'corerightsdescr' => "Bu grup bir temel {$_CONF['site_name']} grubudur.  Bu nedenden bu grubun eriþim haklarý deðiþtirlemez. Aþaýðda bu grubun hangi haklara sahip olduðunun listesi bulunmaktadýr.",
    'groupmsg' => 'Bu sitede kullanýlan güvenlik gruplarý hiyerarþiktir. Bir grubu bu gruba ekleyerek bu grubun sahip olduðu eriþim haklarýyla ayný eriþim haklarýný eklediðiniz gruba vermiþ olursunuz. Bir gruba güvenlik haklarý vermek için aþaðýdaki gruplarý kullanarak gruplar oluþturmaný önerilir. Eðer bir gruba özel haklar vermek istiyorsanýz, aþaðýdaki \'Haklar\' bölümünden istediðiniz özellikleri seçebilirsiniz. Bu grubu bir baþka grup(lar)ýn altýna eklemek için sadece aþaðýdaki gruplardan istediklerinizi seçin.',
    'coregroupmsg' => "Bu grup bir temel {$_CONF['site_name']} grubudur.  Bu yüzden bu grubun bulunduðu gruplar deðiþtirilemez. Bu grubun bulunduðu gruplarýn salt okunur listesi aþaðýdadýr.",
    'rightsdescr' => 'Bir grubun bir eriþim hakký buradan verilebilir veya grubun bir üst grubu varsa o gruba verilerek bu gurubun almasý saðlanabilinir. Aþaðýda eðer seçme kutusu olmayan haklar varsa bunlar bu grubun üyesi olduðu bir üst gruba verilmiþ olan haklardýr. Seçme kutusu olan haklarý seçerek bu gruba daha geniþ bir hak verebilirsiniz.',
    'lock' => 'Kilit',
    'members' => 'Üyeler',
    'anonymous' => 'Ýsimsiz Kullanýcý',
    'permissions' => 'Ýzinler',
    'permissionskey' => 'R = oku, E = düzenle, haklarda deðiþiklik yap',
    'edit' => 'Deðiþtir',
    'none' => 'Hiçbiri',
    'accessdenied' => 'Eriþim Engellendi',
    'storydenialmsg' => "Bu yazýyý okuma yetkiniz yok. Bunun nedeni {$_CONF['site_name']} sitesinin bir üyesi olmamanýzdan kaynaklanýyor olabilir. Lütfen {$_CONF['site_name']} sitesinin <a href=users.php?mode=new> üyesi olun</a> ve sadece üyelere verilen haklara kavuþun!",
    'nogroupsforcoregroup' => 'Bu grup bir baþka gruba daðil deðil.',
    'grouphasnorights' => 'Bu grup, sitenin hiç bir yönetimsel özelliklerine sahip deðil.',
    'newgroup' => 'Yeni Grup',
    'adminhome' => 'Kontrol Ana Sayfasý',
    'save' => 'kaydet',
    'cancel' => 'vazgeç',
    'delete' => 'sil',
    'canteditroot' => 'Root grubu deðiþtirmeye çalýþtýnýz, fakat root grubun bir üyesi deðilsiniz. Bu nedenden eriþiminiz engellendi. Eðer bunun bir hata olduðunu düþünüyorsanýz sistem yöneticinize danýþýn.',
    'listusers' => 'Üye Listesi',
    'listthem' => 'liste',
    'usersingroup' => 'Üye grubu %s',
    'usergroupadmin' => 'User Group Yönetimi',
    'add' => 'Ekle',
    'remove' => 'Kaldýr',
    'availmembers' => 'Available Kullanýcýlar',
    'groupmembers' => 'Grup Üyeleri',
    'canteditgroup' => 'Bu gurubu düzenleyebilmek için, bu grubum bir üyesi olmalýsýnýz. Please contact the system administrator if you feel this is an error.',
    'cantlistgroup' => 'To see the members of this group, you have to be a member yourself. Please contact the system administrator if you feel this is an error.',
    'editgroupmsg' => 'To modify the group membership, click on the member names(s) and use the add or remove buttons. If the member is a member of the group, their name will appear on the right side only. Once you are complete - press <b>Save</b> to update the group and return to the main group admin page.',
    'listgroupmsg' => 'Listing of all current members in the group: <b>%s</b>',
    'search' => 'Ara',
    'submit' => 'Submit',
    'limitresults' => 'Limit Results',
    'group_id' => 'Grup ID',
    'plugin_access_denied_msg' => 'Yönetim sayfasýna yetkisiz olarak girmeye çalýþtýnýz.  Ip numaranýz ve Adýnýz Kaydedildi.',
    'groupexists' => 'Grup adý Kullanýlýyor',
    'groupexistsmsg' => 'Seçtiðiniz grup adý kullanýlýmda, baþka bir grup adý seçiniz.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Son 10 yedekleme',
    'do_backup' => 'Yedekleme Yap',
    'backup_successful' => 'Veritabaný yedeklemesi baþarýyla sonuçlandý.',
    'db_explanation' => 'Geeklog sisteminin yeni bir yedeðini almak için, aþaðýdaki butona basýn.',
    'not_found' => "Hatalý adres veya mysqldump programý çalýþtýrýlýnamýyor.<br>config.php dosyanýzdaki <strong>\$_DB_mysqldump_path</strong> deðiþkenini kontrol edin.<br>Deðiþken þu anki deðeri: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Yedekleme baþarýsýz: Dosya boyutu 0 bayt idi.',
    'path_not_found' => "{$_CONF['backup_path']} adresi yok veya bir klasör deðil",
    'no_access' => "HATA: Kalsör {$_CONF['backup_path']} eriþilinemiyor.",
    'backup_file' => 'Yedek dosyasý',
    'size' => 'Boyut',
    'bytes' => 'Bayt',
    'total_number' => 'Toplam backup sayýsý: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Ana Sayfa',
    2 => 'Ýletiþim',
    3 => 'Yazý Yazýn',
    4 => 'Adresler',
    5 => 'Anketler',
    6 => 'Takvim',
    7 => 'Site Ýstatistikleri',
    8 => 'Özelleþtir',
    9 => 'Ara',
    10 => 'Geliþmiþ Arama',
    11 => 'Dizin'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Hatasý',
    2 => 'Üff, her yere baktým ama <b>%s</b> bulamadým.',
    3 => "<p>Üzgünüz, belirttiðiniz dosya bulunamýyor. Lütfen <a href=\"{$_CONF['site_url']}\">ana sayfa</a>ya veya <a href=\"{$_CONF['site_url']}/search.php\">arama sayfasý</a>'na bakarak kaybettiðiniz dokümaný bulabilecekmisiniz bir bakýn."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Sisteme giriþ yapmanýz gerekiyor',
    2 => 'Üzgünüm, bu alana giriþ yapabilmeniz için bir kullanýcý olarak giriþ yapmanýz gerekiyor.',
    3 => 'Giriþ yap',
    4 => 'Yeni Kullanýcý'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'PDF özelliði kapatýldý',
    2 => 'The document provided was not rendered. The document was received but could not be processed.  Please make sure to submit only html formatted documents that have been written to the xHTML standard. Please note that overly complex html documents may not render correctly or at all.The document resulting from your attempt was 0 bytes in length, and has been silindi. If you\'re sure that your document should render fine, please re-submit it.',
    3 => 'Unknown error during PDF generation',
    4 => "No page data was given or you want to use the ad-hoc PDF generation tool below.  If you think you are getting this page\n          in error then please contact the system administrator.  Otherwise, you may use the form below to generate PDF's in an ad-hoc fashion.",
    5 => 'Yükleniyor .',
    6 => 'Please wait while your document is loaded.',
    7 => 'You may right click the button below and choose \'save target...\' or \'save link location...\' to save a copy of your document.',
    8 => "The path given in the configuration file to the HTMLDoc binary is invalid or this system cannot execute it.  Please contact the site administrator if this problem\n          persists.",
    9 => 'PDF Generator',
    10 => "This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This\n           is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site",
    11 => 'URL',
    12 => 'PDF Oluþtur!',
    13 => 'The PHP configuration on this server does not allow URLs to be used with the fopen() command.  The system administrator must edit the php.ini file and set allow_url_fopen to On',
    14 => 'The PDF you requested either does not exist or you tried to illegally access a file.'
);

###############################################################################
# trackback.php

$LANG_TRB = array(
    'trackback' => 'Trackback',
    'from' => 'Kimden',
    'tracked_on' => 'Tracked on',
    'read_more' => '[devamýný oku]',
    'intro_text' => 'Here\'s what others have to say about \'%s\':',
    'no_comments' => 'Trackback iletisi yok.',
    'this_trackback_url' => 'Bu yazý için Trackback URL si:',
    'num_comments' => '%d trackback iletileri',
    'send_trackback' => 'Ping Gönder',
    'preview' => 'Ön Ýzleme',
    'editor_title' => 'trackback comment',
    'trackback_url' => 'Trackback URL',
    'entry_url' => 'Entry URL',
    'entry_title' => 'Entry Title',
    'blog_name' => 'Site Name',
    'excerpt' => 'Excerpt',
    'truncate_warning' => 'Note: The receiving site may truncate your excerpt',
    'button_send' => 'Gönder',
    'button_preview' => 'Öz Ýzleme',
    'send_error' => 'Error',
    'send_error_details' => 'Error when sending trackback comment:',
    'url_missing' => 'No Entry URL',
    'url_required' => 'Please enter at least a URL for the entry.',
    'target_missing' => 'Trackback URL si YOK',
    'target_required' => 'Lütfen bir trackback URL si giriniz',
    'error_socket' => 'Could not open socket.',
    'error_response' => 'Response not understood.',
    'error_unspecified' => 'Unspecified error.',
    'select_url' => 'Trackback URLsi Seçiniz',
    'not_found' => 'Trackback URL not found',
    'autodetect_failed' => 'Geeklog could not detect the Trackback URL for the post you want to Gönder your comment to. Please enter it manually below.',
    'trackback_explain' => 'From the links below, please select the URL you want to Gönder your Trackback comment to. Geeklog will then try to determine the correct Trackback URL for that post. Or you can <a href="%s">enter it manually</a> if you know it already.',
    'no_links_trackback' => 'No links found. You can not Gönder a Trackback comment for this entry.',
    'pingback' => 'Pingback',
    'pingback_results' => 'Pingback results',
    'send_pings' => 'Gönder Pings',
    'send_pings_for' => 'Gönder Pings for "%s"',
    'no_links_pingback' => 'No links found. No Pingbacks were sent for this entry.',
    'pingback_success' => 'Pingback sent.',
    'no_pingback_url' => 'No pingback URL found.',
    'resend' => 'ReGönder',
    'ping_all_explain' => 'You can now notify the sites you linked to (<a href="http://en.wikipedia.org/wiki/Pingback">Pingback</a>), advertise that your site has been updated by pinging weblog directory services, or Gönder a <a href="http://en.wikipedia.org/wiki/Trackback">Trackback</a> comment in case you wrote about a post on someone else\'s site.',
    'pingback_button' => 'Gönder Pingback',
    'pingback_short' => 'Gönder Pingbacks to all sites linked from this entry.',
    'pingback_disabled' => '(Pingback disabled)',
    'ping_button' => 'Gönder Ping',
    'ping_short' => 'Ping weblog directory services.',
    'ping_disabled' => '(Ping disabled)',
    'trackback_button' => 'Gönder Trackback',
    'trackback_short' => 'Gönder a Trackback comment.',
    'trackback_disabled' => '(Trackback disabled)',
    'may_take_a_while' => 'Please note that Göndering Pingbacks and Pings may take a while.',
    'ping_results' => 'Ping results',
    'unknown_method' => 'Unknown ping method',
    'ping_success' => 'Ping sent.',
    'error_site_name' => 'Please enter the site\'s name.',
    'error_site_url' => 'Please enter the site\'s URL.',
    'error_ping_url' => 'Please enter a valid Ping URL.',
    'no_services' => 'No weblog directory services configured.',
    'services_headline' => 'Weblog Directory Services',
    'service_explain' => 'To modify or delete a weblog directory service, click on the edit icon of that service below. To add a new weblog directory service, click on "Create New" above.',
    'service' => 'Service',
    'ping_method' => 'Ping method',
    'service_website' => 'Website',
    'service_ping_url' => 'URL to ping',
    'ping_standard' => 'Standard Ping',
    'ping_extended' => 'Extended Ping',
    'ping_unknown' => '(unknown method)',
    'edit_service' => 'Edit Weblog Directory Service',
    'trackbacks' => 'Trackbacks',
    'editor_intro' => 'Prepare your trackback comment for <a href="%s">%s</a>.',
    'editor_intro_none' => 'Prepare your trackback comment.',
    'trackback_note' => 'To Gönder a trackback comment for a story, go to the list of stories and click on "Gönder Ping" for the story. To Gönder a trackback that is not related to a story, <a href="%s">click here</a>.',
    'pingback_explain' => 'Enter a URL to Gönder the Pingback to. The pingback will point to your site\'s homepage.',
    'pingback_url' => 'Pingback URL',
    'site_url' => 'This site\'s URL',
    'pingback_note' => 'To Gönder a pingback for a story, go to the list of stories and click on "Gönder Ping" for the story. To Gönder a pingback that is not related to a story, <a href="%s">click here</a>.',
    'pbtarget_missing' => 'No Pingback URL',
    'pbtarget_required' => 'Please enter a pingback URL',
    'pb_error_details' => 'Error when Göndering the pingback:',
    'delete_trackback' => 'To delete this Trackback click: '
);

###############################################################################
# directory.php

$LANG_DIR = array(
    'title' => 'Article Dizini',
    'title_year' => ' %d için Article Dizini',
    'title_month_year' => ' %s %d için Article Dizini',
    'nav_top' => 'Article Dizinine Geri Dön',
    'no_articles' => 'Articles Yok.'
);

###############################################################################
# "What's New" Time Strings
# 
# For the first two strings, you can use the following placeholders.
# Order them so it makes sense in your language:
# %i    item, "Stories"
# %n    amount, "2", "20" etc.
# %t    time, "2" (weeks)
# %s    scale, "hrs", "weeks"

$LANG_WHATSNEW = array(
    'new_string' => '%n yeni %i in the last %t %s',
    'new_last' => 'son %t %s',
    'minutes' => 'dakikalar',
    'hours' => 'saatler',
    'days' => 'günler',
    'weeks' => 'haftalar',
    'months' => 'aylar',
    'minute' => 'dakika',
    'hour' => 'saat',
    'day' => 'gün',
    'week' => 'hafta',
    'month' => 'ay'
);

###############################################################################
# Month names

$LANG_MONTH = array(
    1 => 'Ocak',
    2 => 'Þubat',
    3 => 'Mart',
    4 => 'Nisan',
    5 => 'Mayýs',
    6 => 'Haziran',
    7 => 'Temmuz',
    8 => 'Aðustos',
    9 => 'Eylül',
    10 => 'Ekim',
    11 => 'Kasým',
    12 => 'Aralýk'
);

###############################################################################
# Weekdays

$LANG_WEEK = array(
    1 => 'Pazar',
    2 => 'Pazartesi',
    3 => 'Salý',
    4 => 'Çarþamba',
    5 => 'Perþembe',
    6 => 'Cuma',
    7 => 'Cumartesi'
);

###############################################################################
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array(
    'search' => 'Arama',
    'limit_results' => 'Sonuç Limiti',
    'submit' => 'Gönder',
    'edit' => 'Düzenle',
    'edit_adv' => 'Glþmþ.Düzenleme',
    'admin_home' => 'Yönetim AnaSayfa',
    'create_new' => 'Yeni Oluþtur',
    'create_new_adv' => 'Yeni Oluþtur(Glþmþ.)',
    'enabled' => 'Ýzinli',
    'title' => 'Baþlýk',
    'type' => 'Tip',
    'topic' => 'Konu',
    'help_url' => 'Yardým Dosyasý URL',
    'save' => 'Kaydet',
    'cancel' => 'Vazgeç',
    'delete' => 'Sil',
    'delete_sel' => 'Seçileni Sil',
    'copy' => 'Kopyala',
    'no_results' => '- Giriþ Bulunumadý -',
    'data_error' => 'Veriniz iþlenirken bir hata oluþtu. Lütfen veri kaynaðýný kontrol edin.',
    'preview' => 'ÖnÝzleme',
    'records_found' => 'Kayýt Bulundu'
);

###############################################################################
# Localisation of the texts for the various drop-down menus that are actually
# stored in the database. If these exist, they override the texts from the
# database.

$LANG_commentcodes = array(
    0 => 'Yorum Ekleme Ýzinsiz',
    -1 => 'Yorum Ekleme Ýzinli'
);


$LANG_commentmodes = array(
    'flat' => 'Alt Alta',
    'nested' => 'Ýç Ýçe',
    'threaded' => 'Threaded',
    'nocomment' => 'Yorum Gösterme'
);

$LANG_cookiecodes = array(
    0 => '(don\'t)',
    3600 => '1 Saat',
    7200 => '2 Saat',
    10800 => '3 Saat',
    28800 => '8 Saat',
    86400 => '1 Gün',
    604800 => '1 Hafta',
    2678400 => '1 Ay'
);

$LANG_dateformats = array(
    0 => 'Sistem Default'
);

$LANG_featurecodes = array(
    0 => 'Önceliksiz',
    1 => 'Öncelikli'
);

$LANG_frontpagecodes = array(
    0 => 'Sadece Konularda Göster',
    1 => 'Anasayfada Göster'
);

$LANG_postmodes = array(
    'plaintext' => 'Text Formatlý',
    'html' => 'HTML Formatlý'
);

$LANG_sortcodes = array(
    'ASC' => 'Önce Eskiler',
    'DESC' => 'Önce Yeniler'
);

$LANG_trackbackcodes = array(
    0 => 'Trackback Ýzinli',
    -1 => 'Trackback Ýzinsiz'
);

?>
