<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-security.php                                                          |
// | Geeklog security library.                                                 |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@users.sourceforge.net                |
// |          Vincent Furia    - vmf@abtech.org                                |
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
// $Id: lib-security.php,v 1.14 2003/05/06 15:53:21 dhaun Exp $

/**
* This is the security library for Geeklog.  This is used to implement Geeklog's
* *nix-style security system.  
*
* Programming notes:  For items you need security on you need the following for
* each record in your database:
* owner_id        | mediumint(8)          
* group_id        | mediumint(8)          
* perm_owner      | tinyint(1) unsigned   
* perm_group      | tinyint(1) unsigned   
* perm_members    | tinyint(1) unsigned  
* perm_anon       | tinyint(1) unsigned  
*
* For display one function can handle most needs:
* function SEC_hasAccess($owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon)
* A call to this function will allow you to determine if the current user should see the item.
*
* For the admin screen several functions will make life easier:
* function SEC_getPermissionsHTML($perm_owner,$perm_group,$perm_members,$perm_anon)
* This function displays the permissions widget with arrays for each permission
* function SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon)
* This function takes the permissions from the previous function and converts them into 
* an integer for saving back to the database.
*
*/

// Turn this on go get various debug messages from the code in this library
$_SEC_VERBOSE = false;

/**
* Returns the groups a user belongs to
*
* This is part of the GL security implementation.  This function returns
* all the groups a user belongs to.  This function is called recursively
* as groups can belong to other groups
*
* Note: this is an expensive function -- if you are concerned about speed it should only 
*       be used once at the beginning of a page.  The resulting array $_GROUPS can then be
*       used through out the page.
*
* @return array Array of group ID's user belongs to
*
* @param        int     $uid            User ID to get information for. If empty current user.
* @return	array	Associative Array grp_name -> ug_main_grp_id
*
*/
function SEC_getUserGroups($uid='')
{
    global $_TABLES, $_USER, $_SEC_VERBOSE;

    if ($_SEC_VERBOSE) {
        COM_errorLog("****************in getusergroups(uid=$uid,usergroups=$usergroups,cur_grp_id=$cur_grp_id)***************",1);
    }
    
    $groups = array();

    if (empty($uid)) {
        if (empty($_USER['uid'])) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }

    $result = DB_query("SELECT ug_main_grp_id,grp_name FROM {$_TABLES["group_assignments"]},{$_TABLES["groups"]}"
            . " WHERE grp_id = ug_main_grp_id AND ug_uid = $uid",1);

    if ($result == -1) {
        return $groups;
    }

    $nrows = DB_numRows($result);

    if ($_SEC_VERBOSE) {
        COM_errorLog("got $nrows rows",1);
    }

    while ($nrows > 0) {
        $cgroups = array();

        for ($i = 1; $i <= $nrows; $i++) {
            $A = DB_fetchArray($result);
    
            if ($_SEC_VERBOSE) {
                COM_errorLog('user is in group ' . $A['grp_name'],1);
            }
            if (!in_array($A['ug_main_grp_id'], $groups)) {
                array_push($cgroups, $A['ug_main_grp_id']);
                $groups[$A['grp_name']] = $A['ug_main_grp_id'];
            }
        }

        if (sizeof ($cgroups) > 0) {
            $glist = join(',', $cgroups);
            $result = DB_query("SELECT ug_main_grp_id,grp_name FROM {$_TABLES["group_assignments"]},{$_TABLES["groups"]}"
                    . " WHERE grp_id = ug_main_grp_id AND ug_grp_id IN ($glist)",1);
            $nrows = DB_numRows($result);
        } else {
            $nrows = 0;
        }
    }

    ksort($groups);

    if ($_SEC_VERBOSE) {
        COM_errorLog("****************leaving getusergroups(uid=$uid)***************",1);
    }

    return $groups;
}

/**
* Determines if user belongs to specified group
*
* This is part of the Geeklog security implementation. This function
* looks up whether a user belongs to a specified group
*
* @param        string      $grp_to_verify      Group we want to see if user belongs to
* @param        int         $uid                ID for user to check. If empty current user.
* @param        string      $cur_grp_id         NOT USED Current group we are working with in hierarchy
* @return       boolean     true if user is in group, otherwise false
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

        if (empty($_GROUPS)) {
            $_GROUPS = SEC_getUserGroups($_USER['uid']);
        }
        $groups = $_GROUPS;
    } else {
        $groups = SEC_getUserGroups ($uid);
    }

    if (is_numeric($grp_to_verify)) {
        if (in_array($grp_to_verify, $groups)) {
           return true;
        } else {
           return false;
        }
    } else {
        if (!empty($groups[$grp_to_verify])) {
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
* @return   boolean     returns if user has any .moderate rights
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
* Checks to see if current user has access to view a topic
*
* Checks to see if current user has access to view a topic
*
* @param        string      $tid        ID for topic to check on
* @return       int 	returns 3 for read/edit 2 for read only 0 for no access
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
* Checks if current user has access to the given object
*
* This function SEC_takes the access info from a Geeklog object
* and let's us know if the have access to the object
* returns 3 for read/edit, 2 for read only and 0 for no
* access
*
* @param        int     $owner_id       ID of the owner of object
* @param        int     $group_id       ID of group object belongs to
* @param        int     $perm_owner     Permissions the owner has
* @param        int     $perm_group     Permissions the gorup has
* @param        int     $perm_members   Permissions logged in members have
* @param        int     $perm_anon      Permissions anonymous users have
* @return       int 	returns 3 for read/edit 2 for read only 0 for no access
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
* Checks if current user has rights to a feature
*
* Takes either a single feature or an array of features and returns
* an array of whether the user has those rights
*
* @param        string|array        $features       Features to check
* @param        string              $operator       Either 'and' or 'or'. Default is 'and'.  Used if checking more than one feature.
* @return       boolean     Return true if current user has access to feature(s), otherwise false.
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
* @param        int     $perm_owner     Permissions the owner has 1 = edit 2 = read 3 = read/edit
* @param        int     $perm_group     Permission the group has
* @param        int     $perm_members   Permissions logged in members have
* @param        int     $perm_anon      Permissions anonymous users have
* @return       string  needed HTML (table) in HTML $perm_owner = array of permissions [edit,read], etc edit = 1 if permission, read = 2 if permission
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
* will get all the permissions the current user has call itself recursively.
*
* @param        int     $grp_id     DO NOT USE (Used for reccursion) Current group function is working on
* @uid		int	$uid        User to check, if empty current user.
* @return       string   returns comma delimited list of features the user has access to
*
*/
function SEC_getUserPermissions($grp_id='',$uid='')
{
    global $_TABLES, $_USER, $_SEC_VERBOSE;

    if ($_SEC_VERBOSE) {
        COM_errorLog("**********inside SEC_getUserPermissions(grp_id=$grp_id)**********",1);
    }

    // Get user ID if we don't already have it
    if (empty($uid)) {
        if (empty($_USER['uid'])) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }

    if ($uid == $_USER['uid']) {
        if (!isset($_GROUPS)) {
            $_GROUPS = SEC_getUserGroups($uid);
        }
        $groups = $_GROUPS;
    } else {
        $groups = SEC_getUserGroups($uid);
    }

    $glist = join(',', $groups);
    $result = DB_query("SELECT DISTINCT ft_name FROM {$_TABLES["access"]},{$_TABLES["features"]} "
                     . "WHERE ft_id = acc_ft_id AND acc_grp_id IN ($glist)");

    $nrows = DB_numrows($result);
    for ($j = 1; $j <= $nrows; $j++) {
        $A = DB_fetchArray($result);
        if ($_SEC_VERBOSE) {
            COM_errorLog('Adding right ' . $A['ft_name'] . ' in SEC_getUserPermissions',1);
        }
        $retval .= $A['ft_name'] . ',';
    }
    
    return $retval;
}

/**
* Converts permissions to numeric values
*
* This function will take all permissions for an object and get the numeric value
* that can then be used to save the database.
*
* @param        array       $perm_owner     Array of owner permissions  These arrays are set up by SEC_getPermissionsHTML
* @param        array       $perm_group     Array of group permissions
* @param        array       $perm_members   Array of member permissions
* @param        array       $perm_anon      Array of anonymous user permissions
* @return       array       returns numeric equivalent for each permissions array (2 = read, 3=edit/read)
* @see	SEC_getPermissionsHTML
* @see  SEC_getPermissionValue
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
* @param        array       $perm_x     Array of permission values
* @return       int         integer representation of a permission array 2 = read 3 = edit/read
* @see SEC_getPermissionValues
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
