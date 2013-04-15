<?php
// +--------------------------------------------------------------------------+
// | Geeklog 2.0                                                              |
// +--------------------------------------------------------------------------+
// | lib-template.php                                                         |
// |                                                                          |
// | Geeklog Caching Template Library (CTL)                                   | 
// +--------------------------------------------------------------------------+
// | Copyright (C) 2008-2009 by the following authors:                        |
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

// this file can't be used on its own
if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-template.php') !== false) {
    die('This file can not be used on its own!');
}

$TEMPLATE_OPTIONS['hook']['set_root'] = 'CTL_setTemplateRoot';

/**
* Returns possible theme template directories.  
*
* @param    string  $root    Path to template root
* @return   array            Theme template directories
*/
function CTL_setTemplateRoot($root) {
    global $_CONF;

    $retval = array();

    if (!is_array($root)) {
        $root = array($root);
    }

    foreach ($root as $r) {
        if (substr($r, -1) == '/') {
            $r = substr($r, 0, -1);
        }
        if ( strpos($r,"plugins") != 0 ) {
            $p = str_replace($_CONF['path'],$_CONF['path_themes'] . $_CONF['theme'] . '/', $r);
            $x = str_replace("/templates", "",$p);
            $retval[] = $x;
        }
        if ( $r != '' ) {
            $retval[] = $r . '/custom';
            $retval[] = $r;
            $retval[] = $_CONF['path_themes'] . $_CONF['theme_default'] . '/' .
                substr($r, strlen($_CONF['path_layout']));
        }
    }
    return $retval;
}

function CTL_clearCacheDirectories($path, $needle = '')
{
    if ( $path[strlen($path)-1] != '/' ) {
        $path .= '/';
    }
    if ($dir = @opendir($path)) {
        while ($entry = readdir($dir)) {
            if ($entry == '.' || $entry == '..' || is_link($entry) || $entry == '.svn' || $entry == 'index.html') {
                continue;
            } elseif (is_dir($path . $entry)) {
                CTL_clearCacheDirectories($path . $entry, $needle);
                @rmdir($path . $entry);
            } elseif (empty($needle) || strpos($entry, $needle) !== false) {
                @unlink($path . $entry);
            }
        }
        @closedir($dir);
    }
}


function CTL_clearCache($plugin='')
{
    global $TEMPLATE_OPTIONS, $_CONF, $_SYSTEM;

    if (!empty($plugin)) {
        $plugin = '__' . $plugin . '__';
    }

    CTL_clearCacheDirectories($_CONF['path_data'] . 'layout_cache/', $plugin);

    if ( $_SYSTEM['use_direct_style_js'] ) {
        foreach (glob($_CONF['path_html'].$_CONF['css_cache_filename']."*.*") as $filename) {
            @unlink($filename);
        }
        foreach (glob($_CONF['path_html'].$_CONF['js_cache_filename']."*.*") as $filename) {
            @unlink($filename);
        }
    }

}

?>
