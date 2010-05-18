<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
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

require_once '../../siteconfig.php';
// Database configuration
require_once $_CONF['path'] . 'db-config.php';
require_once 'lib-install.php';
$db_server   = $_DB_host;
$db_name     = $_DB_name;
$db_username = $_DB_user;
$db_password = $_DB_pass;

$site_url    = (isset($_REQUEST['site_url']) ? $_REQUEST['site_url'] : '');
$site_admin_url   = (isset($_REQUEST['site_admin_url']) ? $_REQUEST['site_admin_url'] : '');

// Other settings (optional)
$filename         = '';     // Specify the dump filename to suppress the file selection dialog
$linespersession  = 3000;   // Lines to be executed per one import session
$delaypersession  = 0;      // You can specify a sleep time in milliseconds after each session
                            // Works only if JavaScript is activated. Use to reduce server overrun

// Allowed comment delimiters: lines starting with these strings will be dropped by BigDump
$comment[]='#';                       // Standard comment lines are dropped by default
$comment[]='-- ';
// $comment[]='---';                  // Uncomment this line if using proprietary dump created by outdated mysqldump
// $comment[]='CREATE DATABASE';      // Uncomment this line if your dump contains create database queries in order to ignore them
$comment[]='/*!';                     // Or add your own string to leave out other proprietary things
// see http://project.geeklog.net/tracking/view.php?id=955
$comment[]='SET character_set_client = @saved_cs_client;';

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
define ('DATA_CHUNK_LENGTH',16384);  // How many chars are read per time
define ('MAX_QUERY_LINES',300);      // How many lines may be considered to be one query (except text lines)
define ('TESTMODE',false);           // Set to true to process the file without actually accessing the database
@ini_set('auto_detect_line_endings', true);
@set_time_limit(0);

if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get"))
  @date_default_timezone_set(@date_default_timezone_get());

header('Content-Type: text/html; charset=' . $LANG_CHARSET);
echo INST_getHeader($LANG_MIGRATE[17]);

$error = false;
$file  = false;

// Check if mysql extension is available
if (!$error && !function_exists('mysql_connect')) {
  echo '<p>' . $LANG_BIGDUMP[11] . '</p>' . LB;
  $error=true;
}

// Get the current directory
if (isset($_SERVER["CGIA"]))
  $upload_dir=dirname($_SERVER["CGIA"]);
else if (isset($_SERVER["ORIG_PATH_TRANSLATED"]))
  $upload_dir=dirname($_SERVER["ORIG_PATH_TRANSLATED"]);
else if (isset($_SERVER["ORIG_SCRIPT_FILENAME"]))
  $upload_dir=dirname($_SERVER["ORIG_SCRIPT_FILENAME"]);
else if (isset($_SERVER["PATH_TRANSLATED"]))
  $upload_dir=dirname($_SERVER["PATH_TRANSLATED"]);
else 
  $upload_dir=dirname($_SERVER["SCRIPT_FILENAME"]);


// Connect to the database
if (!$error && !TESTMODE) {
  $dbconnection = @mysql_connect($db_server,$db_username,$db_password);
  if ($dbconnection) 
    $db = mysql_select_db($db_name);
  if (!$dbconnection || !$db) {
    echo INST_getAlertMsg($LANG_ERROR[9] . mysql_error() . '<br' . XHTML .'>' . $LANG_ERROR[10]);
    $error=true;
  }
  if (!$error && $db_connection_charset!=='')
    @mysql_query("SET NAMES $db_connection_charset", $dbconnection);
} else {
  $dbconnection = false;
}

// Single file mode
if (!$error && !isset ($_REQUEST["fn"]) && $filename!="") {
  echo '<p><a href="' . $_SERVER['PHP_SELF'] . '?start=1&amp;fn=' . urlencode($filename) . '&amp;foffset=0&amp;totalqueries=0\">' . $LANG_BIGDUMP[0] . '</a>' . $LANG_BIGDUMP[1] . $filename . $LANG_BIGDUMP[2] . $db_name . $LANG_BIGDUMP[3] . $db_server . LB;
}


// Open the file
if (!$error && isset($_REQUEST["start"])) { 
  // Set current filename ($filename overrides $_REQUEST["fn"] if set)
  if ($filename != "")
    $curfilename = $filename;
  else if (isset($_REQUEST["fn"]))
    $curfilename = urldecode($_REQUEST["fn"]);
  else
    $curfilename = "";

  // Recognize GZip filename
  if (preg_match("/\.gz$/i",$curfilename))
    $gzipmode = true;
  else
    $gzipmode = false;

  if ((!$gzipmode && !$file=@fopen($curfilename,"r")) || ($gzipmode && !$file=@gzopen($curfilename,"r"))) {
    echo INST_getAlertMsg($LANG_BIGDUMP[5] . $curfilename . $LANG_BIGDUMP[6]);
    $error = true;
  }

  // Get the file size (can't do it fast on gzipped files, no idea how)
  else if ((!$gzipmode && @fseek($file, 0, SEEK_END)==0) || ($gzipmode && @gzseek($file, 0)==0)) {
    if (!$gzipmode) $filesize = ftell($file);
    else $filesize = gztell($file);                   // Always zero, ignore
  } else {
        echo INST_getAlertMsg($LANG_BIGDUMP[4] . $curfilename);
    $error = true;
  }
}

// *******************************************************************************************
// START IMPORT SESSION HERE
// *******************************************************************************************

if (!$error && isset($_REQUEST["start"]) && isset($_REQUEST["foffset"]) && preg_match("/(\.(sql|gz))$/i",$curfilename)) {

  // Check start and foffset are numeric values
  if (!is_numeric($_REQUEST["start"]) || !is_numeric($_REQUEST["foffset"])) {
    echo INST_getAlertMsg($LANG_BIGDUMP[7]);
    $error=true;
  }

  if (!$error) {
    $_REQUEST["start"]   = floor($_REQUEST["start"]);
    $_REQUEST["foffset"] = floor($_REQUEST["foffset"]);
    echo '<p>' . $LANG_BIGDUMP[8] . ' <b>' . $curfilename . '</b></p>' . LB;
  }

  // Check $_REQUEST["foffset"] upon $filesize (can't do it on gzipped files)
  if (!$error && !$gzipmode && $_REQUEST["foffset"]>$filesize) {
    echo INST_getAlertMsg($LANG_BIGDUMP[9]);
    $error=true;
  }

  // Set file pointer to $_REQUEST["foffset"]
  if (!$error && ((!$gzipmode && fseek($file, $_REQUEST["foffset"])!=0) || ($gzipmode && gzseek($file, $_REQUEST["foffset"])!=0))) {
    echo INST_getAlertMsg($LANG_BIGDUMP[10] . $_REQUEST["foffset"]);
    $error = true;
  }

  // Start processing queries from $file
  if (!$error) {
    $query="";
    $queries=0;
    $totalqueries=$_REQUEST["totalqueries"];
    $linenumber=$_REQUEST["start"];
    $querylines=0;
    $inparents=false;

    // Stay processing as long as the $linespersession is not reached or the query is still incomplete
    while ($linenumber<$_REQUEST["start"]+$linespersession || $query!="") {

      // Read the whole next line
      $dumpline = "";
      while (!feof($file) && substr ($dumpline, -1) != "\n") {
        if (!$gzipmode)
          $dumpline .= fgets($file, DATA_CHUNK_LENGTH);
        else
          $dumpline .= gzgets($file, DATA_CHUNK_LENGTH);
      }
      if ($dumpline==="") break;

      // Handle DOS and Mac encoded linebreaks (I don't know if it will work on Win32 or Mac Servers)
      $dumpline=str_replace("\r\n", "\n", $dumpline);
      $dumpline=str_replace("\r", "\n", $dumpline);
            
      // Skip comments and blank lines only if NOT in parents
      if (!$inparents){
        $skipline=false;
        reset($comment);
        foreach ($comment as $comment_value) {
          if (!$inparents && (trim($dumpline)=="" || strpos ($dumpline, $comment_value) === 0)) {
            $skipline=true;
            break;
          }
        }
        if ($skipline) {
          $linenumber++;
          continue;
        }
      }

      // Remove double back-slashes from the dumpline prior to count the quotes ('\\' can only be within strings)
      $dumpline_deslashed = str_replace ("\\\\","",$dumpline);

      // Count ' and \' in the dumpline to avoid query break within a text field ending by ;
      // Please don't use double quotes ('"')to surround strings, it wont work
      $parents=substr_count ($dumpline_deslashed, "'")-substr_count ($dumpline_deslashed, "\\'");
      if ($parents % 2 != 0)
        $inparents=!$inparents;

      // Add the line to query
      $query .= $dumpline;

      // Don't count the line if in parents (text fields may include unlimited linebreaks)
      if (!$inparents)
        $querylines++;
      
      // Stop if query contains more lines as defined by MAX_QUERY_LINES
      if ($querylines>MAX_QUERY_LINES) {
    echo INST_getAlertMsg($LANG_BIGDUMP[14] . $linenumber . $LANG_BIGDUMP[15] . MAX_QUERY_LINES . $LANG_BIGDUMP[16]);
        $error=true;
        break;
      }

      // Execute query if end of query detected (; as last character) AND NOT in parents
      if (preg_match("/;$/",trim($dumpline)) && !$inparents) {
        if (!TESTMODE && !mysql_query(trim($query), $dbconnection)) {
          echo INST_getAlertMsg($LANG_BIGDUMP[17] . $linenumber . ': ' . trim($dumpline) . '.<br ' . XHTML . '>' . $LANG_BIGDUMP[18] . trim(nl2br(htmlentities($query))) . '<br ' . XHTML . '>' . $LANG_BIGDUMP[19] . mysql_error());
          $error=true;
          break;
        }
        $totalqueries++;
        $queries++;
        $query="";
        $querylines=0;
      }
      $linenumber++;
    }
  }

  // Get the current file position
  if (!$error) {
    if (!$gzipmode) 
      $foffset = ftell($file);
    else
      $foffset = gztell($file);
    if (!$foffset) { 
      echo INST_getAlertMsg($LANG_BIGDUMP[20]);
      $error = true;
    }
  }

// Print statistics

  if (!$error) { 
    $lines_this   = $linenumber-$_REQUEST["start"];
    $lines_done   = $linenumber-1;
    $lines_togo   = ' ? ';
    $lines_tota   = ' ? ';
    
    $queries_this = $queries;
    $queries_done = $totalqueries;
    $queries_togo = ' ? ';
    $queries_tota = ' ? ';

    $bytes_this   = $foffset-$_REQUEST["foffset"];
    $bytes_done   = $foffset;
    $kbytes_this  = round($bytes_this/1024,2);
    $kbytes_done  = round($bytes_done/1024,2);
    $mbytes_this  = round($kbytes_this/1024,2);
    $mbytes_done  = round($kbytes_done/1024,2);
   
    if (!$gzipmode) {
      $bytes_togo  = $filesize-$foffset;
      $bytes_tota  = $filesize;
      $kbytes_togo = round($bytes_togo/1024,2);
      $kbytes_tota = round($bytes_tota/1024,2);
      $mbytes_togo = round($kbytes_togo/1024,2);
      $mbytes_tota = round($kbytes_tota/1024,2);
      
      $pct_this   = ceil($bytes_this/$filesize*100);
      $pct_done   = ceil($foffset/$filesize*100);
      $pct_togo   = 100 - $pct_done;
      $pct_tota   = 100;

      if ($bytes_togo==0) 
      { $lines_togo   = '0'; 
        $lines_tota   = $linenumber-1; 
        $queries_togo = '0'; 
        $queries_tota = $totalqueries; 
      }

      $pct_bar    = "<div style=\"height:15px;width:$pct_done%;background-color:#000080;margin:0px;\"></div>";
    } else {
      $bytes_togo  = ' ? ';
      $bytes_tota  = ' ? ';
      $kbytes_togo = ' ? ';
      $kbytes_tota = ' ? ';
      $mbytes_togo = ' ? ';
      $mbytes_tota = ' ? ';
      
      $pct_this    = ' ? ';
      $pct_done    = ' ? ';
      $pct_togo    = ' ? ';
      $pct_tota    = 100;
      $pct_bar     = str_replace(' ','&nbsp;','<tt>[         ' . $LANG_BIGDUMP[21] . '          ]</tt>');
    }
    
    echo '
        <table width="650" border="0" cellpadding="3" cellspacing="1">
        <tr><th align="left" width="125">' . $LANG_BIGDUMP[22] . ': ' . $pct_done . '%</th><td colspan="4">' . $pct_bar . '</td></tr>
        </table><br' . XHTML . '>' . LB;

    // Finish message and restart the script
    if ($linenumber<$_REQUEST["start"]+$linespersession) { 
    
        echo INST_getAlertMsg($LANG_BIGDUMP[23], 'success');
        /*** Go back to Geeklog installer ***/
        echo ("<script language=\"JavaScript\" type=\"text/javascript\">window.setTimeout('location.href=\""
            . 'migrate.php?step=4'
            . '&language=' . $language
            . '&site_url=' . $_REQUEST['site_url']
            . '&site_admin_url=' . $_REQUEST['site_admin_url'] . "\";',3000);</script>\n");

    } else { 
    
        if ($delaypersession != 0) {
            echo '<p><b>' . $LANG_BIGDUMP[24] . $delaypersession . $LANG_BIGDUMP[25] . LB;
        }

        // Go to the next step
        echo '<script language="JavaScript" type="text/javascript">window.setTimeout(\'location.href="'
            . $_SERVER['PHP_SELF'] . '?start=' . $linenumber . '&fn='
            . urlencode($curfilename) . '&foffset=' . $foffset . '&totalqueries=' . $totalqueries . '&db_connection_charset=' . $db_connection_charset . '&language=' . $language . '&site_url=' . $site_url . '&site_admin_url=' . $site_admin_url . '";\',500+' . $delaypersession . ');</script>' . LB
            . '<noscript>' . LB
            . ' <p><a href="' . $_SERVER['PHP_SELF'] . '?start=' . $linenumber . '&amp;fn=' . urlencode($curfilename) . '&amp;foffset=' . $foffset . '&amp;totalqueries=' . $totalqueries . '&amp;db_connection_charset=' . $db_connection_charset . '&amp;language=' . $language . '&amp;site_url=' . $site_url . '&amp;site_admin_url=' . $site_admin_url . '">Continue from the line ' . $linenumber . '</a></p>' . LB
            . '</noscript>' . LB
            . '<p><b><a href="' . $_SERVER['PHP_SELF'] . '">' . $LANG_BIGDUMP[26] . '</a></b> ' . $LANG_BIGDUMP[27] . ' <b>' . $LANG_BIGDUMP[28] . '</b></p>' . LB;
    }
  } else {
    echo INST_getAlertMsg($LANG_BIGDUMP[29]);
  }

}

if ($error) {
    $backurl = 'migrate.php';
    if (! empty($language)) {
        $backurl .= '?language=' . $language;
    }
    echo '<p><a href="' . $backurl . '">' . $LANG_BIGDUMP[30] . '</a> '
         . $LANG_BIGDUMP[31] . '</p>' . LB;
}

if ($dbconnection) mysql_close($dbconnection);
if ($file && !$gzipmode) fclose($file);
else if ($file && $gzipmode) gzclose($file);

echo INST_getFooter();

?>
