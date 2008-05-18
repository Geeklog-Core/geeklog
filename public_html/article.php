<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | article.php                                                               |
// |                                                                           |
// | Shows articles in various formats.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2008 by the following authors:                         |
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
// $Id: article.php,v 1.96 2008/05/18 19:29:30 dhaun Exp $

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
require_once 'lib-common.php';
require_once $_CONF['path_system'] . 'lib-story.php';
if ($_CONF['trackback_enabled']) {
    require_once $_CONF['path_system'] . 'lib-trackback.php';
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

// echo COM_debug($_POST);

// MAIN
$display = '';

$order = '';
$query = '';
$reply = '';
if (isset ($_POST['mode'])) {
    $sid = COM_applyFilter ($_POST['story']);
    $mode = COM_applyFilter ($_POST['mode']);
    if (isset ($_POST['order'])) {
        $order = COM_applyFilter ($_POST['order']);
    }
    if (isset ($_POST['query'])) {
        $query = COM_applyFilter ($_POST['query']);
    }
    if (isset ($_POST['reply'])) {
        $reply = COM_applyFilter ($_POST['reply']);
    }
} else {
    COM_setArgNames (array ('story', 'mode'));
    $sid = COM_applyFilter (COM_getArgument ('story'));
    $mode = COM_applyFilter (COM_getArgument ('mode'));
    if (isset ($_GET['order'])) {
        $order = COM_applyFilter ($_GET['order']);
    }
    if (isset ($_GET['query'])) {
        $query = COM_applyFilter ($_GET['query']);
    }
    if (isset ($_GET['reply'])) {
        $reply = COM_applyFilter ($_GET['reply']);
    }
}

if (empty ($sid)) {
    echo COM_refresh ($_CONF['site_url'] . '/index.php');
    exit();
}
if ((strcasecmp ($order, 'ASC') != 0) && (strcasecmp ($order, 'DESC') != 0)) {
    $order = '';
}

$result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE sid = '$sid'" . COM_getPermSql ('AND'));
$A = DB_fetchArray($result);
if ($A['count'] > 0) {

    $story = new Story();

    $args = array (
                    'sid' => $sid,
                    'mode' => 'view'
                  );

    $output = STORY_LOADED_OK;
    $result = PLG_invokeService('story', 'get', $args, $output, $svc_msg);

    if($result == PLG_RET_OK) {
        /* loadFromArray cannot be used, since it overwrites the timestamp */
        reset($story->_dbFields);

        while (list($fieldname,$save) = each($story->_dbFields)) {
            $varname = '_' . $fieldname;

            if (array_key_exists($fieldname, $output)) {
                $story->{$varname} = $output[$fieldname];
            }
        }
    }

    /*$access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
            $A['perm_owner'], $A['perm_group'], $A['perm_members'],
            $A['perm_anon']);
    if (($access == 0) OR !SEC_hasTopicAccess ($A['tid']) OR
        (($A['draft_flag'] == 1) AND !SEC_hasRights ('story.edit'))) {*/
    if ($output == STORY_PERMISSION_DENIED) {
        $display .= COM_siteHeader ('menu', $LANG_ACCESS['accessdenied'])
                 . COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
                 . $LANG_ACCESS['storydenialmsg']
                 . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                 . COM_siteFooter ();
    } elseif ( $output == STORY_INVALID_SID ) {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    } elseif (($mode == 'print') && ($_CONF['hideprintericon'] == 0)) {
        $story_template = new Template ($_CONF['path_layout'] . 'article');
        $story_template->set_file ('article', 'printable.thtml');
        $story_template->set_var ('xhtml', XHTML);
        $story_template->set_var ('page_title',
                $_CONF['site_name'] . ': ' . $story->displayElements('title'));
        $story_template->set_var ( 'story_title', $story->DisplayElements( 'title' ) );
        header ('Content-Type: text/html; charset=' . COM_getCharset ());
        $story_template->set_var ('story_date', $story->displayElements('date'));

        if ($_CONF['contributedbyline'] == 1) {
            $story_template->set_var ('lang_contributedby', $LANG01[1]);
            $authorname = COM_getDisplayName ($story->displayElements('uid'));
            $story_template->set_var ('author', $authorname);
            $story_template->set_var ('story_author', $authorname);
            $story_template->set_var ('story_author_username', $story->DisplayElements('username'));
        }

        $story_template->set_var ('story_introtext',
                                    $story->DisplayElements('introtext'));
        $story_template->set_var ('story_bodytext',
                                    $story->DisplayElements('bodytext'));

        $story_template->set_var ('site_url', $_CONF['site_url']);
        $story_template->set_var ('layout_url', $_CONF['layout_url']);
        $story_template->set_var ('site_name', $_CONF['site_name']);
        $story_template->set_var ('site_slogan', $_CONF['site_slogan']);
        $story_template->set_var ('story_id', $story->getSid());
        $articleUrl = COM_buildUrl ($_CONF['site_url']
                                    . '/article.php?story=' . $story->getSid());
        if ($story->DisplayElements('commentcode') >= 0) {
            $commentsUrl = $articleUrl . '#comments';
            $comments = $story->DisplayElements('comments');
            $numComments = COM_numberFormat ($comments);
            $story_template->set_var ('story_comments', $numComments);
            $story_template->set_var ('comments_url', $commentsUrl);
            $story_template->set_var ('comments_text',
                    $numComments . ' ' . $LANG01[3]);
            $story_template->set_var ('comments_count', $numComments);
            $story_template->set_var ('lang_comments', $LANG01[3]);
            $comments_with_count = sprintf ($LANG01[121], $numComments);

            if ($comments > 0) {
                $comments_with_count = COM_createLink($comments_with_count, $commentsUrl);
            }
            $story_template->set_var ('comments_with_count', $comments_with_count);
        }
        $story_template->set_var ('lang_full_article', $LANG08[33]);
        $story_template->set_var ('article_url', $articleUrl);

        $langAttr = '';
        if( !empty( $_CONF['languages'] ) && !empty( $_CONF['language_files'] ))
        {
            $langId = COM_getLanguageId();
        }
        else
        {
            // try to derive the language id from the locale
            $l = explode( '.', $_CONF['locale'] );
            $langId = $l[0];
        }
        if( !empty( $langId ))
        {
            $l = explode( '-', str_replace( '_', '-', $langId ));
            if(( count( $l ) == 1 ) && ( strlen( $langId ) == 2 ))
            {
                $langAttr = 'lang="' . $langId . '"';
            }
            else if( count( $l ) == 2 )
            {
                if(( $l[0] == 'i' ) || ( $l[0] == 'x' ))
                {
                    $langId = implode( '-', $l );
                    $langAttr = 'lang="' . $langId . '"';
                }
                else if( strlen( $l[0] ) == 2 )
                {
                    $langId = implode( '-', $l );
                    $langAttr = 'lang="' . $langId . '"';
                }
                else
                {
                    $langId = $l[0];
                }
            }
        }
        $story_template->set_var( 'lang_id', $langId );
        $story_template->set_var( 'lang_attribute', $langAttr );

        $story_template->parse ('output', 'article');
        $display = $story_template->finish ($story_template->get_var('output'));
    } else {
        // Set page title
        $pagetitle = $story->DisplayElements('title');

        $rdf = '';
        if ($story->DisplayElements('trackbackcode') == 0) {
            if ($_CONF['trackback_enabled']) {
                $permalink = COM_buildUrl ($_CONF['site_url']
                                           . '/article.php?story=' . $story->getSid());
                $trackbackurl = TRB_makeTrackbackUrl ($story->getSid());
                $rdf = '<!--' . LB
                     . TRB_trackbackRdf ($permalink, $pagetitle, $trackbackurl)
                     . LB . '-->' . LB;
            }
            if ($_CONF['pingback_enabled']) {
                header ('X-Pingback: ' . $_CONF['site_url'] . '/pingback.php');
            }
        }
        $display .= COM_siteHeader ('menu', $pagetitle, $rdf);

        if (isset ($_GET['msg'])) {
            $display .= COM_showMessage (COM_applyFilter ($_GET['msg'], true));
        }

        DB_query ("UPDATE {$_TABLES['stories']} SET hits = hits + 1 WHERE (sid = '".$story->getSid()."') AND (date <= NOW()) AND (draft_flag = 0)");

        // Display whats related

        $story_template = new Template($_CONF['path_layout'] . 'article');
        $story_template->set_file('article','article.thtml');

        $story_template->set_var('xhtml', XHTML);
        $story_template->set_var('site_url', $_CONF['site_url']);
        $story_template->set_var('site_admin_url', $_CONF['site_admin_url']);
        $story_template->set_var('layout_url', $_CONF['layout_url']);
        $story_template->set_var('story_id', $story->getSid());
        $story_template->set_var('story_title', $pagetitle);
        $story_options = array ();
        if (($_CONF['hideemailicon'] == 0) && (!empty ($_USER['username']) ||
                (($_CONF['loginrequired'] == 0) &&
                 ($_CONF['emailstoryloginrequired'] == 0)))) {
            $emailUrl = $_CONF['site_url'] . '/profiles.php?sid=' . $story->getSid()
                      . '&amp;what=emailstory';
            $story_options[] = COM_createLink($LANG11[2], $emailUrl);
            $story_template->set_var ('email_story_url', $emailUrl);
            $story_template->set_var ('lang_email_story', $LANG11[2]);
            $story_template->set_var ('lang_email_story_alt', $LANG01[64]);
        }
        $printUrl = COM_buildUrl ($_CONF['site_url']
                . '/article.php?story=' . $story->getSid() . '&amp;mode=print');
        if ($_CONF['hideprintericon'] == 0) {
            $story_options[] = COM_createLink($LANG11[3], $printUrl, array('rel' => 'nofollow'));
            $story_template->set_var ('print_story_url', $printUrl);
            $story_template->set_var ('lang_print_story', $LANG11[3]);
            $story_template->set_var ('lang_print_story_alt', $LANG01[65]);
        }
        if ($_CONF['pdf_enabled'] == 1) {
            $pdfUrl = $_CONF['site_url']
                    . '/pdfgenerator.php?pageType=2&amp;pageData='
                    . urlencode ($printUrl);
            $story_options[] = COM_createLink($LANG11[5], $pdfUrl);
            $story_template->set_var ('pdf_story_url', $printUrl);
            $story_template->set_var ('lang_pdf_story', $LANG11[5]);
        }
        $related = STORY_whatsRelated ($story->displayElements('related'),
                        $story->displayElements('uid'), $story->displayElements('tid'));
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
                                  STORY_renderArticle ($story, 'n', '', $query));

        // display comments or not?
        if ( (is_numeric($mode)) and ($_CONF['allow_page_breaks'] == 1) )
        {
            $story_page = $mode;
            $mode = '';
            if( $story_page <= 0 ) {
                $story_page = 1;
            }
            $article_arr = explode( '[page_break]', $story->displayElements('bodytext'));
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
        if (($story->displayElements('commentcode') >= 0) and $show_comments) {
            $delete_option = (SEC_hasRights('story.edit') && ($story->getAccess() == 3)
                             ? true : false);
            require_once ( $_CONF['path_system'] . 'lib-comment.php' );
            $story_template->set_var ('commentbar',
                    CMT_userComments ($story->getSid(), $story->displayElements('title'), 'article',
                                      $order, $mode, 0, $page, false, $delete_option, $story->displayElements('commentcode')));
        }
        if ($_CONF['trackback_enabled'] && ($story->displayElements('trackbackcode') >= 0) &&
                $show_comments) {
            if (SEC_hasRights ('story.ping')) {
                if (($story->displayElements('draft_flag') == 0) &&
                    ($story->displayElements('day') < time ())) {
                    $url = $_CONF['site_admin_url']
                         . '/trackback.php?mode=sendall&amp;id=' . $story->getSid();
                    $story_template->set_var ('send_trackback_link',
                        COM_createLink($LANG_TRB['send_trackback'], $url));
                    $story_template->set_var ('send_trackback_url', $url);
                    $story_template->set_var ('lang_send_trackback_text',
                                              $LANG_TRB['send_trackback']);
                }
            }

            $permalink = COM_buildUrl ($_CONF['site_url']
                                       . '/article.php?story=' . $story->getSid());
            $story_template->set_var ('trackback',
                    TRB_renderTrackbackComments ($story->getSID(), 'article',
                                                 $story->displayElements('title'), $permalink));
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
