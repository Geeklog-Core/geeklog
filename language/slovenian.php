<?php

###############################################################################
# slovenian.php
# language file for geeklog version 1.3.10
#
# This is the slovenian language page for GeekLog!
# Special thanks to Mischa Polivanov for his work on this project
#
# Prevedel gape@gape.org ; za pripombe, predloge ipd ... pi�i na email
# med plug-ini �e nekaj manjka ... ker ne razumem scene
# 
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
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

$LANG_CHARSET = 'windows-1250';

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
    1 => 'Pi�e:',
    2 => 'Beri dalje',
    3 => 'komentarjev.',
    4 => 'Uredi',
    5 => 'Anketa',
    6 => 'Rezultati',
    7 => 'Rezultati ankete',
    8 => 'glasov<br>',
    9 => 'Administracijske funkcije:',
    10 => '�akajo�a vsebina',
    11 => '�lanki',
    12 => 'Bloki',
    13 => 'Teme',
    14 => 'Povezave',
    15 => 'Dogodki',
    16 => 'Ankete',
    17 => 'Uporabniki',
    18 => 'SQL poizvedovanje',
    19 => 'Izhod iz sistema',
    20 => 'Podatki o uporabniku:',
    21 => 'Uporabni�ko ime',
    22 => 'Uporabni�ki ID',
    23 => 'Varnostni nivo',
    24 => 'Anonimni uporabnik',
    25 => 'Odgovori',
    26 => 'Za komentarje so odgovorni njihovi avtorji. Avtorji spletne strani na komentarje obiskovalcev nimamo nobenega vpliva.',
    27 => 'Zadnjikrat komentirano',
    28 => 'Izbri�i',
    29 => 'Ni komentarjev.',
    30 => 'Starej�i �lanki',
    31 => 'Dovoljeni HTML ukazi:',
    32 => 'Napaka, neveljavno uporabni�ko ime',
    33 => 'Napaka, ne morem shranjevati v log datoteko',
    34 => 'Napaka',
    35 => 'Izhod iz sistema',
    36 => 'dne',
    37 => 'Ni �lankov',
    38 => 'Zdru�evanje vsebine (Syndication)',
    39 => 'Osve�i',
    40 => 'Izklju�ene so <tt>register_globals = Off</tt> v <tt>php.ini</tt>. Geeklog zahteva <tt>register_globals</tt> <strong>vklju�ene</strong>. Preden nadaljuje�, jih prosim <strong>vklju�i</strong> in ponovno za�eni web server.',
    41 => 'Gostje',
    42 => 'Prispeval/a:',
    43 => 'Odgovori na To',
    44 => 'Star�',
    45 => 'MySQL �tevilka napake',
    46 => 'MySQL sporo�ilo o napaki',
    47 => 'Prijava uporabnika',
    48 => 'Podatki o uporabni�kem ra�unu',
    49 => 'Nastavitve',
    50 => 'Napaka v SQL ukazu',
    51 => 'pomo�',
    52 => 'Novo',
    53 => 'Administratorske strani',
    54 => 'Ne morem odpreti datoteke',
    55 => 'Napaka na',
    56 => 'Glasuj',
    57 => 'Geslo',
    58 => 'Prijava',
    59 => "Niste registriran uporabnik?  <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Registrirajte se</a>.",
    60 => 'Dodaj komentar',
    61 => 'Nov uporabnik',
    62 => 'besed',
    63 => 'Nastavitve komentarjev',
    64 => 'Po�lji �lanek prijatelju po e-po�ti',
    65 => 'Stran prijazna za tisk',
    66 => 'Osebni koledar',
    67 => 'Dobrodo�li na ',
    68 => 'Domov',
    69 => 'Kontakt',
    70 => 'I��i',
    71 => 'Dodaj �lanek',
    72 => 'Zanimive povezave',
    73 => 'Pretekle ankete',
    74 => 'Koledar dogodkov',
    75 => 'Napredno iskanje',
    76 => 'Statistika spletne strani',
    77 => 'Priklju�eni moduli',
    78 => 'Dogodki',
    79 => 'Kaj je novega',
    80 => '�lankov v zadnjih',
    81 => '�lanek v zadnjih ',
    82 => 'urah',
    83 => 'KOMENTARJI BRALCEV<br>',
    84 => 'POVEZAVE<br>',
    85 => 'v zadnjih 48 urah',
    86 => 'ni novih komentarjev',
    87 => 'v zadnjih 2 tednih',
    88 => 'ni novih povezav',
    89 => 'Trenutno ni nobenih prihajajo�ih dogodkov.',
    90 => 'Na osnovno stran',
    91 => 'Spletna stran zgenerirana v',
    92 => 'sekundah',
    93 => 'Copyright',
    94 => 'Vsa na�a koda pripada vam.',
    95 => 'Gnano z',
    96 => 'Uporabni�ke skupine',
    97 => 'Seznam besed',
    98 => 'Priklju�ni moduli',
    99 => '�LANKI',
    100 => 'Ni novih �lankov',
    101 => 'Va�i dogodki',
    102 => 'Najavljeno je:',
    103 => 'DB Bekapi',
    104 => 'z',
    105 => 'Email uporabniki',
    106 => 'Ogledov',
    107 => 'GL Test verzije',
    108 => 'Izprazni cache',
    109 => 'Prijavi zlorabo',
    110 => 'Prijavi ta prispevek upravniku strani',
    111 => 'PDF verzija',
    112 => 'Prijavljeni uporabniki',
    113 => 'Dokumentacija',
    114 => 'TRACKBACKS',
    115 => 'No new trackback comments',
    116 => 'Trackback',
    117 => 'Directory',
    118 => 'Please continue reading on the next page:',
    119 => "Lost your <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">password</a>?",
    120 => 'Permanent link to this comment',
    121 => 'Comments (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'All HTML is allowed',
    124 => 'Click to delete all checked items',
    125 => 'Are you sure you want to Delete all checked items?',
    126 => 'Select or de-select all items'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Po�iljanje komentarja',
    2 => 'Oblika besedila',
    3 => 'Odjava',
    4 => 'Registrirajte se',
    5 => 'Uporabni�ko ime',
    6 => '�e �elite posredovati komentar se morate registrirati. �e �e nimate svojega uporabni�kega imena in gesla, kliknite spodaj.',
    7 => 'Va� zadnji komentar je bil pred',
    8 => " sekundami.  Med posameznimi komentarji bralca mora prete�i vsaj {$_CONF['commentspeedlimit']} sekund",
    9 => 'Komentar',
    10 => 'Po�lji prijavo',
    11 => 'Po�lji komentar',
    12 => '�e �elite posredovati komentar, vpi�ite va�e ime, e-mail naslov, naslov komentarja in vsebino komentarja.',
    13 => 'Va�e informacije',
    14 => 'Predogled',
    15 => 'Report this post',
    16 => 'Naslov',
    17 => 'Napaka',
    18 => 'Pomembno',
    19 => 'Prosimo da se sku�ate dr�ati teme objavljenega �lanka.',
    20 => 'Za�eleno je argumentiranje va�ih trditev.',
    21 => 'Preberite komentarje ostalih - morda je kdo �e napisal kaj kar nameravate napisati tudi vi.',
    22 => 'Pazite na pravilno slovnico in se izogibajte �alitvam drugih.',
    23 => 'Va� e-mail naslov ne bo javno objavljen.',
    24 => 'Anonimni uporabnik',
    25 => 'Ste prepri�ani da ho�ete prijaviti ta orispevek upravniku strani?',
    26 => '%s je prijavil naslednji prispevek ki zlorablja:',
    27 => 'Prijava zlorabe'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Uporabnik',
    2 => 'Uporabni�ko ime',
    3 => 'Ime',
    4 => 'Geslo',
    5 => 'Elektronski naslov',
    6 => 'Spletna stran',
    7 => 'Opis',
    8 => 'PGP javni klju�',
    9 => 'Shrani podatke',
    10 => 'Zadnjih 10 komentarjev uporabnika',
    11 => 'Uporabnik ni prispeval nobenih komentarjev',
    12 => 'Uporabni�ke nastavitve za',
    13 => 'Po�lji no�no poro�ilo (Nightly Digest)',
    14 => 'Geslo se generira naklju�no. Priporo�amo vam, da geslo takoj spremenite. To storite s klikom na Informacije o ra�unu v  meniju Osebne nastavitve. Za spremembe osebnih nastavitev se morate prijaviti v sistem.',
    15 => 'Va� uporabni�ki ra�un na spletni strani je bil uspe�no vzpostavljen. �e ga �elite uporabljati, se morate prijaviti s spodnjimi podatki. Svetujemo vam da podatke o va�em uporabni�kem ra�unu shranite.',
    16 => 'Informacije o va�em uporabni�kem ra�unu',
    17 => 'Uporabni�ki ra�un ne obstaja',
    18 => 'Vne�eni e-mail naslov ni veljaven',
    19 => 'Vne�eno uporabni�ko ime ali e-mail naslov sta �e uporabljena na tem sistemu',
    20 => 'Vne�eni e-mail naslov ni veljaven',
    21 => 'Napaka',
    22 => "Registracija {$_CONF['site_name']}!",
    23 => "Registracija vam omogo�a �lanstvo na na�i spletni strani{$_CONF['site_name']}. To pomeni da boste lahko objavljali komentarje, po�iljali svoje �lanke, dostopali in dodajali zapiske in bili dele�ni vseh pomembnih informacij. �e se ne registrirate, boste na spletni strani lahko sodelovali le kot anonimni uporabnik. <font color=red>Elektronski naslovi registriranih uporabnikov <b><i>ne bodo javno objavljeni</i></b>.",
    24 => 'Geslo vam bomo poslali na e-mail naslov, ki ste ga vnesli.',
    25 => 'Ste pozabili geslo?',
    26 => 'Vnesite <em>uporabni�ko ime</em> <em>ali</em> email naslov s katerim ste se registrirali in kliknite spodnji gumb (Po�lji geslo po emailu). Navodila kako nastaviti novo geslo vam bomo sporo�ili na registrirani e-mail naslov.',
    27 => 'Registrirajte se!',
    28 => 'Po�lji geslo na e-mail naslov',
    29 => 'odjava',
    30 => 'prijava',
    31 => 'Za izvedbo te funkcije se morate prijaviti',
    32 => 'Podpis',
    33 => 'Se nikoli javno ne prika�e',
    34 => 'Va�e pravo ime',
    35 => 'Vpi�i spremenjeno geslo',
    36 => 'Za�ne� z http://',
    37 => 'Nastavitve komentarjev',
    38 => 'To lahko prebere vsakdo',
    39 => 'PGP javni klju?',
    40 => 'Brez ikone teme',
    41 => 'Pripravljen moderirati',
    42 => 'Format datuma',
    43 => 'Najve� �lankov',
    44 => 'Brez okvirjev',
    45 => 'Prika�i nastavitve za',
    46 => 'Izklju�eni deli',
    47 => 'Nastavitve novosti za',
    48 => 'Teme',
    49 => 'Brez ikon v �lankih',
    50 => '�e vas ne zanima, odzna�ite',
    51 => 'Samo novi �lanki',
    52 => 'Privzeta nastavitev je 10',
    53 => 'Prejmi nove �lanke vsako no�',
    54 => 'Ozna�i teme in avtorje, katerih prispevki vas ne zanimajo',
    55 => '�e pustite prazno, se bodo ohranile privzete nastavitve. �e za�nete izbirati bloke, se bodo prikazali samo tisti, ki ste jih izbrali (brez privzetih). Privzete nastavitve so <B> povdarjene</B>.',
    56 => 'Avtorji',
    57 => 'Na�in prikaza',
    58 => 'Uredi po',
    59 => 'Omejitve komentarja',
    60 => 'Kak�en na�in izpisa �elite za svoje komentarje',
    61 => 'Najprej novi ali stari?',
    62 => 'Prevzeta vrednost je 100',
    63 => "Geslo je bilo poslano na va� e-mail naslov. Sledite navodilom, ki jih boste dobili. Hvala ker uporabljate spletno stran {$_CONF['site_name']}",
    64 => 'Nastavitve komentarjev za',
    65 => 'Poizkusite se ponovno prijaviti',
    66 => "Morda ste se zmotili pri vnosu svojega uporabni�kega imena ali gesla? Poizkusite se ponovno prijaviti. Ste morda �e neregistriran uporabnik - v tem primeru se <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrirajte</a>.",
    67 => 'Uporabnik od',
    68 => 'Zapomni se me za',
    69 => 'Kako dolgo naj si te zapomnim po zadnji prijavi?',
    70 => "Priredi izgled spletne strani {$_CONF['site_name']}",
    71 => "Ena od posebnosti spletne strani{$_CONF['site_name']} je popolna mo�nost prilagajanja izgleda posameznemu uporabniku.  �e �elite uporabiti to mo�nost se morate najprej <a href=\"{$_CONF['site_url']}/users.php?mode=new\">prijaviti</a> na {$_CONF['site_name']}.  Ali ste �e postali registrirani uporabnik?  Prijavite se!",
    72 => 'Tema',
    73 => 'Jezik',
    74 => 'Spremeni izgled strani!',
    75 => 'Teme po e-mailu',
    76 => 'Nove �lanke iz izbranih podro�ij boste ob koncu vsakega dneva prejeli po e-mailu. Izberite teme, ki vas zanimajo!',
    77 => 'Slika',
    78 => 'Dodaj svojo sliko!',
    79 => 'Izbri�i izbrano sliko',
    80 => 'Vpis',
    81 => 'Po�lji Email',
    82 => 'Zadnjih 10 �lankov uporabnika',
    83 => 'Statistika objavljanja uporabnika',
    84 => 'Skupno �tevilo �lankov:',
    85 => 'Skupno �tevilo komentarjev:',
    86 => 'Najdi vse objave uporabnika',
    87 => 'Va�e uporabni�ko ime',
    88 => "Nekdo (verjetno ti) je zahteval novo geslo za tvoj ra�un  \"%s\" na {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\n�e res �eli� novo geslo, prosim klikni povezavo :\n\n",
    89 => "�e no�e� novega gesla, preprosto ignoriraj to sporo�ilo in zahtevo bomo zavrgli (tvoje geslo bo ostalo nespremenjeno).\n\n",
    90 => 'Spodaj lahko vpi�e� novo geslo za svoj ra�un. Prosim, vedi, da je staro geslo �e vedno veljavno, dokler ne  odpo�lje� tega obrazca.',
    91 => 'Nastavljanje novega gesla',
    92 => 'Vpi�i novo geslo',
    93 => 'Tvoja zadnja zahteva za novo geslo je bila sprejeta pred %d sekundami. Te strani zahtevajo vsaj %d sekund med spremembami gesla.',
    94 => 'Izbri�i ra�un "%s"',
    95 => 'Klikni gumb "Izbri�i ra�un" spodaj za izbris svojega uporabni�kega ra�una iz na�e baze podatkov. Vedi, da bodo vsi prispevki, ki si jih prispeval/a pod tem ra�unom <strong>ostali</strong> na na�ih straneh. Uporabnik, ki jih je prispeval pa bo postal anonimne�.',
    96 => 'Izbri�i ra�un',
    97 => 'Potrdi brisanje ra�una',
    98 => 'Si prepri�an da �eli� pobrisati svoj uporabni�ki ra�un. Po tem prijava na na�e strani ne bo ve� mogo�a (razen, �e si ustvari� nov ra�un). �e si prepri�an/a ponovno klikni "Izbri�i ra�un" v spodnjem obrazcu.',
    99 => 'Nastavitve zasebnosti za',
    100 => 'Adminov email',
    101 => 'Dovoli emaile od upravljalcev strani',
    102 => 'Email od uporabnikov',
    103 => 'Dovoli emaile od drugih uporabnikov strani',
    104 => 'Prika�i Online Status',
    105 => 'Dovoli prikaz v bloku Na liniji so',
    106 => 'Lokacija',
    107 => 'Prikazano v va�em javnem profilu',
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
    123 => "Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?",
    124 => 'Confirm Email',
    125 => 'You have to enter the same email address in both fields!',
    126 => 'Please repeat for confirmation',
    127 => 'To change any of these settings, you will have to enter your current password.',
    128 => 'Your Name',
    129 => 'Password &amp; Email',
    130 => 'About You',
    131 => 'Daily Digest Options',
    132 => 'Daily Digest Feature',
    133 => 'Comment Display',
    134 => 'Comment Options',
    135 => '<li>Default mode for how comments will be displayed</li><li>Default order to display comments</li><li>Set maximum number of comments to show - default is 100</li>',
    136 => 'Exclude Topics and Authors',
    137 => 'Filter Story Content',
    138 => 'Misc Settings',
    139 => 'Layout and Language',
    140 => '<li>No Topic Icons if checked will not display the story topic icons</li><li>No boxes if checked will only show the Admin Menu, User Menu and Topics<li>Set the maximum number of stories to show per page</li><li>Set your theme and perferred date format</li>',
    141 => 'Privacy Settings',
    142 => 'The default setting is to allow users & admins to email fellow site members and show your status as online. Un-check these options to protect your privacy.',
    143 => 'Filter Block Content',
    144 => 'Show & hide boxes',
    145 => 'Your Public Profile',
    146 => 'Password and email',
    147 => 'Edit your account password, email and autologin feature. You will need to enter the same password or email address twice as a confirmation.',
    148 => 'User Information',
    149 => 'Modify your user information that will be shown to other users.<li>The signature will be added to any comments or forum posts you made</li><li>The BIO is a brief summary of yourself to share</li><li>Share your PGP Key</li>',
    150 => 'Warning: Javascript recommended for enhanced functionality',
    151 => 'Preview',
    152 => 'Username & Password',
    153 => 'Layout & Language',
    154 => 'Content',
    155 => 'Privacy',
    156 => 'Delete Account'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Podro�je je trenutno prazno',
    2 => 'Trenutno v tem tematskem podro�ju ni nobenega �lanka, ali pa so va�e uporabni�ke nastavitve tak�ne da nimate dostopa do tega podro�ja',
    3 => '.',
    4 => 'Dana�nji udarni �lanek',
    5 => 'naslednja stran',
    6 => 'prej�nja stran',
    7 => 'Prva',
    8 => 'Zadnja'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Napaka!!! Poskusite znova.',
    2 => 'Sporo�ilo je bilo poslano',
    3 => 'Uporabite pravi e-mail naslov!',
    4 => 'Izpolnite polja: Ime, e-mail za odgovor, Zadeva in vpi�ite sporo�ilo',
    5 => 'Napaka. Neznan uporabnik!',
    6 => 'Upsss... Napaka ;-).',
    7 => 'Uporabnik',
    8 => 'Uporabni�ko ime',
    9 => 'URL naslov',
    10 => 'e-mail naslov',
    11 => 'Ime:',
    12 => 'e-mail za odgovor:',
    13 => 'Zadeva:',
    14 => 'Sporo�ilo:',
    15 => 'HTML ukazi ne bodo upo�tevani.',
    16 => 'Po�lji sporo�ilo',
    17 => 'Po�lji �lanek prijatelju po e-mailu',
    18 => 'Ime prijatelja',
    19 => 'Elektronski naslov prijatelja',
    20 => 'Va�e ime',
    21 => 'Va� e-mail naslov',
    22 => 'Izpolniti je potrebno vsa polja!',
    23 => "To sporo�ilo vam je poslal na� obiskovalec %s (%s). Upravitelji spletne strani {$_CONF['site_url']} od koder je bilo sporo�ilo poslano, va�ih podatkov nismo shranili v nobeno bazo podatkov.",
    24 => '�lanek se nahaja na spletnem naslovu: ',
    25 => '�e �elite poslati �lanek po e-po�ti, se morate predhodno registrirati. Registracija je potrebna da prepre�imo morebitne zlorabe sistema.',
    26 => 'S pomo�jo tega obrazca boste poslali e-mail izbranemu uporabniku. Izpolniti je potrebno vsa polja!',
    27 => 'Kratko spremno sporo�ilo',
    28 => 'Obiskovalec %s je napisal slede�e spremno sporo�ilo: ',
    29 => "Dnevni pregled strani {$_CONF['site_name']} za ",
    30 => 'Dnevne novice za',
    31 => 'Naslov',
    32 => 'Datum',
    33 => 'Celotno besedilo:',
    34 => 'Konec sporo�ila',
    35 => '�al, ta uporabnik ne �eli prejemati emailov.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Napredno iskanje',
    2 => 'Klju�ne besede',
    3 => 'Tematsko podro�je',
    4 => 'vse',
    5 => 'Nasvet',
    6 => '�lanki',
    7 => 'komentarji bralcev',
    8 => 'Avtorji',
    9 => 'vse',
    10 => 'I��i',
    11 => 'Rezultati iskanja',
    12 => 'zadetki',
    13 => 'Iskanje med �lanki: ni� zadetkov',
    14 => 'Za iskalni pojem',
    15 => 'ni nobenega zadetka. Prosimo poizkusite ponovno.',
    16 => 'Naslov',
    17 => 'datum',
    18 => 'avtor',
    19 => 'Iskalnik celotne baze podatkov (vsi �lanki in vsi komentarji bralcev)',
    20 => 'Datum',
    21 => 'do',
    22 => '(format datuma YYYY-MM-DD)',
    23 => '�t. zadetkov',
    24 => 'Na�el sem %d zadetkov',
    25 => 'Iskal sem',
    26 => 'zadetkov ',
    27 => 'sekund.',
    28 => 'Za vpisani iskalni pogoj ni bilo najdenega nobenega �lanka niti nobenega komentarja',
    29 => 'Rezultati iskanja',
    30 => 'Nobena povezava ne ustreza va�emu iskalnemu pogoju. Poizkusite znova!',
    31 => 'Ni zadetkov za ta plug-in. Poizkusite znova!',
    32 => 'Dogodek',
    33 => 'URL',
    34 => 'Lokacija',
    35 => 'Celodnevno dogajanje',
    36 => 'Noben dogodek ne ustreza va�emu iskalnemu pogoju. Poizkusite znova!',
    37 => 'Rezultati za dogodke',
    38 => 'Rezultati za povezave',
    39 => 'Povezave',
    40 => 'Dogodki',
    41 => 'Iskalni niz mora imeti vsaj tri znake.',
    42 => 'Datum naj bo formatiran na na�in: YYYY-MM-DD (leto-mesec-dan).',
    43 => 'to�na fraza',
    44 => 'vse besede',
    45 => 'katerakoli beseda',
    46 => 'Naslednji',
    47 => 'Prej�nji',
    48 => 'Avtor',
    49 => 'Datum',
    50 => 'Zadetki',
    51 => 'Povezava',
    52 => 'Lokacija',
    53 => 'Rezultati �lankov',
    54 => 'Rezultati komentarjev',
    55 => 'fraza',
    56 => 'AND',
    57 => 'OR',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Statistike spletne strani',
    2 => '�tevilo vseh obiskov strani',
    3 => '�tevilo objavljenih �lankov (komentarjev)',
    4 => '�tevilo anket (odgovorov)',
    5 => '�tevilo povezav (obiskov)',
    6 => '�tevilo napovedanih dogodkov',
    7 => 'Deset najbolj branih �lankov',
    8 => 'Naslov �lanka',
    9 => '�t. ogledov',
    10 => 'Na spletni strani ni objavljenih �lankov, ali pa nih�e ni prebral nobenega �lanka.',
    11 => 'Deset najbolj komentiranih �lankov',
    12 => '�t. komentarjev',
    13 => 'Na spletni strani ni objavljenih komentarjev, ali pa nih�e ni objavil nobenega komentarja.',
    14 => 'Deset najbolj obiskanih anket',
    15 => 'Anketno vpra�anje',
    16 => '�t. glasov',
    17 => 'Na spletni strani ni objavljena nobena anketa, ali pa nih�e ni glasoval pri nobeni anketi.',
    18 => 'Deset najbolj obiskanih povezav',
    19 => 'Povezave',
    20 => '�t. ogledov',
    21 => 'Na spletni strani ni objavljena nobena povezava ali pa nih�e ni obiskal nobene povezave.',
    22 => 'Deset najbolj po e-mailu posredovanih �lankov',
    23 => '�t. posredovanj',
    24 => 'Nih�e ni posredoval nobenega �lanka po e-mailu.',
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
    1 => 'Sorodne povezave',
    2 => 'Po�lji �lanek po e-po�ti',
    3 => 'Stran prijazna za tisk',
    4 => 'Dodatne mo�nosti',
    5 => 'PDF format �lanka'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "�e �elite objaviti %s se morate prijaviti. �e niste registrirani uporabnik? <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> Registrirajte se</a>.",
    2 => 'Prijava',
    3 => 'Nov uporabnik',
    4 => 'Po�lji dogodek',
    5 => 'Po�lji povezavo',
    6 => '�lanek',
    7 => 'Potrebno se je prijaviti!',
    8 => 'Po�lji',
    9 => 'Pri po�iljanju informacij se dr�ite naslednjih priporo�il:<ul><li>izpolnite vsa polja,<li>poskrbite da bo informacija, ki jo po�iljate to�na in ustrezna,<li>pazite na slovnico,<li>preverite da delujejo vse povezave,<li><font color=red>prosimo da po�iljate <b>samo �lanke</b>, komentarje vpisujte pod posamezen �lanek, za splo�ne debate ali mnenja pa uporabite forum.</font></ul>',
    10 => 'Naslov',
    11 => 'Povezava',
    12 => 'Datum za�etka',
    13 => 'Datum zaklju�ka',
    14 => 'Lokacija',
    15 => 'Opis',
    16 => '�e \'drugo\', vpi�i ime',
    17 => 'Kategorija',
    18 => 'Drugo',
    19 => 'Prosimo, preberite',
    20 => 'Napaka: ni dolo�ena kategorija',
    21 => 'Kadar izberete "Drugo" vpi�ite tudi ime kategorije',
    22 => 'Napaka: niso izpolnjena vsa polja',
    23 => 'Prosimo izpolnite vsa polja obrazca.',
    24 => 'Shranjeno!',
    25 => 'Va� %s prispevek je bil shranjen.',
    26 => 'Omejitev hitrosti',
    27 => 'Uporabni�ko ime',
    28 => 'Tematsko podro�je',
    29 => 'Vsebina �lanka',
    30 => 'Va�a zadnja objava je bila poslana pred ',
    31 => " sekundami. Nastavitve te spletne strani pa zahtevajo da med dvema objavama istega avtorja mine vsaj {$_CONF['speedlimit']} sekund",
    32 => 'Predogled',
    33 => 'Predogled �lanka',
    34 => 'izhod',
    35 => 'HTML ukazi ne bodo upo�tevani',
    36 => 'Oblika besedila',
    37 => 'Dogodek bo dodan na skupni koledar, od koder ga registrirani uporabniki lahko dodajo na svoj osebni koledar. Ta aplikacija zato <b>NI</b> namenjena shranjevanju osebnih dogodkov (obletnice, rojstni dnevi, zabave...) �e nas ne mislite nanje povabiti ;-)<br><br>Preden bo dogodek objavljen na skupnem koledarju dogodkov, ga bo pregledal administrator!',
    38 => 'Dodaj dogodek v',
    39 => 'Skupni koledar',
    40 => 'Osebni koledar',
    41 => '�as zaklju�ka',
    42 => '�as za�etka',
    43 => 'Celodnevni dogodek',
    44 => 'Naslov 1',
    45 => 'Naslov 2',
    46 => 'Mesto',
    47 => 'Dr�ava',
    48 => 'Po�tna �tevilka',
    49 => 'Tip dogodka',
    50 => 'Uredi tipe dogodkov',
    51 => 'Lokacija',
    52 => 'Odstrani',
    53 => 'Naredi ra�un'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Obvezna prijava',
    2 => 'Dostop zavrnjen! Vnesli ste napa�ne podatke.',
    3 => 'Napa�no geslo za uporabnika',
    4 => 'Uporabni�ko ime:',
    5 => 'Geslo:',
    6 => 'Vsi dostopi do administracijske strani se bele�ijo.<br>Ta del spletne strani lahko uporabljajo samo poobla��ene osebe.<p>',
    7 => 'prijava'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Ups... ne bo �lo. Nimate zahtevanih administratorskih pravic ;-)',
    2 => 'Za urejanje tega bloka nimate zahtevanih administratorskih pravic',
    3 => 'Urejanje blokov',
    4 => 'Pri branju je nastala te�ava (za detajle glej error.log).',
    5 => 'Ime bloka',
    6 => 'Tema',
    7 => 'Vse',
    8 => 'Varnostna raven bloka',
    9 => 'Pravila bloka',
    10 => 'Tip bloka',
    11 => 'Blok na portalu',
    12 => 'Obi�ajni blok',
    13 => 'Nastavitve bloka na portalu',
    14 => 'RDF URL',
    15 => 'Zadnja RDF osve�itev',
    16 => 'Nastavitve obi�ajnega bloka',
    17 => 'Komentar',
    18 => 'Vnesite ime in vsebino bloka',
    19 => 'Administracija bloka',
    20 => 'Ime bloka',
    21 => 'Varnostna raven',
    22 => 'Tip bloka',
    23 => 'Pravila bloka',
    24 => 'Tema bloka',
    25 => 'Izberite blok, ki ga �elite urediti ali odstraniti. �e �elite ustvariti nov blok, kliknite zgoraj.',
    26 => 'Izgled',
    27 => 'PHP blok',
    28 => 'Nastavitve PHP bloka',
    29 => 'Funkcije bloka',
    30 => '�e �eli� da blok uporablja php kodo, zgoraj vpi�i ime funkcije. Ime funkcije se mora za�eti z izrazom "phpblock_" (t.j. phpblock_getweather). �e funkcija nima te predpone, NE bo klicana.  To je narejeno tako zaradi tega, da potencialni hekerji ne morejo izvesti kode, ki bi lahko �kodovala sistemu. Pazi da ne vstavi� praznih oklepajev "()" za ime funkcije. Priporo�amo vso svojo kodo, tudi to za bloke, vpisujete v /pot/do/geekloga/system/lib-custom.php. Tako bo ta koda brez te�av ostala z vami tudi po nadgradnji Geekloga.',
    31 => 'Napaka v PHP bloku. Funkcija %s, ne obstaja.',
    32 => 'Napaka. Manjkajo podatki',
    33 => 'Vnesite URL naslov v datoteko .rdf za blok na portalu',
    34 => 'Vnesite naslov in funkcijo PHP bloka',
    35 => 'Vnesite naslov in vsebino bloka',
    36 => 'Vnesite vsebino in izberite izgled bloka',
    37 => 'Napa�no ime funkcije PHP bloka',
    38 => 'Funkcije PHP bloka morajo imeti predpono \'phpblock_\' (npr. phpblock_imefunkcije).  Predpona \'phpblock_\' je potrebna zaradi varnosti!',
    39 => 'Stran',
    40 => 'Levo',
    41 => 'Desno',
    42 => 'Vnesite ime bloka in vrstni red zanj.',
    43 => 'Samo doma�a stran',
    44 => 'Dostop zavrnjen',
    45 => "Do tega bloka nimate dostopa. Va� poskus je bil zabele�en v bazo podatkov! Prosimo, vrnite se na <a href=\"{$_CONF['site_url']}/admin/block.php\"> stran za administracijo</a>!",
    46 => 'Nov blok',
    47 => 'Administratorske strani',
    48 => 'Ime bloka',
    49 => ' (Presledki niso dovoljeni. Imena blokov ne smejo biti podvojena',
    50 => 'URL za pomo�',
    51 => 'Za�ne� s http://',
    52 => '�e pustite prazno, se ikona za pomo� ne bo izpisala!',
    53 => 'Omogo�eno',
    54 => 'Shrani',
    55 => 'Prekli�i',
    56 => 'Izbri�i',
    57 => 'Premakni blok dol',
    58 => 'Premakni blok gor',
    59 => 'Premakni blok na desno stran',
    60 => 'Premakni blok na levo stran',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order',
    66 => 'Autotags',
    67 => 'Check to allow autotags'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Prej�nji �lanki',
    2 => 'Naslednji �lanki',
    3 => 'Nastavitve �lanka',
    4 => 'Oblikovanje �lanka',
    5 => 'Urejanje �lanka',
    6 => 'Ni �lankov v sistemu',
    7 => 'Avtor',
    8 => 'Shrani',
    9 => 'Predogled',
    10 => 'Prekli�i',
    11 => 'Izbri�i',
    12 => 'ID',
    13 => 'Naslov',
    14 => 'tematsko podro�je',
    15 => 'datum',
    16 => 'Uvodno besedilo',
    17 => 'Raz�irjeno besedilo',
    18 => '�t. branj',
    19 => 'Komentarjev',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Seznam �lankov',
    23 => '�e �elite spreminjati ali izbrisati �lanek, kliknite na njegovo �tevilko. �e �elite �lanek pregledati, kliknite na njegov naslov. �e �elite objaviti nov �lanek, kliknite na zgornjo povezavo.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Predogled �lanka',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'Napake pri shranjevanju datoteke',
    31 => 'Prosimo izpolnite polji Naslov in Uvodno besedilo',
    32 => 'Udarni �lanek',
    33 => 'Udarni �lanek je lahko smo eden',
    34 => 'Draft',
    35 => 'Da',
    36 => 'Ne',
    37 => 'Ve� od avtorja',
    38 => 'Ve� iz podro�ja',
    39 => '�t. posredovanj po e-mailu',
    40 => 'Dostop zavrnjen',
    41 => "Poizku�ate dostopati do �lanka do katerega nimate dostopa. Ta poizkus neveljavnega dostopa je bil zabele�en in shranjen. �lanek lahko samo preberete, ne morete pa ga urejati. �e �elite lahko vstopite <a href=\"{$_CONF['site_url']}/admin/story.php\"> na administracijo �lanka</a>.",
    42 => "Poizku�ate dostopati do �lanka do katerega nimate dostopa. Ta poizkus neveljavnega dostopa je bil zabele�en in shranjen. �e �elite lahko vstopite <a href=\"{$_CONF['site_url']}/admin/story.php\">na administracijo �lankov</a>.",
    43 => 'Nov �lanek',
    44 => 'Administracijska stran',
    45 => 'Dostop',
    46 => '<b>POZOR:</b> va� prispevek ne bo objavljen do izbranega datuma.Do tega datuma tudi na bo v va�em RDF in ne bo vklju�n v iskalnik.',
    47 => 'Slike',
    48 => 'slika',
    49 => 'desno',
    50 => 'levo',
    51 => 'Sliko vstavite v �lanek s posebnim ukazom [imageX], [imageX_right] ali [imageX_left], kjer je X �tevilka slike v prilogi. POZOR: uporabite lahko samo slike iz priloge. V nasprotnem primeru �lanka ne bo mogo�e objaviti. <BR><P><B>PREDOGLED</B>: Predogled �lanka s slikami najenostavneje opraviter tako, da �lanek shranite kot draft in ne uporabite gumba Predogled. Funkcija Predogled deluje deluje le, �e �lanek brez slik.',
    52 => 'Odstrani',
    53 => 'ni bila uporabljena. Sliko morate pred shranjevanjem vklju�iti v uvod ali med besedilo �lanka.',
    54 => 'Prilo�ene slike niso bile uporabljene',
    55 => 'Napaka pri shranjevanju �lanka. Prosimo popravite napake na spodnjem seznamu:',
    56 => 'Prika�i ikono teme',
    57 => 'Oglej si nezmanj�ano sliko',
    58 => 'Administracija �lankov',
    59 => 'Opcija',
    60 => 'Omogo�eno',
    61 => 'Samodejno arhiviranje',
    62 => 'Samodejno brisanje',
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
    85 => 'Show All',
    86 => 'Advanced Editor',
    87 => 'Story Stats'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Urejanje tem',
    2 => 'ID teme',
    3 => 'Ime teme',
    4 => 'Slika teme',
    5 => '(ne uporabljajte presledkov)',
    6 => '�e odstranite temo, odstranite tudi vse �lanke in bloke, ki so z njo povezani',
    7 => 'Izpolnite ID teme in naslov teme.',
    8 => 'Urejevalnik tem',
    9 => 'Izberite temo, ki jo �elite urediti ali odstraniti. �e �elite ustvariti novo temo, kliknite gumb Nova tema, na levi. V vsaki temi najde�, v oklepajih, svoj nivo dostopa. Zvazdica (*) ozna�uje privzeto temo.',
    10 => 'Uredi po',
    11 => '�lankov/Strani',
    12 => 'Dostop zavrnjen!',
    13 => "Do te teme nimate dostopa. Va� poskus je bil zabele�en in shranjen. Prosimo, vrnite se na <a href=\"{$_CONF['site_url']}/admin/topic.php\"> administracijo tem</a>!",
    14 => 'Uredi po',
    15 => 'abecedi',
    16 => 'privzeto',
    17 => 'Nova tema',
    18 => 'Administratorske strani',
    19 => 'Shrani',
    20 => 'Prekli�i',
    21 => 'Izbri�i',
    22 => 'Privzeto',
    23 => 'Ustvari to temo privzeto za novo oddane �lanke',
    24 => '(*)',
    25 => 'Arhiviraj temo',
    26 => 'naredi to temo privzeto za arhivirane �lanke. Samo ena tema je dovoljena.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Urejanje uporabnika',
    2 => 'ID uporabnika',
    3 => 'uporabni�ko ime',
    4 => 'ime uporabnika',
    5 => 'Geslo',
    6 => 'Varnostni nivo',
    7 => 'e-mail naslov',
    8 => 'Va�a spletna stran',
    9 => '(ne uporabljajte presledkov)',
    10 => 'Prosimo vpi�ite uporabni�ko ime in e-mail.',
    11 => 'Administracija uporabnikov',
    12 => '�e �elite spremeniti ali izbrisati uporabnika, kliknite na njegovo uporabni�ko ime spodaj. �e �elite ustvariti novega uporabnika, kliknite gumb Nov uporabnik na levi. V spodnje okence vpi�ite iskalni niz, i��ete lahko po imenu, delu imena, emailu ali celotnem imenu (npr. *sin* ali *.si*).',
    13 => 'Varnostni nivo',
    14 => 'Datum registracije',
    15 => 'nov uporabnik',
    16 => 'Administratorske strani',
    17 => 'spremeni geslo',
    18 => 'prekini',
    19 => 'izbri�i',
    20 => 'shrani',
    21 => 'Uporabni�ko ime, ki ga �elite hraniti �e obstaja.',
    22 => 'Napaka',
    23 => 'Zaporedno dodajanje',
    24 => 'Zaporedno dodajanje uporabnikov',
    25 => 'Uvozi� lahko zaporedje uporabnikov v Geekloga.  Datoteka za uvoz mora biti razdeljena s tabi in mora biti navadna tekstovna datoteka. Polja naj si sledijo v naslednjem vrstnem redu: polno ime, uporabni�ko ime, email naslov.  Vsak uporabnik bo prejel email z naklju�nim geslom. Vsak uporabnik naj bo vpisan v svoji vrstici. �e ne upo�teva� teh navodil, lahko nastanejo precej�nje te�ave, ki bodo zahtevale ro�no delo, zato, �e enkrat preveri vpise v datoteki preden jo za�ne� uva�ati!',
    26 => 'I��i',
    27 => 'Omejitve iskanja',
    28 => 'Izbri�i sliko',
    29 => 'Pot',
    30 => 'Uvozi',
    31 => 'Novi uporabniki',
    32 => 'Kon�ano. Uvo�eno %d in %d napak',
    33 => 'po�lji',
    34 => 'Napaka: Mora� dolo�iti datoteko.',
    35 => 'Zadnji vpis',
    36 => '(nikoli)',
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
    47 => 'Edit',
    48 => 'Show Admin Groups',
    49 => 'Admin Group',
    50 => 'Check to allow filtering this group as an Admin Use Group',
    51 => 'Online Days',
    52 => '<br>Note: "Online Days" is the number of days between the first registration and the last login.',
    53 => 'registered',
    54 => 'Batch Delete',
    55 => 'This only works if you have <code>$_CONF[\'lastlogin\'] = true;</code> in your config.php',
    56 => 'Please choose the type of user you want to delete and press "Update List". Then, uncheck those from the list you do not want to delete and press "Delete". Please note that you will only delete those that are currently visible in case the list spans over several pages.',
    57 => 'Phantom users',
    58 => 'Short-Time Users',
    59 => 'Old Users',
    60 => 'Users that registered more than ',
    61 => ' months ago, but never logged in.',
    62 => 'Users that registered more than ',
    63 => ' months ago, then logged in within 24 hours, but since then never came back to your site.',
    64 => 'Normal users, who simply did not visit your site since ',
    65 => ' months.',
    66 => 'Update List',
    67 => 'Months since registration',
    68 => 'Online Hours',
    69 => 'Offline Months',
    70 => 'could not be deleted',
    71 => 'sucessfully deleted',
    72 => 'No User selected for deletion',
    73 => 'Are You sure you want to permanently delete ALL selected users?',
    74 => 'Recent Users',
    75 => 'Users that registered in the last ',
    76 => ' months'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Objavi',
    2 => 'Izbri�i',
    3 => 'Uredi',
    4 => 'Profil',
    10 => 'Naslov',
    11 => 'Datum za�etka',
    12 => 'URL',
    13 => 'Kategorija',
    14 => 'Datum',
    15 => 'Tema',
    16 => 'Uporabni�ko ime',
    17 => 'Popolno ime',
    18 => 'E-mail',
    34 => 'Administratorske strani',
    35 => '�akajo�i �lanki',
    36 => '�akajo�e povezave',
    37 => '�akajo�i dogodki',
    38 => 'Potrdi',
    39 => 'Trenutno v tem podro�ju ni nobene �akajo�e vsebine.',
    40 => 'Uporabniki so poslali'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} EMail pripomo�ek",
    2 => 'Od:',
    3 => 'Naslov za odgovor:',
    4 => 'Zadeva:',
    5 => 'Sporo�ilo:',
    6 => 'Naslov:',
    7 => 'Vsem uporabnikom',
    8 => 'Admin',
    9 => 'Nastavitve',
    10 => 'HTML',
    11 => 'Nujno sporo�ilo!',
    12 => 'Po�lji',
    13 => 'Zbri�i',
    14 => 'Prezri uporabni�ke nastavitve',
    15 => 'Napaka pri po�iljanju: ',
    16 => 'Sporo�ilo je bilo uspe�no poslano na naslov: ',
    17 => "<a href={$_CONF['site_url']}/admin/mail.php>Po�lji novo sporo�ilo</a>",
    18 => 'Za:',
    19 => 'POZOR: �e �elite poslati sporo�ilo vsem uporabnikom strani, izberite skupino Prijavljeni uporabniki iz menija Uporabniki',
    20 => "Uspe�no poslana sporo�ila: <successcount>;<BR>Neuspe�no poslana sporo�ila: <failcount>. Podrobnosti o neuspe�no poslanih sporo�ilh najdete spodaj.<BR><BR>�elite poslati �e kak�no <a href=\"{$_CONF['site_url']}/admin/mail.php\">sporo�ilo</a>? <BR><BR>Nazaj na <a href=\"{$_CONF['site_url']}/admin/moderation.php\">administratorkse strani</a>.",
    21 => 'Neuspe�no poslana sporo�ila',
    22 => 'Uspe�no poslana sporo�ila',
    23 => 'Nobenega neuspe�no poslanega sporo�ila',
    24 => 'Nobenega uspe�no poslanega sporo�ila',
    25 => '-- Izberi skupino --',
    26 => 'Prosim izpolni vsa polja v obrazcu in izberi skupino uporabnikov iz menija.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Instalacija vti�nikov (plugin) lahko povzro�i �kodo tvoji instalaciji Geekloga, lahko tudi tvojemu sistemu. Pomemno je, da instalira� samo vti�nike, ki jih preto�i� z <a href="http://www.geeklog.net" target="_blank">Geeklogove doma�e strani</a> saj smo samo te dodobra preizkusili na razli�nih operacijskih sistemih. Pomembno je razumeti, da je instalacija vti�nikov proces, ki zahteva izvajanje nekaterih komand na nivoju datote�nega sistema. Te lahko vodijo do varnostnih lukenj, posebno �e uporablja� vti�nik iz strani tretjih oseb. Tudi s tem opozorilom, ne garantiramo uspeh katerekoli instalacije niti nismo odgovorni za �kodo povzro�eno z instalacijo vti�nika za Geeklog. Z drugimi besedami instalira� na svojo lastno odgovornost. Navodila za ro�no instalacijo vti�nika so vklju�ena v paketu vsakega vti�nika.',
    2 => 'Plug-in Installation Disclaimer',
    3 => 'Plug-in Installation Form',
    4 => 'Plug-in File',
    5 => 'Spisek vti�nikov',
    6 => 'Opozorilo: Plug-in je �e name��en!',
    7 => 'Vti�nik ki ga sku�a� namestiti je �e name��en. Prosim pobri�i stari vti�nik pred ponovno instalacijo',
    8 => 'Test kompatibilnosti vti�nika ni uspel',
    9 => 'Ta vti�nik zahteva novej�o verzijo Geekloga. Namesti novo razli�ico <a href="http://www.geeklog.net">Geekloga</a> ali najdi novej�o verzijo vti�nika.',
    10 => '<br><b>Trenutno ni name��enih nobenih vti�nikov.</b><br><br>',
    11 => 'Za spremembo ali izbris vti�nika, klikni njegovo �tevilko spodaj. Za ve� informacij o vti�niku, klikni njegovo ime in preusmerjen bo� na njegovo doma�o stran. Za instalacijo ali nadgradnjo vti�nika, klikni na gumb Nov vti�nik zgoraj.',
    12 => 'nobeno ime vti�nika ni bilo poslano v plugineditor()',
    13 => 'Urejevalnik vti�nikov(Plugin Editor)',
    14 => 'Nov vti�nik',
    15 => 'Administratorske strani',
    16 => 'Ime vti�nika',
    17 => 'Verzija vti�nika',
    18 => 'Verzija Geekloga',
    19 => 'Omogo�en',
    20 => 'Da',
    21 => 'Ne',
    22 => 'Namesti',
    23 => 'Shrani',
    24 => 'Prekli�i',
    25 => 'Odstrani',
    26 => 'Ime Plug-ina',
    27 => 'Plug-in Homepage',
    28 => 'Verzija Plug-in',
    29 => 'Verzija Geekloga',
    30 => 'Odstrani Plug-in?',
    31 => 'Ali ste prepri�ani da �elite odstraniti ta plug-in?  S tem bodo iz baze izbrisani tudi vsi podatki, ki jih uporablja ta plug-in.',
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
    1 => 'ustvari vsebino (feed)',
    2 => 'shrani',
    3 => 'zbri�i',
    4 => 'prekli�i',
    10 => 'Vsebina (Syndication)',
    11 => 'Nova vsebina (Feed)',
    12 => 'Adminov dom',
    13 => 'Za spreminjanje ali brisanje vsebine (feed), kliknite na vsebino spodaj. Za novo vsebino, kliknite na gumb Nova vsebina zgoraj.',
    14 => 'Naslov',
    15 => 'Tip',
    16 => 'Ime datoteke',
    17 => 'Format',
    18 => 'zadnji obnovljen',
    19 => 'Omogo�eno',
    20 => 'Da',
    21 => 'Ne',
    22 => '<i>(ni vsebine)</i>',
    23 => 'vsi �lanki',
    24 => 'Urejevalnik (RDF) vsebine',
    25 => 'naslov vsebine',
    26 => 'Meja',
    27 => 'Dol�ine vnosov',
    28 => '(0 = brez dodatnega teksta, 1 = ves tekst, drugo = omeji tekst na to �tevilo znakov.)',
    29 => 'Opis',
    30 => 'Zadnji� obnovljeno',
    31 => 'Nabor znakov',
    32 => 'Jezik',
    33 => 'Vsebina',
    34 => 'Vpisi',
    35 => 'Ure',
    36 => 'Izberite tip vsebine',
    37 => 'Name��en imate vsaj en vti�nik, ki podpira sodelovanje (content syndication). Spodaj morate izbrati ali delate RDF vsebino za Geekloga ali za katerega od vti�nikov.',
    38 => 'Napaka: Manjkajo�a polja',
    39 => 'Prosim izpolnite polja Naslov, Opis, Ime datoteke.',
    40 => 'Prosim vpi�ite �tevilo vpisov ali �tevilo ur.',
    41 => 'Povezave',
    42 => 'Dogodki',
    43 => 'All',
    44 => 'None',
    45 => 'Header-link in topic',
    46 => 'Limit Results',
    47 => 'Search',
    48 => 'Edit',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})",
    51 => 'The filename you have chosen is already used by another feed. Please choose a different one.',
    52 => 'Error: existing Filename'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => 'Geslo smo vam poslali na va� e-mail naslov. Elektronsko sporo�ilo vsebuje tudi vsa ustrezna navodila.',
    2 => 'Za poslani �lanek se vam najlep�e zahvaljujemo. Pred objavo ga bo pregledal eden izmed urednikov. �e bo odobren, bo objavljen na spletni strani.',
    3 => "Za poslano povezavo se vam najlep�e zahvaljujemo. Pred objavo jo bo pregledal eden izmed urednikov. �e bo odobrena, bo objavljena na strani <a href={$_CONF['site_url']}/links.php>povezav</a>.",
    4 => "Za poslani dogodek se vam najlep�e zahvaljujemo. Pred objavo ga bo pregledal eden izmed urednikov. �e bo odobren, bo objavljen v <a href={$_CONF['site_url']}/calendar.php>koledarju dogodkov</a>.",
    5 => 'Podatki o va�em uporabni�kem ra�unu so bili shranjeni.',
    6 => 'Nastavitve so bile uspe�no shranjene.',
    7 => 'Va�e nastavitve komentarjev so bile uspe�no shranjene.',
    8 => 'Odjava je bila uspe�na.',
    9 => '�lanek je bil uspe�no shranjen.',
    10 => '�lanek je bil izbrisan.',
    11 => 'Va�i bloki so bili uspe�no shranjeni.',
    12 => 'Blok je bil izbrisan.',
    13 => 'Tematsko podro�je je bilo uspe�no shranjeno.',
    14 => 'Tematsko podro�je skupaj z vsemi �lanki v njem z je bilo izbrisano.',
    15 => 'Povezava je bila uspe�no shranjena v bazo povezav.',
    16 => 'Povezava je bila izbrisana.',
    17 => 'Dogodek je bil uspe�no shranjen v bazo dogodkov.',
    18 => 'Dogodek je bil izbrisan.',
    19 => 'Anketa je bila uspe�no shranjena.',
    20 => 'Anketa je bila izbrisana.',
    21 => 'Uporabni�ke nastavitve so bile uspe�no shranjene.',
    22 => 'Uporabnik je bil izbrisan.',
    23 => 'Napaka pri dodajanju dogodka v koledar dogodkov. Vnesite ID dogodka.',
    24 => 'Dogodek je bil uspe�no shranjen v va� koledar dogodkov',
    25 => 'Dostop do osebnega koledarja je mogo� le �e ste prijavljeni.',
    26 => 'Dogodek je bil odstranjen iz va�ega osebnega koledarja dogodkov',
    27 => 'Sporo�ilo je bilo poslano.',
    28 => 'Vti�nik je bil uspe�no shranjen',
    29 => '�al ta stran ne podpira osebnega koledarja.',
    30 => 'Dostop zavrnjen',
    31 => '�al nimate dostopa do administracije �lankov. Vsi poizkusi nedovoljenega dostopa se bele�ijo!',
    32 => '�al nimate dostopa do administracije tematskih podro�ij. Vsi poizkusi nedovoljenega dostopa se bele�ijo!',
    33 => '�al nimate dostopa do administracije blokov. Vsi poizkusi nedovoljenega dostopa se bele�ijo!',
    34 => '�al nimate dostopa do administracije povezav. Vsi poizkusi nedovoljenega dostopa se bele�ijo1',
    35 => '�al nimate dostopa do administracije dogodkov. Vsi poizkusi nedovoljenega dostopa se bele�ijo!',
    36 => '�al nimate dostopa do administracije anket. Vsi poizkusi nedovoljenega dostopa se bele�ijo!',
    37 => '�al nimate dostopa do administracije uporabnikov. Vsi poizkusi nedovoljenega dostopa se bele�ijo!',
    38 => '�al nimate dostopa do administracije priklju�nih modulov. Vsi poizkusi nedovoljenega dostopa se bele�ijo!',
    39 => '�al nimate dostopa do administracije elektronske po�te. Vsi poizkusi nedovoljenega dostopa se bele�ijo!',
    40 => 'Sistemsko sporo�ilo',
    41 => '�al nima� dostopa do strani za menjavo besed. Vsi poizkusi nedovoljenega dostopa se bele�ijo!',
    42 => 'Beseda je bila uspe�no shranjena.',
    43 => 'Beseda je bila uspe�no pobrisana.',
    44 => 'Vti�nik je bil uspe�no name��en!',
    45 => 'Vti�nik je bil odstranjen.',
    46 => '�al nimate dostopa do bekapa baze. Vsak poskus nedovoljenega dostopa se bele�i',
    47 => 'To deluje samo pod operacijskim sistemom *nix.  �e uporablja� *nix za svoj operacijski sistem, potem je bil cache uspe�no izpraznjen. �e uporablja� Windows OS, bo� moral poiskati datoteke po imenu adodb_*.php in jih pobrisati ro�no.',
    48 => "Hvala ker ste se prijavili za �lanstvo v {$_CONF['site_name']}. Na�e osebje vam bo sporo�ilo odgovor v kratkem. �e boste sprejeti, vam bomo poslali va�e geslo email naslov, ki te ga ravnokar napisali.",
    49 => 'Skupina je bila uspe�no shranjena.',
    50 => 'Skupina je bila uspe�no izbrisana.',
    51 => 'To uporabni�ko ime je �e zasedeno. Prosim izberi drugo.',
    52 => 'Vpisani email ne izgleda kot pravi email naslov.',
    53 => 'Tvoje novo geslo je sprejeto. Prosim uporabi to novo geslo spodaj za vpis v sistem.',
    54 => 'Tvoja zahteva za novo geslo je potekla. Prosim poizkusi ponovno spodaj.',
    55 => 'Poslal sem Email. Na tvoj naslov bi moral priti takoj. Prosim upo�tevaj navodila v tem emailu, za izbiro novega gesla za svoj ra�un.',
    56 => 'Vpisani email je �e uporabljen za enega od ra�unov na na�i bazi podatkov.',
    57 => 'Tvoj ra�un je bil uspe�no pobrisan.',
    58 => '(RDF) vsebina je bila uspe�no shranjena.',
    59 => '(RDF) vsebina je bila uspe�no izbrisana.',
    60 => 'Vti�nik je bil uspe�no obnovljen (updated)',
    61 => 'Vti�nik %s: Neznan okvir sporo�ila (Unknown message placeholder)',
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
    75 => 'Trackbacks must be sent using a POST request.',
    76 => 'Do you really want to delete this item?',
    77 => 'WARNING:<br>You have set your default encoding to UTF-8. However, your server does not support multibyte encodings. Please install mbstring functions for PHP or choose a different character set/language.',
    78 => 'Please make sure that the email address and the confirmation email address are the same.',
    79 => 'The page you have been trying to open refers to a function that no longer exists on this site.',
    80 => 'The plugin that created this feed is currently disabled. You will not be able to edit this feed until you re-enable the parent plugin.',
    81 => 'You may have mistyped your login credentials.  Please try logging in again below.',
    82 => 'You have exceeded the number of allowed login attempts.  Please try again later.',
    83 => 'To change your password, email address, or for how long to remember you, please enter your current password.',
    84 => 'To delete your account, please enter your current password.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Dostop',
    'ownerroot' => 'Lastnik/Root',
    'group' => 'Skupina',
    'readonly' => 'Samo za branje',
    'accessrights' => 'Pravice dostopa',
    'owner' => 'Lastnik',
    'grantgrouplabel' => 'Dovoli zgornji skupini pravice spreminjanja',
    'permmsg' => 'OBVESTILO: uporabniki so vsi prijavljeni �lani, anonimni uporabniki in vsi trenutni neprijavljeni obiskovalci strani.',
    'securitygroups' => 'Varnostne skupine',
    'editrootmsg' => "�eprav ste administrator, ne morete spreminjati nastavitev root uporabnika, �e sami niste root uporabnik. Lahko pa urejate nastavitve vseh ostalih uporabnikov. Vsi poizkusi nedovoljenega dostopa se bele�ijo. Vrnite se na <a href=\"{$_CONF['site_url']}/admin/users.php\">Administratorske strani</a>.",
    'securitygroupsmsg' => 'Izberite skupine, katerim naj pripada uporabnik',
    'groupeditor' => 'Urejanje skupin',
    'description' => 'Opis',
    'name' => 'Ime',
    'rights' => 'Pravice',
    'missingfields' => 'Manjkajo�a polja',
    'missingfieldsmsg' => 'Vpi�ite ime in opis skupine!',
    'groupmanager' => 'Administracija skupin',
    'newgroupmsg' => 'Izberite skupinpo, ki jo �eleite odstraniti skupino ali spremeniti njene nastavitve. �e �elite oblikovati novo skupino, kliknite na Nova skupina zgoraj! Osnovnih skupin ni mogo�e odstraniti!',
    'groupname' => 'Ime skupine',
    'coregroup' => 'Osnovna skupina',
    'yes' => 'Da',
    'no' => 'Ne',
    'corerightsdescr' => "Ta skupina je osnovna skupina {$_CONF['site_name']}. Pravice te skupine ne morejo biti spremenjene. Pravice, ki pripadajo tej skupini so na spodnjem seznamu!",
    'groupmsg' => 'Varnost skupin na tej strnai je urejena hierarhi�no. Vsaka podskupina ima enake pravice kot njena nadskupina. Zato je priporo�ljiva uporaba podskupin. �e skupina potrebuje posebne pravice, jih izberite v meniju \'Pravice\'.',
    'coregroupmsg' => "Ta skupina je osnovna skupina strani {$_CONF['site_name']}. Nastavitve skupin, ki ji pripadajo zato ne morejo biti spremenjene. Spodnji seznam vsebuje imena skupin, ki ji pripadajo.",
    'rightsdescr' => 'Pravice, ki jih dolo�ite skupini, so avtomatsko dodeljene tudi vsem njenim podskupinam. Pravice lahko dodajate tako, da jih izberete iz spodnjega seznama. �e dolo�ena pravica nima \'checkboxa\' pomeni, da ji je ta pravica dodeljena, ker je podskupina neke druge skupine.',
    'lock' => 'Zakleni',
    'members' => '�lani',
    'anonymous' => 'Anonimni uporabnik',
    'permissions' => 'Pravice',
    'permissionskey' => 'R = branje, E = spreminjanje, pravice spreminjanja predpostavljajo pravice branja',
    'edit' => 'Uredi',
    'none' => 'Nih�e',
    'accessdenied' => 'Dostop zavrnjen!',
    'storydenialmsg' => "�al nimate dostopa do tega �lanka. Morda zato, ker niste registrirani uporabnik {$_CONF['site_name']}? <a href=users.php?mode=New> Registrirajte se!</a> in dobili boste popoln dostop do strani {$_CONF['site_name']}",
    'nogroupsforcoregroup' => 'Ta skupina ne pripada nobeni od preostalih skupin',
    'grouphasnorights' => 'Ta skupina nima nobenih administratorskih pravic.',
    'newgroup' => 'Nova skupina',
    'adminhome' => 'Administratorske strani',
    'save' => 'Shrani',
    'cancel' => 'Prekli�i',
    'delete' => 'Izbri�i',
    'canteditroot' => 'Poizkusili ste urejati nastavitve glavne skupine. Ker niste �lan glavne skupine je va� dostop zavrnjen. �e mislite, da je to napaka, kontatkirajte administratorja sistema.',
    'listusers' => 'Izpi�i uporabnike',
    'listthem' => 'Izpis',
    'usersingroup' => 'Uporabniki v skupini %s',
    'usergroupadmin' => 'Administracija skupin uporabnikov',
    'add' => 'Dodaj',
    'remove' => 'Odstrani',
    'availmembers' => 'Uporabniki na voljo',
    'groupmembers' => '�lani skupine',
    'canteditgroup' => 'Za urejanje te skupine, morate biti njen �lan. Prosim posvetujte se z administratorjem, �e se vam zdi da je to sporo�ilo napaka.',
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
    'last_ten_backups' => 'Zadnjih 10 backupov',
    'do_backup' => 'Naredi backup',
    'backup_successful' => 'Bravo. Baza podatkov se je uspe�no bekapirala ;-).',
    'db_explanation' => '�e �elite narediti backup va�ega Geeklog sistema, kliknite gumb spodaj',
    'not_found' => "Napa�na pot ali mysqldump utility nima izvr�evalnih pravic.<br>Preveri <strong>\$_DB_mysqldump_path</strong> definicijo v config.php.<br>Spremenljivka je trenutno definirana kot: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup neuspe�en: Velikost datoteka je bila 0 bytov',
    'path_not_found' => "{$_CONF['backup_path']} ne obstaja ali pa ni direktorij",
    'no_access' => "NAPAKA: Direktorij {$_CONF['backup_path']} ni dosegljiv.",
    'backup_file' => 'Backup datoteka',
    'size' => 'Velikost',
    'bytes' => 'Bytov',
    'total_number' => 'Skupno �tevilo bekapov: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Domov',
    2 => 'Kontakt',
    3 => 'Objavi',
    4 => 'Povezave',
    5 => 'Ankete',
    6 => 'Koledar',
    7 => 'Statistika strani',
    8 => 'Osebne nastavitve',
    9 => 'I��i',
    10 => 'Napredno iskanje',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Napaka 404',
    2 => 'Ups, pogledal sem povsod, ampak ne najdem <b>%s</b>.',
    3 => "<p>�al mi je, ampak, datoteka ki jo zahteva� ne obstaja. Prosim preveri <a href=\"{$_CONF['site_url']}\">glavno stran</a> ali <a href=\"{$_CONF['site_url']}/search.php\">iskalno stran</a> in poglej �e lahko najde� kar si izgubil."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Zahtevan je vpis',
    2 => '�al, za ogled tega dela strani, mora� biti logiran kot uporabnik.',
    3 => 'Logiraj se',
    4 => 'Nov uporabnik'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'PDF na�in je onemogo�en',
    2 => 'Zahtevani dokument ni bil renderiran. Dokument je bil prejte ampak ga ni bilo mo�no sprocesirati. Prosim prepri�aj se da po�ilja� PDF procesorju samo dokumente v obliki html, ki so bili napisani po xHTML standardu. Upo�tevajte da pri pre-kompleksnih dokumentih lahko pride do tega, da se sploh ne sprocesirajo. Dokument ki je nastal na va�o zahtevo je dolg 0 bytov, in je bil izbrisan. �e ste prepri�ani, da bi se ta dokument moral pravilno izra�unati, ga prosimo po�ljite ponovno.',
    3 => 'Neznana napaka med izdelavo PDF dokumenta',
    4 => "Dobil nisem nobenih podatkov o strani, ali pa �elite uporabiti ad-hoc PDF generator spodaj. �e mislite da ste dobili to stran\n          Po nesre�i prosim sporo�ite to upravniku strani. �e temu ni tako, lahko uporabite spodnjo formo in si ustvarite PDF dokumente na na�in ad-hoc.",
    5 => 'Nalagam va� dokument.',
    6 => 'Prosim po�akajte, da nalo�im va� dokument.',
    7 => 'Spodnji gumb lahko kliknete z desnim mi�kinim gumbom in izberete \'save target...\' ali \'save link location...\' da shranite kopijo dokumenta.',
    8 => "Pot do HTMLDoc izvr�ilne datoteke, ki je zapisana v nastavitvah je napa�na in sistem je ne more zagnati. Prosimo sporo�ite ta problem upravniku strani\n          �e se ponavlja.",
    9 => 'Izdelovalnik PDF',
    10 => "To je orodje za Ad-hoc izdelavo PDF dokumentov. Orodje bo poizkusilo predelati vse URL naslove v PDF. Prosim zavedaj se, da se nekatere internetne strani NE bodo pravilno renderirale s tem na�inom (ad-hoc).  To\n           je omejitev orodja HTMLDoc in teh napak ne rabite prijavljati upravniku strani",
    11 => 'URL',
    12 => 'Naredi PDF!',
    13 => 'PHP konfiguracija na tem serverju ne dovoli odpiranja internetnih naslovov (URL) z ukazom fopen(). Upravnik strani mora popraviti php.ini datoteko in v njej prestaviti allow_url_fopen na On',
    14 => 'PDF ki ste ga zahtevali ali ne obstaja ali pa ste nepravilno dostopali do datoteke.'
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
    'pb_error_details' => 'Error when sending the pingback:',
    'delete_trackback' => 'To delete this Trackback click: '
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
# Month names

$LANG_MONTH = array(
    1 => 'januar',
    2 => 'februar',
    3 => 'marec',
    4 => 'april',
    5 => 'maj',
    6 => 'junij',
    7 => 'julij',
    8 => 'avgust',
    9 => 'september',
    10 => 'oktober',
    11 => 'november',
    12 => 'december'
);

###############################################################################
# Weekdays

$LANG_WEEK = array(
    1 => 'nedelja',
    2 => 'ponedeljek',
    3 => 'torek',
    4 => 'sreda',
    5 => '�etrtek',
    6 => 'petek',
    7 => 'sobota'
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
    'edit_adv' => 'Adv. Edit',
    'admin_home' => 'Admin Home',
    'create_new' => 'Create New',
    'create_new_adv' => 'Create New (Adv.)',
    'enabled' => 'Enabled',
    'title' => 'Title',
    'type' => 'Type',
    'topic' => 'Topic',
    'help_url' => 'Help File URL',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'delete_sel' => 'Delete selected',
    'copy' => 'Copy',
    'no_results' => '- No entries found -',
    'data_error' => 'There was an error processing the subscription data. Please check the data source.',
    'preview' => 'Preview',
    'records_found' => 'Records found'
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