<?php 
/**
 * new_session()
 * Adds a new session to the database for the given userid.
 * Returns the new session ID.
 * Also deletes all expired sessions from the database, based on the given session lifespan.
 */
function new_session($userid, $remote_ip, $lifespan, $md5_based=0) {

        mt_srand((double)microtime()*1000000);
        $sessid = mt_rand();

	// For added security we are adding the option to build a IP-based
	// session ID.  This has the advantage of better security but it may
	// required dialed users to login every time.  You can turn the below
	// code on in config.php (it's turned off by default)
	if ($md5_based == 1) {
		errorlog("in ipbasedsessid code", 1);
		$ip = str_replace(".","",$remote_ip);
		$md5_sessid = md5($ip + $sessid);
	} else
		$md5_sessid = ""; 		
	errorlog("ip = $ip",1);

        $currtime = (string) (time());
        $expirytime = (string) (time() - $lifespan);

        $deleteSQL = "DELETE FROM sessions WHERE (start_time < $expirytime)";
        $delresult = mysql_query($deleteSQL);

        if (!$delresult) {
                die("Delete failed in new_session()");
        }
        $sql = "INSERT INTO sessions (sess_id, md5_sess_id, uid, start_time, remote_ip) VALUES ($sessid, '$md5_sessid', $userid, $currtime, '$remote_ip')";
	//errorlog("sql = $sql");

        $result = mysql_query($sql);

        if ($result) {
		if ($md5_based == 1)
			return $md5_sessid;
		else
                	return $sessid;
        } else {
                echo mysql_errno().": ".mysql_error()."<BR>";
                die("Insert failed in new_session()");
        } // if/else

} // new_session()

/**
 * Sets the sessID cookie for the given session ID. the $cookietime parameter
 * is no longer used, but just hasn't been removed yet. It'll break all the modules
 * (just login) that call this code when it gets removed.
 * Sets a cookie with no specified expiry time. This makes the cookie last until the
 * user's browser is closed. (at last that's the case in IE5 and NS4.7.. Haven't tried
 * it with anything else.)
 */
function set_session_cookie($sessid, $cookietime, $cookiename, $cookiepath, $cookiedomain, $cookiesecure) {
        // This sets a cookie that will persist until the user closes their browser window.
        // since session expiry is handled on the server-side, cookie expiry time isn't a big deal.
        #setcookie($cookiename,$sessid,'',$cookiepath,$cookiedomain,$cookiesecure);
	setcookie($cookiename,$sessid,'',$cookiepath);

} // set_session_cookie()


/**
 * Returns the userID associated with the given session, based on
 * the given session lifespan $cookietime and the given remote IP
 * address. If no match found, returns 0.
 */
function get_userid_from_session($sessid, $cookietime, $remote_ip, $md5_based=0) {
        $mintime = time() - $cookietime;
	if ($md5_based == 1)
		$sql = "SELECT uid FROM sessions WHERE (md5_sess_id = '$sessid') AND (start_time > $mintime) AND (remote_ip = '$remote_ip')";
	else
        	$sql = "SELECT uid FROM sessions WHERE (sess_id = $sessid) AND (start_time > $mintime) AND (remote_ip = '$remote_ip')";
        $result = dbquery($sql);
        if (!$result) {
                echo mysql_error() . "<br>\n";
                errorlog("Error doing DB query in get_userid_from_session()");
        }
        $row = mysql_fetch_array($result);

        if (!$row) {	
                return 0;
        } else {
                return $row[uid];
        }

} // get_userid_from_session()

/**
 * Refresh the start_time of the given session in the database.
 * This is called whenever a page is hit by a user with a valid session.
 */
function update_session_time($sessid, $md5_based=0) {

        $newtime = (string) time();
	if ($md5_based == 1)
		$sql = "UPDATE sessions SET start_time=$newtime WHERE (md5_sess_id = '$sessid')";
	else
        	$sql = "UPDATE sessions SET start_time=$newtime WHERE (sess_id = $sessid)";

        $result = dbquery($sql);
        if (!$result) {
                echo mysql_error() . "<br>\n";
                die("Error doing DB update in update_session_time()");
        }
        return 1;

} // update_session_time()

/**
 * Delete the given session from the database. Used by the logout page.
 */
function end_user_session($userid, $db) {

        $sql = "DELETE FROM sessions WHERE (uid = $userid)";
        $result = dbquery($sql);
        if (!$result) {
                echo mysql_error() . "<br>\n";
                die("Delete failed in end_user_session()");
        }
        return 1;

} // end_session()

/**
 * Prints either "logged in as [username]. Log out." or
 * "Not logged in. Log in.", depending on the value of
 * $user_logged_in.
 */
function print_login_status($user_logged_in, $username, $url_phpbb) {
        global $phpEx;
        global $l_loggedinas, $l_notloggedin, $l_logout, $l_login;

        if($user_logged_in) {
                echo "<b>$l_loggedinas $username. <a href=\"$url_phpbb/logout.$phpEx\">$l_logout.</a></b><br>\n";
        } else {
                echo "<b>$l_notloggedin. <a href=\"$url_phpbb/login.$phpEx\">$l_login.</a></b><br>\n";
        }
} // print_login_status()

/**
 * Prints a link to either login.php or logout.php, depending
 * on whether the user's logged in or not.
 */
function make_login_logout_link($user_logged_in, $url_phpbb) {
        global $phpEx;
        global $l_logout, $l_login;
        if ($user_logged_in) {
                $link = "<a class=storybyline href=\"../users.php?mode=logout\">$l_logout</a>";
        } else {
                $link = "<a class=storybyline href=\"$url_phpbb/login.$phpEx\">$l_login</a>";
        }
        return $link;
} // make_login_logout_link()

/*
 * Gets user's data based on their username
 */
function get_userdata($username) {
	$sql = "SELECT  users.uid, username, username name, seclev, email, homepage, sig,noicons, dfid FROM users, userprefs WHERE userprefs.uid = users.uid AND username = '$username'";
        if(!$result = dbquery($sql))
		errorlog("error in get_userdata");
        if(!$myrow = mysql_fetch_array($result))
		errorlog("error in get_userdata");
        return($myrow);
}

function get_userdata_from_id($userid) {

        $sql = "SELECT * FROM users WHERE uid = $userid";
        if(!$result = dbquery($sql)) {
                $userdata = array("error" => "1");
                return ($userdata);
        }
        if(!$myrow = mysql_fetch_array($result)) {
                $userdata = array("error" => "1");
                return ($userdata);
        }

        return($myrow);
}

?>
