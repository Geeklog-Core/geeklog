<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | functions.php                                                             |
// |                                                                           |
// | Functions implementing the theme API                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2019 by the following authors:                         |
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
function theme_config_denim_three()
{
    $options = array(
        'uikit_theme' => 'default',
        'use_minified_css'  => 1,   // 1:use  or 0:no_use minified css
        'block_left_search' => 1,   // 1:show or 0:hide left block searchbox
        'welcome_msg'       => 1,   // 1:show or 0:hide welcome message
        'trademark_msg'     => 0,   // 1:show or 0:hide trademark message on footer
        'execution_time'    => 0,   // 1:show or 0:hide execution time on footer
        'pagenavi_string'   => 1,   // 1:show or 0:hide text string of page navigation
        'header_brand_type' => 1,   // 1:text or 0:image type of header brand (site name)
        'off_canvas_mode'   => 2,   // 0:push 1:slide 2:reveal or 3:none mode of UIkit off-canvas animation
        'enable_etag'       => 0,   // 1:enable or 0:disable ETag (deprecated since version 2.2.0. keep the value to 0)
    );

    // All options below only required if specified
    // Some Options are used to display information about the theme on Geeklog and some plugins
    // Note: You can include a preview image for your theme in the root of your theme folder. The image must be the same name as your theme's folder and be either a .png or .jpg file type.
    return array(
        'theme_name'            => 'Denim Three', // Required
        'theme_version'         => '1.0.4', // Required - This theme version released Geeklog v2.2.2
        'theme_gl_version'      => '2.2.2', // Required - Minimum Geeklog version theme is compatible with
        'theme_description'     => '', // Can contain HTML
        'theme_author'          => 'dengen',
        'theme_author_url'      => 'https://www.geeklog.net/users.php?mode=profile&uid=13649',
        'theme_homepage'        => 'https://www.geeklog.net/',
        'theme_download_url'    => '',
        'theme_copyright'       => '2012-2022',
        'theme_license'         => 'GPL-2.0+', 
        'theme_path_site_logo'  => '/layout/denim_three/images/logo2.png', // Used to override path_site_logo config option if needed. Empty or should have absolute path with Logo image filename. See path_site_logo option in config docs for more info
        'image_type'            => 'png',
        'doctype'               => 'xhtml5',
        'etag'                  => false, // never set this true. instead use $options['enable_etag'] above.
        'theme_plugins'         => '', // EXPERIMENTAL - Not required - Is used by all plugins - You can specify a COMPATIBLE theme (not a child theme) to use templates stored with some plugins. Can have problems if plugins include css and js files via their own functions.php
        'options'               => $options // Not required, some options of this theme
    );
}

/**
 * Return an array of CSS files to be loaded
 */
function theme_css_denim_three()
{
    global $_CONF, $LANG_DIRECTION;

    $theme_var = theme_config_denim_three();

    $direction = ($LANG_DIRECTION === 'rtl') ? '-rtl' : '';
    $ui_theme = '';
    if (in_array($theme_var['options']['uikit_theme'], array('gradient', 'almost-flat'))) {
        $ui_theme = '.' . $theme_var['options']['uikit_theme'];
    }
    $min = ($theme_var['options']['use_minified_css'] === 1) ? '.min' : '';

    // array of css packages
    $css_packages = array();

    // main package items
    $css_items = array();

    // add uikit css
    $css_items[] = array(
        'name'       => 'uikit3',
        'file'       => '/vendor/uikit3/css/uikit' . $direction . $min . '.css',
        'attributes' => array('media' => 'all'),
        'priority'   => 80
    );

    // add main css of this theme
    $css_items[] = array(
        'name'       => 'main', // don't use the name 'theme' to control the priority
        'file'       => '/layout/' . $_CONF['theme'] . '/css_' . $LANG_DIRECTION . '/style' . $ui_theme . $min . '.css',
        'attributes' => array('media' => 'all'),
        'priority'   => 90
    );

    // add additional css of this theme
    $css_items[] = array(
        'name'       => 'additional',
        'file'       => '/layout/' . $_CONF['theme'] . '/css_' . $LANG_DIRECTION . '/additional.css',
        'attributes' => array('media' => 'all'),
        'priority'   => 91
    );

    // add custom css of this theme
    $css_items[] = array(
        'name'       => 'custom',
        'file'       => '/layout/' . $_CONF['theme'] . '/css_' . $LANG_DIRECTION . '/custom.css',
        'attributes' => array('media' => 'all'),
        'priority'   => 91
    );

    // register main css package
    $css_packages[] = array(
        'name'      => 'main_package',
        'css_items' => $css_items,
    );

    // never packed css items
    $never_packed_items = array();

    $result = array();
    $result = $never_packed_items;
    if ($theme_var['options']['enable_etag'] === 1) {
        foreach($css_packages as $package) {
            $result[] = array(
                'name'      => $package['name'],
                'file'      => '/layout/' . $_CONF['theme'] . '/css/style.css.php?theme='
                                    . $_CONF['theme'] . '&amp;package=' . $package['name'] . '&amp;dir=' . $LANG_DIRECTION,
                'css_items' => $package['css_items'],
                'priority'  => 90
            );
        }
    } else {
        foreach($css_packages as $package) {
            $result = array_merge($result, $package['css_items']);
        }
    }

    return $result;
}

/**
 * Return an array of JS libraries to be loaded
 */
function theme_js_libs_denim_three()
{
    $theme_var = theme_config_denim_three();

    $result = array();
    $result[] = array(
        'library' => 'jquery',
        'footer'  => false // Required, default = true
    );

    $result[] = array(
        'library' => 'uikit3',
        'footer'  => false, // Required, default = true
    );

    $result[] = array(
        'library' => 'uikit3_modifier',
        'footer'  => false, // Required, default = true
    );

    return $result;
}

/**
 * Return an array of JS files to be loaded
 */
function theme_js_files_denim_three()
{
    global $_CONF;

    $result = array();

    $result[] = array(
        'name'     => 'theme.script',
        'file'     => '/layout/' . $_CONF['theme'] . '/javascript/script.js',
        'footer'   => true, // Not required, default = true
        'priority' => 100 // Not required, default = 100
    );

    return $result;
}

/**
 * Return an array of javascript code to be loaded
 */
function theme_js_denim_three()
{
    global $_CONF;

    $result = array();

    // For Cookie consent v3.1.1 customizations
    // Add EU Cookie Consent - https://www.osano.com/cookieconsent
    // Customizations - https://www.osano.com/cookieconsent/documentation/javascript-api/
    if (isset($_CONF['cookie_consent']) && $_CONF['cookie_consent']) {
        $_CONF['cookie_consent_theme_customization'] = true; // Let's Geeklog know their are customizations

        $cookie_consent_href = '';
        if (isset($_CONF['about_cookies_link']) && !empty($_CONF['about_cookies_link'])) {
            $cookie_consent_href = '"href": "' . $_CONF['about_cookies_link'] . '",';
        }

        $result[] = array(
            'code'     => '
                            window.cookieconsent.initialise({
                                "palette": {
                                    "popup": {
                                        "background": "#000"
                                    },
                                    "button": {
                                        "background": "#f1d600"
                                    }
                                },
                                "content": {
                                    "message": "This website uses cookies to ensure you get the best experience on our website.",
                                    "dismiss": "Got it!",
                                    ' . $cookie_consent_href . '
                                    "link": "Learn more"
                                }
                            });
                        ',
            'wrap'     => true, // Not required, wrap code <script> and </script> tags
            'footer'   => true, // Not required, default = true
        );
    }

    return $result;
}

/**
 * Do any other initialisation here
 */
function theme_init_denim_three()
{
    global $_BLOCK_TEMPLATE, $_CONF;

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
    $_BLOCK_TEMPLATE['articles_related_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';
    $_BLOCK_TEMPLATE['story_options_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';

	// Block used to display admin lists (including simple)
	$_BLOCK_TEMPLATE['_admin_list'] = 'blockheader-child.thtml,blockfooter.thtml';

    // Define the blocks that are a list of links styled as an unordered list - using class="blocklist"
    $_BLOCK_TEMPLATE['admin_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    $_BLOCK_TEMPLATE['section_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';

    if (!COM_isAnonUser()) {
        $_BLOCK_TEMPLATE['user_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    }
	
	// Available Blocks not used currently by theme
	// $_BLOCK_TEMPLATE['_admin_block'] // Main Block for Page used by Admin
	// $_BLOCK_TEMPLATE['_staticpages_block'] // Main Block to wrap Static Page
	// $_BLOCK_TEMPLATE['older_stories_block'] // Block to wrap Older Stories Block
	// $_BLOCK_TEMPLATE['whats_new_block'] // Block to wrap What's New Block	
}

/**
* Return information for the request item location
* CSS Classes, Styles, etc... can be passed
 */
function theme_getThemeItem_denim_three($item)
{
    $retval = '';

    switch ($item) {
        case 'core-file-print-css': // Return Common CSS file to be used for print pages - New item as of GL v2.2.1sr1
            global  $_CONF, $LANG_DIRECTION;
            $dir = isset($LANG_DIRECTION) && ($LANG_DIRECTION === 'rtl') ? 'rtl' : 'ltr';
            $retval = 'layout/' . $_CONF['theme'] . '/css_' . $dir . '/print.css';
            break;

        // ***************************
        // Item names used for lists created by COM_makeList
        // These original list items css classes which were defined way back in Geeklog 1.3. Most are not in use anymore by any updated theme
        // 'list-new-plugins', 'list-story-options', 'list-older-stories', 'list-feed', 'list-new-comments', 'list-new-trackbacks', 'list-whats-related', 'list-new-links', 'list-personal-events', 'list-site-events'

        // New Core, Article, Topic, Comment locations added Geeklog 2.2.1
        // Theme can pass a specific infor if needed else return empty string. Plugins can also set their own item locations and define their css classes in the plugin templates functions.php file
        // ***************************
        case 'article-css-list-options':  // Return 1 or more CSS Classes - replacing "list-story-options"
            $retval = 'list-story-options'; // used by denim, denim_curve, modern_curve
            break;

        case 'comment-css-user-avatar': // Return 1 or more CSS Classes - Add to user generated photo for comments - New item as of GL v2.2.1
            $retval = 'uk-comment-avatar';
            break;

        case 'comment-width-user-avatar': // Return width in pixels of user photos in comments - New item as of GL v2.2.1
            $retval = '80';
            break;

        // If Generate User Icon Automatically (config option generate_user_icon) is true  use the setting below to change the look
        // Geeklog generates a URL with letters and color settings like this: https://ui-avatars.com/api/?name=ME&color=000000&background=B4ED88&size=128
        // This option will add extra settings to the end of this URL.
        // Please visit https://ui-avatars.com/ for the full list of options you can change (which include, bold, font-size and rounded)
        case 'core-auto-generated-user-avatar-settings':
            //$retval = '&rounded=true';
            break;

        case 'core-css-list-default': // Return 1 or more CSS Classes -  Default List styling - not used yet
        case 'core-css-list-new': // Return 1 or more CSS Classes - For What's New Block - replacing "list-new-plugins", 'list-new-comments', 'list-new-trackbacks'
        case 'core-css-list-feed': // Return 1 or more CSS Classes - For RSS Feed Portal Block - replacing "list-feed"
        case 'article-css-list-directory':  // Return 1 or more CSS Classes - For Article Directory page - New item as of GL v2.2.1
        case 'article-css-list-related': // Return 1 or more CSS Classes - For Article Page What's Related List - replacing 'list-whats-related'
        case 'article-css-list-related-articles': // Return 1 or more CSS Classes - For Article Page You might also like - New item as of GL v2.2.1sr1
        case 'article-css-list-older':  // Return 1 or more CSS Classes - For Older Articles Block - replacing "list-older-stories"
        case 'topic-css-list-related': // Return 1 or more CSS Classes - For Autotags Related Topic items list - New item as of GL v2.2.1

        // If any other items requested return empty string
        default:
           break;
    }

    return $retval;
}

/**
 * Return an array of Block Locations for a theme (besides left and right)
 */
/*
EXAMPLE CODE ONLY. Follow instructions below to implement.

The code below can be added to the footer.html where you want the blocks to appear
{!if blocks_footer}
{blocks_footer}
{!endif}

Then uncomment this function below to register the above block location with Geeklog. Any new or updated blocks can then be assigned the following block location in the Block Editor

function theme_getBlockLocations_denim_three()
{
    $block_locations = array();

    // Add any extra block positions in theme. Locations can have one or more variables assigned to them
    // Remember these locations can only appear in templates that PLG_templateSetVars is used with
    $block_locations[] = array(
        'id'                => 'denim_three_footer', // Unique string. No other block location (includes Geeklog itself and any other plugins or themes) can share the same id ("left" and "right" are already taken).
        'name'              => 'Denim Three Footer', // (should use language variable here)
        'description'       => 'Blocks will appear at the bottom of all pages.', // (should use language variable here)
        'template_name'     => 'footer',
        'template_variable' => 'blocks_footer'
    );

    return $block_locations;
}
*/
