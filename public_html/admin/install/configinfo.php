<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | check.php                                                                 |
// | Geeklog check installation script                                         |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002 by the following authors:                              |
// |                                                                           |
// | Authors: Dirk Haun        - dirk@haun-online.de                           |
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
// $Id: configinfo.php,v 1.2 2002/07/07 16:21:16 dreamscape Exp $

/**
* This script will display file and permission information based on settings in
* config.php  This is meant to be as a support tool when asked questions in #geeklog
*
*
* @author   Jeffrey Schoolcraft <dream@dr3amscap3.com>
*
*/

require_once('../../../config.php');

$highlight_on 	= '#bcbcbc';
$highlight_off	= '#3399FF';

$display = '';
$n = 0;
$display .= '<table width=100% cellspacing=0 cellpadding=0 border=0 style="border: thin black solid;">';

foreach($_CONF as $option => $value) {
	$display .= '<tr';
	if ($n % 2 == 0) {
		$display .= ' style="background-color: ' . $highlight_on . '">';
	} else {
		$display .= ' style="background-color: ' . $highlight_off . '">';
	}
	$display .= '<td style="border: thin black solid;"><strong>$_CONF["' . $option . '"]</strong></td>';
	if (is_array($value)) {
		ob_start();
		print_r($value);
		$value=nl2br(ob_get_contents());
		ob_end_clean();
	} elseif (eregi('[a-z]+html', $option)) {
		$value = htmlentities($value);
	} elseif (! isset($value)) {
		$value = '&nbsp;';
	}
	$display .= '<td style="border: thin black solid;"><strong>' . $value . '</strong></td>';
	$display .= '</tr>';
	$n++;
}
$display .= '</table>';

echo $display;
