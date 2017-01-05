<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | style.css.php                                                             |
// |                                                                           |
// | Preprocessor for CSS theme files                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2012 by the following authors:                              |
// |                                                                           |
// | Authors: Rouslan Placella  - rouslan@placella.com                         |
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

require_once '../../../siteconfig.php';

// get theme name
if (!isset($_GET['theme'])) {
    exit;
}
$theme = $_GET['theme'];

// get package name
if (!isset($_GET['package'])) {
    exit;
}
$package_name = $_GET['package'];

// get lang directions
$LANG_DIRECTION = 'ltr'; // need to set this for themes function.php file
if (isset($_GET['dir']) && $_GET['dir'] === 'rtl') {
    $LANG_DIRECTION = 'rtl';
}

// set path variables
$path_html = dirname(dirname(dirname(getcwd()))); // Should always be the directory above
$path_themes = $path_html . '/layout/';
$path_layout = $path_themes . $theme . '/';

// set etag file name and path
// have moved or renamed /data directory, please change the following line accordingly.
$etag_filename =  $_CONF['path'] . 'data/layout_css/' . $theme . '_' . $package_name. '_' . $LANG_DIRECTION . '_etag.cache';

// get theme info
if (!file_exists($path_layout . 'functions.php')) {
    exit;
}
require_once $path_layout . 'functions.php';

// get the configuration values from the theme
$theme_default = '';
$path_layout_default = '';
$func = "theme_config_" . $theme;
if (function_exists($func)) {
    $theme_config = $func();
    if (isset($theme_config['theme_default'])) {
        $theme_default = $theme_config['theme_default'];
        $path_layout_default = $path_themes . $theme_default . '/';
        // reset fake config theme var to default so when fuction below loads in css files it will point to default
    }
}

$cssfiles = array();

// load in default theme css files
if (!empty($theme_default)) {
    if (!file_exists($path_layout_default . 'functions.php')) {
        exit;
    }
    require_once $path_layout_default . 'functions.php';

    // include scripts on behalf of the theme
    $_CONF['theme'] = $theme_default; // Need to set this for default themes function.php file

    $func = "theme_css_" . $theme_default;
    if (function_exists($func)) {
        $css_packages = $func();
        foreach($css_packages as $package) {
            if ($package['name'] === $package_name) {
                $cssfiles = $package['css_items'];
                break;
            }
        }
    }
}

// include scripts on behalf of the theme
$_CONF['theme'] = $theme; // Need to set this for themes function.php file

$func = "theme_css_" . $theme;
if (function_exists($func)) {
    $css_packages = $func();
    foreach($css_packages as $package) {
        if ($package['name'] === $package_name) {
            $cssfiles = array_merge($cssfiles, $package['css_items']);
            break;
        }
    }
}

// sort theme css files based on priority if needed
$priority = array();
foreach($cssfiles as $k => $d) {
    $priority[$k] = $d['priority'];
}
array_multisort($priority, SORT_ASC, $cssfiles);

if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
    if (is_readable($etag_filename)) {
        $etag = file_get_contents($etag_filename);
        if (!empty($etag) AND (trim($_SERVER['HTTP_IF_NONE_MATCH'], '"\'') === $etag)) {
            header('HTTP/1.1 304 Not Modified');
            header('Status: 304 Not Modified');
            exit;
        }
    }
}

// creates a new ETag value and saves it into the file
$etag = md5(microtime(TRUE));
@file_put_contents($etag_filename, $etag);

// Send correct header type:
header('Content-Type: text/css; charset=UTF-8');
// Add Cache Expire in 1 week
header('Cache-control: must-revalidate');
header('Expires: '.gmdate('D, d M Y H:i:s', time() + 604800).' GMT');

header('ETag: "' . $etag . '"');

// Output the contents of each file
foreach ($cssfiles as $file) {
    $full_filepath = '';
    // Set css path variables
    $css_file_default='';
    if (!empty($theme_default)) {
        $css_file_default = $path_html . $file['file'];
    }
    $css_file = $path_html . $file['file'];

    if (!empty($theme_default)) {
        // First add own theme css file if found else add default css file
        if (is_readable($css_file)) {
            $full_filepath = $css_file;
        } elseif (is_readable($css_file_default)) {
            $full_filepath = $css_file_default;
        }
    } else {
        // Add theme css file if found
        if (is_readable($css_file)) {
            $full_filepath = $css_file;
        }
    }

    if (!empty($full_filepath)) {
        $css = file_get_contents($full_filepath);
        echo $css . PHP_EOL;
    }
}
