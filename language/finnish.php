<?php

###############################################################################
# finnish.php
# This is the Finnish language page for GeekLog!
#
# Copyright (C) 2004 Jussi Josefsson
# 20031012 - Version 1.0 - Geeklog 1.3.8
# 20040217 - Version 1.1 - Geeklog 1.3.9rc1
# ihra@iki.fi
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

$LANG_CHARSET = 'iso-8859-1';

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
    1 => 'Kirjoittaja:',
    2 => 'lue lis��',
    3 => 'kommentti(a)',
    4 => 'Muokkaa',
    5 => '��nest�',
    6 => 'Tulokset',
    7 => '��nestyksen tulokset',
    8 => '��nt�',
    9 => 'Yll�pidon toiminnot:',
    10 => 'L�hetyksi�',
    11 => 'Artikkeleja',
    12 => 'Blokkeja',
    13 => 'Aiheita',
    14 => 'Linkkej�',
    15 => 'Tapahtumia',
    16 => '��nestyksi�',
    17 => 'K�ytt�ji�',
    18 => 'SQL kysely',
    19 => 'Kirjaudu ulos',
    20 => 'K�ytt�j�n tiedot:',
    21 => 'K�ytt�j�n nimi',
    22 => 'Tunnus',
    23 => 'Turvallisuustaso',
    24 => 'Tuntematon',
    25 => 'Vastaa',
    26 => 'Oheiset kommentit ovat kirjoittajiensa omaisuutta. Sivusto ei ole vastuussa kirjoittajien sanomisista.',
    27 => 'Uusin kirjoitus',
    28 => 'Poista',
    29 => 'Ei k�ytt�j�n l�hett�mi� kommentteja',
    30 => 'Vanhemmat artikkelit',
    31 => 'Sallitut HTML tagit:',
    32 => 'Virhe, virheellinen k�ytt�j�nimi',
    33 => 'Virhe, logiin ei voi kirjoittaa',
    34 => 'Virhe',
    35 => 'Kirjaudu ulos',
    36 => 'on',
    37 => 'Ei k�ytt�j�n kirjoituksia',
    38 => 'Content Syndication',
    39 => 'Virkist�',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Vieraita sivustolla',
    42 => 'Tekij�:',
    43 => 'Vastaa t�h�n',
    44 => 'Edellinen',
    45 => 'MySQL virhe numeroltaan',
    46 => 'MySQL virhe viesti',
    47 => 'K�ytt�j�n toiminnot',
    48 => 'Omat tiedot',
    49 => 'Asetukset',
    50 => 'Virhe SQL lauseessa',
    51 => 'apua',
    52 => 'Uusi',
    53 => 'Yll�pito',
    54 => 'Tiedostoa ei voinut avata.',
    55 => 'Virhe',
    56 => '��nest�',
    57 => 'Salasana',
    58 => 'Kirjaudu',
    59 => "Ei tunnusta viel�? Kirjaudu <a href=\"{$_CONF['site_url']}/users.php?mode=new\">uutena k�ytt�j�n�</a>",
    60 => 'L�het� kommentti',
    61 => 'Luo uusi k�ytt�j�tili',
    62 => 'sanaa',
    63 => 'Kommenttien asetukset',
    64 => 'L�het� artikkeli s�hk�postitse yst�v�lle',
    65 => 'N�yt� tulostettava versio',
    66 => 'Oma kalenteri',
    67 => 'Tervetuloa sivustolle',
    68 => 'etusivu',
    69 => 'yhteystiedot',
    70 => 'etsi',
    71 => 'l�het� artikkeli',
    72 => 'verkkoresurssit',
    73 => 'aikaisemmat ��nestykset',
    74 => 'kalenteri',
    75 => 'laajennettu etsint�',
    76 => 'sivuston tilastot',
    77 => 'Laajennukset',
    78 => 'Tulevat tapahtumat',
    79 => 'Uutta sivustolla',
    80 => 'artikkelia viimeiseen',
    81 => 'artikkeli viimeiseen',
    82 => 'tuntiin',
    83 => 'KOMMENTIT',
    84 => 'LINKIT',
    85 => 'viimeisen� 48 tuntina',
    86 => 'Ei uusia kommentteja',
    87 => 'viimeiseen 2 viikkoon',
    88 => 'Ei uusia linkkej�',
    89 => 'Ei tulevia tapahtumia',
    90 => 'Etusivu',
    91 => 'Sivu luotu ',
    92 => 'sekunnissa',
    93 => 'Copyright',
    94 => 'All trademarks and copyrights on this page are owned by their respective owners.',
    95 => 'Moottorina toimii',
    96 => 'Ryhmi�',
    97 => 'Sana lista',
    98 => 'Laajennuksia',
    99 => 'ARTIKKELIT',
    100 => 'Ei uusia artikkeleita',
    101 => 'Omat tapahtumat',
    102 => 'Sivuston tapahtumat',
    103 => 'DB varmuuskopiointi',
    104 => 'by',
    105 => 'S�hk�postia k�ytt�jille',
    106 => 'Katselukertoja',
    107 => 'GL versiotesti',
    108 => 'Tyhjenn� v�limuisti',
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
    123 => 'All HTML is allowed',
    124 => 'Click to delete all checked items',
    125 => 'Are you sure you want to Delete all checked items?',
    126 => 'Select or de-select all items'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'L�het� kommentti',
    2 => 'L�hetyksen muoto',
    3 => 'Kirjaudu ulos',
    4 => 'Luo k�ytt�j�tili',
    5 => 'K�ytt�j�nimi',
    6 => 'Sivustolle voi l�hett�� kommentteja vain rekister�ityneet k�ytt�j�t. Jos sinulla ei ole k�ytt�j�tili� sivustolla, voit tehd� tilin k�ytt�m�ll� alla olevaa lomaketta.',
    7 => 'Viimeisin kommenttisi kirjoitettiin ',
    8 => " sekuntia sitten. Sivusto vaatii v�hint��n {$_CONF['commentspeedlimit']} sekuntia kommenttien v�lill�",
    9 => 'Kommentti',
    10 => 'Send Report',
    11 => 'L�het� kommentti',
    12 => 'T�yt� otsikko ja kommentti -kent�t, ne ovat pakollisia kommenttia l�hetett�ess�.',
    13 => 'Omat tietosi',
    14 => 'Esikatselu',
    15 => 'Report this post',
    16 => 'Otsikko',
    17 => 'Virhe',
    18 => 'T�rkeit� huomioita',
    19 => 'Yrit� pysy� aiheessa.',
    20 => 'Pyri vastaamaan muiden l�hett�miin kommentteihin uuden kommenttis�ikeen aloittamisen sijaan.',
    21 => 'Lue muiden l�hett�m�t viestit ennen oman kommentin postittamista toiston est�miseksi.',
    22 => 'Nime� viesti selke�sti ja kuvaavasti.',
    23 => 'S�hk�postiosoitteesi EI tule julkisesti n�kyville.',
    24 => 'Tuntematon k�ytt�j�',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Tiedot k�ytt�j�st�',
    2 => 'K�ytt�j�n nimi',
    3 => 'Koko nimi',
    4 => 'Salasana',
    5 => 'S�hk�posti',
    6 => 'Kotisivu',
    7 => 'Tiedot',
    8 => 'PGP avain',
    9 => 'Tallenna tiedot',
    10 => 'Viimeiset 10 kommentti� k�ytt�j�lt�',
    11 => 'Ei k�ytt�j�n l�hett�mi� kommentteja',
    12 => 'Asetukset k�ytt�j�lle',
    13 => 'L�het� p�ivitt�inen yhteenveto s�hk�postitse',
    14 => 'T�m� salasana on satunnaisgeneraattorin tuottama. On suositeltavaa vaihtaa salasana toiseen v�litt�m�sti. Vaihtaaksesi salasanan, kirjaudu sivustolle ja valitse Omat tiedot k�ytt�j�n toiminnoista.',
    15 => "{$_CONF['site_name']} k�ytt�j�tili on luotu. K�ytt��ksesi tili�, kirjaudu sis��n allaolevin tiedoin. S��st� t�m� s�hk�posti tulevaa k�ytt�� varten.",
    16 => 'Omat tiedot',
    17 => 'Tili� ei ole olemassa',
    18 => 'S�hk�posti-osoite ei ole tunnu olevan oikeanmuotoinen osoite',
    19 => 'Sy�tetty k�ytt�j�nimi tai s�hk�posti ovat jo k�yt�ss�',
    20 => 'S�hk�posti-osoite ei ole oikea s�hk�posti-osoite',
    21 => 'Virhe',
    22 => "Rekister�idy sivustolle {$_CONF['site_name']}!",
    23 => "Luomalla sivustolle {$_CONF['site_name']} k�ytt�j�tilin voit itse l�hett�� artikkeleita tai kommentteja. Ilman tili� voit l�hett�� viestej� vain tuntemattomana. Huomaa ett� s�hk�postiosoitettasi ei <b><i>koskaan</i></b> n�ytet� julkisesti sivustolla.",
    24 => 'Salasanasi l�hetet��n sy�tt�m��si s�hk�postiosoitteeseen.',
    25 => 'Unohditko salasanasi?',
    26 => 'Sy�t� <em>joko</em> k�ytt�j�nimesi <em>tai</em> s�hk�posti-osoitteesi jotka sy�tit rekister�ityess�si ja valitse L�het� salasana. Ohjeet uuden salasanan asettamiseksi l�hetet��n s�hk�postitse tilin osoitteeseen.',
    27 => 'Rekister�idy!',
    28 => 'L�het� salasana',
    29 => 'kirjauduit ulos sivustolta',
    30 => 'kirjauduit sis��n sivustolle',
    31 => 'Toiminto vaatii rekister�itymist�',
    32 => 'Allekirjoitus',
    33 => 'Ei julkisesti n�kyv�',
    34 => 'Oikea nimesi',
    35 => 'Kirjoita uusi salasana jos haluat vaihtaa vanhan',
    36 => 'Alkaa http://',
    37 => 'Lis�tty kommentteihisi',
    38 => 'Kaikki el�m�st�si! Kaikki voivat lukea t�m�n',
    39 => 'Julkinen PGP avain jaettavaksi',
    40 => 'Ei aiheiden kuvakkeita',
    41 => 'Halukas moderoijaksi',
    42 => 'P�iv�yksen muoto',
    43 => 'Artikkelien maksimim��r�',
    44 => 'Ei laatikkoja',
    45 => 'N�yt� asetukset tilille',
    46 => 'Poisj�tett�v�t kohteet tilille',
    47 => 'Uutislaatikon asetukset tilille',
    48 => 'Aiheet',
    49 => 'Ei kuvakkeita artikkeleissa',
    50 => 'Poista rasti jos et ole kiinnostunut',
    51 => 'Vain uutiset',
    52 => 'Oletus on',
    53 => 'Vastaanota p�iv�n tarina joka y�',
    54 => 'Valitse aiheet ja kirjoittajat joita et halua n�hd�.',
    55 => 'J�tt�m�ll� kaikki laatikot valitsematta, k�ytet��n oletusarvoja. Jos alat rastittamaan valintoja, muista valita kaikki haluamasi, koska oletusarvot ohitetaan. Oletusarvot n�ytet��n lihavoituina.',
    56 => 'Kirjoittajat',
    57 => 'N�ytt�tila',
    58 => 'Lajitteluj�rjestys',
    59 => 'Kommenttien rajoitus',
    60 => 'Miten haluat kommenttisi n�ytett�v�n?',
    61 => 'Uusimmat vai vanhimmat ensin?',
    62 => 'Oletus on 100',
    63 => "Salasanasi on l�hetetty s�hk�postitse. Seuraa viestiss� olevia ohjeita ja kiitos kun k�yt�t sivustoa {$_CONF['site_name']}",
    64 => 'Kommenttien astukset k�ytt�j�lle',
    65 => 'Yrit� kirjautua uudestaan',
    66 => "Kirjoitit sis��nkirjautuessa jotain v��rin. Yrit� kirjautua uudelleen. Oletko <a href=\"{$_CONF['site_url']}/users.php?mode=new\">uusi k�ytt�j�</a>?",
    67 => 'Liittynyt',
    68 => 'S�ilyt� tiedot',
    69 => 'Kuinka kauan sivuston tulee muistaa tietosi kirjautumisen j�lkeen?',
    70 => "Muokkaa ulkoasua ja asetuksia sivustolle {$_CONF['site_name']}",
    71 => "Yksi t�m�n sivuston ({$_CONF['site_name']}) parhaista ominaisuuksista on muokattavuus - voit muokata haluamasi ulkoasun ja sis�ll�n sivustolle. Hy�dynt��ksesi ominaisuuksia sinun tulee ensiksi <a href=\"{$_CONF['site_url']}/users.php?mode=new\">rekister�ity�</a> sivustolle {$_CONF['site_name']}.  Oletko jo rekister�itynyt? Kirjaudu sis��n k�ytt�en vasemmalla olevaa lomaketta!",
    72 => 'Teema',
    73 => 'Kieli',
    74 => 'Vaihda sivuston ulkoasua!',
    75 => 'S�hk�postitse l�hetett�v�t uutiset',
    76 => 'Valitsemalla aiheet alla olevasta listasta, saat uudet aiheisiin liittyv�t uutiset s�hk�postitse itsellesi kerran p�iv�ss�. Valitse vain aiheet joista olet kiinnostunut!',
    77 => 'Kuva',
    78 => 'Lis�� kuva itsest�si!',
    79 => 'Rastita t�m� poistaaksesi kuvan',
    80 => 'Kirjaudu',
    81 => 'L�het� s�hk�postitse',
    82 => 'Viimeiset 10 tarinaa k�ytt�j�lt�',
    83 => 'Tilastot kirjoituksista k�ytt�j�lt�',
    84 => 'Artikkeleita yhteens�:',
    85 => 'Kommentteja yhteens�:',
    86 => 'Etsi kaikki postitukset k�ytt�j�lt�',
    87 => 'Nimesi jolla olet kirjautunut',
    88 => "Joku (mahdollisesti sin� itse) on pyyt�nyt uutta salasanaa tilillesi \"%s\" sivustolla {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nJos haluat vaihtaa salasanan, valitse seuraava linkki:\n\n",
    89 => "Jos et halua tehd� n�in, ohita t�m� viesti ja pyynt� ev�t��n (salasanasi pysyy muuttumattomana).\n\n",
    90 => 'Voit kirjoittaa tilisi uuden salasanan alle, Huomaa ett� vanha salasanasi on yh� voimassa kunnes l�het�t t�m�n lomakkeen.',
    91 => 'Aseta uusi salasana',
    92 => 'Kirjoita uusi salasana',
    93 => 'Edellinen pyynt�si salasanan vaihtamiseksi tapahtui %d sekuntia sitten. Sivusto vaatii ainakin %d sekunnin viiveen vaihtojen v�lill�.',
    94 => 'Poista tili "%s"',
    95 => 'Valitse "poista tili" nappi alta poistaaksesi tietosi tietokannasta. Huomaa ett� kaikki postittamasi artikkelit ja kommentit <strong>eiv�t</strong> poistu, mutta niiden kirjoittajaksi merkit��n "tuntematon".',
    96 => 'poista tili',
    97 => 'Vahvista tilin poistaminen',
    98 => 'Oletko varma ett� haluat poistaa tilisi? Poistamalla k�ytt�j�tilin et voi kirjautua sivustolle uudestaan (paitsi tekem�ll� uuden tilin). Jos olet varma, valitse "poista tili" alta.',
    99 => 'Yksityisyyden vaihtoehdot tilille',
    100 => 'Yll�pidon viestit',
    101 => 'Salli yll�pidon l�hett�m�t s�hk�postit',
    102 => 'K�ytt�jien viestit',
    103 => 'Salli muiden k�ytt�jien l�hett�m�t s�hk�postit',
    104 => 'N�yt� linjalla -tila',
    105 => 'N�y Ket� on linjalla -lohkossa',
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
    1 => 'Ei n�ytett�vi� uutisia',
    2 => 'Ei n�ytett�vi� uutisi�. Joko aiheesta ei ole uutisia tai asetuksesi voivat olla liian rajoittavia',
    3 => ' aiheesta %s',
    4 => 'P�iv�n artikkeli',
    5 => 'Seuraava',
    6 => 'Edellinen',
    7 => 'First',
    8 => 'Last'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Virhe viesti� l�hetett�ess�. Yrit� uudelleen.',
    2 => 'Viesti l�hetetty onnistuneesti.',
    3 => 'Varmista ett� vastausosoite-kent�ss� on oikea s�hk�postiosoite.',
    4 => 'T�yt� nimesi, vastausosoite, aihe sek� viesti-kent�t',
    5 => 'Virhe: valittua k�ytt�j�� ei l�ydy.',
    6 => 'Tapahtui virhe k�sittelyss�.',
    7 => 'Profiili k�ytt�j�lle',
    8 => 'K�ytt�j�nimi',
    9 => 'K�ytt�j�n URL',
    10 => 'L�het� viesti k�ytt�j�lle',
    11 => 'Nimesi:',
    12 => 'Vastausosoite:',
    13 => 'Aihe:',
    14 => 'Viesti:',
    15 => 'HTML koodeja ei k��nnet�.',
    16 => 'L�het� viesti',
    17 => 'L�het� artikkeli yst�v�lle',
    18 => 'K�ytt�j�lle',
    19 => 'S�hk�postiosoitteeseen',
    20 => 'L�hett�j�n nimi',
    21 => 'L�hett�j�n s�hk�postiosoite',
    22 => 'Kaikki kent�t on t�ytett�v�',
    23 => "T�m�n s�hk�postin l�hetti sinulle %s at %s koska h�n ajatteli artikkelin osoitteesta {$_CONF['site_url']} kiinnostavan sinua.  T�m� ei ole roskapostia ja l�hetyksess� k�ytettyj� s�hk�postiosoitteita ei tallenneta my�hemp�� k�ytt�� varten.",
    24 => 'Kommentoi artikkelia osoitteessa',
    25 => 'Sinun taytyy olla kirjautuneena sivustolle k�ytt��ksesi ominaisuutta. Vaatimalla kirjautumista estet��n j�rjestelm�n v��rink�yt�kset',
    26 => 'T�ll� lomakkeella voit l�hett�� s�hk�postia valitulle k�ytt�j�lle. Kaikki kent�t ovat pakollisia t�ytt��.',
    27 => 'Lyhyt viesti',
    28 => '%s kirjoitti: ',
    29 => "T�m� on p�ivitt�inen kooste sivustolta {$_CONF['site_name']} k�ytt�j�lle ",
    30 => ' P�ivitt�inen uutislehti ',
    31 => 'Otsikko',
    32 => 'P�iv�ys',
    33 => 'Lue artikkeli kokonaan osoitteessa',
    34 => 'Viestin loppu',
    35 => 'Pahoittelemme, k�ytt�j� ei halua saada s�hk�posteja.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Laajennettu haku',
    2 => 'Avainsanat',
    3 => 'Aihe',
    4 => 'Kaikki',
    5 => 'Tyyppi',
    6 => 'Artikkelit',
    7 => 'Kommentit',
    8 => 'Kirjoittajat',
    9 => 'Kaikki',
    10 => 'Etsi',
    11 => 'Etsinn�n tulokset',
    12 => 'osumaa',
    13 => 'Etsinn�n tulokset: ei osumia',
    14 => 'Ei l�ytynyt hakutuloksia haulle',
    15 => 'Yrit� uudelleen.',
    16 => 'Otsikko',
    17 => 'P�iv�ys',
    18 => 'Kirjoittaja',
    19 => "Etsi nykyisi� ja vanhoja artikkeleita sivuston {$_CONF['site_name']} koko tietokannasta",
    20 => 'P�iv�ys',
    21 => 'viiva',
    22 => '(P�iv�yksen muoto VVVV-KK-PP)',
    23 => 'Katselukertaa',
    24 => 'L�ydetty %d aihetta',
    25 => 'Etsitty ',
    26 => 'aihetta ',
    27 => 'sekuntia',
    28 => 'Yksik��n artikkeli tai kommentti ei vastannut hakuasi',
    29 => 'Artikkeleiden ja kommenttien tulokset',
    30 => 'Yksik��n linkki ei vastannut hakuasi',
    31 => 'Laajennus ei l�yt�nyt osumia',
    32 => 'Tapahtuma',
    33 => 'URL',
    34 => 'Sijainti',
    35 => 'Koko p�iv�n',
    36 => 'Yksik��n tapahtuma ei vastannut hakuasi',
    37 => 'Tapahtumien tulokset',
    38 => 'Linkkien tulokset',
    39 => 'Linkit',
    40 => 'Tapahtumat',
    41 => 'Hakulauseessa tulee olla ainakin 3 merkki�.',
    42 => 'K�yt� p�iv�yst� muodossa VVVV-KK-PP (vuosi-kuukausi-p�iv�).',
    43 => 't�sm�lleen sama lause',
    44 => 'kaikki sanat',
    45 => 'mik� tahansa sanoista',
    46 => 'Seuraava',
    47 => 'Edellinen',
    48 => 'Kirjoittaja',
    49 => 'P�iv�ys',
    50 => 'Osumia',
    51 => 'Linkki',
    52 => 'Sijainti',
    53 => 'Tulokset artikkeleista',
    54 => 'Tulokset kommenteista',
    55 => 'lause',
    56 => 'JA',
    57 => 'TAI',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Sivuston tilastot',
    2 => 'Yhteens� latauksia j�rjestelm�st�',
    3 => 'Artikkeleja(kommentteja) j�rjestelm�ss�',
    4 => '��nestyksi�(vastauksia) j�rjestelm�ss�',
    5 => 'Linkkej�(klikkauksia) j�rjestelm�ss�',
    6 => 'Tapahtumia j�rjestelm�ss�',
    7 => 'Kymmenen luetuinta artikkelia',
    8 => 'Artikkelin otsikko',
    9 => 'Lukukertoja',
    10 => 'N�ytt�� silt� ettei sivustolla ole artikkeleita tai kukaan ei ole koskaan niit� lukenut.',
    11 => 'Kymmenen kommentoiduinta artikkelia',
    12 => 'Kommentteja',
    13 => 'N�ytt�� silt� ettei sivustolla ole artikkeleita tai kukaan ei ole kommentoinut niit�.',
    14 => 'Kymmenen suosituinta kysely�',
    15 => 'Kyselyn aihe',
    16 => '��nt�',
    17 => 'N�ytt�� silt� ettei sivustolla ole ��nestyksi� tai kyselyit� tai ettei kukaan ole niiss� ��nest�nyt.',
    18 => 'Kymmenen suosituinta linkki�',
    19 => 'Linkki',
    20 => 'Latauksia',
    21 => 'N�ytt�� silt� ettei sivustolla ole linkkej� tai kukaan ei ole niit� ladannut.',
    22 => 'Kymmenen postitetuinta artikkelia',
    23 => 'L�hetyksi�',
    24 => 'N�ytt�� silt� ettei kukaan ole l�hett�nyt s�hk�postitse artikkeleita sivustolta.',
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
    1 => 'Aiheeseen liittyen',
    2 => 'L�het� artikkeli yst�v�lle',
    3 => 'Tulostettava versio artikkelista',
    4 => 'Artikkelien asetukset',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'L�hett��ksesi %s sinun t�ytyy olla kirjautuneena sivustolle.',
    2 => 'Kirjaudu',
    3 => 'Uusi k�ytt�j�',
    4 => 'L�het� tapahtuma',
    5 => 'L�het� linkki',
    6 => 'L�het� artikkeli',
    7 => 'Kirjautuminen vaaditaan',
    8 => 'L�het�',
    9 => 'L�hett�ess�si tietoa sivuston k�ytt��n, seuraa oheisia suosituksia...<ul><li>T�yt� kaikki kent�t<li>L�het� t�ydellist� ja paikkaansapit�v�� tietoa<li>Tuplatarkista URL-osoitteet</ul>',
    10 => 'Otsikko',
    11 => 'Linkki',
    12 => 'Aloitusp�iv�',
    13 => 'Lopetusp�iv�',
    14 => 'Sijainti',
    15 => 'Kuvaus',
    16 => 'Jos muu, tarkenna',
    17 => 'Aihealue',
    18 => 'Muu',
    19 => 'Lue ensin',
    20 => 'Virhe: aihealue puuttuu',
    21 => 'Valitessasi "Muu" sy�t� my�s aihealueen nimi',
    22 => 'Virhe: puuttuvia kentti�',
    23 => 'T�yt� kaikki kent�t lomakkeessa. Kaikki kent�t ovat pakollisia.',
    24 => 'L�hetys tallennettu',
    25 => '%s -l�hetys on tallennettu onnistuneesti.',
    26 => 'Nopeusrajoitus',
    27 => 'K�ytt�j�nimi',
    28 => 'Aihe',
    29 => 'Juttu',
    30 => 'Viimeisin l�hetyksesi oli ',
    31 => " sekuntia sitten. Sivusto vaatii v�hint��n {$_CONF['speedlimit']} sekunnin tauon l�hetysten v�lill�",
    32 => 'Esikatselu',
    33 => 'Artikkelin esikatselu',
    34 => 'Kirjaudu ulos',
    35 => 'HTML koodit eiv�t ole sallittu',
    36 => 'L�hetystila',
    37 => "L�hett�ess�si tapahtumaa sivustolle {$_CONF['site_name']} se laitetaan p��kalenteriin josta k�ytt�j�t voivat poimia tapahtumasi heid�n henkil�kohtaisiin kalentereihin. Ominaisuutta <b>EI</b> ole tarkoitettu syntym�p�ivien tai henkil�kohtaisten tapahtumien tallentamiseen. <br><br>L�hetetty�si tapahtuman se tarkistetaan yll�pidon voimin ja hyv�ksynn�n j�lkeen tapahtuma lis�t��n p��kalenteriin.",
    38 => 'Lis�� tapahtuma ',
    39 => 'P��kalenteriin',
    40 => 'Henkil�kohtaiseen kalenteriin',
    41 => 'Loppumisaika',
    42 => 'Aloitusaika',
    43 => 'Koko p�iv�n tapahtuma',
    44 => 'Osoiterivi 1',
    45 => 'Osoiterivi 2',
    46 => 'Kaupunki',
    47 => 'Osavaltio',
    48 => 'Postinumero',
    49 => 'Tapahtuman tyyppi',
    50 => 'Muokkaa tapahtumien tyyppej�',
    51 => 'Sijainti',
    52 => 'Poista',
    53 => 'Luo tili'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Tunnistus vaaditaan',
    2 => 'Ev�tty! Virheelliset kirjautumistiedot',
    3 => 'V��r� salasana k�ytt�j�lle',
    4 => 'K�ytt�j�tunnus:',
    5 => 'Salasana:',
    6 => 'Kaikki yll�pidon osioiden liikenne sivustolla kirjataan ja tarkistetaan. <br>Sivu on tarkoitettu vain sallitulle henkil�kunnalle.',
    7 => 'kirjaudu'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Riitt�m�tt�m�t yll�pidolliset valtuudet',
    2 => 'Sinulla ei ole oikeuksia muokata t�t� lohkoa.',
    3 => 'Lohkojen muokkaus',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Lohkon otsikko',
    6 => 'Aihe',
    7 => 'Kaikki',
    8 => 'Lohkon turvallisuustaso',
    9 => 'Lohkon lajittelu',
    10 => 'Lohkon tyyppi',
    11 => 'Sivuston lohko',
    12 => 'Normaali lohko',
    13 => 'Sivuston lohkojen asetukset',
    14 => 'RDF URL',
    15 => 'Viimeisin RDF p�ivitys',
    16 => 'Normaalin lohkon asetukset',
    17 => 'Lohkon sis�lt�',
    18 => 'T�yt� lohkon otsikko, turvallisuus taso sek� sis�lt� -kent�t',
    19 => 'Lohkojen hallinta',
    20 => 'Lohkon otsikko',
    21 => 'Lohkon turvataso',
    22 => 'Lohkon tyyppi',
    23 => 'Lajitteluj�rjestys',
    24 => 'Lohkon aihe',
    25 => 'Muokataksesi tai poistaaksesi lohkoa, klikkaa haluamaasi lohkoa alta. Luodaksesi uuden lohkon, klikkaa uusi lohko yl�puolelta.',
    26 => 'Ulkoasu lohko',
    27 => 'PHP lohko',
    28 => 'PHP lohkon asetukset',
    29 => 'Lohkon toiminnot',
    30 => 'Jos haluat lohkon k�ytt�v�n PHP koodia, sy�t� funktion nimi ylh��lle. Funktion tai toiminteen tulee alkaa "phpblock_" (esimerkiksi phpblock_getweather). Jos aliohjelmassa ei ole t�t� alkulausetta, funktiota ei kutsuta.  T�m� tehd��n ep�m��r�isten aliohjelmakutsujen est�miseksi jos henkil�t ovat hakkeroineet Geeklogin asennuksen. Varmista ettet laita tyhji� sulkuja "()" funktion nimen per��n. Lopuksi on suositeltavaa laittaa kaikki PHP koodisi tiedostoon /path/to/geeklog/system/lib-custom.php.  T�ll� varmistut ett� koodisi s�ilyy vaikka p�ivitt�isit Geeklogin uudempaan versioon.',
    31 => 'Virhe PHP lohkossa.  Funktio, %s, ei ole olemassa.',
    32 => 'Virhe puuttuva kentt�',
    33 => 'Sinun tulee sy�tt�� URL .rdf tiedostoon sivuston lohkoa varten',
    34 => 'Sinun tulee sy�tt�� otsikko ja funktio PHP lohkoa varten',
    35 => 'Sinun tulee sy�tt�� otsikko ja sis�lt� normaali lohkoihin',
    36 => 'Sinun tulee sy�tt�� sis�lt� ulkoasu lohkoa varten',
    37 => 'Virheellinen PHP lohkon funktion nimi',
    38 => 'PHP lohkojen funktioissa tulee olla alussa \'phpblock_\' (esim. phpblock_getweather).  \'phpblock_\' etuliite vaaditaan turvallisuuden vuoksi, h�m�r�n koodin ajamisen est�miseksi.',
    39 => 'Sivu',
    40 => 'Vasen',
    41 => 'Oikea',
    42 => 'Lajitteluj�rjestys ja turvallisuustaso tulee sy�tt�� Geeklogin oletuslohkoja varten',
    43 => 'Vain kotisivu',
    44 => 'P��sy kielletty',
    45 => "Olet yritt�m�ss� k�ytt�� lohkoa johon sinulla ei ole oikeuksia. Yritys on kirjattu lokitiedostoon.  <a href=\"{$_CONF['site_admin_url']}/block.php\">Siirry takaisin yll�pidon valikkoon</a>.",
    46 => 'Uusi lohko',
    47 => 'Yll�pidon kotisivu',
    48 => 'Lohkon nimi',
    49 => ' (ei v�lily�ntej� ja nimen tulee olla yksil�llinen)',
    50 => 'Avuste-tiedoston URL',
    51 => 'sis�llyt� http://',
    52 => 'Jos j�t�t t�m�n tyhj�ksi, avuste-ikonia ei n�ytet� t�lle lohkolle',
    53 => 'P��ll�',
    54 => 'tallenna',
    55 => 'peruuta',
    56 => 'poista',
    57 => 'Siirr� lohkoa alasp�in',
    58 => 'Siirr� lohkoa yl�sp�in',
    59 => 'Siirr� lohko oikealle puolelle',
    60 => 'Siirr� lohko vasemmalle puolelle',
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
    1 => 'Aikaisemmat artikkelit',
    2 => 'Seuraavat artikkelit',
    3 => 'Tila',
    4 => 'L�hetystila',
    5 => 'Artikkelin muokkaus',
    6 => 'Ei artikkeleja j�rjestelm�ss�',
    7 => 'Kirjoittaja',
    8 => 'tallenna',
    9 => 'esikatselu',
    10 => 'peruuta',
    11 => 'poista',
    12 => 'ID',
    13 => 'Otsikko',
    14 => 'Aihe',
    15 => 'P�iv�ys',
    16 => 'Alkuteksti',
    17 => 'Leip�teksti',
    18 => 'Osumia',
    19 => 'Kommentteja',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Lista artikkeleista',
    23 => 'Muokataksesi tai poistaaksesi artikkelin, klikkaa artikkelin numeroa. N�hd�ksesi artikkelin, klikkaa haluamaasi otsikkoa. Luodaksesi uuden artikkelin, valitse uusi artikkeli.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Artikkelin esikatselu',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'Tiedoston l�hetys-virhe',
    31 => 'T�yt� otsikko ja alkuteksti kent�t',
    32 => 'Erikoisartikkeli',
    33 => 'Vain yksi artikkeli voi olla erikoisena',
    34 => 'Vedos',
    35 => 'Kyll�',
    36 => 'Ei',
    37 => 'Lis��',
    38 => 'Lis��',
    39 => 'L�hetyksi�',
    40 => 'P��sy kielletty',
    41 => "Yrit�t ladata artikkelia johon sinulla ei ole oikeuksia. Yritys on kirjattu lokitiedostoon. Voit n�hd� artikkelin vain luku-muodossa. <a href=\"{$_CONF['site_admin_url']}/story.php\">Siirry takaisin artikkelien yll�pitoon</a> kun olet valmis.",
    42 => "Yrit�t ladata artikkelia johon sinulla ei ole oikeuksia. Yritys on kirjattu lokitiedostoon. <a href=\"{$_CONF['site_admin_url']}/story.php\">Siirry takaisin artikkelien yll�pitoon</a>.",
    43 => 'Uusi artikkeli',
    44 => 'Yll�pidon sivu',
    45 => 'K�ytt�oikeus',
    46 => '<b>HUOMAA:</b> jos muokkaat p�iv�yst� osoittamaan tulevaisuuteen, artikkelia ei julkaista ennen kyseist� p�iv��. Artikkelia ei my�sk��n sis�llytet� RDF otsikoihin, hakuihin tai tilastoihin.',
    47 => 'Kuvat',
    48 => 'kuva',
    49 => 'oikea',
    50 => 'vasen',
    51 => 'Lis�t�ksesi kuvan artikkeliin, tekstin joukkoon tulee lis�t� erikoisteksti�. Erikoistekstej� ovat [imageX], [imageX_right] tai [imageX_left] jossa X on kuvan numero jonka olet liitt�nyt. HUOMAA: Sinun tulee k�ytt�� kuvia jotka itse liit�t artikkeliin, muuten et voi tallentaa artikkelia.<BR><P><B>ESIKATSELU</B>: Esikatselu kuvien kanssa onnistuu parhaiten tallentamalla artikkeli aluksi vedoksena EIK� painamalla esikatselu-nappia. K�yt� esikatselua vain kun kuvia ei ole liitettyn�.',
    52 => 'Poista',
    53 => 'ei k�ytetty. Sinun tulee sis�llytt�� t�m� kuva alkutekstiin tai leip�tekstiin ennen kuin voit tallentaa muutokset',
    54 => 'Liitetyt kuvat joita ei k�ytetty',
    55 => 'Seuraavat virheet tapahtuivat tallennettaessa. Korjaa virheet ennen tallentamista',
    56 => 'N�yt� aihe kuvake',
    57 => 'N�yt� skaalaamaton kuva',
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
    85 => 'Show All',
    86 => 'Advanced Editor',
    87 => 'Story Stats'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Aihepiirien muokkaus',
    2 => 'Aiheen ID',
    3 => 'Aihepiirin nimi',
    4 => 'Aiheen kuva',
    5 => '(�l� k�yt� v�lily�ntej�)',
    6 => 'Aihepiirin poistaminen poistaa kaikki aihepiirin artikkelit ja lohkot jotka siihen liittyv�t',
    7 => 'T�yt� Aiheen ID ja Aihepiirin nimi -kent�t',
    8 => 'Aihepiirien hallinta',
    9 => 'Klikkaa aihepiiri� muokataksesi tai poistaaksesi aiheen. Luodaksesi uuden valitse uusi aihepiiri -nappi vasemmalta. N�et k�ytt�oikeutesi aihepiiriin suluissa. T�hti (*) merkitsee oletusaihetta.',
    10 => 'Lajitteluj�rjestys',
    11 => 'Artikkeleja/sivu',
    12 => 'P��sy kielletty',
    13 => "Olet pyrkim�ss� aiheeseen johon sinulla ei ole oikeuksia. Yritys on kirjattu lokitiedostoon. <a href=\"{$_CONF['site_admin_url']}/topic.php\">Siirry takaisin aihepiirien yll�pitoon</a>.",
    14 => 'Lajittelu tapa',
    15 => 'aakkosellinen',
    16 => 'oletus on',
    17 => 'Uusi aihepiiri',
    18 => 'Yll�pidon sivu',
    19 => 'tallenna',
    20 => 'peruuta',
    21 => 'poista',
    22 => 'Oletus',
    23 => 'tee t�st� oletus aihe uusille artikkeleille',
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
    1 => 'K�ytt�j�n muokkaus',
    2 => 'K�ytt�j�n ID',
    3 => 'K�ytt�j�tunnus',
    4 => 'Koko nimi',
    5 => 'Salasana',
    6 => 'Turvallisuustaso',
    7 => 'S�hk�posti-osoite',
    8 => 'Kotisivu',
    9 => '(�l� k�yt� v�lily�ntej�)',
    10 => 'T�yt� k�ytt�j�tunnus ja s�hk�posti-osoite kent�t',
    11 => 'K�ytt�jien hallinta',
    12 => 'Klikkaa alta jos haluat muokata tai poistaa k�ytt�j�n. Luodaksesi uuden k�ytt�j�n, valitse uusi k�ytt�j� vasemmalta. Voit tehd� yksinkertaisia hakuja sy�tt�m�ll� osan k�ytt�j�tunnuksesta, s�hk�postista tai kokonimest� allaolevaan lomakkeeseen (esimerkiksi *son* tai *.edu).',
    13 => 'Turvataso',
    14 => 'Rek.p�iv�',
    15 => 'Uusi k�ytt�j�',
    16 => 'Yll�pidon sivu',
    17 => 'vaihda salasana',
    18 => 'peruuta',
    19 => 'poista',
    20 => 'tallenna',
    21 => 'K�ytt�j�tunnus on jo olemassa.',
    22 => 'Virhe',
    23 => 'Kimppalis�ys',
    24 => 'Tuo lauma k�ytt�ji�',
    25 => 'Voit tuoda Geeklogiin suuremman m��r�n k�ytt�ji�. Tuontitiedoston tulee olla sarkain-eroteltu teksti-tiedosto jossa kenttien tulee olla seuraavassa j�rjestyksess�: koko nimi, k�ytt�j�tunnus, s�hk�posti-osoite. Tuomillesi henkil�ille postitetaan satunnaisesti generoitu salasana s�hk�postitse. Tiedostossa tulee olla yksi k�ytt�j� per rivi. Virheet tuonnissa voivat aiheuttaa ongelmia joiden selvitt�minen vaatii k�sity�t� joten tarkista sy�tteesi tarkasti!',
    26 => 'Etsi',
    27 => 'Rajoita tuloksia',
    28 => 'Klikkaa t�h�n tuhotaksesi t�m�n kuvan',
    29 => 'Polku',
    30 => 'Tuo',
    31 => 'Uudet k�ytt�j�t',
    32 => 'K�sittely valmis. Tuotiin %d ja kohdattiin %d virhett�',
    33 => 'l�het�',
    34 => 'Virhe: valitse l�hetett�v� tiedosto.',
    35 => 'Viimeksi kirjautunut',
    36 => '(ei koskaan)',
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
    1 => 'Hyv�ksy',
    2 => 'Poista',
    3 => 'Muokkaa',
    4 => 'Profiili',
    10 => 'Otsikko',
    11 => 'Aloitus p�iv�',
    12 => 'URL',
    13 => 'Aihepiiri',
    14 => 'P�iv�',
    15 => 'Aihe',
    16 => 'K�ytt�j�nimi',
    17 => 'Koko nimi',
    18 => 'S�hk�posti',
    34 => 'Komennot ja hallinta',
    35 => 'L�hetettyj� artikkeleja',
    36 => 'L�hetettyj� linkkej�',
    37 => 'L�hetettyj� tapahtumia',
    38 => 'L�het�',
    39 => 'Ei hallinnoitavia l�hetyksi� t�ll� hetkell�',
    40 => 'K�ytt�jien l�hetyksi�'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Posti Apuri",
    2 => 'L�hett�j�',
    3 => 'Vastausosoite',
    4 => 'Aihe',
    5 => 'Leip�teksti',
    6 => 'Kenelle l�hetet��n:',
    7 => 'Kaikille k�ytt�jille',
    8 => 'Yll�pito',
    9 => 'Vaihtoehdot',
    10 => 'HTML',
    11 => 'T�rke� viesti!',
    12 => 'L�het�',
    13 => 'Tyhjenn�',
    14 => 'Ohita k�ytt�jien asetukset',
    15 => 'Virhe l�hetett�ess�: ',
    16 => 'L�hetykset tehty onnistuneesti: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>L�het� toinen viesti</a>",
    18 => 'Vastaanottaja',
    19 => 'HUOMAA: jos haluat l�hett�� viestin sivuston kaikille j�senille, valitse kirjautuneet k�ytt�j�t -ryhm� pudotusvalikosta.',
    20 => "Onnistuneesti l�hetetty <successcount> viesti� ja ep�onnistuttu <failcount> viestin l�hetyksess�. Tarvittaessa kaikkien viestil�hetyksien tiedot l�ytyv�t alta. Muuten voit l�hett�� <a href=\"{$_CONF['site_admin_url']}/mail.php\">seuraavan viestin</a> tai <a href=\"{$_CONF['site_admin_url']}/moderation.php\">siirty� takaisin hallinnon sivulle</a>.",
    21 => 'ep�onnistumisia',
    22 => 'onnistumisia',
    23 => 'Ei ep�onnistumisia',
    24 => 'Ei onnistumisia',
    25 => '-- Valitse ryhm� --',
    26 => 'T�yt� kaikki kent�t lomakkeesta ja valitse kohdek�ytt�jien ryhm� pudotusvalikosta.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Laajennusten asentaminen voi vahingoittaa Geeklogia ja mahdollisesti j�rjestelm��si. K�yt� vain <a href="http://www.geeklog.net" target="_blank">Geeklogin kotisivulta</a> ladattuja laajennuksia, koska testaamme sivustollemme l�hetetyt laajennukset usealla k�ytt�j�rjestelm�ll�. On t�rke�� ymm�rt�� laajennuksien asentamisen vaativan joidenkin k�ytt�j�rjestelmi�k�skyjen ajamisen, jotka voivat johtaa turvallisuusongelmiin, varsinkin kolmansien osapuolien laajennusten tapauksessa. Vaikka varoitammekin k�ytt�ji� laajennuksista, emme takaa asennuksen onnistumista emmek� ota vastuuta Geeklogin laajennusten aiheuttamista vahingoista. Toisinsanoen, asenna n�it� omalla vastuullasi. Varovaisille; k�sin tapahtuvaan asennukseen tulee ohjeet jokaisessa laajennuspaketissa.',
    2 => 'Huomioi laajennuksia asentaessasi',
    3 => 'Laajennuksien asentamislomake',
    4 => 'Laajennustiedosto',
    5 => 'Lista laajennuksista',
    6 => 'Varoitus: laajennus on jo asennettu!',
    7 => 'Laajennus jonka asentamista yrit�t, on jo asennettu. Poista laajennus ennen sen uudelleenasentamista',
    8 => 'Laajennuksen yhteensopivuustesti ep�onnistui',
    9 => 'Laajennus vaatii uudemman version Geeklogista. P�ivit� <a href="http://www.geeklog.net">Geeklog-j�rjestelm�si</a> tai hanki uudempi versio laajennuksesta.',
    10 => '<br><b>Laajennuksia ei ole t�ll� hetkell� asennettuna.</b><br><br>',
    11 => 'Muokataksesi tai poistaaksesi laajennuksen, valitse laajennuksen numero. Halutessasi lis�tietoja laajennuksesta, valitse laajennuksen nimi alta ja sinut ohjataa laajennuksen kotisivulle. Asentaaksesi tai p�ivitt��ksesi laajennuksen, lue laajennuksen dokumentaatio.',
    12 => 'laajennuksen nime� ei ole l�hetetty plugineditor()',
    13 => 'Laajennusten muokkain',
    14 => 'Uusi laajennus',
    15 => 'Hallinnon sivu',
    16 => 'Laajennuksen nimi',
    17 => 'Laajennuksen versio',
    18 => 'Geeklogin versio',
    19 => 'P��ll�',
    20 => 'Kyll�',
    21 => 'Ei',
    22 => 'Asenna',
    23 => 'Tallenna',
    24 => 'Peruuta',
    25 => 'Poista',
    26 => 'Laajennuksen nimi',
    27 => 'Laajennuksen kotisivu',
    28 => 'Laajennuksen versio',
    29 => 'Geeklogin versio',
    30 => 'Poista laajennus?',
    31 => 'Oletko varma ett� haluat poistaa laajennuksen? Poistamalla poistat my�s kaiken tiedot ja tietorakenteen jotka liittyv�t t�h�n laajennukseen. Jos olet varma, valitse poista uudelleen alta l�ytyv�st� lomakkeesta.',
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
    1 => 'luo sy�te',
    2 => 'tallenna',
    3 => 'poista',
    4 => 'peruuta',
    10 => 'Sis�ll�n syndikointi',
    11 => 'Uusi sy�te',
    12 => 'Yll�pidon sivu',
    13 => 'Poistaaksesi tai muokataksesi sy�tett�, valitse sy�tteen otsikko. Luodaksesi uuden sy�tteen, valitse Uusi sy�te ylt�.',
    14 => 'Otsikko',
    15 => 'Tyyppi',
    16 => 'Tiedosto',
    17 => 'Muoto',
    18 => 'viimeksi p�ivitetty',
    19 => 'Sallittu',
    20 => 'Kyll�',
    21 => 'Ei',
    22 => '<i>(ei sy�tteit�)</i>',
    23 => 'kaikki artikkelit',
    24 => 'Sy�tteiden muokkain',
    25 => 'Sy�tteen otsikko',
    26 => 'Rajoitus',
    27 => 'Sis�ll�n pituus',
    28 => '(0 = ei teksti�, 1 = koko teksti, muu = rajoita sy�tt�m��si m��r��n merkkej�.)',
    29 => 'Kuvaus',
    30 => 'Viimeisin p�ivitys',
    31 => 'Merkkilaji',
    32 => 'Kieli',
    33 => 'Sis�lt�',
    34 => 'Kirjauksia',
    35 => 'Tuntia',
    36 => 'Valitse sy�tteen tyyppi',
    37 => 'V�hint��n yksi sy�tett� tai sis�ll�n jakamista tukeva laajennus on asennettu. Alta voit valita haluatko luoda sy�tteen Geeklogista vai jostain laajennuksesta.',
    38 => 'Virhe: puuttuvia kentti�',
    39 => 'T�yt� sy�tteen otsikko, kuvaus ja tiedoston nimi.',
    40 => 'Sy�t� kirjauksien m��r� tai tuntien lukum��r�.',
    41 => 'Linkit',
    42 => 'Tapahtumat',
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
    1 => "Salasanasi on l�hetetty s�hk�postitse ja pit�isi saapua sinulle hetken kuluttua. Seuraa viestiss� olevia ohjeita. Kiit�mme sivuston {$_CONF['site_name']} k�yt�st�.",
    2 => "Kiitokset artikkelin l�hett�misest� sivustolle {$_CONF['site_name']}.  Yll�pito tarkistaa ja l�pik�y sen ja se tulee hyv�ksymisen j�lkeen lukijoiden n�kyville sivustolle.",
    3 => "Kiitokset linkin l�hett�misest� sivustolle {$_CONF['site_name']}.  Yll�pito tarkistaa sen ja linkki tulee hyv�ksymisen j�lkeen <a href={$_CONF['site_url']}/links.php>linkit</a>-osioon sivustolla.",
    4 => "Kiitokset tapahtuman l�hett�misest� sivustolle{$_CONF['site_name']}.  Yll�pito tarkistaa sen ja hyv�ksymisen j�lkeen tapahtuma on n�kyviss� <a href={$_CONF['site_url']}/calendar.php>kalenteri</a>-osiossa.",
    5 => 'Tilisi tiedot ovat tallennettu.',
    6 => 'N�ytt�asetuksesi ovat tallennettu.',
    7 => 'Kommennttisi asetukset ovat tallennettu.',
    8 => 'Olet kirjautunut ulos.',
    9 => 'Artikkelisi on tallennettu.',
    10 => 'Artikkelisi on poistettu.',
    11 => 'Lohko on tallennettu.',
    12 => 'Lohko on poistettu.',
    13 => 'Aiheesi on tallennettu.',
    14 => 'Aihe ja kaikki sen artikkelit ja lohkot ovat poistettu.',
    15 => 'Linkki on tallennettu.',
    16 => 'Linkki on poistettu.',
    17 => 'Tapahtuma on tallennettu.',
    18 => 'Tapahtuma on poistettu.',
    19 => 'Kysely on tallennettu.',
    20 => 'Kysely on poistettu.',
    21 => 'Uusi k�ytt�j� on tallennettu.',
    22 => 'K�ytt�j� on poistettu.',
    23 => 'Virhe lis�tt�ess� tapahtumaa kalenteriisi. Ei tapahtuman id:t�.',
    24 => 'Tapahtuma on tallennettu kalenteriisi',
    25 => 'Henkil�kohtaista kalenteria ei voi avata ennen sis��nkirjautumista',
    26 => 'Tapahtuma on poistettu omasta kalenteristasi',
    27 => 'Viesti l�hetetty onnistuneesti.',
    28 => 'Laajennus on tallennettu',
    29 => 'Omat kalenterit eiv�t ole sallittuja t�ll� sivustolla',
    30 => 'P��sy kielletty',
    31 => 'Sinulla ei ole p��sy� artikkelien hallinnan sivulle. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    32 => 'Sinulla ei ole p��sy� aiheiden hallintaan. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    33 => 'Sinulla ei ole p��sy� lohkojen hallintaan. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    34 => 'Sinulla ei ole p��sy� linkkien hallintaan. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    35 => 'Sinulla ei ole p��sy� tapahtumien hallintaan. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    36 => 'Sinulla ei ole p��sy� kyselyjen hallintaan. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    37 => 'Sinulla ei ole p��sy� k�ytt�jien hallintaan. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    38 => 'Sinulla ei ole p��sy� laajennusten hallintaan. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    39 => 'Sinulla ei ole p��sy� s�hk�postin hallintaan. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    40 => 'J�rjestelm�n viesti',
    41 => 'Sinulla ei ole p��sy� sanojen korvauksen sivulle. Huomaa ett� yritykset kirjataan lokitiedostoon',
    42 => 'Sanasi on tallennettu.',
    43 => 'Sana on poistettu.',
    44 => 'Laajennus on onnistuneesti asennettu!',
    45 => 'Laajennus on poistettu.',
    46 => 'Sinulla ei ole oikeuksia tietokannan varmistukseen. Huomaa ett� kaikki yritykset kirjataan lokitiedostoon',
    47 => 'T�m� toiminto toimii vain *nix j�rjestelmiss�.  Jos k�ytt�j�rjestelm�si on *nix, v�limuisti on tyhjennetty. Jos k�ytt�j�rjestelm�si on Windows, joudut etsim��n tiedostot adodb_*.php ja poistamaan ne k�sin.',
    48 => "Kiitos j�senhakemuksestasi sivustolle {$_CONF['site_name']}. Yll�pito k�y l�pi hakemuksesi. Hyv�ksymisen j�lkeen salasanasi l�hetet��n antamaasi s�hk�postiosoitteeseen.",
    49 => 'Ryhm� on tallennettu.',
    50 => 'Ryhm� on poistettu.',
    51 => 'K�ytt�j�nimi on jo k�yt�ss�. Valitse toinen k�ytt�j�nimi.',
    52 => 'Sy�tt�m�si s�hk�postiosoite ei ole oikea.',
    53 => 'Uusi salasanasi on hyv�ksytty. K�yt� uutta salasanaasi kirjautuessasi nyt sis��n.',
    54 => 'Pyynt�si uuden salasanan saamiseksi on ik��ntynyt. Yrit� uudestaan alta.',
    55 => 'S�hk�postiviesti on l�hetetty sinulle ja sen pit�isi saapua hetken p��st�. Seuraa viestin ohjeita asettaaksesi uuden salasanan tilillesi.',
    56 => 'Sy�tt�m�si s�hk�postiosoite on jo k�yt�ss� toisella tilill�.',
    57 => 'Tilisi on poistettu.',
    58 => 'Sy�tteesi on tallennettu.',
    59 => 'Sy�te on poistettu.',
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
    'access' => 'P��sy',
    'ownerroot' => 'Omistaja/Root',
    'group' => 'Ryhm�',
    'readonly' => 'Vain luku',
    'accessrights' => 'K�ytt�oikeudet',
    'owner' => 'Omistaja',
    'grantgrouplabel' => 'Salli ryhm�lle muokkaus oikeudet',
    'permmsg' => 'HUOMAA: j�senet tarkoittavat kaikkia sivustolle kirjautuneita henkil�it� ja tuntematon tarkoittaa kaikkia sivustolla selailevia k�ytt�ji� jotka eiv�t ole kirjautuneet sis��n.',
    'securitygroups' => 'Turvallisuus ryhm�t',
    'editrootmsg' => "Vaikka olet k�ytt�jien yll�pit�j�, et voi muokata p��k�ytt�j�� olematta itse p��k�ytt�j�. Voit muokata muita k�ytt�ji� paitsi p��yll�pit�j��. Huomaa ett� kaikki yritykset laittomasti muokata p��k�ytt�ji� kirjoitetaan lokitiedostoon. Siirry takaisin <a href=\"{$_CONF['site_admin_url']}/user.php\">k�ytt�jien yll�pitoon</a>.",
    'securitygroupsmsg' => 'Rastita ruudut niist� ryhmist� joihin haluat k�ytt�j�n kuuluvan.',
    'groupeditor' => 'Ryhmien muokkaus',
    'description' => 'Kuvaus',
    'name' => 'Nimi',
    'rights' => 'Oikeudet',
    'missingfields' => 'Puuttuvat kent�t',
    'missingfieldsmsg' => 'Sy�t� ryhm�n nimi ja kuvaus',
    'groupmanager' => 'Ryhmien hallinta',
    'newgroupmsg' => 'Muokataksesi tai poistaaksesi ryhm�n, valitse ryhm� alta. Luodaksesi uuden ryhm�n, valitse uusi ryhm� ylt�. Huomaa ett� ydinryhmi� ei voi poistaa koska ne ovat j�rjestelm�n k�yt�ss�.',
    'groupname' => 'Ryhm�n nimi',
    'coregroup' => 'Ydin ryhm�',
    'yes' => 'Kyll�',
    'no' => 'Ei',
    'corerightsdescr' => "Ryhm� kuuluu sivuston {$_CONF['site_name']} ydin ryhm��n. Ryhm�n oikeuksia ei voi siit� syyst� muokata. Alla on lista ryhm�n oikeuksista vain lukemista varten.",
    'groupmsg' => 'Turvallisuus ryhm�t sivustolla ovat hierarkiset. Muokkaamalla t�t� ryhm�� tai jotain alla olevista ryhmist� antaa t�lle ryhm�lle samat oikeudet kuin muille alla oleville ryhmille. Milloin se on mahdollista, suosittelemme k�ytt�m��n allaolevia ryhmi� oikeuksie jakamiseen t�lle ryhm�lle. Jos tarvitset muokattuja oikeuksia, voit valita oikeudet sivuston eri toimintoihin alta l�ytyv�st� \'Oikeudet\'-kohdasta. Lis�t�ksesi t�m�n ryhm�n johonkin allaolevista ryhmist�, merkitse rasti ryhm�n tai ryhmien viereen.',
    'coregroupmsg' => "T�m� ryhm� on ydinryhm� sivustolla {$_CONF['site_name']}.  T�st� johtuen ryhm�� ei voi muokata. Alla on lista vain luku-muodossa ryhmist� joihin t�m� ryhm� kuuluu.",
    'rightsdescr' => 'Ryhm� saa oikeutensa joko olemalla osana toista ryhm�� TAI ryhm�lle voi antaa suoraan haluamasi oikeudet. Alla olevat oikeudet joissa ei ole rastiruutua, ovat oikeuksia jotka ryhm� on saanut olemalla osa jotain toista ryhm�� jolla nuo oikeudet ovat. Ne joissa on laatikko vieress� ovat oikeuksia joita ryhm�lle voidaan suoraan my�nt��.',
    'lock' => 'Lukittu',
    'members' => 'J�senet',
    'anonymous' => 'Tuntematon',
    'permissions' => 'Oikeudet',
    'permissionskey' => 'L = luku, M = muokkaa, muokkaus-oikeudet olettavat my�s luku oikeuksien l�ytyv�n',
    'edit' => 'Muokkaa',
    'none' => 'Ei yht��n',
    'accessdenied' => 'P��sy kielletty',
    'storydenialmsg' => "Sinulla ei ole oikeuksia katsoa artikkelia. Oletko varmasti j�senen� sivustolla {$_CONF['site_name']}? <a href=users.php?mode=new>Rekister�idy j�seneksi</a> sivustolle {$_CONF['site_name']} saadaksesi t�ydet j�senyyden suomat oikeudet!",
    'nogroupsforcoregroup' => 'Ryhm� ei kuulu mihink��n muuhun ryhm��n',
    'grouphasnorights' => 'Ryhm�ll� ei ole hallinnointi oikeuksia sivustolla.',
    'newgroup' => 'Uusi ryhm�',
    'adminhome' => 'Yll�pidon sivu',
    'save' => 'tallenna',
    'cancel' => 'peruuta',
    'delete' => 'poista',
    'canteditroot' => 'Olet yritt�nyt muokata Omistajien ryhm��, mutta et kuulu itse ryhm��n, niinp� sinulta on p��sy ryhm��n kielletty. Ota yhteytt� j�rjestelm�n yll�pitoon jos uskot t�m�n olevan virhe',
    'listusers' => 'Listaa k�ytt�j�t',
    'listthem' => 'lista',
    'usersingroup' => 'K�ytt�j�t ryhm�ss� %s',
    'usergroupadmin' => 'K�ytt�j�ryhmien yll�pito',
    'add' => 'Lis��',
    'remove' => 'Poista',
    'availmembers' => 'Saatavilla olevat j�senet',
    'groupmembers' => 'Ryhm�n j�senet',
    'canteditgroup' => 'Sinun tulee olla ryhm�n j�sen muokataksesi t�t� ryhm��. Jos t�m� tuntuu virheelt�, ota yhteytt� j�rjestelm�n yll�pitoon.',
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
    'last_ten_backups' => 'Viimeiset 10 varmuuskopiota',
    'do_backup' => 'Tee varmuuskopio',
    'backup_successful' => 'Tietokannan varmistus onnistui.',
    'db_explanation' => 'Luodaksesi uuden varmuuskopion Geeklogista, klikkaa alta l�ytyv�� nappia',
    'not_found' => "Viallinen polku tai mysqldump apuohjelma ei ole suoritettavissa.<br>Tarkista <strong>\$_DB_mysqldump_path</strong> m��ritys config.php -tiedostossa.<br>Muuttujan nykyinen m��rittely: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Varmuuskopiointi ep�onnistui: tiedoston koko 0 tavua',
    'path_not_found' => "{$_CONF['backup_path']} ei ole olemassa tai ei ole hakemisto",
    'no_access' => "VIRHE: Hakemisto {$_CONF['backup_path']} ei ole saatavilla.",
    'backup_file' => 'Tee varmuuskopio',
    'size' => 'Koko',
    'bytes' => 'tavua',
    'total_number' => 'Varmistuksia yhteens�: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Etusivu',
    2 => 'Yhteystiedot',
    3 => 'Julkaise',
    4 => 'Linkit',
    5 => 'Kyselyt',
    6 => 'Kalenteri',
    7 => 'Sivuston tilastot',
    8 => 'Mukauta',
    9 => 'Etsi',
    10 => 'laajennettu haku',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Virhe',
    2 => 'Oho, etsin kaikkialta, mutten l�yt�nyt <b>%s</b>.',
    3 => "<p>Pahoittelumme mutta emme l�yd� haluamaasi tiedostoa. Katso sivuston <a href=\"{$_CONF['site_url']}\">p��sivu</a> tai sivuston <a href=\"{$_CONF['site_url']}/search.php\">hakusivu</a> l�yt��ksesi mit� olet hukannut."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Kirjautuminen vaaditaan',
    2 => 'T�m� alue vaatii sis��nkirjautumisen k�ytt�j�n�.',
    3 => 'Kirjaudu',
    4 => 'Uusi k�ytt�j�'
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
    1 => 'Tammikuu',
    2 => 'Helmikuu',
    3 => 'Maaliskuu',
    4 => 'Huhtikuu',
    5 => 'Toukokuu',
    6 => 'Kes�kuu',
    7 => 'Hein�kuu',
    8 => 'Elokuu',
    9 => 'Syyskuu',
    10 => 'Lokakuu',
    11 => 'Marraskuu',
    12 => 'Joulukuu'
);

###############################################################################
# Weekdays

$LANG_WEEK = array(
    1 => 'Sunnuntai',
    2 => 'Maanantai',
    3 => 'Tiistai',
    4 => 'Keskiviikko',
    5 => 'Torstai',
    6 => 'Perjantai',
    7 => 'Lauantai'
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