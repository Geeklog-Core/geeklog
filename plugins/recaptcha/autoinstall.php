<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/autoinstall.php                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014-2019 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Based on the CAPTCHA Plugin by Ben                                        |
// |                                                - ben AT geeklog DOT fr    |
// | Based on the original CAPTCHA Plugin by Mark R. Evans                     |
// |                                                - mark AT glfusion DOT org |
// | Constructed with the Universal Plugin                                     |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own!');
}

/**
 * Plugin autoinstall function
 *
 * @param  string $pi_name Plugin name
 * @return array           Plugin information
 */
function plugin_autoinstall_recaptcha($pi_name)
{
    global $_CONF, $_RECAPTCHA_CONF;

    // IF demo mode (since GL 2.2.0) is in effect, return no valid information
    if (COM_isDemoMode()) {
        return [];
    }

    require_once __DIR__ . '/config.php';

    return [
        'info'     => [
            'pi_name'         => 'recaptcha',
            'pi_display_name' => 'reCAPTCHA',
            'pi_version'      => $_RECAPTCHA_CONF['pi_version'],
            'pi_gl_version'   => $_RECAPTCHA_CONF['gl_version'],
            'pi_homepage'     => $_RECAPTCHA_CONF['pi_url'],
        ],
        'groups'   => $_RECAPTCHA_CONF['GROUPS'],
        'features' => $_RECAPTCHA_CONF['FEATURES'],
        'mappings' => $_RECAPTCHA_CONF['MAPPINGS'],
        'tables'   => [],
    ];
}

/**
 * Load plugin configuration from database
 *
 * @param  string $pi_name Plugin name
 * @return bool    true on success, otherwise false
 * @see    plugin_initconfig_recaptcha
 */
function plugin_load_configuration_recaptcha($pi_name)
{
    require_once __DIR__ . '/install_defaults.php';

    return plugin_initconfig_recaptcha();
}

/**
 * Checks if the plugin is compatible with this Geeklog version
 *
 * @param  string $pi_name Plugin name
 * @return bool   true: plugin compatible; false: not compatible
 */
function plugin_compatible_with_this_version_recaptcha($pi_name)
{
    global $_RECAPTCHA_CONF;

    require_once __DIR__ . '/config.php';

    $geeklogVersion = preg_replace('/[^0-9.]/', '', VERSION);

    return version_compare(PHP_VERSION, '5.3.0', '>=') &&
        version_compare($geeklogVersion, $_RECAPTCHA_CONF['gl_version'], '>=');
}
