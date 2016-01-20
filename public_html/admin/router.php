<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | router.php                                                                |
// |                                                                           |
// | Geeklog URL routing administration.                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2016-2016 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - mystralkk AT gmail DOT com                   |
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
 * URL routing administration page: Create, edit, delete routing rules
 * for your Geeklog site.
 */

// Geeklog common function library
require_once '../lib-common.php';

// Security check to ensure user even belongs on this page
require_once './auth.inc.php';

$display = '';

if (!SEC_hasRights('url_routing.edit')) {
    $display = COM_createHTMLDocument(
        COM_showMessageText($MESSAGE[29], $MESSAGE[30]),
        array('pagetitle' => $MESSAGE[30])
    );
    COM_accessLog("User {$_USER['username']} tried to illegally access the URL routing administration screen");
    COM_output($display);
    exit;
}

