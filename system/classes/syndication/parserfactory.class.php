<?php
  /****************************************************************************/
  /* feedparserfactory.class.php                                              */
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

  // Require pear HTTP_REQUEST
  require_once('HTTP/Request.php');
  /**
   * FeedParserFactory provides generic access to syndication feed formats.
   *
   * <p>This library provides abstraction of feed formats. It provides a factory
   * pattern interface to constructing feed handlers to parse incoming
   * syndication files, and write outgoing syndication files. The interface is
   * not tied to any system implementation, however, I plan to provide interface
   * to geeklog.</p>
   *
   * @author Michael Jervis (mike@Fuckingbrit.com)
   * @copyright Michael Jervis 2004
   * @see FeedParserBase
   */
  class FeedParserFactory
  {
    var $readerName;
    var $reader;
    var $userAgent;
    var $errorStatus;
    var $lastModified;
    var $eTag;

    /**
      * Constructor, loads feedparser classes into memory.
      *
      * This takes a path on which the supporting feed classes exist, and then
      * tries to find all *.feed.class.php and brings them into scope.
      *
      * @param string $path path to include files from.
      */
    function FeedParserFactory( $path='' )
    {
      if( $path != '' )
      {
        if( is_dir( $path ) )
        {
          $folder = opendir( $path );
          while( ( $filename = @readdir( $folder ) ) !== false )
          {
            if( preg_match( '/(.*)\.feed\.class\.php$/i', $filename ) )
            {
              require_once( $path.'/'.$filename );
            }
          }
        }
      }
      $this->lastModified = '';
      $this->eTag = '';
    }

    /**
      * Method to get a feed handler class.
      *
      * This function takes a url, fetches it, parses it, and thus figures out
      * what type of feed parser to return, with the contents all parsed for
      * your viewing pleasure.
      *
      * @access public
      * @param string $url The url to a feed type to syndicate.
      */
    function reader( $url, $targetformat='' )
    {
      if( $data = $this->_getFeed( $url ) )
      {
        return $this->_findFeed( $data, $targetformat );
      } else {
        return false;
      }
    }

    /**
      * Method to get a feed handler class.
      *
      * this function assumes you know what you want, and gets you a blank feed
      * handler to write that data.
      *
      * @access public
      * @param string $feedtype the type of feed to get
      * @param float $version the version
      */
    function writer( $feedtype, $version=2.0 )
    {
      $feedtype = strtolower($feedtype);
      switch ($feedtype)
      {
        case 'rss':
          if( $version == '' )
          {
            return new RSS0x();
          } else {
            if( $version < 1.0 )
            {
              return new RSS0x();
            } else if( $version >= 2.0 ) {
              return new RSS20();
            } else {
              return new RSS0x();
            }
          }
          break;
        case 'rdf':
          return new RDF();
          break;
        case 'atom':
          if( $version == '' )
          {
            return new Atom10();
          } else {
            if( $version < 1.0 )
            {
              return new Atom03();
            } else {
              return new Atom10();
            }
          }
          break;
        default:
          return false;
          break;
      }
    }

    /**
      * Provides an array of feed types understood.
      *
      * Provides an array of feed types understood. Yeah it's manual, but, the
      * feed reader has to be edited to support new inbounds anyway.
      *
      * @access public
      */
    function getFeedTypes()
    {
      $types = array();
      $types[] = array('name'=>'RSS','version'=>'0.9x');
      $types[] = array('name'=>'RSS','version'=>'2.0');
      $types[] = array('name'=>'RDF','version'=>'1.0');
      $types[] = array('name'=>'Atom','version'=>'0.3');
      $types[] = array('name'=>'Atom','version'=>'1.0');
      return $types;
    }

    /**
      * Opens a url in a file pointer
      *
      * @access private
      * @param string $url The URL to open.
      * @return mixed      HTTP response body or boolean false
      */
    function _getFeed( $url )
    {
        $req = new HTTP_Request($url, array('allowRedirects' => true));
        if ($this->userAgent != '') {
            $req->addHeader('User-Agent', $this->userAgent);
        }
        if (!empty($this->lastModified) && !empty($this->eTag)) {
            $req->addHeader('If-Modified-Since', $this->lastModified);
            $req->addHeader('If-None-Match', $this->eTag);
        }
        $response = $req->sendRequest();
        if (!PEAR::isError($response)) {
            if ($req->getResponseCode() == 304) {
                $this->errorStatus = false; // indicate no error, just unchanged
                return false;
            } else {
                $this->lastModified = $req->getResponseHeader('Last-Modified');
                $this->eTag = $req->getResponseHeader('ETag');
                return $req->getResponseBody();
            }
        } else {
      	    $this->errorStatus = array('HTTP Fetch Failed', $response->getCode(), $response->getMessage());
            return false;
        }
    }

    /**
      * Find out what format a feed is in.
      *
      * @access private
      */
    function _findFeed( $data, $format='' )
    {
      $xml_parser = xml_parser_create();
      xml_parser_set_option( $xml_parser, XML_OPTION_CASE_FOLDING, true );
      if( $format != '' )
      {
        @xml_parser_set_option( $xml_parser, XML_OPTION_TARGET_ENCODING,
                                $format );
      }
      xml_set_element_handler( $xml_parser, array(&$this,'_startElement'), array(&$this, '_endElement') );
      xml_set_character_data_handler( $xml_parser, array(&$this,'_charData') );

      if( !xml_parse( $xml_parser, $data ) )
      {
        $this->errorStatus = array( 'Unable to parse XML',
                'Error Code: '.xml_get_error_code( $xml_parser  ),
                'Error Message: '.xml_error_string( xml_get_error_code( $xml_parser  ) )
        		    );
        xml_parser_free( $xml_parser );
        return false;
      }
      xml_parser_free( $xml_parser );

      if( $this->reader != false )
      {
        return $this->reader;
      } else {
      	$this->errorStatus = array( 'Unidentified feed type.', '', '' );
        return false;
      }
    }

    function _startElement( $parser, $name, $attributes )
    {
      if( !$this->readerName )
      {
        /* Check for atom */
        if( $name == 'FEED' )
        {
          if( array_key_exists('VERSION', $attributes) )
          {
            $this->readerName = 'Atom03';
          } else {
            $this->readerName = 'Atom10';
          }
        } elseif ( $name == 'RSS' ) {
          if( array_key_exists('VERSION', $attributes) )
          {
            $version = $attributes['VERSION'];
          } else {
            $version = 0.91;
          }
          if( $version < 1 )
          {
            $this->readerName = 'RSS0x';
          } else {
            $this->readerName = 'RSS20';
          }
        } elseif ( $name = 'RDF:RDF' ) {
          $this->readerName = 'RDF';
        }
        if( $this->readerName )
        {
          $this->reader = new $this->readerName;
          //echo( "Made a new {$this->readerName} called {$this->reader} it's a ".get_class($this->reader)." I'm a ".get_class($this) );
        }
      }

      if( $this->reader )
      {
        $this->reader->startElement( $parser, $name, $attributes );
      }
    }

    function _endElement( $parser, $name )
    {
      if( $this->reader )
      {
        $this->reader->endElement( $parser, $name );
      }
    }

    function _charData( $parser, $data )
    {
      if( $this->reader )
      {
        $this->reader->charData( $parser, $data );
      }
    }
  }
?>
