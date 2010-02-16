<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This is the main page for the Geeklog Static Pages Plugin                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
* Display a Static Page
*
* @package StaticPages
* @subpackage public_html
*/

/**
* Geeklog common function library
*/
require_once '../lib-common.php';

if (!in_array('staticpages', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}


// MAIN

COM_setArgNames(array('page', 'disp_mode'));
$page = COM_applyFilter(COM_getArgument('page'));
$display_mode = COM_applyFilter(COM_getArgument('disp_mode'));
$query = '';
if (isset($_REQUEST['query'])) {
    $query = COM_applyfilter($_GET['query']);
}

// from comments display refresh:
if (isset($_REQUEST['order'])) {
    $comment_order = COM_applyFilter($_REQUEST['order']);
    $comment_mode  = COM_applyFilter($_REQUEST['mode']);
    if (isset($_REQUEST['cpage'])) {
        $comment_page = COM_applyFilter($_REQUEST['cpage']);
    }
    if ((strcasecmp($comment_order, 'ASC') != 0) &&
            (strcasecmp($comment_order, 'DESC') != 0)) {
        $comment_order = '';
    }
} else {
    $comment_order = '';
    $comment_mode  = '';
    $comment_page = 1;
}

if ($display_mode != 'print') {
    $display_mode = '';
}

$msg = 0;
if (isset($_GET['msg'])) {
    $msg = COM_applyFilter($_GET['msg'], true);
    if ($msg <= 0) {
        $msg = 0;
    }
}

$retval = SP_returnStaticpage($page, $display_mode, $comment_order, $comment_mode, $comment_page, $msg, $query);

if ($display_mode == 'print') {
    header('Content-Type: text/html; charset=' . COM_getCharset());
    if (! empty($_CONF['frame_options'])) {
        header('X-FRAME-OPTIONS: ' . $_CONF['frame_options']);
    }
}

COM_output($retval);

?>
