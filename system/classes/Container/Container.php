<?php

namespace Geeklog\Container;

use Closure;
use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param  string  $id  Identifier of the entry to look for.
     * @return mixed Entry.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new ContainerNotFoundException(__METHOD__ . ": entry not found '$id'");
        }

        $item = $this->data[$id];
        if ($item instanceof Closure) {
            $item = $this->data[$id] = $item();
        }

        return $item;
    }

    /**
     * Set an item to the container
     *
     * @param  string  $id
     * @param  mixed   $item
     * @return void
     */
    public function set($id, $item)
    {
        if ($this->has($id)) {
            throw new InvalidArgumentException(__METHOD__ . ": item named '$id' already exists");
        } else {
            $this->data[$id] = $item;
        }
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param  string  $id  Identifier of the entry to look for.
     * @return bool
     */
    public function has($id)
    {
        return array_key_exists($id, $this->data);
    }
}
