<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | language.php                                                              |
// |                                                                           |
// | Geeklog language administration page.                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2016      by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - mystralkk AT gmail DOT come                  |
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

global $_CONF, $LANG_ADMIN;

use Geeklog\Input;

// Geeklog common function library
require_once './../lib-common.php';

// Security check to ensure user even belongs on this page
require_once './auth.inc.php';

// Include admin library
require_once $_CONF['path_system'] . 'lib-admin.php';

// Include Language class
require_once $_CONF['path_system'] . 'classes/language.class.php';

// Make sure user has rights to access this page
Language::checkAccessRights();

// Main
$mode = Input::post('mode', Input::get('mode', ''));

switch ($mode) {
    case 'list':
        Language::adminShowList();
        break;

    case 'edit':
        Language::adminShowEditor();
        break;

    case $LANG_ADMIN['save']:
        Language::adminSave();
        break;

    case $LANG_ADMIN['delete']:
        Language::adminDelete();
        break;

    default:
        if (isset($_POST['delitem'])) {
            Language::adminMassDelete();
        } else {
            Language::adminShowList();
        }

        break;
}
