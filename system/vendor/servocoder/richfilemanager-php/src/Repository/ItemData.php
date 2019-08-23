<?php

namespace RFM\Repository;

use function RFM\app;

class ItemData
{
    const TYPE_FILE = 'file';
    const TYPE_FOLDER = 'folder';

    public $pathRelative;
    public $pathAbsolute;
    public $pathDynamic;
    public $isDirectory;
    public $isExists;
    public $isImage;
    public $isRoot;
    public $isReadable;
    public $isWritable;
    public $timeCreated;
    public $timeModified;
    public $basename;
    public $size = 0;
    public $imageData = [];

    /**
     * Format item data to the format compatible with JSON API
     *
     * @return array
     */
    public function formatJsonApi()
    {
        if ($this->isDirectory) {
            return $this->getJsonFolderTemplate();
        } else {
            return $this->getJsonFileTemplate();
        }
    }

    /**
     * File item template.
     *
     * @return array
     */
    protected function getJsonFileTemplate()
    {
        return [
            "id"    => $this->pathRelative,
            "type"  => self::TYPE_FILE,
            "attributes" => [
                'name'      => $this->basename,
                'path'      => $this->pathDynamic,
                'readable'  => (int)$this->isReadable,
                'writable'  => (int)$this->isWritable,
                'created'   => $this->timeCreated,
                'modified'  => $this->timeModified,
                'size'      => $this->size,
                'width'     => isset($this->imageData['width']) ? $this->imageData['width'] : 0,
                'height'    => isset($this->imageData['height']) ? $this->imageData['height'] : 0,
            ]
        ];
    }

    /**
     * Folder item template.
     *
     * @return array
     */
    protected function getJsonFolderTemplate()
    {
        return [
            "id"    => $this->pathRelative,
            "type"  => self::TYPE_FOLDER,
            "attributes" => [
                'name'      => $this->basename,
                'path'      => $this->pathDynamic,
                'readable'  => (int)$this->isReadable,
                'writable'  => (int)$this->isWritable,
                'created'   => $this->timeCreated,
                'modified'  => $this->timeModified,
            ]
        ];
    }
}