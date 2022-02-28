<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | xmlsitemap.class.php                                                      |
// |                                                                           |
// | Google Sitemap Generator class                                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2020 by the following authors:                         |
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
 * Sitemap Generator class
 *
 * @package XMLSitemap
 */

/**
 * This is the built-in Geeklog class for creating an XML sitemap.
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
class XMLSitemap
{
    // Constants
    const MAX_NUM_ENTRIES = 50000;
    const MAX_FILE_SIZE = 10485760;   // 1MB
    const DEFAULT_PRIORITY = 0.5;
    const PING_INTERVAL = 3600;       // 1 hour
    const LB = "\n";

    // Sitemap types
    const TYPE_REGULAR = 1;     // Regular sitemap
    const TYPE_MOBILE = 2;      // Mobile sitemap
    const TYPE_NEWS = 3;        // News Sitemap
    
    /**
     * @var string
     */
    private $encoding;

    /**
     * @var array
     */
    private $changeFrequencies = [];

    /**
     * @var array
     */
    private $priorities = [];

    /**
     * @var array
     */
    private $types = [];

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $mobileFilename;

    /**
     * @var string
     */
    private $newsFilename;

    /**
     * @var array
     */
    private $newsTopics = [];

    /**
     * @var int
     */
    private $newsAge = 2 * 24 * 3600;  // 2 days

    /**
     * @var bool
     */
    private $updating = false;

    /**
     * @var array
     */
    private $items = [];

    // Valid expressions for 'changeFrequencies' field
    private $validChangeFrequencies = [
        'always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never',
    ];

    /**
     * Constructor
     *
     * @param  string  $encoding  the encoding of contents
     */
    public function __construct($encoding)
    {
        $this->setEncoding($encoding);

        // Set only 'article' as default value
        $this->setTypes(['article']);
    }

    /**
     * Set the encoding of contents
     *
     * @param  string  $encoding  the encoding of contents
     */
    public function setEncoding($encoding)
    {
        if ($encoding == '') {
            $encoding = COM_getCharset();
        }
        if ($encoding == '') {  // This is very unlikely
            $encoding = 'iso-8859-1';
        }

        $this->encoding = $encoding;
    }

    /**
     * Set the name(s) of the sitemap file (and optionally the mobile
     * sitemap file)
     *
     * NOTE:    Sitemap files must be located in the top directory of the site,
     *          i.e., the same directory as "lib-common.php".
     *
     * @param  string  $filename         name of sitemap file
     * @param  string  $mobile_filename  name of mobile sitemap file
     * @param  string  $news_filename    name of news sitemap file
     */
    public function setFileNames($filename = '', $mobile_filename = '', $news_filename = '')
    {
        global $_CONF;

        if (!empty($filename)) {
            $this->filename = $_CONF['path_html'] . basename($filename);
        }

        if (!empty($mobile_filename)) {
            $this->mobileFilename = $_CONF['path_html'] . basename($mobile_filename);
        }

        if (!empty($news_filename)) {
            $this->newsFilename = $_CONF['path_html'] . basename($news_filename);
        }
    }

    /**
     * Return the names of sitemap files
     *
     * @return  array    names of the sitemap, mobile sitemap, and news sitemap
     */
    public function getFileNames()
    {
        return [$this->filename, $this->mobileFilename, $this->newsFilename];
    }

    /**
     * Check if a string stands for a valid value of priority
     *
     * @param  string  $str  a string for a priority
     * @return float         a valid value or 0.5 (default value)
     */
    public function checkPriority($str)
    {
        $v = (float) $str;

        return (($v >= 0.0) && ($v <= 1.0)) ? $v : self::DEFAULT_PRIORITY;
    }

    /**
     * Set the priority of the item
     *
     * @param  string  $type   'article', 'staticpages', ...
     * @param  float   $value  the value of priority
     */
    public function setPriority($type, $value)
    {
        $value = $this->checkPriority($value);

        if ($value != self::DEFAULT_PRIORITY) {
            $this->priorities[$type] = $value;
        }
    }

    /**
     * Return the value of priority
     *
     * @param  string  $type  'article', 'staticpages', ...
     * @return float           0.0..1.0 (default value is 0.5)
     */
    public function getPriority($type)
    {
        return isset($this->priorities[$type])
            ? (float) $this->priorities[$type]
            : self::DEFAULT_PRIORITY;
    }

    /**
     * Check if a string stands for a proper frequency
     *
     * @param  string  $str  a string for a frequency
     * @return string        a valid string or an empty string
     */
    public function checkChangeFrequency($str)
    {
        $str = strtolower($str);

        return in_array($str, $this->validChangeFrequencies) ? $str : '';
    }

    /**
     * Set the change frequency of the item
     *
     * @param  string  $type   'article', 'staticpages', ...
     * @param  string  $value  any of 'always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'
     */
    public function setChangeFrequency($type, $value)
    {
        $value = $this->checkChangeFrequency($value);

        if ($value != '') {
            $this->changeFrequencies[$type] = $value;
        }
    }

    /**
     * Return the value of change frequency
     *
     * @param  string  $type  'article', 'staticpages', ...
     * @return string         any of 'always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never', ''
     */
    public function getChangeFrequency($type)
    {
        return isset($this->changeFrequencies[$type]) ? $this->changeFrequencies[$type] : '';
    }

    /**
     * Set the types of content
     *
     * NOTE: $types parameter is not checked to handle a case where
     *       a plugins is being enabled/disabled, i.e., when you can't
     *       depend on $_PLUGINS.
     *
     * @param  array  $types  (string or array of string): 'article', ...
     */
    public function setTypes(array $types)
    {
        $this->types = array_unique($types);
    }

    /**
     * Get the types of content
     *
     * @return  array  array of string: 'article', 'staticpages', ...
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Set the topics for news
     *
     * @param  array  $topics  array of string: 'topicid1', ...
     */
    public function setNewsTopics($topics)
    {
        $this->newsTopics = array_unique($topics);
    }

    /**
     * Get the topics for news
     *
     * @return  array    array of strings of topics: 'topicid1', 'topicid2', ...
     */
    public function getNewsTopics()
    {
        return $this->newsTopics;
    }

    /**
     * Set the max age for news
     *
     * @param  int  max age of news articles in seconds
     */
    public function setNewsAge($MaxAge)
    {
        $this->newsAge = intval($MaxAge);
    }

    /**
     * Get the max age for news
     *
     * @return  int  max age of news articles in seconds
     */
    public function getNewsAge()
    {
        return $this->newsAge;
    }

    /**
     * Normalize a URL
     *
     * @param  string  $url  URL to normalize
     * @return string        a normalized URL
     */
    private function normalizeURL($url)
    {
        static $needConversion = null;

        if ($needConversion === null) {
            $needConversion = (strcasecmp($this->encoding, 'utf-8') !== 0);
        }

        if ($needConversion) {
            $url = $this->toUtf8($url);
        }

        $url = str_replace(
            ['&lt;', '&gt;', '&amp;', '&quot;', '&#039;'],
            ['<', '>', '&', '"', "'"],
            $url
        );

        return htmlspecialchars($url, ENT_QUOTES, 'utf-8');
    }

    /**
     * Return a string expression of the server time zone
     *
     * @return string '(+|-)\d\d:\d\d' or '' in case no valid timezone is set
     */
    private function getTimezoneStr()
    {
        global $_CONF;

        static $retval = null;

        if ($retval === null) {
            if (isset($_CONF['timezone'])) {
                try {
                    $now = new DateTime('now', new DateTimeZone($_CONF['timezone']));
                    $offset = $now->getOffset();

                    if ($offset >= 0) {
                        $retval = '+';
                    } else {
                        $retval = '-';
                        $offset = -$offset;
                    }

                    $hour = floor($offset / 3600);
                    $min = ($offset - 3600 * $hour) % 60;
                    $retval .= sprintf('%02d:%02d', $hour, $min);
                } catch (Exception $e) {
                    COM_errorLog(__METHOD__ . ': invalid timezone name was given');
                    $retval = '';
                }
            } else {
                $retval = '';
            }
        }

        return $retval;
    }

    /**
     * Convert the encoding of a string to utf-8
     *
     * @param  string  $str
     * @return string
     */
    private function toUtf8($str)
    {
        if (is_callable('mb_convert_encoding')) {
            $str = mb_convert_encoding($str, 'utf-8', $this->encoding);
        } elseif (is_callable('iconv')) {
            $str = iconv($this->encoding, 'utf-8', $str);
        } elseif (is_callable('utf8_encode')) {
            $str = utf8_encode($str);
        } else {
            COM_errorLog(__METHOD__ . ': No way to convert encoding to utf-8.');
        }

        return $str;
    }

    /**
     * Write a sitemap into a file
     *
     * @param  string  $filename  the name of the sitemap file
     * @param  string  $sitemap   the content of the sitemap
     * @return bool               true = success, false = otherwise
     */
    protected function write($filename, $sitemap)
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
                    COM_errorLog(__METHOD__ . ': Cannot lock the sitemap file for writing: ' . $filename);
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
     * Format an item
     *
	 * @param  int     $type   sitemap type: one of XMLSitemap::TYPE_REGULAR or XMLSitemap::TYPE_MOBILE
     * @param  string  $url
     * @param  int     $lastModified
     * @param  float   $priority
     * @param  string  $frequency
     * @return string
     */
    protected function formatItem($type, $url, $lastModified = null, $priority = null, $frequency = null)
    {
        static $timezone = null;

        if ($timezone === null) {
            $timezone = $this->getTimezoneStr();
        }

        if (empty($url)) {
            return '';
        }

        // URL
        $retval = '  <url>' . self::LB
            . '    <loc>' . $this->normalizeURL($url) . '</loc>' . self::LB;

        // Last modified time
        if (!empty($lastModified)) {
            if (!empty($timezone)) {
				$date = date('c', $lastModified); // Want date format for time zone like 2012-11-28T10:53:17+01:00
            } else {
				$date = date('Y-m-d', $lastModified);
			}

            $retval .= '    <lastmod>' . $date . '</lastmod>' . self::LB;
        }

        // Priority
        if (!empty($priority) && ($priority != self::DEFAULT_PRIORITY)) {
            $retval .= '    <priority>' . (string) $priority
                . '</priority>' . self::LB;
        }

        // Frequency of change
        if (!empty($frequency)) {
            $retval .= '    <changefreq>' . $frequency
                . '</changefreq>' . self::LB;
        }
		
        // Mobile Sitemap
        if ($type == self::TYPE_MOBILE) {
            $retval .= '    <mobile:mobile />' . self::LB;
        }

        $retval .= '  </url>' . self::LB;

        return $retval;
    }

    /**
     * Escape special characters not allowed in XML
     *
     * @param  string  $str
     * @return string
     */
    protected function escapeString($str)
    {
        return COM_escHTML($str, ENT_QUOTES | ENT_SUBSTITUTE | ENT_XML1);
    }

    /**
     * Format an entry for news sitemap
     *
     * @param  array   $entry
     * @param  string  $site_lang_id
     * @param  bool    $multi_lang
     * @return string
     */
    protected function formatEntryForNewsSitemap(array $entry, $site_lang_id, $multi_lang)
    {
        global $_CONF;

        static $timezone = null;

        if ($timezone === null) {
            $timezone = $this->getTimezoneStr();
        }
		
        // Check URL, date is under max age, and appropriate topics
        if (empty($entry['url']) || ((int) $entry['date-created'] < time() - $this->getNewsAge())) {
            // <loc> element is mandatory for the sitemap.  So, when no url is provided, or the entry is too old,
            // we simply have to skip the item silently.
            return '';
        }

        $url = $this->normalizeURL($entry['url']);
        $retval = '  <url>' . self::LB
            . '    <loc>' . $url . '</loc>' . self::LB;

        // Start News Specific tags
        $retval .= '    <news:news>' . self::LB;

        // Publication
        $retval .= '      <news:publication>' . self::LB;
        $retval .= '        <news:name>' . $this->escapeString($_CONF['site_name']) . '</news:name>' . self::LB;

        // Language
        if ($multi_lang) {
            $lang_id = COM_getLanguageIdForObject($entry['id']);
            if (empty($lang_id)) {
                // if no lang id then assume site default lang
                $lang_id = $site_lang_id;
            }
        } else {
            $lang_id = $site_lang_id;
        }
        $retval .= '        <news:language>' . $lang_id . '</news:language>' . self::LB;
        $retval .= '      </news:publication>' . self::LB;

        // Time stamp
        $date = date('Y-m-d', $entry['date-created']);
        if (!empty($timezone)) {
            $date .= 'T' . date('H:i:s', $entry['date-created']) . $timezone;
        }
        $retval .= '      <news:publication_date>' . $date . '</news:publication_date>' . self::LB;

        // Title
        $retval .= '      <news:title>' . $this->escapeString($entry['title']) . '</news:title>' . self::LB;
        $retval .= '    </news:news>' . self::LB;
        $retval .= '  </url>' . self::LB;

        return $retval;
    }

    /**
     * Create the sitemap and save it into files
     *
     * @return  bool  true on success, false otherwise
     */
    public function create()
    {
        global $_XMLSMAP_CONF, $_CONF, $LANG_ISO639_1;

        // Get file names
        list ($filename, $mobile_filename, $news_filename) = $this->getFileNames();

        if (!empty($filename) || !empty($mobile_filename)) {
            $numEntries = 0;
            $sitemap = '';
            $types = $this->getTypes();
            $what = 'url,date-modified';
            $uid = 1;   // anonymous user
            $limit = 0;   // the max number of items to be returned (0 = no limit)
            $options = [];

            if (count($types) === 0) {
                COM_errorLog(__METHOD__ . ': No content type is specified.');

                return false;
            }

            // Prepend the homepage (feature #997)
            if (isset($_XMLSMAP_CONF['include_homepage']) && $_XMLSMAP_CONF['include_homepage']) {
                $sitemap .= $this->formatItem(self::TYPE_REGULAR, $_CONF['site_url']);
            }

            foreach ($types as $type) {
                // New API since GL-2.1.1
                $result = PLG_collectSitemapItems($type, $uid, $limit);

                if (!is_array($result) || (count($result) === 0)) {
                    // Only call if plugin doesn't have a function for PLG_collectSitemapItems as an empty result from PLG_collectSitemapItems could be possible depending on user permissions for plugin items
                    if (!function_exists('plugin_collectSitemapItems_' . $type)) {
                        $result = PLG_getItemInfo($type, '*', $what, $uid, $options);
                    }
                }

                if (is_array($result) && (count($result) > 0)) {
                    foreach ($result as $entry) {
                        if (empty($entry['url'])) {
                            // When no url is provided, we simply have to skip the item silently.
                            continue;
                        }

                        $url = $entry['url'];

                        // Frequency of change
                        $frequency = isset($entry['change-freq'])
                            ? $entry['change-freq']
                            : $this->getChangeFrequency($type);

                        // Last modified time stamp
                        $lastModified = (isset($entry['date-modified']) && in_array($type, $_XMLSMAP_CONF['lastmod']))
                            ? $entry['date-modified']
                            : null;

                        // Priority
                        $priority = isset($entry['priority'])
                            ? $entry['priority']
                            : $this->getPriority($type);

                        $sitemap .= $this->formatItem(self::TYPE_REGULAR, $url, $lastModified, $priority, $frequency);
                        $numEntries++;
                    }
                }
            }

            // Write the sitemap into file(s)

            // Append the header and footer to the sitemap body
            if ($sitemap != '') {
                $sitemap = '<?xml version="1.0" encoding="UTF-8" ?>' . self::LB
                    . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . self::LB
                    . $sitemap
                    . '</urlset>' . self::LB;

                // Check the number of items and the size of the sitemap file
                if ($numEntries > self::MAX_NUM_ENTRIES) {
                    COM_errorLog(__METHOD__ . ': The number of items in the sitemap file must be ' . self::MAX_NUM_ENTRIES . ' or smaller.');

                    return false;
                } elseif (strlen($sitemap) > self::MAX_FILE_SIZE) {
                    COM_errorLog(__METHOD__ . ': The size of the sitemap file must be ' . self::MAX_FILE_SIZE . ' bytes or smaller.');

                    return false;
                }

                if ($filename != '') {
                    if (!$this->write($filename, $sitemap)) {
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
					
					// Convert regular sitemap now to mobile 
                    $sitemap = str_replace(
                        '  </url>',
                        '    <mobile:mobile />' . self::LB . '  </url>',
                        $sitemap
                    );

                    if (!$this->write($mobile_filename, $sitemap)) {
                        return false;
                    }
                }
            }
        }

        // Get News Sitemap
        if ($news_filename != '') {
            $numEntries = 0;
            $sitemap = '';
            $what = 'url,date-created,id,title';
            $uid = 1;   // anonymous user
            $limit = 0;   // the max number of items to be returned (0 = no limit)
            $options = [];

            // Figure out language id
            $multi_lang = COM_isMultiLanguageEnabled();
            if ($multi_lang) {
                // default language for multi language site
                $site_lang_id = COM_getLanguageId();
            } else {
                // Just one default language
                $site_lang_id = $LANG_ISO639_1;
            }

            // Retrieve complete topic list including inherited ones
            $topic_list = '';
            $newstopics = $this->getNewsTopics();

            if (!empty($newstopics)) {
                foreach ($newstopics as $tid) {
                    $tids = TOPIC_getChildList($tid, $uid);
                    if (!empty($tids)) {
                        if (!empty($topic_list)) {
                            $topic_list = $topic_list . "," . $tids;
                        } else {
                            $topic_list = $tids;
                        }
                    }
                }
            }
            if (!empty($topic_list)) {
                $options['filter']['topic-ids'] = $topic_list;
            }

            // Figure out max age
            if ($this->getNewsAge() > 0) {
                $options['filter']['date-created'] = strtotime("-" . $this->getNewsAge() . " seconds");
            }

            $result = PLG_getItemInfo('article', '*', $what, $uid, $options);

            if (is_array($result) && (count($result) > 0)) {
                foreach ($result as $entry) {
                    $sitemap .= $this->formatEntryForNewsSitemap($entry, $site_lang_id, $multi_lang);
                    $numEntries++;
                }
            }

            // Append the header and footer to the sitemap body even if sitemap contains no info
            $sitemap = '<?xml version="1.0" encoding="UTF-8" ?>' . self::LB
                . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . self::LB
                . $sitemap
                . '</urlset>' . self::LB;

            // Check the number of items and the size of the sitemap file
            if ($numEntries > self::MAX_NUM_ENTRIES) {
                COM_errorLog(__METHOD__ . ': The number of items in the sitemap file must be ' . self::MAX_NUM_ENTRIES . ' or smaller.');

                return false;
            } elseif (strlen($sitemap) > self::MAX_FILE_SIZE) {
                COM_errorLog(__METHOD__ . ': The size of the sitemap file must be ' . self::MAX_FILE_SIZE . ' bytes or smaller.');

                return false;
            }

            if (!$this->write($news_filename, $sitemap)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Set updating flag to true and empty the queue
     */
    public function beginUpdate()
    {
        $this->updating = true;
        $this->items = [];
    }

    /**
     * Add  to the queue an item to add to sitemap files
     *
     * @param  string  $type          item type, e.g. 'article'
     * @param  string  $id
     * @param  string  $url
     * @param  int     $dateModified
     * @param  int     $dateCreated
     * @param  string  $title
     * @param  float   $priority
     * @param  string  $frequency
     * @return void
     */
    public function addItem($type, $id, $url, $dateModified = null, $dateCreated = null, $title = null, $priority = null, $frequency = null)
    {
        if ($this->updating && !empty($url)) {
            $this->items[] = [
                '+', [
                    'type'          => $type,
                    'id'            => $id,
                    'url'           => $url,
                    'date-modified' => $dateModified,
                    'date-created'  => $dateCreated,
                    'title'         => $title,
                    'priority'      => $priority,
                    'frequency'     => $frequency,
                ]
            ];
        }
    }

    /**
     * Add to the queue an item to delete from sitemap files
     *
     * @param  string  $type  item type, e.g. 'article'
     * @param  string  $url
     * @return void
     */
    public function deleteItem($type, $url)
    {
        if ($this->updating && !empty($url)) {
            $this->items[] = [
                '-', [
                    'type' => $type,
                    'url'  => $url,
                ]
            ];
        }
    }

    /**
     * Return if the entry is valid as a news sitemap item
     *
     * @param  array  $entry
     * @return bool
     */
    protected function isValidNewsItem(array $entry)
    {
        if ($entry['type'] === 'article') {
            //return false;
        }

        $what = 'url,date-created,id,title';
        $uid = 1;   // anonymous user
        $options = [];



		// Retrieve complete topic list including inherited ones
		$topic_list = '';
		$newstopics = $this->getNewsTopics();

		if (!empty($newstopics)) {
			foreach ($newstopics as $tid) {
				$tids = TOPIC_getChildList($tid, $uid);
				if (!empty($tids)) {
					if (!empty($topic_list)) {
						$topic_list = $topic_list . "," . $tids;
					} else {
						$topic_list = $tids;
					}
				}
			}
		}
		if (!empty($topic_list)) {
			$options['filter']['topic-ids'] = $topic_list;
		}

        // Figure out max age
        if ($this->getNewsAge() > 0) {
            $options['filter']['date-created'] = strtotime("-{$this->getNewsAge()} seconds");
        }

        $result = PLG_getItemInfo('article', $entry['id'], $what, $uid, $options);

        return is_array($result) && (count($result) > 0);
    }

    /**
     * Patch a sitemap file
     *
     * @param  int     $type   sitemap type: one of XMLSitemap::TYPE_REGULAR, XMLSitemap::TYPE_MOBILE and XMLSitemap::TYPE_NEWS
     * @param  string  $path   full path to the sitemap file
     * @param  array   $items  to add to and/or delete from the sitemap file
     * @return bool            true on success, false otherwise
     */
    protected function patchFile($type, $path, array $items)
    {
        global $LANG_ISO639_1;

        $sitemap = @file_get_contents($path);
        if ($sitemap === false) {
            return false;
        }

        $updated = false;

        // Figure out language id
        $isMultiLang = COM_isMultiLanguageEnabled();
        if ($isMultiLang) {
            // default language for multi language site
            $siteLangId = COM_getLanguageId();
        } else {
            // Just one default language
            $siteLangId = $LANG_ISO639_1;
        }

        foreach ($items as $item) {
            list($action, $data) = $item;

            if ($action === '+') {
                $formattedItem = '';

                if (($type === self::TYPE_REGULAR) || ($type == self::TYPE_MOBILE)) {
                    $formattedItem = $this->formatItem($type, $data['url'], $data['date-modified'], $data['priority'], $data['frequency']);
                } else {
                    // News sitemap
                    if ($this->isValidNewsItem($data)) {
                        $formattedItem = $this->formatEntryForNewsSitemap($data, $siteLangId, $isMultiLang);
                    }
                }

                // Append an item
                if (!empty($formattedItem)) {
                    $pos = strpos($sitemap, '</urlset>');

                    if ($pos !== false) {
                        $sitemap = substr($sitemap, 0, $pos) . $formattedItem . '</urlset>' . self::LB;
                        $updated = true;
                    }
                }
            } elseif ($action === '-') {
                if (($type === self::TYPE_NEWS) && ($data['type'] !== 'article')) {
                    continue;
                }

                // Delete an existing item
				// Note may not even exist in sitemap so let $updated = true anyways even if not found and removed
                $target = '  <url>' . self::LB . '    <loc>' . $this->normalizeURL($data['url']) . '</loc>' . self::LB;
                $pos = strpos($sitemap, $target);

                if ($pos !== false) {
                    $pos2 = strpos($sitemap, '</url>', $pos + strlen($target));

                    if ($pos2 !== false) {
                        $sitemap = substr($sitemap, 0, $pos)
                            . substr($sitemap, $pos2 + strlen('</url>' . self::LB));
                    }
                }
				
				$updated = true;
            }
        }

        return $updated && (@file_put_contents($path, $sitemap) !== false);
    }

    /**
     * Set updating flag to false and modify sitemap files if necessary
     *
     * @return bool  true on success, false otherwise
     */
    public function endUpdate()
    {
        global $_XMLSMAP_CONF;

        $retval = true;
        $this->updating = false;

        if (count($this->items) === 0) {
            return true;
        }

        // Send ping to search engines
        $pingTargets = [];

        if (isset($_XMLSMAP_CONF['ping_google']) && $_XMLSMAP_CONF['ping_google']) {
            $pingTargets[] = 'google';
        }

        // Get file names
        list ($filename, $mobileFilename, $newsFilename) = $this->getFileNames();

        if (!empty($filename)) {
            $retval = $this->patchFile(self::TYPE_REGULAR, $filename, $this->items);

            if ($retval) {
                $this->sendPing($pingTargets, $filename);
            }
        }

        if (!empty($mobileFilename)) {
            $retval = $retval && $this->patchFile(self::TYPE_MOBILE, $mobileFilename, $this->items);

            if ($retval)  {
                $this->sendPing($pingTargets, $mobileFilename);
            }
        }
		
        if (!empty($newsFilename)) {
            $retval = $retval && $this->patchFile(self::TYPE_NEWS, $newsFilename, $this->items);

            if ($retval)  {
                $this->sendPing($pingTargets, $newsFilename);
            }
        }		

        // Empty the queue
        $this->items = [];

        return $retval;
    }

    /**
     * Sends a ping to search engines for the main sitemap only
     *
     * @param  array   $destinations  an array of search engine types.  Currently supported are 'google' and 'bing'.
     * @param  string  $filename      the full path to a sitemap file
     * @return int                    the number of successful pings
     */
    public function sendPing(array $destinations, $filename)
    {
        global $_CONF, $_TABLES;

        $destinations = array_unique($destinations);
        if (COM_isDemoMode() || (count($destinations) === 0)) {
            return 0;
        }

        if (empty($filename)) {
            COM_errorLog(__METHOD__ . ': sitemap file name is not specified.');

            return 0;
        } elseif (preg_match('@\Ahttps?://localhost/@i', $_CONF['site_url'])) {
            // It seems that 'localhost' is not accepted
            return 0;
        }

        // Checks for the record of previous pings
        $hasRecord = false;
        $sql = "SELECT value FROM {$_TABLES['vars']} WHERE (name = 'xmlsitemap.pings') ";
        $result = DB_query($sql);

        if (($result !== false) && (DB_numRows($result) == 1)) {
            $hasRecord = true;
            list ($A) = DB_fetchArray($result);
            $records = json_decode($A, true);
        } else {
            $records = [];
        }

        $success = 0;
        $sitemapUrl = $_CONF['site_url'] . '/' . basename($filename);
        $sitemapUrl = urlencode($sitemapUrl);

        foreach ($destinations as $dest) {
            $dest = strtolower($dest);

            // Checks if there was a record of a previous ping
            if (isset($records[$dest]) &&
                ($records[$dest] + self::PING_INTERVAL > time())) {
                continue;
            }

            switch ($dest) {
                case 'google':
                    $url = 'https://www.google.com/ping?sitemap=' . $sitemapUrl;
                    break;
				
				// See: https://github.com/Geeklog-Core/geeklog/issues/1105
                //case 'bing':
                //    $url = 'https://www.bing.com/ping?sitemap=' . $sitemapUrl;
                //    break;

                default:
                    $url = '';
                    COM_errorLog(__METHOD__ . ': unknown target "' . $dest . '"is specified.');
                    break;
            }

            // Sends a ping to the endpoint of a search engine
            if (!empty($url)) {
                $req = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);

                try {
                    $req->setHeader('User-Agent', 'Geeklog/' . VERSION);
                    $response = $req->send();
                    $status = $response->getStatus();

                    if ($status == 200) {
                        $success++;
                        $records[$dest] = time();
                    } else {
                        COM_errorLog(sprintf('Failed to send a ping to %s: HTTP status %d', $url, $status));
                    }
                } catch (HTTP_Request2_Exception $e) {
                    COM_errorLog(__METHOD__ . ': ' . $e->getMessage());
                }
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
	
    /**
     * Submit a changed URL to IndexNow
     *
     * @param  string  $changedURL    the full URL to the changed page
     * @return int                    if successful or not
     */
    public function submitURL($changedURL)
    {
        global $_CONF, $_XMLSMAP_CONF;

        if (COM_isDemoMode() || !$_XMLSMAP_CONF['indexnow']) {
            return 0;
        }
		
        if (empty($_XMLSMAP_CONF['indexnow_key'])) {
            COM_errorLog(__METHOD__ . ': IndexNow key is not set.');

            return 0;
		}

        if (empty($changedURL)) {
            COM_errorLog(__METHOD__ . ': url is not specified to ping IndexNow with.');

            return 0;
        } elseif (preg_match('@\Ahttps?://localhost/@i', $_CONF['site_url'])) {
            // It seems that 'localhost' is not accepted
            return 0;
        }
		
		$_validator = Validator::getInstance();		
		$ruleParams[] = $changedURL;
		if (!$_validator->dispatchMethod("url", $ruleParams)) {
            COM_errorLog(__METHOD__ . ': url "' . $changedURL . '" is not valid and therefore cannot be used by IndexNow.');

            return 0;
		}
		
		if (!empty($_XMLSMAP_CONF['indexnow_key_location'])) {
			unset($ruleParams);
			$ruleParams[] = $_XMLSMAP_CONF['indexnow_key_location'];
			if (!$_validator->dispatchMethod("url", $ruleParams)) {
				COM_errorLog(__METHOD__ . ': key location is not a valid url and therefore cannot be used with IndexNow.');

				return 0;
			}
			
		}
		
		$success = 0;
		
		// Build url
		$url = 'https://api.indexnow.org/indexnow?url=' . urlencode($changedURL) . '&key=' . $_XMLSMAP_CONF['indexnow_key'];
		if (!empty($_XMLSMAP_CONF['indexnow_key_location'])) {
			$url .= '&keyLocation=' . urlencode($_XMLSMAP_CONF['indexnow_key_location']);
		}

		// Sends a ping to the endpoint of IndexNow
		if (!empty($url)) {
			$req = new HTTP_Request2($url, HTTP_Request2::METHOD_GET);

			try {
				$req->setHeader('User-Agent', 'Geeklog/' . VERSION);
				$response = $req->send();
				$status = $response->getStatus();

				if ($status == 200 || $status == 202) {
					$success++;
				} else {
					COM_errorLog(sprintf('Failed to send a ping to %s: HTTP status %d', $url, $status));
				}
			} catch (HTTP_Request2_Exception $e) {
				COM_errorLog(__METHOD__ . ': ' . $e->getMessage());
			}
		}

        return $success;
    }	
}
