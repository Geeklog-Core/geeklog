<?php

namespace Geeklog;

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
     *
     * @param CacheInterface $driver
     */
    public static function init(CacheInterface $driver)
    {
        if (!self::$isInitialized) {
            self::$instance = $driver;
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
     * Return if caching is enabled
     *
     * @return bool true if caching is enabled
     */
    public static function isEnabled()
    {
        return self::$isEnabled;
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
        return self::$isEnabled && self::$instance->set($key, $data, $ttl);
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
        return self::$isEnabled && self::$instance->add($key, $data, $ttl);
    }

    /**
     * Delete existing entry
     *
     * @param  string $key
     * @return bool
     */
    public static function delete($key)
    {
        return self::$isEnabled && self::$instance->delete($key);
    }

    /**
     * Return if cached data exists
     *
     * @param  string $key
     * @return bool
     */
    public static function exists($key)
    {
        return self::$isEnabled && self::$instance->exists($key);
    }

    /**
     * Return the timestamp of cached item
     *
     * @param  string $key
     * @return int|false    the timestamp when the item exists, false otherwise
     */
    public static function getAge($key)
    {
        return self::$isEnabled ? self::$instance->getAge($key) : false;
    }
}
