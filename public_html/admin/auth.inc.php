<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
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
    COM_displayMessageAndAbort($LANG04[112], '', 403, 'Access denied');
}

$uid = '';
if (!empty($_POST['loginname']) && !empty($_POST['passwd'])) {
    if ($_CONF['user_login_method']['standard']) {
        $status = SEC_authenticate(COM_applyFilter($_POST['loginname']),
                                   $_POST['passwd'], $uid);
    } else {
        $status = '';
    }
} else {
    $status = '';
}
$display = '';

if ($status == USER_ACCOUNT_ACTIVE) {
    DB_change($_TABLES['users'], 'pwrequestid', "NULL", 'uid', $uid);
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

            SEC_setCookie($_CONF['cookie_name'], $_USER['uid'],
                          time() + $cooktime);
        }
    }
    if (!SEC_hasRights('story.edit,block.edit,topic.edit,user.edit,plugin.edit,syndication.edit','OR')) {
        $display .= COM_refresh($_CONF['site_admin_url'] . '/moderation.php');
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
    echo $display;
    exit;
} else if (!SEC_hasRights('story.edit,block.edit,topic.edit,user.edit,plugin.edit,user.mail,syndication.edit','OR') && (count(PLG_getAdminOptions()) == 0)) {
    COM_updateSpeedlimit('login');

    $display .= COM_siteHeader('menu');
    $display .= COM_startBlock($LANG20[1]);

    if (!$_CONF['user_login_method']['standard']) {
        $display .= '<p>' . $LANG_LOGIN[2] . '</p>';
    } else {

        if (isset($_POST['warn'])) {
            $display .= $LANG20[2]
                     . '<br' . XHTML . '><br' . XHTML . '>'
                     . COM_accessLog($LANG20[3] . ' ' . $_POST['loginname']);
        }

        $display .= '<form action="' . $_CONF['site_admin_url'] . '/moderation.php" method="post">'
            .'<table cellspacing="0" cellpadding="3" border="0" width="100%">'.LB
            .'<tr><td class="alignright"><b><label for="loginname">'.$LANG20[4].'</label></b></td>'.LB
            .'<td><input type="text" name="loginname" id="loginname" size="16" maxlength="16"' . XHTML . '></td>'.LB
            .'</tr>'.LB
            .'<tr>'.LB
            .'<td class="alignright"><b><label for="passwd">'.$LANG20[5].'</label></b></td>'.LB
            .'<td><input type="password" name="passwd" id="passwd" size="16"' . XHTML . '></td>'
            .'</tr>'.LB
            .'<tr>'.LB
            .'<td colspan="2" align="center" class="warning">'.$LANG20[6].'<input type="hidden" name="warn" value="1"' . XHTML . '>'
            .'<br' . XHTML . '><input type="submit" name="mode" value="'.$LANG20[7].'"' . XHTML . '></td>'.LB
            .'</tr>'.LB
            .'</table></form>';
    }

    $display .= COM_endBlock()
             . COM_siteFooter();
    COM_output($display);
    exit;
}

?>
