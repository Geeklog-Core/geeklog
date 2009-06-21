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


require_once( 'httpclient.php' );
require_once( 'oid_util.php' );
require_once( 'association.php' );
require_once( 'interface.php' );
require_once( 'oid_parse.php' );

class OpenIDConsumerHelper {

    // Do not escape anything that is already 7-bit safe, so we do the
    // minimal transform on the identity URL
    function quote_minimal($s) {
        $res = '';
        for( $i = 0; $i < strlen($s); $i++ ) {
            $c = $s{$i};
            if( ord($c) >= 0x80 ) {
                $enc_c = utf8_encode( $c );
                for( $j = 0; $j < strlen( $enc_c ); $j ++ ) {
                    $b = $enc_c{$j};
                    $res .= sprintf('%%%02X', ord($b));
                }
            }
            else {
                $res .= $c;
            }
        }
        return $res;
    }
    
    // From openID spec:
    // The delegate identity URL must be canonical. It will not be further 
    // processed by the consumer, so be sure it has the "http://" and trailing 
    // slash, if there's no path component.
    function normalize_url($url) {
        assert( 'is_string( $url )' );
        $url = trim( $url );
        
        // Note: we use parse_url() here rather than checking for http(s) because
        // possibly the url contains eg ftp:// and it would be silly to prepend
        // http:// to such a url.
        $parts = parse_url( $url );
        $scheme = isset( $parts['scheme'] ) ? $parts['scheme'] : null;

        if( !$scheme ) {
            $url = 'http://' . $url;
            // If no scheme was found, then path will contain the whole url, which is not what we want,
            // so we parse it again.
            $parts = parse_url( $url );
        }

        $path = isset( $parts['path'] ) ? $parts['path'] : null;
        
        if( !$path ) {
            $url .= '/';
        }
        
    
        // Porting Todo: handle unicode urls.
        /*
        if isinstance(url, unicode) {
            parsed = urlparse.urlparse(url)
            authority = parsed[1].encode('idna')
            tail = map(quote_minimal, parsed[2:])
            encoded = (str(parsed[0]), authority) + tuple(tail)
            url = urlparse.urlunparse(encoded)
            assert type(url) is str
        */
    
        return $url;
    }

};

class OpenIDConsumer {
    function OpenIDConsumer($http_client=null, $assoc_mngr=null) {
        $this->http_client = $http_client ? $http_client : HTTPClient::getHTTPClient();
        $this->assoc_mngr = $assoc_mngr ? $assoc_mngr : new DumbAssociationManager();
    }

    function handle_request($server_id, $server_url, $return_to,
                       $trust_root=null, $immediate=false,
                       $required_fields=null) {
        // Returns the url to redirect to, where server_id is the
        // identity url the server is checking and server_url is the url
        // of the openid server.
        $redir_args = array( 'openid.identity' => $server_id,
                             'openid.return_to' => $return_to );

        if( $trust_root ) {
            $redir_args['openid.trust_root'] = $trust_root;
        }

        if( $immediate ) {
            $mode = 'checkid_immediate';
        }
        else {
            $mode = 'checkid_setup';
        }

        $redir_args['openid.mode'] = $mode;

        if ($required_fields) {
            $redir_args['openid.sreg.required'] = $required_fields;
        }

        $assoc_handle = $this->assoc_mngr->associate($server_url);

        if( $assoc_handle ) {
            $redir_args['openid.assoc_handle'] = $assoc_handle;
        }
        
        return oidUtil::append_args($server_url, $redir_args);
    }

    function handle_response($req) {
        // Handles an OpenID GET request with openid.mode in the
        // arguments. req should be a Request instance, properly
        // initialized with the http arguments given, and the http method
        // used to make the request.

        // This method returns a subclass of
        // openid.interface.ConsumerResponse.  See the openid.interface
        // module for the list of subclasses possible.

        if( $req->http_method != 'GET' ) {
            $error = sprintf( 'Expected HTTP Method "GET", got %s', $req->get('http_method') );
            // raise ProtocolError( $error )
            trigger_error( $error, E_USER_ERROR );
        }
        $func = 'do_' . $req->get('mode');
        if( !method_exists( $this, $func ) ) {
            $error = sprintf( "Unknown Mode: %s", $req->get('mode') );
            // raise ProtocolError( $error )
            trigger_error( $error, E_USER_ERROR );
        }
        
        return $this->$func($req);
    }

    function find_identity_info($identity_url) {
        // Returns (consumer_id, server_id, server_url) or null if no
        // server found. Fetch url and parse openid.server and
        // potentially openid.delegate urls.  consumer_id is the identity
        // url the consumer should use.  It is the url after following
        // any redirects the url passed in might use.  server_id is the
        // url actually sent to the server to verify, and may be the
        // result of finding a delegate link.
        $url = OpenIDConsumerHelper::normalize_url($identity_url);
        
        $ret = $this->http_client->get($url);
        if( !$ret ) {
            return null;
        }

        list( $consumer_id, $data ) = $ret;
        
        $server = null;
        $delegate = null;
        $link_attrs = oidParse::parseLinkAttrs($data);
        foreach( $link_attrs as $attrs ) {
            $rel = isset( $attrs['rel'] ) ? $attrs['rel'] : null;
            if( $rel == 'openid.server' && !$server ) {
                $href = isset( $attrs['href'] ) ? $attrs['href'] : null;
                if( $href ) {
                    $server = $href;
                }
            }

            if( $rel == 'openid.delegate' && !$delegate ) {
                $href = isset( $attrs['href'] ) ? $attrs['href'] : null;
                if( $href ) {
                    $delegate = $href;
                }
            }
        }

        if( !$server ) {
            return null;
        }

        if( $delegate ) {
            $server_id = $delegate;
        }
        else {
            $server_id = $consumer_id;
        }

        return array( $consumer_id, $server_id, $server );
    }

    function create_return_to($url, $identity_url, $kwargs) {
        // Returns an return_to url, with required identity_url, and
        // optional args
        $kwargs['identity'] = $identity_url;
        return oidUtil::append_args($url, $kwargs);
    }

    function check_auth($server_url, $return_to, $post_data, $openid) {
        // This method is called to perform the openid.mode =
        // check_authentication call.  The identity argument should be
        // the identity url you are confirming (from the consumer's
        // viewpoint, ie. not a delegated identity).  The return_to and
        // post_data arguments should be as contained in the
        // CheckAuthRequired object returned by a previous call to
        // handle_response.

        if( !$this->verify_return_to($return_to) ) {
            return new InvalidLogin();
        }

        // This is *required* because of PHP changing "." to "_" in URL
        // argument attributes, but not in values. And here some items
        // of the signed field argument value should exactly match the
        // name of some attributes given in the same URL. Understood?!
        //  (Choplair)
        $post_data = str_replace('sreg_', 'sreg.', $post_data);

        $ret = $this->http_client->post($server_url, $post_data);
        if( !$ret ) {
            return new InvalidLogin();
        }

        $data = $ret[1];

        $results = oidUtil::parsekv($data);
        $is_valid = isset( $results['is_valid'] ) ? $results['is_valid'] : 'false';
        if( $is_valid == 'true' ) {
            $invalidate_handle = isset( $results['invalidate_handle'] ) ? $results['invalidate_handle'] : null;
            if( $invalidate_handle ) {
                $this->assoc_mngr->invalidate($server_url, $invalidate_handle);
            }

            parse_str( $post_data, $vars );
            error_log( "post_data: $post_data        " );
            error_log( serialize($vars) . "        " );
            $key = 'openid_identity';  // php replaces . with _
            
            $identity = isset( $vars[$key] ) ? $vars[$key] : null;
            $vl = new ValidLogin($this, $identity);
            if( $vl->verifyIdentity($openid) ) {
                return $vl;
            }
        }
        else {
            $error = isset( $results['openid.error'] ) ? $results['openid.error'] : null;
            if( $error ) {
                $str = sprintf( 'Server Response: %s', $error );
                return new ErrorFromServer( $str );
            }
        }

        return new InvalidLogin();
    }

    function do_id_res($req) {

        if( !$this->verify_return_to($req->get('return_to')) ) {
            return new InvalidLogin();
        }

        $user_setup_url = $req->get('user_setup_url');
        if( $user_setup_url ) {
            return new UserSetupNeeded($user_setup_url);
        }

        $server_url = $this->determine_server_url($req);

        $assoc = $this->assoc_mngr->get_association($server_url, $req->get('assoc_handle'));
        
        if( !$assoc ) {

            // No matching association found. I guess we're in dumb mode...
            $check_args = array();
            foreach( $req->args as $k => $v ) {
                if( oidUtil::startsWith($k, 'openid.') ) {
                    $check_args[$k] = $v;
                }
            }

            $check_args['openid.mode'] = 'check_authentication';

            $post_data = http_build_query( $check_args );
            return new CheckAuthRequired($server_url, $req->get('return_to'), $post_data);
        }

        // Check the signature
        $sig = $req->get('sig');
        $signed_fields = explode( ',', trim( $req->get('signed') ) );
        
        list( $_signed, $v_sig ) = oidUtil::sign_reply($req->args, $assoc->secret, $signed_fields);
        
        if( $v_sig != $sig ) {
            
            return new InvalidLogin();
        }

        $vl = new ValidLogin($this, $req->get('identity') );
        if( $vl->verifyIdentity($req->openid  ) ) {

            return $vl;
        }
        return new InvalidLogin();
    }

    function do_error($req) {
        $error = $req->get('error');
        if( !$error ) {
            $str = sprintf( 'Unspecified Server Error: %s', $req->toString() );
            return new ErrorFromServer( $str );
        }
        else {
            $str = sprintf( 'Server Response: %s', $error );
            return new ErrorFromServer($str);
        }
    }

    function do_cancel($unused_req) {
        return new UserCancelled();
    }


    // Callbacks
    function determine_server_url($req) {
        // Returns the url of the identity server for the identity in
        // the request.

        // Subclasses might extract the server_url from a cache or from a
        // signed parameter specified in the return_to url passed to
        // initialRequest.

        // The default implementation fetches the identity page again,
        // and parses the server url out of it.
        
        // Grab the server_url from the identity in args
        $ret = $this->find_identity_info($req->get('identity'));
        if( !$ret ) {
            $error = sprintf( 'ID URL %s seems not to be an OpenID identity.', $req->get('identity') );
            // raise ValueMismatchError( $error )
            trigger_error( $error, E_USER_ERROR );
        }

        list( $unused, $server_id, $server_url ) = $ret;
        if( $req->get('identity') != $server_id ) {
            $error = sprintf( 'ID URL %r seems to have moved: %s', $req->get('identity'), $server_id );
            // raise ValueMismatchError( $error )
            trigger_error( $error, E_USER_ERROR );
        }

        return $server_url;
    }

    function verify_return_to($return_to) {
        // This method is called before the consumer makes a
        // check_authentication call to the server.  It helps verify that
        // the request being authenticated is valid by confirming that
        // the openid.return_to value signed by the server corresponds to
        // this consumer.  The return value should be True if the
        // return_to field corresponds to this consumer, or false
        // otherwise.  This method must be overridden, as it has no
        // default implementation.
        trigger_error( 'unimplemented', E_USER_WARNING );
    }
    
};    
        
        
?>
