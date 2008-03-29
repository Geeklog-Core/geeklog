<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | help.php                                                                  |
// |                                                                           |
// | Support for Geeklog installation script.                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
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
// $Id: help.php,v 1.3 2008/03/29 22:17:47 mwest Exp $

if (!defined ("LB")) {
    define("LB", "\n");
}
if ( !defined( 'XHTML' ) ) {
	define( 'XHTML', ' /' );
}

$language = (isset( $_GET['language'] ) && !empty( $_GET['language'] )) ? $_GET['language'] : 'english';
require_once( 'language/' . $language . '.php' );

// $display holds all the outputted HTML and content
if ( defined( 'XHTML' ) ) {
	$display = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
} else {
	$display = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>';
}
$display .= '<head>
<meta http-equiv="Content-Type" content="text/html;charset=' . $LANG_CHARSET . '"' . XHTML . '>
<link rel="stylesheet" type="text/css" href="layout/style.css"' . XHTML . '>
<meta name="robots" content="noindex,nofollow"' . XHTML . '>
<title>' . $LANG_INSTALL[0] . '</title>
</head>

<body dir="ltr">
    <div class="header-navigation-container">
        <div class="header-navigation-line">
            <a href="' . $LANG_INSTALL[87] . '" class="header-navigation">' . $LANG_INSTALL[1] . '</a>&nbsp;&nbsp;&nbsp;
        </div>
    </div>
    <div class="header-logobg-container-outer">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="header-logobg-container-inner">
            <tr>
                <td class="header-logobg-left">
                    <a href="http://www.geeklog.net/"><img src="layout/logo.png" width="151" height="56" alt="Geeklog" border="0"' . XHTML . '></a>
                </td>
                <td class="header-logobg-right">
                    <div class="site-slogan">' . $LANG_INSTALL[2] . ' <br' . XHTML . '><br' . XHTML . '>
                </td>
            </tr>
        </table>
    </div>
    <div class="installation-container">
        <div class="installation-body-container">
            <h1 class="heading">' . $LANG_HELP[0] . '</h1>
            <h2><a name="site_name">' . $LANG_INSTALL[32] . '</a></h2>
            <p>' . $LANG_HELP[1] . '</p>

            <h2><a name="site_slogan">' . $LANG_INSTALL[33] . '</a></h2>
            <p>' . $LANG_HELP[2] . '</p>

            <h2><a name="db_type">' . $LANG_INSTALL[34] . '</a></h2>
            <p>' . $LANG_HELP[3] . '</p>

            <h2><a name="db_host">' . $LANG_INSTALL[39] . '</a></h2>
            <p>' . $LANG_HELP[4] . '</p>

            <h2><a name="db_name">' . $LANG_INSTALL[40] . '</a></h2>
            <p>' . $LANG_HELP[5] . '</p>

            <h2><a name="db_user">' . $LANG_INSTALL[41] . '</a></h2>
            <p>' . $LANG_HELP[6] . '</p>

            <h2><a name="db_pass">' . $LANG_INSTALL[42] . '</a></h2>
            <p>' . $LANG_HELP[7] . '</p>

            <h2><a name="db_prefix">' . $LANG_INSTALL[43] . '</a></h2>
            <p>' . $LANG_HELP[8] . '</p>

            <h2><a name="site_url">' . $LANG_INSTALL[45] . '</a></h2>
            <p>' . $LANG_HELP[9] . '</p>

            <h2><a name="site_admin_url">' . $LANG_INSTALL[47] . '</a></h2>
            <p>' . $LANG_HELP[10] . '</p>

            <h2><a name="site_mail">' . $LANG_INSTALL[48] . '</a></h2>
            <p>' . $LANG_HELP[11] . '</p>

            <h2><a name="noreply_mail">' . $LANG_INSTALL[49] . '</a></h2>
            <p>' . $LANG_HELP[12] . '</p>

        </div>
    </div>

</body>
</html>' . LB;

echo $display;

?>