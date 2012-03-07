<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | unpacker.class.php                                                        |
// |                                                                           |
// | unpacker - archive libs wrapper                                           |
// | This class wraps calls to pecl Zip, pear Zip, pear Tar, using the best    |
// | package available to unpack or list information about the archive.        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2010 by the following authors:                         |
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

/**
 * Geeklog plugin unpacker - Archive Libs Wrapper
 * 
 * This class wraps calls to pecl Zip, pear Zip, pear Tar, using the best 
 * package available to unpack or list information about the archive.
 * 
 * @author Justin Carlson, justin DOT carlson AT gmail DOT com
 * 
 */
class unpacker {

    // mime types ( these are not very reliable, varies browser to browser )
    // for the best results, pass the real filename as well as the mime type
    var $mime_def = array('application/zip'              => 'zip',
    					  'application/x-zip'            => 'zip',
    					  'application/x-zip-compressed' => 'zip',
    					  'multipart/x-zip'              => 'zip',
    					  'application/gzip'             => 'tar',
    					  'application/tar'              => 'tar',
    					  'application/x-tar'            => 'tar',
    					  'application/x-gtar'           => 'tar',
    					  'application/x-gzip'           => 'tar',
    					  'application/x-gzip-compressed'=> 'tar',
    					  'application/octet-stream'     => 'tar',
    					  'application/x-compress'       => 'tar',
    					  'application/x-compressed'     => 'tar');

    var $file = null; // archive name 
    var $filesize = null; // archive size (in bytes)
    var $ext = null; // archive ext 
    var $contents = null; // archive contents 
    var $archive = null; // archive resource handle
    var $errorno = null; // error number ( set when returned false )
    var $error = null; // error text ( set when returned false )
    var $u_size = null; // uncompressed archive size 
    var $d_sep = null; // directory separator default
    var $type = null; // archive type  
    var $comp = null; // archive compression type (private)


    /**
     * Constructor
     * 
     * @param string $file full path to archive
     * @param string $mime_type mime type ( optional, application/zip, /tar, etc )
     * @return boolean $success result of loading archive passed
     */
    function unpacker($file, $mime_type = null) {

        // default directory separator
        $this->d_sep = DIRECTORY_SEPARATOR;

        // if the file doesn't have it's path, assume local
        if (! strstr($file, $this->d_sep)) {
            $file = getcwd() . $this->d_sep . $file;
        }

        // make sure the file exists
        if (file_exists($file)) {

            // copy vars
            $this->file = $file;
            $this->filesize = filesize($file);
            $this->ext = strtolower(substr($file, - 4));

            // if the type is passed, store it
            if ($mime_type != null) {

                if (isset($this->mime_def[$mime_type])) {
                    $this->type = $this->mime_def[$mime_type];
                } else {
                    return $this->setError('400', 'Invalid MIME Type');
                }

            }

            if ($this->type == null || $this->type == 'other') {

                // if a known mime type was not provided, expect real filename
                // mime types are not reliable so this is the reccommended way
                // for example: unpacker($_FILES['foo']['name'],$type); 
                // .tar, .tgz, .tar.gz, .tar.bz2, and .tar.bz are supported
                if ($this->ext == 'r.gz' || $this->ext == '.tgz') {
                    $this->type = 'tar';
                    $this->comp = 'gz';
                } elseif ($this->ext == 'r.bz' || $this->ext == '.bz2') {
                    $this->type = 'tar';
                    $this->comp = 'bz2';
                } else {
                    $this->type = str_replace('.', '', $this->ext);
                }

                // see if we know of a mime type for this ext
                if (in_array($this->type, $this->mime_def) === false) {
                    return $this->setError('400', 'Invalid File Extension');
                }
            }

            // call the load wrapper, return result
            return $this->load_file();

        } else {
            // file did not exist
            return false;
        }

    }

    /**
     * Open - Constructor Wrapper
     * This clears the vars and loads another file.
     * ( May never be used )
     * 
     * @param string $file full path to archive
     * @param string $optional_type mime type ( application/zip, /tar, etc )
     * @return boolean $success result of loading archive passed
     */
    function open($file, $optional_type = false) {

        $this->ext = null;
        $this->file = null;
        $this->filesize = null;
        $this->contents = null;
        $this->archive = null;
        $this->errorno = null;
        $this->error = null;
        $this->u_size = null;
        $this->d_sep = null;
        $this->type = null;
        return $this->unpacker($file, $optional_type);
    }

    /**
     * 
     * Decides which loader to call, or returns false if one isn't found.
     * 
     * @return boolean $success result of loading archive passed
     */
    function load_file() {

        $handler = 'load_' . $this->type;
        if (method_exists($this, $handler)) {
            return $this->$handler();
        } else {
            return $this->setError('406', 'Unacceptable archive.');
        }
    }

    /**
     * load a zip archive
     * 
     * @return boolean $success result of loading archive passed
     */
    function load_zip() {

        if (class_exists('ZipArchive')) {

            // Use PECL ZIP
            $this->archive = new ZipArchive();
            $result = $this->archive->open($this->file);
            if ($result === false) {
                return $this->setError($result, 'ZipArchive Error');
            }

        } else {

            // use Pear Archive_Zip     
            require_once 'Archive/Zip.php';
            $this->archive = new Archive_Zip($this->file);
            // unfortunately, we can't tell if it succeeded

        }

        // return resource handle or result
        return true;
    }

    /**
     * load a tar archive
     * 
     * @return boolean $success result of loading archive passed
     */
    function load_tar() {

        // use Pear Archive_Tar 
        require_once 'Archive/Tar.php';
        $this->archive = new Archive_Tar($this->file, $this->comp);

        // unfortunately, we can't tell if it succeeded
        return ($this->archive);

    }

    /**
     * return contents of archive (wrapper)
     * 
     * @return array array(array('filename','size','etc')) archive contents
     */
    function getlist() {

        // see if content are cached
        if (is_array($this->contents)) {
            return $this->contents;
        }        

        // not cached, load and cache the content list
        $handler = 'list_' . $this->type;
        if (method_exists($this, $handler)) {
            $this->contents = $this->$handler();
            return $this->contents;
        } else {
            return $this->setError('405', 'Unpacker called getlist ' . 'with unknown handler.');
        }

    }

    /**
     * return contents of zip archive
     * 
     * @return array array(array('filename','size','etc')) archive contents
     */
    function list_zip() {

        // using PECL::ZipArchive
        if (class_exists('ZipArchive')) {

            // catch empty archive
            if ($this->archive->numFiles < 1) {
                return $this->setError('411', 'Archive is empty.');
            }

            // reset cache
            $this->contents = array();
            for ($i = 0; $i < $this->archive->numFiles; $i ++) {

                // Make ZipArchive's info look like Archive_Zip's 
                $zip_entry = $this->archive->statIndex($i);
                $this->contents[$i]['filename'] = $zip_entry['name'];
                $this->contents[$i]['size'] = $zip_entry['size'];
                $this->contents[$i]['compressed'] = $zip_entry['comp_size'];
                $this->contents[$i]['method'] = $zip_entry['comp_method'];

            }
            // return the contents list            
            return $this->contents;

        // using PEAR::Archive_Zip
        } else {

            $this->contents = $this->archive->listContent();
            if (is_array($this->contents)) {
                return $this->contents;
            } else {
                return $this->setError('411', 'Archive is empty.');
            }

        }
    }

    /**
     * return contents of tar archive
     * 
     * @return array array(array('filename','size','etc')) archive contents
     */
    function list_tar() {

        $this->contents = $this->archive->listContent();
        if (is_array($this->contents)) {
            return $this->contents;
        } else {
            return $this->setError('411', 'Archive is empty.');
        }
    }

    /**
     * unpack the archive in the target path (wrapper)
     * 
     * @param string $target_path destination 
     * @param array $item_array array of specific path/file(s)
     * @return boolean result
     */
    function unpack($target_path, $item_array = null) {

        // make sure it's writable
        if (is_writable($target_path) === false) {
            return $this->setError('403', 'Permission denied writing to path.');
        }

        // make sure target ends with slash
        if (substr($target_path, - 1) != $this->d_sep) {
            $target_path .= $this->d_sep;
        }

        $handler = 'unpack_' . $this->type;
        if (method_exists($this, $handler)) {
            return $this->$handler($target_path, $item_array);
        } else {
            return $this->setError('405', 'Called unpack ' . 'with unknown handler.');
        }
    }

    /**
     * unpack a zip archive in the target path 
     * 
     * @param string $target_path destination 
     * @param array $item_array array of specific path/file(s)
     * @return boolean result
     */
    function unpack_zip($target_path, $item_array = null) {

        // using PECL::ZipArchive
        if (class_exists('ZipArchive')) {

            if ($this->archive) {

                if (is_array($item_array)) {

                    // bleh: it won't handle an array with one item
                    // we have to watch for that and send the string instead
                    if (count($item_array) == 1) {
                        $item_array = $item_array[0];
                    }

                    if ($this->archive->extractTo($target_path, $item_array)) {
                        return true;
                    } else {
                        return $this->setError('406', 'Could not extract ' . ' the archive.');
                    }

                } else {

                    if ($this->archive->extractTo($target_path)) {
                        return true;
                    }

                }

            } else {

                return $this->setError('415', 'Tried to unpack nothing!');
            }

        // using PEAR::Archive_Zip
        } else {

            if (is_array($item_array) === true) {
                $result = $this->archive->extract(array('add_path' => $target_path, 'by_name' => $item_array));
            } else {
                $result = $this->archive->extract(array('add_path' => $target_path));
            }
            // extract() returns an array on success and 0 on failure
            if ($result === 0) {
                return false;
            } else {
                return true;
            }

        }
    }

    /**
     * unpack a tar archive in the target path 
     * 
     * @param string $target_path destination 
     * @param array $item_array array of specific path/file(s)
     * @return boolean result
     */
    function unpack_tar($target_path, $item_array = null) {

        if (is_array($item_array)) {
            if ($this->archive->extractList($item_array, $target_path)) {
                return true;
            }
        } else {
            if ($this->archive->extract($target_path)) {
                return true;
            }
        }
    }

    /**
     * return the first directory name in the archive 
     * 
     * @return mixed string directory name, or boolean false
     */
    function getdir() {

        if (is_array($this->contents) === false) {
            $this->contents = $this->getlist();
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
    function getunpackedsize() {

        if (is_null($this->u_size) === false) {
            return $this->u_size;
        }
        if (is_array($this->contents) === false) {
            $this->contents = $this->getlist();
        }
        if (is_array($this->contents) && is_array($this->contents[0])) {
            foreach ( $this->contents as $temp ) {
                $this->u_size += $temp['size'];
            }
            unset($temp);

            return ($this->u_size);

        } else {
            return false;
        }
    }

     /**
     * sets an error number and string to report if asked 
     * acts as a wrapper for return false, to set an error
     * at the same time
     * 
     * @param string $errorno error number ( anything goes )
     * @param string $error error text ( anything goes ) 
     * @return boolean, always false
     */
    function setError($errorno, $error) {

        $this->errorno = $errorno;
        $this->error = $error;
        return false;
    }

}

?>
