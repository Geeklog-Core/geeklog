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
// $Id: lib-custom.php,v 1.5 2003/07/02 14:29:31 dhaun Exp $

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

?>
