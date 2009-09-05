<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | migrate.php                                                               |
// |                                                                           |
// | Install Geeklog from a backup.                                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Matt West - matt AT mattdanger DOT net                           |
// |          Dirk Haun - dirk AT haun-online DOT de                           |
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

require_once 'lib-install.php';
require_once '../../siteconfig.php';


/**
* Fix site_url in content
*
* If the site's URL changed due to the migration, this function will replace
* the old URL with the new one in text content of the given tables.
*
* @param    string  $old_url    the site's previous URL
* @param    string  $new_url    the site's new URL after the migration
* @param    array   $tablespec  (optional) list of tables to patch
*
* The $tablespec is an array of tablename => fieldlist pairs, where the field
* list contains the text fields to be searched and the table's index field
* as the first(!) entry.
*
* NOTE: This function may be used by plugins during PLG_migrate. Changes should
*       ensure backward compatibility.
*
*/
function INST_updateSiteUrl($old_url, $new_url, $tablespec = '')
{
    global $_TABLES;

    // standard tables to update if no $tablespec given
    $tables = array(
        'stories'           => 'sid, introtext, bodytext, related',
        'storysubmission'   => 'sid, introtext, bodytext',
        'comments'          => 'cid, comment',
        'trackback'         => 'cid, excerpt, url',
        'blocks'            => 'bid, content'
    );

    if (empty($tablespec) || (! is_array($tablespec))) {
        $tablespec = $tables;
    }

    if (empty($old_url) || empty($new_url)) {
        return;
    }

    if ($old_url == $new_url) {
        return;
    }

    foreach ($tablespec as $table => $fieldlist) {
        $fields = explode(',', str_replace(' ', '', $fieldlist));
        $index = array_shift($fields);

        $result = DB_query("SELECT $fieldlist FROM {$_TABLES[$table]}");
        $numRows = DB_numRows($result);
        for ($i = 0; $i < $numRows; $i++) {
            $A = DB_fetchArray($result);
            $changed = false;
            foreach ($fields as $field) {
                $newtxt = str_replace($old_url, $new_url, $A[$field]);
                if ($newtxt != $A[$field]) {
                    $A[$field] = $newtxt;
                    $changed = true;
                }
            }

            if ($changed) {
                $sql = "UPDATE {$_TABLES[$table]} SET ";
                foreach ($fields as $field) {
                    $sql .= "$field = '" . addslashes($A[$field]) . "', ";
                }
                $sql = substr($sql, 0, -2);

                DB_query($sql . " WHERE $index = '" . addslashes($A[$index]) . "'");
            }
        }
    }
}


/**
* Unpack a db backup file, if necessary
*
* Note: This requires a minimal PEAR setup (incl. Tar and Zip classes) and a
*       way to set the PEAR include path. But if that doesn't work on your
*       setup, then chances are you won't get Geeklog up and running anyway ...
*
* @param    string  $backup_path    path to the "backups" directory
* @param    string  $backup_file    backup file name
* @param    ref     $display        reference to HTML string (for error msg)
* @return   mixed                   file name of unpacked file or false: error
*
*/
function INST_unpackFile($backup_path, $backup_file, &$display)
{
    global $_CONF, $LANG_MIGRATE;

    $unpacked_file = $backup_file;

    $type = '';
    if (preg_match('/\.zip$/i', $backup_file)) {
        $type = 'zip';
    } elseif (preg_match('/\.tar.gz$/i', $backup_file) ||
              preg_match('/\.tgz$/i', $backup_file)) {
        $type = 'tar';
    }

    if (empty($type)) {
        // not packed
        return $backup_file;
    }

    $include_path = get_include_path();
    if (set_include_path($_CONF['path'] . 'system/pear/' . PATH_SEPARATOR
                         . $include_path) === false) {
        // couldn't set PEAR path - can't handle compressed backups
        $display .= INST_getAlertMsg($LANG_MIGRATE[39]);
        return false;
    }

    if ($type == 'zip') {

        require_once 'Archive/Zip.php';

        $archive = new Archive_Zip($backup_path . $backup_file);

    } else {

        require_once 'Archive/Tar.php';

        $archive = new Archive_Tar($backup_path . $backup_file);

    }

    // we're going to extract the first .sql file we find in the archive
    $found_sql_file = false;
    $files = $archive->listContent();
    foreach ($files as $file) {
        if ((! isset($file['folder'])) || (! $file['folder'])) {
            if (preg_match('/\.sql$/', $file['filename'])) {
                $dirname = preg_replace('/\/.*$/', '', $file['filename']);
                $found_sql_file = true;
                break;
            }
        }
    }

    if (! $found_sql_file) {
        // no .sql file found in archive
        $display .= INST_getAlertMsg(sprintf($LANG_MIGRATE[40], $backup_file));
        return false;
    }

    if ($dirname == $file['filename']) {
        $dirname = ''; // no directory
    }
    if (empty($dirname)) {
        $unpacked_file = $file['filename'];
    } else {
        $unpacked_file = substr($file['filename'], strlen($dirname) + 1);
    } 

    $success = false;
    if ($type == 'zip') {
        $result = $archive->extract(array('add_path' => $backup_path,
                                          'by_name' => array($file['filename']),
                                          'remove_path' => $dirname));
        if (is_array($result)) {
            $success = true;
        }
    } else {
        $result = $archive->extractList(array($file['filename']),
                                        $backup_path, $dirname);
        $success = $result;
    }

    if ((! $success) || (! file_exists($backup_path . $unpacked_file))) {
        // error unpacking file
        $display .= INST_getAlertMsg(sprintf($LANG_MIGRATE[41], $unpacked_file));
        return false;
    }

    unset($archive);

    return $unpacked_file;
}


// +---------------------------------------------------------------------------+
// | Main                                                                      |
// +---------------------------------------------------------------------------+

// Set some vars
$html_path          = INST_getHtmlPath();
$siteconfig_path    = '../../siteconfig.php';

if ($_CONF['path'] == '/path/to/Geeklog/') { // If the Geeklog path has not been defined.

    // Attempt to locate Geeklog's path
    $gl_path = strtr(__FILE__, '\\', '/'); // replace all '\' with '/'
    for ($i = 0; $i < 4; $i++) {
        $remains = strrchr($gl_path, '/');
        if ($remains === false) {
            break;
        } else {
            $gl_path = substr($gl_path, 0, -strlen($remains));
        }
    }

    $_CONF['path'] = $gl_path;

} else {

    // TODO: Remove all references to $gl_path and use $_CONF['path'] for consistency.
    $gl_path = $_CONF['path'];

}

$dbconfig_path      = (isset($_POST['dbconfig_path'])) ? $_POST['dbconfig_path'] : ((isset($_GET['dbconfig_path'])) ? $_GET['dbconfig_path'] : $gl_path . '/db-config.php');
$dbconfig_path      = INST_sanitizePath($dbconfig_path);
$step               = isset($_GET['step']) ? $_GET['step'] : (isset($_POST['step']) ? $_POST['step'] : 1);
$backup_dir         = $_CONF['path'] . 'backups/';

// $display holds all the outputted HTML and content
$display = INST_getHeader($LANG_MIGRATE[17]); // Grab the beginning HTML for the installer theme.

// Make sure the version of PHP is supported.
if (INST_phpOutOfDate()) {

    // If their version of PHP is not supported, print an error:
    $display .= '<h1>' . $LANG_INSTALL[4] . '</h1>' . LB;
    $display .= '<p>' . $LANG_INSTALL[5] . $phpv[0] . '.' . $phpv[1] . '.' . (int) $phpv[2] . $LANG_INSTALL[6] . '</p>' . LB;

} else {

    // Ok, the user's version of PHP is supported. Let's move on
    switch ($step) {

    /**
     * Page 1 - Form for user to enter their database and path information
     * and to select a database backup file from the backups directory
     * or upload a backup from their computer.
     */
    case 1:

        $display .= INST_getAlertMsg($LANG_MIGRATE[0], 'warning') . LB
            . '<h2>' . $LANG_MIGRATE[1] . '</h2>' . LB
            . '<ul>' . LB
            . '<li>' . $LANG_MIGRATE[2] . '</li>' . LB
            . '<li>' . $LANG_MIGRATE[3] . '</li>' . LB
            . '<li>' . $LANG_MIGRATE[5] . '</li>' . LB
            . '<li>' . $LANG_MIGRATE[4] . '</li>' . LB
            . '</ul>' . LB . LB;

        // Default form values
        $_FORM = array( 'host' => 'localhost',
                        'name' => 'geeklog',
                        'user' => 'username',
                        'pass' => '',
                        'prefix' => 'gl_' );
        if (file_exists($dbconfig_path)) {
            require_once $dbconfig_path;

            if (($_DB_host != 'localhost') || ($_DB_name != 'geeklog') ||
                    ($_DB_user != 'username') || ($_DB_pass != 'password')) {
                // only display those if they all have their default values
                $_DB_host = '';
                $_DB_name = '';
                $_DB_user = '';
                $_DB_pass = '';
            }

            $_FORM['host'] = ($_DB_host != 'localhost' ? '' : $_DB_host);
            $_FORM['name'] = ($_DB_name != 'geeklog'   ? '' : $_DB_name);
            $_FORM['user'] = ($_DB_user != 'username'  ? '' : $_DB_user);
            $_FORM['prefix'] = $_DB_table_prefix;
        }

        // Set up the URL and admin URL paths.
        $site_url = isset($_REQUEST['site_url']) ? $_REQUEST['site_url'] : INST_getSiteUrl();
        $site_admin_url = isset($_REQUEST['site_admin_url']) ? $_REQUEST['site_admin_url'] : INST_getSiteAdminUrl();

        $display .= '<h2>' . $LANG_INSTALL[31] . '</h2>' . LB 
            . '<form action="migrate.php" method="post" name="migrate" enctype="multipart/form-data">' . LB 
            . '<input type="hidden" name="step" value="2"' . XHTML . '>' . LB
            . '<input type="hidden" name="language" value="' . $language . '"' . XHTML . '>' . LB
            . '<input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($dbconfig_path) . '"' . XHTML . '>' . LB
            . '<p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[34] . ' ' . INST_helpLink('db_type') . '</label> <select name="db[type]">' . LB 
                . '<option value="mysql">' . $LANG_INSTALL[35] . '</option>' . LB 
            . '</select></p>' . LB
            . '<p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[39] . ' ' . INST_helpLink('db_host') . '</label> <input type="text" name="db[host]" value="' . $_FORM['host'] .'" size="20"' . XHTML . '></p>' . LB
            . '<p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[40] . ' ' . INST_helpLink('db_name') . '</label> <input type="text" name="db[name]" value="' . $_FORM['name'] . '" size="20"' . XHTML . '></p>' . LB
            . '<p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[41] . ' ' . INST_helpLink('db_user') . '</label> <input type="text" name="db[user]" value="' . $_FORM['user'] . '" size="20"' . XHTML . '></p>' . LB
            . '<p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[42] . ' ' . INST_helpLink('db_pass') . '</label> <input type="password" name="db[pass]" value="' . $_FORM['pass'] . '" size="20"' . XHTML . '></p>' . LB
            . '<p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[45] . ' ' . INST_helpLink('site_url') . '</label> <input type="text" name="site_url" value="' . htmlspecialchars($site_url) . '" size="50"' . XHTML . '>  &nbsp; ' . $LANG_INSTALL[46] . '</p>' . LB
            . '<p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[47] . ' ' . INST_helpLink('site_admin_url') . '</label> <input type="text" name="site_admin_url" value="' . htmlspecialchars($site_admin_url) . '" size="50"' . XHTML . '>  &nbsp; ' . $LANG_INSTALL[46] . '</p>' . LB;

        // Identify the backup files in backups/ and order them newest to oldest
        $backup_files = array();
        foreach (array('*.sql', '*.tar.gz', '*.tgz', '*.zip') as $pattern) {
            $files = glob($backup_dir . $pattern);
            if (is_array($files)) {
                $backup_files = array_merge($backup_files, $files);
            }
        }
        rsort($backup_files);

        $display .= '<p><label class="' . $form_label_dir . '">' . $LANG_MIGRATE[6] . ' ' . INST_helpLink('migrate_file') . '</label>' . LB
            . '<select name="migration_type" onchange="INST_selectMigrationType()">' . LB
            . '<option value="">' . $LANG_MIGRATE[7] . '</option>' . LB
            . '<option value="select">' . $LANG_MIGRATE[8] . '</option>' . LB
            . '<option value="upload">' . $LANG_MIGRATE[9] . '</option>' . LB
            . '</select> ' . LB
            . '<span id="migration-select">' . LB;

        // Check if there are any files in the backups directory
        if (count($backup_files) > 0) { 
            
            $display .= '<select name="backup_file">' . LB
                . '<option value="">' . $LANG_MIGRATE[10] . '</option>' . LB;

            // List each of the backup files in the backups directory
            foreach ($backup_files as $file_path) { 

                $file_path   = str_replace('../../../backups/', '', $file_path);
                $filename    = str_replace($backup_dir, '', $file_path);
                $backup_file = str_replace($backup_dir, '', $file_path);

                $display .= '<option value="' . $filename .'">' . $backup_file . ' (' . INST_formatSize(filesize($file_path)) . ')</option>' . LB;

            }
            
            $display .= '</select>' . LB;

        } else { 

            $display .= $LANG_MIGRATE[11] . LB; 

        }

        $display .= '</span>' . LB
            . '<span id="migration-upload">' . LB ;
                
        // Check if the user's PHP configuration has 'file_uploads' enabled
        $file_uploads = ini_get('file_uploads') ? true : false;

        // Check if the plugins directory is writable by the webserver before we even bother uploading anything
        $is_writable = is_writable($backup_dir) ? true : false;

        if ($file_uploads && $is_writable) {

            $display .= '<input class="input_file" type="file" name="backup_file"' . XHTML . '><br' . XHTML . '>' . LB;
        
        }

        $display .= '</span>' . LB
            . '</p>' . LB
            . '<div id="migration-upload-warning">' . LB;

        if ($file_uploads) { 

            if ($is_writable) {
    
                $display .= INST_getAlertMsg($LANG_MIGRATE[12] . ini_get('upload_max_filesize') . $LANG_MIGRATE[13] . ini_get('upload_max_filesize') . $LANG_MIGRATE[14], 'notice');

            } else {

                $display .= INST_getAlertMsg($LANG_MIGRATE[15]);

            }

        } 

        $display .= '</div><br' . XHTML . '>' . LB
            . '<p>' 
            // Todo: Add "Refresh" button to refresh the list of files in the backups directory
            // . '<input type="button" name="refresh" class="submit" value="' . 'Refresh' . '" onclick="INST_refreshBackupList()"' . XHTML . '>' 
            . '<input type="submit" name="submit" class="submit button" value="' . $LANG_MIGRATE[16] . ' &gt;&gt;"' . XHTML . '></p>' . LB
            . '</form>' . LB;

        break;

    /**
     * Page 2 - Check database credentials and write db-config.php using the form data
     */
    case 2:

        /**
         * Check a few things before beginning the import process
         */
        $import_errors = 0;

        // Get the backup_file
        switch ($_REQUEST['migration_type']) {
        case 'select': // Select a backup file from the backups directory

            if (isset($_REQUEST['backup_file']) && !empty($_REQUEST['backup_file'])) {

                $backup_file = array('name' => $_REQUEST['backup_file']);

            } else { // No backup file was selected

                $display .= INST_getAlertMsg($LANG_MIGRATE[18]);
                $backup_file = false;
                $import_errors++;

            }
            break;

        case 'upload': // Upload a new backup file

            if ($upload_error = INST_getUploadError($_FILES['backup_file'])) { // If an error occured while uploading the file
                                                                               // or if no backup file was selected

                $display .= INST_getAlertMsg($upload_error);
                $backup_file = false;
                $import_errors++;

            } else {

                $backup_file = $_FILES['backup_file'];

            }
            break;

        default:
            $display .= INST_getAlertMsg($LANG_MIGRATE[18]);
            $backup_file = false;
            $import_errors++;

        } // End switch ($_REQUEST['migration_type'])

        // Check if we can't connect to the database
        $DB = $_REQUEST['db'];
        if (!INST_dbConnect($DB)) { 

            $display .= INST_getAlertMsg($LANG_INSTALL[54]);
            $import_errors++;

        } else {         

            // Check if the user's version of MySQL is out of date
            // (needs to connect to MySQL in order to check)
            if (INST_mysqlOutOfDate($DB)) {

                $display .= INST_getAlertMsg($LANG_INSTALL[51]);
                $import_errors++;

            } 

        }

        // Check if the database doesn't exist
        if (!INST_dbExists($DB)) { 

            $display .= INST_getAlertMsg($LANG_INSTALL[56]);
            $import_errors++;

        } 

        // Continue with the import if there were no previous errors
        if ($import_errors == 0) { 

            // Check if the form was received from Step 1
            if (isset($_REQUEST['db'])) {

                // Write the database info to db-config.php
                if (!INST_writeConfig(INST_sanitizePath($dbconfig_path), $DB)) {

                    exit($LANG_INSTALL[26] . ' ' . $dbconfig_path . $LANG_INSTALL[58]);

                }
            }

            require_once $dbconfig_path; // Not sure if this needs to be included..
            switch ($_REQUEST['migration_type']) {
            case 'select':

                header('Location: migrate.php?step=3&dbconfig_path=' . $dbconfig_path 
                    . '&language=' . $language 
                    . '&backup_file=' . urlencode($backup_file['name'])
                    . '&site_url=' . urlencode($_REQUEST['site_url'])
                    . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));
                break;

            case 'upload':

                $backup_file = $_FILES['backup_file'];

                if (file_exists($backup_dir . $backup_file['name'])) { // If file already exists.

                    // Ask the user if they want to overwrite the original 
                    // but for now save the file as a copy so it won't need
                    // to be uploaded again.
                    $backup_file_copy = str_replace('.sql', '_uploaded.sql', $backup_file['name']);
                    if (!move_uploaded_file($backup_file['tmp_name'], $backup_dir . $backup_file_copy)) { // If able to save the file

                        $display .= $LANG_MIGRATE[19] . $backup_file_copy . $LANG_MIGRATE[20] . $backup_dir . '.' . LB;

                    } else {

                        $display .= '<p>' . $LANG_MIGRATE[21] . ' <code>' . $backup_file['name'] . '</code> ' . $LANG_MIGRATE[22] . '</p><br' . XHTML . '>' . LB
                            . '<form action="migrate.php" method="post"><p align="center">' . LB
                            . '<input type="hidden" name="step" value="3"' . XHTML . '>' . LB
                            . '<input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($dbconfig_path) . '"' . XHTML . '>' . LB
                            . '<input type="hidden" name="site_url" value="' . urlencode($_REQUEST['site_url']) . '"' . XHTML . '>' . LB
                            . '<input type="hidden" name="site_admin_url" value="' . urlencode($_REQUEST['site_admin_url']) . '"' . XHTML . '>' . LB
                            . '<input type="hidden" name="backup_file" value="' . $backup_file['name'] . '"' . XHTML . '>' . LB
                            . '<input type="hidden" name="language" value="' . $language . '"' . XHTML . '>' . LB
                            . '<input type="submit" class="button big-button" name="overwrite_file" value="' . $LANG_MIGRATE[23] . '"' . XHTML .'>' . LB
                            . '<input type="submit" class="button big-button" name="no" value="' . $LANG_MIGRATE[24] . '" onclick="document.location=\'migrate.php\'"' . XHTML .'>' . LB
                            . '</p></form>' . LB;

                    }

                } else {

                    if (!move_uploaded_file($backup_file['tmp_name'], $backup_dir . $backup_file['name'])) { // If able to save the uploaded file
    
                        $display .= $LANG_MIGRATE[19] . $backup_file['name'] . $LANG_MIGRATE[20] . $backup_dir . '.' . LB;

                    } else {

                        header('Location: migrate.php?step=3&dbconfig_path=' . $dbconfig_path 
                            . '&language=' . $language 
                            . '&backup_file=' . urlencode($backup_file['name'])
                            . '&site_url=' . urlencode($_REQUEST['site_url'])
                            . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));

                    }

                }

                break;

            } // End switch ($_REQUEST['migration_type']

        }

        break;

    /**
     * Page 3 - Gets the database table prefix from the database file.
     * Overwrites an existing database file if requested by the user.
     * Sends the database filename (and a few other variables) 
     * to bigdump.php, which performs the import.
     * 
     */
    case 3:

        require_once 'lib-upgrade.php';

        // Get the backup filename
        $backup_file = $_REQUEST['backup_file'];

        // If the user chose to overwrite an existing backup file
        if (isset($_REQUEST['overwrite_file'])) { 

            // Overwrite the old file with the new file.
            rename($backup_dir . str_replace('.sql', '_uploaded.sql', $backup_file), $backup_dir . $backup_file);

        }

        $unpacked_file = INST_unpackFile($backup_dir, $backup_file, $display);
        if ($unpacked_file !== false) {

            $backup_file = $unpacked_file;

            // Parse the .sql file to grab the table prefix
            $has_config = false;
            $num_create = 0;
            $db_connection_charset = '';
            $DB['table_prefix'] = '';

            $sql_file = @fopen($backup_dir . $backup_file, 'r');
            if (! $sql_file) {
                // "This shouldn't happen" - just unpacked and now it's gone?
                exit(sprintf($LANG_MIGRATE[42], $backup_dir . $backup_file));
            }
            while (! feof($sql_file)) {
                $line = @fgets($sql_file);
                if (! empty($line)) {
                    if (preg_match('/CREATE TABLE/i', $line)) {
                        $num_create++;
                        $line = trim($line);
                        if (strpos($line, 'access') !== false) {
                            $line = str_replace('IF NOT EXISTS ', '', $line);
                            $words = explode(' ', $line);
                            if (count($words) >= 3) {
                                $table = str_replace('`', '', $words[2]);
                                if (substr($table, -6) == 'access') {
                                    $DB['table_prefix'] = substr($table, 0, -6);
                                }
                            }
                        } elseif (strpos($line, 'conf_values') !== false) {
                            $has_config = true;
                            break;
                        } elseif (strpos($line, 'featurecodes') !== false) {
                            // assume there's no conf_values table in here
                            break;
                        }
                    } elseif (substr($line, 0, 3) == '/*!') {
                        if (strpos($line, 'SET NAMES utf8') !== false) {
                            $db_connection_charset = 'utf8';
                        }
                    } elseif (empty($db_connection_charset) &&
                            strpos($line, 'ENGINE=') !== false) {
                        if (strpos($line, 'DEFAULT CHARSET=utf8') !== false) {
                            $db_connection_charset = 'utf8';
                        }
                    }
                }
            }
            fclose($sql_file);

            if ($num_create <= 1) {

                // this doesn't look like an SQL dump ...
                $display .= INST_getAlertMsg(sprintf($LANG_MIGRATE[43],
                                                     $backup_file));

            } else {
                // Update db-config.php with the table prefix from the backup file.
                if (!INST_writeConfig($dbconfig_path, $DB)) {
                    exit($LANG_INSTALL[26] . ' ' . $dbconfig_path
                         . $LANG_INSTALL[58]);
                }

                if (!INST_setDefaultCharset($siteconfig_path,
                        ($db_connection_charset == 'utf8'
                                                ? 'utf-8' : $LANG_CHARSET))) {
                    exit($LANG_INSTALL[26] . ' ' . $siteconfig_path
                         . $LANG_INSTALL[58]);
                }

                // Send file to bigdump.php script to do the import.
                header('Location: bigdump.php?start=1&foffset=0&totalqueries=0'
                    . '&db_connection_charset=' . $db_connection_charset
                    . '&language=' . $language
                    . '&fn=' . urlencode($backup_dir . $backup_file) 
                    . '&site_url=' . urlencode($_REQUEST['site_url'])
                    . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));

            }

        }

        break;

    /**
     * Page 4 - Post-import operations
     * Update the database, if necessary. Then check for missing plugins,
     * incorrect paths, and other required Geeklog files
     */
    case 4:

        require_once $dbconfig_path;
        require_once $_CONF['path_system'] . 'lib-database.php';
        require_once 'lib-upgrade.php';

        $upgrade_error = false;

        $version = INST_identifyGeeklogVersion();
        if ($version == 'empty') {

            // "This shouldn't happen"
            $display .= INST_getAlertMsg($LANG_MIGRATE[44]);
            $upgrade_error = true;

        } elseif (empty($version)) {

            $display .= INST_getAlertMsg($LANG_MIGRATE[45]);
            // TBD: add a link back to the install script, preferrably a direct
            //      link to the upgrade screen
            $upgrade_error = true;

        } elseif ($version != VERSION) {

            $use_innodb = false;
            $db_engine = DB_getItem($_TABLES['vars'], 'value',
                                    "name = 'database_engine'");
            if ($db_engine == 'InnoDB') {
                // we've migrated, probably to a different server
                // - so check InnoDB support again
                if (INST_innodbSupported()) {
                    $use_innodb = true;
                } else {
                    // no InnoDB support on this server
                    DB_delete($_TABLES['vars'], 'name', 'database_engine');
                }
            }

            if (! INST_doDatabaseUpgrades($version)) {

                $display .= INST_getAlertMsg(sprintf($LANG_MIGRATE[47],
                                                     $version, VERSION));
                $upgrade_error = true;

            }

        }

        if ($upgrade_error) {

            $display .= INST_getFooter();
            echo $display;
            exit;

        }

        /**
         * Let's assume that the paths that were imported from the backup are 
         * incorrect and update them with the current paths.
         *
         * Note: When updating the config settings in the database, we also
         *       need to fix the $_CONF values. We can _not_ simply reload
         *       them via get_config('Core') here yet.
         *
         */
        require_once $_CONF['path_system'] . 'classes/config.class.php';
        $config = config::get_instance();
        $config->initConfig();

        // save a copy of the old config
        $_OLD_CONF = $config->get_config('Core');

        $config->set('site_url', urldecode($_REQUEST['site_url']));
        $_CONF['site_url'] = urldecode($_REQUEST['site_url']);
        $config->set('site_admin_url', urldecode($_REQUEST['site_admin_url']));
        $_CONF['site_admin_url'] = urldecode($_REQUEST['site_admin_url']);
        $config->set('path_html', $html_path);
        $_CONF['path_html'] = $html_path;
        $config->set('path_log', $gl_path . 'logs/');
        $_CONF['path_log'] = $gl_path . 'logs/';
        $config->set('path_language', $gl_path . 'language/');
        $_CONF['path_language'] = $gl_path . 'language/';
        $config->set('backup_path', $backup_dir);
        $_CONF['backup_path'] = $backup_dir;
        $config->set('path_data', $gl_path . 'data/');
        $_CONF['path_data'] = $gl_path . 'data/';
        $config->set('path_images', $html_path . 'images/');
        $_CONF['path_images'] = $html_path . 'images/';
        $config->set('path_themes', $html_path . 'layout/');
        $_CONF['path_themes'] = $html_path . 'layout/';
        $config->set('rdf_file', $html_path . 'backend/geeklog.rss');
        $_CONF['rdf_file'] = $html_path . 'backend/geeklog.rss';
        $config->set('path_pear', $_CONF['path_system'] . 'pear/');
        $_CONF['path_pear'] = $_CONF['path_system'] . 'pear/';

        // reset cookie domain and path as wrong values may prevent login
        $config->set('cookiedomain', '');
        $_CONF['cookiedomain'] = '';
        $config->set('cookie_path', '/');
        $_CONF['cookie_path'] = '/';

        // check the default theme
        $theme = '';
        if (empty($_CONF['theme'])) {
            // try old conf value
            $theme = $_OLD_CONF['theme'];
        } else {
            $theme = $_CONF['theme'];
        }

        if (! file_exists($_CONF['path_themes'] . $theme . '/header.thtml')) {
            $config->set('theme', 'professional');
            $_CONF['theme'] = 'professional';
        }

        // set noreply_mail when updating from an old version
        if (empty($_CONF['noreply_mail']) && (! empty($_CONF['site_mail']))) {
            $_CONF['noreply_mail'] = $_CONF['site_mail'];
            $config->set('noreply_mail', $_CONF['noreply_mail']);
        }

        if (! empty($_OLD_CONF['ip_lookup'])) {
            $_CONF['ip_lookup'] = str_replace($_OLD_CONF['site_url'],
                $_CONF['site_url'], $_OLD_CONF['ip_lookup']);
            $config->set('ip_lookup', $_CONF['ip_lookup']);
        }

        /**
         * Check for missing plugins
         */

        // We want to add a log entry for any plugins that have been disabled 
        // but we can't actually call lib-common.php until all missing plugins 
        // have been disabled. So we keep track of missing plugins in the 
        // $_MISSING_PLUGINS array then call lib-common.php and log them after
        // they've been disabled.
        $_MISSING_PLUGINS = array();

        // Query {$_TABLES['plugins']} to get a list of installed plugins
        $missing_plugins = 0;
        $result = DB_query("SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
        $num_plugins = DB_numRows($result);
        for ($i = 0; $i < $num_plugins; $i++) { // Look in the plugins directories to ensure that those plugins exist. 
        
            $plugin = DB_fetchArray($result);

            if (!file_exists($_CONF['path'] . 'plugins/' . $plugin['pi_name'])) { // If plugin does not exist

                // Deactivate the plugin
                DB_query("UPDATE {$_TABLES['plugins']} SET pi_enabled='0' WHERE pi_name='{$plugin['pi_name']}'");

                array_push($_MISSING_PLUGINS, $plugin['pi_name']);

                $missing_plugins++;

            } 

        }

        // Any missing plugins have been disabled, now we can get lib-common.php
        // so we can call COM_errorLog().
        require_once $html_path . 'lib-common.php'; 

        // including lib-common.php overwrites our $language variable
        $language = INST_getLanguage();

        // Log any missing plugins
        foreach ($_MISSING_PLUGINS as $m_p) {

            COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[27] . $m_p . $LANG_MIGRATE[28]); 

        }

        $disabled_plugins = 0;
        if ($version != VERSION) {

            // We did a database upgrade above. Now that any missing plugins
            // have been disabled and we've loaded lib-common.php, perform
            // upgrades for the remaining plugins.
            $disabled_plugins = INST_pluginUpgrades(true, $_OLD_CONF);

        }

        // finally, check for any new plugins and install them
        INST_autoinstallNewPlugins();

        /**
         * Check for other missing files
         * e.g. images/articles, images/topics, images/userphotos
         *
         */
        $missing_images = false;

        // Article images
        $missing_article_images = false;
        $result = DB_query("SELECT `ai_filename` FROM {$_TABLES['article_images']}");
        $num_article_images = DB_numRows($result);
        for ($i = 0; $i < $num_article_images; $i++) {

            $article_image = DB_fetchArray($result); // 
            if (!file_exists($html_path . 'images/articles/' . $article_image['ai_filename'])) { // If article image does not exist

                // Log the error
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[29] . $article_image['ai_filename'] . $LANG_MIGRATE[30] . $_TABLES['article_images'] . $LANG_MIGRATE[31] . $html_path . 'images/articles/'); 

                $missing_article_images = true;
                $missing_images = true;

            }
        }
        
        // Topic images
        $missing_topic_images = false;
        $result = DB_query("SELECT `imageurl` FROM {$_TABLES['topics']}");
        $num_topic_images = DB_numRows($result);
        for ($i = 0; $i < $num_topic_images; $i++) {
        
            $topic_image = DB_fetchArray($result);
            if (!file_exists($html_path . $topic_image['imageurl'])) { // If topic image does not exist

                // Log the error
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[29] . $topic_image['imageurl'] . $LANG_MIGRATE[30] . $_TABLES['topics'] . $LANG_MIGRATE[31] . $html_path . 'images/topics/'); 

                $missing_topic_images = true;
                $missing_images = true;
            
            }
        
        }

        // Userphoto images
        $missing_userphoto_images = false;
        $result = DB_query("SELECT `photo` FROM {$_TABLES['users']} WHERE `photo` != NULL AND `photo` != ''");
        $num_userphoto_images = DB_numRows($result);
        for ($i = 0; $i < $num_userphoto_images; $i++) {
        
            $userphoto_image = DB_fetchArray($result);
            if (!file_exists($html_path . 'images/userphotos/' . $userphoto_image['photo'])) { // If userphoto image does not exist
            
                // Log the error
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[29] . $userphoto_image['photo'] . $LANG_MIGRATE[30] . $_TABLES['users'] . $LANG_MIGRATE[31] . $html_path . 'images/userphotos/'); 

                $missing_userphoto_images = true;
                $missing_images = true;
        
            }

        }

        // did the site URL change?
        if ((! empty($_OLD_CONF['site_url'])) & (! empty($_CONF['site_url']))
                && ($_OLD_CONF['site_url'] != $_CONF['site_url'])) {

            INST_updateSiteUrl($_OLD_CONF['site_url'], $_CONF['site_url']);

        } else {

            // refresh "Older Stories" block
            COM_olderStuff();

        }

        /** 
         * Import complete.
         *
         */

        // Check if there are any missing files or plugins
        if ($missing_images || ($missing_plugins > 0) ||
                ($disabled_plugins > 0)) {

            $display .= '<h2>' . $LANG_MIGRATE[37] . '</h2>' . LB
                        . '<p>' . $LANG_MIGRATE[38] . '</p>' . LB;

            // Plugins
            if ($missing_plugins > 0) { 

                $display .= INST_getAlertMsg($LANG_MIGRATE[32] . ' <code>' . $_CONF['path'] . 'plugins/</code> ' . $LANG_MIGRATE[33], 'notice');

            }

            if ($disabled_plugins > 0) {

                $display .= INST_getAlertMsg($LANG_MIGRATE[48]);

            }

            // Article images
            if ($missing_article_images) { 

                $display .= INST_getAlertMsg($LANG_MIGRATE[34] . ' <code>' . $html_path . 'images/articles/</code> ' . $LANG_MIGRATE[35], 'notice');

            }

            // Topic images
            if ($missing_topic_images) { 
            
                $display .= INST_getAlertMsg($LANG_MIGRATE[34] . ' <code>' . $html_path . 'images/topics/</code> ' . $LANG_MIGRATE[35], 'notice');

            }

            // Userphoto images
            if ($missing_userphoto_images) { 

                $display .= INST_getAlertMsg($LANG_MIGRATE[34] . ' <code>' . $html_path . 'images/userphotos/</code> ' . $LANG_MIGRATE[35], 'notice');

            }

            $display .= '<p>' . $LANG_MIGRATE[36] . '</p>' . LB
                .'<form action="success.php" method="get">' . LB
                . '<input type="hidden" name="type" value="migrate"' . XHTML . '>' . LB
                . '<input type="hidden" name="language" value="' . $language . '"' . XHTML . '>' . LB
                . '<input type="hidden" name="" value=""' . XHTML . '>' . LB
                . '<p><input type="submit" class="button big-button" name="" value="' . $LANG_INSTALL[62] . ' &gt;&gt;"' . XHTML . '></p>' . LB
                . '</form>'; 

        } else {

            header('Location: success.php?type=migrate&language=' . $language);

        }

        break;

    } // End switch ($step)
} // end if (php_v())

$display .= INST_getFooter();

header('Content-Type: text/html; charset=' . $LANG_CHARSET);
echo $display;

?>
