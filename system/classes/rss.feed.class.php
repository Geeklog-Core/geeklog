<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | rss.feed.class.php                                                        |
// |                                                                           |
// | Geeklog class for RSS 0.91 feeds.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT geeklog DOT net                       |
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
//
// $Id: rss.feed.class.php,v 1.1 2003/08/12 21:10:06 dhaun Exp $

/**
* Geeklog RSS 0.91 class
*
* Parts of this code have originally been lifted from phpweblog which is
* licenced under the GPL. It has since been heavily modified.
*
* @author Dirk Haun <dirk AT haun-online DOT de>
* @package net.geeklog.rss
*
*/
class Rss {
    /**
    * @access private
    * @var string
    */
    var $_feedfile = 'geeklog.rdf';

    /**
    * @access private
    * @var string
    */
    var $_feedpath = '';

    /**
    * @access private
    * @var string
    */
    var $_feedurl = '';

    /**
    * @access private
    * @var string
    */
    var $_sitelink = '';

    /**
    * @access private
    * @var string
    */
    var $_feedtitle = '';

    /**
    * @access private
    * @var string
    */
    var $_feeddesc = '';

    /**
    * @access private
    * @var string
    */
    var $_feedlang = 'en-gb';

    /**
    * @access private
    * @var string
    */
    var $_feedencoding = 'UTF-8';

    /**
    * @access private
    * @var int
    */
    var $_feedcontentlen = 0;


    /**
    * Constructor
    *
    * Initializes private variables.
    *
    * @author Dirk Haun <dirk AT haun-online DOT de>
    * @access public
    *
    */
    function Rss ()
    {
        global $_CONF;

        if (!empty ($_CONF['default_charset'])) {
            $this->_feedencoding = $_CONF['default_charset'];
        } else {
            $this->_feedencoding = 'UTF-8';
        }

        if (!empty ($_CONF['rdf_language'])) {
            $this->_feedlang = $_CONF['rdf_language'];
        } else {
            $this->_feedlang = $_CONF['locale'];
        }
    }

    /**
    * Set file name for the RSS feed.
    *
    * @param   string   filename   actual file name, e.g. 'geeklog.rdf'
    *
    * @author Dirk Haun <dirk AT haun-online DOT de>
    * @access public
    *
    */
    function setFeedfile ($filename = '')
    {
        global $_CONF;

        if (!empty ($filename)) {
            $this->_feedfile = $filename;
        } else {
            $pos = strrpos ($_CONF['rdf_file'], '/');
            $this->_feedfile = substr ($_CONF['rdf_file'], $pos + 1);
        }
        $path = $_CONF['rdf_file'];
        $pos = strrpos ($path, '/');
        $path = substr ($path, 0, $pos + 1);
        $this->_feedpath = $path . $this->_feedfile;
        $this->_feedurl = substr_replace ($path, $_CONF['site_url'], 0,
                                          strlen ($_CONF['path_html']) - 1);
    }

    /**
    * Set information for an RSS feed.
    *
    * @param string   link    link to the site where this feed originates
    * @param string   title   (short) title of the feed
    * @param string   desc    (longer) description of the feed
    *
    * @author Dirk Haun <dirk AT haun-online DOT de>
    * @access public
    *
    */
    function setFeedinfo ($link = '', $title = '', $desc = '')
    {
        $this->_sitelink = $link;
        $this->_feedtitle = $title;
        $this->_feeddesc = $desc;
    }

    /**
    * Set formats for an RSS feed.
    *
    * @param int      contentlen    length of the content of an entry
    * @param string   language      feed language, e.g. 'en-gb'
    * @param string   encoding      feed encoding, e.g. 'UTF-8'
    *
    * @author Dirk Haun <dirk AT haun-online DOT de>
    * @access public
    *
    */
    function setFeedformats ($contentlen = 0, $language = '', $encoding = '')
    {
        $this->_feedcontentlen = $contentlen;

        if (!empty ($language)) {
            $this->_feedlang = $language;
        }

        if (!empty ($encoding)) {
            $this->_feedencoding = $encoding;
        }
    }

    /**
    * Format the content of an item
    *
    * @author Dirk Haun <dirk AT haun-online DOT de>
    * @access private
    *
    */
    function _formatContent ($text)
    {
        $storytext = trim (strip_tags ($text));
        $storytext = preg_replace ("/(\015)/", "", $storytext);
        if ($this->_feedcontentlen > 1) {
            if (strlen ($storytext) > $this->_feedcontentlen) {
                $storytext = substr ($storytext, 0, $this->_feedcontentlen - 3)
                           . '...';
            }
        }

        return htmlspecialchars ($storytext);
    }

    /**
    * Write the actual feed file.
    *
    * @author Dirk Haun <dirk AT haun-online DOT de>
    * @access public
    *
    */
    function write ($content)
    {
        global $LANG01;

        if (sizeof ($content) == 0) {
            return false;
        }

        $success = false;

        if ($fd = @fopen ($this->_feedpath, 'w')) {
            fputs ($fd, "<?xml version=\"1.0\" encoding=\"$this->_feedencoding\"?>\n\n");
            // according to <http://feeds.archive.org/validator/>, this
            // shouldn't be used any more ...
            // fputs ($fd, "<!DOCTYPE rss PUBLIC \"-//Netscape Communications//DTD RSS 0.91//EN\"\n \"http://my.netscape.com/publish/formats/rss-0.91.dtd\">\n");

            fputs ($fd, "<rss version=\"0.91\">\n");
            fputs ($fd, "<channel>\n");
            fputs ($fd, '<title>' . htmlspecialchars ($this->_feedtitle)
                        . "</title>\n");
            fputs ($fd, '<link>' . htmlspecialchars ($this->_sitelink)
                        . "</link>\n");
            fputs ($fd, '<description>' . htmlspecialchars ($this->_feeddesc)
                        . "</description>\n");
            fputs ($fd, '<language>' . $this->_feedlang . "</language>\n\n");

            foreach ($content as $entry) {
                $desc = '';
                if ($this->_feedcontentlen > 0) {
                    $desc = '<description>'
                          . $this->_formatContent ($entry['text'])
                          . "</description>\n";
                }
                $title = '<title>' . htmlspecialchars ($entry['title'])
                       . "</title>\n";
                $link = '<link>' . htmlspecialchars ($entry['link'])
                      . "</link>\n";

                fputs ($fd, "<item>\n");
                fputs ($fd, $title);
                fputs ($fd, $link);
                if (!empty ($desc)) {
                    fputs ($fd, $desc);
                }
                fputs ($fd, "</item>\n\n");
            }

            fputs ($fd, "</channel>\n");
            fputs ($fd, "</rss>\n");

            fclose ($fd);

            $success = true;
        } else {
            COM_errorLog ($LANG01[54] . ' ' . $this->_feedpath, 1);
        }

        return $success;
    }
}

?>
