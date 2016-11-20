<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog installation script.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Matt West         - matt AT mattdanger DOT net                   |
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
// | You don't need to change anything in this file.  Please read              |
// | docs/english/install.html which describes how to install Geeklog.         |
// +---------------------------------------------------------------------------+

define('PATH_INSTALL', __DIR__ . '/');
define('PATH_LAYOUT', PATH_INSTALL . 'layout');
define('BASE_FILE', str_replace('\\', '/', __FILE__));

require_once __DIR__ . '/classes/micro_template.class.php';
require_once __DIR__ . '/classes/installer.class.php';

$installer = new Installer();
$installer->run();
