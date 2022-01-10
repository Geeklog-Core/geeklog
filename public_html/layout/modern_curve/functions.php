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
function theme_config_modern_curve()
{

    // All options below only required if specified
    // Some Options are used to display information about the theme on Geeklog and some plugins
    // Note: You can include a preview image for your theme in the root of your theme folder. The image must be the same name as your theme's folder and be either a .png or .jpg file type.
    return array(
        'theme_name'            => 'Modern Curve', // Required
        'theme_version'         => '1.0.3', // Required - This theme version released Geeklog v2.2.2
        'theme_gl_version'      => '2.2.2', // Required - Minimum Geeklog version theme is compatible with
        'theme_description'     => '', // Can contain HTML
        'theme_author'          => '',
        'theme_author_url'      => '',
        'theme_download_url'    => '',
        'theme_homepage'        => 'https://www.geeklog.net/',
        'theme_copyright'       => '2022',
        'theme_license'         => 'GPL-2.0+',
        'theme_path_site_logo'  => '/layout/modern_curve/images/logo.png', // Used to override path_site_logo config option if needed. Empty or should have absolute path with Logo image filename. See path_site_logo option in config docs for more info
        'image_type'            => 'png',
        'doctype'               => 'xhtml5',
        'etag'                  => true,
    );
}

/**
 * Return an array of CSS files to be loaded
 */
function theme_css_modern_curve()
{
    global $_CONF, $LANG_DIRECTION;

    /* // Sample css settings
    return array(
         array(
             'name' => 'theme', // Not required but if set to theme then will always be loaded first
             'file' => '/layout/' . $_CONF['theme'] . '/style.css.php?dir=' . $LANG_DIRECTION,
             'attributes' => array('media' => 'all'), // Not required
             'priority'   => 100  // Not required, default = 100
         )
    );
     */

    // Instead of importing all files in a single css file we will load them separately
    // since each file needs to be processed by style.css.php for language template vars
    return array(
         array('file' => '/layout/' . $_CONF['theme'] . '/css/compatible.css', 'priority' => 1.00),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/default.css', 'priority' => 1.01),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/common.css', 'priority' => 1.02),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/layout.css', 'priority' => 1.03),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/block.css', 'priority' => 1.04),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/option.css', 'priority' => 1.05),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/form.css', 'priority' => 1.06),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/story.css', 'priority' => 1.07),

         array('file' => '/layout/' . $_CONF['theme'] . '/css/article/article.css', 'priority' => 1.08),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/comment/comment.css', 'priority' => 1.09),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/navbar/navbar.css', 'priority' => 1.10),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/preferences/preferences.css', 'priority' => 1.11),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/search/search.css', 'priority' => 1.12),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/stats/stats.css', 'priority' => 1.13),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/submit/submit.css', 'priority' => 1.14),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/trackback/trackback.css', 'priority' => 1.15),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/users/users.css', 'priority' => 1.16),

         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/common.css', 'priority' => 1.17),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/block.css', 'priority' => 1.18),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/envcheck.css', 'priority' => 1.19),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/group.css', 'priority' => 1.20),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/lists.css', 'priority' => 1.21),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/commandcontrol.css', 'priority' => 1.22),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/plugins.css', 'priority' => 1.23),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/story.css', 'priority' => 1.24),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/topic.css', 'priority' => 1.25),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/trackback.css', 'priority' => 1.26),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/user.css', 'priority' => 1.27),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/admin/configuration.css', 'priority' => 1.28),

         array('file' => '/layout/' . $_CONF['theme'] . '/css/plugin/japanize.css', 'priority' => 1.29),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/plugin/sitecalendar.css', 'priority' => 1.30),

         array('file' => '/layout/' . $_CONF['theme'] . '/css/tooltips/tooltips.css', 'priority' => 1.31),
         array('file' => '/layout/' . $_CONF['theme'] . '/css/additional.css', 'priority' => 1.32),
    );
}

/**
 * Return an array of JS libraries to be loaded
 */
function theme_js_libs_modern_curve()
{
    return array(
       array(
            'library'  => 'jquery',
            'footer' => true // Not requred, default = true
        )
    );
}

/**
 * Return an array of JS files to be loaded
 */
function theme_js_files_modern_curve()
{
    global $_CONF;

    return array(
       array(
            'file'      => '/layout/' . $_CONF['theme'] . '/javascript/fix_html.js',
            'footer'    => false, // Not requred, default = true
            'priority'  => 100 // Not requred, default = 100
        ),
        array(
            'file'     => '/layout/' . $_CONF['theme'] . '/javascript/confirm.js',
        ),
        array(
            'file'     => '/layout/' . $_CONF['theme'] . '/javascript/search.js',
        )
    );
}

/**
 * Return an array of javascript code to be loaded
 */
function theme_js_modern_curve()
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
 * Do any other initialization here
 */
function theme_init_modern_curve()
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

    // Define the blocks that are a list of links styled as an unordered list - using class="blocklist"
    $_BLOCK_TEMPLATE['admin_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    $_BLOCK_TEMPLATE['section_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';

    if (! COM_isAnonUser()) {
        $_BLOCK_TEMPLATE['user_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
    }
}

/**
* Return information for the request item location
* CSS Classes, Styles, etc... can be passed
 */
function theme_getThemeItem_modern_curve($item)
{
    $retval = '';

    switch ($item) {
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
        case 'comment-css-user-avatar': // Return 1 or more CSS Classes - Add to user generated photo for comments - New item as of GL v2.2.1
        case 'comment-width-user-avatar': // Return width in pixels of user photos in comments - New item as of GL v2.2.1
        case 'article-css-list-directory':  // Return 1 or more CSS Classes - For Article Directory page - New item as of GL v2.2.1
        case 'article-css-list-related': // Return 1 or more CSS Classes - For Article Page What's Related List - replacing 'list-whats-related'
        case 'article-css-list-related-articles': // Return 1 or more CSS Classes - For Article Page You might also like - New item as of GL v2.2.1sr1
        case 'article-css-list-older':  // Return 1 or more CSS Classes - For Older Articles Block - replacing "list-older-stories"
        case 'topic-css-list-related': // Return 1 or more CSS Classes - For Autotags Related Topic items list - New item as of GL v2.2.1
        case 'core-file-print-css': // Return Common CSS file to be used for print pages - New item as of GL v2.2.1sr1

        // If any other items requested return empty string
        default:
           break;
    }

    return $retval;
}
