<?php
// +--------------------------------------------------------------------------+
// | Geeklog 2.0                                                              |
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

/**
* Geeklog common function library
*/
require_once '../lib-common.php';

/**
* Security check to ensure user even belongs on this page
*/
require_once 'auth.inc.php';

require_once $_CONF['path_system'] . 'lib-admin.php';

if (!SEC_inGroup('Root')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the log viewer screen.");
    COM_output($display);
    exit;
}

if (isset($_GET['log'])) {
    $log = COM_applyFilter($_GET['log']);
} else if (isset($_POST['log'])) {
    $log = COM_applyFilter($_POST['log']);
} else {
    $log = '';
}

$log = COM_sanitizeFilename($log, true);
if (empty($log)) {
    $log = 'error.log';
}

$display = '';

$menu_arr = array (
    array('url' => $_CONF['site_admin_url'],
          'text' => $LANG_ADMIN['admin_home'])
);

$display  = COM_startBlock ($LANG_LOGVIEW['log_viewer'],'', COM_getBlockTemplate ('_admin_block', 'header'));
$display .= ADMIN_createMenu( $menu_arr,
                             $LANG_LOGVIEW['info'],
                             $_CONF['layout_url'] . '/images/icons/log_viewer.'. $_IMAGE_TYPE
);

$display .= '<form method="post" action="'.$_CONF['site_admin_url'].'/logviewer.php"><div>';
$display .= $LANG_LOGVIEW['logs'].':&nbsp;&nbsp;&nbsp;';
$files = array();
if ($dir = @opendir($_CONF['path_log'])) {
    while (($file = readdir($dir)) !== false) {
        if (is_file($_CONF['path_log'] . $file) && preg_match('/\.log$/i', $file)) {
            array_push($files,$file);
        }
    }
    closedir($dir);
}
$display .= '<select name="log">';

for ($i = 0; $i < count($files); $i++) {
    $display .= '<option value="' . $files[$i] . '"';
    if ($log == $files[$i]) {
        $display .= ' selected="selected"';
    }
    $display .= '>' . $files[$i] . '</option>';
    next($files);
}
$display .= '</select>&nbsp;&nbsp;&nbsp;&nbsp;';
$display .= '<input type="submit" name="viewlog" value="'.$LANG_LOGVIEW['view'].'"'.XHTML.'>';
$display .= '&nbsp;&nbsp;&nbsp;&nbsp;';
$display .= '<input type="submit" name="clearlog" value="'.$LANG_LOGVIEW['clear'].'"'.XHTML.'>';
$display .= '</div></form>';

if (isset($_POST['clearlog'])) {
    if (@unlink($_CONF['path_log'] . $log)) {
        if ($fd = @fopen($_CONF['path_log'] . $log, 'a')) {
            $timestamp = strftime("%c");
            fputs($fd, "$timestamp - Log File Cleared \n");
            fclose($fd);
            $_POST['viewlog'] = 1;
        }
    }
}
if (isset($_POST['viewlog'])) {
    $display .= '<p><strong>'.$LANG_LOGVIEW['log_file'].': ' . $log . '</strong></p>';
    $display .= '<div style="margin:10px 0 5px;border-bottom:1px solid #cccccc;"></div>';
    $display .= '<pre style="overflow:scroll; height:500px;">';
    $display .= htmlentities(implode('', file($_CONF['path_log'] . $log)), ENT_NOQUOTES, COM_getEncodingt());
    $display .= '</pre>';
}

$display .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

$display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_LOGVIEW['log_viewer']));

COM_output($display);  
exit;
?>
