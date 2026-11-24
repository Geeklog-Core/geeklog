<?php
/**
 * Standalone smoke test without PHPUnit or Geeklog bootstrap.
 * Compatible with PHP 5.6.4: run using PHP CLI with GD and Fileinfo.
 */
require_once dirname(dirname(__DIR__)) . '/system/classes/Media/MediaValidator.php';
require_once dirname(dirname(__DIR__)) . '/system/classes/Media/MediaStorage.php';
require_once dirname(dirname(__DIR__)) . '/system/classes/Media/MediaThumbnail.php';

use Geeklog\Media\MediaStorage;
use Geeklog\Media\MediaValidator;
use Geeklog\Media\MediaThumbnail;

if (!extension_loaded('gd') || !function_exists('imagepng')) {
    fwrite(STDERR, "Missing GD PNG support\n");
    exit(1);
}

$root = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'geeklog-preview-' . uniqid();
mkdir($root, 0700);
$cache = $root . DIRECTORY_SEPARATOR . 'cache-private';
mkdir($cache, 0700);
mkdir($root . DIRECTORY_SEPARATOR . '_thumbs', 0700);
mkdir($root . DIRECTORY_SEPARATOR . 'other', 0700);
$source = $root . DIRECTORY_SEPARATOR . 'original.png';
$img = imagecreatetruecolor(720, 480);
imagefill($img, 0, 0, imagecolorallocate($img, 20, 80, 160));
imagepng($img, $source);
imagedestroy($img);
try {
    $validator = new MediaValidator(['jpg','jpeg','png','webp'], ['mp4'], ['mp3']);
    $storage = new MediaStorage($root, 'https://example.invalid/images', $validator, 1024*1024, false, ['cache-private']);
    $listing = $storage->listDirectory('', 'Root');
    $names = array();
    foreach ($listing['items'] as $item) { $names[] = $item['name']; }
    if (in_array('_thumbs', $names, true) || in_array('cache-private', $names, true)) {
        throw new RuntimeException('Technical directory exposed.');
    }
    try {
        $storage->listDirectory('_thumbs', 'Root');
        throw new RuntimeException('Technical directory still accessible.');
    } catch (RuntimeException $e) {
        if (strpos($e->getMessage(), 'technical directory') === false) {
            throw $e;
        }
    }
    list($target, $etag, $mime) = MediaThumbnail::generate($source, $cache);
    if (!is_file($target) || strlen($etag) !== 64
        || ($mime !== 'image/png' && $mime !== 'image/webp')) {
        throw new RuntimeException('Thumbnail not generated.');
    }
    // PHP 5.6 has no reliable WebP metadata support; the generator must use PNG.
    if (PHP_VERSION_ID < 70100 && $mime !== 'image/png') {
        throw new RuntimeException('PHP 5.6 must generate PNG thumbnails.');
    }
    $preview = $mime === 'image/png' ? @imagecreatefrompng($target)
        : (function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($target) : false);
    $actual = $preview ? imagesx($preview) . 'x' . imagesy($preview) : 'undecodable';
    if (!$preview || imagesx($preview) !== 320 || imagesy($preview) !== 213) {
        throw new RuntimeException('Thumbnail dimensions incorrect: expected 320x213, got '
            . $actual . ' (' . $mime . ', PHP ' . PHP_VERSION . ').');
    }
    imagedestroy($preview);
    list($cached, $sameTag) = MediaThumbnail::generate($source, $cache);
    if ($cached !== $target || $sameTag !== $etag) {
        throw new RuntimeException('Thumbnail cache not reused.');
    }
    echo "OK: PHP " . PHP_VERSION . ", thumbnail " . $mime . ", access protections\n";
} finally {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($iterator as $entry) {
        if ($entry->isDir()) { rmdir($entry->getPathname()); }
        else { unlink($entry->getPathname()); }
    }
    rmdir($root);
}
