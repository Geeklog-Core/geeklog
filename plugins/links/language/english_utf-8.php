<?php

###############################################################################
# english_utf-8.php
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
# $Id: english_utf-8.php,v 1.6 2007/08/28 07:33:30 ospiess Exp $

/** 
 * This is the english language page for the Geeklog links Plug-in! 
 * 
 * @package Links
 * @subpackage Language
 * @filesource
 * @version 1.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License 
 * @author Trinity Bays <trinity93@steubentech.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 * 
 */


###############################################################################
# Array Format:
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
###############################################################################
/**
* the link plugin's lang array
* 
* @global array $LANG_LINKS 
*/
$LANG_LINKS= array(
    10 => 'Submissions',
    14 => 'Links',
    84 => 'LINKS',
    88 => 'No recent new links',
    114 => 'Links',
    116 => 'Add A Link',
    117 => 'Go',
    118 => 'Categories',
    'root' => 'Root' // this is the title used for the root (top level) category
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => 'Links (Clicks) in the System',
    'stats_headline' => 'Top Ten Links',
    'stats_page_title' => 'Links',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'It appears that there are no links on this site or no one has ever clicked on one.',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => 'Link Results',
 'title' => 'Title',
 'date' => 'Date Added',
 'author' => 'Submited by',
 'hits' => 'Clicks'
);

###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
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

$PLG_links_MESSAGE1 = "Thank-you for submitting a link to {$_CONF['site_name']}.  It has been submitted to our staff for approval.  If approved, your link will be seen in the <a href={$_CONF['site_url']}/links/index.php>links</a> section.";
$PLG_links_MESSAGE2 = 'Your link has been successfully saved.';
$PLG_links_MESSAGE3 = 'The link has been successfully deleted.';
$PLG_links_MESSAGE4 = "Thank-you for submitting a link to {$_CONF['site_name']}.  You can see it now in the <a href={$_CONF['site_url']}/links/index.php>links</a> section.";
$PLG_links_MESSAGE5 = "You do not have sufficient access rights to view this category.";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php
/**
* the link plugin's lang admin array
* 
* @global array $LANG_LINKS_ADMIN 
*/
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
    12 => 'To modify or delete a link, click on that link\'s edit icon below.  To create a new link or a new category, click on "New link" or "New category" above. To edit multiple categories, click on "Edit categories" above.',
    14 => 'Link Category',
    16 => 'Access Denied',
    17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">go back to the link administration screen</a>.",
    20 => 'If other, specify',
    24 => 'Edit categories',
    25 => 'New link',
    26 => 'New category',
    27 => 'Edit links',
    28 => 'Edit category',
    29 => 'Enter or edit the details below.',
    30 => 'Category',
    31 => 'Description',
    32 => 'Category ID',
    33 => 'Topic',
    34 => 'Parent',
    35 => 'You are not allowed to set the id of a category to "site" or "user" - these are reserved for internal use.',
    37 => 'Category deleted',
    38 => 'Category contains links and/or categories. Please remove these first.',
    39 => 'Category was saved successfully',
    40 => 'Edit this category',
    41 => 'Create child category',
    42 => 'Delete this category',
    43 => 'Site categories',
    44 => 'Add&nbsp;child',
    45 => 'You do not have sufficient rights to delete this category',
    46 => 'User %s tried to delete a category to which they do not have access rights',
    47 => 'No such category exists',
    48 => 'You are trying to make a parent category the child of it\'s own subcategory. This would create an orphan category, so please first move the child category or categories up to a higher level.'
);

?>