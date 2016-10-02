<?php

namespace Geeklog;

/**
 * Class FileSystem
 *
 * @package Geeklog
 */
class FileSystem
{
    /**
     * Remove file(s) or dir(s)
     *
     * @param  string $path path to remove
     * @param  bool $isRecursive
     * @return bool true on success
     */
    public static function remove($path, $isRecursive = true)
    {
        $flag = $isRecursive ? '-rf ' : '-f ';

        return @\System::rm($flag . $path);
    }
}
