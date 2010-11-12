<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | twitter.auth.class.php                                                    |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'twitter.auth.class.php') !== false) {
    die('This file can not be used on its own.');
}

// PEAR class to handle HTTP-OAuth
require_once 'HTTP/OAuth/Consumer.php';

class twitterConsumer extends OAuthConsumerBaseClass {
    public $consumer_key = ''; // <-- Consumer key
    public $consumer_secret = '';  // <-- Consumer secret
    public $url_requestToken = 'https://twitter.com/oauth/request_token';
    public $url_authorize = 'https://twitter.com/oauth/authenticate';
    public $url_accessToken = 'https://twitter.com/oauth/access_token';
    public $url_userinfo = 'http://twitter.com/account/verify_credentials.xml';

    protected function _getCreateUserInfo($info) {
        $users = array(
            'loginname'      => $info->screen_name,
            'email'          => '',
            'passwd'         => '',
            'passwd2'        => '',
            'fullname'       => $info->name,
            'homepage'       => 'http://twitter.com/'.$info->screen_name,
            'remoteusername' => addslashes($info->screen_name),
            'remoteservice'  => 'oauth.twitter',
            'remotephoto'    => $info->profile_image_url,
        );
        return $users;
    }

    protected function _getUpdateUserInfo($info) {
        $userinfo = array(
            'about'          => $info->description,
            'location'       => $info->location,
        );
        return $userinfo;
    }

    protected function _after_trigger($uid, $users, $userinfo) {
        global $_CONF, $MESSAGE;
        
        $url = $this->_shorten($_CONF['site_url']);
        // twitter send message
        $msg = str_replace(array('{site_url}','\n'), array($url,"\n"), $MESSAGE[113]);
        $this->_sendDM($users['remoteusername'], $msg);
    }

    private function _sendDM($name, $msg) {
        try {
            $this->consumer = new HTTP_OAuth_Consumer($this->consumer_key, $this->consumer_secret, $this->token, $this->token_secret);
            $this->consumer->accept($this->request);
            $response = $this->consumer->sendRequest('http://api.twitter.com/1/direct_messages/new.xml', array('screen_name'=>$name, 'text'=>$msg), 'POST');
            if ($response->getStatus() !== 200) {
                $this->errormsg = $response->getStatus() . ' : ' . $response->getBody();
                COM_errorLog("TwitterAuth DM Error(".$response->getStatus()."/".$response->getBody().") TwitterId={$name}, DM={$msg}");
            }
        } catch (HTTP_OAuth_Consumer_Exception_Invalid_Response $e) {
            $this->errormsg = get_class($e) . ': ' . $e->getBody();
        } catch (Exception $e) {
            $this->errormsg = get_class($e) . ': ' . $e->getMessage();
        }
    }
}

?>