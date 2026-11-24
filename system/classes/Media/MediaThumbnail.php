<?php

namespace Geeklog\Media;

/**
 * Lazy, bounded WebP thumbnails stored in Geeklog's private data directory.
 */
class MediaThumbnail
{
    public static function generate($source, $cacheRoot)
    {
        if (!extension_loaded('gd') || !function_exists('imagepng')) {
            throw new \RuntimeException('GD PNG support is unavailable.');
        }
        $base = realpath($cacheRoot);
        if ($base === false || !is_dir($base)) {
            throw new \RuntimeException('The private thumbnail cache is unavailable.');
        }
        clearstatcache(true, $source);
        $stat = @stat($source);
        if (!$stat || !is_file($source) || is_link($source) || $stat['size'] > 25 * 1024 * 1024) {
            throw new \RuntimeException('This image cannot be previewed.');
        }
        $info = @getimagesize($source);
        if (!$info || empty($info[0]) || empty($info[1]) || $info[0] > 10000
            || $info[1] > 10000 || (float) $info[0] * $info[1] > 24000000) {
            throw new \RuntimeException('Image dimensions exceed thumbnail safety limits.');
        }
        $types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, 18]; // WebP constant appears in PHP 7.1.
        if (!in_array($info[2], $types, true)) {
            throw new \RuntimeException('Unsupported thumbnail format.');
        }
        $useWebp = function_exists('imagewebp');
        $format = $useWebp ? 'webp' : 'png';
        $mime = $useWebp ? 'image/webp' : 'image/png';
        // Inode changes after an atomic replacement, even if size and mtime coincide.
        $key = hash('sha256', $format . ':' . $source . ':' . $stat['mtime'] . ':'
            . $stat['size'] . ':' . $stat['ino']);
        $directory = $base . DIRECTORY_SEPARATOR . substr($key, 0, 2);
        if (!is_dir($directory) && !@mkdir($directory, 0700, true) && !is_dir($directory)) {
            throw new \RuntimeException('Cannot initialize thumbnail cache.');
        }
        $target = $directory . DIRECTORY_SEPARATOR . $key . '.' . $format;
        if (is_file($target) && filesize($target) > 0) {
            return [$target, $key, $mime];
        }
        $lockPath = $directory . DIRECTORY_SEPARATOR . $key . '.lock';
        $lock = @fopen($lockPath, 'c');
        if (!$lock || !flock($lock, LOCK_EX)) {
            if ($lock) { fclose($lock); }
            throw new \RuntimeException('Cannot lock thumbnail cache.');
        }
        try {
            if (!is_file($target) || filesize($target) === 0) {
                switch ($info[2]) {
                    case IMAGETYPE_JPEG:
                        $image = @imagecreatefromjpeg($source);
                        break;
                    case IMAGETYPE_PNG:
                        $image = @imagecreatefrompng($source);
                        break;
                    case IMAGETYPE_GIF:
                        $image = @imagecreatefromgif($source);
                        break;
                    case 18:
                        $image = function_exists('imagecreatefromwebp')
                            ? @imagecreatefromwebp($source) : false;
                        break;
                    default:
                        $image = false;
                }
                if ($image === false) {
                    throw new \RuntimeException('Unable to decode image preview.');
                }
                try {
                    $width = (int) $info[0];
                    $height = (int) $info[1];
                    $scale = min(1, 320 / max($width, $height));
                    $w = max(1, (int) round($width * $scale));
                    $h = max(1, (int) round($height * $scale));
                    $thumb = imagecreatetruecolor($w, $h);
                    if ($thumb === false) {
                        throw new \RuntimeException('Cannot allocate thumbnail.');
                    }
                    try {
                        imagealphablending($thumb, false);
                        imagesavealpha($thumb, true);
                        $transparent = imagecolorallocatealpha($thumb, 0, 0, 0, 127);
                        imagefill($thumb, 0, 0, $transparent);
                        if (!imagecopyresampled($thumb, $image, 0, 0, 0, 0, $w, $h, $width, $height)) {
                            throw new \RuntimeException('Unable to resize preview.');
                        }
                        $temporary = @tempnam($directory, '.thumb-');
                        if (!$temporary) {
                            throw new \RuntimeException('Cannot create temporary thumbnail.');
                        }
                        try {
                            if (!($useWebp ? @imagewebp($thumb, $temporary, 76)
                                    : @imagepng($thumb, $temporary, 6))
                                || !is_file($temporary) || filesize($temporary) === 0
                                || !@rename($temporary, $target)) {
                                throw new \RuntimeException('Cannot save generated thumbnail.');
                            }
                            @chmod($target, 0600);
                        } finally {
                            if (file_exists($temporary)) { @unlink($temporary); }
                        }
                    } finally {
                        imagedestroy($thumb);
                    }
                } finally {
                    imagedestroy($image);
                }
            }
        } finally {
            flock($lock, LOCK_UN);
            fclose($lock);
        }
        return [$target, $key, $mime];
    }
}
