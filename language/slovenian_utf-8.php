<?php

###############################################################################
# slovenian.php
# language file for geeklog version 1.3.10
#
# This is the slovenian language page for GeekLog!
# Special thanks to Mischa Polivanov for his work on this project
#
# Prevedel gape@gape.org ; za pripombe, predloge ipd ... piši na email
# med plug-ini še nekaj manjka ... ker ne razumem scene
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
    1 => 'Piše:',
    2 => 'Beri dalje',
    3 => 'komentarjev.',
    4 => 'Uredi',
    5 => 'Anketa',
    6 => 'Rezultati',
    7 => 'Rezultati ankete',
    8 => 'glasov<br>',
    9 => 'Administracijske funkcije:',
    10 => 'Čakajoča vsebina',
    11 => 'Članki',
    12 => 'Bloki',
    13 => 'Teme',
    14 => 'Povezave',
    15 => 'Dogodki',
    16 => 'Ankete',
    17 => 'Uporabniki',
    18 => 'SQL poizvedovanje',
    19 => 'Izhod iz sistema',
    20 => 'Podatki o uporabniku:',
    21 => 'Uporabniško ime',
    22 => 'Uporabniški ID',
    23 => 'Varnostni nivo',
    24 => 'Anonimni uporabnik',
    25 => 'Odgovori',
    26 => 'Za komentarje so odgovorni njihovi avtorji. Avtorji spletne strani na komentarje obiskovalcev nimamo nobenega vpliva.',
    27 => 'Zadnjikrat komentirano',
    28 => 'Izbriši',
    29 => 'Ni komentarjev.',
    30 => 'Starejši članki',
    31 => 'Dovoljeni HTML ukazi:',
    32 => 'Napaka, neveljavno uporabniško ime',
    33 => 'Napaka, ne morem shranjevati v log datoteko',
    34 => 'Napaka',
    35 => 'Izhod iz sistema',
    36 => 'dne',
    37 => 'Ni člankov',
    38 => 'Združevanje vsebine (Syndication)',
    39 => 'Osveži',
    40 => 'Izključene so <tt>register_globals = Off</tt> v <tt>php.ini</tt>. Geeklog zahteva <tt>register_globals</tt> <strong>vključene</strong>. Preden nadaljuješ, jih prosim <strong>vključi</strong> in ponovno zaženi web server.',
    41 => 'Gostje',
    42 => 'Prispeval/a:',
    43 => 'Odgovori na To',
    44 => 'Starš',
    45 => 'MySQL številka napake',
    46 => 'MySQL sporočilo o napaki',
    47 => 'Prijava uporabnika',
    48 => 'Podatki o uporabniškem računu',
    49 => 'Nastavitve',
    50 => 'Napaka v SQL ukazu',
    51 => 'pomoč',
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
    64 => 'Pošlji članek prijatelju po e-pošti',
    65 => 'Stran prijazna za tisk',
    66 => 'Osebni koledar',
    67 => 'Dobrodošli na ',
    68 => 'Domov',
    69 => 'Kontakt',
    70 => 'Išči',
    71 => 'Dodaj članek',
    72 => 'Zanimive povezave',
    73 => 'Pretekle ankete',
    74 => 'Koledar dogodkov',
    75 => 'Napredno iskanje',
    76 => 'Statistika spletne strani',
    77 => 'Priključeni moduli',
    78 => 'Dogodki',
    79 => 'Kaj je novega',
    80 => 'Člankov v zadnjih',
    81 => 'Članek v zadnjih ',
    82 => 'urah',
    83 => 'KOMENTARJI BRALCEV<br>',
    84 => 'POVEZAVE<br>',
    85 => 'v zadnjih 48 urah',
    86 => 'ni novih komentarjev',
    87 => 'v zadnjih 2 tednih',
    88 => 'ni novih povezav',
    89 => 'Trenutno ni nobenih prihajajočih dogodkov.',
    90 => 'Na osnovno stran',
    91 => 'Spletna stran zgenerirana v',
    92 => 'sekundah',
    93 => 'Copyright',
    94 => 'Vsa naša koda pripada vam.',
    95 => 'Gnano z',
    96 => 'Uporabniške skupine',
    97 => 'Seznam besed',
    98 => 'Priključni moduli',
    99 => 'ČLANKI',
    100 => 'Ni novih člankov',
    101 => 'Vaši dogodki',
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
    1 => 'Pošiljanje komentarja',
    2 => 'Oblika besedila',
    3 => 'Odjava',
    4 => 'Registrirajte se',
    5 => 'Uporabniško ime',
    6 => 'Če želite posredovati komentar se morate registrirati. Če še nimate svojega uporabniškega imena in gesla, kliknite spodaj.',
    7 => 'Vaš zadnji komentar je bil pred',
    8 => " sekundami.  Med posameznimi komentarji bralca mora preteči vsaj {$_CONF['commentspeedlimit']} sekund",
    9 => 'Komentar',
    10 => 'Pošlji prijavo',
    11 => 'Pošlji komentar',
    12 => 'Če želite posredovati komentar, vpišite vaše ime, e-mail naslov, naslov komentarja in vsebino komentarja.',
    13 => 'Vaše informacije',
    14 => 'Predogled',
    15 => 'Report this post',
    16 => 'Naslov',
    17 => 'Napaka',
    18 => 'Pomembno',
    19 => 'Prosimo da se skušate držati teme objavljenega članka.',
    20 => 'Zaželeno je argumentiranje vaših trditev.',
    21 => 'Preberite komentarje ostalih - morda je kdo že napisal kaj kar nameravate napisati tudi vi.',
    22 => 'Pazite na pravilno slovnico in se izogibajte žalitvam drugih.',
    23 => 'Vaš e-mail naslov ne bo javno objavljen.',
    24 => 'Anonimni uporabnik',
    25 => 'Ste prepričani da hočete prijaviti ta orispevek upravniku strani?',
    26 => '%s je prijavil naslednji prispevek ki zlorablja:',
    27 => 'Prijava zlorabe'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Uporabnik',
    2 => 'Uporabniško ime',
    3 => 'Ime',
    4 => 'Geslo',
    5 => 'Elektronski naslov',
    6 => 'Spletna stran',
    7 => 'Opis',
    8 => 'PGP javni ključ',
    9 => 'Shrani podatke',
    10 => 'Zadnjih 10 komentarjev uporabnika',
    11 => 'Uporabnik ni prispeval nobenih komentarjev',
    12 => 'Uporabniške nastavitve za',
    13 => 'Pošlji nočno poročilo (Nightly Digest)',
    14 => 'Geslo se generira naključno. Priporočamo vam, da geslo takoj spremenite. To storite s klikom na Informacije o računu v  meniju Osebne nastavitve. Za spremembe osebnih nastavitev se morate prijaviti v sistem.',
    15 => 'Vaš uporabniški račun na spletni strani je bil uspešno vzpostavljen. Če ga želite uporabljati, se morate prijaviti s spodnjimi podatki. Svetujemo vam da podatke o vašem uporabniškem računu shranite.',
    16 => 'Informacije o vašem uporabniškem računu',
    17 => 'Uporabniški račun ne obstaja',
    18 => 'Vnešeni e-mail naslov ni veljaven',
    19 => 'Vnešeno uporabniško ime ali e-mail naslov sta že uporabljena na tem sistemu',
    20 => 'Vnešeni e-mail naslov ni veljaven',
    21 => 'Napaka',
    22 => "Registracija {$_CONF['site_name']}!",
    23 => "Registracija vam omogoča članstvo na naši spletni strani{$_CONF['site_name']}. To pomeni da boste lahko objavljali komentarje, pošiljali svoje članke, dostopali in dodajali zapiske in bili deležni vseh pomembnih informacij. Če se ne registrirate, boste na spletni strani lahko sodelovali le kot anonimni uporabnik. <font color=red>Elektronski naslovi registriranih uporabnikov <b><i>ne bodo javno objavljeni</i></b>.",
    24 => 'Geslo vam bomo poslali na e-mail naslov, ki ste ga vnesli.',
    25 => 'Ste pozabili geslo?',
    26 => 'Vnesite <em>uporabniško ime</em> <em>ali</em> email naslov s katerim ste se registrirali in kliknite spodnji gumb (Pošlji geslo po emailu). Navodila kako nastaviti novo geslo vam bomo sporočili na registrirani e-mail naslov.',
    27 => 'Registrirajte se!',
    28 => 'Pošlji geslo na e-mail naslov',
    29 => 'odjava',
    30 => 'prijava',
    31 => 'Za izvedbo te funkcije se morate prijaviti',
    32 => 'Podpis',
    33 => 'Se nikoli javno ne prikaže',
    34 => 'Vaše pravo ime',
    35 => 'Vpiši spremenjeno geslo',
    36 => 'Začneš z http://',
    37 => 'Nastavitve komentarjev',
    38 => 'To lahko prebere vsakdo',
    39 => 'PGP javni klju?',
    40 => 'Brez ikone teme',
    41 => 'Pripravljen moderirati',
    42 => 'Format datuma',
    43 => 'Največ člankov',
    44 => 'Brez okvirjev',
    45 => 'Prikaži nastavitve za',
    46 => 'Izključeni deli',
    47 => 'Nastavitve novosti za',
    48 => 'Teme',
    49 => 'Brez ikon v člankih',
    50 => 'Če vas ne zanima, odznačite',
    51 => 'Samo novi članki',
    52 => 'Privzeta nastavitev je 10',
    53 => 'Prejmi nove članke vsako noč',
    54 => 'Označi teme in avtorje, katerih prispevki vas ne zanimajo',
    55 => 'Če pustite prazno, se bodo ohranile privzete nastavitve. Če začnete izbirati bloke, se bodo prikazali samo tisti, ki ste jih izbrali (brez privzetih). Privzete nastavitve so <B> povdarjene</B>.',
    56 => 'Avtorji',
    57 => 'Način prikaza',
    58 => 'Uredi po',
    59 => 'Omejitve komentarja',
    60 => 'Kakšen način izpisa želite za svoje komentarje',
    61 => 'Najprej novi ali stari?',
    62 => 'Prevzeta vrednost je 100',
    63 => "Geslo je bilo poslano na vaš e-mail naslov. Sledite navodilom, ki jih boste dobili. Hvala ker uporabljate spletno stran {$_CONF['site_name']}",
    64 => 'Nastavitve komentarjev za',
    65 => 'Poizkusite se ponovno prijaviti',
    66 => "Morda ste se zmotili pri vnosu svojega uporabniškega imena ali gesla? Poizkusite se ponovno prijaviti. Ste morda še neregistriran uporabnik - v tem primeru se <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrirajte</a>.",
    67 => 'Uporabnik od',
    68 => 'Zapomni se me za',
    69 => 'Kako dolgo naj si te zapomnim po zadnji prijavi?',
    70 => "Priredi izgled spletne strani {$_CONF['site_name']}",
    71 => "Ena od posebnosti spletne strani{$_CONF['site_name']} je popolna možnost prilagajanja izgleda posameznemu uporabniku.  Če želite uporabiti to možnost se morate najprej <a href=\"{$_CONF['site_url']}/users.php?mode=new\">prijaviti</a> na {$_CONF['site_name']}.  Ali ste že postali registrirani uporabnik?  Prijavite se!",
    72 => 'Tema',
    73 => 'Jezik',
    74 => 'Spremeni izgled strani!',
    75 => 'Teme po e-mailu',
    76 => 'Nove članke iz izbranih področij boste ob koncu vsakega dneva prejeli po e-mailu. Izberite teme, ki vas zanimajo!',
    77 => 'Slika',
    78 => 'Dodaj svojo sliko!',
    79 => 'Izbriši izbrano sliko',
    80 => 'Vpis',
    81 => 'Pošlji Email',
    82 => 'Zadnjih 10 člankov uporabnika',
    83 => 'Statistika objavljanja uporabnika',
    84 => 'Skupno število člankov:',
    85 => 'Skupno število komentarjev:',
    86 => 'Najdi vse objave uporabnika',
    87 => 'Vaše uporabniško ime',
    88 => "Nekdo (verjetno ti) je zahteval novo geslo za tvoj račun  \"%s\" na {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nČe res želiš novo geslo, prosim klikni povezavo :\n\n",
    89 => "Če nočeš novega gesla, preprosto ignoriraj to sporočilo in zahtevo bomo zavrgli (tvoje geslo bo ostalo nespremenjeno).\n\n",
    90 => 'Spodaj lahko vpišeš novo geslo za svoj račun. Prosim, vedi, da je staro geslo še vedno veljavno, dokler ne  odpošlješ tega obrazca.',
    91 => 'Nastavljanje novega gesla',
    92 => 'Vpiši novo geslo',
    93 => 'Tvoja zadnja zahteva za novo geslo je bila sprejeta pred %d sekundami. Te strani zahtevajo vsaj %d sekund med spremembami gesla.',
    94 => 'Izbriši račun "%s"',
    95 => 'Klikni gumb "Izbriši račun" spodaj za izbris svojega uporabniškega računa iz naše baze podatkov. Vedi, da bodo vsi prispevki, ki si jih prispeval/a pod tem računom <strong>ostali</strong> na naših straneh. Uporabnik, ki jih je prispeval pa bo postal anonimnež.',
    96 => 'Izbriši račun',
    97 => 'Potrdi brisanje računa',
    98 => 'Si prepričan da želiš pobrisati svoj uporabniški račun. Po tem prijava na naše strani ne bo več mogoča (razen, če si ustvariš nov račun). Če si prepričan/a ponovno klikni "Izbriši račun" v spodnjem obrazcu.',
    99 => 'Nastavitve zasebnosti za',
    100 => 'Adminov email',
    101 => 'Dovoli emaile od upravljalcev strani',
    102 => 'Email od uporabnikov',
    103 => 'Dovoli emaile od drugih uporabnikov strani',
    104 => 'Prikaži Online Status',
    105 => 'Dovoli prikaz v bloku Na liniji so',
    106 => 'Lokacija',
    107 => 'Prikazano v vašem javnem profilu',
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
    1 => 'Področje je trenutno prazno',
    2 => 'Trenutno v tem tematskem področju ni nobenega članka, ali pa so vaše uporabniške nastavitve takšne da nimate dostopa do tega področja',
    3 => '.',
    4 => 'Današnji udarni članek',
    5 => 'naslednja stran',
    6 => 'prejšnja stran',
    7 => 'Prva',
    8 => 'Zadnja'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Napaka!!! Poskusite znova.',
    2 => 'Sporočilo je bilo poslano',
    3 => 'Uporabite pravi e-mail naslov!',
    4 => 'Izpolnite polja: Ime, e-mail za odgovor, Zadeva in vpišite sporočilo',
    5 => 'Napaka. Neznan uporabnik!',
    6 => 'Upsss... Napaka ;-).',
    7 => 'Uporabnik',
    8 => 'Uporabniško ime',
    9 => 'URL naslov',
    10 => 'e-mail naslov',
    11 => 'Ime:',
    12 => 'e-mail za odgovor:',
    13 => 'Zadeva:',
    14 => 'Sporočilo:',
    15 => 'HTML ukazi ne bodo upoštevani.',
    16 => 'Pošlji sporočilo',
    17 => 'Pošlji članek prijatelju po e-mailu',
    18 => 'Ime prijatelja',
    19 => 'Elektronski naslov prijatelja',
    20 => 'Vaše ime',
    21 => 'Vaš e-mail naslov',
    22 => 'Izpolniti je potrebno vsa polja!',
    23 => "To sporočilo vam je poslal naš obiskovalec %s (%s). Upravitelji spletne strani {$_CONF['site_url']} od koder je bilo sporočilo poslano, vaših podatkov nismo shranili v nobeno bazo podatkov.",
    24 => 'Članek se nahaja na spletnem naslovu: ',
    25 => 'Če želite poslati članek po e-pošti, se morate predhodno registrirati. Registracija je potrebna da preprečimo morebitne zlorabe sistema.',
    26 => 'S pomočjo tega obrazca boste poslali e-mail izbranemu uporabniku. Izpolniti je potrebno vsa polja!',
    27 => 'Kratko spremno sporočilo',
    28 => 'Obiskovalec %s je napisal sledeče spremno sporočilo: ',
    29 => "Dnevni pregled strani {$_CONF['site_name']} za ",
    30 => 'Dnevne novice za',
    31 => 'Naslov',
    32 => 'Datum',
    33 => 'Celotno besedilo:',
    34 => 'Konec sporočila',
    35 => 'Žal, ta uporabnik ne želi prejemati emailov.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Napredno iskanje',
    2 => 'Ključne besede',
    3 => 'Tematsko področje',
    4 => 'vse',
    5 => 'Nasvet',
    6 => 'Članki',
    7 => 'komentarji bralcev',
    8 => 'Avtorji',
    9 => 'vse',
    10 => 'Išči',
    11 => 'Rezultati iskanja',
    12 => 'zadetki',
    13 => 'Iskanje med članki: nič zadetkov',
    14 => 'Za iskalni pojem',
    15 => 'ni nobenega zadetka. Prosimo poizkusite ponovno.',
    16 => 'Naslov',
    17 => 'datum',
    18 => 'avtor',
    19 => 'Iskalnik celotne baze podatkov (vsi članki in vsi komentarji bralcev)',
    20 => 'Datum',
    21 => 'do',
    22 => '(format datuma YYYY-MM-DD)',
    23 => 'Št. zadetkov',
    24 => 'Našel sem %d zadetkov',
    25 => 'Iskal sem',
    26 => 'zadetkov ',
    27 => 'sekund.',
    28 => 'Za vpisani iskalni pogoj ni bilo najdenega nobenega članka niti nobenega komentarja',
    29 => 'Rezultati iskanja',
    30 => 'Nobena povezava ne ustreza vašemu iskalnemu pogoju. Poizkusite znova!',
    31 => 'Ni zadetkov za ta plug-in. Poizkusite znova!',
    32 => 'Dogodek',
    33 => 'URL',
    34 => 'Lokacija',
    35 => 'Celodnevno dogajanje',
    36 => 'Noben dogodek ne ustreza vašemu iskalnemu pogoju. Poizkusite znova!',
    37 => 'Rezultati za dogodke',
    38 => 'Rezultati za povezave',
    39 => 'Povezave',
    40 => 'Dogodki',
    41 => 'Iskalni niz mora imeti vsaj tri znake.',
    42 => 'Datum naj bo formatiran na način: YYYY-MM-DD (leto-mesec-dan).',
    43 => 'točna fraza',
    44 => 'vse besede',
    45 => 'katerakoli beseda',
    46 => 'Naslednji',
    47 => 'Prejšnji',
    48 => 'Avtor',
    49 => 'Datum',
    50 => 'Zadetki',
    51 => 'Povezava',
    52 => 'Lokacija',
    53 => 'Rezultati člankov',
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
    2 => 'Število vseh obiskov strani',
    3 => 'Število objavljenih člankov (komentarjev)',
    4 => 'Število anket (odgovorov)',
    5 => 'Število povezav (obiskov)',
    6 => 'Število napovedanih dogodkov',
    7 => 'Deset najbolj branih člankov',
    8 => 'Naslov članka',
    9 => 'Št. ogledov',
    10 => 'Na spletni strani ni objavljenih člankov, ali pa nihče ni prebral nobenega članka.',
    11 => 'Deset najbolj komentiranih člankov',
    12 => 'Št. komentarjev',
    13 => 'Na spletni strani ni objavljenih komentarjev, ali pa nihče ni objavil nobenega komentarja.',
    14 => 'Deset najbolj obiskanih anket',
    15 => 'Anketno vprašanje',
    16 => 'Št. glasov',
    17 => 'Na spletni strani ni objavljena nobena anketa, ali pa nihče ni glasoval pri nobeni anketi.',
    18 => 'Deset najbolj obiskanih povezav',
    19 => 'Povezave',
    20 => 'Št. ogledov',
    21 => 'Na spletni strani ni objavljena nobena povezava ali pa nihče ni obiskal nobene povezave.',
    22 => 'Deset najbolj po e-mailu posredovanih člankov',
    23 => 'Št. posredovanj',
    24 => 'Nihče ni posredoval nobenega članka po e-mailu.',
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
    2 => 'Pošlji članek po e-pošti',
    3 => 'Stran prijazna za tisk',
    4 => 'Dodatne možnosti',
    5 => 'PDF format članka'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "Če želite objaviti %s se morate prijaviti. Še niste registrirani uporabnik? <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> Registrirajte se</a>.",
    2 => 'Prijava',
    3 => 'Nov uporabnik',
    4 => 'Pošlji dogodek',
    5 => 'Pošlji povezavo',
    6 => 'Članek',
    7 => 'Potrebno se je prijaviti!',
    8 => 'Pošlji',
    9 => 'Pri pošiljanju informacij se držite naslednjih priporočil:<ul><li>izpolnite vsa polja,<li>poskrbite da bo informacija, ki jo pošiljate točna in ustrezna,<li>pazite na slovnico,<li>preverite da delujejo vse povezave,<li><font color=red>prosimo da pošiljate <b>samo članke</b>, komentarje vpisujte pod posamezen članek, za splošne debate ali mnenja pa uporabite forum.</font></ul>',
    10 => 'Naslov',
    11 => 'Povezava',
    12 => 'Datum začetka',
    13 => 'Datum zaključka',
    14 => 'Lokacija',
    15 => 'Opis',
    16 => 'Če \'drugo\', vpiši ime',
    17 => 'Kategorija',
    18 => 'Drugo',
    19 => 'Prosimo, preberite',
    20 => 'Napaka: ni določena kategorija',
    21 => 'Kadar izberete "Drugo" vpišite tudi ime kategorije',
    22 => 'Napaka: niso izpolnjena vsa polja',
    23 => 'Prosimo izpolnite vsa polja obrazca.',
    24 => 'Shranjeno!',
    25 => 'Vaš %s prispevek je bil shranjen.',
    26 => 'Omejitev hitrosti',
    27 => 'Uporabniško ime',
    28 => 'Tematsko področje',
    29 => 'Vsebina članka',
    30 => 'Vaša zadnja objava je bila poslana pred ',
    31 => " sekundami. Nastavitve te spletne strani pa zahtevajo da med dvema objavama istega avtorja mine vsaj {$_CONF['speedlimit']} sekund",
    32 => 'Predogled',
    33 => 'Predogled članka',
    34 => 'izhod',
    35 => 'HTML ukazi ne bodo upoštevani',
    36 => 'Oblika besedila',
    37 => 'Dogodek bo dodan na skupni koledar, od koder ga registrirani uporabniki lahko dodajo na svoj osebni koledar. Ta aplikacija zato <b>NI</b> namenjena shranjevanju osebnih dogodkov (obletnice, rojstni dnevi, zabave...) če nas ne mislite nanje povabiti ;-)<br><br>Preden bo dogodek objavljen na skupnem koledarju dogodkov, ga bo pregledal administrator!',
    38 => 'Dodaj dogodek v',
    39 => 'Skupni koledar',
    40 => 'Osebni koledar',
    41 => 'Čas zaključka',
    42 => 'Čas začetka',
    43 => 'Celodnevni dogodek',
    44 => 'Naslov 1',
    45 => 'Naslov 2',
    46 => 'Mesto',
    47 => 'Država',
    48 => 'Poštna številka',
    49 => 'Tip dogodka',
    50 => 'Uredi tipe dogodkov',
    51 => 'Lokacija',
    52 => 'Odstrani',
    53 => 'Naredi račun'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Obvezna prijava',
    2 => 'Dostop zavrnjen! Vnesli ste napačne podatke.',
    3 => 'Napačno geslo za uporabnika',
    4 => 'Uporabniško ime:',
    5 => 'Geslo:',
    6 => 'Vsi dostopi do administracijske strani se beležijo.<br>Ta del spletne strani lahko uporabljajo samo pooblaščene osebe.<p>',
    7 => 'prijava'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Ups... ne bo šlo. Nimate zahtevanih administratorskih pravic ;-)',
    2 => 'Za urejanje tega bloka nimate zahtevanih administratorskih pravic',
    3 => 'Urejanje blokov',
    4 => 'Pri branju je nastala težava (za detajle glej error.log).',
    5 => 'Ime bloka',
    6 => 'Tema',
    7 => 'Vse',
    8 => 'Varnostna raven bloka',
    9 => 'Pravila bloka',
    10 => 'Tip bloka',
    11 => 'Blok na portalu',
    12 => 'Običajni blok',
    13 => 'Nastavitve bloka na portalu',
    14 => 'RDF URL',
    15 => 'Zadnja RDF osvežitev',
    16 => 'Nastavitve običajnega bloka',
    17 => 'Komentar',
    18 => 'Vnesite ime in vsebino bloka',
    19 => 'Administracija bloka',
    20 => 'Ime bloka',
    21 => 'Varnostna raven',
    22 => 'Tip bloka',
    23 => 'Pravila bloka',
    24 => 'Tema bloka',
    25 => 'Izberite blok, ki ga želite urediti ali odstraniti. Če želite ustvariti nov blok, kliknite zgoraj.',
    26 => 'Izgled',
    27 => 'PHP blok',
    28 => 'Nastavitve PHP bloka',
    29 => 'Funkcije bloka',
    30 => 'Če želiš da blok uporablja php kodo, zgoraj vpiši ime funkcije. Ime funkcije se mora začeti z izrazom "phpblock_" (t.j. phpblock_getweather). Če funkcija nima te predpone, NE bo klicana.  To je narejeno tako zaradi tega, da potencialni hekerji ne morejo izvesti kode, ki bi lahko škodovala sistemu. Pazi da ne vstaviš praznih oklepajev "()" za ime funkcije. Priporočamo vso svojo kodo, tudi to za bloke, vpisujete v /pot/do/geekloga/system/lib-custom.php. Tako bo ta koda brez težav ostala z vami tudi po nadgradnji Geekloga.',
    31 => 'Napaka v PHP bloku. Funkcija %s, ne obstaja.',
    32 => 'Napaka. Manjkajo podatki',
    33 => 'Vnesite URL naslov v datoteko .rdf za blok na portalu',
    34 => 'Vnesite naslov in funkcijo PHP bloka',
    35 => 'Vnesite naslov in vsebino bloka',
    36 => 'Vnesite vsebino in izberite izgled bloka',
    37 => 'Napačno ime funkcije PHP bloka',
    38 => 'Funkcije PHP bloka morajo imeti predpono \'phpblock_\' (npr. phpblock_imefunkcije).  Predpona \'phpblock_\' je potrebna zaradi varnosti!',
    39 => 'Stran',
    40 => 'Levo',
    41 => 'Desno',
    42 => 'Vnesite ime bloka in vrstni red zanj.',
    43 => 'Samo domača stran',
    44 => 'Dostop zavrnjen',
    45 => "Do tega bloka nimate dostopa. Vaš poskus je bil zabeležen v bazo podatkov! Prosimo, vrnite se na <a href=\"{$_CONF['site_url']}/admin/block.php\"> stran za administracijo</a>!",
    46 => 'Nov blok',
    47 => 'Administratorske strani',
    48 => 'Ime bloka',
    49 => ' (Presledki niso dovoljeni. Imena blokov ne smejo biti podvojena',
    50 => 'URL za pomoč',
    51 => 'Začneš s http://',
    52 => 'Če pustite prazno, se ikona za pomoč ne bo izpisala!',
    53 => 'Omogočeno',
    54 => 'Shrani',
    55 => 'Prekliči',
    56 => 'Izbriši',
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
    1 => 'Prejšnji članki',
    2 => 'Naslednji članki',
    3 => 'Nastavitve članka',
    4 => 'Oblikovanje članka',
    5 => 'Urejanje članka',
    6 => 'Ni člankov v sistemu',
    7 => 'Avtor',
    8 => 'Shrani',
    9 => 'Predogled',
    10 => 'Prekliči',
    11 => 'Izbriši',
    12 => 'ID',
    13 => 'Naslov',
    14 => 'tematsko področje',
    15 => 'datum',
    16 => 'Uvodno besedilo',
    17 => 'Razširjeno besedilo',
    18 => 'Št. branj',
    19 => 'Komentarjev',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Seznam člankov',
    23 => 'Če želite spreminjati ali izbrisati članek, kliknite na njegovo številko. Če želite članek pregledati, kliknite na njegov naslov. Če želite objaviti nov članek, kliknite na zgornjo povezavo.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Predogled članka',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'Napake pri shranjevanju datoteke',
    31 => 'Prosimo izpolnite polji Naslov in Uvodno besedilo',
    32 => 'Udarni članek',
    33 => 'Udarni članek je lahko smo eden',
    34 => 'Draft',
    35 => 'Da',
    36 => 'Ne',
    37 => 'Več od avtorja',
    38 => 'Več iz področja',
    39 => 'Št. posredovanj po e-mailu',
    40 => 'Dostop zavrnjen',
    41 => "Poizkušate dostopati do članka do katerega nimate dostopa. Ta poizkus neveljavnega dostopa je bil zabeležen in shranjen. članek lahko samo preberete, ne morete pa ga urejati. Če želite lahko vstopite <a href=\"{$_CONF['site_url']}/admin/story.php\"> na administracijo članka</a>.",
    42 => "Poizkušate dostopati do članka do katerega nimate dostopa. Ta poizkus neveljavnega dostopa je bil zabeležen in shranjen. Če želite lahko vstopite <a href=\"{$_CONF['site_url']}/admin/story.php\">na administracijo člankov</a>.",
    43 => 'Nov članek',
    44 => 'Administracijska stran',
    45 => 'Dostop',
    46 => '<b>POZOR:</b> vaš prispevek ne bo objavljen do izbranega datuma.Do tega datuma tudi na bo v vašem RDF in ne bo vključn v iskalnik.',
    47 => 'Slike',
    48 => 'slika',
    49 => 'desno',
    50 => 'levo',
    51 => 'Sliko vstavite v članek s posebnim ukazom [imageX], [imageX_right] ali [imageX_left], kjer je X številka slike v prilogi. POZOR: uporabite lahko samo slike iz priloge. V nasprotnem primeru članka ne bo mogoče objaviti. <BR><P><B>PREDOGLED</B>: Predogled članka s slikami najenostavneje opraviter tako, da članek shranite kot draft in ne uporabite gumba Predogled. Funkcija Predogled deluje deluje le, če članek brez slik.',
    52 => 'Odstrani',
    53 => 'ni bila uporabljena. Sliko morate pred shranjevanjem vključiti v uvod ali med besedilo članka.',
    54 => 'Priložene slike niso bile uporabljene',
    55 => 'Napaka pri shranjevanju članka. Prosimo popravite napake na spodnjem seznamu:',
    56 => 'Prikaži ikono teme',
    57 => 'Oglej si nezmanjšano sliko',
    58 => 'Administracija člankov',
    59 => 'Opcija',
    60 => 'Omogočeno',
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
    6 => 'Če odstranite temo, odstranite tudi vse članke in bloke, ki so z njo povezani',
    7 => 'Izpolnite ID teme in naslov teme.',
    8 => 'Urejevalnik tem',
    9 => 'Izberite temo, ki jo želite urediti ali odstraniti. Če želite ustvariti novo temo, kliknite gumb Nova tema, na levi. V vsaki temi najdeš, v oklepajih, svoj nivo dostopa. Zvazdica (*) označuje privzeto temo.',
    10 => 'Uredi po',
    11 => 'Člankov/Strani',
    12 => 'Dostop zavrnjen!',
    13 => "Do te teme nimate dostopa. Vaš poskus je bil zabeležen in shranjen. Prosimo, vrnite se na <a href=\"{$_CONF['site_url']}/admin/topic.php\"> administracijo tem</a>!",
    14 => 'Uredi po',
    15 => 'abecedi',
    16 => 'privzeto',
    17 => 'Nova tema',
    18 => 'Administratorske strani',
    19 => 'Shrani',
    20 => 'Prekliči',
    21 => 'Izbriši',
    22 => 'Privzeto',
    23 => 'Ustvari to temo privzeto za novo oddane članke',
    24 => '(*)',
    25 => 'Arhiviraj temo',
    26 => 'naredi to temo privzeto za arhivirane članke. Samo ena tema je dovoljena.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Urejanje uporabnika',
    2 => 'ID uporabnika',
    3 => 'uporabniško ime',
    4 => 'ime uporabnika',
    5 => 'Geslo',
    6 => 'Varnostni nivo',
    7 => 'e-mail naslov',
    8 => 'Vaša spletna stran',
    9 => '(ne uporabljajte presledkov)',
    10 => 'Prosimo vpišite uporabniško ime in e-mail.',
    11 => 'Administracija uporabnikov',
    12 => 'Če želite spremeniti ali izbrisati uporabnika, kliknite na njegovo uporabniško ime spodaj. Če želite ustvariti novega uporabnika, kliknite gumb Nov uporabnik na levi. V spodnje okence vpišite iskalni niz, iščete lahko po imenu, delu imena, emailu ali celotnem imenu (npr. *sin* ali *.si*).',
    13 => 'Varnostni nivo',
    14 => 'Datum registracije',
    15 => 'nov uporabnik',
    16 => 'Administratorske strani',
    17 => 'spremeni geslo',
    18 => 'prekini',
    19 => 'izbriši',
    20 => 'shrani',
    21 => 'Uporabniško ime, ki ga želite hraniti že obstaja.',
    22 => 'Napaka',
    23 => 'Zaporedno dodajanje',
    24 => 'Zaporedno dodajanje uporabnikov',
    25 => 'Uvoziš lahko zaporedje uporabnikov v Geekloga.  Datoteka za uvoz mora biti razdeljena s tabi in mora biti navadna tekstovna datoteka. Polja naj si sledijo v naslednjem vrstnem redu: polno ime, uporabniško ime, email naslov.  Vsak uporabnik bo prejel email z naključnim geslom. Vsak uporabnik naj bo vpisan v svoji vrstici. Če ne upoštevaš teh navodil, lahko nastanejo precejšnje težave, ki bodo zahtevale ročno delo, zato, še enkrat preveri vpise v datoteki preden jo začneš uvažati!',
    26 => 'Išči',
    27 => 'Omejitve iskanja',
    28 => 'Izbriši sliko',
    29 => 'Pot',
    30 => 'Uvozi',
    31 => 'Novi uporabniki',
    32 => 'Končano. Uvoženo %d in %d napak',
    33 => 'pošlji',
    34 => 'Napaka: Moraš določiti datoteko.',
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
    2 => 'Izbriši',
    3 => 'Uredi',
    4 => 'Profil',
    10 => 'Naslov',
    11 => 'Datum začetka',
    12 => 'URL',
    13 => 'Kategorija',
    14 => 'Datum',
    15 => 'Tema',
    16 => 'Uporabniško ime',
    17 => 'Popolno ime',
    18 => 'E-mail',
    34 => 'Administratorske strani',
    35 => 'Čakajoči članki',
    36 => 'Čakajoče povezave',
    37 => 'Čakajoči dogodki',
    38 => 'Potrdi',
    39 => 'Trenutno v tem področju ni nobene čakajoče vsebine.',
    40 => 'Uporabniki so poslali'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} EMail pripomoček",
    2 => 'Od:',
    3 => 'Naslov za odgovor:',
    4 => 'Zadeva:',
    5 => 'Sporočilo:',
    6 => 'Naslov:',
    7 => 'Vsem uporabnikom',
    8 => 'Admin',
    9 => 'Nastavitve',
    10 => 'HTML',
    11 => 'Nujno sporočilo!',
    12 => 'Pošlji',
    13 => 'Zbriši',
    14 => 'Prezri uporabniške nastavitve',
    15 => 'Napaka pri pošiljanju: ',
    16 => 'Sporočilo je bilo uspešno poslano na naslov: ',
    17 => "<a href={$_CONF['site_url']}/admin/mail.php>Pošlji novo sporočilo</a>",
    18 => 'Za:',
    19 => 'POZOR: če želite poslati sporočilo vsem uporabnikom strani, izberite skupino Prijavljeni uporabniki iz menija Uporabniki',
    20 => "Uspešno poslana sporočila: <successcount>;<BR>Neuspešno poslana sporočila: <failcount>. Podrobnosti o neuspešno poslanih sporočilh najdete spodaj.<BR><BR>Želite poslati še kakšno <a href=\"{$_CONF['site_url']}/admin/mail.php\">sporočilo</a>? <BR><BR>Nazaj na <a href=\"{$_CONF['site_url']}/admin/moderation.php\">administratorkse strani</a>.",
    21 => 'Neuspešno poslana sporočila',
    22 => 'Uspešno poslana sporočila',
    23 => 'Nobenega neuspešno poslanega sporočila',
    24 => 'Nobenega uspešno poslanega sporočila',
    25 => '-- Izberi skupino --',
    26 => 'Prosim izpolni vsa polja v obrazcu in izberi skupino uporabnikov iz menija.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Instalacija vtičnikov (plugin) lahko povzroči škodo tvoji instalaciji Geekloga, lahko tudi tvojemu sistemu. Pomemno je, da instaliraš samo vtičnike, ki jih pretočiš z <a href="http://www.geeklog.net" target="_blank">Geeklogove domače strani</a> saj smo samo te dodobra preizkusili na različnih operacijskih sistemih. Pomembno je razumeti, da je instalacija vtičnikov proces, ki zahteva izvajanje nekaterih komand na nivoju datotečnega sistema. Te lahko vodijo do varnostnih lukenj, posebno če uporabljaš vtičnik iz strani tretjih oseb. Tudi s tem opozorilom, ne garantiramo uspeh katerekoli instalacije niti nismo odgovorni za škodo povzročeno z instalacijo vtičnika za Geeklog. Z drugimi besedami instaliraš na svojo lastno odgovornost. Navodila za ročno instalacijo vtičnika so vključena v paketu vsakega vtičnika.',
    2 => 'Plug-in Installation Disclaimer',
    3 => 'Plug-in Installation Form',
    4 => 'Plug-in File',
    5 => 'Spisek vtičnikov',
    6 => 'Opozorilo: Plug-in je že nameščen!',
    7 => 'Vtičnik ki ga skušaš namestiti je že nameščen. Prosim pobriši stari vtičnik pred ponovno instalacijo',
    8 => 'Test kompatibilnosti vtičnika ni uspel',
    9 => 'Ta vtičnik zahteva novejšo verzijo Geekloga. Namesti novo različico <a href="http://www.geeklog.net">Geekloga</a> ali najdi novejšo verzijo vtičnika.',
    10 => '<br><b>Trenutno ni nameščenih nobenih vtičnikov.</b><br><br>',
    11 => 'Za spremembo ali izbris vtičnika, klikni njegovo številko spodaj. Za več informacij o vtičniku, klikni njegovo ime in preusmerjen boš na njegovo domačo stran. Za instalacijo ali nadgradnjo vtičnika, klikni na gumb Nov vtičnik zgoraj.',
    12 => 'nobeno ime vtičnika ni bilo poslano v plugineditor()',
    13 => 'Urejevalnik vtičnikov(Plugin Editor)',
    14 => 'Nov vtičnik',
    15 => 'Administratorske strani',
    16 => 'Ime vtičnika',
    17 => 'Verzija vtičnika',
    18 => 'Verzija Geekloga',
    19 => 'Omogočen',
    20 => 'Da',
    21 => 'Ne',
    22 => 'Namesti',
    23 => 'Shrani',
    24 => 'Prekliči',
    25 => 'Odstrani',
    26 => 'Ime Plug-ina',
    27 => 'Plug-in Homepage',
    28 => 'Verzija Plug-in',
    29 => 'Verzija Geekloga',
    30 => 'Odstrani Plug-in?',
    31 => 'Ali ste prepričani da želite odstraniti ta plug-in?  S tem bodo iz baze izbrisani tudi vsi podatki, ki jih uporablja ta plug-in.',
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
    3 => 'zbriši',
    4 => 'prekliči',
    10 => 'Vsebina (Syndication)',
    11 => 'Nova vsebina (Feed)',
    12 => 'Adminov dom',
    13 => 'Za spreminjanje ali brisanje vsebine (feed), kliknite na vsebino spodaj. Za novo vsebino, kliknite na gumb Nova vsebina zgoraj.',
    14 => 'Naslov',
    15 => 'Tip',
    16 => 'Ime datoteke',
    17 => 'Format',
    18 => 'zadnji obnovljen',
    19 => 'Omogočeno',
    20 => 'Da',
    21 => 'Ne',
    22 => '<i>(ni vsebine)</i>',
    23 => 'vsi članki',
    24 => 'Urejevalnik (RDF) vsebine',
    25 => 'naslov vsebine',
    26 => 'Meja',
    27 => 'Dolžine vnosov',
    28 => '(0 = brez dodatnega teksta, 1 = ves tekst, drugo = omeji tekst na to število znakov.)',
    29 => 'Opis',
    30 => 'Zadnjič obnovljeno',
    31 => 'Nabor znakov',
    32 => 'Jezik',
    33 => 'Vsebina',
    34 => 'Vpisi',
    35 => 'Ure',
    36 => 'Izberite tip vsebine',
    37 => 'Nameščen imate vsaj en vtičnik, ki podpira sodelovanje (content syndication). Spodaj morate izbrati ali delate RDF vsebino za Geekloga ali za katerega od vtičnikov.',
    38 => 'Napaka: Manjkajoča polja',
    39 => 'Prosim izpolnite polja Naslov, Opis, Ime datoteke.',
    40 => 'Prosim vpišite število vpisov ali število ur.',
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
    1 => 'Geslo smo vam poslali na vaš e-mail naslov. Elektronsko sporočilo vsebuje tudi vsa ustrezna navodila.',
    2 => 'Za poslani članek se vam najlepše zahvaljujemo. Pred objavo ga bo pregledal eden izmed urednikov. Če bo odobren, bo objavljen na spletni strani.',
    3 => "Za poslano povezavo se vam najlepše zahvaljujemo. Pred objavo jo bo pregledal eden izmed urednikov. Če bo odobrena, bo objavljena na strani <a href={$_CONF['site_url']}/links.php>povezav</a>.",
    4 => "Za poslani dogodek se vam najlepše zahvaljujemo. Pred objavo ga bo pregledal eden izmed urednikov. Če bo odobren, bo objavljen v <a href={$_CONF['site_url']}/calendar.php>koledarju dogodkov</a>.",
    5 => 'Podatki o vašem uporabniškem računu so bili shranjeni.',
    6 => 'Nastavitve so bile uspešno shranjene.',
    7 => 'Vaše nastavitve komentarjev so bile uspešno shranjene.',
    8 => 'Odjava je bila uspešna.',
    9 => 'članek je bil uspešno shranjen.',
    10 => 'članek je bil izbrisan.',
    11 => 'Vaši bloki so bili uspešno shranjeni.',
    12 => 'Blok je bil izbrisan.',
    13 => 'Tematsko področje je bilo uspešno shranjeno.',
    14 => 'Tematsko področje skupaj z vsemi članki v njem z je bilo izbrisano.',
    15 => 'Povezava je bila uspešno shranjena v bazo povezav.',
    16 => 'Povezava je bila izbrisana.',
    17 => 'Dogodek je bil uspešno shranjen v bazo dogodkov.',
    18 => 'Dogodek je bil izbrisan.',
    19 => 'Anketa je bila uspešno shranjena.',
    20 => 'Anketa je bila izbrisana.',
    21 => 'Uporabniške nastavitve so bile uspešno shranjene.',
    22 => 'Uporabnik je bil izbrisan.',
    23 => 'Napaka pri dodajanju dogodka v koledar dogodkov. Vnesite ID dogodka.',
    24 => 'Dogodek je bil uspešno shranjen v vaš koledar dogodkov',
    25 => 'Dostop do osebnega koledarja je mogoč le če ste prijavljeni.',
    26 => 'Dogodek je bil odstranjen iz vašega osebnega koledarja dogodkov',
    27 => 'Sporočilo je bilo poslano.',
    28 => 'Vtičnik je bil uspešno shranjen',
    29 => 'Žal ta stran ne podpira osebnega koledarja.',
    30 => 'Dostop zavrnjen',
    31 => 'Žal nimate dostopa do administracije člankov. Vsi poizkusi nedovoljenega dostopa se beležijo!',
    32 => 'Žal nimate dostopa do administracije tematskih področij. Vsi poizkusi nedovoljenega dostopa se beležijo!',
    33 => 'Žal nimate dostopa do administracije blokov. Vsi poizkusi nedovoljenega dostopa se beležijo!',
    34 => 'Žal nimate dostopa do administracije povezav. Vsi poizkusi nedovoljenega dostopa se beležijo1',
    35 => 'Žal nimate dostopa do administracije dogodkov. Vsi poizkusi nedovoljenega dostopa se beležijo!',
    36 => 'Žal nimate dostopa do administracije anket. Vsi poizkusi nedovoljenega dostopa se beležijo!',
    37 => 'Žal nimate dostopa do administracije uporabnikov. Vsi poizkusi nedovoljenega dostopa se beležijo!',
    38 => 'Žal nimate dostopa do administracije priključnih modulov. Vsi poizkusi nedovoljenega dostopa se beležijo!',
    39 => 'Žal nimate dostopa do administracije elektronske pošte. Vsi poizkusi nedovoljenega dostopa se beležijo!',
    40 => 'Sistemsko sporočilo',
    41 => 'Žal nimaš dostopa do strani za menjavo besed. Vsi poizkusi nedovoljenega dostopa se beležijo!',
    42 => 'Beseda je bila uspešno shranjena.',
    43 => 'Beseda je bila uspešno pobrisana.',
    44 => 'Vtičnik je bil uspešno nameščen!',
    45 => 'Vtičnik je bil odstranjen.',
    46 => 'Žal nimate dostopa do bekapa baze. Vsak poskus nedovoljenega dostopa se beleži',
    47 => 'To deluje samo pod operacijskim sistemom *nix.  Če uporabljaš *nix za svoj operacijski sistem, potem je bil cache uspešno izpraznjen. Če uporabljaš Windows OS, boš moral poiskati datoteke po imenu adodb_*.php in jih pobrisati ročno.',
    48 => "Hvala ker ste se prijavili za članstvo v {$_CONF['site_name']}. Naše osebje vam bo sporočilo odgovor v kratkem. Če boste sprejeti, vam bomo poslali vaše geslo email naslov, ki te ga ravnokar napisali.",
    49 => 'Skupina je bila uspešno shranjena.',
    50 => 'Skupina je bila uspešno izbrisana.',
    51 => 'To uporabniško ime je že zasedeno. Prosim izberi drugo.',
    52 => 'Vpisani email ne izgleda kot pravi email naslov.',
    53 => 'Tvoje novo geslo je sprejeto. Prosim uporabi to novo geslo spodaj za vpis v sistem.',
    54 => 'Tvoja zahteva za novo geslo je potekla. Prosim poizkusi ponovno spodaj.',
    55 => 'Poslal sem Email. Na tvoj naslov bi moral priti takoj. Prosim upoštevaj navodila v tem emailu, za izbiro novega gesla za svoj račun.',
    56 => 'Vpisani email je že uporabljen za enega od računov na naši bazi podatkov.',
    57 => 'Tvoj račun je bil uspešno pobrisan.',
    58 => '(RDF) vsebina je bila uspešno shranjena.',
    59 => '(RDF) vsebina je bila uspešno izbrisana.',
    60 => 'Vtičnik je bil uspešno obnovljen (updated)',
    61 => 'Vtičnik %s: Neznan okvir sporočila (Unknown message placeholder)',
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
    'permmsg' => 'OBVESTILO: uporabniki so vsi prijavljeni člani, anonimni uporabniki in vsi trenutni neprijavljeni obiskovalci strani.',
    'securitygroups' => 'Varnostne skupine',
    'editrootmsg' => "Čeprav ste administrator, ne morete spreminjati nastavitev root uporabnika, če sami niste root uporabnik. Lahko pa urejate nastavitve vseh ostalih uporabnikov. Vsi poizkusi nedovoljenega dostopa se beležijo. Vrnite se na <a href=\"{$_CONF['site_url']}/admin/users.php\">Administratorske strani</a>.",
    'securitygroupsmsg' => 'Izberite skupine, katerim naj pripada uporabnik',
    'groupeditor' => 'Urejanje skupin',
    'description' => 'Opis',
    'name' => 'Ime',
    'rights' => 'Pravice',
    'missingfields' => 'Manjkajoča polja',
    'missingfieldsmsg' => 'Vpišite ime in opis skupine!',
    'groupmanager' => 'Administracija skupin',
    'newgroupmsg' => 'Izberite skupinpo, ki jo želeite odstraniti skupino ali spremeniti njene nastavitve. Če želite oblikovati novo skupino, kliknite na Nova skupina zgoraj! Osnovnih skupin ni mogoče odstraniti!',
    'groupname' => 'Ime skupine',
    'coregroup' => 'Osnovna skupina',
    'yes' => 'Da',
    'no' => 'Ne',
    'corerightsdescr' => "Ta skupina je osnovna skupina {$_CONF['site_name']}. Pravice te skupine ne morejo biti spremenjene. Pravice, ki pripadajo tej skupini so na spodnjem seznamu!",
    'groupmsg' => 'Varnost skupin na tej strnai je urejena hierarhično. Vsaka podskupina ima enake pravice kot njena nadskupina. Zato je priporočljiva uporaba podskupin. Če skupina potrebuje posebne pravice, jih izberite v meniju \'Pravice\'.',
    'coregroupmsg' => "Ta skupina je osnovna skupina strani {$_CONF['site_name']}. Nastavitve skupin, ki ji pripadajo zato ne morejo biti spremenjene. Spodnji seznam vsebuje imena skupin, ki ji pripadajo.",
    'rightsdescr' => 'Pravice, ki jih določite skupini, so avtomatsko dodeljene tudi vsem njenim podskupinam. Pravice lahko dodajate tako, da jih izberete iz spodnjega seznama. Če določena pravica nima \'checkboxa\' pomeni, da ji je ta pravica dodeljena, ker je podskupina neke druge skupine.',
    'lock' => 'Zakleni',
    'members' => 'člani',
    'anonymous' => 'Anonimni uporabnik',
    'permissions' => 'Pravice',
    'permissionskey' => 'R = branje, E = spreminjanje, pravice spreminjanja predpostavljajo pravice branja',
    'edit' => 'Uredi',
    'none' => 'Nihče',
    'accessdenied' => 'Dostop zavrnjen!',
    'storydenialmsg' => "Žal nimate dostopa do tega članka. Morda zato, ker niste registrirani uporabnik {$_CONF['site_name']}? <a href=users.php?mode=New> Registrirajte se!</a> in dobili boste popoln dostop do strani {$_CONF['site_name']}",
    'nogroupsforcoregroup' => 'Ta skupina ne pripada nobeni od preostalih skupin',
    'grouphasnorights' => 'Ta skupina nima nobenih administratorskih pravic.',
    'newgroup' => 'Nova skupina',
    'adminhome' => 'Administratorske strani',
    'save' => 'Shrani',
    'cancel' => 'Prekliči',
    'delete' => 'Izbriši',
    'canteditroot' => 'Poizkusili ste urejati nastavitve glavne skupine. Ker niste član glavne skupine je vaš dostop zavrnjen. Če mislite, da je to napaka, kontatkirajte administratorja sistema.',
    'listusers' => 'Izpiši uporabnike',
    'listthem' => 'Izpis',
    'usersingroup' => 'Uporabniki v skupini %s',
    'usergroupadmin' => 'Administracija skupin uporabnikov',
    'add' => 'Dodaj',
    'remove' => 'Odstrani',
    'availmembers' => 'Uporabniki na voljo',
    'groupmembers' => 'Člani skupine',
    'canteditgroup' => 'Za urejanje te skupine, morate biti njen član. Prosim posvetujte se z administratorjem, če se vam zdi da je to sporočilo napaka.',
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
    'backup_successful' => 'Bravo. Baza podatkov se je uspešno bekapirala ;-).',
    'db_explanation' => 'Če želite narediti backup vašega Geeklog sistema, kliknite gumb spodaj',
    'not_found' => "Napačna pot ali mysqldump utility nima izvrševalnih pravic.<br>Preveri <strong>\$_DB_mysqldump_path</strong> definicijo v config.php.<br>Spremenljivka je trenutno definirana kot: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup neuspešen: Velikost datoteka je bila 0 bytov',
    'path_not_found' => "{$_CONF['backup_path']} ne obstaja ali pa ni direktorij",
    'no_access' => "NAPAKA: Direktorij {$_CONF['backup_path']} ni dosegljiv.",
    'backup_file' => 'Backup datoteka',
    'size' => 'Velikost',
    'bytes' => 'Bytov',
    'total_number' => 'Skupno število bekapov: %d'
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
    9 => 'Išči',
    10 => 'Napredno iskanje',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Napaka 404',
    2 => 'Ups, pogledal sem povsod, ampak ne najdem <b>%s</b>.',
    3 => "<p>Žal mi je, ampak, datoteka ki jo zahtevaš ne obstaja. Prosim preveri <a href=\"{$_CONF['site_url']}\">glavno stran</a> ali <a href=\"{$_CONF['site_url']}/search.php\">iskalno stran</a> in poglej če lahko najdeš kar si izgubil."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Zahtevan je vpis',
    2 => 'Žal, za ogled tega dela strani, moraš biti logiran kot uporabnik.',
    3 => 'Logiraj se',
    4 => 'Nov uporabnik'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'PDF način je onemogočen',
    2 => 'Zahtevani dokument ni bil renderiran. Dokument je bil prejte ampak ga ni bilo možno sprocesirati. Prosim prepričaj se da pošiljaš PDF procesorju samo dokumente v obliki html, ki so bili napisani po xHTML standardu. Upoštevajte da pri pre-kompleksnih dokumentih lahko pride do tega, da se sploh ne sprocesirajo. Dokument ki je nastal na vašo zahtevo je dolg 0 bytov, in je bil izbrisan. Če ste prepričani, da bi se ta dokument moral pravilno izračunati, ga prosimo pošljite ponovno.',
    3 => 'Neznana napaka med izdelavo PDF dokumenta',
    4 => "Dobil nisem nobenih podatkov o strani, ali pa želite uporabiti ad-hoc PDF generator spodaj. Če mislite da ste dobili to stran\n          Po nesreči prosim sporočite to upravniku strani. Če temu ni tako, lahko uporabite spodnjo formo in si ustvarite PDF dokumente na način ad-hoc.",
    5 => 'Nalagam vaš dokument.',
    6 => 'Prosim počakajte, da naložim vaš dokument.',
    7 => 'Spodnji gumb lahko kliknete z desnim miškinim gumbom in izberete \'save target...\' ali \'save link location...\' da shranite kopijo dokumenta.',
    8 => "Pot do HTMLDoc izvršilne datoteke, ki je zapisana v nastavitvah je napačna in sistem je ne more zagnati. Prosimo sporočite ta problem upravniku strani\n          če se ponavlja.",
    9 => 'Izdelovalnik PDF',
    10 => "To je orodje za Ad-hoc izdelavo PDF dokumentov. Orodje bo poizkusilo predelati vse URL naslove v PDF. Prosim zavedaj se, da se nekatere internetne strani NE bodo pravilno renderirale s tem načinom (ad-hoc).  To\n           je omejitev orodja HTMLDoc in teh napak ne rabite prijavljati upravniku strani",
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
    5 => 'četrtek',
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