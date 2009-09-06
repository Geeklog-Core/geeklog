<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
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
*
*/
class upload
{
    /**
    * @access private
    */
    var $_errors = array();               // Array
    /**
    * @access private
    */
    var $_warnings = array();             // Array
    /**
    * @access private
    */
    var $_debugMessages = array();        // Array
    /**
    * @access private
    */
    var $_allowedMimeTypes = array();     // Array
    /**
    * @access private
    */
    var $_availableMimeTypes = array();   // Array
    /**
    * @access private
    */
    var $_filesToUpload = array();        // Array
    /**
    * @access private
    */
    var $_currentFile = array();          // Array
    /**
    * @access private
    */
    var $_allowedIPS = array();           // Array
    /**
    * @access private
    */
    var $_uploadedFiles = array();        // Array
    /**
    * @access private
    */
    var $_maxImageWidth = 300;            // Pixels
    /**
    * @access private
    */
    var $_maxImageHeight = 300;           // Pixels
    /**
    * @access private
    */
    var $_maxFileSize = 1048576;          // Long, in bytes
    /**
    * @access private
    */
    var $_jpegQuality = 0;                // int (0-100)
    /**
    * @access private
    */
    var $_pathToMogrify = '';             // String
    /**
    * @access private
    */
    var $_pathToNetPBM= '';               // String
    /**
    * @access private
    */
    var $_imageLib = '';                 // Integer
    /**
    * @access private
    */
    var $_autoResize = false;             // boolean
    /**
    * @access private
    */
    var $_keepOriginalImage = false;      // boolean
    /**
    * @access private
    */
    var $_maxFileUploadsPerForm = 5;
    /**
    * @access private
    */
    var $_fileUploadDirectory = '';       // String
    /**
    * @access private
    */
    var $_fileNames = '';                 // String
    /**
    * @access private
    */
    var $_permissions = '';               // String
    /**
    * @access private
    */
    var $_logFile = '';                   // String
    /**
    * @access private
    */
    var $_doLogging = false;              // Boolean
    /**
    * @access private
    */
    var $_continueOnError = false;        // Boolean
    /**
    * @access private
    */
    var $_debug = false;                  // Boolean
    /**
    * @access private
    */
    var $_limitByIP = false;              // Boolean
    /**
    * @access private
    */
    var $_numSuccessfulUploads = 0;       // Integer
    /**
    * @access private
    */
    var $_imageIndex = 0;                 // Integer
    /**
    * @access private
    */
    var $_ignoreMimeTest = false;       // Boolean

    /**
    * @access private
    */
    var $_wasResized = false;             // Boolean


    /**
    * Constructor
    *
    */
    function upload()
    {
        $this->_setAvailableMimeTypes();
    }

    // PRIVATE METHODS

    /**
    * Adds a warning that was encountered
    *
    * @access   private
    * @param    string  $warningText     Text of warning
    *
    */
    function _addWarning($warningText)
    {
        $nwarnings = count($this->_warnings);
        $nwarnings = $nwarnings + 1;
        $this->_warnings[$nwarnings] = $warningText;
        if ($this->loggingEnabled()) {
            $this->_logItem('Warning',$warningText);
        }
    }

    /**
    * Adds an error that was encountered
    *
    * @access   private
    * @param    string      $errorText      Text of error
    *
    */
    function _addError($errorText)
    {
        $nerrors = count($this->_errors);
        $nerrors = $nerrors + 1;
        $this->_errors[$nerrors] = $errorText;
        if ($this->loggingEnabled()) {
            $this->_logItem('Error',$errorText);
        }
    }

    /**
    * Adds a debug message
    *
    * @access   private
    * @param        string      $debugText      Text of debug message
    *
    */
    function _addDebugMsg($debugText)
    {
        $nmsgs = count($this->_debugMessages);
        $nmsgs = $nmsgs + 1;
        $this->_debugMessages[$nmsgs] = $debugText;
        if ($this->loggingEnabled()) {
            $this->_logItem('Debug',$debugText);
        }
    }

    /**
    * Logs an item to the log file
    *
    * @access   private
    * @param    string      $logtype    can be 'warning' or 'error'
    * @param    string      $text       Text to log to log file
    * @return   boolean     Whether or not we successfully logged an item
    *
    */
    function _logItem($logtype, $text)
    {
        $timestamp = strftime("%c");
        if (!$file = fopen($this->_logFile, 'a')) {
            // couldn't open log file for writing so let's disable logging and add an error
            $this->setLogging(false);
            $this->_addError('Error writing to log file: ' . $this->_logFile . '.  Logging has been disabled');
            return false;
        }
        fputs ($file, "$timestamp - $logtype: $text \n");
        fclose($file);
        return true;
    }

    /**
    * Defines superset of available Mime types.
    *
    * @access   private
    * @param    array   $mimeTypes  string array of valid mime types this object will accept
    *
    */
    function _setAvailableMimeTypes($mimeTypes = array())
    {
        if (count($mimeTypes) == 0) {
            $this->_availableMimeTypes =
            array(
                'application/x-gzip-compressed'     => '.tar.gz,.tgz',
                'application/x-zip-compressed'      => '.zip',
                'application/x-tar'                 => '.tar',
                'application/x-gtar'                => '.tar',
                'text/plain'                        => '.phps,.txt,.inc',
                'text/html'                         => '.html,.htm',
                'image/bmp'                         => '.bmp,.ico',
                'image/gif'                         => '.gif',
                'image/pjpeg'                       => '.jpg,.jpeg',
                'image/jpeg'                        => '.jpg,.jpeg',
                'image/png'                         => '.png',
                'image/x-png'                       => '.png',
                'audio/mpeg'                        => '.mp3',
                'audio/wav'                         => '.wav',
                'application/pdf'                   => '.pdf',
                'application/x-shockwave-flash'     => '.swf',
                'application/msword'                => '.doc',
                'application/vnd.ms-excel'          => '.xls',
                'application/octet-stream'          => '.fla,.psd'
            );
        } else {
            $this->_availableMimeTypes = $mimeTypes;
        }
    }

    /**
    * Checks if current file is an image
    *
    * @access private
    * @return boolean   returns true if file is an image, otherwise false
    */
    function _isImage()
    {
        if (strpos ($this->_currentFile['type'], 'image/') === 0) {
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
    * @access private
    * @return boolean   returns true of file size is within our limits otherwise false
    */
    function _fileSizeOk()
    {
        if ($this->_debug) {
            $this->_addDebugMsg('File size for ' . $this->_currentFile['name'] . ' is ' . $this->_currentFile['size'] . ' bytes');
        }

        if ($this->_currentFile['size'] > $this->_maxFileSize) {
            return false;
        } else {
            return true;
        }
    }

    /**
    * Checks to see if file is an image and, if so, whether or not
    * it meets width and height limitations
    *
    * @access   private
    * @return   boolean     returns true if image height/width meet our limitations otherwise false
    *
    */
    function _imageSizeOK($doResizeCheck=true)
    {
        if (!$this->_isImage()) {
            return true;
        }

        $imageInfo = $this->_getImageDimensions($this->_currentFile['tmp_name']);

        $sizeOK = true;

        if ($this->_debug) {
            $this->_addDebugMsg('Max allowed width = ' . $this->_maxImageWidth . ', Image width = ' . $imageInfo['width']);
            $this->_addDebugMsg('Max allowed height = ' . $this->_maxImageHeight . ', Image height = ' . $imageInfo['height']);
        }

        // If user set _autoResize then ignore these settings and try to resize on upload
        if (($doResizeCheck AND !($this->_autoResize)) OR (!($doResizeCheck))) {
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
    * @access private
    * @return array     Array with width and height of current image
    */
    function _getImageDimensions()
    {
        $dimensions = GetImageSize($this->_currentFile['tmp_name']);
        if ($this->_debug) {
            $this->_addDebugMsg('in _getImageDimensions I got a width of ' . $dimensions[0] . ', and a height of ' . $dimensions[1]);
        }
        return array('width' => $dimensions[0], 'height' => $dimensions[1]);
    }

    /**
    * Calculate the factor to scale images with if they're not meeting
    * the size restrictions.
    *
    * @access   private
    * @param    int     $width      width of the unscaled image
    * @param    int     $height     height of the unscaled image
    * @return   double              resize factor
    *
    */
    function _calcSizefactor ($width, $height) // 1000
    {
        if (($width > $this->_maxImageWidth) ||
                ($height > $this->_maxImageHeight)) {
            // get both sizefactors that would resize one dimension correctly
            $sizefactor_w = (double) ($this->_maxImageWidth / $width);
            $sizefactor_h = (double) ($this->_maxImageHeight / $height);
            // check if the height is ok after resizing the width
            if ( ($height * $sizefactor_w) > ($this->_maxImageHeight) ){
                // if no, get new sizefactor from height instead
                $sizefactor = $sizefactor_h;
            } else {
                // otherwise the width factor it ok to fit max dimensions
                $sizefactor = $sizefactor_w;
            }
        } else {
            $sizefactor = 1.0;
        }

        return $sizefactor;
    }

    /**
    * Keep the original (unscaled) image file, if configured.
    *
    * @access   private
    * @param    string  $filename   name of uploaded file
    * @return   bool                true: okay, false: an error occured
    *
    */
    function _keepOriginalFile ($filename)
    {
        if ($this->_keepOriginalImage) {
            $lFilename_large = substr_replace ($this->_getDestinationName (),
                '_original.', strrpos ($this->_getDestinationName (), '.'), 1);
            $lFilename_large_complete = $this->_fileUploadDirectory . '/'
                                      .  $lFilename_large;
            if (!copy ($filename, $lFilename_large_complete)) {
                $this->_addError ("Couldn't copy $filename to $lFilename_large_complete.  You'll need to remove both files.");
                $this->printErrors ();

                return false;
            }
        }

        return true;
    }

    /**
    * Gets destination file name for current file
    *
    * @access private
    * @return string    returns destination file name
    *
    */
    function _getDestinationName()
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
    * @access   private
    * @return   string  returns final permisisons for current file
    *
    */
    function _getPermissions()
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
    * @access   private
    * @return   boolean     true if copy succeeds otherwise false
    *
    */
    function _copyFile()
    {
        if (!is_writable($this->_fileUploadDirectory)) {
            // Developer didn't check return value of setPath() method which would
            // have told them the upload directory was not writable.  Error out now
            $this->_addError('Specified upload directory, ' . $this->_fileUploadDirectory . ' exists but is not writable');
            return false;
        }
        $sizeOK = true;
        if (!($this->_imageSizeOK(false)) AND $this->_autoResize) {
            $imageInfo = $this->_getImageDimensions($this->_currentFile['tmp_name']);
            if ($imageInfo['width'] > $this->_maxImageWidth) {
                $sizeOK = false;
            }

            if ($imageInfo['height'] > $this->_maxImageHeight) {
                $sizeOK = false;
            }
        }
        $returnMove = move_uploaded_file($this->_currentFile['tmp_name'], $this->_fileUploadDirectory . '/' . $this->_getDestinationName());
        if (!($sizeOK)) {
            // OK, resize
            $sizefactor = $this->_calcSizefactor ($imageInfo['width'],
                                                  $imageInfo['height']);
            $newwidth = (int) ($imageInfo['width'] * $sizefactor);
            $newheight = (int) ($imageInfo['height'] * $sizefactor);
            $this->_addDebugMsg ('Going to resize image to ' . $newwidth . 'x'
                                 . $newheight . ' using ' . $this->_imageLib);

            if ($this->_imageLib == 'imagemagick') {

                $newsize = $newwidth . 'x' . $newheight;
                $quality = '';
                if ($this->_jpegQuality > 0) {
                    $quality = sprintf(' -quality %d', $this->_jpegQuality);
                }
                $cmd = $this->_pathToMogrify . $quality . ' -resize '. $newsize . ' "' . $this->_fileUploadDirectory . '/' . $this->_getDestinationName() . '" 2>&1';
                $this->_addDebugMsg('Attempting to resize with this command (imagemagick): ' . $cmd);

                $filename = $this->_fileUploadDirectory . '/'
                            . $this->_getDestinationName ();
                if (!$this->_keepOriginalFile ($filename)) {
                    exit;
                }

                exec($cmd, $mogrify_output, $retval);

            } elseif ($this->_imageLib == 'netpbm') {

                $cmd = $this->_pathToNetPBM;
                $filename = $this->_fileUploadDirectory . '/' . $this->_getDestinationName();
                $cmd_end = " '" . $filename . "' | " . $this->_pathToNetPBM . 'pnmscale -xsize=' . $newwidth . ' -ysize=' . $newheight . ' | ' . $this->_pathToNetPBM;
                // convert to pnm, resize, convert back
                if (($this->_currentFile['type'] == 'image/png') ||
                    ($this->_currentFile['type'] == 'image/x-png')) {
                    $tmpfile = $this->_fileUploadDirectory . '/tmp.png';
                    $cmd .= 'pngtopnm ' . $cmd_end . 'pnmtopng > ' . $tmpfile;
                } elseif (($this->_currentFile['type'] == 'image/jpeg') ||
                          ($this->_currentFile['type'] == 'image/pjpeg')) {
                    $tmpfile = $this->_fileUploadDirectory . '/tmp.jpg';
                    $quality = '';
                    if ($this->_jpegQuality > 0) {
                        $quality = sprintf(' -quality=%d', $this->_jpegQuality);
                    }
                    $cmd .= 'jpegtopnm ' . $cmd_end . 'pnmtojpeg' . $quality . ' > ' . $tmpfile;
                } elseif ($this->_currentFile['type'] == 'image/gif') {
                    $tmpfile = $this->_fileUploadDirectory . '/tmp.gif';
                    $cmd .= 'giftopnm ' . $cmd_end . 'ppmquant 256 | '
                         . $this->_pathToNetPBM . 'ppmtogif > ' . $tmpfile;
                } else {
                    $this->_addError ("Image format of file $filename is not supported.");
                    $this->printErrors ();
                    exit;
                }
                $this->_addDebugMsg('Attempting to resize with this command (netpbm): ' . $cmd);
                exec($cmd, $netpbm_output, $retval);

                if (!$this->_keepOriginalFile ($filename)) {
                    exit;
                }

                // Move tmp file to actual file
                if (!copy($tmpfile,$filename)) {
                    $this->_addError("Couldn't copy $tmpfile to $filename.  You'll need remove both files");
                    $this->printErrors();
                    exit;
                } else {
                    // resize with netpbm worked, now remove tmpfile
                    if (!unlink($tmpfile)) {
                        $this->_addError("Couldn't delete $tmpfile.  You'll need to remove it manually");
                        $this->printErrors();
                        exit;
                    }
                }

            } elseif ($this->_imageLib == 'gdlib') {

                $filename = $this->_fileUploadDirectory . '/'
                          . $this->_getDestinationName();

                if (!$this->_keepOriginalFile ($filename)) {
                    exit;
                }

                if (!function_exists('gd_info')) {
                    $this->_addError('GD library does not seem to be enabled.');
                    $this->printErrors();
                    exit;
                }

                if (($this->_currentFile['type'] == 'image/png') OR
                    ($this->_currentFile['type'] == 'image/x-png')) {
                    if (!function_exists ('imagecreatefrompng')) {
                        $this->_addError ('Sorry, this version of the GD library does not support PNG images.');
                        $this->printErrors ();
                        exit;
                    }
                    if (!$image_source = imagecreatefrompng ($filename)) {
                        $this->_addError ('Could not create image from PNG: '
                                          . $filename);
                        $this->printErrors ();
                        exit;
                    }
                } elseif (($this->_currentFile['type'] == 'image/jpeg') OR
                          ($this->_currentFile['type'] == 'image/pjpeg')) {
                    if (!function_exists ('imagecreatefromjpeg')) {
                        $this->_addError ('Sorry, this version of the GD library does not support JPEG images.');
                        $this->printErrors ();
                        exit;
                    }
                    if (!$image_source = imagecreatefromjpeg ($filename)) {
                        $this->_addError ('Could not create image from JPEG: '
                                          . $filename);
                        $this->printErrors ();
                        exit;
                    }
                } elseif ($this->_currentFile['type'] == 'image/gif') {
                    if (!function_exists ('imagecreatefromgif')) {
                        $this->_addError ('Sorry, this version of the GD library does not support GIF images.');
                        $this->printErrors ();
                        exit;
                    }
                    if (!$image_source = imagecreatefromgif ($filename)) {
                        $this->_addError ('Could not create image from GIF: '
                                          . $filename);
                        $this->printErrors ();
                        exit;
                    }
                } else {
                    $this->_addError ('MIME type ' . $this->_currentFile['type']
                                      . ' not supported.');
                    $this->printErrors ();
                    exit;
                }

                // do resize
                $sizefactor = $this->_calcSizefactor ($imageInfo['width'],
                                                      $imageInfo['height']);
                $this->_addDebugMsg ('Resizing image, factor=' . $sizefactor);
                $newwidth = (int) ($imageInfo['width'] * $sizefactor);
                $newheight = (int) ($imageInfo['height'] * $sizefactor);
                $newsize = $newwidth . 'x' . $newheight;

                // ImageCreateTrueColor may throw a fatal error on some PHP
                // versions when GD2 is not installed. Ugly workaround, but
                // there seems to be no better way. Also see the discussion at
                // http://php.net/ImageCreateTrueColor
                $image_dest = @ImageCreateTrueColor($newwidth, $newheight);
                if (!$image_dest) {
                    $thumb = imagecreate ($newwidth, $newheight);
                    if ($this->_jpegQuality > 0) {
                        imagejpeg($thumb, $filename, $this->_jpegQuality);
                    } else {
                        imagejpeg($thumb, $filename);
                    }
                    imagedestroy ($thumb);
                    $image_dest = @imagecreatefromjpeg ($filename);
                    unlink ($filename);
                }

                imagecopyresampled($image_dest, $image_source, 0, 0, 0, 0,
                                   $newwidth, $newheight, $imageInfo['width'],
                                   $imageInfo['height']);
                if (($this->_currentFile['type'] == 'image/png') OR
                    ($this->_currentFile['type'] == 'image/x-png')) {
                    if (!imagepng ($image_dest, $filename)) {
                        $this->_addError ('Could not create PNG: ' . $filename);
                        $this->printErrors ();
                        exit;
                    }
                } elseif (($this->_currentFile['type'] == 'image/jpeg') OR
                          ($this->_currentFile['type'] == 'image/pjpeg')) {
                    if ($this->_jpegQuality > 0) {
                        $jpsuccess = imagejpeg($image_dest, $filename,
                                               $this->_jpegQuality);
                    } else {
                        $jpsuccess = imagejpeg($image_dest, $filename);
                    }
                    if (!$jpsuccess) {
                        $this->_addError ('Could not create JPEG: '. $filename);
                        $this->printErrors ();
                        exit;
                    }
                } elseif ($this->_currentFile['type'] == 'image/gif') {
                    if (!imagegif ($image_dest, $filename)) {
                        $this->_addError ('Could not create GIF: ' . $filename);
                        $this->printErrors ();
                        exit;
                    }
                }

            }

            if ($retval > 0) {
                if ($this->_imageLib == 'imagemagick') {
                    $this->_addError ('Image, ' . $this->_currentFile['name']
                        . ' had trouble being resized: ' . $mogrify_output[0]);
                } elseif ($this->_imageLib == 'netpbm') {
                    $this->_addError ('Image, ' . $this->_currentFile['name']
                        . ' had trouble being resized: ' . $netpbm_output[0]);
                }
                $this->printErrors();
                exit;
            } else {
                $this->_addDebugMsg ('Image, ' . $this->_currentFile['name'] . ' was resized from ' . $imageInfo['width'] . 'x' . $imageInfo['height'] . ' to ' . $newsize);
            }
        }
        $returnChmod = true;
        $perms = $this->_getPermissions();
        if (!empty($perms)) {
            $returnChmod = chmod ($this->_fileUploadDirectory . '/' . $this->_getDestinationName (), octdec ($perms));
        }

        if ($returnMove AND $returnChmod) {
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
    * @param     string    $path_to_mogrify    Absolute path to mogrify
    * @return    boolean   True if set, false otherwise
    *
    */
    function setMogrifyPath($path_to_mogrify)
    {
        $this->_imageLib = 'imagemagick';
        $this->_pathToMogrify = $path_to_mogrify;
        return true;
    }

    /**
    * Sets the path to where the netpbm utilities are
    *
    * @param     string    $path_to_netpbm    Absolute path to netpbm dir
    * @return    boolean   True if set, false otherwise
    *
    */
    function setNetPBM($path_to_netpbm)
    {
        $this->_imageLib = 'netpbm';
        $this->_pathToNetPBM = $path_to_netpbm;
        return true;
    }

    /**
    * Configure upload to use GD library
    *
    * @return    boolean   True if set, false otherwise
    *
    */
    function setGDLib()
    {
        $this->_imageLib = 'gdlib';
        return true;
    }

    /**
    * Sets mode to automatically resize images that are either too wide or
    * too tall
    *
    * @param    boolean    $switch  True to turn on, false to turn off
    *
    */
    function setAutomaticResize($switch)
    {
        $this->_autoResize = $switch;
    }

    /**
    * Allows you to override default max file size
    *
    * @param    int     $size_in_bytes      Max. size for uploaded files
    * @return   boolean true if we set it OK, otherwise false
    *
    */
    function setMaxFileSize($size_in_bytes)
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
    * @param    int    $width_pixels    Max. width allowed
    * @param    int    $height_pixels   Max. height allowed
    * @return   boolean true if we set values OK, otherwise false
    *
    */
    function setMaxDimensions($width_pixels, $height_pixels)
    {
        if (!is_numeric($width_pixels) AND !is_numeric($height_pixels)) {
            return false;
        }

        $this->_maxImageWidth = $width_pixels;
        $this->_maxImageHeight = $height_pixels;

        return true;
    }

    /**
    * Sets the max number of files that can be uploaded per form
    *
    * @param     int       $maxfiles    Maximum number of files to allow. Default is 5
    * @return    boolean   True if set, false otherwise
    *
    */
    function setMaxFileUploads($maxfiles)
    {
        $this->_maxFileUploadsPerForm = $maxfiles;
        return true;
    }

    /**
    * Allows you to keep the original (unscaled) image.
    *
    * @param    boolean   $keepit   true = keep original, false = don't
    * @return   boolean   true if we set values OK, otherwise false
    *
    */
    function keepOriginalImage ($keepit)
    {
        $this->_keepOriginalImage = $keepit;

        return true;
    }

    /**
    * Set JPEG quality
    *
    * NOTE:     The 'quality' is an arbitrary value used by the IJG library.
    *           It is not a percent value! The default (and a good value) is 75.
    *
    * @param    int       $quality  JPEG quality (0-100)
    * @return   boolean   true if we set values OK, otherwise false
    *
    */
    function setJpegQuality($quality)
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
    * @param    array   $validIPS   Array of valid IP addresses to allow file uploads from
    * @return   boolean returns true if we successfully limited the IP's, otherwise false
    */
    function limitByIP($validIPS = array('127.0.0.1'))
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
    *
    * NOTE: this only affects the actual file upload process.
    *
    * @param    boolean     $switch     true or false
    *
    */
    function setContinueOnError($switch)
    {
        if ($switch) {
            $this->_continueOnError = true;
        } else {
            $this->_continueOnError = false;
        }
    }

    /**
    * Sets log file
    *
    * @param    string  $logFile    fully qualified path to log files
    * @return   boolean returns true if we set the log file, otherwise false
    *
    */
    function setLogFile($logFile = '')
    {
        if (empty($logFile) OR !file_exists($logFile)) {
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
    * @param    boolean     $switch     flag, true or false
    *
    */
    function setLogging($switch)
    {
        if ($switch AND !empty($this->_logFile)) {
            $this->_doLogging = true;
        } else {
            if ($switch AND empty($this->_logFile)) {
                $this->_addWarning('Unable to enable logging because no log file was set.  Use setLogFile() method');
            }
            $this->_doLogging = false;
        }
    }

    /**
    * Returns whether or not logging is enabled
    *
    * @return   boolean returns true if logging is enabled otherwise false
    *
    */
    function loggingEnabled()
    {
        return $this->_doLogging;
    }

    /**
    * Will force the debug messages in this class to be
    * printed
    *
    * @param    boolean     $switch     flag, true or false
    *
    */
    function setDebug($switch)
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
    * @param    boolean     $switch     flag, true or false
    *
    */
    function setIgnoreMimeCheck($switch)
    {
        if ($switch) {
            $this->_ignoreMimeTest = true;
        } else {
            $this->_ignoreMimeTest = false;
        }
    }


    /**
    * This function will print any errors out.  This is useful in debugging
    *
    * @param    boolean     $verbose    whether or not to print immediately or return only a string
    * @return   string  if $verbose is false it returns all errors otherwise just an empty string
    *
    */
    function printErrors($verbose=true)
    {
        if (isset($this->_errors) AND is_array($this->_errors)) {
            $retval = '';
            reset($this->_errors);
            $nerrors = count($this->_errors);
            for ($i = 1; $i <= $nerrors; $i++) {
                if ($verbose) {
                    print current($this->_errors) . "<br" . XHTML . ">\n";
                } else {
                    $retval .= current($this->_errors) . "<br" . XHTML . ">\n";
                }
                next($this->_errors);
            }
            return $retval;
        }
    }

    /**
    * This function will print any warnings out.  This is useful in debugging
    *
    */
    function printWarnings()
    {
        if (isset($this->_warnings) AND is_array($this->_warnings)) {
            reset($this->_warnings);
            $nwarnings = count($this->_warnings);
            for ($i = 1; $i <= $nwarnings; $i++) {
                print current($this->_warnings) . "<br" . XHTML . ">\n";
                next($this->_warnings);
            }
        }
    }

    /**
    * This function will print any debug messages out.
    *
    */
    function printDebugMsgs()
    {
        if (isset($this->_debugMessages) AND is_array($this->_debugMessages)) {
            reset($this->_debugMessages);
            $nmsgs = count($this->_debugMessages);
            for ($i = 1; $i <= $nmsgs; $i++) {
                print current($this->_debugMessages) . "<br" . XHTML . ">\n";
                next($this->_debugMessages);
            }
        }
    }

    /**
    * Returns if any errors have been encountered thus far
    *
    * @return   boolean returns true if there were errors otherwise false
    *
    */
    function areErrors()
    {
        if (count($this->_errors) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * Sets allowed mime types for this instance
    *
    * @param    array   allowedMimeTypes        Array of allowed mime types
    *
    */
    function setAllowedMimeTypes($mimeTypes = array())
    {
        $this->_allowedMimeTypes = $mimeTypes;
    }

    /**
    * Gets allowed mime types for this instance
    *
    * @return   array   Returns array of allowed mime types
    *
    */
    function getAllowedMimeTypes()
    {
        return $this->_allowedMimeTypes;
    }

    /**
    * Checks to see that mime type for current file is allowed for upload
    *
    * @return   boolean     true if current file's mime type is allowed otherwise false
    *
    */
    function checkMimeType()
    {
        if ($this->_ignoreMimeTest) {
            return true;
        }

        $sc = strpos ($this->_currentFile['type'], ';');
        if ($sc > 0) {
            $this->_currentFile['type'] = substr ($this->_currentFile['type'], 0, $sc);
        }
        $mimeTypes = $this->getAllowedMimeTypes ();
        foreach ($mimeTypes as $mimeT => $extList) {
            if ($mimeT == $this->_currentFile['type']) {
                // Each defined Mime Type can have multiple possible extesions - need to test each
                if (is_array($extList)) {   // Used if allowedMimeTypes is being defined using the Online Config Manager
                    $extensions = array_keys($extList);
                } else {
                    $extensions = explode (',', $extList);
                }
                $fileName = $this->_currentFile['name'];
                foreach ($extensions as $ext) {
                    $ext = trim($ext);
                    if (strcasecmp (substr ($fileName, -strlen ($ext)), $ext) == 0) {
                        return true;
                    }
                }
            }
        }
        $this->_addError ('Mime type, ' . $this->_currentFile['type']
                          . ', or extension of ' . $this->_currentFile['name']
                          . ' not in list of allowed types.');
        return false;
    }

    /**
    * Sets file upload path
    *
    * @param    string  $uploadDir  Directory on server to store uploaded files
    * @return   boolean returns true if we successfully set path otherwise false
    *
    */
    function setPath($uploadDir)
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
    *
    */
    function getPath()
    {
        return $this->_fileUploadDirectory;
    }

    /**
    * Sets file name(s) for files
    *
    * This function will set the name of any files uploaded.  If the
    * number of file names sent doesn't match the number of uploaded
    * files a warning will be generated but processing will continue
    *
    * @param    string|array    $fileNames      A string or string array of file names
    *
    */
    function setFileNames($fileNames = 'geeklog_uploadedfile')
    {
        if (isset($fileNames) AND is_array($fileNames)) {
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
    * @param    string|array    $perms      A string or string array of file permissions
    *
    */
    function setPerms($perms)
    {
        if (isset($perms) AND is_array($perms)) {
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
    *
    */
    function numFiles()
    {
        if (empty($this->_filesToUpload)) {
            $this->_filesToUpload = $_FILES;
        }

        $fcount = 0;

        for ($i = 1; $i <= count($_FILES); $i++) {
            $curFile = current($this->_filesToUpload);

            // Make sure file field on HTML form wasn't empty
            if (!empty($curFile['name'])) {
                $fcount++;
            }
            next($this->_filesToUpload);
        }
        reset($_FILES);

        return $fcount;
    }

    /**
    * Uploads any posted files.
    *
    * @return   boolean returns true if no errors were encountered otherwise false
    */
    function uploadFiles()
    {
        // Before we do anything, let's see if we are limiting file uploads by
        // IP address and, if so, verify the poster is originating from one of
        // those places
        if ($this->_limitByIP) {
            if (!in_array($_SERVER['REMOTE_ADDR'], $this->_allowedIPS)) {
                $this->_addError('The IP, ' . $_SERVER['REMOTE_ADDR'] . ' is not in the list of '
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
        if (!$this->_ignoreMimeTest AND !$this->_allowedMimeTypes) {
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
                if ($this->checkMimeType() AND $this->_imageSizeOK() AND !$this->areErrors()) {
                    if ($this->_copyFile()) {
                        $this->_uploadedFiles[] = $this->_fileUploadDirectory . '/' . $this->_getDestinationName();
                    }
                }

                $this->_currentFile = array();

                if ($this->areErrors() AND !$this->_continueOnError) {
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
        if ($this->areErrors()) {
            return false;
        } else {
            return true;
        }
    }
}

?>
