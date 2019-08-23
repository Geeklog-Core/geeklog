<?php

namespace RFM\Event\Api;

use Symfony\Component\EventDispatcher\Event;
use RFM\Repository\ItemData;

/**
 * API event. Dispatched each time when file or folder is deleted.
 */
class AfterItemDeleteEvent extends Event
{
    const NAME = 'api.after.item.delete';

    /**
     * @var ItemData
     */
    protected $originalItemData;

    /**
     * AfterItemDeleteEvent constructor.
     *
     * @param ItemData $originalItemData
     */
    public function __construct(ItemData $originalItemData)
    {
        $this->originalItemData = $originalItemData;
    }

    /**
     * @return ItemData
     */
    public function getOriginalItemData()
    {
        return $this->originalItemData;
    }
}