<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | auth.inc.php                                                              |
// |                                                                           |
// | Geeklog admin authentication module                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
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
// $Id: auth.inc.php,v 1.21 2004/08/15 12:06:10 dhaun Exp $

// this file can't be used on its own
if (eregi ('auth.inc.php', $HTTP_SERVER_VARS['PHP_SELF']))
{
    die ('This file can not be used on its own.');
}

// MAIN

if (!empty($loginname) && !empty($passwd)) {
    $mypasswd = COM_getPassword($loginname);
} else {
    srand((double)microtime()*1000000);
    $mypasswd = rand();
}

$display = '';

if (!empty ($passwd) && !empty ($mypasswd) && ($mypasswd == md5 ($passwd))) {
    $_USER = SESS_getUserData ($loginname);
    $sessid = SESS_newSession ($_USER['uid'], $HTTP_SERVER_VARS['REMOTE_ADDR'],
            $_CONF['session_cookie_timeout'], $_CONF['cookie_ip']);
    SESS_setSessionCookie ($sessid, $_CONF['session_cookie_timeout'],
            $_CONF['cookie_session'], $_CONF['cookie_path'],
            $_CONF['cookiedomain'], $_CONF['cookiesecure']);

    // Now that we handled session cookies, handle longterm cookie

    if (!isset ($HTTP_COOKIE_VARS[$_CONF['cookie_name']])) {

        // Either their cookie expired or they are new

        $cooktime = COM_getUserCookieTimeout();

        if (!empty($cooktime)) {
		
            // They want their cookie to persist for some amount of time so set it now

            setcookie ($_CONF['cookie_name'], $_USER['uid'],
                       time() + $cooktime, $_CONF['cookie_path'],
                       $_CONF['cookiedomain'], $_CONF['cookiesecure']);
        }
    }
    if (!SEC_hasRights('story.edit,block.edit,topic.edit,link.edit,event.edit,poll.edit,user.edit,plugin.edit','OR')) {
        $display .= COM_refresh($_CONF['site_admin_url'] . '/moderation.php');
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
} else if (!SEC_hasRights('story.edit,block.edit,topic.edit,link.edit,event.edit,poll.edit,user.edit,plugin.edit,user.mail','OR') && (count (PLG_getAdminOptions()) == 0)) {
    $display .= COM_siteHeader();

    $display .= COM_startBlock($LANG20[01]);

    if (!empty($warn)) {
        $display .= $LANG20[02]
        .'<br><br>'
        .COM_accessLog($LANG20[03] . ' ' . $loginname);
    }
	
    $display .= '<form action="' . $HTTP_SERVER_VARS['PHP_SELF']
             . '" method="POST">'
        .'<table cellspacing="0" cellpadding="0" border="0" width="100%">'.LB
        .'<tr><td align="right">'.$LANG20[04].'&nbsp;</td>'.LB
        .'<td><input type="text" name="loginname" size="16" maxlength="16"></td>'.LB
        .'</tr>'.LB
        .'<tr>'.LB
        .'<td align="right">'.$LANG20[05].'&nbsp;</td>'.LB
        .'<td><input type="password" name="passwd" size="16" maxlength="16"></td>'
        .'</tr>'.LB
        .'<tr>'.LB
        .'<td colspan="2" align="center" class="warning">'.$LANG20[06].'<input type="hidden" name="warn" value="1">'
        .'<br><input type="submit" name="mode" value="'.$LANG20[07].'"></td>'.LB
        .'</tr>'.LB
        .'</table></form>'
        .COM_endBlock()
        .COM_siteFooter();
        echo $display;
        exit;
}

echo $display;

?>
