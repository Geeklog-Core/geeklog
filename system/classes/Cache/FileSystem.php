<?php

namespace Geeklog\Cache;

use Geeklog\CacheInterface;

/**
 * Class FileSystem
 *
 * @package Geeklog\Cache
 */
class FileSystem implements CacheInterface
{
    /**
     * @var string
     */
    private $root;

    /**
     * Array of directories and files that should not be deleted
     *
     * @var array
     */
    private $excludes = array('.', '..', 'index.html');

    /**
     * FileSystem constructor.
     *
     * @param $root
     */
    public function __construct($root)
    {
        $this->root = rtrim($root, '/\\') . DIRECTORY_SEPARATOR;
    }

    /**
     * @param  string $key
     * @return string
     */
    private function getFileName($key)
    {
        static $cache = array();

        if (!isset($cache[$key])) {
            $cache[$key] = $this->root . md5($key) . '.php';
        }

        return $cache[$key];
    }

    /**
     * Remove the contents of a directory given
     *
     * @param  string $dir
     */
    private function removeDirContents($dir)
    {
        foreach (scandir($dir) as $entry) {
            if (!in_array($entry, $this->excludes)) {
                $path = $dir . DIRECTORY_SEPARATOR . $entry;

                if (is_dir($path)) {
                    $this->removeDirContents($path);
                    rmdir($path);
                } else {
                    @unlink($path);
                }
            }
        }
    }

    /**
     * Clear all cached data
     */
    public function clear()
    {
        $this->removeDirContents(rtrim($this->root, '/\\'));
    }

    /**
     * Calculate hash of data
     *
     * @param  string $data
     * @return string
     */
    private function getHash($data)
    {
        if (!is_string($data)) {
            $data = serialize($data);
        }

        if (is_callable('hash_hmac')) {
            $hash = hash_hmac('sha1', $data, $this->root, true);
        } else {
            $hash = sha1($data . $this->root, true);
        }

        return base64_encode($hash);
    }

    /**
     * Get data
     *
     * @param  string $key
     * @param  mixed  $defaultValue
     * @return mixed
     */
    public function get($key, $defaultValue = null)
    {
        if (!$this->exists($key)) {
            return $defaultValue;
        }

        $fileName = $this->getFileName($key);
        $temp = @file_get_contents($fileName);

        if ($temp === false) {
            $this->delete($key);

            return $defaultValue;
        }

        $data = @unserialize($temp);

        if ($data === false) {
            // Failed to unserialize the cached data
            $this->delete($key);

            return $defaultValue;
        }

        if (is_array($data) && isset($data['data'], $data['created'], $data['ttl'], $data['hash']) &&
            (($data['ttl'] === 0) || (time() <= $data['created'] + $data['ttl'])) &&
            ($this->getHash($data['data']) === $data['hash'])) {
            return $data['data'];
        } else {
            $this->delete($key);

            return $defaultValue;
        }
    }

    /**
     * Set data
     *
     * @param  string $key
     * @param  mixed  $data
     * @param  int    $ttl
     * @return bool
     */
    public function set($key, $data, $ttl = 0)
    {
        $fileName = $this->getFileName($key);
        $item = array(
            'data'    => $data,
            'created' => time(),
            'ttl'     => (int) $ttl,
            'hash'    => $this->getHash($data),
        );

        return (@file_put_contents($fileName, serialize($item)) !== false);
    }

    /**
     * Add data only if it doesn't exist yet
     *
     * @param  string $key
     * @param  mixed  $data
     * @param  int    $ttl
     * @return bool
     */
    public function add($key, $data, $ttl = 0)
    {
        if ($this->exists($key)) {
            return false;
        } else {
            $this->set($key, $data, $ttl);

            return true;
        }
    }

    /**
     * Delete existing entry
     *
     * @param  string $key
     * @return bool
     */
    public function delete($key)
    {
        $fileName = $this->getFileName($key);

        return @unlink($fileName);
    }

    public function exists($key)
    {
        $fileName = $this->getFileName($key);
        clearstatcache();

        return @is_file($fileName) && @is_readable($fileName);
    }
}
