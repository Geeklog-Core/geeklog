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

// What's New Block
$_PO_DEFAULT['new_polls_interval'] = 1209600; // 2 weeks
$_PO_DEFAULT['hide_new_polls'] = 'hide'; // 'hide', 'created', 'modified'
$_PO_DEFAULT['title_trim_length'] = 20;

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

// Define default usuage permissions for the polls autotags.
// Permissions are perm_owner, perm_group, perm_members, perm_anon (in that
// order). Possible values:
// 2 = use
// 0 = cannot use
// (a value of 1 is not allowed)
$_PO_DEFAULT['autotag_permissions_poll'] = array (2, 2, 2, 2);
$_PO_DEFAULT['autotag_permissions_poll_vote'] = array (2, 2, 0, 0);
$_PO_DEFAULT['autotag_permissions_poll_result'] = array (2, 2, 0, 0);


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

        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'polls', 0);
        $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, 'polls', 0);
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, true, 'polls', 0);
        $c->add('pollsloginrequired', $_PO_DEFAULT['pollsloginrequired'],
                'select', 0, 0, 0, 10, true, 'polls', 0);
        $c->add('hidepollsmenu', $_PO_DEFAULT['hidepollsmenu'], 'select',
                0, 0, 1, 20, true, 'polls', 0);
        $c->add('maxquestions', $_PO_DEFAULT['maxquestions'], 'text',
                0, 0, 0, 30, true, 'polls', 0);
        $c->add('maxanswers', $_PO_DEFAULT['maxanswers'], 'text',
                0, 0, 0, 40, true, 'polls', 0);
        $c->add('answerorder', $_PO_DEFAULT['answerorder'], 'select',
                0, 0, 2, 50, true, 'polls', 0);
        $c->add('pollcookietime', $_PO_DEFAULT['pollcookietime'], 'text',
                0, 0, 0, 60, true, 'polls', 0);
        $c->add('polladdresstime', $_PO_DEFAULT['polladdresstime'], 'text',
                0, 0, 0, 70, true, 'polls', 0);
        $c->add('delete_polls', $_PO_DEFAULT['delete_polls'], 'select',
                0, 0, 0, 80, true, 'polls', 0);
        $c->add('aftersave', $_PO_DEFAULT['aftersave'], 'select',
                0, 0, 9, 90, true, 'polls', 0);
        $c->add('meta_tags', $_PO_DEFAULT['meta_tags'], 'select',
                0, 0, 0, 100, true, 'polls', 0);        
        
        $c->add('tab_whatsnew', NULL, 'tab', 0, 1, NULL, 0, true, 'polls', 1);
        $c->add('fs_whatsnew', NULL, 'fieldset', 0, 1, NULL, 0, true, 'polls', 1);
        $c->add('newpollsinterval',$_PO_DEFAULT['new_polls_interval'],'text',
                0, 1, NULL, 10, TRUE, 'polls', 1);
        $c->add('hidenewpolls',$_PO_DEFAULT['hide_new_polls'],'select',
                0, 1, 5, 20, TRUE, 'polls', 1);
        $c->add('title_trim_length',$_PO_DEFAULT['title_trim_length'],'text',
                0, 1, NULL, 30, TRUE, 'polls', 1);

        $c->add('tab_permissions', NULL, 'tab', 0, 2, NULL, 0, true, 'polls', 2);
        $c->add('fs_permissions', NULL, 'fieldset', 0, 2, NULL, 0, true, 'polls', 2);
        $c->add('default_permissions', $_PO_DEFAULT['default_permissions'], '@select', 
                0, 2, 12, 100, true, 'polls', 2);
        
        $c->add('tab_autotag_permissions', NULL, 'tab', 0, 10, NULL, 0, true, 'polls', 10);
        $c->add('fs_autotag_permissions', NULL, 'fieldset', 0, 10, NULL, 0, true, 'polls', 10);
        $c->add('autotag_permissions_poll', $_PO_DEFAULT['autotag_permissions_poll'], '@select', 
                0, 10, 13, 10, true, 'polls', 10);       
        $c->add('autotag_permissions_poll_vote', $_PO_DEFAULT['autotag_permissions_poll_vote'], '@select', 
                0, 10, 13, 10, true, 'polls', 10);       
        $c->add('autotag_permissions_poll_result', $_PO_DEFAULT['autotag_permissions_poll_result'], '@select', 
                0, 10, 13, 10, true, 'polls', 10);       
    }

    return true;
}

?>
