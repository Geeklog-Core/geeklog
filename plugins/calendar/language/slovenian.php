<?php

###############################################################################
# slovenian.php - version 1.4.1
# This is the slovenian language page for the Geeklog Calendar Plug-in!
# language file for geeklog version 1.4.1 beta by mb
# gape@gape.org ; za pripombe, predloge ipd ... piši na email
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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
    1 => 'Koledar dogodkov',
    2 => 'Trenutno ni v koledar vpisanega nobenega dogodka.',
    3 => 'Kdaj',
    4 => 'Kje',
    5 => 'Opis',
    6 => 'Dodaj dogodek',
    7 => 'Prihajajoèi dogodki',
    8 => 'Ko bo novi dogodek dodan v tvoj osebni koledar, lahko s klikom na "Moj koledar" v meniju "Uporabniške funkcije" hitro pregledaš le tiste dogodke, ki te zanimajo.',
    9 => 'Dodaj v Moj koledar',
    10 => 'Odstrani iz Mojega koledarja',
    11 => 'Dodajanje dogodka v %s koledar',
    12 => 'Dogodek',
    13 => 'Zaèetek',
    14 => 'Konec',
    15 => 'Nazaj na Koledar',
    16 => 'Koledar',
    17 => 'Datum zaèetka',
    18 => 'Datum konca',
    19 => 'Èakajoèi dogodki',
    20 => 'Naslov',
    21 => 'Datum zaèetka',
    22 => 'URL',
    23 => 'Tvoji dogodki',
    24 => 'Dogodki te strani',
    25 => 'Ni prihajajoèih dogodkov',
    26 => 'Oddaj dogodek',
    27 => "Oddaja dogodka na spletnem mestu {$_CONF['site_name']} bo tvoj dogodek dodala na glavni koledar, od koder lahko uporabniki tvoj dogodek dodajo v svoje osebne koledarje. Ta funkcija <b>NI</b> namenjena shranjevanju osebnih dogodkov, kot so rojstni dnevi in obletnice.<br" . XHTML . "><br" . XHTML . ">Ko svoj dogodek oddaš, bo poslan upravnikom, in èe bo odobren, se bo pojavil v glavnem koledarju.",
    28 => 'Naslov',
    29 => 'Konèni èas',
    30 => 'Zaèetni èas',
    31 => 'Celodnevni dogodek',
    32 => 'Naslov 1',
    33 => 'Naslov 2',
    34 => 'Mesto/Kraj',
    35 => 'Pokrajina',
    36 => 'Poštna številka',
    37 => 'Vrsta dogodka',
    38 => 'Uredi vrste dogodkov',
    39 => 'Lokacija',
    40 => 'Dodaj dogodek v',
    41 => 'Glavni koledar',
    42 => 'Osebni koledar',
    43 => 'Povezava',
    44 => 'Oblikovanje HTML ni dovoljeno',
    45 => 'Oddaj',
    46 => 'Dogodki v sistemu',
    47 => 'Najboljših 10 dogodkov',
    48 => 'Zadetki',
    49 => 'Izgleda, da na tem mestu ni dogodkov ali pa še nikoli ni nihèe kliknil na nobenega.',
    50 => 'Dogodki',
    51 => 'Izbriši'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Rezultati koledarja',
    'title' => 'Naslov',
    'date_time' => 'Datum & ura',
    'location' => 'Kraj',
    'description' => 'Opis'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Dodaj osebni dogodek',
    9 => '%s dogodek',
    10 => 'Dogodki za',
    11 => 'Glavni koledar',
    12 => 'Moj koledar',
    25 => 'Nazaj na ',
    26 => 'Ves dan',
    27 => 'Teden',
    28 => 'Osebni koledar za',
    29 => 'Javni koledar',
    30 => 'izbriši dogodek',
    31 => 'Dodaj',
    32 => 'Dogodek',
    33 => 'Datum',
    34 => 'Ura',
    35 => 'Hitro dodajanje',
    36 => 'Oddaj',
    37 => 'Žal funkcija osebnega koledarja na tej strani ni omogoèena',
    38 => 'Urejevalnik osebnih dogodkov',
    39 => 'Dan',
    40 => 'Teden',
    41 => 'Mesec',
    42 => 'Dodaj glavni dogodek',
    43 => 'Dogodki'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Urejevalnik dogodkov',
    2 => 'Napaka',
    3 => 'Oblikovanje',
    4 => 'URL dogodka',
    5 => 'Zaèetek dogodka',
    6 => 'Zakljuèek dogodka',
    7 => 'Kraj dogodka',
    8 => 'Opis dogodka',
    9 => '(vkljuèi http://)',
    10 => 'Doloèiti moraš datume/ure, naslov dogodka in opis',
    11 => 'Upravljalnik koledarja',
    12 => 'Za spreminjanje ali izbris dogodka klikni na njegovo ikono za urejanje spodaj. Za ustvarjenje novega dogodka klikni na "Ustvari novega" zgoraj. Za ustvarjenje kopije že obstojeèega dogodka klikni na ikono za kopiranje.',
    13 => 'Avtor',
    14 => 'Zaèetni datum',
    15 => 'Konèni datum',
    16 => '',
    17 => "Poskušaš dostopiti do dogodka, za katerega nimaš pravic. Ta poskus je bil zabeležen. Prosim <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">pojdi nazaj na zaslon za upravljanje dogodkov</a>.",
    18 => '',
    19 => '',
    20 => 'shrani',
    21 => 'preklièi',
    22 => 'izbriši',
    23 => 'Napaèen zaèetni datum.',
    24 => 'Napaèen konèni datum.',
    25 => 'Konèni datum je pred zaèetnim datumom.',
    26 => 'Delete old entries',
    27 => 'These are the events that are older than ',
    28 => ' months. Please click on the trashcan Icon on the bottom to delete them, or select a different timespan:<br' . XHTML . '>Find all entries that are older than ',
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
    'save' => 'Tvoj dogodek je uspešno shranjen.',
    'delete' => 'Dogodek je uspešno izbrisan.',
    'private' => 'Dogodek je shranjen v tvoj koledar.',
    'login' => 'Ne morem odpreti tvojega osebnega koledarja, dokler se ne prijaviš',
    'removed' => 'Dogodek je uspešno odstranjen iz tvojega osebnega koledarja',
    'noprivate' => 'Žal osebni koledarji na tem spletnem mestu niso omogoèeni',
    'unauth' => 'Žal nimaš dostopa do strani za upravljanje dogodkov. Vsi poskusi dostopa do nepooblašèenih funkcij se beležijo.'
);

$PLG_calendar_MESSAGE4 = "Hvala, da si dogodek oddal/a na spletno mesto {$_CONF['site_name']}. Pred objavo ga bo pregledal eden od urednikov. Èe bo odobren, bo objavljen in dan na razpolago bralcem te spletne strani v razdelku <a href=\"{$_CONF['site_url']}/calendar/index.php\">koledar</a>.";
$PLG_calendar_MESSAGE17 = 'Tvoj dogodek je uspešno shranjen.';
$PLG_calendar_MESSAGE18 = 'Dogodek je uspešno izbrisan.';
$PLG_calendar_MESSAGE24 = 'Dogodek je shranjen v tvoj koledar.';
$PLG_calendar_MESSAGE26 = 'Dogodek je uspešno izbrisan.';

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
