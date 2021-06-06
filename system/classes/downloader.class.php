<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
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
 */
class downloader
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
    private $_allowedExtensions = array();

    /**
     * @var array
     */
    private $_availableExtensions = array();

    /**
     * @var array
     */
    private $_availableMimeTypes = array();

    /**
     * @var array
     */
    private $_allowedIPS = array();

    /**
     * @var string
     */
    private $_sourceDirectory = '';

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
    private $_debug = false;

    /**
     * @var bool
     */
    private $_limitByIP = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_errors = array();
        $this->_warnings = array();
        $this->_debugMessages = array();
        $this->_allowedExtensions = array();
        $this->_availableExtensions = array();
        $this->_availableMimeTypes = array();
        $this->_sourceDirectory = '';
        $this->_logFile = '';
        $this->_doLogging = false;
        $this->_limitByIP = false;

        $this->_setAvailableExtensions();
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
     * @param    string $debugText Text of debug message
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
     * @return   boolean     true on success otherwise false
     */
    private function _logItem($logType, $text)
    {
        $timestamp = strftime("%c");
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
     * @param    array $extensions string array of valid mime types this object will accept
     */
    private function _setAvailableExtensions($extensions = array())
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
                    'mp3'  => 'audio/mpeg',
                    'wav'  => 'audio/wav',
                    'pdf'  => 'application/pdf',
                    'swf'  => 'application/x-shockwave-flash',
                    'doc'  => 'application/msword',
                    'xls'  => 'application/vnd.ms-excel',
                    'exe'  => 'application/octet-stream',
                    'sql'  => 'text/plain',
                );
        } else {
            $this->_availableMimeTypes = $extensions;
        }

        $this->_availableExtensions = array();
        foreach ($this->_availableMimeTypes as $ext => $mime) {
            $this->_availableExtensions[] = $ext;
        }
    }

    /**
     * Extra security option that forces all attempts to download a file to be
     * done so from a set of VERY specific IP's.  This is only good for those
     * who are paranoid
     *
     * @param    array $validIPS Array of valid IP addresses to allow file uploads from
     * @return   boolean     returns true on success otherwise false
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
     * Sets log file
     *
     * @param        string $logFile fully qualified path to log files
     * @return       boolean                 true on success otherwise false
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
     * Return the log file
     *
     * @return string
     */
    public function getLogFile()
    {
        return $this->_logFile;
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
     * @return   boolean     true if logging is enabled otherwise false
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
     * Return the debug mode
     *
     * @return bool
     */
    public function isDebug()
    {
        return $this->_debug;
    }

    /**
     * This function will print any errors out.  This is useful in debugging
     *
     * @param    boolean $verbose will print errors to web browser if true
     * @return   boolean     string of all errors
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
                print current($this->_warnings) . '<br' . XHTML . '>' . PHP_EOL;
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
                print current($this->_debugMessages) . '<br' . XHTML . '>' . PHP_EOL;
                next($this->_debugMessages);
            }
        }
    }

    /**
     * Returns if any errors have been encountered thus far
     *
     * @return       boolean     True if errors occurred otherwise false
     */
    public function areErrors()
    {
        return (count($this->_errors) > 0);
    }

    /**
     * Sets allowed mime types for this instance
     *
     * @param  array $validExtensions Array of allowed extensions and mime types
     */
    public function setAllowedExtensions($validExtensions = array())
    {
        // This is a subset of _availableMimetypes.  Go ahead and make sure
        // all the mime types passed to this function are in the
        // available list
        foreach ($validExtensions as $ext => $mime) {
            if (!in_array($mime, $this->_availableMimeTypes)) {
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
     */
    public function getAllowedExtensions()
    {
        return $this->_allowedExtensions;
    }

    /**
     * Checks to see that mime type for current file is allowed for upload
     *
     * @param        string $extension Verifies file extension is allowed for download
     * @return       boolean     true if allowed otherwise false
     */
    public function checkExtension($extension)
    {
        if (!in_array($extension, array_keys($this->getAllowedExtensions()))) {
            $this->_addError('File type, .' . $extension . ', not in list of allowed file types available for download');

            return false;
        } else {
            return true;
        }
    }

    /**
     * Sets file upload path
     *
     * @param    string $uploadDir Directory on server to store uploaded files
     * @return   boolean     true on success otherwise false
     */
    public function setPath($uploadDir)
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
     */
    public function getPath()
    {
        return $this->_sourceDirectory;
    }

    /**
     * Attempts to dowload a file
     *
     * @param    string $fileName file to download without path
     * @return   boolean     true on success otherwise false
     */
    public function downloadFile($fileName)
    {
        // Before we do anything, let's see if we are limiting file downloads by
        // IP address and, if so, verify the user is originating from one of
        // those places
        if ($this->_limitByIP) {
            if (!in_array(\Geeklog\IP::getIPAddress(), $this->_allowedIPS)) {
                $this->_addError('The IP, ' . \Geeklog\IP::getIPAddress() . ' is not in the list of accepted IP addresses.  Refusing to allow file download(s)');

                return false;
            }
        }

        if (strstr(PHP_OS, "WIN")) {  // Added as test1 below was failing on Windows platforms
            $strPathSeparator = '\\';
            $this->_sourceDirectory = str_replace('/', '\\', $this->_sourceDirectory);
        } else {
            $strPathSeparator = '/';
        }

        if (!is_file($this->_sourceDirectory . $fileName)) {
            echo "<br" . XHTML . ">{$this->_sourceDirectory}{$fileName} does not exist";
        }


        // Ensure file exists and is accessible
        if (!is_file($this->_sourceDirectory . $fileName) ||
            ($this->_sourceDirectory <> (dirname($this->_sourceDirectory . $strPathSeparator . $fileName) . $strPathSeparator))
        ) {
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
        $pos = strrpos($fileName, '.') + 1;
        $fileExtension = substr($fileName, $pos);

        // If application has not set the allowedExtensions then initialize to the default
        if (count($this->_allowedExtensions) == 0) {
            $this->_allowedExtensions = array_flip($this->_availableExtensions);
        }

        // Send headers.
        if ($this->checkExtension($fileExtension)) {
            // Display file inside browser.
            header('Content-Type: ' . $this->_availableMimeTypes[$fileExtension]);
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($this->_sourceDirectory . $fileName));

            // send images as 'inline' everything else as 'attachment'
            if (substr($this->_availableMimeTypes[$fileExtension], 0, 6) === 'image/') {
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
