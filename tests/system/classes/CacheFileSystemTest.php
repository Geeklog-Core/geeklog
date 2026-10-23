<?php

namespace Geeklog\Test;

use Geeklog\Cache\FileSystem;
use PHPUnit\Framework\TestCase;

class CacheFileSystemTest extends TestCase
{
    public function testClearWithMissingDirectory()
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('geeklog-cache-missing-', true);
        $cache = new FileSystem($path);
        $cache->clear();

        $this->assertFalse(is_dir($path));
    }

    public function testClearRemovesCachedFileButPreservesIndex()
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('geeklog-cache-', true);
        mkdir($path, 0700);

        try {
            file_put_contents($path . DIRECTORY_SEPARATOR . 'index.html', '');
            file_put_contents($path . DIRECTORY_SEPARATOR . 'cached.php', 'test');

            $cache = new FileSystem($path);
            $cache->clear();

            $this->assertFileExists($path . DIRECTORY_SEPARATOR . 'index.html');
            $this->assertFileNotExists($path . DIRECTORY_SEPARATOR . 'cached.php');
        } finally {
            @unlink($path . DIRECTORY_SEPARATOR . 'cached.php');
            @unlink($path . DIRECTORY_SEPARATOR . 'index.html');
            @rmdir($path);
        }
    }
}
