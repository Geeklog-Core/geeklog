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

$LANG_CHARSET = 'UTF-8';

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
    2 => 'devamı',
    3 => 'yorum',
    4 => 'Değiştir',
    5 => 'Oy Kullan',
    6 => 'Sonuçlar',
    7 => 'Anket Sonuçları',
    8 => 'oy',
    9 => 'Yönetici kontrolleri:',
    10 => 'Gönderilenler',
    11 => 'Yazılar',
    12 => 'Bloklar',
    13 => 'Konular',
    14 => 'Internet Adresleri',
    15 => 'Etkinlikler',
    16 => 'Anketler',
    17 => 'Kullanıcılar',
    18 => 'SQL Sorgusu',
    19 => 'Sistemden Çık',
    20 => 'Kullanıcı Bilgileri:',
    21 => 'Kullanıcı Adı',
    22 => 'Kullanıcı Tanımlayıcısı',
    23 => 'Güvenlik Seviyesi',
    24 => 'İsimsiz Kullanıcı',
    25 => 'Yorum Ekle',
    26 => 'Aşağıdaki yorumların sorumluluğu gönderene aittir. Sitemiz herhangi bir sorumluluk kabul etmez.',
    27 => 'En Son',
    28 => 'Sil',
    29 => 'Hiç yorum yapılmamış.',
    30 => 'Eski Yazılar',
    31 => 'Kabul edilen HTML komutları:',
    32 => 'Kullanıcı adınız yanlış',
    33 => 'Hata, kayıt dosyasına yazılamıyor',
    34 => 'Hata',
    35 => 'Çıkış Yap',
    36 => 'on',
    37 => 'Kullanıcılardan hiç bir yazı gelmemiş',
    38 => 'Content Syndication',
    39 => 'Yenile',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Misafirler',
    42 => 'Yazar:',
    43 => 'Cevap Ver',
    44 => 'Üst',
    45 => 'MySQL Hata Numarası',
    46 => 'MySQL Hata Mesajı',
    47 => 'Kullanıcı',
    48 => 'Kayıt Bilgileriniz',
    49 => 'Görünüm Özellikleri',
    50 => 'SQL komutunda hata var',
    51 => 'yardım',
    52 => 'Yeni',
    53 => 'Kontrol Ana Sayfası',
    54 => 'Dosya açılamıyor.',
    55 => 'Hata',
    56 => 'Oy kullan',
    57 => 'Şifre',
    58 => 'Sisteme Gir',
    59 => "Hala üye değilmisiniz?<br><a href=\"{$_CONF['site_url']}/users.php?mode=new\">Üye olun</a>",
    60 => 'Yorum Gönder',
    61 => 'Yeni ',
    62 => 'kelime',
    63 => 'Yorum Ayarları',
    64 => 'Bu Yazıyı bir Arkadaşına Gönder',
    65 => 'Basılabilir Hali',
    66 => 'Takvimim',
    67 => ' ne Hoş Geldiniz',
    68 => 'ana Sayfa',
    69 => 'iletişim',
    70 => 'ara',
    71 => 'yazı ekle',
    72 => 'web kaynakları',
    73 => 'geçmiş anketler',
    74 => 'takvim',
    75 => 'gelişmiş arama',
    76 => 'site istatistikleri',
    77 => 'Eklentiler',
    78 => 'Gelecek Etkinlikler',
    79 => 'Yenilikler',
    80 => 'hikaye son',
    81 => 'hikaye son',
    82 => 'saat',
    83 => 'Yorumlar',
    84 => 'Adresler',
    85 => 'son 48 saat',
    86 => 'Hiç yeni yorum yok',
    87 => 'son 2 hafta',
    88 => 'Hiç yeni adres yok',
    89 => 'Hiç etkinlik yok',
    90 => 'Ana Sayfa',
    91 => 'Yaratılma süresi:',
    92 => 'saniye',
    93 => 'Copyright',
    94 => 'Bu sayfalarda yayımlanan materyalin tüm hakları sahiplerine aittir.',
    95 => 'Powered By:',
    96 => 'Gruplar',
    97 => 'Kelime Listesi',
    98 => 'Eklentiler',
    99 => 'Yazılar',
    100 => 'Hiç yeni yazı yok',
    101 => 'Etkinliklerim',
    102 => 'Site Etkinlikleri',
    103 => 'Veritabanı Yedekleri',
    104 => 'ta. Gönderen:',
    105 => 'Kullanıcılara Mesaj',
    106 => 'Okunma',
    107 => 'GL Sürüm Testi',
    108 => 'Önbelleği Temizle',
    109 => 'Report abuse',
    110 => 'Report this post to the site admin',
    111 => 'View PDF Version',
    112 => 'Registered Users',
    113 => 'Documentation',
    114 => 'TRACKBACKS',
    115 => 'No new trackback comments',
    116 => 'Trackback',
    117 => 'Directory',
    118 => 'Please continue reading on the next page:',
    119 => "Lost your <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">password</a>?",
    120 => 'Permanent link to this comment',
    121 => 'Comments (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'All HTML is allowed'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Etkinlik Takvimi',
    2 => 'Üzgünüm, gösterilebilinecek etkinlik yok.',
    3 => 'Ne Zaman',
    4 => 'Nerede',
    5 => 'Açıklama',
    6 => 'Etkinlik Ekle',
    7 => 'gelecek Etkinlikler',
    8 => 'Bu etkinliği ekleyerek ileride sadece ilgilendiğiniz etkinlikleri "Takvimim" düğmesine basarak izleyebilirsiniz.',
    9 => 'Takvimime Ekle',
    10 => 'Takvimimden Çıkar',
    11 => "Etkinlik {$_USER['username']} Takvimine ekleniyor",
    12 => 'Etkinlik',
    13 => 'Başlangıç',
    14 => 'Bitiş',
    15 => 'Takvime Geri Dön'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Yorum ekle',
    2 => 'Biçim Methodu',
    3 => 'Sistemden Çık',
    4 => 'Sisteme Üye ol',
    5 => 'Kullanıcı Adı',
    6 => 'Yorum koyabilmeniz için sisteme giriş yapmanız gerekiyor. Eğer bir kullanıcı adınız yoksa aşağıdaki formu kullanarak kendinize bir tane yaratın.',
    7 => 'Son yorumunuz ',
    8 => " saniye önceydi.  Bu sitede iki yorum arasında minimum {$_CONF['commentspeedlimit']} saniye olmalıdır.",
    9 => 'Yorum',
    10 => 'Send Report',
    11 => 'Yorumu Ekle',
    12 => 'Lütfen Başlık ve Yorum bloklarını doldurunuz.',
    13 => 'Bilgileriniz',
    14 => 'Ön İzleme',
    15 => 'Report this post',
    16 => 'Başlık',
    17 => 'Hata',
    18 => 'Önemli Bilgiler',
    19 => 'Yorumlarınızın konuyla ilgili olmasına dikkat ediniz.',
    20 => 'Yeni bir yorum başlığı açmaktansa başka insanların yorumlarına cevap vermeyi tercih ediniz.',
    21 => 'Başka insanların yorumlarını okuyunuz ki aynı şeyleri bir de siz söylememiş olun.',
    22 => 'Yorumunuzun konusunu içeriğini iyi anlatan bir şekilde seçiniz.',
    23 => 'Email adresiniz diğer kullanıcılara GÖSTERİLMEYECEKTİR.',
    24 => 'Herhangi Kullanıcı',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Kullanıcı Profili:',
    2 => 'Kullanıcı Adı',
    3 => 'Gerçek Ad',
    4 => 'Şifre',
    5 => 'Email',
    6 => 'Web Sitesi',
    7 => 'Hakkında',
    8 => 'PGP Anahtarı',
    9 => 'Kaydet',
    10 => 'Bu kullanıcı için son 10 yorum -',
    11 => 'Hiç Yorum Yok',
    12 => 'Kullanıcı Özellikleri:',
    13 => 'Her Gece Özet Email',
    14 => 'Bu şifre rastgele yatarılmıştır. Bu şifreyi olabildiğince çabuk değiştirmeniz önerilir. Şifrenizi değiştirmek için sisteme giriş yapıp Kullanıcı menüsünden Kayıt Bilgilerine gidiniz.',
    15 => "{$_CONF['site_name']} sitesindeki kullanıcı hesabınız başarıyla yaratıldı. Bu hesabı kullanmak için sitemize aşağıdaki bilgiler dahilinde giriş yapınız. Bu maili ileride referans olarak kullanmak için kaydediniz.",
    16 => 'Kullanıcı Hesap Bilgileriniz',
    17 => 'Hesap yok',
    18 => 'Belirttiğiniz email adresi gerçek bir email adresine benzemiyor',
    19 => 'Kullanıcı adınız veye email adresiniz sistemde kullanılıyor',
    20 => 'Belirttiğiniz email adresi gerçek bir email adresine benzemiyor',
    21 => 'Hata',
    22 => "{$_CONF['site_name']} üye ol!",
    23 => "Bir kullanıcı hesabı yaratmanız size {$_CONF['site_name']} üyeliği sağlar. Bu sayede siteye kendinize ait yorumlarınızı gönderebilir ve kendi içeriğinizi düzenleyebilirsiniz. Eğer kullanıcı hesabınız yoksa sadece Herhangi Birisi-İsimsiz Kullanıcı olarak içerik ve yorum gönderebilirsiniz. Sistemimize verdiğiniz email adresi <b><i>hiç bir zaman</i></b> sitede görüntülenmeyecektir.",
    24 => 'Şifreniz verdiğiniz email adresinize gönderilecektir.',
    25 => 'Şifrenizi mi unuttunuz?',
    26 => 'Kullanıcı adınızı girin ve Şifremi Gönder tuşuna basın. Yeni yaratılacak bir şifre sistemimize kayıtlı olan email adresinize gönderilecektir.',
    27 => 'Üye Ol!',
    28 => 'Şifremi Gönder',
    29 => 'Sistemden çıktınız:',
    30 => 'Sisteme girdiniz:',
    31 => 'Seçtiğini bu kontrol sisteme giriş yapmış olmanızı gerektirmektedir',
    32 => 'İmza',
    33 => 'Site misafirlerine asla gösterilmeyecektir',
    34 => 'Adınız ve soyadınız',
    35 => 'Şifrenizi değiştirmek için',
    36 => 'http:// ile başlamalı',
    37 => 'Yorumlarınıza uygulanır',
    38 => 'Hakkınızla ilgili herşey! Herkes bunu okuyabilir',
    39 => 'Paylaşacağınız PGP anahtarınız',
    40 => 'Konu Sembolü Kullanma',
    41 => 'Yönetime Katılmak İstiyorum',
    42 => 'Tarih Biçimi',
    43 => 'En Fazla Yazı Sayısı',
    44 => 'Bloklar Olmasın',
    45 => 'Görünüm Özellikleri -',
    46 => 'Görmek İstemediğiniz Konu ve Yazarlar -',
    47 => 'Haber Ayarları -',
    48 => 'Konular',
    49 => 'Yazılarda semboller kullanılmayacak',
    50 => 'İlgilenmiyorsanız işareti kaldırın',
    51 => 'Sadece haberler ile ilgili yazılar',
    52 => 'Varsayılan:',
    53 => 'Günün yazılarını her akşam al',
    54 => 'Görmek istemediğiniz konu ve kullanıcılar ile ilgili seçenekleri seçiniz.',
    55 => 'Site tarafından varsayılan seçim değerlerini kullanmak istiyorsanız, seçeneklerin tamamını boş bırakırsanız. Eğer herhangi bir seçim yaparsanız, varsayılan seçimler kullanılmaz, bu yüzden görmek istediğiniz tüm özellikleri seçmeniz gerekir. Varsayılan seçimler kalın yazı tipi ile belirtilmiştir.',
    56 => 'Yazarlar',
    57 => 'Görünüm Şekli',
    58 => 'Sıralama Şekli',
    59 => 'Yorum Sayısı Limiti',
    60 => 'Yorumlarınızın nasıl görüntülenmesini istersiniz?',
    61 => 'İlk en yeni mi, yoksa en eski mi gösterilsin?',
    62 => 'Varsayılan değer 100',
    63 => "Şifreniz email adresinize gönderildi. Lütfen, email mesajınızda belirtilen adımları uygulayın. {$_CONF['site_name']} kullandığınız için teşekkür ederiz!",
    64 => 'Yorum Ayarları -',
    65 => 'Bir Daha Sisteme Girmeyi Deneyin',
    66 => "Kullanıcı adınızı veya şifrenizi yanlış girdiniz. Lütfen aşağıdaki formu kullanarak bir daha sisteme giriş yapmayı deneyin. <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Yeni bir kullanıcı</a> mısınız?",
    67 => 'Üyelik Tarihi',
    68 => 'Beni hatırla:',
    69 => 'Sizi sisteme giriş yaptıktan sonra hatırlama süresi',
    70 => "{$_CONF['site_name']} için içerik ve görünüm ayarları düzenleyin",
    71 => "{$_CONF['site_name']} nin en büyük özelliği, içeriğinizi özelleştirebilir, bu sitenin tüm görüntüsünü değiştirebilirsiniz.  Bu büyük avantajlardan yararlanmak için öncelikle {$_CONF['site_name']} ne <a href=\"{$_CONF['site_url']}/users.php?mode=new\">kayıt yapmalısınız</a>.  Zaten kayıtlı bir üyemisiniz?  O zaman sol taraftaki formu kullanarak giriş yapınız!",
    72 => 'Tema',
    73 => 'Dil',
    74 => 'Sitenin görünümünü değiştirin!',
    75 => 'Email ile Gönderilecek Konular -',
    76 => 'If you select a topic from the list below you will receive any new stories posted to that topic at the end of each day.  Choose only the topics that interest you!',
    77 => 'Resim',
    78 => 'Resminizi Ekleyin!',
    79 => 'Resmi silmek için burayı seçin',
    80 => 'Siteye Giriş',
    81 => 'Email Yolla',
    82 => 'Son 10 Mesaj -',
    83 => 'Yazı gönderme istatistikleri -',
    84 => 'Yazılan yazıların toplamı:',
    85 => 'Yazılan yorumların toplamı:',
    86 => 'Gönderdiği tüm mesajlar:',
    87 => 'Giriş Adınız',
    88 => "Birisi (belki siz) {$_CONF['site_name']}, sitesindeki \"%s\" hesabınız için yeni bir şifre istedi <{$_CONF['site_url']}>.\n\nŞayet siz gerçekten bu şifreyi almak istiyorsanız, lütfen bu linki tıklayın:\n\n",
    89 => "Şayet bu şifreyi almak istemiyorsanız, bu mesajı dikkate almayın ve bu isteği önemsemeyin (şifreniz değişmeyecek ve olduğu gibi kalacaktır).\n\n",
    90 => 'Aşağıdaki hesabınız için yeni bir şifre girmelisiniz. Not: bu formu gönderinceye kadar eski şifreniz geçerlidir.',
    91 => 'Yeni Şifre Tespit Et',
    92 => 'Yeni Şifre Gir',
    93 => 'Yeni bir şifre isteğiniz %d saniye önceydi. Bu site şifre istekleri arasında en az %d saniye olmasını aramaktadır.',
    94 => '"%s" isimli üyenin Hesabını Sil',
    95 => 'Aşağıdaki "hesabı sil" butonuna tıklayınca hesabınız, veritabanımızdan kaldırılacaktır. Not, bu hesabınız altında gönderdiğiniz yazılar ve yorumlar <strong>silinmeyecektir</strong> fakat iletiler "İsimsiz Kullanıcı" olarak görüntülenecektir.',
    96 => 'hesabı sil',
    97 => 'Hesap Silme Onayı',
    98 => 'Hesabınızı silmek istediğinize eminmisiniz? Böylece yeni bir hesap yaratıncaya kadar bu siteye kayıtlı kullanıcı olarak giremeyeceksiniz. Şayet eminseniz aşağıdaki formda ki "hesabı sil" butonuna tekrar tıklayınız.',
    99 => 'isimli üyenin Gizlilik Seçenekleri',
    100 => 'Yöneticiden Email',
    101 => 'Site yöneticilerinden email izni',
    102 => 'Üyelerden Email',
    103 => 'Diğer üyelerden email izni',
    104 => 'Aktifliğinizin Görüntülenmesi',
    105 => 'Aktif Kullanıcılar Bloğunda görüntülenme',
    106 => 'Location',
    107 => 'Shown in your public profile',
    108 => 'Confirm new password',
    109 => 'Enter the New password again here',
    110 => 'Current Password',
    111 => 'Please enter your Current password',
    112 => 'You have exceeded the number of allowed login attempts.  Please try again later.',
    113 => 'Login Attempt Failed',
    114 => 'Account Disabled',
    115 => 'Your account has been disabled, you may not login. Please contact an Administrator.',
    116 => 'Account Awaiting Activation',
    117 => 'Your account is currently awaiting activation by an administrator. You will not be able to login until your account has been approved.',
    118 => "Your {$_CONF['site_name']} account has now been activated by an administrator. You may now login to the site at the url below using your username (<username>) and password as previously emailed to you.",
    119 => 'If you have forgotten your password, you may request a new one at this url:',
    120 => 'Account Activated',
    121 => 'Service',
    122 => 'Sorry, new user registration is disabled',
    123 => "Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?"
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Gösterilecek hiç haber yok',
    2 => 'Gösterilecek hiç haber yazısı yok. Bu konu hakkında hiç haber olmayabilir, veya belirlediğiniz ayarlar yüzünden gösterilemiyor olabilir',
    3 => ' %s için',
    4 => 'Günün Yazısı',
    5 => 'Sonraki',
    6 => 'Önceki',
    7 => 'First',
    8 => 'Last'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Mesaj gönderilirken bir hata oluştu. Lütfen bir daha deneyin.',
    2 => 'Mesajınız başarıyla gönderildi.',
    3 => 'Cevap Adresi alanına doğru bir email adresi girdiğinizden emin olunuz.',
    4 => 'Lütfen, Adınızı, Cevap Adresinizi, Konu ve Mesaj alanlarını doldurunuz',
    5 => 'Hata: Böyle bir kullanıcı yok.',
    6 => 'Hata oluştu.',
    7 => 'Kullanıcı Profili:',
    8 => 'Kullanıcı Adı',
    9 => 'Kullanıcı URL\'ı',
    10 => 'Mail yolla:',
    11 => 'Adınız:',
    12 => 'Cevap Adresi:',
    13 => 'Konu:',
    14 => 'Mesaj:',
    15 => 'HTML kodu çevrilmeyecektir.',
    16 => 'Mesajı Gönder',
    17 => 'Bu Yazıyı bir Arkadaşına Gönder',
    18 => 'Alıcının Adı',
    19 => 'Alıcının Email Adresi',
    20 => 'Gönderen Adı',
    21 => 'Gönderen Emaili',
    22 => 'Bütün alanları doldurmalısınız',
    23 => "Bu email size %s (%s) tarafından gönderilmiştir. Sizin bu yazı {$_CONF['site_url']} ile ilgilenebileceğinizi düşündü. Bu bir SPAM değildir, ve sizin email adresiniz herhangi bir şekilde bir listeye eklenmemiştir.",
    24 => 'Bu yazıya yorum ekle',
    25 => 'Bu özelliği kullanabilmeniz için sisteme giriş yapmanız gerekmektedir. Sitemize giriş yapmanız sayesinde sitemizin kötü kullanımını önlemiş olursunuz',
    26 => 'Bu form sizin seçtiğiniz kullanıcıya email yollamanızı sağlar. Tüm alanlar mecburidir.',
    27 => 'Mesaj',
    28 => '%s: ',
    29 => "Bu mesaj {$_CONF['site_name']} günlük özetidir. ",
    30 => ' Günlük Haber Özeti ',
    31 => 'Başlık',
    32 => 'Tarih',
    33 => 'Yazının tamamı için:',
    34 => 'Mesajın Sonu',
    35 => 'Üzgünüz, bu kullanıcı hiç mail almamayı tercih etmiş.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Gelişmiş Arama',
    2 => 'Anahtar Kelimeler',
    3 => 'Konu',
    4 => 'Tamamı',
    5 => 'Tipi',
    6 => 'Yazılar',
    7 => 'Yorumlar',
    8 => 'Yazarlar',
    9 => 'Tamamı',
    10 => 'Ara',
    11 => 'Arama Sonuçları',
    12 => 'bulundu',
    13 => 'Arama Sonuçları: Hiç kayıt bulunamadı',
    14 => 'Arama kriteriniz ile hiç kayıt bulunamadı:',
    15 => 'Lütfen bir daha deneyin.',
    16 => 'Başlık',
    17 => 'Tarih',
    18 => 'Yazar',
    19 => "{$_CONF['site_name']} sitesinin veri tabanında bütün yazıları ara.",
    20 => 'Tarih',
    21 => '-',
    22 => '(Tarih yapısı YYYY-AA-GG)',
    23 => 'Okunma Sayısı',
    24 => 'Found %d items',
    25 => 'kayıt bulundu. Toplam',
    26 => 'kayıt var. Arama süresi',
    27 => 'saniye.',
    28 => 'Aramanız sonucunda herhangi bir yazı veya yorum bulunamadı',
    29 => 'Yazı ve Yorum Arama Sonuçları',
    30 => 'No links matched your search Aramanız sonucunda herhangi bir Internet Adresi bulunamadı.',
    31 => 'Bu eklenti herhangi bir sonuç döndürmedi',
    32 => 'Etkinlik',
    33 => 'URL',
    34 => 'Yer',
    35 => 'Tüm Gün',
    36 => 'Aramanız sonucunda herhangi bir etkinlik bulunamadı.',
    37 => 'Etkinlik Arama Sonuçları',
    38 => 'Internet Adresleri Arama Sonuçları',
    39 => 'Adresler',
    40 => 'Etkinlikler',
    41 => 'Arama yapabilmeniz için en az 3 harften oluşan bir arama sorgusu girmeniz gerekmektedir.',
    42 => 'Lütfen YYYY-AA-GG (Yıl-Ay-Gün) şeklinde düzenlenmiş bir tarhi kullanınız.',
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
    53 => 'Yazı Sonuçları',
    54 => 'Yorum Sonuçları',
    55 => 'ibare',
    56 => 'VE',
    57 => 'YADA',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Site İstatistikleri',
    2 => 'Siteye gelen toplam trafik',
    3 => 'Sitedeki Yazılar(Yorumlar)',
    4 => 'Sitedeki Anketler(Cevaplar)',
    5 => 'Sitedeki Internet Adresleri(Gidilme Sayısı)',
    6 => 'Sitedeki Etkinlikler',
    7 => 'İlk 10 Yazı',
    8 => 'Yazı Başlığı',
    9 => 'Okunma&nbsp;Sayısı',
    10 => 'Sitenizde ya hiç yazı yok yada daha hiçkimse, hiçbir yazıyı okumamış.',
    11 => 'En Çok Yorum Alan 10 Yazı',
    12 => 'Yorum&nbsp;Sayısı',
    13 => 'Sitenizde ya hiç yazı yok yada daha hiç kimse yazılara yorum yazmamış.',
    14 => 'İlk 10 Anket',
    15 => 'Anket Sorusu',
    16 => 'Kullanılan&nbsp;Oy&nbsp;Sayısı',
    17 => 'Sitenizde ya hiç anket yok yada daha hiç kimse herhangi bir ankete oy vermemiş.',
    18 => 'İlk 10 İnternet Adresi',
    19 => 'Adresler',
    20 => 'Kullanım&nbsp;Sayısı',
    21 => 'Sitenizde ya hiç İnternet Adresi yok yada hiç kimse herhangi bir adresi kullanmamış.',
    22 => 'En çok e-mail ile gönderilen 10 Yazı',
    23 => 'Email&nbsp;Sayısı',
    24 => 'Hiç kimse sitenizdeki bir yazıyı bir arkadaşına göndermemiş.',
    25 => 'Top Ten Trackback Commented Stories',
    26 => 'No trackback comments found.',
    27 => 'Number of active users',
    28 => 'Top Ten Events',
    29 => 'Event',
    30 => 'Hits',
    31 => 'It appears that there are no events on this site or no one has ever clicked on one.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'İlgili',
    2 => 'Arkadaşına Gönder',
    3 => 'Basılmaya Uygun Şekli',
    4 => 'Seçenekler',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => '%s gönderebilmek için sisteme bir kullanıcı olarak giriş yapmış olmanız gerekiyor.',
    2 => 'Sisteme gir',
    3 => 'Yeni Kullanıcı',
    4 => 'Etkinlik Ekle',
    5 => 'İnternet Adresi Ekle',
    6 => 'Yazı Ekle',
    7 => 'Sisteme giriş yapmış olmanız gerekiyor',
    8 => 'Gönder',
    9 => 'Bir bilgi gönderirken, şu önerileri dikkate almanızı rica ederiz:<ul><li>Bütün alanları doldurmanız mecburidir.<li>Tam ve doğru bilgi veriniz<li>İnternet Adresi girerken iki kere kontrol ediniz</ul>',
    10 => 'Başlık',
    11 => 'İnternet Adresi',
    12 => 'Başlangıç Tarihi',
    13 => 'Bitiş Tarihi',
    14 => 'Yer',
    15 => 'Açıklama',
    16 => 'Farklı ise lütfen belirtiniz',
    17 => 'Kategori',
    18 => 'Diğer',
    19 => 'Önce Okuyun',
    20 => 'Hata: Kategori girilmemiş',
    21 => '"Diğer"\'i seçtiğinizde lütfen kategori adını girin',
    22 => 'Hata: Boş alanlar var',
    23 => 'Formdaki tüm alanları doldurunuz. Hepsinin doldurulması gerekmektedir.',
    24 => 'Gönderiniz Kaydedildi',
    25 => '%s gönderiniz başarıyla kaydedildi.',
    26 => 'Hız Limiti',
    27 => 'Kullanıcı Acı',
    28 => 'Konu',
    29 => 'Yazı',
    30 => 'En son gönderiniz ',
    31 => " saniye önceydi. Bu sitede iki gönderi arasında en az {$_CONF['speedlimit']} saniye geçmesi gerekmektedir",
    32 => 'Öz İzleme',
    33 => 'Yazı Ön İzleme',
    34 => 'Sistemden çık',
    35 => 'HTML kodlarının kullanımına izin verilmemektedir',
    36 => 'Gönderi Tipi',
    37 => "{$_CONF['site_name']} sitesine bir etkinlik göndermeniz halinde, gönderiniz sitenin Genel Takvim'ine eklenecektir. Genel Takvimi tüm kullanıcılar görür ve takvimde ilgilerini çeken etkinlikleri özel takvimlerine ekleyebilirler. Sitenin bu özelliği, kişisel etkinliklerinizi (doğum günleri, veya yıldönümlerini) eklemek için <b>değildir</b>. Etkinliği gönderdikten sonra, sitenin yönetiminin onayına gidecektir. Onay verildikten sonra Genel Takvim'de etkinliğinizi görebilirsiniz.",
    38 => 'Etkinlik Ekle:',
    39 => 'Genel Takvim',
    40 => 'Kişisel Takvim',
    41 => 'Bitiş Saati',
    42 => 'Başlangıç Saati',
    43 => 'Tüm Gün Etkinliği',
    44 => 'Adres Satırı 1',
    45 => 'Adres Satırı 2',
    46 => 'Şehir',
    47 => 'İlçe',
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
    1 => 'Sisteme Giriş Yapmış Olmanız Gerekiyor',
    2 => 'Engellendi! Sisteme Giriş Bilgileriniz Yanlış',
    3 => 'Şifre kullanıcı için yanlış:',
    4 => 'Kullanıcı Adı:',
    5 => 'Şifre:',
    6 => 'Sitenin yönetim alanlarında yapılan tüm işlemler kaydedilir ve kontrol edilir.<br>Bu sayfa sadece yetkili kişiler tarafından kullanılabilir.',
    7 => 'sisteme giriş yap'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Yetersiz Yönetici Hakları',
    2 => 'Bu bloğu düzenlemek için yeterli haklara sahip değilsiniz.',
    3 => 'Blok Düzenleyicisi',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Blok Başlığı',
    6 => 'Konu',
    7 => 'Tamamı',
    8 => 'Blok Güvenlik Seviyesi',
    9 => 'Blok Sırası',
    10 => 'Blok Tipi',
    11 => 'Portal Blok',
    12 => 'Normal Blok',
    13 => 'Portal Blok Özellikleri',
    14 => 'RDF Adresi',
    15 => 'Son RDF Değişikliği',
    16 => 'Normal Blok Özellikleri',
    17 => 'Blok İçeriği',
    18 => 'Lütfen Blok Başlığı, Güvenlik Seviyesi ve İçerik alanlarını doldurunuz.',
    19 => 'Blok Yöneticisi',
    20 => 'Blok Başlığı',
    21 => 'Blok Güv. Sev.',
    22 => 'Blok Tipi',
    23 => 'Blok Sırası',
    24 => 'Blok Konusu',
    25 => 'Bir bloğu silmek veya değiştirmek istiyorsanız, bloğun ismine basınız. Yeni bir blok yaratmak için yukarıdaki Yeni Blok düğmesine basınız.',
    26 => 'Düzenleme Bloğu',
    27 => 'PHP Blok',
    28 => 'PHP Blok Özellikleri',
    29 => 'Blok Fonksiyonu',
    30 => 'Eğer bloklarınızdan birinin PHP kodu kullanmasını istiyorsanız, PHP fonksiyonunun adını yukarıya giriniz. Fonksiyon adınız "phpblock_" ile başlamalıdır(örn. phpblock_getweather). Eğer bu şekilde başlamıyorsa, fonkisyonunuz çağrılmayacaktır. Bunu yapmamızın nedeni, Geeklog sürümünü değiştiren insanların sisteme zarar verebilecek fonksiyonları kullanmalarını önlemek içindir. Fonkisyon adından sonra boş parantez  "()" koymamaya dikkat edin. Son olarak, tüm PHP kodlarınızı /path/to/geeklog/system/lib-custom.php dosyasına koymanızı öneririz. Bu sayede sistemin yeni sürümünü yükleseniz bile yazdığını kişisel PHP kodları silinmez.',
    31 => 'PHP Bloğunda hata. %s fonksiyonu yok.',
    32 => 'Hata: Eksik alan(lar)',
    33 => 'Portal Blokları için .rdf dosyasına olan adresi girmeniz gerekmektedir.',
    34 => 'PHP Blokları için başlık ve fonkisyonu girmeniz gerekmektedir.',
    35 => 'Normal bloklar için başlık ve içeriği girmeniz gerekmektedir.',
    36 => 'Düzenleme bloğu için içerik girmelisiniz',
    37 => 'PHP Blok fonksiyonunun adı uygun değil',
    38 => 'PHP Bloklar için çağrılacak fonksiyonlar \'phpblock_\' ile başlamalıdır (örn. phpblock_getweather). Bu ön ek herhangi bir fonksiyonun çağrılmasını önlemek içindir.',
    39 => 'Kenar',
    40 => 'Sol',
    41 => 'Sağ',
    42 => 'Geeklog varsayılan blokları için, blok sırası ve güvenlik seviyesini girmelisiniz',
    43 => 'Sadece Ana Sayfa',
    44 => 'Erişim Engellendi',
    45 => "Erişim hakkınız olmayan bir yazıya erişmek istiyorsunuz. Bu eyleminiz kayıtlara eklenmiştir. Lütfen <a href=\"{$_CONF['site_admin_url']}/alan.php\">kontrol ana sayfasına geri dönün</a>.",
    46 => 'Yeni Blok',
    47 => 'Kontrol Ana Sayfası',
    48 => 'Alan Adı',
    49 => ' (boşluk kullanılmamalı ve tek olmalı)',
    50 => 'Yardım Dosyası Adresi',
    51 => 'http:// ile başlayın',
    52 => 'Bu alanı boş bırakırsanız, blok ile ilişkili yardım düğmesi gösterilmeyecektir',
    53 => 'Kullanıma Açık',
    54 => 'Kaydet',
    55 => 'Vazgeç',
    56 => 'Sil',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Etkinlik Düzenleyicisi',
    2 => 'Error',
    3 => 'Etkinlik Başlığı',
    4 => 'Etkinlik Adresi',
    5 => 'Etkinlik Başlangıç Tarihi',
    6 => 'Etkinlik Bitiş Tarihi',
    7 => 'Etkinlik Yeri',
    8 => 'Etkinlik Açıklaması',
    9 => '(http:// ile başlayın)',
    10 => 'Tüm alanları doldurmanız gerekmektedir',
    11 => 'Etkinlik Yöneticisi',
    12 => 'Bir etkinliği değiştirmek veya silmek istiyorsanız, adına basın. Yeni etkinlik yaratmak için Yeni Etkinlik düğmesine basın.',
    13 => 'Etkinlik Başlığı',
    14 => 'Başlangıç Tarihi',
    15 => 'Bitiş Tarihi',
    16 => 'Erişim Engellendi',
    17 => "Erişim hakkınız olmayan bir yazıya erişmek istiyorsunuz. Bu eyleminiz kayıtlara eklenmiştir. Lütfen <a href=\"{$_CONF['site_admin_url']}/event.php\">kontrol ana sayfasına geri dönün</a>.",
    18 => 'Yeni Etkinlik',
    19 => 'Kontrol Ana Sayfası',
    20 => 'Kaydet',
    21 => 'Vazgeç',
    22 => 'Sil',
    23 => 'Bad start date.',
    24 => 'Bad end date.',
    25 => 'End date is before start date.'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Önceki Yazı',
    2 => 'Sonraki Yazı',
    3 => 'Özellikler',
    4 => 'Gönderi Şekli',
    5 => 'Yazı Düzenle',
    6 => 'Sisteme kayıtlı hiç bir yazı bulunmamakta.',
    7 => 'Yazar',
    8 => 'kaydet',
    9 => 'ön izleme',
    10 => 'vazgeç',
    11 => 'sil',
    12 => 'ID',
    13 => 'Başlık',
    14 => 'Konu',
    15 => 'Tarih',
    16 => 'Özet',
    17 => 'İçerik',
    18 => 'Toplam okunma sayısı',
    19 => 'Yorumlar',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Yazı Listesi',
    23 => 'Bir yazıyı değiştirmek veya silmek istiyorsanız, yazının numarasına basınız. Bir yazıyı görüntülemek istiyorsanız, yazının başlığına basınız. Yeni bir yazı yaratmak istiyorsanız, yukarıdaki Yeni Yazı düğmesine basınız.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Yazı Ön İzlemi',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'File Upload Errors',
    31 => 'Lütfen, Yazar, Başlık ve Konu alanlarını doldurunuz.',
    32 => 'Öncelikli',
    33 => 'Sadece bir tane Öncelikli yazı olabilir.',
    34 => 'Taslak',
    35 => 'Evet',
    36 => 'Hayır',
    37 => 'Yazdıkları:',
    38 => 'Yazılanlar:',
    39 => 'Emailler',
    40 => 'Erişiminiz Engellendi',
    41 => "Erişim hakkınız olmayan bir yazıya erişmek istiyorsunuz. Bu eyleminiz kayıtlara eklenmiştir. Bu yazıya salt okunur şekilde aşağıdan erişebilirsiniz. İşiniz bittiği zaman lütfen <a href=\"{$_CONF['site_admin_url']}/story.php\">kontrol ekranına dönünüz</a>.",
    42 => "Erişim hakkınız olmayan bir yazıya erişmek istiyorsunuz.  Bu eyleminiz kayıtlara eklenmiştir.  Lütfen <a href=\"{$_CONF['site_admin_url']}/story.php\">kontrol ekranına geri dönünüz</a>.",
    43 => 'Yeni Yazı',
    44 => 'Kontrol Ana Sayfası',
    45 => 'Aç(access)',
    46 => '<b>NOT:</b> eğer ileride bir tarih verirseniz, yazınız o tarihe kadar yayımlanmayacaktır. Bu aynı zamanda bu yazının RDF başlıklarında ve arama ve istatistik sayfalarda görüntülenmeyecektir.',
    47 => 'Resimler',
    48 => 'resim',
    49 => 'sağ',
    50 => 'sol',
    51 => 'Bu resimlerden birini yazmakta olduğunuz yazıya eklemek istiyorsanız, eklemek istediğiniz yere: [imageX], [imageX_right] veya [imageX_left] yazın. Burada, X eklediğiniz resimin numarasıdır. left ve right ekleri imajın sola veya sağa dayalı olarak çıkmasına neden olur. NOT: Sadece eklediğiniz resimleri kullanabilirsiniz.  Eğer eklediğiniz resimleri kullanmazsanız yazınızı kaydedemezsiniz.<BR><P><B>Ön İzleme</B>:  Resim eklenmiş bir yazıyı Ön İzlem\'de görüntülemenin en iyi yolu: önce yazınızı Taslak olarak kaydetmenizdir. Bir yazıyı eğer resimleri eklenmediyse Ön İzleme butonunu kullanarak görüntüleyebilirsiniz.',
    52 => 'Sil',
    53 => 'kullanılmadı. Bu resmi özet veya yazı bölümlerinden birinde kullanmadan değişiklikleri kaydedemezsiniz',
    54 => 'Eklenen Resimler Kullanılmadı',
    55 => 'Aşağıdaki hatalar yazınızı kaydetmeye çalışırken oluştu.  Lütfen listelenen hataları kontrol edip düzeltiniz',
    56 => 'Sembolü Göster',
    57 => 'Ölçeksiz resim göster',
    58 => 'Story Management',
    59 => 'Option',
    60 => 'Enabled',
    61 => 'Auto Archive',
    62 => 'Auto Delete',
    63 => '',
    64 => '',
    65 => '',
    66 => '',
    67 => 'Expand the Content Edit Area size',
    68 => 'Reduce the Content Edit Area size',
    69 => 'Publish Story Date',
    70 => 'Toolbar Selection',
    71 => 'Basic Toolbar',
    72 => 'Common Toolbar',
    73 => 'Advanced Toolbar',
    74 => 'Advanced II Toolbar',
    75 => 'Full Featured',
    76 => 'Publish Options',
    77 => 'Javascript needs to be enabled for Advanced Editor. Option can be disabled in the main site config.php',
    78 => 'Click <a href="%s/story.php?mode=edit&amp;sid=%s&amp;editopt=default">here</a> to use default editor',
    79 => 'Preview',
    80 => 'Editor',
    81 => 'Publish Options',
    82 => 'Images',
    83 => 'Archive Options',
    84 => 'Permissions',
    85 => 'Show All'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Konu Düzenle',
    2 => 'Konu Tanımlayıcı',
    3 => 'Konu Adı',
    4 => 'Konu Resmi',
    5 => '(boşluk kullanmayın)',
    6 => 'Bir konuyu sildiğiniz zaman o konuyla ilişkili tüm yazılar ve bloklar silinecektir',
    7 => 'Lütfen Konu Tanımlayıcı ve  Konu Adı alanlarını doldurunuz',
    8 => 'Konu Yöneticisi',
    9 => 'Bir konuyu değiştirmek veya silmek istiyorsanız, konunun adına basınız.  Yeni bir konu yaratmak istiyorsanız, soldaki Yeni Konu düğmesine basınız. Her konuya olan erişim haklarınızı parantez içinde görebilirsiniz',
    10 => 'Sıralama',
    11 => 'Yazı/Sayfa',
    12 => 'Erişim Engellendi',
    13 => "Erişim hakkınız olmayan bir konuya erişmek istiyorsunuz.  Bu eyleminiz kayıtlara eklenmiştir. Lütfen <a href=\"{$_CONF['site_admin_url']}/topic.php\">konu kontrol ekranına geri dönünüz</a>.",
    14 => 'Sıralama yöntemi',
    15 => 'alfabetik',
    16 => 'standart',
    17 => 'Yeni Konu',
    18 => 'Kontrol Ana Sayfası',
    19 => 'kaydet',
    20 => 'vazgeç',
    21 => 'sil',
    22 => 'Varsayılan',
    23 => 'bildirilen yeni yazı için bunu varsayılan başlık yap',
    24 => '(*)',
    25 => 'Archive Topic',
    26 => 'make this the default topic for archived stories. Only one topic allowed.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Kullanıcı Düzenle',
    2 => 'Kullanıcı Tanımlayıcısı',
    3 => 'Kullanıcı Adı',
    4 => 'Gerçek Adı',
    5 => 'Şifresi',
    6 => 'Güvenlik Seviyesi',
    7 => 'Email Adresi',
    8 => 'Web Sitesi',
    9 => '(boşluk kullanmayın)',
    10 => 'Lütfen Kullanıcı Adı, Gerçek Adı, Güvenlik Seviyesi, ve Email Adresi alanlarını doldurunuz',
    11 => 'Kullanıcı Düzenleyici',
    12 => 'Bir kullanıcının bilgilerini değiştirmek veya silmek istiyorsanız, kullanıcı adına basınız.  Yeni bir kullanıcı yaratmak istiyorsanız, soldaki Yeni Kullanıcı düğmesine basınız. Aşağıdaki formda kullanıcı adını, email adresini veya gerçek adını girerek basit aramalar yapabilirsiniz (örneğin *son* or *.edu).',
    13 => 'Güvenlik Seviyesi',
    14 => 'Kayıt Tarihi',
    15 => 'Yeni Kullanıcı',
    16 => 'Kontrol Ana Sayfası',
    17 => 'şifre değiştir',
    18 => 'vazgeç',
    19 => 'sil',
    20 => 'kaydet',
    21 => 'Seçtiğiniz kullanıcı adı kullanılmakta.',
    22 => 'Hata',
    23 => 'Birden Fazla Kullanıcı Ekleme',
    24 => 'Birden Fazla Kullanıcı Ekleme',
    25 => 'Geeklog programına birden fazla kullanıcıyı ekleyebilirsiniz. Sekme ile ayrılmış bir metin dosyasının içine alanları şu sıra ile ekleyin: gerçek adı, kullanıcı adı, email adresi.  Eklenen her kullanıcıya rasgele atanmış bir şifre, kullanıcının email adresine gönderilecektir. Her satıra sadece bir kullanıcı adının eklenmiş olmasına dikkat ediniz. Herhangi bir yanlışlıkta eklenen her kullanıcıyı tek tek düzeltmek zorunda kalabilirsiniz. Bu yüzden dosyanızı iki kere kontrol edin!',
    26 => 'Ara',
    27 => 'Sonuçları Sınırla',
    28 => 'Resmi silmek için burayı seçin',
    29 => 'Adres',
    30 => 'Dışarıdan al',
    31 => 'Yeni Kullanıcılar',
    32 => 'Ekleme işlemi tamamlandı. %d kullanıcı eklendi ve %d hata oluştu',
    33 => 'gönder',
    34 => 'Hata: Yükleme yapmak için bir dosya seçmiş olmanız gerekiyor.',
    35 => 'Son Giriş',
    36 => '(asla)',
    37 => 'UID',
    38 => 'Group Listing',
    39 => 'Password (again)',
    40 => 'Registration Date',
    41 => 'Last login Date',
    42 => 'Banned',
    43 => 'Awaiting Activation',
    44 => 'Awaiting Authorization',
    45 => 'Active',
    46 => 'User Status',
    47 => 'Edit'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Onayla',
    2 => 'Sil',
    3 => 'Değiştir',
    4 => 'Profil',
    10 => 'Başlık',
    11 => 'Başlangıç Tarihi',
    12 => 'URL',
    13 => 'Kategori',
    14 => 'Tarih',
    15 => 'Konu',
    16 => 'Kullanıcı adı',
    17 => 'Gerçek adı',
    18 => 'Email',
    34 => 'Kontrol',
    35 => 'Eklenen Yazılar',
    36 => 'Eklenen Adresler',
    37 => 'Eklenen Etkinlikler',
    38 => 'Gönder',
    39 => 'Onaylamanız gereken herhangi bir eklenti yok',
    40 => 'Kullanıcıların ekledikleri'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Pazar',
    2 => 'Pazartesi',
    3 => 'Salı',
    4 => 'Çarşamba',
    5 => 'Perşembe',
    6 => 'Cuma',
    7 => 'Cumartesi',
    8 => 'Etkinlik Ekle',
    9 => 'ScriptEvi Etkinliği',
    10 => 'Etkinlikler:',
    11 => 'Genel Takvim',
    12 => 'Takvimim',
    13 => 'Ocak',
    14 => 'Şubat',
    15 => 'Mart',
    16 => 'Nisan',
    17 => 'Mayıs',
    18 => 'Haziran',
    19 => 'Temmuz',
    20 => 'Ağustos',
    21 => 'Eylül',
    22 => 'Ekim',
    23 => 'Kasım',
    24 => 'Aralık',
    25 => 'Geri: ',
    26 => 'Tüm Gün',
    27 => 'Hafta',
    28 => 'Kişisel Takvim:',
    29 => 'Genel Takvim',
    30 => 'etkinliği sil',
    31 => 'Ekle',
    32 => 'Etkinlik',
    33 => 'Tarih',
    34 => 'Saat',
    35 => 'Hızlı Ekle',
    36 => 'Gönder',
    37 => 'Özür dilerim, kişisel takvim özelliği bu sitede tanımlanmamış',
    38 => 'Kişisel Etkinlik Düzenleyicisi',
    39 => 'Gün',
    40 => 'Hafta',
    41 => 'Ay'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Mesaj Programı",
    2 => 'Kimden',
    3 => 'Cevaplama Adresi',
    4 => 'Konu',
    5 => 'İçerik',
    6 => 'Gönderim:',
    7 => 'Kullanıcı Ekle',
    8 => 'Admin',
    9 => 'Özellikler',
    10 => 'HTML',
    11 => 'Acil Mesaj!',
    12 => 'Gönder',
    13 => 'Temizle',
    14 => 'Kullanıcı ayarlarını dikkate alma',
    15 => 'Kullanıcı(lar)a gönderilemiyor: ',
    16 => 'Kullanıcı(lar)a başarıyla gönderildi: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Bir mesaj daha gönder</a>",
    18 => 'Kime',
    19 => 'NOT: eğer bütün site üyelerine mesaj göndermek istiyorsanız, seçim listesinden Sitedeki Kullanıcılar grubunu seçiniz.',
    20 => "<successcount> mesaj başarıyla gönderildi ama <failcount> mesajın gönderilmesinde sorun çıktı. Her gönderme denemesinin ayrıntıları aşağıda bulunmaktadır. <a href=\"{$_CONF['site_admin_url']}/mail.php\">Başka bir mesaj gönderebilir</a>, veya <a href=\"{$_CONF['site_admin_url']}/moderation.php\">Kontrol Ana Sayfası</a>na geri dönebilirisiniz.",
    21 => 'Başarısız',
    22 => 'Başarılı',
    23 => 'Başarısız olan gönderim yok',
    24 => 'Başarılı olan gönderim yok',
    25 => '-- Grup seçin --',
    26 => 'Lütfen formun tüm alanlarını doldurun ve şeçim listesinden bir kullanıcı grubu seçin.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Sisteme eklenti (plug-in) yükleyerek Geeklog\'un çalışmasını ve belki sisteminizi bozabilirsiniz. Sadece <a href="http://www.geeklog.net" target="_blank">Geeklog Ana Sayfası</a>\'ndan yüklediğiniz eklentileri yüklemeniz tavsiye edilir, çünkü bize ulaşan tüm eklentileri çeşitli işletim sistemleriyle ayrıntılı testlere sokuyoruz. Özellikle üçüncü firmalardan yüklediğiniz eklentilerin yüklenirken sisteminize zarar verebilecek programlar çalıştırabileceğini ve bunların güvenlik açıklarına neden olabileceğini anlamanız önemlidir. Bu uyarıya rağmen, biz bu eklentinin yüklenmesinin başarıyla tamamlanacağını garanti etmiyoruz, ve sisteminizde doğacak herhangi bir hasardan dolayı sorumluluk kabul etmiyoruz. Başka bir deyişle eklentiyi yüklerken doğacak tüm riskler size aittir.  Ayrıntıları öğrenmek isteyenler için her eklenti paketinde yüklemenin el ile yapılabilmesi için ayrıntılar ve adımlar mevcuttur.',
    2 => 'Eklenti Yükleme ile İlgili Yükümler',
    3 => 'Eklenti Yükleme Formu',
    4 => 'Eklenti Dosyası',
    5 => 'Eklenti Listesi',
    6 => 'Uyarı: Eklenti zaten yüklenmiş!',
    7 => 'Yüklemeye çalıştığınız eklenti zaten yüklenmiş. Eğer yeniden yüklemek istiyorsanız, eklentiyi önce silin.',
    8 => 'Eklenti uyumluluk kontrolü başarısız.',
    9 => 'Bu eklenti Geeklog\'un yeni bir versiyonun istemekte. Elinizdeki kopyayı ya <a href="http://www.geeklog.net">Geeklog</a> adresinden yenileyin ya da eklentinin yeni bir versiyonunu bulmalısınız.',
    10 => '<br><b>Şu anda hiç bir eklenti yüklenmemiş.</b><br><br>',
    11 => 'Bir eklentiyi değiştirmek veya silmek istiyorsanız eklentinin numarasına basın. Eklenti hakkında daha fazla bilgi edinmek için eklentinin adına basın. Bu eklentinin web sitesini açar. Bir eklenti yüklemek veya sürümünü yenilemek için dokümantasyonuna başvurun.',
    12 => 'plugineditor()\'e hiç bir eklenti adı sağlanmadı',
    13 => 'Eklenti Düzenle',
    14 => 'Yeni Eklenti',
    15 => 'Kontrol Ana Sayfası',
    16 => 'Eklenti Adı',
    17 => 'Eklenti Sürümü',
    18 => 'Geeklog Sürümü',
    19 => 'Kullanımda',
    20 => 'Evet',
    21 => 'Hayır',
    22 => 'Yükle',
    23 => 'Kaydet',
    24 => 'Vazgeç',
    25 => 'Sil',
    26 => 'Eklenti adı',
    27 => 'Eklenti Web Sitesi',
    28 => 'Eklenti Sürümü',
    29 => 'Geeklog Sürümü',
    30 => 'Eklentiyi Sil?',
    31 => 'Bu eklentiyi silmek istediğinizden eminmisiniz? Bunu yaparsanız eklentinin kullandığı tüm veriler ve veri yapıları da silinecektir. Eminseniz Sil düğmesine bir daha basınız.',
    32 => '<p><b>Error AutoLink tag not correct format</b></p>',
    33 => 'Code Version',
    34 => 'Update',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'create feed',
    2 => 'save',
    3 => 'delete',
    4 => 'cancel',
    10 => 'Content Syndication',
    11 => 'New Feed',
    12 => 'Admin Home',
    13 => 'To modify or delete a feed, click on the feed\'s title below. To create a new feed, click on New Feed above.',
    14 => 'Title',
    15 => 'Type',
    16 => 'Filename',
    17 => 'Format',
    18 => 'last updated',
    19 => 'Enabled',
    20 => 'Yes',
    21 => 'No',
    22 => '<i>(no feeds)</i>',
    23 => 'all Stories',
    24 => 'Feed Editor',
    25 => 'Feed Title',
    26 => 'Limit',
    27 => 'Length of entries',
    28 => '(0 = no text, 1 = full text, other = limit to that number of chars.)',
    29 => 'Description',
    30 => 'Last Update',
    31 => 'Character Set',
    32 => 'Language',
    33 => 'Contents',
    34 => 'Entries',
    35 => 'Hours',
    36 => 'Select type of feed',
    37 => 'You have at least one plugin installed that supports content syndication. Below you will need to select whether you want to create a Geeklog feed or a feed from one of the plugins.',
    38 => 'Error: Missing Fields',
    39 => 'Please fill in the Feed Title, Description, and Filename.',
    40 => 'Please enter a  number of entries or number of hours.',
    41 => 'Links',
    42 => 'Events',
    43 => 'All',
    44 => 'None',
    45 => 'Header-link in topic',
    46 => 'Limit Results',
    47 => 'Search',
    48 => 'Edit',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})"
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Şifreniz email adresinize gönderilmiştir. Lütfen, email adresinize gelen mesajdaki adımları uygulayın. {$_CONF['site_name']} kullandığınız için teşekkür ederiz.",
    2 => 'Yazınızı sitemize gönderdiğiniz için teşekkür ederiz.  Yazınız, site yönetimi tarafından onaylandıktan sonra yayımlanacaktır.',
    3 => "İnternet adresini sitemize gönderdiğiniz için teşekkür ederiz. Adresiniz, site yönetimi tarafından onaylandıktan sonra yayımlanacaktır. Onaylandıktan sonra gönderdiğiniz adresi<a href={$_CONF['site_url']}/links.php>Adresler</a> bölümünde görebilirsiniz.",
    4 => "Sitemize eklediğiniz etkinlik için teşekkür ederiz.  Gönderdiğiniz etkinlik, site yönetimi tarafından onaylandıktan sonra yayımlanacaktır. Onaylandıktan sonra <a href={$_CONF['site_url']}/calendar.php>takvim</a> bölümünde görebilirsiniz.",
    5 => 'Kayıt bilgileriniz başarılı bir şekilde kaydedildi.',
    6 => 'Görünüm ayarlarınız başarılı bir şekilde kaydedildi.',
    7 => 'Yorum tercihleriniz başarılı bir şekilde kaydedildi.',
    8 => 'Sistemden başarıyla çıktınız.',
    9 => 'Yazınız başarıyla kaydedildi.',
    10 => 'Yazınız başarıyla silindi.',
    11 => 'Bloğunuz başarıyla kaydedildi.',
    12 => 'Bloğunuz başarıyla silindi.',
    13 => 'Konunuz başarıyla kaydedildi.',
    14 => 'Konunuz ve bütün yazıları ve alanları başarıyla silindi.',
    15 => 'Internet Adresiniz başarıyla kaydedildi.',
    16 => 'Internet Adresiniz başarıyla silindi.',
    17 => 'Etkinliğiniz başarıyla kaydedildi.',
    18 => 'Etkinliğiniz başarıyla silindi.',
    19 => 'Anketiniz başarıyla kaydedildi.',
    20 => 'Anketiniz başarıyla silindi.',
    21 => 'Yeni kullanıcı başarıyla kaydedildi.',
    22 => 'Yeni kullanıcı başarıyla silindi.',
    23 => 'Takviminize etkinlik eklerken sorun oluştu. Etkinlik tanımlayıcısı tanımlanmamış.',
    24 => 'Takviminize etkinlik başarıyla eklendi.',
    25 => 'Sisteme giriş yapmadan kişisel takviminizi açamazsınız.',
    26 => 'Kişisel takviminizden etkinlik başarıyla silinmiştir.',
    27 => 'Mesaj başarılya iletildi.',
    28 => 'Eklenti başarıyla eklendi.',
    29 => 'Üzgünüm, kişisel takvimler bu sitede kullanılamıyor.',
    30 => 'Erişim Engellendi',
    31 => 'Yazı kontrol sayfalarına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    32 => 'Konu kontrol sayfalarına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    33 => 'Blok kontrol sayfalarına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    34 => 'Internet Adresi kontrol sayfalarına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    35 => 'Etkinlik kontrol sayfalarına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    36 => 'Anket kontrol sayfalarına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    37 => 'Kullanıcı kontrol sayfalarına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    38 => 'Eklenti kontrol sayfalarına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    39 => 'Mesaj kontrol sayfalarına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    40 => 'Sistem Mesajı',
    41 => 'Kelime değiştirme sayfasına erişiminiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    42 => 'Kelimeniz başarıyla kaydedildi.',
    43 => 'Kelimeniz  başarıyla silindi.',
    44 => 'Eklenti başarılya yüklendi!',
    45 => 'Eklenti başarıyla silindi.',
    46 => 'Veri tabanı yedekleme programına erişimiz yok.  Giriş izni olmayan tüm etkinlikler kayıtlara geçmektedir.',
    47 => 'Bu özellik sadece Linux, Unix gibi işletim sistemlerinde çalışır.  Eğer Linux, Unix gibi bir işletim sistemi kullanıyorsanız, önbelleğiniz başarıyla temizlenmiştir. Eğer Windows kullanıyorsanız, adodb_*.php  dosyalarını aratın ve silin.',
    48 => "{$_CONF['site_name']} sitesine üyelik başvurunuz için teşekkür ederiz. Site yönetimi başvurunuzu inceleyecektir. Eğer kabul alırsanız şifreniz belirttiğiniz eğmail adreisne gönderilecektir.",
    49 => 'Grubunuz başarıyla kaydedildi.',
    50 => 'Grup başarıyla silindi.',
    51 => 'Bu kullanıcı adı zaten kullanılıyor. Lütfen başka bir tane seçin.',
    52 => 'Sağlanan email adresi geçerli bir email adresi olarak gözükmüyor.',
    53 => 'Yeni şifreniz kabul edildi. Lütfen aşağıdan yeni şifrenizi kullanarak şimdi giriş yapın.',
    54 => 'Yeni bir şifre isteme süresiniz doldu. Lütfen aşağıdan tekrar deneyin.',
    55 => 'Size bir email gönderildi ve az önce yerine ulaştı. Hesabınıza yeni bir şifre tayin etmek için mesajdaki talimatları lütfen takip ediniz.',
    56 => 'Sağlanan email adresi zaten başka bir hesap tarafından kullanılıyor.',
    57 => 'Hesabınız başarıyla silindi.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.',
    60 => 'The plugin was successfully updated',
    61 => 'Plugin %s: Unknown message placeholder',
    62 => 'The trackback comment has been deleted.',
    63 => 'An error occurred when deleting the trackback comment.',
    64 => 'Your trackback comment has been successfully sent.',
    65 => 'Weblog directory service successfully saved.',
    66 => 'The weblog directory service has been deleted.',
    67 => 'The new password does not match the confirmation password!',
    68 => 'You have to enter the correct current password.',
    69 => 'Your account has been blocked!',
    70 => 'Your account is awaiting administrator approval.',
    71 => 'Your account has now been confirmed and is awaiting administrator approval.',
    72 => 'An error occured while attempting to install the plugin. See error.log for details.',
    73 => 'An error occured while attempting to uninstall the plugin. See error.log for details.',
    74 => 'The pingback has been successfully sent.',
    75 => 'Trackbacks must be sent using a POST request.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Erişim',
    'ownerroot' => 'Sahibi/Root',
    'group' => 'Grup',
    'readonly' => 'Salt Okunur',
    'accessrights' => 'Erişim Hakları',
    'owner' => 'Sahibi',
    'grantgrouplabel' => 'Yukarıdaki Grup Değiştirme Haklarına İzin Ver',
    'permmsg' => 'NOT: Üyeler bu sitenin, siteye girmiş olan üyelerine denir, ve Herhangi ise sitede bulundan ama siteye giriş yapmamış herhangi bir kullanıcıya denir.',
    'securitygroups' => 'Güvenlik Grupları',
    'editrootmsg' => "Kullanıcı Yöneticisi olmanıza rağmen root kullanıcısını, root kullanıcısı olmadan değiştiremezsiniz. Root kullanıcısı dışında herhangi bir kullanıcıyı değiştirebiliriniz. Root kullanıcısına olan izinsiz tüm etkinlikler kaydedilmektedir. Lütfen <a href=\"{$_CONF['site_admin_url']}/user.php\">Kullarnıcı Kontrol Sayfası</a>'na geri dönün.",
    'securitygroupsmsg' => 'Kullanıcının bulunmasını istediğiniz grupları lütfen seçiniz.',
    'groupeditor' => 'Grup Düzenleyicisi',
    'description' => 'Tanım',
    'name' => 'Ad',
    'rights' => 'Haklar',
    'missingfields' => 'Eksik Bloklar',
    'missingfieldsmsg' => 'Gruba bir Ad ve Tanım vermelisiniz.',
    'groupmanager' => 'Grup Düzenleyicisi',
    'newgroupmsg' => 'Bir grubu değiştirmek veya silmek istiyorsanız, grubun adına basınız. Yeni bir grup yaratmak için yukarıdan Yeni Grup düğmesine basınız. Sistem tarafından yaratılmış temel gruplar sistem tarafından kullanıldığı için silinemez.',
    'groupname' => 'Grup Adı',
    'coregroup' => 'Temel Grubu',
    'yes' => 'Evet',
    'no' => 'Hayır',
    'corerightsdescr' => "Bu grup bir temel {$_CONF['site_name']} grubudur.  Bu nedenden bu grubun erişim hakları değiştirlemez. Aşaığda bu grubun hangi haklara sahip olduğunun listesi bulunmaktadır.",
    'groupmsg' => 'Bu sitede kullanılan güvenlik grupları hiyerarşiktir. Bir grubu bu gruba ekleyerek bu grubun sahip olduğu erişim haklarıyla aynı erişim haklarını eklediğiniz gruba vermiş olursunuz. Bir gruba güvenlik hakları vermek için aşağıdaki grupları kullanarak gruplar oluşturmanı önerilir. Eğer bir gruba özel haklar vermek istiyorsanız, aşağıdaki \'Haklar\' bölümünden istediğiniz özellikleri seçebilirsiniz. Bu grubu bir başka grup(lar)ın altına eklemek için sadece aşağıdaki gruplardan istediklerinizi seçin.',
    'coregroupmsg' => "Bu grup bir temel {$_CONF['site_name']} grubudur.  Bu yüzden bu grubun bulunduğu gruplar değiştirilemez. Bu grubun bulunduğu grupların salt okunur listesi aşağıdadır.",
    'rightsdescr' => 'Bir grubun bir erişim hakkı buradan verilebilir veya grubun bir üst grubu varsa o gruba verilerek bu gurubun alması sağlanabilinir. Aşağıda eğer seçme kutusu olmayan haklar varsa bunlar bu grubun üyesi olduğu bir üst gruba verilmiş olan haklardır. Seçme kutusu olan hakları seçerek bu gruba daha geniş bir hak verebilirsiniz.',
    'lock' => 'Kilit',
    'members' => 'Üyeler',
    'anonymous' => 'İsimsiz Kullanıcı',
    'permissions' => 'İzinler',
    'permissionskey' => 'R = oku, E = düzenle, haklarda değişiklik yap',
    'edit' => 'Değiştir',
    'none' => 'Hiçbiri',
    'accessdenied' => 'Erişim Engellendi',
    'storydenialmsg' => "Bu yazıyı okuma yetkiniz yok. Bunun nedeni {$_CONF['site_name']} sitesinin bir üyesi olmamanızdan kaynaklanıyor olabilir. Lütfen {$_CONF['site_name']} sitesinin <a href=users.php?mode=new> üyesi olun</a> ve sadece üyelere verilen haklara kavuşun!",
    'eventdenialmsg' => "Bu etkinliği görüntüleme yetkiniz yok. Bunun nedeni {$_CONF['site_name']} sitesinin bir üyesi olmamanızdan kaynaklanıyor olabilir. Lütfen {$_CONF['site_name']} sitesinin <a href=users.php?mode=new> üyesi olun</a> ve sadece üyelere verilen haklara kavuşun!",
    'nogroupsforcoregroup' => 'Bu grup bir başka gruba dağil değil.',
    'grouphasnorights' => 'Bu grup, sitenin hiç bir yönetimsel özelliklerine sahip değil.',
    'newgroup' => 'Yeni Grup',
    'adminhome' => 'Kontrol Ana Sayfası',
    'save' => 'kaydet',
    'cancel' => 'vazgeç',
    'delete' => 'sil',
    'canteditroot' => 'Root grubu değiştirmeye çalıştınız, fakat root grubun bir üyesi değilsiniz. Bu nedenden erişiminiz engellendi. Eğer bunun bir hata olduğunu düşünüyorsanız sistem yöneticinize danışın.',
    'listusers' => 'Üye Listesi',
    'listthem' => 'liste',
    'usersingroup' => 'Üye grubu %s',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.',
    'cantlistgroup' => 'To see the members of this group, you have to be a member yourself. Please contact the system administrator if you feel this is an error.',
    'editgroupmsg' => 'To modify the group membership, click on the member names(s) and use the add or remove buttons. If the member is a member of the group, their name will appear on the right side only. Once you are complete - press <b>Save</b> to update the group and return to the main group admin page.',
    'listgroupmsg' => 'Listing of all current members in the group: <b>%s</b>',
    'search' => 'Search',
    'submit' => 'Submit',
    'limitresults' => 'Limit Results',
    'group_id' => 'Group ID',
    'plugin_access_denied_msg' => 'You are illegally trying access a plugin administration page.  Please note that all attempts to illegally access this page are logged.',
    'groupexists' => 'Group name already exists',
    'groupexistsmsg' => 'There is already a group with this name. Group names must be unique.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Son 10 yedekleme',
    'do_backup' => 'Yedekleme Yap',
    'backup_successful' => 'Veritabanı yedeklemesi başarıyla sonuçlandı.',
    'db_explanation' => 'Geeklog sisteminin yeni bir yedeğini almak için, aşağıdaki butona basın.',
    'not_found' => "Hatalı adres veya mysqldump programı çalıştırılınamıyor.<br>config.php dosyanızdaki <strong>\$_DB_mysqldump_path</strong> değişkenini kontrol edin.<br>Değişken şu anki değeri: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Yedekleme başarısız: Dosya boyutu 0 bayt idi.',
    'path_not_found' => "{$_CONF['backup_path']} adresi yok veya bir klasör değil",
    'no_access' => "HATA: Kalsör {$_CONF['backup_path']} erişilinemiyor.",
    'backup_file' => 'Yedek dosyası',
    'size' => 'Boyut',
    'bytes' => 'Bayt',
    'total_number' => 'Toplam backup sayısı: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Ana Sayfa',
    2 => 'İletişim',
    3 => 'Yazı Yazın',
    4 => 'Adresler',
    5 => 'Anketler',
    6 => 'Takvim',
    7 => 'Site İstatistikleri',
    8 => 'Özelleştir',
    9 => 'Ara',
    10 => 'Gelişmiş Arama',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Hatası',
    2 => 'Üff, her yere baktım ama <b>%s</b> bulamadım.',
    3 => "<p>Üzgünüz, belirttiğiniz dosya bulunamıyor. Lütfen <a href=\"{$_CONF['site_url']}\">ana sayfa</a>ya veya <a href=\"{$_CONF['site_url']}/search.php\">arama sayfası</a>'na bakarak kaybettiğiniz dokümanı bulabilecekmisiniz bir bakın."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Sisteme giriş yapmanız gerekiyor',
    2 => 'Üzgünüm, bu alana giriş yapabilmeniz için bir kullanıcı olarak giriş yapmanız gerekiyor.',
    3 => 'Giriş yap',
    4 => 'Yeni Kullanıcı'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'The PDF feature has been disabled',
    2 => 'The document provided was not rendered. The document was received but could not be processed.  Please make sure to submit only html formatted documents that have been written to the xHTML standard. Please note that overly complex html documents may not render correctly or at all.The document resulting from your attempt was 0 bytes in length, and has been deleted. If you\'re sure that your document should render fine, please re-submit it.',
    3 => 'Unknown error during PDF generation',
    4 => "No page data was given or you want to use the ad-hoc PDF generation tool below.  If you think you are getting this page\n          in error then please contact the system administrator.  Otherwise, you may use the form below to generate PDF's in an ad-hoc fashion.",
    5 => 'Loading your document.',
    6 => 'Please wait while your document is loaded.',
    7 => 'You may right click the button below and choose \'save target...\' or \'save link location...\' to save a copy of your document.',
    8 => "The path given in the configuration file to the HTMLDoc binary is invalid or this system cannot execute it.  Please contact the site administrator if this problem\n          persists.",
    9 => 'PDF Generator',
    10 => "This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This\n           is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site",
    11 => 'URL',
    12 => 'Generate PDF!',
    13 => 'The PHP configuration on this server does not allow URLs to be used with the fopen() command.  The system administrator must edit the php.ini file and set allow_url_fopen to On',
    14 => 'The PDF you requested either does not exist or you tried to illegally access a file.'
);

###############################################################################
# trackback.php

$LANG_TRB = array(
    'trackback' => 'Trackback',
    'from' => 'from',
    'tracked_on' => 'Tracked on',
    'read_more' => '[read more]',
    'intro_text' => 'Here\'s what others have to say about \'%s\':',
    'no_comments' => 'No trackback comments for this entry.',
    'this_trackback_url' => 'Trackback URL for this entry:',
    'num_comments' => '%d trackback comments',
    'send_trackback' => 'Send Pings',
    'preview' => 'Preview',
    'editor_title' => 'Send trackback comment',
    'trackback_url' => 'Trackback URL',
    'entry_url' => 'Entry URL',
    'entry_title' => 'Entry Title',
    'blog_name' => 'Site Name',
    'excerpt' => 'Excerpt',
    'truncate_warning' => 'Note: The receiving site may truncate your excerpt',
    'button_send' => 'Send',
    'button_preview' => 'Preview',
    'send_error' => 'Error',
    'send_error_details' => 'Error when sending trackback comment:',
    'url_missing' => 'No Entry URL',
    'url_required' => 'Please enter at least a URL for the entry.',
    'target_missing' => 'No Trackback URL',
    'target_required' => 'Please enter a trackback URL',
    'error_socket' => 'Could not open socket.',
    'error_response' => 'Response not understood.',
    'error_unspecified' => 'Unspecified error.',
    'select_url' => 'Select Trackback URL',
    'not_found' => 'Trackback URL not found',
    'autodetect_failed' => 'Geeklog could not detect the Trackback URL for the post you want to send your comment to. Please enter it manually below.',
    'trackback_explain' => 'From the links below, please select the URL you want to send your Trackback comment to. Geeklog will then try to determine the correct Trackback URL for that post. Or you can <a href="%s">enter it manually</a> if you know it already.',
    'no_links_trackback' => 'No links found. You can not send a Trackback comment for this entry.',
    'pingback' => 'Pingback',
    'pingback_results' => 'Pingback results',
    'send_pings' => 'Send Pings',
    'send_pings_for' => 'Send Pings for "%s"',
    'no_links_pingback' => 'No links found. No Pingbacks were sent for this entry.',
    'pingback_success' => 'Pingback sent.',
    'no_pingback_url' => 'No pingback URL found.',
    'resend' => 'Resend',
    'ping_all_explain' => 'You can now notify the sites you linked to (<a href="http://en.wikipedia.org/wiki/Pingback">Pingback</a>), advertise that your site has been updated by pinging weblog directory services, or send a <a href="http://en.wikipedia.org/wiki/Trackback">Trackback</a> comment in case you wrote about a post on someone else\'s site.',
    'pingback_button' => 'Send Pingback',
    'pingback_short' => 'Send Pingbacks to all sites linked from this entry.',
    'pingback_disabled' => '(Pingback disabled)',
    'ping_button' => 'Send Ping',
    'ping_short' => 'Ping weblog directory services.',
    'ping_disabled' => '(Ping disabled)',
    'trackback_button' => 'Send Trackback',
    'trackback_short' => 'Send a Trackback comment.',
    'trackback_disabled' => '(Trackback disabled)',
    'may_take_a_while' => 'Please note that sending Pingbacks and Pings may take a while.',
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
    'trackback_note' => 'To send a trackback comment for a story, go to the list of stories and click on "Send Ping" for the story. To send a trackback that is not related to a story, <a href="%s">click here</a>.',
    'pingback_explain' => 'Enter a URL to send the Pingback to. The pingback will point to your site\'s homepage.',
    'pingback_url' => 'Pingback URL',
    'site_url' => 'This site\'s URL',
    'pingback_note' => 'To send a pingback for a story, go to the list of stories and click on "Send Ping" for the story. To send a pingback that is not related to a story, <a href="%s">click here</a>.',
    'pbtarget_missing' => 'No Pingback URL',
    'pbtarget_required' => 'Please enter a pingback URL',
    'pb_error_details' => 'Error when sending the pingback:'
);

###############################################################################
# directory.php

$LANG_DIR = array(
    'title' => 'Article Directory',
    'title_year' => 'Article Directory for %d',
    'title_month_year' => 'Article Directory for %s %d',
    'nav_top' => 'Back to Article Directory',
    'no_articles' => 'No articles.'
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
    'new_string' => '%n new %i in the last %t %s',
    'new_last' => 'last %t %s',
    'minutes' => 'minutes',
    'hours' => 'hours',
    'days' => 'days',
    'weeks' => 'weeks',
    'months' => 'months',
    'minute' => 'minute',
    'hour' => 'hour',
    'day' => 'day',
    'week' => 'week',
    'month' => 'month'
);

###############################################################################
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array(
    'search' => 'Search',
    'limit_results' => 'Limit Results',
    'submit' => 'Submit',
    'edit' => 'Edit',
    'admin_home' => 'Admin Home',
    'create_new' => 'Create New',
    'enabled' => 'Enabled',
    'title' => 'Title',
    'type' => 'Type',
    'topic' => 'Topic',
    'help_url' => 'Help File URL',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'copy' => 'Copy',
    'no_results' => '- No entries found -',
    'data_error' => 'There was an error processing the subscription data. Please check the data source.'
);

###############################################################################
# Localisation of the texts for the various drop-down menus that are actually
# stored in the database. If these exist, they override the texts from the
# database.

$LANG_commentcodes = array(
    0 => 'Comments Enabled',
    -1 => 'Comments Disabled'
);


$LANG_commentmodes = array(
    'flat' => 'Flat',
    'nested' => 'Nested',
    'threaded' => 'Threaded',
    'nocomment' => 'No Comments'
);

$LANG_cookiecodes = array(
    0 => '(don\'t)',
    3600 => '1 Hour',
    7200 => '2 Hours',
    10800 => '3 Hours',
    28800 => '8 Hours',
    86400 => '1 Day',
    604800 => '1 Week',
    2678400 => '1 Month'
);

$LANG_dateformats = array(
    0 => 'System Default'
);

$LANG_featurecodes = array(
    0 => 'Not Featured',
    1 => 'Featured'
);

$LANG_frontpagecodes = array(
    0 => 'Show Only in Topic',
    1 => 'Show on Front Page'
);

$LANG_postmodes = array(
    'plaintext' => 'Plain Old Text',
    'html' => 'HTML Formatted'
);

$LANG_sortcodes = array(
    'ASC' => 'Oldest First',
    'DESC' => 'Newest First'
);

$LANG_trackbackcodes = array(
    0 => 'Trackback Enabled',
    -1 => 'Trackback Disabled'
);

?>