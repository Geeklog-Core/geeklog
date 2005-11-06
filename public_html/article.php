<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | article.php                                                               |
// |                                                                           |
// | Shows articles in various formats.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
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
// $Id: article.php,v 1.71 2005/11/06 14:05:42 dhaun Exp $

/**
* This page is responsible for showing a single article in different modes which
* may, or may not, include the comments attached
*
* @author   Jason Whittenburg
* @author   Tony Bibbbs <tony@tonybibbs.com>
* @author   Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
*/

/**
* Geeklog common function library
*/
require_once ('lib-common.php');
require_once ($_CONF['path_system'] . 'lib-story.php');
if ($_CONF['trackback_enabled']) {
    require_once ($_CONF['path_system'] . 'lib-trackback.php');
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

// echo COM_debug($_POST);

// MAIN

if (isset ($_POST['mode'])) {
    $story = COM_applyFilter ($_POST['story']);
    $mode = COM_applyFilter ($_POST['mode']);
    $order = COM_applyFilter ($_POST['order']);
    $query = COM_applyFilter ($_POST['query']);
    $reply = COM_applyFilter ($_POST['reply']);
} else {
    COM_setArgNames (array ('story', 'mode'));
    $story = COM_applyFilter (COM_getArgument ('story'));
    $mode = COM_applyFilter (COM_getArgument ('mode'));
    $order = COM_applyFilter ($_GET['order']);
    $query = COM_applyFilter ($_GET['query']);
    $reply = COM_applyFilter ($_GET['reply']);
}

if (empty ($story)) {
    echo COM_refresh ($_CONF['site_url'] . '/index.php');
    exit();
}
if ((strcasecmp ($order, 'ASC') != 0) && (strcasecmp ($order, 'DESC') != 0)) {
    $order = '';
}


$result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE sid = '$story'" 
                 . COM_getPermSql ('AND'));
$A = DB_fetchArray($result);

if ($A['count'] > 0) {
    $result = DB_query ("SELECT STRAIGHT_JOIN s.*, UNIX_TIMESTAMP(s.date) as day, "
     . "u.username, u.fullname, u.photo, t.topic, t.imageurl "
     . "FROM {$_TABLES['stories']} as s, {$_TABLES['users']} as u, {$_TABLES['topics']} as t "
     . "WHERE (s.uid = u.uid) AND (s.tid = t.tid) AND (sid = '$story')");
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
            $story_template->set_var('story_author', $A['username']);
        }

        if ($A['postmode'] == 'plaintext') {
            $A['introtext'] = nl2br ($A['introtext']);
            $A['bodytext'] = nl2br ($A['bodytext']);
        }
        $story_template->set_var ('story_introtext',
                PLG_replaceTags (stripslashes ($A['introtext'])));
        $story_template->set_var ('story_bodytext',
                PLG_replaceTags (stripslashes ($A['bodytext'])));

        $story_template->set_var('site_url', $_CONF['site_url']);
        $story_template->set_var('layout_url', $_CONF['layout_url']);
        $story_template->set_var('story_id', $A['sid']);
        $story_template->set_var('story_comments', DB_count($_TABLES['comments'],'sid',$A['sid']));
        $story_template->set_var('lang_comments', $LANG01[3]);
        $articleUrl = COM_buildUrl ($_CONF['site_url']
                                    . '/article.php?story=' . $A['sid']);
        $story_template->set_var ('article_url', $articleUrl);
        $story_template->parse('output','article');
        $display = $story_template->finish($story_template->get_var('output')); 
    } else {
        // Set page title
        $pagetitle = stripslashes (str_replace ('$', '&#36;', $A['title']));

        if ($_CONF['trackback_enabled']) {
            $permalink = COM_buildUrl ($_CONF['site_url']
                                       . '/article.php?story=' . $story);
            $trackbackurl = TRB_makeTrackbackUrl ($story);
            $rdf = '<!--' . LB
                 . TRB_trackbackRdf ($permalink, $A['title'], $trackbackurl)
                 . LB . '-->' . LB;
        } else {
            $rdf = '';
        }
        if ($_CONF['pingback_enabled']) {
            header ('X-Pingback: ' . $_CONF['site_url'] . '/pingback.php');
        }
        $display .= COM_siteHeader ('menu', $pagetitle, $rdf);

        DB_query ("UPDATE {$_TABLES['stories']} SET hits = hits + 1 WHERE (sid = '$story') AND (date <= NOW()) AND (draft_flag = 0)");

        // Display whats related any polls configured for this page

        $story_template = new Template($_CONF['path_layout'] . 'article');
        $story_template->set_file('article','article.thtml');

        $story_template->set_var('site_url', $_CONF['site_url']);
        $story_template->set_var('layout_url', $_CONF['layout_url']);
        $story_template->set_var('story_id', $story);
        $story_options = array ();
        if (($_CONF['hideemailicon'] == 0) && (!empty ($_USER['username']) ||
                (($_CONF['loginrequired'] == 0) &&
                 ($_CONF['emailstoryloginrequired'] == 0)))) {
            $emailUrl = $_CONF['site_url'] . '/profiles.php?sid=' . $story
                      . '&amp;what=emailstory';
            $story_options[] = '<a href="' . $emailUrl . '">' . $LANG11[2]
                             . '</a>';
            $story_template->set_var ('email_story_url', $emailUrl);
            $story_template->set_var ('lang_email_story', $LANG11[2]);
            $story_template->set_var ('lang_email_story_alt', $LANG01[64]);
        }
        $printUrl = COM_buildUrl ($_CONF['site_url']
                . '/article.php?story=' . $story .  '&amp;mode=print');
        if ($_CONF['hideprintericon'] == 0) {
            $story_options[] = '<a href="' . $printUrl . '">' . $LANG11[3]
                             . '</a>';
            $story_template->set_var ('print_story_url', $printUrl);
            $story_template->set_var ('lang_print_story', $LANG11[3]);
            $story_template->set_var ('lang_print_story_alt', $LANG01[65]);
        }
        if ($_CONF['pdf_enabled'] == 1) {
            $pdfUrl = $_CONF['site_url']
                    . '/pdfgenerator.php?pageType=2&amp;pageData='
                    . urlencode ($printUrl);
            $story_options[] = '<a href="' . $pdfUrl . '">' . $LANG11[5]
                             . '</a>';
            $story_template->set_var ('pdf_story_url', $printUrl);
            $story_template->set_var ('lang_pdf_story', $LANG11[5]);
        }
        $related = STORY_whatsRelated ($A['related'], $A['uid'], $A['tid']);
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
                . COM_makeList ($story_options, 'list-story-options')
                . COM_endBlock (COM_getBlockTemplate ('story_options_block',
                    'footer'));
        } else {
            $optionsblock = '';
        }
        $story_template->set_var ('whats_related', $related);
        $story_template->set_var ('story_options', $optionsblock);
        $story_template->set_var ('whats_related_story_options',
                                  $related . $optionsblock);

        $story_template->set_var ('formatted_article',
                                  STORY_renderArticle ($A, 'n', '', $query));

        // display comments or not?
        if ( (is_numeric($mode)) and ($_CONF['allow_page_breaks'] == 1) )
        {
            $story_page = $mode;
            $mode = '';
            if( $story_page <= 0 ) {
                $story_page = 1;
            }
            $article_arr = explode( '[page_break]', $A['bodytext']);
            $conf = $_CONF['page_break_comments'];
            if  (
                 ($conf == 'all') or
                 ( ($conf =='first') and ($story_page == 1) ) or
                 ( ($conf == 'last') and (count($article_arr) == ($story_page)) )
                ) {
                $show_comments = true;
            } else {
                $show_comments = false;
            }
        } else {
            $show_comments = true;
        }
                                  
        // Display the comments, if there are any ..
        if (($A['commentcode'] >= 0) and $show_comments) {
            $delete_option = (SEC_hasRights('story.edit') && ($access == 3)
                             ? true : false);
            require_once ( $_CONF['path_system'] . 'lib-comment.php' );
            $story_template->set_var ('commentbar',
                    CMT_userComments ($story, $A['title'], 'article',
                                      $order, $mode, 0, $page, false, $delete_option));
        }
        if ($_CONF['trackback_enabled'] && ($A['trackbackcode'] >= 0) &&
                $show_comments) {
            if (SEC_hasRights ('story.ping')) {
                if (($A['draft'] == 0) && ($A['day'] < time ())) {
                    $url = $_CONF['site_admin_url']
                         . '/trackback.php?mode=sendall&amp;id=' . $A['sid'];
                    $story_template->set_var ('send_trackback_link', '<a href="'
                         . $url . '">' . $LANG_TRB['send_trackback'] . '</a>');
                    $story_template->set_var ('send_trackback_url', $url);
                    $story_template->set_var ('lang_send_trackback_text',
                                              $LANG_TRB['send_trackback']);
                }
            }

            $permalink = COM_buildUrl ($_CONF['site_url']
                                       . '/article.php?story=' . $story);
            $story_template->set_var ('trackback',
                    TRB_renderTrackbackComments ($story, 'article',
                                                 $A['title'], $permalink));
        } else {
            $story_template->set_var ('trackback', '');
        }
        $display .= $story_template->finish ($story_template->parse ('output', 'article'));
        $display .= COM_siteFooter ();
    }
} else {
    $display .= COM_refresh($_CONF['site_url'] . '/index.php');
}

echo $display;

?>
