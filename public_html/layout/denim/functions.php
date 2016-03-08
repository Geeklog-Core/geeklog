<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.0                                                               |
// +---------------------------------------------------------------------------+
// | functions.php                                                             |
// |                                                                           |
// | Functions implementing the theme API                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2012 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Vincent Furia     - vinny01 AT users DOT sourceforge DOT net     |
// |          Rouslan Placella  - rouslan AT placella DOT com                  |
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
 * Return the configuration values for the theme
 */
function theme_config_denim()
{
    return array(
        'image_type' => 'png',
        'doctype'    => 'xhtml5',
        'supported_version_theme' => '2.0.0', // support new theme format for the later Geeklog 2.0.0
        'theme_plugins' => 'denim', // Not requred, you can specify compatible theme of template stored with plugins
        'options'    => array(      // Not requred, show or hide switcher of some of the parts
            'header_search'     => 1, // 1:show or 0:hide header searchbox
            'block_left_search' => 0, // 1:show or 0:hide left block searchbox
            'welcome_msg'       => 0, // 1:show or 0:hide welcome message
            'topic_image'       => 1, // 1:show or 0:hide topic images
            'trademark_msg'     => 0, // 1:show or 0:hide trademark message on footer
            'execution_time'    => 0, // 1:show or 0:hide execution time on footer
            'pagenavi_string'   => 1, // 1:show or 0:hide string of page navigation
            'table_overflow'    => 1, // 1:scroll or 0:visible overflow style of admin tables
        )
    );
}

/**
 * Return an array of CSS files to be loaded
 */
function theme_css_denim()
{
    global $_CONF, $LANG_DIRECTION;

    $direction = ($LANG_DIRECTION == 'rtl') ? '_rtl' : '';

    return array(
        array(
            'name'       => 'uikit',
            'file'       => '/vendor/uikit/css' . $direction . '/uikit.gradient.min.css',
            'attributes' => array('media' => 'all'),
            'priority'   => 80
        ),

        array(
            'name'       => 'main', // don't use the name 'theme' to control the priority
            'file'       => '/layout/' . $_CONF['theme'] . '/css_' . $LANG_DIRECTION . '/style.css', // change '/style.css' during debugging
            'attributes' => array('media' => 'all')
        )
    );
}

/**
 * Return an array of JS libraries to be loaded
 */
function theme_js_libs_denim()
{
    return array(
       array(
            'library' => 'jquery',
            'footer'  => false // Not requred, default = true
        )
    );
}

/**
 * Return an array of JS files to be loaded
 */
function theme_js_files_denim()
{
    global $_CONF;

    return array(

       array(
            'file'      => '/vendor/uikit/js/uikit.js',
            'footer'    => false, // Not requred, default = true
            'priority'  => 100 // Not requred, default = 100
        ),

       array(
            'file'      => '/layout/' . $_CONF['theme'] . '/javascript/script.js',
            'footer'    => true, // Not requred, default = true
            'priority'  => 100 // Not requred, default = 100
        )
    );
}

/**
 * Do any other initialisation here
 */
function theme_init_denim()
{
    global $_BLOCK_TEMPLATE, $_CONF;

    $_CONF['left_blocks_in_footer'] = 1;

    /*
     * For left/right block support there is no longer any need for the theme to
     * put code into functions.php to set specific templates for the left/right
     * versions of blocks. Instead, Geeklog will automagically look for
     * blocktemplate-left.thtml and blocktemplate-right.thtml if given
     * blocktemplate.thtml from $_BLOCK_TEMPLATE. So, if you want different left
     * and right templates from admin_block, just create blockheader-list-left.thtml
     * etc.
     */

    $_BLOCK_TEMPLATE['_msg_block'] = 'blockheader-message.thtml,blockfooter-message.thtml';
    $_BLOCK_TEMPLATE['configmanager_block'] = 'blockheader-config.thtml,blockfooter-config.thtml';
    $_BLOCK_TEMPLATE['configmanager_subblock'] = 'blockheader-config.thtml,blockfooter-config.thtml';
    $_BLOCK_TEMPLATE['whats_related_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';
    $_BLOCK_TEMPLATE['story_options_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';

    // Define the blocks that are a list of links styled as an unordered list - using class="blocklist"
    $_BLOCK_TEMPLATE['admin_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    $_BLOCK_TEMPLATE['section_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';

    if (!COM_isAnonUser()) {
        $_BLOCK_TEMPLATE['user_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    }
}

?>
