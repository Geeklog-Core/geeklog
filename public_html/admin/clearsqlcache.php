<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | clearsqlcache.php                                                         |
// | Clears the SQL cache                                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002 by the following authors:                              |
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
// $Id: clearsqlcache.php,v 1.1 2002/05/20 20:04:45 tony_bibbs Exp $

require_once('../lib-common.php');
require_once('auth.inc.php');
include_once($_CONF['path_system'] . 'databases/adodb/adodb.inc.php');
$display = '';

// Make sure user has access to this page  
if (!SEC_inGroup('Root')) {
    $retval .= COM_siteHeader('menu');
    $retval .= COM_startBlock($MESSAGE[30]);
    $retval .= $MESSAGE[37];
    $retval .= COM_endBlock();
    $retval .= COM_siteFooter();
    COM_errorLog("User {$_USER['username']} tried to illegally access the SQL cache administration screen",1);
    echo $retval;
    exit;
}

system("rm -f `find " . $ADODB_CACHE_DIR . " -name adodb_*.cache`");

// MAIN

$display .= COM_siteHeader();
$display .= COM_startBlock();
$display .= $MESSAGE[47];
$display .= COM_endBlock();
$display .= COM_siteFooter();

echo $display;

?>