<?php

###############################################################################
# english.php
# This is the english language page for the Geeklog links Plug-in!
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
# $Id: english.php,v 1.3 2005/05/31 07:51:09 ospiess Exp $

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_LINKS= array(
    1 => 'Contributed by:',
    2 => 'read more',
    3 => 'comments',
    4 => 'Edit',
    5 => 'Vote',
    6 => 'Results',
    7 => 'Poll Results',
    8 => 'votes',
    9 => 'Admin Functions:',
    10 => 'Submissions',
    11 => 'Articles',
    12 => 'Blocks',
    13 => 'Topics',
    14 => 'Links',
    15 => 'Events',
    16 => 'Polls',
    17 => 'Users',
    18 => 'SQL Query',
    19 => 'Log Out',
    20 => 'User Information:',
    21 => 'Username',
    22 => 'User ID',
    23 => 'Security Level',
    24 => 'Anonymous',
    25 => 'Reply',
    26 => 'The following comments are owned by whomever posted them. This site is not responsible for what they say.',
    27 => 'Most Recent Post',
    28 => 'Delete',
    29 => 'No user comments.',
    30 => 'Older Stories',
    31 => 'Allowed HTML Tags:',
    32 => 'Error, invalid username',
    33 => 'Error, could not write to the log file',
    34 => 'Error',
    35 => 'Logout',
    36 => 'on',
    37 => 'No user Articles',
    38 => 'Content Syndication',
    39 => 'Refresh',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Guest Users',
    42 => 'Authored by:',
    43 => 'Reply to This',
    44 => 'Parent',
    45 => 'MySQL Error Number',
    46 => 'MySQL Error Message',
    47 => 'User Functions',
    48 => 'Account Information',
    49 => 'Preferences',
    50 => 'Error with SQL statement',
    51 => 'help',
    52 => 'New',
    53 => 'Admin Home',
    54 => 'Could not open the file.',
    55 => 'Error at',
    56 => 'Vote',
    57 => 'Password',
    58 => 'Login',
    59 => "Don't have an account yet?  Sign up as a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">New User</a>",
    60 => 'Post a comment',
    61 => 'Create New Account',
    62 => 'words',
    63 => 'Comment Preferences',
    64 => 'Email Article To a Friend',
    65 => 'View Printable Version',
    66 => 'My Calendar',
    67 => 'Welcome to ',
    68 => 'Home',
    69 => 'Contact',
    70 => 'Search',
    71 => 'Contribute',
    72 => 'Training Provider Directory',
    73 => 'Past Polls',
    74 => 'Training Calendar',
    75 => 'Advanced Search',
    76 => 'Site Statistics',
    77 => 'Plugins',
    78 => 'Upcoming Training Events',
    79 => 'What\'s New',
    80 => 'articles in last',
    81 => 'article in last',
    82 => 'hours',
    83 => 'COMMENTS',
    84 => 'TRAINING PROVIDER DIRECTORY',
    85 => 'last 48 hrs',
    86 => 'No new comments',
    87 => 'last 2 wks',
    88 => 'No recent new providers',
    89 => 'There are no upcoming training events',
    90 => 'Home',
    91 => 'Created this page in',
    92 => 'seconds',
    93 => 'Copyright',
    94 => 'All trademarks and copyrights on this page are owned by their respective owners.',
    95 => 'Powered By',
    96 => 'Groups',
    97 => 'Word List',
    98 => 'Plug-ins',
    99 => 'ARTICLES',
    100 => 'No new articles',
    101 => 'Your Events',
    102 => 'Site Events',
    103 => 'DB Backups',
    104 => 'by',
    105 => 'Mail Users',
    106 => 'Views',
    107 => 'GL Version Test',
    108 => 'Clear Cache',
    109 => 'Report abuse',
    110 => 'Report this post to the site admin',
    111 => 'View PDF Version',
    112 => 'Registered Users',
    113 => 'Documentation',
    114 => 'Web Resources',
    115 => 'There are no resources to display.',
    116 => 'Add A Link'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Links(Clicks) in the System',
    'stats_headline' => 'Top Ten Links',
    'stats_page_title' => 'Links',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'It appears that there are no links on this site or no one has ever clicked on one.',
); 
 
###############################################################################
# for the search
 
$LANG_LINKS_SEARCH = array(
 'results' => 'Link Results',
 'title' => 'Title',
 'date' => 'Date Added',
 'author' => 'Submited by',
 'hits' => 'Clicks'
);
###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'Submit a Link',
    2 => 'Link',
    3 => 'Category',
    4 => 'Other',
    5 => 'If other, please specify',
    6 => 'Error: Missing Category',
    7 => 'When selecting "Other" please also provide a category name',
    8 => 'Title',
    9 => 'URL',
    10 => 'Category',
    11 => 'Link Submissions'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Thank-you for submitting a link to {$_CONF['site_name']}.  It has been submitted to our staff for approval.  If approved, your link will be seen in the <a href={$_CONF['site_url']}/links.php>links</a> section.";
$PLG_links_MESSAGE2 = 'Your link has been successfully saved.';
$PLG_links_MESSAGE3 = 'The link has been successfully deleted.';
$PLG_links_MESSAGE4 = "Thank-you for submitting a link to {$_CONF['site_name']}.  You can see it now in the <a href={$_CONF['site_url']}/links.php>links</a> section.";

###############################################################################
# admin/link.php

$LANG_LINKS_ADMIN = array(
    1 => 'Link Editor',
    2 => 'Link ID',
    3 => 'Link Title',
    4 => 'Link URL',
    5 => 'Category',
    6 => '(include http://)',
    7 => 'Other',
    8 => 'Link Hits',
    9 => 'Link Description',
    10 => 'You need to provide a link Title, URL and Description.',
    11 => 'Link Manager',
    12 => 'To modify or delete a link, click on that link below.  To create a new link click new link above.',
    13 => 'Link Title',
    14 => 'Link Category',
    15 => 'Link URL',
    16 => 'Access Denied',
    17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/link.php\">go back to the link administration screen</a>.",
    18 => 'New Link',
    19 => 'Admin Home',
    20 => 'If other, specify',
    21 => 'save',
    22 => 'cancel',
    23 => 'delete'
);

?>
