<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Page Geeklog Plugin 1.3                                            |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// | This is the main page for the Geeklog Static Page Plugin                  |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Tom Willett      - twillett@users.sourceforge.net                |
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
// $Id: index.php,v 1.11 2003/03/11 17:00:57 dhaun Exp $

require_once ('../lib-common.php');


$error = 0;

if (!empty ($_USER['uid'])) {
    $result = DB_query ("SELECT noboxes FROM {$_TABLES['userindex']} WHERE uid = '{$_USER['uid']}'");
    $U = DB_fetchArray ($result);
}

COM_setArgNames (array ('page'));
$page = COM_getArgument ('page');

if (empty ($page)) {
    $error = 1;
}

$perms = SP_getPerms ();
if (!empty ($perms)) {
    $perms = ' AND ' . $perms;
}
$result = DB_query ("SELECT * FROM {$_TABLES['staticpage']} WHERE (sp_id = '$page')" . $perms);
$count = DB_numRows ($result);

if ($count == 0 || $count > 1) {
    $error = 1;
}

if (!($error)) {
    $A = DB_fetchArray ($result);
    $_CONF["pagetitle"] = stripslashes ($A['sp_title']);
    if ($A['sp_format'] == 'allblocks' OR $A['sp_format'] == 'leftblocks') {
        $retval .= COM_siteHeader ('menu');
    } else {
        if ($A['sp_format'] <> 'blankpage') {
            $retval .= COM_siteHeader ('none');
        }
    }
    if ($_SP_CONF['in_block'] == 1) {
        $retval .= COM_startBlock (stripslashes ($A['sp_title']));
    }
    //Check for type (ie html or php)
    if ($A['sp_php'] == 1) {
        $retval .= eval (stripslashes ($A['sp_content']));
    } else {
        $retval .= stripslashes ($A['sp_content']);
    }
    if ($A['sp_format'] <> 'blankpage') {
        $curtime = COM_getUserDateTimeFormat ($A['sp_date']);
        $retval .= '<p align="center"><br>' . $LANG_STATIC['lastupdated']
                . ' ' . $curtime[0]; 
        if (SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']) == 3) {
            $retval .= '<br><a href="' . COM_buildURL ($_CONF['site_admin_url']
                    . '/plugins/staticpages/index.php?mode=edit&amp;sp_id='
                    . $page) . '">';
            $retval .= $LANG_STATIC['edit'] . "</a>";
        }
        $retval .= '</p>';
    }
    if ($_SP_CONF['in_block'] == 1) {
        $retval .= COM_endBlock ();
    }

    if ($A['sp_format'] <> 'blankpage') {
    	if ($A['sp_format'] == 'allblocks' && $U['noboxes'] != 1) {
            $retval .= COM_siteFooter (true);
    	} else {
            $retval .= COM_siteFooter ();
        }
    }

    // increment hit counter for page...is SQL compliant?  
    DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_hits = sp_hits + 1 WHERE sp_id = '$page'"); 
} else {
    $failflg = DB_getItem ($_TABLES['staticpage'], 'sp_nf', "sp_id='$page'");
    if ($failflg) {
        $retval = COM_siteHeader ('menu');
        $retval .= COM_startBlock ($LANG_LOGIN[1]);
        $login = new Template ($_CONF['path_layout'] . 'submit');
        $login->set_file (array ('login'=>'submitloginrequired.thtml'));
        $login->set_var ('login_message', $LANG_LOGIN[2]);
        $login->set_var ('site_url', $_CONF['site_url']);
        $login->set_var ('lang_login', $LANG_LOGIN[3]);
        $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
        $login->parse ('output', 'login');
        $retval .= $login->finish ($login->get_var ('output'));
        $retval .= COM_endBlock ();
        $retval .= COM_siteFooter (true);
    } else {
        $retval = COM_siteHeader ('menu');
	    $retval .= COM_startBlock ($LANG_ACCESS['accessdenied']);
    	$retval .= $LANG_STATIC['deny_msg'];
	    $retval .= COM_endBlock ();
    	$retval .= COM_siteFooter (true);
    }
}

echo $retval;

?>
