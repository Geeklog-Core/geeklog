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

    public function testSameKeyIsIsolatedBetweenInstances()
    {
        $a = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('geeklog-cache-a-', true);
        $b = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('geeklog-cache-b-', true);
        mkdir($a, 0700);
        mkdir($b, 0700);
        $first = new FileSystem($a);
        $second = new FileSystem($b);
        $key = 'shared-key';
        try {
            $this->assertTrue($first->set($key, 'site-a'));
            $this->assertTrue($second->set($key, 'site-b'));
            $this->assertSame('site-a', $first->get($key));
            $this->assertSame('site-b', $second->get($key));
            $first->clear();
            $this->assertFalse($first->exists($key));
            $this->assertSame('site-b', $second->get($key));
        } finally {
            $first->clear();
            $second->clear();
            rmdir($a);
            rmdir($b);
        }
    }
}
