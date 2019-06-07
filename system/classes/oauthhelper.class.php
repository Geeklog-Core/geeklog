<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2.0                                                             |
// +---------------------------------------------------------------------------+
// | oauthhelper.class.php                                                     |
// | version: 2.2.0                                                            |
// |                                                                           |
// | Geeklog Distributed Authentication Module.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010-2017 by the following authors:                         |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

// As of Geeklog 2.2.0, both oauth-api and httpclient classes are managed by composer.
// Also see https://www.phpclasses.org/package/7700-PHP-Authorize-and-access-APIs-using-OAuth.html

// Enable to show debug info for OAuth
$_SYSTEM['debug_oauth'] = false;

class OAuthConsumer
{
    protected $consumer = null;
    protected $client = null;
    public $error = '';

    /**
     * OAuthConsumer constructor.
     *
     * @param  string $service
     * @throws InvalidArgumentException
     */
    public function __construct($service)
    {
        global $_CONF, $_SYSTEM;

        $service = strtolower($service); // always deal in lower case since that is how it is stored in the config 
        
        if (strpos($service, 'oauth.') === 0) {
            $service = str_replace('oauth.', '', $service);
        }
        
        // Geeklog stores oauth service in all small case
        // Vendor oauth_client.php capitalizes certain letters so update service variable to make sure will match when the vendor oauth_client_class is created
        switch ($service) {
            case "facebook":
                $service = "Facebook";
                break;
            case "github":
                $service = "github";
                break;
            case "google":
                $service = "Google";
                break;
            case "linkedin":
                $service = "LinkedIn";
                break;
            case "microsoft":
                $service = "Microsoft";
                break;
            case "twitter":
                $service = "Twitter";
                break;
            case "yahoo":
                $service = "Yahoo";
                break;
            default:
                break;
        }

        $this->client = new oauth_client_class;
        $this->client->server = $service;
        $this->client->debug = $_SYSTEM['debug_oauth'];
        $this->client->debug_http = $_SYSTEM['debug_oauth'];

        // Set key and secret for OAuth service if found in config
        if ($this->client->client_id == '') {
            if (isset($_CONF[strtolower($service) . '_consumer_key'])) {
                if ($_CONF[strtolower($service) . '_consumer_key'] != '') {
                    $this->client->client_id = $_CONF[strtolower($service) . '_consumer_key'];
                }
            }
        }
        if ($this->client->client_secret == '') {
            if (isset($_CONF[strtolower($service) . '_consumer_secret'])) {
                if ($_CONF[strtolower($service) . '_consumer_secret'] != '') {
                    $this->client->client_secret = $_CONF[strtolower($service) . '_consumer_secret'];
                }
            }
        }

        switch ($this->client->server) {
            case 'Facebook' :
                //$api_url = 'https://graph.facebook.com/me?fields=name,email,link,id,first_name,last_name,about';
                //$scope   = 'email,public_profile,user_friends';
				// About returns no data as of April 4th, 2018 as new version of API
				// Don't need to request user_friends scope. Fix for permissions now required by Facebook app when requesting non-default data
                // 2018-10-19 - A link to the person's Timeline. Removed link since even with user_link permission it is not useful anymore.
                // The link will only resolve if the person clicking the link is logged into Facebook and is a friend of the person whose profile is being viewed. 
                // At one point it use to be visible to non friends 
				$api_url = 'https://graph.facebook.com/me?fields=name,email,id,first_name,last_name,location';
				$scope   = 'email,public_profile';
                $q_api   = array();
                break;

            case 'Google' :
                // For differences see: https://stackoverflow.com/questions/31277898/difference-between-v1-v2-and-v3-in-https-www-googleapis-com-oauth2-v3-certs
                //$api_url = 'https://www.googleapis.com/oauth2/v1/userinfo';
                $api_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
                // $api_url = 'https://www.googleapis.com/oauth2/v3/userinfo';
                $scope   = 'https://www.googleapis.com/auth/userinfo.email '.'https://www.googleapis.com/auth/userinfo.profile';
                $q_api   = array();
                break;
            
            case 'Microsoft' :
                $api_url = 'https://apis.live.net/v5.0/me';
                $scope   = 'wl.basic wl.emails';
                $q_api   = array();
                break;

            case 'Twitter' :
                $api_url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
                $scope   = '';
                $q_api   = array('include_entities' => "true", 'skip_status' => "true", 'include_email' => "true");
                break;

            case 'Yahoo' :
                $api_url = 'http://query.yahooapis.com/v1/yql';
                $scope   = '';
                $q_api   = array('q'=>'select * from social.profile where guid=me','format'=>'json');
                break;

            case 'LinkedIn' :
                $api_url = 'http://api.linkedin.com/v1/people/~:(id,first-name,last-name,location,summary,email-address,picture-url,public-profile-url)';
                $scope   = 'r_basicprofile r_emailaddress';
                $q_api   = array('format'=>'json');
                break;

            case 'github' :
                $api_url = 'https://api.github.com/user';
                $scope   = 'user:email';
                $q_api   = array();
                break;

            default:
                throw new InvalidArgumentException(__METHOD__ . ': Unknown server "' . $this->client->server . '" was given');
        }

        $this->client->scope = $scope;
        $this->api_url = $api_url;
        $this->q_api = $q_api;
    }

    /**
     * @return bool|object|array
     */
    public function authenticate_user()
    {
        global $_SYSTEM;

        $user = array();

        if (($success = $this->client->Initialize())) {
            if (($success = $this->client->Process())) {
                if (strlen($this->client->authorization_error)) {
                    $this->client->error = $this->client->authorization_error;
                    $this->error = $this->client->authorization_error;
                    $success = false;
                } elseif (strlen($this->client->access_token)) {
                    $user = $this->get_userinfo();
                }
            }
            $success = $this->client->Finalize($success);
        }
        if ($_SYSTEM['debug_oauth']) {
            COM_errorLog($this->client->debug_output, 1);
        }
        if ($this->client->exit) {
            exit;
        }
        if ($success) {
            return $user;
        }

        return $success;
    }

    public function get_userinfo()
    {
        $success = null;
        $user = null;

        if (strlen($this->client->access_token)) {
            $success = $this->client->CallAPI(
                $this->api_url,
                'GET', $this->q_api, array('FailOnAccessError' => true), $user);
        }
        $success = $this->client->Finalize($success);

        if ($this->client->exit) {
            exit;
        }

        if ($success) {
            return $user;
        } else {
            return null;
        }
    }

    /**
     * @param  string $url
     */
    public function setRedirectURL($url)
    {
        $this->client->redirect_uri = $url;
    }

    public function doAction($info)
    {
        global $_TABLES, $status, $uid, $_CONF;

        // remote auth precludes user submission, and integrates user activation
        $status = USER_ACCOUNT_ACTIVE;
        
        $users = $this->_getCreateUserInfo($info);
        $userInfo = $this->_getUpdateUserInfo($info);
        
        // We need to make sure we get a remote username. The odd time it may not get returned do to outside server error
        if (!empty($users['remoteusername'])) { 
            $sql = "SELECT uid, status FROM {$_TABLES['users']} "
                . "WHERE remoteusername = '" . DB_escapeString($users['remoteusername']) . "' "
                . "AND remoteservice = '" . DB_escapeString($users['remoteservice']) . "'";

            $result = DB_query($sql);
            $tmp = DB_error();
            $numRows = DB_numRows($result);

            if (empty($tmp) && $numRows == 1) {
                list($uid, $status) = DB_fetchArray($result);
            } else {
                // initial login - create account
                $status = USER_ACCOUNT_ACTIVE;
                // Treat username same as Geeklog would for normal account (see USER_createAccount) even though they will not use name to login
                // So remove any unwanted characters
                $loginName = trim(GLText::remove4byteUtf8Chars(COM_applyFilter($users['loginname'])));
                
                $checkName = DB_getItem($_TABLES['users'], 'username', "username='" . DB_escapeString($loginName) . "'");
                if (!empty($checkName) || empty($loginName)) { // also if for some reason blank login name we should create one
                    if (function_exists('CUSTOM_uniqueRemoteUsername')) {
                        /** @noinspection PhpUndefinedVariableInspection */
                        $loginName = CUSTOM_uniqueRemoteUsername($loginName, $remoteService);
                    }
                    if (strcasecmp($checkName, $loginName) == 0) {
                        $loginName = USER_uniqueUsername($loginName);
                    }
                }
                $users['loginname'] = $loginName;
                $uid = USER_createAccount($users['loginname'], $users['email'], '', $users['fullname'], $users['homepage'], $users['remoteusername'], $users['remoteservice']);

                if (is_array($users)) {
                    $this->_DBupdate_users($uid, $users);
                }

                if (is_array($userInfo)) {
                    $this->_DBupdate_userinfo($uid, $userInfo);
                }

                $remote_grp = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Remote Users'");
                DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($remote_grp, $uid)");
            }
            
            return true;
        }
    }

    public function doSynch($info)
    {
        global $_TABLES, $_USER, $status, $uid, $_CONF;

        // remote auth precludes usersubmission and integrates user activation
        $users = $this->_getCreateUserInfo($info);
        $userInfo = $this->_getUpdateUserInfo($info);

        $updateColumns = '';

        // Update users
        if (is_array($users)) {
            $sql = "UPDATE {$_TABLES['users']} SET ";
            if (!empty($users['fullname'])) {
                $updateColumns .= "fullname='" . DB_escapeString($users['fullname']) . "'";
            }
            if (!empty($users['email'])) {
                if (!empty($updateColumns)) {
                    $updateColumns .= ", ";
                }
                $updateColumns .= "email='" . DB_escapeString($users['email']) . "'";
            }
            if (!empty($users['homepage'])) {
                if (!empty($updateColumns)) {
                    $updateColumns .= ", ";
                }
                $updateColumns .= "homepage='" . DB_escapeString($users['homepage']) . "'";
            }
            $sql = $sql . $updateColumns . " WHERE uid=" . (int) $_USER['uid'];

            DB_query($sql);

            // Update rest of users info
            $this->_DBupdate_users($_USER['uid'], $users);
        }

        // Update userinfo
        if (is_array($userInfo)) {
            $this->_DBupdate_userinfo($_USER['uid'], $userInfo);
        }

    }

    protected function _getUpdateUserInfo($info)
    {
        $userInfo = array();

        switch ($this->client->server) {
            case 'Facebook' :
				// Facebook removed all access to About in April, 2018
                //if ( isset($info->about) ) {
                //    $userinfo['about'] = $info->about;
                //}
                if ( isset($info->location->name) ) {
                    $userinfo['location'] = $info->location->name;
                }
                break;

            case 'Google' :
                break;

            case 'Microsoft' :
                break;

            case 'Twitter' :
                if ( isset($info->email ) ) {
                    $userinfo['email'] = $info->email;
                }
                break;

            case 'Yahoo' :
                if (isset($info->query->results->profile->location)) {
                    $userInfo['location'] = $info->query->results->profile->location;
                }
                break;

            case 'LinkedIn' :
                if ( isset($info->location->name) ) {
                    $userinfo['location'] = $info->location->name;
                }
                break;

            case 'github' :
                break;
        }

        return $userInfo;
    }

    protected function _getCreateUserInfo($info)
    {
        switch ($this->client->server) {
            case 'Facebook' :
                $users = array(
                    'loginname'      => (isset($info->first_name) ? $info->first_name : $info->id),
                    'email'          => $info->email,
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => $info->name,
                    'homepage'       => '', // Changed from $info->link, // See above in scope as to why removed (Facebook User must be logged in and a friend to work)
                    'remoteusername' => DB_escapeString($info->id),
                    'remoteservice'  => 'oauth.facebook',
                    'remotephoto'    => 'http://graph.facebook.com/'.$info->id.'/picture',
                );
                break;            

            case 'github' :
                $users = array(
                    'loginname'      => (isset($info->{'login'}) ? $info->{'login'} : $info->id),
                    'email'          => $info->{'email'},
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => $info->{'name'},
                    'homepage'       => $info->{'html_url'},
                    'remoteusername' => DB_escapeString($info->id),
                    'remoteservice'  => 'oauth.github',
                    'remotephoto'    => $info->{'avatar_url'},
                );
                break;                
            
            case 'Google' :
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
            
            case 'Twitter' :
                $mail = '';
                if ( isset($info->email)) {
                    $mail = $info->email;
                }
                $users = array(
                    'loginname'      => $info->screen_name,
                    'email'          => $mail,
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => $info->name,
                    'homepage'       => 'http://twitter.com/'.$info->screen_name,
                    'remoteusername' => DB_escapeString($info->screen_name),
                    'remoteservice'  => 'oauth.twitter',
                    'remotephoto'    => $info->profile_image_url,
                );
                break;                

            case 'Microsoft' :
                $users = array(
                    'loginname'      => (isset($info->first_name) ? $info->first_name : $info->id),
                    'email'          => $info->emails->preferred,
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => $info->name,
                    'homepage'       => '',
                    'remoteusername' => DB_escapeString($info->id),
                    'remoteservice'  => 'oauth.microsoft',
                    'remotephoto'    => 'https://apis.live.net/v5.0/me/picture?access_token=' . $this->client->access_token,
                );
                break;
                
            case 'Yahoo' :
                $users = array(
                    'loginname'      => (isset($info->query->results->profile->nickname) ? $info->query->results->profile->nickname : $info->query->results->profile->guid),
                    'email'          => $info->query->results->profile->emails->handle,
                    'passwd'         => '',
                    'passwd2'        => '',
                    'fullname'       => ($info->query->results->profile->givenName . ' ' . $info->query->results->profile->familyName),
                    'homepage'       => $info->query->results->profile->profileUrl,
                    'remoteusername' => DB_escapeString($info->query->results->profile->guid),
                    'remoteservice'  => 'oauth.yahoo',
                    'remotephoto'    => $info->query->results->profile->image->imageUrl,
                );
                break;
                
            case 'LinkedIn' :
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

            default:
                throw new InvalidArgumentException(__METHOD__ . ': Unknown server "' . $this->client->server . '" was given');
        }

        return $users;
    }

    protected function _DBupdate_userinfo($uid, $userInfo)
    {
        global $_TABLES;

		// Location field returned by several Oauth Providers
		// About field was returned by Facebook but not anymore. Left in for now in case in future we can set it again or by another OAuth provider
        if (!empty($userInfo['about']) || !empty($userInfo['location'])) {
            $sql = "UPDATE {$_TABLES['userinfo']} SET";
            $sql .= !empty($userInfo['about']) ? " about = '" . DB_escapeString($userInfo['about']) . "'" : "";
            $sql .= (!empty($userInfo['about']) && !empty($userInfo['location'])) ? "," : "";
            $sql .= !empty($userInfo['location']) ? " location = '" . DB_escapeString($userInfo['location']) . "'" : "";
            $sql .= " WHERE uid = " . (int) $uid;
            DB_query($sql);
        }
    }

    protected function _DBupdate_users($uid, $users)
    {
        global $_TABLES, $_CONF;

        $sql = "UPDATE {$_TABLES['users']} SET remoteusername = '" . DB_escapeString($users['remoteusername']) . "', remoteservice = '" . DB_escapeString($users['remoteservice']) . "', status = 3 ";
        if (!empty($users['remotephoto'])) {
            $save_img = $_CONF['path_images'] . 'userphotos/' . $uid;
            $imgsize = $this->_saveUserPhoto($users['remotephoto'], $save_img);
            if (!empty($imgsize)) {
                $ext = $this->_getImageExt($save_img);
                $image = $save_img . $ext;
                if (file_exists($image)) {
                    unlink($image);
                }
                rename($save_img, $image);

                $photo = $uid . $ext;
                $img_path = $this->_handleImageResize($_CONF['path_images'] . 'userphotos/' . $photo);

                // If nothing returned then image resize did not go right
                if (!empty($img_path)) {
                    if (!file_exists($img_path)) {
                        $photo = '';
                    }
                } else {
                    USER_deletePhoto($photo, false);
                    $photo = '';
                }

                $sql .= ", photo = '" . DB_escapeString($photo) . "'"; // update photo even if blank just incase OAuth profile picture has been removed
            }
        }
        $sql .= " WHERE uid = " . (int) $uid;
        DB_query($sql);
    }

    protected function _saveUserPhoto($from, $to)
    {
        // Use Pear HTTP Request 2 since first Facebook url to profile picture redirects to a new location
        $ret = '';
        $request = new HTTP_Request2($from, HTTP_Request2::METHOD_GET);
        $request->setConfig(array(
            'adapter'          => 'HTTP_Request2_Adapter_Socket',
            'connect_timeout'  => 15,
            'timeout'          => 30,
            'follow_redirects' => true,
            'max_redirects'    => 5,
            'ssl_verify_peer'  => false,
            'ssl_verify_host'  => false,
        ));
        $request->setHeader('User-Agent', 'Geeklog/' . VERSION);
        $request->setHeader('Referer', COM_getCurrentURL());
        $response = $request->send();
        if (200 == $response->getStatus()) {
            $img = $response->getBody();
            $ret = file_put_contents($to, $img);
        }

        return $ret;
    }

    protected function _getImageExt($img, $dot = true)
    {
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

            default:
                throw new InvalidArgumentException(__METHOD__ . ': Unknown MIME type "' . $size['mime'] . '" was given');
        }

        return ($dot ? '.' : '') . $ext;
    }

    protected function _handleImageResize($to_path)
    {
        global $_CONF;

        require_once $_CONF['path_system'] . 'classes/upload.class.php';

        // Figure out file name
        $path_parts = pathinfo($to_path);
        $filename = $path_parts['basename'];

        $upload = new Upload();
        if (!empty ($_CONF['image_lib'])) {
            if ($_CONF['image_lib'] == 'imagemagick') {
                // Using imagemagick
                $upload->setMogrifyPath($_CONF['path_to_mogrify']);
            } elseif ($_CONF['image_lib'] == 'netpbm') {
                // using netPBM
                $upload->setNetPBM($_CONF['path_to_netpbm']);
            } elseif ($_CONF['image_lib'] == 'gdlib') {
                // using the GD library
                $upload->setGDLib();
            }
            $upload->setAutomaticResize(true);
            if (isset ($_CONF['debug_image_upload']) && $_CONF['debug_image_upload']) {
                $upload->setLogFile($_CONF['path'] . 'logs/error.log');
                $upload->setDebug(true);
            }
            if (isset($_CONF['jpeg_quality'])) {
                $upload->setJpegQuality($_CONF['jpeg_quality']);
            }
        }
        $upload->setAllowedMimeTypes(array(
            'image/gif'   => '.gif',
            'image/jpeg'  => '.jpg,.jpeg',
            'image/pjpeg' => '.jpg,.jpeg',
            'image/x-png' => '.png',
            'image/png'   => '.png',
        ));
        // Set new path and image name
        if (!$upload->setPath($_CONF['path_images'] . 'userphotos')) {
            return;
        }

        // Current path of image to resize
        $path = $_CONF['path_images'] . 'userphotos/' . $filename;
        $path_parts = pathinfo($path);
        $_FILES['imagefile']['name'] = $path_parts['basename'];
        $_FILES['imagefile']['tmp_name'] = $path;
        $_FILES['imagefile']['type'] = '';

        switch ($path_parts['extension']) {
            case 'gif':
                $_FILES['imagefile']['type'] = 'image/gif';
                break;

            case 'jpg':
            case 'jpeg':
                $_FILES['imagefile']['type'] = 'image/jpeg';
                break;

            case 'png':
                $_FILES['imagefile']['type'] = 'image/png';
                break;
        }

        $_FILES['imagefile']['size'] = filesize($_FILES['imagefile']['tmp_name']);
        $_FILES['imagefile']['error'] = '';
        $_FILES['imagefile']['non_upload'] = true; // Flag to bypass upload process via browser file form

        // do the upload
        if (!empty($filename)) {
            $upload->setFileNames($filename);
            $upload->setPerms('0644');
            if (($_CONF['max_photo_width'] > 0) && ($_CONF['max_photo_height'] > 0)) {
                $upload->setMaxDimensions($_CONF['max_photo_width'],
                    $_CONF['max_photo_height']);
            } else {
                $upload->setMaxDimensions($_CONF['max_image_width'],
                    $_CONF['max_image_height']);
            }
            if ($_CONF['max_photo_size'] > 0) {
                $upload->setMaxFileSize($_CONF['max_photo_size']);
            } else {
                $upload->setMaxFileSize($_CONF['max_image_size']);
            }
            $upload->uploadFiles();

            if ($upload->areErrors()) {
                return;
            }
        }

        return $path; // return new path and filename
    }
}
