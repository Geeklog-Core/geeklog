<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
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

if (isset($_CONF['site_url']) && (strpos($_CONF['site_url'], 'example.com') === false)) {
    $docs = $_CONF['site_url'] . '/docs/english/config.html#desc_';
} else {
    $docs = '../../docs/english/config.html#desc_';
}

if (isset($_CONF['mail_settings']['password'])) {
    unset($_CONF['mail_settings']['password']);
}

if (!isset($LANG_DIRECTION)) {
    $LANG_DIRECTION = 'ltr';
}
$env['rtl'] = $LANG_DIRECTION ==='rtl' ? '-rtl' : '';

$display = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex,nofollow">
    <title>Configuration Settings</title>
    <link rel="stylesheet" type="text/css" href="../../vendor/uikit3/css/uikit' . $env['rtl'] . '.min.css">
    <link rel="stylesheet" type="text/css" href="layout/style' . $env['rtl'] . '.css">
    <script src="../../vendor/uikit3/js/uikit.min.js"></script>
    <script src="../../vendor/uikit3/js/uikit-icons.min.js"></script>
</head>

<body dir="' . $LANG_DIRECTION . '">';

$display .= '
    <div class="uk-container">
        <section class="uk-section uk-section-default uk-section-small">
            <h1>Configuration Settings</h1>
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-striped">
                    <thead><tr><th>Option</th><th>Value</th></tr></thead>
                    <tbody>';
                
foreach ($_CONF as $option => $value) {
    $display .= '<tr>';
    $display .= '<td><strong>$_CONF[\'<a href="'
              . $docs . $option . '">' . $option . '</a>\']</strong></td>';
    if (is_array($value)) {
        ob_start();
        print_r($value);
        $value = COM_nl2br(ob_get_clean());
    } elseif (is_bool($value)) {
        $value = ($value === false) ? 'false' : 'true';
    } elseif (MBYTE_eregi('[a-z]+html', $option)) {
        $value = htmlentities($value);
    } elseif (!isset($value)) {
        $value = '&nbsp;';
    }
    $display .= '<td>' . $value . '</td>';
    $display .= '</tr>';
}
$display .= '
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>';

echo $display;
