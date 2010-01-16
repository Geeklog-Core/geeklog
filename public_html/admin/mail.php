<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | mail.php                                                                  |
// |                                                                           |
// | Geeklog mail administration page.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2001-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs - tony AT tonybibbs DOT com                           |
// |          Dirk Haun  - dirk AT haun-online DOT de                          |
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
* Simple email form that lets you send emails to certain groups of users.
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

$display = '';

// Make sure user has access to this page
if (! SEC_hasRights('user.mail')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the mail administration screen.");
    COM_output($display);
    exit;
}

/**
* Shows the form the admin uses to send Geeklog members a message. Right now
* you can only email an entire group.
*
* @param    array   $vars   optional array of form content
* @return   string          HTML for the email form
*
*/
function display_mailform($vars = array())
{
    global $_CONF, $LANG31, $LANG_ADMIN, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    $retval .= COM_startBlock($LANG31[1], '',
                        COM_getBlockTemplate('_admin_block', 'header'));

    $menu_arr = array(
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $desc = '<p>' . $LANG31[19] . '</p>';
    $icon = $_CONF['layout_url'] . '/images/icons/mail.' . $_IMAGE_TYPE;
    $retval .= ADMIN_createMenu($menu_arr, $desc, $icon);

    $mail_templates = new Template($_CONF['path_layout'] . 'admin/mail');
    $mail_templates->set_file(array('form' => 'mailform.thtml'));
    $mail_templates->set_var('xhtml', XHTML);
    $mail_templates->set_var('site_url', $_CONF['site_url']);
    $mail_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $mail_templates->set_var('layout_url', $_CONF['layout_url']);
    $mail_templates->set_var('startblock_email', COM_startBlock($LANG31[1],
            '', COM_getBlockTemplate('_admin_block', 'header')));
    $mail_templates->set_var('php_self', $_CONF['site_admin_url']
                                         . '/mail.php');
    $mail_templates->set_var('lang_note', $LANG31[19]);
    $mail_templates->set_var('lang_to', $LANG31[18]);
    $mail_templates->set_var('lang_selectgroup', $LANG31[25]);

    $to_group = 0;
    if (isset($vars['to_group'])) {
        $to_group = COM_applyFilter($vars['to_group'], true);
    }

    $thisUsersGroups = SEC_getUserGroups();
    uksort($thisUsersGroups, 'strcasecmp');
    $group_options = '';
    foreach ($thisUsersGroups as $groupName => $groupID) {
        if ($groupName != 'All Users') {
            $group_options .= '<option value="' . $groupID . '"';
            if (($to_group > 0) && ($to_group == $groupID)) {
                $group_options .= ' selected="selected"';
            }
            $group_options .= '>' . ucwords($groupName) . '</option>';
        }
    }

    $mail_templates->set_var('group_options', $group_options);
    $mail_templates->set_var('lang_from', $LANG31[2]);
    if (! empty($vars['fra'])) {
        $from = $vars['fra'];
    } else {
        $from = $_CONF['site_name'];
    }
    $from = strip_tags($from);
    $from = substr($from, 0, strcspn($from, "\r\n"));
    $from = htmlspecialchars(trim($from), ENT_QUOTES);
    $mail_templates->set_var('site_name', $from);

    $mail_templates->set_var('lang_replyto', $LANG31[3]);
    if (! empty($vars['fraepost'])) {
        $fromemail = $vars['fraepost'];
    } else {
        $fromemail = $_CONF['site_mail'];
    }
    $fromemail = strip_tags($fromemail);
    $fromemail = substr($fromemail, 0, strcspn($fromemail, "\r\n"));
    $fromemail = htmlspecialchars(trim($fromemail), ENT_QUOTES);
    $mail_templates->set_var('site_mail', $fromemail);

    $mail_templates->set_var('lang_subject', $LANG31[4]);
    $mail_templates->set_var('lang_body', $LANG31[5]);
    $mail_templates->set_var('lang_sendto', $LANG31[6]);
    $mail_templates->set_var('lang_allusers', $LANG31[7]);
    $mail_templates->set_var('lang_admin', $LANG31[8]);
    $mail_templates->set_var('lang_options', $LANG31[9]);
    $mail_templates->set_var('lang_HTML', $LANG31[10]);
    $mail_templates->set_var('lang_urgent', $LANG31[11]);
    $mail_templates->set_var('lang_ignoreusersettings', $LANG31[14]);
    $mail_templates->set_var('lang_send', $LANG31[12]);
    $mail_templates->set_var('end_block',
            COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer')));
    $mail_templates->set_var('gltoken_name', CSRF_TOKEN);
    $mail_templates->set_var('gltoken', SEC_createToken());

    $mail_templates->parse('output', 'form');
    $retval .= $mail_templates->finish($mail_templates->get_var('output'));

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
* This function actually sends the messages to the specified group
*
* @param    array   $vars   Same as $_POST, holds all the email info
* @return   string          HTML with success or error message
*
*/
function send_messages($vars)
{
    global $_CONF, $_TABLES, $LANG31;

    require_once $_CONF['path_system'] . 'lib-user.php';

    $retval = '';

    if (empty($vars['fra']) OR empty($vars['fraepost']) OR
            empty($vars['subject']) OR empty($vars['message']) OR
            empty($vars['to_group']) OR (strpos($vars['fra'], '@') !== false)) {
        $retval .= COM_showMessageText($LANG31[26]);
        $retval .= display_mailform($vars);

        return $retval;
    }

    $to_group = COM_applyFilter($vars['to_group'], true);
    if ($to_group > 0) {
        $group_name = DB_getItem($_TABLES['groups'], 'grp_name',
                                 "grp_id = $to_group");
        if (! SEC_inGroup($group_name)) {
            return COM_refresh($_CONF['site_admin_url'] . '/mail.php');
        }
    } else {
        return COM_refresh($_CONF['site_admin_url'] . '/mail.php');
    }

    // Urgent message!
    if (isset ($vars['priority'])) {
        $priority = 1;
    } else {
        $priority = 0;
    }

    // If you want to send html mail
    if (isset ($vars['html'])) {
        $html = true;
    } else {
        $html = false;
    }

    $groupList = implode(',', USER_getChildGroups($to_group));

    // and now mail it
    if (isset ($vars['overstyr'])) {
        $sql = "SELECT DISTINCT username,fullname,email FROM {$_TABLES['users']},{$_TABLES['group_assignments']} WHERE uid > 1";
        $sql .= " AND {$_TABLES['users']}.status = 3 AND ((email IS NOT NULL) and (email != ''))";
        $sql .= " AND {$_TABLES['users']}.uid = ug_uid AND ug_main_grp_id IN ({$groupList})";
    } else {
        $sql = "SELECT DISTINCT username,fullname,email,emailfromadmin FROM {$_TABLES['users']},{$_TABLES['userprefs']},{$_TABLES['group_assignments']} WHERE {$_TABLES['users']}.uid > 1";
        $sql .= " AND {$_TABLES['users']}.status = 3 AND ((email IS NOT NULL) and (email != ''))";
        $sql .= " AND {$_TABLES['users']}.uid = {$_TABLES['userprefs']}.uid AND emailfromadmin = 1";
        $sql .= " AND ug_uid = {$_TABLES['users']}.uid AND ug_main_grp_id IN ({$groupList})";
    }

    $result = DB_query ($sql);
    $nrows = DB_numRows ($result);

    $from = COM_formatEmailAddress ($vars['fra'], $vars['fraepost']);
    $subject = COM_stripslashes ($vars['subject']);
    $message = COM_stripslashes ($vars['message']);

    // Loop through and send the messages!
    $successes = array ();
    $failures = array ();
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray ($result);
        if (empty ($A['fullname'])) {
            $to = COM_formatEmailAddress ($A['username'], $A['email']);
        } else {
            $to = COM_formatEmailAddress ($A['fullname'], $A['email']);
        }

        if (!COM_mail ($to, $subject, $message, $from, $html, $priority)) {
            $failures[] = htmlspecialchars ($to);
        } else {
            $successes[] = htmlspecialchars ($to);
        }
    }

    $retval .= COM_startBlock ($LANG31[1]);

    $failcount = count ($failures);
    $successcount = count ($successes);
    $mailresult = str_replace ('<successcount>', $successcount, $LANG31[20]);
    $retval .= str_replace ('<failcount>', $failcount, $mailresult);

    $retval .= '<h2>' . $LANG31[21] . '</h2>';
    for ($i = 0; $i < count ($failures); $i++) {
        $retval .= current ($failures) . '<br' . XHTML . '>';
        next ($failures);
    }
    if (count ($failures) == 0) {
        $retval .= $LANG31[23];
    }

    $retval .= '<h2>' . $LANG31[22] . '</h2>';
    for ($i = 0; $i < count ($successes); $i++) {
        $retval .= current ($successes) . '<br' . XHTML . '>';
        next ($successes);
    }
    if (count ($successes) == 0) {
        $retval .= $LANG31[24];
    }

    $retval .= COM_endBlock ();

    return $retval;
}

// MAIN

$display .= COM_siteHeader ('menu', $LANG31[1]);

if (isset($_POST['mail']) && ($_POST['mail'] == 'mail') && SEC_checkToken()) {
    $display .= send_messages ($_POST);
} else {
    $display .= COM_showMessageFromParameter();
    $display .= display_mailform();
}

$display .= COM_siteFooter ();

COM_output($display);

?>
