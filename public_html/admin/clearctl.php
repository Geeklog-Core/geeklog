<?php

// +--------------------------------------------------------------------------+
// | Geeklog 2.2                                                              |
// +---------------------------------------------------------------------------+
// | clearctl.php                                                             |
// |                                                                          |
// | Removed all cached templates                                             |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2008 by the following authors:                             |
// |                                                                          |
// | Mark R. Evans          mark AT glfusion DOT org                          |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | This program is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU General Public License              |
// | as published by the Free Software Foundation; either version 2           |
// | of the License, or (at your option) any later version.                   |
// |                                                                          |
// | This program is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with this program; if not, write to the Free Software Foundation,  |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.          |
// |                                                                          |
// +--------------------------------------------------------------------------+

require_once '../lib-common.php';

$display = '';

if (!SEC_inGroup('Root') && !SEC_inGroup('Theme Admin')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the clear cache.");
    COM_output($display);
    exit;
}

/*
 * Main processing
 */
 
// Clearing Theme Template Cache
CTL_clearCache(); 

// Clearing Resource Cache (CSS, and Javascript concatenated and minified files)
Geeklog\Cache::clear(); 

// ********************************
// Clean out Data directory (includes things like temp uploaded plugin files, user batch files, etc...)
$leave_dirs = array('cache', 'layout_cache', 'layout_css');
$leave_files = array('cacert.pem', 'README');
COM_cleanDirectory($_CONF['path_data'], $leave_dirs, $leave_files);

// ********************************
// Clean out File Manager Thumbnail Files (article directory is also used by article editor to create thumbs of images)
// See Geeklog Environment Check or Geeklog Installer Check Permissions for complete list of all image directories and how they are used by Geeklog
$leave_dirs = array();
$leave_files = array('index.html');
COM_cleanDirectory($_CONF['path_images'] . '_thumbs/articles/', $leave_dirs, $leave_files);

$leave_dirs = array();
$leave_files = array('index.html');
COM_cleanDirectory($_CONF['path_images'] . '_thumbs/userphotos/', $leave_dirs, $leave_files);

$leave_dirs = array();
$leave_files = array('index.html');
COM_cleanDirectory($_CONF['path_images'] . '/library/Image/_thumbs/', $leave_dirs, $leave_files);

$leave_dirs = array('articles', 'userphotos');
$leave_files = array();
COM_cleanDirectory($_CONF['path_images'] . '_thumbs/', $leave_dirs, $leave_files);

// ********************************
// Allow Plugins to clear any cached items
PLG_clearCache(); 

COM_redirect($_CONF['site_admin_url'] . '/index.php?msg=500');
