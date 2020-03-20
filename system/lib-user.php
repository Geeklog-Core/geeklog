<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-user.php                                                              |
// |                                                                           |
// | User-related functions needed in more than one place.                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2019 by the following authors:                         |
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

use Geeklog\Session;

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-user.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Delete a user account
 *
 * @param    int $uid id of the user to delete
 * @return   boolean   true = user deleted, false = an error occurred
 */
function USER_deleteAccount($uid)
{
    global $_CONF, $_TABLES, $_USER;

    // first some checks ...
    if ((($uid == $_USER['uid']) && ($_CONF['allow_account_delete'] == 1)) ||
        SEC_hasRights('user.delete')
    ) {
        if (SEC_inGroup('Root', $uid)) {
            if (!SEC_inGroup('Root')) {
                // can't delete a Root user without being in the Root group
                COM_accessLog("User {$_USER['uid']} just tried to delete Root user $uid with insufficient privileges.");

                return false;
            } else {
                $rootgrp = DB_getItem($_TABLES['groups'], 'grp_id',
                    "grp_name = 'Root'");
                $result = DB_query("SELECT COUNT(DISTINCT {$_TABLES['users']}.uid) AS count FROM {$_TABLES['users']},{$_TABLES['group_assignments']} WHERE {$_TABLES['users']}.uid > 1 AND {$_TABLES['users']}.uid = {$_TABLES['group_assignments']}.ug_uid AND ({$_TABLES['group_assignments']}.ug_main_grp_id = $rootgrp)");
                $A = DB_fetchArray($result);
                if ($A['count'] <= 1) {
                    // make sure there's at least 1 Root user left
                    COM_errorLog("You can't delete the last user from the Root group.", 1);

                    return false;
                }
            }
        }
    } else {
        // you can only delete your own account (if enabled) or you need
        // proper permissions to do so (user.delete)
        COM_accessLog("User {$_USER['uid']} just tried to delete user $uid with insufficient privileges.");

        return false;
    }

    // log the user out and delete all auto login keys
    SESS_deleteUserSessions($uid);

    // Ok, now delete everything related to this user

    // let plugins update their data for this user
    PLG_deleteUser($uid);

    // remove from all security groups
    DB_delete($_TABLES['group_assignments'], 'ug_uid', $uid);

    // remove user information and preferences
    DB_delete($_TABLES['userprefs'], 'uid', $uid);
    DB_delete($_TABLES['userindex'], 'uid', $uid);
    DB_delete($_TABLES['usercomment'], 'uid', $uid);
    DB_delete($_TABLES['userinfo'], 'uid', $uid);
    DB_delete($_TABLES['backup_codes'], 'uid', $uid);
    DB_delete($_TABLES['likes'], 'uid', $uid);

    // avoid having orphand stories/comments by making them anonymous posts
    DB_query("UPDATE {$_TABLES['comments']} SET uid = 1 WHERE uid = $uid");
    DB_query("UPDATE {$_TABLES['stories']} SET uid = 1 WHERE uid = $uid");
    DB_query("UPDATE {$_TABLES['stories']} SET owner_id = 1 WHERE owner_id = $uid");

    // delete submissions
    DB_delete($_TABLES['storysubmission'], 'uid', $uid);
    DB_delete($_TABLES['commentsubmissions'], 'uid', $uid); // Includes article and plugin submissions

    // delete user photo, if enabled & exists
    if ($_CONF['allow_user_photo'] == 1) {
        $photo = DB_getItem($_TABLES['users'], 'photo', "uid = $uid");
        USER_deletePhoto($photo, false);
    }

    // in case the user owned any objects that require Admin access, assign
    // them to the Root user with the lowest uid
    $rootGroup = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
    $result = DB_query("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootGroup ORDER BY ug_uid LIMIT 1");
    $A = DB_fetchArray($result);
    $rootUser = $A['ug_uid'];

    DB_query("UPDATE {$_TABLES['blocks']} SET owner_id = {$rootUser} WHERE owner_id = {$uid} ");
    DB_query("UPDATE {$_TABLES['topics']} SET owner_id = {$rootUser} WHERE owner_id = {$uid} ");

    // now delete the user itself
    DB_delete($_TABLES['users'], 'uid', $uid);

    return true;
}

/**
 * Create a new password and send it to the user
 *
 * @param    string $username   user's login name
 * @param    string $useremail  user's email address
 * @param    int    $uid        user ID
 * @param    string $email_type
 * @return   boolean            true = success, false = an error occurred
 */
function USER_createAndSendPassword($username, $useremail, $uid, $email_type = '')
{
    global $_CONF, $LANG04;

    $passwd = null;
    SEC_updateUserPassword($passwd, $uid);

    if ($email_type == '' && file_exists($_CONF['path_data'] . 'welcome_email.txt')) {
        $template = COM_newTemplate(CTL_core_templatePath($_CONF['path_data']));
        $template->set_file(array('mail' => 'welcome_email.txt'));
        $template->set_var('auth_info',
            "$LANG04[2]: $username\n$LANG04[4]: $passwd");
        $template->set_var('site_name', $_CONF['site_name']);
        $template->set_var('site_slogan', $_CONF['site_slogan']);
        $template->set_var('lang_text1', $LANG04[15]);
        $template->set_var('lang_text2', $LANG04[14]);
        $template->set_var('lang_username', $LANG04[2]);
        $template->set_var('lang_password', $LANG04[4]);
        $template->set_var('username', $username);
        $template->set_var('password', $passwd);
        $template->set_var('name', COM_getDisplayName($uid));
        $template->parse('output', 'mail');
        $mailtext = $template->get_var('output');
    } else {
        if ($email_type == 'convert_remote') {
            $mailtext = $LANG04['email_convert_remote'] . "\n\n";
        } else {
            $mailtext = $LANG04[15] . "\n\n";
        }
        $mailtext .= $LANG04[2] . ": $username\n";
        $mailtext .= $LANG04[4] . ": $passwd\n\n";
        $mailtext .= $LANG04[14] . "\n\n";
        $mailtext .= $_CONF['site_name'] . "\n";
        $mailtext .= $_CONF['site_url'] . "\n";
    }
    $subject = $_CONF['site_name'] . ': ' . $LANG04[16];
    if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
        $mailfrom = $_CONF['noreply_mail'];
        $mailtext .= LB . LB . $LANG04[159];
    } else {
        $mailfrom = $_CONF['site_mail'];
    }

    return COM_mail($useremail, $subject, $mailtext, $mailfrom);
}

/**
 * Inform a user their account has been activated.
 *
 * @param    string $userName  user's login name
 * @param    string $userEmail user's email address
 * @return   boolean           true = success, false = an error occurred
 */
function USER_sendActivationEmail($userName, $userEmail)
{
    global $_CONF, $LANG04;

    if (file_exists($_CONF['path_data'] . 'activation_email.txt')) {
        $template = COM_newTemplate(CTL_core_templatePath($_CONF['path_data']));
        $template->set_file(array('mail' => 'activation_email.txt'));
        $template->set_var('site_name', $_CONF['site_name']);
        $template->set_var('site_slogan', $_CONF['site_slogan']);
        $template->set_var('lang_text1', $LANG04[15]);
        $template->set_var('lang_text2', $LANG04[14]);
        $template->parse('output', 'mail');
        $mailText = $template->get_var('output');
    } else {
        $mailText = str_replace("<username>", $userName, $LANG04[118]) . "\n\n";
        $mailText .= $_CONF['site_url'] . "\n\n";
        $mailText .= $LANG04[119] . "\n\n";
        $mailText .= $_CONF['site_url'] . "/users.php?mode=getpassword\n\n";
        $mailText .= $_CONF['site_name'] . "\n";
        $mailText .= $_CONF['site_url'] . "\n";
    }
    $subject = $_CONF['site_name'] . ': ' . $LANG04[120];
    if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
        $mailFrom = $_CONF['noreply_mail'];
        $mailText .= LB . LB . $LANG04[159];
    } else {
        $mailFrom = $_CONF['site_mail'];
    }

    return COM_mail($userEmail, $subject, $mailText, $mailFrom);
}

/**
 * Create a new user
 * Also calls the custom user registration (if enabled) and plugin functions.
 * NOTE: Does NOT send out password emails.
 *
 * @param  string  $username    username (mandatory) and needs to be unique without any spaces in the front or trailing
 * @param  string  $email       user's email address (mandatory) and should be unique
 * @param  string  $passwd      password (optional, see above)
 * @param  string  $fullname    user's full name (optional)
 * @param  string  $homepage    user's home page (optional)
 * @param  string  $remoteUserName
 * @param  string  $service
 * @param  boolean $batchImport set to true when called from importuser() in admin/users.php (optional)
 * @return int                     new user's ID
 */
function USER_createAccount($username, $email, $passwd = '', $fullname = '', $homepage = '', $remoteUserName = '', $service = '', $batchImport = false)
{
    global $_CONF, $_TABLES;

    $queueUser = false;

    // username should have had COM_applyFilter (so no punctuation, etc..) and been trimmed of spaces and checked if unique before this as if not this function does not fail gracefully
    // Might as well double check as having spaces and 4 byte characters could cause issues. Better to fail in this function than later in the process
    // If username filters change remember to change same process for remote accounts (like in ouath helper class and doAction function)
    $username = trim(GLText::remove4byteUtf8Chars($username));
    $username = DB_escapeString($username);
    $email = DB_escapeString($email);

    $regdate = strftime('%Y-%m-%d %H:%M:%S', time());
    $fields = 'username,email,regdate,cookietimeout';
    $values = "'$username','$email','$regdate','{$_CONF['default_perm_cookie_timeout']}'";

    if (!empty($passwd)) {
        // Since no uid exists yet we can't use SEC_updateUserPassword and must handle things manually
        $salt = SEC_generateSalt();
        $passwd = SEC_encryptPassword($passwd, $salt, $_CONF['pass_alg'], $_CONF['pass_stretch']);
        $fields .= ',passwd,salt,algorithm,stretch';
        $values .= ",'$passwd','$salt','" . $_CONF['pass_alg'] . "','" . $_CONF['pass_stretch'] . "'";
    }
    if (!empty($fullname)) {
        $fullname = DB_escapeString($fullname);
        $fields .= ',fullname';
        $values .= ",'$fullname'";
    }
    if (!empty($homepage)) {
        $homepage = DB_escapeString($homepage);
        $fields .= ',homepage';
        $values .= ",'$homepage'";
    }
    if (($_CONF['usersubmission'] == 1) && !SEC_hasRights('user.edit')) {
        $queueUser = true;
        if (!empty($_CONF['allow_domains'])) {
            if (USER_emailMatches($email, $_CONF['allow_domains'])) {
                $queueUser = false;
            }
        }
        if ($queueUser) {
            $fields .= ',status';
            $values .= ',' . USER_ACCOUNT_AWAITING_APPROVAL;
        }
    } else {
        if (!empty($remoteUserName)) {
            $fields .= ',remoteusername';
            $values .= ",'$remoteUserName'";
        }
        if (!empty($service)) {
            $fields .= ',remoteservice';
            $values .= ",'$service'";
        }
    }

    DB_query("INSERT INTO {$_TABLES['users']} ($fields) VALUES ($values)");
    // Get the uid of the user, possibly given a service:
    if ($remoteUserName != '') {
        $uid = DB_getItem($_TABLES['users'], 'uid', "remoteusername = '$remoteUserName' AND remoteservice='$service'");
    } else {
        $uid = DB_getItem($_TABLES['users'], 'uid', "username = '$username' AND remoteservice IS NULL");
    }

    // Add user to Logged-in group (i.e. members) and the All Users group
    $normal_grp = DB_getItem($_TABLES['groups'], 'grp_id',
        "grp_name='Logged-in Users'");
    $all_grp = DB_getItem($_TABLES['groups'], 'grp_id',
        "grp_name='All Users'");
    DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($normal_grp, $uid)");
    DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($all_grp, $uid)");

    // any default groups?
    $result = DB_query("SELECT grp_id FROM {$_TABLES['groups']} WHERE grp_default = 1");
    $num_groups = DB_numRows($result);
    for ($i = 0; $i < $num_groups; $i++) {
        list($def_grp) = DB_fetchArray($result);
        DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ($def_grp, $uid)");
    }

    DB_query("INSERT INTO {$_TABLES['userprefs']} (uid) VALUES ($uid)");
    if ($_CONF['emailstoriesperdefault'] == 1) {
        DB_query("INSERT INTO {$_TABLES['userindex']} (uid,etids) VALUES ($uid,'')");
    } else {
        DB_query("INSERT INTO {$_TABLES['userindex']} (uid,etids) VALUES ($uid, '-')");
    }

    DB_query("INSERT INTO {$_TABLES['usercomment']} (uid,commentmode,commentorder,commentlimit) VALUES ($uid,'{$_CONF['comment_mode']}','{$_CONF['comment_order']}','{$_CONF['comment_limit']}')");
    DB_query("INSERT INTO {$_TABLES['userinfo']} (uid) VALUES ($uid)");

    // Call plugins back on user creation
    PLG_createUser($uid);

    // Notify the admin?
    if (isset($_CONF['notification']) && in_array('user', $_CONF['notification'])) {
        $mode = $queueUser ? 'inactive' : 'active';
        $username = COM_getDisplayName($uid, $username, $fullname, $remoteUserName, $service);
        USER_sendNotification($username, $email, $uid, $mode);
    }

    return $uid;
}

/**
 * Send an email notification when a new user registers with the site.
 *
 * @param  string $userName Username of the new user
 * @param  string $email    Email address of the new user
 * @param  int    $uid      User id of the new user
 * @param  string $mode     Mode user was added at.
 * @return boolean             true = success, false = an error occurred
 */
function USER_sendNotification($userName, $email, $uid, $mode = 'inactive')
{
    global $_CONF, $LANG01, $LANG04, $LANG08, $LANG28, $LANG29;

    $mailBody = "$LANG04[2]: $userName\n"
        . "$LANG04[5]: $email\n"
        . "$LANG28[14]: " . strftime($_CONF['date']) . "\n\n";

    if ($mode === 'inactive') {
        // user needs admin approval
        $mailBody .= "{$LANG01[10]}: {$_CONF['site_admin_url']}/moderation.php\n\n";
    } else {
        // user has been created, or has activated themselves:
        $mailBody .= "{$LANG29[4]}: {$_CONF['site_url']}/users.php?mode=profile&uid={$uid}\n\n";
    }
    $mailBody .= "\n------------------------------\n";
    $mailBody .= "\n{$LANG08[34]}\n";
    $mailBody .= "\n------------------------------\n";

    $mailSubject = $_CONF['site_name'] . ' ' . $LANG29[40];

    return COM_mail($_CONF['site_mail'], $mailSubject, $mailBody);
}

/**
 * Send an email notification when invalid logins max is reached.
 *
 * @param  string $userName Username of the new user
 * @param  string $email    Email address of the new user
 * @param  int    $uid      User id of the new user
 * @param  string $mode     Mode user was added at.
 * @return boolean             true = success, false = an error occurred
 */
function USER_sendInvalidLoginAlert($userName, $email, $uid, $mode = 'inactive')
{
    global $_CONF, $LANG04, $LANG08, $LANG29;

    $remoteAddress = $_SERVER['REMOTE_ADDR'];

    $mailBody = "$LANG04[2]: $userName\n"
        . "$LANG04[5]: $email\n";

    $mailBody .= sprintf($LANG29['max_invalid_login_msg'] . "\n\n", $remoteAddress);

    $mailBody .= "{$LANG29[4]}: {$_CONF['site_url']}/users.php?mode=profile&uid={$uid}\n\n";

    $mailBody .= "\n------------------------------\n";
    $mailBody .= "\n{$LANG08[34]}\n";
    $mailBody .= "\n------------------------------\n";

    $mailSubject = $_CONF['site_name'] . ' ' . $LANG29['max_invalid_login'];

    return COM_mail($_CONF['site_mail'], $mailSubject, $mailBody);
}

/**
 * Get a user's photo, either uploaded or from an external service
 * NOTE:     All parameters are optional and can be passed as 0 / empty string.
 *           User Id of 1 will return the default anonymous photo if default set
 *
 * @param    int    $uid   User ID
 * @param    string $photo name of the user's uploaded image
 * @param    string $email user's email address (for gravatar.com)
 * @param    int    $width preferred image width
 * @param    string $cssClasses extra css classes to apply to img
 * @param    string $anonName   If uid = 1 then this anonymous display name will be used
 * @return   string        <img> tag or empty string if no image available
 */
function USER_getPhoto($uid = 0, $photo = '', $email = '', $width = 0, $cssClasses = 'userphoto', $anonName = '')
{
    global $_CONF, $_TABLES, $_USER;

    $userPhoto = '';

    // Older versions of Geeklog and plugins may pass $photo = '(none)'
    // Lets get away from passing this to indicate no user photo. Use an empty string instead
    if ($photo === '(none)') {
        $photo = '';
    }

    if ($_CONF['allow_user_photo'] == 1) {
        if (($width == 0) && !empty($_CONF['force_photo_width'])) {
            $width = $_CONF['force_photo_width'];
        }

        $img = '';

        if ($uid == 1) {
            // For anonymous users
            if (!empty($_CONF['default_photo'])) {
                $img = $_CONF['default_photo'];
            }
        } else {
            // collect user's information with as few SQL requests as possible
            if ($uid == 0) {
                $uid = $_USER['uid'];
                if (empty($email)) {
                    $email = $_USER['email'];
                }
                if (!empty($_USER['photo']) && empty($photo)) {
                    $photo = $_USER['photo'];
                }
            }
             
            if (empty($photo) || (empty($email) && $_CONF['use_gravatar'])) {
                $result = DB_query("SELECT email,photo FROM {$_TABLES['users']} WHERE uid = '{$uid}'");
                list($newEmail, $newPhoto) = DB_fetchArray($result);
                if (empty($photo)) {
                    $photo = $newPhoto;
                }
                if (empty($email)) {
                    $email = $newEmail;
                }
            }

            if (empty($photo)) {
                // no photo - try gravatar.com, if allowed
                if ($_CONF['use_gravatar']) {
                    $img = 'https://www.gravatar.com/avatar/' . md5($email);
                    $params = array();

                    if ($width > 0) {
                        $params[] = 's=' . $width;
                    }

                    if (!empty($_CONF['gravatar_rating'])) {
                        $params[] = 'r=' . $_CONF['gravatar_rating'];
                    }

                    // Since Geeklog-2.1.2
                    if (!empty($_CONF['gravatar_identicon'])) {
                        if (!in_array($_CONF['gravatar_identicon'], array('mm', 'identicon', 'monsterid', 'wavatar', 'retro'))) {
                            $_CONF['gravatar_identicon'] = 'identicon';
                        }

                        $params[] = 'd=' . urlencode($_CONF['gravatar_identicon']);
                    }

                    if (count($params) > 0) {
                        $img .= '?' . implode('&amp;', $params);
                    }
                }
            } else {
                // check if images are inside or outside the document root
                if (strstr($_CONF['path_images'], $_CONF['path_html'])) {
                    $imgPath = substr($_CONF['path_images'], strlen($_CONF['path_html']));
                    $img = $_CONF['site_url'] . '/' . $imgPath . 'userphotos/' . $photo;
                } else {
                    $img = $_CONF['site_url'] . '/getimage.php?mode=userphotos&amp;image=' . $photo;
                }
            }

            if (empty($img) && !empty($_CONF['default_photo'])) {
                $img = $_CONF['default_photo'];
            }
        }

        if (!empty($img)) {
            $displayName = COM_getDisplayName($uid);
            $userPhoto = '<img src="' . $img . '"';
            if ($width > 0) {
                $userPhoto .= ' width="' . $width . '"';
            }
            $userPhoto .= ' alt="" title="' . $displayName . '" class="' . $cssClasses . '"' . XHTML . '>';
        } else {
            $userPhoto = USER_generateUserICON($uid, $width, $cssClasses, $anonName);
        }
    }

    return $userPhoto;
}

/**
 * Generate an icon for a logged-in user who has no profile photo
 *
 * @param   int     $uid
 * @param   int     $width      preferred image width
 * @param   string  $cssClasses extra css classes to apply to img
 * @param   string  $anonName   If uid = 1 then this anonymous display name will be used
 * @return string
 * @see    https://stackoverflow.com/questions/34310271/css-place-in-circle-first-letter-of-the-name
 */
function USER_generateUserICON($uid, $width = 0, $cssClasses = '', $anonName = '')
{
    global $_CONF, $_USER, $LANG03;

    $retval = '';

    if (!isset($_CONF['generate_user_icon']) || !$_CONF['generate_user_icon']) {
        return $retval;
    }

    $uid = (int) $uid;

    if (($uid > 0)) {
        $displayName = COM_getDisplayName($uid);
        if (!empty($displayName)) {
            $letters = '';

            if (MBYTE_strpos($displayName, ' ') !== false) {
                $parts = explode(' ', $displayName, 2);
            //} elseif (MBYTE_strpos($_USER['username'], ' ') !== false) {
            //    $parts = explode(' ', $_USER['username']);
            } else {
                if ($uid == 1) {
                    $parts = [
                        MBYTE_substr($displayName, 0, 1)
                    ];
                } else {
                    $parts = [
                        MBYTE_substr($displayName, 0, 1),
                        MBYTE_substr($displayName, -1)
                    ];
                }
            }

            if ($uid == 1) {
                if (empty($anonName)) {
                    $anonName = $displayName;
                }
                $altText = sprintf($LANG03['anon_user_name'], $anonName);
                $letters = MBYTE_strtoupper(MBYTE_substr($parts[0], 0, 1));
            } else {
                $altText = $displayName;
                $letters = MBYTE_strtoupper(MBYTE_substr($parts[0], 0, 1))
                    . MBYTE_strtoupper(MBYTE_substr($parts[1], 0, 1));
            }
            $letters = htmlspecialchars($letters, ENT_QUOTES, 'utf-8');
            $bg_color = _textToColor($displayName);
            $text_color = _textColorBasedOnBgColor($bg_color, 'FFFFFF', '000000');
            // See https://ui-avatars.com/ for API
            // See https://github.com/LasseRafn/php-initial-avatar-generator and https://github.com/LasseRafn/ui-avatars for github libraries
            $extrasettings = PLG_getThemeItem('core-auto-generated-user-avatar-settings', 'core');
            $retval = '<img src="https://ui-avatars.com/api/?name=' . $letters . '&color=' . $text_color . '&background=' . $bg_color . '&size=' . $_CONF['max_photo_width']
                . $extrasettings . '"  alt="" title="' . $altText . '" class="' . $cssClasses . '"';
            if ($width > 0) {
                // Since a square is returned set height as well
                $retval .= ' width="' . $width . '" height="' . $width . '"';
            }
            $retval .= XHTML . '>';
        }
    }

    return $retval;
}

/**
 * Figures out text color to display on a specific RBG background color
 * Note: This function starts with _ therefore it is only meant to be called from within the user library for a specific task
 *
 * @param  string $bgColor      hexadecimal background color
 * @param  string $lightColor   Light text color to use
 * @param  string $darkColor    Dark text color to use
 * @return string               hexadecimal color to use
 */
function _textColorBasedOnBgColor($bgColor, $lightColor, $darkColor)
{
    $color = (substr($bgColor, 0, 1) === '#') ? substr($bgColor, 1, 7) : $bgColor;
    $r = hexdec(substr($color, 0, 2)); // hexToR
    $g = hexdec(substr($color, 2, 2)); // hexToG
    $b = hexdec(substr($color, 4, 2)); // hexToB
    $retval = ((($r * 0.299) + ($g * 0.587) + ($b * 0.114)) > 186) ? $darkColor : $lightColor;

    return $retval;
}

/**
 * Converts text to a corresponding RGB color
 * Note: This function starts with _ therefore it is only meant to be called from within the user library for a specific task
 *
 * @param  string $text
 * @return string           hexadecimal color to use
 */
function _textToColor($text)
{
    // random color
    $rgb = substr(dechex(crc32($text)), 0, 6);

    // make it darker
    $darker = 1; // 1 means leave it, 2 will darken so text is always light
    list($R16, $G16, $B16) = str_split($rgb, 2);
    $R = sprintf('%02X', floor(hexdec($R16) / $darker));
    $G = sprintf('%02X', floor(hexdec($G16) / $darker));
    $B = sprintf('%02X', floor(hexdec($B16) / $darker));
    return $R . $G . $B;
}

/**
 * Delete a user's photo (i.e. the actual file)
 * NOTE:     Will silently ignore non-existing files.
 *
 * @param    string  $photo        name of the photo (without the path)
 * @param    boolean $abortOnError true: abort script on error, false: don't
 * @return   void
 */
function USER_deletePhoto($photo, $abortOnError = true)
{
    global $_CONF, $LANG04;

    if (!empty($photo)) {
        $fileToDelete = $_CONF['path_images'] . 'userphotos/' . $photo;
        if (file_exists($fileToDelete)) {
            if (!@unlink($fileToDelete)) {
                if ($abortOnError) {
                    $display = COM_errorLog("Unable to remove file $photo");
                    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG04[21]));
                    echo $display;
                    exit;
                } else {
                    // just log the problem, but don't abort
                    COM_errorLog("Unable to remove file {$photo}");
                }
            }
        }
    }
}

/**
 * Convert a user account from remote to local.
 * If user status is active and a email address exists then a new password email will be sent
 *
 * @param    int        $uid    User id
 * @return   int                0 = Problems, not converted
 *                              1 = User account converted successfully
 *                              2 = User account converted successfully and email sent with password info
 */
function USER_convertRemote($uid)
{
    global $_TABLES;

    $remote_grp = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Remote Users'");

    // Find all Google accounts
    $sql = "SELECT status, username, email, remoteusername, remoteservice FROM {$_TABLES['users']} WHERE uid = $uid";
    $result = DB_query($sql);
    $numRows = DB_numRows($result);
    if ($numRows == 1) {
        list($status, $username, $email, $remoteusername, $remoteservice) = DB_fetchArray($result);
        // Confirm actually a remote account
        if (!empty($remoteusername) || !empty($remoteservice)) {
            // Remove them from remote accounts group
            DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $remote_grp AND ug_uid = $uid");

            // If user account is active and has no email then it cannot function as a regular account so lock it
            // Cannot set status to USER_ACCOUNT_NEW_EMAIL since user doesn't know his password as a new one is being created
            if ($status == USER_ACCOUNT_ACTIVE && empty($email)) {
                $status = USER_ACCOUNT_LOCKED;
            }
            // If account looking for new email then lock it since user does not know password and admin has deemed email to be invalid
            if ($status == USER_ACCOUNT_NEW_EMAIL) {
                $status = USER_ACCOUNT_LOCKED;
            }

            // Add null to remoteusername and remoteservice
            $sql = "UPDATE {$_TABLES['users']} SET
            remoteusername = NULL, remoteservice = NULL, status = $status
            WHERE uid = $uid";
            DB_query($sql);

            // Update user with random password
            if ($status == USER_ACCOUNT_ACTIVE && !empty($email)) {
                USER_createAndSendPassword($username, $email, $uid, 'convert_remote');

                return 1; // Account converted NO email sent
            } else {
                $passwd = NULL; //Pass null so random will be created
                SEC_updateUserPassword($passwd, $uid);

                return 2; // Account converted and email sent
            }
        }
    }

    return 0;
}

/**
 * Add user to group if user does not belong to specified group
 * This is part of the Geeklog user implementation. This function
 * looks up whether a user belongs to a specified group and if not
 * adds them to the group
 *
 * @param        int $groupId Group we want to see if user belongs to and if not add to group
 * @param        int $uid     ID for user to check if in group and if not add user. If empty current user.
 * @return       boolean     true if user is added to group, otherwise false
 */
function USER_addGroup($groupId, $uid = 0)
{
    global $_TABLES, $_USER;

    // set $uid if $uid is empty
    if (empty($uid)) {
        // bail for anonymous users
        if (COM_isAnonUser()) {
            return false;
        } else {
            // If logged in set to current uid
            $uid = $_USER['uid'];
        }
    }

    if (($groupId < 1) || SEC_inGroup($groupId, $uid)) {
        return false;
    } else {
        DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid) VALUES ('{$groupId}', {$uid})");

        return true;
    }
}

/**
 * Delete from group if user belongs to specified group
 * This is part of the Geeklog user implementation. This function
 * looks up whether a user belongs to a specified group and if so
 * removes them from the group
 *
 * @param        int $groupId Group we want to see if user belongs to and if so delete user from group
 * @param        int $uid     ID for user to delete. If empty current user.
 * @return       boolean      true if user is removed from group, otherwise false
 */
function USER_delGroup($groupId, $uid = 0)
{
    global $_TABLES, $_USER;

    // set $uid if $uid is empty
    if (empty($uid)) {
        // bail for anonymous users
        if (COM_isAnonUser()) {
            return false;
        } else {
            // If logged in set to current uid
            $uid = $_USER['uid'];
        }
    }

    if (($groupId > 0) && SEC_inGroup($groupId, $uid)) {
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = {$groupId} AND ug_uid = {$uid}");

        return true;
    } else {
        return false;
    }
}

/**
 * Check email address against a list of domains
 * Checks if the given email's domain part matches one of the entries in a
 * comma-separated list of domain names (regular expressions are allowed).
 *
 * @param    string $email       email address to check
 * @param    string $domain_list list of domain names
 * @return   boolean                 true if match found, otherwise false
 */
function USER_emailMatches($email, $domain_list)
{
    $match_found = false;

    if (!empty($domain_list)) {
        $domains = explode(',', $domain_list);

        // Note: We should already have made sure that $email is a valid address
        $email_domain = substr($email, strpos($email, '@') + 1);

        foreach ($domains as $domain) {
            $domain = trim($domain);    // To fix bug #0001701

            if (preg_match("#{$domain}#i", $email_domain)) {
                $match_found = true;
                break;
            }
        }
    }

    return $match_found;
}

/**
 * Convert the accents to their non-accented counter part. Case insensitive
 * Note: This function starts with _ therefore it is only meant to be called from within the user library for a specific task
 *       Function meant to be used for php when comparing for example user names to make sure they are unique
 * From: https://stackoverflow.com/questions/27680624/compare-two-string-and-ignore-but-not-replace-accents-php
 *
 * @param  string $text
 * @return string           hexadecimal color to use
 */
function _removeAccents($text)
{
    return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'))), ' '));
}

/**
 * Ensure unique username across all services (remote or local)
 * Checks that $username does not exist yet and creates a new unique username
 * (based off of $username) if necessary.
 * Mostly useful for creating accounts for remote users.
 *
 * @param    string $username initial username
 * @return   string           unique username
 * @todo     Bugs: Race conditions apply ...
 */
function USER_uniqueUsername($username)
{
    global $_TABLES;

    // username should have had COM_applyFilter (so no punctuation, etc..) and been trimmed of spaces, BUT lets double check
    $username = trim(GLText::remove4byteUtf8Chars($username));

    if (function_exists('CUSTOM_uniqueUsername')) {
        return CUSTOM_uniqueUsername($username);
    }

    $try = $username;
    do {
        $try = DB_escapeString($try);
        // Usernames need to be trimmed and checked as lower case
        // Remember some database collations are case and accent insensitive and some are not. They would consider "nina", "nina  ", "Nina", and, "niña" as the same
        $uid = DB_getItem($_TABLES['users'], 'uid', "TRIM(LOWER(username)) = TRIM(LOWER('$try'))");
        if (!empty($uid)) {
            $r = rand(2, 9999);
            if (strlen($username) > 12) {
                $try = sprintf('%s%d', substr($username, 0, 12), $r);
            } else {
                $try = sprintf('%s%d', $username, $r);
            }
        }
    } while (!empty($uid));

    return $try;
}

/**
 * Used to return an array of groups that a base group contains
 * GL supports hierarchical groups and this will return all the child groups
 *
 * @param    int $groupId Group id to get list of groups for
 * @return   array        Array of child groups
 */
function USER_getChildGroups($groupId)
{
    global $_TABLES;

    $to_check = array();
    array_push($to_check, $groupId);
    $groups = array();

    while (count($to_check) > 0) {
        $thisGroup = array_pop($to_check);
        if ($thisGroup > 0) {
            $result = DB_query("SELECT ug_grp_id FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = {$thisGroup}");
            $numGroups = DB_numRows($result);
            for ($i = 0; $i < $numGroups; $i++) {
                $A = DB_fetchArray($result);
                if (!in_array($A['ug_grp_id'], $groups)) {
                    if (!in_array($A['ug_grp_id'], $to_check)) {
                        array_push($to_check, $A['ug_grp_id']);
                    }
                }
            }
            $groups[] = $thisGroup;
        }
    }

    return $groups;
}

/**
 * Subscribe user to a topic (for the Daily Digest)
 *
 * @param    string $tid Topic ID
 */
function USER_subscribeToTopic($tid)
{
    global $_CONF, $_TABLES, $_USER;

    if ($_CONF['emailstories'] == 0) {
        return;
    }

    if (COM_isAnonUser()) {
        return;
    }

    if (!SEC_hasTopicAccess($tid)) {
        return;
    }

    $user_etids = DB_getItem($_TABLES['userindex'], 'etids',
        "uid = {$_USER['uid']}");
    if (empty($user_etids)) {
        return; // already subscribed to all topics
    }

    if ($user_etids == '-') {
        $user_etids = $tid; // first topic user subscribed to
    } else {
        $eTids = explode(' ', $user_etids);
        if (in_array($tid, $eTids)) {
            return; // already subscribed
        }
        $eTids[] = $tid;
        $user_etids = implode(' ', $eTids);
    }
    $user_etids = DB_escapeString($user_etids);

    DB_query("UPDATE {$_TABLES['userindex']} SET etids = '{$user_etids}' WHERE uid = {$_USER['uid']}");
}

/**
 * Unsubscribe user from a topic (for the Daily Digest)
 *
 * @param    string $tid Topic ID
 */
function USER_unsubscribeFromTopic($tid)
{
    global $_CONF, $_TABLES, $_USER;

    if ($_CONF['emailstories'] == 0) {
        return;
    }

    if (COM_isAnonUser()) {
        return;
    }

    // no check for SEC_hasTopicAccess here to unsubscribe user "just in case"
    $user_etids = DB_getItem($_TABLES['userindex'], 'etids', "uid = {$_USER['uid']}");
    if ($user_etids == '-') {
        return; // not subscribed to any topics
    }

    if (empty($user_etids)) {
        // subscribed to all topics - get list
        $etids = USER_getAllowedTopics();
    } else {
        $etids = explode(' ', $user_etids);
    }

    $key = array_search($tid, $etids);
    if ($key === false) {
        return; // not subscribed to this topic
    }

    unset($etids[$key]);

    if (count($etids) == 0) {
        $user_etids = '-';
    } else {
        $user_etids = implode(' ', $etids);
    }
    $user_etids = DB_escapeString($user_etids);

    DB_query("UPDATE {$_TABLES['userindex']} SET etids = '$user_etids' WHERE uid = {$_USER['uid']}");
}

/**
 * Check if user is subscribed to a topic
 *
 * @param    string $tid Topic ID
 * @return   boolean     true: subscribed, false: not subscribed
 */
function USER_isSubscribedToTopic($tid)
{
    global $_CONF, $_TABLES, $_USER;

    if ($_CONF['emailstories'] == 0) {
        return false;
    }

    if (COM_isAnonUser()) {
        return false;
    }

    if (!SEC_hasTopicAccess($tid)) {
        return false;
    }

    $user_etids = DB_getItem($_TABLES['userindex'], 'etids',
        "uid = {$_USER['uid']}");
    if (empty($user_etids)) {
        return true; // subscribed to all topics
    } elseif ($user_etids == '-') {
        return false; // not subscribed to any topics
    }

    $eTids = explode(' ', $user_etids);

    return in_array($tid, $eTids);
}

/**
 * Get topics the current user has access to
 *
 * @return   array   Array of topic IDs
 */
function USER_getAllowedTopics()
{
    global $_TABLES;

    $topics = array();

    $result = DB_query("SELECT tid FROM {$_TABLES['topics']}");
    $numRows = DB_numRows($result);
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);
        if (SEC_hasTopicAccess($A['tid'])) {
            $topics[] = $A['tid'];
        }
    }

    return $topics;
}

/**
 * Return if the current user can send email to the user
 *
 * @param  int   $toUid
 * @return bool  true if the current user can send email to the user
 */
function USER_isCanSendMail($toUid = 0)
{
    global $_CONF, $_TABLES;

    $retval = false;

    // Anonymous users cannot send email at this site
    if (($_CONF['loginrequired'] || $_CONF['emailuserloginrequired']) && COM_isAnonUser()) {
        return $retval;
    }

    $toUid = (int) $toUid;

    if ($toUid > 1) {
        $sql = "SELECT emailfromadmin, emailfromuser FROM {$_TABLES['userprefs']} "
            . "WHERE (uid = {$toUid})";
        $result = DB_query($sql);

        if (!DB_error()) {
            $A = DB_fetchArray($result, false);
            $retval = (bool) $A['emailfromuser'] || ((bool) $A['emailfromadmin'] && SEC_inGroup('Root'));
        }
    }

    return $retval;
}

/**
 * Shows a profile for a user
 * This grabs the user profile for a given user and displays it
 *
 * @param    int     $uid     User ID of profile to get
 * @param    boolean $preview whether being called as preview from My Account
 * @param    int     $msg     Message to display (if != 0)
 * @param    string  $plugin  optional plugin name for message
 * @return   string           HTML for user profile page
 */
function USER_showProfile($uid, $preview = false, $msg = 0, $plugin = '')
{
    global $_CONF, $_TABLES, $_USER, $_IMAGE_TYPE,
           $LANG01, $LANG04, $LANG09, $LANG28, $LANG_LOGIN, $LANG_ADMIN;

    $retval = '';

    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) || ($_CONF['profileloginrequired'] == 1))) {
        $retval .= SEC_loginRequiredForm();
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG_LOGIN[1]));

        return $retval;
    }

    $result = DB_query("SELECT {$_TABLES['users']}.uid,username,fullname,regdate,homepage,about,location,pgpkey,photo,email,status,postmode FROM {$_TABLES['userinfo']},{$_TABLES['users']} WHERE {$_TABLES['userinfo']}.uid = {$_TABLES['users']}.uid AND {$_TABLES['users']}.uid = $uid");
    $numRows = DB_numRows($result);
    if ($numRows == 0) { // no such user
        COM_handle404();
    }
    $A = DB_fetchArray($result);

    if ($A['status'] == USER_ACCOUNT_DISABLED && !SEC_hasRights('user.edit')) {
        COM_displayMessageAndAbort(30, '', 403, 'Forbidden');
    }

    // Profile still viewable under the following user statuses
    if (($A['status'] != USER_ACCOUNT_ACTIVE && $A['status'] != USER_ACCOUNT_LOCKED && $A['status'] != USER_ACCOUNT_NEW_EMAIL && $A['status'] != USER_ACCOUNT_NEW_PASSWORD) && !SEC_hasRights('user.edit')) {
        COM_handle404();
    }

    $display_name = COM_getDisplayName($uid, $A['username'], $A['fullname']);
    $display_name = htmlspecialchars($display_name);

    if (!$preview) {
        if ($msg > 0) {
            $retval .= COM_showMessage($msg, $plugin);
        }

        $systemMessages = COM_getSystemMessages();
        foreach ($systemMessages as $systemMessage) {
            if (!empty($systemMessage)) {
                $retval .= COM_showMessageText($systemMessage);
            }
        }
    }

    // format date/time to user preference
    $currentTime = COM_getUserDateTimeFormat($A['regdate']);
    $A['regdate'] = $currentTime[0];

    $user_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'users'));
    $user_templates->set_file(array(
        'profile' => 'profile.thtml'
    ));

    $blocks = array('display_field', 'field_statistic', 'last10_block', 'last10_row');
    foreach ($blocks as $block) {
        $user_templates->set_block('profile', $block);
    }

    $user_templates->set_var('start_block_userprofile', COM_startBlock($LANG04[1] . ' ' . $display_name));
    $user_templates->set_var('end_block', COM_endBlock());
    $user_templates->set_var('lang_username', $LANG04[2]);

    if ($_CONF['show_fullname'] == 1) {
        if (empty($A['fullname'])) {
            $userName = $A['username'];
            $fullName = '';
        } else {
            $userName = $A['fullname'];
            $fullName = $A['username'];
        }
    } else {
        $userName = $A['username'];
        $fullName = $A['fullname'];
    }
    $userName = htmlspecialchars($userName);
    $fullName = htmlspecialchars($fullName);

    if ($A['status'] == USER_ACCOUNT_DISABLED) {
        $userName = sprintf('<s title="%s">%s</s>', $LANG28[42], $userName);
        if (!empty($fullName)) {
            $fullName = sprintf('<s title="%s">%s</s>', $LANG28[42], $fullName);
        }
    }

    $user_templates->set_var('username', $userName);
    $user_templates->set_var('user_fullname', $fullName);

    if ($preview) {
        $user_templates->set_var('edit_icon', '');
        $user_templates->set_var('edit_link', '');
        $user_templates->set_var('user_edit', '');
    } elseif (!COM_isAnonUser() && ($_USER['uid'] == $uid)) {
        $edit_icon = '<img src="' . $_CONF['layout_url'] . '/images/edit.'
            . $_IMAGE_TYPE . '" alt="' . $LANG01[48]
            . '" title="' . $LANG01[48] . '"' . XHTML . '>';
        $edit_link_url = COM_createLink($edit_icon, $_CONF['site_url'] . '/usersettings.php');
        $user_templates->set_var('edit_icon', $edit_icon);
        $user_templates->set_var('edit_link', $edit_link_url);
        $user_templates->set_var('user_edit', $edit_link_url);
    } elseif (SEC_hasRights('user.edit')) {
        $edit_icon = '<img src="' . $_CONF['layout_url'] . '/images/edit.'
            . $_IMAGE_TYPE . '" alt="' . $LANG_ADMIN['edit']
            . '" title="' . $LANG_ADMIN['edit'] . '"' . XHTML . '>';
        $edit_link_url = COM_createLink($edit_icon, "{$_CONF['site_admin_url']}/user.php?mode=edit&amp;uid={$A['uid']}");
        $user_templates->set_var('edit_icon', $edit_icon);
        $user_templates->set_var('edit_link', $edit_link_url);
        $user_templates->set_var('user_edit', $edit_link_url);
    }

    $photo = USER_getPhoto($uid, $A['photo'], $A['email'], -1);
    $user_templates->set_var('user_photo', $photo);

    $user_templates->set_var('lang_membersince', $LANG04[67]);
    $user_templates->set_var('user_regdate', $A['regdate']);
    $user_templates->set_var('lang_email', $LANG04[5]);
    $user_templates->set_var('user_id', $uid);
    $user_templates->set_var('uid', $uid);

    if (!empty($A['email']) && USER_isCanSendMail($uid) && ($A['status'] == USER_ACCOUNT_ACTIVE || $A['status'] == USER_ACCOUNT_NEW_PASSWORD)) {
        $user_templates->set_var('lang_sendemail', $LANG04[81]);
        $user_templates->set_var('email_option', true);
    } else {
        $user_templates->set_var('email_option', false);
    }

    $user_templates->set_var('lang_homepage', $LANG04[6]);
    $user_templates->set_var('user_homepage', COM_killJS($A['homepage']));
    $user_templates->set_var('lang_location', $LANG04[106]);
    $user_templates->set_var('user_location', GLText::stripTags($A['location']));
    $user_templates->set_var('lang_bio', $LANG04[7]);
    $user_templates->set_var(
        'user_bio',
        GLText::getDisplayText(stripslashes($A['about']), $A['postmode'], GLTEXT_LATEST_VERSION)
    );
    $user_templates->set_var('lang_pgpkey', $LANG04[8]);
    $user_templates->set_var('user_pgp', COM_nl2br($A['pgpkey']));


    $user_templates->set_var('start_block_postingstats', COM_startBlock($LANG04[83] . ' ' . $display_name));
    $user_templates->set_var('lang_title', $LANG09[16]);
    $user_templates->set_var('lang_date', $LANG09[17]);

    // for alternative layouts: use these as headlines instead of block titles
    $user_templates->set_var('headline_last10stories', $LANG04[82]);
    $user_templates->set_var('headline_last10comments', $LANG04[10]);
    $user_templates->set_var('headline_postingstats', $LANG04[83]);

    $tids = TOPIC_getList(0, true, false);
    $topics = "'" . implode("','", $tids) . "'";

    // list of last 10 stories by this user
    if (count($tids) > 0) {
        $sql = "SELECT sid,title,UNIX_TIMESTAMP(date) AS unixdate
            FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
            WHERE (uid = $uid) AND (draft_flag = 0) AND (date <= NOW()) AND (tid IN ($topics))" . COM_getPermSQL('AND') . "
            AND ta.type = 'article' AND ta.id = sid AND ta.tdefault = 1
            ORDER BY unixdate DESC LIMIT 10";

        $result = DB_query($sql);
        $numRows = DB_numRows($result);
    } else {
        $numRows = 0;
    }

    $user_templates->set_var('start_block_last10', COM_startBlock($LANG04[82] . ' ' . $display_name));
    $user_templates->set_var('end_block', COM_endBlock());
    if ($numRows > 0) {
        for ($i = 0; $i < $numRows; $i++) {
            $C = DB_fetchArray($result);
            $user_templates->set_var('cssid', ($i % 2) + 1);
            $user_templates->set_var('row_number', ($i + 1) . '.');
            $articleUrl = COM_buildURL($_CONF['site_url'] . '/article.php?story=' . $C['sid']);
            $user_templates->set_var('article_url', $articleUrl);
            $C['title'] = str_replace('$', '&#36;', $C['title']);
            $user_templates->set_var('item_title',
                COM_createLink(
                    stripslashes($C['title']),
                    $articleUrl,
                    array('class' => 'b'))
            );
            $storyTime = COM_getUserDateTimeFormat($C['unixdate']);
            $user_templates->set_var('item_date', $storyTime[0]);

            if ($i == 0) {
                $user_templates->parse('last10_rows', 'last10_row');
            } else {
                $user_templates->parse('last10_rows', 'last10_row', true);
            }
        }
    } else {
        $story_row = $LANG01[37];
        $user_templates->set_var('last10_rows', $story_row);
    }
    $user_templates->parse('last10_blocks', 'last10_block', true);

    $user_templates->set_var('start_block_last10', COM_startBlock($LANG04[10] . ' ' . $display_name));
    $user_templates->set_var('end_block', COM_endBlock());
    // list of last 10 comments by this user
    $new_plugin_comments = PLG_getWhatsNewComment('', 10, $uid);

    if (!empty($new_plugin_comments)) {
        // Sort array by element lastdate newest to oldest
        foreach ($new_plugin_comments as $k => $v) {
            $b[$k] = strtolower($v['unixdate']);
        }
        arsort($b);
        foreach ($b as $key => $val) {
            $temp[] = $new_plugin_comments[$key];
        }
        $new_plugin_comments = $temp;

        $i = 0;
        foreach ($new_plugin_comments as $C) {
            $i = $i + 1;
            $user_templates->set_var('cssid', ($i % 2));
            $user_templates->set_var('row_number', ($i) . '.');
            $C['title'] = str_replace('$', '&#36;', $C['title']);
            $comment_url = $_CONF['site_url'] . '/comment.php?mode=view&amp;cid=' . $C['cid'];
            $user_templates->set_var(
                'item_title',
                COM_createLink(
                    stripslashes($C['title']),
                    $comment_url,
                    array('class' => 'b')
                )
            );
            $commentTime = COM_getUserDateTimeFormat($C['unixdate']);
            $user_templates->set_var('item_date', $commentTime[0]);
            //$user_templates->parse('item_row', 'row', true);

            if ($i == 1) {
                $user_templates->parse('last10_rows', 'last10_row');
            } else {
                $user_templates->parse('last10_rows', 'last10_row', true);
            }

            if ($i == 10) {
                break;
            }
        }
    } else {
        $comment_row = $LANG01[29];
        $user_templates->set_var('last10_rows', $comment_row);
    }
    $user_templates->parse('last10_blocks', 'last10_block', true);

    // posting stats for this user
    $user_templates->set_var('lang_number_field', $LANG04[84]);
    $sql = "SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE (uid = $uid) AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL('AND');
    $result = DB_query($sql);
    $N = DB_fetchArray($result);
    $user_templates->set_var('number_field', COM_numberFormat($N['count']));
    $user_templates->parse('field_statistics', 'field_statistic', true);

    $user_templates->set_var('lang_number_field', $LANG04[85]);
    $sql = "SELECT COUNT(*) AS count FROM {$_TABLES['comments']} WHERE (uid = $uid)";
    $result = DB_query($sql);
    $N = DB_fetchArray($result);
    $user_templates->set_var('number_field', COM_numberFormat($N['count']));
    $user_templates->parse('field_statistics', 'field_statistic', true);

    $user_templates->set_var('lang_all_postings_by', $LANG04[86] . ' ' . $display_name);

    // Call custom registration function if enabled and exists
    if ($_CONF['custom_registration'] && function_exists('CUSTOM_userDisplay')) {
        $user_templates->set_var('customfields', CUSTOM_userDisplay($uid));
    }

    // See if other plugins want to add any extra profile informaiton
    PLG_profileVariablesDisplay($uid, $user_templates);

    $user_templates->parse('output', 'profile');
    $retval .= $user_templates->finish($user_templates->get_var('output'));
    $retval .= PLG_profileBlocksDisplay($uid);

    if (!$preview) {
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG04[1] . ' ' . $display_name));
    }

    return $retval;
}

/**
 * Implements the [user:] autotag.
 *
 * @param  string $op      operation to perform
 * @param  string $content item (e.g. story text), including the autotag
 * @param  array  $autotag parameters used in the autotag
 * @return mixed           tag names (for $op='tagname') or formatted content
 */
function plugin_autotags_user($op, $content = '', $autotag = array())
{
    global $_CONF, $_TABLES, $LANG28, $_GROUPS;

    if ($op === 'tagname') {
        return 'user';
    } elseif ($op === 'permission' || $op === 'nopermission') {
        if ($op === 'permission') {
            $flag = true;
        } else {
            $flag = false;
        }
        $tagNames = array();

        if (isset($_GROUPS['User Admin'])) {
            $group_id = $_GROUPS['User Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'User Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();

        if (COM_getPermTag($owner_id, $group_id, $_CONF['autotag_permissions_user'][0], $_CONF['autotag_permissions_user'][1], $_CONF['autotag_permissions_user'][2], $_CONF['autotag_permissions_user'][3]) == $flag) {
            $tagNames[] = 'user';
        }

        if (count($tagNames) > 0) {
            return $tagNames;
        }
    } elseif ($op === 'description') {
        return array(
            'user' => $LANG28['autotag_desc_user'],
        );
    } elseif ($op === 'parse') {
        $uName = COM_applyFilter($autotag['parm1']);
        $uName = DB_escapeString($uName);
        $sql = "SELECT uid, username, fullname, status FROM {$_TABLES['users']} WHERE username = '{$uName}'";
        $result = DB_query($sql);
        if (DB_numRows($result) == 1) {
            $A = DB_fetchArray($result);
            $linkText = $autotag['parm2'] ?: COM_getDisplayName($A['uid'], $A['username'], $A['fullname']);
            $link = COM_getProfileLink($A['uid'], $linkText, $A['fullname'], '', '');
            $content = str_replace($autotag['tagstr'], $link, $content);
        }

        return $content;
    } else {
        return '';
    }
}

/**
 * User required to confirm new email address - send email with a link and confirm id
 *
 * @return string           form or meta redirect for users of status USER_ACCOUNT_NEW_EMAIL
 */
function USER_emailConfirmation($email)
{
    global $_CONF, $_TABLES, $LANG04, $_USER;

    $retval = '';

    $uid = $_USER['uid'];

    if ($uid > 1) {
        $result = DB_query("SELECT uid,email,emailconfirmid,status FROM {$_TABLES['users']} WHERE uid = $uid");
        $numRows = DB_numRows($result);
        if ($numRows == 1) {
            $A = DB_fetchArray($result);
            if ($A['status'] != USER_ACCOUNT_NEW_EMAIL && $A['status'] != USER_ACCOUNT_ACTIVE) {
                COM_redirect($_CONF['site_url'] . '/index.php?msg=30');
            }
            $emailconfirmid = substr(md5(uniqid(rand(), 1)), 1, 16);
            DB_change($_TABLES['users'], 'emailconfirmid', "$emailconfirmid", 'uid', $uid);
            DB_change($_TABLES['users'], 'emailtoconfirm', "$email", 'uid', $uid);

            $mailtext = sprintf($LANG04['email_msg_email_status_1'], $_USER['username']);
            $mailtext .= $_CONF['site_url'] . '/users.php?mode=newemailstatus&uid=' . $uid . '&ecid=' . $emailconfirmid . "\n\n";
            $mailtext .= $LANG04['email_msg_email_status_2'];
            $mailtext .= "{$_CONF['site_name']}\n";
            $mailtext .= "{$_CONF['site_url']}\n";

            $subject = $_CONF['site_name'] . ': ' . $LANG04[16];
            if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
                $mailfrom = $_CONF['noreply_mail'];
                $mailtext .= LB . LB . $LANG04[159];
            } else {
                $mailfrom = $_CONF['site_mail'];
            }
            if (COM_mail($email, $subject, $mailtext, $mailfrom)) {
                if ($A['status'] == USER_ACCOUNT_ACTIVE) {
                    // Being called by usersettings.php so just return true on success
                    return true;
                } else {
                    // Being called by users.php
                    $redirect = $_CONF['site_url'] . "/users.php?mode=logout&msg=501";
                }
            } else {
                if ($A['status'] == USER_ACCOUNT_ACTIVE) {
                    // Being called by usersettings.php
                    return false;
                } else {
                    // Being called by users.php
                    // problem sending the email
                    $redirect = $_CONF['site_url'] . "/users.php?mode=newemailstatus&msg=85";
                }
            }

            // Email sent so to confirm new email address so now logoff and tell user go check inbox
            COM_redirect($redirect);
        } else {
            if ($A['status'] == USER_ACCOUNT_ACTIVE) {
                // Being called by usersettings.php
                return false;
            } else {
                // Something else is wrong here so bail
                COM_redirect($_CONF['site_url'] . '/users.php?msg=43');
            }
        }
    }

    return $retval;
}

/**
 * Check if the email address given is valid for a new user
 *
 * @param  string $email  an email address
 * @return bool           true if valid email address, false otherwise
 */
function USER_isValidEmailAddress($email)
{
    global $_CONF, $_TABLES;

    $email = trim($email);
    if ($email === '') {
        return false;
    }

    // Valid as an email address?
    if (!COM_isEmail($email)) {
        return false;
    }

    // In disallowed domains?
    if (USER_emailMatches($email, $_CONF['disallow_domains'])) {
        return false;
    }

    // Anonymous function to make an email address uniform
    $emailMutator = function ($email) {
        $email = strtolower($email);
        $parts = explode('@', $email, 2);

        // Additional check for Gmail.  See Issue #918
        if (isset($parts[1]) && $parts[1] === 'gmail.com') {
            // Ignore all dots '.' and anything after plus sign '+'
            $parts[0] = str_replace('.', '', $parts[0]);
            $plusSign = strpos($parts[0], '+');
            if ($plusSign !== false) {
                $parts[0] = substr($parts[0], 0, $plusSign);
            }
            $email = $parts[0] . '@gmail.com';
        }

        return $email;
    };

    $email = $emailMutator($email);

    // Check database for a similar email address
    $sql = "SELECT email FROM {$_TABLES['users']}";
    $result = DB_query($sql);
    if (DB_error()) {
        return false;
    }

    while (($A = DB_fetchArray($result, false)) !== false) {
        if ($email === $emailMutator($A['email'])) {
            return false;
        }
    }

    return true;
}

/**
 * Return if the user is banned
 *
 * @param  int $uid user id.  Specify 0 in case of the current user
 * @return bool
 */
function USER_isBanned($uid = 0)
{
    global $_TABLES, $_USER;

    $uid = (int) $uid;
    if ($uid < 1) {
        $uid = (int) $_USER['uid'];
    }

    if ($uid < 1) {
        return true;
    } elseif ($uid === 1) {
        return false;
    } else {
        $sql = "SELECT status FROM {$_TABLES['users']} WHERE uid = {$uid}";
        $result = DB_query($sql);

        if (DB_error() || (DB_numRows($result) == 0)) {
            return true;
        }

        $A = DB_fetchArray($result, false);
        $status = (int) $A['status'];

        return ($status == USER_ACCOUNT_DISABLED);
    }
}
