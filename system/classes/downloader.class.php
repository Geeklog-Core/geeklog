<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | downloader.class.php                                                      |
// | Geeklog file download class library.                                      |
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
// $Id: downloader.class.php,v 1.1 2002/04/25 21:37:33 tony_bibbs Exp $

class downloader
{
    // Private Properties
    var $_errors;               // Array
    var $_warnings;             // Array
    var $_debugMessages;        // Array
    var $_allowedExtensions;    // Array
    var $_availableExtensions;  // Array
    var $_allowedIPS;           // Array
    var $_sourceDirectory;      // String
    var $_logFile;              // String
    var $_doLogging;            // Boolean
    var $_debug;                // Boolean
    var $_limitByIP;            // Boolean
    
    /**
    * Constructor
    *
    */
    function downloader()
    {
        $this->_errors = array();
        $this->_warnings = array();
        $this->_debugMessages = array();
        $this->_allowedExtensions = array();
        $this->_availableExtensions = array();
        $this->_sourceDirectory = '';
        $this->_logFile = '';
        $this->_doLogging = false;
        $this->_limitByIP = false;
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
    function _setAvailableExtensions($extensions = array())
    {
		if (sizeof($extensions) == 0) {
			$this->_availableMimeTypes = 
				array(
                    
					'tgz' => 'application/x-gzip-compressed',
                    'gz' =>  'application/x-gzip-compressed',
					'zip' => 'application/x-zip-compresseed',
					'tar' => 'application/x-tar',
					'php' => 'text/plain',
                    'phps' => 'text/plain',
                    'txt' => 'text/plain',
					'html' => 'text/html',
                    'htm' => 'text/html',
					'bmp' => 'image/bmp',
                    'ico' => 'image/bmp',
					'gif' => 'image/gif',
					'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
					'png' => 'image/x-png',
					'mp3' => 'audio/mpeg',
					'wav' => 'audio/wav',
					'pdf' => 'application/pdf',
					'swf' => 'application/x-shockwave-flash',
					'doc' => 'application/msword',
					'xls' => 'application/vnd.ms-excel',
					'exe' => 'application/octet-stream'
				);
		} else {
			$this->_availableMimeTypes = $extensions;
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
    function printErrors($verbose=true)
    {
        if (isset($this->_errors) AND is_array($this->_errors)) {
            $retval = '';
            reset($this->_errors);
            $nerrors = count($this->_errors);
            for ($i = 1; $i <= $nerrors; $i++) {
                if ($verbose) {
                    print current($this->_errors) . "<BR>\n";
                } else {
                    $retval .= current($this->_errors) . "<BR>\n";
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
    function setAllowedExtensions($validExtensions = array())
	{
        // This is a subset of _availableMimetypes.  Go ahead and make sure
        // all the mime types passed to this function are in the
        // available list
        for ($i = 1; $i <= count($validExtensions); $i++) {
            if (!in_array(current($validExtensions),$this->_availableExtensions)) {
                $this->_addError('extension, ' .current($validExtensions) . ' is not in the list of available file types for download');
                return;
            }
            next($validExtensions);
        }
        $this->_allowedExtensions = $validExtensions;
	}
	
	/**
	* Gets allowed mime types for this instance
	*
	*/
	function getAllowedExtensions()
	{
		return $this->_allowedExtensions;
	}
	
    /**
    * Checks to see that mime type for current file is allowed for upload
    *
    */
    function checkExtension($extension)
    {
        if (!in_array($extensions,$this->getAllowedExtensions())) {
			$this->_addError('File type, .' . $extension . ', not in list of allowed file types available for download');
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
            $this->_addError('Specified source directory, ' . $uploadDir . ' is not a valid directory');
            return false;
        }
        
        if (!is_readable($uploadDir)) {
            $this->_addError('Specified source directory, ' . $uploadDir . ' exists but is not readable');
            return false;
        }
        
        $this->_sourceDirectory = $uploadDir;
        
        return true;
	}
	
	/**
	* Returns directory to upload to
	*
	*/
	function getPath()
	{
        return $this->_sourceDirectory;
	}
	
	function downloadFile($fileName)
	{
        // Ensure file exists        
        if(!is_file($this->_sourceDirectory . $fileName)) {
            $this->_addError('Specified file ' . $this->_sourceDirectory . $fileName . ' does not exist');
            return false;
        }
        
        // Make sure file is readable
        clearstatcache();
        if (!is_readable($this->_sourceDirectory . $fileName)) {
            $this->_addError('Specified file, ' . $this->_sourceDirectory . $fileName . ' exists but is not readable');
            return false;
        }
        
        // OK, file is valid, get file extension
        $pos = strrpos($fileName,'.') + 1;
        $fextension = substr($fileName, $pos);
        
        // Send headers.
        if ($this->checkExtension($fextension)) {
            // Display file inside browser.
            header('Content-type: ' . $this->_availableMimeTypes[$fextension] . "\n");
            header('Content-transfer-encoding: binary' . "\n");
            header('Content-length: ' . filesize($this->_sourceDirectory . $fileName) . "\n");

            // Send file contents.
            $fp = fopen($this->_sourceDirectory . $fileName, 'rb');

            fpassthru( $fp );
        }
            	
	}
	
}

?>