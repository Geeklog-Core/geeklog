<?php

namespace RFM\Event\Api;

use Symfony\Component\EventDispatcher\Event;
use RFM\Repository\ItemData;

/**
 * API event. Dispatched each time a new folder is created.
 */
class AfterFolderCreateEvent extends Event
{
    const NAME = 'api.after.folder.create';

    /**
     * @var ItemData
     */
    protected $itemData;

    /**
     * AfterFolderCreateEvent constructor.
     *
     * @param ItemData $itemData
     */
    public function __construct(ItemData $itemData)
    {
        $this->itemData = $itemData;
    }

    /**
     * @return ItemData
     */
    public function getFolderData()
    {
        return $this->itemData;
    }
}