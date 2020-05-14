<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/install_defaults.php                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014-2020 mystral-kk - geeklog AT mystral-kk DOT net        |
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
 * reCAPTCHA default settings
 *
 * Initial Installation Defaults used when loading the online configuration
 * records.  These settings are only used during the initial installation
 * and not referenced any more once the plugin is installed
 */
global $_RECAPTCHA_DEFAULT;

$_RECAPTCHA_DEFAULT = [
    'site_key'             => '',
    'secret_key'           => '',
    'invisible_site_key'   => '',
    'invisible_secret_key' => '',
    'site_key_v3'          => '',
    'secret_key_v3'        => '',

    'logging'        => 0,
    'anonymous_only' => 0,
    'remoteusers'    => 0,

    // reCAPTCHA V3 since v1.2.4 (Geeklog 2.2.2)
    'enable_comment'      => RECAPTCHA_SUPPORT_V3,
    'enable_contact'      => RECAPTCHA_SUPPORT_V3,
    'enable_emailstory'   => RECAPTCHA_SUPPORT_V3,
    'enable_registration' => RECAPTCHA_SUPPORT_V3,
    'enable_getpassword'  => RECAPTCHA_SUPPORT_V3,
    'enable_loginform'    => RECAPTCHA_SUPPORT_V3,
    'enable_story'        => RECAPTCHA_SUPPORT_V3,

    'score_comment'      => RECAPTCHA_DEFAULT_SCORE_THRESHOLD,
    'score_contact'      => RECAPTCHA_DEFAULT_SCORE_THRESHOLD,
    'score_emailstory'   => RECAPTCHA_DEFAULT_SCORE_THRESHOLD,
    'score_registration' => RECAPTCHA_DEFAULT_SCORE_THRESHOLD,
    'score_getpassword'  => RECAPTCHA_DEFAULT_SCORE_THRESHOLD,
    'score_loginform'    => RECAPTCHA_DEFAULT_SCORE_THRESHOLD,
    'score_story'        => RECAPTCHA_DEFAULT_SCORE_THRESHOLD,
];

/**
 * Initializes reCAPTCHA plugin configuration
 *
 * Creates the database entries for the configuration if they don't already
 * exist.  Initial values will be taken from $_RECAPTCHA_DEFAULT
 * if available (e.g. from an old config.php), uses $_RECAPTCHA_DEFAULT
 * otherwise.
 *
 * @return bool true: success, false: an error occurred
 */
function plugin_initconfig_recaptcha()
{
    global $_RECAPTCHA_DEFAULT;

    $c = config::get_instance();
    $me = 'recaptcha';
    $so = 0;
    $sg = 0;
    $fs = 0;
    $tab = 0;

    if (!$c->group_exists($me)) {
        // Subgroup = 0
        $c->add('sg_main', null, 'subgroup', $sg, $fs, null, $so, true, $me, $tab);
        $c->add('tab_general', null, 'tab', $sg, $fs, null, $so, true, $me, $tab);

        // Subgroup = 0, Fieldset = 0, Tab = 0
        $c->add('fs_system', null, 'fieldset', $sg, $fs, null, 0, true, $me, $tab);
        $so += 10;
        $c->add('site_key', $_RECAPTCHA_DEFAULT['site_key'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('secret_key', $_RECAPTCHA_DEFAULT['secret_key'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('invisible_site_key', $_RECAPTCHA_DEFAULT['invisible_site_key'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('invisible_secret_key', $_RECAPTCHA_DEFAULT['invisible_secret_key'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('site_key_v3', $_RECAPTCHA_DEFAULT['site_key_v3'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('secret_key_v3', $_RECAPTCHA_DEFAULT['secret_key_v3'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('logging', $_RECAPTCHA_DEFAULT['logging'], 'select', $sg, $fs, 0, $so, true, $me, $tab);
        $so += 10;
        $c->add('anonymous_only', $_RECAPTCHA_DEFAULT['anonymous_only'], 'select', $sg, $fs, 0, $so, true, $me, $tab);
        $so += 10;
        $c->add('remoteusers', $_RECAPTCHA_DEFAULT['remoteusers'], 'select', $sg, $fs, 0, $so, true, $me, $tab);
        $so += 10;

        // Subgroup = 0, Fieldset = 0, Tab = 1
        $tab++;
        $c->add('tab_integration', null, 'tab', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('fs_integration', null, 'fieldset', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('enable_comment', $_RECAPTCHA_DEFAULT['enable_comment'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
        $so += 10;
        $c->add('enable_contact', $_RECAPTCHA_DEFAULT['enable_contact'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
        $so += 10;
        $c->add('enable_emailstory', $_RECAPTCHA_DEFAULT['enable_emailstory'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
        $so += 10;
        $c->add('enable_registration', $_RECAPTCHA_DEFAULT['enable_registration'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
        $so += 10;
        $c->add('enable_getpassword', $_RECAPTCHA_DEFAULT['enable_getpassword'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
        $so += 10;
        $c->add('enable_loginform', $_RECAPTCHA_DEFAULT['enable_loginform'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
        $so += 10;
        $c->add('enable_story', $_RECAPTCHA_DEFAULT['enable_story'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
        $so += 10;

        // Since v1.2.4 (Geeklog 2.2.2)
        $tab++;
        $c->add('tab_score', null, 'tab', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('fs_score', null, 'fieldset', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('score_comment', $_RECAPTCHA_DEFAULT['score_comment'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('score_contact', $_RECAPTCHA_DEFAULT['score_contact'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('score_emailstory', $_RECAPTCHA_DEFAULT['score_emailstory'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('score_registration', $_RECAPTCHA_DEFAULT['score_registration'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('score_getpassword', $_RECAPTCHA_DEFAULT['score_getpassword'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('score_loginform', $_RECAPTCHA_DEFAULT['score_loginform'], 'text', $sg, $fs, null, $so, true, $me, $tab);
        $so += 10;
        $c->add('score_story', $_RECAPTCHA_DEFAULT['score_story'], 'text', $sg, $fs, null, $so, true, $me, $tab);
    }

    return true;
}
