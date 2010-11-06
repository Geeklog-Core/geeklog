<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This file acts as a gateway to the Atom webservices.                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Ramnath R Iyer   - rri AT silentyak DOT com                      |
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

require_once '../../lib-common.php';
require_once $_CONF['path_system'] . '/lib-webservices.php';

/* Check if WS component is enabled */
if ($_CONF['disable_webservices']) {
    /* Pretend the WS doesn't exist */
    COM_displayMessageAndAbort($LANG_404[3], '', 404, 'Not Found');
}

// Set the default content type
header('Content-type: ' . 'application/atom+xml' . '; charset=UTF-8');

/* Authenticate the user IF credentials are present */
WS_authenticate();

/**
* Global array of groups current user belongs to
*/

if (!COM_isAnonUser()) {
    $_GROUPS = SEC_getUserGroups($_USER['uid']);
} else {
    $_GROUPS = SEC_getUserGroups(1);
}

/**
* Global array of current user permissions [read,edit]
*/

$_RIGHTS = explode(',', SEC_getUserPermissions());

switch ($_SERVER['REQUEST_METHOD']) {
case 'POST':
    WS_post();
    break;
case 'PUT':
    WS_put();
    break;
case 'GET':
    WS_get();
    break;
case 'DELETE':
    WS_delete();
    break;
default:
    WS_error(PLG_RET_ERROR);
}

WS_writeSync();

?>
