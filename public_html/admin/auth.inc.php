<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | auth.inc.php                                                              |
// |                                                                           |
// | Geeklog admin authentication module                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
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

// this file can't be used on its own
if (strpos(strtolower($_SERVER['PHP_SELF']), 'auth.inc.php') !== false) {
    die('This file can not be used on its own.');
}

// MAIN
COM_clearSpeedlimit($_CONF['login_speedlimit'], 'login');
if (COM_checkSpeedlimit('login', $_CONF['login_attempts']) > 0) {
    COM_displayMessageAndAbort(82, '', 403, 'Access denied');
}

$uid = '';
if (!empty($_POST['loginname']) && !empty($_POST['passwd'])) {
    if ($_CONF['user_login_method']['standard']) {
        $status = SEC_authenticate(Geeklog\Input::fPost('loginname'), Geeklog\Input::post('passwd'), $uid);
    } else {
        $status = '';
    }
} else {
    $status = '';
}
$display = '';

if ($status == USER_ACCOUNT_ACTIVE) {
    DB_query("UPDATE {$_TABLES['users']} SET pwrequestid = NULL WHERE uid = $uid");
    $_USER = SESS_getUserDataFromId($uid);
    $sessid = SESS_newSession($_USER['uid'], $_SERVER['REMOTE_ADDR'],
            $_CONF['session_cookie_timeout'], $_CONF['cookie_ip']);
    SESS_setSessionCookie($sessid, $_CONF['session_cookie_timeout'],
            $_CONF['cookie_session'], $_CONF['cookie_path'],
            $_CONF['cookiedomain'], $_CONF['cookiesecure']);
    PLG_loginUser($_USER['uid']);

    // Now that we handled session cookies, handle longterm cookie
    if (!isset($_COOKIE[$_CONF['cookie_name']])) {
        // Either their cookie expired or they are new
        $cooktime = COM_getUserCookieTimeout();

        if (!empty($cooktime)) {
            // They want their cookie to persist for some amount of time so set it now
            SEC_setCookie($_CONF['cookie_name'], $_USER['uid'], time() + $cooktime);
        }
    }

    if (!SEC_hasRights('story.edit,block.edit,topic.edit,user.edit,plugin.edit,syndication.edit,theme.edit','OR')) {
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    } else {
        COM_redirect($_CONF['site_url'] . '/index.php');
    }
} elseif (!SEC_hasRights('story.edit,block.edit,topic.edit,user.edit,plugin.edit,user.mail,syndication.edit,theme.edit','OR') &&
    (count(PLG_getAdminOptions()) == 0) && !SEC_hasConfigAccess()) {
    COM_updateSpeedlimit('login');

    $template = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'users'));
    $template->set_file(array('authenticationrequired' => 'authenticationrequired.thtml'));
    
    $display .= COM_startBlock($LANG20[1]);
    if (!$_CONF['user_login_method']['standard']) {
        $template->set_var('lang_nonstandardlogin', $LANG_LOGIN[2]);
    } else {
        $template->set_var('lang_username', $LANG20[4]);
        $template->set_var('lang_password', $LANG20[5]);
        $template->set_var('lang_warning', $LANG20[6]);
        $template->set_var('lang_login', $LANG20[8]);
        $template->set_var('value_login', $LANG20[7]);
        if (isset($_POST['warn'])) {
            $template->set_var('lang_incorrectlogin', $LANG20[2]);
            COM_accessLog($LANG20[3] . ' ' . Geeklog\Input::post('loginname'));
        }        
    }
    
    // For Captcha 
    PLG_templateSetVars('loginform', $template);
    
    $display .= $template->finish($template->parse('output', 'authenticationrequired'));        

    $display .= COM_endBlock();
    $display = COM_createHTMLDocument($display);
    COM_output($display);
    exit;
}
