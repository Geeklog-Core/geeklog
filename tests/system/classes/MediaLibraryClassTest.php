<?php

namespace Geeklog\Test;

use Geeklog\Media\MediaStorage;
use Geeklog\Media\MediaValidator;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class MediaLibraryClassTest extends TestCase
{
    /** @var string */
    private $testRoot;

    /** @var MediaValidator */
    private $validator;

    /** @var MediaStorage */
    private $storage;

    public function setUp(): void
    {
        require_once \Tst::$root . 'system/classes/Media/MediaValidator.php';
        require_once \Tst::$root . 'system/classes/Media/MediaStorage.php';

        $this->testRoot = sys_get_temp_dir() . DIRECTORY_SEPARATOR
            . 'geeklog-media-test-' . bin2hex(random_bytes(6));
        $this->assertTrue(mkdir($this->testRoot, 0700));
        $this->validator = new MediaValidator(
            ['jpg', 'jpeg', 'gif', 'png', 'webp', 'svg'],
            ['ogv', 'mp4', 'webm'],
            ['ogg', 'mp3', 'wav']
        );
        $this->storage = new MediaStorage(
            $this->testRoot,
            'https://example.invalid/media',
            $this->validator,
            1024 * 1024,
            false
        );
    }

    public function tearDown(): void
    {
        if (!is_dir($this->testRoot)) {
            return;
        }
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->testRoot, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($iterator as $entry) {
            if ($entry->isLink() || $entry->isFile()) {
                unlink($entry->getPathname());
            } else {
                rmdir($entry->getPathname());
            }
        }
        rmdir($this->testRoot);
    }

    /**
     * @dataProvider rejectedPathProvider
     */
    public function testRejectsUnsafeLogicalPaths($path)
    {
        $this->expectException(RuntimeException::class);
        $this->validator->normalizeLogicalPath($path);
    }

    public function rejectedPathProvider()
    {
        return [
            ['..'],
            ['../secret'],
            ['/etc/passwd'],
            ['C:\\Windows\\win.ini'],
            ['https://example.com/file'],
            ['folder\\..\\secret'],
        ];
    }

    /**
     * @dataProvider executableNameProvider
     */
    public function testRejectsExecutableNames($name)
    {
        $this->expectException(RuntimeException::class);
        $this->validator->validateExistingFileName($name, 'Root');
    }

    public function executableNameProvider()
    {
        return [
            ['shell.php'],
            ['shell.PHP'],
            ['.htaccess'],
            ['payload.phtml'],
            ['payload.phar'],
            ['script.py'],
            ['script.sh'],
        ];
    }

    public function testRejectsMismatchedImageMimeType()
    {
        $path = $this->testRoot . DIRECTORY_SEPARATOR . 'fake.jpg';
        file_put_contents($path, 'This is not a JPEG image.');

        $this->expectException(RuntimeException::class);
        $this->validator->validateFileContents($path, 'fake.jpg');
    }

    public function testStorageLifecycleAndNonEmptyDirectoryProtection()
    {
        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=',
            true
        );
        file_put_contents($this->testRoot . DIRECTORY_SEPARATOR . 'sample.png', $png);

        $listing = $this->storage->listDirectory('', 'Image');
        $this->assertCount(1, $listing['items']);
        $this->assertSame('sample.png', $listing['items'][0]['name']);

        $this->storage->createDirectory('', 'folder');
        $this->storage->renameItem('sample.png', 'renamed.png', 'Image');
        file_put_contents($this->testRoot . DIRECTORY_SEPARATOR . 'folder'
            . DIRECTORY_SEPARATOR . 'marker.txt', 'test');

        try {
            $this->storage->deleteItem('folder');
            $this->fail('A non-empty directory was deleted.');
        } catch (RuntimeException $e) {
            $this->assertSame('Only empty folders can be deleted.', $e->getMessage());
        }

        unlink($this->testRoot . DIRECTORY_SEPARATOR . 'folder' . DIRECTORY_SEPARATOR . 'marker.txt');
        $this->storage->deleteItem('renamed.png');
        $this->storage->deleteItem('folder');
        $this->assertSame(['.', '..'], scandir($this->testRoot));
    }

    public function testRejectsMediaRootDeletion()
    {
        $this->expectException(RuntimeException::class);
        $this->storage->deleteItem('');
    }

    public function testDoesNotListSymbolicLinks()
    {
        $outside = tempnam(sys_get_temp_dir(), 'geeklog-media-outside-');
        $link = $this->testRoot . DIRECTORY_SEPARATOR . 'outside.png';
        if (!@symlink($outside, $link)) {
            unlink($outside);
            $this->markTestSkipped('The operating system does not permit symlink creation.');
        }

        try {
            $listing = $this->storage->listDirectory('', 'Image');
            $this->assertCount(0, $listing['items']);
        } finally {
            unlink($link);
            unlink($outside);
        }
    }
}
