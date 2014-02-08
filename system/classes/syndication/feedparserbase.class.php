<?php

/****************************************************************************/
/* FeedParserBase.class.php                                                 */
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
* FeedParserBase provides an abstract ancestor class for feed parsers.
*
* @author Michael Jervis (mike@fuckingbrit.com)
* @copyright Michael Jervis 2004
* @abstract
*/
abstract class FeedParserBase
{
    const LB  = "\n";
    const LB2 = "\n\n";

    /**
    * An array of items.
    *
    * This holds all the news from the source. This should be an array of
    * associative arrays. Each item will have:
    * title - The title
    * URI - Link to the full story
    * date - The date of the article
    * Optional (pre-defined) items are:
    * summary - Short version of article
    * text - full version
    * author - Who wrote the article
    */
    public $articles;

    /**
    * Encoding tag for the XML declaration
    */
    public $encoding;

    /**
    * Language for the feed
    */
    public $lang;

    /**
    * Title for the feed
    */
    public $title;

    /**
    * The description of the feed
    */
    public $description;

    /**
    * The URL of the feed
    */
    public $url;

    /**
    * URL of the site
    */
    public $sitelink;

    /**
    * Site contact
    */
    public $sitecontact;

    /**
    * copyright tag:
    */
    public $copyright;

    /**
    * system powering the feed
    */
    public $system;

    /**
    * Image to link to the feed.
    */
    public $feedlogo;

    /**
    * Additional namespaces to add.
    */
    public $namespaces;

    /**
    * Additional tags to add.
    */
    public $extensions;

    /**
    * Stuff for parsing XML
    */
    protected $_currentTag;

    /**
    * @var boolean
    */
    protected $_inItem;

    /**
    * @var array
    */
    protected $_currentItem;

    public function __construct()
    {
        $this->encoding     = 'iso-8859-1';
        $this->title        = 'Killer Feed System Feed';
        $this->lang         = 'en-gb';
        $this->namespaces   = array();
        $this->extensions   = array();
        $this->articles     = array();
        $this->currentTag   = '';
        $this->_inItem      = false;
        $this->_currentItem = array();
    }

    /**
    * Make sure a string is safe to be chardata in an xml element
    *
    * @param    string     $string          the string to escape.
    * @param    boolean    $doubleEncode    whether to encode HTML entities
    */
    protected function _safeXML($string, $doubleEncode = true)
    {
        $retval = @htmlspecialchars($string, ENT_QUOTES, $this->encoding);

        if (!$doubleEncode) {
            $retval = str_replace('&amp;amp;', '&amp;', $retval);
        }

        return $retval;
    }

    protected function _writeFile($fileName, $data)
    {
        if (($fp = @fopen($fileName, 'w')) !== false) {
            fputs($fp, $data);
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }

    /**
    * Create a file for the stream
    *
    * Writes the $items content to the file supplied in the format we have
    * specified. Uses the (abstract) function formatArticle to return XML
    * for an article.
    *
    * @param    string    $fileName    The fully qualified path to the file to create.
    * @param    int       $limit       (optional) max number of items to write.
    */
    public function createFeed($fileName, $limit = '')
    {
        // Start the XML Feed formating
        $xml = $this->_feedHeader();

        // Start with a limit of the size of the array, then, if we have a
        // specific max length use that unless it's bigger than our count
        $count = count($this->articles);

        if ($limit && ($limit < $count)) {
            $count = $limit;
        }

        // Put the first $count items into the xml, using formatArticle
        for ($i = 0; $i < $count; $i++) {
            $xml .= $this->_formatArticle($this->articles[$i]);
        }

        // Close off the feed
        $xml .= $this->_feedFooter();

        // And write it to file
        return $this->_writeFile($fileName, $xml);
    }

    /**
    * Return the formatted start of a feed.
    *
    * This will start the xml and create header information about the feed
    * itself.
    */
    protected function _feedHeader()
    {
        $xml = '<?xml version="1.0" encoding="' . $this->encoding . '"?>' . self::LB;

        return $xml;
    }

    /**
    * Inject extending tags into the feed header, if needed.
    */
    protected function _injectExtendingTags()
    {
        $xml = '';

        if (count($this->extensions) > 0) {
            $this->extensions = array_unique($this->extensions);
            $xml = ' ' . implode(self::LB, $this->extensions) . self::LB;
        }

        return $xml;
    }

    /**
    * Inject XMLNS items into the feed master element, if needed.
    */
    protected function _injectNamespaces()
    {
        $xml = ' ';

        if (count($this->namespaces) > 0) {
            $this->namespaces = array_unique($this->namespaces);
            $xml = implode(' ', $this->namespaces);
        }

        return $xml;
    }

    /**
    * Format an article into feed specific XML.
    *
    * Takes an associative article array and turns it into an XML definition
    * of an article.
    * @param array $article ASsociative array describing an article.
    */
    abstract protected function _formatArticle(array $article);

    /**
    * Return the formatted end of a feed.
    *
    * just closes things off nicely.
    */
    abstract protected function _feedFooter();

    /**
    * Handle the begining of an XML element
    *
    * This is called from the parserfactory once the type of data has been
    * determined. Standard XML_PARSER element handler.
    *
    * @author Michael Jervis (mike@fuckingbrit.com)
    * @copyright Michael Jervis 2004
    */
    abstract public function startElement($parser, $name, $attributes);

    /**
    * Handle the close of an XML element
    *
    * Called by the parserfactory during parsing.
    */
    abstract public function endElement($parser, $name);

    /**
    * Handles character data.
    *
    * Called by the parserfactory during parsing.
    */
    abstract public function charData($parser, $data);
}

?>
