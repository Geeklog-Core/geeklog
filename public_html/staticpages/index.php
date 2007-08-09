<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Page Geeklog Plugin 1.4.4                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This is the main page for the Geeklog Static Page Plugin                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
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
//
// $Id: index.php,v 1.45 2007/08/09 08:03:04 ospiess Exp $

require_once '../lib-common.php';

// MAIN

COM_setArgNames(array('page', 'mode'));
$page = COM_applyFilter(COM_getArgument('page'));
$display_mode = COM_applyFilter(COM_getArgument('disp_mode'));

// from comments display refresh:
if (isset ($_POST['order'])) {
    $comment_order = COM_applyFilter ($_POST['order']);
    $comment_mode = COM_applyFilter ($_POST['mode']);
    $page = COM_applyFilter($_POST['id']);
    if ((strcasecmp ($order, 'ASC') != 0) && (strcasecmp ($order, 'DESC') != 0)) {
        $order = '';
    }
}

if ($mode != 'print') {
    $mode = '';
}

$retval = SP_returnStaticpage($page, $display_mode, $comment_order, $comment_mode);

echo $retval;

?>
