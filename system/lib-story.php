<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | lib-story.php                                                             |
// |                                                                           |
// | Story-related functions needed in more than one place.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-story.php') !== false) {
    die('This file can not be used on its own!');
}

require_once $_CONF['path_system'] . '/classes/story.class.php';

if ($_CONF['allow_user_photo']) {
    // only needed for the USER_getPhoto function
    require_once $_CONF['path_system'] . 'lib-user.php';
}

// this must be kept in sync with the actual size of 'sid' in the db ...
define('STORY_MAX_ID_LENGTH', 40);

// Story Record Options for the STATUS Field
if (!defined ('STORY_ARCHIVE_ON_EXPIRE')) {
    define ('STORY_ARCHIVE_ON_EXPIRE', '10');
    define ('STORY_DELETE_ON_EXPIRE',  '11');
}

/**
 * Takes an article class and renders HTML in the specified template and style.
 *
 * Formats the given article into HTML. Called by index.php, article.php,
 * submit.php and admin/story.php (Preview mode for the last two).
 *
 * @param   object  $story      The story to display, an instance of the Story class.
 * @param   string  $index      n = Full display of article. p = 'Preview' mode. Else introtext only.
 * @param   string  $storytpl   The template to use to render the story.
 * @param   string  $query      A search query, if one was specified.
 *
 * @return  string  Article as formated HTML.
 *
 * Note: Formerly named COM_Article, and re-written totally since then.
 */
function STORY_renderArticle( &$story, $index='', $storytpl='storytext.thtml', $query='')
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG05, $LANG11, $LANG_TRB,
           $_IMAGE_TYPE, $mode;

    static $storycounter = 0;

    if( empty( $storytpl ))
    {
        $storytpl = 'storytext.thtml';
    }

    $introtext = COM_undoSpecialChars($story->displayElements('introtext'));
    $bodytext = COM_undoSpecialChars($story->displayElements('bodytext'));
    $readmore = empty($bodytext)?0:1;
    $numwords = COM_numberFormat(count(explode(' ', COM_getTextContent($bodytext))));
    if (COM_onFrontpage()) {
        $bodytext = '';
    }

    if( !empty( $query ))
    {
        $introtext = COM_highlightQuery($introtext, $query );
        $bodytext  = COM_highlightQuery($bodytext, $query );
    }


    $article = COM_newTemplate($_CONF['path_layout']);
    $article->set_file( array(
            'article'          => $storytpl,
            'bodytext'         => 'storybodytext.thtml',
            'featuredarticle'  => 'featuredstorytext.thtml',
            'featuredbodytext' => 'featuredstorybodytext.thtml',
            'archivearticle'   => 'archivestorytext.thtml',
            'archivebodytext'  => 'archivestorybodytext.thtml'
            ));

    $article->set_var( 'site_name', $_CONF['site_name'] );
    $article->set_var( 'story_date', $story->DisplayElements('date') );
    $article->set_var( 'story_date_short', $story->DisplayElements('shortdate') );
    $article->set_var( 'story_date_only', $story->DisplayElements('dateonly') );
    if( $_CONF['hideviewscount'] != 1 ) {
        $article->set_var( 'lang_views', $LANG01[106] );
        $article->set_var( 'story_hits', $story->DisplayElements('hits') );
    }
    $article->set_var( 'story_id', $story->getSid() );

    if ($_CONF['contributedbyline'] == 1) {
        $article->set_var('lang_contributed_by', $LANG01[1]);
        $article->set_var('contributedby_uid', $story->DisplayElements('uid'));

        $fullname = $story->DisplayElements('fullname');
        $username = $story->DisplayElements('username');
        $article->set_var('contributedby_user', $username);
        if (empty($fullname)) {
            $article->set_var('contributedby_fullname', $username);
        } else {
            $article->set_var('contributedby_fullname',$fullname);
        }

        $authorname = COM_getDisplayName($story->DisplayElements('uid'),
                                         $username, $fullname);
        $article->set_var('contributedby_author', $authorname);
        $article->set_var('author', $authorname);

        if ($story->DisplayElements('uid') > 1) {
            $profileUrl = $_CONF['site_url']
                        . '/users.php?mode=profile&amp;uid='
                        . $story->DisplayElements('uid');
            $article->set_var('start_contributedby_anchortag',
                    '<a class="storybyline" href="' . $profileUrl . '">');
            $article->set_var('end_contributedby_anchortag', '</a>');
            $article->set_var('contributedby_url', $profileUrl);
        }

        $photo = '';
        if ($_CONF['allow_user_photo'] == 1) {
            $authphoto = $story->DisplayElements('photo');
            if (empty($authphoto)) {
                $authphoto = '(none)'; // user does not have a photo
            }
            $photo = USER_getPhoto($story->DisplayElements('uid'), $authphoto,
                                   $story->DisplayElements('email'));
        }
        if (!empty($photo)) {
            $article->set_var('contributedby_photo', $photo);
            $article->set_var('author_photo', $photo);
            $camera_icon = '<img src="' . $_CONF['layout_url']
                         . '/images/smallcamera.' . $_IMAGE_TYPE . '" alt=""'
                         . XHTML . '>';
            $article->set_var('camera_icon',
                              COM_createLink($camera_icon, $profileUrl));
        } else {
            $article->set_var ('contributedby_photo', '');
            $article->set_var ('author_photo', '');
            $article->set_var ('camera_icon', '');
        }
    }

    $topicname = $story->DisplayElements('topic');
    $article->set_var('story_topic_id', $story->DisplayElements('tid'));
    $article->set_var('story_topic_name', $topicname);

    $topicurl = $_CONF['site_url'] . '/index.php?topic=' . $story->DisplayElements('tid');
    if(( !isset( $_USER['noicons'] ) OR ( $_USER['noicons'] != 1 )) AND
            $story->DisplayElements('show_topic_icon') == 1 )
    {
        $imageurl = $story->DisplayElements('imageurl');
        if( !empty( $imageurl ))
        {
            $imageurl = COM_getTopicImageUrl( $imageurl );
            $article->set_var( 'story_topic_image_url', $imageurl );
            $topicimage = '<img src="' . $imageurl . '" class="float'
                        . $_CONF['article_image_align'] . '" alt="'
                        . $topicname . '" title="' . $topicname . '"' . XHTML . '>';
            $article->set_var( 'story_anchortag_and_image',
                COM_createLink(
                    $topicimage,
                    $topicurl,
                    array('rel'=>"category")
                )
            );
            $article->set_var( 'story_topic_image', $topicimage );
            $topicimage_noalign = '<img src="' . $imageurl . '" alt="'
                        . $topicname . '" title="' . $topicname . '"' . XHTML . '>';
            $article->set_var( 'story_anchortag_and_image_no_align',
                COM_createLink(
                    $topicimage_noalign,
                    $topicurl,
                    array('rel'=>"category")
                )
            );
            $article->set_var( 'story_topic_image_no_align',
                               $topicimage_noalign );
        }
    }
    $article->set_var( 'story_topic_url', $topicurl );

    $recent_post_anchortag = '';
    $articleUrl = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                                . $story->getSid());
    $article->set_var('story_title', $story->DisplayElements('title'));
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

    if(( $index == 'n' ) || ( $index == 'p' ))
    {
        if( empty( $bodytext ))
        {
            $article->set_var( 'story_introtext', $introtext );
            $article->set_var( 'story_text_no_br', $introtext );
        }
        else
        {
            if(( $_CONF['allow_page_breaks'] == 1 ) and ( $index == 'n' ))
            {
                $story_page = 1;

                // page selector
                if( is_numeric( $mode ))
                {
                    $story_page = $mode;
                    if( $story_page <= 0 )
                    {
                        $story_page = 1;
                        $mode = 0;
                    }
                    elseif( $story_page > 1 )
                    {
                        $introtext = '';
                    }
                }
                $article_array = explode( '[page_break]', $bodytext );
                $pagelinks = COM_printPageNavigation(
                    $articleUrl, $story_page, count( $article_array ),
                    'mode=', $_CONF['url_rewrite'], $LANG01[118]);
                if( count( $article_array ) > 1 )
                {
                    $bodytext = $article_array[$story_page - 1];
                }
                $article->set_var( 'page_selector', $pagelinks );

                if (
                     ( ($_CONF['page_break_comments'] == 'last')  and
                       ($story_page < count($article_array)) )
                    or
                     ( ($_CONF['page_break_comments'] == 'first')  and
                       ($story_page != 1) )
                   )
                {
                    $show_comments = false;
                }
                $article->set_var( 'story_page', $story_page );
            }

            $article->set_var('story_introtext', $introtext
                    . '<br' . XHTML . '><br' . XHTML . '>' . $bodytext);
            $article->set_var('story_text_no_br', $introtext . ' ' . $bodytext);
        }
        $article->set_var( 'story_introtext_only', $introtext );
        $article->set_var( 'story_bodytext_only', $bodytext );

        if(( $_CONF['trackback_enabled'] || $_CONF['pingback_enabled'] ) &&
                SEC_hasRights( 'story.ping' ))
        {
            $url = $_CONF['site_admin_url']
                 . '/trackback.php?mode=sendall&amp;id=' . $story->getSid();
            $article->set_var( 'send_trackback_link',
                COM_createLink($LANG_TRB['send_trackback'], $url)
            );
            $pingico = '<img src="' . $_CONF['layout_url'] . '/images/sendping.'
                . $_IMAGE_TYPE . '" alt="' . $LANG_TRB['send_trackback']
                . '" title="' . $LANG_TRB['send_trackback'] . '"' . XHTML . '>';
            $article->set_var( 'send_trackback_icon',
                COM_createLink($pingico, $url)
            );
            $article->set_var( 'send_trackback_url', $url );
            $article->set_var( 'lang_send_trackback_text',
                               $LANG_TRB['send_trackback'] );
        }
        $article->set_var( 'story_display',
                           ( $index == 'p' ) ? 'preview' : 'article' );
        $article->set_var( 'story_counter', 0 );
    }
    else
    {
        $article->set_var( 'story_introtext', $introtext );
        $article->set_var( 'story_text_no_br', $introtext );
        $article->set_var( 'story_introtext_only', $introtext );

        if($readmore)
        {
            $article->set_var( 'lang_readmore', $LANG01[2] );
            $article->set_var( 'lang_readmore_words', $LANG01[62] );
            $article->set_var( 'readmore_words', $numwords );

            $article->set_var( 'readmore_link',
                COM_createLink(
                    $LANG01[2],
                    $articleUrl,
                    array('class'=>'story-read-more-link')
                )
                . ' (' . $numwords . ' ' . $LANG01[62] . ') ' );
            $article->set_var('start_readmore_anchortag', '<a href="'
                    . $articleUrl . '" class="story-read-more-link">');
            $article->set_var('end_readmore_anchortag', '</a>');
            $article->set_var('read_more_class', 'class="story-read-more-link"');
        }

        if(( $story->DisplayElements('commentcode') >= 0 ) and ( $show_comments ))
        {
            $commentsUrl = COM_buildUrl( $_CONF['site_url']
                    . '/article.php?story=' . $story->getSid() ) . '#comments';
            $article->set_var( 'comments_url', $commentsUrl );
            $article->set_var( 'comments_text',
                    COM_numberFormat( $story->DisplayElements('comments') ) . ' ' . $LANG01[3] );
            $article->set_var( 'comments_count',
                    COM_numberFormat ( $story->DisplayElements('comments') ));
            $article->set_var( 'lang_comments', $LANG01[3] );
            $comments_with_count = sprintf( $LANG01[121], COM_numberFormat( $story->DisplayElements('comments') ));

            if( $story->DisplayElements('comments') > 0 )
            {
                $result = DB_query( "SELECT UNIX_TIMESTAMP(date) AS day,username,fullname,{$_TABLES['comments']}.uid as cuid FROM {$_TABLES['comments']},{$_TABLES['users']} WHERE {$_TABLES['users']}.uid = {$_TABLES['comments']}.uid AND sid = '".$story->getSid()."' ORDER BY date DESC LIMIT 1" );
                $C = DB_fetchArray( $result );

                $recent_post_anchortag = '<span class="storybyline">'
                        . $LANG01[27] . ': '
                        . strftime( $_CONF['daytime'], $C['day'] ) . ' '
                        . $LANG01[104] . ' ' . COM_getDisplayName ($C['cuid'],
                                                $C['username'], $C['fullname'])
                        . '</span>';
                $article->set_var( 'comments_with_count', COM_createLink($comments_with_count, $commentsUrl));
                $article->set_var( 'start_comments_anchortag', '<a href="'
                        . $commentsUrl . '">' );
                $article->set_var( 'end_comments_anchortag', '</a>' );
            }
            else
            {
                $article->set_var( 'comments_with_count', $comments_with_count);
                $recent_post_anchortag = COM_createLink($LANG01[60],
                    $_CONF['site_url'] . '/comment.php?sid=' . $story->getSid()
                        . '&amp;pid=0&amp;type=article');
            }
            if( $story->DisplayElements( 'commentcode' ) == 0 )
            {
                $postCommentUrl = $_CONF['site_url'] . '/comment.php?sid='
                            . $story->getSid() . '&amp;pid=0&amp;type=article';
                $article->set_var( 'post_comment_link',
                        COM_createLink($LANG01[60], $postCommentUrl,
                                       array('rel' => 'nofollow')));
            /*
                $article->set_var( 'subscribe_link',
                        COM_createLink('Nubbies', '', array('rel' => 'nofollow'))
                                 );
            */
                $article->set_var( 'lang_post_comment', $LANG01[60] );
                $article->set_var( 'start_post_comment_anchortag',
                                   '<a href="' . $postCommentUrl
                                   . '" rel="nofollow">' );
                $article->set_var( 'end_post_comment_anchortag', '</a>' );
            }
        }

        if(( $_CONF['trackback_enabled'] || $_CONF['pingback_enabled'] ) &&
                ( $story->DisplayElements('trackbackcode') >= 0 ) && ( $show_comments ))
        {
            $num_trackbacks = COM_numberFormat( $story->DisplayElements('trackbacks') );
            $trackbacksUrl = COM_buildUrl( $_CONF['site_url']
                    . '/article.php?story=' . $story->getSid() ) . '#trackback';
            $article->set_var( 'trackbacks_url', $trackbacksUrl );
            $article->set_var( 'trackbacks_text', $num_trackbacks . ' '
                                                  . $LANG_TRB['trackbacks'] );
            $article->set_var( 'trackbacks_count', $num_trackbacks );
            $article->set_var( 'lang_trackbacks', $LANG_TRB['trackbacks'] );
            $article->set_var( 'trackbacks_with_count',
                COM_createLink(
                    sprintf( $LANG01[122], $num_trackbacks ),
                    $trackbacksUrl
                )
            );

            if(SEC_hasRights( 'story.ping' ))
            {
                $pingurl = $_CONF['site_admin_url']
                    . '/trackback.php?mode=sendall&amp;id=' . $story->getSid();
                $pingico = '<img src="' . $_CONF['layout_url'] . '/images/sendping.'
                    . $_IMAGE_TYPE . '" alt="' . $LANG_TRB['send_trackback']
                    . '" title="' . $LANG_TRB['send_trackback'] . '"' . XHTML . '>';
                $article->set_var( 'send_trackback_icon',
                    COM_createLink($pingico, $pingurl)
                );
            }

            if( $story->DisplayElements('trackbacks') > 0 )
            {
                $article->set_var( 'trackbacks_with_count',
                    COM_createLink(
                        sprintf( $LANG01[122], $num_trackbacks ),
                        $trackbacksUrl
                    )
                );
            }
            else
            {
                $article->set_var( 'trackbacks_with_count',
                        sprintf( $LANG01[122], $num_trackbacks )
                );
            }
        }

        if(( $_CONF['hideemailicon'] == 1 ) ||
           ( COM_isAnonUser() &&
                (( $_CONF['loginrequired'] == 1 ) ||
                 ( $_CONF['emailstoryloginrequired'] == 1 ))))
        {
            $article->set_var( 'email_icon', '' );
        }
        else
        {
            $emailUrl = $_CONF['site_url'] . '/profiles.php?sid=' . $story->getSid()
                      . '&amp;what=emailstory';
            $emailicon = '<img src="' . $_CONF['layout_url'] . '/images/mail.'
                . $_IMAGE_TYPE . '" alt="' . $LANG01[64] . '" title="'
                . $LANG11[2] . '"' . XHTML . '>';
            $article->set_var( 'email_icon',
                COM_createLink($emailicon, $emailUrl)
            );
            $article->set_var( 'email_story_url', $emailUrl );
            $article->set_var( 'lang_email_story', $LANG11[2] );
            $article->set_var( 'lang_email_story_alt', $LANG01[64] );
        }
        $printUrl = COM_buildUrl( $_CONF['site_url'] . '/article.php?story='
                                  . $story->getSid() . '&amp;mode=print' );
        if( $_CONF['hideprintericon'] == 1 )
        {
            $article->set_var( 'print_icon', '' );
        }
        else
        {
            $printicon = '<img src="' . $_CONF['layout_url']
                . '/images/print.' . $_IMAGE_TYPE . '" alt="' . $LANG01[65]
                . '" title="' . $LANG11[3] . '"' . XHTML . '>';
            $article->set_var( 'print_icon',
                COM_createLink($printicon, $printUrl, array('rel' => 'nofollow'))
            );
            $article->set_var( 'print_story_url', $printUrl );
            $article->set_var( 'lang_print_story', $LANG11[3] );
            $article->set_var( 'lang_print_story_alt', $LANG01[65] );
        }
        $article->set_var( 'story_display', 'index' );

        $storycounter++;
        $article->set_var( 'story_counter', $storycounter );
    }
    $article->set_var( 'article_url', $articleUrl );
    $article->set_var( 'recent_post_anchortag', $recent_post_anchortag );

    if( $story->checkAccess() == 3 AND SEC_hasrights( 'story.edit' ) AND ( $index != 'p' ))
    {
        $article->set_var( 'edit_link',
            COM_createLink($LANG01[4], $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $story->getSid())
            );
        $article->set_var( 'edit_url', $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $story->getSid() );
        $article->set_var( 'lang_edit_text',  $LANG01[4] );
        $editicon = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
        $editiconhtml = '<img src="' . $editicon . '" alt="' . $LANG01[4] . '" title="' . $LANG01[4] . '"' . XHTML . '>';
        $article->set_var( 'edit_icon',
            COM_createLink(
                $editiconhtml,
                $_CONF['site_admin_url'] . '/story.php?mode=edit&amp;sid=' . $story->getSid()
            )
        );
        $article->set_var( 'edit_image', $editiconhtml);
    }

    if( $story->DisplayElements('featured') == 1 )
    {
        $article->set_var( 'lang_todays_featured_article', $LANG05[4] );
        $article->parse( 'story_bodyhtml', 'featuredbodytext', true );
        PLG_templateSetVars( 'featuredstorytext', $article );
        $article->parse( 'finalstory', 'featuredarticle' );
    }
    elseif( $story->DisplayElements('statuscode') == STORY_ARCHIVE_ON_EXPIRE AND $story->DisplayElements('expire') <= time() )
    {
        $article->parse( 'story_bodyhtml', 'archivestorybodytext', true );
        PLG_templateSetVars( 'archivestorytext', $article );
        $article->parse( 'finalstory', 'archivearticle' );
    }
    else
    {
        $article->parse( 'story_bodyhtml', 'bodytext', true );
        PLG_templateSetVars( 'storytext', $article );
        $article->parse( 'finalstory', 'article' );
    }

    return $article->finish( $article->get_var( 'finalstory' ));
}

/**
* Extract links from an HTML-formatted text.
*
* Collects all the links in a story and returns them in an array.
*
* @param    string  $fulltext   the text to search for links
* @param    int     $maxlength  max. length of text in a link (can be 0)
* @return   array   an array of strings of form <a href="...">link</a>
*
*/
function STORY_extractLinks( $fulltext, $maxlength = 26 )
{
    $rel = array();

    /* Only match anchor tags that contain 'href="<something>"'
     */
    preg_match_all( "/<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)<\/a>/i", $fulltext, $matches );
    for ( $i=0; $i< count( $matches[0] ); $i++ )
    {
        $matches[2][$i] = strip_tags( $matches[2][$i] );
        if ( !MBYTE_strlen( trim( $matches[2][$i] ) ) ) {
            $matches[2][$i] = strip_tags( $matches[1][$i] );
        }

        // if link is too long, shorten it and add ... at the end
        if ( ( $maxlength > 0 ) && ( MBYTE_strlen( $matches[2][$i] ) > $maxlength ) )
        {
            $matches[2][$i] = substr( $matches[2][$i], 0, $maxlength - 3 ) . '...';
        }

        $rel[] = '<a href="' . $matches[1][$i] . '">'
               . str_replace(array("\015", "\012"), '', $matches[2][$i])
               . '</a>';
    }

    return( $rel );
}

/**
* Create "What's Related" links for a story
*
* Creates an HTML-formatted list of links to be used for the What's Related
* block next to a story (in article view).
*
* @param        string      $related    contents of gl_stories 'related' field
* @param        int         $uid        user id of the author
* @param        int         $tid        topic id
* @return       string      HTML-formatted list of links
*/

function STORY_whatsRelated( $related, $uid, $tid )
{
    global $_CONF, $_TABLES, $LANG24;

    // get the links from the story text
    if (!empty ($related)) {
        $rel = explode ("\n", $related);
    } else {
        $rel = array ();
    }

    if( !COM_isAnonUser() || (( $_CONF['loginrequired'] == 0 ) &&
           ( $_CONF['searchloginrequired'] == 0 ))) {
        // add a link to "search by author"
        if( $_CONF['contributedbyline'] == 1 )
        {
            $author = COM_getDisplayName( $uid );
            $rel[] = "<a href=\"{$_CONF['site_url']}/search.php?mode=search&amp;type=stories&amp;author=$uid\">{$LANG24[37]} $author</a>";
        }

        // add a link to "search by topic"
        $topic = DB_getItem( $_TABLES['topics'], 'topic', "tid = '$tid'" );
        $rel[] = '<a href="' . $_CONF['site_url']
               . '/search.php?mode=search&amp;type=stories&amp;topic=' . $tid
               . '">' . $LANG24[38] . ' ' . stripslashes( $topic ) . '</a>';
    }

    $related = '';
    if( count( $rel ) > 0 )
    {
        $related = COM_checkWords( COM_makeList( $rel, 'list-whats-related' ));
    }

    return( $related );
}

/**
* Delete one image from a story
*
* Deletes scaled and unscaled image, but does not update the database.
*
* @param    string  $image  file name of the image (without the path)
*
*/
function STORY_deleteImage ($image)
{
    global $_CONF;

    if (empty ($image)) {
        return;
    }

    $filename = $_CONF['path_images'] . 'articles/' . $image;
    if (!@unlink ($filename)) {
        // log the problem but don't abort the script
        echo COM_errorLog ('Unable to remove the following image from the article: ' . $filename);
    }

    // remove unscaled image, if it exists
    $lFilename_large = substr_replace ($image, '_original.',
                                       strrpos ($image, '.'), 1);
    $lFilename_large_complete = $_CONF['path_images'] . 'articles/'
                              . $lFilename_large;
    if (file_exists ($lFilename_large_complete)) {
        if (!@unlink ($lFilename_large_complete)) {
            // again, log the problem but don't abort the script
            echo COM_errorLog ('Unable to remove the following image from the article: ' . $lFilename_large_complete);
        }
    }
}

/**
* Delete all images from a story
*
* Deletes all scaled and unscaled images from the file system and the database.
*
* @param    string  $sid    story id
*
*/
function STORY_deleteImages ($sid)
{
    global $_TABLES;

    $result = DB_query ("SELECT ai_filename FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid'");
    $nrows = DB_numRows ($result);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray ($result);
        STORY_deleteImage ($A['ai_filename']);
    }
    DB_delete ($_TABLES['article_images'], 'ai_sid', $sid);
}

/**
* Delete a story.
*
* This is used to delete a story from the list of stories.
*
* @param    string  $sid    ID of the story to delete
* @return   string          HTML, e.g. a meta redirect
*
*/
function STORY_deleteStory($sid)
{
    $args = array (
                    'sid' => $sid
                  );

    $output = '';

    PLG_invokeService('story', 'delete', $args, $output, $svc_msg);

    return $output;
}

/**
* Delete a story and related data immediately.
*
* Note: For internal use only! To delete a story, use STORY_deleteStory (see
*       above), which will do permission checks and eventually end up here.
*
* @param    string  $sid    ID of the story to delete
* @internal For internal use only!
*
*/
function STORY_doDeleteThisStoryNow($sid)
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'lib-comment.php';

    STORY_deleteImages($sid);
    DB_delete($_TABLES['comments'], array('sid', 'type'),
                                    array($sid, 'article'));
    DB_delete($_TABLES['trackback'], array('sid', 'type'),
                                     array($sid, 'article'));
    DB_delete($_TABLES['stories'], 'sid', $sid);

    // notify plugins
    PLG_itemDeleted($sid, 'article');

    // update RSS feed and Older Stories block
    COM_rdfUpToDateCheck();
    COM_olderStuff();
    CMT_updateCommentcodes();
}


/*
 * Implement *some* of the Plugin API functions for stories. While stories
 * aren't a plugin (and likely never will be), implementing some of the API
 * functions here will save us from doing special handling elsewhere.
 */
 
/**
* Return new Story comments for the What's New block
*
* @param    string  $numreturn  If 0 will return results for What's New Block. 
*                               If > 0 will return last X new comments for User Profile.
* @param    string  $uid        ID of the user to return results for. 0 = all users.
* @return   array list of new comments (dups, type, title, sid, lastdate) or (sid, title, cid, unixdate)
*
*/
function plugin_getwhatsnewcomment_story($numreturn = 0, $uid = 0)
{
    global $_CONF, $_TABLES;

    $topicsql = COM_getTopicSql ('AND', 0, $_TABLES['stories']);
    
    $stwhere = '';
    if( !COM_isAnonUser() ) {
        $stwhere .= "(({$_TABLES['stories']}.owner_id IS NOT NULL AND {$_TABLES['stories']}.perm_owner IS NOT NULL) OR ";
        $stwhere .= "({$_TABLES['stories']}.group_id IS NOT NULL AND {$_TABLES['stories']}.perm_group IS NOT NULL) OR ";
        $stwhere .= "({$_TABLES['stories']}.perm_members IS NOT NULL))";
    } else {
        $stwhere .= "({$_TABLES['stories']}.perm_anon IS NOT NULL)";
    }
    
    if ($uid > 0) {
        $stwhere .= " AND ({$_TABLES['comments']}.uid = $uid)";
    }
    if ($numreturn == 0 ) {
        $sql['mssql'] = "SELECT DISTINCT COUNT(*) AS dups, type, {$_TABLES['stories']}.title, {$_TABLES['stories']}.sid, max({$_TABLES['comments']}.date) AS lastdate FROM {$_TABLES['comments']} LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid) AND type = 'article' " . COM_getPermSQL( 'AND', 0, 2, $_TABLES['stories'] ) . " AND ({$_TABLES['stories']}.draft_flag = 0) AND ({$_TABLES['stories']}.commentcode >= 0)" . $topicsql . COM_getLangSQL( 'sid', 'AND', $_TABLES['stories'] ) . ") WHERE ({$_TABLES['comments']}.date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newcommentsinterval']} SECOND))) AND ((({$stwhere}))) GROUP BY {$_TABLES['comments']}.sid,type, {$_TABLES['stories']}.title, {$_TABLES['stories']}.title, {$_TABLES['stories']}.sid ORDER BY 5 DESC LIMIT 15";          
        $sql['mysql'] = "SELECT DISTINCT COUNT(*) AS dups, type, {$_TABLES['stories']}.title, {$_TABLES['stories']}.sid, max({$_TABLES['comments']}.date) AS lastdate FROM {$_TABLES['comments']} LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid) AND type = 'article' " . COM_getPermSQL( 'AND', 0, 2, $_TABLES['stories'] ) . " AND ({$_TABLES['stories']}.draft_flag = 0) AND ({$_TABLES['stories']}.commentcode >= 0)" . $topicsql . COM_getLangSQL( 'sid', 'AND', $_TABLES['stories'] ) . ") WHERE ({$_TABLES['comments']}.date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newcommentsinterval']} SECOND))) AND ((({$stwhere}))) GROUP BY {$_TABLES['comments']}.sid,type, {$_TABLES['stories']}.title, {$_TABLES['stories']}.title, {$_TABLES['stories']}.sid ORDER BY 5 DESC LIMIT 15";
        $sql['pgsql'] = "SELECT DISTINCT COUNT(*) AS dups, type, {$_TABLES['stories']}.title, {$_TABLES['stories']}.sid, max({$_TABLES['comments']}.date) AS lastdate FROM {$_TABLES['comments']} LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid) AND type = 'article' " . COM_getPermSQL( 'AND', 0, 2, $_TABLES['stories'] ) . " AND ({$_TABLES['stories']}.draft_flag = 0) AND ({$_TABLES['stories']}.commentcode >= 0)" . $topicsql . COM_getLangSQL( 'sid', 'AND', $_TABLES['stories'] ) . ") WHERE ({$_TABLES['comments']}.date >= (NOW()+ INTERVAL '{$_CONF['newcommentsinterval']} SECOND')) AND ((({$stwhere}))) GROUP BY {$_TABLES['comments']}.sid,type, {$_TABLES['stories']}.title, {$_TABLES['stories']}.title, {$_TABLES['stories']}.sid ORDER BY 5 DESC LIMIT 15";
    } else {
        $sql = "SELECT {$_TABLES['stories']}.sid, {$_TABLES['comments']}.title, cid, UNIX_TIMESTAMP({$_TABLES['comments']}.date) AS unixdate FROM {$_TABLES['comments']} LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid) AND type = 'article' " . COM_getPermSQL( 'AND', 0, 2, $_TABLES['stories'] ) . " AND ({$_TABLES['stories']}.draft_flag = 0) AND ({$_TABLES['stories']}.commentcode >= 0)" . $topicsql . COM_getLangSQL( 'sid', 'AND', $_TABLES['stories'] ) . ") WHERE ({$stwhere}) ORDER BY unixdate DESC LIMIT $numreturn";
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
*
* This is the story equivalent of PLG_getItemInfo. See lib-plugins.php for
* details.
*
* @param    string  $sid        story ID or '*'
* @param    string  $what       comma-separated list of story properties
* @param    int     $uid        user ID or 0 = current user
* @param    array   $options    (reserved for future extensions)
* @return   mixed               string or array of strings with the information
*
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
            $fields[] = 'UNIX_TIMESTAMP(date) AS unixdate';
            break;
        case 'description':
            $fields[] = 'introtext';
            $fields[] = 'bodytext';
            break;
        case 'excerpt':
            $fields[] = 'introtext';
            break;
        case 'feed':
            $fields[] = 'tid';
            break;
        case 'id':
            $fields[] = 'sid';
            break;
        case 'title':
            $fields[] = 'title';
            break;
        case 'url':
            // needed for $sid == '*', but also in case we're only requesting
            // the URL (so that $fields isn't emtpy)
            $fields[] = 'sid';
            break;
        default:
            // nothing to do
            break;
        }
    }

    $fields = array_unique($fields);

    if (count($fields) == 0) {
        $retval = array();

        return $retval;
    }

    // prepare SQL request
    if ($sid == '*') {
        $where = ' WHERE';
    } else {
        $where = " WHERE (sid = '" . addslashes($sid) . "') AND";
    }
    $where .= ' (draft_flag = 0) AND (date <= NOW())';
    if ($uid > 0) {
        $permSql = COM_getPermSql('AND', $uid)
                 . COM_getTopicSql('AND', $uid);
    } else {
        $permSql = COM_getPermSql('AND') . COM_getTopicSql('AND');
    }
    $sql = "SELECT " . implode(',', $fields)
            . " FROM {$_TABLES['stories']}" . $where . $permSql;
    if ($sid != '*') {
        $sql .= ' LIMIT 1';
    }

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    $retval = array();
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);

        $props = array();
        foreach ($properties as $p) {
            switch ($p) {
            case 'date-created':
                $props['date-created'] = $A['unixdate'];
                break;
            case 'description':
                $props['description'] = trim(PLG_replaceTags(stripslashes($A['introtext']) . ' ' . stripslashes($A['bodytext'])));
                break;
            case 'excerpt':
                $excerpt = stripslashes($A['introtext']);
                if (!empty($A['bodytext'])) {
                    $excerpt .= "\n\n" . stripslashes($A['bodytext']);
                }
                $props['excerpt'] = trim(PLG_replaceTags($excerpt));
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
*
*/
function plugin_wsEnabled_story()
{
    return true;
}

/**
* Returns list of moderation values
*
* The array returned contains (in order): the row 'id' label, main table,
* moderation fields (comma separated), and submission table
*
* @return   array       Returns array of useful moderation values
*
*/
function plugin_moderationvalues_story()
{
    global $_TABLES;

    return array(
        'sid',
        $_TABLES['stories'],
        'sid,uid,tid,title,introtext,date,postmode',
        $_TABLES['storysubmission']
    );
}

/**
* Performs story exclusive work for items deleted by moderation
*
* While moderation.php handles the actual removal from the submission
* table, within this function we handle all other deletion related tasks
*
* @param    string  $sid    Identifying string, i.e. the story id
* @return   string          Any wanted HTML output
*
*/
function plugin_moderationdelete_story($sid)
{
    global $_TABLES;

    DB_delete($_TABLES['storysubmission'], 'sid', $sid);

    return '';
}

/**
* Checks that the current user has the rights to moderate stories.
* Returns true if this is the case, false otherwise
*
* @return   boolean     Returns true if moderator
*
*/
function plugin_ismoderator_story()
{
    return SEC_hasRights('story.moderate');
}

/**
* Returns SQL & Language texts to moderation.php
*
* @return   mixed   Plugin object or void if not allowed
*
*/
function plugin_itemlist_story()
{
    global $_TABLES, $LANG29;

    if (plugin_ismoderator_story()) {
        $plugin = new Plugin();
        $plugin->submissionlabel = $LANG29[35];
        $plugin->submissionhelpfile = 'ccstorysubmission.html';
        $plugin->getsubmissionssql = "SELECT sid AS id,title,date,tid FROM {$_TABLES['storysubmission']}" . COM_getTopicSQL ('WHERE') . " ORDER BY date ASC";
        $plugin->addSubmissionHeading($LANG29[10]);
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
*
* The array returned contains (in order): the row 'id' label, main table,
* moderation fields (comma separated), and submission table
*
* @return   array       Returns array of useful moderation values
*
*/
function plugin_moderationvalues_story_draft()
{
    global $_TABLES;

    return array(
        'sid',
        $_TABLES['stories'],
        'sid,uid,tid,title,introtext,date,postmode',
        $_TABLES['stories']
    );
}

/**
* Performs draft story exclusive work for items deleted by moderation
*
* While moderation.php handles the actual removal from the submission
* table, within this function we handle all other deletion related tasks
*
* @param    string  $sid    Identifying string, i.e. the story id
* @return   string          Any wanted HTML output
*
*/
function plugin_moderationdelete_story_draft($sid)
{
    global $_TABLES;

    STORY_deleteStory($sid);

    return '';
}

/**
* Returns SQL & Language texts to moderation.php
*
* @return   mixed   Plugin object or void if not allowed
*
*/
function plugin_itemlist_story_draft()
{
    global $_TABLES, $LANG24, $LANG29;

    if (SEC_hasRights('story.edit')) {
        $plugin = new Plugin();
        $plugin->submissionlabel = $LANG29[35] . ' (' . $LANG24[34] . ')';
        $plugin->submissionhelpfile = 'ccdraftsubmission.html';
        $plugin->getsubmissionssql = "SELECT sid AS id,title,date,tid FROM {$_TABLES['stories']} WHERE (draft_flag = 1)" . COM_getTopicSQL ('AND') . COM_getPermSQL ('AND', 0, 3) . " ORDER BY date ASC";
        $plugin->addSubmissionHeading($LANG29[10]);
        $plugin->addSubmissionHeading($LANG29[14]);
        $plugin->addSubmissionHeading($LANG29[15]);

        return $plugin;
    }
}

/**
* "Approve" a draft story
*
* @param    string  $sid    story id
* @return   void
*
*/
function plugin_moderationapprove_story_draft($sid)
{
    global $_TABLES;

    DB_change($_TABLES['stories'], 'draft_flag', 0, 'sid', $sid);

    PLG_itemSaved($sid, 'article');

    // update feeds
    COM_rdfUpToDateCheck();

    // update Older Stories block
    COM_olderStuff();
}

/**
* Implements the [story:] autotag.
*
* @param    string  $op         operation to perform
* @param    string  $content    item (e.g. story text), including the autotag
* @param    array   $autotag    parameters used in the autotag
* @param    mixed               tag names (for $op='tagname') or formatted content
*
*/
function plugin_autotags_story($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES, $LANG24, $_GROUPS;

    if ($op == 'tagname' ) {
        return 'story';
    } elseif ($op == 'permission' || $op == 'nopermission') {
        if ($op == 'permission') {
            $flag = true;
        } else {
            $flag = false;
        }
        $tagnames = array();

        if (isset($_GROUPS['Story Admin'])) {
            $group_id = $_GROUPS['Story Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                   "grp_name = 'Story Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();

        if (COM_getPermTag($owner_id, $group_id, $_CONF['autotag_permissions_story'][0], $_CONF['autotag_permissions_story'][1], $_CONF['autotag_permissions_story'][2], $_CONF['autotag_permissions_story'][3]) == $flag) {
            $tagnames[] = 'story';
        }
        
        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'description') {
        return array (
            'story' => $LANG24['autotag_desc_story']
            );        
    } else {
        $sid = COM_applyFilter($autotag['parm1']);
        if (! empty($sid)) {
            $result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE sid = '$sid'" . COM_getPermSql('AND'));
            $A = DB_fetchArray($result);
            if ($A['count'] > 0) {

                $url = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                                    . $sid);
                $linktext = $autotag['parm2'];
                if (empty($linktext)) {
                    $linktext = stripslashes(DB_getItem($_TABLES['stories'],
                                                'title', "sid = '$sid'"));
                }
                $link = COM_createLink($linktext, $url);
                $content = str_replace($autotag['tagstr'], $link, $content);
            }
        }

        return $content;
    }
}


/*
 * START SERVICES SECTION
 * This section implements the various services offered by the story module
 */


/**
 * Submit a new or updated story. The story is updated if it exists, or a new one is created
 *
 * @param   array   args    Contains all the data provided by the client
 * @param   string  &output OUTPUT parameter containing the returned text
 * @return  int		    Response code as defined in lib-plugins.php
 */
function service_submit_story($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $_USER, $LANG24, $MESSAGE, $_GROUPS;

    if (!SEC_hasRights('story.edit')) {
        $output .= COM_siteHeader('menu', $MESSAGE[30])
                . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
                . COM_siteFooter();

        return PLG_RET_AUTH_FAILED;
    }

    require_once $_CONF['path_system'] . 'lib-comment.php';
    if (! $_CONF['disable_webservices']) {
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

    /* Store the first CATEGORY as the Topic ID */
    if (!empty($args['category'][0])) {
        $args['tid'] = $args['category'][0];
    }

    $content = '';
    if (!empty($args['content'])) {
        $content = $args['content'];
    } else if (!empty($args['summary'])) {
        $content = $args['summary'];
    }   
    if (!empty($content)) {
        $parts = explode('[page_break]', $content);
        if (count($parts) == 1) {
            $args['introtext'] = $content;
            $args['bodytext']  = '';
        } else {
            $args['introtext'] = array_shift($parts);
            $args['bodytext']  = implode('[page_break]', $parts);
        }
    }

    /* Apply filters to the parameters passed by the webservice */

    if ($args['gl_svc']) {
        if (isset($args['mode'])) {
            $args['mode'] = COM_applyBasicFilter($args['mode']);
        }
        if (isset($args['editopt'])) {
            $args['editopt'] = COM_applyBasicFilter($args['editopt']);
        }
    }

    /* - START: Set all the defaults - */

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
    }

    if(empty($args['owner_id'])) {
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
            } else if (($args['content_type'] == 'html')
                    || ($args['content_type'] == 'xhtml')) {
                $args['postmode'] = 'html';
            }
        }
    }

    if ($args['gl_svc']) {

        /* Permissions */
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
    /* - END: Set all the defaults - */

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
    $args['sid'] = COM_sanitizeID($args['sid']);
    if (!$gl_edit) {
        if (strlen($args['sid']) > STORY_MAX_ID_LENGTH) {
            $slug = '';
            if (isset($args['slug'])) {
                $slug = $args['slug'];
            }
            if (function_exists('WS_makeId')) {
                $args['sid'] = WS_makeId($slug, STORY_MAX_ID_LENGTH);
            } else {
                $args['sid'] = COM_makeSid();
            }
        }
    }
    $story = new Story();

    $gl_edit = false;
    if (isset($args['gl_edit'])) {
        $gl_edit = $args['gl_edit'];
    }
    if ($gl_edit && !empty($args['gl_etag'])) {
        /* First load the original story to check if it has been modified */
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

    /* This function is also doing the security checks */
    $result = $story->loadFromArgsArray($args);

    $sid = $story->getSid();

    switch ($result) {
    case STORY_DUPLICATE_SID:
        $output .= COM_siteHeader ('menu', $LANG24[5]);
        $output .= COM_errorLog ($LANG24[24], 2);
        if (!$args['gl_svc']) {
            $output .= storyeditor ($sid);
        }
        $output .= COM_siteFooter ();
        return PLG_RET_ERROR;
    case STORY_EXISTING_NO_EDIT_PERMISSION:
        $output .= COM_siteHeader('menu', $MESSAGE[30])
                . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
                . COM_siteFooter ();
        COM_accessLog("User {$_USER['username']} tried to illegally submit or edit story $sid.");
        return PLG_RET_PERMISSION_DENIED;
    case STORY_NO_ACCESS_PARAMS:
        $output .= COM_siteHeader('menu', $MESSAGE[30])
                . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
                . COM_siteFooter ();
        COM_accessLog("User {$_USER['username']} tried to illegally submit or edit story $sid.");
        return PLG_RET_PERMISSION_DENIED;
    case STORY_EMPTY_REQUIRED_FIELDS:
        $output .= COM_siteHeader('menu');
        $output .= COM_errorLog($LANG24[31],2);
        if (!$args['gl_svc']) {
            $output .= storyeditor($sid);
        }
        $output .= COM_siteFooter();
        return PLG_RET_ERROR;
    default:
        break;
    }

    /* Image upload is not supported by the web-service at present */
    if (!$args['gl_svc']) {
        // Delete any images if needed
        if (array_key_exists('delete', $args)) {
            $delete = count($args['delete']);
            for ($i = 1; $i <= $delete; $i++) {
                $ai_filename = DB_getItem ($_TABLES['article_images'],'ai_filename', "ai_sid = '{$sid}' AND ai_img_num = " . key($args['delete']));
            STORY_deleteImage ($ai_filename);

                DB_query ("DELETE FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' AND ai_img_num = " . key($args['delete']));
                next($args['delete']);
            }
        }

        // OK, let's upload any pictures with the article
        if (DB_count($_TABLES['article_images'], 'ai_sid', $sid) > 0) {
            $index_start = DB_getItem($_TABLES['article_images'],'max(ai_img_num)',"ai_sid = '$sid'") + 1;
        } else {
            $index_start = 1;
        }

        if (count($_FILES) > 0 AND $_CONF['maximagesperarticle'] > 0) {
            require_once($_CONF['path_system'] . 'classes/upload.class.php');
            $upload = new upload();

            if (isset ($_CONF['debug_image_upload']) && $_CONF['debug_image_upload']) {
                $upload->setLogFile ($_CONF['path'] . 'logs/error.log');
                $upload->setDebug (true);
            }
            $upload->setMaxFileUploads ($_CONF['maximagesperarticle']);
            if (!empty($_CONF['image_lib'])) {
                if ($_CONF['image_lib'] == 'imagemagick') {
                    // Using imagemagick
                    $upload->setMogrifyPath ($_CONF['path_to_mogrify']);
                } elseif ($_CONF['image_lib'] == 'netpbm') {
                    // using netPBM
                    $upload->setNetPBM ($_CONF['path_to_netpbm']);
                } elseif ($_CONF['image_lib'] == 'gdlib') {
                    // using the GD library
                    $upload->setGDLib ();
                }
                $upload->setAutomaticResize(true);
                if ($_CONF['keep_unscaled_image'] == 1) {
                    $upload->keepOriginalImage (true);
                } else {
                    $upload->keepOriginalImage (false);
                }
                if (isset($_CONF['jpeg_quality'])) {
                    $upload->setJpegQuality($_CONF['jpeg_quality']);
                }
            }
            $upload->setAllowedMimeTypes (array (
                    'image/gif'   => '.gif',
                    'image/jpeg'  => '.jpg,.jpeg',
                    'image/pjpeg' => '.jpg,.jpeg',
                    'image/x-png' => '.png',
                    'image/png'   => '.png'
                    ));
            if (!$upload->setPath($_CONF['path_images'] . 'articles')) {
                $output = COM_siteHeader ('menu', $LANG24[30]);
                $output .= COM_startBlock ($LANG24[30], '', COM_getBlockTemplate ('_msg_block', 'header'));
                $output .= $upload->printErrors (false);
                $output .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
                $output .= COM_siteFooter ();
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
            $filenames = array();
            $end_index = $index_start + $upload->numFiles() - 1;
            for ($z = $index_start; $z <= $end_index; $z++) {
                $curfile = current($_FILES);
                if (!empty($curfile['name'])) {
                    $pos = strrpos($curfile['name'],'.') + 1;
                    $fextension = substr($curfile['name'], $pos);
                    $filenames[] = $sid . '_' . $z . '.' . $fextension;
                }
                next($_FILES);
            }
            $upload->setFileNames($filenames);
            reset($_FILES);
            $upload->uploadFiles();

            if ($upload->areErrors()) {
                $retval = COM_siteHeader('menu', $LANG24[30]);
                $retval .= COM_startBlock ($LANG24[30], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
                $retval .= $upload->printErrors(false);
                $retval .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
                $retval .= COM_siteFooter();
                echo $retval;
                exit;
            }

            reset($filenames);
            for ($z = $index_start; $z <= $end_index; $z++) {
                DB_query("INSERT INTO {$_TABLES['article_images']} (ai_sid, ai_img_num, ai_filename) VALUES ('$sid', $z, '" . current($filenames) . "')");
                next($filenames);
            }
        }

        if ($_CONF['maximagesperarticle'] > 0) {
            $errors = $story->insertImages();
            if (count($errors) > 0) {
                $output = COM_siteHeader ('menu', $LANG24[54]);
                $output .= COM_startBlock ($LANG24[54], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
                $output .= $LANG24[55] . '<p>';
                for ($i = 1; $i <= count($errors); $i++) {
                    $output .= current($errors) . '<br' . XHTML . '>';
                    next($errors);
                }
                $output .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
                $output .= storyeditor($sid);
                $output .= COM_siteFooter();
                echo $output;
                exit;
            }
        }
    }

    $result = $story->saveToDatabase();

    if ($result == STORY_SAVED) {
        // see if any plugins want to act on that story
        if ((! empty($args['old_sid'])) && ($args['old_sid'] != $sid)) {
            PLG_itemSaved($sid, 'article', $args['old_sid']);
        } else {
            PLG_itemSaved($sid, 'article');
        }

        // update feed(s) and Older Stories block
        COM_rdfUpToDateCheck('article', $story->DisplayElements('tid'), $sid);
        COM_olderStuff();
        CMT_updateCommentcodes();

        if ($story->type == 'submission') {
            $output = COM_refresh ($_CONF['site_admin_url'] . '/moderation.php?msg=9');
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
 * @param   array   args    Contains all the data provided by the client
 * @param   string  &output OUTPUT parameter containing the returned text
 * @return  int		    Response code as defined in lib-plugins.php
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

    $result = DB_query ("SELECT tid,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'");
    $A = DB_fetchArray ($result);
    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
                             $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    $access = min ($access, SEC_hasTopicAccess ($A['tid']));
    if ($access < 3) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete story $sid.");
        $output = COM_refresh ($_CONF['site_admin_url'] . '/story.php');
        if ($_USER['uid'] > 1) {
            return PLG_RET_PERMISSION_DENIED;
        } else {
            return PLG_RET_AUTH_FAILED;
        }
    }

    STORY_doDeleteThisStoryNow($sid);

    $output = COM_refresh($_CONF['site_admin_url'] . '/story.php?msg=10');

    return PLG_RET_OK;
}

/**
 * Get an existing story
 *
 * @param   array   args    Contains all the data provided by the client
 * @param   string  &output OUTPUT parameter containing the returned text
 * @return  int		    Response code as defined in lib-plugins.php
 */
function service_get_story($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $_USER;

    $output = array();
    $retval = '';

    if (!isset($_CONF['atom_max_stories'])) {
        $_CONF['atom_max_stories'] = 10; // set a resonable default
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
                                    'perm_anon'
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

        $story = new Story();

        $retval = $story->loadFromDatabase($sid, $mode);

        if ($retval != STORY_LOADED_OK) {
            $output = $retval;
            return PLG_RET_ERROR;
        }

        reset($story->_dbFields);

        while (list($fieldname,$save) = each($story->_dbFields)) {
            $varname = '_' . $fieldname;
            $output[$fieldname] = $story->{$varname};
        }
        $output['username'] = $story->_username;
        $output['fullname'] = $story->_fullname;

        if ($args['gl_svc']) {
            if (($output['statuscode'] == STORY_ARCHIVE_ON_EXPIRE) ||
                ($output['statuscode'] == STORY_DELETE_ON_EXPIRE)) {
                // This date format is PHP 5 only,
                // but only the web-service uses the value
                $output['expire_date']  = date('c', $output['expire']);
            }
            $output['id']           = $output['sid'];
            $output['category']     = array($output['tid']);
            $output['published']    = date('c', $output['date']);
            $output['updated']      = date('c', $output['date']);
            if (empty($output['bodytext'])) {
                $output['content']  = $output['introtext'];
            } else {
                $output['content']  = $output['introtext'] . LB
                                    . '[page_break]' . LB . $output['bodytext'];
            }
            $output['content_type'] = ($output['postmode'] == 'html')
                                    ? 'html' : 'text';

            $owner_data = SESS_getUserDataFromId($output['owner_id']);

            $output['author_name']  = $owner_data['username'];

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
        = "SELECT STRAIGHT_JOIN s.*, UNIX_TIMESTAMP(s.date) AS unixdate, UNIX_TIMESTAMP(s.expire) as expireunix, "
            . "u.username, u.fullname, u.photo, u.email, t.topic, t.imageurl " . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, {$_TABLES['topics']} AS t " . "WHERE (s.uid = u.uid) AND (s.tid = t.tid)" . COM_getPermSQL('AND', $_USER['uid'], 2, 's') . $order . $limit;

        $sql['mssql'] =
            "SELECT STRAIGHT_JOIN s.sid, s.uid, s.draft_flag, s.tid, s.date, s.title, CAST(s.introtext AS text) AS introtext, CAST(s.bodytext AS text) AS bodytext, s.hits, s.numemails, s.comments, s.trackbacks, s.related, s.featured, s.show_topic_icon, s.commentcode, s.trackbackcode, s.statuscode, s.expire, s.postmode, s.frontpage, s.owner_id, s.group_id, s.perm_owner, s.perm_group, s.perm_members, s.perm_anon, s.advanced_editor_mode, " . " UNIX_TIMESTAMP(s.date) AS unixdate, UNIX_TIMESTAMP(s.expire) as expireunix, " . "u.username, u.fullname, u.photo, u.email, t.topic, t.imageurl " . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, {$_TABLES['topics']} AS t " . "WHERE (s.uid = u.uid) AND (s.tid = t.tid)" . COM_getPermSQL('AND', $_USER['uid'], 2, 's') . $order . $limit;

        $sql['pgsql'] = "SELECT  s.*, UNIX_TIMESTAMP(s.date) AS unixdate, UNIX_TIMESTAMP(s.expire) as expireunix, u.username, u.fullname, u.photo, u.email, t.topic, t.imageurl  FROM stories s, users u, topics t WHERE (s.uid = u.uid) AND (s.tid = t.tid) FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, {$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (s.tid = t.tid)" . COM_getPermSQL('AND', $_USER['uid'], 2, 's') . $order . $limit_pgsql;
        $result = DB_query($sql);

        $count = 0;

        while (($story_array = DB_fetchArray($result, false)) !== false) {

            $count += 1;
            if ($count == $max_items) {
                $svc_msg['offset'] = $offset + $_CONF['atom_max_stories'];
                break;
            }

            $story = new Story();

            $story->loadFromArray($story_array);

            // This access check is not strictly necessary
            $access = SEC_hasAccess($story_array['owner_id'], $story_array['group_id'], $story_array['perm_owner'], $story_array['perm_group'],
                                $story_array['perm_members'], $story_array['perm_anon']);
            $story->_access = min($access, SEC_hasTopicAccess($story->_tid));

            if ($story->_access == 0) {
                continue;
            }

            $story->_sanitizeData();

            reset($story->_dbFields);

            $output_item = array ();

            while (list($fieldname,$save) = each($story->_dbFields)) {
                $varname = '_' . $fieldname;
                $output_item[$fieldname] = $story->{$varname};
            }

            if ($args['gl_svc']) {
                if (($output_item['statuscode'] == STORY_ARCHIVE_ON_EXPIRE) ||
                    ($output_item['statuscode'] == STORY_DELETE_ON_EXPIRE)) {
                    // This date format is PHP 5 only,
                    // but only the web-service uses the value
                    $output_item['expire_date']  = date('c', $output_item['expire']);
                }
                $output_item['id']           = $output_item['sid'];
                $output_item['category']     = array($output_item['tid']);
                $output_item['published']    = date('c', $output_item['date']);
                $output_item['updated']      = date('c', $output_item['date']);
                if (empty($output_item['bodytext'])) {
                    $output_item['content']  = $output_item['introtext'];
                } else {
                    $output_item['content']  = $output_item['introtext'] . LB
                            . '[page_break]' . LB . $output_item['bodytext'];
                }
                $output_item['content_type'] = ($output_item['postmode'] == 'html') ? 'html' : 'text';

                $owner_data = SESS_getUserDataFromId($output_item['owner_id']);

                $output_item['author_name']  = $owner_data['username'];
            }
            $output[] = $output_item;
        }
    }

    return PLG_RET_OK;
}

/**
 * Get all the topics available
 *
 * @param   array   args    Contains all the data provided by the client
 * @param   string  &output OUTPUT parameter containing the returned text
 * @return  int         Response code as defined in lib-plugins.php
 */
function service_getTopicList_story($args, &$output, &$svc_msg)
{
    $output = COM_topicArray('tid');

    return PLG_RET_OK;
}

/*
 * END SERVICES SECTION
 */

?>
