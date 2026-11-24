<?php

namespace Geeklog\Test;

use Geeklog\Media\MediaThumbnail;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class MediaThumbnailClassTest extends TestCase
{
    public function setUp(): void
    {
        require_once \Tst::$root . 'system/classes/Media/MediaThumbnail.php';
        if (!extension_loaded('gd') || !function_exists('imagewebp')) {
            $this->markTestSkipped('GD WebP support is required.');
        }
    }

    public function testCreatesAndReusesOptimizedPrivateThumbnail()
    {
        $root = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'gl-thumbs-' . bin2hex(random_bytes(5));
        $cache = $root . DIRECTORY_SEPARATOR . 'cache';
        mkdir($root, 0700);
        mkdir($cache, 0700);
        $source = $root . DIRECTORY_SEPARATOR . 'large.png';
        $image = imagecreatetruecolor(720, 480);
        imagefill($image, 0, 0, imagecolorallocate($image, 80, 130, 160));
        imagepng($image, $source);
        imagedestroy($image);
        try {
            list($thumbnail, $etag) = MediaThumbnail::generate($source, $cache);
            $this->assertFileExists($thumbnail);
            $this->assertStringEndsWith('.webp', $thumbnail);
            $info = getimagesize($thumbnail);
            $this->assertSame(IMAGETYPE_WEBP, $info[2]);
            $this->assertSame(320, $info[0]);
            $this->assertSame(213, $info[1]);
            list($again, $sameTag) = MediaThumbnail::generate($source, $cache);
            $this->assertSame($thumbnail, $again);
            $this->assertSame($etag, $sameTag);
            $this->assertNotSame(realpath($source), realpath($thumbnail));
        } finally {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );
            foreach ($iterator as $entry) {
                if ($entry->isDir()) {
                    rmdir($entry->getPathname());
                } else {
                    unlink($entry->getPathname());
                }
            }
            rmdir($root);
        }
    }

    public function testRejectsOversizedImageDimensions()
    {
        $root = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'gl-thumb-invalid-' . bin2hex(random_bytes(5));
        mkdir($root, 0700);
        $cache = $root . DIRECTORY_SEPARATOR . 'cache';
        mkdir($cache, 0700);
        $source = $root . DIRECTORY_SEPARATOR . 'too-big.png';
        // A tiny file can still declare oversized dimensions in its PNG IHDR.
        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='
        );
        $png = substr_replace($png, pack('N', 10001), 16, 4);
        file_put_contents($source, $png);
        try {
            $this->expectException(RuntimeException::class);
            MediaThumbnail::generate($source, $cache);
        } finally {
            unlink($source);
            rmdir($cache);
            rmdir($root);
        }
    }
}
