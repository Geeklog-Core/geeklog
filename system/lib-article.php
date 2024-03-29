<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-article.php                                                           |
// |                                                                           |
// | Story-related functions needed in more than one place.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

if ($_CONF['allow_user_photo']) {
    // only needed for the USER_getPhoto function
    require_once $_CONF['path_system'] . 'lib-user.php';
}

// this must be kept in sync with the actual size of 'sid' in the db ...
define('STORY_MAX_ID_LENGTH', 128);

// Story Record Options for the STATUS Field
if (!defined('STORY_ARCHIVE_ON_EXPIRE')) {
    define('STORY_ARCHIVE_ON_EXPIRE', '10');
    define('STORY_DELETE_ON_EXPIRE', '11');
}

/**
 * Takes an article class and renders HTML in the specified template and style.
 * Formats the given article into HTML. Called by index.php, article.php,
 * submit.php and admin/article.php (Preview mode for the last two).
 *
 * @param   Article $story    The story to display, an instance of the Story class.
 * @param   string  $index    n = Full display of article. p = 'Preview' mode. Else y = introtext only.
 * @param   string  $storyTpl The template to use to render the story.
 * @param   string  $query    A search query, if one was specified.
 * @param   string  $articlePage            Current page being displayed for articles. Used only with $index of 'n' and if page breaks enabled (else always assume 1)
 * @param   string  $articleCountOnPage     Current article count being displayed on page. Used for topics to display blocks between articles
 * @param   array   $story_options          Array of article options for the block. Only displayed on full article page
  * @return  string           Article as formatted HTML.
 *                            Note: Formerly named COM_Article, and re-written totally since then.
 */
function STORY_renderArticle($story, $index = '', $storyTpl = 'articletext.thtml', $query = '', $articlePage = 1, $articleCountOnPage = 1, $story_options = [])
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG05, $LANG11, $LANG24, $LANG_TRB,
           $_IMAGE_TYPE, $_STRUCT_DATA;

    static $storyCounter = 0;

    if ($story->DisplayElements('featured') == 1) {
        $article_filevar = 'featuredarticle';
    } elseif ($story->DisplayElements('statuscode') == STORY_ARCHIVE_ON_EXPIRE && $story->DisplayElements('expire') <= time()) {
        $article_filevar = 'archivearticle';
    } else {
        $article_filevar = 'article';
    }

    if (empty($storyTpl)) {
        $storyTpl = 'articletext.thtml';
    }

    // Change article template file with the topic (feature request #275)
    $templateDir = $_CONF['path_layout'] . 'article/';
    $topicDir = $_CONF['path_layout'] . 'topics/' . $story->DisplayElements('tid') . '/';

    if (is_dir($topicDir) && file_exists($topicDir . $storyTpl)) {
        $templateDir = $topicDir;
    }

    $article = COM_newTemplate(CTL_core_templatePath($templateDir));
    $article->set_file(array(
        'article'          => $storyTpl,
        'bodytext'         => 'articlebodytext.thtml',
        'featuredarticle'  => 'featuredarticletext.thtml',
        'featuredbodytext' => 'featuredarticlebodytext.thtml',
        'archivearticle'   => 'archivearticletext.thtml',
        'archivebodytext'  => 'archivearticlebodytext.thtml',
    ));

    // begin instance caching...
    $cache_time = $story->DisplayElements('cache_time');
    $current_article_tid = $story->DisplayElements('tid');
    $retval = false; // If stays false will rebuild article and not used cache (checks done below)

    // Check cache time or if search query do not use cache as need to add highlight
    if (($cache_time > 0 || $cache_time == -1) && empty($query)) {
        $hash = CACHE_security_hash();
        $cacheInstance = 'article__' . $story->getSid() . '_' . $index . $articlePage . '_' . $article_filevar . '_' . $current_article_tid . '_' . $hash . '_' . $_CONF['theme'];

        if ($_CONF['cache_templates']) {
            $retval = $article->check_instance($cacheInstance, $article_filevar);
        } else {
            $retval = CACHE_check_instance($cacheInstance);
        }

        $cache_found = false;
        if ($retval && $cache_time == -1) {
            // Cache file found so use it since no time limit set to recreate
            $cache_found = true;
        } elseif ($retval && $cache_time > 0) {
            $lu = CACHE_get_instance_update($cacheInstance);
            $now = time();
            if (($now - $lu) < $cache_time) {
                // Cache file found so use it since under time limit set to recreate
                $cache_found = true;
            } else {
                // generate article and create cache file
                // Cache time is not built into template caching so need to delete it manually and reset $retval
                if ($_CONF['cache_templates']) {
                    CACHE_remove_instance($cacheInstance);
                    $_STRUCT_DATA->clear_cachedScript('article', $story->getSid());

                    // Need to close and recreate template class since issues arise when theme templates are cached
                    unset($article); // Close template class
                    $article = COM_newTemplate(CTL_core_templatePath($templateDir));
                    $article->set_file(array(
                        'article'          => $storyTpl,
                        'bodytext'         => 'articlebodytext.thtml',
                        'featuredarticle'  => 'featuredarticletext.thtml',
                        'featuredbodytext' => 'featuredarticlebodytext.thtml',
                        'archivearticle'   => 'archivearticletext.thtml',
                        'archivebodytext'  => 'archivearticlebodytext.thtml',
                    ));
                } else { // theme templates are not cache so can go ahead and delete story cache
                    CACHE_remove_instance($cacheInstance);
                    $_STRUCT_DATA->clear_cachedScript('article', $story->getSid());
                }
                $retval = false;
            }
        } else {
            // Need to reset especially if caching is disabled for a certain story but template caching has been enabled for the theme
            $retval = false;
        }

        // Now find structured data cache if required
        // Structured Data is cached by itself. Need to cache in case structured data autotags exist in page.
        // Since autotags are executed when the page is rendered therefore we have to cache structured data if page is cached.
        // Only cache and use structured data on full article view
        if ($index == 'n' && !empty($story->DisplayElements('structured_data_type')) && $cache_found) {
            if (!$_STRUCT_DATA->get_cachedScript('article', $story->getSid(), $cache_time)) {
                // Structured Data missing for some reason even though page cache found. Render all again
                $retval = false;
            }
        }
    }

    // ****************************************
    // This Stuff below is never cached
    $articleUrl = COM_buildURL($_CONF['site_url'] . '/article.php?story=' . $story->getSid());
    $article->set_var('article_url', $articleUrl);
    $article->set_var('story_title', $story->DisplayElements('title'));

    // Date formatting set by user therefore cannot be cached
    $article->set_var('story_date', $story->DisplayElements('date'), false, true);
    $article->set_var('story_datetime', $story->DisplayElements('datetime'), false, true);

    // Story views increase with every visit so cannot be cached
    if ($_CONF['hideviewscount'] != 1) {
        $article->set_var('lang_views', $LANG01[106], false, true);
        $article->set_var('story_hits', $story->DisplayElements('hits'), false, true);
    }

    // Topic Icon is user configurable so do not cache
    $topicname = $story->DisplayElements('topic');
    $topicurl = TOPIC_getUrl($story->DisplayElements('tid'));
    if ($story->DisplayElements('show_topic_icon') == 1) {
        $imageurl = $story->DisplayElements('imageurl');
        if (!empty($imageurl)) {
            $imageurl = COM_getTopicImageUrl($imageurl);
            $article->set_var('story_topic_image_url', $imageurl, false, true);
            $topicimage = '<img src="' . $imageurl . '" class="float'
                . $_CONF['article_image_align'] . '" alt="'
                . $topicname . '" title="' . $topicname . '"' . XHTML . '>';
            $article->set_var('story_anchortag_and_image',
                COM_createLink(
                    $topicimage,
                    $topicurl,
                    array()
                )
                , false, true
            );
			
			$article->set_var('story_topic_name', $topicname, false, true);
			$article->set_var('story_topic_url', $topicurl, false, true);
            $article->set_var('story_topic_image', $imageurl, false, true);			
            
            $topicimage_noalign = '<img src="' . $imageurl . '" alt="'
                . $topicname . '" title="' . $topicname . '"' . XHTML . '>';
            $article->set_var('story_anchortag_and_image_no_align',
                COM_createLink(
                    $topicimage_noalign,
                    $topicurl,
                    array()
                ),
                false, true
            );
            $article->set_var('story_topic_image_no_align', $topicimage_noalign, false, true);
        }
    }

    if ($_CONF['likes_enabled'] != 0 && $_CONF['likes_articles'] != 0) {
        $article->set_var('likes_control',LIKES_control('article', '',$story->getSid(), $_CONF['likes_articles']), false, true);
    } else {
        $article->set_var('likes_control', '', false, true);
    }

    // ****************************************

    // Create article (and ignore cache) only if preview, or query not empty, or if no cache or cache has been disabled
    if ($index == 'p' || !empty($query) || !$retval) {
        // Main article content
        if ($index == 'p') {
            $introtext = $story->getPreviewText('introtext');
            $bodytext = $story->getPreviewText('bodytext');
        } else {
            $introtext = $story->displayElements('introtext');
            $bodytext = $story->displayElements('bodytext');
        }
        $readmore = empty($bodytext) ? 0 : 1;
        $numwords = COM_numberFormat(count(explode(' ', COM_getTextContent($bodytext))));
        if (COM_onFrontpage()) {
            $bodytext = '';
        }
        if (!empty($query)) {
            $introtext = COM_highlightQuery($introtext, $query);
            $bodytext = COM_highlightQuery($bodytext, $query);
        }

        $article->set_var('article_filevar', '');
        $article->set_var('site_name', $_CONF['site_name']);
        //$article->set_var( 'story_date', $story->DisplayElements('date') );
        $article->set_var('story_date_short', $story->DisplayElements('shortdate'));
        $article->set_var('story_date_only', $story->DisplayElements('dateonly'));
        $article->set_var('story_id', $story->getSid());
        // Send index (display type) so theme developers have the option to display things
        $article->set_var('story_display_type', $index, false, true);

        if ($_CONF['contributedbyline'] == 1) {
            $article->set_var('lang_contributed_by', $LANG01[1]);
            $article->set_var('contributedby_uid', $story->DisplayElements('uid'));

            $fullname = $story->DisplayElements('fullname');
            $username = $story->DisplayElements('username');
            $article->set_var('contributedby_user', $username);
            if (empty($fullname)) {
                $article->set_var('contributedby_fullname', $username);
            } else {
                $article->set_var('contributedby_fullname', $fullname);
            }

            $isBanned = USER_isBanned($story->DisplayElements('uid'));
            $authorname = COM_getDisplayName(
                $story->DisplayElements('uid'), $username, $fullname
            );
            if ($isBanned) {
                $authorname = '<span style="text-decoration: line-through;">' . $authorname . '</span>';
            }
            $article->set_var('contributedby_author', $authorname);
            $article->set_var('author', $authorname);

            $profileUrl = '';
            if (($story->DisplayElements('uid') > 1) &&
                (!$isBanned || SEC_hasRights('user.edit'))) {
                $profileUrl = $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid='
                    . $story->DisplayElements('uid');
                $article->set_var('start_contributedby_anchortag',
                    '<a class="storybyline" href="' . $profileUrl
                    . '" rel="author">');
                $article->set_var('end_contributedby_anchortag', '</a>');
                $article->set_var('contributedby_url', $profileUrl);
            }

            $photo = '';
            if ($_CONF['allow_user_photo'] == 1) {
                $authphoto = $story->DisplayElements('photo');
                $photo = USER_getPhoto($story->DisplayElements('uid'), $authphoto,
                    $story->DisplayElements('email'));
            }
            if (!empty($photo)) {
                $article->set_var('contributedby_photo', $photo);
                $article->set_var('author_photo', $photo);
				
				$linkIcon = rtrim($_CONF['path_layout'], '/')  . '/images/smallcamera.' . $_IMAGE_TYPE;
				$sizeAttributes = COM_getImgSizeAttributes($linkIcon);					
                $camera_icon = '<img ' . $sizeAttributes . 'src="' . $_CONF['layout_url']
                    . '/images/smallcamera.' . $_IMAGE_TYPE . '" alt=""'
                    . XHTML . '>';
                $article->set_var('camera_icon',
                    COM_createLink($camera_icon, $profileUrl));
            } else {
                $article->set_var('contributedby_photo', '');
                $article->set_var('author_photo', '');
                $article->set_var('camera_icon', '');
            }
        }

        $article->set_var('story_topic_id', $story->DisplayElements('tid'));
        $article->set_var('story_topic_name', $topicname);
        $article->set_var('story_topic_url', $topicurl);

        $recent_comment_anchortag = '';

        $article->set_var('lang_permalink', $LANG01[127]);

        $show_comments = true;
        // n = Full display of article. p = 'Preview' mode.
        if ((($index != 'n') && ($index != 'p')) || !empty($query)) {
            $attributes = ' class="non-ul"';
            $attr_array = array('class' => 'non-ul');
            if (!empty($query)) {
                $attributes .= ' rel="bookmark"';
                $attr_array['rel'] = 'bookmark';
            }
            $article->set_var('start_storylink_anchortag',
                '<a href="' . $articleUrl . '"' . $attributes . '>');
            $article->set_var('end_storylink_anchortag', '</a>');
            $article->set_var('story_title_link',
                COM_createLink(
                    $story->DisplayElements('title'),
                    $articleUrl,
                    $attr_array
                )
            );
        } else {
            $article->set_var('story_title_link', $story->DisplayElements('title'));
        }

        $related_topics = '';

        if ($index == 'n') {
            if ($_CONF['related_topics'] > 0) {
                $related_topics = TOPIC_relatedTopics('article', $story->getSid(), $_CONF['related_topics_max']);
                $article->set_var('related_topics', $related_topics);
            }
        } elseif ($index != 'p') {
            if ($_CONF['related_topics'] > 1) {
                $related_topics = TOPIC_relatedTopics('article', $story->getSid(), $_CONF['related_topics_max']);
                $article->set_var('related_topics', $related_topics);
            }
        }

        $page_selector = '';
        $readmore_link = '';
        $post_comment_link = '';
        $plugin_itemdisplay = '';
        $comments_with_count = '';
        $trackbacks_with_count = '';

        if (($index == 'n') || ($index == 'p')) {
            $show_comments = true;

            if (empty($bodytext)) {
                $article->set_var('story_introtext', $introtext);
                $article->set_var('story_text_no_br', $introtext);
            } else {
                if (($_CONF['allow_page_breaks'] == 1) && ($index == 'n') && $story->DisplayElements('numpages') > 1) {
                    $article_array = explode('[page_break]', $bodytext);
                    $page_break_count = count($article_array);

                    if ($articlePage > 1) {
                        $introtext = '';
                    }
                    if (count($article_array) > 1) {
                        $bodytext = $article_array[$articlePage - 1];
                    }

                    $page_selector = COM_printPageNavigation(
                        $articleUrl, $articlePage, $page_break_count,
                        'page=', $_CONF['url_rewrite'], $LANG01[118]);
                    $article->set_var('page_selector', $page_selector);

                    if ((($_CONF['page_break_comments'] == 'last') && ($articlePage < count($article_array))) ||
                        (($_CONF['page_break_comments'] == 'first') && ($articlePage != 1))) {
                        $show_comments = false;
                    }
                }

                $article->set_var('story_introtext', $introtext
                    . '<br' . XHTML . '><br' . XHTML . '>' . $bodytext);
                $article->set_var('story_text_no_br', $introtext . ' ' . $bodytext);
            }
            $article->set_var('story_introtext_only', $introtext);
            $article->set_var('story_bodytext_only', $bodytext);

            // Pass Page and Comment Display info to template in case it wants to display anything else with comments
            $article->set_var('page_number', $articlePage);
            $article->set_var('page_total', $story->DisplayElements('numpages'));
            $article->set_var('comments_on_page', $show_comments);

            if (($_CONF['trackback_enabled'] || $_CONF['pingback_enabled']) &&
                SEC_hasRights('story.ping')
            ) {
                $url = $_CONF['site_admin_url']
                    . '/trackback.php?mode=sendall&amp;id=' . $story->getSid();
                $article->set_var('send_trackback_link',
                    COM_createLink($LANG_TRB['send_trackback'], $url)
                );
				
				$linkIcon = rtrim($_CONF['path_layout'], '/')  . '/images/sendping.' . $_IMAGE_TYPE;
				$sizeAttributes = COM_getImgSizeAttributes($linkIcon);					
                $pingico = '<img ' . $sizeAttributes . 'src="' . $_CONF['layout_url'] . '/images/sendping.'
                    . $_IMAGE_TYPE . '" alt="' . $LANG_TRB['send_trackback']
                    . '" title="' . $LANG_TRB['send_trackback'] . '"' . XHTML . '>';
                $article->set_var('send_trackback_icon',
                    COM_createLink($pingico, $url)
                );
                $article->set_var('send_trackback_url', $url);
                $article->set_var('lang_send_trackback_text',
                    $LANG_TRB['send_trackback']);
            }
            $article->set_var('story_display',
                ($index == 'p') ? 'preview' : 'article');
            $article->set_var('story_counter', 0);
        } else {
            $article->set_var('story_introtext', $introtext);
            $article->set_var('story_text_no_br', $introtext);
            $article->set_var('story_introtext_only', $introtext);

            if ($readmore) {
                $article->set_var('lang_readmore', $LANG01[2]);
                $article->set_var('lang_readmore_words', $LANG01[62]);
                $article->set_var('readmore_words', $numwords);

                $readmore_link = COM_createLink(
                        $LANG01[2],
                        $articleUrl,
                        array('class' => 'story-read-more-link')
                    ) . ' (' . $numwords . ' ' . $LANG01[62] . ') ';
                $article->set_var('readmore_link', $readmore_link);
                $article->set_var('start_readmore_anchortag', '<a href="'
                    . $articleUrl . '" class="story-read-more-link">');
                $article->set_var('end_readmore_anchortag', '</a>');
                $article->set_var('read_more_class', 'class="story-read-more-link"');
            }

            if (($story->DisplayElements('commentcode') >= 0) && ($show_comments)) {
                if ($_CONF['allow_page_breaks'] == 1 && $_CONF['page_break_comments'] == 'last' && $story->DisplayElements('numpages') > 1) {
                    $articlePageNumURLPart = "&amp;mode=" . $story->DisplayElements('numpages');
                } else {
                    $articlePageNumURLPart = "";
                }

                $commentsUrl = COM_buildUrl($_CONF['site_url']
                        . '/article.php?story=' . $story->getSid()) . $articlePageNumURLPart . '#comments';
                $article->set_var('comments_url', $commentsUrl);
                $article->set_var('comments_text',
                    COM_numberFormat($story->DisplayElements('comments')) . ' ' . $LANG01[3]);
                $article->set_var('comments_count',
                    COM_numberFormat($story->DisplayElements('comments')));
                $article->set_var('lang_comments', $LANG01[3]);

                $numComments = (int) $story->DisplayElements('comments');
                if ($numComments > 1) {
                    $comments_with_count = sprintf($LANG01[121], COM_numberFormat($numComments));
                } else {
                    $comments_with_count = sprintf($LANG01[143], COM_numberFormat($numComments));
                }

                if ($_CONF['comment_on_same_page'] == true) {
                    $postCommentUrl = $_CONF['site_url'] . '/article.php?story='
                        . $story->getSid() . $articlePageNumURLPart . '#commenteditform';
                } else {
                    $postCommentUrl = $_CONF['site_url'] . '/comment.php?sid='
                        . $story->getSid() . '&amp;pid=0&amp;type=article';
                    if ($_CONF['show_comments_at_replying'] == true) {
                        $postCommentUrl .= '#commenteditform';
                    }
                }

                if ($story->DisplayElements('comments') > 0) {
                    $result = DB_query("SELECT UNIX_TIMESTAMP(date) AS day,username,fullname,{$_TABLES['comments']}.uid as cuid FROM {$_TABLES['comments']},{$_TABLES['users']} WHERE {$_TABLES['users']}.uid = {$_TABLES['comments']}.uid AND sid = '" . $story->getSid() . "' ORDER BY date DESC LIMIT 1");
                    $C = DB_fetchArray($result);

                    $recent_comment_info = $LANG01[27] . ': '
                        . COM_strftime($_CONF['daytime'], $C['day']) . ' '
                        . $LANG01[104] . ' ' . COM_getDisplayName($C['cuid'],
                            $C['username'], $C['fullname']);
                    $article->set_var('recent_comment_info', $recent_comment_info);

                    $attr = array('title' => htmlspecialchars($recent_comment_info));
                    $comments_with_count = COM_createLink($comments_with_count, $commentsUrl, $attr);
                    $article->set_var('comments_with_count', $comments_with_count);

                    $recent_comment_anchortag = COM_createLink($comments_with_count, $postCommentUrl, $attr);

                } else {
                    $article->set_var('comments_with_count', $comments_with_count);

                    $recent_comment_anchortag = COM_createLink($LANG01[60], $postCommentUrl);
                }

                if ($story->DisplayElements('commentcode') == 0) {
                    $post_comment_link = COM_createLink($LANG01[60], $postCommentUrl,
                        array('rel' => 'nofollow'));
                    $article->set_var('post_comment_link', $post_comment_link);
                    $article->set_var('lang_post_comment', $LANG01[60]);

                    // Not really used anymore but left in for old themes
                    $article->set_var('start_post_comment_anchortag',
                        '<a href="' . $postCommentUrl
                        . '" rel="nofollow">');
                    $article->set_var('end_post_comment_anchortag', '</a>');
                }
            }

            if (($_CONF['trackback_enabled'] || $_CONF['pingback_enabled']) &&
                ($story->DisplayElements('trackbackcode') >= 0) && ($show_comments)
            ) {
                $num_trackbacks = COM_numberFormat($story->DisplayElements('trackbacks'));
                $trackbacksUrl = COM_buildUrl($_CONF['site_url']
                        . '/article.php?story=' . $story->getSid()) . '#trackback';
                $article->set_var('trackbacks_url', $trackbacksUrl);
                $article->set_var('trackbacks_text', $num_trackbacks . ' '
                    . $LANG_TRB['trackbacks']);
                $article->set_var('trackbacks_count', $num_trackbacks);
                $article->set_var('lang_trackbacks', $LANG_TRB['trackbacks']);

                if (SEC_hasRights('story.ping')) {
                    $pingurl = $_CONF['site_admin_url']
                        . '/trackback.php?mode=sendall&amp;id=' . $story->getSid();
						
					$linkIcon = rtrim($_CONF['path_layout'], '/')  . '/images/sendping.' . $_IMAGE_TYPE;
					$sizeAttributes = COM_getImgSizeAttributes($linkIcon);					
					$pingico = '<img ' . $sizeAttributes . 'src="' . $_CONF['layout_url'] . '/images/sendping.'
                        . $_IMAGE_TYPE . '" alt="' . $LANG_TRB['send_trackback']
                        . '" title="' . $LANG_TRB['send_trackback'] . '"' . XHTML . '>';
                    $article->set_var('send_trackback_icon',
                        COM_createLink($pingico, $pingurl)
                    );
                }

                $trackbacks_with_count = sprintf($LANG01[122], $num_trackbacks);
                if ($story->DisplayElements('trackbacks') > 0) {
                    $trackbacks_with_count = COM_createLink(
                        $trackbacks_with_count, $trackbacksUrl);
                }
                $article->set_var('trackbacks_with_count', $trackbacks_with_count);
            }

            if (($_CONF['hideemailicon'] == 1) ||
                (COM_isAnonUser() &&
                    (($_CONF['loginrequired'] == 1) ||
                        ($_CONF['emailstoryloginrequired'] == 1)))
            ) {
                $article->set_var('email_icon', '');
            } else {
                $emailUrl = $_CONF['site_url'] . '/profiles.php?sid=' . $story->getSid()
                    . '&amp;what=emailstory';
					
				$linkIcon = rtrim($_CONF['path_layout'], '/')  . '/images/mail.' . $_IMAGE_TYPE;
				$sizeAttributes = COM_getImgSizeAttributes($linkIcon);					
                $emailicon = '<img ' . $sizeAttributes . 'src="' . $_CONF['layout_url'] . '/images/mail.'
                    . $_IMAGE_TYPE . '" alt="' . $LANG01[64] . '" title="'
                    . $LANG11[2] . '"' . XHTML . '>';
                $article->set_var('email_icon', COM_createLink($emailicon, $emailUrl));
                $article->set_var('email_story_url', $emailUrl);
                $article->set_var('lang_email_story', $LANG11[2]);
                $article->set_var('lang_email_story_alt', $LANG01[64]);
            }
            $printUrl = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                . $story->getSid() . '&amp;mode=print');
            if ($_CONF['hideprintericon'] == 1) {
                $article->set_var('print_icon', '');
            } else {
				$linkIcon = rtrim($_CONF['path_layout'], '/')  . '/images/print.' . $_IMAGE_TYPE;
				$sizeAttributes = COM_getImgSizeAttributes($linkIcon);					
                $printicon = '<img ' . $sizeAttributes . 'src="' . $_CONF['layout_url']
                    . '/images/print.' . $_IMAGE_TYPE . '" alt="' . $LANG01[65]
                    . '" title="' . $LANG11[3] . '"' . XHTML . '>';
                $article->set_var('print_icon',
                    COM_createLink($printicon, $printUrl, array('rel' => 'nofollow'))
                );
                $article->set_var('print_story_url', $printUrl);
                $article->set_var('lang_print_story', $LANG11[3]);
                $article->set_var('lang_print_story_alt', $LANG01[65]);
            }
            $article->set_var('story_display', 'index');

            $storyCounter++;
            $article->set_var('story_counter', $storyCounter);
        }

        $article->set_var('recent_comment_anchortag', $recent_comment_anchortag);

        if (($index != 'p') && SEC_hasRights('story.edit') &&
            ($story->checkAccess() == 3) &&
            (TOPIC_hasMultiTopicAccess('article', $story->DisplayElements('sid')) == 3)
        ) {
            $editUrl = $_CONF['site_admin_url'] . '/article.php?mode=edit&amp;sid='
                . $story->getSid();
				
			$linkIcon = rtrim($_CONF['path_layout'], '/')  . '/images/edit.' . $_IMAGE_TYPE;
			$sizeAttributes = COM_getImgSizeAttributes($linkIcon);					
            $editiconhtml = '<img ' . $sizeAttributes . 'src="' . $_CONF['layout_url']
                . '/images/edit.' . $_IMAGE_TYPE . '" alt="' . $LANG01[4]
                . '" title="' . $LANG01[4] . '"' . XHTML . '>';
            $article->set_var('edit_link', COM_createLink($LANG01[4], $editUrl));
            $article->set_var('edit_url', $editUrl);
            $article->set_var('lang_edit_text', $LANG01[4]);
            $article->set_var(
                'edit_icon',
                COM_createLink(
                    $editiconhtml,
                    $editUrl,
                    array(
                        'class' => 'editlink',
                        'rel'   => 'nofollow',
                    )
                )
            );
            $article->set_var('edit_image', $editiconhtml);
        }

        $navi_list = true;
        $feedback_list = true;
        if ($index == 'p') {
            $navi_list = false;
            $feedback_list = false;
        } else {
            $navi_list =
                ($page_selector !== ''
                    || $readmore_link !== ''
                    || $post_comment_link !== '');
            $feedback_list =
                ($plugin_itemdisplay !== ''
                    || $comments_with_count !== ''
                    || $trackbacks_with_count !== '');
        }
        $story_footer = ($navi_list || $feedback_list || $related_topics !== '');
        $article->set_var('navi_list', $navi_list);
        $article->set_var('feedback_list', $feedback_list);
        $article->set_var('story_footer', $story_footer);

        // Set type of view in template so can change display if needed
        // Index variable:  n = Full display of article. p = 'Preview' mode. Else y = introtext only.
        $article->set_var('display_type', $index);

        if ($story->DisplayElements('featured') == 1) {
            $article->set_var('lang_todays_featured_article', $LANG05[4]);
            $article->parse('story_bodyhtml', 'featuredbodytext', true);
            PLG_templateSetVars('featuredstorytext', $article);
        } elseif ($story->DisplayElements('statuscode') == STORY_ARCHIVE_ON_EXPIRE &&
            $story->DisplayElements('expire') <= time()
        ) {
            $article->parse('story_bodyhtml', 'archivestorybodytext', true);
            PLG_templateSetVars('archivestorytext', $article);
        } else {
            $article->parse('story_bodyhtml', 'bodytext', true);
            PLG_templateSetVars('storytext', $article);
        }


        if ($index === 'n') {
            // Related Articles block (You might also like)
            if ($_CONF['meta_tags'] > 0) {
                $relatedArticles = $story->getRelatedArticlesByKeywords(
                    $story->getSid(),
                    $story->DisplayElements('meta_keywords'));
                if (!empty($relatedArticles)) {
                    $relatedArticles = COM_startBlock($LANG24[92], '',
                        COM_getBlockTemplate('articles_related_block', 'header'))
                        . $relatedArticles
                        . COM_endBlock(COM_getBlockTemplate('articles_related_block', 'footer'));
                }

                $article->set_var('related_articles_by_keyword', $relatedArticles);
            }

            // What's Related Block
            $related = STORY_whatsRelated($story->displayElements('related'),
                $story->displayElements('uid'),
                $story->getSid());
            if (!empty($related)) {
                $related = COM_startBlock($LANG11[1], '',
                    COM_getBlockTemplate('whats_related_block', 'header'))
                    . $related
                    . COM_endBlock(COM_getBlockTemplate('whats_related_block',
                        'footer'));
            }
            $article->set_var('whats_related', $related);

            // Article Options Block
            if (count($story_options) > 0) {
                $optionsblock = COM_startBlock($LANG11[4], '',
                    COM_getBlockTemplate('story_options_block', 'header'))
                    . COM_makeList($story_options, PLG_getThemeItem('article-css-list-options', 'article'))
                    . COM_endBlock(COM_getBlockTemplate('story_options_block',
                        'footer'));
            } else {
                $optionsblock = '';
            }
            $article->set_var('story_options', $optionsblock);
            $article->set_var('whats_related_story_options', $related . $optionsblock);

            // Trackback
            if ($_CONF['trackback_enabled'] && ($story->displayElements('trackbackcode') >= 0) &&
                $show_comments
            ) {
                if (SEC_hasRights('story.ping')) {
                    if (($story->displayElements('draft_flag') == 0) &&
                        ($story->displayElements('day') < time())
                    ) {
                        $url = $_CONF['site_admin_url']
                            . '/trackback.php?mode=sendall&amp;id=' . $story->getSid();
                        $article->set_var('send_trackback_link',
                            COM_createLink($LANG_TRB['send_trackback'], $url));
                        $article->set_var('send_trackback_url', $url);
                        $article->set_var('lang_send_trackback_text',
                            $LANG_TRB['send_trackback']);
                    }
                }

                $permalink = COM_buildUrl($_CONF['site_url']
                    . '/article.php?story=' . $story->getSid());
                $article->set_var('trackback',
                    TRB_renderTrackbackComments($story->getSID(), 'article',
                        $story->displayElements('title'), $permalink));
            } else {
                $article->set_var('trackback', '');
            }
        }

        PLG_templateSetVars($article_filevar, $article);
        // Used by Custom Block Locations (needs to be done before cache)
        if ($index == 'n') { // p = preview, n = full article, y = intro only (displayed in topics)
            PLG_templateSetVars($article_filevar . '_full', $article);
        } elseif ($_CONF['blocks_article_topic_list_repeat_after'] > 0) {
            if ($index == 'y' && ($articleCountOnPage %$_CONF['blocks_article_topic_list_repeat_after'] == 0)) {
                PLG_templateSetVars($article_filevar . '_topic_list', $article);
            }
        }

        // Don't cache previews, article display from a search query or if no cache time
        if ($index != 'p' && empty($query) && ($cache_time > 0 || $cache_time == -1)) {
            $article->create_instance($cacheInstance, $article_filevar);
            // CACHE_create_instance($cacheInstance, $article);
        }

        // Figure out structured data if needed. Always displayed on article page if set. Depends if in topics
        if (!empty($story->DisplayElements('structured_data_type')) && ($index == 'n' || ($index == 'y' && $_CONF['structured_data_article_topic'] == 1))) {

            $attributes = array();
            $attributes['multi_language'] = true;
            // Only cache if not search and full article view (=n)
            if ($index == 'n' && empty($query) && ($cache_time > 0 || $cache_time == -1)) {
                $attributes['cache'] = true;
            }

            $properties['headline'] = $story->displayElements('title');
            $properties['url'] = $articleUrl;
            $properties['datePublished'] = $story->displayElements('date');
            // Don't include modified if empty or date is less than published
            if (($story->displayElements('unixmodified') != false) && ($story->displayElements('unixmodified') > $story->displayElements('unixdate'))) {
                $properties['dateModified'] = $story->displayElements('modified');
            }
            $properties['description'] = $story->DisplayElements('meta_description');
            $properties['keywords'] = $story->DisplayElements('meta_keywords');
            $properties['commentCount'] = CMT_commentCount($story->getSid(), 'article');
            $properties['author']['name'] = $story->DisplayElements('username');
            if (!USER_isBanned($story->DisplayElements('uid'))) {
                $properties['author']['url'] = $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid='
                    . $story->DisplayElements('uid');
            }
            $_STRUCT_DATA->add_type('article', $story->getSid(), $story->displayElements('structured_data_type'), $properties, $attributes);
            // Include any images attached to the article (taken in part from renderImageTags function in article class)
            // If none are attached then take a look at the acutal content in case they are embedded that way
            // It is important we add images since they are required by Google for article structured data snippets
            $result = DB_query("SELECT ai_filename,ai_img_num FROM {$_TABLES['article_images']} WHERE ai_sid = '{$story->getSid()}' ORDER BY ai_img_num");
            $numRows = DB_numRows($result);
            if ($numRows > 0) {
                $stdImageLoc = true;
                if (!strstr($_CONF['path_images'], $_CONF['path_html'])) {
                    $stdImageLoc = false;
                }

                for ($i = 1; $i <= $numRows; $i++) {
                    $A = DB_fetchArray($result);

                    $imgPath = '';
                    if ($stdImageLoc) {
                        $imgPath = substr($_CONF['path_images'], strlen($_CONF['path_html']));
                        $imgSrc = $_CONF['site_url'] . '/' . $imgPath . 'articles/' . $A['ai_filename'];
                    } else {
                        $imgSrc = $_CONF['site_url'] . '/getimage.php?mode=articles&amp;image=' . $A['ai_filename'];
                    }

                    // Only include images that exist
                    $sizeAttributes = COM_getImgSizeAttributes($_CONF['path_images'] . 'articles/' . $A['ai_filename'], false);
                    if (is_array($sizeAttributes)) {
                        $_STRUCT_DATA->set_image_item('article', $story->getSid(), ($imgSrc . $A['ai_filename']), $sizeAttributes['width'], $sizeAttributes['height']);
                    }
                }
            } else {
                // Before searching content for images, check if structured data already exist for image incase autotags used to insert images and/or structured data
                // Structured Data Images are stored as arrays so just check for array, if found then skip checking content for images
                if (!is_array($_STRUCT_DATA->get_param_item('article', $story->getSid(), 'image'))) {
                    // Images are required by Google for article structured data rich snippets.
                    // lets look in the actual content of the article for an image and add it that way as long as it is locally stored and meets the min requirements
                    preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', ($introtext .  $bodytext), $result);
                    $srcs = array_pop($result);
                    foreach ($srcs as $src) {
                    /* ALternate way to get image src but believe slower
                    $articleDoc = new DOMDocument();
                    libxml_use_internal_errors(true); // Incase invalid HTML is loaded
                    $articleDoc->loadHTML(($introtext .  $bodytext));
                    $images = $articleDoc->getElementsByTagName('img');
                    foreach ($images as $image) {
                        $src = $image->getAttribute('src');
                    */
                        if (substr($src, 0, 1) == "/" || substr($src, 0, strlen($_CONF['site_url'])) == $_CONF['site_url']) {
                            // COM_getImgSizeAttributes checks if file exists
                            $sizeAttributes = COM_getImgSizeAttributes($_CONF['path_html'] . substr($src, 1), false);
                            // Make sure image meets minimum sizes as we don't want to grab something really small
                            // Using old Geeklog image width and height defaults
                            if (is_array($sizeAttributes)
                                && $sizeAttributes['width'] >= 160 && $sizeAttributes['height'] >= 160) {
                                //&& $sizeAttributes['width'] <= $_CONF['max_image_width'] && $sizeAttributes['height'] <= $_CONF['max_image_height']) {
                                $_STRUCT_DATA->set_image_item('article', $story->getSid(), ($_CONF['site_url'] . $src), $sizeAttributes['width'], $sizeAttributes['height']);

                                break;
                            }
                        }
                    }
                }
            }
        }
    } else {
        PLG_templateSetVars($article_filevar, $article);
        // Used by Custom Block Locations
        if ($index == 'n') { // p = preview, n = full article, y = intro only (displayed in topics)
            PLG_templateSetVars($article_filevar . '_full', $article);
        } elseif ($_CONF['blocks_article_topic_list_repeat_after'] > 0) {
            if ($index == 'y' && ($articleCountOnPage %$_CONF['blocks_article_topic_list_repeat_after'] == 0)) {
                PLG_templateSetVars($article_filevar . '_topic_list', $article);
            }
        }

        if (!$_CONF['cache_templates']) {
            // This is only triggered if cache_templates is disabled but caching is enabled for the article itself

            // Template var was original set with set_file (as it is a template file)
            // Since the article itself is cached but not the rest of the templates we need to reset the templateCode variable in the template class
            // Views use the templateCode variable as well so we can just update the template code variable with set_view as we have already retrieved the cache version of the article
            $article->set_view($article_filevar, $retval);
        }
    }

    $article->parse('finalstory', $article_filevar);

    return $article->finish($article->get_var('finalstory'));
}

/**
 * Extract links from an HTML-formatted text.
 * Collects all the links in a story and returns them in an array.
 *
 * @param    string $fulltext  the text to search for links
 * @param    int    $maxlength max. length of text in a link (can be 0)
 * @return   array   an array of strings of form <a href="...">link</a>
 */
function STORY_extractLinks($fulltext, $maxlength = 26)
{
    $rel = array();

    /* Only match anchor tags that contain 'href="<something>"'
     */
    preg_match_all("/<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)<\/a>/i", $fulltext, $matches);
    for ($i = 0; $i < count($matches[0]); $i++) {
        $matches[2][$i] = GLText::stripTags($matches[2][$i]);
        if (!MBYTE_strlen(trim($matches[2][$i]))) {
            $matches[2][$i] = GLText::stripTags($matches[1][$i]);
        }

        // if link is too long, shorten it and add ... at the end
        if (($maxlength > 0) && (MBYTE_strlen($matches[2][$i]) > $maxlength)) {
            $matches[2][$i] = MBYTE_substr($matches[2][$i], 0, $maxlength - 3) . '...';
        }

        $rel[] = '<a href="' . $matches[1][$i] . '">'
            . str_replace(array("\015", "\012"), '', $matches[2][$i])
            . '</a>';
    }

    return ($rel);
}

/**
 * Create "What's Related" links for a story
 * Creates an HTML-formatted list of links to be used for the What's Related
 * block next to a story (in article view).
 *
 * @param        string $related contents of gl_stories 'related' field
 * @param        int    $uid     user id of the author
 * @param        int    $sid     story id
 * @return       string      HTML-formatted list of links
 */

function STORY_whatsRelated($related, $uid, $sid)
{
    global $_CONF, $_TABLES, $LANG24;

    // Is it enabled?
    // Disabled' => 0, 'Enabled' => 1, 'Enabled (No Links)' => 2, 'Enabled (No Outbound Links)' => 3
    if ($_CONF['whats_related']) {
        // get the links from the story text
        if ($_CONF['whats_related'] != 2) {
            if (!empty ($related)) {
                $rel = explode("\n", $related);
            } else {
                $rel = array();
            }

            // Used to hunt out duplicates. Stores urls that have already passed filters
            $urls = array();

            foreach ($rel as $key => &$value) {
                if (preg_match("/<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)<\/a>/i",
                        $value, $matches) === 1
                ) {

                    // Go through array and remove links with no link text except link. Since a max of only 23 characters of link text showen then compare only this
                    if (substr($matches[1], 0, 23) != substr($matches[2], 0, 23)) {
                        // Check if outbound links (if needed)
                        $passd_check = false;
                        if ($_CONF['whats_related'] == 3) { // no outbound links
                            if ($_CONF['site_url'] == substr($matches[1], 0, strlen($_CONF['site_url']))) {
                                $passd_check = true;
                            }
                        } else {
                            $passd_check = true;
                        }

                        if ($passd_check) {
                            // Go through array and remove any duplicates of this link
                            if (in_array($matches[1], $urls)) {
                                // remove it from the array
                                unset($rel[$key]);
                            } else {
                                $urls[] = $matches[1];
                                // Now Check Words
                                $value = '<a href="' . $matches[1] . '">'
                                    . COM_checkWords($matches[2], 'story') . '</a>';
                            }
                        } else {
                            // remove it from the array
                            unset($rel[$key]);
                        }
                    } else {
                        // remove it from the array
                        unset($rel[$key]);
                    }
                } else {
                    $value = COM_checkWords($value, 'story');
                }
            }
            unset($value);

        }

        $topics = array();
        if (!COM_isAnonUser() || (($_CONF['loginrequired'] == 0) &&
                ($_CONF['searchloginrequired'] == 0))
        ) {
            // add a link to "search by author"
            if ($_CONF['contributedbyline'] == 1) {
                $author = $LANG24[37] . ' ' . COM_getDisplayName($uid);
                if ($_CONF['whats_related_trim'] > 0 && (MBYTE_strlen($author) > $_CONF['whats_related_trim'])) {
                    $author = substr($author, 0, $_CONF['whats_related_trim'] - 3) . '...';
                }
                $topics[] = "<a href=\"{$_CONF['site_url']}/search.php?mode=search&amp;type=article&amp;author=$uid\">$author</a>";
            }

            // Retrieve topics
            $tids = TOPIC_getTopicIdsForObject('article', $sid, 0);
            foreach ($tids as $tid) {
                // add a link to "search by topic"
                $topic = $LANG24[38] . ' ' . stripslashes(DB_getItem($_TABLES['topics'], 'topic', "tid = '$tid'"));
                // trim topics if needed
                if ($_CONF['whats_related_trim'] > 0 && (MBYTE_strlen($topic) > $_CONF['whats_related_trim'])) {
                    $topic = substr($topic, 0, $_CONF['whats_related_trim'] - 3) . '...';
                }
                $topics[] = '<a href="' . $_CONF['site_url']
                    . '/search.php?mode=search&amp;type=article&amp;topic=' . $tid
                    . '">' . $topic . '</a>';
            }
        }

        // If line limit then split between related links and topics
        if ($_CONF['whats_related_max'] > 0) {
            if ($_CONF['whats_related_max'] < 3) {
                $rel = array(); // Reset related links so at least user search and default topic search is displayed
                $topics = array_slice($topics, 0, 2);
            } else {
                $rel_max_num_items = intval($_CONF['whats_related_max'] / 2);
                $topic_max_num_items = $rel_max_num_items;
                if (($rel_max_num_items + $topic_max_num_items) != $_CONF['whats_related_max']) {
                    $topic_max_num_items = $topic_max_num_items + 1;
                }
                // Now check if we have enough topics to display else give it to links
                $topic_num_items = count($topics);
                $rel_num_items = count($rel);
                $added_flag = false;
                if ($topic_num_items < $topic_max_num_items) {
                    $rel_max_num_items = $rel_max_num_items + ($topic_max_num_items - $topic_num_items);
                    $added_flag = true;
                }
                if (!$added_flag && ($rel_num_items < $rel_max_num_items)) {
                    $topic_max_num_items = $topic_max_num_items + ($rel_max_num_items - $rel_num_items);
                }
                $rel = array_slice($rel, 0, $rel_max_num_items);
                $topics = array_slice($topics, 0, $topic_max_num_items);

            }
        }
        $result = array_merge($rel, $topics);

        $related = '';
        if (count($result) > 0) {
            $related = COM_makeList($result, PLG_getThemeItem('article-css-list-related', 'core'));
        }
    } else {
        $related = '';
    }

    return $related;
}

/**
 * Delete one image from a story
 * Deletes scaled and unscaled image, but does not update the database.
 *
 * @param    string $image file name of the image (without the path)
 */
function STORY_deleteImage($image)
{
    global $_CONF;

    if (empty ($image)) {
        return;
    }

    $filename = $_CONF['path_images'] . 'articles/' . $image;
    if (!@unlink($filename)) {
        // log the problem but don't abort the script
        echo COM_errorLog('Unable to remove the following image from the article: ' . $filename);
    }

    // remove unscaled image, if it exists
    $lFilename_large = substr_replace($image, '_original.',
        strrpos($image, '.'), 1);
    $lFilename_large_complete = $_CONF['path_images'] . 'articles/'
        . $lFilename_large;
    if (file_exists($lFilename_large_complete)) {
        if (!@unlink($lFilename_large_complete)) {
            // again, log the problem but don't abort the script
            echo COM_errorLog('Unable to remove the following image from the article: ' . $lFilename_large_complete);
        }
    }
    // delete thumbnail image
    STORY_deleteThumbnail($image);
    STORY_deleteThumbnail($lFilename_large);
}

/**
 * Delete thumbnail
 *
 * @param    string $image file name of the thumbnail (without the path)
 */
function STORY_deleteThumbnail($image)
{
    global $_CONF;

    $thumb = substr_replace($image, '_64x64px.', strrpos($image, '.'), 1);
    $thumb_path = $_CONF['path_images'] . '_thumbs/articles/' . $thumb;
    if (file_exists($thumb_path)) {
        @unlink($thumb_path);
    }
}

/**
 * Delete all images from a story
 * Deletes all scaled and unscaled images from the file system and the database.
 *
 * @param    string $sid story id
 */
function STORY_deleteImages($sid)
{
    global $_TABLES;

    $result = DB_query("SELECT ai_filename FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid'");
    $nrows = DB_numRows($result);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        STORY_deleteImage($A['ai_filename']);
    }
    DB_delete($_TABLES['article_images'], 'ai_sid', $sid);
}

/**
 * Delete a story.
 * This is used to delete a story from the list of stories.
 *
 * @param  string $sid ID of the story to delete
 * @return array
 */
function STORY_deleteStory($sid)
{
    $args = array(
        'sid' => $sid,
    );

    $output = array();
    $svc_msg = array();
    PLG_invokeService('story', 'delete', $args, $output, $svc_msg);

    return $output;
}

/**
 * Delete a story and related data immediately.
 * Note: For internal use only! To delete a story, use STORY_deleteStory (see
 *       above), which will do permission checks and eventually end up here.
 *
 * @param    string $sid ID of the story to delete
 * @internal For internal use only!
 */
function STORY_doDeleteThisStoryNow($sid)
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'lib-comment.php';

	CMT_deleteComment('', $sid, 'article', false);
    
	DB_delete($_TABLES['trackback'], array('sid', 'type'),
        array($sid, 'article'));

    STORY_deleteImages($sid);
    
	DB_delete($_TABLES['stories'], 'sid', $sid);

    TOPIC_deleteTopicAssignments('article', $sid);

    LIKES_deleteActions('article', '', $sid);

    // notify plugins
    PLG_itemDeleted($sid, 'article');

    // update RSS feed
    COM_rdfUpToDateCheck('article');
    COM_rdfUpToDateCheck('comment');
    STORY_updateLastArticlePublished();
    CMT_updateCommentcodes();
}

/**
 * Updates last_article_publish variables stored in vars table.
 * Note: Used when insert/update/delete an article. last_article_publish is used to
 *       determine new articles and if feeds need to be updated.
 */
function STORY_updateLastArticlePublished()
{
    global $_TABLES;

    //Set new latest article published in feed
    $sql = "SELECT date FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() AND perm_anon > 0 ORDER BY date DESC LIMIT 1";
    $result = DB_query($sql);

    $A = DB_fetchArray($result);
    DB_query("UPDATE {$_TABLES['vars']} SET value='{$A['date']}' WHERE name='last_article_publish'");

}

/*
 * Implement *some* of the Plugin API functions for stories. While stories
 * aren't a plugin (and likely never will be), implementing some of the API
 * functions here will save us from doing special handling elsewhere.
 */

/**
 * Return list of articles for the Related Items block
 *
 * @param    array $tids list of topic ids
 * @param    int   $max  maximum number of items to return
 * @param    int   $trim max length of text
 * @return   array   array of links to related articles with unix timestamp as key
 */
function plugin_getrelateditems_story($tids, $max, $trim)
{
    global $_CONF, $_TABLES;

    $where_sql = '';
    $archivetid = DB_getItem($_TABLES['topics'], 'tid', "archive_flag=1");
    if (!empty($archivetid)) {
        $where_sql = " AND (ta.tid <> '$archivetid')";
    }

    // Find the newest stories the user has access too
    $sql = "SELECT sid, title, UNIX_TIMESTAMP(date) s_date
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE ta.type = 'article' AND ta.id = sid AND (ta.tid IN ('" . implode("','", $tids) . "'))
        AND (date <= NOW()) AND (draft_flag = 0)" . $where_sql . COM_getPermSQL('AND') . COM_getLangSQL('sid', 'AND') . "
        GROUP BY sid ORDER BY s_date DESC LIMIT {$max}";

    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    $newstories = array();
    if ($nrows > 0) {
        for ($x = 0; $x < $nrows; $x++) {
            $A = DB_fetchArray($result);
            $url = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                . $A['sid']);
            $title = COM_undoSpecialChars(stripslashes($A['title']));
            if ($trim > 0) {
                $titletouse = COM_truncate($title, $trim, '...');
            } else {
                $titletouse = $title;
            }
            if ($title != $titletouse) {
                $attr = array('title' => htmlspecialchars($title));
            } else {
                $attr = array();
            }
            $astory = str_replace('$', '&#36;', $titletouse);
            $astory = str_replace(' ', '&nbsp;', $astory);

            $newstories[$A['s_date']] = COM_createLink($astory, $url, $attr);
        }
    }

    return $newstories;
}

/**
 * Return new Story comments for the What's New block
 *
 * @param    string $numreturn   If 0 will return results for What's New Block.
 *                               If > 0 will return last X new comments for User Profile.
 * @param    string $uid         ID of the user to return results for. 0 = all users.
 * @return   array list of new comments (dups, type, title, sid, lastdate) or (sid, title, cid, unixdate)
 */
function plugin_getwhatsnewcomment_story($numreturn = 0, $uid = 0)
{
    global $_CONF, $_TABLES;

    $topicsql = COM_getTopicSql('AND', 0, 'ta');

    $stwhere = '';
    if (!COM_isAnonUser()) {
        $stwhere .= "((s.owner_id IS NOT NULL AND s.perm_owner IS NOT NULL) OR ";
        $stwhere .= "(s.group_id IS NOT NULL AND s.perm_group IS NOT NULL) OR ";
        $stwhere .= "(s.perm_members IS NOT NULL))";
    } else {
        $stwhere .= "(s.perm_anon IS NOT NULL)";
    }

    if ($uid > 0) {
        $stwhere .= " AND (c.uid = $uid)";
    }
    if ($numreturn == 0) {
        $sql['mysql'] = "SELECT DISTINCT COUNT(*) AS dups, c.type, s.title, s.sid, max(c.date) AS lastdate
            FROM {$_TABLES['comments']} c LEFT JOIN {$_TABLES['stories']} s ON ((s.sid = c.sid) AND type = 'article' " . COM_getPermSQL('AND', 0, 2, 's') . " AND (s.draft_flag = 0) AND (s.commentcode >= 0)" . COM_getLangSQL('sid', 'AND', 's') . ")
            , {$_TABLES['topic_assignments']} ta
            WHERE ta.type = 'article' AND ta.id = s.sid AND ta.tdefault = 1 {$topicsql} AND (c.date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newcommentsinterval']} SECOND))) AND ((({$stwhere})))
            GROUP BY c.sid, c.type, s.title, s.title, s.sid
            ORDER BY 5 DESC LIMIT 15";

        $sql['pgsql'] = "SELECT DISTINCT COUNT(*) AS dups, c.type, s.title, s.sid, max(c.date) AS lastdate
            FROM {$_TABLES['comments']} c LEFT JOIN {$_TABLES['stories']} s ON ((s.sid = c.sid) AND type = 'article' " . COM_getPermSQL('AND', 0, 2, 's') . " AND (s.draft_flag = 0) AND (s.commentcode >= 0)" . COM_getLangSQL('sid', 'AND', 's') . ")
            , {$_TABLES['topic_assignments']} ta
            WHERE ta.type = 'article' AND ta.id = s.sid AND ta.tdefault = 1 {$topicsql} AND (c.date >= (NOW()+ INTERVAL '{$_CONF['newcommentsinterval']} SECOND')) AND ((({$stwhere})))
            GROUP BY c.sid,c.type, s.title, s.title, s.sid
            ORDER BY 5 DESC LIMIT 15";
    } else {
        $sql = "SELECT s.sid, c.title, cid, UNIX_TIMESTAMP(c.date) AS unixdate
            FROM {$_TABLES['comments']} c LEFT JOIN {$_TABLES['stories']} s ON ((s.sid = c.sid) AND type = 'article' " . COM_getPermSQL('AND', 0, 2, 's') . " AND (s.draft_flag = 0) AND (s.commentcode >= 0)" . COM_getLangSQL('sid', 'AND', 's') . ")
            , {$_TABLES['topic_assignments']} ta
            WHERE ta.type = 'article' AND ta.id = s.sid AND ta.tdefault = 1 {$topicsql} AND ({$stwhere}) ORDER BY unixdate DESC LIMIT $numreturn";
    }
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($x = 0; $x < $nrows; $x++) {
            $A[] = DB_fetchArray($result);
        }

        return $A;
    }
}

/**
 * Return information for a story
 * This is the story equivalent of PLG_getItemInfo. See lib-plugins.php for
 * details.
 *
 * @param    string $sid     story ID or '*'
 * @param    string $what    comma-separated list of story properties
 * @param    int    $uid     user ID or 0 = current user
 * @param    array  $options (reserved for future extensions)
 * @return   mixed               string or array of strings with the information
 */
function plugin_getiteminfo_story($sid, $what, $uid = 0, $options = array())
{
    global $_CONF, $_TABLES;

    // parse $what to see what we need to pull from the database
    $properties = explode(',', $what);
    $fields = array();
    foreach ($properties as $p) {
        switch ($p) {
            case 'date-created':
                $fields[] = 'UNIX_TIMESTAMP(date) AS c_unixdate';
                $groupby_fields[] = 'c_unixdate';
                break;

            case 'date-modified':
                $fields[] = 'UNIX_TIMESTAMP(modified) AS m_unixdate';
                $groupby_fields[] = 'm_unixdate';
                break;

            case 'description':
                $fields[] = 'introtext';
                $fields[] = 'bodytext';
                $groupby_fields[] = 'introtext';
                $groupby_fields[] = 'bodytext';
                break;

            case 'excerpt':
                $fields[] = 'introtext';
                $groupby_fields[] = 'introtext';
                break;

            case 'feed':
                $fields[] = 'ta.tid';
                $groupby_fields[] = 'ta.tid';
                break;

            case 'id':
                $fields[] = 'sid';
                $groupby_fields[] = 'sid';
                break;

            case 'title':
                $fields[] = 'title';
                $groupby_fields[] = 'title';
                break;
				
            case 'likes':
				// Likes article setting is a global variable and not an item per item setting
                $fields[] = $_CONF['likes_articles'] . ' AS likes';
                $groupby_fields[] = 'likes';
                break;					

            case 'url':
                // needed for $sid == '*', but also in case we're only requesting
                // the URL (so that $fields isn't empty)
                $fields[] = 'sid';
                $groupby_fields[] = 'sid';
                break;

            default:
                // nothing to do
                break;
        }
    }

    $fields = array_unique($fields);

    if (count($fields) === 0) {
        return [];
    }

    // prepare SQL request
    $where = ' WHERE 1=1';
    $groupBySQL = '';
    $filter_flag = false;
    if ($sid === '*') {

    } else {
        $where .= " AND (sid = '" . DB_escapeString($sid) . "')";
    }

	// *********************************
	// Moved out of $sid === '*' if statement above since XML Sitemap needs to filter even when it knows an ID
	// Assuming this doesn't mess anything else up??? See issue #1050
	
	// Check options to see if filters enabled
	if (isset($options['filter']['date-created'])) {
		$filter_flag = true;
		// $where .= " AND (date >= '" . date('c', $options['filter']['date-created']) . "')";
		$where .= " AND (date >= '" . date('Y-m-d H:i:s', $options['filter']['date-created']) . "')";
	}

	if (isset($options['filter']['topic-ids']) && !empty($options['filter']['topic-ids'])) {
		$filter_flag = true;
		$where .= " AND (ta.tid IN (" . $options['filter']['topic-ids'] . "))";
	}
	// *********************************************

    if (!SEC_hasRights('story.edit', 'AND', $uid)) {
        $where .= ' AND (draft_flag = 0) AND (date <= NOW())';
    }

    if ($uid > 0) {
        if ($filter_flag) {
            // Need to group by as duplicates may be returned since we need to return articles that may belong in 1 or more topics (and the default may not be one of them)
            $permSql = COM_getPermSql('AND', $uid) . " AND ta.type = 'article' AND ta.id = sid " . COM_getTopicSql('AND', $uid, 'ta');
            $groupBySQL = " GROUP BY " . implode(',', $groupby_fields);
        } else {
            // Without a filter we can select just a the stories from a default topic since all stories are required a default topic.
            // So no duplicates returned
            $permSql = COM_getPermSql('AND', $uid) . " AND ta.type = 'article' AND ta.id = sid AND ta.tdefault = 1 " . COM_getTopicSql('AND', $uid, 'ta');
        }
    } else {
        $permSql = COM_getPermSql('AND') . " AND ta.type = 'article' AND ta.id = sid AND ta.tdefault = 1 " . COM_getTopicSql('AND', 0, 'ta');
    }

    $sql = "SELECT " . implode(',', $fields)
        . " FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta" . $where . $permSql . $groupBySQL;
    if ($sid != '*') {
        $sql .= ' LIMIT 1';
    }

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    $retval = array();
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);
        $props = [];

        foreach ($properties as $p) {
            switch ($p) {
                case 'date-created':
                    $props['date-created'] = $A['c_unixdate'];
                    break;

                case 'date-modified':
                    $props['date-modified'] = $A['m_unixdate'];
                    break;

                case 'description':
                    $props['description'] = trim(PLG_replaceTags(stripslashes($A['introtext']) . ' ' . stripslashes($A['bodytext']), '', false , 'article', $sid));
                    break;

                case 'excerpt':
                    $excerpt = stripslashes($A['introtext']);
                    if (!empty($A['bodytext'])) {
                        $excerpt .= "\n\n" . stripslashes($A['bodytext']);
                    }
                    $props['excerpt'] = trim(PLG_replaceTags($excerpt, '', false, 'article', $sid));
                    break;

                case 'feed':
                    $feedfile = DB_getItem($_TABLES['syndication'], 'filename',
                        "topic = '::all'");
                    if (empty($feedfile)) {
                        $feedfile = DB_getItem($_TABLES['syndication'], 'filename',
                            "topic = '::frontpage'");
                    }
                    if (empty($feedfile)) {
                        $feedfile = DB_getItem($_TABLES['syndication'], 'filename',
                            "topic = '{$A['tid']}'");
                    }
                    if (empty($feedfile)) {
                        $props['feed'] = '';
                    } else {
                        $props['feed'] = SYND_getFeedUrl($feedfile);
                    }
                    break;

                case 'id':
                    $props['id'] = $A['sid'];
                    break;

                case 'title':
                    $props['title'] = stripslashes($A['title']);
                    break;
					
                case 'likes':
                    $props['likes'] = $A['likes'];
                    break;					

                case 'url':
                    if (empty($A['sid'])) {
                        $props['url'] = COM_buildUrl($_CONF['site_url']
                            . '/article.php?story=' . $sid);
                    } else {
                        $props['url'] = COM_buildUrl($_CONF['site_url']
                            . '/article.php?story=' . $A['sid']);
                    }
                    break;

                default:
                    // return empty string for unknown properties
                    $props[$p] = '';
                    break;
            }
        }

        $mapped = array();
        foreach ($props as $key => $value) {
            if ($sid == '*') {
                if ($value != '') {
                    $mapped[$key] = $value;
                }
            } else {
                $mapped[] = $value;
            }
        }

        if ($sid == '*') {
            $retval[] = $mapped;
        } else {
            $retval = $mapped;
            break;
        }
    }

    if (($sid != '*') && (count($retval) == 1)) {
        $retval = $retval[0];
    }

    return $retval;
}

/**
 * Return true since this component supports webservices
 *
 * @return   boolean     True, if webservices are supported
 */
function plugin_wsEnabled_story()
{
    return true;
}

/**
 * Returns list of moderation values
 * The array returned contains (in order): the row 'id' label, main table,
 * moderation fields (comma separated), and submission table
 *
 * @return   array       Returns array of useful moderation values
 */
function plugin_moderationvalues_story()
{
    global $_TABLES;

    return array(
        'sid',
        $_TABLES['stories'],
        'sid,uid,tid,title,introtext,date,postmode',
        $_TABLES['storysubmission'],
    );
}

/**
 * Performs story exclusive work for items deleted by moderation
 * While moderation.php handles the actual removal from the submission
 * table, within this function we handle all other deletion related tasks
 *
 * @param    string $sid Identifying string, i.e. the story id
 * @return   string          Any wanted HTML output
 */
function plugin_moderationdelete_story($sid)
{
    global $_TABLES;

    TOPIC_deleteTopicAssignments('article', $sid);
    DB_delete($_TABLES['storysubmission'], 'sid', $sid);

    return '';
}

/**
 * Checks that the current user has the rights to moderate stories.
 * Returns true if this is the case, false otherwise
 *
 * @return   boolean     Returns true if moderator
 */
function plugin_ismoderator_story()
{
    return SEC_hasRights('story.moderate');
}

/**
 * Returns SQL & Language texts to moderation.php
 *
 * @return   mixed   Plugin object or void if not allowed
 */
function plugin_itemlist_story()
{
    global $_TABLES, $LANG29;

    if (plugin_ismoderator_story()) {
        $plugin = new Plugin();
        $plugin->submissionlabel = $LANG29[35];
        $plugin->submissionhelpfile = 'ccstorysubmission.html';
        $plugin->getsubmissionssql = "SELECT sid AS id,title,uid,date,ta.tid FROM {$_TABLES['storysubmission']}, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'article' AND ta.id = sid AND ta.tdefault = 1 " . COM_getTopicSQL('AND') . " ORDER BY date DESC";
        $plugin->addSubmissionHeading($LANG29[10]);
        $plugin->addSubmissionHeading($LANG29[37]);
        $plugin->addSubmissionHeading($LANG29[14]);
        $plugin->addSubmissionHeading($LANG29[15]);

        return $plugin;
    }
}

/*
 * Another pseudo plugin API for draft stories
 */

/**
 * Returns list of moderation values
 * The array returned contains (in order): the row 'id' label, main table,
 * moderation fields (comma separated), and submission table
 *
 * @return   array       Returns array of useful moderation values
 */
function plugin_moderationvalues_story_draft()
{
    global $_TABLES;

    return array(
        'sid',
        $_TABLES['stories'],
        'sid,uid,tid,title,introtext,date,postmode',
        $_TABLES['stories'],
    );
}

/**
 * Performs draft story exclusive work for items deleted by moderation
 * While moderation.php handles the actual removal from the submission
 * table, within this function we handle all other deletion related tasks
 *
 * @param    string $sid Identifying string, i.e. the story id
 * @return   string          Any wanted HTML output
 */
function plugin_moderationdelete_story_draft($sid)
{
    STORY_deleteStory($sid);

    return '';
}

/**
 * Returns SQL & Language texts to moderation.php
 *
 * @return   mixed   Plugin object or void if not allowed
 */
function plugin_itemlist_story_draft()
{
    global $_TABLES, $LANG24, $LANG29;

    if (SEC_hasRights('story.edit')) {
        $plugin = new Plugin();
        $plugin->submissionlabel = $LANG29[35] . ' (' . $LANG24[34] . ')';
        $plugin->submissionhelpfile = 'ccdraftsubmission.html';
        $plugin->getsubmissionssql = "SELECT sid AS id,title,uid,date,tid FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta WHERE ta.type = 'article' AND ta.id = sid AND ta.tdefault = 1 AND draft_flag = 1 " . COM_getTopicSQL('AND') . COM_getPermSQL('AND', 0, 3) . " ORDER BY date DESC";
        $plugin->addSubmissionHeading($LANG29[10]);
        $plugin->addSubmissionHeading($LANG29[37]);
        $plugin->addSubmissionHeading($LANG29[14]);
        $plugin->addSubmissionHeading($LANG29[15]);

        return $plugin;
    }
}

/**
 * "Approve" a draft story
 *
 * @param    string $sid story id
 * @return   void
 */
function plugin_moderationapprove_story_draft($sid)
{
    global $_TABLES;

    DB_change($_TABLES['stories'], 'draft_flag', 0, 'sid', $sid);

    PLG_itemSaved($sid, 'article');

    // update feeds
    COM_rdfUpToDateCheck('article');
    COM_rdfUpToDateCheck('comment');
    STORY_updateLastArticlePublished();
}

/**
 * This function is called to inform plugins when a group's information has
 * changed or a new group has been created.
 *
 * @param    int    $grp_id Group ID
 * @param    string $mode   type of change: 'new', 'edit', or 'delete'
 */
function plugin_group_changed_story($grp_id, $mode)
{
    global $_TABLES, $_GROUPS;

    if ($mode == 'delete') {
        // Change any deleted group ids to Story Admin if exist, if does not change to root group
        if (isset($_GROUPS['Story Admin'])) {
            $new_group_id = $_GROUPS['Story Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Story Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }

        // Update Story with new group id
        $sql = "UPDATE {$_TABLES['stories']} SET group_id = $new_group_id WHERE group_id = $grp_id";
        DB_query($sql);
    }
}

/**
 * Implements the [story:] and [article:] autotag.
 *
 * @param   string $op      operation to perform
 * @param   string $content item (e.g. story text), including the autotag
 * @param   array  $autotag parameters used in the autotag
 * @return  mixed           tag names (for $op='tagname') or formatted content
 */
function plugin_autotags_article($op, $content = '', $autotag = array())
{
    global $_CONF, $_TABLES, $LANG24, $_GROUPS;

    if ($op === 'tagname') {
        return array('article', 'story');
    } elseif ($op === 'permission' || $op === 'nopermission') {
        $flag = ($op == 'permission');
        $tagnames = array();

        if (isset($_GROUPS['Story Admin'])) {
            $group_id = $_GROUPS['Story Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Story Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();
        $p = 'autotag_permissions_story';
        if (COM_getPermTag($owner_id, $group_id,
                $_CONF[$p][0], $_CONF[$p][1],
                $_CONF[$p][2], $_CONF[$p][3]) == $flag
        ) {
            $tagnames[] = 'article';
            $tagnames[] = 'story';
        }

        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'description') {
        return array(
            'article' => $LANG24['autotag_desc_article'],
            'story' => $LANG24['autotag_desc_story']
        );
    } else {
        $sid = isset($autotag['parm1']) ? COM_applyFilter($autotag['parm1']) : '';
        $sid = COM_switchLanguageIdForObject($sid);
        if (!empty($sid)) {
            $result = DB_query("SELECT COUNT(*) AS count "
                . "FROM {$_TABLES['stories']} "
                . "WHERE sid = '$sid'");
            $A = DB_fetchArray($result);

            if ($A['count'] > 0) {
                $url = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $sid);
                $linktext = $autotag['parm2'];
                if (empty($linktext)) {
                    $linktext = stripslashes(DB_getItem($_TABLES['stories'], 'title', "sid = '$sid'"));
                }
                $link = COM_createLink($linktext, $url);
                $content = str_replace($autotag['tagstr'], $link, $content);
            }
        }

        return $content;
    }
}

/**
 * Return the comment code to this plugin item. This is based not only the code of the actual plugin item but the access the user has to the item
 *
 * @param   string $id   Item id to which $cid belongs
 * @param   int    $uid  user id or 0 = current user 
 * @return  int    Return a CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
 */
function plugin_commentenabled_article($id, $uid = 0)
{
    global $_CONF, $_TABLES;

    // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
    $commentCode = COMMENT_CODE_DISABLED;

    $sql = "SELECT sid, commentcode, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon FROM {$_TABLES['stories']}";
    $sql .= " WHERE sid = '" . DB_escapeString($id) . "' " . COM_getPermSQL('AND', $uid);
    if (!SEC_hasRights('story.edit')) {
        $sql .= "AND (draft_flag = 0) AND (date <= NOW())";
    } 
    $result = DB_query($sql);
    $A = DB_fetchArray($result);
    if (DB_numRows($result) == 1 && TOPIC_hasMultiTopicAccess('article', $id) > 0) { // Need read access of topics to post comment
        // CommentCode: Enabled = 0, Disabled = -1. Closed = 1
        if ($A['commentcode'] == COMMENT_CODE_ENABLED) {
            $commentCode = COMMENT_CODE_ENABLED;
        } elseif ($A['commentcode'] == COMMENT_CODE_CLOSED) { // Closed but still visible so give admins access
            if (SEC_hasRights('story.edit', 'AND', $uid) &&
                (SEC_hasAccess($A['owner_id'], $A['group_id'],
                        $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                        $A['perm_anon'], $uid) == 3)) {
                $commentCode = COMMENT_CODE_ENABLED; // If Admin then treat comment like enabled
            } else {
                $commentCode = COMMENT_CODE_CLOSED;
            }
        }
    }

    return $commentCode;
}

/**
 * article: saves a comment
 *
 * @param   string $title    comment title
 * @param   string $comment  comment text
 * @param   string $id       Item id to which $cid belongs
 * @param   int    $pid      comment parent
 * @param   string $postmode 'html' or 'text'
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_savecomment_article($title, $comment, $id, $pid, $postmode)
{
    global $_CONF, $_TABLES, $LANG03;

    $retval = '';

    // Use plugin_commentenabled_foo permission check to determine if user has permissions to save a comment for this item
    // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
    if (plugin_commentenabled_article($id) != COMMENT_CODE_ENABLED) {
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    $numpages = DB_getItem($_TABLES['stories'], 'numpages',
        "(sid = '$id') AND (draft_flag = 0) AND (date <= NOW())"
        . COM_getPermSQL('AND'));
    if ($_CONF['allow_page_breaks'] == 1 && $_CONF['page_break_comments'] == 'last' && $numpages > 1) {
        $articlePageNumURLPart = "&amp;page=" . $numpages;
    } else {
        $articlePageNumURLPart = "";
    }

    $ret = CMT_saveComment($title, $comment, $id, $pid, 'article', $postmode);
    if ($ret == -1) {
        $url = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $id . $articlePageNumURLPart);
        $url .= (strpos($url, '?') ? '&' : '?') . 'msg=15';
        COM_redirect($url);
    } elseif (($ret > 0) || is_string($ret)) { // failure
        // FIXME: some failures should not return to comment form
        $retval .= CMT_commentForm($title, $comment, $id, $pid, 'article',
            $LANG03[14], $postmode);

        if (!defined('COMMENT_ON_SAME_PAGE')) {
            $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
        } else {
            if (!COMMENT_ON_SAME_PAGE) {
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
            }
        }
    } else { // success
        // Updated comment counts on article
        plugin_moderationcommentapprove_article($id, 0); // Don't need new comment id so just pass 0

        // Comment count in Older Stories block may have changed so delete cache
        $cacheInstance = 'olderarticles__'; // remove all olderarticles instances
        CACHE_remove_instance($cacheInstance);

        COM_redirect(COM_buildUrl($_CONF['site_url'] . "/article.php?story=" . $id . $articlePageNumURLPart . "#comments"));
    }

    return $retval;
}

/**
 * article: Comment Submission approved
 *
 * @param   string $id       Item id to which $cid belongs
 * @param   int     $cid    Approved Comment id
 */
function plugin_moderationcommentapprove_article($id, $cid)
{
    global $_TABLES;

    $comments = DB_count($_TABLES['comments'], array('type', 'sid'), array('article', $id));
    DB_change($_TABLES['stories'], 'comments', $comments, 'sid', $id);

    return true;
}

/**
 * article: delete a comment
 *
 * @param   int    $cid Comment to be deleted
 * @param   string $id  Item id to which $cid belongs
 * @param   boolean $returnOption  Either return a boolean on success or not, or redirect
 * @return  mixed        Based on $returnOption. false for failure or true for success, else a redirect for success or failure
 */
function plugin_deletecomment_article($cid, $id, $returnBoolean)
{
    global $_CONF, $_TABLES, $_USER;

    $retval = false;

    $has_editPermissions = SEC_hasRights('story.edit');
    $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon "
        . "FROM {$_TABLES['stories']} WHERE sid = '$id'");
    $A = DB_fetchArray($result);

    if ($has_editPermissions && SEC_hasAccess($A['owner_id'],
            $A['group_id'], $A['perm_owner'], $A['perm_group'],
            $A['perm_members'], $A['perm_anon']) == 3
    ) {
        CMT_deleteComment($cid, $id, 'article');
        $comments = DB_count($_TABLES['comments'], 'sid', $id);
        DB_change($_TABLES['stories'], 'comments', $comments, 'sid', $id);

        // Comment count in Older Stories block may have changed so delete cache
        $cacheInstance = 'olderstories__'; // remove all olderstories instances
        CACHE_remove_instance($cacheInstance);

        if ($returnBoolean) {
            $retval = true;
        } else {
            COM_redirect(COM_buildUrl($_CONF['site_url'] . "/article.php?story=$id") . '#comments');
        }
    } else {
        COM_errorLog("User {$_USER['username']} (IP: " . \Geeklog\IP::getIPAddress() . ") "
            . "tried to illegally delete comment $cid from $id");

        if ($returnBoolean) {
            $retval = false;
        } else {
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
    }

    return $retval;
}

/**
 * article: display [a] comment[s]
 *
 * @param   string  $id     Unique idenifier for item comment belongs to
 * @param   int     $cid    Comment id to display (possibly including sub-comments)
 * @param   string  $title  Page/comment title
 * @param   string  $order  'ASC' or 'DESC' or blank
 * @param   string  $format 'threaded', 'nested', or 'flat'
 * @param   int     $page   Page number of comments to display
 * @param   boolean $view   True to view comment (by cid), false to display (by $pid)
 * @return  mixed   results of calling the plugin_displaycomment_ function
 */
function plugin_displaycomment_article($id, $cid, $title, $order, $format, $page, $view)
{
    global $_TABLES, $LANG_ACCESS;

    $retval = '';

    $sql = 'SELECT COUNT(*) AS count, commentcode, owner_id, group_id, perm_owner, perm_group, '
        . "perm_members, perm_anon FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta WHERE (sid = '$id') "
        . 'AND (draft_flag = 0) AND (commentcode >= 0) AND (date <= NOW()) AND ta.type = "article" AND ta.id = sid ' . COM_getPermSQL('AND')
        . COM_getTopicSQL('AND', 0, 'ta') . ' GROUP BY sid, owner_id, group_id, perm_owner, perm_group,perm_members, perm_anon ';
    $result = DB_query($sql);
	$nrows = DB_numRows($result);
	if ($nrows > 0) {	
		$A = DB_fetchArray($result);
		$allowed = $A['count'];

		if ($allowed > 0) { // Was equal 1 but when multiple topics in play the comment could belong to more than one topic creating a higher count
			$delete_option = (SEC_hasRights('story.edit') &&
				(SEC_hasAccess($A['owner_id'], $A['group_id'],
						$A['perm_owner'], $A['perm_group'], $A['perm_members'],
						$A['perm_anon']) == 3));
			$retval .= CMT_userComments($id, $title, 'article', $order,
				$format, $cid, $page, $view, $delete_option,
				$A['commentcode']);
		} else {
			$retval .= COM_showMessageText($LANG_ACCESS['storydenialmsg'], $LANG_ACCESS['accessdenied']);
		}
	} else {
		$retval .= COM_showMessageText($LANG_ACCESS['storydenialmsg'], $LANG_ACCESS['accessdenied']);
	}

    return $retval;
}

/**
 * Provide URL for the link to a comment's parent item.
 * NOTE: The Plugin API does not support $_CONF['url_rewrite'] here,
 *       so we'll end up with a non-rewritten URL ...
 *
 * @return   string   string of URL
 */
function plugin_getcommenturlid_article($id)
{
    global $_CONF, $_TABLES;

    // Cannot use COM_buildURL as comment stuff does not support URL Rewrite - $retval = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $id);
    $retval = $_CONF['site_url'] . '/article.php?story=' . $id;

    //  If article.php is the calling file we can figure out article page
    if (strpos($_SERVER['PHP_SELF'], '/article.php') !== false) {
        // *********************************
        // Figure out mode and article page
        // Same code as in beginning of article.php and plugin_getcommenturlid_article function in lib-article.php
            $mode = Geeklog\Input::fPost('mode', Geeklog\Input::fPost('format', ''));

        if (!empty($mode)) {
            $sid = Geeklog\Input::fPost('story', '');
        } else {
            // This supports URL Rewrite
            COM_setArgNames(array('story', 'mode'));
            $sid = COM_applyFilter(COM_getArgument('story'));
            $mode = COM_applyFilter(COM_getArgument('mode')); // Could be mode or page if numeric
        }
        $articlePage = (int) Geeklog\Input::fGet('page', 0);

        if ($_CONF['allow_page_breaks'] == 1 && $articlePage == 0) {
            // $mode was used to store page ids before Geeklog v2.2.1 See Issue #1022
            // Lets do a bit of backwards compatibility here for any external links coming in
            // if not numeric then mode is used by comments to determine how to display them
            // REALLY should do a 301 redirect so search engines know that there is a new url for same content
            if (is_numeric($mode)) {
                $articlePage = $mode;
                $mode = ''; // need to clear it since mode post variable is used by comment as well to determine how to display comments
            }
        }
        if ($articlePage == 0) {
            $articlePage = 1;
        }
        // *********************************
    } else {
        // something else (most likely comment.php) is the calling file so...
        $articlePage = 1;
    }

    // See if multi page article as we will have to see which page comments appear on
    $numpages = DB_getItem($_TABLES['stories'], 'numpages', "sid = '$id'");
    if ($_CONF['allow_page_breaks'] == 1 && $numpages > 1) {
        if ($_CONF['page_break_comments'] == 'last' or $articlePage > $numpages) {
            $retval .= "&amp;page=" . $numpages;
        } elseif ($articlePage > 1) {
            $retval .= "&amp;page=" . $articlePage;
        }
    }

    return $retval;
}

/**
 * Do we support article feeds? (use plugin api)
 *
 * @return   array   id/name pairs of all supported feeds
 */
function plugin_getfeednames_article()
{
    global $_TABLES, $LANG33;

    $feeds = array();

    $feeds[] = array('id' => '::frontpage', 'name' => $LANG33[53]);
    $feeds[] = array('id' => '::all', 'name' => $LANG33[23]);

    $result = DB_query("SELECT tid, topic FROM {$_TABLES['topics']} " . COM_getPermSQL('AND') . " ORDER BY topic ASC");
    $num = DB_numRows($result);

    if ($num > 0) {
        for ($i = 0; $i < $num; $i++) {
            $A = DB_fetchArray($result);
            $feeds[] = array('id' => $A['tid'], 'name' => $A['topic']);
        }
    }

    return $feeds;
}

/**
 * Return an array of Block Locations in plugin templates
 */
function plugin_getBlockLocations_article()
{
   global $LANG23;

    $block_locations = array();

    // Add any extra block locations for plugin
    // Remember these locations can only appear in templates that PLG_templateSetVars is used with
    $block_locations[] = array(
        'id'                => 'article_footer', // Unique string. No other block location (includes Geeklog itself and any other plugins or themes) can share the same id ("left" and "right" are already taken).
        'name'              => $LANG23['blocks_article_footer_name'],
        'description'       => $LANG23['blocks_article_footer_desc'],
        'template_name'     => 'article_full',
        'template_variable' => 'blocks_article_footer'
    );

    $block_locations[] = array(
        'id'                => 'article_topic_list', // Unique string. No other block location (includes Geeklog itself and any other plugins or themes) can share the same id ("left" and "right" are already taken).
        'name'              => $LANG23['blocks_article_topic_list_name'],
        'description'       => $LANG23['blocks_article_topic_list_desc'],
        'template_name'     => 'article_topic_list',
        'template_variable' => 'blocks_article_topic_list'
    );

    return $block_locations;
}

/**
 * Config Option has changed. (use plugin api)
 *
 * @return  void
 */
function plugin_configchange_article($group, $changes = array())
{
    global $_TABLES, $_CONF, $_STRUCT_DATA;

    // If trim length changes then need to redo all related url's for articles
    if ($group == 'Core' && in_array('whats_related_trim', $changes)) {
        $sql = "SELECT sid, introtext, bodytext FROM {$_TABLES['stories']}";
        $result = DB_query($sql);
        $nrows = DB_numRows($result);
        if ($nrows > 0) {
            for ($x = 0; $x < $nrows; $x++) {
                $A = DB_fetchArray($result);
                // Should maybe retrieve through story service but just grab from database and apply any autotags
                // This is all the related story column should really need
                $fulltext = PLG_replaceTags($A['introtext'], 'article', $A['sid']) . ' ' . PLG_replaceTags($A['bodytext'], '', false , 'article', $A['sid']);
                $related = DB_escapeString(implode("\n", STORY_extractLinks($fulltext, $_CONF['whats_related_trim'])));

                // Update all related even if empty since number of related links could have changed for some reason
                DB_query("UPDATE {$_TABLES['stories']} SET related = '$related' WHERE sid = '{$A['sid']}'");
            }

        }
        // For if any articles are being cached
    } elseif ($group == 'Core' && (in_array('site_name', $changes) ||
            in_array('contributedbyline', $changes) ||
            in_array('allow_user_photo', $changes) ||
            in_array('article_image_align', $changes) ||
            in_array('related_topics', $changes) ||
            in_array('related_topics_max', $changes) ||
            in_array('allow_page_breaks', $changes) ||
            in_array('page_break_comments', $changes) ||
            in_array('url_rewrite', $changes) ||
            in_array('url_routing', $changes) ||
            in_array('hideviewscount', $changes) ||
            in_array('hideemailicon', $changes) ||
            in_array('loginrequired', $changes) ||
            in_array('emailstoryloginrequired', $changes) ||
            in_array('hideprintericon', $changes))
    ) {
        // If any Article options changed then delete all article cache
        $cacheInstance = 'article__';
        CACHE_remove_instance($cacheInstance);
        $_STRUCT_DATA->clear_cachedScript('article');
    }
}

/**
 * Did user create any articles
 *
 * @return   string   number of articles user contributed. If nothing leave blank
 */
function plugin_usercontributed_article($uid)
{
    global $_TABLES, $LANG33;

    $retval = '';

    // Include articles and article submissions
    $count = DB_getItem($_TABLES['stories'], 'COUNT(owner_id)', "owner_id = {$uid}") + DB_getItem($_TABLES['storysubmission'], 'COUNT(uid)', "uid = {$uid}");

    if ($count > 0) {
        $retval = str_replace('%s', $count, $LANG33['num_articles']);
    }

    return $retval;
}

/**
 * Find out Likes plural label for item
 *
 * @return   string 	Plural name of item that can be liked or disliked
 */
function plugin_likeslabel_article($sub_type)
{
    global $LANG_LIKES;

    return $LANG_LIKES['articles'];
}

/**
 * Is Likes system enabled for articles
 *
 * @return   int    0 = disabled, 1 = Likes and Dislikes, 2 = Likes only
 */
function plugin_likesenabled_article($sub_type, $id)
{
    global $_CONF;

    $retval = false;

    if ( $_CONF['likes_articles'] > 0) {
        $retval = $_CONF['likes_articles'];
    }

    return $retval;
}

/**
 * Get URL for item like is for
 * Note: $Id is filtered as a string by likes.php.
 *       If needed do additional checks here (like if you need a numeric value)
 *       but you cannot change the value of id since it will not change in the original calling function
 *
 * @return   string    URL of item like is for
 */
function plugin_getItemLikeURL_article($sub_type, $id)
{
    global $_CONF;

    $retval = '';

    if ($_CONF['likes_articles'] > 0) {
        // No sense rebuilding stuff here so use PLG_getItemInfo
        // PLG_getItemInfo will only return url if user has permissions
        $options['sub_type'] = $sub_type;
        $retval = PLG_getItemInfo('article', $id, 'url', 0, $options);
    }

    return $retval;
}

/**
 * Can user perform a like action on item
 * Need to check not only likes enabled for item but same owner and read permissions to item
 * Note: $Id is filtered as a string by likes.php.
 *       If needed do additional checks here (like if you need a numeric value)
 *       but you cannot change the value of id since it will not change in the original calling function
 *
 * @return   bool
 */
function plugin_canuserlike_article($sub_type, $id, $uid, $ip)
{
    global $_CONF, $_TABLES;

    $retval = false;

    if ($_CONF['likes_articles'] > 0) {
        $perm_sql = COM_getPermSQL( 'AND', $uid, 2);
        $sql = "SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid='".$id."' " . $perm_sql;
        $result = DB_query($sql);
        if (DB_numRows($result) > 0) {
            list ($owner_id, $group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) = DB_fetchArray($result);
            if ($owner_id != $uid) {
                $retval = true;
            }
        }
    }

    return $retval;
}

// Format content to be displayed in the search results
function plugin_searchformat_article($id, $contentType, $content)
{
    global $_TABLES;

	// Remove any [imageX_mode] and [unscaledX_mode] from article text
	if ($contentType == 'description') {
        $result = DB_query("SELECT ai_img_num FROM {$_TABLES['article_images']} WHERE " .
            "ai_sid = '$id' ORDER BY ai_img_num");
        $numRows = DB_numRows($result);

        for ($i = 1; $i <= $numRows; $i++) {
            $A = DB_fetchArray($result);

            $n = $A['ai_img_num'];
            $imageX = '[image' . $n . ']';
            $imageX_left = '[image' . $n . '_left]';
            $imageX_right = '[image' . $n . '_right]';
            $content = str_replace($imageX, '', $content);
            $content = str_replace($imageX_left, '', $content);
            $content = str_replace($imageX_right, '', $content);

            $unscaledX = '[unscaled' . $n . ']';
            $unscaledX_left = '[unscaled' . $n . '_left]';
            $unscaledX_right = '[unscaled' . $n . '_right]';
            $content = str_replace($unscaledX, '', $content);
            $content = str_replace($unscaledX_left, '', $content);
            $content = str_replace($unscaledX_right, '', $content);
        }

		return $content;
	}
}

/**
 * Geeklog is asking us to provide any items that show up in the type
 * drop-down on search.php.  Let's users search for events.
 *
 * @return   array   (plugin name/entry title) pair for the dropdown
 */
function plugin_searchtypes_article()
{
    global $LANG09;

    $tmp['article'] = $LANG09[65];

    return $tmp;
}

/**
 * This searches for events matching the user query and returns an array for the
 * header and table rows back to search.php where it will be formated and printed
 *
 * @param    string $query     Keywords user is looking for
 * @param    date   $datestart Start date to get results for
 * @param    date   $dateend   End date to get results for
 * @param    string $topic     The topic they were searching in
 * @param    string $type      Type of items they are searching, or 'all' (deprecated)
 * @param    int    $author    Get all results by this author
 * @param    string $keyType   search key type: 'all', 'phrase', 'any'
 * @param    int    $page      page number of current search (deprecated)
 * @param    int    $perpage   number of results per page (deprecated)
 * @return   object|array              search result object
 */
function plugin_dopluginsearch_article($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $_TABLES, $LANG09;

    // Make sure the query is SQL safe
    $query = trim(DB_escapeString($query));

    $sql = 'SELECT s.sid AS id, s.title AS title, s.introtext AS description, ';
    $sql .= 'UNIX_TIMESTAMP(s.date) AS date, s.uid AS uid, s.hits AS hits, ';
    $sql .= "CONCAT('/article.php?story=', s.sid) AS url ";
    $sql .= 'FROM ' . $_TABLES['stories'] . ' AS s, ' . $_TABLES['users'] . ' AS u, ' . $_TABLES['topic_assignments'] . ' AS ta ';
    $sql .= 'WHERE (draft_flag = 0) AND (date <= NOW()) AND (u.uid = s.uid) ';
    $sql .= 'AND ta.type = \'article\' AND ta.id = sid ';
    $sql .= COM_getPermSQL('AND') . COM_getTopicSQL('AND', 0, 'ta') . COM_getLangSQL('sid', 'AND') . ' ';

    if (!empty($topic)) {
        // Retrieve list of inherited topics
        if ($topic == TOPIC_ALL_OPTION) {
            // Stories do not have an all option so just return all stories that meet the requirements and permissions
            //$sql .= "AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '".$topic."')) ";
        } else {
            $tid_list = TOPIC_getChildList($topic);
            $sql .= "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '" . $topic . "'))) ";
        }
    }
    if (!empty($author)) {
        $sql .= 'AND (s.uid = \'' . $author . '\') ';
    }

    $search_s = new SearchCriteria('article', $LANG09[65]);

    $columns = array('title' => 'title', 'introtext', 'bodytext');
    $sql .= $search_s->getDateRangeSQL('AND', 'date', $datestart, $dateend);
    list($sql, $ftSql) = $search_s->buildSearchSQL($keyType, $query, $columns, $sql);

    $sql .= " GROUP BY s.sid, s.title, s.introtext, date, s.uid, s.hits ";

    $search_s->setSQL($sql);
    $search_s->setFtSQL($ftSql);
    $search_s->setRank(5);
    $search_s->setURLRewrite(true);

    // Search Story Comments
    $sql = 'SELECT c.cid AS id, c.title AS title, c.comment AS description, ';
    $sql .= 'UNIX_TIMESTAMP(c.date) AS date, c.uid AS uid, \'0\' AS hits, ';
    $sql .= 'CONCAT(\'/comment.php?mode=view&amp;cid=\',c.cid) AS url ';
    $sql .= 'FROM ' . $_TABLES['users'] . ' AS u, ' . $_TABLES['topic_assignments'] . ' AS ta, ' . $_TABLES['comments'] . ' AS c ';
    $sql .= 'LEFT JOIN ' . $_TABLES['stories'] . ' AS s ON ((s.sid = c.sid) ';
    $sql .= COM_getPermSQL('AND', 0, 2, 's') . COM_getLangSQL('sid', 'AND', 's') . ') ';
    $sql .= 'WHERE (u.uid = c.uid) AND (s.draft_flag = 0) AND (s.commentcode >= 0) AND (s.date <= NOW()) ';
    $sql .= 'AND ta.type = \'article\' AND ta.id = s.sid ' . COM_getTopicSQL('AND', 0, 'ta');

    if (!empty($topic)) {
        if ($topic == TOPIC_ALL_OPTION) {
            // Stories do not have an all option so just return all story comments that meet the requirements and permissions
            //$sql .= "AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '".$topic."')) ";
        } else {
            $sql .= "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '" . $topic . "'))) ";
        }
    }
    if (!empty($author)) {
        $sql .= 'AND (c.uid = \'' . $author . '\') ';
    }

    $search_c = new SearchCriteria('comments', array($LANG09[65], $LANG09[66]));

    $columns = array('title' => 'c.title', 'comment');
    $sql .= $search_c->getDateRangeSQL('AND', 'c.date', $datestart, $dateend);
    list($sql, $ftSql) = $search_c->buildSearchSQL($keyType, $query, $columns, $sql);

    $sql .= " GROUP BY c.cid, c.title, c.comment, c.date, c.uid ";

    $search_c->setSQL($sql);
    $search_c->setFtSQL($ftSql);
    $search_c->setRank(2);

    return array($search_s, $search_c);

}

/**
 * Return URL of item even if the item doesn't exist, e.g., after it has been deleted
 *
 * @param  string  $sub_type  (unused) sub type of plugin
 * @param  string  $item_id   the id of the item
 * @return string
 * @since  Geeklog 2.2.2
 */
function plugin_idToURL_article($sub_type, $item_id)
{
    global $_CONF;

    return COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $item_id);
}

/*
 * START SERVICES SECTION
 * This section implements the various services offered by the story module
 */

/**
 * Submit a new or updated story. The story is updated if it exists, or a new one is created
 *
 * @param   array  $args   Contains all the data provided by the client
 * @param   string $output OUTPUT parameter containing the returned text
 * @return  int             Response code as defined in lib-plugins.php
 */
function service_submit_story($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $_USER, $LANG24, $MESSAGE;

    $output = ''; // Initialize as a string variable

    if (!SEC_hasRights('story.edit')) {
        $output .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
        $output = COM_createHTMLDocument($output, array('pagetitle' => $MESSAGE[30]));

        return PLG_RET_AUTH_FAILED;
    }

    require_once $_CONF['path_system'] . 'lib-comment.php';
    if (!$_CONF['disable_webservices']) {
        require_once $_CONF['path_system'] . 'lib-webservices.php';
    }

    $gl_edit = false;
    if (isset($args['gl_edit'])) {
        $gl_edit = $args['gl_edit'];
    }
    if ($gl_edit) {
        /* This is EDIT mode, so there should be an old sid */
        if (empty($args['old_sid'])) {
            if (!empty($args['id'])) {
                $args['old_sid'] = $args['id'];
            } else {
                return PLG_RET_ERROR;
            }

            if (empty($args['sid'])) {
                $args['sid'] = $args['old_sid'];
            }
        }
    } else {
        if (empty($args['sid']) && !empty($args['id'])) {
            $args['sid'] = $args['id'];
        }
    }

    // Store the first CATEGORY as the Topic ID
    if (!empty($args['category'][0])) {
        $args['tid'] = $args['category'][0];
    }

    $content = '';
    if (!empty($args['content'])) {
        $content = $args['content'];
    } elseif (!empty($args['summary'])) {
        $content = $args['summary'];
    }
    if (!empty($content)) {
        $parts = explode('[page_break]', $content);
        if (count($parts) == 1) {
            $args['introtext'] = $content;
            $args['bodytext'] = '';
        } else {
            $args['introtext'] = array_shift($parts);
            $args['bodytext'] = implode('[page_break]', $parts);
        }
    }

    // Apply filters to the parameters passed by the webservice
    if ($args['gl_svc']) {
        if (isset($args['mode'])) {
            $args['mode'] = COM_applyBasicFilter($args['mode']);
        }
        if (isset($args['editopt'])) {
            $args['editopt'] = COM_applyBasicFilter($args['editopt']);
        }
    }

    // - START: Set all the defaults -
    /*
    if (empty($args['tid'])) {
        // see if we have a default topic
        $topic = DB_getItem($_TABLES['topics'], 'tid',
                            'is_default = 1' . COM_getPermSQL('AND'));
        if (!empty($topic)) {
            $args['tid'] = $topic;
        } else {
            // otherwise, just use the first one
            $o = array();
            $s = array();
            if (service_getTopicList_story(array('gl_svc' => true), $o, $s) == PLG_RET_OK) {
                $args['tid'] = $o[0];
            } else {
                $svc_msg['error_desc'] = 'No topics available';
                return PLG_RET_ERROR;
            }
        }
    } */


    /* This is a solution for above but the above has issues
    if (!TOPIC_checkTopicSelectionControl()) {
        $svc_msg['error_desc'] = 'No topics selected or available';
        return PLG_RET_ERROR;
    }
   */

    if (empty($args['owner_id'])) {
        $args['owner_id'] = $_USER['uid'];
    }

    if (empty($args['group_id'])) {
        $args['group_id'] = SEC_getFeatureGroup('story.edit', $_USER['uid']);
    }

    if (empty($args['postmode'])) {
        $args['postmode'] = $_CONF['postmode'];

        if (!empty($args['content_type'])) {
            if ($args['content_type'] == 'text') {
                $args['postmode'] = 'text';
            } elseif (($args['content_type'] == 'html')
                || ($args['content_type'] == 'xhtml')
            ) {
                $args['postmode'] = 'html';
            }
        }
    }

    if ($args['gl_svc']) {
        // Permissions
        if (!isset($args['perm_owner'])) {
            $args['perm_owner'] = $_CONF['default_permissions_story'][0];
        } else {
            $args['perm_owner'] = COM_applyBasicFilter($args['perm_owner'], true);
        }
        if (!isset($args['perm_group'])) {
            $args['perm_group'] = $_CONF['default_permissions_story'][1];
        } else {
            $args['perm_group'] = COM_applyBasicFilter($args['perm_group'], true);
        }
        if (!isset($args['perm_members'])) {
            $args['perm_members'] = $_CONF['default_permissions_story'][2];
        } else {
            $args['perm_members'] = COM_applyBasicFilter($args['perm_members'], true);
        }
        if (!isset($args['perm_anon'])) {
            $args['perm_anon'] = $_CONF['default_permissions_story'][3];
        } else {
            $args['perm_anon'] = COM_applyBasicFilter($args['perm_anon'], true);
        }

        if (!isset($args['draft_flag'])) {
            $args['draft_flag'] = $_CONF['draft_flag'];
        }

        if (empty($args['frontpage'])) {
            $args['frontpage'] = $_CONF['frontpage'];
        }

        if (empty($args['show_topic_icon'])) {
            $args['show_topic_icon'] = $_CONF['show_topic_icon'];
        }
    }
    // - END: Set all the defaults -

    // TEST CODE
    /* foreach ($args as $k => $v) {
        if (!is_array($v)) {
            echo "$k => $v\r\n";
        } else {
            echo "$k => $v\r\n";
            foreach ($v as $k1 => $v1) {
                echo "        $k1 => $v1\r\n";
            }
        }
    }*/
    // exit ();
    // END TEST CODE

    if (!isset($args['sid'])) {
        $args['sid'] = '';
    }
    $args['sid'] = COM_sanitizeID($args['sid'], true, true);
    if (!$gl_edit) {
        if (strlen($args['sid']) > STORY_MAX_ID_LENGTH) {
            $slug = '';
            if (isset($args['slug'])) {
                $slug = $args['slug'];
            }
            if (function_exists('WS_makeId')) {
                $args['sid'] = WS_makeId($slug, STORY_MAX_ID_LENGTH);
            } else {
                $args['sid'] = COM_makeSid(true);
            }
        }
    }
    $story = new Article();

    $gl_edit = false;
    if (isset($args['gl_edit'])) {
        $gl_edit = $args['gl_edit'];
    }
    if ($gl_edit && !empty($args['gl_etag'])) {
        // First load the original story to check if it has been modified
        $result = $story->loadFromDatabase($args['sid']);
        if ($result == STORY_LOADED_OK) {
            if ($args['gl_etag'] != date('c', $story->_date)) {
                $svc_msg['error_desc'] = 'A more recent version of the story is available';

                return PLG_RET_PRECONDITION_FAILED;
            }
        } else {
            $svc_msg['error_desc'] = 'Error loading story';

            return PLG_RET_ERROR;
        }
    }

    // This function is also doing the security checks
    $result = $story->loadFromArgsArray($args);

    $sid = $story->getSid();

    // Check if topics selected if not prompt required field
    if ($result == STORY_LOADED_OK) {
        if (!TOPIC_checkTopicSelectionControl()) {
            $result = STORY_EMPTY_REQUIRED_FIELDS;
        }
    }

    switch ($result) {
        case STORY_DUPLICATE_SID:
            $output .= COM_errorLog($LANG24[24], 2);
            if (!$args['gl_svc']) {
                $_POST['sid'] = $_POST['old_sid']; // Restore the previous value
                $output .= storyeditor('', 'preview'); // Resume editing
            }
            $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG24[5]));

            return PLG_RET_ERROR;
            break;

        case STORY_EXISTING_NO_EDIT_PERMISSION:
            $output .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
            $output = COM_createHTMLDocument($output, array('pagetitle' => $MESSAGE[30]));
            COM_accessLog("User {$_USER['username']} tried to illegally submit or edit story $sid.");

            return PLG_RET_PERMISSION_DENIED;
            break;

        case STORY_NO_ACCESS_PARAMS:
            $output .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
            $output = COM_createHTMLDocument($output, array('pagetitle' => $MESSAGE[30]));
            COM_accessLog("User {$_USER['username']} tried to illegally submit or edit story $sid.");

            return PLG_RET_PERMISSION_DENIED;
            break;

        case STORY_EMPTY_REQUIRED_FIELDS:
            $output .= COM_errorLog($LANG24[31], 2);
            if (!$args['gl_svc']) {
                $output .= storyeditor($sid);
            }
            $output = COM_createHTMLDocument($output);

            return PLG_RET_ERROR;
            break;

        default:
            break;
    }

    /* Image upload is not supported by the web-service at present */
    if (!$args['gl_svc']) {
        // Delete any images if needed
        if (array_key_exists('delete', $args)) {
            $delete = count($args['delete']);
            for ($i = 1; $i <= $delete; $i++) {
                $ai_filename = DB_getItem($_TABLES['article_images'], 'ai_filename', "ai_sid = '{$sid}' AND ai_img_num = " . key($args['delete']));
                STORY_deleteImage($ai_filename);

                DB_query("DELETE FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' AND ai_img_num = " . key($args['delete']));
                next($args['delete']);
            }
        }

        // OK, let's upload any pictures with the article
        if (DB_count($_TABLES['article_images'], 'ai_sid', $sid) > 0) {
            $index_start = DB_getItem($_TABLES['article_images'], 'max(ai_img_num)', "ai_sid = '$sid'") + 1;
        } else {
            $index_start = 1;
        }

        if (count($_FILES) > 0 && $_CONF['maximagesperarticle'] > 0) {
            $filenames = array();
            $ai_fnames = array();
            $files = $_FILES;
            $uploadFiles = array();
            foreach ($files as $k => $file) {
                if ($file['error'] == 0) {
                    $num = str_replace('file', '', $k);
                    $pos = strrpos($file['name'], '.') + 1;
                    $fExtension = substr($file['name'], $pos);
                    $ai_fnames[$num] = $sid . '_' . $num . '.' . $fExtension;
                    $filenames[] = $ai_fnames[$num];
                    $uploadFiles[$num] = $file;
                }
            }
            $_FILES = $uploadFiles;
            $upload = new Upload();

            if (isset ($_CONF['debug_image_upload']) && $_CONF['debug_image_upload']) {
                $upload->setLogFile($_CONF['path'] . 'logs/error.log');
                $upload->setDebug(true);
            }
            $upload->setMaxFileUploads($_CONF['maximagesperarticle']);
            if (!empty($_CONF['image_lib'])) {
                if ($_CONF['image_lib'] == 'imagemagick') {
                    // Using imagemagick
                    $upload->setMogrifyPath($_CONF['path_to_mogrify']);
                } elseif ($_CONF['image_lib'] == 'netpbm') {
                    // using netPBM
                    $upload->setNetPBM($_CONF['path_to_netpbm']);
                } elseif ($_CONF['image_lib'] == 'gdlib') {
                    // using the GD library
                    $upload->setGDLib();
                }
                $upload->setAutomaticResize(true);
                if ($_CONF['keep_unscaled_image'] == 1) {
                    $upload->keepOriginalImage(true);
                } else {
                    $upload->keepOriginalImage(false);
                }
                if (isset($_CONF['jpeg_quality'])) {
                    $upload->setJpegQuality($_CONF['jpeg_quality']);
                }
            }
            $upload->setAllowedMimeTypes(array(
                'image/gif'   => '.gif',
                'image/jpeg'  => '.jpg,.jpeg',
                'image/pjpeg' => '.jpg,.jpeg',
                'image/x-png' => '.png',
                'image/png'   => '.png',
            ));
            if (!$upload->setPath($_CONF['path_images'] . 'articles')) {
                $output = COM_showMessageText($upload->printErrors(false), $LANG24[30]);
                $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG24[30]));
                echo $output;
                exit;
            }
            if (!$upload->setThumbsPath($_CONF['path_images'] . '_thumbs/articles')) {
                $output = COM_showMessageText($upload->printErrors(false), $LANG24[30]);
                $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG24[30]));
                echo $output;
                exit;
            }

            // NOTE: if $_CONF['path_to_mogrify'] is set, the call below will
            // force any images bigger than the passed dimensions to be resized.
            // If mogrify is not set, any images larger than these dimensions
            // will get validation errors
            $upload->setMaxDimensions($_CONF['max_image_width'], $_CONF['max_image_height']);
            $upload->setMaxFileSize($_CONF['max_image_size']); // size in bytes, 1048576 = 1MB

            // Set file permissions on file after it gets uploaded (number is in octal)
            $upload->setPerms('0644');
            $upload->setFileNames($filenames);
            $upload->uploadFiles();

            if ($upload->areErrors()) {
                $output .= COM_errorLog($upload->printErrors(false), 2);
                if (!$args['gl_svc']) {
                    $output .= storyeditor($sid);
                }
                $output = COM_createHTMLDocument($output);

                return PLG_RET_ERROR;
            }

            foreach ($ai_fnames as $k => $ai_fname) {
                $count = DB_count($_TABLES['article_images'], array('ai_sid','ai_img_num'), array($sid, $k));
                if ($count == 1) {
                    DB_query("UPDATE {$_TABLES['article_images']} SET ai_filename = '$ai_fname' WHERE ai_sid = '$sid' AND ai_img_num = $k");
                } elseif ($count == 0) {
                    DB_query("INSERT INTO {$_TABLES['article_images']} (ai_sid, ai_img_num, ai_filename) VALUES ('$sid', $k, '$ai_fname')");
                }
            }
        }

        if ($_CONF['maximagesperarticle'] > 0) {
            $errors = $story->checkAttachedImages();
            if (count($errors) > 0) {
                $output .= COM_startBlock($LANG24[54], '',
                    COM_getBlockTemplate('_msg_block', 'header'));
                $output .= $LANG24[55] . LB . '<ul>' . LB;
                foreach ($errors as $err) {
                    $output .= '<li>' . $err . '</li>' . LB;
                }
                $output .= '</ul>' . LB;
                $output .= COM_endBlock(
                    COM_getBlockTemplate('_msg_block', 'footer'));
                $output .= storyeditor($sid);
                $output = COM_createHTMLDocument($output,
                    array('pagetitle' => $LANG24[54]));
                echo $output;
                exit;
            }
        }
    }

    $result = $story->saveToDatabase();

    if ($result == STORY_SAVED) {
        // see if any plugins want to act on that story
        if ((!empty($args['old_sid'])) && ($args['old_sid'] != $sid)) {
            PLG_itemSaved($sid, 'article', $args['old_sid']);
        } else {
            PLG_itemSaved($sid, 'article');
        }

        // update feed(s)
        COM_rdfUpToDateCheck('article', $story->DisplayElements('tid'), $sid);
        COM_rdfUpToDateCheck('comment');
        STORY_updateLastArticlePublished();
        CMT_updateCommentcodes();

        if ($story->type == 'submission') {
            $output = COM_refresh($_CONF['site_admin_url'] . '/moderation.php?msg=9');
        } else {
            $output = PLG_afterSaveSwitch($_CONF['aftersave_story'],
                COM_buildURL("{$_CONF['site_url']}/article.php?story=$sid"),
                'story', 9);
        }

        /* @TODO Set the object id here */
        $svc_msg['id'] = $sid;

        return PLG_RET_OK;
    }
}

/**
 * Delete an existing story
 *
 * @param   array  $args   Contains all the data provided by the client
 * @param   string $output OUTPUT parameter containing the returned text
 * @param   array  $svc_msg
 * @return  int             Response code as defined in lib-plugins.php
 */
function service_delete_story($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $_USER;

    if (empty($args['sid']) && !empty($args['id'])) {
        $args['sid'] = $args['id'];
    }

    if ($args['gl_svc']) {
        $args['sid'] = COM_applyBasicFilter($args['sid']);
    }

    $sid = $args['sid'];

    $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'");
    $A = DB_fetchArray($result);
    $access = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'],
        $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    $access = min($access, TOPIC_hasMultiTopicAccess('article', $sid));
    if ($access < 3) {
        COM_accessLog("User {$_USER['username']} tried to illegally delete story $sid.");
        $output = COM_refresh($_CONF['site_admin_url'] . '/article.php');
        if ($_USER['uid'] > 1) {
            return PLG_RET_PERMISSION_DENIED;
        } else {
            return PLG_RET_AUTH_FAILED;
        }
    }

    STORY_doDeleteThisStoryNow($sid);

    $output = COM_refresh($_CONF['site_admin_url'] . '/article.php?msg=10');

    return PLG_RET_OK;
}

/**
 * Get an existing story
 *
 * @param   array $args   Contains all the data provided by the client
 * @param   array $output OUTPUT parameter containing the returned text
 * @param   array $svc_msg
 * @return  int            Response code as defined in lib-plugins.php
 */
function service_get_story($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $_USER;

    if (!isset($_CONF['atom_max_stories'])) {
        $_CONF['atom_max_stories'] = 10; // set a reasonable default
    }

    $svc_msg['output_fields'] = array(
        'draft_flag',
        'hits',
        'numemails',
        'comments',
        'trackbacks',
        'featured',
        'commentcode',
        'statuscode',
        'expire_date',
        'postmode',
        'advanced_editor_mode',
        'frontpage',
        'owner_id',
        'group_id',
        'perm_owner',
        'perm_group',
        'perm_members',
        'perm_anon',
    );

    if (empty($args['sid']) && !empty($args['id'])) {
        $args['sid'] = $args['id'];
    }

    if ($args['gl_svc']) {
        if (isset($args['mode'])) {
            $args['mode'] = COM_applyBasicFilter($args['mode']);
        }
        if (isset($args['sid'])) {
            $args['sid'] = COM_applyBasicFilter($args['sid']);
        }

        if (empty($args['sid'])) {
            $svc_msg['gl_feed'] = true;
        } else {
            $svc_msg['gl_feed'] = false;
        }
    } else {
        $svc_msg['gl_feed'] = false;
    }

    if (empty($args['mode'])) {
        $args['mode'] = 'view';
    }

    if (!$svc_msg['gl_feed']) {
        $sid = $args['sid'];
        $mode = $args['mode'];

        $story = new Article();
        $retval = $story->loadFromDatabase($sid, $mode);

        if ($retval != STORY_LOADED_OK) {
            $output = $retval;

            return PLG_RET_ERROR;
        }

        foreach ($story->_dbFields as $fieldname => $save) {
            $varname = '_' . $fieldname;
            $output[$fieldname] = $story->{$varname};
        }
        $output['username'] = $story->_username;
        $output['fullname'] = $story->_fullname;

        if ($args['gl_svc']) {
            if (($output['statuscode'] == STORY_ARCHIVE_ON_EXPIRE) ||
                ($output['statuscode'] == STORY_DELETE_ON_EXPIRE)
            ) {
                // This date format is PHP 5 only,
                // but only the web-service uses the value
                $output['expire_date'] = date('c', $output['expire']);
            }
            $output['id'] = $output['sid'];
            $output['category'] = array($output['tid']);
            $output['published'] = date('c', $output['date']);
            $output['updated'] = date('c', $output['date']);
            if (empty($output['bodytext'])) {
                $output['content'] = $output['introtext'];
            } else {
                $output['content'] = $output['introtext'] . LB
                    . '[page_break]' . LB . $output['bodytext'];
            }
            $output['content_type'] = ($output['postmode'] == 'html')
                ? 'html' : 'text';

            $owner_data = SESS_getUserDataFromId($output['owner_id']);

            $output['author_name'] = $owner_data['username'];

            $output['link_edit'] = $sid;
        }
    } else {
        $output = array();

        $mode = $args['mode'];

        $sql = array();

        if (isset($args['offset'])) {
            $offset = COM_applyBasicFilter($args['offset'], true);
        } else {
            $offset = 0;
        }
        $max_items = $_CONF['atom_max_stories'] + 1;

        $limit = " LIMIT $offset, $max_items";
        $limit_pgsql = " LIMIT $max_items OFFSET $offset";
        $order = " ORDER BY unixdate DESC";

        $sql['mysql']
            = "SELECT s.*, UNIX_TIMESTAMP(s.date) AS unixdate, UNIX_TIMESTAMP(s.expire) as expireunix, "
            . "u.username, u.fullname, u.photo, u.email, t.topic, t.imageurl " . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, {$_TABLES['topics']} AS t " . "WHERE (s.uid = u.uid) AND (s.tid = t.tid)" . COM_getPermSQL('AND', $_USER['uid'], 2, 's') . $order . $limit;
        $sql['pgsql'] = "SELECT  s.*, UNIX_TIMESTAMP(s.date) AS unixdate, UNIX_TIMESTAMP(s.expire) as expireunix, u.username, u.fullname, u.photo, u.email, t.topic, t.imageurl  FROM stories s, users u, topics t WHERE (s.uid = u.uid) AND (s.tid = t.tid) FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, {$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (s.tid = t.tid)" . COM_getPermSQL('AND', $_USER['uid'], 2, 's') . $order . $limit_pgsql;
        $result = DB_query($sql);

        $count = 0;

        while (($story_array = DB_fetchArray($result, false)) !== false) {
            $count += 1;
            if ($count == $max_items) {
                $svc_msg['offset'] = $offset + $_CONF['atom_max_stories'];
                break;
            }

            $story = new Article();
            $story->loadFromArray($story_array);

            // This access check is not strictly necessary
            $access = SEC_hasAccess($story_array['owner_id'], $story_array['group_id'], $story_array['perm_owner'], $story_array['perm_group'],
                $story_array['perm_members'], $story_array['perm_anon']);
            $story->_access = min($access, SEC_hasTopicAccess($story->_tid));

            if ($story->_access == 0) {
                continue;
            }

            $story->sanitizeData();

            reset($story->_dbFields);

            $output_item = array();

            foreach ($story->_dbFields as $fieldname => $save) {
                $varname = '_' . $fieldname;
                $output_item[$fieldname] = $story->{$varname};
            }

            if ($args['gl_svc']) {
                if (($output_item['statuscode'] == STORY_ARCHIVE_ON_EXPIRE) ||
                    ($output_item['statuscode'] == STORY_DELETE_ON_EXPIRE)
                ) {
                    // This date format is PHP 5 only,
                    // but only the web-service uses the value
                    $output_item['expire_date'] = date('c', $output_item['expire']);
                }
                $output_item['id'] = $output_item['sid'];
                $output_item['category'] = array($output_item['tid']);
                $output_item['published'] = date('c', $output_item['date']);
                $output_item['updated'] = date('c', $output_item['date']);
                if (empty($output_item['bodytext'])) {
                    $output_item['content'] = $output_item['introtext'];
                } else {
                    $output_item['content'] = $output_item['introtext'] . LB
                        . '[page_break]' . LB . $output_item['bodytext'];
                }
                $output_item['content_type'] = ($output_item['postmode'] == 'html') ? 'html' : 'text';

                $owner_data = SESS_getUserDataFromId($output_item['owner_id']);

                $output_item['author_name'] = $owner_data['username'];
            }
            $output[] = $output_item;
        }
    }

    return PLG_RET_OK;
}

/**
 * Get all the topics available
 *
 * @param  array $args   Contains all the data provided by the client
 * @param  array $output OUTPUT parameter containing the returned text
 * @param  array $svc_msg
 * @return int             Response code as defined in lib-plugins.php
 */
function service_getTopicList_story($args, &$output, &$svc_msg)
{
    $output = COM_topicArray('tid');

    return PLG_RET_OK;
}

/*
 * END SERVICES SECTION
 */
