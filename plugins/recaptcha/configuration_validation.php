<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/autoinstall.php                                 |
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

// reCAPTCHA Plugin Main Settings
$_CONF_VALIDATE['recaptcha'] = [
    'site_key'             => ['rule' => 'stringOrEmpty'],
    'secret_key'           => ['rule' => 'stringOrEmpty'],
    'invisible_site_key'   => ['rule' => 'stringOrEmpty'],
    'invisible_secret_key' => ['rule' => 'stringOrEmpty'],
    'logging'              => ['rule' => ['inList', ['0', '1'], true]],
    'anonymous_only'       => ['rule' => ['inList', ['0', '1'], true]],
    'remoteusers'          => ['rule' => ['inList', ['0', '1'], true]],

    // '0' => Disabled, '1' => reCAPTCHA V2, '2' => reCAPTCHA V2 Invisible, '4' => reCAPTCHA V3
    'enable_comment'       => ['rule' => ['inList', ['0', '1', '2', '4'], true]],
    'enable_contact'       => ['rule' => ['inList', ['0', '1', '2', '4'], true]],
    'enable_emailstory'    => ['rule' => ['inList', ['0', '1', '2', '4'], true]],
    'enable_registration'  => ['rule' => ['inList', ['0', '1', '2', '4'], true]],
    'enable_getpassword'   => ['rule' => ['inList', ['0', '1', '2', '4'], true]],
    'enable_loginform'     => ['rule' => ['inList', ['0', '1', '2', '4'], true]],
    'enable_story'         => ['rule' => ['inList', ['0', '1', '2', '4'], true]],

    // Score thresholds: 0.0 (even a bot will be accepted) - 1.0 (only humans will be accepted), default 0.5
    'score_comment'        => ['rule' => ['range', 0, 1]],
    'score_contact'        => ['rule' => ['range', 0, 1]],
    'score_emailstory'     => ['rule' => ['range', 0, 1]],
    'score_registration'   => ['rule' => ['range', 0, 1]],
    'score_getpassword'    => ['rule' => ['range', 0, 1]],
    'score_loginform'      => ['rule' => ['range', 0, 1]],
    'score_story'          => ['rule' => ['range', 0, 1]],
];
