<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.7                                                   |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This is the main page for the Geeklog Static Pages Plugin                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
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
 * @package    StaticPages
 * @subpackage public_html
 */

// Geeklog common function library. If VERSION set then lib-common already loaded. Check required for URL Routing functionality
if (!defined('VERSION')) {
    require_once '../lib-common.php';
}

// Required to declare global variables for URL Routing functionality (as scope changes)
global $_PLUGINS;

if (!in_array('staticpages', $_PLUGINS)) {
    COM_handle404();
    exit;
}

// MAIN

COM_setArgNames(array('page', 'disp_mode'));
$page = COM_applyFilter(COM_getArgument('page'));
$display_mode = COM_applyFilter(COM_getArgument('disp_mode'));
$query = Geeklog\Input::fRequest('query', '');

TOPIC_getTopic('staticpages', $page);

// from comments display refresh:
if (isset($_REQUEST['order'])) {
    $comment_order = Geeklog\Input::fRequest('order');
    //$comment_mode = Geeklog\Input::fRequest('mode');
    $comment_mode = Geeklog\Input::fRequest('mode', Geeklog\Input::fRequest('format', ''));
    if (isset($_REQUEST['cpage'])) {
        $comment_page = Geeklog\Input::fRequest('cpage');
    } else {
        $comment_page = 1;
    }
    if ((strcasecmp($comment_order, 'ASC') != 0) &&
        (strcasecmp($comment_order, 'DESC') != 0)
    ) {
        $comment_order = '';
    }
} else {
    $comment_order = '';
    $comment_mode = '';
    $comment_page = 1;
}

if ($display_mode !== 'print') {
    $display_mode = '';
}

$msg = (int) Geeklog\Input::fGet('msg', 0);
if ($msg <= 0) {
    $msg = 0;
}

// Handle just template staticpage security here, rest done in services.
// Cannot view template staticpages directly. If template staticpage bail here
// if user doesn't have edit rights.
if (DB_getItem($_TABLES['staticpage'], 'template_flag', "sp_id = '$page'") == 1) {
    if (SEC_hasRights('staticpages.edit')) {
        $perms = SP_getPerms('', '3');
        if (!empty($perms)) {
            $perms = ' AND ' . $perms;
        }
        if (DB_getItem($_TABLES['staticpage'], 'sp_id', "sp_id = '$page'" . $perms) == '') {
            COM_handle404();
            exit;
        }
    } else {
        COM_handle404();
        exit;
    }
}

$retval = SP_returnStaticpage($page, $display_mode, $comment_order, $comment_mode, $comment_page, $msg, $query);

if ($display_mode === 'print') {
    header('Content-Type: text/html; charset=' . COM_getCharset());
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');

    if (!empty($_CONF['frame_options'])) {
        header('X-FRAME-OPTIONS: ' . $_CONF['frame_options']);
    }
}

COM_output($retval);
