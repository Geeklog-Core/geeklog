<?php

###############################################################################
# estonian_utf-8.php
# This is the Estonian language file for the Geeklog Link plugin
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
    117 => 'Teata mittetöötavast lingist',
    118 => 'Mittetöötavast lingist teatamine',
    119 => 'Järgmisest lingist on teatatud kui mittetöötavast: ',
    120 => 'Lingi toimetamiseks kliki siin: ',
    121 => 'Mittetöötavast lingist teatas: ',
    122 => 'Täname mittetöötavast lingist teatamise eest. Administraator parandab lingi nii ruttu kui võimalik.',
    123 => 'Täname sind',
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
    'stats_no_hits' => 'Näib, et lehel pole linke või keegi pole neil klõpsanud.'
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
    5 => 'Kui muu, siis määratle',
    6 => 'Viga: puudub kategooria',
    7 => 'Kui valid "Muu", määratle ka kategooria nimi',
    8 => 'Tiitel',
    9 => 'URL',
    10 => 'Kategooria',
    11 => 'Sisestatud lingid'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Täname sind {$_CONF['site_name']} lehele lingi sisestamise eest. See on saadetud meie meeskonnale kinnitamiseks. Kui meeskond kinnitab selle lingi, ilmub see <a href=\"{$_CONF['site_url']}/links/\">Linkide osas.</a>";
$PLG_links_MESSAGE2 = 'Sinu link on edukalt salvestatud.';
$PLG_links_MESSAGE3 = 'Link on edukalt kustutatud';
$PLG_links_MESSAGE4 = "Täname sind {$_CONF['site_name']}  lehele lingi lisamise eest. Sa võid seda linki juba näha <a href=\"{$_CONF['site_url']}/links/\">linkide osas.</a>";
$PLG_links_MESSAGE5 = 'Sul pole piisavalt ligipääsuõigusi selle kategooria vaatamiseks.';
$PLG_links_MESSAGE6 = 'Sul pole piisavalt õigusi selle kategooria toimetamiseks.';
$PLG_links_MESSAGE7 = 'Palun sisesta kategooria nimi ja kirjeldus.';
$PLG_links_MESSAGE10 = 'Sinu kategooria on edukalt salvestatud.';
$PLG_links_MESSAGE11 = 'Sa ei saa kategooria ID-ks määrata "site" või "user" - need on reserveeritud sisemiseks kasutamiseks.';
$PLG_links_MESSAGE12 = 'Sa proovid teha vanemkategooriast selle kategooria alamkategooria alamkategooriat. Nii tekiks orbkategooria. Palun vii enne alamkategooriad kõrgemale tasemele.';
$PLG_links_MESSAGE13 = 'Kategooria on edukalt kustutatud.';
$PLG_links_MESSAGE14 = 'Kategooria sisaldab linke või alamkategooriaid. Eemalda need enne.';
$PLG_links_MESSAGE15 = 'Sul pole piisavalt õigusi, et seda kategooriat kustutada.';
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
    10 => 'Sa pead määrama lingi URL-i, tiitli ja kirjelduse.',
    11 => 'Lingi haldur',
    12 => 'Lingi toimetamiseks või kustutamiseks klõpsa allpool vastava lingi juures oleval toimetamisikoonil. Uue lingi loomiseks klõpsa "Tee uus" ülal.',
    14 => 'Lingi kategooria',
    16 => 'Ligipääs tõkestatud',
    17 => "Sa proovisid ligi pääseda lingile, milleks pole sul õigust. See katse on logitud. Palun <a href=\"{$_CONF['site_admin_url']}/plugins/links/\"> mine tagasi linkide administreerimislehele.</a>",
    20 => 'Kui muu, siis määratle',
    21 => 'salvesta',
    22 => 'tühista',
    23 => 'kustuta',
    24 => 'Ei leidnud linki',
    25 => 'Ei leidnud seda linki, mille valisid toimetamiseks.',
    26 => 'Kontrolli linke',
    27 => 'HTML Staatus',
    28 => 'Toimeta kategooriat',
    29 => 'Sisesta allpool kategooria detaile või toimeta neid.',
    30 => 'Kategooria',
    31 => 'Kirjeldus',
    32 => 'Kategooria ID',
    33 => 'Rubriik',
    34 => 'Ülemine',
    35 => 'Kõik',
    40 => 'Toimeta kategooriat',
    41 => 'Loo alamkategooria',
    42 => 'Kustuta see kategooria',
    43 => 'Lehe kategooriad',
    44 => 'Lisa&nbsp;alam',
    46 => 'Kasutaja %s püüdis kustutada kategooriat, mille jaoks polnud tal ligipääsuõigusi',
    50 => 'Loetle kategooriaid',
    51 => 'Uus link',
    52 => 'Uus kategooria',
    53 => 'Loetle linke',
    54 => 'Kategooriahaldur',
    55 => 'Toimeta allpool olevaid kategooriaid. Pane tähele, et sa ei saa kustutada kategooriaid, milles on alamkategooriaid või linke. Kustuta need eelnevalt või vii need mõnda teise kategooriasse.',
    56 => 'Kategooriatoimetaja',
    57 => 'Veel kontrollimata',
    58 => 'Kontrolli nüüd',
    59 => '<p>Kõigi nähtaval olevate linkide kontrollimiseks, klõpsa palun allpool oleval lingil "Kontrolli nüüd". Pane tähele, et kontrollimine võib sõltuvalt nähtaval olevate linkide arvust võtta veidi aega.</p>',
    60 => 'Kasutaja %s proovis õigustamatult  muuta kategooriat: %s.',
    61 => 'Links in Category'
);


$LANG_LINKS_STATUS = array(
    100 => 'Jätka',
    101 => 'Vahetan protokolli',
    200 => 'OK',
    201 => 'Loodud',
    202 => 'Kinnitatud',
    203 => 'Ebausaldusväärne info',
    204 => 'Pole sisu',
    205 => 'Reseti sisu',
    206 => 'Osaline sisu',
    300 => 'Mitu valikut',
    301 => 'Püsivalt teises kohas',
    302 => 'Leitud',
    303 => 'Vaata muud',
    304 => 'Pole muudetud',
    305 => 'Kasuta Proxyt',
    307 => 'Ajutine ümbersuunamine',
    400 => 'Halb päring',
    401 => 'Pole autoriseeritud',
    402 => 'Tasuline teenus',
    403 => 'Keelatud',
    404 => 'Ei leidnud',
    405 => 'Meetod pole lubatud',
    406 => 'Pole vastuvõetav',
    407 => 'Nõutav Proxy kaudu autoriseerimine',
    408 => 'Päringu ajapiir',
    409 => 'Konflikt',
    410 => 'Läinud',
    411 => 'Pikkus nõutav',
    412 => 'Eeltingimused ebaõnnestusid',
    413 => 'Päringu sisu liiga suur',
    414 => 'Päringu URI liiga pikk',
    415 => 'Toetamata meedia Tüüp',
    416 => 'Nõutud piirkond pole rahuldatav',
    417 => 'Expectation Failed',
    500 => 'Sisemine serveri viga',
    501 => 'Pole implementeeritud',
    502 => 'Halb Gateway',
    503 => 'Teenus pole saadaval',
    504 => 'Gateway ajapiir',
    505 => 'HTTP Versioon pole toetatud',
    999 => 'Ühenduse ajapiir'
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
    'hidelinksmenu' => 'Peida linkide menüüpunkt',
    'linkcols' => 'Kategooriaid veerus',
    'linksperpage' => 'Linke lehel',
    'show_top10' => 'Näita top 10 linki?',
    'notification' => 'Teavituskiri?',
    'delete_links' => 'Kustuta lingid, omanikuks?',
    'aftersave' => 'Pärast linkide salvestamist',
    'show_category_descriptions' => 'Näita kategooriate kirjeldust?',
    'new_window' => 'Ava välised lingid uues aknas?',
    'root' => 'Peakategooria ID',
    'default_permissions' => 'Linkide vaikimisi õigused',
    'category_permissions' => 'Kategooria vaikimisi õigused'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'Peahäälestused'
);

$LANG_fs['links'] = array(
    'fs_public' => 'Avalike linkide loetelu häälestused',
    'fs_admin' => 'Linkide Admin häälestused',
    'fs_permissions' => 'Vaikimisi õigused',
    'fs_cpermissions' => 'Kategooria õigused'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('Jah' => 1, 'Ei' => 0),
    1 => array('Jah' => true, 'Ei' => false),
    9 => array('Suuna edasi lingitud lehele' => 'item', 'Näita administreerimisloetelu' => 'list', 'Näita avalikku loetelu' => 'plugin', 'Näita avalehte' => 'home', 'Näita Admini lehte' => 'admin'),
    12 => array('Pole ligipääsu' => 0, 'Ainult loetav' => 2, 'Loetav ja muudetav' => 3)
);

?>
