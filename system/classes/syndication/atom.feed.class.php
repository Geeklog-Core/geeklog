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

    function _RFC3339Date($timestamp='')
    {
        $return = '';
        if( !empty($timestamp) )
        {
            $return = strftime("%Y-%m-%dT%T", $timestamp);
            $suffix = strftime("%z", $timestamp);
        } else {
            $return = strftime("%Y-%m-%dT%T");
            $suffix = strftime("%z");
        }
        return $return.substr($suffix,0,3).':'.substr($suffix,3,2);
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
      $xml .= '<link rel="alternate" type="text/html" href="'.$this->_safeXML( $article['link'] )."\"/>\n";
      $xml .= '<id>'.htmlspecialchars( $article['link'] )."</id>\n";
      $xml .= '<issued>'.$this->_RFC3339Date( $article['date'] )."</issued>\n";
      $xml .= '<modified>'.$this->_RFC3339Date( $article['date'] )."</modified>\n";
      if( array_key_exists( 'author', $article ) )
      {
        $xml .= "<author>\n<name>{$article['author']}</name>\n</author>\n";
      }
      if( array_key_exists( 'summary', $article ) )
      {
        if( !empty( $article['summary'] ) )
        {
          $xml .= '<content type="text/html" mode="escaped">'
                          . $this->_safeXML ($article['summary'])
                          . "</content>\n";
        }
      }
      if( is_array( $this->extensions ) )
      {
        foreach( $this->extensions as $extendingTag )
        {
            $xml .= "$extendingTag\n";
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
      $xml = '<?xml version="1.0" encoding="' . $this->encoding . '" ?>' . LB . LB
           . '<feed version="0.3"  xmlns="http://purl.org/atom/ns#"'.$this->_injectNamespaces().'>' . LB
           . '<title mode="escaped">' . $this->_safeXML( $this->title ) . '</title>' . LB
           . '<tagline mode="escaped">' . $this->_safeXML( $this->description ) . '</tagline>' . LB
           . '<link rel="alternate" type="text/html" href="' . $this->_safeXML( $this->sitelink ) . '"/>' . LB
           . '<modified>'.$this->_RFC3339Date().'</modified>' . LB
           . "<author>\n<name>" . $this->_safeXML( $this->title ) . '</name>' . LB
           . '<email>' . $this->_safeXML( $this->sitecontact ) . "</email>\n</author>\n";
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
          if( empty( $this->_currentItem['date'] ) )
          {
            $this->_currentItem['date'] = $data;
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

  /**
   * atom10 provides reading and writing of Atom 1.0 format syndication feeds.
   *
   * @author Michael Jervis (mike@fuckingbrit.com)
   * @copyright Michael Jervis 2005
   * @abstract
   */
  class Atom10 extends FeedParserBase
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

    function Atom10()
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
      $xml .= '<title type="html">'.$this->_safeXML( $article['title'] )."</title>\n";
      $xml .= '<link rel="alternate" type="text/html" href="'.$this->_safeXML( $article['link'] )."\"/>\n";
      $xml .= '<id>' . $this->_createId($article['link'], $article['date']) . "</id>\n";
      $xml .= '<published>'.$this->_RFC3339Date( $article['date'] )."</published>\n";
      $xml .= '<updated>'.$this->_RFC3339Date( $article['date'] )."</updated>\n";
      if( array_key_exists( 'author', $article ) )
      {
        $xml .= "<author>\n<name>{$article['author']}</name>\n</author>\n";
      }
      if( array_key_exists( 'summary', $article ) )
      {
        if( !empty( $article['summary'] ) )
        {
          $xml .= '<content type="html">'
                          . $this->_safeXML ($article['summary'])
                          . "</content>\n";
        }
      }
      if( is_array( $this->extensions ) )
      {
        foreach( $this->extensions as $extendingTag )
        {
            $xml .= "$extendingTag\n";
        }
      }
      $xml .= "</entry>\n";
      return $xml;
    }

    function _createId($url, $date)
    {
        $start = strpos($url, '/') + 2;
        $end = strpos($url, '/', $start);
        $tag = 'tag:'.substr($url, $start, $end-$start);
        $tag .= strftime(",%Y-%m-%d", $date).':'.substr($url, $end);
        return $tag;
    }

    function _RFC3339Date($timestamp='')
    {
        $return = '';
        if( !empty($timestamp) )
        {
            $return = strftime("%Y-%m-%dT%T", $timestamp);
            $suffix = strftime("%z", $timestamp);
        } else {
            $return = strftime("%Y-%m-%dT%T");
            $suffix = strftime("%z");
        }
        return $return.substr($suffix,0,3).':'.substr($suffix,3,2);
    }

    /**
      * Return the formatted start of a feed.
      *
      * This will start the xml and create header information about the feed
      * itself.
      */
    function _feedHeader()
    {
      $xml = '<?xml version="1.0" encoding="' . $this->encoding . '" ?>' . LB . LB
           . '<feed xmlns="http://www.w3.org/2005/Atom"'.$this->_injectNamespaces().'>' . LB
           . '<title type="text">' . $this->_safeXML( $this->title ) . '</title>' . LB
           . '<subtitle type="text">' . $this->_safeXML( $this->description ) . '</subtitle>' . LB
           . '<link rel="self" href="' . $this->_safeXML( $this->url ) . '"/>' . LB
           . '<link rel="alternate" type="text/html" href="' . $this->_safeXML( $this->sitelink ) . '/"/>' . LB;
      if ($this->feedlogo != '')
      {
           $xml .= '<logo>' . $this->_safeXML( $this->feedlogo ) . '</logo>' . LB;
      }
      $xml .= '<id>' . $this->_safeXML( $this->sitelink ) . '/</id>' . LB
           . '<updated>'.$this->_RFC3339Date().'</updated>' . LB
           . "<author>\n<name>" . $this->_safeXML( $this->title ) . '</name>' . LB
           . '<email>' . $this->_safeXML( $this->sitecontact ) . "</email>\n</author>\n";
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
        } else if( $this->_currentTag == 'UPDATED' ) {
          $this->_currentItem['date'] = $data;
        } else if( $this->_currentTag == 'PUBLISHED' ) {
          if( empty( $this->_currentItem['date'] ) )
          {
            $this->_currentItem['date'] = $data;
          }
        }
      } else {
        if( $this->_currentTag == 'TITLE' )
        {
          $this->title .= $data;
        } else if( $this->_currentTag == 'SUBTITLE' ) {
          $this->description .= $data;
        }
      }
    }
  }
?>
