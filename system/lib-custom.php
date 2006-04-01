<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | lib-custom.php                                                            |
// |                                                                           |
// | Your very own custom Geeklog library.                                     |
// |                                                                           |
// | This is the file where you should put all of your custom code.  When      |
// | possible you should not alter lib-common.php but, instead, put code here. |
// | This will make upgrading to future versions of Geeklog easier for you     |
// | because you will always be guaranteed that the Geeklog developers will    |
// | NOT add required code to this file.                                       |
// |                                                                           |
// | NOTE: we have already gone through the trouble of making sure that we     |
// | always include this file when lib-common.php is included some place so    |
// | you will have access to lib-common.php.  It follows then that you should  |
// | not include lib-common.php in this file.                                  |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Blaine Lang      - blaine AT portalparts DOT com                 |
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
//
// $Id: lib-custom.php,v 1.21 2006/04/01 10:52:40 dhaun Exp $

// You can use this global variable to print useful messages to the errorlog
// using COM_errorLog().  To see an example of how to do this, look in
// lib-common.php and see how $_COM_VERBOSE was used throughout the code
$_CST_VERBOSE = false;

/**
* Sample PHP Block function
*
* this is a sample function used by a PHP block.  This will show the rights that
* a user has in the "What you have access to" block.
*
*/
function phpblock_showrights()
{
    global $_RIGHTS, $_CST_VERBOSE;

    if ($_CST_VERBOSE) {
        COM_errorLog('**** Inside phpblock_showrights in lib-custom.php ****', 1);
    }

    $retval .= '&nbsp;';

    for ($i = 0; $i < count($_RIGHTS); $i++) {
        $retval .=  '<li>' . $_RIGHTS[$i] . '</li>' . LB;
    }

    if ($_CST_VERBOSE) {
        COM_errorLog('**** Leaving phpblock_showrights in lib-custom.php ****', 1);
    }

    return $retval;
}


/***
*
* Get Bent()
*
* Php function to tell you how if your site is grossly insecure
*
**/
function phpblock_getBent()
{
    global $_CONF, $_TABLES, $MESSAGE, $mb_enabled;

    $retval = '';
    $insecure_msg = '';

    $secure = true;

    if (!$mb_enabled && $_CONF['default_charset'] == 'utf-8') {
        $secure = false;
        $insecure_msg = $MESSAGE[77];
    }

    $secure_msg .= 'Could not find any gross insecurities in your site.  Do not take this ';
    $secure_msg .= 'as meaning your site is 100% secure, as no site ever is.  I can only ';
    $secure_msg .= 'check things that should be blatantly obvious.';

    // we don't have the path to the admin directory, so try to figure it out
    // from $_CONF['site_admin_url']
    $adminurl = $_CONF['site_admin_url'];
    if (strrpos ($adminurl, '/') == strlen ($adminurl)) {
        $adminurl = substr ($adminurl, 0, -1);
    }
    $pos = strrpos ($adminurl, '/');
    if ($pos === false) {
        // only guessing ...
        $installdir = $_CONF['path_html'] . 'admin/install';
    } else {
        $installdir = $_CONF['path_html'] . substr ($adminurl, $pos + 1)
                    . '/install';
    }

    if (is_dir ($installdir)) {
        $insecure_msg .= '<p>You should really remove the install directory <b>' . $installdir .'</b> once you have your site up and running without any errors.';
        $insecure_msg .= ' Keeping it around would allow malicious users the ability to destroy your current install, take over your site, or retrieve sensitive information.';

        $secure = false;
    }

    // check to see if any account still has 'password' as its password.
    $count = DB_query("select count(*) as count from {$_TABLES['users']} where passwd='" . md5('password') . "'");
    $A = DB_fetchArray($count);
    if ( $A['count'] > 0 ) {
        $secure = false;
        $insecure_msg .= '<p>You still have not changed the default password from "password" on ' . $A['count'] . ' account(s). ';
        $insecure_msg .= 'This will allow people to do serious harm to your site!';
    }

    if ($secure) {
        $retval = $secure_msg;
    } else {
        $retval = $insecure_msg;
    }
    $retval = wordwrap($retval,20,' ',1);

    return $retval;
}


/**
* Include any code in this function that will be called by the internal CRON API
* The interval between runs is determined by $_CONF['cron_schedule_interval']
*/
function CUSTOM_runScheduledTask() {

}


/**
* Include any code in this function that will be called by Plugin API to set template variables
* Initially this API is only called in the COM_siteHeader function to set header.thtml variables
*/
function CUSTOM_templateSetVars($templatename, &$template) {

    if ($templatename == 'header') {
        if (isset($mycontent)) {
            $template->set_var( 'myvar', $mycontent );
        }
    }
}


/*  Sample Custom Member Functions to create and update Custom Membership registration and profile

    Note1: Enable CustomRegistration Feature in config.php
    $_CONF['custom_registration'] = true;  // Set to true if you have custom code

    Note2: This example requries a template file called memberdetail.thtml to be
    located under the theme_dir/custom directory.
    Sample is provided under /system with the distribution.

    Functions have been provided that are called from the Core Geeklog user and admin functions
    - This works with User Moderation as well
    - Admin will see the new registration info when checking a members profile only
    - All other users will see the standard User profile with the optional extended custom information
    - Customization requires changes to a few of the core template files to add {customfields} variable
    - See notes below in the custom function about the template changes
*/

/* Create any new records in additional tables you may have added  */
/* Update any fields in the core GL tables for this user as needed */
/* Called when user is first created */
function CUSTOM_userCreate($uid)
{
    global $_CONF, $_TABLES;

    // Ensure all data is prepared correctly before inserts, quotes may need to be escaped with addslashes()
    DB_query("UPDATE {$_TABLES['users']} SET email='{$_POST['email']}',homepage='{$_POST['homepage']}', fullname='{$_POST['fullname']}' WHERE uid=$uid");

    return true;
}

// Delete any records from custom tables you may have used
function CUSTOM_userDelete($uid)
{
    return true;
}

/* Called from users.php - when user is displaying a member profile  */
/* This function can now return any extra fields that need to be shown */
/* Output is then replaced in {customfields) -- This variable needs to be added to your templates */
/* Template: path_layout/users/profile/profile.thtml */

function CUSTOM_userDisplay($uid)
{
    global $_CONF, $_TABLES;

    $var = "Value from custom table";
    $retval .= '<tr>
        <td align="right"><b>Custom Fields:</b></td>
        <td>' . $var .'</td>
     </tr>';

    return $retval;
}


/* Function called when editing user profile. */
/* Called from usersettings.php - when user is eding their own profile  */
/* and from admin/user.php when admin is editing a member profile  */
/* This function can now return any extra fields that need to be shown for editing */
/* Output is then replaced in {customfields} -- This variable needs to be added to your templates */
/* User: path_layout/preferences/profile.thtml and Admin: path_layout/admin/user/edituser.thtml */

/* This example shows adding the Cookie Timeout setting and extra text field */
/* As noted: You need to add the {customfields} template variable. */
/* For the edituser.thtml - maybe it would be added about the {group_edit} variable. */

function CUSTOM_userEdit($uid)
{
    global $_CONF, $_TABLES;

    $var = "Value from custom table";
    $cookietimeout = DB_getitem($_TABLES['users'], 'cookietimeout' ,$uid);
    $selection = '<select name="cooktime">' . LB;
    $selection .= COM_optionList ($_TABLES['cookiecodes'], 'cc_value,cc_descr', $cookietimeout, 0);
    $selection .= '</select>';
    $retval .= '<tr>
        <td align="right">Remember user for:</td>
        <td>' . $selection .'</td>
     </tr>';
    $retval .= '<tr>
        <td align="right"><b>Custom Fields:</b></td>
        <td><input type="text" name="custom1" size="50" value="' . $var .'"></td>
     </tr>';
    $retval .= '<tr><td colspan="2"><hr></td></tr>';

    return $retval;
}

/* Function called when saving the user profile. */
/* This function can now update any extra fields  */
function CUSTOM_userSave($uid)
{
    global $_CONF, $_TABLES;

    DB_query("UPDATE {$_TABLES['users']} SET cookietimeout='{$_POST["cooktime"]}'");
}


/**
* Main Form used for Custom membership when member is registering
*
* Note: Requires a file custom/memberdetail.thtml in every theme that is
*       installed on the site!
*
* @param    string  $msg    an error message to display or the word 'new'
* @return   string          HTML for the registration form
*
*/
function CUSTOM_userForm ($msg = '')
{
    global $_CONF, $_TABLES, $LANG04;

    if (!empty ($msg) && ($msg != 'new')) {
        $retval .= COM_startBlock($LANG04[21]) . $msg . COM_endBlock();
    }

    $post_url = $_CONF['site_url']."/users.php";
    $postmode = "create";
    $submitbutton = '<input type="submit" value="Register Now!">';
    $message = "<blockquote style=\"padding-top:10px;\"><font color=black><b>Please complete the application below. Once you have completed the application, click the Submit button and the application will be processed immediately.</b></font></blockquote>";

    $user_templates = new Template ($_CONF['path_layout'] . 'custom');
    $user_templates->set_file('memberdetail', 'memberdetail.thtml');
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('post_url', $post_url);
    $user_templates->set_var('startblock', COM_startBlock("Custom Registration Example"));
    $user_templates->set_var('message', $message);
    $user_templates->set_var('USERNAME', "Username");
    $user_templates->set_var('USERNAME_HELP', "Name to be used when accessing this site");
    $user_templates->set_var('username', '');
    $user_templates->set_var('EMAIL', "Email Address");
    $user_templates->set_var('EMAIL_HELP', "");
    $user_templates->set_var('email', '');
    $user_templates->set_var('FULLNAME', "Full Name");
    $user_templates->set_var('FULLNAME_HELP', "");
    $user_templates->set_var('fullname', '');
    $user_templates->set_var('user_id', $user);
    $user_templates->set_var('postmode', $postmode);
    $user_templates->set_var('submitbutton', $submitbutton);
    $user_templates->set_var('endblock', COM_endBlock());
    $user_templates->parse('output', 'memberdetail');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
* Check if it's okay to create a new user.
*
* Geeklog is about to create a new user with the given username and email
* address. This is the custom code's last chance to prevent that,
* e.g. to check if all required data has been entered.
*
* @param    string  $username   username that Geeklog would use for the new user* @param    string  $email      email address of that user
* @return   string              an error message or an empty string for "OK"
*
*/
function CUSTOM_userCheck ($username, $email)
{
    $msg = '';

    // Example, check that the full name has been entered
    // and complain if it's missing
    if (empty ($_POST['fullname'])) {
        $msg = 'Please enter your full name!';
    }

    return $msg;
}


/**
* Custom function to retrieve and return a formatted list of blocks
* Can be used when calling COM_siteHeader or COM_siteFooter
*
* Example:
* 1: Setup an array of blocks to display
* 2: Call COM_siteHeader or COM_siteFooter
*
*  $myblocks = array( 'site_menu', 'site_news', 'poll_block' );
*
* COM_siteHeader( array( 'CUSTOM_showBlocks', $myblocks )) ;
* COM_siteFooter( true, array( 'CUSTOM_showBlocks', $myblocks ));
*
* @param   array   $showblocks    An array of block names to retrieve and format
* @return  string                 Formated HTML containing site footer and optionally right blocks
*/
function CUSTOM_showBlocks($showblocks)
{
    global $_CONF, $_TABLES;

    $retval = '';
    foreach($showblocks as $block) {
        $sql = "SELECT bid, name,type,title,content,rdfurl,phpblockfn,help FROM {$_TABLES['blocks']} WHERE name='$block'";
        $result = DB_query($sql);
        if (DB_numRows($result) == 1) {
            $A = DB_fetchArray($result);
            $retval .= COM_formatBlock($A);
        }
    }

    return $retval;
}


/**
* This is an example of a custom email function. When this function is NOT
* commented out, Geeklog would send all emails through this function
* instead of sending them through COM_mail in lib-common.php.
*
* This is basically a re-implementation of the way emails were sent
* prior to Geeklog 1.3.9 (Geeklog uses PEAR::Mail as of version 1.3.9).
*
*/
/*
function CUSTOM_mail($to, $subject, $message, $from = '', $html = false, $priority = 0)
{
    global $_CONF, $LANG_CHARSET;

    if (empty ($LANG_CHARSET)) {
        $charset = $_CONF['default_charset'];
        if (empty ($charset)) {
            $charset = 'iso-8859-1';
        }
    } else {
        $charset = $LANG_CHARSET;
    }

    if (empty ($from)) {
        $from = $_CONF['site_name'] . ' <' . $_CONF['site_mail'] . '>';
    }

    $headers  = 'From: ' . $from . "\r\n"
              . 'X-Mailer: Geeklog ' . VERSION . "\r\n";

    if ($priority > 0) {
        $headers .= 'X-Priority: ' . $priority . "\r\n";
    }

    if ($html) {
        $headers .= "Content-Type: text/html; charset={$charset}\r\n"
                 .  'Content-Transfer-Encoding: 8bit';
    } else {
        $headers .= "Content-Type: text/plain; charset={$charset}";
    }

    return mail ($to, $subject, $message, $headers);
}
*/

/**
* This is an example of a function that returns menu entries to be used for
* the 'custom' entry in $_CONF['menu_elements'] (see config.php).
*
*/
/*
function CUSTOM_menuEntries ()
{
    global $_CONF, $_USER;

    $myentries = array ();

    // Sample link #1: Link to Gallery
    $myentries[] = array ('url'   => $_CONF['site_url'] . '/gallery/',
                          'label' => 'Gallery');

    // Sample link #2: Link to the Personal Calendar - only visible for
    // logged-in users
    if (!empty ($_USER['uid']) && ($_USER['uid'] > 1)) {
        $myentries[] = array ('url'   => $_CONF['site_url']
                                         . '/calendar.php?mode=personal',
                              'label' => 'My Calendar');
    }

    return $myentries;
}
*/

?>
