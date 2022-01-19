<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | upload.class.php                                                          |
// |                                                                           |
// | Geeklog file upload class library.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
 * This class will allow you to securely upload one or more files from a form
 * submitted via POST method.  Please read documentation as there are a number of
 * security related features that will come in handy for you.
 *
 * @author       Tony Bibbs, tony AT tonybibbs DOT com
 */
class Upload
{
    /**
     * @var array
     */
    private $_errors = array();

    /**
     * @var array
     */
    private $_warnings = array();

    /**
     * @var array
     */
    private $_debugMessages = array();

    /**
     * @var array
     */
    private $_allowedMimeTypes = array();

    /**
     * @var array
     */
    private $_availableMimeTypes = array();

    /**
     * @var array
     */
    private $_filesToUpload = array();

    /**
     * @var array
     */
    private $_currentFile = array();

    /**
     * @var array
     */
    private $_allowedIPS = array();

    /**
     * @var array
     */
    private $_uploadedFiles = array();

    /**
     * @var int Pixels
     */
    private $_maxImageWidth = 300;

    /**
     * @var int Pixels
     */
    private $_maxImageHeight = 300;

    /**
     * @var int in bytes
     */
    private $_maxFileSize = 1048576;

    /**
     * @var int (0-100)
     */
    private $_jpegQuality = 0;

    /**
     * @var string
     */
    private $_pathToMogrify = '';

    /**
     * @var string
     */
    private $_pathToNetPBM = '';

    /**
     * @var string
     */
    private $_imageLib = '';

    /**
     * @var bool
     */
    private $_autoResize = false;

    /**
     * @var bool
     */
    private $_keepOriginalImage = false;

    /**
     * @var int
     */
    private $_maxFileUploadsPerForm = 5;

    /**
     * @var string
     */
    private $_fileUploadDirectory = '';

    /**
     * @var string
     */
    private $_fileNames = '';

    /**
     * @var string
     */
    private $_permissions = '';

    /**
     * @var string
     */
    private $_logFile = '';

    /**
     * @var bool
     */
    private $_doLogging = false;

    /**
     * @var bool
     */
    private $_continueOnError = false;

    /**
     * @var bool
     */
    private $_debug = false;

    /**
     * @var bool
     */
    private $_limitByIP = false;

    /**
     * @var int
     */
    private $_imageIndex = 0;

    /**
     * @var bool
     */
    private $_ignoreMimeTest = false;

    /**
     * @var string
     */
    private $_thumbsDirectory = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_setAvailableMimeTypes();
    }

    /**
     * Adds a warning that was encountered
     *
     * @param    string $warningText Text of warning
     */
    private function _addWarning($warningText)
    {
        $numWarnings = count($this->_warnings);
        $numWarnings = $numWarnings + 1;
        $this->_warnings[$numWarnings] = $warningText;

        if ($this->loggingEnabled()) {
            $this->_logItem('Warning', $warningText);
        }
    }

    /**
     * Adds an error that was encountered
     *
     * @param    string $errorText Text of error
     */
    private function _addError($errorText)
    {
        $numErrors = count($this->_errors);
        $numErrors = $numErrors + 1;
        $this->_errors[$numErrors] = $errorText;

        if ($this->loggingEnabled()) {
            $this->_logItem('Error', $errorText);
        }
    }

    /**
     * Adds a debug message
     *
     * @param        string $debugText Text of debug message
     */
    private function _addDebugMsg($debugText)
    {
        $numMessages = count($this->_debugMessages);
        $numMessages = $numMessages + 1;
        $this->_debugMessages[$numMessages] = $debugText;

        if ($this->loggingEnabled()) {
            $this->_logItem('Debug', $debugText);
        }
    }

    /**
     * Logs an item to the log file
     *
     * @param    string $logType can be 'warning' or 'error'
     * @param    string $text    Text to log to log file
     * @return   boolean     Whether or not we successfully logged an item
     */
    private function _logItem($logType, $text)
    {
        $timestamp = COM_strftime("%c");
        if (!$file = fopen($this->_logFile, 'a')) {
            // couldn't open log file for writing so let's disable logging and add an error
            $this->setLogging(false);
            $this->_addError('Error writing to log file: ' . $this->_logFile . '.  Logging has been disabled');

            return false;
        }
        fputs($file, "{$timestamp} - {$logType}: {$text} " . PHP_EOL);
        fclose($file);

        return true;
    }

    /**
     * Defines superset of available Mime types.
     *
     * @param    array $mimeTypes string array of valid mime types this object will accept
     */
    private function _setAvailableMimeTypes($mimeTypes = array())
    {
        if (count($mimeTypes) === 0) {
            $this->_availableMimeTypes =
                array(
                    'application/x-gzip-compressed' => '.tar.gz,.tgz',
                    'application/x-zip-compressed'  => '.zip',
                    'application/x-tar'             => '.tar',
                    'application/x-gtar'            => '.tar',
                    'text/plain'                    => '.phps,.txt,.inc',
                    'text/html'                     => '.html,.htm',
                    'image/bmp'                     => '.bmp,.ico',
                    'image/gif'                     => '.gif',
                    'image/pjpeg'                   => '.jpg,.jpeg',
                    'image/jpeg'                    => '.jpg,.jpeg',
                    'image/png'                     => '.png',
                    'image/x-png'                   => '.png',
                    'audio/mpeg'                    => '.mp3',
                    'audio/wav'                     => '.wav',
                    'application/pdf'               => '.pdf',
                    'application/x-shockwave-flash' => '.swf',
                    'application/msword'            => '.doc',
                    'application/vnd.ms-excel'      => '.xls',
                    'application/octet-stream'      => '.fla,.psd',
                );
        } else {
            $this->_availableMimeTypes = $mimeTypes;
        }
    }

    /**
     * Checks if current file is an image
     *
     * @return boolean   returns true if file is an image, otherwise false
     */
    private function _isImage()
    {
        if (strpos($this->_currentFile['type'], 'image/') === 0) {
            $isImage = true;
        } else {
            $isImage = false;
        }
        if ($this->_debug) {
            $msg = 'File, ' . $this->_currentFile['name'] . ' is of mime type '
                . $this->_currentFile['type'];
            if (!$isImage) {
                $msg .= ' and is NOT an image file.';
            } else {
                $msg .= ' and IS an image file.';
            }
            $this->_addDebugMsg($msg);
        }

        return $isImage;
    }

    /**
     * Verifies the file size meets specified size limitations
     *
     * @return boolean   returns true of file size is within our limits otherwise false
     */
    private function _fileSizeOk()
    {
        if ($this->_debug) {
            $this->_addDebugMsg('File size for ' . $this->_currentFile['name'] . ' is ' . $this->_currentFile['size'] . ' bytes');
        }

        return ($this->_currentFile['size'] <= $this->_maxFileSize);
    }

    /**
     * Checks to see if file is an image and, if so, whether or not
     * it meets width and height limitations
     *
     * @param  bool $doResizeCheck
     * @return bool returns true if image height/width meet our limitations otherwise false
     */
    private function _imageSizeOK($doResizeCheck = true)
    {
        if (!$this->_isImage()) {
            return true;
        }

        $imageInfo = $this->_getImageDimensions();
        $sizeOK = true;

        if ($this->_debug) {
            $this->_addDebugMsg('Max allowed width = ' . $this->_maxImageWidth . ', Image width = ' . $imageInfo['width']);
            $this->_addDebugMsg('Max allowed height = ' . $this->_maxImageHeight . ', Image height = ' . $imageInfo['height']);
        }

        // If user set _autoResize then ignore these settings and try to resize on upload
        if (($doResizeCheck && !($this->_autoResize)) || (!($doResizeCheck))) {
            if ($imageInfo['width'] > $this->_maxImageWidth) {
                $sizeOK = false;
                if ($doResizeCheck) {
                    $this->_addError('Image, ' . $this->_currentFile['name'] . ' does not meet width limitations (is: ' . $imageInfo['width'] . ', max: ' . $this->_maxImageWidth . ')');
                }
            }

            if ($imageInfo['height'] > $this->_maxImageHeight) {
                $sizeOK = false;
                if ($doResizeCheck) {
                    $this->_addError('Image, ' . $this->_currentFile['name'] . ' does not meet height limitations (is: ' . $imageInfo['height'] . ', max: ' . $this->_maxImageHeight . ')');
                }
            }
        }

        if ($this->_debug) {
            $this->_addDebugMsg('File, ' . $this->_currentFile['name'] . ' has a width of '
                . $imageInfo['width'] . ' and a height of ' . $imageInfo['height']);
        }

        return $sizeOK;
    }

    /**
     * Gets the width and height of an image
     *
     * @return array     Array with width and height of current image
     */
    private function _getImageDimensions()
    {
        $dimensions = getimagesize($this->_currentFile['tmp_name']);
        if ($this->_debug) {
            $this->_addDebugMsg('in _getImageDimensions I got a width of ' . $dimensions[0] . ', and a height of ' . $dimensions[1]);
        }

        return array('width' => $dimensions[0], 'height' => $dimensions[1]);
    }

    /**
     * Calculate the factor to scale images with if they're not meeting
     * the size restrictions.
     *
     * @param    int $width  width of the unscaled image
     * @param    int $height height of the unscaled image
     * @return   double              resize factor
     */
    private function _calcSizeFactor($width, $height) // 1000
    {
        if (($width > $this->_maxImageWidth) ||
            ($height > $this->_maxImageHeight)
        ) {
            // get both size factors that would resize one dimension correctly
            $sizeFactorWidth = (double) ($this->_maxImageWidth / $width);
            $sizeFactorHeight = (double) ($this->_maxImageHeight / $height);

            // check if the height is ok after resizing the width
            if (($height * $sizeFactorWidth) > ($this->_maxImageHeight)) {
                // if no, get new size factor from height instead
                $sizeFactor = $sizeFactorHeight;
            } else {
                // otherwise the width factor it ok to fit max dimensions
                $sizeFactor = $sizeFactorWidth;
            }
        } else {
            $sizeFactor = 1.0;
        }

        return $sizeFactor;
    }

    /**
     * Keep the original (unscaled) image file, if configured.
     *
     * @param    string $filename name of uploaded file
     * @return   boolean             true: okay, false: an error occurred
     */
    private function _keepOriginalFile($filename)
    {
        if ($this->_keepOriginalImage) {
            $lFilename_large = substr_replace($this->_getDestinationName(),
                '_original.', strrpos($this->_getDestinationName(), '.'), 1);
            $lFilename_large_complete = $this->_fileUploadDirectory . '/'
                . $lFilename_large;
            if (!copy($filename, $lFilename_large_complete)) {
                $this->_addError("Couldn't copy $filename to $lFilename_large_complete.  You'll need to remove both files.");
                $this->printErrors();

                return false;
            } else {
                $this->createThumbnail($lFilename_large);
            }
        }

        return true;
    }

    /**
     * Gets destination file name for current file
     *
     * @return string    returns destination file name
     */
    private function _getDestinationName()
    {
        if (is_array($this->_fileNames)) {
            $name = $this->_fileNames[$this->_imageIndex];
        }

        if (empty($name)) {
            $name = $this->_currentFile['name'];
        }

        return $name;
    }

    /**
     * Gets permissions for a file.  This is used to do a chmod
     *
     * @return   string  returns final permissions for current file
     */
    private function _getPermissions()
    {
        if (is_array($this->_permissions)) {
            if (count($this->_permissions) > 1) {
                $perms = $this->_permissions[$this->_imageIndex];
            } else {
                $perms = $this->_permissions[0];
            }
        }

        if (empty($perms)) {
            $perms = '';
        }

        return $perms;
    }

    /**
     * This function actually completes the upload of a file
     *
     * @return   boolean     true if copy succeeds otherwise false
     */
    private function _copyFile()
    {
        if (!is_writable($this->_fileUploadDirectory)) {
            // Developer didn't check return value of setPath() method which would
            // have told them the upload directory was not writable.  Error out now
            $this->_addError('Specified upload directory, ' . $this->_fileUploadDirectory . ' exists but is not writable');

            return false;
        }

        $sizeOK = true;

        if (!($this->_imageSizeOK(false)) && $this->_autoResize) {
            $imageInfo = $this->_getImageDimensions();
            if ($imageInfo['width'] > $this->_maxImageWidth) {
                $sizeOK = false;
            }

            if ($imageInfo['height'] > $this->_maxImageHeight) {
                $sizeOK = false;
            }
        }

        if (isset($this->_currentFile['non_upload']) && $this->_currentFile['non_upload'] == true) {
            // Not from the upload file dialogue so just move
            $returnMove = rename($this->_currentFile['tmp_name'], $this->_fileUploadDirectory . '/' . $this->_getDestinationName());
        } else {
            if (isset($this->_currentFile['_gl_data_dir']) &&
                $this->_currentFile['_gl_data_dir']
            ) {
                // uploaded file was involved in a recreated POST after an expired
                // token - can't use move_uploaded_file() here
                $returnMove = rename($this->_currentFile['tmp_name'], $this->_fileUploadDirectory . '/' . $this->_getDestinationName());
            } else {
                $returnMove = move_uploaded_file($this->_currentFile['tmp_name'], $this->_fileUploadDirectory . '/' . $this->_getDestinationName());
            }
        }

        if (!$sizeOK) {
            // OK, resize
            $retval = 0;

            $sizeFactor = $this->_calcSizeFactor($imageInfo['width'], $imageInfo['height']);
            $newWidth = (int) ($imageInfo['width'] * $sizeFactor);
            $newHeight = (int) ($imageInfo['height'] * $sizeFactor);
            $this->_addDebugMsg('Going to resize image to ' . $newWidth . 'x'
                . $newHeight . ' using ' . $this->_imageLib);

            $filename = $this->_fileUploadDirectory . '/' . $this->_getDestinationName();
            if (!$this->_keepOriginalFile($filename)) {
                exit;
            }

            if ($this->_imageLib == 'imagemagick') {
                $newSize = $newWidth . 'x' . $newHeight;
                $quality = '';
                if ($this->_jpegQuality > 0) {
                    $quality = sprintf(' -quality %d', $this->_jpegQuality);
                }
                $cmd = $this->_pathToMogrify . $quality . ' -resize ' . $newSize . ' "' . $filename . '" 2>&1';
                $this->_addDebugMsg('Attempting to resize with this command (imagemagick): ' . $cmd);
                exec($cmd, $mogrify_output, $retval);
            } elseif ($this->_imageLib === 'netpbm') {
                $cmd = $this->_pathToNetPBM;
                $cmd_end = " '" . $filename . "' | " . $this->_pathToNetPBM . 'pnmscale -xsize=' . $newWidth . ' -ysize=' . $newHeight . ' | ' . $this->_pathToNetPBM;
                // convert to pnm, resize, convert back
                if (($this->_currentFile['type'] == 'image/png') ||
                    ($this->_currentFile['type'] == 'image/x-png')
                ) {
                    $tempFile = $this->_fileUploadDirectory . '/tmp.png';
                    $cmd .= 'pngtopnm ' . $cmd_end . 'pnmtopng > ' . $tempFile;
                } elseif (($this->_currentFile['type'] == 'image/jpeg') ||
                    ($this->_currentFile['type'] == 'image/pjpeg')
                ) {
                    $tempFile = $this->_fileUploadDirectory . '/tmp.jpg';
                    $quality = '';
                    if ($this->_jpegQuality > 0) {
                        $quality = sprintf(' -quality=%d', $this->_jpegQuality);
                    }
                    $cmd .= 'jpegtopnm ' . $cmd_end . 'pnmtojpeg' . $quality . ' > ' . $tempFile;
                } elseif ($this->_currentFile['type'] == 'image/gif') {
                    $tempFile = $this->_fileUploadDirectory . '/tmp.gif';
                    $cmd .= 'giftopnm ' . $cmd_end . 'ppmquant 256 | '
                        . $this->_pathToNetPBM . 'ppmtogif > ' . $tempFile;
                } else {
                    $this->_addError("Image format of file $filename is not supported.");
                    $this->printErrors();
                    exit;
                }
                $this->_addDebugMsg('Attempting to resize with this command (netpbm): ' . $cmd);
                exec($cmd, $netpbm_output, $retval);
                // Move tmp file to actual file
                if (!copy($tempFile, $filename)) {
                    $this->_addError("Couldn't copy $tempFile to $filename.  You'll need remove both files");
                    $this->printErrors();
                    exit;
                } else {
                    // resize with netpbm worked, now remove tmpfile
                    if (!unlink($tempFile)) {
                        $this->_addError("Couldn't delete $tempFile.  You'll need to remove it manually");
                        $this->printErrors();
                        exit;
                    }
                }
            } elseif ($this->_imageLib === 'gdlib') {
                if (!function_exists('gd_info')) {
                    $this->_addError('GD library does not seem to be enabled.');
                    $this->printErrors();
                    exit;
                }

                $image_source = $this->_createImageFromFile_gdlib($filename);

                // do resize

                // ImageCreateTrueColor may throw a fatal error on some PHP
                // versions when GD2 is not installed. Ugly workaround, but
                // there seems to be no better way. Also see the discussion at
                // http://php.net/ImageCreateTrueColor
                $image_dest = @imagecreatetruecolor($newWidth, $newHeight);
                if (!$image_dest) {
                    $thumb = imagecreate($newWidth, $newHeight);
                    if ($this->_jpegQuality > 0) {
                        imagejpeg($thumb, $filename, $this->_jpegQuality);
                    } else {
                        imagejpeg($thumb, $filename);
                    }
                    imagedestroy($thumb);
                    $image_dest = @imagecreatefromjpeg($filename);
                    unlink($filename);
                }

                // Prevent transparent area of a JPEG image from being painted black
                if (is_callable('imagealphablending') && is_callable('imagesavealpha')) {
                    imagealphablending($image_dest, false);
                    imagesavealpha($image_dest, true);
                }
                imagecopyresampled($image_dest, $image_source,
                   0, 0, 0, 0, $newWidth, $newHeight,
                   $imageInfo['width'], $imageInfo['height']);
                $this->_outputImageToFile_gdlib($image_dest, $filename);

                $temp = getimagesize($filename);
                if ($temp !== false) {
                    $newSize = $temp[0] . 'x' . $temp[1];
                } else {
                    $newSize = '?';
                }
            }

            if ($retval > 0) {
                if ($this->_imageLib === 'imagemagick') {
                    $this->_addError('Image, ' . $this->_currentFile['name']
                        . ' had trouble being resized: ' . $mogrify_output[0]);
                } elseif ($this->_imageLib === 'netpbm') {
                    $this->_addError('Image, ' . $this->_currentFile['name']
                        . ' had trouble being resized: ' . $netpbm_output[0]);
                }
                $this->printErrors();
                exit;
            } else {
                $this->_addDebugMsg('Image, ' . $this->_currentFile['name'] . ' was resized from ' . $imageInfo['width'] . 'x' . $imageInfo['height'] . ' to ' . $newSize);
            }
        }

        $returnChmod = true;
        $perms = $this->_getPermissions();

        if (!empty($perms)) {
            $returnChmod = chmod($this->_fileUploadDirectory . '/' . $this->_getDestinationName(), octdec($perms));
        }

        if ($returnMove && $returnChmod) {
            return true;
        } else {
            if (!$returnMove) {
                $this->_addError('Upload of ' . $this->_currentFile['name'] . ' failed.');
            }

            if (!$returnChmod) {
                $this->_addError('Chmod of ' . $this->_currentFile['name'] . ' to ' . $perms . ' failed');
            }

            return false;
        }
    }

    /**
     * Sets the path to where the mogrify ImageMagick function is
     *
     * @param     string $path_to_mogrify Absolute path to mogrify
     * @return    boolean   True if set, false otherwise
     */
    public function setMogrifyPath($path_to_mogrify)
    {
        $this->_imageLib = 'imagemagick';
        $this->_pathToMogrify = $path_to_mogrify;

        return true;
    }

    /**
     * Sets the path to where the netpbm utilities are
     *
     * @param     string $path_to_netpbm Absolute path to netpbm dir
     * @return    boolean   True if set, false otherwise
     */
    public function setNetPBM($path_to_netpbm)
    {
        $this->_imageLib = 'netpbm';
        $this->_pathToNetPBM = $path_to_netpbm;

        return true;
    }

    /**
     * Configure upload to use GD library
     *
     * @return    boolean   True if set, false otherwise
     */
    public function setGDLib()
    {
        $this->_imageLib = 'gdlib';

        return true;
    }

    /**
     * Sets mode to automatically resize images that are either too wide or
     * too tall
     *
     * @param    boolean $switch True to turn on, false to turn off
     */
    public function setAutomaticResize($switch)
    {
        $this->_autoResize = $switch;
    }

    /**
     * Allows you to override default max file size
     *
     * @param    int $size_in_bytes Max. size for uploaded files
     * @return   boolean true if we set it OK, otherwise false
     */
    public function setMaxFileSize($size_in_bytes)
    {
        if (!is_numeric($size_in_bytes)) {
            return false;
        }
        $this->_maxFileSize = $size_in_bytes;

        return true;
    }

    /**
     * Allows you to override default max. image dimensions
     *
     * @param    int $width_pixels  Max. width allowed
     * @param    int $height_pixels Max. height allowed
     * @return   boolean true if we set values OK, otherwise false
     */
    public function setMaxDimensions($width_pixels, $height_pixels)
    {
        if (!is_numeric($width_pixels) || !is_numeric($height_pixels)) {
            return false;
        }

        $this->_maxImageWidth = $width_pixels;
        $this->_maxImageHeight = $height_pixels;

        return true;
    }

    /**
     * Sets the max number of files that can be uploaded per form
     *
     * @param     int $maxFiles Maximum number of files to allow. Default is 5
     * @return    boolean   True if set, false otherwise
     */
    public function setMaxFileUploads($maxFiles)
    {
        $this->_maxFileUploadsPerForm = $maxFiles;

        return true;
    }

    /**
     * Allows you to keep the original (unscaled) image.
     *
     * @param    boolean $keepIt true = keep original, false = don't
     * @return   boolean   true if we set values OK, otherwise false
     */
    public function keepOriginalImage($keepIt)
    {
        $this->_keepOriginalImage = $keepIt;

        return true;
    }

    /**
     * Set JPEG quality
     * NOTE:     The 'quality' is an arbitrary value used by the IJG library.
     *           It is not a percent value! The default (and a good value) is 75.
     *
     * @param    int $quality JPEG quality (0-100)
     * @return   boolean   true if we set values OK, otherwise false
     */
    public function setJpegQuality($quality)
    {
        if (($quality < 0) || ($quality > 100)) {
            return false;
        }

        $this->_jpegQuality = $quality;

        return true;
    }

    /**
     * Extra security option that forces all attempts to upload a file to be done
     * so from a set of VERY specific IP's.  This is only good for those who are
     * paranoid
     *
     * @param    array $validIPS Array of valid IP addresses to allow file uploads from
     * @return   boolean returns true if we successfully limited the IP's, otherwise false
     */
    public function limitByIP($validIPS = array('127.0.0.1'))
    {
        if (is_array($validIPS)) {
            $this->_limitByIP = true;
            $this->_allowedIPS = $validIPS;

            return true;
        } else {
            $this->_addError('Bad call to method limitByIP(), must pass array of valid IP addresses');

            return false;
        }
    }

    /**
     * Allows you to specify whether or not to continue processing other files
     * when an error occurs or exit immediately. Default is to exit immediately
     * NOTE: this only affects the actual file upload process.
     *
     * @param    boolean $switch true or false
     */
    public function setContinueOnError($switch)
    {
        $this->_continueOnError = (bool) $switch;
    }

    /**
     * Sets log file
     *
     * @param    string $logFile fully qualified path to log files
     * @return   boolean returns true if we set the log file, otherwise false
     */
    public function setLogFile($logFile = '')
    {
        if (empty($logFile) || !file_exists($logFile)) {
            // Log file doesn't exist, produce warning
            $this->_addWarning('Log file, ' . $logFile . ' does not exists, setLogFile() method failed');
            $this->_doLogging = false;

            return false;
        }
        $this->_logFile = $logFile;

        return true;
    }

    /**
     * Enables/disables logging of errors and warnings
     *
     * @param    boolean $switch flag, true or false
     */
    public function setLogging($switch)
    {
        if ($switch && !empty($this->_logFile)) {
            $this->_doLogging = true;
        } else {
            if ($switch && empty($this->_logFile)) {
                $this->_addWarning('Unable to enable logging because no log file was set.  Use setLogFile() method');
            }
            $this->_doLogging = false;
        }
    }

    /**
     * Returns whether or not logging is enabled
     *
     * @return   boolean returns true if logging is enabled otherwise false
     */
    public function loggingEnabled()
    {
        return $this->_doLogging;
    }

    /**
     * Will force the debug messages in this class to be
     * printed
     *
     * @param    boolean $switch flag, true or false
     */
    public function setDebug($switch)
    {
        if ($switch) {
            $this->_debug = true;
            // setting debugs implies logging is on too
            $this->setLogging(true);
        } else {
            $this->_debug = false;
        }
    }

    /**
     * If enabled will ignore the MIME checks on file uploads
     *
     * @param    boolean $switch flag, true or false
     */
    public function setIgnoreMimeCheck($switch)
    {
        $this->_ignoreMimeTest = (bool) $switch;
    }

    /**
     * This function will print any errors out.  This is useful in debugging
     *
     * @param    boolean $verbose whether or not to print immediately or return only a string
     * @return   string  if $verbose is false it returns all errors otherwise just an empty string
     */
    public function printErrors($verbose = true)
    {
        if (isset($this->_errors) && is_array($this->_errors)) {
            $retval = '';
            reset($this->_errors);
            $numErrors = count($this->_errors);

            for ($i = 1; $i <= $numErrors; $i++) {
                if ($verbose) {
                    echo current($this->_errors) . '<br' . XHTML . '>' . PHP_EOL;
                } else {
                    $retval .= current($this->_errors) . '<br' . XHTML . '>' . PHP_EOL;
                }
                next($this->_errors);
            }

            return $retval;
        } else {
            return '';
        }
    }

    /**
     * This function will print any warnings out.  This is useful in debugging
     */
    public function printWarnings()
    {
        if (isset($this->_warnings) && is_array($this->_warnings)) {
            reset($this->_warnings);
            $numWarnings = count($this->_warnings);
            for ($i = 1; $i <= $numWarnings; $i++) {
                echo current($this->_warnings) . '<br' . XHTML . '>' . PHP_EOL;
                next($this->_warnings);
            }
        }
    }

    /**
     * This function will print any debug messages out.
     */
    public function printDebugMsgs()
    {
        if (isset($this->_debugMessages) && is_array($this->_debugMessages)) {
            reset($this->_debugMessages);
            $numMessages = count($this->_debugMessages);
            for ($i = 1; $i <= $numMessages; $i++) {
                echo current($this->_debugMessages) . '<br' . XHTML . '>' . PHP_EOL;
                next($this->_debugMessages);
            }
        }
    }

    /**
     * Returns if any errors have been encountered thus far
     *
     * @return   boolean returns true if there were errors otherwise false
     */
    public function areErrors()
    {
        return (count($this->_errors) > 0);
    }

    /**
     * Sets allowed mime types for this instance
     *
     * @param    array $mimeTypes Array of allowed mime types
     */
    public function setAllowedMimeTypes($mimeTypes = array())
    {
        $this->_allowedMimeTypes = $mimeTypes;
    }

    /**
     * Gets allowed mime types for this instance
     *
     * @return   array   Returns array of allowed mime types
     */
    public function getAllowedMimeTypes()
    {
        return $this->_allowedMimeTypes;
    }

    /**
     * Checks to see that mime type for current file is allowed for upload
     *
     * @return   boolean     true if current file's mime type is allowed otherwise false
     */
    public function checkMimeType()
    {
        if ($this->_ignoreMimeTest) {
            return true;
        }

        $sc = strpos($this->_currentFile['type'], ';');
        if ($sc > 0) {
            $this->_currentFile['type'] = substr($this->_currentFile['type'], 0, $sc);
        }
        $mimeTypes = $this->getAllowedMimeTypes();

        foreach ($mimeTypes as $mimeT => $extList) {
            if ($mimeT == $this->_currentFile['type']) {
                // Each defined Mime Type can have multiple possible extesions - need to test each
                if (is_array($extList)) {   // Used if allowedMimeTypes is being defined using the Online Config Manager
                    $extensions = array_keys($extList);
                } else {
                    $extensions = explode(',', $extList);
                }
                $fileName = $this->_currentFile['name'];

                foreach ($extensions as $ext) {
                    $ext = trim($ext);
                    if (strcasecmp(substr($fileName, -strlen($ext)), $ext) == 0) {
                        return true;
                    }
                }
            }
        }

        $this->_addError('Mime type, ' . $this->_currentFile['type']
            . ', or extension of ' . $this->_currentFile['name']
            . ' not in list of allowed types.');

        return false;
    }

    /**
     * Sets file upload path
     *
     * @param    string $uploadDir Directory on server to store uploaded files
     * @return   boolean returns true if we successfully set path otherwise false
     */
    public function setPath($uploadDir)
    {
        if (!is_dir($uploadDir)) {
            $this->_addError('Specified upload directory, ' . $uploadDir . ' is not a valid directory');

            return false;
        }

        if (!is_writable($uploadDir)) {
            $this->_addError('Specified upload directory, ' . $uploadDir . ' exists but is not writable');

            return false;
        }

        $this->_fileUploadDirectory = $uploadDir;

        return true;
    }

    /**
     * Returns directory to upload to
     *
     * @return   string  returns path to file upload directory
     */
    public function getPath()
    {
        return $this->_fileUploadDirectory;
    }

    /**
     * Sets directory to store thumbnails
     *
     * @param    string $thumbsDir Directory on server to store thumbnails
     * @return   boolean returns true if we successfully set path otherwise false
     */
    public function setThumbsPath($thumbsDir)
    {
        if (!is_dir($thumbsDir)) {
            $this->_addError('Specified upload directory, ' . $thumbsDir . ' is not a valid directory');

            return false;
        }

        if (!is_writable($thumbsDir)) {
            $this->_addError('Specified upload directory, ' . $thumbsDir . ' exists but is not writable');

            return false;
        }

        $this->_thumbsDirectory = $thumbsDir;

        return true;
    }

    /**
     * Returns directory to store thumbnails
     *
     * @return   string  returns path to directory to store thumbnails
     */
    public function getThumbsPath()
    {
        return $this->_thumbsDirectory;
    }

    /**
     * Sets file name(s) for files
     * This function will set the name of any files uploaded.  If the
     * number of file names sent doesn't match the number of uploaded
     * files a warning will be generated but processing will continue
     *
     * @param    string|array $fileNames A string or string array of file names
     */
    public function setFileNames($fileNames = 'geeklog_uploadedfile')
    {
        if (isset($fileNames) && is_array($fileNames)) {
            // this is an array of file names, set them
            $this->_fileNames = $fileNames;
        } else {
            $this->_fileNames = array($fileNames);
        }
    }

    /**
     * Changes permissions for uploaded files.  If only one set of perms is
     * sent then they are applied to all uploaded files.  If more then one set
     * of perms is sent (i.e. $perms is an array) then permissions are applied
     * one by one.  Any files not having an associated permissions will be
     * left alone.  NOTE: this is meant to be called BEFORE you do the upload
     * and ideally is called right after setFileNames()
     *
     * @param    string|array $perms A string or string array of file permissions
     */
    public function setPerms($perms)
    {
        if (isset($perms) && is_array($perms)) {
            // this is an array of file names, set them
            $this->_permissions = $perms;
        } else {
            $this->_permissions = array($perms);
        }
    }

    /**
     * Returns how many actual files were sent for upload.  NOTE: this will
     * ignore HTML file fields that were left blank.
     *
     * @return   int returns number of files were sent to be uploaded
     */
    public function numFiles()
    {
        if (empty($this->_filesToUpload)) {
            $this->_filesToUpload = $_FILES;
        }

        $fileCount = 0;

        for ($i = 1; $i <= count($_FILES); $i++) {
            $curFile = current($this->_filesToUpload);

            // Make sure file field on HTML form wasn't empty
            if (!empty($curFile['name'])) {
                $fileCount++;
            }
            next($this->_filesToUpload);
        }
        reset($_FILES);

        return $fileCount;
    }

    /**
     * Uploads any posted files.
     *
     * @return   boolean returns true if no errors were encountered otherwise false
     */
    public function uploadFiles()
    {
        // Before we do anything, let's see if we are limiting file uploads by
        // IP address and, if so, verify the poster is originating from one of
        // those places
        if ($this->_limitByIP) {
            if (!in_array(\Geeklog\IP::getIPAddress(), $this->_allowedIPS)) {
                $this->_addError('The IP, ' . \Geeklog\IP::getIPAddress() . ' is not in the list of '
                    . 'accepted IP addresses.  Refusing to allow file upload(s)');

                return false;
            }
        }

        $this->_filesToUpload = $_FILES;
        $numFiles = count($this->_filesToUpload);

        // For security sake, check to make sure a DOS isn't happening by making
        // sure there is a limit of the number of files being uploaded
        if ($numFiles > $this->_maxFileUploadsPerForm) {
            $this->_addError('Max. number of files you can upload from a form is '
                . $this->_maxFileUploadsPerForm . ' and you sent ' . $numFiles);

            return false;
        }

        // Verify upload directory is valid
        if (!$this->_fileUploadDirectory) {
            $this->_addError('No Upload Directory Specified, use setPath() method');
        }

        // Verify allowed mime types exist
        if (!$this->_ignoreMimeTest && !$this->_allowedMimeTypes) {
            $this->_addError('No allowed mime types specified, use setAllowedMimeTypes() method');
        }

        for ($i = 1; $i <= $numFiles; $i++) {
            $this->_currentFile = current($_FILES);

            // Make sure file field on HTML form wasn't empty before proceeding
            if (!empty($this->_currentFile['name'])) {
                // Verify file meets size limitations
                if (!$this->_fileSizeOk()) {
                    $this->_addError('File, ' . $this->_currentFile['name'] . ', is bigger than the ' . $this->_maxFileSize . ' byte limit');
                }

                // If all systems check, do the upload
                if ($this->checkMimeType() && $this->_imageSizeOK() && !$this->areErrors()) {
                    if ($this->_copyFile()) {
                        $this->_uploadedFiles[] = $this->_fileUploadDirectory . '/' . $this->_getDestinationName();
                        $this->createThumbnail($this->_getDestinationName());
                    }
                }

                $this->_currentFile = array();

                if ($this->areErrors() && !$this->_continueOnError) {
                    return false;
                }

                $this->_imageIndex++;
            } else {
                // No file name specified...send as warning.
                $this->_addWarning('File #' . $i . ' on the HTML form was empty...ignoring it and continuing');
            }
            next($_FILES);
        }

        // This function returns false if any errors were encountered
        return !$this->areErrors();
    }

    /**
     * Create a new image from file with GD Library
     *
     * @param    string $src_path path to the source image
     * @return   resource returns an image
     */
    private function _createImageFromFile_gdlib($src_path)
    {
        $src_image = false;
        switch ($this->_currentFile['type']) {
            case 'image/png':
            case 'image/x-png':
                $imageType = 'png';
                break;
            case 'image/jpeg':
            case 'image/pjpeg':
                $imageType = 'jpeg';
                break;
            case 'image/gif':
                $imageType = 'gif';
                break;
            default:
                $this->_addError('MIME type ' . $this->_currentFile['type'] . ' not supported.');
                $this->printErrors();
                exit;
                break;
        }
        $function = 'imagecreatefrom' . $imageType;
        $imageType = strtoupper($imageType);
        if (!function_exists($function)) {
            $this->_addError('Sorry, this version of the GD library does not support '
                . $imageType . ' images.');
            $this->printErrors();
            exit;
        }
        if (!$src_image = $function($src_path)) {
            $this->_addError('Could not create image from '
                . $imageType . ': ' . $src_path);
            $this->printErrors();
            exit;
        }

        return $src_image;
    }

    /**
     * Output image to file with GD Library
     *
     * @param    resource $dst_image image resource returned by one of the image creation functions
     * @param    string $dst_path path to save the file to
     * @return   void
     */
    private function _outputImageToFile_gdlib($dst_image, $dst_path)
    {
        switch ($this->_currentFile['type']) {
            case 'image/png':
            case 'image/x-png':
                $imageType = 'png';
                break;
            case 'image/jpeg':
            case 'image/pjpeg':
                $imageType = 'jpeg';
                break;
            case 'image/gif':
                $imageType = 'gif';
                break;
        }
        $function = 'image' . $imageType;
        if (!$function($dst_image, $dst_path)) {
            $this->_addError('Could not create '
                . strtoupper($imageType) . ': ' . $dst_path);
            $this->printErrors();
            exit;
        }
    }

    /**
     * Create thumbnail with GD Library
     *
     * @param    string $src_fname source file name to create thumbnail
     * @return   boolean returns true if no errors were encountered otherwise false
     */
    private function _createThumbnail_gdlib($src_fname)
    {
        // Thumbnail size
        $dst_w = 64;
        $dst_h = 64;

        $src_path = $this->_fileUploadDirectory . '/' . $src_fname;
        $dst_fname = substr_replace($src_fname, '_64x64px.', strrpos($src_fname, '.'), 1);
        $dst_path = $this->_thumbsDirectory . '/' . $dst_fname;

        // Get size of source image
        list($width, $height) = getimagesize($src_path);

        // Compare width and height and match it either
        // and set start position and size for copying part
        $src_x = 0;
        $src_y = 0;
        $src_w = $width;
        $src_h = $height;
        if ($width > $height) {
            $src_x = (int)(($width - $height) * 0.5);
            $src_w = $height;
        } elseif ($width < $height) {
            $src_y = (int)(($height - $width) * 0.5);
            $src_h = $width;
        }

        // Create a new image to be a thumbnail
        $dst_image = imagecreatetruecolor($dst_w, $dst_h);

        // Create a new image from source file
        $src_image = $this->_createImageFromFile_gdlib($src_path);

        // Copy and resize part of source image
        imagecopyresampled($dst_image,     $src_image,
                           0,      0,      $src_x, $src_y,
                           $dst_w, $dst_h, $src_w, $src_h);

        // Output image to file
        $this->_outputImageToFile_gdlib($dst_image, $dst_path);

        return true;
    }

    /**
     * Create thumbnail with ImageMagick
     *
     * @param    string $src_fname source file name to create thumbnail
     * @return   boolean returns true if no errors were encountered otherwise false
     */
    private function _createThumbnail_imagick($src_fname)
    {
        // Thumbnail size
        $dst_w = 64;
        $dst_h = 64;
        $newSize = $dst_w . 'x' . $dst_h;

        $src_path = $this->_fileUploadDirectory . '/' . $src_fname;
        $dst_fname = substr_replace($src_fname, '_64x64px.', strrpos($src_fname, '.'), 1);
        $dst_path = $this->_thumbsDirectory . '/' . $dst_fname;

        // convert src.jpg -resize 64x64^ -gravity center -extent 64x64 dist.jpg
        $cmd = str_replace('mogrify', 'convert', $this->_pathToMogrify);
        $cmd = $cmd . ' "' . $src_path . '" -resize ' . $newSize . '^ -gravity center -extent ' . $newSize . ' "' . $dst_path . '"';

        $this->_addDebugMsg('Attempting to resize with this command (imagemagick): ' . $cmd);
        exec($cmd, $mogrify_output, $retval);

        return true;
    }

    /**
     * Create thumbnail with Netpbm
     *
     * @param    string $src_fname source file name to create thumbnail
     * @return   boolean returns true if no errors were encountered otherwise false
     */
    private function _createThumbnail_netpbm($src_fname)
    {
        // Thumbnail size
        $dst_w = 64;
        $dst_h = 64;

        $src_path = $this->_fileUploadDirectory . '/' . $src_fname;
        $dst_fname = substr_replace($src_fname, '_64x64px.', strrpos($src_fname, '.'), 1);
        $dst_path = $this->_thumbsDirectory . '/' . $dst_fname;

        // Get size of source image
        list($width, $height) = getimagesize($src_path);

        // Compare width and height and match it either
        // and set start position and size for copying part
        $src_x = 0;
        $src_y = 0;
        $src_w = $width;
        $src_h = $height;
        if ($width > $height) {
            $src_x = (int)(($width - $height) * 0.5);
            $src_w = $height;
        } elseif ($width < $height) {
            $src_y = (int)(($height - $width) * 0.5);
            $src_h = $width;
        }

        //jpegtopnm orig.jpg | pnmcut 420 0 1080 1080 | pnmscale 0.059259259 | pnmtojpeg > dist.jpg
        $path = $this->_pathToNetPBM;
        $cut = $path . sprintf('pnmcut %d %d %d %d', $src_x, $src_y, $src_w, $src_h);
        $scale = $path . 'pnmscale ' . (float)($dst_w / $src_w);

        if ($this->_currentFile['type'] == 'image/png' ||
            $this->_currentFile['type'] == 'image/x-png') {

            $cmd .= $path . 'pngtopnm "' . $src_path . '" | ' . $cut . ' | ' . $scale
                . ' | ' . $path . 'pnmtopng > "' . $dst_path . '"';

        } elseif ($this->_currentFile['type'] == 'image/jpeg' ||
            $this->_currentFile['type'] == 'image/pjpeg') {

            $quality = '';
            if ($this->_jpegQuality > 0) {
                $quality = sprintf(' -quality=%d', $this->_jpegQuality);
            }
            $cmd .= $path . 'jpegtopnm "' . $src_path . '" | ' . $cut . ' | ' . $scale
                . ' | ' . $path . 'pnmtojpeg' . $quality . ' > "' . $dst_path . '"';

        } elseif ($this->_currentFile['type'] == 'image/gif') {

            $cmd .= $path . 'giftopnm "' . $src_path . '" | ' . $cut . ' | ' . $scale . ' | '
                . $path . 'ppmquant 256 | ' . $path . 'ppmtogif > "' . $dst_path . '"';

        } else {

            $this->_addError("Image format of file $filename is not supported.");
            $this->printErrors();
            exit;

        }
        $this->_addDebugMsg('Attempting to resize with this command (netpbm): ' . $cmd);
        exec($cmd, $netpbm_output, $retval);

        return true;
    }

    /**
     * Create thumbnail
     *
     * @param    string $src_fname source file name to create thumbnail
     * @return   boolean returns true if no errors were encountered otherwise false
     */
    public function createThumbnail($src_fname)
    {
        if (empty($this->_fileUploadDirectory) || empty($this->_thumbsDirectory)) {
            return false;
        }

        if (empty($this->_currentFile['type'])) {
            if (extension_loaded('fileinfo')) {
                $src_path = $this->_fileUploadDirectory . '/' . $src_fname;
                // Get mime type
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $this->_currentFile['type'] = $finfo->file($src_path);
            } else {
                return false;
            }
        }

        if ($this->_imageLib === 'imagemagick') {
            return $this->_createThumbnail_imagick($src_fname);
        } elseif ($this->_imageLib === 'netpbm') {
            return $this->_createThumbnail_netpbm($src_fname);
        }
        return $this->_createThumbnail_gdlib($src_fname);
    }

    /**
     * @return string
     */
    public function getMogrifyPath()
    {
        return $this->_pathToMogrify;
    }

    /**
     * @return string
     */
    public function getNetPBMPath()
    {
        return $this->_pathToNetPBM;
    }

    /**
     * @return bool
     */
    public function isAutoResize()
    {
        return $this->_autoResize;
    }

    /**
     * @return int
     */
    public function getMaxFileSize()
    {
        return $this->_maxFileSize;
    }

    /**
     * @return int
     */
    public function getMaxImageWidth()
    {
        return $this->_maxImageWidth;
    }

    /**
     * @return int
     */
    public function getMaxImageHeight()
    {
        return $this->_maxImageHeight;
    }

    /**
     * @return int
     */
    public function getMaxFileUploadsPerForm()
    {
        return $this->_maxFileUploadsPerForm;
    }

    /**
     * @return boolean
     */
    public function isKeepOriginalImage()
    {
        return $this->_keepOriginalImage;
    }

    /**
     * @return int
     */
    public function getJpegQuality()
    {
        return $this->_jpegQuality;
    }

    /**
     * @return boolean
     */
    public function isContinueOnError()
    {
        return $this->_continueOnError;
    }

    /**
     * @return string
     */
    public function getLogFile()
    {
        return $this->_logFile;
    }

    /**
     * @return boolean
     */
    public function isDebug()
    {
        return $this->_debug;
    }

    /**
     * @return boolean
     */
    public function isIgnoreMimeTest()
    {
        return $this->_ignoreMimeTest;
    }

    /**
     * @return string
     */
    public function getPermissions()
    {
        return $this->_permissions;
    }

    /**
     * @return string
     */
    public function getFileNames()
    {
        return $this->_fileNames;
    }

    /**
     * @return string
     */
    public function getImageLib()
    {
        return $this->_imageLib;
    }
}
