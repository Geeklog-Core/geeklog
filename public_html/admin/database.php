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
// $Id: database.php,v 1.1 2002/02/25 23:21:33 tony_bibbs Exp $

include('../lib-common.php');
include('auth.inc.php');

/*
This page allows all Root admins to create a database backup.  This will not
allow the removal of past backups.  It's pretty simple actually.  The admin
clicks a button, we do a mysqldump to a file in the following format:
geeklog_back_MMDDYYYY.sql  That's it.
*/

$display = '';
$display .= COM_siteHeader();

// If user isn't a root user or if the backup feature is disable, bail.
if (!SEC_inGroup('Root') OR $_CONF['allow_mysqldump'] == 0) {
    $display .= COM_startBlock($MESSAGE[30]);
    $display .= $MESSAGE[46];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    COM_errorLog("User {$_USER['username']} tried to illegally access the databasek backup screen",1);
    echo $display;
    exit;
}

// Perform the backup if asked
if ($mode == 'Do Backup') {
    $curdatetime = date("m_d_Y");
    if (!empty($_DB_pass)) {
        $command = $_DB_mysqldump_path . " -h$_DB_host -u$_DB_user -p$_DB_pass $_DB_name > {$_CONF['backup_path']}geeklog_db_backup_$curdatetime.sql"; 
    } else {
        $command = $_DB_mysqldump_path . " -h$_DB_host -u$_DB_user $_DB_name > {$_CONF['backup_path']}geeklog_db_backup_$curdatetime.sql"; 
    }
    $display .= "command = $command <br>";
    exec($command);
    $display .= '<font color="red">Database back up was successful</font><br>';
}

// Show last ten backups
$display .= COM_startBlock($LANG_DB_BACKUP['last_ten_backups']);
$backups = array();
$fd = opendir($_CONF['backup_path']);
$index = 0;
while (($file = @readdir($fd)) == TRUE AND ($index <= 10)) {
    if ($file <> '.' && $file <> '..' && $file <> 'CVS') {
        $index++;
        clearstatcache();
        $akey = fileatime($_CONF['backup_path'] . $file);
        $backups[$akey] = $file;
    }
} 
if (is_array($backups) AND $index > 0) {
    krsort($backups);
    reset($backups);
    for ($i = 1; $i <= count($backups); $i++) {
        $display .= current($backups) . '<br>';
        next($backups);
    }
} else {
   $display .= "No backups in the system";
}
$display .= COM_endBlock();

// Show backup form
$display .= "To create a new backup of your Geeklog system, hit the button below";
$display .= '<form name="dobackup" method="post" action="' . $PHP_SELF . '">';
$display .= '<input type="submit" name="mode" value="Do Backup"></form>';
$display .= COM_siteFooter();

echo $display; 
    
?>
