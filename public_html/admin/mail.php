<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | mail.php                                                                  |
// |                                                                           |
// | Geeklog mail administration page.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2001-2011 by the following authors:                         |
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

use Geeklog\Session;

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
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the mail administration screen.");
    COM_output($display);
    exit;
}

require_once $_CONF['path_system'] . 'lib-admin.php';

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

    $retval = COM_startBlock($LANG31[1], '',
                        COM_getBlockTemplate('_admin_block', 'header'));

    $menu_arr = array(
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $desc = $LANG31[19];
    $icon = $_CONF['layout_url'] . '/images/icons/mail.' . $_IMAGE_TYPE;
    $retval .= ADMIN_createMenu($menu_arr, $desc, $icon);

    $mail_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/mail'));
    $mail_templates->set_file(array('form' => 'mailform.thtml'));
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
    $from = GLText::stripTags($from);
    $from = substr($from, 0, strcspn($from, "\r\n"));
    $from = htmlspecialchars(trim($from), ENT_QUOTES);
    $mail_templates->set_var('site_name', $from);

    $mail_templates->set_var('lang_replyto', $LANG31[3]);
    if (! empty($vars['fraepost'])) {
        $fromEmail = $vars['fraepost'];
    } else {
        $fromEmail = $_CONF['site_mail'];
    }
    $fromEmail = GLText::stripTags($fromEmail);
    $fromEmail = substr($fromEmail, 0, strcspn($fromEmail, "\r\n"));
    $fromEmail = htmlspecialchars(trim($fromEmail), ENT_QUOTES);
    $mail_templates->set_var('site_mail', $fromEmail);
    if (isset($vars['subject'])) {
        $mail_templates->set_var('subject', COM_applyFilter($vars['subject']));
    }
    if (isset($vars['message'])) {
        $mail_templates->set_var('message', COM_applyFilter($vars['message']));
    }
    if (isset($vars['html']) && trim($vars['html']) == 'on') {
        $mail_templates->set_var('html', ' checked="checked"');
    }
    if (isset($vars['priority']) && trim($vars['priority']) == 'on') {
        $mail_templates->set_var('priority', ' checked="checked"');
    }
    if (isset($vars['overstyr']) && trim($vars['overstyr']) == 'on') {
        $mail_templates->set_var('overstyr', ' checked="checked"');
    }
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
    $mail_templates->set_var('lang_mail_templatevars', $LANG31[27]);
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
function send_messages(array $vars)
{
    global $_CONF, $_TABLES, $LANG31, $LANG_ADMIN, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-user.php';

    $retval = '';

    if (empty($vars['fra']) || empty($vars['fraepost']) || empty($vars['subject']) ||
        empty($vars['message']) || empty($vars['to_group']) || strpos($vars['fra'], '@') !== false) {
        $retval .= COM_showMessageText($LANG31[26]);
        $retval .= display_mailform($vars);

        return $retval;
    }

    $to_group = COM_applyFilter($vars['to_group'], true);
    if ($to_group > 0) {
        $group_name = DB_getItem($_TABLES['groups'], 'grp_name', "grp_id = $to_group");
        if (!SEC_inGroup($group_name)) {
            COM_redirect($_CONF['site_admin_url'] . '/mail.php');
        }
    } else {
        COM_redirect($_CONF['site_admin_url'] . '/mail.php');
    }

    // Urgent message!
    $priority = isset($vars['priority']) ? 1 : 0;

    // If you want to send html mail
    $html = isset($vars['html']);
    $groupList = implode(',', USER_getChildGroups($to_group));

    // and now mail it
    if (isset($vars['overstyr'])) {
        $sql = "SELECT DISTINCT username,fullname,email FROM {$_TABLES['users']},{$_TABLES['group_assignments']} WHERE uid > 1";
        $sql .= " AND {$_TABLES['users']}.status = " . USER_ACCOUNT_ACTIVE . " AND ((email IS NOT NULL) and (email != ''))";
        $sql .= " AND {$_TABLES['users']}.uid = ug_uid AND ug_main_grp_id IN ({$groupList})";
    } else {
        $sql = "SELECT DISTINCT username,fullname,email,emailfromadmin FROM {$_TABLES['users']},{$_TABLES['user_attributes']},{$_TABLES['group_assignments']} WHERE {$_TABLES['users']}.uid > 1";
        $sql .= " AND {$_TABLES['users']}.status = " . USER_ACCOUNT_ACTIVE . " AND ((email IS NOT NULL) and (email != ''))";
        $sql .= " AND {$_TABLES['users']}.uid = {$_TABLES['user_attributes']}.uid AND emailfromadmin = 1";
        $sql .= " AND ug_uid = {$_TABLES['users']}.uid AND ug_main_grp_id IN ({$groupList})";
    }

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    //$from = array($vars['fraepost'] => $vars['fra']);
	$from = array($vars['fraepost'] => $_CONF['site_mail']);
    $subject = $vars['subject'];
    $subject = GLText::stripTags($subject);
    $message = $vars['message'];

    if ($html) {
        if (stripos($message, '<body') === false) {
            $message = '<body>' . PHP_EOL . $message . PHP_EOL . '</body>' . PHP_EOL;
        }

        if (stripos($message, '<head') === false) {
            $message = '<head></head>' . PHP_EOL . $message;
        }

        if (stripos($message, '<html') === false) {
            $message = '<html>' . PHP_EOL . $message . '</html>' . PHP_EOL;
        }
    } else {
        $message = GLText::stripTags($message);
    }

    // Loop through and send the messages!
    $successes = array();
    $failures = array();

    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);
        if (empty($A['fullname'])) {
            $to = array($A['email'] => $A['username']);
        } else {
            $to = array($A['email'] => $A['fullname']);
        }

        $tempTo = is_array($to) ? implode('', array_keys($to)) : $to;
        
		if (!COM_mail($to, $subject, $message, $from, $html, $priority)) {
			$failures[] = htmlspecialchars($tempTo);
		} else {
			$successes[] = htmlspecialchars($tempTo);
		}
    }

    $mail_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/mail'));
    $mail_templates->set_file(array('form' => 'mailsent.thtml'));
	$mail_templates->set_block('form', 'display_email');
	
    $mail_templates->set_var('start_block_mailusers', COM_startBlock($LANG31[1], '', COM_getBlockTemplate('_admin_block', 'header')));
	$mail_templates->set_var('end_block_mailusers', COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer')),);
	
    $mail_templates->set_var('start_block_failures', COM_startBlock($LANG31[21], '', 'blockheader-child.thtml'));
    $mail_templates->set_var('end_block_failures', COM_endBlock('blockfooter-child.thtml'));	

    $mail_templates->set_var('start_block_successes', COM_startBlock($LANG31[22], '', 'blockheader-child.thtml'));
    $mail_templates->set_var('end_block_successes', COM_endBlock('blockfooter-child.thtml'));	
						
    $menu_arr = array(
        array('url'  => $_CONF['site_admin_url'] . '/mail.php',
              'text' => $LANG31[1]), 	
        array('url'  => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $desc = $LANG31[19];
    $icon = $_CONF['layout_url'] . '/images/icons/mail.' . $_IMAGE_TYPE;
    $mail_templates->set_var('admin_menu', ADMIN_createMenu($menu_arr, $desc, $icon));

    $failCount = count($failures);
    $successCount = count($successes);
    $mailResult = str_replace('<successcount>', $successCount, $LANG31[20]);
    $mailResult = str_replace('<failcount>', $failCount, $mailResult);
    $mail_templates->set_var('lang_mail_results', $mailResult);
	
    for ($i = 0; $i < count($failures); $i++) {
		$mail_templates->set_var('email_address', current($failures));
		$mail_templates->parse('display_failures', 'display_email', true);
        next($failures);
    }
    if (count($failures) === 0) {
		$mail_templates->set_var('lang_no_failure_message', $LANG31[23]);
    }

    for ($i = 0; $i < count($successes); $i++) {
		$mail_templates->set_var('email_address', current($successes));
		$mail_templates->parse('display_successes', 'display_email', true);
		
        next($successes);
    }
    if (count($successes) === 0) {
		$mail_templates->set_var('lang_no_success_message', $LANG31[24]);
    }
	
    $mail_templates->parse('output', 'form');
    $retval .= $mail_templates->finish($mail_templates->get_var('output'));

    return $retval;
}

// MAIN
if ((Geeklog\Input::post('mail') === 'mail') && SEC_checkToken()) {
    $display .= send_messages($_POST);
} else {
    $display .= COM_showMessageFromParameter();
    $display .= display_mailform();
}

$display = COM_createHTMLDocument($display, array('pagetitle' => $LANG31[1]));

COM_output($display);
