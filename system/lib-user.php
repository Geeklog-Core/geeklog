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
// $Id: lib-user.php,v 1.2 2004/02/14 17:26:53 dhaun Exp $

if (eregi ('lib-user.php', $PHP_SELF)) {
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
    $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid");
    $A = DB_fetchArray ($result);
    $rootuser = $A['ug_uid'];

    DB_query ("UPDATE {$_TABLES['blocks']} SET owner_id = $rootuser WHERE owner_id = $uid");
    DB_query ("UPDATE {$_TABLES['pollquestions']} SET owner_id = $rootuser WHERE owner_id = $uid");
    DB_query ("UPDATE {$_TABLES['topics']} SET owner_id = $rootuser WHERE owner_id = $uid");

    // now delete the user itself
    DB_delete ($_TABLES['users'], 'uid', $uid);

    return true;
}

?>
