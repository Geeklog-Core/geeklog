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
  class FeedParserBase
  {
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
    var $articles;

    /**
      * Encoding tag for the XML declaration
      */
    var $encoding;

    /**
      * Language for the feed
      */
    var $lang;

    /**
      * Title for the feed
      */
    var $title;

    /**
      * The description of the feed
      */
    var $description;

    /**
      * The URL of the feed
      */
    var $url;

    /**
      * URL of the site
      */
    var $sitelink;

    /**
      * Site contact
      */
    var $sitecontact;

    /**
      * copyright tag:
      */
    var $copyright;

    /**
      * system powering the feed
      */
    var $system;

    /**
      * Image to link to the feed.
      */
    var $feedlogo;

    /**
      * Additional namespaces to add.
      */
    var $namespaces;

    /**
      * Additional tags to add.
      */
    var $extensions;

    /**
      * Stuff for parsing XML
      */
    var $_currentTag;

    function FeedParserBase()
    {
      $this->encoding = 'iso-8859-1';
      $title = 'Killer Feed System Feed';
      $this->lang = 'en-gb';
      $currentTag = '';
      $articles = array();
    }

    /**
      * Create a file for the stream
      *
      * Writes the $items content to the file supplied in the format we have
      * specified. Uses the (abstract) function formatArticle to return XML
      * for an article.
      *
      * @param string $fileName The fully qualified path to the file to create.
      * @param int $limit (optional) max number of items to write.
      */
    function createFeed( $fileName, $limit='' )
    {
      /* Start the XML Feed formating */
      $xml = $this->_feedHeader();

      /* Start with a limit of the size of the array, then, if we have a
       * specific max length use that unless it's bigger than our count */
      $count = count( $this->articles );
      if( $limit )
      {
        if( $limit < $count )
        {
          $count = $limit;
        }
      }

      /* Put the first $count items into the xml, using formatArticle */
      for( $i = 0; $i < $count; $i++ )
      {
        $xml .= $this->_formatArticle( $this->articles[$i] );
      }

      /* Close off the feed */
      $xml .= $this->_feedFooter();
      /* And write it to file */
      return $this->_writeFile( $fileName, $xml );
    }

    function _writeFile( $fileName, $data )
    {
      if( $fp = @fopen( $fileName, 'w' ) )
      {
        fputs( $fp, $data );
        fclose( $fp );
        return true;
      } else {
        return false;
      }
    }

    /**
      * Format an article into feed specific XML.
      *
      * Takes an associative article array and turns it into an XML definition
      * of an article.
      * @param array $article ASsociative array describing an article.
      */
    function _formatArticle( $article )
    {
      $xml = "<article>\n";
      while( list($key, $value) = each( $article ) )
      {
        if($key != 'extensions')
        {
            $value = $this->_safeXML( $value );
            $xml .= "<$key>$value</$key>\n>";
        } else {
            if(is_array($value))
            {
                foreach( $value as $ext )
                {
                    $xml .= $ext."\n";
                }
            } else {
                $xml .= $value."\n";
            }
        }

      }
      $xml .= "</article>\n";
      return $xml;
    }

    /**
      * Make sure a string is safe to be chardata in an xml element
      *
      * @param string $string the string to escape.
      */
    function _safeXML( $string )
    {
      return htmlspecialchars($string);
    }

    /**
      * Return the formatted start of a feed.
      *
      * This will start the xml and create header information about the feed
      * itself.
      */
    function _feedHeader()
    {
      $xml = "<?xml version=\"1.0\" encoding=\"{$this->encoding}\"?>\n\n";

      $xml .= '<feed'.$this->_injectNamespaces().">\n";

      $xml .= "<title>{$this->title}</title>\n";
      $xml .= $this->_injectExtendingTags();
      return $xml;
    }
    
    /**
      * Inject extending tags into the feed header, if needed.
      */
    function _injectExtendingTags()
    {
      $xml = '';
      if( is_array( $this->extensions ) )
      {
        $this->extensions = array_unique($this->extensions);
        $xml .= implode("\n", $this->extensions) . "\n";
      }
      return $xml;
    }

    /**
      * Inject XMLNS items into the feed master element, if needed.
      */
    function _injectNamespaces()
    {
        $xml = ' ';
        if( is_array($this->namespaces) )
        {
            $this->namespaces = array_unique($this->namespaces);
            $xml .= implode(' ', $this->namespaces);
        }

        return $xml;
    }

    /**
      * Return the formatted end of a feed.
      *
      * just closes things off nicely.
      */
    function _feedFooter()
    {
      $xml = '</feed>';
      return $xml;
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
    function startElement($parser, $name, $attributes)
    {
    }

    /**
      * Handle the close of an XML element
      *
      * Called by the parserfactory during parsing.
      */
    function endElement($parser, $name)
    {
    }

    /**
      * Handles character data.
      *
      * Called by the parserfactory during parsing.
      */
    function charData($parser, $data)
    {
    }
  }
?>
