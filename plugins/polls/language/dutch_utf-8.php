<?php

###############################################################################
# dutch_utf-8.php
# This is the Dutch language file for the Geeklog Polls plugin
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

$LANG_POLLS = array(
    'polls' => 'Peilingen',
    'results' => 'Resultaten',
    'pollresults' => 'Peiling Resultaten',
    'votes' => 'stemmen',
    'vote' => 'Stem',
    'pastpolls' => 'Oudere peilingen',
    'savedvotetitle' => 'Stem opgeslagen',
    'savedvotemsg' => 'Uw stem is in de peling opgenomen',
    'pollstitle' => 'Peilingen in systeem',
    'polltopics' => 'Other polls',
    'stats_top10' => 'Top Tien Peilingen',
    'stats_topics' => 'Poll Topic',
    'stats_votes' => 'Stemmen',
    'stats_none' => 'Er zijn geen peilingen aanwezig of er is nog niet op gestemd.',
    'stats_summary' => 'Peilingen (resultaten) in het systeem',
    'open_poll' => 'Open voor stemmen',
    'answer_all' => 'Please answer all remaining questions',
    'not_saved' => 'Result not saved',
    'upgrade1' => 'You installed a new version of the Polls plugin. Please',
    'upgrade2' => 'upgrade',
    'editinstructions' => 'Please fill in the Poll ID, at least one question and two answers for it.',
    'pollclosed' => 'This poll is closed for voting.',
    'pollhidden' => 'You have already voted. This poll results will only be shown when voting is closed.',
    'start_poll' => 'Start Poll'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Mode',
    2 => 'Please enter a topic, at least one question and at least one answer for that question.',
    3 => 'Poll Created',
    4 => 'Poll %s saved',
    5 => 'Edit Poll',
    6 => 'Poll ID',
    7 => '(do not use spaces)',
    8 => 'Appears on Pollblock',
    9 => 'Topic',
    10 => 'Answers / Votes / Remark',
    11 => 'There was an error getting poll answer data about the poll %s',
    12 => 'There was an error getting poll question data about the poll %s',
    13 => 'Create Poll',
    14 => 'save',
    15 => 'cancel',
    16 => 'delete',
    17 => 'Please enter a Poll ID',
    18 => 'Poll List',
    19 => 'To modify or delete a poll, click on the edit icon of the poll.  To create a new poll, click on "Create New" above.',
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
    31 => 'Question',
    32 => 'To remove this question from the poll, remove its question text',
    33 => 'Open for voting',
    34 => 'Poll Topic:',
    35 => 'This poll has',
    36 => 'more questions.',
    37 => 'Hide results while poll is open',
    38 => 'While the poll is open, only the owner &amp; root can see the results',
    39 => 'The topic will be only displayed if there are more than 1 questions.',
    40 => 'See all answers to this poll'
);

$PLG_polls_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_polls_MESSAGE19 = 'Your poll has been successfully saved.';
$PLG_polls_MESSAGE20 = 'Your poll has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'Polls',
    'title' => 'Polls Configuration'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'Polls Login Required?',
    'hidepollsmenu' => 'Hide Polls Menu Entry?',
    'maxquestions' => 'Max. Questions per Poll',
    'maxanswers' => 'Max. Options per Question',
    'answerorder' => 'Sort Results ...',
    'pollcookietime' => 'Voter Cookie valid for',
    'polladdresstime' => 'Voter IP Address valid for',
    'delete_polls' => 'Delete Polls with Owner?',
    'aftersave' => 'After Saving Poll',
    'default_permissions' => 'Poll Default Permissions',
    'meta_tags' => 'Enable Meta Tags'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'General Polls Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('As Submitted' => 'submitorder', 'By Votes' => 'voteorder'),
    9 => array('Forward to Poll' => 'item', 'Display Admin List' => 'list', 'Display Public List' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
