<?php

namespace RFM\Event\Api;

use Symfony\Component\EventDispatcher\Event;
use RFM\Repository\ItemData;

/**
 * API event. Dispatched each time when file or folder is moved.
 */
class AfterItemMoveEvent extends Event
{
    const NAME = 'api.after.item.move';

    /**
     * @var ItemData
     */
    protected $itemData;

    /**
     * @var ItemData
     */
    protected $originalItemData;

    /**
     * AfterItemMoveEvent constructor.
     *
     * @param ItemData $itemData
     * @param ItemData $originalItemData
     */
    public function __construct(ItemData $itemData, ItemData $originalItemData)
    {
        $this->itemData = $itemData;
        $this->originalItemData = $originalItemData;
    }

    /**
     * @return ItemData
     */
    public function getItemData()
    {
        return $this->itemData;
    }

    /**
     * @return ItemData
     */
    public function getOriginalItemData()
    {
        return $this->originalItemData;
    }
}