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

$theme = 'modern_curve'; // Theme Name
$default_theme = ''; // Default theme name. If nothing leave as blank string
$path_themes = '../'; // Assumes the default if not then change

$css_path_default='';
if (!empty($default_theme)) {
    $css_path_default = $path_themes . $default_theme . '/css/';
}
$css_path = $path_themes . $theme . '/css/';

// We assume /data directory is right under $_CONF['path'] directory.  If you
// have moved or renamed /data directory, please change the following line accordingly.
$etag_filename =  $_CONF['path'] . 'data/' . $theme . '_etag.cache';

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
header('ETag: "' . $etag . '"');

// List of CSS files to be loaded
$files = array(
    'compatible.css',
    'default.css',
    'common.css',
    'layout.css',
    'block.css',
    'option.css',
    'form.css',
    'story.css',

    'article/article.css',
    'comment/comment.css',
    'navbar/navbar.css',
    'preferences/preferences.css',
    'search/search.css',
    'stats/stats.css',
    'submit/submit.css',
    'trackback/trackback.css',
    'users/users.css',

    'admin/common.css',
    'admin/block.css',
    'admin/group.css',
    'admin/lists.css',
    'admin/moderation.css',
    'admin/plugins.css',
    'admin/story.css',
    'admin/topic.css',
    'admin/trackback.css',
    'admin/user.css',
    'admin/configuration.css',

    'plugin/japanize.css',
    'plugin/sitecalendar.css',

    'tooltips/tooltips.css', 
    
    'custom.css'
);

// Create directions for RTL support
$left  = 'left';
$right = 'right';

if ($_GET['dir'] === 'rtl') {
    $left  = 'right';
    $right = 'left';
}

// Output the contents of each file
foreach ($files as $file) {
    $full_filepath = '';
    if (!empty($default_theme)) {
        // First add own theme css file if found else add default css file
        if (is_readable($css_path . $file)) {
            $full_filepath = $css_path . $file;
        } elseif (is_readable($css_path_default . $file)) {
            $full_filepath = $css_path_default . $file;
        }
    } else {
        // Add theme css file if found
        if (is_readable($css_path . $file)) {
            $full_filepath = $css_path . $file;
        }
    }
    
    if (!empty($full_filepath)) {
        $css = file_get_contents($full_filepath);
        $css = preg_replace("@/\*.*?\*/@sm", '', $css); // strip comments
        $css = preg_replace("@\s*\n+\s*@sm", "\n", $css); // strip indentation
    
        // Replace {right} and {left} placeholders with actual values.
        // Used for RTL support.
        $css = str_replace('{right}', $right, $css);
        $css = str_replace('{left}', $left, $css);
    
        // Output
        echo "\n/* $full_filepath */\n";
         
        echo $css;
    }
}

?>
