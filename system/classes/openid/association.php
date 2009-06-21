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

class Association {
    // static
    function from_expires_in( $handle, $secret, $expires_in ) {
        return new Association( $handle, $secret, time(), $expires_in );
    }

    function Association($handle, $secret, $issued, $lifetime) {
        $this->handle = $handle;
        $this->secret = $secret;
        $this->issued = (int)$issued;
        $this->lifetime = (int)$lifetime;
    }

    function get_expires_in() {
        return max(0, $this->issued + $this->lifetime - time());
    }

    // expires_in = property(get_expires_in)
};

class ConsumerAssociation extends Association {

    // static
    function from_expires_in( $expires_in, $server_url, $handle, $secret ) {
        return new ConsumerAssociation( $server_url, $handle, $secret, time(), $expires_in );
    }

    function ConsumerAssociation($server_url, $handle, $secret, $issued, $lifetime) {
        parent::Association( $handle, $secret, $issued, $lifetime );
        $this->server_url = $server_url;
    }
};        


class ConsumerAssociationManager {
    // Base class for type unification of Association Managers.  Most
    // implementations of this should extend the BaseAssociationManager
    // class below.
    function get_association($server_url, $assoc_handle) {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }
    
    function associate($server_url) {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }
    
    function invalidate($server_url, $assoc_handle) {
        trigger_error( 'unimplemented', E_USER_WARNING );
    }
}    


class DumbAssociationManager extends ConsumerAssociationManager {
    // Using this class will cause a consumer to behave in dumb mode.
    function get_association($server_url, $assoc_handle) {
        return null;
    }
    
    function associate($server_url) {
        return null;
    }
    
    function invalidate($server_url, $assoc_handle) {
        return;
    }
};

class AbstractConsumerAssociationManager extends ConsumerAssociationManager {
    // Abstract base class for association manager implementations.

    function AbstractConsumerAssociationManager($associator) {
        $this->associator = $associator;
    }

    function associate($server_url) {
        // Returns assoc_handle associated with server_url
        $expired = array();
        $assoc = null;
        $all = $this->get_all($server_url);
        foreach( $all as $current) {
            if( $current->get_expires_in() <= 0 ) {
                $expired[] = $current;
            }
            else if( !$assoc || $current->get_expires_in() > $assoc->get_expires_in() ) {
                $assoc = $current;
            }
        }

        $new_assoc = null;
        if( !$assoc ) {
            $assoc = $new_assoc = $this->associator->associate($server_url);
        }

        // print "assoc.secret:"
        // print to_b64(assoc.secret)
        if( $new_assoc || $expired ) {
            $this->update($new_assoc, $expired);
        }

        return $assoc->handle;
    }

    function get_association($server_url, $assoc_handle) {
        // Find the secret matching server_url and assoc_handle
        $associations = $this->get_all($server_url);
        foreach( $associations as $assoc ) {
            if( $assoc->handle == $assoc_handle ) {
                return $assoc;
            }
        }

        return null;
    }

    // Subclass need to implement the following methods:
    function update($new_assoc, $expired) {
        // new_assoc is either a new association object or None.
        // Expired is a possibly empty list of expired associations.
        // Subclasses should add new_assoc if it is not None and expire
        // each association in the expired list.
        trigger_error( 'unimplemented', E_USER_WARNING );
    }
    
    function get_all($server_url) {
        // Subclasses should return a list of ConsumerAssociation
        // objects whose server_url attribute is equal to server_url.
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function invalidate($server_url, $assoc_handle) {
        // Subclasses should remove the ConsumerAssociation for the
        // given server_url and assoc_handle from their stores.
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

};


class DiffieHelmanAssociator {
    function DiffieHelmanAssociator($http_client, $srand=null) {
        $this->http_client = $http_client;
        $this->srand = $srand;
    }

    function get_mod_gen() {
        // -> (modulus, generator) for Diffie-Helman

        // override this function to use different values
        $dh = new DiffieHellman();
        return array( $dh->DEFAULT_MOD, $dh->DEFAULT_GEN);
    }
    
    function getResult( $results, $key ) {
    
        if( !isset( $results[$key] ) ) {
            trigger_error( sprintf( 'protocol error : Association server response missing argument %s', $key ), E_USER_WARNING );
            return null;
        }
        return $results[$key];
    }

    function associate($server_url) {
        list( $p, $g ) = $this->get_mod_gen();
        $dh = new DiffieHellman($p, $g, $this->srand);
        $cpub = $dh->createKeyExchange();

        $args = array(
            'openid.mode' => 'associate',
            'openid.assoc_type' =>'HMAC-SHA1',
            'openid.session_type' =>'DH-SHA1',
            'openid.dh_modulus' => oidUtil::to_b64(oidUtil::long2a($dh->p)),
            'openid.dh_gen' => oidUtil::to_b64(oidUtil::long2a($dh->g)),
            'openid.dh_consumer_public' => oidUtil::to_b64(oidUtil::long2a($cpub)),
        );

        $body = http_build_query($args);

        list( $url, $data ) = $this->http_client->post($server_url, $body);
        $results = oidUtil::parsekv($data);

        $assoc_type = $this->getResult( $results, 'assoc_type');
        if( $assoc_type != 'HMAC-SHA1' ) {
            trigger_error( sprintf( 'runtime error : Unknown association type %s', $assoc_type ), E_USER_WARNING );
        }

        $assoc_handle = $this->getResult( $results, 'assoc_handle');
        $expires_in = isset( $results['expires_in'] ) ? $results['expires_in'] : 0;

        $session_type = isset( $results['session_type'] ) ? $results['session_type'] : 0;
        if( !$session_type ) {
            $secret = oidUtil::from_b64( $this->getResult( $results, 'mac_key'));
        }
        else {
            if( $session_type != 'DH-SHA1' ) {
                trigger_error( sprintf( 'runtime error : Unknown Session Type: %s', $session_type ), E_USER_WARNING );
            }

            $spub = oidUtil::a2long(oidUtil::from_b64( $this->getResult( $results, 'dh_server_public')));
            $dh_shared = $dh->decryptKeyExchange($spub);
            $enc_mac_key = $this->getResult( $results, 'enc_mac_key');
            
            // print "enc_mac_key: " . $enc_mac_key;
            $secret = oidUtil::strxor(oidUtil::from_b64($enc_mac_key), oidUtil::sha1(oidUtil::long2a($dh_shared)));
        }
                                    
        return ConsumerAssociation::from_expires_in( $expires_in, $server_url, $assoc_handle, $secret );
    }
};


class ServerAssociationStore {
    // This is the interface the OpenIDServer class expects its
    // internal_store and external_store objects to support.

    function get($assoc_type) {
        // This method returns an association handle for the given
        // association type.  For the internal_store, implementations may
        // return either a new association, or an existing one, as long
        // as the association it returns won't expire too soon to be
        // useable.  For the external_store, implementations must return
        // a new association each time this method is called.
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function lookup($assoc_handle, $assoc_type) {
        // This method returns the stored association for a given
        // handle and association type.  If there is no such stored
        // association, it should return None.
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

    function remove($handle) {
        // If the server code notices that an association it retrieves
        // has expired, it will call this method to let the store know it
        // should remove the given association.  In general, the
        // implementation should take care of that without the server
        // code getting involved.  This exists primarily to deal with
        // corner cases correctly.
        trigger_error( 'unimplemented', E_USER_WARNING );
    }

}

?>
