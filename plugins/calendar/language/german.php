<?php

###############################################################################
# german.php
#
# This is the German language file for the Geeklog Calendar Plugin
#
# Authors: Dirk Haun <dirk AT haun-online DOT de>
#          Markus Wollschl�ger
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
    6 => 'Termin hinzuf�gen',
    7 => 'Anstehende Termine',
    8 => 'Wenn Du diesen Termin zu Deinem Kalender hinzuf�gst, kannst Du Dir schneller einen �berblick �ber die Termine verschaffen, die Dich interessieren, indem Du einfach auf "Mein Kalender" klickst.',
    9 => 'Zu Meinem Kalender hinzuf�gen',
    10 => 'Aus Meinem Kalender entfernen',
    11 => 'Termin wird zum Kalender von %s hinzugef�gt',
    12 => 'Termin',
    13 => 'Beginnt',
    14 => 'Endet',
    15 => 'Zur�ck zum Kalender',
    16 => 'Kalender',
    17 => 'Startdatum',
    18 => 'Enddatum',
    19 => 'Beitr�ge: Kalender',
    20 => 'Titel',
    21 => 'Startdatum',
    22 => 'URL',
    23 => 'Meine Termine',
    24 => 'Allgemeine Termine',
    25 => 'Es stehen keine Termine an',
    26 => 'Einen Termin einreichen',
    27 => "Wenn Du einen Termin bei {$_CONF['site_name']} einreichst, wird er in den Kalender aufgenommen, von wo aus ihn andere User in ihren pers�nlichen Kalender �bernehmen k�nnen. Dies ist <b>NICHT</b> dazu gedacht, private Termine und Ereignisse wie etwa Geburtstage zu verwalten.<br" . XHTML . "><br" . XHTML . ">Wenn Du einen Termin einreichst, wird er an die Administratoren weitergeleitet und sobald er von diesen akzeptiert wird, wird er im Kalender erscheinen.",
    28 => 'Titel',
    29 => 'Endzeit',
    30 => 'Startzeit',
    31 => 'Ganzt�giger Termin',
    32 => 'Addresse, Zeile 1',
    33 => 'Addresse, Zeile 2',
    34 => 'Stadt',
    35 => 'Bundesland',
    36 => 'Postleitzahl',
    37 => 'Art des Termins',
    38 => 'Termin-Arten �ndern',
    39 => 'Ort',
    40 => 'Termin hinzuf�gen zu',
    41 => 'Kalender',
    42 => 'Pers�nlicher Kalender',
    43 => 'Link',
    44 => 'HTML ist nicht erlaubt',
    45 => 'Abschicken',
    46 => 'Anzahl Termine',
    47 => 'Top Ten der Termine',
    48 => 'Angezeigt',
    49 => 'Es gibt keine Termine oder sie wurden von niemandem gelesen.',
    50 => 'Termine',
    51 => 'L�schen'
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
    25 => 'Zur�ck zum ',
    26 => 'ganzt�gig',
    27 => 'Woche',
    28 => 'Pers�nlicher Kalender f�r',
    29 => '�ffentlicher Kalender',
    30 => 'Termin l�schen',
    31 => 'Hinzuf�gen',
    32 => 'Termin',
    33 => 'Datum',
    34 => 'Uhrzeit',
    35 => 'Neuer Termin',
    36 => 'Abschicken',
    37 => 'Der pers�nliche Kalender ist auf dieser Website nicht verf�gbar.',
    38 => 'Pers�nlicher Termin-Editor',
    39 => 'Tag',
    40 => 'Woche',
    41 => 'Monat',
    42 => 'Neuer Termin',
    43 => 'Beitr�ge: Termine'
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
    10 => 'Es m�ssen mindestens Datum und Uhrzeit, Titel und Beschreibung eingegeben werden!',
    11 => 'Kalender-Manager',
    12 => 'Auf das �ndern-Icon klicken, um einen Termin zu �ndern oder zu l�schen. Mit Neu anlegen (s.o.) wird ein neuer Termin angelegt. Das Kopie-Icon erzeugt eine Kopie eines vorhandenen Termins.',
    13 => 'Autor',
    14 => 'Startdatum',
    15 => 'Enddatum',
    16 => '',
    17 => "Keine Zugriffsrechte f�r diesen Termin. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">Zur�ck zum Administrator-Men�</a>.",
    18 => '',
    19 => '',
    20 => 'Speichern',
    21 => 'Abbruch',
    22 => 'L�schen',
    23 => 'Ung�ltiges Startdatum.',
    24 => 'Ung�ltiges Enddatum.',
    25 => 'Enddatum ist vor dem Startdatum.',
    26 => 'Alte Eintr�ge l�schen',
    27 => 'Diese Termine sind �lter als ',
    28 => ' Monate. Bite auf das M�lleimer-Icon klicken, um sie zu entfernen, oder eine andere Zeitspanne ausw�hlen:<br' . XHTML . '>Suche alle Eintr�ge �lter als ',
    29 => ' Monate.',
    30 => 'Liste aktualisieren',
    31 => 'Sind Sie sicher, dass Sie alle ausgew�hlten User permanent l�schen m�chten?',
    32 => 'Alle auflisten',
    33 => 'Keine Termine zum L�schen ausgew�hlt',
    34 => 'Termin ID',
    35 => 'konnte nicht gel�scht werden',
    36 => 'Erfolgreich gel�scht'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'Der Termin wurde gespeichert.',
    'delete' => 'Der Termin wurde gel�scht.',
    'private' => 'Der Termin wurde in Deinen Kalender eingetragen.',
    'login' => 'Du musst angemeldet sein, um auf Deinen pers�nlichen Kalender zugreifen zu k�nnen.',
    'removed' => 'Der Termin wurde aus Deinem pers�nlichen Kalender entfernt',
    'noprivate' => 'Sorry, pers�nliche Kalender sind auf dieser Site nicht verf�gbar.',
    'unauth' => 'Du hast keinen Zugriff auf die Termin-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.'
);

$PLG_calendar_MESSAGE4 = "Danke f�r Deinen Beitrag zu {$_CONF['site_name']}. Dein Termin wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald im <a href=\"{$_CONF['site_url']}/calendar/index.php\">Kalender</a> aufgelistet werden.";
$PLG_calendar_MESSAGE17 = 'Dein Termin wurde gespeichert.';
$PLG_calendar_MESSAGE18 = 'Der Termin wurde gel�scht.';
$PLG_calendar_MESSAGE24 = 'Der Termin wurde in Deinen Kalender eingetragen.';
$PLG_calendar_MESSAGE26 = 'Der Termin wurde gel�scht.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Kalender',
    'title' => 'Kalendereinstellungen'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Zur Einsicht einloggen n�tig?',
    'hidecalendarmenu' => 'Men�eintrag ausblenden?',
    'personalcalendars' => 'Pers�nliche Kalender?',
    'eventsubmission' => 'Eintr�ge moderieren?',
    'showupcomingevents' => 'Zuk�nftige Termine anzeigen?',
    'upcomingeventsrange' => 'Zeitraum zuk�nftige Termine',
    'event_types' => 'Art der Termine',
    'hour_mode' => 'Stunden-Modus',
    'notification' => 'Benachrichtigungs-eMail?',
    'delete_event' => 'Termine mit User l�schen?',
    'aftersave' => 'Nach Speichern des Termins',
    'default_permissions' => 'Grundeinstellungen Termine'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Hauptbereich'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'Allgemeine Kalendereinstellungen',
    'fs_permissions' => 'Grundeinstellungen Rechte'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('Ja' => 1, 'Nein' => 0),
    1 => array('Ja' => true, 'Nein' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Zum Termin weiterleiten' => 'item', 'Admin Liste anzeigen' => 'list', 'Kalender anzeigen' => 'plugin', 'Startseite anzeigen' => 'home', 'Kommandozentrale' => 'admin'),
    12 => array('Kein Zugang' => 0, 'Nur lesen' => 2, 'Lesen-Schreiben' => 3)
);

?>
