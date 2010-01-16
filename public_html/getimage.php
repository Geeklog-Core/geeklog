<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | getimage.php                                                              |
// |                                                                           |
// | Shows images outside of the webtree                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
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

/**
* For really strict webhosts, this file an be used to show images in pages that
* serve the images from outside of the webtree to a place that the webserver
* user can actually write too
*
* @author   Tony Bibbs, tony AT tonybibbs DOT com
*
*/

require_once 'lib-common.php';
require_once $_CONF['path_system'] . 'classes/downloader.class.php';

$downloader = new downloader();

$downloader->setLogFile($_CONF['path_log'] . 'error.log');

$downloader->setLogging(true);

$downloader->setAllowedExtensions(array('gif'  => 'image/gif',
                                        'jpg'  => 'image/jpeg',
                                        'jpeg' => 'image/jpeg',
                                        'png'  => 'image/png',
                                        'png'  => 'image/x-png'
                                       )
                                 );
                                 
COM_setArgNames(array('mode', 'image'));
$mode  = COM_applyFilter(COM_getArgument('mode'));
$image = COM_applyFilter(COM_getArgument('image'));

if (strstr($image, '..')) {
    // Can you believe this, some jackass tried to relative pathing to access
    // files they shouldn't have access to?
    COM_accessLog('Someone tried to illegally access files using getimage.php');
    exit;
}

// Set the path properly
switch ($mode) {
    case 'show':
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
        // Hrm, got a bad path, just die
        exit;
}

// Let's see if we don't have a legit file.  If not bail
$pathToImage = $downloader->getPath() . $image;
if (is_file($pathToImage)) {

    // support conditional GET, if possible
    $st = @stat($pathToImage);
    if (is_array($st)) {
        // cf. RFC 2616, Section 3.3.1 Full Date
        $last_mod = str_replace('+0000', 'GMT', gmdate('r', $st['mtime']));
        $etag     = '"' . md5($image) . '"';

        $mod_since  = '';
        $none_match = '';
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            $mod_since = $_SERVER['HTTP_IF_MODIFIED_SINCE'];
        }
        if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
            $none_match = $_SERVER['HTTP_IF_NONE_MATCH'];
        }

        if (($last_mod == $mod_since) && ($etag == $none_match)) {
            // image hasn't change - we're done
            header('HTTP/1.1 304 Not Modified');
            header('Status: 304 Not Modified');
            exit;
        }

        header('Last-Modified: ' . $last_mod);
        header('ETag: ' . $etag);
    }

    if ($mode == 'show') {
        echo '<html><body><img src="' . $_CONF['site_url'] . '/getimage.php?mode=articles&amp;image=' . $image . '" alt=""' . XHTML . '></body></html>';
    } else {
        $downloader->downloadFile($image);
    }
} else {
    $display = COM_errorLog('File, ' . $image . ', was not found in getimage.php');

    // send 404 in any case
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');

    if ($mode == 'show') {
        echo COM_siteHeader('menu') . $display . COM_siteFooter();
    }
}

?>
