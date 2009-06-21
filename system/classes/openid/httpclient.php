<?php

/*****
PHP OpenID - OpenID consumer and server library

Copyright (C) 2005 Open Source Consulting, SA. and Dan Libby

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA

Reciprocal linking.  The author humbly requests that if you should use 
PHP-OpenID on your website to provide an OpenID enabled service that you 
place a link to the author's website ( http://videntity.org ) somewhere 
that your users can discover it.  You are however under no obligation to 
do so.  

More info about PHP OpenID:
openid@videntity.org
http://videntity.org/openid/

More info about OpenID:
http://www.openid.net

*****/


class HTTPClient {
    // Object used by Consumer to send http messages

    function get( $url) {
        // -->(final_url, data)
        // Fetch the content of url, following redirects, and return the
        // final url and page data as a tuple.  Return None on failure.

        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function post( $url, $body) {
        // -->(final_url, data)
        // Post the body string argument to url.
        // Reutrn the resulting final url and page data as a
        // tuple. Return None on failure.

        trigger_error( 'unimplemented', E_USER_WARNING );
    }
    
    // static
    function getHTTPClient() {

        // try to import find curl_init, which will let us use ParanoidHTTPClient
        if( function_exists( 'curl_init' ) ) {
            return new ParanoidHTTPClient();
        }
    
        return new SimpleHTTPClient();
    }
    
};



class SimpleHTTPClient extends HTTPClient {

    // var $user_agent = "Mozilla/4.0 (compatible; MSIE 5.5; Windows 98)";
    var $user_agent = "PHP-OpenID SimpleHTTPClient";
    var $ALLOWED_TIME = 20;   // seconds

    function _findRedirect( $headers) {
        foreach( $headers as $line ) {
            $loc = 'Location: ';
            if( substr( $line, 0, strlen($loc) ) == $loc ) {
                return trim( substr( $line, strlen($loc)-1 ) );
            }
        }
        return null;
    }


    function get( $url) {
    
        do {
            $stop = time() + $this->ALLOWED_TIME;
            $off = $this->ALLOWED_TIME;
        
            $parts = parse_url( $url );
            $scheme = isset( $parts['scheme'] ) ? $parts['scheme'] : null;
            $host = isset( $parts['host'] ) ? $parts['host'] : null;
            $port = isset( $parts['port'] ) ? $parts['port'] : ( $scheme == 'https' ? 443 : 80 );
            $path = isset( $parts['path'] ) ? $parts['path'] : null;
            $query = isset( $parts['query'] ) ? $parts['query'] : null;

            $uri = $path . ( $query ? '?' . $query : '' );
            
            // FIXME: perform some error checking on this URL.
            // See request at http://lists.danga.com/pipermail/yadis/2005-September/001401.html
            // Also, paranoidHttpClient should have a _checkURL method, so may
            // want to use same mechanism here.
        
            if( !in_array( $scheme, array( 'http', 'https' ) ) || !$host || !$port || !$uri ) {
                return null;
            }
            if( $scheme == 'https' ) {
                $host = 'ssl://' . $host;
            }
    
            $user_agent = $this->user_agent;
        	$headers = 
                "GET $path HTTP/1.0\r\n" .
                "User-Agent: $user_agent\r\n" .
                "Host: $host:$port\r\n" .
                "Port: $port\r\n" .
                "Cache-Control: no-cache\r\n" .
                "\r\n";
            
        	$fp = @fsockopen($host, $port, $errno, $errstr);
        	if (!$fp) {
        		return false;
        	}
    
        	fputs($fp, $headers);
        	
        	$data = '';
        	while (!feof($fp)) {
        		$data.= fgets($fp, 1024);
            }
                
        	fclose($fp);

            // Split response into header and body sections
            list($response_headers, $response_body) = explode("\r\n\r\n", $data, 2);
            $response_header_lines = explode("\r\n", $response_headers);

            $redir = false;
            if( strstr( $response_header_lines[0], '301') || strstr( $response_header_lines[0], '302') ) {
                $url = $this->_findRedirect($response_header_lines);
                $redir = true;
            }

            $off = $stop - time();
            
        } while( $redir && $off > 0 );
    	
    	return array( $url, $response_body );
    }
    
    // Simple function to post http data.
    // notes: 
    //   - handles both http and https
    //   - does not follow redirects
    function post($url, $body) {
    
    	$content_length = $this->strlen_bytes($body);
        $accept = '*/*';

        $parts = parse_url( $url );
        $scheme = isset( $parts['scheme'] ) ? $parts['scheme'] : null;
        $host = isset( $parts['host'] ) ? $parts['host'] : null;
        $port = isset( $parts['port'] ) ? $parts['port'] : ( $scheme == 'https' ? 443 : 80 );
    
        if( !in_array( $scheme, array( 'http', 'https' ) ) || !$host || !$port ) {
            return null;
        }
        if( $scheme == 'https' ) {
            $host = 'ssl://' . $host;
        }

        $user_agent = $this->user_agent;
    	$headers = 
            "POST $url HTTP/1.0\r\n" .
            "Accept: $accept\r\n" .
            "Content-Type: application/x-www-form-urlencoded\r\n" .
            "User-Agent: $user_agent\r\n" .
            "Host: $host:$port\r\n" .
            "Cache-Control: no-cache\r\n" .
            "Content-Length: $content_length\r\n" .
            "\r\n";
        
    	$fp = fsockopen($host, $port, $errno, $errstr);
    	if (!$fp) {
    		return false;
    	}
    
    	fputs($fp, $headers);
    	fputs($fp, $body);
    	
    	$data = '';
    	while (!feof($fp)) {
    		$data.= @fgets($fp, 1024);
        }
            
    	fclose($fp);
        
        // Split response into header and body sections
        list($response_headers, $response_body) = explode("\r\n\r\n", $data, 2);
        $response_header_lines = explode("\r\n", $response_headers);
    	
    	return array( $url, $response_body );
    }    

    // static
    function strlen_bytes( $str ) {
        // if mb_* are in effect, there is a good chance $this->strlen_bytes is shadowed to return
        // mb_$this->strlen_bytes, which can give incorrect byte count.  so we force mb_$this->strlen_bytes to give us latin1 count.
        return function_exists('mb_strlen') ? mb_strlen($str, 'latin1') : strlen($str);
    }

};
    

class ParanoidHTTPClient extends HTTPClient {
    // A paranoid HTTPClient that uses curl for fecthing.
    // See http://php.net/curl
    var $ALLOWED_TIME = 20;   // seconds
    
    var $headers;

    function ParanoidHTTPClient() {
    }

    function _findRedirect( $headers) {
        foreach( $headers as $line ) {
            $loc = 'Location: ';
            if( substr( $line, strlen($loc) ) == $loc ) {
                return trim( substr( $line, strlen($loc)-1 ) );
            }
        }
        return null;
    }


    function _checkURL( $url) {
        // TODO: make sure url is welformed and route-able
        //       ie. the Paranoid part.
        return true;
    }
    

    function get( $url) {
    
        $retval = null;
        
        $c = curl_init( $url );
        
        if( $c ) {
            // CURLOPT_NOSIGNAL was added in php 5.
            if( defined( 'CURLOPT_NOSIGNAL' ) ) {
                curl_setopt( $c, CURLOPT_NOSIGNAL, true);
            }

            curl_setopt( $c, CURLOPT_RETURNTRANSFER, true);
            curl_setopt( $c, CURLOPT_HEADER, true);

            $stop = time() + $this->ALLOWED_TIME;
            $off = $this->ALLOWED_TIME;
            
            while( $off > 0 ) {
                
                if( !$this->_checkURL($url) ) {
                    break;
                }
                
                curl_setopt( $c, CURLOPT_URL, $url);
                curl_setopt( $c, CURLOPT_TIMEOUT, $off );

                $response_full = curl_exec( $c );
                if( !$response_full ) {
                    break;
                }
                // Split response into header and body sections
                list($response_headers, $response_body) = explode("\r\n\r\n", $response_full, 2);
                $response_header_lines = explode("\r\n", $response_headers);

                $code = curl_getinfo( $c, CURLINFO_HTTP_CODE );
                if( in_array( $code, array(301, 302) ) ) {
                    $url = $this->_findRedirect($response_header_lines);
                }
                else {
                    $retval = array( $url, $response_body );
                    break;
                }

                $off = $stop - time();
            }
            
            curl_close( $c );

        }
        return $retval;
    }

    function post( $url, $body) {
        $retval = null;
    
        if( !$this->_checkURL($url) ) {
            return null;
        }

        $c = curl_init( $url );
        
        if( $c ) {
            // CURLOPT_NOSIGNAL was added in php 5.
            if( defined( 'CURLOPT_NOSIGNAL' ) ) {
                curl_setopt( $c, CURLOPT_NOSIGNAL, true);
            }
            curl_setopt( $c, CURLOPT_POST, true);
            curl_setopt( $c, CURLOPT_POSTFIELDS, $body);
            curl_setopt( $c, CURLOPT_TIMEOUT, $this->ALLOWED_TIME);
            curl_setopt( $c, CURLOPT_URL, $url);
            curl_setopt( $c, CURLOPT_RETURNTRANSFER, true);

            $data = curl_exec( $c );
            
            curl_close( $c );
            
            if( $data ) {
                $retval = array( $url, $data );
            }
        }
        return $retval;
    }
            
    
    // static        
    function startsWith( $str, $sub ) {
       return ( substr( $str, 0, strlen( $sub ) ) == $sub );
    }
};

function _oid_httpclient_test() {

    $url_get = 'http://www.google.com';

    $c1 = new SimpleHttpClient();
    $response = $c1->get( $url_get );
    if( $response ) {
        list( $url, $data ) = $response;
        echo $data ;
    }
    else {
        echo "test 1 failed";
    }

}

if( strstr( $_SERVER['REQUEST_URI'], 'httpclient.php' ) ) {
    _oid_httpclient_test();
}
            
            
?>
