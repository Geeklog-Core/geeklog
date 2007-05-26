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


require_once( 'oid_util.php' );
require_once( 'interface.php' );
require_once( 'trustroot.php' );


define( '_oid_authentication_error', -1);

class OpenIDServer {

    function OpenIDServer($internal_store, $external_store, $srand=null) {
        // srand should be a cryptographic-quality source of random
        // bytes, if Diffie-Helman secret exchange is to be supported.
        // On systems where it is available, an instance of
        // random.SystemRandom is a good choice.
        $this->istore = $internal_store;
        $this->estore = $external_store;
        $this->srand = $srand;
    }

    function handle($req) {
        // Handles an OpenID request.  req should be a Request
        // instance, properly initialized with the http arguments given,
        // and the method used to make the request.  Returns a Response
        // instance with the necessary fields set to indicate the
        // appropriate action.

        $method_name = 'do_' . $req->get('mode');
        
        if( !method_exists( $this, $method_name ) ) {
            $error = sprintf('Unsupported openid.mode: %s', $req->get('mode') );

            $return_to = $req->get( 'return_to' );
            if( $req->get( 'http_method' ) == 'GET' && $return_to ) {
                return redirect( oidUtil::append_args(return_to, $edict));
            }
            else {
                return OpenIDServer::_error_page( $error );
            }
        }
        
        return $this->$method_name($req);
    }

    function do_associate($req) {
        // Performs the actions needed for openid.mode=associate.  If
        // srand was provided when constructing this server instance,
        // this method supports the DH-SHA1 openid.session_type when
        // requested.  This function requires that $this->get_new_secret be
        // overriden to function properly.  Returns a Response object
        // indicating what should be sent back to the consumer.
        $reply = array();
        $assoc_type = $req->get('openid.assoc_type', 'HMAC-SHA1');
        $assoc = $this->estore->get($assoc_type);

        $session_type = $req->get('session_type');
        if( $session_type ) {
            if( $session_type == 'DH-SHA1' ) {
                $p = $req->get('dh_modulus');
                $g = $req->get('dh_gen');
                
                $dh = DiffieHellman::fromBase64($p, $g, $this->srand);
                
                $cpub = oidUtil::a2long( oidUtil::from_b64($req->get( 'dh_consumer_public' )) );

                $dh_shared = $dh->decryptKeyExchange($cpub);

                $mac_key = oidUtil::strxor( $assoc->secret, oidUtil::sha1( oidUtil::long2a($dh_shared) ));

                $spub = $dh->createKeyExchange();

                $reply['session_type'] = $session_type;
                $reply['dh_server_public'] = oidUtil::to_b64(oidUtil::long2a($spub));
                $reply['enc_mac_key'] = oidUtil::to_b64($mac_key);
                
                // error_log( "assoc.secret: " . $assoc->secret );
                // error_log( "dh_server_public: " . $reply['dh_server_public'] );
                // error_log( "dh_server_public_raw: " . $spub );
                // error_log( "enc_mac_key: " . $reply['enc_mac_key'] );
                
            }
            else {
                // raise ProtocolError('session_type must be DH-SHA1');
                $error = 'session_type must be DH-SHA1';
                return OpenIDServer::_error_page( $error );
            }
        }
        else {
            $reply['mac_key'] = oidUtil::to_b64($assoc->secret);
        }

        $reply['assoc_type'] = $assoc_type;
        $reply['assoc_handle'] = $assoc->handle;
        $reply['expires_in'] = $assoc->get_expires_in();
        
        return response_page(oidUtil::kvform($reply));
    }

    function do_checkid_immediate($req) {
    /*
        try:
            return $this->checkid(req)
        except AuthenticationError:
            user_setup_url = $this->get_user_setup_url(req)
            reply = {
                'openid.mode': 'id_res',
                'openid.user_setup_url': user_setup_url,
                }
            return redirect(append_args(req.return_to, reply))
     */
     
        $rc = $this->checkid($req);
        if( is_int($rc) && $rc == _oid_authentication_error ) {
            $user_setup_url = $this->get_user_setup_url($req);
            $reply = array(
                'openid.mode' => 'id_res',
                'openid.user_setup_url' => $user_setup_url
            );
            return redirect(oidUtil::append_args($req->get( 'return_to' ), $reply));
        }
        return $rc;
    }
            
     

    function do_checkid_setup($req) {
    /*
        try:
            return $this->checkid(req)
        except AuthenticationError:
            return $this->get_setup_response(req)
     */
     
        $rc = $this->checkid($req);
        if( is_int( $rc ) && $rc == _oid_authentication_error ) {
            return $this->get_setup_response($req);
        }
        return $rc;
    }

    // errors:
    //   _oid_authentication_error
    function checkid($req) {
        // This function does the logic for the checkid functions.
        // Since the only difference in behavior between them is how
        // authentication errors are handled, this does all logic for
        // dealing with successful authentication, and raises an
        // exception for its caller to handle on a failed authentication.
        
        $tr = TrustRoot::parse($req->get('trust_root') );
        if( !$tr ) {
            //raise ProtocolError('Malformed trust_root: %s' % req.trust_root)
            $error = sprintf('Malformed trust_root: %s', $req->get('trust_root'));
            return OpenIDServer::_error_page( $error );
        }

        if( !$tr->isSane() ) {
            // raise ProtocolError('trust_root %r makes no sense' % req.trust_root)
            $error = sprintf( 'trust_root %s makes no sense', $req->get('trust_root'));
            return OpenIDServer::_error_page( $error );
        }

        if( !$tr->validateURL($req->get('return_to')) ) {
        //    raise ProtocolError('url(%s) not valid against trust_root(%s)' % (
        //        req.return_to, req.trust_root))
            $error = sprintf( 'url(%s) not valid against trust_root(%s)', $req->get('return_to'), $req->get('trust_root'));
            return OpenIDServer::_error_page( $error );
        }

        if( !$this->is_valid($req) ) {
            // raise AuthenticationError
            return _oid_authentication_error;
        }

        $reply = array(
            'openid.mode' => 'id_res',
            'openid.return_to' => $req->get('return_to'),
            'openid.identity' => $req->get('identity')
        );

        $assoc_handle = $req->get('assoc_handle');
        if( $assoc_handle ) {
            $assoc = $this->estore->lookup($assoc_handle, 'HMAC-SHA1');

            // fall back to dumb mode if assoc_handle not found,
            // and send the consumer an invalidate_handle message
            if( !$assoc || $assoc->get_expires_in() <= 0 ) {
                if( $assoc && $assoc->get_expires_in() <= 0 ) {
                    $this->estore->remove($assoc->handle);
                }
                $assoc = $this->istore->get('HMAC-SHA1');
                $reply['openid.invalidate_handle'] = $assoc_handle;
            }
        }
        else {
            $assoc = $this->istore->get('HMAC-SHA1');
        }

        $reply['openid.assoc_handle'] = $assoc->handle;

        $_signed_fields = array('mode', 'identity', 'return_to');

        list( $signed, $sig ) = oidUtil::sign_reply($reply, $assoc->secret, $_signed_fields );

        $reply['openid.signed'] = $signed;
        $reply['openid.sig'] = $sig;
        
        return redirect(oidUtil::append_args($req->get('return_to'), $reply));
    }

    function do_check_authentication($req) {
    
        $handle = $req->get('assoc_handle');
    
        // Last step in dumb mode
        $assoc = $this->istore->lookup($req->get('assoc_handle'), 'HMAC-SHA1');

        if( !$assoc ) {
            // raise ProtocolError('no secret found for %r' % req.assoc_handle)
            $error = sprintf( 'no secret found for %r', $req->get('assoc_handle') );
            // trigger_error( $error, $E_USER_WARNING );
            
            return OpenIDServer::_error_page( $error );
        }

        $reply = array();
        if( $assoc->get_expires_in() > 0 ) {
            $token = $req->args;
            $token['openid.mode'] = 'id_res';

            $signed_fields = explode(',', trim($req->get('signed')));
            list( $ignore, $v_sig ) = oidUtil::sign_reply($token, $assoc->secret, $signed_fields);

            if( $v_sig == $req->get('sig') ) {
                $is_valid = 'true';

                // if an invalidate_handle request is present, verify it
                $invalidate_handle = $req->get('invalidate_handle');
                if( $invalidate_handle ) {
                    if( !$this->estore->lookup($invalidate_handle, 'HMAC-SHA1') ) {
                        $reply['invalidate_handle'] = $invalidate_handle;
                    }
                }
            }
            else {
            
                $is_valid = 'false';
            }
        }

        else {
        
            $this->istore->remove($req->get('assoc_handle'));
            $is_valid = 'false';
        }

        $reply['is_valid'] = $is_valid;
        return response_page(oidUtil::kvform($reply));
    }
    
    // private
    function _error_page( $error ) {
    
        $edict = array(
            'openid.mode' => 'error',
            'openid.error' => $error
        );

        return error_page(oidUtil::kvform($edict));
    }
    

    // Callbacks:
    function is_valid($req) {
        // If a valid authentication is supplied as part of the
        // request, and allows the given trust_root to authenticate the
        // identity url, this returns True.  Otherwise, it returns False.
        
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function get_user_setup_url($req) {
        // If an identity has failed to authenticate for a given
        // trust_root in immediate mode, this is called.  It returns the
        // URL to include as the user_setup_url in the redirect sent to
        // the consumer.
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function get_setup_response($req) {
        // If an identity has failed to authenticate for a given
        // trust_root in setup mode, this is called.  It returns a
        // Response object containing either a page to draw or a redirect
        // to issue.
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

};

?>
