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
    *
    * This library file provides multiple class definitions for dealing with
    * variants of the RSS syndication format. We will <b>not</b> handle RSS 1.0
    * however, that is RDF and handled in a seperate case. This is purely for
    * the original RSS and the 2.0 that was created to deal with the fact
    * that RDF was overkill for the original purpose of RSS.
    *
    * @author Michael Jervis (mike@fuckingbrit.com)
    * @version 1.0
    */

  /**
   * rss0x provides reading and writing of RSS 0.91 format syndication feeds.
   *
   * @author Michael Jervis (mike@fuckingbrit.com)
   * @copyright Michael Jervis 2004
   * @abstract
   */
  class RSS0x extends FeedParserBase
  {
    /**
      * @access private
      * @var boolean
      */
    var $_inItem;

    /**
      * @access private
      * @var array
      */
    var $_currentItem;

    function RSS0x()
    {
      $this->FeedParserBase();
      $this->_inItem = false;
    }

    /**
      * Format an article into an RSS 0.91 <item> tag.
      *
      * Takes an associative article array and turns it into an XML definition
      * of an article. Uses merely title, link and summary.
      *
      * @param array $article Associative array describing an article.
      */
    function _formatArticle( $article )
    {
      $xml = "<item>\n";
      $xml .= '<title>'.$this->_safeXML( $article['title'] )."</title>\n";
      $xml .= '<link>'.$this->_safeXML( $article['link'] )."</link>\n";
      if( array_key_exists( 'summary', $article ) )
      {
        if( strlen( $article['summary'] ) > 0 )
        {
          $xml .= '<description>'.$this->_safeXML( $article['summary'] )."</description>\n";
        }
      }

      if( is_array($article['extensions']) )
      {
        foreach( $article['extensions'] as $extensionTag )
        {
            $xml .= "$extensionTag\n";
        }
      }
      $xml .= "</item>\n";
      return $xml;
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
      $xml .= "<rss version=\"0.91\"".$this->_injectNamespaces().">\n<channel>\n";
      $xml .= "<title>".$this->_safeXML( $this->title )."</title>\n";
      $xml .= "<link>".$this->_safeXML( $this->sitelink )."</link>\n";
      if( strlen( $this->description ) > 0 )
      {
        $xml .= "<description>".$this->_safeXML( $this->description )."</description>\n";
      }
      $xml .= "<language>{$this->lang}</language>\n";
      if( strlen($this->feedlogo) > 0 )
      {
        $xml .= "<image>\n";
        $xml .= '<url>'.$this->_safeXML( $this->feedlogo )."</url>\n";
        $xml .= '<title>'.$this->_safeXML( $this->title )."</title>\n";
        $xml .= '<link>'.$this->_safeXML( $this->sitelink )."</link>\n";
        $xml .= "</image>\n";
      }
      $xml .= $this->_injectExtendingTags();
      return $xml;
    }

    /**
      * Return the formatted end of a feed.
      *
      * just closes things off nicely.
      */
    function _feedFooter()
    {
      $xml = "</channel>\n</rss>\n";
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
      if( $name == 'ITEM' )
      {
        $this->_inItem = true;
        $this->_currentItem = array();
      }
      $this->_currentTag = $name;
    }

    /**
      * Handle the close of an XML element
      *
      * Called by the parserfactory during parsing.
      */
    function endElement($parser, $name)
    {
      if( $name == 'ITEM' )
      {
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
    function charData($parser, $data)
    {
      if( $this->_inItem )
      {
        if( $this->_currentTag == 'TITLE' )
        {
          if( empty( $this->_currentItem['title'] ) )
          {
            $this->_currentItem['title'] = $data;
          } else {
            $this->_currentItem['title'] .= $data;
          }
        } else if( $this->_currentTag == 'LINK' ) {
          if( empty( $this->_currentItem['link'] ) )
          {
            $this->_currentItem['link'] = $data;
          } else {
            $this->_currentItem['link'] .= $data;
          }
        } else if( $this->_currentTag == 'DESCRIPTION' ) {
          if( empty( $this->_currentItem['summary'] ) )
          {
            $this->_currentItem['summary'] = $data;
          } else {
            $this->_currentItem['summary'] .= $data;
          }
        }
      } else {
        if( $this->_currentTag == 'TITLE' )
        {
          $this->title .= $data;
        } else if( $this->_currentTag == 'LINK' ) {
          $this->sitelink .= $data;
        } else if( $this->_currentTag == 'DESCRIPTION' ) {
          $this->description .= $data;
        }
      }
    }
  }


  /**
   * rss20 provides reading and writing of RSS 2.0 format syndication feeds.
   *
   * @author Michael Jervis (mike@fuckingbrit.com)
   * @copyright Michael Jervis 2004
   * @abstract
   */
  class RSS20 extends FeedParserBase
  {
    /**
      * @access private
      * @var boolean
      */
    var $_inItem;

    /**
      * @access private
      * @var array
      */
    var $_currentItem;

    /**
      * Date of feed, for reading only
      */
    var $date;

    /**
      * is the guid element a permalink?
      */
    var $_permaLink;

    /**
      * Have we used GUID for link?
      */
    var $_linkGUID;

    function RSS20()
    {
      $this->FeedParserBase();
      $this->_inItem = false;
      $this->_linkGUID = false;
    }

    /**
      * Generate an RFC-822 compliant date-time stamp.
      *
      * @param timestamp $timestamp Date time to format.
      */
    function _RFC822DateFormat($timestamp='')
    {
    	// format the date
    	if(!empty($timestamp))
    	{
    		$time = date( 'r', $timestamp);
    	} else {
    		$time = date( 'r' );
    	}
    	// return the time
    	return $time;
    }

    /**
      * Format an article into an RSS 2.0 <item> tag.
      *
      * Takes an associative article array and turns it into an XML definition
      * of an article. Uses merely title, link and summary.
      *
      * @param array $article Associative array describing an article.
      */
    function _formatArticle( $article )
    {
      $xml = "<item>\n";
      $xml .= '<title>'.$this->_safeXML( $article['title'] )."</title>\n";
      $xml .= '<link>'.$this->_safeXML( $article['link'] )."</link>\n";
      $xml .= '<guid isPermaLink="true">'.$this->_safeXML( $article['link'] )."</guid>\n";
      $xml .= '<pubDate>'.$this->_RFC822DateFormat( $article['date'] )."</pubDate>\n";
      if( array_key_exists( 'commenturl', $article ) )
      {
        $xml .= '<comments>'.$this->_safeXML( $article['commenturl'] )."</comments>\n";
      }
      if( array_key_exists( 'topic', $article ) )
      {
        $topic = $article['topic'];
        if( is_array( $topic ))
        {
          foreach( $topic as $subject )
          {
            $xml .= '<dc:subject>'.$this->_safeXML( $subject )."</dc:subject>\n";
          }
        }
        else
        {
          $xml .= '<dc:subject>'.$this->_safeXML( $topic )."</dc:subject>\n";
        }
      }
      if( array_key_exists( 'summary', $article ) )
      {
        if( strlen( $article['summary'] ) > 0 )
        {
          $xml .= '<description>'.$this->_safeXML( $article['summary'] )."</description>\n";
        }
      }
      if( isset($article['extensions']) &&  is_array($article['extensions']) )
      {
        foreach( $article['extensions'] as $extensionTag )
        {
            $xml .= "$extensionTag\n";
        }
      }
      $xml .= "</item>\n";
      return $xml;
    }

    /**
      * Return the formatted start of a feed.
      *
      * This will start the xml and create header information about the feed
      * itself.
      */
    function _feedHeader()
    {
      global $_CONF;

      if( !is_array($this->namespaces) )
      {
        $this->namespaces = array();
      }
      $this->namespaces[] = 'xmlns:dc="http://purl.org/dc/elements/1.1/"';

      $xml = "<?xml version=\"1.0\" encoding=\"{$this->encoding}\"?>\n\n";
      $xml .= "<rss version=\"2.0\"".$this->_injectNamespaces().">\n";
      $xml .= "<channel>\n";
      $xml .= "<title>".$this->_safeXML( $this->title )."</title>\n";
      $xml .= "<link>".$this->_safeXML( $this->sitelink )."</link>\n";
      if( strlen( $this->description ) > 0 )
      {
        $xml .= "<description>".$this->_safeXML( $this->description )."</description>\n";
      }
      if( strlen($this->sitecontact) > 0 )
      {
        $xml .= '<managingEditor>'.$this->_safeXML( $this->sitecontact )."</managingEditor>\n";
        $xml .= '<webMaster>'.$this->_safeXML( $this->sitecontact )."</webMaster>\n";
      }
      if( strlen($this->copyright) > 0 )
      {
        $xml .= '<copyright>'.$this->_safeXML( $this->copyright )."</copyright>\n";
      }
      if( strlen($this->system) > 0 )
      {
        $xml .= '<generator>'.$this->_safeXML( $this->system )."</generator>\n";
      }
      $xml .= '<pubDate>'.$this->_RFC822DateFormat()."</pubDate>\n";
      $xml .= "<language>{$this->lang}</language>\n";

      if( strlen($this->feedlogo) > 0 )
      {
        $xml .= "<image>\n";
        $xml .= '<url>'.$this->_safeXML( $this->feedlogo )."</url>\n";
        $xml .= '<title>'.$this->_safeXML( $this->title )."</title>\n";
        $xml .= '<link>'.$this->_safeXML( $this->sitelink )."</link>\n";
        $xml .= "</image>\n";
      }
      $xml .= $this->_injectExtendingTags();
      return $xml;
    }

    /**
      * Return the formatted end of a feed.
      *
      * just closes things off nicely.
      */
    function _feedFooter()
    {
      $xml = "</channel>\n</rss>\n";
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
      $this->_currentTag = $name;
      if( $name == 'ITEM' )
      {
        $this->_inItem = true;
        $this->_currentItem = array();
        $this->_permaLink = false;
      } else if( ($name == 'GUID') && array_key_exists('ISPERMALINK', $attributes) ) {
        if( $attributes['ISPERMALINK'] == 'true' )
        {
          $this->_permaLink = true;
        } else {
          $this->_permaLink = false;
        }
      } else if( ($name == 'ENCLOSURE') && array_key_exists('URL', $attributes) ) {
        /* If we have an enclosure with a URL, remember it because this is a podcast */
        $this->_currentItem['enclosureurl'] = $attributes['URL'];
      } else {
        $this->_permaLink = false;
      }

    }

    /**
      * Handle the close of an XML element
      *
      * Called by the parserfactory during parsing.
      */
    function endElement($parser, $name)
    {
      if( $name == 'ITEM' )
      {
        $this->_inItem = false;
        $this->articles[] = $this->_currentItem;
      } elseif ($name == 'GUID') {
        if ($this->_permaLink) {
          // if we have a guid that is ALSO a permalink, override link with it
          $this->_currentItem['link'] = $this->_currentItem['guid'];
          $this->_linkGUID = true;
        } elseif (empty($this->_currentItem['link']) &&
                  substr($this->_currentItem['guid'], 0, 4) == 'http') {
          /* this is NOT according to spec: if we don't have a link but the
           * guid, despite being non-permanent, starts with http, use it instead
           */
          $this->_currentItem['link'] = $this->_currentItem['guid'];
          $this->_linkGUID = true;
        }
      }
      $this->_currentTag = '';
    }

    /**
      * Handles character data.
      *
      * Called by the parserfactory during parsing.
      */
    function charData($parser, $data)
    {
      if( $this->_inItem )
      {
        if( $this->_currentTag == 'TITLE' )
        {
          if( empty( $this->_currentItem['title'] ) )
          {
            $this->_currentItem['title'] = $data;
          } else {
            $this->_currentItem['title'] .= $data;
          }
        } else if( $this->_currentTag == 'LINK' ) {
          if( !$this->_linkGUID )
          {
              if( empty( $this->_currentItem['link'] ) )
              {
                $this->_currentItem['link'] = $data;
              } else {
                $this->_currentItem['link'] .= $data;
              }
          }
        } else if( $this->_currentTag == 'DESCRIPTION' ) {
          if( empty( $this->_currentItem['summary'] ) )
          {
            $this->_currentItem['summary'] = $data;
          } else {
            $this->_currentItem['summary'] .= $data;
          }
        } else if( $this->_currentTag == 'PUBDATE' ) {
          $this->_currentItem['date'] = $data;
        } else if( $this->_currentTag == 'GUID' ) {
          if( empty( $this->_currentItem['guid'] ) )
          {
            $this->_currentItem['guid'] = $data;
          } else {
            $this->_currentItem['guid'] .= $data;
          }
        }
      } else {
        if( $this->_currentTag == 'TITLE' )
        {
          $this->title .= $data;
        } else if( $this->_currentTag == 'LINK' ) {
          $this->sitelink .= $data;
        } else if( $this->_currentTag == 'DESCRIPTION' ) {
          $this->description .= $data;
        } else if( $this->_currentTag == 'MANAGINGEDITOR' ) {
          $this->sitecontact .= $data;
        } else if( $this->_currentTag == 'COPYRIGHT' ) {
          $this->copyright .= $data;
        } else if( $this->_currentTag == 'PUBDATE' ) {
          $this->date .= $data;
        }
      }
    }
  }
?>
