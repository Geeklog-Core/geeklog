<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | oauthhelper.class.php                                                     |
// | version: 1.0.0                                                            |
// |                                                                           |
// | Geeklog Distributed Authentication Module.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010-2011 by the following authors:                         |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'oauthhelper.class.php') !== false) {
    die('This file can not be used on its own.');
}

// PEAR class to handle HTTP-Request2
require_once 'HTTP/Request2.php';

class OAuthConsumer {
    protected $consumer = NULL;

    public function OAuthConsumer($service)
    {
        global $_CONF;

        if (strpos($service, 'oauth.') === 0) {
            $service = str_replace("oauth.", "", $service);
        }

        require_once $_CONF['path_system'] . 'classes/oauth/' . $service . '.auth.class.php';
        $serviceclass = $service . 'Consumer';
        $this->consumer = new $serviceclass;

        // Set key and secret for OAuth service if found in config
        if ($this->consumer->consumer_key == '') {
            if (isset($_CONF[$service . '_consumer_key'])) {
                if ($_CONF[$service . '_consumer_key'] != '') {
                    $this->consumer->consumer_key = $_CONF[$service . '_consumer_key'];
                }
            }
        }
        if ($this->consumer->consumer_secret == '') {
            if (isset($_CONF[$service . '_consumer_secret'])) {
                if ($_CONF[$service . '_consumer_secret'] != '') {
                    $this->consumer->consumer_secret = $_CONF[$service . '_consumer_secret'];
                }
            }
        }
    }

    public function find_identity_info($callback_url, $query) {
        return $this->consumer->find_identity_info($callback_url, $query);
    }

    public function sreq_userinfo_response($query) {
        return $this->consumer->sreq_userinfo_response($query);
    }

    public function refresh_userinfo() {
        return $this->consumer->refresh_userinfo();
    }

    public function getErrorMsg() {
        return $this->consumer->getErrorMsg();
    }

    public function doSynch($info) {
        $this->consumer->doSynch($info);
    }

    public function doAction($info) {
        $this->consumer->doAction($info);
    }

    public function getCallback_query_string() {
        return $this->consumer->callback_query_string;
    }

    public function getCancel_query_string() {
        return $this->consumer->cancel_query_string;
    }

}

class OAuthConsumerBaseClass {
    protected $request = '';
    protected $consumer = '';
    protected $errormsg = '';
    protected $shortapi = 'http://api.tr.im/api/trim_url.xml';
    public $consumer_key = '';
    public $consumer_secret = '';
    public $url_requestToken = '';
    public $url_authorize = '';
    public $url_accessToken = '';
    public $url_userinfo = '';
    public $method_requestToken = 'GET';
    public $method_accessToken = 'GET';
    public $method_userinfo = 'GET';
    public $cookietimeout = 300;    // google Callbacks 5min
    public $token = '';
    public $token_secret = '';
    public $callback_query_string = 'oauth_verifier';
    public $cancel_query_string = '';

    public function __construct () {
        $httpRequest = new HTTP_Request2;
        $httpRequest->setConfig('ssl_verify_peer', false);
        $httpRequest->setHeader('Accept-Encoding', '.*');
        $this->request = new HTTP_OAuth_Consumer_Request;
        $this->request->accept($httpRequest);
    }

    public function find_identity_info($callback_url, $query) {
        $url = '';

        try {
            $this->consumer = new HTTP_OAuth_Consumer($this->consumer_key, $this->consumer_secret);
            $this->consumer->accept($this->request);

            $this->consumer->getRequestToken($this->url_requestToken, $callback_url, array(), $this->method_requestToken);
            $timeout = time() + $this->cookietimeout;
            SEC_setCookie('request_token', $this->consumer->getToken(), $timeout);
            SEC_setCookie('request_token_secret', $this->consumer->getTokenSecret(), $timeout);

            $url = $this->consumer->getAuthorizeUrl($this->url_authorize);

        } catch (HTTP_OAuth_Consumer_Exception_Invalid_Response $e) {
            $this->errormsg = get_class($e) . ': ' . $e->getBody();
        } catch (Exception $e) {
            $this->errormsg = get_class($e) . ': ' . $e->getMessage();
        }
        return $url;
    }

    public function sreq_userinfo_response($query) {
        $userinfo = array();

        // COM_errorLog("BASE:sreq_userinfo_response()------------------");
        try {
            $this->token = $_COOKIE['request_token'];
            $this->token_secret = $_COOKIE['request_token_secret'];
            $verifier = $query[$this->callback_query_string];
            // clear cookies
            SEC_setCookie($_COOKIE['request_token'], '', time() - 10000);
            SEC_setCookie($_COOKIE['request_token_secret'], '', time() - 10000);
            $this->consumer = new HTTP_OAuth_Consumer($this->consumer_key, $this->consumer_secret, $this->token, $this->token_secret);
            $this->consumer->accept($this->request);

            $this->consumer->getAccessToken($this->url_accessToken, $verifier, array(), $this->method_accessToken);

            $this->token = $this->consumer->getToken();
            $this->token_secret = $this->consumer->getTokenSecret();

            $this->consumer->setToken($this->token);
            $this->consumer->setTokenSecret($this->token_secret);

            $response = $this->consumer->sendRequest($this->url_userinfo, array(), $this->method_userinfo);
            if ($response->getStatus() !== 200) {
                $this->errormsg = $response->getStatus() . ' : ' . $response->getBody();
            } else {
                $userinfo = simplexml_load_string($response->getBody());
            }
        } catch (HTTP_OAuth_Consumer_Exception_Invalid_Response $e) {
            $this->errormsg = get_class($e) . ': ' . $e->getBody();
        } catch (Exception $e) {
            $this->errormsg = get_class($e) . ': ' . $e->getMessage();
        }
        return $userinfo;
    }

    public function doSynch($info) {
        global $_TABLES, $_USER, $status, $uid, $_CONF;

        // COM_errorLog("doSynch() method ------------------");

        // remote auth precludes usersubmission and integrates user activation

        $users = $this->_getCreateUserInfo($info);
        $userinfo = $this->_getUpdateUserInfo($info);

        $updatecolumns = '';

        // Update users
        if (is_array($users)) {
            $sql = "UPDATE {$_TABLES['users']} SET ";
            if (!empty($users['fullname'])) {
                $fn = addslashes(strip_tags($users['fullname']));
                $updatecolumns .= "fullname='$fn'";
            }
            if (!empty($users['email'])) {
                if (!empty($updatecolumns)) {
                    $updatecolumns .= ", ";
                }
                $em = addslashes(COM_applyFilter($users['email']));
                $updatecolumns .= "email='$em'";
            }
            if (!empty($users['homepage'])) {
                if (!empty($updatecolumns)) {
                    $updatecolumns .= ", ";
                }
                $hp = addslashes(COM_applyFilter($users['homepage']));
                $updatecolumns .= "homepage='$hp'";
            }
            $sql = $sql . $updatecolumns . " WHERE uid={$_USER['uid']}";

            DB_query($sql);

            // Update rest of users info
            $this->_DBupdate_users($_USER['uid'], $users);
        }

        // Update userinfo
        if (is_array($userinfo)) {
            $this->_DBupdate_userinfo($_USER['uid'], $userinfo);
        }

    }

    public function doAction($info) {

        global $_TABLES, $status, $uid, $_CONF;

        // COM_errorLog("doAction() method ------------------");

        // remote auth precludes usersubmission, and integrates user activation
        $status = USER_ACCOUNT_ACTIVE;

        $users = $this->_getCreateUserInfo($info);
        $userinfo = $this->_getUpdateUserInfo($info);
        
        $sql = "SELECT uid,status FROM {$_TABLES['users']} WHERE remoteusername = '{$users['remoteusername']}' AND remoteservice = '{$users['remoteservice']}'";
        // COM_errorLog("sql={$sql}");
        $result = DB_query($sql);
        $tmp = DB_error();
        // COM_errorLog("DB_error={$tmp}");
        $nrows = DB_numRows($result);
        // COM_errorLog("DB_numRows={$nrows}");
        if (empty($tmp) && $nrows == 1) {
            list($uid, $status) = DB_fetchArray($result);
            // COM_errorLog("user found!  uid={$uid} status={$status}");
        } else {
            // COM_errorLog("user not found - creating new account");
            // initial login - create account
            $status = USER_ACCOUNT_ACTIVE;

            // COM_errorLog("checking remoteusername for uniqueness");
            // the likelihood that a remoteusername would not be unique within a given service is extremely unlikely
            // but, i guess it's better to be safe than sorry
            $checkName = DB_getItem($_TABLES['users'], 'username', "username='{$users['remoteusername']}'");
            if (!empty($checkName)) {
                if (function_exists('CUSTOM_uniqueRemoteUsername')) {
                    // COM_errorLog("CUSTOM_uniqueRemoteUserName function exists, calling it");
                    $loginname = CUSTOM_uniqueRemoteUsername($loginname, $remoteservice);
                }
                if ($checkName == $loginname) {
                    // COM_errorLog("remoteusername is not unique, using USER_uniqueUsername() to create one");
                    $loginname = USER_uniqueUsername($loginname);
                }
            }

            $uid = USER_createAccount($users['loginname'], $users['email'], $users['passwd2'], $users['fullname'], $users['homepage'], $users['remoteusername'], $users['remoteservice']);
            // COM_errorLog("after creation, uid={$uid}");

            // COM_errorLog("updating users[]");
            if (is_array($users)) {
                $this->_DBupdate_users($uid, $users);
            }

            // COM_errorLog("updating userinfo[]");
            if (is_array($userinfo)) {
                $this->_DBupdate_userinfo($uid, $userinfo);
            }

            // COM_errorLog("adding uid={$uid} to Remote Users group");
            $remote_grp = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Remote Users'");
            DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($remote_grp, $uid)");

            // usercreate after trigger
            if (method_exists($this, '_after_trigger')) {
                $this->_after_trigger($uid, $users, $userinfo);
            }
        }
    }

    public function getErrorMsg() {
        return $this->errormsg;
    }

    protected function _DBupdate_users($uid, $users) {
        global $_TABLES, $_CONF;
        // COM_errorLog("_DBupdate_users()---------------------");
        $sql = "UPDATE {$_TABLES['users']} SET remoteusername = '{$users['remoteusername']}', remoteservice = '{$users['remoteservice']}', status = 3";
        if (!empty($users['remotephoto'])) {
            // COM_errorLog("saving userphoto");
            $save_img = $_CONF['path_images'] . 'userphotos/' . $users['loginname'];
            // COM_errorLog("from={$users['remotephoto']} to={$save_img}");
            $imgsize = $this->_saveUserPhoto($users['remotephoto'], $save_img);
            // COM_errorLog("imgsize={$imgsize}");
            if (!empty($imgsize)) {
                $ext = $this->_getImageExt($save_img);
                // COM_errorLog("image_ext={$ext}");
                $image = $save_img . $ext;
                // if a userphoto exists, delete it
                if (file_exists($image)) {
                    unlink($image);
                }
                rename($save_img, $image);
                $imgname = $users['loginname'] . $ext;
                $sql .= ", photo = '{$imgname}'";
            }
        }
        $sql .= " WHERE uid = $uid";
        // COM_errorLog("sql={$sql}");
        DB_query($sql);
    }

    protected function _DBupdate_userinfo($uid, $userinfo) {
        global $_TABLES;
        // COM_errorLog("_DBupdate_userinfo()-----------------");
        if (!empty($userinfo['about']) || !empty($userinfo['location'])) {
            // COM_errorLog("userinfo update needed");
            // COM_errorLog("userinfo[about]={$userinfo['about']}");
            // COM_errorLog("userinfo[location]={$userinfo['location']}");
            $sql = "UPDATE {$_TABLES['userinfo']} SET";
            if (! empty($userinfo['about'])) {
                $sql .= " about = '" . addslashes(strip_tags($userinfo['about'])) . "'";
            }
            $sql .= (!empty($userinfo['about']) && !empty($userinfo['location'])) ? "," : "";
            if (! empty($userinfo['location'])) {
                $sql .= " location = '" . addslashes(strip_tags($userinfo['location'])) . "'";
            }
            $sql .= " WHERE uid = {$uid}";
            // COM_errorLog("sql={$sql}");
            DB_query($sql);
        }
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
        $size = getimagesize($img);
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

    protected function _shorten($url) {
        $this->request->setUrl($this->shortapi.'?url='.$url);
        $this->request->setMethod('GET');
        $response = $this->request->send();
        if ($response->getStatus() !== 200) {
            return $url;
        } else {
            $xml = @simplexml_load_string($response->getBody());
            return $xml->url;
        }
    }

}


?>
