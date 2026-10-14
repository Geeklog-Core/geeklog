<?php
/**
 * Regression test for issue #1171.
 *
 * Run with: php tests/clear-cache-preserve-data.php
 * Compatible with PHP 5.6 and PHP 8.1.
 *
 * Executes the real admin controller with a disposable site fixture.
 * No live installation, database, or plugin is required.
 */
namespace Geeklog {
    class Cache
    {
        public static $cleared = false;

        public static function clear()
        {
            self::$cleared = true;
        }
    }
}

namespace {
    function testRemoveTree($path)
    {
        if (is_dir($path)) {
            foreach (scandir($path) as $entry) {
                if ($entry !== '.' && $entry !== '..') {
                    testRemoveTree($path . '/' . $entry);
                }
            }
            rmdir($path);
        } elseif (file_exists($path)) {
            unlink($path);
        }
    }

    function testAssert($condition, $message)
    {
        if (!$condition) {
            throw new \Exception($message);
        }
    }

    function SEC_inGroup($group)
    {
        return $group === 'Root';
    }

    function CTL_clearCache()
    {
        $GLOBALS['templateCacheCleared'] = true;
    }

    function PLG_clearCache()
    {
        $GLOBALS['pluginCacheCleared'] = true;
    }

    function COM_redirect($url)
    {
        $GLOBALS['redirectedTo'] = $url;
    }

    function COM_cleanDirectory($directory, $leaveDirs, $leaveFiles)
    {
        $GLOBALS['cleanedDirectories'][] = $directory;
        if (!is_dir($directory)) {
            return;
        }
        foreach (scandir($directory) as $entry) {
            if ($entry === '.' || $entry === '..'
                || in_array($entry, $leaveDirs, true)
                || in_array($entry, $leaveFiles, true)) {
                continue;
            }
            testRemoveTree(rtrim($directory, '/\\') . '/' . $entry);
        }
    }

    $base = sys_get_temp_dir() . '/geeklog-1171-' . uniqid('', true);
    $_CONF = array(
        'path_data' => $base . '/site-a/data/',
        'path_images' => $base . '/site-a/images/',
        'site_admin_url' => 'https://example.invalid/admin'
    );
    $otherSite = $base . '/site-b/data/';
    $persistentPaths = array(
        $_CONF['path_data'] . 'mediagallery/uploads/photo.jpg',
        $_CONF['path_data'] . 'monitor/catalog.json',
        $_CONF['path_data'] . 'videos/data.json',
        $_CONF['path_data'] . 'private/custom.txt',
        $otherSite . 'plugin/documents.json'
    );

    try {
        foreach ($persistentPaths as $file) {
            if (!is_dir(dirname($file))) {
                testAssert(mkdir(dirname($file), 0777, true), 'Cannot create fixture directory');
            }
            testAssert(file_put_contents($file, 'persistent') !== false, 'Cannot create fixture');
        }

        $GLOBALS['cleanedDirectories'] = array();
        $GLOBALS['templateCacheCleared'] = false;
        $GLOBALS['pluginCacheCleared'] = false;

        // clearctl.php requires ../lib-common.php relative to its own directory.
        // Intercept that bootstrap by executing a copy inside our fixture with a
        // minimal, empty lib-common.php file.
        $admin = $base . '/site-a/public_html/admin';
        testAssert(mkdir($admin, 0777, true), 'Cannot create admin fixture');
        testAssert(file_put_contents($base . '/site-a/public_html/lib-common.php', '<?php return; ') !== false,
            'Cannot create bootstrap stub');
        $controller = dirname(__DIR__) . '/public_html/admin/clearctl.php';
        testAssert(copy($controller, $admin . '/clearctl.php'), 'Cannot copy controller');

        $previousCwd = getcwd();
        chdir($admin);
        try {
            include $admin . '/clearctl.php';
        } finally {
            chdir($previousCwd);
        }

        testAssert($GLOBALS['templateCacheCleared'], 'Template cache was not cleared');
        testAssert(\Geeklog\Cache::$cleared, 'Resource cache was not cleared');
        testAssert($GLOBALS['pluginCacheCleared'], 'Plugin cache hook was not called');
        testAssert($GLOBALS['redirectedTo'] === $_CONF['site_admin_url'] . '/index.php?msg=500',
            'Admin redirect changed');

        foreach ($persistentPaths as $file) {
            testAssert(is_file($file) && file_get_contents($file) === 'persistent',
                'Persistent file was removed: ' . $file);
        }
        foreach ($GLOBALS['cleanedDirectories'] as $directory) {
            testAssert(strpos($directory, $_CONF['path_data']) !== 0,
                'Clear Cache attempted to recursively clean private data');
            testAssert(strpos($directory, $otherSite) !== 0,
                'Clear Cache attempted to clean another site');
        }
        echo "PASS: cache actions completed without removing site or plugin data\n";
    } catch (\Exception $e) {
        fwrite(STDERR, 'FAIL: ' . $e->getMessage() . "\n");
        testRemoveTree($base);
        exit(1);
    }

    testRemoveTree($base);
}
