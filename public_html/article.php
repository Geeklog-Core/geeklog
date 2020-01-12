<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | article.php                                                               |
// |                                                                           |
// | Shows articles in various formats.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
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
require_once $_CONF['path_system'] . 'lib-article.php';
require_once $_CONF['path_system'] . 'lib-comment.php';
if ($_CONF['trackback_enabled']) {
    require_once $_CONF['path_system'] . 'lib-trackback.php';
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation

// echo COM_debug($_POST);

/**
 * Extract external <a> tags
 *
 * @param  string $text
 * @return array
 */
function extractExternalLinks($text) {
    global $_CONF;

    $retval = array();

    if (preg_match_all('@<a\s.*?href="(https?://.+?)".*?>.+?</a>@im', $text, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            if (stripos($match[1], $_CONF['site_url']) !== 0) {
                $retval[$match[1]] = $match[0];
            }
        }
    }

    return $retval;
}

// MAIN
CMT_updateCommentcodes();
$display = '';

$mode = Geeklog\Input::fPost('mode', Geeklog\Input::fPost('format', ''));

if (!empty($mode)) {
    $sid = Geeklog\Input::fPost('story', '');
    $order = Geeklog\Input::fPost('order', '');
    $query = Geeklog\Input::post('query', '');
    $reply = Geeklog\Input::fPost('reply', '');
    $page = (int) Geeklog\Input::fPost('cpage', 0);
} else {
    COM_setArgNames(array('story', 'mode'));
    $sid = COM_applyFilter(COM_getArgument('story'));
    $mode = COM_applyFilter(COM_getArgument('mode'));
    $order = Geeklog\Input::fGet('order', '');
    $query = Geeklog\Input::get('query', '');
    $reply = Geeklog\Input::fGet('reply', '');
    $page = (int) Geeklog\Input::fGet('cpage', 0);
}

if (!empty($_REQUEST['sid'])) {
    $sid = Geeklog\Input::fRequest('sid');
}
if (empty($sid) && !empty($_POST['cmt_sid'])) {
    $sid = Geeklog\Input::fPost('cmt_sid');
}
if (empty($sid)) {
    COM_handle404();
}

// Get topic
TOPIC_getTopic('article', $sid);

if ((strcasecmp($order, 'ASC') !== 0) && (strcasecmp($order, 'DESC') !== 0)) {
    $order = '';
}

$result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE sid = '$sid'" . COM_getPermSql('AND'));
$A = DB_fetchArray($result);
if ($A['count'] > 0) {
    $article = new Article();

    $args = array(
        'sid'  => $sid,
        'mode' => 'view',
    );

    $output = STORY_LOADED_OK;
    $svc_msg = array();
    $output = array();
    $result = PLG_invokeService('story', 'get', $args, $output, $svc_msg);

    if ($result == PLG_RET_OK) {
        // loadFromArray cannot be used, since it overwrites the timestamp
        foreach ($article->_dbFields as $fieldname => $save) {
            $varname = '_' . $fieldname;

            if (array_key_exists($fieldname, $output)) {
                $article->{$varname} = $output[$fieldname];
            }
        }

        $article->_username = $output['username'];
        $article->_fullname = $output['fullname'];
    }

    if ($output == STORY_PERMISSION_DENIED) {
        $display = COM_showMessageText($LANG_ACCESS['storydenialmsg'], $LANG_ACCESS['accessdenied']);
        $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_ACCESS['accessdenied']));
    } elseif ($output == STORY_INVALID_SID) {
        COM_handle404();
    } elseif (($mode === 'print') && ($_CONF['hideprintericon'] == 0)) {
        $articleTemplate = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'article'));
        $articleTemplate->set_file('article', 'printable.thtml');
        if (XHTML != '') {
            $articleTemplate->set_var('xmlns', ' xmlns="http://www.w3.org/1999/xhtml"');
        }
        $articleTemplate->set_var('direction', $LANG_DIRECTION);

        $theme = $_CONF['theme'];
        $dir = isset($LANG_DIRECTION) && ($LANG_DIRECTION === 'rtl') ? 'rtl' : 'ltr';
        $paths = array(
            'denim'        => 'layout/' . $theme . '/css_' . $dir . '/print.css',
            'professional' => 'layout/' . $theme . '/print.css',
            'other'        => 'layout/' . $theme . '/css/print.css',
        );

        global $_SCRIPTS;
        foreach ($paths as $path) {
            if (file_exists($_CONF['path_html'] . $path)) {
                $_SCRIPTS->setCssFile('print', '/' . $path, true, array('media' => 'print'));
            }
        }

        // Override style for <a> tags
        $_SCRIPTS->setCSS('a { color: blue !important; text-decoration: underline !important; }');
        $articleTemplate->set_var('plg_headercode', $_SCRIPTS->getHeader());

        $page_title = $article->DisplayElements('page_title');
        if (empty($page_title)) {
            $page_title = $_CONF['site_name'] . ' - ' . $article->DisplayElements('title');
        }
        $articleTemplate->set_var('page_title', $page_title);

        $articleTemplate->set_var('story_title', $article->DisplayElements('title'));
        header('Content-Type: text/html; charset=' . COM_getCharset());
        header('X-XSS-Protection: 1; mode=block');
        header('X-Content-Type-Options: nosniff');

        if (!empty($_CONF['frame_options'])) {
            header('X-FRAME-OPTIONS: ' . $_CONF['frame_options']);
        }

        $articleTemplate->set_var('story_date', $article->displayElements('date'));
        $articleTemplate->set_var('story_modified', $article->displayElements('modified'));

        if ($_CONF['contributedbyline'] == 1) {
            $articleTemplate->set_var('lang_contributedby', $LANG01[1]);
            $authorname = COM_getDisplayName($article->displayElements('uid'));
            $articleTemplate->set_var('author', $authorname);
            $articleTemplate->set_var('story_author', $authorname);
            $articleTemplate->set_var('story_author_username', $article->DisplayElements('username'));
        }

        $introtext = $article->DisplayElements('introtext');
        $bodytext = $article->DisplayElements('bodytext');
        if (empty($bodytext)) {
            $fulltext = $introtext;
            $fulltext_no_br = $introtext;
        } else {
            $fulltext = $introtext . '<br' . XHTML . '><br' . XHTML . '/>' . $bodytext;
            $fulltext_no_br = $introtext . ' ' . $bodytext;
        }
        if ($article->DisplayElements('postmode') == 'plaintext') {
            $introtext = '<p>' . $introtext . '</p>';
            $bodytext = '<p>' . $bodytext . '</p>';
            $fulltext = '<p>' . $fulltext . '</p>';
            $fulltext_no_br = '<p>' . $fulltext_no_br . '</p>';
        }

        $links = extractExternalLinks($fulltext_no_br);
        $externalLinks = array();
        $i = 1;
        foreach ($links as $url => $tag) {
            $marker = '[*' . $i . '] ';
            $externalLinks[] = $marker . $url;
            $fulltext_no_br = str_replace($tag, $tag . $marker, $fulltext_no_br);
            $i++;
        }

        if (count($externalLinks) > 0) {
            $externalLinks = '<p>' . implode('<br' . XHTML . '>' . PHP_EOL, $externalLinks) . PHP_EOL . '</p>';
        } else {
            $externalLinks = '';
        }
        $articleTemplate->set_var('external_links', $externalLinks);

        $articleTemplate->set_var('story_introtext', $introtext);
        $articleTemplate->set_var('story_bodytext', $bodytext);
        $articleTemplate->set_var('story_text', $fulltext);
        $articleTemplate->set_var('story_text_no_br', $fulltext_no_br);
        $articleTemplate->set_var('site_name', $_CONF['site_name']);
        $articleTemplate->set_var('site_slogan', $_CONF['site_slogan']);
        $articleTemplate->set_var('story_id', $article->getSid());
        $articleUrl = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $article->getSid());

        if ($article->DisplayElements('commentcode') >= 0) {
            $commentsUrl = $articleUrl . '#comments';
            $comments = $article->DisplayElements('comments');
            $numComments = COM_numberFormat($comments);
            $articleTemplate->set_var('story_comments', $numComments);
            $articleTemplate->set_var('comments_url', $commentsUrl);
            $articleTemplate->set_var('comments_text',
                $numComments . ' ' . $LANG01[3]);
            $articleTemplate->set_var('comments_count', $numComments);
            $articleTemplate->set_var('lang_comments', $LANG01[3]);

            if ($numComments > 1) {
                $comments_with_count = sprintf($LANG01[121], $numComments);
            } else {
                $comments_with_count = sprintf($LANG01[143], $numComments);
            }

            if ($comments > 0) {
                $comments_with_count = COM_createLink($comments_with_count,
                    $commentsUrl);
            }
            $articleTemplate->set_var('comments_with_count',
                $comments_with_count);
        }
        $articleTemplate->set_var('lang_full_article', $LANG08[33]);
        $articleTemplate->set_var('article_url', $articleUrl);
        $printable = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
            . $article->getSid() . '&amp;mode=print');
        $articleTemplate->set_var('printable_url', $printable);
        COM_setLangIdAndAttribute($articleTemplate);

        $articleTemplate->parse('output', 'article');
        $display = $articleTemplate->finish($articleTemplate->get_var('output'));
    } else {
        // Set page title
        $pagetitle = $article->DisplayElements('page_title');
        if (empty($pagetitle)) {
            $pagetitle = $article->DisplayElements('title');
        }

        $headercode = '';
        $permalink = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
            . $article->getSid());
        $headercode .= '<link rel="canonical" href="' . $permalink . '"'
            . XHTML . '>';

        // Meta Tags
        if ($_CONF['meta_tags'] > 0) {
            $headercode .= LB . PLG_getMetaTags(
                    'article', $article->getSid(),
                    array(
                        array(
                            'name'    => 'description',
                            'content' => $article->DisplayElements('meta_description'),
                        ),
                        array(
                            'name'    => 'keywords',
                            'content' => $article->DisplayElements('meta_keywords'),
                        ),
                    )
                );
        }

        // Add hreflang link element if Multi Language Content is setup
        // Only allow hreflang link element to be visible when on canonical url
        // ie no second pages which can happen with comments, or if [page_break] is used or with extra trailing variables like from a search query
        if (strtolower(COM_getCurrentURL()) == strtolower($permalink)) {
            $headercode .= COM_createHREFLang('story', $article->getSid());
        }

        if ($article->DisplayElements('trackbackcode') == 0) {
            if ($_CONF['trackback_enabled']) {
                $trackbackurl = TRB_makeTrackbackUrl($article->getSid());
                $headercode .= LB . '<!--' . LB
                    . TRB_trackbackRdf($permalink, $pagetitle, $trackbackurl)
                    . LB . '-->' . LB;
            }
            if ($_CONF['pingback_enabled']) {
                header('X-Pingback: ' . $_CONF['site_url'] . '/pingback.php');
            }
        }

        if (isset($_GET['msg'])) {
            $msg = (int) Geeklog\Input::fGet('msg');
            if ($msg > 0) {
                $plugin = Geeklog\Input::fGet('plugin', '');
                $display .= COM_showMessage($msg, $plugin);
            }
        }

        // Don't count views for the author of the article (feature request #0001572)
        if (COM_isAnonUser() || ($_USER['uid'] != $article->displayElements('uid'))) {
            DB_query("UPDATE {$_TABLES['stories']} SET hits = hits + 1 WHERE (sid = '" . DB_escapeString($article->getSid()) . "') AND (date <= NOW()) AND (draft_flag = 0)");
        }

        $articleTemplate = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'article'));

        // Render article near top so it can use mode if set (ie to figure out page break)
        // Another option here could be to figure out if story is first on page
        $tmpl = $_CONF['showfirstasfeatured'] ? 'featuredarticletext.thtml' : '';
        $articleTemplate->set_var('formatted_article',
            STORY_renderArticle($article, 'n', $tmpl, $query));

        // Figure out to display comments or not on this page of the article
        $story_page = 1;
        $show_comments = true;
        $page_break_count = $article->displayElements('numpages');
        if ($_CONF['allow_page_breaks'] == 1 && $page_break_count > 1) {
            // if not numeric then mode is used by comments to determine how to display them
            if (!is_numeric($mode)) {
                // if not empty then assume mode is being used by comments to change display and check if need to be on last page
                if (!empty($mode) && $_CONF['allow_page_breaks'] == 1 && $_CONF['page_break_comments'] == 'last' && $page_break_count > 1) {
                    // See github issue #1019 for bug regarding $_CONF['page_break_comments'] ='all' and not being able to figure out what article page we are on if comment display is changed since mode is being used by article for page number and comments to change display
                    $story_page = $page_break_count;
                } else {
                    $story_page = 1;
                }
            } else {
                $story_page = $mode;
                $mode = ''; // need to clear it since mode post variable is used by comment as well to determine how to display comments

                if ($story_page <= 0) {
                    $story_page = 1;
                }

                if ($story_page > $page_break_count) { // Can't have page count greater than actual number of pages
                    $story_page = $page_break_count;
                }
            }

            if ($page_break_count > 1) {
                $conf = $_CONF['page_break_comments'];
                if (
                    ($conf === 'all') ||
                    (($conf === 'first') && ($story_page == 1)) ||
                    (($conf === 'last') && ($page_break_count == $story_page))
                ) {
                    $show_comments = true;
                } else {
                    $show_comments = false;
                }
            } else {
                $show_comments = true;
            }
        } else {
            $show_comments = true;
        }

        // Pass Page and Comment Display info to template in case it wants to display anything else with comments
        $articleTemplate->set_var('page_number', $story_page);
        $articleTemplate->set_var('page_total', $page_break_count);
        $articleTemplate->set_var('comments_on_page', $show_comments);

        // Display whats related
        $articleTemplate->set_file('article', 'article.thtml');

        $articleTemplate->set_var('story_id', $article->getSid());
        $articleTemplate->set_var('story_title', $pagetitle);
        $story_options = array();
        if (($_CONF['hideemailicon'] == 0) && (!COM_isAnonUser() ||
                (($_CONF['loginrequired'] == 0) &&
                    ($_CONF['emailstoryloginrequired'] == 0)))
        ) {
            $emailUrl = $_CONF['site_url'] . '/profiles.php?sid=' . $article->getSid()
                . '&amp;what=emailstory';
            $story_options[] = COM_createLink($LANG11[2], $emailUrl);
            $articleTemplate->set_var('email_story_url', $emailUrl);
            $articleTemplate->set_var('lang_email_story', $LANG11[2]);
            $articleTemplate->set_var('lang_email_story_alt', $LANG01[64]);
        }
        $printUrl = COM_buildUrl($_CONF['site_url']
            . '/article.php?story=' . $article->getSid() . '&amp;mode=print');
        if ($_CONF['hideprintericon'] == 0) {
            $story_options[] = COM_createLink($LANG11[3], $printUrl, array('rel' => 'nofollow'));
            $articleTemplate->set_var('print_story_url', $printUrl);
            $articleTemplate->set_var('lang_print_story', $LANG11[3]);
            $articleTemplate->set_var('lang_print_story_alt', $LANG01[65]);
        }
        if ($_CONF['backend'] == 1) {
            $tid = $article->displayElements('tid');
            $result = DB_query("SELECT filename, title, format FROM {$_TABLES['syndication']} WHERE type = 'article' AND topic = '$tid' AND is_enabled = 1");
            $feeds = DB_numRows($result);
            for ($i = 0; $i < $feeds; $i++) {
                list($filename, $title, $format) = DB_fetchArray($result);
                $feedUrl = SYND_getFeedUrl($filename);
                $feedTitle = sprintf($LANG11[6], $title);
                $feedType = SYND_getMimeType($format);
                $feedClass = 'feed-link';
                if (!empty($LANG_DIRECTION) && ($LANG_DIRECTION === 'rtl')) {
                    $feedClass .= '-rtl';
                }
                $story_options[] = COM_createLink($feedTitle, $feedUrl,
                    array(
                        'type'  => $feedType,
                        'class' => $feedClass,
                    )
                );
            }
        }
        if (($_CONF['trackback_enabled'] || $_CONF['pingback_enabled'] ||
                $_CONF['ping_enabled']) && SEC_hasRights('story.ping') &&
            ($article->displayElements('draft_flag') == 0) &&
            ($article->displayElements('day') < time()) &&
            ($article->displayElements('perm_anon') != 0)
        ) {

            // also check permissions for the topic
            $topic_anon = DB_getItem($_TABLES['topics'], 'perm_anon',
                "tid = '" . DB_escapeString($article->displayElements('tid')) . "'");

            // check special case: no link when Trackbacks are disabled for this
            // story AND pinging weblog directories is disabled
            if (($topic_anon != 0) &&
                (($article->displayElements('trackbackcode') >= 0) ||
                    $_CONF['ping_enabled'])
            ) {
                $url = $_CONF['site_admin_url']
                    . '/trackback.php?mode=sendall&amp;id=' . $article->getSid();
                $story_options[] = COM_createLink($LANG_TRB['send_trackback'],
                    $url);
            }
        }
        /*
            if (true) { // can subscribe
                $commentSubscribeURL = '';
                $story_options[] = COM_createLink('Nubbies', $commentSubscribeURL, array('rel' => 'nofollow'));
                $story_template->set_var('comment_subscribe_url', $commentSubscribeURL);
                $story_template->set_var('lang_comment_subscribe', 'Nubbies');
            }
        */
        $related = STORY_whatsRelated($article->displayElements('related'),
            $article->displayElements('uid'),
            $article->getSid());
        if (!empty($related)) {
            $related = COM_startBlock($LANG11[1], '',
                    COM_getBlockTemplate('whats_related_block', 'header'))
                . $related
                . COM_endBlock(COM_getBlockTemplate('whats_related_block',
                    'footer'));
        }
        if (count($story_options) > 0) {
            $optionsblock = COM_startBlock($LANG11[4], '',
                    COM_getBlockTemplate('story_options_block', 'header'))
                . COM_makeList($story_options, PLG_getThemeItem('article-css-list-options', 'article'))
                . COM_endBlock(COM_getBlockTemplate('story_options_block',
                    'footer'));
        } else {
            $optionsblock = '';
        }
        $articleTemplate->set_var('whats_related', $related);
        $articleTemplate->set_var('story_options', $optionsblock);
        $articleTemplate->set_var('whats_related_story_options',
            $related . $optionsblock);

        // Display the comments, if there are any ..
        if (($article->displayElements('commentcode') >= 0) && $show_comments) {
            $delete_option = (SEC_hasRights('story.edit') && ($article->getAccess() == 3));
            $articleTemplate->set_var('commentbar',
                CMT_userComments($article->getSid(), $article->displayElements('title'), 'article',
                    $order, $mode, 0, $page, false, $delete_option, $article->displayElements('commentcode')));
        }
        if ($_CONF['trackback_enabled'] && ($article->displayElements('trackbackcode') >= 0) &&
            $show_comments
        ) {
            if (SEC_hasRights('story.ping')) {
                if (($article->displayElements('draft_flag') == 0) &&
                    ($article->displayElements('day') < time())
                ) {
                    $url = $_CONF['site_admin_url']
                        . '/trackback.php?mode=sendall&amp;id=' . $article->getSid();
                    $articleTemplate->set_var('send_trackback_link',
                        COM_createLink($LANG_TRB['send_trackback'], $url));
                    $articleTemplate->set_var('send_trackback_url', $url);
                    $articleTemplate->set_var('lang_send_trackback_text',
                        $LANG_TRB['send_trackback']);
                }
            }

            $permalink = COM_buildUrl($_CONF['site_url']
                . '/article.php?story=' . $article->getSid());
            $articleTemplate->set_var('trackback',
                TRB_renderTrackbackComments($article->getSID(), 'article',
                    $article->displayElements('title'), $permalink));
        } else {
            $articleTemplate->set_var('trackback', '');
        }
        $display .= $articleTemplate->finish($articleTemplate->parse('output', 'article'));

        $breadcrumbs = TOPIC_breadcrumbs('article', $article->getSid());

        $display = COM_createHTMLDocument(
            $display,
            array(
                'pagetitle'   => $pagetitle,
                'breadcrumbs' => $breadcrumbs,
                'headercode'  => $headercode,
            )
        );
    }
} else {
    COM_handle404();
}

COM_output($display);
