<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | database.php                                                              |
// | Geeklog database administration page.                                     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Blaine Lang      - langmail@sympatico.ca                         |
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
// $Id: database.php,v 1.6 2002/07/29 13:49:03 dhaun Exp $

include('../lib-common.php');
include('auth.inc.php');

/*
This page allows all Root admins to create a database backup.  This will not
allow the removal of past backups.  It's pretty simple actually.  The admin
clicks a button, we do a mysqldump to a file in the following format:
geeklog_db_backup_YYYY_MM_DD.sql  That's it.
*/

$display = '';
$display .= COM_siteHeader();

// If user isn't a root user or if the backup feature is disable, bail.
if (!SEC_inGroup('Root') OR $_CONF['allow_mysqldump'] == 0) {
    $display .= COM_startBlock($MESSAGE[30]);
    $display .= $MESSAGE[46];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    COM_errorLog("User {$_USER['username']} tried to illegally access the database backup screen",1);
    echo $display;
    exit;
}

// Perform the backup if asked

if ($mode == $LANG_DB_BACKUP['do_backup']) {
    if(is_dir($_CONF['backup_path'])) {
		$curdatetime = date("Y_m_d");
		$backupfile = "{$_CONF['backup_path']}geeklog_db_backup_{$curdatetime}.sql";
	    if (!empty($_DB_pass)) {
	        $command = $_DB_mysqldump_path . " -h$_DB_host -u$_DB_user -p$_DB_pass $_DB_name > {$backupfile}"; 
	    } else {
	        $command = $_DB_mysqldump_path . " -h$_DB_host -u$_DB_user $_DB_name > {$backupfile}"; 
	    }
		if (is_executable($_DB_mysqldump_path)) {
			exec($command);
			if(file_exists($backupfile) && filesize($backupfile) > 0) {
				$display .= '<font color="red">' . $LANG_DB_BACKUP['backup_successful'] . '</font><br>';
			} else {
				$display .= COM_startBlock($LANG08[06]);
				$display .= $LANG_DB_BACKUP['zero_size'];
		    	$display .= COM_endBlock();
		    	$display .= COM_siteFooter();
				COM_errorLog("Backup Filesize was 0 bytes",1);	
	    	}
		} else {
			$display .= COM_startBlock($LANG08[06]);
			$display .= $LANG_DB_BACKUP['not_found'];
		    $display .= COM_endBlock();
    		$display .= COM_siteFooter();
			COM_errorLog("Backup Error: Bad path or mysqldump does not exist",1);
		}
	} else {
		$display .= COM_startBlock($MESSAGE[30]);
    	$display .= $LANG_DB_BACKUP['path_not_found'];
	    $display .= COM_endBlock();
    	$display .= COM_siteFooter();
		COM_errorLog($_CONF['backup_path'] . " does not exist or is not a directory",1);
	}
}

// Show last ten backups

if(is_writable($_CONF['backup_path'])) {
	$backups = array();
	$display .= COM_startBlock($LANG_DB_BACKUP['last_ten_backups']);
	$fd = opendir($_CONF['backup_path']);
	$index = 0;
	while ((false !== ($file = @readdir ($fd))) && ($index < 10)) {
	    if ($file <> '.' && $file <> '..' && $file <> 'CVS') {
	        $index++;
	        clearstatcache();
            $backups[] = $file;
    	}
	}
	if (is_array($backups) AND $index > 0) {
	    krsort($backups);
	    reset($backups);
        $display .= '<table width="100%" border="0">' . LB;
        $display .= '<tr><td><b>' . $LANG_DB_BACKUP['backup_file'] . '</b></td><td align="right"><b>' . $LANG_DB_BACKUP['size'] . '</b></td></tr>';
	    for ($i = 1; $i <= count($backups); $i++) {
			$backupfile = "{$_CONF['backup_path']}" .current($backups);
			$backupfilesize = filesize($backupfile);
	        $display .= '<tr><td>' . current($backups) . '</td><td align="right">' . $backupfilesize . ' <b>' . $LANG_DB_BACKUP['bytes'] . '</b></td></tr>' . LB;
	        next($backups);
	    }
        $display .= '</table>' . LB;
	} else {
	   $display .= $LANG_DB_BACKUP['no_backups'];
	}
	$display .= COM_endBlock();
	// Show backup form
	$display .= $LANG_DB_BACKUP['db_explanation'];
	$display .= '<form name="dobackup" method="post" action="' . $PHP_SELF . '">';
	$display .= '<input type="submit" name="mode" value="' . $LANG_DB_BACKUP['do_backup'] . '"></form>';
	$display .= COM_siteFooter();
} else {
	$display .= COM_startBlock($LANG08[06]);
	$display .= $LANG_DB_BACKUP['no_access'];
	COM_errorLog($_CONF['backup_path'] . " is not accessible.",1);
	$display .= COM_endBlock();
	$display .= COM_siteFooter();
}
echo $display; 
    
?>
