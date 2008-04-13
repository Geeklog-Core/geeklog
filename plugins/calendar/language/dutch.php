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
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
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
    27 => "Wanneer u uw gebeurtenis bij {$_CONF['site_name']} toevoegd, wordt deze in de kalender opgenomen, van waaruit u en anderen deze in de persoonlijke Kalender kunnen overnemen. Dit is <b>NIET</b> ervoor bedoeld, om prive gebeurtenissen zoals verjaardagen te beheren.<br><br>Wanner u een gebeurtenis indient, wordt deze door de beheerder verder bekeken. En zodra de beheerder het accepteert verschijnt de gebeurtenis in de Kalender.",
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
# admin/event.php (LANG22)

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
    16 => 'Toegang geweigerd',
    17 => "U heeft geen toegangsrechten voor deze gebeurtenis. Deze toegangspoging wordt opgeslagen. <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">Terug naar het Beheerder-Menü</a>.",
    18 => '',
    19 => '',
    20 => 'Opslaan',
    21 => 'Afbreken',
    22 => 'Wissen',
    23 => 'Ongeldige Startdatum.',
    24 => 'Ongeldige Einddatum.',
    25 => 'Einddatum is voor de Startdatum.'
);

$LANG_CAL_MESSAGE = array(
    'save'      => 'Uw gebeurtenis is opgeslagen.',
    'delete'    => 'De gebeurtenis is verwijderd.',
    'private'   => 'De gebeurtenis is in uw kalender opgenomen.',
    'login'     => 'U moet aangemeld zijn om uw persoonlijke kalender te bewerken.',
    'removed'   => 'De gebeurtenis is van uw persoonlijke kalender verwijderd',
    'noprivate' => 'Sorry, persoonlijke kalenders zijn op deze webpagina niet beschikbaar.',
    'unauth'    => 'U heeft geen toegang tot het gebeurtenis-beheerdersgedeelte. Alle toegangspogingen worden opgeslagen.'
);

$PLG_calendar_MESSAGE4 = "Dank U voor uw bijdrage aan {$_CONF['site_name']}. Uw evenement wordt nu beoordeeld. Zodra deze geaccepteerd is wordt deze zo snel mogelijk in de <a href=\"{$_CONF['site_url']}/calendar/index.php\">kalender</a> opgenomen.";
$PLG_calendar_MESSAGE17 = 'Uw gebeurtenis wordt opgeslagen.';
$PLG_calendar_MESSAGE18 = 'De gebeurtenis wordt verwijderd.';
$PLG_calendar_MESSAGE24 = 'De gebeurtenis is in uw kalender opgenomen.';
$PLG_calendar_MESSAGE26 = 'Deze gebeurtenis is reeds verwijderd.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

?>
