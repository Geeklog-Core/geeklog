<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-common.php                                                            |
// | Geeklog common library.                                                   |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            | 	
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     | 
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
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
// $Id: lib-common.php,v 1.14 2001/12/14 16:01:40 tony_bibbs Exp $

// Turn this on go get various debug messages from the code in this library
$_COM_VERBOSE = false; 

// +---------------------------------------------------------------------------+
// | Configuration Include: You shoud only have to modify this include         | 
// +---------------------------------------------------------------------------+
include_once('/path/to/geeklog/config.php');

// +---------------------------------------------------------------------------+
// | Library Includes: You shouldn't have to touch anything below here         | 
// +---------------------------------------------------------------------------+

// Instantiate page timer that times how fast each page is created
include_once($_CONF['path_system'] . 'classes/timer.class.php');
$_PAGE_TIMER = new timerobject();
$_PAGE_TIMER->startTimer();

include_once($_CONF['path_system'] . 'classes/template.class.php');
include_once($_CONF['path_system'] . 'lib-database.php');
include_once($_CONF['path_system'] . 'lib-security.php');
include_once($_CONF['path_system'] . 'lib-custom.php');
include_once($_CONF['path_system'] . 'lib-plugins.php');
include_once($_CONF['path_system'] . 'lib-sessions.php');


// Set theme
// Need to modify this code to check if theme was cached in user cookie.  That way
// if user logged in and set theme and then logged out we would still know which
// theme to show them.
if ($_CONF['allow_user_themes'] == 1) {
    if (isset($HTTP_COOKIE_VARS['theme']) && empty($_USER['theme'])) {
        if (is_dir($_CONF['path_themes'] . $HTTP_COOKIE_VARS['theme'])) {
            $_USER['theme'] = $HTTP_COOKIE_VARS['theme'];
        }
    }
    if (!empty($_USER['theme'])) {
        $_CONF['theme'] = $_USER['theme'];
        $_CONF['path_layout'] = $_CONF['path_themes'] . $_CONF['theme'] . '/';
        $_CONF['layout_url'] = $_CONF['site_url'] . '/layout/' . $_CONF['theme'];
        if (file_exists($_CONF['path_layout'] . 'functions.php')) {
            include_once($_CONF['path_layout'] . 'functions.php');
        }
    }
} 

// Similarly set language
if (isset($HTTP_COOKIE_VARS['language']) && empty($_USER['language'])) {
    if (is_file($_CONF['path_language'] . $HTTP_COOKIE_VARS['language'] . '.php')) {
        $_USER['language'] = $HTTP_COOKIE_VARS['language'];
        $_CONF['language'] = $HTTP_COOKIE_VARS['language'];
    }
} else if (!empty($_USER['language'])) {
    if (is_file($_CONF['path_language'] . $_USER['language'] . '.php')) {
        $_CONF['language'] = $_USER['language'];
    }
}
include_once($_CONF['path'] . 'language/' . $_CONF['language'] . '.php');

setlocale(LC_ALL, $_CONF['locale']);

// Get user permissions
$_RIGHTS = explode(',',SEC_getUserPermissions());

// +---------------------------------------------------------------------------+
// | BLOCK LOADER: Load all definable HTML blocks in to memory                 | 
// +---------------------------------------------------------------------------+

$result = DB_query("SELECT title,content FROM {$_TABLES['blocks']} WHERE type = 'layout'");
$nrows = DB_numRows($result);
for ($i = 1; $i <= $nrows; $i++) {
    $A = DB_fetchArray($result);
    $BLOCK[$A['title']] = $A['content'];
}

// +---------------------------------------------------------------------------+
// | STORY FUNCTIONS                                                           | 
// +---------------------------------------------------------------------------+

/**
* Displays the array passed to it as an article
*
* Displays the given article data in formatted HTML
*
* @A		array		Data to display as an article
* @index	string		
*
*/
function COM_article($A,$index='') 
{
    global $_TABLES,$mode,$_CONF,$LANG01,$_USER;
	
    if (!empty($_USER['uid'])) {
        $result = DB_query("SELECT noicons FROM {$_TABLES['userprefs']} WHERE uid = {$_USER['uid']}",1);
        $nrows = DB_numRows($result);
        if ($nrows == 1) {
            $U = DB_fetchArray($result);
            $_USER['noicons'] = $U['noicons'];
        }
    }

	$curtime = COM_getUserDateTimeFormat($A['day']);
	$A['day'] = $curtime[0];

    $article = new Template($_CONF['path_layout']);
    $article->set_file(array('article'=>'storytext.thtml','bodytext'=>'storybodytext.thtml'));
    $article->set_var('story_title',$A['title']);
    $article->set_var('site_url',$_CONF['site_url']);
    $article->set_var('story_date',$A['day']);

    if ($_CONF['contributedbyline'] == 1) {
        if ($A['uid'] > 1) {
            $article->set_var('lang_contributed_by',$LANG01[1]);
            $article->set_var('start_contributedby_anchortag', '<a class="storybyline" href="'.$_CONF['site_url'].'/users.php?mode=profile&uid='.$A['uid'].'">');
            $article->set_var('contributedby_user', DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'"));
            $article->set_var('end_contributedby_anchortag', '</a>');
        } else {
            $article->set_var('contrributedby_user', $LANG01[1].' '.DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'"));
        }
    }
	
    if ($_USER['noicons'] != 1) {
        $top = DB_getItem($_TABLES['topics'],'imageurl',"tid = '{$A['tid']}'");
        if (!empty($top)) { 
            $article->set_var('story_anchortag_and_image', '<a href="'.$_CONF['site_url'].'/index.php?topic='.$A['tid'].'"><img align="'.$_CONF['article_image_align'].'" src="'.$_CONF['site_url'].$top.'" alt="'.$A['tid'].'" border="0"></a>');
        }
    }
   
    if ($index == 'n') {
        $article->set_var('story_introtext', stripslashes($A['introtext']) . '<br><br>'.nl2br(stripslashes($A['bodytext'])));
    } else {
        $article->set_var('story_introtext', stripslashes($A['introtext'])); 
        if (!empty($A['bodytext'])) {
            $article->set_var('readmore_link', '<a href="' .  $_CONF['site_url'] . '/article.php?story=' . $A['sid'] . '">' . $LANG01[2] . '</a> (' . sizeof(explode(' ',$A['bodytext'])) . ' ' . $LANG01[62] . ') ');
        }
        if ($A['commentcode'] >= 0 && $A['comments'] > 0) {
            $article->set_var('comments_url',$_CONF['site_url'].'/article.php?story='.$A['sid'].'#comments');
            $article->set_var('comments_text', $A['comments'] . ' ' . $LANG01[3]);

            $result = DB_query("SELECT UNIX_TIMESTAMP(date) AS day FROM {$_TABLES['comments']} WHERE sid = '{$A['sid']}' ORDER BY date desc LIMIT 1");
            $C = DB_fetchArray($result);
            $recent_post_anchortag = '<span class="storybyline">'.$LANG01[27].': '.strftime($_CONF['daytime'],$C['day']).'</span>';
        } else if ($A['commentcode'] >= 0) {
            $recent_post_anchortag = ' <a href="'.$_CONF['site_url'].'/comment.php?sid='.$A['sid'].'&pid=0&type=article">'.$LANG01[60].'</a>';
        }
	$article->set_var('email_icon', '<a href="' . $_CONF['site_url'] . '/profiles.php?sid=' . $A['sid'] . '&what=emailstory">' 
            . '<img src="' . $_CONF['layout_url'] . '/images/mail.gif" alt="' . $LANG01[64] . '" border="0"></a>');
	$article->set_var('print_icon', '<a href="' . $_CONF['site_url'] . '/article.php?story=' . $A['sid'] . '&mode=print"><img border="0" src="' . $_CONF['layout_url'] . '/images/print.gif" alt="' . $LANG01[65] . '"></a>');
    }

    $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);

    if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) == 3 AND SEC_hasrights('story.edit')) {
	    $article->set_var('edit_link', '<a href="'.$_CONF['site_url'].'/admin/story.php?mode=edit&sid='.$A['sid'].'">'.$LANG01[4].'</a>');
    }

    $article->set_var('recent_post_anchortag', $recent_post_anchortag);
	
    $article->parse('story_bodyhtml','bodytext',true);
    $article->parse('finalstory','article');

    return $article->finish($article->get_var('finalstory'));
}

// +---------------------------------------------------------------------------+
// | HTML WIDGETS                                                              |
// +---------------------------------------------------------------------------+

/**
* Return the file to use for a block template
*
* This returns the template needed to build the HTML for a block
*
* @blockname        string      block name to get template for
* @which            string      indicates whether to return header template or footer template
*
*/
function COM_getBlockTemplate($blockname,$which)
{
    global $_BLOCK_TEMPLATE, $_COM_VERBOSE;

    if ($_COM_VERBOSE) {
        COM_errorLog("_BLOCK_TEMPLATE[$blockname] = " . $_BLOCK_TEMPLATE[$blockname], 1);
    }

    if (!empty($_BLOCK_TEMPLATE[$blockname])) {
        $templates = explode(',',$_BLOCK_TEMPLATE[$blockname]);
        if ($which == 'header') {
            if (!empty($templates[0])) {
                $template = $templates[0];
            } else {
                $template = 'blockheader.thtml';
            }
        } else {
            if (!empty($templates[1])) {
                $template = $templates[1];
            } else {
                $template = 'blockfooter.thtml';
            }
        }
    } else {
        if ($which == 'header') {
            $template = 'blockheader.thtml';
        } else {
            $template = 'blockfooter.thtml';
        }
    }

    if ($_COM_VERBOSE) {
        COM_errorLog("Block template for the $which of $blockname is: $template", 1);
    }

    return $template;

}

/**
* Gets all installed themes
*
* Gets all directory names in /path/to/geeklog/themes/ and returns all the 
* directories
*
*/
function COM_getThemes()
{
    global $_CONF;

    $index = 1;

    $themes = array();

    $fd = opendir($_CONF['path_themes']); 

    // If users aren't allowed to change their theme then only return the 
    // default theme
    if ($_CONF['allow_user_themes'] == 0) {
        $themes[$index] = $_CONF['theme'];
    } else {
        while (($dir = @readdir($fd)) == TRUE) {
            if (is_dir($_CONF['path_themes'].$dir) && $dir <> '.' && $dir <> '..' && $dir <> 'CVS') {
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
* HTML for the site header.
*
*/
function COM_siteHeader($what = 'menu')
{
    global $_CONF, $_USER, $LANG01, $_COM_VERBOSE, $topic;
  
    // If the theme implemented this for us then call their version
    // instead.
    $function = $_CONF['layout'] . '_siteHeader';
    if (function_exists($function)) {
        return $function();
    }
  
    // If we reach here then either we have the default theme OR
    // the current theme only needs the default variable substitutions 
    $header = new Template($_CONF['path_layout']);
    $header->set_file(array('header'=>'header.thtml','menuitem'=>'menuitem.thtml','leftblocks'=>'leftblocks.thtml'));
    $header->set_var('page_title', $_CONF['site_name'] . ' - ' . $_CONF['site_slogan']);
    $header->set_var('background_image', $_CONF['layout_url'] . '/images/bg.gif'); 
    $header->set_var('site_url', $_CONF['site_url']);
    $header->set_var('layout_url', $_CONF['layout_url']);
    $header->set_var('site_email', $_CONF['site_mail']);
    $header->set_var('site_name', $_CONF['site_name']);
    $msg = '&nbsp;'.$LANG01[67].' '.$_CONF['site_name'];
    if (!empty($_USER['username'])) {
        $msg .= ', '.$_USER['username'];
    }
    $header->set_var('welcome_msg', $msg); 
    $curtime =  COM_getUserDateTimeFormat();
    $header->set_var('datetime', $curtime[0]);
    $header->set_var('site_logo', $_CONF['layout_url'] . '/images/logo.gif' );
    $header->set_var('css_url', $_CONF['layout_url'] . '/style.css');
    $header->set_var('theme', $_CONF['theme']);
    // Now add nested template for menu items

    // contribute link
    $header->set_var('menuitem_url', $_CONF['site_url'] . '/submit.php?type=story');
    $header->set_var('menuitem_text', $LANG01[71]);
    $header->parse('menu_elements', 'menuitem', true);
    
    // links link
    $header->set_var('menuitem_url', $_CONF['site_url'] . '/links.php');
    $header->set_var('menuitem_text', $LANG01[72]);
    $header->parse('menu_elements', 'menuitem', true);

    // polls link
    $header->set_var('menuitem_url', $_CONF['site_url'] . '/pollbooth.php');
    $header->set_var('menuitem_text', $LANG01[73]);
    $header->parse('menu_elements', 'menuitem', true);

    // calendar link
    $header->set_var('menuitem_url', $_CONF['site_url'] . '/calendar.php');
    $header->set_var('menuitem_text', $LANG01[74]);
    $header->parse('menu_elements', 'menuitem', true);

    // Get plugin menu options
    $plugin_menu = PLG_getMenuItems();

    if ($_COM_VERBOSE) {
        COM_errorLog('num plugin menu items in header = ' . count($plugin_menu),1);
    }

    for ($i = 1; $i <= count($plugin_menu); $i++) {
        $header->set_var('menuitem_url', current($plugin_menu));
        $header->set_var('menuitem_text', key($plugin_menu));
        $header->parse('plg_menu_elements', 'menuitem', true);
        next($plugin_menu);
    }
    if (count($plugin_menu) == 0) $header->set_var('plg_menu_elements', '&nbsp;');

    // Search link 
    $header->set_var('menuitem_url', $_CONF['site_url'] . '/search.php');
    $header->set_var('menuitem_text', $LANG01[75]);
    $header->parse('menu_elements', 'menuitem', true);

    // Stats link 
    $header->set_var('menuitem_url', $_CONF['site_url'] . '/stats.php');
    $header->set_var('menuitem_text', $LANG01[76]);
    $header->parse('menu_elements', 'menuitem', true);
   
    if ($what <> 'none') { 
        // Now show any blocks
        $header->set_var('geeklog_blocks',COM_showBlocks('left', $topic));
        $header->parse('left_blocks','leftblocks',true);
    } else {
        //$header->set_var('geeklog_blocks', '');
        $header->set_var('left_blocks', '');
    }

    // The following line allows users to embed PHP in their templates.  This
    // is almost a contradition to the reasons for using templates but this may
    // prove useful at times...don't use PHP in templates if you can live without it
    $tmp = $header->parse('index_header','header');
    return eval("?>".$tmp); 
    return $header->finish($header->get_var('index_header'));
}

/**
* Returns the site footer 
*
* This loads the proper templates, does variable substitution and returns the 
* HTML for the site footer.
*
*/
function COM_siteFooter()
{
    global $_CONF, $LANG01, $_PAGE_TIMER, $_TABLES;

    // If the theme implemented this for us then call their version
    // instead.
    $function = $_CONF['layout'] . '_siteFooter';
    if (function_exists($function)) {
        return $function();
    }

    // Set template directory   
    $footer = new Template($_CONF['path_layout']);

    // Set template file
    $footer->set_file('footer','footer.thtml');

    // Do variable assignments
    DB_change($_TABLES['vars'],'value','value + 1','name','totalhits','',true);

    $footer->set_var('site_url', $_CONF['site_url']);
    $footer->set_var('copyright_notice', '&nbsp;'.$LANG01[93].' &copy; 2001 '.$_CONF['site_name'].'<br>&nbsp;'.$LANG01[94]);
    $footer->set_var('geeklog_version', VERSION);
    $footer->set_var('execution_time', $_PAGE_TIMER->stopTimer());

    // Actually parse the template and make variable substitutions
    $footer->parse('index_footer','footer');

    // Return resulting HTML
    return $footer->finish($footer->get_var('index_footer'));

}

/**
* Prints out standard block header
* 
* Prints out standard block header but pulling header HTML formatting from 
* the database.  THIS IS GOING AWAY SOON AND REPLACED BY TEMPLATE FUNCTIONS
*
* @title        string      Value to set block title to
* @help         string      Help file, if one exists
*
*/
function COM_startBlock($title='', $helpfile='', $template='blockheader.thtml') 
{
    global $BLOCK,$LANG01,$_CONF;

    $block = new Template($_CONF['path_layout']);
    $block->set_file('block', $template);
    $block->set_var('layout_url', $_CONF['layout_url']);
    $block->set_var('block_title',$title);
    if (!empty($helpfile)) {
        $help = '<a class="blocktitle" href="' . $_CONF['site_url'] . '/help/' . $helpfile 
            . '" target="_blank"><img src="' . $_CONF['layout_url'] 
            . '/images/button_help.gif" border="0" height="15" width="15" alt="?"></a>';
        $block->set_var('block_help',$help); 
    }

    $block->parse("startHTML",'block'); 

    return $block->finish($block->get_var('startHTML')); 
}

/**
* Closes out startcomment and COM_startBlock
*
* THIS IS GOING AWAY SOON - WILL BE REPLACED BY NEW BLOCK/TEMPLATE FUNCTIONS
*
*/
function COM_endBlock($template='blockfooter.thtml') 
{
    global $_CONF, $BLOCK;

    $block = new Template($_CONF['path_layout']);
    $block->set_file('block', $template);
    $block->parse("endHTML",'block');                               

    return $block->finish($block->get_var('endHTML'));
}

/**
* Prints Admin option on moderation.php
*
* This prints an image/label pair on moderation.php  This will more than likely
* be going away so use sparingly
*
* @type     string      Type of adminedit we are creating
* @text     string      Text label
*
*/
function COM_adminEdit($type,$text='') 
{
    global $LANG01,$_CONF;
	
    if (!HandlePluginAdminEdit($type)) {
        $retval .= '<table border="0" cellspacing="0" cellpadding=2 width="100%">'.LB
            .'<tr><td rowspan="2"><img src="'.$_CONF['site_url'].'/images/icons/'.$type.'.gif"></td>'.LB
            .'<td>[ <a href="'.$_CONF['site_url'].'/admin/'.$type.'.php?mode=edit">'.$LANG01[52].' '.$type.'</a> | <a href="'.$_CONF['site_url'].'/admin">'.$LANG01[53].'</a> ]</td></tr>'.LB
            .'<tr><td>'.$text.'</td></tr>'.LB
            .'</table><br>';
    }
	
    return $retval;
}

/**
* Same as COM_startBlock, but set up for the comments
*
* THIS IS GOING AWAY SOON - WILL BE REPLACED BY NEW BLOCK/TEMPLATE FUNCTIONS
*
*/
function COM_startComment() 
{
    $retval .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">'.LB
        .'<tr><td><table width="100%" border="0" cellspacing="0" cellpadding=3>'.LB;
	
    return $retval;
}


/**
* Creates a <option> list from a database list for use in forms
*
* Creates option list form field using given arguments
*
* @table        string      Table to get data from
* @selection    string      Comma delimited string of fields to pull
* @selected     string      Value to set to SELECTED
* @sortcol      int         Which field to sort option list by
*
*/
function COM_optionList($table,$selection,$selected='',$sortcol=1) 
{
    $tmp = str_replace('DISTINCT ', '', $selection);
    $select_set = explode(',',$tmp);
    
    $result = DB_query("SELECT $selection FROM $table ORDER BY $select_set[$sortcol]");
    $nrows = DB_numRows($result);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $retval .= '<option value="' . $A[0] . '"';
        if ($A[0] == $selected) { 
            $retval .= ' selected'; 
        }
        $retval .= '>' . $A[1] . '</option>' . LB;
    }
	
    return $retval;
}

/**
* Creates a <input> checklist from a database list for use in forms
*
* Creates a group of checkbox form fields with given arguments
*
* @table        string      Table to pull data from
* @selection    string      Comma delimited list of fields to pull from table
* @where        string      Where clause
* @selected     string      Value to set to CHECKED
*
*/ 
function COM_checkList($table,$selection,$where='',$selected='') 
{
    global $_TABLES, $_COM_VERBOSE;

    $sql = "SELECT $selection FROM $table";

    if (!empty($where)) {
        $sql .= " WHERE $where";
    }
	
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if (!empty($selected)) {
        if ($_COM_VERBOSE) {
            COM_errorLog("exploding selected array: $selected in COM_checkList", 1);
        }
        $S = explode(' ',$selected);
    } else {
        if ($_COM_VERBOSE) {
            COM_errorLog("selected string was empty COM_checkList",1);
        }
    }

    for ($i = 0; $i < $nrows; $i++) {
        $access = true;
        $A = DB_fetchArray($result);

        if ($table == 'topics' AND SEC_hasTopicAccess($A['tid']) == 0) {
            $access = false;
        }

        if ($access) {
            $retval .= '<input type="checkbox" name="'.$table.'[]" value="'.$A[0].'"';
            for ($x = 0; $x < sizeof($S); $x++) {
                if ($A[0] == $S[$x]) {
                    $retval .= ' checked="CHECKED"';
                }
            }
            if ($A[2] < 10 && $A[2] > 0) {
                $retval .= '><b>' . $A[1] . '</b><br>' . LB;
            } else {
                $retval .= '>' . $A[1] . '<br>' . LB;
            }
        }
    }

    return $retval;
}

/**
* Prints out the HTTP headers post information for debugging
*
* The core of this code has been lifted from phpweblog which is licenced
* under the GPL.
*
* @A        array       Array to loop through and print values for
*/
function COM_debug($A) 
{
    if (!empty($A)) {
        $retval .= "<pre><p>---- DEBUG ----\n";
        for (reset($A); $k = key($A); next($A)) {
            $retval .= sprintf("<li>%13s [%s]</li>\n",$k,$A[$k]);
        }
        $retval .= "<br>---------------\n</pre>\n";
    }
	
    return $retval;
}

/**
* Creates a vaild RDF file from the stories
*
* The core of this code has been lifted from phpweblog which is licenced
* under the GPL.
*
*/
function COM_exportRDF() 
{
    global $_TABLES, $_CONF, $_COM_VERBOSE;

    if ($_CONF['backend']>0) {
        $outputfile = $_CONF['rdf_file'];
        $rdencoding = "UTF-8";
        $rdtitle = $_CONF['site_name'];
        $rdlink	= $_CONF['site_url'];
        $rddescr = $_CONF['site_slogan'];
        $rdlang	= $_CONF['locale'];
        $result = DB_query("SELECT * FROM {$_TABLES['stories']} WHERE uid > 1 AND draft_flag = 0 ORDER BY date DESC limit 10");

        if (!$file = @fopen($outputfile,w)) {
            COM_errorLog("{LANG01[54]} $outputfile",1);
        } else {
            fputs ( $file, "<?xml version=\"1.0\" encoding=\"$rdencoding\"?>\n\n" );
            fputs ( $file, "<!DOCTYPE rss PUBLIC \"-//Netscape Communications//DTD RSS 0.91//EN\"\n \"http://my.netscape.com/publish/formats/rss-0.91.dtd\">\n" );
            fputs ( $file, "<rss version=\"0.91\">\n\n" );
            fputs ( $file, "<channel>\n" );
            fputs ( $file, "<title>$rdtitle</title>\n ");
            fputs ( $file, "<link>$rdlink</link>\n");
            fputs ( $file, "<description>$rddescr</description>\n");
            fputs ( $file, "<language>$rdlang</language>\n\n");
            while ($row = DB_fetchArray($result)) {
                $title = 'title';
                $link = 'sid';
                $author = 'author';
                fputs ( $file, "<item>\n" );
                $title = "<title>" . htmlspecialchars(stripslashes($row[$title])) . "</title>\n";
                $author = "<author>" . htmlspecialchars(stripslashes($row[$author])) . "</author>\n";
                $link  = "<link>{$_CONF['site_url']}/article.php?story={$row[$link]}</link>\n";
                fputs ( $file,  $title );
                fputs ( $file,  $link );
                fputs ( $file, "</item>\n\n" );
            }
        }
        fputs ( $file, "</channel>\n");
        fputs ( $file, "</rss>\n");
        fclose( $file );
    }
}

/**
* Logs messages to error.log or the web page or both
*
* Prints a well formatted message to either the web page, error log
* or both.
*
* @actionid     int     (1) write to log (2) write to screen (default) both
*
*/
function COM_errorLog($logentry, $actionid = '') 
{
    global $_CONF, $LANG01;

    $retval = '';
	
    if (!empty($logentry)) {
        $timestamp = strftime("%c");
        switch ($actionid) {
        case 1:
            $logfile = $_CONF['path_log'] . 'error.log';
            if (!$file = fopen($logfile,a)) {
                $retval .= $LANG01[33] . ' ' . $logfile . ' (' . $timestamp . ')<br>' . LB;
            }
            fputs ($file, "$timestamp - $logentry \n");
            break;
        case 2:
            $retval .= COM_startBlock($LANG01[55] . ' ' . $timestamp)
                . nl2br($logentry)
                . COM_endBlock();
                break;
        default:
            $logfile = $_CONF['path_log'] . 'error.log';
            if (!$file = fopen($logfile,a)) {
                $retval .= $LANG01[33] . ' ' . $logfile . ' (' . $timestamp . ')<br>' . LB;
            }
            fputs ($file, "$timestamp - $logentry \n");
            $retval .= COM_startBlock($LANG01[34] . ' - ' . $timestamp)
                . nl2br($logentry)
                . COM_endBlock();
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
* @logentry     string      Message to write
* 
*/
function COM_accesslog($logentry) 
{
    global $_CONF,$LANG01;
	
    $timestamp = strftime("%c");
    $logfile = $_CONF['path_log'] . 'access.log';

    if (!$file=fopen($logfile,a)) {
        $retval .= $LANG01[33] . $logfile . ' (' . $timestamp . ')<br>' . LB;
    }

    fputs ($file, "$timestamp - $logentry \n");

    return $retval;
}

/**
* Shows a poll form
* 
* Shows an HTML formatted poll for the given question ID
*
* @qid      string      ID for poll question
*
*/
function COM_pollVote($qid) 
{
    global $_TABLES,$HTTP_COOKIE_VARS,$REMOTE_ADDR,$LANG01,$_CONF;
	
    $question = DB_query("SELECT * FROM {$_TABLES['pollquestions']} WHERE qid='$qid'");
    $Q = DB_fetchArray($question);

    if (SEC_hasAccess($Q['owner_id'],$Q['group_id'],$Q['perm_owner'],$Q['perm_group'],$Q['perm_members'],$Q['perm_anon']) == 0) {
        return $retval;
    }
	
    $nquestion = DB_numRows($question);
    $id = DB_count($_TABLES['pollvoters'],'ipaddress',$REMOTE_ADDR,'qid',$qid);

    if (empty($HTTP_COOKIE_VARS[$qid]) && $id == 0) {
        if ($nquestion == 1) {
            $answers = DB_query("SELECT answer,aid FROM {$_TABLES['pollanswers']} WHERE qid='$qid'");
            $nanswers = DB_numRows($answers);

            if ($nanswers > 0) {
                $retval .= '<form action="' . $_CONF['site_url'] . '/pollbooth.php" name="Vote" method="GET">' . LB
                    . COM_startBlock($LANG01[5],'',COM_getBlockTemplate('poll_block', 'header'))
                    . '<input type="hidden" name="qid" value="' . $qid . '">' . LB
                    . '<h2>' . $Q['question'] . '</h2>' . LB;
					
                for ($i=1; $i<=$nanswers; $i++) {
                    $A = DB_fetchArray($answers);
                    $retval .= '<input type="radio" name="aid" value="' .$A['aid'] . '">' . $A['answer'] . '<br>' . LB;
                }

                $retval .= '<input type="submit" value="' . $LANG01[56] . '">' . LB
                    . '<a href="' . $_CONF['site_url'] . '/pollbooth.php?qid=' . $qid . '&aid=-1">' . $LANG01[6] . '</a><br>'
                    . '<span class="storybyline" align="right">' . $Q['voters'] . ' ' . $LANG01[8];

                if ($Q['commentcode'] >= 0) {
                    $retval .= ' | <a href="' . $_CONF['site_url'] . '/pollbooth.php?qid=' . $qid . '&aid=-1#comments">'
                        . DB_count($_TABLES['comments'],'sid',$qid) . ' ' . $LANG01[3] . '</a>';
                }
				
                $retval .= '</span>'
                    . COM_endBlock(COM_getBlockTemplate('poll_block', 'footer'))
                    . '</form>'.LB;
            }
        }
    } else {
        $retval .= COM_pollResults($qid);
    }
	
    return $retval;
}

/**
* This shows a poll
*
* This will determine if a user needs to see the poll form OR the poll
* result.
*
* @size         int         ??
* @qid          string      Question ID to show (optional)
*
*/
function COM_showPoll($size,$qid='') 
{
    global $_TABLES,$HTTP_COOKIE_VARS,$REMOTE_ADDR,$_CONF;
	
	DB_query("DELETE FROM {$_TABLES['pollvoters']} WHERE date < unix_timestamp() - {$_CONF['polladdresstime']}");

	if (!empty($qid)) {
		$id = DB_count($_TABLES['pollvoters'],'ipaddress',$REMOTE_ADDR,'qid',$qid);

		if (empty($HTTP_COOKIE_VARS[$qid]) && $id == 0) {
			$retval .= COM_pollVote($qid);
		} else {
			$retval .= COM_pollResults($qid,$size);
		}
	} else {
		$result = DB_query("SELECT qid from {$_TABLES['pollquestions']} WHERE display = 1");
		$nrows = DB_numRows($result);

		if ($nrows > 0) {
			for ($i = 1; $i <= $nrows; $i++) {
				$Q = DB_fetchArray($result);
				$qid = $Q['qid'];
				$id = DB_count($_TABLES['pollvoters'],'ipaddress',$REMOTE_ADDR,'qid',$qid);

				if (empty($HTTP_COOKIE_VARS[$qid]) && $id == 0) {
					$retval .= COM_pollVote($qid);
				} else {
					$retval .= COM_pollResults($qid,$size);
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
* @qid      string      ID for poll question to show
* @scale    int         Size to scale formatted results to
* @order    string      ??
* @mod      string      ??
*
*/
function COM_pollResults($qid,$scale=400,$order='',$mode='') 
{
	global $_TABLES,$LANG01,$_CONF, $_COM_VERBOSE;
	
	$question = DB_query("SELECT * FROM {$_TABLES['pollquestions']} WHERE qid='$qid'");
	$Q = DB_fetchArray($question);

	if (SEC_hasAccess($Q['owner_id'],$Q['group_id'],$Q['perm_owner'],$Q['perm_group'],$Q['perm_members'],$Q['perm_anon']) == 0) {
		return;
	}

	$nquestion = DB_numRows($question);

	if ($nquestion == 1) {
		$answers = DB_query("SELECT * FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY votes DESC");
		$nanswers = DB_numRows($answers);
        if ($_COM_VERBOSE) {
            COM_errorLog("got $answers answers in COM_pollResults",1);
        }
		if ($nanswers > 0) {
            $title = DB_getItem($_TABLES['blocks'],'title',"name='poll_block'");
			$retval .= COM_startBlock($title, '', COM_getBlockTemplate('poll_block', 'header'))
				. '<h2>' . $Q['question'] . '</h2>'
				.'<table border="0" cellpadding="3" cellspacing="0" align="center">' . LB;

			for ($i = 1; $i <= $nanswers; $i++) {
				$A = DB_fetchArray($answers);

				if ($Q['voters'] == 0) {
					$percent = 0;
				} else {
					$percent = $A['votes'] / $Q['voters'];
				}

				$retval .= '<tr>' . LB
					. '<td align="right"><b>' . $A['answer'] . '</b></td>' . LB
					. '<td>';

				if ($scale < 120) {
					$retval .= sprintf("%.2f", $percent * 100) . '% </td>' . LB;
				} else {
					$width = $percent * $scale;
					$retval .= '<img src="' . $_CONF['layout_url'] . '/images/bar.gif" width="' . $width
                        . '" height="10" align="bottom"> '
						. $A['votes'] . ' ' . sprintf("(%.2f)",$percent * 100) . '%' . '</td>' . LB;
				}

				$retval .= '</tr>' . LB;
			}
			$retval .= '</table>' . LB . '<div class="storybyline" align="right">' . $Q['voters'] . ' '
                . $LANG01[8] . LB;

			if ($Q['commentcode'] >= 0) {
				$retval .= ' | <a href="' .$_CONF['site_url'] . '/pollbooth.php?qid=' . $qid.'&aid=-1#comments">'
                    . DB_count($_TABLES['comments'],'sid',$qid) . ' ' . $LANG01[3] . '</a>';
			}

			$retval .= '</div>'. LB . COM_endBlock(COM_getBlockTemplate('poll_block', 'footer'));
				
			if ($scale > 399 && $Q['commentcode'] >= 0) {
				$retval .= COM_userComments($qid,$Q['question'],'poll',$order,$mode);
			}
		}
	}

	return $retval;
}

/** 
* Shows all available topics
*
* Show the topics in the system the user has access to and prints them in HTML
* 
* @topic        string      ??
*
*/
function COM_showTopics($topic='') 
{
    global $_TABLES, $_CONF, $_USER, $LANG01, $PHP_SELF;
	
    if ($_CONF['sortmethod'] == 'alpha') {
        $result = DB_query("SELECT * FROM {$_TABLES['topics']} ORDER BY tid ASC");
    } else {
        $result = DB_query("SELECT * FROM {$_TABLES['topics']} ORDER BY sortnum");
    }

    $nrows = DB_numRows($result);

    // Give a link to the hompage here since a lot of people use this for navigating the site

    if (($PHP_SELF <> "/index.php") OR !empty($topic)) {
        $retval .= '<a href="' . $_CONF['site_url'] . '/index.php"><b>' . $LANG01[90] . '</b></a><br>';
    } else {
        $retval .= $LANG01[90] . '<br>';
    }

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
            if ($A['tid']==$topic) {
                $retval .= $A['topic'];
                if ($_CONF['showstorycount'] + $_CONF['showsubmissioncount'] > 0) {
                    $retval .= ' (';
                    if ($_CONF['showstorycount']) {
                        $retval .= DB_count($_TABLES['stories'],'tid',$A['tid']);
                    }
                    if ($_CONF['showstorycount']) {
                        if ($_CONF['showstorycount']) {
                            $retval .= '/';
                        }
                        $retval .= DB_count($_TABLES['storysubmission'],'tid',$A['tid']);
                    }
                    $retval .= ')';
                }
                $retval .= '<br>' . LB;
            } else {
                $retval .= '<a href="' . $_CONF['site_url'] . '/index.php?topic=' . $A['tid']
                    . '"><b>' . $A['topic'] . '</b></a> ';
                if ($_CONF['showstorycount'] + $_CONF['showsubmissioncount'] > 0) {
                    $retval .= '(';
                    if ($_CONF['showstorycount']) {
                        $retval .= DB_count($_TABLES['stories'],'tid',$A['tid']);
                    }
                    if ($_CONF['showsubmissioncount']) {
                        if ($_CONF['showstorycount']) {
                            $retval .= '/';
                        }
                        $retval .= DB_count($_TABLES['storysubmission'],'tid',$A['tid']);
                    }
                    $retval .= ')';
                }
                $retval .= '<br>' . LB;
            }
        }
    }
	
    return $retval;
}

/**
* Shows the user their menu options
*
* This shows the average joe use their menu options
*
*/
function COM_userMenu($title='') 
{
    global $_TABLES, $_USER, $_CONF, $LANG01;

    if ($_USER['uid'] > 1) {
        $adminmenu = new Template($_CONF['path_layout']);
        $adminmenu->set_file('option', 'useroption.thtml');

        if (empty($title)) {
            $title = DB_getItem($_TABLES['blocks'],'title',"name='user_block'");
        }
        $retval .= COM_startBlock($title,'',COM_getBlockTemplate('user_block', 'header'));
			
        if ($_CONF['personalcalendars'] == 1) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/calendar.php?mode=personal');
            $adminmenu->set_var('option_label', $LANG01[66]);
            $adminmenu->set_var('option_count', '');
            $retval .= $adminmenu->parse('item', 'option');
        }

        // This function will show the user options for all installed plugins (if any)
        $plugin_options = PLG_getUserOptions();
        $nrows = count($plugin_options);
        for ($i = 1; $i <= $nrows; $i++) {
            $plg = current($plugin_options);
            $adminmenu->set_var('option_url', $plg->adminurl);
            $adminmenu->set_var('option_label', $plg->adminlabel);
            if (!empty($plg->numsubmissions)) {
                $adminmenu->set_var('option_count', '(' . $plg->numsubmissions . ')');
            } else {
                $adminmenu->set_var('option_count', '');
            }
            $retval .= $adminmenu->parse('item', 'option');
            next ($plugin_options);
        }
        $adminmenu->set_var('option_url', $_CONF['site_url'] . '/usersettings.php?mode=edit');
        $adminmenu->set_var('option_label', $LANG01[48]);
        $adminmenu->set_var('option_count', '');
        $retval .= $adminmenu->parse('item', 'option');

        $adminmenu->set_var('option_url', $_CONF['site_url'] . '/usersettings.php?mode=preferences');
        $adminmenu->set_var('option_label', $LANG01[49]);
        $adminmenu->set_var('option_count', '');
        $retval .= $adminmenu->parse('item', 'option');

        $adminmenu->set_var('option_url', $_CONF['site_url'] . '/usersettings.php?mode=comments');
        $adminmenu->set_var('option_label', $LANG01[63]);
        $adminmenu->set_var('option_count', '');
        $retval .= $adminmenu->parse('item', 'option');

        $adminmenu->set_var('option_url', $_CONF['site_url'] . '/users.php?mode=logout');
        $adminmenu->set_var('option_label', $LANG01[19]);
        $adminmenu->set_var('option_count', '');
        $retval .= $adminmenu->parse('item', 'option');

        $retval .=  COM_endBlock(COM_getBlockTemplate('user_block', 'footer'));
    } else {
        $retval .= COM_startBlock($LANG01[47])
            . '<form action="' . $_CONF['site_url'] . '/users.php" method="post">' . LB
            . '<b>' . $LANG01[21] . ':</b><br>' . LB
            . '<input type="text" size="10" name="loginname" value=""><br>' . LB
            . '<b>' . $LANG01[57] . ':</b><br>' . LB
            . '<input type="password" size="10" name="passwd"><br>' . LB
            . '<input type="submit" value="' . $LANG01[58] . '">' . LB
            . '</form>' . $LANG01[59] . LB
            . COM_endBlock(COM_getBlockTemplate('user_block', 'footer'));
    }

    return $retval;

}

/**
* Prints administration menu
*
* This will return the administration menu items that the user has
* sufficient rights to
*
*/
function COM_adminMenu($title='') 
{
    global $_TABLES, $_USER, $_CONF, $LANG01;

    if (SEC_isModerator() OR SEC_hasrights('story.edit,block.edit,topic.edit,link.edit,event.edit,poll.edit,user.edit,plugin.edit,user.mail','OR')) {
        $adminmenu = new Template($_CONF['path_layout']);
        $adminmenu->set_file('option', 'adminoption.thtml');

        if (empty($title)) {
            $title = DB_getItem($_TABLES['blocks'],'title',"name='admin_block'");
        }
	    $retval .= COM_startBlock($title,'',COM_getBlockTemplate('admin_block', 'header'));
        if (SEC_isModerator()) {
            $num = DB_count($_TABLES['storysubmission'],'uid',0) + 
                    DB_count($_TABLES['eventsubmission'],'eid',0) + 
                    DB_count($_TABLES['linksubmission'],'lid',0);

            //now handle submissions for plugins
            $num = $num + PLG_getSubmissionCount();
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/moderation.php');
            $adminmenu->set_var('option_label', $LANG01[10]);
            $adminmenu->set_var('option_count', $num);
            $retval .= $adminmenu->parse('item', 'option');
        }
        if (SEC_hasrights('story.edit')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/story.php');
            $adminmenu->set_var('option_label', $LANG01[11]);
            $adminmenu->set_var('option_count', DB_count($_TABLES['stories']));
            $retval .= $adminmenu->parse('item', 'option');
        }
        if (SEC_hasrights('block.edit')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/block.php');
            $adminmenu->set_var('option_label', $LANG01[12]);
            $adminmenu->set_var('option_count', DB_count($_TABLES['blocks']));
            $retval .= $adminmenu->parse('item', 'option');
        }
        if (SEC_hasrights('topic.edit')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/topic.php');
            $adminmenu->set_var('option_label', $LANG01[13]);
            $adminmenu->set_var('option_count', DB_count($_TABLES['topics']));
            $retval .= $adminmenu->parse('item', 'option');
        }
        if (SEC_hasrights('link.edit')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/link.php');
            $adminmenu->set_var('option_label', $LANG01[14]);
            $adminmenu->set_var('option_count', DB_count($_TABLES['links']));
            $retval .= $adminmenu->parse('item', 'option');
        }
        if (SEC_hasrights('event.edit')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/event.php');
            $adminmenu->set_var('option_label', $LANG01[15]);
            $adminmenu->set_var('option_count', DB_count($_TABLES['events']));
            $retval .= $adminmenu->parse('item', 'option');
        }
        if (SEC_hasrights('poll.edit')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/poll.php');
            $adminmenu->set_var('option_label', $LANG01[16]);
            $adminmenu->set_var('option_count', DB_count($_TABLES['pollquestions']));
            $retval .= $adminmenu->parse('item', 'option');
        }
        if (SEC_hasrights('user.edit')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/user.php');
            $adminmenu->set_var('option_label', $LANG01[17]);
            $adminmenu->set_var('option_count', (DB_count($_TABLES['users'])-1));
            $retval .= $adminmenu->parse('item', 'option');
        }
        if (SEC_hasrights('group.edit')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/group.php');
            $adminmenu->set_var('option_label', $LANG01[96]);
            $adminmenu->set_var('option_count', DB_count($_TABLES['groups']));
            $retval .= $adminmenu->parse('item', 'option');
        }
        if (SEC_hasrights('plugin.edit')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/plugins.php');
            $adminmenu->set_var('option_label', $LANG01[77]);
            $adminmenu->set_var('option_count', DB_count($_TABLES['plugins']));
            $retval .= $adminmenu->parse('item', 'option');
        }

        // This function will show the admin options for all installed plugins (if any)
        $plugin_options = PLG_getAdminOptions();
        $nrows = count($plugin_options);
        for ($i = 1; $i <= $nrows; $i++) {
            $plg = current($plugin_options);
            $adminmenu->set_var('option_url', $plg->adminurl);
            $adminmenu->set_var('option_label', $plg->adminlabel);
            if (empty($plg->numsubmissions)) {
                $adminmenu->set_var('option_count', 'N/A');
            } else {
                $adminmenu->set_var('option_count', $plg->numsubmissions);
            }
            $retval .= $adminmenu->parse('item', 'option', true);
            next($plugin_options);
        }
             

        if (SEC_hasrights('user.mail')) {
            $adminmenu->set_var('option_url', $_CONF['site_url'] . '/admin/mail.php');
            $adminmenu->set_var('option_label', 'Mail');
            $adminmenu->set_var('option_count', 'N/A');
            $retval .= $adminmenu->parse('item', 'option');
        }

        $adminmenu->set_var('option_url', 'http://geeklog.sourceforge.net/versionchecker.php?version=' . VERSION);
        $adminmenu->set_var('option_label', 'GL Version Test');
        $adminmenu->set_var('option_count', 'N/A');
        $retval .= $adminmenu->parse('item', 'option');
        $retval .= COM_endBlock();
    }
    return $retval;
}

/** 
* Redirects user to a given URL
*
* This function COM_passes a meta tag to COM_refresh after a form is sent.  This is
* necessary because for some reason Netscape and PHP4 don't play well with
* the header() function COM_100% of the time.
*
* @url      string      URL to send user to
*
*/
function COM_refresh($url) 
{
	return "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
}

/**
* This function displays the comment control bar
*
* Prints the control that allows the user to interact with Geeklog Comments
*
* @sid          string      ID of item in question
* @title        string      Title of item
* @type         string      Type of item (i.e. story, photo, etc)
* @order        string      Order that comments are displayed in
* @mode         string      Mode (nested, flat, etc.)
*
*/
function COM_commentBar($sid,$title,$type,$order,$mode) 
{
    global $_TABLES, $LANG01, $_USER, $_CONF;
	
    $nrows = DB_count($_TABLES['comments'],'sid',$sid);
    $retval .= '<a name="comments"></a>';
	
    // Build comment control bar

    $retval .= '<table cellspacing="0" cellpadding="0" border="0" width="100%">' . LB
        . '<tr><td align="center" class="commentbar1"><b>' . stripslashes($title) . '</b> | '
        . $nrows . ' ' . $LANG01[3] . ' | ';

    if (!empty($_USER['username'])) {
        $retval .= $_USER['username'] . ' <a href="' . $_CONF['site_url'] . '/users.php?mode=logout" class="commentbar1">'
            . $LANG01[35] . '</a>';
    } else {
        $retval .= '<a href="' . $_CONF['site_url'] . '/users.php?mode=new" class="commentbar1">' . $LANG01[61] . '</a>';
    }

    $retval .= '</td></tr>' . LB . '<tr><td align="center" class="commentbar2">';

    if ($type == 1) {
        $retval .= '<form action="' . $_CONF['site_url'] . '/pollbooth.php" method="POST">' . LB
            . '<input type="hidden" name="scale" value="400">' . LB
            . '<input type="hidden" name="qid" value="'.$sid.'">' . LB
            . '<input type="hidden" name="aid" value="-1">' . LB;
    } else {
        $retval .= '<form action="' . $_CONF['site_url'] . '/article.php" method="POST">' . LB
            . '<input type="hidden" name="story" value="' . $sid . '">' . LB;
    }
	
    // Order
	
    $retval .= '<select name="order">'
        . COM_optionList($_TABLES['sortcodes'],'code,name',$order)
        .'</select> ';
	
    // Mode
	
    $retval .= '<select name="mode">'
        . COM_optionList($_TABLES['commentmodes'],'mode,name',$mode)
        . '</select> '
        . '<input type="submit" value="'. $LANG01[39] . '"> '
        . '<input type="hidden" name="type" value="'.$type . '">'
        . '<input type="hidden" name="pid" value="0">'
        . '<input type="submit" name="reply" value="' . $LANG01[25] . '"></form></td></tr>' . LB
        . '<tr><td align="center" class="commentbar3">' . $LANG01[26] . '</td></tr>' . LB
        . '</table>' . LB;
	
    return $retval;
}

/**
* This function displays the comments in a high level format.
*
* Begins displaying user comments for an item
*
* @sid          string      ID for item to show comments for
* @title        string      Title of item
* @type         string      Type of item (article,photo,link,etc.)
* @order        string      How to order the comments
* @mode         string      comment mode (nested, flat, etc.)
* @pid          int         ???
*
*/
function COM_userComments($sid,$title,$type='article',$order='',$mode='',$pid=0) 
{
    global $_TABLES, $_CONF,$LANG01,$_USER;
	
    if (!empty($_USER['uid']) && empty($order) && empty($mode)) {
        $result = DB_query("SELECT commentorder,commentmode,commentlimit FROM {$_TABLES['usercomment']} WHERE uid = '{$_USER['uid']}'");
        $U = DB_fetchArray($result);
        $order = $U['commentorder'];
        $mode = $U['commentmode'];
        $limit = $U['commentlimit'];
    }
	
    if (empty($order)) {
        $order = 'ASC';
    }

    if (empty($mode)) {
        $mode = $_CONF['comment_mode'];
    }

    if (empty($limit)) {
        $limit = $_CONF['comment_limit'];
    }
	
    switch ($mode) {
    case 'nocomments':
        $retval .= COM_commentBar($sid,$title,$type,$order,$mode);
		break;
    case 'nested':
        $result = DB_query("SELECT *,unix_timestamp(date) AS nice_date FROM {$_TABLES['comments']} WHERE sid = '$sid' AND pid = 0 ORDER BY date $order LIMIT $limit");
        $nrows = DB_numRows($result);
        $retval .= COM_commentBar($sid,$title,$type,$order,$mode);

        if ($nrows>0) {
            $retval .= COM_startComment();
            for ($i = 0; $i < $nrows; $i++) {
                $A = DB_fetchArray($result);
                $retval .= COM_comment($A,0,$type,0,$mode);
                $retval .= COM_commentChildren($sid,$A['cid'],$order,$mode,$type);
            }
            $retval .= '</td></tr></table></td></tr></table>';
        } else {
            $retval .= COM_startComment()
                . '<tr><td class="commenttitle" align="center">' . $LANG01[29] . '</td></tr></table></td></tr></table>';
        }
        break;
    case 'flat':
        $result = DB_query("SELECT *,unix_timestamp(date) AS nice_date FROM {$_TABLES['comments']} WHERE sid = '$sid' ORDER BY date $order LIMIT $limit");
        $nrows = DB_numRows($result);
        $retval .= COM_commentBar($sid,$title,$type,$order,$mode);
        if ($nrows>0) {
            $retval .= COM_startComment();
            for ($i =0; $i < $nrows; $i++) {
                $A = DB_fetchArray($result);
                $retval .= COM_comment($A,0,$type,0,$mode);
            }
            $retval .= '</td></tr></table></td></tr></table>';
        } else {
            $retval .= COM_startComment()
                . '<tr><td class="commenttitle" align="center">' . $LANG01[29] . '</td></tr></table></td></tr></table>';
        }
        break;
    case 'threaded':
        $result = DB_query("SELECT *,unix_timestamp(date) AS nice_date FROM {$_TABLES['comments']} WHERE sid = '$sid' AND pid = $pid ORDER BY date $order LIMIT $limit");
        $nrows = DB_numRows($result);
        $retval .= COM_commentBar($sid,$title,$type,$order,$mode);
        if ($nrows > 0) {
            $retval .= COM_startComment();
            for ($i = 0; $i < $nrows; $i++) {
                $A = DB_fetchArray($result);
                $retval .= COM_comment($A,0,$type,0,$mode)
                    . '<tr><td>'
                    . COM_commentChildren($sid,$A['cid'],$order,$mode,$type)
                    . '</td></tr>';
            }
            $retval .= '</td></tr></table></td></tr></table>';
        } else {
            $retval .= COM_startComment()
            . '<tr><td class="commenttitle" align="center">' . $LANG01[29] . '</td></tr></table></td></tr></table>';
        }
        break;
    }
	
    return $retval;
}

/**
* Prints the next level of children for a given comment
*
* This is called recursivley to display all the comments for a given
* comment 
*
* @sid          string      ID for item comments belong to
* @pid          string      ??
* @order        string      Order to show comments in
* @mode         string      Mode (e.g. nested, flat, etc)
* @type         string      Type of item (article, photo, link, etc.)
* @level        int         How deep in comment thread we are
*
*/
function COM_commentchildren($sid,$pid,$order,$mode,$type,$level=0) 
{
    global $_TABLES,$_CONF;
	
    $result = DB_query("SELECT *,unix_timestamp(date) AS nice_date FROM {$_TABLES['comments']} WHERE sid = '$sid' AND pid = $pid ORDER BY date $order");
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        if ($mode == 'threaded') { 
            $retval .= '<ul>'; 
        }
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $retval .= COM_comment($A,0,$type,$level+1,$mode)
                . COM_commentChildren($sid,$A['cid'],$order,$mode,$type,$level+1);
        }
        if ($mode == 'threaded') {
            $retval .= '</ul>'; 
        }
    } 
    return $retval;
}

###############################################################################
# This function COM_print $A in comment format

function COM_comment($A,$mode=0,$type,$level=0,$mode='flat',$ispreview=false) 
{
    global $_TABLES, $_CONF, $LANG01, $_USER, $order;
	
    $level = $level * 25;
	
    // if no date, make it now!
    if (empty($A['nice_date'])) {
        $A['nice_date'] = time(); 
    }

    if ($mode == 'threaded' && $level > 0) {
        $retval .= '<li><b><a href="' . $_CONF['site_url'] . '/comment.php?mode=display&sid=' . $A['sid']
            . '&title=' . urlencode($A['title']) . '&type=' . $type . '&order=' . $order . '&pid=' . $A['pid'].'">'
            . $A['title'] . '</a></b> - ' . $LANG01[42] . ' ';

        if ($A['uid'] == 1) {
            $retval .= $LANG01[24];
        } else {
            $retval .= '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&uid=' . $A['uid'] . '">'
                . DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'") . '</a>';
        }

        $A['nice_date'] = strftime($_CONF['date'], $A['nice_date']);
        $retval .= ' ' . $LANG01[36] . ' ' . $A['nice_date'] . LB;
    } else {
        if ($level > 0) {
            $retval .= '<tr><td><table border="0" cellpadding="0" cellspacing="0" width="100%">' . LB
                . '<tr><td rowspan="3" width="' . $level . '"><img src="' . $_CONF['site_url'] 
                . '/images/speck.gif" width="' . $level . '" height="100%"></td>' . LB;
        } else {
            $retval .= '<tr>';
        }

        $retval .= '<td class="commenttitle">' . stripslashes($A['title']) . '</td></tr>' . LB
            . '<tr><td>' . $LANG01[42] . ' ';

        if ($A['uid'] == 1) {
            $retval .= $LANG01[24];
        } else {
            $retval .= '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&uid=' . $A['uid'] . '">'
                . DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'") .'</a>';
        }

        $A['nice_date'] = strftime($_CONF['date'],$A['nice_date']);
        $retval .= ' on ' . $A['nice_date'] . '</td></tr>' . LB
            . '<tr><td valign="top">' . nl2br(stripslashes($A['comment']));

        if ($mode == 0 && $ispreview == false) {
            $retval .= '<p>[ <a href="' . $_CONF['site_url'] . '/comment.php?sid=' . $A['sid'] . '&pid='
                . $A['cid'] . '&title=' . rawurlencode($A['title']) . '&type=' . $type . '">' . $LANG01[43]
            . '</a> ';
			
            // Until I find a better way to parent, we're stuck with this...
            if ($mode == 'threaded' && $A['pid'] != 0) {
                $result = DB_query("SELECT title,pid from {$_TABLES['comments']} where cid = '{$A['pid']}'");
                $P = DB_fetchArray($result);
                $retval .= '| <a href="' . $_CONF['site_url'] . '/comment.php?mode=display&sid=' . $A['sid']
                    . '&title=' . rawurlencode($P['title']) . '&type=' . $type . '&order=' . $order . '&pid=' 
                    . $P['pid'] . '">' . $LANG01[44] . '</a> ';
            }
			
            if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) == 3) {
                $retval .= '| <a href="' . $_CONF['site_url'] . '/comment.php?mode=' . $LANG01[28] . '&cid=' 
                    . $A['cid'] . '&sid=' . $A['sid'] . '&type=' . $type . '">'  . $LANG01[28] . '</a> ';
            }
			
            $retval .= ']<br>';
        }
		
        $retval .= '</td></tr>' . LB;
		
        if ($level > 0) {
            $retval .= '</table></td></tr>' . LB;
        }
    }
	
    return $retval;
}

/**
* This censors inappropriate content
*
* This will replace 'bad words' with something more appropriate
*
* @message          string      String to check
*
*/
function COM_checkWords($Message) 
{
    global $_CONF;

    $EditedMessage = $Message;
    if ($_CONF["censormode"] != 0) {
        if (is_array($_CONF["censorlist"])) {
            $Replacement = $_CONF["censorreplace"];
            if ($_CONF["censormode"] == 1) { # Exact match
                $RegExPrefix   = '([^[:alpha:]]|^)';
                $RegExSuffix   = '([^[:alpha:]]|$)';
            } elseif ($_CONF["censormode"] == 2) {    # Word beginning
                $RegExPrefix   = '([^[:alpha:]]|^)';
                $RegExSuffix   = '[[:alpha:]]*([^[:alpha:]]|$)';
            } elseif ($_CONF["censormode"] == 3) {    # Word fragment
                $RegExPrefix   = '([^[:alpha:]]*)[[:alpha:]]*';
                $RegExSuffix   = '[[:alpha:]]*([^[:alpha:]]*)';
            }
            for ($i = 0; $i < count($_CONF["censorlist"]) && $RegExPrefix != ''; $i++) {
                $EditedMessage = eregi_replace($RegExPrefix.$_CONF["censorlist"][$i].$RegExSuffix,"\\1$Replacement\\2",$EditedMessage);
            }
        }
    }
    return ($EditedMessage);
}

/**
* This function COM_checks html tags.
*
* The core of this code has been lifted from phpslash which is licenced under
* the GPL.
*
* @str      string      HTML to check
*
*/
function COM_checkHTML($str) 
{
    global $_CONF;
	
    $str = stripslashes($str);

    // Get rid of any newline characters
	
    $str = preg_replace("/\n/","",$str);
    $str = strip_tags($str,$_CONF['allowablehtml']);

    return $str;
}

/**
* Makes an ID based on current date/time
*
* This function COM_creates a 17 digit sid for stories based on the 14 digit date
* and a 3 digit random number that was seeded with the number of microseconds
* (.000001th of a second) since the last full second.
*
*/
function COM_makesid() 
{
    $sid = date("YmdHis");
    srand((double)microtime()*1000000);
    $sid .= rand(0,999);

    return $sid;
}

/**
* checks to see if email address is valid
*
* This function COM_checks to see if an email address is in the correct from
*
* @email        string      Email address to verify
*
*/
function COM_isemail($email) 
{
    if (eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*.[a-z]{2,3}$", $email, $check)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
* Returns older stuff block
*
* Creates the olderstuff block for display.
*
*/
function COM_olderstuff() 
{
    global $_TABLES, $_CONF, $LANG01;

    if ($_CONF['olderstuff'] == 1) {
        $result = DB_query("SELECT sid,title,comments,unix_timestamp(date) AS day FROM " 
        . $_TABLES['stories'] . " WHERE draft_flag = 1 ORDER BY date desc LIMIT {$_CONF['limitnews']}, {$_CONF['limitnews']}");
        $nrows = DB_numRows($result);

        if ($nrows>0) {
            $day = 'noday';
            $string = '';
            for ($i = 0; $i < $nrows; $i++) {
                $A = DB_fetchArray($result);
                $daycheck = strftime("%A",$A['day']);
                if ($day != $daycheck) {
                    $day2 = strftime("%m/%d",$A['day']);
                    $day = $daycheck;
                    $string .= '<br><b>' . $day . '</b> <small>' . $day2 . '</small><br>' . LB;
                }
                $string .= '<li><a href="' . $_CONF['site_url'] . '/article.php?story=' . $A['sid']
                    . '">' . $A['title'] . '</a> (' . $A['comments'] . ')' . LB;
        }

        $string = addslashes($string);
        DB_delete($_TABLES['blocks'],'title',"'{$LANG01[30]}'");
        DB_save($_TABLES['blocks'],'title,blockorder,content',"'{$LANG01[30]}','{$_CONF['olderstufforder']}','$string'");
        }
    }
}

/** 
* Shows a single Geeklog block
*
* This shows a single block and is typically called from
* COM_showBlocks OR from plugin code
*
* @name     string      Logical name of block (not same as title)
*
*/
function COM_showBlock($name,$title='')
{
    global $_CONF;

    switch ($name) {
    case 'user_block':
        $retval .= COM_userMenu($title);
        break;
    case 'admin_block':
        $retval .= COM_adminMenu($title);
        break;
    case 'section_block':
        $retval .= COM_startBlock($title,'', COM_getBlockTemplate($name,'header')) 
            . COM_showTopics($topic) 
            . COM_endBlock(COM_getBlockTemplate($name,'footer'));
        break;
    case 'events_block':
        if (!$U['noboxes'] && $_CONF['showupcomingevents']) {
            $retval .= COM_printUpcomingEvents($title);
        } 
        break;
    case 'poll_block':
        $retval .= COM_showPoll(60);
        break;
    case 'whats_new_block':
        if (!$U['noboxes']) {
            $retval .= COM_whatsNewBlock($title);
        }
        break;
    }

    return $retval;

}

/**
* Shows Geeklog blocks
*
* Returns HTML for blocks on a given side and, potentially, for
* a given topic
* 
* @side     string      Side to get blocks for (right or left for now)
* @topic    string      Only get blocks for this topic
*
*/
function COM_showBlocks($side, $topic='', $name='all') 
{
    global $_TABLES, $_CONF, $_USER, $LANG21;

    // Get user preferences on blocks
	
    if (!empty($_USER['uid'])) {
        $result = DB_query("SELECT boxes,noboxes FROM {$_TABLES['userindex']} WHERE uid = '{$_USER['uid']}'");
        $U = DB_fetchArray($result);
    }
	
    if ($side == 'left') {
        $sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) as date FROM {$_TABLES['blocks']} WHERE onleft = 1";
    } else {
        $sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) as date FROM {$_TABLES['blocks']} WHERE onleft = 0";
    }

    if (!empty($topic)) {
        $sql .= " AND (tid = '$topic' OR (tid = 'all' AND type <> 'layout'))";
    } else {
        $sql .= " AND (tid = 'homeonly' OR (tid = 'all' AND type != 'layout'))";
    }

    if (!empty($U['boxes'])) {
        $BOXES = explode(' ',$U['boxes']);
        $sql .= ' AND (';

        for ($i = 0; $i < sizeof($BOXES); $i++) {
            $sql .= "bid = '$BOXES[$i]' OR ";
        }

        $result = DB_query("SELECT bid FROM {$_TABLES['blocks']} WHERE name = 'user_block' OR name= 'section_block'");
        $nrows = DB_numRows($result);

        for ($i = 1; $i <= $nrows; $i++) {
            $A = DB_fetchArray($result);
            $sql .= "bid = '" . $A['bid'] . "' OR ";
        }

        $sql .= "bid = '-1')";

    } else {
        $sql .= ' AND blockorder < 10';
    }
    
    $sql .= ' ORDER BY blockorder,title asc';
    COM_errorLog('sql = ' . $sql,1);
    $result	= DB_query($sql);
    $nrows = DB_numRows($result);	
    COM_errorLog("nrows = $nrows",1);
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        COM_errorLog("name = " . $A['name'],1);
        if ($A['type'] == 'portal') {
            COM_rdfCheck($A['bid'],$A['rdfurl'],$A['date']);
        }

        if ($A['type'] == 'gldefault') {
            $retval .= COM_showBlock($A['name'],$A['title']);
        }

        if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
            if ($A['type'] == 'phpblock' && !$U['noboxes']) {
                $function = $A['phpblockfn'];
                $retval .= COM_startBlock($A['title']);

                if (function_exists($function)) {
                    // great, call it
                    $retval .= $function();
                } else {
                    // show friendly error message
                    $retval .= $LANG21[31];
                }
                $retval .= COM_endBlock();
            }
            if (!empty($A['content']) && !$U['noboxes']) {
                $retval .= COM_startBlock($A['title']) . nl2br(stripslashes($A['content'])) . '<br>' . LB
                    . COM_endBlock();
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
* @bid      string      Block ID
* @rdfurl   string      URL to get headlines from
* @date     string      Last time the headlines were imported
*
*/
function COM_rdfCheck($bid,$rdfurl,$date) 
{
    $nextupdate = $date + 3600;

    if ($nextupdate < time()) {
        COM_rdfImport($bid,$rdfurl);
    }
}

/**
* Imports an RDF/RSS block
*
* This will pull content from another site and store it in the database
* to be shown within a portal block
*
* @bid          string      Block ID
* @rdfurl       string      URL to get content from
*
*/
function COM_rdfimport($bid,$rdfurl) 
{
    global $_TABLES;

    $update = date("Y-m-d H:i:s");
    $result = DB_change($_TABLES['blocks'],'rdfupdated',"$update",'bid',$bid);
    clearstatcache();

    if ($fp = fopen($rdfurl, 'r')) {
        $rdffile = file($rdfurl);
        fclose($fp);
        $num = count($rdffile);

        if ($num > 1) {
            for ($i = 0; $i < $num; $i++) {
                if ($rdffile[$i] == '') {
                    continue;
                }

                if (ereg("<([^<>]*)>([^<>]*)?",$rdffile[$i],$regs)) {
                    $item = $regs[1];
                    $data = $regs[2];
                    if ($item=='channel' || $item=='image' || $item=='item') {
                        $type = $item;
                        if ($item == 'item') {
	                        $di++;
                        }
                    } else if (($item == 'title') && ($type == 'item')) {
                        $channel_data_title[$di]=$data;
                    } else if (($item == 'link') && ($type == 'item')) {
                        $channel_data_link[$di]=$data;
                    }
                }
            }

            $blockcontent = '';

            for ($i = 1; $i <= $di; $i++) {
                $blockcontent .= '<li><a href="' . addslashes($channel_data_link[$i]) . '">' 
                    . addslashes($channel_data_title[$i]) . '</a></li>';
            }

            $result = DB_change($_TABLES['blocks'],'content',"$blockcontent",'bid',$bid);
        }
    } else {
        $retval .= COM_errorLog("can not reach $rdfurl",1);
        $result = DB_change($_TABLES['blocks'],'content',"GeekLog can not reach the suppiled RDF file at $update. "
            . "Please double check the URL provided.  Make sure your url is correctly entered and it begins with "
            . "http://. GeekLog will try in one hour to fetch the file again.",'bid',"$bid");
    }

    return $retval;
}

/**
* Returns what HTML is allows in content
*
* Returns what HTML tags the system allows to be used inside content
* you can modify this by changing $_CONF['allowablehtml'] in 
* config.php
*
*/
function COM_allowedhtml() 
{
    global $_CONF,$LANG01;
	
    $retval .= '<span class="warningsmall">'
        . $LANG01[31]
        . htmlspecialchars($_CONF['allowablehtml'])
        . '</span>';
		
    return $retval;
}

/**
* Return the password for the given username
*
* Fetches a password for the given user
*
* @loginname        string      username to get password for
*
*/
function COM_getpassword($loginname) 
{
    global $_TABLES, $LANG01;

    $result = DB_query("SELECT passwd FROM {$_TABLES['users']} WHERE username='$loginname'");
    $tmp = mysql_errno();
    $nrows = DB_numRows($result);

    if (($tmp == 0) && ($nrows == 1)) {
        $U = DB_fetchArray($result);
        return $U['passwd'];
    } else {
        $tmp = $LANG01[32] . $loginname . '!';
        COM_errorLog($tmp,1);
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

    DB_query("UPDATE {$_TABLES['vars']} SET value = value + 1 WHERE name = 'totalhits'");
}

/**
* Returns the upcoming event block
*
* Returns the HTML for any upcoming events in the calendar
*
*/
function COM_printUpcomingEvents($title='') 
{
    global $_TABLES, $LANG01,$_CONF;

    if (empty($title)) {	
        $title = DB_getItem($_TABLES['blocks'],'title',"name = 'events_block'");
    }
    $retval .= COM_startBlock($title, '', COM_getBlockTemplate('events_block', 'header'));

    $eventSql = "SELECT eid, title, url, datestart, dateend FROM {$_TABLES['events']} WHERE dateend >= NOW() AND " 
        . "(TO_DAYS(datestart) - TO_DAYS(NOW()) < 14) ORDER BY datestart, dateend";
    $personaleventsql = "SELECT eid, title, url, datestart, dateend FROM {$_TABLES['personal_events']} WHERE dateend >= NOW() AND "
        . "(TO_DAYS(datestart) - TO_DAYS(NOW()) < 14) ORDER BY datestart, dateend";

    $allEvents = DB_query($eventSql);
    $numRows   = DB_numRows($allEvents);
    $totalrows = $numRows;
    $numDays   = 0;         // Without limits, I'll force them.
    $theRow    = 1;         // Start with today!
    $oldDate1  = 'no_day';  // Invalid Date!
    $oldDate2  = 'last_d';  // Invalid Date!

    if ($_CONF['personalcalendars'] == 1) {
        $iterations = 2;
    } else {
        $iterations = 1;
    }

    for ($z = 1; $z <= $iterations; $z++) {
        if ($z == 2) {
            $allEvents = DB_query($personaleventsql);
            $numRows = DB_numRows($allEvents);
            $totalrows = $totalrows + $numRows;
            $numDays   = 0;         // Without limits, I'll force them.
            $theRow    = 1;         // Start with today!
            $oldDate1  = 'no_day';  // Invalid Date!
            $oldDate2  = 'last_d';  // Invalid Date!
            if ($totalrows > 0) $retval .= '<p><b><u>Your Events</u></b><br>';
        } else {
             if ($iterations == 2 && $totalrows > 0) $retval .= '<b><u>Public Events</u></b><br>';
        }

    //if ($numRows == 0) {
    if ($z == 2 AND $totalrows == 0) {
        // There aren't any upcoming events, show a nice message
        $retval .= $LANG01[89];
    }

    while ($theRow <= $numRows AND $numDays < 14) {

        // Retreive the next event, and format the start date.
        $theEvent   = DB_fetchArray($allEvents);
		
        // Start Date strings...
        $startDate  = $theEvent['datestart'];
        $theTime1   = strtotime($startDate);
        $dayName1   = strftime("%A", $theTime1);
        $abbrDate1  = strftime("%m/%d", $theTime1);

        // End Date strings...
        $endDate    = $theEvent['dateend'];
        $theTime2   = strtotime($endDate);
        $dayName2   = strftime("%A", $theTime2);
        $abbrDate2  = strftime("%m/%d", $theTime2);

        // If either of the dates [start/end] change, then display a new header.
        if ($oldDate1 != $abbrDate1 OR $oldDate2 != $abbrDate2) {
            $oldDate1 = $abbrDate1;
            $oldDate2 = $abbrDate2;
            $numDays ++;
            if ($numDays < 14) {
                $retval .= '<br><b>' . $dayName1 . '</b>&nbsp;<small>' . $abbrDate1 . '</small>';
                // If different start and end Dates, then display end date:
                if ($abbrDate1 != $abbrDate2) {
                    $retval .= ' - <br><b>' . $dayName2 . '</b>&nbsp;<small>' . $abbrDate2 . '</small>';
                }
            }
        }

        // Now display this event record.

        if ($numDays < 14) {
            // Display the url now!
            $retval .= '<li><a href="' . $_CONF['site_url'] . '/calendar_event.php?eid=' . $theEvent['eid']
                . '">' . stripslashes($theEvent['title']) . '</a></li>';
        }
        $theRow ++ ;  
    }

    } // end for z
    $retval .= COM_endBlock(COM_getBlockTemplate('events_block', 'footer'));
	
    return $retval;
}

/**
* This will email new stories in the topics that the user is interested in
*
* In account information the user can specify which topics for which they
* will receive any new article for in a daily digest. As of 10/15/2001 this
* isn't working entirely (usersettings.php needs to be modified)
*
*/
function COM_emailUserTopics() 
{
    global $_TABLES, $LANG08, $_CONF;

    // Get users who want stories emailed to them

    $users = DB_query("SELECT username,email, etids FROM {$_TABLES['users']}, {$_TABLES['userindex']} WHERE "
        . "userindex.uid = {$_TABES['users']}.uid AND etids IS NOT NULL");
    $nrows = DB_numRows($users);
    // $file = @fopen('testemail.txt',w);
    // fputs($file, "got $nrows users who want stories emailed to them\n");

    // For each user, pull the stories they want and email it to them
    for ($x = 0; $x < $nrows; $x++) {
        fputs($file, "inside for loop\n");
        $U = DB_fetchArray($users);
        $cur_day = strftime("%D",time());
        $result = DB_query("SELECT value AS lastrun FROM {$_TABLES['vars']} WHERE name = 'lastemailedstories'");
        $L = DB_fetchArray($result);
        $storysql = "SELECT sid, date AS day, title, introtext, bodytext FROM {$_TABLES['stories']} WHERE date >= '"
            . $L['lastrun'] . "' AND (";
        $ETIDS = explode(' ',$U['etids']);
        // fputs($file, "got $ETIDS[$x] for a category\n");

        for ($i = 0; $i < sizeof($ETIDS); $i++) {
            if ($i == (sizeof($ETIDS) - 1)) {
                $storysql .= "tid = '$ETIDS[$i]')";
            } else {
                $storysql .= "tid = '$ETIDS[$i]' OR ";
            }
        }

        fputs($file, $storysql . "\n");
        $stories = DB_query($storysql);
        $nsrows = DB_numRows($stories);
        // fputs($file, "got $nsrows stories that need to be emailed to user: {$U['username']}\n");

        if ($nsrows == 0) {
            // If no new stories where pulled then exit out
            return;
        }

        $mailtext = "{$LANG08[27]}\n";
        for ($y=0; $y<$nsrows; $y++) {
            // Loop through stories building the requested email message
            $S = DB_fetchArray($stories);
            // fputs($file, "introtext = {$S['introtext']}\n, bodytext = {$S['bodytext']}\n");
            $mailtext .= "\n------------------------------\n\n";
            $mailtext .= "Title: {$S['title']}\n";
            $mailtext .= "Date: " . strftime($_CONF['date'],strtotime($S['day'])) . "\n\n";
            $mailtext .= nl2br(stripslashes(strip_tags($S['introtext']))) . "\n\n";
            $mailtext .= "Read the full article at {$_CONF['site_url']}/article.php?story={$S['sid']}\n";
        }
        $mailtext .= "\n------------------------------\n";
        $mailtext .= "\nEnd of Message\n";
        $mailtext .= "\n------------------------------\n";
        $toemail = $U['email'];
		$mailto = "{$U['username']} <{$toemail}>";
        $mailfrom = "FROM: Iowa Outdoors <newsletter@iowaoutdoors.org>";                        $subject = strip_tags(stripslashes("Iowa Outdoors Daily Newsletter for " . strftime('%m/%d/%Y',time())));
        // fputs($file,"to: $toemail, from: $mailfrom, sub: $subject\ntext: $mailtext");
        @mail($toemail,$subject,$mailtext,$mailfrom);
    }
    $tmpdate = date("Y-m-d H:i:s",time());
    DB_query("UPDATE {$_TABLES['vars']} SET value = '$tmpdate'");
    // fclose($file);
}

/**
* Shows any new information in block
*
* Return the HTML that shows any new stories, comments, etc
*
*/
function COM_whatsNewBlock($title='') 
{
    global $_TABLES, $_CONF, $LANG01;
	
    if ($_CONF['whatsnewbox'] == 0) {
        // Site is configured not to display this, so return empty.
        return $retval;
    }

    // Find the newest stories
    // Change 86400 to your desired interval in seconds
	
    $sql = "SELECT *,UNIX_TIMESTAMP(date) AS day FROM {$_TABLES['stories']} WHERE ";
    $now = time();
    $desired = $now - $_CONF['newstoriesinterval'];
    $sql .= "UNIX_TIMESTAMP(date) > {$desired}"; // ORDER BY day DESC"
    $sql .= " AND draft_flag = 0";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if (empty($title)) {
        $title = DB_getItem($_TABLES['block'],'title',"name='whats_new_block'");
    }
    $retval .= COM_startBlock($title, '', COM_getBlockTemplate('whats_new_block', 'header'));

    // Any late breaking news stories?
    $retval .= '<b>' . $LANG01[99] . '</b><br>';
	
    if ($nrows > 0) {
        $hours = (($_CONF['newstoriesinterval']/60)/60);
        if ($nrows == 1) {
            $retval .= '<li class="storyclose"><a href="' . $_CONF['site_url'] . '">1 ' . $LANG01[81] . ' '
                . $hours . ' ' . $LANG01[82] . '</a></li>';
        } else {
            $retval .= '<li class="storyclose"><a href="' . $_CONF['site_url'] . '">' . $nrows . ' ' . $LANG01[80]
                . ' ' . $hours . ' ' . $LANG01[82] . '</a></li>';
        }
    } else {
        $retval .= '<li class="storyclose">' . $LANG01[100] . '</li>';
    }
    $retval .= '<br>';

    // Go get the newest comments
    // Change 172800 to desired interval in seconds
	
    $retval .= '<b>' . $LANG01[83] . '</b> <small>' . $LANG01[85] . '</small><br>';
	
    $sql = "SELECT DISTINCT *, count(*) AS dups, {$_TABLES["comments"]}.cid,{$_TABLES["comments"]}.sid,"
        . "{$_TABLES["stories"]}.sid,{$_TABLES["stories"]}.title,max(UNIX_TIMESTAMP({$_TABLES["comments"]}.date)) "
        . "AS day FROM {$_TABLES["comments"]},{$_TABLES["stories"]} WHERE ";
    $now = time();
    $desired = $now - $_CONF['newcommentsinterval'];
    $sql .= "UNIX_TIMESTAMP({$_TABLES["comments"]}.date) > {$desired} and ({$_TABLES["stories"]}.sid={$_TABLES["comments"]}.sid) GROUP BY {$_TABLES["comments"]}.sid";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    // Cap max displayed at 15
    if ($nrows > 15) $nrows = 15;
    if ($nrows > 0) {
        for ($x = 1; $x <= $nrows; $x++) {
            $A = DB_fetchArray($result);
            $robtime = strftime("%D %T",$A['day']);
            $itemlen = strlen($A['title']);
            if ($A['cmt_type'] == 'story') {
                $urlstart = '<a href="' . $_CONF['site_url'] . '/article.php?story=' . $A['sid'] . '#comments">';
            } else {
                $urlstart = '<a href="' . $_CONF['site_url'] . '/pollbooth.php?qid=' . $A['qid'] . '&aid=-1#comments">';
            }
			
            // Trim the length if over 20 characters
			
            if ($itemlen > 20) {
                $retval .= '<li class="storyclose">' . $urlstart . substr($A['title'],0,26) . '... ';
                if ($A['dups'] > 1) {
                    $retval .= '[+' . $A['dups'] . ']';
                }
                $retval .= '</a></li>' . LB;  
            } else {
                $retval .= '<li class="storyclose">' . $urlstart . $A['title'];
                if ($A['dups'] > 1) {
                    $retval .= '[+' . $A['dups'] . ']';
                }
                $retval .= '</a></li>' . LB;
            }
        }
    } else {
        $retval .= '<li class="storyclose">' . $LANG01[86] . '</li>' . LB;
    }

    $retval .= '<br>';
    // Get newest links
    // Change 1209600 to desired interval in seconds
	
    $retval .= '<b>' . $LANG01[84] . '</b> <small>' . $LANG01[87] . '</small><br>';
	
    $sql    = "SELECT * FROM {$_TABLES['links']} ORDER BY lid DESC";
    $foundone = 0;
    $now = time();
    $desired = $now - $_CONF['newlinksinterval'];
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    // Cap max displayed at 15
    if ($nrows > 15) $nrows = 15;
    if ($nrows > 0) {
        for ($x = 1; $x <= $nrows; $x++) {
            $A = DB_fetchArray($result);
			
            // Need to reparse the date from the link id
            $myyear  = substr($A['lid'],0,4);
            $mymonth = substr($A['lid'],4,2);
            $myday   = substr($A['lid'],6,2);
            $myhour  = substr($A['lid'],8,2);
            $mymin   = substr($A['lid'],10,2);
            $mysec   = substr($A['lid'],12,2);
            $newtime = "{$mymonth}/{$myday}/{$myyear} {$myhour}:{$mymin}:{$mysec}";
            $convtime = strtotime($newtime);

            if ($convtime > $desired) {
                $itemlen = strlen($A['title']);

                // Trim the length if over 16 characters, and strip the 'http://'
                $foundone = 1;

                if ($itemlen > 16) {
                    $retval .= '<li class="storyclose"><a href="' . $A['url'] . '" target="_blank">' 
                        . substr($A['title'],0,16) . '...</a></li>' . LB;
                } else {
                    $retval .= '<li class="storyclose"><a href="' . $A['url'] . '" target="_blank">'
                        . substr($A['title'],0,$itemlen) . '</a></li>' . LB;
                }
            }
        }
        if ($foundone == 0) {
            $retval .= '<li class="storyclose">' . $LANG01[88] . '</li>' . LB;
        }
    }

    $retval .= COM_endBlock(COM_getBlockTemplate('whats_new_block', 'footer'));
	
    return $retval;
} 

/**
* Displays a message on the webpage
*
* Pulls $msg off the URL string and gets the corresponding message and returns
* it for display on the calling page
*
* @msg          int     ID of message to show
*
*/
function COM_showMessage($msg) 
{
    global $MESSAGE, $_CONF;

    $retval = '';
	
    if ($msg > 0) {
        $timestamp = strftime("%c");
        $retval .= COM_startBlock($MESSAGE[40] . ' - ' . $timestamp)
            . '<img src="' . $_CONF['layout_url'] . '/images/sysmessage.gif" border="0" align="top">'
            . $MESSAGE[$msg] . '<BR><BR>' . COM_endBlock();
    }
	
    return $retval;
}

/**
* Shows Paging control
*
* Shows the Google-like paging navigation control
*
* @page         int     Current page
* @num_pages    int     Total number of pages
* @topic        string  Topic we are showing pages for
*
*/
function COM_PrintPageNavigation ($page, $num_pages, $topic='') 
{
    global $_CONF,$LANG05;

    if ($num_pages == 1) {
        // If there's only one page, we don't need this ..
        return;
    }

    if ($page > 1) {
        $retval .= '<a href="' . $_CONF['site_url'] . '/index.php';
        if (!empty($topic)) {
            $retval .= '?topic=' . $topic . '&page=' . ($page-1) . '">' . $LANG05[6] . '</a> ';
        } else {
            $retval .= '?page=' . ($page-1) . '">' . $LANG05[6] . '</a> ';
        }   
    } else {
        $retval .= $LANG05[6] . ' ';
    }

    for ($pgcount=($page-10);($pgcount<=($page+9)) && ($pgcount<=$num_pages);$pgcount++) {
        if ($pgcount <= 0) {
            $pgcount = 1;
        }

        if ($pgcount == $page) {
            $retval .= '<b>' . $pgcount . '</b> ';
        } else {
            $retval .= '<a href="' . $_CONF['site_url'] . '/index.php';
            if (!empty($topic)) {
                $retval .= '?topic=' . $topic . '&page=' . $pgcount . '">' . $pgcount . '</a> ';
            } else {
                $retval .= '?page=' . $pgcount . '">' . $pgcount . '</a> ';
            }
        }
    }

    if ($page == $num_pages) {
        $retvfal .= $LANG05[5];
    } else {
        $retval .= '<a href="' . $_CONF['site_url'] . '/index.php';
        if (!empty($topic)) {
            $retval .= '?topic=' . $topic . '&page=' . ($page+1) . '>' . $LANG05[5] . '</a>';
        } else {
            $retval .= '?page=' . ($page+1) . '>' . $LANG05[5] . '</a>';
        }
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
* @date         string      date to format, otherwise we format current date/time
*
*/
function COM_getUserDateTimeFormat($date='') 
{
    global $_TABLES, $_USER, $_CONF;

    // Get display format for time

    if ($_USER['uid'] > 1) {
        $result = DB_query("SELECT format FROM {$_TABLES['dateformats']}, {$_TABLES['userprefs']} WHERE "
            . "{$_TABLES["dateformats"]}.dfid = {$_TABLES["userprefs"]}.dfid AND uid = {$_USER['uid']}");
        $nrows = DB_numRows($result);
        $A = DB_fetchArray($result);

        if (empty($A['format'])) {
            $dateformat = $_CONF['date'];
        } else {
            $dateformat = $A['format'];
        }
    } else {    
        $dateformat = $_CONF['date'];
    }

    if (empty($date)) {
        // Date is empty, get current date/time
        $stamp = time();
    } else if (is_numeric($date)) {
	
        // This is a timestamp
	
        $stamp = $date;
    } else {
	
        // This is a string representation of a date/time
    
        $stamp = strtotime($date);
    }

    // Format the date

    $date = strftime($dateformat,$stamp);

    return array($date, $stamp);
}

/**
* Returns user-defined cookie timeout
*
* In account preferences users can specify when their long-term cookie expires.  This
* function returns that value.
*
*/
function COM_getUserCookieTimeout() 
{
    global $_TABLES, $_USER, $_CONF;

    if (empty($_USER)) {
        return;
    }
	
    $timeoutvalue = DB_getItem($_TABLES['users'],'cookietimeout',"uid = {$_USER['uid']}");

    if (empty($timeoutvalue)) {
        $timeoutvalue = $_CONF['default_perm_cookie_timeout'];
    }

    return $timeoutvalue;
}

// Now include all plugin functions
$result = DB_query("SELECT * FROM {$_TABLES["plugins"]} WHERE pi_enabled = 1");
$nrows = DB_numRows($result);
for ($i = 1; $i <= $nrows; $i++) {
	$A = DB_fetchArray($result);
	include_once($_CONF['path'] . 'plugins/' . $A['pi_name'] . '/functions.inc');
}

?>
