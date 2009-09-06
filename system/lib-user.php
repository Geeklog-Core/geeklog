<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | lib-user.php                                                              |
// |                                                                           |
// | User-related functions needed in more than one place.                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
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
    global $_CONF, $_TABLES, $LANG04;

    $passwd = rand ();
    $passwd = md5 ($passwd);
    $passwd = substr ($passwd, 1, 8);
    $passwd2 = SEC_encryptPassword($passwd);
    DB_change ($_TABLES['users'], 'passwd', "$passwd2", 'uid', $uid);

    if (file_exists ($_CONF['path_data'] . 'welcome_email.txt')) {
        $template = new Template ($_CONF['path_data']);
        $template->set_file (array ('mail' => 'welcome_email.txt'));
        $template->set_var ( 'xhtml', XHTML );
        $template->set_var ('auth_info',
                            "$LANG04[2]: $username\n$LANG04[4]: $passwd");
        $template->set_var ('site_url', $_CONF['site_url']);
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
        $template = new Template ($_CONF['path_data']);
        $template->set_file (array ('mail' => 'activation_email.txt'));
        $template->set_var ( 'xhtml', XHTML );
        $template->set_var ('site_url', $_CONF['site_url']);
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
* @param    string  $username    user name (mandatory)
* @param    string  $email       user's email address (mandatory)
* @param    string  $passwd      password (optional, see above)
* @param    string  $fullname    user's full name (optional)
* @param    string  $homepage    user's home page (optional)
* @param    boolean $batchimport set to true when called from importuser() in admin/users.php (optional)
* @return   int                  new user's ID
*
*/
function USER_createAccount ($username, $email, $passwd = '', $fullname = '', $homepage = '', $remoteusername = '', $service = '',$batchimport=false)
{
    global $_CONF, $_TABLES;

    $queueUser = false;
    $username = addslashes ($username);
    $email = addslashes ($email);

    $regdate = strftime ('%Y-%m-%d %H:%M:%S', time ());
    $fields = 'username,email,regdate,cookietimeout';
    $values = "'$username','$email','$regdate','{$_CONF['default_perm_cookie_timeout']}'";

    if (!empty ($passwd)) {
        $passwd = addslashes ($passwd);
        $fields .= ',passwd';
        $values .= ",'$passwd'";
    }
    if (!empty ($fullname)) {
        $fullname = addslashes ($fullname);
        $fields .= ',fullname';
        $values .= ",'$fullname'";
    }
    if (!empty ($homepage)) {
        $homepage = addslashes ($homepage);
        $fields .= ',homepage';
        $values .= ",'$homepage'";
    }
    if (($_CONF['usersubmission'] == 1) && !SEC_hasRights ('user.edit')) {
        $queueUser = true;
        if (!empty ($_CONF['allow_domains'])) {
            if (USER_emailMatches ($email, $_CONF['allow_domains'])) {
                $queueUser = false;
            }
        }
        if ($queueUser) {
            $fields .= ',status';
            $values .= ',' . USER_ACCOUNT_AWAITING_APPROVAL;
        }
    } else {
        if (!empty($remoteusername)) {
            $fields .= ',remoteusername';
            $values .= ",'$remoteusername'";
        }
        if (!empty($service)) {
            $fields .= ',remoteservice';
            $values .= ",'$service'";
        }
    }

    DB_query ("INSERT INTO {$_TABLES['users']} ($fields) VALUES ($values)");
    // Get the uid of the user, possibly given a service:
    if ($remoteusername != '')
    {
        $uid = DB_getItem ($_TABLES['users'], 'uid', "remoteusername = '$remoteusername' AND remoteservice='$service'");
    } else {
        $uid = DB_getItem ($_TABLES['users'], 'uid', "username = '$username' AND remoteservice IS NULL");
    }

    // Add user to Logged-in group (i.e. members) and the All Users group
    $normal_grp = DB_getItem ($_TABLES['groups'], 'grp_id',
                              "grp_name='Logged-in Users'");
    $all_grp = DB_getItem ($_TABLES['groups'], 'grp_id',
                           "grp_name='All Users'");
    DB_query ("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) VALUES ($normal_grp, $uid)");
    DB_query ("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) VALUES ($all_grp, $uid)");

    DB_query ("INSERT INTO {$_TABLES['userprefs']} (uid) VALUES ($uid)");
    if ($_CONF['emailstoriesperdefault'] == 1) {
        DB_query ("INSERT INTO {$_TABLES['userindex']} (uid,etids) VALUES ($uid,'')");
    } else {
        DB_query ("INSERT INTO {$_TABLES['userindex']} (uid,etids) VALUES ($uid, '-')");
    }

    DB_query ("INSERT INTO {$_TABLES['usercomment']} (uid,commentmode,commentlimit) VALUES ($uid,'{$_CONF['comment_mode']}','{$_CONF['comment_limit']}')");
    DB_query ("INSERT INTO {$_TABLES['userinfo']} (uid) VALUES ($uid)");

    // call custom registration function and plugins
    if ($_CONF['custom_registration'] && (function_exists ('CUSTOM_userCreate'))) {
        CUSTOM_userCreate ($uid,$batchimport);
    }
    PLG_createUser ($uid);

    // Notify the admin?
    if (isset ($_CONF['notification']) &&
        in_array ('user', $_CONF['notification'])) {
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
* @param username string      User name of the new user
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
        if (empty ($photo) || ($photo == 'none')) {
            // no photo - try gravatar.com, if allowed
            if ($_CONF['use_gravatar']) {
                $img = 'http://www.gravatar.com/avatar.php?gravatar_id='
                     . md5 ($email);
                if ($width > 0) {
                    $img .= '&amp;size=' . $width;
                }
                if (!empty ($_CONF['gravatar_rating'])) {
                    $img .= '&amp;rating=' . $_CONF['gravatar_rating'];
                }
                if (!empty ($_CONF['default_photo'])) {
                    $img .= '&amp;default='
                         . urlencode ($_CONF['default_photo']);
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
                    $display = COM_siteHeader ('menu', $LANG04[21])
                             . COM_errorLog ("Unable to remove file $photo")
                             . COM_siteFooter ();
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
        if (empty ($_USER['uid']) || ($_USER['uid'] == 1)) {
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
        if (empty ($_USER['uid']) || ($_USER['uid'] == 1)) {
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

?>
