<?php

###############################################################################
# turkish.php
# This is the turkish language page for GeekLog!
# Special thanks to Mischa Polivanov for his work on this project
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
# - root (user)
###############################################################################

$LANG_CHARSET = "iso-8859-9";

###############################################################################
# Array Format:
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
	1 => "Ekleyen:",
	2 => "devamý",
	3 => "yorum",
	4 => "Deðiþtir",
	5 => "Oy Kullan",
	6 => "Sonuçlar",
	7 => "Anket Sonuçlarý",
	8 => "oy",
	9 => "Yönetici kontrolleri:",
	10 => "Gönderilenler",
	11 => "Yazýlar",
	12 => "Bloklar",
	13 => "Konular",
	14 => "Internet Adresleri",
	15 => "Etkinlikler",
	16 => "Anketler",
	17 => "Kullanýcýlar",
	18 => "SQL Sorgusu",
	19 => "Sistemden Çýk",
	20 => "Kullanýcý Bilgileri:",
	21 => "Kullanýcý Adý",
	22 => "Kullanýcý Tanýmlayýcýsý",
	23 => "Güvenlik Seviyesi",
	24 => "Ýsimsiz Kullanýcý",
	25 => "Yorum Ekle",
	26 => "Aþaðýdaki yorumlarýn sorumluluðu gönderene aittir. Sitemiz herhangi bir sorumluluk kabul etmez.",
	27 => "En Son",
	28 => "Sil",
	29 => "Hiç yorum yapýlmamýþ.",
	30 => "Eski Yazýlar",
	31 => "Kabul edilen HTML komutlarý:",
	32 => "Kullanýcý adýnýz yanlýþ",
	33 => "Hata, kayýt dosyasýna yazýlamýyor",
	34 => "Hata",
	35 => "Çýkýþ Yap",
	36 => "",
	37 => "Kullanýcýlardan hiç bir yazý gelmemiþ",
	38 => "",
	39 => "Yenile",
	40 => "",
	41 => "Misafirler",
	42 => "Yazar:",
	43 => "Cevap Ver",
	44 => "Üst",
	45 => "MySQL Hata Numarasý",
	46 => "MySQL Hata Mesajý",
	47 => "Kullanýcý",
	48 => "Kayýt Bilgileriniz",
	49 => "Görünüm Özellikleri",
	50 => "SQL komutunda hata var",
	51 => "yardým",
	52 => "Yeni",
	53 => "Kontrol Ana Sayfasý",
	54 => "Dosya açýlamýyor.",
	55 => "Hata",
	56 => "Oy kullan",
	57 => "Þifre",
	58 => "Sisteme Gir",
	59 => "Hala üye deðilmisiniz?<br><a href=\"{$_CONF['site_url']}/users.php?mode=new\">Üye olun</a>",
	60 => "Yorum Gönder",
	61 => "Yeni ",
	62 => "kelime",
	63 => "Yorum Ayarlarý",
	64 => "Bu Yazýyý bir Arkadaþýna Gönder",
	65 => "Basýlabilir Hali",
	66 => "Takvimim",
	67 => " ne Hoþ Geldiniz", //in turkish welcome to comes after site name. ie. GeekLog Site Welcome to
	68 => "ana Sayfa",
	69 => "iletiþim",
	70 => "ara",
	71 => "yazý ekle",
	72 => "web kaynaklarý",
	73 => "geçmiþ anketler",
	74 => "takvim",
	75 => "geliþmiþ arama",
	76 => "site istatistikleri",
	77 => "Eklentiler",
	78 => "Gelecek Etkinlikler",
	79 => "Yenilikler",
	80 => "hikaye son",
	81 => "hikaye son",
	82 => "saat",
	83 => "Yorumlar",
	84 => "Adresler",
	85 => "son 48 saat",
	86 => "Hiç yeni yorum yok",
	87 => "son 2 hafta",
	88 => "Hiç yeni adres yok",
	89 => "Hiç etkinlik yok",
	90 => "Ana Sayfa",
	91 => "Yaratýlma süresi:",
	92 => "saniye",
	93 => "Copyright",
	94 => "Bu sayfalarda yayýmlanan materyalin tüm haklarý sahiplerine aittir.",
	95 => "Powered By:",
	96 => "Gruplar",
    97 => "Kelime Listesi",
	98 => "Eklentiler",
	99 => "Yazýlar",
    100 => "Hiç yeni yazý yok",
    101 => 'Etkinliklerim',
    102 => 'Site Etkinlikleri',
    103 => 'Veritabaný Yedekleri',
    104 => 'ta. Gönderen:',
    105 => 'Kullanýcýlara Mesaj',
    106 => 'Okunma',
    107 => 'GL Sürüm Testi',
    108 => 'Önbelleði Temizle'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Etkinlik Takvimi",
	2 => "Üzgünüm, gösterilebilinecek etkinlik yok.",
	3 => "Ne Zaman",
	4 => "Nerede",
	5 => "Açýklama",
	6 => "Etkinlik Ekle",
	7 => "gelecek Etkinlikler",
	8 => 'Bu etkinliði ekleyerek ileride sadece ilgilendiðiniz etkinlikleri "Takvimim" düðmesine basarak izleyebilirsiniz.',
	9 => "Takvimime Ekle",
	10 => "Takvimimden Çýkar",
	11 => "Etkinlik {$_USER['username']} Takvimine ekleniyor",
	12 => "Etkinlik",
	13 => "Baþlangýç",
	14 => "Bitiþ",
    15 => "Takvime Geri Dön"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Yorum ekle",
	2 => "Biçim Methodu",
	3 => "Sistemden Çýk",
	4 => "Sisteme Üye ol",
	5 => "Kullanýcý Adý",
	6 => "Yorum koyabilmeniz için sisteme giriþ yapmanýz gerekiyor. Eðer bir kullanýcý adýnýz yoksa aþaðýdaki formu kullanarak kendinize bir tane yaratýn.",
	7 => "Son yorumunuz ",
	8 => " saniye önceydi.  Bu sitede iki yorum arasýnda minimum {$_CONF["commentspeedlimit"]} saniye olmalýdýr.",
	9 => "Yorum",
	10 => '',
	11 => "Yorumu Ekle",
	12 => "Lütfen Baþlýk ve Yorum bloklarýný doldurunuz.",
	13 => "Bilgileriniz",
	14 => "Ön Ýzleme",
	15 => "",
	16 => "Baþlýk",
	17 => "Hata",
	18 => 'Önemli Bilgiler',
	19 => 'Yorumlarýnýzýn konuyla ilgili olmasýna dikkat ediniz.',
	20 => 'Yeni bir yorum baþlýðý açmaktansa baþka insanlarýn yorumlarýna cevap vermeyi tercih ediniz.',
	21 => 'Baþka insanlarýn yorumlarýný okuyunuz ki ayný þeyleri bir de siz söylememiþ olun.',
	22 => 'Yorumunuzun konusunu içeriðini iyi anlatan bir þekilde seçiniz.',
	23 => 'Email adresiniz diðer kullanýcýlara GÖSTERÝLMEYECEKTÝR.',
	24 => 'Herhangi Kullanýcý'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Kullanýcý Profili:",
	2 => "Kullanýcý Adý",
	3 => "Gerçek Ad",
	4 => "Þifre",
	5 => "Email",
	6 => "Web Sitesi",
	7 => "Hakkýnda",
	8 => "PGP Anahtarý",
	9 => "Kaydet",
	10 => "Bu kullanýcý için son 10 yorum -",
	11 => "Hiç Yorum Yok",
	12 => "Kullanýcý Özellikleri:",
	13 => "Her Gece Özet Email",
	14 => "Bu þifre rastgele yatarýlmýþtýr. Bu þifreyi olabildiðince çabuk deðiþtirmeniz önerilir. Þifrenizi deðiþtirmek için sisteme giriþ yapýp Kullanýcý menüsünden Kayýt Bilgilerine gidiniz.",
	15 => "{$_CONF["site_name"]} sitesindeki kullanýcý hesabýnýz baþarýyla yaratýldý. Bu hesabý kullanmak için sitemize aþaðýdaki bilgiler dahilinde giriþ yapýnýz. Bu maili ileride referans olarak kullanmak için kaydediniz.",
	16 => "Kullanýcý Hesap Bilgileriniz",
	17 => "Hesap yok",
	18 => "Belirttiðiniz email adresi gerçek bir email adresine benzemiyor",
	19 => "Kullanýcý adýnýz veye email adresiniz sistemde kullanýlýyor",
	20 => "Belirttiðiniz email adresi gerçek bir email adresine benzemiyor",
	21 => "Hata",
	22 => "{$_CONF['site_name']} üye ol!",
	23 => "Bir kullanýcý hesabý yaratmanýz size {$_CONF['site_name']} üyeliði saðlar. Bu sayede siteye kendinize ait yorumlarýnýzý gönderebilir ve kendi içeriðinizi düzenleyebilirsiniz. Eðer kullanýcý hesabýnýz yoksa sadece Herhangi Birisi-Ýsimsiz Kullanýcý olarak içerik ve yorum gönderebilirsiniz. Sistemimize verdiðiniz email adresi <b><i>hiç bir zaman</i></b> sitede görüntülenmeyecektir.",
	24 => "Þifreniz verdiðiniz email adresinize gönderilecektir.",
	25 => "Þifrenizi mi unuttunuz?",
	26 => "Kullanýcý adýnýzý girin ve Þifremi Gönder tuþuna basýn. Yeni yaratýlacak bir þifre sistemimize kayýtlý olan email adresinize gönderilecektir.",
	27 => "Üye Ol!",
	28 => "Þifremi Gönder",
	29 => "Sistemden çýktýnýz:",
	30 => "Sisteme girdiniz:",
	31 => "Seçtiðini bu kontrol sisteme giriþ yapmýþ olmanýzý gerektirmektedir",
	32 => "Ýmza",
	33 => "Site misafirlerine asla gösterilmeyecektir",
	34 => "Adýnýz ve soyadýnýz",
	35 => "Þifrenizi deðiþtirmek için",
	36 => "http:// ile baþlamalý",
	37 => "Yorumlarýnýza uygulanýr",
	38 => "Hakkýnýzla ilgili herþey! Herkes bunu okuyabilir",
	39 => "Paylaþacaðýnýz PGP anahtarýnýz",
	40 => "Konu Sembolü Kullanma",
	41 => "Yönetime Katýlmak Ýstiyorum",
	42 => "Tarih Biçimi",
	43 => "En Fazla Yazý Sayýsý",
	44 => "Bloklar Olmasýn",
	45 => "Görünüm Özellikleri -",
	46 => "Görmek Ýstemediðiniz Konu ve Yazarlar -",
	47 => "Haber Ayarlarý -",
	48 => "Konular",
	49 => "Yazýlarda semboller kullanýlmayacak",
	50 => "Ýlgilenmiyorsanýz iþareti kaldýrýn",
	51 => "Sadece haberler ile ilgili yazýlar",
	52 => "Varsayýlan:",
	53 => "Günün yazýlarýný her akþam al",
	54 => "Görmek istemediðiniz konu ve kullanýcýlar ile ilgili seçenekleri seçiniz.",
	55 => "Site tarafýndan varsayýlan seçim deðerlerini kullanmak istiyorsanýz, seçeneklerin tamamýný boþ býrakýrsanýz. Eðer herhangi bir seçim yaparsanýz, varsayýlan seçimler kullanýlmaz, bu yüzden görmek istediðiniz tüm özellikleri seçmeniz gerekir. Varsayýlan seçimler kalýn yazý tipi ile belirtilmiþtir.",
	56 => "Yazarlar",
	57 => "Görünüm Þekli",
	58 => "Sýralama Þekli",
	59 => "Yorum Sayýsý Limiti",
	60 => "Yorumlarýnýzýn nasýl görüntülenmesini istersiniz?",
	61 => "Ýlk en yeni mi, yoksa en eski mi gösterilsin?",
	62 => "Varsayýlan deðer 100",
	63 => "Þifreniz email adresinize gönderildi. Lütfen, email mesajýnýzda belirtilen adýmlarý uygulayýn. " . $_CONF["site_name"] . " kullandýðýnýz için teþekkür ederiz!",
	64 => "Yorum Ayarlarý -",
	65 => "Bir Daha Sisteme Girmeyi Deneyin",
	66 => "Kullanýcý adýnýzý veya þifrenizi yanlýþ girdiniz. Lütfen aþaðýdaki formu kullanarak bir daha sisteme giriþ yapmayý deneyin. <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Yeni bir kullanýcý</a> mýsýnýz?",
	67 => "Üyelik Tarihi",
	68 => "Beni hatýrla:",
	69 => "Sizi sisteme giriþ yaptýktan sonra hatýrlama süresi",
	70 => "{$_CONF['site_name']} için içerik ve görünüm ayarlarý düzenleyin",
	71 => "{$_CONF['site_name']} nin en büyük özelliði, içeriðinizi özelleþtirebilir, bu sitenin tüm görüntüsünü deðiþtirebilirsiniz.  Bu büyük avantajlardan yararlanmak için öncelikle {$_CONF['site_name']} ne <a href=\"{$_CONF['site_url']}/users.php?mode=new\">kayýt yapmalýsýnýz</a>.  Zaten kayýtlý bir üyemisiniz?  O zaman sol taraftaki formu kullanarak giriþ yapýnýz!",
    72 => "Tema",
    73 => "Dil",
    74 => "Sitenin görünümünü deðiþtirin!",
    75 => "Email ile Gönderilecek Konular -",
    76 => "If you select a topic from the list below you will receive any new stories posted to that topic at the end of each day.  Choose only the topics that interest you!",
    77 => "Resim",
    78 => "Resminizi Ekleyin!",
    79 => "Resmi silmek için burayý seçin",
    80 => "Siteye Giriþ",
    81 => "Email Yolla",
    82 => 'Son 10 Mesaj -',
    83 => 'Yazý gönderme istatistikleri -',
    84 => 'Yazýlan yazýlarýn toplamý:',
    85 => 'Yazýlan yorumlarýn toplamý:',
    86 => 'Gönderdiði tüm mesajlar:',
    87 => 'Giriþ Adýnýz',
    88 => 'Birisi (belki siz) ' . $_CONF['site_name'] . ', sitesindeki "%s" hesabýnýz için yeni bir þifre istedi <' . $_CONF['site_url'] . ">.\n\nÞayet siz gerçekten bu þifreyi almak istiyorsanýz, lütfen bu linki týklayýn:\n\n",
    89 => "Þayet bu þifreyi almak istemiyorsanýz, bu mesajý dikkate almayýn ve bu isteði önemsemeyin (þifreniz deðiþmeyecek ve olduðu gibi kalacaktýr).\n\n",
    90 => 'Aþaðýdaki hesabýnýz için yeni bir þifre girmelisiniz. Not: bu formu gönderinceye kadar eski þifreniz geçerlidir.',
    91 => 'Yeni Þifre Tespit Et',
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
    105 => 'Aktif Kullanýcýlar Bloðunda görüntülenme'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Gösterilecek hiç haber yok",
	2 => "Gösterilecek hiç haber yazýsý yok. Bu konu hakkýnda hiç haber olmayabilir, veya belirlediðiniz ayarlar yüzünden gösterilemiyor olabilir",
	3 => " $topic için",
	4 => "Günün Yazýsý",
	5 => "Sonraki",
	6 => "Önceki"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Web Adresleri",
	2 => "Gösterilecek bir adres yok.",
	3 => "Adres Ekle"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Oyunuz kaydedildi",
	2 => "Anket için verdiðiniz oy kaydedildi",
	3 => "Oyla",
	4 => "Anketler",
	5 => "Oy var",
    6 => "Diðer anketleri göster"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Mesaj gönderilirken bir hata oluþtu. Lütfen bir daha deneyin.",
	2 => "Mesajýnýz baþarýyla gönderildi.",
	3 => "Cevap Adresi alanýna doðru bir email adresi girdiðinizden emin olunuz.",
	4 => "Lütfen, Adýnýzý, Cevap Adresinizi, Konu ve Mesaj alanlarýný doldurunuz",
	5 => "Hata: Böyle bir kullanýcý yok.",
	6 => "Hata oluþtu.",
	7 => "Kullanýcý Profili:",
	8 => "Kullanýcý Adý",
	9 => "Kullanýcý URL'ý",
	10 => "Mail yolla:",
	11 => "Adýnýz:",
	12 => "Cevap Adresi:",
	13 => "Konu:",
	14 => "Mesaj:",
	15 => "HTML kodu çevrilmeyecektir.",
	16 => "Mesajý Gönder",
	17 => "Bu Yazýyý bir Arkadaþýna Gönder",
	18 => "Alýcýnýn Adý",
	19 => "Alýcýnýn Email Adresi",
	20 => "Gönderen Adý",
	21 => "Gönderen Emaili",
	22 => "Bütün alanlarý doldurmalýsýnýz",
	23 => "Bu email size $from ($fromemail) tarafýndan gönderilmiþtir. $from sizin bu yazý {$_CONF["site_url"]} ile ilgilenebileceðinizi düþündü. Bu bir SPAM deðildir, ve sizin email adresiniz herhangi bir þekilde bir listeye eklenmemiþtir.",
	24 => "Bu yazýya yorum ekle",
	25 => "Bu özelliði kullanabilmeniz için sisteme giriþ yapmanýz gerekmektedir. Sitemize giriþ yapmanýz sayesinde sitemizin kötü kullanýmýný önlemiþ olursunuz",
	26 => "Bu form sizin seçtiðiniz kullanýcýya email yollamanýzý saðlar. Tüm alanlar mecburidir.",
	27 => "Mesaj",
	28 => "$from: $shortmsg",
    29 => "Bu mesaj {$_CONF['site_name']} günlük özetidir. ",
    30 => " Günlük Haber Özeti ",
    31 => "Baþlýk",
    32 => "Tarih",
    33 => "Yazýnýn tamamý için:",
    34 => "Mesajýn Sonu",
    35 => 'Üzgünüz, bu kullanýcý hiç mail almamayý tercih etmiþ.'
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Geliþmiþ Arama",
	2 => "Anahtar Kelimeler",
	3 => "Konu",
	4 => "Tamamý",
	5 => "Tipi",
	6 => "Yazýlar",
	7 => "Yorumlar",
	8 => "Yazarlar",
	9 => "Tamamý",
	10 => "Ara",
	11 => "Arama Sonuçlarý",
	12 => "bulundu",
	13 => "Arama Sonuçlarý: Hiç kayýt bulunamadý",
	14 => "Arama kriteriniz ile hiç kayýt bulunamadý:",
	15 => "Lütfen bir daha deneyin.",
	16 => "Baþlýk",
	17 => "Tarih",
	18 => "Yazar",
	19 => "{$_CONF["site_name"]} sitesinin veri tabanýnda bütün yazýlarý ara.",
	20 => "Tarih",
	21 => "-",
	22 => "(Tarih yapýsý YYYY-AA-GG)",
	23 => "Okunma Sayýsý",
	24 => "",
	25 => "kayýt bulundu. Toplam",
	26 => "kayýt var. Arama süresi",
	27 => "saniye.",
    28 => 'Aramanýz sonucunda herhangi bir yazý veya yorum bulunamadý',
    29 => 'Yazý ve Yorum Arama Sonuçlarý',
    30 => 'No links matched your search Aramanýz sonucunda herhangi bir Internet Adresi bulunamadý.',
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
    57 => 'YADA'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Site Ýstatistikleri",
	2 => "Siteye gelen toplam trafik",
	3 => "Sitedeki Yazýlar(Yorumlar)",
	4 => "Sitedeki Anketler(Cevaplar)",
	5 => "Sitedeki Internet Adresleri(Gidilme Sayýsý)",
	6 => "Sitedeki Etkinlikler",
	7 => "Ýlk 10 Yazý",
	8 => "Yazý Baþlýðý",
	9 => "Okunma&nbsp;Sayýsý",
	10 => "Sitenizde ya hiç yazý yok yada daha hiçkimse, hiçbir yazýyý okumamýþ.",
	11 => "En Çok Yorum Alan 10 Yazý",
	12 => "Yorum&nbsp;Sayýsý",
	13 => "Sitenizde ya hiç yazý yok yada daha hiç kimse yazýlara yorum yazmamýþ.",
	14 => "Ýlk 10 Anket",
	15 => "Anket Sorusu",
	16 => "Kullanýlan&nbsp;Oy&nbsp;Sayýsý",
	17 => "Sitenizde ya hiç anket yok yada daha hiç kimse herhangi bir ankete oy vermemiþ.",
	18 => "Ýlk 10 Ýnternet Adresi",
	19 => "Adresler",
	20 => "Kullaným&nbsp;Sayýsý",
	21 => "Sitenizde ya hiç Ýnternet Adresi yok yada hiç kimse herhangi bir adresi kullanmamýþ.",
	22 => "En çok e-mail ile gönderilen 10 Yazý",
	23 => "Email&nbsp;Sayýsý",
	24 => "Hiç kimse sitenizdeki bir yazýyý bir arkadaþýna göndermemiþ."
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Ýlgili",
	2 => "Arkadaþýna Gönder",
	3 => "Basýlmaya Uygun Þekli",
	4 => "Seçenekler"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "$type gönderebilmek için sisteme bir kullanýcý olarak giriþ yapmýþ olmanýz gerekiyor.",
	2 => "Sisteme gir",
	3 => "Yeni Kullanýcý",
	4 => "Etkinlik Ekle",
	5 => "Ýnternet Adresi Ekle",
	6 => "Yazý Ekle",
	7 => "Sisteme giriþ yapmýþ olmanýz gerekiyor",
	8 => "Gönder",
	9 => "Bir bilgi gönderirken, þu önerileri dikkate almanýzý rica ederiz:<ul><li>Bütün alanlarý doldurmanýz mecburidir.<li>Tam ve doðru bilgi veriniz<li>Ýnternet Adresi girerken iki kere kontrol ediniz</ul>",
	10 => "Baþlýk",
	11 => "Ýnternet Adresi",
	12 => "Baþlangýç Tarihi",
	13 => "Bitiþ Tarihi",
	14 => "Yer",
	15 => "Açýklama",
	16 => "Farklý ise lütfen belirtiniz",
	17 => "Kategori",
	18 => "Diðer",
	19 => "Önce Okuyun",
	20 => "Hata: Kategori girilmemiþ",
	21 => "\"Diðer\"'i seçtiðinizde lütfen kategori adýný girin",
	22 => "Hata: Boþ alanlar var",
	23 => "Formdaki tüm alanlarý doldurunuz. Hepsinin doldurulmasý gerekmektedir.",
	24 => "Gönderiniz Kaydedildi",
	25 => "$type gönderiniz baþarýyla kaydedildi.",
	26 => "Hýz Limiti",
	27 => "Kullanýcý Acý",
	28 => "Konu",
	29 => "Yazý",
	30 => "En son gönderiniz ",
	31 => " saniye önceydi. Bu sitede iki gönderi arasýnda en az {$_CONF["speedlimit"]} saniye geçmesi gerekmektedir",
	32 => "Öz Ýzleme",
	33 => "Yazý Ön Ýzleme",
	34 => "Sistemden çýk",
	35 => "HTML kodlarýnýn kullanýmýna izin verilmemektedir",
	36 => "Gönderi Tipi",
	37 => "{$_CONF["site_name"]} sitesine bir etkinlik göndermeniz halinde, gönderiniz sitenin Genel Takvim'ine eklenecektir. Genel Takvimi tüm kullanýcýlar görür ve takvimde ilgilerini çeken etkinlikleri özel takvimlerine ekleyebilirler. Sitenin bu özelliði, kiþisel etkinliklerinizi (doðum günleri, veya yýldönümlerini) eklemek için <b>deðildir</b>. Etkinliði gönderdikten sonra, sitenin yönetiminin onayýna gidecektir. Onay verildikten sonra Genel Takvim'de etkinliðinizi görebilirsiniz.",
    38 => "Etkinlik Ekle:",
    39 => "Genel Takvim",
    40 => "Kiþisel Takvim",
    41 => "Bitiþ Saati",
    42 => "Baþlangýç Saati",
    43 => "Tüm Gün Etkinliði",
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
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Sisteme Giriþ Yapmýþ Olmanýz Gerekiyor",
	2 => "Engellendi! Sisteme Giriþ Bilgileriniz Yanlýþ",
	3 => "Þifre kullanýcý için yanlýþ:",
	4 => "Kullanýcý Adý:",
	5 => "Þifre:",
	6 => "Sitenin yönetim alanlarýnda yapýlan tüm iþlemler kaydedilir ve kontrol edilir.<br>Bu sayfa sadece yetkili kiþiler tarafýndan kullanýlabilir.",
	7 => "sisteme giriþ yap"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Yetersiz Yönetici Haklarý",
	2 => "Bu bloðu düzenlemek için yeterli haklara sahip deðilsiniz.",
	3 => "Blok Düzenleyicisi",
	4 => "",
	5 => "Blok Baþlýðý",
	6 => "Konu",
	7 => "Tamamý",
	8 => "Blok Güvenlik Seviyesi",
	9 => "Blok Sýrasý",
	10 => "Blok Tipi",
	11 => "Portal Blok",
	12 => "Normal Blok",
	13 => "Portal Blok Özellikleri",
	14 => "RDF Adresi",
	15 => "Son RDF Deðiþikliði",
	16 => "Normal Blok Özellikleri",
	17 => "Blok Ýçeriði",
	18 => "Lütfen Blok Baþlýðý, Güvenlik Seviyesi ve Ýçerik alanlarýný doldurunuz.",
	19 => "Blok Yöneticisi",
	20 => "Blok Baþlýðý",
	21 => "Blok Güv. Sev.",
	22 => "Blok Tipi",
	23 => "Blok Sýrasý",
	24 => "Blok Konusu",
	25 => "Bir bloðu silmek veya deðiþtirmek istiyorsanýz, bloðun ismine basýnýz. Yeni bir blok yaratmak için yukarýdaki Yeni Blok düðmesine basýnýz.",
	26 => "Düzenleme Bloðu",
	27 => "PHP Blok",
    28 => "PHP Blok Özellikleri",
    29 => "Blok Fonksiyonu",
    30 => "Eðer bloklarýnýzdan birinin PHP kodu kullanmasýný istiyorsanýz, PHP fonksiyonunun adýný yukarýya giriniz. Fonksiyon adýnýz \"phpblock_\" ile baþlamalýdýr(örn. phpblock_getweather). Eðer bu þekilde baþlamýyorsa, fonkisyonunuz çaðrýlmayacaktýr. Bunu yapmamýzýn nedeni, Geeklog sürümünü deðiþtiren insanlarýn sisteme zarar verebilecek fonksiyonlarý kullanmalarýný önlemek içindir. Fonkisyon adýndan sonra boþ parantez  \"()\" koymamaya dikkat edin. Son olarak, tüm PHP kodlarýnýzý /path/to/geeklog/system/lib-custom.php dosyasýna koymanýzý öneririz. Bu sayede sistemin yeni sürümünü yükleseniz bile yazdýðýný kiþisel PHP kodlarý silinmez.",
    31 => 'PHP Bloðunda hata. $function fonksiyonu yok.',
    32 => "Hata: Eksik alan(lar)",
    33 => "Portal Bloklarý için .rdf dosyasýna olan adresi girmeniz gerekmektedir.",
    34 => "PHP Bloklarý için baþlýk ve fonkisyonu girmeniz gerekmektedir.",
    35 => "Normal bloklar için baþlýk ve içeriði girmeniz gerekmektedir.",
    36 => "Düzenleme bloðu için içerik girmelisiniz",
    37 => "PHP Blok fonksiyonunun adý uygun deðil",
    38 => "PHP Bloklar için çaðrýlacak fonksiyonlar 'phpblock_' ile baþlamalýdýr (örn. phpblock_getweather). Bu ön ek herhangi bir fonksiyonun çaðrýlmasýný önlemek içindir.",
	39 => "Kenar",
	40 => "Sol",
	41 => "Sað",
	42 => "Geeklog varsayýlan bloklarý için, blok sýrasý ve güvenlik seviyesini girmelisiniz",
	43 => "Sadece Ana Sayfa",
	44 => "Eriþim Engellendi",
	45 => "Eriþim hakkýnýz olmayan bir yazýya eriþmek istiyorsunuz. Bu eyleminiz kayýtlara eklenmiþtir. Lütfen <a href=\"{$_CONF["site_admin_url"]}/alan.php\">kontrol ana sayfasýna geri dönün</a>.",
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
    56 => 'Sil'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Etkinlik Düzenleyicisi",
	2 => "",
	3 => "Etkinlik Baþlýðý",
	4 => "Etkinlik Adresi",
	5 => "Etkinlik Baþlangýç Tarihi",
	6 => "Etkinlik Bitiþ Tarihi",
	7 => "Etkinlik Yeri",
	8 => "Etkinlik Açýklamasý",
	9 => "(http:// ile baþlayýn)",
	10 => "Tüm alanlarý doldurmanýz gerekmektedir",
	11 => "Etkinlik Yöneticisi",
	12 => "Bir etkinliði deðiþtirmek veya silmek istiyorsanýz, adýna basýn. Yeni etkinlik yaratmak için Yeni Etkinlik düðmesine basýn.",
	13 => "Etkinlik Baþlýðý",
	14 => "Baþlangýç Tarihi",
	15 => "Bitiþ Tarihi",
	16 => "Eriþim Engellendi",
	17 => "Eriþim hakkýnýz olmayan bir yazýya eriþmek istiyorsunuz. Bu eyleminiz kayýtlara eklenmiþtir. Lütfen <a href=\"{$_CONF["site_admin_url"]}/event.php\">kontrol ana sayfasýna geri dönün</a>.",
	18 => 'Yeni Etkinlik',
	19 => 'Kontrol Ana Sayfasý',
    20 => 'Kaydet',
    21 => 'Vazgeç',
    22 => 'Sil'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Ýnternet Adresi Düzenleyicisi",
	2 => "",
	3 => "Adres Baþlýðý",
	4 => "Adres URL'i",
	5 => "Kategori",
	6 => "(http:// ile baþlayýn)",
	7 => "Diðer",
	8 => "Adres Sayacý",
	9 => "Adres Açýklamasý",
	10 => "Tüm alanlarý doldurmanýz gerekmektedir.",
	11 => "Adres Yöneticisi",
	12 => "Bir adresi deðiþtirmek veya silmek istiyorsanýz, adýna basýn. Yeni etkinlik yaratmak için Yeni Etkinlik düðmesine basýn.",
	13 => "Adres Baþlýðý",
	14 => "Adres Kategorisi",
	15 => "Adres URL'i",
	16 => "Eriþim Engellendi",
	17 => "Eriþim hakkýnýz olmayan bir yazýya eriþmek istiyorsunuz. Bu eyleminiz kayýtlara eklenmiþtir. Lütfen <a href=\"{$_CONF["site_admin_url"]}/link.php\">kontrol ana sayfasýna geri dönün</a>.",
	18 => 'Yeni Adres',
	19 => 'Kontrol Ana Sayfasý',
	20 => 'Farklý ise, belirtin',
    21 => 'Kaydet',
    22 => 'Vazgeç',
    23 => 'Sil'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Önceki Yazý",
	2 => "Sonraki Yazý",
	3 => "Özellikler",
	4 => "Gönderi Þekli",
	5 => "Yazý Düzenle",
	6 => "Sisteme kayýtlý hiç bir yazý bulunmamakta.",
	7 => "Yazar",
	8 => "kaydet",
	9 => "ön izleme",
	10 => "vazgeç",
	11 => "sil",
	12 => "",
	13 => "Baþlýk",
	14 => "Konu",
	15 => "Tarih",
	16 => "Özet",
	17 => "Ýçerik",
	18 => "Toplam okunma sayýsý",
	19 => "Yorumlar",
	20 => "",
	21 => "",
	22 => "Yazý Listesi",
	23 => "Bir yazýyý deðiþtirmek veya silmek istiyorsanýz, yazýnýn numarasýna basýnýz. Bir yazýyý görüntülemek istiyorsanýz, yazýnýn baþlýðýna basýnýz. Yeni bir yazý yaratmak istiyorsanýz, yukarýdaki Yeni Yazý düðmesine basýnýz.",
	24 => "",
	25 => "",
	26 => "Yazý Ön Ýzlemi",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Lütfen, Yazar, Baþlýk ve Konu alanlarýný doldurunuz.",
	32 => "Öncelikli",
	33 => "Sadece bir tane Öncelikli yazý olabilir.",
	34 => "Taslak",
	35 => "Evet",
	36 => "Hayýr",
	37 => "Yazdýklarý:",
	38 => "Yazýlanlar:",
	39 => "Emailler",
	40 => "Eriþiminiz Engellendi",
	41 => "Eriþim hakkýnýz olmayan bir yazýya eriþmek istiyorsunuz. Bu eyleminiz kayýtlara eklenmiþtir. Bu yazýya salt okunur þekilde aþaðýdan eriþebilirsiniz. Ýþiniz bittiði zaman lütfen <a href=\"{$_CONF["site_admin_url"]}/story.php\">kontrol ekranýna dönünüz</a>.",
	42 => "Eriþim hakkýnýz olmayan bir yazýya eriþmek istiyorsunuz.  Bu eyleminiz kayýtlara eklenmiþtir.  Lütfen <a href=\"{$_CONF["site_admin_url"]}/story.php\">kontrol ekranýna geri dönünüz</a>.",
	43 => 'Yeni Yazý',
	44 => 'Kontrol Ana Sayfasý',
	45 => 'Aç(access)',
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
    57 => 'Ölçeksiz resim göster'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Özellikleri",
	2 => "",
	3 => "Yaratýlma Tarihi",
	4 => "Anket $qid kaydedildi",
	5 => "Ankati Deðiþtir",
	6 => "Anket Tanýmlayýcý",
	7 => "(boþluk kullanmayýn)",
	8 => "Ana Sayfada Gözükecek",
	9 => "Soru",
	10 => "Cevaplar / Oylar",
	11 => "$qid Anket cevap verilerini alýrken bir sorun oluþtu",
	12 => "$qid Anket soru verilerini alýrken bir sorun oluþtu",
	13 => "Anket Yarat",
	14 => "kaydet",
	15 => "vazgeç",
	16 => "sil",
	17 => "",
	18 => "Anket Listesi",
	19 => "Bir anketi deðiþtirmek veya silmek istiyorsanýz, anketin tanýmlayýcýsýna basýnýz. Bir anketi görüntülemek istiyorsanýz, anketin baþlýðýna basýnýz. Yeni bir anket yaratmak istiyorsanýz, yukarýdaki Yeni Anket düðmesine basýnýz.",
	20 => "Oylayanlar",
	21 => "Eriþim Engellendi",
	22 => "Eriþim hakkýnýz olmayan bir yazýya eriþmek istiyorsunuz.  Bu eyleminiz kayýtlara eklenmiþtir. Lütfen  <a href=\"{$_CONF["site_admin_url"]}/poll.php\">anket kontrol ekranýna geri dönünüz</a>.",
	23 => 'Yeni Anket',
	24 => 'Kontrol Ana Sayfasý',
	25 => 'Evet',
	26 => 'Hayýr'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Konu Düzenle",
	2 => "Konu Tanýmlayýcý",
	3 => "Konu Adý",
	4 => "Konu Resmi",
	5 => "(boþluk kullanmayýn)",
	6 => "Bir konuyu sildiðiniz zaman o konuyla iliþkili tüm yazýlar ve bloklar silinecektir",
	7 => "Lütfen Konu Tanýmlayýcý ve  Konu Adý alanlarýný doldurunuz",
	8 => "Konu Yöneticisi",
	9 => "Bir konuyu deðiþtirmek veya silmek istiyorsanýz, konunun adýna basýnýz.  Yeni bir konu yaratmak istiyorsanýz, soldaki Yeni Konu düðmesine basýnýz. Her konuya olan eriþim haklarýnýzý parantez içinde görebilirsiniz",
	10=> "Sýralama",
	11 => "Yazý/Sayfa",
	12 => "Eriþim Engellendi",
	13 => "Eriþim hakkýnýz olmayan bir konuya eriþmek istiyorsunuz.  Bu eyleminiz kayýtlara eklenmiþtir. Lütfen <a href=\"{$_CONF["site_admin_url"]}/topic.php\">konu kontrol ekranýna geri dönünüz</a>.",
	14 => "Sýralama yöntemi",
	15 => "alfabetik",
	16 => "standart",
	17 => "Yeni Konu",
	18 => "Kontrol Ana Sayfasý",
    19 => 'kaydet',
    20 => 'vazgeç',
    21 => 'sil',
    22 => 'Varsayýlan',
    23 => 'bildirilen yeni yazý için bunu varsayýlan baþlýk yap',
    24 => '(*)'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Kullanýcý Düzenle",
	2 => "Kullanýcý Tanýmlayýcýsý",
	3 => "Kullanýcý Adý",
	4 => "Gerçek Adý",
	5 => "Þifresi",
	6 => "Güvenlik Seviyesi",
	7 => "Email Adresi",
	8 => "Web Sitesi",
	9 => "(boþluk kullanmayýn)",
	10 => "Lütfen Kullanýcý Adý, Gerçek Adý, Güvenlik Seviyesi, ve Email Adresi alanlarýný doldurunuz",
	11 => "Kullanýcý Düzenleyici",
	12 => "Bir kullanýcýnýn bilgilerini deðiþtirmek veya silmek istiyorsanýz, kullanýcý adýna basýnýz.  Yeni bir kullanýcý yaratmak istiyorsanýz, soldaki Yeni Kullanýcý düðmesine basýnýz. Aþaðýdaki formda kullanýcý adýný, email adresini veya gerçek adýný girerek basit aramalar yapabilirsiniz (örneðin *son* or *.edu).",
	13 => "Güvenlik Seviyesi",
	14 => "Kayýt Tarihi",
	15 => 'Yeni Kullanýcý',
	16 => 'Kontrol Ana Sayfasý',
	17 => 'þifre deðiþtir',
	18 => 'vazgeç',
	19 => 'sil',
	20 => 'kaydet',
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
    32 => 'Ekleme iþlemi tamamlandý. $successes kullanýcý eklendi ve $failures hata oluþtu',
    33 => 'gönder',
    34 => 'Hata: Yükleme yapmak için bir dosya seçmiþ olmanýz gerekiyor.',
    35 => 'Son Giriþ',
    36 => '(asla)'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Onayla",
    2 => "Sil",
    3 => "Deðiþtir",
    4 => 'Profil',
    10 => "Baþlýk",
    11 => "Baþlangýç Tarihi",
    12 => "URL",
    13 => "Kategori",
    14 => "Tarih",
    15 => "Konu",
    16 => 'Kullanýcý adý',
    17 => 'Gerçek adý',
    18 => 'Email',
    34 => "Kontrol",
    35 => "Eklenen Yazýlar",
    36 => "Eklenen Adresler",
    37 => "Eklenen Etkinlikler",
    38 => "Gönder",
    39 => "Onaylamanýz gereken herhangi bir eklenti yok",
    40 => "Kullanýcýlarýn ekledikleri"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Pazar",
	2 => "Pazartesi",
	3 => "Salý",
	4 => "Çarþamba",
	5 => "Perþembe",
	6 => "Cuma",
	7 => "Cumartesi",
	8 => "Etkinlik Ekle",
	9 => "ScriptEvi Etkinliði",
	10 => "Etkinlikler:",
	11 => "Genel Takvim",
	12 => "Takvimim",
	13 => "Ocak",
	14 => "Þubat",
	15 => "Mart",
	16 => "Nisan",
	17 => "Mayýs",
	18 => "Haziran",
	19 => "Temmuz",
	20 => "Aðustos",
	21 => "Eylül",
	22 => "Ekim",
	23 => "Kasým",
	24 => "Aralýk",
	25 => "Geri: ",
    26 => "Tüm Gün",
    27 => "Hafta",
    28 => "Kiþisel Takvim:",
    29 => "Genel Takvim",
    30 => "etkinliði sil",
    31 => "Ekle",
    32 => "Etkinlik",
    33 => "Tarih",
    34 => "Saat",
    35 => "Hýzlý Ekle",
    36 => "Gönder",
    37 => "Özür dilerim, kiþisel takvim özelliði bu sitede tanýmlanmamýþ",
    38 => "Kiþisel Etkinlik Düzenleyicisi",
    39 => 'Gün',
    40 => 'Hafta',
    41 => 'Ay'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => $_CONF['site_name'] . " Mesaj Programý",
 	2 => "Kimden",
 	3 => "Cevaplama Adresi",
 	4 => "Konu",
 	5 => "Ýçerik",
 	6 => "Gönderim:",
 	7 => "Kullanýcý Ekle",
 	8 => "Admin",
	9 => "Özellikler",
	10 => "HTML",
 	11 => "Acil Mesaj!",
 	12 => "Gönder",
 	13 => "Temizle",
 	14 => "Kullanýcý ayarlarýný dikkate alma",
 	15 => "Kullanýcý(lar)a gönderilemiyor: ",
	16 => "Kullanýcý(lar)a baþarýyla gönderildi: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Bir mesaj daha gönder</a>",
    18 => "Kime",
    19 => "NOT: eðer bütün site üyelerine mesaj göndermek istiyorsanýz, seçim listesinden Sitedeki Kullanýcýlar grubunu seçiniz.",
    20 => "<successcount> mesaj baþarýyla gönderildi ama <failcount> mesajýn gönderilmesinde sorun çýktý. Her gönderme denemesinin ayrýntýlarý aþaðýda bulunmaktadýr. <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">Baþka bir mesaj gönderebilir</a>, veya <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">Kontrol Ana Sayfasý</a>na geri dönebilirisiniz.",
    21 => 'Baþarýsýz',
    22 => 'Baþarýlý',
    23 => 'Baþarýsýz olan gönderim yok',
    24 => 'Baþarýlý olan gönderim yok',
    25 => '-- Grup seçin --',
    26 => "Lütfen formun tüm alanlarýný doldurun ve þeçim listesinden bir kullanýcý grubu seçin."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Þifreniz email adresinize gönderilmiþtir. Lütfen, email adresinize gelen mesajdaki adýmlarý uygulayýn. " . $_CONF["site_name"] . " kullandýðýnýz için teþekkür ederiz.",
	2 => "Yazýnýzý sitemize gönderdiðiniz için teþekkür ederiz.  Yazýnýz, site yönetimi tarafýndan onaylandýktan sonra yayýmlanacaktýr.",
	3 => "Ýnternet adresini sitemize gönderdiðiniz için teþekkür ederiz. Adresiniz, site yönetimi tarafýndan onaylandýktan sonra yayýmlanacaktýr. Onaylandýktan sonra gönderdiðiniz adresi<a href={$_CONF["site_url"]}/links.php>Adresler</a> bölümünde görebilirsiniz.",
	4 => "Sitemize eklediðiniz etkinlik için teþekkür ederiz.  Gönderdiðiniz etkinlik, site yönetimi tarafýndan onaylandýktan sonra yayýmlanacaktýr. Onaylandýktan sonra <a href={$_CONF["site_url"]}/calendar.php>takvim</a> bölümünde görebilirsiniz.",
	5 => "Kayýt bilgileriniz baþarýlý bir þekilde kaydedildi.",
	6 => "Görünüm ayarlarýnýz baþarýlý bir þekilde kaydedildi.",
	7 => "Yorum tercihleriniz baþarýlý bir þekilde kaydedildi.",
	8 => "Sistemden baþarýyla çýktýnýz.",
	9 => "Yazýnýz baþarýyla kaydedildi.",
	10 => "Yazýnýz baþarýyla silindi.",
	11 => "Bloðunuz baþarýyla kaydedildi.",
	12 => "Bloðunuz baþarýyla silindi.",
	13 => "Konunuz baþarýyla kaydedildi.",
	14 => "Konunuz ve bütün yazýlarý ve alanlarý baþarýyla silindi.",
	15 => "Internet Adresiniz baþarýyla kaydedildi.",
	16 => "Internet Adresiniz baþarýyla silindi.",
	17 => "Etkinliðiniz baþarýyla kaydedildi.",
	18 => "Etkinliðiniz baþarýyla silindi.",
	19 => "Anketiniz baþarýyla kaydedildi.",
	20 => "Anketiniz baþarýyla silindi.",
	21 => "Yeni kullanýcý baþarýyla kaydedildi.",
	22 => "Yeni kullanýcý baþarýyla silindi.",
	23 => "Takviminize etkinlik eklerken sorun oluþtu. Etkinlik tanýmlayýcýsý tanýmlanmamýþ.",
	24 => "Takviminize etkinlik baþarýyla eklendi.",
	25 => "Sisteme giriþ yapmadan kiþisel takviminizi açamazsýnýz.",
	26 => "Kiþisel takviminizden etkinlik baþarýyla silinmiþtir.",
	27 => "Mesaj baþarýlya iletildi.",
	28 => "Eklenti baþarýyla eklendi.",
	29 => "Üzgünüm, kiþisel takvimler bu sitede kullanýlamýyor.",
	30 => "Eriþim Engellendi",
	31 => "Yazý kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
	32 => "Konu kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
	33 => "Blok kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
	34 => "Internet Adresi kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
	35 => "Etkinlik kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
	36 => "Anket kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
	37 => "Kullanýcý kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
	38 => "Eklenti kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
	39 => "Mesaj kontrol sayfalarýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
	40 => "Sistem Mesajý",
    41 => "Kelime deðiþtirme sayfasýna eriþiminiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
    42 => "Kelimeniz baþarýyla kaydedildi.",
	43 => "Kelimeniz  baþarýyla silindi.",
    44 => 'Eklenti baþarýlya yüklendi!',
    45 => 'Eklenti baþarýyla silindi.',
    46 => "Veri tabaný yedekleme programýna eriþimiz yok.  Giriþ izni olmayan tüm etkinlikler kayýtlara geçmektedir.",
    47 => "Bu özellik sadece Linux, Unix gibi iþletim sistemlerinde çalýþýr.  Eðer Linux, Unix gibi bir iþletim sistemi kullanýyorsanýz, önbelleðiniz baþarýyla temizlenmiþtir. Eðer Windows kullanýyorsanýz, adodb_*.php  dosyalarýný aratýn ve silin.",
    48 => $_CONF['site_name'] . ' sitesine üyelik baþvurunuz için teþekkür ederiz. Site yönetimi baþvurunuzu inceleyecektir. Eðer kabul alýrsanýz þifreniz belirttiðiniz eðmail adreisne gönderilecektir.',
    49 => "Grubunuz baþarýyla kaydedildi.",
    50 => "Grup baþarýyla silindi.",
    51 => 'Bu kullanýcý adý zaten kullanýlýyor. Lütfen baþka bir tane seçin.',
    52 => 'Saðlanan email adresi geçerli bir email adresi olarak gözükmüyor.',
    53 => 'Yeni þifreniz kabul edildi. Lütfen aþaðýdan yeni þifrenizi kullanarak þimdi giriþ yapýn.',
    54 => 'Yeni bir þifre isteme süresiniz doldu. Lütfen aþaðýdan tekrar deneyin.',
    55 => 'Size bir email gönderildi ve az önce yerine ulaþtý. Hesabýnýza yeni bir þifre tayin etmek için mesajdaki talimatlarý lütfen takip ediniz.',
    56 => 'Saðlanan email adresi zaten baþka bir hesap tarafýndan kullanýlýyor.',
    57 => 'Hesabýnýz baþarýyla silindi.'
);

// for plugins.php

$LANG32 = array (
	1 => "Sisteme eklenti (plug-in) yükleyerek Geeklog'un çalýþmasýný ve belki sisteminizi bozabilirsiniz. Sadece <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Ana Sayfasý</a>'ndan yüklediðiniz eklentileri yüklemeniz tavsiye edilir, çünkü bize ulaþan tüm eklentileri çeþitli iþletim sistemleriyle ayrýntýlý testlere sokuyoruz. Özellikle üçüncü firmalardan yüklediðiniz eklentilerin yüklenirken sisteminize zarar verebilecek programlar çalýþtýrabileceðini ve bunlarýn güvenlik açýklarýna neden olabileceðini anlamanýz önemlidir. Bu uyarýya raðmen, biz bu eklentinin yüklenmesinin baþarýyla tamamlanacaðýný garanti etmiyoruz, ve sisteminizde doðacak herhangi bir hasardan dolayý sorumluluk kabul etmiyoruz. Baþka bir deyiþle eklentiyi yüklerken doðacak tüm riskler size aittir.  Ayrýntýlarý öðrenmek isteyenler için her eklenti paketinde yüklemenin el ile yapýlabilmesi için ayrýntýlar ve adýmlar mevcuttur.",
	2 => "Eklenti Yükleme ile Ýlgili Yükümler",
	3 => "Eklenti Yükleme Formu",
	4 => "Eklenti Dosyasý",
	5 => "Eklenti Listesi",
	6 => "Uyarý: Eklenti zaten yüklenmiþ!",
	7 => "Yüklemeye çalýþtýðýnýz eklenti zaten yüklenmiþ. Eðer yeniden yüklemek istiyorsanýz, eklentiyi önce silin.",
	8 => "Eklenti uyumluluk kontrolü baþarýsýz.",
	9 => "Bu eklenti Geeklog'un yeni bir versiyonun istemekte. Elinizdeki kopyayý ya <a href=\"http://www.geeklog.net\">Geeklog</a> adresinden yenileyin ya da eklentinin yeni bir versiyonunu bulmalýsýnýz.",
	10 => "<br><b>Þu anda hiç bir eklenti yüklenmemiþ.</b><br><br>",
	11 => "Bir eklentiyi deðiþtirmek veya silmek istiyorsanýz eklentinin numarasýna basýn. Eklenti hakkýnda daha fazla bilgi edinmek için eklentinin adýna basýn. Bu eklentinin web sitesini açar. Bir eklenti yüklemek veya sürümünü yenilemek için dokümantasyonuna baþvurun.",
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
    31 => 'Bu eklentiyi silmek istediðinizden eminmisiniz? Bunu yaparsanýz eklentinin kullandýðý tüm veriler ve veri yapýlarý da silinecektir. Eminseniz Sil düðmesine bir daha basýnýz.'
);

$LANG_ACCESS = array(
	access => "Eriþim",
    ownerroot => "Sahibi/Root",
    group => "Grup",
    readonly => "Salt Okunur",
	accessrights => "Eriþim Haklarý",
	owner => "Sahibi",
	grantgrouplabel => "Yukarýdaki Grup Deðiþtirme Haklarýna Ýzin Ver",
	permmsg => "NOT: Üyeler bu sitenin, siteye girmiþ olan üyelerine denir, ve Herhangi ise sitede bulundan ama siteye giriþ yapmamýþ herhangi bir kullanýcýya denir.",
	securitygroups => "Güvenlik Gruplarý",
	editrootmsg => "Kullanýcý Yöneticisi olmanýza raðmen root kullanýcýsýný, root kullanýcýsý olmadan deðiþtiremezsiniz. Root kullanýcýsý dýþýnda herhangi bir kullanýcýyý deðiþtirebiliriniz. Root kullanýcýsýna olan izinsiz tüm etkinlikler kaydedilmektedir. Lütfen <a href=\"{$_CONF["site_admin_url"]}/user.php\">Kullarnýcý Kontrol Sayfasý</a>'na geri dönün.",
	securitygroupsmsg => "Kullanýcýnýn bulunmasýný istediðiniz gruplarý lütfen seçiniz.",
	groupeditor => "Grup Düzenleyicisi",
	description => "Taným",
	name => "Ad",
 	rights => "Haklar",
	missingfields => "Eksik Bloklar",
	missingfieldsmsg => "Gruba bir Ad ve Taným vermelisiniz.",
	groupmanager => "Grup Düzenleyicisi",
	newgroupmsg => "Bir grubu deðiþtirmek veya silmek istiyorsanýz, grubun adýna basýnýz. Yeni bir grup yaratmak için yukarýdan Yeni Grup düðmesine basýnýz. Sistem tarafýndan yaratýlmýþ temel gruplar sistem tarafýndan kullanýldýðý için silinemez.",
	groupname => "Grup Adý",
	coregroup => "Temel Grubu",
	yes => "Evet",
	no => "Hayýr",
	corerightsdescr => "Bu grup bir temel {$_CONF["site_name"]} grubudur.  Bu nedenden bu grubun eriþim haklarý deðiþtirlemez. Aþaýðda bu grubun hangi haklara sahip olduðunun listesi bulunmaktadýr.",
	groupmsg => "Bu sitede kullanýlan güvenlik gruplarý hiyerarþiktir. Bir grubu bu gruba ekleyerek bu grubun sahip olduðu eriþim haklarýyla ayný eriþim haklarýný eklediðiniz gruba vermiþ olursunuz. Bir gruba güvenlik haklarý vermek için aþaðýdaki gruplarý kullanarak gruplar oluþturmaný önerilir. Eðer bir gruba özel haklar vermek istiyorsanýz, aþaðýdaki 'Haklar' bölümünden istediðiniz özellikleri seçebilirsiniz. Bu grubu bir baþka grup(lar)ýn altýna eklemek için sadece aþaðýdaki gruplardan istediklerinizi seçin.",
	coregroupmsg => "Bu grup bir temel {$_CONF["site_name"]} grubudur.  Bu yüzden bu grubun bulunduðu gruplar deðiþtirilemez. Bu grubun bulunduðu gruplarýn salt okunur listesi aþaðýdadýr.",
	rightsdescr => "Bir grubun bir eriþim hakký buradan verilebilir veya grubun bir üst grubu varsa o gruba verilerek bu gurubun almasý saðlanabilinir. Aþaðýda eðer seçme kutusu olmayan haklar varsa bunlar bu grubun üyesi olduðu bir üst gruba verilmiþ olan haklardýr. Seçme kutusu olan haklarý seçerek bu gruba daha geniþ bir hak verebilirsiniz.",
	lock => "Kilit",
	members => "Üyeler",
	anonymous => "Ýsimsiz Kullanýcý",
	permissions => "Ýzinler",
	permissionskey => "R = oku, E = düzenle, haklarda deðiþiklik yap",
	edit => "Deðiþtir",
	none => "Hiçbiri",
	accessdenied => "Eriþim Engellendi",
	storydenialmsg => "Bu yazýyý okuma yetkiniz yok. Bunun nedeni {$_CONF["site_name"]} sitesinin bir üyesi olmamanýzdan kaynaklanýyor olabilir. Lütfen {$_CONF["site_name"]} sitesinin <a href=users.php?mode=new> üyesi olun</a> ve sadece üyelere verilen haklara kavuþun!",
	eventdenialmsg => "Bu etkinliði görüntüleme yetkiniz yok. Bunun nedeni {$_CONF["site_name"]} sitesinin bir üyesi olmamanýzdan kaynaklanýyor olabilir. Lütfen {$_CONF["site_name"]} sitesinin <a href=users.php?mode=new> üyesi olun</a> ve sadece üyelere verilen haklara kavuþun!",
	nogroupsforcoregroup => "Bu grup bir baþka gruba daðil deðil.",
	grouphasnorights => "Bu grup, sitenin hiç bir yönetimsel özelliklerine sahip deðil.",
	newgroup => 'Yeni Grup',
	adminhome => 'Kontrol Ana Sayfasý',
	save => 'kaydet',
	cancel => 'vazgeç',
	delete => 'sil',
	canteditroot => 'Root grubu deðiþtirmeye çalýþtýnýz, fakat root grubun bir üyesi deðilsiniz. Bu nedenden eriþiminiz engellendi. Eðer bunun bir hata olduðunu düþünüyorsanýz sistem yöneticinize danýþýn.',
    listusers => 'Üye Listesi',
    listthem => 'liste',
    usersingroup => 'Üye grubu %s'	
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Kelime Deðiþtirme Düzenleyicisi",
    wordid => "Kelime Tanýmlayýcýsý",
    intro => "Bir kelimeyi deðiþtirmek veya silmek için o kelimenin üzerine basýn. Yeni bir Kelime Deðiþtirmesi yaratmak için soldaki Yeni Kelime düðmesine basýn.",
    wordmanager => "Kelime Düzenleyicisi",
    word => "Kelime",
    replacmentword => "Yeni Kelime",
    newword => "Yeni Kelime"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Son 10 yedekleme',
    do_backup => 'Yedekleme Yap',
    backup_successful => 'Veritabaný yedeklemesi baþarýyla sonuçlandý.',
    no_backups => 'Sisteminizde hiç veritabaný yedeði yok.',
    db_explanation => 'Geeklog sisteminin yeni bir yedeðini almak için, aþaðýdaki butona basýn.',
    not_found => "Hatalý adres veya mysqldump programý çalýþtýrýlýnamýyor.<br>config.php dosyanýzdaki <strong>\$_DB_mysqldump_path</strong> deðiþkenini kontrol edin.<br>Deðiþken þu anki deðeri: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Yedekleme baþarýsýz: Dosya boyutu 0 bayt idi.',
    path_not_found => "{$_CONF['backup_path']} adresi yok veya bir klasör deðil",
    no_access => "HATA: Kalsör {$_CONF['backup_path']} eriþilinemiyor.",
    backup_file => 'Yedek dosyasý',
    size => 'Boyut',
    bytes => 'Bayt',
    total_number => 'Toplam backup sayýsý: %d'
);

$LANG_BUTTONS = array(
    1 => "Ana Sayfa",
    2 => "Ýletiþim",
    3 => "Yazý Yazýn",
    4 => "Adresler",
    5 => "Anketler",
    6 => "Takvim",
    7 => "Site Ýstatistikleri",
    8 => "Özelleþtir",
    9 => "Ara",
    10 => "Geliþmiþ Arama"
);

$LANG_404 = array(
    1 => "404 Hatasý",
    2 => "Üff, her yere baktým ama <b>%s</b> bulamadým.",
    3 => "<p>Üzgünüz, belirttiðiniz dosya bulunamýyor. Lütfen <a href=\"{$_CONF['site_url']}\">ana sayfa</a>ya veya <a href=\"{$_CONF['site_url']}/search.php\">arama sayfasý</a>'na bakarak kaybettiðiniz dokümaný bulabilecekmisiniz bir bakýn."
);

$LANG_LOGIN = array (
    1 => 'Sisteme giriþ yapmanýz gerekiyor',
    2 => 'Üzgünüm, bu alana giriþ yapabilmeniz için bir kullanýcý olarak giriþ yapmanýz gerekiyor.',
    3 => 'Giriþ yap',
    4 => 'Yeni Kullanýcý'
);

?>
