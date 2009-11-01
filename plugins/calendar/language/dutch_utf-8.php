<?php

###############################################################################
# dutch.php
#
# This is the Dutch language file for the Geeklog Calendar Plugin
#
# Copyright (C) 2007 John van Gaal
# www.vespaclub.nl
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
    1 => 'Gebeurtenis-kalender',
    2 => 'Er zijn geen weer te geven gebeurtenissen.',
    3 => 'Wanneer',
    4 => 'Waar',
    5 => 'Beschrijving',
    6 => 'Gebeurtenis invoegen',
    7 => 'Aaankomende gebeurtenissen',
    8 => 'Wanneer je deze gebeurtenis aan je eigen kalender toevoegd, krijg je sneller een overzicht over alle gebeurtenissen welke je interesseren, als je eenvoudig op "Mijn Kalender" klikt.',
    9 => 'Aan Mijn Kalender toevoegen',
    10 => 'Van mijn Kalender verwijderen',
    11 => 'Gebeurtenis wordt aan kalender van %s toegevoegd',
    12 => 'Gebeurtenis',
    13 => 'Begint',
    14 => 'Eindigt',
    15 => 'Terug naar Kalender',
    16 => 'Kalender',
    17 => 'Startdatum',
    18 => 'Einddatum',
    19 => 'Toevoegen: Kalender',
    20 => 'Titel',
    21 => 'Startdatum',
    22 => 'URL',
    23 => 'Mijn Gebeurtenis',
    24 => 'Algemene gebeurtenissen',
    25 => 'Er zijn geen komende gebeurtenissen',
    26 => 'Een gebeurtenis toevoegen',
    27 => "Wanneer u uw gebeurtenis bij {$_CONF['site_name']} toevoegd, wordt deze in de kalender opgenomen, van waaruit u en anderen deze in de persoonlijke Kalender kunnen overnemen. Dit is <b>NIET</b> ervoor bedoeld, om prive gebeurtenissen zoals verjaardagen te beheren.<br" . XHTML . "><br" . XHTML . ">Wanner u een gebeurtenis indient, wordt deze door de beheerder verder bekeken. En zodra de beheerder het accepteert verschijnt de gebeurtenis in de Kalender.",
    28 => 'Titel',
    29 => 'Eindtijd',
    30 => 'Starttijd',
    31 => 'Hele dag',
    32 => 'Adres 1',
    33 => 'Adres 2',
    34 => 'Stad',
    35 => 'Provincie',
    36 => 'Postcode',
    37 => 'Evenement',
    38 => 'Evenement, veranderen',
    39 => 'Plaats',
    40 => 'Gebeurtenis toevoegen aan',
    41 => 'Kalender',
    42 => 'Persoonlijke Kalender',
    43 => 'Link',
    44 => 'HTML is niet toegestaan',
    45 => 'Versturen',
    46 => 'Aantal gebeurtenissen',
    47 => 'Top Tien gebeurtenissen',
    48 => 'Aangekondigd',
    49 => 'Er zijn geen gebeurtenissen of ze worden door niemand gelezen.',
    50 => 'Gebeurtenissen',
    51 => 'Wissen'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Gevonden gebeurtenissen',
    'title' => 'Titel',
    'date_time' => 'Datum en tijd',
    'location' => 'Plaats',
    'description' => 'Beschrijving'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Nieuwe gebeurtenis',
    9 => 'Gebeurtenis',
    10 => 'Gebeurtenis op',
    11 => 'Kalender',
    12 => 'Mijn Kalender',
    25 => 'Terug naar ',
    26 => 'heel de dag',
    27 => 'Week',
    28 => 'Persoonlijke kalender voor',
    29 => 'Algemene Kalender',
    30 => 'Gebeurtenis wissen',
    31 => 'Invoegen',
    32 => 'Gebeurtenis',
    33 => 'Datum',
    34 => 'Tijd',
    35 => 'Nieuwe gebeurtenis',
    36 => 'Versturen',
    37 => 'Sorry, persoonlijke kalenders zijn op deze webpagina niet beschikbaar.',
    38 => 'Persoonlijke gebeurtenis-Editor',
    39 => 'Vandaag',
    40 => 'Week',
    41 => 'Maand',
    42 => 'Nieuwe Gebeurtenis',
    43 => 'Bijdrage: Gebeurtenissen'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Gebeurtenis-Editor',
    2 => 'Fout',
    3 => 'Titel',
    4 => 'URL',
    5 => 'Startdatum',
    6 => 'Einddatum',
    7 => 'Plaats',
    8 => 'Beschrijving',
    9 => '(met http://)',
    10 => 'Er moet minstens een Datum, Tijd, Titel en Beschrijving worden ingegeven!',
    11 => 'Kalender-Manager',
    12 => 'Op het andere Icoon klikken, om een gebeurtenis te veranderen of te verwijderen. Met Nieuw aanmaken (s.o.) word een nieuwe gebeurtenis aangemaakt. De kopie-knop maakt een kopie van een komende gebeurtenis.',
    13 => 'Schrijver',
    14 => 'Startdatum',
    15 => 'Einddatum',
    16 => '',
    17 => "U heeft geen toegangsrechten voor deze gebeurtenis. Deze toegangspoging wordt opgeslagen. <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">Terug naar het Beheerder-Menü</a>.",
    18 => '',
    19 => '',
    20 => 'Opslaan',
    21 => 'Afbreken',
    22 => 'Wissen',
    23 => 'Ongeldige Startdatum.',
    24 => 'Ongeldige Einddatum.',
    25 => 'Einddatum is voor de Startdatum.',
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
    'save' => 'Uw gebeurtenis is opgeslagen.',
    'delete' => 'De gebeurtenis is verwijderd.',
    'private' => 'De gebeurtenis is in uw kalender opgenomen.',
    'login' => 'U moet aangemeld zijn om uw persoonlijke kalender te bewerken.',
    'removed' => 'De gebeurtenis is van uw persoonlijke kalender verwijderd',
    'noprivate' => 'Sorry, persoonlijke kalenders zijn op deze webpagina niet beschikbaar.',
    'unauth' => 'U heeft geen toegang tot het gebeurtenis-beheerdersgedeelte. Alle toegangspogingen worden opgeslagen.'
);

$PLG_calendar_MESSAGE4 = "Dank U voor uw bijdrage aan {$_CONF['site_name']}. Uw evenement wordt nu beoordeeld. Zodra deze geaccepteerd is wordt deze zo snel mogelijk in de <a href=\"{$_CONF['site_url']}/calendar/index.php\">kalender</a> opgenomen.";
$PLG_calendar_MESSAGE17 = 'Uw gebeurtenis wordt opgeslagen.';
$PLG_calendar_MESSAGE18 = 'De gebeurtenis wordt verwijderd.';
$PLG_calendar_MESSAGE24 = 'De gebeurtenis is in uw kalender opgenomen.';
$PLG_calendar_MESSAGE26 = 'Deze gebeurtenis is reeds verwijderd.';

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
