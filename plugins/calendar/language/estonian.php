<?php

###############################################################################
# estonian.php
# This is the estonian language page for the Geeklog Calendar Plug-in!
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

# index.php
$LANG_CAL_1 = array(
    1 => 'S�ndmuste kalender',
    2 => 'Kahjuks pole �htegi s�ndmust, mida n�idata.',
    3 => 'Millal',
    4 => 'Kus',
    5 => 'Kirjeldus',
    6 => 'Lisa s�ndmus',
    7 => 'Tuleviku s�ndmused',
    8 => 'Lisades selle s�ndmuse oma kalendrisse saad kiire �levaate just sind huvitavatest s�ndmustest, kui kl�psad "Kasutaja funktsioonid" valikute hulgas "Minu kalender".',
    9 => 'Lisa minu kalendrisse',
    10 => 'Eemalda minu kalendrist',
    11 => "S�ndmuse lisamine {$_USER['username']} kalendrisse",
    12 => 'S�ndmus',
    13 => 'Algab',
    14 => 'L�peb',
    15 => 'Tagasi kalendrisse',
    16 => 'Kalender',
    17 => 'Algusp�ev',
    18 => 'L�pup�ev',
    19 => 'Sisestused kalendrisse',
    20 => 'Tiitel',
    21 => 'Algusaeg',
    22 => 'URL',
    23 => 'Sinu s�ndmused',
    24 => 'S�ndmused',
    25 => 'Pole tulevasi s�ndmusi',
    26 => 'Lisa s�ndmus',
    27 => "Lisades {$_CONF['site_name']} lehele s�ndmuse, paigutub see peakalendrisse, kust kasutajad saavad soovi korral lisada selle oma enda isiklikku kalendrisse. Lehe kalender <b>ei ole </b> m�eldud teieisiklike s�ndmuste, nagu s�nnip�evade v�i t�htp�evade jaoks.<br" . XHTML . "><br" . XHTML . ">P�rast s�ndmuse lisamist saadetakse see meie administraatoritele. Administraatorite poolt kinnitatud s�ndmus ilmub peakalendrisse.",
    28 => 'Tiitel',
    29 => 'L�puaeg',
    30 => 'Algusaeg',
    31 => 'Kogu p�eva s�ndmus',
    32 => 'Aadressrida 1',
    33 => 'Aadressrida 2',
    34 => 'Linn',
    35 => 'Piirkond',
    36 => 'postiindeks',
    37 => 'S�ndmuse t��p',
    38 => 'Toimeta s�ndmuste t��pe',
    39 => 'Asukoht',
    40 => 'Lisa s�ndmus - ',
    41 => 'Peakalender',
    42 => 'Isiklik kalender',
    43 => 'Link',
    44 => 'HTML sildid pole lubatud',
    45 => 'Sisesta',
    46 => 'S�ndmused lehel',
    47 => 'Top 10 s�ndmust',
    48 => 'klikke',
    49 => 'N�ib, et saidil pole �htegi s�ndmust v�i mitte keegi pole neil kl�psanud.',
    50 => 'S�ndmused',
    51 => 'Kustuta'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Kalendri tulemused',
    'title' => 'Tiitel',
    'date_time' => 'P�ev ja kellaaeg',
    'location' => 'Asukoht',
    'description' => 'Kirjeldus'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Lisa s�ndmus',
    9 => '%s s�ndmus',
    10 => 'S�ndmused, kasutaja',
    11 => 'Peakalender',
    12 => 'Minu kalender',
    25 => 'tagasi ',
    26 => 'K�ik p�evad',
    27 => 'N�dal',
    28 => 'Isiklik kalender, kasutaja',
    29 => 'Avalik kalender',
    30 => 'kustuta s�ndmus',
    31 => 'Lisa',
    32 => 'S�ndmus',
    33 => 'Kuup�ev',
    34 => 'Aeg',
    35 => 'Kiirlisamine',
    36 => 'Sisesta',
    37 => 'Isiklik kalender ei ole sellel lehel kahjuks aktiveeritud.',
    38 => 'Isiklik s�ndmuste toimetaja',
    39 => 'P�ev',
    40 => 'N�dal',
    41 => 'Kuu',
    42 => 'Lisa peas�ndmus',
    43 => 'Sisestatud s�ndmused'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'S�ndmuste toimetaja',
    2 => 'Viga',
    3 => 'S�ndmuse tiitel',
    4 => 'S�ndmuse URL',
    5 => 'S�ndmuse algusaeg',
    6 => 'S�ndmuse l�puaeg',
    7 => 'S�ndmuse asukoht',
    8 => 'S�ndmuse kirjeldus',
    9 => '(koos http://)',
    10 => 'Sa pead m��rama s�ndmuse aja ja kellaaja, tiitli ja kirjelduse',
    11 => 'S�ndmuste haldaja',
    12 => 'S�ndmuse toimetamiseks v�i kustutamiseks kl�psa allpool selle tiitlil.  Uue s�ndmuse loomiseks kl�psa Tee uus �lal. Kl�psa [C] olemasolevast s�ndmusest koopia tegemiseks.',
    13 => 'S�ndmuse tiitel',
    14 => 'Algusp�ev',
    15 => 'l�pup�ev',
    16 => '',
    17 => "Sa proovisid ligi p��seda s�ndmusele, millele sul pole �igust ligi p��seda. See katse on logitud. Palun <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/\">mine tagasi s�ndmuste haldamise lehele</a>.",
    18 => '',
    19 => '',
    20 => 'salvesta',
    21 => 't�hista',
    22 => 'kustuta',
    23 => 'Sobimatu algusaeg.',
    24 => 'Sobimatu l�puaeg.',
    25 => 'L�puaeg on enne algusaega.',
    26 => 'Delete old entries',
    27 => 'These are the events that are older than ',
    28 => ' months. Please click on the trashcan Icon on the bottom to delete them, or select a different timespan:<brXHTML>Find all entries that are older than ',
    29 => ' months.',
    30 => 'Update List',
    31 => 'Are You sure you want to permanently delete ALL selected users?',
    32 => 'List all',
    33 => 'No events selected for deletion',
    34 => 'Event ID',
    35 => 'could not be deleted',
    36 => 'Sucessfully deleted'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'Sinu s�ndmus on edukalt salvestatud.',
    'delete' => 'S�ndmus on edukalt kustutatud.',
    'private' => 'S�ndmus on sinu kalendrisse salvestatud.',
    'login' => 'Ei saa enne sinu sisselogimist sinu isiklikku kalendrit avada',
    'removed' => 'S�ndmus on sinu isiklikust kalendrist kustutatud.',
    'noprivate' => 'Kahjuks pole sellel lehel isiklikud kalendrid kasutuses.',
    'unauth' => 'Sul pole ligip��su s�ndmuste haldamise lehele. Pane t�hele, et k�ik sellised lubamatud katsed logitakse'
);

$PLG_calendar_MESSAGE4 = "T�name sind {$_CONF['site_name']} lehele s�ndmuse sisestamise eest.  See saadeti meie meeskonnale kinnitamiseks. P�rast kinnitamist on see s�ndmus n�ha <a href=\"{$_CONF['site_url']}/calendar/\">kalendri</a> osas.";
$PLG_calendar_MESSAGE17 = 'S�ndmus on edukalt salvestatud.';
$PLG_calendar_MESSAGE18 = 'Sinu s�ndmus on edukalt kustutatud.';
$PLG_calendar_MESSAGE24 = 'S�ndmus on salvestatud sinu kalendrisse.';
$PLG_calendar_MESSAGE26 = 'S�ndmus on edukalt kustutatud.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendar',
    'title' => 'Calendar Configuration'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Calendar Login Required?',
    'hidecalendarmenu' => 'Hide Calendar Menu Entry?',
    'personalcalendars' => 'Enable Personal Calendars?',
    'eventsubmission' => 'Enable Submission Queue?',
    'showupcomingevents' => 'Show upcoming Events?',
    'upcomingeventsrange' => 'Upcoming Events Range',
    'event_types' => 'Event Types',
    'hour_mode' => 'Hour Mode',
    'notification' => 'Notification Email?',
    'delete_event' => 'Delete Events with Owner?',
    'aftersave' => 'After Saving Event',
    'default_permissions' => 'Event Default Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>