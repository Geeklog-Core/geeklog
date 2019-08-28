<?php
/**
 * Entry point for PHP connector, put your customizations here.
 *
 * @license     MIT License
 * @author      Pavel Solomienko <https://github.com/servocoder/>
 * @copyright   Authors
 */

// only for debug
// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
// ini_set('display_errors', '1');

global $_CONF_FCK, $_USER;

require_once __DIR__ . '/../../../lib-common.php';
require_once __DIR__ . '/events.php';

// fix display non-latin chars correctly
// https://github.com/servocoder/RichFilemanager/issues/7
setlocale(LC_CTYPE, 'en_US.UTF-8');

// fix for undefined timezone in php.ini
// https://github.com/servocoder/RichFilemanager/issues/43
if (!ini_get('date.timezone')) {
    date_default_timezone_set('GMT');
}


// This function is called for every server connection. It must return true.
//
// Implement this function to authenticate the user, for example to check a
// password login, or restrict client IP address.
//
// This function only authorizes the user to connect and/or load the initial page.
// Authorization for individual files or dirs is provided by the two functions below.
//
// NOTE: If using session variables, the session must be started first (session_start()).
function fm_authenticate()
{
    global $_CONF;

    if (COM_isDemoMode()) {
        return false;
    } else {
        return SEC_inGroup('Root') || (!$_CONF['filemanager_disabled'] && (SEC_inGroup('Filemanager Admin') || SEC_hasRights('filemanager.admin')));
    }

    // If this function returns false, the user will just see an error.
    // If this function returns an array with "redirect" key, the user will be redirected to the specified URL:
    // return ['redirect' => 'http://domain.my/login'];
}


// This function is called before any filesystem read operation, where
// $filepath is the file or directory being read. It must return true,
// otherwise the read operation will be denied.
//
// Implement this function to do custom individual-file permission checks, such as
// user/group authorization from a database, or session variables, or any other custom logic.
//
// Note that this is not the only permissions check that must pass. The read operation
// must also pass:
//   * Filesystem permissions (if any), e.g. POSIX `rwx` permissions on Linux
//   * The $filepath must be allowed according to config['patterns'] and config['extensions']
//
function fm_has_read_permission($filepath)
{
    // Customize this code as desired.
    return true;
}


// This function is called before any filesystem write operation, where
// $filepath is the file or directory being written to. It must return true,
// otherwise the write operation will be denied.
//
// Implement this function to do custom individual-file permission checks, such as
// user/group authorization from a database, or session variables, or any other custom logic.
//
// Note that this is not the only permissions check that must pass. The write operation
// must also pass:
//   * Filesystem permissions (if any), e.g. POSIX `rwx` permissions on Linux
//   * The $filepath must be allowed according to config['patterns'] and config['extensions']
//   * config['read_only'] must be set to false, otherwise all writes are disabled
//
function fm_has_write_permission($filepath)
{
    // Customize this code as desired.
    return true;
}

$isAdmin = false;

if (SEC_inGroup('Root') || SEC_inGroup('Filemanager Admin')
    || SEC_hasRights('filemanager.admin')) {
    $isAdmin = true;
} elseif (SEC_hasRights('story.edit') || SEC_hasRights('story.submit')) {
    $isAdmin = false;
} else {
    $content = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($content, ['pagetitle' => $MESSAGE[30]] );

    // Log illegal attempt to access.log
    COM_accessLog("User {$_USER['username']} tried to illegally access the Filemanager.");
    COM_output($display);
    exit;
}

if ($isAdmin) {
    $fileRoot = $_CONF['path_images'];
} else {
    if (isset($_CONF_FCK['imgl'])) {
        $fileRoot = $_CONF['path_html'] . trim($_CONF_FCK['imgl'], '/\\') . '/';
    } elseif (isset($_CONF_FCK['imagelibrary'])) {
        $fileRoot = $_CONF['path_html'] . trim($_CONF_FCK['imagelibrary'], '/\\') . '/';
    } else {
        $fileRoot = $_CONF['path_html'] . 'images/library/';
    }
}

$restrictions = array_merge(
    $_CONF['filemanager_images_ext'],
    $_CONF['filemanager_videos_ext'],
    $_CONF['filemanager_audios_ext']
);

// See https://github.com/servocoder/RichFilemanager-PHP/blob/master/src/config/config.local.php for detail
$config = [
    'logger'     => [
        'enabled' => $_CONF['filemanager_logger'],
        'file'    => ($_CONF['filemanager_logger'] ? $_CONF['path_log'] . 'error.log' : null),
    ],
    'options'    => [
        'serverRoot'        => true,
        'fileRoot'          => $fileRoot,
        'fileRootSizeLimit' => false,
        'charsLatinOnly'    => $_CONF['filemanager_chars_only_latin'],
    ],
    'security'   => [
        'readOnly'          => $_CONF['filemanager_browse_only'],
        'normalizeFilename' => true,
        'extensions'        => [
            'policy'       => 'ALLOW_LIST',
            'ignoreCase'   => true,
            'restrictions' => $restrictions,
        ],
    ],
    'patterns'   => [
        'policy'       => 'DISALLOW_LIST',
        'ignoreCase'   => true,
        'restrictions' => [
            // files
            '*/.htaccess',
            '*/web.config',
            // directories
            '*/.CDN_ACCESS_LOGS/',
            '*/_thumbs/',
            '*/cache/',
        ],
    ],
    'symlinks'   => [
        'allowAll'   => false,
        'allowPaths' => [],
    ],
    'upload'     => [
        'fileSizeLimit' => $_CONF['filemanager_upload_file_size_limit'],
        'overwrite'     => $_CONF['filemanager_upload_overwrite'],
        'paramName'     => 'upload',
    ],
    'images'     => [
        'main'      => [
            'autoOrient' => true,
            'maxWidth'   => 1280,
            'maxHeight'  => 1024,
        ],
        'thumbnail' => [
            'enabled'   => $_CONF['filemanager_generate_thumbnails'],
            'cache'     => true,
            'dir'       => '_thumbs',
            'crop'      => true,
            'maxWidth'  => 64,
            'maxHeight' => 64,
        ],
    ],
    'mkdir_mode' => 0755,
];

$app = new RFM\Application();

// uncomment to use events
//$app->registerEventsListeners();

$local = new RFM\Repository\Local\Storage($config);
$local->setRoot($fileRoot, false, false);
$app->setStorage($local);

// set application API
$app->api = new RFM\Api\LocalApi();
$app->run();