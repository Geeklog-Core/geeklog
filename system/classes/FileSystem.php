<?php

namespace Geeklog;

/**
 * Class FileSystem
 *
 * @package Geeklog
 */
abstract class FileSystem
{
    /**
     * Remove the directory and all files and directories under it
     *
     * @param  string  $dir  the directory to remove
     * @return bool          true on success, false otherwise
     */
    public static function remove($dir)
    {
        $retval = true;

        $dir = rtrim($dir, '/\\');
        if (!is_dir($dir)) {
            return false;
        }

        foreach (scandir($dir) as $item) {
            if (($item !== '.') && ($item !== '..')) {
                $path = $dir . DIRECTORY_SEPARATOR . $item;

                if (is_dir($path)) {
                    if (!self::remove($path)) {
                        $retval = false;
                    }
                } else {
                    if (!@unlink($path)) {
                        $retval = false;
                    }
                }
            }
        }

        if ($retval) {
            $retval = @rmdir($dir);
        }

        return $retval;
    }

    /**
     * Return if the file name given is safe to use on ANY OS
     *
     * @param  string  $fileName
     * @return bool
     */
    public static function isValidFileName($fileName)
    {
        return (strpos($fileName, '.') !== 0)                    // File name should not start with '.'
            && (substr($fileName, -1) !== '.')                   // and should not end with '.'
            && (strpos($fileName, '..') === false)               // and should not include '..'
            && preg_match('/\A[0-9a-zA-Z_.-]+\z/', $fileName);  // and contains only '0'-'9', 'a'-'z', 'A'-'Z', underscore, '.' and '-'
    }

    /**
     * Normalize a file name so it can safely be used both on Windows and Unixy systems like Linux
     *
     * @param  string  $path
     * @return string
     * @see https://en.wikipedia.org/wiki/Filename#Comparison_of_filename_limitations
     */
    public static function normalizeFileName($path)
    {
        $fileName = basename($path);
        $fileName = preg_replace('@[\x00-\x1f\x5c\x7f<>:\"/|?*]@', '_', $fileName);
        $dir = dirname($path);

        return ($dir === '.') ? $fileName : $dir . DIRECTORY_SEPARATOR . $fileName;
    }
}
