<?php

namespace RFM\Repository;

interface ItemModelInterface
{
    /**
     * Get storage instance associated with model item.
     *
     * @return StorageInterface
     */
    public function getStorage();

    /**
     * Associate storage with model item.
     *
     * @param string $storageName
     */
    public function setStorage($storageName);

    /**
     * Return relative path to item.
     *
     * @return string
     */
    public function getRelativePath();

    /**
     * Return absolute path to item.
     *
     * @return string
     */
    public function getAbsolutePath();

    /**
     * Return path without storage root path, prepended with dynamic folder.
     * Based on relative item path.
     *
     * @return mixed
     */
    public function getDynamicPath();

    /**
     * Return thumbnail relative path from given path.
     * Work for both files and dirs paths.
     *
     * @return string
     */
    public function getThumbnailPath();

    /**
     * Return original relative path for thumbnail model.
     * Work for both files and dirs paths.
     *
     * @return string
     */
    public function getOriginalPath();

    /**
     * Validate whether item is file or folder.
     *
     * @return bool
     */
    public function isDirectory();

    /**
     * Validate whether file or folder exists.
     *
     * @return bool
     */
    public function isExists();

    /**
     * Check whether the item is root folder.
     *
     * @return bool
     */
    public function isRoot();

    /**
     * Check whether file is image, based on its mime type.
     *
     * @return string
     */
    public function isImageFile();

    /**
     * Check whether item path is valid by comparing paths.
     *
     * @return bool
     */
    public function isValidPath();

    /**
     * Check the patterns blacklist for path.
     *
     * @return bool
     */
    public function isAllowedPattern();

    /**
     * Check the global blacklists for this file path.
     *
     * @return bool
     */
    public function isUnrestricted();

    /**
     * Verify if item has read permission.
     *
     * @return bool
     */
    public function hasReadPermission();

    /**
     * Verify if item has write permission.
     *
     * @return bool
     */
    public function hasWritePermission();

    /**
     * Check that item exists and path is valid.
     *
     * @return void
     */
    public function checkPath();

    /**
     * Check that item has read permission.
     *
     * @return void
     */
    public function checkReadPermission();

    /**
     * Check that item can be written to.
     *
     * @return void
     */
    public function checkWritePermission();

    /**
     * Build and return item data class instance.
     *
     * @return ItemData
     */
    public function getData();

    /**
     * Return model for parent folder on the current item.
     * Create and cache if not existing yet.
     *
     * @return null|self
     */
    public function closest();

    /**
     * Return model for thumbnail of the current item.
     * Create and cache if not existing yet.
     *
     * @return null|self
     */
    public function thumbnail();

    /**
     * Create thumbnail from the original image.
     *
     * @return void
     */
    public function createThumbnail();

    /**
     * Remove current file or folder.
     *
     * @return bool
     */
    public function remove();
}