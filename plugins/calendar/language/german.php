<?php

###############################################################################
# german.php
#
# This is the German language file for the Geeklog Calendar Plugin
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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Terminkalender',
    2 => 'I\'m sorry, there are no events to display.',
    3 => 'When',
    4 => 'Where',
    5 => 'Description',
    6 => 'Add An Event',
    7 => 'Upcoming Events',
    8 => 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "My Calendar" from the User Functions area.',
    9 => 'Add to My Calendar',
    10 => 'Remove from My Calendar',
    11 => "Adding Event to %s's Calendar",
    12 => 'Event',
    13 => 'Starts',
    14 => 'Ends',
    15 => 'Back to Calendar',
    16 => 'Kalender',
    17 => 'Start Date',
    18 => 'End Date',
    19 => 'Calendar Submissions',
    20 => 'Title',
    21 => 'Start Date',
    22 => 'URL',
    23 => 'Your Events',
    24 => 'Site Events',
    25 => 'There are no upcoming events',
    26 => 'Submit an Event',
    27 => "Submitting an event to {$_CONF['site_name']} will put your event on the master calendar where users can optionally add your event to their personal calendar. This feature is <b>NOT</b> meant to store your personal events such as birthdays and anniversaries.<br><br>Once you submit your event it will be sent to our administrators and if approved, your event will appear on the master calendar.",
    28 => 'Title',
    29 => 'End Time',
    30 => 'Start Time',
    31 => 'All Day Event',
    32 => 'Address Line 1',
    33 => 'Address Line 2',
    34 => 'City/Town',
    35 => 'State',
    36 => 'Zip Code',
    37 => 'Event Type',
    38 => 'Edit Event Types',
    39 => 'Location',
    40 => 'Add Event to',
    41 => 'Master Calendar',
    42 => 'Personal Calendar',
    43 => 'Link',
    44 => 'HTML tags are not allowed',
    45 => 'Submit',
    46 => 'Events in the system',
    47 => 'Top Ten Events',
    48 => 'Hits',
    49 => 'It appears that there are no events on this site or no one has ever clicked on one.',
    50 => 'Events',
    51 => 'Delete'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Calendar Results',
    'title' => 'Title',
    'date_time' => 'Date & Time',
    'location' => 'Location',
    'description' => 'Description'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Add Personal Event',
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
    36 => 'Submit',
    37 => 'Sorry, der persönliche Kalender ist auf dieser Site nicht verfügbar.',
    38 => 'Persönlicher Termin-Editor',
    39 => 'Tag',
    40 => 'Woche',
    41 => 'Monat',
    42 => 'Add Master Event',
    43 => 'Event Submissions',
);

###############################################################################
# admin/event.php (LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Termin-Editor',
    2 => 'Error',
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
    16 => 'Zugriff verweigert',
    17 => "Du hast keine Zugriffsrechte für diesen Termin. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">Zurück zum Administrator-Menü</a>.",
    18 => '',
    19 => '',
    20 => 'Speichern',
    21 => 'Abbruch',
    22 => 'Löschen',
    23 => 'Ungültiges Startdatum.',
    24 => 'Ungültiges Enddatum.',
    25 => 'Enddatum ist vor dem Startdatum.'
);

$LANG_CAL_MESSAGE = array(
    'save'      => 'Your event has been successfully saved.',
    'delete'    => 'The event has been successfully deleted.',
    'private'   => 'The event has been saved to your calendar',
    'login'     => 'Cannot open your personal calendar until you login',
    'removed'   => 'Event was successfully removed from your personal calendar',
    'noprivate' => 'Sorry, personal calendars are not enabled on this site',
    'unauth'    => 'Sorry, you do not have access to the event administration page.  Please note that all attempts to access unauthorized features are logged',
);

$PLG_calendar_MESSAGE26 = 'The event has been saved to your calendar';
$PLG_calendar_MESSAGE4  = "Thank-you for submitting an event to {$_CONF['site_name']}.  It has been submitted to our staff for approval.  If approved, your event will be seen here, in our <a href=\"{$_CONF['site_url']}/calendar/index.php\">calendar</a> section.";
$PLG_calendar_MESSAGE17 = 'Your event has been successfully saved.';
$PLG_calendar_MESSAGE18 = 'The event has been successfully deleted.';
$PLG_calendar_MESSAGE24 = 'The event has been saved to your calendar';

?>
