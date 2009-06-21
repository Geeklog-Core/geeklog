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


class ServerResponse {

    var $code;
    var $content_type;
    var $body;
    var $redirect_url;

    function ServerResponse( $vars ) {
    
        $attrs = array( 'code', 'content_type', 'body', 'redirect_url' );
        foreach( $attrs as $attr ) {
        
            if( isset( $vars[$attr] ) ) {
                $this->$attr = $vars[$attr];
            }
        }
    }

};

    
function redirect( $url ) {
    return new ServerResponse( array( 'code'=>302, 'redirect_url'=>$url) );
}

function response_page( $body ) {
    return new ServerResponse( array( 'code'=>200, 'content_type'=>'text/plain', 'body'=>$body) );
}

function error_page( $body ) {
    return new ServerResponse( array( 'code'=>400, 'content_type'=>'text/plain', 'body'=>$body) );
}




class ConsumerResponse {
    // This is a superclass to provide type unification for all the
    // various responses the consumer library can provide after
    // interpreting an openid query.

    // A Visitor pattern interface for dispatching to the various
    // subclasses is provided for users of the library who wish to use
    // it.
    function doAction( $handler ) {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }
};    
        

class ActionHandler {

    function doValidLogin($login) {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function doInvalidLogin() {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function doUserCancelled() {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function doCheckAuthRequired($server_url, $return_to, $post_data) {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function doErrorFromServer($message) {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function createReturnTo($base_url, $identity_url, $args) {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function getOpenID() {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }
};

class ValidLogin extends ConsumerResponse {
    // This subclass is used when the login succeeded.  The identity
    // parameter is the value that the id server has confirmed.

    // This method passes itself into its visitor pattern implementation.
    // This is so that its verifyIdentity method can be used in the
    // handler funtion.
    function ValidLogin($consumer, $identity) {
        $this->consumer = $consumer;
        $this->identity = $identity;
    }

    function doAction($handler) {
        return $handler->doValidLogin($this);
    }

    function verifyIdentity($identity) {
        // This method verifies that the identity passed in is one
        // that this response is actually claiming is valid.  It takes
        // care of checking if the identity url that the server actually
        // verified is delegated to by the identity passed in, if such a
        // check is needed.  Returns True if the identity passed in was
        // authenticated by the server, False otherwise.
error_log( "id: $identity       this_id: " . $this->identity . '      ' );        
        if( $identity == $this->identity ) {
            return true;
        }

        $ret = $this->consumer->find_identity_info($identity);
        if( !$ret ) {
            return false;
        }

        return $ret[1] == $this->identity;
    }
};    

class InvalidLogin extends ConsumerResponse {
    // This subclass is used when the login wasn't valid.
    function doAction($handler) {
        return $handler->doInvalidLogin();
    }
};        

class UserCancelled extends ConsumerResponse {
    // This subclass is used when the user cancelled the login.
    function doAction($handler) {
        return $handler->doUserCancelled();
    }
};    

class UserSetupNeeded extends ConsumerResponse {
    // This subclass is used when the UA needs to be sent to the given
    // user_setup_url to complete their login.
    function UserSetupNeeded($user_setup_url) {
        $this->user_setup_url = $user_setup_url;
    }

    function doAction($handler) {
        return $handler->doUserSetupNeeded($this->user_setup_url);
    }
};    

class ErrorFromServer extends ConsumerResponse {
    // This subclass is used
    function ErrorFromServer($message) {
        $this->message = $message;
    }

    function doAction($handler) {
        return $handler->doErrorFromServer($this->message);
    }
};    

class CheckAuthRequired extends ConsumerResponse {
    function CheckAuthRequired($server_url, $return_to, $post_data) {
        $this->server_url = $server_url;
        $this->return_to = $return_to;
        $this->post_data = $post_data;
    }

    function doAction($handler) {
        return $handler->doCheckAuthRequired(
            $this->server_url, $this->return_to, $this->post_data);
    }
};    


class Request {
    var $args;

    function Request($args, $http_method, $authentication=null) {
        // Creates a new Request object, used by both the consumer and
        // server APIs.  args should be an array map of http arguments,
        // whether via post or GET request.  http_method should be set to
        // either POST or GET, indicating how this request was made.
        //
        // authentication is a field that isn't used by any library code,
        // but exists purely as a pass-through, so that users of the
        // server library can verify that a given request has whatever
        // authentication credentials are needed to allow it correctly
        // calculate the return from get_auth_range.  A typical value of
        // the authentication field would be the username of the
        // logged-in user making the http request from the server.
        //
        // If an instance of this is created without any openid.* arguments,
        // a NoOpenIDArgs warning is raised.
        $this->args = array();
        $this->http_method = strtoupper($http_method);
        $this->authentication = $authentication;

        $found = false;
        foreach( $args as $k => $v ) {
            $needle = 'openid_';
            if( substr( $k, 0, strlen($needle)) == $needle ) {
                $found = true;
                $k = str_replace( $needle, 'openid.', $k );
            }
            $this->args[$k] = $v;
        }
        if( !$found ) {
            trigger_error( 'NoOpenIDArgs', E_USER_WARNING );
        }
    }

    function get($key, $default=null) {
        $k = 'openid.' . $key;
        return isset( $this->args[$k] ) ? $this->args[$k] : $default;
    }

/*
    function __getattr__(attr) {
        if attr[0] == '_':
            raise AttributeError

        val = $this->get(attr)
        if val is None:
            if attr == 'trust_root':
                return $this->return_to
            else:
                raise ProtocolError('Query argument %r not found' % (attr,))

        return val
  */
  
    function get_by_full_key($key, $default=null) {
        return $this->get($key, $default);
    }
    
    function toString() {
        $s = '';
        foreach( $this->args as $k => $v ) {
            $s .= "$k => $v\n";
        }
        return $s;
    }
};    

class ConsumerRequest extends Request {

    function ConsumerRequest($openid, $args, $http_method, $authentication=null) {
        parent::Request($args, $http_method, $authentication);
        $this->openid = $openid;
    }
};
        
?>
