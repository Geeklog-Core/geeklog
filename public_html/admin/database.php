<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | database.php                                                              |
// |                                                                           |
// | Geeklog database backup and maintenance page.                             |
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

/**
* This admin panel provides some simple database backup and administration
* abilities. You can create and download database backups, optimize tables,
* or convert tables to InnoDB.
* All of these functions are currently only available for MySQL. The link to
* this admin panel is actually hidden when not using MySQL.
*/

/**
* Geeklog common function library
*/
require_once '../lib-common.php';

/**
* Security check to ensure user even belongs on this page
*/
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
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG08, $LANG_ADMIN,
           $LANG_DB_BACKUP, $_DB_dbms;

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
                                . '/database.php?mode=backup&amp;'
                                . CSRF_TOKEN . '=' . $token,
                  'text' => $LANG_ADMIN['create_new']),
        );
        if ($_DB_dbms == 'mysql') {
            $menu_arr[] =
                array('url' => $thisUrl . '?mode=optimize',
                      'text' => $LANG_DB_BACKUP['optimize_menu']);
            if (innodb_supported()) {
                $menu_arr[] =
                    array('url' => $thisUrl . '?mode=innodb',
                          'text' => $LANG_DB_BACKUP['convert_menu']);
            }
        }
        $menu_arr[] =
            array('url' => $_CONF['site_admin_url'],
                  'text' => $LANG_ADMIN['admin_home']);
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

/**
* Delete selected backup files
*
* @return   string  empty string (nothing to do), or HTML error or success msg
*
*/
function deletebackups()
{
    global $_CONF, $LANG_DB_BACKUP;

    $retval = '';
    $files = 0;
    $failed = 0;

    foreach ($_POST['delitem'] as $delfile) {
        $file = COM_sanitizeFilename($delfile, true);
        if (! empty($file)) {
            $files++;
            if (! @unlink($_CONF['backup_path'] . $file)) {
                COM_errorLog('Unable to remove backup file "' . $file . '"');
                $failed++;
            }
        }
    }

    if ($files > 0) {
        if ($failed > 0) {
            $retval .= COM_showMessageText($LANG_DB_BACKUP['delete_failure']);
        } else {
            $retval .= COM_showMessageText($LANG_DB_BACKUP['delete_success']);
        }
    }

    return $retval;
}

/**
* Create a simple form with two buttons
*
* Creates a simple form that has a Cancel and an "action" button, where
* the latter invokes a POST request with $_POST['mode'] set to the given value.
*
* @param    string  $buttontext     text string for the "action" button
* @param    string  $mode           mode value
* @param    string  $token          CSRF token, will be created if empty
* @return   string                  HTML form
*
*/
function miniform_DoOrCancel($buttontext, $mode, $token = '')
{
    global $_CONF, $LANG_ADMIN;

    $retval = '';

    if (empty($token)) {
        $token = SEC_createToken();
    }

    $retval .= '<div id="miniform"><form action="' . $_CONF['site_admin_url']
            . '/database.php" method="post" style="display:inline;">' . LB;
    $retval .= '<input type="submit" value="' . $buttontext . '"'
            . XHTML . '>' . LB;
    $retval .= '<input type="hidden" name="mode" value="' . $mode . '"'
            . XHTML . '>' . LB;
    $retval .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="'
            . $token . '"' . XHTML . '>' . LB;
    $retval .= '</form>' . LB;
    $retval .= '<form action="' . $_CONF['site_admin_url']
            . '/database.php" method="post" style="display:inline;">' . LB;
    $retval .= '<input type="submit" value="' . $LANG_ADMIN['cancel'] . '"'
            . XHTML . '>' . LB;
    $retval .= '</form></div>' . LB;

    return $retval;
}

/**
* Check for InnoDB table support (usually as of MySQL 4.0, but may be
* available in earlier versions, e.g. "Max" or custom builds).
*
* @return   true = InnoDB tables supported, false = not supported
*
*/
function innodb_supported()
{
    global $_DB_dbms;

    $retval = false;

    if ($_DB_dbms == 'mysql') {
        $result = DB_query("SHOW TABLE TYPES");
        $numEngines = DB_numRows($result);
        for ($i = 0; $i < $numEngines; $i++) {
            $A = DB_fetchArray($result);

            if (strcasecmp($A['Engine'], 'InnoDB') == 0) {
                if (strcasecmp($A['Support'], 'yes') == 0) {
                    $retval = true;
                }
                break;
            }
        }
    }

    return $retval;
}

/**
* Check if all the tables have already been converted to InnoDB
*
* @return   bool    true: all tables are InnoDB, otherwise false
*
*/
function already_converted()
{
    global $_CONF, $_TABLES, $_DB_name;

    $retval = false;

    $engine = DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'");
    if (!empty($engine) && ($engine == 'InnoDB')) {
        // need to look at all the tables
        $result = DB_query("SHOW TABLES");
        $numTables = DB_numRows($result);
        for ($i = 0; $i < $numTables; $i++) {
            $A = DB_fetchArray($result, true);
            $table = $A[0];
            if (in_array($table, $_TABLES)) {
                $result2 = DB_query("SHOW TABLE STATUS FROM $_DB_name LIKE '$table'");
                $B = DB_fetchArray($result2);
                if (strcasecmp($B['Engine'], 'InnoDB') != 0) {
                    break; // found a non-InnoDB table
                }
            }
        }
        if ($i == $numTables) {
            // okay, all the tables are InnoDB already
            $retval = true;
        }
    }

    return $retval;
}

/**
* Prepare for conversion to InnoDB tables
*
* @return   string  HTML form
*
*/
function innodb()
{
    global $_CONF, $LANG_ADMIN, $LANG_DB_BACKUP;

    $retval = '';

    $retval .= COM_startBlock($LANG_DB_BACKUP['convert_title']);
    $retval .= '<p>' . $LANG_DB_BACKUP['innodb_explain'] . '</p>' . LB;

    if (already_converted()) {
        $retval .= '<p>' . $LANG_DB_BACKUP['already_converted'] . '</p>' . LB;
    } else {
        $retval .= '<p>' . $LANG_DB_BACKUP['conversion_patience'] . '</p>' . LB;
    }

    $retval .= miniform_DoOrCancel($LANG_DB_BACKUP['convert_button'],
                                   'doinnodb');
    $retval .= COM_endBlock();
    // Note: COM_siteFooter is added in MAIN

    return $retval;
}

/**
* Convert to InnoDB tables
*
* @param    string  $startwith  table to start with
* @param    int     $failures   number of previous errors
* @return   int                 number of errors during conversion
*
*/
function doinnodb($startwith = '', $failures = 0)
{
    global $_CONF, $_TABLES, $_DB_name;

    $retval = '';
    $start = time();

    DB_displayError(true);

    $maxtime = @ini_get('max_execution_time');
    if (empty($maxtime)) {
        // unlimited or not allowed to query - assume 30 second default
        $maxtime = 30;
    }
    $maxtime -= 5; // give us some leeway

    $token = ''; // SEC_createToken();

    $result = DB_query("SHOW TABLES");
    $numTables = DB_numRows($result);
    for ($i = 0; $i < $numTables; $i++) {
        $A = DB_fetchArray($result, true);
        $table = $A[0];
        if (in_array($table, $_TABLES)) {
            if (! empty($startwith)) {
                if ($table == $startwith) {
                    $startwith = '';
                } else {
                    continue; // already handled - skip
                }
            }

            $result2 = DB_query("SHOW TABLE STATUS FROM $_DB_name LIKE '$table'");
            $B = DB_fetchArray($result2);
            if (strcasecmp($B['Engine'], 'InnoDB') == 0) {
                continue; // already converted - skip
            }

            if (time() > $start + $maxtime) {
                // this is taking too long - kick off another request
                $startwith = $table;
                $url = $_CONF['site_admin_url'] . '/database.php?mode=doinnodb';
                if (! empty($token)) {
                    $token = '&' . CSRF_TOKEN . '=' . $token;
                }
                header("Location: $url&startwith=$startwith&failures=$failures"
                                  . $token);
                exit;
            }

            $make_innodb = DB_query("ALTER TABLE $table ENGINE=InnoDB", 1);
            if ($make_innodb === false) {
                $failures++;
                COM_errorLog('SQL error for table "' . $table . '" (ignored): '
                             . DB_error());
            }
        }
    }

    DB_delete($_TABLES['vars'], 'name', 'database_engine');
    DB_query("INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('database_engine', 'InnoDB')");

    return $failures;
}

/**
* Prepare for optimizing tables
*
* @return   string  HTML form
*
*/
function optimize()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG_DB_BACKUP;

    $retval = '';

    $lastrun = DB_getItem($_TABLES['vars'], 'UNIX_TIMESTAMP(value)',
                          "name = 'lastoptimizeddb'");

    $retval .= COM_siteHeader('menu', $LANG_DB_BACKUP['optimize_title']);
    $retval .= COM_startBlock($LANG_DB_BACKUP['optimize_title']);
    $retval .= '<p>' . $LANG_DB_BACKUP['optimize_explain'] . '</p>' . LB;
    if (!empty($lastrun)) {
        $last = COM_getUserDateTimeFormat($lastrun);
        $retval .= '<p>' . $LANG_DB_BACKUP['last_optimization'] . ': '
                . $last[0] . '</p>' . LB;
    }
    $retval .= '<p>' . $LANG_DB_BACKUP['optimization_patience'] . '</p>' . LB;

    $retval .= miniform_DoOrCancel($LANG_DB_BACKUP['optimize_button'],
                                   'dooptimize');
    $retval .= COM_endBlock();
    // Note: COM_siteFooter is added in MAIN

    return $retval;
}

/**
* Optimize database tables
*
* @param    string  $startwith  table to start with
* @param    int     $failures   number of previous errors
* @return   int                 number of errors during conversion
*
*/
function dooptimize($startwith = '', $failures = 0)
{
    global $_CONF, $_TABLES;

    $retval = '';
    $start = time();

    $lasttable = DB_getItem($_TABLES['vars'], 'value',
                            "name = 'lastoptimizedtable'");
    if (empty($startwith) && !empty($lasttable)) {
        $startwith = $lasttable;
    }

    $maxtime = @ini_get('max_execution_time');
    if (empty($maxtime)) {
        // unlimited or not allowed to query - assume 30 second default
        $maxtime = 30;
    }
    $maxtime -= 5; // give us some leeway

    DB_displayError(true);

    $token = ''; // SEC_createToken();

    $result = DB_query("SHOW TABLES");
    $numTables = DB_numRows($result);
    for ($i = 0; $i < $numTables; $i++) {
        $A = DB_fetchArray($result, true);
        $table = $A[0];
        if (in_array($table, $_TABLES)) {
            if (! empty($startwith)) {
                if ($table == $startwith) {
                    $startwith = '';
                } else {
                    continue; // already handled - skip
                }
                if (!empty($lasttable) && ($lasttable == $table)) {
                    continue; // skip
                }
            }

            if (time() > $start + $maxtime) {
                // this is taking too long - kick off another request
                $startwith = $table;
                $url = $_CONF['site_admin_url']
                     . '/database.php?mode=dooptimize';
                if (! empty($token)) {
                    $token = '&' . CSRF_TOKEN . '=' . $token;
                }
                header("Location: $url&startwith=$startwith&failures=$failures"
                                  . $token);
                exit;
            }

            if (empty($lasttable)) {
                DB_query("INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastoptimizedtable', '$table')");
                $lasttable = $table;
            } else {
                DB_query("UPDATE {$_TABLES['vars']} SET value = '$table' WHERE name = 'lastoptimizedtable'");
            }
            $optimize = DB_query("OPTIMIZE TABLE $table", 1);
            if ($optimize === false) {
                $failures++;
                COM_errorLog('SQL error for table "' . $table . '" (ignored): '
                             . DB_error());

                $startwith = $table;
                $url = $_CONF['site_admin_url']
                     . '/database.php?mode=dooptimize';
                if (! empty($token)) {
                    $token = '&' . CSRF_TOKEN . '=' . $token;
                }
                header("Location: $url&startwith=$startwith&failures=$failures"
                                  . $token);
                exit;
            }
        }
    }

    DB_delete($_TABLES['vars'], 'name', 'lastoptimizedtable');
    DB_delete($_TABLES['vars'], 'name', 'lastoptimizeddb');
    DB_query("INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastoptimizeddb', FROM_UNIXTIME(" . time() . "))");

    return $failures;
}


// MAIN
$display = '';

$mode = '';
if (isset($_POST['mode'])) {
    $mode = COM_applyFilter($_POST['mode']);
    if ($mode == 'delete') {
        if (! isset($_POST['delitem'])) {
            $mode = '';
        }
    }
} elseif (isset($_GET['mode'])) {
    $mode = COM_applyFilter($_GET['mode']);
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

$list_backups = true;

switch ($mode) {
case 'backup':
    $display .= COM_siteHeader('menu', $LANG_DB_BACKUP['new_backup']);
    if (SEC_checkToken()) {
        $display .= dobackup();
    }
    break;

case 'delete':
    $display .= COM_siteHeader('menu', $LANG_DB_BACKUP['last_ten_backups']);
    if (SEC_checkToken()) {
        $display .= deletebackups();
    }
    break;

case 'optimize':
    $display .= optimize();
    $list_backups = false;
    break;

case 'dooptimize':
    $startwith = '';
    if (isset($_GET['startwith'])) {
        $startwith = COM_applyFilter($_GET['startwith']);
    }
    if (!empty($startwith) || SEC_checkToken()) {
        $failures = 0;
        if (isset($_GET['failures'])) {
            $failures = COM_applyFilter($_GET['failures'], true);
        }
        $num_errors = dooptimize($startwith, $failures);
        $display .= COM_siteHeader('menu', $LANG_DB_BACKUP['optimize_title']);
        if ($num_errors == 0) {
            $display .= COM_showMessageText($LANG_DB_BACKUP['optimize_success']);
        } else {
            $display .= COM_showMessageText($LANG_DB_BACKUP['optimize_success']
                            . ' ' . $LANG_DB_BACKUP['table_issues']);
        }
    } else {
        $display .= COM_siteHeader('menu', $LANG_DB_BACKUP['optimize_title']);
    }
    break;

case 'innodb':
    $display .= COM_siteHeader('menu', $LANG_DB_BACKUP['convert_title']);
    if (innodb_supported()) {
        $display .= innodb();
        $list_backups = false;
    } else {
        $display .= COM_showMessageText($LANG_DB_BACKUP['sorry_no_innodb']);
    }
    break;

case 'doinnodb':
    $display .= COM_siteHeader('menu', $LANG_DB_BACKUP['convert_title']);
    if (innodb_supported()) {
        $startwith = '';
        if (isset($_GET['startwith'])) {
            $startwith = COM_applyFilter($_GET['startwith']);
        }
        if (!empty($startwith) || SEC_checkToken()) {
            $failures = 0;
            if (isset($_GET['failures'])) {
                $failures = COM_applyFilter($_GET['failures'], true);
            }
            $num_errors = doinnodb($startwith, $failures);
            if ($num_errors == 0) {
                $display .= COM_showMessageText($LANG_DB_BACKUP['innodb_success']);
            } else {
                $display .= COM_showMessageText($LANG_DB_BACKUP['innodb_success'] . ' ' . $LANG_DB_BACKUP['table_issues']);
            }
        }
    } else {
        $display .= COM_showMessageText($LANG_DB_BACKUP['sorry_no_innodb']);
    }
    break;

default:
    $display .= COM_siteHeader('menu', $LANG_DB_BACKUP['last_ten_backups']);
    $display .= COM_showMessageFromParameter();
    break;
}

// Show all backups
if ($list_backups) {
    $display .= listbackups();
}

$display .= COM_siteFooter();

COM_output($display);

?>
