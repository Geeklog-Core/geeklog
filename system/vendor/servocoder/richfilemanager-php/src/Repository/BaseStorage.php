<?php

namespace RFM\Repository;

use function RFM\app;
use function RFM\config;

/**
 *    BaseStorage PHP class
 *
 *    Base class created to define base methods
 *
 *    @license    MIT License
 *    @author        Pavel Solomienko <https://github.com/servocoder/>
 *    @copyright    Authors
 */

abstract class BaseStorage
{
    const STORAGE_S3_NAME = 's3';
    const STORAGE_LOCAL_NAME = 'local';

    /**
     * Storage name string.
     *
     * @var string
     */
    private $storageName;

    /**
     * Set unique name for storage.
     *
     * @param string $name
     */
    protected function setName($name)
    {
        $this->storageName = $name;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->storageName;
    }

    /**
     * @inheritdoc
     */
    public function setConfig($config)
    {
        app()->configure($this->getName(), $config);

        // exclude image thumbnails folder from the output
        if ($this->config('security.patterns.policy') === 'DISALLOW_LIST') {
            $configKey = $this->getName() . '.security.patterns.restrictions';
            $pattern = $this->buildPathPattern($this->config('images.thumbnail.dir'), true);
            $patterns = config($configKey, []);
            $patterns[] = $pattern;
            config([$configKey => $patterns]);
        }
    }

    /**
     * @inheritdoc
     */
    public function config($key = null, $default = null)
    {
        return config($this->getName() . ".{$key}", $default);
    }

    /**
     * Turn a path into the pattern for 'security.patterns.restrictions' configuration option.
     *
     * @param string $path
     * @param bool $isDir
     * @return string
     */
    public function buildPathPattern($path, $isDir = false)
    {
        $path = '*/'. $path . ($isDir ? '/*' : '');

        return $this->cleanPath($path);
    }

    /**
     * Return storage instance that stores image thumbnails.
     *
     * @return \RFM\Repository\StorageInterface|\RFM\Repository\Local\Storage|\RFM\Repository\S3\Storage
     */
    public function forThumbnail()
    {
        $storageName = ($this->config('images.thumbnail.useLocalStorage') === true)
            ? self::STORAGE_LOCAL_NAME
            : self::STORAGE_S3_NAME;

        return app()->getStorage($storageName);
    }

    /**
     * Clean string to retrieve correct file/folder name.
     * @param string $string
     * @param array $allowed
     * @return array|mixed
     */
    public function normalizeString($string, $allowed = [])
    {
        $allow = '';
        if(!empty($allowed)) {
            foreach ($allowed as $value) {
                $allow .= "\\$value";
            }
        }

        if($this->config('security.normalizeFilename') === true) {
            // Remove path information and dots around the filename, to prevent uploading
            // into different directories or replacing hidden system files.
            // Also remove control characters and spaces (\x00..\x20) around the filename:
            $string = trim(basename(stripslashes($string)), ".\x00..\x20");

            // Replace chars which are not related to any language
            $replacements = [' '=>'_', '\''=>'_', '/'=>'', '\\'=>''];
            $string = strtr($string, $replacements);
        }

        if($this->config('options.charsLatinOnly') === true) {
            // transliterate if extension is loaded
            if(extension_loaded('intl') === true && function_exists('transliterator_transliterate')) {
                $options = 'Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;';
                $string = transliterator_transliterate($options, $string);
            }
            // clean up all non-latin chars
            $string = preg_replace("/[^{$allow}_a-zA-Z0-9]/u", '', $string);
        }

        return $string;
    }

    /**
     * Check whether given mime type is image.
     *
     * @param string $mime
     * @return bool
     */
    public function isImageMimeType($mime)
    {
        $imagesMime = [
            "image/jpeg",
            "image/png",
            "image/gif",
            "image/bmp",
            "image/svg+xml",
        ];
        return in_array($mime, $imagesMime);
    }

    /**
     * Clean path string to remove multiple slashes, etc.
     *
     * @param string $string
     * @return string
     */
    abstract public function cleanPath($string);
}
