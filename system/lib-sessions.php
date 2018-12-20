<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-sessions.php                                                          |
// |                                                                           |
// | Geeklog session library.                                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2018 by the following authors:                         |
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
*
*/

// Turn this on if you want to see various debug messages from this library
$_SESS_VERBOSE = COM_isEnableDeveloperModeLog('session');

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-sessions.php') !== false) {
    die('This file can not be used on its own!');
}

if (empty ($_CONF['cookiedomain'])) {
    preg_match ("/\/\/([^\/:]*)/", $_CONF['site_url'], $server);
    if (substr ($server[1], 0, 4) == 'www.') {
        $_CONF['cookiedomain'] = substr ($server[1], 3);
    } else {
        if (strchr ($server[1], '.') === false) {
            // e.g. 'localhost' or other local names
            $_CONF['cookiedomain'] = '';
        } else {
            $_CONF['cookiedomain'] = '.' . $server[1];
        }
    }
    if ($_SESS_VERBOSE) {
        COM_errorLog ("Setting cookiedomain = '" . $_CONF['cookiedomain'] . "'", 1);
    }
}

/**
* This gets the state for the user
*
* Much of this code if from phpBB (www.phpbb.org).  This checks the session
* cookie and long term cookie to get the users state.
*
* @return   void
*
*/
function SESS_sessionCheck()
{
    global $_CONF, $_TABLES, $_USER, $_SESS_VERBOSE;

    if ($_SESS_VERBOSE) {
        COM_errorLog("*** Inside SESS_sessionCheck ***",1);
    }

    $_USER = array();

    // Check for a cookie on the users's machine.  If the cookie exists, build
    // an array of the users info and setup the theme.

    // Flag indicates if session cookie and session data exist
    $session_exists = true;

    if (isset($_COOKIE[$_CONF['cookie_session']])) {
        $sessid = COM_applyFilter($_COOKIE[$_CONF['cookie_session']]);
        if ($_SESS_VERBOSE) {
            COM_errorLog("Got $sessid as the session ID",1);
        }

        $userid = SESS_getUserIdFromSession($sessid, $_CONF['session_cookie_timeout'],
            $_SERVER['REMOTE_ADDR'], $_CONF['cookie_ip']);

        if ($_SESS_VERBOSE) {
            COM_errorLog("Got $userid as User ID from the session ID",1);
        }

        if ($userid > 1) {
            // Check user status
            $status = SEC_checkUserStatus($userid);
            if (($status == USER_ACCOUNT_ACTIVE) ||
                    ($status == USER_ACCOUNT_AWAITING_ACTIVATION ||
                    $status == USER_ACCOUNT_LOCKED ||
                    $status == USER_ACCOUNT_NEW_EMAIL ||
                    $status == USER_ACCOUNT_NEW_PASSWORD)) {
                SESS_updateSessionTime($sessid, $_CONF['cookie_ip']);
                $_USER = SESS_getUserDataFromId($userid);
                if ($_SESS_VERBOSE) {
                    $str = "Got " . count($_USER) . " pieces of data from userdata \n";
                    foreach ($_USER as $k => $v)
                        $str .= sprintf("%15s [%s] \n", $k, $v);
                    COM_errorLog($str, 1);
                }
                $_USER['auto_login'] = false;
            }
        } elseif ($userid == 1) {
            // Anonymous User has session so update any information
            SESS_updateSessionTime($sessid, $_CONF['cookie_ip']);
        } else {
            // Session probably expired
            $session_exists = false;
        }
    } else {
        if ($_SESS_VERBOSE) {
            COM_errorLog("Session cookie not found",1);
        }
        $session_exists = false;
    }

    if ($session_exists === false) {
        // Check if the permanent cookie exists
        $userid = '';
        if (isset($_COOKIE[$_CONF['cookie_name']])) {
            $userid = COM_applyFilter($_COOKIE[$_CONF['cookie_name']], true);
        }

        if (!empty($userid)) {
            // Session cookie or session data don't exist, but a permanent cookie does.
            // Start a new session cookie and session data;
            if ($_SESS_VERBOSE) {
                COM_errorLog("Got $userid as User ID from the permanent cookie",1);
            }

            $cookie_password = '';
            $userpass = '';
            if (($userid > 1) &&
                    isset($_COOKIE[$_CONF['cookie_password']])) {
                $cookie_password = $_COOKIE[$_CONF['cookie_password']];
                $userpass = DB_getItem($_TABLES['users'], 'passwd',
                                       "uid = $userid");
            }
            if (empty($cookie_password) || ($cookie_password <> $userpass)) {
                if ($_SESS_VERBOSE) {
                    COM_errorLog("Password comparison failed or cookie password missing",1);
                }

                // Invalid or manipulated cookie data
                $ctime = time() - 10000;
                SEC_setCookie($_CONF['cookie_session'], '', $ctime);
                SEC_setCookie($_CONF['cookie_password'], '', $ctime);
                SEC_setCookie($_CONF['cookie_name'], '', $ctime);

                COM_clearSpeedlimit($_CONF['login_speedlimit'], 'login');
                if (COM_checkSpeedlimit('login', $_CONF['login_attempts']) > 0) {
                    if (! defined('XHTML')) { define('XHTML', ''); }
                    COM_displayMessageAndAbort(82, '', 403, 'Access denied');
                }
                COM_updateSpeedlimit('login');
            } elseif ($userid > 1) {
                if ($_SESS_VERBOSE) {
                    COM_errorLog("Password comparison passed",1);
                }
                // Check user status
                $status = SEC_checkUserStatus($userid);
                if (($status == USER_ACCOUNT_ACTIVE) ||
                        ($status == USER_ACCOUNT_AWAITING_ACTIVATION)) {
                    if ($_SESS_VERBOSE) {
                        COM_errorLog("Create new session and write cookie",1);
                    }
                    // Create new session and write cookie
                    $sessid = SESS_newSession($userid, $_SERVER['REMOTE_ADDR'],
                        $_CONF['session_cookie_timeout'], $_CONF['cookie_ip']);
                    SESS_setSessionCookie($sessid, $_CONF['session_cookie_timeout'],
                        $_CONF['cookie_session'], $_CONF['cookie_path'],
                        $_CONF['cookiedomain'], $_CONF['cookiesecure']);
                    $_USER = SESS_getUserDataFromId($userid);
                    $_USER['auto_login'] = true;
                }
            }
        } else {
            if ($_SESS_VERBOSE) {
                COM_errorLog("Permanent cookie not found",1);
            }

            // Anonymous user has session id but it has been expired and wiped from the db so reset.
            // Or new anonymous user so create new session and write cookie.
            $userid = 1;
            $sessid = SESS_newSession($userid, $_SERVER['REMOTE_ADDR'],
                $_CONF['session_cookie_timeout'], $_CONF['cookie_ip']);
            SESS_setSessionCookie($sessid, $_CONF['session_cookie_timeout'],
                $_CONF['cookie_session'], $_CONF['cookie_path'],
                $_CONF['cookiedomain'], $_CONF['cookiesecure']);
        }
    }

    if ($_SESS_VERBOSE) {
        COM_errorLog("*** Leaving SESS_sessionCheck ***",1);
    }

    $_USER['session_id'] = $sessid;
    
    // Check to see if user status is set to something we have to redirect the user too
    if (isset($_USER['uid']) && $_USER['uid'] > 1) {
        // Check if active user has email account and if required
        // Doesn't matter if remote account or not
        if ($_CONF['require_user_email'] && empty($_USER['email']) && $_USER['status'] == USER_ACCOUNT_ACTIVE) {
            $_USER['status'] = USER_ACCOUNT_NEW_EMAIL;
            DB_change($_TABLES['users'], 'status', USER_ACCOUNT_NEW_EMAIL, 'uid', $_USER['uid']);
        }
        
        if ($_USER['status'] == USER_ACCOUNT_LOCKED) {
            // Account is locked so user shouldn't be logged in
            if ($_SERVER['PHP_SELF'] != '/users.php') {
                COM_redirect($_CONF['site_url'] . '/users.php?mode=logout&msg=17');  
            }
        } elseif ($_USER['status']  == USER_ACCOUNT_NEW_EMAIL || $_USER['status'] == USER_ACCOUNT_NEW_PASSWORD) {
            // Account requires additional info so get it
            if ($_SERVER['PHP_SELF'] != '/users.php') {
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
* @param        int         $userid         User ID to create session for
* @param        string      $remote_ip      IP address user is connected from
* @param        string      $lifespan       How long (seconds) this cookie should persist
* @param        int         $md5_based      If 1 session will be MD5 hash of ip address
* @return       string      Session ID
*
*/
function SESS_newSession($userid, $remote_ip, $lifespan, $md5_based=0)
{
    global $_TABLES, $_CONF, $_SESS_VERBOSE;

    if ($_SESS_VERBOSE) {
        COM_errorLog("*** Inside SESS_newSession ***",1);
        COM_errorLog("Args to SESS_newSession: userid = $userid, "
            . "remote_ip = $remote_ip, lifespan = $lifespan, "
            . "md5_based = $md5_based",1);
    }
    $sessid = mt_rand();

    // For added security we are adding the option to build a IP-based
    // session ID.  This has the advantage of better security but it may
    // required dialed users to login every time.  You can turn the below
    // code on in the configuration (it's turned off by default)
    $md5_sessid = '';
    if ($md5_based == 1) {
        $ip = str_replace('.','',$remote_ip);
        $md5_sessid = md5($ip + $sessid);
    }

    $ctime = time();
    $currtime = (string) ($ctime);
    $expirytime = (string) ($ctime - $lifespan);
    if (!isset($_COOKIE[$_CONF['cookie_session']])) {
        // ok, delete any old sessons for this user
        if ($userid > 1) {
            DB_delete($_TABLES['sessions'], 'uid', $userid);
        } else {
            DB_delete($_TABLES['sessions'], array('uid', 'remote_ip'),
                                            array(1, $remote_ip));
        }
    } else {
        DB_lockTable($_TABLES['sessions']);
        $deleteSQL = "DELETE FROM {$_TABLES['sessions']} WHERE (start_time < $expirytime)";
        $delresult = DB_query($deleteSQL);
        DB_unlockTable($_TABLES['sessions']);

        if ($_SESS_VERBOSE) {
            COM_errorLog("Attempted to delete rows from session table with following SQL\n$deleteSQL\n",1);
            COM_errorLog("Got $delresult as a result from the query",1);
        }

        if (!$delresult) {
            die("Delete failed in SESS_newSession()");
        }
    }
    // Remove the anonymous session for this user
    if ($userid > 1) {
        // Retrieve any session variables that we need to add to the new logged in session
        // To come
        // Delete record
        DB_delete($_TABLES['sessions'], array('uid', 'remote_ip'),
                                        array(1, $remote_ip));
    }

    // Create new session
    if ($md5_based == 1) {
        $sql = "INSERT INTO {$_TABLES['sessions']} "
            . "(sess_id, md5_sess_id, uid, start_time, remote_ip, whos_online) "
            . "VALUES ($sessid, '$md5_sessid', $userid, $currtime, '$remote_ip', 1)";
    } else {
        $sql = "INSERT INTO {$_TABLES['sessions']} "
            . "(sess_id, uid, start_time, remote_ip, whos_online) "
            . "VALUES ($sessid, $userid, $currtime, '$remote_ip', 1)";
    }
    $result = DB_query($sql);
    if (!$result) {
        echo DB_error().": ".DB_error()."<br" . XHTML . ">";
        die("Insert failed in SESS_newSession()");
    }

    if ($_CONF['lastlogin'] == true) {
        // Update userinfo record to record the date and time as lastlogin
        DB_query("UPDATE {$_TABLES['userinfo']} SET lastlogin = UNIX_TIMESTAMP() WHERE uid=$userid");
    }
    if ($_SESS_VERBOSE) {
        COM_errorLog("Assigned the following session id: $sessid",1);
        COM_errorLog("*** Leaving SESS_newSession ***",1);
    }
    if ($md5_based == 1) {
        return $md5_sessid;
    }
    return $sessid;
}

/**
* Sets the session cookie
*
* This saves the session ID to the session cookie on client's machine for
* later use
*
* @param        string      $sessid         Session ID to save to cookie
* @param        int         $cookietime     Cookie timeout value (not used)
* @param        string      $cookiename     Name of cookie to save sessiond ID to
* @param        string      $cookiepath     Path in which cookie should be sent to server for
* @param        string      $cookiedomain   Domain in which cookie should be sent to server for
* @param        int         $cookiesecure   if =1, set cookie only on https connection
*
*/
function SESS_setSessionCookie($sessid, $cookietime, $cookiename, $cookiepath, $cookiedomain, $cookiesecure)
{
    global $_SESS_VERBOSE;

    // This sets a cookie that will persist until the user closes their browser
    // window. since session expiry is handled on the server-side, cookie expiry
    // time isn't a big deal.
    if ($_SESS_VERBOSE) {
        COM_errorLog("Setting session cookie: setcookie($cookiename, $sessid, 0, "
            . "$cookiepath, $cookiedomain, $cookiesecure);", 1);
    }

    if (SEC_setCookie($cookiename, $sessid, 0, $cookiepath, $cookiedomain,
                      $cookiesecure) === false) {
        COM_errorLog("Failed to set session cookie.", 1);
    }
}

/**
* Gets the user id from Session ID
*
* Returns the userID associated with the given session, based on
* the given session lifespan $cookietime and the given remote IP
* address. If no match found, returns 0.
*
* @param        string      $sessid         Session ID to get user ID from
* @param        string      $cookietime     Used to query DB for valid sessions
* @param        string      $remote_ip      Used to pull session we need
* @param        int         $md5_based      Let's us now if we need to take MD5 hash into consideration
* @return       int         User ID
*/
function SESS_getUserIdFromSession($sessid, $cookietime, $remote_ip, $md5_based=0)
{
    global $_TABLES, $_SESS_VERBOSE;

    if ($_SESS_VERBOSE) {
        COM_errorLog("*** Inside SESS_getUserIdFromSession ***",1);
    }

    $mintime = (string) (time() - $cookietime);

    if ($md5_based == 1) {
        $sql_where = "md5_sess_id = '$sessid'";
    } else {
        $sql_where = "sess_id = '$sessid'";
    }
    $sql = "SELECT uid FROM {$_TABLES['sessions']} WHERE "
        . "($sql_where) AND (start_time > $mintime) AND (remote_ip = '$remote_ip')";

    if ($_SESS_VERBOSE) {
        COM_errorLog("SQL in SESS_getUserIdFromSession is: \n$sql \n", 1);
    }

    $result = DB_query($sql);
    $numrows = DB_numRows($result);

    if ($_SESS_VERBOSE) {
        COM_errorLog("*** Leaving SESS_getUserIdFromSession ***",1);
    }

    if ($numrows == 1) {
        $row = DB_fetchArray($result);
        return $row['uid'];
    }
    return 0;
}

/**
* Updates a session cookies timeout
*
* Refresh the start_time of the given session in the database.
* This is called whenever a page is hit by a user with a valid session.
*
* @param        string      $sessid     Session ID to update time for
* @param        int         $md5_based  Indicates if sessid is MD5 hash
* @return       boolean     always true for some reason
*
*/
function SESS_updateSessionTime($sessid, $md5_based=0)
{
    global $_TABLES;

    $newtime = (string) time();

    if ($md5_based == 1) {
        $sql_where = "md5_sess_id = '$sessid'";
    } else {
        $sql_where = "sess_id = '$sessid'";
    }
    DB_query("UPDATE {$_TABLES['sessions']} "
        . "SET start_time = $newtime, whos_online = 1 WHERE ($sql_where)");

    return 1;
}

/**
* This ends a user session
*
* Delete the given session from the database. Used by the logout page.
*
* @param        int     $userid     User ID to end session of
* @return       boolean     Always true for some reason
*
*/
function SESS_endUserSession($userid)
{
    global $_CONF, $_TABLES;

    if (!(isset($_CONF['demo_mode']) && $_CONF['demo_mode'])) {
        DB_delete($_TABLES['sessions'], 'uid', $userid);
    }

    return 1;
}

/**
* Gets a user's data
*
* Gets user's data based on their username
*
* @param        string     $username        Username of user to get data for
* @return       array       returns user's data in an array
*
*/
function SESS_getUserData($username)
{
    global $_TABLES;

    $sql = "SELECT *,format FROM {$_TABLES['users']}, {$_TABLES['userprefs']}, {$_TABLES['dateformats']} "
        . "WHERE {$_TABLES['dateformats']}.dfid = {$_TABLES['userprefs']}.dfid AND "
        . "{$_TABLES['userprefs']}.uid = {$_TABLES['users']}.uid AND username = '$username'";

    if (!$result = DB_query($sql)) {
        COM_errorLog("Error in SESS_getUserData", 1);
    }

    if (!$myrow = DB_fetchArray($result)) {
        COM_errorLog("Error in SESS_getUserData", 1);
    }

    return $myrow;
}

/**
* Gets user's data
*
* Gets user's data based on their user id
*
* @param    int     $userid     User ID of user to get data for
* @return   array               returns user's data in an array
*
*/
function SESS_getUserDataFromId($userid)
{
    global $_TABLES;

    $sql = "SELECT *,format FROM {$_TABLES['dateformats']},{$_TABLES['users']},{$_TABLES['userprefs']} "
        . "WHERE {$_TABLES['dateformats']}.dfid = {$_TABLES['userprefs']}.dfid AND "
        . "{$_TABLES['userprefs']}.uid = $userid AND {$_TABLES['users']}.uid = $userid";

    if (!$result = DB_query($sql)) {
        $userdata = array('error' => '1');
        return $userdata;
    }

    if (!$myrow = DB_fetchArray($result, false)) {
        $userdata = array('error' => '1');
        return $userdata;
    }

    return $myrow;
}


/**
* Gets the Session ID from the User Id
*
* Returns the session id associated with the user if available.
* This is not for anonymous users. If no match found, returns an empty string.
*
* @param        int      $uid         User Id to retrieve session Id for
* @return       string                Session ID
*/
function SESS_getSessionIdFromUserId($uid)
{
    global $_TABLES;

    $retval = '';
    if ($uid > 1) {
        $retval = DB_getItem($_TABLES['sessions'], "sess_id", "uid = $uid");
    }

    return $retval;
}

/**
* Retrieves a session variable from the db
*
* @param        string      $variable   Variable name to retrieve
* @return       string     data from variable
*
*/
function SESS_getVariable($variable)
{
    global $_TABLES, $_CONF, $_USER;

    $session_id = $_USER['session_id'];

    if ($_CONF['cookie_ip'] == 1) { // $md5_based  Indicates if sessid is MD5 hash
        $sql_where = "md5_sess_id = '$session_id'";
    } else {
        $sql_where = "sess_id = '$session_id'";
    }
    $retval = DB_getItem($_TABLES['sessions'], $variable, $sql_where);

    return $retval;
}

/**
* Updates a session variable from the db
*
* @param        string      $variable   Variable name to update
* @param        string      $value      Value of variable
* @param        string      $session_id Session ID of variable to update (0 = current session)
* @return       boolean     always true for some reason
*
*/
function SESS_setVariable($variable, $value, $session_id = '')
{
    global $_TABLES, $_CONF, $_USER;

    if ($session_id === '') {
        $session_id = $_USER['session_id'];
    }

    if ($_CONF['cookie_ip'] == 1) { // $md5_based  Indicates if sessid is MD5 hash
        $sql_where = "md5_sess_id = '$session_id'";
    } else {
        $sql_where = "sess_id = '$session_id'";
    }
    DB_query("UPDATE {$_TABLES['sessions']} "
        . "SET $variable = '$value' WHERE ($sql_where)");

    return 1;
}
