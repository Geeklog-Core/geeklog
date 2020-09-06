<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | bigdump.php                                                               |
// |                                                                           |
// | Staggered import for large MySQL Dumps                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Alexey Ozerov    - alexey AT ozerov DOT de (BigDump author)      |
// |          Matt West        - matt.danger.west AT gmail DOT com             |
// |          Rouslan Placella - rouslan AT placella DOT com                   |
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
// BigDump ver. 0.29b from 2008-01-19
// Staggered import of an large MySQL Dump (like phpMyAdmin 2.x Dump)
// Even through the webservers with hard runtime limit and those in safe mode
// Works fine with Internet Explorer 7.0 and Firefox 2.x
//
// Author:       Alexey Ozerov (alexey at ozerov dot de)
//               AJAX & CSV functionalities: Krzysiek Herod (kr81uni at wp dot pl)
// Copyright:    GPL (C) 2003-2008
// More Infos:   http://www.ozerov.de/bigdump.php
//
// THIS SCRIPT IS PROVIDED AS IS, WITHOUT ANY WARRANTY OR GUARANTEE OF ANY KIND
//

/**
 * Replaces all newlines in a string with <br> or <br />,
 * depending on the detected setting.  Ported from "lib-common.php"
 *
 * @param  string  $string  The string to modify
 * @return  string         The modified string
 */
function myNl2br($string)
{
    return str_replace(["\r\n", "\n\r", "\r", "\n"], '<br>', $string);
}

define('GL_INSTALL_ACTIVE', true);
define('PATH_INSTALL', __DIR__ . '/');
define('PATH_LAYOUT', PATH_INSTALL . 'layout');
define('BASE_FILE', str_replace('\\', '/', __FILE__));

global $_CONF, $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_charset,
       $LANG_BIGDUMP, $LANG_CHARSET, $LANG_DIRECTION, $LANG_ERROR, $LANG_HELP, $LANG_INSTALL,
       $LANG_LABEL, $LANG_MIGRATE, $LANG_PLUGINS, $LANG_RESCUE, $LANG_SUCCESS;

require_once __DIR__ . '/classes/micro_template.class.php';
require_once __DIR__ . '/classes/installer.class.php';
require_once __DIR__ . '/classes/db.class.php';
require_once __DIR__ . '/../../siteconfig.php';
require_once $_CONF['path'] . 'db-config.php';

// Set PHP error reporting
if ((isset($_CONF['developer_mode']) && ($_CONF['developer_mode'] === true)) &&
    isset($_CONF['developer_mode_php'], $_CONF['developer_mode_php']['error_reporting'])) {
    error_reporting((int) $_CONF['developer_mode_php']['error_reporting']);
} else {
    // Same setting as Geeklog - Prevent PHP from reporting uninitialized variables
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR);
}

$installer = new Installer();

$db_server = $_DB_host;
$db_name = $_DB_name;
$db_username = $_DB_user;
$db_password = $_DB_pass;

// Other settings (optional)
$filename = '';     // Specify the dump filename to suppress the file selection dialog
$linesPerSession = 3000;   // Lines to be executed per one import session
$delayPerSession = 0;      // You can specify a sleep time in milliseconds after each session
// Works only if JavaScript is activated. Use to reduce server overrun

// Allowed comment delimiters: lines starting with these strings will be dropped by BigDump
$comment[] = '#';                       // Standard comment lines are dropped by default
$comment[] = '-- ';
// $comment[]='---';                  // Uncomment this line if using proprietary dump created by outdated mysqldump
// $comment[]='CREATE DATABASE';      // Uncomment this line if your dump contains create database queries in order to ignore them
$comment[] = '/*!';                     // Or add your own string to leave out other proprietary things
// see http://project.geeklog.net/tracking/view.php?id=955
$comment[] = 'SET character_set_client = @saved_cs_client;';

// Connection character set should be the same as the dump file character set (utf8, latin1, cp1251, koi8r etc.)
// See http://dev.mysql.com/doc/refman/5.0/en/charset-charsets.html for the full list
$db_connection_charset = '';
if (isset($_REQUEST['db_connection_charset'])) {
    $db_connection_charset = preg_replace('/[^a-z0-9\-_]/', '', $_REQUEST['db_connection_charset']);
}

// *******************************************************************************************
// If not familiar with PHP please don't change anything below this line
// *******************************************************************************************

//define ('VERSION','0.32b');
define('DATA_CHUNK_LENGTH', 16384);  // How many chars are read per time
define('MAX_QUERY_LINES', 300);      // How many lines may be considered to be one query (except text lines)
define('TESTMODE', false);           // Set to true to process the file without actually accessing the database
@ini_set('auto_detect_line_endings', true);
@set_time_limit(0);

if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get")) {
    @date_default_timezone_set(@date_default_timezone_get());
}

$content = '<h1>' . $LANG_MIGRATE[17] . '</h1>' . PHP_EOL;

$error = false;
$file = false;

// Check if mysql extension is available
$availableDrivers = Geeklog\Db::getDrivers();

if (!$error && (count($availableDrivers) === 0)) {
    $content .= '<p>' . $LANG_BIGDUMP[11] . '</p>' . PHP_EOL;
    $error = true;
}

// Get the current directory
$upload_dir = __DIR__;

// Connect to the database
$db = false;
$dbConnection = false;
$errorMessage = '';
$args = [
    'host'    => $_DB_host,
    'user'    => $_DB_user,
    'pass'    => $_DB_pass,
    'name'    => $_DB_name,
    'charset' => $db_connection_charset,
];

if (!$error && !TESTMODE) {
    try {
        $dbConnection = Geeklog\Db::connect(Geeklog\Db::DB_MYSQLI, $args);
        $db = true;
    } catch (Exception $e) {
        try {
            $dbConnection = Geeklog\Db::connect(Geeklog\Db::DB_MYSQL, $args);
            $db = true;
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $dbConnection = false;
        }
    }

    if (empty($dbConnection) || !$db) {
        $content .= $installer->getAlertMsg($LANG_ERROR[9] . $errorMessage . '<br>' . $LANG_ERROR[10]);
        $error = true;
    }
} else {
    $dbConnection = false;
}

// Single file mode
if (!$error && !isset($_REQUEST["fn"]) && $filename != "") {
    $content .= '<p><a href="' . $_SERVER['PHP_SELF'] . '?start=1&fn=' . urlencode($filename) . '&foffset=0&totalqueries=0\">' . $LANG_BIGDUMP[0] . '</a>' . $LANG_BIGDUMP[1] . $filename . $LANG_BIGDUMP[2] . $db_name . $LANG_BIGDUMP[3] . $db_server . PHP_EOL;
}

// Open the file
if (!$error && isset($_REQUEST["start"])) {
    // Set current filename ($filename overrides $_REQUEST["fn"] if set)
    if ($filename != '') {
        $currentFileName = $filename;
    } elseif (isset($_REQUEST["fn"])) {
        $currentFileName = urldecode($_REQUEST["fn"]);
    } else {
        $currentFileName = '';
    }

    // Recognize GZip filename
    if (preg_match('/\.gz$/i', $currentFileName)) {
        $gzipMode = true;
    } else {
        $gzipMode = false;
    }

    if ((!$gzipMode && !$file = @fopen($currentFileName, "r")) || ($gzipMode && !$file = @gzopen($currentFileName, "r"))) {
        $content .= $installer->getAlertMsg($LANG_BIGDUMP[5] . $currentFileName . $LANG_BIGDUMP[6]);
        $error = true;
    } elseif ((!$gzipMode && @fseek($file, 0, SEEK_END) == 0) || ($gzipMode && @gzseek($file, 0) == 0)) {
        // Get the file size (can't do it fast on gzipped files, no idea how)
        if (!$gzipMode) {
            $fileSize = ftell($file);
        } else {
            $fileSize = gztell($file);  // Always zero, ignore
        }
    } else {
        $content .= $installer->getAlertMsg($LANG_BIGDUMP[4] . $currentFileName);
        $error = true;
    }
}

// *******************************************************************************************
// START IMPORT SESSION HERE
// *******************************************************************************************

// Figure out back url for any errors
// $backUrl = 'index.php?mode=migrate'; // doesn't work so return them to main install page
$error_gobackUrl = 'index.php';
$site_url = isset($_REQUEST['site_url']) ? $_REQUEST['site_url'] : '';
$site_admin_url = isset($_REQUEST['site_admin_url']) ? $_REQUEST['site_admin_url'] : '';
$language = $installer->getLanguage();

if (!empty($language)) {
    $error_gobackUrl .= '?language=' . $language;
}

if (!$error && isset($_REQUEST["start"]) && isset($_REQUEST["foffset"]) && preg_match('/(\.(sql|gz))$/i', $currentFileName)) {
    // Check start and foffset are numeric values
    if (!is_numeric($_REQUEST["start"]) || !is_numeric($_REQUEST["foffset"])) {
        $content .= $installer->getAlertMsg($LANG_BIGDUMP[7]);
        $error = true;
    }

    if (!$error) {
        $_REQUEST["start"] = floor($_REQUEST["start"]);
        $_REQUEST["foffset"] = floor($_REQUEST["foffset"]);
        $content .= '<p>' . $LANG_BIGDUMP[8] . ' <b>' . $currentFileName . '</b></p>' . PHP_EOL;
    }

    // Check $_REQUEST["foffset"] upon $fileSize (can't do it on gzipped files)
    if (!$error && !$gzipMode && $_REQUEST["foffset"] > $fileSize) {
        $content .= $installer->getAlertMsg($LANG_BIGDUMP[9]);
        $error = true;
    }

    // Set file pointer to $_REQUEST["foffset"]
    if (!$error && ((!$gzipMode && fseek($file, $_REQUEST["foffset"]) != 0) || ($gzipMode && gzseek($file, $_REQUEST["foffset"]) != 0))) {
        $content .= $installer->getAlertMsg($LANG_BIGDUMP[10] . $_REQUEST["foffset"]);
        $error = true;
    }

    // Start processing queries from $file
    if (!$error) {
        $query = "";
        $queries = 0;
        $totalQueries = $_REQUEST["totalqueries"];
        $lineNumber = $_REQUEST["start"];
        $queryLines = 0;
        $inParents = false;

        // Stay processing as long as the $linesPerSession is not reached or the query is still incomplete
        while ($lineNumber < $_REQUEST["start"] + $linesPerSession || $query != "") {
            // Read the whole next line
            $dumpLine = "";

            while (!feof($file) && substr($dumpLine, -1) != "\n") {
                if (!$gzipMode) {
                    $dumpLine .= fgets($file, DATA_CHUNK_LENGTH);
                } else {
                    $dumpLine .= gzgets($file, DATA_CHUNK_LENGTH);
                }
            }

            if ($dumpLine === '') {
                break;
            }

            // Handle DOS and Mac encoded linebreaks (I don't know if it will work on Win32 or Mac Servers)
            $dumpLine = str_replace("\r\n", "\n", $dumpLine);
            $dumpLine = str_replace("\r", "\n", $dumpLine);

            // Skip comments and blank lines only if NOT in parents
            if (!$inParents) {
                $skipLine = false;
                reset($comment);

                foreach ($comment as $comment_value) {
                    if (!$inParents && (trim($dumpLine) == "" || strpos($dumpLine, $comment_value) === 0)) {
                        $skipLine = true;
                        break;
                    }
                }

                if ($skipLine) {
                    $lineNumber++;
                    continue;
                }
            }

            // Remove double back-slashes from the dumpline prior to count the quotes ('\\' can only be within strings)
            $dumpLine_deslashed = str_replace("\\\\", "", $dumpLine);

            // Count ' and \' in the dumpline to avoid query break within a text field ending by ;
            // Please don't use double quotes ('"')to surround strings, it wont work
            $parents = substr_count($dumpLine_deslashed, "'") - substr_count($dumpLine_deslashed, "\\'");
            if ($parents % 2 != 0) {
                $inParents = !$inParents;
            }

            // Add the line to query
            $query .= $dumpLine;

            // Don't count the line if in parents (text fields may include unlimited linebreaks)
            if (!$inParents) {
                $queryLines++;
            }

            // Stop if query contains more lines as defined by MAX_QUERY_LINES
            if ($queryLines > MAX_QUERY_LINES) {
                $content .= $installer->getAlertMsg($LANG_BIGDUMP[14] . $lineNumber . $LANG_BIGDUMP[15] . MAX_QUERY_LINES . $LANG_BIGDUMP[16]);
                $error = true;
                break;
            }

            // Execute query if end of query detected (; as last character) AND NOT in parents
            if (preg_match("/;$/", trim($dumpLine)) && !$inParents) {
                if (!TESTMODE) {
                    if ($dbConnection->query(trim($query)) === false) {
                        $content .= $installer->getAlertMsg(
                            $LANG_BIGDUMP[17] . $lineNumber . ': ' . trim($dumpLine) . '.<br ' . PHP_EOL . '>'
                            . $LANG_BIGDUMP[18] . trim(myNl2br(htmlentities($query))) . '<br ' . PHP_EOL . '>'
                            . $LANG_BIGDUMP[19] . $dbConnection->error()
                        );
                        $error = true;
                        break;
                    }

                    $totalQueries++;
                    $queries++;
                    $query = "";
                    $queryLines = 0;
                }

                $lineNumber++;
            }
        }

        // Get the current file position
        if (!$error) {
            if (!$gzipMode) {
                $fOffset = ftell($file);
            } else {
                $fOffset = gztell($file);
            }

            if (!$fOffset) {
                $content .= $installer->getAlertMsg($LANG_BIGDUMP[20]);
                $error = true;
            }
        }

        // Print statistics
        if (!$error) {
            $lines_this = $lineNumber - $_REQUEST["start"];
            $lines_done = $lineNumber - 1;
            $lines_togo = ' ? ';
            $lines_tota = ' ? ';

            $queries_this = $queries;
            $queries_done = $totalQueries;
            $queries_togo = ' ? ';
            $queries_tota = ' ? ';

            $bytes_this = $fOffset - $_REQUEST["foffset"];
            $bytes_done = $fOffset;
            $kbytes_this = round($bytes_this / 1024, 2);
            $kbytes_done = round($bytes_done / 1024, 2);
            $mbytes_this = round($kbytes_this / 1024, 2);
            $mbytes_done = round($kbytes_done / 1024, 2);

            if (!$gzipMode) {
                $bytes_togo = $fileSize - $fOffset;
                $bytes_tota = $fileSize;
                $kbytes_togo = round($bytes_togo / 1024, 2);
                $kbytes_tota = round($bytes_tota / 1024, 2);
                $mbytes_togo = round($kbytes_togo / 1024, 2);
                $mbytes_tota = round($kbytes_tota / 1024, 2);

                $pct_this = ceil($bytes_this / $fileSize * 100);
                $pct_done = ceil($fOffset / $fileSize * 100);
                $pct_togo = 100 - $pct_done;
                $pct_tota = 100;

                if ($bytes_togo == 0) {
                    $lines_togo = '0';
                    $lines_tota = $lineNumber - 1;
                    $queries_togo = '0';
                    $queries_tota = $totalQueries;
                }

                $pct_bar = '<progress class="uk-progress" value="' . $pct_done . '" max="100"></progress>';
            } else {
                $bytes_togo = ' ? ';
                $bytes_tota = ' ? ';
                $kbytes_togo = ' ? ';
                $kbytes_tota = ' ? ';
                $mbytes_togo = ' ? ';
                $mbytes_tota = ' ? ';

                $pct_this = ' ? ';
                $pct_done = ' ? ';
                $pct_togo = ' ? ';
                $pct_tota = 100;
                $pct_bar = str_replace(' ', '&nbsp;', '<tt>[         ' . $LANG_BIGDUMP[21] . '          ]</tt>');
            }

            $content .= '' . $LANG_BIGDUMP[22] . ': ' . $pct_done . '% ' . $pct_bar . PHP_EOL;

            // Finish message and restart the script
            if ($lineNumber < $_REQUEST["start"] + $linesPerSession) {
                $content .= $installer->getAlertMsg($LANG_BIGDUMP[23], 'success');
                /*** Go back to Geeklog installer ***/
                $url = 'index.php?mode=migrate&step=4'
                            . '&language=' . urlencode($installer->getLanguage())
                            . '&site_url=' . urlencode($_REQUEST['site_url'])
                            . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']);

                $content .= "<script>
                    window.setTimeout(function () {
                        window.location.href=\""
                            . $url . "\";
                    }, 3000); // Wait 3 seconds before redirect
                </script>\n";

                // Add button since above javascript settimeout function doesn't seem to work in development enviroment for Firefox for some reason (at least in 2019)
                $content .= '<button class="uk-button uk-button-primary uk-margin-small" onClick="location.href=' . "'" . $url . "'" . '">' . $LANG_INSTALL[62] . '</button>';

            } else {
                if ($delayPerSession != 0) {
                    $content .= '<p><b>' . $LANG_BIGDUMP[24] . $delayPerSession . $LANG_BIGDUMP[25] . PHP_EOL;
                }

                // Go to the next step
                $content .= '<script language="JavaScript" type="text/javascript">window.setTimeout(\'location.href="'
                    . $_SERVER['PHP_SELF'] . '?start=' . $lineNumber . '&fn='
                    . urlencode($currentFileName) . '&foffset=' . $fOffset . '&totalqueries=' . $totalQueries . '&db_connection_charset=' . $db_connection_charset . '&language=' . $language . '&site_url=' . $site_url . '&site_admin_url=' . $site_admin_url . '";\',500+' . $delayPerSession . ');</script>' . PHP_EOL
                    . '<noscript>' . PHP_EOL
                    . ' <p><a href="' . $_SERVER['PHP_SELF'] . '?start=' . $lineNumber . '&fn=' . urlencode($currentFileName) . '&foffset=' . $fOffset . '&totalqueries=' . $totalQueries . '&db_connection_charset=' . $db_connection_charset . '&language=' . $language . '&site_url=' . $site_url . '&site_admin_url=' . $site_admin_url . '">Continue from the line ' . $lineNumber . '</a></p>' . PHP_EOL
                    . '</noscript>' . PHP_EOL
                    . '<p><strong><a href="' . $error_gobackUrl . '">' . $LANG_BIGDUMP[26] . '</a></strong> ' . $LANG_BIGDUMP[27] . ' <strong>' . $LANG_BIGDUMP[28] . '</strong></p>' . PHP_EOL;
            }
        } else {
            $content .= $installer->getAlertMsg($LANG_BIGDUMP[29]);
        }
    }
}

// If there was an error, we offer a link to retry migration
if ($error) {
    $error_gobackUrl .= '&site_url=' . urlencode($site_url) . '&site_admin_url=' . urlencode($site_admin_url);
    $content .= '<p><a class="uk-button uk-button-primary" href="' . $error_gobackUrl . '">' . $LANG_BIGDUMP[30] . '</a></p><p>'
        . $LANG_BIGDUMP[31] . '</p>' . PHP_EOL;
}

if ($file && !$gzipMode) {
    fclose($file);
} elseif ($file && $gzipMode) {
    gzclose($file);
}

$installer->display($content);
