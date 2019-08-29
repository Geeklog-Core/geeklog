<?php

namespace Geeklog;

/**
 * Interface CacheInterface
 *
 * @package Geeklog
 */
interface CacheInterface
{
    /**
     * Clear all cached data
     */
    public function clear();

    /**
     * Get data
     *
     * @param  string $key
     * @param  mixed  $defaultValue
     * @return mixed
     */
    public function get($key, $defaultValue = null);

    /**
     * Set data
     *
     * @param  string $key
     * @param  mixed  $data
     * @param  int    $ttl
     * @return bool
     */
    public function set($key, $data, $ttl = 0);

    /**
     * Add data only if it doesn't exist yet
     *
     * @param  string $key
     * @param  mixed  $data
     * @param  int    $ttl
     * @return bool
     */
    public function add($key, $data, $ttl = 0);

    /**
     * Delete existing entry
     *
     * @param  string $key
     * @return bool
     */
    public function delete($key);

    /**
     * Return if cached data exists
     *
     * @param  string $key
     * @return bool
     */
    public function exists($key);

    /**
     * Return the timestamp of cached item
     *
     * @param  string $key
     * @return int|false    the timestamp when the item exists, false otherwise
     */
    public function getAge($key);
}
