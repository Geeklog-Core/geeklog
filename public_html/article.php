<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | article.php                                                               |
// |                                                                           |
// | Shows articles in various formats.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
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
// $Id: article.php,v 1.34 2003/07/01 15:03:44 dhaun Exp $

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

// echo COM_debug($HTTP_POST_VARS);

// MAIN

// First see if we have a plugin that may be trying to use the Geeklog comment engine
if (PLG_supportsComments($type)) {
    // Yes, this is a plugin wanting to be commented on...do it
    $display .= PLG_callCommentForm($type,$story,$mode,$order,$reply);
    echo $display;
    exit();
}

if ($type == 'poll') {
    $result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['pollquestions']} WHERE qid = '$story'");
} else {
    $result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE sid = '$story'");
}
$A = DB_fetchArray($result);

if ($A['count'] > 0) {
    if ($reply == $LANG01[25]) {
        echo COM_refresh ($_CONF['site_url']
                . "/comment.php?sid=$story&amp;pid=$pid&amp;type=$type");
    } else {
        $result = DB_query ("SELECT sid,uid,tid,title,introtext,bodytext,hits,comments,featured,draft_flag,show_topic_icon,commentcode,postmode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,unix_timestamp(date) AS day FROM {$_TABLES['stories']} WHERE sid = '$story'");
        $A = DB_fetchArray ($result);

        $access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
                $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                $A['perm_anon']);
        if (($access == 0) OR !SEC_hasTopicAccess ($A['tid']) OR
            (($A['draft_flag'] == 1) AND !SEC_hasRights ('story.edit'))) {
            $display .= COM_siteHeader ('menu')
                     . COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                     . $LANG_ACCESS['storydenialmsg']
                     . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                     . COM_siteFooter ();
        } elseif (($mode == 'print') && ($_CONF['hideprintericon'] == 0)) {
            $story_template = new Template($_CONF['path_layout'] . 'article');
            $story_template->set_file('article','printable.thtml');
            $story_template->set_var('page_title',
                    $_CONF['site_name'] . ': ' . stripslashes($A['title'])); 
            $story_template->set_var('story_title',stripslashes($A['title']));
            $curtime = COM_getUserDateTimeFormat($A['day']);
            $story_template->set_var('story_date', $curtime[0]);
 
            if ($_CONF['contributedbyline'] == 1) {
                $story_template->set_var('lang_contributedby', $LANG01[1]);
                $story_template->set_var('story_author', DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'"));
            }
            if ($A['postmode'] == 'html') {
                $story_template->set_var ('story_introtext',
                        stripslashes ($A['introtext']));
                $story_template->set_var ('story_bodytext',
                        stripslashes ($A['bodytext']));
            } else {
                $story_template->set_var ('story_introtext',
                        nl2br (stripslashes ($A['introtext'])));
                $story_template->set_var ('story_bodytext',
                        nl2br (stripslashes ($A['bodytext'])));
            }
            $story_template->set_var('site_url',$_CONF['site_url']);
            $story_template->set_var('layout_url',$_CONF['layout_url']);
            $story_template->set_var('story_id', $A['sid']);
            $story_template->set_var('story_comments', DB_count($_TABLES['comments'],'sid',$A['sid']));
            $story_template->set_var('lang_comments', $LANG01[3]);
            $story_template->parse('output','article');
            $display = $story_template->finish($story_template->get_var('output')); 
        } else {
            // Set page title
            $_CONF['pagetitle'] = stripslashes (str_replace ('$', '&#36;',
                                                $A['title']));
            $display .= COM_siteHeader ('menu');

            DB_change ($_TABLES['stories'], 'hits', DB_getItem ($_TABLES['stories'], 'hits', "sid = '$story'") + 1, 'sid', $story);

            if ($query) {
                $mywords = explode (" ", $query);
                foreach ($mywords as $searchword) {
                    $A['introtext'] = preg_replace ("/(\>(((?>[^><]+)|(?R))*)\<)/ie", "preg_replace('/(?>$searchword+)/i','<span class=\"highlight\">$searchword</span>','\\0')", "<x>" . $A['introtext'] . "<x>");
                    $A['bodytext'] = preg_replace ("/(\>(((?>[^><]+)|(?R))*)\<)/ie", "preg_replace('/(?>$searchword+)/i','<span class=\"highlight\">$searchword</span>','\\0')" ,"<x>" . $A['bodytext'] . "<x>");
                }
            }

            // Display whats related any polls configured for this page

            $story_template = new Template($_CONF['path_layout'] . 'article');
            $story_template->set_file('article','article.thtml');

            $story_template->set_var('site_url', $_CONF['site_url']);
            $story_template->set_var('layout_url', $_CONF['layout_url']);
            $story_options = array ();
            if ($_CONF['hideemailicon'] == 0) {
                $story_options[] = '<a href="' . $_CONF['site_url']
                    . '/profiles.php?sid=' . $story . '&amp;what=emailstory">'
                    . $LANG11[2] . '</a>';
            }
            if ($_CONF['hideprintericon'] == 0) {
                $story_options[] = '<a href="' . $_CONF['site_url']
                    . '/article.php?story=' . $story .  '&amp;mode=print">'
                    . $LANG11[3] . '</a>';
            }
            $related = COM_whatsRelated ($A['introtext'] . ' ' . $A['bodytext'],
                                         $A['uid'], $A['tid']);
            if (!empty ($related)) {
                $related = COM_startBlock ($LANG11[1], '',
                    COM_getBlockTemplate ('whats_related_block', 'header'))
                    . $related
                    . COM_endBlock (COM_getBlockTemplate ('whats_related_block',
                        'footer'));
            }
            if (count ($story_options) > 0) {
                $optionsblock = COM_startBlock ($LANG11[4], '',
                        COM_getBlockTemplate ('story_options_block', 'header'))
                    . COM_makeList ($story_options)
                    . COM_endBlock (COM_getBlockTemplate ('story_options_block',
                        'footer'));
            } else {
                $optionsblock = '';
            }
            $story_template->set_var ('whats_related', $related);
            $story_template->set_var ('story_options', $optionsblock);
            $story_template->set_var ('whats_related_story_options',
                    $related . $optionsblock);

            // if (DB_count($_TABLES['pollquestions'],'qid',$story) > 0) {
            //     $display .= COM_showPoll(80,$story);
            // }

            $story_template->set_var('formatted_article', COM_article($A, 'n'));
            // Display the comments, if there are any ..
            if ($A['commentcode'] >= 0) {
                $story_template->set_var ('commentbar',
                        COM_userComments ($story, $A['title'], 'article',
                                          $order, $mode));
            }
            $display .= $story_template->finish ($story_template->parse ('output', 'article'));
            $display .= COM_siteFooter ();
        }
    }
} else {
    $display .= COM_refresh($_CONF['site_url'] . '/index.php');
}
echo $display;

?>
