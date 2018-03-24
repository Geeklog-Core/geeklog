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

$display .= '<form method="post" action="' . $_CONF['site_admin_url'] . '/logviewer.php" class="uk-form"><div>'
    . $LANG_LOGVIEW['logs'] . ':&nbsp;' . PHP_EOL;
$tcc = COM_newTemplate($_CONF['path_layout'] . 'controls');
$tcc->set_file('common', 'common.thtml');
$tcc->set_block('common', 'type-select');
$tcc->set_var('name', 'log');
$items = '';
foreach (glob($_CONF['path_log'] . '*.log') as $file) {
    $file = basename($file);
    $items .= '<option value="' . $file . '"'
        . ($log === $file ? ' selected="selected"' : '') . '>' . $file . '</option>' . PHP_EOL;
}
$tcc->set_var('select_items', $items);
$display .= $tcc->finish($tcc->parse('common', 'type-select'));

$tcc->set_block('common', 'type-submit');
$tcc->set_var('name', 'viewlog');
$tcc->set_var('value', $LANG_LOGVIEW['view']);
$tcc->set_var('lang_button', $LANG_LOGVIEW['view']);
$display .= $tcc->finish($tcc->parse('common', 'type-submit'));

$tcc->set_var('name', 'clearlog');
$tcc->set_var('value', $LANG_LOGVIEW['clear']);
$tcc->set_var('lang_button', $LANG_LOGVIEW['clear']);
$tcc->set_var('onclick', 'return confirm(\'' . $MESSAGE[76] . '\');');
$display .= $tcc->finish($tcc->parse('common', 'type-submit'));
$display .= '</div></form>';

if (isset($_POST['clearlog'])) {
    if (@unlink($_CONF['path_log'] . $log)) {
        $timestamp = strftime("%c");
        @file_put_contents($_CONF['path_log'] . $log, "$timestamp - Log File Cleared " . PHP_EOL, FILE_APPEND);
        $_POST['viewlog'] = 1;
    }
}
if (isset($_POST['viewlog'])) {
    $display .= '<p><strong>' . $LANG_LOGVIEW['log_file'] . ': ' . $log . '</strong></p>'
        . '<div style="margin:10px 0 5px;border-bottom:1px solid #cccccc;"></div>'
        . '<pre style="overflow:scroll; height:500px;">'
        . htmlentities(file_get_contents($_CONF['path_log'] . $log), ENT_NOQUOTES, COM_getEncodingt())
        . '</pre>';
}

$display .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
$output = COM_createHTMLDocument($display, array('pagetitle' => $LANG_LOGVIEW['log_viewer']));
header('Content-Type: text/html; charset=' . COM_getEncodingt());
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
COM_output($output);
