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

  /**
    * Provides feed handlers for Atom 0.3
    *
    * @author Michael Jervis (mike@fuckingbrit.com)
    * @version 1.0
    */

  /**
   * atom03 provides reading and writing of Atom 0.3 format syndication feeds.
   *
   * @author Michael Jervis (mike@fuckingbrit.com)
   * @copyright Michael Jervis 2004
   * @abstract
   */
  class Atom03 extends FeedParserBase
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

    function Atom03()
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
      $xml = "<entry>\n";
      $xml .= '<title mode="escaped">'.$this->_safeXML( $article['title'] )."</title>\n";
      $xml .= '<link rel="alternative" type="text/html" href="'.$this->_safeXML( $article['link'] )."\">\n";
      $xml .= '<id>'.htmlspecialchars( $entry['link'] )."</id>\n";
      $xml .= '<issued>'.strftime( "%a, %d %b %Y %T %Z", $article['date'] )."</issued>\n";
      $xml .= '<modified>'.strftime( "%a, %d %b %Y %T %Z", $article['date'] )."</modified>\n";
      if( array_key_exists( 'author', $article ) )
      {
        $xml .= "<author>\n<name>{$article['author']}</name>\n</author>\n";
      }
      if( array_key_exists( 'summary', $article ) )
      {
        if( strlen( $article['summary'] ) > 0 )
        {
          $xml .= '<content type="text/html" mode="escaped">'
                          . $this->_safeXML ($article['text'])
                          . "</content>\n";
        }
      }
      $xml .= "</entry>\n";
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
      $xml .= "<feed version=\"0.3\">\n";
      $xml .= "<title mode=\"escaped\">".$this->_safeXML( $this->title )."</title>\n";
      $xml .= '<tagline mode=\"escaped\">'.$this->_safeXML( $this->description )."</tagline>\n";
      $xml .= '<link rel="alternative" type="text/html" href="'.$this->_safeXML( $this->sitelink )."\"/>\n";
      return $xml;
    }

    /**
      * Return the formatted end of a feed.
      *
      * just closes things off nicely.
      */
    function _feedFooter()
    {
      $xml = "</feed>\n";
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
      if( $name == 'ENTRY' )
      {
        $this->_inItem = true;
        $this->_currentItem = array();
      } else if( $this->_inItem ) {
        if( $name == 'LINK' )
        {
          $this->_currentItem['link'] = $attributes['HREF'];
        }
      } else {
        if( $name == 'LINK' )
        {
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
    function endElement($parser, $name)
    {
      if( $name == 'ENTRY' )
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
        } else if( $this->_currentTag == 'CONTENT' ) {
          if( empty( $this->_currentItem['summary'] ) )
          {
            $this->_currentItem['summary'] = $data;
          } else {
            $this->_currentItem['summary'] .= $data;
          }
        } else if( $this->_currentTag == 'MODIFIED' ) {
          $this->_currentItem['date'] = $data;
        } else if( $this->_currentTag == 'ISSUED' ) {
          if( empty( $this->currentItem['date'] ) )
          {
            $this->currentITem['date'] = $data;
          }
        }
      } else {
        if( $this->_currentTag == 'TITLE' )
        {
          $this->title .= $data;
        } else if( $this->_currentTag == 'TAGLINE' ) {
          $this->description .= $data;
        }
      }
    }
  }
