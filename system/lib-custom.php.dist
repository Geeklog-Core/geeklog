<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
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
// | Copyright (C) 2000-2011 by the following authors:                         |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-custom.php') !== false) {
    die('This file can not be used on its own!');
}

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

    $retval = '';

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


/**
* Include any code in this function that will be called by the internal CRON API
* The interval between runs is determined by $_CONF['cron_schedule_interval']
*/
function CUSTOM_runScheduledTask() {

}


/**
* Example of custom function that can be used to handle a login error.
* Only active with custom registration mode enabled
* Used if you have a custom front page and need to trap and reformat any error messages
* This example redirects to the front page with a extra passed variable plus the message
* Note: Message could be a string but in this case maps to $MESSAGE[81] as a default - edit in language file
*/
function CUSTOM_loginErrorHandler($msg='') {
    global $_CONF,$MESSAGE;

    if ($msg > 0) {
        $msg = $msg;
    } elseif ($msg == '') {
        $msg = 81;
    }
    $retval = COM_refresh($_CONF['site_url'] .'/index.php?mode=loginfail&amp;msg='.$msg);
    echo $retval;
    exit;
}


/**
* Include any code in this function to add custom template variables.
*
* Called from within Geeklog for:
* - 'header' (site header)
* - 'footer' (site footer)
* - 'storytext', 'featuredstorytext', 'archivestorytext' (story templates)
* - 'story' (story submission)
* - 'comment' (comment submission form)
* - 'registration' (user registration form)
* - 'contact' (email user form)
* - 'emailstory' (email story to a friend)
* - 'loginblock' (login form in the side bar)
* - 'loginform' (login form in the content area)
* - 'search' (advanced search form; simple search is usually part of 'header')
*
* This function is called whenever PLG_templateSetVars is called, i.e. in
* addition to the templates listed here, it may also be called from plugins.
*
* @param    string  $templatename   name of the template, e.g. 'header'
* @param    ref    &$template       reference to the template
* @return   void
* @see      PLG_templateSetVars
*
*/
function CUSTOM_templateSetVars($templatename, &$template)
{
    // define a {hello_world} variable available in header.thtml and
    // a {hello_again} variable available in the story templates

    switch ($templatename) {
    case 'header':
        $template->set_var('hello_world', 'Hello, world!');
        break;

    case 'storytext':
    case 'featuredstorytext':
    case 'archivestorytext':
        $template->set_var('hello_again', 'Hello (again)!');
        break;
    }
}


/*  Sample Custom Member Functions to create and update Custom Membership registration and profile

    Note1: Enable CustomRegistration Feature in the configuration
    $_CONF['custom_registration'] = true;  // Set to true if you have custom code

    Note2: This example requires a template file called memberdetail.thtml to be
    located under the theme_dir/custom directory.
    Sample is provided under /system with the distribution.

    Note3: Optional parm $bulkimport added so that if your using the [Batch Add] feature,
    you can execute different logic if required.

    Functions have been provided that are called from the Core Geeklog user and admin functions
    - This works with User Moderation as well
    - Admin will see the new registration info when checking a member's profile only
    - All other users will see the standard User profile with the optional extended custom information
    - Customization requires changes to a few of the core template files to add {customfields} variables
    - See notes below in the custom function about the template changes
*/

/**
* Called when user is first created
* Create any new records in additional tables you may have added
* Update any fields in the core GL tables for this user as needed
*
* @param    int     $uid        user id - record already exists at this point
* @param    boolean $bulkimport true during Batch User Import (admin/user.php)
* @return   boolean             true on success, otherwise false
*
*/
function CUSTOM_userCreate($uid, $bulkimport = false)
{
    global $_CONF, $_TABLES;

    if ($bulkimport) {
        // the sample code in this function is written for the normal signup
        // process; the $_POST variables are not set during bulk import
        return true;
    }

    // Ensure all data is prepared correctly before inserts, quotes may need to
    // be escaped with addslashes()
    $email = '';
    if (isset ($_POST['email'])) {
        $email = COM_applyFilter ($_POST['email']);
        $email = addslashes ($email);
    }

    $homepage = '';
    if (isset ($_POST['homepage'])) {
        $homepage = COM_applyFilter ($_POST['homepage']);
        $homepage = addslashes ($homepage);
    }

    $fullname = '';
    if (isset ($_POST['fullname'])) {
        // COM_applyFilter would strip special characters, e.g. quotes, so
        // we only strip HTML
        $fullname = strip_tags ($_POST['fullname']);
        $fullname = addslashes ($fullname);
    }

    // Note: In this case, we can trust the $uid variable to contain the new
    // account's uid.
    DB_query("UPDATE {$_TABLES['users']} SET email = '$email', homepage = '$homepage', fullname = '$fullname' WHERE uid = $uid");

    return true;
}

// Delete any records from custom tables you may have used
function CUSTOM_userDelete($uid)
{
    return true;
}

/* Called from users.php - when user is displaying a member profile.
 * This function can now return any extra fields that need to be shown.
 * Output is then replaced in {customfields} -- This variable needs to be added
 * to your templates
 * Template: path_layout/users/profile.thtml
 */
function CUSTOM_userDisplay($uid)
{
    global $_CONF, $_TABLES;

    $retval = '';

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

    $retval = '';

    $var = "Value from custom table";
    $cookietimeout = DB_getitem($_TABLES['users'], 'cookietimeout', $uid);
    $selection = '<select name="cooktime">' . LB;
    $selection .= COM_optionList ($_TABLES['cookiecodes'], 'cc_value,cc_descr', $cookietimeout, 0);
    $selection .= '</select>';
    $retval .= '<tr>
        <td align="right">Remember user for:</td>
        <td>' . $selection .'</td>
     </tr>';
    $retval .= '<tr>
        <td align="right"><b>Custom Fields:</b></td>
        <td><input type="text" name="custom1" size="50" value="' . $var .'"' . XHTML . '></td>
     </tr>';
    $retval .= '<tr><td colspan="2"><hr' . XHTML . '></td></tr>';

    return $retval;
}

/* Function called when saving the user profile. */
/* This function can now update any extra fields  */
function CUSTOM_userSave($uid)
{
    global $_CONF, $_TABLES;

    $cooktime = 0;
    if (isset ($_POST['cooktime'])) {
        $cooktime = COM_applyFilter ($_POST['cooktime'], true);
        if ($cooktime < 0) {
            $cooktime = 0;
        }

        DB_query("UPDATE {$_TABLES['users']} SET cookietimeout = $cooktime WHERE uid = $uid");
    }
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

    $retval = '';

    if (!empty ($msg) && ($msg != 'new')) {
        $retval .= COM_startBlock($LANG04[21]) . $msg . COM_endBlock();
    }

    $post_url = $_CONF['site_url'] . '/users.php';
    $postmode = 'create';
    $submitbutton = '<input type="submit" value="Register Now!"' . XHTML . '>';
    $message = "<blockquote style=\"padding-top:10px;\"><b>Please complete the application below. Once you have completed the application, click the Register Now! button and the application will be processed immediately.</b></blockquote>";

    $user_templates = COM_newTemplate($_CONF['path_layout'] . 'custom');
    $user_templates->set_file('memberdetail', 'memberdetail.thtml');
    $user_templates->set_var('post_url', $post_url);
    $user_templates->set_var('startblock', COM_startBlock("Custom Registration Example"));
    $user_templates->set_var('message', $message);

    $user_templates->set_var('USERNAME', $LANG04[2]);
    $user_templates->set_var('USERNAME_HELP', "Name to be used when accessing this site");
    $username = '';
    if (isset ($_POST['username'])) {
        $username = COM_applyFilter ($_POST['username']);
    }
    $user_templates->set_var('username', $username);

    $user_templates->set_var('EMAIL', $LANG04[5]);
    $user_templates->set_var('EMAIL_HELP', $LANG04[33]);
    $email = '';
    if (isset ($_POST['email'])) {
        $email = COM_applyFilter ($_POST['email']);
    }
    $user_templates->set_var('email', $email);

    $user_templates->set_var('EMAIL_CONF', $LANG04[124]);
    $user_templates->set_var('EMAIL_CONF_HELP', $LANG04[126]);
    $email_conf = '';
    if (isset ($_POST['email_conf'])) {
        $email_conf = COM_applyFilter ($_POST['email_conf']);
    }
    $user_templates->set_var('email_conf', $email_conf);

    $user_templates->set_var('FULLNAME', $LANG04[3]);
    $user_templates->set_var('FULLNAME_HELP', $LANG04[34]);
    $fullname = '';
    if (isset ($_POST['fullname'])) {
        $fullname = strip_tags ($_POST['fullname']);
    }
    $user_templates->set_var('fullname', $fullname);

    $user_templates->set_var('user_id', $user);
    $user_templates->set_var('postmode', $postmode);
    $user_templates->set_var('submitbutton', $submitbutton);
    $user_templates->set_var('endblock', COM_endBlock());
    $user_templates->parse('output', 'memberdetail');
    $retval .= $user_templates->finish($user_templates->get_var('output'));

    return $retval;
}

/**
* Geeklog is about to create a new user or edit an existing user.
* This is the custom code's last chance to do any form validation,
* e.g. to check if all required data has been entered.
*
* @param    string  $username   username that Geeklog would use for the new user* @param    string  $email      email address of that user
* @return   mixed               Returns an empty string if no issues found validating user account form
*                               If a validation test fails, return both a message and code
*                                  > usercreate needs a string and usersettings saveuser() needs a message number
*                               The message number will map to the GLOBALS $MESSAGE define in the site language files
*                               By default $MESSAGE[400] will appear if a non-numeric is returned to usersettings.php - saveuser function
*/
function CUSTOM_userCheck ($username, $email='')
{
    global $MESSAGE;

    $retval = '';

    // Example, check that the full name has been entered
    // and complain if it's missing
    if (empty($_POST['fullname'])) {
        $retval['string'] = $MESSAGE['401'];
        $retval['number'] = 401;
    }

    return $retval;
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
    global $_CONF, $_USER, $_TABLES;

    $retval = '';

    if( !isset( $_USER['noboxes'] )) {
        if( !empty( $_USER['uid'] )) {
            $noboxes = DB_getItem( $_TABLES['userindex'], 'noboxes', "uid = {$_USER['uid']}" );
        } else {
            $noboxes = 0;
        }
    } else {
        $noboxes = $_USER['noboxes'];
    }

    foreach($showblocks as $block) {
        $sql = "SELECT bid, name,type,title,content,rdfurl,phpblockfn,help,allow_autotags,onleft FROM {$_TABLES['blocks']} WHERE name='$block'";
        $result = DB_query($sql);
        if (DB_numRows($result) == 1) {
            $A = DB_fetchArray($result);
            if ($A['onleft'] == 1) {
                $side = 'left';
            } else {
                $side = 'right';
            }
            $retval .= COM_formatBlock($A,$noboxes, $side);
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
    global $_CONF;

    if (empty ($from)) {
        $from = $_CONF['site_name'] . ' <' . $_CONF['site_mail'] . '>';
    }

    $headers  = 'From: ' . $from . "\r\n"
              . 'X-Mailer: Geeklog ' . VERSION . "\r\n";

    if ($priority > 0) {
        $headers .= 'X-Priority: ' . $priority . "\r\n";
    }

    $charset = COM_getCharset ();
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
* the 'custom' entry in $_CONF['menu_elements'] (see configuration).
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
                                         . '/calendar/index.php?mode=personal',
                              'label' => 'My Calendar');
    }

    return $myentries;
}
*/

/**
  * This is an example of an error handler override. This will be used in
  * place of COM_handleError if the user is not in the Root group. Really,
  * this should only be used to display some nice pretty "site error" html.
  * Though you could try and notify the sysadmin, and log the error, as this
  * example will show. The function is commented out for saftey.
  */
/*
function CUSTOM_handleError($errno, $errstr, $errfile, $errline, $errcontext)
{
    global $_CONF;
    if( is_array($_CONF) && function_exists('COM_mail'))
    {
        COM_mail($_CONF['site_mail'], $_CONF['site_name'].' Error Handler',
                "An error has occurred: $errno $errstr @ $errline of $errfile");
        COM_errorLog("Error Handler: $errno $errstr @ $errline of $errfile");
    }
    echo("
        <html>
            <head>
                <title>{$_CONF['site_name']} - An error occurred.</title>
                <style type=\"text/css\">
                    body,html {height: 100%; width: 100%;}
                    body{ border: 0px; padding: 0px;
                        background-color: white;
                        color: black;
                        }
                   div { margin-left: auto; margin-right: auto;
                            margin-top: auto; margin-bottom: auto;
                            border: solid thin blue; width: 400px;
                            padding: 5px; text-align: center;
                            }
                   h1 { color: blue;}
               </style>
            </head>
            <body>
                <div>
                    <h1>An Error Has Occurred.</h1>
                    <p>Unfortunatley, the action you performed has caused an
                    error. The site administrator has been informed. If you
                    try again later, the issue may have been fixed.</p>
                </div>
            </body>
        </html>
        ");
    exit;
}
*/
?>
