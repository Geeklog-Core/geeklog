<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-common.php                                                            |
// |                                                                           |
// | Geeklog common library.                                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: lib-common.php,v 1.312 2004/04/09 17:16:03 dhaun Exp $

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
if( eregi( 'lib-common.php', $PHP_SELF ))
{
    echo COM_refresh( $_CONF['site_url'] . '/index.php' );
    exit;
}

// +---------------------------------------------------------------------------+
// | Library Includes: You shouldn't have to touch anything below here         |
// +---------------------------------------------------------------------------+

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
* Ulf Harnhammar's kses class
*
*/

require_once( $_CONF['path_system'] . 'classes/kses.class.php' );

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

// Set theme
// Need to modify this code to check if theme was cached in user cookie.  That
// way if user logged in and set theme and then logged out we would still know
// which theme to show them.

if( !empty( $HTTP_POST_VARS['usetheme'] ) && is_dir( $_CONF['path_themes']
        . $HTTP_POST_VARS['usetheme'] ))
{
    $_CONF['theme'] = $HTTP_POST_VARS['usetheme'];
    $_CONF['path_layout'] = $_CONF['path_themes'] . $_CONF['theme'] . '/';      
    $_CONF['layout_url'] = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];   
}
else if( $_CONF['allow_user_themes'] == 1 )
{
    if( isset( $HTTP_COOKIE_VARS[$_CONF['cookie_theme']]) && empty($_USER['theme'] ))
    {
        if( is_dir( $_CONF['path_themes'] . $HTTP_COOKIE_VARS[$_CONF['cookie_theme']] ))
        {
            $_USER['theme'] = $HTTP_COOKIE_VARS[$_CONF['cookie_theme']];
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

// Similarly set language

if( isset( $HTTP_COOKIE_VARS[$_CONF['cookie_language']]) && empty( $_USER['language'] ))
{
    if( is_file( $_CONF['path_language'] . $HTTP_COOKIE_VARS[$_CONF['cookie_language']] . '.php' ))
    {
        $_USER['language'] = $HTTP_COOKIE_VARS[$_CONF['cookie_language']];
        $_CONF['language'] = $HTTP_COOKIE_VARS[$_CONF['cookie_language']];
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
    DB_query( "DELETE FROM {$_TABLES['sessions']} WHERE remote_ip = '$REMOTE_ADDR' AND uid = 1" );

    $tries = 0;
    do
    {
        // Build a useless sess_id (needed for insert to work properly)
        mt_srand(( double )microtime() * 1000000 );
        $sess_id = mt_rand();
        $curtime = time();

        // Insert anonymous user session
        DB_query( "INSERT INTO {$_TABLES['sessions']} (sess_id, start_time, remote_ip, uid) VALUES ($sess_id,$curtime,'$REMOTE_ADDR',1)", 1 );
        $tries++;
    }
    while( DB_error() && ( $tries < 5 ));
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
* Global array of current user permissions [read,edit]
*
* @global array $_RIGHTS
*
*/

$_RIGHTS = explode( ',', SEC_getUserPermissions() );

/**
* Global array of groups current user belongs to
*
* @global array $_GROUPS
*
*/

$_GROUPS = SEC_getUserGroups( $_USER['uid'] );

if( isset( $HTTP_GET_VARS['topic'] ))
{
    $topic = COM_applyFilter( $HTTP_GET_VARS['topic'] );
}
else if( isset( $HTTP_POST_VARS['topic'] ))
{
    $topic = COM_applyFilter( $HTTP_POST_VARS['topic'] );
}
else
{
    $topic = '';
}


// +---------------------------------------------------------------------------+
// | STORY FUNCTIONS                                                           |
// +---------------------------------------------------------------------------+

/**
* Returns the array (created from db record) passed to it as formated HTML
*
* Formats the given article data into HTML.  Called by index.php, article.php,
* and admin/story.php (when previewing)
*
* @param    array       $A      Data to display as an article (associative array from record from gl_stories
* @param    string      $index  whether or not this is the index page if 'n' then compact display for index page else display full article
* @return   string      Article as formated HTML
*
*/

function COM_article( $A, $index='', $storytpl='storytext.thtml' )
{
    global $_TABLES, $mode, $_CONF, $_USER, $LANG01, $LANG05, $LANG11, $_THEME_URL;

    $curtime = COM_getUserDateTimeFormat( $A['day'] );
    $A['day'] = $curtime[0];

    // If plain text then replace newlines with <br> tags
    if( $A['postmode'] == 'plaintext' )
    {
        $A['introtext'] = nl2br( COM_makeClickableLinks( $A['introtext'] ));
        $A['bodytext'] = nl2br( COM_makeClickableLinks( $A['bodytext'] ));
    }

    $A['introtext'] = str_replace( '{', '&#123;', $A['introtext'] );
    $A['introtext'] = str_replace( '}', '&#125;', $A['introtext'] );
    $A['bodytext'] = str_replace( '{', '&#123;', $A['bodytext'] );
    $A['bodytext'] = str_replace( '}', '&#125;', $A['bodytext'] );

    $article = new Template( $_CONF['path_layout'] );
    $article->set_file( array(
            'article'          => $storytpl,
            'bodytext'         => 'storybodytext.thtml',
            'featuredarticle'  => 'featuredstorytext.thtml',
            'featuredbodytext' => 'featuredstorybodytext.thtml'
            ));

    $article->set_var( 'layout_url', $_CONF['layout_url'] );
    $article->set_var( 'site_url', $_CONF['site_url'] );
    $article->set_var( 'story_date', $A['day'] );
    $article->set_var( 'lang_views', $LANG01[106] );
    $article->set_var( 'story_hits', $A['hits'] );
    $article->set_var( 'story_id', $A['sid'] );

    if( $_CONF['contributedbyline'] == 1 )
    {
        $sql = "SELECT username, fullname, photo FROM {$_TABLES['users']} WHERE uid = '{$A['uid']}'";
        $results = DB_query( $sql );
        $U = DB_fetchArray( $results );

        $article->set_var( 'lang_contributed_by', $LANG01[1] );
        $article->set_var( 'contributedby_uid', $A['uid'] );
        $username = $U['username'];
        $article->set_var( 'contributedby_user', $username );

        $fullname = $U['fullname'];
        if( empty( $fullname ))
        {
            $article->set_var( 'contributedby_fullname', $username );
        }
        else
        {
            $article->set_var( 'contributedby_fullname', $fullname );
        }

        if( $A['uid'] > 1 )
        {
            $article->set_var( 'start_contributedby_anchortag',
                    '<a class="storybyline" href="' . $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $A['uid'] . '">' );
            $article->set_var( 'end_contributedby_anchortag', '</a>' );
            $article->set_var( 'contributedby_url', $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $A['uid'] );

            $photo = $U['photo'];
            if( !empty( $photo ))
            {
                if( empty( $fullname ))
                {
                    $altname = $username;
                }
                else
                {
                    $altname = $fullname;
                }
                $article->set_var( 'contributedby_photo', '<img src="'
                        . $_CONF['site_url'] . '/images/userphotos/' . $photo
                        . '" alt="' . $altname . '">' );
            }
        }
    }

    if( $_USER['noicons'] != 1 AND $A['show_topic_icon'] == 1 )
    {
        $result = DB_query( "SELECT imageurl,topic FROM {$_TABLES['topics']} WHERE tid = '{$A['tid']}'" );
        $T = DB_fetchArray( $result );

        $topicname = htmlspecialchars( stripslashes( $T['topic'] ));
        $topicurl = $_CONF['site_url'] . '/index.php?topic=' . $A['tid'];
        if( !empty( $T['imageurl'] ))
        {
            if( isset( $_THEME_URL ))
            {
                $imagebase = $_THEME_URL;
            }
            else
            {
                $imagebase = $_CONF['site_url'];
            }
            $topicimage = '<img align="' . $_CONF['article_image_align']
                    . '" src="' . $imagebase . $T['imageurl'] . '" alt="'
                    . $topicname . '" title="' . $topicname . '" border="0">';
            $article->set_var( 'story_anchortag_and_image', '<a href="'
                    . $topicurl . '">' . $topicimage . '</a>' );
            $article->set_var( 'story_topic_image', $topicimage );
        }
        $article->set_var( 'story_topic_id', $A['tid'] );
        $article->set_var( 'story_topic_name', $topicname );
        $article->set_var( 'story_topic_url', $topicurl );
    }

    $A['title'] = str_replace( '$', '&#36;', $A['title'] );
    $A['introtext'] = str_replace( '$', '&#36;', $A['introtext'] );
    $A['bodytext'] = str_replace( '$', '&#36;', $A['bodytext'] );

    $recent_post_anchortag = '';
    if( $index == 'n' )
    {
        $article->set_var( 'story_title', stripslashes( $A['title'] ));
        $article->set_var( 'story_introtext', stripslashes( $A['introtext'] )
                . '<br><br>' . stripslashes( $A['bodytext'] ));
    }
    else
    {
        $article->set_var( 'story_title', stripslashes( $A['title'] ));
        $article->set_var( 'story_introtext', stripslashes( $A['introtext'] ));

        $articleUrl = COM_buildUrl( $_CONF['site_url'] . '/article.php?story='
                                    . $A['sid'] );
        $article->set_var( 'article_url', $articleUrl );
        if( !empty( $A['bodytext'] ))
        {
            $article->set_var( 'lang_readmore', $LANG01[2] );
            $article->set_var( 'lang_readmore_words', $LANG01[62] );
            $numwords = sizeof( explode( ' ', $A['bodytext'] ));
            $article->set_var( 'readmore_words', $numwords );

            $article->set_var( 'readmore_link', '<a href="' . $articleUrl . '">'
                    . $LANG01[2] . '</a> (' . $numwords . ' ' . $LANG01[62]
                    . ') ' );
            $article->set_var( 'start_readmore_anchortag', '<a href="'
                    . $articleUrl . '">' );
            $article->set_var( 'end_readmore_anchortag', '</a>' );
        }

        if( $A['commentcode'] >= 0 )
        {
            if( $A['comments'] > 0 )
            {
                $commentsUrl = COM_buildUrl( $_CONF['site_url']
                        . '/article.php?story=' . $A['sid'] . '#comments' );
                $article->set_var( 'comments_url', $commentsUrl );
                $article->set_var( 'comments_text', $A['comments'] . ' '
                        . $LANG01[3] );
                $article->set_var( 'comments_count', $A['comments'] );
                $article->set_var( 'lang_comments', $LANG01[3] );

                $result = DB_query( "SELECT UNIX_TIMESTAMP(date) AS day,username FROM {$_TABLES['comments']},{$_TABLES['users']} WHERE {$_TABLES['users']}.uid = {$_TABLES['comments']}.uid AND sid = '{$A['sid']}' ORDER BY date desc LIMIT 1" );
                $C = DB_fetchArray( $result );

                $recent_post_anchortag = '<span class="storybyline">'
                        . $LANG01[27] . ': '
                        . strftime( $_CONF['daytime'], $C['day'] ) . ' '
                        . $LANG01[104] . ' ' . $C['username'] . '</span>';
                $article->set_var( 'start_comments_anchortag', '<a href="'
                        . $commentsUrl . '">' );
                $article->set_var( 'end_comments_anchortag', '</a>' );
            }
            else
            {
                $recent_post_anchortag = ' <a href="' . $_CONF['site_url']
                        . '/comment.php?sid=' . $A['sid']
                        . '&amp;pid=0&amp;type=article">' . $LANG01[60] . '</a>';
            }
            $article->set_var( 'post_comment_link',' <a href="'
                    . $_CONF['site_url'] . '/comment.php?sid=' . $A['sid']
                    . '&amp;pid=0&amp;type=article">' . $LANG01[60] . '</a>' );
        }

        if( $_CONF['hideemailicon'] == 1 )
        {
            $article->set_var( 'email_icon', '' );
        }
        else
        {
            $article->set_var( 'email_icon', '<a href="' . $_CONF['site_url']
                . '/profiles.php?sid=' . $A['sid'] . '&amp;what=emailstory">'
                . '<img src="' . $_CONF['layout_url']
                . '/images/mail.gif" alt="' . $LANG01[64]
                . '" title="' . $LANG11[2] . '" border="0"></a>' );
        }
        if( $_CONF['hideprintericon'] == 1 )
        {
            $article->set_var( 'print_icon', '' );
        }
        else
        {
            $article->set_var( 'print_icon', '<a href="' . $_CONF['site_url']
                . '/article.php?story=' . $A['sid'] . '&amp;mode=print">'
                . '<img border="0" src="' . $_CONF['layout_url']
                . '/images/print.gif" alt="' . $LANG01[65] . '" title="'
                . $LANG11[3] . '"></a>' );
        }
    }
    $article->set_var( 'recent_post_anchortag', $recent_post_anchortag );

    if( SEC_hasAccess( $A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon'] ) == 3 AND SEC_hasrights( 'story.edit' ))
    {
        $article->set_var( 'edit_link', '<a href="' . $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $A['sid'] . '">'
                . $LANG01[4] . '</a>' );
        $article->set_var( 'edit_url', $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $A['sid'] );
        $article->set_var( 'lang_edit_text',  $LANG01[4] );
        $article->set_var( 'edit_icon', '<a href="' . $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $A['sid'] . '"><img src="'
                . $_CONF['layout_url'] . '/images/edit.gif" alt="' . $LANG01[4]
                . '" title="' . $LANG01[4] . '" border="0"></a>' );
        $article->set_var( 'edit_image',  '<img src="' . $_CONF['layout_url']
                . '/images/edit.gif" alt="' . $LANG01[4] . '" title="'
                . $LANG01[4] . '" border="0">' );
    }

    if( $A['featured'] == 1 )
    {
        $article->set_var( 'lang_todays_featured_article', $LANG05[4] );
        $article->parse( 'story_bodyhtml', 'featuredbodytext', true );
        $article->parse( 'finalstory', 'featuredarticle' );
    }
    else
    {
        $article->parse( 'story_bodyhtml', 'bodytext', true );
        $article->parse( 'finalstory', 'article' );
    }

    return $article->finish( $article->get_var( 'finalstory' ));
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
* Gets all directory names in /path/to/geeklog/themes/ and returns all the
* directories
*
* @return   array   All installed themes
*/

function COM_getThemes($all = false)
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
* Returns the site header
*
* This loads the proper templates, does variable substitution and returns the
* HTML for the site header with or without blocks depending on the value of $what
*
* Programming Note:
*
* The two functions COM_siteHeader and COM_siteFooter provide the framework for page display
* in Geeklog.  COM_siteHeader controls the display of the Header and left blocks and COM_siteFooter
* controls the dsiplay of the right blocks and the footer.  You use them like a sandwich.  Thus the
* following code will display a Geeklog page with both right and left blocks displayed.
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
* Note that the default for the header is to display the left blocks and the default of the
* footer is to not display the right blocks.
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
* @param        string      $what       If 'none' then no left blocks are returned, if 'menu' (default) then right blocks are returned
* @see function COM_siteFooter
* @return   string  This returns formated HTML containing the site header
*
*/

function COM_siteHeader( $what = 'menu' )
{
    global $_CONF, $_USER, $LANG01, $_COM_VERBOSE, $topic, $LANG_BUTTONS, $LANG_CHARSET;
    global $_TABLES, $HTTP_POST_VARS, $HTTP_GET_VARS;

    // If the theme implemented this for us then call their version instead.

    $function = $_CONF['theme'] . '_siteHeader';

    if( function_exists( $function ))
    {
        return $function( $what );
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

    $pagetitle = '';
    if( isset( $_CONF['pagetitle'] ))
    {
        $pagetitle = $_CONF['pagetitle'];
    }
    if( empty( $pagetitle ))
    {
        $pagetitle = $_CONF['site_slogan'];
    }
    if( !empty( $pagetitle ))
    {
        $pagetitle = ' - ' . $pagetitle;
    }
    $header->set_var( 'page_title', $_CONF['site_name'] . $pagetitle );

    $header->set_var( 'background_image', $_CONF['layout_url'] . '/images/bg.gif' );
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
    $header->set_var( 'site_logo', $_CONF['layout_url'] . '/images/logo.gif' );
    $header->set_var( 'css_url', $_CONF['layout_url'] . '/style.css' );
    $header->set_var( 'theme', $_CONF['theme'] );

    if( empty( $LANG_CHARSET ))
    {
        $charset = $_CONF['default_charset'];

        if( empty( $charset ))
        {
            $charset = "iso-8859-1";
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
    $header->set_var( 'button_links', $LANG_BUTTONS[4] );
    $header->set_var( 'button_polls', $LANG_BUTTONS[5] );
    $header->set_var( 'button_calendar', $LANG_BUTTONS[6] );
    $header->set_var( 'button_sitestats', $LANG_BUTTONS[7] );
    $header->set_var( 'button_personalize', $LANG_BUTTONS[8] );
    $header->set_var( 'button_search', $LANG_BUTTONS[9] );
    $header->set_var( 'button_advsearch', $LANG_BUTTONS[10] );

    // Now add nested template for menu items

    // contribute link
    if( empty( $topic ))
    {
        $contributelink = $_CONF['site_url'] . '/submit.php?type=story';
        $header->set_var( 'current_topic', '' );
    }
    else
    {
        $contributelink = $_CONF['site_url']
                        . '/submit.php?type=story&amp;topic=' . $topic;
        $header->set_var( 'current_topic', '&amp;topic=' . $topic );
    }

    $allowedCounter = 0;
    $header->set_var( 'menuitem_url', $contributelink );
    $header->set_var( 'menuitem_text', $LANG01[71] );
    $header->parse( 'menu_elements', 'menuitem', true );
    if(( isset( $_USER['uid'] ) && ( $_USER['uid'] > 1 )) ||
        (( $_CONF['loginrequired'] == 0 ) && ( $_CONF['submitloginrequired'] == 0 )))
    {
        $header->parse( 'allowed_menu_elements', 'menuitem', true );
        $allowedCounter++;
    }

    // links link
    $header->set_var( 'menuitem_url', $_CONF['site_url'] . '/links.php' );
    $header->set_var( 'menuitem_text', $LANG01[72] );
    $header->parse( 'menu_elements', 'menuitem', true );
    if(( isset( $_USER['uid'] ) && ( $_USER['uid'] > 1 )) ||
        (( $_CONF['loginrequired'] == 0 ) && ( $_CONF['linksloginrequired'] == 0 )))
    {
        $header->parse( 'allowed_menu_elements', 'menuitem', true );
        $allowedCounter++;
    }

    // polls link
    $header->set_var( 'menuitem_url', $_CONF['site_url'] . '/pollbooth.php' );
    $header->set_var( 'menuitem_text', $LANG01[73] );
    $header->parse( 'menu_elements', 'menuitem', true );
    if(( isset( $_USER['uid'] ) && ( $_USER['uid'] > 1 )) ||
        (( $_CONF['loginrequired'] == 0 ) && ( $_CONF['pollsloginrequired'] == 0 )))
    {
        $header->parse( 'allowed_menu_elements', 'menuitem', true );
        $allowedCounter++;
    }

    // calendar link
    $header->set_var( 'menuitem_url', $_CONF['site_url'] . '/calendar.php' );
    $header->set_var( 'menuitem_text', $LANG01[74] );
    $header->parse( 'menu_elements', 'menuitem', true );
    if(( isset( $_USER['uid'] ) && ( $_USER['uid'] > 1 )) ||
        (( $_CONF['loginrequired'] == 0 ) && ( $_CONF['calendarloginrequired'] == 0 )))
    {
        $header->parse( 'allowed_menu_elements', 'menuitem', true );
        $allowedCounter++;
    }

    // Get plugin menu options
    $plugin_menu = PLG_getMenuItems();

    if( $_COM_VERBOSE )
    {
        COM_errorLog( 'num plugin menu items in header = ' . count( $plugin_menu ), 1 );
    }

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

    // Search link
    $header->set_var( 'menuitem_url', $_CONF['site_url'] . '/search.php' );
    $header->set_var( 'menuitem_text', $LANG01[75] );
    $header->parse( 'menu_elements', 'menuitem', true );
    if(( isset( $_USER['uid'] ) && ( $_USER['uid'] > 1 )) ||
        (( $_CONF['loginrequired'] == 0 ) && ( $_CONF['searchloginrequired'] == 0 )))
    {
        $header->parse( 'allowed_menu_elements', 'menuitem', true );
        $allowedCounter++;
    }

    // Stats link
    $header->set_var( 'menuitem_url', $_CONF['site_url'] . '/stats.php' );
    $header->set_var( 'menuitem_text', $LANG01[76] );
    $header->parse( 'menu_elements', 'menuitem_last', true );
    if(( isset( $_USER['uid'] ) && ( $_USER['uid'] > 1 )) ||
        (( $_CONF['loginrequired'] == 0 ) && ( $_CONF['statsloginrequired'] == 0 )))
    {
        $header->parse( 'allowed_menu_elements', 'menuitem', true );
        $allowedCounter++;
    }

    if( $allowedCounter == 0 )
    {
        $header->set_var( 'allowed_menu_elements', '' );
    }

    if( $what <> 'none' )
    {
        // Now show any blocks -- need to get the topic if not on home page
        if( !isset( $HTTP_GET_VARS['topic'] ))
        {
            if( isset( $HTTP_GET_VARS['story'] ))
            {
                $sid = COM_applyFilter( $HTTP_GET_VARS['story'] );
            }
            elseif( isset( $HTTP_GET_VARS['sid'] ))
            {
                $sid = COM_applyFilter( $HTTP_GET_VARS['sid'] );
            }
            elseif( isset( $HTTP_POST_VARS['story'] ))
            {
                $sid = COM_applyFilter( $HTTP_POST_VARS['story'] );
            }
            if( !empty( $sid ))
            {
                $topic = DB_getItem( $_TABLES['stories'], 'tid', "sid='$sid'" );
            }
        }
        else
        {
            $topic = COM_applyFilter( $HTTP_GET_VARS['topic'] );
        }
        $header->set_var( 'geeklog_blocks', COM_showBlocks( 'left', $topic ));
        $header->parse( 'left_blocks', 'leftblocks', true );
    }
    else
    {
        $header->set_var( 'geeklog_blocks', '' );
        $header->set_var( 'left_blocks', '' );
    }

    // Call any plugin that may want to include Extra Metatags or Javascript functions
    $header->set_var( 'plg_headercode', PLG_getHeaderCode());

    // The following line allows users to embed PHP in their templates.  This
    // is almost a contradition to the reasons for using templates but this may
    // prove useful at times...don't use PHP in templates if you can live without it

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
* @param        boolean     $rightblock     Whether or not to show blocks on right hand side default is no
* @see function COM_siteHeader
* @return   string  Formated HTML containing site footer and optionally right blocks
*
*/
function COM_siteFooter( $rightblock = false )
{
    global $_CONF, $LANG01, $_PAGE_TIMER, $_TABLES, $topic;

    // If the theme implemented this for us then call their version instead.

    $function = $_CONF['theme'] . '_siteFooter';

    if( function_exists( $function ))
    {
        return $function( $rightblock );
    }

    // Set template directory
    $footer = new Template( $_CONF['path_layout'] );

    // Set template file
    $footer->set_file( array( 'footer'=>'footer.thtml', 'rightblocks'=>'rightblocks.thtml' ));

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

    $exectime = $_PAGE_TIMER->stopTimer();
    $exectext = $LANG01[91] . ' ' . $exectime . ' ' . $LANG01[92];

    $footer->set_var( 'execution_time', $exectime );
    $footer->set_var( 'execution_textandtime', $exectext );

    if( $rightblock )
    {
        $rblocks = COM_showBlocks( 'right', $topic );
    }
    if( $rightblock && !empty( $rblocks ))
    {
        $footer->set_var( 'geeklog_blocks', $rblocks );
        $footer->parse( 'right_blocks', 'rightblocks', true);
    }
    else
    {
        $footer->set_var( 'geeklog_blocks', '' );
        $footer->set_var( 'right_blocks', '' );
    }
    
    // Global centerspan variable set in index.php
    if( isset( $GLOBALS['centerspan'] ))
    {
        $footer->set_var( 'centerblockfooter-span', '</td></tr></table>' );
    }

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
    global $_CONF, $LANG01;

    $block = new Template( $_CONF['path_layout'] );
    $block->set_file( 'block', $template );

    $block->set_var( 'site_url', $_CONF['site_url'] );
    $block->set_var( 'layout_url', $_CONF['layout_url'] );
    $block->set_var( 'block_title', stripslashes( $title ));

    if( !empty( $helpfile ))
    {
        if( !stristr( $helpfile, 'http://' ))
        {
            $help = '<a class="blocktitle" href="' . $_CONF['site_url'] . '/help/' . $helpfile
                . '" target="_blank"><img src="' . $_CONF['layout_url']
                . '/images/button_help.gif" border="0" alt="?"></a>';
        }
        else
        {
            $help = '<a class="blocktitle" href="' . $helpfile
                . '" target="_blank"><img src="' . $_CONF['layout_url']
                . '/images/button_help.gif" border="0" alt="?"></a>';
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
* @param        string      $selected   Value (from $selection) to set to SELECTED or default
* @param        int         $sortcol    Which field to sort option list by 0 (value) or 1 (label)
* @see function COM_checkList
* @return   string  Formated HTML of option values
*
*/
function COM_optionList( $table, $selection, $selected='', $sortcol=1 )
{
    $retval = '';

    $tmp = str_replace( 'DISTINCT ', '', $selection );
    $select_set = explode( ',', $tmp );

    $result = DB_query( "SELECT $selection FROM $table ORDER BY $select_set[$sortcol]" );
    $nrows = DB_numRows( $result );

    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result, true );
        $retval .= '<option value="' . $A[0] . '"';

        if( $A[0] == $selected )
        {
            $retval .= ' selected="selected"';
        }

        $retval .= '>' . $A[1] . '</option>' . LB;
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
* @see file lib-syndication.php
*
*/
function COM_rdfUpToDateCheck()
{
    global $_CONF, $_TABLES;

    if( $_CONF['backend'] > 0 )
    {
        $result = DB_query( "SELECT fid,type,topic,limits,update_info FROM {$_TABLES['syndication']} WHERE is_enabled = 1" );
        $num = DB_numRows( $result );
        for( $i = 0; $i < $num; $i++)
        {
            $A = DB_fetchArray( $result );

            $is_current = true;
            if( $A['type'] == 'geeklog' )
            {
                $is_current = SYND_feedUpdateCheck( $A['type'], $A['fid'],
                        $A['topic'], $A['update_info'], $A['limits'] );
            }
            else
            {
                $is_current = PLG_feedUpdateCheck( $A['type'], $A['fid'],
                        $A['topic'], $A['update_info'], $A['limits'] );
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
* @return   string  If $actionid = 2 or '' then HTML formated string (wrapped in block) else nothing
*
*/

function COM_errorLog($logentry, $actionid = '')
{
    global $_CONF, $LANG01;

    $retval = '';

    if( !empty( $logentry ))
    {
        $timestamp = strftime( "%c" );

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
    global $_CONF, $_USER, $LANG01, $REMOTE_ADDR;

    $retval = '';

    $timestamp = strftime( '%c' );
    $logfile = $_CONF['path_log'] . 'access.log';

    if( !$file = fopen( $logfile, 'a' ))
    {
        return $LANG01[33] . $logfile . ' (' . $timestamp . ')<br>' . LB;
    }

    if( isset( $_USER['uid'] ))
    {
        $byuser = $_USER['uid'] . '@' . $REMOTE_ADDR;
    }
    else
    {
        $byuser = 'anon@' . $REMOTE_ADDR;
    }

    fputs( $file, "$timestamp ($byuser) - $logentry\n" );

    return $retval;
}

/**
* Shows a poll form
*
* Shows an HTML formatted poll for the given question ID
*
* @param      string      $qid      ID for poll question
* @see function COM_pollResults
* @see function COM_showPoll
* @return       string  HTML Formatted Poll
*
*/

function COM_pollVote( $qid )
{
    global $_CONF, $_TABLES, $HTTP_COOKIE_VARS, $REMOTE_ADDR, $LANG01;

    $retval = '';

    $question = DB_query( "SELECT question,voters,commentcode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid='$qid'" );
    $Q = DB_fetchArray( $question );

    if( SEC_hasAccess( $Q['owner_id'], $Q['group_id'], $Q['perm_owner'], $Q['perm_group'], $Q['perm_members'], $Q['perm_anon'] ) == 0 )
    {
        return $retval;
    }

    $nquestion = DB_numRows( $question );
    $fields = array( 'ipaddress', 'qid' );
    $values = array( $REMOTE_ADDR, $qid );
    $id = DB_count( $_TABLES['pollvoters'], $fields, $values );

    if( empty( $HTTP_COOKIE_VARS[$qid] ) && $id == 0 )
    {
        if( $nquestion == 1 )
        {
            $answers = DB_query( "SELECT answer,aid FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY aid" );
            $nanswers = DB_numRows( $answers );

            if( $nanswers > 0 )
            {
                $poll = new Template( $_CONF['path_layout'] . 'pollbooth' );
                $poll->set_file( array( 'panswer' => 'pollanswer.thtml',
                                        'block' => 'pollblock.thtml',
                                        'comments' => 'pollcomments.thtml' ));
                $poll->set_var( 'site_url', $_CONF['site_url'] );
                $poll->set_var( 'layout_url', $_CONF['layout_url'] );

                $poll->set_var( 'poll_question', $Q['question'] );
                $poll->set_var( 'poll_id', $qid );
                $poll->set_var( 'num_votes', $Q['voters'] );
                $poll->set_var( 'poll_vote_url', $_CONF['site_url']
                        . '/pollbooth.php');
                $poll->set_var( 'poll_results_url', $_CONF['site_url']
                        . '/pollbooth.php?qid=' . $qid . '&amp;aid=-1');

                $poll->set_var( 'lang_vote', $LANG01[56] );
                $poll->set_var( 'lang_votes', $LANG01[8] );
                $poll->set_var( 'lang_results', $LANG01[6] );

                for( $i = 1; $i <= $nanswers; $i++ )
                {
                    $A = DB_fetchArray( $answers );
                    $poll->set_var( 'answer_id', $A['aid'] );
                    $poll->set_var( 'answer_text', $A['answer'] );
                    $poll->parse( 'poll_answers', 'panswer', true );
                }

                if( $Q['commentcode'] >= 0 )
                {
                    $poll->set_var( 'num_comments',
                            DB_count( $_TABLES['comments'], 'sid', $qid ));
                    $poll->set_var( 'lang_comments', $LANG01[3] );
                    $poll->set_var( 'poll_comments_url', $_CONF['site_url'] .
                        '/pollbooth.php?qid=' . $qid . '&amp;aid=-1#comments');
                    $poll->parse( 'poll_comments', 'comments', true );
                }
                else
                {
                    $poll->set_var( 'poll_comments', '' );
                    $poll->set_var( 'poll_comments_url', '' );
                }

                $retval = COM_startBlock( $LANG01[5], '',
                              COM_getBlockTemplate( 'poll_block', 'header' ))
                        . $poll->finish( $poll->parse( 'output', 'block' ))
                        . COM_endBlock( COM_getBlockTemplate( 'poll_block', 'footer' )) . LB;
            }
        }
    }
    else
    {
        $retval .= COM_pollResults( $qid );
    }

    return $retval;
}

/**
* This shows a poll
*
* This will determine if a user needs to see the poll form OR the poll
* result.
*
* @param        int        $sise       Size in pixels of poll results
* @param        string     $qid        Question ID to show (optional)
* @see function COM_pollVote
* @see function COM_pollResults
* @return    String  HTML Formated string of Poll
*
*/

function COM_showPoll( $size, $qid='' )
{
    global $_TABLES, $HTTP_COOKIE_VARS, $REMOTE_ADDR, $_CONF;

    $retval = '';

    DB_query( "DELETE FROM {$_TABLES['pollvoters']} WHERE date < unix_timestamp() - {$_CONF['polladdresstime']}" );

    if( !empty( $qid ))
    {
        $pcount = DB_count( $_TABLES['pollvoters'], array( 'ipaddress', 'qid' ),
                            array( $REMOTE_ADDR, $qid ));

        if( empty( $HTTP_COOKIE_VARS[$qid]) && $pcount == 0 )
        {
            $retval .= COM_pollVote( $qid );
        }
        else
        {
            $retval .= COM_pollResults( $qid, $size );
        }
    }
    else
    {
        $result = DB_query( "SELECT qid from {$_TABLES['pollquestions']} WHERE display = 1 ORDER BY date DESC" );
        $nrows = DB_numRows( $result );

        if( $nrows > 0 )
        {
            for( $i = 1; $i <= $nrows; $i++ )
            {
                $Q = DB_fetchArray( $result );
                $qid = $Q['qid'];
                $id = array( 'ipaddress', 'qid' );
                $value = array( $REMOTE_ADDR, $qid );
                $pcount = DB_count( $_TABLES['pollvoters'], $id, $value );

                if( !isset( $HTTP_COOKIE_VARS[$qid]) && $pcount == 0 )
                {
                    $retval .= COM_pollVote( $qid );
                }
                else
                {
                    $retval .= COM_pollResults( $qid, $size );
                }
            }
        }
    }

    return $retval;
}

/**
* Shows the results of a poll
*
* Shows the poll results for a give poll question
*
* @param        string      $qid        ID for poll question to show
* @param        int         $scale      Size in pixels to scale formatted results to
* @param        string      $order      'ASC' or 'DESC' for Comment ordering (SQL statment ordering)
* @param        string      $mode       Comment Mode possible values 'nocomment', 'flat', 'nested', 'threaded'
* @see COM_pollVote
* @see COM_showPoll
* @return     string   HTML Formated Poll Results
*
*/
function COM_pollResults( $qid, $scale=400, $order='', $mode='' )
{
    global $_TABLES, $LANG01, $LANG07, $_CONF, $_COM_VERBOSE;

    $retval = '';

    $question = DB_query( "SELECT question,voters,commentcode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid='$qid'" );
    $Q = DB_fetchArray( $question );

    if( SEC_hasAccess( $Q['owner_id'], $Q['group_id'], $Q['perm_owner'], $Q['perm_group'], $Q['perm_members'], $Q['perm_anon']) == 0 )
    {
        return $retval;
    }

    $nquestion = DB_numRows( $question );

    if( $nquestion == 1 )
    {
        if( $_CONF['answerorder'] == 'voteorder' )
        {
            $answers = DB_query( "SELECT votes,answer FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY votes DESC" );
        }
        else
        {
            $answers = DB_query( "SELECT votes,answer FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY aid" );
        }

        $nanswers = DB_numRows( $answers );

        if( $_COM_VERBOSE )
        {
            COM_errorLog( "got $answers answers in COM_pollResults", 1 );
        }

        if( $nanswers > 0 )
        {
            $title = DB_getItem( $_TABLES['blocks'], 'title', "name='poll_block'" );

            if( $scale < 120 ) // assume we're in the poll block
            {
                $retval .= COM_startBlock( $title, '',
                        COM_getBlockTemplate( 'poll_block', 'header' ));
            }
            else // assume we're in pollbooth.php
            {
                $retval .= COM_startBlock( $title );
            }

            $poll = new Template( $_CONF['path_layout'] . 'pollbooth' );
            $poll->set_file( array( 'result' => 'pollresult.thtml',
                                    'comments' => 'pollcomments.thtml',
                                    'votes_bar' => 'pollvotes_bar.thtml',
                                    'votes_num' => 'pollvotes_num.thtml' ));
            $poll->set_var( 'site_url', $_CONF['site_url'] );
            $poll->set_var( 'layout_url', $_CONF['layout_url'] );

            $poll->set_var( 'poll_question', $Q['question'] );
            $poll->set_var( 'poll_id', $qid );
            $poll->set_var( 'num_votes', $Q['voters'] );

            $poll->set_var( 'lang_votes', $LANG01[8] );

            for( $i = 1; $i <= $nanswers; $i++ )
            {
                $A = DB_fetchArray( $answers );

                if( $Q['voters'] == 0 )
                {
                    $percent = 0;
                }
                else
                {
                    $percent = $A['votes'] / $Q['voters'];
                }

                $poll->set_var( 'answer_text', $A['answer'] );
                $poll->set_var( 'answer_counter', $i );
                $poll->set_var( 'answer_odd', (( $i - 1 ) % 2 ));
                $poll->set_var( 'answer_num', $A['votes'] );
                $poll->set_var( 'answer_percent',
                                sprintf( '%.2f', $percent * 100 ));
                if( $scale < 120 )
                {
                    $poll->parse( 'poll_votes', 'votes_num', true );
                }
                else
                {
                    $width = $percent * $scale;
                    $poll->set_var( 'bar_width', $width );
                    $poll->parse( 'poll_votes', 'votes_bar', true );
                }
            }

            if( $Q['commentcode'] >= 0 )
            {
                $poll->set_var( 'num_comments',
                        DB_count( $_TABLES['comments'], 'sid', $qid ));
                $poll->set_var( 'lang_comments', $LANG01[3] );
                $poll->set_var( 'poll_comments_url', $_CONF['site_url'] .
                        '/pollbooth.php?qid=' . $qid . '&amp;aid=-1#comments');
                $poll->parse( 'poll_comments', 'comments', true );
            }
            else
            {
                $poll->set_var( 'poll_comments_url', '' );
                $poll->set_var( 'poll_comments', '' );
            }

            $poll->set_var( 'lang_pollquestions', $LANG07[6] );

            $retval .= $poll->finish( $poll->parse( 'output', 'result' ));

            if( $scale < 120)
            {
                $retval .= COM_endBlock( COM_getBlockTemplate( 'poll_block',
                        'footer' ));
            }
            else
            {
                $retval .= COM_endBlock();
            }
            if( $scale > 399 && $Q['commentcode'] >= 0 )
            {
                $delete_option = ( SEC_hasRights( 'poll.edit' ) &&
                    SEC_hasAccess( $Q['owner_id'], $Q['group_id'],
                    $Q['perm_owner'], $Q['perm_group'], $Q['perm_members'],
                    $Q['perm_anon'] ) == 3 ? true : false );
                $retval .= COM_userComments( $qid, $Q['question'], 'poll',
                                             $order, $mode, 0, 1, $delete_option ); 
            }
        }
    }

    return $retval;
}

/**
* Shows all available topics
*
* Show the topics in the system the user has access to and prints them in HTML.
* This function is used to show the topics in the sections block.
*
* @param        string      $topic      TopicID of currently selected
* @return   string    HTML formated topic list
*
*/

function COM_showTopics( $topic='' )
{
    global $_CONF, $_TABLES, $_USER, $_GROUPS, $LANG01, $HTTP_SERVER_VARS,
           $page, $newstories;

    $sql = "SELECT tid,topic,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['topics']}";
    if( $_USER['uid'] > 1 ) {
        $tids = DB_getItem( $_TABLES['userindex'], 'tids',
                            "uid = '{$_USER['uid']}'" );
        if (!empty ($tids)) {
            $sql .= " WHERE (tid NOT IN ('" . str_replace( ' ', "','", $tids )
                 . "'))" . COM_getPermSQL( 'AND ');
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
        $sql .= " ORDER BY topic ASC";
    }
    else
    {
        $sql .= " ORDER BY sortnum";
    }
    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    $retval = '';
    $sections = new Template( $_CONF['path_layout'] );
    $sections->set_file( array( 'option' => 'topicoption.thtml',
                                'inactive' => 'topicoption_off.thtml' ));
    $sections->set_var( 'site_url', $_CONF['site_url'] );
    $sections->set_var( 'layout_url', $_CONF['layout_url'] );
    $sections->set_var( 'block_name', str_replace( '_', '-', 'section_block' ));

    if( $_CONF['hide_home_link'] == 0 )
    {
        // Give a link to the homepage here since a lot of people use this for
        // navigating the site
        // Note: We can't use $PHP_SELF here since the site may not be in the
        // DocumentRoot

        preg_match( "/\/\/[^\/]*(.*)/", $_CONF['site_url'], $pathonly );
        if(( $HTTP_SERVER_VARS['SCRIPT_NAME'] <> $pathonly[1] . "/index.php" )
                OR !empty( $topic ) OR ( $page > 1 ) OR $newstories )
        {
            $sections->set_var( 'option_url',
                                $_CONF['site_url'] . '/index.php' );
            $sections->set_var( 'option_label', $LANG01[90] );
            $sections->set_var( 'option_count', '' );
            $retval .= $sections->parse( 'item', 'option' );
        }
        else
        {
            $sections->set_var( 'option_url', '' );
            $sections->set_var( 'option_label', $LANG01[90] );
            $sections->set_var( 'option_count', '' );
            $retval .= $sections->parse( 'item', 'inactive' );
        }
    }

    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );

        $sections->set_var( 'option_url', $_CONF['site_url']
                            . '/index.php?topic=' . $A['tid'] );
        $sections->set_var( 'option_label', stripslashes( $A['topic'] ));

        $countstring = '';
        if( $_CONF['showstorycount'] + $_CONF['showsubmissioncount'] > 0 )
        {
            $countstring .= '(';

            if( $_CONF['showstorycount'] )
            {
                $rcount = DB_query( "SELECT count(*) AS count FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) AND (tid = '{$A['tid']}')" . COM_getPermSQL( 'AND' ));
                $T = DB_fetchArray( $rcount );
                $countstring .= $T['count'];
            }

            if( $_CONF['showsubmissioncount'] )
            {
                if( $_CONF['showstorycount'] )
                {
                    $countstring .= '/';
                }
                $countstring .= DB_count( $_TABLES['storysubmission'],
                                          'tid', $A['tid'] );
            }

            $countstring .= ')';
        }
        $sections->set_var( 'option_count', $countstring );

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
    global $_TABLES, $_USER, $_CONF, $LANG01, $HTTP_SERVER_VARS;

    $retval = '';

    if( $_USER['uid'] > 1 )
    {
        $usermenu = new Template( $_CONF['path_layout'] );
        $usermenu->set_file( array( 'option' => 'useroption.thtml',
                                    'current' => 'useroption_off.thtml' ));
        $usermenu->set_var( 'site_url', $_CONF['site_url'] );
        $usermenu->set_var( 'layout_url', $_CONF['layout_url'] );
        $usermenu->set_var( 'block_name', str_replace( '_', '-', 'user_block' ));

        if( empty( $title ))
        {
            $title = DB_getItem( $_TABLES['blocks'], 'title', "name='user_block'" );
        }

        // what's our current URL?
        $thisUrl = $HTTP_SERVER_VARS['SCRIPT_URI'];
        if( empty( $thisUrl ))
        {
            $thisUrl = $HTTP_SERVER_VARS['DOCUMENT_URI'];
        }
        if( !empty( $thisUrl ) && !empty( $HTTP_SERVER_VARS['QUERY_STRING'] ))
        {
            $thisUrl .= '?' . $HTTP_SERVER_VARS['QUERY_STRING'];
        }
        if( empty( $thisUrl ))
        {
            $requestUri = $HTTP_SERVER_VARS['REQUEST_URI'];
            if( empty( $HTTP_SERVER_VARS['REQUEST_URI'] ))
            {
                $requestUri = $HTTP_SERVER_VARS['SCRIPT_NAME'];
                if( !empty( $HTTP_SERVER_VARS['QUERY_STRING'] ))
                {
                    $requestUri .= '?' . $HTTP_SERVER_VARS['QUERY_STRING'];     
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
        $login->set_var( 'layout_url', $_CONF['layout_url'] );
        $login->set_var( 'lang_username', $LANG01[21] );
        $login->set_var( 'lang_password', $LANG01[57] );
        $login->set_var( 'lang_login', $LANG01[58] );
        $login->set_var( 'lang_signup', $LANG01[59] );
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
    global $_TABLES, $_USER, $_CONF, $LANG01, $HTTP_SERVER_VARS;

    $retval = '';

    if( empty( $_USER['username'] ))
    {
        return $retval;
    }

    $plugin_options = PLG_getAdminOptions();
    $nrows = count( $plugin_options );

    if( SEC_isModerator() OR SEC_hasrights( 'story.edit,block.edit,topic.edit,link.edit,event.edit,poll.edit,user.edit,plugin.edit,user.mail', 'OR' ) OR ( $nrows > 0 ))
    {
        // what's our current URL?
        $thisUrl = $HTTP_SERVER_VARS['SCRIPT_URI'];
        if( empty( $thisUrl ))
        {
            $thisUrl = $HTTP_SERVER_VARS['DOCUMENT_URI'];
        }
        if( !empty( $thisUrl ) && !empty( $HTTP_SERVER_VARS['QUERY_STRING'] ))
        {
            $thisUrl .= '?' . $HTTP_SERVER_VARS['QUERY_STRING'];
        }
        if( empty( $thisUrl ))
        {
            $requestUri = $HTTP_SERVER_VARS['REQUEST_URI'];
            if( empty( $HTTP_SERVER_VARS['REQUEST_URI'] ))
            {
                $requestUri = $HTTP_SERVER_VARS['SCRIPT_NAME'];
                if( !empty( $HTTP_SERVER_VARS['QUERY_STRING'] ))
                {
                    $requestUri .= '?' . $HTTP_SERVER_VARS['QUERY_STRING'];     
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

        $adminmenu = new Template( $_CONF['path_layout'] );
        $adminmenu->set_file( array( 'option' => 'adminoption.thtml',
                                     'current' => 'adminoption_off.thtml' ));
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
                $num += DB_count ($_TABLES['eventsubmission'] );
            }

            if( SEC_hasrights( 'link.edit' ))
            {
                $num += DB_count( $_TABLES['linksubmission'] );
            }

            if( $_CONF['usersubmission'] == 1 )
            {
                if( SEC_hasrights( 'user.edit' ) && SEC_hasrights( 'user.delete' ))
                {
                    $emptypwd = md5( '' );
                    $num += DB_count( $_TABLES['users'], 'passwd', $emptypwd );
                }
            }

            // now handle submissions for plugins

            $num = $num + PLG_getSubmissionCount();

            $url = $_CONF['site_admin_url'] . '/moderation.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[10] );
            $adminmenu->set_var( 'option_count', $num );

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
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
            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_hasrights( 'block.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/block.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[12] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['blocks'] ));

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_hasrights( 'topic.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/topic.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[13] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['topics'] ));

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_hasrights( 'link.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/link.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[14] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['links'] ));

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_hasrights( 'event.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/event.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[15] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['events'] ));

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_hasrights( 'poll.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/poll.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[16] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['pollquestions'] ));

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_hasrights( 'user.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/user.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[17] );
            $adminmenu->set_var( 'option_count', ( DB_count( $_TABLES['users'] ) -1 ));

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_hasrights( 'group.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/group.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[96] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['groups'] ));

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_hasrights( 'user.mail' ))
        {
            $url = $_CONF['site_admin_url'] . '/mail.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[105] );
            $adminmenu->set_var( 'option_count', 'N/A' );

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if(( $_CONF['backend'] == 1 ) && SEC_inGroup( 'Root' ))
        {
            $url = $_CONF['site_admin_url'] . '/syndication.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[38] );
            $count = DB_count( $_TABLES['syndication'] );
            $adminmenu->set_var( 'option_count', $count );

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_hasrights( 'plugin.edit' ))
        {
            $url = $_CONF['site_admin_url'] . '/plugins.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[77] );
            $adminmenu->set_var( 'option_count', DB_count( $_TABLES['plugins'] ));

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
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

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $plg->adminurl ) ? 'current' : 'option', true );

            next( $plugin_options );
        }

        if( $_CONF['allow_mysqldump'] == 1 AND SEC_inGroup( 'Root' ))
        {
            $url = $_CONF['site_admin_url'] . '/database.php';
            $adminmenu->set_var( 'option_url', $url );
            $adminmenu->set_var( 'option_label', $LANG01[103] );
            $adminmenu->set_var( 'option_count', 'N/A' );

            $retval .= $adminmenu->parse( 'item',
                    ( $thisUrl == $url ) ? 'current' : 'option' );
        }

        if( SEC_inGroup( 'Root' ))
        {
            $adminmenu->set_var( 'option_url',
               'http://www.geeklog.net/versionchecker.php?version=' . VERSION );
            $adminmenu->set_var( 'option_label', $LANG01[107] );
            $adminmenu->set_var( 'option_count', VERSION );

            $retval .= $adminmenu->parse( 'item', 'option' );
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
* This function displays the comment control bar
*
* Prints the control that allows the user to interact with Geeklog Comments
*
* @param        string      $sid        ID of item in question
* @param        string      $title      Title of item
* @param        string      $type       Type of item (i.e. story, photo, etc)
* @param        string      $order      Order that comments are displayed in
* @param        string      $mode       Mode (nested, flat, etc.)
* @see COM_userComments
* @see COM_commentChildren
* @return     string   HTML Formated comment bar
*
*/
function COM_commentBar( $sid, $title, $type, $order, $mode )
{
    global $_TABLES, $LANG01, $_USER, $_CONF, $HTTP_GET_VARS;

    $nrows = DB_count( $_TABLES['comments'], 'sid', $sid );

    $commentbar = new Template( $_CONF['path_layout'] . 'comment' );
    $commentbar->set_file( array( 'commentbar' => 'commentbar.thtml' ));
    $commentbar->set_var( 'site_url', $_CONF['site_url'] );
    $commentbar->set_var( 'layout_url', $_CONF['layout_url'] );

    $commentbar->set_var( 'lang_comments', $LANG01[3] );
    $commentbar->set_var( 'lang_refresh', $LANG01[39] );
    $commentbar->set_var( 'lang_reply', $LANG01[25] );
    $commentbar->set_var( 'lang_disclaimer', $LANG01[26] );

    $commentbar->set_var( 'story_title', stripslashes( $title ));
    $commentbar->set_var( 'num_comments', $nrows );
    $commentbar->set_var( 'comment_type', $type );

    if( $_USER['uid'] > 1)
    {
        $username = $_USER['username'];
        $fullname = DB_getItem( $_TABLES['users'], 'fullname',
                                "uid = '{$_USER['uid']}'" ); 
    }
    else
    {
        $username = DB_getItem( $_TABLES['users'], 'username', "uid = '1'" );
        $fullname = DB_getItem( $_TABLES['users'], 'fullname', "uid = '1'" );
    }
    if( empty( $fullname ))
    {
        $fullname = $username;
    }
    $commentbar->set_var( 'user_name', $username );   
    $commentbar->set_var( 'user_fullname', $fullname );    

    if( !empty( $_USER['username'] ))
    {
        $commentbar->set_var( 'user_nullname', $username );
        $commentbar->set_var( 'login_logout_url',
                              $_CONF['site_url'] . '/users.php?mode=logout' );
        $commentbar->set_var( 'lang_login_logout', $LANG01[35] );
    }
    else
    {
        $commentbar->set_var( 'user_nullname', '' );
        $commentbar->set_var( 'login_logout_url',
                              $_CONF['site_url'] . '/users.php?mode=new' );
        $commentbar->set_var( 'lang_login_logout', $LANG01[61] );
    }

    if( $type == "poll" )
    {
        $commentbar->set_var( 'parent_url', $_CONF['site_url']
                              . '/pollbooth.php?qid=' . $sid . '&amp;aid=-1' );
        $commentbar->set_var( 'hidden_field',         
                '<input type="hidden" name="scale" value="400">' );
    }
    else
    {
        $commentbar->set_var( 'parent_url',
                              $_CONF['site_url'] . '/article.php' );
        $commentbar->set_var( 'hidden_field',
                '<input type="hidden" name="story" value="' . $sid . '">' );
    }

    // Order
    $selector = '<select name="order">' . LB
              . COM_optionList( $_TABLES['sortcodes'], 'code,name', $order )
              . LB . '</select>';
    $commentbar->set_var( 'order_selector', $selector);

    // Mode
    $selector = '<select name="mode">' . LB
              . COM_optionList( $_TABLES['commentmodes'], 'mode,name', $mode )
              . LB . '</select>';
    $commentbar->set_var( 'mode_selector', $selector);

    return $commentbar->finish( $commentbar->parse( 'output', 'commentbar' ));
}    


/**
* This function prints &$comments (db results set of comments) in comment format
* -For previews, &$comments is assumed to be an associative array containing
*  data for a single comment.
* 
* @param     array      &$comments Database result set of comments to be printed
* @param     string     $mode      'flat', 'threaded', etc
* @param     string     $type      Type of item (article, poll, etc.)
* @param     string     $order     How to order the comments 'ASC' or 'DESC'
* @param     boolean    $delete_option   if current user can delete comments
* @param     boolean    $preview   Preview display (for edit) or not
* @return    string     HTML       Formated Comment 
*
*/
function COM_getComment( &$comments, $mode, $type, $order, $delete_option = false, $preview = false )
{
    global $_CONF, $_TABLES, $LANG01;
    
    $indent = 0;  // begin with 0 indent
    $level = array(); // used to track depth
    $retval = ''; // initialize return value

    $template = new Template( $_CONF['path_layout'] . 'comment' );
    $template->set_file( array( 'comment' => 'comment.thtml',
                                'thread'  => 'thread.thtml'  ));
                                
    // generic template variables
    $template->set_var( 'site_url', $_CONF['site_url'] );
    $template->set_var( 'layout_url', $_CONF['layout_url'] );
    $template->set_var( 'lang_replytothis', $LANG01[43] );
    $template->set_var( 'lang_reply', $LANG01[25] );
    $template->set_var( 'lang_authoredby', $LANG01[42] );
    $template->set_var( 'lang_on', $LANG01[36] );
    $template->set_var( 'order', $order );    
    
    // Make sure we have a default value for comment indentation
    if( !isset( $_CONF['comment_indent'] ))
    {
        $_CONF['comment_indent'] = 25;
    }
    
    if ( $preview )
    {
        $A = $comments;   
    }
    else
    {
        $A = DB_fetchArray($comments);
    }
    
    if ( empty( $A ) )
    {
	return '';
    }
    
    do
    {
        // determines indentation for current comment
        if ( $mode == 'threaded' || $mode = 'nested' )
        {
            $indent = $A['indent'] * $_CONF['comment_indent'];
        }
        
        // comment variables
        $template->set_var( 'indent', $indent );
        $template->set_var( 'author', $A['username'] );
        $template->set_var( 'author_id', $A['uid'] );
        
        if( $A['uid'] > 1 )
        {
            if( empty( $A['fullname'] ))
            {
                $template->set_var( 'author_fullname', $A['username'] );
                $alttext = $A['username'];
            }
            else
            {
                $template->set_var( 'author_fullname', $A['fullname'] );
                $alttext = $A['fullname'];
            }
            
            if( !empty( $A['photo'] ))
            {
                $template->set_var( 'author_photo', '<img src="'
                                    . $_CONF['site_url']
                                    . '/images/userphotos/' . $A['photo']
                                    . '" alt="' . $alttext . '">' );
            }
            else
            {
                $template->set_var( 'author_photo', '' );
            }
            
            $template->set_var( 'start_author_anchortag', '<a href="'
                    . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid='
                    . $A['uid'] . '">' );
            $template->set_var( 'end_author_anchortag', '</a>' );
        }
        else
        {
            $template->set_var( 'author_fullname', $A['username'] );
            $template->set_var( 'author_photo', '' );
            $template->set_var( 'start_author_anchortag', '' );
            $template->set_var( 'end_author_anchortag', '' );
        }
    
        // this will hide HTML that should not be viewed in preview mode
        if( $preview )
        {
            $template->set_var( 'hide_if_preview', 'style="display:none"' );
        }
        else
        {
            $template->set_var( 'hide_if_preview', '' );
        }
    
        // for threaded mode, add a link to comment parent
        if( $mode == 'threaded' && $A['pid'] != 0 )
        {
            $result = DB_query( "SELECT title,pid from {$_TABLES['comments']} where cid = '{$A['pid']}'" );
            $P = DB_fetchArray( $result );
            $plink = $_CONF['site_url'] . '/comment.php?mode=display&amp;sid='
                   . $A['sid'] . '&amp;title=' . rawurlencode( $P['title'] )
                   . '&amp;type=' . $type . '&amp;order=' . $order . '&amp;pid=' 
                   . $P['pid'];
            $template->set_var( 'parent_link', "| <a href=\"$plink\">{$LANG01[44]}</a>");
        }
        else
        {
            $template->set_var( 'parent_link', '');
        }
    
        $template->set_var( 'date', strftime( $_CONF['date'], $A['nice_date'] ));
        $template->set_var( 'sid', $A['sid'] );
        $template->set_var( 'type', $A['type'] );

        // If deletion is allowed, displays delete link
        if( $delete_option )
        {
            $template->set_var( 'delete_option', '| <a href="' . $_CONF['site_url']
                    . '/comment.php?mode=' . $LANG01[28] . '&amp;cid=' . $A['cid']
                    . '&amp;sid=' . $A['sid'] . '&amp;type=' . $type . '">'
                    . $LANG01[28] . '</a> ' );
        }
        else
        {
            $template->set_var( 'delete_option', '' );
        }

        $A['title'] = stripslashes( $A['title'] );
        $A['title'] = str_replace( '$', '&#36;', $A['title'] );

        // and finally: format the actual text of the comment
        $A['comment'] = stripslashes( $A['comment'] );
        if( preg_match( '/<.*>/', $A['comment'] ) == 0 )
        {
            $A['comment'] = nl2br( COM_makeClickableLinks( $A['comment'] ));
        }
    
        // highlight search terms if specified
        if( !empty( $query ))
        {
            $mywords = explode( ' ', $query );
            foreach( $mywords as $searchword )
            {
                $searchword = str_replace( '*', '\*', $searchword );
                $A['comment'] = preg_replace( "/(\>(((?>[^><]+)|(?R))*)\<)/ie", "preg_replace('/(?>$searchword+)/i','<span class=\"highlight\">$searchword</span>','\\0')", "<x>" . $A['comment'] . "<x>" );
            }
        }
        
        $A['comment'] = str_replace( '$', '&#36;', $A['comment'] );
        $A['comment'] = str_replace( '{', '&#123;', $A['comment'] );
        $A['comment'] = str_replace( '}', '&#125;', $A['comment'] );

        $template->set_var( 'title', $A['title'] );
        $template->set_var( 'comments', $A['comment'] );

        // parse the templates
        if( $mode == 'threaded' && $indent > 0 )
        {
            $template->set_var( 'pid', $A['pid'] );
            $retval .= $template->parse( 'output', 'thread' );   
        }
        else
        {
            $template->set_var( 'pid', $A['cid'] );
            $retval .= $template->parse( 'output', 'comment' ); 
        }
    } while ($A = DB_fetchArray($comments));
    
    return $retval;
}

/**
* This function displays the comments in a high level format.
*
* Begins displaying user comments for an item
*
* @param        string      $sid       ID for item to show comments for
* @param        string      $title     Title of item
* @param        string      $type      Type of item (article, poll, etc.)
* @param        string      $order     How to order the comments 'ASC' or 'DESC'
* @param        string      $mode      comment mode (nested, flat, etc.)
* @param        int         $pid       id of parent comment
* @param        boolean     $delete_option   if current user can delete comments
* @see function COM_commentBar
* @see function COM_commentChildren
* @return     string  HTML Formated Comments
*
*/
function COM_userComments( $sid, $title, $type='article', $order='', $mode='', $pid = 0, $page = 1, $delete_option = false )
{
    global $_CONF, $_TABLES, $_USER, $LANG01;

    if( !empty( $_USER['uid'] ) )
    {
        $result = DB_query( "SELECT commentorder,commentmode,commentlimit FROM {$_TABLES['usercomment']} WHERE uid = '{$_USER['uid']}'" );
        $U = DB_fetchArray( $result );
        if ( empty( $order ) ) 
        {
            $order = $U['commentorder'];
        }
        if ( empty( $mode ) ) 
        {
            $mode = $U['commentmode'];
        }
        $limit = $U['commentlimit'];
    }

    if( empty( $order ))
    {
        $order = 'ASC';
    }

    if( empty( $mode ))
    {
        $mode = $_CONF['comment_mode'];
    }

    if( empty( $limit ))
    {
        $limit = $_CONF['comment_limit'];
    }
    
    if( !is_numeric($page) || $page < 1 )
    {
        $page = 1;
    }

    $start = $limit * ($page - 1);

    $template = new Template( $_CONF['path_layout'] . 'comment' );
    $template->set_file( array( 'commentarea' => 'startcomment.thtml' ));
    $template->set_var( 'site_url', $_CONF['site_url'] );
    $template->set_var( 'layout_url', $_CONF['layout_url'] );
    $template->set_var( 'commentbar',
                        COM_commentBar( $sid, $title, $type, $order, $mode));
    
    if ( $mode == 'nested' or $mode == 'threaded' or $mode == 'flat' )
    {
        // build query
        switch( $mode )
        {
            case 'flat':
                $count = DB_count($_TABLES['comments'], "sid", $sid);
            
                $q = "SELECT c.*, u.username, u.fullname, u.photo, " 
                     . "unix_timestamp(c.date) AS nice_date "
                   . "FROM {$_TABLES['comments']} as c, {$_TABLES['users']} as u "
                   . "WHERE c.uid = u.uid AND c.sid = '$sid' "
                   . "ORDER BY date $order LIMIT $start, $limit";
                break;

            case 'nested':
            case 'threaded':
            default:
                // count the total number of applicable comments
                $q2 = "SELECT COUNT(*) "
                    . "FROM {$_TABLES['comments']} as c, {$_TABLES['comments']} as c2 "
                    . "WHERE c.sid = '$sid' AND c.lft BETWEEN c2.lft AND c2.rht "
                    . "AND c2.sid = '$sid' AND c2.pid = $pid";
                $result = DB_query($q2);
                list($count) = DB_fetchArray($result);

                if( $order == 'DESC' )
                {
                    $cOrder = 'c.rht DESC';
                }
                else
                {
                    $cOrder = 'c.lft ASC'; 
                }                            
                $q = "SELECT c.*, u.username, u.fullname, u.photo, " 
                     . "unix_timestamp(c.date) AS nice_date "
                   . "FROM {$_TABLES['comments']} as c, {$_TABLES['comments']} as c2, "
                     . "{$_TABLES['users']} as u "
                   . "WHERE c.sid = '$sid' AND c.lft BETWEEN c2.lft AND c2.rht "
                     . "AND c2.sid = '$sid' AND c2.pid = $pid AND c.uid = u.uid "
                   . "ORDER BY $cOrder LIMIT $start, $limit";
                break;
        }

        $thecomments = '';
        $result = DB_query( $q );
        $thecomments .= COM_getComment( $result, $mode, $type, $order,
                                        $delete_option );
        
        // Pagination
        $tot_pages =  ceil( $count / $limit );
        $pLink = $_CONF['site_url'] . "/article.php?story=$sid&amp;type=$type&amp;order=$order&amp;mode=$mode";
        $template->set_var( 'pagenav',
                         COM_printPageNavigation($pLink, $page, $tot_pages));
        
        $template->set_var( 'comments', $thecomments );
        $retval = $template->parse( 'output', 'commentarea' );
    }

    return $retval;
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

    return ($EditedMessage);
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
    $str = str_replace( '\\', '&#092;', $str );
    $str = str_replace( '<', '&lt;', $str );
    $str = str_replace( '>', '&gt;', $str );

    return( $str );
}

/**
* This function checks html tags.
*
* The core of this code has been lifted from phpslash which is licenced under
* the GPL.  It checks to see that the HTML tags are on the approved list and
* removes them if not.
*
* @param        string      $str        HTML to check
* @see function COM_checkHTML
* @return   string  Filtered HTML
*
*/

function COM_checkHTML( $str )
{
    global $_CONF;

    $str = stripslashes($str);

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

    $filter = new kses;
    if( isset( $_CONF['allowed_protocols'] ) && is_array( $_CONF['allowed_protocols'] ) && ( sizeof( $_CONF['allowed_protocols'] ) > 0 ))
    {
        $filter->Protocols( $_CONF['allowed_protocols'] );
    }
    else
    {
        $filter->Protocols( array( 'http:', 'https:', 'ftp:' ));
    }

    if( !SEC_hasRights( 'story.edit' ) || empty ( $_CONF['admin_html'] ))       
    {
        $html = $_CONF['user_html'];
    }
    else
    {
        $html = array_merge( $_CONF['user_html'], $_CONF['admin_html'] );
    }

    foreach( $html as $tag => $attr )
    {
        $filter->AddHTML( $tag, $attr );
    }

    return $filter->Parse( $str );
}

/** undo function for htmlspecialchars()
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
    $string = ereg_replace( '&#36;', '$', $string );
    $string = ereg_replace( '&#123;', '{', $string );
    $string = ereg_replace( '&#125;', '}', $string );
    $string = ereg_replace( '&gt;', '>', $string );
    $string = ereg_replace( '&lt;', '<', $string );
    $string = ereg_replace( '&quot;', "\"", $string );
    $string = ereg_replace( '&amp;', '&', $string );

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
    $sid = date( "YmdHis" );
    srand(( double )microtime() * 1000000 );
    $sid .= rand( 0,999 );

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

    if( empty( $from ))
    {
        $from = $_CONF['site_name'] . ' <' . $_CONF['site_mail'] . '>';
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

    $sql = "SELECT sid,tid,title,comments,unix_timestamp(date) AS day FROM {$_TABLES['stories']} WHERE (perm_anon = 2) AND (date <= NOW()) AND (draft_flag = 0) ORDER BY featured DESC, date DESC LIMIT {$_CONF['limitnews']}, {$_CONF['limitnews']}";
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
            $topic_anon = DB_getItem( $_TABLES['topics'], 'perm_anon', "tid='{$A['tid']}'" );

            if( $topic_anon == 2 )
            {
                $daycheck = strftime( "%A", $A['day'] );
                if( $day != $daycheck )
                {
                    if( $day != 'noday' )
                    {
                        $daylist = COM_makeList( $oldnews );
                        $daylist = preg_replace( "/(\015\012)|(\015)|(\012)/",
                                                 "", $daylist );
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
        }

        if( !empty( $oldnews ))
        {
            $daylist = COM_makeList( $oldnews );
            $daylist = preg_replace( "/(\015\012)|(\015)|(\012)/", "", $daylist );
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
* @param        string      $name       Logical name of block (not same as title) -- 'user_block', 'admin_block', 'section_block', 'events_block', 'poll_block', 'whats_new_block'.
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

    if( !empty( $_USER['uid'] ))
    {
        $U['noboxes'] = DB_getItem( $_TABLES['userindex'], 'noboxes', "uid = {$_USER['uid']}" );
    }
    else
    {
        $U['noboxes'] = 0;
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
            if( !$U['noboxes'] && $_CONF['showupcomingevents'] )
            {
                $retval .= COM_printUpcomingEvents( $help, $title );
            }
            break;

        case 'poll_block':
            if( !$U['noboxes'] )
            {
                $retval .= COM_showPoll( 60 );
            }
            break;

        case 'whats_new_block':
            if( !$U['noboxes'] )
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
    global $_TABLES, $_CONF, $_USER, $LANG21, $HTTP_SERVER_VARS, $topic, $page, $newstories;

    $retval = '';

    // Get user preferences on blocks

    if( !empty( $_USER['uid'] ))
    {
        $result = DB_query( "SELECT boxes,noboxes FROM {$_TABLES['userindex']} WHERE uid = '{$_USER['uid']}'" );
        $U = DB_fetchArray( $result );
    }
    else
    {
        $U['boxes'] = '';
        $U['noboxes'] = 0;
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
        preg_match( "/\/\/[^\/]*(.*)/", $_CONF['site_url'], $pathonly );
        if(( $HTTP_SERVER_VARS['SCRIPT_NAME'] <> $pathonly[1] . "/index.php" ) OR !empty( $topic ) OR ( $page > 1 ) OR $newstories )
        {
            $sql .= " AND (tid = 'all' AND type <> 'layout')";
        }
        else
        {
            $sql .= " AND (tid = 'homeonly' OR (tid = 'all' AND type <> 'layout'))";
        }
    }

    if( !empty( $U['boxes'] ))
    {
        $BOXES = str_replace( ' ', ',', $U['boxes'] );

        $sql .= " AND (bid NOT IN ($BOXES) OR bid = '-1')";
    }

    $sql .= ' ORDER BY blockorder,title asc';

    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    for( $i = 1; $i <= $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );

        if( SEC_hasAccess( $A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']) > 0 )
        {
            if( $A['type'] == 'portal' )
            {
                if( COM_rdfCheck( $A['bid'], $A['rdfurl'], $A['date'] ))
                {
                    $A['content'] = DB_getItem( $_TABLES['blocks'], 'content',
                                                "bid = '{$A['bid']}'");
                }
            }

            if( $A['type'] == 'gldefault' )
            {
                $retval .= COM_showBlock( $A['name'], $A['help'], $A['title'] );
            }

            if( $A['type'] == 'phpblock' && !$U['noboxes'] )
            {
                if( !($A['name'] == 'whosonline_block' AND DB_getItem( $_TABLES['blocks'], 'is_enabled', "name='whosonline_block'") == 0 ))
                {
                    $function = $A['phpblockfn'];
                    $blkheader = COM_startBlock( $A['title'], $A['help'],
                            COM_getBlockTemplate( $A['name'], 'header' ));
                    $blkfooter = COM_endBlock( COM_getBlockTemplate( $A['name'],
                            'footer' ));

                    if( function_exists( $function ))
                    {
                        $fretval = $function();
                        if (!empty ($fretval)) {
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

            if( !empty( $A['content'] ) && !$U['noboxes'] )
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
        }
    }

    return $retval;
}

/**
* Checks to see if it's time to import and RDF/RSS block again
*
* Updates RDF/RSS block if needed
*
* @param        string      $bid        Block ID
* @param        string      $rdfurl     URL to get headlines from
* @param        string      $date       Last time the headlines were imported
* @see function COM_rdfImport
* @return   void
*/

function COM_rdfCheck( $bid, $rdfurl, $date )
{
    $retval = false;
    $nextupdate = $date + 3600;

    if( $nextupdate < time() )
    {
        COM_rdfImport( $bid, $rdfurl );
        $retval = true;
    }

    return $retval;
}

/**
* Imports an RDF/RSS block
*
* This will pull content from another site and store it in the database
* to be shown within a portal block
*
* new RDF parser provided by Roger Webster
*
*/

$RDFinsideitem = false;
$RDFtag = '';
$RDFtitle = '';
$RDFlink = '';
$RDFheadlines = array ();

function COM_rdfStartElement( $parser, $name, $attrs )
{
    global $RDFinsideitem, $RDFtag;

    if( $RDFinsideitem )
    {
        $RDFtag = $name;
    }
    elseif( $name == 'ITEM' )
    {
        $RDFinsideitem = true;
    }
}

function COM_rdfEndElement( $parser, $name )
{
    global $RDFinsideitem, $RDFtag, $RDFtitle, $RDFlink, $RDFheadlines;

    if( $name == "ITEM" )
    {
        $RDFtitle = str_replace( '$', '&#36;', $RDFtitle );
        $RDFheadlines[] .= '<a href="' . addslashes( trim( $RDFlink )) . '">' . addslashes( trim( $RDFtitle )) . '</a>';
        $RDFtitle = '';
        $RDFlink = '';
        $RDFinsideitem = false;
    }
}

function COM_rdfCharacterData ($parser, $data)
{
    global $RDFinsideitem, $RDFtag, $RDFtitle, $RDFlink;

    if( $RDFinsideitem )
    {
        switch( $RDFtag )
        {
            case 'TITLE':
                $RDFtitle .= $data;
                break;

            case 'LINK':
                $RDFlink .= $data;
                break;
        }
    }
}

/**
* This is the actual RDF parser (the above are just helper functions)
*
* @param        string      $bid        Block ID
* @param        string      $rdfurl     URL to get content from
* @see function COM_rdfCheck
*
*/

function COM_rdfImport( $bid, $rdfurl )
{
    global $_TABLES, $LANG21,
           $RDFinsideitem, $RDFtag, $RDFtitle, $RDFlink, $RDFheadlines;

    $RDFinsideitem = false;
    $RDFtag = '';
    $RDFtitle = '';
    $RDFlink = '';
    $RDFheadlines = array();

    $update = date( 'Y-m-d H:i:s' );

    $result = DB_change( $_TABLES['blocks'], 'rdfupdated', $update,
                         'bid', $bid );
    clearstatcache();

    $rdferror = false;
    $xml_parser = xml_parser_create();
    xml_set_element_handler( $xml_parser, 'COM_rdfStartElement',
                             'COM_rdfEndElement');
    xml_set_character_data_handler( $xml_parser, 'COM_rdfCharacterData' );

    if( $fp = @fopen( $rdfurl, 'r' ))
    {
        $startoffeed = true;
        while( $data = fread( $fp, 4096 ))
        {
            if( $startoffeed )
            {
                $data = ltrim( $data );
                if( empty( $data ))
                {
                    break;
                }
                $startoffeed = false;
            }
            if( !xml_parse( $xml_parser, $data, feof( $fp )))
            {
                $errmsg = sprintf(
                    "Parse error in %s: %s at line %d",
                    $rdfurl,
                    xml_error_string( xml_get_error_code( $xml_parser )),
                    xml_get_current_line_number( $xml_parser )
                    );

                COM_errorLog( $errmsg, 1 );
                $rdferror = true;
                $result = DB_change( $_TABLES['blocks'], 'content',
                                     addslashes( $LANG21[4] ), 'bid', $bid );
                break;
            }
        }
        if( $startoffeed && empty( $data ))
        {
            $errmsg = sprintf( 'The feed at %s exists but is currently empty.',
                               $rdfurl );
            COM_errorLog( $errmsg, 1 );
            $rdferror = true;
            $result = DB_change( $_TABLES['blocks'], 'content',
                                 addslashes( $LANG21[4] ), 'bid', $bid );
        }

        fclose( $fp );
        xml_parser_free( $xml_parser );

        if( !$rdferror )
        {
            $blockcontent = COM_makeList( $RDFheadlines );
            $RDFheadlines = array();
            $blockcontent = preg_replace( "/(\015\012)|(\015)|(\012)/", '',
                                          $blockcontent );
            $result = DB_change( $_TABLES['blocks'], 'content', $blockcontent,
                                 'bid', $bid);
        }
    }
    else
    {
        $errmsg = sprintf( 'Geeklog can not reach the feed at %s.', $rdfurl );
        COM_errorLog( $errmsg, 1 );
        $rdferror = true;

        $result = DB_change( $_TABLES['blocks'], 'content',
                             addslashes( $LANG21[4] ), 'bid', $bid );
    }
}

/**
* Returns what HTML is allows in content
*
* Returns what HTML tags the system allows to be used inside content.
* You can modify this by changing $_CONF['user_html'] in config.php
* (for admins, see also $_CONF['admin_html']).
*
* @return   string  HTML <span> enclosed string
*/

function COM_allowedHTML()
{
    global $_CONF, $LANG01;

    $retval = '<span class="warningsmall">' . $LANG01[31];

    if( !SEC_hasRights( 'story.edit' ) || empty( $_CONF['admin_html'] ))
    {
        $html = $_CONF['user_html'];
    }
    else
    {
        $html = array_merge( $_CONF['user_html'], $_CONF['admin_html'] );
    }

    $br = 0;
    foreach( $html as $tag => $attr )
    {
        $br++;
        $retval .= '&lt;' . $tag . '&gt;,';
        if( $br == 10 )
        {
            $retval .= ' ';
            $br = 0;
        }
    }

    $retval .= '[code]';
    $retval .= '</span>';

    return $retval;
}

/**
* Return the password for the given username
*
* Fetches a password for the given user
*
* @param        string      $loginname      username to get password for
* @return   string     Password or ''
*
*/

function COM_getpassword( $loginname )
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
        $tmp = $LANG01[32] . ': ' . $loginname;
        COM_errorLog( $tmp, 1 );
    }
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
* @return   string  HTML formated block containing events.
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

    $retval = COM_startBlock( $title, '',
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

    for( $z = 1; $z <= $iterations; $z++ )
    {
        if( $z == 2 )
        {
            $allEvents = DB_query($personaleventsql);
            $numRows = DB_numRows($allEvents);
            $totalrows = $totalrows + $numRows;

            $numDays = 0;          // Without limits, I'll force them.
            $theRow = 1;           // Start with today!
            $oldDate1 = 'no_day';  // Invalid Date!
            $oldDate2 = 'last_d';  // Invalid Date!
            $headline = false;
        }
        else
        {
            $headline = false;
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
                $dayName1 = strftime( "%A", $theTime1 );
                $abbrDate1 = strftime( $dateonly, $theTime1 );

                // End Date strings...
                $endDate = $theEvent['dateend'];
                $theTime2 = strtotime( $endDate );
                $dayName2 = strftime( "%A", $theTime2 );
                $abbrDate2 = strftime( $dateonly, $theTime2 );

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
                             $retval .= COM_makeList( $newevents );
                        }

                        $retval .= '<br><b>' . $dayName1 . '</b>&nbsp;<small>' . $abbrDate1 . '</small>';

                        // If different start and end Dates, then display end date:
                        if( $abbrDate1 != $abbrDate2 )
                        {
                            $retval .= ' - <br><b>' . $dayName2 . '</b>&nbsp;<small>' . $abbrDate2 . '</small>';
                        }
                    }

                    $newevents = array();
                }

                // Now display this event record.
                if( $numDays < $range )
                {
                    // Display the url now!
                    $newevent = '<a href="' . $_CONF['site_url'] . '/calendar_event.php?';

                    if( $z == 2 )
                    {
                        $newevent .= 'mode=personal&amp;';
                    }

                    $newevent .= 'eid=' . $theEvent['eid'] . '">' . stripslashes( $theEvent['title'] ) . '</a>';
                    $newevents[] = $newevent;
                }

                if( !empty( $newevents ))
                {
                    $retval .= COM_makeList( $newevents );
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

    $lastrun = DB_getItem ($_TABLES['vars'], 'value', "name = 'lastemailedstories'");

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
                $mailtext .= "$LANG24[7]: " . $storyauthor . "\n";
            }

            $mailtext .= "$LANG08[32]: " . strftime( $_CONF['date'], strtotime( $S['day' ])) . "\n\n";

            if( $_CONF['emailstorieslength'] > 0 )
            {
                $storytext = COM_undoSpecialChars( stripslashes( strip_tags( $S['introtext'] )));

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
* Shows any new information in block
*
* Return the HTML that shows any new stories, comments, etc
*
* @param        string      $help       Help file for block
* @param        string      $title      Title used in block header
* @return     string  Return the HTML that shows any new stories, comments, etc
*
*/

function COM_whatsNewBlock( $help='', $title='' )
{
    global $_TABLES, $_CONF, $LANG01, $_USER, $_GROUPS, $page, $newstories;

    $retval = COM_startBlock( $title, $help,
                       COM_getBlockTemplate( 'whats_new_block', 'header' ));

    $topicsql = '';
    if(( $_CONF['hidenewstories'] == 0 ) || ( $_CONF['hidenewcomments'] == 0 ))
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
                $topicsql = " AND (tid IN ('" . implode( "','", $tids ) . "'))";
            }
        }
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
            $hours = (( $_CONF['newstoriesinterval'] / 60 ) / 60 );
            if( $nrows == 1 )
            {
                $newmsg = '1 ' . $LANG01[81] . ' ' . $hours . ' ' . $LANG01[82];
                if ($newstories && ($page < 2))
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
                $newmsg = $nrows . ' ' . $LANG01[80] . ' ' . $hours . ' '
                    . $LANG01[82];
                if ($newstories && ($page < 2))  
                {
                    $retval .= $newmsg . '<br>';
                }
                else 
                {
                    $retval .= '<a href="' . $_CONF['site_url']
                        . '/index.php?display=new">' . $newmsg . '</a><br>';
                }
            }
        }
        else
        {
            $retval .= $LANG01[100] . '<br>';
        }

        $retval .= '<br>';
    }

    if( $_CONF['hidenewcomments'] == 0 )
    {
        // Go get the newest comments
        $retval .= '<b>' . $LANG01[83] . '</b> <small>' . $LANG01[85] . '</small><br>';

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

        $powhere = '';

        if( !empty( $_USER['uid'] ))
        {
            $powhere .= "({$_TABLES['pollquestions']}.owner_id IS NOT NULL AND {$_TABLES['pollquestions']}.perm_owner IS NOT NULL) OR ";
            $powhere .= "({$_TABLES['pollquestions']}.group_id IS NOT NULL AND {$_TABLES['pollquestions']}.perm_group IS NOT NULL) OR ";
            $powhere .= "({$_TABLES['pollquestions']}.perm_members IS NOT NULL)";
        }
        else
        {
            $powhere .= "({$_TABLES['pollquestions']}.perm_anon IS NOT NULL)";
        }

        $sql = "SELECT DISTINCT count(*) AS dups, type, question, {$_TABLES['stories']}.title, {$_TABLES['stories']}.sid, qid, max({$_TABLES['comments']}.date) as lastdate FROM {$_TABLES['comments']} LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid)" . COM_getPermSQL( 'AND', 0, 2, $_TABLES['stories'] ) . " AND ({$_TABLES['stories']}.draft_flag = 0)" . $topicsql . ") LEFT JOIN {$_TABLES['pollquestions']} ON ((qid = {$_TABLES['comments']}.sid)" . COM_getPermSQL( 'AND', 0, 2, $_TABLES['pollquestions'] ) . ") WHERE ({$_TABLES['comments']}.date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newcommentsinterval']} SECOND))) AND ((({$stwhere})) OR (({$powhere}))) GROUP BY {$_TABLES['comments']}.sid ORDER BY 7 DESC LIMIT 15";

        $result = DB_query( $sql );

        $nrows = DB_numRows( $result );

        if( $nrows > 0 )
        {
            $newcomments = array();

            for( $x = 1; $x <= $nrows; $x++ )
            {
                $A = DB_fetchArray( $result );

                if(( $A['type'] == 'article' ) || empty( $A['type'] ))
                {
                    $itemlen = strlen( $A['title'] );
                    $titletouse = stripslashes( $A['title'] );
                    $urlstart = '<a href="' . COM_buildUrl( $_CONF['site_url']
                        . '/article.php?story=' . $A['sid'] . '#comments' ) . '"';
                }
                else if( $A['type'] == 'poll' )
                {
                    $itemlen = strlen( $A['question'] );
                    $titletouse = $A['question'];
                    $urlstart = '<a href="' . $_CONF['site_url'] . '/pollbooth.php?qid=' . $A['qid'] . '&amp;aid=-1#comments"';
                }

                if( $itemlen > 20 )
                {
                    $urlstart .= ' title="' . htmlspecialchars( $titletouse ) . '">';
                }
                else
                {
                    $urlstart .= '>';
                }

                // Trim the length if over 20 characters
                if( $itemlen > 20 )
                {
                    $titletouse = substr( $titletouse, 0, 17 );
                    $acomment = str_replace( '$', '&#36;', $titletouse ) . '...';
                    $acomment = str_replace( ' ', '&nbsp;', $acomment );

                    if( $A['dups'] > 1 )
                    {
                        $acomment .= ' [+' . $A['dups'] . ']';
                    }
                }
                else
                {
                    $acomment = str_replace( '$', '&#36;', $titletouse );
                    $acomment = str_replace( ' ', '&nbsp;', $acomment );

                    if( $A['dups'] > 1 )
                    {
                        $acomment .= ' [+' . $A['dups'] . ']';
                    }
                }

                $newcomments[] = $urlstart . $acomment . '</a>';
            }

            $retval .= COM_makeList( $newcomments );
        }
        else
        {
            $retval .= $LANG01[86] . '<br>' . LB;
        }

        $retval .= '<br>';
    }

    if( $_CONF['hidenewlinks'] == 0 )
    {
        // Get newest links
        $retval .= '<b>' . $LANG01[84] . '</b> <small>' . $LANG01[87] . '</small><br>';

        $sql = "SELECT lid,title,url FROM {$_TABLES['links']}"
             . COM_getPermSQL() . ' ORDER BY lid DESC LIMIT 15';
        $foundone = 0;
        $now = time();
        $desired = $now - $_CONF['newlinksinterval'];
        $result = DB_query( $sql );
        $nrows = DB_numRows( $result );

        if( $nrows > 0 )
        {
            $newlinks = array();
            for( $x = 1; $x <= $nrows; $x++ )
            {
                $A = DB_fetchArray( $result );
                $A['title'] = stripslashes( $A['title'] );

                // Need to reparse the date from the link id
                $myyear = substr( $A['lid'], 0, 4 );
                $mymonth = substr( $A['lid'], 4, 2 );
                $myday = substr( $A['lid'], 6, 2 );
                $myhour = substr( $A['lid'], 8, 2 );
                $mymin = substr( $A['lid'], 10, 2 );
                $mysec = substr( $A['lid'], 12, 2 );
                $newtime = "{$mymonth}/{$myday}/{$myyear} {$myhour}:{$mymin}:{$mysec}";
                $convtime = strtotime( $newtime );

                if( $convtime > $desired )
                {
                    $foundone = 1;

                    // redirect link via portal.php so we can count the clicks
                    $lcount = $_CONF['site_url']
                            . '/portal.php?what=link&amp;item=' . $A['lid'];

                    // Trim the length if over 16 characters
                    $itemlen = strlen( $A['title'] );
                    if( $itemlen > 16 )
                    {
                        $newlinks [] = '<a href="' . $lcount . '" title="'
                            . $A['title'] . '">' . substr( $A['title'], 0, 16 )
                            . '...</a>' . LB;
                    }
                    else
                    {
                        $newlinks[] = '<a href="' . $lcount . '">'
                            . substr( $A['title'], 0, $itemlen ) . '</a>' . LB;
                    }
                }
            }
        }

        if( $foundone == 0 )
        {
            $retval .= $LANG01[88] . '<br>' . LB;
        }
        else
        {
            $retval .= COM_makeList( $newlinks );
        }
    }

    if( $_CONF['hidenewplugins'] == 0 )
    {
        list( $headlines, $bylines, $content ) = PLG_getWhatsNew();
        $plugins = sizeof( $headlines );
        if( $plugins > 0 )
        {
            for( $i = 0; $i < $plugins; $i++ )
            {
                $retval .= '<br>';
                $retval .= '<b>' . $headlines[$i] . '</b> <small>'
                        . $bylines[$i] . '</small><br>';
                if( is_array( $content[$i] ))
                {
                    $retval .= COM_makeList( $content[$i] );
                }
                else
                {
                    $retval .= $content[$i] . '<br>' . LB;
                }
            }
        }
    }

    $retval .= COM_endBlock( COM_getBlockTemplate( 'whats_new_block', 'footer' ));

    return $retval;
}

/**
* Displays a message on the webpage
*
* Pulls $msg off the URL string and gets the corresponding message and returns
* it for display on the calling page
*
* @param        int     $msg        ID of message to show
* @return     string  HTML block with message
*/

function COM_showMessage( $msg )
{
    global $MESSAGE, $_CONF;

    $retval = '';

    if( $msg > 0 )
    {
        $timestamp = strftime( $_CONF['daytime'] );
        $retval .= COM_startBlock( $MESSAGE[40] . ' - ' . $timestamp, '',
                           COM_getBlockTemplate( '_msg_block', 'header' ))
            . '<img src="' . $_CONF['layout_url']
            . '/images/sysmessage.gif" border="0" align="top" alt="">'
            . $MESSAGE[$msg] . '<br><br>'
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
* @return   string   HTML formated widget
*/

function COM_printPageNavigation( $base_url, $curpage, $num_pages )
{
    global $LANG05;

    $hasargs = strstr( $base_url, '?' );

    if( $num_pages < 2 ) 
	{
        return;
    }

    $retval = '';

    if( $curpage > 1 )
    {
        if( $hasargs )
        {
            $retval .= '<a href="' . $base_url . '&amp;page=1">' . $LANG05[7] . '</a> | ';
            $retval .= '<a href="' . $base_url . '&amp;page=' . ( $curpage - 1 ) . '">' . $LANG05[6] . '</a> | ';
        } else {
            $retval .= '<a href="' . $base_url . '?page=1">' . $LANG05[7] . '</a> | ';
            $retval .= '<a href="' . $base_url . '?page=' . ( $curpage - 1 ) . '">' . $LANG05[6] . '</a> | ';
        }
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
            if( $hasargs )
            {
                $retval .= '<a href="' . $base_url . '&amp;page=' . $pgcount . '">' . $pgcount . '</a> ';
            }
            else
            {
                $retval .= '<a href="' . $base_url . '?page=' . $pgcount . '">' . $pgcount . '</a> ';
            }
        }
    }

    if( $curpage == $num_pages )
    {
        $retval .= '| ' . $LANG05[5] . ' ';
        $retval .= '| ' . $LANG05[8];
    }
    else
    {
        if( $hasargs )
        {
            $retval .= '| <a href="' . $base_url . '&amp;page=' . ( $curpage + 1 ) . '">' . $LANG05[5] . '</a> ';
            $retval .= '| <a href="' . $base_url . '&amp;page=' . $num_pages . '">' . $LANG05[8] . '</a>';
        } else {
            $retval .= '| <a href="' . $base_url . '?page=' . ( $curpage + 1 ) . '">' . $LANG05[5] . '</a> ';
            $retval .= '| <a href="' . $base_url . '?page=' . $num_pages . '">' . $LANG05[8] . '</a>';
        }
    }

    if( !empty( $retval ))
    {
        $retval = '<div class="pagenav">' . $retval . '</div>';
    }

    return $retval;
}

/**
* Returns formated date/time for user
*
* This function COM_takes a date in either unixtimestamp or in english and
* formats it to the users preference.  If the user didn't specify a format
* the format in the config file is used.  This returns array where array[0]
* is the formated date and array[1] is the unixtimestamp
*
* @param        string      $date       date to format, otherwise we format current date/time
* @return   array   array[0] is the formated date and array[1] is the unixtimestamp.
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
* In account preferences users can specify when their long-term cookie expires.  This
* function returns that value.
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
    global $_CONF, $_TABLES, $LANG01;

    $retval = '';

    $expire_time = time() - $_CONF['whosonline_threshold'];

    $result = DB_query( "SELECT DISTINCT {$_TABLES['sessions']}.uid, username,photo,showonline FROM {$_TABLES['sessions']},{$_TABLES['users']},{$_TABLES['userprefs']} WHERE {$_TABLES['users']}.uid = {$_TABLES['sessions']}.uid AND {$_TABLES['users']}.uid = {$_TABLES['userprefs']}.uid AND start_time >= $expire_time AND {$_TABLES['sessions']}.uid <> 1 ORDER BY username" );
    $nrows = DB_numRows( $result );

    $num_anon = 0;

    for( $i = 1; $i <= $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );

        if( $A['showonline'] == 1 ) {

            $retval .= '<a href="' . $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $A['uid'] . '">'
                    . $A['username'] . '</a>';

            if( !empty( $A['photo'] ) AND $_CONF['allow_user_photo'] == 1)
            {
                $retval .= '&nbsp;<a href="' . $_CONF['site_url']
                        . '/users.php?mode=profile&amp;uid=' . $A['uid']
                        . '"><img src="' . $_CONF['layout_url']
                        . '/images/smallcamera.gif" border="0" alt=""></a>';
            }
            $retval .= '<br>';

        } else {
            // this user does not want to show up in Who's Online
            $num_anon++; // count as anonymous
        }
    }

    $result = DB_query( "SELECT DISTINCT uid,remote_ip FROM {$_TABLES['sessions']} WHERE uid = 1" );
    $num_anon += DB_numRows( $result );

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

function COM_makeList( $listofitems )
{
    global $_CONF;

    $list = new Template( $_CONF['path_layout'] );
    $list->set_file( array( 'list'     => 'list.thtml',
                            'listitem' => 'listitem.thtml' ));
    $list->set_var( 'layout_url', $_CONF['layout_url'] );
    $list->set_var( 'site_url', $_CONF['site_url'] );

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
* @return       int      0 = does not apply, else: seconds since last post
*/
function COM_checkSpeedlimit ($type = 'submit')
{
    global $_TABLES, $REMOTE_ADDR;

    $last = 0;

    $date = DB_getItem ($_TABLES['speedlimit'], 'date',
                        "(type = '$type') AND (ipaddress = '$REMOTE_ADDR')");
    if (!empty ($date)) {
        $last = time () - $date;
        if ($last == 0) {
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
function COM_updateSpeedlimit ($type = 'submit')
{
    global $_TABLES, $REMOTE_ADDR;

    DB_save ($_TABLES['speedlimit'], 'ipaddress,date,type',
             "'$REMOTE_ADDR',unix_timestamp(),'$type'");
}

/**
* Clear out expired speed limits, i.e. entries older than 'x' seconds
*
* @param speedlimit   int      number of seconds
* @param type         string   type of speed limit, e.g. 'submit', 'comment'
*
*/
function COM_clearSpeedlimit ($speedlimit = 60, $type = '')
{
    global $_TABLES;

    $sql = "DELETE FROM {$_TABLES['speedlimit']} WHERE ";
    if (!empty ($type)) {
        $sql .= "(type = '$type') AND ";
    }
    $sql .= "(date < unix_timestamp() - $speedlimit)";
    DB_query ($sql);
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
* @param        array       $names      Names of arguments in query string to assign to values
* @return   boolean     True if suscessful
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
                $foo = (int)(( $rate / $seconds ) + .5 );

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
* Extract links from an HTML-formatted text.
*
* Collects all the links in a story and returns them in an array.
*
* @param        string      $fulltext   the text to search for links
* @param        int         $maxlength  max. length of text in a link (can be 0)
* @return       array       an array of strings of form <a href="...">link</a>
*/

function COM_extractLinks( $fulltext, $maxlength = 26 )
{
    $rel = array();

    /* [href|name] needs to replace href below at the least, it would be better
     * to find a method that will work in all cases however.
     */
    preg_match_all( "/(<a.*?href=\"(.*?)\".*?>)(.*?)(<\/a>)/i", $fulltext, $matches );
    for ( $i=0; $i< count( $matches[0] ); $i++ )
    {
        $matches[3][$i] = strip_tags( $matches[3][$i] );
        if ( !strlen( trim( $matches[3][$i] ) ) ) {
            $matches[3][$i] = strip_tags( $matches[2][$i] );
        }

        // if link is too long, shorten it and add ... at the end
        if ( ( $maxlength > 0 ) && ( strlen( $matches[3][$i] ) > $maxlength ) )
        {
            $matches[3][$i] = substr( $matches[3][$i], 0, $maxlength - 3 ) . '...';
        }

        $rel[] = $matches[1][$i] . $matches[3][$i] . $matches[4][$i];
    }

    return( $rel );
}

/**
* Create "What's Related" links for a story
*
* Creates an HTML-formatted list of links to be used for the What's Related
* block next to a story (in article view).
*
* @param        string      $fulltext   the story text
* @param        int         $uid        user id of the author
* @param        int         $tid        topic id
* @return       string      HTML-formatted list of links
*/

function COM_whatsRelated( $fulltext, $uid, $tid )
{
    global $_CONF, $_TABLES, $LANG24;

    // collect any links from the story text
    $rel = COM_extractLinks( $fulltext );

    if( !empty( $_USER['username'] ) || (( $_CONF['loginrequired'] == 0 ) &&
           ( $_CONF['searchloginrequired'] == 0 ))) {
        // add a link to "search by author"
        if( $_CONF["contributedbyline"] == 1 )
        {
            $author = DB_getItem( $_TABLES['users'], 'username', "uid = $uid" );
            $rel[] = "<a href=\"{$_CONF['site_url']}/search.php?mode=search&amp;type=stories&amp;author=$uid\">{$LANG24[37]} $author</a>";
        }

        // add a link to "search by topic"
        $topic = DB_getItem( $_TABLES['topics'], 'topic', "tid = '$tid'" );
        $rel[] = "<a href=\"{$_CONF['site_url']}/search.php?mode=search&amp;type=stories&amp;topic=$tid\">{$LANG24[38]} $topic</a>";
    }

    $related = '';
    if( sizeof( $rel ) > 0 )
    {
        $related = COM_checkWords( COM_makeList( $rel ));
    }

    return( $related );
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
*/
function COM_getPermSQL( $type = 'WHERE', $u_id = 0, $access = 2, $table = '' )
{
    global $_USER, $_GROUPS;

    if( !empty( $table ))
    {
        $table .= '.';
    }

    if( $u_id <= 0 )
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
    global $HTTP_SERVER_VARS;

    $log_manipulation = false; // set to true to log when the filter applied

    $p = COM_stripslashes( $parameter );
    $p = strip_tags( $p );
    $p = COM_killJS( $p ); // doesn't help a lot right now, but still ...

    if( $isnumeric )
    {
        // Note: PHP's is_numeric() accepts values like 4e4 as numeric
        if( !is_numeric( $p ) || ( preg_match( '/^([0-9]+)$/', $p ) == 0 ))
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
        $pa = explode( '\\', $pa[0] );
        $p = $pa[0];
    }

    if( $log_manipulation )
    {
        if( strcmp( $p, $parameter ) != 0 )
        {
            COM_errorLog( "Filter applied: >> $parameter << filtered to $p [IP {$HTTP_SERVER_VARS['REMOTE_ADDR']}]", 1);
        }
    }

    return $p;
}

/**
* Detect links in a plain-ascii texts and turn them into clickable links.
* Will detect links starting with "http:", "https:", "ftp:", and "www".
*
* Derived from a newgroup posting by Andreas Schwarz in
* news:de.comp.lang.php <aieq4p$12jn2i$3@ID-16486.news.dfncis.de>
*
* @param    string    $text     the (plain-ascii) text string
* @return   string    the same string, with links enclosed in <a>...</a> tags
*
*/
function COM_makeClickableLinks( $text )
{
    $text = preg_replace( '/((((ht|f)tps?):(\/\/)|www)[a-z0-9%&_\-\+,;=:@~#\/.\?\[\]]+(\/|[+0-9a-z]))/is', '<a href="\\1">\\1</a>', $text );
    $text = str_replace( '<a href="www', '<a href="http://www', $text );

    return $text;
}


// Now include all plugin functions
$result = DB_query( "SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_enabled = 1" );
$nrows = DB_numRows( $result );

for( $i = 0; $i < $nrows; $i++ )
{
    $A = DB_fetchArray( $result );
    require_once( $_CONF['path'] . 'plugins/' . $A['pi_name'] . '/functions.inc' );
}

?>
