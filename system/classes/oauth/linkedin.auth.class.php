<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | linkedin.auth.class.php                                                   |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'linkedin.auth.class.php') !== false) {
    die('This file can not be used on its own.');
}

// PEAR class to handle HTTP-OAuth
require_once 'HTTP/OAuth/Consumer.php';

class linkedinConsumer extends OAuthConsumerBaseClass {
    public $consumer_key = '';  // <-- API Key
    public $consumer_secret = '';  // <-- Secret Key
    public $url_requestToken = 'https://api.linkedin.com/uas/oauth/requestToken';
    public $url_authorize = 'https://www.linkedin.com/uas/oauth/authenticate';
    public $url_accessToken = 'https://api.linkedin.com/uas/oauth/accessToken';
    public $url_userinfo = 'https://api.linkedin.com/v1/people/~:(id,first-name,last-name,location,summary,picture-url,public-profile-url)';
    public $method_requestToken = 'POST';
    public $method_accessToken = 'POST';
    public $method_userinfo = 'GET';

    protected function _getCreateUserInfo($info) {
        $users = array(
            'loginname'      => $info->id,
            'email'          => '',
            'passwd'         => '',
            'passwd2'        => '',
            'fullname'       => $info->{'first-name'} . ' ' .  $info->{'last-name'},
            'homepage'       => $info->{'public-profile-url'},
            'remoteusername' => addslashes($info->id),
            'remoteservice'  => 'oauth.linkedin',
            'remotephoto'    => $info->{'picture-url'},
        );
        return $users;
    }

    protected function _getUpdateUserInfo($info) {
        $userinfo = array(
            'about'          => $info->summary,
            'location'       => $info->location->name,
        );
        return $userinfo;
    }

}

?>