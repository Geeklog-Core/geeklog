<?php

namespace RFM\Repository;

use function RFM\app;

/**
 *    BaseItemModel PHP class
 *
 *    Base class created to define base methods
 *
 *    @license    MIT License
 *    @author        Pavel Solomienko <https://github.com/servocoder/>
 *    @copyright    Authors
 */

class BaseItemModel
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * Get storage instance associated with model item.
     *
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Associate storage with model item.
     *
     * @param string $storageName
     */
    public function setStorage($storageName)
    {
        $this->storage = app()->getStorage($storageName);
    }
}