<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | help.php                                                                  |
// |                                                                           |
// | Support for Geeklog installation script.                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Randy Kolenko     - randy AT nextide DOT ca
// |          Matt West         - matt AT mattdanger DOT net                   |
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
// | You don't need to change anything in this file.                           |
// | Please read docs/install.html which describes how to install Geeklog.     |
// +---------------------------------------------------------------------------+
//
// $Id: help.php,v 1.7 2008/06/07 07:56:36 dhaun Exp $

if (!defined ("LB")) {
    define("LB", "\n");
}
if ( !defined( 'XHTML' ) ) {
	define( 'XHTML', ' /' );
}

$language = 'english';
if (isset($_GET['language'])) {
    $lng = $_GET['language'];
} else if (isset($_COOKIE['language'])) {
    // Okay, so the name of the language cookie is configurable, so it may not
    // be named 'language' after all. Still worth a try ...
    $lng = $_COOKIE['language'];
} else {
    $lng = $language;
}
// sanitize value and check for file
$lng = preg_replace('/[^a-z0-9\-_]/', '', $lng);
if (!empty($lng) && is_file('language/' . $lng . '.php')) {
    $language = $lng;
}
require_once 'language/' . $language . '.php';

// $display holds all the outputted HTML and content
if ( defined( 'XHTML' ) ) {
	$display = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
} else {
	$display = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>';
}
if (empty($LANG_DIRECTION)) {
    $LANG_DIRECTION = 'ltr';
}
$display .= '<head>
<meta http-equiv="Content-Type" content="text/html;charset=' . $LANG_CHARSET . '"' . XHTML . '>
<link rel="stylesheet" type="text/css" href="layout/style.css"' . XHTML . '>
<meta name="robots" content="noindex,nofollow"' . XHTML . '>
<title>' . $LANG_INSTALL[0] . '</title>
</head>

<body dir="' . $LANG_DIRECTION . '">
    <div class="header-navigation-container">
        <div class="header-navigation-line">
            <a href="' . $LANG_INSTALL[87] . '" class="header-navigation">' . $LANG_INSTALL[1] . '</a>&nbsp;&nbsp;&nbsp;
        </div>
    </div>
    <div class="header-logobg-container-inner">
        <a class="header-logo" href="http://www.geeklog.net/">
            <img src="layout/logo.png"  width="151" height="56" alt="Geeklog"' . XHTML . '>
        </a>
        <div class="header-slogan">' . $LANG_INSTALL[2] . ' <br' . XHTML . '><br' . XHTML . '></div>
    </div>
    <div class="installation-container">
        <div class="installation-body-container">
            <h1 class="heading">' . $LANG_HELP[0] . '</h1>
            <h2><a name="site_name">' . $LANG_INSTALL[32] . '</a></h2>
            <p class="indent">' . $LANG_HELP[1] . '</p>

            <h2><a name="site_slogan">' . $LANG_INSTALL[33] . '</a></h2>
            <p class="indent">' . $LANG_HELP[2] . '</p>

            <h2><a name="db_type">' . $LANG_INSTALL[34] . '</a></h2>
            <p class="indent">' . $LANG_HELP[3] . '</p>

            <h2><a name="db_host">' . $LANG_INSTALL[39] . '</a></h2>
            <p class="indent">' . $LANG_HELP[4] . '</p>

            <h2><a name="db_name">' . $LANG_INSTALL[40] . '</a></h2>
            <p class="indent">' . $LANG_HELP[5] . '</p>

            <h2><a name="db_user">' . $LANG_INSTALL[41] . '</a></h2>
            <p class="indent">' . $LANG_HELP[6] . '</p>

            <h2><a name="db_pass">' . $LANG_INSTALL[42] . '</a></h2>
            <p class="indent">' . $LANG_HELP[7] . '</p>

            <h2><a name="db_prefix">' . $LANG_INSTALL[43] . '</a></h2>
            <p class="indent">' . $LANG_HELP[8] . '</p>

            <h2><a name="site_url">' . $LANG_INSTALL[45] . '</a></h2>
            <p class="indent">' . $LANG_HELP[9] . '</p>

            <h2><a name="site_admin_url">' . $LANG_INSTALL[47] . '</a></h2>
            <p class="indent">' . $LANG_HELP[10] . '</p>

            <h2><a name="site_mail">' . $LANG_INSTALL[48] . '</a></h2>
            <p class="indent">' . $LANG_HELP[11] . '</p>

            <h2><a name="noreply_mail">' . $LANG_INSTALL[49] . '</a></h2>
            <p class="indent">' . $LANG_HELP[12] . '</p>

            <h2><a name="utf8">' . $LANG_INSTALL[92] . '</a></h2>
            <p class="indent">' . $LANG_HELP[13] . '</p>

            <h2><a name="migrate_file">' . $LANG_MIGRATE[6] . '</a></h2>
            <p class="indent">' . $LANG_HELP[14] . '</p>

            <h2><a name="plugin_upload">' . $LANG_PLUGINS[10] . '</a></h2>
            <p class="indent">' . $LANG_HELP[15] . '</p>

        </div>
    </div>

</body>
</html>' . LB;

echo $display;

?>
