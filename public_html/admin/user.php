<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-user.php                                                              |
// | Geeklog user administration page.                                         |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
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
// $Id: user.php,v 1.15 2001/12/17 16:23:12 tony_bibbs Exp $

// Set this to true to get various debug messages from this script
$_USER_VERBOSE = false;

include('../lib-common.php');
include('auth.inc.php');

$display = '';

// Make sure user has access to this page  
if (!SEC_hasRights('user.edit')) {
    $retval .= COM_siteHeader('menu');
    $retval .= COM_startBlock($MESSAGE[30]);
    $retval .= $MESSAGE[37];
    $retval .= COM_endBlock();
    $retval .= COM_siteFooter();
    COM_errorLog("User {$_USER['username']} tried to illegally access the user administration screen",1);
    echo $retval;
    exit;
}

/**
* Shows the user edit form
*
* @uid          int         User to edit
*
*/
function edituser($uid = '', $msg = '') 
{
	global $_TABLES, $LANG28, $_CONF, $LANG_ACCESS, $_USER;

    $retval = '';

    if (!empty($msg)) {
        $retval .= COM_startBlock($LANG28[22]) . $LANG28[$msg] . COM_endBlock();
    }

	$retval .= COM_startBlock($LANG28[1]);

	if (!empty($uid)) {
		$result = DB_query("SELECT * FROM {$_TABLES['users']} WHERE uid ='$uid'");
		$A = DB_fetchArray($result);
		
		if (SEC_inGroup('Root',$uid) AND !SEC_inGroup('Root')) {
			// the current admin user isn't Root but is trying to change
			// a root account.  Deny them and log it.
			$retval .= $LANG_ACCESS[editrootmsg];
			COM_errorLog("User {$_USER['username']} tried to edit a root account with insufficient privileges",1);
			$retval .= COM_endBlock();
			return $retval;
		}
		$curtime = COM_getUserDateTimeFormat($A['regdate']);
	} else {
        $tmp = DB_query("SELECT MAX(uid) AS max FROM {$_TABLES['users']}");
        $T = DB_fetchArray($tmp);
        $A['uid'] = $T['max'] + 1;
		$curtime =  COM_getUserDateTimeFormat();
    }

	$A['regdate'] = $curtime[0];

    $user_templates = new Template($_CONF['path_layout'] . 'admin/user');
    $user_templates->set_file(array('form'=>'edituser.thtml','groupedit'=>'groupedit.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('lang_save', $LANG28[20]);
	if ($A['uid'] > 1) { 
        $user_templates->set_var('change_password_option', '<input type="submit" value="' . $LANG28[17] . '" name="mode">');
    }
	if (!empty($uid) && SEC_hasRights('user.delete')) {
        $user_templates->set_var('delete_option', '<input type="submit" value="' . $LANG28[19] . '" name="mode">');
	}
    $user_templates->set_var('lang_cancel', $LANG28[18]);

    $user_templates->set_var('lang_userid', $LANG28[2]);
    $user_templates->set_var('user_id', $A['uid']);
    $user_templates->set_var('lang_regdate', $LANG28[14]);
    $user_templates->set_var('user_regdate', $A['regdate']);
    $user_templates->set_var('lang_username', $LANG28[3]);
    $user_templates->set_var('username', $A['username']);
    $user_templates->set_var('lang_fullname', $LANG28[4]);
    $user_templates->set_var('user_fullname', $A['fullname']);
    $user_templates->set_var('lang_password', $LANG28[5]); 
    $user_templates->set_var('lang_emailaddress', $LANG28[7]);
    $user_templates->set_var('user_email', $A['email']);
    $user_templates->set_var('lang_homepage', $LANG28[8]);
    $user_templates->set_var('user_homepage', $A['homepage']);

	if (SEC_inGroup('Group Admin')) {
        $user_templates->set_var('lang_securitygroups', $LANG_ACCESS[securitygroups]);
        $user_templates->set_var('lang_groupinstructions', $LANG_ACCESS[securitygroupsmsg]);
        
        if (!empty($uid)) { 
		    $usergroups = SEC_getUserGroups($uid);
		    if (is_array($usergroups) && !empty($uid)) {
			    $selected = implode(' ',$usergroups);
		    } else {
			    $selected = '';
		    }
        } else {
            $selected = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='All Users'") . ' ';
            $selected .= DB_getItem($_TABLES['groups'],'grp_id',"grp_name='Logged-in Users'");
        }
		$user_templates->set_var('group_options', COM_checkList($_TABLES['groups'],'grp_id,grp_name','',$selected));
        $user_templates->parse('group_edit', 'groupedit', true);
	} else {
		// user doesn't have the rights to edit a user's groups so set to -1 so we know not to
		// handle the groups array when we save
		$user_templates->set_var('group_edit', '<input type="hidden" name="groups" value="-1">');
	}
    $user_templates->parse('output', 'form');
    $retval .= $user_templates->finish($user_templates->get_var('output')); 
	$retval .= COM_endBlock();

    return $retval;
}

/**
* Changes a user's password
*
* @uid      int     ID of user to change password for
* @passwd   int     New password
*
*/
function changepw($uid,$passwd) 
{
	global $_TABLES; 

    $retval = '';

	if (!empty($passwd) && !empty($uid)) {
		$passwd = md5($passwd);
		$result = DB_change($_TABLES['users'],'passwd',"$passwd",'uid',$uid,'admin/user.php?mode=none');	
	} else {
		$retval .= COM_siteHeader('menu');
		COM_errorLog("CHANGEPW ERROR: There was nothing to do!",3);
		$retval .= COM_siteFooter();
	}
}

/**
* Saves $uid to the database
*
*/
function saveusers($uid,$username,$fullname,$passwd,$email,$regdate,$homepage,$groups) 
{
	global $_TABLES, $_CONF, $LANG28, $_USER_VERBOSE;

	if ($_USER_VERBOSE) COM_errorLog("**** entering saveusers****",1);	
	if ($_USER_VERBOSE) COM_errorLog("group size at beginning = " . sizeof($groups),1);	

    $ucount = DB_getItem($_TABLES['users'],'count(*)',"username = '$username' AND uid <> $uid");
    if ($ucount > 0) {
        // Admin just changes a user's username to one that already exists...bail
        return edituser($uid, 21);
    }

	if (!empty($username) && !empty($email)) {
		if (($uid == 1) or !empty($passwd)) { 
			$passwd = md5($passwd);
			$sql = "REPLACE INTO {$_TABLES['users']} (uid,username,fullname,passwd,email,homepage) VALUES ($uid,'$username','$fullname','$passwd','$email','$homepage')";
		} else {
			$sql = "SELECT passwd FROM {$_TABLES['users']} WHERE uid = $uid";
			$result = DB_query($sql);
			$A = DB_fetchArray($result);
			$sql = "REPLACE INTO {$_TABLES['users']} (uid,username,fullname,passwd,email,homepage) VALUES ($uid,'$username','$fullname','" . $A["passwd"] . "','$email','$homepage')";
		} 
		$result = DB_query($sql);

		// if groups is -1 then this user isn't allowed to change any groups so ignore
		if (is_array($groups)) {
			if ($_USER_VERBOSE) COM_errorLog("deleting all group_assignments for user $uid/$username",1);
			DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_uid = $uid");
			if (!empty($groups)) {
				for ($i = 1; $i <= sizeof($groups); $i++) {
					if ($_USER_VERBOSE) COM_errorLog("adding group_assignment " . current($groups) . " for $username",1);
					$sql = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES (" . current($groups) . ",$uid)";
					DB_query($sql);
					next($groups);		
				}
			}
		}
		DB_save($_TABLES['userprefs'],'uid',$uid);
		DB_save($_TABLES['usercomment'],'uid',$uid);
		DB_save($_TABLES['userindex'],'uid',$uid);
		DB_save($_TABLES['userinfo'],'uid',$uid);
        	$errors = DB_error();
		if (empty($errors)) { 
			echo COM_refresh($_CONF['site_url'] . '/admin/user.php?msg=21');
		} else {
			$retval .= COM_siteHeader('menu');
            $retval .= COM_errorLog('Error in saveusers in admin/users.php');
			$retval .= COM_siteFooter();
		}
	} else {
		$retval .= COM_siteHeader('menu');
		$retval .= COM_errorLog($LANG28[10]);
		$retval .= edituser($uid);
		$retval .= COM_siteFooter();
	}

	if ($_USER_VERBOSE) COM_errorLog("***************leaving saveusers*****************",1);	

    return $retval;
}

/**
* Lists all users in the system
*
*/
function listusers() 
{
	global $_TABLES, $LANG28, $_CONF;

    $retval = '';

	$retval .= COM_startBlock($LANG28[11]);

    $user_templates = new Template($_CONF['path_layout'] . 'admin/user');
    $user_templates->set_file(array('list'=>'userslist.thtml','row'=>'listitem.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('lang_newuser', $LANG28[15]);
    $user_templates->set_var('lang_adminhome', $LANG28[16]);
    $user_templates->set_var('lang_instructions', $LANG28[12]); 
    $user_templates->set_var('lang_username', $LANG28[3]);
    $user_templates->set_var('lang_fullname', $LANG28[4]);
    $user_templates->set_var('lang_emailaddress', $LANG28[7]);

	$result = DB_query("SELECT uid,username,fullname,email FROM {$_TABLES['users']} WHERE uid > 1");
	$nrows = DB_numRows($result);

	for ($i = 0; $i < $nrows; $i++) {
		$A = DB_fetchArray($result);
        $user_templates->set_var('user_id', $A['uid']);
        $user_templates->set_var('username', $A['username']);
        $user_templates->set_var('user_fullname', $A['fullname']);
        $user_templates->set_var('user_email', $A['email']);
        $user_templates->parse('user_row', 'row', true);
	}
    
    $user_templates->parse('output', 'list');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

	$retval .= COM_endBlock();

    return $retval;

}

###############################################################################
# MAIN
switch ($mode) {
case $LANG28[19]:
    // Ok, delete everything related to this user
		
    #first, remove from all security groups
    DB_delete($_TABLES['group_assignments'],'ug_uid',$uid);
	
    // what to do with orphan stories/comments?
	
    // now move delete the user itself
    DB_delete($_TABLES['users'],'uid',$uid,'admin/user.php?msg=22');
    break;
case $LANG28[20]:
    $display = saveusers($uid,$username,$fullname,$passwd,$email,$regdate,$homepage,$HTTP_POST_VARS[$_TABLES['groups']]);
    if (!empty($display)) {
        $tmp = COM_siteHeader('menu');
        $tmp .= $display;
        $tmp .= COM_siteFooter('menu');
        $display = $tmp;
    }
    break;
case $LANG28[17]:
    changepw($uid,$passwd);
    break;
case 'edit':
    $display .= COM_siteHeader('menu');
    $display .= edituser($uid);
    $display .= COM_siteFooter();
    break;
case $LANG28[18]:
default:
    $display .= COM_siteHeader('menu');
    $display .= COM_showMessage($msg);
    $display .= listusers();
    $display .= COM_siteFooter();
    break;
}

echo $display;

?>
