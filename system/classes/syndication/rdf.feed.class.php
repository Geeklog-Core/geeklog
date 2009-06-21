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

    function RDF()
    {
      $this->FeedParserBase();
      $this->_inItem = false;
    }

    /**
      * Format an article into an Atom 0.3 <entry> tag.
      *
      * Takes an associative article array and turns it into an XML definition
      * of an article. Uses merely title, link and summary.
      *
      * @param array $article Associative array describing an article.
      */
    function _formatArticle( $article )
    {
      $xml = "<item rdf:about=\"{$article['link']}\">\n";
      $xml .= '<title>'.$this->_safeXML( $article['title'] )."</title>\n";
      $xml .= '<link>'.$this->_safeXML( $article['link'] )."</link>\n";
      if( array_key_exists( 'author', $article ) )
      {
        $xml .= '<dc:creator>'.$article['author']."</dc:creator>\n";
      }
      if( array_key_exists( 'summary', $article ) )
      {
        if( strlen( $article['summary'] ) > 0 )
        {
          $xml .= '<content:encoded>'
                          . $this->_safeXML ($article['summary'])
                          . "</content:encoded>\n";
        }
      }
      if( is_array( $article['extensions'] ) )
      {
        foreach( $article['extensions'] as $extendingTag )
        {
            $xml .= "$extendingTag\n";
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
      $this->namespaces[] = 'xmlns:dc="http://purl.org/dc/elements/1.1/"';
      $this->namespaces[] = 'xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"';
      $this->namespaces[] = 'xmlns="http://purl.org/rss/1.0/"';
      $this->namespaces[] = 'xmlns:content="http://purl.org/rss/1.0/modules/content/"';
      $xml .= '<rdf:RDF'.$this->_injectNamespaces().">\n";
      $xml .= "<channel  rdf:about=\"{$this->feedlogo}\">\n";
      $xml .= "<title>".$this->_safeXML( $this->title )."</title>\n";
      $xml .= '<link>'.$this->_safeXML( $this->sitelink )."</link>\n";
      $xml .= '<description>'.$this->_safeXML( $this->description )."</description>\n";
      $xml .= '<dc:language>'.$this->lang."</dc:language>\n";
      if( strlen($this->feedlogo) > 0 )
      {
        $xml .= '<image rdf:resource="'.$this->_safeXML( $this->feedlogo )."\"/>\n";
      }

      if( strlen($this->sitecontact) > 0 )
      {
        $xml .= '<dc:creator>'.$this->sitecontact."</dc:creator>\n";
      }
      $xml .= "<items>\n<rdf:Seq/>\n</items>\n";
      if( strlen($this->feedlogo) > 0 )
      {
        $xml .= "<image  rdf:about=\"{$this->feedlogo}\">\n";
        $xml .= '<url>'.$this->_safeXML( $this->feedlogo )."</url>\n";
        $xml .= '<title>'.$this->_safeXML( $this->title )."</title>\n";
        $xml .= '<link>'.$this->_safeXML( $this->sitelink )."</link>\n";
        $xml .= "</image>\n";
      }
      $xml .= $this->_injectExtendingTags();
      $xml .= "</channel>\n";

      return $xml;
    }

    /**
      * Return the formatted end of a feed.
      *
      * just closes things off nicely.
      */
    function _feedFooter()
    {
      $xml = "</rdf:RDF>\n";
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
        } else if( $this->_currentTag == 'CONTENT:ENCODED' ) {
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
?>
