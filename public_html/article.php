<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | article.php                                                               |
// | Shows articles in various formats.                                        |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony@tonybibbs.com                                   |
// |          Jason Whitttenburg, jwhitten@securitygeeks.com		       |
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
// $Id: article.php,v 1.19 2002/05/14 21:16:31 tony_bibbs Exp $

/**
* This page is responsible for showing a single article in different modes which
* may, or may not, include the comments attached
*
* @author   Jason Whittenburg
* @author   Tony Bibbbs <tony@tonybibbs.com>
*/

/**
* Geeklog common function library
*/
require_once('lib-common.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

// debug($HTTP_POST_VARS);

// MAIN

// First see if we have a plugin that may be trying to use the Geeklog comment engine
if (PLG_supportsComments($type)) {
	// Yes, this is a plugin wanting to be commented on...do it
	echo COM_refresh($_CONF['site_url'] . "/comment.php?sid=$story&amp;pid=$pid&amp;type=$type");
}

if ($type == 'poll') {
    $result = DB_query("SELECT count(*) as count FROM {$_TABLES['pollquestions']} WHERE qid = '$story'");
} else {
    $result = DB_query("SELECT count(*) as count FROM {$_TABLES['stories']} WHERE sid = '$story'");
}
$A = DB_fetchArray($result);

if ($A['count'] > 0) {
    if ($reply == $LANG01[25]) {
        echo COM_refresh($_CONF['site_url'] . "/comment.php?sid=$story&amp;pid=$pid&amp;type=$type");
	} else if ($mode == "print") {
		$result = DB_query("SELECT *,unix_timestamp(date) AS day FROM {$_TABLES['stories']} WHERE sid = '$story'");
		$A = DB_fetchArray($result);
		$access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
		if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) == 0 OR (!SEC_hasTopicAccess($A['tid']))) {	
			$display .= COM_siteHeader('menu')
				.COM_startBlock($LANG_ACCESS[accessdenied])
				.$LANG_ACCESS[storydenialmsg]
				.COM_endBlock()
				.COM_siteFooter();
		} else {
            $story_template = new Template($_CONF['path_layout'] . 'article');
            $story_template->set_file('article','printable.thtml');
            $story_template->set_var('page_title',$_CONF['site_name'] . ': ' . stripslashes($A['title'])); 
            $story_template->set_var('story_title',stripslashes($A['title']));
            $curtime = COM_getUserDateTimeFormat($A['day']);
            $story_template->set_var('story_date', $curtime[0]);
 
		    if ($_CONF['contributedbyline'] == 1) {
                $story_template->set_var('lang_contributedby', $LANG01[1]);
                $story_template->set_var('story_author', DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'"));
		    }
            $story_template->set_var('story_introtext',nl2br(stripslashes($A['introtext'])));
            $story_template->set_var('story_bodytext', nl2br(stripslashes($A['bodytext'])));
            $story_template->set_var('site_url',$_CONF['site_url']);
            $story_template->set_var('story_id', $A['sid']);
            $story_template->set_var('story_comments', DB_count($_TABLES['comments'],'sid',$A['sid']));
            $story_template->set_var('lang_comments', $LANG01[3]);
            $story_template->parse('output','article');
            $display = $story_template->finish($story_template->get_var('output')); 
        }
	} else {
		// Set page title
		
		$_CONF['pagetitle'] = stripslashes($A['title']);
		$display .= COM_siteHeader('menu');
		$result = DB_query("SELECT *,unix_timestamp(date) AS day FROM {$_TABLES["stories"]} WHERE sid = '$story'");
		$A = DB_fetchArray($result);

        // Make sure user has access to this article
		$access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) == 0 OR (!SEC_hasTopicAccess($A['tid']))) {
            // Bail, they don't have access
			$display .= COM_startBlock($LANG_ACCESS[accessdenied])
				.$LANG_ACCESS[storydenialmsg]
				.COM_endBlock()
				.COM_siteFooter();
			echo $display;
            exit;
		}

        // They have access...go ahead and show the article

		DB_change($_TABLES['stories'],'hits',DB_getItem($_TABLES['stories'],'hits',"sid = '$story'") + 1,'sid',$story);
		$sql = "SELECT *,unix_timestamp(date) AS day FROM {$_TABLES['stories']} WHERE sid = '$story' ";
		$result = DB_query($sql);
		$A = DB_fetchArray($result);

		// Display whats related any polls configured for this page

        $story_template = new Template($_CONF['path_layout'] . 'article');
        $story_template->set_file('article','article.thtml');

        $story_template->set_var('site_url', $_CONF['site_url']);
        $story_template->set_var('whats_related_story_options', COM_startBlock($LANG11[1])
			. nl2br($A['related'])
			. COM_endBlock()
			. COM_startBlock($LANG11[4])
			. '<li><a href="' . $_CONF['site_url'] . '/profiles.php?sid=' . $story . '&amp;what=emailstory">' . $LANG11[2] . '</a></li>' . LB
			. '<li><a href="' . $_CONF['site_url'] . '/article.php?story=' . $story . '&amp;mode=print">' . $LANG11[3] . '</a></li>' . LB
			. COM_endBlock());

		// if (DB_count($_TABLES['pollquestions'],'qid',$story) > 0) {
		// 	$display .= COM_showPoll(80,$story);
		// }
		
        $story_template->set_var('formatted_article', COM_article($A,'n'));
		// Display the comments, if there are any ..
		if ($A['commentcode'] >= 0) {
				$story_template->set_var('commentbar', COM_userComments($story,$A['title'],'article',$order,$mode));
		}
        $story_template->parse('output', 'article');
        $display .= $story_template->finish($story_template->get_var('output'));
		$display .= COM_siteFooter();
	}
} else {
	$display .= COM_refresh($_CONF['site_url'] . '/index.php');
}
echo $display;

?>