<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-custom.php                                                            |
// | Your very own custom Geeklog library.                                     |
// |                                                                           |
// | This is the file where you should put all of your custom code.  When      |
// | possible you should not alter lib-common.php but, instead, put code here. |
// | This will make upgrading to future versions of Geeklog easier for you     |
// | because you will always be gauranteed that the Geeklog developers will    |
// | NOT add code to this file. NOTE: we have already gone through the trouble |
// | of making sure that we always include this file when lib-common.php is    |
// | included some place so you will have access to lib-common.php.  It        |
// | follows then that you should not include lib-common.php in this file      |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
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
// $Id: lib-custom.php,v 1.6 2003/07/17 17:09:27 dhaun Exp $

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
function phpblock_showrights() {
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
    global $_CONF, $_TABLES;
    $secure = true;

    $retval = '';

    $secure_msg = 'Could not find any gross insecurities in your site.  Do not take this ';
    $secure_msg .= 'as meaning your site is 100% secure, as no site ever is.  I can only ';
    $secure_msg .= 'check things that should be blatantly obvious.';

    $insecure_msg = '';

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


/*  Sample Custom Member Functions to create and update Custom Membership registration and profile 

	  Required Table Structure for this example:
		CREATE TABLE `custom_memberinfo` (
		  `uid` mediumint(9) NOT NULL default '0',
		  `firstname` varchar(128) NOT NULL default '',
		  `lastname` varchar(128) NOT NULL default '',
		  `country` varchar(128) NOT NULL default '',
		  `company` varchar(128) NOT NULL default '',
		  KEY `uid` (`uid`)
		) TYPE=MyISAM;

	Note1: You also need to include a defintion for the new table in lib-database.php 
	$_TABLES['custom_memberinfo'] = $_DB_table_prefix . 'custom_memberinfo';

	Note2: Enable CustomRegistration Feature in config.php
	$_CONF['custom_registration'] = true;  // Set to true if you have custom code

	Note3: This example requries a template file called memberdetail.thtml to be
	located under the theme_dir/custom directory

	4 Functions have been provided that are called from the Core Geeklog User admin code
	- This works with User Moderation as well
	- Admin will see the new registration info when checking a members profile only
	- All other users will see the standard GL User profile information

*/

function custom_usercreate($uid) {
    global $_CONF,$_TABLES,$HTTP_POST_VARS;

	// Note you will need to ensure all data is prepared correctly before inserts - as quotes may need to be escaped with addslashes()

    DB_query("INSERT INTO {$_TABLES['custom_memberinfo']} (uid,company,firstname,lastname,country) VALUES
       ($uid,'{$HTTP_POST_VARS['company']}','{$HTTP_POST_VARS['firstname']}','{$HTTP_POST_VARS['lastname']}','{$HTTP_POST_VARS['country']}')");
	DB_query("UPDATE {$_TABLES['users']} SET email='{$HTTP_POST_VARS['email']}',homepage='{$HTTP_POST_VARS['homepage']}', fullname='{$HTTP_POST_VARS['firstname']} {$HTTP_POST_VARS['lastname']}' WHERE uid=$uid");

    return true;

}

function custom_usersave($uid) {
    global $_CONF,$_TABLES,$HTTP_POST_VARS;

	// Note you will need to ensure all data is prepared correctly before inserts - as quotes may need to be escaped with addslashes()

    DB_query("UPDATE {$_TABLES['custom_memberinfo']} SET
	    company='{$HTTP_POST_VARS['company']}',
		firstname='{$HTTP_POST_VARS['firstname']}',
		lastname='{$HTTP_POST_VARS['lastname']}',
		country='{$HTTP_POST_VARS['country']}'
        WHERE uid=$uid");

	DB_query("UPDATE {$_TABLES['users']} SET 
	    email='{$HTTP_POST_VARS['email']}',
		homepage='{$HTTP_POST_VARS['homepage']}', 
		fullname='{$HTTP_POST_VARS['firstname']} {$HTTP_POST_VARS['lastname']}' 
		WHERE uid=$uid");

    return true;

}

function custom_userdelete($uid) {
    global $_TABLES;
    DB_query("DELETE FROM {$_TABLES['custom_memberinfo']} WHERE uid=$uid");

	return true;
}

/* Main Form used for Custom membership to add/edit and display custom user form */
function custom_userform($mode,$uid="",$msg="") {
    global $_CONF,$_TABLES, $LANG04;
	if (!empty($msg)) {
		$retval .= COM_startBlock($LANG04[21]) . $msg . COM_endBlock();
	}

	if ($mode == "edit") {
        $post_url = $_CONF['site_url']."/usersettings.php";
		$postmode = "saveuser";
        $submitbutton = '<input type="submit" value="Update User Profile">';
		$passwd_input = '<tr valign="top">' . LB
	        . '<td align="right"><b>Password</b></td>' . LB
	        . '<td><input type="password" name="passwd" size="32" maxlength="32" value=""></td>' . LB
	        . '</tr>' . LB;
        $result = DB_query("SELECT * FROM {$_TABLES['users']},{$_TABLES['custom_memberinfo']} WHERE {$_TABLES['users']}.uid = $uid AND {$_TABLES['custom_memberinfo']}.uid = $uid");
        $A = DB_fetchArray($result);
        $message = "<br><font size=3><br></font><font size=2 color=black><b>Edit your membership below. Once you have completed, click the Update button to save the record.</b></font>";
    
    } elseif ($mode == "moderate" ) {
	   $submitbutton = '<input type="button" value="Back" onclick="javascript:history.go(-1)">';
	   $result = DB_query("SELECT * FROM {$_TABLES['users']},{$_TABLES['custom_memberinfo']} WHERE {$_TABLES['users']}.uid = $uid AND {$_TABLES['custom_memberinfo']}.uid = $uid");
       $A = DB_fetchArray($result);
			
	} else {
        $post_url = $_CONF['site_url']."/users.php";
		$postmode = "create";
        $submitbutton = '<input type="submit" value="Register Now!">';
		$passwd_input = "";
		$message = "<br><font size=2 color=black><b>Please complete the application below. Once you have completed the application, click the Submit button and the application will be processed immediately.</b></font>";
		$A=array();
    }

    $user_templates = new Template ($_CONF['path_layout'] . 'custom');
    $user_templates->set_file('memberdetail', 'memberdetail.thtml');
    $user_templates->set_var('layout_url', $_CONF['layout_url']);
    $user_templates->set_var('post_url', $post_url);
    $user_templates->set_var('startblock', COM_startBlock("New Member User Registration"));
    $user_templates->set_var('message', $message);    
    $user_templates->set_var('USERNAME', "Username");
    $user_templates->set_var('USERNAME_HELP', "Name to be used when accessing this site");
    $user_templates->set_var('username', $A['username']);
    $user_templates->set_var('passwd_input', $passwd_input);
    $user_templates->set_var('EMAIL', "Email Address");
    $user_templates->set_var('EMAIL_HELP', "");
    $user_templates->set_var('email', $A['email']);
    $user_templates->set_var('WEBSITE', "website");
    $user_templates->set_var('WEBSITE_HELP', "");
    $user_templates->set_var('website', $A['homepage']);
    $user_templates->set_var('COMPANY', "Company Name");
    $user_templates->set_var('COMPANY_HELP', "Enter your Company Name");
    $user_templates->set_var('company', $A['company']);
    $user_templates->set_var('FIRSTNAME', "First Name");
    $user_templates->set_var('FIRSTNAME_HELP', "");
    $user_templates->set_var('firstname', $A['firstname']);
    $user_templates->set_var('LASTNAME', "Last Name");
    $user_templates->set_var('LASTNAME_HELP', "");
    $user_templates->set_var('lastname', $A['lastname']);
    $user_templates->set_var('COUNTRY', "Country");
    $user_templates->set_var('COUNTRY_HELP', "Enter your country");
    $user_templates->set_var('country', $A['country']);	
    $user_templates->set_var('user_id', $user);
    $user_templates->set_var('postmode', $postmode);
    $user_templates->set_var('submitbutton', $submitbutton);

    $user_templates->set_var('endblock', COM_endBlock());
    $user_templates->parse('output', 'memberdetail');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

	return $retval;
}

?>
