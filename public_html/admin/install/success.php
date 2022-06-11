<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | success.php                                                               |
// |                                                                           |
// | Page that is displayed upon a successful Geeklog installation or upgrade  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2022 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Randy Kolenko     - randy AT nextide DOT ca                      |
// |          Matt West         - matt AT mattdanger DOT net                   |
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

// Need to set in case site is disabled as we want the User to know of the success of the Installer
define('GL_INSTALL_ACTIVE', true);

use Geeklog\Input;
use Geeklog\LocaleData;

require_once '../../lib-common.php';

if (!defined('XHTML')) {
    define('XHTML', ' /');
}

/**
 * Helper function to figure out the actual names of the 'admin/install' dir
 *
 * @return string the actual names of the 'admin/install' dir
 */
function SUCCESS_getInstallPath()
{
    $path = str_replace('\\', '/', __FILE__);
    $path = str_replace('//', '/', $path);
    $parts = explode('/', $path);
    $num_parts = count($parts);

    if (($num_parts < 3) || ($parts[$num_parts - 1] != 'success.php')) {
        return 'admin/install';
    }

    return $parts[$num_parts - 3] . '/' . $parts[$num_parts - 2];
}

/**
 * Delete all files and directories under the $baseDir
 *
 * @param  string  $baseDir
 * @return array of files and directories that the script couldn't delete
 */
function SUCCESS_deleteAll($baseDir)
{
    static $failures = [];

    foreach (scandir($baseDir) as $item) {
        if (($item !== '.') && ($item !== '..')) {
            $path = $baseDir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($path)) {
                SUCCESS_deleteAll($path);
            } elseif (!@is_link($path)) {
                if (!@unlink($path)) {
                    $failures[] = $path;
                }
            }
        }
    }

    if (!@rmdir($baseDir)) {
        $failures[] = $baseDir;
    }

    return $failures;
}

// Main
global $_TABLES, $LANG_SUCCESS, $MESSAGE;

// Clear all speed limits for login to prevent login issues after install/upgrade/migrate (bug #995)
COM_clearSpeedlimit(0, 'login');

$type = Input::fGet('type', 'install');
$submit = Input::post('submit', '');
$language = Input::fGet('language', 'english');
$language = preg_replace('/[^a-z0-9\-_]/', '', $language);
$languagePath = __DIR__ . '/language/' . $language . '.php';

if (is_readable($languagePath)) {
    require_once __DIR__ . '/language/' . $language . '.php';

    // Update $_CONF['language'] (issue #991, #1129)
    if ($type === 'install') {
        $config = config::get_instance();
        $config->set('language', $language, 'Core');
    }
} else {
    require_once __DIR__ . '/language/english.php';
}

// enable detailed error reporting
$_CONF['rootdebug'] = true;

// Prevent the template class from creating a cache file (now done in lib-common as we had to disable cache_resource as well)
// $_CONF['cache_templates'] = false;

switch ($submit) {
    case $LANG_SUCCESS[24]: // Delete all the fies and directories
        $failures = SUCCESS_deleteAll(__DIR__);
        $redirect = $_CONF['site_url'] . '/index.php?msg='
            . ((count($failures) === 0) ? 150 : 151);
        header('Location: ' . $redirect);
        die(0);
        break;

    case $LANG_SUCCESS[25]: // Don't delete any files or directories
        header('Location: ' . $_CONF['site_url'] . '/index.php?msg=152');
        break;

    default:
        // do nothing
        break;
}

// Clear old cache
CTL_clearCache();

$T = COM_newTemplate(CTL_core_templatePath(__DIR__ . '/layout'));
$T->set_file('success', 'success.thtml');

$msg = '';
if ($type === 'install') {
    $message = $LANG_SUCCESS[20];
} elseif ($type === 'upgrade') {
    $message = $LANG_SUCCESS[21];

    if (isset($_GET['msg'])) {
        $msg = $LANG_SUCCESS[(int) $_GET['msg']];
    }
} else {
    $message = $LANG_SUCCESS[22];
}

// Check if the language the user is using is supported, and show a warning if necessary
if (!LocaleData::isLanguageSupported($language)) {
    if (!empty($msg)) {
        $msg .= '<br>';
    }

    $msg .= sprintf($LANG_SUCCESS[29], $language);
}

$T->set_var([
    'conf_path'           => $_CONF['path'],
    'conf_path_html'      => $_CONF['path_html'],
    'conf_site_url'       => $_CONF['site_url'],
    'is_install'          => ($type === 'install'),
    'lang_message'        => $message,
    'msg'                 => $msg,
    'lang_success_1'      => $LANG_SUCCESS[1],
    'lang_success_2'      => $LANG_SUCCESS[2],
    'lang_success_3'      => $LANG_SUCCESS[3],
    'lang_success_4'      => $LANG_SUCCESS[4],
    'lang_success_5'      => $LANG_SUCCESS[5],
    'lang_success_6'      => $LANG_SUCCESS[6],
    'lang_success_7'      => $LANG_SUCCESS[7],
    'lang_success_8'      => $LANG_SUCCESS[8],
    'lang_success_9'      => $LANG_SUCCESS[9],
    'lang_success_10'     => $LANG_SUCCESS[10],
    'lang_success_11'     => $LANG_SUCCESS[11],
    'lang_success_12'     => $LANG_SUCCESS[12],
    'lang_success_13'     => $LANG_SUCCESS[13],
    'lang_success_14'     => $LANG_SUCCESS[14],
    'lang_success_15'     => $LANG_SUCCESS[15],
    'lang_success_16'     => $LANG_SUCCESS[16],
    'lang_success_17'     => $LANG_SUCCESS[17],
    'lang_success_18'     => $LANG_SUCCESS[18],
    'lang_success_19'     => $LANG_SUCCESS[19],
    'lang_success_20'     => $LANG_SUCCESS[20],
    'lang_success_21'     => $LANG_SUCCESS[21],
    'lang_success_22'     => $LANG_SUCCESS[22],
    'lang_success_23'     => $LANG_SUCCESS[23],
    'lang_success_24'     => $LANG_SUCCESS[24],
    'lang_success_25'     => $LANG_SUCCESS[25],
    'lang_success_26'     => $LANG_SUCCESS[26],
    'lang_confirm_delete' => $MESSAGE[76],
    'install_path'        => $_CONF['path_html'] . SUCCESS_getInstallPath(),
    'older_geeklog'       => (DB_count($_TABLES['users'], 'username', 'NewAdmin') > 0),
    'type'                => $type,
    'version'             => VERSION,
]);

$T->parse('output', 'success');
$content = $T->finish($T->get_var('output'));
$doc = COM_createHTMLDocument(
    $content,
    [
        'what'      => 'menu',
        'pagetitle' => $LANG_SUCCESS[0],
    ]
);
COM_output($doc);
