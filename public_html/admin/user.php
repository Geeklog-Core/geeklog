<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | user.php                                                                  |
// |                                                                           |
// | Geeklog user administration page.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
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
//
// $Id: user.php,v 1.90 2005/03/25 21:34:08 blaine Exp $

// Set this to true to get various debug messages from this script
$_USER_VERBOSE = false;

require_once ('../lib-common.php');
require_once ('auth.inc.php');
require_once ($_CONF['path_system'] . 'lib-user.php');

$display = '';

// Make sure user has access to this page  
if (!SEC_hasRights('user.edit')) {
    $retval .= COM_siteHeader ('menu');
    $retval .= COM_startBlock ($MESSAGE[30], '',
               COM_getBlockTemplate ('_msg_block', 'header'));
    $retval .= $MESSAGE[37];
    $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $retval .= COM_siteFooter ();
    COM_accessLog("User {$_USER['username']} tried to illegally access the user administration screen.");
    echo $retval;
    exit;
}

/**
* Shows the user edit form
*
* @param    int     $uid    User to edit
* @param    int     $msg    Error message to display
* @return   string          HTML for user edit form
*
*/
function edituser($uid = '', $msg = '') 
{
    global $_CONF, $_TABLES, $_USER, $LANG28, $LANG_ACCESS, $MESSAGE;

    $retval = '';

    if (!empty ($msg)) {
        $retval .= COM_startBlock ($LANG28[22], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
                . $MESSAGE[$msg]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    if (!empty ($msg) && !empty ($uid) && ($uid > 1)) {
        // an error occured while editing a user - if it was a new account,
        // don't bother trying to read the user's data from the database ...
        $cnt = DB_count ($_TABLES['users'], 'uid', $uid);
        if ($cnt == 0) {
            $uid = '';
        }
    }

    if (!empty ($uid) && ($uid > 1)) {
        $result = DB_query("SELECT * FROM {$_TABLES['users']} WHERE uid = '$uid'");
        $A = DB_fetchArray($result);
        if (empty ($A['uid'])) {
            return COM_refresh ($_CONF['site_admin_url'] . '/user.php');
        }

        if (SEC_inGroup('Root',$uid) AND !SEC_inGroup('Root')) {
            // the current admin user isn't Root but is trying to change
            // a root account.  Deny them and log it.
            $retval .= COM_startBlock ($LANG28[1], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
            $retval .= $LANG_ACCESS['editrootmsg'];
            COM_accessLog("User {$_USER['username']} tried to edit a Root account with insufficient privileges.");
            $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            return $retval;
        }
        $curtime = COM_getUserDateTimeFormat($A['regdate']);
        $lastlogin = DB_getItem ($_TABLES['userinfo'], 'lastlogin', "uid = '$uid'");
        $lasttime = COM_getUserDateTimeFormat ($lastlogin);
    } else {
        $A['uid'] = '';
        $uid = '';
        $curtime =  COM_getUserDateTimeFormat();
        $lastlogin = '';
        $lasttime = '';
    }

    $retval .= COM_startBlock ($LANG28[1], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $user_templates = new Template($_CONF['path_layout'] . 'admin/user');
    $user_templates->set_file (array ('form' => 'edituser.thtml',
                                      'groupedit' => 'groupedit.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('lang_save', $LANG28[20]);
    if (!empty ($A['uid']) && ($A['uid'] > 1)) { 
        $user_templates->set_var('change_password_option', '<input type="submit" value="' . $LANG28[17] . '" name="mode">');
    }
    if (!empty($uid) && ($A['uid'] != $_USER['uid']) && SEC_hasRights('user.delete')) {
        $user_templates->set_var('delete_option', '<input type="submit" value="' . $LANG28[19] . '" name="mode">');
    }
    $user_templates->set_var('lang_cancel', $LANG28[18]);

    $user_templates->set_var('lang_userid', $LANG28[2]);
    if (empty ($A['uid'])) {
        $user_templates->set_var ('user_id', 'n/a');
    } else {
        $user_templates->set_var ('user_id', $A['uid']);
    }
    $user_templates->set_var('lang_regdate', $LANG28[14]);
    $user_templates->set_var('regdate_timestamp', $curtime[1]);
    $user_templates->set_var('user_regdate', $curtime[0]);
    $user_templates->set_var('lang_lastlogin', $LANG28[35]);
    if (empty ($lastlogin)) {
        $user_templates->set_var('user_lastlogin', $LANG28[36]);
    } else {
        $user_templates->set_var('user_lastlogin', $lasttime[0]);
    }
    $user_templates->set_var('lang_username', $LANG28[3]);
    $user_templates->set_var('username', $A['username']);

    if (($_CONF['allow_user_photo'] == 1) && !empty ($A['photo'])) {
        if (strstr ($_CONF['path_images'], $_CONF['path_html'])) {
            $imgpath = substr ($_CONF['path_images'],
                               strlen ($_CONF['path_html']));
            $user_templates->set_var ('user_photo', '<img src="'
                . $_CONF['site_url'] . '/' . $imgpath . 'userphotos/'
                . $A['photo'] . '" alt="">');
        } else {
            $user_templates->set_var ('user_photo', '<img src="' . $_CONF['site_url'] . '/getimage.php?mode=userphotos&amp;image=' . $A['photo'] . '" alt="">');
        }
        $user_templates->set_var ('lang_delete_photo', $LANG28[28]);
        $user_templates->set_var ('delete_photo_option',
                '<input type="checkbox" name="delete_photo">');
    } else {
        $user_templates->set_var ('user_photo', '');
        $user_templates->set_var ('lang_delete_photo', '');
        $user_templates->set_var ('delete_photo_option', '');
    }

    $user_templates->set_var('lang_fullname', $LANG28[4]);
    $user_templates->set_var('user_fullname', htmlspecialchars($A['fullname']));
    $user_templates->set_var('lang_password', $LANG28[5]); 
    $user_templates->set_var('lang_emailaddress', $LANG28[7]);
    $user_templates->set_var('user_email', htmlspecialchars($A['email']));
    $user_templates->set_var('lang_homepage', $LANG28[8]);
    $user_templates->set_var('user_homepage', htmlspecialchars($A['homepage']));
    $user_templates->set_var('do_not_use_spaces', $LANG28[9]);

    if ($_CONF['custom_registration'] AND (function_exists('custom_useredit'))) {
        if (!empty ($uid) && ($uid > 1)) {
            $user_templates->set_var('customfields', custom_useredit($uid) );
        } else {
            $user_templates->set_var('customfields', custom_useredit($A['uid']) );
        }
    }

    if (SEC_hasRights('group.edit')) {
        $user_templates->set_var('lang_securitygroups', $LANG_ACCESS['securitygroups']);
        $user_templates->set_var('lang_groupinstructions', $LANG_ACCESS['securitygroupsmsg']);

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
        $thisUsersGroups = SEC_getUserGroups ();
        $where = 'grp_id IN (' . implode (',', $thisUsersGroups) . ')';
        $user_templates->set_var ('group_options',
                COM_checkList ($_TABLES['groups'], 'grp_id,grp_name',
                               $where, $selected));
        $user_templates->parse('group_edit', 'groupedit', true);
    } else {
        // user doesn't have the rights to edit a user's groups so set to -1
        // so we know not to handle the groups array when we save
        $user_templates->set_var ('group_edit',
                '<input type="hidden" name="groups" value="-1">');
    }
    $user_templates->parse('output', 'form');
    $retval .= $user_templates->finish($user_templates->get_var('output')); 
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Changes a user's password
*
* @param    int     $uid        ID of user to change password for
* @param    string  $passwd     New password
* @return   string              HTML redirect or error message
*
*/
function changepw ($uid, $passwd)
{
    global $_CONF, $_TABLES;

    $retval = '';

    if (!empty ($passwd) && !empty ($uid)) {
        $passwd = md5 ($passwd);
        $result = DB_change ($_TABLES['users'], 'passwd', "$passwd",
                             'uid', $uid);

        $retval .= COM_refresh ($_CONF['site_admin_url'] . '/user.php?msg=5');
    } else {
        $retval .= COM_siteHeader ('menu');
        $retval .= COM_errorLog ('CHANGEPW ERROR: There was nothing to do!', 3);
        $retval .= COM_siteFooter ();
    }

    return $retval;
}

/**
* Saves user to the database
*
* @param    int     $uid            user id
* @param    string  $usernmae       (short) user name
* @param    string  $fullname       user's full name
* @param    string  $email          user's email address
* @param    string  $regdate        date the user registered with the site
* @param    string  $homepage       user's homepage URL
* @param    array   $groups         groups the user belongs to
* @param    string  $delete_photo   delete user's photo if == 'on'
* @return   string                  HTML redirect or error message
*
*/
function saveusers ($uid, $username, $fullname, $passwd, $email, $regdate, $homepage, $groups, $delete_photo = '') 
{
    global $_CONF, $_TABLES, $_USER, $LANG28, $_USER_VERBOSE;

    $retval = '';

    if ($_USER_VERBOSE) COM_errorLog("**** entering saveusers****",1);    
    if ($_USER_VERBOSE) COM_errorLog("group size at beginning = " . sizeof($groups),1);    

    if (!empty ($username) && !empty ($email)) {

        if (!COM_isEmail ($email)) {
            return edituser ($uid, 52);
        }

        $uname = addslashes ($username);
        if (empty ($uid)) {
            $ucount = DB_getItem ($_TABLES['users'], 'COUNT(*)',
                                  "username = '$uname'");
        } else {
            $ucount = DB_getItem ($_TABLES['users'], 'COUNT(*)',
                                  "username = '$uname' AND uid <> $uid");
        }
        if ($ucount > 0) {
            // Admin just changed a user's username to one that already exists
            return edituser ($uid, 51);
        }

        $emailaddr = addslashes ($email);
        if (empty ($uid)) {
            $ucount = DB_getItem ($_TABLES['users'], 'count(*)',
                                  "email = '$emailaddr'");
        } else {
            $ucount = DB_getItem ($_TABLES['users'], 'count(*)',
                                  "email = '$emailaddr' AND uid <> $uid");
        }
        if ($ucount > 0) {
            // Admin just changed a user's email to one that already exists
            return edituser ($uid, 56);
        }

        if (empty ($uid) || !empty ($passwd)) { 
            $passwd = md5 ($passwd);
        } else {
            $passwd = DB_getItem ($_TABLES['users'], 'passwd', "uid = $uid");
        }

        if (empty ($uid)) {
            if (empty ($passwd)) {
                // no password? create one ...
                srand ((double) microtime () * 1000000);
                $passwd = rand ();
                $passwd = md5 ($passwd);
                $passwd = substr ($passwd, 1, 8);
                $passwd = md5 ($passwd);
            }

            $uid = USER_createAccount ($username, $email, $passwd, $fullname,
                                       $homepage);
        } else {
            $fullname = addslashes ($fullname);
            $homepage = addslashes ($homepage);
            $curphoto = DB_getItem($_TABLES['users'],'photo',"uid = $uid");
            if (!empty($curphoto) AND $delete_photo == 'on') {
                if (!unlink($_CONF['path_html'] . 'images/userphotos/' . $curphoto)) {
                    echo COM_errorLog('Unable to delete photo ' . $curphoto);
                    exit;
                }
                $curphoto = '';
            }

            if (($_CONF['allow_user_photo'] == 1) && !empty ($curphoto)) {
                $curusername = DB_getItem ($_TABLES['users'], 'username',
                                           "uid = $uid");
                if ($curusername != $username) {
                    // user has been renamed - rename the photo, too
                    $newphoto = preg_replace ('/' . $curusername . '/',
                                              $username, $curphoto, 1);
                    $imgpath = $_CONF['path_images'] . 'userphotos/';
                    if (rename ($imgpath . $curphoto,
                                $imgpath . $newphoto) === false) {
                        $display = COM_siteHeader ('menu');
                        $display .= COM_errorLog ('Could not rename userphoto "'
                                        . $photo . '" to "' . $newphoto . '".');
                        $display .= COM_siteFooter ();
                        return $display;
                    }
                    $curphoto = $newphoto;
                }
            }

            $curphoto = addslashes ($curphoto);
            DB_query("UPDATE {$_TABLES['users']} SET username = '$username', fullname = '$fullname', passwd = '$passwd', email = '$email', homepage = '$homepage', photo = '$curphoto' WHERE uid = $uid");
            if ($_CONF['custom_registration'] AND (function_exists('custom_usersave'))) {
                custom_usersave($uid);
            }
            PLG_userInfoChanged ($uid);
        }

        // if groups is -1 then this user isn't allowed to change any groups so ignore
        if (is_array ($groups) && SEC_inGroup ('Group Admin')) {
            if (!SEC_inGroup ('Root')) {
                $rootgrp = DB_getItem ($_TABLES['groups'], 'grp_id',
                                       "grp_name = 'Root'");
                if (in_array ($rootgrp, $groups)) {
                    COM_accessLog ("User {$_USER['username']} just tried to give Root permissions to user $username.");
                    echo COM_refresh ($_CONF['site_admin_url'] . '/index.php');
                    exit;
                }
            }
            if ($_USER_VERBOSE) COM_errorLog("deleting all group_assignments for user $uid/$username",1);
            // remove user from all groups that the User Admin is a member of
            $UserAdminGroups = SEC_getUserGroups ();
            $whereGroup = 'ug_main_grp_id IN ('
                        . implode (',', $UserAdminGroups) . ')';
            DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_uid = $uid) AND " . $whereGroup);
            if (!empty($groups)) {
                for ($i = 1; $i <= sizeof($groups); $i++) {
                    if (in_array (current ($groups), $UserAdminGroups)) {
                        if ($_USER_VERBOSE) COM_errorLog("adding group_assignment " . current($groups) . " for $username",1);
                        $sql = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES (" . current($groups) . ",$uid)";
                        DB_query($sql);
                    }
                    next($groups);        
                }
            }
        }
        $errors = DB_error();
        if (empty($errors)) { 
            echo COM_refresh($_CONF['site_admin_url'] . '/user.php?msg=21');
        } else {
            $retval .= COM_siteHeader ('menu');
            $retval .= COM_errorLog ('Error in saveusers in '
                                     . $_CONF['site_admin_url'] . '/user.php');
            $retval .= COM_siteFooter ();
            echo $retval;
            exit;
        }
    } else {
        $retval = COM_siteHeader('menu');
        $retval .= COM_errorLog($LANG28[10]);
        if (DB_count($_TABLES['users'],'uid',$uid) > 0) {
            $retval .= edituser($uid);
        } else {
            $retval .= edituser();
        }
        $retval .= COM_siteFooter();
        echo $retval;
        exit;
    }

    if ($_USER_VERBOSE) COM_errorLog("***************leaving saveusers*****************",1);    

    return $retval;
}

/**
* Lists all users in the system
*
* @param    int     $offset         start of list
* @param    int     $curpage        current page
* @param    string  $query          query string for search
* @param    int     $query_limit    max. entries per page
* @return   string                  HTML for list of users
*
*/
function listusers ($offset, $curpage, $query = '', $query_limit = 50) 
{
    global $_CONF, $_TABLES, $LANG28;
        
    $retval = '';

    $retval .= COM_startBlock ($LANG28[11], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $user_templates = new Template($_CONF['path_layout'] . 'admin/user');
    $user_templates->set_file (array ('list' => 'userslist.thtml',
                                      'row' => 'listitem.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('lang_newuser', $LANG28[15]);
    $user_templates->set_var('lang_batchadd',$LANG28[23]);
    $user_templates->set_var('lang_adminhome', $LANG28[16]);
    $user_templates->set_var('lang_instructions', $LANG28[12]);
    $user_templates->set_var('lang_search', $LANG28[26]);
    $user_templates->set_var('lang_submit', $LANG28[33]);
    $user_templates->set_var('last_query', $query);
    $user_templates->set_var('lang_limit_results', $LANG28[27]);
    $user_templates->set_var('lang_username', $LANG28[3]);
    $user_templates->set_var('lang_fullname', $LANG28[4]);
    $user_templates->set_var('lang_emailaddress', $LANG28[7]);

    if (empty($query_limit)) {
        $limit = 50;
    } else {
        $limit = $query_limit;
    }
    $user_templates->set_var($limit . '_selected', 'selected="selected"');
    
    if (!empty ($query)) {
        $query = addslashes (str_replace ('*', '%', $query));
        $num_pages = ceil (DB_getItem ($_TABLES['users'], 'count(*)',
                "uid > 1 AND (username LIKE '$query' OR email LIKE '$query' OR fullname LIKE '$query')") / $limit);
        if ($num_pages < $curpage) {
            $curpage = 1;
        }
    } else {
        $num_pages = ceil (DB_getItem ($_TABLES['users'], 'count(*)',
                                       'uid > 1') / $limit);
    }

    $offset = (($curpage - 1) * $limit);

    if (!empty($query)) {
        $sql = "SELECT uid,username,fullname,email FROM {$_TABLES['users']} WHERE uid > 1 AND (username LIKE '$query' OR email LIKE '$query' OR fullname LIKE '$query') ORDER BY uid LIMIT $offset,$limit";
    } else {
        $sql = "SELECT uid,username,fullname,email FROM {$_TABLES['users']} WHERE uid > 1 ORDER BY uid LIMIT $offset,$limit";
    }
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $user_templates->set_var('user_id', $A['uid']);
        $user_templates->set_var('username', $A['username']);
        $user_templates->set_var('user_fullname', $A['fullname']);
        $user_templates->set_var('user_email', $A['email']);
        $user_templates->parse('user_row', 'row', true);
    }
    if (!empty($query)) {
        $query = str_replace('%','*',$query);
        $base_url = $_CONF['site_admin_url'] . '/user.php?q=' . urlencode($query) . '&amp;query_limit=' . $query_limit;
    } else {
        $base_url = $_CONF['site_admin_url'] . '/user.php?query_limit=' . $query_limit;
    }

    if ($num_pages > 1) {
        $user_templates->set_var('google_paging',COM_printPageNavigation($base_url,$curpage,$num_pages));
    } else {
        $user_templates->set_var('google_paging', '');
    }
    $user_templates->parse('output', 'list');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* This function allows the administrator to import batches of users
*
* @param    string  $file   file to import
* @return   string          HTML with success or error message
*
*/
function importusers ($file)
{
    global $_CONF, $_TABLES, $LANG04, $LANG28;

    // Setting this to true will cause import to print processing status to
    // webpage and to the error.log file
    $verbose_import = true;

    $retval = '';

    // First, upload the file
    require_once ($_CONF['path_system'] . 'classes/upload.class.php');

    $upload = new upload ();
    $upload->setPath ($_CONF['path_data']);
    $upload->setAllowedMimeTypes (array ('text/plain' => '.txt'));
    $upload->setFileNames ('user_import_file.txt');
    if ($upload->uploadFiles ()) {
        // Good, file got uploaded, now install everything
        $thefile =  current ($_FILES);
        $filename = $_CONF['path_data'] . 'user_import_file.txt';
    } else {
        // A problem occurred, print debug information
        $retval = COM_siteHeader ('menu', $LANG28[22]);
        $retval .= COM_startBlock ($LANG28[24], '',
                COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= $upload->printErrors ();
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

        return $retval;
    }

    $users = file ($filename);
    
    $retval .= COM_siteHeader ('menu', $LANG28[22]);
    $retval .= COM_startBlock ($LANG28[31], '',
            COM_getBlockTemplate ('_admin_block', 'header'));

    // Following variables track import processing statistics
    $successes = 0;
    $failures = 0;
    foreach ($users as $line) {
        $line = rtrim ($line);
        if (empty ($line)) {
            continue;
        }

        list ($full_name, $u_name, $email) = explode ("\t", $line);

        $full_name = strip_tags ($full_name);
        $u_name = COM_applyFilter ($u_name);
        $email = COM_applyFilter ($email);

        if ($verbose_import) {
            $retval .="<br><b>Working on username=$u_name, fullname=$full_name, and email=$email</b><br>\n";
            COM_errorLog ("Working on username=$u_name, fullname=$full_name, and email=$email",1);
        }

        // prepare for database
        $userName  = trim ($u_name);
        $fullName  = trim ($full_name);
        $emailAddr = trim ($email);

        if (COM_isEmail ($email)) {
            // email is valid form
            $ucount = DB_count ($_TABLES['users'], 'username',
                                addslashes ($userName));
            $ecount = DB_count ($_TABLES['users'], 'email',
                                addslashes ($emailAddr));

            if ($ucount == 0 && ecount == 0) {
                // user doesn't already exist
                $uid = USER_createAccount ($userName, $emailAddr, '',
                                           $fullName);
                emailpassword ($userName);

                if ($verbose_import) {
                    $retval .= "<br> Account for <b>$u_name</b> created successfully.<br>\n";
                    COM_errorLog("Account for $u_name created successfully",1);
                }
                $successes++;
            } else {
                if ($verbose_import) {
                    $retval .= "<br><b>$u_name</b> or <b>$email</b> already exists, account not created.<br>\n"; // user already exists
                    COM_errorLog("$u_name,$email: username or email already exists, account not created",1);
                }
                $failures++;
            } // end if $ucount == 0 && ecount == 0
        } else {
            if ($verbose_import) {
                $retval .= "<br><b>$email</b> is not a valid email address, account not created<br>\n"; // malformed email
                COM_errorLog("$email is not a valid email address, account not created",1);
            }
            $failures++;
        } // end if COM_isEmail($email)
    } // end foreach

    unlink ($filename);

    $retval .= '<p>' . sprintf ($LANG28[32], $successes, $failures);

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
    $retval .= COM_siteFooter ();  

    return $retval;
}

/**
* Send password to newly created user
*
* @param    string  $username   name of user
*
*/
function emailpassword ($username)
{
    global $_TABLES;

    $email = DB_getItem ($_TABLES['users'], 'email', "username = '$username'");
    if (!empty ($email)) {
        USER_createAndSendPassword ($username, $email);
    }
}


/**
* Display "batch add" (import) form
*
* @return   string      HTML for import form
*
*/
function display_form ()
{
    global $_CONF, $LANG28;

    $retval = '<form action="' . $_CONF['site_admin_url']
            . '/user.php" method="post" enctype="multipart/form-data">'
            . $LANG28[29] . ': <input type="file" name="importfile" size="40">'
            . '<input type="hidden" name="mode" value="import">'
            . '<input type="submit" name="submit" value="' . $LANG28[30]
            . '"></form>';

    return $retval;
}

/**
* Delete a user
*
* @param    int     $uid    id of user to delete
* @return   string          HTML redirect
*
*/
function deleteUser ($uid)
{
    global $_CONF;

    if (!USER_deleteAccount ($uid)) {
        return COM_refresh ($_CONF['site_admin_url'] . '/user.php');
    }

    return COM_refresh ($_CONF['site_admin_url'] . '/user.php?msg=22');
}

// MAIN
$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

if (($mode == $LANG28[19]) && !empty ($LANG28[19])) { // delete
    $uid = COM_applyFilter ($_POST['uid'], true);
    if ($uid > 1) {
        $display .= deleteUser ($uid);
    } else {
        COM_errorLog ('Attempted to delete user uid=' . $uid);
        $display = COM_refresh ($_CONF['site_admin_url'] . '/user.php');
    }
} else if (($mode == $LANG28[20]) && !empty ($LANG28[20])) { // save
    $display = saveusers (COM_applyFilter ($_POST['uid'], true),
            $_POST['username'], $_POST['fullname'],
            $_POST['passwd'], $_POST['email'],
            $_POST['regdate'], $_POST['homepage'],
            $_POST[$_TABLES['groups']],
            $_POST['delete_photo']);
    if (!empty($display)) {
        $tmp = COM_siteHeader('menu');
        $tmp .= $display;
        $tmp .= COM_siteFooter();
        $display = $tmp;
    }
} else if (($mode == $LANG28[17]) && !empty ($LANG28[17])) { // change password
    $display .= changepw (COM_applyFilter ($_POST['uid'], true),
                          $_POST['passwd']);
} else if ($mode == 'edit') {
    $display .= COM_siteHeader('menu', $LANG28[1]);
    $display .= edituser (COM_applyFilter ($_GET['uid']));
    $display .= COM_siteFooter();
} else if ($mode == 'import') {
    $display .= importusers ($_POST['file']);
} else if ($mode == 'importform') {
    $display .= COM_siteHeader('menu', $LANG28[24]);
    $display .= COM_startBlock ($LANG28[24], '',
                        COM_getBlockTemplate ('_admin_block', 'header'));
    $display .= $LANG28[25] . '<br><br>';
    $display .= display_form();
    $display .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
    $display .= COM_siteFooter();
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader ('menu', $LANG28[11]);
    if (isset ($_REQUEST['msg'])) {
        $display .= COM_showMessage (COM_applyFilter ($_REQUEST['msg'], true));
    }
    $offset = 0;
    if (isset ($_REQUEST['offset'])) {
        $offset = COM_applyFilter ($_REQUEST['offset'], true);
    }
    $page = 1;
    if (isset ($_REQUEST['page'])) {
        $page = COM_applyFilter ($_REQUEST['page'], true);
    }
    if ($page < 1) {
        $page = 1;
    }
    $display .= listusers ($offset, $page, $_REQUEST['q'],
                           COM_applyFilter ($_REQUEST['query_limit'], true));
    $display .= COM_siteFooter();
}

echo $display;

?>
