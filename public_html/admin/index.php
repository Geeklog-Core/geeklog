<?php
###############################################################################
# /admin/index.php
# This is the admin index page that does nothing more that login you in.
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

/**
* Geeklog common function library
*/
require_once '../lib-common.php';

/**
* Security check to ensure user even belongs on this page
*/
require_once 'auth.inc.php';

// MAIN
if (isset ($_GET['mode']) && ($_GET['mode'] == 'logout')) {
    print COM_refresh($_CONF['site_url'] . '/users.php?mode=logout');
}

/**
* Display a reminder to execute the security check script
*
* @return   string      HTML for security reminder (or empty string)
*/
function security_check_reminder()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $MESSAGE;

    $retval = '';

    if (!SEC_inGroup ('Root')) {
        return $retval;
    }

    $done = DB_getItem ($_TABLES['vars'], 'value', "name = 'security_check'");
    if ($done != 1) {
        $retval .= COM_showMessage(92);
    }

    return $retval;
}

$display = COM_showMessageFromParameter()
         .  security_check_reminder()
         .  COM_commandControl();

$display = COM_createHTMLDocument($display, array('pagetitle' => $LANG29[34]));

COM_output($display);

?>
