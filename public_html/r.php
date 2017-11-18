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
Geeklog\Cache::init();

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
echo $data['data'];
