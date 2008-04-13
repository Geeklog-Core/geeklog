<?php

###############################################################################
# czech.php
# This is the czech language (ISO 8859-2) page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2007 Ondrej Rusek
# rusek@gybon.cz
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
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Kalendáø událostí',
    2 => 'Bohu¾el. ¾ádné události k zobrazení.',
    3 => 'Kdy',
    4 => 'Kde',
    5 => 'Popis',
    6 => 'Pøidat událost',
    7 => 'Blí¾ící se události',
    8 => 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "My Calendar" from the User Functions area.',
    9 => 'Pøidat do osobního kalendáøe.',
    10 => 'Odebrat z mého kalendáøe',
    11 => "Pøidat událost do osobního kalendáøe u¾ivatele %s",
    12 => 'Událost',
    13 => 'Zaèátek',
    14 => 'Konec',
    15 => 'Zpìt na kalendáø',
    16 => 'Kalendáø',
    17 => 'Poèáteèní datum',
    18 => 'Koncové datum',
    19 => 'Po¾adavky kalendáøe',
    20 => 'Titulek',
    21 => 'Poèáteèní datum',
    22 => 'URL',
    23 => 'Tvoje události',
    24 => 'Události webu',
    25 => '®ádné blí¾ící se události',
    26 => 'Poslat událost',
    27 => "Odesláním události pro {$_CONF['site_name']} pøidáte va¹i událost do hlavního kalendáøe. Po odeslání bude událost podrobena schválení a poté bude publikována v hlavním kalendáøi.",
    28 => 'Titulek',
    29 => 'Èas konce',
    30 => 'Èas zaèátku',
    31 => 'V¹echny události dne',
    32 => 'Adresa 1',
    33 => 'Adresa 2',
    34 => 'Mìsto',
    35 => 'Stát',
    36 => 'PSÈ',
    37 => 'Typ události',
    38 => 'Editovat typy událostí',
    39 => 'Umístìní',
    40 => 'Pøidat událost do',
    41 => 'Hlavní kalendáø',
    42 => 'Osobní kalendáø',
    43 => 'Odkaz',
    44 => 'HTML tagy nejsou povoleny',
    45 => 'Odeslat',
    46 => 'Události v systému',
    47 => 'Top Ten událostí',
    48 => 'Kliknutí',
    49 => '®ádné události.',
    50 => 'Události',
    51 => 'Vymazat'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Výsledky kalendáøe',
    'title' => 'Titulek',
    'date_time' => 'Datum & Èas',
    'location' => 'Umístìní',
    'description' => 'Popis'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Pøidat osobní událost',
    9 => '%s událost',
    10 => 'Události pro',
    11 => 'Hlavní kalendáø',
    12 => 'Mùj kalendáø',
    25 => 'Zpìt do ',
    26 => 'Celý den',
    27 => 'Týden',
    28 => 'Osobní kalendáø pro',
    29 => 'Veøejný kalendáø',
    30 => 'vymazat událost',
    31 => 'Pøidat',
    32 => 'Událost',
    33 => 'Datum',
    34 => 'Èas',
    35 => 'Rychle pøidat',
    36 => 'Odeslat',
    37 => 'Bohu¾el, pou¾ití osobního kalendáøe není povoleno',
    38 => 'Osobní editor událostí',
    39 => 'Den',
    40 => 'Týden',
    41 => 'Mìsíc',
    42 => 'Pøidat hlavní událost',
    43 => 'Po¾adavky událostí',
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Editor událostí',
    2 => 'Chyba',
    3 => 'Post Mode',
    4 => 'URL události',
    5 => 'Datum zaèátku',
    6 => 'Datum konce',
    7 => 'Umístìní události',
    8 => 'Popis události',
    9 => '(vèetnì http://)',
    10 => 'Musíte zadata datum/èas, titulek a popis',
    11 => 'Správce kalendáøe',
    12 => 'Pro zmìnu nebo vymazání události, kliknìte na ikonu události.  Pro vytvoøení nové události, kliknìte na "Vytvoøit novou". Kliknutím na ikonu kopie vytvoøíte kopii události.',
    13 => 'Autor',
    14 => 'Datum zaèátku',
    15 => 'Datum konce',
    16 => '',
    17 => "Pøistupujete k události, na kterou nemáte dostateèná práva. Tento pokus byl zalogován. Prosím, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">vra»e ze zpìt na administraci událostí</a>.",
    18 => '',
    19 => '',
    20 => 'ulo¾it',
    21 => 'cancel',
    22 => 'vymazat',
    23 => 'Chybný datum zaèátku.',
    24 => 'Chybný datum konce.',
    25 => 'Koncové datum je pøed datem zaèátku.'
);

$LANG_CAL_MESSAGE = array(
    'save'      => 'Událost byla úspì¹nì ulo¾ena.',
    'delete'    => 'Událost byla úspì¹nì vymazána.',
    'private'   => 'Událost byla ulo¾ena do va¹eho osobního kalendáøe',
    'login'     => 'Nemohu otevøít vá¹ osobní kalendáø dokud se nepøihlásíte',
    'removed'   => 'Událost byla odstranìna z va¹eho osobního kalendáøe',
    'noprivate' => 'Bohu¾el, osobní kalendáøe tento server nepodporuje',
    'unauth'    => 'Bohu¾el, nemáte administrátorský pøístup. Tento vá¹ pokus byl zalogován',
);

$PLG_calendar_MESSAGE4  = "Dìkujeme za odeslání události pro {$_CONF['site_name']}.  Nyní oèekává potvrzení.  Jakmile bude potvrzena, naleznete ji v <a href=\"{$_CONF['site_url']}/calendar/index.php\">kalendáøi</a>.";
$PLG_calendar_MESSAGE17 = 'Událost byla úspì¹nì ulo¾ena.';
$PLG_calendar_MESSAGE18 = 'Událost byla úspì¹nì vymazána.';
$PLG_calendar_MESSAGE24 = 'Událost byla ulo¾ena do kalendáøe.';
$PLG_calendar_MESSAGE26 = 'Událost byla vymazána.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

?>
