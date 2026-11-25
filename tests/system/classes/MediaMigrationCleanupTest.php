<?php

namespace Geeklog\Test;

use Geeklog\Install\Common;
use PHPUnit\Framework\TestCase;

require_once \Tst::$root
    . 'public_html/admin/install/classes/Common.php';

class MediaMigrationCleanupHarness extends Common
{
    public function cleanup($path)
    {
        return $this->cleanupLegacyFileManagerEndpoints($path);
    }
}

class MediaMigrationCleanupTest extends TestCase
{
    private $root;
    private $files = [
        'connectors/php/events.php',
        'connectors/php/filemanager.php',
        'libs/jQuery-File-Upload/server/php/UploadHandler.php',
        'libs/jQuery-File-Upload/server/php/index.php',
    ];

    public function setUp(): void
    {
        $this->root = sys_get_temp_dir()
            . '/geeklog-migration-' . bin2hex(random_bytes(6));

        foreach ($this->files as $file) {
            $path = $this->root . '/filemanager/' . $file;
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }
            file_put_contents($path, '<?php // legacy');
        }

        $userfiles = $this->root . '/filemanager/userfiles';
        if (!is_dir($userfiles)) {
            mkdir($userfiles, 0755, true);
        }

        file_put_contents($userfiles . '/.htaccess', 'protected');
        file_put_contents($userfiles . '/web.config', 'protected');
        file_put_contents($userfiles . '/photo.jpg', 'user data');
    }

    public function tearDown(): void
    {
        if (!is_dir($this->root)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $this->root,
                \FilesystemIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir() && !$item->isLink()) {
                rmdir($item->getPathname());
            } else {
                unlink($item->getPathname());
            }
        }

        rmdir($this->root);
    }

    public function testRemovesLegacyEndpointsButPreservesUserFiles()
    {
        $cleanup = new MediaMigrationCleanupHarness();

        $this->assertSame([], $cleanup->cleanup($this->root));

        foreach ($this->files as $file) {
            $this->assertFileDoesNotExist(
                $this->root . '/filemanager/' . $file
            );
        }

        foreach (['.htaccess', 'web.config', 'photo.jpg'] as $file) {
            $this->assertFileExists(
                $this->root . '/filemanager/userfiles/' . $file
            );
        }
    }

    public function testCleanupIsIdempotent()
    {
        $cleanup = new MediaMigrationCleanupHarness();

        $this->assertSame([], $cleanup->cleanup($this->root));
        $this->assertSame([], $cleanup->cleanup($this->root));
    }

    public function testReportsFailedDeletion()
    {
        $blocked = $this->root
            . '/filemanager/connectors/php/filemanager.php';

        unlink($blocked);
        mkdir($blocked);

        $cleanup = new MediaMigrationCleanupHarness();

        $this->assertSame(
            ['connectors/php/filemanager.php'],
            $cleanup->cleanup($this->root)
        );

        $this->assertDirectoryExists($blocked);
    }
}
