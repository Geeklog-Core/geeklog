<?php

/**
 * @var $_CONF
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'siteconfig.php';

if (!isset($_CONF['path'], $_CONF['path_system']) ||
    (isset($_CONF['site_enabled']) && !$_CONF['site_enabled'])) {
    exit;
}

// Register autoloader
require_once $_CONF['path_system'] . 'classes/Autoload.php';
Geeklog\Autoload::initialize();
Geeklog\Cache::init(new Geeklog\Cache\FileSystem($_CONF['path'] . 'data/cache/'));

// Get cache key
$key = Geeklog\Input::fGet('k');
if (empty($key)) {
    exit;
}

// Get cached data
$data = Geeklog\Cache::get($key, null);
if (empty($data)) {
    exit;
}

// Check if eTags match
$eTag = md5($data['createdAt']);
$clientETag = trim(Geeklog\Input::server('HTTP_IF_NONE_MATCH', ''), '"\'');
if ($clientETag === $eTag) {
    header('HTTP/1.1 304 Not Modified');
    header('Status: 304 Not Modified');
    exit;
}


// Always compress if possible. Don't know $_CONF['compressed_output']) as file does not load lib-common.php
// Code taken from Geeklog COM_Output function
$compress_output = false;
$gzip_accepted = false;
if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
    $enc = str_replace(' ', '', $_SERVER['HTTP_ACCEPT_ENCODING']);
    $accept = explode(',', strtolower($enc));
    $gzip_accepted = in_array('gzip', $accept);
}

if ($gzip_accepted && function_exists('gzencode')) {
    $zlib_comp = ini_get('zlib.output_compression');
    if (empty($zlib_comp) || (strcasecmp($zlib_comp, 'off') === 0)) {
        header('Content-encoding: gzip');
        
        $compress_output = true;
    }
}

// Send correct header type
switch($data['type']) {
    case 'c':
        header('Content-Type: text/css; charset=UTF-8');
        break;

    case 'j':
        header('Content-Type: text/javascript; charset=UTF-8');
        break;

    default:
        exit();
        break;
}

// Add Cache Expire in 1 week
header('Cache-control: must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + Geeklog\Resource::DEFAULT_CACHE_LIFESPAN) . ' GMT');
header('ETag: "' . $eTag . '"');
if ($compress_output) {
    echo gzencode($data['data']);    
} else {
    echo $data['data'];
}
