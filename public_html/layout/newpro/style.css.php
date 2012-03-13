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

// Send correct header type:
header('Content-Type: text/css; charset=UTF-8');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');

// List of CSS files to be loaded
$files = array(
    "compatible.css",
    "default.css",
    "common.css",
    "layout.css",
    "block.css",
    "option.css",
    "form.css",
    "story.css",

    "article/article.css",
    "comment/comment.css",
    "navbar/navbar.css",
    "preferences/preferences.css",
    "search/search.css",
    "stats/stats.css",
    "submit/submit.css",
    "trackback/trackback.css",
    "users/users.css",

    "admin/common.css",
    "admin/block.css",
    "admin/group.css",
    "admin/lists.css",
    "admin/moderation.css",
    "admin/plugins.css",
    "admin/story.css",
    "admin/topic.css",
    "admin/trackback.css",
    "admin/user.css",
    "admin/configuration.css",

    "plugin/japanize.css",
    "plugin/sitecalendar.css",

    "tooltips/tooltips.css"
);

// Output the contents of each file
foreach ($files as $file) {
    $css = file_get_contents("css/$file");
    $css = preg_replace("@/\*.*?\*/@sm", "", $css); // strip comments
    $css = preg_replace("@\s*\n+\s*@sm", "\n", $css); // strip indentation
    echo $css;
}

// Also output the contents of the custom CSS file, if it's available
if (is_readable("css/custom.css")) {
    echo file_get_contents("css/custom.css");
}

?>
