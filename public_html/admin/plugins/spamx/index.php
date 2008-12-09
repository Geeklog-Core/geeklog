<?php

// +---------------------------------------------------------------------------+
// | Spam-X plugin 1.0.2                                                       |
// +---------------------------------------------------------------------------+
// | admin/index.php                                                           |
// |                                                                           |
// | Administration page.                                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002-2004 by the following authors:                         |
// |                                                                           |
// | Author:                                                                   |
// | Constructed with the Universal Plugin                                     |
// | Copyright (C) 2002 by the following authors:                              |
// | Tom Willett                 -    twillett@users.sourceforge.net           |
// | Blaine Lang                 -    langmail@sympatico.ca                    |
// | The Universal Plugin is based on prior work by:                           |
// | Tony Bibbs                  -    tony@tonybibbs.com                       |
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

require_once '../../../lib-common.php';
require_once '../../auth.inc.php';

$display = '';

// Only let admin users access this page
if (!SEC_hasRights('spamx.admin')) {
    // Someone is trying to illegally access this page
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("Someone has tried to illegally access the Spam-X Admin page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
    echo $display;
    exit;
}


/**
* Main
*/

$display = COM_siteHeader ('menu', $LANG_SX00['plugin_name']);
$T = new Template ($_CONF['path'] . 'plugins/spamx/templates');
$T->set_file ('admin', 'admin.thtml');
$T->set_var ( 'xhtml', XHTML );
$T->set_var ('site_url', $_CONF['site_url']);
$T->set_var ('site_admin_url', $_CONF['site_admin_url']);
$T->set_var ('header', $LANG_SX00['admin']);
$T->set_var ('plugin_name', $LANG_SX00['plugin_name']);
$T->set_var ('plugin', 'spamx');
$T->parse ('output', 'admin');
$display .= $T->finish ($T->get_var ('output'));

$files = array ();
if ($dir = @opendir ($_CONF['path'] . 'plugins/spamx/')) {
    while (($file = readdir ($dir)) !== false) {
        if (is_file ($_CONF['path'] . 'plugins/spamx/' . $file))
        {
            if (substr ($file, -16) == '.Admin.class.php') {
                $tmp = str_replace ('.Admin.class.php', '', $file);
                array_push ($files, $tmp);
            }
        }
    }
    closedir ($dir);
}
$display .= '<p><b>' . $LANG_SX00['adminc'] . '</b></p><ul>';

foreach ($files as $file) {
    require_once ($_CONF['path'] . 'plugins/spamx/' . $file . '.Admin.class.php');
    $CM = new $file;
    $display .= '<li>' . COM_createLink($CM->link (), $_CONF['site_admin_url']
             . '/plugins/spamx/index.php?command=' . $file) . '</li>';
}
$display .= '<li>' . COM_createLink($LANG_SX00['documentation'],
            $_CONF['site_url'] . '/docs/spamx.html') . '</li>';
$display .= '</ul>';

if (isset ($_REQUEST['command'])) {
    $CM = new $_REQUEST['command'];
    $display .= $CM->display ();
}
$display .= COM_siteFooter (true);

echo $display;

?>
