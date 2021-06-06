<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | public_html/admin/plugins/recaptcha/index.php                             |
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

require_once '../../../lib-common.php';

// Only let admin users access this page
if (!SEC_hasRights('recaptcha.edit')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the recaptcha Admin page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . \Geeklog\IP::getIPAddress(), 1);

    $content = COM_startBlock(RECAPTCHA_esc($LANG_ACCESS['accessdenied']))
        . RECAPTCHA_esc($LANG_ACCESS['plugin_access_denied_msg'])
        . COM_endBlock();
    $display = COM_createHTMLDocument($content);
    COM_output($display);
    exit;
}

// Main
header('Location: ' . $_CONF['site_admin_url'] . '/configuration.php');
