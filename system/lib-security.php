<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | lib-security.php                                                          |
// |                                                                           |
// | Geeklog security library.                                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Mark Limburg     - mlimburg AT users DOT sourceforge DOT net     |
// |          Vincent Furia    - vmf AT abtech DOT org                         |
// |          Michael Jervis   - mike AT fuckingbrit DOT com                   |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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

// Turn this on to get various debug messages from the code in this library
$_SEC_VERBOSE = false;

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-security.php') !== false) {
    die('This file can not be used on its own!');
}

/* Constants for account stats */
define('USER_ACCOUNT_DISABLED', 0); // Account is banned/disabled
define('USER_ACCOUNT_AWAITING_ACTIVATION', 1); // Account awaiting user to login.
define('USER_ACCOUNT_AWAITING_APPROVAL', 2); // Account awaiting moderator approval
define('USER_ACCOUNT_ACTIVE', 3); // active account

/* Constant for Security Token */
if (!defined('CSRF_TOKEN')) {
    define('CSRF_TOKEN', '_glsectoken');
}

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
* @param        int     $uid            User ID to get information for. If empty current user.
* @return	array	Associative Array grp_name -> ug_main_grp_id of group ID's user belongs to
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

    if ($result === false) {
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

        if (count($cgroups) > 0) {
            $glist = implode(',', $cgroups);
            $result = DB_query("SELECT ug_main_grp_id,grp_name FROM {$_TABLES["group_assignments"]},{$_TABLES["groups"]}"
                    . " WHERE grp_id = ug_main_grp_id AND ug_grp_id IN ($glist)",1);
            $nrows = DB_numRows($result);
        } else {
            $nrows = 0;
        }
    }

    uksort($groups, 'strcasecmp');

    if ($_SEC_VERBOSE) {
        COM_errorLog("****************leaving getusergroups(uid=$uid)***************",1);
    }

    return $groups;
}

/**
  * Checks to see if a user has admin access to the "Remote Users" group
  * Admin users will probably not be members, but, User Admin, Root, and
  * group admin will have access to it. However, we can not be sure what
  * the group id for "Remote User" group is, because it's a later static
  * group, and upgraded systems could have it in any id slot.
  *
  * @param      groupid     int     The id of a group, which might be the remote users group
  * @param      groups      array   Array of group ids the user has access to.
  * @return     boolean
  */
function SEC_groupIsRemoteUserAndHaveAccess($groupid, $groups)
{
    global $_TABLES, $_CONF;
    if(!isset($_CONF['remote_users_group_id']))
    {
        $result = DB_query("SELECT grp_id FROM {$_TABLES['groups']} WHERE grp_name='Remote Users'");
        if( $result )
        {
            $row = DB_fetchArray( $result );
            $_CONF['remote_users_group_id'] = $row['grp_id'];
        }
    }
    if( $groupid == $_CONF['remote_users_group_id'] )
    {
        if( in_array( 1, $groups ) || // root
            in_array( 9, $groups ) || // user admin
            in_array( 11, $groups ) // Group admin
          )
        {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
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

    if (empty ($uid)) {
        if (empty ($_USER['uid'])) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }

    if ((empty($_USER['uid']) && ($uid == 1)) ||
            (isset($_USER['uid']) && ($uid == $_USER['uid']))) {
        if (empty($_GROUPS)) {
            $_GROUPS = SEC_getUserGroups($uid);
        }
        $groups = $_GROUPS;
    } else {
        $groups = SEC_getUserGroups($uid);
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
* Checks to see if current user has access to a configuration
* 
* @return   boolean     returns if user has any config. rights
*/
function SEC_hasConfigAcess() {
    global $_CONF_FT;
    
    if (SEC_hasRights($_CONF_FT, 'OR')) {
        return true;
    }
    
    return false;
}

/**
* Checks to see if current user has access to a topic
*
* Checks to see if current user has access to a topic
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

    $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['topics']} WHERE tid = '$tid'");
    $A = DB_fetchArray($result);

    return SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
}

/**
* Checks if current user has access to the given object
*
* This function takes the access info from a Geeklog object
* and let's us know if they have access to the object
* returns 3 for read/edit, 2 for read only and 0 for no
* access
*
* @param        int     $owner_id       ID of the owner of object
* @param        int     $group_id       ID of group object belongs to
* @param        int     $perm_owner     Permissions the owner has
* @param        int     $perm_group     Permissions the gorup has
* @param        int     $perm_members   Permissions logged in members have
* @param        int     $perm_anon      Permissions anonymous users have
* @param        int     $uid            User id or 0 = current user
* @return       int 	returns 3 for read/edit 2 for read only 0 for no access
*
*/
function SEC_hasAccess($owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon, $uid = 0)
{
    global $_USER;

    if ($uid == 0) {
        // Cache current user id
        if (empty($_USER['uid'])) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }
    
    // If user is in Root group then return full access
    if (SEC_inGroup('Root', $uid)) {
        return 3;
    }

    // If user is owner then return 1 now
    if ($uid == $owner_id) return $perm_owner;

    // Not private, if user is in group then give access
    if (SEC_inGroup($group_id, $uid)) {
        return $perm_group;
    } else {
        if ($uid == 1) {
            // This is an anonymous user, return it's rights
            return $perm_anon;
        } else {
            // This is a logged in member, return their rights
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

    if (is_string($features) && strstr($features,',')) {
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
* This will return the HTML needed to create the security control seen on the
* admin screen for GL objects (i.e. stories, etc)
*
* @param        int     $perm_owner     Permissions the owner has 1 = edit 2 = read 3 = read/edit
* @param        int     $perm_group     Permission the group has
* @param        int     $perm_members   Permissions logged in members have
* @param        int     $perm_anon      Permissions anonymous users have
* @return       string  needed HTML (table) in HTML $perm_owner = array of permissions [edit,read], etc edit = 1 if permission, read = 2 if permission
*
*/
function SEC_getPermissionsHTML($perm_owner, $perm_group, $perm_members, $perm_anon)
{
    global $_CONF, $LANG_ACCESS;

    $retval = '';

    $perm_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/common');
    $perm_templates->set_file(array('editor' => 'edit_permissions.thtml'));

    $perm_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $perm_templates->set_var('owner', $LANG_ACCESS['owner']);
    $perm_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $perm_templates->set_var('group', $LANG_ACCESS['group']);
    $perm_templates->set_var('lang_members', $LANG_ACCESS['members']);
    $perm_templates->set_var('members', $LANG_ACCESS['members']);
    $perm_templates->set_var('lang_anonymous', $LANG_ACCESS['anonymous']);
    $perm_templates->set_var('anonymous', $LANG_ACCESS['anonymous']);

    // Owner Permissions
    if ($perm_owner >= 2) {
        $perm_templates->set_var('owner_r_checked',' checked="checked"');
    }
    if ($perm_owner == 3) {
        $perm_templates->set_var('owner_e_checked',' checked="checked"');
    }
    // Group Permissions
    if ($perm_group >= 2) {
        $perm_templates->set_var('group_r_checked',' checked="checked"');
    }
    if ($perm_group == 3) {
        $perm_templates->set_var('group_e_checked',' checked="checked"');
    }
    // Member Permissions
    if ($perm_members == 2) {
        $perm_templates->set_var('members_checked',' checked="checked"');
    }
    // Anonymous Permissions
    if ($perm_anon == 2) {
        $perm_templates->set_var('anon_checked',' checked="checked"');
    }

    $perm_templates->parse('output', 'editor');
    $retval .= $perm_templates->finish($perm_templates->get_var('output'));

    return $retval;
}

/**
* Gets everything a user has permissions to within the system
*
* This is part of the Geeklog security implementation.  This function
* will get all the permissions the current user has. Calls itself recursively.
*
* @param    int     $grp_id     DO NOT USE (Used for recursion) Current group function is working on
* @param    int     $uid        User to check, if empty current user.
* @return   string  returns comma delimited list of features the user has access to
*
*/
function SEC_getUserPermissions($grp_id='', $uid='')
{
    global $_TABLES, $_USER, $_SEC_VERBOSE, $_GROUPS;

    $retval = '';

    if ($_SEC_VERBOSE) {
        COM_errorLog("**********inside SEC_getUserPermissions(grp_id=$grp_id)**********",1);
    }

    // Get user ID if we don't already have it
    if (empty ($uid)) {
        if (empty ($_USER['uid'])) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }

    if ((empty ($_USER['uid']) && ($uid == 1)) || ($uid == $_USER['uid'])) {
        if (empty ($_GROUPS)) {
            $_GROUPS = SEC_getUserGroups ($uid);
        }
        $groups = $_GROUPS;
    } else {
        $groups = SEC_getUserGroups ($uid);
    }

    if (empty($groups)) {
        // this shouldn't happen - make a graceful exit to avoid an SQL error
        return '';
    }

    $glist = implode(',', $groups);
    $result = DB_query("SELECT DISTINCT ft_name FROM {$_TABLES["access"]},{$_TABLES["features"]} "
                     . "WHERE ft_id = acc_ft_id AND acc_grp_id IN ($glist)");

    $nrows = DB_numrows($result);
    for ($j = 1; $j <= $nrows; $j++) {
        $A = DB_fetchArray($result);
        if ($_SEC_VERBOSE) {
            COM_errorLog('Adding right ' . $A['ft_name'] . ' in SEC_getUserPermissions',1);
        }
        $retval .= $A['ft_name'];
        if ($j < $nrows) {
            $retval .= ',';
        }
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
        COM_errorLog('perm_owner = ' . $perm_owner, 1);
        COM_errorLog('perm_group = ' . $perm_group, 1);
        COM_errorLog('perm_member = ' . $perm_members, 1);
        COM_errorLog('perm_anon = ' . $perm_anon, 1);
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
* @return       int         int representation of a permission array 2 = read 3 = edit/read
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

    for ($i = 1; $i <= count($perm_x); $i++) {
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

/**
* Return the group to a given feature.
*
* Scenario: We have a feature and we want to know from which group the user
* got this feature. Always returns the lowest group ID, in case the feature
* has been inherited from more than one group.
*
* @param    string  $feature    the feature, e.g 'story.edit'
* @param    int     $uid        (optional) user ID
* @return   int                 group ID or 0
*
*/
function SEC_getFeatureGroup ($feature, $uid = '')
{
    global $_GROUPS, $_TABLES, $_USER;

    $ugroups = array ();

    if (empty ($uid)) {
        if (empty ($_USER['uid'])) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }

    if ((empty ($_USER['uid']) && ($uid == 1)) || ($uid == $_USER['uid'])) {
        if (empty ($_GROUPS)) {
            $_GROUPS = SEC_getUserGroups ($uid);
        }
        $ugroups = $_GROUPS;
    } else {
        $ugroups = SEC_getUserGroups ($uid);
    }

    $group = 0;

    $ft_id = DB_getItem ($_TABLES['features'], 'ft_id', "ft_name = '$feature'");
    if (($ft_id > 0) && (count($ugroups) > 0)) {
        $grouplist = implode (',', $ugroups);
        $result = DB_query ("SELECT acc_grp_id FROM {$_TABLES['access']} WHERE (acc_ft_id = $ft_id) AND (acc_grp_id IN ($grouplist)) ORDER BY acc_grp_id LIMIT 1");
        $A = DB_fetchArray ($result);
        if (isset ($A['acc_grp_id'])) {
            $group = $A['acc_grp_id'];
        }
    }

    return $group;
}

/**
* Attempt to login a user.
*
* Checks a users username and password against the database. Returns
* users status.
*
* @param    string  $username   who is logging in?
* @param    string  $password   what they claim is their password
* @param    int     $uid        This is an OUTPUT param, pass by ref,
*                               sends back UID inside it.
* @return   int                 user status, -1 for fail.
*
*/
function SEC_authenticate($username, $password, &$uid)
{
    global $_CONF, $_TABLES, $LANG01;

    $password = str_replace(array("\015", "\012"), '', $password);

    $result = DB_query("SELECT status, passwd, email, uid FROM {$_TABLES['users']} WHERE username='$username' AND ((remoteservice is null) or (remoteservice = ''))");
    $tmp = DB_error();
    $nrows = DB_numRows($result);

    if (($tmp == 0) && ($nrows == 1)) {
        $U = DB_fetchArray($result);
        $uid = $U['uid'];
        if ($U['status'] == USER_ACCOUNT_DISABLED) {
            // banned, jump to here to save an password hash calc.
            return USER_ACCOUNT_DISABLED;
        } elseif (SEC_encryptUserPassword($password, $uid) < 0) {
            return -1; // failed login
        } elseif ($U['status'] == USER_ACCOUNT_AWAITING_APPROVAL) {
            return USER_ACCOUNT_AWAITING_APPROVAL;
        } elseif ($U['status'] == USER_ACCOUNT_AWAITING_ACTIVATION) {
            // Awaiting user activation, activate:
            DB_change($_TABLES['users'], 'status', USER_ACCOUNT_ACTIVE,
                      'username', $username);
            return USER_ACCOUNT_ACTIVE;
        } else {
            return $U['status']; // just return their status
        }
    } else {
        $tmp = $LANG01[32] . ": '" . $username . "'";
        COM_errorLog($tmp, 1);
        return -1;
    }
}

/**
* Return the current user status for a user.
*
* NOTE:     May not return for banned/non-approved users.
*
* @param    int  $userid   Valid uid value.
* @return   int            user status, 0-3
*
*/
function SEC_checkUserStatus($userid)
{
    global $_CONF, $_TABLES;

    // Check user status
    $status = DB_getItem($_TABLES['users'], 'status', "uid=$userid");

    // only do redirects if we aren't on users.php in a valid mode (logout or
    // default)
    if (strpos($_SERVER['PHP_SELF'], 'users.php') === false) {
        $redirect = true;
    } else {
        if (empty($_REQUEST['mode']) || ($_REQUEST['mode'] == 'logout')) {
            $redirect = false;
        } else {
            $redirect = true;
        }
    }
    if ($status == USER_ACCOUNT_AWAITING_ACTIVATION) {
        DB_change($_TABLES['users'], 'status', USER_ACCOUNT_ACTIVE, 'uid', $userid);
    } elseif ($status == USER_ACCOUNT_AWAITING_APPROVAL) {
        // If we aren't on users.php with a default action then go to it
        if ($redirect) {
            COM_accessLog("SECURITY: Attempted Cookie Session login from user awaiting approval $userid.");
            echo COM_refresh($_CONF['site_url'] . '/users.php?msg=70');
            exit;
        }
    } elseif ($status == USER_ACCOUNT_DISABLED) {
        if ($redirect) {
            COM_accessLog("SECURITY: Attempted Cookie Session login from banned user $userid.");
            echo COM_refresh($_CONF['site_url'] . '/users.php?msg=69');
            exit;
        }
    }

    return $status;
}

/**
  * Check to see if we can authenticate this user with a remote server
  *
  * A user has not managed to login localy, but has an @ in their user
  * name and we have enabled distributed authentication. Firstly, try to
  * see if we have cached the module that we used to authenticate them
  * when they signed up (i.e. they've actualy changed their password
  * elsewhere and we need to synch.) If not, then try to authenticate
  * them with /every/ authentication module. If this suceeds, create
  * a user for them.
  *
  * @param  string  $loginname Their username
  * @param  string  $passwd The password entered
  * @param  string  $service The service portion of $username
  * @param  string  $uid OUTPUT parameter, pass it by ref to get uid back.
  * @return int     user status, -1 for fail.
  */
function SEC_remoteAuthentication(&$loginname, $passwd, $service, &$uid)
{
    global $_CONF, $_TABLES;

    /* First try a local cached login */
    $remoteusername = addslashes($loginname);
    $remoteservice = addslashes($service);
    $result = DB_query("SELECT passwd, status, uid FROM {$_TABLES['users']} WHERE remoteusername='$remoteusername' AND remoteservice='$remoteservice'");
    $tmp = DB_error();
    $nrows = DB_numRows($result);
    if (($tmp == 0) && ($nrows == 1)) {
        $U = DB_fetchArray($result);
        $uid = $U['uid'];
        $mypass = $U['passwd']; // also used to see if the user existed later.
        if ($mypass == SEC_encryptPassword($passwd)) {
            /* Valid password for cached user, return status */
            return $U['status'];
        }
    }

    $service = COM_sanitizeFilename($service);
    $servicefile = $_CONF['path_system'] . 'classes/authentication/' . $service
                 . '.auth.class.php';
    if (file_exists($servicefile)) {
        require_once $servicefile;

        $authmodule = new $service();
        if ($authmodule->authenticate($loginname, $passwd)) {
            /* check to see if they have logged in before: */
            if (empty($mypass)) {
                // no such user, create them

                // Check to see if their remoteusername is unique locally
                $checkName = DB_getItem($_TABLES['users'], 'username',
                                        "username='$remoteusername'");
                if (!empty($checkName)) {
                    // no, call custom function.
                    if (function_exists('CUSTOM_uniqueRemoteUsername')) {
                        $loginname = CUSTOM_uniqueRemoteUsername($loginname,
                                                                 $service);
                    }
                }
                USER_createAccount($loginname, $authmodule->email, $passwd, $authmodule->fullname, $authmodule->homepage, $remoteusername, $remoteservice);
                $uid = DB_getItem($_TABLES['users'], 'uid', "remoteusername = '$remoteusername' AND remoteservice='$remoteservice'");
                // Store full remote account name:
                DB_query("UPDATE {$_TABLES['users']} SET remoteusername='$remoteusername', remoteservice='$remoteservice', status=3 WHERE uid='$uid'");
                // Add to remote users:
                $remote_grp = DB_getItem($_TABLES['groups'], 'grp_id',
                                         "grp_name='Remote Users'");
                DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) VALUES ($remote_grp, $uid)");
                return 3; // Remote auth precludes usersubmission,
                          // and integrates user activation, see?
            } else {
                // user existed, update local password:
                DB_change($_TABLES['users'], 'passwd', SEC_encryptPassword($passwd), array('remoteusername','remoteservice'), array($remoteusername,$remoteservice));
                // and return their status
                return DB_getItem($_TABLES['users'], 'status', "remoteusername='$remoteusername' AND remoteservice='$remoteservice'");
            }
        } else {
            return -1;
        }
    } else {
        return -1;
    }
}

/**
* Return available modules for Remote Authentication
*
* @return   array   Names of available remote authentication modules
*
*/
function SEC_collectRemoteAuthenticationModules()
{
    global $_CONF;

    $modules = array();

    $modulespath = $_CONF['path_system'] . 'classes/authentication/';
    if (is_dir($modulespath)) {
        $folder = opendir($modulespath);
        while (($filename = @readdir($folder)) !== false) {
            $pos = strpos($filename, '.auth.class.php');
            if ($pos && (substr($filename, strlen($filename) - 4) == '.php')) {
                $modules[] = substr($filename, 0, $pos);
            }
        }
    }

    return $modules;
}

/**
  * Add user to a group
  *
  * work in progress
  *
  * Rather self explanitory shortcut function
  * Is this the right place for this, Dirk?
  *
  * @author Trinity L Bays, trinity93 AT gmail DOT com
  *
  * @param  string  $uid Their user id
  * @param  string  $gname The group name
  * @return boolean status, true or false.
  */
function SEC_addUserToGroup($uid, $gname)
{
    global $_TABLES, $_CONF;

    $remote_grp = DB_getItem ($_TABLES['groups'], 'grp_id', "grp_name='". $gname ."'");
    DB_query ("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id,ug_uid) VALUES ($remote_grp, $uid)");
}

/**
* Set default permissions for an object
*
* @param    array   $A                  target array
* @param    array   $use_permissions    permissions to set
*
*/
function SEC_setDefaultPermissions (&$A, $use_permissions = array ())
{
    if (!is_array ($use_permissions) || (count ($use_permissions) != 4)) {
        $use_permissions = array (3, 2, 2, 2);
    }

    // sanity checks
    if (($use_permissions[0] > 3) || ($use_permissions[0] < 0) ||
            ($use_permissions[0] == 1)) {
        $use_permissions[0] = 3;
    }
    if (($use_permissions[1] > 3) || ($use_permissions[1] < 0) ||
            ($use_permissions[1] == 1)) {
        $use_permissions[1] = 2;
    }
    if (($use_permissions[2] != 2) && ($use_permissions[2] != 0)) {
        $use_permissions[2] = 2;
    }
    if (($use_permissions[3] != 2) && ($use_permissions[3] != 0)) {
        $use_permissions[3] = 2;
    }

    $A['perm_owner']   = $use_permissions[0];
    $A['perm_group']   = $use_permissions[1];
    $A['perm_members'] = $use_permissions[2];
    $A['perm_anon']    = $use_permissions[3];
}


/**
* Common function used to build group access SQL
*
* @param   string  $clause    Optional parm 'WHERE' - default is 'AND'
* @return  string  $groupsql  Formatted SQL string to be appended in calling script SQL statement
*/
function SEC_buildAccessSql ($clause = 'AND')
{
    global $_TABLES, $_USER;

    if (isset($_USER) AND $_USER['uid'] > 1) {
        $uid = $_USER['uid'];
    } else {
        $uid = 1;
    }

    $_GROUPS = SEC_getUserGroups($uid);
    $groupsql = '';
    if (count($_GROUPS) == 1) {
        $groupsql .= " $clause grp_access = '" . current($_GROUPS) ."'";
    } else {
        $groupsql .= " $clause grp_access IN (" . implode(',',array_values($_GROUPS)) .")";
    }

    return $groupsql;
}

/**
* Remove a feature from the database entirely.
*
* This function can be used by plugins during uninstall.
*
* @param    string  $feature_name   name of the feature, e.g. 'foo.edit'
* @param    boolean $logging        whether to log progress in error.log
* @return   void
*
*/
function SEC_removeFeatureFromDB ($feature_name, $logging = false)
{
    global $_TABLES;

    if (!empty ($feature_name)) {
        $feat_id = DB_getItem ($_TABLES['features'], 'ft_id',
                               "ft_name = '$feature_name'");
        if (!empty ($feat_id)) {
            // Before removing the feature itself, remove it from all groups
            if ($logging) {
                COM_errorLog ("Attempting to remove '$feature_name' rights from all groups", 1);
            }
            DB_delete ($_TABLES['access'], 'acc_ft_id', $feat_id);
            if ($logging) {
                COM_errorLog ('...success', 1);
            }

            // now remove the feature itself
            if ($logging) {
                COM_errorLog ("Attempting to remove the '$feature_name' feature", 1);
            }
            DB_delete ($_TABLES['features'], 'ft_id', $feat_id);
            if ($logging) {
                COM_errorLog ('...success', 1);
            }
        } else if ($logging) {
            COM_errorLog ("SEC_removeFeatureFromDB: Feature '$feature_name' not found.");
        }
    }
}

/**
* Create a group dropdown
*
* Creates the group dropdown menu that's used on pretty much every admin page
*
* @param    int     $group_id   current group id (to be selected)
* @param    int     $access     access permission
* @return   string              HTML for the dropdown
*
*/
function SEC_getGroupDropdown ($group_id, $access)
{
    global $_TABLES;

    $groupdd = '';

    if ($access == 3) {
        $usergroups = SEC_getUserGroups ();

        $groupdd .= '<select name="group_id">' . LB;
        foreach ($usergroups as $ug_name => $ug_id) {
            $groupdd .= '<option value="' . $ug_id . '"';
            if ($group_id == $ug_id) {
                $groupdd .= ' selected="selected"';
            }
            $groupdd .= '>' . ucwords($ug_name) . '</option>' . LB;
        }
        $groupdd .= '</select>' . LB;
    } else {
        // They can't set the group then
        $groupdd .= DB_getItem ($_TABLES['groups'], 'grp_name',
                                "grp_id = '$group_id'")
                 . '<input type="hidden" name="group_id" value="' . $group_id
                 . '"' . XHTML . '>';
    }

    return $groupdd;
}

/**
 * Class defining constants for encryptions algorithms. These values are stored
 * in the user database to indicate the hash function the user's password is
 * encrypted with.
 */
class HashFunction {
    const md5      = 0;
    const sha1     = 1;
    const sha256   = 2;
    const sha512   = 3;
    const blowfish = 4;
}

/**
* Encrypt password
*
* Encrypts $password using the specified salt, hash algorithm, and stretch
* count.
*
* @param    string  $password   the password to encrypt, in clear text
* @param    string  $salt       salt to prepend to the password prior to hashing
* @param    int     $algorithm  hash algorithm to use to encrypt the password
* @param    int     $stretch    number of times hash function should be applied
*                               to the password.
* @return   string              encrypted password
*
*/
function SEC_encryptPassword($password, $salt = '', $algorithm = null, $stretch = null)
{
    global $_CONF;

    /* grab defaults if not specified, default salt is empty */
    if ( is_null($algorithm) ) {
        $algorithm = $_CONF['pass_alg'];
    }
    if ( is_null($stretch) ) {
        $stretch = $_CONF['pass_stretch'];
    }

    /* A stretch of less than one implies no encryption, do not allow that */
    if ($stretch < 1) {
        $stretch = 1;
    }

    /* encrypt password based on algorithm */
    switch ($algorithm) {
    case HashFunction::md5:
        $hash = $password;
        for ($i = 0; $i < $stretch; $i++) {
            $hash = md5($hash . $salt, false);
        }
        break;

    case HashFunction::sha1:
        $hash = $password;
        for ($i = 0; $i < $stretch; $i++) {
            $hash = sha1($hash . $salt, false);
        }
        break;

    case HashFunction::sha256:
        if ($stretch < 1000) $stretch = 1000;
        $salt = '$5$rounds=' . $stretch . '$' . $salt . '$';
        $hash = crypt($password, $salt);
        break;

    case HashFunction::sha512:
        if ($stretch < 1000) $stretch = 1000;
        $salt = '$6$rounds=' . $stretch . '$' . $salt . '$';
        $hash = crypt($password, $salt);
        break;

    case HashFunction::blowfish:
        $stretch = log($stretch, 2);       /* blow fish crypt uses a log 2 number for cost */
        if ($stretch < 4) $stretch = 4;    /* crypt defined minimum */
        if ($stretch > 31) $stretch = 31;  /* crypt defined maximum */
        $salt = '$2a$' . sprintf('%02d', $stretch) . '$' . $salt . '$';
        $hash = crypt($password, $salt);
        break;

    default:  /* unrecognized algorithm error */
        return -1;
    }

    return $hash;
}

/**
 * Generate password salt
 *
 * This function produces a random string of 22 characters from a 64 character set.
 * The size is needed for password salting, but is useful any function that needs a
 * random set of human readable characters.
 *
 * @return  string  generated salt
 */
function SEC_generateSalt() {
    static $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';

    $salt = '';
    for ($i = 0; $i < 22; $i++) {
        $salt .= $charset[mt_rand(0,61)];
    }

    return $salt;
}

/**
 * Encrypt User Password
 *
 * Verify that the provided password authenticates the specified user (defualts
 * to the current user).
 *
 * @param  string  $password  password to verify
 * @param  int     $uid       user id to authenticate
 * @return int     0 for success, non-zero for failure or error
 */
function SEC_encryptUserPassword($password, $uid = '')
{
    global $_USER, $_CONF, $_TABLES;

    // if $uid is empty, assume current user
    if (empty($uid)) {
        $uid = $_USER['uid'];
    }

    // validate $uid nonempty and valid user (anonymous, uid = 1, not valid)
    if (empty($uid) || $uid < 1) {
        return -1;
    }

    /* get passwd, algorithm, stretch, and salt from $_USER if possible, else
     * get them from the DB
     */
    if ( ( isset($_USER['uid']) && ($uid == $_USER['uid']) && isset($_USER['passwd']) &&
           isset($_USER['algorithm']) && isset($_USER['stretch']) && isset($_USER['salt']) ) ) {
        $passwd    = $_USER['passwd'];
        $algorithm = $_USER['algorithm'];
        $stretch   = $_USER['stretch'];
        $salt      = $_USER['salt'];
    } else {
        $query = "SELECT passwd, salt, algorithm, stretch FROM " . $_TABLES['users']
               . " WHERE uid = $uid";
        $result = DB_query($query);
        list($passwd, $salt, $algorithm, $stretch) = DB_fetchArray($result);
    }

    /* verify we have good data */
    if (empty($passwd) || is_null($salt) || !is_numeric($algorithm) || empty($stretch)) {
        return -1;
    }

    // calculate hash to verify password
    $newhash = SEC_encryptPassword($password, $salt, $algorithm, $stretch);

    /* if the hash checks out, update hash if needed and return success, otherwise return an error */
    if ($newhash == $passwd) {
        if ($algorithm != $_CONF['pass_alg'] || $stretch != $_CONF['pass_stretch'] || empty($salt)) {
            SEC_updateUserPassword($password, $uid);
        }
        return 0;
    } else {
        return -255;
    }
}

/**
 * Generate Random Password
 *
 * Generates a random string of human readable characters.
 *
 * @return  string  generated random password
 */
function SEC_generateRandomPassword() {
    // SEC_generateSalt is used here as it creates a random string using readable characters
    return substr(SEC_generateSalt(), 0, 12);
}

/**
 * Update User Password
 *
 * Updates the users password for current hash algorithm and stretch site settings.
 * If not password is specified, a random password will be generated.
 *
 * @param  string  $password  Password to encrypt
 * @param  int     $uid       User id to update
 * @return int     0 for success, non-zero indicates error.
 */
function SEC_updateUserPassword(&$password = '', $uid = '') {
    global $_TABLES, $_CONF, $_USER;

    // if no password is specified, generate a random one
    if (empty($password)) {
        $password = SEC_generateRandomPassword();
    }

    // if $uid is empty, assume current user
    if (empty($uid)) {
        $uid = $_USER['uid'];
    }

    // validate $uid nonempty and valid user (anonymous, uid = 1, not valid)
    if (empty($uid) || $uid < 1) {
        return -1;
    }

    // update the database with the new password using algorithm and stretch from $_CONF
    $salt = SEC_generateSalt();
    $newhash = SEC_encryptPassword($password, $salt, $_CONF['pass_alg'], $_CONF['pass_stretch']);
    $query = 'UPDATE ' . $_TABLES['users'] . " SET passwd = \"$newhash\", "
        . "salt = \"$salt\", algorithm =\"" . $_CONF['pass_alg'] . '",' 
        . 'stretch = ' . $_CONF['pass_stretch'] . " WHERE uid = $uid";
    DB_query($query);

    // return success
    return 0;
}

/**
* Generate a security token.
*
* This generates and stores a one time security token. Security tokens are
* added to forms and urls in the admin section as a non-cookie double-check
* that the admin user really wanted to do that...
*
* @param  int  $ttl  Time to live for token in seconds. Default is 20 minutes.
* @return string  Generated token, it'll be an MD5 hash (32chars)
* @see SEC_checkToken
*
*/
function SEC_createToken($ttl = 1200)
{
    global $_TABLES, $_USER;

    static $last_token;

    if (isset($last_token)) {
        return $last_token;
    }
    
	$uid = isset($_USER['uid']) ? $_USER['uid'] : 1;
    
    /* Figure out the full url to the current page */
    $pageURL = COM_getCurrentURL();
    
    /* Generate the token */
    $token = md5($uid.$pageURL.uniqid (rand (), 1));
    $pageURL = addslashes($pageURL);
    
    /* Destroy exired tokens: */
    $sql['mssql'] = "DELETE FROM {$_TABLES['tokens']} WHERE (DATEADD(ss, ttl, created) < NOW())"
           . " AND (ttl > 0)";
    $sql['mysql'] = "DELETE FROM {$_TABLES['tokens']} WHERE (DATE_ADD(created, INTERVAL ttl SECOND) < NOW())"
           . " AND (ttl > 0)";
    $sql['pgsql'] = "DELETE FROM {$_TABLES['tokens']} WHERE ROUND(EXTRACT(EPOCH FROM ABSTIME(created)))::int4 + (SELECT ttl from {$_TABLES['tokens']} LIMIT 1) < ROUND(EXTRACT(EPOCH FROM ABSTIME(NOW())))::int4"
           . " AND (ttl > 0)";                           
    DB_query($sql);
    
    /* Destroy tokens for this user/url combination */
    $sql = "DELETE FROM {$_TABLES['tokens']} WHERE owner_id='{$uid}' AND urlfor='$pageURL'";
    DB_query($sql);
    
    /* Create a token for this user/url combination */
    /* NOTE: TTL mapping for PageURL not yet implemented */
    $sql = "INSERT INTO {$_TABLES['tokens']} (token, created, owner_id, urlfor, ttl) "
           . "VALUES ('$token', NOW(), $uid, '$pageURL', $ttl)";
    DB_query($sql);
           
    $last_token = $token;

    /* And return the token to the user */
    return $token;
}

/**
* Check a security token.
*
* Checks the POST and GET data for a security token, if one exists, validates
* that it's for this user and URL. If the token is not valid, it asks the user
* to re-authenticate and resends the request if authentication was successful.
*
* @return   boolean     true if the token is valid; does not return if not!
* @see      SECINT_checkToken
* @link http://wiki.geeklog.net/index.php/Re-Authentication_for_expired_Tokens
*
*/
function SEC_checkToken()
{
    global $_CONF, $LANG20, $LANG_ADMIN;

    if (SECINT_checkToken()) {

        // if this was a recreated request, recreate $_FILES array, too
        SECINT_recreateFilesArray();

        return true;
    }

    /**
    * Token not valid (probably expired): Ask user to authenticate again
    */
    $returnurl = COM_getCurrentUrl();
    $method = strtoupper($_SERVER['REQUEST_METHOD']);
    $postdata = serialize($_POST);
    $getdata = serialize($_GET);
    $files = '';
    if (! empty($_FILES)) {
        // rescue uploaded files
        foreach ($_FILES as $key => $f) {
            if (! empty($f['name'])) {
                $filename = basename($f['tmp_name']);
                move_uploaded_file($f['tmp_name'],
                                   $_CONF['path_data'] . $filename);
                $_FILES[$key]['tmp_name'] = $filename; // drop temp. dir
            }
        }
        $files = serialize($_FILES);
    }

    $display = COM_showMessageText($LANG_ADMIN['token_expired'])
             . SECINT_authform($returnurl, $method, $postdata, $getdata, $files);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG20[1]));

    COM_output($display);
    exit;

    // we don't return from here
}

/**
* Helper function: Actual check of the security token
*
* @return   boolean     true if the token is valid and for this user.
* @access   private
* @see      SEC_checkToken
*
*/
function SECINT_checkToken()
{
    global $_TABLES, $_USER, $_DB_dbms;

    $token = ''; // Default to no token.
    $return = false; // Default to fail.
    
    if (array_key_exists(CSRF_TOKEN, $_GET)) {
        $token = COM_applyFilter($_GET[CSRF_TOKEN]);
    } elseif (array_key_exists(CSRF_TOKEN, $_POST)) {
        $token = COM_applyFilter($_POST[CSRF_TOKEN]);
    }
    
    if(trim($token) != '') {
        if($_DB_dbms != 'mssql') {
            $sql['mysql'] = "SELECT ((DATE_ADD(created, INTERVAL ttl SECOND) < NOW()) AND ttl > 0) as expired, owner_id, urlfor FROM "
               . "{$_TABLES['tokens']} WHERE token='$token'";
            $sql['pgsql'] = "SELECT ((UNIX_TIMESTAMP(created) + ttl) < UNIX_TIMESTAMP() AND ttl > 0)::int4 as expired, owner_id, urlfor FROM "
               . "{$_TABLES['tokens']} WHERE token='$token'";
        } else {
            $sql['mssql'] = "SELECT owner_id, urlfor, expired = 
                      CASE 
                         WHEN (DATEADD(s,ttl,created) < getUTCDate()) AND (ttl>0) THEN 1
                
                         ELSE 0
                      END
                    FROM {$_TABLES['tokens']} WHERE token='$token'"; 
        }
        $tokens = DB_query($sql);
        $numberOfTokens = DB_numRows($tokens);
        if($numberOfTokens != 1) {
            $return = false; // none, or multiple tokens. Both are invalid. (token is unique key...)
        } else {
            $tokendata = DB_fetchArray($tokens);
            /* Check that:
             *  token's user is the current user.
             *  token is not expired.
             *  the http referer is the url for which the token was created.
             */
            if( $_USER['uid'] != $tokendata['owner_id'] ) {
                $return = false;
            } else if($tokendata['urlfor'] != $_SERVER['HTTP_REFERER']) {
                $return = false;
            } else if($tokendata['expired']) {
                $return = false;
            } else {
                $return = true; // Everything is AOK in only one condition...
            }
           
            // It's a one time token. So eat it.
            DB_delete($_TABLES['tokens'], 'token', $token);
        }
    } else {
        $return = false; // no token.
    }
    
    return $return;
}

/**
* Helper function: Display loginform and ask user to authenticate again
*
* @param    string  $returnurl  URL to return to after authentication
* @param    string  $method     original request method: POST or GET
* @param    string  $postdata   serialized POST data
* @param    string  $getdata    serialized GET data
* @return   string              HTML for the authentication form
* @access   private
*
*/ 
function SECINT_authform($returnurl, $method, $postdata = '', $getdata = '', $files = '')
{
    global $LANG20, $LANG_ADMIN;

    // stick postdata etc. into hidden input fields
    $hidden = '<input type="hidden" name="mode" value="tokenexpired"'
            . XHTML . '>' . LB;
    $hidden .= '<input type="hidden" name="token_returnurl" value="'
            . urlencode($returnurl) . '"' . XHTML . '>' . LB;
    $hidden .= '<input type="hidden" name="token_postdata" value="'
            . urlencode($postdata) . '"' . XHTML . '>' . LB;
    $hidden .= '<input type="hidden" name="token_getdata" value="'
            . urlencode($getdata) . '"' . XHTML . '>' . LB;
    $hidden .= '<input type="hidden" name="token_files" value="'
            . urlencode($files) . '"' . XHTML . '>' . LB;
    $hidden .= '<input type="hidden" name="token_requestmethod" value="'
            . $method . '"' . XHTML . '>' . LB;
    $hidden .= '<input type="hidden" name="' . CSRF_TOKEN . '" value="'
            . SEC_createToken() . '"'. XHTML . '>' . LB;

    $cfg = array(
        'hide_forgotpw_link' => true,
        'no_newreg_link'     => true,
        'no_openid_login'    => true, // TBD
        'no_plugin_vars'     => true, // no plugin vars in re-auth form, please

        'title'       => $LANG20[1],
        'message'     => $LANG_ADMIN['reauth_msg'],
        'button_text' => $LANG_ADMIN['authenticate'],

        'hidden_fields' => $hidden
    );

    return SEC_loginForm($cfg);
}


/**
* Helper function: Recreate $_FILES array after token re-authentication
*
* @return void
* @access private
*
*/
function SECINT_recreateFilesArray()
{
    global $_CONF;

    if (empty($_FILES)) {
        // recreate $_FILES array
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 7) == '_files_') {
                $file = substr($key, 7);
                foreach ($value as $kk => $kv) {
                    if ($kk == 'tmp_name') {
                        // fix path - uploaded files are in our data directory
                        $filename = COM_sanitizeFilename(basename($kv), true);
                        $kv = $_CONF['path_data'] . $filename;
                        // set a flag so we know where it's coming from
                        $_FILES[$file]['_gl_data_dir'] = true;
                    }
                    $_FILES[$file][$kk] = $kv;
                }
                if (! file_exists($_FILES[$file]['tmp_name'])) {
                    // whoops!?
                    COM_errorLog("Uploaded file {$_FILES[$file]['name']} not found when recreating \$_FILES array");
                    unset($_FILES[$file]);
                }
                unset($_POST[$key]);
            }
        }
    }
}

/**
* Helper function: Clean up any leftover files on failed re-authentication
*
* When re-authentication fails, we need to clean up any files that may have
* been rescued during the original POST request with the expired token. Note
* that the uploaded files are now in the site's 'data' directory.
*
* @param    mixed   $files  original or recreated $_FILES array
* @return   void
* @access   private
*
*/
function SECINT_cleanupFiles($files)
{
    global $_CONF;

    // first, some sanity checks
    if (! is_array($files)) {
        if (empty($files)) {
            return; // nothing to do
        } else {
            $files = @unserialize($files);
        }
    }
    if (!is_array($files) || empty($files)) {
        return; // bogus
    }

    foreach ($files as $key => $value) {
        if (! empty($value['tmp_name'])) {
            // ignore path - file is in $_CONF['path_data']
            $filename = COM_sanitizeFilename(basename($value['tmp_name']), true);
            $orphan = $_CONF['path_data'] . $filename;
            if (file_exists($orphan)) {
                if (! @unlink($orphan)) {
                    COM_errorLog("SECINT_cleanupFile: Unable to remove file $filename from 'data' directory");
                }
            }
        }
    }
}

/**
* Get a token's expiry time
*
* @param    string  $token  the token we're looking for
* @return   int             UNIX timestamp of the expiry time or 0
*
*/
function SEC_getTokenExpiryTime($token)
{
    global $_TABLES, $_USER;

    $retval = 0;

    if (!COM_isAnonUser()) {

        $sql['mysql'] = "SELECT UNIX_TIMESTAMP(DATE_ADD(created, INTERVAL ttl SECOND)) AS expirytime FROM {$_TABLES['tokens']} WHERE (token = '$token') AND (owner_id = '{$_USER['uid']}') AND (ttl > 0)";
        $sql['mssql'] = "SELECT UNIX_TIMESTAMP(DATEADD(ss, ttl, created)) AS expirytime FROM {$_TABLES['tokens']} WHERE (token = '$token') AND (owner_id = '{$_USER['uid']}') AND (ttl > 0)";
        $sql['pgsql'] = "SELECT UNIX_TIMESTAMP(created) + ttl AS expirytime FROM {$_TABLES['tokens']} WHERE (token = '$token') AND (owner_id = '{$_USER['uid']}') AND (ttl > 0)";
        
        $result = DB_query($sql);
        if (DB_numRows($result) == 1) {
            list($retval) = DB_fetchArray($result);
        }
    }

    return $retval;
}

/**
* Create a message informing the user when the security token is about to expire
*
* This message is only created for Remote Users who logged in using OpenID,
* since the re-authentication does not work with OpenID.
*
* @param    string  $token      the token
* @param    string  $extra_msg  (optional) additional text to include in notice
* @return   string              formatted HTML of message
* @see      SEC_checkToken
*
*/
function SEC_getTokenExpiryNotice($token, $extra_msg = '')
{
    global $_CONF, $_USER, $LANG_ADMIN;

    $retval = '';

    if (isset($_USER['remoteservice']) &&
            ($_USER['remoteservice'] == 'openid')) {

        $expirytime = SEC_getTokenExpiryTime($token);
        if ($expirytime > 0) {
            $exptime = '<span id="token-expirytime">'
                     . strftime($_CONF['timeonly'], $expirytime) . '</span>';
            $retval .= '<p id="token-expirynotice">'
                    . sprintf($LANG_ADMIN['token_expiry'], $exptime);
            if (! empty($extra_msg)) {
                $retval .= ' ' . $extra_msg;
            }

            $retval .= '</p>' . LB;
        }

    }

    return $retval;
}

/**
* Set a cookie using the HttpOnly flag
*
* Use this function to set "important" cookies (session, password, ...).
* Browsers that support the HttpOnly flag will not allow JavaScript access
* to such a cookie.
*
* @param    string  $name       cookie name
* @param    string  $value      cookie value
* @param    int     $expire     expire time
* @param    string  $path       path on the server or $_CONF['cookie_path']
* @param    string  $domain     domain or $_CONF['cookiedomain']
* @param    boolean $secure     whether to use HTTPS or $_CONF['cookiesecure']
* @link http://blog.mattmecham.com/2006/09/12/http-only-cookies-without-php-52/
*
*/
function SEC_setCookie($name, $value, $expire = 0, $path = null, $domain = null, $secure = null)
{
    global $_CONF;

    $retval = false;

    if ($path === null) {
        $path = $_CONF['cookie_path'];
    }
    if ($domain === null) {
        $domain = $_CONF['cookiedomain'];
    }
    if ($secure === null) {
        $secure = $_CONF['cookiesecure'];
    }

    $retval = setcookie($name, $value, $expire, $path, $domain, $secure, true);

    return $retval;
}

/**
* Prepare an array of the standard permission values
*
* This helper functions does the following:
* 1) filter permission values, e.g. after a POST request
* 2) translates the permission checkbox arrays into numerical values
* 3) ensures that all the standard permission entries are set, so you don't
*    have to check with isset() all the time
*
* <code>
* $PERM = SEC_filterPermissions($_POST);
* if ($PERM['perm_anon'] != 0) { ...
* </code>
*
* @param    array   $A  array to filter on, e.g. $_POST
* @return   array       array of only the 6 standard permission values
* @see      SEC_getPermissionValues
*
*/
function SEC_filterPermissions($A)
{
    $retval = array();

    if (isset($A['owner_id'])) {
        $retval['owner_id'] = COM_applyFilter($A['owner_id'], true);
    } else {
        $retval['owner_id'] = 0;
    }

    if (isset($A['group_id'])) {
        $retval['group_id'] = COM_applyFilter($A['group_id'], true);
    } else {
        $retval['group_id'] = 0;
    }

    $perms = array('perm_owner', 'perm_group', 'perm_members', 'perm_anon');

    $B = array();
    foreach ($perms as $p) {
        if (isset($A[$p])) {
            $B[$p] = $A[$p];
        } else {
            $B[$p] = array();
        }
    }

    $B = SEC_getPermissionValues($B['perm_owner'], $B['perm_group'],
                                 $B['perm_members'], $B['perm_anon']);
    for ($i = 0; $i < 4; $i++) {
        $retval[$perms[$i]] = $B[$i];
    }

    return $retval;
}

/**
* Helper function for when you want to call SEC_hasAccess and have all the
* values to check in an array.
*
* @param    array   $A  array with the standard permission values
* @return   int         returns 3 for read/edit 2 for read only 0 for no access
* @see      SEC_hasAccess
*
*/
function SEC_hasAccess2($A)
{
    return SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'],
                         $A['perm_group'], $A['perm_members'], $A['perm_anon']);
}

/**
* Display a "to access this area you need to be logged in" message
*
* @return   string      HTML for the message
*
*/
function SEC_loginRequiredForm()
{
    global $_CONF, $LANG_LOGIN;

    $cfg = array(
        'title'   => $LANG_LOGIN[1],
        'message' => $LANG_LOGIN[2]
    );

    return SEC_loginForm($cfg);
}

/**
* Displays a login form
*
* This is the version of the login form displayed in the content area of the
* page (not the side bar). It will present all options (remote authentication
* - including OpenID, new registration link, etc.) according to the current
* configuration settings.
*
* @param    array   $use_config     options to override some of the defaults
* @return   string                  HTML of the login form
*
*/
function SEC_loginForm($use_config = array())
{
    global $_CONF, $LANG01, $LANG04, $_SCRIPTS;

    $retval = '';

    $have_remote_login = false;
    $default_config = array(
        // display options
        'hide_forgotpw_link' => false,

        // for hidden fields to be included in the form
        'hidden_fields'     => '',

        // options to locally override some specific $_CONF options
        'no_oauth_login'    => false, // $_CONF['user_login_method']['oauth']
        'no_3rdparty_login' => false, // $_CONF['user_login_method']['3rdparty']
        'no_openid_login'   => false, // $_CONF['user_login_method']['openid']
        'no_newreg_link'    => false, // $_CONF['disable_new_user_registration']
        'no_plugin_vars'    => false, // call PLG_templateSetVars?

        // default texts
        'title'       => $LANG04[65], // Try Logging in Again
        'message'     => $LANG04[66], // You may have mistyped ...
        'button_text' => $LANG04[80]  // Login
    );

    $config = array_merge($default_config, $use_config);
    
    $loginform = COM_newTemplate($_CONF['path_layout'] . 'users');
    $loginform->set_file('login', 'loginform.thtml');

    $loginform->set_var('start_block_loginagain',
                        COM_startBlock($config['title']));
    $loginform->set_var('lang_message', $config['message']);
    if ($config['no_newreg_link'] || $_CONF['disable_new_user_registration']) {
        $loginform->set_var('lang_newreglink', '');
    } else {
        $loginform->set_var('lang_newreglink', $LANG04[123]);
    }

    $loginform->set_var('lang_username', $LANG04[2]);
    $loginform->set_var('lang_password', $LANG01[57]);
    if ($config['hide_forgotpw_link']) {
        $loginform->set_var('lang_forgetpassword', '');
        $loginform->set_var('forgetpassword_link', '');
    } else {
        $loginform->set_var('lang_forgetpassword', $LANG04[25]);
        $forget = COM_createLink($LANG04[25], $_CONF['site_url']
                                              . '/users.php?mode=getpassword',
                                 array('rel' => 'nofollow'));
        $loginform->set_var('forgetpassword_link', $forget);
    }
    $loginform->set_var('lang_login', $config['button_text']);
    $loginform->set_var('lang_remote_login', $LANG04[167]);
    $loginform->set_var('lang_remote_login_desc', $LANG04[168]);
    $loginform->set_var('end_block', COM_endBlock());

    // 3rd party remote authentification.
    $services = '';
    if (!$config['no_3rdparty_login'] &&
            $_CONF['user_login_method']['3rdparty'] &&
            ($_CONF['usersubmission'] == 0)) {
        $modules = SEC_collectRemoteAuthenticationModules();
        if (count($modules) > 0) {
            if (!$_CONF['user_login_method']['standard'] &&
                    (count($modules) == 1)) {
                $select = '<input type="hidden" name="service" value="'
                        . $modules[0] . '"' . XHTML . '>' . $modules[0];
            } else {
                // Build select
                $select = '<select name="service">';
                if ($_CONF['user_login_method']['standard']) {
                    $select .= '<option value="">' .  $_CONF['site_name']
                            . '</option>';
                }
                foreach ($modules as $service) {
                    $select .= '<option value="' . $service . '">' . $service
                            . '</option>';
                }
                $select .= '</select>';
            }

            $loginform->set_file('services', 'services.thtml');
            $loginform->set_var('lang_service', $LANG04[121]);
            $loginform->set_var('select_service', $select);
            $loginform->parse('output', 'services');
            $services .= $loginform->finish($loginform->get_var('output'));
        }
    }
    if (! empty($config['hidden_fields'])) {
        // allow caller to (ab)use {services} for hidden fields
        $services .= $config['hidden_fields'];
    }
    $loginform->set_var('services', $services);

    // OpenID remote authentification.
    if (!$config['no_openid_login'] && $_CONF['user_login_method']['openid'] &&
            ($_CONF['usersubmission'] == 0) &&
            !$_CONF['disable_new_user_registration']) {
        $have_remote_login = true;
        $_SCRIPTS->setJavascriptFile('login', '/javascript/login.js');
        $loginform->set_file('openid_login', '../loginform_openid.thtml');
        $loginform->set_var('lang_openid_login', $LANG01[128]);
        $loginform->set_var('input_field_size', 40);

        // for backward compatibility - not used any more
        $app_url = isset($_SERVER['SCRIPT_URI'])
                 ? $_SERVER['SCRIPT_URI']
                 : 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        $loginform->set_var('app_url', $app_url);

        $loginform->parse('output', 'openid_login');
        $loginform->set_var('openid_login',
            $loginform->finish($loginform->get_var('output')));
    } else {
        $loginform->set_var('openid_login', '');
    }

    // OAuth remote authentification.
    if (!$config['no_oauth_login'] && $_CONF['user_login_method']['oauth'] && 
            ($_CONF['usersubmission'] == 0) &&
            !$_CONF['disable_new_user_registration']) {
        $have_remote_login = true;
        $_SCRIPTS->setJavascriptFile('login', '/javascript/login.js');
        $modules = SEC_collectRemoteOAuthModules();
        if (count($modules) == 0) {
            $loginform->set_var('oauth_login', '');
        } else {
            $html_oauth = '';
            foreach ($modules as $service) {
                $loginform->set_file('oauth_login', '../loginform_oauth.thtml');
                $loginform->set_var('oauth_service', $service);
                $loginform->set_var('lang_oauth_service', $LANG01[$service]);
                // for sign in image
                $loginform->set_var('oauth_sign_in_image', $_CONF['site_url'] . '/images/' . $service . '-login-icon.png');
                $loginform->parse('output', 'oauth_login');
                $html_oauth .= $loginform->finish($loginform->get_var('output'));
            }
            $loginform->set_var('oauth_login', $html_oauth);
        }
    } else {
        $loginform->set_var('oauth_login', '');
    }

    if ($have_remote_login) {
        $loginform->set_var('remote_login_class', 'remote-login-enabled');
    }

    if (! $config['no_plugin_vars']) {
        PLG_templateSetVars('loginform', $loginform);
    }
    $loginform->parse('output', 'login');

    $retval .= $loginform->finish($loginform->get_var('output'));

    return $retval;
}

/**
* Return available modules for Remote OAuth
*
* @return   array   Names of available remote OAuth modules
*
*/
function SEC_collectRemoteOAuthModules()
{
    global $_CONF;

    $modules = array();
    
    // Check for OpenSSL PHP extension which is required
    if (extension_loaded('openssl')) {
        $modulespath = $_CONF['path_system'] . 'classes/oauth/';
        if (is_dir($modulespath)) {
            $folder = opendir($modulespath);
            while (($filename = @readdir($folder)) !== false) {
                $pos = strpos($filename, '.auth.class.php');
                if ($pos && (substr($filename, strlen($filename) - 4) == '.php')) {
                    $mod = substr($filename, 0, $pos);
                    $def_thtml = $_CONF['path_layout'] . 'loginform_oauth.thtml';
                    $thtml = $_CONF['path_layout'] . 'loginform_' . $mod . '.thtml';
                    if (file_exists($def_thtml) || file_exists($thtml)) {
                        // Check to see if there is a config value to enable or disable login method
                        if (isset($_CONF[$mod . '_login'])) {
                            if ($_CONF[$mod . '_login']) {
                                // Now check if a Consumer Key and Secret exist and are set
                                if (isset($_CONF[$mod . '_consumer_key'])) {
                                    if ($_CONF[$mod . '_consumer_key'] != '') {
                                        if (isset($_CONF[$mod . '_consumer_secret'])) {
                                            if ($_CONF[$mod . '_consumer_secret'] != '') {
                                                $modules[] = $mod;
                                            }
                                        }                                
                                    }
                                }                                
                            }
                        } else {
                            $modules[] = $mod;
                        }
                    }
                }
            }
        }
    }
    
    return $modules;
}

/**
* Returns the default Root user id
*
* @return   int   The id of the default Root user
*
*/
function SEC_getDefaultRootUser()
{
    global $_TABLES;
     
    $rootgrp = DB_getItem ($_TABLES['groups'], 'grp_id',
                           "grp_name = 'Root'");
    
    $sql = "SELECT u.uid FROM {$_TABLES['users']} u,{$_TABLES['group_assignments']} ga  
            WHERE u.uid > 1 AND u.uid = ga.ug_uid AND (ga.ug_main_grp_id = $rootgrp)
            GROUP BY u.uid ORDER BY u.uid ASC LIMIT 1";
    
    $result = DB_query ($sql);
    $A = DB_fetchArray ($result);      
    
    return $A['uid'];
}

?>
