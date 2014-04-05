<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | xmlsitemap.class.php                                                      |
// |                                                                           |
// | Google Sitemap Generator classes                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2014 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO        - geeklog AT mystral-kk DOT net                 |
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
* Google Sitemap Generator classes
*
* @package XMLSitemap
*/

if (stripos($_SERVER['PHP_SELF'], 'xmlsitemap.class.php') !== FALSE) {
    die('This file cannot be used on its own.');
}

/**
* This is the built-in Geeklog class for creating the Google sitemap.
*
* USAGE:
*
* <code>
*   $sitemap = new SitemapXML();
*   $sitemap->setFileNames('path_to_sitemap_file',
*       'path_to_mobile_sitemap_file');
*   // $sitemap->setTypes(array('article', 'staticpages'));
*   // $sitemap->setPriority('article', 0.6);
*   // $sitemap->setPriority('staticpages', 0.4);
*   // $sitemap->setChangeFreq('article', 'weekly');
*   // $sitemap->setChangeFreq('staticpages', 'monthly');
*   $sitemap->create();
* </code>
*
*/
class SitemapXML
{
    // Constants
    const MAX_NUM_ENTRIES = 50000;
    const MAX_FILE_SIZE   = 10485760;	// 1MB
    const PING_INTERVAL   = 3600;		// 1 hour
    const LB = "\n";

    // Vars
    private $_num_entries;
    private $_encoding;
    private $_changeFreqs;
    private $_priorities;
    private $_types;
    private $_filename;
    private $_mobile_filename;

    // Valid expressions for 'changefreq' field
    private $_valid_change_freqs = array('always', 'hourly', 'daily', 'weekly',
            'monthly', 'yearly', 'never');

    /**
    * Constructor
    *
    * @param   string   $encoding   the encoding of contents
    */
    public function __construct($encoding = '')
    {
        $this->_num_entries = 0;
        $this->setEncoding($encoding);
        $this->_changeFreqs = array();
        $this->_priorities  = array();

        // Set only 'article' as default value
        $this->setTypes(array('article'));
    }

    /**
    * Set the encoding of contents
    *
    * @param   string   $encoding   the encoding of contents
    * @return  void
    */
    public function setEncoding($encoding)
    {
        if ($encoding == '') {
            $encoding = COM_getCharset();
        }
        if ($encoding == '') {  // This is very unlikely
            $encoding = 'iso-8859-1';
        }

        $this->_encoding = $encoding;
    }

    /**
    * Return the encoding of the source content
    *
    * @return  string   the encoding of contents
    */
    public function getEncoding()
    {
        return $this->_encoding;
    }

    /**
    * Set the name(s) of the sitemap file (and optionally the mobile
    * sitemap file)
    *
    * NOTE:    Sitemap files must be located in the top directory of the site,
    *          i.e., the same directory as "lib-common.php".
    *
    * @param   string   $filename           name of sitemap file
    * @param   string   $mobile_filename    name of mobile sitemap file
    */
    public function setFileNames($filename = '', $mobile_filename = '')
    {
        global $_CONF;

        if ($filename != '') {
            $this->_filename = $_CONF['path_html'] . basename($filename);
        }

        if ($mobile_filename != '') {
            $this->_mobile_filename = $_CONF['path_html'] . basename($mobile_filename);
        }
    }

    /**
    * Return the names of sitemap files
    *
    * @return  array    names of the sitemap and mobile sitemap
    */
    public function getFileNames()
    {
        return array($this->_filename, $this->_mobile_filename);
    }

    /**
    * Check if a string stands for a valid value of priority
    *
    * @param   string   $str    a string for a priority
    * @return  float            a valid value or 0.5 (default value)
    */
    public function checkPriority($str)
    {
        $v = (float) $str;

        return (($v >= 0.0) && ($v <= 1.0)) ? $v : 0.5;
    }

    /**
    * Set the priority of the item
    *
    * @param   string   $type   'article', 'staticpages', ...
    * @param   float    $value  the value of priority
    */
    public function setPriority($type, $value)
    {
        $value = $this->checkPriority($value);

        if ($value != 0.5) {
            $this->_priorities[$type] = $value;
        }
    }

    /**
    * Return the value of priority
    *
    * @param   string  $type   'article', 'staticpages', ...
    * @return  float           0.0..1.0 (default value is 0.5)
    */
    public function getPriority($type)
    {
        if (isset($this->_priorities[$type])) {
            return (float) $this->_priorities[$type];
        } else {
            return 0.5;
        }
    }

    /**
    * Check if a string stands for a proper frequency
    *
    * @param   string  $str    a string for a frequency
    * @return  string          a valid string or an empty string
    */
    public function checkChangeFreq($str)
    {
        $str = strtolower($str);

        return in_array($str, $this->_valid_change_freqs) ? $str : '';
    }

    /**
    * Set the change frequency of the item
    *
    * @param   string  $type   'article', 'staticpages', ...
    * @param   string  $value  any of 'always', 'hourly', 'daily', 'weekly',
    *                          'monthly', 'yearly', 'never'
    */
    public function setChangeFreq($type, $value)
    {
        $value = $this->checkChangeFreq($value);

        if ($value != '') {
            $this->_change_freqs[$type] = $value;
        }
    }

    /**
    * Return the value of change frequency
    *
    * @param   string  $type   'article', 'staticpages', ...
    * @return  string          any of 'always', 'hourly', 'daily', 'weekly',
    *                          'monthly', 'yearly', 'never', ''
    */
    public function getChangeFreq($type)
    {
        return isset($this->_change_freqs[$type]) ? $this->_change_freqs[$type] : '';
    }

    /**
    * Set the types of content
    *
    * NOTE: $types parameter is not checked to handle a case where
    *       a plugins is being enabled/disabled, i.e., when you can't
    *       depend on $_PLUGINS.
    *
    * @param   mixed   $types (string or array of string): 'article', ...
    */
    public function setTypes($types)
    {
        $this->_types = array_unique($types);
    }

    /**
    * Get the types of content
    *
    * @return  array    array of strings of types: 'article', 'staticpages', ...
    */
    public function getTypes()
    {
        return $this->_types;
    }

    /**
    * Normalize a URL
    *
    * @param   string   $url    URL to normalize
    * @return  string           a normalized URL
    */
    private function _normalizeURL($url)
    {
        static $encoding = null;

        if ($encoding === null) {
            $encoding = $this->getEncoding();
        }

        $url = str_replace(
            array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
            array(   '<',    '>',     '&',      '"',      "'"),
            $url
        );

        return @htmlspecialchars($url, ENT_QUOTES, $encoding);
    }

    /**
    * Return a string expression of the server time zone
    *
    * @return           mixed  '(+|-)\d\d:\d\d' or FALSE
    * @see              PEAR Date/TimeZone.php
    */
    private function _getTimezoneStr()
    {
        global $_CONF;

        static $retval = NULL;

        if ($retval === NULL) {
            if (isset($_CONF['timezone'])) {
                $timezone = $_CONF['timezone'];
                require_once 'Date/TimeZone.php';

                if (array_key_exists($timezone, $GLOBALS['_DATE_TIMEZONE_DATA'])) {
                    $offset = $GLOBALS['_DATE_TIMEZONE_DATA'][$timezone]['offset'];

                    if ($offset >= 0) {
                        $retval = '+';
                    } else {
                        $retval = '-';
                        $offset = - $offset;
                    }

                    $hour = floor($offset / 3600000);
                    $min  = ($offset - 3600000 * $hour) % 60000;
                    $retval .= sprintf('%02d:%02d', $hour, $min);
                } else {
                    COM_errorLog(__METHOD__ . ': $_CONF[\'timezone\'] is wrong: ' . $_CONF['timezone']);
                    $retval = false;
                }
            } else {
                $retval = false;
            }
        }

        return $retval;
    }

    /**
    * Convert the encoding of a string to utf-8
    *
    * NOTE: This method is not used currently.
    *
    * @param   string         $str    to encode
    * @param   string $from_encoding  source encoding
    * @return                 string
    */
    private function _toUtf8($str, $from_encoding = '')
    {
        if ($from_encoding == '') {
            $from_encoding = $this->_encoding;
        }

        if ($from_encoding != '') {
            if (is_callable('mb_convert_encoding')) {
                $str = mb_convert_encoding($str, 'utf-8', $from_encoding);
            } else if (is_callable('iconv')) {
                $str = iconv($from_encoding, 'utf-8', $str);
            } else if (is_callable('utf8_encode')) {
                $str = utf8_encode($str);
            } else {
                COM_errorLog(__METHOD__ .  ': No way to convert encoding to utf-8.');
            }
        }

        return $str;
    }

    /**
    * Write the sitemap into a file
    *
    * @param   string     $filename the name of the sitemap file
    * @param   string     $sitemap  the content of the sitemap
    * @return  boolean              TRUE = success, FALSE = otherwise
    */
    protected function _write($filename, $sitemap)
    {
        $retval = false;

        if (!@touch($filename)) {
            COM_errorLog(__METHOD__ . ': Cannot write into the sitemap file: ' . $filename);
            return $retval;
        }

        // If file name is '*.gz', then we use Zlib functions
        $parts = pathinfo($filename);

        if (isset($parts['extension']) &&
                (strtolower($parts['extension']) === 'gz') &&
                is_callable('gzopen')) {
            // Save as a gzipped file
            $gp = @gzopen($filename, 'r+b');

            if ($gp === false) {
                COM_errorLog(__METHOD__ . ': Cannot create the sitemap file: ' . $filename);
            } else {
                if (flock($gp, LOCK_EX)) {
                    ftruncate($gp, 0);
                    gzrewind($gp);
                    gzwrite($gp, $sitemap);
					flock($gp, LOCK_UN);
                    gzclose($gp);
                    $retval = true;
                } else {
                    COM_errorLog(__METHOD__ . ': Cannot lock the sitemap file for writing: '  . $filename);
                }
            }
        } else {
            $fp = @fopen($filename, 'r+b');

            if ($fp === false) {
                COM_errorLog(__METHOD__ . ': Cannot create the sitemap file: ' . $filename);
            } else {
                if (flock($fp, LOCK_EX)) {
                    ftruncate($fp, 0);
                    rewind($fp);
                    fwrite($fp, $sitemap);
					fflush($fp);
					flock($fp, LOCK_UN);
                    fclose($fp);
                    $retval = true;
                } else {
                    COM_errorLog(__METHOD__ . ': Cannot lock the sitemap file for writing: ' . $filename);
                }
            }
        }

        return $retval;
    }

    /**
    * Create the sitemap and save it as a file
    *
    * @return  boolean  TRUE = success, FALSE = otherwise
    */
    public function create()
    {
        global $_XMLSMAP_CONF;

        $this->_num_entries = 0;
        $sitemap = '';
        $types   = $this->getTypes();
        $what    = 'url,date-modified';
        $options = array();

        if (count($types) === 0) {
            COM_errorLog(__METHOD__ . ': No content type is specified.');
            return false;
        }

        foreach ($types as $type) {
            $result = PLG_getItemInfo($type, '*', $what, 1, $options);

            if (is_array($result) && (count($result) > 0)) {
                foreach ($result as $entry) {
                    if (isset($entry['url'])) {
                        $url = $this->_normalizeURL($entry['url']);
                        $sitemap .= '  <url>' . self::LB
                                 .  '    <loc>' . $url . '</loc>' . self::LB;
                    } else {
                        /**
                        * <loc> element is mandatory for the sitemap.  So,
                        * when no url is provided, we simply have to skip
                        * the item silently.
                        */
                        continue;
                    }

                    // The items below are all optional.

                    // Frequency of change
                    $change_freq = $this->getChangeFreq($type);

                    if ($change_freq != '') {
                        $sitemap .= '    <changefreq>' . $change_freq
                                 .  '</changefreq>' . self::LB;
                    }

                    // Time stamp
                    if (isset($entry['date-modified'])) {
                        $date = date('Y-m-d', $entry['date-modified']);

                        // Add the time part for frequently changed items
                        if (in_array($change_freq, array('always', 'hourly', 'daily'))) {
                            $timezone = $this->_getTimezoneStr();

                            if ($timezone !== false) {
                                $date .= 'T' . date('H:i:s', $entry['date-modified'])
                                      .  $timezone;
                            }
                        }
                        
                        if (in_array($type, $_XMLSMAP_CONF['lastmod'])) {
                            $sitemap .= '    <lastmod>' . $date . '</lastmod>' . self::LB;
                        }
                    }

                    // Priority
                    $priority = $this->getPriority($type);

                    if ($priority != 0.5) {
                        $sitemap .= '    <priority>' . (string) $priority
                                 .  '</priority>' . self::LB;
                    }

                    $sitemap .= '  </url>' . self::LB;
                    $this->_num_entries++;
                }
            }
        }

        // Append the header and footer to the sitemap body
        if ($sitemap != '') {
            $sitemap = '<?xml version="1.0" encoding="UTF-8" ?>' . self::LB
                     .  '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . self::LB
                     . $sitemap
                     . '</urlset>' . self::LB;
        } else {
            return true;
        }

        // Check the number of items and the size of the sitemap file
        if ($this->_num_entries > self::MAX_NUM_ENTRIES) {
            COM_errorLog(__METHOD__ . ': The number of items in the sitemap file must be ' . self::MAX_NUM_ENTRIES . ' or smaller.');
            return false;
        } else if (strlen($sitemap) > self::MAX_FILE_SIZE) {
            COM_errorLog(__METHOD__ . ': The size of the sitemap file must be ' . self::MAX_FILE_SIZE . ' bytes or smaller.');
            return false;
        }

        // Write the sitemap into file(s)
        list ($filename, $mobile_filename) = $this->getFileNames();

        if ($filename != '') {
            if (!$this->_write($filename, $sitemap)) {
                return false;
            }
        }

        if ($mobile_filename != '') {
            // Modify the sitemap as Google Mobile Sitemap
            $sitemap = str_replace(
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">',
                $sitemap
            );
            $sitemap = str_replace(
                '  </url>',
                '    <mobile:mobile>' . self::LB . '  </url>',
                $sitemap
            );

            if (!$this->_write($mobile_filename, $sitemap)) {
                return false;
            }
        }

        return true;
    }
    
    /**
    * Sends a ping to search engines
    *
    * @param    array of string    $destinations    an array of search engine
    *                                               types.  Currently supported are
    *                                               'google' and 'bing'.
    * @return   int                the number of successful pings
    */
    public function sendPing(array $destinations)
    {
        global $_CONF, $_TABLES;

        // Checks if arguments are good
        $destinations = array_unique($destinations);
        list ($sitemap, ) = $this->getFileNames();

        if ($sitemap == '') {
            COM_errorLog(__METHOD__ . ': sitemap file name is not specified.');
            return 0;
        } else if (count($destinations) === 0) {
            COM_errorLog(__METHOD__ . ': target URL is not specified.');
            return 0;
        }

        // Checks for the record of previous pings
        $hasRecord = false;
        $sql = "SELECT value FROM {$_TABLES['vars']} WHERE (name = 'xmlsitemap.pings') ";
        $result = DB_query($sql);

        if (($result !== false) && (DB_numRows($result) == 1)) {
            $hasRecord = true;
            list ($A) = DB_fetchArray($result);
            $records  = json_decode($A, true);
        } else {
            $records = array();
        }

        $success = 0;
        $sitemap = $_CONF['site_url'] . '/' . $sitemap;
        require_once 'HTTP/Request.php';

        foreach ($destinations as $dest) {
            $dest = strtolower($dest);

            // Checks if there was a record of a previous ping
            if (isset($records[$dest]) &&
                    ($records[$dest] + self::PING_INTERVAL > time())) {
                continue;
            }

            switch ($dest) {
                case 'google':
                    $url = 'http://www.google.com/webmasters/tools/ping?sitemap='
                         . urlencode($sitemap);
                    break;

                case 'bing':
                    $url = 'http://www.bing.com/ping?sitemap='
                         . urlencode($sitemap);
                    break;

                default:
                    COM_errorLog(__METHOD__ . ': unknown target "' . $dest . '"is specified.');
                    continue;
            }

            // Sends a ping to the API of a search engine
            $req = new HTTP_Request($url);
            $req->setMethod(HTTP_REQUEST_METHOD_GET);
            $req->addHeader('User-Agent', 'Geeklog/' . VERSION);
            $response = $req->sendRequest();

            if (PEAR::isError($response)) {
                COM_errorLog(__METHOD__ . ': HTTP error: ' . $response->getMessage());
            } else if ($req->getResponseCode() != 200) {
                COM_errorLog(__METHOD__ . ': HTTP error code: ' . $req->getResponseCode());
            } else {
                $success++;
                $records[$dest] = time();
            }
        }

        // Writes back a record of pings into database
        $records = json_encode($records);
        $records = DB_escapeString($records);

        if ($hasRecord) {
            $sql = "UPDATE {$_TABLES['vars']} SET value = '{$records}' "
                 . "WHERE (name = 'xmlsitemap.pings') ";
        } else {
            $sql = "INSERT INTO {$_TABLES['vars']} (name, value) "
                 . "VALUES ('xmlsitemap.pings', '{$records}') ";
        }

        if (DB_query($sql) === false) {
            COM_errorLog(__METHOD__ . ': cannot save ping records into database');
        }

        return (count($destinations) === $success);
    }
}   // End of SitemapXML class

?>
