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
# Converted to Unicode (UTF-8) by Samuel Stone <sam@stonemicro.com>
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
    1 => 'Kirjoittaja:',
    2 => 'lue lisää',
    3 => 'kommentti(a)',
    4 => 'Muokkaa',
    5 => 'Äänestä',
    6 => 'Tulokset',
    7 => 'Äänestyksen tulokset',
    8 => 'ääntä',
    9 => 'Ylläpidon toiminnot:',
    10 => 'Lähetyksiä',
    11 => 'Artikkeleja',
    12 => 'Blokkeja',
    13 => 'Aiheita',
    14 => 'Linkkejä',
    15 => 'Tapahtumia',
    16 => 'Äänestyksiä',
    17 => 'Käyttäjiä',
    18 => 'SQL kysely',
    19 => 'Kirjaudu ulos',
    20 => 'Käyttäjän tiedot:',
    21 => 'Käyttäjän nimi',
    22 => 'Tunnus',
    23 => 'Turvallisuustaso',
    24 => 'Tuntematon',
    25 => 'Vastaa',
    26 => 'Oheiset kommentit ovat kirjoittajiensa omaisuutta. Sivusto ei ole vastuussa kirjoittajien sanomisista.',
    27 => 'Uusin kirjoitus',
    28 => 'Poista',
    29 => 'Ei käyttäjän lähettämiä kommentteja',
    30 => 'Vanhemmat artikkelit',
    31 => 'Sallitut HTML tagit:',
    32 => 'Virhe, virheellinen käyttäjänimi',
    33 => 'Virhe, logiin ei voi kirjoittaa',
    34 => 'Virhe',
    35 => 'Kirjaudu ulos',
    36 => 'on',
    37 => 'Ei käyttäjän kirjoituksia',
    38 => 'Content Syndication',
    39 => 'Virkistä',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Vieraita sivustolla',
    42 => 'Tekijä:',
    43 => 'Vastaa tähän',
    44 => 'Edellinen',
    45 => 'MySQL virhe numeroltaan',
    46 => 'MySQL virhe viesti',
    47 => 'Käyttäjän toiminnot',
    48 => 'Omat tiedot',
    49 => 'Asetukset',
    50 => 'Virhe SQL lauseessa',
    51 => 'apua',
    52 => 'Uusi',
    53 => 'Ylläpito',
    54 => 'Tiedostoa ei voinut avata.',
    55 => 'Virhe',
    56 => 'Äänestä',
    57 => 'Salasana',
    58 => 'Kirjaudu',
    59 => "Ei tunnusta vielä? Kirjaudu <a href=\"{$_CONF['site_url']}/users.php?mode=new\">uutena käyttäjänä</a>",
    60 => 'Lähetä kommentti',
    61 => 'Luo uusi käyttäjätili',
    62 => 'sanaa',
    63 => 'Kommenttien asetukset',
    64 => 'Lähetä artikkeli sähköpostitse ystävälle',
    65 => 'Näytä tulostettava versio',
    66 => 'Oma kalenteri',
    67 => 'Tervetuloa sivustolle',
    68 => 'etusivu',
    69 => 'yhteystiedot',
    70 => 'etsi',
    71 => 'lähetä artikkeli',
    72 => 'verkkoresurssit',
    73 => 'aikaisemmat äänestykset',
    74 => 'kalenteri',
    75 => 'laajennettu etsintä',
    76 => 'sivuston tilastot',
    77 => 'Laajennukset',
    78 => 'Tulevat tapahtumat',
    79 => 'Uutta sivustolla',
    80 => 'artikkelia viimeiseen',
    81 => 'artikkeli viimeiseen',
    82 => 'tuntiin',
    83 => 'KOMMENTIT',
    84 => 'LINKIT',
    85 => 'viimeisenä 48 tuntina',
    86 => 'Ei uusia kommentteja',
    87 => 'viimeiseen 2 viikkoon',
    88 => 'Ei uusia linkkejä',
    89 => 'Ei tulevia tapahtumia',
    90 => 'Etusivu',
    91 => 'Sivu luotu ',
    92 => 'sekunnissa',
    93 => 'Copyright',
    94 => 'All trademarks and copyrights on this page are owned by their respective owners.',
    95 => 'Moottorina toimii',
    96 => 'Ryhmiä',
    97 => 'Sana lista',
    98 => 'Laajennuksia',
    99 => 'ARTIKKELIT',
    100 => 'Ei uusia artikkeleita',
    101 => 'Omat tapahtumat',
    102 => 'Sivuston tapahtumat',
    103 => 'DB varmuuskopiointi',
    104 => 'by',
    105 => 'Sähköpostia käyttäjille',
    106 => 'Katselukertoja',
    107 => 'GL versiotesti',
    108 => 'Tyhjennä välimuisti',
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
    1 => 'Tapahtumakalenteri',
    2 => 'Ei näytettäviä tapahtumia.',
    3 => 'Milloin',
    4 => 'Missä',
    5 => 'Kuvaus',
    6 => 'Lisää tapahtuma',
    7 => 'Tulevat tapahtumat',
    8 => 'Lisäämällä tapahtuman kalenteriisi voit nopeasti nähdä itseäsi kiinnostavat tapahtumat valitsemalla "Oma kalenteri" käyttäjän toiminnoista.',
    9 => 'Lisää omaan kalenteriin',
    10 => 'Poista omasta kalenterista',
    11 => "Lisään tapahtuman {$_USER['username']}:n kalenteriin",
    12 => 'Tapahtuma',
    13 => 'Alkaa',
    14 => 'Loppuu',
    15 => 'Paluu kalenteriin'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Lähetä kommentti',
    2 => 'Lähetyksen muoto',
    3 => 'Kirjaudu ulos',
    4 => 'Luo käyttäjätili',
    5 => 'Käyttäjänimi',
    6 => 'Sivustolle voi lähettää kommentteja vain rekisteröityneet käyttäjät. Jos sinulla ei ole käyttäjätiliä sivustolla, voit tehdä tilin käyttämällä alla olevaa lomaketta.',
    7 => 'Viimeisin kommenttisi kirjoitettiin ',
    8 => " sekuntia sitten. Sivusto vaatii vähintään {$_CONF['commentspeedlimit']} sekuntia kommenttien välillä",
    9 => 'Kommentti',
    10 => 'Send Report',
    11 => 'Lähetä kommentti',
    12 => 'Täytä otsikko ja kommentti -kentät, ne ovat pakollisia kommenttia lähetettäessä.',
    13 => 'Omat tietosi',
    14 => 'Esikatselu',
    15 => 'Report this post',
    16 => 'Otsikko',
    17 => 'Virhe',
    18 => 'Tärkeitä huomioita',
    19 => 'Yritä pysyä aiheessa.',
    20 => 'Pyri vastaamaan muiden lähettämiin kommentteihin uuden kommenttisäikeen aloittamisen sijaan.',
    21 => 'Lue muiden lähettämät viestit ennen oman kommentin postittamista toiston estämiseksi.',
    22 => 'Nimeä viesti selkeästi ja kuvaavasti.',
    23 => 'Sähköpostiosoitteesi EI tule julkisesti näkyville.',
    24 => 'Tuntematon käyttäjä',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Tiedot käyttäjästä',
    2 => 'Käyttäjän nimi',
    3 => 'Koko nimi',
    4 => 'Salasana',
    5 => 'Sähköposti',
    6 => 'Kotisivu',
    7 => 'Tiedot',
    8 => 'PGP avain',
    9 => 'Tallenna tiedot',
    10 => 'Viimeiset 10 kommenttiä käyttäjältä',
    11 => 'Ei käyttäjän lähettämiä kommentteja',
    12 => 'Asetukset käyttäjälle',
    13 => 'Lähetä päivittäinen yhteenveto sähköpostitse',
    14 => 'Tämä salasana on satunnaisgeneraattorin tuottama. On suositeltavaa vaihtaa salasana toiseen välittömästi. Vaihtaaksesi salasanan, kirjaudu sivustolle ja valitse Omat tiedot käyttäjän toiminnoista.',
    15 => "{$_CONF['site_name']} käyttäjätili on luotu. Käyttääksesi tiliä, kirjaudu sisään allaolevin tiedoin. Säästä tämä sähköposti tulevaa käyttöä varten.",
    16 => 'Omat tiedot',
    17 => 'Tiliä ei ole olemassa',
    18 => 'Sähköposti-osoite ei ole tunnu olevan oikeanmuotoinen osoite',
    19 => 'Syötetty käyttäjänimi tai sähköposti ovat jo käytössä',
    20 => 'Sähköposti-osoite ei ole oikea sähköposti-osoite',
    21 => 'Virhe',
    22 => "Rekisteröidy sivustolle {$_CONF['site_name']}!",
    23 => "Luomalla sivustolle {$_CONF['site_name']} käyttäjätilin voit itse lähettää artikkeleita tai kommentteja. Ilman tiliä voit lähettää viestejä vain tuntemattomana. Huomaa että sähköpostiosoitettasi ei <b><i>koskaan</i></b> näytetä julkisesti sivustolla.",
    24 => 'Salasanasi lähetetään syöttämääsi sähköpostiosoitteeseen.',
    25 => 'Unohditko salasanasi?',
    26 => 'Syötä <em>joko</em> käyttäjänimesi <em>tai</em> sähköposti-osoitteesi jotka syötit rekisteröityessäsi ja valitse Lähetä salasana. Ohjeet uuden salasanan asettamiseksi lähetetään sähköpostitse tilin osoitteeseen.',
    27 => 'Rekisteröidy!',
    28 => 'Lähetä salasana',
    29 => 'kirjauduit ulos sivustolta',
    30 => 'kirjauduit sisään sivustolle',
    31 => 'Toiminto vaatii rekisteröitymistä',
    32 => 'Allekirjoitus',
    33 => 'Ei julkisesti näkyvä',
    34 => 'Oikea nimesi',
    35 => 'Kirjoita uusi salasana jos haluat vaihtaa vanhan',
    36 => 'Alkaa http://',
    37 => 'Lisätty kommentteihisi',
    38 => 'Kaikki elämästäsi! Kaikki voivat lukea tämän',
    39 => 'Julkinen PGP avain jaettavaksi',
    40 => 'Ei aiheiden kuvakkeita',
    41 => 'Halukas moderoijaksi',
    42 => 'Päiväyksen muoto',
    43 => 'Artikkelien maksimimäärä',
    44 => 'Ei laatikkoja',
    45 => 'Näytä asetukset tilille',
    46 => 'Poisjätettävät kohteet tilille',
    47 => 'Uutislaatikon asetukset tilille',
    48 => 'Aiheet',
    49 => 'Ei kuvakkeita artikkeleissa',
    50 => 'Poista rasti jos et ole kiinnostunut',
    51 => 'Vain uutiset',
    52 => 'Oletus on',
    53 => 'Vastaanota päivän tarina joka yö',
    54 => 'Valitse aiheet ja kirjoittajat joita et halua nähdä.',
    55 => 'Jättämällä kaikki laatikot valitsematta, käytetään oletusarvoja. Jos alat rastittamaan valintoja, muista valita kaikki haluamasi, koska oletusarvot ohitetaan. Oletusarvot näytetään lihavoituina.',
    56 => 'Kirjoittajat',
    57 => 'Näyttötila',
    58 => 'Lajittelujärjestys',
    59 => 'Kommenttien rajoitus',
    60 => 'Miten haluat kommenttisi näytettävän?',
    61 => 'Uusimmat vai vanhimmat ensin?',
    62 => 'Oletus on 100',
    63 => "Salasanasi on lähetetty sähköpostitse. Seuraa viestissä olevia ohjeita ja kiitos kun käytät sivustoa {$_CONF['site_name']}",
    64 => 'Kommenttien astukset käyttäjälle',
    65 => 'Yritä kirjautua uudestaan',
    66 => "Kirjoitit sisäänkirjautuessa jotain väärin. Yritä kirjautua uudelleen. Oletko <a href=\"{$_CONF['site_url']}/users.php?mode=new\">uusi käyttäjä</a>?",
    67 => 'Liittynyt',
    68 => 'Säilytä tiedot',
    69 => 'Kuinka kauan sivuston tulee muistaa tietosi kirjautumisen jälkeen?',
    70 => "Muokkaa ulkoasua ja asetuksia sivustolle {$_CONF['site_name']}",
    71 => "Yksi tämän sivuston ({$_CONF['site_name']}) parhaista ominaisuuksista on muokattavuus - voit muokata haluamasi ulkoasun ja sisällön sivustolle. Hyödyntääksesi ominaisuuksia sinun tulee ensiksi <a href=\"{$_CONF['site_url']}/users.php?mode=new\">rekisteröityä</a> sivustolle {$_CONF['site_name']}.  Oletko jo rekisteröitynyt? Kirjaudu sisään käyttäen vasemmalla olevaa lomaketta!",
    72 => 'Teema',
    73 => 'Kieli',
    74 => 'Vaihda sivuston ulkoasua!',
    75 => 'Sähköpostitse lähetettävät uutiset',
    76 => 'Valitsemalla aiheet alla olevasta listasta, saat uudet aiheisiin liittyvät uutiset sähköpostitse itsellesi kerran päivässä. Valitse vain aiheet joista olet kiinnostunut!',
    77 => 'Kuva',
    78 => 'Lisää kuva itsestäsi!',
    79 => 'Rastita tämä poistaaksesi kuvan',
    80 => 'Kirjaudu',
    81 => 'Lähetä sähköpostitse',
    82 => 'Viimeiset 10 tarinaa käyttäjältä',
    83 => 'Tilastot kirjoituksista käyttäjältä',
    84 => 'Artikkeleita yhteensä:',
    85 => 'Kommentteja yhteensä:',
    86 => 'Etsi kaikki postitukset käyttäjältä',
    87 => 'Nimesi jolla olet kirjautunut',
    88 => "Joku (mahdollisesti sinä itse) on pyytänyt uutta salasanaa tilillesi \"%s\" sivustolla {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nJos haluat vaihtaa salasanan, valitse seuraava linkki:\n\n",
    89 => "Jos et halua tehdä näin, ohita tämä viesti ja pyyntö evätään (salasanasi pysyy muuttumattomana).\n\n",
    90 => 'Voit kirjoittaa tilisi uuden salasanan alle, Huomaa että vanha salasanasi on yhä voimassa kunnes lähetät tämän lomakkeen.',
    91 => 'Aseta uusi salasana',
    92 => 'Kirjoita uusi salasana',
    93 => 'Edellinen pyyntösi salasanan vaihtamiseksi tapahtui %d sekuntia sitten. Sivusto vaatii ainakin %d sekunnin viiveen vaihtojen välillä.',
    94 => 'Poista tili "%s"',
    95 => 'Valitse "poista tili" nappi alta poistaaksesi tietosi tietokannasta. Huomaa että kaikki postittamasi artikkelit ja kommentit <strong>eivät</strong> poistu, mutta niiden kirjoittajaksi merkitään "tuntematon".',
    96 => 'poista tili',
    97 => 'Vahvista tilin poistaminen',
    98 => 'Oletko varma että haluat poistaa tilisi? Poistamalla käyttäjätilin et voi kirjautua sivustolle uudestaan (paitsi tekemällä uuden tilin). Jos olet varma, valitse "poista tili" alta.',
    99 => 'Yksityisyyden vaihtoehdot tilille',
    100 => 'Ylläpidon viestit',
    101 => 'Salli ylläpidon lähettämät sähköpostit',
    102 => 'Käyttäjien viestit',
    103 => 'Salli muiden käyttäjien lähettämät sähköpostit',
    104 => 'Näytä linjalla -tila',
    105 => 'Näy Ketä on linjalla -lohkossa',
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
    1 => 'Ei näytettäviä uutisia',
    2 => 'Ei näytettäviä uutisiä. Joko aiheesta ei ole uutisia tai asetuksesi voivat olla liian rajoittavia',
    3 => ' aiheesta %s',
    4 => 'Päivän artikkeli',
    5 => 'Seuraava',
    6 => 'Edellinen',
    7 => 'First',
    8 => 'Last'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Virhe viestiä lähetettäessä. Yritä uudelleen.',
    2 => 'Viesti lähetetty onnistuneesti.',
    3 => 'Varmista että vastausosoite-kentässä on oikea sähköpostiosoite.',
    4 => 'Täytä nimesi, vastausosoite, aihe sekä viesti-kentät',
    5 => 'Virhe: valittua käyttäjää ei löydy.',
    6 => 'Tapahtui virhe käsittelyssä.',
    7 => 'Profiili käyttäjälle',
    8 => 'Käyttäjänimi',
    9 => 'Käyttäjän URL',
    10 => 'Lähetä viesti käyttäjälle',
    11 => 'Nimesi:',
    12 => 'Vastausosoite:',
    13 => 'Aihe:',
    14 => 'Viesti:',
    15 => 'HTML koodeja ei käännetä.',
    16 => 'Lähetä viesti',
    17 => 'Lähetä artikkeli ystävälle',
    18 => 'Käyttäjälle',
    19 => 'Sähköpostiosoitteeseen',
    20 => 'Lähettäjän nimi',
    21 => 'Lähettäjän sähköpostiosoite',
    22 => 'Kaikki kentät on täytettävä',
    23 => "Tämän sähköpostin lähetti sinulle %s at %s koska hän ajatteli artikkelin osoitteesta {$_CONF['site_url']} kiinnostavan sinua.  Tämä ei ole roskapostia ja lähetyksessä käytettyjä sähköpostiosoitteita ei tallenneta myöhempää käyttöä varten.",
    24 => 'Kommentoi artikkelia osoitteessa',
    25 => 'Sinun taytyy olla kirjautuneena sivustolle käyttääksesi ominaisuutta. Vaatimalla kirjautumista estetään järjestelmän väärinkäytökset',
    26 => 'Tällä lomakkeella voit lähettää sähköpostia valitulle käyttäjälle. Kaikki kentät ovat pakollisia täyttää.',
    27 => 'Lyhyt viesti',
    28 => '%s kirjoitti: ',
    29 => "Tämä on päivittäinen kooste sivustolta {$_CONF['site_name']} käyttäjälle ",
    30 => ' Päivittäinen uutislehti ',
    31 => 'Otsikko',
    32 => 'Päiväys',
    33 => 'Lue artikkeli kokonaan osoitteessa',
    34 => 'Viestin loppu',
    35 => 'Pahoittelemme, käyttäjä ei halua saada sähköposteja.'
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
    11 => 'Etsinnän tulokset',
    12 => 'osumaa',
    13 => 'Etsinnän tulokset: ei osumia',
    14 => 'Ei löytynyt hakutuloksia haulle',
    15 => 'Yritä uudelleen.',
    16 => 'Otsikko',
    17 => 'Päiväys',
    18 => 'Kirjoittaja',
    19 => "Etsi nykyisiä ja vanhoja artikkeleita sivuston {$_CONF['site_name']} koko tietokannasta",
    20 => 'Päiväys',
    21 => 'viiva',
    22 => '(Päiväyksen muoto VVVV-KK-PP)',
    23 => 'Katselukertaa',
    24 => 'Löydetty %d aihetta',
    25 => 'Etsitty ',
    26 => 'aihetta ',
    27 => 'sekuntia',
    28 => 'Yksikään artikkeli tai kommentti ei vastannut hakuasi',
    29 => 'Artikkeleiden ja kommenttien tulokset',
    30 => 'Yksikään linkki ei vastannut hakuasi',
    31 => 'Laajennus ei löytänyt osumia',
    32 => 'Tapahtuma',
    33 => 'URL',
    34 => 'Sijainti',
    35 => 'Koko päivän',
    36 => 'Yksikään tapahtuma ei vastannut hakuasi',
    37 => 'Tapahtumien tulokset',
    38 => 'Linkkien tulokset',
    39 => 'Linkit',
    40 => 'Tapahtumat',
    41 => 'Hakulauseessa tulee olla ainakin 3 merkkiä.',
    42 => 'Käytä päiväystä muodossa VVVV-KK-PP (vuosi-kuukausi-päivä).',
    43 => 'täsmälleen sama lause',
    44 => 'kaikki sanat',
    45 => 'mikä tahansa sanoista',
    46 => 'Seuraava',
    47 => 'Edellinen',
    48 => 'Kirjoittaja',
    49 => 'Päiväys',
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
    2 => 'Yhteensä latauksia järjestelmästä',
    3 => 'Artikkeleja(kommentteja) järjestelmässä',
    4 => 'Äänestyksiä(vastauksia) järjestelmässä',
    5 => 'Linkkejä(klikkauksia) järjestelmässä',
    6 => 'Tapahtumia järjestelmässä',
    7 => 'Kymmenen luetuinta artikkelia',
    8 => 'Artikkelin otsikko',
    9 => 'Lukukertoja',
    10 => 'Näyttää siltä ettei sivustolla ole artikkeleita tai kukaan ei ole koskaan niitä lukenut.',
    11 => 'Kymmenen kommentoiduinta artikkelia',
    12 => 'Kommentteja',
    13 => 'Näyttää siltä ettei sivustolla ole artikkeleita tai kukaan ei ole kommentoinut niitä.',
    14 => 'Kymmenen suosituinta kyselyä',
    15 => 'Kyselyn aihe',
    16 => 'Ääntä',
    17 => 'Näyttää siltä ettei sivustolla ole äänestyksiä tai kyselyitä tai ettei kukaan ole niissä äänestänyt.',
    18 => 'Kymmenen suosituinta linkkiä',
    19 => 'Linkki',
    20 => 'Latauksia',
    21 => 'Näyttää siltä ettei sivustolla ole linkkejä tai kukaan ei ole niitä ladannut.',
    22 => 'Kymmenen postitetuinta artikkelia',
    23 => 'Lähetyksiä',
    24 => 'Näyttää siltä ettei kukaan ole lähettänyt sähköpostitse artikkeleita sivustolta.',
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
    2 => 'Lähetä artikkeli ystävälle',
    3 => 'Tulostettava versio artikkelista',
    4 => 'Artikkelien asetukset',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Lähettääksesi %s sinun täytyy olla kirjautuneena sivustolle.',
    2 => 'Kirjaudu',
    3 => 'Uusi käyttäjä',
    4 => 'Lähetä tapahtuma',
    5 => 'Lähetä linkki',
    6 => 'Lähetä artikkeli',
    7 => 'Kirjautuminen vaaditaan',
    8 => 'Lähetä',
    9 => 'Lähettäessäsi tietoa sivuston käyttöön, seuraa oheisia suosituksia...<ul><li>Täytä kaikki kentät<li>Lähetä täydellistä ja paikkaansapitävää tietoa<li>Tuplatarkista URL-osoitteet</ul>',
    10 => 'Otsikko',
    11 => 'Linkki',
    12 => 'Aloituspäivä',
    13 => 'Lopetuspäivä',
    14 => 'Sijainti',
    15 => 'Kuvaus',
    16 => 'Jos muu, tarkenna',
    17 => 'Aihealue',
    18 => 'Muu',
    19 => 'Lue ensin',
    20 => 'Virhe: aihealue puuttuu',
    21 => 'Valitessasi "Muu" syötä myös aihealueen nimi',
    22 => 'Virhe: puuttuvia kenttiä',
    23 => 'Täytä kaikki kentät lomakkeessa. Kaikki kentät ovat pakollisia.',
    24 => 'Lähetys tallennettu',
    25 => '%s -lähetys on tallennettu onnistuneesti.',
    26 => 'Nopeusrajoitus',
    27 => 'Käyttäjänimi',
    28 => 'Aihe',
    29 => 'Juttu',
    30 => 'Viimeisin lähetyksesi oli ',
    31 => " sekuntia sitten. Sivusto vaatii vähintään {$_CONF['speedlimit']} sekunnin tauon lähetysten välillä",
    32 => 'Esikatselu',
    33 => 'Artikkelin esikatselu',
    34 => 'Kirjaudu ulos',
    35 => 'HTML koodit eivät ole sallittu',
    36 => 'Lähetystila',
    37 => "Lähettäessäsi tapahtumaa sivustolle {$_CONF['site_name']} se laitetaan pääkalenteriin josta käyttäjät voivat poimia tapahtumasi heidän henkilökohtaisiin kalentereihin. Ominaisuutta <b>EI</b> ole tarkoitettu syntymäpäivien tai henkilökohtaisten tapahtumien tallentamiseen. <br><br>Lähetettyäsi tapahtuman se tarkistetaan ylläpidon voimin ja hyväksynnän jälkeen tapahtuma lisätään pääkalenteriin.",
    38 => 'Lisää tapahtuma ',
    39 => 'Pääkalenteriin',
    40 => 'Henkilökohtaiseen kalenteriin',
    41 => 'Loppumisaika',
    42 => 'Aloitusaika',
    43 => 'Koko päivän tapahtuma',
    44 => 'Osoiterivi 1',
    45 => 'Osoiterivi 2',
    46 => 'Kaupunki',
    47 => 'Osavaltio',
    48 => 'Postinumero',
    49 => 'Tapahtuman tyyppi',
    50 => 'Muokkaa tapahtumien tyyppejä',
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
    2 => 'Evätty! Virheelliset kirjautumistiedot',
    3 => 'Väärä salasana käyttäjälle',
    4 => 'Käyttäjätunnus:',
    5 => 'Salasana:',
    6 => 'Kaikki ylläpidon osioiden liikenne sivustolla kirjataan ja tarkistetaan. <br>Sivu on tarkoitettu vain sallitulle henkilökunnalle.',
    7 => 'kirjaudu'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Riittämättömät ylläpidolliset valtuudet',
    2 => 'Sinulla ei ole oikeuksia muokata tätä lohkoa.',
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
    15 => 'Viimeisin RDF päivitys',
    16 => 'Normaalin lohkon asetukset',
    17 => 'Lohkon sisältö',
    18 => 'Täytä lohkon otsikko, turvallisuus taso sekä sisältö -kentät',
    19 => 'Lohkojen hallinta',
    20 => 'Lohkon otsikko',
    21 => 'Lohkon turvataso',
    22 => 'Lohkon tyyppi',
    23 => 'Lajittelujärjestys',
    24 => 'Lohkon aihe',
    25 => 'Muokataksesi tai poistaaksesi lohkoa, klikkaa haluamaasi lohkoa alta. Luodaksesi uuden lohkon, klikkaa uusi lohko yläpuolelta.',
    26 => 'Ulkoasu lohko',
    27 => 'PHP lohko',
    28 => 'PHP lohkon asetukset',
    29 => 'Lohkon toiminnot',
    30 => 'Jos haluat lohkon käyttävän PHP koodia, syötä funktion nimi ylhäälle. Funktion tai toiminteen tulee alkaa "phpblock_" (esimerkiksi phpblock_getweather). Jos aliohjelmassa ei ole tätä alkulausetta, funktiota ei kutsuta.  Tämä tehdään epämääräisten aliohjelmakutsujen estämiseksi jos henkilöt ovat hakkeroineet Geeklogin asennuksen. Varmista ettet laita tyhjiä sulkuja "()" funktion nimen perään. Lopuksi on suositeltavaa laittaa kaikki PHP koodisi tiedostoon /path/to/geeklog/system/lib-custom.php.  Tällä varmistut että koodisi säilyy vaikka päivittäisit Geeklogin uudempaan versioon.',
    31 => 'Virhe PHP lohkossa.  Funktio, %s, ei ole olemassa.',
    32 => 'Virhe puuttuva kenttä',
    33 => 'Sinun tulee syöttää URL .rdf tiedostoon sivuston lohkoa varten',
    34 => 'Sinun tulee syöttää otsikko ja funktio PHP lohkoa varten',
    35 => 'Sinun tulee syöttää otsikko ja sisältö normaali lohkoihin',
    36 => 'Sinun tulee syöttää sisältö ulkoasu lohkoa varten',
    37 => 'Virheellinen PHP lohkon funktion nimi',
    38 => 'PHP lohkojen funktioissa tulee olla alussa \'phpblock_\' (esim. phpblock_getweather).  \'phpblock_\' etuliite vaaditaan turvallisuuden vuoksi, hämärän koodin ajamisen estämiseksi.',
    39 => 'Sivu',
    40 => 'Vasen',
    41 => 'Oikea',
    42 => 'Lajittelujärjestys ja turvallisuustaso tulee syöttää Geeklogin oletuslohkoja varten',
    43 => 'Vain kotisivu',
    44 => 'Pääsy kielletty',
    45 => "Olet yrittämässä käyttää lohkoa johon sinulla ei ole oikeuksia. Yritys on kirjattu lokitiedostoon.  <a href=\"{$_CONF['site_admin_url']}/block.php\">Siirry takaisin ylläpidon valikkoon</a>.",
    46 => 'Uusi lohko',
    47 => 'Ylläpidon kotisivu',
    48 => 'Lohkon nimi',
    49 => ' (ei välilyöntejä ja nimen tulee olla yksilöllinen)',
    50 => 'Avuste-tiedoston URL',
    51 => 'sisällytä http://',
    52 => 'Jos jätät tämän tyhjäksi, avuste-ikonia ei näytetä tälle lohkolle',
    53 => 'Päällä',
    54 => 'tallenna',
    55 => 'peruuta',
    56 => 'poista',
    57 => 'Siirrä lohkoa alaspäin',
    58 => 'Siirrä lohkoa ylöspäin',
    59 => 'Siirrä lohko oikealle puolelle',
    60 => 'Siirrä lohko vasemmalle puolelle',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Tapahtumien muokkain',
    2 => 'Error',
    3 => 'Tapahtuman otsikko',
    4 => 'Tapahtuman URL',
    5 => 'Tapahtuman aloituspäivä',
    6 => 'Tapahtuman loppumispäivä',
    7 => 'Tapahtuman sijainti',
    8 => 'Tapahtuman kuvaus',
    9 => '(sisällytä http://)',
    10 => 'Päiväyksen/ajan, kuvauksen ja sijainnin syöttäminen on pakollista!',
    11 => 'Tapahtumien hallinta',
    12 => 'Muokataksesi tai poistaaksesi tapahtuman, valitse tapahtuma alapuolelta. Luodaksesi uuden tapahtuman, klikkaa uusi tapahtuma yläpuolelta. Klikkaa [C] luodaksesi kopion olemassaolevasta tapahtumasta.',
    13 => 'Tapahtuman otsikko',
    14 => 'Alkamispäivä',
    15 => 'Loppumispäivä',
    16 => 'Pääsy kielletty',
    17 => "Yrität päästä tapahtumaan johon sinulla ei ole oikeuksia. Yritys on kirjattu lokitiedostoon. <a href=\"{$_CONF['site_admin_url']}/event.php\">Siirry takaisin tapahtuman hallinnan sivustolle</a>.",
    18 => 'Uusi tapahtuma',
    19 => 'Ylläpidon etusivu',
    20 => 'tallenna',
    21 => 'peruuta',
    22 => 'poista',
    23 => 'Bad start date.',
    24 => 'Bad end date.',
    25 => 'End date is before start date.'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Aikaisemmat artikkelit',
    2 => 'Seuraavat artikkelit',
    3 => 'Tila',
    4 => 'Lähetystila',
    5 => 'Artikkelin muokkaus',
    6 => 'Ei artikkeleja järjestelmässä',
    7 => 'Kirjoittaja',
    8 => 'tallenna',
    9 => 'esikatselu',
    10 => 'peruuta',
    11 => 'poista',
    12 => 'ID',
    13 => 'Otsikko',
    14 => 'Aihe',
    15 => 'Päiväys',
    16 => 'Alkuteksti',
    17 => 'Leipäteksti',
    18 => 'Osumia',
    19 => 'Kommentteja',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Lista artikkeleista',
    23 => 'Muokataksesi tai poistaaksesi artikkelin, klikkaa artikkelin numeroa. Nähdäksesi artikkelin, klikkaa haluamaasi otsikkoa. Luodaksesi uuden artikkelin, valitse uusi artikkeli.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Artikkelin esikatselu',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'Tiedoston lähetys-virhe',
    31 => 'Täytä otsikko ja alkuteksti kentät',
    32 => 'Erikoisartikkeli',
    33 => 'Vain yksi artikkeli voi olla erikoisena',
    34 => 'Vedos',
    35 => 'Kyllä',
    36 => 'Ei',
    37 => 'Lisää',
    38 => 'Lisää',
    39 => 'Lähetyksiä',
    40 => 'Pääsy kielletty',
    41 => "Yrität ladata artikkelia johon sinulla ei ole oikeuksia. Yritys on kirjattu lokitiedostoon. Voit nähdä artikkelin vain luku-muodossa. <a href=\"{$_CONF['site_admin_url']}/story.php\">Siirry takaisin artikkelien ylläpitoon</a> kun olet valmis.",
    42 => "Yrität ladata artikkelia johon sinulla ei ole oikeuksia. Yritys on kirjattu lokitiedostoon. <a href=\"{$_CONF['site_admin_url']}/story.php\">Siirry takaisin artikkelien ylläpitoon</a>.",
    43 => 'Uusi artikkeli',
    44 => 'Ylläpidon sivu',
    45 => 'Käyttöoikeus',
    46 => '<b>HUOMAA:</b> jos muokkaat päiväystä osoittamaan tulevaisuuteen, artikkelia ei julkaista ennen kyseistä päivää. Artikkelia ei myöskään sisällytetä RDF otsikoihin, hakuihin tai tilastoihin.',
    47 => 'Kuvat',
    48 => 'kuva',
    49 => 'oikea',
    50 => 'vasen',
    51 => 'Lisätäksesi kuvan artikkeliin, tekstin joukkoon tulee lisätä erikoistekstiä. Erikoistekstejä ovat [imageX], [imageX_right] tai [imageX_left] jossa X on kuvan numero jonka olet liittänyt. HUOMAA: Sinun tulee käyttää kuvia jotka itse liität artikkeliin, muuten et voi tallentaa artikkelia.<BR><P><B>ESIKATSELU</B>: Esikatselu kuvien kanssa onnistuu parhaiten tallentamalla artikkeli aluksi vedoksena EIKÄ painamalla esikatselu-nappia. Käytä esikatselua vain kun kuvia ei ole liitettynä.',
    52 => 'Poista',
    53 => 'ei käytetty. Sinun tulee sisällyttää tämä kuva alkutekstiin tai leipätekstiin ennen kuin voit tallentaa muutokset',
    54 => 'Liitetyt kuvat joita ei käytetty',
    55 => 'Seuraavat virheet tapahtuivat tallennettaessa. Korjaa virheet ennen tallentamista',
    56 => 'Näytä aihe kuvake',
    57 => 'Näytä skaalaamaton kuva',
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
    78 => 'Click <a href="%s/story.php?mode=edit&amp;sid=%s&amp;editopt=default">here</a> to use default editor'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Aihepiirien muokkaus',
    2 => 'Aiheen ID',
    3 => 'Aihepiirin nimi',
    4 => 'Aiheen kuva',
    5 => '(älä käytä välilyöntejä)',
    6 => 'Aihepiirin poistaminen poistaa kaikki aihepiirin artikkelit ja lohkot jotka siihen liittyvät',
    7 => 'Täytä Aiheen ID ja Aihepiirin nimi -kentät',
    8 => 'Aihepiirien hallinta',
    9 => 'Klikkaa aihepiiriä muokataksesi tai poistaaksesi aiheen. Luodaksesi uuden valitse uusi aihepiiri -nappi vasemmalta. Näet käyttöoikeutesi aihepiiriin suluissa. Tähti (*) merkitsee oletusaihetta.',
    10 => 'Lajittelujärjestys',
    11 => 'Artikkeleja/sivu',
    12 => 'Pääsy kielletty',
    13 => "Olet pyrkimässä aiheeseen johon sinulla ei ole oikeuksia. Yritys on kirjattu lokitiedostoon. <a href=\"{$_CONF['site_admin_url']}/topic.php\">Siirry takaisin aihepiirien ylläpitoon</a>.",
    14 => 'Lajittelu tapa',
    15 => 'aakkosellinen',
    16 => 'oletus on',
    17 => 'Uusi aihepiiri',
    18 => 'Ylläpidon sivu',
    19 => 'tallenna',
    20 => 'peruuta',
    21 => 'poista',
    22 => 'Oletus',
    23 => 'tee tästä oletus aihe uusille artikkeleille',
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
    1 => 'Käyttäjän muokkaus',
    2 => 'Käyttäjän ID',
    3 => 'Käyttäjätunnus',
    4 => 'Koko nimi',
    5 => 'Salasana',
    6 => 'Turvallisuustaso',
    7 => 'Sähköposti-osoite',
    8 => 'Kotisivu',
    9 => '(älä käytä välilyöntejä)',
    10 => 'Täytä käyttäjätunnus ja sähköposti-osoite kentät',
    11 => 'Käyttäjien hallinta',
    12 => 'Klikkaa alta jos haluat muokata tai poistaa käyttäjän. Luodaksesi uuden käyttäjän, valitse uusi käyttäjä vasemmalta. Voit tehdä yksinkertaisia hakuja syöttämällä osan käyttäjätunnuksesta, sähköpostista tai kokonimestä allaolevaan lomakkeeseen (esimerkiksi *son* tai *.edu).',
    13 => 'Turvataso',
    14 => 'Rek.päivä',
    15 => 'Uusi käyttäjä',
    16 => 'Ylläpidon sivu',
    17 => 'vaihda salasana',
    18 => 'peruuta',
    19 => 'poista',
    20 => 'tallenna',
    21 => 'Käyttäjätunnus on jo olemassa.',
    22 => 'Virhe',
    23 => 'Kimppalisäys',
    24 => 'Tuo lauma käyttäjiä',
    25 => 'Voit tuoda Geeklogiin suuremman määrän käyttäjiä. Tuontitiedoston tulee olla sarkain-eroteltu teksti-tiedosto jossa kenttien tulee olla seuraavassa järjestyksessä: koko nimi, käyttäjätunnus, sähköposti-osoite. Tuomillesi henkilöille postitetaan satunnaisesti generoitu salasana sähköpostitse. Tiedostossa tulee olla yksi käyttäjä per rivi. Virheet tuonnissa voivat aiheuttaa ongelmia joiden selvittäminen vaatii käsityötä joten tarkista syötteesi tarkasti!',
    26 => 'Etsi',
    27 => 'Rajoita tuloksia',
    28 => 'Klikkaa tähän tuhotaksesi tämän kuvan',
    29 => 'Polku',
    30 => 'Tuo',
    31 => 'Uudet käyttäjät',
    32 => 'Käsittely valmis. Tuotiin %d ja kohdattiin %d virhettä',
    33 => 'lähetä',
    34 => 'Virhe: valitse lähetettävä tiedosto.',
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
    47 => 'Edit'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Hyväksy',
    2 => 'Poista',
    3 => 'Muokkaa',
    4 => 'Profiili',
    10 => 'Otsikko',
    11 => 'Aloitus päivä',
    12 => 'URL',
    13 => 'Aihepiiri',
    14 => 'Päivä',
    15 => 'Aihe',
    16 => 'Käyttäjänimi',
    17 => 'Koko nimi',
    18 => 'Sähköposti',
    34 => 'Komennot ja hallinta',
    35 => 'Lähetettyjä artikkeleja',
    36 => 'Lähetettyjä linkkejä',
    37 => 'Lähetettyjä tapahtumia',
    38 => 'Lähetä',
    39 => 'Ei hallinnoitavia lähetyksiä tällä hetkellä',
    40 => 'Käyttäjien lähetyksiä'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Sunnuntai',
    2 => 'Maanantai',
    3 => 'Tiistai',
    4 => 'Keskiviikko',
    5 => 'Torstai',
    6 => 'Perjantai',
    7 => 'Lauantai',
    8 => 'Lisää tapahtuma',
    9 => '%s tapahtuma',
    10 => 'Tapahtumat',
    11 => 'pääkalenteriin',
    12 => 'omaan kalenteriin',
    13 => 'Tammikuu',
    14 => 'Helmikuu',
    15 => 'Maaliskuu',
    16 => 'Huhtikuu',
    17 => 'Toukokuu',
    18 => 'Kesäkuu',
    19 => 'Heinäkuu',
    20 => 'Elokuu',
    21 => 'Syyskuu',
    22 => 'Lokakuu',
    23 => 'Marraskuu',
    24 => 'Joulukuu',
    25 => 'Paluu ',
    26 => 'Koko päivä',
    27 => 'Viikko',
    28 => 'Henkilökohtainen kalenteri käyttäjälle',
    29 => 'Julkinen kalenteri',
    30 => 'poista tapahtuma',
    31 => 'Lisää',
    32 => 'Tapahtuma',
    33 => 'Päivä',
    34 => 'Aika',
    35 => 'Pikalisäys',
    36 => 'Lähetä',
    37 => 'Henkilökohtaiset kalenterit eivät ole sallittuja tällä sivustolla',
    38 => 'Henkilökohtaisten tapahtumien muokkain',
    39 => 'Päivä',
    40 => 'Viikko',
    41 => 'Kuukausi'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Posti Apuri",
    2 => 'Lähettäjä',
    3 => 'Vastausosoite',
    4 => 'Aihe',
    5 => 'Leipäteksti',
    6 => 'Kenelle lähetetään:',
    7 => 'Kaikille käyttäjille',
    8 => 'Ylläpito',
    9 => 'Vaihtoehdot',
    10 => 'HTML',
    11 => 'Tärkeä viesti!',
    12 => 'Lähetä',
    13 => 'Tyhjennä',
    14 => 'Ohita käyttäjien asetukset',
    15 => 'Virhe lähetettäessä: ',
    16 => 'Lähetykset tehty onnistuneesti: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Lähetä toinen viesti</a>",
    18 => 'Vastaanottaja',
    19 => 'HUOMAA: jos haluat lähettää viestin sivuston kaikille jäsenille, valitse kirjautuneet käyttäjät -ryhmä pudotusvalikosta.',
    20 => "Onnistuneesti lähetetty <successcount> viestiä ja epäonnistuttu <failcount> viestin lähetyksessä. Tarvittaessa kaikkien viestilähetyksien tiedot löytyvät alta. Muuten voit lähettää <a href=\"{$_CONF['site_admin_url']}/mail.php\">seuraavan viestin</a> tai <a href=\"{$_CONF['site_admin_url']}/moderation.php\">siirtyä takaisin hallinnon sivulle</a>.",
    21 => 'epäonnistumisia',
    22 => 'onnistumisia',
    23 => 'Ei epäonnistumisia',
    24 => 'Ei onnistumisia',
    25 => '-- Valitse ryhmä --',
    26 => 'Täytä kaikki kentät lomakkeesta ja valitse kohdekäyttäjien ryhmä pudotusvalikosta.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Laajennusten asentaminen voi vahingoittaa Geeklogia ja mahdollisesti järjestelmääsi. Käytä vain <a href="http://www.geeklog.net" target="_blank">Geeklogin kotisivulta</a> ladattuja laajennuksia, koska testaamme sivustollemme lähetetyt laajennukset usealla käyttöjärjestelmällä. On tärkeää ymmärtää laajennuksien asentamisen vaativan joidenkin käyttöjärjestelmiäkäskyjen ajamisen, jotka voivat johtaa turvallisuusongelmiin, varsinkin kolmansien osapuolien laajennusten tapauksessa. Vaikka varoitammekin käyttäjiä laajennuksista, emme takaa asennuksen onnistumista emmekä ota vastuuta Geeklogin laajennusten aiheuttamista vahingoista. Toisinsanoen, asenna näitä omalla vastuullasi. Varovaisille; käsin tapahtuvaan asennukseen tulee ohjeet jokaisessa laajennuspaketissa.',
    2 => 'Huomioi laajennuksia asentaessasi',
    3 => 'Laajennuksien asentamislomake',
    4 => 'Laajennustiedosto',
    5 => 'Lista laajennuksista',
    6 => 'Varoitus: laajennus on jo asennettu!',
    7 => 'Laajennus jonka asentamista yrität, on jo asennettu. Poista laajennus ennen sen uudelleenasentamista',
    8 => 'Laajennuksen yhteensopivuustesti epäonnistui',
    9 => 'Laajennus vaatii uudemman version Geeklogista. Päivitä <a href="http://www.geeklog.net">Geeklog-järjestelmäsi</a> tai hanki uudempi versio laajennuksesta.',
    10 => '<br><b>Laajennuksia ei ole tällä hetkellä asennettuna.</b><br><br>',
    11 => 'Muokataksesi tai poistaaksesi laajennuksen, valitse laajennuksen numero. Halutessasi lisätietoja laajennuksesta, valitse laajennuksen nimi alta ja sinut ohjataa laajennuksen kotisivulle. Asentaaksesi tai päivittääksesi laajennuksen, lue laajennuksen dokumentaatio.',
    12 => 'laajennuksen nimeä ei ole lähetetty plugineditor()',
    13 => 'Laajennusten muokkain',
    14 => 'Uusi laajennus',
    15 => 'Hallinnon sivu',
    16 => 'Laajennuksen nimi',
    17 => 'Laajennuksen versio',
    18 => 'Geeklogin versio',
    19 => 'Päällä',
    20 => 'Kyllä',
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
    31 => 'Oletko varma että haluat poistaa laajennuksen? Poistamalla poistat myös kaiken tiedot ja tietorakenteen jotka liittyvät tähän laajennukseen. Jos olet varma, valitse poista uudelleen alta löytyvästä lomakkeesta.',
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
    1 => 'luo syöte',
    2 => 'tallenna',
    3 => 'poista',
    4 => 'peruuta',
    10 => 'Sisällön syndikointi',
    11 => 'Uusi syöte',
    12 => 'Ylläpidon sivu',
    13 => 'Poistaaksesi tai muokataksesi syötettä, valitse syötteen otsikko. Luodaksesi uuden syötteen, valitse Uusi syöte yltä.',
    14 => 'Otsikko',
    15 => 'Tyyppi',
    16 => 'Tiedosto',
    17 => 'Muoto',
    18 => 'viimeksi päivitetty',
    19 => 'Sallittu',
    20 => 'Kyllä',
    21 => 'Ei',
    22 => '<i>(ei syötteitä)</i>',
    23 => 'kaikki artikkelit',
    24 => 'Syötteiden muokkain',
    25 => 'Syötteen otsikko',
    26 => 'Rajoitus',
    27 => 'Sisällön pituus',
    28 => '(0 = ei tekstiä, 1 = koko teksti, muu = rajoita syöttämääsi määrään merkkejä.)',
    29 => 'Kuvaus',
    30 => 'Viimeisin päivitys',
    31 => 'Merkkilaji',
    32 => 'Kieli',
    33 => 'Sisältö',
    34 => 'Kirjauksia',
    35 => 'Tuntia',
    36 => 'Valitse syötteen tyyppi',
    37 => 'Vähintään yksi syötettä tai sisällön jakamista tukeva laajennus on asennettu. Alta voit valita haluatko luoda syötteen Geeklogista vai jostain laajennuksesta.',
    38 => 'Virhe: puuttuvia kenttiä',
    39 => 'Täytä syötteen otsikko, kuvaus ja tiedoston nimi.',
    40 => 'Syötä kirjauksien määrä tai tuntien lukumäärä.',
    41 => 'Linkit',
    42 => 'Tapahtumat',
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
    1 => "Salasanasi on lähetetty sähköpostitse ja pitäisi saapua sinulle hetken kuluttua. Seuraa viestissä olevia ohjeita. Kiitämme sivuston {$_CONF['site_name']} käytöstä.",
    2 => "Kiitokset artikkelin lähettämisestä sivustolle {$_CONF['site_name']}.  Ylläpito tarkistaa ja läpikäy sen ja se tulee hyväksymisen jälkeen lukijoiden näkyville sivustolle.",
    3 => "Kiitokset linkin lähettämisestä sivustolle {$_CONF['site_name']}.  Ylläpito tarkistaa sen ja linkki tulee hyväksymisen jälkeen <a href={$_CONF['site_url']}/links.php>linkit</a>-osioon sivustolla.",
    4 => "Kiitokset tapahtuman lähettämisestä sivustolle{$_CONF['site_name']}.  Ylläpito tarkistaa sen ja hyväksymisen jälkeen tapahtuma on näkyvissä <a href={$_CONF['site_url']}/calendar.php>kalenteri</a>-osiossa.",
    5 => 'Tilisi tiedot ovat tallennettu.',
    6 => 'Näyttöasetuksesi ovat tallennettu.',
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
    21 => 'Uusi käyttäjä on tallennettu.',
    22 => 'Käyttäjä on poistettu.',
    23 => 'Virhe lisättäessä tapahtumaa kalenteriisi. Ei tapahtuman id:tä.',
    24 => 'Tapahtuma on tallennettu kalenteriisi',
    25 => 'Henkilökohtaista kalenteria ei voi avata ennen sisäänkirjautumista',
    26 => 'Tapahtuma on poistettu omasta kalenteristasi',
    27 => 'Viesti lähetetty onnistuneesti.',
    28 => 'Laajennus on tallennettu',
    29 => 'Omat kalenterit eivät ole sallittuja tällä sivustolla',
    30 => 'Pääsy kielletty',
    31 => 'Sinulla ei ole pääsyä artikkelien hallinnan sivulle. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    32 => 'Sinulla ei ole pääsyä aiheiden hallintaan. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    33 => 'Sinulla ei ole pääsyä lohkojen hallintaan. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    34 => 'Sinulla ei ole pääsyä linkkien hallintaan. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    35 => 'Sinulla ei ole pääsyä tapahtumien hallintaan. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    36 => 'Sinulla ei ole pääsyä kyselyjen hallintaan. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    37 => 'Sinulla ei ole pääsyä käyttäjien hallintaan. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    38 => 'Sinulla ei ole pääsyä laajennusten hallintaan. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    39 => 'Sinulla ei ole pääsyä sähköpostin hallintaan. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    40 => 'Järjestelmän viesti',
    41 => 'Sinulla ei ole pääsyä sanojen korvauksen sivulle. Huomaa että yritykset kirjataan lokitiedostoon',
    42 => 'Sanasi on tallennettu.',
    43 => 'Sana on poistettu.',
    44 => 'Laajennus on onnistuneesti asennettu!',
    45 => 'Laajennus on poistettu.',
    46 => 'Sinulla ei ole oikeuksia tietokannan varmistukseen. Huomaa että kaikki yritykset kirjataan lokitiedostoon',
    47 => 'Tämä toiminto toimii vain *nix järjestelmissä.  Jos käyttöjärjestelmäsi on *nix, välimuisti on tyhjennetty. Jos käyttöjärjestelmäsi on Windows, joudut etsimään tiedostot adodb_*.php ja poistamaan ne käsin.',
    48 => "Kiitos jäsenhakemuksestasi sivustolle {$_CONF['site_name']}. Ylläpito käy läpi hakemuksesi. Hyväksymisen jälkeen salasanasi lähetetään antamaasi sähköpostiosoitteeseen.",
    49 => 'Ryhmä on tallennettu.',
    50 => 'Ryhmä on poistettu.',
    51 => 'Käyttäjänimi on jo käytössä. Valitse toinen käyttäjänimi.',
    52 => 'Syöttämäsi sähköpostiosoite ei ole oikea.',
    53 => 'Uusi salasanasi on hyväksytty. Käytä uutta salasanaasi kirjautuessasi nyt sisään.',
    54 => 'Pyyntösi uuden salasanan saamiseksi on ikääntynyt. Yritä uudestaan alta.',
    55 => 'Sähköpostiviesti on lähetetty sinulle ja sen pitäisi saapua hetken päästä. Seuraa viestin ohjeita asettaaksesi uuden salasanan tilillesi.',
    56 => 'Syöttämäsi sähköpostiosoite on jo käytössä toisella tilillä.',
    57 => 'Tilisi on poistettu.',
    58 => 'Syötteesi on tallennettu.',
    59 => 'Syöte on poistettu.',
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
    'access' => 'Pääsy',
    'ownerroot' => 'Omistaja/Root',
    'group' => 'Ryhmä',
    'readonly' => 'Vain luku',
    'accessrights' => 'Käyttöoikeudet',
    'owner' => 'Omistaja',
    'grantgrouplabel' => 'Salli ryhmälle muokkaus oikeudet',
    'permmsg' => 'HUOMAA: jäsenet tarkoittavat kaikkia sivustolle kirjautuneita henkilöitä ja tuntematon tarkoittaa kaikkia sivustolla selailevia käyttäjiä jotka eivät ole kirjautuneet sisään.',
    'securitygroups' => 'Turvallisuus ryhmät',
    'editrootmsg' => "Vaikka olet käyttäjien ylläpitäjä, et voi muokata pääkäyttäjää olematta itse pääkäyttäjä. Voit muokata muita käyttäjiä paitsi pääylläpitäjää. Huomaa että kaikki yritykset laittomasti muokata pääkäyttäjiä kirjoitetaan lokitiedostoon. Siirry takaisin <a href=\"{$_CONF['site_admin_url']}/user.php\">käyttäjien ylläpitoon</a>.",
    'securitygroupsmsg' => 'Rastita ruudut niistä ryhmistä joihin haluat käyttäjän kuuluvan.',
    'groupeditor' => 'Ryhmien muokkaus',
    'description' => 'Kuvaus',
    'name' => 'Nimi',
    'rights' => 'Oikeudet',
    'missingfields' => 'Puuttuvat kentät',
    'missingfieldsmsg' => 'Syötä ryhmän nimi ja kuvaus',
    'groupmanager' => 'Ryhmien hallinta',
    'newgroupmsg' => 'Muokataksesi tai poistaaksesi ryhmän, valitse ryhmä alta. Luodaksesi uuden ryhmän, valitse uusi ryhmä yltä. Huomaa että ydinryhmiä ei voi poistaa koska ne ovat järjestelmän käytössä.',
    'groupname' => 'Ryhmän nimi',
    'coregroup' => 'Ydin ryhmä',
    'yes' => 'Kyllä',
    'no' => 'Ei',
    'corerightsdescr' => "Ryhmä kuuluu sivuston {$_CONF['site_name']} ydin ryhmään. Ryhmän oikeuksia ei voi siitä syystä muokata. Alla on lista ryhmän oikeuksista vain lukemista varten.",
    'groupmsg' => 'Turvallisuus ryhmät sivustolla ovat hierarkiset. Muokkaamalla tätä ryhmää tai jotain alla olevista ryhmistä antaa tälle ryhmälle samat oikeudet kuin muille alla oleville ryhmille. Milloin se on mahdollista, suosittelemme käyttämään allaolevia ryhmiä oikeuksie jakamiseen tälle ryhmälle. Jos tarvitset muokattuja oikeuksia, voit valita oikeudet sivuston eri toimintoihin alta löytyvästä \'Oikeudet\'-kohdasta. Lisätäksesi tämän ryhmän johonkin allaolevista ryhmistä, merkitse rasti ryhmän tai ryhmien viereen.',
    'coregroupmsg' => "Tämä ryhmä on ydinryhmä sivustolla {$_CONF['site_name']}.  Tästä johtuen ryhmää ei voi muokata. Alla on lista vain luku-muodossa ryhmistä joihin tämä ryhmä kuuluu.",
    'rightsdescr' => 'Ryhmä saa oikeutensa joko olemalla osana toista ryhmää TAI ryhmälle voi antaa suoraan haluamasi oikeudet. Alla olevat oikeudet joissa ei ole rastiruutua, ovat oikeuksia jotka ryhmä on saanut olemalla osa jotain toista ryhmää jolla nuo oikeudet ovat. Ne joissa on laatikko vieressä ovat oikeuksia joita ryhmälle voidaan suoraan myöntää.',
    'lock' => 'Lukittu',
    'members' => 'Jäsenet',
    'anonymous' => 'Tuntematon',
    'permissions' => 'Oikeudet',
    'permissionskey' => 'L = luku, M = muokkaa, muokkaus-oikeudet olettavat myös luku oikeuksien löytyvän',
    'edit' => 'Muokkaa',
    'none' => 'Ei yhtään',
    'accessdenied' => 'Pääsy kielletty',
    'storydenialmsg' => "Sinulla ei ole oikeuksia katsoa artikkelia. Oletko varmasti jäsenenä sivustolla {$_CONF['site_name']}? <a href=users.php?mode=new>Rekisteröidy jäseneksi</a> sivustolle {$_CONF['site_name']} saadaksesi täydet jäsenyyden suomat oikeudet!",
    'eventdenialmsg' => "Sinulla ei ole oikeuksia katsoa tätä tapahtumaa. Oletko varmasti jäsenenä sivustolla {$_CONF['site_name']}? <a href=users.php?mode=new>Rekisteröidy jäseneksi</a> sivustolle {$_CONF['site_name']} saadaksesi täydet jäsenyyden suomat oikeudet!",
    'nogroupsforcoregroup' => 'Ryhmä ei kuulu mihinkään muuhun ryhmään',
    'grouphasnorights' => 'Ryhmällä ei ole hallinnointi oikeuksia sivustolla.',
    'newgroup' => 'Uusi ryhmä',
    'adminhome' => 'Ylläpidon sivu',
    'save' => 'tallenna',
    'cancel' => 'peruuta',
    'delete' => 'poista',
    'canteditroot' => 'Olet yrittänyt muokata Omistajien ryhmää, mutta et kuulu itse ryhmään, niinpä sinulta on pääsy ryhmään kielletty. Ota yhteyttä järjestelmän ylläpitoon jos uskot tämän olevan virhe',
    'listusers' => 'Listaa käyttäjät',
    'listthem' => 'lista',
    'usersingroup' => 'Käyttäjät ryhmässä %s',
    'usergroupadmin' => 'Käyttäjäryhmien ylläpito',
    'add' => 'Lisää',
    'remove' => 'Poista',
    'availmembers' => 'Saatavilla olevat jäsenet',
    'groupmembers' => 'Ryhmän jäsenet',
    'canteditgroup' => 'Sinun tulee olla ryhmän jäsen muokataksesi tätä ryhmää. Jos tämä tuntuu virheeltä, ota yhteyttä järjestelmän ylläpitoon.',
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
    'db_explanation' => 'Luodaksesi uuden varmuuskopion Geeklogista, klikkaa alta löytyvää nappia',
    'not_found' => "Viallinen polku tai mysqldump apuohjelma ei ole suoritettavissa.<br>Tarkista <strong>\$_DB_mysqldump_path</strong> määritys config.php -tiedostossa.<br>Muuttujan nykyinen määrittely: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Varmuuskopiointi epäonnistui: tiedoston koko 0 tavua',
    'path_not_found' => "{$_CONF['backup_path']} ei ole olemassa tai ei ole hakemisto",
    'no_access' => "VIRHE: Hakemisto {$_CONF['backup_path']} ei ole saatavilla.",
    'backup_file' => 'Tee varmuuskopio',
    'size' => 'Koko',
    'bytes' => 'tavua',
    'total_number' => 'Varmistuksia yhteensä: %d'
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
    2 => 'Oho, etsin kaikkialta, mutten löytänyt <b>%s</b>.',
    3 => "<p>Pahoittelumme mutta emme löydä haluamaasi tiedostoa. Katso sivuston <a href=\"{$_CONF['site_url']}\">pääsivu</a> tai sivuston <a href=\"{$_CONF['site_url']}/search.php\">hakusivu</a> löytääksesi mitä olet hukannut."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Kirjautuminen vaaditaan',
    2 => 'Tämä alue vaatii sisäänkirjautumisen käyttäjänä.',
    3 => 'Kirjaudu',
    4 => 'Uusi käyttäjä'
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