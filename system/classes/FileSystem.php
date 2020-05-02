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
     * Remove file(s) or dir(s)
     *
     * @param  string  $path  path to remove
     * @param  bool    $isRecursive
     * @return bool true on success
     */
    public static function remove($path, $isRecursive = true)
    {
        $flag = $isRecursive ? '-rf ' : '-f ';

        return @\System::rm($flag . $path);
    }

    /**
     * Normalize a file name so it can safely used both on Windows and Unixy systems like Linux
     *
     * @param  string  $fileName
     * @return string
     * @see https://en.wikipedia.org/wiki/Filename#Comparison_of_filename_limitations
     */
    public static function normalizeFileName($fileName)
    {
        $fileName = basename($fileName);
        $fileName = preg_replace('@[\x00-\x1f\x5c\x7f<>:\"/|?*]@', '_', $fileName);

        return $fileName;
    }
}
