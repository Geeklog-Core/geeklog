<?php

namespace RFM\Factory;

use RFM\Repository\Local\ItemModel as LocalItemModel;
use RFM\Repository\S3\ItemModel as S3ItemModel;

class Factory
{
    /**
     * Return new item instance for image thumbnail.
     *
     * @param \RFM\Repository\ItemModelInterface $imageModel
     * @return LocalItemModel|S3ItemModel
     */
    public function createThumbnailModel($imageModel)
    {
        $storage = $imageModel->getStorage();
        $path = $imageModel->getThumbnailPath();

        if ($storage->config('images.thumbnail.useLocalStorage') === true) {
            return new LocalItemModel($path, true);
        } else {
            $itemClass = get_class($imageModel);
            return new $itemClass($path, true);
        }
    }
}