<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | article.php                                                               |
// |                                                                           |
// | Shows articles in various formats.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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

/**
* This page is responsible for showing a single article in different modes which
* may, or may not, include the comments attached
*
* @author   Jason Whittenburg
* @author   Tony Bibbbs, tony AT tonybibbs DOT com
* @author   Vincent Furia, vinny01 AT users DOT sourceforge DOT net
*/

/**
* Geeklog common function library
*/
require_once 'lib-common.php';
require_once $_CONF['path_system'] . 'lib-story.php';
require_once $_CONF['path_system'] . 'lib-comment.php';
if ($_CONF['trackback_enabled']) {
    require_once $_CONF['path_system'] . 'lib-trackback.php';
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

// echo COM_debug($_POST);

// MAIN
CMT_updateCommentcodes();
$display = '';

$order = '';
$query = '';
$reply = '';
$page = 0;
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
    if (isset ($_POST['cpage'])) {
        $page = COM_applyFilter ($_POST['cpage'], true);
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
    if (isset ($_GET['cpage'])) {
        $page = COM_applyFilter ($_GET['cpage'], true);
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
        $story->_username = $output['username'];
        $story->_fullname = $output['fullname'];
    }

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
        $story_template = new Template($_CONF['path_layout'] . 'article');
        $story_template->set_file('article', 'printable.thtml');
        $story_template->set_var('xhtml', XHTML);
        $story_template->set_var('site_url', $_CONF['site_url']);
        $story_template->set_var('site_admin_url', $_CONF['site_admin_url']);
        $story_template->set_var('layout_url', $_CONF['layout_url']);
        if (XHTML != '') {
            $story_template->set_var('xmlns',
                                     ' xmlns="http://www.w3.org/1999/xhtml"');
        }
        $story_template->set_var('direction', $LANG_DIRECTION);
        $story_template->set_var('page_title', $story->DisplayElements('page_title'));
        $story_template->set_var('story_title',
                                 $story->DisplayElements('title'));
        header('Content-Type: text/html; charset=' . COM_getCharset());
        if (! empty($_CONF['frame_options'])) {
            header('X-FRAME-OPTIONS: ' . $_CONF['frame_options']);
        }
        $story_template->set_var('story_date', $story->displayElements('date'));

        if ($_CONF['contributedbyline'] == 1) {
            $story_template->set_var('lang_contributedby', $LANG01[1]);
            $authorname = COM_getDisplayName($story->displayElements('uid'));
            $story_template->set_var('author', $authorname);
            $story_template->set_var('story_author', $authorname);
            $story_template->set_var('story_author_username',
                                     $story->DisplayElements('username'));
        }

        $introtext = $story->DisplayElements('introtext');
        $bodytext  = $story->DisplayElements('bodytext');
        if (empty($bodytext)) {
            $fulltext = $introtext;
            $fulltext_no_br = $introtext;
        } else {
            $fulltext = $introtext . '<br' . XHTML . '><br' . XHTML . '/>'
                      . $bodytext;
            $fulltext_no_br = $introtext . ' ' . $bodytext;
        }
        if ($story->DisplayElements('postmode') == 'plaintext') {
            $introtext = '<p>' . $introtext . '</p>';
            $bodytext = '<p>' . $bodytext . '</p>';
            $fulltext = '<p>' . $fulltext . '</p>';
            $fulltext_no_br = '<p>' . $fulltext_no_br . '</p>';
        }

        $story_template->set_var('story_introtext', $introtext);
        $story_template->set_var('story_bodytext',  $bodytext);
        $story_template->set_var('story_text', $fulltext);
        $story_template->set_var('story_text_no_br', $fulltext_no_br);

        $story_template->set_var('site_name', $_CONF['site_name']);
        $story_template->set_var('site_slogan', $_CONF['site_slogan']);
        $story_template->set_var('story_id', $story->getSid());
        $articleUrl = COM_buildUrl($_CONF['site_url']
                                   . '/article.php?story=' . $story->getSid());
        if ($story->DisplayElements('commentcode') >= 0) {
            $commentsUrl = $articleUrl . '#comments';
            $comments = $story->DisplayElements('comments');
            $numComments = COM_numberFormat($comments);
            $story_template->set_var('story_comments', $numComments);
            $story_template->set_var('comments_url', $commentsUrl);
            $story_template->set_var('comments_text',
                    $numComments . ' ' . $LANG01[3]);
            $story_template->set_var('comments_count', $numComments);
            $story_template->set_var('lang_comments', $LANG01[3]);
            $comments_with_count = sprintf($LANG01[121], $numComments);

            if ($comments > 0) {
                $comments_with_count = COM_createLink($comments_with_count,
                                                      $commentsUrl);
            }
            $story_template->set_var('comments_with_count',
                                     $comments_with_count);
        }
        $story_template->set_var('lang_full_article', $LANG08[33]);
        $story_template->set_var('article_url', $articleUrl);
        $printable = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                                  . $story->getSid() . '&amp;mode=print');
        $story_template->set_var('printable_url', $printable);

        COM_setLangIdAndAttribute($story_template);

        $story_template->parse('output', 'article');
        $display = $story_template->finish($story_template->get_var('output'));
    } else {
        // Set page title
        $pagetitle = $story->DisplayElements('page_title');
        if(empty($pagetitle)) {
            $pagetitle = $story->DisplayElements('title');
        }

        $headercode = '';
        $permalink = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                                  . $story->getSid());
        $headercode .= '<link rel="canonical" href="' . $permalink . '"'
                    . XHTML . '>';

        // Meta Tags
        If ($_CONF['meta_tags'] > 0) {
            $meta_description  = $story->DisplayElements('meta_description');
            $meta_keywords  = $story->DisplayElements('meta_keywords');        
            $headercode .= COM_createMetaTags($meta_description, $meta_keywords);
        }

        if ($story->DisplayElements('trackbackcode') == 0) {
            if ($_CONF['trackback_enabled']) {
                $trackbackurl = TRB_makeTrackbackUrl($story->getSid());
                $headercode .= LB . '<!--' . LB
                     . TRB_trackbackRdf($permalink, $pagetitle, $trackbackurl)
                     . LB . '-->' . LB;
            }
            if ($_CONF['pingback_enabled']) {
                header('X-Pingback: ' . $_CONF['site_url'] . '/pingback.php');
            }
        }
        
        $display .= COM_siteHeader('menu', $pagetitle, $headercode);

        if (isset($_GET['msg'])) {
            $msg = COM_applyFilter($_GET['msg'], true);
            if ($msg > 0) {
                $plugin = '';
                if (isset($_GET['plugin'])) {
                    $plugin = COM_applyFilter($_GET['plugin']);
                }
                $display .= COM_showMessage($msg, $plugin);
            }
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
        if (($_CONF['hideemailicon'] == 0) && (!COM_isAnonUser() ||
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
        if ($_CONF['backend'] == 1) {
            $tid = $story->displayElements('tid');
            $result = DB_query("SELECT filename, title, format FROM {$_TABLES['syndication']} WHERE type = 'article' AND topic = '$tid' AND is_enabled = 1");
            $feeds = DB_numRows($result);
            for ($i = 0; $i < $feeds; $i++) {
                list($filename, $title, $format) = DB_fetchArray($result);
                $feedUrl = SYND_getFeedUrl($filename);
                $feedTitle = sprintf($LANG11[6], $title);
                $feedType = SYND_getMimeType($format);
                $feedClass = 'feed-link';
                if (!empty($LANG_DIRECTION) && ($LANG_DIRECTION == 'rtl')) {
                    $feedClass .= '-rtl';
                }
                $story_options[] = COM_createLink($feedTitle, $feedUrl,
                                                  array('type'  => $feedType,
                                                        'class' => $feedClass));
            }
        }
        if (($_CONF['trackback_enabled'] || $_CONF['pingback_enabled'] ||
                $_CONF['ping_enabled']) && SEC_hasRights('story.ping') &&
                ($story->displayElements('draft_flag') == 0) &&
                ($story->displayElements('day') < time ()) &&
                ($story->displayElements('perm_anon') != 0)) {

            // also check permissions for the topic
            $topic_anon = DB_getItem($_TABLES['topics'], 'perm_anon',
                "tid = '" . addslashes($story->displayElements('tid')) . "'");

            // check special case: no link when Trackbacks are disabled for this
            // story AND pinging weblog directories is disabled
            if (($topic_anon != 0) &&
                    (($story->displayElements('trackbackcode') >= 0) ||
                    $_CONF['ping_enabled'])) {
                $url = $_CONF['site_admin_url']
                     . '/trackback.php?mode=sendall&amp;id=' . $story->getSid();
                $story_options[] = COM_createLink($LANG_TRB['send_trackback'],
                                                  $url);
            }
        }
    /*
        if (true) { // can subscribe
            $commentSubscribeURL = '';
            $story_options[] = COM_createLink('Nubbies', $commentSubscribeURL, array('rel' => 'nofollow'));
            $story_template->set_var ('comment_subscribe_url', $commentSubscribeURL);
            $story_template->set_var ('lang_comment_subscribe', 'Nubbies');
        }
    */
        $related = STORY_whatsRelated($story->displayElements('related'),
                                      $story->displayElements('uid'),
                                      $story->displayElements('tid'));
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

COM_output($display);

?>
