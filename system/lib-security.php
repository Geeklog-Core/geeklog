<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-security.php                                                          |
// | Geeklog security library.                                                 |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
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
// $Id: lib-security.php,v 1.4 2002/04/11 17:54:26 tony_bibbs Exp $

// Turn this on go get various debug messages from the code in this library
$_SEC_VERBOSE = false;

/**
* Returns the groups a user belongs to
*
* This is part of the GL security implementation.  This function returns
* all the groups a user belongs to.  This function is called recursively
* as groups can belong to other groups
*
* @uid          int     User ID to get information for
* @usergroups   string  comma delimited string of groups user belongs to
* @cur_grp_id   int     Current group the function is working with in tree
*
*/
function SEC_getUserGroups($uid='',$usergroups='',$cur_grp_id='')
{
    global $_TABLES, $_USER, $_SEC_VERBOSE;

    if (empty($usergroups)) {
        $usergroups = array();
    }
    
    if ($_SEC_VERBOSE) {
        COM_errorLog("****************in getusergroups(uid=$uid,usergroups=$usergroups,cur_grp_id=$cur_grp_id)***************",1);
    }

    if (empty($uid)) {
        if (empty($_USER['uid'])) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }

    if (empty($cur_grp_id)) {
        $result = DB_query("SELECT ug_main_grp_id,grp_name FROM {$_TABLES["group_assignments"]},{$_TABLES["groups"]}"
            . " WHERE grp_id = ug_main_grp_id AND ug_uid = $uid",1);
    } else {
        $result = DB_query("SELECT ug_main_grp_id,grp_name FROM {$_TABLES["group_assignments"]},{$_TABLES["groups"]}"
            . " WHERE grp_id = ug_main_grp_id AND ug_grp_id = $cur_grp_id",1);
    }

    if ($result == -1) {
        return $usergroups;
    }

    $nrows = DB_numRows($result);

    if ($_SEC_VERBOSE) {
        COM_errorLog("got $nrows rows",1);
    }

    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);

	if ($_SEC_VERBOSE) {
            COM_errorLog('user is in group ' . $A['grp_name'],1);
        }
        $usergroups[$A['grp_name']] = $A['ug_main_grp_id'];
        $usergroups = SEC_getUserGroups($uid,$usergroups,$A['ug_main_grp_id']);
    }

    if (is_array($usergroups)) {
        ksort($usergroups);
    }

    if ($_SEC_VERBOSE) {
        COM_errorLog("****************leaving getusergroups(uid=$uid)***************",1);
    }

    return $usergroups;
}

/**
* Determines if user belongs to specified group
*
* This is part of the Geeklog security implementation. This function
* looks up whether a user belongs to a specified group
*
* @grp_to_verify        string          Group we want to see if user belongs to
* @uid                  string          ID for user to check
* @cur_grp_id           string          Current group we are working with in hierarchy
*
*/
function SEC_inGroup($grp_to_verify,$uid='',$cur_grp_id='')
{
    global $_TABLES, $_USER, $_SEC_VERBOSE, $_GROUPS;

    if (empty($uid)) {
        if (empty($_USER['uid'])) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }

    if (empty($_GROUPS)) {
        $_GROUPS = SEC_getUserGroups($_USER['uid']);
    }

    if (is_numeric($grp_to_verify)) {
        if (in_array($grp_to_verify, $_GROUPS)) {
           return true;
        } else {
           return false;
        }
    } else {
        if (!empty($_GROUPS[$grp_to_verify])) {
            return true;
        } else {
            return false;
        }
   }
}

/**
* Determines if current user is a moderator of any kind
*
* Checks to see if this user is a moderator for any of the GL features OR
* GL plugins
*
*/
function SEC_isModerator()
{
    global $_USER,$_RIGHTS;

    // Loop through GL core rights.
    for ($i = 0; $i < count($_RIGHTS); $i++) {
        if (stristr($_RIGHTS[$i],'.moderate')) {
            return true;
        }
    }

    // If we get this far they are not a Geeklog moderator
    // So, let's return if they're a plugin moderator

    return PLG_isModerator();
}

/**
* Checks to see if user has access to view a topic
*
* Checks to see if user has access to view a topic
*
* @tid      string      ID for topic to check on
*
*/
function SEC_hasTopicAccess($tid)
{
    global $_TABLES;

    if (empty($tid)) {
        return 0;
    }

    $result = DB_query("SELECT * FROM {$_TABLES["topics"]} WHERE tid = '$tid'");
    $A = DB_fetchArray($result);

    return SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
}

/**
* Checks if user has access to the given object
*
* This function SEC_takes the access info from a Geeklog object
* and let's us know if the have access to the object
* returns 3 for read/edit, 2 for read only and 0 for no
* access
*
* @owner_id     int     ID of the owner of object
* @group_id     int     ID of group object belongs to
* @perm_owner   int     Permissions the owner has
* @perm_group   int     Permissions the gorup has
* @perm_members int     Permissions logged in members have
* @perm_anon    int     Permissions anonymous users have
*
*/
function SEC_hasAccess($owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon)
{
    global $_USER;

    // Cache current user id
    if (empty($_USER['uid'])) {
        $uid = 1;
    } else {
        $uid = $_USER['uid'];
    }

    // If user is in Root group then return full access
    if (SEC_inGroup('Root')) {
        return 3;
    }

    // If user is owner then return 1 now
    if ($uid == $owner_id) return $perm_owner;

    // Not private, if user is in group then give access
    if (SEC_inGroup($group_id)) {
        return $perm_group;
    } else {
        if ($uid == 1) {
            // This is an anonymous user, return it's rights
            return $perm_anon;
        } else {
            // This is a logged in memeber, return their rights
            return $perm_members;
        }
    }
}

/**
* Checks if user has rights to a feature
*
* Takes either a single feature or an array of features and returns
* an array of wheather the user has those rights
*
* @features     string|array      Features to check
* @operator     string            If checking more than one feature this operator is used
*
*/
function SEC_hasRights($features,$operator='AND')
{
    global $_USER, $_RIGHTS, $_SEC_VERBOSE;

    if (strstr($features,',')) {
        $features = explode(',',$features);
    }

    if (is_array($features)) {
        // check all values passed
        for ($i = 0; $i < count($features); $i++) {
            if ($operator == 'OR') {
                // OR operator, return as soon as we find a true one
                if (in_array($features[$i],$_RIGHTS)) {
                    if ($_SEC_VERBOSE) {
                        COM_errorLog('SECURITY: user has access to ' . $features[$i],1);
                    }
                    return true;
                }
            } else {
                // this is an "AND" operator, bail if we find a false one
                if (!in_array($features[$i],$_RIGHTS)) {
                    if ($_SEC_VERBOSE) {
                        COM_errorLog('SECURITY: user does not have access to ' . $features[$i],1);
                    }
                    return false;
                }
            }
        }

        if ($operator == 'OR') {
            if ($_SEC_VERBOSE) {
                COM_errorLog('SECURITY: user does not have access to ' . $features[$i],1);
            }
            return false;
                } else {
            if ($_SEC_VERBOSE) {
                COM_errorLog('SECURITY: user has access to ' . $features[$i],1);
            }
            return true;
        }
    } else {
        // Check the one value
        if ($_SEC_VERBOSE) {
            if (in_array($features,$_RIGHTS)) {
                COM_errorLog('SECURITY: user has access to ' . $features,1);
            } else {
                COM_errorLog('SECURITY: user does not have access to ' . $features,1);
            }
        }
        return in_array($features,$_RIGHTS);
    }
}

/**
* Shows security control for an object
*
* This will return the HTML needed to create the security control see on the admin
* screen for GL objects (i.e. stories, links, etc)
*
* @perm_owner       int         Permissions the owner has
* @perm_group       int         Permission the group has
* @perm_members     int         Permissions logged in members have
* @perm_anon        int         Permissions anonymous users have
*
*/
function SEC_getPermissionsHTML($perm_owner,$perm_group,$perm_members,$perm_anon)
{
    global $LANG_ACCESS;

    $retval .= '<table cellpadding="0" cellspacing="0" border="0">' . LB . '<tr>' . LB
        . '<td colspan="3"><b>' . $LANG_ACCESS['owner'] . '</b></td>'  .LB
        . '<td colspan="3"><b>' . $LANG_ACCESS['group'] . '</b></td>' . LB
        . '<td><b>' . $LANG_ACCESS['members'] . '</b></td>' . LB
        . '<td><b>' . $LANG_ACCESS['anonymous'] . '</b></td>' . LB
        . '</tr>' . LB . '<tr>' . LB;

    // Owner Permissions
    $retval .= '<td align="center"><b>R</b><br><input type="checkbox" name="perm_owner[]" value="2"';
    if ($perm_owner >= 2) {
        $retval .= ' checked="checked"';
    }
    $retval .= '></td>' . LB
        .'<td align="center"><b>E</b><br><input type="checkbox" name="perm_owner[]" value="1"';
    if ($perm_owner == 3) {
        $retval .= ' checked="checked"';
    }
    $retval .= '></td>' . LB .'<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>' . LB;

    // Group Permissions

    $retval .= '<td align="center"><b>R</b><br><input type="checkbox" name="perm_group[]" value="2"';
    if ($perm_group >= 2) {
        $retval .= ' checked="checked"';
    }
    $retval .= '></td>'.LB
        .'<td align="center"><b>E</b><br><input type="checkbox" name="perm_group[]" value="1"';
    if ($perm_group == 3) {
        $retval .= ' checked="checked"';
    }
    $retval .= '></td>' . LB . '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>' . LB;

    // Member Permissions
    $retval .= '<td align="center"><b>R</b><br><input type="checkbox" name="perm_members[]" value="2"';
    if ($perm_members == 2) {
        $retval .= ' checked="checked"';
    }
    $retval .= '></td>' . LB;

    // Anonymous Permissions

    $retval .= '<td align="center"><b>R</b><br><input type="checkbox" name="perm_anon[]" value="2"';
    if ($perm_anon == 2) {
        $retval .= ' checked="checked"';
    }
    $retval .= '></td>' . LB;

    // Finish off and return

    $retval .= '</tr>' . LB . '</table>';

    return $retval;
}

/**
* Gets everything a user has permissions to within the system
*
* This is part of the Geeklog security implmentation.  This function
* will get all the permissions the current user has
*
* @grp_id       int     Current group function is working on
*
*/
function SEC_getUserPermissions($grp_id='',$uid='')
{
    global $_TABLES, $_USER, $_SEC_VERBOSE;

    // Get user ID if we don't already have it
    if (empty($uid)) {
        if (empty($_USER['uid'])) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }

    if ($_SEC_VERBOSE) {
        COM_errorLog("**********inside SEC_getUserPermissions(grp_id=$grp_id)**********",1);
    }

    if (empty($grp_id)) {
        // Okay, this was the first time this function SEC_was called.
        // Let's get all the groups this user belongs to and get the permissions for each group.
        // NOTE: permissions are given to groups and NOT individuals

	// print "<BR>uid = " . $_USER[uid];

        $result = DB_query("SELECT ug_main_grp_id FROM {$_TABLES["group_assignments"]} WHERE ug_uid = $uid",1);
        if ($result <> -1) {
            $nrows = DB_numRows($result);
            if ($_SEC_VERBOSE) {
                COM_errorLog("got $nrows row(s) in SEC_getUserPermissions",1);
            }
            for ($i = 1; $i <= $nrows; $i++) {
                $A = DB_fetchArray($result);
                $retval .= SEC_getUserPermissions($A['ug_main_grp_id'],$uid);
            }
        }
    } else {
        // In this case we are going up the group tree for this user building a list of rights
        // along the way.  First, get the rights for this group.

        $result = DB_query("SELECT ft_name FROM {$_TABLES["access"]},{$_TABLES["features"]} WHERE "
            . "ft_id = acc_ft_id AND acc_grp_id = $grp_id",1);
        $nrows = DB_numRows($result);

        if ($_SEC_VERBOSE) COM_errorLog("got $nrows rights for group $grp_id in SEC_getUserPermissions",1);

        for ($j = 1; $j <= $nrows; $j++) {
            $A = DB_fetchArray($result);
            if ($_SEC_VERBOSE) {
                COM_errorLog('Adding right ' . $A['ft_name'] . ' in SEC_getUserPermissions',1);
            }
            $retval .= $A['ft_name'] . ',';
        }

        // Now see if there are any groups tied to this one further up the tree.  If so
        // see if they have additional rights

        $result = DB_query("SELECT ug_main_grp_id FROM {$_TABLES["group_assignments"]} WHERE ug_grp_id = $grp_id",1);
        $nrows = DB_numRows($result);
        if ($_SEC_VERBOSE) {
            COM_errorLog("got $nrows groups tied to group $grp_id in SEC_getUserPermissions",1);
        }
        for ($i = 1; $i <= $nrows; $i++) {
            // Now for each group, see if there are any rights assigned to it. If so, add to our
            // comma delimited string

            $A = DB_fetchArray($result);
            $retval .= SEC_getUserPermissions($A['ug_main_grp_id'],$uid);
        }
    }
    if ($_SEC_VERBOSE) {
        COM_errorLog("**********leaving SEC_getUserPermissions(grp_id=$grp_id)**********",1);
    }
    return $retval;
}

/**
* Converts permissions to numeric values
*
* This function will take all permissions for an object and get the numeric value
* that can then be used to save the database.
*
* @perm_owner        array        Array of owner permissions
* @perm_group        array        Array of group permissions
* @perm_members      array        Array of member permissions
* @perm_anon         array        Array of anonymous user permissions
*
*/
function SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon) 
{
    global $_SEC_VERBOSE;

    if ($_SEC_VERBOSE) {
        COM_errorLog('**** Inside SEC_getPermissionValues ****', 1);
    }

    if (is_array($perm_owner)) {
        $perm_owner = SEC_getPermissionValue($perm_owner);
    } else {
        $perm_owner = 0;
    }

    if (is_array($perm_group)) {
        $perm_group = SEC_getPermissionValue($perm_group);
    } else {
        $perm_group = 0;
    }

    if (is_array($perm_members)) {
        $perm_members = SEC_getPermissionValue($perm_members);
    } else {
        $perm_members = 0;
    }

    if (is_array($perm_anon)) {
        $perm_anon = SEC_getPermissionValue($perm_anon);
    } else {
        $perm_anon = 0;
    }

    if ($_SEC_VERBOSE) {
        COM_errorlog('perm_owner = ' . $perm_owner, 1);
        COM_errorlog('perm_group = ' . $perm_group, 1);
        COM_errorlog('perm_member = ' . $perm_member, 1);
        COM_errorlog('perm_anon = ' . $perm_anon, 1);
        COM_errorLog('**** Leaving SEC_getPermissionValues ****', 1);
    }

    return array($perm_owner,$perm_group,$perm_members,$perm_anon);
}

/**
* Converts permission array into numeric value
*
* This function converts an array of permissions for either
* the owner/group/members/anon and returns the numeric 
* equivalent.  This is typically called by the admin screens
* to prepare the permissions to be save to the database
*
* @perm_x        array    Array of permission values
*
*/
function SEC_getPermissionValue($perm_x) 
{
    global $_SEC_VERBOSE;

    if ($_SEC_VERBOSE) {
        COM_errorLog('**** Inside SEC_getPermissionValue ***', 1);
    }

    $retval = 0;

    for ($i = 1; $i <= sizeof($perm_x); $i++) {
        if ($_SEC_VERBOSE) {
            COM_errorLog("perm_x[$i] = " . current($perm_x), 1);
        }
        $retval = $retval + current($perm_x);
        next($perm_x);
    }

    // if they have edit rights, assume read rights
    if ($retval == 1) {
        $retval = 3;
    }

    if ($_SEC_VERBOSE) {
        COM_errorLog("Got $retval permission value", 1);
        COM_errorLog('**** Leaving SEC_getPermissionValue ***', 1);
    }

    return $retval;
}

?>
