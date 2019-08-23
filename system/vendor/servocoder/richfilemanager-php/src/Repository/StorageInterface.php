<?php

namespace RFM\Repository;

interface StorageInterface
{
    /**
     * Return storage name string.
     *
     * @return string
     */
    public function getName();

    /**
     * Set configuration options for storage.
     * Merge config file options array with custom options array.
     *
     * @param array $options
     */
    public function setConfig($options);

    /**
     * Get configuration options specific for storage.
     *
     * @param array|string $key
     * @param null|mixed $default
     * @return mixed
     */
    public function config($key = null, $default = null);

    /**
     * Set user storage folder.
     *
     * @param string $path
     * @param bool $makeDir
     */
    public function setRoot($path, $makeDir);

    /**
     * Get user storage folder.
     *
     * @return string
     */
    public function getRoot();

    /**
     * Get user storage folder without document root
     *
     * @return string
     */
    public function getDynamicRoot();

    /**
     * Return path without storage root path.
     *
     * @param string $path
     * @return string
     */
    public function getRelativePath($path);

    /**
     * Create new folder.
     *
     * @param ItemModelInterface $target
     * @param ItemModelInterface $prototype
     * @param $options array
     * @return bool
     */
    public function createFolder($target, $prototype, $options);

    /**
     * Retrieve mime type of file.
     *
     * @param string $path - absolute or relative path
     * @return string
     */
    public function getMimeType($path);

    /**
     * Defines size of file.
     *
     * @param string $path
     * @return int|string
     */
    public function getFileSize($path);

    /**
     * Return summary info for specified folder.
     *
     * @param string $dir
     * @param array $result
     * @return array
     */
    public function getDirSummary($dir, &$result);
}