<?php

namespace RFM\Event\Api;

use Symfony\Component\EventDispatcher\Event;
use RFM\Repository\ItemData;

/**
 * API event. Dispatched each time new files have been downloaded.
 */
class AfterItemDownloadEvent extends Event
{
    const NAME = 'api.after.item.download';

    /**
     * @var ItemData
     */
    protected $itemData;

    /**
     * AfterItemDownloadEvent constructor.
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
    public function getDownloadedItemData()
    {
        return $this->itemData;
    }
}