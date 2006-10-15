<?php

###############################################################################
# estonian_utf-8.php
# This is the estonian language page for GeekLog!
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
#
# Estonian translation by Artur Räpp <rtr AT planet DOT ee>
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
    1 => 'Postitajaks:',
    2 => 'loe lisaks',
    3 => 'kommentaari',
    4 => 'Toimeta',
    5 => 'Hääleta',
    6 => 'Tulemused',
    7 => 'Hääletuse tulemused',
    8 => 'hääletanut',
    9 => 'Admini funktsioonid:',
    10 => 'Sisestused',
    11 => 'Lugu',
    12 => 'Blokid',
    13 => 'Rubriigid',
    14 => 'Lingid',
    15 => 'Sündmused',
    16 => 'Küsitlused',
    17 => 'Kasutajad',
    18 => 'SQL päring',
    19 => 'Logi välja',
    20 => 'Kasutaja info',
    21 => 'Kasutajanimi',
    22 => 'Kasutaja ID',
    23 => 'Turvatase',
    24 => 'Anonüümne',
    25 => 'Vasta',
    26 => 'Järgnevate kommentaaride omanikuks on need, kes iganes need postitas. See leht ei vastuta nende poolt öeldu eest.',
    27 => 'Värskeim postitus',
    28 => 'Kustuta',
    29 => 'Pole kommentaare.',
    30 => 'Vanemad lood',
    31 => 'Lubatud HTML sildid:',
    32 => 'Viga, sobimatu kasutajanimi',
    33 => 'Viga, ei saanud kirjutada logifaili',
    34 => 'Viga',
    35 => 'Logi välja',
    36 => 'Aeg',
    37 => 'Pole kasutaja lugusid',
    38 => 'Sisu jagamine',
    39 => 'Värskenda',
    40 => 'Sul on <tt>php.ini</tt> failis <tt>register_globals = Off</tt>. Kuid Geeklogi jaoks peab olema <tt>register_globals</tt> = <strong>on</strong>. Enne jätkamist sea selle väärtuseks <strong>"on"</strong> ja taaskäivita veebiserver.',
    41 => 'Külaliskasutajaid',
    42 => 'Autoriks:',
    43 => 'Vasta sellele',
    44 => 'Tase kõrgemal',
    45 => 'MySQL vea number',
    46 => 'MySQL veateade',
    47 => 'Lehe kasutajale',
    48 => 'Konto info',
    49 => 'eelistused',
    50 => 'Viga SQL lauses',
    51 => 'abi',
    52 => 'Uus',
    53 => 'Admin avaleht',
    54 => 'Ei saanud avada faili.',
    55 => 'Viga: koht',
    56 => 'Hääleta',
    57 => 'Salasõna',
    58 => 'Logi sisse',
    59 => "Pole veel kontot? Logi sisse <a href=\"{$_CONF['site_url']}/users.php?mode=new\">uue kasutajana</a>",
    60 => 'Postita kommentaar',
    61 => 'Loo uus kasutajakonto',
    62 => 'sõna',
    63 => 'Kommentaaride eelistused',
    64 => 'Saada artikkel sõbrale E-postiga',
    65 => 'Näita printversiooni',
    66 => 'Minu kalender',
    67 => 'Tere siia - ',
    68 => 'Avaleht',
    69 => 'Kontakt',
    70 => 'Otsi',
    71 => 'Lisa lehele lugu',
    72 => 'Veebi kohad',
    73 => 'Vanemad küsitlused',
    74 => 'Kalender',
    75 => 'Otsing', // täpsem otsing
    76 => 'Lehe statistika',
    77 => 'Pluginad',
    78 => 'Tulevased sündmused',
    79 => 'Mida uut',
    80 => 'viimased lood',
    81 => 'viimane lugu',
    82 => 'tundi',
    83 => 'KOMMENTAARE',
    84 => 'LINKE',
    85 => 'viimased 48 t',
    86 => 'Pole uusi kommentaare',
    87 => 'viimased 2 n',
    88 => 'Pole uusi linke',
    89 => 'Pole tulevasi sündmusi',
    90 => 'Avaleht',
    91 => 'Leht valmis',
    92 => 'sekundiga',
    93 => '(C)', // copyright
    94 => 'Kõik sellel lehel olevad kaubamärgid ja autorikaitsega materjalid kuuluvad nende õigustatud omanikele.',
    95 => 'Mootoriks on',
    96 => 'Grupid',
    97 => 'Sõnade loetelu',
    98 => 'Pluginad',
    99 => 'LOOD',
    100 => 'Pole uusi lugusid',
    101 => 'Sinu sündmused',
    102 => 'Sündmused',
    103 => 'DB Backupid',
    104 => '',// by
    105 => 'E-post kasutajatele',
    106 => 'Vaatamisi',
    107 => 'GL versiooni test',
    108 => 'Tühjenda puhvermälu',
    109 => 'Teata kuritahtlikkusest',
    110 => 'Teata sellest postitusest lehe administraatorile',
    111 => 'Vaata PDF versiooni',
    112 => 'Registreeritud kasutajaid',
    113 => 'Dokumentatsioon',
    114 => 'TRACKBACKID',
    115 => 'Pole uusi trackback kommentaare',
    116 => 'Trackback',
    117 => 'Lood ajalises järjekorras',
    118 => 'Palun jätka lugemist järgmisel lehel:',
    119 => "Kaotasid oma <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">salasõna?</a>",
    120 => 'Püsilink sellele kommentaarile',
    121 => 'Kommentaare (%d)',
    122 => 'Trackbacke (%d)',
    123 => 'Kogu HTML on lubatud',
    124 => 'Klõpsa kõigi märgitute kustutamiseks',
    125 => 'Kas oled kindel, et soovid kõiki neid kustutada?',
    126 => 'Märgi/eemalda märge kõigilt'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Postita kommentaar',
    2 => 'Postituse viis',
    3 => 'Logi välja',
    4 => 'Loo konto',
    5 => 'Kasutajanimi',
    6 => 'Sellel lehel peate kommentaaride postitamiseks eelnevalt sisse logima. Kui sul ei ole veel kasutajakontot, võid alloleva vormi abiga endale konto luua.',
    7 => 'Sinu viimane kommentaar oli ',
    8 => " sekundit tagasi.  Sellel lehel  peab kommentaaride vahe olema vähemalt {$_CONF['commentspeedlimit']} sekundit",
    9 => 'kommentaar',
    10 => 'Saada raport',
    11 => 'Saada kommentaar',
    12 => 'Palun täida tiitli ja kommentaari väljad. Need on kommentaari postitamisel kohustuslikud.',
    13 => 'Info sinu kohta',
    14 => 'Eelvaade',
    15 => 'Teata sellest postitusest',
    16 => 'Tiitel',
    17 => 'Viga',
    18 => 'Oluline',
    19 => 'Hoia sõnum vastavuses teemaga.',
    20 => 'Proovi uue teema algatamise asemel pigem vastata teiste postitustele',
    21 => 'Loe enne postitamist teiste poolt öeldut, vältides nii juba öeldu kordamist.',
    22 => 'Kasuta sinu sõnumit selgelt kirjeldavat tiitlit.',
    23 => 'Sinu E-postiaadressi ei tehta avalikuks.',
    24 => 'Anonüümne kasutaja',
    25 => 'Kas oled kindel, et soovid teatada sellest postitusest lehe administraatorile?',
    26 => '%s teatas järgmisest kuritahtlikust postitusest:',
    27 => 'Kuritahtlikkusest teatamine'
);

###############################################################################
# usersettings.php

$LANG04 = array(
    1 => 'Kasutaja profiil, omanik',
    2 => 'Kasutajanimi',
    3 => 'Täisnimi',
    4 => 'Salasõna',
    5 => 'E-postiaadress',
    6 => 'Koduleht',
    7 => 'Bio',
    8 => 'PGP võti',
    9 => 'Salvesta info',
    10 => 'Viimased 10 kommentaari, kommenteerijaks',
    11 => 'Pole kasutaja kommentaare',
    12 => 'Kasutaja eelistused, kasutaja -',
    13 => 'Saada öösiti kokkuvõtted',
    14 => 'See salasõna on genereeritud juhusliku sümbolite kombinatsioonina. On soovitav, et sa vahetad koheselt salasõna. Salasõna muutmiseks logi oma kasutajanime ja salasõna abil sisse ja ava "Lehe kasutajale" alt "Konto info".',
    15 => "Sinu {$_CONF['site_name']} konto on edukalt loodud. Selle kasutamiseks pead sa allpool oleva info abil sisse logima. Palun salvesta see kiri edaspidiseks kasutamiseks.",
    16 => 'Sinu kasutajakonto info',
    17 => 'Kontot ei ole',
    18 => 'Sisestatud E-postiaadress tundub olevat ebakorrektne E-postiaadress',
    19 => 'Kasutajanimi või E-postiaadress on juba olemas',
    20 => 'Sisestatud E-postiaadress tundub olevat ebakorrektne E-postiaadress',
    21 => 'Viga',
    22 => "Registreeri {$_CONF['site_name']} lehel!",
    23 => "Kasutajakonto loomine annab sulle kõik {$_CONF['site_name']} lehe poolt kasutajale pakutavad võimalused. Sa võid postitada oma nimega  kommentaare ja uusi lugusid. Kui sul ei ole kontot, ei saa sa neid postitada. Sinu E-postiaadressi <i><b>ei näidata kunagi</b></i> sellel lehel avalikult.",
    24 => 'Sinu salasõna saadetakse siin sisestatud E-postiaadressil.',
    25 => 'Kas unustasid oma salasõna?',
    26 => 'Sisesta <em>kas</em> oma kasutajanimi <em> või </em> registreerimisel antud E-postiaadress ning klõpsa Saada salasõna. Antud E-postiaadressile saadetakse juhendid, kuidas määrata uus salasõna.',
    27 => 'Registreeri nüüd!',
    28 => 'Saada salasõna',
    29 => 'välja logitud',
    30 => 'logitud sisse lehelt',
    31 => 'Sinu valitud käsk vajab, et oleksid sisse logitud',
    32 => 'Allkiri',
    33 => 'Ei näidata kunagi avalikel lehtedel',
    34 => 'See on sinu tegelik nimi',
    35 => 'Sisesta uus salasõna',
    36 => 'Koos http://',
    37 => 'Rakendatakse sinu kommentaaridele',
    38 => 'See on kõik sinu kohta! Kõik saavad seda lugeda',
    39 => 'Sinu avalik/public PGP võti levitamiseks',
    40 => 'Pole rubriikide ikoone',
    41 => 'Soovid modereerida',
    42 => 'Kuupäeva formaat',
    43 => 'Lugude maksimum',
    44 => 'pole kaste',
    45 => 'Näita eelistusi - kasutaja',
    46 => 'Väljaarvatud asjad - kasutaja',
    47 => 'Uudistekasti häälestus - kasutaja',
    48 => 'Rubriigid',
    49 => 'Lugudes pole ikoone',
    50 => 'Eemalda märge, kui pole huvitatud',
    51 => 'Ainult uudislood',
    52 => 'Vaikimisi on',
    53 => 'Saada igal öösel päeval postitatud lood .',
    54 => 'Märgi (rubriigid/autorid), mida sa ei soovi näha',
    55 => 'Kui sa jätad kõik märkimata, siis rakendatakse süsteemi vaikimisi häälestust. Kui aga alustad märkimist, siis märgi kindlasti kõik soovitud, sest süsteemi vaikeseadistust sinule ei rakendata. Süsteemi vaikevalikud on rasvases kirjas.',
    56 => 'Autorid',
    57 => 'Näitamise viis',
    58 => 'Sorteerimisjärjekord',
    59 => 'Kommentaaride limiit',
    60 => 'Kuidas soovid, et kommentaare näitan?',
    61 => 'Uuemad või vanemad enne',
    62 => 'Vaikimisi on 100',
    63 => "Sinu salasõna saadeti sulle E-postiga ja peaks kohe kohale jõudma. Palun järgi sõnumis olevaid juhendeid. Me täname sind {$_CONF['site_name']} kasutamise eest.",
    64 => 'Kommentaaride eelistused - kasutaja',
    65 => 'Proovi uuesti sisse logida',
    66 => "Võib-olla kirjutasid kasutajatunnuse või salasõna valesti. Palun proovi alloleva vormi abil uuesti. Või oled <a href=\"{$_CONF['site_url']}/users.php?mode=new\">uus kasutaja?</a>",
    67 => 'Liige alates',
    68 => 'Mäleta mind',
    69 => 'Kui kaua peale sisselogimist peaksin sind mäletama?',
    70 => "Kohanda {$_CONF['site_name']} sisu ja välimust",
    71 => "{$_CONF['site_name']} lehe üks headest omadustest on see, et sa võid määrata, millist sisu sulle näidatakse ja sa saad muuta lehe üldist välimust. Selle kasutamiseks pead sa kõigepealt <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registreeruma</a> {$_CONF['site_name']} lehel.   Kui sa oled juba registreerinud, siis logi palun sisse.",
    72 => 'Teema',
    73 => 'Keel',
    74 => 'Saidi välimus',
    75 => 'Rubriigid E-postiga kasutajale',
    76 => 'Kui valid allpool olevast loetelust rubriigi, saadetakse päeva lõpus sulle kõik antud teemas postitatud lood. Vali ainult sind huvitavad teemad!',
    77 => 'Foto',
    78 => 'Lisa pilt endast!',
    79 => 'tee märge selle pilti kustutamiseks', //'Check here to delete this picture',
    80 => 'Logi sisse',
    81 => 'Saada E-kiri',
    82 => 'Viimased 10 lugu, postitajaks',
    83 => 'Postituste statistika, autor',
    84 => 'Artiklite koguarv:',
    85 => 'Kommentaaride koguarv:',
    86 => 'Leia kõik postitused - autoriks',
    87 => 'Sinu kasutajanimi',
    88 => "Keegi, võimalik, et sa ise, tellis {$_CONF['site_name']} lehel aadressiga {$_CONF['site_url']}\n\n asuva kasutajakonto \"%s\" jaoks uue salasõna. Kui sa soovid seda tõesti teha, siis kliki alloleval lingil või ava see leht oma veebilehitsejas:\n\n",
    89 => "Kui sa ei soovi salasõna vahetada, siis ignoreeri seda E-kirja ning salasõna vahetuse tellimus tühistatakse (sinu salasõna jääb muutmata)\n\n",
    90 => 'Sa võid allpool sisestada oma konto jaoks uue salasõna. Pane tähele, et vana salasõna on kehtiv kuni oled selle vormi täitnud ja uus salasõna on serveri poolt kinnitatud.',
    91 => 'Kinnita uus salasõna',
    92 => 'Sisesta uus salasõna',
    93 => 'Sinu viimane uue salasõna tellimine toimus %d sekundit tagasi. Sellel lehel peab aga salasõna tellimiste vahe olema vähemalt %d sekundit.',
    94 => 'Kustuta konto "%s"',
    95 => 'Oma kasutajakonto kustutamiseks klõpsa allpool nupul Kustuta konto. Pane tähele, et koos sellega ei kustutata selle kasutajakonto alt postitatud kommentaare ega jutte. Neid näidatakse edaspidi kui anonüümse kasutaja poolt postitatuid.',
    96 => 'kustuta konto',
    97 => 'Kinnita kasutajakonto kustutamine',
    98 => 'Kas oled kindel, et soovid oma kasutajakonto kustutada? Pärast kustutamist ei saa sa enam sellel lehel kasutajana sisse logida (kuni sa pole uut kasutajakontot loonud). Kui oled kindel, klõpsa uuesti allpool olevat nuppu "Kustuta konto"',
    99 => 'Privaatsusvalikud - kasutaja',
    100 => 'E-kiri administraatorilt',
    101 => 'Luba lehe administraatoritelt E-kirju',
    102 => 'E-kirjad kasutajatelt',
    103 => 'Luba teistelt kasutajatelt E-kirju',
    104 => 'Näita online staatust',
    105 => 'Näita "Kes on online" blokis',
    106 => 'Asukoht',
    107 => 'Näidatakse sinu avalikus profiilis',
    108 => 'Kontrolliks uus salasõna uuesti',
    109 => 'Kirjuta siia uuesti oma uus salasõna',
    110 => 'Praegune salasõna',
    111 => 'Palun sisesta oma praegune salasõna',
    112 => 'Liiga mitu järjestikust ebaõnnestunud sisselogimist. Palun proovi hiljem uuesti.',
    113 => 'Ebaõnnestunud sisselogimine',
    114 => 'Kontole on ligipääs tõkestatud',
    115 => 'Ligipääs sinu kasutajakontole on tõkestatud. Palun kontakteeru administraatoriga.',
    116 => 'Konto ootab aktiveerimist',
    117 => 'Sinu konto ootab hetkel administraatoripoolt aktiveerimist. Sa ei saa enne konto aktiveerimist sisse logida.',
    118 => "Sinu {$_CONF['site_name']} lehe konto on nüüd administraatori poolt aktiveeritud. Sa saad nüüd alloleval aadressil oma kasutajanime <username>) ja eelnevalt saadetud salasõnaga sisse logida.",
    119 => "Kui sa unustasid oma salasõna võid tellida uue salasõna URL-ilt",
    120 => 'Konto on aktiveeritud',
    121 => 'Teenus',
    122 => 'Kahjuks uute kasutajate registreerimine on suletud',
    123 => "Kas sa oled <a href=\"{$_CONF['site_url']}/users.php?mode=new\">uus kasutaja?</a>",
    124 => 'Kinnita E-postiaadress',
    125 => 'Sa pead sisestama sama E-postiaadressi mõlemale väljale!',
    126 => 'Palun korda vigade vältimiseks',
    127 => 'Neist seadistustest ükskõik millise muutmiseks pead sa sisestama oma kehtiva salasõna.',
    128 => 'Sinu nimi',
    129 => 'Salasõna ja E-post',
    130 => 'Sinust',
    131 => 'Päeva kokkuvõttekirjade valikud',
    132 => 'Päeva kokkuvõttekirjade võimalused',
    133 => 'Kommentaaride näitamine',
    134 => 'Kommentaaride valikud',
    135 => '<li>Vaikimisi seatud kommentaaride näitamisviis</li><li>Kommentaaride sorteerimise vaikejärjekord</li><li>Sea kommentaaride maksimumarv, vaikimisi on 100</li>',
    136 => 'Arva välja rubriigid ja autorid',
    137 => 'Filtreeri lugusid',
    138 => 'Mitmesugused valikud',
    139 => 'Välimus ja keel',
    140 => '<li>Pole ikoone, Kui märgitud, ei näidata rubriikide ikoone</li><li>Pole kaste, kui märgitud näidatakse ainult Kasutaja valikuid, rubriike ja administraatoritele administraatori valikuid</li><li>Määra ühel lehel maksimaalselt näidatavate lugude arv</li><li>Määra kasutatav välimuse teema ja kuupäeva formaat</li>',
    141 => 'Privaatsusseadistused',
    142 => 'Vaikimisi on määratud, et kasutajad ja administraatorid võivad saata "lehekaaslastele" E-kirju ja lehel näidatakse kui sa oled online. Eemalda märked, et kaitsta oma privaatsust.',
    143 => 'Filtreeri kaste',
    144 => 'Näita/peida kaste',
    145 => 'Sinu avalik profiil',
    146 => 'Salasõna ja E-post',
    147 => 'Muuda oma salasõna, E-postiaadressi või autologimist. Salasõna ja E-postiaadressi muutmisel pead sa vigade vältimiseks sisestama need topelt.',
    148 => 'Kasutaja info',
    149 => 'Muuda teistele kasutajatele nähtavat kasutajainfot. <li>Allkiri lisatakse sinu kommentaaridele</li><li>Bio on lühike sinu kirjeldus teistele</li><li>Jaga oma PGP võtit</li>',
    150 => 'Märkus: mugavamaks kasutamiseks on soovitav JavaScript.',
    151 => 'Eelvaade',
    152 => 'Kasutajanimi ja salasõna',
    153 => 'Välimus ja keel',
    154 => 'Sisu',
    155 => 'Privaatsus',
    156 => 'Kustuta konto',
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Pole midagi näidata',
    2 => 'Pole midagi näidata. Võimalik, et selles rubriigis pole ühtegi lugu, mida näidata või on sinu kasutajaeelistused liiga kitsendavad, et näidata neid',
    3 => " rubriigis %s",
    4 => 'Tänane peaartikkel',
    5 => 'Järgmine',
    6 => 'Eelmine',
    7 => 'Esimene',
    8 => 'Viimane'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Sinu kirja saatmisel tekkis viga. Palun proovi uuesti.',
    2 => 'Sõnum on edukalt saadetud.',
    3 => 'Palun veendu, et saatja E-postiaadressiks oleks toimiv E-postiaadress.',
    4 => 'Palun täida "Sinu nimi", "Sinu E-postiaadress", "Teema" ja sõnumi väljad.',
    5 => 'Viga: pole sellist kasutajat.',
    6 => 'Oli viga..',
    7 => 'Kasutajaprofiil, omanik ',
    8 => 'Kasutaja nimi',
    9 => 'Kasutaja URL',
    10 => 'Saada E-post, kirja saajaks',
    11 => 'Sinu nimi:',
    12 => 'Sinu E-postiaadress:',
    13 => 'Teema:',
    14 => 'Sõnum:',
    15 => 'HTML-i ei transleerita .',
    16 => 'Valmis',
    17 => 'Saada lugu sõbrale',
    18 => 'Saaja nimi',
    19 => 'E-postiaadress',
    20 => 'Saatja nimi',
    21 => 'Saatja E-postiaadress',
    22 => 'Kõik väljad on kohustuslikud',
    23 => "See E-kiri saadeti sulle %s %s poolt, sest ta arvas, et sa oled huvitatud artiklist {$_CONF['site_url']} lehel.  See ei ole rämpskiri. Antud kirjaga seotud E-postiaadresseid ei säilitata hilisemaks kasutamiseks!",
    24 => 'Kommenteeri seda lugu aadressil',
    25 => 'Selle võimaluse kasutamiseks pead sa lehele sisse logima. See nõue aitab meil kaitsta lehte väärkasutuste eest.',
    26 => 'Selle vormi abil saad saata E-kirja valitud inimesele. Kõik väljad on kohustuslikud.',
    27 => 'Lühike sõnum',
    28 => "%s kirjutas: ",
    29 => "See on päevane kokkuvõte {$_CONF['site_name']} lehelt kasutajale.",
    30 => 'Igapäevane uudiskiri kasutajale  ',
    31 => 'Tiitel',
    32 => 'Päev',
    33 => 'Loe kogu artiklit aadressil',
    34 => 'Sõnumi lõpp',
    35 => 'Kahjuks see kasutaja ei soovi kirju saada.',
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Otsing', // täpsem otsing
    2 => 'Märksõnad',
    3 => 'Rubriik',
    4 => 'Kõik',
    5 => 'Tüüp',
    6 => 'Lood',
    7 => 'Kommentaarid',
    8 => 'Autorid',
    9 => 'Kõik',
    10 => 'Otsi',
    11 => 'Otsingu tulemused',
    12 => 'Sobivaid',
    13 => 'Otsingu tulemused: ei leitud sobivaid',
    14 => 'Ei leitud sobivat otsitavale',
    15 => 'Palun proovi uuesti.',
    16 => 'Tiitel',
    17 => 'päev',
    18 => 'Postitaja',
    19 => "Otsi kõigist {$_CONF['site_name']} praegustest ja eelmistest lugudest",
    20 => 'kuupäev',
    21 => 'kuni',
    22 => '(kuupäeva formaat AAAA-KK-PP)',
    23 => 'Vaatamisi',
    24 => 'Leidsin %d sobivat',
    25 => 'Otsiti',
    26 => 'asja ',
    27 => 'sekundit',
    28 => 'Ükski lugu ega kommentaar ei sobinud otsitavaga',
    29 => 'Lugude ja kommentaaride tulemus',
    30 => 'Ükski link ei sobinud otsitavaga',
    31 => 'See plugin ei leidnud sobivaid',
    32 => 'Sündmus',
    33 => 'URL',
    34 => 'Asukoht',
    35 => 'Kogu päev',
    36 => 'Ükski sündmus ei sobinud otsinguga',
    37 => 'Sündmuste tulemus',
    38 => 'Linkide tulemus',
    39 => 'Linke',
    40 => 'Sündmused',
    41 => 'Otsitav peab olema vähemalt 3 märki pikk',
    42 => 'Palun kasuta kuupäeva kujul AAAA-KK-PP(aasta-kuu-päev)',
    43 => 'täpne fraas',
    44 => 'Kõik need sõnad',
    45 => 'vähemalt üks neist sõnadest',
    46 => 'Järgmine',
    47 => 'Eelmine',
    48 => 'Autor',
    49 => 'Päev',
    50 => 'Klikke',
    51 => 'Link',
    52 => 'Asukoht',
    53 => 'Lugude tulemus',
    54 => 'Kommentaaride tulemus',
    55 => 'fraasi',
    56 => 'JA',
    57 => 'VÕI',
    58 => 'Rohkem tulemusi &gt;&gt;',
    59 => 'Tulemused',
    60 => 'lehel',
    61 => ' täpsusta otsingut'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Lehe statistika',
    2 => 'Klikkide koguarv lehtedel',
    3 => 'Lugusid (kommentaare lehtedel',
    4 => 'Küsitlusi (vastuseid)',
    5 => 'Linke (klikke)',
    6 => 'Sündmusi',
    7 => '10 enim vaadatud lugu',
    8 => 'Loo tiitel',
    9 => 'Vaatamisi',
    10 => 'Näib, et saidil pole ühtegi lugu või mitte keegi pole neid vaadanud.',
    11 => '10 enim kommenteeritud lugu',
    12 => 'Kommentaare',
    13 => 'Näib, et saidil pole ühtegi lugu või mitte keegi pole neile postitanud ühtegi kommentaari.',
    14 => 'Top 10 küsitlust',
    15 => 'Küsitluse küsimus',
    16 => 'Hääli',
    17 => 'Näib, et saidil pole ühtegi küsitlust või mitte keegi pole neil hääletanud.',
    18 => 'Top 10 linki',
    19 => 'Linke',
    20 => 'Klikke',
    21 => 'Näib, et saidil pole ühtegi linki või mitte keegi pole ühelgi neist klõpsanud.',
    22 => 'Top 10 E-postiga saadetud lugu',
    23 => 'E-kirju',
    24 => 'Näib, et mitte keegi pole saidil saatnud ühtegi lugu E-postiga.',
    25 => 'Top 10 trackback abil kommenteeritud lugu',
    26 => 'Ei leidnud trackback kommentaare.',
    27 => 'Aktiivseid kasutajaid',
    28 => 'Top 10 sündmust',
    29 => 'Sündmus',
    30 => 'Klikke',
    31 => ''
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Seotud',
    2 => 'Saada lugu sõbrale',
    3 => 'Lugu prinditaval kujul',
    4 => 'Loo valikud',
    5 => 'PDF lugude formaat'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "Selleks et lisada %s pead sa kasutajana sisse logima.",
    2 => 'Logi sisse',
    3 => 'Uus kasutaja',
    4 => 'Lisa sündmus',
    5 => 'Lisa link',
    6 => 'Lisa lugu',
    7 => 'Nõutav on sisselogimine',
    8 => 'Sisesta',
    9 => 'Kui lisad meie saidile uut infot, palume järgida järgmisi soovitusi ...<ul><li>Täida kõik väljad, mis on kohustuslikud</li><li>Anna täielik ja täpne info</li><li>Kontrolli hoolikalt kirjutatud URL-id (veebiaadressid)</li></ul>',
    10 => 'Tiitel',
    11 => 'Link',
    12 => 'Alguskuupäev',
    13 => 'Lõpukuupäev',
    14 => 'Asukoht',
    15 => 'Kirjeldus',
    16 => 'Kui "Muu", siis täpsusta',
    17 => 'Kategooria',
    18 => 'Muu',
    19 => 'Loe enne',
    20 => 'Viga: kategooria on puudu',
    21 => 'Kui valisid Muu, sisesta palun ka kategooria nimi.',
    22 => 'Viga: puuduvad väljad',
    23 => 'Palun täida kõik vormi väljad. Kõik väljad on kohustuslikud.',
    24 => 'Sisestus on salvestatud',
    25 => "Sinu sisestatud %s on edukalt salvestatud.",
    26 => 'Kiiruse piirang',
    27 => 'Kasutajanimi',
    28 => 'Rubriik',
    29 => 'Lugu',
    30 => 'Sinu viimane postitus oli',
    31 => " sekundit tagasi.  Sellel lehel   peab sisestuste vahe olema vähemalt {$_CONF['speedlimit']} sekundit.",
    32 => 'Eelvaade',
    33 => 'Loo eelvaade',
    34 => 'Logi välja',
    35 => 'HTML sildid pole lubatud',
    36 => 'Postituse tüüp',
    37 => "Lisades {$_CONF['site_name']} lehele sündmuse, paigutub see peakalendrisse, kust kasutajad saavad soovi korral lisada selle oma enda isiklikku kalendrisse. Lehe kalender <b>ei ole </b> mõeldud teieisiklike sündmuste, nagu sünnipäevade või tähtpäevade jaoks.<br><br>Sündmuse lisamisel saadetakse see meie administraatoritele. Pärast administraatorite poolset kinnitamist ilmub lisatud sündmus peakalendrisse.",
    38 => 'Lisa sündmus',
    39 => 'peakalender',
    40 => 'Isiklik kalender',
    41 => 'lõpuaeg',
    42 => 'algusaeg',
    43 => 'Kogu päev',
    44 => 'aadressrida 1',
    45 => 'aadressrida 2',
    46 => 'linn',
    47 => 'Piirkond',
    48 => 'postiindeks',
    49 => 'Sündmuse tüüp',
    50 => 'Toimeta sündmuste tüüpe',
    51 => 'Asukoht',
    52 => 'Kustuta',
    53 => 'Loo konto'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Nõutav on autoriseerimine',
    2 => 'Tõkestatud! Ebakorrektne info logimisel',
    3 => 'vigane salasõna, kasutajanimi',
    4 => 'Kasutajanimi:',
    5 => 'Salasõna:',
    6 => 'Kõik katsed pääseda ligi selle lehe administreerimisosadele logitakse ja vaadatakse läbi. <br> See leht on mõeldud ainult autoriseeritud kasutajatele.',
    7 => 'logi sisse'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Ebapiisavalt administreerimisõiguseid',
    2 => 'Sul ei ole piisavalt õigusi selle bloki toimetamiseks.',
    3 => 'Bloki toimetaja',
    4 => 'Tekkis probleem selle lõime lugemisel. Täpsemalt loe error.log failist.',
    5 => 'Bloki tiitel',
    6 => 'rubriik',
    7 => 'Kõik',
    8 => 'Bloki turvatase',
    9 => 'Bloki järjekord',
    10 => 'Bloki tüüp',
    11 => 'Portaalblokk',
    12 => 'Normaalblokk',
    13 => 'Portaalbloki valikud',
    14 => 'RSS URL',
    15 => 'Viimane RSS uuendus',
    16 => 'Normaalbloki valikud',
    17 => 'Bloki sisu',
    18 => 'Palun täida bloki tiitli ja sisu väljad',
    19 => 'Bloki haldur',
    20 => 'Bloki tiitel',
    21 => 'Bloki turva..',
    22 => 'Bloki tüüp',
    23 => 'Bloki järjekord',
    24 => 'Bloki rubriik',
    25 => 'Bloki toimetamiseks või kustutamiseks klõpsa allpool selle tiitlil. Uue bloki loomiseks klõpsa Tee uus ülal.',
    26 => 'Kujundusblokk',
    27 => 'PHP blokk',
    28 => 'PHP bloki valikud',
    29 => 'Bloki funktsioon',
    30 => 'Kui sa soovid oma blokis kasutada PHP käske, sisesta allolevasse kasti PHP funktsiooni nimi. See peab algama eesliitega "phpblock_" (n. phpblock_getweather). Ilma selle eesliiteta funktsiooni ei käivitata. Me oleme lisanud selle kitsenduse kaitsmaks sinu saiti juhuks, kui keegi on sellele sisse häkkinud ja lisanud lehe koodi kontrollimata käske. Jälgi, et sa ei lisaks funktsiooni nime lõppu sulge "()". On soovitav panna oma PHP blokkide jaoks mõeldud funktsioonid faili /path/to/geeklog/system/lib-custom.php. See lubab säilitada lisatud PHP blockide funktsioonid ka Geeklogi uuendamisel.',
    31 => 'Viga PHP blokis.  Funktsiooni %s pole olemas.',
    32 => 'Viga: puuduvad väljad',
    33 => 'Sa pead portaalbloki jaoks sisestama RSS faili URL-i.',
    34 => 'Sa pead sisestama PHP bloki tiitli ja funktsiooni',
    35 => 'Sa pead normaalbloki jaoks sisestama tiitli ja sisu',
    36 => 'Sa pead kujundusblokkide jaoks sisestama bloki sisu',
    37 => 'Sobimatu PHP bloki funktsiooni nimi',
    38 => 'PHP blokkide jaoks mõeldud funktsioonid peavad algama \'phpblock_\' (n. phpblock_getweather).  \'phpblock_\' algus on kasutuses turvakaalutlustel, takistamaks kontrollimata koodi käivitamist',
    39 => 'Külg',
    40 => 'Vasak',
    41 => 'Parem',
    42 => 'Sa pead Geeklogi vaikeblokkide jaoks sisestama bloki tiitli ja järjekorra.',
    43 => 'Ainult avaleht',
    44 => 'Ligipääs tõkestatud',
    45 => "Sa üritasid ligi pääseda blokile, milleks polnud sul õigust. See katse logiti. Palun <a href=\"{$_CONF['site_admin_url']}/block.php\">mine tagasi blokkide administreerimislehele. </a>",
    46 => 'Uus blokk',
    47 => 'Admin avaleht',
    48 => 'Bloki nimi',
    49 => ' (ilma tühikuteta ja erinev teistest)',
    50 => 'Abifaili URL',
    51 => 'koos http://',
    52 => 'Kui sa jätad selle välja tühjaks, siis selle bloki jaoks ei näidata abiikooni.',
    53 => 'kasutuses',
    54 => 'salvesta',
    55 => 'tühista',
    56 => 'kustuta',
    57 => 'vii allapoole',
    58 => 'Vii ülespoole',
    59 => 'Vii blokk paremale',
    60 => 'Vii blokk vasakule',
    61 => 'Pole tiitlit',
    62 => 'Artikli limiit',
    63 => 'Sobimatu bloki tiitel',
    64 => 'Tiitel peab olema ja ei tohi sisaldada HTML-i!',
    65 => 'Järjekord',
    66 => 'Autosildid',
    67 => 'Autosiltide lubamiseks tee märge',
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Eelmised lood',
    2 => 'Järgmised lood',
    3 => 'laad',
    4 => 'Postituse viis',
    5 => 'Lugude toimetaja',
    6 => 'Süsteemis pole lugusid',
    7 => 'Autor',
    8 => 'Salvesta',
    9 => 'eelvaade',
    10 => 'tühista',
    11 => 'kustuta',
    12 => 'ID',
    13 => 'Tiitel',
    14 => 'Rubriik',
    15 => 'Päev',
    16 => 'Tutvustustekst',
    17 => 'Sisutekst',
    18 => 'Klikke',
    19 => 'Kommentaare',
    20 => '',
    21 => '',
    22 => 'Lugude nimekiri',
    23 => 'Loo toimetamiseks või kustutamiseks klõpsa allpool loo numbril. Loo vaatamiseks klõpsa selle tiitlil. Uue loo tegemiseks klõpsa Tee uus ülal.',
    24 => 'Loo jaoks valitud ID on juba kasutuses. Palun vali loo jaoks teine ID.',
    25 => '',
    26 => 'Loo eelvaade',
    27 => '',
    28 => '',
    29 => '',
    30 => 'Faili üleslaadimise vead',
    31 => 'Palun täida loo tiitli ja tutvustusteksti väljad',
    32 => 'Pealugu',
    33 => 'Korraga saab olla vaid üks pealugu',
    34 => 'Mustand',
    35 => 'Ja',
    36 => 'Ei',
    37 => 'Rohkem postitajalt',
    38 => 'Rohkem rubriigis',
    39 => 'E-kirju',
    40 => 'Ligipääs tõkestatud',
    41 => "Sa proovisid ligi pääseda loole, millele pole sul õigust. See katse on logitud. Sa võid vaadata seda artiklit allpool ainult loetaval kujul. Palun <a href=\"{$_CONF['site_admin_url']}/story.php\">mine pärast lugemist tagasi lugude administreerimislehele. </a>",
    42 => "Sa proovisid ligi pääseda loole, millele pole sul õigust. See katse on logitud. Palun <a href=\"{$_CONF['site_admin_url']}/story.php\">mine tagasi lugude administreerimislehele. </a>",
    43 => 'Uus lugu',
    44 => 'Admin avaleht',
    45 => 'Ligipääs',
    46 => '<b>MÄRKUS:</b> Kui sa määrad selle kuupäeva tulevikku, siis seda artiklit ei avaldata enne seda päeva. See tähendab ka seda, et seda artiklit ei lisata varem sinu RSS voogu ja seda ignoreeritakse otsingu ja statistika lehtede poolt.',
    47 => 'Pildid',
    48 => 'pilt',
    49 => 'parem',
    50 => 'vasak',
    51 => 'Loosse lisatud piltide lehel nähtavaks tegemiseks pead sa teksti kirjutama spetsiaalsed tähistused. Need tähistused on kujul: [imageX], [imageX_right] või [imageX_left], kus tähe X asemele tuleb panna lisatava pildi järjenumber. Märkus: sa pead iga lisatud pildi jaoks kirjutama vastava tähistuse. Kui sa ei määra laetud piltidele asukohta, ei saa sa lugu salvestada. <p><b>Eelvaade</b>: Piltidega loo puhul on Eelvaate nupul klõpsamise asemel parem lugu salvestada mustandina. Kasuta eelvaate nuppu vaid siis, kui loos pole pilte.',
    52 => 'Kustuta',
    53 => 'pole kasutuses. Sa pead enne muudatuste salvestamist lisama selle pildi kas tutvustusteksti või sisu teksti.',
    54 => 'Lisatud pildid pole kasutuses',
    55 => 'Loo salvestamisel tekkisid järgmised vead. Palun paranda need enne loo salvestamist',
    56 => 'Näita rubriigi ikooni',
    57 => 'Vaata originaalsuuruses pilti',
    58 => 'Lugude haldamine',
    59 => 'Valik',
    60 => 'Kasutuses',
    61 => 'Autoarhiiv',
    62 => 'Autokustuta',
    63 => '',
    64 => '',
    65 => '',
    66 => '',
    67 => 'Laienda sisu toimetamise ala suurust',
    68 => 'Vähenda sisu toimetamise ala suurust',
    69 => 'Publish Story Date', // tõlkimata
    70 => 'Tööriistariba valik',
    71 => 'Lihtne tööriistariba',
    72 => 'Harilik tööriistariba',
    73 => 'Suur tööriistariba',
    74 => 'Suur II tööriistariba',
    75 => 'Täis põhilugu',
    76 => 'Avaldamise valikud',
    77 => 'Keerukama toimetaja jaoks peab lubatud olema JavaScript. Valiku saab välja lülitada saidi pea config.php failis.',
    78 => '<a href="%s/story.php?mode=edit&sid=%s&editopt=default">vaiketoimetaja kasutamiseks klõpsa siia</a>',
    79 => 'Eelvaade',
    80 => 'Toimetaja',
    81 => 'Avaldamise valikud',
    82 => 'Pildid',
    83 => 'Arhiveerimisvalikud',
    84 => 'Õigused', // permissions
    85 => 'Näita kõik',
    86 => 'Keerukam toimetaja',
    87 => 'Lugude statistika'
);


###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Rubriikide toimetaja',
    2 => 'Rubriigi ID',
    3 => 'Rubriigi nimi',
    4 => 'Rubriigi pilt',
    5 => '(ära kasuta tühikuid)',
    6 => 'Kustutades rubriigi, kustutatakse ka kõik sellega seotud lood ja blokid.',
    7 => 'Palun täida rubriigi ID ja kirjelduse väljad',
    8 => 'Rubriikide haldaja',
    9 => 'Rubriigi toimetamiseks või kustutamiseks klõpsa selle nimel. Uue rubriigi lisamiseks klõpsa Tee uus ülal. Sa näed iga rubriigi kõrval sulgudes antud rubriigi jaoks oma ligipääsuõiguseid. Tärn (*) märgib vaikimisi valitud rubriiki.',
    10 => 'Sorteerimise järjekord',
    11 => 'Lugusid lehel',
    12 => 'Ligipääs tõkestatud',
    13 => "Sa proovisid pääseda ligi rubriigile, milleks polnud sul õigust. See ligipääsukatse on logitud. Palun <a href=\"{$_CONF['site_admin_url']}/topic.php\">mine tagasi rubriikide administreerimislehele. </a>",
    14 => 'Sorteerimismeetod',
    15 => 'tähestikuline',
    16 => 'vaikimisi',
    17 => 'Uus rubriik',
    18 => 'Admin avaleht',
    19 => 'salvesta',
    20 => 'tühista',
    21 => 'kustuta',
    22 => 'Vaikimisi',
    23 => 'Määra see uute lugude jaoks vaikerubriigiks',
    24 => '(*)',
    25 => 'Arhiivi rubriik',
    26 => 'määra see rubriik arhiveeritud lugude  jaoks vaikerubriigiks. Ainult üks rubriik on lubatud.',
    27 => 'või lae rubriigi ikoon',
    28 => 'Maksimum',
    29 => 'Vead faili üleslaadimisel'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Kasutajate toimetaja',
    2 => 'Kasutaja ID',
    3 => 'kasutaja nimi',
    4 => 'Täisnimi',
    5 => 'Salasõna',
    6 => 'Turvatase',
    7 => 'E-postiaadress',
    8 => 'Koduleht',
    9 => '(ära kasuta tühikuid)',
    10 => 'Palun täida kasutajanime ja E-postiaadressi väljad',
    11 => 'Kasutajate haldur',
    12 => 'Kasutaja andmete toimetamiseks või konto kustutamiseks klõpsa allpool soovitud kasutajal. Uue kasutajakonto loomiseks klõpsa ülal Tee uus. Võid teha kasutajate lihtotsingut sisestades otsingukasti osa nende kasutajanimest, E-postiaadressist või täisnimest (näiteks: mart* või *.com).',
    13 => 'Turva..',
    14 => 'Reg. aeg',
    15 => 'Uus kasutaja',
    16 => 'Admin avaleht',
    17 => 'muuda',
    18 => 'tühista',
    19 => 'kustuta',
    20 => 'salvesta',
    21 => 'See kasutajanimi on juba olemas',
    22 => 'Viga',
    23 => 'Masslisamine',
    24 => 'Mass kasutajate importimine',
    25 => 'Sa võid Geeklogi importida korraga mitu kasutajat. Imporditavas tekstifailis peab väljade eraldajaks olema tabulaator ja selles peavad väljad olema järgmises järjekorras: täisnimi, kasutajanimi, E-postiaadress. Igale imporditud kasutajale saadetakse E-postiga salasõnageneraatoriga genereeritud juhuslik salasõna. Ühel real tohib olla vaid täpselt üks kasutaja. Selle reegli rikkumine toob kaasa probleeme, mille kõrvaldamine nõuab lehe käsitsi häälestamist, nii et kontrolli hoolikalt ja mitu korda imporditava faili sissekandeid!',
    26 => 'Otsi',
     27 => 'Piira tulemused',
    28 => 'Pildi kustutamiseks märgi see',
    29 => 'tee',
    30 => 'Import',
    31 => 'Uued kasutajad',
    32 => 'Töötlus lõpetatud. Imporditi %d ja oli %d tõrget',
    33 => 'sisesta',
    34 => 'Viga: pead määrama laetava faili.',
    35 => 'Viimati logitud',
    36 => '(pole)',
    37 => 'UID',
    38 => 'Gruppide nimekiri',
    39 => 'salasõna (uuesti)',
    40 => 'Registreerimise aeg',
    41 => 'Viimane logimisaeg',
    42 => 'Blokeeritud',
    43 => 'Ootab aktiveerimist',
    44 => 'Ootab autoriseerimist',
    45 => 'Aktiivne',
    46 => 'Kasutaja staatus',
    47 => 'Toimeta',
    48 => 'Näita administreerimisgruppe',
    49 => 'Administreerimisgrupp',
    50 => 'Märgi, et seda gruppi filtreeritaks administreerimisgrupina',
    51 => 'Online päevad',
    52 => '<br>Märkus: Online päevad on päevade arv  registreerimisest viimase sisselogimiseni.',
    53 => 'registreeritud',
    54 => 'Masskustutamine',
    55 => "See töötab vaid siis kui sul on config.php failis <code>\$_CONF['lastlogin'] = true;</code>",
    56 => 'Palun vali kasutajate rühm, mida soovid kustutada ja klõpsa seejärel "Uuenda loetelu". Avanenud lehel  eemalda märge nende kasutajate eest, keda sa ei soovi kustutada ning vajuta "Kustuta". Pane tähele, et kui kasutajate loetelu on jaotatud mitmele lehele, kustutad sa ainult neid kasutajaid, mis on nähtavad antud lehel.',
    57 => 'Fantoomkasutajad',
    58 => 'Lühiaegsed kasutajad',
    59 => 'Vanad kasutajad',
    60 => 'Kasutajad, kes on registreerunud rohkem kui',
    61 => ' kuud tagasi kuid pole kunagi sisse loginud.',
    62 => 'Kasutajad, kes on registreerunud rohkem kui ',
    63 => ' kuud tagasi, seejärel loginud sisse 24 tunni jooksul kuid pole pärast seda enam kordagi sinu lehele naasnud.',
    64 => 'Tavalised kasutajad, kes lihtsalt pole sinu lehele tulnud juba ',
    65 => ' kuud.',
    66 => 'Uuenda loetelu',
    67 => 'Kuud registreerimisest',
    68 => 'Online tunde',
    69 => 'Offline kuud',
    70 => 'Ei kustutatud',
    71 => 'Edukalt kustutatud',
    72 => 'Kustutamiseks pole ühtegi kasutajat valitud',
    73 => 'Kas sa oled kindel, et soovid lõplikult kustutada kõik valitud kasutajad?',
    74 => 'Viimased registreerijad',
    75 => 'Kasutajad, kes on viimati registreerunud ',
    76 => ' kuud'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Kinnita',
    2 => 'Kustuta',
    3 => 'Toimeta',
    4 => 'Profiil',
    10 => 'Tiitel',
    11 => 'Alguspäev',
    12 => 'URL',
    13 => 'Kategooria',
    14 => 'Päev',
    15 => 'Rubriik',
    16 => 'Kasutajanimi',
    17 => 'Täisnimi',
    18 => 'E-post',
    34 => 'Kontrolli ja otsusta',
    35 => 'Sisestatud lood',
    36 => 'Sisestatud lingid',
    37 => 'Sisestatud sündmused',
    38 => 'Sisesta',
    39 => 'Hetkel pole ülevaatamist (modereerimist) vajavaid sisestusi.',
    40 => 'Kasutajate sisestused'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} E-posti tööriist",
    2 => 'Kellelt',
    3 => 'Vasta',
    4 => 'Teema',
    5 => 'Sisu',
    6 => 'Saada :',
    7 => 'Kõik kasutajad',
    8 => 'Administraator',
    9 => 'Valikud',
    10 => 'HTML',
    11 => 'Oluline teade!',
    12 => 'Saada',
    13 => 'Puhasta',
    14 => 'Ignoreeri kasutaja seadistusi',
    15 => 'Viga saatmisel: ',
    16 => 'Edukalt saadetud: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Saada järgmine kiri</a>",
    18 => 'Kellele',
    19 => 'Kui soovid saata kirja kõigile registreeritud kasutajatele, vali valikukastist Logged-in kasutajagrupp.',
    20 => "Edukalt saadetud <successcount> sõnumit ja ebaõnnestus saata <failcount> sõnumit.  Kui sa vajad iga sõnumi kohta detailset infot, siis leiad selle info allpool. Kuid sa võid <a href=\"{$_CONF['site_admin_url']}/mail.php\">saata järgmise sõnumi</a> või võid <a href=\"{$_CONF['site_admin_url']}/moderation.php\">mine tagasi administreerimislehele. </a>",
    21 => 'Tõrked',
    22 => 'Edukalt',
    23 => 'Polnud tõrkeid',
    24 => 'Polnud õnnestunuid',
    25 => '-- Vali grupp --',
    26 => 'Palun täida kõik väljad ja vali valikukastist kasutajate grupp.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Pluginate installeerimine võib kahjustada sinu Geeklogi installatsiooni ja lisaks kahjustada ka sinu süsteemi. On oluline, et sa installeeriksid vaid <a href="http://www.geeklog.net">Geeklogi kodulehelt</a> laetud pluginaid, sest me kontrollime hoolikalt meie lehele laetud pluginaid erinevates operatsioonisüsteemides. On oluline mõista, et plugina installeerimine nõuab mitmete süsteemikäskude kasutamist, mis võib kaasa tuua turvalisusprobleeme, eriti siis, kui sa kasutad kolmandatelt lehtedelt laetud pluginaid. Sellest hoiatusest hoolimata ei taga me plugina installeerimise edukust ega vastuta selle installeerimise tagajärjena põhjustatud kahju eest. Teiste sõnadega - installeeri oma vastutusel. Lisaks on iga plugina paketi juures juhend, kuidas installeerida plugin käsitsi.',
    2 => 'Plug-in Installation Disclaimer', // tõlkida
    3 => 'Plugina installeerimisvorm',
    4 => 'Plugina fail',
    5 => 'Pluginate loetelu',
    6 => 'Hoiatus, plugin on juba installeeritud!',
    7 => 'Plugin, mida sa soovid installeerida, on juba installeeritud. Palun kustuta see plugin enne taasinstalleerimist.',
    8 => 'Plugina sobivuse kontroll  ebaõnnestus',
    9 => 'See plugin vajab uuemat Geeklogi versiooni. Kas uuenda <a href="http://www.geeklog.net">Geeklog</a> või hangi plugina sobiv versioon.',
    10 => '<br><b>Hetkel pole installeeritud ühtegi pluginat.</b><br><br>',
    11 => 'Plugina muutmiseks või kustutamiseks klõpsa allpool selle nimel. Sulle näidatakse plugina kohta täpsemat infot koos autori veebilehe aadressiga. Näidatakse nii installeeritud versiooni numbrit kui ka plugina koodist saadud plugina versioon. Selle põhjal saad otsustada, kas plugin vajab uuendamist või mitte. Plugina installeerimise või uuendamise kohta loe täpsemalt plugina dokumentatsioonist.',
    12 => 'plugineditor () ei saanud plugina nime',
    13 => 'Plugina toimetaja',
    14 => 'Uus plugin',
    15 => 'Admin avaleht',
    16 => 'Plugina nimi',
    17 => 'Plugina versioon',
    18 => 'Geeklogi versioon',
    19 => 'Kasutuses',
    20 => 'Ja',
    21 => 'Ei',
    22 => 'Installeeri',
    23 => 'Salvesta',
    24 => 'Tühista',
    25 => 'Kustuta',
    26 => 'Plugina nimi',
    27 => 'Plugina koduleht',
    28 => 'Installeeritud versioonid',
    29 => 'Geeklogi versioon',
    30 => 'Kustuta plugin?',
    31 => 'Kas sa oled kindel, et soovid  kustutada  selle plugina?  Jätkates kustutad sa ka kõik selle pluginaga seotud andmed ja andmestruktuurid. Kui sa oled kindel, siis klõpsa uuesti allpool "kustuta" nuppu.',
    32 => '<p><b>Viga: AutoLink silt on ebakorrektse formaadiga</b></p>',
    33 => 'Koodi versioon',
    34 => 'Uuenda',
    35 => 'Toimeta',
    36 => 'Kood',
    37 => 'andmed', // data
    38 => 'Uuenda!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'loo lõim',
    2 => 'salvesta',
    3 => 'kustuta',
    4 => 'tühista',
    10 => 'Sisu jagamine',
    11 => 'Uus lõim',
    12 => 'Admin avaleht',
    13 => 'Lõime toimetamiseks või kustutamiseks klõpsa allpool selle nimel. Uue lõime loomiseks klõpsa Tee uus ülalpool.',
    14 => 'Tiitel',
    15 => 'Tüüp',
    16 => 'Faili nimi',
    17 => 'Formaat',
    18 => 'viimati uuendatud',
    19 => 'Kasutuses',
    20 => 'Ja',
    21 => 'Ei',
    22 => '<i>(pole lõimi)</i>',
    23 => 'kõik lood',
    24 => 'Lõime toimetaja',
    25 => 'Lõime tiitel',
    26 => 'Limiit',
    27 => 'Kannete pikkus',
    28 => '(0 = pole  teksti, 1 = täistekst, muu = piira antud märkide arvuni.)',
    29 => 'Kirjeldus',
    30 => 'Viimane uuendus',
    31 => 'kooditabel',
    32 => 'Keel',
    33 => 'Sisu',
    34 => 'Kanded',
    35 => 'tundi',
    36 => 'Vali lõime tüüp',
    37 => 'Sa oled installeerinud vähemalt ühe plugina, mis toetab sisu jaotamist. Allpool pead sa valima, kas lood Geeklogi lõime või mõne plugina poolt toetatud lõime.',
    38 => 'Viga: puuduvad väljad',
    39 => 'Palun täida lõime tiitli, kirjelduse ja faili nime väljad.',
    40 => 'Palun sisesta lugude  või tundide arv.',
    41 => 'Sisesta',
    42 => 'Sündmused',
    43 => 'Igas rubriigis.',
    44 => 'Mitte üheski.',
    45 => 'Rubriigi lehepäises on link?',
    46 => 'Piira tulemused',
    47 => 'Otsi',
    48 => 'Toimeta',
    49 => 'Lõime logo',
    50 => "Suhteline saidi urli suhtes ({$_CONF['site_url']})",
    51 => 'Sinu valitud lõimefailinimi on juba teise lõime poolt kasutuses. Palun vali teine nimi.',
    52 => 'Viga: failinimi on juba kasutuses'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Sinu salasõna saadeti sulle E-postiga ja peaks kohe kohale jõudma. Palun järgi kirjas olevaid juhiseid ja me täname sind {$_CONF['site_name']} lehe kasutamise eest",
    2 => "Täname sind {$_CONF['site_name']} lehele loo sisestamise eest. See saadeti meie meeskonnale kinnitamiseks. Pärast meie lehe meeskonna poolset kinnitamist saavad kõik seda meie lehel lugeda.",
    3 => "Täname sind {$_CONF['site_name']} lehele lingi lisamise eest.  See saadeti meie meeskonnale kinnitamiseks. Kui see kinnitatakse, võid sa seda näha <a href={$_CONF['site_url']}/links.php>linkide</a> osas.",
    4 => "Täname sind {$_CONF['site_name']} lehele sündmuse sisestamise eest.  See saadeti meie meeskonnale kinnitamiseks. Pärast kinnitamist on see sündmus näha <a href={$_CONF['site_url']}/calendar.php>kalendri</a> osas.",
    5 => 'Sinu konto info on edukalt salvestatud.',
    6 => 'Sinu eelistused on edukalt salvestatud.',
    7 => 'Sinu kommentaaride eelistused on edukalt salvestatud.',
    8 => 'Sa oled edukalt välja logitud.',
    9 => 'Sinu lugu on edukalt salvestatud.',
    10 => 'Lugu on edukalt kustutatud.',
    11 => 'Sinu blokk on edukalt salvestatud.',
    12 => 'Blokk on edukalt kustutatud.',
    13 => 'Rubriik on edukalt salvestatud.',
    14 => 'Rubriik ja kõik sellega seotud lood ja blokid on edukalt kustutatud.',
    15 => 'Sinu link on edukalt salvestatud.',
    16 => 'Link on edukalt kustutatud.',
    17 => 'Sündmus on edukalt salvestatud.',
    18 => 'Sündmus on edukalt kustutatud.',
    19 => 'Küsitlus on edukalt salvestatud.',
    20 => 'Küsitlus on edukalt kustutatud.',
    21 => 'Kasutaja on edukalt salvestatud.',
    22 => 'Kasutaja on edukalt kustutatud.',
    23 => 'Sinu kalendrisse sündmuse lisamisel tekkis viga. Ei olnud sündmuse ID-d.',
    24 => 'Sündmus on sinu kalendrisse salvestatud.',
    25 => 'Ei saa enne sinu sisselogimist isiklikku kalendrit avada',
    26 => 'Sündmus on sinu isiklikust kalendrist edukalt eemaldatud',
    27 => 'Sõnum on edukalt saadetud.',
    28 => 'plugin on edukalt salvestatud',
    29 => 'Sellel lehel pole kahjuks isiklikud kalendrid kasutuses.',
    30 => 'Ligipääs tõkestatud',
    31 => 'Kahjuks pole sul ligipääsu lugude haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    32 => 'Kahjuks pole sul ligipääsu rubriikide haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    33 => 'Kahjuks pole sul ligipääsu blokkide haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    34 => 'Kahjuks pole sul ligipääsu linkide haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    35 => 'Kahjuks pole sul ligipääsu sündmuste haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    36 => 'Kahjuks pole sul ligipääsu küsitluste haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    37 => 'Kahjuks pole sul ligipääsu kasutajate haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    38 => 'Kahjuks pole sul ligipääsu pluginate haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    39 => 'Kahjuks pole sul ligipääsu E-posti haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    40 => 'Süsteemi teade',
    41 => 'Kahjuks pole sul ligipääsu sõnade asendamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    42 => 'Sõna on edukalt salvestatud',
    43 => 'Sõna on edukalt kustutatud.',
    44 => 'Plugin on edukalt installeeritud!',
    45 => 'Plugin on edukalt kustutatud.',
    46 => 'Kahjuks pole sul ligipääsu  andmebaasi bakupi tööriista juurde. Pane tähele, et kõik sellised lubamatud katsed logitakse',
    47 => 'Selliseid võimalusi saab kasutada vaid *nix keskkonnas. Kui süsteem töötab *nix operatsioonisüsteemis, siis puhvermälu on edukalt tühjendatud. Kui operatsioonisüsteemiks on Windows, pead sa otsima faile nimekujuga adodb_*.php ja need failid käsitsi kustutama.',
    48 => "Täname sind oma liikmelisuse kinnitamise eest {$_CONF['site_name']} lehel. Meie meeskond vaatab sinu taotluse läbi. Kui see kinnitatakse, saadetakse sinu poolt antud E-postiaadressile E-kirjaga sinu salasõna.",
    49 => 'Grupp on edukalt salvestatud.',
    50 => 'Grupp on edukalt kustutatud.',
    51 => 'See kasutajanimi on juba kasutuses. Palun vali mõni teine.',
    52 => 'Sisestatud E-postiaadress tundub olevat ebakorrektne.',
    53 => 'Sinu uus salasõna on aktsepteeritud. Palun logi uut salasõna kasutades allpool oleva vormi kaudu sisse.',
    54 => 'Sinu tellimus uue salasõna saamiseks on aegunud. Palun proovi alloleva vormi abil uuesti.',
    55 => 'Sulle saadeti E-kiri, mis peaks kohe sinu postkasti jõudma. Uue salasõna määramiseks järgi selles olevaid juhiseid.',
    56 => 'Sisestatud E-postiaadress on juba kasutuses teises kasutajakontos.',
    57 => 'Sinu kasutajakonto on edukalt kustutatud.',
    58 => 'Lõim on edukalt salvestatud.',
    59 => 'Lõim on edukalt kustutatud.',
    60 => 'Plugin on edukalt uuendatud.',
    61 => 'Plugin %s: Tundmatu teate järjenumber',
    62 => 'Trackback kommentaar on kustutatud.',
    63 => 'Trackback kommentaari kustutamisel tekkis viga.',
    64 => 'Sinu trackback kommentaar on edukalt saadetud.',
    65 => 'Veebilogi kataloogi teenus on edukalt salvestatud.',
    66 => 'See Veebilogi kataloogi teenus on kustutatud.',
    67 => 'Uus salasõna ei kattu kontrolliks sisestatud teise salasõnaga!',
    68 => 'Sa pead sisestama praeguse kehtiva salasõna.',
    69 => 'Sinu kasutajakonto on blokeeritud!',
    70 => 'Sinu konto ootab administraatori kinnitust.',
    71 => 'Sinu kasutajakonto loomise soov on nüüd kinnitatud ja ootab administraatoripoolset kinnitamist.',
    72 => 'Plugina installeerimisel tekkis viga. Täpsemalt vaata error.log failist.',
    73 => 'Plugina eemaldamisel tekkis viga. Täpsemalt vaata error.log failist.',
    74 => 'Pingback on edukalt saadetud.',
    75 => 'Trackbackid tuleb saata post meetodiga.',
    76 => 'Kas sa tõesti soovid seda kustutada?',
    77 => 'Hoiatus: <br>sa määrasid vaikekooditabeliks UTF-8, kuid sinu server ei toeta mitmebaidilist kooditabelit. Palun installeeri PHP jaoks mbstring funktsioonid või vali mõni teine kooditabel/keel.',
    78 => 'Palun kontrolli, et E-postiaadress ja kontrolliks sisestatud E-postiaadress oleksid samad.',
    79 => 'Leht, mida soovid avada, vajab tööks funktsiooni, mida kahjuks sellel saidil enam kasutuses ei ole.',
    80 => 'Selle lõime teinud plugina töö on hetkel välja lülitatud. Sa ei saa seda lõime toimetada enne kui oled antud plugina uuesti tööle lülitanud.',
    81 => 'Võimalik, et sa kirjutasid oma sisselogimisinfo valesti. Palun proovi alloleva vormi abil  uuesti sisse logida.',
    82 => 'Sa oled ületanud lubatud sisselogimiskatsete limiidi. Palun proovi hiljem uuesti.',
    83 => 'Et muuta oma salasõna, E-postiaadressi või kui kaua sind peaks sait mäletama, pead sa sisestama oma kehtiva salasõna.',
    84 => 'Oma konto kustutamiseks sisesta oma kehtiv salasõna.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Ligipääs',
    'ownerroot' => 'omanik (root)',
    'group' => 'Grupp',
    'readonly' => 'Ainult loetav',
    'accessrights' => 'Ligipääsuõigused',
    'owner' => 'Omanik',
    'grantgrouplabel' => 'Grant Above Group Edit Rights', // tõlkida
    'permmsg' => 'Märkus: liikmed on kõik lehele sisse loginud lehe kasutajad ja anonüümsed on kõik lehel olevad ja mitte sisse loginud lehe lugejad.',
    'securitygroups' => 'Turvalisusgrupid',
    'editrootmsg' => "Kuigi sa oled kasutajate administraator, ei saa sa muuta root kasutajate andmeid, kui sa ei ole ise root kasutaja. Sa võid toimetada kõiki teisi kasutajaid, välja arvatud root kasutajaid. Pane tähele, et kõik õigustamata katsed muuta root kasutajate andmeid logitakse.  Palun mine tagasi <a href=\"{$_CONF['site_admin_url']}/user.php\">Kasutajate administreerimislehele. </a>",
    'securitygroupsmsg' => 'Märgi grupid, millesse soovid, et see kasutaja kuuluks.',
    'groupeditor' => 'Grupi toimetaja',
    'description' => 'Kirjeldus',
    'name' => 'Nimi',
    'rights' => 'Õigused',
    'missingfields' => 'Puuduvad väljad',
    'missingfieldsmsg' => 'Sa pead grupi jaoks sisestama grupi nime ja kirjelduse',
    'groupmanager' => 'Grupi haldur',
    'newgroupmsg' => 'Grupi toimetamiseks või kustutamiseks klõpsa selle nimel allpool. Uue grupi loomiseks klõpsa Tee uus ülal. Pane tähele, et põhigruppe (core group) ei saa kustutada, sest need on süsteemis kasutusel.',
    'groupname' => 'Grupi nimi',
    'coregroup' => 'Põhigrupp',
    'yes' => 'Ja',
    'no' => 'Ei',
    'corerightsdescr' => "See grupp on {$_CONF['site_name']} põhigrupp (Core Group).  Seetõttu selle grupi õigusi ei saa muuta. Allpool on ainult loetaval kujul loetelu antud grupi õigustest.",
    'groupmsg' => 'Sellel lehel on turvalisusgrupid hierarhilised.  Lisades antud grupi mõnda alloleva grupi koosseisu, annad sa antud grupile samad õigused kui neilgi gruppidel. On eelistatavam kasutada allolevaid gruppe antud grupile õiguste määramisel.  Kui vajad kohandatud õigustega gruppi, siis saad sa selle lehe "Õigused" osas määrata mitmeid õigusi. Õiguste määramiseks märgi lihtsalt vastava grupi või õiguse juures olev märkeruut.',
    'coregroupmsg' => "See grupp on {$_CONF['site_name']} põhigrupp (Core Group).  Seetõttu ei saa selle grupi kuulumist teistesse gruppidesse muuta. Allpool on ainult loetaval kujul loetelu gruppidest, kuhu see grupp kuulub.",
    'rightsdescr' => 'Grupile võib määrata õigusi otse, määrates neid just antud grupile,  või andes vastavad õigused mõnele neist gruppidest, kuhu antud grupp kuulub. Need õigused, mis on ilma märkeruuduta, on antud grupile juba määratud nende gruppide kaudu, kuhu see hetkel kuulub. Neid õigusi, mille kõrval on märkeruut, võib määrata otse antud grupile.',
    'lock' => 'Lukk',
    'members' => 'Liikmed',
    'anonymous' => 'Anonüümne',
    'permissions' => 'Lubatud',
    'permissionskey' => 'R =lugemis-, E = toimetamis-, toimetamisõigus annab ka  lugemisõiguse', // tõlkida
    'edit' => 'Toimeta',
    'none' => 'Mitte midagi',
    'accessdenied' => 'Ligipääs tõkestatud',
    'storydenialmsg' => "Sul ei ole õigust seda lugu vaadata. Selle põhjuseks võib olla, et sa ei ole {$_CONF['site_name']} lehel registreerunud kasutaja.  Palun <a href=\"users.php?mode=new\"> registreeru {$_CONF['site_name']} lehe kasutajaks </a>, et saada kõiki registreerunud kasutaja õigusi",
    'nogroupsforcoregroup' => 'See grupp ei kuulu ühtegi teise gruppi',
    'grouphasnorights' => 'Sellel grupil pole ligipääsu ühelegi administreerimisfunktsioonile antud saidil',
    'newgroup' => 'Uus grupp',
    'adminhome' => 'Admin avaleht',
    'save' => 'salvesta',
    'cancel' => 'tühista',
    'delete' => 'kustuta',
    'canteditroot' => 'Sa üritasid toimetada root gruppi, kuid sa pole ise root grupi liige. Selletõttu tõkestati sinu ligipääs antud grupile. Kui sa arvad, et tegu on veaga, siis palun kontakteeru lehe administraatoriga.',
    'listusers' => 'Näita kasutajad',
    'listthem' => 'loetelu',
    'usersingroup' => 'Kasutajad grupis "%s"',
    'usergroupadmin' => 'Kasutajagrupi administreerimine',
    'add' => 'Lisa',
    'remove' => 'Eemalda',
    'availmembers' => 'Võimalikud liikmed',
    'groupmembers' => 'Grupi liikmed',
    'canteditgroup' => 'Grupi toimetamiseks pead sa ise olema selle grupi liige. Kui arvad, et tegu on veaga, siis palun kontakteeru lehe administraatoriga.',
    'cantlistgroup' => 'Grupi liikmete nägemiseks pead sa ise olema selle grupi liige. Kui sa arvad, et tegu on veaga, palun kontakteeru lehe administraatoriga.',
    'editgroupmsg' => 'Grupi liikmeskonna muutmiseks klõpsa kasutaja nimel ja kasuta kas Lisa või Eemalda nuppu. Kui kasutaja on grupi liige, on tema nimi ainult parempoolses loetelus. Kui oled lõpetanud, klõpsa grupi koosseisu uuendamiseks ja gruppide haldamise pealehele jõudmiseks <b>Salvesta</b> nuppu.',
    'listgroupmsg' => 'Loetelu kõigist grupi <b>%s</b> hetke liikmetest:',
    'search' => 'Otsi',
    'submit' => 'Sisesta',
    'limitresults' => 'Piira tulemused',
    'group_id' => 'Grupi ID',
    'plugin_access_denied_msg' => 'Sa üritasid ligi pääseda pluginate administreerimislehele, milleks polnud sul õigust. Pane tähele, et kõik õigustamata katsed sellele lehele ligi pääseda logitakse.',
    'groupexists' => 'Grupi nimi on juba olemas',
    'groupexistsmsg' => 'Sama nimega grupp on juba olemas. Grupi nimed peavad olema üksteisest erinevad.',
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Viimased 10 bakupit',
    'do_backup' => 'Tee bakkup',
    'backup_successful' => 'Andmebaasi bakkup oli edukas.',
    'db_explanation' => 'Sinu Geeklogist uue bakupi tegemiseks klõpsa allolevat nuppu',
    'not_found' => "Ebakorrektne tee programmini või mysqldump pole käivitatav.<br>Kontrolli config.php failis <strong>\$_DB_mysqldump_path</strong> definitsiooni.<br>Hetkel on muutuja väärtuseks: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Bakkup ebaõnnestus, faili suurus on 0 baiti',
    'path_not_found' => "{$_CONF['backup_path']} pole olemas või pole kataloog.",
    'no_access' => "Viga: bakkupkataloog, {$_CONF['backup_path']}, pole ligipääsetav.",
    'backup_file' => 'Backupfail',
    'size' => 'suurus',
    'bytes' => 'baiti',
    'total_number' => 'Bakupite üldarv: %d'
);

###############################################################################erefo$

$LANG_BUTTONS = array(
    1 => 'Avaleht',
    2 => 'Kontakt',
    3 => 'Avalda',
    4 => 'Lingid',
    5 => 'Küsitlused',
    6 => 'Kalender',
    7 => 'Lehe statistika',
    8 => 'Kohanda',
    9 => 'Otsi',
    10 => 'täpsem otsing',
    11 => 'Artiklid'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Viga/Error 404',
    2 => 'Ma otsisin igalt poolt, kuid ei leidnud otsitud lehte: <b>%s</b>.',
    3 => "<p>Mul on kahju, kuid soovitud  faili ei ole. Palun vaata kindlasti <a href=\"{$_CONF['site_url']}\">pealehele </a> või <a href=\"{$_CONF['site_url']}/search.php\">otsimislehele,</a> et otsitavat leida.",
);

###############################################################################

$LANG_LOGIN = array(
    1 => 'Nõutav sisselogimine',
    2 => 'Selle lehe osa vaatamiseks pead kasutajana sisse logima.',
    3 => 'Logi sisse',
    4 => 'Uus kasutaja'
);

$LANG_PDF = array(
    1 => 'PDF oskused on välja lülitatud',
    2 => 'Etteantud faili ei teisendatud. Dokument laeti korrektselt, kuid seda ei suudetud töödelda. Jälgi hoolikalt, et laeksid vaid XHTML standardile vastavaid HTML dokumente. Pea meeles, et keeruka kujundusega HTML dokumente võidakse teisendada ebakorrektselt või üldse mitte teisendada. Sinu faili töötluse tulemusena loodi 0 baidi suurusega fail ja see kustutati. Kui sa oled kindel, et sinu faili saab edukalt töödelda, siis lae see uuesti.',
    3 => 'PDF-i genereerimisel tekkis tundmatu viga',
    4 => 'No page data was given or you want to use the ad-hoc PDF generation tool below.  If you think you are getting this page in error then please contact the system administrator.  Otherwise, you may use the form below to generate PDF\'s in an ad-hoc fashion.',// tõlkida
    5 => 'Laen dokumenti.',
    6 => 'Palun oota, kuni sinu dokumenti laetakse.',
    7 => 'Sa võid oma dokumendi salvestamiseks teha alloleval lingil hiirega paremklõpsu ning valida menüüst kas "Save target...", "Salvesta sihtmärk...", "Save Link location..." vms.',
    8 => 'Konfiguratsioonis määratud tee HTMLDoc rakenduseni on kas vale või seda rakendust ei saa käivitada. Palun pöördu probleemi püsimisel lehe administraatori poole.',
    9 => 'PDF-i genereerija',
    10 => 'This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site', // tõlkida
    11 => 'URL',
    12 => 'Genereeri PDF!',
    13 => 'Selle lehe häälestus ei luba kasutada PHP funktsiooni fopen(). Süsteemiadministraator peab selle funktsiooni lubamiseks muutma php.ini faili ning selles allow_url_fopen sisse lülitama.',
    14 => 'PDF faili, mida soovid vaadata kas pole olemas või üritad sa seda vaadata ilma selleks piisavaid õigusi omamata.',
);

###############################################################################
# trackback

$LANG_TRB = array (
    'trackback'          => 'Trackback',
    'from'               => 'kust',
    'tracked_on'         => 'Kommenteeritud', // Tracked on
    'read_more'          => '[loe lisaks]',
    'intro_text'         => 'Siin on see, mida teised ütlevad "%s" kohta:',
    'no_comments'        => 'Selle sisestuse kohta pole trackbackkommentaare.',
    'this_trackback_url' => 'Selle sisestuse trackback URL:',
    'num_comments'       => '%d trackbackkommentaari',
    'send_trackback'     => 'Saada Ping',
    'preview'            => 'Eelvaade',
    'editor_title'       => 'Saada trackbackkommentaar',
    'trackback_url'      => 'Trackbacki URL',
    'entry_url'          => 'Sisestuse URL',
    'entry_title'        => 'Sisestuse tiitel',
    'blog_name'          => 'Saidi nimi',
    'excerpt'            => 'katkend',
    'truncate_warning'   => 'Märkus: vastuvõttev leht võib sinu katkendit lühendada.',
    'button_send'        => 'Saada',
    'button_preview'     => 'Eelvaade',
    'send_error'         => 'Viga',
    'send_error_details' => 'Viga trackbackkommentaari saatmisel:',
    'url_missing'        => 'Puudub sisestuse URL',
    'url_required'       => 'Palun kirjuta sisestuse jaoks vähemalt URL.',
    'target_missing'     => 'Pole Trackback URL-i',
    'target_required'    => 'Palun kirjuta trackbacki URL',
    'error_socket'       => 'Ei saanud avada väratit.',
    'error_response'     => 'Serveri vastus oli arusaamatu.',
    'error_unspecified'  => 'Määratlemata viga.',
    'select_url'         => 'Vali trackbacki URL',
    'not_found'          => 'Ei leidnud trackback URL-i',
    'autodetect_failed'  => 'Geeklog ei suutnud tuvastada saadetava kommentaari jaoks trackback URL-i. Palun kirjuta see käsitsi allolevasse vormi.',
    'trackback_explain'  => 'Vali allolevast loetelust link, kuhu soovid oma trackback kommentaari saata. Pärast seda üritab Geeklog tuvastada trackback kommentaari jaoks õige URL-i. Kui sa tead õiget URL-i, võid sa <a href="%s">sisestada selle käsitsi. </a>',
    'no_links_trackback' => 'Ei leidnud linke. Sa ei saa selle sisestuse kohta saata trackback kommentaari.',
    'pingback'           => 'Pingback',
    'pingback_results'   => 'Pingback tulemused',
    'send_pings'         => 'Saada Ping-id',
    'send_pings_for'     => 'Saada Ping-id "%s"', // tõlkida
    'no_links_pingback'  => 'Ei leidnud linke. Selle sisestuse kohta ei saadetud  pingbacke.',
    'pingback_success'   => 'Pingback on saadetud.',
    'no_pingback_url'    => 'Ei leidnud pingback URL-i.',
    'resend'             => 'Saada uuesti',
    'ping_all_explain'   => 'Sa võid teavitada lehti, millele sinu leht viitab saates (<a href="http://en.wikipedia.org/wiki/Pingback"> Pingbacki</a>), teavitada lehe uuendamisest saates pingi veebi logikataloogidesse (weblog directory) või saata <a href="http://en.wikipedia.org/wiki/Trackback"> Trackbackkommentaari,</a> viimast juhul, kui oled oma lehel kommenteerinud mõnel teisel saidil olnud kellegi teise kirjutist.',
    'pingback_button'    => 'Saada Pingback',
    'pingback_short'     => 'Saada pingback kõigile käesolevalt  lehelt lingitud lehtedele.',
    'pingback_disabled'  => '(Pingback on välja lülitatud)',
    'ping_button'        => 'Saada Ping',
    'ping_short'         => 'Pingi veebi logikatalooge',
    'ping_disabled'      => '(Ping on välja lülitatud)',
    'trackback_button'   => 'Saada Trackback',
    'trackback_short'    => 'Saada trackbackkommentaar.',
    'trackback_disabled' => '(Trackback on välja lülitatud)',
    'may_take_a_while'   => 'Pane tähele, et pingi ja pingbacki saatmine võib võtta aega.',
    'ping_results'       => 'Ping tulemused',
    'unknown_method'     => 'Tundmatu ping meetod',
    'ping_success'       => 'Ping on saadetud.',
    'error_site_name'    => 'Palun kirjuta saidi nimi.',
    'error_site_url'     => 'Palun sisesta lehe URL.',
    'error_ping_url'     => 'Palun kirjuta toimiv ping URL.',
    'no_services'        => 'Pole häälestatud veebi logikataloogide kasutamine (weblog directory services).',
    'services_headline'  => 'Veebi logikataloogide teenused',
    'service_explain'    => 'Veebi logikataloogi teenusepakkuja andmete toimetamiseks klõpsa allpool vastavat nuppu logikataloogi nime kõrval. Uue logikataloogi lisamiseks klõpsa Tee uus ülal.',
    'service'            => 'Teenus',
    'ping_method'        => 'Ping meetod',
    'service_website'    => 'Veebileht',
    'service_ping_url'   => 'Pingi URL',
    'ping_standard'      => 'Standard Ping',
    'ping_extended'      => 'Laiendatud ping',
    'ping_unknown'       => '(tundmatu meetod)',
    'edit_service'       => 'Toimeta veebi logikataloogi andmeid',
    'trackbacks'         => 'Trackbackid',
    'editor_intro'       => 'Valmista oma trackbackkommentaar  <a href="%s">%s jaoks ette</a>.',
    'editor_intro_none'  => 'Valmista trackback kommentaar ette.',
    'trackback_note'     => 'Trackbakkommentaari saatmiseks mine lugude loetelusse ja klõpsa loo juures "' . $LANG24[21] . '". Klõpsa järgmisel lingil, et <a href="%s"> saata lugudega sidumata trackbackkommentaari.</a>',
    'pingback_explain'   => 'Kirjuta URL, kuhu pingback saata. Pingback viitab tagasi sinu saidi pealehele.',
    'pingback_url'       => 'Pingbacki URL',
    'site_url'           => 'Antud saidi URL',
    'pingback_note'     => 'Pingbacki saatmiseks mine lugude loetelusse ja klõpsa loo juures "' . $LANG24[21] . '". Klõpsa järgmisel lingil, et <a href="%s"> saata lugudega sidumata pingbacki.</a>',
    'pbtarget_missing'   => 'Pole pingbacki URL-i',
    'pbtarget_required'  => 'Palun kirjuta pingbacki URL',
    'pb_error_details'   => 'Pingbacki saatmisel tekkis viga:',
    'delete_trackback'   => 'Selle trackbacki kustutamiseks klõpsa: ',
);

###############################################################################
# directory.php

$LANG_DIR = array (
    'title'            => 'Artiklite kataloog',
    'title_year'       => '%d artiklid',
    'title_month_year' => '%s %d artiklid',
    'nav_top'          => 'Tagasi peakataloogi',
    'no_articles'      => 'Pole artikleid'
);

################################################################################
# "What's New" Time Strings

$LANG_WHATSNEW = array (
    # This here determines the order of the sentence "No new stories in 2 hrs"
    # order it so it makes sense in your language:
    # %i    item, "Stories"
    # %n    amount, "2", "20" etc
    # %t    time, "2" (weeks)
    # %s    scale, "hrs", "weeks"
    'new_string'  => '%n uut %i viimase %t %s jooksul',
    'new_last'    => ' viimase %t %s jooksul',
    # other strings
    'minutes'     => 'minuti',
    'hours'       => 'tunni',
    'days'        => 'päeva',
    'weeks'       => 'nädala',
    'months'      => 'kuu',
    'minute'      => 'minut',
    'hour'        => 'tund',
    'day'         => 'päeva',
    'week'        => 'nädala',
    'month'       => 'kuu'
);

$LANG_MONTH = array(
    1 => 'Jaanuar',
    2 => 'Veebruar',
    3 => 'Märts',
    4 => 'Aprill',
    5 => 'Mai',
    6 => 'Juuni',
    7 => 'Juuli',
    8 => 'August',
    9 => 'September',
    10 => 'Oktoober',
    11 => 'November',
    12 => 'Detsember'
);

$LANG_WEEK = array(
    1 => 'Pühapäev',
    2 => 'Esmaspäev',
    3 => 'Teisipäev',
    4 => 'Kolmapäev',
    5 => 'Neljapäev',
    6 => 'Reede',
    7 => 'Laupäev'
);

################################################################################
# Admin - Strings
#
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array (
    'search'        => 'Otsi',
    'limit_results' => 'Piira tulemused',
    'submit'        => 'Valmis',
    'edit'          => 'Toimeta',
    'edit_adv'      => 'Toimeta lisa',
    'admin_home'    => 'Admin avaleht',
    'create_new'    => 'Tee uus',
    'create_new_adv' => 'Tee uus (lisa)',
    'enabled'       => 'Kasutuses',
    'title'         => 'Tiitel',
    'type'          => 'Tüüp',
    'topic'         => 'Rubriik',
    'help_url'      => 'Abifaili URL',
    'save'          => 'Salvesta',
    'cancel'        => 'Tühista',
    'delete'        => 'Kustuta',
    'delete_sel'    => 'Kustuta valitud',
    'copy'          => 'Koopia',
    'no_results'    => '- Ei leidnud midagi -',
    'data_error'    => 'Liitumiste andmetega tekkis viga. Palun kontrolli algandmeid.',
    'preview'       => 'Eelvaade',
    'records_found' => 'Leitud kirjed'
);

# Localisation of the texts for the various drop-down menus that are actually
# stored in the database. If these exist, they override the texts from the
# database.

$LANG_commentcodes = array(
    0   => 'On kommentaarid',
    -1  => 'Pole kommentaare'
);

$LANG_commentmodes = array(
    'flat'      => 'lihtne',
    'nested'    => 'Üksteise sees',
    'threaded'  => 'Lõimedena',
    'nocomment' => 'pole kommentaare'
);

$LANG_cookiecodes = array(
    0       => 'ära mäleta',
    3600    => '1 tund',
    7200    => '2 tundi',
    10800   => '3 tundi',
    28800   => '8 tundi',
    86400   => '1 päev',
    604800  => '1 nädal',
    2678400 => '1 kuu'
);

$LANG_dateformats = array(
    0   => 'Süsteemi seadistus'
);

$LANG_featurecodes = array(
    0 => 'Pole pealugu',
    1 => 'Pealugu'
);

$LANG_frontpagecodes = array(
    0 => 'Ainult rubriigis',
    1 => 'Avalehel ja rubriigis'
);

$LANG_postmodes = array(
    'plaintext' => 'Puhas tekst',
    'html'      => 'HTML kujundusega'
);

$LANG_sortcodes = array(
    'ASC'  => 'Vanemad enne',
    'DESC' => 'Uuemad enne'
);

$LANG_trackbackcodes = array(
    0   => 'Trackback lubatud',
    -1  => 'Trackback keelatud'
);

?>
