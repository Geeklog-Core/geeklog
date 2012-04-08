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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Kalendář událostí',
    2 => 'Bohužel. žádné události k zobrazení.',
    3 => 'Kdy',
    4 => 'Kde',
    5 => 'Popis',
    6 => 'Přidat událost',
    7 => 'Blížící se události',
    8 => 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "My Calendar" from the User Functions area.',
    9 => 'Přidat do osobního kalendáře.',
    10 => 'Odebrat z mého kalendáře',
    11 => 'Přidat událost do osobního kalendáře uživatele %s',
    12 => 'Událost',
    13 => 'Začátek',
    14 => 'Konec',
    15 => 'Zpět na kalendář',
    16 => 'Kalendář',
    17 => 'Počáteční datum',
    18 => 'Koncové datum',
    19 => 'Požadavky kalendáře',
    20 => 'Titulek',
    21 => 'Počáteční datum',
    22 => 'URL',
    23 => 'Tvoje události',
    24 => 'Události webu',
    25 => 'Žádné blížící se události',
    26 => 'Poslat událost',
    27 => "Odesláním události pro {$_CONF['site_name']} přidáte vaši událost do hlavního kalendáře. Po odeslání bude událost podrobena schválení a poté bude publikována v hlavním kalendáři.",
    28 => 'Titulek',
    29 => 'Čas konce',
    30 => 'Čas začátku',
    31 => 'Všechny události dne',
    32 => 'Adresa 1',
    33 => 'Adresa 2',
    34 => 'Město',
    35 => 'Stát',
    36 => 'PSČ',
    37 => 'Typ události',
    38 => 'Editovat typy událostí',
    39 => 'Umístění',
    40 => 'Přidat událost do',
    41 => 'Hlavní kalendář',
    42 => 'Osobní kalendář',
    43 => 'Odkaz',
    44 => 'HTML tagy nejsou povoleny',
    45 => 'Odeslat',
    46 => 'Události v systému',
    47 => 'Top Ten událostí',
    48 => 'Kliknutí',
    49 => 'Žádné události.',
    50 => 'Události',
    51 => 'Vymazat',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Výsledky kalendáře',
    'title' => 'Titulek',
    'date_time' => 'Datum & Čas',
    'location' => 'Umístění',
    'description' => 'Popis'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Přidat osobní událost',
    9 => '%s událost',
    10 => 'Události pro',
    11 => 'Hlavní kalendář',
    12 => 'Můj kalendář',
    25 => 'Zpět do ',
    26 => 'Celý den',
    27 => 'Týden',
    28 => 'Osobní kalendář pro',
    29 => 'Veřejný kalendář',
    30 => 'vymazat událost',
    31 => 'Přidat',
    32 => 'Událost',
    33 => 'Datum',
    34 => 'Čas',
    35 => 'Rychle přidat',
    36 => 'Odeslat',
    37 => 'Bohužel, použití osobního kalendáře není povoleno',
    38 => 'Osobní editor událostí',
    39 => 'Den',
    40 => 'Týden',
    41 => 'Měsíc',
    42 => 'Přidat hlavní událost',
    43 => 'Požadavky událostí'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Editor událostí',
    2 => 'Chyba',
    3 => 'Post Mode',
    4 => 'URL události',
    5 => 'Datum začátku',
    6 => 'Datum konce',
    7 => 'Umístění události',
    8 => 'Popis události',
    9 => '(včetně http://)',
    10 => 'Musíte zadata datum/čas, titulek a popis',
    11 => 'Správce kalendáře',
    12 => 'Pro změnu nebo vymazání události, klikněte na ikonu události.  Pro vytvoření nové události, klikněte na "Vytvořit novou". Kliknutím na ikonu kopie vytvoříte kopii události.',
    13 => 'Autor',
    14 => 'Datum začátku',
    15 => 'Datum konce',
    16 => '',
    17 => "Přistupujete k události, na kterou nemáte dostatečná práva. Tento pokus byl zalogován. Prosím, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">vraťe ze zpět na administraci událostí</a>.",
    18 => '',
    19 => '',
    20 => 'uložit',
    21 => 'cancel',
    22 => 'vymazat',
    23 => 'Chybný datum začátku.',
    24 => 'Chybný datum konce.',
    25 => 'Koncové datum je před datem začátku.',
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
    'save' => 'Událost byla úspěšně uložena.',
    'delete' => 'Událost byla úspěšně vymazána.',
    'private' => 'Událost byla uložena do vašeho osobního kalendáře',
    'login' => 'Nemohu otevřít váš osobní kalendář dokud se nepřihlásíte',
    'removed' => 'Událost byla odstraněna z vašeho osobního kalendáře',
    'noprivate' => 'Bohužel, osobní kalendáře tento server nepodporuje',
    'unauth' => 'Bohužel, nemáte administrátorský přístup. Tento váš pokus byl zalogován'
);

$PLG_calendar_MESSAGE4 = "Děkujeme za odeslání události pro {$_CONF['site_name']}.  Nyní očekává potvrzení.  Jakmile bude potvrzena, naleznete ji v <a href=\"{$_CONF['site_url']}/calendar/index.php\">kalendáři</a>.";
$PLG_calendar_MESSAGE17 = 'Událost byla úspěšně uložena.';
$PLG_calendar_MESSAGE18 = 'Událost byla úspěšně vymazána.';
$PLG_calendar_MESSAGE24 = 'Událost byla uložena do kalendáře.';
$PLG_calendar_MESSAGE26 = 'Událost byla vymazána.';

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
    'default_permissions' => 'Event Default Permissions',
    'autotag_permissions_event' => '[event: ] Permissions',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'General Calendar Settings',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_events_block' => 'Events Block'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
