<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-user.php                                                              |
// |                                                                           |
// | User-related functions needed in more than one place.                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: lib-user.php,v 1.7 2004/10/05 19:52:45 dhaun Exp $

if (eregi ('lib-user.php', $HTTP_SERVER_VARS['PHP_SELF'])) {
    die ('This file can not be used on its own.');
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
    if ($_CONF['custom_registration'] && function_exists (custom_userdelete)) {
        custom_userdelete ($uid);
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

    // same for links and events
    DB_query ("UPDATE {$_TABLES['links']} SET owner_id = 1 WHERE owner_id = $uid");
    DB_query ("UPDATE {$_TABLES['events']} SET owner_id = 1 WHERE owner_id = $uid");

    // delete personal events
    DB_delete ($_TABLES['personal_events'], 'owner_id', $uid);

    // delete story submissions
    DB_delete ($_TABLES['storysubmission'], 'uid', $uid);

    // delete user photo, if enabled & exists
    if ($_CONF['allow_user_photo'] == 1) {
        $photo = DB_getItem ($_TABLES['users'], 'photo', "uid = $uid");
        if (!empty ($photo)) {
            $filetodelete = $_CONF['path_images'] . 'userphotos/' . $photo;
            if (!@unlink ($filetodelete)) {
                // just log the problem, but don't abort
                COM_errorLog ("Unable to remove file $filetodelete.", 1);
            }
        }
    }

    // in case the user owned any objects that require Admin access, assign
    // them to the Root user with the lowest uid
    $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
    $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
    $A = DB_fetchArray ($result);
    $rootuser = $A['ug_uid'];

    DB_query ("UPDATE {$_TABLES['blocks']} SET owner_id = $rootuser WHERE owner_id = $uid");
    DB_query ("UPDATE {$_TABLES['pollquestions']} SET owner_id = $rootuser WHERE owner_id = $uid");
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
* @return   bool                true = success, false = an error occured
*
*/
function USER_createAndSendPassword ($username, $useremail)
{
    global $_CONF, $_TABLES, $LANG04;

    srand ((double) microtime () * 1000000);
    $passwd = rand ();
    $passwd = md5 ($passwd);
    $passwd = substr ($passwd, 1, 8);
    $passwd2 = md5 ($passwd);
    DB_change ($_TABLES['users'], 'passwd', "$passwd2", 'username', $username);

    if (file_exists ($_CONF['path_data'] . 'welcome_email.txt')) {
        $template = new Template ($_CONF['path_data']);
        $template->set_file (array ('mail' => 'welcome_email.txt'));
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

    return COM_mail ($useremail, $subject, $mailtext);
}

/**
* Create a new user
*
* This also handles adding the user to the user submission queue, if enabled.
* Also calls the custom user registration (if enabled) and plugin functions.
*
* NOTE: Does NOT send out password emails.
*
* @param    string  $username   user name (mandatory)
* @param    string  $email      user's email address (mandatory)
* @param    string  $passwd     password (optional, see above)
* @param    string  $fullname   user's full name (optional)
* @param    string  $homepage   user's home page (optional)
* @return   int                 new user's ID
*
*/
function USER_createAccount ($username, $email, $passwd = '', $fullname = '', $homepage = '')
{
    global $_CONF, $_TABLES;

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

    DB_query ("INSERT INTO {$_TABLES['users']} ($fields) VALUES ($values)");

    $uid = DB_getItem ($_TABLES['users'], 'uid', "username = '$username'");

    // Add user to Logged-in group (i.e. members) and the All Users group
    $normal_grp = DB_getItem ($_TABLES['groups'], 'grp_id',
                              "grp_name='Logged-in Users'");
    $all_grp = DB_getItem ($_TABLES['groups'], 'grp_id',
                           "grp_name='All Users'");
    DB_query ("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) VALUES ($normal_grp, $uid)");
    DB_query ("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) VALUES ($all_grp, $uid)");

    DB_query ("INSERT INTO {$_TABLES['userprefs']} (uid) VALUES ($uid)");
    if ($_CONF['emailstoriesperdefault'] == 1) {
        DB_query ("INSERT INTO {$_TABLES['userindex']} (uid) VALUES ($uid)");
    } else {
        DB_query ("INSERT INTO {$_TABLES['userindex']} (uid,etids) VALUES ($uid, '-')");
    }

    DB_query ("INSERT INTO {$_TABLES['usercomment']} (uid,commentmode,commentlimit) VALUES ($uid,'{$_CONF['comment_mode']}','{$_CONF['comment_limit']}')");
    DB_query ("INSERT INTO {$_TABLES['userinfo']} (uid) VALUES ($uid)");

    // if user submission queue is active and the current user is not a
    // User Admin, then we may have to add the new user to the submission queue
    if (($_CONF['usersubmission'] == 1) && !SEC_hasRights ('user.edit')) {
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
            $passwd = addslashes (md5 (''));
            DB_change ($_TABLES['users'], 'passwd', "$passwd", 'uid', $uid);
        }
    }

    // call custom registration function and plugins
    if ($_CONF['custom_registration'] && (function_exists ('custom_usercreate'))) {
        custom_usercreate ($uid);
    }
    PLG_createUser ($uid);

    return $uid;
}

/**
* Check if a user is in the user submission queue
*
* @param    int     $uid    User ID to check
* @return   boolean         true = user in queue, false = not in queue
*
*/
function USER_isQueued ($uid)
{
    global $_TABLES;

    $queued = false;

    $passwd = md5 ('');
    if (DB_getItem ($_TABLES['users'], 'passwd', "uid = $uid") == $passwd) {
        $queued = true;
    }

    return $queued;
}

?>
