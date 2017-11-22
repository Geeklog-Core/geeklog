<?php

namespace Geeklog;

use Geeklog\Cache\APCu;
use Geeklog\Cache\FileSystem;

/**
 * Class Cache
 *
 * @package Geeklog
 */
abstract class Cache
{
    /**
     * @var bool
     */
    private static $isInitialized = false;

    /**
     * @var bool
     */
    private static $isEnabled = true;

    /**
     * @var CacheInterface
     */
    private static $instance = null;

    /**
     * Initialize Cache class
     */
    public static function init()
    {
        global $_CONF;

        if (!self::$isInitialized) {
            self::$instance = new FileSystem($_CONF['path'] . 'data/cache/');
//            self::$instance = new APCu();
            self::$isInitialized = true;
        }
    }

    /**
     * Disable caching
     */
    public static function disable()
    {
        self::$isEnabled = false;
    }

    /**
     * Enable caching
     */
    public static function enable()
    {
        self::$isEnabled = false;
    }

    /**
     * Clear all cached data
     */
    public static function clear()
    {
        if (self::$isEnabled) {
            self::$instance->clear();
        }
    }

    /**
     * Get data
     *
     * @param  string $key
     * @param  mixed  $defaultValue
     * @return mixed
     */
    public static function get($key, $defaultValue = null)
    {
        return self::$isEnabled ? self::$instance->get($key, $defaultValue) : $defaultValue;
    }

    /**
     * Set data
     *
     * @param  string $key
     * @param  mixed  $data
     * @param  int    $ttl
     * @return bool
     */
    public static function set($key, $data, $ttl = 0)
    {
        return self::$isEnabled ? self::$instance->set($key, $data, $ttl) : false;
    }

    /**
     * Add data only if it doesn't exist yet
     *
     * @param  string $key
     * @param  mixed  $data
     * @param  int    $ttl
     * @return bool
     */
    public static function add($key, $data, $ttl = 0)
    {
        return self::$isEnabled ? self::$instance->add($key, $data, $ttl) : false;
    }

    /**
     * Delete existing entry
     *
     * @param  string $key
     * @return bool
     */
    public static function delete($key)
    {
        return self::$isEnabled ? self::$instance->delete($key) : false;
    }

    /**
     * Return if cached data exists
     *
     * @param  string $key
     * @return bool
     */
    public static function exists($key)
    {
        return self::$isEnabled ? self::$instance->exists($key) : false;
    }
}
