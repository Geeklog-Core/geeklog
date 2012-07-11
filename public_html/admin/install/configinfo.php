<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | configinfo.php                                                            |
// |                                                                           |
// | Display current configuration settings                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Jeffrey Schoolcraft  - dream AT dr3amscap3 DOT com               |
// |          Dirk Haun            - dirk AT haun-online DOT de                |
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
* This script will display file and permission information based on settings in
* the configuration.  This is meant to be used as a support tool when asked
* questions in #geeklog.
*
* @author   Jeffrey Schoolcraft, dream AT dr3amscap3 DOT com
*
*/

if (file_exists('../../lib-common.php')) {
    require_once '../../lib-common.php';
} else {
    die("Sorry, lib-common.php not found ...");
}

$highlight_on     = '#EFEFEF';
$highlight_off    = '#D9D9D9';

if (isset($_CONF['site_url']) &&
        strpos($_CONF['site_url'], 'example.com') === false) {
    $docs = $_CONF['site_url'] . '/docs/english/config.html#desc_';
} else {
    $docs = '../../docs/english/config.html#desc_';
}

if (isset($_CONF['mail_settings']['password'])) {
    unset($_CONF['mail_settings']['password']);
}

$display = "<html>\n<head><title>Configuration Settings</title></head>\n<body>\n";
$n = 0;
$display .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="border: thin black solid;">';

foreach ($_CONF as $option => $value) {
    $display .= '<tr';
    if ($n % 2 == 0) {
        $display .= ' style="background-color: ' . $highlight_on . '">';
    } else {
        $display .= ' style="background-color: ' . $highlight_off . '">';
    }
    $display .= '<td style="border: thin black solid; padding: 2px;"><strong>$_CONF[\'<a href="'
              . $docs . $option . '">' . $option . '</a>\']</strong></td>';
    if (is_array($value)) {
        ob_start();
        print_r($value);
        $value=nl2br(ob_get_contents());
        ob_end_clean();
    } elseif (is_bool($value)) {
        $value = ($value === false) ? 'false' : 'true';
    } elseif (eregi('[a-z]+html', $option)) {
        $value = htmlentities($value);
    } elseif (!isset($value)) {
        $value = '&nbsp;';
    }
    $display .= '<td style="border: thin black solid; padding: 2px;"><strong>' . $value . '</strong></td>';
    $display .= '</tr>';
    $n++;
}
$display .= "</table>\n</body>\n</html>";

echo $display;

?>
