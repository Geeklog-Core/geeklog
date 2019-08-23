<?php

namespace RFM\Event\Api;

use Symfony\Component\EventDispatcher\Event;
use RFM\Repository\ItemData;

/**
 * API event. Dispatched each time new files have been uploaded.
 */
class AfterFileUploadEvent extends Event
{
    const NAME = 'api.after.file.upload';

    /**
     * @var ItemData
     */
    protected $itemData;

    /**
     * AfterFileUploadEvent constructor.
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
    public function getUploadedFileData()
    {
        return $this->itemData;
    }
}