<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Page Geeklog Plugin 0.1                                            |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// | This is the main page for the Geeklog Static Page Plugin                  |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
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
// $Id: index.php,v 1.5 2002/05/14 13:29:50 mlimburg Exp $

require_once('../lib-common.php');

$error = 0;

if (!empty($USER["uid"])) {
        $result = DB_query("SELECT noboxes FROM {$_TABLES['userindex']} WHERE uid = '{$USER["uid"]}'");
        $U = DB_fetchArray($result);
}

if (empty($page)) {
	$error = 1;
}

$count = DB_count('staticpage','sp_id',$page);

if ($count == 0 || $count > 1) {
	$error = 1;
}

if (!($error)) {
	$result = DB_query("SELECT * FROM staticpage WHERE sp_id = '$page'");
	$A = DB_fetchArray($result);
	$_CONF["pagetitle"] = stripslashes($A['sp_title']);
	if ($A['sp_format'] == 'allblocks' OR $A["sp_format"] == 'leftblocks') {
		$retval .= COM_siteHeader('menu');
	} else {
        if ($A['sp_format'] <> 'blankpage') {
		    $retval .= COM_siteHeader('none');
        }
	}
	$retval .= stripslashes($A['sp_content']);
    if ($A['sp_format'] <> 'blankpage') {
	    $curtime = COM_getUserDateTimeFormat($A['sp_date']);
	    $retval .= '<br><br><center>' . $LANG_STATIC[lastupdated] . ' ' . $curtime[0] . '<br>'; 
	    if (SEC_hasRights('staticpages.edit,staticpages.delete','OR')) {
		    $retval .= "<a href={$_CONF['site_admin_url']}/plugins/staticpages/index.php?mode=edit&sp_id=$page>";
		    $retval .= $LANG_STATIC[edit] . "</a></center>";
	    }
    }

    
    if ($A['sp_format'] <> 'blankpage') 
    {

    	if ($A['sp_format'] == 'allblocks' && $U['noboxes'] != 1) {
            $retval .= COM_siteFooter(true);
    	} 
        else 
        {
            $retval .= COM_siteFooter();
        }
        
    }
   
    // increment hit counter for page...is SQL compliant?  
    DB_query("UPDATE staticpage SET sp_hits = sp_hits + 1 WHERE sp_id = '$page'"); 
} else {
	$retval .= COM_startBlock('error');
	$retval .= 'page does not exist';
	$retval .= COM_endBlock();
} 

echo $retval;

?>
