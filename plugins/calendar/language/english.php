<?php

###############################################################################
# english.php
# This is the english language page for the Geeklog Calendar Plug-in!
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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Calendar of Events',
    2 => 'I\'m sorry, there are no events to display.',
    3 => 'When',
    4 => 'Where',
    5 => 'Description',
    6 => 'Add An Event',
    7 => 'Upcoming Events',
    8 => 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "My Calendar" from the User Functions area.',
    9 => 'Add to My Calendar',
    10 => 'Remove from My Calendar',
    11 => "Adding Event to {$_USER['username']}'s Calendar",
    12 => 'Event',
    13 => 'Starts',
    14 => 'Ends',
    15 => 'Back to Calendar',
    16 => 'Calendar',
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
    50 => 'Events'
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
    1 => 'Sunday',
    2 => 'Monday',
    3 => 'Tuesday',
    4 => 'Wednesday',
    5 => 'Thursday',
    6 => 'Friday',
    7 => 'Saturday',
    8 => 'Add Personal Event',
    9 => '%s Event',
    10 => 'Events for',
    11 => 'Master Calendar',
    12 => 'My Calendar',
    13 => 'January',
    14 => 'February',
    15 => 'March',
    16 => 'April',
    17 => 'May',
    18 => 'June',
    19 => 'July',
    20 => 'August',
    21 => 'September',
    22 => 'October',
    23 => 'November',
    24 => 'December',
    25 => 'Back to ',
    26 => 'All Day',
    27 => 'Week',
    28 => 'Personal Calendar for',
    29 => 'Public Calendar',
    30 => 'delete event',
    31 => 'Add',
    32 => 'Event',
    33 => 'Date',
    34 => 'Time',
    35 => 'Quick Add',
    36 => 'Submit',
    37 => 'Sorry, the personal calendar feature is not enabled on this site',
    38 => 'Personal Event Editor',
    39 => 'Day',
    40 => 'Week',
    41 => 'Month',
    42 => 'Add Master Event'
);

###############################################################################
# admin/event.php (LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Event Editor',
    2 => 'Error',
    3 => 'Post Mode',
    4 => 'Event URL',
    5 => 'Event Start Date',
    6 => 'Event End Date',
    7 => 'Event Location',
    8 => 'Event Description',
    9 => '(include http://)',
    10 => 'You must provide the dates/times, event title, and description',
    11 => 'Calendar Manager',
    12 => 'To modify or delete an event, click on that event\'s edit icon below.  To create a new event, click on "Create New" above. Click on the copy icon to create a copy of an existing event.',
    13 => 'Author',
    14 => 'Start Date',
    15 => 'End Date',
    16 => '',
    17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/event.php\">go back to the event administration screen</a>.",
    18 => '',
    19 => '',
    20 => 'save',
    21 => 'cancel',
    22 => 'delete',
    23 => 'Bad start date.',
    24 => 'Bad end date.',
    25 => 'End date is before start date.'
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

?>
