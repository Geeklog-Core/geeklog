<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | users.php                                                                 |
// | User authentication module.                                               |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@users.sourceforge.net                |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
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
// $Id: users.php,v 1.40 2002/08/14 11:42:37 dhaun Exp $

/**
* This file handles user authentication
*
* @author   Tony Bibbs <tony@tonybibbs.com>
* @author   Mark Limburg <mlimburg@users.sourceforge.net>
* @author   Jason Whittenburg
*
*/

/**
* Geeklog common function library
*/
require_once('lib-common.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

// echo COM_debug($HTTP_POST_VARS);

/**
* Shows a profile for a user
*
* This grabs the user profile for a given user and displays it
*
* @param    int     $user       User ID of profile to get
* @return   string  HTML for user profile page
*
*/
function userprofile($user) 
{
    global $_TABLES, $_CONF, $_USER, $LANG04, $LANG01, $LANG_LOGIN, $_GROUPS;

    if (empty ($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['profileloginrequired'] == 1))) {
        $retval .= COM_startBlock($LANG_LOGIN[1]);
        $login = new Template($_CONF['path_layout'] . 'submit');
        $login->set_file (array ('login'=>'submitloginrequired.thtml'));
        $login->set_var ('login_message', $LANG_LOGIN[2]);
        $login->set_var ('site_url', $_CONF['site_url']);
        $login->set_var ('lang_login', $LANG_LOGIN[3]);
        $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
        $login->parse ('output', 'login');
        $retval .= $login->finish ($login->get_var('output'));
        $retval .= COM_endBlock();
 
        return $retval;
    }

    $retval = '';
	
    $result = DB_query("SELECT username,fullname,regdate,homepage,about,pgpkey,photo FROM {$_TABLES['userinfo']},{$_TABLES["users"]} WHERE {$_TABLES['userinfo']}.uid = {$_TABLES['users']}.uid AND {$_TABLES['users']}.uid = $user");
    $nrows = DB_numRows($result);
    if ($nrows == 0) { // no such user
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }
    $A = DB_fetchArray($result);

    // format date/time to user preference
    $curtime = COM_getUserDateTimeFormat($A["regdate"]);
    $A['regdate'] = $curtime[0];

    $user_templates = new Template($_CONF['path_layout'] . 'users');
    $user_templates->set_file(array('profile'=>'profile.thtml','row'=>'commentrow.thtml','strow'=>'storyrow.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('start_block_userprofile', COM_startBlock($LANG04[1] . ' ' . $A['username']));
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('username', $A['username']);
    if (!empty($A['photo']) AND $_CONF['allow_user_photo'] == 1) {
        $user_templates->set_var('user_photo','<img src="' . $_CONF['site_url'] . '/images/userphotos/' . $A['photo'] . '" alt="">');
    } else {
        $user_templates->set_var('user_photo','');
    }
    $user_templates->set_var('user_fullname', $A['fullname']);
    $user_templates->set_var('lang_membersince', $LANG04[67]);
    $user_templates->set_var('user_regdate', $A['regdate']);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('user_id', $user);
    $user_templates->set_var('lang_sendemail', $LANG04[81]);
    $user_templates->set_var('lang_homepage', $LANG04[6]);
    $user_templates->set_var('user_homepage', $A['homepage']);
    $user_templates->set_var('lang_bio', $LANG04[7]);
    $user_templates->set_var('user_bio', nl2br(stripslashes($A['about']))); 
    $user_templates->set_var('lang_pgpkey', $LANG04[8]);
    $user_templates->set_var('user_pgp', nl2br($A['pgpkey']));
    $user_templates->set_var('start_block_last10stories',
            COM_startBlock($LANG04[82] . ' ' . $A['username']));
    $user_templates->set_var('start_block_last10comments',
            COM_startBlock($LANG04[10] . ' ' . $A['username']));
    $user_templates->set_var('start_block_postingstats',
            COM_startBlock($LANG04[83] . ' ' . $A['username']));
    // for alternative layouts: use these as headlines instead of block titles
    $user_templates->set_var('headline_last10stories', $LANG04[82]);
    $user_templates->set_var('headline_last10comments', $LANG04[10]);
    $user_templates->set_var('headline_postingstats', $LANG04[83]);

    // list of last 10 stories by this user
    $groupList = '';
    $sql = "SELECT sid,title,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['stories']} WHERE (uid = $user) AND (draft_flag = 0) AND (date <= NOW()) AND (";
    if (!empty ($_USER['uid'])) {
        foreach ($_GROUPS as $grp) {
            $groupList .= $grp . ',';
        }
        $groupList = substr ($groupList, 0, -1);
        $sql .= "(owner_id = {$_USER['uid']} AND perm_owner >= 2) OR ";
        $sql .= "(group_id IN ($groupList) AND perm_group >= 2) OR ";
    }
    $sql .= "(perm_anon >= 2)) ORDER BY unixdate DESC LIMIT 10";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $C = DB_fetchArray($result);
            $user_templates->set_var('row_number', $i . '.');
            $user_templates->set_var('story_begin_href', '<a href="' .
                $_CONF['site_url'] . '/article.php?story=' . $C['sid'] . '">');
            $user_templates->set_var('story_title', stripslashes($C['title']));
            $user_templates->set_var('story_end_href', '</a>');
            $storytime = COM_getUserDateTimeFormat($C['unixdate']);
            $user_templates->set_var('story_date', $storytime[0]);
            $user_templates->parse('story_row','strow',true);
        }
    } else {
        $user_templates->set_var('story_row','<tr><td>' . $LANG01[37] . '</td></tr>');
    }

    // list of last 10 comments by this user
    // first, get a list of all stories the current visitor has access to
    $sql = "SELECT sid FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) AND (";
    if (!empty ($_USER['uid'])) {
        $sql .= "(owner_id = {$_USER['uid']} AND perm_owner >= 2) OR ";
        $sql .= "(group_id IN ($groupList) AND perm_group >= 2) OR ";
    }
    $sql .= "(perm_anon >= 2))";
    $result = DB_query($sql);
    $numsids = DB_numRows($result);
    $sidList = '';
    for ($i = 1; $i <= $numsids; $i++) {
        $S = DB_fetchArray ($result);
        $sidList .= $S['sid'];
        if ($i != $numsids) {
            $sidList .= ',';
        }
    }
    // add all polls the current visitor has access to
    $sql = "SELECT qid FROM {$_TABLES['pollquestions']} WHERE ";
    if (!empty ($_USER['uid'])) {
        $sql .= "(owner_id = {$_USER['uid']} AND perm_owner >= 2) OR ";
        $sql .= "(group_id IN ($groupList) AND perm_group >= 2) OR ";
    }
    $sql .= "(perm_anon >= 2)";
    $result = DB_query($sql);
    $numqids = DB_numRows($result);
    if (($numqids > 0) && !empty ($sidList)) {
        $sidList .= ',';
    }
    for ($i = 1; $i <= $numqids; $i++) {
        $Q = DB_fetchArray ($result);
        $sidList .= "'" . $Q['qid'] . "'";
        if ($i != $numqids) {
            $sidList .= ',';
        }
    }
    // then, find all comments by the user in those stories and polls
    $sql = "SELECT sid,title,pid,type,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['comments']} WHERE (uid = $user) AND (sid in ($sidList)) ORDER BY unixdate DESC LIMIT 10";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $C = DB_fetchArray($result);
            $user_templates->set_var('row_number', $i . '.');
            if ($C['type'] == 'article') {
                $user_templates->set_var('comment_begin_href',
                    '<a href="' . $_CONF['site_url'] .
                    '/comment.php?mode=display&amp;sid=' . $C['sid'] .
                    '&amp;title=' . urlencode($C['title']) . '&amp;pid=' .
                    $C['pid'] . '">');
            } else {
                $user_templates->set_var('comment_begin_href',
                    '<a href="' . $_CONF['site_url'] .
                    '/comment.php?mode=display&amp;sid=' . $C['sid'] .
                    '&amp;title=' . urlencode($C['title']) . '&amp;pid=' .
                    $C['pid'] . '&amp;qid=' . $C['sid'] . '">');
            }
            $user_templates->set_var('comment_title', stripslashes($C['title']));
            $user_templates->set_var('comment_end_href', '</a>');
            $commenttime = COM_getUserDateTimeFormat($C['unixdate']);
            $user_templates->set_var('comment_date', $commenttime[0]); 
            $user_templates->parse('comment_row','row',true);
        }
    } else {
        $user_templates->set_var('comment_row','<tr><td>' . $LANG01[29] . '</td></tr>');
    }

    // posting stats for this user
    $user_templates->set_var ('lang_number_stories', $LANG04[84]);
    $sql = "SELECT count(*) AS count FROM {$_TABLES['stories']} WHERE (uid = $user) AND (draft_flag = 0) AND (date <= NOW()) AND (";
    if (!empty ($_USER['uid'])) {
        $sql .= "(owner_id = {$_USER['uid']} AND perm_owner >= 2) OR ";
        $sql .= "(group_id IN ($groupList) AND perm_group >= 2) OR ";
    }
    $sql .= "(perm_anon >= 2))";
    $result = DB_query($sql);
    $N = DB_fetchArray ($result);
    $user_templates->set_var('number_stories', $N['count']);
    $user_templates->set_var ('lang_number_comments', $LANG04[85]);
    $sql = "SELECT count(*) AS count FROM {$_TABLES['comments']} WHERE (uid = $user) AND (sid in ($sidList))";
    $result = DB_query($sql);
    $N = DB_fetchArray ($result);
    $user_templates->set_var('number_comments', $N['count']);
    $user_templates->set_var ('lang_all_postings_by', $LANG04[86] . ' ' . $A['username']);

    $user_templates->parse('output', 'profile');
    $retval .= $user_templates->finish($user_templates->get_var('output'));	

    return $retval;
}

/**
* Emails password to a user
*
* This will email the given user their password.
*
* @param    string      $username       Username for which to get and email password
* @param    int         $msg            Message number of message to show when done
* @return   string      Optionally returns the HTML for the default form if the user info can't be found
*
*/
function emailpassword($username,$msg=0) 
{
    global $_TABLES, $_CONF, $LANG04, $LANG_CHARSET;
	
    $result = DB_query("SELECT email,passwd FROM {$_TABLES['users']} WHERE username = '$username'");
    $nrows = DB_numRows($result);
    if ($nrows == 1) {
        $A = DB_fetchArray($result);
        if (($_CONF['usersubmission'] == 1) && ($A['passwd'] == md5(''))) {
            return COM_refresh ("{$_CONF['site_url']}/index.php?msg=48");
        }
        srand((double)microtime()*1000000);
        $passwd = rand();
        $passwd = md5($passwd);
        $passwd = substr($passwd,1,8);
        $passwd2 = md5($passwd);
        DB_change($_TABLES['users'],'passwd',"$passwd2",'username',$username);
        $mailtext = "{$LANG04[15]}\n\n";
        $mailtext .= "{$LANG04[2]}: $username\n";
        $mailtext .= "{$LANG04[4]}: $passwd\n\n";
        $mailtext .= "{$LANG04[14]}\n\n";
        $mailtext .= "{$_CONF["site_name"]}\n";
        $mailtext .= "{$_CONF['site_url']}\n";
        if (empty ($LANG_CHARSET)) {
            $charset = $_CONF['default_charset'];
            if (empty ($charset)) {
                $charset = "iso-8859-1";
            }
        }
        else {
            $charset = $LANG_CHARSET;
        }
        mail($A["email"]
            ,"{$_CONF["site_name"]}: {$LANG04[16]}"
            ,$mailtext
            ,"From: {$_CONF["site_name"]} <{$_CONF["site_mail"]}>\nReturn-Path: <{$_CONF["site_mail"]}>\nContent-Type: text/plain; charset={$charset}\nX-Mailer: GeekLog $VERSION"
            );
			
        if ($msg) {
            $retval .= COM_refresh("{$_CONF['site_url']}/index.php?msg=$msg");
        } else {
            $retval .= COM_refresh("{$_CONF['site_url']}/index.php");
        }
    } else {
        $retval .= COM_siteHeader('menu') . defaultform($LANG04[17]) . COM_siteFooter();
    }
	
    return $retval;
}

/**
* Creates a user
*
* Creates a user with the give username and email address
*
* @param    string      $username       username to create user for
* @param    string      $email          email address to assign to user
* @return   string      HTML for the form again if error occurs, otherwise nothing.
*
*/
function createuser($username,$email) 
{
    global $_TABLES, $LANG04, $_CONF;
	
    $ucount = DB_count($_TABLES['users'],'username',$username);
    $ecount = DB_count($_TABLES['users'],'email',$email);
	
    if ($ucount == 0 AND $ecount == 0) {
        if (COM_isEmail($email)) {
            $regdate = strftime('%Y-%m-%d %H:%M:$S',time());
            DB_save($_TABLES['users'],'username,email,regdate',"'$username','$email','$regdate'");
            $uid = DB_getItem($_TABLES['users'],'uid',"username = '$username'");

            // Add user to Logged-in group (i.e. members) and the All Users group (which includes
            // anonymous users
            $normal_grp = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='Logged-in Users'");
            $all_grp = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='All Users'");
            DB_query("INSERT INTO {$_TABLES["group_assignments"]} (ug_main_grp_id,ug_uid) values ($normal_grp, $uid)");
            DB_query("INSERT INTO {$_TABLES["group_assignments"]} (ug_main_grp_id,ug_uid) values ($all_grp, $uid)");
            DB_query("INSERT INTO {$_TABLES["userprefs"]} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES["userindex"]} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES["usercomment"]} (uid) VALUES ($uid)");
            DB_query("INSERT INTO {$_TABLES["userinfo"]} (uid) VALUES ($uid)");
            if ($_CONF['usersubmission'] == 1) {
                $queueUser = true;
                if (!empty ($_CONF['allow_domains'])) {
                    $allowed = explode (',', $_CONF['allow_domains']);
                    // Note: We already made sure $email is a valid address
                    $domain = substr ($email, strpos ($email, '@') + 1);
                    if (in_array ($domain, $allowed)) {
                        $queueUser = false;
                    }
                }
                if ($queueUser) {
                    $passwd = md5('');
                    DB_change($_TABLES['users'],'passwd',"$passwd",'username',$username);
                    $msg = 48;
                } else {
                    emailpassword($username, 1);
                    $msg = 1;
                }
            } else {
                emailpassword($username, 1);
                $msg = 1;
            }
            DB_change($_TABLES['usercomment'],'commentmode',$_CONF['comment_mode'],'uid',$uid);
            DB_change($_TABLES['usercomment'],'commentlimit',$_CONF['comment_limit'],'uid',$uid); 

            return COM_refresh($_CONF['site_url'] . '/index.php?msg=' . $msg);
        } else {
            $retval .= COM_siteHeader('Menu') . newuserform($LANG04[18]) . COM_siteFooter();
        }
    } else {
        $retval .= COM_siteHeader('Menu') . newuserform($LANG04[19]) . COM_siteFooter();
    }
    return $retval;
}

/**
* Shows the user login form after failed attempts to either login or access a page
* requiring login. 
*
* @return   string      HTML for login form
*
*/
function loginform()
{
    global $_CONF, $LANG04;

    $retval = '';

    $user_templates = new Template ($_CONF['path_layout'] . 'users');
    $user_templates->set_file('login', 'loginform.thtml');
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('start_block_loginagain', COM_startBlock($LANG04[65]));
    $user_templates->set_var('lang_message', $LANG04[66]);
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('lang_password', $LANG04[4]);
    $user_templates->set_var('lang_forgetpassword', $LANG04[25]);
    $user_templates->set_var('lang_login', $LANG04[80]);
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->parse('output', 'login');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
* Shows the user registration form
*
* @param    int     $msg        message number to show
* @param    string  $referrer   page to send user to after registration
* @return   string  HTML for user registration page
*/
function newuserform($msg = '')
{
    global $LANG04, $_CONF;

    $retval = '';
    
	if (!empty($msg)) {
		$retval .= COM_startBlock($LANG04[21]) . $msg . COM_endBlock();
	}
    $user_templates = new Template($_CONF['path_layout'] . 'users');
    $user_templates->set_file('regform','registrationform.thtml');
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('start_block', COM_startBlock($LANG04[22]));
    $user_templates->set_var('lang_instructions', $LANG04[23]);
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('lang_warning', $LANG04[24]);
    $user_templates->set_var('lang_register', $LANG04[27]);
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->parse('output', 'regform');
    $retval .= $user_templates->finish($user_templates->get_var('output')); 
    return $retval;
}

/**
* Shows the password retrieval form
*
* @return   string  HTML for form used to retrieve user's password
*
*/
function getpasswordform()
{
    global $_CONF, $LANG04;

    $retval = '';

    $user_templates = new Template($_CONF['path_layout'] . 'users');
    $user_templates->set_file('form', 'getpasswordform.thtml');
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('start_block_forgetpassword', COM_startBlock($LANG04[25]));
    $user_templates->set_var('lang_instructions', $LANG04[26]);
    $user_templates->set_var('lang_username', $LANG04[2]);
    $user_templates->set_var('lang_emailpassword', $LANG04[28]);
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->parse('output', 'form');

    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
* Shows user their account info form
*
* @param    int     $msg        Id of message to display if one is needed
* @param    string  $referrer   
* @return   string  HTML for form
*
*/
function defaultform($msg, $referrer='') 
{
    global $LANG04, $_CONF;
	
	if (!empty($msg)) {
		$retval .= COM_startBlock($LANG04[21]) . $msg . COM_endBlock();
	}
	
	$retval .= COM_startBlock($LANG04[65])
		. '<form action="' . $_CONF['site_url'] . '/users.php" method="post">' . LB
		. '<table border="0" cellspacing="0" cellpadding="3">' . LB
		. '<tr><td colspan="2">' . $LANG04[66] . '</td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[2] . ':</b></td><td><input type="text" size="16" name="loginname"></td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[4] . ':</b></td><td><input type="password" name="passwd" size="16"></td></tr>' . LB
		. '<tr><td align="center" colspan="2"><input type="submit" value="Login"></td></tr>' . LB
		. '</table></form>'
		. COM_endBlock();
	
	$retval .= COM_startBlock($LANG04[22])
		. '<form action="' . $_CONF['site_url'] . '/users.php" method="post">' . LB
		. '<table border="0" cellspacing="0" cellpadding="3">' . LB
		. '<tr><td colspan="2">' . $LANG04[23] . '</td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[2] 
        . ':</b></td><td><input type="text" size="16" maxlength="16" name="username"></td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[5] 
        . ':</b></td><td><input type="text" size="16" maxlength="32" name="email"></td></tr>' . LB
		. '<tr><td align="center" class="warning" colspan="2">' . $LANG04[24] . '</td></tr>' . LB
		. '<tr><td align="center" colspan="2"><input type="hidden" name="mode" value="create"><input type="submit" value="'
        . $LANG04[27] . '"></td></tr>' . LB 
        . '</table></form>' 
        . COM_endBlock();
	
	$retval .= COM_startBlock($LANG04[25])
		. '<form action="' . $_CONF['site_url'] . '/users.php" method="post">' . LB
		. '<table border="0" cellspacing="0" cellpadding="3">' . LB
		. '<tr><td colspan="2">' . $LANG04[26] . '</td></tr>' . LB
		. '<tr><td align="right"><b>' . $LANG04[2] 
        . ':</b></td><td><input type="text" size="16" maxlength="16" name="username"></td></tr>' . LB
		. '<tr><td align="center" colspan="2"><input type="hidden" name="mode" value="emailpasswd">'
        . '<input type="submit" value="' . $LANG04[28] . '"></td></tr>' . LB
		. '</table></form>'
		. COM_endBlock();
	
	return $retval;
}

// MAIN
if (isset ($HTTP_POST_VARS['mode'])) {
    $mode = $HTTP_POST_VARS['mode'];
}
elseif (isset ($HTTP_GET_VARS['mode'])) {
    $mode = $HTTP_GET_VARS['mode'];
}
else {
    $mode = "";
}
switch ($mode) {
case 'logout':
    if (!empty($_USER['uid']) AND $_USER['uid'] > 1) {
        SESS_endUserSession($_USER['uid']);
        COM_accessLog("userid = {$HTTP_COOKIE_VARS[$_CONF["cookie_session"]]} {$LANG04[29]} $REMOTE_ADDR.");
    }
    setcookie($_CONF['cookie_session'],'',time() - 10000,$_CONF['cookie_path']);
    setcookie($_CONF['cookie_name'],'',time() - 10000,$_CONF['cookie_path']);
    $display .= COM_refresh($_CONF['site_url'] . '/index.php?msg=8');
    break;
case 'profile':
    $display .= COM_siteHeader('menu') . userprofile($HTTP_GET_VARS['uid']) . COM_siteFooter();
    break;
case 'create':
    $display .= createuser($HTTP_POST_VARS['username'],$HTTP_POST_VARS['email']);
    break;
case 'getpassword':
    $display .= COM_siteHeader('menu');
    $display .= getpasswordform();
    $display .= COM_siteFooter();
    break;
case 'emailpasswd':
    $display .= emailpassword($HTTP_POST_VARS['username'], 1);
    break;
case 'new':
    $display .= COM_siteHeader('menu');
    $display .= newuserform($msg);
    $display .= COM_siteFooter();
    break;
default:
    if (isset ($HTTP_POST_VARS['loginname'])) {
        $loginname = $HTTP_POST_VARS['loginname'];
    }
    if (isset ($HTTP_POST_VARS['passwd'])) {
        $passwd = $HTTP_POST_VARS['passwd'];
    }
    if (!empty($loginname) && !empty($passwd)) {
        $mypasswd = COM_getPassword($loginname);
    } else {
        srand((double)microtime()*1000000);
        $mypasswd = rand();
    }
    if (!empty($passwd) && $mypasswd == md5($passwd)) {
        $userdata = SESS_getUserData($loginname);
        $_USER=$userdata;
        $sessid = SESS_newSession($_USER['uid'], $REMOTE_ADDR, $_CONF['session_cookie_timeout'], $_CONF['cookie_ip']);
        SESS_setSessionCookie($sessid, $_CONF['session_cookie_timeout'], $_CONF['cookie_session'], $_CONF['cookie_path'], $_CONF['cookiedomain'], $_CONF['cookiesecure']);

        // Now that we handled session cookies, handle longterm cookie
        if (!isset($HTTP_COOKIE_VARS[$_CONF["cookie_name"]]) || !isset($HTTP_COOKIE_VARS['password'])) {
            // Either their cookie expired or they are new
            $cooktime = COM_getUserCookieTimeout();
            if ($VERBOSE) {
                COM_errorLog("Trying to set permanent cookie with time of $cooktime",1);
            }
            if (!empty($cooktime)) {
                // They want their cookie to persist for some amount of time so set it now
                if ($VERBOSE) {
                    COM_errorLog('Trying to set permanent cookie',1);
                }
                setcookie($_CONF['cookie_name'],$_USER['uid'],time() + $cooktime,$_CONF['cookie_path']);
                setcookie('password',md5($passwd),time() + $cooktime,$_CONF['cookie_path']);
            }
        } else {
            $userid = $HTTP_COOKIE_VARS[$_CONF['cookie_name']];
            if ($VERBOSE) {
                COM_errorLog('NOW trying to set permanent cookie',1);
                COM_errorLog('Got '.$userid.' from perm cookie in users.php',1);
            }
            if ($userid) {
                $user_logged_in = 1;
                // Create new session
                $userdata = SESS_getUserDataFromId($userid);
                $_USER = $userdata;
                if ($VERBOSE) {
                    COM_errorLog('Got '.$_USER['username'].' for the username in user.php',1);
                }
            }
        }

        // Now that we have users data see if their theme cookie is set.  If not set it
        setcookie('theme',$_USER['theme'],time() + 31536000,$_CONF['cookie_path']);
	
        // Increment the numlogins counter for this user
        // DB_change("users","numlogins","numlogins + 1","username","$loginname");
        if (($HTTP_REFERER) && ($HTTP_REFERER <> ($_CONF['site_url']."/users.php"))) {
            $indexMsg = $_CONF['site_url'] . '/index.php?msg=';
            if (substr ($HTTP_REFERER, 0, strlen ($indexMsg)) == $indexMsg) {
                $display .= COM_refresh($_CONF['site_url'] . '/index.php');
            } else {
                $display .= COM_refresh($HTTP_REFERER);
            }
        } else {
            $display .= COM_refresh($_CONF['site_url'] . '/index.php');
        }
    } else {
        $display .= COM_siteHeader('menu');

        $display .= COM_showMessage($msg);

        switch ($mode) {
        case 'create':
            // Got bad account info from registration process, show error message
            // and display form again
            $display .= newuserform();
            break;
        default:
            // Show login form
            $display .= loginform();
            break;
        }

        if ($mode != "new" && empty($msg)) {
            $msg = $LANG04[31];
        }

        //$display .= defaultform($msg) . COM_siteFooter();
        $display .= COM_siteFooter();
    }
    break;
}

echo $display;

?>
