<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/autoinstall.php                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014-2017 mystral-kk - geeklog AT mystral-kk DOT net        |
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
$_CONF_VALIDATE['recaptcha'] = array(
    'site_key'             => array('rule' => 'stringOrEmpty'),
    'secret_key'           => array('rule' => 'stringOrEmpty'),
    'invisible_site_key'   => array('rule' => 'stringOrEmpty'),
    'invisible_secret_key' => array('rule' => 'stringOrEmpty'),
    'logging'              => array('rule' => array('inList', array('0', '1'), true)),
    'anonymous_only'       => array('rule' => array('inList', array('0', '1'), true)),
    'remoteusers'          => array('rule' => array('inList', array('0', '1'), true)),

    // '0' => Disabled, '1' => reCAPTCHA v2, '2' => Invisible reCAPTCHA
    'enable_comment'       => array('rule' => array('inList', array('0', '1', '2'), true)),
    'enable_contact'       => array('rule' => array('inList', array('0', '1', '2'), true)),
    'enable_emailstory'    => array('rule' => array('inList', array('0', '1', '2'), true)),
    'enable_registration'  => array('rule' => array('inList', array('0', '1', '2'), true)),
    'enable_getpassword'   => array('rule' => array('inList', array('0', '1', '2'), true)),
    'enable_loginform'     => array('rule' => array('inList', array('0', '1', '2'), true)),
    'enable_story'         => array('rule' => array('inList', array('0', '1', '2'), true)),
    'enable_calendar'      => array('rule' => array('inList', array('0', '1', '2'), true)),
    'enable_links'         => array('rule' => array('inList', array('0', '1', '2'), true)),

    // The plugins below still don't support Invisible reCAPTCHA
    'enable_forum'         => array('rule' => array('inList', array('0', '1', '2'), true)),
    'enable_mediagallery'  => array('rule' => array('inList', array('0', '1'), true)),
    'enable_rating'        => array('rule' => array('inList', array('0', '1'), true)),
);
