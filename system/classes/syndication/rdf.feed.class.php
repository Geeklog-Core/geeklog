<?php

/****************************************************************************/
/* rdf.feed.class.php                                                       */
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
* Provides feed handlers for RDF 1.0
*
* @author Michael Jervis (mike@fuckingbrit.com)
* @version 1.0
*/

/**
* RDF provides reading and writing of RDF 1.0 format syndication feeds.
*
* @author Michael Jervis (mike@fuckingbrit.com)
* @copyright Michael Jervis 2004
* @abstract
*/
class RDF extends FeedParserBase
{
    public function __construct()
    {
        parent::__construct();
        $this->namespaces= array(
            'xmlns:dc="http://purl.org/dc/elements/1.1/"',
            'xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"',
            'xmlns="http://purl.org/rss/1.0/"',
            'xmlns:content="http://purl.org/rss/1.0/modules/content/"',
        );
    }

    /**
    * Format an article into an Atom 0.3 <entry> tag.
    *
    * Takes an associative article array and turns it into an XML definition
    * of an article. Uses merely title, link and summary.
    *
    * @param    array    $article    Associative array describing an article.
    */
    protected function _formatArticle(array $article)
    {
        $xml = '<item rdf:about="' . $this->_safeXML($article['link'], false) . '">' . self::LB
             . '<title>' . $this->_safeXML($article['title']) . '</title>' . self::LB
             . '<link>' . $this->_safeXML($article['link'], false) . '</link>' . self::LB;

        if (array_key_exists('author', $article)) {
            $xml .= '<dc:creator>' . $this->_safeXML($article['author']) . '</dc:creator>' . self::LB;
        }

        if (array_key_exists('summary', $article) && (strlen( $article['summary']) > 0)) {
            $xml .= '<content:encoded>'
                 .  $this->_safeXML($article['summary'])
                 .  '</content:encoded>' . self::LB;
        }

        if (is_array($article['extensions'])) {
            $xml .= implode(self::LB, $article['extensions']) . self::LB;
        }

        $xml .= '</item>' . self::LB;

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
             . '<rdf:RDF' . $this->_injectNamespaces() . '>' . self::LB
             . '<channel rdf:about="' . $this->feedlogo . '">' . self::LB
             . '<title>' . $this->_safeXML($this->title) . '</title>' . self::LB
             . '<link>' . $this->_safeXML($this->sitelink, false) . '</link>' . self::LB
             . '<description>'
             . $this->_safeXML($this->description)
             . '</description>' . self::LB
             . '<dc:language>' . $this->lang . '</dc:language>' . self::LB;

        if (strlen($this->feedlogo) > 0) {
            $xml .= '<image rdf:resource="' . $this->_safeXML($this->feedlogo) . '"/>' . self::LB;
        }

        if (strlen($this->sitecontact) > 0) {
            $xml .= '<dc:creator>' . $this->sitecontact . '</dc:creator>' . self::LB;
        }

        $xml .= '<items>' . self::LB . '<rdf:Seq/>' . self::LB . '</items>' . self::LB;

        if (strlen($this->feedlogo) > 0) {
            $xml .= '<image rdf:about="' . $this->feedlogo . '">' . self::LB
                 .  '<url>' . $this->_safeXML($this->feedlogo, false) . '</url>' . self::LB
                 .  '<title>' . $this->_safeXML($this->title) . '</title>' . self::LB
                 .  '<link>' . $this->_safeXML($this->sitelink, false) . '</link>' . self::LB
                 .  '</image>' . self::LB;
        }

        $xml .= $this->_injectExtendingTags()
             .  '</channel>' . self::LB;

        return $xml;
    }

    /**
    * Return the formatted end of a feed.
    *
    * just closes things off nicely.
    */
    protected function _feedFooter()
    {
        return '</rdf:RDF>' . self::LB;
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
    *
    * Called by the parserfactory during parsing.
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
    *
    * Called by the parserfactory during parsing.
    */
    public function charData($parser, $data)
    {
        if ($this->_inItem) {
            if ($this->_currentTag === 'TITLE') {
                $this->_currentItem['title'] .= $data;
            } else if ($this->_currentTag === 'LINK') {
                $this->_currentItem['link'] .= $data;
            } else if ($this->_currentTag === 'CONTENT:ENCODED') {
                $this->_currentItem['summary'] .= $data;
            }
        } else {
            if ($this->_currentTag === 'TITLE') {
                $this->title .= $data;
            } else if ($this->_currentTag === 'LINK') {
                $this->sitelink .= $data;
            } else if ($this->_currentTag === 'DESCRIPTION') {
                $this->description .= $data;
            }
        }
    }
}

?>
