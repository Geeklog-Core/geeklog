<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/config.php                                      |
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

// Plugin info
$_RECAPTCHA_CONF = [
    'pi_version' => '1.2.1',                                        // Plugin Version
    'gl_version' => '2.2.1',                                        // GL Version plugin for];
    'pi_url'     => 'https://github.com/Geeklog-Plugins/recaptcha', // Plugin Homepage
    'GROUPS'     => [
        'reCAPTCHA Admin' => 'Users in this group can administer the ReCAPTCHA plugin',
    ],
    'FEATURES'   => [
        'recaptcha.edit' => 'Access to reCAPTCHA editor',
    ],
    'MAPPINGS'   => [
        'recaptcha.edit' => ['reCAPTCHA Admin'],
    ],

    'enable_comment'       => RECAPTCHA_SUPPORT_V2,
    'enable_contact'       => RECAPTCHA_SUPPORT_V2,
    'enable_emailstory'    => RECAPTCHA_SUPPORT_V2,
    'enable_registration'  => RECAPTCHA_SUPPORT_V2,
    'enable_getpassword'   => RECAPTCHA_SUPPORT_V2,
    'enable_loginform'     => RECAPTCHA_SUPPORT_V2,
    'enable_story'         => RECAPTCHA_SUPPORT_V2,
];
