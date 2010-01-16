<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls plugin 2.0                                                          |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Dirk Haun        - dirk AT haun-online DOT de                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* Install data and defaults for the Polls plugin configuration
*
* @package Polls
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Polls default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */
global $_PO_DEFAULT;
$_PO_DEFAULT = array();

// when set to 1 will only allow logged-in users to view the list of past polls
$_PO_DEFAULT['pollsloginrequired'] = 0;

// Set to 1 to hide the "Polls" entry from the top menu:
$_PO_DEFAULT['hidepollsmenu']      = 0;

$_PO_DEFAULT['maxquestions']       = 5; // max. number of questions in a poll
$_PO_DEFAULT['maxanswers']         = 8; // max. number of options in a question

// 'submitorder' is the order in which answers are saved in admin/poll.php
// 'voteorder' will list answers ordered by number of votes (highest->lowest);
$_PO_DEFAULT['answerorder']        = 'submitorder';

// how long a poll is closed for a user after they've voted
$_PO_DEFAULT['pollcookietime']     = 86400;  // seconds (= 24 hours)
$_PO_DEFAULT['polladdresstime']    = 604800; // seconds (= 7 days)

// When a user is deleted, ownership of polls created by that user can
// be transfered to a user in the Root group (= 0) or the polls can be
// deleted (= 1).
$_PO_DEFAULT['delete_polls'] = 0;

/** What to show after a poll has been saved? Possible choices:
 * 'item' -> forward to the poll
 * 'list' -> display the admin-list of poll
 * 'plugin' -> display the public homepage of the poll plugin
 * 'home' -> display the site homepage
 * 'admin' -> display the site admin homepage
 */
$_PO_DEFAULT['aftersave'] = 'list';


// Display Meta Tags for static pages (1 = show, 0 = don't) 
$_PO_DEFAULT['meta_tags'] = 0;

// Define default permissions for new polls created from the Admin panel.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 3 = read + write permissions (perm_owner and perm_group only)
// 2 = read-only
// 0 = neither read nor write permissions
// (a value of 1, ie. write-only, does not make sense and is not allowed)
$_PO_DEFAULT['default_permissions'] = array (3, 2, 2, 2);


/**
* Initialize Polls plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_PO_CONF if available (e.g. from
* an old config.php), uses $_PO_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_polls()
{
    global $_CONF, $_PO_CONF, $_PO_DEFAULT;

    if (is_array($_PO_CONF) && (count($_PO_CONF) > 1)) {
        $_PO_DEFAULT = array_merge($_PO_DEFAULT, $_PO_CONF);
    }

    $c = config::get_instance();
    if (!$c->group_exists('polls')) {

        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'polls');
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, true, 'polls');
        $c->add('pollsloginrequired', $_PO_DEFAULT['pollsloginrequired'],
                'select', 0, 0, 0, 10, true, 'polls');
        $c->add('hidepollsmenu', $_PO_DEFAULT['hidepollsmenu'], 'select',
                0, 0, 1, 20, true, 'polls');
        $c->add('maxquestions', $_PO_DEFAULT['maxquestions'], 'text',
                0, 0, 0, 30, true, 'polls');
        $c->add('maxanswers', $_PO_DEFAULT['maxanswers'], 'text',
                0, 0, 0, 40, true, 'polls');
        $c->add('answerorder', $_PO_DEFAULT['answerorder'], 'select',
                0, 0, 2, 50, true, 'polls');
        $c->add('pollcookietime', $_PO_DEFAULT['pollcookietime'], 'text',
                0, 0, 0, 60, true, 'polls');
        $c->add('polladdresstime', $_PO_DEFAULT['polladdresstime'], 'text',
                0, 0, 0, 70, true, 'polls');
        $c->add('delete_polls', $_PO_DEFAULT['delete_polls'], 'select',
                0, 0, 0, 80, true, 'polls');
        $c->add('aftersave', $_PO_DEFAULT['aftersave'], 'select',
                0, 0, 9, 90, true, 'polls');
        $c->add('meta_tags', $_PO_DEFAULT['meta_tags'], 'select',
                0, 0, 0, 100, true, 'polls');        

        $c->add('fs_permissions', NULL, 'fieldset', 0, 1, NULL, 0, true, 'polls');
        $c->add('default_permissions', $_PO_DEFAULT['default_permissions'],
                '@select', 0, 1, 12, 100, true, 'polls');
    }

    return true;
}

?>
