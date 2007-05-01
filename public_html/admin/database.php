<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | database.php                                                              |
// |                                                                           |
// | Geeklog database backup administration page.                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                   |
// |          Blaine Lang        - langmail AT sympatico DOT ca                |
// |          Dirk Haun          - dirk AT haun-online DOT de                  |
// |          Alexander Schmacks - Alexander.Schmacks AT gmx DOT de            |
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
// $Id: database.php,v 1.35 2007/05/01 17:32:57 dhaun Exp $

require_once '../lib-common.php';
require_once 'auth.inc.php';

/*
This page allows all Root admins to create a database backup.  This will not
allow the removal of past backups.  It's pretty simple actually.  The admin
clicks a button, we do a mysqldump to a file in the following format:
geeklog_db_backup_YYYY_MM_DD.sql  That's it.
*/

/**
* Sort backup files with newest first, oldest last.
* For use with usort() function.
* This is needed because the sort order of the backup files, coming from the
* 'readdir' function, might not be that way.
**/
function compareBackupFiles($pFileA, $pFileB)
{
    global $_CONF;

    $lFiletimeA = filemtime($_CONF['backup_path'] . $pFileA);
    $lFiletimeB = filemtime($_CONF['backup_path'] . $pFileB);
    if ($lFiletimeA == $lFiletimeB) {
       return 0;
    }

    return ($lFiletimeA > $lFiletimeB) ? -1 : 1;
}

function listbackups()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG08, $LANG_ADMIN, $LANG_DB_BACKUP;
    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    if (is_writable($_CONF['backup_path'])) {
        $backups = array();
        $fd = opendir($_CONF['backup_path']);
        $index = 0;
        while ((false !== ($file = @readdir($fd)))) {
            if ($file <> '.' && $file <> '..' && $file <> 'CVS' &&
                    preg_match('/\.sql$/i', $file)) {
                $index++;
                clearstatcache();
                $backups[] = $file;
            }
        }
        // AS, 2004-03-29 - Sort backup files by date, newest first.
        // Order given by 'readdir' might not be correct.
        usort($backups, 'compareBackupFiles');
        $backups = array_slice($backups, 0, 10);
        reset($backups);

        $data_arr = array();
        for ($i = 0; $i < count($backups); $i++) {
            $thisUrl = $_CONF['site_admin_url'] . '/database.php';
            $downloadUrl = $thisUrl . '?mode=download&amp;file='
                         . urlencode($backups[$i]);
            $downloadLink = COM_createLink($backups[$i], $downloadUrl,
                    array('title' => $LANG_DB_BACKUP['download']));
            $backupfile = $_CONF['backup_path'] . $backups[$i];
            $backupfilesize = COM_numberFormat(filesize($backupfile))
                            . ' <b>' . $LANG_DB_BACKUP['bytes'] . '</b>';
            $data_arr[$i] = array('file' => $downloadLink,
                                  'size' => $backupfilesize);
        }

        $menu_arr = array(
                        array('url' => $_CONF['site_admin_url']
                                       . '/database.php?mode=' . $LANG_DB_BACKUP['do_backup'],
                              'text' => $LANG_ADMIN['create_new']),
                        array('url' => $_CONF['site_admin_url'],
                              'text' => $LANG_ADMIN['admin_home'])
        );

        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_DB_BACKUP['backup_file'], 'field' => 'file'),
            array('text' => $LANG_DB_BACKUP['size'],        'field' => 'size')
        );

        $text_arr = array('has_menu' => true,
                          'instructions' => $LANG_DB_BACKUP['db_explanation']
                                            . "<br>" . sprintf($LANG_DB_BACKUP['total_number'], $index),
                          'icon' => $_CONF['layout_url'] . '/images/icons/database.' . $_IMAGE_TYPE,
                          'title' => $LANG_DB_BACKUP['last_ten_backups']
        );
        $retval .= ADMIN_simpleList('', $header_arr, $text_arr, $data_arr, $menu_arr);
    } else {
        $retval .= COM_startBlock($LANG08[06], '',
                            COM_getBlockTemplate('_msg_block', 'header'));
        $retval .= $LANG_DB_BACKUP['no_access'];
        COM_errorLog($_CONF['backup_path'] . ' is not writable.', 1);
        $retval .= COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
    }

    return $retval;
}

/**
* Download a backup file
*
* @param    string  $file   Filename (without the path)
* @return   void
* @note     Filename should have been sanitized and checked before calling this.
*
*/
function downloadbackup($file)
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/downloader.class.php';

    $dl = new downloader;

    $dl->setLogFile($_CONF['path'] . 'logs/error.log');
    $dl->setLogging(true);
    $dl->setDebug(true);

    $dl->setPath($_CONF['backup_path']);
    $dl->setAllowedExtensions(array('sql' =>  'application/x-gzip-compressed'));

    $dl->downloadFile($file);
}


// MAIN
$display = '';
$display .= COM_siteHeader('menu', $LANG_DB_BACKUP['last_ten_backups']);

// If user isn't a root user or if the backup feature is disabled, bail.
if (!SEC_inGroup('Root') OR $_CONF['allow_mysqldump'] == 0) {
    $display .= COM_startBlock($MESSAGE[30], '',
                    COM_getBlockTemplate('_msg_block', 'header'));
    $display .= $MESSAGE[46];
    $display .= COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
    $display .= COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the database backup screen.");
    echo $display;
    exit;
}

$mode = '';
if (isset($_GET['mode'])) {
    if ($_GET['mode'] == $LANG_DB_BACKUP['do_backup']) {
        $mode = 'backup';
    } else if ($_GET['mode'] == 'download') {
        $mode = 'download';
    }
}

// Perform the backup if asked
if ($mode == 'backup') {
    if (is_dir($_CONF['backup_path'])) {
        $curdatetime = date('Y_m_d_H_i_s');
        $backupfile = "{$_CONF['backup_path']}geeklog_db_backup_{$curdatetime}.sql";
        $command = $_DB_mysqldump_path . " -h$_DB_host -u$_DB_user";
        if (!empty($_DB_pass)) {
            $command .= " -p$_DB_pass";
        }
        if (!empty($_CONF['mysqldump_options'])) {
            $command .= ' ' . $_CONF['mysqldump_options'];
        }
        $command .= " $_DB_name > \"$backupfile\"";

        if (function_exists('is_executable')) {
            $canExec = is_executable($_DB_mysqldump_path);
        } else {
            $canExec = file_exists($_DB_mysqldump_path);
        }
        if ($canExec) {
            exec($command);
            if (file_exists($backupfile) && filesize($backupfile) > 0) {
                @chmod($backupfile, 0644);
                $timestamp = strftime($_CONF['daytime']);
                $display .= COM_startBlock($MESSAGE[40] . ' - ' . $timestamp,
                              '', COM_getBlockTemplate('_msg_block', 'header'))
                         . '<img src="' . $_CONF['layout_url'] . '/images/'
                         . 'sysmessage.' . $_IMAGE_TYPE
                         . '" align="top" alt="">'
                         . $LANG_DB_BACKUP['backup_successful'] . '<br><br>'
                         . COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
            } else {
                $display .= COM_startBlock($LANG08[06], '',
                                COM_getBlockTemplate('_msg_block', 'header'));
                $display .= $LANG_DB_BACKUP['zero_size'];
                $display .= COM_endBlock(COM_getBlockTemplate('_msg_block',
                                                              'footer'));
                COM_errorLog('Backup Filesize was 0 bytes', 1);
                COM_errorLog("Command used for mysqldump: $command", 1);
            }
        } else {
            $display .= COM_startBlock($LANG08[06], '',
                                COM_getBlockTemplate('_msg_block', 'header'));
            $display .= $LANG_DB_BACKUP['not_found'];
            $display .= COM_endBlock(COM_getBlockTemplate('_msg_block',
                                                          'footer'));
            COM_errorLog('Backup Error: Bad path or mysqldump does not exist', 1);
            COM_errorLog("Command used for mysqldump: $command", 1);
        }
    } else {
        $display .= COM_startBlock($MESSAGE[30], '',
                            COM_getBlockTemplate('_msg_block', 'header'));
        $display .= $LANG_DB_BACKUP['path_not_found'];
        $display .= COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
        COM_errorLog("Backup directory '" . $_CONF['backup_path'] . "' does not exist or is not a directory", 1);
    }
} else if ($mode == 'download') {
    $file = '';
    if (isset($_GET['file'])) {
        $file = preg_replace('/[^a-zA-Z0-9\-_\.]/', '', $_GET['file']);
        $file = str_replace('..', '', $file);
        if (!file_exists($_CONF['backup_path'] . $file)) {
            $file = '';
        }
    }
    if (!empty($file)) {
        downloadbackup($file);
        exit;
    }
}

// Show last ten backups

$display .= listbackups();

$display .= COM_siteFooter();

echo $display;

?>
