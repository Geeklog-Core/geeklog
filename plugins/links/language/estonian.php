<?php

###############################################################################
# estonian.php
# This is the Estonian language file for the Geeklog Link plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
#
# Estonian translation by Artur R�pp <rtr AT planet DOT ee>
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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_LINKS = array(
    10 => 'Sisestatud',
    14 => 'Linke',
    84 => 'LINKE',
    88 => 'Pole uusi linke',
    114 => 'Linke',
    116 => 'Lisa link',
    117 => 'Teata mittet��tavast lingist',
    118 => 'Mittet��tavast lingist teatamine',
    119 => 'J�rgmisest lingist on teatatud kui mittet��tavast: ',
    120 => 'Lingi toimetamiseks kliki siin: ',
    121 => 'Mittet��tavast lingist teatas: ',
    122 => 'T�name mittet��tavast lingist teatamise eest. Administraator parandab lingi nii ruttu kui v�imalik.',
    123 => 'T�name sind',
    124 => 'Mine',
    125 => 'Kategooriad',
    126 => 'Oled siin:',
    'root' => 'Pea'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Linke (klikke) lehtedel',
    'stats_headline' => 'Top 10 linki',
    'stats_page_title' => 'Lingid',
    'stats_hits' => 'Klikke',
    'stats_no_hits' => 'N�ib, et lehel pole linke v�i keegi pole neil kl�psanud.'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => 'Linkide tulemus',
    'title' => 'Tiitel',
    'date' => 'Lisamisaeg',
    'author' => 'Lisaja',
    'hits' => 'Klikke'
);

###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'Saada link',
    2 => 'Link',
    3 => 'Kategooria',
    4 => 'Muu',
    5 => 'Kui muu, siis m��ratle',
    6 => 'Viga: puudub kategooria',
    7 => 'Kui valid "Muu", m��ratle ka kategooria nimi',
    8 => 'Tiitel',
    9 => 'URL',
    10 => 'Kategooria',
    11 => 'Sisestatud lingid'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "T�name sind {$_CONF['site_name']} lehele lingi sisestamise eest. See on saadetud meie meeskonnale kinnitamiseks. Kui meeskond kinnitab selle lingi, ilmub see <a href=\"{$_CONF['site_url']}/links/\">Linkide osas.</a>";
$PLG_links_MESSAGE2 = 'Sinu link on edukalt salvestatud.';
$PLG_links_MESSAGE3 = 'Link on edukalt kustutatud';
$PLG_links_MESSAGE4 = "T�name sind {$_CONF['site_name']}  lehele lingi lisamise eest. Sa v�id seda linki juba n�ha <a href=\"{$_CONF['site_url']}/links/\">linkide osas.</a>";
$PLG_links_MESSAGE5 = 'Sul pole piisavalt ligip��su�igusi selle kategooria vaatamiseks.';
$PLG_links_MESSAGE6 = 'Sul pole piisavalt �igusi selle kategooria toimetamiseks.';
$PLG_links_MESSAGE7 = 'Palun sisesta kategooria nimi ja kirjeldus.';
$PLG_links_MESSAGE10 = 'Sinu kategooria on edukalt salvestatud.';
$PLG_links_MESSAGE11 = 'Sa ei saa kategooria ID-ks m��rata "site" v�i "user" - need on reserveeritud sisemiseks kasutamiseks.';
$PLG_links_MESSAGE12 = 'Sa proovid teha vanemkategooriast selle kategooria alamkategooria alamkategooriat. Nii tekiks orbkategooria. Palun vii enne alamkategooriad k�rgemale tasemele.';
$PLG_links_MESSAGE13 = 'Kategooria on edukalt kustutatud.';
$PLG_links_MESSAGE14 = 'Kategooria sisaldab linke v�i alamkategooriaid. Eemalda need enne.';
$PLG_links_MESSAGE15 = 'Sul pole piisavalt �igusi, et seda kategooriat kustutada.';
$PLG_links_MESSAGE16 = 'Pole sellist kategooriat.';
$PLG_links_MESSAGE17 = 'See kategooria-ID on juba kasutuses.';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugina uuendamine pole toetatud.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

$LANG_LINKS_ADMIN = array(
    1 => 'Lingi toimetaja',
    2 => 'Lingi ID',
    3 => 'Lingi tiitel',
    4 => 'Lingi URL',
    5 => 'Kategooria',
    6 => '(koos http://)',
    7 => 'Muu',
    8 => 'Klikke lingil',
    9 => 'Lingi kirjeldus',
    10 => 'Sa pead m��rama lingi URL-i, tiitli ja kirjelduse.',
    11 => 'Lingi haldur',
    12 => 'Lingi toimetamiseks v�i kustutamiseks kl�psa allpool vastava lingi juures oleval toimetamisikoonil. Uue lingi loomiseks kl�psa "Tee uus" �lal.',
    14 => 'Lingi kategooria',
    16 => 'Ligip��s t�kestatud',
    17 => "Sa proovisid ligi p��seda lingile, milleks pole sul �igust. See katse on logitud. Palun <a href=\"{$_CONF['site_admin_url']}/plugins/links/\"> mine tagasi linkide administreerimislehele.</a>",
    20 => 'Kui muu, siis m��ratle',
    21 => 'salvesta',
    22 => 't�hista',
    23 => 'kustuta',
    24 => 'Ei leidnud linki',
    25 => 'Ei leidnud seda linki, mille valisid toimetamiseks.',
    26 => 'Kontrolli linke',
    27 => 'HTML Staatus',
    28 => 'Toimeta kategooriat',
    29 => 'Sisesta allpool kategooria detaile v�i toimeta neid.',
    30 => 'Kategooria',
    31 => 'Kirjeldus',
    32 => 'Kategooria ID',
    33 => 'Rubriik',
    34 => '�lemine',
    35 => 'K�ik',
    40 => 'Toimeta kategooriat',
    41 => 'Loo alamkategooria',
    42 => 'Kustuta see kategooria',
    43 => 'Lehe kategooriad',
    44 => 'Lisa&nbsp;alam',
    46 => 'Kasutaja %s p��dis kustutada kategooriat, mille jaoks polnud tal ligip��su�igusi',
    50 => 'Loetle kategooriaid',
    51 => 'Uus link',
    52 => 'Uus kategooria',
    53 => 'Loetle linke',
    54 => 'Kategooriahaldur',
    55 => 'Toimeta allpool olevaid kategooriaid. Pane t�hele, et sa ei saa kustutada kategooriaid, milles on alamkategooriaid v�i linke. Kustuta need eelnevalt v�i vii need m�nda teise kategooriasse.',
    56 => 'Kategooriatoimetaja',
    57 => 'Veel kontrollimata',
    58 => 'Kontrolli n��d',
    59 => '<p>K�igi n�htaval olevate linkide kontrollimiseks, kl�psa palun allpool oleval lingil "Kontrolli n��d". Pane t�hele, et kontrollimine v�ib s�ltuvalt n�htaval olevate linkide arvust v�tta veidi aega.</p>',
    60 => 'Kasutaja %s proov<is �igustamatult  muuta kategooriat: %s.',
    61 => 'Linke kategoorias'
);


$LANG_LINKS_STATUS = array(
    100 => 'J�tka',
    101 => 'Vahetan protokolli',
    200 => 'OK',
    201 => 'Loodud',
    202 => 'Kinnitatud',
    203 => 'Ebausaldusv��rne info',
    204 => 'Pole sisu',
    205 => 'Reseti sisu',
    206 => 'Osaline sisu',
    300 => 'Mitu valikut',
    301 => 'P�sivalt teises kohas',
    302 => 'Leitud',
    303 => 'Vaata muud',
    304 => 'Pole muudetud',
    305 => 'Kasuta Proxyt',
    307 => 'Ajutine �mbersuunamine',
    400 => 'Halb p�ring',
    401 => 'Pole autoriseeritud',
    402 => 'Tasuline teenus',
    403 => 'Keelatud',
    404 => 'Ei leidnud',
    405 => 'Meetod pole lubatud',
    406 => 'Pole vastuv�etav',
    407 => 'N�utav Proxy kaudu autoriseerimine',
    408 => 'P�ringu ajapiir',
    409 => 'Konflikt',
    410 => 'L�inud',
    411 => 'Pikkus n�utav',
    412 => 'Eeltingimused eba�nnestusid',
    413 => 'P�ringu sisu liiga suur',
    414 => 'P�ringu URI liiga pikk',
    415 => 'Toetamata meedia T��p',
    416 => 'N�utud piirkond pole rahuldatav',
    417 => 'Expectation Failed',
    500 => 'Sisemine serveri viga',
    501 => 'Pole implementeeritud',
    502 => 'Halb Gateway',
    503 => 'Teenus pole saadaval',
    504 => 'Gateway ajapiir',
    505 => 'HTTP Versioon pole toetatud',
    999 => '�henduse ajapiir'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => 'Lingid',
    'title' => 'Linkide haldur'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => 'Lingid vajavad sisselogimist?',
    'linksubmission' => 'Luba linkide puhver?',
    'newlinksinterval' => 'Uute linkide intervall',
    'hidenewlinks' => 'Peida uued lingid',
    'hidelinksmenu' => 'Peida linkide men��punkt',
    'linkcols' => 'Kategooriaid veerus',
    'linksperpage' => 'Linke lehel',
    'show_top10' => 'N�ita top 10 linki?',
    'notification' => 'Teavituskiri?',
    'delete_links' => 'Kustuta lingid, omanikuks?',
    'aftersave' => 'P�rast linkide salvestamist',
    'show_category_descriptions' => 'N�ita kategooriate kirjeldust?',
    'new_window' => 'Ava v�lised lingid uues aknas?',
    'root' => 'Peakategooria ID',
    'default_permissions' => 'Linkide vaikimisi �igused',
    'category_permissions' => 'Kategooria vaikimisi �igused'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'Peah��lestused'
);

$LANG_fs['links'] = array(
    'fs_public' => 'Avalike linkide loetelu h��lestused',
    'fs_admin' => 'Linkide Admin h��lestused',
    'fs_permissions' => 'Vaikimisi �igused',
    'fs_cpermissions' => 'Kategooria �igused'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('Jah' => 1, 'Ei' => 0),
    1 => array('Jah' => true, 'Ei' => false),
    9 => array('Suuna edasi lingitud lehele' => 'item', 'N�ita administreerimisloetelu' => 'list', 'N�ita avalikku loetelu' => 'plugin', 'N�ita avalehte' => 'home', 'N�ita Admini lehte' => 'admin'),
    12 => array('Pole ligip��su' => 0, 'Ainult loetav' => 2, 'Loetav ja muudetav' => 3)
);

?>
