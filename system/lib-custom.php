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
// $Id: lib-custom.php,v 1.1 2001/10/17 23:20:47 tony_bibbs Exp $

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
	
    $retval .= COM_startBlock('User Rights');
	
    for ($i = 0; $i < count($_RIGHTS); $i++) {
        $retval .=  '<li>' . $_RIGHTS[$i] . '</li>' . LB;
    }
	
    $retval .= COM_endBlock();
	
    if ($_CST_VERBOSE) {
        COM_errorLog('**** Leaving phpblock_showrights in lib-custom.php ****', 1);
    }

    return $retval;
}

?>
