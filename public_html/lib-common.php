<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | lib-common.php                                                            |
// |                                                                           |
// | Geeklog common library.                                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
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

// Prevent PHP from reporting uninitialized variables
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR | E_USER_ERROR);

/**
* This is the common library for Geeklog.  Through our code, you will see
* functions with the COM_ prefix (e.g. COM_siteHeader()).  Any such functions
* can be found in this file.
*
* --- You don't need to modify anything in this file! ---
*
* WARNING: put any custom hacks in lib-custom.php and not in here.  This file is
* modified frequently by the Geeklog development team.  If you put your hacks in
* lib-custom.php you will find upgrading much easier.
*
*/

/**
* Turn this on to get various debug messages from the code in this library
* @global Boolean $_COM_VERBOSE
*/
$_COM_VERBOSE = false;

/**
* Prevent getting any surprise values. But we should really stop
* using $_REQUEST altogether.
*/
$_REQUEST = array_merge($_GET, $_POST);

/**
* Here, we shall establish an error handler. This will mean that whenever a
* php level error is encountered, our own code handles it. This will hopefuly
* go someway towards preventing nasties like path exposures from ever being
* possible. That is, unless someone has overridden our error handler with one
* with a path exposure issue...
*
* Must make sure that the function hasn't been disabled before calling it.
*
*/ 
if (function_exists('set_error_handler')) {
    /* Tell the error handler to use the default error reporting options.
     * You may like to change this to use it in more/less cases, if so,
     * just use the syntax used in the call to error_reporting() above.
     */
    $defaultErrorHandler = set_error_handler('COM_handleError',
                                             error_reporting());
}

/**
* Configuration Include:
* You do NOT need to modify anything here any more!
*/
require_once 'siteconfig.php';

COM_checkInstalled();

/**
* Configuration class
*/
require_once $_CONF['path_system'] . 'classes/config.class.php';

$config =& config::get_instance();
$config->set_configfile($_CONF['path'] . 'db-config.php');
$config->load_baseconfig();
$config->initConfig();

$_CONF = $config->get_config('Core');

// Get features that has ft_name like 'config%'
$_CONF_FT = $config->_get_config_features();

// Before we do anything else, check to ensure site is enabled

if (isset($_CONF['site_enabled']) && !$_CONF['site_enabled']) {

    if (empty($_CONF['site_disabled_msg'])) {
        header("HTTP/1.1 503 Service Unavailable");
        header("Status: 503 Service Unavailable");
        header('Content-Type: text/plain; charset=' . COM_getCharset());
        echo $_CONF['site_name'] . ' is temporarily down.  Please check back soon.' . LB;
    } else {
        // if the msg starts with http: assume it's a URL we should redirect to
        if (preg_match("/^(https?):/", $_CONF['site_disabled_msg']) === 1) {
            echo COM_refresh($_CONF['site_disabled_msg']);
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
if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-common.php') !== false) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}


// +---------------------------------------------------------------------------+
// | Library Includes: You shouldn't have to touch anything below here         |
// +---------------------------------------------------------------------------+

/**
* If needed, add our PEAR path to the list of include paths
*
*/
if (! $_CONF['have_pear']) {
    $curPHPIncludePath = get_include_path();
    if (empty($curPHPIncludePath)) {
        $curPHPIncludePath = $_CONF['path_pear'];
    } else {
        $curPHPIncludePath = $_CONF['path_pear'] . PATH_SEPARATOR
                           . $curPHPIncludePath;
    }

    if (set_include_path($curPHPIncludePath) === false) {
        COM_errorLog('set_include_path failed - there may be problems using the PEAR classes.', 1);
    }
}

/**
* Set the webserver's timezone
*/

require_once $_CONF['path_system'] . 'classes/timezoneconfig.class.php';
TimeZoneConfig::setSystemTimeZone();

/**
* Include plugin class.
* This is a poorly implemented class that was not very well thought out.
* Still very necessary
*
*/

require_once( $_CONF['path_system'] . 'lib-plugins.php' );

/**
* Include page time -- used to time how fast each page was created
*
*/

require_once( $_CONF['path_system'] . 'classes/timer.class.php' );
$_PAGE_TIMER = new timerobject();
$_PAGE_TIMER->startTimer();

/**
* Include URL class
*
* This provides optional URL rewriting functionality.
*/

require_once( $_CONF['path_system'] . 'classes/url.class.php' );
$_URL = new url( $_CONF['url_rewrite'] );

/**
* This is our HTML template class.  It is the same one found in PHPLib and is
* licensed under the LGPL.  See that file for details.
*
*/

require_once( $_CONF['path_system'] . 'classes/template.class.php' );

/**
* This is the security library used for application security
*
*/

require_once( $_CONF['path_system'] . 'lib-security.php' );

/**
* This is the syndication library used to offer (RSS) feeds.
*
*/

require_once( $_CONF['path_system'] . 'lib-syndication.php' );

/**
* This is the topic library used to manage topics.
*
*/

require_once( $_CONF['path_system'] . 'lib-topic.php' );

/**
* Retrieve new topic or get last topic.
*
*/

if (isset($_GET['topic'])) {
    $topic = COM_applyFilter( $_GET['topic'] );
} elseif (isset( $_POST['topic'])) {
    $topic = COM_applyFilter( $_POST['topic'] );
} else {
    $topic = '';
}

/**
* This is the block library used to manage blocks.
*
*/

require_once( $_CONF['path_system'] . 'lib-block.php' );

/**
 *These variables were taken out of the configuration and placed here since they
 *are necessary to change with the themes, not whole sites. They should now be
 *overridden by setting them to a different value than here in the theme's
 *function.php or in lib-custom.php. Therefore they are NOT TO BE CHANGED HERE.
 */
$_CONF['left_blocks_in_footer'] = 0;  // use left blocks in header
$_CONF['right_blocks_in_footer'] = 1;  // use right blocks in footer

/**
* This is the custom library.
*
* It is the sandbox for every Geeklog Admin to play in.
* The lib-custom.php as shipped will never contain required code,
* so it's safe to always use your own copy.
* This should hold all custom hacks to make upgrading easier.
*
*/

require_once( $_CONF['path_system'] . 'lib-custom.php' );

/**
* Session management library
*
*/

require_once( $_CONF['path_system'] . 'lib-sessions.php' );
TimeZoneConfig::setUserTimeZone();

if (COM_isAnonUser()) {
    $_USER['advanced_editor'] = $_CONF['advanced_editor'];
}


/**
* Ulf Harnhammar's kses class
*
*/

require_once( $_CONF['path_system'] . 'classes/kses.class.php' );

/**
* Multibyte functions
*
*/
require_once( $_CONF['path_system'] . 'lib-mbyte.php' );

// Set theme

$usetheme = '';
if( isset( $_POST['usetheme'] ))
{
    $usetheme = COM_sanitizeFilename($_POST['usetheme'], true);
}
if( !empty( $usetheme ) && is_dir( $_CONF['path_themes'] . $usetheme ))
{
    $_CONF['theme'] = $usetheme;
    $_CONF['path_layout'] = $_CONF['path_themes'] . $_CONF['theme'] . '/';
    $_CONF['layout_url'] = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
}
else if( $_CONF['allow_user_themes'] == 1 )
{
    if( isset( $_COOKIE[$_CONF['cookie_theme']] ) && empty( $_USER['theme'] ))
    {
        $theme = COM_sanitizeFilename($_COOKIE[$_CONF['cookie_theme']], true);
        if( is_dir( $_CONF['path_themes'] . $theme ))
        {
            $_USER['theme'] = $theme;
        }
    }

    if( !empty( $_USER['theme'] ))
    {
        if( is_dir( $_CONF['path_themes'] . $_USER['theme'] ))
        {
            $_CONF['theme'] = $_USER['theme'];
            $_CONF['path_layout'] = $_CONF['path_themes'] . $_CONF['theme'] . '/';
            $_CONF['layout_url'] = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
        }
        else
        {
            $_USER['theme'] = $_CONF['theme'];
        }
    }
}

/**
* Include the Scripts class
*
* This provides the ability to set css and javascript.
*/

require_once( $_CONF['path_system'] . 'classes/scripts.class.php' );
$_SCRIPTS = new scripts();

/**
* Include theme functions file which may/may not do anything
*/
if (file_exists($_CONF['path_layout'] . 'functions.php')) {
    require_once $_CONF['path_layout'] . 'functions.php';
}

/**
 * Get the configuration values from the theme
 */
$func = "theme_config_" . $_CONF['theme'];
if (function_exists($func)) {
    $theme_config = $func();
    $_CONF['doctype'] = $theme_config['doctype'];
    $_IMAGE_TYPE = $theme_config['image_type'];
}
/**
* themes can specify the default image type
* fall back to 'gif' if they don't
*/
if (empty($_IMAGE_TYPE)) {
    $_IMAGE_TYPE = 'gif';
}

/**
* ensure XHTML constant is defined to avoid problems elsewhere
*/
if (! defined('XHTML')) {
    switch ($_CONF['doctype']) {
    case 'xhtml10transitional':
    case 'xhtml10strict':
        define('XHTML', ' /');
        break;

    default:
        /**
        * @ignore
        */
        define('XHTML', '');
        break;
    }
}

// Set language

if( isset( $_COOKIE[$_CONF['cookie_language']] ) && empty( $_USER['language'] ))
{
    $language = COM_sanitizeFilename($_COOKIE[$_CONF['cookie_language']]);
    if( is_file( $_CONF['path_language'] . $language . '.php' ) &&
            ( $_CONF['allow_user_language'] == 1 ))
    {
        $_USER['language'] = $language;
        $_CONF['language'] = $language;
    }
}
else if( !empty( $_USER['language'] ))
{
    if( is_file( $_CONF['path_language'] . $_USER['language'] . '.php' ) &&
            ( $_CONF['allow_user_language'] == 1 ))
    {
        $_CONF['language'] = $_USER['language'];
    }
}
else if( !empty( $_CONF['languages'] ) && !empty( $_CONF['language_files'] ))
{
    $_CONF['language'] = COM_getLanguage();
}

/**
*
* Language include
*
*/

require_once $_CONF['path_language'] . $_CONF['language'] . '.php';

if (empty($LANG_DIRECTION)) {
    // default to left-to-right
    $LANG_DIRECTION = 'ltr';
}

COM_switchLocaleSettings();

if( setlocale( LC_ALL, $_CONF['locale'] ) === false ) {
    setlocale( LC_TIME, $_CONF['locale'] );
}

/* Include scripts on behalf of the theme */
$func = "theme_css_" . $_CONF['theme'];
if (function_exists($func)) {
    foreach ($func() as $info) {
        $file = $info['file'];
        $name = md5($file);
        $constant   = (!empty($info['constant']))   ? $info['constant']   : true;
        $attributes = (!empty($info['attributes'])) ? $info['attributes'] : array();
        $_SCRIPTS->setCssFile($name, $file, $constant, $attributes);
    }
}
$func = "theme_js_libs_" . $_CONF['theme'];
if (function_exists($func)) {
    foreach ($func() as $name) {
        $_SCRIPTS->setJavaScriptLibrary($name);
    }
}
$func = "theme_js_files_" . $_CONF['theme'];
if (function_exists($func)) {
    foreach ($func() as $file) {
        $_SCRIPTS->setJavaScriptFile(md5($file), $file);
    }
}
$func = "theme_init_" . $_CONF['theme'];
if (function_exists($func)){
    $func();
}
unset(
    $theme_config,
    $func
);
// if the themes supported version of the theme engine not found assume lowest version
if (!isset($_CONF['supported_version_theme'])) {
    $_CONF['supported_version_theme'] = '1.8.1';
}

// Clear out any expired sessions
DB_query( "UPDATE {$_TABLES['sessions']} SET whos_online = 0 WHERE start_time < " . ( time() - $_CONF['whosonline_threshold'] ));

/**
* Global array of groups current user belongs to
*
* @global array $_GROUPS
*
*/

if( !COM_isAnonUser() )
{
    $_GROUPS = SEC_getUserGroups( $_USER['uid'] );
}
else
{
    $_GROUPS = SEC_getUserGroups( 1 );
}

/**
* Global array of current user permissions [read,edit]
*
* @global array $_RIGHTS
*
*/

$_RIGHTS = explode( ',', SEC_getUserPermissions() );

/**
* Build global array of Topics current user has access to
*
* @global array $_TOPICS
*
*/
$_TOPICS = TOPIC_buildTree(TOPIC_ROOT, true);

// +---------------------------------------------------------------------------+
// | HTML WIDGETS                                                              |
// +---------------------------------------------------------------------------+

/**
* Return the file to use for a block template.
*
* This returns the template needed to build the HTML for a block.  This function
* allows designers to give a block it's own custom look and feel.  If no
* templates for the block are specified, the default blockheader.html and
* blockfooter.html will be used.
*
* @param        string      $blockname      corresponds to name field in block table
* @param        string      $which          can be either 'header' or 'footer' for corresponding template
* @param        string      $position       can be 'left', 'right' or blank. If set, will be used to find a side specific override template.
* @see function COM_startBlock
* @see function COM_endBlock
* @see function COM_showBlocks
* @see function COM_showBlock
* @return   string  template name
*/
function COM_getBlockTemplate( $blockname, $which, $position='' )
{
    global $_BLOCK_TEMPLATE, $_COM_VERBOSE, $_CONF;

    if( $_COM_VERBOSE )
    {
        COM_errorLog( "_BLOCK_TEMPLATE[$blockname] = " . $_BLOCK_TEMPLATE[$blockname], 1 );
    }

    if( !empty( $_BLOCK_TEMPLATE[$blockname] ))
    {
        $templates = explode( ',', $_BLOCK_TEMPLATE[$blockname] );
        if( $which == 'header' )
        {
            if( !empty( $templates[0] ))
            {
                $template = $templates[0];
            }
            else
            {
                $template = 'blockheader.thtml';
            }
        }
        else
        {
            if( !empty( $templates[1] ))
            {
                $template = $templates[1];
            }
            else
            {
                $template = 'blockfooter.thtml';
            }
        }
    }
    else
    {
        if( $which == 'header' )
        {
            $template = 'blockheader.thtml';
        }
        else
        {
            $template = 'blockfooter.thtml';
        }
    }

    // If we have a position specific request, and the template is not already
    // position specific then look to see if there is a position specific
    // override.
    $templateLC = strtolower($template);
    if( !empty($position) && ( strpos($templateLC, $position) === false ) )
    {
        // Trim .thtml from the end.
        $positionSpecific = substr($template, 0, strlen($template) - 6);
        $positionSpecific .= '-' . $position . '.thtml';
        if( file_exists( $_CONF['path_layout'] . $positionSpecific ) )
        {
            $template = $positionSpecific;
        }
    }

    if( $_COM_VERBOSE )
    {
        COM_errorLog( "Block template for the $which of $blockname is: $template", 1 );
    }

    return $template;
}

/**
* Gets all installed themes
*
* Returns a list of all the directory names in $_CONF['path_themes'], i.e.
* a list of all the theme names.
*
* @param    boolean $all    if true, return all themes even if users aren't allowed to change their default themes
* @return   array           All installed themes
*
*/
function COM_getThemes( $all = false )
{
    global $_CONF;

    $index = 1;

    $themes = array();

    // If users aren't allowed to change their theme then only return the default theme

    if(( $_CONF['allow_user_themes'] == 0 ) && !$all )
    {
        $themes[$index] = $_CONF['theme'];
    }
    else
    {
        $fd = opendir( $_CONF['path_themes'] );

        while(( $dir = @readdir( $fd )) == TRUE )
        {
            if( is_dir( $_CONF['path_themes'] . $dir) && $dir <> '.' && $dir <> '..' && $dir <> 'CVS' && substr( $dir, 0 , 1 ) <> '.' )
            {
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
* @param    Template    &$header        reference to the header template
* @param    array       $plugin_menu    array of plugin menu entries, if any
*
*/
function COM_renderMenu( &$header, $plugin_menu )
{
    global $_CONF, $LANG01, $topic;

    if( empty( $_CONF['menu_elements'] ))
    {
        $_CONF['menu_elements'] = array( // default set of links
                'contribute', 'search', 'stats', 'directory', 'plugins' );
    }

    $anon = COM_isAnonUser();
    $menuCounter = 0;
    $allowedCounter = 0;
    $counter = 0;

    $num_plugins = count( $plugin_menu );
    if( ( $num_plugins == 0 ) && in_array( 'plugins', $_CONF['menu_elements'] ))
    {
        $key = array_search( 'plugins', $_CONF['menu_elements'] );
        unset( $_CONF['menu_elements'][$key] );
    }

    if( in_array( 'custom', $_CONF['menu_elements'] ))
    {
        $custom_entries = array();
        if( function_exists( 'CUSTOM_menuEntries' ))
        {
            $custom_entries = CUSTOM_menuEntries();
        }
        if( count( $custom_entries ) == 0 )
        {
            $key = array_search( 'custom', $_CONF['menu_elements'] );
            unset( $_CONF['menu_elements'][$key] );
        }
    }

    $num_elements = count( $_CONF['menu_elements'] );

    foreach( $_CONF['menu_elements'] as $item )
    {
        $counter++;
        $allowed = true;
        $last_entry = ( $counter == $num_elements ) ? true : false;

        switch( $item )
        {
            case 'contribute':
                if (empty($topic)) {
                    $url = $_CONF['site_url'] . '/submit.php?type=story';
                    $header->set_var('current_topic', '');
                } else {
                    $tp = urlencode($topic);
                    $url = $_CONF['site_url']
                         . '/submit.php?type=story&amp;topic=' . $tp;
                    $header->set_var('current_topic', '&amp;topic=' . $tp);
                }
                $label = $LANG01[71];
                if ($anon && ($_CONF['loginrequired'] ||
                              $_CONF['submitloginrequired'])) {
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

                        $header->set_var('menuitem_url',  $entry['url']);
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
                if( !empty( $topic ))
                {
                    $url = COM_buildUrl( $url . '?topic='
                                         . urlencode( $topic ));
                }
                $label = $LANG01[117];
                if( $anon && ( $_CONF['loginrequired'] ||
                        $_CONF['directoryloginrequired'] ))
                {
                    $allowed = false;
                }
                break;

            case 'home':
                $url = $_CONF['site_url'] . '/';
                $label = $LANG01[90];
                break;

            case 'plugins':
                for( $i = 1; $i <= $num_plugins; $i++ )
                {
                    $header->set_var( 'menuitem_url', current( $plugin_menu ));
                    $header->set_var( 'menuitem_text', key( $plugin_menu ));

                    if( $last_entry && ( $i == $num_plugins ))
                    {
                        $header->parse( 'menu_elements', 'menuitem_last',
                                        true );
                    }
                    else
                    {
                        $header->parse( 'menu_elements', 'menuitem', true );
                    }
                    $menuCounter++;

                    next( $plugin_menu );
                }
                $url = '';
                $label = '';
                break;

            case 'prefs':
                $url = $_CONF['site_url'] . '/usersettings.php';
                $label = $LANG01[48];
                break;

            case 'search':
                $url = $_CONF['site_url'] . '/search.php';
                $label = $LANG01[75];
                if( $anon && ( $_CONF['loginrequired'] ||
                        $_CONF['searchloginrequired'] ))
                {
                    $allowed = false;
                }
                break;

            case 'stats':
                $url = $_CONF['site_url'] . '/stats.php';
                $label = $LANG01[76];
                if( $anon &&
                    ( $_CONF['loginrequired'] || $_CONF['statsloginrequired'] ))
                {
                    $allowed = false;
                }
                break;

            default: // unknown entry
                $url = '';
                $label = '';
                break;
        }

        if( !empty( $url ) && !empty( $label ))
        {
            $header->set_var( 'menuitem_url',  $url );
            $header->set_var( 'menuitem_text', $label );
            if( $last_entry )
            {
                $header->parse( 'menu_elements', 'menuitem_last', true );
            }
            else
            {
                $header->parse( 'menu_elements', 'menuitem', true );
            }
            $menuCounter++;

            if( $allowed )
            {
                if( $last_entry )
                {
                    $header->parse( 'allowed_menu_elements', 'menuitem_last',
                                    true );
                }
                else
                {
                    $header->parse( 'allowed_menu_elements', 'menuitem', true );
                }
                $allowedCounter++;
            }
        }
    }

    if( $menuCounter == 0 )
    {
        $header->parse( 'menu_elements', 'menuitem_none', true );
    }
    if( $allowedCounter == 0 )
    {
        $header->parse( 'allowed_menu_elements', 'menuitem_none', true );
    }
}

/**
* Returns the site header
*
* This loads the proper templates, does variable substitution and returns the
* HTML for the site header with or without blocks depending on the value of $what
*
* Programming Note:
*
* The two functions COM_siteHeader and COM_siteFooter provide the framework for
* page display in Geeklog.  COM_siteHeader controls the display of the Header
* and left blocks and COM_siteFooter controls the dsiplay of the right blocks
* and the footer.  You use them like a sandwich.  Thus the following code will
* display a Geeklog page with both right and left blocks displayed.
*
* <code>
* <?php
* require_once 'lib-common.php';
* // Change to COM_siteHeader('none') to not display left blocks
* $display .= COM_siteHeader();
* $display .= "Here is your html for display";
* // Change to COM_siteFooter() to not display right blocks
* $display .= COM_siteFooter(true);
* echo $display;
* ? >
* </code>
*
* Note that the default for the header is to display the left blocks and the
* default of the footer is to not display the right blocks.
*
* This sandwich produces code like this (greatly simplified)
* <code>
* // COM_siteHeader
* <table><tr><td colspan="3">Header</td></tr>
* <tr><td>Left Blocks</td><td>
*
* // Your HTML goes here
* Here is your html for display
*
* // COM_siteFooter
* </td><td>Right Blocks</td></tr>
* <tr><td colspan="3">Footer</td></table>
* </code>
*
* @param    string  $what       If 'none' then no left blocks are returned, if 'menu' (default) then right blocks are returned
* @param    string  $pagetitle  optional content for the page's <title>
* @param    string  $headercode optional code to go into the page's <head>
* @return   string              Formatted HTML containing the site header
* @see function COM_siteFooter
*
*/
function COM_siteHeader( $what = 'menu', $pagetitle = '', $headercode = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG_BUTTONS, $LANG_DIRECTION,
           $_IMAGE_TYPE, $topic, $_COM_VERBOSE, $_SCRIPTS;

    global $_GLOBAL_WHAT;
    $_GLOBAL_WHAT = $what;

    // If the theme implemented this for us then call their version instead.

    $function = $_CONF['theme'] . '_siteHeader';

    if( function_exists( $function ))
    {
        return $function( $what, $pagetitle, $headercode );
    }

    // If we reach here then either we have the default theme OR
    // the current theme only needs the default variable substitutions

    switch ($_CONF['doctype']) {
    case 'html401transitional':
        $doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
        break;

    case 'html401strict':
        $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
        break;

    case 'xhtml10transitional':
        $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        break;

    case 'xhtml10strict':
        $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
        break;

    default: // fallback: HTML 4.01 Transitional w/o system identifier
        $doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
        break;
    }

    // send out the charset header
    header('Content-Type: text/html; charset=' . COM_getCharset());

    if (!empty($_CONF['frame_options'])) {
        header('X-FRAME-OPTIONS: ' . $_CONF['frame_options']);
    }

    $header = COM_newTemplate($_CONF['path_layout']);
    $header->set_file( array(
        'header'        => 'header.thtml',
        'menuitem'      => 'menuitem.thtml',
        'menuitem_last' => 'menuitem_last.thtml',
        'menuitem_none' => 'menuitem_none.thtml',
        'leftblocks'    => 'leftblocks.thtml',
        'rightblocks'   => 'rightblocks.thtml'
        ));
    
    $header->postprocess_fn = 'PLG_replaceTags';
    
    $header->set_var('doctype', $doctype);
    
    if (XHTML == '') {
        $header->set_var('xmlns', '');
    } else {
        $header->set_var('xmlns', ' xmlns="http://www.w3.org/1999/xhtml"');
    }

    $feed_url = array();
    if( $_CONF['backend'] == 1 ) // add feed-link to header if applicable
    {
        $baseurl = SYND_getFeedUrl();

        $sql = 'SELECT format, filename, title, language FROM '
             . $_TABLES['syndication'] . " WHERE (header_tid = 'all')";
        if( !empty( $topic ))
        {
            $sql .= " OR (header_tid = '" . addslashes( $topic ) . "')";
        }
        $result = DB_query( $sql );
        $numRows = DB_numRows( $result );
        for( $i = 0; $i < $numRows; $i++ )
        {
            $A = DB_fetchArray( $result );
            if ( !empty( $A['filename'] ))
            {
                $format_type = SYND_getMimeType($A['format']);
                $format_name = SYND_getFeedType($A['format']);
                $feed_title = $format_name . ' Feed: ' . $A['title'];

                $feed_url[] = '<link rel="alternate" type="' . $format_type
                            . '" hreflang="' . $A['language'] . '" href="'
                            . $baseurl . $A['filename'] . '" title="'
                            . htmlspecialchars($feed_title) . '"' . XHTML . '>';
            }
        }
    }
    $header->set_var( 'feed_url', implode( LB, $feed_url ));

    // for backward compatibility only - use {feed_url} instead
    $feed = SYND_getDefaultFeedUrl();
    $header->set_var('rdf_file', $feed);
    $header->set_var('rss_url', $feed);

    $relLinks = array();
    if (COM_onFrontpage()) {
        $relLinks['canonical'] = '<link rel="canonical" href="'
                               . $_CONF['site_url'] . '/"' . XHTML . '>';
    } else {
        $relLinks['home'] = '<link rel="home" href="' . $_CONF['site_url']
                          . '/" title="' . $LANG01[90] . '"' . XHTML . '>';
    }
    $loggedInUser = !COM_isAnonUser();
    if( $loggedInUser || (( $_CONF['loginrequired'] == 0 ) &&
                ( $_CONF['searchloginrequired'] == 0 )))
    {
        if(( substr( $_SERVER['PHP_SELF'], -strlen( '/search.php' ))
                != '/search.php' ) || isset( $_GET['mode'] ))
        {
            $relLinks['search'] = '<link rel="search" href="'
                                . $_CONF['site_url'] . '/search.php" title="'
                                . $LANG01[75] . '"' . XHTML . '>';
        }
    }
    if( $loggedInUser || (( $_CONF['loginrequired'] == 0 ) &&
                ( $_CONF['directoryloginrequired'] == 0 )))
    {
        if( strpos( $_SERVER['PHP_SELF'], '/article.php' ) !== false ) {
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
    $header->set_var( 'rel_links', implode( LB, $relLinks ));

    $pagetitle_siteslogan = false;
    if( empty( $pagetitle ))
    {
        if( empty( $topic ))
        {
            $pagetitle = $_CONF['site_slogan'];
            $pagetitle_siteslogan = true;
        }
        else
        {
            $pagetitle = stripslashes( DB_getItem( $_TABLES['topics'], 'topic',
                                                   "tid = '$topic'" ));
        }
    }
    if( !empty( $pagetitle ))
    {
        $header->set_var( 'page_site_splitter', ' - ');
    }
    else
    {
        $header->set_var( 'page_site_splitter', '');
    }
    $header->set_var( 'page_title', $pagetitle );
    $header->set_var( 'site_name', $_CONF['site_name']);

    if (COM_onFrontpage() OR $pagetitle_siteslogan) {
        $title_and_name = $_CONF['site_name'];
        if (!empty($pagetitle)) {
            $title_and_name .= ' - ' . $pagetitle;
        }
    } else {
        $title_and_name = '';
        if (!empty($pagetitle)) {
            $title_and_name = $pagetitle . ' - ';
        }
        $title_and_name .= $_CONF['site_name'];
    }
    $header->set_var('page_title_and_site_name', $title_and_name);

    COM_setLangIdAndAttribute($header);

    $header->set_var( 'background_image', $_CONF['layout_url']
                                          . '/images/bg.' . $_IMAGE_TYPE );
    $header->set_var( 'site_mail', "mailto:{$_CONF['site_mail']}" );
    $header->set_var( 'site_name', $_CONF['site_name'] );
    $header->set_var( 'site_slogan', $_CONF['site_slogan'] );

    $msg = rtrim($LANG01[67]) . ' ' . $_CONF['site_name'];

    if( !empty( $_USER['username'] ))
    {
        $msg .= ', ' . COM_getDisplayName( $_USER['uid'], $_USER['username'],
                                           $_USER['fullname'] );
    }

    $curtime =  COM_getUserDateTimeFormat();

    $header->set_var( 'welcome_msg', $msg );
    $header->set_var( 'datetime', $curtime[0] );
    $header->set_var( 'site_logo', $_CONF['layout_url']
                                   . '/images/logo.' . $_IMAGE_TYPE );
    $header->set_var( 'theme', $_CONF['theme'] );

    $header->set_var('charset', COM_getCharset());
    $header->set_var('direction', $LANG_DIRECTION);

    // Now add variables for buttons like e.g. those used by the Yahoo theme
    $header->set_var( 'button_home', $LANG_BUTTONS[1] );
    $header->set_var( 'button_contact', $LANG_BUTTONS[2] );
    $header->set_var( 'button_contribute', $LANG_BUTTONS[3] );
    $header->set_var( 'button_sitestats', $LANG_BUTTONS[7] );
    $header->set_var( 'button_personalize', $LANG_BUTTONS[8] );
    $header->set_var( 'button_search', $LANG_BUTTONS[9] );
    $header->set_var( 'button_advsearch', $LANG_BUTTONS[10] );
    $header->set_var( 'button_directory', $LANG_BUTTONS[11] );

    // Get plugin menu options
    $plugin_menu = PLG_getMenuItems();

    if( $_COM_VERBOSE )
    {
        COM_errorLog( 'num plugin menu items in header = ' . count( $plugin_menu ), 1 );
    }

    // Now add nested template for menu items
    COM_renderMenu( $header, $plugin_menu );

    if( count( $plugin_menu ) == 0 )
    {
        $header->parse( 'plg_menu_elements', 'menuitem_none', true );
    }
    else
    {
        $count_plugin_menu = count( $plugin_menu );
        for( $i = 1; $i <= $count_plugin_menu; $i++ )
        {
            $header->set_var( 'menuitem_url', current( $plugin_menu ));
            $header->set_var( 'menuitem_text', key( $plugin_menu ));

            if( $i == $count_plugin_menu )
            {
                $header->parse( 'plg_menu_elements', 'menuitem_last', true );
            }
            else
            {
                $header->parse( 'plg_menu_elements', 'menuitem', true );
            }

            next( $plugin_menu );
        }
    }

    // Call to plugins to set template variables in the header
    PLG_templateSetVars( 'header', $header );

    if( $_CONF['left_blocks_in_footer'] == 1 )
    {
        $header->set_var( 'left_blocks', '' );
        $header->set_var( 'geeklog_blocks', '' );
    }
    else
    {
        $lblocks = '';

        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function
         * This can be used to take control over what blocks are then displayed
         */
        if( is_array( $what ))
        {
            $function = $what[0];
            if( function_exists( $function ))
            {
                $lblocks = $function( $what[1], 'left' );
            }
            else
            {
                $lblocks = COM_showBlocks( 'left', $topic );
            }
        }
        else if( $what <> 'none' )
        {
            // Now show any blocks -- need to get the topic if not on home page
            $lblocks = COM_showBlocks( 'left', $topic );
        }

        if( empty( $lblocks ))
        {
            $header->set_var( 'left_blocks', '' );
            $header->set_var( 'geeklog_blocks', '' );
        }
        else
        {
            $header->set_var( 'geeklog_blocks', $lblocks );
            $header->parse( 'left_blocks', 'leftblocks', true );
            $header->set_var( 'geeklog_blocks', '');
        }
    }

    if( $_CONF['right_blocks_in_footer'] == 1 )
    {
        $header->set_var( 'right_blocks', '' );
        $header->set_var( 'geeklog_blocks', '' );
    }
    else
    {
        $rblocks = '';

        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function
         * This can be used to take control over what blocks are then displayed
         */
        if( is_array( $what ))
        {
            $function = $what[0];
            if( function_exists( $function ))
            {
                $rblocks = $function( $what[1], 'right' );
            }
            else
            {
                $rblocks = COM_showBlocks( 'right', $topic );
            }
        }
        else if( $what <> 'none' )
        {
            // Now show any blocks -- need to get the topic if not on home page
            $rblocks = COM_showBlocks( 'right', $topic );
        }

        if( empty( $rblocks ))
        {
            $header->set_var( 'right_blocks', '' );
            $header->set_var( 'geeklog_blocks', '' );
        }
        else
        {
            $header->set_var( 'geeklog_blocks', $rblocks, true );
            $header->parse( 'right_blocks', 'rightblocks', true );
        }
    }
    
    // Set last topic session variable
    SESS_setVariable('topic', $topic);

    // Call any plugin that may want to include extra Meta tags
    // or Javascript functions
    $headercode .= PLG_getHeaderCode();
    
    // Meta Tags
    // 0 = Disabled, 1 = Enabled, 2 = Enabled but default just for homepage
    if ($_CONF['meta_tags'] > 0) {
        $meta_description = '';
        $meta_keywords = '';
        $no_meta_description = 1;
        $no_meta_keywords = 1;
        
        //Find out if the meta tag description or keywords already exist in the headercode
        if ($headercode != '') { 
            $pattern = '/<meta ([^>]*)name="([^"\'>]*)"([^>]*)/im'; 
            if (preg_match_all($pattern, $headercode, $matches, PREG_SET_ORDER)) {
                // Loop through all meta tags looking for description and keywords
                for ($i = 0; $i<count($matches) && (($no_meta_description == 1) || ($no_meta_keywords == 1)); $i++) { 
                    $str_matches = strtolower($matches[$i][0]); 
                    $pos = strpos($str_matches,'name='); 
                    if (!(is_bool($pos) && !$pos)) { 
                        $name = trim(substr($str_matches,$pos+5),'"'); 
                        $pos = strpos($name,'"'); 
                        $name = substr($name,0,$pos); 

                        if (strcasecmp("description",$name) == 0) { 
                            $pos = strpos($str_matches,'content='); 
                            if (!(is_bool($pos) && !$pos)) {
                                $no_meta_description = 0;
                            }
                        }
                        if (strcasecmp("keywords",$name) == 0) { 
                            $pos = strpos($str_matches,'content='); 
                            if (!(is_bool($pos) && !$pos)) {
                                $no_meta_keywords = 0;
                            }
                        }
                        
                    }
                }
            } 
        }
        
        If (COM_onFrontpage() && $_CONF['meta_tags'] == 2) { // Display default meta tags only on home page
            If ($no_meta_description) {
                $meta_description = $_CONF['meta_description'];
            }
            If ($no_meta_keywords) {
                $meta_keywords = $_CONF['meta_keywords'];
            }
        } else if ( $_CONF['meta_tags'] == 1 ) { // Display default meta tags anywhere there are no tags
            If ($no_meta_description) {
                $meta_description = $_CONF['meta_description'];
            }
            If ($no_meta_keywords) {
                $meta_keywords = $_CONF['meta_keywords'];
            }            
        }
        
        If ($no_meta_description OR $no_meta_keywords) {
            $headercode .= COM_createMetaTags($meta_description, $meta_keywords);
        }
    }
    
    $headercode = $_SCRIPTS->getHeader() . $headercode;
    $header->set_var( 'plg_headercode', $headercode );

    // The following lines allow users to embed PHP in their templates.  This
    // is almost a contradition to the reasons for using templates but this may
    // prove useful at times ...
    // Don't use PHP in templates if you can live without it!

    $tmp = $header->finish($header->parse('index_header', 'header'));

    $xml_declaration = '';
    if ( get_cfg_var('short_open_tag') == '1' )
    {
        if ( preg_match( '/(<\?xml[^>]*>)(.*)/s', $tmp, $match ) )
        {
            $xml_declaration = $match[1] . LB;
            $tmp = $match[2];
        }
    }

    ob_start();
    eval( '?>' . $tmp );
    $retval = $xml_declaration . ob_get_contents();
    ob_end_clean();

    return $retval;
}


/**
* Returns the site footer
*
* This loads the proper templates, does variable substitution and returns the
* HTML for the site footer.
*
* @param   boolean     $rightblock     Whether or not to show blocks on right hand side default is no
* @param   array       $custom         An array defining custom function to be used to format Rightblocks
* @see function COM_siteHeader
* @return   string  Formated HTML containing site footer and optionally right blocks
*
*/
function COM_siteFooter( $rightblock = -1, $custom = '' )
{
    global $_CONF, $_TABLES, $LANG01, $_PAGE_TIMER, $topic, $LANG_BUTTONS, $_SCRIPTS;
    global $_GLOBAL_WHAT;

    // If the theme implemented this for us then call their version instead.

    $function = $_CONF['theme'] . '_siteFooter';

    if( function_exists( $function ))
    {
        return $function( $rightblock, $custom );
    }

    COM_hit();

    // Set template directory
    $footer = COM_newTemplate($_CONF['path_layout']);

    // Set template file
    $footer->set_file( array(
            'footer'      => 'footer.thtml',
            'rightblocks' => 'rightblocks.thtml',
            'leftblocks'  => 'leftblocks.thtml'
            ));
    
    // Needed to set for pre (instead of post) since JavaScript could contain 
    // autotag labels (like in configuration search) 
    $footer->preprocess_fn = 'PLG_replaceTags';

    // Do variable assignments
    $footer->set_var( 'site_mail', "mailto:{$_CONF['site_mail']}" );
    $footer->set_var( 'site_name', $_CONF['site_name'] );
    $footer->set_var( 'site_slogan', $_CONF['site_slogan'] );

    $feed = SYND_getDefaultFeedUrl();
    $footer->set_var('rdf_file', $feed);
    $footer->set_var('rss_url', $feed);

    $year = date( 'Y' );
    $copyrightyear = $year;
    if(!empty($_CONF['copyrightyear'])) {
        $copyrightyear = $_CONF['copyrightyear'];
    }
    if(!empty($_CONF['owner_name'])) {
        $copyrightname = $_CONF['owner_name'];
    } else {
        $copyrightname = $_CONF['site_name'];
    }
    $footer->set_var( 'copyright_notice', '&nbsp;' . $LANG01[93] . ' &copy; '
            . $copyrightyear . ' ' . $copyrightname . '<br' . XHTML . '>&nbsp;'
            . $LANG01[94] );
    $footer->set_var( 'copyright_msg', $LANG01[93] . ' &copy; '
            . $copyrightyear . ' ' . $_CONF['site_name'] );
    $footer->set_var( 'current_year', $year );
    $footer->set_var( 'lang_copyright', $LANG01[93] );
    $footer->set_var( 'trademark_msg', $LANG01[94] );
    $footer->set_var( 'powered_by', $LANG01[95] );
    $footer->set_var( 'geeklog_url', 'http://www.geeklog.net/' );
    $footer->set_var( 'geeklog_version', VERSION );
    // Now add variables for buttons like e.g. those used by the Yahoo theme
    $footer->set_var( 'button_home', $LANG_BUTTONS[1] );
    $footer->set_var( 'button_contact', $LANG_BUTTONS[2] );
    $footer->set_var( 'button_contribute', $LANG_BUTTONS[3] );
    $footer->set_var( 'button_sitestats', $LANG_BUTTONS[7] );
    $footer->set_var( 'button_personalize', $LANG_BUTTONS[8] );
    $footer->set_var( 'button_search', $LANG_BUTTONS[9] );
    $footer->set_var( 'button_advsearch', $LANG_BUTTONS[10] );
    $footer->set_var( 'button_directory', $LANG_BUTTONS[11] );

    /* Right blocks. Argh. Don't talk to me about right blocks...
     * Right blocks will be displayed if Right_blocks_in_footer is set [1],
     * AND (this function has been asked to show them (first param) OR the
     * show_right_blocks conf variable has been set to override what the code
     * wants to do.
     *
     * If $custom sets an array (containing functionname and first argument)
     * then this is used instead of the default (COM_showBlocks) to render
     * the right blocks (and left).
     *
     * [1] - if it isn't, they'll be in the header already.
     *
     */
    $displayRightBlocks = true;
    if ($_CONF['right_blocks_in_footer'] == 1)
    {
        if( ($rightblock < 0) || !$rightblock )
        {
            if( isset( $_CONF['show_right_blocks'] ) )
            {
                $displayRightBlocks = $_CONF['show_right_blocks'];
            }
            else
            {
                $displayRightBlocks = false;
            }
        } else {
            $displayRightBlocks = true;
        }
    } else {
        $displayRightBlocks = false;
    }
    
    if ($displayRightBlocks)
    {
        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function.
         * This can be used to take control over what blocks are then displayed
         */
        if( is_array( $custom ))
        {
            $function = $custom['0'];
            if( function_exists( $function ))
            {
                $rblocks = $function( $custom['1'], 'right' );
            } else {
                $rblocks = COM_showBlocks( 'right', $topic );
            }
        } else {
            $rblocks = COM_showBlocks( 'right', $topic );
        }
        
        if( empty( $rblocks ))
        {
            $footer->set_var( 'geeklog_blocks', '');
            $footer->set_var( 'right_blocks', '' );
        } else {
            $footer->set_var( 'geeklog_blocks', $rblocks);
            $footer->parse( 'right_blocks', 'rightblocks', true );
            $footer->set_var( 'geeklog_blocks', '');
        }
    } else {
        $footer->set_var( 'geeklog_blocks', '');
        $footer->set_var( 'right_blocks', '' );
    }

    if( $_CONF['left_blocks_in_footer'] == 1 )
    {
        $lblocks = '';

        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function
         * This can be used to take control over what blocks are then displayed
         */
        if( is_array( $custom ))
        {
            $function = $custom[0];
            if( function_exists( $function ))
            {
                $lblocks = $function( $custom[1], 'left' );
            }
        }
        else
        {
            if ($_GLOBAL_WHAT <> 'none') {
                $lblocks = COM_showBlocks( 'left', $topic );
            }
        }

        if( empty( $lblocks ))
        {
            $footer->set_var( 'left_blocks', '' );
            $footer->set_var( 'geeklog_blocks', '');
        }
        else
        {
            $footer->set_var( 'geeklog_blocks', $lblocks);
            $footer->parse( 'left_blocks', 'leftblocks', true );
            $footer->set_var( 'geeklog_blocks', '');
        }
    }

    // Global centerspan variable set in index.php
    if( isset( $GLOBALS['centerspan'] ))
    {
        $footer->set_var( 'centerblockfooter-span', '</td></tr></table>' );
    }

    $exectime = $_PAGE_TIMER->stopTimer();
    $exectext = $LANG01[91] . ' ' . $exectime . ' ' . $LANG01[92];

    $footer->set_var( 'execution_time', $exectime );
    $footer->set_var( 'execution_textandtime', $exectext );

    // Call to plugins to set template variables in the footer
    PLG_templateSetVars( 'footer', $footer );

    // Call any plugin that may want to include extra JavaScript functions
    $plugin_footercode = PLG_getFooterCode();
 
    // Retrieve any JavaScript libraries, variables and functions
    $footercode = $_SCRIPTS->getFooter();
 
    // $_SCRIPTS code should be placed before plugin_footer_code but plugin_footer_code should still be allowed to set $_SCRIPTS
    $footercode .= $plugin_footercode;
    
    $footer->set_var('plg_footercode', $footercode);

    // Actually parse the template and make variable substitutions
    $footer->parse( 'index_footer', 'footer' );

    // Return resulting HTML
    return $footer->finish( $footer->get_var( 'index_footer' ));
}


/**
* Create and return the HTML document
*
* @param    string  $content        Main content for the page
* @param    array   $information    An array defining variables to be used when creating the output
*                       string  'what'          If 'none' then no left blocks are returned, if 'menu' (default) then right blocks are returned
*                       string  'pagetitle'     Optional content for the page's <title>
*                       string  'breadcrumbs'   Optional content for the page's <title>
*                       string  'headercode'    Optional code to go into the page's <head>
*                       boolean 'rightblock'    Whether or not to show blocks on right hand side default is no (-1)
*                       array   'custom'        An array defining custom function to be used to format Rightblocks
* @see      function COM_siteHeader
* @see      function COM_siteFooter
* @return   string              Formated HTML document
*
*/
function COM_createHTMLDocument(&$content = '', $information = array())
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG_BUTTONS, $LANG_DIRECTION,
           $_IMAGE_TYPE, $topic, $_COM_VERBOSE, $_SCRIPTS, $_PAGE_TIMER;

   // Retrieve required variables from information array
   if (isset($information['what'])) {
       $what = $information['what'];
   } else {
       $what = 'menu';
   }
   if (isset($information['pagetitle'])) {
       $pagetitle = $information['pagetitle'];
   } else {
       $pagetitle = '';
   }
   if (isset($information['headercode'])) {
       $headercode = $information['headercode'];
   } else {
       $headercode = '';
   }
   if (isset($information['breadcrumbs'])) {
       $breadcrumbs = $information['breadcrumbs'];
   } else {
       $breadcrumbs = '';
   }
   if (isset($information['rightblock'])) {
       $rightblock = $information['rightblock'];
   } else {
       $rightblock = -1;
   } 
   if (isset($information['custom'])) {
       $custom = $information['custom'];
   } else {
       $custom = '';
   }  

    // If the theme does not support the CSS layout then call the legacy functions (Geeklog 1.8.1 and older).
    if ($_CONF['supported_version_theme'] == '1.8.1') {
        return COM_siteHeader($what, $pagetitle, $headercode) . $content
             . COM_siteFooter($rightblock, $custom);
    }

    // If the theme implemented this for us then call their version instead.
    $function = $_CONF['theme'] . '_createHTMLDocument';

    if( function_exists($function)) {
        return $function( $content, $what, $pagetitle, $headercode, $rightblock, $custom );
    }

    // If we reach here then either we have the default theme OR
    // the current theme only needs the default variable substitutions

    switch ($_CONF['doctype']) {
    case 'html401transitional':
        $doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
        break;

    case 'html401strict':
        $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
        break;

    case 'xhtml10transitional':
        $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        break;

    case 'xhtml10strict':
        $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
        break;

    default: // fallback: HTML 4.01 Transitional w/o system identifier
        $doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
        break;
    }

    // send out the charset header
    header('Content-Type: text/html; charset=' . COM_getCharset());

    if (!empty($_CONF['frame_options'])) {
        header('X-FRAME-OPTIONS: ' . $_CONF['frame_options']);
    }

    $header = COM_newTemplate($_CONF['path_layout']);
    $header->set_file( array(
        'header'        => 'header.thtml',
        'menuitem'      => 'menuitem.thtml',
        'menuitem_last' => 'menuitem_last.thtml',
        'menuitem_none' => 'menuitem_none.thtml',
        'leftblocks'    => 'leftblocks.thtml',
        'rightblocks'   => 'rightblocks.thtml'
        ));
    
    $header->postprocess_fn = 'PLG_replaceTags';
    
    $header->set_var('doctype', $doctype);
    
    if (XHTML == '') {
        $header->set_var('xmlns', '');
    } else {
        $header->set_var('xmlns', ' xmlns="http://www.w3.org/1999/xhtml"');
    }

    $feed_url = array();
    if( $_CONF['backend'] == 1 ) // add feed-link to header if applicable
    {
        $baseurl = SYND_getFeedUrl();

        $sql = 'SELECT format, filename, title, language FROM '
             . $_TABLES['syndication'] . " WHERE (header_tid = 'all')";
        if( !empty( $topic ))
        {
            $sql .= " OR (header_tid = '" . addslashes( $topic ) . "')";
        }
        $result = DB_query( $sql );
        $numRows = DB_numRows( $result );
        for( $i = 0; $i < $numRows; $i++ )
        {
            $A = DB_fetchArray( $result );
            if ( !empty( $A['filename'] ))
            {
                $format_type = SYND_getMimeType($A['format']);
                $format_name = SYND_getFeedType($A['format']);
                $feed_title = $format_name . ' Feed: ' . $A['title'];

                $feed_url[] = '<link rel="alternate" type="' . $format_type
                            . '" hreflang="' . $A['language'] . '" href="'
                            . $baseurl . $A['filename'] . '" title="'
                            . htmlspecialchars($feed_title) . '"' . XHTML . '>';
            }
        }
    }
    $header->set_var( 'feed_url', implode( LB, $feed_url ));

    // for backward compatibility only - use {feed_url} instead
    $feed = SYND_getDefaultFeedUrl();

    $relLinks = array();
    if (COM_onFrontpage()) {
        $relLinks['canonical'] = '<link rel="canonical" href="'
                               . $_CONF['site_url'] . '/"' . XHTML . '>';
    } else {
        $relLinks['home'] = '<link rel="home" href="' . $_CONF['site_url']
                          . '/" title="' . $LANG01[90] . '"' . XHTML . '>';
    }
    $loggedInUser = !COM_isAnonUser();
    if( $loggedInUser || (( $_CONF['loginrequired'] == 0 ) &&
                ( $_CONF['searchloginrequired'] == 0 )))
    {
        if(( substr( $_SERVER['PHP_SELF'], -strlen( '/search.php' ))
                != '/search.php' ) || isset( $_GET['mode'] ))
        {
            $relLinks['search'] = '<link rel="search" href="'
                                . $_CONF['site_url'] . '/search.php" title="'
                                . $LANG01[75] . '"' . XHTML . '>';
        }
    }
    if( $loggedInUser || (( $_CONF['loginrequired'] == 0 ) &&
                ( $_CONF['directoryloginrequired'] == 0 )))
    {
        if( strpos( $_SERVER['PHP_SELF'], '/article.php' ) !== false ) {
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
    $header->set_var( 'rel_links', implode( LB, $relLinks ));

    $pagetitle_siteslogan = false;
    if( empty( $pagetitle ))
    {
        if( empty( $topic ))
        {
            $pagetitle = $_CONF['site_slogan'];
            $pagetitle_siteslogan = true;
        }
        else
        {
            $pagetitle = stripslashes( DB_getItem( $_TABLES['topics'], 'topic',
                                                   "tid = '$topic'" ));
        }
    }
    if( !empty( $pagetitle ))
    {
        $header->set_var( 'page_site_splitter', ' - ');
    }
    else
    {
        $header->set_var( 'page_site_splitter', '');
    }
    $header->set_var( 'page_title', $pagetitle );
    $header->set_var( 'site_name', $_CONF['site_name']);

    if (COM_onFrontpage() OR $pagetitle_siteslogan) {
        $title_and_name = $_CONF['site_name'];
        if (!empty($pagetitle)) {
            $title_and_name .= ' - ' . $pagetitle;
        }
    } else {
        $title_and_name = '';
        if (!empty($pagetitle)) {
            $title_and_name = $pagetitle . ' - ';
        }
        $title_and_name .= $_CONF['site_name'];
    }
    $header->set_var('page_title_and_site_name', $title_and_name);

    COM_setLangIdAndAttribute($header);

    $header->set_var( 'background_image', $_CONF['layout_url']
                                          . '/images/bg.' . $_IMAGE_TYPE );

    $msg = rtrim($LANG01[67]) . ' ' . $_CONF['site_name'];

    if( !empty( $_USER['username'] ))
    {
        $msg .= ', ' . COM_getDisplayName( $_USER['uid'], $_USER['username'],
                                           $_USER['fullname'] );
    }

    $curtime =  COM_getUserDateTimeFormat();

    $header->set_var( 'welcome_msg', $msg );
    $header->set_var( 'datetime', $curtime[0] );
    $header->set_var( 'site_logo', $_CONF['layout_url']
                                   . '/images/logo.' . $_IMAGE_TYPE );
    $header->set_var( 'theme', $_CONF['theme'] );

    $header->set_var('charset', COM_getCharset());
    $header->set_var('direction', $LANG_DIRECTION);

    $template_vars = array(
        'rdf_file' => $feed,
        'rss_url' => $feed,
        'site_mail' => "mailto:{$_CONF['site_mail']}",
        'site_name' => $_CONF['site_name'],
        'site_slogan' => $_CONF['site_slogan'],
        // Now add variables for buttons like e.g. those used by the Yahoo theme
        'button_home'  =>  $LANG_BUTTONS[1],
        'button_contact'  =>  $LANG_BUTTONS[2],
        'button_contribute'  =>  $LANG_BUTTONS[3],
        'button_sitestats'  =>  $LANG_BUTTONS[7],
        'button_personalize'  =>  $LANG_BUTTONS[8],
        'button_search'  =>  $LANG_BUTTONS[9],
        'button_advsearch'  =>  $LANG_BUTTONS[10],
        'button_directory'  =>  $LANG_BUTTONS[11],
    );
    $header->set_var( $template_vars );

    // Get plugin menu options
    $plugin_menu = PLG_getMenuItems();

    if( $_COM_VERBOSE )
    {
        COM_errorLog( 'num plugin menu items in header = ' . count( $plugin_menu ), 1 );
    }

    // Now add nested template for menu items
    COM_renderMenu( $header, $plugin_menu );

    if( count( $plugin_menu ) == 0 )
    {
        $header->parse( 'plg_menu_elements', 'menuitem_none', true );
    }
    else
    {
        $count_plugin_menu = count( $plugin_menu );
        for( $i = 1; $i <= $count_plugin_menu; $i++ )
        {
            $header->set_var( 'menuitem_url', current( $plugin_menu ));
            $header->set_var( 'menuitem_text', key( $plugin_menu ));

            if( $i == $count_plugin_menu )
            {
                $header->parse( 'plg_menu_elements', 'menuitem_last', true );
            }
            else
            {
                $header->parse( 'plg_menu_elements', 'menuitem', true );
            }

            next( $plugin_menu );
        }
    }

    // Call to plugins to set template variables in the header
    PLG_templateSetVars( 'header', $header );

    if( $_CONF['left_blocks_in_footer'] == 1 )
    {
        $header->set_var( 'left_blocks', '' );
        $header->set_var( 'geeklog_blocks', '' );
    }
    else
    {
        $lblocks = '';

        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function
         * This can be used to take control over what blocks are then displayed
         */
        if( is_array( $what ))
        {
            $function = $what[0];
            if( function_exists( $function ))
            {
                $lblocks = $function( $what[1], 'left' );
            }
            else
            {
                $lblocks = COM_showBlocks( 'left', $topic );
            }
        }
        else if( $what <> 'none' )
        {
            // Now show any blocks -- need to get the topic if not on home page
            $lblocks = COM_showBlocks( 'left', $topic );
        }

        if( empty( $lblocks ))
        {
            $header->set_var( 'left_blocks', '' );
            $header->set_var( 'geeklog_blocks', '' );
        }
        else
        {
            $header->set_var( 'geeklog_blocks', $lblocks );
            $header->parse( 'left_blocks', 'leftblocks', true );
            $header->set_var( 'geeklog_blocks', '');
        }
    }

    if( $_CONF['right_blocks_in_footer'] == 1 )
    {
        $header->set_var( 'right_blocks', '' );
        $header->set_var( 'geeklog_blocks', '' );
    }
    else
    {
        $rblocks = '';

        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function
         * This can be used to take control over what blocks are then displayed
         */
        if( is_array( $what ))
        {
            $function = $what[0];
            if( function_exists( $function ))
            {
                $rblocks = $function( $what[1], 'right' );
            }
            else
            {
                $rblocks = COM_showBlocks( 'right', $topic );
            }
        }
        else if( $what <> 'none' )
        {
            // Now show any blocks -- need to get the topic if not on home page
            $rblocks = COM_showBlocks( 'right', $topic );
        }

        if( empty( $rblocks ))
        {
            $header->set_var( 'right_blocks', '' );
            $header->set_var( 'geeklog_blocks', '' );
        }
        else
        {
            $header->set_var( 'geeklog_blocks', $rblocks, true );
            $header->parse( 'right_blocks', 'rightblocks', true );
        }
    }
    
    // Set last topic session variable
    SESS_setVariable('topic', $topic);

    // Call any plugin that may want to include extra Meta tags
    // or Javascript functions
    $headercode .= PLG_getHeaderCode();
    
    // Meta Tags
    // 0 = Disabled, 1 = Enabled, 2 = Enabled but default just for homepage
    if ($_CONF['meta_tags'] > 0) {
        $meta_description = '';
        $meta_keywords = '';
        $no_meta_description = 1;
        $no_meta_keywords = 1;
        
        //Find out if the meta tag description or keywords already exist in the headercode
        if ($headercode != '') { 
            $pattern = '/<meta ([^>]*)name="([^"\'>]*)"([^>]*)/im'; 
            if (preg_match_all($pattern, $headercode, $matches, PREG_SET_ORDER)) {
                // Loop through all meta tags looking for description and keywords
                for ($i = 0; $i<count($matches) && (($no_meta_description == 1) || ($no_meta_keywords == 1)); $i++) { 
                    $str_matches = strtolower($matches[$i][0]); 
                    $pos = strpos($str_matches,'name='); 
                    if (!(is_bool($pos) && !$pos)) { 
                        $name = trim(substr($str_matches,$pos+5),'"'); 
                        $pos = strpos($name,'"'); 
                        $name = substr($name,0,$pos); 

                        if (strcasecmp("description",$name) == 0) { 
                            $pos = strpos($str_matches,'content='); 
                            if (!(is_bool($pos) && !$pos)) {
                                $no_meta_description = 0;
                            }
                        }
                        if (strcasecmp("keywords",$name) == 0) { 
                            $pos = strpos($str_matches,'content='); 
                            if (!(is_bool($pos) && !$pos)) {
                                $no_meta_keywords = 0;
                            }
                        }
                        
                    }
                }
            } 
        }
        
        If (COM_onFrontpage() && $_CONF['meta_tags'] == 2) { // Display default meta tags only on home page
            If ($no_meta_description) {
                $meta_description = $_CONF['meta_description'];
            }
            If ($no_meta_keywords) {
                $meta_keywords = $_CONF['meta_keywords'];
            }
        } else if ( $_CONF['meta_tags'] == 1 ) { // Display default meta tags anywhere there are no tags
            If ($no_meta_description) {
                $meta_description = $_CONF['meta_description'];
            }
            If ($no_meta_keywords) {
                $meta_keywords = $_CONF['meta_keywords'];
            }            
        }
        
        If ($no_meta_description OR $no_meta_keywords) {
            $headercode .= COM_createMetaTags($meta_description, $meta_keywords);
        }
    }
    
    $headercode = $_SCRIPTS->getHeader() . $headercode;
    $header->set_var( 'plg_headercode', $headercode );
    
    $header->set_var( 'breadcrumb_trail', $breadcrumbs );

    COM_hit();

    // Set template directory
    $footer = COM_newTemplate($_CONF['path_layout']);

    // Set template file
    $footer->set_file( array(
            'footer'      => 'footer.thtml',
            'rightblocks' => 'rightblocks.thtml',
            'leftblocks'  => 'leftblocks.thtml'
            ));
    
    // Needed to set for pre (instead of post) since JavaScript could contain 
    // autotag labels (like in configuration search) 
    $footer->preprocess_fn = 'PLG_replaceTags';

    $year = date( 'Y' );
    $copyrightyear = $year;
    if(!empty($_CONF['copyrightyear'])) {
        $copyrightyear = $_CONF['copyrightyear'];
    }
    if(!empty($_CONF['owner_name'])) {
        $copyrightname = $_CONF['owner_name'];
    } else {
        $copyrightname = $_CONF['site_name'];
    }
    $footer->set_var( 'copyright_notice', '&nbsp;' . $LANG01[93] . ' &copy; '
            . $copyrightyear . ' ' . $copyrightname . '<br' . XHTML . '>&nbsp;'
            . $LANG01[94] );
    $footer->set_var( 'copyright_msg', $LANG01[93] . ' &copy; '
            . $copyrightyear . ' ' . $_CONF['site_name'] );
    $footer->set_var( 'current_year', $year );
    $footer->set_var( 'lang_copyright', $LANG01[93] );
    $footer->set_var( 'trademark_msg', $LANG01[94] );
    $footer->set_var( 'powered_by', $LANG01[95] );
    $footer->set_var( 'geeklog_url', 'http://www.geeklog.net/' );
    $footer->set_var( 'geeklog_version', VERSION );

    $footer->set_var( $template_vars );

    /* Right blocks. Argh. Don't talk to me about right blocks...
     * Right blocks will be displayed if Right_blocks_in_footer is set [1],
     * AND (this function has been asked to show them (first param) OR the
     * show_right_blocks conf variable has been set to override what the code
     * wants to do.
     *
     * If $custom sets an array (containing functionname and first argument)
     * then this is used instead of the default (COM_showBlocks) to render
     * the right blocks (and left).
     *
     * [1] - if it isn't, they'll be in the header already.
     *
     */
    $displayRightBlocks = true;
    if ($_CONF['right_blocks_in_footer'] == 1)
    {
        if( ($rightblock < 0) || !$rightblock )
        {
            if( isset( $_CONF['show_right_blocks'] ) )
            {
                $displayRightBlocks = $_CONF['show_right_blocks'];
            }
            else
            {
                $displayRightBlocks = false;
            }
        } else {
            $displayRightBlocks = true;
        }
    } else {
        $displayRightBlocks = false;
    }
    
    if ($displayRightBlocks)
    {
        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function.
         * This can be used to take control over what blocks are then displayed
         */
        if( is_array( $custom ))
        {
            $function = $custom['0'];
            if( function_exists( $function ))
            {
                $rblocks = $function( $custom['1'], 'right' );
            } else {
                $rblocks = COM_showBlocks( 'right', $topic );
            }
        } else {
            $rblocks = COM_showBlocks( 'right', $topic );
        }
        
        if( empty( $rblocks ))
        {
            $footer->set_var( 'geeklog_blocks', '');
            $footer->set_var( 'right_blocks', '' );
        } else {
            $footer->set_var( 'geeklog_blocks', $rblocks);
            $footer->parse( 'right_blocks', 'rightblocks', true );
            $footer->set_var( 'geeklog_blocks', '');
        }
    } else {
        $footer->set_var( 'geeklog_blocks', '');
        $footer->set_var( 'right_blocks', '' );
    }

    if( $_CONF['left_blocks_in_footer'] == 1 )
    {
        $lblocks = '';

        /* Check if an array has been passed that includes the name of a plugin
         * function or custom function
         * This can be used to take control over what blocks are then displayed
         */
        if( is_array( $custom ))
        {
            $function = $custom[0];
            if( function_exists( $function ))
            {
                $lblocks = $function( $custom[1], 'left' );
            }
        }
        else
        {
            if ($what <> 'none') {
                $lblocks = COM_showBlocks( 'left', $topic );
            }
        }

        if( empty( $lblocks ))
        {
            $footer->set_var( 'left_blocks', '' );
            $footer->set_var( 'geeklog_blocks', '');
        }
        else
        {
            $footer->set_var( 'geeklog_blocks', $lblocks);
            $footer->parse( 'left_blocks', 'leftblocks', true );
            $footer->set_var( 'geeklog_blocks', '');
        }
    }

    // Global centerspan variable set in index.php
    if( isset( $GLOBALS['centerspan'] ))
    {
        $footer->set_var( 'centerblockfooter-span', '</td></tr></table>' );
    }

    $exectime = $_PAGE_TIMER->stopTimer();
    $exectext = $LANG01[91] . ' ' . $exectime . ' ' . $LANG01[92];

    $footer->set_var( 'execution_time', $exectime );
    $footer->set_var( 'execution_textandtime', $exectext );


    /* Check leftblocks and rightblocks */
    $layout_columns = 'left-center-right';
    $emptylblocks = empty($lblocks);
    $emptyrblocks = empty($rblocks);
    if (!$emptylblocks && $emptyrblocks) {
        $layout_columns = 'left-center';
    }
    if ($emptylblocks && !$emptyrblocks) {
        $layout_columns = 'center-right';
    }
    if ($emptylblocks && $emptyrblocks) {
        $layout_columns = 'center';
    }
    $header->set_var( 'layout_columns', $layout_columns );

    // The following lines allow users to embed PHP in their templates.  This
    // is almost a contradition to the reasons for using templates but this may
    // prove useful at times ...
    // Don't use PHP in templates if you can live without it!

    $tmp = $header->finish($header->parse('index_header', 'header'));

    $xml_declaration = '';
    if ( get_cfg_var('short_open_tag') == '1' )
    {
        if ( preg_match( '/(<\?xml[^>]*>)(.*)/s', $tmp, $match ) )
        {
            $xml_declaration = $match[1] . LB;
            $tmp = $match[2];
        }
    }

    ob_start();
    eval( '?>' . $tmp );
    $retval_header = $xml_declaration . ob_get_contents();
    ob_end_clean();

    // Call to plugins to set template variables in the footer
    PLG_templateSetVars( 'footer', $footer );

    // Call any plugin that may want to include extra JavaScript functions
    $plugin_footercode = PLG_getFooterCode();
 
    // Retrieve any JavaScript libraries, variables and functions
    $footercode = $_SCRIPTS->getFooter();
 
    // $_SCRIPTS code should be placed before plugin_footer_code but plugin_footer_code should still be allowed to set $_SCRIPTS
    $footercode .= $plugin_footercode;
    
    $footer->set_var('plg_footercode', $footercode);

    // Actually parse the template and make variable substitutions
    $footer->parse( 'index_footer', 'footer' );

    return $retval_header . $content . $footer->finish( $footer->get_var( 'index_footer' ));
}


/**
* Prints out standard block header
*
* Prints out standard block header but pulling header HTML formatting from
* the database.
*
* Programming Note:  The two functions COM_startBlock and COM_endBlock are used
* to sandwich your block content.  These functions are not used only for blocks
* but anything that uses that format, e.g. Stats page.  They are used like
* COM_siteHeader and COM_siteFooter but for internal page elements.
*
* @param    string  $title      Value to set block title to
* @param    string  $helpfile   Help file, if one exists
* @param    string  $template   HTML template file to use to format the block
* @return   string              Formatted HTML containing block header
* @see COM_endBlock
* @see COM_siteHeader
*
*/

function COM_startBlock( $title='', $helpfile='', $template='blockheader.thtml' )
{
    global $_CONF, $LANG01, $_IMAGE_TYPE;
    
    // If the theme implemented this for us then call their version instead.
    $function = $_CONF['theme'] . '_startBlock';
    if( function_exists( $function )) {
        return $function( $title, $helpfile, $template );
    }

    $block = COM_newTemplate($_CONF['path_layout']);
    $block->set_file( 'block', $template );
    
    $block->postprocess_fn = 'PLG_replaceTags';

    $block->set_var( 'block_title', stripslashes( $title ));

    if( !empty( $helpfile )) {
        $helpimg = $_CONF['layout_url'] . '/images/button_help.' . $_IMAGE_TYPE;
        $help_content = '<img src="' . $helpimg. '" alt="?"' . XHTML . '>';
        $help_attr = array('class'=>'blocktitle');
        if( !stristr( $helpfile, 'http://' )) {
            $help_url = $_CONF['site_url'] . "/help/$helpfile";
        } else {
            $help_url = $helpfile;
        }
        $help = COM_createLink($help_content, $help_url, $help_attr);
        $block->set_var( 'block_help', $help );
    }

    $block->parse( 'startHTML', 'block' );

    return $block->finish( $block->get_var( 'startHTML' ));
}

/**
* Closes out COM_startBlock
*
* @param        string      $template       HTML template file used to format block footer
* @return   string  Formatted HTML to close block
* @see function COM_startBlock
*
*/
function COM_endBlock( $template='blockfooter.thtml' )
{
    global $_CONF;
    
    // If the theme implemented this for us then call their version instead.
    $function = $_CONF['theme'] . '_endBlock';
    if( function_exists( $function )) {
        return $function( $template );
    }

    $block = COM_newTemplate($_CONF['path_layout']);
    $block->set_file( 'block', $template );
    
    $block->postprocess_fn = 'PLG_replaceTags';

    $block->parse( 'endHTML', 'block' );

    return $block->finish( $block->get_var( 'endHTML' ));
}


/**
* Creates a <option> list from a database list for use in forms
*
* Creates option list form field using given arguments
*
* @param        string      $table      Database Table to get data from
* @param        string      $selection  Comma delimited string of fields to pull The first field is the value of the option and the second is the label to be displayed.  This is used in a SQL statement and can include DISTINCT to start.
* @param        string/array      $selected   Value (from $selection) to set to SELECTED or default
* @param        int         $sortcol    Which field to sort option list by 0 (value) or 1 (label)
* @param        string      $where      Optional WHERE clause to use in the SQL Selection
* @see function COM_checkList
* @return   string  Formated HTML of option values
*
*/
function COM_optionList( $table, $selection, $selected='', $sortcol=1, $where='' )
{
    global $_DB_table_prefix;

    $retval = '';

    $LangTableName = '';
    if( substr( $table, 0, strlen( $_DB_table_prefix )) == $_DB_table_prefix )
    {
        $LangTableName = 'LANG_' . substr( $table, strlen( $_DB_table_prefix ));
    }
    else
    {
        $LangTableName = 'LANG_' . $table;
    }

    global $$LangTableName;

    if( isset( $$LangTableName ))
    {
        $LangTable = $$LangTableName;
    }
    else
    {
        $LangTable = array();
    }

    $tmp = str_replace( 'DISTINCT ', '', $selection );
    $select_set = explode( ',', $tmp );

    $sql = "SELECT $selection FROM $table";
    if( $where != '' )
    {
        $sql .= " WHERE $where";
    }
    $sql .= " ORDER BY {$select_set[$sortcol]}";
    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result, true );
        $retval .= '<option value="' . $A[0] . '"';

        if( is_array( $selected ) AND count( $selected ) > 0 )
        {
            foreach( $selected as $selected_item )
            {
                if( $A[0] == $selected_item )
                {
                    $retval .= ' selected="selected"';
                }
            }
        }
        elseif( !is_array( $selected ) AND $A[0] == $selected )
        {
            $retval .= ' selected="selected"';
        }

        $retval .= '>';
        if( empty( $LangTable[$A[0]] ))
        {
            $retval .= $A[1];
        }
        else
        {
            $retval .= $LangTable[$A[0]];
        }
        $retval .= '</option>' . LB;
    }

    return $retval;
}

/**
* Create and return a dropdown-list of available topics
*
* This is a variation of COM_optionList() from lib-common.php. It will add
* only those topics to the option list which are accessible by the current
* user.
*
* @param        string      $selection  Comma delimited string of fields to pull The first field is the value of the option and the second is the label to be displayed.  This is used in a SQL statement and can include DISTINCT to start.
* @param        string      $selected   Value (from $selection) to set to SELECTED or default
* @param        int         $sortcol    Which field to sort option list by 0 (value) or 1 (label)
* @param        boolean     $ignorelang Whether to return all topics (true) or only the ones for the current language (false)
* @see function COM_optionList
* @return   string  Formated HTML of option values
*
*/
function COM_topicList( $selection, $selected = '', $sortcol = 1, $ignorelang = false )
{
    global $_TABLES;

    $retval = '';

    $topics = COM_topicArray($selection, $sortcol, $ignorelang);
    foreach ($topics as $tid => $topic) {
        $retval .= '<option value="' . $tid . '"';
        if (is_array($selected)) {
             foreach ($selected as $multiselect_tid) {
                if ($tid == $multiselect_tid) {
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
* @param    string  $selection  Comma delimited string of fields to pull The first field is the value of the option and the second is the label to be displayed.  This is used in a SQL statement and can include DISTINCT to start.
* @param    int     $sortcol    Which field to sort option list by 0 (value) or 1 (label)
* @param    boolean $ignorelang Whether to return all topics (true) or only the ones for the current language (false)
* @return   array               Array of topics
* @see function COM_topicList
*
*/
function COM_topicArray($selection, $sortcol = 0, $ignorelang = false)
{
    global $_TABLES;

    $retval = array();

    $tmp = str_replace('DISTINCT ', '', $selection);
    $select_set = explode(',', $tmp);

    $sql = "SELECT $selection FROM {$_TABLES['topics']}";
    if ($ignorelang) {
        $sql .= COM_getPermSQL();
    } else {
        $permsql = COM_getPermSQL();
        if (empty($permsql)) {
            $sql .= COM_getLangSQL('tid');
        } else {
            $sql .= $permsql . COM_getLangSQL('tid', 'AND');
        }
    }
    $sql .=  " ORDER BY $select_set[$sortcol]";

    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if (count($select_set) > 1) {
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result, true);
            $retval[$A[0]] = stripslashes($A[1]);
        }
    } else {
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result, true);
            $retval[] = $A[0];
        }
    }

    return $retval;
}

/**
* Creates a <input> checklist from a database list for use in forms
*
* Creates a group of checkbox form fields with given arguments
*
* @param    string  $table      DB Table to pull data from
* @param    string  $selection  Comma delimited list of fields to pull from table
* @param    string  $where      Where clause of SQL statement
* @param    string  $selected   Value to set to CHECKED
* @param    string  $fieldname  Name to use for the checkbox array
* @return   string              HTML with Checkbox code
* @see      COM_optionList
*
*/
function COM_checkList($table, $selection, $where = '', $selected = '', $fieldname = '')
{
    global $_TABLES, $_COM_VERBOSE;

    $sql = "SELECT $selection FROM $table";

    if( !empty( $where ))
    {
        $sql .= " WHERE $where";
    }

    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    if( !empty( $selected ))
    {
        if( $_COM_VERBOSE )
        {
            COM_errorLog( "exploding selected array: $selected in COM_checkList", 1 );
        }

        $S = explode( ' ', $selected );
    }
    else
    {
        if( $_COM_VERBOSE)
        {
            COM_errorLog( 'selected string was empty COM_checkList', 1 );
        }

        $S = array();
    }
    $retval = '<ul class="checkboxes-list">' . LB;
    for( $i = 0; $i < $nrows; $i++ )
    {
        $access = true;
        $A = DB_fetchArray( $result, true );

        if( $table == $_TABLES['topics'] AND SEC_hasTopicAccess( $A['tid'] ) == 0 )
        {
            $access = false;
        }

        if (empty($fieldname)) {
            // Not a good idea, as that will expose our table name and prefix!
            // Make sure you pass a distinct field name!
            $fieldname = $table;
        }

        if( $access )
        {
            $retval .= '<li><input type="checkbox" name="' . $fieldname . '[]" value="' . $A[0] . '"';

            $sizeS = count( $S );
            for( $x = 0; $x < $sizeS; $x++ )
            {
                if( $A[0] == $S[$x] )
                {
                    $retval .= ' checked="checked"';
                    break;
                }
            }

            if(( $table == $_TABLES['blocks'] ) && isset( $A[2] ) && ( $A[2] == 'gldefault' ))
            {
                $retval .= XHTML . '><span class="gldefault">' . stripslashes( $A[1] ) . '</span></li>' . LB;
            }
            else
            {
                $retval .= XHTML . '><span>' . stripslashes( $A[1] ) . '</span></li>' . LB;
            }
        }
    }
    $retval .= '</ul>' . LB;

    return $retval;
}

/**
* Prints out an associative array for debugging
*
* The core of this code has been lifted from phpweblog which is licenced
* under the GPL.  This is not used very much in the code but you can use it
* if you see fit
*
* @param    array   $array    Array to loop through and print values for
* @return   string  $retval    Formatted HTML List
*
*/

function COM_debug($array)
{
    $retval = '';    
    if(!empty($array)) {
        $retval = '<ul><pre><p>---- DEBUG ----</p>';
        foreach($array as $k => $v) { 
            $retval .= sprintf("<li>%13s [%s]</li>\n", $k, $v);
        }
        $retval .= '<p>---------------</p></pre></ul>';
    }    
    return $retval;
}

/**
*
* Checks to see if RDF file needs updating and updates it if so.
* Checks to see if we need to update the RDF as a result
* of an article with a future publish date reaching it's
* publish time and if so updates the RDF file.
*
* NOTE: When called without parameters, this will only check for new entries to
*       include in the feeds. Pass the $updated_XXX parameters when the content
*       of an existing entry has changed.
*
* @param    string  $updated_type   (optional) feed type to update
* @param    string  $updated_topic  (optional) feed topic to update
* @param    string  $updated_id     (optional) feed id to update
*
* @see file lib-syndication.php
*
*/
function COM_rdfUpToDateCheck( $updated_type = '', $updated_topic = '', $updated_id = '' )
{
    global $_CONF, $_TABLES;

    if( $_CONF['backend'] > 0 )
    {
        if( !empty( $updated_type ) && ( $updated_type != 'article' ))
        {
            // when a plugin's feed is to be updated, skip Geeklog's own feeds
            $sql = "SELECT fid,type,topic,limits,update_info FROM {$_TABLES['syndication']} WHERE (is_enabled = 1) AND (type <> 'article')";
        }
        else
        {
            $sql = "SELECT fid,type,topic,limits,update_info FROM {$_TABLES['syndication']} WHERE is_enabled = 1";
        }
        $result = DB_query( $sql );
        $num = DB_numRows( $result );
        for( $i = 0; $i < $num; $i++)
        {
            $A = DB_fetchArray( $result );

            $is_current = true;
            if( $A['type'] == 'article' )
            {
                $is_current = SYND_feedUpdateCheck( $A['topic'],
                                $A['update_info'], $A['limits'],
                                $updated_topic, $updated_id );
            }
            else
            {
                $is_current = PLG_feedUpdateCheck( $A['type'], $A['fid'],
                                $A['topic'], $A['update_info'], $A['limits'],
                                $updated_type, $updated_topic, $updated_id );
            }
            if( !$is_current )
            {
                SYND_updateFeed( $A['fid'] );
            }
        }
    }
}

/**
* Checks and Updates the featured status of all articles.
*
* Checks to see if any articles that were published for the future have been
* published and, if so, will see if they are featured.  If they are featured,
* this will set old featured article (if there is one) to normal
*
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
    for($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray($result);

        $sql = "SELECT s.sid FROM {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta WHERE s.featured = 1 AND s.draft_flag = 0 AND ta.tid = '{$A['tid']}' AND ta.type = 'article' AND s.date <= NOW() ORDER BY s.date DESC LIMIT 2";
        $resultB = DB_query($sql);
        $numB = DB_numRows($resultB);
        if ($numB > 1) {
            // OK, we have two or more featured stories in a topic, fix that
            $B = DB_fetchArray($resultB);
            $sql = "UPDATE {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta SET s.featured = 0 WHERE s.featured = 1 AND s.draft_flag = 0 AND ta.tid = '{$A['tid']}' AND ta.type = 'article' AND ta.id = s.sid AND s.date <= NOW() AND s.sid <> '{$B['sid']}'";
            DB_query($sql);            
        }
    }
}

/**
*
* Logs messages to error.log or the web page or both
*
* Prints a well formatted message to either the web page, error log
* or both.
*
* @param        string      $logentry       Text to log to error log
* @param        int         $actionid       where 1 = write to log file, 2 = write to screen (default) both
* @see function COM_accessLog
* @return   string  If $actionid = 2 or '' then HTML formatted string (wrapped in block) else nothing
*
*/

function COM_errorLog( $logentry, $actionid = '' )
{
    global $_CONF, $LANG01;

    $retval = '';

    if( !empty( $logentry ))
    {
        $logentry = str_replace( array( '<?', '?>' ), array( '(@', '@)' ),
                                 $logentry );

        $timestamp = @strftime( '%c' );
        
        $remoteaddress = $_SERVER['REMOTE_ADDR'];        

        if (!isset($_CONF['path_layout']) &&
                (($actionid == 2) || empty($actionid))) {
            $actionid = 1;
        }
        if ((($actionid == 2) || empty($actionid)) &&
                !class_exists('Template')) {
            $actionid = 1;
        }
        if (!isset($_CONF['path_log']) && ($actionid != 2)) {
            $actionid = 3;
        }

        switch( $actionid )
        {
            case 1:
                $logfile = $_CONF['path_log'] . 'error.log';

                if( !$file = fopen( $logfile, 'a' ))
                {
                    $retval .= $LANG01[33] . ' ' . $logfile . ' (' . $timestamp . ')<br' . XHTML . '>' . LB;
                }
                else
                {
                    fputs( $file, "$timestamp - $remoteaddress - $logentry \n" );
                }
                break;

            case 2:
                $retval .= COM_startBlock( $LANG01[55] . ' ' . $timestamp, '',
                               COM_getBlockTemplate( '_msg_block', 'header' ))
                        . nl2br( $logentry )
                        . COM_endBlock( COM_getBlockTemplate( '_msg_block',
                                                              'footer' ));
                break;

            case 3:
                $retval = nl2br($logentry);
                break;

            default:
                $logfile = $_CONF['path_log'] . 'error.log';

                if( !$file = fopen( $logfile, 'a' ))
                {
                    $retval .= $LANG01[33] . ' ' . $logfile . ' (' . $timestamp . ')<br' . XHTML . '>' . LB;
                }
                else
                {
                    fputs( $file, "$timestamp - $remoteaddress - $logentry \n" );
                    $retval .= COM_startBlock( $LANG01[34] . ' - ' . $timestamp,
                                   '', COM_getBlockTemplate( '_msg_block',
                                   'header' ))
                            . nl2br( $logentry )
                            . COM_endBlock( COM_getBlockTemplate( '_msg_block',
                                                                  'footer' ));
                }
                break;
        }
    }

    return $retval;
}

/**
* Logs message to access.log
*
* This will print a message to the Geeklog access log
*
* @param        string      $logentry       Message to write to access log
* @see COM_errorLog
*
*/

function COM_accessLog( $logentry )
{
    global $_CONF, $_USER, $LANG01;

    $retval = '';

    if( !empty( $logentry ))
    {
        $logentry = str_replace( array( '<?', '?>' ), array( '(@', '@)' ),
                                 $logentry );

        $timestamp = @strftime( '%c' );
        $logfile = $_CONF['path_log'] . 'access.log';

        if( !$file = fopen( $logfile, 'a' ))
        {
            return $LANG01[33] . $logfile . ' (' . $timestamp . ')<br' . XHTML . '>' . LB;
        }

        if( isset( $_USER['uid'] ))
        {
            $byuser = $_USER['uid'] . '@' . $_SERVER['REMOTE_ADDR'];
        }
        else
        {
            $byuser = 'anon@' . $_SERVER['REMOTE_ADDR'];
        }

        fputs( $file, "$timestamp ($byuser) - $logentry\n" );
    }

    return $retval;
}

/**
* Shows all available topics
*
* Show the topics in the system the user has access to and prints them in HTML.
* This function is used to show the topics in the topics block.
*
* @param    string    $topic      ID of currently selected topic
* @return   string                HTML formatted topic list
*
*/
function COM_showTopics($topic = '')
{
    global $_CONF, $_TABLES, $_TOPICS, $_USER, $LANG01, $_BLOCK_TEMPLATE, $page;
 
    $retval = '';
    $sections = COM_newTemplate($_CONF['path_layout']);
    if (isset($_BLOCK_TEMPLATE['topicoption'])) {
        $templates = explode(',', $_BLOCK_TEMPLATE['topicoption']);
        $sections->set_file(array('option'  => $templates[0],
                                  'current' => $templates[1]));
    } else {
        $sections->set_file(array('option'   => 'topicoption.thtml',
                                  'inactive' => 'topicoption_off.thtml'));
    }

    $sections->set_var('block_name', str_replace('_', '-', 'section_block'));

    if ($_CONF['hide_home_link'] == 0) {
        // Give a link to the homepage here since a lot of people use this for
        // navigating the site
        
        $start_branch = 1; // Sets indentation level for topics

        if (COM_onFrontpage()) {
            $sections->set_var('option_url', '');
            $sections->set_var('option_label', $LANG01[90]);
            $sections->set_var('option_count', '');
            $sections->set_var('option_attributes', '');
            $sections->set_var('topic_image', '');
            $retval .= $sections->parse('item', 'inactive');
        } else {
            $sections->set_var('option_url', $_CONF['site_url'] . '/');
            $sections->set_var('option_label', $LANG01[90]);
            $sections->set_var('option_count', '');
            $sections->set_var('option_attributes', ' rel="home"');
            $sections->set_var('topic_image', '');
            $retval .= $sections->parse('item', 'option');
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

    for ($count_topic = $start_topic; $count_topic <= $total_topic ; $count_topic++) {
        
        // Check if branch needs to be hidden due to a parent being hidden or a different language
        if ($branch_level_skip >= $_TOPICS[$count_topic]['branch_level']) {
            $branch_level_skip = 0;
        }
        
        if ($branch_level_skip == 0) {
            // Make sure to show topics for proper language only
            if ($_TOPICS[$count_topic]['exclude'] == 0 && $_TOPICS[$count_topic]['access'] > 0 && !$_TOPICS[$count_topic]['hidden'] && (($lang_id == '') || ($lang_id != '' && ($_TOPICS[$count_topic]['language_id'] == $lang_id)))) {
                $branch_spaces = "";
                $level = 1;
                for ($branch_count = $start_branch; $branch_count <= $_TOPICS[$count_topic]['branch_level'] ; $branch_count++) {
                    $branch_spaces .= "&nbsp;&nbsp;&nbsp;";
                    $level++;
                }
                $sections->set_var('branch_spaces', $branch_spaces);
                $sections->set_var('branch_level', $level);
                
                $topicname = stripslashes($_TOPICS[$count_topic]['title']);
                $sections->set_var('option_url', $_CONF['site_url']
                                                 . '/index.php?topic=' . $_TOPICS[$count_topic]['id']);
                $sections->set_var('option_label', $topicname);
        
                $countstring = '';
                if ($_CONF['showstorycount'] || $_CONF['showsubmissioncount']) {
                    $countstring .= '(';

                    // Retrieve list of inherited topics
                    $tid_list = TOPIC_getChildList($_TOPICS[$count_topic]['id']);

                    if ($_CONF['showstorycount']) {
                        // Calculate number of stories in topic, includes any inherited ones
                        $sql = "SELECT sid FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta "
                             . 'WHERE (draft_flag = 0) AND (date <= NOW()) '
                             . COM_getPermSQL('AND')
                             . "AND ta.type = 'article' AND ta.id = sid "
                             . "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$_TOPICS[$count_topic]['id']}'))) "
                             . ' GROUP BY sid';   
            
                        $resultD = DB_query($sql);
                        $nrows = DB_numRows ($resultD);
                        $countstring .= COM_numberFormat($nrows);
                    }
        
                    if ($_CONF['showsubmissioncount']) {
                        if ($_CONF['showstorycount']) {
                            $countstring .= '/';
                        }
                        // Calculate number of story submissions in topic, includes any inherited ones
                        $sql = "SELECT sid FROM {$_TABLES['storysubmission']}, {$_TABLES['topic_assignments']} ta "
                             . "WHERE ta.type = 'article' AND ta.id = sid "
                             . "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$_TOPICS[$count_topic]['id']}'))) "
                             . ' GROUP BY sid';   
            
                        $resultD = DB_query($sql);
                        $nrows = DB_numRows ($resultD);
                        $countstring .= COM_numberFormat($nrows);
                    }
        
                    $countstring .= ')';
                }
                $sections->set_var('option_count', $countstring);
                $sections->set_var('option_attributes', '');
        
                $sql = "SELECT imageurl, meta_description FROM {$_TABLES['topics']} WHERE tid = '{$_TOPICS[$count_topic]['id']}'";
                $result = DB_query($sql);
                $A = DB_fetchArray($result);
                
                $topicimage = '';
                if (! empty( $A['imageurl'])) {
                    $imageurl = COM_getTopicImageUrl($A['imageurl']);
                    $topicimage = '<img src="' . $imageurl . '" alt="' . $topicname
                                . '" title="' . $topicname . '"' . XHTML . '>';
                }
                $sections->set_var('topic_image', $topicimage);
        
                $desc = trim($A['meta_description']);
                $sections->set_var('topic_description', $desc);
                $desc_escaped = htmlspecialchars($desc);
                $sections->set_var('topic_description_escaped', $desc_escaped);
                if (! empty($desc)) {
                    $sections->set_var('topic_title_attribute',
                                       'title="' . $desc_escaped . '"');
                } else {
                    $sections->set_var('topic_title_attribute', '');
                }
        
                if (($_TOPICS[$count_topic]['id'] == $topic) && ($page == 1)) {
                    $retval .= $sections->parse('item', 'inactive');
                }
                else
                {
                    $retval .= $sections->parse('item', 'option');
                }
            } else {
                // Different language or hidden, so flag this to skip if we have children
                $branch_level_skip = $_TOPICS[$count_topic]['branch_level'];
            }
        }
    }

    return $retval;
}

/**
* Shows the user their menu options
*
* This shows the average Joe User their menu options. This is the user block on the left side
*
* @param        string      $help       Help file to show
* @param        string      $title      Title of Menu
* @param        string      $position   Side being shown on 'left', 'right'. Though blank works not likely.
* @see function COM_adminMenu
*
*/
function COM_userMenu( $help='', $title='', $position='' )
{
    global $_TABLES, $_CONF, $LANG01, $LANG04, $_BLOCK_TEMPLATE, $_SCRIPTS;

    $retval = '';

    if( !COM_isAnonUser() )
    {
        $usermenu = COM_newTemplate($_CONF['path_layout']);
        if( isset( $_BLOCK_TEMPLATE['useroption'] ))
        {
            $templates = explode( ',', $_BLOCK_TEMPLATE['useroption'] );
            $usermenu->set_file( array( 'option' => $templates[0],
                                        'current' => $templates[1] ));
        }
        else
        {
           $usermenu->set_file( array( 'option' => 'useroption.thtml',
                                       'current' => 'useroption_off.thtml' ));
        }
        $usermenu->set_var( 'block_name', str_replace( '_', '-', 'user_block' ));

        if( empty( $title ))
        {
            $title = DB_getItem( $_TABLES['blocks'], 'title',
                                 "name='user_block'" );
        }

        // what's our current URL?
        $thisUrl = COM_getCurrentURL();

        $retval .= COM_startBlock( $title, $help,
                           COM_getBlockTemplate( 'user_block', 'header', $position ));

        // This function will show the user options for all installed plugins
        // (if any)

        $plugin_options = PLG_getUserOptions();
        $nrows = count( $plugin_options );

        for( $i = 0; $i < $nrows; $i++ )
        {
            $plg = current( $plugin_options );
            $usermenu->set_var( 'option_label', $plg->adminlabel );

            if( !empty( $plg->numsubmissions ))
            {
                $usermenu->set_var( 'option_count', '(' . $plg->numsubmissions . ')' );
            }
            else
            {
                $usermenu->set_var( 'option_count', '' );
            }

            $usermenu->set_var( 'option_url', $plg->adminurl );
            if( $thisUrl == $plg->adminurl )
            {
                $retval .= $usermenu->parse( 'item', 'current' );
            }
            else
            {
                $retval .= $usermenu->parse( 'item', 'option' );
            }
            next( $plugin_options );
        }

        $url = $_CONF['site_url'] . '/usersettings.php';
        $usermenu->set_var( 'option_label', $LANG01[48] );
        $usermenu->set_var( 'option_count', '' );
        $usermenu->set_var( 'option_url', $url );
        if( $thisUrl == $url )
        {
            $retval .= $usermenu->parse( 'item', 'current' );
        }
        else
        {
            $retval .= $usermenu->parse( 'item', 'option' );
        }

        $url = $_CONF['site_url'] . '/users.php?mode=logout';
        $usermenu->set_var( 'option_label', $LANG01[19] );
        $usermenu->set_var( 'option_count', '' );
        $usermenu->set_var( 'option_url', $url );
        $retval .= $usermenu->finish($usermenu->parse('item', 'option'));
        $retval .=  COM_endBlock(COM_getBlockTemplate('user_block', 'footer', $position));
    }
    else
    {
        $retval .= COM_startBlock( $LANG01[47], $help,
                           COM_getBlockTemplate( 'user_block', 'header', $position ));
        $login = COM_newTemplate($_CONF['path_layout']);
        $login->set_file( 'form', 'loginform.thtml' );
        $login->set_var( 'lang_username', $LANG01[21] );
        $login->set_var( 'lang_password', $LANG01[57] );
        $login->set_var( 'lang_forgetpassword', $LANG01[119] );
        $login->set_var( 'lang_login', $LANG01[58] );
        if ($_CONF['disable_new_user_registration']) {
            $login->set_var('lang_signup', '');
        } else {
            $login->set_var('lang_signup', $LANG01[59]);
        }

        // 3rd party remote authentification.
        if ($_CONF['user_login_method']['3rdparty'] && !$_CONF['usersubmission']) {
            $modules = SEC_collectRemoteAuthenticationModules();
            if (count($modules) == 0) {
                $user_templates->set_var('services', '');
            } else {
                if (!$_CONF['user_login_method']['standard'] &&
                        (count($modules) == 1)) {
                    $select = '<input type="hidden" name="service" value="'
                            . $modules[0] . '"' . XHTML . '>' . $modules[0];
                } else {
                    // Build select
                    $select = '<select name="service" id="service">';
                    if ($_CONF['user_login_method']['standard']) {
                        $select .= '<option value="">' . $_CONF['site_name']
                                . '</option>';
                    }
                    foreach ($modules as $service) {
                        $select .= '<option value="' . $service . '">'
                                . $service . '</option>';
                    }
                    $select .= '</select>';
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

        // OpenID remote authentification.
        if ($_CONF['user_login_method']['openid'] && ($_CONF['usersubmission'] == 0) && !$_CONF['disable_new_user_registration']) {
            $_SCRIPTS->setJavascriptFile('login', '/javascript/login.js');
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

        // OAuth remote authentification.
        if ($_CONF['user_login_method']['oauth'] && ($_CONF['usersubmission'] == 0) && !$_CONF['disable_new_user_registration']) {
            $_SCRIPTS->setJavascriptFile('login', '/javascript/login.js');
            $modules = SEC_collectRemoteOAuthModules();
            if (count($modules) == 0) {
                $login->set_var('oauth_login', '');
            } else {
                $html_oauth = '';
                foreach ($modules as $service) {
                    $login->set_file('oauth_login', 'loginform_oauth.thtml');
                    $login->set_var('oauth_service', $service);
                    $login->set_var('lang_oauth_service', $LANG01[$service]);
                    // for sign in image
                    $login->set_var('oauth_sign_in_image', $_CONF['site_url'] . '/images/' . $service . '-login-icon.png');
                    $login->parse('output', 'oauth_login');
                    $html_oauth .= $login->finish($login->get_var('output'));
                }
                $login->set_var('oauth_login', $html_oauth);
            }
        } else {
            $login->set_var('oauth_login', '');
        }

        PLG_templateSetVars('loginblock', $login);
        $retval .= $login->finish($login->parse('output', 'form'));
        $retval .= COM_endBlock( COM_getBlockTemplate('user_block', 'footer', $position));
    }

    return $retval;
}

/**
* Prints administration menu
*
* This will return the administration menu items that the user has
* sufficient rights to -- Admin Block on the left side.
*
* @param        string      $help       Help file to show
* @param        string      $title      Menu Title
* @param        string      $position   Side being shown on 'left', 'right' or blank.
* @see function COM_userMenu
*
*/
function COM_adminMenu( $help = '', $title = '', $position = '' )
{
    global $_TABLES, $_CONF, $_CONF_FT, $LANG01, $LANG_ADMIN, $_BLOCK_TEMPLATE,
           $_DB_dbms, $config;

    $retval = '';

    if (COM_isAnonUser()) {
        return $retval;
    }

    $plugin_options = PLG_getAdminOptions();
    $num_plugins = count( $plugin_options );

    if( SEC_isModerator() OR SEC_hasRights( 'story.edit,block.edit,topic.edit,user.edit,plugin.edit,user.mail,syndication.edit', 'OR' ) OR ( $num_plugins > 0 ) OR SEC_hasConfigAcess())        
    {
        $link_array = array();

        // what's our current URL?
        $thisUrl = COM_getCurrentURL();

        $adminmenu = COM_newTemplate($_CONF['path_layout']);
        if( isset( $_BLOCK_TEMPLATE['adminoption'] ))
        {
            $templates = explode( ',', $_BLOCK_TEMPLATE['adminoption'] );
            $adminmenu->set_file( array( 'option' => $templates[0],
                                         'current' => $templates[1] ));
        }
        else
        {
            $adminmenu->set_file( array( 'option' => 'adminoption.thtml',
                                         'current' => 'adminoption_off.thtml' ));
        }
        $adminmenu->set_var( 'block_name', str_replace( '_', '-', 'admin_block' ));

        if( empty( $title ))
        {
            $title = DB_getItem( $_TABLES['blocks'], 'title',
                                 "name = 'admin_block'" );
        }

        $retval .= COM_startBlock( $title, $help,
                           COM_getBlockTemplate( 'admin_block', 'header', $position ));

        $topicsql = '';
        if( SEC_isModerator() || SEC_hasRights( 'story.edit' ))
        {
            $tresult = DB_query( "SELECT tid FROM {$_TABLES['topics']}"
                                 . COM_getPermSQL() );
            $trows = DB_numRows( $tresult );
            if( $trows > 0 )
            {
                $tids = array();
                for( $i = 0; $i < $trows; $i++ )
                {
                    $T = DB_fetchArray( $tresult );
                    $tids[] = $T['tid'];
                }
                if( count( $tids ) > 0 )
                {
                    $topicsql = " AND (ta.tid IN ('" . implode( "','", $tids ) . "'))";
                }
            }
        }

        $modnum = 0;
        if (SEC_hasRights('story.edit,story.moderate', 'OR') ||
                (($_CONF['commentsubmission'] == 1) &&
                    SEC_hasRights('comment.moderate')) ||
                (($_CONF['usersubmission'] == 1) &&
                    SEC_hasRights('user.edit,user.delete'))) {

            if (SEC_hasRights('story.moderate')) {
                if (empty($topicsql)) {
                    $modnum += DB_count($_TABLES['storysubmission']);
                } else {
                    $sql = "SELECT COUNT(DISTINCT sid) AS count FROM {$_TABLES['storysubmission']}, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'article' AND ta.id = sid " . $topicsql;
                    $sresult = DB_query($sql);
                    $S = DB_fetchArray($sresult);
                    $modnum += $S['count'];
                }
            }

            if (($_CONF['listdraftstories'] == 1) && SEC_hasRights('story.edit')) {
                $sql = "SELECT COUNT(DISTINCT sid) AS count FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'article' AND ta.id = sid AND draft_flag = 1";
                if (!empty($topicsql)) {
                    $sql .= $topicsql;
                }
                $result = DB_query($sql . COM_getPermSQL('AND', 0, 3));
                $A = DB_fetchArray($result);
                $modnum += $A['count'];
            }

            if (($_CONF['commentsubmission'] == 1) && SEC_hasRights('comment.moderate')) {
                $modnum += DB_count($_TABLES['commentsubmissions']);
            }

            if ($_CONF['usersubmission'] == 1) {
                if (SEC_hasRights('user.edit') && SEC_hasRights('user.delete')) {
                    $modnum += DB_count($_TABLES['users'], 'status', '2');
                }
            }
        }

        if (SEC_hasConfigAcess()) {
            $url = $_CONF['site_admin_url'] . '/configuration.php';
            $adminmenu->set_var('option_url', $url);
            $adminmenu->set_var('option_label', $LANG01[129]);
            $adminmenu->set_var('option_count', count($config->_get_groups()));
            $menu_item = $adminmenu->parse('item',
                                           ($thisUrl == $url) ? 'current' :
                                                                'option');
            $link_array[$LANG01[129]] = $menu_item;
        }


        // now handle submissions for plugins
        $modnum += PLG_getSubmissionCount();

        if( SEC_hasRights( 'story.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/story.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[11] );
            if( empty( $topicsql ))
            {
                $numstories = DB_count( $_TABLES['stories'] );
            }
            else
            {
                $nresult = DB_query( "SELECT COUNT(DISTINCT sid) AS count FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'article' AND ta.id = sid " . $topicsql . COM_getPermSql( 'AND' ));
                $N = DB_fetchArray( $nresult );
                $numstories = $N['count'];
            }
            $adminmenu->set_var( 'option_count',
                                 COM_numberFormat( $numstories ));
            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[11]] = $menu_item;
        }

        if( SEC_hasRights( 'block.edit' ))
        {
            $result = DB_query( "SELECT COUNT(*) AS count FROM {$_TABLES['blocks']}" . COM_getPermSql());
            list( $count ) = DB_fetchArray( $result );

            $url = $_CONF['site_admin_url'] . '/block.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[12] );
            $adminmenu->set_var( 'option_count', COM_numberFormat( $count ));

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[12]] = $menu_item;
        }

        if( SEC_hasRights( 'topic.edit' ))
        {
            $result = DB_query( "SELECT COUNT(*) AS count FROM {$_TABLES['topics']}" . COM_getPermSql());
            list( $count ) = DB_fetchArray( $result );

            $url = $_CONF['site_admin_url'] . '/topic.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[13] );
            $adminmenu->set_var( 'option_count', COM_numberFormat( $count ));

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[13]] = $menu_item;
        }

        if (SEC_hasRights('user.edit')) {
            $url = $_CONF['site_admin_url'] . '/user.php';
            $adminmenu->set_var('option_url', $url);
            $adminmenu->set_var('option_label', $LANG01[17]);
            $active_users = DB_count($_TABLES['users'], 'status',
                                     USER_ACCOUNT_ACTIVE);
            $adminmenu->set_var('option_count',
                    COM_numberFormat($active_users - 1));

            $menu_item = $adminmenu->parse('item',
                    $thisUrl == $url ? 'current' : 'option');
            $link_array[$LANG01[17]] = $menu_item;
        }

        if( SEC_hasRights( 'group.edit' ))
        {
            if (SEC_inGroup('Root')) {
                $grpFilter = '';
            } else {
                $thisUsersGroups = SEC_getUserGroups ();
                $grpFilter = 'WHERE (grp_id IN (' . implode (',', $thisUsersGroups) . '))';
            }
            $result = DB_query( "SELECT COUNT(*) AS count FROM {$_TABLES['groups']} $grpFilter;" );
            $A = DB_fetchArray( $result );

            $url = $_CONF['site_admin_url'] . '/group.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[96] );
            $adminmenu->set_var( 'option_count',
                                 COM_numberFormat( $A['count'] ));

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[96]] = $menu_item;
        }

        if( SEC_hasRights( 'user.mail' ))
        {
            $url = $_CONF['site_admin_url'] . '/mail.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[105] );
            $adminmenu->set_var( 'option_count', $LANG_ADMIN['na'] );

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[105]] = $menu_item;
        }

        if(( $_CONF['backend'] == 1 ) && SEC_hasRights( 'syndication.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/syndication.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[38] );
            $count = COM_numberFormat( DB_count( $_TABLES['syndication'] ));
            $adminmenu->set_var( 'option_count', $count );

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[38]] = $menu_item;
        }

        if(( $_CONF['trackback_enabled'] || $_CONF['pingback_enabled'] ||
                $_CONF['ping_enabled'] ) && SEC_hasRights( 'story.ping' ))
        {
            $url = $_CONF['site_admin_url'] . '/trackback.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[116] );
            if( $_CONF['ping_enabled'] )
            {
                $count = COM_numberFormat( DB_count( $_TABLES['pingservice'] ));
                $adminmenu->set_var( 'option_count', $count );
            }
            else
            {
                $adminmenu->set_var( 'option_count', $LANG_ADMIN['na'] );
            }

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[116]] = $menu_item;
        }

        if (SEC_hasRights('plugin.edit')) {
            $url = $_CONF['site_admin_url'] . '/plugins.php';
            $adminmenu->set_var('option_url', $url);
            $adminmenu->set_var('option_label', $LANG01[77]);
            $adminmenu->set_var('option_count',
                    COM_numberFormat(DB_count($_TABLES['plugins'],
                                              'pi_enabled', 1)));

            $menu_item = $adminmenu->parse('item',
                    ($thisUrl == $url) ? 'current' : 'option');
            $link_array[$LANG01[77]] = $menu_item;
        }

        // This will show the admin options for all installed plugins (if any)

        for ($i = 0; $i < $num_plugins; $i++) {
            $plg = current($plugin_options);

            $adminmenu->set_var('option_url',   $plg->adminurl);
            $adminmenu->set_var('option_label', $plg->adminlabel);

            if (isset($plg->numsubmissions) &&
                    is_numeric($plg->numsubmissions)) {
                $adminmenu->set_var('option_count',
                                    COM_numberFormat($plg->numsubmissions));
            } elseif (! empty($plg->numsubmissions)) {
                $adminmenu->set_var('option_count', $plg->numsubmissions);
            } else {
                $adminmenu->set_var('option_count', $LANG_ADMIN['na']);
            }

            $menu_item = $adminmenu->parse('item',
                    ($thisUrl == $plg->adminurl) ? 'current' : 'option', true);
            $link_array[$plg->adminlabel] = $menu_item;

            next($plugin_options);
        }

        if(( $_CONF['allow_mysqldump'] == 1 ) AND ( $_DB_dbms == 'mysql' ) AND
                SEC_inGroup( 'Root' ))
        {
            $url = $_CONF['site_admin_url'] . '/database.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[103] );
            $adminmenu->set_var( 'option_count', $LANG_ADMIN['na'] );

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[103]] = $menu_item;
        }

        if ($_CONF['link_documentation'] == 1) {
            $doclang = COM_getLanguageName();
            $docs = 'docs/' . $doclang . '/index.html';
            if (file_exists($_CONF['path_html'] . $docs)) {
                $adminmenu->set_var('option_url', $_CONF['site_url']
                                    . '/' . $docs);
            } else {
                $adminmenu->set_var('option_url', $_CONF['site_url']
                                    . '/docs/english/index.html');
            }
            $adminmenu->set_var('option_label', $LANG01[113]);
            $adminmenu->set_var('option_count', $LANG_ADMIN['na']);
            $menu_item = $adminmenu->parse('item', 'option');
            $link_array[$LANG01[113]] = $menu_item;
        }

        if( $_CONF['link_versionchecker'] == 1 AND SEC_inGroup( 'Root' ))
        {
            $adminmenu->set_var( 'option_url',
               'http://www.geeklog.net/versionchecker.php?version=' . VERSION );
            $adminmenu->set_var( 'option_label', $LANG01[107] );
            $adminmenu->set_var( 'option_count', VERSION );

            $menu_item = $adminmenu->parse( 'item', 'option' );
            $link_array[$LANG01[107]] = $menu_item;
        }

        if( $_CONF['sort_admin'] )
        {
            uksort( $link_array, 'strcasecmp' );
        }

        $url = $_CONF['site_admin_url'] . '/moderation.php';
        $adminmenu->set_var('option_url', $url);
        $adminmenu->set_var('option_label', $LANG01[10]);
        $adminmenu->set_var('option_count', COM_numberFormat($modnum));
        $menu_item = $adminmenu->finish($adminmenu->parse('item',
                        ($thisUrl == $url) ? 'current' : 'option'));
        $link_array = array($menu_item) + $link_array;

        foreach( $link_array as $link )
        {
            $retval .= $link;
        }

        $retval .= COM_endBlock( COM_getBlockTemplate( 'admin_block', 'footer', $position ));
    }

    return $retval;
}

/**
* Redirects user to a given URL
*
* This function does a redirect using a meta refresh. This is (or at least
* used to be) more compatible than using a HTTP Location: header.
*
* NOTE:     This does not need to be XHTML compliant. It may also be used
*           in situations where the XHTML constant is not defined yet ...
*
* @param    string  $url    URL to send user to
* @return   string          HTML meta redirect
*
*/
function COM_refresh($url)
{
    return "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
}

/**
 * DEPRECIATED -- see CMT_userComments in lib-comment.php
 * @deprecated since Geeklog 1.4.0
 * @see CMT_userComments
 */
function COM_userComments( $sid, $title, $type='article', $order='', $mode='', $pid = 0, $page = 1, $cid = false, $delete_option = false )
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'lib-comment.php';

    return CMT_userComments( $sid, $title, $type, $order, $mode, $pid, $page, $cid, $delete_option );
}

/**
* This censors inappropriate content
*
* This will replace 'bad words' with something more appropriate
*
* @param        string      $Message        String to check
* @see function COM_checkHTML
* @return   string  Edited $Message
*
*/

function COM_checkWords( $Message )
{
    global $_CONF;

    $EditedMessage = $Message;

    if( $_CONF['censormode'] != 0 )
    {
        if( is_array( $_CONF['censorlist'] ))
        {
            $Replacement = $_CONF['censorreplace'];

            switch( $_CONF['censormode'])
            {
                case 1: # Exact match
                    $RegExPrefix = '(\s)';
                    $RegExSuffix = '(\W)';
                    break;

                case 2: # Word beginning
                    $RegExPrefix = '(\s)';
                    $RegExSuffix = '(\w*)';
                    break;

                case 3: # Word fragment
                    $RegExPrefix   = '(\w*)';
                    $RegExSuffix   = '(\w*)';
                    break;
            }

            foreach ($_CONF['censorlist'] as $c) {
                if (!empty($c)) {
                    $EditedMessage = MBYTE_eregi_replace($RegExPrefix . $c
                        . $RegExSuffix, "\\1$Replacement\\2", $EditedMessage);
                }
            }
        }
    }

    
    
    return $EditedMessage;
}

/**
*  Takes some amount of text and replaces all javascript events on*= with in
*
*  This script takes some amount of text and matches all javascript events, on*= (onBlur= onMouseClick=)
*  and replaces them with in*=
*  Essentially this will cause onBlur to become inBlur, onFocus to be inFocus
*  These are not valid javascript events and the browser will ignore them.
* @param    string  $Message    Text to filter
* @return   string  $Message with javascript filtered
* @see  COM_checkWords
* @see  COM_checkHTML
*
*/

function COM_killJS( $Message )
{
    return( preg_replace( '/(\s)+[oO][nN](\w*) ?=/', '\1in\2=', $Message ));
}

/**
* Handles the part within a [code] ... [/code] section, i.e. escapes all
* special characters.
*
* @param   string  $str  the code section to encode
* @return  string  $str with the special characters encoded
* @see     COM_checkHTML
*
*/
function COM_handleCode( $str )
{
    $search  = array( '&',     '\\',    '<',    '>',    '[',     ']'     );
    $replace = array( '&amp;', '&#92;', '&lt;', '&gt;', '&#91;', '&#93;' );

    $str = str_replace( $search, $replace, $str );

    return( $str );
}

/**
* This function checks html tags.
*
* Checks to see that the HTML tags are on the approved list and
* removes them if not.
*
* @param    string  $str            HTML to check
* @param    string  $permissions    comma-separated list of rights which identify the current user as an "Admin"
* @return   string                  Filtered HTML
*
*/
function COM_checkHTML( $str, $permissions = 'story.edit' )
{
    global $_CONF, $_USER;

    // replace any \ with &#092; (HTML equiv)
    $str = str_replace('\\', '&#092;', COM_stripslashes($str) );

    // Get rid of any newline characters
    $str = preg_replace( "/\n/", '', $str );

    // Replace any $ with &#36; (HTML equiv)
    $str = str_replace( '$', '&#36;', $str );
    // handle [code] ... [/code]
    do
    {
        $start_pos = MBYTE_strpos( MBYTE_strtolower( $str ), '[code]' );
        if( $start_pos !== false )
        {
            $end_pos = MBYTE_strpos( MBYTE_strtolower( $str ), '[/code]' );
            if( $end_pos !== false )
            {
                $encoded = COM_handleCode( MBYTE_substr( $str, $start_pos + 6,
                        $end_pos - ( $start_pos + 6 )));
                $encoded = '<pre><code>' . $encoded . '</code></pre>';
                $str = MBYTE_substr( $str, 0, $start_pos ) . $encoded
                     . MBYTE_substr( $str, $end_pos + 7 );
            }
            else // missing [/code]
            {
                // Treat the rest of the text as code (so as not to lose any
                // special characters). However, the calling entity should
                // better be checking for missing [/code] before calling this
                // function ...
                $encoded = COM_handleCode( MBYTE_substr( $str, $start_pos + 6 ));
                $encoded = '<pre><code>' . $encoded . '</code></pre>';
                $str = MBYTE_substr( $str, 0, $start_pos ) . $encoded;
            }
        }
    }
    while( $start_pos !== false );

    // handle [raw] ... [/raw]
    do
    {
        $start_pos = MBYTE_strpos( MBYTE_strtolower( $str ), '[raw]' );
        if( $start_pos !== false )
        {
            $end_pos = MBYTE_strpos( MBYTE_strtolower( $str ), '[/raw]' );
            if( $end_pos !== false )
            {
                $encoded = COM_handleCode( MBYTE_substr( $str, $start_pos + 5,
                        $end_pos - ( $start_pos + 5 )));
                // [raw2] to avoid infinite loop. Not HTML comment as we strip
                // them later.
                $encoded = '[raw2]' . $encoded . '[/raw2]';
                $str = MBYTE_substr( $str, 0, $start_pos ) . $encoded
                     . MBYTE_substr( $str, $end_pos + 6 );
            }
            else // missing [/raw]
            {
                // Treat the rest of the text as raw (so as not to lose any
                // special characters). However, the calling entity should
                // better be checking for missing [/raw] before calling this
                // function ...
                $encoded = COM_handleCode( MBYTE_substr( $str, $start_pos + 5 ));
                // [raw2] to avoid infinite loop. Not HTML comment as we strip
                // them later.
                $encoded = '[raw2]' . $encoded . '[/raw2]';
                $str = MBYTE_substr( $str, 0, $start_pos ) . $encoded;
            }
        }
    }
    while( $start_pos !== false );

    $has_skiphtmlfilterPermissions = SEC_hasRights ('htmlfilter.skip');
    
    if ($has_skiphtmlfilterPermissions || (isset( $_CONF['skip_html_filter_for_root'] ) &&
             ( $_CONF['skip_html_filter_for_root'] == 1 ) &&
            SEC_inGroup( 'Root' ))) {
        return $str;
    }

    // strip_tags() gets confused by HTML comments ...
    $str = preg_replace( '/<!--.+?-->/', '', $str );

    $filter = new kses4;
    if( isset( $_CONF['allowed_protocols'] ) && is_array( $_CONF['allowed_protocols'] ) && ( count( $_CONF['allowed_protocols'] ) > 0 ))
    {
        $filter->SetProtocols( $_CONF['allowed_protocols'] );
    }
    else
    {
        $filter->SetProtocols( array( 'http:', 'https:', 'ftp:' ));
    }

    if( empty( $permissions) || !SEC_hasRights( $permissions ) ||
            empty( $_CONF['admin_html'] ))
    {
        $html = $_CONF['user_html'];
    }
    else
    {
        if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
            $html = array_merge_recursive($_CONF['user_html'],
                                          $_CONF['admin_html'],
                                          $_CONF['advanced_html']);
        } else {
            $html = array_merge_recursive($_CONF['user_html'],
                                          $_CONF['admin_html']);
        }
    }

    foreach( $html as $tag => $attr )
    {
        $filter->AddHTML( $tag, $attr );
    }
    /* Replace [raw][/raw] with <!--raw--><!--/raw-->, note done "late" because
     * of the above noted // strip_tags() gets confused by HTML comments ...
     */
    $str = $filter->Parse( $str );
    $str = str_replace('[raw2]','<!--raw--><span class="raw">', $str);
    $str = str_replace('[/raw2]','</span><!--/raw-->', $str);

    return $str;
}

/**
* undo function for htmlspecialchars()
*
* This function translates HTML entities created by htmlspecialchars() back
* into their ASCII equivalents. Also handles the entities for $, {, and }.
*
* @param    string   $string   The string to convert.
* @return   string   The converted string.
*
*/
function COM_undoSpecialChars( $string )
{
    $string = str_replace( '&#36;',  '$', $string );
    $string = str_replace( '&#123;', '{', $string );
    $string = str_replace( '&#125;', '}', $string );
    $string = str_replace( '&gt;',   '>', $string );
    $string = str_replace( '&lt;',   '<', $string );
    $string = str_replace( '&quot;', '"', $string );
    $string = str_replace( '&nbsp;', ' ', $string );
    $string = str_replace( '&amp;',  '&', $string );

    return( $string );
}

/**
* Makes an ID based on current date/time
*
* This function creates a 17 digit sid for stories based on the 14 digit date
* and a 3 digit random number that was seeded with the number of microseconds
* (.000001th of a second) since the last full second.
* NOTE: this is now used for more than just stories!
*
* @return   string  $sid  Story ID
*
*/
function COM_makesid()
{
    $sid = date( 'YmdHis' );
    $sid .= rand( 0, 999 );

    return $sid;
}

/**
* Checks to see if email address is valid.
*
* This function checks to see if an email address is in the correct from.
*
* @param    string    $email   Email address to verify
* @return   boolean            True if valid otherwise false
*
*/
function COM_isEmail( $email )
{
    require_once( 'Mail/RFC822.php' );

    $rfc822 = new Mail_RFC822;

    return( $rfc822->isValidInetAddress( $email ) ? true : false );
}


/**
* Encode a string such that it can be used in an email header
*
* @param    string  $string     the text to be encoded
* @return   string              encoded text
*
*/
function COM_emailEscape( $string )
{
    global $_CONF;

    if (function_exists('CUSTOM_emailEscape')) {
        return CUSTOM_emailEscape($string);
    }

    $charset = COM_getCharset();
    if(( $charset == 'utf-8' ) && ( $string != utf8_decode( $string )))
    {
        if( function_exists( 'iconv_mime_encode' ))
        {
            $mime_parameters = array( 'input-charset'  => 'utf-8',
                                      'output-charset' => 'utf-8',
                                      // 'Q' encoding is more readable than 'B'
                                      'scheme'         => 'Q'
                                    );
            $string = substr( iconv_mime_encode( '', $string,
                                                 $mime_parameters ), 2 );
        }
        else
        {
            $string = '=?' . $charset . '?B?' . base64_encode( $string ) . '?=';
        }
    }
    else if( preg_match( '/[^0-9a-z\-\.,:;\?! ]/i', $string ))
    {
        $string = '=?' . $charset . '?B?' . base64_encode( $string ) . '?=';
    }

    return $string;
}

/**
* Takes a name and an email address and returns a string that vaguely
* resembles an email address specification conforming to RFC(2)822 ...
*
* @param    string  $name       name, e.g. John Doe
* @param    string  $address    email address only, e.g. john.doe@example.com
* @return   string              formatted email address
*
*/
function COM_formatEmailAddress($name, $address)
{
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
*
* All emails sent by Geeklog are sent through this function.
*
* NOTE: Please note that using CC: will expose the email addresses of
*       all recipients. Use with care.
*
* @param    string      $to         recipients name and email address
* @param    string      $subject    subject of the email
* @param    string      $message    the text of the email
* @param    string      $from       (optional) sender of the the email
* @param    boolean     $html       (optional) true if to be sent as HTML email
* @param    int         $priority   (optional) add X-Priority header, if > 0
* @param    mixed       $optional   (optional) other headers or CC:
* @return   boolean                 true if successful,  otherwise false
*
*/
function COM_mail($to, $subject, $message, $from = '', $html = false, $priority = 0, $optional = null)
{
    global $_CONF;

    static $mailobj;

    if (empty($from)) {
        $from = COM_formatEmailAddress($_CONF['site_name'], $_CONF['site_mail']);
    }

    $to = substr($to, 0, strcspn($to, "\r\n"));
    if (($optional != null) && !is_array($optional)) {
        $optional = substr($optional, 0, strcspn($optional, "\r\n"));
    }
    $from = substr($from, 0, strcspn($from, "\r\n"));
    $subject = substr($subject, 0, strcspn($subject, "\r\n"));
    $subject = COM_emailEscape($subject);

    if (function_exists('CUSTOM_mail')) {
        return CUSTOM_mail($to, $subject, $message, $from, $html, $priority,
                           $optional);
    }

    include_once 'Mail.php';
    include_once 'Mail/RFC822.php';

    $method = $_CONF['mail_settings']['backend'];

    if (! isset($mailobj)) {
        if (($method == 'sendmail') || ($method == 'smtp')) {
            $mailobj =& Mail::factory($method, $_CONF['mail_settings']);
        } else {
            $method = 'mail';
            $mailobj =& Mail::factory($method);
        }
    }

    $charset = COM_getCharset();
    $headers = array();

    $headers['From'] = $from;
    if ($method != 'mail') {
        $headers['To'] = $to;
    }
    if (($optional != null) && !is_array($optional) && !empty($optional)) {
        // assume old (optional) CC: header
        $headers['Cc'] = $optional;
    }
    $headers['Date'] = date('r'); // RFC822 formatted date
    if($method == 'smtp') {
        list($usec, $sec) = explode(' ', microtime());
        $m = substr($usec, 2, 5);
        $headers['Message-Id'] = '<' .  date('YmdHis') . '.' . $m
                               . '@' . $_CONF['mail_settings']['host'] . '>';
    }
    if ($html) {
        $headers['Content-Type'] = 'text/html; charset=' . $charset;
        $headers['Content-Transfer-Encoding'] = '8bit';
    } else {
        $headers['Content-Type'] = 'text/plain; charset=' . $charset;
    }
    $headers['Subject'] = $subject;
    if ($priority > 0) {
        $headers['X-Priority'] = $priority;
    }
    $headers['X-Mailer'] = 'Geeklog ' . VERSION;

    if (!empty($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['SERVER_ADDR']) &&
            ($_SERVER['REMOTE_ADDR'] != $_SERVER['SERVER_ADDR'])) {
        $url = COM_getCurrentURL();
        if (substr($url, 0, strlen($_CONF['site_admin_url']))
                != $_CONF['site_admin_url']) {
            $headers['X-Originating-IP'] = $_SERVER['REMOTE_ADDR'];
        }
    }

    // add optional headers last
    if (($optional != null) && is_array($optional)) {
        foreach ($optional as $h => $v) {
            $headers[$h] = $v;
        }
    }

    $retval = $mailobj->send($to, $headers, $message);
    if ($retval !== true) {
        COM_errorLog($retval->toString(), 1);
    }

    return($retval === true ? true : false);
}


/**
* Creates older stuff block
*
* Creates the olderstuff block for display.
* Actually updates the olderstuff record in the gl_blocks database.
* @return   void
*/

function COM_olderStuff()
{
    global $_TABLES, $_CONF;

    $sql['mysql'] = "SELECT sid,ta.tid,title,comments,UNIX_TIMESTAMP(date) AS day 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
        WHERE ta.type = 'article' AND ta.id = sid   
        AND (perm_anon = 2) AND (frontpage = 1) AND (date <= NOW()) AND (draft_flag = 0)" . COM_getTopicSQL('AND', 1, 'ta') . "
        GROUP BY sid 
        ORDER BY featured DESC, date DESC LIMIT {$_CONF['limitnews']}, {$_CONF['limitnews']}";
    
    $sql['mssql'] = $sql['mysql'];
    
    $sql['pgsql'] = "SELECT sid,ta.tid,title,comments,date_part('epoch',date) AS day 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta  
        WHERE ta.type = 'article' AND ta.id = sid AND 
        AND (perm_anon = 2) AND (frontpage = 1) AND (date <= NOW()) AND (draft_flag = 0)" . COM_getTopicSQL('AND', 1, 'ta') . " 
        GROUP BY sid 
        ORDER BY featured DESC, date DESC LIMIT {$_CONF['limitnews']}, {$_CONF['limitnews']}";

    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    if( $nrows > 0 )
    {
        $dateonly = $_CONF['dateonly'];
        if( empty( $dateonly ))
        {
            $dateonly = '%d-%b'; // fallback: day - abbrev. month name
        }

        $day = 'noday';
        $string = '';

        for( $i = 0; $i < $nrows; $i++ )
        {
            $A = DB_fetchArray( $result );

            $daycheck = strftime( '%A', $A['day'] );
            if( $day != $daycheck )
            {
                if( $day != 'noday' )
                {
                    $daylist = COM_makeList( $oldnews, 'list-older-stories' );
                    $daylist = preg_replace( "/(\015\012)|(\015)|(\012)/",
                                             '', $daylist );
                    $string .= $daylist . '<br' . XHTML . '>';
                }

                $day2 = strftime( $dateonly, $A['day'] );
                $string .= '<h3>' . $daycheck . ' <small>' . $day2
                        . '</small></h3>' . LB;
                $oldnews = array();
                $day = $daycheck;
            }

            $oldnews_url = COM_buildUrl( $_CONF['site_url'] . '/article.php?story='
                . $A['sid'] );
            $oldnews[] = COM_createLink($A['title'], $oldnews_url)
                .' (' . COM_numberFormat( $A['comments'] ) . ')';
        }

        if( !empty( $oldnews ))
        {
            $daylist = COM_makeList( $oldnews, 'list-older-stories' );
            $daylist = preg_replace( "/(\015\012)|(\015)|(\012)/", '', $daylist );
            $string .= $daylist;
            $string = addslashes( $string );

            DB_query( "UPDATE {$_TABLES['blocks']} SET content = '$string' WHERE name = 'older_stories'" );
        }
    }
}

/**
* Shows a single Geeklog block
*
* This shows a single block and is typically called from
* COM_showBlocks OR from plugin code
*
* @param        string      $name       Logical name of block (not same as title) -- 'user_block', 'admin_block', 'section_block', 'whats_new_block'.
* @param        string      $help       Help file location
* @param        string      $title      Title shown in block header
* @param        string      $position   Side, 'left', 'right' or empty.
* @see function COM_showBlocks
* @return   string  HTML Formated block
*
*/

function COM_showBlock( $name, $help='', $title='', $position='' )
{
    global $_CONF, $topic, $_TABLES, $_USER;

    $retval = '';

    if( !isset( $_USER['noboxes'] ))
    {
        if( !COM_isAnonUser() )
        {
            $_USER['noboxes'] = DB_getItem( $_TABLES['userindex'], 'noboxes',
                                            "uid = {$_USER['uid']}" );
        }
        else
        {
            $_USER['noboxes'] = 0;
        }
    }

    switch( $name )
    {
        case 'user_block':
            $retval .= COM_userMenu( $help,$title, $position );
            break;

        case 'admin_block':
            $retval .= COM_adminMenu( $help,$title, $position );
            break;

        case 'section_block':
            $retval .= COM_startBlock( $title, $help,
                               COM_getBlockTemplate( $name, 'header', $position ))
                . COM_showTopics( $topic )
                . COM_endBlock( COM_getBlockTemplate( $name, 'footer', $position ));
            break;

        case 'whats_new_block':
            if( !$_USER['noboxes'] )
            {
                $retval .= COM_whatsNewBlock( $help, $title, $position );
            }
            break;
    }

    return $retval;
}


/**
* Shows Geeklog blocks
*
* Returns HTML for blocks on a given side and, potentially, for
* a given topic. Currently only used by static pages.
*
* @param        string      $side       Side to get blocks for (right or left for now)
* @param        string      $topic      Only get blocks for this topic
* @param        string      $name       Block name (not used)
* @see function COM_showBlock
* @return   string  HTML Formated blocks
*
*/

function COM_showBlocks( $side, $topic='', $name='all' )
{
    global $_CONF, $_TABLES, $_USER, $LANG21, $topic, $page, $_TOPICS;

    $retval = '';

    // Get user preferences on blocks
    if( !isset( $_USER['noboxes'] ) || !isset( $_USER['boxes'] ))
    {
        if( !COM_isAnonUser() )
        {
            $result = DB_query( "SELECT boxes,noboxes FROM {$_TABLES['userindex']} "
                               ."WHERE uid = '{$_USER['uid']}'" );
            list($_USER['boxes'], $_USER['noboxes']) = DB_fetchArray( $result );
        }
        else
        {
            $_USER['boxes'] = '';
            $_USER['noboxes'] = 0;
        }
    }

    $blocksql['mssql']  = "SELECT bid, is_enabled, name, b.type, title, blockorder, cast(content as text) as content, ";
    $blocksql['mssql'] .= "rdfurl, rdfupdated, rdflimit, onleft, phpblockfn, help, owner_id, ";
    $blocksql['mssql'] .= "group_id, perm_owner, perm_group, perm_members, perm_anon, allow_autotags,UNIX_TIMESTAMP(rdfupdated) AS date ";

    $blocksql['mysql'] = "SELECT b.*,UNIX_TIMESTAMP(rdfupdated) AS date ";
    $blocksql['pgsql'] = 'SELECT b.*, date_part(\'epoch\', rdfupdated) AS date ';
    
    

    $commonsql = "FROM {$_TABLES['blocks']} b, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'block' AND ta.id = bid AND is_enabled = 1";

    if( $side == 'left' ) {
        $commonsql .= " AND onleft = 1";
    } else {
        $commonsql .= " AND onleft = 0";
    }

    if(!empty($topic) && $topic != TOPIC_ALL_OPTION && $topic != TOPIC_HOMEONLY_OPTION && $_TOPICS[TOPIC_getIndex($topic)]['access'] > 0) {
        // Retrieve list of inherited topics
        $tid_list = TOPIC_getChildList($topic);
        // Get list of blocks to display (except for dynamic). This includes blocks for all topics, and child blocks that are inherited
        $commonsql .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$topic}')) OR ta.tid = 'all')";
    } else {
        if( COM_onFrontpage() ) {
            $commonsql .= " AND (ta.tid = '" . TOPIC_HOMEONLY_OPTION . "' OR ta.tid = '" . TOPIC_ALL_OPTION . "')";
        } else {
            $commonsql .= " AND (ta.tid = '" . TOPIC_ALL_OPTION . "')";
        }
    }

    if( !empty( $_USER['boxes'] )) {
        $BOXES = str_replace( ' ', ',', $_USER['boxes'] );

        $commonsql .= " AND (bid NOT IN ($BOXES) OR bid = '-1')";
    }

    $commonsql .= ' ORDER BY blockorder,title ASC';

    $blocksql['mysql'] .= $commonsql;
    $blocksql['mssql'] .= $commonsql;
    $blocksql['pgsql'] .= $commonsql;
    
    $result = DB_query( $blocksql );
    $nrows = DB_numRows( $result );

    // convert result set to an array of associated arrays
    $blocks = array();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $blocks[] = DB_fetchArray( $result );
    }

    // Check and see if any plugins have blocks to show
    $pluginBlocks = PLG_getBlocks( $side, $topic, $name );
    $blocks = array_merge( $blocks, $pluginBlocks );

    // sort the resulting array by block order
    $column = 'blockorder';
    $sortedBlocks = $blocks;
    $num_sortedBlocks = count( $sortedBlocks );
    for( $i = 0; $i < $num_sortedBlocks - 1; $i++ )
    {
        for( $j = 0; $j < $num_sortedBlocks - 1 - $i; $j++ )
        {
            if( $sortedBlocks[$j][$column] > $sortedBlocks[$j+1][$column] )
            {
                $tmp = $sortedBlocks[$j];
                $sortedBlocks[$j] = $sortedBlocks[$j + 1];
                $sortedBlocks[$j + 1] = $tmp;
            }
        }
    }
    $blocks = $sortedBlocks;

    // Loop though resulting sorted array and pass associative arrays
    // to COM_formatBlock
    foreach( $blocks as $A )
    {
        if( $A['type'] == 'dynamic' or SEC_hasAccess( $A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon'] ) > 0 )
        {
           $retval .= COM_formatBlock( $A, $_USER['noboxes'] );
        }
    }

    return $retval;
}

/**
* Formats a Geeklog block
*
* This shows a single block and is typically called from
* COM_showBlocks OR from plugin code
*
* @param        array     $A          Block Record
* @param        boolean   $noboxes    Set to true if userpref is no blocks
* @return       string    HTML Formated block
*
*/
function COM_formatBlock( $A, $noboxes = false )
{
    global $_CONF, $_TABLES, $LANG21;

    $retval = '';

    $lang = COM_getLanguageId();
    if (!empty($lang)) {

        $blocksql['mssql']  = "SELECT bid, is_enabled, name, type, title, tid, blockorder, cast(content as text) as content, ";
        $blocksql['mssql'] .= "rdfurl, rdfupdated, rdflimit, onleft, phpblockfn, help, owner_id, ";
        $blocksql['mssql'] .= "group_id, perm_owner, perm_group, perm_members, perm_anon, allow_autotags,UNIX_TIMESTAMP(rdfupdated) AS date ";

        $blocksql['mysql'] = "SELECT *,UNIX_TIMESTAMP(rdfupdated) AS date ";
        $blocksql['pgsql'] =  'SELECT *, date_part(\'epoch\', rdfupdated) AS date ';

        $commonsql = "FROM {$_TABLES['blocks']} WHERE name = '"
                   . $A['name'] . '_' . $lang . "'";

        $blocksql['mysql'] .= $commonsql;
        $blocksql['mssql'] .= $commonsql;
        $blocksql['pgsql'] .= $commonsql;
        $result = DB_query( $blocksql );

        if (DB_numRows($result) == 1) {
            // overwrite with data for language-specific block
            $A = DB_fetchArray($result);
        }
    }
    
    if( array_key_exists( 'onleft', $A ) )
    {
        if( $A['onleft'] == 1 )
        {
            $position = 'left';
        } else {
            $position = 'right';
        }
    } else {
        $position = '';
    }

    if( $A['type'] == 'portal' )
    {
        if( COM_rdfCheck( $A['bid'], $A['rdfurl'], $A['date'], $A['rdflimit'] ))
        {
            $A['content'] = DB_getItem( $_TABLES['blocks'], 'content',
                                        "bid = '{$A['bid']}'");
        }
    }

    if( $A['type'] == 'gldefault' )
    {
        $retval .= COM_showBlock( $A['name'], $A['help'], $A['title'], $position );
    }

    if( $A['type'] == 'phpblock' && !$noboxes )
    {
        if( !( $A['name'] == 'whosonline_block' AND DB_getItem( $_TABLES['blocks'], 'is_enabled', "name='whosonline_block'" ) == 0 ))
        {
            $function = $A['phpblockfn'];
            $matches = array();
            if (preg_match('/^(phpblock_\w*)\\((.*)\\)$/', $function, $matches) == 1)
            {
                $function = $matches[1];
                $args = $matches[2];
            }
            $blkheader = COM_startBlock( $A['title'], $A['help'],
                    COM_getBlockTemplate( $A['name'], 'header', $position ));
            $blkfooter = COM_endBlock( COM_getBlockTemplate( $A['name'],
                    'footer', $position ));

            if( function_exists( $function ))
            {
               if (isset($args))
               {
                    $fretval = $function($A, $args);
               } else {
                    $fretval = $function();
               }
               if( !empty( $fretval ))
               {
                    $retval .= $blkheader;
                    $retval .= $fretval;
                    $retval .= $blkfooter;
               }
            }
            else
            {
                // show error message
                $retval .= $blkheader;
                $retval .= sprintf( $LANG21[31], $function );
                $retval .= $blkfooter;
            }
        }
    }

    if (!empty($A['content']) && (trim($A['content']) != '') && !$noboxes) {
        $blockcontent = stripslashes($A['content']);

        // Hack: If the block content starts with a '<' assume it
        // contains HTML and do not call nl2br() which would only add
        // unwanted <br> tags.

        if (substr(trim($blockcontent), 0, 1) != '<') {
            $blockcontent = nl2br($blockcontent);
        }

        // autotags are only(!) allowed in normal blocks
        if (($A['allow_autotags'] == 1) && ($A['type'] == 'normal')) {
            $blockcontent = PLG_replaceTags($blockcontent);
        }
        $blockcontent = str_replace(array('<?', '?>'), '', $blockcontent);

        $retval .= COM_startBlock($A['title'], $A['help'],
                       COM_getBlockTemplate($A['name'], 'header', $position))
                . $blockcontent . LB
                . COM_endBlock(COM_getBlockTemplate($A['name'], 'footer', $position));
    }

    return $retval;
}


/**
* Checks to see if it's time to import and RDF/RSS block again
*
* Updates RDF/RSS block if needed
*
* @param    string  $bid            Block ID
* @param    string  $rdfurl         URL to get headlines from
* @param    string  $date           Last time the headlines were imported
* @param    string  $maxheadlines   max. number of headlines to import
* @return   void
* @see function COM_rdfImport
*
*/
function COM_rdfCheck( $bid, $rdfurl, $date, $maxheadlines = 0 )
{
    $retval = false;
    $nextupdate = $date + 3600;

    if( $nextupdate < time() )
    {
        COM_rdfImport( $bid, $rdfurl, $maxheadlines );
        $retval = true;
    }

    return $retval;
}

/**
* Syndication import function. Imports headline data to a portal block.
*
* Rewritten December 19th 2004 by Michael Jervis (mike AT fuckingbrit DOT com).
* Now utilises a Factory Pattern to open a URL and automaticaly retreive a feed
* object populated with feed data. Then import it into the portal block.
*
* @param    string  $bid            Block ID
* @param    string  $rdfurl         URL to get content from
* @param    int     $maxheadlines   Maximum number of headlines to display
* @return   void
* @see function COM_rdfCheck
*
*/
function COM_rdfImport($bid, $rdfurl, $maxheadlines = 0)
{
    global $_CONF, $_TABLES, $LANG21;

    // Import the feed handling classes:
    require_once $_CONF['path_system']
                 . '/classes/syndication/parserfactory.class.php';
    require_once $_CONF['path_system']
                 . '/classes/syndication/feedparserbase.class.php';

    $result = DB_query("SELECT rdf_last_modified, rdf_etag FROM {$_TABLES['blocks']} WHERE bid = $bid");
    list($last_modified, $etag) = DB_fetchArray($result);

    // Load the actual feed handlers:
    $factory = new FeedParserFactory($_CONF['path_system']
                                     . '/classes/syndication/');
    $factory->userAgent = 'Geeklog/' . VERSION;
    if (!empty($last_modified) && !empty($etag)) {
        $factory->lastModified = $last_modified;
        $factory->eTag = $etag;
    }

    // Aquire a reader:
    $feed = $factory->reader($rdfurl, $_CONF['default_charset']);

    if ($feed) {
        /* We have located a reader, and populated it with the information from
         * the syndication file. Now we will sort out our display, and update
         * the block.
         */
        if ($maxheadlines == 0) {
            if (!empty($_CONF['syndication_max_headlines'])) {
                $maxheadlines = $_CONF['syndication_max_headlines'];
            } else {
                $maxheadlines = count($feed->articles);
            }
        }

        $update = date('Y-m-d H:i:s');
        $last_modified = '';
        if (!empty($factory->lastModified)) {
            $last_modified = addslashes($factory->lastModified);
        }
        $etag = '';
        if (!empty($factory->eTag)) {
            $etag = addslashes($factory->eTag);
        }

        if (empty($last_modified) || empty($etag)) {
            DB_query("UPDATE {$_TABLES['blocks']} SET rdfupdated = '$update', rdf_last_modified = NULL, rdf_etag = NULL WHERE bid = '$bid'");
        } else {
            DB_query("UPDATE {$_TABLES['blocks']} SET rdfupdated = '$update', rdf_last_modified = '$last_modified', rdf_etag = '$etag' WHERE bid = '$bid'");
        }

        $charset = COM_getCharset();

        // format articles for display
        $readmax = min($maxheadlines, count($feed->articles));
        for ($i = 0; $i < $readmax; $i++) {
            if (empty($feed->articles[$i]['title'])) {
                $feed->articles[$i]['title'] = $LANG21[61];
            }

            if ($charset == 'utf-8') {
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
        $content = COM_makeList($articles, 'list-feed');
        $content = str_replace(array("\015", "\012"), '', $content);

        if (strlen($content) > 65000) {
            $content = $LANG21[68];
        }

        // Standard theme based function to put it in the block
        $result = DB_change($_TABLES['blocks'], 'content',
                            addslashes($content), 'bid', $bid);
    } else if ($factory->errorStatus !== false) {
        // failed to aquire info, 0 out the block and log an error
        COM_errorLog("Unable to aquire feed reader for $rdfurl", 1);
        COM_errorLog($factory->errorStatus[0] . ' ' .
                     $factory->errorStatus[1] . ' ' .
                     $factory->errorStatus[2]);
        $content = addslashes($LANG21[4]);
        DB_query("UPDATE {$_TABLES['blocks']} SET content = '$content', rdf_last_modified = NULL, rdf_etag = NULL WHERE bid = $bid");
    }
}


/**
* Returns what HTML is allowed in content
*
* Returns what HTML tags the system allows to be used inside content.
* You can modify this by changing $_CONF['user_html'] in the configuration
* (for admins, see also $_CONF['admin_html']).
*
* @param    string  $permissions        comma-separated list of rights which identify the current user as an "Admin"
* @param    boolean $list_only          true = return only the list of HTML tags
* @param    boolean $filter_html_flag   0 = returns allowed all html tags, 1 = returns allowed HTML tags only, 2 = returns No HTML Tags Allowed (this is used by plugins if they have a config that overrides Geeklogs filter html settings or do not have a post mode)
* @return   string                  HTML <div>/<span> enclosed string
* @see      function COM_checkHTML
* @todo     Bugs: The list always includes the [code], [raw], and [page_break]
*           tags when story.* permissions are required, even when those tags
*           are not actually available (e.g. in comments on stories).
*
*/
function COM_allowedHTML($permissions = 'story.edit', $list_only = false, $filter_html_flag = 1)
{
    global $_CONF, $_PLUGINS, $LANG01;

    $retval = '';
    $has_skiphtmlfilterPermissions = SEC_hasRights ('htmlfilter.skip');

    if (($has_skiphtmlfilterPermissions || (isset($_CONF['skip_html_filter_for_root']) &&
             ($_CONF['skip_html_filter_for_root'] == 1) &&
            SEC_inGroup('Root'))) || ($filter_html_flag == 0)) {

        if (!$list_only) {
            $retval .= '<span class="warningsmall">' . $LANG01[123]
                    . ',</span> ';
        }
        $retval .= '<div dir="ltr" class="warningsmall">';
    } elseif ($filter_html_flag == 2) {

        if (!$list_only) {
            $retval .= '<span class="warningsmall">' . $LANG01[131]
                    . ',</span> ';
        }
        $retval .= '<div dir="ltr" class="warningsmall">';
    } else {

        if (! $list_only) {
            $retval .= '<span class="warningsmall">' . $LANG01[31] . '</span> ';
        }

        if (empty($permissions) || !SEC_hasRights($permissions) ||
                empty($_CONF['admin_html'])) {
            $html = $_CONF['user_html'];
        } else {
            $html = array_merge_recursive($_CONF['user_html'],
                                          $_CONF['admin_html']);
        }

        $retval .= '<div dir="ltr" class="warningsmall">';
        foreach ($html as $tag => $attr) {
            $retval .= '&lt;' . $tag . '&gt;, ';
        }
    }

    $with_story_perms = false;
    $perms = explode(',', $permissions);
    foreach ($perms as $p) {
        if (substr($p, 0, 6) == 'story.') {
            $with_story_perms = true;
            break;
        }
    }

    if ($with_story_perms) {
        $retval .= '[code], [raw], ';

        if ($_CONF['allow_page_breaks'] == 1) {
            $retval .= '[page_break], ';
        }
    }

    // List autotags user has permission to use (with descriptions)
    $autotags = array_keys(PLG_collectTags('permission'));
    $description = array_flip(PLG_collectTags('description'));
    $done_once = false;
    $comma = '';
    foreach ($autotags as $tag) {
        if ($done_once) { 
            $comma = ', ';
        }
        if (! empty($description[$tag])) {
           $desc = str_replace(array('[',']'), array('&#91;', '&#93;'), $description[$tag]);
           $retval .= $comma . COM_getTooltip('&#91;' . $tag . ':&#93;', $desc, '', $LANG01[132],'information');
        } else {
           $retval .= $comma . '&#91;' . $tag . ':&#93;';
        }
        $done_once = true;
    }
    $retval .= '</div>';

    return $retval;
    

    return $retval;
}

/**
* Return the password for the given username
*
* Fetches a password for the given user
*
* @param    string  $loginname  username to get password for
* @return   string              Password or ''
*
*/

function COM_getPassword( $loginname )
{
    global $_TABLES, $LANG01;

    $result = DB_query( "SELECT passwd FROM {$_TABLES['users']} WHERE username='$loginname'" );
    $tmp = DB_error();
    $nrows = DB_numRows( $result );

    if(( $tmp == 0 ) && ( $nrows == 1 ))
    {
        $U = DB_fetchArray( $result );
        return $U['passwd'];
    }
    else
    {
        $tmp = $LANG01[32] . ": '" . $loginname . "'";
        COM_errorLog( $tmp, 1 );
    }

    return '';
}


/**
* Return the username or fullname for the passed member id (uid)
*
* Allows the siteAdmin to determine if loginname (username) or fullname
* should be displayed.
*
* @param    int     $uid        site member id
* @param    string  $username   Username, if this is set no lookup is done.
* @param    string  $fullname   Users full name.
* @param    string  $remoteusername  Username on remote service
* @param    string  $remoteservice   Remote login service.
* @return   string  Username, fullname or username@Service
*
*/
function COM_getDisplayName($uid = '', $username = '', $fullname = '', $remoteusername = '', $remoteservice = '')
{
    global $_CONF, $_TABLES, $_USER;

    if ($uid == '') {
        if (COM_isAnonUser()) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    }

    // "this shouldn't happen"
    if ($uid == 0) {
        $uid = 1;
    }

    if (empty($username)) {
        $query = DB_query("SELECT username, fullname, remoteusername, remoteservice FROM {$_TABLES['users']} WHERE uid='$uid'");
        list($username, $fullname, $remoteusername, $remoteservice) = DB_fetchArray($query);
    }

    if (!empty($fullname) && ($_CONF['show_fullname'] == 1)) {
        return $fullname;
    } elseif (($_CONF['user_login_method']['3rdparty'] || $_CONF['user_login_method']['openid']) && !empty($remoteusername)) {
        if (! empty($username)) {
            $remoteusername = $username;
        }

        if ($_CONF['show_servicename']) {
            return "$remoteusername@$remoteservice";
        } else {
            return $remoteusername;
        }
    }

    return $username;
}


/**
* Adds a hit to the system
*
* This function is called in the footer of every page and is used to
* track the number of hits to the Geeklog system.  This information is
* shown on stats.php
*
*/

function COM_hit()
{
    global $_TABLES;

    $sql = array();
    $sql['mysql'] = "UPDATE {$_TABLES['vars']} SET value=value+1 WHERE name = 'totalhits'";
    $sql['mssql'] = "UPDATE {$_TABLES['vars']} SET value=value+1 WHERE name = 'totalhits'";
    $sql['pgsql'] = "UPDATE {$_TABLES['vars']} SET value=value::int4+1 WHERE name = 'totalhits'";
    DB_query($sql);
}

/**
* This will email new stories in the topics that the user is interested in
*
* In account information the user can specify which topics for which they
* will receive any new article for in a daily digest.
*
* @return   void
*/

function COM_emailUserTopics()
{
    global $_CONF, $_TABLES, $LANG04, $LANG08, $LANG24;

    if ($_CONF['emailstories'] == 0) {
        return;
    }

    $subject = strip_tags( $_CONF['site_name'] . $LANG08[30] . strftime( '%Y-%m-%d', time() ));

    $authors = array();

    // Get users who want stories emailed to them
    $usersql = "SELECT username,email,etids,{$_TABLES['users']}.uid AS uuid "
        . "FROM {$_TABLES['users']}, {$_TABLES['userindex']} "
        . "WHERE {$_TABLES['users']}.uid > 1 AND {$_TABLES['userindex']}.uid = {$_TABLES['users']}.uid AND (etids <> '-' OR etids IS NULL) ORDER BY {$_TABLES['users']}.uid";

    $users = DB_query( $usersql );
    $nrows = DB_numRows( $users );

    $lastrun = DB_getItem( $_TABLES['vars'], 'value', "name = 'lastemailedstories'" );

    // For each user, pull the stories they want and email it to them
    for( $x = 0; $x < $nrows; $x++ )
    {
        $U = DB_fetchArray( $users );

        $storysql = array();
        $storysql['mysql'] = "SELECT sid,uid,date AS day,title,introtext,bodytext";
        $storysql['pgsql'] = "SELECT sid,uid,date AS day,title,introtext,postmode";
        $storysql['mssql'] = "SELECT sid,uid,date AS day,title,CAST(introtext AS text) AS introtext,CAST(bodytext AS text) AS introtext";

        $commonsql = " FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta  
            WHERE draft_flag = 0 AND date <= NOW() AND date >= '{$lastrun}' 
            AND ta.type = 'article' AND ta.id = sid ";

        $topicsql = "SELECT tid FROM {$_TABLES['topics']}"
                  . COM_getPermSQL( 'WHERE', $U['uuid'] );
        $tresult = DB_query( $topicsql );
        $trows = DB_numRows( $tresult );

        if( $trows == 0 )
        {
            // this user doesn't seem to have access to any topics ...
            continue;
        }

        $TIDS = array();
        for( $i = 0; $i < $trows; $i++ )
        {
            $T = DB_fetchArray( $tresult );
            $TIDS[] = $T['tid'];
        }

        if( !empty( $U['etids'] ))
        {
            $ETIDS = explode( ' ', $U['etids'] );
            $TIDS = array_intersect( $TIDS, $ETIDS );
        }

        if( count( $TIDS ) > 0) {
            // We have list of Daily Digest topic ids that user has access too and that the user wants a report on
             $commonsql .= " AND (ta.tid IN ('" . implode( "','", $TIDS ) . "'))";
        }

        $commonsql .= COM_getPermSQL( 'AND', $U['uuid'] );
        $commonsql .= ' GROUP BY sid 
            ORDER BY featured DESC, date DESC';

        $storysql['mysql'] .= $commonsql;
        $storysql['mssql'] .= $commonsql;
        $storysql['pgsql'] .= $commonsql; 

        $stories = DB_query( $storysql );
        $nsrows = DB_numRows( $stories );

        if( $nsrows == 0 )
        {
            // If no new stories where pulled for this user, continue with next
            continue;
        }

        $mailtext = $LANG08[29] . strftime( $_CONF['shortdate'], time() ) . "\n";

        for( $y = 0; $y < $nsrows; $y++ )
        {
            // Loop through stories building the requested email message
            $S = DB_fetchArray( $stories );

            $mailtext .= "\n------------------------------\n\n";
            $mailtext .= "$LANG08[31]: "
                . COM_undoSpecialChars( stripslashes( $S['title'] )) . "\n";
            if( $_CONF['contributedbyline'] == 1 )
            {
                if( empty( $authors[$S['uid']] ))
                {
                    $storyauthor = COM_getDisplayName ($S['uid']);
                    $authors[$S['uid']] = $storyauthor;
                }
                else
                {
                    $storyauthor = $authors[$S['uid']];
                }
                $mailtext .= "$LANG24[7]: " . $storyauthor . "\n";
            }

            $mailtext .= "$LANG08[32]: " . strftime( $_CONF['date'], strtotime( $S['day' ])) . "\n\n";

            if( $_CONF['emailstorieslength'] > 0 )
            {
                if($S['postmode']==='wikitext'){
                    $storytext = COM_undoSpecialChars( strip_tags( COM_renderWikiText ( stripslashes( $S['introtext'] ))));
                } else {
                    $storytext = COM_undoSpecialChars( strip_tags( PLG_replaceTags( stripslashes( $S['introtext'] ))));
                }

                if( $_CONF['emailstorieslength'] > 1 )
                {
                    $storytext = COM_truncate( $storytext,
                                    $_CONF['emailstorieslength'], '...' );
                }

                $mailtext .= $storytext . "\n\n";
            }

            $mailtext .= $LANG08[33] . ' ' . COM_buildUrl( $_CONF['site_url']
                      . '/article.php?story=' . $S['sid'] ) . "\n";
        }

        $mailtext .= "\n------------------------------\n";
        $mailtext .= "\n$LANG08[34]\n";
        $mailtext .= "\n------------------------------\n";

        $mailto = $U['username'] . ' <' . $U['email'] . '>';

        if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
            $mailfrom = $_CONF['noreply_mail'];
            $mailtext .= LB . LB . $LANG04[159];
        } else {
            $mailfrom = $_CONF['site_mail'];
        }
        COM_mail( $mailto, $subject, $mailtext , $mailfrom);
    }

    DB_query( "UPDATE {$_TABLES['vars']} SET value = NOW() WHERE name = 'lastemailedstories'" );
}

/**
* Shows any new information in a block
*
* Return the HTML that shows any new stories, comments, etc
*
* @param    string  $help     Help file for block
* @param    string  $title    Title used in block header
* @param    string  $position Position in which block is being rendered 'left', 'right' or blank (for centre)
* @return   string  Return the HTML that shows any new stories, comments, etc
*
*/

function COM_whatsNewBlock( $help = '', $title = '', $position = '' )
{
    global $_CONF, $_TABLES, $LANG01, $LANG_WHATSNEW, $page, $newstories;

    $retval = COM_startBlock( $title, $help,
                       COM_getBlockTemplate( 'whats_new_block', 'header', $position ));

    $topicsql = '';
    if(( $_CONF['hidenewstories'] == 0 ) || ( $_CONF['hidenewcomments'] == 0 )
            || ( $_CONF['trackback_enabled']
            && ( $_CONF['hidenewtrackbacks'] == 0 )))
    {
        $topicsql = COM_getTopicSql ('AND', 0, 'ta');
    }

    if( $_CONF['hidenewstories'] == 0 )
    {
        $where_sql = " AND ta.type = 'article' AND ta.id = sid";

        $archsql = '';
        $archivetid = DB_getItem( $_TABLES['topics'], 'tid', "archive_flag=1" );
        if(!empty( $archivetid )) {
            $where_sql .= " AND (ta.tid <> '$archivetid')";
        }

        // Find the newest stories
        $sql['mssql'] = "SELECT COUNT(DISTINCT sid) AS count FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta  
            WHERE (date >= (date_sub(NOW(), INTERVAL {$_CONF['newstoriesinterval']} SECOND))) AND (date <= NOW()) AND (draft_flag = 0)" . $where_sql . COM_getPermSQL( 'AND' ) . $topicsql . COM_getLangSQL( 'sid', 'AND' );
        
        $sql['mysql'] = "SELECT COUNT(DISTINCT sid) AS count FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
            WHERE (date >= (date_sub(NOW(), INTERVAL {$_CONF['newstoriesinterval']} SECOND))) AND (date <= NOW()) AND (draft_flag = 0)" . $where_sql . COM_getPermSQL( 'AND' ) . $topicsql . COM_getLangSQL( 'sid', 'AND' );
        
        $sql['pgsql'] = "SELECT COUNT(DISTINCT sid) AS count FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
            WHERE (date >= (NOW() - INTERVAL '{$_CONF['newstoriesinterval']} SECOND')) AND (date <= NOW()) AND (draft_flag = 0)" . $where_sql . COM_getPermSQL( 'AND' ) . $topicsql . COM_getLangSQL( 'sid', 'AND' );        
        
        $result = DB_query( $sql );
        $A = DB_fetchArray( $result );
        $nrows = $A['count'];

        if( empty( $title ))
        {
            $title = DB_getItem( $_TABLES['blocks'], 'title', "name='whats_new_block'" );
        }

        // Any late breaking news stories?
        $retval .= '<h3>' . $LANG01[99] . '</h3>';

        if( $nrows > 0 )
        {
            $newmsg = COM_formatTimeString( $LANG_WHATSNEW['new_string'],
                        $_CONF['newstoriesinterval'], $LANG01[11], $nrows);

            if( $newstories && ( $page < 2 ))
            {
                $retval .= $newmsg . '<br' . XHTML . '>';
            }
            else
            {
                $retval .= COM_createLink($newmsg, $_CONF['site_url']
                    . '/index.php?display=new') . '<br' . XHTML . '>';
            }
        }
        else
        {
            $retval .= $LANG01[100] . '<br' . XHTML . '>';
        }

        if(( $_CONF['hidenewcomments'] == 0 ) || ( $_CONF['trackback_enabled']
                && ( $_CONF['hidenewtrackbacks'] == 0 ))
                || ( $_CONF['hidenewplugins'] == 0 ))
        {
            $retval .= '<br' . XHTML . '>';
        }
    }

    if( $_CONF['hidenewcomments'] == 0 )
    {
        // Go get the newest comments
        $retval .= '<h3>' . $LANG01[83] . ' <small>'
                . COM_formatTimeString( $LANG_WHATSNEW['new_last'],
                                        $_CONF['newcommentsinterval'] )
                . '</small></h3>';

        $new_plugin_comments = array();
        $new_plugin_comments = PLG_getWhatsNewComment();
        
        if( !empty($new_plugin_comments) ) {
            // Sort array by element lastdate newest to oldest
            foreach($new_plugin_comments as $k=>$v) {		
                $b[$k] = strtolower($v['lastdate']);	
            }	
            arsort($b);	
            foreach($b as $key=>$val) {		
                $temp[] = $new_plugin_comments[$key];	
            }	   
            $new_plugin_comments = $temp;

            $newcomments = array();
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
                    $title = COM_undoSpecialChars( stripslashes( $A['title'] ));
                    $titletouse = COM_truncate( $title, $_CONF['title_trim_length'],
                                                '...' );
                    if( $title != $titletouse ) {
                        $attr = array('title' => htmlspecialchars($title));
                    } else {
                        $attr = array();
                    }
                    $acomment = str_replace( '$', '&#36;', $titletouse );
                    $acomment = str_replace( ' ', '&nbsp;', $acomment );
    
                    if( $A['dups'] > 1 ) {
                        $acomment .= ' [+' . $A['dups'] . ']';
                    }
    
                    $newcomments[] = COM_createLink($acomment, $url, $attr);
                    
                    if ($count == 15) {
                        break;   
                    }
                }
                
            }

            $retval .= COM_makeList( $newcomments, 'list-new-comments' );
        } else {
            $retval .= $LANG01[86] . '<br' . XHTML . '>' . LB;
        }
        
        if(( $_CONF['hidenewplugins'] == 0 )
                || ( $_CONF['trackback_enabled']
                && ( $_CONF['hidenewtrackbacks'] == 0 )))
        {
            $retval .= '<br' . XHTML . '>';
        }
    }

    if( $_CONF['trackback_enabled'] && ( $_CONF['hidenewtrackbacks'] == 0 ))
    {
        $retval .= '<h3>' . $LANG01[114] . ' <small>'
                . COM_formatTimeString( $LANG_WHATSNEW['new_last'],
                                        $_CONF['newtrackbackinterval'] )
                . '</small></h3>';

        $sql['mysql'] = "SELECT DISTINCT COUNT(*) AS count,s.title,t.sid,max(t.date) AS lastdate 
            FROM {$_TABLES['trackback']} AS t, {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta 
            WHERE ta.type = 'article' AND ta.id = s.sid AND (t.type = 'article') AND (t.sid = s.sid) AND (t.date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newtrackbackinterval']} SECOND)))" . COM_getPermSQL('AND', 0, 2, 's') . " AND (s.draft_flag = 0) AND (s.trackbackcode = 0)" . $topicsql . COM_getLangSQL('sid', 'AND', 's') . " 
            GROUP BY t.sid, s.title 
            ORDER BY lastdate DESC LIMIT 15";
        
        $sql['mssql'] =  $sql['mysql'];
        
        $sql['pgsql'] = "SELECT DISTINCT COUNT(*) AS count,s.title,t.sid,max(t.date) AS lastdate 
            FROM {$_TABLES['trackback']} AS t, {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta  
            WHERE ta.type = 'article' AND ta.id = s.sid AND (t.type = 'article') AND (t.sid = s.sid) AND (t.date >= (NOW()+ INTERVAL '{$_CONF['newtrackbackinterval']} SECOND'))" . COM_getPermSQL('AND', 0, 2, 's') . " AND (s.draft_flag = 0) AND (s.trackbackcode = 0)" . $topicsql . COM_getLangSQL('sid', 'AND', 's') . " 
            GROUP BY t.sid, s.title 
            ORDER BY lastdate DESC LIMIT 15";
            
        $result = DB_query( $sql );

        $nrows = DB_numRows( $result );
        if( $nrows > 0 )
        {
            $newcomments = array();

            for( $i = 0; $i < $nrows; $i++ )
            {
                $A = DB_fetchArray( $result );

                $url = COM_buildUrl( $_CONF['site_url']
                    . '/article.php?story=' . $A['sid'] ) . '#trackback';

                $title = COM_undoSpecialChars( stripslashes( $A['title'] ));
                $titletouse = COM_truncate( $title, $_CONF['title_trim_length'],
                                            '...' );

                if( $title != $titletouse )
                {
                    $attr = array('title' => htmlspecialchars($title));
                }
                else
                {
                    $attr = array();
                }
                $acomment = str_replace( '$', '&#36;', $titletouse );
                $acomment = str_replace( ' ', '&nbsp;', $acomment );

                if( $A['count'] > 1 )
                {
                    $acomment .= ' [+' . $A['count'] . ']';
                }

                $newcomments[] = COM_createLink($acomment, $url, $attr);
            }

            $retval .= COM_makeList( $newcomments, 'list-new-trackbacks' );
        }
        else
        {
            $retval .= $LANG01[115] . '<br' . XHTML . '>' . LB;
        }
        if( $_CONF['hidenewplugins'] == 0 )
        {
            $retval .= '<br' . XHTML . '>';
        }
    }

    if( $_CONF['hidenewplugins'] == 0 )
    {
        list( $headlines, $smallheadlines, $content ) = PLG_getWhatsNew();
        $plugins = count( $headlines );
        if( $plugins > 0 )
        {
            for( $i = 0; $i < $plugins; $i++ )
            {
                $retval .= '<h3>' . $headlines[$i] . ' <small>'
                        . $smallheadlines[$i] . '</small></h3>';
                if( is_array( $content[$i] ))
                {
                    $retval .= COM_makeList( $content[$i], 'list-new-plugins' );
                }
                else
                {
                    $retval .= $content[$i];
                }

                if( $i + 1 < $plugins )
                {
                    $retval .= '<br' . XHTML . '>';
                }
            }
        }
    }

    $retval .= COM_endBlock( COM_getBlockTemplate( 'whats_new_block', 'footer', $position ));

    return $retval;
}

/**
* Creates the string that indicates the timespan in which new items were found
*
* @param    string  $time_string    template string
* @param    int     $time           number of seconds in which results are found
* @param    string  $type           type (translated string) of new item
* @param    int     $amount         amount of things that have been found.
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
    $time_description  = array('minute',  'hour',  'day',  'week',  'month',  'year');
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
* @param    string  $message    Message text; may contain HTML
* @param    string  $title      (optional) alternative block title
* @return   string              HTML block with message
* @see      COM_showMessage
* @see      COM_showMessageFromParameter
*
*/
function COM_showMessageText($message, $title = '')
{
    global $_CONF, $MESSAGE, $_IMAGE_TYPE;

    $retval = '';

    if (!empty($message)) {
        if (empty($title)) {
            $title = $MESSAGE[40];
        }
        $timestamp = strftime($_CONF['daytime']);
        $retval .= COM_startBlock($title . ' - ' . $timestamp, '',
                                  COM_getBlockTemplate('_msg_block', 'header'))
                . '<p class="sysmessage"><img src="' . $_CONF['layout_url']
                . '/images/sysmessage.' . $_IMAGE_TYPE . '" alt="" ' . XHTML
                . '>' . $message . '</p>'
                . COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
    }

    return $retval;
}

/**
* Displays a message on the webpage
*
* Display one of the predefined messages from the $MESSAGE array. If a plugin
* name is provided, display that plugin's message instead.
* 
* @param    int     $msg        ID of message to show
* @param    string  $plugin     Optional name of plugin to lookup plugin defined message
* @return   string              HTML block with message
* @see      COM_showMessageFromParameter
* @see      COM_showMessageText
*
*/
function COM_showMessage($msg, $plugin = '')
{
    global $MESSAGE;

    $retval = '';

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
        }

        if (!empty($message)) {
            $retval .= COM_showMessageText($message);
        }
    }

    return $retval;
}

/**
* Displays a message, as defined by URL parameters
*
* Helper function to display a message, if URL parameters 'msg' and 'plugin'
* (optional) are defined. Only for GET requests, but that's what Geeklog uses
* everywhere anyway.
*
* @return   string  HTML block with message
* @see      COM_showMessage
* @see      COM_showMessageText
*
*/
function COM_showMessageFromParameter()
{
    $retval = '';

    if (isset($_GET['msg'])) {
        $msg = COM_applyFilter($_GET['msg'], true);
        if ($msg > 0) {
            $plugin = '';
            if (isset($_GET['plugin'])) {
                $plugin = COM_applyFilter($_GET['plugin']);
            }
            $retval .= COM_showMessage($msg, $plugin);
        }
    }

    return $retval;
}

/**
* Prints Google(tm)-like paging navigation
*
* @param        string      $base_url       base url to use for all generated links. If an array, then the current parameter as the first part of the url, and the end is the last part of the url
* @param        int         $curpage        current page we are on
* @param        int         $num_pages      Total number of pages
* @param        string      $page_str       page-variable name AND '='
* @param        boolean     $do_rewrite     if true, url-rewriting is respected
* @param        string      $msg            to be displayed with the navigation
* @param        string      $open_ended     replace next/last links with this
* @return   string   HTML formatted widget
*/
function COM_printPageNavigation( $base_url, $curpage, $num_pages,
                                  $page_str='page=', $do_rewrite=false, $msg='',
                                  $open_ended = '')
{
    global $LANG05;

    $retval = '';
    $first_url = '';
    $last_url = '';    
    
    if (is_array($base_url)) {
        $first_url = current($base_url);
        $last_url = end($base_url);
    } else {
        $first_url = $base_url;
    }

    if( $num_pages < 2 )
    {
        return;
    }

    if( !$do_rewrite )
    {
        $hasargs = strstr( $first_url, '?' );
        if( $hasargs )
        {
            $sep = '&amp;';
        }
        else
        {
            $sep = '?';
        }
    }
    else
    {
        $sep = '/';
        $page_str = '';
    }

    if( $curpage > 1 )
    {
        $retval .= '<span>' . COM_createLink($LANG05[7], $first_url . $last_url ) . '</span> ' . ' | ';
         $pg = '';
         if( ( $curpage - 1 ) > 1 )
         {
             $pg = $sep . $page_str . ( $curpage - 1 );
         }
         $retval .= '<span>' . COM_createLink($LANG05[6], $first_url . $pg . $last_url ) . '</span> ' . ' | ';
     }
     else
     {
         $retval .= '<span>' . $LANG05[7] . '</span>' . ' | ';
         $retval .= '<span>' . $LANG05[6] . '</span>' . ' | ';
     }
 
    for( $pgcount = ( $curpage - 10 ); ( $pgcount <= ( $curpage + 9 )) AND ( $pgcount <= $num_pages ); $pgcount++ )
     {
         if( $pgcount <= 0 )
         {
             $pgcount = 1;
         }
 
        if( $pgcount == $curpage )
         {
             $retval .= '<span>' . $pgcount . '</span> ';
         }
         else
         {
             $pg = '';
             if( $pgcount > 1 )
             {
                 $pg = $sep . $page_str . $pgcount;
             }
             $retval .= COM_createLink($pgcount, $first_url . $pg . $last_url) . ' ';
         }
     }
 
    if( !empty( $open_ended ))
     {
         $retval .= '| ' . $open_ended;
     }
     else if( $curpage == $num_pages )
     {
         $retval .= '| ' . '<span>' . $LANG05[5] . '</span>' . ' ';
         $retval .= '| ' . '<span>' . $LANG05[8] . '</span>';
     }
     else
     {
         $retval .= '| ' . '<span>' . COM_createLink($LANG05[5], $first_url . $sep
                                          . $page_str . ($curpage + 1) . $last_url) . '</span> ';
         $retval .= ' | ' . '<span>' . COM_createLink($LANG05[8], $first_url . $sep
                                           . $page_str . $num_pages . $last_url) . '</span> ';
     }
 
    if( !empty( $retval ))
     {
         if( !empty( $msg ))
         {
             $msg .= ' ';
         }
         $retval = '<div class="gl-pagenav">' . $msg . $retval . '</div>';
     }

    return $retval;
}

/**
* Returns formatted date/time for user
*
* This function COM_takes a date in either unixtimestamp or in english and
* formats it to the users preference.  If the user didn't specify a format
* the format in the config file is used.  This returns an array where array[0]
* is the formatted date and array[1] is the unixtimestamp
*
* @param        string      $date       date to format, otherwise we format current date/time
* @return   array   array[0] is the formatted date and array[1] is the unixtimestamp.
*/

function COM_getUserDateTimeFormat( $date='' )
{
    global $_TABLES, $_USER, $_CONF;

    // Get display format for time

    if( !COM_isAnonUser() )
    {
        if( empty( $_USER['format'] ))
        {
            $dateformat = $_CONF['date'];
        }
        else
        {
            $dateformat = $_USER['format'];
        }
    }
    else
    {
        $dateformat = $_CONF['date'];
    }

    if( empty( $date ))
    {
        // Date is empty, get current date/time
        $stamp = time();
    }
    else if( is_numeric( $date ))
    {
        // This is a timestamp
        $stamp = $date;
    }
    else
    {
        // This is a string representation of a date/time
        $stamp = strtotime( $date );
    }

    // Format the date

    $date = strftime( $dateformat, $stamp );

    return array( $date, $stamp );
}

/**
* Returns user-defined cookie timeout
*
* In account preferences users can specify when their long-term cookie expires.
* This function returns that value.
*
* @return   int Cookie time out value in seconds
*/

function COM_getUserCookieTimeout()
{
    global $_TABLES, $_USER, $_CONF;

    if (COM_isAnonUser()) {
        return;
    }

    $timeoutvalue = DB_getItem( $_TABLES['users'], 'cookietimeout', "uid = {$_USER['uid']}" );

    if( empty( $timeoutvalue ))
    {
        $timeoutvalue = 0;
    }

    return $timeoutvalue;
}

/**
* Shows who is online in slick little block
* @return   string  HTML string of online users seperated by line breaks.
*/

function phpblock_whosonline()
{
    global $_CONF, $_TABLES, $LANG01, $_IMAGE_TYPE;

    $retval = '';

    $expire_time = time() - $_CONF['whosonline_threshold'];

    $byname = 'username';
    if( $_CONF['show_fullname'] == 1 )
    {
        $byname .= ',fullname';
    }
    if( $_CONF['user_login_method']['openid'] || $_CONF['user_login_method']['3rdparty'] )
    {
        $byname .= ',remoteusername,remoteservice';
    }

    $sql = "SELECT DISTINCT {$_TABLES['sessions']}.uid,{$byname},photo,showonline 
            FROM {$_TABLES['sessions']},{$_TABLES['users']},{$_TABLES['userprefs']} 
            WHERE {$_TABLES['users']}.uid = {$_TABLES['sessions']}.uid 
            AND {$_TABLES['sessions']}.whos_online = 1 
            AND {$_TABLES['users']}.uid = {$_TABLES['userprefs']}.uid AND start_time >= $expire_time 
            AND {$_TABLES['sessions']}.uid <> 1 ORDER BY {$byname}";
            
    $result = DB_query($sql);
    $nrows = DB_numRows( $result );

    $num_anon = 0;
    $num_reg  = 0;

    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );

        if( $A['showonline'] == 1 )
        {
            $fullname = '';
            if( $_CONF['show_fullname'] == 1 )
            {
                $fullname = $A['fullname'];
            }
            if( $_CONF['user_login_method']['openid'] || $_CONF['user_login_method']['3rdparty'] )
            {
                $username = COM_getDisplayName( $A['uid'], $A['username'],
                        $fullname, $A['remoteusername'], $A['remoteservice'] );
            }
            else
            {
                $username = COM_getDisplayName( $A['uid'], $A['username'],
                                                $fullname );
            }
            $url = $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['uid'];
            $retval .= COM_createLink($username, $url);

            if( !empty( $A['photo'] ) AND $_CONF['allow_user_photo'] == 1) {
                if ($_CONF['whosonline_photo'] == true) {
                    $usrimg = '<img src="' . $_CONF['site_url']
                            . '/images/userphotos/' . $A['photo']
                            . '" alt="" height="30" width="30"' . XHTML . '>';
                } else {
                    $usrimg = '<img src="' . $_CONF['layout_url']
                            . '/images/smallcamera.' . $_IMAGE_TYPE
                            . '" alt=""' . XHTML . '>';
                }
                        
                $retval .= '&nbsp;' . COM_createLink($usrimg, $url);
            }
            $retval .= '<br' . XHTML . '>';
            $num_reg++;
        }
        else
        {
            // this user does not want to show up in Who's Online
            $num_anon++; // count as anonymous
        }
    }

    $num_anon += DB_count($_TABLES['sessions'], array('uid', 'whos_online'), array(1, 1));

    if(( $_CONF['whosonline_anonymous'] == 1 ) &&
            COM_isAnonUser() )
    {
        // note that we're overwriting the contents of $retval here
        if( $num_reg > 0 )
        {
            $retval = $LANG01[112] . ': ' . COM_numberFormat($num_reg)
                    . '<br' . XHTML . '>';
        }
        else
        {
            $retval = '';
        }
    }

    if( $num_anon > 0 )
    {
        $retval .= $LANG01[41] . ': ' . COM_numberFormat($num_anon)
                . '<br' . XHTML . '>';
    }

    return $retval;
}

/**
* Gets the <option> values for calendar months
*
* @param        string      $selected       Selected month
* @see function COM_getDayFormOptions
* @see function COM_getYearFormOptions
* @see function COM_getHourFormOptions
* @see function COM_getMinuteFormOptions
* @return   string  HTML Months as option values
*/

function COM_getMonthFormOptions( $selected = '' )
{
    global $LANG_MONTH;

    $month_options = '';

    for( $i = 1; $i <= 12; $i++ )
    {
        $mval = $i;
        $month_options .= '<option value="' . $mval . '"';

        if( $i == $selected )
        {
            $month_options .= ' selected="selected"';
        }

        $month_options .= '>' . $LANG_MONTH[$mval] . '</option>';
    }

    return $month_options;
}

/**
* Gets the <option> values for calendar days
*
* @param        string      $selected       Selected day
* @see function COM_getMonthFormOptions
* @see function COM_getYearFormOptions
* @see function COM_getHourFormOptions
* @see function COM_getMinuteFormOptions
* @return string HTML days as option values
*/

function COM_getDayFormOptions( $selected = '' )
{
    $day_options = '';

    for( $i = 1; $i <= 31; $i++ )
    {
        if( $i < 10 )
        {
            $dval = '0' . $i;
        }
        else
        {
            $dval = $i;
        }

        $day_options .= '<option value="' . $dval . '"';

        if( $i == $selected )
        {
            $day_options .= ' selected="selected"';
        }

        $day_options .= '>' . $dval . '</option>';
    }

    return $day_options;
}

/**
* Gets the <option> values for calendar years
*
* Returns Option list Containing 5 years starting with current
* unless @selected is < current year then starts with @selected
*
* @param        string      $selected     Selected year
* @param        int         $startoffset  Optional (can be +/-) Used to determine start year for range of years
* @param        int         $endoffset    Optional (can be +/-) Used to determine end year for range of years
* @see function COM_getMonthFormOptions
* @see function COM_getDayFormOptions
* @see function COM_getHourFormOptions
* @see function COM_getMinuteFormOptions
* @return string  HTML years as option values
*/

function COM_getYearFormOptions($selected = '', $startoffset = -1, $endoffset = 5)
{
    $year_options = '';
    $start_year  = date('Y') + $startoffset;
    $cur_year    = date('Y', time());
    $finish_year = $cur_year + $endoffset;

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
* @param    string  $selected   Selected hour
* @param    int     $mode       12 or 24 hour mode
* @return   string              HTML string of options
* @see function COM_getMonthFormOptions
* @see function COM_getDayFormOptions
* @see function COM_getYearFormOptions
* @see function COM_getMinuteFormOptions
*/

function COM_getHourFormOptions( $selected = '', $mode = 12 )
{
    $hour_options = '';

    if( $mode == 12 )
    {
        for( $i = 1; $i <= 11; $i++ )
        {
            if( $i < 10 )
            {
                $hval = '0' . $i;
            }
            else
            {
                $hval = $i;
            }

            if( $i == 1 )
            {
                $hour_options .= '<option value="12"';

                if( $selected == 12 )
                {
                    $hour_options .= ' selected="selected"';
                }

                $hour_options .= '>12</option>';
            }

            $hour_options .= '<option value="' . $hval . '"';

            if( $selected == $i )
            {
                $hour_options .= ' selected="selected"';
            }

            $hour_options .= '>' . $i . '</option>';
        }
    }
    else // if( $mode == 24 )
    {
        for( $i = 0; $i < 24; $i++ )
        {
            if( $i < 10 )
            {
                $hval = '0' . $i;
            }
            else
            {
                $hval = $i;
            }

            $hour_options .= '<option value="' . $hval . '"';

            if( $selected == $i )
            {
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
* @param    string      $selected   Selected minutes
* @param    int         $step       number of minutes between options, e.g. 15
* @see function COM_getMonthFormOptions
* @see function COM_getDayFormOptions
* @see function COM_getHourFormOptions
* @see function COM_getYearFormOptions
* @return string  HTML of option minutes
*/

function COM_getMinuteFormOptions( $selected = '', $step = 1 )
{
    $minute_options = '';

    if(( $step < 1 ) || ( $step > 30 ))
    {
        $step = 1;
    }

    for( $i = 0; $i <= 59; $i += $step )
    {
        if( $i < 10 )
        {
            $mval = '0' . $i;
        }
        else
        {
            $mval = $i;
        }

        $minute_options .= '<option value="' . $mval . '"';

        if( $selected == $i )
        {
            $minute_options .= ' selected="selected"';
        }

        $minute_options .= '>' . $mval . '</option>';
    }

    return $minute_options;
}

/**
* For backward compatibility only.
* This function should always have been called COM_getMinuteFormOptions
* @see COM_getMinuteFormOptions
*/
function COM_getMinuteOptions( $selected = '', $step = 1 )
{
    return COM_getMinuteFormOptions( $selected, $step );
}

/**
* Create an am/pm selector dropdown menu
*
* @param    string  $name       name of the <select>
* @param    string  $selected   preselection: 'am' or 'pm'
* @return   string  HTML for the dropdown; empty string in 24 hour mode
*
*/
function COM_getAmPmFormSelection( $name, $selected = '' )
{
    global $_CONF;

    $retval = '';

    if( isset( $_CONF['hour_mode'] ) && ( $_CONF['hour_mode'] == 24 ))
    {
        $retval = '';
    }
    else
    {
        if( empty( $selected ))
        {
            $selected = date( 'a' );
        }

        $retval .= '<select name="' . $name . '">' . LB;
        $retval .= '<option value="am"';
        if( $selected == 'am' )
        {
            $retval .= ' selected="selected"';
        }
        $retval .= '>am</option>' . LB . '<option value="pm"';
        if( $selected == 'pm' )
        {
            $retval .= ' selected="selected"';
        }
        $retval .= '>pm</option>' . LB . '</select>' . LB;
    }

    return $retval;
}

/**
* Creates an HTML unordered list from the given array.
* It formats one list item per array element, using the list.thtml
* and listitem.thtml templates.
*
* @param    array   $listofitems    Items to list out
* @param    string  $classname      optional CSS class name for the list
* @return   string                  HTML unordered list of array items
*/
function COM_makeList($listofitems, $classname = '')
{
    global $_CONF;

    $list = COM_newTemplate($_CONF['path_layout']);
    $list->set_file(array('list'     => 'list.thtml',
                          'listitem' => 'listitem.thtml'));

    if (empty($classname)) {
        $list->set_var('list_class',      '');
        $list->set_var('list_class_name', '');
    } else {
        $list->set_var('list_class',      'class="' . $classname . '"');
        $list->set_var('list_class_name', $classname);
    }

    if (is_array($listofitems)) {
        foreach ($listofitems as $oneitem) {
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
* @param    string  $type       type of speed limit, e.g. 'submit', 'comment'
* @param    int     $max        max number of allowed tries within speed limit
* @param    string  $property   IP address or other identifiable property
* @return   int                 0: does not apply, else: seconds since last post
*/
function COM_checkSpeedlimit($type = 'submit', $max = 1, $property = '')
{
    global $_TABLES;

    $last = 0;

    if (empty($property)) {
        $property = $_SERVER['REMOTE_ADDR'];
    }
    $property = addslashes($property);

    $res  = DB_query("SELECT date FROM {$_TABLES['speedlimit']} WHERE (type = '$type') AND (ipaddress = '$property') ORDER BY date ASC");

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
* @param    string  $type       type of speed limit, e.g. 'submit', 'comment'
* @param    string  $property   IP address or other identifiable property
*
*/
function COM_updateSpeedlimit($type = 'submit', $property = '')
{
    global $_TABLES;

    if (empty($property)) {
        $property = $_SERVER['REMOTE_ADDR'];
    }
    $property = addslashes($property);

    DB_save($_TABLES['speedlimit'], 'ipaddress,date,type',
            "'$property',UNIX_TIMESTAMP(),'$type'");
}

/**
* Clear out expired speed limits, i.e. entries older than 'x' seconds
*
* @param speedlimit   int      number of seconds
* @param type         string   type of speed limit, e.g. 'submit', 'comment'
*
*/
function COM_clearSpeedlimit($speedlimit = 60, $type = '')
{
    global $_TABLES;

    $sql = "DELETE FROM {$_TABLES['speedlimit']} WHERE ";
    if (!empty($type)) {
        $sql .= "(type = '$type') AND ";
    }
    $sql .= "(date < UNIX_TIMESTAMP() - $speedlimit)";
    DB_query($sql);
}

/**
* Reset the speedlimit
*
* @param    string  $type       type of speed limit to reset, e.g. 'submit'
* @param    string  $property   IP address or other identifiable property
*
*/
function COM_resetSpeedlimit($type = 'submit', $property = '')
{
    global $_TABLES;

    if (empty($property)) {
        $property = $_SERVER['REMOTE_ADDR'];
    }
    $property = addslashes($property);

    DB_delete($_TABLES['speedlimit'], array('type', 'ipaddress'),
                                      array($type, $property));
}

/**
* Wrapper function for URL class so as to not confuse people as this will
* eventually get used all over the place
*
* This function returns a crawler friendly URL (if possible)
*
* @param    string      $url    URL to try to build crawler friendly URL for
* @return   string              Rewritten URL
*/

function COM_buildURL( $url )
{
    global $_URL;

    return $_URL->buildURL( $url );
}

/**
* Wrapper function for URL class so as to not confuse people
*
* This function sets the name of the arguments found in url
*
* @param    array   $names  Names of arguments in query string to assign to values
* @return   boolean         True if successful
*/

function COM_setArgNames( $names )
{
    global $_URL;

    return $_URL->setArgNames( $names );
}

/**
* Wrapper function for URL class
*
* returns value for specified argument
*
* @param        string      $name       argument to get value for
* @return   string     Argument value
*/

function COM_getArgument( $name )
{
    global $_URL;

    return $_URL->getArgument( $name );
}

/**
* Occurences / time
*
* This will take a number of occurrences, and number of seconds for the time span and return
* the smallest #/time interval
*
* @param    int     $occurrences        how many occurrences during time interval
* @param    int     $timespan           time interval in seconds
* @return   int Seconds per interval
*/

function COM_getRate( $occurrences, $timespan )
{
    // want to define some common time words (yes, dirk, i need to put this in LANG)
    // time words and their value in seconds
    // week is 7 * day, month is 30 * day, year is 365.25 * day

    $common_time = array(
        "second" => 1,
        "minute" => 60,
        "hour"   => 3600,
        "day"    => 86400,
        "week"   => 604800,
        "month"  => 2592000,
        "year"   => 31557600
        );

    if( $occurrences != 0 )
    {
        $rate = ( int )( $timespan / $occurrences );
        $adjustedRate = $occurrences + 1;
        $time_unit = 'second';

        $found_one = false;

        foreach( $common_time as $unit=>$seconds )
        {
            if( $rate > $seconds )
            {
                $foo = ( int )(( $rate / $seconds ) + .5 );

                if(( $foo < $occurrences ) && ( $foo > 0 ))
                {
                    $adjustedRate = $foo;
                    $time_unit = $unit;
                }
            }
        }

        $singular = '1 shout every ' . $adjustedRate . ' ' . $time_unit;

        if( $adjustedRate > 1 )
        {
            $singular .= 's';
        }
    }
    else
    {
        $singular = 'No events';
    }

    return $singular;
}

/**
* Check for Tag usuage permissions.
*
* This function takes the usuage access info of the autotag passed to it
* and let's us know if the user has access to use the autotag.
*
* @param        int     $owner_id       ID of the owner of object
* @param        int     $group_id       ID of group object belongs to
* @param        int     $perm_owner     Permissions the owner has
* @param        int     $perm_group     Permissions the gorup has
* @param        int     $perm_members   Permissions logged in members have
* @param        int     $perm_anon      Permissions anonymous users have
* @param        int     $uid            User ID to get information for. If empty current user.
* @return       int 	returns true if user has access
*
*/
function COM_getPermTag($owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon, $u_id = 0)
{
    global $_USER, $_GROUPS;

    $retval = false;
    $access = 2;
    
    if ($u_id <= 0) {
        if (COM_isAnonUser()) {
            $uid = 1;
        } else {
            $uid = $_USER['uid'];
        }
    } else {
        $uid = $u_id;
    }

    $UserGroups = array();
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
*
* Creates part of an SQL expression that can be used to request items with the
* standard set of Geeklog permissions.
*
* @param        string      $type     part of the SQL expr. e.g. 'WHERE', 'AND'
* @param        int         $u_id     user id or 0 = current user
* @param        int         $access   access to check for (2=read, 3=r&write)
* @param        string      $table    table name if ambiguous (e.g. in JOINs)
* @return       string      SQL expression string (may be empty)
*
*/
function COM_getPermSQL( $type = 'WHERE', $u_id = 0, $access = 2, $table = '' )
{
    global $_USER, $_GROUPS;

    if( !empty( $table ))
    {
        $table .= '.';
    }
    if( $u_id <= 0)
    {
        if( COM_isAnonUser() )
        {
            $uid = 1;
        }
        else
        {
            $uid = $_USER['uid'];
        }
    }
    else
    {
        $uid = $u_id;
    }

    $UserGroups = array();
    if(( empty( $_USER['uid'] ) && ( $uid == 1 )) || ( $uid == $_USER['uid'] ))
    {
        if( empty( $_GROUPS ))
        {
            $_GROUPS = SEC_getUserGroups( $uid );
        }
        $UserGroups = $_GROUPS;
    }
    else
    {
        $UserGroups = SEC_getUserGroups( $uid );
    }

    if( empty( $UserGroups ))
    {
        // this shouldn't really happen, but if it does, handle user
        // like an anonymous user
        $uid = 1;
    }

    if( SEC_inGroup( 'Root', $uid ))
    {
        return '';
    }

    $sql = ' ' . $type . ' (';

    if( $uid > 1 )
    {
        $sql .= "(({$table}owner_id = '{$uid}') AND ({$table}perm_owner >= $access)) OR ";

        $sql .= "(({$table}group_id IN (" . implode( ',', $UserGroups )
             . ")) AND ({$table}perm_group >= $access)) OR ";
        $sql .= "({$table}perm_members >= $access)";
    }
    else
    {
        $sql .= "{$table}perm_anon >= $access";
    }

    $sql .= ')';

    return $sql;
}

/**
* Return SQL expression to check for allowed topics.
*
* Creates part of an SQL expression that can be used to only request stories
* from topics to which the user has access to.
*
* Note that this function does an SQL request, so you should cache
* the resulting SQL expression if you need it more than once.
*
* @param    string  $type   part of the SQL expr. e.g. 'WHERE', 'AND'
* @param    int     $u_id   user id or 0 = current user
* @param    string  $table  table name if ambiguous (e.g. in JOINs)
* @return   string          SQL expression string (may be empty)
*
*/
function COM_getTopicSQL( $type = 'WHERE', $u_id = 0, $table = '' )
{
    global $_TABLES, $_USER, $_GROUPS;

    $topicsql = ' ' . $type . ' ';

    if( !empty( $table ))
    {
        $table .= '.';
    }

    $UserGroups = array();
    if(( $u_id <= 0 ) || ( isset( $_USER['uid'] ) && $u_id == $_USER['uid'] ))
    {
        if( !COM_isAnonUser() )
        {
            $uid = $_USER['uid'];
        }
        else
        {
            $uid = 1;
        }
        $UserGroups = $_GROUPS;
    }
    else
    {
        $uid = $u_id;
        $UserGroups = SEC_getUserGroups( $uid );
    }

    if( empty( $UserGroups ))
    {
        // this shouldn't really happen, but if it does, handle user
        // like an anonymous user
        $uid = 1;
    }

    if( SEC_inGroup( 'Root', $uid ))
    {
        return '';
    }

    $result = DB_query( "SELECT tid FROM {$_TABLES['topics']}"
                        . COM_getPermSQL( 'WHERE', $uid ));
    $tids = array();
    while( $T = DB_fetchArray( $result ))
    {
        $tids[] = $T['tid'];
    }

    if( count( $tids ) > 0 )
    {
        $topicsql .= "({$table}tid IN ('" . implode( "','", $tids ) . "'))";
    }
    else
    {
        $topicsql .= '0';
    }

    return $topicsql;
}

/**
* Strip slashes from a string only when magic_quotes_gpc = on.
*
* @param   string  $text  The text
* @return  string  The text, possibly without slashes.
*/
function COM_stripslashes($text)
{
    if (@get_magic_quotes_gpc()) {
        if (is_array($text)) {
            return(array_map('stripslashes', $text));
        } else {
            return(stripslashes($text));
        }
    }
    return($text);
}

/**
* Filter parameters passed per GET (URL) or POST.
*
* @param    string    $parameter   the parameter to test
* @param    boolean   $isnumeric   true if $parameter is supposed to be numeric
* @return   string    the filtered parameter (may now be empty or 0)
* @see COM_applyBasicFilter
*
*/
function COM_applyFilter( $parameter, $isnumeric = false )
{
    $p = COM_stripslashes($parameter);

    return COM_applyBasicFilter($p, $isnumeric);
}

/**
* Filter parameters
*
* NOTE:     Use this function instead of COM_applyFilter for parameters
*           _not_ coming in through a GET or POST request.
*
* @param    string    $parameter   the parameter to test
* @param    boolean   $isnumeric   true if $parameter is supposed to be numeric
* @return   string    the filtered parameter (may now be empty or 0)
* @see COM_applyFilter
*
*/
function COM_applyBasicFilter( $parameter, $isnumeric = false )
{
    $log_manipulation = false; // set to true to log when the filter applied

    $p = strip_tags( $parameter );
    $p = COM_killJS( $p ); // doesn't help a lot right now, but still ...

    if( $isnumeric )
    {
        // Note: PHP's is_numeric() accepts values like 4e4 as numeric
        if( !is_numeric( $p ) || ( preg_match( '/^-?\d+$/', $p ) == 0 ))
        {
            $p = 0;
        }
    }
    else
    {
        $p = preg_replace( '/\/\*.*/', '', $p );
        $pa = explode( "'", $p );
        $pa = explode( '"', $pa[0] );
        $pa = explode( '`', $pa[0] );
        $pa = explode( ';', $pa[0] );
        $pa = explode( ',', $pa[0] );
        $pa = explode( '\\', $pa[0] );
        $p = $pa[0];
    }

    if( $log_manipulation )
    {
        if( strcmp( $p, $parameter ) != 0 )
        {
            COM_errorLog( "Filter applied: >> $parameter << filtered to $p [IP {$_SERVER['REMOTE_ADDR']}]", 1);
        }
    }

    return $p;
}

/**
* Sanitize a URL
*
* @param    string  $url                URL to sanitized
* @param    array   $allowed_protocols  array of allowed protocols
* @param    string  $default_protocol   replacement protocol (default: http)
* @return   string                      sanitized URL
*
*/
function COM_sanitizeUrl( $url, $allowed_protocols = '', $default_protocol = '' )
{
    global $_CONF;

    if( empty( $allowed_protocols ))
    {
        $allowed_protocols = $_CONF['allowed_protocols'];
    }
    else if( !is_array( $allowed_protocols ))
    {
        $allowed_protocols = array( $allowed_protocols );
    }

    if( empty( $default_protocol ))
    {
        $default_protocol = 'http:';
    }
    else if( substr( $default_protocol, -1 ) != ':' )
    {
        $default_protocol .= ':';
    }

    $url = strip_tags( $url );
    if( !empty( $url ))
    {
        $pos = MBYTE_strpos( $url, ':' );
        if( $pos === false )
        {
            $url = $default_protocol . '//' . $url;
        }
        else
        {
            $protocol = MBYTE_substr( $url, 0, $pos + 1 );
            $found_it = false;
            foreach( $allowed_protocols as $allowed )
            {
                if( substr( $allowed, -1 ) != ':' )
                {
                    $allowed .= ':';
                }
                if( $protocol == $allowed )
                {
                    $found_it = true;
                    break;
                }
            }
            if( !$found_it )
            {
                $url = $default_protocol . MBYTE_substr( $url, $pos + 1 );
            }
        }
    }

    return $url;
}

/**
* Ensure an ID contains only alphanumeric characters, dots, dashes, or underscores
*
* @param    string  $id     the ID to sanitize
* @param    boolean $new_id true = create a new ID in case we end up with an empty string
* @return   string          the sanitized ID
*/
function COM_sanitizeID( $id, $new_id = true )
{
    $id = str_replace( ' ', '', $id );
    $id = str_replace( array( '/', '\\', ':', '+' ), '-', $id );
    $id = preg_replace( '/[^a-zA-Z0-9\-_\.]/', '', $id );
    if( empty( $id ) && $new_id )
    {
        $id = COM_makesid();
    }

    return $id;
}

/**
* Sanitize a filename.
*
* NOTE:     This function is pretty strict in what it allows. Meant to be used
*           for files to be included where part of the filename is dynamic.
*
* @param    string  $filename   the filename to clean up
* @param    boolean $allow_dots whether to allow dots in the filename or not
* @return   string              sanitized filename
*
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
* @param    string    $text     the (plain-ascii) text string
* @return   string    the same string, with links enclosed in <a>...</a> tags
*
*/
function COM_makeClickableLinks( $text )
{
    global $_CONF;

    if (! $_CONF['clickable_links']) {
        return $text;
    }

    // These regular expressions will work for this purpuse, but
    // they should NOT be used for validating links.

    // matches anything starting with http:// or https:// or ftp:// or ftps://
    $regex[] = '/(?<=^|[\n\r\t\s\(\)\[\]<>";])((?:(?:ht|f)tps?:\/{2})(?:[^\n\r\t\s\(\)\[\]<>"&]+(?:&amp;)?)+)(?=[\n\r\t\s\(\)\[\]<>"&]|$)/ei';
    $replace[] = "COM_makeClickableLinksCallback('', '\\1')";

    // matches anything containing a top level domain: xxx.com or xxx.yyy.net/stuff.php or xxx.yyy.zz
    // list taken from: http://en.wikipedia.org/wiki/List_of_Internet_TLDs
    $regex[] = '/(?<=^|[\n\r\t\s\(\)\[\]<>";])((?:[a-z0-9]+\.)*[a-z0-9]+\.(?:aero|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|[a-z]{2})(?:[\/?#](?:[^\n\r\t\s\(\)\[\]<>"&]+(?:&amp;)?)*)?)(?=[\n\r\t\s\(\)\[\]<>"&]|$)/ei';
    $replace[] = "COM_makeClickableLinksCallback('http://', '\\1')";

    $text = preg_replace( $regex, $replace, $text );

    return $text;
}

/**
* Callback function to help format links in COM_makeClickableLinks
*
* @param    string  $http   set to 'http://' when not already in the url
* @param    string  $link   the url
* @return   string          link enclosed in <a>...</a> tags
*
*/
function COM_makeClickableLinksCallback( $http, $link )
{
    global $_CONF;
    
    if ($_CONF['linktext_maxlen'] > 0) {
        $text = COM_truncate( $link, $_CONF['linktext_maxlen'], '...', '10' );
    } else {
        $text = $link;        
    }

    return "<a href=\"$http$link\">$text</a>";
}

/**
* Undo the conversion of URLs to clickable links (in plain text posts),
* e.g. so that we can present the user with the post as they entered them.
*
* @param    string  $text   story text
* @return   string          story text without links
*
*/
function COM_undoClickableLinks( $text )
{
    $text = preg_replace( '/<a href="([^"]*)">([^<]*)<\/a>/', '\1', $text );

    return $text;
}

/**
* Highlight the words from a search query in a given text string.
*
* @param    string  $text   the text
* @param    string  $query  the search query
* @param    string  $class  html class to use to highlight
* @return   string          the text with highlighted search words
*
*/
function COM_highlightQuery($text, $query, $class = 'highlight')
{
    if (!empty($text) && !empty($query)) {

        // escape PCRE special characters
        $query = preg_quote($query, '/');

        $mywords = explode(' ', $query);
        foreach ($mywords as $searchword) {
            if (!empty($searchword)) {
                $before = "/(?!(?:[^<]+>|[^>]+<\/a>))\b";
                $after = "\b/i";
                if ($searchword <> utf8_encode($searchword)) {
                    if (@preg_match('/^\pL$/u', urldecode('%C3%B1'))) {
                        // Unicode property support
                        $before = "/(?<!\p{L})";
                        $after = "(?!\p{L})/u";
                     } else {
                        $before = "/";
                        $after = "/u";
                     }
                }
                $text = preg_replace($before . $searchword . $after,
                                     "<span class=\"$class\">\\0</span>",
                                     '<!-- x -->' . $text . '<!-- x -->');
            }
        }
    }

    return $text;
}

/**
* Determines the difference between two dates.
*
* This will takes either unixtimestamps or English dates as input and will
* automatically do the date diff on the more recent of the two dates (e.g. the
* order of the two dates given doesn't matter).
*
* @author Tony Bibbs, tony DOT bibbs AT iowa DOT gov
* @access public
* @param string $interval Can be:
* y = year
* m = month
* w = week
* h = hours
* i = minutes
* s = seconds
* @param string|int $date1 English date (e.g. 10 Dec 2004) or unixtimestamp
* @param string|int $date2 English date (e.g. 10 Dec 2004) or unixtimestamp
* @return int Difference of the two dates in the unit of time indicated by the interval
*
*/
function COM_dateDiff( $interval, $date1, $date2 )
{
    // Convert dates to timestamps, if needed.
    if( !is_numeric( $date1 ))
    {
        $date1 = strtotime( $date1 );
    }

    if( !is_numeric( $date2 ))
    {
        $date2 = strtotime( $date2 );
    }

    // Function roughly equivalent to the ASP "DateDiff" function
    if( $date2 > $date1 )
    {
        $seconds = $date2 - $date1;
    }
    else
    {
        $seconds = $date1 - $date2;
    }

    switch( $interval )
    {
        case "y":
            list($year1, $month1, $day1) = split('-', date('Y-m-d', $date1));
            list($year2, $month2, $day2) = split('-', date('Y-m-d', $date2));
            $time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
            $time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
            $diff = $year2 - $year1;
            if($month1 > $month2) {
                $diff -= 1;
            } elseif($month1 == $month2) {
                if($day1 > $day2) {
                    $diff -= 1;
                } elseif($day1 == $day2) {
                    if($time1 > $time2) {
                        $diff -= 1;
                    }
                }
            }
            break;
        case "m":
            list($year1, $month1, $day1) = split('-', date('Y-m-d', $date1));
            list($year2, $month2, $day2) = split('-', date('Y-m-d', $date2));
            $time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
            $time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
            $diff = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
            if($day1 > $day2) {
                $diff -= 1;
            } elseif($day1 == $day2) {
                if($time1 > $time2) {
                    $diff -= 1;
                }
            }
            break;
        case "w":
            // Only simple seconds calculation needed from here on
            $diff = floor($seconds / 604800);
            break;
         case "d":
            $diff = floor($seconds / 86400);
            break;
        case "h":
            $diff = floor($seconds / 3600);
            break;
        case "i":
            $diff = floor($seconds / 60);
            break;
        case "s":
            $diff = $seconds;
            break;
    }

    return $diff;
}

/**
* Try to figure out our current URL, including all parameters.
*
* This is an ugly hack since there's no single variable that returns what
* we want and the variables used here may not be available on all servers
* and / or setups.
*
* Seems to work on Apache (1.3.x and 2.x), IIS, and Zeus ...
*
* @return   string  complete URL, e.g. 'http://www.example.com/blah.php?foo=bar'
*
*/
function COM_getCurrentURL()
{
    global $_CONF;

    $thisUrl = '';

    if( empty( $_SERVER['SCRIPT_URI'] ))
    {
        if( !empty( $_SERVER['DOCUMENT_URI'] ))
        {
            $thisUrl = $_SERVER['DOCUMENT_URI'];
        }
    }
    else
    {
        $thisUrl = $_SERVER['SCRIPT_URI'];
    }
    if( !empty( $thisUrl ) && !empty( $_SERVER['QUERY_STRING'] ))
    {
        $thisUrl .= '?' . $_SERVER['QUERY_STRING'];
    }
    if( empty( $thisUrl ))
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        if( empty( $_SERVER['REQUEST_URI'] ))
        {
            // on a Zeus webserver, prefer PATH_INFO over SCRIPT_NAME
            if( empty( $_SERVER['PATH_INFO'] ))
            {
                $requestUri = $_SERVER['SCRIPT_NAME'];
            }
            else
            {
                $requestUri = $_SERVER['PATH_INFO'];
            }
            if( !empty( $_SERVER['QUERY_STRING'] ))
            {
                $requestUri .= '?' . $_SERVER['QUERY_STRING'];
            }
        }

        $firstslash = strpos( $_CONF['site_url'], '/' );
        if( $firstslash === false )
        {
            // special case - assume it's okay
            $thisUrl = $_CONF['site_url'] . $requestUri;
        }
        else if( $firstslash + 1 == strrpos( $_CONF['site_url'], '/' ))
        {
            // site is in the document root
            $thisUrl = $_CONF['site_url'] . $requestUri;
        }
        else
        {
            // extract server name first
            $pos = strpos( $_CONF['site_url'], '/', $firstslash + 2 );
            $thisUrl = substr( $_CONF['site_url'], 0, $pos ) . $requestUri;
        }
    }

    return $thisUrl;
}

/**
* Check if we're on Geeklog's index page.
*
* See if we're on the main index page (first page, no topics selected).
*
* @return   boolean     true = we're on the frontpage, false = we're not
*
*/
function COM_onFrontpage()
{
    global $_CONF, $topic, $page, $newstories;

    // Note: We can't use $PHP_SELF here since the site may not be in the
    // DocumentRoot
    $onFrontpage = false;

    // on a Zeus webserver, prefer PATH_INFO over SCRIPT_NAME
    if (empty($_SERVER['PATH_INFO'])) {
        $scriptName = $_SERVER['SCRIPT_NAME'];
    } else {
        $scriptName = $_SERVER['PATH_INFO'];
    }

    preg_match('/\/\/[^\/]*(.*)/', $_CONF['site_url'], $pathonly);
    if (($scriptName == $pathonly[1] . '/index.php') &&
            empty($topic) && (empty($page) || ($page == 1)) && !$newstories) {
        $onFrontpage = true;
    }

    return $onFrontpage;
}

/**
* Check if we're on Geeklog's index page [deprecated]
*
* Note that this function returns FALSE when we're on the index page. Due to
* the inverted return values, it has been deprecated and is only provided for
* backward compatibility - use COM_onFrontpage() instead.
*
* @deprecated since Geeklog 1.4.1
* @see COM_onFrontpage
*
*/
function COM_isFrontpage()
{
    return !COM_onFrontpage();
}

/**
* Converts a number for output into a formatted number with thousands-
* separator, comma-separator and fixed decimals if necessary
*
* @param        float        $number        Number that will be formatted
* @return        string                        formatted number
*
*/
function COM_numberFormat( $number )
{
    global $_CONF;

    if( $number - floor( $number ) > 0 ) // number has decimals
    {
        $dc = $_CONF['decimal_count'];
    }
    else
    {
        $dc = 0;
    }
    $ts = $_CONF['thousand_separator'];
    $ds = $_CONF['decimal_separator'];

    return number_format( $number, $dc, $ds, $ts );
}

/**
* Convert a text based date YYYY-MM-DD to a unix timestamp integer value
*
* @param    string  $date   Date in the format YYYY-MM-DD
* @param    string  $time   Option time in the format HH:MM::SS
* @return   int             UNIX Timestamp
*/
function COM_convertDate2Timestamp( $date, $time = '' )
{
    $atoks = array();
    $btoks = array();

    // Breakup the string using either a space, fwd slash, dash, bkwd slash or
    // colon as a delimiter
    $atok = strtok( $date, ' /-\\:' );
    while( $atok !== FALSE )
    {
        $atoks[] = $atok;
        $atok = strtok( ' /-\\:' );  // get the next token
    }

    for( $i = 0; $i < 3; $i++ )
    {
        if( !isset( $atoks[$i] ) || !is_numeric( $atoks[$i] ))
        {
            $atoks[$i] = 0;
        }
    }

    if( $time == '' )
    {
        $timestamp = mktime( 0, 0, 0, $atoks[1], $atoks[2], $atoks[0] );
    }
    else
    {
        $btok = strtok( $time, ' /-\\:' );
        while( $btok !== FALSE )
        {
            $btoks[] = $btok;
            $btok = strtok( ' /-\\:' );
        }

        for( $i = 0; $i < 3; $i++ )
        {
            if( !isset( $btoks[$i] ) || !is_numeric( $btoks[$i] ))
            {
                $btoks[$i] = 0;
            }
        }

        $timestamp = mktime( $btoks[0], $btoks[1], $btoks[2],
                             $atoks[1], $atoks[2], $atoks[0] );
    }

    return $timestamp;
}

/**
* Get the HTML for an image with height & width
*
* @param    string  $file   full path to the file
* @return   string          html that will be included in the img-tag
*/
function COM_getImgSizeAttributes( $file )
{
    $sizeattributes = '';

    if( file_exists( $file ))
    {
        $dimensions = getimagesize( $file );
        if( !empty( $dimensions[0] ) AND !empty( $dimensions[1] ))
        {
            $sizeattributes = 'width="' . $dimensions[0]
                            . '" height="' . $dimensions[1] . '" ';
        }
    }

    return $sizeattributes;
}

/**
* Display a message and abort
*
* NOTE: Displays the message and aborts the script.
*
* @param    int     $msg            message number
* @param    string  $plugin         plugin name, if applicable
* @param    int     $http_status    HTTP status code to send with the message
* @param    string  $http_text      Textual version of the HTTP status code
*
*/
function COM_displayMessageAndAbort( $msg, $plugin = '', $http_status = 200, $http_text = 'OK')
{
    global $MESSAGE;

    $display = COM_showMessage( $msg, $plugin );
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30], 'rightblock' => true));

    if( $http_status != 200 )
    {
        header( "HTTP/1.1 $http_status $http_text" );
        header( "Status: $http_status $http_text" );
    }
    echo $display;
    exit;
}

/**
* Return full URL of a topic icon
*
* @param    string  $imageurl   (relative) topic icon URL
* @return   string              Full URL
*
*/
function COM_getTopicImageUrl( $imageurl )
{
    global $_CONF, $_THEME_URL;

    $iconurl = '';

    if( !empty( $imageurl ))
    {
        if( isset( $_THEME_URL ))
        {
            $iconurl = $_THEME_URL . $imageurl;
        }
        else
        {
            $stdImageLoc = true;
            if( !strstr( $_CONF['path_images'], $_CONF['path_html'] ))
            {
                $stdImageLoc = false;
            }

            if( $stdImageLoc )
            {
                $iconurl = $_CONF['site_url'] . $imageurl;
            }
            else
            {
                $t = explode( '/', $imageurl );
                $topicicon = $t[count( $t ) - 1];
                $iconurl = $_CONF['site_url']
                         . '/getimage.php?mode=topics&amp;image=' . $topicicon;
            }
        }
    }

    return $iconurl;
}

/**
 * Create an HTML link
 *
 * @param   string  $content    the object to be linked (text, image etc)
 * @param   string  $url        the URL the link will point to
 * @param   array   $attr       an array of optional attributes for the link
 *                              for example array('title' => 'whatever');
 * @return  string              the HTML link
 */
function COM_createLink($content, $url, $attr = array())
{
    $retval = '';

    $attr_str = 'href="' . $url . '"';
    foreach ($attr as $key => $value) {
        $attr_str .= " $key=\"$value\"";
    }
    $retval .= "<a $attr_str>$content</a>";

    return $retval;
}

/**
 * Create an HTML img
 *
 * @param   string  $url        the URL of the image, either starting with
 *                              http://... or $_CONF['layout_url'] is prepended
 * @param   string  $alt        the 'alt'-tag of the image
 * @param   array   $attr       an array of optional attributes for the link
 *                              for example array('title' => 'whatever');
 * @return  string              the HTML img
 */
function COM_createImage($url, $alt = "", $attr = array())
{
    global $_CONF;

    $retval = '';

    if (preg_match("/^(https?):/", $url) !== 1) {
        $url = $_CONF['layout_url'] . $url;
    }
    $attr_str = 'src="' . $url . '"';

    foreach ($attr as $key => $value) {
        $attr_str .= " $key=\"$value\"";
    }

    $retval = "<img $attr_str alt=\"$alt\"" . XHTML . ">";

    return $retval;
}

/**
* Try to determine the user's preferred language by looking at the
* "Accept-Language" header sent by their browser (assuming they bothered
* to select a preferred language there).
*
* Sample header: Accept-Language: en-us,en;q=0.7,de-de;q=0.3
*
* @return   string  name of the language file to use or an empty string
* @todo     Bugs: Does not take the quantity ('q') parameter into account,
*           but only looks at the order of language codes.
*
*/
function COM_getLanguageFromBrowser()
{
    global $_CONF;

    $retval = '';

    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
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
*
*/
function COM_getLanguage()
{
    global $_CONF, $_USER;

    $langfile = '';

    if (!empty($_USER['language'])) {
        $langfile = $_USER['language'];
    } elseif (!empty($_COOKIE[$_CONF['cookie_language']])) {
        $langfile = $_COOKIE[$_CONF['cookie_language']];
    } elseif (isset($_CONF['languages'])) {
        $langfile = COM_getLanguageFromBrowser();
    }

    $langfile = COM_sanitizeFilename($langfile);
    if (!empty($langfile)) {
        if (is_file($_CONF['path_language'] . $langfile . '.php')) {
            return $langfile;
        }
    }

    // if all else fails, return the default language
    return $_CONF['language'];
}

/**
* Determine the language of the object from the id
*
* @param    string  $id         id of object to retrieve language id from
* @return   string              language ID, e.g 'en'; empty string on error
*
*/
function COM_getLanguageIdForObject($id)
{
    global $_CONF;
    
    $lang_id = '';

    if (!empty($id)) {
        $loc = MBYTE_strrpos($id, '_');
        if ($loc > 0 && (($loc + 1) < MBYTE_strlen($id))) {
            $lang_id = MBYTE_substr($id, ($loc + 1));
            // Now check if language actually exists
            if (isset($_CONF['language_files'])) {
                if (array_key_exists($lang_id, $_CONF['language_files']) === false) {
                    // that looks like a misconfigured $_CONF['language_files'] array
                    COM_errorLog('Language "' . $language . '" not found in $_CONF[\'language_files\'] array!');
        
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
*
* The $_CONF['language_files'] array maps language IDs to language file names.
* This function returns the language ID for a certain language file, to be
* used in language-dependent URLs.
*
* @param    string  $language   current language file name (optional)
* @return   string              language ID, e.g 'en'; empty string on error
*
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
*
* Creates part of an SQL expression that can be used to request items in the
* current language only.
*
* @param    string  $field  name of the "id" field, e.g. 'sid' for stories
* @param    string  $type   part of the SQL expression, e.g. 'WHERE', 'AND'
* @param    string  $table  table name if ambiguous, e.g. in JOINs
* @return   string          SQL expression string (may be empty)
*
*/
function COM_getLangSQL( $field, $type = 'WHERE', $table = '' )
{
    global $_CONF;

    $sql = '';

    if( !empty( $_CONF['languages'] ) && !empty( $_CONF['language_files'] ))
    {
        if( !empty( $table ))
        {
            $table .= '.';
        }

        $lang_id = COM_getLanguageId();

        if( !empty( $lang_id ))
        {
            $sql = ' ' . $type . " ({$table}$field LIKE '%\\_$lang_id')";
        }
    }

    return $sql;
}

/**
* Provide a block to switch languages
*
* Provides a drop-down menu (or simple link, if you only have two languages)
* to switch languages. This can be used as a PHP block or called from within
* your theme's header.thtml:
* <code>
* <?php print phpblock_switch_language(); ?>
* </code>
*
* @return   string  HTML for drop-down or link to switch languages
*
*/
function phpblock_switch_language()
{
    global $_CONF;

    $retval = '';

    if( empty( $_CONF['languages'] ) || empty( $_CONF['language_files'] ) ||
          ( count( $_CONF['languages'] ) != count( $_CONF['language_files'] )))
    {
        return $retval;
    }

    $lang = COM_getLanguage();
    $langId = COM_getLanguageId( $lang );

    if( count( $_CONF['languages'] ) == 2 )
    {
        foreach( $_CONF['languages'] as $key => $value )
        {
            if( $key != $langId )
            {
                $newLang = $value;
                $newLangId = $key;
                break;
            }
        }

        $switchUrl = COM_buildUrl( $_CONF['site_url'] . '/switchlang.php?lang='
                                   . $newLangId );
        $retval .= COM_createLink($newLang, $switchUrl);
    }
    else
    {
        $retval .= '<form name="change" action="'. $_CONF['site_url']
                . '/switchlang.php" method="get">' . LB;
        $retval .= '<input type="hidden" name="oldlang" value="' . $langId
                . '"' . XHTML . '>' . LB;

        $retval .= '<select onchange="change.submit()" name="lang">';
        foreach( $_CONF['languages'] as $key => $value )
        {
            if( $lang == $_CONF['language_files'][$key] )
            {
                $selected = ' selected="selected"';
            }
            else
            {
                $selected = '';
            }
            $retval .= '<option value="' . $key . '"' . $selected . '>'
                    . $value . '</option>' . LB;
        }
        $retval .= '</select>' . LB;
        $retval .= '</form>' . LB;
    }

    return $retval;
}

/**
* Switch locale settings
*
* When multi-language support is enabled, allow overwriting the default locale
* settings with language-specific settings (date format, etc.). So in addition
* to $_CONF['date'] you can have a $_CONF['date_en'], $_CONF['date_de'], etc.
*
*/
function COM_switchLocaleSettings()
{
    global $_CONF;

    if( !empty( $_CONF['languages'] ) && !empty( $_CONF['language_files'] ))
    {
        $overridables = array
        (
          'locale',
          'date', 'daytime', 'shortdate', 'dateonly', 'timeonly',
          'week_start', 'hour_mode',
          'thousand_separator', 'decimal_separator'
        );

        $langId = COM_getLanguageId();
        foreach( $overridables as $option )
        {
            if( isset( $_CONF[$option . '_' . $langId] ))
            {
                $_CONF[$option] = $_CONF[$option . '_' . $langId];
            }
        }
    }
}

/**
* Get the name of the current language, minus the character set
*
* Strips the character set from $_CONF['language'].
*
* @return   string  language name
*
*/
function COM_getLanguageName()
{
    global $_CONF;

    $retval = '';

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
* @param    string  $noscript_message   Used instead of default message
* @param    string  $link_message       Secondary message that may contain a link
* @return   string                      noscript html tag with message(s)
*
*/
function COM_getNoScript($warning = true, $noscript_message = '', $link_message = '')
{
    global $_CONF, $LANG01;
    
    $noscript = COM_newTemplate($_CONF['path_layout']);
    $noscript->set_file(array('noscript' => 'noscript.thtml'));    
    
    if ($warning) {
        if (empty($noscript_message)) {
            $noscript_message =  $LANG01[136];
        }
    } else {
        if (empty($noscript_message)) {
            $noscript_message =  $LANG01[137];
        }
    }
    $noscript->set_var('lang_nojavascript', $noscript_message);
    
    if (!empty($link_message)) {
        $noscript->set_var('hide_link', '');
        $noscript->set_var('no_javascript_return_link', $link_message);
    } else {
        $noscript->set_var('hide_link', ' style="display:none;"');
        $noscript->set_var('no_javascript_return_link', '');
    }
    
    $retval =  $noscript->finish($noscript->parse('output', 'noscript'));
    return $retval;    
}

/**
* Returns an text/image that will display a tooltip
*
* This tooltip is based on an example from http://downloads.sixrevisions.com/css-tooltips/index.html
*
* @param    string  $hoverover  Text or image to display for the user to hover their mouse cursor over.
* @param    string  $text       Text for the actual tooltip. Can include HTML.
* @param    string  $link       Link for the tooltip. If passed, then the hoverover text becomes a link.
* @param    string  $title      Text for the tooltip title (if there is one). Can include HTML.
* @param    string  $template   Specify a different template to use (classic, critical, help, information, warning). 
* @param    string  $class      Specify a different tooltip class to use.
* @return   string              HTML tooltip
*
*/
function COM_getTooltip($hoverover = '', $text = '', $link = '', $title = '', $template = 'classic', $class = 'gl-tooltip') 
{
    global $_CONF, $_IMAGE_TYPE, $_SCRIPTS;
    
    if (! defined('TOOLTIPS_FIXED')) {
        define('TOOLTIPS_FIXED', true);
        $_SCRIPTS->setJavaScriptLibrary('jquery');
        $_SCRIPTS->setJavaScriptFile('fix_tooltips', '/javascript/fix_tooltips.js');
    }

    if ($hoverover == '') {
        $hoverover = '<img alt="?" id="gl-tooltip-icon" src="' . $_CONF['layout_url'] . '/tooltips/images/tooltip.' . $_IMAGE_TYPE . '"' . XHTML . '>';   
    }
    
    $tooltip = COM_newTemplate($_CONF['path_layout'] .'tooltips/');
    $tooltip->set_file(array('tooltip'    => $template . '.thtml'));    
    
    $tooltip->set_var('class', $class);
    $tooltip->set_var('hoverover', $hoverover);
    $tooltip->set_var('text', $text);
    $tooltip->set_var('title', $title);
    if ($link == '') {
        $link = 'javascript:void(0);';
        $cursor = 'help';
    } else {
        $cursor = 'pointer';
    }
    $tooltip->set_var('link', $link);
    $tooltip->set_var('cursor', $cursor);
    
    $retval =  $tooltip->finish($tooltip->parse('output', 'tooltip'));
    return $retval;
}


/**
* Truncate a string that contains HTML tags. Will close all HTML tags as needed.
*
* Truncates a string to a max. length and optionally adds a filler string,
* e.g. '...', to indicate the truncation.
* This function is multi-byte string aware. This function is based on a 
* code snippet by pitje at Snipplr.com.
*
* NOTE: The truncated string may be shorter or longer than $maxlen characters.
* Currently any initial html tags in the truncated string are taken into account.
* The $filler string is also taken into account but any html tags that are added 
* by this function to close open html tags are not. 
*
* @param    string  $htmltext   the text string which contains HTML tags to truncate
* @param    int     $maxlen     max. number of characters in the truncated string
* @param    string  $filler     optional filler string, e.g. '...'
* @param    int     $endchars   number of characters to show after the filler
* @return   string              truncated string
*
*/
function COM_truncateHTML ( $htmltext, $maxlen, $filler = '', $endchars = 0 )
{

    $newlen = $maxlen - MBYTE_strlen($filler);
    $len = MBYTE_strlen($htmltext);
    if ($len > $maxlen) {
        $htmltext = MBYTE_substr($htmltext, 0, $newlen - $endchars);

        // Strip any mangled tags off the end
        if (MBYTE_strrpos($htmltext, '<' ) > MBYTE_strrpos($htmltext, '>')) {
            $htmltext = MBYTE_substr($htmltext, 0, MBYTE_strrpos($htmltext, '<'));
        }        
        
        $htmltext = $htmltext . $filler . MBYTE_substr($htmltext, $len - $endchars, $endchars);
    
        // put all opened tags into an array
        preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $htmltext, $result );
        $openedtags = $result[1];
        $openedtags = array_diff($openedtags, array("img", "hr", "br"));
        $openedtags = array_values($openedtags);
    
        // put all closed tags into an array
        preg_match_all ("#</([a-z]+)>#iU", $htmltext, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        
        // all tags are closed
        if(count( $closedtags ) == $len_opened) {
            return $htmltext;
        }
        $openedtags = array_reverse ($openedtags);
    
        // close tags
        for($i = 0; $i < $len_opened; $i++) {
            if (!in_array ($openedtags[$i], $closedtags )) {
                $htmltext .= "</" . $openedtags[$i] . ">";
            } else {
                unset ($closedtags[array_search ($openedtags[$i], $closedtags)]);
            }
        }
    }

    return $htmltext;
}

/**
* Truncate a string
*
* Truncates a string to a max. length and optionally adds a filler string,
* e.g. '...', to indicate the truncation.
* This function is multi-byte string aware, based on a patch by Yusuke Sakata.
*
* NOTE: The truncated string may be shorter but will never be longer than
*       $maxlen characters, i.e. the $filler string is taken into account.
*
* @param    string  $text       the text string to truncate
* @param    int     $maxlen     max. number of characters in the truncated string
* @param    string  $filler     optional filler string, e.g. '...'
* @param    int     $endchars   number of characters to show after the filler
* @return   string              truncated string
*
*/
function COM_truncate( $text, $maxlen, $filler = '', $endchars = 0 )
{
    $newlen = $maxlen - MBYTE_strlen( $filler );
    if( $newlen <= 0 ) {
        $text = MBYTE_substr( $text, 0, $maxlen);
    }
    $len = MBYTE_strlen( $text );
    if( $len > $maxlen )
    {
        $startchars = $newlen - $endchars;
        if ($startchars < $endchars) {
            $text = MBYTE_substr( $text, 0, $newlen ) . $filler;
        } else {
            $text = MBYTE_substr( $text, 0, $newlen - $endchars ) . $filler . MBYTE_substr( $text, $len - $endchars, $endchars );
        }
    }

    return $text;
}

/**
* Get the current character set
*
* Uses (if available, and in this order)
* - $LANG_CHARSET (from the current language file)
* - $_CONF['default_charset'] (from siteconfig.php)
* - 'iso-8859-1' (hard-coded fallback)
*
* @return   string      character set, e.g. 'utf-8'
*
*/
function COM_getCharset()
{
    global $_CONF, $LANG_CHARSET;

    if( empty( $LANG_CHARSET )) {
        $charset = $_CONF['default_charset'];
        if( empty( $charset )) {
            $charset = 'iso-8859-1';
        }
    } else {
        $charset = $LANG_CHARSET;
    }

    return $charset;
}

/**
  * Handle errors.
  *
  * This function will handle all PHP errors thrown at it, without exposing
  * paths, and hopefully, providing much more information to Root Users than
  * the default white error page.
  *
  * This function will call out to CUSTOM_handleError if it exists, but, be
  * advised, only override this function with a very, very stable function. I'd
  * suggest one that outputs some static, basic HTML.
  *
  * The PHP feature that allows us to do so is documented here:
  * http://uk2.php.net/manual/en/function.set-error-handler.php
  *
  * @param  int     $errno      Error Number.
  * @param  string  $errstr     Error Message.
  * @param  string  $errfile    The file the error was raised in.
  * @param  int     $errline    The line of the file that the error was raised at.
  * @param  array   $errcontext An array that points to the active symbol table at the point the error occurred.
  */
function COM_handleError($errno, $errstr, $errfile='', $errline=0, $errcontext='')
{
    global $_CONF, $_USER;

    // Handle @ operator
    if (error_reporting() == 0) {
        return;
    }

    /*
     * If we have a root user, then output detailed error message:
     */
    if ((is_array($_USER) && function_exists('SEC_inGroup'))
            || (isset($_CONF['rootdebug']) && $_CONF['rootdebug'])) {
        if ($_CONF['rootdebug'] || SEC_inGroup('Root')) {

            header('HTTP/1.1 500 Internal Server Error');
            header('Status: 500 Internal Server Error');

            $title = 'An Error Occurred';
            if (!empty($_CONF['site_name'])) {
                $title = $_CONF['site_name'] . ' - ' . $title;
            }
            echo "<html><head><title>$title</title></head>\n<body>\n";

            echo '<h1>An error has occurred:</h1>';
            if ($_CONF['rootdebug']) {
                echo '<h2 style="color: red">This is being displayed as "Root Debugging" is enabled
                        in your Geeklog configuration.</h2><p>If this is a production
                        website you <strong><em>must disable</em></strong> this
                        option once you have resolved any issues you are
                        investigating.</p>';
            } else {
                echo '<p>(This text is only displayed to users in the group \'Root\')</p>';
            }
            echo "<p>$errno - $errstr @ $errfile line $errline</p>";

            if (!function_exists('SEC_inGroup') || !SEC_inGroup('Root')) {
                if ('force' != ''.$_CONF['rootdebug']) {
                    $errcontext = COM_rootDebugClean($errcontext);
                } else {
                    echo '<h2 style="color: red">Root Debug is set to "force", this
                    means that passwords and session cookies are exposed in this
                    message!!!</h2>';
                }
            }
            if (@ini_get('xdebug.default_enable') == 1) {
                ob_start();
                var_dump($errcontext);
                $errcontext = ob_get_contents();
                ob_end_clean();
                echo "$errcontext</body></html>";
            } else {
                $btr = debug_backtrace();
                if (count($btr) > 0) {
                    if ($btr[0]['function'] == 'COM_handleError') {
                        array_shift($btr);
                    }
                }
                if (count($btr) > 0) {
                    echo "<font size='1'><table class='xdebug-error' dir='ltr' border='1' cellspacing='0' cellpadding='1'>\n";
                    echo "<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>\n";
                    echo "<tr><th align='right' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>File</th><th align='right' bgcolor='#eeeeec'>Line</th></tr>\n";
                    $i = 1;
                    foreach ($btr as $b) {
                        $f = '';
                        if (! empty($b['file'])) {
                            $f = $b['file'];
                        }
                        $l = '';
                        if (! empty($b['line'])) {
                            $l = $b['line'];
                        }
                        echo "<tr><td bgcolor='#eeeeec' align='right'>$i</td><td bgcolor='#eeeeec'>{$b['function']}</td><td bgcolor='#eeeeec'>{$f}</td><td bgcolor='#eeeeec' align='right'>{$l}</td></tr>\n";
                        $i++;
                        if ($i > 100) {
                            echo "<tr><td bgcolor='#eeeeec' align='left' colspan='4'>Possible recursion - aborting.</td></tr>\n";
                            break;
                        }
                    }
                    echo "</table></font>\n";
                }
                echo '<pre>';
                ob_start();
                var_dump($errcontext);
                $errcontext = htmlspecialchars(ob_get_contents());
                ob_end_clean();
                echo "$errcontext</pre></body></html>";
            }
            exit;
        }
    }

    /* If there is a custom error handler, fail over to that, but only
     * if the error wasn't in lib-custom.php
     */
    if (is_array($_CONF) && !(strstr($errfile, 'lib-custom.php'))) {
        if (array_key_exists('path_system', $_CONF)) {
            if (file_exists($_CONF['path_system'] . 'lib-custom.php')) {
                require_once $_CONF['path_system'] . 'lib-custom.php';
            }
            if (function_exists('CUSTOM_handleError')) {
                CUSTOM_handleError($errno, $errstr, $errfile, $errline, $errcontext);
                exit;
            }
        }
    }

    // if we do not throw the error back to an admin, still log it in the error.log
    COM_errorLog("$errno - $errstr @ $errfile line $errline", 1);

    header('HTTP/1.1 500 Internal Server Error');
    header('Status: 500 Internal Server Error');

    // Does the theme implement an error message html file?
    if (!empty($_CONF['path_layout']) &&
            file_exists($_CONF['path_layout'] . 'errormessage.html')) {
        // NOTE: NOT A TEMPLATE! JUST HTML!
        include $_CONF['path_layout'] . 'errormessage.html';
    } else {
        // Otherwise, display simple error message
        $title = 'An Error Occurred';
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
            Unfortunately, an error has occurred rendering this page. Please try
            again later.
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
  *
  * [Not fit for public consumption comments about what users who enable root
  * debug in production should have done to them, and why making this change
  * defeats the point of the entire root debug feature go here.]
  *
  * @param  array    $array  Array of state info (Recursive array).
  * @param  boolean  $blank  override (wouldn't that blank out everything?)
  * @return array            Cleaned array
  */
function COM_rootDebugClean($array, $blank=false)
{
    $blankField = false;
    while(list($key, $value) = each($array)) {
        $lkey = strtolower($key);
        if((strpos($lkey, 'pass') !== false) || (strpos($lkey, 'cookie') !== false) || (strpos($lkey, '_consumer_key') !== false) || (strpos($lkey, '_consumer_secret') !== false)) {
            $blankField = true;
        } else {
            $blankField = $blank;
        }
        if(is_array($value)) {
            $array[$key] = COM_rootDebugClean($value, $blankField);
        } elseif($blankField) {
            $array[$key] = '[VALUE REMOVED]';
        }
    }
    return $array;
}

/**
  * Checks to see if a specified user, or the current user if non-specified
  * is the anonymous user.
  *
  * @param  int $uid    ID of the user to check, or none for the current user.
  * @return boolean     true if the user is the anonymous user.
  */
function COM_isAnonUser($uid = '')
{
    global $_USER;

    /* If no user was specified, fail over to the current user if there is one */
    if( empty( $uid ) )
    {
        if( isset( $_USER['uid'] ) )
        {
            $uid = $_USER['uid'];
        }
    }

    if( !empty( $uid ) )
    {
        return ($uid == 1);
    } else {
        return true;
    }
}

/**
* Create Meta Tags to be used by COM_siteHeader in the headercode variable
*
* @param    string  $meta_description   the text for the meta description of the page being displayed
* @param    string  $meta_keywords        the text for the meta keywords of the page being displayed
* @return   string                         XHTML formatted text
*
*/
function COM_createMetaTags($meta_description, $meta_keywords)
{
    global $_CONF;

    $headercode ='';

    if ($_CONF['meta_tags'] > 0) {
        if ($meta_description != '') {
            $headercode .= LB . '<meta name="description" content="' . str_replace(array("\015", "\012"), '', strip_tags($meta_description)) . '"' . XHTML . '>';
        }
        if ($meta_keywords != '') {
            $headercode .= LB . '<meta name="keywords" content="' . str_replace(array("\015", "\012"), '', strip_tags($meta_keywords)) . '"' . XHTML . '>';
        }
    }    

    return $headercode;
}



/**
* Convert wiki-formatted text to (X)HTML
*
* @param    string  $wikitext   wiki-formatted text
* @return   string              XHTML formatted text
*
*/
function COM_renderWikiText($wikitext)
{
    global $_CONF;

    if (!$_CONF['wikitext_editor']) {
        return $wikitext;
    }

    require_once 'Text/Wiki.php';

    $wiki = new Text_Wiki();
    $wiki->setFormatConf('Xhtml', 'translate', HTML_SPECIALCHARS);
    $wiki->setRenderConf('Xhtml', 'charset', COM_getCharset());
    $wiki->disableRule('wikilink');
    $wiki->disableRule('freelink');
    $wiki->disableRule('interwiki');

    return $wiki->transform($wikitext, 'Xhtml');
}

/**
* Set the {lang_id} and {lang_attribute} variables for a template
*
* NOTE:     {lang_attribute} is only set in multi-language environments.
*
* @param    ref     &$template  template to use
* @return   void
*
*/
function COM_setLangIdAndAttribute(&$template)
{
    global $_CONF;

    $langAttr = '';
    $langId   = '';

    if (!empty($_CONF['languages']) && !empty($_CONF['language_files'])) {
        $langId = COM_getLanguageId();
    } else {
        // try to derive the language id from the locale
        $l = explode('.', $_CONF['locale']); // get rid of character set
        $langId = $l[0];
        $l = explode('@', $langId); // get rid of '@euro', etc.
        $langId = $l[0];
    }

    if (!empty($langId)) {
        $l = explode('-', str_replace('_', '-', $langId));
        if ((count($l) == 1) && (strlen($langId) == 2)) {
            $langAttr = 'lang="' . $langId . '"';
        } else if (count($l) == 2) {
            if (($l[0] == 'i') || ($l[0] == 'x')) {
                $langId = implode('-', $l);
                $langAttr = 'lang="' . $langId . '"';
            } else if (strlen($l[0]) == 2) {
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
        $template->set_var('lang_attribute', '');
    }
}

/**
* Sends compressed output to browser.
*
* Assumes that $display contains the _entire_ output for a request - no
* echoes are allowed before or after this function.
* Currently only supports gzip compression. Checks if zlib compression is
* enabled in PHP and does uncompressed output if it is.
*
* @param    string  $display    Content to send to browser
* @return   void
*
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
            if (empty($zlib_comp) || (strcasecmp($zlib_comp, 'off') == 0)) {

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
*
* This function removes HTML tags, line breaks, etc. and returns one long
* line of text. This is useful for word counts (do an explode() on the result)
* and for text excerpts.
*
* @param    string  $text   original text, including HTML and line breaks
* @return   string          continuous plain text
* 
*/
function COM_getTextContent($text)
{
    // replace <br> with spaces so that Text<br>Text becomes two words
    $text = preg_replace('/\<br(\s*)?\/?\>/i', ' ', $text);

    // add extra space between tags, e.g. <p>Text</p><p>Text</p>
    $text = str_replace('><', '> <', $text);

    // only now remove all HTML tags
    $text = strip_tags($text);

    // replace all tabs, newlines, and carrriage returns with spaces
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
* @param    string  $version        Geeklog version number
* @return   string                  Generic version number that can be correctly handled by PHP
*
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
        $b  = strpos($version, 'b');
        $rc = strpos($version, 'rc');
        $sr = strpos($version, 'sr');
        if ($b && $b<$dash) {
            $pos = $b;
        } else if ($rc && $rc<$dash) {
            $pos = $rc;
        } else if ($sr && $sr<$dash) {
            $pos = $sr;
        } else {
            // Version is correctly formatted
            $rearrange = false;
        }
        // Rearrange the version number, if needed
        if ($rearrange) {
            $ver = substr($version, 0, $pos);
            $cod = substr($version, $pos, $dash-$pos);
            $bug = substr($version, $dash+1);
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
    } else if (strpos($version, 'rc') !== false) {
        $version = str_replace('rc', $bugfix . '.2.', $version);
    } else if (strpos($version, 'sr') !== false) {
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
* @param    string  $version1       First version number to be compared
* @param    string  $version2       Second version number to be sompared
* @param    string  $operator       optional string to define how the two versions are to be compared
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
*
* This is a (very) simple check to see if the user already ran the install
* script. If not, abort and display a nice(r) welcome screen with handy links
* to the install script and instructions. Inspired by MediaWiki ...
*
*/
function COM_checkInstalled()
{
    global $_CONF;

    $not_installed = false;

    // this is the only thing we check for now ...
    if (empty($_CONF) || !isset($_CONF['path']) ||
            ($_CONF['path'] == '/path/to/Geeklog/')) {
        $not_installed = true;
    }

    if ($not_installed) {
        $rel = '';
        $cd = getcwd();
        if (! file_exists($cd . '/admin/install/index.php')) {
            // this should cover most (though not all) cases
            $rel = '../';
        }

        $display =
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Welcome to Geeklog</title>
<meta name="robots" content="noindex,nofollow" />
<style type="text/css">
  html, body {
    color:#000;
    background-color:#fff;
    font-family:sans-serif;
    text-align:center;
  }
</style>
</head>

<body>
<img src="' . $rel . 'docs/images/newlogo.gif" alt="" />

<h1>Geeklog ' . VERSION . '</h1>
<p>Please run the <a href="' . $rel . 'admin/install/index.php" rel="nofollow">install script</a> first.</p>
<p>For more information, please refer to the <a href="' . $rel . 'docs/english/install.html" rel="nofollow">installation instructions</a>.</p>
</body>
</html>
';

        header("HTTP/1.1 503 Service Unavailable");
        header("Status: 503 Service Unavailable");
        header('Content-Type: text/html; charset=' . $_CONF['default_charset']);
        die($display);
    }
}

/**
* Provide support for drop-in replacable template engines
*
* @param    string  $root    Path to template root
* @param    array   $options List of options to pass to constructor
* @return   object           An ITemplate derved object
*/
function COM_newTemplate($root, $options = Array())
{
    global $_CONF;

    if (function_exists('OVERRIDE_newTemplate')) {
        if (is_string($options)) $options = Array('unknowns', $options);
        $T = OVERRIDE_newTemplate($root, $options);
    } else $T = null;
    if (!is_object($T)) {
        if (is_array($options) && array_key_exists('unknowns', $options)) $options = $options['unknowns'];
        else $options = 'remove';
        $T = new Template($root, $options);
    }
    $T->set_var('xhtml', XHTML);
    $T->set_var('site_url', $_CONF['site_url']);
    $T->set_var('site_admin_url', $_CONF['site_admin_url']);
    $T->set_var('layout_url', $_CONF['layout_url']);
    return $T;
}

/**
* Now include all plugin functions
*/
foreach ($_PLUGINS as $pi_name) {
    require_once $_CONF['path'] . 'plugins/' . $pi_name . '/functions.inc';
}

// Check and see if any plugins (or custom functions)
// have scheduled tasks to perform
if ($_CONF['cron_schedule_interval'] > 0) {
    if ((DB_getItem($_TABLES['vars'], 'value', "name='last_scheduled_run'")
            + $_CONF['cron_schedule_interval']) <= time()) {
        DB_query("UPDATE {$_TABLES['vars']} SET value=UNIX_TIMESTAMP() WHERE name='last_scheduled_run'");
        PLG_runScheduledTask();
    }
}

?>
