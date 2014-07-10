<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.9.0                                                             |
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

require_once '../../siteconfig.php';

// Get theme
if (isset($_GET['theme'])) {
    $theme = $_GET['theme'];
} else {
    exit();
}

// Create directions for RTL support
$left  = 'left';
$right = 'right';
$dir = 'ltr';

if ($_GET['dir'] === 'rtl') {
    $left  = 'right';
    $right = 'left';
    $dir = 'rtl';
}
$LANG_DIRECTION = $dir; // Need to set this for themes function.php file

// Set Path Variables
$path_html = dirname(dirname(getcwd())); // Should always be the directory above
$path_themes = $path_html . '/layout/';  
$path_layout = $path_themes . $theme . '/';
// Set etag file name and path
// have moved or renamed /data directory, please change the following line accordingly.
$etag_filename =  $_CONF['path'] . 'data/layout_css/' . $theme . '_' . $dir . '_etag.cache';

/**
* Get Theme Info
*/
if (file_exists($path_layout . 'functions.php')) {
    require_once $path_layout . 'functions.php';
} else {
    exit;    
}

/**
 * Get the configuration values from the theme
 */
$theme_default = ''; // Default is none
$path_layout_default = ''; // Default is none
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
// Load in default theme css files
if (!empty($theme_default)) {
    if (file_exists($path_layout_default . 'functions.php')) {
        require_once $path_layout_default . 'functions.php';
    } else {
        exit;    
    }
    
    /* Include scripts on behalf of the theme */
    $_CONF['theme'] = $theme_default; // Need to set this for default themes function.php file
    $func = "theme_css_" . $theme_default;
    if (function_exists($func)) {
        foreach ($func() as $info) {
            $info['priority'] = (!empty($info['priority']))   ? $info['priority']   : 100;
            $cssfiles[] = $info;
        }
    }        
}
/* Include scripts on behalf of the theme */
$_CONF['theme'] = $theme; // Need to set this for themes function.php file
$func = "theme_css_" . $theme;
if (function_exists($func)) {
    foreach ($func() as $info) {
        $info['priority'] = (!empty($info['priority']))   ? $info['priority']   : 100;
        $cssfiles[] = $info;
    }
}

// Sort Theme CSS Files based on priority if needed
$priority = array();
foreach($cssfiles as $k => $d) {
  $priority[$k] = $d['priority'];
}
array_multisort($priority, SORT_ASC, $cssfiles);

// Add in custom.css at end after sort
if (!empty($theme_default)) {
    $info = array();
    $info['file'] = '/layout/' . $theme_default . '/custom.css';
    $info['priority'] = 1000;
    $cssfiles[] = $info;
}
$info = array();
$info['file'] = '/layout/' . $theme . '/custom.css';
$info['priority'] = 1000;
$cssfiles[] = $info;

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

// Creates a new ETag value and saves it into the file
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
        $css = preg_replace("@/\*.*?\*/@sm", '', $css); // strip comments
        $css = preg_replace("@\s*\n+\s*@sm", "\n", $css); // strip indentation
    
        // Replace {right} and {left} placeholders with actual values.
        // Used for RTL support in some themes.
        $css = str_replace('{right}', $right, $css);
        $css = str_replace('{left}', $left, $css);
    
        // Output
        echo "\n/* $full_filepath */\n";
         
        echo $css;
    }
}

?>
