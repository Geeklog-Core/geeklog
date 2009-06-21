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


define( '_oid_top_level_domains_list', <<< END
com|edu|gov|int|mil|net|org|biz|info|name|museum|coop|aero|ac|ad|ae|
af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|bj|
bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|
cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|fi|fj|fk|fm|fo|
fr|ga|gd|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|
ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|
kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mk|ml|mm|
mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|
nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|ru|rw|sa|
sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|sv|sy|sz|tc|td|tf|tg|th|
tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|
vn|vu|wf|ws|ye|yt|yu|za|zm|zw|localhost
END
);
define( '_oid_protocol_list', 'http|https');

class TrustRoot {
    // Represents a valid openid trust root.  The parse classmethod
    // accepts a trust root string, producing a TrustRoot object.
    
    var $_protocols;
    var $_top_level_domains;
    
    function TrustRoot($unparsed, $proto, $wildcard, $host, $port, $path) {
    
        $this->_top_level_domains = explode( '|', _oid_top_level_domains_list );
        $this->_protocols = explode( '|', _oid_protocol_list );
    
        $this->unparsed = $unparsed;
        $this->proto = $proto;
        $this->wildcard = $wildcard;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;

        $this->_is_sane = null;
    }

    function isSane() {
        // Checks the sanity of this trust root.
        // http://*.com/ for example is not sane.  Returns a bool.
        
        if( $this->_is_sane ) {
            return $this->_is_sane;
        }

        if( $this->host == 'localhost') {
            return true;
        }

        $host_parts = explode( '.', $this->host );

        // extract sane "top-level-domain
        //
        // porting note:  this is a very python-ish way of doing things.
        $host = array();
        $cnt = count( $host_parts );
        if( strlen($host_parts[$cnt-1]) == 2) {
            if( $cnt > 1 && strlen($host_parts[$cnt-1]) <= 3) {
                $host = array_slice( $host_parts, 0, $cnt-2);
            }
        }
        else if( strlen($host_parts[$cnt-1]) == 3) {
            $host = array_slice( $host_parts, 0, $cnt-1);
        }

        $this->_is_sane = count($host) ? true : false;
        return $this->_is_sane;
    }

    function validateURL($url) {
        // Validates a URL against this trust root.  Returns a bool

        if( !$this->isSane()) {
            return false;
        }

        // porting note:  PHP's parse_url() is not intended for url validation.
        $url_parts = parse_url($url);
        if( !$url_parts || !count( $url_parts ) ) {
            return false;
        }
        
        $proto = isset( $url_parts['scheme'] ) ? $url_parts['scheme'] : null;
        $host = isset( $url_parts['host'] ) ? $url_parts['host'] : null;
        $port = isset( $url_parts['port'] ) ? $url_parts['port'] : null;
        $path = isset( $url_parts['path'] ) ? $url_parts['path'] : null;

        if( $proto != $this->proto) {
            return false;
        }

        if( $port != $this->port) {
            return false;
        }

        $arr1 = explode( '?', $path, 1);
        $arr2 = explode( '?', $this->path, 1);
        
        if( !$this->startswith( $arr1[0], $arr2[0]) ) {
            return false;
        }

        if( !$this->wildcard) {
            return $host == $this->host;
        }
        else {
            return $this->endsWith( $host, $this->host );
        }
    }

    // static
    function parse($trust_root, $check_sanity=false) {
        if( !is_string($trust_root) ) {
            return null;
        }

        // porting note:  PHP's parse_url() is not intended for url validation.
        $url_parts = parse_url($trust_root);
        if( !$url_parts || !count( $url_parts ) ) {
            return false;
        }
        
        $proto = isset( $url_parts['scheme'] ) ? $url_parts['scheme'] : null;
        $host = isset( $url_parts['host'] ) ? $url_parts['host'] : null;
        $port = isset( $url_parts['port'] ) ? $url_parts['port'] : null;
        $path = isset( $url_parts['path'] ) ? $url_parts['path'] : null;

        // check for valid prototype
        $protocols = explode( '|', _oid_protocol_list );
        if( !in_array( $proto, $protocols) ) {
            return null;
        }

        // extract wildcard if it is there
        if( strchr( $host,  '*')) {
            // wildcard must be at start of domain) {  *.foo.com, not foo.*.com
            if( ! TrustRoot::startsWith( $host, '*') ) {
                return null;
            }

            // there should also be a '.' ala *.schtuff.com
            if( $host[1] != '.') {
                return null;
            }
            
            $host = substr( $host, 2 );
            $wilcard = true;
        }
        else {
            $wilcard = false;
        }
        
        // at least needs to end in a top-level-domain
        $ends_in_tld = false;
        $_top_level_domains = explode( '|', _oid_top_level_domains_list );
        
        foreach( $_top_level_domains as $tld ) {
            if( TrustRoot::endsWith($host, $tld) ) {
                $ends_in_tld = true;
                break;
            }
        }

        if( !$ends_in_tld) {
            return null;
        }

        // we have a valid trust root
        $tr = new TrustRoot($trust_root, $proto, $wilcard, $host, $port, $path);
        if( $check_sanity) {
            if( !$tr->isSane() ) {
                return null;
            }
        }

        return $tr;
    }

    // static
    function checkSanity($trust_root_string) {
        // str -> bool

        // is this a sane trust root?
        $tr = TrustRoot::parse($trust_root_string);
        return $tr->isSane();
    }

    // static
    function checkURL($trust_root, $url) {
        // quick func for validating a url against a trust root.  See the
        // TrustRoot class if you need more control.
        
        $tr = TrustRoot::parse($trust_root, true);
        return $tr && $tr->validateURL($url);
    }

    function toString() {
        return sprintf( "TrustRoot('%s', '%s', '%s', '%s', '%s', '%s')",
            $this->unparsed, $this->proto, $this->wildcard, $this->host, $this->port,
            $this->path);
    }

    function startsWith( $str, $sub ) {
       return ( substr( $str, 0, strlen( $sub ) ) == $sub );
    }
    
    // return tru if $str ends with $sub
    function endsWith( $str, $sub ) {
       $len1 = strlen( $str );
       $len2 = strlen( $sub );
       return $len1 >= $len2 && ( substr( $str, $len1 - $len2 ) == $sub );
    }        
};


function _oid_trustroot_test() {
    print 'Testing...';

    // test invalid trust root strings
    function assertBad($s) {
        $tr = TrustRoot::parse($s);
        assert( '$tr == null' );
        if( $tr != null ) {
            echo $tr->toString() . '<br' . XHTML . '>';
            exit;
        }
    }

    assertBad('baz.org');
    assertBad('*.foo.com');
    assertBad('ftp://foo.com');
    assertBad('ftp://*.foo.com');
    assertBad('http://*.foo.notatld');
    assertBad('http://*.foo.com:80:90/');
    assertBad('');
    assertBad(' ');
    assertBad(' \t\n ');
    assertBad(null);
    assertBad(5);

    // test valid trust root string
    function assertGood($s) {
        $tr = TrustRoot::parse($s);
        assert( '$tr != null' );
        if( $tr == null ) {
            echo $tr->toString() . '<br' . XHTML . '>';
            exit;
        }
    }

    assertGood('http://*.schtuff.com/');
    assertGood('http://*.schtuff.com');
    assertGood('http://www.schtuff.com/');
    assertGood('http://www.schtuff.com');
    assertGood('http://*.this.that.schtuff.com/');
    assertGood('http://*.com/');
    assertGood('http://*.com');
    assertGood('http://*.foo.com/path');
    assertGood('http://x.foo.com/path?action=foo2');
    assertGood('http://*.foo.com/path?action=foo2');
    assertGood('http://localhost:8081/');

    function assertSane($s, $truth) {
        $tr = TrustRoot::parse($s);
        $isSane = $tr->isSane();
        assert( '$isSane == $truth' );
        
        if( $isSane != $truth ) {
            echo "$isSane, $truth<br" . XHTML . ">";
            exit;
        }
    }


    assertSane('http://*.schtuff.com/', true);
    assertSane('http://*.foo.schtuff.com/', true);
    assertSane('http://*.com/', false);
    assertSane('http://*.com.au/', false);
    assertSane('http://*.co.uk/', false);
    assertSane('http://localhost:8082/?action=openid', true);
    assertSane('http://greg.abstrakt.ch', true);

    // XXX: what exactly is a sane trust root?
    // assertSane('http) {//*.k12.va.us/', false)

    // validate a url against a trust root
    function assertValid($trust_root, $url, $truth) {
        $tr = TrustRoot::parse($trust_root);
        $isSane = $tr->isSane();
        $isValid = $tr->validateURL($url);
        assert( '$isSane' );
        if( !$isSane ) {
            exit;
        }
        assert( '$isValid == $truth' );
        if( $isValid != $truth ) {
            exit;
        }
    }
        

    assertValid('http://*.foo.com', 'http://b.foo.com', true);
    assertValid('http://*.foo.com', 'http://hat.baz.foo.com', true);
    assertValid('http://*.foo.com', 'http://b.foo.com', true);
    assertValid('http://*.b.foo.com', 'http://b.foo.com', true);
    assertValid('http://*.b.foo.com', 'http://x.b.foo.com', true);
    assertValid('http://*.bar.co.uk', 'http://www.bar.co.uk', true);
    assertValid('http://*.uoregon.edu', 'http://*.cs.uoregon.edu', true);

    assertValid('http://*.cs.uoregon.edu', 'http://*.uoregon.edu', false);
    assertValid('http://*.foo.com', 'http://bar.com', false);
    assertValid('http://*.foo.com', 'http://www.bar.com', false);
    assertValid('http://*.bar.co.uk', 'http://xxx.co.uk', false);

    // path validity
    assertValid('http://x.com/abc', 'http://x.com/', false);
    assertValid('http://x.com/abc', 'http://x.com/a', false);
    assertValid('http://*.x.com/abc', 'http://foo.x.com/abc', true);
    assertValid('http://*.x.com/abc', 'http://foo.x.com', false);
    assertValid('http://*.x.com', 'http://foo.x.com/gallery', true);
    assertValid('http://foo.x.com', 'http://foo.x.com/gallery', true);
    assertValid('http://foo.x.com/gallery', 'http://foo.x.com/gallery/xxx', true);
    assertValid('http://localhost:8081/x?action=openid',
                'http://localhost:8081/x?action=openid', true);
    assertValid('http://*.x.com/gallery', 'http://foo.x.com/gallery', true);

    assertValid('http://localhost:8082/?action=openid',
                'http://localhost:8082/?action=openid', true);
    assertValid('http://goathack.livejournal.org:8020/',
                'http://goathack.livejournal.org:8020/openid/login.bml', true);

    print 'All tests passed!';
}

if( strstr( $_SERVER['REQUEST_URI'], 'trustroot.php' ) ) {
    _oid_trustroot_test();
}
    
?>
