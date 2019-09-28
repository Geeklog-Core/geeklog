<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-common.php                                                            |
// |                                                                           |
// | Geeklog common library.                                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2019 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Vincent Furia     - vinny01 AT users DOT sourceforge DOT net     |
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

use Geeklog\Autoload;
use Geeklog\Cache;
use Geeklog\Input;
use Geeklog\Log;
use Geeklog\Mail;
use Geeklog\Resource;
use Geeklog\Session;

// Prevent PHP from reporting uninitialized variables
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR);

/**
 * This is the common library for Geeklog.  Through our code, you will see
 * functions with the COM_ prefix (e.g. COM_createHTMLDocument()).  Any such functions
 * can be found in this file and called by plugins. 
 * Note: functions with the _ prefix should only be called by Core and not any plugins.
 * --- You don't need to modify anything in this file! ---
 * WARNING: put any custom hacks in lib-custom.php and not in here.  This file is
 * modified frequently by the Geeklog development team.  If you put your hacks in
 * lib-custom.php you will find upgrading much easier.
 */

/**
 * Prevent getting any surprise values. But we should really stop
 * using $_REQUEST altogether.
 */
$_REQUEST = array_merge($_GET, $_POST);

/**
 * Configuration Include:
 * You do NOT need to modify anything here any more!
 */
require_once __DIR__ . '/siteconfig.php';

if (COM_isDeveloperMode() &&
    isset($_CONF['developer_mode_php'], $_CONF['developer_mode_php']['error_reporting'])) {
    error_reporting((int) $_CONF['developer_mode_php']['error_reporting']);
}

/**
 * Here, we shall establish an error handler. This will mean that whenever a
 * php level error is encountered, our own code handles it. This will hopefully
 * go someway towards preventing nasties like path exposures from ever being
 * possible. That is, unless someone has overridden our error handler with one
 * with a path exposure issue...
 * Must make sure that the function hasn't been disabled before calling it.
 */
if (is_callable('set_error_handler')) {
    /* Tell the error handler to use the default error reporting options.
     * You may like to change this to use it in more/less cases, if so,
     * just use the syntax used in the call to error_reporting() above.
     */
    $defaultErrorHandler = set_error_handler('COM_handleError', error_reporting());
}

if (is_callable('set_exception_handler')) {
    set_exception_handler('COM_handleException');
}

/**
 * Turn this on to get various debug messages from the code in this library
 *
 * @global bool $_COM_VERBOSE
 */
$_COM_VERBOSE = COM_isEnableDeveloperModeLog('common');

COM_checkInstalled();

// Register autoloader
require_once $_CONF['path_system'] . 'classes/Autoload.php';
Autoload::initialize();

// Initialize system classes
Input::init();

// Load configuration
$config = config::get_instance();
$config->set_configfile($_CONF['path'] . 'db-config.php');
$config->load_baseconfig();
$config->initConfig();

$_CONF = $config->get_config('Core');

// Get features that has ft_name like 'config%'
$_CONF_FT = $config->_get_config_features();

// Load Log class
Log::init($_CONF['path_log']);

// Load Cache class
Cache::init(new Cache\FileSystem($_CONF['path'] . 'data/cache/'));

// Load in Geeklog Variables Table

/**
 * @global $_VARS array
 */
$_VARS = array();
$result = DB_query("SELECT * FROM {$_TABLES['vars']}");

while ($row = DB_fetchArray($result)) {
    $_VARS[$row['name']] = $row['value'];
}

// Before we do anything else, check to ensure site is enabled
if (isset($_CONF['site_enabled']) && !$_CONF['site_enabled']) {
    if (empty($_CONF['site_disabled_msg'])) {
        header("HTTP/1.1 503 Service Unavailable");
        header("Status: 503 Service Unavailable");
        header('Content-Type: text/plain; charset=' . COM_getCharset());
        echo $_CONF['site_name'] . ' is temporarily down.  Please check back soon.' . LB;
    } else {
        // if the msg starts with http: assume it's a URL we should redirect to
        if (preg_match("/^(https?):/", $_CONF['site_disabled_msg'])) {
            COM_redirect($_CONF['site_disabled_msg']);
        } else {
            header("HTTP/1.1 503 Service Unavailable");
            header("Status: 503 Service Unavailable");
            header('Content-Type: text/html; charset=' . COM_getCharset());
            echo $_CONF['site_disabled_msg'] . LB;
        }
    }

    exit;
}

// this file can't be used on its own - redirect to index.php
if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    COM_redirect($_CONF['site_url'] . '/index.php');
}

// +---------------------------------------------------------------------------+
// | Library Includes: You shouldn't have to touch anything below here         |
// +---------------------------------------------------------------------------+

// Set the web server's timezone
TimeZoneConfig::setSystemTimeZone();

// Include multibyte functions
require_once $_CONF['path_system'] . 'lib-mbyte.php';

/**
 * Include plugin class.
 * This is a poorly implemented class that was not very well thought out.
 * Still very necessary
 *
 * @global $_PLUGINS array of the names of active plugins
 */
require_once $_CONF['path_system'] . 'lib-plugins.php';

/**
 * Include page time -- used to time how fast each page was created
 *
 * @global $_PAGE_TIMER timerobject
 */
$_PAGE_TIMER = new timerobject();
$_PAGE_TIMER->startTimer();

/**
 * This provides optional URL rewriting functionality.
 *
 * @global $_URL Url
 */
$_URL = new Url($_CONF['url_rewrite'], $_CONF['url_routing']);

/**
 * Include Device Detect class
 *
 * @global $_DEVICE Device
 */
$_DEVICE = new Device();

// This is the security library used for application security
require_once $_CONF['path_system'] . 'lib-security.php';

// This is the syndication library used to offer (RSS) feeds.
require_once $_CONF['path_system'] . 'lib-syndication.php';

// This is the topic library used to manage topics.
require_once $_CONF['path_system'] . 'lib-topic.php';

// This is the block library used to manage blocks.
require_once $_CONF['path_system'] . 'lib-block.php';

// This is the likes library used to manage and display the likes and dislikes.
require_once $_CONF['path_system'].'lib-likes.php';

/**
 * This is the custom library.
 * It is the sandbox for every Geeklog Admin to play in.
 * The lib-custom.php as shipped will never contain required code,
 * so it's safe to always use your own copy.
 * This should hold all custom hacks to make upgrading easier.
 */
if (file_exists($_CONF['path_system'] . 'lib-custom.php')) {
    require_once $_CONF['path_system'] . 'lib-custom.php';
}

// Session management library
require_once $_CONF['path_system'] . 'lib-sessions.php';
SESS_sessionCheck(); // Load user data
TimeZoneConfig::setUserTimeZone();

if (COM_isAnonUser()) {
    $_USER['advanced_editor'] = $_CONF['advanced_editor'];
}


// Initiate global topic variable
// This variable contains the current topic id
// It can be set by anything that uses topics like index.php (topics), article, directory, staticpages, other potential plugins. 
// Retrieved usually via TOPIC_getTopic by the page (last topic is stored as a session var which TOPIC_getTopic uses)
// Was retrieved here at one point but url_rewrite caused issues as lib-common doesn't know the difference between url rewritten topic urls, article urls, staticpage urls, etc...
$topic = '';

// Set theme
$useTheme = '';
if (isset($_POST['usetheme'])) {
    $useTheme = COM_sanitizeFilename($_POST['usetheme'], true);
}
if (!empty($useTheme) && is_dir($_CONF['path_themes'] . $useTheme)) {
    $_CONF['theme'] = $useTheme;
    $_CONF['path_layout'] = $_CONF['path_themes'] . $_CONF['theme'] . '/';
    $_CONF['layout_url'] = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
} elseif ($_CONF['allow_user_themes'] == 1) {
    if (isset($_COOKIE[$_CONF['cookie_theme']]) && empty($_USER['theme'])) {
        $theme = COM_sanitizeFilename($_COOKIE[$_CONF['cookie_theme']], true);
        if (is_dir($_CONF['path_themes'] . $theme)) {
            $_USER['theme'] = $theme;
        }
    }

    if (!empty($_USER['theme'])) {
        if (is_dir($_CONF['path_themes'] . $_USER['theme'])) {
            $_CONF['theme'] = $_USER['theme'];
            $_CONF['path_layout'] = $_CONF['path_themes'] . $_CONF['theme'] . '/';
            $_CONF['layout_url'] = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
        } else {
            $_USER['theme'] = $_CONF['theme'];
        }
    }
}

/*
// Fix a wrong theme name, since "professional" and "professional_css" themes are deprecated as of Geeklog 2.1.2
if (($_CONF['theme'] === 'professional') || ($_CONF['theme'] === 'professional_css')) {
    $_CONF['theme'] = $_USER['theme'] = 'denim';
    $_CONF['path_layout'] = $_CONF['path_themes'] . $_CONF['theme'] . '/';
    $_CONF['layout_url'] = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];

    if (!headers_sent()) {
        @setcookie(
            $_CONF['cookie_theme'], 'denim', time() + 31536000, $_CONF['cookie_path'],
            $_CONF['cookiedomain'], $_CONF['cookiesecure']
        );
    }
}
*/

// Geeklog Theme Support
// If ANY theme changes related to:
//      template variables (new or deleted)
//      template files (name of files, new or deleted files) 
//      New/Updated Features (for example added the scripts class to handle css and javascript)
// has happened since previous version of Geeklog then current Geeklog version is required.
// If nothing has changed related to this, then the last version of Geeklog that meet these standards can be used here.
// If versions are not compatible then a warning message will be displayed to the Root user on the homepage
$_CONF['min_theme_gl_version'] = VERSION; 


// Include theme functions file (required)
if (file_exists($_CONF['path_layout'] . 'functions.php')) {
    require_once $_CONF['path_layout'] . 'functions.php';
}

// Get the configuration values from the theme
$_CONF['theme_default'] = ''; // Default is none
$_CONF['path_layout_default'] = ''; // Default is none
$_CONF['theme_gl_version'] = ''; // Required and set by theme. Needs to be set in theme_config
$_CONF['theme_etag'] = false;
$_CONF['theme_plugins'] = ''; // Default is none - CANNOT be a child theme
$_CONF['theme_options'] = array(); // Default is empty array

$func = 'theme_config_' . $_CONF['theme'];
if (!is_callable($func)) {
    $func = 'theme_config';
}

if (is_callable($func)) {
    $theme_config = $func();
    $_CONF['doctype'] = $theme_config['doctype'];
    $_CONF['theme_oauth_icons'] = @$theme_config['theme_oauth_icons'];
    $_IMAGE_TYPE = $theme_config['image_type'];
    if (isset($theme_config['theme_default'])) {
        $_CONF['theme_default'] = $theme_config['theme_default'];
        $_CONF['path_layout_default'] = $_CONF['path_themes'] . $_CONF['theme_default'] . '/';
    }
    if (isset($theme_config['supported_version_theme'])) {
        $_CONF['theme_gl_version'] = $theme_config['supported_version_theme'];
        COM_deprecatedLog('"supported_version_theme"', '2.2.1', '3.0.0', 'Set "theme_gl_version" config option in themes theme_config function');
    } else {
        $_CONF['theme_gl_version'] = $theme_config['theme_gl_version'];      
    }
    $_CONF['theme_etag'] = (!isset($theme_config['etag']))
        ? $_CONF['theme_etag'] : $theme_config['etag'];
    if ($_CONF['theme_etag'] && !file_exists($_CONF['path_layout'] . 'style.css.php')) {
        // See if style.css.php file exists that is required
        $_CONF['theme_etag'] = false;
    }
    if (isset($theme_config['theme_plugins'])) {
        // EXPERIMENTAL for theme_gl_version v2.2.0 and higher (See Geeklog Core theme functions.php and theme_plugins for further explanation or  https://github.com/Geeklog-Core/geeklog/issues/767)
        $_CONF['theme_plugins'] = $theme_config['theme_plugins'];
    }
    if (isset($theme_config['options']) && is_array($theme_config['options'])) {
        $_CONF['theme_options'] = $theme_config['options'];
    }
}

/**
 * This provides the ability to set css and javascript.
 *
 * @global $_SCRIPTS Geeklog\Resource
 */
$_SCRIPTS = new Resource($_CONF);

/**
 * themes can specify the default image type
 * fall back to 'gif' if they don't
 *
 * @global $_IMAGE_TYPE string
 */
if (empty($_IMAGE_TYPE)) {
    $_IMAGE_TYPE = 'gif';
}

// Ensure XHTML constant is defined to avoid problems elsewhere
if (!defined('XHTML')) {
    switch ($_CONF['doctype']) {
        case 'xhtml10transitional':
        case 'xhtml10strict':
        case 'xhtml5':
            define('XHTML', ' /');
            break;

        default:
            define('XHTML', '');
            break;
    }
}

// Set template class default template variables option
/**
 * @global $TEMPLATE_OPTIONS array
 */
$TEMPLATE_OPTIONS = array(
    'path_cache'          => $_CONF['path_data'] . 'layout_cache/',   // location of template cache
    'path_prefixes'       => array(                               // used to strip directories off file names. Order is important here.
        $_CONF['path_themes'],  // this is not path_layout. When stripping directories, you want files in different themes to end up in different directories.
        $_CONF['path'],
        '/'                     // this entry must always exist and must always be last
    ),
    'incl_phpself_header' => true,          // set this to true if your template cache exists within your web server's docroot.
    'cache_by_language'   => true,            // create cache directories for each language. Takes extra space but moves all $LANG variable text directly into the cached file
    'cache_for_mobile'    => $_CONF['cache_mobile'],  // create cache directories for mobile devices. Non mobile devices uses regular directory. If disabled mobile uses regular cache files. Takes extra space
    'default_vars'        => array(                                // list of vars found in all templates.
        'xhtml'           => XHTML,
        'image_type'      => $_IMAGE_TYPE,
        'site_url'        => $_CONF['site_url'],
        'site_admin_url'  => $_CONF['site_admin_url'],
        'layout_url'      => $_CONF['layout_url'], // Can be set by lib-common on theme change
        'anonymous_user'  => COM_isAnonUser(),
        'device_mobile'   => $_DEVICE->is_mobile(),
        'front_page'      => COM_onFrontpage(), 
        'current_url'     => COM_getCurrentURL()
    ),
    'hook'                => array('set_root' => 'CTL_setTemplateRoot'), // Function found in lib-template and is used to add the ability for child themes. CTL_setTemplateRoot will be depreciated as of Geeklog 3.0.0. 
);
Autoload::load('template');
// Template library contains helper functions for template class
require_once $_CONF['path_system'] . 'lib-template.php';

// Set language
$_CONF['language_site_default'] = $_CONF['language']; // Store original site default language before it may get changed depending on other settings
if (isset($_COOKIE[$_CONF['cookie_language']]) && empty($_USER['language'])) {
    $language = COM_sanitizeFilename($_COOKIE[$_CONF['cookie_language']]);
    if (is_file($_CONF['path_language'] . $language . '.php') &&
        ($_CONF['allow_user_language'] == 1)
    ) {
        $_USER['language'] = $language;
        $_CONF['language'] = $language;
    }
} elseif (!empty($_USER['language'])) {
    if (is_file($_CONF['path_language'] . $_USER['language'] . '.php') &&
        ($_CONF['allow_user_language'] == 1)
    ) {
        $_CONF['language'] = $_USER['language'];
    }
} elseif (!empty($_CONF['languages']) && !empty($_CONF['language_files'])) {
    $_CONF['language'] = COM_getLanguage();
}

// Include a language file
require_once $_CONF['path_language'] . $_CONF['language'] . '.php';

if (empty($LANG_DIRECTION)) {
    // default to left-to-right
    $LANG_DIRECTION = 'ltr';
}

COM_switchLocaleSettings();

if (setlocale(LC_ALL, $_CONF['locale']) === false) {
    setlocale(LC_TIME, $_CONF['locale']);
}

// Override language items (since v2.1.2)
Language::init();
$language_overrides = array(
    'LANG01', 'LANG03', 'LANG04', 'LANG_MYACCOUNT', 'LANG05', 'LANG08', 'LANG09',
    'LANG10', 'LANG11', 'LANG12', 'LANG_LOGVIEW', 'LANG_ENVCHECK', 'LANG20',
    'LANG21', 'LANG24', 'LANG27', 'LANG28', 'LANG29', 'LANG31', 'LANG32', 'LANG33',
    'MESSAGE', 'LANG_ACCESS', 'LANG_DB_BACKUP', 'LANG_BUTTONS', 'LANG_404',
    'LANG_LOGIN', 'LANG_TRB', 'LANG_DIR', 'LANG_SECTEST', 'LANG_WHATSNEW', 'LANG_MONTH',
    'LANG_WEEK', 'LANG_ADMIN', 'LANG_commentcodes', 'LANG_commentmodes',
    'LANG_cookiecodes', 'LANG_dateformats', 'LANG_featurecodes', 'LANG_frontpagecodes',
    'LANG_postmodes', 'LANG_sortcodes', 'LANG_trackbackcodes', 'LANG_CONFIG',
    'LANG_VALIDATION');
$language_overrides = array_merge($language_overrides, PLG_getLanguageOverrides());
Language::override($language_overrides);

/**
 * Global array of groups current user belongs to
 *
 * @global $_GROUPS array
 */
$_GROUPS = COM_isAnonUser() ? SEC_getUserGroups(1) : SEC_getUserGroups($_USER['uid']);

/**
 * Global array of current user permissions [read,edit]
 *
 * @global $_RIGHTS array
 */
$_RIGHTS = explode(',', SEC_getUserPermissions());

// Include scripts on behalf of the theme
$func = 'theme_css_' . $_CONF['theme'];
if (!is_callable($func)) {
    $func = 'theme_css';
}

if (is_callable($func)) {
    foreach ($func() as $info) {
        $file = (!empty($info['file'])) ? $info['file'] : '';
        $name = (!empty($info['name'])) ? $info['name'] : md5(!empty($file) ? $file : strval(time()));
        $constant = (!empty($info['constant'])) ? $info['constant'] : true;
        $attributes = (!empty($info['attributes'])) ? $info['attributes'] : array();
        $priority = (!empty($info['priority'])) ? $info['priority'] : 100;
        $_SCRIPTS->setCSSFile($name, $file, $constant, $attributes, $priority, 'theme');
    }
}

$func = 'theme_js_libs_' . $_CONF['theme'];
if (!is_callable($func)) {
    $func = 'theme_js_libs';
}

if (is_callable($func)) {
    foreach ($func() as $info) {
        $footer = true;
        if (isset($info['footer']) && !$info['footer']) {
            $footer = false;
        }
        $_SCRIPTS->setJavaScriptLibrary($info['library'], $footer);
    }
}

$func = 'theme_js_files_' . $_CONF['theme'];
if (!is_callable($func)) {
    $func = 'theme_js_files';
}

if (is_callable($func)) {
    foreach ($func() as $info) {
        $footer = true;
        if (isset($info['footer']) && !$info['footer']) {
            $footer = false;
        }
        $priority = (!empty($info['priority'])) ? $info['priority'] : 100;
        $_SCRIPTS->setJavaScriptFile(md5($info['file']), $info['file'], $footer, $priority);
    }
}

$func = 'theme_js_' . $_CONF['theme'];
if (!is_callable($func)) {
    $func = 'theme_js';
}

if (is_callable($func)) {
    foreach ($func() as $info) {
        $wrap = true;
        if (isset($info['wrap']) && !$info['wrap']) {
            $wrap = false;
        }        
        $footer = true;
        if (isset($info['footer']) && !$info['footer']) {
            $footer = false;
        }
        $_SCRIPTS->setJavaScript($info['code'], $wrap, $footer);
    }
}

$func = 'theme_init_' . $_CONF['theme'];
if (!is_callable($func)) {
    $func = 'theme_init';
}

if (is_callable($func)) {
    $func();
}
unset($theme_config, $func);

// Forcibly enable Resource cache if current theme is compatible with Modern Curve theme
if ($_SCRIPTS->isCompatibleWithModernCurveTheme()) {
    $_CONF['cache_resource'] = true;
}

// Disable Resource cache (combined and minified CSS and JavaScript files)
if (isset($_CONF['cache_resource']) && !$_CONF['cache_resource']) {
    Cache::disable();
};

// Clear out any expired sessions
DB_lockTable($_TABLES['sessions']);
DB_query("UPDATE {$_TABLES['sessions']} SET whos_online = 0 WHERE start_time < " . (time() - $_CONF['whosonline_threshold']));
DB_unlockTable($_TABLES['sessions']);

/**
 * Build global array of Topics current user has access to
 *
 * @global $_TOPICS array
 */

// Figure out if we need to update topic tree or retrieve it from the cache
// For anonymous users topic tree data can be shared
$cacheInstance = 'topic_tree__' . CACHE_security_hash();
$serialized_topic_tree = CACHE_check_instance($cacheInstance, true, true); // Not language or mobile cache specific (as this is ALL topic information)

// See if Topic Tree cache exists
if (empty($serialized_topic_tree)) {
    $_TOPICS = TOPIC_buildTree(TOPIC_ROOT, true);

    // Need this check since this variable is not set correctly when Geeklog is being install
    if (isset($GLOBALS['TEMPLATE_OPTIONS']) && is_array($TEMPLATE_OPTIONS) && isset($TEMPLATE_OPTIONS['path_cache'])) {
        // Save updated topic tree and date
        CACHE_create_instance($cacheInstance, serialize($_TOPICS), true, true); // Not language or mobile cache specific
    }
} else {
    $_TOPICS = unserialize($serialized_topic_tree);
}

// Figure out if we need to update article feeds. Check last article date published in feed
$sql = "SELECT date FROM {$_TABLES['stories']} "
    . "WHERE draft_flag = 0 AND date <= NOW() AND perm_anon > 0 "
    . "ORDER BY date DESC LIMIT 1";
$result = DB_query($sql);
$A = DB_fetchArray($result);
if ($_VARS['last_article_publish'] != $A['date']) {
    //Set new latest article published
    // Below similar to what is run in STORY_updateLastArticlePublished
    DB_query("UPDATE {$_TABLES['vars']} SET value='{$A['date']}' WHERE name='last_article_publish'");

    // We need to see if there are currently two featured articles (because of future article).
    // Can only have one but you can have one current featured article
    // and one for the future...this check will set the latest one as featured
    // solely
    COM_featuredCheck();

    // Geeklog now allows for articles to be published in the future.  Because of
    // this, we need to check to see if we need to rebuild the RDF file in the case
    // that any such articles have now been published. Need to do this for comments
    // as well since article can have comments
    COM_rdfUpToDateCheck('article');
    COM_rdfUpToDateCheck('comment');

    // If what's new block is cached, clear it since new article(s) are now online
    if ($_CONF['whatsnew_cache_time'] > 0) {
        $cacheInstance = 'whatsnew__'; // remove all what's new instances
        CACHE_remove_instance($cacheInstance);
    }    
}

/**
 * This provides the ability to generate structure data based on types from schema.org to
 */
Autoload::load('structureddata');
$_STRUCT_DATA = new StructuredData();

// +---------------------------------------------------------------------------+
// | HTML WIDGETS                                                              |
// +---------------------------------------------------------------------------+

/**
 * Return the file to use for a block template.
 * This returns the template needed to build the HTML for a block.  This function
 * allows designers to give a block it's own custom look and feel.  If no
 * templates for the block are specified, the default blockheader.html and
 * blockfooter.html will be used.
 *
 * @param        string $blockName  corresponds to name field in block table
 * @param        string $which      can be either 'header' or 'footer' for corresponding template
 * @param        string $position   can be 'left', 'right' or blank. If set, will be used to find a side specific
 *                                  override template.
 * @param        string $plugin     name of plugin with blocks location
 * @see function COM_startBlock
 * @see function COM_endBlock
 * @see function COM_showBlocks
 * @see function COM_showBlock
 * @return   string  template name
 */
function COM_getBlockTemplate($blockName, $which, $position = '', $plugin = '')
{
    global $_BLOCK_TEMPLATE, $_COM_VERBOSE, $_CONF;

    if ($_COM_VERBOSE) {
        COM_errorLog("_BLOCK_TEMPLATE[$blockName] = " . $_BLOCK_TEMPLATE[$blockName], 1);
    }

    $template = ($which === 'header') ? 'blockheader.thtml' : 'blockfooter.thtml';
    if (!empty($_BLOCK_TEMPLATE[$blockName])) {
        $i = ($which === 'header') ? 0 : 1;
        $templates = explode(',', $_BLOCK_TEMPLATE[$blockName]);
        if (count($templates) === 2 && !empty($templates[$i])) {
            $template = $templates[$i];
        }
    }

    // If we have a position specific request, and the template is not already
    // position specific then look to see if there is a position specific
    // override.
    $templateLC = strtolower($template);
    if (!empty($position) && (strpos($templateLC, $position) === false)) {
        // Trim .thtml from the end.
        $positionSpecific = substr($template, 0, strlen($template) - 6);
        $positionSpecific .= '-' . $position . '.thtml';

        $templatefound = false;        
        if (!empty($plugin)) {
            $plugin_template_paths = CTL_plugin_templatePath($plugin);
            foreach($plugin_template_paths as $plugin_template_path) {
                 if (file_exists($plugin_template_path . '/' . $positionSpecific)) {
                     $template = $positionSpecific;
                     $templatefound = true; // If found don't need to search theme or theme default if exist
                     break;
                 }
            }
        }
        
        if (!$templatefound && file_exists($_CONF['path_layout'] . $positionSpecific)) {
            $template = $positionSpecific;
            $templatefound = true; // If found don't need to search theme default if exist
        }
        // See if default theme if so check there
        if (!$templatefound && !empty($_CONF['theme_default'])) {
            if (file_exists($_CONF['path_layout_default'] . $positionSpecific)) {
                $template = $positionSpecific;
            }
        }
    }

    if ($_COM_VERBOSE) {
        COM_errorLog("Block template for the $which of $blockName is: $template", 1);
    }

    return $template;
}

/**
 * Gets all installed themes
 * Returns a list of all the directory names in $_CONF['path_themes'], i.e.
 * a list of all the theme names.
 *
 * @param    boolean $all if true, return all themes even if users aren't allowed to change their default themes
 * @return   array        All installed themes
 */
function COM_getThemes($all = false)
{
    global $_CONF;

    $index = 1;
    $themes = array();

    // If users aren't allowed to change their theme then only return the default theme

    if (($_CONF['allow_user_themes'] == 0) && !$all) {
        $themes[$index] = $_CONF['theme'];
    } else {
        $fd = opendir($_CONF['path_themes']);

        while (($dir = @readdir($fd)) !== false) {
            if (is_dir($_CONF['path_themes'] . $dir) && ($dir !== '.') && ($dir !== '..') &&
                ($dir !== 'CVS') && (substr($dir, 0, 1) !== '.')
            ) {
                clearstatcache();
                $themes[$index] = $dir;
                $index++;
            }
        }
    }

    return $themes;
}

/**
 * Create the menu, i.e. replace {menu_elements} in the site header with the
 * actual menu entries.
 *
 * @param    Template $header      reference to the header template
 * @param    array    $plugin_menu array of plugin menu entries, if any
 */
function COM_renderMenu($header, $plugin_menu)
{
    global $_CONF, $LANG01, $topic;

    if (empty($_CONF['menu_elements'])) {
        $_CONF['menu_elements'] = array( // default set of links
            'contribute', 'search', 'stats', 'directory', 'plugins',
        );
    }

    $anon = COM_isAnonUser();
    $menuCounter = 0;
    $allowedCounter = 0;
    $counter = 0;
    $custom_entries = array();

    $num_plugins = count($plugin_menu);
    if (($num_plugins === 0) && in_array('plugins', $_CONF['menu_elements'])) {
        $key = array_search('plugins', $_CONF['menu_elements']);
        unset($_CONF['menu_elements'][$key]);
    }

    if (in_array('custom', $_CONF['menu_elements'])) {
        if (function_exists('CUSTOM_menuEntries')) {
            $custom_entries = CUSTOM_menuEntries();
        }
        if (count($custom_entries) === 0) {
            $key = array_search('custom', $_CONF['menu_elements']);
            unset($_CONF['menu_elements'][$key]);
        }
    }

    $num_elements = count($_CONF['menu_elements']);

    foreach ($_CONF['menu_elements'] as $item) {
        $counter++;
        $allowed = true;
        $last_entry = ($counter == $num_elements);

        switch ($item) {
            case 'contribute':
                $url = $_CONF['site_url'] . '/submit.php?type=story';
                $header->set_var('current_topic', '');

                $label = $LANG01[71];
                if ($anon && ($_CONF['loginrequired'] ||
                        $_CONF['submitloginrequired'])
                ) {
                    $allowed = false;
                }
                break;

            case 'custom':
                if (function_exists('CUSTOM_renderMenu')) {
                    CUSTOM_renderMenu($header, $custom_entries, $menuCounter);
                } else {
                    $custom_count = 0;
                    $custom_size = count($custom_entries);
                    foreach ($custom_entries as $entry) {
                        $custom_count++;

                        if (empty($entry['url']) || empty($entry['label'])) {
                            continue;
                        }

                        $header->set_var('menuitem_url', $entry['url']);
                        $header->set_var('menuitem_text', $entry['label']);

                        if ($last_entry && ($custom_count == $custom_size)) {
                            $header->parse('menu_elements', 'menuitem_last',
                                true);
                        } else {
                            $header->parse('menu_elements', 'menuitem', true);
                        }
                        $menuCounter++;
                    }
                }
                $url = '';
                $label = '';
                break;

            case 'directory':
                $url = $_CONF['site_url'] . '/directory.php';
                if (!empty($topic)) {
                    $url = COM_buildURL($url . '?topic=' . urlencode($topic));
                }
                $label = $LANG01[117];
                if ($anon && ($_CONF['loginrequired'] || $_CONF['directoryloginrequired'])) {
                    $allowed = false;
                }
                break;

            case 'home':
                $url = $_CONF['site_url'] . '/';
                $label = $LANG01[90];
                break;

            case 'plugins':
                for ($i = 1; $i <= $num_plugins; $i++) {
                    $header->set_var('menuitem_url', current($plugin_menu));
                    $header->set_var('menuitem_text', key($plugin_menu));

                    if ($last_entry && ($i == $num_plugins)) {
                        $header->parse('menu_elements', 'menuitem_last',
                            true);
                    } else {
                        $header->parse('menu_elements', 'menuitem', true);
                    }

                    $menuCounter++;
                    next($plugin_menu);
                }

                $url = '';
                $label = '';
                break;

            case 'login':
                if ($anon) {
                    $url = $_CONF['site_url'] . '/users.php';
                    $label = $LANG01[58];
                } else {
                    $url = $_CONF['site_url'] . '/users.php?mode=logout';
                    $label = $LANG01[35];
                }
                break;

            case 'prefs':
                if ($anon) {
                    $url = '';
                    $label = '';
                } else {
                    $url = $_CONF['site_url'] . '/usersettings.php';
                    $label = $LANG01[48];
                }
                break;

            case 'search':
                $url = $_CONF['site_url'] . '/search.php';
                $label = $LANG01[75];
                if ($anon && ($_CONF['loginrequired'] || $_CONF['searchloginrequired'])) {
                    $allowed = false;
                }
                break;

            case 'stats':
                $url = $_CONF['site_url'] . '/stats.php';
                $label = $LANG01[76];
                if ($anon &&
                    ($_CONF['loginrequired'] || $_CONF['statsloginrequired'])
                ) {
                    $allowed = false;
                }
                break;

            default: // unknown entry
                $url = '';
                $label = '';
                break;
        }

        if (!empty($url) && !empty($label)) {
            $header->set_var('menuitem_url', $url);
            $header->set_var('menuitem_text', $label);
            if ($last_entry) {
                $header->parse('menu_elements', 'menuitem_last', true);
            } else {
                $header->parse('menu_elements', 'menuitem', true);
            }
            $menuCounter++;

            if ($allowed) {
                if ($last_entry) {
                    $header->parse('allowed_menu_elements', 'menuitem_last',
                        true);
                } else {
                    $header->parse('allowed_menu_elements', 'menuitem', true);
                }
                $allowedCounter++;
            }
        }
    }

    if ($menuCounter == 0) {
        $header->parse('menu_elements', 'menuitem_none', true);
    }
    if ($allowedCounter == 0) {
        $header->parse('allowed_menu_elements', 'menuitem_none', true);
    }
}

/**
 * Create and return the HTML document
 *
 * @param  string $content      Main content for the page
 * @param  array  $information  An array defining variables to be used when creating the output
 *                              string  'what'          If 'none' then no left blocks are returned, if 'menu'
 *                              (default) then right blocks are returned string  'pagetitle'     Optional content for
 *                              the page's <title> string  'breadcrumbs'   Optional content for the page's breadcrumb
 *                              string  'headercode'    Optional code to go into the page's <head> boolean
 *                              'rightblock'    Whether or not to show blocks on right hand side default is no (-1)
 *                              array   'custom'        An array defining custom function to be used to format
 *                              Rightblocks
 * @return string              Formatted HTML document
 */
function COM_createHTMLDocument(&$content = '', $information = array())
{
    global $_CONF, $_VARS, $_TABLES, $_USER, $LANG01, $LANG_BUTTONS, $LANG_DIRECTION,
           $_IMAGE_TYPE, $topic, $_COM_VERBOSE, $_SCRIPTS, $_STRUCT_DATA, $_PAGE_TIMER;

    // Retrieve required variables from information array
    $what = isset($information['what']) ? $information['what'] : 'menu';
    $pageTitle = isset($information['pagetitle']) ? $information['pagetitle'] : '';
    $headerCode = isset($information['headercode']) ? $information['headercode'] : '';
    $breadcrumbs = isset($information['breadcrumbs']) ? $information['breadcrumbs'] : '';
    $rightBlock = isset($information['rightblock']) ? $information['rightblock'] : -1;
    $custom = isset($information['custom']) ? $information['custom'] : '';
    $relLinks = array();

    // If the theme implemented this for us then call their version instead.
    $function = $_CONF['theme'] . '_createHTMLDocument';
    if (function_exists($function)) {
        return $function($content, $information);
    }

    // If we reach here then either we have the default theme OR
    // the current theme only needs the default variable substitutions
    switch ($_CONF['doctype']) {
        case 'html401transitional':
            $docType = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
            break;

        case 'html401strict':
            $docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
            break;

        case 'xhtml10transitional':
            $docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
            break;

        case 'xhtml10strict':
            $docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
            break;

        case 'html5':
        case 'xhtml5':
            $docType = '<!DOCTYPE html>';
            break;

        default: // fallback: HTML 4.01 Transitional w/o system identifier
            $docType = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
            break;
    }

    // send out the charset header
    header('Content-Type: text/html; charset=' . COM_getCharset());
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');

    if (!empty($_CONF['frame_options'])) {
        header('X-FRAME-OPTIONS: ' . $_CONF['frame_options']);
    }

    $page = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
    $page->set_file(array(
        'page'           => 'index.thtml',
        'menunavigation' => 'menunavigation.thtml',
        'leftblocks'     => 'leftblocks.thtml',
        'rightblocks'    => 'rightblocks.thtml',
    ));
    $blocks = array('menuitem', 'menuitem_last', 'menuitem_none');
    foreach ($blocks as $block) {
        $page->set_block('menunavigation', $block);
    }

    $page->parse('menu_elements', 'menunavigation', true);

    $page->set_var('doctype', $docType . LB);

    COM_setLangIdAndAttribute($page);
    $langId = $page->get_var('lang_id');

    if (XHTML == '') {
        $page->set_var('xmlns', '');
    } else {
        $page->set_var('xmlns', ' xmlns="http://www.w3.org/1999/xhtml" xml:lang="' . $langId . '"');
    }

    $feed_url = array();
    if ($_CONF['backend'] == 1) { // add feed-link to header if applicable
        $baseUrl = SYND_getFeedUrl();

        $sql = "SELECT format, filename, title, language FROM {$_TABLES['syndication']} "
            . " WHERE (header_tid = 'all')";
        if (!empty($topic)) {
            $sql .= " OR (header_tid = '" . DB_escapeString($topic) . "')";
        }
        $result = DB_query($sql);
        $numRows = DB_numRows($result);
        for ($i = 0; $i < $numRows; $i++) {
            $A = DB_fetchArray($result);
            if (!empty($A['filename'])) {
                $format_type = SYND_getMimeType($A['format']);
                $format_name = SYND_getFeedType($A['format']);
                $feed_title = $format_name . ' Feed: ' . $A['title'];

                $feed_url[] = '<link rel="alternate" type="' . $format_type
                    . '" href="' . $baseUrl . $A['filename'] . '" title="'
                    . htmlspecialchars($feed_title) . '"' . XHTML . '>';
            }
        }
    }
    $page->set_var('feed_url', implode(LB, $feed_url));

    // for backward compatibility only - use {feed_url} instead
    $feed = SYND_getDefaultFeedUrl();
    $isOnFrontPage = COM_onFrontpage();

    if ($isOnFrontPage) {
        $relLinks['canonical'] = '<link rel="canonical" href="' . $_CONF['site_url'] . '/"' . XHTML . '>';
    } else {
        $relLinks['home'] = '<link rel="home" href="' . $_CONF['site_url'] . '/" title="' . $LANG01[90] . '"' . XHTML . '>';
    }
    $loggedInUser = !COM_isAnonUser();
    if ($loggedInUser || (($_CONF['loginrequired'] == 0) && ($_CONF['searchloginrequired'] == 0))) {
        if ((substr($_SERVER['PHP_SELF'], -strlen('/search.php')) !== '/search.php') || isset($_GET['mode'])) {
            $relLinks['search'] = '<link rel="search" href="' . $_CONF['site_url'] . '/search.php" title="'
                . $LANG01[75] . '"' . XHTML . '>';
        }
    }
    if ($loggedInUser || (($_CONF['loginrequired'] == 0) && ($_CONF['directoryloginrequired'] == 0))) {
        if (strpos($_SERVER['PHP_SELF'], '/article.php') !== false) {
            $relLinks['contents'] = '<link rel="contents" href="'
                . $_CONF['site_url'] . '/directory.php" title="'
                . $LANG01[117] . '"' . XHTML . '>';
        }
    }
    if (!$_CONF['disable_webservices']) {
        $relLinks['service'] = '<link rel="service" '
            . 'type="application/atomsvc+xml" ' . 'href="'
            . $_CONF['site_url'] . '/webservices/atom/?introspection" '
            . 'title="' . $LANG01[130] . '"' . XHTML . '>';
    }
    // TBD: add a plugin API and a lib-custom.php function
    $page->set_var('rel_links', implode(LB, $relLinks));

    $pageTitle_siteSlogan = false;
    if (empty($pageTitle)) {
        if (empty($topic)) {
            $pageTitle = $_CONF['site_slogan'];
            $pageTitle_siteSlogan = true;
        } else {
            $pageTitle = stripslashes(DB_getItem($_TABLES['topics'], 'topic', "tid = '$topic'"));
        }
    }
    if (!empty($pageTitle)) {
        $page->set_var('page_site_splitter', ' - ');
    } else {
        $page->set_var('page_site_splitter', '');
    }
    $page->set_var('page_title', $pageTitle);
    $page->set_var('site_name', $_CONF['site_name']);

    if ($isOnFrontPage || $pageTitle_siteSlogan) {
        $title_and_name = $_CONF['site_name'];
        if (!empty($pageTitle)) {
            $title_and_name .= ' - ' . $pageTitle;
        }
    } else {
        $title_and_name = '';
        if (!empty($pageTitle)) {
            $title_and_name = $pageTitle . ' - ';
        }
        $title_and_name .= $_CONF['site_name'];
    }
    $page->set_var('page_title_and_site_name', $title_and_name);
    $page->set_var('background_image', $_CONF['layout_url'] . '/images/bg.' . $_IMAGE_TYPE);

    $msg = rtrim($LANG01[67]) . ' ' . $_CONF['site_name'];

    if (!empty($_USER['username'])) {
        $msg .= ', ' . COM_getDisplayName($_USER['uid'], $_USER['username'], $_USER['fullname']);
    }

    $currentTime = COM_getUserDateTimeFormat();

    $page->set_var('welcome_msg', $msg);
    $page->set_var('datetime', $currentTime[0]);
    $page->set_var('site_logo', $_CONF['layout_url'] . '/images/logo.' . $_IMAGE_TYPE);
    $page->set_var('theme', $_CONF['theme']);
    $page->set_var('datetime_html5', strftime('%FT%T', $currentTime[1]));

    $page->set_var('charset', COM_getCharset());
    $page->set_var('direction', $LANG_DIRECTION);

    $template_vars = array(
        'rdf_file'           => $feed,
        'rss_url'            => $feed,
        'site_mail'          => "mailto:{$_CONF['site_mail']}",
        'site_name'          => $_CONF['site_name'],
        'site_slogan'        => $_CONF['site_slogan'],
        // Now add variables for buttons like e.g. those used by the Yahoo theme
        'button_home'        => $LANG_BUTTONS[1],
        'button_contact'     => $LANG_BUTTONS[2],
        'button_contribute'  => $LANG_BUTTONS[3],
        'button_sitestats'   => $LANG_BUTTONS[7],
        'button_personalize' => $LANG_BUTTONS[8],
        'button_search'      => $LANG_BUTTONS[9],
        'button_advsearch'   => $LANG_BUTTONS[10],
        'button_directory'   => $LANG_BUTTONS[11],
    );
    $page->set_var($template_vars);

    // Get plugin menu options
    $plugin_menu = PLG_getMenuItems();

    if ($_COM_VERBOSE) {
        COM_errorLog('num plugin menu items in header = ' . count($plugin_menu), 1);
    }

    // Now add nested template for menu items
    COM_renderMenu($page, $plugin_menu);

    if (count($plugin_menu) === 0) {
        $page->parse('plg_menu_elements', 'menuitem_none', true);
    } else {
        $count_plugin_menu = count($plugin_menu);
        for ($i = 1; $i <= $count_plugin_menu; $i++) {
            $page->set_var('menuitem_url', current($plugin_menu));
            $page->set_var('menuitem_text', key($plugin_menu));

            if ($i == $count_plugin_menu) {
                $page->parse('plg_menu_elements', 'menuitem_last', true);
            } else {
                $page->parse('plg_menu_elements', 'menuitem', true);
            }

            next($plugin_menu);
        }
    }

    // Call to plugins to set template variables in the header
    PLG_templateSetVars('header', $page);

    // Set last topic session variable
    if ($topic == TOPIC_ALL_OPTION) {
        $topic = ''; // Do not save 'all' option. Nothing is the same thing
    }
    SESS_setVariable('topic', $topic);

    // Call any plugin that may want to include extra Meta tags
    // or Javascript functions
    $headerCode .= PLG_getHeaderCode();

    // Meta Tags
    // 0 = Disabled, 1 = Enabled, 2 = Enabled but default just for homepage
    if ($_CONF['meta_tags'] > 0) {
        $meta_description = '';
        $meta_keywords = '';
        $no_meta_description = 1;
        $no_meta_keywords = 1;

        // Find out if the meta tag description or keywords already exist in the headercode
        if ($headerCode != '') {
            $pattern = '/<meta ([^>]*)name="([^"\'>]*)"([^>]*)/im';
            if (preg_match_all($pattern, $headerCode, $matches, PREG_SET_ORDER)) {
                // Loop through all meta tags looking for description and keywords
                for ($i = 0; $i < count($matches) && (($no_meta_description == 1) || ($no_meta_keywords == 1)); $i++) {
                    $str_matches = strtolower($matches[$i][0]);
                    $pos = strpos($str_matches, 'name=');
                    if (!(is_bool($pos) && !$pos)) {
                        $name = trim(substr($str_matches, $pos + 5), '"');
                        $pos = strpos($name, '"');
                        $name = substr($name, 0, $pos);

                        if (strcasecmp('description', $name) === 0) {
                            $pos = strpos($str_matches, 'content=');
                            if (!(is_bool($pos) && !$pos)) {
                                $no_meta_description = 0;
                            }
                        }
                        if (strcasecmp('keywords', $name) === 0) {
                            $pos = strpos($str_matches, 'content=');
                            if (!(is_bool($pos) && !$pos)) {
                                $no_meta_keywords = 0;
                            }
                        }
                    }
                }
            }
        }

        if ($isOnFrontPage && ($_CONF['meta_tags'] == 2)) { // Display default meta tags only on home page
            if ($no_meta_description) {
                $meta_description = $_CONF['meta_description'];
            }
            if ($no_meta_keywords) {
                $meta_keywords = $_CONF['meta_keywords'];
            }
        } elseif ($_CONF['meta_tags'] == 1) { // Display default meta tags anywhere there are no tags
            if ($no_meta_description) {
                $meta_description = $_CONF['meta_description'];
            }
            if ($no_meta_keywords) {
                $meta_keywords = $_CONF['meta_keywords'];
            }
        }

        if ($no_meta_description || $no_meta_keywords) {
            $headerCode .= COM_createMetaTags($meta_description, $meta_keywords);
        }
    }

    $page->set_var('breadcrumb_trail', $breadcrumbs);

    // Add Cookie Consent ( https://cookieconsent.osano.com )
    if (isset($_CONF['cookie_consent']) && $_CONF['cookie_consent']) {
        $_SCRIPTS->setCssFile(
            'cookiconsent', 'https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css',
            true, array(), 100
        );
        $_SCRIPTS->setJavaScriptFile(
            'cookie_consent', 'https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js',
            false, 100, false,
            array('data-cfasync' => 'false')
        );

        // To customize appearance and behavior, edit the following file
        $_SCRIPTS->setJavaScriptFile(
            'cookie_consent_config', '/javascript/cookie_consent.js',
            true, 110
        );
    }

    COM_hit();

    $year = date('Y');
    $copyrightYear = empty($_CONF['copyrightyear']) ? $year : $_CONF['copyrightyear'];
    $copyrightName = empty($_CONF['owner_name']) ? $_CONF['site_name'] : $_CONF['owner_name'];
    $page->set_var('copyright_msg', $LANG01[93] . ' &copy; ' . $copyrightYear . ' ' . $copyrightName);
    $page->set_var('current_year', $year);
    $page->set_var('lang_copyright', $LANG01[93]);
    $page->set_var('trademark_msg', $LANG01[94]);
    $page->set_var('powered_by', $LANG01[95]);
    $page->set_var('geeklog_url', 'https://www.geeklog.net/');
    $page->set_var('geeklog_version', VERSION);

    $page->set_var($template_vars);

    /* Right blocks. Argh. Don't talk to me about right blocks...
     * Right blocks will be displayed if this function has been asked to show them (first param) 
     * OR the show_right_blocks conf variable has been set to override what the code
     * wants to do.
     *
     * If $custom sets an array (containing functionname and first argument)
     * then this is used instead of the default (COM_showBlocks) to render
     * the right blocks (and left).
     */
    if (($rightBlock < 0) || !$rightBlock) {
        if (isset($_CONF['show_right_blocks'])) {
            $displayRightBlocks = $_CONF['show_right_blocks'];
        } else {
            $displayRightBlocks = false;
        }
    } else {
        $displayRightBlocks = true;
    }

    if ($displayRightBlocks) {
        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function.
         * This can be used to take control over what blocks are then displayed
         */
        if (is_array($custom)) {
            $function = $custom[0];
            if (function_exists($function)) {
                $rBlocks = $function($custom[1], 'right');
            } else {
                $rBlocks = COM_showBlocks('right');
            }
        } else {
            if (is_array($what)) {
                $function = $what[0];
                if (function_exists($function)) {
                    $rBlocks = $function($what[1], 'right');
                } else {
                    $rBlocks = COM_showBlocks('right');
                }
            } elseif ($what !== 'none') {
                // Now show any blocks -- need to get the topic if not on home page
                $rBlocks = COM_showBlocks('right');
            }        
        }
        if (empty($rBlocks)) {
            $page->set_var('geeklog_blocks', '');
            $page->set_var('right_blocks', '');
        } else {
            $page->set_var('geeklog_blocks', $rBlocks);
            $page->parse('right_blocks', 'rightblocks', true);
            $page->set_var('geeklog_blocks', '');
        }
    } else {
        $page->set_var('geeklog_blocks', '');
        $page->set_var('right_blocks', '');
    }
    
   // Figure out Left blocks
    $lBlocks = '';

    /* Check if an array has been passed that includes the name of a plugin
     * function or custom function
     * This can be used to take control over what blocks are then displayed
     */
    if (is_array($custom)) {
        $function = $custom[0];
        if (function_exists($function)) {
            $lBlocks = $function($custom[1], 'left');
        }
    } else {
        if (is_array($what)) {
            $function = $what[0];
            if (function_exists($function)) {
                $lBlocks = $function($what[1], 'left');
            } else {
                $lBlocks = COM_showBlocks('left');
            }
        } elseif ($what !== 'none') {
            // Now show any blocks -- need to get the topic if not on home page
            $lBlocks = COM_showBlocks('left');
        }            
    }

    if (empty($lBlocks)) {
        $page->set_var('left_blocks', '');
        $page->set_var('geeklog_blocks', '');
    } else {
        $page->set_var('geeklog_blocks', $lBlocks);
        $page->parse('left_blocks', 'leftblocks', true);
        $page->set_var('geeklog_blocks', '');
    }

    $execTime = $_PAGE_TIMER->stopTimer();
    $execText = $LANG01[91] . ' ' . $execTime . ' ' . $LANG01[92];

    $page->set_var('execution_time', $execTime);
    $page->set_var('execution_textandtime', $execText);

    // Check leftblocks and rightblocks
    // Can be used to set custom css classes or as a signal to the template class in if statements
    $layout_columns = 'left-center-right';
    $emptyLeftBlocks = empty($lBlocks);
    $emptyRightBlocks = empty($rBlocks);
    if (!$emptyLeftBlocks && $emptyRightBlocks) {
        $layout_columns = 'left-center';
    }
    if ($emptyLeftBlocks && !$emptyRightBlocks) {
        $layout_columns = 'center-right';
    }
    if ($emptyLeftBlocks && $emptyRightBlocks) {
        $layout_columns = 'center';
    }
    $page->set_var('layout_columns', $layout_columns);

    // All blocks, autotags, template files, etc, now have been rendered (since can be done in footer) so all scripts and css should be set now
    $headerCode = $_STRUCT_DATA->toScript() . $headerCode;
    $headerCode = $_SCRIPTS->getHeader() . $headerCode;
    $page->set_var('plg_headercode', $headerCode);

    // Call to plugins to set template variables in the footer
    PLG_templateSetVars('footer', $page);

    // Call any plugin that may want to include extra JavaScript functions
    $pluginFooterCode = PLG_getFooterCode();
    // Retrieve any JavaScript libraries, variables and functions
    $footerCode = $_SCRIPTS->getFooter();
    // $_SCRIPTS code should be placed before plugin_footer_code but plugin_footer_code should still be allowed to set $_SCRIPTS
    $footerCode .= $pluginFooterCode;
    $page->set_var('plg_footercode', $footerCode);

    $page->set_var('content', $content);
    
    // Actually parse the template and make variable substitutions
    $page->parse('index', 'page');
    
    return $page->finish($page->get_var('index'));
}

/**
 * Prints out standard block header
 * Prints out standard block header but pulling header HTML formatting from
 * the database.
 * Programming Note:  The two functions COM_startBlock and COM_endBlock are used
 * to sandwich your block content.  These functions are not used only for blocks
 * but anything that uses that format, e.g. Stats page.  They are used like
 * COM_createHTMLDocument but for internal page elements.
 *
 * @param    string $title      Value to set block title to
 * @param    string $helpFile   Help file, if one exists
 * @param    string $template   HTML template file to use to format the block
 * @param    string $cssId      CSS ID (since GL 2.2.0, optional)
 * @param    string $cssClasses CSS class names separated by space (since GL 2.2.0, optional)
 * @param    string $plugin     Using a Plugin custom block location (since GL 2.2.0, optional)
 * @return   string             Formatted HTML containing block header
 * @see COM_endBlock
 * @see COM_createHTMLDocument
 */
function COM_startBlock($title = '', $helpFile = '', $template = 'blockheader.thtml', $cssId = '', $cssClasses = '', $plugin = '')
{
    global $_CONF, $LANG32, $_IMAGE_TYPE, $_SCRIPTS;

    // If the theme implemented this for us then call their version instead.
    $function = $_CONF['theme'] . '_startBlock';
    if (function_exists($function)) {
        return $function($title, $helpFile, $template);
    }

    // need to check if template file found for plugin if not then use regular theme location
    $templateFound = false;
    if (!empty($plugin)) {
        $plugin_template_paths = CTL_plugin_templatePath($plugin);
        foreach($plugin_template_paths as $plugin_template_path) {
             if (file_exists($plugin_template_path . '/' . $template)) {
                 $block = COM_newTemplate(CTL_plugin_templatePath($plugin));
                 $templateFound = true; // If found don't need to search theme or theme default if exist
                 break;
             }
        }
    }    
    if (!$templateFound) {
        // If error happens early in the process (ie COM_handleException is called) the caching template library may not be loaded so fall back
        if (function_exists('CTL_core_templatePath')) {
            $block = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
        } else {
            $block = COM_newTemplate($_CONF['path_layout']);
        }
    }
    $block->set_file('block', $template);

    $block->set_var(array(
        'block_title' => stripslashes($title),
        'css_id'      => $cssId,
        'css_classes' => $cssClasses,
    ));

    if (!empty($helpFile)) {
        $helpPopup = "";
        // Only works when header generated all at once
        // Make sure not a full link. Needs to follow help file format (correct location and divs)
        if (!stristr($helpFile, 'http://') && !stristr($helpFile, 'https://')) {
            $helpPopup = "gl-help-popup";
            // Only need to set it once
            if (!defined('GL-HELP-SET')) {
                define('GL-HELP-SET', true);

                // Add in jQuery dialog for help file
                $_SCRIPTS->setJavaScriptLibrary('jquery-ui'); // Requires dialog, draggable, droppable, resizable, and button
                $_SCRIPTS->setJavaScriptLibrary('jquery-ui-dialogoptions'); // extends jquery dialog functions to include responsive
                
                // Add Language variables
                $_SCRIPTS->setLang(array('close' => $LANG32[60]));

                // Add JavaScript
                $_SCRIPTS->setJavaScriptFile('dialog_help', '/javascript/dialog_help.js');
            }
        }

        if (preg_match('@^https?://@', $helpFile)) {
            $help_url = $helpFile;
        } else {
            $help_url = COM_getDocumentUrl('help', $helpFile);
        }

        $block->set_var('help_title', $title);
        $block->set_var('help_url', $help_url);
        $block->set_var('gl-help-popup', $helpPopup);
    }

    $block->parse('startHTML', 'block');

    return $block->finish($block->get_var('startHTML'));
}

/**
 * Closes out COM_startBlock
 *
 * @param    string $template HTML template file used to format block footer
 * @param    string $plugin   plugin name
 * @return   string           Formatted HTML to close block
 * @see function COM_startBlock
 */
function COM_endBlock($template = 'blockfooter.thtml', $plugin = '')
{
    global $_CONF;

    // If the theme implemented this for us then call their version instead.
    $function = $_CONF['theme'] . '_endBlock';
    if (function_exists($function)) {
        return $function($template);
    }

    // need to check if template file found for plugin if not then use regular theme location
    $templateFound = false;
    if (!empty($plugin)) {
        $plugin_template_paths = CTL_plugin_templatePath($plugin);
        foreach($plugin_template_paths as $plugin_template_path) {
             if (file_exists($plugin_template_path . '/' . $template)) {
                 $block = COM_newTemplate(CTL_plugin_templatePath($plugin));
                 $templateFound = true; // If found don't need to search theme or theme default if exist
                 break;
             }
        }
    }    
    if (!$templateFound) {
        // If error happens early in the process (ie COM_handleException is called) the caching template library may not be loaded so fall back
        if (function_exists('CTL_core_templatePath')) {
            $block = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
        } else {
            $block = COM_newTemplate($_CONF['path_layout']);
        }
    } 
    
    $block->set_file('block', $template);

    $block->parse('endHTML', 'block');

    return $block->finish($block->get_var('endHTML'));
}

/**
 * Creates a <option> list from a database list for use in forms
 * Creates option list form field using given arguments
 *
 * @param  string $langVariableName one of 'LANG_commentcodes', 'LANG_commentmodes', 'LANG_cookiecodes',
 *                                  'LANG_featurecodes', 'LANG_frontpagecodes', 'LANG_postmodes', 'LANG_sortcodes',
 *                                  'LANG_statuscodes', 'LANG_trackbackcodes'
 * @param  mixed  $selected         Value (from $selection) to set to SELECTED or default
 * @see function COM_checkList
 * @return   string  Formatted HTML of option values
 */
function COM_optionListFromLangVariables($langVariableName, $selected = '')
{
    static $langVariableNames = array(
        'LANG_commentcodes', 'LANG_commentmodes', 'LANG_featurecodes', 'LANG_frontpagecodes',
        'LANG_postmodes', 'LANG_sortcodes', 'LANG_statuscodes', 'LANG_trackbackcodes', 'LANG_structureddatatypes'
    );
    static $charset = null;

    if (!in_array($langVariableName, $langVariableNames)) {
        throw new InvalidArgumentException('Unknown language variable name: ' . $langVariableName);
    }

    if ($charset === null) {
        $charset = COM_getEncodingt();
    }

    global $$langVariableName;

    $retval = '';

    foreach ($$langVariableName as $value => $text) {
        $isSelected = ($value == $selected) ? ' selected="selected"' : '';
        $retval .= sprintf(
                '<option value="%s"%s>%s</option>',
                htmlspecialchars($value, ENT_QUOTES, $charset),
                $isSelected,
                htmlspecialchars($text, ENT_QUOTES, $charset)
            ) . PHP_EOL;
    }

    return $retval;
}

/**
 * Creates a <option> list from a database list for use in forms
 * Creates option list form field using given arguments
 *
 * @param        string $table     Database Table to get data from
 * @param        string $selection Comma delimited string of fields to pull The first field is the value of the option
 *                                 and the second is the label to be displayed.  This is used in a SQL statement and
 *                                 can include DISTINCT to start.
 * @param               string     /array      $selected   Value (from $selection) to set to SELECTED or default
 * @param        int    $sortCol   Which field to sort option list by 0 (value) or 1 (label)
 * @param        string $where     Optional WHERE clause to use in the SQL Selection
 * @see function COM_checkList
 * @return   string  Formatted HTML of option values
 */
function COM_optionList($table, $selection, $selected = '', $sortCol = 1, $where = '')
{
    global $_DB_table_prefix;
    static $langTableNames = array(
        'LANG_commentcodes', 'LANG_commentmodes', 'LANG_featurecodes', 'LANG_frontpagecodes',
        'LANG_postmodes', 'LANG_sortcodes', 'LANG_statuscodes', 'LANG_trackbackcodes',
    );

    if (substr($table, 0, strlen($_DB_table_prefix)) === $_DB_table_prefix) {
        $LangTableName = 'LANG_' . substr($table, strlen($_DB_table_prefix));
    } else {
        $LangTableName = 'LANG_' . $table;
    }

    if (in_array($LangTableName, $langTableNames)) {
        return COM_optionListFromLangVariables($LangTableName, $selected);
    }

    // Currently, this is the case with $_TABLES['dateformats']
    global $$LangTableName;

    $retval = '';

    $LangTable = isset($$LangTableName) ? $$LangTableName : array();
    $tmp = str_replace('DISTINCT ', '', $selection);
    $select_set = explode(',', $tmp);

    $sql = "SELECT $selection FROM $table";
    if ($where !== '') {
        $sql .= " WHERE {$where}";
    }
    $sql .= " ORDER BY {$select_set[$sortCol]}";
    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result, true);
        $retval .= '<option value="' . $A[0] . '"';

        if (is_array($selected) && (count($selected) > 0)) {
            foreach ($selected as $selected_item) {
                if ($A[0] == $selected_item) {
                    $retval .= ' selected="selected"';
                }
            }
        } elseif (!is_array($selected) && ($A[0] == $selected)) {
            $retval .= ' selected="selected"';
        }

        $retval .= '>';
        if (empty($LangTable[$A[0]])) {
            $retval .= $A[1];
        } else {
            $retval .= $LangTable[$A[0]];
        }
        $retval .= '</option>' . LB;
    }

    return $retval;
}

/**
 * Create and return a dropdown-list of available topics
 * This is a variation of COM_optionList() from lib-common.php. It will add
 * only those topics to the option list which are accessible by the current
 * user.
 *
 * @param        string  $selection  Comma delimited string of fields to pull The first field is the value of the
 *                                   option and the second is the label to be displayed.  This is used in a SQL
 *                                   statement and can include DISTINCT to start.
 * @param        string  $selected   Value (from $selection) to set to SELECTED or default
 * @param        int     $sortCol    Which field to sort option list by 0 (value) or 1 (label)
 * @param        boolean $ignoreLang Whether to return all topics (true) or only the ones for the current language
 *                                   (false)
 * @see function COM_optionList
 * @return   string  Formatted HTML of option values
 */
function COM_topicList($selection, $selected = '', $sortCol = 1, $ignoreLang = false)
{
    $retval = '';

    $topics = COM_topicArray($selection, $sortCol, $ignoreLang);
    foreach ($topics as $tid => $topic) {
        $retval .= '<option value="' . $tid . '"';
        if (is_array($selected)) {
            foreach ($selected as $multiSelectTid) {
                if ($tid == $multiSelectTid) {
                    $retval .= ' selected="selected"';
                    break;
                }
            }
        } else {
            if ($tid == $selected) {
                $retval .= ' selected="selected"';
            }
        }
        $retval .= '>' . $topic . '</option>' . LB;
    }

    return $retval;
}

/**
 * Return a list of topics in an array
 * (derived from COM_topicList - API may change)
 *
 * @param    string  $selection  Comma delimited string of fields to pull The first field is the value of the option
 *                               and the second is the label to be displayed.  This is used in a SQL statement and can
 *                               include DISTINCT to start.
 * @param    int     $sortCol    Which field to sort option list by 0 (value) or 1 (label)
 * @param    boolean $ignoreLang Whether to return all topics (true) or only the ones for the current language (false)
 * @return   array               Array of topics
 * @see function COM_topicList
 */
function COM_topicArray($selection, $sortCol = 0, $ignoreLang = false)
{
    global $_TABLES;

    $retval = array();

    $tmp = str_replace('DISTINCT ', '', $selection);
    $select_set = explode(',', $tmp);

    $sql = "SELECT {$selection} FROM {$_TABLES['topics']}";
    if ($ignoreLang) {
        $sql .= COM_getPermSQL();
    } else {
        $permSql = COM_getPermSQL();
        if (empty($permSql)) {
            $sql .= COM_getLangSQL('tid');
        } else {
            $sql .= $permSql . COM_getLangSQL('tid', 'AND');
        }
    }
    $sql .= " ORDER BY $select_set[$sortCol]";

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    if (count($select_set) > 1) {
        for ($i = 0; $i < $numRows; $i++) {
            $A = DB_fetchArray($result, true);
            $retval[$A[0]] = stripslashes($A[1]);
        }
    } else {
        for ($i = 0; $i < $numRows; $i++) {
            $A = DB_fetchArray($result, true);
            $retval[] = $A[0];
        }
    }

    return $retval;
}

/**
 * Create and return some control for use in forms
 *
 * @param    string $type      Type of control
 * @param    array  $variables Hash of variable name/value pairs
 * @return   string            Formatted HTML of control code
 */
function COM_createControl($type, $variables = array())
{
    global $_CONF;

    static $tcc = null;

    if ($tcc === null) {
        $tcc = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'controls'));
        $tcc->set_file('common', 'common.thtml');
        $blocks = array(
            'type-hidden',
            'type-image',
            'type-checkbox',
            'type-radio',
            'type-select',
            'type-submit',
            
            'type-select-width-small',
            
            'controls-center',
            'controls-left',
            'controls-right',
            
            'display-text-warning',
            'display-text-warning-small',
            'display-text-strikethrough',
            'display-allowed-html',
            'display-allowed-autotags'
        );
        foreach ($blocks as $block) {
            $tcc->set_block('common', $block);
        }
    }
    $tcc->set_var($variables);
    $retval = $tcc->finish($tcc->parse('common', $type));
    foreach($variables as $key => $val) {
        $tcc->unset_var($key);
    }

    return $retval;
}

/**
 * Creates a <input> checklist from a database list for use in forms
 * Creates a group of checkbox form fields with given arguments
 *
 * @param    string $table     DB Table to pull data from
 * @param    string $selection Comma delimited list of fields to pull from table
 * @param    string $where     Where clause of SQL statement
 * @param    string $selected  Value to set to CHECKED
 * @param    string $fieldName Name to use for the checkbox array
 * @return   string            HTML with Checkbox code
 * @see      COM_optionList
 */
function COM_checkList($table, $selection, $where = '', $selected = '', $fieldName = '')
{
    global $_CONF, $_TABLES, $_COM_VERBOSE;

    $sql = "SELECT {$selection} FROM {$table}";

    if (!empty($where)) {
        $sql .= " WHERE {$where}";
    }

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    if (!empty($selected)) {
        if ($_COM_VERBOSE) {
            COM_errorLog("exploding selected array: $selected in COM_checkList", 1);
        }

        $S = explode(' ', $selected);
    } else {
        if ($_COM_VERBOSE) {
            COM_errorLog('selected string was empty COM_checkList', 1);
        }

        $S = array();
    }

    $tcc = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'controls'));
    $tcc->set_file('checklist', 'checklist.thtml');
    $tcc->set_block('checklist', 'item'); 
    $tcc->set_block('checklist', 'item-default');
    
    for ($i = 0; $i < $numRows; $i++) {
        $access = true;
        
        $A = DB_fetchArray($result, true);

        if (($table == $_TABLES['topics']) && (SEC_hasTopicAccess($A['tid']) == 0)) {
            $access = false;
        }

        if (empty($fieldName)) {
            // Not a good idea, as that will expose our table name and prefix!
            // Make sure you pass a distinct field name!
            $fieldName = $table;
        }

        if ($access) {
            $tcc->set_var('name', $fieldName . '[]');
            $tcc->set_var('value', $A[0]);
            $tcc->set_var('label', stripslashes($A[1]));

            $sizeS = count($S);
            for ($x = 0; $x < $sizeS; $x++) {
                if ($A[0] == $S[$x]) {
                    $tcc->set_var('checked', true);
                    break;
                } else {
                    $tcc->set_var('checked', '');
                }
            }

            if (($table == $_TABLES['blocks']) && isset($A[2]) && ($A[2] === 'gldefault')) {
                $tcc->parse('items', 'item-default', true);
                
            } else {
                $tcc->parse('items', 'item', true);
            }
        }
    }
    $retval = $tcc->finish($tcc->parse('output', 'checklist'));

    return $retval;
}

/**
 * Prints out an associative array for debugging
 * The core of this code has been lifted from phpweblog which is licenced
 * under the GPL.  This is not used very much in the code but you can use it
 * if you see fit
 *
 * @param    array $array Array to loop through and print values for
 * @return   string  $retval    Formatted HTML List
 */

function COM_debug($array)
{
    $retval = '';
    if (!empty($array)) {
        $retval = '<ul><pre><p>---- DEBUG ----</p>';
        foreach ($array as $k => $v) {
            $retval .= sprintf("<li>%13s [%s]</li>\n", $k, $v);
        }
        $retval .= '<p>---------------</p></pre></ul>';
    }

    return $retval;
}

/**
 * Checks to see if RDF file needs updating and updates it if so.
 * Checks to see if we need to update the RDF as a result
 * of an article with a future publish date reaching it's
 * publish time and if so updates the RDF file.
 * NOTE: When called without parameters, this will only check for new entries to
 *       include in the feeds. Pass the $updated_XXX parameters when the content
 *       of an existing entry has changed.
 *
 * @param    string $updated_type  (optional) feed type to update
 * @param    string $updated_topic (optional) feed topic to update
 * @param    string $updated_id    (optional) feed id to update
 * @see file lib-syndication.php
 */
function COM_rdfUpToDateCheck($updated_type = '', $updated_topic = '', $updated_id = '')
{
    global $_CONF, $_TABLES;

    if ($_CONF['backend'] > 0) {
        if (!empty($updated_type)) {
            // when a plugin's feed is to be updated, skip Geeklog's own feeds
            $sql = "SELECT fid,type,topic,limits,update_info FROM {$_TABLES['syndication']} WHERE (is_enabled = 1) AND (type = '{$updated_type}')";
        } else {
            $sql = "SELECT fid,type,topic,limits,update_info FROM {$_TABLES['syndication']} WHERE is_enabled = 1";
        }
        $result = DB_query($sql);
        $num = DB_numRows($result);

        for ($i = 0; $i < $num; $i++) {
            $A = DB_fetchArray($result);

            if ($A['type'] === 'article') {
                $is_current = SYND_feedUpdateCheck($A['topic'],
                    $A['update_info'], $A['limits'],
                    $updated_topic, $updated_id);
            } else {
                $is_current = PLG_feedUpdateCheck($A['type'], $A['fid'],
                    $A['topic'], $A['update_info'], $A['limits'],
                    $updated_type, $updated_topic, $updated_id);
            }

            if (!$is_current) {
                SYND_updateFeed($A['fid']);
            }
        }
    }
}

/**
 * Checks and Updates the featured status of all articles.
 * Checks to see if any articles that were published for the future have been
 * published and, if so, will see if they are featured.  If they are featured,
 * this will set old featured article (if there is one) to normal
 */
function COM_featuredCheck()
{
    global $_TABLES;

    // Look for multiple featured frontpage articles. If more than one pick the newest.
    $sql = "SELECT sid FROM {$_TABLES['stories']} WHERE featured = 1 AND draft_flag = 0 AND frontpage = 1 AND date <= NOW() ORDER BY date DESC LIMIT 2";
    $resultB = DB_query($sql);
    $numB = DB_numRows($resultB);
    if ($numB > 1) {
        $B = DB_fetchArray($resultB);
        // un-feature all other featured frontpage story
        $sql = "UPDATE {$_TABLES['stories']} SET featured = 0 WHERE featured = 1 AND draft_flag = 0 AND frontpage = 1 AND date <= NOW() AND sid <> '{$B['sid']}'";
        DB_query($sql);
    }

    // Loop through each topic
    $sql = "SELECT tid FROM {$_TABLES['topics']}" . COM_getPermSQL();
    $result = DB_query($sql);
    $num = DB_numRows($result);
    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray($result);

        $sql = "SELECT s.sid FROM {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta WHERE s.featured = 1 AND s.draft_flag = 0 AND ta.tid = '{$A['tid']}' AND ta.type = 'article' AND s.date <= NOW() ORDER BY s.date DESC LIMIT 2";
        $resultB = DB_query($sql);
        $numB = DB_numRows($resultB);
        if ($numB > 1) {
            // OK, we have two or more featured stories in a topic, fix that
            $B = DB_fetchArray($resultB);
            $sql = array();
            $sql['mysql'] = "UPDATE {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta SET s.featured = 0 WHERE s.featured = 1 AND s.draft_flag = 0 AND ta.tid = '{$A['tid']}' AND ta.type = 'article' AND ta.id = s.sid AND s.date <= NOW() AND s.sid <> '{$B['sid']}'";
            $sql['pgsql'] = "UPDATE {$_TABLES['stories']} AS s SET featured = 0 FROM {$_TABLES['topic_assignments']} WHERE s.featured = 1 AND s.draft_flag = 0 AND {$_TABLES['topic_assignments']}.tid = '{$A['tid']}' AND {$_TABLES['topic_assignments']}.type = 'article' AND {$_TABLES['topic_assignments']}.id = s.sid AND s.date <= NOW() AND s.sid <> '{$B['sid']}'";
            DB_query($sql);
        }
    }
}

/**
 * Logs messages to error.log or the web page or both
 * Prints a well formatted message to either the web page, error log
 * or both.
 *
 * @param    string $logEntry Text to log to error log
 * @param    int    $actionId where 1 = write to log file, 2 = write to screen (default) both
 * @see      function COM_accessLog
 * @return   string  If $actionId = 2 or '' then HTML formatted string (wrapped in block) else nothing
 */
function COM_errorLog($logEntry, $actionId = '')
{
    global $_CONF, $LANG01;

    $retval = '';

    if (!empty($logEntry)) {
        $logEntry = str_replace(array('<?', '?>'), array('(@', '@)'), $logEntry);
        $timestamp = @strftime('%c');
        $remoteAddress = $_SERVER['REMOTE_ADDR'];

        if (!isset($_CONF['path_layout']) && (($actionId == 2) || empty($actionId))) {
            $actionId = 1;
        }
        if ((($actionId == 2) || empty($actionId)) && !class_exists('Template')) {
            $actionId = 1;
        }
        if (!isset($_CONF['path_log']) && ($actionId != 2)) {
            $actionId = 3;
        }

        // Only show call trace in developer mode (for log file only)
        $callTrace = "";
        if (COM_isEnableDeveloperModeLog('trace')) {
            // Generate an exception to trace the deprecated call
            $e = new Exception();
            $trace = $e->getTrace();

            $callTrace = LB . 'Call Trace: ' . LB;
            //position 0 would be the line that called this function so we ignore it
            for ($i = 1; $i < count($trace); ++$i) {
                // Skip showing COM_deprecatedLog calls
                if ($trace[$i]['function'] != 'COM_deprecatedLog') {
                    $callTrace .= "#$i " . print_r($trace[$i], true);
                }
            }
        }

        switch ($actionId) {
            case 1:
                $logfile = $_CONF['path_log'] . 'error.log';

                if (!$file = fopen($logfile, 'a')) {
                    $retval .= $LANG01[33] . ' ' . $logfile . ' (' . $timestamp . ')<br' . XHTML . '>' . LB;
                } else {
                    fputs($file, "$timestamp - $remoteAddress - $logEntry $callTrace \n");
                }
                break;

            case 2:
                $retval .= COM_startBlock($LANG01[55] . ' ' . $timestamp, '',
                        COM_getBlockTemplate('_msg_block', 'header'))
                    . COM_nl2br($logEntry)
                    . COM_endBlock(COM_getBlockTemplate('_msg_block',
                        'footer'));
                break;

            case 3:
                $retval = COM_nl2br($logEntry);
                break;

            default:
                $logfile = $_CONF['path_log'] . 'error.log';

                if (!$file = fopen($logfile, 'a')) {
                    $retval .= $LANG01[33] . ' ' . $logfile . ' (' . $timestamp . ')<br' . XHTML . '>' . LB;
                } else {
                    fputs($file, "$timestamp - $remoteAddress - $logEntry $callTrace \n");
                    $retval .= COM_startBlock($LANG01[34] . ' - ' . $timestamp,
                            '', COM_getBlockTemplate('_msg_block',
                                'header'))
                        . COM_nl2br($logEntry)
                        . COM_endBlock(COM_getBlockTemplate('_msg_block',
                            'footer'));
                }
                break;
        }
    }

    return $retval;
}

/**
 * Writes a deprecated warning message in Geeklog error log file (only in root debug mode)
 *
 * @param   string $deprecated_object  Name of depreciated function, class, etc..
 * @param   string $deprecated_version Version of Geeklog that object was depreciated in
 * @param   string $removed_version    Planned version of Geeklog object will be removed
 * @param   string $new_object         New object developer should be using instead
 * @since   since v2.1.2
 */
function COM_deprecatedLog($deprecated_object, $deprecated_version, $removed_version, $new_object = '')
{
    // Only show deprecated calls in developer mode
    if (COM_isEnableDeveloperModeLog('deprecated')) {
        $log_msg = sprintf(
            'Deprecated Warning - %1$s has been deprecated since Geeklog %2$s. This object will be removed in Geeklog %3$s.',
            $deprecated_object, $deprecated_version, $removed_version
        );

        if (!empty($new_object)) {
            $log_msg .= sprintf(' Use %1$s instead.', $new_object);
        }

        COM_errorLog($log_msg, 1);
    }
}

/**
 * Logs message to access.log
 * This will print a message to the Geeklog access log
 *
 * @param  string $logEntry Message to write to access log
 * @return string
 * @see    COM_errorLog
 */
function COM_accessLog($logEntry)
{
    global $_CONF, $_USER, $LANG01;

    if (empty($logEntry)) {
        return '';
    }

    if (Log::access($logEntry)) {
        return '';
    } else {
        return $LANG01[33] . 'access.log (' . Log::formatTimeStamp() . ')<br' . XHTML . '>' . PHP_EOL;
    }
}

/**
 * Shows all available topics
 * Show the topics in the system the user has access to and prints them in HTML.
 * This function is used to show the topics in the topics block.
 *
 * @param    string $topic ID of currently selected topic
 * @return   string        HTML formatted topic list
 */
function COM_showTopics($topic = '')
{
    global $_CONF, $_TABLES, $_TOPICS, $LANG01, $_BLOCK_TEMPLATE, $page;

    // See if topic block cache is there for specified topic (since topics can be hidden here depending on what topic is clicked)
    $cacheInstance = 'topicsblock__' . $topic . '__' . CACHE_security_hash() . '__' . $_CONF['theme'];
    $retval = CACHE_check_instance($cacheInstance); // Language and theme specific
    if ($retval) {
        return $retval;
    }

    $topicNavigation = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
    if (isset($_BLOCK_TEMPLATE['topicnavigation'])) {
        $topicNavigation->set_file('topicnavigation', $_BLOCK_TEMPLATE['topicnavigation']);
    } else {
        $topicNavigation->set_file('topicnavigation', 'topicnavigation.thtml');
    }
    $blocks = array('option', 'option-with-hidden', 'option-off');
    foreach ($blocks as $block) {
        $topicNavigation->set_block('topicnavigation', $block);
    }

    $topicNavigation->set_var('block_name', str_replace('_', '-', 'section_block'));

    // Allow anything not in the blocks but in the rest of the template file to be displayed
    $retval .= $topicNavigation->parse('item', 'topicnavigation', true);

    if ($_CONF['hide_home_link'] == 0) {
        // Give a link to the homepage here since a lot of people use this for
        // navigating the site

        $start_branch = 1; // Sets indentation level for topics

        if (COM_onFrontpage()) {
            $topicNavigation->set_var('option_url', '');
            $topicNavigation->set_var('option_label', $LANG01[90]);
            $topicNavigation->set_var('option_count', '');
            $topicNavigation->set_var('option_attributes', '');
            $topicNavigation->set_var('topic_image', '');
            $retval .= $topicNavigation->parse('item', 'option-off');
        } else {
            $topicNavigation->set_var('option_url', $_CONF['site_url'] . '/');
            $topicNavigation->set_var('option_label', $LANG01[90]);
            $topicNavigation->set_var('option_count', '');
            $topicNavigation->set_var('option_attributes', ' rel="home"');
            $topicNavigation->set_var('topic_image', '');
            $retval .= $topicNavigation->parse('item', 'option');
        }
    } else {
        $start_branch = 2;
    }

    if ($_CONF['showsubmissioncount']) {
        $sql = "SELECT tid, COUNT(*) AS count FROM {$_TABLES['storysubmission']}, {$_TABLES['topic_assignments']} ta "
            . "WHERE ta.type = 'article' AND ta.id = sid "
            . ' GROUP BY ta.tid';
        $rcount = DB_query($sql);
        while ($C = DB_fetchArray($rcount)) {
            $submissioncount[$C['tid']] = $C['count'];
        }
    }

    $start_topic = 2; // Do not display Root
    $total_topic = count($_TOPICS);
    $branch_level_skip = 0;
    $lang_id = COM_getLanguageId();

    for ($count_topic = $start_topic; $count_topic <= $total_topic; $count_topic++) {
        $topic_in_path = TOPIC_inPath($_TOPICS[$count_topic]['id']);

        // Check if branch needs to be hidden due to a parent being hidden or a different language
        if ($branch_level_skip >= $_TOPICS[$count_topic]['branch_level']) {
            $branch_level_skip = 0;
        }

        if ($branch_level_skip == 0) {
            // Make sure to show topics for proper language only (and all languages)
            if (($_TOPICS[$count_topic]['exclude'] == 0) && ($_TOPICS[$count_topic]['access'] > 0) &&
                (($lang_id == '') || (($lang_id != '') && (($_TOPICS[$count_topic]['language_id'] == $lang_id) || ($_TOPICS[$count_topic]['language_id'] == ''))))
            ) {
                $continue = false;
                if ($_TOPICS[$count_topic]['parent_id'] == $topic) {
                    // Make sure to list any hidden child topics else skip
                    $continue = true;
                } elseif ($topic_in_path) {
                    // Figure out if we are on the current topic breadcrumb and if so show all even if hidden
                    $continue = true;
                } else {
                    // Normal check see if hidden, if not then continue
                    if (!$_TOPICS[$count_topic]['hidden']) {
                        $continue = true;
                    }
                }

                if ($continue) {
                    $branch_spaces = "";
                    $level = 1;
                    for ($branch_count = $start_branch; $branch_count <= $_TOPICS[$count_topic]['branch_level']; $branch_count++) {
                        $branch_spaces .= "&nbsp;&nbsp;&nbsp;";
                        $level++;
                    }
                    $topicNavigation->set_var('branch_spaces', $branch_spaces);
                    $topicNavigation->set_var('branch_level', $level);

                    $topicNavigation->set_var(
                        'option_url',
                        TOPIC_getUrl($_TOPICS[$count_topic]['id'])
                    );
                    $topicName = stripslashes($_TOPICS[$count_topic]['title']);
                    $topicNavigation->set_var('option_label', $topicName);

                    $countString = '';
                    if ($_CONF['showstorycount'] || $_CONF['showsubmissioncount']) {
                        $countString .= '(';

                        // Retrieve list of inherited topics
                        $tid_list = TOPIC_getChildList($_TOPICS[$count_topic]['id']);

                        if ($_CONF['showstorycount']) {
                            // Calculate number of stories in topic, includes any inherited ones
                            $sql = "SELECT sid FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta "
                                . 'WHERE (draft_flag = 0) AND (date <= NOW()) '
                                . COM_getPermSQL('AND')
                                . "AND ta.type = 'article' AND ta.id = sid " . COM_getLangSQL('sid', 'AND')
                                . "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$_TOPICS[$count_topic]['id']}'))) "
                                . ' GROUP BY sid';

                            $resultD = DB_query($sql);
                            $numRows = DB_numRows($resultD);
                            $countString .= COM_numberFormat($numRows);
                        }

                        if ($_CONF['showsubmissioncount']) {
                            if ($_CONF['showstorycount']) {
                                $countString .= '/';
                            }
                            // Calculate number of story submissions in topic, includes any inherited ones
                            $sql = "SELECT sid FROM {$_TABLES['storysubmission']}, {$_TABLES['topic_assignments']} ta "
                                . "WHERE ta.type = 'article' AND ta.id = sid "
                                . "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$_TOPICS[$count_topic]['id']}'))) "
                                . ' GROUP BY sid';

                            $resultD = DB_query($sql);
                            $numRows = DB_numRows($resultD);
                            $countString .= COM_numberFormat($numRows);
                        }

                        $countString .= ')';
                    }
                    $topicNavigation->set_var('option_count', $countString);
                    $topicNavigation->set_var('option_attributes', '');

                    $sql = "SELECT imageurl, meta_description FROM {$_TABLES['topics']} WHERE tid = '{$_TOPICS[$count_topic]['id']}'";
                    $result = DB_query($sql);
                    $A = DB_fetchArray($result);

                    $topicImage = '';
                    if (!empty($A['imageurl'])) {
                        $imageUrl = COM_getTopicImageUrl($A['imageurl']);
                        $topicImage = '<img src="' . $imageUrl . '" alt="' . $topicName
                            . '" title="' . $topicName . '"' . XHTML . '>';
                    }
                    $topicNavigation->set_var('topic_image', $topicImage);

                    $desc = trim($A['meta_description']);
                    $topicNavigation->set_var('topic_description', $desc);
                    $desc_escaped = htmlspecialchars($desc);
                    $topicNavigation->set_var('topic_description_escaped', $desc_escaped);
                    if (!empty($desc)) {
                        $topicNavigation->set_var('topic_title_attribute',
                            'title="' . $desc_escaped . '"');
                    } else {
                        $topicNavigation->set_var('topic_title_attribute', '');
                    }

                    if (($_TOPICS[$count_topic]['id'] == $topic) && ($page == 1)) {
                        $retval .= $topicNavigation->parse('item', 'option-off');
                    } else {
                        // See if we need to display hidden child topic sign
                        $sql = "SELECT tid FROM {$_TABLES['topics']}
                                WHERE parent_id = '{$_TOPICS[$count_topic]['id']}' AND hidden = 1" . COM_getPermSQL('AND', 0, 2);
                        $result = DB_query($sql);
                        $numRows = DB_numRows($result);
                        $A = DB_fetchArray($result);
                        if (($topic_in_path && ($numRows > 1)) || (!$topic_in_path && ($numRows > 0)) ||
                            ($topic_in_path && ($numRows == 1) && !TOPIC_inPath($A['tid']))
                        ) {
                            $retval .= $topicNavigation->parse('item', 'option-with-hidden');
                        } else {
                            $retval .= $topicNavigation->parse('item', 'option');
                        }
                    }
                } else {
                    // Hidden, so flag this to skip if we have children
                    $branch_level_skip = $_TOPICS[$count_topic]['branch_level'];
                }
            } else {
                // Different language or hidden, so flag this to skip if we have children
                $branch_level_skip = $_TOPICS[$count_topic]['branch_level'];
            }
        }
    }

    // Create cache so don't need to recreate unless change
    CACHE_create_instance($cacheInstance, $retval);

    return $retval;
}

/**
 * Shows the user their menu options
 * This shows the average Joe User their menu options. This is the user block on the left side
 *
 * @param  string $help       Help file to show
 * @param  string $title      Title of Menu
 * @param  string $position   Side being shown on 'left', 'right'. Though blank works not likely.
 * @param  string $cssId      CSS ID (since GL 2.2.0, optional)
 * @param  string $cssClasses CSS class names separated by space (since GL 2.2.0, optional)
 * @return string
 * @see     function COM_adminMenu
 */
function COM_userMenu($help = '', $title = '', $position = '', $cssId = '', $cssClasses = '')
{
    global $_TABLES, $_CONF, $LANG01, $LANG04, $_BLOCK_TEMPLATE, $_SCRIPTS;

    $retval = '';

    if (!COM_isAnonUser()) {
        $userMenu = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
        if (isset($_BLOCK_TEMPLATE['usernavigation'])) {
            $userMenu->set_file('usernavigation', $_BLOCK_TEMPLATE['usernavigation']);
        } else {
            $userMenu->set_file('usernavigation', 'usernavigation.thtml');
        }
        $blocks = array('option', 'current');
        foreach ($blocks as $block) {
            $userMenu->set_block('usernavigation', $block);
        }

        $userMenu->set_var('block_name', str_replace('_', '-', 'user_block'));

        if (empty($title)) {
            $title = DB_getItem($_TABLES['blocks'], 'title', "name='user_block'");
        }

        // what's our current URL?
        $thisUrl = COM_getCurrentURL();

        $retval .= COM_startBlock(
            $title, $help,
            COM_getBlockTemplate('user_block', 'header', $position),
            $cssId, $cssClasses
        );

        // Allow anything not in the blocks but in the rest of the template file to be displayed
        $retval .= $userMenu->parse('item', 'usernavigation', true);

        // This function will show the user options for all installed plugins
        // (if any)

        $plugin_options = PLG_getUserOptions();
        $numRows = count($plugin_options);

        for ($i = 0; $i < $numRows; $i++) {
            $plg = current($plugin_options);
            $userMenu->set_var('option_label', $plg->adminlabel);

            if (!empty($plg->numsubmissions)) {
                $userMenu->set_var('option_count', '(' . $plg->numsubmissions . ')');
            } else {
                $userMenu->set_var('option_count', '');
            }

            $userMenu->set_var('option_url', $plg->adminurl);
            if ($thisUrl == $plg->adminurl) {
                $retval .= $userMenu->parse('item', 'current');
            } else {
                $retval .= $userMenu->parse('item', 'option');
            }

            next($plugin_options);
        }

        $url = $_CONF['site_url'] . '/usersettings.php';
        $userMenu->set_var('option_label', $LANG01[48]);
        $userMenu->set_var('option_count', '');
        $userMenu->set_var('option_url', $url);
        if ($thisUrl == $url) {
            $retval .= $userMenu->parse('item', 'current');
        } else {
            $retval .= $userMenu->parse('item', 'option');
        }

        $url = $_CONF['site_url'] . '/users.php?mode=logout';
        $userMenu->set_var('option_label', $LANG01[19]);
        $userMenu->set_var('option_count', '');
        $userMenu->set_var('option_url', $url);
        $retval .= $userMenu->finish($userMenu->parse('item', 'option'));
        $retval .= COM_endBlock(COM_getBlockTemplate('user_block', 'footer', $position));
    } else {
        $retval .= COM_startBlock(
            $LANG01[47], $help,
            COM_getBlockTemplate('user_block', 'header', $position),
            $cssId, $cssClasses
        );
        $login = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
        $login->set_file('form', 'loginform.thtml');
        $login->set_var('lang_username', $LANG01[21]);
        $login->set_var('lang_password', $LANG01[57]);
        $login->set_var('lang_forgetpassword', $LANG01[119]);
        $login->set_var('lang_login', $LANG01[58]);
        $login->set_var('lang_loginform', $LANG01['loginform']);
        $login->set_var('lang_remoteloginoptions', $LANG01['remoteloginoptions']);
        
        if ($_CONF['disable_new_user_registration']) {
            $login->set_var('lang_signup', '');
        } else {
            $login->set_var('lang_signup', $LANG01[59]);
        }

        // 3rd party remote authentication.
        if ($_CONF['user_login_method']['3rdparty'] && !$_CONF['usersubmission']) {
            $modules = SEC_collectRemoteAuthenticationModules();
            if (count($modules) === 0) {
                $login->set_var('services', '');
            } else {
                if (!$_CONF['user_login_method']['standard'] &&
                    (count($modules) == 1)
                ) {
                    $select = '<input type="hidden" name="service" value="'
                        . $modules[0] . '"' . XHTML . '>' . $modules[0];
                } else {
                    // Build select
                    $select = '';
                    if ($_CONF['user_login_method']['standard']) {
                        $select .= '<option value="">' . $_CONF['site_name']
                            . '</option>';
                    }
                    foreach ($modules as $service) {
                        $select .= '<option value="' . $service . '">'
                            . $service . '</option>';
                    }
                    $select = COM_createControl('type-select', array(
                        'name' => 'service',
                        'id' => 'service',
                        'select_items' => $select
                    ));
                }

                $login->set_file('services', 'blockservices.thtml');
                $login->set_var('lang_service', $LANG04[121]);
                $login->set_var('select_service', $select);
                $login->parse('output', 'services');
                $login->set_var('services',
                    $login->finish($login->get_var('output')));
            }
        } else {
            $login->set_var('services', '');
        }

        // OpenID remote authentication
        if ($_CONF['user_login_method']['openid'] && ($_CONF['usersubmission'] == 0) && !$_CONF['disable_new_user_registration']) {
            $_SCRIPTS->setJavaScriptFile('login', '/javascript/login.js');
            $login->set_file('openid_login', 'loginform_openid.thtml');
            $login->set_var('lang_openid_login', $LANG01[128]);
            $login->set_var('input_field_size', 18);
            $login->set_var('app_url', $_CONF['site_url'] . '/users.php');
            $login->parse('output', 'openid_login');
            $login->set_var(
                'openid_login',
                $login->finish($login->get_var('output'))
            );
        } else {
            $login->set_var('openid_login', '');
        }

        // OAuth remote authentication.
        if ($_CONF['user_login_method']['oauth'] && ($_CONF['usersubmission'] == 0) && !$_CONF['disable_new_user_registration']) {
            $_SCRIPTS->setJavaScriptFile('login', '/javascript/login.js');
            $modules = SEC_collectRemoteOAuthModules();
            if (count($modules) === 0) {
                $login->set_var('oauth_login', '');
            } else {
                $html_oauth = '';
                // Grab oauth icons from theme
                if (isset($_CONF['theme_oauth_icons']) && $_CONF['theme_oauth_icons']) {
                    $icon_path = $_CONF['layout_url'] . '/images/';
                } else {
                    $icon_path = $_CONF['site_url'] . '/images/';
                }
                // UIkit icon font names
                $icon_font_names = array(
                    'facebook'  => 'facebook',
                    'google'    => 'google',
                    'twitter'   => 'twitter',
                    'microsoft' => 'windows',
                    'linkedin'  => 'linkedin',
                    'yahoo'     => 'yahoo',
                    'github'    => 'github',
                );
                foreach ($modules as $service) {
                    $login->set_file('oauth_login', 'loginform_oauth.thtml');
                    $login->set_var('oauth_service', $service);
                    $login->set_var('lang_oauth_service', $LANG01[$service]);
                    // for sign in image
                    $login->set_var('oauth_sign_in_image', $icon_path . $service . '-login-icon.png'); // For use with oauth icon on regular buttons
                    $login->set_var('oauth_icon_font_name', $icon_font_names[$service]);
                    $login->parse('output', 'oauth_login');
                    $html_oauth .= $login->finish($login->get_var('output'));
                }
                $login->set_var('oauth_login', $html_oauth);
            }
        } else {
            $login->set_var('oauth_login', '');
        }

        PLG_templateSetVars('loginblock', $login); 
        PLG_templateSetVars('loginform', $login); // Need to set loginform as well since this is what Geeklog checks when logging in users. This will allow things like recaptcha work
        $retval .= $login->finish($login->parse('output', 'form'));
        $retval .= COM_endBlock(COM_getBlockTemplate('user_block', 'footer', $position));
    }

    return $retval;
}

/**
 * Prints Command and Control Page or Administration Menu Block
 * This will return the command and control items or administration menu items that
 * the user has sufficient rights to -- Admin Block on the left side.
 *
 * @param  bool   $isAdminMenu True if admin menu, false if command and control page
 * @param  string $help        Help file to show (admin menu only)
 * @param  string $title       Menu Title (admin menu only)
 * @param  string $position    Side being shown on 'left', 'right' or blank. (admin menu only)
 * @param  string $cssId       CSS ID (since GL 2.2.0, optional)
 * @param  string $cssClasses  CSS class names separated by space (since GL 2.2.0, optional)
 * @return string
 * @see     function COM_adminMenu
 */
function COM_commandControl($isAdminMenu = false, $help = '', $title = '', $position = '', $cssId = '', $cssClasses = '')
{
    global $_CONF, $_CONF_FT, $_TABLES, $_BLOCK_TEMPLATE, $LANG01, $LANG29, $LANG_LOGVIEW,
           $LANG_ENVCHECK, $LANG_ADMIN, $LANG_LANG, $_IMAGE_TYPE, $LANG_ROUTER, $_DB_dbms, $config;

    $retval = '';

    if ($isAdminMenu) {
        // what's our current URL?
        $thisUrl = COM_getCurrentURL();

        // Figure out topics sql since used in a few places
        $topicSql = '';
        if (SEC_isModerator() || SEC_hasRights('story.edit')) {
            $tResult = DB_query("SELECT tid FROM {$_TABLES['topics']}" . COM_getPermSQL());
            $trows = DB_numRows($tResult);
            if ($trows > 0) {
                $tids = array();
                for ($i = 0; $i < $trows; $i++) {
                    $T = DB_fetchArray($tResult);
                    $tids[] = $T['tid'];
                }
                if (count($tids) > 0) {
                    $topicSql = " AND (ta.tid IN ('" . implode("','", $tids) . "'))";
                }
            }
        }

        // Template Stuff
        $adminMenu = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
        if (isset($_BLOCK_TEMPLATE['adminnavigation'])) {
            $adminMenu->set_file('adminnavigation', $_BLOCK_TEMPLATE['adminnavigation']);
        } else {
            $adminMenu->set_file('adminnavigation', 'adminnavigation.thtml');
        }
        $blocks = array('option', 'current', 'group', 'count');
        foreach ($blocks as $block) {
            $adminMenu->set_block('adminnavigation', $block);
        }

        $adminMenu->set_var('block_name', str_replace('_', '-', 'admin_block'));

        if (empty($title)) {
            $title = DB_getItem($_TABLES['blocks'], 'title', "name = 'admin_block'");
        }

        $retval .= COM_startBlock(
            $title, $help,
            COM_getBlockTemplate('admin_block', 'header', $position),
            $cssId, $cssClasses
        );

        // Allow anything not in the blocks but in the rest of the template file to be displayed
        $retval .= $adminMenu->parse('item', 'adminnavigation', true);

        // Add Command and Control Link
        $url = $_CONF['site_admin_url'] . '/index.php';
        $adminMenu->set_var('option_url', $url);
        $adminMenu->set_var('option_label', $LANG01[14]);
        $adminMenu->set_var('option_count', $LANG_ADMIN['na']);
        $retval .= $adminMenu->finish($adminMenu->parse('item',
            ($thisUrl == $url) ? 'current' : 'option'));

        // Get any plugin items
        $plugins = PLG_getAdminOptions();
    } else {
        // this defines the amount of icons displayed next to another in the CC-block
        define('ICONS_PER_ROW', 6);

        // Template Stuff
        $admin_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin'));
        $admin_templates->set_file(array('cc' => 'commandcontrol.thtml'));
        $blocks = array('ccgroup', 'ccrow', 'ccitem');
        foreach ($blocks as $block) {
            $admin_templates->set_block('cc', $block);
        }

        $retval .= COM_startBlock(
            'Geeklog ' . VERSION . ' -- ' . $LANG29[34], '',
            COM_getBlockTemplate('_admin_block', 'header'),
            $cssId, $cssClasses
        );

        // Get any plugin items
        $plugins = PLG_getCCOptions();
    }

    $cc_core = array();
    $cc_plugins = array();
    $cc_tools = array();
    $cc_users = array();
    for ($i = 0; $i < count($plugins); $i++) {
        $cur_plugin = current($plugins);

        if ($isAdminMenu) {
            $item = array(
                'condition' => SEC_hasRights('story.edit'),
                'url'       => $cur_plugin->adminurl,
                'lang'      => $cur_plugin->adminlabel,
                'num'       => $cur_plugin->numsubmissions,
            );
        } else {
            $item = array(
                'condition' => SEC_hasRights('story.edit'),
                'url'       => $cur_plugin->adminurl,
                'lang'      => $cur_plugin->adminlabel,
                'image'     => $cur_plugin->plugin_image,
            );
        }

        switch ($cur_plugin->admingroup) {
            case 'core':
                $cc_core[] = $item;
                break;

            case 'tools':
                $cc_tools[] = $item;
                break;

            case 'users':
                $cc_users[] = $item;
                break;

            default:
                $cc_plugins[] = $item;
                break;
        }
        next($plugins);
    }

    // Command & Control Group Layout
    $ccGroups = array('core', 'plugins', 'tools', 'users');
    foreach ($ccGroups as $ccGroup) {
        // Clear a few things before starting group
        $cc_arr = array();
        $items = array();
        if (!$isAdminMenu) {
            $admin_templates->clear_var('cc_rows');
            $admin_templates->set_var('cc_icon_width', floor(100 / ICONS_PER_ROW));
        }

        switch ($ccGroup) {
            // Core - Blocks, Content Syndication, Stories, Topics, Submissions, Trackbacks
            case 'core':
                $showTrackBackIcon = (($_CONF['trackback_enabled'] ||
                        $_CONF['pingback_enabled'] || $_CONF['ping_enabled'])
                    && SEC_hasRights('story.ping'));

                // Count stuff for admin menu
                $blockCount = 0;
                $topicCount = 0;
                $storyCount = 0;
                $submissionCount = 0;
                $syndicationCount = 0;
                $commentCount = 0;
                $trackBackCount = $LANG_ADMIN['na'];

                if ($isAdminMenu) {
                    // Find num of blocks
                    $result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['blocks']}" . COM_getPermSQL());
                    list($blockCount) = DB_fetchArray($result);
                    // Find num of topics
                    $result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['topics']}" . COM_getPermSQL());
                    list($topicCount) = DB_fetchArray($result);
                    // Find num of stories
                    if (SEC_hasRights('story.edit')) {
                        if (empty($topicSql)) {
                            $storyCount = DB_count($_TABLES['stories']);
                        } else {
                            $nResult = DB_query("SELECT COUNT(DISTINCT sid) AS count FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'article' AND ta.id = sid " . $topicSql . COM_getPermSQL('AND'));
                            $N = DB_fetchArray($nResult);
                            $storyCount = $N['count'];
                        }
                    }
                    // Find num of submissions
                    if (SEC_hasRights('story.edit,story.moderate', 'OR') ||
                        (($_CONF['commentsubmission'] == 1) &&
                            SEC_hasRights('comment.moderate')) ||
                        (($_CONF['usersubmission'] == 1) &&
                            SEC_hasRights('user.edit,user.delete'))
                    ) {
                        if (SEC_hasRights('story.moderate')) {
                            if (empty($topicSql)) {
                                $submissionCount += DB_count($_TABLES['storysubmission']);
                            } else {
                                $sql = "SELECT COUNT(DISTINCT sid) AS count FROM {$_TABLES['storysubmission']}, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'article' AND ta.id = sid " . $topicSql;
                                $sresult = DB_query($sql);
                                $S = DB_fetchArray($sresult);
                                $submissionCount += $S['count'];
                            }
                        }

                        if (($_CONF['listdraftstories'] == 1) && SEC_hasRights('story.edit')) {
                            $sql = "SELECT COUNT(DISTINCT sid) AS count FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'article' AND ta.id = sid AND draft_flag = 1";
                            if (!empty($topicSql)) {
                                $sql .= $topicSql;
                            }
                            $result = DB_query($sql . COM_getPermSQL('AND', 0, 3));
                            $A = DB_fetchArray($result);
                            $submissionCount += $A['count'];
                        }

                        if (($_CONF['commentsubmission'] == 1) && SEC_hasRights('comment.moderate')) {
                            $submissionCount += DB_count($_TABLES['commentsubmissions']);
                        }

                        if ($_CONF['usersubmission'] == 1) {
                            if (SEC_hasRights('user.edit') && SEC_hasRights('user.delete')) {
                                $submissionCount += DB_count($_TABLES['users'], 'status', '2');
                            }
                        }
                    }
                    // now handle submissions for plugins
                    $submissionCount += PLG_getSubmissionCount();
                    // Find num of syndication
                    if (($_CONF['backend'] == 1) && SEC_hasRights('syndication.edit')) {
                        $syndicationCount = COM_numberFormat(DB_count($_TABLES['syndication']));
                    }
                    // Find num of trackback
                    if ($_CONF['ping_enabled'] && SEC_hasRights('story.ping')) {
                        $trackBackCount = COM_numberFormat(DB_count($_TABLES['pingservice']));
                    }

                    // Find num of comments
                    $commentCount = COM_numberFormat(DB_count($_TABLES['comments']))
                        . '/'
                        . COM_numberFormat(DB_count($_TABLES['commentsubmissions']));
                }

                $cc_arr = array(
                    array(
                        'condition' => SEC_hasRights('topic.edit'),
                        'url'       => $_CONF['site_admin_url'] . '/topic.php',
                        'lang'      => $LANG01[13],
                        'num'       => COM_numberFormat($topicCount),
                        'image'     => $_CONF['layout_url'] . '/images/icons/topic.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_hasRights('block.edit'),
                        'url'       => $_CONF['site_admin_url'] . '/block.php',
                        'lang'      => $LANG01[12],
                        'num'       => COM_numberFormat($blockCount),
                        'image'     => $_CONF['layout_url'] . '/images/icons/block.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_hasRights('story.edit'),
                        'url'       => $_CONF['site_admin_url'] . '/article.php',
                        'lang'      => $LANG01[11],
                        'num'       => COM_numberFormat($storyCount),
                        'image'     => $_CONF['layout_url'] . '/images/icons/story.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_hasModerationAccess(),
                        'url'       => $_CONF['site_admin_url'] . '/moderation.php',
                        'lang'      => $LANG01[10],
                        'num'       => COM_numberFormat($submissionCount),
                        'image'     => $_CONF['layout_url'] . '/images/icons/moderation.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_hasRights('syndication.edit'),
                        'url'       => $_CONF['site_admin_url'] . '/syndication.php',
                        'lang'      => $LANG01[38],
                        'num'       => $syndicationCount,
                        'image'     => $_CONF['layout_url'] . '/images/icons/syndication.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => $showTrackBackIcon,
                        'url'       => $_CONF['site_admin_url'] . '/trackback.php',
                        'lang'      => $LANG01[116],
                        'num'       => $trackBackCount,
                        'image'     => $_CONF['layout_url'] . '/images/icons/trackback.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_hasRights('comment.moderate'),
                        'url'       => $_CONF['site_admin_url'] . '/comment.php',
                        'lang'      => $LANG01[83],
                        'num'       => $commentCount,
                        'image'     => $_CONF['layout_url'] . '/images/icons/comment.' . $_IMAGE_TYPE,
                    ),
                );

                // Merge any items that belong to this group from plugins
                $cc_arr = array_merge($cc_arr, $cc_core);
                break;

            // Plugins - All ungrouped plugins
            case 'plugins':
                $cc_arr = $cc_plugins;
                break;

            // Tools - Db backups, Clear cache, Log Viewer, GL Version Test, Plugins, Configuration, Documentation, SPAM-X Plugin
            case 'tools':
                $docsUrl = $_CONF['site_url'] . '/docs/english/index.html';
                if ($_CONF['link_documentation'] == 1) {
                    $docLang = COM_getLanguageName();
                    $docs = 'docs/' . $docLang . '/index.html';
                    if (file_exists($_CONF['path_html'] . $docs)) {
                        $docsUrl = $_CONF['site_url'] . '/' . $docs;
                    }
                }

                $pluginsCount = 0;
                if ($isAdminMenu) {
                    // Find num of plugins
                    if (SEC_hasRights('plugin.edit')) {
                        $pluginsCount = COM_numberFormat(DB_count($_TABLES['plugins'], 'pi_enabled', 1));
                    }
                }

                $routeCount = '0';
                if ($isAdminMenu && SEC_inGroup('Root')) {
                    // Find num of URL routes
                    $sql = "SELECT COUNT(rid) AS cnt FROM {$_TABLES['routes']}";
                    $result = DB_query($sql);

                    if (!DB_error()) {
                        $temp = DB_fetchArray($result, false);
                        $routeCount = COM_numberFormat($temp['cnt']);
                    }
                }

                $cc_arr = array(
                    array(
                        'condition' => SEC_hasRights($_CONF_FT, 'OR'),
                        'url'       => $_CONF['site_admin_url'] . '/configuration.php',
                        'lang'      => $LANG01[129],
                        'num'       => count($config->_get_groups()),
                        'image'     => $_CONF['layout_url'] . '/images/icons/configuration.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => ($_CONF['link_documentation'] == 1),
                        'url'       => $docsUrl,
                        'lang'      => $LANG01[113], 'image' => $_CONF['layout_url'] . '/images/icons/docs.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => (SEC_inGroup('Root') && ($_CONF['link_versionchecker'] == 1)),
                        'url'       => 'https://www.geeklog.net/versionchecker.php?version=' . VERSION,
                        'lang'      => $LANG01[107],
                        'num'       => VERSION,
                        'image'     => $_CONF['layout_url'] . '/images/icons/versioncheck.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_hasRights('plugin.edit'),
                        'url'       => $_CONF['site_admin_url'] . '/plugins.php',
                        'lang'      => $LANG01[98],
                        'num'       => $pluginsCount,
                        'image'     => $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => ($_DB_dbms === 'mysql') && SEC_inGroup('Root'),
                        'url'       => $_CONF['site_admin_url'] . '/database.php',
                        'lang'      => $LANG01[103],
                        'num'       => '',
                        'image'     => $_CONF['layout_url'] . '/images/icons/database.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_inGroup('Root'),
                        'url'       => $_CONF['site_admin_url'] . '/router.php',
                        'lang'      => $LANG_ROUTER[1],
                        'num'       => $routeCount,
                        'image'     => $_CONF['layout_url'] . '/images/icons/router.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_inGroup('Root') || SEC_inGroup('Theme Admin'),
                        'url'       => $_CONF['site_admin_url'] . '/clearctl.php',
                        'lang'      => $LANG01['ctl'],
                        'num'       => '',
                        'image'     => $_CONF['layout_url'] . '/images/icons/ctl.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_inGroup('Root'),
                        'url'       => $_CONF['site_admin_url'] . '/envcheck.php',
                        'lang'      => $LANG_ENVCHECK['env_check'],
                        'num'       => '',
                        'image'     => $_CONF['layout_url'] . '/images/icons/envcheck.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_inGroup('Root'),
                        'url'       => $_CONF['site_admin_url'] . '/logviewer.php',
                        'lang'      => $LANG_LOGVIEW['log_viewer'],
                        'num'       => '',
                        'image'     => $_CONF['layout_url'] . '/images/icons/log_viewer.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_inGroup('Root'),
                        'url'       => $_CONF['site_url'] . '/filemanager/index.php?Type=Root',
                        'lang'      => $LANG01['filemanager'],
                        'num'       => '',
                        'image'     => $_CONF['layout_url'] . '/images/icons/filemanager.' . $_IMAGE_TYPE,
                        'target'    => '_blank',
                    ),
                    array(
                        'condition' => SEC_hasRights('language.edit'),
                        'url'       => $_CONF['site_admin_url'] . '/language.php',
                        'lang'      => $LANG_LANG['language_admin_title'],
                        'num'       => '',
                        'image'     => $_CONF['layout_url'] . '/images/icons/language.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => true,
                        'url'       => $_CONF['site_url'] . '/users.php?mode=logout',
                        'lang'      => $LANG01[35],
                        'num'       => '',
                        'image'     => $_CONF['layout_url'] . '/images/icons/logout.' . $_IMAGE_TYPE,
                    ),
                );

                // Merge any items that belong to this group from plugins
                $cc_arr = array_merge($cc_arr, $cc_tools);
                break;

            // Users - Groups, Users, Mail Users
            case 'users':
                $groupCount = 0;
                $userCount = 0;
                if ($isAdminMenu) {
                    // Find num of groups
                    if (SEC_inGroup('Root')) {
                        $grpFilter = '';
                    } else {
                        $thisUsersGroups = SEC_getUserGroups();
                        $grpFilter = 'WHERE (grp_id IN (' . implode(',', $thisUsersGroups) . '))';
                    }
                    $result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['groups']} $grpFilter;");
                    $A = DB_fetchArray($result);
                    $groupCount = $A['count'];
                    // Find num of users
                    $userCount = (DB_count($_TABLES['users'], 'status', USER_ACCOUNT_ACTIVE) - 1);
                }

                $cc_arr = array(
                    array(
                        'condition' => SEC_hasRights('group.edit'),
                        'url'       => $_CONF['site_admin_url'] . '/group.php',
                        'lang'      => $LANG01[96],
                        'num'       => COM_numberFormat($groupCount),
                        'image'     => $_CONF['layout_url'] . '/images/icons/group.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_hasRights('user.edit'),
                        'url'       => $_CONF['site_admin_url'] . '/user.php',
                        'lang'      => $LANG01[17],
                        'num'       => COM_numberFormat($userCount),
                        'image'     => $_CONF['layout_url'] . '/images/icons/user.' . $_IMAGE_TYPE,
                    ),
                    array(
                        'condition' => SEC_hasRights('user.mail'),
                        'url'       => $_CONF['site_admin_url'] . '/mail.php',
                        'lang'      => $LANG01[105],
                        'num'       => '',
                        'image'     => $_CONF['layout_url'] . '/images/icons/mail.' . $_IMAGE_TYPE,
                    ),
                );
                // Merge any items that belong to this group from plugins
                $cc_arr = array_merge($cc_arr, $cc_users);

                break;
        }

        for ($i = 0; $i < count($cc_arr); $i++) {
            if ($cc_arr[$i]['condition']) {
                if ($isAdminMenu) {
                    // Add Command and Control Link
                    $adminMenu->set_var('option_url', $cc_arr[$i]['url']);
                    $adminMenu->set_var('option_label', $cc_arr[$i]['lang']);
                    if (!empty($cc_arr[$i]['num'])) {
                        $adminMenu->set_var('option_count', $cc_arr[$i]['num']);
                        $adminMenu->set_var('display_count', $adminMenu->parse('item', 'count'));
                    }
                    $adminMenu->set_var('branch_spaces', '&nbsp;&nbsp;&nbsp;');

                    if (isset($cc_arr[$i]['target'])) {
                        $adminMenu->set_var('target', ' target="' . $cc_arr[$i]['target'] . '"');
                    } else {
                        $adminMenu->set_var('target', '');
                    }

                    $item = $adminMenu->finish($adminMenu->parse('item',
                        ($thisUrl == $cc_arr[$i]['url']) ? 'current' : 'option'));

                    $adminMenu->clear_var('display_count'); // incase set before
                } else {
                    if (!empty($cc_arr[$i]['url'])) {
                        $admin_templates->set_var('page_url', $cc_arr[$i]['url']);
                        $admin_templates->set_var('page_image', $cc_arr[$i]['image']);
                        $admin_templates->set_var('option_label', $cc_arr[$i]['lang']);
                        $admin_templates->set_var('cell_width', ((int) (100 / ICONS_PER_ROW)) . '%');

                        if (isset($cc_arr[$i]['target'])) {
                            $admin_templates->set_var('target', ' target="' . $cc_arr[$i]['target'] . '"');
                        } else {
                            $admin_templates->set_var('target', '');
                        }

                        $item = $admin_templates->parse('cc_main_options', 'ccitem', false);
                    }
                }

                $items[$cc_arr[$i]['lang']] = $item;
            }
        }

        if ($_CONF['sort_admin']) {
            uksort($items, 'strcasecmp');
        }

        if (!empty($items)) {
            // Add Group Label now
            if ($isAdminMenu) {
                $adminMenu->set_var('group_label', $LANG29[$ccGroup]);
                $retval .= $adminMenu->finish($adminMenu->parse('item', 'group'));
            } else {
                $admin_templates->set_var('lang_group', $LANG29[$ccGroup]);
            }

            // Add items now
            reset($items);
            $cols = 0;
            $cc_main_options = '';
            foreach ($items as $key => $val) {
                if ($isAdminMenu) {
                    $retval .= $val;
                } else {
                    $cc_main_options .= $val . LB;
                    $cols++;
                    if ($cols == ICONS_PER_ROW) {
                        $admin_templates->set_var('cc_main_options', $cc_main_options);
                        $admin_templates->parse('cc_rows', 'ccrow', true);
                        $admin_templates->clear_var('cc_main_options');
                        $cc_main_options = '';
                        $cols = 0;
                    }
                }
            }

            if (!$isAdminMenu) {
                if ($cols > 0) {
                    // "flush out" any unrendered entries
                    $admin_templates->set_var('cc_main_options', $cc_main_options);
                    $admin_templates->parse('cc_rows', 'ccrow', true);
                    $admin_templates->clear_var('cc_main_options');
                }

                $admin_templates->parse('cc_groups', 'ccgroup', true);
            }
        }
    }

    if ($isAdminMenu) {
        $retval .= COM_endBlock(COM_getBlockTemplate('admin_block', 'footer', $position));
    } else {
        $retval .= $admin_templates->finish($admin_templates->parse('output', 'cc'));
        $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
    }

    return $retval;
}

/**
 * Prints administration menu
 * This will return the administration menu items that the user has
 * sufficient rights to -- Admin Block on the left side.
 *
 * @param  string $help       Help file to show
 * @param  string $title      Menu Title
 * @param  string $position   Side being shown on 'left', 'right' or blank.
 * @param  string $cssId      CSS ID (since GL 2.2.0, optional)
 * @param  string $cssClasses CSS class names separated by space (since GL 2.2.0, optional)
 * @return string
 * @see     function COM_userMenu
 */
function COM_adminMenu($help = '', $title = '', $position = '', $cssId = '', $cssClasses = '')
{
    $retval = '';

    // This is quick so do first
    if (COM_isAnonUser()) {
        return $retval;
    }

    $plugin_options = PLG_getAdminOptions();
    $num_plugins = count($plugin_options);

    if (SEC_isModerator() ||
        SEC_hasRights('story.edit,block.edit,topic.edit,user.edit,plugin.edit,user.mail,syndication.edit,theme.edit', 'OR') ||
        ($num_plugins > 0) || SEC_hasConfigAccess()
    ) {
        $retval = COM_commandControl(true, $help, $title, $position, $cssId, $cssClasses);
    }

    return $retval;
}

/**
 * Redirects user to a given URL
 *
 * @param   string $url URL to send user to
 * @return  string      HTML meta redirect
 * @since   since v2.1.2
 */
function COM_redirect($url)
{
    if (!headers_sent($file, $line)) {
        $url = str_ireplace('&amp;', '&', $url);
        header('Location: ' . $url);
    }

    if (COM_isEnableDeveloperModeLog('redirect')) {
        COM_errorLog(
            sprintf(
                '%1$s failed to redirect to "%2$s".  Headers were already sent at line %3$d of "%4$s".',
                __FUNCTION__, $url, $line, $file
            )
        );
    }

    // Send out HTML meta tags in case header('Location: some_url') fails
    @header('Content-Type: text/html; charset=' . COM_getCharset());
    echo "<html><head><meta http-equiv=\"refresh\" content=\"0; URL={$url}\"></head></html>" . PHP_EOL;
    die(1);
}

/**
 * Redirects user to a given URL
 * This function does a redirect using a meta refresh. This is (or at least
 * used to be) more compatible than using a HTTP Location: header.
 * NOTE:     This does not need to be XHTML compliant. It may also be used
 *           in situations where the XHTML constant is not defined yet ...
 *
 * @param        string $url URL to send user to
 * @return       string      HTML meta redirect
 * @deprecated   since v2.1.2
 * @see          COM_redirect
 */
function COM_refresh($url)
{
    COM_deprecatedLog(__FUNCTION__, '2.1.2', '3.0.0', 'COM_redirect');

    if (is_callable('CUSTOM_refresh')) {
        return CUSTOM_refresh($url);
    } else {
        header('Content-Type: text/html; charset=' . COM_getCharset());

        return "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
    }
}

/**
 * DEPRECIATED -- see CMT_userComments in lib-comment.php
 *
 * @deprecated since Geeklog 1.4.0
 * @see        CMT_userComments
 */
function COM_userComments($sid, $title, $type = 'article', $order = '', $mode = '', $pid = 0, $page = 1, $cid = false, $delete_option = false)
{
    global $_CONF;

    COM_deprecatedLog(__FUNCTION__, '1.4.0', '3.0.0', 'CMT_userComments in lib-comment.php');

    require_once $_CONF['path_system'] . 'lib-comment.php';

    return CMT_userComments($sid, $title, $type, $order, $mode, $pid, $page, $cid, $delete_option);
}

/**
 * This censors inappropriate content
 * This will replace 'bad words' with something more appropriate
 *
 * @param  string $message String to check
 * @param  string $type    e.g. 'story', 'comment'
 * @see    function COM_checkHTML
 * @return string          Edited $Message
 */
function COM_checkWords($message, $type = '')
{
    global $_CONF;

    $editedMessage = $message;

    // Allow some admins to bypass bad word check
    if (SEC_inGroup('Root')) {
        return $editedMessage;
    }

    if (($type === 'comment') && SEC_inGroup('Comment Admin')) {
        return $editedMessage;
    }

    if (($type === 'story') && SEC_inGroup('Story Admin')) {
        return $editedMessage;
    }

    if ($_CONF['censormode'] != 0) {
        if (is_array($_CONF['censorlist'])) {
            $Replacement = $_CONF['censorreplace'];

            switch ($_CONF['censormode']) {
                case 1: // Exact match
                    // Intentional fall-through
                default:
                    // Check words surround by any white-space character. 
                    $RegExPrefix[] = '(\s)';
                    $RegExSuffix[] = '(\W)';

                    // Check words surround by multiple white-space characters. 
                    $RegExPrefix[] = '(\s+)';
                    $RegExSuffix[] = '(\W)';

                    // Check start of string
                    $RegExPrefix[] = '(^)'; // start of string
                    $RegExSuffix[] = '(\W)';

                    // Check End of string
                    $RegExPrefix[] = '(\s)';
                    $RegExSuffix[] = '($)'; // End of string

                    // Check End of line (but not necessarily end of string)
                    $RegExPrefix[] = '(\s)';
                    $RegExSuffix[] = '(\r\n|\r|\n)'; // Line end

                    break;

                case 2: // Word beginning
                    $RegExPrefix[] = '(\s)';
                    $RegExSuffix[] = '(\w*)';

                    // Check start of string
                    $RegExPrefix[] = '(^)'; // start of string
                    $RegExSuffix[] = '(\W)';

                    break;

                case 3: // Word fragment
                    $RegExPrefix[] = '(\w*)';
                    $RegExSuffix[] = '(\w*)';
                    break;
            }

            foreach ($_CONF['censorlist'] as $c) {
                if (!empty($c)) {

                    // Check for exact match. Could happen for really short text strings like anonymous names in comments
                    if (strtolower($editedMessage) == strtolower($c)) {
                        // No need to continue since replaced entire string
                        return $Replacement;
                    } else {
                        // Cycle through each regular expression as needed
                        for ($i = 0; $i < count($RegExPrefix); ++$i) {
                            $editedMessage = MBYTE_eregi_replace($RegExPrefix[$i] . $c . $RegExSuffix[$i], "\\1$Replacement\\2", $editedMessage);
                        }
                    }
                }
            }
        }
    }

    return $editedMessage;
}

/**
 *  Takes some amount of text and replaces all javascript events on*= with in
 *  This script takes some amount of text and matches all javascript events, on*= (onBlur= onMouseClick=)
 *  and replaces them with in*=
 *  Essentially this will cause onBlur to become inBlur, onFocus to be inFocus
 *  These are not valid javascript events and the browser will ignore them.
 *
 * @param    string $Message Text to filter
 * @return   string  $Message with javascript filtered
 * @see       COM_checkWords
 * @see       COM_checkHTML
 */
function COM_killJS($Message)
{
    return preg_replace('/(\s)+[oO][nN](\w*) ?=/', '\1in\2=', $Message);
}

/**
 * Handles the part within a [code] ... [/code] section, i.e. escapes all
 * special characters.
 *
 * @param   string $str the code section to encode
 * @return  string  $str with the special characters encoded
 * @see     COM_checkHTML
 */
function COM_handleCode($str)
{
    $search = array('&', '<', '>', '[', ']');
    $replace = array('&amp;', '&lt;', '&gt;', '&#91;', '&#93;');
    $str = str_replace($search, $replace, $str);

    return $str;
}

/**
 * This function checks html tags.
 * Checks to see that the HTML tags are on the approved list and
 * removes them if not.
 *
 * @param    string $str         HTML to check
 * @param    string $permissions comma-separated list of rights which identify the current user as an "Admin"
 * @return   string              Filtered HTML
 */
function COM_checkHTML($str, $permissions = 'story.edit')
{
    return GLText::checkHTML($str, $permissions);
}

/**
 * undo function for htmlspecialchars()
 * This function translates HTML entities created by htmlspecialchars() back
 * into their ASCII equivalents. Also handles the entities for $, {, and }.
 *
 * @param  string $string The string to convert.
 * @return string         The converted string.
 */
function COM_undoSpecialChars($string)
{
    $string = str_replace('&#39;', "'", $string);
    $string = str_replace('&#039;', "'", $string);
    $string = str_replace('&#36;', '$', $string);
    $string = str_replace('&#036;', '$', $string);
    $string = str_replace('&#123;', '{', $string);
    $string = str_replace('&#125;', '}', $string);
    $string = str_replace('&gt;', '>', $string);
    $string = str_replace('&lt;', '<', $string);
    $string = str_replace('&quot;', '"', $string);
    $string = str_replace('&nbsp;', ' ', $string);
    $string = str_replace('&amp;', '&', $string);

    return $string;
}

/**
 * Makes an ID based on current date/time
 * This function creates a 17 digit id for articles based on the 14 digit date
 * and a 3 digit random number that was seeded with the number of microseconds
 * (.000001th of a second) since the last full second. Supports adding current
 * language id to id if multiple languages enabled.
 * NOTE: this is now used for other ids for plugins etc..
 *
 * @param    boolean $multilang_support     Does item that id is for support Geeklog multiple languages
 * @return   string  $id                    ID
 */
function COM_makeSid($multilang_support = false)
{
    global $_CONF;
    
    $id = date('YmdHis');
    $id .= rand(0, 999);
    
    if ($multilang_support && $_CONF['new_item_set_current_lang'] && COM_isMultiLanguageEnabled()) {
        $langid = COM_getLanguageId();
        if (!empty($langid)) {
            $id .= '_' . $langid;
        }    
    }

    return $id;
}

/**
 * Checks to see if email address is valid.
 * This function checks to see if an email address is in the correct from.
 *
 * @param    string $email Email address to verify
 * @return   boolean       True if valid otherwise false
 */
function COM_isEmail($email)
{
    // This regular expression was taken from Pear's Mail/RFC822.php
    $isMatch = preg_match('/^([*+!.&#$|\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})$/i', trim($email));

    return ($isMatch === 1);
}

/**
 * Encode a string such that it can be used in an email header
 *
 * @param       string $string the text to be encoded
 * @return      string         encoded text
 * @deprecated since Geeklog-2.1.2
 */
function COM_emailEscape($string)
{
    COM_deprecatedLog(__FUNCTION__, '2.1.2', '3.0.0');

    if (function_exists('CUSTOM_emailEscape')) {
        return CUSTOM_emailEscape($string);
    }

    $charset = COM_getCharset();
    if (($charset === 'utf-8') && ($string !== utf8_decode($string))) {
        // Current hack to bypass the use of iconv_mime_encode until proper fix found
        // In some cases emails being sent fail when using COM_Mail when the email subject contain certain characters in another language (like Japanese)
        // This bug usually happens when the Geeklog forum sends out a notification email of a reply to a topic. 
        // For more info see https://github.com/Geeklog-Core/geeklog/issues/684
        if (false) {
            //if (function_exists('iconv_mime_encode')) {
            $mime_parameters = array(
                'input-charset'  => 'utf-8',
                'output-charset' => 'utf-8',
                // 'Q' encoding is more readable than 'B'
                'scheme'         => 'Q',
            );
            $string = substr(iconv_mime_encode('', $string, $mime_parameters), 2);
        } else {
            $string = '=?' . $charset . '?B?' . base64_encode($string) . '?=';
        }
    } elseif (preg_match('/[^0-9a-z\-\.,:;\?! ]/i', $string)) {
        $string = '=?' . $charset . '?B?' . base64_encode($string) . '?=';
    }

    return $string;
}

/**
 * Takes a name and an email address and returns a string that vaguely
 * resembles an email address specification conforming to RFC(2)822 ...
 *
 * @param      string $name    name, e.g. John Doe
 * @param      string $address email address only, e.g. john.doe@example.com
 * @return     string          formatted email address
 * @deprecated since v2.1.2
 */
function COM_formatEmailAddress($name, $address)
{
    COM_deprecatedLog(__FUNCTION__, '2.1.2', '3.0.0');

    $name = trim($name);
    $address = trim($address);

    if (function_exists('CUSTOM_formatEmailAddress')) {
        return CUSTOM_formatEmailAddress($name, $address);
    }

    $formatted_name = COM_emailEscape($name);

    // if the name comes back unchanged, it's not UTF-8, so preg_match is fine
    if (($formatted_name == $name) && preg_match('/[^0-9a-z ]/i', $name)) {
        $formatted_name = str_replace('"', '\\"', $formatted_name);
        $formatted_name = '"' . $formatted_name . '"';
    }

    return $formatted_name . ' <' . $address . '>';
}

/**
 * Send an email.
 * All emails sent by Geeklog are sent through this function.
 * NOTE: Please note that using CC: will expose the email addresses of
 *       all recipients. Use with care.
 *
 * @param    string|array $to          recipient's email address | array(email address => recipient's name)
 * @param    string       $subject     subject of the email
 * @param    string       $message     the text of the email
 * @param    string|array $from        (optional) sender's email address | array(email address > sender's name)
 * @param    bool         $html        (optional) true if to be sent as HTML email
 * @param    int          $priority    (optional) add X-Priority header, if > 0
 * @param    mixed        $optional    (optional) other headers or CC:
 * @param    array        $attachments (optional) array of file names to attach
 * @return   bool                      true if successful,  otherwise false
 */
function COM_mail($to, $subject, $message, $from = '', $html = false, $priority = 0, $optional = null, array $attachments = array())
{
    global $_TABLES, $_CONF;
    
    // Need to check email address to ensure they are not from account that have a status of locked or new email. If so we need to remove them so no email sent
    // Email addresses without accounts are not affected
    if (is_array($to)) {
        $email = key($to);    
    } else {
        $email = $to;
    }
    
    // If no status exists then assume no user account and email is being sent to someone else (which is fine and should be sent like to new users)
    $status = DB_getItem($_TABLES['users'], 'status', "email = '$email'");

    if (!empty($status) && ($status == USER_ACCOUNT_DISABLED || $status == USER_ACCOUNT_LOCKED || $status == USER_ACCOUNT_NEW_EMAIL)) {
        return false;
    } else {
        if (COM_isDemoMode()) {
            // Don't send any emails in demo mode.  Instead, redirect to the home page and show a message.
            $charset = COM_getCharset();
            $subject = htmlspecialchars($subject, ENT_QUOTES, $charset);
            $toAddress = array_keys($to)[0];
            $toAlias = array_values($to)[0];
            $to = htmlspecialchars(
                $toAlias . ' <' . $toAddress . '>',
                ENT_QUOTES, 
                $charset
            );
            $fromAddress = array_keys($from)[0];
            $fromAlias = array_values($from)[0];
            $from = htmlspecialchars(
                $fromAlias . ' <' . $fromAddress . '>',
                ENT_QUOTES,
                $charset
            );
            $priority = htmlspecialchars($priority, ENT_QUOTES, $charset);

            if (!$html) {
                $message = GLText::removeAllHTMLTagsAndAttributes($message);
            }

            // Just in case
            $message = htmlspecialchars($message, ENT_QUOTES, $charset);
            $message = str_replace(["\r\n", "\n", "\r"], '<br>', $message);
            $msg = <<<EOD
<h2>Notice</h2>
<p>Please note sending emails is disabled in Demo mode. The last email which would have been sent was:</p>
---------- Header ----------<br>
Subject: {$subject}<br>
To: {$to}<br>
From: {$from}<br>
Priority: {$priority}<br>
<br>
---------- Body ------------<br>
{$message}<br>
----------------------------<br>
EOD;
            Session::setFlashVar('msg', $msg);
            COM_redirect($_CONF['site_url']);

            return true;
        } else {
            return Mail::send($to, $subject, $message, $from, $html, $priority, $optional, $attachments);
        }
    }
}

/**
 * Shows older story information in a block
 * Return the HTML that shows any older stories
 *
 * @param    string $help       Help file for block
 * @param    string $title      Title used in block header
 * @param    string $position   Position in which block is being rendered 'left', 'right' or blank (for centre)
 * @param    string $cssId      CSS ID (since GL 2.2.0, optional)
 * @param    string $cssClasses CSS class names separated by space (since GL 2.2.0, optional)
 * @return   string             Return the HTML that shows any new stories, comments, etc
 */
function COM_olderStoriesBlock($help = '', $title = '', $position = '', $cssId = '', $cssClasses = '')
{
    global $_TABLES, $_CONF, $LANG01;

    $cacheInstance = 'olderarticles__' . CACHE_security_hash() . '__' . $_CONF['theme'];
    $retval = CACHE_check_instance($cacheInstance);
    if ($retval) {
        return $retval;
    }

    $retval = COM_startBlock(
        $title, $help,
        COM_getBlockTemplate('older_stories_block', 'header', $position),
        $cssId, $cssClasses
    );
    
    $t = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'blocks/'));
    $t->set_file(array('olderarticles' => 'olderarticles.thtml'));

    $sql['mysql'] = "SELECT sid,title,comments,UNIX_TIMESTAMP(date) AS day
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE ta.type = 'article' AND ta.id = sid " . COM_getLangSQL('sid', 'AND') . "
        AND (perm_anon = 2) AND (frontpage = 1) AND (date <= NOW()) AND (draft_flag = 0)" . COM_getTopicSQL('AND', 1, 'ta') . "
        GROUP BY sid, featured, date, title, comments, day 
        ORDER BY featured DESC, date DESC LIMIT {$_CONF['limitnews']}, {$_CONF['limitnews']}";

    $sql['pgsql'] = "SELECT sid,title,comments,date_part('epoch',date) AS day
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE ta.type = 'article' AND ta.id = sid  " . COM_getLangSQL('sid', 'AND') . "
        AND (perm_anon = 2) AND (frontpage = 1) AND (date <= NOW()) AND (draft_flag = 0)" . COM_getTopicSQL('AND', 1, 'ta') . "
        GROUP BY sid, featured, date, title, comments, day  
        ORDER BY featured DESC, date DESC LIMIT {$_CONF['limitnews']}, {$_CONF['limitnews']}";

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    if ($numRows > 0) {
        $day = 'noday';
        $string = '';
        $oldNews = array();

        for ($i = 0; $i < $numRows; $i++) {
            $A = DB_fetchArray($result);
            $dayCheck = strftime('%A', $A['day']);

            if ($day != $dayCheck) {
                if ($day !== 'noday') {
                    $dayList = COM_makeList($oldNews, PLG_getCSSClasses('article-list-older', 'article'));
                    $oldNews = array(); // Reset old news array
                    $dayList = preg_replace("/(\015\012)|(\015)|(\012)/", '', $dayList);
                    
                    $t->set_var('older-articles-list', $dayList);
                    $t->set_var('date-divider', true);
                    $string .= $t->parse('output', 'olderarticles');                       
                }

                list($day2,) = COM_getUserDateTimeFormat($A['day'], 'dateonly');
                
                $t->set_var('weekday', $dayCheck);
                $t->set_var('short-date', $day2);
                $day = $dayCheck;
            }

            $oldNewsUrl = COM_buildURL($_CONF['site_url'] . '/article.php?story=' . $A['sid']);
            $oldNews[] = COM_createLink($A['title'], $oldNewsUrl)
                . ' (' . COM_numberFormat($A['comments']) . ')';
        }

        if (!empty($oldNews)) {
            $dayList = COM_makeList($oldNews, 'article-list-older');
            $dayList = preg_replace("/(\015\012)|(\015)|(\012)/", '', $dayList);
            
            $t->set_var('older-articles-list', $dayList);
            $string .= $t->parse('output', 'olderarticles');                  
            
            $retval .= $string;
        }
    } else {
        // No older articles found
        $retval .= $LANG01[101];
    }

    $retval .= COM_endBlock(COM_getBlockTemplate('older_stories_block', 'footer', $position));
    CACHE_create_instance($cacheInstance, $retval);

    return $retval;
}

/**
 * Shows a single Geeklog block
 * This shows a single block and is typically called from
 * COM_showBlocks OR from plugin code
 *
 * @param    string $name       Logical name of block (not same as title) -- 'user_block', 'admin_block',
 *                              'section_block', 'whats_new_block'.
 * @param    string $help       Help file location
 * @param    string $title      Title shown in block header
 * @param    string $position   Side, 'left', 'right' or empty.
 * @param    string $cssId      CSS ID (since GL 2.2.0, optional)
 * @param    string $cssClasses CSS class names separated by space (since GL 2.2.0, optional)
 * @see       function COM_showBlocks
 * @return    string            HTML Formatted block
 */
function COM_showBlock($name, $help = '', $title = '', $position = '', $cssId = '', $cssClasses = '')
{
    global $topic, $_TABLES, $_USER;

    $retval = '';

    if (!isset($_USER['noboxes'])) {
        $_USER['noboxes'] = COM_isAnonUser()
            ? 0
            : DB_getItem($_TABLES['userindex'], 'noboxes', "uid = {$_USER['uid']}");
    }

    switch ($name) {
        case 'user_block':
            $retval .= COM_userMenu($help, $title, $position, $cssId, $cssClasses);
            break;

        case 'admin_block':
            $retval .= COM_adminMenu($help, $title, $position, $cssId, $cssClasses);
            break;

        case 'section_block':
            $retval .= COM_startBlock(
                    $title, $help,
                    COM_getBlockTemplate($name, 'header', $position),
                    $cssId, $cssClasses
                )
                . COM_showTopics($topic)
                . COM_endBlock(COM_getBlockTemplate($name, 'footer', $position));
            break;

        case 'whats_new_block':
            if (!$_USER['noboxes']) {
                $retval .= COM_whatsNewBlock($help, $title, $position);
            }
            break;

        case 'older_stories':
            if (!$_USER['noboxes']) {
                $retval .= COM_olderStoriesBlock($help, $title, $position);
            }
            break;
    }

    return $retval;
}

/**
 * Shows Geeklog blocks
 * Returns HTML for blocks on a given side and, potentially, for
 * a given topic. Currently only used by static pages.
 *
 * @param  string $location  Side to get blocks for (right or left) OR other block location id
 * @see    function COM_showBlock
 * @return string        HTML Formatted blocks
 */
function COM_showBlocks($location)
{
    global $_TABLES, $_USER, $topic, $_TOPICS;

    $retval = '';

    // Get user preferences on blocks
    if (!isset($_USER['noboxes']) || !isset($_USER['boxes'])) {
        if (!COM_isAnonUser()) {
            $result = DB_query("SELECT boxes,noboxes FROM {$_TABLES['userindex']} "
                . "WHERE uid = '{$_USER['uid']}'");
            list($_USER['boxes'], $_USER['noboxes']) = DB_fetchArray($result);
        } else {
            $_USER['boxes'] = '';
            $_USER['noboxes'] = 0;
        }
    }

    $blockSql['mysql'] = "SELECT b.*,UNIX_TIMESTAMP(rdfupdated) AS date ";
    $blockSql['pgsql'] = 'SELECT b.*, date_part(\'epoch\', rdfupdated) AS date ';

    $blockSql['mysql'] .= "FROM {$_TABLES['blocks']} b, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'block' AND ta.id = bid AND is_enabled = 1";
    $blockSql['pgsql'] .= "FROM {$_TABLES['blocks']} b, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'block' AND ta.id::integer = bid AND is_enabled = 1";

    $commonSql = '';
    if ($location === 'left') {
        $commonSql .= " AND onleft = " . BLOCK_LEFT_POSITION;
    } elseif ($location === 'right') {
        $commonSql .= " AND onleft = " . BLOCK_RIGHT_POSITION;
    } else {
        $commonSql .= " AND onleft = " . BLOCK_NONE_POSITION . " AND location = '$location'";
    }

    // Figure out topic access
    $topic_access = 0;
    if (!empty($topic) && ($topic != TOPIC_ALL_OPTION) && ($topic != TOPIC_HOMEONLY_OPTION)) {
        $topic_index = TOPIC_getIndex($topic);
        if ($topic_index > 0) {
            $topic_access = $_TOPICS[$topic_index]['access'];
        }
    }

    if (!empty($topic) && ($topic != TOPIC_ALL_OPTION) && ($topic != TOPIC_HOMEONLY_OPTION) &&
        ($topic_access > 0)
    ) {
        // Retrieve list of inherited topics
        $tid_list = TOPIC_getChildList($topic);
        // Get list of blocks to display (except for dynamic). This includes blocks
        // for all topics, and child blocks that are inherited
        $commonSql .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$topic}')) OR ta.tid = 'all')";
    } else {
        if (COM_onFrontpage()) {
            $commonSql .= " AND (ta.tid = '" . TOPIC_HOMEONLY_OPTION . "' OR ta.tid = '" . TOPIC_ALL_OPTION . "')";
        } else {
            $commonSql .= " AND (ta.tid = '" . TOPIC_ALL_OPTION . "')";
        }
    }

    if (!empty($_USER['boxes'])) {
        $BOXES = str_replace(' ', ',', $_USER['boxes']);
        $commonSql .= " AND (bid NOT IN ($BOXES) OR bid = '-1')";
    }

    $commonSql .= " GROUP BY bid, is_enabled, name, b.type, title, blockorder, device, content, "
        . "allow_autotags, convert_newlines, cache_time, rdfurl, rdfupdated, rdf_last_modified, rdf_etag, rdflimit, "
        . "onleft, phpblockfn, help, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon ";
    $commonSql .= ' ORDER BY blockorder,title ASC';

    $blockSql['mysql'] .= $commonSql;
    $blockSql['pgsql'] .= $commonSql;

    $result = DB_query($blockSql);
    $numRows = DB_numRows($result);

    // convert result set to an array of associated arrays
    $blocks = array();
    for ($i = 0; $i < $numRows; $i++) {
        $blocks[] = DB_fetchArray($result);
    }

    // Check and see if any plugins have blocks to show
    $pluginBlocks = PLG_getBlocks($location, $topic);
    $blocks = array_merge($blocks, $pluginBlocks);

    // sort the resulting array by block order
    $column = 'blockorder';
    $sortedBlocks = $blocks;
    $num_sortedBlocks = count($sortedBlocks);
    for ($i = 0; $i < $num_sortedBlocks - 1; $i++) {
        for ($j = 0; $j < $num_sortedBlocks - 1 - $i; $j++) {
            if ($sortedBlocks[$j][$column] > $sortedBlocks[$j + 1][$column]) {
                $tmp = $sortedBlocks[$j];
                $sortedBlocks[$j] = $sortedBlocks[$j + 1];
                $sortedBlocks[$j + 1] = $tmp;
            }
        }
    }
    $blocks = $sortedBlocks;

    // Loop though resulting sorted array and pass associative arrays
    // to COM_formatBlock
    foreach ($blocks as $A) {
        if (($A['type'] === 'dynamic') ||
            SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']) > 0
        ) {
            $retval .= COM_formatBlock($A, $_USER['noboxes']);
        }
    }

    return $retval;
}

/**
 * Formats a Geeklog block
 * This shows a single block and is typically called from
 * COM_showBlocks OR from plugin code
 *
 * @param        array   $A          Block Record
 * @param        boolean $noBoxes    Set to true if userpref is no blocks
 * @param        boolean $noPosition Set to true if you don't want to use the left or right side footer and header of
 *                                   block
 * @return       string              HTML Formatted block
 */
function COM_formatBlock($A, $noBoxes = false, $noPosition = false)
{
    global $_CONF, $_TABLES, $LANG21, $_DEVICE;

    $retval = '';
    $plugin = '';

    $lang = COM_getLanguageId();
    if (!empty($lang)) {
        $blockSql['mysql'] = "SELECT *,UNIX_TIMESTAMP(rdfupdated) AS date ";
        $blockSql['pgsql'] = "SELECT *, date_part('epoch', rdfupdated) AS date ";

        $commonSql = "FROM {$_TABLES['blocks']} WHERE name = '" . $A['name'] . '_' . $lang . "'";

        $blockSql['mysql'] .= $commonSql;
        $blockSql['pgsql'] .= $commonSql;
        $result = DB_query($blockSql);

        if (DB_numRows($result) == 1) {
            // overwrite with data for language-specific block
            $A = DB_fetchArray($result);
        }
    }

    if (empty($A['css_id'])) {
        $A['css_id'] = '';
    }
    if (empty($A['css_classes'])) {
        $A['css_classes'] = '';
    }

    // Make sure block can be used by specific device
    // If no device column found then bypass compare check (could happen with dynamic blocks that do not pass device)
    if (!isset($A['device']) || $_DEVICE->compare($A['device'])) {
        if (array_key_exists('onleft', $A) && !$noPosition) {
            if ($A['onleft'] == 0) {
                $position = 'right';
            } elseif ($A['onleft'] == 1) {
                $position = 'left';
            } elseif ($A['onleft'] == 2) {
                // Make sure location exists before checking it (in case dynamic block did not pass one)
                if (array_key_exists('location', $A) && !empty($A['location'])) {
                    $position = $A['location']; // This means it is a custom block location as defined by a theme or another plugin
                    
                    // Determine if Plugin as it could be theme (need to pass plugin name to COM_startBlock and COM_getBlockTemplate so can find proper templates)
                    $block_locations = PLG_getBlockLocations();
                    $key = array_search($position, array_column($block_locations, 'id'));
                    if (is_numeric($key) && $block_locations[$key]['type'] == 'plugin') {
                        $plugin = $block_locations[$key]['type_name'];
                    }
                } else {
                    $position = '';
                }
            } else {
                $position = '';
            }
        } else {
            $position = '';
        }

        if ($A['type'] === 'gldefault') {
            $retval .= COM_showBlock($A['name'], $A['help'], $A['title'], $position, $A['css_id'], $A['css_classes']);
        } else {
            // The only time cache_time would not be set if for dynamic blocks (they can handle their own caching if needed)
            // Don't Cache default blocks either
            if (isset($A['cache_time']) && (($A['cache_time'] > 0) || ($A['cache_time'] == -1))) {
                $cacheInstance = 'block__' . $A['bid'] . '__' . CACHE_security_hash() . '__' . $_CONF['theme'];
                $retval = CACHE_check_instance($cacheInstance);
                if ($retval && ($A['cache_time'] == -1)) {
                    return $retval;
                } elseif ($retval && ($A['cache_time'] > 0)) {
                    $lu = CACHE_get_instance_update($cacheInstance);
                    $now = time();
                    if (($now - $lu) < $A['cache_time']) {
                        return $retval;
                    } else {
                        $retval = '';
                    }
                }
            }
        }

        if ($A['type'] === 'portal') {
            COM_rdfImport($A['bid'], $A['rdfurl'], $A['rdflimit']);
            $A['content'] = DB_getItem($_TABLES['blocks'], 'content', "bid = '{$A['bid']}'");
        }

        if (($A['type'] === 'phpblock') && !$noBoxes) {
            if (!(($A['name'] === 'whosonline_block') && (DB_getItem($_TABLES['blocks'], 'is_enabled', "name='whosonline_block'") == 0))) {
                $function = $A['phpblockfn'];
                $matches = array();
                if (preg_match('/^(phpblock_\w*)\\((.*)\\)$/', $function, $matches) == 1) {
                    $function = $matches[1];
                    $args = $matches[2];
                }
                $blockHeader = COM_startBlock(
                    $A['title'], $A['help'],
                    COM_getBlockTemplate($A['name'], 'header', $position, $plugin),
                    $A['css_id'], $A['css_classes'],
                    $plugin
                );
                $blockFooter = COM_endBlock(COM_getBlockTemplate($A['name'], 'footer', $position, $plugin), $plugin);

                if (function_exists($function)) {
                    if (isset($args)) {
                        $fRetval = $function($A, $args);
                    } else {
                        $fRetval = $function();
                    }
                    if (!empty($fRetval)) {
                        $retval .= $blockHeader;
                        $retval .= $fRetval;
                        $retval .= $blockFooter;
                    }
                } else {
                    // show error message
                    $retval .= $blockHeader;
                    $retval .= sprintf($LANG21[31], $function);
                    $retval .= $blockFooter;
                }
            }
        }

        if (!empty($A['content']) && (trim($A['content']) != '') && !$noBoxes) {
            $blockContent = stripslashes($A['content']);

            // Introduced in Geeklog v2.2.0
            // Dynamic Blocks from older plugins may not have convert_newlines set so check this 
            if (isset($A['convert_newlines']) && ($A['convert_newlines'] == 1) && ($A['type'] === 'normal')) {
                $blockContent = COM_nl2br($blockContent);
            }

            // autotags are only(!) allowed in normal blocks
            if (($A['allow_autotags'] == 1) && ($A['type'] === 'normal')) {
                $blockContent = PLG_replaceTags($blockContent);
            }
            $blockContent = str_replace(array('<?', '?>'), '', $blockContent);

            $retval .= COM_startBlock(
                    $A['title'], $A['help'],
                    COM_getBlockTemplate($A['name'], 'header', $position, $plugin),
                    $A['css_id'], $A['css_classes'],
                    $plugin
                )
                . $blockContent . LB
                . COM_endBlock(COM_getBlockTemplate($A['name'], 'footer', $position, $plugin), $plugin);
        }
        // Cache only if enabled and not gldefault or dynamic
        if (isset($A['cache_time']) &&
            (($A['cache_time'] > 0) || ($A['cache_time'] == -1)) &&
            ($A['type'] !== 'gldefault')
        ) {
            CACHE_create_instance($cacheInstance, $retval);
        }
    }

    return $retval;
}

/**
 * Syndication import function. Imports headline data to a portal block.
 * Rewritten December 19th 2004 by Michael Jervis (mike AT fuckingbrit DOT com).
 * Now utilises a Factory Pattern to open a URL and automaticaly retrieve a feed
 * object populated with feed data. Then import it into the portal block.
 *
 * @param    string $bid          Block ID
 * @param    string $rdfUrl       URL to get content from
 * @param    int    $maxHeadlines Maximum number of headlines to display
 * @return   void
 */
function COM_rdfImport($bid, $rdfUrl, $maxHeadlines = 0)
{
    global $_CONF, $_TABLES, $LANG21;

    // Import the feed handling classes:
    require_once $_CONF['path_system'] . '/classes/syndication/parserfactory.class.php';
    require_once $_CONF['path_system'] . '/classes/syndication/feedparserbase.class.php';

    $result = DB_query("SELECT rdf_last_modified, rdf_etag FROM {$_TABLES['blocks']} WHERE bid = $bid");
    list($last_modified, $eTag) = DB_fetchArray($result);

    // Load the actual feed handlers:
    $factory = new FeedParserFactory($_CONF['path_system'] . '/classes/syndication/');
    $factory->userAgent = 'Geeklog/' . VERSION;
    if (!empty($last_modified) && !empty($eTag)) {
        $factory->lastModified = $last_modified;
        $factory->eTag = $eTag;
    }

    // Acquire a reader:
    $feed = $factory->reader($rdfUrl, $_CONF['default_charset']);

    if ($feed) {
        /* We have located a reader, and populated it with the information from
         * the syndication file. Now we will sort out our display, and update
         * the block.
         */
        if ($maxHeadlines == 0) {
            if (!empty($_CONF['syndication_max_headlines'])) {
                $maxHeadlines = $_CONF['syndication_max_headlines'];
            } else {
                $maxHeadlines = count($feed->articles);
            }
        }

        $update = date('Y-m-d H:i:s');
        $last_modified = '';
        if (!empty($factory->lastModified)) {
            $last_modified = DB_escapeString($factory->lastModified);
        }
        $eTag = '';
        if (!empty($factory->eTag)) {
            $eTag = DB_escapeString($factory->eTag);
        }

        if (empty($last_modified) || empty($eTag)) {
            DB_query("UPDATE {$_TABLES['blocks']} SET rdfupdated = '$update', rdf_last_modified = NULL, rdf_etag = NULL WHERE bid = '$bid'");
        } else {
            DB_query("UPDATE {$_TABLES['blocks']} SET rdfupdated = '$update', rdf_last_modified = '$last_modified', rdf_etag = '$eTag' WHERE bid = '$bid'");
        }

        $articles = array();
        $charset = COM_getCharset();

        // format articles for display
        $readMax = min($maxHeadlines, count($feed->articles));
        for ($i = 0; $i < $readMax; $i++) {
            if (empty($feed->articles[$i]['title'])) {
                $feed->articles[$i]['title'] = $LANG21[61];
            }

            if ($charset === 'utf-8') {
                $title = $feed->articles[$i]['title'];
            } else {
                $title = utf8_decode($feed->articles[$i]['title']);
            }
            if ($feed->articles[$i]['link'] != '') {
                $content = COM_createLink($title, $feed->articles[$i]['link']);
            } elseif ($feed->articles[$i]['enclosureurl'] != '') {
                $content = COM_createLink($title, $feed->articles[$i]['enclosureurl']);
            } else {
                $content = $title;
            }
            $articles[] = $content;
        }

        // build a list
        $content = COM_makeList($articles, PLG_getCSSClasses('core-list-feed', 'core'));
        $content = str_replace(array("\015", "\012"), '', $content);

        if (strlen($content) > 65000) {
            $content = $LANG21[68];
        }

        // Standard theme based function to put it in the block
        DB_change($_TABLES['blocks'], 'content', DB_escapeString($content), 'bid', $bid);
    } elseif ($factory->errorStatus !== false) {
        // failed to acquire info, 0 out the block and log an error
        COM_errorLog("Unable to acquire feed reader for $rdfUrl", 1);
        COM_errorLog($factory->errorStatus[0] . ' ' .
            $factory->errorStatus[1] . ' ' .
            $factory->errorStatus[2]);
        $content = DB_escapeString($LANG21[4]);
        DB_query("UPDATE {$_TABLES['blocks']} SET content = '{$content}', rdf_last_modified = NULL, rdf_etag = NULL WHERE bid = {$bid}");
    }
}

/**
 * Returns what HTML is allowed in content
 * Returns what HTML tags the system allows to be used inside content.
 * You can modify this by changing $_CONF['user_html'] in the configuration
 * (for admins, see also $_CONF['admin_html']).
 *
 * @param    string  $permissions          comma-separated list of rights which identify the current user as an "Admin"
 * @param    boolean $list_only            true = return only the list of HTML tags
 * @param    int     $filter_html_flag     0 = returns allowed all html tags,
 *                                         1 = returns allowed HTML tags only,
 *                                         2 = returns No HTML Tags Allowed (this is used by plugins if they have
 *                                         a config that overrides Geeklogs filter html settings or do not have a
 *                                         post mode)
 * @param    string  $post_mode            Indicates if text is html, adveditor, wikitext or plaintext
 * @return   string                       HTML <div>/<span> enclosed string
 * @see      function COM_checkHTML
 */
function COM_allowedHTML($permissions = 'story.edit', $list_only = false, $filter_html_flag = 1, $post_mode = '')
{
    global $_CONF, $LANG01;

    $has_list = false;
    if ((SEC_hasRights('htmlfilter.skip') || (isset($_CONF['skip_html_filter_for_root']) &&
                ($_CONF['skip_html_filter_for_root'] == 1) &&
                SEC_inGroup('Root'))) || ($filter_html_flag == 0)
    ) {
        $description = $LANG01[123]; // All HTML is allowed
        if (in_array($post_mode, array('plaintext', 'wikitext'))) {
            $description = $LANG01[131]; // No HTML is allowed
        }
    } elseif (($filter_html_flag == 2) ||
        in_array($post_mode, array('plaintext', 'wikitext'))
    ) {
        $description = $LANG01[131]; // No HTML is allowed
    } else {
        $has_list = true;
        $description = $LANG01[31];  // Allowed HTML Tags:
    }

    $list = '';
    if ($has_list) {
        if (empty($permissions) || !SEC_hasRights($permissions) ||
            empty($_CONF['admin_html'])
        ) {
            $html = $_CONF['user_html'];
        } else {
            if ($post_mode === 'adveditor') {
                $html = array_merge_recursive($_CONF['user_html'],
                    $_CONF['admin_html'],
                    $_CONF['advanced_html']);
            } else {
                $html = array_merge_recursive($_CONF['user_html'],
                    $_CONF['admin_html']);
            }
        }

        foreach ($html as $tag => $attr) {
            $list .= '&lt;' . $tag . '&gt;&nbsp;, ';
        }
        $list = rtrim($list, ', ');
    }

    $class = !empty($post_mode) ? ' post_mode_' . $post_mode : '';
        
    $retval = COM_createControl('display-allowed-html', array(
        'list_only' => $list_only,
        'post_mode_class' => $class,
        'html_description' => $description,
        'html_list' => $list
    ));        

    return $retval;
}

/**
 * Returns what autotag is allowed in content
 * Returns what autotags the system allows to be used inside content.
 *
 * @param    boolean $list_only    true = return only the list of HTML tags
 * @param    array   $allowed_tags Array of allowed special tags ('code', 'raw', 'page_break' ...)
 * @return   string                HTML <div>/<span> enclosed string
 * @see      function COM_checkHTML
 */
function COM_allowedAutotags($list_only = false, $allowed_tags = array())
{
    global $LANG01;

    $list = '';
    if (count($allowed_tags) > 0) {
        foreach ($allowed_tags as $tag) {
            $list .= '&#91;' . $tag . '&#93;&nbsp;, ';
        }
    }

    // List autotags user has permission to use (with descriptions)
    $autotags = array_keys(PLG_collectTags('permission'));
    $description = array_flip(PLG_collectTags('description'));
    $closetag = array_flip(PLG_collectTags('closetag'));
    foreach ($autotags as $tag) {
        if (in_array($tag, $closetag)) {
            $tagname = '&#91;' . $tag . ':&#93;&#91;/' . $tag . '&#93;';
        } else {
            $tagname = '&#91;' . $tag . ':&#93;';
        }
        if (!empty($description[$tag])) {
            $desc = str_replace(array('[', ']'), array('&#91;', '&#93;'), $description[$tag]);
            $list .= COM_getTooltip($tagname, $desc, '', $LANG01[132], 'information') . ', ';
        } else {
            $list .= $tagname . '&nbsp;, ';
        }
    }
    $list = rtrim($list, ', ');

    $retval = COM_createControl('display-allowed-autotags', array(
        'list_only' => $list_only,
        'autotags_description' => $LANG01[140],
        'autotags_list' => $list
    ));     

    return $retval;
}

/**
 * Return the password for the given username
 * Fetches a password for the given user
 *
 * @param    string $loginName username to get password for
 * @return   string            Password or ''
 */
function COM_getPassword($loginName)
{
    global $_TABLES, $LANG01;

    $loginName = DB_escapeString($loginName);
    $result = DB_query("SELECT passwd FROM {$_TABLES['users']} WHERE username='{$loginName}'");
    $tmp = DB_error();
    $numRows = DB_numRows($result);

    if (($tmp == 0) && ($numRows == 1)) {
        $U = DB_fetchArray($result);

        return $U['passwd'];
    } else {
        $tmp = $LANG01[40] . ": '" . $loginName . "'";
        COM_accessLog($tmp);
    }

    return '';
}

/**
 * Return the username or fullname for the passed member id (uid)
 * Allows the siteAdmin to determine if loginname (username) or fullname
 * should be displayed.
 *
 * @param    int    $uid            site member id
 * @param    string $username       Username, if this is set no lookup is done.
 * @param    string $fullname       Users full name.
 * @param    string $remoteUserName Username on remote service
 * @param    string $remoteService  Remote login service.
 * @return   string                 Username, fullname or username@Service
 */
function COM_getDisplayName($uid = 0, $username = '', $fullname = '', $remoteUserName = '', $remoteService = '')
{
    global $_CONF, $_TABLES, $_USER;

    if (empty($uid)) {
        $uid = COM_isAnonUser() ? 1 : $_USER['uid'];
    }

    // "this shouldn't happen"
    if ($uid == 0) {
        $uid = 1;
    }

    if (empty($username)) {
        $query = DB_query("SELECT username, fullname, remoteusername, remoteservice FROM {$_TABLES['users']} WHERE uid='$uid'");
        list($username, $fullname, $remoteUserName, $remoteService) = DB_fetchArray($query);
    }

    if (!empty($fullname) && ($_CONF['show_fullname'] == 1)) {
        return $fullname;
    } elseif (($_CONF['user_login_method']['3rdparty'] || $_CONF['user_login_method']['openid']) && !empty($remoteUserName)) {
        if (!empty($username)) {
            $remoteUserName = $username;
        }

        if ($_CONF['show_servicename']) {
            return "{$remoteUserName}@{$remoteService}";
        } else {
            return $remoteUserName;
        }
    }

    return $username;
}

/**
 * Return an <a> tag linking to a user's profile page or a <span> tag just showing a user's name
 *
 * @param    int    $uid            user id
 * @param    string $userName       Username, if this is set no lookup is done.
 * @param    string $fullName       Users full name.
 * @param    string $remoteUserName Username on remote service
 * @param    string $remoteService  Remote login service.
 * @param    array  $attributes     Additional HTML attributes
 * @return   string                 an <a> or a <span> tag
 */
function COM_getProfileLink($uid = 0, $userName = '', $fullName = '', $remoteUserName = '', $remoteService = '', array $attributes = [])
{
    global $_CONF, $_USER;

    // Check user id
    if (empty($uid)) {
        $uid = COM_isAnonUser() ? 1 : $_USER['uid'];
    }

    $uid = (int) $uid;

    // "this shouldn't happen"
    if ($uid == 0) {
        $uid = 1;
    }

    // Get display text
    $text = COM_getDisplayName($uid, $userName, $fullName, $remoteUserName, $remoteService);

    // Build an <a> or a <span> tag
    if ($uid <= 1) {
        $retval = COM_escHTML($text);
    } else {
        require_once $_CONF['path_system'] . 'lib-security.php';
        require_once $_CONF['path_system'] . 'lib-user.php';

        $isUserBanned = USER_isBanned($uid);
        if (!$isUserBanned || SEC_hasRights('user.edit')) {
            if ($isUserBanned) {
                $attributes = array_merge($attributes, ['style' => 'text-decoration: line-through;']);
            }

            $retval = COM_createLink(
                $text,
                $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $uid,
                $attributes
            );
        } else {
            $retval = '<span style="text-decoration: line-through;">' . COM_escHTML($text) . '</span>';
        }
    }

    return $retval;
}

/**
 * Adds a hit to the system
 * This function is called in the footer of every page and is used to
 * track the number of hits to the Geeklog system.  This information is
 * shown on stats.php
 */
function COM_hit()
{
    global $_TABLES;

    $sql = array();
    $sql['mysql'] = "UPDATE {$_TABLES['vars']} SET value=value+1 WHERE name = 'totalhits'";
    $sql['pgsql'] = "UPDATE {$_TABLES['vars']} SET value=value::int4+1 WHERE name = 'totalhits'";
    DB_query($sql);
}

/**
 * Convert a relative URL to an absolute one
 *
 * @param  array $matches
 * @return string
 */
function COM_emailUserTopicsUrlRewriter(array $matches)
{
    global $_CONF;

    $tag = $matches[0];
    $url = $matches[1];

    if (!preg_match('/\A(http|https|ftp|ftps|javascript):/i', $url)) {
        $absUrl = rtrim($_CONF['site_url'], '/') . '/' . ltrim($url, '/');
        $tag = str_replace($url, $absUrl, $tag);
    }

    return $tag;
}

/**
 * This will email new stories in the topics that the user is interested in
 * In account information the user can specify which topics for which they
 * will receive any new article for in a daily digest.
 *
 * @return   void
 */
function COM_emailUserTopics()
{
    global $_CONF, $_VARS, $_TABLES, $LANG04, $LANG08, $LANG24;

    if ($_CONF['emailstories'] == 0) {
        return;
    }

    $subject = GLText::stripTags($_CONF['site_name'] . $LANG08[30] . strftime('%Y-%m-%d', time()));
    $authors = array();

    // Get users who want stories emailed to them
    $userSql = "SELECT username,email,etids,{$_TABLES['users']}.uid AS uuid "
        . "FROM {$_TABLES['users']}, {$_TABLES['userindex']} "
        . "WHERE {$_TABLES['users']}.uid > 1 AND {$_TABLES['userindex']}.uid = {$_TABLES['users']}.uid AND "
        . "(etids <> '-' OR etids IS NULL) "
        . "ORDER BY {$_TABLES['users']}.uid";

    $users = DB_query($userSql);
    $numRows = DB_numRows($users);
    $lastRun = $_VARS['lastemailedstories'];

    // For each user, pull the stories they want and email it to them
    for ($x = 0; $x < $numRows; $x++) {
        $U = DB_fetchArray($users);

        $storySql = array();
        $storySql['mysql'] = "SELECT sid,uid,date AS day,title,introtext,bodytext";
        $storySql['pgsql'] = "SELECT sid,uid,date AS day,title,introtext,postmode";

        $commonSql = " FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
            WHERE draft_flag = 0 AND date <= NOW() AND date >= '{$lastRun}'
            AND ta.type = 'article' AND ta.id = sid ";

        $topicSql = "SELECT tid FROM {$_TABLES['topics']}"
            . COM_getPermSQL('WHERE', $U['uuid']);
        $topicResult = DB_query($topicSql);
        $numTopics = DB_numRows($topicResult);

        if ($numTopics == 0) {
            // this user doesn't seem to have access to any topics ...
            continue;
        }

        $TIDS = array();
        for ($i = 0; $i < $numTopics; $i++) {
            $T = DB_fetchArray($topicResult);
            $TIDS[] = $T['tid'];
        }

        if (!empty($U['etids'])) {
            $ETIDS = explode(' ', $U['etids']);
            $TIDS = array_intersect($TIDS, $ETIDS);
        }

        if (count($TIDS) > 0) {
            // We have list of Daily Digest topic ids that user has access too and that the user wants a report on
            $commonSql .= " AND (ta.tid IN ('" . implode("','", $TIDS) . "'))";
        }

        $commonSql .= COM_getPermSQL('AND', $U['uuid']);
        $commonSql .= ' GROUP BY sid
            ORDER BY featured DESC, date DESC';

        $storySql['mysql'] .= $commonSql;
        $storySql['pgsql'] .= $commonSql;

        $stories = DB_query($storySql);
        $numArticles = DB_numRows($stories);

        if ($numArticles == 0) {
            // If no new articles where pulled for this user, continue with next
            continue;
        }

        list($date,) = COM_getUserDateTimeFormat(time(), 'shortdate');
        $mailText = $LANG08[29] . $date . "\n";

        for ($y = 0; $y < $numArticles; $y++) {
            // Loop through stories building the requested email message
            $S = DB_fetchArray($stories);

            $mailText .= "\n------------------------------\n\n";
            $mailText .= "$LANG08[31]: "
                . COM_undoSpecialChars(stripslashes($S['title'])) . "\n";
            if ($_CONF['contributedbyline'] == 1) {
                if (empty($authors[$S['uid']])) {
                    $articleAuthor = COM_getDisplayName($S['uid']);
                    $authors[$S['uid']] = $articleAuthor;
                } else {
                    $articleAuthor = $authors[$S['uid']];
                }
                $mailText .= "$LANG24[7]: " . $articleAuthor . "\n";
            }

            list($date,) = COM_getUserDateTimeFormat(strtotime($S['day']), 'date');
            $mailText .= "$LANG08[32]: " . $date . "\n\n";

            if ($_CONF['emailstorieslength'] > 0) {
                if ($S['postmode'] === 'wikitext') {
                    $articleText = COM_undoSpecialChars(GLText::stripTags(PLG_replaceTags(COM_renderWikiText(stripslashes($S['introtext'])), '', false, 'article', $S['sid'])));
                } else {
                    $articleText = COM_undoSpecialChars(GLText::stripTags(PLG_replaceTags(stripslashes($S['introtext']), '', false, 'article', $S['sid'])));
                }

                if ($_CONF['emailstorieslength'] > 1) {
                    $articleText = COM_truncate($articleText, $_CONF['emailstorieslength'], '...');
                }

                $articleText = preg_replace_callback('/<a\s+.*?href="(.*?)".*?>/i', 'COM_emailUserTopicsUrlRewriter', $articleText);
                $articleText = preg_replace_callback('/<img\s+.*?src="(.*?)".*?>/i', 'COM_emailUserTopicsUrlRewriter', $articleText);
                $mailText .= $articleText . "\n\n";
            }

            $mailText .= $LANG08[33] . ' ' . COM_buildURL($_CONF['site_url']
                    . '/article.php?story=' . $S['sid']) . "\n";
        }

        $mailText .= "\n------------------------------\n";
        $mailText .= "\n$LANG08[34]\n";
        $mailText .= "\n------------------------------\n";

        $mailTo = array($U['email'] => $U['username']);

        if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
            $mailFrom = $_CONF['noreply_mail'];
            $mailText .= LB . LB . $LANG04[159];
        } else {
            $mailFrom = $_CONF['site_mail'];
        }
        COM_mail($mailTo, $subject, $mailText, $mailFrom);
    }

    DB_query("UPDATE {$_TABLES['vars']} SET value = NOW() WHERE name = 'lastemailedstories'");
}

/**
 * Shows any new information in a block
 * Return the HTML that shows any new stories, comments, etc
 *
 * @param    string $help       Help file for block
 * @param    string $title      Title used in block header
 * @param    string $position   Position in which block is being rendered 'left', 'right' or blank (for centre)
 * @param    string $cssId      CSS ID (since GL 2.2.0, optional)
 * @param    string $cssClasses CSS class names separated by space (since GL 2.2.0, optional)
 * @return   string             Return the HTML that shows any new stories, comments, etc
 */
function COM_whatsNewBlock($help = '', $title = '', $position = '', $cssId = '', $cssClasses = '')
{
    global $_CONF, $_TABLES, $LANG01, $LANG_WHATSNEW;

    if ($_CONF['whatsnew_cache_time'] > 0) {
        $cacheInstance = 'whatsnew__' . CACHE_security_hash() . '__' . $_CONF['theme'];
        $retval = CACHE_check_instance($cacheInstance);
        if ($retval) {
            $lu = CACHE_get_instance_update($cacheInstance);
            $now = time();
            if (($now - $lu) < $_CONF['whatsnew_cache_time']) {
                return $retval;
            }
        }
    }

    $retval = COM_startBlock(
        $title, $help,
        COM_getBlockTemplate('whats_new_block', 'header', $position),
        $cssId, $cssClasses
    );
    
    $t = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'blocks/'));
    $t->set_file(array('whatsnew' => 'whatsnew.thtml'));    

    $topicSql = '';
    if (($_CONF['hidenewstories'] == 0) || ($_CONF['hidenewcomments'] == 0)
        || ($_CONF['trackback_enabled']
            && ($_CONF['hidenewtrackbacks'] == 0))
    ) {
        $topicSql = COM_getTopicSQL('AND', 0, 'ta');
    }

    if ($_CONF['hidenewstories'] == 0) {
        $where_sql = " AND ta.type = 'article' AND ta.id = sid";

        $archiveTid = DB_getItem($_TABLES['topics'], 'tid', "archive_flag=1");
        if (!empty($archiveTid)) {
            $where_sql .= " AND (ta.tid <> '$archiveTid')";
        }

        // Find the newest stories
        $sql['mysql'] = "SELECT sid, title FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
            WHERE (date >= (date_sub(NOW(), INTERVAL {$_CONF['newstoriesinterval']} SECOND))) AND (date <= NOW()) AND (draft_flag = 0)" . $where_sql . COM_getPermSQL('AND') . $topicSql . COM_getLangSQL('sid', 'AND') . "
            GROUP BY sid, title, date ORDER BY date DESC";

        $sql['pgsql'] = "SELECT sid, title FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
            WHERE (date >= (NOW() - INTERVAL '{$_CONF['newstoriesinterval']} SECOND')) AND (date <= NOW()) AND (draft_flag = 0)" . $where_sql . COM_getPermSQL('AND') . $topicSql . COM_getLangSQL('sid', 'AND') . "
            GROUP BY sid, title, date ORDER BY date DESC";

        $result = DB_query($sql);
        $numRows = DB_numRows($result);

        if (empty($title)) {
            $title = DB_getItem($_TABLES['blocks'], 'title', "name='whats_new_block'");
        }
        // Any late breaking news stories?
        $t->set_var('item', $LANG01[99]);
        $t->set_var('time-span', COM_formatTimeString($LANG_WHATSNEW['new_last'], $_CONF['newstoriesinterval']));
            
        if ($numRows > 0) {
            $newArticles = array();

            for ($x = 0; $x < $numRows; $x++) {
                $A = DB_fetchArray($result);

                $url = COM_buildURL($_CONF['site_url'] . '/article.php?story=' . $A['sid']);

                $title = COM_undoSpecialChars(stripslashes($A['title']));
                $titleToUse = COM_truncate($title, $_CONF['title_trim_length'], '...');
                if ($title != $titleToUse) {
                    $attr = array('title' => htmlspecialchars($title));
                } else {
                    $attr = array();
                }
                $anchorText = str_replace('$', '&#36;', $titleToUse);
                $anchorText = str_replace(' ', '&nbsp;', $anchorText);

                $newArticles[] = COM_createLink($anchorText, $url, $attr);
            }

            $t->set_var('new-item-list', COM_makeList($newArticles, PLG_getCSSClasses('core-list-new', 'core')));
        } else {
            $t->set_var('no-items', $LANG01[100]);
        }

        if (($_CONF['hidenewcomments'] == 0) || ($_CONF['hidenewplugins'] == 0)
            || ($_CONF['trackback_enabled']
                && ($_CONF['hidenewtrackbacks'] == 0))
        ) {
            $t->set_var('item-divider', true);
        }
        
        $retval .= $t->parse('output', 'whatsnew');
    }
    $t->clear_var('no-items');

    if ($_CONF['hidenewcomments'] == 0) {
        // Go get the newest comments
        $t->set_var('item', $LANG01[83]);
        $t->set_var('time-span', COM_formatTimeString($LANG_WHATSNEW['new_last'], $_CONF['newcommentsinterval']));            

        $new_plugin_comments = PLG_getWhatsNewComment();

        if (!empty($new_plugin_comments)) {
            // Sort array by element lastdate newest to oldest
            foreach ($new_plugin_comments as $k => $v) {
                $b[$k] = strtolower($v['lastdate']);
            }

            arsort($b);
            $temp = array();

            foreach ($b as $key => $val) {
                $temp[] = $new_plugin_comments[$key];
            }
            $new_plugin_comments = $temp;

            $newComments = array();
            $count = 0;
            foreach ($new_plugin_comments as $A) {
                $count .= +1;
                $url = '';

                $info = PLG_getItemInfo($A['type'], $A['sid'], 'url');
                if (!(empty($info))) {
                    $url = $info . '#comments';
                }

                // Check to see if url (plugin may not support PLG_getItemInfo
                if (!(empty($url))) {
                    $title = COM_undoSpecialChars(stripslashes($A['title']));
                    $titleToUse = COM_truncate($title, $_CONF['title_trim_length'],
                        '...');
                    if ($title != $titleToUse) {
                        $attr = array('title' => htmlspecialchars($title));
                    } else {
                        $attr = array();
                    }
                    $anchorComment = str_replace('$', '&#36;', $titleToUse);
                    $anchorComment = str_replace(' ', '&nbsp;', $anchorComment);

                    if ($A['dups'] > 1) {
                        $anchorComment .= ' [+' . $A['dups'] . ']';
                    }

                    $newComments[] = COM_createLink($anchorComment, $url, $attr);

                    if ($count == 15) {
                        break;
                    }
                }

            }

            $t->set_var('new-item-list', COM_makeList($newComments, PLG_getCSSClasses('core-list-new', 'core')));
        } else {
            $t->set_var('no-items', $LANG01[86]);
        }

        if (($_CONF['hidenewplugins'] == 0)
            || ($_CONF['trackback_enabled']
                && ($_CONF['hidenewtrackbacks'] == 0))
        ) {
            $t->set_var('item-divider', true);
        }
        
        $retval .= $t->parse('output', 'whatsnew');
    }
    $t->clear_var('no-items');

    if ($_CONF['trackback_enabled'] && ($_CONF['hidenewtrackbacks'] == 0)) {
        $t->set_var('item', $LANG01[114]);
        $t->set_var('time-span', COM_formatTimeString($LANG_WHATSNEW['new_last'], $_CONF['newtrackbackinterval']));              

        $sql['mysql'] = "SELECT DISTINCT COUNT(*) AS count,s.title,t.sid,max(t.date) AS lastdate
            FROM {$_TABLES['trackback']} AS t, {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta
            WHERE ta.type = 'article' AND ta.id = s.sid AND (t.type = 'article') AND (t.sid = s.sid) AND (t.date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newtrackbackinterval']} SECOND)))" . COM_getPermSQL('AND', 0, 2, 's') . " AND (s.draft_flag = 0) AND (s.trackbackcode = 0)" . $topicSql . COM_getLangSQL('sid', 'AND', 's') . "
            GROUP BY t.sid, s.title
            ORDER BY lastdate DESC LIMIT 15";

        $sql['pgsql'] = "SELECT DISTINCT COUNT(*) AS count,s.title,t.sid,max(t.date) AS lastdate
            FROM {$_TABLES['trackback']} AS t, {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta
            WHERE ta.type = 'article' AND ta.id = s.sid AND (t.type = 'article') AND (t.sid = s.sid) AND (t.date >= (NOW()+ INTERVAL '{$_CONF['newtrackbackinterval']} SECOND'))" . COM_getPermSQL('AND', 0, 2, 's') . " AND (s.draft_flag = 0) AND (s.trackbackcode = 0)" . $topicSql . COM_getLangSQL('sid', 'AND', 's') . "
            GROUP BY t.sid, s.title
            ORDER BY lastdate DESC LIMIT 15";

        $result = DB_query($sql);
        $numRows = DB_numRows($result);

        if ($numRows > 0) {
            $newComments = array();

            for ($i = 0; $i < $numRows; $i++) {
                $A = DB_fetchArray($result);
                $url = COM_buildURL($_CONF['site_url'] . '/article.php?story=' . $A['sid'])
                    . '#trackback';
                $title = COM_undoSpecialChars(stripslashes($A['title']));
                $titleToUse = COM_truncate($title, $_CONF['title_trim_length'], '...');

                if ($title != $titleToUse) {
                    $attr = array('title' => htmlspecialchars($title));
                } else {
                    $attr = array();
                }
                $anchorComment = str_replace('$', '&#36;', $titleToUse);
                $anchorComment = str_replace(' ', '&nbsp;', $anchorComment);

                if ($A['count'] > 1) {
                    $anchorComment .= ' [+' . $A['count'] . ']';
                }

                $newComments[] = COM_createLink($anchorComment, $url, $attr);
            }

            $t->set_var('new-item-list', COM_makeList($newComments, PLG_getCSSClasses('core-list-new', 'core')));
        } else {
            $t->set_var('no-items', $LANG01[115]);
        }
        if ($_CONF['hidenewplugins'] == 0) {
            $t->set_var('item-divider', true);
        }
        
        $retval .= $t->parse('output', 'whatsnew');
    }
    $t->clear_var('no-items');

    if ($_CONF['hidenewplugins'] == 0) {
        list($headlines, $smallHeadlines, $content) = PLG_getWhatsNew();
        $plugins = count($headlines);
        if ($plugins > 0) {
            for ($i = 0; $i < $plugins; $i++) {
                $t->set_var('item', $headlines[$i]);
                $t->set_var('time-span', $smallHeadlines[$i]);              
                
                if (is_array($content[$i])) {
                    $t->set_var('new-item-list', COM_makeList($content[$i], PLG_getCSSClasses('core-list-new', 'core')));
                } else {
                    // plugins already used COM_makeList on content plus add <br> on no-items text so just use new-item-list
                    $t->set_var('new-item-list', $content[$i]);
                }

                if ($i + 1 < $plugins) {
                    $t->set_var('item-divider', true);
                }
                
                $retval .= $t->parse('output', 'whatsnew');
                
                $t->clear_var('no-items');
            }
        }
    }
    
    $retval .= COM_endBlock(COM_getBlockTemplate('whats_new_block', 'footer', $position));
    if ($_CONF['whatsnew_cache_time'] > 0) {
        CACHE_create_instance($cacheInstance, $retval);
    }

    return $retval;
}

/**
 * Creates the string that indicates the timespan in which new items were found
 *
 * @param  string $time_string template string
 * @param  int    $time        number of seconds in which results are found
 * @param  string $type        type (translated string) of new item
 * @param  int    $amount      amount of things that have been found.
 * @return string
 */
function COM_formatTimeString($time_string, $time, $type = '', $amount = 0)
{
    global $LANG_WHATSNEW;

    $retval = $time_string;

    // This is the amount you have to divide the previous by to get the
    // different time intervals: minute, hour, day, week, month, year
    $time_divider = array(60, 60, 24, 7, 4, 12);

    // These are the respective strings to the numbers above. They have to match
    // the strings in $LANG_WHATSNEW (i.e. these are the keys for the array -
    // the actual text strings are taken from the language file).
    $time_description = array('minute', 'hour', 'day', 'week', 'month', 'year');
    $times_description = array('minutes', 'hours', 'days', 'weeks', 'months', 'years');

    $time_dividers = count($time_divider);
    for ($s = 0; $s < $time_dividers; $s++) {
        $time = $time / $time_divider[$s];
        if (($s + 1 >= $time_dividers) || ($time < $time_divider[$s + 1])) {
            $time = intval($time);
            if ($time == 1) {
                if ($s == 0) {
                    $time_str = $time_description[$s];
                } else {
                    // go back to the previous unit, e.g. 1 day -> 24 hours
                    $time_str = $times_description[$s - 1];
                    $time *= $time_divider[$s];
                }
            } else {
                $time_str = $times_description[$s];
            }
            $fields = array('%n', '%i', '%t', '%s');
            $values = array($amount, $type, $time, $LANG_WHATSNEW[$time_str]);
            $retval = str_replace($fields, $values, $retval);
            break;
        }
    }

    return $retval;
}

/**
 * Displays a message text in a "System Message" block
 *
 * @param    string $message Message text; may contain HTML
 * @param    string $title   (optional) alternative block title
 * @return   string              HTML block with message
 * @see      COM_showMessage
 * @see      COM_showMessageFromParameter
 */
function COM_showMessageText($message, $title = '')
{
    global $_CONF, $MESSAGE, $_IMAGE_TYPE;

    $retval = '';

    if (!empty($message)) {
        $tcc = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'controls'));
        $tcc->set_file('system_message', 'system_message.thtml');
        
        if (empty($title)) {
            $title = $MESSAGE[40];
        }
        list($timestamp,) = COM_getUserDateTimeFormat(time(), 'daytime');
        $tcc->set_var('start_block_msg', COM_startBlock($title . ' - ' . $timestamp, ''
                                       , COM_getBlockTemplate('_msg_block', 'header')));           
        
        $tcc->set_var('lang_message', $message);
        
        $tcc->set_var('end_block_msg', COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer')));
        
        $retval = $tcc->finish($tcc->parse('output', 'system_message'));        
    }

    return $retval;
}

/**
 * Displays a message on the webpage
 * Display one of the predefined messages from the $MESSAGE array. If a plugin
 * name is provided, display that plugin's message instead.
 *
 * @param    int|string  $msg    ID of message to show or a string message WHICH MUST BE SAFE AS HTML TEXT
 * @param    string      $plugin Optional name of plugin to lookup plugin defined message
 * @return   string              HTML block with message
 * @see      COM_showMessageFromParameter
 * @see      COM_showMessageText
 */
function COM_showMessage($msg, $plugin = '')
{
    global $_CONF, $MESSAGE;

    $retval = '';

    if (is_int($msg)) {
        $msg = (int) $msg;

        if ($msg > 0) {
            if (!empty($plugin)) {
                $var = 'PLG_' . $plugin . '_MESSAGE' . $msg;
                global $$var;
                if (isset($$var)) {
                    $message = $$var;
                } else {
                    $message = sprintf($MESSAGE[61], $plugin);
                    COM_errorLog($message . ": " . $var, 1);
                }
            } else {
                $message = $MESSAGE[$msg];

                // Ugly workaround for mailstory function (public_html/profiles.php)
                if ($msg === 153) {
                    $speedLimit = (int) Input::fGet('speedlimit', 0);
                    $message = sprintf($message, $speedLimit, $_CONF['speedlimit']);
                }
            }

            if (!empty($message)) {
                $retval .= COM_showMessageText($message);
            }
        }
    } elseif (is_string($msg) && !empty($msg)) {
        // $msg MUST BE SAFE AS HTML TEXT!
        $retval .= COM_showMessageText($msg);
    }

    return $retval;
}

/**
 * Displays a message, as defined by URL parameters
 * Helper function to display a message, if URL parameters 'msg' and 'plugin'
 * (optional) are defined. Only for GET requests, but that's what Geeklog uses
 * everywhere anyway.
 *
 * @return   string  HTML block with message
 * @see      COM_showMessage
 * @see      COM_showMessageText
 */
function COM_showMessageFromParameter()
{
    $retval = '';

    $msg = (int) Input::fGet('msg', 0);
    if ($msg > 0) {
        $plugin = Input::fGet('plugin', '');
        $retval .= COM_showMessage($msg, $plugin);
    }

    return $retval;
}

/**
 * Prints Google(tm)-like paging navigation
 *
 * @param  string  $base_url     base url to use for all generated links. If an array, then the current parameter
 *                               as the first part of the url, and the end is the last part of the url
 * @param  int     $currentPage  current page we are on
 * @param  int     $num_pages    Total number of pages
 * @param  string  $page_str     page-variable name AND '='
 * @param  boolean $do_rewrite   if true, url-rewriting is respected
 * @param  string  $msg          to be displayed with the navigation
 * @param  string  $open_ended   replace next/last links with this
 * @return string               HTML formatted widget
 */
function COM_printPageNavigation($base_url, $currentPage, $num_pages,
                                 $page_str = 'page=', $do_rewrite = false, $msg = '',
                                 $open_ended = '')
{
    global $_CONF, $_DEVICE, $LANG05;

    if (function_exists('CUSTOM_printPageNavigation')) {
        return CUSTOM_printPageNavigation($base_url, $currentPage, $num_pages, $page_str, $do_rewrite, $msg, $open_ended);
    }

    if ($num_pages < 2) {
        return '';
    }

    $last_url = '';
    if (is_array($base_url)) {
        $first_url = current($base_url);
        $last_url = end($base_url);
    } else {
        $first_url = $base_url;
    }

    if (!$do_rewrite) {
        $sep = strstr($first_url, '?') ? '&amp;' : '?';
    } else {
        $sep = '/';
        $page_str = '';
    }

    $page_navigation = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
    $page_navigation->set_file('page_navigation', 'pagenavigation.thtml');
    $blocks = array('page', 'page-current', 'nav-end', 'nav-open-ended', 'message');
    foreach ($blocks as $block) {
        $page_navigation->set_block('page_navigation', $block);
    }

    $page_navigation->set_var('lang_page_navigation', $LANG05[9]);
    $page_navigation->set_var('lang_first', $LANG05[7]);
    $page_navigation->set_var('lang_previous', $LANG05[6]);
    $page_navigation->set_var('lang_next', $LANG05[5]);
    $page_navigation->set_var('lang_last', $LANG05[8]);

    if ($currentPage > 1) {
        $pg = '';
        if (($currentPage - 1) > 1) {
            $pg = $sep . $page_str . ($currentPage - 1);
        }
        $page_navigation->set_var('start_first_anchortag', '<a href="' . $first_url . $last_url . '">');
        $page_navigation->set_var('end_first_anchortag', '</a>');
        $page_navigation->set_var('start_previous_anchortag', '<a href="' . $first_url . $pg . $last_url . '">');
        $page_navigation->set_var('end_previous_anchortag', '</a>');
    } else {
        $page_navigation->set_var('start_first_anchortag', '');
        $page_navigation->set_var('end_first_anchortag', '');
        $page_navigation->set_var('start_previous_anchortag', '');
        $page_navigation->set_var('end_previous_anchortag', '');
    }

    if ($_DEVICE->is_mobile()) {
        $max_pages = $_CONF['page_navigation_mobile_max_pages'];
    } else {
        $max_pages = $_CONF['page_navigation_max_pages'];
    }
    
    $page_nav_left = intval($max_pages / 2);
    $page_nav_right = $max_pages - $page_nav_left - 1;
    $page_start = $currentPage - $page_nav_left;
    $odd = 0;
    if ($page_start < 1) {
        $odd = 1 - $page_start;
        $page_start = 1;
    }
    $page_end = $currentPage + $page_nav_right + $odd;
    if ($page_end > $num_pages) {
        $odd = $page_end - $num_pages;
        $page_end = $num_pages;
        $page_start = $page_start - $odd;
        if ($page_start < 1) {
            $page_start = 1;
        }
    }
    for ($pageCount = $page_start; $pageCount <= $page_end; $pageCount++) {
        if ($pageCount == $currentPage) {
            $page_navigation->set_var('page_number', $pageCount);
            $page_navigation->parse('pages', 'page-current', true);
            continue;
        }
        $pg = '';
        if ($pageCount > 1) {
            $pg = $sep . $page_str . $pageCount;
        }
        $page_navigation->set_var('page_number', COM_createLink($pageCount, $first_url . $pg . $last_url));
        $page_navigation->parse('pages', 'page', true);
    }
    $page_navigation->set_var('page', '');
    $page_navigation->set_var('page-current', '');

    if (!empty($open_ended)) {
        $page_navigation->set_var('open_ended', $open_ended);
        $page_navigation->parse('pages', 'nav-open-ended', true);
    } else {
        if ($currentPage == $num_pages) {
            $page_navigation->set_var('start_next_anchortag', '');
            $page_navigation->set_var('end_next_anchortag', '');
            $page_navigation->set_var('start_last_anchortag', '');
            $page_navigation->set_var('end_last_anchortag', '');
        } else {
            $page_navigation->set_var('start_next_anchortag', '<a href="' . $first_url . $sep . $page_str . ($currentPage + 1) . $last_url . '">');
            $page_navigation->set_var('end_next_anchortag', '</a>');
            $page_navigation->set_var('start_last_anchortag', '<a href="' . $first_url . $sep . $page_str . $num_pages . $last_url . '">');
            $page_navigation->set_var('end_last_anchortag', '</a>');
        }
        $page_navigation->parse('pages', 'nav-end', true);
    }

    if (!empty($msg)) {
        $page_navigation->set_var('message_text', $msg . ' ');
        $page_navigation->parse('message', 'message');
    } else {
        $page_navigation->parse('message', '');
    }

    return $page_navigation->finish($page_navigation->parse('output', 'page_navigation'));
}

/**
 * Returns formatted date/time for user
 * This function COM_takes a date in either unixtimestamp or in english and
 * formats it to the users preference.  If the user didn't specify a format
 * the format in the config file is used.  This returns an array where array[0]
 * is the formatted date and array[1] is the unixtimestamp
 *
 * @param  string|int $date   date to format, otherwise we format current date/time
 * @param  string     $format (optional, since v2.1.2) any of 'date', 'daytime', 'shortdate', 'dateonly', 'timeonly'
 * @return array              array[0] is the formatted date and array[1] is the unixtimestamp.
 */
function COM_getUserDateTimeFormat($date = '', $format = 'date')
{
    global $_USER, $_CONF;
    static $isAnonUser, $isWindows, $hasMbStringFunctions, $locale;

    if (!isset($isAnonUser)) {
        $isAnonUser = COM_isAnonUser();
        $isWindows = (stripos(PHP_OS, 'WIN') === 0);
        $hasMbStringFunctions = is_callable('mb_convert_encoding');
        $locale = strtolower($_CONF['locale']);
        $dot = strpos($locale, '.');
        if ($dot !== false) {
            $locale = substr($locale, 0, $dot);
        }
    }

    // Check for format
    $format = strtolower($format);

    switch ($format) {
        case 'daytime':
            $dateFormat = $_CONF[$format];

            if (trim($dateFormat) == false) {
                $dateFormat = '%m/%d %I:%M%p';
            }
            break;

        case 'shortdate':
            $dateFormat = $_CONF[$format];

            if (trim($dateFormat) == false) {
                $dateFormat = '%x';
            }
            break;

        case 'dateonly':
            $dateFormat = $_CONF[$format];

            if (trim($dateFormat) == false) {
                $dateFormat = '%d-%b';
            }
            break;

        case 'timeonly':
            $dateFormat = $_CONF[$format];

            if (trim($dateFormat) == false) {
                $dateFormat = '%I:%M %p %Z';
            }
            break;

        case 'date':
        default:
            if ($isAnonUser) {
                $dateFormat = $_CONF[$format];
            } else {
                $dateFormat = empty($_USER['format']) ? $_CONF[$format] : $_USER['format'];
            }

            if (trim($dateFormat) == false) {
                $dateFormat = '%A, %B %d %Y @ %I:%M %p %Z';
            }
            break;
    }

    // Change %e modifier to %#d on Microsoft Windows
    if ($isWindows) {
        $dateFormat = preg_replace('#(?<!%)((?:%%)*)%e#', '\1%#d', $dateFormat);
    }

    // Check for date
    if (empty($date)) {
        // Date is empty, get current date/time
        $stamp = time();
    } elseif (is_numeric($date)) {
        // This is a timestamp
        $stamp = $date;
    } else {
        // This is a string representation of a date/time
        $stamp = strtotime($date);
    }

    // Format the date
    if ($isWindows && $hasMbStringFunctions) {
        $dateFormat = mb_convert_encoding($dateFormat, 'shift_jis', $_CONF['default_charset']);
    }
    $date = strftime($dateFormat, $stamp);

    // Additional fix for Japanese users and so on
    switch ($locale) {
        case 'ja':
        case 'ja_jp':
        case 'japanese':
            if ($isWindows && $hasMbStringFunctions) {
                $date = mb_convert_encoding($date, $_CONF['default_charset'], 'shift_jis');
            }
            break;

        default:
            break;
    }

    return array($date, $stamp);
}

/**
 * Returns user-defined cookie timeout
 * In account preferences users can specify when their long-term cookie expires.
 * This function returns that value.
 *
 * @return   int Cookie time out value in seconds
 */
function COM_getUserCookieTimeout()
{
    global $_TABLES, $_USER;

    if (COM_isAnonUser()) {
        return 0;
    }

    $timeoutValue = DB_getItem($_TABLES['users'], 'cookietimeout', "uid = {$_USER['uid']}");

    if (empty($timeoutValue)) {
        $timeoutValue = 0;
    }

    return $timeoutValue;
}

/**
 * Shows who is online in slick little block
 *
 * @return   string  HTML string of online users seperated by line breaks.
 */
function phpblock_whosonline()
{
    global $_CONF, $_TABLES, $LANG01, $_IMAGE_TYPE;

    $retval = '';

    $expire_time = time() - $_CONF['whosonline_threshold'];
    $byName = 'username';

    if ($_CONF['show_fullname'] == 1) {
        $byName .= ',fullname';
    }
    if ($_CONF['user_login_method']['openid'] || $_CONF['user_login_method']['3rdparty']) {
        $byName .= ',remoteusername,remoteservice';
    }

    $sql = "SELECT DISTINCT {$_TABLES['sessions']}.uid,{$byName},photo,showonline
            FROM {$_TABLES['sessions']},{$_TABLES['users']},{$_TABLES['userprefs']}
            WHERE {$_TABLES['users']}.uid = {$_TABLES['sessions']}.uid
            AND {$_TABLES['sessions']}.whos_online = 1
            AND {$_TABLES['users']}.uid = {$_TABLES['userprefs']}.uid AND start_time >= $expire_time
            AND {$_TABLES['sessions']}.uid <> 1 ORDER BY {$byName}";

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    $num_anon = 0;
    $num_reg = 0;

    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);

        if ($A['showonline'] == 1) {
            $fullname = '';
            if ($_CONF['show_fullname'] == 1) {
                $fullname = $A['fullname'];
            }
            if ($_CONF['user_login_method']['openid'] || $_CONF['user_login_method']['3rdparty']) {
                $username = COM_getDisplayName($A['uid'], $A['username'],
                    $fullname, $A['remoteusername'], $A['remoteservice']);
            } else {
                $username = COM_getDisplayName($A['uid'], $A['username'], $fullname);
            }
            $retval .= COM_getProfileLink($A['uid'], $username, $fullname, '');

            if (!empty($A['photo']) && ($_CONF['allow_user_photo'] == 1)) {
                if ($_CONF['whosonline_photo'] == true) {
                    $userImage = '<img src="' . $_CONF['site_url']
                        . '/images/userphotos/' . $A['photo']
                        . '" alt="" height="30" width="30"' . XHTML . '>';
                } else {
                    $userImage = '<img src="' . $_CONF['layout_url']
                        . '/images/smallcamera.' . $_IMAGE_TYPE
                        . '" alt=""' . XHTML . '>';
                }

                require_once $_CONF['path_system'] . 'lib-user.php';

                if (!USER_isBanned($A['uid'])) {
                    $url = $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['uid'];
                    $retval .= '&nbsp;' . COM_createLink($userImage, $url);
                }
            }
            $retval .= '<br' . XHTML . '>';
            $num_reg++;
        } else {
            // this user does not want to show up in Who's Online
            $num_anon++; // count as anonymous
        }
    }

    $num_anon += DB_count($_TABLES['sessions'], array('uid', 'whos_online'), array(1, 1));

    if (($_CONF['whosonline_anonymous'] == 1) && COM_isAnonUser()) {
        // note that we're overwriting the contents of $retval here
        if ($num_reg > 0) {
            $retval = $LANG01[112] . ': ' . COM_numberFormat($num_reg)
                . '<br' . XHTML . '>';
        } else {
            $retval = '';
        }
    }

    if ($num_anon > 0) {
        $retval .= $LANG01[41] . ': ' . COM_numberFormat($num_anon)
            . '<br' . XHTML . '>';
    }

    return $retval;
}

/**
 * Gets the <option> values for calendar months
 *
 * @param  string $selected Selected month
 * @see    function COM_getDayFormOptions
 * @see    function COM_getYearFormOptions
 * @see    function COM_getHourFormOptions
 * @see    function COM_getMinuteFormOptions
 * @return string HTML Months as option values
 */
function COM_getMonthFormOptions($selected = '')
{
    global $LANG_MONTH;

    $month_options = '';

    for ($i = 1; $i <= 12; $i++) {
        $mval = $i;
        $month_options .= '<option value="' . $mval . '"';

        if ($i == $selected) {
            $month_options .= ' selected="selected"';
        }

        $month_options .= '>' . $LANG_MONTH[$mval] . '</option>';
    }

    return $month_options;
}

/**
 * Gets the <option> values for calendar days
 *
 * @param  string $selected Selected day
 * @see    function COM_getMonthFormOptions
 * @see    function COM_getYearFormOptions
 * @see    function COM_getHourFormOptions
 * @see    function COM_getMinuteFormOptions
 * @return string HTML days as option values
 */
function COM_getDayFormOptions($selected = '')
{
    $day_options = '';

    for ($i = 1; $i <= 31; $i++) {
        if ($i < 10) {
            $dval = '0' . $i;
        } else {
            $dval = $i;
        }

        $day_options .= '<option value="' . $dval . '"';

        if ($i == $selected) {
            $day_options .= ' selected="selected"';
        }

        $day_options .= '>' . $dval . '</option>';
    }

    return $day_options;
}

/**
 * Gets the <option> values for calendar years
 * Returns Option list Containing 5 years starting with current
 * unless @selected is < current year then starts with @selected
 *
 * @param  string $selected    Selected year
 * @param  int    $startOffset Optional (can be +/-) Used to determine start year for range of years
 * @param  int    $endOffset   Optional (can be +/-) Used to determine end year for range of years
 * @see    function COM_getMonthFormOptions
 * @see    function COM_getDayFormOptions
 * @see    function COM_getHourFormOptions
 * @see    function COM_getMinuteFormOptions
 * @return string  HTML years as option values
 */
function COM_getYearFormOptions($selected = '', $startOffset = -1, $endOffset = 5)
{
    $year_options = '';
    $start_year = date('Y') + $startOffset;
    $cur_year = date('Y', time());
    $finish_year = $cur_year + $endOffset;

    if (!empty($selected)) {
        if ($selected < $cur_year) {
            $start_year = $selected;
        }
    }

    for ($i = $start_year; $i <= $finish_year; $i++) {
        $year_options .= '<option value="' . $i . '"';

        if ($i == $selected) {
            $year_options .= ' selected="selected"';
        }

        $year_options .= '>' . $i . '</option>';
    }

    return $year_options;
}

/**
 * Gets the <option> values for clock hours
 *
 * @param    string $selected Selected hour
 * @param    int    $mode     12 or 24 hour mode
 * @return   string              HTML string of options
 * @see      function COM_getMonthFormOptions
 * @see      function COM_getDayFormOptions
 * @see      function COM_getYearFormOptions
 * @see      function COM_getMinuteFormOptions
 */
function COM_getHourFormOptions($selected = '', $mode = 12)
{
    $hour_options = '';

    if ($mode == 12) {
        for ($i = 1; $i <= 11; $i++) {
            if ($i < 10) {
                $hval = '0' . $i;
            } else {
                $hval = $i;
            }

            if ($i == 1) {
                $hour_options .= '<option value="12"';

                if ($selected == 12) {
                    $hour_options .= ' selected="selected"';
                }

                $hour_options .= '>12</option>';
            }

            $hour_options .= '<option value="' . $hval . '"';

            if ($selected == $i) {
                $hour_options .= ' selected="selected"';
            }

            $hour_options .= '>' . $i . '</option>';
        }
    } else { // if( $mode == 24 )
        for ($i = 0; $i < 24; $i++) {
            if ($i < 10) {
                $hval = '0' . $i;
            } else {
                $hval = $i;
            }

            $hour_options .= '<option value="' . $hval . '"';

            if ($selected == $i) {
                $hour_options .= ' selected="selected"';
            }

            $hour_options .= '>' . $i . '</option>';
        }
    }

    return $hour_options;
}

/**
 * Gets the <option> values for clock minutes
 *
 * @param    string $selected Selected minutes
 * @param    int    $step     number of minutes between options, e.g. 15
 * @see      function COM_getMonthFormOptions
 * @see      function COM_getDayFormOptions
 * @see      function COM_getHourFormOptions
 * @see      function COM_getYearFormOptions
 * @return   string HTML of option minutes
 */
function COM_getMinuteFormOptions($selected = '', $step = 1)
{
    $minute_options = '';

    if (($step < 1) || ($step > 30)) {
        $step = 1;
    }

    for ($i = 0; $i <= 59; $i += $step) {
        if ($i < 10) {
            $mval = '0' . $i;
        } else {
            $mval = $i;
        }

        $minute_options .= '<option value="' . $mval . '"';

        if ($selected == $i) {
            $minute_options .= ' selected="selected"';
        }

        $minute_options .= '>' . $mval . '</option>';
    }

    return $minute_options;
}

/**
 * For backward compatibility only.
 * This function should always have been called COM_getMinuteFormOptions
 *
 * @param  string $selected
 * @param  int    $step
 * @return string
 * @see        COM_getMinuteFormOptions
 * @deprecated Use COM_getMinuteFormOptions instead
 */
function COM_getMinuteOptions($selected = '', $step = 1)
{
    COM_deprecatedLog(__FUNCTION__, '2.1.2', '3.0.0', 'COM_getMinuteFormOptions');

    return COM_getMinuteFormOptions($selected, $step);
}

/**
 * Create an am/pm selector dropdown menu
 *
 * @param    string $name     name of the <select>
 * @param    string $selected preselection: 'am' or 'pm'
 * @return   string  HTML for the dropdown; empty string in 24 hour mode
 */
function COM_getAmPmFormSelection($name, $selected = '')
{
    global $_CONF;

    $retval = '';

    if (isset($_CONF['hour_mode']) && ($_CONF['hour_mode'] == 24)) {
        $retval = '';
    } else {
        if (empty($selected)) {
            $selected = date('a');
        }

        $retval .= '<option value="am"';
        if ($selected === 'am') {
            $retval .= ' selected="selected"';
        }
        $retval .= '>am</option>' . LB . '<option value="pm"';
        if ($selected === 'pm') {
            $retval .= ' selected="selected"';
        }
        $retval .= '>pm</option>' . LB;

        $retval = COM_createControl('type-select', array(
            'name' => $name,
            'select_items' => $retval
        ));
    }

    return $retval;
}

/**
 * Creates an HTML unordered list from the given array.
 * It formats one list item per array element, using the list.thtml template
 *
 * @param    array  $listOfItems Items to list out
 * @param    string $className   optional CSS class name for the list
 * @return   string              HTML unordered list of array items
 * @see      PLG_getCSSClasses   Use this function to pass in $className set by the theme or plugin theme
 */
function COM_makeList($listOfItems, $className = '')
{
    global $_CONF;

    $list = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
    $list->set_file(array('list' => 'list.thtml'));
    $list->set_block('list', 'listitem');

    if (empty($className)) {
        $list->set_var('list_class', '');
        $list->set_var('list_class_name', '');
    } else {
        $list->set_var('list_class', 'class="' . $className . '"');
        $list->set_var('list_class_name', $className);
    }

    if (is_array($listOfItems)) {
        foreach ($listOfItems as $oneitem) {
            $list->set_var('list_item', $oneitem);
            $list->parse('list_items', 'listitem', true);
        }
    }

    $list->parse('newlist', 'list', true);

    return $list->finish($list->get_var('newlist'));
}

/**
 * Check if speed limit applies
 *
 * @param    string $type     type of speed limit, e.g. 'submit', 'comment'
 * @param    int    $max      max number of allowed tries within speed limit
 * @param    string $property IP address or other identifiable property
 * @return   int              0: does not apply, else: seconds since last post
 */
function COM_checkSpeedlimit($type = 'submit', $max = 1, $property = '')
{
    global $_TABLES;

    $last = 0;

    // Allow some admins to bypass speed check
    if (SEC_inGroup('Root')) {
        return $last;
    }

    if (($type === 'comment') && SEC_inGroup('Comment Admin')) {
        return $last;
    }

    if (($type === 'submit') && SEC_inGroup('Story Admin')) {
        return $last;
    }

    if (empty($property)) {
        $property = $_SERVER['REMOTE_ADDR'];
    }
    $property = DB_escapeString($property);

    $res = DB_query("SELECT date FROM {$_TABLES['speedlimit']} WHERE (type = '$type') AND (ipaddress = '$property') ORDER BY date ASC");

    // If the number of allowed tries has not been reached,
    // return 0 (didn't hit limit)
    if (DB_numRows($res) < $max) {
        return $last;
    }

    list($date) = DB_fetchArray($res);

    if (!empty($date)) {
        $last = time() - $date;
        if ($last == 0) {
            // just in case someone manages to submit something in < 1 sec.
            $last = 1;
        }
    }

    return $last;
}

/**
 * Store post info for speed limit
 *
 * @param    string $type     type of speed limit, e.g. 'submit', 'comment'
 * @param    string $property IP address or other identifiable property
 */
function COM_updateSpeedlimit($type = 'submit', $property = '')
{
    global $_TABLES;

    if (empty($property)) {
        $property = $_SERVER['REMOTE_ADDR'];
    }

    $property = DB_escapeString($property);
    $type = DB_escapeString($type);
    $sql = "INSERT INTO {$_TABLES['speedlimit']} (ipaddress, date, type) "
        . "VALUES ('{$property}', UNIX_TIMESTAMP(), '{$type}') ";
    DB_query($sql);
}

/**
 * Clear out expired speed limits, i.e. entries older than 'x' seconds
 *
 * @param  int    $speedLimit number of seconds
 * @param  string $type       type of speed limit, e.g. 'submit', 'comment'
 */
function COM_clearSpeedlimit($speedLimit = 60, $type = '')
{
    global $_TABLES;

    $sql = "DELETE FROM {$_TABLES['speedlimit']} WHERE ";
    if (!empty($type)) {
        $sql .= "(type = '$type') AND ";
    }
    $sql .= "(date < UNIX_TIMESTAMP() - {$speedLimit})";
    DB_query($sql);
}

/**
 * Reset the speedlimit
 *
 * @param    string $type     type of speed limit to reset, e.g. 'submit'
 * @param    string $property IP address or other identifiable property
 */
function COM_resetSpeedlimit($type = 'submit', $property = '')
{
    global $_TABLES;

    if (empty($property)) {
        $property = $_SERVER['REMOTE_ADDR'];
    }
    $property = DB_escapeString($property);

    DB_delete($_TABLES['speedlimit'], array('type', 'ipaddress'),
        array($type, $property));
}

/**
 * Wrapper function for URL class so as to not confuse people as this will
 * eventually get used all over the place
 * This function returns a crawler friendly URL (if possible)
 *
 * @param    string $url URL to try to build crawler friendly URL for
 * @return   string              Rewritten URL
 */
function COM_buildURL($url)
{
    global $_URL;

    return $_URL->buildURL($url);
}

/**
 * Wrapper function for URL class so as to not confuse people
 * This function sets the name of the arguments found in url
 *
 * @param    array $names Names of arguments in query string to assign to values
 * @return   boolean      True if successful
 */
function COM_setArgNames(array $names)
{
    global $_URL;

    return $_URL->setArgNames($names);
}

/**
 * Wrapper function for URL class
 * returns value for specified argument
 *
 * @param    string $name argument to get value for
 * @return   string       Argument value
 */
function COM_getArgument($name)
{
    global $_URL;

    return $_URL->getArgument($name);
}

/**
 * Occurrences / time
 * This will take a number of occurrences, and number of seconds for the time span and return
 * the smallest #/time interval
 *
 * @param    int $occurrences how many occurrences during time interval
 * @param    int $timeSpan    time interval in seconds
 * @return   int              Seconds per interval
 */
function COM_getRate($occurrences, $timeSpan)
{
    // want to define some common time words (yes, dirk, i need to put this in LANG)
    // time words and their value in seconds
    // week is 7 * day, month is 30 * day, year is 365.25 * day
    $common_time = array(
        'second' => 1,
        'minute' => 60,
        'hour'   => 3600,
        'day'    => 86400,
        'week'   => 604800,
        'month'  => 2592000,
        'year'   => 31557600,
    );

    if ($occurrences != 0) {
        $rate = (int) ($timeSpan / $occurrences);
        $adjustedRate = $occurrences + 1;
        $time_unit = 'second';

        foreach ($common_time as $unit => $seconds) {
            if ($rate > $seconds) {
                $foo = (int) (($rate / $seconds) + .5);

                if (($foo < $occurrences) && ($foo > 0)) {
                    $adjustedRate = $foo;
                    $time_unit = $unit;
                }
            }
        }

        $singular = '1 shout every ' . $adjustedRate . ' ' . $time_unit;

        if ($adjustedRate > 1) {
            $singular .= 's';
        }
    } else {
        $singular = 'No events';
    }

    return $singular;
}

/**
 * Check for Tag usuage permissions.
 * This function takes the usuage access info of the autotag passed to it
 * and let's us know if the user has access to use the autotag.
 *
 * @param        int $owner_id     ID of the owner of object
 * @param        int $group_id     ID of group object belongs to
 * @param        int $perm_owner   Permissions the owner has
 * @param        int $perm_group   Permissions the gorup has
 * @param        int $perm_members Permissions logged in members have
 * @param        int $perm_anon    Permissions anonymous users have
 * @param        int $u_id         User ID to get information for. If empty current user.
 * @return       int               returns true if user has access
 */
function COM_getPermTag($owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon, $u_id = 0)
{
    global $_USER, $_GROUPS;

    $retval = false;
    $access = 2;

    if ($u_id <= 0) {
        $uid = COM_isAnonUser() ? 1 : $_USER['uid'];
    } else {
        $uid = $u_id;
    }

    if ((empty($_USER['uid']) && ($uid == 1)) || ($uid == $_USER['uid'])) {
        if (empty($_GROUPS)) {
            $_GROUPS = SEC_getUserGroups($uid);
        }
        $UserGroups = $_GROUPS;
    } else {
        $UserGroups = SEC_getUserGroups($uid);
    }

    if (empty($UserGroups)) {
        // this shouldn't really happen, but if it does, handle user
        // like an anonymous user
        $uid = 1;
    }

    if (SEC_inGroup('Root', $uid)) {
        return true;
    } else {
        if ($uid > 1) {
            if (($owner_id == $uid) && ($perm_owner >= $access)) {
                return true;
            }

            if ((in_array($group_id, $UserGroups)) && ($perm_group >= $access)) {
                return true;
            }

            if ($perm_members >= $access) {
                return true;
            }
        } else {
            if ($perm_anon >= $access) {
                return true;
            }
        }
    }

    return $retval;
}

/**
 * Return SQL expression to check for permissions.
 * Creates part of an SQL expression that can be used to request items with the
 * standard set of Geeklog permissions.
 *
 * @param        string $type   part of the SQL expr. e.g. 'WHERE', 'AND'
 * @param        int    $u_id   user id or 0 = current user
 * @param        int    $access access to check for (2=read, 3=r&write)
 * @param        string $table  table name if ambiguous (e.g. in JOINs)
 * @return       string         SQL expression string (may be empty)
 */
function COM_getPermSQL($type = 'WHERE', $u_id = 0, $access = 2, $table = '')
{
    global $_USER, $_GROUPS;

    if (!empty($table)) {
        $table .= '.';
    }
    if ($u_id <= 0) {
        if (COM_isAnonUser()) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    } else {
        $uid = $u_id;
    }

    if ((empty($_USER['uid']) && ($uid == 1)) || ($uid == $_USER['uid'])) {
        if (empty($_GROUPS)) {
            $_GROUPS = SEC_getUserGroups($uid);
        }
        $UserGroups = $_GROUPS;
    } else {
        $UserGroups = SEC_getUserGroups($uid);
    }

    if (empty($UserGroups)) {
        // this shouldn't really happen, but if it does, handle user
        // like an anonymous user
        $uid = 1;
    }

    if (SEC_inGroup('Root', $uid)) {
        return '';
    }

    $sql = ' ' . $type . ' (';

    if ($uid > 1) {
        $sql .= "(({$table}owner_id = '{$uid}') AND ({$table}perm_owner >= $access)) OR ";
        $sql .= "(({$table}group_id IN (" . implode(',', $UserGroups)
            . ")) AND ({$table}perm_group >= $access)) OR ";
        $sql .= "({$table}perm_members >= $access)";
    } else {
        $sql .= "{$table}perm_anon >= $access";
    }

    $sql .= ')';

    return $sql;
}

/**
 * Return SQL expression to check for allowed topics.
 * Creates part of an SQL expression that can be used to only request items (like articles)
 * from topics to which the user has access to.
 * Note that this function does an SQL request, so you should cache
 * the resulting SQL expression if you need it more than once.
 *
 * @param    string $type  part of the SQL expr. e.g. 'WHERE', 'AND'
 * @param    int    $u_id  user id or 0 = current user
 * @param    string $table table name if ambiguous (e.g. in JOINs)
 * @return   string        SQL expression string (may be empty)
 */
function COM_getTopicSQL($type = 'WHERE', $u_id = 0, $table = '')
{
    global $_TABLES, $_USER, $_GROUPS;

    $topicSql = ' ' . $type . ' ';

    if (!empty($table)) {
        $table .= '.';
    }

    if (($u_id <= 0) || (isset($_USER['uid']) && ($u_id == $_USER['uid']))) {
        if (!COM_isAnonUser()) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }
        $UserGroups = $_GROUPS;
    } else {
        $uid = $u_id;
        $UserGroups = SEC_getUserGroups($uid);
    }

    if (empty($UserGroups)) {
        // this shouldn't really happen, but if it does, handle user
        // like an anonymous user
        $uid = 1;
    }

    if (SEC_inGroup('Root', $uid)) {
        return '';
    }

    $result = DB_query("SELECT tid FROM {$_TABLES['topics']}"
        . COM_getPermSQL('WHERE', $uid));
    $tids = array();
    while ($T = DB_fetchArray($result)) {
        $tids[] = $T['tid'];
    }

    if (count($tids) > 0) {
        $topicSql .= "({$table}tid IN ('" . implode("','", $tids) . "'))";
    } else {
        $topicSql .= '0';
    }

    return $topicSql;
}

/**
 * Strip slashes from a string only when magic_quotes_gpc = on.
 *
 * @param   string $text The text
 * @return  string|array The text, possibly without slashes.
 */
function COM_stripslashes($text)
{
    if (@get_magic_quotes_gpc()) {
        if (is_array($text)) {
            return array_map('stripslashes', $text);
        } else {
            return stripslashes($text);
        }
    }

    return $text;
}

/**
 * Filter parameters passed per GET (URL) or POST.
 *
 * @param    string  $parameter the parameter to test
 * @param    boolean $isNumeric true if $parameter is supposed to be numeric
 * @return   string             the filtered parameter (may now be empty or 0)
 * @see      COM_applyBasicFilter
 */
function COM_applyFilter($parameter, $isNumeric = false)
{
    $p = COM_stripslashes($parameter);

    return COM_applyBasicFilter($p, $isNumeric);
}

/**
 * Filter parameters
 * NOTE:     Use this function instead of COM_applyFilter for parameters
 *           _not_ coming in through a GET or POST request.
 *
 * @param    string  $parameter the parameter to test
 * @param    boolean $isNumeric true if $parameter is supposed to be numeric
 * @return   string    the filtered parameter (may now be empty or 0)
 * @see      COM_applyFilter
 */
function COM_applyBasicFilter($parameter, $isNumeric = false)
{
    $log_manipulation = false; // set to true to log when the filter applied

    $p = GLText::remove4byteUtf8Chars($parameter);
    $p = GLText::stripTags($p);
    $p = COM_killJS($p); // doesn't help a lot right now, but still ...

    if ($isNumeric) {
        // Note: PHP's is_numeric() accepts values like 4e4 as numeric
        if (!is_numeric($p) || (preg_match('/^-?\d+$/', $p) == 0)) {
            $p = 0;
        }
    } else {
        $p = preg_replace('/\/\*.*/', '', $p);
        $pa = explode("'", $p);
        $pa = explode('"', $pa[0]);
        $pa = explode('`', $pa[0]);
        $pa = explode(';', $pa[0]);
        $pa = explode(',', $pa[0]);
        $pa = explode('\\', $pa[0]);
        $p = $pa[0];
    }

    if ($log_manipulation) {
        if (strcmp($p, $parameter) != 0) {
            COM_errorLog("Filter applied: >> {$parameter} << filtered to {$p} [IP {$_SERVER['REMOTE_ADDR']}]", 1);
        }
    }

    return $p;
}

/**
 * Sanitize a URL
 *
 * @param    string       $url               URL to sanitized
 * @param    array|string $allowed_protocols array of allowed protocols
 * @param    string       $default_protocol  replacement protocol (default: http)
 * @return   string                           sanitized URL
 */
function COM_sanitizeUrl($url, $allowed_protocols = '', $default_protocol = '')
{
    global $_CONF;

    if (empty($allowed_protocols)) {
        $allowed_protocols = $_CONF['allowed_protocols'];
    } elseif (!is_array($allowed_protocols)) {
        $allowed_protocols = array($allowed_protocols);
    }

    if (empty($default_protocol)) {
        $default_protocol = 'http:';
    } elseif (substr($default_protocol, -1) !== ':') {
        $default_protocol .= ':';
    }

    $url = GLText::stripTags($url);
    if (!empty($url)) {
        $pos = MBYTE_strpos($url, ':');
        if ($pos === false) {
            $url = $default_protocol . '//' . $url;
        } else {
            $protocol = MBYTE_substr($url, 0, $pos + 1);
            $found_it = false;
            foreach ($allowed_protocols as $allowed) {
                if (substr($allowed, -1) !== ':') {
                    $allowed .= ':';
                }
                if ($protocol == $allowed) {
                    $found_it = true;
                    break;
                }
            }
            if (!$found_it) {
                $url = $default_protocol . MBYTE_substr($url, $pos + 1);
            }
        }
    }

    return $url;
}

/**
 * Ensure an ID contains only alphanumeric characters, dots, dashes, or underscores
 *
 * @param    string  $id                    the ID to sanitize
 * @param    boolean $new_id                true = create a new ID in case we end up with an empty string
 * @param    boolean $multilang_support     For new id only. Does item that id is for support Geeklog multiple languages
 * @return   string                         the sanitized ID
 */
function COM_sanitizeID($id, $new_id = true, $multilang_support = false)
{
    $id = str_replace(' ', '', $id);
    $id = str_replace(array('/', '\\', ':', '+'), '-', $id);
    $id = preg_replace('/[^a-zA-Z0-9\-_\.]/', '', $id);

    if (empty($id) && $new_id) {
        $id = COM_makesid($multilang_support);
    }

    return $id;
}

/**
 * Sanitize a filename.
 * NOTE:     This function is pretty strict in what it allows. Meant to be used
 *           for files to be included where part of the filename is dynamic.
 *
 * @param    string  $filename   the filename to clean up
 * @param    boolean $allow_dots whether to allow dots in the filename or not
 * @return   string              sanitized filename
 */
function COM_sanitizeFilename($filename, $allow_dots = false)
{
    if ($allow_dots) {
        $filename = preg_replace('/[^a-zA-Z0-9\-_\.]/', '', $filename);
        $filename = str_replace('..', '', $filename);
    } else {
        $filename = preg_replace('/[^a-zA-Z0-9\-_]/', '', $filename);
    }

    return $filename;
}

/**
 * Detect links in a plain-ascii text and turn them into clickable links.
 * Will detect links starting with "http:", "https:", "ftp:", and "www.".
 *
 * @param    string $text the (plain-ascii) text string
 * @return   string       the same string, with links enclosed in <a>...</a> tags
 */
function COM_makeClickableLinks($text)
{
    global $_CONF;

    if (!$_CONF['clickable_links']) {
        return $text;
    }

    // These regular expressions will work for this purpuse, but
    // they should NOT be used for validating links.

    // Matches anything starting with http:// or https:// or ftp:// or ftps://
    $regex = '/(?<=^|[\n\r\t\s\(\)\[\]<>";])((?:(?:ht|f)tps?:\/{2})(?:[^\n\r\t\s\(\)\[\]<>"&]+(?:&amp;)?)+)(?=[\n\r\t\s\(\)\[\]<>"&]|$)/i';
    $text = preg_replace_callback($regex, function ($match) {
        return COM_makeClickableLinksCallback('', $match[1]);
    }, $text);

    return $text;
}

/**
 * Callback function to help format links in COM_makeClickableLinks
 *
 * @param    string $http set to 'http://' when not already in the url
 * @param    string $link the url
 * @return   string       link enclosed in <a>...</a> tags
 */
function COM_makeClickableLinksCallback($http, $link)
{
    global $_CONF;
    static $encoding = null;

    if ($encoding === null) {
        $encoding = COM_getEncodingt();
    }

    // When $link ends with a period, the period will be moved out of the link
    // text (bug #0001675)
    if (substr($link, -1) === '.') {
        $link = substr($link, 0, -1);
        $end = '.';
    } else {
        $end = '';
    }

    if ($_CONF['linktext_maxlen'] > 0) {
        $text = COM_truncate($link, $_CONF['linktext_maxlen'], '...', 10);
    } else {
        $text = $link;
    }

    $text = htmlspecialchars($text, ENT_QUOTES, $encoding);

    return '<a href="' . $http . $link . '">' . $text . '</a>' . $end;
}

/**
 * Undo the conversion of URLs to clickable links (in plain text posts),
 * e.g. so that we can present the user with the post as they entered them.
 *
 * @param    string $text story text
 * @return   string       story text without links
 */
function COM_undoClickableLinks($text)
{
    $text = preg_replace('/<a href="([^"]*)">([^<]*)<\/a>/', '\1', $text);

    return $text;
}

/**
 * Highlight the words from a search query in a given text string.
 *
 * @param    string $text  the text
 * @param    string $query the search query
 * @param    string $class html class to use to highlight
 * @return   string        the text with highlighted search words
 */
function COM_highlightQuery($text, $query, $class = 'highlight')
{
    if (!empty($text) && !empty($query)) {
        // escape PCRE special characters
        $query = preg_quote($query, '/');

        $myWords = explode(' ', $query);
        foreach ($myWords as $myWord) {
            if (!empty($myWord)) {
                $before = "/(?!(?:[^<]+>|[^>]+<\/a>))\b";
                $after = "\b/i";
                if ($myWord !== utf8_encode($myWord)) {
                    if (@preg_match('/^\pL$/u', urldecode('%C3%B1'))) {
                        // Unicode property support
                        $before = "/(?<!\p{L})";
                        $after = "(?!\p{L})/u";
                    } else {
                        $before = "/";
                        $after = "/u";
                    }
                }
                $text = preg_replace($before . $myWord . $after,
                    "<span class=\"$class\">\\0</span>",
                    '<!-- x -->' . $text . '<!-- x -->');
            }
        }
    }

    return $text;
}

/**
 * Determines the difference between two dates.
 * This will takes either unixtimestamps or English dates as input and will
 * automatically do the date diff on the more recent of the two dates (e.g. the
 * order of the two dates given doesn't matter).
 *
 * @author Tony Bibbs, tony DOT bibbs AT iowa DOT gov
 * @access public
 * @param string      $interval Can be:
 *                              y = year
 *                              m = month
 *                              w = week
 *                              h = hours
 *                              i = minutes
 *                              s = seconds
 * @param  string|int $date1    English date (e.g. 10 Dec 2004) or unixtimestamp
 * @param  string|int $date2    English date (e.g. 10 Dec 2004) or unixtimestamp
 * @return int                  Difference of the two dates in the unit of time indicated by the interval
 */
function COM_dateDiff($interval, $date1, $date2)
{
    // Convert dates to timestamps, if needed.
    if (!is_numeric($date1)) {
        $date1 = strtotime($date1);
    }

    if (!is_numeric($date2)) {
        $date2 = strtotime($date2);
    }

    // Function roughly equivalent to the ASP "DateDiff" function
    if ($date2 > $date1) {
        $seconds = $date2 - $date1;
    } else {
        $seconds = $date1 - $date2;
    }

    switch ($interval) {
        case 'y':
            list($year1, $month1, $day1) = explode('-', date('Y-m-d', $date1));
            list($year2, $month2, $day2) = explode('-', date('Y-m-d', $date2));
            $time1 = (date('H', $date1) * 3600) + (date('i', $date1) * 60) + (date('s', $date1));
            $time2 = (date('H', $date2) * 3600) + (date('i', $date2) * 60) + (date('s', $date2));
            $diff = $year2 - $year1;
            if ($month1 > $month2) {
                $diff -= 1;
            } elseif ($month1 == $month2) {
                if ($day1 > $day2) {
                    $diff -= 1;
                } elseif ($day1 == $day2) {
                    if ($time1 > $time2) {
                        $diff -= 1;
                    }
                }
            }
            break;

        case 'm':
            list($year1, $month1, $day1) = explode('-', date('Y-m-d', $date1));
            list($year2, $month2, $day2) = explode('-', date('Y-m-d', $date2));
            $time1 = (date('H', $date1) * 3600) + (date('i', $date1) * 60) + (date('s', $date1));
            $time2 = (date('H', $date2) * 3600) + (date('i', $date2) * 60) + (date('s', $date2));
            $diff = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
            if ($day1 > $day2) {
                $diff -= 1;
            } elseif ($day1 == $day2) {
                if ($time1 > $time2) {
                    $diff -= 1;
                }
            }
            break;

        case 'w':
            // Only simple seconds calculation needed from here on
            $diff = floor($seconds / 604800);
            break;

        case 'd':
            $diff = floor($seconds / 86400);
            break;

        case 'h':
            $diff = floor($seconds / 3600);
            break;

        case 'i':
            $diff = floor($seconds / 60);
            break;

        case 's':
            $diff = $seconds;
            break;
    }

    return $diff;
}

/**
 * Delete all files and folders in a folder except those specified otherwise
 *
 * @since  Geeklog-2.2.0
 * @param  string   $dir            Directory to clean of files and folders
 * @param  array    $leave_dirs     Array of directory names to not delete
 * @param  array    $leave_files    Array of file names to not delete
 */
function COM_cleanDirectory($dir, $leave_dirs = array(), $leave_files = array()) 
{ 
    // Need to array merge glob to include regular file list AND hidden file lists (that ignore '.' and '..')
    $merged = array_merge(glob(rtrim($dir, '/') . '/*'), glob(rtrim($dir, '/') . '/{*,.[!.]*,..?*}', GLOB_BRACE));
    foreach ($merged as $file) {
        if (is_dir($file)) {
            if (!in_array(basename($file), $leave_dirs)) {
                COM_deleteFiles($file); // delete all sub directories and files in those directories
            }
        } elseif (!in_array(basename($file), $leave_files) ) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}

/**
 * Delete all files and folders including original folder (recursive calls)
 *
 * @since  Geeklog-2.2.0
 * @param  string   $dir            Directory to clean of files and folders
 */
function COM_deleteFiles($dir)
{ 
    $merged = array_merge(glob(rtrim($dir, '/') . '/*'), glob(rtrim($dir, '/') . '/{*,.[!.]*,..?*}', GLOB_BRACE));
    foreach ($merged as $file) {  
        if (is_dir($file)) {
            COM_deleteFiles($file); 
        } else {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
    rmdir($dir); 
}

/**
 * Determine if running via AJAX call
 *
 * @since  Geeklog-2.1.2
 * @return bool   true if AJAX or false otherwise
 */
function COM_isAjax()
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Try to figure out our current URL, including all parameters.
 * This is an ugly hack since there's no single variable that returns what
 * we want and the variables used here may not be available on all servers
 * and / or setups.
 * Seems to work on Apache (1.3.x and 2.x), nginx, and IIS.
 *
 * @return   string  complete URL, e.g. 'http://www.example.com/blah.php?foo=bar'
 */
function COM_getCurrentURL()
{
    global $_CONF;
    static $thisUrl;

    if ($thisUrl !== null) {
        return $thisUrl;
    }

    $thisUrl = '';

    if (empty($_SERVER['SCRIPT_URI'])) {
        if (!empty($_SERVER['DOCUMENT_URI'])) {
            $document_uri = $_SERVER['DOCUMENT_URI'];
            $firstSlash = strpos($_CONF['site_url'], '/');

            if ($firstSlash === false) {
                // special case - assume it's okay
                $thisUrl = $_CONF['site_url'] . $document_uri;
            } elseif ($firstSlash + 1 == strrpos($_CONF['site_url'], '/')) {
                // site is in the document root
                $thisUrl = $_CONF['site_url'] . $document_uri;
            } else {
                // extract server name first
                $pos = strpos($_CONF['site_url'], '/', $firstSlash + 2);
                $thisUrl = substr($_CONF['site_url'], 0, $pos) . $document_uri;
            }
        }
    } else {
        $thisUrl = $_SERVER['SCRIPT_URI'];
    }

    if (!empty($thisUrl) && !empty($_SERVER['QUERY_STRING'])) {
        $thisUrl .= '?' . $_SERVER['QUERY_STRING'];
    }

    if (empty($thisUrl)) {
        $requestUri = $_SERVER['REQUEST_URI'];
        if (empty($_SERVER['REQUEST_URI'])) {
            if (empty($_SERVER['PATH_INFO'])) {
                $requestUri = $_SERVER['SCRIPT_NAME'];
            } else {
                $requestUri = $_SERVER['PATH_INFO'];
            }

            if (!empty($_SERVER['QUERY_STRING'])) {
                $requestUri .= '?' . $_SERVER['QUERY_STRING'];
            }
        }

        $firstSlash = strpos($_CONF['site_url'], '/');

        if ($firstSlash === false) {
            // special case - assume it's okay
            $thisUrl = $_CONF['site_url'] . $requestUri;
        } elseif ($firstSlash + 1 == strrpos($_CONF['site_url'], '/')) {
            // site is in the document root
            $thisUrl = $_CONF['site_url'] . $requestUri;
        } else {
            // extract server name first
            $pos = strpos($_CONF['site_url'], '/', $firstSlash + 2);
            $thisUrl = substr($_CONF['site_url'], 0, $pos) . $requestUri;
        }
    }

    return $thisUrl;
}

/**
 * Check if we're on Geeklog's index page.
 * See if we're on the main index page (first page, no topics selected).
 * Note: Need to make sure topic global variable has already been set before using this function
 *
 * @return   boolean     true = we're on the frontpage, false = we're not
 */
function COM_onFrontpage()
{
    global $_CONF, $topic, $page;

    // Note: We can't use $PHP_SELF here since the site may not be in the DocumentRoot
    $onFrontPage = false;

    $scriptName = empty($_SERVER['PATH_INFO']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['PATH_INFO'];
    preg_match('/\/\/[^\/]*(.*)/', $_CONF['site_url'], $pathonly);
    if (($scriptName == $pathonly[1] . '/index.php') &&
        empty($topic) && (empty($page) || ($page == 1))
    ) {
        $onFrontPage = true;
    }

    return $onFrontPage;
}

/**
 * Check if we're on Geeklog's index page [deprecated]
 * Note that this function returns FALSE when we're on the index page. Due to
 * the inverted return values, it has been deprecated and is only provided for
 * backward compatibility - use COM_onFrontpage() instead.
 *
 * @return      bool
 * @deprecated  since Geeklog 1.4.1
 * @see         COM_onFrontpage
 */
function COM_isFrontpage()
{
    COM_deprecatedLog(__FUNCTION__, '1.4.1', '3.0.0', 'COM_onFrontpage');

    return !COM_onFrontpage();
}

/**
 * Converts a number for output into a formatted number with thousands-
 * separator, comma-separator and fixed decimals if necessary
 *
 * @param        float $number Number that will be formatted
 * @return       string        formatted number
 */
function COM_numberFormat($number)
{
    global $_CONF;

    if (!is_numeric($number)) {
        return '';
    }

    if ($number - floor($number) > 0) { // number has decimals
        $dc = $_CONF['decimal_count'];
    } else {
        $dc = 0;
    }
    $ts = $_CONF['thousand_separator'];
    $ds = $_CONF['decimal_separator'];

    return number_format($number, $dc, $ds, $ts);
}

/**
 * Convert a text based date YYYY-MM-DD to a unix timestamp integer value
 *
 * @param    string $date Date in the format YYYY-MM-DD
 * @param    string $time Option time in the format HH:MM::SS
 * @return   int          UNIX Timestamp
 */
function COM_convertDate2Timestamp($date, $time = '')
{
    $aTokens = array();
    $bTokens = array();

    // Breakup the string using either a space, fwd slash, dash, bkwd slash or
    // colon as a delimiter
    $aToken = strtok($date, ' /-\\:');
    while ($aToken !== false) {
        $aTokens[] = $aToken;
        $aToken = strtok(' /-\\:');  // get the next token
    }

    for ($i = 0; $i < 3; $i++) {
        if (!isset($aTokens[$i]) || !is_numeric($aTokens[$i])) {
            $aTokens[$i] = 0;
        }
    }

    if ($time == '') {
        $timestamp = mktime(0, 0, 0, $aTokens[1], $aTokens[2], $aTokens[0]);
    } else {
        $bToken = strtok($time, ' /-\\:');

        while ($bToken !== false) {
            $bTokens[] = $bToken;
            $bToken = strtok(' /-\\:');
        }

        for ($i = 0; $i < 3; $i++) {
            if (!isset($bTokens[$i]) || !is_numeric($bTokens[$i])) {
                $bTokens[$i] = 0;
            }
        }

        $timestamp = mktime($bTokens[0], $bTokens[1], $bTokens[2],
            $aTokens[1], $aTokens[2], $aTokens[0]);
    }

    return $timestamp;
}

/**
 * Get the HTML for an image with height & width
 *
 * @param    string  $file  full path to the file
 * @param    boolean $html  flag to return html source or array
 * @return   string|array   if $html true then html that will be included in the img-tag.
 *                           Else an array will be returned with the information
 */
function COM_getImgSizeAttributes($file, $html = true)
{
    $sizeAttributes = '';

    if (file_exists($file)) {
        if (preg_match('/\.svgz?$/i', $file)) {
            // SVG file
            $content = @file_get_contents($file);
            $content = str_replace(array("\n", "\r"), ' ', $content);

            if (preg_match('/<svg[^>]+>/', $content, $m)) {
                $line = $m[0];
                $width = '?';

                if (preg_match('/width="([^"]*)"/', $line, $match)) {
                    $width = $match[1];
                }

                $height = '?';

                if (preg_match('/height="([^"]*)"/', $line, $match)) {
                    $height = $match[1];
                }

                if (($width !== '?') && ($height !== '?')) {
                    if ($html) {
                        $sizeAttributes = 'width="' . $width . '" height="' . $height . '" ';
                    } else {
                        $sizeAttributes = array(
                            'width'  => $width,
                            'height' => $height,
                        );
                    }
                }
            }
        } else {
            // Other file type
            $dimensions = getimagesize($file);
            if (!empty($dimensions[0]) && !empty($dimensions[1])) {
                if ($html) {
                    $sizeAttributes = 'width="' . $dimensions[0] . '" height="' . $dimensions[1] . '" ';
                } else {
                    $sizeAttributes = array(
                        'width'  => $dimensions[0],
                        'height' => $dimensions[1],
                    );
                }
            }
        }
    }

    return $sizeAttributes;
}

/**
 * Display a message and abort
 * NOTE: Displays the message and aborts the script.
 *
 * @param    int    $msg         message number
 * @param    string $plugin      plugin name, if applicable
 * @param    int    $http_status HTTP status code to send with the message
 * @param    string $http_text   Textual version of the HTTP status code
 */
function COM_displayMessageAndAbort($msg, $plugin = '', $http_status = 200, $http_text = 'OK')
{
    global $_CONF, $MESSAGE;

    if (defined('GL_INITIALIZED')) {
        $display = COM_showMessage($msg, $plugin);
        $display = COM_createHTMLDocument(
            $display,
            array(
                'pagetitle'  => $MESSAGE[30],
                'rightblock' => true,
            )
        );
    } else {
        // Calling COM_createHTMLDocument() here will cause a fatal error
        $display = '';

        if (empty($plugin)) {
            if (!isset($MESSAGE)) {
                if (isset($_CONF['path_language'])) {
                    if (isset($_CONF['language'])) {
                        require_once $_CONF['path_language'] . $_CONF['language'] . '.php';
                    } else {
                        require_once $_CONF['path_language'] . 'english.php';
                    }
                }
            }

            if (isset($MESSAGE, $MESSAGE[$msg])) {
                $display = $MESSAGE[$msg];
            }
        }

        if ($display === '') {
            $display = 'Error ' . $http_status . ': ' . $http_text;
        }
    }

    if ($http_status != 200) {
        header("HTTP/1.1 $http_status $http_text");
        header("Status: $http_status $http_text");
    }

    echo $display;
    exit;
}

/**
 * Return full URL of a topic icon
 *
 * @param    string $imageUrl (relative) topic icon URL
 * @return   string           Full URL
 */
function COM_getTopicImageUrl($imageUrl)
{
    global $_CONF, $_THEME_URL;

    $iconUrl = '';

    if (!empty($imageUrl)) {
        if (isset($_THEME_URL)) {
            $iconUrl = $_THEME_URL . $imageUrl;
        } else {
            $stdImageLoc = true;
            if (!strstr($_CONF['path_images'], $_CONF['path_html'])) {
                $stdImageLoc = false;
            }

            if ($stdImageLoc) {
                $iconUrl = $_CONF['site_url'] . $imageUrl;
            } else {
                $t = explode('/', $imageUrl);
                $topicIcon = $t[count($t) - 1];
                $iconUrl = $_CONF['site_url'] . '/getimage.php?mode=topics&amp;image=' . $topicIcon;
            }
        }
    }

    return $iconUrl;
}

/**
 * Create an HTML link
 *
 * @param   string $content  the object to be linked (text, image etc)
 * @param   string $url      the URL the link will point to
 * @param   array  $attr     an array of optional attributes for the link
 *                           for example array('title' => 'whatever');
 * @return  string          the HTML link
 */
function COM_createLink($content, $url, $attr = array())
{
    static $charset = null;

    if ($charset === null) {
        $charset = COM_getEncodingt();
    }

    $attributes = '';
    foreach ($attr as $key => $value) {
        $attributes .= sprintf(
            ' %s="%s"',
            htmlspecialchars($key, ENT_QUOTES, $charset, false),
            htmlspecialchars($value, ENT_QUOTES, $charset, false)
        );
    }

    $retval = sprintf('<a href="%s"%s>%s</a>', $url, $attributes, $content);

    return $retval;
}

/**
 * Create an HTML img
 *
 * @param   string $url         the URL of the image, either starting with
 *                              http://... or $_CONF['layout_url'] is prepended
 * @param   string $alt         the 'alt'-tag of the image
 * @param   array  $attr        an array of optional attributes for the link
 *                              for example array('title' => 'whatever');
 * @return  string              the HTML img
 */
function COM_createImage($url, $alt = '', $attr = array())
{
    global $_CONF;

    if (preg_match("/^(https?):/", $url) !== 1) {
        $url = $_CONF['layout_url'] . $url;
    }
    $attr_str = 'src="' . $url . '"';

    foreach ($attr as $key => $value) {
        $attr_str .= " $key=\"$value\"";
    }

    $retval = "<img {$attr_str} alt=\"{$alt}\"" . XHTML . ">";

    return $retval;
}

/**
 * Try to determine the user's preferred language by looking at the
 * "Accept-Language" header sent by their browser (assuming they bothered
 * to select a preferred language there).
 * Sample header: Accept-Language: en-us,en;q=0.7,de-de;q=0.3
 *
 * @return   string  name of the language file to use or an empty string
 * @todo     Bugs: Does not take the quantity ('q') parameter into account,
 *           but only looks at the order of language codes.
 */
function COM_getLanguageFromBrowser()
{
    global $_CONF;

    $retval = '';

    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && is_array($_CONF['language_files'])) {
        $accept = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        foreach ($accept as $l) {
            $l = explode(';', trim($l));
            $l = $l[0];
            if (array_key_exists($l, $_CONF['language_files'])) {
                $retval = $_CONF['language_files'][$l];
                break;
            } else {
                $l = explode('-', $l);
                $l = $l[0];
                if (array_key_exists($l, $_CONF['language_files'])) {
                    $retval = $_CONF['language_files'][$l];
                    break;
                }
            }
        }
    }

    return $retval;
}

/**
 * Determine current language
 *
 * @return   string  name of the language file (minus the '.php' extension)
 */
function COM_getLanguage()
{
    global $_CONF, $_USER;
    static $langFile;

    if ($langFile !== null) {
        return $langFile;
    }

    // 1. Try to get language from URL
    // $langFile = COM_getLanguageFromBrowser(); - Removed line as it doesn't work with the switch language block (that uses phpblock_switch_language) for some setups when a language cookie is set, need to check that first. 
    $langURLinfo = _getLanguageInfoFromURL();
    $langFile = $langURLinfo[0];

    if (empty($langFile)) {
        if (!empty($_USER['language'])) {
            // 2. Try to get language from the user's settings
            $langFile = $_USER['language'];
        } elseif (!empty($_COOKIE[$_CONF['cookie_language']])) {
            // 3. Try to get language from a value stored in a cookie
            $langFile = $_COOKIE[$_CONF['cookie_language']];
        } elseif (isset($_CONF['languages'])) {
            // 4. Try to get language from HTTP request headers sent by the web browser
            $langFile = COM_getLanguageFromBrowser();
        }
    }

    $langFile = COM_sanitizeFilename($langFile);
    if (!empty($langFile)) {
        if (is_file($_CONF['path_language'] . $langFile . '.php')) {
            return $langFile;
        }
    }

    // if all else fails, return the default language
    $langFile = $_CONF['language'];

    return $langFile;
}

/**
 * Figure out if Geeklog is setup correctly for a multi language site and is enabled
 * 
 * @return      boolean
  */
function COM_isMultiLanguageEnabled()
{
    global $_CONF;
    
    $retval = false;

    // If user allowed to switch language and Multi Language Content setup (because config languages and language_files exist (and assume setup correctly))
    if ($_CONF['allow_user_language'] AND !empty($_CONF['languages']) AND !empty($_CONF['language_files']) AND (count($_CONF['languages']) == count($_CONF['language_files']))) {
        $retval = true;
    }
    
    return $retval;
}

/**
 * Get language name and plugin name and id from current URL 
 * Note: This function starts with _ therefore it is only meant to be called from within Geeklog Core for a specific task
 * 
 * @param       boolean    Tells function to return either language or id of plugin item if found
 * @return      array       e.g., 'english', 'japanese', ... , plugin name, id
  */
function _getLanguageInfoFromURL()
{
    global $_CONF;

    $retval = array('','','');

    if (COM_isMultiLanguageEnabled()) {
        
        $langId = '';
        // Need to see if language is set for url. Supports normal, rewrite, and routing urls.
        // To support multi-language items plugins need to include an extra config option for Core that is called langurl_pluginname
        // This allows this function to figure out by looping through these config options langurl_ what plugin the url is for and if it is an 
        // item that supports multiple languages. 
        // This function is used by COM_getLanguage which is called for anonymous visitors when then first visit a page. It is called very early in the process
        // so no plugin config options or actual functions are available so that is why we need to store the config option in Core since these are already loaded and 
        // we already know which plugins are enabled.
        // This function also allows the switch block (phpblock_switch_language) to determine if the url is of an item of a plugin which supports multiple languages.
        // This means the plugin must also support PLG_getItemInfo (specifically checking the id) so the new id with the switched language of the item can be checked to see if it exists or not.
        // Below are example config values for Article, Topic and Staticpages which all support multiple languages.
        // To support multiple languages, the config option langurl_pluginname must contain an array that returns the directory, the file name, and the url variable of the supported url.
        // Keep the rest of the settings after the array the same.
        // $c->add('langurl_topic',array('', 'index.php', 'topic'),'@hidden',7,31,1,1830,TRUE, 'Core', 31);
        // $c->add('langurl_article',array('', 'article.php', 'story'),'@hidden',7,31,1,1830,TRUE, 'Core', 31);
        // $c->add('langurl_staticpages',array('staticpages', 'index.php', 'page'),'@hidden',7,31,1,1830,TRUE, 'Core', 31);
        
        // ***************************
        // Addtional Notes for Debugging
        // For some reason this function gets called 2 times on a page load for the default URLs and URL_Rewrite URLs. It gets called 3 times if URL_Routing is enabled.
        // Because of this after the first call to this function the $_SERVER['REQUEST_URI'] reverts back to the default URL for some unknown reason (I think it has to do with the URL Class)
        // So that is why with URL_Routing enabled we check it just the same way as the default url. 
        // ***************************
        //echo $_SERVER['REQUEST_URI']; // /article.php/english_en/article.php/english_en 
        $curdirectory = ltrim(ltrim(dirname($_SERVER['REQUEST_URI']), '\\'), '/');
        $site_path = ltrim(ltrim(parse_url($_CONF['site_url'], PHP_URL_PATH), '\\'), '/'); // Need to compare in case site_url has a directory ie www.domain.com/site/
        $curdirectory = ltrim(ltrim(ltrim($curdirectory, $site_path), '\\'), '/');

        $curfilename = basename($_SERVER['SCRIPT_NAME']);        
        
        // URL parts of array returned are: plugin name, directory, filename, id
        $url_lang = PLG_getLanguageURL();

        foreach ($url_lang as $value) {
            $var = "";

            // Find a Match
            
            // Check for URL Rewrite enabled only
            if ($_CONF['url_rewrite'] AND !$_CONF['url_routing']) {
                if ($value[0] == 'topic') { // For Topic - Special Case
                    $checkdir = $value[2] . "/" . $value[3];
                } elseif ($value[0] == 'article') { // For Article - Special Case
                    $checkdir = $value[2];
                } else { // For Plugins
                    $checkdir = $value[1] . "/" . $value[2];
                }                
                if ($curdirectory == $checkdir) {
                    // Retrieve matching Variable
                    if ($value[0] == 'topic') { // For Topic - Special Case
                        COM_setArgNames(array(TOPIC_PLACEHOLDER, $value[3]));
                        if (strcasecmp(COM_getArgument(TOPIC_PLACEHOLDER), $value[3]) === 0) {
                            $var = COM_getArgument($value[3]);
                        }
                    } else {
                        COM_setArgNames(array($value[3]));
                        $var = COM_applyFilter(COM_getArgument($value[3]));
                    }
                }
            // Check for Default URL OR Check for URL Rewrite and URL Routing enabled (eith with index.php or without)
            } else {
                if ($curdirectory . "/" . $curfilename == $value[1] . "/" . $value[2]) {
                    // Found a matching variable
                    $var = Input::fRequest($value[3], '');
                }
            }
            
            if (!empty($var)) {
                // Now lets see if language id
                $l = strrpos($var, '_');
                if ($l !== false) {
                    $langId = substr($var, $l + 1);
                    break;
                }                        
            }
        } 

        if (!empty($langId)) {
            if (isset($_CONF['language_files']) && is_array($_CONF['language_files']) &&
                array_key_exists($langId, $_CONF['language_files'])) {
                $retval = array($_CONF['language_files'][$langId], $value[0], $var);
            }
        }        
    }

    return $retval;
}

/**
 * Determine the language of the object from the id
 *
 * @param    string $id id of object to retrieve language id from
 * @return   string     language ID, e.g 'en'; empty string on error
 */
function COM_getLanguageIdForObject($id)
{
    global $_CONF;

    $lang_id = '';

    if (!empty($id)) {
        $loc = MBYTE_strrpos($id, '_');
        if (($loc > 0) && (($loc + 1) < MBYTE_strlen($id))) {
            $lang_id = MBYTE_substr($id, ($loc + 1));
            // Now check if language actually exists
            if (isset($_CONF['language_files'])) {
                if (array_key_exists($lang_id, $_CONF['language_files']) === false) {
                    // that looks like a misconfigured $_CONF['language_files'] array
                    COM_errorLog('Language "' . $lang_id . '" not found in $_CONF[\'language_files\'] array!');

                    $lang_id = ''; // not much we can do here ...
                }
            } else {
                $lang_id = '';
            }
        }
    }

    return $lang_id;
}

/**
 * Determine the ID to use for the current language
 * The $_CONF['language_files'] array maps language IDs to language file names.
 * This function returns the language ID for a certain language file, to be
 * used in language-dependent URLs.
 *
 * @param    string $language current language file name (optional)
 * @return   string           language ID, e.g 'en'; empty string on error
 */
function COM_getLanguageId($language = '')
{
    global $_CONF;

    if (empty($language)) {
        $language = COM_getLanguage();
    }

    $lang_id = '';
    if (isset($_CONF['language_files'])) {
        $lang_id = array_search($language, $_CONF['language_files']);

        if ($lang_id === false) {
            // that looks like a misconfigured $_CONF['language_files'] array
            COM_errorLog('Language "' . $language . '" not found in $_CONF[\'language_files\'] array!');

            $lang_id = ''; // not much we can do here ...
        }
    }

    return $lang_id;
}

/**
 * Return SQL expression to request language-specific content
 * Creates part of an SQL expression that can be used to request items in the
 * current language only.
 *
 * @param    string $field name of the "id" field, e.g. 'sid' for stories
 * @param    string $type  part of the SQL expression, e.g. 'WHERE', 'AND'
 * @param    string $table table name if ambiguous, e.g. in JOINs
 * @return   string        SQL expression string (may be empty)
 */
function COM_getLangSQL($field, $type = 'WHERE', $table = '')
{
    global $_CONF;

    $sql = '';

    if (!empty($_CONF['languages']) && !empty($_CONF['language_files'])) {
        if (!empty($table)) {
            $table .= '.';
        }

        $lang_id = COM_getLanguageId();

        if (!empty($lang_id)) {
            // $sql = ' ' . $type . " ({$table}$field LIKE '%\\_$lang_id')";
            $length = strlen('_' . $lang_id);
            $sql = ' ' . $type . " (({$table}$field LIKE '%\\_$lang_id') OR ('_' <> SUBSTRING({$table}$field, -$length, 1)))";
        }
    }

    return $sql;
}

/**
 * Provide a block to switch languages (For when Multi Language Content is setup)
 * Provides a drop-down menu (or simple link, if you only have two languages)
 * to switch languages. This can be used as a PHP block or called from within
 * your theme's index.thtml:
 * <code>
 * <?php print phpblock_switch_language(); ?>
 * </code>
 *
 * @return   string  HTML for drop-down or link to switch languages
 */
function phpblock_switch_language()
{
    global $_CONF, $_URL;

    $retval = '';

    if (!COM_isMultiLanguageEnabled()) {
        return $retval;
    }

    $lang = COM_getLanguage();
    $langId = COM_getLanguageId($lang);
    $newLang = '';
    $newLangId = '';
    $langURLinfo = _getLanguageInfoFromURL();
    $itemId = $langURLinfo[2];
    $itemType = $langURLinfo[1];

    if (count($_CONF['languages']) === 2) {
        foreach ($_CONF['languages'] as $key => $value) {
            if ($key != $langId) {
                $newLang = $value;
                $newLangId = $key;
                break;
            }
        }

        $switchUrl = COM_buildURL($_CONF['site_url'] . '/switchlang.php?lang=' . $newLangId . '&itemid' . $itemId . '&itemtype' . $itemType);
        $retval .= COM_createLink($newLang, $switchUrl);
    } else {

        $t = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'blocks/'));
        $t->set_file(array('switchlanguage' => 'switchlanguage.thtml'));
            
        $t->set_var('langId', $langId);
        $t->set_var('itemId', $itemId);
        $t->set_var('itemType', $itemType);
        foreach ($_CONF['languages'] as $key => $value) {
            if ($lang == $_CONF['language_files'][$key]) {
                $selected = ' selected="selected"';
            } else {
                $selected = '';
            }
            $retval .= '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
        }
        $t->set_var('language_options', $retval);
        

        $retval = $t->finish($t->parse('output', 'switchlanguage'));        
    }

    return $retval;
}

/**
 * Switch locale settings
 * When multi-language support is enabled, allow overwriting the default locale
 * settings with language-specific settings (date format, etc.). So in addition
 * to $_CONF['date'] you can have a $_CONF['date_en'], $_CONF['date_de'], etc.
 */
function COM_switchLocaleSettings()
{
    global $_CONF;

    if (!empty($_CONF['languages']) && !empty($_CONF['language_files'])) {
        $overridables = array(
            'locale',
            'date', 'daytime', 'shortdate', 'dateonly', 'timeonly',
            'week_start', 'hour_mode',
            'thousand_separator', 'decimal_separator',
            // Since GL-2.1.2
            'meta_description', 'meta_keywords', 'site_name', 'owner_name', 'site_slogan',
        );

        $langId = COM_getLanguageId();
        foreach ($overridables as $option) {
            if (isset($_CONF[$option . '_' . $langId])) {
                $_CONF[$option] = $_CONF[$option . '_' . $langId];
            }
        }
    }
}

/**
 * Switch the language ID of the object id
 *
 * @param    string $id object id that the language ID is attached to the end
 * @return   string     id that is overwritten with the current language ID
 */
function COM_switchLanguageIdForObject($id)
{
    global $_CONF;

    if (!empty($_CONF['languages']) && !empty($_CONF['language_files'])) {
        $new_id = COM_getLanguageId();
        $old_id = COM_getLanguageIdForObject($id);
        if (!empty($new_id) && !empty($old_id)) {
            $id = substr_replace($id, $new_id, -strlen($old_id));
        }
    }

    return $id;
}

/**
 * Get the name of the current language, minus the character set
 * Strips the character set from $_CONF['language'].
 *
 * @return   string  language name
 */
function COM_getLanguageName()
{
    global $_CONF;

    $charset = '_' . strtolower(COM_getCharset());
    if (substr($_CONF['language'], -strlen($charset)) == $charset) {
        $retval = substr($_CONF['language'], 0, -strlen($charset));
    } else {
        $retval = $_CONF['language'];
    }

    return $retval;
}

/**
 * Returns text that will display if JavaScript is not enabled in the browser
 *
 * @param    boolean $warning            If true displays default JavaScript recommended warning message
 *                                       If false displays default JavaScript Required message
 * @param    string  $noScriptMessage    Used instead of default message
 * @param    string  $link_message       Secondary message that may contain a link
 * @return   string                     noscript html tag with message(s)
 */
function COM_getNoScript($warning = true, $noScriptMessage = '', $link_message = '')
{
    global $_CONF, $LANG01;

    $noScript = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
    $noScript->set_file(array('noscript' => 'noscript.thtml'));

    if ($warning) {
        if (empty($noScriptMessage)) {
            $noScriptMessage = $LANG01[136];
        }
    } else {
        if (empty($noScriptMessage)) {
            $noScriptMessage = $LANG01[137];
        }
    }
    $noScript->set_var('lang_nojavascript', $noScriptMessage);

    if (!empty($link_message)) {
        $noScript->set_var('hide_link', '');
        $noScript->set_var('no_javascript_return_link', $link_message);
    } else {
        $noScript->set_var('hide_link', ' style="display:none;"');
        $noScript->set_var('no_javascript_return_link', '');
    }

    $retval = $noScript->finish($noScript->parse('output', 'noscript'));

    return $retval;
}

/**
 * Returns an text/image that will display a tooltip
 * This tooltip is based on an example from http://downloads.sixrevisions.com/css-tooltips/index.html
 *
 * @param    string $hoverOver Text or image to display for the user to hover their mouse cursor over.
 * @param    string $text      Text for the actual tooltip. Can include HTML.
 * @param    string $link      Link for the tooltip. If passed, then the hoverover text becomes a link.
 * @param    string $title     Text for the tooltip title (if there is one). Can include HTML.
 * @param    string $template  Specify a different template to use (classic, critical, help, information, warning).
 * @param    string $class     Specify a different tooltip class to use.
 * @return   string            HTML tooltip
 */
function COM_getTooltip($hoverOver = '', $text = '', $link = '', $title = '', $template = 'classic', $class = 'gl-tooltip')
{
    global $_CONF, $_IMAGE_TYPE, $_SCRIPTS;

    if (!defined('TOOLTIPS_FIXED')) {
        define('TOOLTIPS_FIXED', true);
        $_SCRIPTS->setJavaScriptLibrary('jquery');
        $_SCRIPTS->setJavaScriptFile('fix_tooltips', '/javascript/fix_tooltips.js');
    }

    if ($hoverOver == '') {
        $hoverOver = '<img alt="?" class="gl-tooltip-icon" src="' . $_CONF['layout_url']
            . '/images/tooltips/tooltip.' . $_IMAGE_TYPE . '"' . XHTML . '>';
    }

    $tooltip = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'tooltips/'));
    $tooltip->set_file(array('tooltip' => $template . '.thtml'));

    $tooltip->set_var('class', $class);
    $tooltip->set_var('hoverover', $hoverOver);
    $tooltip->set_var('text', $text);
    $tooltip->set_var('plaintext', GLText::stripTags($text));
    $tooltip->set_var('title', $title);
    $tooltip->set_var('plaintitle', GLText::stripTags($title));
    if ($link == '') {
        $link = 'javascript:void(0);';
        $cursor = 'help';
    } else {
        $cursor = 'pointer';
    }
    $tooltip->set_var('link', $link);
    $tooltip->set_var('cursor', $cursor);

    $retval = $tooltip->finish($tooltip->parse('output', 'tooltip'));

    return $retval;
}

/**
 * Truncate a string that contains HTML tags. Will close all HTML tags as needed.
 * Truncates a string to a max. length and optionally adds a filler string,
 * e.g. '...', to indicate the truncation.
 * This function is multi-byte string aware. This function is based on a
 * code snippet by pitje at Snipplr.com.
 * NOTE: The truncated string may be shorter or longer than $maxlen characters.
 * Currently any initial html tags in the truncated string are taken into account.
 * The $filler string is also taken into account but any html tags that are added
 * by this function to close open html tags are not.
 *
 * @param    string $htmlText the text string which contains HTML tags to truncate
 * @param    int    $maxLen   max. number of characters in the truncated string
 * @param    string $filler   optional filler string, e.g. '...'
 * @param    int    $endChars number of characters to show after the filler
 * @return   string           truncated string
 */
function COM_truncateHTML($htmlText, $maxLen, $filler = '', $endChars = 0)
{
    $newLen = $maxLen - MBYTE_strlen($filler);
    $len = MBYTE_strlen($htmlText);
    if ($len > $maxLen) {
        $htmlText = MBYTE_substr($htmlText, 0, $newLen - $endChars);

        // Strip any mangled tags off the end
        if (MBYTE_strrpos($htmlText, '<') > MBYTE_strrpos($htmlText, '>')) {
            $htmlText = MBYTE_substr($htmlText, 0, MBYTE_strrpos($htmlText, '<'));
        }

        $htmlText = $htmlText . $filler . MBYTE_substr($htmlText, $len - $endChars, $endChars);

        // *******************************
        // Note: At some point we should probably use htmLawed here or the GLText class which uses htmLawed???
        // something like GLText::applyHTMLFilter but needs to be run with the view of an anonymous user
        
        // put all opened tags into an array
        preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU", $htmlText, $result);
        $openedTags = $result[1];
        $openedTags = array_diff($openedTags, array('img', 'hr', 'br'));
        $openedTags = array_values($openedTags);

        // put all closed tags into an array
        preg_match_all("#</([a-z]+)>#iU", $htmlText, $result);
        $closedTags = $result[1];
        $len_opened = count($openedTags);

        // all tags are closed
        if (count($closedTags) == $len_opened) {
            return $htmlText;
        }
        $openedTags = array_reverse($openedTags);

        // close tags
        for ($i = 0; $i < $len_opened; $i++) {
            if (!in_array($openedTags[$i], $closedTags)) {
                $htmlText .= "</" . $openedTags[$i] . ">";
            } else {
                unset($closedTags[array_search($openedTags[$i], $closedTags)]);
            }
        }
        // *******************************
    }

    return $htmlText;
}

/**
 * Truncate a string
 * Truncates a string to a max. length and optionally adds a filler string,
 * e.g. '...', to indicate the truncation.
 * This function is multi-byte string aware, based on a patch by Yusuke Sakata.
 * NOTE: The truncated string may be shorter but will never be longer than
 *       $maxLen characters, i.e. the $filler string is taken into account.
 *
 * @param    string $text     the text string to truncate
 * @param    int    $maxLen   max. number of characters in the truncated string
 * @param    string $filler   optional filler string, e.g. '...'
 * @param    int    $endChars number of characters to show after the filler
 * @return   string           truncated string
 */
function COM_truncate($text, $maxLen, $filler = '', $endChars = 0)
{
    $newLen = $maxLen - MBYTE_strlen($filler);

    if ($newLen <= 0) {
        $text = MBYTE_substr($text, 0, $maxLen);
    }
    $len = MBYTE_strlen($text);
    if ($len > $maxLen) {
        $startChars = $newLen - $endChars;
        if ($startChars < $endChars) {
            $text = MBYTE_substr($text, 0, $newLen) . $filler;
        } else {
            $text = MBYTE_substr($text, 0, $newLen - $endChars) . $filler
                . MBYTE_substr($text, $len - $endChars, $endChars);
        }
    }

    return $text;
}

/**
 * Get the current character set
 * Uses (if available, and in this order)
 * - $LANG_CHARSET (from the current language file)
 * - $_CONF['default_charset'] (from siteconfig.php)
 * - 'iso-8859-1' (hard-coded fallback)
 *
 * @return   string      character set, e.g. 'utf-8'
 */
function COM_getCharset()
{
    global $_CONF, $LANG_CHARSET;

    if (empty($LANG_CHARSET)) {
        $charset = $_CONF['default_charset'];
        if (empty($charset)) {
            $charset = 'iso-8859-1';
        }
    } else {
        $charset = $LANG_CHARSET;
    }

    return $charset;
}

/**
 * Display a 404 not found error message
 *
 * @param    string $alternate_url Point the user to another location
 */
function COM_handle404($alternate_url = '')
{
    global $_CONF, $_USER, $LANG_404;

    if (function_exists('CUSTOM_handle404')) {
        CUSTOM_handle404($alternate_url);
        exit;
    }

    // send 404 in any case
    header('HTTP/1.1 404 Not Found');
    header('Status: 404 Not Found');

    if (isset($_SERVER['SCRIPT_URI'])) {
        // Added QUERY_STRING as this works with PHP with FPM on. Not sure if this affects other PHP setups?
        $url = $_SERVER['SCRIPT_URI'] . '?' . $_SERVER['QUERY_STRING'];
    } else {
        if (empty($_SERVER['HTTPS']) || ($_SERVER['HTTPS'] === 'off')) {
            $url = 'http';
        } else {
            $url = 'https';
        }

        $url .= '://' . @$_SERVER['HTTP_HOST'] . strip_tags($_SERVER['REQUEST_URI']);
    }

    // Add file log stuff
    if (isset($_CONF['404_log']) && $_CONF['404_log']) {
        if (empty($_USER['uid'])) {
            $byUser = 'anon@' . $_SERVER['REMOTE_ADDR'];
        } else {
            $byUser = $_USER['uid'] . '@' . $_SERVER['REMOTE_ADDR'];
        }

        $logEntry = "404 Error generated by {$byUser} for URL: {$url}";

        // Add referer
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $logEntry .= " - Referring URL: {$_SERVER['HTTP_REFERER']}";
        }

        // Add user agent
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $logEntry .= ' - User agent: ' . $_SERVER['HTTP_USER_AGENT'];
        }

        // Write into log file
        Log::error404($logEntry);
    }

    $display = COM_startBlock($LANG_404[1])
        . sprintf($LANG_404[2], $url);

    if ($alternate_url != '') {
        $display .= sprintf($LANG_404[4], $alternate_url);
    } else {
        $display .= $LANG_404[3];
    }

    $display .= COM_endBlock();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_404[1]));
    COM_output($display);
    exit; // Do not want to go any further
}

/**
 * Handle errors.
 * This function will handle all PHP errors thrown at it, without exposing
 * paths, and hopefully, providing much more information to Root Users than
 * the default white error page.
 * This function will call out to CUSTOM_handleError if it exists, but, be
 * advised, only override this function with a very, very stable function. I'd
 * suggest one that outputs some static, basic HTML.
 * The PHP feature that allows us to do so is documented here:
 * http://uk2.php.net/manual/en/function.set-error-handler.php
 *
 * @param  int    $errNo      Error Number.
 * @param  string $errStr     Error Message.
 * @param  string $errFile    The file the error was raised in.
 * @param  int    $errLine    The line of the file that the error was raised at.
 * @param  array  $errContext An array that points to the active symbol table at the point the error occurred.
 */
function COM_handleError($errNo, $errStr, $errFile = '', $errLine = 0, $errContext = array())
{
    global $_CONF, $_USER, $LANG01;

    // Handle @ operator
    if (error_reporting() == 0) {
        return;
    }

    // Table of error code and error type
    $errorTypes = array(
        0     => 'E_SYNTAX',            // Since Geeklog 2.2.0 - Handles syntax errors. Used when Developer Mode is on and PHP is set to show all errors 
        1     => 'E_ERROR',
        2     => 'E_WARNING',
        4     => 'E_PARSE',
        8     => 'E_NOTICE',
        16    => 'E_CORE_ERROR',
        32    => 'E_CORE_WARNING',
        64    => 'E_COMPILE_ERROR',
        128   => 'E_COMPILE_WARNING',
        256   => 'E_USER_ERROR',
        512   => 'E_USER_WARNING',
        1024  => 'E_USER_NOTICE',
        2048  => 'E_STRICT',            // Since PHP-5.0.0
        4096  => 'E_RECOVERABLE_ERROR', // Since PHP-5.2.0
        8192  => 'E_DEPRECATED',        // Since PHP-5.3.0
        16384 => 'E_USER_DEPRECATED',   // Since PHP-5.3.0
    );

    /*
     * If we have a root user, then output detailed error message:
     */
    if ((is_array($_USER) && function_exists('SEC_inGroup'))
        || (isset($_CONF['rootdebug']) && $_CONF['rootdebug'])
    ) {
        if ($_CONF['rootdebug'] || SEC_inGroup('Root')) {
            header('HTTP/1.1 500 Internal Server Error');
            header('Status: 500 Internal Server Error');
            header('Content-Type: text/html; charset=' . COM_getCharset());

            $title = 'An Error Occurred';
            if (!empty($_CONF['site_name'])) {
                $title = $_CONF['site_name'] . ' - ' . $title;
            }
            $output = <<<HTML
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="{$_CONF['default_charset']}">
  <title>{$title}</title>
</head>
<body>
<h1>An error has occurred:</h1>
HTML;
            if ($_CONF['rootdebug']) {
                $output .= <<<HTML
<h2 style="color: red;">This is being displayed as "Root Debugging" is enabled in your Geeklog configuration.</h2>
<p>If this is a production website you <strong><em>must disable</em></strong> this option once you have resolved any issues you are investigating.</p>
HTML;
            } else {
                $output .= '<p>(This text is only displayed to users in the group \'Root\')</p>';
            }

            $output .= "<p>$errorTypes[$errNo]($errNo) - $errStr @ $errFile line $errLine</p>";

            if (!function_exists('SEC_inGroup') || !SEC_inGroup('Root')) {
                if ('force' != '' . $_CONF['rootdebug']) {
                    $errContext = COM_rootDebugClean($errContext);
                } else {
                    $output .= <<<HTML
<h2 style="color: red;">Root Debug is set to "force", this means that passwords and session cookies are exposed in this message!!!</h2>
HTML;
                }
            }
            if (@ini_get('xdebug.default_enable') == 1) {
                ob_start();
                var_dump($errContext);
                $output .= ob_get_clean() . PHP_EOL . '</body></html>';
                echo $output;
            } else {
                $btr = debug_backtrace();
                if (count($btr) > 0) {
                    if ($btr[0]['function'] == 'COM_handleError') {
                        array_shift($btr);
                    }
                }
                if (count($btr) > 0) {
                    $output .= <<<HTML
<table class="xdebug-error" dir="ltr" style="font-size: xx-small; border-width: 1px; border-collapse: collapse;">
  <tr>
    <th style="text-align: left; background-color: #e9b96e;" colspan="5">Call Stack</th>
  </tr>
  <tr>
    <th style="text-align: right; background-color: #eeeeec;">#</th>
    <th style="text-align: left; background-color: #eeeeec;">Function</th>
    <th style="text-align: left; background-color: #eeeeec;">File</th>
    <th style="text-align: right; background-color: #eeeeec;">Line</th>
  </tr>
HTML;

                    $i = 1;
                    foreach ($btr as $b) {
                        $f = '';
                        if (!empty($b['file'])) {
                            $f = $b['file'];
                        }
                        $l = '';
                        if (!empty($b['line'])) {
                            $l = $b['line'];
                        }

                        $output .= <<<HTML
  <tr>
    <td style="text-align: right; background-color: #eeeeec;">{$i}</td>
    <td style="background-color: #eeeeec;">{$b['function']}</td>
    <td style="background-color: #eeeeec;">{$f}</td>
    <td style="text-align: right; background-color: #eeeeec;">{$l}</td>
  </tr>
HTML;
                        $i++;
                        if ($i > 100) {
                            $output .= <<<HTML
  <tr>
    <td style="text-align: left; background-color: #eeeeec;" colspan="4">Possible recursion - aborting.</td>
  </tr>
HTML;
                            break;
                        }
                    }

                    $output .= '</table>' . PHP_EOL;
;               }

                $output .= '<pre>';
                ob_start();
                var_dump($errContext);
                $output .= htmlspecialchars(ob_get_clean()) . '</pre></body></html>';
                echo $output;
            }
            exit;
        }
    }

    /* If there is a custom error handler, fail over to that, but only
     * if the error wasn't in lib-custom.php
     */
    if (is_array($_CONF) && !(strstr($errFile, 'lib-custom.php'))) {
        if (array_key_exists('path_system', $_CONF)) {
            if (file_exists($_CONF['path_system'] . 'lib-custom.php')) {
                require_once $_CONF['path_system'] . 'lib-custom.php';
            }
            if (function_exists('CUSTOM_handleError')) {
                CUSTOM_handleError($errNo, $errStr, $errFile, $errLine, $errContext);
                exit;
            }
        }
    }

    // if we do not throw the error back to an admin, still log it in the error.log
    COM_errorLog("$errorTypes[$errNo]($errNo) - $errStr @ $errFile line $errLine", 1);

    header('HTTP/1.1 500 Internal Server Error');
    header('Status: 500 Internal Server Error');
    header('Content-Type: text/html; charset=' . COM_getCharset());

    // Does the theme implement an error message html file?
    if (!empty($_CONF['path_layout']) &&
        file_exists($_CONF['path_layout'] . 'errormessage.html')
    ) {
        // NOTE: NOT A TEMPLATE! JUST HTML!
        include $_CONF['path_layout'] . 'errormessage.html';
    } elseif (!empty($_CONF['path_layout_default']) &&
        file_exists($_CONF['path_layout_default'] . 'errormessage.html')
    ) {
        // NOTE: NOT A TEMPLATE! JUST HTML!
        include $_CONF['path_layout_default'] . 'errormessage.html';
    } else {
        // Otherwise, display simple error message
        $title = $LANG01[141];

        if (!empty($_CONF['site_name'])) {
            $title = $_CONF['site_name'] . ' - ' . $title;
        }

        echo "
        <html>
            <head>
                <title>{$title}</title>
            </head>
            <body>
            <div style=\"width: 100%; text-align: center;\">
            {$LANG01[142]}
            </div>
            </body>
        </html>
        ";
    }

    exit;
}

/**
 * Recurse through the error context array removing/blanking password/cookie
 * values in case the "for development" only switch is left on in a production
 * environment.
 * [Not fit for public consumption comments about what users who enable root
 * debug in production should have done to them, and why making this change
 * defeats the point of the entire root debug feature go here.]
 *
 * @param  array   $array Array of state info (Recursive array).
 * @param  boolean $blank override (wouldn't that blank out everything?)
 * @return array          Cleaned array
 */
function COM_rootDebugClean($array, $blank = false)
{
    foreach ($array as $key => $value) {
        if ((stripos($key, 'pass') !== false) || (stripos($key, 'cookie') !== false) ||
            (stripos($key, '_consumer_key') !== false) ||
            (stripos($key, '_consumer_secret') !== false)
        ) {
            $blankField = true;
        } else {
            $blankField = $blank;
        }

        if (is_array($value)) {
            $array[$key] = COM_rootDebugClean($value, $blankField);
        } elseif ($blankField) {
            $array[$key] = '[VALUE REMOVED]';
        }
    }

    return $array;
}

/**
 * Checks to see if a specified user, or the current user if non-specified
 * is the anonymous user.
 *
 * @param  int $uid ID of the user to check, or none for the current user.
 * @return boolean  true if the user is the anonymous user.
 */
function COM_isAnonUser($uid = 0)
{
    global $_USER;

    // If no user was specified, fail over to the current user if there is one
    if (empty($uid)) {
        if (isset($_USER['uid'])) {
            $uid = $_USER['uid'];
        }
    }

    if (!empty($uid)) {
        return ($uid == 1);
    } else {
        return true;
    }
}

/**
 * Check and modify a meta tag value
 *
 * @param    string $value
 * @return   string
 * @since    Geeklog-2.1.0
 */
function COM_escapeMetaTagValue($value)
{
    global $_CONF;
    static $charset = null;

    if ($charset === null) {
        $charset = COM_getCharset();
    }

    $value = preg_replace('/[[:cntrl:]]/', ' ', $value);
    $value = GLText::stripTags($value);
    $value = trim($value);
    $value = preg_replace('/\s\s+/', ' ', $value);

    if ($_CONF['doctype'] === 'xhtml5') {
        $value = htmlspecialchars($value, ENT_COMPAT | ENT_HTML5, $charset);
    } else {
        $value = htmlspecialchars($value, ENT_COMPAT | ENT_HTML401, $charset);
    }

    return $value;
}

/**
 * Create Meta Tags to be used by COM_createHTMLDocument in the headercode variable
 *
 * @param    mixed  $meta_description    In case of a string value, this is the text
 *                                       for the meta description of the page being
 *                                       displayed.  In case of an array value, this
 *                                       is key-value pair(s) for the meta description.
 * @param    string $meta_keywords       the text for the meta keywords of the page
 *                                       being displayed
 * @return   string                      (X)HTML formatted text
 * @since    Geeklog-1.6.1
 */
function COM_createMetaTags($meta_description, $meta_keywords)
{
    global $_CONF;

    $headerCode = '';

    if ($_CONF['meta_tags'] > 0) {
        if (is_array($meta_description)) {  // Since GL-2.1.0
            foreach ($meta_description as $name => $content) {
                $name = COM_escapeMetaTagValue($name);
                $content = COM_escapeMetaTagValue($content);
                $headerCode .= LB . '<meta name="' . $name . '" content="'
                    . $content . '"' . XHTML . '>';
            }
        } else {
            if ($meta_description != '') {
                $headerCode .= LB . '<meta name="description" content="'
                    . COM_escapeMetaTagValue($meta_description)
                    . '"' . XHTML . '>';
            }

            if ($meta_keywords != '') {
                $headerCode .= LB . '<meta name="keywords" content="'
                    . COM_escapeMetaTagValue($meta_keywords)
                    . '"' . XHTML . '>';
            }
        }
    }

    return $headerCode;
}

/**
 * Create hreflang HTML link element in header to be used by COM_createHTMLDocument in the headercode variable.
 * Plugin needs to support the function PLG_getItemInfo and be able to return the id and url of the item 
 * Plugin also needs to support the function _getLanguageInfoFromURL which requires extra config options present (see _getLanguageInfoFromURL for more details)
 *
 * @param    string $type    plugin type (incl. 'article' for stories and 'topic' for topic)
 * @param    string $id      ID of an item under the plugin's control (assumes exists and current user has access)
 * @return   string          (X)HTML formatted text
 * @since    Geeklog-2.2.0
 */
function COM_createHREFLang($type, $id)
{
    global $_CONF;

    $headerCode = '';

    // Add hreflang link element if multi-language site
    // If user allowed to switch language and Multi Language Content setup (because config languages and language_files exist (and assume setup correctly))
    if (COM_isMultiLanguageEnabled()) {
        $lang_id = COM_getLanguageIdForObject($id);
        if (empty($lang_id)) {
            // Non Language specific item id found

            // Can set hreflang="x-default" when 
            // See video at: https://support.google.com/webmasters/answer/189077?hl=en
            // 1) url language is broad
            // 2) Content can be dynamic (ie language displayed is based on IP)
            // 3) Is a page that acts as a language selector)
            // 4) Should only be included on the canonical url and not the duplicates
            
            $headerCode .= LB . '<link rel="alternate" hreflang="x-default" href="' . PLG_getItemInfo($type, $id, 'url') . '"' . XHTML . '>';
        } else {
            // Language specific item Id found
            
            // Find non language id of item then
            $nonlang_item_id = MBYTE_substr($id, 0, (-(MBYTE_strlen($lang_id)+1))); // remove length of lang_id plus the underscore character
        
            // Cycle through each language and determine if item exists and is accessible
            foreach ($_CONF['languages'] as $key => $value) {
                $lang_id = $key;
                $lang_item_id = $nonlang_item_id . '_' . $lang_id;
                
                // See if item for language found and user has access, not in draft, etc..
                $tempId = PLG_getItemInfo($type, $lang_item_id, 'id');
                if (!empty($tempId)) {
                    // Now build url for page
                    $headerCode .= LB . '<link rel="alternate" hreflang="' . $lang_id . '" href="' . PLG_getItemInfo($type, $lang_item_id, 'url') . '"' . XHTML . '>';
                }
            }
        }
     }

    return $headerCode;
}

/**
 * Convert wiki-formatted text to (X)HTML
 *
 * @param    string $wikiText wiki-formatted text
 * @return   string              XHTML formatted text
 */
function COM_renderWikiText($wikiText)
{
    global $_CONF;

    if (!$_CONF['wikitext_editor']) {
        return $wikiText;
    }

    return GLText::renderWikiText($wikiText);
}

/**
 * Set the {lang_id} and {lang_attribute} variables for a template
 *
 * @param    Template $template template to use
 * @return   void
 */
function COM_setLangIdAndAttribute($template)
{
    global $_CONF, $LANG_ISO639_1;

    $langAttr = '';

    if (!empty($_CONF['languages']) && !empty($_CONF['language_files'])) {
        $langId = COM_getLanguageId();
    } else {
        $langId = $LANG_ISO639_1;
    }

    if (!empty($langId)) {
        $l = explode('-', str_replace('_', '-', $langId));
        if ((count($l) === 1) && (strlen($langId) === 2)) {
            $langAttr = 'lang="' . $langId . '"';
        } elseif (count($l) == 2) {
            if (($l[0] === 'i') || ($l[0] === 'x')) {
                $langId = implode('-', $l);
                $langAttr = 'lang="' . $langId . '"';
            } elseif (strlen($l[0]) === 2) {
                $langId = implode('-', $l);
                $langAttr = 'lang="' . $langId . '"';
            } else {
                $langId = $l[0];
                // this isn't a valid lang attribute, so don't set $langAttr
            }
        }
    }
    $template->set_var('lang_id', $langId);

    if (!empty($_CONF['languages']) && !empty($_CONF['language_files'])) {
        $template->set_var('lang_attribute', ' ' . $langAttr);
    } else {
        $template->set_var('lang_attribute', ' lang="' . $LANG_ISO639_1 . '"');
    }
}

/**
 * Sends compressed output to browser.
 * Assumes that $display contains the _entire_ output for a request - no
 * echoes are allowed before or after this function.
 * Currently only supports gzip compression. Checks if zlib compression is
 * enabled in PHP and does uncompressed output if it is.
 *
 * @param    string $display Content to send to browser
 * @return   void
 */
function COM_output($display)
{
    global $_CONF;

    if (empty($display)) {
        return;
    }

    if ($_CONF['compressed_output']) {
        $gzip_accepted = false;
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])) {
            $enc = str_replace(' ', '', $_SERVER['HTTP_ACCEPT_ENCODING']);
            $accept = explode(',', strtolower($enc));
            $gzip_accepted = in_array('gzip', $accept);
        }

        if ($gzip_accepted && function_exists('gzencode')) {
            $zlib_comp = ini_get('zlib.output_compression');
            if (empty($zlib_comp) || (strcasecmp($zlib_comp, 'off') === 0)) {
                header('Content-encoding: gzip');
                echo gzencode($display);

                return;
            }
        }
    }

    echo $display;
}

/**
 * Turn a piece of HTML into continuous(!) plain text
 * This function removes HTML tags, line breaks, etc. and returns one long
 * line of text. This is useful for word counts (do an explode() on the result)
 * and for text excerpts.
 *
 * @param    string $text original text, including HTML and line breaks
 * @return   string       continuous plain text
 */
function COM_getTextContent($text)
{
    // remove everything before <body> tag
    if (($pos = stripos($text, '<body')) !== false) {
        $text = substr($text, $pos);
    }

    // remove everything after </body> tag
    if (($pos = stripos($text, '</body>')) !== false) {
        $text = substr($text, 0, $pos + strlen('</body>'));
    }

    // remove <script> tags
    if (stripos($text, '<script') !== false) {
        $text = preg_replace('@<script.*?>.*?</script>@i', ' ', $text);

        if (($pos = stripos($text, '<script')) !== false) {
            // </script> tag is missing
            $text = substr($text, 0, $pos);
        }

        if (($pos = stripos($text, '</script>')) !== false) {
            // <script> tag is missing
            $text = substr($text, $pos + strlen('</script>'));
        }
    }

    // replace <br> with spaces so that Text<br>Text becomes two words
    $text = preg_replace('/\<br(\s*)?\/?\>/i', ' ', $text);

    // add extra space between tags, e.g. <p>Text</p><p>Text</p>
    $text = str_replace('><', '> <', $text);

    // only now remove all HTML tags
    $text = GLText::stripTags($text);

    // replace all tabs, newlines, and carriage returns with spaces
    $text = str_replace(array("\011", "\012", "\015"), ' ', $text);

    // replace entities with plain spaces
    $text = str_replace(array('&#20;', '&#160;', '&nbsp;'), ' ', $text);

    // collapse whitespace
    $text = preg_replace('/\s\s+/', ' ', $text);

    return trim($text);
}

/**
 * Common function used to convert a Geeklog version number into
 * a version number that can be parsed by PHP's "version_compare()"
 *
 * @param    string $version Geeklog version number
 * @return   string          Generic version number that can be correctly handled by PHP
 */
function COM_versionConvert($version)
{
    $version = strtolower($version);
    // Check if it's a bugfix release first
    $dash = strpos($version, '-');
    if ($dash !== false) {
        // Sometimes the bugfix part is not placed in the version number
        // according to the documentation and this needs to be accounted for
        $rearrange = true; // Assume incorrect formatting
        $b = strpos($version, 'b');
        $rc = strpos($version, 'rc');
        $sr = strpos($version, 'sr');
        if ($b && $b < $dash) {
            $pos = $b;
        } elseif ($rc && $rc < $dash) {
            $pos = $rc;
        } elseif ($sr && $sr < $dash) {
            $pos = $sr;
        } else {
            // Version is correctly formatted
            $rearrange = false;
        }
        // Rearrange the version number, if needed
        if ($rearrange) {
            $ver = substr($version, 0, $pos);
            $cod = substr($version, $pos, $dash - $pos);
            $bug = substr($version, $dash + 1);
            $version = $ver . '.' . $bug . $cod;
        } else { // This bugfix release version is correctly formatted
            // So there is an extra number in the version
            $version = str_replace('-', '.', $version);
        }
        $bugfix = '';
    } else {
        // Not a bugfix release, so we add a zero to compensate for the extra number
        $bugfix = '.0';
    }
    // We change the non-numerical part in the "versions" that were passed into the function
    // beta                      -> 1
    // rc                        -> 2
    // hg                        -> ignore
    // stable (e.g: no letters)  -> 3
    // sr                        -> 4
    if (strpos($version, 'b') !== false) {
        $version = str_replace('b', $bugfix . '.1.', $version);
    } elseif (strpos($version, 'rc') !== false) {
        $version = str_replace('rc', $bugfix . '.2.', $version);
    } elseif (strpos($version, 'sr') !== false) {
        $version = str_replace('sr', $bugfix . '.4.', $version);
    } else { // must be a stable version then...
        // we always ignore the 'hg' bit
        $version = str_replace('hg', '', $version);
        $version .= $bugfix . '.3.0';
    }

    return $version;
}

/**
 * Common function used to compare two Geeklog version numbers
 *
 * @param    string $version1        First version number to be compared
 * @param    string $version2        Second version number to be sompared
 * @param    string $operator        optional string to define how the two versions are to be compared
 *                                   valid operators are: <, lt, <=, le, >, gt, >=, ge, ==, =, eq, !=, <>, ne
 * @return   mixed                   By default, returns -1 if the first version is lower than the second,
 *                                   0 if they are equal, and 1 if the second is lower.
 *                                   When using the optional operator argument, the function will return TRUE
 *                                   if the relationship is the one specified by the operator, FALSE otherwise.
 */
function COM_versionCompare($version1, $version2, $operator = '')
{
    // Convert Geeklog version numbers to a ones that can be parsed
    // by PHP's "version_compare"
    $version1 = COM_versionConvert($version1);
    $version2 = COM_versionConvert($version2);
    // All that there should be left at this point is numbers and dots,
    // so PHP's built-in function can now take over.
    if (empty($operator)) {
        return version_compare($version1, $version2);
    } else {
        return version_compare($version1, $version2, $operator);
    }
}

/**
 * Check if Geeklog has been installed yet
 * This is a (very) simple check to see if the user already ran the install
 * script. If not, abort and display a nice(r) welcome screen with handy links
 * to the install script and instructions. Inspired by MediaWiki ...
 */
function COM_checkInstalled()
{
    global $_CONF;

    // this is the only thing we check for now ...
    $isInstalled = !empty($_CONF) && is_array($_CONF) &&
        isset($_CONF['path']) && ($_CONF['path'] !== '/path/to/Geeklog/') && @file_exists($_CONF['path']);

    if (!$isInstalled) {
        $rel = '';
        $cd = getcwd();
        if (!file_exists($cd . '/admin/install/index.php')) {
            // this should cover most (though not all) cases
            $rel = '../';
        }

        $version = VERSION;
        $display = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to Geeklog</title>
  <meta name="robots" content="noindex,nofollow" />
  <link rel="stylesheet" href="vendor/uikit3/css/uikit.min.css">
  <script src="vendor/uikit3/js/uikit.min.js"></script>
  <script src="vendor/uikit3/js/uikit-icons.min.js"></script>
  <style type="text/css">
    html, body {
      color: #000;
      background-color: #fff;
      font-family: sans-serif;
      text-align: center;
    }
  </style>
</head>

<body>
<div class="uk-container">
  <div class="uk-grid" style="max-width: 600px; margin: 5px auto;">
    <div class="uk-align-center">
      <img src="{$rel}docs/images/logo.gif" alt="" />
    </div>

    <div>
      <h1 class="uk-align-center">Geeklog {$version}</h1>
      <p class="uk-align-center"><span uk-icon="icon: warning; ratio: 2" style="color: red;"></span>  Please run the <a href="{$rel}admin/install/index.php" rel="nofollow">install script</a> first.</p>
      <p class="uk-align-center">For more information, please refer to the <a href="{$rel}docs/english/install.html" rel="nofollow">installation instructions</a>.</p>
    </div>
  </div>
</div>
</body>
</html>
HTML;
        header("HTTP/1.1 503 Service Unavailable");
        header("Status: 503 Service Unavailable");
        header('Content-Type: text/html; charset=utf-8');
        die($display);
    }
}

/**
 * Provide support for drop-in replaceable template engines
 *
 * @param    string|array $root    Path to template root. If string assume core, if array assume plugin
 * @param    string|array $options List of options to pass to constructor
 * @return   Template              An ITemplate derived object
 */
function COM_newTemplate($root, $options = array())
{
    global $TEMPLATE_OPTIONS;
    
    if (function_exists('OVERRIDE_newTemplate')) {
        if (is_string($options)) {
            $options = array('unknowns', $options);
        }
        $T = OVERRIDE_newTemplate($root, $options);
    } else {
        $T = null;
    }

    if (!is_object($T)) {
        if (is_array($options) && array_key_exists('unknowns', $options)) {
            $options = $options['unknowns'];
        } else {
            $options = 'remove';
        }

        // Note: as of Geeklog 2.2.0 
        // CTL_setTemplateRoot before was set back when child themes support was added (not sure which Geeklog version) as a hook to run as a template preprocessor. 
        // This was fine for Geeklog Core but could create issues for plugins as it could not tell the difference and would add in theme and theme_default root dir locations (among other custom folders)
        // Now if root is passed as a single directory (not an array) it is assumed that Geeklog Core is setting the template or an old style plugin
        // If root is an array assume it is a plugin that supports multiple locations for its template (uses CTL_plugin_templatePath)
        // For more info see template class set_root function, CTL_setTemplateRoot, CTL_core_templatePath, CTL_plugin_templatePath
        
        // CTL_setTemplateRoot will be depreciated as of Geeklog 3.0.0. This means plugins will not be allowed to set the template class directly. They must use COM_newTemplate and either CTL_core_templatePath or CTL_plugin_templatePath
        
        if (is_array($root)) {
            $TEMPLATE_OPTIONS['hook'] = array(); // Remove default hook that sets CTL_setTemplateRoot Function found in lib-template. It is used to add the ability for child themes (old way)
        }
        
        $T = new Template($root, $options);
    }

    return $T;
}

/**
 * Get a valid encoding for htmlspecialchars()
 *
 * @return   string      character set, e.g. 'utf-8'
 */
function COM_getEncodingt()
{
    static $encoding;

    if ($encoding === null) {
        $encoding = strtolower(COM_getCharset());
        $valid_charsets = array(
            'iso-8859-1', 'iso-8859-15', 'utf-8', 'cp866', 'cp1251',
            'cp1252', 'koi8-r', 'big5', 'gb2312', 'big5-hkscs',
            'shift_jis', 'sjis', 'euc-jp',
        );
        if (!in_array($encoding, $valid_charsets)) {
            $encoding = 'iso-8859-1';
        }
    }

    return $encoding;
}

/**
 * Escape text so that it can safely be displayed as HTML
 *
 * @param  string       $str
 * @param  int          $flags
 * @param  bool         $isDoubleEncode
 * @param  string|null  $encoding
 * @return string
 */
function COM_escHTML($str, $flags = ENT_QUOTES, $isDoubleEncode = true, $encoding = null)
{
    if (empty($encoding)) {
        $encoding = COM_getEncodingt();
    }

    return htmlspecialchars($str, $flags, $encoding, $isDoubleEncode);
}

/**
 * Replaces all newlines in a string with <br> or <br />,
 * depending on the detected setting.
 *
 * @param    string $string The string to modify
 * @return   string         The modified string
 */
function COM_nl2br($string)
{
    if (!defined('XHTML')) {
        define('XHTML', '');
    }

    $replace = '<br' . XHTML . '>';
    $find = array("\r\n", "\n\r", "\r", "\n");

    return str_replace($find, $replace, $string);
}

/**
 * Returns the ISO-639-1 language code
 *
 * @param   string $langName
 * @return  string
 */
function COM_getLangIso639Code($langName = null)
{
    $mapping = array(
        // GL language name   => ISO-639-1
        'afrikaans'           => 'af',
        'bosnian'             => 'bs',
        'bulgarian'           => 'bg',
        'catalan'             => 'ca',
        'chinese_simplified'  => 'zh-cn',
        'chinese_traditional' => 'zh',
        'croatian'            => 'hr',
        'czech'               => 'cs',
        'danish'              => 'da',
        'dutch'               => 'nl',
        'english'             => 'en',
        'estonian'            => 'et',
        'farsi'               => 'fa',
        'finnish'             => 'fi',
        'french_canada'       => 'fr-ca',
        'french_france'       => 'fr',
        'german'              => 'de',
        'german_formal'       => 'de',
        'hebrew'              => 'he',
        'hellenic'            => 'el',
        'indonesian'          => 'id',
        'italian'             => 'it',
        'japanese'            => 'ja',
        'korean'              => 'ko',
        'norwegian'           => 'no',  // Norwegian (nynorsk)
        //      'norwegian'           => 'nb',  // Norwegian (Bokmal)
        'polish'              => 'pl',
        'portuguese'          => 'pt',
        'portuguese_brazil'   => 'pt-br',
        'romanian'            => 'ro',
        'russian'             => 'ru',
        'serbian'             => 'sr',
        'slovak'              => 'sk',
        'slovenian'           => 'sl',
        'spanish'             => 'es',
        'spanish_argentina'   => 'es',
        'swedish'             => 'sv',
        'turkish'             => 'tr',
        'ukrainian'           => 'uk',
        'ukrainian_koi8-u'    => 'uk',
    );

    if ($langName === null) {
        $langName = COM_getLanguage();
    }

    $langName = strtolower($langName);
    $langName = str_replace('_utf-8', '', $langName);

    return isset($mapping[$langName]) ? $mapping[$langName] : 'en';
}

/**
 * Setup Advanced Editor
 *
 * @param   string $custom         location of custom script file relative to
 *                                 public_html directory. Include '/' at beginning
 * @param   string $permissions    comma-separated list of rights which identify the current user as an "Admin"
 * @param   string $myEditor
 * @return  void
 */
function COM_setupAdvancedEditor($custom, $permissions = 'story.edit', $myEditor = '')
{
    global $_CONF, $_USER, $_SCRIPTS;

    if (!$_CONF['advanced_editor'] || !$_USER['advanced_editor']) {
        return;
    }

    $name = 'ckeditor';
    $js = 'ckeditor.js';

    $dir = str_replace($_CONF['path_html'], '', $_CONF['path_editors']);
    $dir = trim($dir, '/'); // default : 'editors'

    if (!empty($_CONF['advanced_editor_name'])) {
        $name = $_CONF['advanced_editor_name'];
    }
    if (!empty($myEditor)) {
        $name = $myEditor;
    }

    if (!file_exists($_CONF['path_editors'] . $name . '/functions.php')) {
        return;
    }

    require_once $_CONF['path_editors'] . $name . '/functions.php';

    $function = 'adveditor_config_' . $name;
    $footer = true;
    $priority = '';

    if (function_exists($function)) {
        $config = $function();
        $js = $config['file'];
        $footer = $config['footer'];
        $priority = $config['priority'];
    }
    $js = trim($js, '/');

    if (empty($footer)) {
        $footer = true;
    }

    if (empty($priority)) {
        $priority = 100;
    }

    if (empty($permissions) || !SEC_hasRights($permissions) ||
        empty($_CONF['admin_html'])
    ) {
        $html = $_CONF['user_html'];
    } else {
        $html = array_merge_recursive($_CONF['user_html'],
            $_CONF['admin_html'],
            $_CONF['advanced_html']);
    }
    
    // Check if the current user has access to Filemanager
    $geeklogFileManager = "false";
    if (!$_CONF['filemanager_disabled'] && (SEC_inGroup('Root') || (SEC_inGroup('Filemanager Admin') || SEC_hasRights('filemanager.admin')))) {
        if (!COM_isDemoMode()) {
            $geeklogFileManager = "true";
        }
    }

    // Add core JavaScript global variables
    $html = json_encode($html);
    $script = <<<HTML
<script type="text/javascript">
    var geeklogEditorName = "{$name}";
    var geeklogAllowedHtml = {$html};
    var geeklogFileManager = {$geeklogFileManager};
</script>
HTML;
    $_SCRIPTS->setJavaScript($script);

    $function = 'adveditor_init_' . $name;
    if (function_exists($function)) {
        $function();
    }

    $function = 'adveditor_setup_' . $name;
    if (function_exists($function)) {
        $function($custom);

        return;
    }

    if (empty($js)) {
        return;
    }

    // Add JavaScript
    $_SCRIPTS->setJavaScriptFile("adveditor_$name", "/$dir/$name/$js", $footer, $priority);
    $_SCRIPTS->setJavaScriptFile('adveditor_main', '/javascript/advanced_editor.js', $footer, $priority + 1);
    $_SCRIPTS->setJavaScriptFile("adveditor_api_$name", "/$dir/$name/functions.js", $footer, $priority + 2);
    $_SCRIPTS->setJavaScriptFile('adveditor_custom', $custom, $footer, $priority + 3);      
}

/**
 * Default exception handler
 *
 * @param  Throwable|Exception $exception
 */
function COM_handleException($exception)
{
    COM_handleError((int) $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTrace());
    die(1);
}

/**
 * Return a URL to a given document file
 *
 * @param  string $baseDirectory the name of directory relative to $_CONF['path_html'], e.g., 'docs', 'help'
 * @param  string $fileName
 * @return string|false            false when the given file is missing
 * @throws InvalidArgumentException
 */
function COM_getDocumentUrl($baseDirectory, $fileName)
{
    global $_CONF;

    if (strpos($baseDirectory, '..') !== false) {
        throw new InvalidArgumentException(__FUNCTION__ . ': directory traversal attack detected');
    }

    $baseDirectory = trim($baseDirectory, '/\\') . DIRECTORY_SEPARATOR;
    $language = COM_getLanguageName();
    $fileName = basename($fileName);
    $path = $_CONF['path_html'] . $baseDirectory . $language . DIRECTORY_SEPARATOR . $fileName;

    if (!file_exists($path)) {
        $path = $_CONF['path_html'] . $baseDirectory . 'english' . DIRECTORY_SEPARATOR . $fileName;
    }

    if (!file_exists($path)) {
        // Maybe old directory structure without language subdirectories
        $path = $_CONF['path_html'] . $baseDirectory . $fileName;

        if (!file_exists($path)) {
            return false;
        }
    }

    $retval = str_replace($_CONF['path_html'], $_CONF['site_url'] . '/', $path);
    $retval = str_replace('\\', '/', $retval);

    return $retval;
}

/**
 * Return if developer mode is set
 *
 * @since  v2.2.0
 * @return bool   true = developer mode on, false otherwise
 */
function COM_isDeveloperMode()
{
    global $_CONF;

    return isset($_CONF['developer_mode']) && ($_CONF['developer_mode'] === true);
}

/**
 * Return if we should enable the detailed logging of some kind in developer mode
 *
 * @param  string $type
 * @since  v2.2.0
 * @return bool true = detailed logging is enabled, false otherwise
 */
function COM_isEnableDeveloperModeLog($type)
{
    global $_CONF;

    $type = strtolower($type);
    $retval = COM_isDeveloperMode() &&
        isset($_CONF['developer_mode_log'], $_CONF['developer_mode_log'][$type]) &&
        $_CONF['developer_mode_log'][$type];

    return $retval;
}

/**
 * Return if we are in demo mode
 *
 * @return bool  true if we are in demo mode, false otherwise
 * @since  Geeklog 2.2.1
 */
function COM_isDemoMode()
{
    global $_CONF;

    return isset($_CONF['demo_mode']) && $_CONF['demo_mode'];
}

// Now include all plugin functions
foreach ($_PLUGINS as $pi_name) {
    require_once $_CONF['path'] . 'plugins/' . $pi_name . '/functions.inc';
}

/**
 * Return the actual admin/install directory
 *
 * @return string
 * @since  Geeklog 2.2.1
 */
function COM_getInstallDir()
{
    global $_CONF;

    $adminUrl = $_CONF['site_admin_url'];
    if (strrpos($adminUrl, '/') == strlen($adminUrl)) {
        $adminUrl = substr($adminUrl, 0, -1);
    }

    $pos = strrpos($adminUrl, '/');
    if ($pos === false) {
        // only guessing ...
        $installDir = $_CONF['path_html'] . 'admin/install';
    } else {
        $installDir = $_CONF['path_html'] . substr($adminUrl, $pos + 1) . '/install';
    }
    $installDir = str_replace('\\', '/', $installDir);

    return is_dir($installDir) ? $installDir : '';
}

// Check and see if any plugins (or custom functions)
// have scheduled tasks to perform
if (!isset($_VARS['last_scheduled_run']) || !is_numeric($_VARS['last_scheduled_run'])) {
    $_VARS['last_scheduled_run'] = 0;
}
if ($_CONF['cron_schedule_interval'] > 0 && COM_onFrontpage()) {
    if (($_VARS['last_scheduled_run'] + $_CONF['cron_schedule_interval']) <= time()) {
        DB_query("UPDATE {$_TABLES['vars']} SET value=UNIX_TIMESTAMP() WHERE name='last_scheduled_run'");
        PLG_runScheduledTask();
    }
}

define('GL_INITIALIZED', true);
