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
        // Issue #465
        // local names part works fine and if domain is an ip it works fine for browsers Firefox and Edge
        // If browser is Chrome if an IP cookie domain needs to be set to ''.
        // Unfortantly Firefox and Edge doesn't work with cookie domain set to ''
        // So left as is with Google Chrome sessions not working properly if IP is the cookie domain
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
        'debug'           => isset($_CONF['developer_mode_log']['session']) && $_CONF['developer_mode_log']['session'],
        'logger'          => 'COM_errorLog',
        'cookie_disabled' => false,
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

        // Make sure corresponding record exists in Geeklog Session Table
        // Shouldn't have been deleted by anything but you never know...
        if (!DB_getItem($_TABLES['sessions'], 'sess_id', "sess_id = '$sessId'")) {
            // If deleted add in basic session record back into Geeklog database
            $ctime = time();
            $currentTime = (string) ($ctime);
            $escSessionId = DB_escapeString($sessId);
            $escRemoteIp = DB_escapeString($_SERVER['REMOTE_ADDR']);

            $sql = "INSERT INTO {$_TABLES['sessions']} (sess_id, uid, start_time, remote_ip, whos_online) "
                . "VALUES ('{$escSessionId}', {$userId}, {$currentTime}, '{$escRemoteIp}', 1)";
            $result = DB_query($sql);
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

                SESS_issueAutoLoginCookie($userId, true);
            }
        } elseif ($userId === Session::ANON_USER_ID) {
            // Check if the permanent cookie exists
            $userId = SESS_handleAutoLogin();

            if ($userId > Session::ANON_USER_ID) {
                SESS_newSession($userId, $_SERVER['REMOTE_ADDR'], $_CONF['session_cookie_timeout']);
                $_USER = SESS_getUserDataFromId($userId);
                SESS_issueAutoLoginCookie($userId, true);
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

                // Create new session and write cookie since user is now logged in
                SESS_newSession($userId, $_SERVER['REMOTE_ADDR'], $_CONF['session_cookie_timeout']);
                $_USER = SESS_getUserDataFromId($userId);
				SESS_issueAutoLoginCookie($userId, false);
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

    // ******************************************************
    // Note this check obviously only runs when a new session happens not with existing sessions
    // Assumed done this way to prevent check happening with every single page load

    // Check to delete expired sessions from database
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

    // Delete Expired User Auto Login Keys
    DB_query("DELETE FROM {$_TABLES['userautologin']} WHERE expiry_time < $currentTime");
    // ******************************************************

    $oldSessionId = Session::getSessionId();
    $escOldSessionId = DB_escapeString($oldSessionId);

    // Delete old session from database
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
*/
function SESS_updateSessionTime($sessId)
{
    global $_TABLES;

    $escSessionId = DB_escapeString($sessId);
    $newTime = (string) time();
    $sql = "UPDATE {$_TABLES['sessions']} SET start_time = {$newTime}, whos_online = 1 "
        . "WHERE sess_id = '{$escSessionId}'";
    DB_query($sql);
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
    global $_TABLES;

    SESS_deleteAutoLoginKey();

    $userId = (int) $userId;
    $oldSessionId = DB_escapeString(Session::getSessionId());
    $newSessionId = Session::regenerateId();
    $newSessionId = DB_escapeString($newSessionId);
    $sql = "UPDATE {$_TABLES['sessions']} SET uid = " . Session::ANON_USER_ID . ", sess_id = '{$newSessionId}' "
        . " WHERE (uid = {$userId}) AND (sess_id = '{$oldSessionId}')";
    DB_query($sql);

    Session::setUid(Session::ANON_USER_ID);

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
    global $_TABLES, $_USER;

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

    // Need to store auto login key this time so it can be reused for current session
    if (isset($_USER['auto_login']) && $_USER['auto_login']) {
        $myRow['auto_login'] = true;
        $myRow['autoLoginKeyHash'] = $_USER['autoLoginKeyHash'];
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
 * Anonymous session should already be created
 *
 * @return  int  user id or 1 when no auto-login key was found
 */
function SESS_handleAutoLogin()
{
    global $_CONF, $_TABLES;

    // Get an auto-login key from cookie
    $autoLoginKey = Input::cookie($_CONF['cookie_name'], '');
    $autoLoginKey = preg_replace('/[^0-9a-f]/', '', $autoLoginKey);

    if ($autoLoginKey === '') {
        // No auto-login key was found in the permanent cookie
        return 1;
    }

    // Try to get a record with the auto-login key from `gl_sessions` table
    $salt = '';
    $autoLoginKeyHash = SEC_encryptPassword($autoLoginKey, $salt, $_CONF['pass_alg'], $_CONF['pass_stretch']);
    $escAutoLoginKeyHash = DB_escapeString($autoLoginKeyHash);
    $sql = "SELECT uid FROM {$_TABLES['userautologin']} WHERE autologin_key_hash = '{$escAutoLoginKeyHash}'";
    $result = DB_query($sql);
    if (DB_error()) {
        return 1;
    }

    if (DB_numRows($result) == 1) {
        $A = DB_fetchArray($result, false);
        $uid = (int) $A['uid'];

        // Delete old original session record tied to this auto login key if it exists (this only may happen if the server has been rebooted or something which flushed all the sesions) as actual PHP Session doesn't exist anymore
        // from the current anonymous session to a new actual user session
		DB_query("DELETE FROM {$_TABLES['sessions']} WHERE autologin_key_hash = '{$escAutoLoginKeyHash}'");

        // Auto login is successful. Update user array with new information (at this point user array is still for anonymous user and hasn't been loaded yet)
        global $_USER;
        $_USER['auto_login'] = true;
        $_USER['autoLoginKeyHash'] = $autoLoginKeyHash;

		// Note: A new logged in user session will be create after this function based on the uid
        // At this point this anonymous user with an auto login key will be transferred over
        return $uid;
    } else {
        // The auto-login key contained in the cookie was not found in the database.
        // We should remove invalid auto-login key from both cookie and database
        SESS_deleteAutoLoginKey();

        return 1;
    }
}

/**
 * Issue a cookie containing an auto-login cookie
 * User is already logged in and user data loaded at this point, and session has already been created
 *
 * @param  int     $userId
 * @param  bool    $onlyExtendLifeSpan
 * @return string|false  a newly created auto-login key or false on failure
 */
function SESS_issueAutoLoginCookie($userId, $onlyExtendLifeSpan = true)
{
    global $_CONF, $_TABLES, $_USER;

    // We don't issue auto-login cookies for anonymous users
    $userId = (int) $userId;
    if ($userId <= Session::ANON_USER_ID) {
        return false;
    }

    $lifeTime = COM_getUserCookieTimeout();
    if ($lifeTime <= 0) {
        // This user doesn't want auto-login feature
        return false;
    }

    $sessionId = DB_escapeString(Session::getSessionId());

    if ($onlyExtendLifeSpan) {
        // Need to make sure cookie is the same as what is in the database though
        $autoLoginKey = Input::cookie($_CONF['cookie_name'], '');
        $autoLoginKey = preg_replace('/[^0-9a-f]/', '', $autoLoginKey);

        // Make sure autologin key cookie still is the same as what is stored in the sessions table and both are not empty
        $salt = '';
        if (empty(trim($autoLoginKey)) || SEC_encryptPassword($autoLoginKey, $salt, $_CONF['pass_alg'], $_CONF['pass_stretch']) != DB_getItem($_TABLES['sessions'], 'autologin_key_hash', "sess_id = '$sessionId'")) {
            // Something is not right since cookie does not match key stored in db so generate a new one since the user is already logged in by this point
            $onlyExtendLifeSpan = false;
        }
    }

    $autoLoginKeyHash = '';
    if (!$onlyExtendLifeSpan) {
        // This is the key we store as a cookie
        $autoLoginKey = SEC_randomBytes(80);
        $autoLoginKey = sha1($autoLoginKey);

        // Extra bit of security. We store hash of key bassed on current Geeklog password encryption settings
        // Calculate hash to store in database so actual key is only stored in cookie on users device
        $salt = ''; // Can't use salt as we don't know the user at the point the auto login key is checked
        $autoLoginKeyHash = SEC_encryptPassword($autoLoginKey, $salt, $_CONF['pass_alg'], $_CONF['pass_stretch']);
    }

    $expiry_time = time() + $lifeTime;
    if (SEC_setCookie($_CONF['cookie_name'], $autoLoginKey, $expiry_time)) {
        // See if a auto login happened for this session and if so use same autologin key
        if (isset($_USER['auto_login']) && $_USER['auto_login']) {
            $origAutoLoginKeyHash = $_USER['autoLoginKeyHash'];
        } else {
            $origAutoLoginKeyHash = DB_getItem($_TABLES['sessions'], 'autologin_key_hash', "sess_id = '$sessionId'");
        }
        if (empty($autoLoginKeyHash)) {
            $autoLoginKeyHash = $origAutoLoginKeyHash;
        }
        $escOrigAutoLoginKeyHash = DB_escapeString($origAutoLoginKeyHash);

        $escAutoLoginKeyHash = DB_escapeString($autoLoginKeyHash);
        $escSessionId = DB_escapeString($sessionId);
        $sql = "UPDATE {$_TABLES['sessions']} SET autologin_key_hash = '{$escAutoLoginKeyHash}' "
            . "WHERE (uid = {$userId}) AND (sess_id = '{$escSessionId}')";
        DB_query($sql);

        // Replace record or create a new one. Always replace if we can as we don't want extra records hanging around
        if (!empty($origAutoLoginKeyHash) && !empty(DB_getItem($_TABLES['userautologin'], 'autologin_key_hash', "autologin_key_hash = '$escOrigAutoLoginKeyHash'"))) {
            $sql = "UPDATE {$_TABLES['userautologin']} SET autologin_key_hash = '{$escAutoLoginKeyHash}',  expiry_time = $expiry_time "
                . "WHERE (uid = {$userId}) AND (autologin_key_hash = '{$escOrigAutoLoginKeyHash}')";
        } else {
            $sql = "INSERT INTO {$_TABLES['userautologin']} (autologin_key_hash, expiry_time, uid) "
                . "VALUES ('{$escAutoLoginKeyHash}', $expiry_time, $userId) ";
        }
        DB_query($sql);

        return $autoLoginKey;
    } else {
        return false;
    }
}

/**
 * Delete an existing auto-login key for the current user (based on session id)
 */
function SESS_deleteAutoLoginKey()
{
    global $_CONF, $_TABLES;

    $sessionId = DB_escapeString(Session::getSessionId());
    $autoLoginKeyHash = DB_escapeString(DB_getItem($_TABLES['sessions'], 'autologin_key_hash', "sess_id = '$sessionId'"));
    $sql = "UPDATE {$_TABLES['sessions']} SET autologin_key_hash = '' WHERE sess_id = '{$sessionId}'";
    DB_query($sql);

    $sql = "DELETE FROM {$_TABLES['userautologin']} WHERE autologin_key_hash = '{$autoLoginKeyHash}' ";
    DB_query($sql);

    SEC_setCookie($_CONF['cookie_name'], '', time() - 10000);
}

/**
 * Delete any existing auto-login keys for a specified user
 *
 * @param  int     $uid
 */
function SESS_deleteUserAutoLoginKeys($uid)
{
    global $_TABLES, $_USER;

    if ($uid > 1) {
        $sql = "UPDATE {$_TABLES['sessions']} SET autologin_key_hash = '' WHERE uid = $uid";
        DB_query($sql);

        $sql = "DELETE FROM {$_TABLES['userautologin']} WHERE uid = $uid";
        DB_query($sql);
    }
}
