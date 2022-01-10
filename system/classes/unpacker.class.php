<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | unpacker.class.php                                                        |
// |                                                                           |
// | unpacker - archive libs wrapper                                           |
// | This class wraps calls to pecl Zip, pear Zip, pear Tar, using the best    |
// | package available to unpack or list information about the archive.        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2012 by the following authors:                         |
// |                                                                           |
// | Authors: Justin Carlson        - justin DOT carlson AT gmail DOT com      |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

use splitbrain\PHPArchive\Archive;
use splitbrain\PHPArchive\ArchiveIllegalCompressionException;
use splitbrain\PHPArchive\ArchiveIOException;
use splitbrain\PHPArchive\Tar;
use splitbrain\PHPArchive\Zip;

/**
 * Geeklog plugin unpacker - Archive Libs Wrapper
 * This class wraps calls to pecl Zip, pear Zip, pear Tar, using the best
 * package available to unpack or list information about the archive.
 *
 * @author Justin Carlson, justin DOT carlson AT gmail DOT com
 */
class Unpacker
{
    // MIME types (these are not very reliable, varies browser to browser)
    // for the best results, pass the real filename as well as the MIME type
    private $mime_def = array(
        'application/zip'               => 'zip',
        'application/x-zip'             => 'zip',
        'application/x-zip-compressed'  => 'zip',
        'multipart/x-zip'               => 'zip',
        'application/gzip'              => 'tar',
        'application/tar'               => 'tar',
        'application/x-tar'             => 'tar',
        'application/x-gtar'            => 'tar',
        'application/x-gzip'            => 'tar',
        'application/x-gzip-compressed' => 'tar',
        'application/octet-stream'      => 'tar',
        'application/x-compress'        => 'tar',
        'application/x-compressed'      => 'tar',
    );

    private $file = null; // archive name
    private $fileSize = null; // archive size (in bytes)
    private $ext = null; // archive ext
    private $contents = null; // archive contents

    /**
     * @var Archive
     */
    private $archive = null; // archive resource handle
    private $errorNo = null; // error number ( set when returned false )
    private $error = null; // error text ( set when returned false )
    private $u_size = null; // uncompressed archive size
    private $type = null; // archive type
    private $comp = null; // archive compression type (private)

    /**
     * Constructor
     *
     * @param  string $file     full path to archive
     * @param  string $mimeType mime type ( optional, application/zip, /tar, etc )
     * @throws InvalidArgumentException
     */
    public function __construct($file, $mimeType = null)
    {
        $this->open($file, $mimeType);

        // Check if all files in the archive have the proper file name
        $files = $this->getList();

        if (is_array($files) && (count($files) > 0)) {
            foreach ($files as $file) {
                if (!\Geeklog\FileSystem::isValidFileName(basename($file['filename']))) {
                    throw new InvalidArgumentException("Bad file name in the archive detected: {$file['filename']}");
                }
            }
        }
    }

    /**
     * Open an archive file
     *
     * @param  string $file     full path to archive
     * @param  string $mimeType mime type ( application/zip, /tar, etc )
     * @return bool   result of loading archive passed
     */
    public function open($file, $mimeType = null)
    {
        $this->ext = null;
        $this->file = null;
        $this->fileSize = null;
        $this->contents = null;
        $this->archive = null;
        $this->errorNo = null;
        $this->error = null;
        $this->u_size = null;
        $this->type = null;

        // if the file doesn't exist in the designated path, assume local
        if (!file_exists($file)) {
            $file = getcwd() . DIRECTORY_SEPARATOR . $file;
        }

        // make sure the file exists
        if (file_exists($file)) {
            // copy vars
            $this->file = $file;
            $this->fileSize = filesize($file);
            $this->ext = strtolower(substr($file, strrpos($file, '.')));

            // if the type is passed, store it
            if (!empty($mimeType)) {
                if (isset($this->mime_def[$mimeType])) {
                    $this->type = $this->mime_def[$mimeType];
                } else {
                    return $this->setError('400', 'Invalid MIME Type');
                }
            }

            if ($this->type == null || $this->type === 'other') {
                // if a known mime type was not provided, expect real filename
                // mime types are not reliable so this is the recommended way
                // for example: unpacker($_FILES['foo']['name'],$type);
                // .tar, .tgz, .tar.gz, .tar.bz2, and .tar.bz are supported
                if ($this->ext === '.gz' || $this->ext === '.tgz') {
                    $this->type = 'tar';
                    $this->comp = 'gz';
                } elseif ($this->ext === '.bz' || $this->ext === '.bz2') {
                    $this->type = 'tar';
                    $this->comp = 'bz2';
                } elseif ($this->ext === '.zip') {
                    $this->type = 'zip';
                    $this->comp = 'zip';
                } else {
                    $this->type = str_replace('.', '', $this->ext);
                }

                // see if we know of a mime type for this ext
                if (!in_array($this->type, $this->mime_def)) {
                    return $this->setError('400', 'Invalid File Extension');
                }
            }

            // call the load wrapper, return result
            return $this->loadFile();
        } else {
            // file did not exist
            return false;
        }
    }

    /**
     * Decides which loader to call, or returns false if one isn't found.
     *
     * @return bool result of loading archive passed
     */
    private function loadFile()
    {
        $handler = 'load_' . $this->type;

        if (method_exists($this, $handler)) {
            return $this->$handler();
        } else {
            return $this->setError('406', 'Unacceptable archive.');
        }
    }

    /**
     * Load a zip archive
     *
     * @return bool result of loading archive passed
     */
    private function load_zip()
    {
        // Use splitbrain\PHPArchive\Zip
        $this->archive = new Zip();

        try {
            $this->archive->open($this->file);
        } catch (ArchiveIOException $e) {
            return $this->setError(-1, $e->getMessage());
        }

        return true;
    }

    /**
     * Load a tar archive
     *
     * @return bool result of loading archive passed
     */
    private function load_tar()
    {
        // Use splitbrain\PHPArchive\Tar
        $this->archive = new Tar();

        try {
            $this->archive->open($this->file);
        } catch (ArchiveIOException $e) {
            return $this->setError(-1, $e->getMessage());
        } catch (ArchiveIllegalCompressionException $e) {
            return $this->setError(-1, $e->getMessage());
        }

        return true;
    }

    /**
     * Return contents of archive (wrapper)
     *
     * @return array|false array(array('filename','size','etc')) archive contents
     */
    public function getList()
    {
        // See if contents are cached
        if (is_array($this->contents)) {
            return $this->contents;
        }

        // If not cached, load and cache the content list
        $handler = 'list_' . $this->type;

        if (method_exists($this, $handler)) {
            $this->contents = $this->$handler();

            return $this->contents;
        } else {
            return $this->setError('405', 'Unpacker called getList ' . 'with unknown handler.');
        }
    }

    /**
     * Convert an array of FileInfo objects into an associative array which is used
     * by 'Archive/Zip.php' and 'Archive/Tar.php'
     *
     * @param  array $items an array of FileInfo objects
     * @return array
     */
    private function convertFileInfoToArray(array $items)
    {
        $retval = array();

        foreach ($items as $item) {
            $retval[] = array(
                'size'       => $item->getSize(),
                'compressed' => $item->getCompressedSize(),
                'mtime'      => $item->getMtime(),
                'gid'        => $item->getGid(),
                'uid'        => $item->getUid(),
                'comment'    => $item->getComment(),
                'group'      => $item->getGroup(),
                'isdir'      => $item->getIsdir(),
                'mode'       => $item->getMode(),
                'owner'      => $item->getOwner(),
                'filename'   => $item->getPath(),
                'method'     => '',
            );
        }

        return $retval;
    }

    /**
     * Return contents of a zip archive
     *
     * @return array|false array(array('filename','size','etc')) archive contents
     */
    private function list_zip()
    {
        // Use splitbrain\PHPArchive\Zip
        try {
            $this->contents = $this->convertFileInfoToArray($this->archive->contents());

            if (is_array($this->contents) && (count($this->contents) > 0)) {
                return $this->contents;
            } else {
                return $this->setError('411', 'Archive is empty.');
            }
        } catch (ArchiveIOException $e) {
            return $this->setError(-1, $e->getMessage());
        }
    }

    /**
     * return contents of tar archive
     *
     * @return array|false array(array('filename','size','etc')) archive contents
     */
    private function list_tar()
    {
        $this->contents = $this->convertFileInfoToArray($this->archive->contents());

        if (is_array($this->contents) && (count($this->contents) > 0)) {
            return $this->contents;
        } else {
            return $this->setError('411', 'Archive is empty.');
        }
    }

    /**
     * unpack the archive in the target path (wrapper)
     *
     * @param  string $target_path destination
     * @param  string $item        specific file to extract
     * @return bool   result
     */
    public function unpack($target_path, $item = null)
    {
        // make sure it's writable
        if (is_writable($target_path) === false) {
            return $this->setError('403', 'Permission denied writing to path.');
        }

        // make sure target ends with slash
        if (substr($target_path, -1) !== DIRECTORY_SEPARATOR) {
            $target_path .= DIRECTORY_SEPARATOR;
        }

        $handler = 'unpack_' . $this->type;

        if (method_exists($this, $handler)) {
            return $this->$handler($target_path, $item);
        } else {
            return $this->setError('405', 'Called unpack ' . 'with unknown handler.');
        }
    }

    /**
     * unpack a zip archive in the target path
     *
     * @param  string $target_path destination
     * @param  array  $item_array  array of specific path/file(s)
     * @return bool   result
     */
    private function unpack_zip($target_path, $item_array = null)
    {
        // Use splitbrain\PHPArchive\Zip
        try {
            $this->archive->open($this->file);

            if (is_array($item_array)) {
                $result = $this->archive->extract($target_path, '', '', $item_array);
            } else {
                $result = $this->archive->extract($target_path);
            }

            return (count($result) > 0);
        } catch (ArchiveIOException $e) {
            return $this->setError(-3, $e->getMessage());
        }
    }

    /**
     * unpack a tar archive in the target path
     *
     * @param  string $target_path destination
     * @param  array  $item_array  array of specific path/file(s)
     * @return bool   result
     */
    private function unpack_tar($target_path, $item_array = null)
    {
        try {
            $this->archive->open($this->file);

            if (is_array($item_array)) {
                $retval = $this->archive->extract($target_path, '', '', $item_array);
            } else {
                $retval = $this->archive->extract($target_path);
            }

            return (count($retval) > 0);
        } catch (ArchiveIOException $e) {
            return $this->setError(-4, $e->getMessage());
        }
    }

    /**
     * return the first directory name in the archive
     *
     * @return mixed string directory name, or boolean false
     */
    private function getDir()
    {
        if (!is_array($this->contents)) {
            $this->contents = $this->getList();
        }

        if (is_array($this->contents) && is_array($this->contents[0])) {
            return trim(preg_replace('/\/.*$/', '', $this->contents[0]['filename']));
        } else {
            return false;
        }
    }

    /**
     * return the total unpacked size of the archive
     *
     * @return mixed (size in bytes or false on error)
     */
    private function getUnpackedSize()
    {
        if ($this->u_size !== null) {
            return $this->u_size;
        }

        if (!is_array($this->contents)) {
            $this->contents = $this->getList();
        }

        if (is_array($this->contents) && is_array($this->contents[0])) {
            foreach ($this->contents as $temp) {
                $this->u_size += intval($temp['size'], 10);
            }

            return $this->u_size;
        } else {
            return false;
        }
    }

    /**
     * Sets an error number and string to report if asked
     * acts as a wrapper for return false, to set an error
     * at the same time
     *
     * @param string $errorNo error number ( anything goes )
     * @param string $error   error text ( anything goes )
     * @return boolean, always false
     */
    private function setError($errorNo, $error)
    {
        $this->errorNo = $errorNo;
        $this->error = $error;

        return false;
    }
}
