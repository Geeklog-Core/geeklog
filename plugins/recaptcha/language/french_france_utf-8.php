<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/french_france_utf-8.php                |
// +---------------------------------------------------------------------------|
// | Copyright (C) 2014-2020 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Based on the CAPTCHA Plugin by Ben                                        |
// |                                                - ben AT geeklog DOT fr    |
// | Based on the original CAPTCHA Plugin by Mark R. Evans                     |
// |                                                - mark AT glfusion DOT org |
// | Constructed with the Universal Plugin                                     |
// +---------------------------------------------------------------------------|
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own!');
}

$LANG_RECAPTCHA = [
    'plugin'      => 'reCAPTCHA',
    'admin'       => 'reCAPTCHA',
    'msg_error'   => 'Error, reCAPTCHA was invalid.',
    'entry_error' => 'An invalid reCAPTCHA string was entered in %1s - IP Address: %2s - Error Codes: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'reCAPTCHA Configuration',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'reCAPTCHA V2 Site Key',
    'secret_key'           => 'reCAPTCHA V2 Secret Key',
    'invisible_site_key'   => 'Invisible reCAPTCHA Site Key',
    'invisible_secret_key' => 'Invisible reCAPTCHA Secret Key',
    'site_key_v3'          => 'reCAPTCHA V3 Site Key',
    'secret_key_v3'        => 'reCAPTCHA V3 Secret Key',
    'logging'              => 'Log invalid reCAPTCHA attempts',
    'anonymous_only'       => 'Anonymous Only',
    'remoteusers'          => 'Force CAPTCHA for all Remote Users',
    'enable_comment'       => 'Enable Comment Support',
    'enable_contact'       => 'Enable Contact Support',
    'enable_emailstory'    => 'Enable Email Story Support',
    'enable_registration'  => 'Enable Registration Support',
    'enable_loginform'     => 'Enable Login Form Support',
    'enable_getpassword'   => 'Enable Get Password Form Support',
    'enable_story'         => 'Enable Story Support',
    'score_comment'        => 'Score Threshold for Comment',
    'score_contact'        => 'Score Threshold for Contact',
    'score_emailstory'     => 'Score Threshold for Email Story',
    'score_registration'   => 'Score Threshold for Registration',
    'score_loginform'      => 'Score Threshold for Login Form',
    'score_getpassword'    => 'Score Threshold for Get Password Form',
    'score_story'          => 'Score Threshold for Story',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => 'Main Settings',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'reCAPTCHA Settings',
    'tab_integration' => 'Geeklog Integration',
    'tab_score'       => 'Score Thresholds',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'System',
    'fs_integration' => 'Geeklog Integration',
    'fs_score'       => 'Score Thresholds',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['Yes' => 1, 'No' => 0],
    2 => ['Disabled' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4],
];
