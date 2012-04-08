<?php

###############################################################################
# danish.php
# This is the Danish language page for the Geeklog Calendar Plug-in!
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
    1 => 'Begivenheds kalender',
    2 => 'Beklager der er ingen begivenheder at vise.',
    3 => 'Når',
    4 => 'Hvor',
    5 => 'Beskrivelse',
    6 => 'Tilføj en begivenhed',
    7 => 'Kommer snart',
    8 => 'Ved at tilføje denne begivenhed kan du hurtig se den begivenheder der interesseret dig ved at klikke på "Min Kalender" under Bruger Funktioner.',
    9 => 'Tilføj til min kalender',
    10 => 'Fjern fra min kalender',
    11 => 'Tilføjer begivenhedAdding til %s\'s kalender',
    12 => 'Begivenhed',
    13 => 'Start',
    14 => 'Slut',
    15 => 'Tilbage til kalender',
    16 => 'Kalender',
    17 => 'Start Dato',
    18 => 'Slut Date',
    19 => 'Kalender forslag',
    20 => 'Titel',
    21 => 'Start Dato',
    22 => 'URL',
    23 => 'Dine Begivenheder',
    24 => 'Sitde Begivenheder',
    25 => 'Der ingen begivenheder lige nu',
    26 => 'Tilføj en begivenhed',
    27 => "Tilføjer begivenhed til {$_CONF['site_name']} vil sætte din begivenhed under hoved kalender. Hvor en bruger kan vælge din begivenhed til deres eget kalender. Denne mulighed er <b>IKKE</b> beregnet til at gemme dine personlige begivenheder som fødselsdage og årsdage.<br" . XHTML . "><br" . XHTML . ">Når du har tilføjet en begivenhed skal admin godkende den, og hvis den godkendes vil den vises på hoved kalender.",
    28 => 'Titel',
    29 => 'Slut Tid',
    30 => 'Start Tid',
    31 => 'Heldags begivenhed',
    32 => 'Adresse Linje 1',
    33 => 'Adresse Linje 2',
    34 => 'By',
    35 => 'State',
    36 => 'Postnummer',
    37 => 'Begivenheds Type',
    38 => 'Ændre begivenheds typer',
    39 => 'Sted',
    40 => 'Tilføj begivenhed til',
    41 => 'Hoved kalender',
    42 => 'Personlig kalender',
    43 => 'Link',
    44 => 'HTML tags ikke tilladt',
    45 => 'Tilføj',
    46 => 'Begivenheder i systemet',
    47 => 'Top Ti Begivenheder',
    48 => 'Hits',
    49 => 'Det ser ikke ud til der er nogen begivenherder på siden, eller er der ikke klikket på nogen.',
    50 => 'Begivenheder',
    51 => 'Slet',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Kalender resultater',
    'title' => 'Titel',
    'date_time' => 'Dato & Tid',
    'location' => 'Sted',
    'description' => 'Beskrivelse'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Tilføj personlig begivenhed',
    9 => '%s Begivenhed',
    10 => 'Begivenhed for',
    11 => 'Hoved kalender',
    12 => 'Min kalender',
    25 => 'Tilbage til ',
    26 => 'Hele dagen',
    27 => 'Uge',
    28 => 'Personlig kalender for',
    29 => 'Offentlig Kalender',
    30 => 'slette begivenhed',
    31 => 'Tilføj',
    32 => 'Begivenhed',
    33 => 'Dato',
    34 => 'Tid',
    35 => 'Tilføj Hurtig',
    36 => 'Tilføjt',
    37 => 'Sorry, the personal calendar feature is not enabled on this site',
    38 => 'Personlig Begivenheds Editor',
    39 => 'Dag',
    40 => 'Uge',
    41 => 'Måned',
    42 => 'Tilføj Hoved Begivenhed',
    43 => 'Begivenheds tilføjelser'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Begivenheds Editor',
    2 => 'Fejl',
    3 => 'Post Måde',
    4 => 'Begivenheds URL',
    5 => 'Begivenhed Start Dato',
    6 => 'Begivenhed Slut Dato',
    7 => 'Begivenheds Sted',
    8 => 'Begivenhed Beskrivelse',
    9 => '(Husk http://)',
    10 => 'Du skal skrive dato/tid, begivenhedevens titel, og beskrivelse',
    11 => 'Kalender Styrelse',
    12 => 'Ret eller slet en begivenhed, klik på begivenhed\'s ret ikon forneden.  For at lave en ny begivenhed, klik på "Lav Ny" foroven. Klik på kopi ikon for at lave en kopi af den eksisterende begivenhed.',
    13 => 'Forfatter',
    14 => 'Start Dato',
    15 => 'Slut Dato',
    16 => '',
    17 => "Du prøver at få adgang til en begivenhed som du ikke har rettigheder til.  Dette forsøg er blevet logget. Venligst <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">gå tilbage til admin siden</a>.",
    18 => '',
    19 => '',
    20 => 'gem',
    21 => 'fortryd',
    22 => 'slet',
    23 => 'Forkert start dato.',
    24 => 'Forkert slut dato.',
    25 => 'Slut dato er før start dato.',
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
    'save' => 'Din begivenhed er blevet gemt.',
    'delete' => 'Denne begivenhed er blevet slettet.',
    'private' => 'Denne begivenhed er gemt i din kalender',
    'login' => 'Kan ikke åbne din personlige kalender før du er logget ind',
    'removed' => 'Begivenheden er slettet fra din personlige kalender',
    'noprivate' => 'Beklager, personlige kalender er ikke til rådighed på siden',
    'unauth' => 'Beklager, du har ikke adgang til admin siden. Alle førsøg på at få adgang til sider som ikke kommer dig ved. Bliver logget'
);

$PLG_calendar_MESSAGE4 = "Tak for tilføjelsen til {$_CONF['site_name']}.  Den er blevet sendt til godkendelse.  Hvis den bliver godkendt vil begivenheden kunne ses her, i vores <a href=\"{$_CONF['site_url']}/calendar/index.php\">kalender</a> sektion.";
$PLG_calendar_MESSAGE17 = 'Din begivenhed er blevet gemt.';
$PLG_calendar_MESSAGE18 = 'Denne begivenhed er blevet slettet.';
$PLG_calendar_MESSAGE24 = 'Denne begivenhed er gemt i din kalender.';
$PLG_calendar_MESSAGE26 = 'Denne begivenhed er slettet.';

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
