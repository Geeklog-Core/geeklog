<?php

###############################################################################
# estonian_utf-8.php
# This is the estonian language page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Sündmuste kalender',
    2 => 'Kahjuks pole ühtegi sündmust, mida näidata.',
    3 => 'Millal',
    4 => 'Kus',
    5 => 'Kirjeldus',
    6 => 'Lisa sündmus',
    7 => 'Tuleviku sündmused',
    8 => 'Lisades selle sündmuse oma kalendrisse saad kiire ülevaate just sind huvitavatest sündmustest, kui klõpsad "Kasutaja funktsioonid" valikute hulgas "Minu kalender".',
    9 => 'Lisa minu kalendrisse',
    10 => 'Eemalda minu kalendrist',
    11 => "Sündmuse lisamine {$_USER['username']} kalendrisse",
    12 => 'Sündmus',
    13 => 'Algab',
    14 => 'Lõpeb',
    15 => 'Tagasi kalendrisse',
    16 => 'Kalender',
    17 => 'Alguspäev',
    18 => 'Lõpupäev',
    19 => 'Sisestused kalendrisse',
    20 => 'Tiitel',
    21 => 'Algusaeg',
    22 => 'URL',
    23 => 'Sinu sündmused',
    24 => 'Sündmused',
    25 => 'Pole tulevasi sündmusi',
    26 => 'Lisa sündmus',
    27 => "Lisades {$_CONF['site_name']} lehele sündmuse, paigutub see peakalendrisse, kust kasutajad saavad soovi korral lisada selle oma enda isiklikku kalendrisse. Lehe kalender <b>ei ole </b> mõeldud teieisiklike sündmuste, nagu sünnipäevade või tähtpäevade jaoks.<br><br>Pärast sündmuse lisamist saadetakse see meie administraatoritele. Administraatorite poolt kinnitatud sündmus ilmub peakalendrisse.",
    28 => 'Tiitel',
    29 => 'Lõpuaeg',
    30 => 'Algusaeg',
    31 => 'Kogu päeva sündmus',
    32 => 'Aadressrida 1',
    33 => 'Aadressrida 2',
    34 => 'Linn',
    35 => 'Piirkond',
    36 => 'postiindeks',
    37 => 'Sündmuse tüüp',
    38 => 'Toimeta sündmuste tüüpe',
    39 => 'Asukoht',
    40 => 'Lisa sündmus - ',
    41 => 'Peakalender',
    42 => 'Isiklik kalender',
    43 => 'Link',
    44 => 'HTML sildid pole lubatud',
    45 => 'Sisesta',
    46 => 'Sündmused lehel',
    47 => 'Top 10 sündmust',
    48 => 'klikke',
    49 => 'Näib, et saidil pole ühtegi sündmust või mitte keegi pole neil klõpsanud.',
    50 => 'Sündmused',
    51 => 'Kustuta',
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Kalendri tulemused',
    'title' => 'Tiitel',
    'date_time' => 'Päev ja kellaaeg',
    'location' => 'Asukoht',
    'description' => 'Kirjeldus'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Lisa sündmus',
    9 => '%s sündmus',
    10 => 'Sündmused, kasutaja',
    11 => 'Peakalender',
    12 => 'Minu kalender',
    25 => 'tagasi ',
    26 => 'Kõik päevad',
    27 => 'Nädal',
    28 => 'Isiklik kalender, kasutaja',
    29 => 'Avalik kalender',
    30 => 'kustuta sündmus',
    31 => 'Lisa',
    32 => 'Sündmus',
    33 => 'Kuupäev',
    34 => 'Aeg',
    35 => 'Kiirlisamine',
    36 => 'Sisesta',
    37 => 'Isiklik kalender ei ole sellel lehel kahjuks aktiveeritud.',
    38 => 'Isiklik sündmuste toimetaja',
    39 => 'Päev',
    40 => 'Nädal',
    41 => 'Kuu',
    42 => 'Lisa peasündmus',
    43 => 'Sisestatud sündmused'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Sündmuste toimetaja',
    2 => 'Viga',
    3 => 'Sündmuse tiitel',
    4 => 'Sündmuse URL',
    5 => 'Sündmuse algusaeg',
    6 => 'Sündmuse lõpuaeg',
    7 => 'Sündmuse asukoht',
    8 => 'Sündmuse kirjeldus',
    9 => '(koos http://)',
    10 => 'Sa pead määrama sündmuse aja ja kellaaja, tiitli ja kirjelduse',
    11 => 'Sündmuste haldaja',
    12 => 'Sündmuse toimetamiseks või kustutamiseks klõpsa allpool selle tiitlil.  Uue sündmuse loomiseks klõpsa Tee uus ülal. Klõpsa [C] olemasolevast sündmusest koopia tegemiseks.',
    13 => 'Sündmuse tiitel',
    14 => 'Alguspäev',
    15 => 'lõpupäev',
    16 => '', // Ligipääs tõkestatud',
    17 => "Sa proovisid ligi pääseda sündmusele, millele sul pole õigust ligi pääseda. See katse on logitud. Palun <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/\">mine tagasi sündmuste haldamise lehele</a>.",
    18 => '', // Uus sündmus',
    19 => '', // Admin avaleht',
    20 => 'salvesta',
    21 => 'tühista',
    22 => 'kustuta',
    23 => 'Sobimatu algusaeg.',
    24 => 'Sobimatu lõpuaeg.',
    25 => 'Lõpuaeg on enne algusaega.'
);

$LANG_CAL_MESSAGE = array(
    'save'      => 'Sinu sündmus on edukalt salvestatud.',
    'delete'    => 'Sündmus on edukalt kustutatud.',
    'private'   => 'Sündmus on sinu kalendrisse salvestatud.',
    'login'     => 'Ei saa enne sinu sisselogimist sinu isiklikku kalendrit avada',
    'removed'   => 'Sündmus on sinu isiklikust kalendrist kustutatud.',
    'noprivate' => 'Kahjuks pole sellel lehel isiklikud kalendrid kasutuses.',
    'unauth'    => 'Sul pole ligipääsu sündmuste haldamise lehele. Pane tähele, et kõik sellised lubamatud katsed logitakse',
);

$PLG_calendar_MESSAGE4  = "Täname sind {$_CONF['site_name']} lehele sündmuse sisestamise eest.  See saadeti meie meeskonnale kinnitamiseks. Pärast kinnitamist on see sündmus näha <a href=\"{$_CONF['site_url']}/calendar/\">kalendri</a> osas.";
$PLG_calendar_MESSAGE17 = 'Sündmus on edukalt salvestatud.';
$PLG_calendar_MESSAGE18 = 'Sinu sündmus on edukalt kustutatud.';
$PLG_calendar_MESSAGE24 = 'Sündmus on salvestatud sinu kalendrisse.';
$PLG_calendar_MESSAGE26 = 'Sündmus on edukalt kustutatud.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

?>
