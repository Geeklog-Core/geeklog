<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | upload.class.php                                                          |
// | Geeklog file upload class library.                                        |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002 by the following authors:                              |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            | 	
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
//
// $Id: upload.class.php,v 1.5 2002/04/10 16:11:25 tony_bibbs Exp $

class upload
{
    // Private Properties
    var $_errors;               // Array
    var $_warnings;             // Array
    var $_debugMessages;        // Array
    var $_allowedMimeTypes;     // Array
    var $_availableMimeTypes;   // Array
    var $_filesToUpload;        // Array
    var $_currentFile;          // Array
    var $_allowedIPS;           // Array
    var $_uploadedFiles;        // Array
    var $_maxImageWidth;        // Pixels
    var $_maxImageHeight;       // Pixels
    var $_maxFileSize;          // Long, in bytes
    var $_fileUploadDirectory;  // String
    var $_fileNames;            // String
    var $_permissions;          // String
    var $_logFile;              // String
    var $_doLogging;            // Boolean
    var $_continueOnError;      // Boolean
    var $_debug;                // Boolean
    var $_limitByIP;            // Boolean
    var $_numSuccessfulUploads; // Integer
    var $_imageIndex;           // Integer
    
    /**
    * Constructor
    *
    */
    function upload()
    {
        $this->_errors = array();
        $this->_warnings = array();
        $this->_debugMessages = array();
        $this->_allowedMimeTypes = array();
        $this->_availableMimeTypes = array();
        $this->_currentFile = array();
        $this->_uploadedFiles = array();
        $this->_maxImageWidth = 300;
        $this->_maxImageHeight = 300;
        $this->_maxFileSize = 1048576; // 1MB = 1048576
        $this->_fileUploadDirectory = '';
        $this->_fileNames = '';
        $this->_permissions = '';
        $this->_logFile = '';
        $this->_doLogging = false;
        $this->_continueOnError = false;
        $this->_numSuccessfulUploads = 0;
        $this->_imageIndex = 0;
        $this->_maxFileUploadsPerForm = 5;
        $this->_limitByIP = false;
        
        $this->_setAvailableMimeTypes();
    }
    
    // PRIVATE METHODS

    /**
    * Adds a warning that was encountered
    *
    * @warningText  string  Text of warning
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
	* @errorText    string  Text of error
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
    * @debugText    string  Text of debug message
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
    * @logtype  string  can be 'warning' or 'error'
    * @text     string  Text to log to log file
    *
    */
	function _logItem($logtype, $text)
	{
        $timestamp = strftime("%c");
        if (!$file = fopen($this->_logFile,a)) {
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
    * @mimeTypes    array   string array of valid mime types this object will accept
    *
    */
    function _setAvailableMimeTypes($mimeTypes = array())
    {
		if (sizeof($mimeTypes) == 0) {
			$this->_availableMimeTypes = 
				array(
					'application/x-gzip-compressed' 	=> '.tar.gz, .tgz',
					'application/x-zip-compressed' 		=> '.zip',
					'application/x-tar'					=> '.tar',
					'text/plain'						=> '.php, .txt, .inc (etc)',
					'text/html'							=> '.html, .htm (etc)',
					'image/bmp' 						=> '.bmp, .ico',
					'image/gif' 						=> '.gif',
					'image/pjpeg'						=> '.jpg, .jpeg',
					'image/jpeg'						=> '.jpg, .jpeg',
					'image/x-png'						=> '.png',
					'audio/mpeg'						=> '.mp3 etc',
					'audio/wav'							=> '.wav',
					'application/pdf'					=> '.pdf',
					'application/x-shockwave-flash' 	=> '.swf',
					'application/msword'				=> '.doc',
					'application/vnd.ms-excel'			=> '.xls',
					'application/octet-stream'			=> '.exe, .fla, .psd (etc)'
				);
		} else {
			$this->_availableMimeTypes = $mimeTypes;
		}
    }
    
    /**
    * Checks if current file is an image
    *
    */    
    function _isImage()
    {
        if (ereg("image",$this->_currentFile['type'])) {
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
    */
	function _imageSizeOK()
	{
        if (!$this->_isImage()) {
            return true;
        }
        
        $imageInfo = $this->_getImageDimensions($this->_currentFile['tmp_name']);
		   
		$sizeOK = true;
		
		if ($this->imageInfo['width'] > $this->maxImageWidth) {
			$sizeOK = false;
			$this->_addError('Image, ' . $this->_currentFile['name'] . ' does not meet width limitations');
		}

		if ($this->imageInfo['height'] > $this->maxImageHeight) {
			$sizeOK= false;
			$this->_addError('Image, ' . $this->_currentFile['name'] . ' does not meet height limitations');
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
	*/
	function _getImageDimensions()
	{
		$dimensions = GetImageSize($this->_currentFile['tmp_name']);
		
		return array('width' => $dimensions[0], 'height' => $dimensions[1]);
	}
	
	/**
	* Gets destination file name for current file
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
    */
	function _getPermissions()
	{
        if (is_array($this->_permissions)) {
            if (count($this->_permissions > 1)) {
                $perms = $this->_permissions[$this->_imageIndex];
            } else {
                $perms = $this->_permissions;
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
	*/
	function _copyFile()
	{
        if (!is_writable($this->_fileUploadDirectory)) {
            // Developer didn't check return value of setPath() method which would
            // have told them the upload directory was not writable.  Error out now
            $this->_addError('Specified upload directory, ' . $this->_fileUploadDirectory . ' exists but is not writable');
            return false;
        }        
        $returnMove = move_uploaded_file($this->_currentFile['tmp_name'], $this->_fileUploadDirectory . '/' . $this->_getDestinationName());
        $returnChmod = true;
        $perms = $this->_getPermissions();
        if (!empty($perms)) {
            $returnChmod = chmod($this->_fileUploadDirectory . '/' . $this->_getDestinationName(), octdec($perms));
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
	
    // Public Methods
    
    /**
    * Extra security option that forces all attempts to upload a file to be done
    * so from a set of VERY specific IP's.  This is only good for those who are
    * paranoid
    *
    * @validIPS     array   Array of valid IP addresses to allow file uploads from
    *
    */
    function limitByIP($validIPS = array('127.0.0.1'))
    {
        if (is_array($validIPS)) {
            $this->_limitByIP = true;
            $this->_allowedIPS = $valid_IPS;
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
    * NOTE: this only effects the actual file upload process.
    *
    * @switch   boolean     true or false
    *
    */
    function setContinueOnError($switch)
    {
        if ($switch) {
            $this->_continueOnError = $true;
        } else {
            $this->_continueOnError = $false;
        }
    }
    
    /**
    * Sets log file
    *
    * @fileName     string      fully qualified path to log files
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
    * $switch   boolean     flag, true or false
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
    */
    function loggingEnabled()
    {
        return $this->_doLogging;
    }

    /**
    * Will force the debug messages in this class to be
    * printed
    *
    * @switch   boolean     flag, true or false
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
    * This function will print any errors out.  This is useful in debugging
    *
    */
    function printErrors()
    {
        if (isset($this->_errors) AND is_array($this->_errors)) {
            reset($this->_errors);
            $nerrors = count($this->_errors);
            for ($i = 1; $i <= $nerrors; $i++) {
                print current($this->_errors) . "<BR>\n";
                next($this->_errors);
            }
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
                print current($this->_warnings) . "<BR>\n";
                next($this->_warnings);
            }
        }
    }
    
    /**
    * This function will print any debmug messages out.
    *
    */
    function printDebugMsgs()
    {
        if (isset($this->_debugMessages) AND is_array($this->_debugMessages)) {
            reset($this->_debugMessages);
            $nmsgs = count($this->_debugMessages);
            for ($i = 1; $i <= $nmsgs; $i++) {
                print current($this->_debugMessages) . "<BR>\n";
                next($this->_debugMessages);
            }
        }
    }
    
    /**
    * Returns if any errors have been encountered thus far
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
    * @allowedMimeTypes     array   Array of allowed mime types
    *
    */
    function setAllowedMimeTypes($mimeTypes = array())
	{
		$this->_allowedMimeTypes = $mimeTypes;
	}
	
	/**
	* Gets allowed mime types for this instance
	*
	*/
	function getAllowedMimeTypes()
	{
		return $this->_allowedMimeTypes;
	}
	
    /**
    * Checks to see that mime type for current file is allowed for upload
    *
    */
    function checkMimeType()
    {
        if (!in_array($this->_currentFile['type'],$this->getAllowedMimeTypes())) {
			$this->_addError('Mime type, ' . $this->_currentFile['type'] . ', not in list of allowed mime types');
			return false;
		} else {
			return true;
		}
    }
    
    /**
    * Sets file upload path
    *
    * @uploadDir    string  Directory on server to store uploaded files
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
    * @fileNames    string/Array    A string or string array of file names
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
    * $perms    String/Array    A string or string array of file permissions
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
    */
	function numFiles()
	{
        if (empty($this->_filesToUpload)) {
            $this->_filesToUpload = $GLOBALS['HTTP_POST_FILES'];
        }
        
        $fcount = 0;
        
        for ($i = 1; $i <= count($GLOBALS['HTTP_POST_FILES']); $i++) {
            $curFile = current($this->_filesToUpload);
        
            // Make sure file field on HTML form wasn't empty
            if (!empty($curFile['name'])) {
                $fcount++;
            }
            next($this->_filesToUpload);
        }
        return $fcount;
	}
	
	/**
	* Uploads any posted files. If form has more than one file field, this will
	* return false if any errors were encountered.
	*
	*/
	function uploadFiles()
	{
        // Before we do anything, let's see if we are limiting file uploads by IP
        // address and, if so, verify the poster is originating from one of those
        // places
        if ($this->_limitByIP) {
            if (!in_array($GLOBALS['REMOTE_ADDR'], $this->_allowedIPS)) {
                $this->_addError('The IP, ' . $GLOBALS['REMOTE_ADDR'] . ' is not in the list of '
                    . 'accepted IP addresses.  Refusing to allow file upload(s)');
                return false;
            }
        }
        
		$this->_filesToUpload = $GLOBALS['HTTP_POST_FILES'];
		$numFiles = count($this->_filesToUpload);
        
        // For security sake, check to make sure a DOS isn't happening by making sure
        // there is a limit of the number of files being uploaded
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
        if (!$this->_allowedMimeTypes) {
            $this->_addError('No allowed mime types specified, use setAllowedMimeTypes() method');
        }
        
		for ($i = 1; $i <= $numFiles; $i++) {
		
            $this->_currentFile = current($GLOBALS['HTTP_POST_FILES']);
            
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
            next($GLOBALS['HTTP_POST_FILES']);
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