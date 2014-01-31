<?php

// +---------------------------------------------------------------------------+
// | Spam-X plugin 1.2                                                         |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Spam-X administration page.                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002-2009 by the following authors:                         |
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

/**
* Spam-X administration page
*
* @package Spam-X
* @subpackage admin
*/

/**
* Geeklog common function library and Admin authentication
*/
require_once '../../../lib-common.php';
require_once '../../auth.inc.php';
require_once $_CONF['path_system'] . '/lib-admin.php';

if (!in_array('spamx', $_PLUGINS)) {
    COM_handle404();
    exit;
}

$display = '';

// Only let admin users access this page
if (!SEC_hasRights('spamx.admin')) {
    // Someone is trying to illegally access this page
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("Someone has tried to illegally access the Spam-X Admin page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: {$_SERVER['REMOTE_ADDR']}", 1);
    COM_output($display);
    exit;
}


/**
* Main
*/

$display = '';

$menu_arr = array (
    array('url' => $_CONF['site_admin_url'],
          'text' => $LANG_ADMIN['admin_home'])
);

$display = COM_startBlock(
    $LANG_SX00['plugin_name'], '', COM_getBlockTemplate('_admin_block', 'header')
);
$display .= ADMIN_createMenu($menu_arr, $LANG_SX00['adminc'], plugin_geticon_spamx());

$files = array();

if ($dir = @opendir($_CONF['path'] . 'plugins/spamx/')) {
    while (($file = readdir($dir)) !== false) {
        if (is_file($_CONF['path'] . 'plugins/spamx/' . $file)) {
            if (substr($file, -16) === '.Admin.class.php') {
                $tmp = str_replace('.Admin.class.php', '', $file);
                array_push($files, $tmp);
            }
        }
    }

    closedir($dir);
}

$header_arr = array(
    array(
        'text'  => $LANG_SX00['plugin'],
        'field' => 'title'
    ),
    array(
        'text'  => $LANG33[30],
        'field' => 'regdate'
    ),
    array(
        'text'  => $LANG_SX00['action'],
        'field' => 'edit'
    )
);
$data_arr = array();

foreach ($files as $file) {
    require_once $_CONF['path'] . 'plugins/spamx/' . $file . '.Admin.class.php';

    $CM = new $file;
    $action  = 'Edit';
    $link    = $CM->linkText;
    $regdate = '-';

    if (strpos($link, 'Edit ') !== false) {
        $link = substr($link, 5);
        $regdate = DB_getItem($_TABLES['spamx'], 'regdate', "name = '{$CM->moduleName}' ORDER BY regdate DESC ");
    } else {
        $action = 'View';
    }

    $data_arr[] = array(
        'title'   => $link,
        'regdate' => $regdate,
        'edit'    => COM_createLink(
            $LANG_SX00[strtolower($action)],
            $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=' . $file
        )
    );
}

$data_arr[] = array(
    'title'   => $LANG_SX00['documentation'],
    'regdate' => '-',
    'edit'    => COM_createLink(
        $LANG_SX00['view'],
        plugin_getdocumentationurl_spamx('index')
    )
);
$display.= ADMIN_simpleList(null, $header_arr, null, $data_arr);

if (isset($_REQUEST['command'])) {
    $cmd = COM_applyFilter($_REQUEST['command']);

    if (!empty($cmd) && in_array($cmd, $files)) {
        $CM = new $cmd;
        $display .= $CM->display();
    }
}

$display .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

$display = COM_createHTMLDocument(
    $display,
    array('pagetitle' => $LANG_SX00['plugin_name'])
);

COM_output($display);

?>
