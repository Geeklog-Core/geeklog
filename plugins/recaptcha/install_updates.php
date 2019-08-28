<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/install_updates.php                             |
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
 * Update Configuration settings for reCAPTCHA plugin v1.1.5
 *
 * @return bool true on success, false otherwise
 */
function recaptcha_update_ConfValues_1_1_5()
{
    global $_RECAPTCHA_DEFAULT;

    $c = config::get_instance();
    $me = 'recaptcha';
    $sg = 0;
    $fs = 1;
    $so = 160;
    $c->add('enable_getpassword', $_RECAPTCHA_DEFAULT['enable_getpassword'], 'select', $sg, $fs, 0, $so, true, $me, 0);
    $so += 10;
    $c->add('enable_loginform', $_RECAPTCHA_DEFAULT['enable_loginform'], 'select', $sg, $fs, 0, $so, true, $me, 0);

    return true;
}

/**
 * Update Configuration settings for reCAPTCHA plugin v1.1.6
 *
 * @return bool true on success, false otherwise
 */
function recaptcha_update_ConfValues_1_1_6()
{
    global $_RECAPTCHA_CONF, $_RECAPTCHA_DEFAULT, $_TABLES;

    // Delete old configuration values
    $sql = "DELETE FROM {$_TABLES['conf_values']} WHERE group_name = 'recaptcha'";
    DB_query($sql);

    $c = config::get_instance();
    $me = 'recaptcha';
    $so = 0;
    $sg = 0;
    $fs = 0;
    $tab = 0;

    // Subgroup = 0
    $c->add('sg_main', null, 'subgroup', $sg, $fs, null, $so, true, $me, $tab);
    $c->add('tab_general', null, 'tab', $sg, $fs, null, $so, true, $me, $tab);

    // Subgroup = 0, Fieldset = 0, Tab = 0
    $c->add('fs_system', null, 'fieldset', $sg, $fs, null, 0, true, $me, $tab);
    $so += 10;
    $c->add('site_key', $_RECAPTCHA_CONF['public_key'], 'text', $sg, $fs, null, $so, true, $me, $tab);
    $so += 10;
    $c->add('secret_key', $_RECAPTCHA_CONF['secret_key'], 'text', $sg, $fs, null, $so, true, $me, $tab);
    $so += 10;
    $c->add('invisible_site_key', '', 'text', $sg, $fs, null, $so, true, $me, $tab);
    $so += 10;
    $c->add('invisible_secret_key', '', 'text', $sg, $fs, null, $so, true, $me, $tab);
    $so += 10;
    $c->add('logging', $_RECAPTCHA_CONF['logging'], 'select', $sg, $fs, 0, $so, true, $me, $tab);
    $so += 10;
    $c->add('anonymous_only', $_RECAPTCHA_CONF['anonymous_only'], 'select', $sg, $fs, 0, $so, true, $me, $tab);
    $so += 10;
    $c->add('remoteusers', $_RECAPTCHA_CONF['remoteusers'], 'select', $sg, $fs, 0, $so, true, $me, $tab);
    $so += 10;

    // Subgroup = 0, Fieldset = 0, Tab = 1
    $tab++;
    $c->add('tab_integration', null, 'tab', $sg, $fs, null, $so, true, $me, $tab);
    $so += 10;
    $c->add('fs_integration', null, 'fieldset', $sg, $fs, null, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_comment', $_RECAPTCHA_CONF['enable_comment'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_contact', $_RECAPTCHA_CONF['enable_contact'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_emailstory', $_RECAPTCHA_CONF['enable_emailstory'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_forum', $_RECAPTCHA_CONF['enable_forum'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_registration', $_RECAPTCHA_CONF['enable_registration'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_getpassword', $_RECAPTCHA_CONF['enable_getpassword'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_loginform', $_RECAPTCHA_CONF['enable_loginform'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $c->add('enable_mediagallery', $_RECAPTCHA_CONF['enable_mediagallery'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_rating', $_RECAPTCHA_CONF['enable_rating'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_story', $_RECAPTCHA_CONF['enable_story'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_calendar', $_RECAPTCHA_CONF['enable_calendar'], 'select', $sg, $fs, 2, $so, true, $me, $tab);
    $so += 10;
    $c->add('enable_links', $_RECAPTCHA_CONF['enable_links'], 'select', $sg, $fs, 2, $so, true, $me, $tab);

    return true;
}

/**
 * Update Configuration settings for reCAPTCHA plugin v1.2.1 (Geeklog 2.2.1)
 *
 * @return bool true on success, false otherwise
 */
function recaptcha_update_ConfValues_1_2_0()
{
    $c = config::get_instance();
    $me = 'recaptcha';

    // Remove plugins from "Integration" tab, since the information on the tab will be
    // obtained through calling "plugin_supportsRecaptcha_xxx"
    $c->del('enable_forum', $me);
    $c->del('enable_mediagallery', $me);
    $c->del('enable_rating', $me);
    $c->del('enable_calendar', $me);
    $c->del('enable_links', $me);

    return true;
}
