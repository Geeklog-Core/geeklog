<?php

namespace Geeklog\Cache;

use Geeklog\CacheInterface;
use RuntimeException;

class APCu implements CacheInterface
{
    /**
     * APCu constructor.
     *
     * @throws RuntimeException
     */
    public function __construct()
    {
        if (!is_callable('apcu_store')) {
            throw new RuntimeException('APCu extension is not loaded');
        }
    }

    /**
     * Clear all cached data
     */
    public function clear()
    {
        apcu_clear_cache();
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
        $retval = apcu_fetch($key, $success);

        return $success ? $retval : $defaultValue;
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
        return apcu_store($key, $data, $ttl);
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
            return $this->set($key, $data, $ttl);
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
        return apcu_delete($key);
    }

    /**
     * Return if cached data exists
     *
     * @param  string $key
     * @return bool
     */
    public function exists($key)
    {
        return apcu_exists($key);
    }

    /**
     * Return the timestamp of cached item
     *
     * @param  string $key
     * @return int|false    the timestamp when the item exists, false otherwise
     */
    public function getAge($key)
    {
        return $this->exists($key) ? time() : false;
    }
}
