<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | user.php                                                                  |
// |                                                                           |
// | Geeklog user administration page.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Vincent Furia     - vmf AT abtech DOT org                        |
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
 */

use Geeklog\Input;

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
$_USER_VERBOSE = COM_isEnableDeveloperModeLog('user');

$display = '';

// Make sure user has access to this page
if (!SEC_hasRights('user.edit')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the user administration screen.");
    COM_output($display);
    exit;
}

/**
 * Shows the user edit form
 *
 * @param    int $uid User to edit
 * @param    int $msg Error message to display
 * @return   string          HTML for user edit form
 */
function edituser($uid = 0, $msg = 0)
{
    global $_CONF, $_TABLES, $_USER, $LANG28, $LANG04, $LANG12, $LANG_ACCESS, $LANG_ADMIN, $MESSAGE, $LANG_configselects, $LANG_confignames, $LANG_postmodes;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    if (!empty($msg)) {
        $retval .= COM_showMessageText($MESSAGE[$msg], $LANG28[22]);
    }

    if (!empty($msg) && !empty($uid) && ($uid > 1)) {
        // an error occurred while editing a user - if it was a new account,
        // don't bother trying to read the user's data from the database ...
        $cnt = DB_count($_TABLES['users'], 'uid', $uid);
        if ($cnt == 0) {
            $uid = 0;
        }
    }

    if (!empty($uid) && ($uid > 1)) {
        $result = DB_query("SELECT * FROM {$_TABLES['users']} WHERE uid = $uid");
        $A = DB_fetchArray($result);
        if (empty($A['uid'])) {
            COM_redirect($_CONF['site_admin_url'] . '/user.php');
        }

        if (SEC_inGroup('Root', $uid) && !SEC_inGroup('Root')) {
            // the current admin user isn't Root but is trying to change
            // a root account.  Deny them and log it.
            $retval .= COM_showMessageText($LANG_ACCESS['editrootmsg'], $LANG28[1]);
            COM_accessLog("User {$_USER['username']} tried to edit a Root account with insufficient privileges.");

            return $retval;
        }
        $resultB = DB_query("SELECT about, pgpkey, location FROM {$_TABLES['user_attributes']} WHERE uid = $uid");
        $B = DB_fetchArray($resultB);
        $newuser = false;
        $A['about'] = $B['about'];
        $A['pgpkey'] = $B['pgpkey'];
        $A['location'] = $B['location'];

        $curtime = COM_getUserDateTimeFormat($A['regdate']);
        $lastlogin = DB_getItem($_TABLES['user_attributes'], 'lastlogin', "uid = '$uid'");
        $lasttime = COM_getUserDateTimeFormat($lastlogin);
    } else {
        $newuser = true;
        $A['uid'] = '';
        $uid = '';
        $curtime = COM_getUserDateTimeFormat();
        $lastlogin = '';
        $lasttime = '';
        $A['status'] = USER_ACCOUNT_ACTIVE;
        $A['location'] = '';
		$A['postmode'] = 'plaintext';
        $A['sig'] = '';
        $A['about'] = '';
		$A['pgpkey'] = '';
    }

    // POST data can override, in case there was an error while editing a user
    if (isset($_POST['username'])) {
        $A['username'] = GLText::stripTags($_POST['username']);
    }
    if (isset($_POST['fullname'])) {
        $A['fullname'] = GLText::stripTags($_POST['fullname']);
    }
    if (isset($_POST['email'])) {
        $A['email'] = GLText::stripTags($_POST['email']);
    }
    if (isset($_POST['homepage'])) {
        $A['homepage'] = GLText::stripTags($_POST['homepage']);
    }
    if (isset($_POST['location'])) {
        $A['location'] = GLText::stripTags($_POST['location']);
    }
    if (isset($_POST['postmode'])) {
		$A['postmode'] = ($A['postmode']=== 'html') ? 'html' : 'plaintext';
	}
    if ($A['postmode'] === 'html') {
        // HTML
		if (isset($_POST['sig'])) {
			$A['sig'] = GLText::checkHTML(GLText::remove4byteUtf8Chars($_POST['sig']), '');
		}
		if (isset($_POST['about'])) {
			$A['about'] = GLText::checkHTML(GLText::remove4byteUtf8Chars($_POST['about']), '');
		}
    } else {
        // Plaintext
		if (isset($_POST['sig'])) {
			$A['sig'] = GLText::stripTags(GLText::remove4byteUtf8Chars($_POST['sig']));
		}
		if (isset($_POST['about'])) {
			$A['about'] = GLText::stripTags(GLText::remove4byteUtf8Chars($_POST['about']));
		}
    }	
    if (isset($_POST['pgpkey'])) {
        $A['pgpkey'] = GLText::stripTags($_POST['pgpkey']);
    }
    if (isset($_POST['userstatus'])) {
        $A['status'] = COM_applyFilter($_POST['userstatus'], true);
    }
    if (isset($_POST['twofactorauth_enabled'])) {
        $A['twofactorauth_enabled'] = COM_applyFilter($_POST['twofactorauth_enabled'], true);
    }

    $token = SEC_createToken();

    $retval .= COM_startBlock($LANG28[1], '',
        COM_getBlockTemplate('_admin_block', 'header'));
    $retval .= SEC_getTokenExpiryNotice($token);

    $user_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/user'));
    $user_templates->set_file(array(
        'form'      => 'edituser.thtml',
        'password'  => 'password.thtml',
        'groupedit' => 'groupedit.thtml',
    ));

    $blocks = array('display_field', 'display_field_text');
    foreach ($blocks as $block) {
        $user_templates->set_block('form', $block);
    }

    $user_templates->set_var('lang_save', $LANG_ADMIN['save']);
    if (!empty($uid) && ($A['uid'] != $_USER['uid']) && SEC_hasRights('user.delete')) {
        $user_templates->set_var('allow_delete', true);
        $user_templates->set_var('lang_delete', $LANG_ADMIN['delete']);
        $user_templates->set_var('confirm_message', $MESSAGE[76]);
    }
    $user_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);

    $user_templates->set_var('lang_userid', $LANG28[2]);
    if (empty($A['uid'])) {
        $user_templates->set_var('user_id', $LANG_ADMIN['na']);
    } else {
        $user_templates->set_var('user_id', $A['uid']);
    }
    $user_templates->set_var('lang_regdate', $LANG28[14]);
    $user_templates->set_var('regdate_timestamp', $curtime[1]);
    $user_templates->set_var('user_regdate', $curtime[0]);
    $user_templates->set_var('lang_lastlogin', $LANG28[35]);
    if (empty($lastlogin)) {
        $user_templates->set_var('user_lastlogin', $LANG28[36]);
    } else {
        $user_templates->set_var('user_lastlogin', $lasttime[0]);
    }
    $user_templates->set_var('lang_username', $LANG28[3]);
    if (isset($A['username'])) {
        $user_templates->set_var('username', $A['username']);
    } else {
        $user_templates->set_var('username', '');
    }

    $remoteservice = '';
    if ($_CONF['show_servicename']) {
        if (!empty($A['remoteservice'])) {
            $remoteservice = '@' . $A['remoteservice'];
        }
    }
    // Always show if account is a remote service
    if (!empty($A['remoteservice'])) {
        $user_templates->set_var('lang_convert_remote', $LANG28['convert_remote']);
        $user_templates->set_var('lang_convert_remote_tooltip', COM_getTooltip('', $LANG28['convert_remote_desc'], '', '', 'information'));
        $user_templates->set_var('lang_convert_remote_desc', $LANG28['convert_remote_desc']);
    }

    $user_templates->set_var('remoteservice', $remoteservice);

    $user_templates->clear_var('show_delete_photo');
    if ($_CONF['allow_user_photo'] && ($A['uid'] > 0)) {
        $photo = USER_getPhoto($A['uid'], $A['photo'], $A['email'], -1);
        $user_templates->set_var('user_photo', $photo);
        if (empty($A['photo'])) {
            $user_templates->clear_var('lang_delete_photo');
        } else {
            $user_templates->set_var('lang_delete_photo', $LANG28[28]);
            $user_templates->set_var('show_delete_photo', true); // Only show delete photo if no user photo or no site default user photo
        }
    } else {
        $user_templates->clear_var('user_photo');
        $user_templates->clear_var('lang_delete_photo');
    }

    $user_templates->set_var('lang_fullname', $LANG28[4]);
    if (isset($A['fullname'])) {
        $user_templates->set_var('user_fullname',
            htmlspecialchars($A['fullname']));
    } else {
        $user_templates->set_var('user_fullname', '');
    }

    if (empty($A['remoteservice'])) {
        $user_templates->set_var('lang_password', $LANG28[5]);
        $user_templates->set_var('lang_password_conf', $LANG28[39]);
        $user_templates->set_var(array(
            'lang_send_password' => $LANG28[91],
            'lang_send_password_desc' => $LANG28[92],
            'send_password'      => SEC_hasRights('user.edit') && ($uid != $_USER['uid']),
        ));
        $user_templates->parse('password_option', 'password', true);
    } else {
        $user_templates->set_var('password_option', '');
    }

    $user_templates->set_var('lang_emailaddress', $LANG28[7]);
    if (isset($A['email'])) {
        $user_templates->set_var('user_email', htmlspecialchars($A['email']));
    } else {
        $user_templates->set_var('user_email', '');
    }

    // Two Factor Auth
    if (!$newuser && isset($_CONF['enable_twofactorauth']) && $_CONF['enable_twofactorauth']) {
        $enableTfaOptions = '';
        foreach ($LANG_configselects['Core'][0] as $text => $value) {
            $selected = ($A['twofactorauth_enabled'] == $value);
            $enableTfaOptions .= '<option value="' . $value . '"'
                . ($selected ? ' selected="selected"' : '') . '>'
                . $text . '</option>' . PHP_EOL;
        }

        $user_templates->set_var(array(
            'enable_twofactorauth'      => true,
            'lang_tfa_two_factor_auth'  => $LANG04['tfa_two_factor_auth'],
            'lang_tfa_user_edit_desc'   => $LANG04['lang_tfa_user_edit_desc'],
            'lang_enable_twofactorauth' => $LANG_confignames['Core']['enable_twofactorauth'],
            'enable_tfa_options'        => $enableTfaOptions
        ));
    } else {
        $user_templates->set_var('enable_twofactorauth', false);
    }

    $user_templates->set_var('lang_homepage', $LANG28[8]);
    if (isset($A['homepage'])) {
        $user_templates->set_var('user_homepage',
            htmlspecialchars(COM_killJS($A['homepage'])));
    } else {
        $user_templates->set_var('user_homepage', '');
    }
    $user_templates->set_var('do_not_use_spaces', '');

    $user_templates->set_var('lang_location', $LANG04[106]);
    $user_templates->set_var('user_location', htmlspecialchars($A['location']));
	$user_templates->set_var('lang_postmode', $LANG12[36]);
    $user_templates->set_var('lang_plaintext', $LANG_postmodes['plaintext']);
    $user_templates->set_var('lang_html', $LANG_postmodes['html']);
    $user_templates->set_var('lang_postmode_text', $LANG04[171]);
	$postMode = $A['postmode'];
    $user_templates->set_var(array(
        'plaintext_selected' => (($postMode === 'plaintext') ? ' selected="selected"' : ''),
        'html_selected'      => (($postMode === 'html') ? ' selected="selected"' : ''),
    ));
    $user_templates->set_var('lang_signature', $LANG04[32]);
    $user_templates->set_var(
        'user_signature',
        GLText::getEditText($A['sig'], $postMode, GLTEXT_LATEST_VERSION)
    );	
    $user_templates->set_var('lang_about', $LANG04[7]);
    $user_templates->set_var(
        'user_about',
        GLText::getEditText($A['about'], $postMode, GLTEXT_LATEST_VERSION)
    );	
    $user_templates->set_var('lang_pgpkey', $LANG04[8]);
    $user_templates->set_var('user_pgpkey', htmlspecialchars($A['pgpkey']));

    $statusarray = array(
        USER_ACCOUNT_ACTIVE              => $LANG28[45],
    );

    // Only show Awaiting Activation status if user already this status as this is an automated status and should not be set by Admin
    // Admin should use USER_ACCOUNT_NEW_EMAIL instead
    if ($A['status'] == USER_ACCOUNT_AWAITING_ACTIVATION && !empty($uid)) {
        $statusarray[USER_ACCOUNT_AWAITING_ACTIVATION] = $LANG28[43];
    }

    $allow_other_statuses = true;
    // do not allow to ban yourself or forcing new email or password
    if (!empty($uid)) {
        if ($A['uid'] == $_USER['uid']) {
            $allow_other_statuses = false; // do not allow to ban yourself or forcing new email or password
        } elseif (SEC_inGroup('Root', $A['uid'])) { // editing a Root user?
            $count_root_sql = "SELECT COUNT(ug_uid) AS root_count FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 1 GROUP BY ug_uid;";
            $count_root_result = DB_query($count_root_sql);
            $C = DB_fetchArray($count_root_result); // how many are left?
            if ($C['root_count'] < 2) {
                $allow_other_statuses = false; // prevent banning the last root user
            }
        }
    }

    if ($allow_other_statuses) {
        $statusarray[USER_ACCOUNT_DISABLED] = $LANG28[42];
        $statusarray[USER_ACCOUNT_LOCKED] = $LANG28['USER_ACCOUNT_LOCKED'];
        $statusarray[USER_ACCOUNT_NEW_EMAIL] = $LANG28['USER_ACCOUNT_NEW_EMAIL'];
        // Only for non remote accounts
        if (empty($A['remoteservice'])) {
            $statusarray[USER_ACCOUNT_NEW_PASSWORD] = $LANG28['USER_ACCOUNT_NEW_PASSWORD'];
        }
    }

    // If this status then $_CONF['usersubmission'] == 1 better be true
    // Only show Awaiting Authorization status if user already this status as this is an automated status and should not be set by Admin
    if (($A['status'] == USER_ACCOUNT_AWAITING_APPROVAL) && !empty($uid)) {
        $statusarray[USER_ACCOUNT_AWAITING_APPROVAL] = $LANG28[44];
    }
    asort($statusarray);

    $items = '';
    foreach ($statusarray as $key => $value) {
        $items .= '<option value="' . $key . '"';
        if ($key == $A['status']) {
            $items .= ' selected="selected"';
        }
        $items .= '>' . $value . '</option>' . LB;
    }
    $statusselect = COM_createControl('type-select', array(
        'name' => 'userstatus',
        'select_items' => $items
    ));
    $user_templates->set_var('user_status', $statusselect);
    $user_templates->set_var('lang_user_status', $LANG28[46]);
    $user_templates->set_var('lang_user_status_desc', $LANG28['user_status_desc']);

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

        if (!empty($uid)) {
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

            // add default groups, if any
            $result = DB_query("SELECT grp_id FROM {$_TABLES['groups']} WHERE grp_default = 1");
            $num_defaults = DB_numRows($result);
            for ($i = 0; $i < $num_defaults; $i++) {
                list($def_grp) = DB_fetchArray($result);
                $selected .= ' ' . $def_grp;
            }
        }

        // in case of an error we may have previously selected a different
        // mix of groups already - reconstruct those from the POST data
        if (isset($_POST['groups']) && (count($_POST['groups']) > 0)) {
            $selected = implode(' ', $_POST['groups']);
        }

        $thisUsersGroups = SEC_getUserGroups();
        $remoteGroup = DB_getItem($_TABLES['groups'], 'grp_id',
            "grp_name = 'Remote Users'");
        if (!empty($remoteGroup)) {
            $thisUsersGroups[] = $remoteGroup;
        }
        $whereGroups = 'grp_id IN (' . implode(',', $thisUsersGroups) . ')';

        $header_arr = array(
            array('text' => $LANG28[86], 'field' => 'checkbox', 'sort' => false),
            array('text' => $LANG_ACCESS['groupname'], 'field' => 'grp_name', 'sort' => true),
            array('text' => $LANG_ACCESS['description'], 'field' => 'grp_descr', 'sort' => true),
        );
        $defsort_arr = array('field' => 'grp_name', 'direction' => 'asc');

        $form_url = $_CONF['site_admin_url']
            . '/user.php?mode=edit&amp;uid=' . $uid;
        $text_arr = array(
            'has_menu'     => false,
            'title'        => '',
            'instructions' => '',
            'icon'         => '',
            'form_url'     => $form_url,
            'inline'       => true,
        );

        $sql = "SELECT grp_id, grp_name, grp_descr FROM {$_TABLES['groups']} WHERE " . $whereGroups;
        $query_arr = array(
            'table'          => 'groups',
            'sql'            => $sql,
            'query_fields'   => array('grp_name'),
            'default_filter' => '',
            'query'          => '',
            'query_limit'    => 0,
        );

        $groupoptions = ADMIN_list('usergroups',
            'ADMIN_getListField_usergroups',
            $header_arr, $text_arr, $query_arr,
            $defsort_arr, '', explode(' ', $selected)
        );

        $user_templates->set_var('group_options', $groupoptions);
        $user_templates->parse('group_edit', 'groupedit', true);
    } else {
        // user doesn't have the rights to edit a user's groups so set to -1
        // so we know not to handle the groups array when we save
        $user_templates->set_var('group_edit',
            '<input type="hidden" name="groups" value="-1"' . XHTML . '>');
    }
    $user_templates->set_var('gltoken_name', CSRF_TOKEN);
    $user_templates->set_var('gltoken', $token);

    PLG_profileVariablesEdit($uid, $user_templates);

    $user_templates->parse('output', 'form');
    $retval .= $user_templates->finish($user_templates->get_var('output'));
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

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
        array('text' => $LANG28[7], 'field' => 'email', 'sort' => true),
    );

    if ($_CONF['user_login_method']['openid'] || $_CONF['user_login_method']['3rdparty']) {
        $header_arr[] = array('text' => $LANG04[121], 'field' => 'remoteservice', 'sort' => true);
    }

    $defsort_arr = array(
        'field'     => $_TABLES['users'] . '.uid',
        'direction' => 'ASC',
    );

    $menu_arr = array(
        array('url'  => $_CONF['site_admin_url'] . '/user.php?mode=edit',
              'text' => $LANG_ADMIN['create_new']),
        array('url'  => $_CONF['site_admin_url'] . '/user.php?mode=importform',
              'text' => $LANG28[23]),
        array('url'  => $_CONF['site_admin_url'] . '/user.php?mode=batchdelete',
              'text' => $LANG28[54]),
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']),
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
        'help_url'   => '',
    );

    $join_userinfo = '';
    $select_userinfo = '';
    if ($_CONF['lastlogin']) {
        $join_userinfo .= "LEFT JOIN {$_TABLES['user_attributes']} ON {$_TABLES['users']}.uid={$_TABLES['user_attributes']}.uid ";
        $select_userinfo .= ",lastlogin";
    }
    if ($_CONF['user_login_method']['openid'] ||
        $_CONF['user_login_method']['3rdparty']
    ) {
        $select_userinfo .= ',remoteservice';
    }
    $sql = "SELECT {$_TABLES['users']}.uid,username,fullname,email,photo,status,regdate$select_userinfo "
        . "FROM {$_TABLES['users']} $join_userinfo WHERE 1=1";

    $query_arr = array(
        'table'          => 'users',
        'sql'            => $sql,
        'query_fields'   => array('username', 'email', 'fullname', 'homepage'),
        'default_filter' => "AND {$_TABLES['users']}.uid > 1",
    );

    $retval .= ADMIN_list('user', 'ADMIN_getListField_users', $header_arr,
        $text_arr, $query_arr, $defsort_arr);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
 * Saves user to the database
 *
 * @param    int    $uid          user id
 * @param    string $username     (short) username
 * @param    string $fullname     user's full name
 * @param    string $email        user's email address
 * @param    string $regdate      date the user registered with the site
 * @param    string $homepage     user's homepage URL
 * @param    array  $groups       groups the user belongs to
 * @param    string $delete_photo delete user's photo if == 'on'
 * @param    string $convert_remote  Convert remote account to local if 'on'
 * @return   string                  HTML redirect or error message
 */
function saveusers($uid, $username, $fullname, $passwd, $passwd_conf, $email, $regdate, $homepage, $location, $postmode, $signature, $pgpkey, $about, $groups, $delete_photo = '', $convert_remote = '', $userstatus = 3, $oldstatus = 3, $enable_twofactorauth = 0)
{
    global $_CONF, $_TABLES, $_USER, $LANG04, $LANG28, $_USER_VERBOSE;

    $retval = '';
    $userChanged = false;

    $username = trim($username);

    if ($_USER_VERBOSE) {
        COM_errorLog("**** entering saveusers****", 1);
        COM_errorLog("group size at beginning = " . count($groups), 1);
    }

    $service = DB_getItem($_TABLES['users'], 'remoteservice', "uid = $uid");
    // If remote service then assume blank password
    if (!empty($service)) {
        $passwd = '';
        $passwd_conf = '';

        // Make sure User Status is not some how USER_ACCOUNT_NEW_PASSWORD for remote users
        if ($userstatus == USER_ACCOUNT_NEW_PASSWORD) {
             $userstatus = USER_ACCOUNT_ACTIVE;
        }
    }

    $passwd_changed = true;
    if (empty($service) && (SEC_encryptUserPassword($passwd, $uid) === 0) && ($passwd_conf === '')) {
        $passwd_changed = false;
    }

    if ($passwd_changed && ($passwd != $passwd_conf)) { // passwords don't match
        return edituser($uid, 67);
    }

    $nameAndEmailOkay = true;
    if (empty($username)) {
        $nameAndEmailOkay = false;
    } elseif (empty($email)) {
        if (empty($uid)) {
            $nameAndEmailOkay = false; // new users need an email address
        } else {
            if (empty($service)) {
                $nameAndEmailOkay = false; // not a remote user - needs email
            }
        }
    }

    if ($nameAndEmailOkay) {
        if (!empty($email) && !COM_isEmail($email)) {
            return edituser($uid, 52);
        }

        $uname = DB_escapeString($username);
        // Remember some database collations are case and accent insensitive and some are not. They would consider "nina", "nina  ", "Nina", and, "niña" as the same
        if (empty($uid)) {
            $ucount = DB_getItem($_TABLES['users'], 'COUNT(*)', "TRIM(LOWER(username)) = TRIM(LOWER('$uname'))");
        } else {
            $ucount = DB_getItem($_TABLES['users'], 'COUNT(*)', "TRIM(LOWER(username)) = TRIM(LOWER('$uname')) AND uid <> $uid");
        }
        if ($ucount > 0) {
            // Admin just changed a user's username to one that already exists
            return edituser($uid, 51);
        }

        $emailaddr = DB_escapeString($email);
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
                $ucount = DB_getItem(
                    $_TABLES['users'], 'COUNT(*)',
                    "email = '$emailaddr' AND uid <> $uid" . $exclude_remote
                );
            }
        }
        if ($ucount > 0) {
            // Admin just changed a user's email to one that already exists
            return edituser($uid, 56);
        }

        if ($_CONF['custom_registration'] && function_exists('CUSTOM_userCheck')) {
            $ret = CUSTOM_userCheck($username, $email);
            if (!empty($ret)) {
                // need a numeric return value - otherwise use default message
                if (!is_numeric($ret['number'])) {
                    $ret['number'] = 400;
                }

                return edituser($uid, $ret['number']);
            }
        }

        // basic filtering only (same as in usersettings.php)
        $fullname = GLText::stripTags(GLText::remove4byteUtf8Chars($fullname));
        $location = GLText::stripTags(GLText::remove4byteUtf8Chars($location));
        //$signature = GLText::stripTags(GLText::remove4byteUtf8Chars($signature));
        //$about = GLText::stripTags(GLText::remove4byteUtf8Chars($about));
		$postmode = ($postmode === 'html') ? 'html' : 'plaintext';
		if ($postmode === 'html') {
			// HTML
			$A['sig'] = GLText::checkHTML(GLText::remove4byteUtf8Chars($signature), '');
			$A['about'] = GLText::checkHTML(GLText::remove4byteUtf8Chars($about), '');
		} else {
			// Plaintext
			$A['sig'] = GLText::stripTags(GLText::remove4byteUtf8Chars($signature));
			$A['about'] = GLText::stripTags(GLText::remove4byteUtf8Chars($about));
		}
        $pgpkey = GLText::stripTags(GLText::remove4byteUtf8Chars($pgpkey));

        // Escape these here since used both in new and updates
        $location = DB_escapeString($location);
		$postmode = DB_escapeString($postmode);
        $signature = DB_escapeString($signature);
        $about = DB_escapeString($about);
		$pgpkey = DB_escapeString($pgpkey);

        $emailData = array(
            'username' => $username,
            'fullname' => $fullname,
            'email' => $email,
            'password' => $passwd,
        );

        if (empty($uid)) {
            $emailData['is_new_user'] = true;
            if (empty($passwd)) {
                // no password? create one ...
                $passwd = SEC_generateRandomPassword();
            }

            $uid = USER_createAccount($username, $email, $passwd, $fullname, $homepage);
            DB_query("UPDATE {$_TABLES['users']} SET sig = '$signature', postmode='$postmode' WHERE uid = $uid");
            DB_query("UPDATE {$_TABLES['user_attributes']} SET pgpkey='$pgpkey',about='$about',location='$location' WHERE uid=$uid");

            if ($uid > 1) {
                DB_query("UPDATE {$_TABLES['users']} SET status = $userstatus WHERE uid = $uid");
            }
        } else {
            $emailData['is_new_user'] = false;

            // Do these ones here since USER_createAccount will do its own filtering
            $escFullName = DB_escapeString($fullname);
            $homepage = DB_escapeString($homepage);

            $curphoto = DB_getItem($_TABLES['users'], 'photo', "uid = $uid");
            if (!empty($curphoto) && ($delete_photo == 'on')) {
                USER_deletePhoto($curphoto);
                $curphoto = '';
            }

            if (($_CONF['allow_user_photo'] == 1) && !empty($curphoto)) {
                $curusername = DB_getItem($_TABLES['users'], 'username',
                    "uid = $uid");
                if ($curusername != $username) {
                    // user has been renamed - rename the photo, too
                    $newphoto = preg_replace('/' . $curusername . '/', $username, $curphoto, 1);
                    $imgpath = $_CONF['path_images'] . 'userphotos/';
                    if (@rename($imgpath . $curphoto, $imgpath . $newphoto) === false) {
                        $retval .= COM_errorLog('Could not rename userphoto "' . $curphoto . '" to "' . $newphoto . '".');

                        return $retval;
                    }
                    $curphoto = $newphoto;
                }
            }

            $username = GLText::remove4byteUtf8Chars($username);
            $escUserName = DB_escapeString($username);
            $curphoto = DB_escapeString($curphoto);

            // Only allow Admins to disable other users 2 Factor Authentication (if enabled for entire site)
            if (!$enable_twofactorauth && isset($_CONF['enable_twofactorauth']) && $_CONF['enable_twofactorauth']) {
                $sql_enable_twofactorauth = ", twofactorauth_enabled = $enable_twofactorauth, twofactorauth_secret = '' ";
            } else {
                //$sql_enable_twofactorauth = ", twofactorauth_enabled = $enable_twofactorauth ";
                $sql_enable_twofactorauth = ""; // Only allowed to disable
            }

            DB_query("UPDATE {$_TABLES['users']} SET username = '{$escUserName}', fullname = '{$escFullName}', email = '$email', homepage = '$homepage', sig = '$signature', postmode='$postmode', photo = '$curphoto', status = '$userstatus' $sql_enable_twofactorauth WHERE uid = {$uid}");
            DB_query("UPDATE {$_TABLES['user_attributes']} SET pgpkey='$pgpkey',about='$about',location='$location' WHERE uid=$uid");
            if ($passwd_changed && !empty($passwd)) {
                SEC_updateUserPassword($passwd, $uid);
            }
            if ($_CONF['custom_registration'] AND (function_exists('CUSTOM_userSave'))) {
                CUSTOM_userSave($uid);
            }

            $curremote = DB_getItem($_TABLES['users'], 'remoteservice', "uid = $uid");
            $user_convert = 0;
            if (!empty($curremote) && ($convert_remote == 'on')) {
                $user_convert = USER_convertRemote($uid);
                $curremote = '';
            }

            // If user submission that meets conditions make sure password email not already sent with remote account conversion
            if (($_CONF['usersubmission'] == 1) && ($oldstatus == USER_ACCOUNT_AWAITING_APPROVAL) && ($userstatus == USER_ACCOUNT_ACTIVE) && ($user_convert != 2)) {
                USER_createAndSendPassword($username, $email, $uid);
            }

            // When the admin has disabled Two Factor Authentication, invalidate secret code and all the backup codes he/she might have
            if (!$enable_twofactorauth) {
                DB_query(
                    "UPDATE {$_TABLES['users']} SET twofactorauth_secret = '' "
                    . "WHERE (uid = {$uid})"
                );
                $tfa = new Geeklog\TwoFactorAuthentication($uid);
                $tfa->invalidateBackupCodes();
            }

            if ($userstatus == USER_ACCOUNT_DISABLED) {
                SESS_deleteUserSessions($uid);
            }
            $userChanged = true;
        }

        // See if any plugins added fields that need to be saved
        PLG_profileExtrasSave('', $uid);

        // check that the user is allowed to change group assignments
        if (is_array($groups) && SEC_hasRights('group.assign')) {
            if (!SEC_inGroup('Root')) {
                $rootgrp = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                if (in_array($rootgrp, $groups)) {
                    COM_accessLog("User {$_USER['username']} ({$_USER['uid']}) just tried to give Root permissions to user $username.");
                    COM_redirect($_CONF['site_admin_url'] . '/index.php');
                }
            }

            // make sure the Remote Users group is in $groups
            if (SEC_inGroup('Remote Users', $uid)) {
                $remUsers = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Remote Users'");
                if (!in_array($remUsers, $groups)) {
                    $groups[] = $remUsers;
                }
            }

            if ($_USER_VERBOSE) {
                COM_errorLog("deleting all group_assignments for user $uid/$username", 1);
            }

            // remove user from all groups that the User Admin is a member of
            $UserAdminGroups = SEC_getUserGroups();
            $whereGroup = 'ug_main_grp_id IN (' . implode(',', $UserAdminGroups) . ')';
            DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_uid = $uid) AND " . $whereGroup);

            // make sure to add user to All Users and Logged-in Users groups
            $allUsers = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'All Users'");
            if (!in_array($allUsers, $groups)) {
                $groups[] = $allUsers;
            }
            $logUsers = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Logged-in Users'");
            if (!in_array($logUsers, $groups)) {
                $groups[] = $logUsers;
            }

            foreach ($groups as $userGroup) {
                if (in_array($userGroup, $UserAdminGroups)) {
                    if ($_USER_VERBOSE) {
                        COM_errorLog("adding group_assignment " . $userGroup . " for $username", 1);
                    }
                    $sql = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($userGroup, $uid)";
                    DB_query($sql);
                }
            }
        }

        // Send password to the user
        if (!empty($uid) && ($uid > 1) &&
            (Input::fPost('send_passwd') === 'on') &&
            ($emailData['is_new_user'] || $passwd_changed)) {
            $subject = $_CONF['site_name'] . ': ' . $LANG04[16];
            $mailText = $emailData['is_new_user'] ? $LANG04[15] : $LANG04[170];
            $mailText .= "\n\n"
                . $LANG04[2] . ": {$emailData['username']}\n"
                . $LANG04[4] . ": {$emailData['password']}\n\n"
                . $LANG04[14] . "\n\n"
                . $_CONF['site_name'] . "\n"
                . $_CONF['site_url'] . "\n";

            if (!COM_mail($emailData['email'], $subject, $mailText)) {
                COM_errorLog(sprintf('failed to send a new password to user (uid: %d)', $uid));
            }
        }

        if ($userChanged) {
            PLG_userInfoChanged($uid);
        }

        $errors = DB_error();
        if (empty($errors)) {
            echo PLG_afterSaveSwitch(
                $_CONF['aftersave_user'],
                "{$_CONF['site_url']}/users.php?mode=profile&uid=$uid",
                'user',
                21
            );
        } else {
            $retval .= COM_errorLog('Error in saveusers in ' . $_CONF['site_admin_url'] . '/user.php');
            $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG28[22]));
            echo $retval;
            exit;
        }
    } else {
        $retval .= COM_showMessageText($LANG28[10]);
        if (!empty($uid) && ($uid > 1) && DB_count($_TABLES['users'], 'uid', $uid) > 0) {
            $retval .= edituser($uid);
        } else {
            $retval .= edituser();
        }
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG28[1]));
        COM_output($retval);
        exit;
    }

    if ($_USER_VERBOSE) {
        COM_errorLog("***************leaving saveusers*****************", 1);
    }

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

    if (!$_CONF['lastlogin']) {
        $retval .= '<p>' . $LANG28[55] . '</p>';

        return $retval;
    }

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $usr_type = Geeklog\Input::fRequest('usr_type', '');
    if (!in_array($usr_type, array('phantom', 'short', 'old', 'recent'))) {
        $usr_type = 'phantom';
    }

    $usr_time_arr = array();
    // default values, in months
    $usr_time_arr['phantom'] = 2;
    $usr_time_arr['short'] = 6;
    $usr_time_arr['old'] = 24;
    $usr_time_arr['recent'] = 1;

    $usr_time = '';
    if (isset($_REQUEST['usr_time'])) {
        // 'usr_time' is an array when clicking "Update List" but a single
        // value when actually deleting users
        if (is_array($_REQUEST['usr_time'])) {
            $usr_time_arr = $_REQUEST['usr_time'];
        } else {
            $usr_time_arr[$usr_type] = (int) $_REQUEST['usr_time'];
        }
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
        array('sel' => 'recent', 'desc' => $LANG28[74], 'txt1' => $LANG28[75], 'txt2' => $LANG28[76]),
    );

    $user_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/user'));
    $user_templates->set_file('form', 'batchdelete.thtml');
    $user_templates->set_block('form', 'batchdelete_options');
    $user_templates->set_block('form', 'reminder');


    $user_templates->set_var('usr_type', $usr_type);
    $user_templates->set_var('usr_time', $usr_time);
    $user_templates->set_var('lang_instruction', $LANG28[56]);
    $user_templates->set_var('lang_updatelist', $LANG28[66]);

    $num_opts = count($opt_arr);
    for ($i = 0; $i < $num_opts; $i++) {
        $selector = '';
        if ($usr_type == $opt_arr[$i]['sel']) {
            $selector = ' checked="checked"';
        }
        $user_templates->set_var('sel_id', $opt_arr[$i]['sel']);
        $user_templates->set_var('selector', $selector);
        $user_templates->set_var('lang_description', $opt_arr[$i]['desc']);
        $user_templates->set_var('lang_text_start', $opt_arr[$i]['txt1']);
        $user_templates->set_var('lang_text_end', $opt_arr[$i]['txt2']);
        $user_templates->set_var('id_value', $usr_time_arr[$opt_arr[$i]['sel']]);
        $user_templates->parse('options_list', 'batchdelete_options', true);
    }
    $user_templates->parse('form', 'form');
    $desc = $user_templates->finish($user_templates->get_var('form'));

    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG28[37], 'field' => $_TABLES['users'] . '.uid', 'sort' => true),
        array('text' => $LANG28[3], 'field' => 'username', 'sort' => true),
        array('text' => $LANG28[4], 'field' => 'fullname', 'sort' => true),
    );

    switch ($usr_type) {
        case 'phantom':
            $header_arr[] = array('text' => $LANG28[14], 'field' => 'regdate', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin_short', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[67], 'field' => 'phantom_date', 'sort' => true);
            $list_sql = ", UNIX_TIMESTAMP()- UNIX_TIMESTAMP(regdate) as phantom_date";
            $filter_sql = "lastlogin = CAST(0 AS CHAR) AND UNIX_TIMESTAMP()- UNIX_TIMESTAMP(regdate) > " . ($usr_time * 2592000) . " AND";
            $sort = 'regdate';
            break;

        case 'short':
            $header_arr[] = array('text' => $LANG28[14], 'field' => 'regdate', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin_short', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[68], 'field' => 'online_hours', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[69], 'field' => 'offline_months', 'sort' => true);
            $list_sql = ", (lastlogin - UNIX_TIMESTAMP(regdate)) AS online_hours, (UNIX_TIMESTAMP() - lastlogin) AS offline_months";
            $filter_sql = "lastlogin > CAST(0 AS CHAR) AND lastlogin - UNIX_TIMESTAMP(regdate) < 86400 "
                . "AND UNIX_TIMESTAMP() - lastlogin > " . ($usr_time * 2592000) . " AND";
            $sort = 'lastlogin';
            break;

        case 'old':
            $header_arr[] = array('text' => $LANG28[41], 'field' => 'lastlogin_short', 'sort' => true);
            $header_arr[] = array('text' => $LANG28[69], 'field' => 'offline_months', 'sort' => true);
            $list_sql = ", (UNIX_TIMESTAMP() - lastlogin) AS offline_months";
            $filter_sql = "lastlogin > CAST(0 AS CHAR) AND (UNIX_TIMESTAMP() - lastlogin) > " . ($usr_time * 2592000) . " AND";
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
    $header_arr[] = array('text' => $LANG28['contributed'], 'field' => 'contributed', 'sort' => false);
    $header_arr[] = array('text' => $LANG28[87], 'field' => 'num_reminders', 'sort' => true);
    $menu_arr = array(
        array('url'  => $_CONF['site_admin_url'] . '/user.php',
              'text' => $LANG28[11]),
        array('url'  => $_CONF['site_admin_url'] . '/user.php?mode=importform',
              'text' => $LANG28[23]),
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']),
    );

    $text_arr = array(
        'has_menu'     => true,
        'has_extras'   => true,
        'title'        => '',
        'instructions' => $desc,
        'icon'         => $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE,
        'form_url'     => $_CONF['site_admin_url'] . "/user.php?mode=batchdelete&amp;usr_type=$usr_type&amp;usr_time=$usr_time",
        'help_url'     => '',
    );

    $defsort_arr = array(
        'field'     => $sort,
        'direction' => 'ASC',
    );

    $join_userinfo = "LEFT JOIN {$_TABLES['user_attributes']} ON {$_TABLES['users']}.uid={$_TABLES['user_attributes']}.uid ";
    $select_userinfo = ", lastlogin as lastlogin_short $list_sql ";

    $sql = "SELECT {$_TABLES['users']}.uid,username,fullname,email,photo,status,regdate,num_reminders$select_userinfo "
        . "FROM {$_TABLES['users']} $join_userinfo WHERE 1=1";

    $query_arr = array(
        'table'          => 'users',
        'sql'            => $sql,
        'query_fields'   => array('username', 'email', 'fullname'),
        'default_filter' => "AND $filter_sql {$_TABLES['users']}.uid > 1",
    );
    $listoptions = array('chkdelete' => true, 'chkfield' => 'uid');

    $menu_arr = array(
        array('url'  => $_CONF['site_admin_url'] . '/user.php',
              'text' => $LANG28[11]),
        array('url'  => $_CONF['site_admin_url'] . '/user.php?mode=importform',
              'text' => $LANG28[23]),
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']),
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
 */
function batchdeleteexec()
{
    global $_CONF, $LANG28;

    $msg = '';

    $user_list = Geeklog\Input::fPost('delitem', array());
    if (count($user_list) === 0) {
        $msg = $LANG28[72] . '<br' . XHTML . '>';
    }
    $c = 0;

    if (!empty($user_list) && is_array($user_list)) {
        foreach ($user_list as $delitem) {
            if (!USER_deleteAccount($delitem)) {
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
 */
function batchreminders()
{
    global $_CONF, $_TABLES, $LANG04, $LANG28;

    $msg = '';
    $user_list = Geeklog\Input::fPost('delitem', array());

    if (count($user_list) === 0) {
        $msg = $LANG28[79] . '<br' . XHTML . '>';
    }
    $c = 0;

    if (!empty($user_list) && is_array($user_list)) {
        foreach ($user_list as $delitem) {
            $userid = (int) $delitem;
            $useremail = DB_getItem($_TABLES['users'], 'email', "uid = '{$userid}'");
            $username = DB_getItem($_TABLES['users'], 'username', "uid = '{$userid}'");
            $lastlogin = DB_getItem($_TABLES['user_attributes'], 'lastlogin', "uid = '{$userid}'");
            $lasttime = COM_getUserDateTimeFormat($lastlogin);
            if (file_exists($_CONF['path_data'] . 'reminder_email.txt')) {
                $template = COM_newTemplate(CTL_core_templatePath($_CONF['path_data']));
                $template->set_file(array('mail' => 'reminder_email.txt'));
                $template->set_var('site_name', $_CONF['site_name']);
                $template->set_var('site_slogan', $_CONF['site_slogan']);
                $template->set_var('lang_username', $LANG04[2]);
                $template->set_var('username', $username);
                $template->set_var('name', COM_getDisplayName($userid));
                $template->set_var('lastlogin', $lasttime[0]);

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

            if (COM_mail($useremail, $subject, $mailtext)) {
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
 * TODO: This function should first display the users that are to be imported,
 * together with the invalid users and the reason of invalidity. Each valid line
 * should have a checkbox that allows selection of final to be imported users.
 * After clicking an extra button, the actual import should take place. This will
 * prevent problems in case the list formatting is incorrect.
 *
 * @return   string          HTML with success or error message
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

    $upload = new Upload ();
    $upload->setPath($_CONF['path_data']);
    $upload->setAllowedMimeTypes(array('text/plain' => '.txt'));
    $upload->setFileNames('user_import_file.txt');
    if ($upload->uploadFiles()) {
        // Good, file got uploaded, now install everything
        $thefile = current($_FILES);
        $filename = $_CONF['path_data'] . 'user_import_file.txt';
        if (!file_exists($filename)) { // empty upload form
            COM_redirect($_CONF['site_admin_url'] . '/user.php?mode=importform');
        }
    } else {
        // A problem occurred, print debug information
        $retval = COM_showMessageText($upload->printErrors(false), $LANG28[24]);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG28[22]));

        return $retval;
    }

    $users = file($filename);

    $retval .= COM_startBlock($LANG28[31], '',
        COM_getBlockTemplate('_admin_block', 'header'));

    // Following variables track import processing statistics
    $successes = 0;
    $failures = 0;
    foreach ($users as $line) {
        $line = rtrim($line);
        if (empty($line)) {
            continue;
        }

        list ($full_name, $u_name, $email) = explode("\t", $line);

        $full_name = GLText::stripTags($full_name);
        $u_name = COM_applyFilter($u_name);
        $email = COM_applyFilter($email);

        if ($verbose_import) {
            $retval .= "<br" . XHTML . "><b>Working on username=$u_name, fullname=$full_name, and email=$email</b><br" . XHTML . ">\n";
            COM_errorLog("Working on username=$u_name, fullname=$full_name, and email=$email", 1);
        }

        // prepare for database
        $userName = trim($u_name);
        $fullName = trim($full_name);
        $emailAddr = trim($email);

        if (COM_isEmail($email)) {
            // email is valid form
            $ucount = DB_count($_TABLES['users'], 'username',
                DB_escapeString($userName));
            $ecount = DB_count($_TABLES['users'], 'email',
                DB_escapeString($emailAddr));

            if (($ucount == 0) && ($ecount == 0)) {
                // user doesn't already exist - pass in optional true for $batchimport parm
                $uid = USER_createAccount($userName, $emailAddr, '',
                    $fullName, '', '', '', true);

                $result = USER_createAndSendPassword($userName, $emailAddr, $uid);

                if ($result) {
                    $successes++;
                    if ($verbose_import) {
                        $retval .= "<br" . XHTML . "> Account for <b>$u_name</b> created successfully.<br" . XHTML . ">\n";
                        COM_errorLog("Account for $u_name created successfully", 1);
                    }
                } else {
                    // user creation failed
                    $retval .= "<br" . XHTML . ">ERROR: There was a problem creating the account for <b>$u_name</b>.<br" . XHTML . ">\n";
                    COM_errorLog("ERROR: here was a problem creating the account for $u_name.", 1);
                }
            } else {
                if ($verbose_import) {
                    $retval .= "<br" . XHTML . "><b>$u_name</b> or <b>$email</b> already exists, account not created.<br" . XHTML . ">\n"; // user already exists
                    COM_errorLog("$u_name,$email: username or email already exists, account not created", 1);
                }
                $failures++;
            } // end if $ucount == 0 && ecount == 0
        } else {
            if ($verbose_import) {
                $retval .= "<br" . XHTML . "><b>$email</b> is not a valid email address, account not created<br" . XHTML . ">\n"; // malformed email
                COM_errorLog("$email is not a valid email address, account not created", 1);
            }
            $failures++;
        } // end if COM_isEmail($email)
    } // end foreach

    unlink($filename);

    $retval .= '<p>' . sprintf($LANG28[32], $successes, $failures);

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
    $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG28[24]));

    return $retval;
}

/**
 * Display "batch add" (import) form
 *
 * @return   string      HTML for import form
 */
function display_batchAddform()
{
    global $_CONF, $LANG28, $LANG_ADMIN, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    $retval .= COM_startBlock($LANG28[24], '', COM_getBlockTemplate('_admin_block', 'header'));

    $menu_arr = array(
        array('url'  => $_CONF['site_admin_url'] . '/user.php',
              'text' => $LANG28[11]),
        array('url'  => $_CONF['site_admin_url'] . '/user.php?mode=batchdelete',
              'text' => $LANG28[54]),
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']),
    );

    $desc = $LANG28[25];
    $icon = $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE;
    $retval .= ADMIN_createMenu($menu_arr, $desc, $icon);

    $user_template = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/user'));
    $user_template->set_file('batchimport', 'batchimport.thtml');
    $user_template->set_var('lang_file_title', $LANG28[29]);
    $user_template->set_var('lang_import', $LANG28[30]);
    $user_template->set_var('gltoken', SEC_createToken());
    $user_template->set_var('gltoken_name', CSRF_TOKEN);
    $user_template->set_var('end_block', COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer')));
    $retval .= $user_template->finish($user_template->parse('output', 'batchimport'));

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG28[24]));

    return $retval;
}

/**
 * Delete a user
 *
 * @param    int $uid id of user to delete
 * @return   string          HTML redirect
 */
function deleteUser($uid)
{
    global $_CONF;

    if (!USER_deleteAccount($uid)) {
        COM_redirect($_CONF['site_admin_url'] . '/user.php');
    }

    COM_redirect($_CONF['site_admin_url'] . '/user.php?msg=22');
}

// MAIN
$mode = Geeklog\Input::request('mode', '');

if (isset($_POST['delbutton_x'])) {
    $mode = 'batchdeleteexec';
}

if (isset($_REQUEST['order'])) {
    $order = (int) Geeklog\Input::fRequest('order');
}

if (isset($_GET['direction'])) {
    $direction = Geeklog\Input::fGet('direction');
}

if (($mode == $LANG_ADMIN['delete']) && !empty($LANG_ADMIN['delete'])) { // delete
    $uid = (int) Geeklog\Input::fPost('uid');
    if ($uid <= 1) {
        COM_errorLog('Attempted to delete user uid=' . $uid);
        COM_redirect($_CONF['site_admin_url'] . '/user.php');
    } elseif (SEC_checkToken()) {
        $display .= deleteUser($uid);
    } else {
        COM_accessLog("User {$_USER['username']} tried to illegally delete user $uid and failed CSRF checks.");
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    }
} elseif (!empty($LANG_ADMIN['save']) && ($mode == $LANG_ADMIN['save']) && SEC_checkToken()) { // save
    $delphoto = Geeklog\Input::post('delete_photo', '');
    $convertremote = Geeklog\Input::post('convert_remote', '');
    if (!isset($_POST['oldstatus'])) {
        $_POST['oldstatus'] = USER_ACCOUNT_ACTIVE;
    }
    if (!isset($_POST['userstatus'])) {
        $_POST['userstatus'] = USER_ACCOUNT_ACTIVE;
    }

    $uid = (int) Geeklog\Input::fPost('uid');
    if ($uid == 1) {
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    } else {
        $passwd = Geeklog\Input::post('passwd', '');
        $passwd_conf = Geeklog\Input::post('passwd_conf', '');

        $enable_twofactorauth = (int) Geeklog\Input::fPost('enable_twofactorauth', 0);
        if (($enable_twofactorauth !== 0) && ($enable_twofactorauth !== 1)) {
            $enable_twofactorauth = 0;
        }

        $display = saveusers(
            $uid,
            Geeklog\Input::post('username'),
            Geeklog\Input::post('fullname'),
            $passwd, $passwd_conf,
            Geeklog\Input::post('email'),
            Geeklog\Input::post('regdate'),
            Geeklog\Input::post('homepage'),
            Geeklog\Input::post('location'),
			Geeklog\Input::post('postmode'),
            Geeklog\Input::post('sig'),
            Geeklog\Input::post('pgpkey'),
            Geeklog\Input::post('about'),
            Geeklog\Input::post('groups'), $delphoto, $convertremote,
            Geeklog\Input::post('userstatus'),
            Geeklog\Input::post('oldstatus'),
            $enable_twofactorauth
        );
        if (!empty($display)) {
            $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG28[22]));
        }
    }
} elseif ($mode === 'edit') {
    $msg = Geeklog\Input::fGet('msg', '');
    $uid = (int) Geeklog\Input::fGet('uid', 0);
    if ($uid == 1) {
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    }
    $display .= edituser($uid, $msg);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG28[1]));
} elseif (($mode === 'import') && SEC_checkToken()) {
    $display .= importusers();
} elseif ($mode === 'importform') {
    $display .= display_batchAddform();
} elseif ($mode === 'batchdelete') {
    $display .= batchdelete();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG28[54]));
} elseif (($mode == $LANG28[78]) && !empty($LANG28[78]) && SEC_checkToken()) {
    $msg = batchreminders();
    $display .= COM_showMessage($msg) . batchdelete();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG28[11]));
} elseif (($mode === 'batchdeleteexec') && SEC_checkToken()) {
    $msg = batchdeleteexec();
    $display .= COM_showMessage($msg) . batchdelete();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG28[11]));
} else { // 'cancel' or no mode at all
    $display .= COM_showMessageFromParameter();
    $display .= listusers();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG28[11]));
}

COM_output($display);
