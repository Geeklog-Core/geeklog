<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | openidhelper.class.php                                                    |
// |                                                                           |
// | OpenID helper classes                                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Choplair         - chopinou AT choplair DOT org                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
//
// $Id: openidhelper.class.php,v 1.2 2008/09/21 08:37:12 dhaun Exp $

if (strpos(strtolower($_SERVER['PHP_SELF']), 'openidhelper.class.php') !== false) {
    die('This file can not be used on its own.');
}

require_once $_CONF['path_system'] . 'classes/openid/consumer.php';

class SimpleConsumer extends OpenIDConsumer {

    function verify_return_to($return_to)
    {
        $parts = parse_url($return_to);
        if (!isset($parts['port'])) {
            $parts['port'] = ($parts['scheme'] == 'https' ? 443 : 80);
        }

        if (($parts['host'] != $_SERVER['SERVER_NAME']) ||
                ($parts['port'] != $_SERVER['SERVER_PORT'])) {
            return false;
        }

        return true;
    }

}


class SimpleActionHandler extends ActionHandler {

    function SimpleActionHandler($query, $consumer)
    {
        $this->query = $query;
        $this->consumer = $consumer;
    }

    // Callbacks.
    function doValidLogin($login)
    {
        global $_TABLES, $status, $uid;

        // Remote auth precludes usersubmission,
        // and integrates user activation, see?;
        $status = USER_ACCOUNT_ACTIVE;

        // PHP replaces "." with "_"
        $openid_identity = addslashes($this->query['openid_identity']);
        $openid_nickname = '';
        if (isset($this->query['openid_sreg_nickname'])) {
            $openid_nickname = $this->query['openid_sreg_nickname'];
        }

        // Check if that account is already registered.
        $result = DB_query("SELECT uid FROM {$_TABLES['users']} WHERE remoteusername = '$openid_identity' AND remoteservice = 'openid'");
        $tmp = DB_error();
        $nrows = DB_numRows($result);
        if (!($tmp == 0) || !($nrows == 1)) {
            // First time login with this OpenID, creating account...

            if (empty($openid_nickname)) {
                $openid_nickname = $this->makeUsername($this->query['openid_identity']);
            }

            // we simply can't accept empty usernames ...
            if (empty($openid_nickname)) {
                COM_errorLog('Got an empty username for ' . $openid_identity);

                // not strictly correct - just to signal a failed login attempt
                $status = USER_ACCOUNT_DISABLED;
                $uid = 0;
                return;
            }

            // Ensure that remoteusername is unique locally.
            $openid_nickname = USER_uniqueUsername($openid_nickname);
            $openid_sreg_email = '';
            if (isset($this->query['openid_sreg_email'])) {
                $openid_sreg_email = $this->query['openid_sreg_email'];
            }
            $openid_sreg_fullname = '';
            if (isset($this->query['openid_sreg_fullname'])) {
                $openid_sreg_fullname = $this->query['openid_sreg_fullname'];
            }
            
            USER_createAccount($openid_nickname, $openid_sreg_email, SEC_generateRandomPassword(),
                    $openid_sreg_fullname, '', $this->query['openid_identity'],
                    'openid');
            $uid = DB_getItem($_TABLES['users'], 'uid', "remoteusername = '$openid_identity' AND remoteservice = 'openid'");

            // Store full remote account name:
            DB_query("UPDATE {$_TABLES['users']} SET remoteusername = '$openid_identity', remoteservice = 'openid', status = 3 WHERE uid = $uid");

            // Add to remote users:
            $remote_grp = DB_getItem($_TABLES['groups'], 'grp_id',
                                     "grp_name = 'Remote Users'");
            DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($remote_grp, $uid)");
        } else {
            $result = DB_query("SELECT uid,status FROM {$_TABLES['users']} WHERE remoteusername = '$openid_identity' AND remoteservice = 'openid'");
            list($uid, $status) = DB_fetchArray($result);
        }
    }

    /**
    * An attempt to guess the username from the OpenID URL,
    * mostly for typekey.com which doesn't send the username :-/
    *
    * @param    string  $url    OpenID URL
    * @return   string          username or empty string
    *
    */
    function makeUsername($url)
    {
        $ignore = array('www', 'profile', 'openid');

        $parts = parse_url($url);

        // try subdomain names, e.g. username.myopenid.com
        $u = explode('.', $parts['host']);
        if (count($u) > 2) {
            $u = $u[0];
            foreach ($ignore as $ign) {
                if (strpos($u, $ign) !== false) {
                    $u = '';
                    break;
                }
            }

            if (!empty($u)) {
                return $u;
            }
        }

        // try paths, e.g. profile.typekey.com/username
        $u = explode('/', $parts['path']);
        $p = '';
        while (count($u) > 0) {
            $x = array_shift($u);
            if (!empty($x)) {
                $p = $x;
                break;
            }
        }

        if (empty($p)) {
            return '';
        }

        foreach ($ignore as $ign) {
            if (strpos($p, $ign) !== false) {
                $p = '';
                break;
            }
        }

        return $p;
    }

    function doInvalidLogin()
    {
        $this->quick_message_display(86);
    }

    function doUserCancelled()
    {
        $this->quick_message_display(87);
    }

    function doCheckAuthRequired($server_url, $return_to, $post_data)
    {
        // do openid.mode=check_authentication call, and then change state

        $response = $this->consumer->check_auth($server_url, $return_to,
                                                $post_data, $this->getOpenID());
        $response->doAction($this);
    }

    function doErrorFromServer($message)
    {
        COM_errorLog('The OpenID server returned the following error: '
                     . $message);
        $this->quick_message_display(88);
    }

    function getOpenID()
    {
        // return the openid from the original form
        return $this->query['open_id'];
    }

    function quick_message_display($msg)
    {
        global $_CONF;

        echo COM_refresh($_CONF['site_url'] . '/users.php?msg=' . $msg);
        exit;
    }

}

?>
