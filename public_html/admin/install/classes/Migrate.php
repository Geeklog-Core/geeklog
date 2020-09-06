<?php

namespace Geeklog\Install;

use config;
use Geeklog\Autoload;
use Geeklog\Input;
use MicroTemplate;
use Unpacker;

require_once __DIR__ . '/Common.php';

/**
 * Class Migrate
 *
 * @package Geeklog\Install
 */
class Migrate extends Common
{
    /**
     * Written to aid in install script development
     * NOTE:    This code is a modified copy from PHP.net
     *
     * @param  int  $size        file size
     * @param  int  $dec_places  Number of decimal places
     * @return  string             file size string
     */
    private function formatSize($size, $dec_places = 0)
    {
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        for ($i = 0; ($size > 1024 && isset($sizes[$i + 1])); $i++) {
            $size /= 1024;
        }

        return round($size, $dec_places) . ' ' . $sizes[$i];
    }

    /**
     * Check if an error occurred while uploading a file
     *
     * @param  array  $mFile    $_FILE['uploaded_file']
     * @return  mixed           Returns the error string if an error occurred,
     *                          returns false if no error occurred
     */
    public function getUploadError($mFile)
    {
        global $LANG_ERROR;

        $mErrors = [
            UPLOAD_ERR_INI_SIZE   => $LANG_ERROR[0],
            UPLOAD_ERR_FORM_SIZE  => $LANG_ERROR[1],
            UPLOAD_ERR_PARTIAL    => $LANG_ERROR[2],
            UPLOAD_ERR_NO_FILE    => $LANG_ERROR[3],
            UPLOAD_ERR_NO_TMP_DIR => $LANG_ERROR[4],
            UPLOAD_ERR_CANT_WRITE => $LANG_ERROR[5],
            UPLOAD_ERR_EXTENSION  => $LANG_ERROR[6],
        ];

        if ($mFile['error'] != UPLOAD_ERR_OK) { // If an error occurred while uploading the file.
            if ($mFile['error'] > count($mErrors)) { // If the error code isn't listed in $mErrors
                $mRetval = 'An unknown error occurred'; // Unknown error
            } else {
                $mRetval = $mErrors[$mFile['error']]; // Print the error
            }
        } else { // If no upload error occurred
            $mRetval = false;
        }

        return $mRetval;
    }

    /**
     * Unpack a db backup file with its file name ending ".sql.gz"
     *
     * @param  string  $backupPath
     * @param  string  $backupFile
     * @param  string  $display
     * @return string|false
     */
    private function unpackSqlGzFile($backupPath, $backupFile, &$display)
    {
        global $LANG_MIGRATE;

        if (!is_callable('gzopen')) {
            $display .= $this->getAlertMsg($LANG_MIGRATE[39], 'error');

            return false;
        }

        $in = @gzopen($backupPath . $backupFile, 'rb');
        if (!$in) {
            $display .= $this->getAlertMsg($LANG_MIGRATE[41], 'error');

            return false;
        }

        $destFile = substr($backupFile, 0, -strlen('.gz'));
        $out = @fopen($backupPath . $destFile, 'wb');
        if (!$out) {
            $display .= $this->getAlertMsg($LANG_MIGRATE[41], 'error');

            return false;
        }

        while (!gzeof($in)) {
            $data = gzread($in, 512);

            if (empty($data)) {
                break;
            } else {
                fwrite($out, $data);
            }
        }

        @fclose($out);
        @gzclose($in);

        return $destFile;
    }

    /**
     * Unpack a db backup file, if necessary
     * Note: This requires a minimal PEAR setup (incl. Tar and Zip classes) and a
     *       way to set the PEAR include path. But if that doesn't work on your
     *       setup, then chances are you won't get Geeklog up and running anyway ...
     *
     * @param  string  $backupPath  path to the "backups" directory
     * @param  string  $backupFile  backup file name
     * @param  string  $display     reference to HTML string (for error msg)
     * @return   mixed              file name of unpacked file or false: error
     */
    private function unpackFile($backupPath, $backupFile, &$display)
    {
        global $LANG_MIGRATE;

        // Backup files created with Geeklog's DBBackUp feature needs to be treated separately
        if (preg_match('/\.sql.gz\z/', $backupFile)) {
            return $this->unpackSqlGzFile($backupPath, $backupFile, $display);
        }

        if (!preg_match('/\.(zip|tar\.gz|tgz|gz)$/i', $backupFile)) {
            // not packed
            return $backupFile;
        }

        $gl_path = str_replace(self::DB_CONFIG_FILE, '', Common::$env['dbconfig_path']);

        require_once $gl_path . 'system/classes/Autoload.php';
        Autoload::initialize();
        $archive = new Unpacker($backupPath . $backupFile);

        // we're going to extract the first .sql file we find in the archive
        $dirName = '';
        $foundSqlFile = false;
        $file = '';
        $files = $archive->getList();

        if (is_array($files) && (count($files) > 0)) {
            foreach ($files as $file) {
                if (!isset($file['folder']) || !$file['folder']) {
                    if (preg_match('/\.sql$/', $file['filename'])) {
                        $dirName = preg_replace('/\/.*$/', '', $file['filename']);
                        $foundSqlFile = true;
                        break;
                    }
                }
            }
        }

        if (!$foundSqlFile) {
            // no .sql file found in archive
            return false;
        }

        if (isset($file) && ($dirName === $file['filename'])) {
            $dirName = ''; // no directory
        }

        if (empty($dirName)) {
            $unpacked_file = $file['filename'];
        } else {
            $unpacked_file = substr($file['filename'], strlen($dirName) + 1);
        }

        $success = $archive->unpack($backupPath, '|' . preg_quote($file['filename'], '|') . '|');

        if (!$success || !file_exists($backupPath . $unpacked_file)) {
            // error unpacking file
            $display .= $this->getAlertMsg(sprintf($LANG_MIGRATE[41], $unpacked_file));

            return false;
        }

        unset($archive);

        return $unpacked_file;
    }

    /**
     * @return string
     */
    private function getLanguage()
    {
        return Common::$env['language'];
    }

    /**
     * Upgrade any enabled plugins
     * NOTE: Needs a fully working Geeklog, so can only be done late in the upgrade
     *       process!
     *
     * @param  boolean  $migration  whether the upgrade is part of a site migration
     * @param  array    $old_conf   old $_CONF values before the migration
     * @return   int     number of failed plugin updates (0 = everything's fine)
     * @see      PLG_upgrade
     * @see      PLG_migrate
     */
    private function pluginUpgrades($migration = false, $old_conf = [])
    {
        global $_CONF, $_PLUGINS, $_TABLES;

        $failed = 0;

        $result = DB_query("SELECT pi_name, pi_version FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
        $numPlugins = DB_numRows($result);

        for ($i = 0; $i < $numPlugins; $i++) {
            list($pi_name, $pi_version) = DB_fetchArray($result);

            $isSuccess = true;
            if ($migration) {
                $isSuccess = PLG_migrate($pi_name, $old_conf);
            }

            if ($isSuccess) {
                $code_version = PLG_chkVersion($pi_name);
                if (!empty($code_version) && ($code_version != $pi_version)) {
                    $isSuccess = PLG_upgrade($pi_name);
                }
            }

            if (!$isSuccess) {
                // migration or upgrade failed - disable plugin
                DB_change($_TABLES['plugins'], 'pi_enabled', 0,
                    'pi_name', $pi_name);
                COM_errorLog("Migration or upgrade for '{$pi_name}' plugin failed - plugin disabled");
                $failed++;
            }
        }

        // Only after all the other plugins are updated can we update sitemaps
        if (in_array('xmlsitemap', $_PLUGINS)) {
            require_once $_CONF['path'] . 'plugins/xmlsitemap/functions.inc';
            XMLSMAP_update();
            COM_errorLog('Successfully updated/migrated the "XMLSitemap" plugin');
        }

        return $failed;
    }

    /**
     * Migrate page 1 - Form for user to enter their database and path information
     * and to select a database backup file from the backups directory
     * or upload a backup from their computer.
     *
     * @return string
     */
    public function step1()
    {
        global $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix, $_DB_charset,
               $LANG_INSTALL, $LANG_MIGRATE;

        Common::$env['alert_message1'] = $this->getAlertMessage($LANG_MIGRATE[0]);

        // Default form values
        $_FORM = [
            'host'   => 'localhost',
            'name'   => 'geeklog',
            'user'   => 'username',
            'pass'   => '',
            'prefix' => 'gl_',
        ];

        if (file_exists(Common::$env['dbconfig_path'])) {
            require_once Common::$env['dbconfig_path'];

            if (($_DB_host !== 'localhost') || ($_DB_name !== 'geeklog')
                || ($_DB_user !== 'username') || ($_DB_pass != 'password')
            ) {
                // only display those if they all have their default values
                $_DB_host = '';
                $_DB_name = '';
                $_DB_user = '';
                $_DB_pass = '';
            }

            $_FORM['host'] = ($_DB_host !== 'localhost') ? '' : $_DB_host;
            $_FORM['name'] = ($_DB_name !== 'geeklog') ? '' : $_DB_name;
            $_FORM['user'] = ($_DB_user !== 'username)') ? '' : $_DB_user;
            $_FORM['prefix'] = $_DB_table_prefix;
        }

        $this->checkDatabaseCharacterSet();

        Common::$env['host'] = $_FORM['host'];
        Common::$env['name'] = $_FORM['name'];
        Common::$env['user'] = $_FORM['user'];
        Common::$env['pass'] = '';
        Common::$env['prefix'] = $_FORM['prefix'];

        // Set up the URL and admin URL paths.
        Common::$env['site_url'] = isset($_REQUEST['site_url'])
            ? $_REQUEST['site_url']
            : $this->getSiteUrl();
        Common::$env['site_admin_url'] = isset($_REQUEST['site_admin_url']) ? $_REQUEST['site_admin_url'] : $this->getSiteAdminUrl();
        Common::$env['help_db_type'] = $this->getHelpLink('db_type');
        Common::$env['help_db_host'] = $this->getHelpLink('db_host');
        Common::$env['help_db_name'] = $this->getHelpLink('db_name');
        Common::$env['help_db_user'] = $this->getHelpLink('db_user');
        Common::$env['help_db_pass'] = $this->getHelpLink('db_pass');
        Common::$env['help_site_url'] = $this->getHelpLink('site_url');
        Common::$env['help_site_admin_url'] = $this->getHelpLink('site_admin_url');
        Common::$env['help_migrate_file'] = $this->getHelpLink('migrate_file');

        // Identify the backup files in backups/ and order them newest to oldest
        $gl_path = str_replace(self::DB_CONFIG_FILE, '', Common::$env['dbconfig_path']);
        $backup_dir = $gl_path . 'backups/';
        $backupFiles = [];

        foreach (['*.sql', '*.gz', '*.tar.gz', '*.tgz', '*.zip'] as $pattern) {
            $files = glob($backup_dir . $pattern);

            if (is_array($files)) {
                $backupFiles = array_merge($backupFiles, $files);
            }
        }

        rsort($backupFiles);

        // Check if there are any files in the backups directory
        if (count($backupFiles) > 0) {
            $backupFileSelector = '<select name="backup_file" class="uk-select uk-width-auto">' . PHP_EOL
                . '<option value="">' . $LANG_MIGRATE[10] . '</option>' . PHP_EOL;

            // List each of the backup files in the backups directory
            foreach ($backupFiles as $filePath) {
                $filePath = str_replace('../../../backups/', '', $filePath);
                $filename = str_replace($backup_dir, '', $filePath);
                $backupFile = str_replace($backup_dir, '', $filePath);

                $backupFileSelector .= '<option value="' . $filename . '">'
                    . $backupFile . ' (' . $this->formatSize(@filesize($filePath)) . ')' . PHP_EOL
                    . '</option>' . PHP_EOL;
            }

            $backupFileSelector .= '</select>' . PHP_EOL;
        } else {
            $backupFileSelector = $LANG_MIGRATE[11] . PHP_EOL;
        }

        Common::$env['backup_file_selector'] = $backupFileSelector;

        // Check if the user's PHP configuration has 'file_uploads' enabled
        $fileUploads = (bool) ini_get('file_uploads');

        // Check if the plugins directory is writable by the web server before we even bother uploading anything
        $isWritable = is_writable($backup_dir);
        Common::$env['backup_file'] = ($fileUploads && $isWritable)
            ? '<input type="file" name="backup_file">' . PHP_EOL
            : '';

        if ($fileUploads) {
            if ($isWritable) {
                $alertMessage2 = $this->getAlertMessage($LANG_MIGRATE[12] . ini_get('upload_max_filesize') . $LANG_MIGRATE[13] . ini_get('upload_max_filesize') . $LANG_MIGRATE[14], 'notice');
            } else {
                $alertMessage2 = $this->getAlertMessage($LANG_MIGRATE[15], 'warning');
            }
        } else {
            $alertMessage2 = '';
        }

        Common::$env['alert_message2'] = $alertMessage2;

        // Update migration warning language about outdated custom theme with default theme
        // Use env to overwrite Language Variable with updated info
        Common::$env['LANG']['MIGRATE'][5] = sprintf($LANG_MIGRATE[5], self::DEFAULT_THEME);

        return MicroTemplate::quick(PATH_LAYOUT, 'step1-migrate', Common::$env);
    }

    /**
     * Migrate page 2 - Check database credentials and write db-config.php using the form data
     */
    public function step2()
    {
        global $_CONF, $LANG_INSTALL, $LANG_CHARSET, $LANG_MIGRATE;

        // Check a few things before beginning the import process
        $importErrors = 0;
        $display = '';

        // Get the backup_file
        switch ($_REQUEST['migration_type']) {
            case 'select': // Select a backup file from the backups directory
                if (isset($_REQUEST['backup_file']) && !empty($_REQUEST['backup_file'])) {
                    $backupFile = ['name' => $_REQUEST['backup_file']];
                } else { // No backup file was selected
                    $display .= $this->getAlertMessage($LANG_MIGRATE[18], 'warning');
                    $backupFile = false;
                    $importErrors++;
                }

                break;

            case 'upload': // Upload a new backup file
                if ($upload_error = $this->getUploadError($_FILES['backup_file'])) { // If an error occurred while uploading the file
                    // or if no backup file was selected
                    $display .= $this->getAlertMsg($upload_error, 'warning');
                    $backupFile = false;
                    $importErrors++;
                } else {
                    $backupFile = $_FILES['backup_file'];
                }

                break;

            case 'dbcontent': // No upload / import required - use db as is
                $backupFile = false;
                $importErrors = 0;
                break;

            default:
                $display .= $this->getAlertMsg($LANG_MIGRATE[18], 'warning');
                $backupFile = false;
                $importErrors++;
        } // End switch ($_REQUEST['migration_type'])

        // Check if we can't connect to the database
        $DB = $_REQUEST['db'];

        if (!$this->dbConnect($DB)) {
            $display .= $this->getAlertMsg($LANG_INSTALL[54], 'warning');
            $importErrors++;
        } else {
            // Check if the user's version of MySQL is out of date
            // (needs to connect to MySQL in order to check)
            if ($this->isMysqlOutOfDate($DB)) {
                $display .= $this->getAlertMsg(sprintf($LANG_INSTALL[51], self::SUPPORTED_MYSQL_VER));
                $importErrors++;
            }
        }

        // Check if the database doesn't exist
        if (!$this->dbExists($DB)) {
            $display .= $this->getAlertMsg($LANG_INSTALL[56], 'warning');
            $importErrors++;
        }

        // Continue with the import if there were no previous errors
        if ($importErrors == 0) {
            // Check if the form was received from Step 1
            if (isset($_REQUEST['db'])) {
                // Write the database info to db-config.php
                if (!$this->writeDbConfig($this->sanitizePath(Common::$env['dbconfig_path']), $DB)) {
                    exit($LANG_INSTALL[26] . ' ' . Common::$env['dbconfig_path'] . $LANG_INSTALL[58]);
                }
            }

            $this->includeConfig(Common::$env['dbconfig_path']); // Not sure if this needs to be included..

            switch ($_REQUEST['migration_type']) {
                case 'select':
                    header('Location: index.php?mode=migrate&step=3&dbconfig_path=' . Common::$env['dbconfig_path']
                        . '&language=' . Common::$env['language']
                        . '&backup_file=' . urlencode($backupFile['name'])
                        . '&site_url=' . urlencode($_REQUEST['site_url'])
                        . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));
                    break;

                case 'upload':
                    $gl_path = str_replace(self::DB_CONFIG_FILE, '', Common::$env['dbconfig_path']);
                    $backup_dir = $gl_path . 'backups/';
                    $backupFile = $_FILES['backup_file'];

                    if (file_exists($backup_dir . $backupFile['name'])) { // If file already exists.
                        // Ask the user if they want to overwrite the original
                        // but for now save the file as a copy so it won't need
                        // to be uploaded again.
                        $backup_file_copy = str_replace('.sql', '_uploaded.sql', $backupFile['name']);

                        if (!move_uploaded_file($backupFile['tmp_name'], $backup_dir . $backup_file_copy)) { // If able to save the file
                            $display .= $LANG_MIGRATE[19] . $backup_file_copy . $LANG_MIGRATE[20] . $backup_dir . '.' . PHP_EOL;
                        } else {
                            $display .= '<p>' . $LANG_MIGRATE[21] . ' <code>' . $backupFile['name'] . '</code> ' . $LANG_MIGRATE[22] . '</p>' . PHP_EOL
                                . '<form action="index.php" method="post">' . PHP_EOL
                                . '<input type="hidden" name="mode" value="migrate">' . PHP_EOL
                                . '<input type="hidden" name="step" value="3">' . PHP_EOL
                                . '<input type="hidden" name="dbconfig_path" value="' . htmlspecialchars(Common::$env['dbconfig_path']) . '">' . PHP_EOL
                                . '<input type="hidden" name="site_url" value="' . urlencode($_REQUEST['site_url']) . '">' . PHP_EOL
                                . '<input type="hidden" name="site_admin_url" value="' . urlencode($_REQUEST['site_admin_url']) . '">' . PHP_EOL
                                . '<input type="hidden" name="backup_file" value="' . $backupFile['name'] . '">' . PHP_EOL
                                . '<input type="hidden" name="language" value="' . Common::$env['language'] . '">' . PHP_EOL
                                . '<button type="submit" class="uk-button uk-button-primary uk-margin-small" name="overwrite_file" value="' . $LANG_MIGRATE[23] . '">' . $LANG_MIGRATE[23] . '</button>' . PHP_EOL
                                . '<button type="submit" class="uk-button uk-button-primary uk-margin-small" name="no" value="' . $LANG_MIGRATE[24] . '" onclick="document.location=\'index.php\'">' . $LANG_MIGRATE[24] . '</button>' . PHP_EOL
                                . '</form>' . PHP_EOL;
                        }
                    } else {
                        if (!move_uploaded_file($backupFile['tmp_name'], $backup_dir . $backupFile['name'])) { // If able to save the uploaded file
                            $display .= $LANG_MIGRATE[19] . $backupFile['name'] . $LANG_MIGRATE[20] . $backup_dir . '.' . PHP_EOL;
                        } else {
                            header('Location: index.php?mode=migrate&step=3&dbconfig_path=' . Common::$env['dbconfig_path']
                                . '&language=' . Common::$env['language']
                                . '&backup_file=' . urlencode($backupFile['name'])
                                . '&site_url=' . urlencode($_REQUEST['site_url'])
                                . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));
                        }
                    }

                    break;

                case 'dbcontent':
                    require_once $_CONF['path_system'] . 'lib-database.php';

                    // we need the following information
                    $has_config = false;
                    $db_connection_charset = '';
                    $DB['table_prefix'] = '';

                    // get table prefix and check for conf_values table
                    $result = DB_query("SHOW TABLES");
                    $num_tables = DB_numRows($result);

                    for ($i = 0; $i < $num_tables; $i++) {
                        list($table) = DB_fetchArray($result);

                        if (substr($table, -6) === 'access') {
                            $DB['table_prefix'] = substr($table, 0, -6);
                        } elseif (strpos($table, 'conf_values') !== false) {
                            $has_config = true;
                            break;
                        }
                    }

                    // try to figure out the charset
                    $result = DB_query("SHOW CREATE TABLE " . $DB['table_prefix'] . "access");
                    list(, $create) = DB_fetchArray($result);

                    if (strpos($create, 'DEFAULT CHARSET=utf8mb4') !== false) {
                        $db_connection_charset = 'utf8mb4';
                    } elseif (strpos($create, 'DEFAULT CHARSET=utf8') !== false) {
                        $db_connection_charset = 'utf8';
                    }

                    // Update db-config.php with the table prefix from the db
                    if (!$this->writeDbConfig(Common::$env['dbconfig_path'], $DB)) {
                        exit($LANG_INSTALL[26] . ' ' . Common::$env['dbconfig_path'] . $LANG_INSTALL[58]);
                    }

                    // In case of migration, we don't use either 'utf8' or 'utf8mb4'
                    if (($db_connection_charset === 'utf8') || ($db_connection_charset === 'utf8mb4')) {
                        $defaultCharset = 'utf-8';
                    } else {
                        $defaultCharset = $LANG_CHARSET;
                    }

                    if (!$this->setDefaultCharset(Common::$env['siteconfig_path'], $defaultCharset)) {
                        exit($LANG_INSTALL[26] . ' ' . Common::$env['siteconfig_path'] . $LANG_INSTALL[58]);
                    }

                    // skip step 3 since we don't need to import anything
                    header('Location: index.php?mode=migrate&step=4&language=' . Common::$env['language']
                        . '&site_url=' . urlencode($_REQUEST['site_url'])
                        . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));
                    break;
            } // End switch ($_REQUEST['migration_type']
        } else {
            // Add prompt
            Common::$env['migrate_errors'] = $display;
            $display = MicroTemplate::quick(PATH_LAYOUT, 'migrate_prompt_error', Common::$env);
        }

        return $display;

    }

    /**
     * Migrate page 3 - Gets the database table prefix from the database file.
     * Overwrites an existing database file if requested by the user.
     * Sends the database filename (and a few other variables)
     * to bigdump.php, which performs the import.
     */
    public function step3()
    {
        global $LANG_INSTALL, $LANG_MIGRATE, $LANG_CHARSET;

        $display = '';

        $gl_path = str_replace(self::DB_CONFIG_FILE, '', Common::$env['dbconfig_path']);
        $backup_dir = $gl_path . 'backups/';
        // Get the backup filename
        $backupFile = $_REQUEST['backup_file'];

        // If the user chose to overwrite an existing backup file
        if (isset($_REQUEST['overwrite_file'])) {
            // Overwrite the old file with the new file.
            rename($backup_dir . str_replace('.sql', '_uploaded.sql', $backupFile), $backup_dir . $backupFile);
        }

        $unpacked_file = $this->unpackFile($backup_dir, $backupFile, $display);

        if ($unpacked_file !== false) {
            $backupFile = $unpacked_file;

            // Parse the .sql file to grab the table prefix
            $has_config = false;
            $num_create = 0;
            $db_connection_charset = '';
            $DB['table_prefix'] = '';

            $sql_file = @fopen($backup_dir . $backupFile, 'r');

            if (!$sql_file) {
                // "This shouldn't happen" - just unpacked and now it's gone?
                exit(sprintf($LANG_MIGRATE[42], $backup_dir . $backupFile));
            }

            while (!feof($sql_file)) {
                $line = @fgets($sql_file);

                if (!empty($line)) {
                    if (preg_match('/CREATE TABLE/i', $line)) {
                        $num_create++;
                        $line = trim($line);

                        if (strpos($line, 'access') !== false) {
                            $line = str_replace('IF NOT EXISTS ', '', $line);
                            $words = explode(' ', $line);

                            if (count($words) >= 3) {
                                $table = str_replace('`', '', $words[2]);

                                if (substr($table, -6) === 'access') {
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
                    } elseif (substr($line, 0, 3) === '/*!') {
                        if ((strpos($line, 'SET NAMES utf8mb4') !== false) || (strpos($line, 'SET NAMES utf8') !== false)) {
                            $db_connection_charset = 'utf-8';
                        }
                    } elseif (empty($db_connection_charset) && strpos($line, 'ENGINE=') !== false) {
                        if ((strpos($line, 'DEFAULT CHARSET=utf8mb4') !== false) || (strpos($line, 'DEFAULT CHARSET=utf8') !== false)) {
                            $db_connection_charset = 'utf-8';
                        }
                    }
                }
            }

            fclose($sql_file);

            if ($num_create <= 1) {
                // this doesn't look like an SQL dump ...
                $display .= $this->getAlertMsg(sprintf($LANG_MIGRATE[43], $backupFile));
            } else {
                // Update db-config.php with the table prefix from the backup file.
                if (!$this->writeDbConfig(Common::$env['dbconfig_path'], $DB)) {
                    exit($LANG_INSTALL[26] . ' ' . Common::$env['dbconfig_path'] . $LANG_INSTALL[58]);
                }

                // In case of $_CONF['default_charset'], we don't use either 'utf8' or 'utf8mb4'
                if ($db_connection_charset === 'utf-8') {
                    $defaultCharset = 'utf-8';
                } else {
                    $defaultCharset = $LANG_CHARSET;
                }

                if (!$this->setDefaultCharset(Common::$env['siteconfig_path'], $defaultCharset)) {
                    exit($LANG_INSTALL[26] . ' ' . Common::$env['siteconfig_path'] . $LANG_INSTALL[58]);
                }

                // Send file to bigdump.php script to do the import.
                header('Location: bigdump.php?start=1&foffset=0&totalqueries=0'
                    . '&db_connection_charset=' . $db_connection_charset
                    . '&language=' . Common::$env['language']
                    . '&fn=' . urlencode($backup_dir . $backupFile)
                    . '&site_url=' . urlencode($_REQUEST['site_url'])
                    . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));
            }
        } else {
            // No SQL file found
            $backLink = 'index.php?'
                . http_build_query([
                    'mode'     => 'migrate',
                    'language' => $this->getLanguage(),
                ]);
            exit($this->getAlertMsg(sprintf($LANG_MIGRATE[40], $backupFile, $backLink)));
        }
    }

    /**
     * Page 4 - Post-import operations
     * Update the database, if necessary. Then check for missing plugins,
     * incorrect paths, and other required Geeklog files
     */
    public function step4()
    {
        global $_CONF, $_DB_dbms, $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix,
               $_TABLES, $LANG_INSTALL, $LANG_MIGRATE, $_URL, $_DEVICE;

        if (empty(Common::$env['dbconfig_path'])) {
            Common::$env['dbconfig_path'] = $_CONF['path'] . 'db-config.php';
        }

        $this->includeConfig(Common::$env['dbconfig_path']);
        require_once $_CONF['path_system'] . 'lib-database.php';
        require_once $_CONF['path_system'] . 'classes/Autoload.php';
        Autoload::initialize();

        $display = '';
        $upgrade_error = false;
        $version = $this->identifyGeeklogVersion();

        if ($version === 'empty') {
            // "This shouldn't happen"
            $display .= $this->getAlertMsg($LANG_MIGRATE[44]);
            $upgrade_error = true;
        } elseif (empty($version)) {
            $display .= $this->getAlertMsg($LANG_MIGRATE[45]);
            // TBD: add a link back to the install script, preferably a direct link to the upgrade screen
            $upgrade_error = true;
        } elseif ($version != self::GL_VERSION) {
            $use_innodb = false;

            if (DB_checkTableExists('vars')) {
                $db_engine = DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'");
            } else {
                $db_engine = '';
            }

            if ($db_engine === 'InnoDB') {
                // we've migrated, probably to a different server
                // - so check InnoDB support again
                if (DB_innoDbSupported()) {
                    $use_innodb = true;
                } else {
                    // no InnoDB support on this server
                    DB_delete($_TABLES['vars'], 'name', 'database_engine');
                }
            }

            // Check for any upgrade info and/or warning messages for specific upgrade path. Skip if continued has been clicked already
            if ($this->post('upgrade_check') !== 'confirmed') {
                $retval = $this->checkUpgradeMessage($version);
                if (!empty($retval)) {
                    return $retval;
                }
            }

            if (!$this->doDatabaseUpgrades($version)) {
                $display .= $this->getAlertMsg(sprintf($LANG_MIGRATE[47], $version, self::GL_VERSION));
                $upgrade_error = true;
            }
        }

        if ($upgrade_error) {
            $display .= <<<HTML
                <br><br>
                </div>
                </div>
                </body>
                </html>
HTML;
            echo $display;
            exit;
        }

        /**
         * Let's assume that the paths that were imported from the backup are
         * incorrect and update them with the current paths.
         * Note: When updating the config settings in the database, we also
         *       need to fix the $_CONF values. We can _not_ simply reload
         *       them via get_config('Core') here yet.
         */
        $html_path = Common::$env['html_path'];

        $config = config::get_instance();
        $config->initConfig();

        // save a copy of the old config
        $_OLD_CONF = $config->get_config('Core');

        $_CONF['site_url'] = urldecode(urldecode(Input::get('site_url', Input::post('site_url', ''))));
        $config->set('site_url', $_CONF['site_url']);
        $_CONF['site_admin_url'] = urldecode(Input::get('site_admin_url', Input::post('site_admin_url', '')));
        $config->set('site_admin_url', $_CONF['site_admin_url']);
        $_CONF['path_html'] = $html_path;
        $config->set('path_html', $html_path);
        $_CONF['path_log'] = $_CONF['path'] . 'logs/';
        $config->set('path_log', $_CONF['path_log']);
        $_CONF['path_language'] = $_CONF['path'] . 'language/';
        $config->set('path_language', $_CONF['path_language']);
        $_CONF['backup_path'] = $_CONF['path'] . 'backups/';
        $config->set('backup_path', $_CONF['backup_path']);
        $_CONF['path_data'] = $_CONF['path'] . 'data/';
        $config->set('path_data', $_CONF['path_data']);
        $_CONF['path_images'] = $html_path . 'images/';
        $config->set('path_images', $_CONF['path_images']);
        $_CONF['path_themes'] = $html_path . 'layout/';
        $config->set('path_themes', $_CONF['path_themes']);
        $_CONF['path_editors'] = $html_path . 'editors/';
        $config->set('path_editors', $_CONF['path_editors']);
        $_CONF['rdf_file'] = $html_path . 'backend/geeklog.rss';
        $config->set('rdf_file', $_CONF['rdf_file']);

        // reset cookie domain and path as wrong values may prevent login
        $_CONF['cookiedomain'] = '';
        $config->set('cookiedomain', $_CONF['cookiedomain']);
        $_CONF['cookie_path'] = $this->guessCookiePath($_CONF['site_url']);
        $config->set('cookie_path', $_CONF['cookie_path']);

        if (substr($_CONF['site_url'], 0, 6) === 'https:') {
            $config->set('cookiesecure', true);
            $_CONF['cookiesecure'] = 1;
        } else {
            $config->set('cookiesecure', false);
            $_CONF['cookiesecure'] = 0;
        }

        // check the default theme
        if (empty($_CONF['theme'])) {
            // try old conf value
            $theme = $_OLD_CONF['theme'];
        } else {
            $theme = $_CONF['theme'];
        }

        // All themes require a functions.php (ie child themes don't require any template files) so check for that
        // At some point could actually check for min geeklog version of theme theme_gl_version which was introduced in Geeklog v2.2.1
        if (!file_exists($_CONF['path_themes'] . $theme . '/functions.php')) {
            // make sure default theme exists before setting config
            if (file_exists($_CONF['path_themes'] . self::DEFAULT_THEME . '/index.thtml')) {
                $config->set('theme', self::DEFAULT_THEME);
                $_CONF['theme'] = self::DEFAULT_THEME;
            }
        }

        // set noreply_mail when updating from an old version
        if (empty($_CONF['noreply_mail']) && !empty($_CONF['site_mail'])) {
            $_CONF['noreply_mail'] = $_CONF['site_mail'];
            $config->set('noreply_mail', $_CONF['noreply_mail']);
        }

        if (!empty($_OLD_CONF['ip_lookup'])) {
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
        $_MISSING_PLUGINS = [];

        // Query {$_TABLES['plugins']} to get a list of installed plugins
        $missing_plugins = 0;
        $result = DB_query("SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
        $num_plugins = DB_numRows($result);

        for ($i = 0; $i < $num_plugins; $i++) { // Look in the plugins directories to ensure that those plugins exist.
            $plugin = DB_fetchArray($result);

            if (!file_exists($_CONF['path'] . 'plugins/' . $plugin['pi_name'])) { // If plugin does not exist
                // Deactivate the plugin
                DB_query("UPDATE {$_TABLES['plugins']} SET pi_enabled='0' WHERE pi_name='{$plugin['pi_name']}'");
                $_MISSING_PLUGINS[] = $plugin['pi_name'];
                $missing_plugins++;
            }
        }

        // Any missing plugins have been disabled, now we can get lib-common.php
        // so we can call COM_errorLog().
        require_once $html_path . 'lib-common.php';

        // including lib-common.php overwrites our $language variable
        $language = Common::$env['language'];

        // Log any missing plugins
        if (count($_MISSING_PLUGINS) > 0) {
            foreach ($_MISSING_PLUGINS as $m_p) {
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[27] . $m_p . $LANG_MIGRATE[28]);
            }
        }

        $disabled_plugins = 0;

        if ($version != self::GL_VERSION) {
            // We did a database upgrade above. Now that any missing plugins
            // have been disabled and we've loaded lib-common.php, perform
            // upgrades for the remaining plugins.
            $disabled_plugins = $this->pluginUpgrades(true, $_OLD_CONF);
        }

        // finally, check for any new plugins and install them
        //        $this->autoInstallNewPlugins();

        /**
         * Check for other missing files
         * e.g. images/articles, images/topics, images/userphotos
         */
        clearstatcache();
        $missing_images = false;

        // Article images
        $missing_article_images = false;
        $result = DB_query("SELECT `ai_filename` FROM {$_TABLES['article_images']}");
        $num_article_images = DB_numRows($result);

        for ($i = 0; $i < $num_article_images; $i++) {
            $article_image = DB_fetchArray($result, false); //

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
            $topic_image = DB_fetchArray($result, false);

            // Topic image stores part of the path
            if (!file_exists($html_path . $topic_image['imageurl'])) { // If topic image does not exist
                // Log the error
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[29] . $topic_image['imageurl'] . $LANG_MIGRATE[30] . $_TABLES['topics'] . $LANG_MIGRATE[31] . $html_path . 'images/topics/');
                $missing_topic_images = true;
                $missing_images = true;
            }
        }

        // Userphoto images
        $missing_userphoto_images = false;
        $result = DB_query("SELECT `photo` FROM {$_TABLES['users']} WHERE `photo` IS NOT NULL AND `photo` <> ''");
        $num_userphoto_images = DB_numRows($result);

        for ($i = 0; $i < $num_userphoto_images; $i++) {
            $userphoto_image = DB_fetchArray($result, false);

            if (!file_exists($html_path . 'images/userphotos/' . $userphoto_image['photo'])) { // If userphoto image does not exist
                // Log the error
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[29] . $userphoto_image['photo'] . $LANG_MIGRATE[30] . $_TABLES['users'] . $LANG_MIGRATE[31] . $html_path . 'images/userphotos/');
                $missing_userphoto_images = true;
                $missing_images = true;
            }
        }

        // did the site URL change?
        if ((!empty($_OLD_CONF['site_url'])) & (!empty($_CONF['site_url'])) && ($_OLD_CONF['site_url'] != $_CONF['site_url'])) {
            self::updateSiteUrl($_OLD_CONF['site_url'], $_CONF['site_url']);
        }

        // Clear the Geeklog Cache in case paths etc. in cache files
        $this->clearCache();

        /**
         * Import complete.
         */

        // Check if there are any missing files or plugins
        if ($missing_images || ($missing_plugins > 0) || ($disabled_plugins > 0)) {
            $display .= '<h2>' . $LANG_MIGRATE[37] . '</h2>' . PHP_EOL
                . '<p>' . $LANG_MIGRATE[38] . '</p>' . PHP_EOL;
            // Plugins
            if ($missing_plugins > 0) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[32] . ' <code>' . $_CONF['path'] . 'plugins/</code> ' . $LANG_MIGRATE[33], 'notice');
            }

            if ($disabled_plugins > 0) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[48]);
            }

            // Article images
            if ($missing_article_images) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[34] . ' <code>' . $html_path . 'images/articles/</code> ' . $LANG_MIGRATE[35], 'notice');
            }

            // Topic images
            if ($missing_topic_images) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[34] . ' <code>' . $html_path . 'images/topics/</code> ' . $LANG_MIGRATE[35], 'notice');
            }

            // Userphoto images
            if ($missing_userphoto_images) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[34] . ' <code>' . $html_path . 'images/userphotos/</code> ' . $LANG_MIGRATE[35], 'notice');
            }

            $display .= '<p>' . $LANG_MIGRATE[36] . '</p>' . PHP_EOL
                . '<form action="success.php" method="get">' . PHP_EOL
                . '<input type="hidden" name="type" value="migrate">' . PHP_EOL
                . '<input type="hidden" name="language" value="' . $language . '">' . PHP_EOL
                . '<input type="hidden" name="" value="">' . PHP_EOL
                . '<button type="submit" class="uk-button uk-button-primary uk-margin-small" name="" value="' . $LANG_INSTALL[62] . '">' . $LANG_INSTALL[62] . '&nbsp;&nbsp;' . Common::$env['icon_arrow_next'] . '</button>' . PHP_EOL
                . '</form>';
        } else {
            header('Location: success.php?type=migrate&language=' . $language);
        }

        return $display;
    }
}
