<?php

###############################################################################
# german_formal.php
#
# This is the formal German language file for the Geeklog Calendar Plugin
#
# Copyright (C) 2006 Dirk Haun
# dirk AT haun-online DOT de
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
    1 => 'Terminkalender',
    2 => 'Es gibt keine Termine anzuzeigen.',
    3 => 'Wann',
    4 => 'Wo',
    5 => 'Beschreibung',
    6 => 'Termin hinzufügen',
    7 => 'Anstehende Termine',
    8 => 'Wenn Sie diesen Termin zu Ihrem Kalender hinzufügen, können Sie sich schneller einen Überblick über die Termine verschaffen, die Sie interessieren, indem Sie einfach auf "Mein Kalender" klicken.',
    9 => 'Zu Meinem Kalender hinzufügen',
    10 => 'Aus Meinem Kalender entfernen',
    11 => 'Termin wird zum Kalender von %s hinzugefügt',
    12 => 'Termin',
    13 => 'Beginnt',
    14 => 'Endet',
    15 => 'Zurück zum Kalender',
    16 => 'Kalender',
    17 => 'Startdatum',
    18 => 'Enddatum',
    19 => 'Beiträge: Kalender',
    20 => 'Titel',
    21 => 'Startdatum',
    22 => 'URL',
    23 => 'Meine Termine',
    24 => 'Allgemeine Termine',
    25 => 'Es stehen keine Termine an',
    26 => 'Einen Termin einreichen',
    27 => "Wenn Sie einen Termin bei {$_CONF['site_name']} einreichen, wird er in den Kalender aufgenommen, von wo aus ihn andere User in ihren persönlichen Kalender übernehmen können. Dies ist <b>NICHT</b> dazu gedacht, private Termine und Ereignisse wie etwa Geburtstage zu verwalten.<br" . XHTML . "><br" . XHTML . ">Wenn Sie einen Termin einreichen, wird er an die Administratoren weitergeleitet und sobald er von diesen akzeptiert wird, wird er im Kalender erscheinen.",
    28 => 'Titel',
    29 => 'Endzeit',
    30 => 'Startzeit',
    31 => 'Ganztägiger Termin',
    32 => 'Addresse, Zeile 1',
    33 => 'Addresse, Zeile 2',
    34 => 'Stadt',
    35 => 'Bundesland',
    36 => 'Postleitzahl',
    37 => 'Art des Termins',
    38 => 'Termin-Arten ändern',
    39 => 'Ort',
    40 => 'Termin hinzufügen zu',
    41 => 'Kalender',
    42 => 'Persönlicher Kalender',
    43 => 'Link',
    44 => 'HTML ist nicht erlaubt',
    45 => 'Abschicken',
    46 => 'Anzahl Termine',
    47 => 'Top Ten der Termine',
    48 => 'Angezeigt',
    49 => 'Es gibt keine Termine oder sie wurden von niemandem gelesen.',
    50 => 'Termine',
    51 => 'Löschen'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Gefundene Termine',
    'title' => 'Titel',
    'date_time' => 'Datum und Uhrzeit',
    'location' => 'Ort',
    'description' => 'Beschreibung'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Neuer Termin',
    9 => 'Termin',
    10 => 'Termine am',
    11 => 'Kalender',
    12 => 'Mein Kalender',
    25 => 'Zurück zum ',
    26 => 'ganztägig',
    27 => 'Woche',
    28 => 'Persönlicher Kalender für',
    29 => 'Öffentlicher Kalender',
    30 => 'Termin löschen',
    31 => 'Hinzufügen',
    32 => 'Termin',
    33 => 'Datum',
    34 => 'Uhrzeit',
    35 => 'Neuer Termin',
    36 => 'Abschicken',
    37 => 'Der persönliche Kalender ist auf dieser Website nicht verfügbar.',
    38 => 'Persönlicher Termin-Editor',
    39 => 'Tag',
    40 => 'Woche',
    41 => 'Monat',
    42 => 'Neuer Termin',
    43 => 'Beiträge: Termine'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Termin-Editor',
    2 => 'Fehler',
    3 => 'Titel',
    4 => 'URL',
    5 => 'Startdatum',
    6 => 'Enddatum',
    7 => 'Ort',
    8 => 'Beschreibung',
    9 => '(mit http://)',
    10 => 'Es müssen mindestens Datum und Uhrzeit, Titel und Beschreibung eingegeben werden!',
    11 => 'Kalender-Manager',
    12 => 'Auf das Ändern-Icon klicken, um einen Termin zu ändern oder zu löschen. Mit Neu anlegen (s.o.) wird ein neuer Termin angelegt. Das Kopie-Icon erzeugt eine Kopie eines vorhandenen Termins.',
    13 => 'Autor',
    14 => 'Startdatum',
    15 => 'Enddatum',
    16 => '',
    17 => "Sie haben keine Zugriffsrechte für diesen Termin. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">Zurück zum Administrator-Menü</a>.",
    18 => '',
    19 => '',
    20 => 'Speichern',
    21 => 'Abbruch',
    22 => 'Löschen',
    23 => 'Ungültiges Startdatum.',
    24 => 'Ungültiges Enddatum.',
    25 => 'Enddatum ist vor dem Startdatum.',
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
    'save' => 'Der Termin wurde gespeichert.',
    'delete' => 'Der Termin wurde gelöscht.',
    'private' => 'Der Termin wurde in Ihren Kalender eingetragen.',
    'login' => 'Sie müssen angemeldet sein, um auf Ihren persönlichen Kalender zugreifen zu können.',
    'removed' => 'Der Termin wurde aus Ihrem persönlichen Kalender entfernt',
    'noprivate' => 'Persönliche Kalender sind auf dieser Site nicht verfügbar.',
    'unauth' => 'Sie haben keinen Zugriff auf die Termin-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.'
);

$PLG_calendar_MESSAGE4 = "Danke für Ihren Beitrag zu {$_CONF['site_name']}. Ihr Termin wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald im <a href=\"{$_CONF['site_url']}/calendar/index.php\">Kalender</a> aufgelistet werden.";
$PLG_calendar_MESSAGE17 = 'Ihr Termin wurde gespeichert.';
$PLG_calendar_MESSAGE18 = 'Der Termin wurde gelöscht.';
$PLG_calendar_MESSAGE24 = 'Der Termin wurde in Ihren Kalender eingetragen.';
$PLG_calendar_MESSAGE26 = 'Der Termin wurde gelöscht.';

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