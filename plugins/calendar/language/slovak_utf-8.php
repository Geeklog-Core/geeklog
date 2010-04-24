<?php

###############################################################################
# slovak_utf-8.php
# This is the Slovak language (UTF-8) file for the Geeklog Calendar plugin
#
# Copyright (C) 2010 Miroslav Fikar
# miroslav.fikar+geeklog@gmail.com
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
    1 => 'Kalendár akcií',
    2 => 'Nie sú žiadne akcie na zobrazenie.',
    3 => 'Kedy',
    4 => 'Kde',
    5 => 'Opis',
    6 => 'Pridať akciu',
    7 => 'Nastávajúce akcie',
    8 => 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "My Calendar" from the User Functions area.',
    9 => 'Pridať do osobného kalendára.',
    10 => 'Odobrať z môjho kalendára',
    11 => 'Pridať akciu do osobného kalendára užívateľa %s',
    12 => 'Akcia',
    13 => 'Začiatok',
    14 => 'Koniec',
    15 => 'Späť na kalendár',
    16 => 'Kalendár',
    17 => 'Začiatočný dátum',
    18 => 'Koncový dátum',
    19 => 'Požiadavky kalendára',
    20 => 'Nadpis',
    21 => 'Začiatočný dátum',
    22 => 'URL',
    23 => 'Tvoje akcie',
    24 => 'Plánované akcie',
    25 => 'Žiadne blížiace sa akcie',
    26 => 'Poslať akciu',
    27 => "Odoslaním akcie pre {$_CONF['site_name']} pridáte vašu akciu do hlavného kalendára. Po odoslaní bude akcia postúpená na schválenie a potom bude publikovaná v hlavnom kalendári.",
    28 => 'Nadpis',
    29 => 'Čas konca',
    30 => 'Čas začiatku',
    31 => 'Všetky akcie dňa',
    32 => 'Adresa 1',
    33 => 'Adresa 2',
    34 => 'Mesto',
    35 => 'Štát',
    36 => 'PSČ',
    37 => 'Typ akcie',
    38 => 'Upraviť typy akcií',
    39 => 'Umiestenie',
    40 => 'Pridať akciu do',
    41 => 'Hlavný kalendár',
    42 => 'Osobný kalendár',
    43 => 'Odkaz',
    44 => 'HTML tagy nie sú povolené',
    45 => 'Odoslať',
    46 => 'Akcie v systéme',
    47 => 'Top Ten akcií',
    48 => 'Kliknutie',
    49 => 'Žiadne akcie.',
    50 => 'Akcie',
    51 => 'Vymazať'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Výsledky kalendára',
    'title' => 'Nadpis',
    'date_time' => 'Dátum & Čas',
    'location' => 'Umiestenie',
    'description' => 'Opis'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Pridať osobnú akciu',
    9 => '%s akcií',
    10 => 'Akcie pre',
    11 => 'Hlavný kalendár',
    12 => 'Môj kalendár',
    25 => 'Späť na ',
    26 => 'Celý deň',
    27 => 'Týždeň',
    28 => 'Osobný kalendár pre',
    29 => 'Verejný kalendár',
    30 => 'Vymazať akciu',
    31 => 'Pridať',
    32 => 'Akcia',
    33 => 'Dátum',
    34 => 'Čas',
    35 => 'Rýchle pridať',
    36 => 'Odoslať',
    37 => 'Bohužiaľ, použitie osobného kalendára nie je povolené',
    38 => 'Osobný editor akcií',
    39 => 'Deň',
    40 => 'Týždeň',
    41 => 'Mesiac',
    42 => 'Pridať hlavnú akciu',
    43 => 'Požiadavky akcií'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Editor akcií',
    2 => 'Chyba',
    3 => 'Post Mode',
    4 => 'URL akcie',
    5 => 'Dátum začiatku',
    6 => 'Dátum konca',
    7 => 'Umiestenie akcie',
    8 => 'Opis akcie',
    9 => '(vrátane http://)',
    10 => 'Musíte zadať dátum/čas, nadpis a opis',
    11 => 'Správca kalendára',
    12 => 'Pre zmenu alebo vymazanie akcie, kliknite na ikonu akcie.  Pre vytvorenie novej akcie, kliknite na "Vytvoriť novú". Kliknutím na ikonu kópie vytvoríte kópiu akcie.',
    13 => 'Autor',
    14 => 'Dátum začiatku',
    15 => 'Dátum konca',
    16 => '',
    17 => "Pristupujete k akcie, na ktorú nemáte dostatečná práva. Tento pokus byl zalogován. Prosím, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">vráťte sa späť na administráciu akcií</a>.",
    18 => '',
    19 => '',
    20 => 'uložiť',
    21 => 'zrušiť',
    22 => 'vymazať',
    23 => 'Chybný dátum začiatku.',
    24 => 'Chybný dátum konca.',
    25 => 'Koncový dátum je pred dátumom začiatku.',
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
    'save' => 'Akcia bola úspešne uložená.',
    'delete' => 'Akcia bola úspešne vymazaná.',
    'private' => 'Akcia bola uložená do vášho osobného kalendára',
    'login' => 'Nemôžem otvoriť váš osobný kalendár pokiaľ sa neprihlásite',
    'removed' => 'Akcia bola odstránená z vášho osobného kalendára',
    'noprivate' => 'Bohužiaľ, osobné kalendáre tento server nepodporuje',
    'unauth' => 'Bohužiaľ, nemáte administrátorský prístup. Tento váš pokus bol zalogovaný'
);

$PLG_calendar_MESSAGE4 = "Ďakujeme za odoslanie akcie pre {$_CONF['site_name']}.  Teraz očakáva potvrdenie.  Akonáhle bude potvrdená, nájdete ju v <a href=\"{$_CONF['site_url']}/calendar/index.php\">kalendári</a>.";
$PLG_calendar_MESSAGE17 = 'Akcia bola úspešne uložená.';
$PLG_calendar_MESSAGE18 = 'Akcia bola úspešne vymazaná.';
$PLG_calendar_MESSAGE24 = 'Akcia bola uložená do kalendára.';
$PLG_calendar_MESSAGE26 = 'Akcia bola vymazaná.';

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
