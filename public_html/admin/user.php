<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | user.php                                                                  |
// |                                                                           |
// | Geeklog user administration page.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
// $Id: user.php,v 1.167 2006/09/07 01:13:49 ospiess Exp $

// Set this to true to get various debug messages from this script
$_USER_VERBOSE = false;

require_once ('../lib-common.php');
require_once ('auth.inc.php');
require_once ($_CONF['path_system'] . 'lib-user.php');

$display = '';

// Make sure user has access to this page
if (!SEC_hasRights('user.edit')) {
    $retval .= COM_siteHeader ('menu', $MESSAGE[30]);
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
    global $_CONF, $_TABLES, $_USER, $LANG28, $LANG_ACCESS, $LANG_ADMIN,
           $MESSAGE;

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
        $A['status'] = USER_ACCOUNT_ACTIVE;
    }

    $retval .= COM_startBlock ($LANG28[1], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $user_templates = new Template($_CONF['path_layout'] . 'admin/user');
    $user_templates->set_file (array ('form' => 'edituser.thtml',
                                      'groupedit' => 'groupedit.thtml'));
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('lang_save', $LANG_ADMIN['save']);
    if (!empty($uid) && ($A['uid'] != $_USER['uid']) && SEC_hasRights('user.delete')) {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $user_templates->set_var ('delete_option',
                                  sprintf ($delbutton, $jsconfirm));
        $user_templates->set_var ('delete_option_no_confirmation',
                                  sprintf ($delbutton, ''));
    }
    $user_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);

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
    if (isset ($A['username'])) {
        $user_templates->set_var('username', $A['username']);
    } else {
        $user_templates->set_var('username', '');
    }

    if ($_CONF['allow_user_photo'] && ($A['uid'] > 0)) {
        $photo = USER_getPhoto ($A['uid'], $A['photo'], $A['email'], -1);
        $user_templates->set_var ('user_photo', $photo);
        if (empty ($A['photo'])) {
            $user_templates->set_var ('lang_delete_photo', '');
            $user_templates->set_var ('delete_photo_option', '');
        } else {
            $user_templates->set_var ('lang_delete_photo', $LANG28[28]);
            $user_templates->set_var ('delete_photo_option',
                    '<input type="checkbox" name="delete_photo">');
        }
    } else {
        $user_templates->set_var ('user_photo', '');
        $user_templates->set_var ('lang_delete_photo', '');
        $user_templates->set_var ('delete_photo_option', '');
    }

    $user_templates->set_var('lang_fullname', $LANG28[4]);
    if (isset ($A['fullname'])) {
        $user_templates->set_var ('user_fullname',
                                  htmlspecialchars ($A['fullname']));
    } else {
        $user_templates->set_var ('user_fullname', '');
    }
    $user_templates->set_var('lang_password', $LANG28[5]);
    $user_templates->set_var('lang_password_conf', $LANG28[39]);
    $user_templates->set_var('lang_emailaddress', $LANG28[7]);
    if (isset ($A['email'])) {
        $user_templates->set_var('user_email', htmlspecialchars($A['email']));
    } else {
        $user_templates->set_var('user_email', '');
    }
    $user_templates->set_var('lang_homepage', $LANG28[8]);
    if (isset ($A['homepage'])) {
        $user_templates->set_var ('user_homepage',
                                  htmlspecialchars ($A['homepage']));
    } else {
        $user_templates->set_var ('user_homepage', '');
    }
    $user_templates->set_var('do_not_use_spaces', '');

    $statusarray = array (USER_ACCOUNT_AWAITING_ACTIVATION => $LANG28[43],
                          USER_ACCOUNT_ACTIVE              => $LANG28[45]
                   );

    $allow_ban = true;

    if ($A['uid'] == $_USER['uid']) {
        $allow_ban = false; // do not allow to ban yourself
    } else if (SEC_inGroup('Root',$A['uid'])) { // is this user a root user?
        $count_root_sql = "SELECT COUNT(ug_uid) AS root_count FROM {$_TABLES['group_assignments']} "
                    . "WHERE ug_main_grp_id = 1 GROUP BY ug_uid;";
        $count_root_result = DB_query($count_root_sql);
        $C = DB_fetchArray($count_root_result); // how many are left?
        if ($C['root_count'] < 2) {
            $allow_ban = false; // prevent banning the last root user
        }
    }

    if ($allow_ban) {
        $statusarray[USER_ACCOUNT_DISABLED] = $LANG28[42];
    }

    if ($_CONF['usersubmission'] == 1) {
        $statusarray[USER_ACCOUNT_AWAITING_APPROVAL] = $LANG28[44];
    }
    asort($statusarray);
    $statusselect = '<select name="userstatus">';
    foreach ($statusarray as $key => $value) {
        $statusselect .= '<option value="' . $key . '"';
        if ($key == $A['status']) {
            $statusselect .= ' selected="selected"';
        }
        $statusselect .= '>' . $value . '</option>' . LB;
    }
    $statusselect .= '</select><input type="hidden" name="oldstatus" value="'
                  . $A['status'] . '">';
    $user_templates->set_var('user_status', $statusselect);
    $user_templates->set_var('lang_user_status', $LANG28[46]);

    if ($_CONF['custom_registration'] AND (function_exists('CUSTOM_userEdit'))) {
        if (!empty ($uid) && ($uid > 1)) {
            $user_templates->set_var('customfields', CUSTOM_userEdit($uid) );
        } else {
            $user_templates->set_var('customfields', CUSTOM_userEdit($A['uid']) );
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
        $remoteGroup = DB_getItem ($_TABLES['groups'], 'grp_id',
                                   "grp_name='Remote users'");
        if (!empty ($remoteGroup)) {
            $thisUsersGroups[] = $remoteGroup;
        }
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

function listusers()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG28, $_IMAGE_TYPE;

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

    $display = '';

    if ($_CONF['lastlogin']) {
        $login_text = $LANG28[41];
        $login_field = 'lastlogin';
    } else {
        $login_text = $LANG28[40];
        $login_field = 'regdate';
    }

    $header_arr = array(      # dislay 'text' and use table field 'field'
                    array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
                    array('text' => $LANG28[37], 'field' => $_TABLES['users'] . '.uid', 'sort' => true),
                    array('text' => $LANG28[3], 'field' => 'username', 'sort' => true),
                    array('text' => $LANG28[4], 'field' => 'fullname', 'sort' => true),
                    array('text' => $login_text, 'field' => $login_field, 'sort' => true)
    );

    $header_arr[] = array('text' => $LANG28[7], 'field' => 'email', 'sort' => true);

    $defsort_arr = array('field'     => $_TABLES['users'] . '.uid',
                         'direction' => 'ASC');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'] . '/user.php?mode=edit',
                          'text' => $LANG_ADMIN['create_new']),
                    array('url' => $_CONF['site_admin_url'] . '/user.php?mode=importform',
                          'text' => $LANG28[23]),
                    array('url' => $_CONF['site_admin_url'] . '/user.php?mode=batchdelete',
                          'text' => $LANG28[54]),
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home'])
    );

    $text_arr = array('has_menu'     => true,
                      'has_extras'   => true,
                      'title'        => $LANG28[11],
                      'instructions' => $LANG28[12],
                      'icon'         => $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE,
                      'form_url'     => $_CONF['site_admin_url'] . "/user.php",
                      'help_url'     => ''
    );

    if ($_CONF['lastlogin']) {
        $join_userinfo="LEFT JOIN {$_TABLES['userinfo']} ON {$_TABLES['users']}.uid={$_TABLES['userinfo']}.uid ";
        $select_userinfo=",lastlogin";
    }
    $sql = "SELECT {$_TABLES['users']}.uid,username,fullname,email,photo,status,regdate$select_userinfo "
         . "FROM {$_TABLES['users']} $join_userinfo WHERE 1=1";

    $query_arr = array('table' => 'users',
                       'sql' => $sql,
                       'query_fields' => array('username', 'email', 'fullname'),
                       'default_filter' => "AND {$_TABLES['users']}.uid > 1");

    $display .= ADMIN_list ("user", "ADMIN_getListField_users", $header_arr, $text_arr,
                            $query_arr, $menu_arr, $defsort_arr);
    return $display;
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
function saveusers ($uid, $username, $fullname, $passwd, $passwd_conf, $email, $regdate, $homepage, $groups, $delete_photo = '', $userstatus=3, $oldstatus=3)
{
    global $_CONF, $_TABLES, $_USER, $LANG28, $_USER_VERBOSE;

    $retval = '';
    $userChanged = false;

    if ($_USER_VERBOSE) COM_errorLog("**** entering saveusers****",1);
    if ($_USER_VERBOSE) COM_errorLog("group size at beginning = " . sizeof($groups),1);

    if ($passwd!=$passwd_conf) { // passwords dont match
        return edituser ($uid, 67);
    }

    if (!empty ($username) && !empty ($email)) {

        if (!COM_isEmail ($email)) {
            return edituser ($uid, 52);
        }

        $uname = addslashes ($username);
        if (empty ($uid)) {
            $ucount = DB_getItem ($_TABLES['users'], 'COUNT(*)',
                                  "username = '$uname'");
        } else {
            $uservice = DB_getItem ($_TABLES['users'], 'remoteservice', "uid = $uid");
            if ($uservice != '') {
                $uservice = addslashes($uservice);
                $ucount = DB_getItem ($_TABLES['users'], 'COUNT(*)',
                            "username = '$uname' AND uid <> $uid AND remoteservice = '$uservice'");
            } else {
                $ucount = DB_getItem ($_TABLES['users'], 'COUNT(*)',
                                  "username = '$uname' AND uid <> $uid AND (remoteservice = '' OR remoteservice is null)");
            }
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
            if (($uid > 1) && ($_CONF['usersubmission'] == 1)) {
                // we don't want to queue new users created by a User Admin
                DB_query ("UPDATE {$_TABLES['users']} SET status = " . USER_ACCOUNT_AWAITING_ACTIVATION . " WHERE uid = $uid");
            }
        } else {
            $fullname = addslashes ($fullname);
            $homepage = addslashes ($homepage);
            $curphoto = DB_getItem($_TABLES['users'],'photo',"uid = $uid");
            if (!empty ($curphoto) && ($delete_photo == 'on')) {
                USER_deletePhoto ($curphoto);
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
                        $display = COM_siteHeader ('menu', $LANG28[22]);
                        $display .= COM_errorLog ('Could not rename userphoto "'
                                        . $curphoto . '" to "' . $newphoto . '".');
                        $display .= COM_siteFooter ();
                        return $display;
                    }
                    $curphoto = $newphoto;
                }
            }

            $curphoto = addslashes ($curphoto);
            DB_query("UPDATE {$_TABLES['users']} SET username = '$username', fullname = '$fullname', passwd = '$passwd', email = '$email', homepage = '$homepage', photo = '$curphoto', status='$userstatus' WHERE uid = $uid");
            if ($_CONF['custom_registration'] AND (function_exists('CUSTOM_userSave'))) {
                CUSTOM_userSave($uid);
            }
            if( ($_CONF['usersubmission'] == 1) && ($oldstatus == USER_ACCOUNT_AWAITING_APPROVAL)
                   && ($userstatus == USER_ACCOUNT_ACTIVE) )
            {
                //USER_sendActivationEmail($username, $email);
                USER_createAndSendPassword ($username, $email, $uid);
            }
            $userChanged = true;
        }

        // if groups is -1 then this user isn't allowed to change any groups so ignore
        if (is_array ($groups) && SEC_inGroup ('Group Admin')) {
            if (!SEC_inGroup ('Root')) {
                $rootgrp = DB_getItem ($_TABLES['groups'], 'grp_id',
                                       "grp_name = 'Root'");
                if (in_array ($rootgrp, $groups)) {
                    COM_accessLog ("User {$_USER['username']} ({$_USER['uid']}) just tried to give Root permissions to user $username.");
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

        if ($userChanged)
        {
            PLG_userInfoChanged ($uid);
        }
        $errors = DB_error();
        if (empty($errors)) {
            echo COM_refresh($_CONF['site_admin_url'] . '/user.php?msg=21');
        } else {
            $retval .= COM_siteHeader ('menu', $LANG28[22]);
            $retval .= COM_errorLog ('Error in saveusers in '
                                     . $_CONF['site_admin_url'] . '/user.php');
            $retval .= COM_siteFooter ();
            echo $retval;
            exit;
        }
    } else {
        $retval = COM_siteHeader('menu', $LANG28[1]);
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
* This function allows the batch deletion of users that are inactive
* It shows the form that will filter user that will be deleted
*
* @return   string          HTML Form
*/
function batchdelete()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG28, $_IMAGE_TYPE;

    $display = '';
    if (!$_CONF['lastlogin']) {
        $retval = "<br>". $_LANG28[55];
        return $retval;
    }

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

    $usr_type = '';
    if (isset($_REQUEST['usr_type'])) {
        $usr_type = COM_applyFilter($_REQUEST['usr_type']);
    } else {
        $usr_type = 'phantom';
    }
    $usr_time_arr = array();
    $usr_time = '';
    if (isset($_REQUEST['usr_time'])) {
        $usr_time_arr = $_REQUEST['usr_time'];
    } else {
        $usr_time_arr['phantom'] = 2;
        $usr_time_arr['short'] = 6;
        $usr_time_arr['old'] = 24;
    }
    $usr_time = $usr_time_arr[$usr_type];

    $sel_phantom="";
    $sel_short="";
    $sel_old="";

    $selector = "sel_$usr_type";
    $$selector = ' checked="checked"';
    $desc = $LANG28[56] . LB
          . '<p><input type="radio" name="usr_type" value="phantom"'.$sel_phantom.'><strong>'
          . $LANG28[57] .':</strong> ' . $LANG28[60]
          . '<input style="text-align:center" type="text" name="usr_time[phantom]" value="'.$usr_time_arr['phantom']
          . '" size="3">' . $LANG28[61] . '<br>' . LB
          . '<input type="radio" name="usr_type" value="short"'.$sel_short.'><strong>'
          . $LANG28[58] .':</strong> ' . $LANG28[62]
          . '<input style="text-align:center" type="text" name="usr_time[short]" value="'.$usr_time_arr['short']
          . '" size="3">' . $LANG28[63] . '<br>'  . LB
          . '<input type="radio" name="usr_type" value="old"'.$sel_old.'><strong>'
          . $LANG28[59] .':</strong> ' . $LANG28[64]
          . '<input style="text-align:center" type="text" name="usr_time[old]" value="'.$usr_time_arr['old']
          . '" size="3">' . $LANG28[65] . '</p>' . LB
          . '&nbsp;<input type="submit" name="submit" value="' . $LANG28[66] . '"></form><p>';

    if ($usr_type == 'phantom') {
        $desc .= $LANG28[60] . $usr_time . $LANG28[61];
    } else if ($usr_type == 'short') {
        $desc .= $LANG28[62] . $usr_time . $LANG28[63];
    } else if ($usr_type == 'old') {
        $desc .= $LANG28[64] . $usr_time . $LANG28[65];
    }

    $display .= '<form style="display:inline" action="' . $_CONF['site_admin_url']. '/user.php?mode=batchdelete" method="post" >' . LB
            . '<input type="hidden" name="mode" value="batchdelete">' . LB
            . '<input type="hidden" name="usr_type" value="'.$usr_type.'">' . LB
            . '<input type="hidden" name="usr_time['.$usr_type.']" value="'.$usr_time.'">' . LB;

    $header_arr = array(      # dislay 'text' and use table field 'field'
                    array('text' => "<input type=\"submit\" name=\"submit\" value=\"{$LANG_ADMIN['delete']}\" onclick=\"return confirm('{$LANG28[73]}');\">",
                          'field' => 'delete', 'sort' => false),
                    array('text' => $LANG28[37], 'field' => $_TABLES['users'] . '.uid', 'sort' => true),
                    array('text' => $LANG28[3], 'field' => 'username', 'sort' => true),
                    array('text' => $LANG28[4], 'field' => 'fullname', 'sort' => true)
    );
    if ($usr_type == 'phantom') {
        $header_arr[] = array('text' => $LANG28[14], 'field' => 'regdate', 'sort' => true);
        $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin', 'sort' => true);
        $header_arr[] = array('text' => $LANG28[67], 'field' => 'phantom_date', 'sort' => true);
    }

    if ($usr_type == 'short') {
        $header_arr[] = array('text' => $LANG28[14], 'field' => 'regdate', 'sort' => true);
        $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin', 'sort' => true);
        $header_arr[] = array('text' => $LANG28[68], 'field' => 'online_hours', 'sort' => true);
        $header_arr[] = array('text' => $LANG28[69], 'field' => 'offline_months', 'sort' => true);
    }

    if ($usr_type == 'old') {
        $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin', 'sort' => true);
        $header_arr[] = array('text' => $LANG28[69], 'field' => 'offline_months', 'sort' => true);
    }

    $header_arr[] = array('text' => $LANG28[7], 'field' => 'email', 'sort' => true);

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'] . '/user.php',
                          'text' => $LANG28[11]),
                    array('url' => $_CONF['site_admin_url'] . '/user.php?mode=importform',
                          'text' => $LANG28[23]),
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home'])
    );

    $text_arr = array('has_menu'     => true,
                      'has_extras'   => true,
                      'title'        => $LANG28[54],
                      'instructions' => "<p>$desc</p>",
                      'icon'         => $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE,
                      'form_url'     => $_CONF['site_admin_url'] . "/user.php?mode=batchdelete&amp;usr_type=$usr_type&amp;usr_time=$usr_time",
                      'help_url'     => ''
    );

    if ($usr_type == 'phantom') {
        // MySQL 3
        $list_sql = ", UNIX_TIMESTAMP()- UNIX_TIMESTAMP(regdate) as phantom_date";
        // MySQL 4
        // $list_sql = ", DATEDIFF(NOW(), regdate) AS phantom_date";
        // MySQL 3
        $filter_sql = "lastlogin = 0 AND UNIX_TIMESTAMP()- UNIX_TIMESTAMP(regdate) > " . ($usr_time * 2592000) . " AND";
        // MySQL 4
        // $filter_sql = "lastlogin = 0 AND DATEDIFF(NOW(), regdate) > " . ($usr_time * 30) . " AND";
        $sort = 'regdate';
    }

    if ($usr_type == 'short') {
        // MySQL 3
        $list_sql = ", (lastlogin - UNIX_TIMESTAMP(regdate)) AS online_hours, (UNIX_TIMESTAMP() - lastlogin) AS offline_months";
        // MySQL 4
        // $list_sql = ", TIMEDIFF(FROM_UNIXTIME(lastlogin), regdate) AS online_time, DATEDIFF(NOW(), FROM_UNIXTIME(lastlogin)) AS offline_months";
        // MySQL 3
        $filter_sql = "lastlogin > 0 AND lastlogin - UNIX_TIMESTAMP(regdate) < 86400 "
                     . "AND UNIX_TIMESTAMP() - lastlogin > " . ($usr_time * 2592000) . " AND";
        // MySQL 4
        // $filter_sql = "lastlogin > 0 AND TIMEDIFF(FROM_UNIXTIME(lastlogin), regdate) < 24 "
        //            . "AND DATEDIFF(NOW(), FROM_UNIXTIME(lastlogin)) > " . ($usr_time * 30) . " AND";
        $sort = 'lastlogin';
    }

    if ($usr_type == 'old') {
        // MySQL 3
        $list_sql = ", (UNIX_TIMESTAMP() - lastlogin) AS offline_months";
        // MySQL 4
        // $list_sql = ", DATEDIFF(NOW(), FROM_UNIXTIME(lastlogin)) AS offline_months";
        // MySQL 3
        $filter_sql = "lastlogin > 0 AND (UNIX_TIMESTAMP() - lastlogin) > " . ($usr_time * 2592000) . " AND";
        // MySQL 4
        // $filter_sql = "lastlogin > 0 AND DATEDIFF(NOW(), FROM_UNIXTIME(lastlogin)) > " . ($usr_time * 30) . " AND";
        $sort = 'lastlogin';
    }

    $defsort_arr = array('field'     => $sort,
                         'direction' => 'ASC');

    $join_userinfo = "LEFT JOIN {$_TABLES['userinfo']} ON {$_TABLES['users']}.uid={$_TABLES['userinfo']}.uid ";
    $select_userinfo = ", lastlogin $list_sql "
                     . ", datediff(CURDATE(), FROM_UNIXTIME(lastlogin)) AS notloggedinsince";

    $sql = "SELECT {$_TABLES['users']}.uid,username,fullname,email,photo,status,regdate$select_userinfo "
         . "FROM {$_TABLES['users']} $join_userinfo WHERE 1=1";

    $query_arr = array('table' => 'users',
                       'sql' => $sql,
                       'query_fields' => array('username', 'email', 'fullname'),
                       'default_filter' => "AND $filter_sql {$_TABLES['users']}.uid > 1");

    $display .= ADMIN_list ("user", "ADMIN_getListField_batchuserdelete", $header_arr, $text_arr,
                            $query_arr, $menu_arr, $defsort_arr);
    $display .= '</form>';


    return $display;
}
/**
* This function deletes the users selected in the batchdeletelist function
*
* @return   string          HTML with success or error message
*
*/
function batchdeleteexec() {
    global $_CONF, $LANG28;

    $msg = '';
    $user_list = array();
    if (isset($_POST['del_uid'])) {
        $user_list = $_POST['del_uid'];
    }

    if (count($user_list) == 0) {
        $msg = $LANG28[72];
    }

    for ($i<0; $i<count($user_list); $i++) {
        if (current($user_list) =='on') {
            $uid = key($user_list);
            if (!USER_deleteAccount (key($user_list))) {
                $msg .= "<strong>{$LANG28[2]} $uid {$LANG28[70]}</strong><br>\n";
            } else {
                $msg .= "{$LANG28[2]} $uid {$LANG28[71]}<br>\n";
            }
        }
        next($user_list);
    }
    return $msg;
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

    // Bulk import implies admin authorisation:
    $_CONF['usersubmission'] = 0;

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

                USER_createAndSendPassword ($userName, $emailAddr, $uid);

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

if (isset ($_REQUEST['order'])) {
    $order =  COM_applyFilter ($_REQUEST['order'],true);
}

if (isset ($_GET['direction'])) {
    $direction =  COM_applyFilter ($_GET['direction']);
}

if (isset ($_POST['passwd']) && isset ($_POST['passwd_conf']) &&
        ($_POST['passwd'] != $_POST['passwd_conf'])) {
    // entered passwords were different
    $uid = COM_applyFilter ($_POST['uid'], true);
    if ($uid > 1) {
        $display .= COM_refresh ($_CONF['site_admin_url']
                                 . '/user.php?mode=edit&msg=67&uid=' . $uid);
    } else {
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/user.php?msg=67');
    }
} else if (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) { // delete
    $uid = COM_applyFilter ($_POST['uid'], true);
    if ($uid > 1) {
        $display .= deleteUser ($uid);
    } else {
        COM_errorLog ('Attempted to delete user uid=' . $uid);
        $display = COM_refresh ($_CONF['site_admin_url'] . '/user.php');
    }
} else if (($mode == $LANG_ADMIN['save']) && !empty ($LANG_ADMIN['save'])) { // save
    $delphoto = '';
    if (isset ($_POST['delete_photo'])) {
        $delphoto = $_POST['delete_photo'];
    }
    if (!isset ($_POST['oldstatus'])) {
        $_POST['oldstatus'] = USER_ACCOUNT_ACTIVE;
    }
    if (!isset ($_POST['userstatus'])) {
        $_POST['userstatus'] = USER_ACCOUNT_ACTIVE;
    }
    $display = saveusers (COM_applyFilter ($_POST['uid'], true),
            $_POST['username'], $_POST['fullname'],
            $_POST['passwd'], $_POST['passwd_conf'], $_POST['email'],
            $_POST['regdate'], $_POST['homepage'],
            $_POST[$_TABLES['groups']],
            $delphoto, $_POST['userstatus'], $_POST['oldstatus']);
    if (!empty($display)) {
        $tmp = COM_siteHeader('menu', $LANG28[22]);
        $tmp .= $display;
        $tmp .= COM_siteFooter();
        $display = $tmp;
    }
} else if ($mode == 'edit') {
    $display .= COM_siteHeader('menu', $LANG28[1]);
    $msg = '';
    if (isset ($_GET['msg'])) {
        $msg = COM_applyFilter ($_GET['msg'], true);
    }
    $uid = '';
    if (isset ($_GET['uid'])) {
        $uid = COM_applyFilter ($_GET['uid'], true);
    }
    $display .= edituser ($uid, $msg);
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
} else if ($mode == 'batchdelete') {
    if (isset ($_POST['submit']) && ($_POST['submit'] == $LANG_ADMIN['delete'])) {
        $msg = batchdeleteexec();
        $display .= COM_siteHeader ('menu', $LANG28[11]);
        $timestamp = strftime( $_CONF['daytime'] );
        $display .= COM_startBlock( $MESSAGE[40] . ' - ' . $timestamp, '',
                               COM_getBlockTemplate( '_msg_block', 'header' ))
                . '<p style="padding:5px"><img src="' . $_CONF['layout_url']
                . '/images/sysmessage.' . $_IMAGE_TYPE . '" border="0" align="left"'
                . ' alt="" style="padding-right:5px; padding-bottom:3px">'
                . $msg . '</p>'
                . COM_endBlock( COM_getBlockTemplate( '_msg_block', 'footer' ));
    } else {
        $display .= COM_siteHeader ('menu', $LANG28[54]);

    }
    $display .= batchdelete();
    $display .= COM_siteFooter();
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader ('menu', $LANG28[11]);
    if (isset ($_REQUEST['msg'])) {
        $display .= COM_showMessage (COM_applyFilter ($_REQUEST['msg'], true));
    }
    $display .= listusers();
    $display .= COM_siteFooter();
}

echo $display;

?>
