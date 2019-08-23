<?php

namespace RFM\Event\Api;

use Symfony\Component\EventDispatcher\Event;
use RFM\Repository\ItemData;

/**
 * API event. Dispatched each time a folder contents is sought.
 */
class AfterFolderSeekEvent extends Event
{
    const NAME = 'api.after.folder.seek';

    /**
     * @var ItemData
     */
    protected $itemData;

    /**
     * @var string
     */
    protected $searchString;

    /**
     * @var array
     */
    protected $filesList;

    /**
     * AfterFolderSeekEvent constructor.
     *
     * @param ItemData $itemData
     * @param string $searchString
     * @param array $filesList
     */
    public function __construct(ItemData $itemData, $searchString, array $filesList)
    {
        $this->itemData = $itemData;
        $this->searchString = $searchString;
        $this->filesList = $filesList;
    }

    /**
     * @return ItemData
     */
    public function getFolderData()
    {
        return $this->itemData;
    }

    /**
     * @return string
     */
    public function getSearchString()
    {
        return $this->searchString;
    }

    /**
     * Return a list of files found.
     *
     * @return array
     */
    public function getSearchResult()
    {
        return $this->filesList;
    }
}