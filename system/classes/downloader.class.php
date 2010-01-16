<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | downloader.class.php                                                      |
// |                                                                           |
// | Geeklog file download class library.                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
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
* This class allows you to download a file from outside the web tree.  Many
* hooks around security and file types have been added for customization within
* any app.
*
* @author   Tony Bibbs
*
*/
class downloader
{
    // Private Properties
    /**
    * @access private
    */
    var $_errors;               // Array
    /**
    * @access private
    */
    var $_warnings;             // Array
    /**
    * @access private
    */
    var $_debugMessages;        // Array
    /**
    * @access private
    */
    var $_allowedExtensions;    // Array
    /**
    * @access private
    */
    var $_availableExtensions;  // Array
    /**
    * @access private
    */
    var $_allowedIPS;           // Array
    /**
    * @access private
    */
    var $_sourceDirectory;      // String
    /**
    * @access private
    */
    var $_logFile;              // String
    /**
    * @access private
    */
    var $_doLogging;            // Boolean
    /**
    * @access private
    */
    var $_debug;                // Boolean
    /**
    * @access private
    */
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

        $this->_setAvailableExtensions ();
    }

    // PRIVATE METHODS

    /**
    * Adds a warning that was encountered
    *
    * @param    string      $warningTextText of warning
    * @access   private
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
    * @param    string      $errorText  Text of error
    * @access   private
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
    * @param    string      $debugText      Text of debug message
    * @access   private
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
    * @param    string      $logtype        can be 'warning' or 'error'
    * @param    string      $text           Text to log to log file
    * @return   boolean     true on success otherwise false
    * @access   private
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
    * @param    array       $extensions     string array of valid mime types this object will accept
    *
    */
    function _setAvailableExtensions($extensions = array())
    {
        if (count($extensions) == 0) {
            $this->_availableMimeTypes = 
                array(
                    'tgz'  => 'application/x-gzip-compressed',
                    'gz'   => 'application/x-gzip-compressed',
                    'zip'  => 'application/x-zip-compresseed',
                    'tar'  => 'application/x-tar',
                    'php'  => 'text/plain',
                    'phps' => 'text/plain',
                    'txt'  => 'text/plain',
                    'html' => 'text/html',
                    'htm'  => 'text/html',
                    'bmp'  => 'image/bmp',
                    'ico'  => 'image/bmp',
                    'gif'  => 'image/gif',
                    'jpg'  => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png'  => 'image/png',
                    'png'  => 'image/x-png',
                    'mp3'  => 'audio/mpeg',
                    'wav'  => 'audio/wav',
                    'pdf'  => 'application/pdf',
                    'swf'  => 'application/x-shockwave-flash',
                    'doc'  => 'application/msword',
                    'xls'  => 'application/vnd.ms-excel',
                    'exe'  => 'application/octet-stream',
                    'sql'  => 'text/plain'
                );
        } else {
            $this->_availableMimeTypes = $extensions;
        }

        $this->_availableExtensions = array ();
        foreach ($this->_availableMimeTypes as $ext => $mime) {
            $this->_availableExtensions[] = $ext;
        }
    }

    // Public Methods

    /**
    * Extra security option that forces all attempts to download a file to be
    * done so from a set of VERY specific IP's.  This is only good for those
    * who are paranoid
    *
    * @param    array       $validIPS   Array of valid IP addresses to allow file uploads from
    * @return   boolean     returns true on success otherwise false
    *
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
    * Sets log file
    *
    * @param        string      $logFile    fully qualified path to log files
    * @return       boolean                 true on success otherwise false
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
    * @return   boolean     true if logging is enabled otherwise false
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
    * This function will print any errors out.  This is useful in debugging
    *
    * @param    boolean     $verbose    will print errors to web browser if true
    * @return   boolean     string of all errors
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
    * @return       boolean     True if errors occurred otherwise false
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
    * @param  array  $validExtensions  Array of allowed extensions and mime types
    *
    */
    function setAllowedExtensions($validExtensions = array())
    {
        // This is a subset of _availableMimetypes.  Go ahead and make sure
        // all the mime types passed to this function are in the
        // available list
        foreach ($validExtensions as $ext => $mime) {
            if (!in_array ($mime, $this->_availableMimeTypes)) {
                $this->_addError('extension, ' . $ext . ' is not in the list of available file types for download');
                return;
            }
        }
        $this->_allowedExtensions = $validExtensions;
    }

    /**
    * Gets allowed mime types for this instance
    *
    * @return   array       array of allowed mime types/file extensions
    *
    */
    function getAllowedExtensions()
    {
        return $this->_allowedExtensions;
    }

    /**
    * Checks to see that mime type for current file is allowed for upload
    *
    * @param        string      $extension      Verifies file extension is allowed for download
    * @return       boolean     true if allowed otherwise false
    *
    */
    function checkExtension($extension)
    {
        if (!in_array($extension,array_keys($this->getAllowedExtensions()))) {
            $this->_addError('File type, .' . $extension . ', not in list of allowed file types available for download');
            return false;
        } else {
            return true;
        }
    }

    /**
    * Sets file upload path
    *
    * @param    string      $uploadDir      Directory on server to store uploaded files
    * @return   boolean     true on success otherwise false
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
    * @return   string      returns directory where files for downloading reside
    *
    */
    function getPath()
    {
        return $this->_sourceDirectory;
    }

    /**
    * Attempts to dowload a file
    *
    * @param    string      $fileName       file to download without path
    * @return   boolean     true on success otherwise false
    *
    */
    function downloadFile($fileName)
    {
        // Before we do anything, let's see if we are limiting file downloads by
        // IP address and, if so, verify the user is originating from one of
        // those places
        if ($this->_limitByIP) {
            if (!in_array($_SERVER['REMOTE_ADDR'], $this->_allowedIPS)) {
                $this->_addError('The IP, ' . $_SERVER['REMOTE_ADDR'] . ' is not in the list of accepted IP addresses.  Refusing to allow file download(s)');
                return false;
            }
        }

        if (strstr( PHP_OS, "WIN")) {  // Added as test1 below was failing on Windows platforms 
            $strPathSeparator = '\\';
            $this->_sourceDirectory = str_replace('/','\\',$this->_sourceDirectory);
        } else {
            $strPathSeparator = '/';
        }

        if(!is_file($this->_sourceDirectory . $fileName)) {
            echo "<br" . XHTML . ">{$this->sourceDirectory}{$filename} does not exist";
        }


        // Ensure file exists and is accessible
        if(!is_file($this->_sourceDirectory . $fileName) OR 
            ($this->_sourceDirectory <> (dirname($this->_sourceDirectory . $strPathSeparator .$fileName) .$strPathSeparator)) ) {
            $this->_addError('Specified file ' . $this->_sourceDirectory . $fileName . ' does not exist or is not accessible');
            return false;
        }

        // Make sure file is readable - test 2
        clearstatcache();
        if (!is_readable($this->_sourceDirectory . $fileName)) {
            $this->_addError('Specified file, ' . $this->_sourceDirectory . $fileName . ' exists but is not readable');
            return false;
        }

        // OK, file is valid, get file extension
        $pos = strrpos($fileName,'.') + 1;
        $fextension = substr($fileName, $pos);

        // If application has not set the allowedExtensions then initialize to the default
        if(count($this->_allowedExtensions) == 0) {
            $this->_allowedExtensions = array_flip($this->_availableExtensions);
        }

        // Send headers.
        if ($this->checkExtension($fextension)) {
            // Display file inside browser.
            header('Content-Type: ' . $this->_availableMimeTypes[$fextension]);
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '
                   . filesize($this->_sourceDirectory . $fileName));

            // send images as 'inline' everything else as 'attachment'
            if (substr($this->_availableMimeTypes[$fextension], 0, 6) == 'image/') {
                header('Content-Disposition: inline; filename="' . $fileName . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
            }

            // Send file contents.
            $fp = fopen($this->_sourceDirectory . $fileName, 'rb');
            fpassthru($fp);
            fclose($fp);
        }

        return true;
    }

}

?>
