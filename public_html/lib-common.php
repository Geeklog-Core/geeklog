<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-common.php                                                            |
// |                                                                           |
// | Geeklog common library.                                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
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
//
// $Id: lib-common.php,v 1.491 2005/11/07 09:15:12 dhaun Exp $

// Prevent PHP from reporting uninitialized variables
error_reporting( E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR );

/**
* This is the common library for Geeklog.  Through our code, you will see
* functions with the COM_ prefix (e.g. COM_siteHeader()).  Any such functions
* can be found in this file.  This file provides all configuration variables
* needed by Geeklog with a series of includes (see futher down).
*
* --- You only need to modify one line in this file! ---
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
* Configuration Include: You should ONLY have to modify this line.
* Leave the rest of this file intact!
*
* Make sure to include the name of the config file,
* i.e. the path should end in .../config.php
*/
require_once( '/path/to/geeklog/config.php' );


// Before we do anything else, check to ensure site is enabled

if( isset( $_CONF['site_enabled'] ) && !$_CONF['site_enabled'] )
{
    if( empty( $_CONF['site_disabled_msg'] ))
    {
        echo $_CONF['site_name'] . ' is temporarily down.  Please check back soon';
    }
    else
    {
        // if the msg starts with http: assume it's a URL we should redirect to
        if( preg_match( "/^(https?):/", $_CONF['site_disabled_msg'] ) === 1 )
        {
            echo COM_refresh( $_CONF['site_disabled_msg'] );
        }
        else
        {
            echo $_CONF['site_disabled_msg'];
        }
    }

    exit;
}

// this file can't be used on its own - redirect to index.php
if( eregi( 'lib-common.php', $_SERVER['PHP_SELF'] ))
{
    echo COM_refresh( $_CONF['site_url'] . '/index.php' );
    exit;
}

// timezone hack - set the webserver's timezone
if( !empty( $_CONF['timezone'] ) && !ini_get( 'safe_mode' ) &&
        function_exists( 'putenv' )) {
    putenv( 'TZ=' . $_CONF['timezone'] );
}


// +---------------------------------------------------------------------------+
// | Library Includes: You shouldn't have to touch anything below here         |
// +---------------------------------------------------------------------------+

/**
* If needed, add our PEAR path to the list of include paths
*
*/
if( !$_CONF['have_pear'] )
{
    $curPHPIncludePath = ini_get( 'include_path' );
    if( defined( 'PATH_SEPARATOR' ))
    {
        $separator = PATH_SEPARATOR;
    }
    else
    {
        // prior to PHP 4.3.0, we have to guess the correct separator ...
        $separator = ';';
        if( strpos( $curPHPIncludePath, $separator ) === false )
        {
            $separator = ':';
        }
    }
    if( ini_set( 'include_path', $_CONF['path_pear'] . $separator
                                 . $curPHPIncludePath ) === false )
    {
        COM_errorLog( 'ini_set failed - there may be problems using the PEAR classes.', 1);
    }
}


/**
* This is necessary to ensure compatibility with PHP 4.1.x
*
*/
if( !function_exists( 'is_a' ))
{
    require_once( 'PHP/Compat.php' );

    PHP_Compat::loadFunction( 'is_a' );
}


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
* Please note this code is still experimental and is only currently used by the
* staticpages plugin.
*/

require_once( $_CONF['path_system'] . 'classes/url.class.php' );
$_URL = new url( $_CONF['url_rewrite'] );

/**
* This is our HTML template class.  It is the same one found in PHPLib and is
* licensed under the LGPL.  See that file for details
*
*/

require_once( $_CONF['path_system'] . 'classes/template.class.php' );

/**
* This is the database library.
*
* Including this gives you a working connection to the database
*
*/

require_once( $_CONF['path_system'] . 'lib-database.php' );

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
* This is the custom library.
*
* It is the sandbox for every Geeklog Admin to play in.
* We will never modify this file.  This should hold all custom
* hacks to make upgrading easier.
*
*/

require_once( $_CONF['path_system'] . 'lib-custom.php' );

/**
* Include plugin class.
* This is a poorly implemented class that was not very well thought out.
* Still very necessary
*
*/

require_once( $_CONF['path_system'] . 'lib-plugins.php' );

/**
* Session management library
*
*/

require_once( $_CONF['path_system'] . 'lib-sessions.php' );

/**
* Include admin functions library
*
*/

require_once( $_CONF['path_system'] . 'lib-admin.php' );

/**
* Ulf Harnhammar's kses class
*
*/

require_once( $_CONF['path_system'] . 'classes/kses.class.php' );


// Set theme
// Need to modify this code to check if theme was cached in user cookie.  That
// way if user logged in and set theme and then logged out we would still know
// which theme to show them.

if( !empty( $_POST['usetheme'] ) && is_dir( $_CONF['path_themes']
        . $_POST['usetheme'] ))
{
    $_CONF['theme'] = $_POST['usetheme'];
    $_CONF['path_layout'] = $_CONF['path_themes'] . $_CONF['theme'] . '/';
    $_CONF['layout_url'] = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
}
else if( $_CONF['allow_user_themes'] == 1 )
{
    if( isset( $_COOKIE[$_CONF['cookie_theme']]) && empty($_USER['theme'] ))
    {
        if( is_dir( $_CONF['path_themes'] . $_COOKIE[$_CONF['cookie_theme']] ))
        {
            $_USER['theme'] = $_COOKIE[$_CONF['cookie_theme']];
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
* Include theme functions file
*/

// Include theme functions file which may/may not do anything

if( file_exists( $_CONF['path_layout'] . 'functions.php' ))
{
    require_once( $_CONF['path_layout'] . 'functions.php' );
}

// themes can now specify the default image type
// fall back to 'gif' if they don't

if( empty( $_IMAGE_TYPE ))
{
    $_IMAGE_TYPE = 'gif';
}

// Similarly set language

if( isset( $_COOKIE[$_CONF['cookie_language']]) && empty( $_USER['language'] ))
{
    if( is_file( $_CONF['path_language'] . $_COOKIE[$_CONF['cookie_language']] . '.php' ))
    {
        $_USER['language'] = $_COOKIE[$_CONF['cookie_language']];
        $_CONF['language'] = $_COOKIE[$_CONF['cookie_language']];
    }
}
else if( !empty( $_USER['language'] ))
{
    if( is_file( $_CONF['path_language'] . $_USER['language'] . '.php' ))
    {
        $_CONF['language'] = $_USER['language'];
    }
}

// Handle Who's Online block
if( empty( $_USER['uid'] ) OR $_USER['uid'] == 1 )
{
    // The following code handles anonymous users so they show up properly
    DB_query( "DELETE FROM {$_TABLES['sessions']} WHERE remote_ip = '{$_SERVER['REMOTE_ADDR']}' AND uid = 1" );

    $tries = 0;
    do
    {
        // Build a useless sess_id (needed for insert to work properly)
        mt_srand(( double )microtime() * 1000000 );
        $sess_id = mt_rand();
        $curtime = time();

        // Insert anonymous user session
        $result = DB_query( "INSERT INTO {$_TABLES['sessions']} (sess_id, start_time, remote_ip, uid) VALUES ($sess_id, $curtime, '{$_SERVER['REMOTE_ADDR']}', 1)", 1 );
        $tries++;
    }
    while(( $result === false) && ( $tries < 5 ));
}

// Clear out any expired sessions
DB_query( "DELETE FROM {$_TABLES['sessions']} WHERE uid = 1 AND start_time < " . ( time() - $_CONF['whosonline_threshold'] ));

/**
*
* Language include
*
*/

require_once( $_CONF['path_language'] . $_CONF['language'] . '.php' );

if( setlocale( LC_ALL, $_CONF['locale'] ) === false )
{
    setlocale( LC_TIME, $_CONF['locale'] );
}

/**
* Global array of groups current user belongs to
*
* @global array $_GROUPS
*
*/

$_GROUPS = SEC_getUserGroups( $_USER['uid'] );

/**
* Global array of current user permissions [read,edit]
*
* @global array $_RIGHTS
*
*/

$_RIGHTS = explode( ',', SEC_getUserPermissions() );

if( isset( $_GET['topic'] ))
{
    $topic = COM_applyFilter( $_GET['topic'] );
}
else if( isset( $_POST['topic'] ))
{
    $topic = COM_applyFilter( $_POST['topic'] );
}
else
{
    $topic = '';
}


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
* @see function COM_startBlock
* @see function COM_endBlock
* @see function COM_showBlocks
* @see function COM_showBlock
* @return   string  template name
*/
function COM_getBlockTemplate( $blockname, $which )
{
    global $_BLOCK_TEMPLATE, $_COM_VERBOSE;

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
* @param    bool    $all    if true, return all themes even if users aren't allowed to change their default themes
* @return   array           All installed themes
*
*/
function COM_getThemes( $all = false )
{
    global $_CONF;

    $index = 1;

    $themes = array();

    $fd = opendir( $_CONF['path_themes'] );

    // If users aren't allowed to change their theme then only return the default theme

    if(( $_CONF['allow_user_themes'] == 0 ) && !$all )
    {
        $themes[$index] = $_CONF['theme'];
    }
    else
    {
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
* @param    Template    $header     reference to the header template
* @param    array       $plugin_menu    array of plugin menu entries, if any
*
*/
function COM_renderMenu( &$header, $plugin_menu )
{
    global $_CONF, $_USER, $LANG01, $topic;

    if( empty( $_CONF['menu_elements'] ))
    {
        $_CONF['menu_elements'] = array( // default set of links
                'contribute', 'calendar', 'search', 'stats',
                'directory', 'plugins' );
    }

    $anon = ( empty( $_USER['uid'] ) || ( $_USER['uid'] <= 1 )) ? true : false;
    $menuCounter = 0;
    $allowedCounter = 0;
    $counter = 0;

    $num_plugins = sizeof( $plugin_menu );
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
        if( sizeof( $custom_entries ) == 0 )
        {
            $key = array_search( 'custom', $_CONF['menu_elements'] );
            unset( $_CONF['menu_elements'][$key] );
        }
    }

    $num_elements = sizeof( $_CONF['menu_elements'] );

    foreach( $_CONF['menu_elements'] as $item )
    {
        $counter++;
        $allowed = true;
        $last_entry = ( $counter == $num_elements ) ? true : false;

        switch( $item )
        {
            case 'calendar':
                $url = $_CONF['site_url'] . '/calendar.php';
                $label = $LANG01[74];
                if( $anon && ( $_CONF['loginrequired'] ||
                        $_CONF['calendarloginrequired'] ))
                {
                    $allowed = false;
                }
                break;

            case 'contribute':
                if( empty( $topic ))
                {
                    $url = $_CONF['site_url'] . '/submit.php?type=story';
                    $header->set_var( 'current_topic', '' );
                }
                else
                {
                    $url = $_CONF['site_url']
                         . '/submit.php?type=story&amp;topic=' . $topic;
                    $header->set_var( 'current_topic', '&amp;topic=' . $topic );
                }
                $label = $LANG01[71];
                if( $anon && ( $_CONF['loginrequired'] ||
                        $_CONF['submitloginrequired'] ))
                {
                    $allowed = false;
                }
                break;

            case 'custom':
                $custom_count = 0;
                $custom_size = sizeof( $custom_entries );
                foreach( $custom_entries as $entry )
                {
                    $custom_count++;

                    if( empty( $entry['url'] ) || empty( $entry['label'] ))
                    {
                        continue;
                    }

                    $header->set_var( 'menuitem_url',  $entry['url'] );
                    $header->set_var( 'menuitem_text', $entry['label'] );

                    if( $last_entry && ( $custom_count == $custom_size ))
                    {
                        $header->parse( 'menu_elements', 'menuitem_last',
                                        true );
                    }
                    else
                    {
                        $header->parse( 'menu_elements', 'menuitem', true );
                    }
                    $menuCounter++;
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
                $url = $_CONF['site_url'] . '/usersettings.php?mode=edit';
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
* -------------------------------------------------------------------------------------
* <?php
* require_once('lib-common.php');
* $display .= COM_siteHeader(); //Change to COM_siteHeader('none') to not display left blocks
* $display .= "Here is your html for display";
* $display .= COM_siteFooter(true);  // Change to COM_siteFooter() to not display right blocks
* echo $display;
* ? >
* ---------------------------------------------------------------------------------------
*
* Note that the default for the header is to display the left blocks and the
* default of the footer is to not display the right blocks.
*
* This sandwich produces code like this (greatly simplified)
*
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
*
* @param    string  $what       If 'none' then no left blocks are returned, if 'menu' (default) then right blocks are returned
* @param    string  $pagetitle  optional content for the page's <title>
* @param    string  $headercode optional code to go into the page's <head>
* @return   string              Formatted HTML containing the site header
* @see function COM_siteFooter
*
*/

function COM_siteHeader( $what = 'menu', $pagetitle = '', $headercode = '' )
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG_BUTTONS, $LANG_CHARSET,
           $_IMAGE_TYPE, $topic, $_COM_VERBOSE;

    // If the theme implemented this for us then call their version instead.

    $function = $_CONF['theme'] . '_siteHeader';

    if( function_exists( $function ))
    {
        return $function( $what, $pagetitle );
    }

    // If we reach here then either we have the default theme OR
    // the current theme only needs the default variable substitutions

    $header = new Template( $_CONF['path_layout'] );
    $header->set_file( array(
        'header'        => 'header.thtml',
        'menuitem'      => 'menuitem.thtml',
        'menuitem_last' => 'menuitem_last.thtml',
        'menuitem_none' => 'menuitem_none.thtml',
        'leftblocks'    => 'leftblocks.thtml'
        ));

    // get topic if not on home page
    if( !isset( $_GET['topic'] ))
    {
        if( isset( $_GET['story'] ))
        {
            $sid = COM_applyFilter( $_GET['story'] );
        }
        elseif( isset( $_GET['sid'] ))
        {
            $sid = COM_applyFilter( $_GET['sid'] );
        }
        elseif( isset( $_POST['story'] ))
        {
            $sid = COM_applyFilter( $_POST['story'] );
        }
        if( empty( $sid ) && $_CONF['url_rewrite'] &&
                ( strpos( $_SERVER['PHP_SELF'], 'article.php' ) !== false ))
        {
            COM_setArgNames( array( 'story' ));
            $sid = COM_applyFilter( COM_getArgument( 'story' ));
        }
        if( !empty( $sid ))
        {
            $topic = DB_getItem( $_TABLES['stories'], 'tid', "sid='$sid'" );
        }
    }
    else
    {
        $topic = COM_applyFilter( $_GET['topic'] );
    }

    $feed_url = '';
    if( $_CONF['backend'] == 1 ) // add feed-link to header if applicable
    {
        $baseurl = SYND_getFeedUrl();

        $sql = 'SELECT format, filename, title FROM '
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
                $format = explode( '-', $A['format'] );
                $format_type = strtolower( $format[0] );
                $format_name = ucwords( $format[0] );

                $feed_url .= '<link rel="alternate" type="application/'
                          . $format_type . '+xml" title="' . $format_name
                          . ' Feed: ' . $A['title'] . '" href="' . $baseurl
                          . $A['filename'] . '">' . LB;
            }
        }
    }
    $header->set_var( 'feed_url', $feed_url );

    if( empty( $pagetitle ) && isset( $_CONF['pagetitle'] ))
    {
        $pagetitle = $_CONF['pagetitle'];
    }
    if( empty( $pagetitle ))
    {
        if( empty( $topic ))
        {
            $pagetitle = $_CONF['site_slogan'];
        }
        else
        {
            $pagetitle = stripslashes( DB_getItem( $_TABLES['topics'], 'topic',
                                                   "tid = '$topic'" ));
        }
    }
    if( !empty( $pagetitle ))
    {
        $pagetitle = ' - ' . $pagetitle;
    }
    $header->set_var( 'page_title', $_CONF['site_name'] . $pagetitle );

    if( isset( $_CONF['advanced_editor'] ) && ( $_CONF['advanced_editor'] == 1 )
            && file_exists( $_CONF['path_layout']
                            . 'advanced_editor_header.thtml' ))
    {
        $header->set_file( 'editor'  , 'advanced_editor_header.thtml');
        $header->parse( 'advanced_editor', 'editor' );

    }
    else
    {
         $header->set_var( 'advanced_editor', '' );
    }

    $header->set_var( 'background_image', $_CONF['layout_url']
                                          . '/images/bg.' . $_IMAGE_TYPE );
    $header->set_var( 'site_url', $_CONF['site_url'] );
    $header->set_var( 'layout_url', $_CONF['layout_url'] );
    $header->set_var( 'site_mail', "mailto:{$_CONF['site_mail']}" );
    $header->set_var( 'site_name', $_CONF['site_name'] );
    $header->set_var( 'site_slogan', $_CONF['site_slogan'] );
    $rdf = substr_replace( $_CONF['rdf_file'], $_CONF['site_url'], 0,
                           strlen( $_CONF['path_html'] ) - 1 );
    $header->set_var( 'rdf_file', $rdf );
    $header->set_var( 'rss_url', $rdf );

    $msg = $LANG01[67] . ' ' . $_CONF['site_name'];

    if( !empty( $_USER['username'] ))
    {
        $msg .= ', ' . $_USER['username'];
    }

    $curtime =  COM_getUserDateTimeFormat();

    $header->set_var( 'welcome_msg', $msg );
    $header->set_var( 'datetime', $curtime[0] );
    $header->set_var( 'site_logo', $_CONF['layout_url']
                                   . '/images/logo.' . $_IMAGE_TYPE );
    $header->set_var( 'css_url', $_CONF['layout_url'] . '/style.css' );
    $header->set_var( 'theme', $_CONF['theme'] );

    if( empty( $LANG_CHARSET ))
    {
        $charset = $_CONF['default_charset'];

        if( empty( $charset ))
        {
            $charset = 'iso-8859-1';
        }
    }
    else
    {
        $charset = $LANG_CHARSET;
    }

    $header->set_var( 'charset', $charset );

    // Now add variables for buttons like e.g. those used by the Yahoo theme
    $header->set_var( 'button_home', $LANG_BUTTONS[1] );
    $header->set_var( 'button_contact', $LANG_BUTTONS[2] );
    $header->set_var( 'button_contribute', $LANG_BUTTONS[3] );
    $header->set_var( 'button_calendar', $LANG_BUTTONS[6] );
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
        for( $i = 1; $i <= count( $plugin_menu ); $i++ )
        {
            $header->set_var( 'menuitem_url', current( $plugin_menu ));
            $header->set_var( 'menuitem_text', key( $plugin_menu ));

            if( $i == count( $plugin_menu ))
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

    if( $_CONF['left_blocks_in_footer'] == 1 )
    {
        $header->set_var( 'geeklog_blocks', '' );
        $header->set_var( 'left_blocks', '' );
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
        }
        else if( $what <> 'none' )
        {
            // Now show any blocks -- need to get the topic if not on home page
            $lblocks = COM_showBlocks( 'left', $topic );
        }

        if( empty( $lblocks ))
        {
            $header->set_var( 'geeklog_blocks', '' );
            $header->set_var( 'left_blocks', '' );
        }
        else
        {
            $header->set_var( 'geeklog_blocks', $lblocks );
            $header->parse( 'left_blocks', 'leftblocks', true );
        }
    }

    // Call any plugin that may want to include extra Meta tags
    // or Javascript functions
    $header->set_var( 'plg_headercode', $headercode . PLG_getHeaderCode() );

    // Call to plugins to set template variables in the header
    PLG_templateSetVars( 'header', $header );

    // The following lines allow users to embed PHP in their templates.  This
    // is almost a contradition to the reasons for using templates but this may
    // prove useful at times ...
    // Don't use PHP in templates if you can live without it!

    $tmp = $header->parse( 'index_header', 'header' );

    ob_start();
    eval( '?>' . $tmp );
    $retval = ob_get_contents();
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
    global $_CONF, $_TABLES, $LANG01, $_PAGE_TIMER, $topic;

    if( $rightblock < 0 )
    {
        if( isset( $_CONF['show_right_blocks'] ))
        {
            $rightblock = $_CONF['show_right_blocks'];
        }
        else
        {
            $rightblock = false;
        }
    }

    // If the theme implemented this for us then call their version instead.

    $function = $_CONF['theme'] . '_siteFooter';

    if( function_exists( $function ))
    {
        return $function( $rightblock );
    }

    // Set template directory
    $footer = new Template( $_CONF['path_layout'] );

    // Set template file
    $footer->set_file( array(
            'footer'      => 'footer.thtml',
            'rightblocks' => 'rightblocks.thtml',
            'leftblocks'  => 'leftblocks.thtml'
            ));

    // Do variable assignments
    DB_change( $_TABLES['vars'], 'value', 'value + 1', 'name', 'totalhits', '', true );

    $footer->set_var( 'site_url', $_CONF['site_url']);
    $footer->set_var( 'layout_url',$_CONF['layout_url']);
    $footer->set_var( 'site_mail', "mailto:{$_CONF['site_mail']}" );
    $footer->set_var( 'site_name', $_CONF['site_name'] );
    $footer->set_var( 'site_slogan', $_CONF['site_slogan'] );
    $rdf = substr_replace( $_CONF['rdf_file'], $_CONF['site_url'], 0,
                           strlen( $_CONF['path_html'] ) - 1 );
    $footer->set_var( 'rdf_file', $rdf );
    $footer->set_var( 'rss_url', $rdf );

    $year = date( 'Y' );
    $copyrightyear = $year;
    if( !empty( $_CONF['copyrightyear'] ))
    {
        $copyrightyear = $_CONF['copyrightyear'];
    }
    $footer->set_var( 'copyright_notice', '&nbsp;' . $LANG01[93] . ' &copy; '
            . $copyrightyear . ' ' . $_CONF['site_name'] . '<br>&nbsp;'
            . $LANG01[94] );
    $footer->set_var( 'copyright_msg', $LANG01[93] . ' &copy; '
            . $copyrightyear . ' ' . $_CONF['site_name'] );
    $footer->set_var( 'current_year', $year );
    $footer->set_var( 'lang_copyright', $LANG01[93] );
    $footer->set_var( 'trademark_msg', $LANG01[94] );
    $footer->set_var( 'powered_by', $LANG01[95] );
    $footer->set_var( 'geeklog_url', 'http://www.geeklog.net/' );
    $footer->set_var( 'geeklog_version', VERSION );

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
        }
    }
    elseif( $rightblock )
    {
        $rblocks = COM_showBlocks( 'right', $topic );
    }
    if( $rightblock && !empty( $rblocks ))
    {
        $footer->set_var( 'geeklog_blocks', $rblocks );
        $footer->parse( 'right_blocks', 'rightblocks', true );
    }
    else
    {
        $footer->set_var( 'geeklog_blocks', '' );
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
            $lblocks = COM_showBlocks( 'left', $topic );
        }

        if( empty( $lblocks ))
        {
            $footer->set_var( 'geeklog_blocks', '' );
            $footer->set_var( 'left_blocks', '' );
        }
        else
        {
            $footer->set_var( 'geeklog_blocks', $lblocks );
            $footer->parse( 'left_blocks', 'leftblocks', true );
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

    // Actually parse the template and make variable substitutions
    $footer->parse( 'index_footer', 'footer' );

    // Return resulting HTML
    return $footer->finish( $footer->get_var( 'index_footer' ));
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
*
* @param        string      $title      Value to set block title to
* @param        string      $helpfile   Help file, if one exists
* @param        string      $template   HTML template file to use to format the block
* @see COM_endBlock
* @see COM_siteHeader  For similiar construct
* @return   string  Formatted HTML containing block header
*
*/

function COM_startBlock( $title='', $helpfile='', $template='blockheader.thtml' )
{
    global $_CONF, $LANG01, $_IMAGE_TYPE;

    $block = new Template( $_CONF['path_layout'] );
    $block->set_file( 'block', $template );

    $block->set_var( 'site_url', $_CONF['site_url'] );
    $block->set_var( 'layout_url', $_CONF['layout_url'] );
    $block->set_var( 'block_title', stripslashes( $title ));

    if( !empty( $helpfile ))
    {
        $helpimg = $_CONF['layout_url'] . '/images/button_help.' . $_IMAGE_TYPE;
        if( !stristr( $helpfile, 'http://' ))
        {
            $help = '<a class="blocktitle" href="' . $_CONF['site_url'] . '/help/' . $helpfile
                . '" target="_blank"><img src="' . $helpimg
                . '" border="0" alt="?"></a>';
        }
        else
        {
            $help = '<a class="blocktitle" href="' . $helpfile
                . '" target="_blank"><img src="' . $helpimg
                . '" border="0" alt="?"></a>';
        }

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

    $block = new Template( $_CONF['path_layout'] );
    $block->set_file( 'block', $template );

    $block->set_var( 'site_url', $_CONF['site_url'] );
    $block->set_var( 'layout_url', $_CONF['layout_url'] );
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
* Create and return a list of available topics
*
* This is a variation of COM_optionList() from lib-common.php. It will add
* only those topics to the option list which are accessible by the current
* user.
*
* @param        string      $selection  Comma delimited string of fields to pull The first field is the value of the option and the second is the label to be displayed.  This is used in a SQL statement and can include DISTINCT to start.
* @param        string      $selected   Value (from $selection) to set to SELECTED or default
* @param        int         $sortcol    Which field to sort option list by 0 (value) or 1 (label)
* @see function COM_optionList
* @return   string  Formated HTML of option values
*
*/

function COM_topicList( $selection, $selected='', $sortcol=1 )
{
    global $_TABLES;

    $retval = '';

    $tmp = str_replace( 'DISTINCT ', '', $selection );
    $select_set = explode( ',', $tmp );

    $result = DB_query( "SELECT * FROM {$_TABLES['topics']}" . COM_getPermSQL()
            . " ORDER BY $select_set[$sortcol]" );
    $nrows = DB_numRows( $result );

    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result, true );
        $retval .= '<option value="' . $A[0] . '"';

        if( $A[0] == $selected )
        {
            $retval .= ' selected';
        }

        $retval .= '>' . stripslashes( $A[1] ) . '</option>' . LB;
    }

    return $retval;
}

/**
* Creates a <input> checklist from a database list for use in forms
*
* Creates a group of checkbox form fields with given arguments
*
* @param        string      $table      DB Table to pull data from
* @param        string      $selection  Comma delimited list of fields to pull from table
* @param        string      $where      Where clause of SQL statement
* @param        string      $selected   Value to set to CHECKED
* @see function COM_optionList
* @return   string  HTML with Checkbox code
*
*/

function COM_checkList( $table, $selection, $where='', $selected='' )
{
    global $_TABLES, $_COM_VERBOSE;

    $retval = '';

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

    for( $i = 0; $i < $nrows; $i++ )
    {
        $access = true;
        $A = DB_fetchArray( $result, true );

        if( $table == $_TABLES['topics'] AND SEC_hasTopicAccess( $A['tid'] ) == 0 )
        {
            $access = false;
        }

        if( $access )
        {
            $retval .= '<input type="checkbox" name="' . $table . '[]" value="' . $A[0] . '"';

            for( $x = 0; $x < sizeof( $S ); $x++ )
            {
                if( $A[0] == $S[$x] )
                {
                    $retval .= ' checked="checked"';
                }
            }

            if(( $table == $_TABLES['blocks'] ) && isset( $A[2] ) && ( $A[2] == 'gldefault' ))
            {
                $retval .= '><b>' . stripslashes( $A[1] ) . '</b><br>' . LB;
            }
            else
            {
                $retval .= '>' . stripslashes( $A[1] ) . '<br>' . LB;
            }
        }
    }

    return $retval;
}

/**
* Prints out an associative array for debugging
*
* The core of this code has been lifted from phpweblog which is licenced
* under the GPL.  This is not used very much in the code but you can use it
* if you see fit
*
* @param        array       $A      Array to loop through and print values for
* @return   string  Formated HTML List
*
*/

function COM_debug( $A )
{
    if( !empty( $A ))
    {
        $retval .= LB . '<pre><p>---- DEBUG ----</p>';

        for( reset( $A ); $k = key( $A ); next( $A ))
        {
            $retval .= sprintf( "<li>%13s [%s]</li>\n", $k, $A[$k] );
        }

        $retval .= '<p>---------------</p></pre>' . LB;
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
* @param    string  $updated_type   (optional) feed type to update
* @param    string  $updated_topic  (optional) feed topic to update
* @param    string  $updated_id     (optional) feed id to update
*
* @note When called without parameters, this will only check for new entries to
*       include in the feeds. Pass the $updated_XXX parameters when the content
*       of an existing entry has changed.
*
* @see file lib-syndication.php
*
*/
function COM_rdfUpToDateCheck( $updated_type = '', $updated_topic = '', $updated_id = '' )
{
    global $_CONF, $_TABLES;

    if( $_CONF['backend'] > 0 )
    {
        if( !empty( $updated_type ) && ( $updated_type != 'geeklog' ))
        {
            // when a plugin's feed is to be updated, skip Geeklog's own feeds
            $sql = "SELECT fid,type,topic,limits,update_info FROM {$_TABLES['syndication']} WHERE (is_enabled = 1) AND (type <> 'geeklog')";
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
            if( $A['type'] == 'geeklog' )
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

    $curdate = date( "Y-m-d H:i:s", time() );

    if( DB_getItem( $_TABLES['stories'], 'count(*)', "featured = 1 AND draft_flag = 0 AND date <= '$curdate'" ) > 1 )
    {
        // OK, we have two featured stories, fix that

        $sid = DB_getItem( $_TABLES['stories'], 'sid', "featured = 1 AND draft_flag = 0 ORDER BY date LIMIT 1" );
        DB_query( "UPDATE {$_TABLES['stories']} SET featured = 0 WHERE sid = '$sid'" );
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
* @param        int         $actionid       1 = write to log file, 2 = write to screen (default) both
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
        $timestamp = strftime( '%c' );

        switch( $actionid )
        {
            case 1:
                $logfile = $_CONF['path_log'] . 'error.log';

                if( !$file = fopen( $logfile, 'a' ))
                {
                    $retval .= $LANG01[33] . ' ' . $logfile . ' (' . $timestamp . ')<br>' . LB;
                }
                else
                {
                    fputs( $file, "$timestamp - $logentry \n" );
                }
                break;

           case 2:
                $retval .= COM_startBlock( $LANG01[55] . ' ' . $timestamp, '',
                               COM_getBlockTemplate( '_msg_block', 'header' ))
                        . nl2br( $logentry )
                        . COM_endBlock( COM_getBlockTemplate( '_msg_block',
                                                              'footer' ));
                break;

            default:
                $logfile = $_CONF['path_log'] . 'error.log';

                if( !$file = fopen( $logfile, 'a' ))
                {
                    $retval .= $LANG01[33] . ' ' . $logfile . ' (' . $timestamp . ')<br>' . LB;
                }
                else
                {
                    fputs( $file, "$timestamp - $logentry \n" );
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
* @param        string      $string         Message to write to access log
* @see COM_errorLog
*
*/

function COM_accessLog( $logentry )
{
    global $_CONF, $_USER, $LANG01;

    $retval = '';

    $timestamp = strftime( '%c' );
    $logfile = $_CONF['path_log'] . 'access.log';

    if( !$file = fopen( $logfile, 'a' ))
    {
        return $LANG01[33] . $logfile . ' (' . $timestamp . ')<br>' . LB;
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

    return $retval;
}

/**
* Shows all available topics
*
* Show the topics in the system the user has access to and prints them in HTML.
* This function is used to show the topics in the sections block.
*
* @param        string      $topic      TopicID of currently selected
* @return   string    HTML formatted topic list
*
*/

function COM_showTopics( $topic='' )
{
    global $_CONF, $_TABLES, $_USER, $LANG01,
           $_THEME_URL, $_BLOCK_TEMPLATE, $page, $newstories;

    $sql = "SELECT tid,topic,imageurl FROM {$_TABLES['topics']}";
    if( $_USER['uid'] > 1 )
    {
        $tids = DB_getItem( $_TABLES['userindex'], 'tids',
                            "uid = '{$_USER['uid']}'" );
        if( !empty( $tids ))
        {
            $sql .= " WHERE (tid NOT IN ('" . str_replace( ' ', "','", $tids )
                 . "'))" . COM_getPermSQL( 'AND' );
        }
        else
        {
            $sql .= COM_getPermSQL();
        }
    }
    else
    {
        $sql .= COM_getPermSQL();
    }
    if( $_CONF['sortmethod'] == 'alpha' )
    {
        $sql .= ' ORDER BY topic ASC';
    }
    else
    {
        $sql .= ' ORDER BY sortnum';
    }
    $result = DB_query( $sql );

    $retval = '';
    $sections = new Template( $_CONF['path_layout'] );
    if( isset( $_BLOCK_TEMPLATE['topicoption'] ))
    {
        $templates = explode( ',', $_BLOCK_TEMPLATE['topicoption'] );
        $sections->set_file( array( 'option' => $templates[0],
                                     'current' => $templates[1] ));
    }
    else
    {
        $sections->set_file( array( 'option' => 'topicoption.thtml',
                                    'inactive' => 'topicoption_off.thtml' ));
    }
    $sections->set_var( 'site_url', $_CONF['site_url'] );
    $sections->set_var( 'layout_url', $_CONF['layout_url'] );
    $sections->set_var( 'block_name', str_replace( '_', '-', 'section_block' ));

    if( $_CONF['hide_home_link'] == 0 )
    {
        // Give a link to the homepage here since a lot of people use this for
        // navigating the site

        if( COM_isFrontpage() )
        {
            $sections->set_var( 'option_url',
                                $_CONF['site_url'] . '/index.php' );
            $sections->set_var( 'option_label', $LANG01[90] );
            $sections->set_var( 'option_count', '' );
            $sections->set_var( 'topic_image', '' );
            $retval .= $sections->parse( 'item', 'option' );
        }
        else
        {
            $sections->set_var( 'option_url', '' );
            $sections->set_var( 'option_label', $LANG01[90] );
            $sections->set_var( 'option_count', '' );
            $sections->set_var( 'topic_image', '' );
            $retval .= $sections->parse( 'item', 'inactive' );
        }
    }

    if( $_CONF['showstorycount'] )
    {
        $sql = "SELECT tid, count(*) AS count FROM {$_TABLES['stories']} "
             . 'WHERE (draft_flag = 0) AND (date <= NOW()) '
             . COM_getPermSQL( 'AND' )
             . ' GROUP BY tid';
        $rcount = DB_query( $sql );
        while( $C = DB_fetchArray( $rcount ))
        {
            $storycount[$C['tid']] = $C['count'];
        }
    }

    if( $_CONF['showsubmissioncount'] )
    {
        $sql = "SELECT tid, count(*) AS count FROM {$_TABLES['storysubmission']} "
             . ' GROUP BY tid';
        $rcount = DB_query( $sql );
        while( $C = DB_fetchArray( $rcount ))
        {
            $submissioncount[$C['tid']] = $C['count'];
        }
    }

    while( $A = DB_fetchArray( $result ) )
    {
        $topicname = stripslashes( $A['topic'] );
        $sections->set_var( 'option_url', $_CONF['site_url']
                            . '/index.php?topic=' . $A['tid'] );
        $sections->set_var( 'option_label', $topicname );

        $countstring = '';
        if( $_CONF['showstorycount'] || $_CONF['showsubmissioncount'] )
        {
            $countstring .= '(';

            if( $_CONF['showstorycount'] )
            {
                if( empty( $storycount[$A['tid']] ))
                {
                    $countstring .= 0;
                }
                else
                {
                    $countstring .= $storycount[$A['tid']];
                }
            }

            if( $_CONF['showsubmissioncount'] )
            {
                if( $_CONF['showstorycount'] )
                {
                    $countstring .= '/';
                }
                if( empty( $submissioncount[$A['tid']] ))
                {
                    $countstring .= 0;
                }
                else
                {
                    $countstring .= $submissioncount[$A['tid']];
                }
            }

            $countstring .= ')';
        }
        $sections->set_var( 'option_count', $countstring );

        $topicimage = '';
        if( !empty( $A['imageurl'] ))
        {
            if( isset( $_THEME_URL ))
            {
                $imagebase = $_THEME_URL;
            }
            else
            {
                $imagebase = $_CONF['site_url'];
            }
            $topicimage = '<img src="' . $imagebase . $A['imageurl'] . '" alt="'
                        . $topicname . '" title="' . $topicname . '">';
        }
        $sections->set_var( 'topic_image', $topicimage );

        if(( $A['tid'] == $topic ) && ( $page == 1 ))
        {
            $retval .= $sections->parse( 'item', 'inactive' );
        }
        else
        {
            $retval .= $sections->parse( 'item', 'option' );
        }
    }

    return $retval;
}

/**
* Shows the user their menu options
*
* This shows the average joe use their menu options. This is the user block on right side
*
* @param        string      $help       Help file to show
* @param        string      $title      Title of Menu
* @see function COM_adminMenu
*
*/

function COM_userMenu( $help='', $title='' )
{
    global $_TABLES, $_USER, $_CONF, $LANG01, $LANG04, $_BLOCK_TEMPLATE;

    $retval = '';

    if( $_USER['uid'] > 1 )
    {
        $usermenu = new Template( $_CONF['path_layout'] );
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
        $usermenu->set_var( 'site_url', $_CONF['site_url'] );
        $usermenu->set_var( 'layout_url', $_CONF['layout_url'] );
        $usermenu->set_var( 'block_name', str_replace( '_', '-', 'user_block' ));

        if( empty( $title ))
        {
            $title = DB_getItem( $_TABLES['blocks'], 'title',
                                 "name='user_block'" );
        }

        // what's our current URL?
        $thisUrl = COM_getCurrentURL();

        $retval .= COM_startBlock( $title, $help,
                           COM_getBlockTemplate( 'user_block', 'header' ));

        if( $_CONF['personalcalendars'] == 1 )
        {
            $url = $_CONF['site_url'] . '/calendar.php?mode=personal';
            $usermenu->set_var( 'option_label', $LANG01[66] );
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
        }

        // This function will show the user options for all installed plugins
        // (if any)

        $plugin_options = PLG_getUserOptions();
        $nrows = count( $plugin_options );

        for( $i = 1; $i <= $nrows; $i++ )
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

        $url = $_CONF['site_url'] . '/usersettings.php?mode=edit';
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

        $url = $_CONF['site_url'] . '/usersettings.php?mode=preferences';
        $usermenu->set_var( 'option_label', $LANG01[49] );
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
        $retval .= $usermenu->parse( 'item', 'option' );

        $retval .=  COM_endBlock( COM_getBlockTemplate( 'user_block', 'footer' ));
    }
    else
    {
        $retval .= COM_startBlock( $LANG01[47], $help,
                           COM_getBlockTemplate( 'user_block', 'header' ));

        $login = new Template( $_CONF['path_layout'] );
        $login->set_file( 'form', 'loginform.thtml' );
        $login->set_var( 'site_url', $_CONF['site_url'] );
        $login->set_var( 'site_url_ssl', $_CONF['site_url_ssl'] );
        $login->set_var( 'layout_url', $_CONF['layout_url'] );
        $login->set_var( 'lang_username', $LANG01[21] );
        $login->set_var( 'lang_password', $LANG01[57] );
        $login->set_var( 'lang_forgetpassword', $LANG01[119] );
        $login->set_var( 'lang_login', $LANG01[58] );
        if( $_CONF['disable_new_user_registration'] == 1 )
        {
            $login->set_var( 'lang_signup', '' );
        }
        else
        {
            $login->set_var( 'lang_signup', $LANG01[59] );
        }
        if( $_CONF['remoteauthentication'] && !$_CONF['usersubmission'] )
        {
            // Build select
            $select = '<select name="service"><option value="">' .
                            $_CONF['site_name'] . '</option>';
            if( is_dir( $_CONF['path_system'] . 'classes/authentication/' ))
            {
                $folder = opendir( $_CONF['path_system']
                                   . 'classes/authentication/' );
                while(( $filename = @readdir( $folder )) !== false )
                {
                    $strpos = strpos( $filename, '.auth.class.php' );
                    if( $strpos )
                    {
                        $service = substr( $filename, 0, $strpos );
                        $select .= '<option value="' . $service . '">'
                                . $service . '</option>';
                    }
                }
            }
            $select .= '</select>';
            $login->set_file( 'services', 'blockservices.thtml' );
            $login->set_var( 'lang_service', $LANG04[121] );
            $login->set_var( 'select_service', $select );
            $login->parse( 'output', 'services' );
            $login->set_var( 'services',
                             $login->finish( $login->get_var( 'output' )));
        }
        else
        {
            $login->set_var( 'services', '' );
        }
        $retval .= $login->parse( 'output', 'form' );

        $retval .= COM_endBlock( COM_getBlockTemplate( 'user_block', 'footer' ));
    }

    return $retval;
}

/**
* Prints administration menu
*
* This will return the administration menu items that the user has
* sufficient rights to -- Admin Block on right side.
*
* @param        string      $help       Help file to show
* @param        string      $title      Menu Title
* @see function COM_userMenu
*
*/

function COM_adminMenu( $help = '', $title = '' )
{
    global $_TABLES, $_USER, $_CONF, $LANG01, $_BLOCK_TEMPLATE, $LANG_PDF;

    $retval = '';

    if( empty( $_USER['username'] ))
    {
        return $retval;
    }

    $plugin_options = PLG_getAdminOptions();
    $nrows = count( $plugin_options );

    if( SEC_isModerator() OR SEC_hasrights( 'story.edit,block.edit,topic.edit,event.edit,user.edit,plugin.edit,user.mail', 'OR' ) OR ( $nrows > 0 ))
    {
        // what's our current URL?
        $thisUrl = COM_getCurrentURL();

        $adminmenu = new Template( $_CONF['path_layout'] );
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
        $adminmenu->set_var( 'site_url', $_CONF['site_url'] );
        $adminmenu->set_var( 'layout_url', $_CONF['layout_url'] );
        $adminmenu->set_var( 'block_name', str_replace( '_', '-', 'admin_block' ));

        if( empty( $title ))
        {
            $title = DB_getItem( $_TABLES['blocks'], 'title',
                                 "name = 'admin_block'" );
        }

        $retval .= COM_startBlock( $title, $help,
                           COM_getBlockTemplate( 'admin_block', 'header' ));

        $topicsql = '';
        if( SEC_isModerator() || SEC_hasrights( 'story.edit' ))
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
                if( sizeof( $tids ) > 0 )
                {
                    $topicsql = " (tid IN ('" . implode( "','", $tids ) . "'))";
                }
            }
        }

        if( SEC_isModerator()  || (( $_CONF['usersubmission'] == 1 ) && SEC_hasRights( 'user.edit,user.delete' )))
        {
            $num = 0;

            if( SEC_hasrights( 'story.edit' ))
            {
                if( empty( $topicsql ))
                {
                    $num += DB_count( $_TABLES['storysubmission'] );
                }
                else
                {
                    $sresult = DB_query( "SELECT COUNT(*) AS count FROM {$_TABLES['storysubmission']} WHERE" . $topicsql );
                    $S = DB_fetchArray( $sresult );
                    $num += $S['count'];
                }

                if( $_CONF['listdraftstories'] == 1 )
                {
                    $sql = "SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE (draft_flag = 1)";
                    if( !empty( $topicsql ))
                    {
                        $sql .= ' AND' . $topicsql;
                    }
                    $result = DB_query( $sql . COM_getPermSQL( 'AND', 0, 3 ));
                    $A = DB_fetchArray( $result );
                    $num += $A['count'];
                }
            }

            if( SEC_hasrights( 'event.edit' ))
            {
                $num += DB_count( $_TABLES['eventsubmission'] );
            }


            if( $_CONF['usersubmission'] == 1 )
            {
                if( SEC_hasrights( 'user.edit' ) && SEC_hasrights( 'user.delete' ))
                {
                    $emptypwd = md5( '' );
                    $num += DB_count( $_TABLES['users'], 'status', '2' );
                }
            }

            // now handle submissions for plugins

            $num = $num + PLG_getSubmissionCount();

            $url = $_CONF['site_admin_url'] . '/moderation.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[10] );
            $adminmenu->set_var( 'option_count', $num );
            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[10]] = $menu_item;
        }

        if( SEC_hasrights( 'story.edit' ))
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
                $nresult = DB_query( "SELECT COUNT(*) AS count from {$_TABLES['stories']} WHERE" . $topicsql );
                $N = DB_fetchArray( $nresult );
                $numstories = $N['count'];
            }
            $adminmenu->set_var( 'option_count', $numstories );
            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[11]] = $menu_item;
        }

        if( SEC_hasrights( 'block.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/block.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[12] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['blocks'] ));

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[12]] = $menu_item;
        }

        if( SEC_hasrights( 'topic.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/topic.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[13] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['topics'] ));

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[13]] = $menu_item;
        }

        if( SEC_hasrights( 'event.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/event.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[15] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['events'] ));

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[15]] = $menu_item;
        }

        if( SEC_hasrights( 'user.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/user.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[17] );
            $adminmenu->set_var( 'option_count', ( DB_count( $_TABLES['users'] ) -1 ));

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[17]] = $menu_item;
        }

        if( SEC_hasrights( 'group.edit' ))
        {
            $thisUsersGroups = SEC_getUserGroups();
            $grp_list = implode( ',', $thisUsersGroups );
            $result = DB_query( "SELECT COUNT(*) AS count FROM {$_TABLES['groups']} WHERE grp_id IN ($grp_list)" );
            $A = DB_fetchArray( $result );

            $url = $_CONF['site_admin_url'] . '/group.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[96] );
            $adminmenu->set_var( 'option_count', $A['count'] );

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[96]] = $menu_item;
        }

        if( SEC_hasrights( 'user.mail' ))
        {
            $url = $_CONF['site_admin_url'] . '/mail.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[105] );
            $adminmenu->set_var( 'option_count', 'N/A' );

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[105]] = $menu_item;
        }

        if(( $_CONF['backend'] == 1 ) && SEC_inGroup( 'Root' ))
        {
            $url = $_CONF['site_admin_url'] . '/syndication.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[38] );
            $count = DB_count( $_TABLES['syndication'] );
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
                $count = DB_count( $_TABLES['pingservice'] );
                $adminmenu->set_var( 'option_count', $count );
            }
            else
            {
                $adminmenu->set_var( 'option_count', 'N/A' );
            }

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[116]] = $menu_item;
        }

        if( SEC_hasRights( 'plugin.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/plugins.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[77] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['plugins'] ));

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[77]] = $menu_item;
        }

        // This will show the admin options for all installed plugins (if any)

        for( $i = 1; $i <= $nrows; $i++ )
        {
            $plg = current( $plugin_options );

            $adminmenu->set_var( 'option_url', $plg->adminurl );
            $adminmenu->set_var( 'option_label', $plg->adminlabel );

            if( empty( $plg->numsubmissions ))
            {
                $adminmenu->set_var( 'option_count', 'N/A' );
            }
            else
            {
                $adminmenu->set_var( 'option_count', $plg->numsubmissions );
            }

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $plg->adminurl ) ? 'current' : 'option', true );
            $link_array[$plg->adminlabel] = $menu_item;

            next( $plugin_options );
        }

        if( $_CONF['allow_mysqldump'] == 1 AND SEC_inGroup( 'Root' ))
        {
            $url = $_CONF['site_admin_url'] . '/database.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[103] );
            $adminmenu->set_var( 'option_count', 'N/A' );

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG01[103]] = $menu_item;
        }

        // Add PDF Generator Link if the feature is enabled
        if(( $_CONF['pdf_enabled'] == 1 ) AND ( SEC_inGroup( 'Root' )))
        {
            $url = $_CONF['site_url'] . '/pdfgenerator.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG_PDF[9] );
            $adminmenu->set_var( 'option_count', 'N/A' );

            $menu_item = $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
            $link_array[$LANG_PDF[9]] = $menu_item;
        }

        if( $_CONF['link_documentation'] == 1 )
        {
            $adminmenu->set_var( 'option_url',
                                 $_CONF['site_url'] . '/docs/index.html' );
            $adminmenu->set_var( 'option_label', $LANG01[113] );
            $adminmenu->set_var( 'option_count', 'N/A' );
            $menu_item = $adminmenu->parse( 'item', 'option' );
            $link_array[$LANG01[113]] = $menu_item;
        }

        if( SEC_inGroup( 'Root' ))
        {
            $adminmenu->set_var( 'option_url',
               'http://www.geeklog.net/versionchecker.php?version=' . VERSION );
            $adminmenu->set_var( 'option_label', $LANG01[107] );
            $adminmenu->set_var( 'option_count', VERSION );

            $menu_item = $adminmenu->parse( 'item', 'option' );
            $link_array[$LANG01[107]] = $menu_item;
        }
        if ($_CONF['sort_admin'] )
        {
            ksort($link_array);
        }
        reset($link_array);
        while (list($key, $val) = each($link_array))
        {
          $retval .= "$val\n";
        }
        $retval .= COM_endBlock( COM_getBlockTemplate( 'admin_block', 'footer' ));
    }

    return $retval;
}

/**
* Redirects user to a given URL
*
* This function COM_passes a meta tag to COM_refresh after a form is sent.  This is
* necessary because for some reason Nutscrape and PHP4 don't play well with
* the header() function COM_100% of the time.
*
* @param        string      $url        URL to send user to
*
*/

function COM_refresh( $url )
{
    return "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
}

/**
 * DEPRECIATED -- see CMT_userComments in lib-comment.php
 */
function COM_userComments( $sid, $title, $type='article', $order='', $mode='', $pid = 0, $page = 1, $cid = false, $delete_option = false ) {
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
                    $RegExPrefix = '(\s*)';
                    $RegExSuffix = '(\W*)';
                    break;

                case 2: # Word beginning
                    $RegExPrefix = '(\s*)';
                    $RegExSuffix = '(\w*)';
                    break;

                case 3: # Word fragment
                    $RegExPrefix   = '(\w*)';
                    $RegExSuffix   = '(\w*)';
                    break;
            }

            for( $i = 0; $i < count( $_CONF['censorlist']); $i++ )
            {
                $EditedMessage = eregi_replace( $RegExPrefix . $_CONF['censorlist'][$i] . $RegExSuffix, "\\1$Replacement\\2", $EditedMessage );
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
    global $_CONF;

    $str = stripslashes( $str );

    // Get rid of any newline characters
    $str = preg_replace( "/\n/", '', $str );

    // Replace any $ with &#36; (HTML equiv)
    $str = str_replace( '$', '&#36;', $str );

    // handle [code] ... [/code]
    do
    {
        $start_pos = strpos( strtolower( $str ), '[code]' );
        if( $start_pos !== false )
        {
            $end_pos = strpos( strtolower( $str ), '[/code]' );
            if( $end_pos !== false )
            {
                $encoded = COM_handleCode( substr( $str, $start_pos + 6,
                        $end_pos - ( $start_pos + 6 )));
                $encoded = '<pre><code>' . $encoded . '</code></pre>';
                $str = substr( $str, 0, $start_pos ) . $encoded
                     . substr( $str, $end_pos + 7 );
            }
            else // missing [/code]
            {
                // Treat the rest of the text as code (so as not to lose any
                // special characters). However, the calling entity should
                // better be checking for missing [/code] before calling this
                // function ...
                $encoded = COM_handleCode( substr( $str, $start_pos + 6 ));
                $encoded = '<pre><code>' . $encoded . '</code></pre>';
                $str = substr( $str, 0, $start_pos ) . $encoded;
            }
        }
    }
    while( $start_pos !== false );

    // strip_tags() gets confused by HTML comments ...
    $str = preg_replace( '/<!--.+?-->/', '', $str );

    $filter = new kses4;
    if( isset( $_CONF['allowed_protocols'] ) && is_array( $_CONF['allowed_protocols'] ) && ( sizeof( $_CONF['allowed_protocols'] ) > 0 ))
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
        $html = array_merge_recursive( $_CONF['user_html'],
                                       $_CONF['admin_html'] );
    }

    foreach( $html as $tag => $attr )
    {
        $filter->AddHTML( $tag, $attr );
    }

    return $filter->Parse( $str );
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
    srand(( double ) microtime() * 1000000 );
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
* Takes a name and an email address and returns a string that vaguely
* resembles an email address specification conforming to RFC(2)822 ...
*
* @param    string  $name       name, e.g. John Doe
* @param    string  $address    email address only, e.g. john.doe@example.com
* @return   string              formatted email address
*
*/
function COM_formatEmailAddress( $name, $address )
{
    $formatted_name = $name;

    if( eregi( '[^0-9a-z ]', $formatted_name ))
    {
        $formatted_name = str_replace( '"', '\\"', $formatted_name );
        $formatted_name = '"' . $formatted_name . '"';
    }

    return $formatted_name . ' <' . $address . '>';
}

/**
* Send an email.
*
* All emails sent by Geeklog are sent through this function now.
*
* @param    to         string   recipients name and email address
* @param    subject    string   subject of the email
* @param    message    string   the text of the email
* @param    from       string   (optional) sender of the the email
* @param    html       bool     true if to be sent as an HTML email
* @param    priority   int      add X-Priority header, if > 0
* @return   boolean             true if successful,  otherwise false
*
*/
function COM_mail( $to, $subject, $message, $from = '', $html = false, $priority = 0 )
{
    global $_CONF, $LANG_CHARSET;

    static $mailobj;

    if( empty( $from ))
    {
        $from = COM_formatEmailAddress( $_CONF['site_name'], $_CONF['site_mail']);
    }

    $to = substr( $to, 0, strcspn( $to, "\r\n" ));
    $from = substr( $from, 0, strcspn( $from, "\r\n" ));
    $subject = substr( $subject, 0, strcspn( $subject, "\r\n" ));

    if( function_exists( 'CUSTOM_mail' ))
    {
        return CUSTOM_mail( $to, $subject, $message, $from, $html, $priority );
    }

    include_once( 'Mail.php' );
    include_once( 'Mail/RFC822.php' );

    $method = $_CONF['mail_settings']['backend'];

    if( !isset( $mailobj ))
    {
        if(( $method == 'sendmail' ) || ( $method == 'smtp' ))
        {
            $mailobj =& Mail::factory( $method, $_CONF['mail_settings'] );
        }
        else
        {
            $method = 'mail';
            $mailobj =& Mail::factory( $method );
        }
    }

    if( empty( $LANG_CHARSET ))
    {
        $charset = $_CONF['default_charset'];
        if( empty( $charset ))
        {
            $charset = 'iso-8859-1';
        }
    }
    else
    {
        $charset = $LANG_CHARSET;
    }

    $headers = array();

    $headers['From'] = $from;
    if( $method != 'mail' )
    {
        $headers['To'] = $to;
    }
    $headers['Date'] = date( 'r' ); // RFC822 formatted date
    if( $method == 'smtp' )
    {
        list( $usec, $sec ) = explode( ' ', microtime());
        $m = substr( $usec, 2, 5 );
        $headers['Message-Id'] = '<' .  date( 'YmdHis' ) . '.' . $m
                               . '@' . $_CONF['mail_settings']['host'] . '>';
    }
    if( $html )
    {
        $headers['Content-Type'] = 'text/html; charset=' . $charset;
        $headers['Content-Transfer-Encoding'] = '8bit';
    }
    else
    {
        $headers['Content-Type'] = 'text/plain; charset=' . $charset;
    }
    $headers['Subject'] = $subject;
    if( $priority > 0 )
    {
        $headers['X-Priority'] = $priority;
    }
    $headers['X-Mailer'] = 'GeekLog ' . VERSION;

    $retval = $mailobj->send( $to, $headers, $message );
    if( $retval !== true )
    {
        COM_errorLog( $retval->toString(), 1 );
    }

    return( $retval === true ? true : false );
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

    $sql = "SELECT sid,tid,title,comments,UNIX_TIMESTAMP(date) AS day FROM {$_TABLES['stories']} WHERE (perm_anon = 2) AND (frontpage = 1) AND (date <= NOW()) AND (draft_flag = 0)" . COM_getTopicSQL( 'AND', 1 ) . " ORDER BY featured DESC, date DESC LIMIT {$_CONF['limitnews']}, {$_CONF['limitnews']}";
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
                    $string .= $daylist . '<br>';
                }

                $day2 = strftime( $dateonly, $A['day'] );
                $string .= '<b>' . $daycheck . '</b> <small>' . $day2
                        . '</small>' . LB;
                $oldnews = array();
                $day = $daycheck;
            }

            $oldnews[] = '<a href="' . COM_buildUrl( $_CONF['site_url']
                . '/article.php?story=' . $A['sid'] ) . '">' . $A['title']
                . '</a> (' . $A['comments'] . ')';
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
* @param        string      $name       Logical name of block (not same as title) -- 'user_block', 'admin_block', 'section_block', 'events_block', 'whats_new_block'.
* @param        string      $help       Help file location
* @param        string      $title      Title shown in block header
* @see function COM_showBlocks
* @return   string  HTML Formated block
*
*/

function COM_showBlock( $name, $help='', $title='' )
{
    global $_CONF, $topic, $_TABLES, $_USER;

    $retval = '';

    if( isset( $_USER['noboxes'] ))
    {
        if( !empty( $_USER['uid'] ))
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
            $retval .= COM_userMenu( $help,$title );
            break;

        case 'admin_block':
            $retval .= COM_adminMenu( $help,$title );
            break;

        case 'section_block':
            $retval .= COM_startBlock( $title, $help,
                               COM_getBlockTemplate( $name, 'header' ))
                . COM_showTopics( $topic )
                . COM_endBlock( COM_getBlockTemplate( $name, 'footer' ));
            break;

        case 'events_block':
            if( !$_USER['noboxes'] && $_CONF['showupcomingevents'] )
            {
                $retval .= COM_printUpcomingEvents( $help, $title );
            }
            break;

        case 'whats_new_block':
            if( !$_USER['noboxes'] )
            {
                $retval .= COM_whatsNewBlock( $help, $title );
            }
            break;
    }

    return $retval;
}


/**
* Shows Geeklog blocks
*
* Returns HTML for blocks on a given side and, potentially, for
* a given topic. Currentlly only used by static pages.
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
      global $_CONF, $_TABLES, $_USER, $LANG21, $topic, $page, $newstories;

    $retval = '';

    // Get user preferences on blocks
    if( !isset( $_USER['noboxes'] ) || !isset( $_USER['boxes'] ))
    {
        if( !empty( $_USER['uid'] ))
        {
            $result = DB_query( "SELECT boxes,noboxes FROM {$_TABLES['userindex']} WHERE uid = '{$_USER['uid']}'" );
            list($_USER['boxes'], $_USER['noboxes']) = DB_fetchArray( $result );
        }
        else
        {
            $_USER['boxes'] = '';
            $_USER['noboxes'] = 0;
        }
    }

    if( $side == 'left' )
    {
        $sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) as date FROM {$_TABLES['blocks']} WHERE onleft = 1 AND is_enabled = 1";
    }
    else
    {
        $sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) as date FROM {$_TABLES['blocks']} WHERE onleft = 0 AND is_enabled = 1";
    }

    if( !empty( $topic ))
    {
        $sql .= " AND (tid = '$topic' OR (tid = 'all' AND type <> 'layout'))";
    }
    else
    {
        if( COM_isFrontpage() )
        {
            $sql .= " AND (tid = 'all' AND type <> 'layout')";
        }
        else
        {
            $sql .= " AND (tid = 'homeonly' OR (tid = 'all' AND type <> 'layout'))";
        }
    }

    if( !empty( $_USER['boxes'] ))
    {
        $BOXES = str_replace( ' ', ',', $_USER['boxes'] );

        $sql .= " AND (bid NOT IN ($BOXES) OR bid = '-1')";
    }

    $sql .= ' ORDER BY blockorder,title asc';

    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    // convert result set to an array of associated arrays
    $blocks = array();
    for( $i = 1; $i <= $nrows; $i++ )
    {
        $blocks[] = DB_fetchArray( $result );
    }

    // Check and see if any plugins have blocks to show
    $pluginBlocks = PLG_getBlocks( $side, $topic, $name );
    $blocks = array_merge( $blocks, $pluginBlocks );

    // sort the resulting array by block order
    $column = 'blockorder';
    $sortedBlocks = $blocks;
    for( $i = 0; $i < sizeof( $sortedBlocks )-1; $i++ ) 
    {
        for ($j=0; $j<sizeof($sortedBlocks)-1-$i; $j++)
        {
            if ($sortedBlocks[$j][$column] > $sortedBlocks[$j+1][$column]) 
            {
                $tmp = $sortedBlocks[$j];
                $sortedBlocks[$j] = $sortedBlocks[$j + 1];
                $sortedBlocks[$j + 1] = $tmp;
            }
        }
    }
    $blocks = $sortedBlocks;

    // Loop though resulting sorted array aand pass associative arays to COM_formatBlock
    foreach( $blocks as $A )
    {
        if( SEC_hasAccess( $A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']) > 0 or $A['type'] == 'dynamic' )
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
* @param        bool      $noboxes    Set to true if userpref is no blocks
* @return       string    HTML Formated block
*
*/
function COM_formatBlock( $A, $noboxes = false )
{
    global $_CONF, $_TABLES, $_USER, $LANG21, $topic, $page, $newstories;

    $retval = '';
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
        $retval .= COM_showBlock( $A['name'], $A['help'], $A['title'] );
    }

    if( $A['type'] == 'phpblock' && !$_USER['noboxes'] )
    {
        if( !( $A['name'] == 'whosonline_block' AND DB_getItem( $_TABLES['blocks'], 'is_enabled', "name='whosonline_block'" ) == 0 ))
        {
            $function = $A['phpblockfn'];
            $blkheader = COM_startBlock( $A['title'], $A['help'],
                    COM_getBlockTemplate( $A['name'], 'header' ));
            $blkfooter = COM_endBlock( COM_getBlockTemplate( $A['name'],
                    'footer' ));

            if( function_exists( $function ))
            {
                $fretval = $function();
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

    if( !empty( $A['content'] ) && !$_USER['noboxes'] )
    {
        $blockcontent = stripslashes( $A['content'] );

        // Hack: If the block content starts with a '<' assume it
        // contains HTML and do not call nl2br() which would only add
        // unwanted <br> tags.

        if( substr( $blockcontent, 0, 1 ) != '<' )
        {
            $blockcontent = nl2br( $blockcontent );
        }

        $retval .= COM_startBlock( $A['title'], $A['help'],
                       COM_getBlockTemplate( $A['name'], 'header' ))
                . $blockcontent . LB
                . COM_endBlock( COM_getBlockTemplate( $A['name'], 'footer' ));
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
* Rewritten December 19th 2004 by Michael Jervis (mike@fuckingbrit.com). Now
* utilises a Factory Pattern to open a URL and automaticaly retreive a feed
* object populated with feed data. Then import it into the portal block.
*
* @param    string  $bid            Block ID
* @param    string  $rdfurl         URL to get content from
* @param    int     $maxheadlines   Maximum number of headlines to display
* @return   void
* @see function COM_rdfCheck
*
*/
function COM_rdfImport( $bid, $rdfurl, $maxheadlines = 0 )
{
    global $_CONF, $_TABLES, $LANG21;

    // Import the feed handling classes:
    require_once( $_CONF['path_system']
                  . '/classes/syndication/parserfactory.class.php' );
    require_once( $_CONF['path_system']
                  . '/classes/syndication/feedparserbase.class.php' );

    // Load the actual feed handlers:
    $factory = new FeedParserFactory( $_CONF['path_system']
                                      . '/classes/syndication/' );
    $feed = $factory->reader( $rdfurl, $_CONF['default_charset'] );

    // Aquire a reader:
    if( $feed )
    {
        /* We have located a reader, and populated it with the information from
         * the syndication file. Now we will sort out our display, and update
         * the block.
         */
        if( $maxheadlines == 0 )
        {
            if( !empty( $_CONF['syndication_max_headlines'] ))
            {
                $maxheadlines = $_CONF['syndication_max_headlines'];
            }
            else
            {
                $maxheadlines = count( $feed->articles );
            }
        }

        $update = date( 'Y-m-d H:i:s' );
        $result = DB_change( $_TABLES['blocks'], 'rdfupdated', $update,
                                                 'bid', $bid );

        // format articles for display
        for( $i = 0; $i < $maxheadlines; $i++ )
        {
            if( empty( $feed->articles[$i]['title'] ))
            {
                $feed->articles[$i]['title'] = $LANG21[61];
            }

            $content = '<a href="' . $feed->articles[$i]['link'] . '">'
                     . $feed->articles[$i]['title'] . '</a>';
            $articles[] = $content;
        }

        // build a list
        $content = COM_makeList( $articles );
        $content = preg_replace( "/(\015\012)|(\015)|(\012)/", '', $content );

        // Standard theme based function to put it in the block
        $result = DB_change( $_TABLES['blocks'], 'content',
                             addslashes( $content ), 'bid', $bid );
    }
    else
    {
        // failed to aquire info, 0 out the block and log an error
        COM_errorLog( "Unable to aquire feed reader for $rdfurl", 1 );
        $result = DB_change( $_TABLES['blocks'], 'content',
                             addslashes( $LANG21[4] ), 'bid', $bid );
    }
}


/**
* Returns what HTML is allowed in content
*
* Returns what HTML tags the system allows to be used inside content.
* You can modify this by changing $_CONF['user_html'] in config.php
* (for admins, see also $_CONF['admin_html']).
*
* @param    string  $permissions    comma-separated list of rights which identify the current user as an "Admin"
* @param    boolean $list_only      true = return only the list of HTML tags
* @return   string  HTML <span> enclosed string
* @see function COM_checkHTML
*/
function COM_allowedHTML( $permissions = 'story.edit', $list_only = false )
{
    global $_CONF, $LANG01;

    $retval = '';
    if( !$list_only )
    {
        $retval .= '<span class="warningsmall">' . $LANG01[31] . ' ';
    }

    $allow_page_break = false;
    if( empty( $permissions ) || !SEC_hasRights( $permissions ) ||
            empty( $_CONF['admin_html'] ))
    {
        $html = $_CONF['user_html'];
    }
    else
    {
        $html = array_merge_recursive( $_CONF['user_html'],
                                       $_CONF['admin_html'] );
        if( $_CONF['allow_page_breaks'] == 1 )
        {
            $perms = explode( ',', $permissions );
            foreach( $perms as $p )
            {
                if( substr( $p, 0, 6 ) == 'story.' )
                {
                    $allow_page_break = true;
                    break;
                }
            }
        }
    }

    foreach( $html as $tag => $attr )
    {
        $retval .= '&lt;' . $tag . '&gt;, ';
    }

    $retval .= '[code]';

    if( $allow_page_break )
    {
        $retval .= ', [page_break]';
    }

    // list autolink tags
    $autotags = PLG_collectTags();
    foreach( $autotags as $tag => $module )
    {
        $retval .= ', [' . $tag . ':]';
    }

    if( !$list_only )
    {
        $retval .= '</span>';
    }

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
    $tmp = mysql_errno();
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
* @param    int  $uid  site member id
* @param    string  $username   Username, if this is set no lookup is done.
* @param    string  $fullname   Users full name.
* @param    string  $service    Remote login service.
* @return   string  Username, fullname or username@Service
*
*/
function COM_getDisplayName( $uid = '', $username='', $fullname='', $remoteusername='', $remoteservice='' )
{
    global $_CONF, $_TABLES, $_USER;

    if ($uid == '')
    {
        if( empty( $_USER['uid'] ) || ( $_USER['uid'] <= 1 ))
        {
            $uid = 1;
        }
        else
        {
            $uid = $_USER['uid'];
        }
    }

    if( empty( $username ))
    {
        $query = DB_query( "SELECT username, fullname, remoteusername, remoteservice FROM {$_TABLES['users']} WHERE uid='$uid'" );
        list( $username, $fullname, $remoteusername, $remoteservice ) = DB_fetchArray( $query );
    }

    if( !empty( $fullname ) && ($_CONF['show_fullname'] == 1 ))
    {
        return $fullname;
    }
    else if( $_CONF['remoteauthentication'] && $_CONF['show_servicename'] &&
                    !empty( $remoteusername ))
    {
        return "$remoteusername@$remoteservice";
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

    DB_query( "UPDATE {$_TABLES['vars']} SET value = value + 1 WHERE name = 'totalhits'" );
}

/**
* Returns the upcoming event block
*
* Returns the HTML for any upcoming events in the calendar
*
* @param        string      $help       Help file for block
* @param        string      $title      Title to be used in block header
* @return   string  HTML formatted block containing events.
*/

function COM_printUpcomingEvents( $help='', $title='' )
{
    global $_TABLES, $LANG01, $_CONF, $_USER;

    $range = $_CONF['upcomingeventsrange'];
    if( $range == 0 )
    {
        $range = 14; // fallback: 14 days
    }
    $dateonly = $_CONF['dateonly'];
    if( empty( $dateonly ))
    {
        $dateonly = '%d-%b'; // fallback: day - abbrev. month name
    }

    if( empty( $title ))
    {
        $title = DB_getItem( $_TABLES['blocks'], 'title', "name = 'events_block'" );
    }

    $retval = COM_startBlock( $title, $help,
                       COM_getBlockTemplate( 'events_block', 'header' ));

    $eventSql = 'SELECT eid,title,url,datestart,dateend,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon '
        . "FROM {$_TABLES['events']} "
        . "WHERE dateend >= NOW() AND (TO_DAYS(datestart) - TO_DAYS(NOW()) < $range) "
        . 'ORDER BY datestart,timestart';

    $personaleventsql = 'SELECT eid,title,url,datestart,dateend,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon '
        . "FROM {$_TABLES['personal_events']} "
        . "WHERE uid = {$_USER['uid']} AND dateend >= NOW() AND (TO_DAYS(datestart) - TO_DAYS(NOW()) < $range) "
        . 'ORDER BY datestart, dateend';

    $allEvents = DB_query( $eventSql );
    $numRows = DB_numRows( $allEvents );
    $totalrows = $numRows;

    $numDays = 0;          // Without limits, I'll force them.
    $theRow = 1;           // Start with today!
    $oldDate1 = 'no_day';  // Invalid Date!
    $oldDate2 = 'last_d';  // Invalid Date!

    if( $_CONF['personalcalendars'] == 1 AND !empty( $_USER['uid'] ))
    {
        $iterations = 2;
    }
    else
    {
        $iterations = 1;
    }

    $eventsFound = 0;
    $skipFirstBreak = false;

    for( $z = 1; $z <= $iterations; $z++ )
    {
        if( $z == 2 )
        {
            $allEvents = DB_query( $personaleventsql );
            $numRows = DB_numRows( $allEvents );
            $totalrows = $totalrows + $numRows;

            $numDays = 0;          // Without limits, I'll force them.
            $theRow = 1;           // Start with today!
            $oldDate1 = 'no_day';  // Invalid Date!
            $oldDate2 = 'last_d';  // Invalid Date!
            $classname = 'list-personal-events';
            $headline = false;
        }
        else
        {
            $classname = 'list-site-events';
            $headline = false;
        }
        if( $_CONF['personalcalendars'] == 0 )
        {
            $headline = true; // no headline needed
            $skipFirstBreak = true;
        }

        while( $theRow <= $numRows AND $numDays < $range )
        {
            // Retreive the next event, and format the start date.
            $theEvent = DB_fetchArray( $allEvents );

            if( SEC_hasAccess( $theEvent['owner_id'], $theEvent['group_id'], $theEvent['perm_owner'], $theEvent['perm_group'], $theEvent['perm_members'], $theEvent['perm_anon'] ) > 0 )
            {
                $eventsFound++;

                if( !$headline )
                {
                    if($z == 2)
                    {
                        if( $numRows > 0 )
                        {
                            $retval .= '<p><b>' . $LANG01[101] . '</b><br>';
                        }
                    }
                    else
                    {
                        if( $totalrows > 0 )
                        {
                            $retval .= '<b>' . $LANG01[102] . '</b><br>';
                        }
                    }

                    $headline = true;
                }

                // Start Date strings...
                $startDate = $theEvent['datestart'];
                $theTime1 = strtotime( $startDate );
                $dayName1 = strftime( '%A', $theTime1 );
                $abbrDate1 = strftime( $dateonly, $theTime1 );

                // End Date strings...
                $endDate = $theEvent['dateend'];
                $theTime2 = strtotime( $endDate );
                $dayName2 = strftime( '%A', $theTime2 );
                $abbrDate2 = strftime( $dateonly, $theTime2 );

                $todaysEvent = false;
                if( date( 'Ymd', $theTime1 ) == date( 'Ymd', time()))
                {
                    $todaysEvent = true;
                    if( $z == 2 )
                    {
                        $todaysClassName = 'personal-event-today';
                    }
                    else
                    {
                        $todaysClassName = 'site-event-today';
                    }
                }

                // If either of the dates [start/end] change, then display a new header.
                if( $oldDate1 != $abbrDate1 OR $oldDate2 != $abbrDate2 )
                {
                    $oldDate1 = $abbrDate1;
                    $oldDate2 = $abbrDate2;
                    $numDays ++;

                    if( $numDays < $range )
                    {
                        if( !empty( $newevents ))
                        {
                             $retval .= COM_makeList( $newevents, $classname );
                        }

                        if( $skipFirstBreak )
                        {
                            $skipFirstBreak = false;
                        }
                        else
                        {
                            $retval .= '<br>';
                        }
                        if( $todaysEvent )
                        {
                            $retval .= '<span class="' . $todaysClassName
                                    . '">';
                        }
                        $retval .= '<b>' . $dayName1 . '</b>&nbsp;<small>'
                                . $abbrDate1 . '</small>';

                        // If different start and end dates, then display end date:
                        if( $abbrDate1 != $abbrDate2 )
                        {
                            $retval .= ' - <br><b>' . $dayName2 . '</b>&nbsp;<small>' . $abbrDate2 . '</small>';
                        }
                        if( $todaysEvent )
                        {
                            $retval .= '</span>';
                        }
                    }

                    $newevents = array();
                }

                // Now display this event record.
                if( $numDays < $range )
                {
                    // Display the url now!
                    $newevent = '<a href="' . $_CONF['site_url']
                              . '/calendar_event.php?';

                    if( $z == 2 )
                    {
                        $newevent .= 'mode=personal&amp;';
                    }

                    $newevent .= 'eid=' . $theEvent['eid'] . '"';
                    if( $todaysEvent )
                    {
                        $newevent .= ' class="' . $todaysClassName . '"';
                    }
                    $newevent .= '>' . stripslashes( $theEvent['title'] )
                              . '</a>';
                    $newevents[] = $newevent;
                }

                if( !empty( $newevents ))
                {
                    $retval .= COM_makeList( $newevents, $classname );
                    $newevents = array();
                }
            }

            $theRow++;
        }
    } // end for z

    if( $eventsFound == 0 )
    {
        // There aren't any upcoming events, show a nice message
        $retval .= $LANG01[89];
    }

    $retval .= COM_endBlock( COM_getBlockTemplate( 'events_block', 'footer' ));

    return $retval;
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
    global $_CONF, $_TABLES, $LANG08, $LANG24;

    $subject = strip_tags( $_CONF['site_name'] . $LANG08[30] . strftime( '%Y-%m-%d', time() ));

    $authors = array();

    // Get users who want stories emailed to them
    $usersql = "SELECT username,email,etids,{$_TABLES['users']}.uid AS uuid "
        . "FROM {$_TABLES['users']}, {$_TABLES['userindex']} "
        . "WHERE {$_TABLES['users']}.uid > 1 AND {$_TABLES['userindex']}.uid = {$_TABLES['users']}.uid AND (etids <> '-') ORDER BY {$_TABLES['users']}.uid";

    $users = DB_query( $usersql );
    $nrows = DB_numRows( $users );

    $lastrun = DB_getItem( $_TABLES['vars'], 'value', "name = 'lastemailedstories'" );

    // For each user, pull the stories they want and email it to them
    for( $x = 1; $x <= $nrows; $x++ )
    {
        $U = DB_fetchArray( $users );

        $storysql = "SELECT sid,uid,date AS day,title,introtext,bodytext "
            . "FROM {$_TABLES['stories']} "
            . "WHERE draft_flag = 0 AND date <= NOW() AND date >= '{$lastrun}'";

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
        for( $i = 1; $i <= $trows; $i++ )
        {
            $T = DB_fetchArray( $tresult );
            $TIDS[] = $T['tid'];
        }

        if( !empty( $U['etids'] ))
        {
            $ETIDS = explode( ' ', $U['etids'] );
            $TIDS = array_intersect( $TIDS, $ETIDS );
        }

        if( sizeof( $TIDS ) > 0)
        {
            $storysql .= " AND (tid IN ('" . implode( "','", $TIDS ) . "'))";
        }

        $storysql .= COM_getPermSQL( 'AND', $U['uuid'] );
        $storysql .= ' ORDER BY featured DESC, date DESC';

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
                    $storyauthor = DB_getItem( $_TABLES['users'], 'username', "uid = '{$S['uid']}'" );
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
                $storytext = COM_undoSpecialChars( strip_tags( PLG_replaceTags( stripslashes( $S['introtext'] ))));

                if( $_CONF['emailstorieslength'] > 1 )
                {
                   if( strlen( $storytext ) > $_CONF['emailstorieslength'] )
                   {
                       $storytext = substr( $storytext, 0, $_CONF['emailstorieslength'] ) . '...';
                   }
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

        COM_mail( $mailto, $subject, $mailtext );
    }

    DB_query( "UPDATE {$_TABLES['vars']} SET value = NOW() WHERE name = 'lastemailedstories'" );
}

/**
* Shows any new information in a block
*
* Return the HTML that shows any new stories, comments, etc
*
* @param    string  $help   Help file for block
* @param    string  $title  Title used in block header
* @return   string  Return the HTML that shows any new stories, comments, etc
*
*/

function COM_whatsNewBlock( $help = '', $title = '' )
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG_WHATSNEW, $page, $newstories;

    $retval = COM_startBlock( $title, $help,
                       COM_getBlockTemplate( 'whats_new_block', 'header' ));

    $topicsql = '';
    if(( $_CONF['hidenewstories'] == 0 ) || ( $_CONF['hidenewcomments'] == 0 )
            || ( $_CONF['trackback_enabled']
            && ( $_CONF['hidenewtrackbacks'] == 0 )))
    {
        $topicsql = COM_getTopicSql ('AND', 0, $_TABLES['stories']);
    }

    if( $_CONF['hidenewstories'] == 0 )
    {
        // Find the newest stories
        $sql = "SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE (date >= (date_sub(NOW(), INTERVAL {$_CONF['newstoriesinterval']} SECOND))) AND (date <= NOW()) AND (draft_flag = 0)" . COM_getPermSQL( 'AND' ) . $topicsql;
        $result = DB_query( $sql );
        $A = DB_fetchArray( $result );
        $nrows = $A['count'];

        if( empty( $title ))
        {
            $title = DB_getItem( $_TABLES['blocks'], 'title', "name='whats_new_block'" );
        }

        // Any late breaking news stories?
        $retval .= '<b>' . $LANG01[99] . '</b><br>';

        if( $nrows > 0 )
        {
            $newmsg .= COM_formatTimeString( $LANG_WHATSNEW['new_string'],
                        $_CONF['newstoriesinterval'], $LANG01[11], $nrows);

            if( $newstories && ( $page < 2 ))
            {
                $retval .= $newmsg . '<br>';
            }
            else
            {
                $retval .= '<a href="' . $_CONF['site_url']
                    . '/index.php?display=new">' . $newmsg . '</a><br>';
            }
        }
        else
        {
            $retval .= $LANG01[100] . '<br>';
        }

        if(( $_CONF['hidenewcomments'] == 0 ) || ( $_CONF['trackback_enabled']
                && ( $_CONF['hidenewtrackbacks'] == 0 ))
                || ( $_CONF['hidenewplugins'] == 0 ))
        {
            $retval .= '<br>';
        }
    }

    if( $_CONF['hidenewcomments'] == 0 )
    {
        // Go get the newest comments
        $retval .= '<b>' . $LANG01[83] . '</b> <small>'
                . COM_formatTimeString( $LANG_WHATSNEW['new_last'],
                                        $_CONF['newcommentsinterval'] )
                . '</small><br>';

        $stwhere = '';

        if( !empty( $_USER['uid'] ))
        {
            $stwhere .= "({$_TABLES['stories']}.owner_id IS NOT NULL AND {$_TABLES['stories']}.perm_owner IS NOT NULL) OR ";
            $stwhere .= "({$_TABLES['stories']}.group_id IS NOT NULL AND {$_TABLES['stories']}.perm_group IS NOT NULL) OR ";
            $stwhere .= "({$_TABLES['stories']}.perm_members IS NOT NULL)";
        }
        else
        {
            $stwhere .= "({$_TABLES['stories']}.perm_anon IS NOT NULL)";
        }
        $sql = "SELECT DISTINCT count(*) AS dups, type, {$_TABLES['stories']}.title, {$_TABLES['stories']}.sid, max({$_TABLES['comments']}.date) as lastdate FROM {$_TABLES['comments']} LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid)" . COM_getPermSQL( 'AND', 0, 2, $_TABLES['stories'] ) . " AND ({$_TABLES['stories']}.draft_flag = 0)" . $topicsql . ") WHERE ({$_TABLES['comments']}.date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newcommentsinterval']} SECOND))) AND ((({$stwhere}))) GROUP BY {$_TABLES['comments']}.sid ORDER BY 5 DESC LIMIT 15";

        $result = DB_query( $sql );

        $nrows = DB_numRows( $result );

        if( $nrows > 0 )
        {
            $newcomments = array();

            for( $x = 0; $x < $nrows; $x++ )
            {
                $A = DB_fetchArray( $result );

                if(( $A['type'] == 'article' ) || empty( $A['type'] ))
                {
                    $titletouse = stripslashes( $A['title'] );
                    $itemlen = strlen( $titletouse );
                    $urlstart = '<a href="' . COM_buildUrl( $_CONF['site_url']
                        . '/article.php?story=' . $A['sid'] ) . '#comments' . '"';
                }

                // Trim the length if over 20 characters
                if( $itemlen > 20 )
                {
                    $urlstart .= ' title="' . htmlspecialchars( $titletouse ) . '">';
                    $titletouse = substr( $titletouse, 0, 17 ) . '...';
                }
                else
                {
                    $urlstart .= '>';
                }

                $acomment = str_replace( '$', '&#36;', $titletouse );
                $acomment = str_replace( ' ', '&nbsp;', $acomment );

                if( $A['dups'] > 1 )
                {
                    $acomment .= ' [+' . $A['dups'] . ']';
                }

                $newcomments[] = $urlstart . $acomment . '</a>';
            }

            $retval .= COM_makeList( $newcomments, 'list-new-comments' );
        }
        else
        {
            $retval .= $LANG01[86] . '<br>' . LB;
        }
        if(( $_CONF['hidenewplugins'] == 0 )
                || ( $_CONF['trackback_enabled']
                && ( $_CONF['hidenewtrackbacks'] == 0 )))
        {
            $retval .= '<br>';
        }
    }

    if( $_CONF['trackback_enabled'] && ( $_CONF['hidenewtrackbacks'] == 0 ))
    {
        $retval .= '<b>' . $LANG01[114] . '</b> <small>'
                . COM_formatTimeString( $LANG_WHATSNEW['new_last'],
                                        $_CONF['newtrackbackinterval'] )
                . '</small><br>';

        $sql = "SELECT DISTINCT COUNT(*) AS count,{$_TABLES['stories']}.title,t.sid FROM {$_TABLES['trackback']} AS t,{$_TABLES['stories']} WHERE (t.type = 'article') AND (t.sid = {$_TABLES['stories']}.sid) AND (t.date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newtrackbackinterval']} SECOND)))" . COM_getPermSQL( 'AND', 0, 2, $_TABLES['stories'] ) . " AND ({$_TABLES['stories']}.draft_flag = 0)" . $topicsql . " GROUP BY t.sid ORDER BY t.date DESC LIMIT 15";
        $result = DB_query( $sql );

        $nrows = DB_numRows( $result );
        if( $nrows > 0 )
        {
            $newcomments = array();

            for( $i = 0; $i < $nrows; $i++ )
            {
                $A = DB_fetchArray( $result );

                $titletouse = stripslashes( $A['title'] );
                $itemlen = strlen( $titletouse );
                $urlstart = '<a href="' . COM_buildUrl( $_CONF['site_url']
                    . '/article.php?story=' . $A['sid'] ) . '#trackback' . '"';

                // Trim the length if over 20 characters
                if( $itemlen > 20 )
                {
                    $urlstart .= ' title="' . htmlspecialchars( $titletouse ) . '">';
                    $titletouse = substr( $titletouse, 0, 17 ) . '...';
                }
                else
                {
                    $urlstart .= '>';
                }

                $acomment = str_replace( '$', '&#36;', $titletouse );
                $acomment = str_replace( ' ', '&nbsp;', $acomment );

                if( $A['count'] > 1 )
                {
                    $acomment .= ' [+' . $A['count'] . ']';
                }

                $newcomments[] = $urlstart . $acomment . '</a>';
            }

            $retval .= COM_makeList( $newcomments, 'list-new-trackbacks' );
        }
        else
        {
            $retval .= $LANG01[115] . '<br>' . LB;
        }
        if( $_CONF['hidenewplugins'] == 0 )
        {
            $retval .= '<br>';
        }
    }

    if( $_CONF['hidenewplugins'] == 0 )
    {
        list( $headlines, $smallheadlines, $content ) = PLG_getWhatsNew();
        $plugins = sizeof( $headlines );
        if( $plugins > 0 )
        {
            for( $i = 0; $i < $plugins; $i++ )
            {
                $retval .= '<b>' . $headlines[$i] . '</b> <small>'
                        . $smallheadlines[$i] . '</small><br>';
                if( is_array( $content[$i] ))
                {
                    $retval .= COM_makeList( $content[$i], 'list-new-plugins' );
                }
                else
                {
                    $retval .= $content[$i] . '<br>' . LB;
                }

                if( $i + 1 < $plugins )
                {
                    $retval .= '<br>';
                }
            }
        }
    }

    $retval .= COM_endBlock( COM_getBlockTemplate( 'whats_new_block', 'footer' ));

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
function COM_formatTimeString( $time_string, $time, $type = '', $amount = 0 )
{
    global $LANG_WHATSNEW;

    $retval = $time_string;

    // This is the amount you have to divide the previous by to get the
    // different time intervals: hour, day, week, months
    $time_divider = array ( 60, 60, 24, 7, 30 );

    // These are the respective strings to the numbers above. They have to match
    // the strings in $LANG_WHATSNEW (i.e. these are the keys for the array -
    // the actual text strings are taken from the language file).
    $times_description = array ( 'minutes', 'hours', 'days', 'weeks', 'months' );
    $time_description = array ( 'minute', 'hour', 'day', 'week', 'month' );

    for ( $s = 0; $s < count( $time_divider ); $s++ )
    {
        $time = $time / $time_divider[$s];
        if ( $time < $time_divider[$s + 1] )
        {
            if ( $time == 1 )
            {
                $time_str = $time_description[$s];
            }
            else
            {
                $time_str = $times_description[$s];
            }
            $fields = array( '%n', '%i', '%t', '%s' );
            $values = array( $amount, $type, $time, $LANG_WHATSNEW[$time_str] );
            $retval = str_replace( $fields, $values, $retval );
            break;
        }
    }

    return $retval;
}


/**
* Displays a message on the webpage
*
* Pulls $msg off the URL string and gets the corresponding message and returns
* it for display on the calling page
*
* @param      int     $msg        ID of message to show
* @param      string  $plugin     Optional Name of plugin to lookup plugin defined message
* @return     string  HTML block with message
*/

function COM_showMessage( $msg, $plugin='' )
{
    global $_CONF, $MESSAGE, $_IMAGE_TYPE;

    $retval = '';

    if( $msg > 0 )
    {
        if( !empty( $plugin ))
        {
            $var = 'PLG_' . $plugin . '_MESSAGE' . $msg;
            global $$var;
            if( isset( $$var ))
            {
                $message = $$var;
            }
            else
            {
                $message = sprintf( $MESSAGE[61], $plugin );
            }
        }
        else
        {
            $message = $MESSAGE[$msg];
        }

        $timestamp = strftime( $_CONF['daytime'] );
        $retval .= COM_startBlock( $MESSAGE[40] . ' - ' . $timestamp, '',
                           COM_getBlockTemplate( '_msg_block', 'header' ))
            . '<table><tr><td><img src="' . $_CONF['layout_url']
            . '/images/sysmessage.' . $_IMAGE_TYPE
            . '" border="0" align="top" alt=""></td>'
            . '<td style="padding:5px;">' . $message . '</td></tr></table>'
            . COM_endBlock( COM_getBlockTemplate( '_msg_block', 'footer' ));
    }

    return $retval;
}


/**
* Prints Google(tm)-like paging navigation
*
* @param        string      $base_url       base url to use for all generated links
* @param        int         $curpage        current page we are on
* @param        int         $num_pages      Total number of pages
* @param        string      $page_str       page-variable name AND '='
* @param        bool        $do_rewrite     if true, url-rewriting is respected
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

    if( $num_pages < 2 )
    {
        return;
    }

    if( !$do_rewrite )
    {
        $hasargs = strstr( $base_url, '?' );
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
        $retval .= '<a href="' . $base_url . '">' . $LANG05[7] . '</a> | ';
        $pg = '';
        if( ( $curpage - 1 ) > 1 )
        {
            $pg = $sep . $page_str . ( $curpage - 1 );
        }
        $retval .= '<a href="' . $base_url . $pg . '">' . $LANG05[6]
                . '</a> | ';
    }
    else
    {
        $retval .= $LANG05[7] . ' | ' ;
        $retval .= $LANG05[6] . ' | ' ;
    }

    for( $pgcount = ( $curpage - 10 ); ( $pgcount <= ( $curpage + 9 )) AND ( $pgcount <= $num_pages ); $pgcount++ )
    {
        if( $pgcount <= 0 )
        {
            $pgcount = 1;
        }

        if( $pgcount == $curpage )
        {
            $retval .= '<b>' . $pgcount . '</b> ';
        }
        else
        {
            $pg = '';
            if( $pgcount > 1 )
            {
                $pg = $sep . $page_str . $pgcount;
            }
            $retval .= '<a href="' . $base_url . $pg . '">' . $pgcount
                    . '</a> ';
        }
    }

    if( !empty( $open_ended ))
    {
        $retval .= '| ' . $open_ended;
    }
    else if( $curpage == $num_pages )
    {
        $retval .= '| ' . $LANG05[5] . ' ';
        $retval .= '| ' . $LANG05[8];
    }
    else
    {
        $retval .= '| <a href="' . $base_url . $sep . $page_str
                . ( $curpage + 1 ) . '">' . $LANG05[5] . '</a> ';
        $retval .= '| <a href="' . $base_url . $sep . $page_str . $num_pages
                . '">' . $LANG05[8] . '</a>';
    }

    if( !empty( $retval ))
    {
        if( !empty( $msg ))
        {
            $msg .=  ' ';
        }
        $retval = '<div class="pagenav">' . $msg . $retval . '</div>';
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

    if( $_USER['uid'] > 1 )
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

    if( empty( $_USER ))
    {
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
    global $_CONF, $_TABLES, $_USER, $LANG01, $_IMAGE_TYPE;

    $retval = '';

    $expire_time = time() - $_CONF['whosonline_threshold'];

    if( $_CONF['show_fullname'] == 1 )
    {
        $byname = 'fullname,username';
    }
    else
    {
        $byname = 'username';
    }
    if( $_CONF['remoteauthentication'] )
    {
        $byname .= ',remoteusername,remoteservice';
    }

    $result = DB_query( "SELECT DISTINCT {$_TABLES['sessions']}.uid,{$byname},photo,showonline FROM {$_TABLES['sessions']},{$_TABLES['users']},{$_TABLES['userprefs']} WHERE {$_TABLES['users']}.uid = {$_TABLES['sessions']}.uid AND {$_TABLES['users']}.uid = {$_TABLES['userprefs']}.uid AND start_time >= $expire_time AND {$_TABLES['sessions']}.uid <> 1 ORDER BY {$byname}" );
    $nrows = DB_numRows( $result );

    $num_anon = 0;
    $num_reg  = 0;

    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );

        if( $A['showonline'] == 1 )
        {
            $username = COM_getDisplayName( $A['uid'], $A['username'], $A['fullname'], $A['remoteusername'], $A['remoteservice']);
            $retval .= '<a href="' . $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $A['uid'] . '">'
                    . $username . '</a>';

            if( !empty( $A['photo'] ) AND $_CONF['allow_user_photo'] == 1)
            {
                $retval .= '&nbsp;<a href="' . $_CONF['site_url']
                        . '/users.php?mode=profile&amp;uid=' . $A['uid']
                        . '"><img src="' . $_CONF['layout_url']
                        . '/images/smallcamera.' . $_IMAGE_TYPE
                        . '" border="0" alt=""></a>';
            }
            $retval .= '<br>';
            $num_reg++;
        }
        else
        {
            // this user does not want to show up in Who's Online
            $num_anon++; // count as anonymous
        }
    }

    $result = DB_query( "SELECT DISTINCT uid,remote_ip FROM {$_TABLES['sessions']} WHERE uid = 1" );
    $num_anon += DB_numRows( $result );

    if(( $_CONF['whosonline_anonymous'] == 1 ) &&
            ( empty( $_USER['uid'] ) || ( $_USER['uid'] == 1 )))
    {
        // note that we're overwriting the contents of $retval here
        if( $num_reg > 0 )
        {
            $retval = $LANG01[112] . ': ' . $num_reg . '<br>';
        }
        else
        {
            $retval = '';
        }
    }

    if( $num_anon > 0 )
    {
        $retval .= $LANG01[41] . ': ' . $num_anon . '<br>';
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
    global $LANG30;

    $month_options = '';

    for( $i = 1; $i <= 12; $i++ )
    {
        if( $i < 10 )
        {
            $mval = '0' . $i;
        }
        else
        {
            $mval = $i;
        }

        $month_options .= '<option value="' . $mval . '" ';

        if( $i == $selected )
        {
            $month_options .= 'selected="selected"';
        }

        $month_options .= '>' . $LANG30[$mval + 12] . '</option>';
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

        $day_options .= '<option value="' . $dval . '" ';

        if( $i == $selected )
        {
            $day_options .= 'selected="selected"';
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
* @param        string      $selected       Selected year
* @see function COM_getMonthFormOptions
* @see function COM_getDayFormOptions
* @see function COM_getHourFormOptions
* @see function COM_getMinuteFormOptions
* @return string  HTML years as option values
*/

function COM_getYearFormOptions( $selected = '' )
{
    $year_options = '';
    $cur_year = date( 'Y', time() );
    $start_year = $cur_year;

    if( !empty( $selected ))
    {
        if( $selected < $cur_year )
        {
            $start_year = $selected;
        }
    }

    for( $i = $start_year - 1; $i <= $cur_year + 5; $i++ )
    {
        $year_options .= '<option value="' . $i . '" ';

        if( $i == $selected )
        {
            $year_options .= 'selected="selected"';
        }

        $year_options .= '>' . $i . '</option>';
    }

    return $year_options;
}

/**
* Gets the <option> values for clock hours
*
* @param        string      $selected       Selected hour
* @see function COM_getMonthFormOptions
* @see function COM_getDayFormOptions
* @see function COM_getYearFormOptions
* @see function COM_getMinuteFormOptions
* @return string    HTML string of options
*/

function COM_getHourFormOptions( $selected = '' )
{
    $hour_options = '';

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
            $hour_options .= '<option value="12" ';

            if( $selected == 12 )
            {
                $hour_options .= 'selected="selected"';
            }

            $hour_options .= '>12</option>';
        }

        $hour_options .= '<option value="' . $hval . '" ';

        if( $selected == $i )
        {
            $hour_options .= 'selected="selected"';
        }

        $hour_options .= '>' . $i . '</option>';
    }

    return $hour_options;
}

/**
* Gets the <option> values for clock minutes
*
* @param        string      $selected       Selected minutes
* @see function COM_getMonthFormOptions
* @see function COM_getDayFormOptions
* @see function COM_getHourFormOptions
* @see function COM_getYearFormOptions
* @return string  HTML of option minutes
*/

function COM_getMinuteOptions( $selected = '' )
{
    $minute_options = '';

    for( $i = 0; $i <= 59; $i++ )
    {
        if( $i < 10 )
        {
            $mval = '0' . $i;
        }
        else
        {
            $mval = $i;
        }

        $minute_options .= '<option value="' . $mval . '" ';

        if( $selected == $i )
        {
            $minute_options .= 'selected="selected"';
        }

        $minute_options .= '>' . $mval . '</option>';
    }

    return $minute_options;
}

/**
* Creates an HTML unordered list from the given array.
* It formats one list item per array element, using the list.thtml
* and listitem.thtml templates.
*
* @param        array       $listofitems        Items to list out
* @return   string  HTML unordered list of array items
*/

function COM_makeList( $listofitems, $classname = '' )
{
    global $_CONF;

    $list = new Template( $_CONF['path_layout'] );
    $list->set_file( array( 'list'     => 'list.thtml',
                            'listitem' => 'listitem.thtml' ));
    $list->set_var( 'site_url', $_CONF['site_url'] );
    $list->set_var( 'layout_url', $_CONF['layout_url'] );
    if( empty( $classname ))
    {
        $list->set_var( 'list_class', '' );
        $list->set_var( 'list_class_name', '' );
    }
    else
    {
        $list->set_var( 'list_class', 'class="' . $classname . '"' );
        $list->set_var( 'list_class_name', $classname );
    }

    foreach( $listofitems as $oneitem )
    {
        $list->set_var( 'list_item', $oneitem );
        $list->parse( 'list_items', 'listitem', true );
    }

    $list->parse( 'newlist', 'list', true );

    return $list->finish( $list->get_var( 'newlist' ));
}

/**
* Check if speed limit applies for current IP address.
*
* @param type   string   type of speed limit to check, e.g. 'submit', 'comment'
* @param max    int      max number of allowed tries within speed limit
* @return       int      0 = does not apply, else: seconds since last post
*/
function COM_checkSpeedlimit( $type = 'submit', $max = 1 )
{
    global $_TABLES;

    $last = 0;

    $res  = DB_query( "SELECT date FROM {$_TABLES['speedlimit']} WHERE (type = '$type') AND (ipaddress = '{$_SERVER['REMOTE_ADDR']}') ORDER BY date ASC" );

    // If the number of allowed tries has not been reached,
    // return 0 (didn't hit limit)
    if( DB_numRows( $res ) < $max )
    {
        return $last;
    }

    list( $date ) = DB_fetchArray( $res );

    if( !empty( $date ))
    {
        $last = time() - $date;
        if( $last == 0 )
        {
            // just in case someone manages to submit something in < 1 sec.
            $last = 1;
        }
    }

    return $last;
}

/**
* Store post info for current IP address.
*
* @param type   string   type of speed limit, e.g. 'submit', 'comment'
*
*/
function COM_updateSpeedlimit( $type = 'submit' )
{
    global $_TABLES;

    DB_save( $_TABLES['speedlimit'], 'ipaddress,date,type',
             "'{$_SERVER['REMOTE_ADDR']}',unix_timestamp(),'$type'" );
}

/**
* Clear out expired speed limits, i.e. entries older than 'x' seconds
*
* @param speedlimit   int      number of seconds
* @param type         string   type of speed limit, e.g. 'submit', 'comment'
*
*/
function COM_clearSpeedlimit( $speedlimit = 60, $type = '' )
{
    global $_TABLES;

    $sql = "DELETE FROM {$_TABLES['speedlimit']} WHERE ";
    if( !empty( $type ))
    {
        $sql .= "(type = '$type') AND ";
    }
    $sql .= "(date < unix_timestamp() - $speedlimit)";
    DB_query( $sql );
}

/**
* Wrapper function for URL class so as to not confuse people as this will
* eventually get used all over the place
*
* This function returns a crawler friendly URL (if possible)
*
* @param        string      $url        URL to try to build crawler friendly URL for
* @return   string      Rewritten URL
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
        if( empty( $_USER['uid'] ))
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
    if(( empty( $_USER['uid'] ) && ( $uid == 1 )) || ( $uid == $_USER['uid'] ))
    {
        if( empty( $_GROUPS ))
        {
            $_GROUPS = SEC_getUserGroups( $uid );
        }
        $GROUPS = $_GROUPS;
    }
    else
    {
        $GROUPS = SEC_getUserGroups( $uid );
    }

    if( empty( $_GROUPS ))
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

        $sql .= "(({$table}group_id IN (" . implode( ',', $_GROUPS )
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

    if(( $u_id <= 0 ) || ( $u_id == $_USER['uid'] ))
    {
        $uid = $_USER['uid'];
        $GROUPS = $_GROUPS;
    }
    else
    {
        $uid = $u_id;
        $GROUPS = SEC_getUserGroups( $uid );
    }

    if( empty( $_GROUPS ))
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

    if( sizeof( $tids ) > 0 )
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
function COM_stripslashes( $text )
{
    if( get_magic_quotes_gpc() == 1 )
    {
        return( stripslashes( $text ));
    }

    return( $text );
}

/**
* Filter parameters passed per GET (URL) or POST.
*
* @param    string    $parameter   the parameter to test
* @param    boolean   $isnumeric   true if $parameter is supposed to be numeric
* @return   string    the filtered parameter (may now be empty or 0)
*
*/
function COM_applyFilter( $parameter, $isnumeric = false )
{
    $log_manipulation = false; // set to true to log when the filter applied

    $p = COM_stripslashes( $parameter );
    $p = strip_tags( $p );
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
* Detect links in a plain-ascii text and turn them into clickable links.
* Will detect links starting with "http:", "https:", "ftp:", and "www.".
*
* Derived from a newsgroup posting by Andreas Schwarz in
* news:de.comp.lang.php <aieq4p$12jn2i$3@ID-16486.news.dfncis.de>
*
* @param    string    $text     the (plain-ascii) text string
* @return   string    the same string, with links enclosed in <a>...</a> tags
*
*/
function COM_makeClickableLinks( $text )
{
    $text = preg_replace( '/([^"]?)((((ht|f)tps?):(\/\/)|www\.)[a-z0-9%&_\-\+,;=:@~#\/.\?\[\]]+(\/|[+0-9a-z]))/is', '\\1<a href="\\2">\\2</a>', $text );
    $text = str_replace( '<a href="www', '<a href="http://www', $text );

    return $text;
}

/**
* Undo the conversion of URLs to clickable links (in plain text posts),
* e.g. so that we can present the user with the post as they entered them.
*
* @param    string  $txt    story text
* @param    string          story text without links
*
*/
function COM_undoClickableLinks( $text )
{
    $text = preg_replace( '/<a href="[^"]*">([^<]*)<\/a>/', '\1', $text );

    return $text;
}

/**
* Highlight the words from a search query in a given text string.
*
* @param    string  $text   the text
* @param    string  $query  the search query
* @return   string          the text with highlighted search words
*
*/
function COM_highlightQuery( $text, $query )
{
    $query = str_replace( '+', ' ', $query );

    // escape all the other PCRE special characters
    $query = preg_quote( $query );

    $mywords = explode( ' ', $query );
    foreach( $mywords as $searchword )
    {
        if( !empty( $searchword ))
        {
            $text = preg_replace( '/(\>(((?>[^><]+)|(?R))*)\<)/ie', "preg_replace('/(?>$searchword+)/i','<span class=\"highlight\">$searchword</span>','\\0')", '<x>' . $text . '<x>' );
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
* @author Tony Bibbs <tony.bibbs@iowa.gov
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
* @return   bool    true = we're on the frontpage, false = we're not
*
*/
function COM_isFrontpage()
{
    global $_CONF, $topic, $page, $newstories;

    // Note: We can't use $PHP_SELF here since the site may not be in the
    // DocumentRoot
    $isFrontpage = false;

    // on a Zeus webserver, prefer PATH_INFO over SCRIPT_NAME
    if( empty( $_SERVER['PATH_INFO'] ))
    {
        $scriptName = $_SERVER['SCRIPT_NAME'];
    }
    else
    {
        $scriptName = $_SERVER['PATH_INFO'];
    }

    preg_match( '/\/\/[^\/]*(.*)/', $_CONF['site_url'], $pathonly );
    if(( $scriptName <> $pathonly[1] . '/index.php' ) OR
            !empty( $topic ) OR ( $page > 1 ) OR $newstories )
    {
        $isFrontpage = true;
    }

    return $isFrontpage;
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

/** Converts a number for output into a formatted number with thousands-
*         separator, comma-separator and fixed decimals if necessary
*
*        @param        float        $number        Number that will be formatted
*        @return        string                        formatted number
*/
function COM_NumberFormat( $number )
{
    global $_CONF;

    if( $number - abs( $number ) > 0 ) // number has decimals
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
    // Breakup the string using either a space, fwd slash, bkwd slash or
    // colon as a delimiter
    $atok = strtok( $date, ' /-\\:' );
    while( $atok !== FALSE )
    {
        $atoks[] = $atok;
        $atok = strtok( ' /-\\:' );  // get the next token
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
    $dimensions = GetImageSize( $file );
    if( !empty( $dimensions[0] ) AND !empty( $dimensions[1] ))
    {
        $sizeattributes = 'width="' . $dimensions[0]
                        . '" height="' . $dimensions[1] . '" ';
    }
    else
    {
        $sizeattributes = '';
    }

    return $sizeattributes;
}

/**
* Display a message and abort
*
* @param    int     $msg            message number
* @param    string  $plugin         plugin name, if applicable
* @param    int     $http_status    HTTP status code to send with the message
* @param    string  $http_text      Textual version of the HTTP status code
*
* @note Displays the message and aborts the script.
*
*/
function COM_displayMessageAndAbort( $msg, $plugin = '', $http_status = 200, $http_text = 'OK')
{
    $display = COM_siteHeader( 'menu' )
             . COM_showMessage( $msg, $plugin )
             . COM_siteFooter( true );

    if( $http_status != 200 )
    {
        header( "HTTP/1.1 $http_status $http_text" );
        header( "Status: $http_status $http_text" );
    }
    echo $display;
    exit;
}

// Now include all plugin functions
foreach( $_PLUGINS as $pi_name )
{
    require_once( $_CONF['path'] . 'plugins/' . $pi_name . '/functions.inc' );
}

// Check and see if any plugins (or custom functions)
// have scheduled tasks to perform
if(( DB_getItem( $_TABLES['vars'], 'value', "name='last_scheduled_run'" )
        + $_CONF['cron_schedule_interval'] ) <= time())
{
    PLG_runScheduledTask();
    DB_query( "UPDATE {$_TABLES['vars']} SET value=UNIX_TIMESTAMP() WHERE name='last_scheduled_run'" );
}

?>
