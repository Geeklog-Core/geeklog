<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/config.php                                      |
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

$_RECAPTCHA_CONF = array();

// Plugin info
$_RECAPTCHA_CONF['pi_version'] = '1.2.1';											// Plugin Version
$_RECAPTCHA_CONF['gl_version'] = '2.2.0';											// GL Version plugin for
$_RECAPTCHA_CONF['pi_url']     = 'https://github.com/Geeklog-Plugins/recaptcha';	// Plugin Homepage
$_RECAPTCHA_CONF['GROUPS']     = array(
	'reCAPTCHA Admin' => 'Users in this group can administer the ReCAPTCHA plugin',
);
$_RECAPTCHA_CONF['FEATURES']   = array(
	'recaptcha.edit' => 'Access to reCAPTCHA editor',
);
$_RECAPTCHA_CONF['MAPPINGS']   = array(
	'recaptcha.edit' => array('reCAPTCHA Admin'),
);

// Items the reCAPTCHA plugin supports
$_RECAPTCHA_CONF['supported_items'] = array(
	'comment', 'story', 'registration', 'loginform', 'getpassword', 'contact',
	'emailstory', 'forum', 'mediagallery', 'rating', 'links', 'calendar',
);
