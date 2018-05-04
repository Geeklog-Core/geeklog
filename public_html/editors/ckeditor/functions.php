<?php

// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | functions.php                                                             |
// |                                                                           |
// | Functions implementing the Advanced Editor API                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2013 by the following authors:                              |
// |                                                                           |
// | Authors: Yoshinori Tahara  - dengenxp AT gmail DOT com                    |
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

// this file can't be used on its own
if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

/**
 * Return the configuration values for the advanced editor
 */
function adveditor_config_ckeditor()
{
    return array(
        'name'     => 'CKEditor',
        'file'     => 'ckeditor.js',
        'footer'   => true, // Not required, default = true
        'priority' => 200   // Need to set higher than default 100 since if cache_resource config enabled (and editor js are NOT included in the resource file) it may cause an issue
    );
}

/**
 * Do any other initializations here
 */
function adveditor_init_ckeditor()
{
}

/**
 * Base function for override process to set JavaScript files
 */
/*
function adveditor_setup_ckeditor($custom)
{
    global $_CONF, $_SCRIPTS;

    // Add JavaScript
    $_SCRIPTS->setJavaScriptFile('adveditor_ckeditor', '/editors/ckeditor/ckeditor.js',      true, 110);
    $_SCRIPTS->setJavaScriptFile('adveditor_main', '/javascript/advanced_editor.js',         true, 111);
    $_SCRIPTS->setJavaScriptFile('adveditor_api_ckeditor', '/editors/ckeditor/functions.js', true, 112);
    $_SCRIPTS->setJavaScriptFile('adveditor_custom', $custom,                                true, 113);
}
*/
