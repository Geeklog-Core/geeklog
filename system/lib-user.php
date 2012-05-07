<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | lib-user.php                                                              |
// |                                                                           |
// | User-related functions needed in more than one place.                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-user.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Delete a user account
*
* @param    int       $uid   id of the user to delete
* @return   boolean   true = user deleted, false = an error occured
*
*/
function USER_deleteAccount ($uid)
{
    global $_CONF, $_TABLES, $_USER;

    // first some checks ...
    if ((($uid == $_USER['uid']) && ($_CONF['allow_account_delete'] == 1)) ||
            SEC_hasRights ('user.delete')) {
        if (SEC_inGroup ('Root', $uid)) {
            if (!SEC_inGroup ('Root')) {
                // can't delete a Root user without being in the Root group
                COM_accessLog ("User {$_USER['uid']} just tried to delete Root user $uid with insufficient privileges.");

                return false;
            } else {
                $rootgrp = DB_getItem ($_TABLES['groups'], 'grp_id',
                                       "grp_name = 'Root'");
                $result = DB_query ("SELECT COUNT(DISTINCT {$_TABLES['users']}.uid) AS count FROM {$_TABLES['users']},{$_TABLES['group_assignments']} WHERE {$_TABLES['users']}.uid > 1 AND {$_TABLES['users']}.uid = {$_TABLES['group_assignments']}.ug_uid AND ({$_TABLES['group_assignments']}.ug_main_grp_id = $rootgrp)");
                $A = DB_fetchArray ($result);
                if ($A['count'] <= 1) {
                    // make sure there's at least 1 Root user left
                    COM_errorLog ("You can't delete the last user from the Root group.", 1);
                    return false;
                }
            }
        }
    } else {
        // you can only delete your own account (if enabled) or you need
        // proper permissions to do so (user.delete)
        COM_accessLog ("User {$_USER['uid']} just tried to delete user $uid with insufficient privileges.");

        return false;
    }

    // log the user out
    SESS_endUserSession ($uid);

    // Ok, now delete everything related to this user

    // let plugins update their data for this user
    PLG_deleteUser ($uid);

    // Call custom account profile delete function if enabled and exists
    if ($_CONF['custom_registration'] && function_exists ('CUSTOM_userDelete')) {
        CUSTOM_userDelete ($uid);
    }

    // remove from all security groups
    DB_delete ($_TABLES['group_assignments'], 'ug_uid', $uid);

    // remove user information and preferences
    DB_delete ($_TABLES['userprefs'], 'uid', $uid);
    DB_delete ($_TABLES['userindex'], 'uid', $uid);
    DB_delete ($_TABLES['usercomment'], 'uid', $uid);
    DB_delete ($_TABLES['userinfo'], 'uid', $uid);

    // avoid having orphand stories/comments by making them anonymous posts
    DB_query ("UPDATE {$_TABLES['comments']} SET uid = 1 WHERE uid = $uid");
    DB_query ("UPDATE {$_TABLES['stories']} SET uid = 1 WHERE uid = $uid");
    DB_query ("UPDATE {$_TABLES['stories']} SET owner_id = 1 WHERE owner_id = $uid");

    // delete story submissions
    DB_delete ($_TABLES['storysubmission'], 'uid', $uid);

    // delete user photo, if enabled & exists
    if ($_CONF['allow_user_photo'] == 1) {
        $photo = DB_getItem ($_TABLES['users'], 'photo', "uid = $uid");
        USER_deletePhoto ($photo, false);
    }

    // in case the user owned any objects that require Admin access, assign
    // them to the Root user with the lowest uid
    $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
    $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
    $A = DB_fetchArray ($result);
    $rootuser = $A['ug_uid'];

    DB_query ("UPDATE {$_TABLES['blocks']} SET owner_id = $rootuser WHERE owner_id = $uid");
    DB_query ("UPDATE {$_TABLES['topics']} SET owner_id = $rootuser WHERE owner_id = $uid");

    // now delete the user itself
    DB_delete ($_TABLES['users'], 'uid', $uid);

    return true;
}

/**
* Create a new password and send it to the user
*
* @param    string  $username   user's login name
* @param    string  $useremail  user's email address
* @return   boolean             true = success, false = an error occured
*
*/
function USER_createAndSendPassword ($username, $useremail, $uid)
{
    global $_CONF, $LANG04;

    $passwd = null;
    SEC_updateUserPassword($password, $uid);

    if (file_exists ($_CONF['path_data'] . 'welcome_email.txt')) {
        $template = COM_newTemplate($_CONF['path_data']);
        $template->set_file (array ('mail' => 'welcome_email.txt'));
        $template->set_var ('auth_info',
                            "$LANG04[2]: $username\n$LANG04[4]: $passwd");
        $template->set_var ('site_name', $_CONF['site_name']);
        $template->set_var ('site_slogan', $_CONF['site_slogan']);
        $template->set_var ('lang_text1', $LANG04[15]);
        $template->set_var ('lang_text2', $LANG04[14]);
        $template->set_var ('lang_username', $LANG04[2]);
        $template->set_var ('lang_password', $LANG04[4]);
        $template->set_var ('username', $username);
        $template->set_var ('password', $passwd);
        $template->set_var ('name', COM_getDisplayName ($uid));
        $template->parse ('output', 'mail');
        $mailtext = $template->get_var ('output');
    } else {
        $mailtext = $LANG04[15] . "\n\n";
        $mailtext .= $LANG04[2] . ": $username\n";
        $mailtext .= $LANG04[4] . ": $passwd\n\n";
        $mailtext .= $LANG04[14] . "\n\n";
        $mailtext .= $_CONF['site_name'] . "\n";
        $mailtext .= $_CONF['site_url'] . "\n";
    }
    $subject = $_CONF['site_name'] . ': ' . $LANG04[16];
    if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
        $mailfrom = $_CONF['noreply_mail'];
        $mailtext .= LB . LB . $LANG04[159];
    } else {
        $mailfrom = $_CONF['site_mail'];
    }

    return COM_mail ($useremail, $subject, $mailtext, $mailfrom);
}

/**
* Inform a user their account has been activated.
*
* @param    string  $username   user's login name
* @param    string  $useremail  user's email address
* @return   boolean             true = success, false = an error occured
*
*/
function USER_sendActivationEmail ($username, $useremail)
{
    global $_CONF, $_TABLES, $LANG04;

    if (file_exists ($_CONF['path_data'] . 'activation_email.txt')) {
        $template = COM_newTemplate($_CONF['path_data']);
        $template->set_file (array ('mail' => 'activation_email.txt'));
        $template->set_var ('site_name', $_CONF['site_name']);
        $template->set_var ('site_slogan', $_CONF['site_slogan']);
        $template->set_var ('lang_text1', $LANG04[15]);
        $template->set_var ('lang_text2', $LANG04[14]);
        $template->parse ('output', 'mail');
        $mailtext = $template->get_var ('output');
    } else {
        $mailtext = str_replace("<username>", $username, $LANG04[118]) . "\n\n";
        $mailtext .= $_CONF['site_url'] ."\n\n";
        $mailtext .= $LANG04[119] . "\n\n";
        $mailtext .= $_CONF['site_url'] ."/users.php?mode=getpassword\n\n";
        $mailtext .= $_CONF['site_name'] . "\n";
        $mailtext .= $_CONF['site_url'] . "\n";
    }
    $subject = $_CONF['site_name'] . ': ' . $LANG04[120];
    if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
        $mailfrom = $_CONF['noreply_mail'];
        $mailtext .= LB . LB . $LANG04[159];
    } else {
        $mailfrom = $_CONF['site_mail'];
    }

    return COM_mail ($useremail, $subject, $mailtext, $mailfrom);
}

/**
* Create a new user
*
* Also calls the custom user registration (if enabled) and plugin functions.
*
* NOTE: Does NOT send out password emails.
*
* @param    string  $username    username (mandatory)
* @param    string  $email       user's email address (mandatory)
* @param    string  $passwd      password (optional, see above)
* @param    string  $fullname    user's full name (optional)
* @param    string  $homepage    user's home page (optional)
* @param    boolean $batchimport set to true when called from importuser() in admin/users.php (optional)
* @return   int                  new user's ID
*
*/
function USER_createAccount($username, $email, $passwd = '', $fullname = '', $homepage = '', $remoteusername = '', $service = '', $batchimport = false)
{
    global $_CONF, $_TABLES;

    $queueUser = false;
    $username = addslashes($username);
    $email = addslashes($email);

    $regdate = strftime('%Y-%m-%d %H:%M:%S', time());
    $fields = 'username,email,regdate,cookietimeout';
    $values = "'$username','$email','$regdate','{$_CONF['default_perm_cookie_timeout']}'";

    if (! empty($passwd)) {
        // Since no uid exists yet we can't use SEC_updateUserPassword and must handle things manually
        $salt = SEC_generateSalt();
        $passwd = SEC_encryptPassword($passwd, $salt, $_CONF['pass_alg'], $_CONF['pass_stretch']); 
        $fields .= ',passwd,salt,algorithm,stretch';
        $values .= ",'$passwd','$salt','" . $_CONF['pass_alg'] . "','" . $_CONF['pass_stretch'] . "'";
    }
    if (! empty($fullname)) {
        $fullname = addslashes($fullname);
        $fields .= ',fullname';
        $values .= ",'$fullname'";
    }
    if (! empty($homepage)) {
        $homepage = addslashes($homepage);
        $fields .= ',homepage';
        $values .= ",'$homepage'";
    }
    if (($_CONF['usersubmission'] == 1) && !SEC_hasRights('user.edit')) {
        $queueUser = true;
        if (!empty($_CONF['allow_domains'])) {
            if (USER_emailMatches($email, $_CONF['allow_domains'])) {
                $queueUser = false;
            }
        }
        if ($queueUser) {
            $fields .= ',status';
            $values .= ',' . USER_ACCOUNT_AWAITING_APPROVAL;
        }
    } else {
        if (! empty($remoteusername)) {
            $fields .= ',remoteusername';
            $values .= ",'$remoteusername'";
        }
        if (! empty($service)) {
            $fields .= ',remoteservice';
            $values .= ",'$service'";
        }
    }

    DB_query("INSERT INTO {$_TABLES['users']} ($fields) VALUES ($values)");
    // Get the uid of the user, possibly given a service:
    if ($remoteusername != '') {
        $uid = DB_getItem($_TABLES['users'], 'uid', "remoteusername = '$remoteusername' AND remoteservice='$service'");
    } else {
        $uid = DB_getItem($_TABLES['users'], 'uid', "username = '$username' AND remoteservice IS NULL");
    }

    // Add user to Logged-in group (i.e. members) and the All Users group
    $normal_grp = DB_getItem($_TABLES['groups'], 'grp_id',
                             "grp_name='Logged-in Users'");
    $all_grp = DB_getItem($_TABLES['groups'], 'grp_id',
                          "grp_name='All Users'");
    DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($normal_grp, $uid)");
    DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($all_grp, $uid)");

    // any default groups?
    $result = DB_query("SELECT grp_id FROM {$_TABLES['groups']} WHERE grp_default = 1");
    $num_groups = DB_numRows($result);
    for ($i = 0; $i < $num_groups; $i++) {
        list($def_grp) = DB_fetchArray($result);
        DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($def_grp, $uid)");
    }

    DB_query("INSERT INTO {$_TABLES['userprefs']} (uid) VALUES ($uid)");
    if ($_CONF['emailstoriesperdefault'] == 1) {
        DB_query("INSERT INTO {$_TABLES['userindex']} (uid,etids) VALUES ($uid,'')");
    } else {
        DB_query("INSERT INTO {$_TABLES['userindex']} (uid,etids) VALUES ($uid, '-')");
    }

    DB_query("INSERT INTO {$_TABLES['usercomment']} (uid,commentmode,commentlimit) VALUES ($uid,'{$_CONF['comment_mode']}','{$_CONF['comment_limit']}')");
    DB_query("INSERT INTO {$_TABLES['userinfo']} (uid) VALUES ($uid)");

    // call custom registration function and plugins
    if ($_CONF['custom_registration'] && function_exists('CUSTOM_userCreate')) {
        CUSTOM_userCreate($uid,$batchimport);
    }
    PLG_createUser($uid);

    // Notify the admin?
    if (isset($_CONF['notification']) &&
            in_array('user', $_CONF['notification'])) {
        if ($queueUser) {
            $mode = 'inactive';
        } else {
            $mode = 'active';
        }
        $username = COM_getDisplayName($uid, $username, $fullname,
                                       $remoteusername, $service);
        USER_sendNotification($username, $email, $uid, $mode);
    }

    return $uid;
}

/**
* Send an email notification when a new user registers with the site.
*
* @param username string      Username of the new user
* @param email    string      Email address of the new user
* @param uid      int         User id of the new user
* @param mode     string      Mode user was added at.
* @return         boolean     true = success, false = an error occured
*
*/
function USER_sendNotification ($username, $email, $uid, $mode='inactive')
{
    global $_CONF, $_TABLES, $LANG01, $LANG04, $LANG08, $LANG28, $LANG29;

    $mailbody = "$LANG04[2]: $username\n"
              . "$LANG04[5]: $email\n"
              . "$LANG28[14]: " . strftime ($_CONF['date']) . "\n\n";

    if ($mode == 'inactive') {
        // user needs admin approval
        $mailbody .= "$LANG01[10] <{$_CONF['site_admin_url']}/moderation.php>\n\n";
    } else {
        // user has been created, or has activated themselves:
        $mailbody .= "$LANG29[4] <{$_CONF['site_url']}/users.php?mode=profile&uid={$uid}>\n\n";
    }
    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[40];

    return COM_mail($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
* Get a user's photo, either uploaded or from an external service
*
* NOTE:     All parameters are optional and can be passed as 0 / empty string.
*
* @param    int     $uid    User ID
* @param    string  $photo  name of the user's uploaded image
* @param    string  $email  user's email address (for gravatar.com)
* @param    int     $width  preferred image width
* @return   string          <img> tag or empty string if no image available
*
*/
function USER_getPhoto ($uid = 0, $photo = '', $email = '', $width = 0)
{
    global $_CONF, $_TABLES, $_USER;

    $userphoto = '';

    if ($_CONF['allow_user_photo'] == 1) {

        if (($width == 0) && !empty ($_CONF['force_photo_width'])) {
            $width = $_CONF['force_photo_width'];
        }

        // collect user's information with as few SQL requests as possible
        if ($uid == 0) {
            $uid = $_USER['uid'];
            if (empty ($email)) {
                $email = $_USER['email'];
            }
            if (!empty ($_USER['photo']) &&
                    (empty ($photo) || ($photo == '(none)'))) {
                $photo = $_USER['photo'];
            }
        }
        if ((empty ($photo) || ($photo == '(none)')) ||
                (empty ($email) && $_CONF['use_gravatar'])) {
            $result = DB_query ("SELECT email,photo FROM {$_TABLES['users']} WHERE uid = '$uid'");
            list($newemail, $newphoto) = DB_fetchArray ($result);
            if (empty ($photo) || ($photo == '(none)')) {
                $photo = $newphoto;
            }
            if (empty ($email)) {
                $email = $newemail;
            }
        }

        $img = '';
        if (empty($photo) || ($photo == 'none')) {
            // no photo - try gravatar.com, if allowed
            if ($_CONF['use_gravatar']) {
                $img = 'http://www.gravatar.com/avatar/' . md5($email);
                $parms = array();
                if ($width > 0) {
                    $parms[] = 's=' . $width;
                }
                if (! empty($_CONF['gravatar_rating'])) {
                    $parms[] = 'r=' . $_CONF['gravatar_rating'];
                }
                if (! empty($_CONF['default_photo'])) {
                    $parms[] = 'd=' . urlencode($_CONF['default_photo']);
                }
                if (count($parms) > 0) {
                    $img .= '?' . implode('&amp;', $parms);
                }
            }
        } else {
            // check if images are inside or outside the document root
            if (strstr ($_CONF['path_images'], $_CONF['path_html'])) {
                $imgpath = substr ($_CONF['path_images'],
                                   strlen ($_CONF['path_html']));
                $img = $_CONF['site_url'] . '/' . $imgpath . 'userphotos/'
                     . $photo;
            } else {
                $img = $_CONF['site_url']
                     . '/getimage.php?mode=userphotos&amp;image=' . $photo;
            }
        }

        if (empty ($img) && !empty ($_CONF['default_photo'])) {
            $img = $_CONF['default_photo'];
        }
        if (!empty ($img)) {
            $userphoto = '<img src="' . $img . '"';
            if ($width > 0) {
                $userphoto .= ' width="' . $width . '"';
            }
            $userphoto .= ' alt="" class="userphoto"' . XHTML . '>';
        }
    }

    return $userphoto;
}

/**
* Delete a user's photo (i.e. the actual file)
*
* NOTE:     Will silently ignore non-existing files.
*
* @param    string  $photo          name of the photo (without the path)
* @param    boolean $abortonerror   true: abort script on error, false: don't
* @return   void
*
*/
function USER_deletePhoto ($photo, $abortonerror = true)
{
    global $_CONF, $LANG04;

    if (!empty ($photo)) {
        $filetodelete = $_CONF['path_images'] . 'userphotos/' . $photo;
        if (file_exists ($filetodelete)) {
            if (!@unlink ($filetodelete)) {
                if ($abortonerror) {
                    $display = COM_errorLog ("Unable to remove file $photo");
                    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[21]));
                    echo $display;
                    exit;
                } else {
                    // just log the problem, but don't abort
                    COM_errorLog ("Unable to remove file $photo");
                }
            }
        }
    }
}

/**
* Add user to group if user does not belong to specified group
*
* This is part of the Geeklog user implementation. This function
* looks up whether a user belongs to a specified group and if not
* adds them to the group
*
* @param        int      $groupid     Group we want to see if user belongs to and if not add to group
* @param        int         $uid        ID for user to check if in group and if not add user. If empty current user.
* @return       boolean     true if user is added to group, otherwise false
*
*/
function USER_addGroup ($groupid, $uid = '')
{
    global $_CONF, $_TABLES, $_USER;

     // set $uid if $uid is empty
    if (empty ($uid)) {
        // bail for anonymous users
        if (COM_isAnonUser()) {
            return false;
        } else {
            // If logged in set to current uid
            $uid = $_USER['uid'];
        }
    }

    if (($groupid < 1) || SEC_inGroup ($groupid, $uid)) {
        return false;
    } else {
        DB_query ("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ('$groupid', $uid)");
        return true;
    }
}

/**
* Delete from group if user belongs to specified group
*
* This is part of the Geeklog user implementation. This function
* looks up whether a user belongs to a specified group and if so
* removes them from the group
*
* @param        int      $groupid      Group we want to see if user belongs to and if so delete user from group
* @param        int         $uid          ID for user to delete. If empty current user.
* @return       boolean     true if user is removed from group, otherwise false
*
*/
function  USER_delGroup ($groupid, $uid = '')
{
    global $_CONF, $_TABLES, $_USER;

    // set $uid if $uid is empty
    if (empty ($uid)) {
        // bail for anonymous users
        if (COM_isAnonUser()) {
            return false;
        } else {
            // If logged in set to current uid
            $uid = $_USER['uid'];
        }
    }

    if (($groupid > 0) && SEC_inGroup ($groupid, $uid)) {
        DB_query ("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $groupid AND ug_uid = $uid");
        return true;
    } else {
        return false;
    }
}

/**
* Check email address against a list of domains
*
* Checks if the given email's domain part matches one of the entries in a
* comma-separated list of domain names (regular expressions are allowed).
*
* @param    string  $email          email address to check
* @param    string  $domain_list    list of domain names
* @return   boolean                 true if match found, otherwise false
*
*/
function USER_emailMatches ($email, $domain_list)
{
    $match_found = false;

    if (!empty ($domain_list)) {
        $domains = explode (',', $domain_list);

        // Note: We should already have made sure that $email is a valid address
        $email_domain = substr ($email, strpos ($email, '@') + 1);

        foreach ($domains as $domain) {
            if (preg_match ("#$domain#i", $email_domain)) {
                $match_found = true;
                break;
            }
        }
    }

    return $match_found;
}

/**
* Ensure unique username
*
* Checks that $username does not exist yet and creates a new unique username
* (based off of $username) if necessary.
* Mostly useful for creating accounts for remote users.
*
* @param    string  $username   initial username
* @return   string              unique username
* @todo     Bugs: Race conditions apply ...
*
*/
function USER_uniqueUsername($username)
{
    global $_TABLES;

    if (function_exists('CUSTOM_uniqueUsername')) {
        return CUSTOM_uniqueUsername($username);
    }

    $try = $username;
    do {
        $try = addslashes($try);
        $uid = DB_getItem($_TABLES['users'], 'uid', "username = '$try'");
        if (!empty($uid)) {
            $r = rand(2, 9999);
            if (strlen($username) > 12) {
                $try = sprintf('%s%d', substr($username, 0, 12), $r);
            } else {
                $try = sprintf('%s%d', $username, $r);
            }
        }
    } while (!empty($uid));

    return $try;
}


/**
* Used to return an array of groups that a base group contains
* GL supports hierarchical groups and this will return all the child groups
*
* @param    int     $groupid        Group id to get list of groups for
* @return   array                   Array of child groups
*
*/
function USER_getChildGroups($groupid)
{
    global $_TABLES;

    $to_check = array();
    array_push($to_check, $groupid);
    $groups = array();
    while (count($to_check) > 0) {
        $thisgroup = array_pop($to_check);
        if ($thisgroup > 0) {
            $result = DB_query("SELECT ug_grp_id FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $thisgroup");
            $numGroups = DB_numRows($result);
            for ($i = 0; $i < $numGroups; $i++) {
                $A = DB_fetchArray($result);
                if (!in_array($A['ug_grp_id'], $groups)) {
                    if (!in_array($A['ug_grp_id'], $to_check)) {
                        array_push($to_check, $A['ug_grp_id']);
                    }
                }
            }
            $groups[] = $thisgroup;
        }
    }

    return $groups;
}

/**
* Subscribe user to a topic (for the Daily Digest)
*
* @param    string  $tid    Topic ID
*
*/
function USER_subscribeToTopic($tid)
{
    global $_CONF, $_TABLES, $_USER;

    if ($_CONF['emailstories'] == 0) {
        return;
    }

    if (COM_isAnonUser()) {
        return;
    }

    if (!SEC_hasTopicAccess($tid)) {
        return;
    }

    $user_etids = DB_getItem($_TABLES['userindex'], 'etids',
                             "uid = {$_USER['uid']}");
    if (empty($user_etids)) {
        return; // already subscribed to all topics
    }

    if ($user_etids == '-') {
        $user_etids = $tid; // first topic user subscribed to
    } else {
        $etids = explode(' ', $user_etids);
        if (in_array($tid, $etids)) {
            return; // already subscribed
        }
        $etids[] = $tid;
        $user_etids = implode(' ', $etids);
    }
    $user_etids = addslashes($user_etids);

    DB_query("UPDATE {$_TABLES['userindex']} SET etids = '$user_etids' WHERE uid = {$_USER['uid']}");
}

/**
* Unsubscribe user from a topic (for the Daily Digest)
*
* @param    string  $tid    Topic ID
*
*/
function USER_unsubscribeFromTopic($tid)
{
    global $_CONF, $_TABLES, $_USER;

    if ($_CONF['emailstories'] == 0) {
        return;
    }

    if (COM_isAnonUser()) {
        return;
    }

    // no check for SEC_hasTopicAccess here to unsubscribe user "just in case"

    $user_etids = DB_getItem($_TABLES['userindex'], 'etids',
                             "uid = {$_USER['uid']}");
    if ($user_etids == '-') {
        return; // not subscribed to any topics
    }

    if (empty($user_etids)) {
        // subscribed to all topics - get list
        $etids = USER_getAllowedTopics();
    } else {
        $etids = explode(' ', $user_etids);
    }

    $key = array_search($tid, $etids);
    if ($key === false) {
        return; // not subscribed to this topic
    }

    unset($etids[$key]);

    if (count($etids) == 0) {
        $user_etids = '-';
    } else {
        $user_etids = implode(' ', $etids);
    }
    $user_etids = addslashes($user_etids);

    DB_query("UPDATE {$_TABLES['userindex']} SET etids = '$user_etids' WHERE uid = {$_USER['uid']}");
}

/**
* Check if user is subscribed to a topic
*
* @param    string  $tid    Topic ID
* @return   boolean         true: subscribed, false: not subscribed
*
*/
function USER_isSubscribedToTopic($tid)
{
    global $_CONF, $_TABLES, $_USER;

    if ($_CONF['emailstories'] == 0) {
        return false;
    }

    if (COM_isAnonUser()) {
        return false;
    }

    if (!SEC_hasTopicAccess($tid)) {
        return false;
    }

    $user_etids = DB_getItem($_TABLES['userindex'], 'etids',
                             "uid = {$_USER['uid']}");
    if (empty($user_etids)) {
        return true; // subscribed to all topics
    } elseif ($user_etids == '-') {
        return false; // not subscribed to any topics
    }

    $etids = explode(' ', $user_etids);

    return in_array($tid, $etids);
}

/**
* Get topics the current user has access to
*
* @return   array   Array of topic IDs
*
*/
function USER_getAllowedTopics()
{
    global $_TABLES;

    $topics = array();

    $result = DB_query("SELECT tid FROM {$_TABLES['topics']}");
    $numrows = DB_numRows($result);
    for ($i = 0; $i < $numrows; $i++) {
        $A = DB_fetchArray($result);
        if (SEC_hasTopicAccess($A['tid'])) {
            $topics[] = $A['tid'];
        }
    }

    return $topics;
}

/**
* Shows a profile for a user
*
* This grabs the user profile for a given user and displays it
*
* @param    int     $uid        User ID of profile to get
* @param    boolean $preview    whether being called as preview from My Account
* @param    int     $msg        Message to display (if != 0)
* @param    string  $plugin     optional plugin name for message
* @return   string              HTML for user profile page
*
*/
function USER_showProfile($uid, $preview = false, $msg = 0, $plugin = '')
{
    global $_CONF, $_TABLES, $_USER, $_IMAGE_TYPE,
           $LANG01, $LANG04, $LANG09, $LANG28, $LANG_LOGIN, $LANG_ADMIN;

    $retval = '';

    if (COM_isAnonUser() &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['profileloginrequired'] == 1))) {
        $retval .= SEC_loginRequiredForm();
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG_LOGIN[1]));

        return $retval;
    }

    $result = DB_query("SELECT {$_TABLES['users']}.uid,username,fullname,regdate,homepage,about,location,pgpkey,photo,email,status FROM {$_TABLES['userinfo']},{$_TABLES['users']} WHERE {$_TABLES['userinfo']}.uid = {$_TABLES['users']}.uid AND {$_TABLES['users']}.uid = $uid");
    $nrows = DB_numRows($result);
    if ($nrows == 0) { // no such user
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }
    $A = DB_fetchArray($result);

    if ($A['status'] == USER_ACCOUNT_DISABLED && !SEC_hasRights('user.edit')) {
        COM_displayMessageAndAbort(30, '', 403, 'Forbidden');
    }

    if ($A['status'] != USER_ACCOUNT_ACTIVE && !SEC_hasRights('user.edit')) {
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }
    
    $display_name = COM_getDisplayName($uid, $A['username'], $A['fullname']);
    $display_name = htmlspecialchars($display_name);

    if (! $preview) {
        if ($msg > 0) {
            $retval .= COM_showMessage($msg, $plugin);
        }
    }

    // format date/time to user preference
    $curtime = COM_getUserDateTimeFormat($A['regdate']);
    $A['regdate'] = $curtime[0];

    $user_templates = COM_newTemplate($_CONF['path_layout'] . 'users');
    $user_templates->set_file(array('profile' => 'profile.thtml',
                                    'email'     => 'email.thtml',
                                    'row'     => 'commentrow.thtml',
                                    'strow'   => 'storyrow.thtml'));
    $user_templates->set_var('start_block_userprofile',
            COM_startBlock($LANG04[1] . ' ' . $display_name));
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->set_var('lang_username', $LANG04[2]);

    if ($_CONF['show_fullname'] == 1) {
        if (empty($A['fullname'])) {
            $username = $A['username'];
            $fullname = '';
        } else {
            $username = $A['fullname'];
            $fullname = $A['username'];
        }
    } else {
        $username = $A['username'];
        $fullname = $A['fullname'];
    }
    $username = htmlspecialchars($username);
    $fullname = htmlspecialchars($fullname);

    if ($A['status'] == USER_ACCOUNT_DISABLED) {
        $username = sprintf('<s title="%s">%s</s>', $LANG28[42], $username);
        if (! empty($fullname)) {
            $fullname = sprintf('<s title="%s">%s</s>', $LANG28[42], $fullname);
        }
    }

    $user_templates->set_var('username', $username);
    $user_templates->set_var('user_fullname', $fullname);

    if ($preview) {
        $user_templates->set_var('edit_icon', '');
        $user_templates->set_var('edit_link', '');
        $user_templates->set_var('user_edit', '');
    } elseif (!COM_isAnonUser() && ($_USER['uid'] == $uid)) {
        $edit_icon = '<img src="' . $_CONF['layout_url'] . '/images/edit.'
                   . $_IMAGE_TYPE . '" alt="' . $LANG01[48]
                   . '" title="' . $LANG01[48] . '"' . XHTML . '>';
        $edit_link_url = COM_createLink($edit_icon,
                            $_CONF['site_url'] . '/usersettings.php');
        $user_templates->set_var('edit_icon', $edit_icon);
        $user_templates->set_var('edit_link', $edit_link_url);
        $user_templates->set_var('user_edit', $edit_link_url);
    } elseif (SEC_hasRights('user.edit')) {
        $edit_icon = '<img src="' . $_CONF['layout_url'] . '/images/edit.'
                   . $_IMAGE_TYPE . '" alt="' . $LANG_ADMIN['edit']
                   . '" title="' . $LANG_ADMIN['edit'] . '"' . XHTML . '>';
        $edit_link_url = COM_createLink($edit_icon,
            "{$_CONF['site_admin_url']}/user.php?mode=edit&amp;uid={$A['uid']}");
        $user_templates->set_var('edit_icon', $edit_icon);
        $user_templates->set_var('edit_link', $edit_link_url);
        $user_templates->set_var('user_edit', $edit_link_url);
    }

    if (isset($A['photo']) && empty($A['photo'])) {
        $A['photo'] = '(none)'; // user does not have a photo
    }
    $photo = USER_getPhoto($uid, $A['photo'], $A['email'], -1);
    $user_templates->set_var('user_photo', $photo);

    $user_templates->set_var('lang_membersince', $LANG04[67]);
    $user_templates->set_var('user_regdate', $A['regdate']);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('user_id', $uid);
    $user_templates->set_var('uid', $uid);
    if ($A['email'] != '') {
        $user_templates->set_var('lang_sendemail', $LANG04[81]);
        $user_templates->parse ('email_option', 'email', true);
    } else {
        $user_templates->set_var ('email_option', '');
    }    
    $user_templates->set_var('lang_homepage', $LANG04[6]);
    $user_templates->set_var('user_homepage', COM_killJS($A['homepage']));
    $user_templates->set_var('lang_location', $LANG04[106]);
    $user_templates->set_var('user_location', strip_tags($A['location']));
    $user_templates->set_var('lang_bio', $LANG04[7]);
    $user_templates->set_var('user_bio', nl2br(stripslashes ($A['about'])));
    $user_templates->set_var('lang_pgpkey', $LANG04[8]);
    $user_templates->set_var('user_pgp', nl2br ($A['pgpkey']));
    $user_templates->set_var('start_block_last10stories',
            COM_startBlock($LANG04[82] . ' ' . $display_name));
    $user_templates->set_var('start_block_last10comments',
            COM_startBlock($LANG04[10] . ' ' . $display_name));
    $user_templates->set_var('start_block_postingstats',
            COM_startBlock($LANG04[83] . ' ' . $display_name));
    $user_templates->set_var('lang_title', $LANG09[16]);
    $user_templates->set_var('lang_date', $LANG09[17]);

    // for alternative layouts: use these as headlines instead of block titles
    $user_templates->set_var('headline_last10stories', $LANG04[82]);
    $user_templates->set_var('headline_last10comments', $LANG04[10]);
    $user_templates->set_var('headline_postingstats', $LANG04[83]);

    $tids = TOPIC_getList();
    $topics = "'" . implode("','", $tids) . "'";

    // list of last 10 stories by this user
    if (count($tids) > 0) {
        $sql = "SELECT sid,title,UNIX_TIMESTAMP(date) AS unixdate 
            FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
            WHERE (uid = $uid) AND (draft_flag = 0) AND (date <= NOW()) AND (tid IN ($topics))" . COM_getPermSQL('AND') . " 
            AND ta.type = 'article' AND ta.id = sid AND ta.tdefault = 1 
            ORDER BY unixdate DESC LIMIT 10";
            
        $result = DB_query($sql);
        $nrows = DB_numRows($result);
    } else {
        $nrows = 0;
    }
    if ($nrows > 0) {
        for ($i = 0; $i < $nrows; $i++) {
            $C = DB_fetchArray($result);
            $user_templates->set_var('cssid', ($i % 2) + 1);
            $user_templates->set_var('row_number', ($i + 1) . '.');
            $articleUrl = COM_buildUrl($_CONF['site_url']
                                       . '/article.php?story=' . $C['sid']);
            $user_templates->set_var('article_url', $articleUrl);
            $C['title'] = str_replace('$', '&#36;', $C['title']);
            $user_templates->set_var('story_title',
                COM_createLink(
                    stripslashes($C['title']),
                    $articleUrl,
                    array('class'=>'b'))
            );
            $storytime = COM_getUserDateTimeFormat($C['unixdate']);
            $user_templates->set_var('story_date', $storytime[0]);
            $user_templates->parse('story_row', 'strow', true);
        }
    } else {
        $user_templates->set_var('story_row',
                                 '<tr><td>' . $LANG01[37] . '</td></tr>');
    }

    // list of last 10 comments by this user
    $new_plugin_comments = array();
    $new_plugin_comments = PLG_getWhatsNewComment('', 10, $uid);
    
    if( !empty($new_plugin_comments) ) {
        // Sort array by element lastdate newest to oldest
        foreach($new_plugin_comments as $k=>$v) {		
            $b[$k] = strtolower($v['unixdate']);	
        }	
        arsort($b);	
        foreach($b as $key=>$val) {		
            $temp[] = $new_plugin_comments[$key];	
        }	   
        $new_plugin_comments = $temp;   
           
        $i = 0;
        foreach ($new_plugin_comments as $C) {
            $i = $i + 1;
            $user_templates->set_var('cssid', ($i % 2));
            $user_templates->set_var('row_number', ($i) . '.');
            $C['title'] = str_replace('$', '&#36;', $C['title']);
            $comment_url = $_CONF['site_url']
                         . '/comment.php?mode=view&amp;cid=' . $C['cid'];
            $user_templates->set_var('comment_title',
                COM_createLink(
                    stripslashes($C['title']),
                    $comment_url,
                    array('class'=>'b'))
            );
            $commenttime = COM_getUserDateTimeFormat($C['unixdate']);
            $user_templates->set_var('comment_date', $commenttime[0]);
            $user_templates->parse('comment_row', 'row', true);
            
            if ($i == 10) {
                break;   
            }
        }
    } else {
        $user_templates->set_var('comment_row',
                                 '<tr><td>' . $LANG01[29] . '</td></tr>');
    }

    // posting stats for this user
    $user_templates->set_var('lang_number_stories', $LANG04[84]);
    $sql = "SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE (uid = $uid) AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL('AND');
    $result = DB_query($sql);
    $N = DB_fetchArray($result);
    $user_templates->set_var('number_stories', COM_numberFormat($N['count']));
    $user_templates->set_var('lang_number_comments', $LANG04[85]);
    $sql = "SELECT COUNT(*) AS count FROM {$_TABLES['comments']} WHERE (uid = $uid)";
    $result = DB_query($sql);
    $N = DB_fetchArray($result);
    $user_templates->set_var('number_comments', COM_numberFormat($N['count']));
    $user_templates->set_var('lang_all_postings_by',
                             $LANG04[86] . ' ' . $display_name);

    // Call custom registration function if enabled and exists
    if ($_CONF['custom_registration'] && function_exists('CUSTOM_userDisplay') ) {
        $user_templates->set_var('customfields', CUSTOM_userDisplay($uid));
    }
    PLG_profileVariablesDisplay($uid, $user_templates);

    $user_templates->parse('output', 'profile');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

    $retval .= PLG_profileBlocksDisplay($uid);

    if (! $preview) {
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[1] . ' ' . $display_name));
    }

    return $retval;
}

/**
* Implements the [user:] autotag.
*
* @param    string  $op         operation to perform
* @param    string  $content    item (e.g. story text), including the autotag
* @param    array   $autotag    parameters used in the autotag
* @param    mixed               tag names (for $op='tagname') or formatted content
*
*/
function plugin_autotags_user($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES, $LANG28, $_GROUPS;

    if ($op == 'tagname' ) {
        return 'user';
    } elseif ($op == 'permission' || $op == 'nopermission') {
        if ($op == 'permission') {
            $flag = true;
        } else {
            $flag = false;
        }
        $tagnames = array();

        if (isset($_GROUPS['User Admin'])) {
            $group_id = $_GROUPS['User Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                   "grp_name = 'User Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();   

        if (COM_getPermTag($owner_id, $group_id, $_CONF['autotag_permissions_user'][0], $_CONF['autotag_permissions_user'][1], $_CONF['autotag_permissions_user'][2], $_CONF['autotag_permissions_user'][3]) == $flag) {
            $tagnames[] = 'user';
        }
        
        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'description') {
        return array (
            'user' => $LANG28['autotag_desc_user']
            );          
    } elseif ($op == 'parse') {
        $uname = COM_applyFilter($autotag['parm1']);
        $uname = addslashes($uname);
        $sql = "SELECT uid, username, fullname, status FROM {$_TABLES['users']} WHERE username = '$uname'";
        $result = DB_query($sql);
        if (DB_numRows($result) == 1) {
            $A = DB_fetchArray($result);
            $url = $_CONF['site_url'] . '/users.php?mode=profile&amp;uid='
                 . $A['uid'];
            $linktext = $autotag['parm2'];
            if (empty($linktext)) {
                $linktext = COM_getDisplayName($A['uid'], $A['username'], $A['fullname']);
                if ($A['status'] == USER_ACCOUNT_DISABLED) {
                    $linktext = sprintf('<s title="%s">%s</s>', $LANG28[42],
                                        $linktext);
                }
            }

            $link = COM_createLink($linktext, $url);
            $content = str_replace($autotag['tagstr'], $link, $content);

        }

        return $content;
    }
}

?>
