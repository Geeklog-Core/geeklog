<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/install_updates.php                             |
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

/**
 * Update Configuration settings for reCAPTCHA plugin
 *
 * @return bool true on success, false otherwise
 */
function recaptcha_update_ConfValues_1_1_5()
{
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
