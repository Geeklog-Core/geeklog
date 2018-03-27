<?php
// +--------------------------------------------------------------------------+
// | Geeklog 2.1                                                              |
// +--------------------------------------------------------------------------+
// | logviewer.php                                                            |
// |                                                                          |
// | Geeklog log viewer.                                                      |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 by the following authors:                        |
// |                                                                          |
// | Mark R. Evans          mark AT glfusion DOT org                          |
// |                                                                          |
// | Based on the Original work by                                            |
// | Copyright (C) 2000-2008 by the following authors:                        |
// |                                                                          |
// | Authors: Tom Willett        - twillett@users.sourceforge.net             |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | This program is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU General Public License              |
// | as published by the Free Software Foundation; either version 2           |
// | of the License, or (at your option) any later version.                   |
// |                                                                          |
// | This program is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with this program; if not, write to the Free Software Foundation,  |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.          |
// |                                                                          |
// +--------------------------------------------------------------------------+

// Geeklog common function library
require_once '../lib-common.php';

// Security check to ensure user even belongs on this page
require_once 'auth.inc.php';
require_once $_CONF['path_system'] . 'lib-admin.php';

if (!SEC_inGroup('Root')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the log viewer screen.");
    COM_output($display);
    exit;
}

$log = Geeklog\Input::fGetOrPost('log', '');
$log = COM_sanitizeFilename($log, true);
if (empty($log)) {
    $log = 'error.log';
}

$display = '';

$menu_arr = array(
    array(
        'url'  => $_CONF['site_admin_url'],
        'text' => $LANG_ADMIN['admin_home'],
    ),
);

$display = COM_startBlock($LANG_LOGVIEW['log_viewer'], '', COM_getBlockTemplate('_admin_block', 'header'))
    . ADMIN_createMenu($menu_arr,
        $LANG_LOGVIEW['info'],
        $_CONF['layout_url'] . '/images/icons/log_viewer.' . $_IMAGE_TYPE
    );
    
    
$T = new Template($_CONF['path_layout'] . 'admin');
$T->set_file('page','logviewer.thtml');

$T->set_var('lang_logs', $LANG_LOGVIEW['logs']);
    
$items = '';
foreach (glob($_CONF['path_log'] . '*.log') as $file) {
    $file = basename($file);
    $items .= '<option value="' . $file . '"'
        . ($log === $file ? ' selected="selected"' : '') . '>' . $file . '</option>' . PHP_EOL;
}
$T->set_var('log_items', $items);

$T->set_var('lang_log_view', $LANG_LOGVIEW['view']);
$T->set_var('lang_log_clear', $LANG_LOGVIEW['clear']);
$T->set_var('lang_confirm_del_message', $MESSAGE[76]);

if (isset($_POST['clearlog'])) {
    if (@unlink($_CONF['path_log'] . $log)) {
        $timestamp = strftime("%c");
        @file_put_contents($_CONF['path_log'] . $log, "$timestamp - Log File Cleared " . PHP_EOL, FILE_APPEND);
        $_POST['viewlog'] = 1;
    }
}
if (isset($_POST['viewlog'])) {
    $T->set_var('lang_log_file', $LANG_LOGVIEW['log_file']);
    $T->set_var('log_filename', $log);
    $T->set_var('log_contents', htmlentities(file_get_contents($_CONF['path_log'] . $log), ENT_NOQUOTES, COM_getEncodingt()));
}

$T->parse('output', 'page');
$display .= $T->finish($T->get_var('output'));
$display .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

$output = COM_createHTMLDocument($display, array('pagetitle' => $LANG_LOGVIEW['log_viewer']));
header('Content-Type: text/html; charset=' . COM_getEncodingt());
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
COM_output($output);
