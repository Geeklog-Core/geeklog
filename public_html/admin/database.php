<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | database.php                                                              |
// |                                                                           |
// | Geeklog database backup administration page.                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Blaine Lang      - langmail@sympatico.ca                         |
// |          Dirk Haun        - dirk@haun-online.de                           |
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
// $Id: database.php,v 1.12 2003/06/19 17:37:37 dhaun Exp $

require_once('../lib-common.php');
require_once('auth.inc.php');

/*
This page allows all Root admins to create a database backup.  This will not
allow the removal of past backups.  It's pretty simple actually.  The admin
clicks a button, we do a mysqldump to a file in the following format:
geeklog_db_backup_YYYY_MM_DD.sql  That's it.
*/

$display = '';
$display .= COM_siteHeader();

// If user isn't a root user or if the backup feature is disabled, bail.
if (!SEC_inGroup ('Root') OR $_CONF['allow_mysqldump'] == 0) {
    $display .= COM_startBlock($MESSAGE[30], '',
                    COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[46];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    COM_errorLog("User {$_USER['username']} tried to illegally access the database backup screen",1);
    echo $display;
    exit;
}

// Perform the backup if asked

if ($mode == $LANG_DB_BACKUP['do_backup']) {
    if (is_dir ($_CONF['backup_path'])) {
        $curdatetime = date ("Y_m_d");
        $backupfile = "{$_CONF['backup_path']}geeklog_db_backup_{$curdatetime}.sql";
        $command = $_DB_mysqldump_path . " -h$_DB_host -u$_DB_user";
        if (!empty ($_DB_pass)) {
            $command .= " -p$_DB_pass";
        }
        if (!empty ($_CONF['mysqldump_options'])) {
            $command .= ' ' . $_CONF['mysqldump_options'];
        }
        $command .= " $_DB_name > {$backupfile}"; 

        if (function_exists ('is_executable')) {
            $canExec = is_executable($_DB_mysqldump_path);
        } else {
            $canExec = true;
        }
		if ($canExec) {
			exec($command);
			if (file_exists ($backupfile) && filesize ($backupfile) > 0) {
                $timestamp = strftime ($_CONF['daytime']);
                $display .= COM_startBlock ($MESSAGE[40] . ' - ' . $timestamp,
                              '', COM_getBlockTemplate ('_msg_block', 'header'))
                         . '<img src="' . $_CONF['layout_url'] . '/images/'
                         . 'sysmessage.gif" border="0" align="top" alt="">'
                         . $LANG_DB_BACKUP['backup_successful'] . '<br><br>'
                         . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
			} else {
                $display .= COM_startBlock ($LANG08[06], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
                $display .= $LANG_DB_BACKUP['zero_size'];
                $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block',
                                                                'footer'));
                COM_errorLog ("Backup Filesize was 0 bytes", 1);	
            }
		} else {
            $display .= COM_startBlock ($LANG08[06], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
            $display .= $LANG_DB_BACKUP['not_found'];
            $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block',
                                                            'footer'));
            COM_errorLog("Backup Error: Bad path or mysqldump does not exist",1);
		}
	} else {
        $display .= COM_startBlock ($MESSAGE[30], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $LANG_DB_BACKUP['path_not_found'];
        $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        COM_errorLog($_CONF['backup_path'] . " does not exist or is not a directory",1);
	}
}

// Show last ten backups

if(is_writable($_CONF['backup_path'])) {
    $backups = array();
    $display .= COM_startBlock ($LANG_DB_BACKUP['last_ten_backups'], '',
                        COM_getBlockTemplate ('_admin_block', 'header'));
    $fd = opendir($_CONF['backup_path']);
    $index = 0;
    while ((false !== ($file = @readdir ($fd)))) {
        if ($file <> '.' && $file <> '..' && $file <> 'CVS' &&
                preg_match ('/\.sql$/i', $file)) {
            $index++;
            clearstatcache();
            $backups[] = $file;
    	}
    }
    if (is_array($backups) AND $index > 0) {
        krsort($backups);
        $backups = array_slice ($backups, 0, 10);
        reset($backups);

        $database = new Template ($_CONF['path_layout'] . 'admin/database');
        $database->set_file (array ('list' => 'listbackups.thtml',
                                    'row' => 'listitem.thtml'));
        $database->set_var ('site_url', $_CONF['site_url']);
        $database->set_var ('layout_url', $_CONF['layout_url']);
        $database->set_var ('lang_backupfile', $LANG_DB_BACKUP['backup_file']);
        $database->set_var ('lang_backupsize', $LANG_DB_BACKUP['size']);
        $database->set_var ('lang_bytes', $LANG_DB_BACKUP['bytes']);

        for ($i = 1; $i <= count ($backups); $i++) {
            $backupfile = $_CONF['backup_path'] . current ($backups);
            $backupfilesize = filesize ($backupfile);
            $database->set_var ('backup_file', current ($backups));
            $database->set_var ('backup_size', $backupfilesize);
            $database->parse ('backup_item', 'row', true);
            next($backups);
        }
        $database->set_var ('number_backups',
                sprintf ($LANG_DB_BACKUP['total_number'], $index));
        $display .= $database->parse ('output', 'list');
    } else {
        $display .= '<p>' . $LANG_DB_BACKUP['no_backups'] . '</p>';
    }

	// Show backup form
    $display .= $LANG_DB_BACKUP['db_explanation'];
    $display .= '<form name="dobackup" method="POST" action="'
             . $_CONF['site_admin_url'] . '/database.php">';
    $display .= '<input type="submit" name="mode" value="'
             . $LANG_DB_BACKUP['do_backup'] . '"></form>';

    $display .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
} else {
    $display .= COM_startBlock ($LANG08[06], '',
                        COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $LANG_DB_BACKUP['no_access'];
    COM_errorLog ($_CONF['backup_path'] . ' is not accessible.', 1);
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
}
$display .= COM_siteFooter ();

echo $display; 

?>
