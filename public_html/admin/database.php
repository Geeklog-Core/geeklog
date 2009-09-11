<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | database.php                                                              |
// |                                                                           |
// | Geeklog database backup administration page.                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
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

require_once '../lib-common.php';
require_once 'auth.inc.php';

$display = '';

// If user isn't a Root user or if the backup feature is disabled, bail.
if (!SEC_inGroup('Root') OR ($_CONF['allow_mysqldump'] == 0)) {
    $display .= COM_siteHeader('menu', $LANG_DB_BACKUP['last_ten_backups'])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the database backup screen.");
    COM_output($display);
    exit;
}

/**
* This page allows all Root admins to create a database backup.  It's pretty
* simple actually.  The admin clicks a button, we do a mysqldump to a file in
* the following format: geeklog_db_backup_YYYY_MM_DD_hh_mm_ss.sql  That's it.
*/

/**
* Sort backup files with newest first, oldest last.
* For use with usort() function.
* This is needed because the sort order of the backup files, coming from the
* 'readdir' function, might not be that way.
*/
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

/**
* List all backups, i.e. all files ending in .sql
*
* @return   string      HTML for the list of files or an error when not writable
*
*/
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

        $data_arr = array();
        $thisUrl = $_CONF['site_admin_url'] . '/database.php';
        $num_backups = count($backups);
        for ($i = 0; $i < $num_backups; $i++) {
            $downloadUrl = $thisUrl . '?mode=download&amp;file='
                         . urlencode($backups[$i]);
            $downloadLink = COM_createLink($backups[$i], $downloadUrl,
                    array('title' => $LANG_DB_BACKUP['download']));
            $backupfile = $_CONF['backup_path'] . $backups[$i];
            $backupfilesize = COM_numberFormat(filesize($backupfile))
                            . ' <b>' . $LANG_DB_BACKUP['bytes'] . '</b>';
            $data_arr[$i] = array('file' => $downloadLink,
                                  'size' => $backupfilesize,
                                  'filename' => $backups[$i]);
        }

        $token = SEC_createToken();
        $menu_arr = array(
            array('url' => $_CONF['site_admin_url']
                           . '/database.php?mode=backup&'.CSRF_TOKEN.'='.$token,
                  'text' => $LANG_ADMIN['create_new']),
            array('url' => $_CONF['site_admin_url'],
                  'text' => $LANG_ADMIN['admin_home'])
        );
        $retval .= COM_startBlock($LANG_DB_BACKUP['last_ten_backups'], '',
                            COM_getBlockTemplate('_admin_block', 'header'));
        $retval .= ADMIN_createMenu(
            $menu_arr,
            "<p>{$LANG_DB_BACKUP['db_explanation']}</p>" .
            '<p>' . sprintf($LANG_DB_BACKUP['total_number'], $index) . '</p>',
            $_CONF['layout_url'] . '/images/icons/database.' . $_IMAGE_TYPE
        );

        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_DB_BACKUP['backup_file'], 'field' => 'file'),
            array('text' => $LANG_DB_BACKUP['size'],        'field' => 'size')
        );

        $text_arr = array(
            'form_url' => $thisUrl
        );
        $form_arr = array('bottom' => '', 'top' => '');
        if ($num_backups > 0) {
            $form_arr['bottom'] = '<input type="hidden" name="mode" value="delete"' . XHTML . '>'
                                . '<input type="hidden" name="' . CSRF_TOKEN
                                . '" value="' . $token . '"' . XHTML . '>' . LB;
        }
        $listoptions = array('chkdelete' => true, 'chkminimum' => 0,
                             'chkfield' => 'filename');
        $retval .= ADMIN_simpleList('', $header_arr, $text_arr, $data_arr,
                                    $listoptions, $form_arr);
        $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
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
* Perform database backup
*
* @return   string      HTML success or error message
*
*/
function dobackup()
{
    global $_CONF, $LANG08, $LANG_DB_BACKUP, $MESSAGE, $_IMAGE_TYPE,
           $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_mysqldump_path;

    $retval = '';

    if (is_dir($_CONF['backup_path'])) {
        if (!empty($_CONF['mysqldump_filename_mask'])) {
            $filename_mask = strftime($_CONF['mysqldump_filename_mask']);
        } else {
            $curdatetime = date('Y_m_d_H_i_s');
            $filename_mask = "geeklog_db_backup_{$curdatetime}.sql";
        }
        $backupfile = $_CONF['backup_path'] . $filename_mask;
        $command = $_DB_mysqldump_path . " -h$_DB_host -u$_DB_user";
        if (!empty($_DB_pass)) {
            $command .= " -p$_DB_pass";
        }
        if (!empty($_CONF['mysqldump_options'])) {
            $command .= ' ' . $_CONF['mysqldump_options'];
        }
        $command .= " $_DB_name > \"$backupfile\"";

        $log_command = $command;
        if (!empty($_DB_pass)) {
            $log_command = str_replace(" -p$_DB_pass", ' -p*****', $command);
        }

        if (function_exists('is_executable')) {
            $canExec = @is_executable($_DB_mysqldump_path);
        } else {
            $canExec = @file_exists($_DB_mysqldump_path);
        }
        if ($canExec) {
            exec($command);
            if (file_exists($backupfile) && filesize($backupfile) > 1000) {
                @chmod($backupfile, 0644);
                $retval .= COM_showMessage(93);
            } else {
                $retval .= COM_showMessage(94);
                COM_errorLog('Backup Filesize was less than 1kb', 1);
                COM_errorLog("Command used for mysqldump: $log_command", 1);
            }
        } else {
            $retval .= COM_startBlock($LANG08[06], '',
                                COM_getBlockTemplate('_msg_block', 'header'));
            $retval .= $LANG_DB_BACKUP['not_found'];
            $retval .= COM_endBlock(COM_getBlockTemplate('_msg_block',
                                                         'footer'));
            COM_errorLog('Backup Error: Bad path, mysqldump does not exist or open_basedir restriction in effect.', 1);
            COM_errorLog("Command used for mysqldump: $log_command", 1);
        }
    } else {
        $retval .= COM_startBlock($MESSAGE[30], '',
                            COM_getBlockTemplate('_msg_block', 'header'));
        $retval .= $LANG_DB_BACKUP['path_not_found'];
        $retval .= COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
        COM_errorLog("Backup directory '" . $_CONF['backup_path'] . "' does not exist or is not a directory", 1);
    }

    return $retval;
}

/**
* Download a backup file
*
* NOTE:     Filename should have been sanitized and checked before calling this.
*
* @param    string  $file   Filename (without the path)
* @return   void
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

$mode = '';
if (isset($_GET['mode'])) {
    if ($_GET['mode'] == 'backup') {
        $mode = 'backup';
    } else if ($_GET['mode'] == 'download') {
        $mode = 'download';
    }
} else if (isset($_POST['mode'])) {
    if (($_POST['mode'] == 'delete') && isset($_POST['delitem'])) {
        $mode = 'delete';
    }
}

if ($mode == 'download') {
    $file = '';
    if (isset($_GET['file'])) {
        $file = COM_sanitizeFilename($_GET['file'], true);
        if (! file_exists($_CONF['backup_path'] . $file)) {
            $file = '';
        }
    }
    if (!empty($file)) {
        downloadbackup($file);
        exit;
    }
}

$display .= COM_siteHeader('menu', $LANG_DB_BACKUP['last_ten_backups']);

if ($mode == 'backup') {
    // Perform the backup if asked
    if (SEC_checkToken()) {
        $display .= dobackup();
    }
} elseif ($mode == 'delete') {
    if (SEC_checkToken()) {
        foreach ($_POST['delitem'] as $delfile) {
            $file = COM_sanitizeFilename($delfile, true);
            if (! empty($file)) {
                if (!@unlink($_CONF['backup_path'] . $file)) {
                    COM_errorLog('Unable to remove backup file "' . $file . '"');
                }
            }
        }
    }
} else {
    $display .= COM_showMessageFromParameter();
}

// Show all backups

$display .= listbackups();

$display .= COM_siteFooter();

COM_output($display);

?>
