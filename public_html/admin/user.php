<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | user.php                                                                  |
// |                                                                           |
// | Geeklog user administration page.                                         |
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

/**
* User administration: Manage users (create, delete, import) and their
* group membership.
*
*/

/**
* Geeklog common function library
*/
require_once '../lib-common.php';

/**
* Security check to ensure user even belongs on this page
*/

require_once 'auth.inc.php';

/**
* User-related functions
*/
require_once $_CONF['path_system'] . 'lib-user.php';

// Set this to true to get various debug messages from this script
$_USER_VERBOSE = false;

$display = '';

// Make sure user has access to this page
if (!SEC_hasRights('user.edit')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the user administration screen.");
    COM_output($display);
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

    require_once $_CONF['path_system'] . 'lib-admin.php';

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
    $user_templates->set_var( 'xhtml', XHTML );
    $user_templates->set_var('site_url', $_CONF['site_url']);
    $user_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('lang_save', $LANG_ADMIN['save']);
    if (!empty($uid) && ($A['uid'] != $_USER['uid']) && SEC_hasRights('user.delete')) {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s' . XHTML . '>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $user_templates->set_var ('delete_option',
                                  sprintf ($delbutton, $jsconfirm));
        $user_templates->set_var ('delete_option_no_confirmation',
                                  sprintf ($delbutton, ''));
    }
    $user_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);

    $user_templates->set_var('lang_userid', $LANG28[2]);
    if (empty ($A['uid'])) {
        $user_templates->set_var ('user_id', $LANG_ADMIN['na']);
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

    $remoteservice = '';
    if ($_CONF['show_servicename'] && ($_CONF['user_login_method']['3rdparty']
            || $_CONF['user_login_method']['openid'])) {
        if (! empty($A['remoteservice'])) {
            $remoteservice = '@' . $A['remoteservice'];
        }
    }
    $user_templates->set_var('remoteservice', $remoteservice);

    if ($_CONF['allow_user_photo'] && ($A['uid'] > 0)) {
        $photo = USER_getPhoto ($A['uid'], $A['photo'], $A['email'], -1);
        $user_templates->set_var ('user_photo', $photo);
        if (empty ($A['photo'])) {
            $user_templates->set_var ('lang_delete_photo', '');
            $user_templates->set_var ('delete_photo_option', '');
        } else {
            $user_templates->set_var ('lang_delete_photo', $LANG28[28]);
            $user_templates->set_var ('delete_photo_option',
                    '<input type="checkbox" name="delete_photo"' . XHTML . '>');
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

    $statusarray = array(USER_ACCOUNT_AWAITING_ACTIVATION => $LANG28[43],
                         USER_ACCOUNT_ACTIVE              => $LANG28[45]
                   );

    $allow_ban = true;

    if (!empty($uid)) {
        if ($A['uid'] == $_USER['uid']) {
            $allow_ban = false; // do not allow to ban yourself
        } else if (SEC_inGroup('Root', $A['uid'])) { // editing a Root user?
            $count_root_sql = "SELECT COUNT(ug_uid) AS root_count FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 1 GROUP BY ug_uid;";
            $count_root_result = DB_query($count_root_sql);
            $C = DB_fetchArray($count_root_result); // how many are left?
            if ($C['root_count'] < 2) {
                $allow_ban = false; // prevent banning the last root user
            }
        }
    }

    if ($allow_ban) {
        $statusarray[USER_ACCOUNT_DISABLED] = $LANG28[42];
    }

    if (($_CONF['usersubmission'] == 1) && !empty($uid)) {
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
                  . $A['status'] . '"' . XHTML . '>';
    $user_templates->set_var('user_status', $statusselect);
    $user_templates->set_var('lang_user_status', $LANG28[46]);

    if ($_CONF['custom_registration'] AND function_exists('CUSTOM_userEdit')) {
        if (!empty($uid) && ($uid > 1)) {
            $user_templates->set_var('customfields', CUSTOM_userEdit($uid));
        } else {
            $user_templates->set_var('customfields', CUSTOM_userEdit($A['uid']));
        }
    }

    if (SEC_hasRights('group.assign')) {
        $user_templates->set_var('lang_securitygroups',
                                 $LANG_ACCESS['securitygroups']);
        $user_templates->set_var('lang_groupinstructions',
                                 $LANG_ACCESS['securitygroupsmsg']);

        if (! empty($uid)) {
            $usergroups = SEC_getUserGroups($uid);
            if (is_array($usergroups) && !empty($uid)) {
                $selected = implode(' ', $usergroups);
            } else {
                $selected = '';
            }
        } else {
            $selected = DB_getItem($_TABLES['groups'], 'grp_id',
                                   "grp_name = 'All Users'")
                      . ' ';
            $selected .= DB_getItem($_TABLES['groups'], 'grp_id',
                                    "grp_name = 'Logged-in Users'");
        }
        $thisUsersGroups = SEC_getUserGroups();
        $remoteGroup = DB_getItem($_TABLES['groups'], 'grp_id',
                                  "grp_name = 'Remote Users'");
        if (! empty($remoteGroup)) {
            $thisUsersGroups[] = $remoteGroup;
        }
        $whereGroups = 'grp_id IN (' . implode (',', $thisUsersGroups) . ')';

        $header_arr = array(
                        array('text' => $LANG28[86], 'field' => 'checkbox', 'sort' => false),
                        array('text' => $LANG_ACCESS['groupname'], 'field' => 'grp_name', 'sort' => true),
                        array('text' => $LANG_ACCESS['description'], 'field' => 'grp_descr', 'sort' => true)
        );
        $defsort_arr = array('field' => 'grp_name', 'direction' => 'asc');

        $form_url = $_CONF['site_admin_url']
                  . '/user.php?mode=edit&amp;uid=' . $uid;
        $text_arr = array('has_menu' => false,
                          'title' => '', 'instructions' => '',
                          'icon' => '', 'form_url' => $form_url,
                          'inline' => true
        );

        $sql = "SELECT grp_id, grp_name, grp_descr FROM {$_TABLES['groups']} WHERE " . $whereGroups;
        $query_arr = array('table' => 'groups',
                           'sql' => $sql,
                           'query_fields' => array('grp_name'),
                           'default_filter' => '',
                           'query' => '',
                           'query_limit' => 0
        );

        $groupoptions = ADMIN_list('usergroups',
                                   'ADMIN_getListField_usergroups',
                                   $header_arr, $text_arr, $query_arr,
                                   $defsort_arr, '', explode(' ', $selected));

        $user_templates->set_var('group_options', $groupoptions);
        $user_templates->parse('group_edit', 'groupedit', true);
    } else {
        // user doesn't have the rights to edit a user's groups so set to -1
        // so we know not to handle the groups array when we save
        $user_templates->set_var('group_edit',
                '<input type="hidden" name="groups" value="-1"' . XHTML . '>');
    }
    $user_templates->set_var('gltoken_name', CSRF_TOKEN);
    $user_templates->set_var('gltoken', SEC_createToken());
    $user_templates->parse('output', 'form');
    $retval .= $user_templates->finish($user_templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

function listusers()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG04, $LANG28, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    if ($_CONF['lastlogin']) {
        $login_text = $LANG28[41];
        $login_field = 'lastlogin';
    } else {
        $login_text = $LANG28[40];
        $login_field = 'regdate';
    }

    $header_arr = array(      # display 'text' and use table field 'field'
                    array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
                    array('text' => $LANG28[37], 'field' => $_TABLES['users'] . '.uid', 'sort' => true),
                    array('text' => $LANG28[3], 'field' => 'username', 'sort' => true),
                    array('text' => $LANG28[4], 'field' => 'fullname', 'sort' => true),
                    array('text' => $login_text, 'field' => $login_field, 'sort' => true),
                    array('text' => $LANG28[7], 'field' => 'email', 'sort' => true)
    );

    if ($_CONF['user_login_method']['openid'] ||
        $_CONF['user_login_method']['3rdparty']) {
        $header_arr[] = array('text' => $LANG04[121], 'field' => 'remoteservice', 'sort' => true);
    }

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

    $retval .= COM_startBlock($LANG28[11], '',
                              COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG28[12],
        $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE
    );

    $text_arr = array(
        'has_extras' => true,
        'form_url'   => $_CONF['site_admin_url'] . '/user.php',
        'help_url'   => ''
    );

    $join_userinfo   = '';
    $select_userinfo = '';
    if ($_CONF['lastlogin']) {
        $join_userinfo .= "LEFT JOIN {$_TABLES['userinfo']} ON {$_TABLES['users']}.uid={$_TABLES['userinfo']}.uid ";
        $select_userinfo .= ",lastlogin";
    }
    if ($_CONF['user_login_method']['openid'] ||
        $_CONF['user_login_method']['3rdparty']) {
        $select_userinfo .= ',remoteservice';
    }
    $sql = "SELECT {$_TABLES['users']}.uid,username,fullname,email,photo,status,regdate$select_userinfo "
         . "FROM {$_TABLES['users']} $join_userinfo WHERE 1=1";

    $query_arr = array('table' => 'users',
                       'sql' => $sql,
                       'query_fields' => array('username', 'email', 'fullname'),
                       'default_filter' => "AND {$_TABLES['users']}.uid > 1");

    $retval .= ADMIN_list('user', 'ADMIN_getListField_users', $header_arr,
                          $text_arr, $query_arr, $defsort_arr);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

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
function saveusers ($uid, $username, $fullname, $passwd, $passwd_conf, $email, $regdate, $homepage, $groups, $delete_photo = '', $userstatus=3, $oldstatus=3)
{
    global $_CONF, $_TABLES, $_USER, $LANG28, $_USER_VERBOSE;

    $retval = '';
    $userChanged = false;

    if ($_USER_VERBOSE) COM_errorLog("**** entering saveusers****",1);
    if ($_USER_VERBOSE) COM_errorLog("group size at beginning = " . count($groups),1);

    if ($passwd != $passwd_conf) { // passwords don't match
        return edituser($uid, 67);
    }

    $nameAndEmailOkay = true;
    if (empty($username)) {
        $nameAndEmailOkay = false;
    } elseif (empty($email)) {
        if (empty($uid)) {
            $nameAndEmailOkay = false; // new users need an email address
        } else {
            $service = DB_getItem($_TABLES['users'], 'remoteservice',
                                  "uid = $uid");
            if (empty($service)) {
                $nameAndEmailOkay = false; // not a remote user - needs email
            }
        }
    }

    if ($nameAndEmailOkay) {

        if (!empty($email) && !COM_isEmail($email)) {
            return edituser($uid, 52);
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
                                  "username = '$uname' AND uid <> $uid AND (remoteservice = '' OR remoteservice IS NULL)");
            }
        }
        if ($ucount > 0) {
            // Admin just changed a user's username to one that already exists
            return edituser ($uid, 51);
        }

        $emailaddr = addslashes($email);
        $exclude_remote = " AND (remoteservice IS NULL OR remoteservice = '')";
        if (empty($uid)) {
            $ucount = DB_getItem($_TABLES['users'], 'COUNT(*)',
                                 "email = '$emailaddr'" . $exclude_remote);
        } else {
            $old_email = DB_getItem($_TABLES['users'], 'email', "uid = '$uid'");
            if ($old_email == $email) {
                // email address didn't change so don't care
                $ucount = 0;
            } else {
                $ucount = DB_getItem($_TABLES['users'], 'COUNT(*)',
                                     "email = '$emailaddr' AND uid <> $uid"
                                     . $exclude_remote);
            }
        }
        if ($ucount > 0) {
            // Admin just changed a user's email to one that already exists
            return edituser($uid, 56);
        }

        if ($_CONF['custom_registration'] &&
                function_exists('CUSTOM_userCheck')) {
            $ret = CUSTOM_userCheck($username, $email);
            if (! empty($ret)) {
                // need a numeric return value - otherwise use default message
                if (! is_numeric($ret['number'])) {
                    $ret['number'] = 400;
                }
                return edituser($uid, $ret['number']);
            }
        }

        if (empty ($uid) || !empty ($passwd)) {
            $passwd = SEC_encryptPassword($passwd);
        } else {
            $passwd = DB_getItem ($_TABLES['users'], 'passwd', "uid = $uid");
        }

        if (empty ($uid)) {
            if (empty ($passwd)) {
                // no password? create one ...
                $passwd = rand ();
                $passwd = md5 ($passwd);
                $passwd = substr ($passwd, 1, 8);
                $passwd = SEC_encryptPassword($passwd);
            }

            $uid = USER_createAccount ($username, $email, $passwd, $fullname,
                                       $homepage);
            if ($uid > 1) {
                DB_query("UPDATE {$_TABLES['users']} SET status = $userstatus WHERE uid = $uid");
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
                   && ($userstatus == USER_ACCOUNT_ACTIVE) ) {
                USER_createAndSendPassword ($username, $email, $uid);
            }
            if ($userstatus == USER_ACCOUNT_DISABLED) {
                SESS_endUserSession($uid);
            }
            $userChanged = true;
        }

        // check that the user is allowed to change group assignments
        if (is_array($groups) && SEC_hasRights('group.assign')) {
            if (! SEC_inGroup('Root')) {
                $rootgrp = DB_getItem($_TABLES['groups'], 'grp_id',
                                      "grp_name = 'Root'");
                if (in_array($rootgrp, $groups)) {
                    COM_accessLog("User {$_USER['username']} ({$_USER['uid']}) just tried to give Root permissions to user $username.");
                    echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
                    exit;
                }
            }

            // make sure the Remote Users group is in $groups
            if (SEC_inGroup('Remote Users', $uid)) {
                $remUsers = DB_getItem($_TABLES['groups'], 'grp_id',
                                       "grp_name = 'Remote Users'");
                if (! in_array($remUsers, $groups)) {
                    $groups[] = $remUsers;
                }
            }

            if ($_USER_VERBOSE) {
                COM_errorLog("deleting all group_assignments for user $uid/$username",1);
            }

            // remove user from all groups that the User Admin is a member of
            $UserAdminGroups = SEC_getUserGroups();
            $whereGroup = 'ug_main_grp_id IN ('
                        . implode (',', $UserAdminGroups) . ')';
            DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_uid = $uid) AND " . $whereGroup);

            // make sure to add user to All Users and Logged-in Users groups
            $allUsers = DB_getItem($_TABLES['groups'], 'grp_id',
                                   "grp_name = 'All Users'");
            if (! in_array($allUsers, $groups)) {
                $groups[] = $allUsers;
            }
            $logUsers = DB_getItem($_TABLES['groups'], 'grp_id',
                                   "grp_name = 'Logged-in Users'");
            if (! in_array($logUsers, $groups)) {
                $groups[] = $logUsers;
            }

            foreach ($groups as $userGroup) {
                if (in_array($userGroup, $UserAdminGroups)) {
                    if ($_USER_VERBOSE) {
                        COM_errorLog("adding group_assignment " . $userGroup
                                     . " for $username", 1);
                    }
                    $sql = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($userGroup, $uid)";
                    DB_query($sql);
                }
            }
        }

        if ($userChanged) {
            PLG_userInfoChanged ($uid);
        }

        $errors = DB_error();
        if (empty($errors)) {
            echo PLG_afterSaveSwitch (
                $_CONF['aftersave_user'],
                "{$_CONF['site_url']}/users.php?mode=profile&uid=$uid",
                'user',
                21
            );
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
        $retval .= COM_showMessageText($LANG28[10]);
        if (DB_count($_TABLES['users'], 'uid', $uid) > 0) {
            $retval .= edituser($uid);
        } else {
            $retval .= edituser();
        }
        $retval .= COM_siteFooter();
        COM_output($retval);
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
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG01, $LANG28, $_IMAGE_TYPE;

    $retval = '';

    if (! $_CONF['lastlogin']) {
        $retval .= '<p>'. $_LANG28[55] . '</p>';
        return $retval;
    }

    require_once $_CONF['path_system'] . 'lib-admin.php';

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
        // default values, in months
        $usr_time_arr['phantom'] =  2;
        $usr_time_arr['short']   =  6;
        $usr_time_arr['old']     = 24;
        $usr_time_arr['recent']  =  1;
    }
    $usr_time = $usr_time_arr[$usr_type];

    // list of options for user display
    // sel => form-id
    // desc => title
    // txt1 => text before input-field
    // txt2 => text after input field
    $opt_arr = array(
        array('sel' => 'phantom', 'desc' => $LANG28[57], 'txt1' => $LANG28[60], 'txt2' => $LANG28[61]),
        array('sel' => 'short', 'desc' => $LANG28[58], 'txt1' => $LANG28[62], 'txt2' => $LANG28[63]),
        array('sel' => 'old', 'desc' => $LANG28[59], 'txt1' => $LANG28[64], 'txt2' => $LANG28[65]),
        array('sel' => 'recent', 'desc' => $LANG28[74], 'txt1' => $LANG28[75], 'txt2' => $LANG28[76])
    );

    $user_templates = new Template($_CONF['path_layout'] . 'admin/user');
    $user_templates->set_file (array ('form' => 'batchdelete.thtml',
                                      'options' => 'batchdelete_options.thtml',
                                      'reminder' => 'reminder.thtml'));
    $user_templates->set_var ( 'xhtml', XHTML );
    $user_templates->set_var ('site_url', $_CONF['site_url']);
    $user_templates->set_var ('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var ('layout_url', $_CONF['layout_url']);
    $user_templates->set_var ('usr_type', $usr_type);
    $user_templates->set_var ('usr_time', $usr_time);
    $user_templates->set_var ('lang_instruction', $LANG28[56]);
    $user_templates->set_var ('lang_updatelist', $LANG28[66]);

    $num_opts = count($opt_arr);
    for ($i = 0; $i < $num_opts; $i++) {
        $selector = '';
        if ($usr_type == $opt_arr[$i]['sel']) {
            $selector = ' checked="checked"';
        }
        $user_templates->set_var ('sel_id', $opt_arr[$i]['sel']);
        $user_templates->set_var ('selector', $selector);
        $user_templates->set_var ('lang_description', $opt_arr[$i]['desc']);
        $user_templates->set_var ('lang_text_start', $opt_arr[$i]['txt1']);
        $user_templates->set_var ('lang_text_end', $opt_arr[$i]['txt2']);
        $user_templates->set_var ('id_value', $usr_time_arr[$opt_arr[$i]['sel']]);
        $user_templates->parse('options_list', 'options', true);
    }
    $user_templates->parse('form', 'form');
    $desc = $user_templates->finish($user_templates->get_var('form'));

    $header_arr = array(      # display 'text' and use table field 'field'
                    array('text' => $LANG28[37], 'field' => $_TABLES['users'] . '.uid', 'sort' => true),
                    array('text' => $LANG28[3], 'field' => 'username', 'sort' => true),
                    array('text' => $LANG28[4], 'field' => 'fullname', 'sort' => true)
    );

    switch ($usr_type) {
        case 'phantom':
            $header_arr[] = array('text' => $LANG28[14], 'field' => 'regdate', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin_short', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[67], 'field' => 'phantom_date', 'sort' => true);
            $list_sql = ", UNIX_TIMESTAMP()- UNIX_TIMESTAMP(regdate) as phantom_date";
            $filter_sql = "lastlogin = 0 AND UNIX_TIMESTAMP()- UNIX_TIMESTAMP(regdate) > " . ($usr_time * 2592000) . " AND";
            $sort = 'regdate';
            break;
        case 'short':
            $header_arr[] = array('text' => $LANG28[14], 'field' => 'regdate', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin_short', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[68], 'field' => 'online_hours', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[69], 'field' => 'offline_months', 'sort' => true);
            $list_sql = ", (lastlogin - UNIX_TIMESTAMP(regdate)) AS online_hours, (UNIX_TIMESTAMP() - lastlogin) AS offline_months";
            $filter_sql = "lastlogin > 0 AND lastlogin - UNIX_TIMESTAMP(regdate) < 86400 "
                         . "AND UNIX_TIMESTAMP() - lastlogin > " . ($usr_time * 2592000) . " AND";
            $sort = 'lastlogin';
            break;
        case 'old':
            $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin_short', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[69], 'field' => 'offline_months', 'sort' => true);
            $list_sql = ", (UNIX_TIMESTAMP() - lastlogin) AS offline_months";
            $filter_sql = "lastlogin > 0 AND (UNIX_TIMESTAMP() - lastlogin) > " . ($usr_time * 2592000) . " AND";
            $sort = 'lastlogin';
            break;
        case 'recent':
            $header_arr[] = array('text' => $LANG28[14], 'field' => 'regdate', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin_short', 'sort' => true);
            $list_sql = "";
            $filter_sql = "(UNIX_TIMESTAMP() - UNIX_TIMESTAMP(regdate)) < " . ($usr_time * 2592000) . " AND";
            $sort = 'regdate';
            break;
    }

    $header_arr[] = array('text' => $LANG28[7], 'field' => 'email', 'sort' => true);
    $header_arr[] = array('text' => $LANG28[87], 'field' => 'num_reminders', 'sort' => true);
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
                      'title'        => '',
                      'instructions' => $desc,
                      'icon'         => $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE,
                      'form_url'     => $_CONF['site_admin_url'] . "/user.php?mode=batchdelete&amp;usr_type=$usr_type&amp;usr_time=$usr_time",
                      'help_url'     => ''
    );

    $defsort_arr = array('field'     => $sort,
                         'direction' => 'ASC');

    $join_userinfo = "LEFT JOIN {$_TABLES['userinfo']} ON {$_TABLES['users']}.uid={$_TABLES['userinfo']}.uid ";
    $select_userinfo = ", lastlogin as lastlogin_short $list_sql ";

    $sql = "SELECT {$_TABLES['users']}.uid,username,fullname,email,photo,status,regdate,num_reminders$select_userinfo "
         . "FROM {$_TABLES['users']} $join_userinfo WHERE 1=1";

    $query_arr = array (
        'table' => 'users',
        'sql' => $sql,
        'query_fields' => array('username', 'email', 'fullname'),
        'default_filter' => "AND $filter_sql {$_TABLES['users']}.uid > 1"
    );
    $listoptions = array('chkdelete' => true, 'chkfield' => 'uid');

    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'] . '/user.php',
              'text' => $LANG28[11]),
        array('url' => $_CONF['site_admin_url'] . '/user.php?mode=importform',
              'text' => $LANG28[23]),
        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $retval .= COM_startBlock($LANG28[54], '',
                           COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $desc,
        $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE
    );

    $user_templates->set_var('lang_reminder', $LANG28[77]);
    $user_templates->set_var('action_reminder', $LANG28[78]);
    $user_templates->parse('test', 'reminder');

    $form_arr['top'] = $user_templates->finish($user_templates->get_var('test'));
    $token = SEC_createToken();
    $form_arr['bottom'] = "<input type=\"hidden\" name=\"" . CSRF_TOKEN
                        . "\" value=\"{$token}\"" . XHTML . ">";
    $retval .= ADMIN_list('user', 'ADMIN_getListField_users', $header_arr,
                          $text_arr, $query_arr, $defsort_arr, '', '',
                          $listoptions, $form_arr);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
* This function deletes the users selected in the batchdeletelist function
*
* @return   string          HTML with success or error message
*
*/
function batchdeleteexec()
{
    global $_CONF, $LANG28;

    $msg = '';
    $user_list = array();
    if (isset($_POST['delitem'])) {
        $user_list = $_POST['delitem'];
    }

    if (count($user_list) == 0) {
        $msg = $LANG28[72] . '<br' . XHTML . '>';
    }
    $c = 0;

    if (isset($user_list) AND is_array($user_list)) {
        foreach($user_list as $delitem) {
            $delitem = COM_applyFilter($delitem);
            if (!USER_deleteAccount ($delitem)) {
                $msg .= "<strong>{$LANG28[2]} $delitem {$LANG28[70]}</strong><br" . XHTML . ">\n";
            } else {
                $c++; // count the deleted users
            }
        }
    }

    // Since this function is used for deletion only, it's necessary to say that
    // zero were deleted instead of just leaving this message away.
    COM_numberFormat($c); // just in case we have more than 999 ...
    $msg .= "{$LANG28[71]}: $c<br" . XHTML . ">\n";

    return $msg;
}


/**
* This function used to send out reminders to users to access the site or account may be deleted
*
* @return   string          HTML with success or error message
*
*/
function batchreminders()
{
    global $_CONF, $_TABLES, $LANG04, $LANG28;

    $msg = '';
    $user_list = array();
    if (isset($_POST['delitem'])) {
        $user_list = $_POST['delitem'];
    }

    if (count($user_list) == 0) {
        $msg = $LANG28[79] . '<br' . XHTML . '>';
    }
    $c = 0;

    if (isset($_POST['delitem']) AND is_array($_POST['delitem'])) {
        foreach($_POST['delitem'] as $delitem) {
            $userid = COM_applyFilter($delitem);
            $useremail = DB_getItem ($_TABLES['users'], 'email', "uid = '$userid'");
            $username = DB_getItem ($_TABLES['users'], 'username', "uid = '$userid'");
            $lastlogin = DB_getItem ($_TABLES['userinfo'], 'lastlogin', "uid = '$userid'");
            $lasttime = COM_getUserDateTimeFormat ($lastlogin);
            if (file_exists ($_CONF['path_data'] . 'reminder_email.txt')) {
                $template = new Template ($_CONF['path_data']);
                $template->set_file (array ('mail' => 'reminder_email.txt'));
                $template->set_var ('site_url', $_CONF['site_url']);
                $template->set_var ('site_name', $_CONF['site_name']);
                $template->set_var ('site_slogan', $_CONF['site_slogan']);
                $template->set_var ('lang_username', $LANG04[2]);
                $template->set_var ('username', $username);
                $template->set_var ('name', COM_getDisplayName ($uid));
                $template->set_var ('lastlogin', $lasttime[0]);

                $template->parse('output', 'mail');
                $mailtext = $template->finish($template->get_var('output'));
            } else {
                if ($lastlogin == 0) {
                    $mailtext = $LANG28[83] . "\n\n";
                } else {
                    $mailtext = sprintf($LANG28[82], $lasttime[0]) . "\n\n";
                }
                $mailtext .= sprintf($LANG28[84], $username) . "\n";
                $mailtext .= sprintf($LANG28[85], $_CONF['site_url']
                                     . '/users.php?mode=getpassword') . "\n\n";

            }
            $subject = sprintf($LANG28[81], $_CONF['site_name']);
            if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
                $mailfrom = $_CONF['noreply_mail'];
                $mailtext .= LB . LB . $LANG04[159];
            } else {
                $mailfrom = $_CONF['site_mail'];
            }

            if (COM_mail ($useremail, $subject, $mailtext, $mailfrom)) {
                DB_query("UPDATE {$_TABLES['users']} SET num_reminders=num_reminders+1 WHERE uid=$userid");
                $c++;
            } else {
                COM_errorLog("Error attempting to send account reminder to use:$username ($userid)");
            }
        }
    }

    // Since this function is used for deletion only, its necessary to say that
    // zero where deleted instead of just leaving this message away.
    COM_numberFormat($c); // just in case we have more than 999)..
    $msg .= "{$LANG28[80]}: $c<br" . XHTML . ">\n";

    return $msg;
}


/**
* This function allows the administrator to import batches of users
*
* TODO: This function should first display the users that are to be imported,
* together with the invalid users and the reason of invalidity. Each valid line
* should have a checkbox that allows selection of final to be imported users.
* After clicking an extra button, the actual import should take place. This will
* prevent problems in case the list formatting is incorrect.
*
* @return   string          HTML with success or error message
*
*/
function importusers()
{
    global $_CONF, $_TABLES, $LANG04, $LANG28;

    // Setting this to true will cause import to print processing status to
    // webpage and to the error.log file
    $verbose_import = true;

    $retval = '';

    // Bulk import implies admin authorisation:
    $_CONF['usersubmission'] = 0;

    // First, upload the file
    require_once $_CONF['path_system'] . 'classes/upload.class.php';

    $upload = new upload ();
    $upload->setPath ($_CONF['path_data']);
    $upload->setAllowedMimeTypes (array ('text/plain' => '.txt'));
    $upload->setFileNames ('user_import_file.txt');
    if ($upload->uploadFiles()) {
        // Good, file got uploaded, now install everything
        $thefile = current($_FILES);
        $filename = $_CONF['path_data'] . 'user_import_file.txt';
        if (!file_exists($filename)) { // empty upload form
            $retval = COM_refresh($_CONF['site_admin_url']
                                  . '/user.php?mode=importform');
            return $retval;
        }
    } else {
        // A problem occurred, print debug information
        $retval = COM_siteHeader ('menu', $LANG28[22]);
        $retval .= COM_startBlock ($LANG28[24], '',
                COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= $upload->printErrors(false);
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

        return $retval;
    }

    $users = file ($filename);

    $retval .= COM_siteHeader ('menu', $LANG28[24]);
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
            $retval .="<br" . XHTML . "><b>Working on username=$u_name, fullname=$full_name, and email=$email</b><br" . XHTML . ">\n";
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

            if (($ucount == 0) && ($ecount == 0)) {
                // user doesn't already exist - pass in optional true for $batchimport parm
                $uid = USER_createAccount ($userName, $emailAddr, '',
                                           $fullName,'','','',true);

                $result = USER_createAndSendPassword ($userName, $emailAddr, $uid);

                if ($result && $verbose_import) {
                    $retval .= "<br" . XHTML . "> Account for <b>$u_name</b> created successfully.<br" . XHTML . ">\n";
                    COM_errorLog("Account for $u_name created successfully",1);
                } else if ($result) {
                    $successes++;
                } else {
                    // user creation failed
                    $retval .= "<br" . XHTML . ">ERROR: There was a problem creating the account for <b>$u_name</b>.<br" . XHTML . ">\n";
                    COM_errorLog("ERROR: here was a problem creating the account for $u_name.",1);
                }
            } else {
                if ($verbose_import) {
                    $retval .= "<br" . XHTML . "><b>$u_name</b> or <b>$email</b> already exists, account not created.<br" . XHTML . ">\n"; // user already exists
                    COM_errorLog("$u_name,$email: username or email already exists, account not created",1);
                }
                $failures++;
            } // end if $ucount == 0 && ecount == 0
        } else {
            if ($verbose_import) {
                $retval .= "<br" . XHTML . "><b>$email</b> is not a valid email address, account not created<br" . XHTML . ">\n"; // malformed email
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
function display_batchAddform()
{
    global $_CONF, $LANG28, $LANG_ADMIN, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    $token = SEC_createToken();
    $retval .= COM_siteHeader('menu', $LANG28[24]);
    $retval .= COM_startBlock ($LANG28[24], '',
                        COM_getBlockTemplate ('_admin_block', 'header'));

    $menu_arr = array(
        array('url'  => $_CONF['site_admin_url'] . '/user.php',
              'text' => $LANG28[11]),
        array('url'  => $_CONF['site_admin_url'] . '/user.php?mode=batchdelete',
              'text' => $LANG28[54]),
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $desc = '<p>' . $LANG28[25] . '</p>';
    $icon = $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE;
    $retval .= ADMIN_createMenu($menu_arr, $desc, $icon);

    $retval .= '<form action="' . $_CONF['site_admin_url']
            . '/user.php" method="post" enctype="multipart/form-data"><div>'
            . $LANG28[29]
            . ': <input type="file" dir="ltr" name="importfile" size="40"'
            . XHTML . '>'
            . '<input type="hidden" name="mode" value="import"' . XHTML . '>'
            . '<input type="submit" name="submit" value="' . $LANG28[30]
            . '"' . XHTML . '><input type="hidden" name="' . CSRF_TOKEN
            . "\" value=\"{$token}\"" . XHTML . '></div></form>' . LB;

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
    $retval .= COM_siteFooter();

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
if (isset($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

if (isset($_POST['delbutton_x'])) {
    $mode = 'batchdeleteexec';
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
                                 . '/user.php?mode=edit&amp;msg=67&amp;uid=' . $uid);
    } else {
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/user.php?msg=67');
    }
} elseif (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) { // delete
    $uid = COM_applyFilter($_POST['uid'], true);
    if ($uid <= 1) {
        COM_errorLog('Attempted to delete user uid=' . $uid);
        $display = COM_refresh($_CONF['site_admin_url'] . '/user.php');
    } elseif (SEC_checkToken()) {
        $display .= deleteUser($uid);
    } else {
        COM_accessLog("User {$_USER['username']} tried to illegally delete user $uid and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
    }
} elseif (($mode == $LANG_ADMIN['save']) && !empty($LANG_ADMIN['save']) && SEC_checkToken()) { // save
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
            $_POST['regdate'], $_POST['homepage'], $_POST['groups'],
            $delphoto, $_POST['userstatus'], $_POST['oldstatus']);
    if (!empty($display)) {
        $tmp = COM_siteHeader('menu', $LANG28[22]);
        $tmp .= $display;
        $tmp .= COM_siteFooter();
        $display = $tmp;
    }
} elseif ($mode == 'edit') {
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
} elseif (($mode == 'import') && SEC_checkToken()) {
    $display .= importusers();
} elseif ($mode == 'importform') {
    $display .= display_batchAddform();
} elseif ($mode == 'batchdelete') {
    $display .= COM_siteHeader ('menu', $LANG28[54]);
    $display .= batchdelete();
    $display .= COM_siteFooter();
} elseif (($mode == $LANG28[78]) && !empty($LANG28[78]) && SEC_checkToken()) {
    $msg = batchreminders();
    $display .= COM_siteHeader ('menu', $LANG28[11])
        . COM_showMessage($msg)
        . batchdelete()
        . COM_siteFooter();
} elseif (($mode == 'batchdeleteexec') && SEC_checkToken()) {
    $msg = batchdeleteexec();
    $display .= COM_siteHeader ('menu', $LANG28[11])
        . COM_showMessage($msg)
        . batchdelete()
        . COM_siteFooter();
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader('menu', $LANG28[11]);
    $display .= COM_showMessageFromParameter();
    $display .= listusers();
    $display .= COM_siteFooter();
}

COM_output($display);

?>
