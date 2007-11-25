<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | auth.inc.php                                                              |
// |                                                                           |
// | Geeklog admin authentication module                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
//
// $Id: auth.inc.php,v 1.35 2007/11/25 06:58:55 ospiess Exp $

// this file can't be used on its own
if (strpos ($_SERVER['PHP_SELF'], 'auth.inc.php') !== false)
{
    die ('This file can not be used on its own.');
}

// MAIN
$uid = '';
if (!empty ($_POST['loginname']) && !empty ($_POST['passwd'])) {
    $status = SEC_authenticate (COM_applyFilter ($_POST['loginname']),
                                $_POST['passwd'], $uid);
} else {
    $status = '';
}
$display = '';

if ($status == 3) {
    DB_change($_TABLES['users'],'pwrequestid',"NULL",'uid',$uid);
    $_USER = SESS_getUserDataFromId ($uid);
    $sessid = SESS_newSession ($_USER['uid'], $_SERVER['REMOTE_ADDR'],
            $_CONF['session_cookie_timeout'], $_CONF['cookie_ip']);
    SESS_setSessionCookie ($sessid, $_CONF['session_cookie_timeout'],
            $_CONF['cookie_session'], $_CONF['cookie_path'],
            $_CONF['cookiedomain'], $_CONF['cookiesecure']);
    PLG_loginUser ($_USER['uid']);

    // Now that we handled session cookies, handle longterm cookie

    if (!isset ($_COOKIE[$_CONF['cookie_name']])) {

        // Either their cookie expired or they are new

        $cooktime = COM_getUserCookieTimeout();

        if (!empty($cooktime)) {

            // They want their cookie to persist for some amount of time so set it now

            setcookie ($_CONF['cookie_name'], $_USER['uid'],
                       time() + $cooktime, $_CONF['cookie_path'],
                       $_CONF['cookiedomain'], $_CONF['cookiesecure']);
        }
    }
    if (!SEC_hasRights('story.edit,block.edit,topic.edit,user.edit,plugin.edit,syndication.edit','OR')) {
        $display .= COM_refresh($_CONF['site_admin_url'] . '/moderation.php');
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
    echo $display;
    exit;
} else if (!SEC_hasRights('story.edit,block.edit,topic.edit,user.edit,plugin.edit,user.mail,syndication.edit','OR') && (count (PLG_getAdminOptions()) == 0)) {
    $display .= COM_siteHeader();

    $display .= COM_startBlock($LANG20[01]);

    if (!empty($warn)) {
        $display .= $LANG20[02]
        .'<br' . XHTML . '><br' . XHTML . '>'
        .COM_accessLog($LANG20[03] . ' ' . $_POST['loginname']);
    }

    $display .= '<form action="' . $_SERVER['PHP_SELF']
             . '" method="post">'
        .'<table cellspacing="0" cellpadding="0" border="0" width="100%">'.LB
        .'<tr><td align="right">'.$LANG20[04].'&nbsp;</td>'.LB
        .'<td><input type="text" name="loginname" size="16" maxlength="16"' . XHTML . '></td>'.LB
        .'</tr>'.LB
        .'<tr>'.LB
        .'<td align="right">'.$LANG20[05].'&nbsp;</td>'.LB
        .'<td><input type="password" name="passwd" size="16" maxlength="16"' . XHTML . '></td>'
        .'</tr>'.LB
        .'<tr>'.LB
        .'<td colspan="2" align="center" class="warning">'.$LANG20[06].'<input type="hidden" name="warn" value="1"' . XHTML . '>'
        .'<br' . XHTML . '><input type="submit" name="mode" value="'.$LANG20[07].'"' . XHTML . '></td>'.LB
        .'</tr>'.LB
        .'</table></form>'
        .COM_endBlock()
        .COM_siteFooter();
        echo $display;
        exit;
}

?>
