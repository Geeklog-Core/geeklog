<?php

/****************************************************************************/
/* rss.feed.class.php                                                       */
/*                                                                          */
/****************************************************************************/
/* Copyright (c) 2004 Michael Jervis (mike@fuckingbrit.com)                 */
/*                                                                          */
/* This software is licensed under the terms of the ZLIB License:           */
/*                                                                          */
/* This software is provided 'as-is', without any express or implied        */
/* warranty. In no event will the authors be held liable for any damages    */
/* arising from the use of this software.                                   */
/*                                                                          */
/* Permission is granted to anyone to use this software for any purpose,    */
/* including commercial applications, and to alter it and redistribute it   */
/* freely, subject to the following restrictions:                           */
/*                                                                          */
/*  1. The origin of this software must not be misrepresented; you must not */
/*     claim that you wrote the original software. If you use this software */
/*     in a product, an acknowledgment in the product documentation would be*/
/*     appreciated but is not required.                                     */
/*                                                                          */
/*  2. Altered source versions must be plainly marked as such, and must not */
/*     be misrepresented as being the original software.                    */
/*                                                                          */
/*  3. This notice may not be removed or altered from any source            */
/*     distribution.                                                        */
/****************************************************************************/

/**
 * Provides feed handlers for RSS 0.9x and RSS 2.0
 * This library file provides multiple class definitions for dealing with
 * variants of the RSS syndication format. We will <b>not</b> handle RSS 1.0
 * however, that is RDF and handled in a seperate case. This is purely for
 * the original RSS and the 2.0 that was created to deal with the fact
 * that RDF was overkill for the original purpose of RSS.
 *
 * @author  Michael Jervis (mike@fuckingbrit.com)
 * @version 1.0
 */

/**
 * rss20 provides reading and writing of RSS 2.0 format syndication feeds.
 *
 * @author    Michael Jervis (mike@fuckingbrit.com)
 * @copyright Michael Jervis 2004
 * @abstract
 */
class RSS20 extends FeedParserBase
{
    /**
     * Date of feed, for reading only
     */
    private $date;

    /**
     * is the guid element a permalink?
     */
    private $_permaLink;

    /**
     * Have we used GUID for link?
     */
    private $_linkGUID;

    /**
     * RSS20 constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->namespaces = array('xmlns:dc="http://purl.org/dc/elements/1.1/"');
        $this->_linkGUID = false;
    }

    /**
     * Generate an RFC-822 compliant date-time stamp.
     *
     * @param  int $timestamp Date time to format.
     * @return string
     */
    private function _RFC822DateFormat($timestamp = null)
    {
        // format the date
        if (empty($timestamp)) {
            $timestamp = time();
        }

        return date('r', $timestamp);
    }

    /**
     * Format an article into an RSS 2.0 <item> tag.
     * Takes an associative article array and turns it into an XML definition
     * of an article. Uses merely title, link and summary.
     *
     * @param  array $article Associative array describing an article.
     * @return string
     */
    protected function _formatArticle(array $article)
    {
        $xml = '<item>' . self::LB
            . '<title>' . $this->_safeXML($article['title']) . '</title>' . self::LB
            . '<link>' . $this->_safeXML($article['link'], false) . '</link>' . self::LB
            . '<guid isPermaLink="true">'
            . $this->_safeXML($article['link'], false)
            . '</guid>' . self::LB
            . '<pubDate>'
            . $this->_RFC822DateFormat($article['date'])
            . '</pubDate>' . self::LB;

        if (array_key_exists('commenturl', $article)) {
            $xml .= '<comments>'
                . $this->_safeXML($article['commenturl'], false)
                . '</comments>' . self::LB;
        }

        if (array_key_exists('summary', $article) && (strlen($article['summary']) > 0)) {
            $xml .= '<description>'
                . $this->_safeXML($article['summary'])
                . '</description>' . self::LB;
        }

        if (isset($article['extensions']) && is_array($article['extensions'])) {
            $xml .= implode(self::LB, $article['extensions']) . self::LB;
        }

        $xml .= '</item>' . self::LB;

        return $xml;
    }

    /**
     * Return the formatted start of a feed.
     * This will start the xml and create header information about the feed
     * itself.
     *
     * @return string
     */
    protected function _feedHeader()
    {
        global $_CONF;

        $xml = parent::_feedHeader()
            . '<rss version="2.0"' . $this->_injectNamespaces() . '>' . self::LB
            . '<channel>' . self::LB
            . '<title>' . $this->_safeXML($this->title) . '</title>' . self::LB
            . '<link>' . $this->_safeXML($this->sitelink, false) . '</link>' . self::LB;

        if (strlen($this->description) > 0) {
            $xml .= '<description>'
                . $this->_safeXML($this->description)
                . '</description>' . self::LB;
        }

        if (strlen($this->sitecontact) > 0) {
            $xml .= '<managingEditor>'
                . $this->_safeXML($this->sitecontact)
                . ' (' . $_CONF['site_name'] . ')'
                . '</managingEditor>' . self::LB
                . '<webMaster>'
                . $this->_safeXML($this->sitecontact)
                . ' (' . $_CONF['site_name'] . ')'
                . '</webMaster>' . self::LB;
        }

        if (strlen($this->copyright) > 0) {
            $xml .= '<copyright>'
                . $this->_safeXML($this->copyright)
                . '</copyright>' . self::LB;
        }

        if (strlen($this->system) > 0) {
            $xml .= '<generator>'
                . $this->_safeXML($this->system)
                . '</generator>' . self::LB;
        }

        $xml .= '<pubDate>' . $this->_RFC822DateFormat() . '</pubDate>' . self::LB
            . '<language>' . $this->lang . '</language>' . self::LB;

        if (strlen($this->feedlogo) > 0) {
            $xml .= '<image>' . self::LB
                . '<url>' . $this->_safeXML($this->feedlogo, false) . '</url>' . self::LB
                . '<title>' . $this->_safeXML($this->title) . '</title>' . self::LB
                . '<link>' . $this->_safeXML($this->sitelink, false) . '</link>' . self::LB
                . '</image>' . self::LB;
        }

        $xml .= $this->_injectExtendingTags();

        return $xml;
    }

    /**
     * Return the formatted end of a feed.
     * just closes things off nicely.
     *
     * @return string
     */
    protected function _feedFooter()
    {
        return '</channel>' . self::LB . '</rss>' . self::LB;
    }

    /**
     * Handle the begining of an XML element
     * This is called from the parserfactory once the type of data has been
     * determined. Standard XML_PARSER element handler.
     *
     * @author    Michael Jervis (mike@fuckingbrit.com)
     * @copyright Michael Jervis 2004
     * @param  resource $parser
     * @param  string   $name
     * @param  array    $attributes
     */
    public function startElement($parser, $name, $attributes)
    {
        $this->_currentTag = $name;

        if ($name === 'ITEM') {
            $this->_inItem = true;
            $this->_currentItem = array(
                'title'   => '',
                'link'    => '',
                'summary' => '',
                'guid'    => '',
            );
            $this->_permaLink = false;
        } elseif (($name === 'GUID') && array_key_exists('ISPERMALINK', $attributes)) {
            $this->_permaLink = ($attributes['ISPERMALINK'] === 'true');
        } elseif (($name === 'ENCLOSURE') && array_key_exists('URL', $attributes)) {
            // If we have an enclosure with a URL, remember it because this is a podcast
            $this->_currentItem['enclosureurl'] = $attributes['URL'];
        } else {
            $this->_permaLink = false;
        }
    }

    /**
     * Handle the close of an XML element
     * Called by the parser factory during parsing.
     *
     * @param  resource $parser
     * @param  string   $name
     */
    public function endElement($parser, $name)
    {
        if ($name === 'ITEM') {
            $this->_inItem = false;
            $this->articles[] = $this->_currentItem;
        } elseif ($name === 'GUID') {
            if ($this->_permaLink) {
                // if we have a guid that is ALSO a permalink, override link with it
                $this->_currentItem['link'] = $this->_currentItem['guid'];
                $this->_linkGUID = true;
            } elseif (empty($this->_currentItem['link']) &&
                substr($this->_currentItem['guid'], 0, 4) === 'http'
            ) {
                // this is NOT according to spec: if we don't have a link but the
                // guid, despite being non-permanent, starts with http, use it instead
                $this->_currentItem['link'] = $this->_currentItem['guid'];
                $this->_linkGUID = true;
            }
        }

        $this->_currentTag = '';
    }

    /**
     * Handles character data.
     * Called by the parser factory during parsing.
     *
     * @param  resource $parser
     * @param  string   $data
     */
    public function charData($parser, $data)
    {
        if ($this->_inItem) {
            if ($this->_currentTag === 'TITLE') {
                $this->_currentItem['title'] .= $data;
            } elseif ($this->_currentTag === 'LINK') {
                if (!$this->_linkGUID) {
                    $this->_currentItem['link'] .= $data;
                }
            } elseif ($this->_currentTag === 'DESCRIPTION') {
                $this->_currentItem['summary'] .= $data;
            } elseif ($this->_currentTag === 'PUBDATE') {
                $this->_currentItem['date'] = $data;
            } elseif ($this->_currentTag === 'GUID') {
                $this->_currentItem['guid'] .= $data;
            }
        } else {
            if ($this->_currentTag === 'TITLE') {
                $this->title .= $data;
            } elseif ($this->_currentTag === 'LINK') {
                $this->sitelink .= $data;
            } elseif ($this->_currentTag === 'DESCRIPTION') {
                $this->description .= $data;
            } elseif ($this->_currentTag === 'MANAGINGEDITOR') {
                $this->sitecontact .= $data;
            } elseif ($this->_currentTag === 'COPYRIGHT') {
                $this->copyright .= $data;
            } elseif ($this->_currentTag === 'PUBDATE') {
                $this->date .= $data;
            }
        }
    }
}

/**
 * rss0x provides reading and writing of RSS 0.91 format syndication feeds.
 *
 * @author    Michael Jervis (mike@fuckingbrit.com)
 * @copyright Michael Jervis 2004
 * @abstract
 */
class RSS0x extends FeedParserBase
{
    /**
     * Format an article into an RSS 0.91 <item> tag.
     * Takes an associative article array and turns it into an XML definition
     * of an article. Uses merely title, link and summary.
     *
     * @param  array $article Associative array describing an article.
     * @return string
     */
    protected function _formatArticle(array $article)
    {
        $xml = '<item>' . self::LB
            . '<title>' . $this->_safeXML($article['title']) . '</title>' . self::LB
            . '<link>' . $this->_safeXML($article['link'], false) . '</link>' . self::LB;

        if (array_key_exists('summary', $article) && (strlen($article['summary']) > 0)) {
            $xml .= '<description>'
                . $this->_safeXML($article['summary'])
                . '</description>' . self::LB;
        }

        if (is_array($article['extensions'])) {
            $xml .= implode(self::LB, $article['extensions']) . self::LB;
        }

        $xml .= '</item>' . self::LB;

        return $xml;
    }

    /**
     * Return the formatted start of a feed.
     * This will start the xml and create header information about the feed
     * itself.
     *
     * @return string
     */
    protected function _feedHeader()
    {
        $xml = '<?xml version="1.0" encoding="' . $this->encoding . '"?>' . self::LB2
            . '<rss version="0.91"' . $this->_injectNamespaces() . '>' . self::LB . '<channel>' . self::LB
            . '<title>' . $this->_safeXML($this->title) . '</title>' . self::LB
            . '<link>' . $this->_safeXML($this->sitelink, false) . '</link>' . self::LB;

        if (strlen($this->description) > 0) {
            $xml .= '<description>'
                . $this->_safeXML($this->description)
                . '</description>' . self::LB;
        }

        $xml .= '<language>' . $this->lang . '</language>' . self::LB;

        if (strlen($this->feedlogo) > 0) {
            $xml .= '<image>' . self::LB
                . '<url>' . $this->_safeXML($this->feedlogo, false) . '</url>' . self::LB
                . '<title>' . $this->_safeXML($this->title) . '</title>' . self::LB
                . '<link>' . $this->_safeXML($this->sitelink, false) . '</link>' . self::LB
                . '</image>' . self::LB;
        }

        $xml .= $this->_injectExtendingTags();

        return $xml;
    }

    /**
     * Return the formatted end of a feed.
     * just closes things off nicely.
     *
     * @return string
     */
    protected function _feedFooter()
    {
        return '</channel>' . self::LB . '</rss>' . self::LB;
    }

    /**
     * Handle the begining of an XML element
     * This is called from the parser factory once the type of data has been
     * determined. Standard XML_PARSER element handler.
     *
     * @author    Michael Jervis (mike@fuckingbrit.com)
     * @copyright Michael Jervis 2004
     * @param  resource $parser
     * @param  string   $name
     * @param  array    $attributes
     */
    public function startElement($parser, $name, $attributes)
    {
        if ($name === 'ITEM') {
            $this->_inItem = true;
            $this->_currentItem = array(
                'title'   => '',
                'link'    => '',
                'summary' => '',
            );
        }

        $this->_currentTag = $name;
    }

    /**
     * Handle the close of an XML element
     * Called by the parser factory during parsing.
     *
     * @param  resource $parser
     * @param  string   $name
     */
    public function endElement($parser, $name)
    {
        if ($name === 'ITEM') {
            $this->_inItem = false;
            $this->articles[] = $this->_currentItem;
        }

        $this->_currentTag = '';
    }

    /**
     * Handles character data.
     * Called by the parser factory during parsing.
     *
     * @param  resource $parser
     * @param  string   $data
     */
    public function charData($parser, $data)
    {
        if ($this->_inItem) {
            if ($this->_currentTag === 'TITLE') {
                $this->_currentItem['title'] .= $data;
            } elseif ($this->_currentTag === 'LINK') {
                $this->_currentItem['link'] .= $data;
            } elseif ($this->_currentTag === 'DESCRIPTION') {
                $this->_currentItem['summary'] .= $data;
            }
        } else {
            if ($this->_currentTag === 'TITLE') {
                $this->title .= $data;
            } elseif ($this->_currentTag === 'LINK') {
                $this->sitelink .= $data;
            } elseif ($this->_currentTag === 'DESCRIPTION') {
                $this->description .= $data;
            }
        }
    }
}
