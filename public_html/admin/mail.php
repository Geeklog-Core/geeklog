<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | mail.php                                                                  |
// | Geeklog mail administration page.                                         |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2001,2002 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |                                                                           |
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
// $Id: mail.php,v 1.9 2002/04/27 21:42:17 dhaun Exp $

// Set this to true to get various debug messages from this script
$_MAIL_VERBOSE = false;

require_once('../lib-common.php');
require_once('auth.inc.php');

$display = '';

// Make sure user has access to this page  
if (!SEC_inGroup('Mail Admin')) {
    $retval .= COM_siteHeader('menu');
    $retval .= COM_startBlock($MESSAGE[30]);
    $retval .= $MESSAGE[37];
    $retval .= COM_endBlock();
    $retval .= COM_siteFooter();
    COM_errorLog("User {$_USER['username']} tried to illegally access the mail administration screen",1);
    echo $retval;
    exit;
}

/**
* Shows the form the admin uses to send Geeklog members a message. Right now
* you can only email an entire group.
*
*/
function display_form()
{
    global $_CONF, $_USER, $_LANG31, $PHP_SELF, $LANG31, $_TABLES;
    
    $retval = '';
    
    $mail_templates = new Template($_CONF['path_layout'] . 'admin/mail');
    $mail_templates->set_file(array('form'=>'mailform.thtml'));
    $mail_templates->set_var('site_url', $_CONF['site_url']);
    $mail_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $mail_templates->set_var('startblock_email',COM_startBlock($LANG31[1]));
    $mail_templates->set_var('php_self', $PHP_SELF);
    $mail_templates->set_var('lang_note', $LANG31[19]);
    $mail_templates->set_var('lang_to', $LANG31[18]);
    $mail_templates->set_var('lang_selectgroup', $LANG31[25]);
    $group_options = '';
    $result = DB_query("SELECT grp_id, grp_name FROM {$_TABLES['groups']} WHERE grp_name <> 'All Users'");
    $nrows = DB_numRows($result);
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        $group_options .= '<option value="' . $A['grp_id'] . '">' . $A['grp_name'] . '</option>';
    }
    $mail_templates->set_var('group_options', $group_options);
    $mail_templates->set_var('lang_from', $LANG31[2]);
    $mail_templates->set_var('lang_replyto', $LANG31[3]);
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
    $mail_templates->set_var('end_block', COM_endBlock());
    
    $mail_templates->parse('output','form');
    $retval = $mail_templates->finish($mail_templates->get_var('output'));
    
    return $retval;
}

/**
* This function actually sends the messages to the specified group
*
* @vars     array       Is the same is $HTTP_POST_VARS and hold all the email info
*
*/
function send_messages($vars)
{
    global $_CONF, $LANG31, $_TABLES;
    
    $retval = '';
    
 	if (empty($vars['fra']) OR empty($vars['fraepost']) OR empty($vars['subject'])
        OR empty($vars['message']) OR empty($vars['to_group'])) {
  		echo $LANG31[2];
  		exit;
	}
    
	// Header information
	$headers = "From: {$vars['fra']} <{$vars['fraepost']}>\n";
	$headers .= "X-Sender: <{$vars['fraepost']}>\n"; 
	$headers .= "X-Mailer: PHP\n"; // mailer
    
	// Urgent message!
	if (isset($vars['priority'])) {
 		$headers .= "X-Priority: 1\n"; 
	}
    
	$headers .= "Return-Path: <{$vars['fraepost']}>\n";  // Return path for errors
	// If you want to send html mail
	if (isset($vars['html'])) { 
 		$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Mime type 
	}
    
	// and now mail it
	if (!isset($vars['overstyr'])) {
 		$sql = "SELECT username,fullname,email,emailfromadmin FROM {$_TABLES['users']},{$_TABLES['userprefs']},{$_TABLES['group_assignments']} WHERE {$_TABLES['users']}.uid > 1";
 		$sql .= " AND {$_TABLES['users']}.uid = {$_TABLES['userprefs']}.uid AND emailfromadmin = 1";
        $sql .= " AND ug_uid = {$_TABLES['users']}.uid AND ug_main_grp_id = {$vars['to_group']}";
	}
    
	if (isset($vars['overstyr'])) {
 		$sql = "SELECT username,fullname,email  FROM {$_TABLES['users']},{$_TABLES['group_assignments']} WHERE uid > 1";
        $sql .= " AND {$_TABLES['users']}.uid = ug_uid AND ug_main_grp_id = {$vars['to_group']}";
	}
 
	$sendttil = '';
	$result = DB_query($sql);
	$nrows = DB_numRows($result);
    
    // Loop through and send the messages!
    $successes = array();
    $failures = array();
	for ($i = 1;$i <= $nrows; $i++) {
 		$A = DB_fetchArray($result);
		$til = '';
		if (!isset($A['fullname'])) {
  			$til .= $A['username'];
 		} else {
  			$til .= $A['fullname'];
 		}
 		$til .= '<' . $A['email'] . '>';
 		$sendttil .= $til . '<BR>';
 
 		if (!mail($til, $vars['subject'], $vars['message'], $headers)) {
            $failures[] .= $til;
 		} else {
            $successes[] = $til;
 		}
	}
	
	//$retval = 'Successfully sent ' . count($successes) . ' messages and unsuccessfully sent ' . count($failures) . ' messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href="' . $_CONF['site_url'] . '/admin/mail.php">Send another message</a> or you can <a href="' . $_CONF['site_url'] . '/admin/moderation.php">go back to the administration page</a>.';
	$failcount = count($failures);
	$successcount = count($successes);
	$mailresult .= str_replace('<successcount>',$successcount,$LANG31[20]);
	$retval .= str_replace('<failcount>',$failcount,$mailresult);
	$retval .= "<H2>{$LANG31[21]}</H2>";
	for ($i = 1; $i <= count($failures); $i++) {
        $retval .= current($failures) . '<br>';
        next($failures);
	}
	if (count($failures) == 0) {
        $retval .= $LANG31[23];
	}
	$retval .= "<H2>{$LANG31[22]}</H2>";
	for ($i = 1; $i <= count($successes); $i++) {
        $retval .= current($successes) . '<br>';
        next($successes);
	}
	if (count($successes) == 0) {
        $retval .= $LANG31[24];
	}
	return $retval;
}

// MAIN

$display .= COM_siteHeader();

if ($mail == 'mail') {
    $display .= send_messages($HTTP_POST_VARS);
} else {
    $display .= display_form();
}

$display .= COM_siteFooter();

echo $display;

?>
