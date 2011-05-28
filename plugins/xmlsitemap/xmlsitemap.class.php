<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | xmlsitemap.class.php                                                      |
// |                                                                           |
// | Google Sitemap Generator classes                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'xmlsitemap.class.php') !== FALSE) {
    die('This file can not be used on its own.');
}

/**
* "linebreak" constant
*/
if (!defined('LB')) {
    define('LB', "\n");
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
    /**
    * Vars
    *
    * @access  private
    */
    var $_num_entries;
    var $_encoding;
    var $_changeFreqs;
    var $_priorities;
    var $_types;
    var $_filename;
    var $_mobile_filename;

    /**
    * Valid expressions for 'changefreq' field.  Should be constants in PHP5
    */
    var $_valid_change_freqs = array('always', 'hourly', 'daily', 'weekly',
            'monthly', 'yearly', 'never');

    /**
    * Constructor
    *
    * @access  public
    * @param   string   $encoding   the encoding of contents
    */
    function SitemapXML($encoding = '')
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
    * @access  public
    * @param   string   $encoding   the encoding of contents
    * @return  void
    */
    function setEncoding($encoding)
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
    * @access  public
    * @return  string   the encoding of contents
    */
    function getEncoding()
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
    * @access  public
    * @param   string   $filename           name of sitemap file
    * @param   string   $mobile_filename    name of mobile sitemap file
    */
    function setFileNames($filename = '', $mobile_filename = '')
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
    * @access  public
    * @return  array    names of the sitemap and mobile sitemap
    */
    function getFileNames()
    {
        return array($this->_filename, $this->_mobile_filename);
    }

    /**
    * Check if a string stands for a valid value of priority
    *
    * @access  public
    * @param   string   $str    a string for a priority
    * @return  float            a valid value or 0.5 (default value)
    */
    function checkPriority($str)
    {
        $v = (float) $str;
        return (($v >= 0.0) AND ($v <= 1.0)) ? $v : 0.5;
    }

    /**
    * Set the priority of the item
    *
    * @access  public
    * @param   string   $type   'article', 'staticpages', ...
    * @param   float    $value  the value of priority
    */
    function setPriority($type, $value)
    {
        $value = $this->checkPriority($value);
        if ($value != 0.5) {
            $this->_priorities[$type] = $value;
        }
    }

    /**
    * Return the value of priority
    *
    * @access  public
    * @param   string  $type   'article', 'staticpages', ...
    * @return  float           0.0..1.0 (default value is 0.5)
    */
    function getPriority($type)
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
    * @access  public
    * @param   string  $str    a string for a frequency
    * @return  string          a valid string or an empty string
    */
    function checkChangeFreq($str)
    {
        $str = strtolower($str);
        return in_array($str, $this->_valid_change_freqs) ? $str : '';
    }

    /**
    * Set the change frequency of the item
    *
    * @access  public
    * @param   string  $type   'article', 'staticpages', ...
    * @param   string  $value  any of 'always', 'hourly', 'daily', 'weekly',
    *                          'monthly', 'yearly', 'never'
    */
    function setChangeFreq($type, $value)
    {
        $value = $this->checkChangeFreq($value);
        if ($value != '') {
            $this->_change_freqs[$type] = $value;
        }
    }

    /**
    * Return the value of change frequency
    *
    * @access  public
    * @param   string  $type   'article', 'staticpages', ...
    * @return  string          any of 'always', 'hourly', 'daily', 'weekly',
    *                          'monthly', 'yearly', 'never', ''
    */
    function getChangeFreq($type)
    {
        if (isset($this->_change_freqs[$type])) {
            return $this->_change_freqs[$type];
        } else {
            return '';
        }
    }

    /**
    * Set the types of content
    *
    * NOTE: $types parameter is not checked to handle a case where
    *       a plugins is being enabled/disabled, i.e., when you can't
    *       depend on $_PLUGINS.
    *
    * @access  public
    * @param   mixed   $types (string or array of string): 'article', ...
    */
    function setTypes($types)
    {
        $this->_types = array_unique($types);
    }

    /**
    * Get the types of content
    *
    * @access  public
    * @return  array    array of strings of types: 'article', 'staticpages', ...
    */
    function getTypes()
    {
        return $this->_types;
    }

    /**
    * Normalize a URL
    *
    * @access  private
    * @param   string   $url    URL to normalize
    * @return  string           a normalized URL
    */
    function _normalizeURL($url)
    {
        static $encoding = NULL;

        if ($encoding === NULL) {
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
    * @access  private
    * @return           mixed  '(+|-)\d\d:\d\d' or FALSE
    * @see              PEAR Date/TimeZone.php
    */
    function _getTimezoneStr()
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
                    COM_errorLog(__CLASS__ . ': $_CONF[\'timezone\'] is wrong: ' . $_CONF['timezone']);
                    $retval = FALSE;
                }
            } else {
                $retval = FALSE;
            }
        }

        return $retval;
    }

    /**
    * Convert the encoding of a string to utf-8
    *
    * NOTE: This method is not used currently.
    *
    * @access  private
    * @param   string         $str    to encode
    * @param   string $from_encoding  source encoding
    * @return                 string
    */
    function _toUtf8($str, $from_encoding = '')
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
                COM_errorLog(__CLASS__ .  ': No way to convert encoding to utf-8.');
            }
        }

        return $str;
    }

    /**
    * Write the sitemap into a file
    *
    * @access  protected
    * @param   string     $filename the name of the sitemap file
    * @param   string     $sitemap  the content of the sitemap
    * @return  boolean              TRUE = success, FALSE = otherwise
    */
    function _write($filename, $sitemap)
    {
        $retval = FALSE;

        if (!@touch($filename)) {
            COM_errorLog(__CLASS__ . ': Cannot write the sitemap file: ' . $filename);
            return $retval;
        }

        // If file name is '*.gz', then we use gz* functions
        $parts = pathinfo($filename);
        if (isset($parts['extension'])
         AND (strtolower($parts['extension']) == 'gz')
         AND is_callable('gzopen')) {
            // Save as a gzipped file
            $gp = gzopen($filename, 'r+b');
            if ($gp === FALSE) {
                COM_errorLog(__CLASS__ . ': Cannot create the sitemap file: ' . $filename);
            } else {
                if (flock($gp, LOCK_EX)) {
                    ftruncate($gp, 0);
                    gzrewind($gp);
                    gzwrite($gp, $sitemap);
                    gzclose($gp);
                    $retval = TRUE;
                } else {
                    COM_errorLog(__CLASS__ . ': Cannot lock the sitemap file for writing: '  . $filename);
                }
            }
        } else {
            $fp = fopen($filename, 'r+b');
            if ($fp === FALSE) {
                COM_errorLog(__CLASS__ . ': Cannot create the sitemap file: ' . $filename);
            } else {
                if (flock($fp, LOCK_EX)) {
                    ftruncate($fp, 0);
                    rewind($fp);
                    fwrite($fp, $sitemap);
                    fclose($fp);
                    $retval = TRUE;
                } else {
                    COM_errorLog(__CLASS__ . ': Cannot lock the sitemap file for writing: ' . $filename);
                }
            }
        }

        return $retval;
    }

    /**
    * Create the sitemap and save it as a file
    *
    * @access  public
    * @return  boolean  TRUE = success, FALSE = otherwise
    */
    function create()
    {
        global $_CONF;

        $this->_num_entries = 0;
        $sitemap = '';
        $types   = $this->getTypes();
        $what    = 'url,date-modified';
        $options = array();
        if (count($types) == 0) {
            COM_errorLog(__CLASS__ . ': No content type is specified.');
            return FALSE;
        }

        foreach ($types as $type) {
            $result = PLG_getItemInfo($type, '*', $what, 1, $options);

            if (is_array($result) AND (count($result) > 0)) {
                foreach ($result as $entry) {
                    if (isset($entry['url'])) {
                        $url = $this->_normalizeURL($entry['url']);
                        $sitemap .= '  <url>' . LB
                                 .  '    <loc>' . $url . '</loc>' . LB;
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
                                 .  '</changefreq>' . LB;
                    }

                    // Time stamp
                    if (isset($entry['date-modified'])) {
                        $date = date('Y-m-d', $entry['date-modified']);

                        // Add the time part for frequently changed items
                        if (in_array($change_freq, array('always', 'hourly', 'daily'))) {
                            $timezone = $this->_getTimezoneStr();
                            if ($timezone !== FALSE) {
                                $date .= 'T' . date('H:i:s', $entry['date-modified'])
                                      .  $timezone;
                            }
                        }
                        $sitemap .= '    <lastmod>' . $date . '</lastmod>' . LB;
                    }

                    // Priority
                    $priority = $this->getPriority($type);
                    if ($priority != 0.5) {
                        $sitemap .= '    <priority>' . (string) $priority
                                 .  '</priority>' . LB;
                    }

                    $sitemap .= '  </url>' . LB;
                    $this->_num_entries ++;
                }
            }
        }

        // Append the header and footer to the sitemap body
        if ($sitemap != '') {
            $sitemap = '<?xml version="1.0" encoding="UTF-8" ?>' . LB
                     .  '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . LB
                     . $sitemap
                     . '</urlset>' . LB;
        } else {
            return TRUE;
        }

        // Check the number of items and the size of the sitemap file
        if ($this->_num_entries > 50000) {
            COM_errorLog(__CLASS__ . ': The number of items in the sitemap file must be 50,000 or smaller.');
            return FALSE;
        } else if (strlen($sitemap) > 10485760) {
            COM_errorLog(__CLASS__ . ': The size of the sitemap file must be 1048,5760 bytes (= 1MB) or smaller.');
            return FALSE;
        }

        // Write the sitemap into file(s)
        list($filename, $mobile_filename) = $this->getFileNames();
        if ($filename != '') {
            if (!$this->_write($filename, $sitemap)) {
                return FALSE;
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
                '    <mobile:mobile>' . LB . '  </url>',
                $sitemap
            );

            if (!$this->_write($mobile_filename, $sitemap)) {
                return FALSE;
            }
        }

        return TRUE;
    }
}   // End of SitemapXML class

?>
