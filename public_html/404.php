<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | 404.php                                                                   |
// |                                                                           |
// | Geeklog "404 Not Found" page                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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

require_once 'lib-common.php';

$display = COM_siteHeader('menu', $LANG_404[1]);
$display .= COM_startBlock($LANG_404[1]);
if (isset($_SERVER['SCRIPT_URI'])) {
    $url = strip_tags($_SERVER['SCRIPT_URI']);
} else {
    $pos = strpos($_SERVER['REQUEST_URI'], '?');
    if ($pos === false) {
        $request = $_SERVER['REQUEST_URI'];
    } else {
        $request = substr($_SERVER['REQUEST_URI'], 0, $pos);
    }
    $url = 'http://' . $_SERVER['HTTP_HOST'] . strip_tags($request);
}
$display .= sprintf($LANG_404[2], $url);
$display .= $LANG_404[3];
$display .= COM_endBlock();
$display .= COM_siteFooter();

COM_output($display);

?>
