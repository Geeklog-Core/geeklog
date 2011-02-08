<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | facebook.auth.class.php                                                   |
// | version: 1.0.0                                                            |
// |                                                                           |
// | Geeklog Distributed Authentication Module.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 by the following authors:                              |
// |                                                                           |
// | Authors: Hiroron          - hiroron AT hiroron DOT com                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

if (strpos(strtolower($_SERVER['PHP_SELF']), 'facebook.auth.class.php') !== false) {
    die('This file can not be used on its own.');
}

class facebookConsumer extends OAuthConsumerBaseClass {
    public $consumer_key = ''; // <--  Application ID
    public $consumer_secret = ''; // <--  Application Secret
    public $url_authorize = 'https://graph.facebook.com/oauth/authorize';
    public $url_accessToken = 'https://graph.facebook.com/oauth/access_token';
    public $url_userinfo = 'https://graph.facebook.com/me';
    public $url_userinfo_photo = 'https://graph.facebook.com/me/picture';
    public $callback_query_string = 'code';
    public $cancel_query_string = 'error_reason';
    
    public function __construct() {
        $this->request = new HTTP_Request2;
        $this->request->setConfig('ssl_verify_peer', false);
        $this->request->setHeader('Accept-Encoding', '.*');
    }
    
    public function find_identity_info($callback_url, $query) {
        $params = array(
            'client_id' => $this->consumer_key,
            'redirect_uri' => $callback_url,
            'scope' => 'email,user_website,user_location,user_about_me,user_photos',
        );
        return $this->url_authorize . '?' . http_build_query($params, null, '&');
    }
    
    public function sreq_userinfo_response($query) {
        global $_CONF;
        
        $userinfo = array();
        
        try {
            $verifier = $query[$this->callback_query_string];
            $callback_url = $_CONF['site_url'] . '/users.php?oauth_login=facebook';
            $params = array(
                'client_id' => $this->consumer_key,
                'redirect_uri' => $callback_url,
                'client_secret' => $this->consumer_secret,
                'code' => $verifier,
            );
            $url_auth = $this->url_accessToken . '?' . http_build_query($params, null, '&');
            $this->request->setUrl($url_auth);
            $response = $this->request->send();
            $rdata = $response->getBody();
            parse_str($rdata, $data);
            if (isset($data['access_token'])) {
                $this->token = $data['access_token'];
            } else {
                $data = json_decode($rdata);
                if (!empty($data->error)) {
                    $this->errormsg = $data->error->message;
                }
                return;
            }
            
            $params = array('access_token' => $this->token);
            $url_me = $this->url_userinfo . '?' . http_build_query($params, null, '&');
            $this->request->setUrl($url_me);
            $response = $this->request->send();
            $rdata = $response->getBody();
            $data = json_decode($rdata);
            if (!empty($data->error)) {
                $this->errormsg = $data->error->message;
                return;
            }
            $userinfo = $data;
            
            $url_photo = $this->url_userinfo_photo . '?' . http_build_query($params, null, '&');
            $this->request->setUrl($url_photo);
            $response = $this->request->send();
            $rdata = $response->getHeader();
            $userinfo->photo = $rdata['location'];
        } catch (Exception $e) {
            $this->errormsg = get_class($e) . ': ' . $e->getMessage();
        }
        return $userinfo;
    }

    protected function _getCreateUserInfo($info) {
        $users = array(
            'loginname'      => $info->id,
            'email'          => $info->email,
            'passwd'         => '',
            'passwd2'        => '',
            'fullname'       => $info->name,
            'homepage'       => $info->link,
            'remoteusername' => addslashes($info->id),
            'remoteservice'  => 'oauth.facebook',
            'remotephoto'    => $info->photo,
        );
        return $users;
    }

    protected function _getUpdateUserInfo($info) {
        $userinfo = array(
            'about'          => $info->about,
            'location'       => $info->location->name,
        );
        return $userinfo;
    }

}

if ( !function_exists('json_decode') ){
    function json_decode($json)
    { 
        // Author: walidator.info 2009
        $comment = false;
        $out = '$x=';
       
        for ($i=0; $i<strlen($json); $i++)
        {
            if (!$comment)
            {
                if ($json[$i] == '{')        $out .= ' array(';
                else if ($json[$i] == '}')    $out .= ')';
                else if ($json[$i] == ':')    $out .= '=>';
                else                         $out .= $json[$i];           
            }
            else $out .= $json[$i];
            if ($json[$i] == '"')    $comment = !$comment;
        }
        eval($out . ';');
        return $x;
    } 
}

?>