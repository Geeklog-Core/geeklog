<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | getImage.php                                                              |
// |                                                                           |
// | Shows images outside of the webtree                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
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
// $Id: getImage.php,v 1.1 2003/12/31 05:44:02 tony Exp $

/**
* For really strict webhosts, this file an be used to show images in pages that
* serve the images from outside of the webtree to a place that the webserver
* user can actually write too
*
* @author   Tony Bibbs <tony@tonybibbs.com>
*
*/

require_once 'lib-common.php';

require_once $_CONF['path_system'] . 'classes/downloader.class.php';

$downloader = new downloader();

$downloader->setLogFile($_CONF['path_log'] . 'error.log');

$downloader->setLogging(true);

$downloader->setAllowedExtensions(array('gif' => 'image/gif',
                                        'jpg' => 'image/jpeg',
                                        'jpeg' => 'image/jpeg',
                                        'png' => 'image/x-png',
                                       )
                                 );
                                 
$mode = '';
if (isset($HTTP_GET_VARS['mode'])) {
    $mode = $HTTP_GET_VARS['mode'];
}
$image = '';
if (isset($HTTP_GET_VARS['image'])) {
    $image = $HTTP_GET_VARS['image'];
}
if (strstr($image, '..')) {
    // Can you believe this, some jackass tried to relative pathing to access files they
    // shouldn't have access to?
    COM_errorLog('Someone tried to illegally access files using getImage.php');
    exit;
}

switch ($mode) {
    case 'articles':
        $downloader->setPath($_CONF['path_images'] . 'articles/');
        break;
    case 'topics':
        $downloader->setPath($_CONF['path_images'] . 'topics/');
        break;
    case 'userphotos':
        $downloader->setPath($_CONF['path_images'] . 'userphotos/');
        break;
    default:
}

$downloader->downloadFile($image);

?>