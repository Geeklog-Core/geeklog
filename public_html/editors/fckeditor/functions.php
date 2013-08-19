<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.0                                                               |
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
if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Return the configuration values for the advanced editor
 */
function adveditor_config_fckeditor()
{
    return array(
        'name'     => 'FCKEditor',
        'file'     => 'fckeditor.js',
        'footer'   => true, // Not requred, default = true
        'priority' => 110   // Not requred, default = 100
    );
}

/**
 * Do any other initialisation here
 */
function adveditor_init_fckeditor()
{
    global $_CONF, $_SCRIPTS;

    // Add core JavaScript global variables
    $script  = '<script type="text/javascript">' . LB
             . 'var geeklogEditorBaseUrl = "' . $_CONF['site_url'] . '/editors";' . LB
               // Setup editor path for advanced editor JS functions
             . 'var geeklogEditorBasePath = "' . $_CONF['site_url'] . '/editors/fckeditor/";' . LB
             . '</script>' . LB;
    $_SCRIPTS->setJavaScript($script);
}

/**
 * Base function for override process to set JavaScript files
 */
/*
function adveditor_setup_fckeditor($custom)
{
    global $_CONF, $_SCRIPTS;

    // Add JavaScript
    $_SCRIPTS->setJavaScriptFile('adveditor_fckeditor', '/editors/fckeditor/fckeditor.js',     true, 110);
    $_SCRIPTS->setJavaScriptFile('adveditor_main', '/javascript/advanced_editor.js',           true, 111);
    $_SCRIPTS->setJavaScriptFile('adveditor_api_fckeditor', '/editors/fckeditor/functions.js', true, 112);
    $_SCRIPTS->setJavaScriptFile('adveditor_custom', $custom,                                  true, 113);
}
*/
?>
