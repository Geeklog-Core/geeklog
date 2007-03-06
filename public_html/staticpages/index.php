<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Page Geeklog Plugin 1.4.3                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This is the main page for the Geeklog Static Page Plugin                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
// $Id: index.php,v 1.42 2007/03/06 06:41:32 ospiess Exp $

require_once ('../lib-common.php');

// MAIN

if (!empty ($_USER['uid'])) {
    $noboxes = DB_getItem ($_TABLES['userindex'], 'noboxes',
                           "uid = '{$_USER['uid']}'");
} else {
    $noboxes = 0;
}

COM_setArgNames (array ('page', 'mode'));
$page = COM_applyFilter (COM_getArgument ('page'));
$mode = COM_applyFilter (COM_getArgument ('mode'));
if ($mode != 'print') {
    unset ($mode);
}

$retval = SP_returnStaticpage($page, $mode);

echo $retval;

?>
