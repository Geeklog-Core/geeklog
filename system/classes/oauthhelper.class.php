<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1.0                                                               |
// +---------------------------------------------------------------------------+
// | oauthhelper.class.php                                                     |
// | version: 2.1.0                                                            |
// |                                                                           |
// | Geeklog Distributed Authentication Module.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Hiroron          - hiroron AT hiroron DOT com                    |
// | Mark Howard               - mark AT usable-web DOT com                    |
// | Mark R. Evans             - mark AT glfusion DOT org                      |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'oauthhelper.class.php') !== false) {
    die('This file can not be used on its own.');
}

require_once 'http/http.php';
require_once 'oauth/oauth_client.php';

// Enable to show debug info for OAuth
$_SYSTEM['debug_oauth'] = false;

class OAuthConsumer {
    protected $consumer = NULL;
    protected $client = NULL;
    var $error = '';

    public function OAuthConsumer($service) {
        global $_CONF,$_SYSTEM;

        if (strpos($service, 'oauth.') === 0) {
            $service = str_replace("oauth.", "", $service);
        }

    	$this->client = new oauth_client_class;
    	$this->client->server     = $service;
        $this->client->debug      = $_SYSTEM['debug_oauth'];
        $this->client->debug_http = $_SYSTEM['debug_oauth'];

        // Set key and secret for OAuth service if found in config
        if ($this->client->client_id == '') {
            if (isset($_CONF[$service . '_consumer_key'])) {
                if ($_CONF[$service . '_consumer_key'] != '') {
                    $this->client->client_id = $_CONF[$service . '_consumer_key'];
                }
            }
        }
        if ($this->client->client_secret == '') {
            if (isset($_CONF[$service . '_consumer_secret'])) {
                if ($_CONF[$service . '_consumer_secret'] != '') {
                    $this->client->client_secret = $_CONF[$service . '_consumer_secret'];
                }
            }
        }

        switch ( $this->client->server ) {
            case 'facebook' :
                $api_url = 'https://graph.facebook.com/me';
                $scope   = 'email,user_website,user_location,user_about_me,user_photos';
                $q_api   = array();
                break;
            case 'google' :
                $api_url = 'https://www.googleapis.com/oauth2/v1/userinfo';
                $scope   = 'https://www.googleapis.com/auth/userinfo.email '.'https://www.googleapis.com/auth/userinfo.profile';
                $q_api   = array();
                break;
            case 'microsoft' :
                $api_url = 'https://apis.live.net/v5.0/me';
                $scope   = 'wl.basic wl.emails';
                $q_api   = array();
                break;
            case 'twitter' :
                $api_url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
                $scope   = '';
                $q_api   = array();
                break;
            case 'yahoo' :
                $api_url = 'http://query.yahooapis.com/v1/yql';
                $scope   = '';
                $q_api   = array('q'=>'select * from social.profile where guid=me','format'=>'json');
                break;
            case 'linkedin' :
                $api_url = 'http://api.linkedin.com/v1/people/~:(id,first-name,last-name,location,summary,email-address,picture-url,public-profile-url)';
                $scope   = 'r_fullprofile r_emailaddress';
                $q_api   = array('format'=>'json');
                break;
        }

        $this->client->scope = $scope;
        $this->api_url = $api_url;
        $this->q_api   = $q_api;
    }

    public function authenticate_user() {
        global $_SYSTEM;
    	if ( ($success = $this->client->Initialize() ) ) {
    		if ( ($success = $this->client->Process() ) ) {
    			if(strlen($this->client->authorization_error)) {
				    $this->client->error = $this->client->authorization_error;
				    $this->error = $this->client->authorization_error;
				    $success = false;
			    } elseif(strlen($this->client->access_token)) {
                    $user = $this->get_userinfo();
                }
    		}
    		$success = $this->client->Finalize($success);
    	}
        if ($_SYSTEM['debug_oauth'] ) COM_errorLog($this->client->debug_output);
    	if ($this->client->exit) {
    		exit;
    	}
    	if ($success) {
    	    return $user;
    	}
    	return $success;
    }

    public function get_userinfo() {

         if (strlen($this->client->access_token)) {
    	    $success = $this->client->CallAPI(
    		    $this->api_url,
    			'GET', $this->q_api, array('FailOnAccessError'=>true), $user);
    	}
   		$success = $this->client->Finalize($success);

    	if ($this->client->exit) {
    		exit;
    	}
    	if ($success) {
    	    return $user;
    	}
    }

    public function setRedirectURL($url) {
            $this->client->redirect_uri  = $url;
    }

    public function doAction($info) {
        global $_TABLES, $status, $uid, $_CONF;

        // remote auth precludes usersubmission, and integrates user activation
        $status = USER_ACCOUNT_ACTIVE;

        $users      = $this->_getCreateUserInfo($info);
        $userinfo   = $this->_getUpdateUserInfo($info);

        $sql = "SELECT uid,status FROM {$_TABLES['users']} WHERE remoteusername = '".DB_escapeString($users['remoteusername'])."' AND remoteservice = '".DB_escapeString($users['remoteservice'])."'";

        $result = DB_query($sql);
        $tmp = DB_error();
        $nrows = DB_numRows($result);

        if (empty($tmp) && $nrows == 1) {
            list($uid, $status) = DB_fetchArray($result);
        } else {
            // initial login - create account
            $status = USER_ACCOUNT_ACTIVE;
            $loginname = $users['loginname'];
            $checkName = DB_getItem($_TABLES['users'], 'username', "username='".DB_escapeString($loginname)."'");
            if (!empty($checkName)) {
                if (function_exists('CUSTOM_uniqueRemoteUsername')) {
                    $loginname = CUSTOM_uniqueRemoteUsername(loginname, $remoteservice);
                }
                if (strcasecmp($checkName,$loginname) == 0) {
                    $loginname = USER_uniqueUsername($loginname);
                }
            }
            $users['loginname'] = $loginname;
            $uid = USER_createAccount($users['loginname'], $users['email'], '', $users['fullname'], $users['homepage'], $users['remoteusername'], $users['remoteservice']);

            if (is_array($users)) {
                $this->_DBupdate_users($uid, $users);
            }

            if (is_array($userinfo)) {
                $this->_DBupdate_userinfo($uid, $userinfo);
            }

            $remote_grp = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Remote Users'");
            DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($remote_grp, $uid)");
        }
    }

    public function doSynch($info) {
        global $_TABLES, $_USER, $status, $uid, $_CONF;

        // remote auth precludes usersubmission and integrates user activation

        $users = $this->_getCreateUserInfo($info);
        $userinfo = $this->_getUpdateUserInfo($info);

        $updatecolumns = '';

        // Update users
        if (is_array($users)) {
            $sql = "UPDATE {$_TABLES['users']} SET ";
            if (!empty($users['fullname'])) {
                $updatecolumns .= "fullname='".DB_escapeString($users['fullname'])."'";
            }
            if (!empty($users['email'])) {
                if (!empty($updatecolumns)) { $updatecolumns .= ", "; }
                $updatecolumns .= "email='".DB_escapeString($users['email'])."'";
            }
            if (!empty($users['homepage'])) {
                if (!empty($updatecolumns)) { $updatecolumns .= ", "; }
                $updatecolumns .= "homepage='".DB_escapeString($users['homepage'])."'";
            }
            $sql = $sql . $updatecolumns . " WHERE uid=" . (int) $_USER['uid'];

            DB_query($sql);

            // Update rest of users info
            $this->_DBupdate_users($_USER['uid'], $users);
        }

        // Update userinfo
        if (is_array($userinfo)) {
            $this->_DBupdate_userinfo($_USER['uid'], $userinfo);
        }

    }

    protected function _getUpdateUserInfo($info) {
        $userinfo = array();
        switch ( $this->client->server ) {
            case 'facebook' :
                if ( isset($info->about) ) {
                    $userinfo['about'] = $info->about;
                }
                if ( isset($info->location->name) ) {
                    $userinfo['location'] = $info->location->name;
                }
                break;
            case 'google' :
                break;
            case 'microsoft' :
                break;
            case 'twitter' :
                break;
            case 'yahoo' :
                break;
            case 'linkedin' :
                if ( isset($info->location->name) ) {
                    $userinfo['location'] = $info->location->name;
                }
                break;
        }

        return $userinfo;
    }


    protected function _getCreateUserInfo($info) {

        switch ( $this->client->server ) {
            case 'facebook' :
                $users = array(
                    'loginname'      => (isset($info->first_name) ? $info->first_name : $info->id),
                    'email'          => $info->email,
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => $info->name,
                    'homepage'       => $info->link,
                    'remoteusername' => DB_escapeString($info->id),
                    'remoteservice'  => 'oauth.facebook',
                    'remotephoto'    => 'http://graph.facebook.com/'.$info->id.'/picture',
                );
                break;
            case 'google' :
                $users = array(
                    'loginname'      => (isset($info->given_name) ? $info->given_name : $info->id),
                    'email'          => $info->email,
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => $info->name,
                    'homepage'       => $info->link,
                    'remoteusername' => DB_escapeString($info->id),
                    'remoteservice'  => 'oauth.google',
                    'remotephoto'    => $info->picture,
                );
                break;
            case 'twitter' :
                $users = array(
                    'loginname'      => $info->screen_name,
                    'email'          => '',
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => $info->name,
                    'homepage'       => 'http://twitter.com/'.$info->screen_name,
                    'remoteusername' => DB_escapeString($info->screen_name),
                    'remoteservice'  => 'oauth.twitter',
                    'remotephoto'    => $info->profile_image_url,
                );
                break;
            case 'microsoft' :
                $users = array(
                    'loginname'      => (isset($info->first_name) ? $info->first_name : $info->id),
                    'email'          => $info->emails->preferred,
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => $info->name,
                    'homepage'       => '',
                    'remoteusername' => DB_escapeString($info->id),
                    'remoteservice'  => 'oauth.microsoft',
                    'remotephoto'    => 'https://apis.live.net/v5.0/me/picture?access_token='.$this->client->access_token,
                );
                break;
            case 'yahoo' :
                $users = array(
                    'loginname'      => (isset($info->query->results->profile->givenName) ? $info->query->results->profile->givenName : $info->query->results->profile->guid),
                    'email'          => $info->query->results->profile->emails->handle,
                    'passwd'         => '',
                    'passwd2'        => '',
                    // 'fullname'       => $info->query->results->profile->familyName,
                    'fullname'       => $info->query->results->profile->nickname,
                    'homepage'       => '',
                    'remoteusername' => DB_escapeString($info->query->results->profile->guid),
                    'remoteservice'  => 'oauth.yahoo',
                    // 'remotephoto'    => 'https://apis.live.net/v5.0/me/picture?access_token='.$this->client->access_token,
                    'remotephoto'    => '',
                );
                break;
            case 'linkedin' :
                $users = array(
                    'loginname'      => (isset($info->{'firstName'}) ? $info->{'firstName'} : $info->id),
                    'email'          => $info->{'emailAddress'},
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => $info->{'firstName'} . ' ' .  $info->{'lastName'},
                    'homepage'       => $info->{'publicProfileUrl'},
                    'remoteusername' => DB_escapeString($info->id),
                    'remoteservice'  => 'oauth.linkedin',
                    'remotephoto'    => $info->{'pictureUrl'},
                );
                break;
        }

        return $users;
    }

    protected function _DBupdate_userinfo($uid, $userinfo) {
        global $_TABLES;
        if (!empty($userinfo['about']) || !empty($userinfo['location'])) {
            $sql = "UPDATE {$_TABLES['userinfo']} SET";
            $sql .= !empty($userinfo['about']) ? " about = '".DB_escapeString($userinfo['about'])."'" : "";
            $sql .= (!empty($userinfo['about']) && !empty($userinfo['location'])) ? "," : "";
            $sql .= !empty($userinfo['location']) ? " location = '".DB_escapeString($userinfo['location'])."'" : "";
            $sql .= " WHERE uid = ".(int) $uid;
            DB_query($sql);
        }
    }

    protected function _DBupdate_users($uid, $users) {
        global $_TABLES, $_CONF;

        $sql = "UPDATE {$_TABLES['users']} SET remoteusername = '".DB_escapeString($users['remoteusername'])."', remoteservice = '".DB_escapeString($users['remoteservice'])."', status = 3 ";
        if (!empty($users['remotephoto'])) {
            $save_img = $_CONF['path_images'] . 'userphotos/' . $uid ;
            $imgsize = $this->_saveUserPhoto($users['remotephoto'], $save_img);
            if (!empty($imgsize)) {
                $ext = $this->_getImageExt($save_img);
                $image = $save_img . $ext;
                if (file_exists($image)) {
                    unlink($image);
                }
                rename($save_img, $image);
                $imgname = $uid . $ext;
                $sql .= ", photo = '".DB_escapeString($imgname)."'";
            }
        }
        $sql .= " WHERE uid = ".(int) $uid;
        DB_query($sql);
    }

    protected function _saveUserPhoto($from, $to) {
        $ret = '';
        require_once 'HTTP/Request.php';
        $req = new HTTP_Request($from);
        $req->addHeader('User-Agent', 'Geeklog/' . VERSION);
        $req->addHeader('Referer', COM_getCurrentUrl());
        $res = $req->sendRequest();
        if( !PEAR::isError($res) ){
            $img = $req->getResponseBody();
            $ret = file_put_contents($to, $img);
        }
        return $ret;
    }

    protected function _getImageExt($img, $dot = true) {
        $size = @getimagesize($img);
        switch ($size['mime']) {
            case 'image/gif':
                $ext = 'gif';
                break;
            case 'image/jpeg':
                $ext = 'jpg';
                break;
            case 'image/png':
                $ext = 'png';
                break;
            case 'image/bmp':
                $ext = 'bmp';
                break;
        }
        return ($dot ? '.' : '') . $ext;
    }
}

?>
