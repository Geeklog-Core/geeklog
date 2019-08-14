<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-sessions.php                                                          |
// |                                                                           |
// | Geeklog session library.                                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2019 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Mark Limburg     - mlimburg AT users DOT sourceforge DOT net     |
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

/**
* This is the session management library for Geeklog.  Some of this code was
* borrowed from phpBB 1.4.x which is also GPL'd
*/

use Geeklog\Input;
use Geeklog\Session;

// Turn this on if you want to see various debug messages from this library
$_SESS_VERBOSE = COM_isEnableDeveloperModeLog('session');

if (stripos($_SERVER['PHP_SELF'], 'lib-sessions.php') !== false) {
    die('This file can not be used on its own!');
}

if (empty($_CONF['cookiedomain'])) {
    preg_match("/\/\/([^\/:]*)/", $_CONF['site_url'], $server);
    if (substr($server[1], 0, 4) === 'www.') {
        $_CONF['cookiedomain'] = substr($server[1], 3);
    } else {
        if (strpos($server[1], '.') === false) {
            // e.g. 'localhost' or other local names
            $_CONF['cookiedomain'] = '';
        } else {
            $_CONF['cookiedomain'] = '.' . $server[1];
        }
    }
    if ($_SESS_VERBOSE) {
        COM_errorLog("Setting cookiedomain = '" . $_CONF['cookiedomain'] . "'", 1);
    }
}

/**
* This gets the state for the user
*
* Much of this code if from phpBB (www.phpbb.org).  This checks the session
* cookie and long term cookie to get the users state.
*/
function SESS_sessionCheck()
{
    global $_CONF, $_TABLES, $_USER, $_SESS_VERBOSE;

    if ($_SESS_VERBOSE) {
        COM_errorLog("*** Inside SESS_sessionCheck ***",1);
    }

    $_USER = array(
        'uid' => Session::ANON_USER_ID,
    );

    // Check for a cookie on the users's machine.  If the cookie exists, build
    // an array of the users info and setup the theme.

    // Flag indicates if session cookie and session data exist
    $sessionExists = Session::init(array(
        'cookie_lifetime' => $_CONF['session_cookie_timeout'],
        'cookie_path'     => $_CONF['cookie_path'],
        'cookie_domain'   => $_CONF['cookiedomain'],
        'cookie_secure'   => $_CONF['cookiesecure'],
        'session_name'    => $_CONF['cookie_session'],
    ));
    $sessId = Session::getSessionId();
    $status = -1;

    if ($sessionExists) {
        if ($_SESS_VERBOSE) {
            COM_errorLog("Got {$sessId} as the session ID",1);
        }

        $userId = Session::getUid();
        if ($_SESS_VERBOSE) {
            COM_errorLog("Got {$userId} as User ID from the session ID",1);
        }

        if ($userId > Session::ANON_USER_ID) {
            // Check user status
            $status = SEC_checkUserStatus($userId);
            if (($status == USER_ACCOUNT_ACTIVE) ||
                    ($status == USER_ACCOUNT_AWAITING_ACTIVATION ||
                    $status == USER_ACCOUNT_LOCKED ||
                    $status == USER_ACCOUNT_NEW_EMAIL ||
                    $status == USER_ACCOUNT_NEW_PASSWORD)) {
                SESS_updateSessionTime($sessId);
                $_USER = SESS_getUserDataFromId($userId);
                if ($_SESS_VERBOSE) {
                    $str = "Got " . count($_USER) . " pieces of data from userdata \n";
                    foreach ($_USER as $k => $v) {
                        $str .= sprintf("%15s [%s] \n", $k, $v);
                    }
                    COM_errorLog($str, 1);
                }

                SESS_issueAutoLoginCookie($userId);
            }
        } elseif ($userId === Session::ANON_USER_ID) {
            // Check if the permanent cookie exists
            $userId = SESS_handleAutoLogin();

            if ($userId > Session::ANON_USER_ID) {
                SESS_newSession($userId, $_SERVER['REMOTE_ADDR'], $_CONF['session_cookie_timeout']);
                $_USER = SESS_getUserDataFromId($userId);
                SESS_issueAutoLoginCookie($userId);
            } else {
                // Anonymous User has session so update any information
                SESS_updateSessionTime($sessId);
            }
        }
    } else {
        // Session cookie was not found, but the Session class was initialized.
        if ($_SESS_VERBOSE) {
            COM_errorLog("Session cookie not found",1);
        }

        // Check if the permanent cookie exists
        $userId = SESS_handleAutoLogin();

        if ($userId > Session::ANON_USER_ID) {
            // Session cookie or session data don't exist, but a permanent cookie does.
            if ($_SESS_VERBOSE) {
                COM_errorLog("Got {$userId} as User ID from the permanent cookie", 1);
            }

            Session::setUid($userId);

            // Check user status
            $status = SEC_checkUserStatus($userId);
            if (($status == USER_ACCOUNT_ACTIVE) ||
                ($status == USER_ACCOUNT_AWAITING_ACTIVATION)) {
                if ($_SESS_VERBOSE) {
                    COM_errorLog('Create new session', 1);
                }

                // Create new session and write cookie
                SESS_newSession($userId, $_SERVER['REMOTE_ADDR'], $_CONF['session_cookie_timeout']);
                $_USER = SESS_getUserDataFromId($userId);
                $_USER['auto_login'] = true;
            }
        } else {
            if ($_SESS_VERBOSE) {
                COM_errorLog("Permanent cookie not found",1);
            }

            // Anonymous user has session id but it has been expired and wiped from the db so reset.
            // Or new anonymous user so create new session and write cookie.
            SESS_newSession($userId, $_SERVER['REMOTE_ADDR'], $_CONF['session_cookie_timeout']);
        }
    }

    if ($_SESS_VERBOSE) {
        COM_errorLog("*** Leaving SESS_sessionCheck ***",1);
    }

    // Check to see if user status is set to something we have to redirect the user too
    if (isset($_USER['uid']) && $_USER['uid'] > Session::ANON_USER_ID) {
        // Check if active user has email account and if required
        // Doesn't matter if remote account or not
        if ($_CONF['require_user_email'] && empty($_USER['email']) && $_USER['status'] == USER_ACCOUNT_ACTIVE) {
            $_USER['status'] = USER_ACCOUNT_NEW_EMAIL;
            DB_change($_TABLES['users'], 'status', USER_ACCOUNT_NEW_EMAIL, 'uid', $_USER['uid']);
        }
        
        if ($_USER['status'] == USER_ACCOUNT_LOCKED) {
            // Account is locked so user shouldn't be logged in
            if ($_SERVER['PHP_SELF'] !== '/users.php') {
                COM_redirect($_CONF['site_url'] . '/users.php?mode=logout&msg=17');  
            }
        } elseif ($_USER['status']  == USER_ACCOUNT_NEW_EMAIL || $_USER['status'] == USER_ACCOUNT_NEW_PASSWORD) {
            // Account requires additional info so get it
            if ($_SERVER['PHP_SELF'] !== '/users.php') {
                if ($_USER['status']  == USER_ACCOUNT_NEW_EMAIL) {
                    COM_redirect($_CONF['site_url'] . '/users.php?mode=newemailstatus');
                } elseif ($status == USER_ACCOUNT_NEW_PASSWORD) {
                    COM_redirect($_CONF['site_url'] . '/users.php?mode=newpwdstatus');
                }
            }
            
        }      
    }
}

/**
* Creates new user session (short term cookie)
*
* Adds a new session to the database for the given userid and returns a new session ID.
* Also deletes all expired sessions from the database, based on the given session lifespan.
*
* @param   int     $userId     User ID to create session for
* @param   string  $remote_ip  IP address user is connected from
* @param   string  $lifespan   How long (seconds) this cookie should persist
* @return  string              Session ID
*/
function SESS_newSession($userId, $remote_ip, $lifespan)
{
    global $_TABLES, $_CONF, $_SESS_VERBOSE;

    if ($_SESS_VERBOSE) {
        COM_errorLog("*** Inside SESS_newSession ***", 1);
        COM_errorLog(
            "Args to SESS_newSession: userid = {$userId}, remote_ip = {$remote_ip}, lifespan = {$lifespan}",
            1
        );
    }

    // Delete expired sessions from database
    $ctime = time();
    $currentTime = (string) ($ctime);
    $expiryTime = (string) ($ctime - $lifespan);
    $deleteResult = false;
    $retryMax = 3;
    $wait = 50000; // 50 ms

    for ($i = 0; $i < $retryMax; $i++) {
        DB_lockTable($_TABLES['sessions']);
        $deleteSQL = "DELETE FROM {$_TABLES['sessions']} WHERE (start_time < {$expiryTime})";
        $deleteResult = DB_query($deleteSQL);
        DB_unlockTable($_TABLES['sessions']);
        if ($_SESS_VERBOSE) {
            COM_errorLog("Attempted to delete rows from session table with following SQL\n$deleteSQL\n",1);
            COM_errorLog("Got $deleteResult as a result from the query",1);
        }

        if ($deleteResult) {
            break;
        }

        usleep($wait);
    }

    if (!$deleteResult) {
        die("Delete failed in SESS_newSession()");
    }

    // Delete old session from database
    $oldSessionId = Session::getSessionId();
    $escOldSessionId = DB_escapeString($oldSessionId);
    DB_query("DELETE FROM {$_TABLES['sessions']} WHERE sess_id = '{$escOldSessionId}'");

    // Create new session ID and insert it into database
    $sessId = Session::regenerateId();
    $escSessionId = DB_escapeString($sessId);
    $escRemoteIp = DB_escapeString($remote_ip);

    // Create new session
    Session::setUid($userId);
    $sql = "INSERT INTO {$_TABLES['sessions']} (sess_id, uid, start_time, remote_ip, whos_online) "
        . "VALUES ('{$escSessionId}', {$userId}, {$currentTime}, '{$escRemoteIp}', 1)";
    $result = DB_query($sql);
    if (!$result) {
        echo DB_error() . ': ' . DB_error() . '<br' . XHTML . '>';
        die('Insert failed in SESS_newSession()');
    }

    if ($_CONF['lastlogin']) {
        // Update userinfo record to record the date and time as lastlogin
        DB_query("UPDATE {$_TABLES['userinfo']} SET lastlogin = UNIX_TIMESTAMP() WHERE uid = {$userId}");
    }
    if ($_SESS_VERBOSE) {
        COM_errorLog("Assigned the following session id: {$sessId}", 1);
        COM_errorLog("*** Leaving SESS_newSession ***", 1);
    }

    return $sessId;
}

/**
* Updates a session cookie's timeout and the session id
*
* Refresh the start_time of the given session in the database.
* This is called whenever a page is hit by a user with a valid session.
*
* @param   string  $sessId  Session ID to update time for
* @return  string           a new session ID
*/
function SESS_updateSessionTime($sessId)
{
    global $_TABLES;

    $escOldSessionId = DB_escapeString($sessId);
    $newSessionId = Session::regenerateId();
    $escNewSessionId = DB_escapeString($newSessionId);
    $newTime = (string) time();
    $sql = "UPDATE {$_TABLES['sessions']} SET start_time = {$newTime}, "
        . "whos_online = 1, sess_id = '{$escNewSessionId}' "
        . "WHERE sess_id = '{$escOldSessionId}'";
    DB_query($sql);

    return $newSessionId;
}

/**
* This ends a user session
*
* Delete the given session from the database. Used by the logout page.
*
* @param   int   $userId  User ID to end session of
* @return  bool           Always true for some reason
*/
function SESS_endUserSession($userId)
{
    global $_CONF, $_TABLES;

    $userId = (int) $userId;

    if (!(isset($_CONF['demo_mode']) && $_CONF['demo_mode'])) {
        DB_delete($_TABLES['sessions'], 'uid', $userId);
        Session::setUid(Session::ANON_USER_ID);
    }

    return 1;
}

/**
* Gets user's data based on their user id
*
* @param   int    $userId  User ID of user to get data for
* @return  array           returns user's data in an array
*/
function SESS_getUserDataFromId($userId)
{
    global $_TABLES;

    $userId = (int) $userId;
    if ($userId <= Session::ANON_USER_ID) {
        return array(
            'uid'      => Session::ANON_USER_ID,
            'username' => 'anonymous',
        );
    }

    $sql = "SELECT *,format FROM {$_TABLES['dateformats']},{$_TABLES['users']},{$_TABLES['userprefs']} "
        . "WHERE {$_TABLES['dateformats']}.dfid = {$_TABLES['userprefs']}.dfid AND "
        . "{$_TABLES['userprefs']}.uid = $userId AND {$_TABLES['users']}.uid = {$userId}";

    if ((!$result = DB_query($sql)) || (!$myRow = DB_fetchArray($result, false))) {
        return array(
            'uid'      => $userId,
            'username' => 'anonymous',
            'error'    => '1',
        );
    }

    return $myRow;
}

/**
* Retrieves a session variable from the db
*
* @param   string  $name  Variable name to retrieve
* @return  mixed          data from variable
*/
function SESS_getVariable($name)
{
    return Session::getVar($name, '');
}

/**
* Updates a session variable from the db
*
* @param   string  $name   Variable name to update
* @param   mixed   $value  Value of variable
* @return  bool            Always true for some reason
*/
function SESS_setVariable($name, $value)
{
    Session::setVar($name, $value);

    return 1;
}

/**
 * Handle an auto-login key
 *
 * @param   int  $lifeTime  cookie lifetime
 * @return  int  user id or 1 when no auto-login key was found
 */
function SESS_handleAutoLogin($lifeTime = -1)
{
    global $_CONF, $_TABLES;

    // Get an auto-login key from cookie
    $autoLoginKey = Input::cookie($_CONF['cookie_name'], '');
    $autoLoginKey = preg_replace('/[^0-9a-f]/', '', $autoLoginKey);

    if ($autoLoginKey === '') {
        // No auto-login key was found in the permanent cookie
        return 1;
    }

    $escAutoLoginKey = DB_escapeString($autoLoginKey);
    $sql = "SELECT uid FROM {$_TABLES['users']} WHERE autologin_key = '{$escAutoLoginKey}'";
    $result = DB_query($sql);
    if (DB_error()) {
        return 1;
    }

    switch (DB_numRows($result)) {
        case 0:
            // The Auto-login key given was not found in database.  Possible attack
            COM_clearSpeedlimit($_CONF['login_speedlimit'], 'login');
            if (COM_checkSpeedlimit('login', $_CONF['login_attempts']) > 0) {
                COM_displayMessageAndAbort(82, '', 403, 'Access denied');
            }
            COM_updateSpeedlimit('login');

            return 1;
            break;

        case 1:
            $A = DB_fetchArray($result, false);
            $uid = (int) $A['uid'];

            // Issue a new auto-login key
            SESS_issueAutoLoginCookie($uid);

            return $uid;
            break;

        default:
            // very unlikely case
            $sql = "UPDATE {$_TABLES['users']} SET autologin_key = '' WHERE autologin_key = {$escAutoLoginKey}";
            DB_query($sql);

            return 1;
            break;
    }
}

/**
 * Issue a cookie containing an auto-login cookie
 *
 * @param  int     $userId
 * @param  int     $lifeTime
 * @return string  a newly created auto-login key or false on failure
 */
function SESS_issueAutoLoginCookie($userId, $lifeTime = -1)
{
    global $_CONF, $_TABLES;

    // We don't issue auto-login cookies for anonymous users
    $userId = (int) $userId;
    if ($userId <= Session::ANON_USER_ID) {
        return false;
    }

    $lifeTime = (int) $lifeTime;
    if ($lifeTime <= 0) {
        $lifeTime = COM_getUserCookieTimeout();

        // This user doesn't want auto-login feature
        if ($lifeTime <= 0) {
            return false;
        }
    }

    $autoLoginKey = SEC_randomBytes(80);
    $autoLoginKey = sha1($autoLoginKey);

    if (SEC_setCookie($_CONF['cookie_name'], $autoLoginKey, time() + $lifeTime)) {
        $escAutoLoginKey = DB_escapeString($autoLoginKey);
        $sql = "UPDATE {$_TABLES['users']} SET autologin_key = '{$escAutoLoginKey}' WHERE uid = {$userId}";
        DB_query($sql);
        return $autoLoginKey;
    } else {
        return false;
    }
}

/**
 * Delete an existing auto-login key for the current user
 */
function SESS_deleteAutoLoginKey()
{
    global $_CONF, $_TABLES;

    $autoLoginKey = Input::fCookie($_CONF['cookie_name'], '');

    if (!empty($autoLoginKey)) {
        $escAutoLoginKey = DB_escapeString($autoLoginKey);
        $sql = "UPDATE {$_TABLES['users']} SET autologin_key = '' WHERE autologin_key = '{$escAutoLoginKey}'";
        DB_query($sql);
        SEC_setCookie($_CONF['cookie_name'], '', time() - 10000);
    }
}
