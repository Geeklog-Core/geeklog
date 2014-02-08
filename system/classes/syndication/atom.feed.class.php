<?php

/****************************************************************************/
/* atom.feed.class.php                                                      */
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
// $Id: atom.feed.class.php,v 1.14 2008/09/15 08:15:26 dhaun Exp $

/**
* Provides feed handlers for Atom 0.3 and Atom 1.0
*
* @author Michael Jervis (mike@fuckingbrit.com)
* @version 1.1
*/

/**
* atom10 provides reading and writing of Atom 1.0 format syndication feeds.
*
* @author Michael Jervis (mike@fuckingbrit.com)
* @copyright Michael Jervis 2005
* @abstract
*/
class Atom10 extends FeedParserBase
{
    public function __construct()
    {
        parent::__construct();
        $this->namespaces = array('xmlns="http://www.w3.org/2005/Atom"');
    }

    /**
    * Format an article into an Atom 0.3 <entry> tag.
    *
    * Takes an associative article array and turns it into an XML definition
    * of an article. Uses merely title, link and summary.
    *
    * @param array $article Associative array describing an article.
    */
    protected function _formatArticle(array $article)
    {
        $xml = '<entry>' . self::LB
             . '<title type="html">' . $this->_safeXML($article['title']) . '</title>' . self::LB
             . '<link rel="alternate" type="text/html" href="' . $this->_safeXML($article['link'], false) . '"/>' . self::LB
             . '<id>' . $this->_createId($article['link'], $article['date']) . '</id>' . self::LB
             . '<published>' . $this->_RFC3339Date($article['date']) . '</published>' . self::LB
             . '<updated>' . $this->_RFC3339Date($article['date']) . '</updated>' . self::LB;

        if (array_key_exists('author', $article)) {
            $xml .= '<author>' . self::LB
                 .  '<name>' . $this->_safeXML($article['author']) . '</name>' . self::LB
                 . '</author>' . self::LB;
        }

        if (array_key_exists('summary', $article) && !empty($article['summary'])) {
            $xml .= '<content type="html">'
                 .  $this->_safeXML($article['summary'])
                 .  '</content>' . self::LB;
        }

        if (is_array($this->extensions)) {
            $xml .= implode(self::LB, $this->extensions) . self::LB;
        }

        $xml .= '</entry>' . self::LB;

        return $xml;
    }

    protected function _createId($url, $date)
    {
        $start = strpos($url, '/') + 2;
        $end   = strpos($url, '/', $start);
        $tag   = 'tag:' . substr($url, $start, $end - $start)
               . strftime(',%Y-%m-%d', $date) . ':' . substr($url, $end);

        return $tag;
    }

    private function _RFC3339Date($timestamp = '')
    {
        if (empty($timestamp)) {
            $timestamp = time();
        }

        return date(DateTime::ATOM, $timestamp);
    }

    /**
    * Return the formatted start of a feed.
    *
    * This will start the xml and create header information about the feed
    * itself.
    */
    protected function _feedHeader()
    {
        $xml = parent::_feedHeader()
             . '<feed' . $this->_injectNamespaces() . '>' . self::LB
             . '<title type="text">' . $this->_safeXML($this->title) . '</title>' . self::LB
             . '<subtitle type="text">' . $this->_safeXML($this->description) . '</subtitle>' . self::LB
             . '<link rel="self" href="' . $this->_safeXML($this->url, false) . '"/>' . self::LB
             . '<link rel="alternate" type="text/html" href="' . $this->_safeXML($this->sitelink, false) . '/"/>' . self::LB;


        if ($this->feedlogo != '') {
            $xml .= '<logo>' . $this->_safeXML($this->feedlogo) . '</logo>' . self::LB;
        }

        $xml .= '<id>' . $this->_safeXML($this->sitelink, false) . '/</id>' . self::LB
             .  '<updated>' . $this->_RFC3339Date() . '</updated>' . self::LB
             .  '<author>' . self::LB . '<name>' . $this->_safeXML($this->title) . '</name>' . self::LB
             .  '<email>' . $this->_safeXML($this->sitecontact) . '</email>' . self::LB
             .  '</author>' . self::LB
             .  $this->_injectExtendingTags();

        return $xml;
    }

    /**
    * Return the formatted end of a feed.
    *
    * just closes things off nicely.
    */
    protected function _feedFooter()
    {
        return '</feed>' . self::LB;
    }

    /**
    * Handle the begining of an XML element
    *
    * This is called from the parserfactory once the type of data has been
    * determined. Standard XML_PARSER element handler.
    *
    * @author Michael Jervis (mike@fuckingbrit.com)
    * @copyright Michael Jervis 2004
    */
    public function startElement($parser, $name, $attributes)
    {
        if ($name === 'ENTRY') {
            $this->_inItem = true;
            $this->_currentItem = array(
                'title'   => '',
                'link'    => '',
                'summary' => '',
                'date'    => '',
            );
        } else if ($this->_inItem) {
            if ($name === 'LINK') {
                $this->_currentItem['link'] = $attributes['HREF'];
            }
        } else {
            if ($name === 'LINK') {
                $this->sitelink = $attributes['HREF'];
            }
        }

        $this->_currentTag = $name;
    }

    /**
    * Handle the close of an XML element
    *
    * Called by the parserfactory during parsing.
    */
    public function endElement($parser, $name)
    {
        if ($name === 'ENTRY') {
            $this->_inItem = false;
            $this->articles[] = $this->_currentItem;
        }

        $this->_currentTag = '';
    }

    /**
    * Handles character data.
    *
    * Called by the parserfactory during parsing.
    */
    public function charData($parser, $data)
    {
        if ($this->_inItem) {
            if ($this->_currentTag === 'TITLE') {
                $this->_currentItem['title'] .= $data;
            } else if ($this->_currentTag === 'CONTENT') {
                $this->_currentItem['summary'] .= $data;
            } else if ($this->_currentTag === 'UPDATED') {
                $this->_currentItem['date'] = $data;
            } else if ($this->_currentTag === 'PUBLISHED') {
                 $this->_currentItem['date'] = $data;
            }
        } else {
            if ($this->_currentTag === 'TITLE') {
                $this->title .= $data;
            } else if ($this->_currentTag === 'SUBTITLE') {
                $this->description .= $data;
            }
        }
    }
}

/**
* atom03 provides reading and writing of Atom 0.3 format syndication feeds.
*
* @author Michael Jervis (mike@fuckingbrit.com)
* @copyright Michael Jervis 2004
* @abstract
*/
class Atom03 extends Atom10
{
    public function __construct()
    {
        parent::__construct();
        $this->namespaces = array('xmlns="http://purl.org/atom/ns#"');
    }

    /**
    * Format an article into an Atom 0.3 <entry> tag.
    *
    * Takes an associative article array and turns it into an XML definition
    * of an article. Uses merely title, link and summary.
    *
    * @param array $article Associative array describing an article.
    */
    protected function _formatArticle(array $article)
    {
        $xml = '<entry>' . self::LB
             . '<title mode="escaped">'
             . $this->_safeXML($article['title'])
             . '</title>' . self::LB
             . '<link rel="alternate" type="text/html" href="'
             . $this->_safeXML($article['link'], false) . '"/>' . self::LB
             . '<id>' . $this->_safeXML($article['link'], false) . '</id>' . self::LB
             . '<issued>' . $this->_RFC3339Date($article['date']) . '</issued>' . self::LB
             . '<modified>' . $this->_RFC3339Date($article['date']) . '</modified>' . self::LB;

        if (array_key_exists('author', $article)) {
            $xml .= '<author>' . self::LB
                 .  '<name>' . $this->_safeXML($article['author']) . '</name>' . self::LB
                 .  '</author>' . self::LB;
        }

        if (array_key_exists('summary', $article) && !empty($article['summary'])) {
            $xml .= '<content type="text/html" mode="escaped">'
                 .  $this->_safeXML($article['summary'])
                 .  '</content>' . self::LB;
        }

        if (count($this->extensions) > 0) {
            $xml .= implode(self::LB, $this->extensions) . self::LB;
        }

        $xml .= '</entry>' . self::LB;

        return $xml;
    }

    /**
    * Return the formatted start of a feed.
    *
    * This will start the xml and create header information about the feed
    * itself.
    */
    protected function _feedHeader()
    {
        $xml = parent::_feedHeader()
             . '<feed version="0.3" ' . $this->_injectNamespaces() . '>' . self::LB
             . '<title mode="escaped">' . $this->_safeXML($this->title) . '</title>' . self::LB
             . '<tagline mode="escaped">' . $this->_safeXML($this->description) . '</tagline>' . self::LB
             . '<link rel="alternate" type="text/html" href="' . $this->_safeXML($this->sitelink) . '"/>' . self::LB
             . '<modified>' . $this->_RFC3339Date() . '</modified>' . self::LB
             . '<author>' . self::LB . '<name>' . $this->_safeXML($this->title) . '</name>' . self::LB
             . '<email>' . $this->_safeXML($this->sitecontact) . '</email>' . self::LB . '</author>' . self::LB
             . $this->_injectExtendingTags();

        return $xml;
    }

    /**
      * Handles character data.
      *
      * Called by the parserfactory during parsing.
      */
    public function charData($parser, $data)
    {
        if ($this->_inItem) {
            if ($this->_currentTag === 'TITLE') {
                $this->_currentItem['title'] .= $data;
            } else if ($this->_currentTag === 'CONTENT') {
                $this->_currentItem['summary'] .= $data;
            } else if ($this->_currentTag === 'MODIFIED') {
                $this->_currentItem['date'] = $data;
            } else if ($this->_currentTag === 'ISSUED') {
                $this->_currentItem['date'] = $data;
            }
        } else {
            if ($this->_currentTag === 'TITLE') {
                $this->title .= $data;
            } else if ($this->_currentTag === 'TAGLINE') {
                $this->description .= $data;
            }
        }
    }
}

?>
