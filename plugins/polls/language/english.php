<?php

###############################################################################
# english.php
# This is the english language page for the Geeklog Polls Plug-in!
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


$LANG_POLLS = array(
    'polls'             => 'Polls',
    'results'           => 'Results',
    'pollresults'       => 'Poll Results',
    'votes'             => 'votes',
    'vote'              => 'Vote',
    'pastpolls'         => 'Past Polls',
    'savedvotetitle'    => 'Vote Saved',
    'savedvotemsg'      => 'Your vote was saved for the poll',
    'pollstitle'        => 'Polls in System',
    'pollquestions'     => 'View other poll questions',
    'stats_top10'       => 'Top Ten Polls',
    'stats_questions'   => 'Poll Question',
    'stats_votes'       => 'Votes',
    'stats_none'        => 'It appears that there are no polls on this site or no one has ever voted.',
    'stats_summary'     => 'Polls(Answers) in the system'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Mode',
    2 => 'Please enter a question and at least one answer.',
    3 => 'Poll Created',
    4 => "Poll %s saved",
    5 => 'Edit Poll',
    6 => 'Poll ID',
    7 => '(do not use spaces)',
    8 => 'Appears on Homepage',
    9 => 'Question',
    10 => 'Answers / Votes',
    11 => "There was an error getting poll answer data about the poll %s",
    12 => "There was an error getting poll question data about the poll %s",
    13 => 'Create Poll',
    14 => 'save',
    15 => 'cancel',
    16 => 'delete',
    17 => 'Please enter a Poll ID',
    18 => 'Poll List',
    19 => 'To modify or delete a poll, click on the edit icon of the poll.  To create a new poll click on new poll above.',
    20 => 'Voters',
    21 => 'Access Denied',
    22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/poll.php\">go back to the poll administration screen</a>.",
    23 => 'New Poll',
    24 => 'Admin Home',
    25 => 'Yes',
    26 => 'No',
    27 => 'Edit',
    28 => 'Submit',
    29 => 'Search',
    30 => 'Limit Results',
);

$PLG_polls_MESSAGE19 = 'Your poll has been successfully saved.';

?>
