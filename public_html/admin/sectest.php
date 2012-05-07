<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | sectest.php                                                               |
// |                                                                           |
// | Does a quick security check of the Geeklog install                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun            - dirk AT haun-online DOT de                |
// |          Jeffrey Schoolcraft  - dream AT dr3amscap3 DOT com               |
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
* This script does a few quick and simple checks to ensure that you have
* installed Geeklog in a (relatively) secure fashion. It also gives tips on
* how to fix issues.
*
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

if (!SEC_inGroup('Root')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the security check.");
    COM_output($display);
    exit;
}

// ugh, global variable ...
$failed_tests = 0;

/**
* Send an HTTP HEAD request for the given URL
*
* @param    string  $url        URL to request
* @param    string  &$errmsg    error message, if any (on return)
* @return   int                 HTTP response code or 777 on error
*
*/
function doHeadRequest($url, &$errmsg)
{
    require_once 'HTTP/Request.php';

    $req = new HTTP_Request($url);
    $req->setMethod(HTTP_REQUEST_METHOD_HEAD);
    $req->addHeader('User-Agent', 'Geeklog/' . VERSION);
    $response = $req->sendRequest();
    if (PEAR::isError($response)) {
        $errmsg = $response->getMessage();
        return 777;
    } else {
        return $req->getResponseCode();
    }
}

/**
* Determine the site's base URL to check
*
* @return   string      site URL or empty string (= nothing to check)
*
*/
function urlToCheck()
{
    global $_CONF;

    $url = '';
    if ($_CONF['path'] == $_CONF['path_html']) {
        // not good ...
        $url = $_CONF['site_url'];
    } elseif (substr($_CONF['path'], 0, strlen($_CONF['path_html'])) == $_CONF['path_html']) {
        // "geeklog" dir in the document root
        $rest = substr($_CONF['path'], -(strlen($_CONF['path']) - strlen($_CONF['path_html'])));
        $url = $_CONF['site_url'] . '/' . $rest;
    } else {
        // check for sites like www.example.com/geeklog
        $u = $_CONF['site_url'];
        if (substr($u, -1) == '/') {
            $u = substr($u, 0, -1);
        }
        $pos = strpos($u, ':');
        if ($pos !== false) {
            $u2 = substr($u, $pos + 3);
        } else {
            $u2 = $u;
        }
        $p = explode('/', $u2);
        if (count($p) > 1) {
            $cut = strlen($p[count($p) - 1]) + 1;
            $url = substr($u, 0, -$cut);
        }
    }

    if (!empty($url) && (substr($url, -1) == '/')) {
        $url = substr($url, 0, -1);
    }

    return $url;
}

/**
* Give an interpretation of the test result
*
* @param    int     $retcode    HTTP response code of the test
* @param    string  $msg        file or directory that was checked
* @return   string              text explaining the result of the test
*
*/
function interpretResult($retcode, $msg)
{
    global $LANG_SECTEST, $failed_tests;

    $retval = '';

    if ($retcode == 200) {
        $retval .= sprintf($LANG_SECTEST['reachable'],
                           '<strong>' . $msg . '</strong>')
                . '<br' . XHTML . '><em>' . $LANG_SECTEST['fix_it'] . '</em>';
        $failed_tests++;
    } elseif (($retcode == 401) || ($retcode == 403) || ($retcode == 404)) {
        $retval .= sprintf($LANG_SECTEST['not_reachable'], $msg);
    } elseif (is_numeric($retcode)) {
        $retval .= sprintf($LANG_SECTEST['not_sure'], $retval, $msg);
        $failed_tests++;
    } else {
        $retval .= $retcode;
    }

    return $retval;
}

/**
* Create a temporary file
*
* @param    string  $file   full path of the file to create
* @return   boolean         true: success; false: file creation failed
*
*/
function makeTempfile($file)
{
    $retval = false;

    $tempfile = @fopen($file, 'w');
    if ($tempfile) {
        $retval = true;
        fclose($tempfile);
    }

    return $retval;
}

/**
* Perform a test
*
* @param    string  $baseurl        the site's base URL
* @param    string  $urltocheck     relative URL to check
* @param    string  $what           explanatory text: what is being checked
* @return   string                  test result as a list item
*
*/
function doTest($baseurl, $urltocheck, $what)
{
    global $failed_tests;

    $retval = '';

    $retval .= '<li>';
    $retcode = doHeadRequest($baseurl  . '/' . $urltocheck, $errmsg);
    if ($retcode == 777) {
        $retval .= $errmsg;
        $failed_tests++;
    } else {
        $retval .= interpretResult($retcode, $what);
    }
    $retval .= '</li>' . LB;

    return $retval;
}

/**
* Check for the existence of the install directory
*
* NOTE: This test used to be part of the "Get Bent" block in lib-custom.php
*
* @return   string      text explaining the result of the test
*
*/
function checkInstallDir()
{
    global $_CONF, $LANG_SECTEST, $failed_tests;

    $retval = '';

    // we don't have the path to the admin directory, so try to figure it out
    // from $_CONF['site_admin_url']
    $adminurl = $_CONF['site_admin_url'];
    if (strrpos($adminurl, '/') == strlen($adminurl)) {
        $adminurl = substr($adminurl, 0, -1);
    }
    $pos = strrpos($adminurl, '/');
    if ($pos === false) {
        // only guessing ...
        $installdir = $_CONF['path_html'] . 'admin/install';
    } else {
        $installdir = $_CONF['path_html'] . substr($adminurl, $pos + 1)
                    . '/install';
    }

    if (is_dir($installdir)) {
        $retval .= '<li>' . sprintf($LANG_SECTEST['remove_inst'],
                           '<b>' . $installdir . '</b>') . ' '
                . $LANG_SECTEST['remove_inst2'] . '</li>';
        $failed_tests++;
    } else {
        $retval .= '<li>' . $LANG_SECTEST['inst_removed'] . '</li>';
    }

    return $retval;
}

/**
* Check if the Admin account is still using the default password
*
* @return   string      text explaining the result of the test
*
*/
function checkDefaultPassword()
{
    global $_TABLES, $LANG_SECTEST, $failed_tests;

    $retval = '';

    if (SEC_encryptUserPassword('password', 2) ==  0) {
        $retval .= '<li>' . $LANG_SECTEST['fix_password'] . '</li>';
        $failed_tests++;
    } else {
        $retval .= '<li>' . $LANG_SECTEST['password_okay'] . '</li>';
    }

    return $retval;
}

// MAIN
$display = COM_startBlock($LANG_SECTEST['results']);

$url = urlToCheck();
if (!empty($url)) {

    $display .= '<ol>';

    if (strpos($_SERVER['PHP_SELF'], 'public_html') !== false) {
        $doclang = COM_getLanguageName();
        $docs = 'docs/' . $doclang . '/install.html';
        if (file_exists($_CONF['path_html'] . $docs)) {
            $instUrl = $_CONF['site_url'] . '/' . $docs;
        } else {
            $instUrl = $_CONF['site_url'] . '/docs/english/install.html';
        }
        $instUrl .= '#public_html';
        $display .= '<li>' . sprintf($LANG_SECTEST['public_html'],
                      COM_createLink($LANG_SECTEST['installation'], $instUrl))
                 . '</li>' . LB;
        $failed_tests++;
    }

    $display .= checkInstallDir();

    $urls = array
        (
        array('db-config.php',
              'db-config.php'),
        array('logs/error.log',
              'logs ' . $LANG_SECTEST['directory']),
        array('plugins/staticpages/functions.inc',
              'plugins ' . $LANG_SECTEST['directory']),
        array('system/lib-security.php',
              'system ' . $LANG_SECTEST['directory'])
        );

    foreach ($urls as $tocheck) {
        $display .= doTest($url, $tocheck[0], $tocheck[1]);
    }

    // Note: We're not testing the 'sql' and 'language' directories.

    if (($_CONF['allow_mysqldump'] == 1) && ($_DB_dbms == 'mysql')) {
        if (makeTempfile($_CONF['backup_path'] . 'test.txt')) {
            $display .= doTest($url, 'backups/test.txt',
                               'backups ' . $LANG_SECTEST['directory']);
            @unlink($_CONF['backup_path'] . 'test.txt');
        } else {
            $display .= '<li>' . sprintf($LANG_SECTEST['failed_tmp'], 'backups')
                     . '</li>';
        }
    }

    if (makeTempfile($_CONF['path_data'] . 'test.txt')) {
        $display .= doTest($url, 'data/test.txt', 'data directory');
        @unlink($_CONF['path_data'] . 'test.txt');
    } else {
        $display .= '<li>' . sprintf($LANG_SECTEST['failed_tmp'], 'data')
                 . '</li>';
    }

    $display .= checkDefaultPassword();

    $display .= '</ol>';

} else {

    $resultInstallDirCheck = checkInstallDir();
    $resultPasswordCheck = checkDefaultPassword();

    if ($failed_tests == 0) {
        $display .= '<p>' . $LANG_SECTEST['okay'] . '</p>';
    } else {
        $display .= '<ol>';
        $display .= $resultInstallDirCheck . LB . $resultPasswordCheck;
        $display .= '</ol>';
    }

}

if ($failed_tests > 0) {
    $display .= '<p class="warningsmall"><strong>'
             . $LANG_SECTEST['please_fix'] . '</strong></p>';

    DB_save($_TABLES['vars'], 'name,value', "'security_check','0'");
} else {
    $display .= '<p>' . $LANG_SECTEST['please_note'] . '</p>';

    DB_save($_TABLES['vars'], 'name,value', "'security_check','1'");
}

$ml = COM_createLink('geeklog-announce',
        'http://lists.geeklog.net/mailman/listinfo/geeklog-announce');
$versioncheck = '<strong>' . $LANG01[107] . '</strong>';
$display .= '<p>' . sprintf($LANG_SECTEST['stay_informed'], $ml, $versioncheck)
         . '</p>';

$display .= COM_endBlock();
$display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_SECTEST['sectest']));

COM_output($display);

?>
