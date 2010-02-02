<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Spam-X plugin 1.2                                                         |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2009 by the following authors:                         |
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
* Install data and defaults for the Spam-X plugin configuration
*
* @package Spam-X
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Spam-X default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records. These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 *
 */
global $_SPX_DEFAULT;
$_SPX_DEFAULT = array();

// Default Spam-X Action
$_SPX_DEFAULT['action'] = 128; // Default is to ignore (delete) the post

// address which mail admin module will use
// same as $_CONF['site_mail'] if empty
$_SPX_DEFAULT['notification_email'] = '';

// if set to = true, skip spam check for members of the "spamx Admin" group
$_SPX_DEFAULT['admin_override'] = false;

// enable / disable logging to spamx.log
$_SPX_DEFAULT['logging'] = true;

// timeout for contacting external services, e.g. SLV
$_SPX_DEFAULT['timeout'] = 5; // in seconds


/**
* Initialize Spam-X plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_SPX_CONF if available (e.g. from
* an old config.php), uses $_SPX_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
* @see      plugin_load_configuration_spamx
*
*/
function plugin_initconfig_spamx()
{
    global $_CONF, $_SPX_CONF, $_SPX_DEFAULT;

    if (is_array($_SPX_CONF) && (count($_SPX_CONF) > 1)) {
        $_SPX_DEFAULT = array_merge($_SPX_DEFAULT, $_SPX_CONF);
    }

    $c = config::get_instance();
    if (!$c->group_exists('spamx')) {

        $enable_email = true;
        if (empty($_SPX_DEFAULT['notification_email']) || ($_SPX_DEFAULT['notification_email'] == $_CONF['site_mail'])) {
            $enable_email = false;
        }

        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, true, 'spamx');
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, true, 'spamx');
        $c->add('logging', $_SPX_DEFAULT['logging'], 'select',
                0, 0, 1, 10, true, 'spamx');
        $c->add('timeout', $_SPX_DEFAULT['timeout'], 'text',
                0, 0, null, 30, true, 'spamx');
        $c->add('notification_email', $_SPX_DEFAULT['notification_email'],
                'text', 0, 0, null, 40, $enable_email, 'spamx');
        $c->add('action', $_SPX_DEFAULT['action'], 'text',
                0, 0, null, 50, false, 'spamx');

    }

    return true;
}

?>
