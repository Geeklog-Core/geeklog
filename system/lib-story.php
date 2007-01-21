<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | lib-story.php                                                             |
// |                                                                           |
// | Story-related functions needed in more than one place.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
//
// $Id: lib-story.php,v 1.78 2007/01/21 10:12:36 mjervis Exp $
require_once ($_CONF['path_system'] . '/classes/story.class.php');

if (strpos ($_SERVER['PHP_SELF'], 'lib-story.php') !== false) {
    die ('This file can not be used on its own!');
}

if( $_CONF['allow_user_photo'] )
{
    // only needed for the USER_getPhoto function
    require_once ($_CONF['path_system'] . 'lib-user.php');
}

/**
 * Takes an article class and renders HTML in the specified template and style.
 *
 * Formats the given article into HTML. Called by index.php, article.php,
 * submit.php and admin/story.php (Preview mode for the last two).
 *
 * @param   object  $story      The story to display, an instance of the Story class.
 * @param   string  $index      n = 'Compact display' for list of stories. p = 'Preview' mode. Else full display of article.
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

    $introtext = $story->displayElements('introtext');
    $bodytext = $story->displayElements('bodytext');

    if( !empty( $query ))
    {
        $introtext = COM_highlightQuery( $introtext, $query );
        $bodytext  = COM_highlightQuery( $bodytext, $query );
    }


    $article = new Template( $_CONF['path_layout'] );
    $article->set_file( array(
            'article'          => $storytpl,
            'bodytext'         => 'storybodytext.thtml',
            'featuredarticle'  => 'featuredstorytext.thtml',
            'featuredbodytext' => 'featuredstorybodytext.thtml',
            'archivearticle'   => 'archivestorytext.thtml',
            'archivebodytext'  => 'archivestorybodytext.thtml'
            ));

    $article->set_var( 'layout_url', $_CONF['layout_url'] );
    $article->set_var( 'site_url', $_CONF['site_url'] );
    $article->set_var( 'story_date', $story->DisplayElements('date') );
    $article->set_var( 'story_date_short', $story->DisplayElements('shortdate') );
    $article->set_var( 'story_date_only', $story->DisplayElements('dateonly') );
    if( $_CONF['hideviewscount'] != 1 ) {
        $article->set_var( 'lang_views', $LANG01[106] );
        $article->set_var( 'story_hits', $story->DisplayElements('hits') );
    }
    $article->set_var( 'story_id', $story->getSid() );

    if( $_CONF['contributedbyline'] == 1 )
    {
        $article->set_var( 'lang_contributed_by', $LANG01[1] );
        $article->set_var( 'contributedby_uid', $story->DisplayElements('uid') );
        $fullname = $story->DisplayElements('fullname');
        $article->set_var( 'contributedby_user', $story->DisplayElements('username') );
        if (empty ($fullname)) {
            $article->set_var( 'contributedby_fullname', $story->DisplayElements('username') );
        } else {
            $article->set_var( 'contributedby_fullname',$story->DisplayElements('fullname') );
        }
        $authorname = COM_getDisplayName( $story->DisplayElements('uid'), $story->DisplayElements('username'), $fullname );
        $article->set_var( 'contributedby_author', $authorname );
        $article->set_var( 'author', $authorname );

        if( $story->DisplayElements('uid') > 1 )
        {
            $profileUrl = $_CONF['site_url']
                        . '/users.php?mode=profile&amp;uid=' . $story->DisplayElements('uid');
            $article->set_var( 'start_contributedby_anchortag',
                    '<a class="storybyline" href="' . $profileUrl . '">' );
            $article->set_var( 'end_contributedby_anchortag', '</a>' );
            $article->set_var( 'contributedby_url', $profileUrl );
        }

        $photo = '';
        if( $_CONF['allow_user_photo'] )
        {
            $photo = USER_getPhoto( $story->DisplayElements('uid'), $story->DisplayElements('photo') );
        }
        if( !empty( $photo ))
        {
            $article->set_var( 'contributedby_photo', $photo );
            $article->set_var( 'camera_icon', '<a href="' . $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $story->DisplayElements('uid')
                    . '"><img src="' . $_CONF['layout_url']
                    . '/images/smallcamera.' . $_IMAGE_TYPE
                    . '" alt=""></a>' );
        }
        else
        {
            $article->set_var( 'contributedby_photo', '' );
            $article->set_var( 'camera_icon', '' );
        }
    }

    $article->set_var( 'story_topic_id', $story->DisplayElements('tid') );
    $article->set_var( 'story_topic_name', $story->DisplayElements('topic') );

    $topicurl = $_CONF['site_url'] . '/index.php?topic=' . $story->DisplayElements('tid');
    if(( !isset( $_USER['noicons'] ) OR ( $_USER['noicons'] != 1 )) AND
            $story->DisplayElements('show_topic_icon') == 1 )
    {
        $imageurl = $story->DisplayElements('imageurl');
        if( !empty( $imageurl ))
        {
            $imageurl = COM_getTopicImageUrl( $imageurl );
            $topicimage = '<img align="' . $_CONF['article_image_align']
                        . '" src="' . $imageurl . '" alt="' . $topicname
                        . '" title="' . $topicname . '">';
            $article->set_var( 'story_anchortag_and_image', '<a href="'
                        . $topicurl . '" rel="category tag">' . $topicimage
                        . '</a>' );
            $article->set_var( 'story_topic_image', $topicimage );
        }
    }
    $article->set_var( 'story_topic_url', $topicurl );

    $recent_post_anchortag = '';
    $articleUrl = COM_buildUrl( $_CONF['site_url'] . '/article.php?story='
                                . $story->getSid() );
    $article->set_var( 'story_title', $story->DisplayElements('title'));
    $article->set_var( 'lang_permalink' $_LANG01[127] );

    $show_comments = true;
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
                $pagelinks = COM_printPageNavigation( $articleUrl, $story_page,
                                                      count( $article_array ),
                                                      'mode=',
                                                      $_CONF['url_rewrite'],
                                                      $LANG01[118]
                                                      );
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

            $article->set_var( 'story_introtext', $introtext . '<br><br>'
                               . $bodytext );
            $article->set_var( 'story_text_no_br', $introtext . $bodytext );
        }
        $article->set_var( 'story_introtext_only', $introtext );
        $article->set_var( 'story_bodytext_only', $bodytext );

        if(( $_CONF['trackback_enabled'] || $_CONF['pingback_enabled'] ) &&
                SEC_hasRights( 'story.ping' ))
        {
            $url = $_CONF['site_admin_url']
                 . '/trackback.php?mode=sendall&amp;id=' . $story->getSid();
            $article->set_var( 'send_trackback_link', '<a href="' . $url . '">'
                 . $LANG_TRB['send_trackback'] . '</a>' );
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

        if( !empty( $bodytext ))
        {
            $article->set_var( 'lang_readmore', $LANG01[2] );
            $article->set_var( 'lang_readmore_words', $LANG01[62] );
            $numwords = COM_NumberFormat (sizeof( explode( ' ', strip_tags( $bodytext ))));
            $article->set_var( 'readmore_words', $numwords );

            $article->set_var( 'readmore_link', '<a href="' . $articleUrl
                    . '" class="story-read-more-link">' . $LANG01[2] . '</a> ('
                    . $numwords . ' ' . $LANG01[62] . ') ' );
            $article->set_var( 'start_readmore_anchortag', '<a href="'
                    . $articleUrl . '" class="story-read-more-link">' );
            $article->set_var( 'end_readmore_anchortag', '</a>' );
            $article->set_var( 'read_more_class', 'class="story-read-more"' );
        }
        $article->set_var( 'start_storylink_anchortag', '<a href="'
                . $articleUrl . '" class="non-ul">' );
        $article->set_var( 'end_storylink_anchortag', '</a>' );

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
            $article->set_var( 'comments_with_count',
                    sprintf( $LANG01[121], COM_numberFormat( $story->DisplayElements('comments') )));

            if( $story->DisplayElements('comments') > 0 )
            {
                $result = DB_query( "SELECT UNIX_TIMESTAMP(date) AS day,username,fullname,{$_TABLES['comments']}.uid as cuid FROM {$_TABLES['comments']},{$_TABLES['users']} WHERE {$_TABLES['users']}.uid = {$_TABLES['comments']}.uid AND sid = '".$story->getsid()."' ORDER BY date desc LIMIT 1" );
                $C = DB_fetchArray( $result );

                $recent_post_anchortag = '<span class="storybyline">'
                        . $LANG01[27] . ': '
                        . strftime( $_CONF['daytime'], $C['day'] ) . ' '
                        . $LANG01[104] . ' ' . COM_getDisplayName ($C['cuid'],
                                                $C['username'], $C['fullname'])
                        . '</span>';
                $article->set_var( 'start_comments_anchortag', '<a href="'
                        . $commentsUrl . '">' );
                $article->set_var( 'end_comments_anchortag', '</a>' );
            }
            else
            {
                $recent_post_anchortag = ' <a href="' . $_CONF['site_url']
                        . '/comment.php?sid=' . $story->getsid()
                        . '&amp;pid=0&amp;type=article">' . $LANG01[60] . '</a>';
            }
            $postCommentUrl = $_CONF['site_url'] . '/comment.php?sid='
                            . $story->getSid() . '&amp;pid=0&amp;type=article';
            $article->set_var( 'post_comment_link','<a href="'
                    . $postCommentUrl . '">' . $LANG01[60] . '</a>' );
            $article->set_var( 'lang_post_comment', $LANG01[60] );
            $article->set_var( 'start_post_comment_anchortag',
                               '<a href="' . $postCommentUrl . '">' );
            $article->set_var( 'end_post_comment_anchortag', '</a>' );
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
                               sprintf( $LANG01[122], $num_trackbacks ));

            if( $story->DisplayElements('trackbacks') > 0 )
            {
                $article->set_var( 'start_trackbacks_anchortag', '<a href="'
                        . $trackbacksUrl . '">' );
                $article->set_var( 'end_trackbacks_anchortag', '</a>' );
            }
        }

        if(( $_CONF['hideemailicon'] == 1 ) ||
           ( empty( $_USER['username'] ) &&
                (( $_CONF['loginrequired'] == 1 ) ||
                 ( $_CONF['emailstoryloginrequired'] == 1 ))))
        {
            $article->set_var( 'email_icon', '' );
        }
        else
        {
            $emailUrl = $_CONF['site_url'] . '/profiles.php?sid=' . $story->getSid()
                      . '&amp;what=emailstory';
            $article->set_var( 'email_icon', '<a href="' . $emailUrl . '">'
                . '<img src="' . $_CONF['layout_url'] . '/images/mail.'
                . $_IMAGE_TYPE . '" alt="' . $LANG01[64] . '" title="'
                . $LANG11[2] . '"></a>' );
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
            $article->set_var( 'print_icon', '<a href="' . $printUrl . '">'
                . '<img src="' . $_CONF['layout_url']
                . '/images/print.' . $_IMAGE_TYPE . '" alt="' . $LANG01[65]
                . '" title="' . $LANG11[3] . '"></a>' );
            $article->set_var( 'print_story_url', $printUrl );
            $article->set_var( 'lang_print_story', $LANG11[3] );
            $article->set_var( 'lang_print_story_alt', $LANG01[65] );
        }
        if( $_CONF['pdf_enabled'] == 1 )
        {
            $pdfUrl = $_CONF['site_url'] . '/pdfgenerator.php?pageType=2&amp;'
                    . 'pageData=' . urlencode( $printUrl );
            $article->set_var( 'pdf_icon',
                sprintf( '<a href="%s"><img src="%s/images/pdf.'
                         . $_IMAGE_TYPE . '" alt="%s" title="%s"></a>',
                         $pdfUrl, $_CONF['layout_url'], $LANG01[111], $LANG11[5] ));
            $article->set_var( 'pdf_story_url', $pdfUrl );
            $article->set_var( 'lang_pdf_story', $LANG11[5] );
            $article->set_var( 'lang_pdf_story_alt', $LANG01[111] );
        }
        else
        {
            $article->set_var( 'pdf_icon', '' );
        }
        $article->set_var( 'story_display', 'index' );

        $storycounter++;
        $article->set_var( 'story_counter', $storycounter );
    }
    $article->set_var( 'article_url', $articleUrl );
    $article->set_var( 'recent_post_anchortag', $recent_post_anchortag );

    if( $story->checkAccess() == 3 AND SEC_hasrights( 'story.edit' ) AND ( $index != 'p' ))
    {
        $article->set_var( 'edit_link', '<a href="' . $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $story->getSid() . '">'
                . $LANG01[4] . '</a>' );
        $article->set_var( 'edit_url', $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $story->getSid() );
        $article->set_var( 'lang_edit_text',  $LANG01[4] );
        $editicon = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
        $article->set_var( 'edit_icon', '<a href="' . $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $story->getSid() . '"><img src="'
                . $editicon . '" alt="' . $LANG01[4] . '" title="' . $LANG01[4]
                . '"></a>' );
        $article->set_var( 'edit_image',  '<img src="' . $editicon . '" alt="'
                . $LANG01[4] . '" title="' . $LANG01[4] . '">' );
    }

    if( $story->DisplayElements('featured') == 1 )
    {
        $article->set_var( 'lang_todays_featured_article', $LANG05[4] );
        $article->parse( 'story_bodyhtml', 'featuredbodytext', true );
        $article->parse( 'finalstory', 'featuredarticle' );
    }
    elseif( $story->DisplayElements('statuscode') == 10 AND $story->DisplayElements('expire') <= time() )
    {
        $article->parse( 'story_bodyhtml', 'archivestorybodytext', true );
        $article->parse( 'finalstory', 'archivearticle' );
    }
    else
    {
        $article->parse( 'story_bodyhtml', 'bodytext', true );
        $article->parse( 'finalstory', 'article' );
    }

    return $article->finish( $article->get_var( 'finalstory' ));
}

// Story Record Options for the STATUS Field
if (!defined ('STORY_ARCHIVE_ON_EXPIRE')) {
    define ('STORY_ARCHIVE_ON_EXPIRE', '10');
    define ('STORY_DELETE_ON_EXPIRE',  '11');
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
               . str_replace ("/(\015\012)|(\015)|(\012)/", '', $matches[2][$i])
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
    global $_CONF, $_TABLES, $_USER, $LANG24;

    // get the links from the story text
    if (!empty ($related)) {
        $rel = explode ("\n", $related);
    } else {
        $rel = array ();
    }

    if( !empty( $_USER['username'] ) || (( $_CONF['loginrequired'] == 0 ) &&
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
    if( sizeof( $rel ) > 0 )
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
* Return information for a story
*
* This is the story equivalent of PLG_getItemInfo. See lib-plugins.php for
* details.
*
* @param    string  $sid    story ID
* @param    string  $what   comma-separated list of story properties
* @return   mixed           string or array of strings with the information
*
*/
function STORY_getItemInfo ($sid, $what)
{
    global $_CONF, $_TABLES;

    $properties = explode (',', $what);
    $fields = array ();
    foreach ($properties as $p) {
        switch ($p) {
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
            case 'title':
                $fields[] = 'title';
                break;
            default: // including 'url'
                // nothing to do
                break;
        }
    }

    if (count ($fields) > 0) {
        $result = DB_query ("SELECT " . implode (',', $fields)
                    . " FROM {$_TABLES['stories']} WHERE sid = '$sid'"
                    . COM_getPermSql ('AND') . COM_getTopicSql ('AND'));
        $A = DB_fetchArray ($result);
    } else {
        $A = array ();
    }

    $retval = array ();
    foreach ($properties as $p) {
        switch ($p) {
            case 'description':
                $retval[] = trim (PLG_replaceTags (stripslashes ($A['introtext']) . ' ' . stripslashes ($A['bodytext'])));
                break;
            case 'excerpt':
                $excerpt = stripslashes ($A['introtext']);
                if (!empty ($A['bodytext'])) {
                    $excerpt .= "\n\n" . stripslashes ($A['bodytext']);
                }
                $retval[] = trim (PLG_replaceTags ($excerpt));
                break;
            case 'feed':
                $feedfile = DB_getItem ($_TABLES['syndication'], 'filename',
                                        "topic = '::all'");
                if (empty ($feedfile)) {
                    $feedfile = DB_getItem ($_TABLES['syndication'], 'filename',
                                            "topic = '{$A['tid']}'");
                }
                if (empty ($feedfile)) {
                    $retval[] = '';
                } else {
                    $retval[] = SYND_getFeedUrl ($feedfile);
                }
                break;
            case 'title':
                $retval[] = stripslashes ($A['title']);
                break;
            case 'url':
                $retval[] = COM_buildUrl ($_CONF['site_url']
                                          . '/article.php?story=' . $sid);
                break;
            default:
                $retval[] = ''; // return empty string for unknown properties
                break;
        }
    }

    if (count ($retval) == 1) {
        $retval = $retval[0];
    }

    return $retval;
}

/**
* This replaces all article image HTML in intro and body with
* GL special syntax
*
* @param    string      $sid    ID for story to parse
* @param    string      $intro  Intro text
* @param    string      $body   Body text
* @return   string      processed text
*
*/
function STORY_replace_images($sid, $intro, $body)
{
    global $_CONF, $_TABLES, $LANG24;

    $stdImageLoc = true;
    if (!strstr($_CONF['path_images'], $_CONF['path_html'])) {
        $stdImageLoc = false;
    }
    $result = DB_query("SELECT ai_filename FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' ORDER BY ai_img_num");
    $nrows = DB_numRows($result);
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);

        $imageX       = '[image' . $i . ']';
        $imageX_left  = '[image' . $i . '_left]';
        $imageX_right = '[image' . $i . '_right]';

        $sizeattributes = COM_getImgSizeAttributes ($_CONF['path_images'] . 'articles/' . $A['ai_filename']);

        $lLinkPrefix = '';
        $lLinkSuffix = '';
        if ($_CONF['keep_unscaled_image'] == 1) {
            $lFilename_large = substr_replace ($A['ai_filename'], '_original.',
                    strrpos ($A['ai_filename'], '.'), 1);
            $lFilename_large_complete = $_CONF['path_images'] . 'articles/'
                                      . $lFilename_large;
            if ($stdImageLoc) {
                $imgpath = substr ($_CONF['path_images'],
                                   strlen ($_CONF['path_html']));
                $lFilename_large_URL = $_CONF['site_url'] . '/' . $imgpath
                                     . 'articles/' . $lFilename_large;
            } else {
                $lFilename_large_URL = $_CONF['site_url']
                    . '/getimage.php?mode=show&amp;image=' . $lFilename_large;
            }
            if (file_exists ($lFilename_large_complete)) {
                $lLinkPrefix = '<a href="' . $lFilename_large_URL
                             . '" title="' . $LANG24[57] . '">';
                $lLinkSuffix = '</a>';
            }
        }

        if ($stdImageLoc) {
            $imgpath = substr ($_CONF['path_images'],
                               strlen ($_CONF['path_html']));
            $imgSrc = $_CONF['site_url'] . '/' . $imgpath . 'articles/'
                    . $A['ai_filename'];
        } else {
            $imgSrc = $_CONF['site_url']
                . '/getimage.php?mode=articles&amp;image=' . $A['ai_filename'];
        }
        $norm = $lLinkPrefix . '<img ' . $sizeattributes . 'src="' . $imgSrc . '" alt="">' . $lLinkSuffix;
        $left = $lLinkPrefix . '<img ' . $sizeattributes . 'align="left" src="' . $imgSrc . '" alt="">' . $lLinkSuffix;
        $right = $lLinkPrefix . '<img ' . $sizeattributes . 'align="right" src="' . $imgSrc . '" alt="">' . $lLinkSuffix;

        $fulltext = $intro . ' ' . $body;
        $intro = str_replace ($norm,  $imageX,       $intro);
        $body  = str_replace ($norm,  $imageX,       $body);
        $intro = str_replace ($left,  $imageX_left,  $intro);
        $body  = str_replace ($left,  $imageX_left,  $body);
        $intro = str_replace ($right, $imageX_right, $intro);
        $body  = str_replace ($right, $imageX_right, $body);

        if (($_CONF['allow_user_scaling'] == 1) and
            ($_CONF['keep_unscaled_image'] == 1)){

            $unscaledX       = '[unscaled' . $i . ']';
            $unscaledX_left  = '[unscaled' . $i . '_left]';
            $unscaledX_right = '[unscaled' . $i . '_right]';

            if (file_exists ($lFilename_large_complete)) {
                    $sizeattributes = COM_getImgSizeAttributes($lFilename_large_complete);
                    $norm = '<img ' . $sizeattributes . 'src="' . $lFilename_large_URL . '" alt="">';
                    $left = '<img ' . $sizeattributes . 'align="left" src="' . $lFilename_large_URL . '" alt="">';
                    $right = '<img ' . $sizeattributes . 'align="right" src="' . $lFilename_large_URL . '" alt="">';
                }
            $intro = str_replace ($norm,  $unscaledX,       $intro);
            $body  = str_replace ($norm,  $unscaledX,       $body);
            $intro = str_replace ($left,  $unscaledX_left,  $intro);
            $body  = str_replace ($left,  $unscaledX_left,  $body);
            $intro = str_replace ($right, $unscaledX_right, $intro);
            $body  = str_replace ($right, $unscaledX_right, $body);
        }
    }

    return array($intro, $body);
}

/**
* Replaces simple image syntax with actual HTML in the intro and body.
* If errors occur it will return all errors in $error
*
* @param    string      $sid    ID for story to parse
* @param    string      $intro  Intro text
* @param    string      $body   Body text
* @param    string      $usage  'html' for normal use, 'email' for email use
* @return   string      Processed text
*
*/
function STORY_insert_images($sid, $intro, $body, $usage='html')
{
    global $_CONF, $_TABLES, $LANG24;

    $result = DB_query("SELECT ai_filename FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' ORDER BY ai_img_num");
    $nrows = DB_numRows($result);
    $errors = array();
    $stdImageLoc = true;
    if (!strstr($_CONF['path_images'], $_CONF['path_html'])) {
        $stdImageLoc = false;
    }
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);

        $lLinkPrefix = '';
        $lLinkSuffix = '';
        if ($_CONF['keep_unscaled_image'] == 1) {
            $lFilename_large = substr_replace ($A['ai_filename'], '_original.',
                    strrpos ($A['ai_filename'], '.'), 1);
            $lFilename_large_complete = $_CONF['path_images'] . 'articles/'
                                      . $lFilename_large;
            if ($stdImageLoc) {
                $imgpath = substr ($_CONF['path_images'],
                                   strlen ($_CONF['path_html']));
                $lFilename_large_URL = $_CONF['site_url'] . '/' . $imgpath
                                     . 'articles/' . $lFilename_large;
            } else {
                $lFilename_large_URL = $_CONF['site_url']
                    . '/getimage.php?mode=show&amp;image=' . $lFilename_large;
            }
            if (file_exists ($lFilename_large_complete)) {
                $lLinkPrefix = '<a href="' . $lFilename_large_URL
                             . '" title="' . $LANG24[57] . '">';
                $lLinkSuffix = '</a>';
            }
        }

        $sizeattributes = COM_getImgSizeAttributes ($_CONF['path_images'] . 'articles/' . $A['ai_filename']);

        $norm  = '[image' . $i . ']';
        $left  = '[image' . $i . '_left]';
        $right = '[image' . $i . '_right]';

        $unscalednorm  = '[unscaled' . $i . ']';
        $unscaledleft  = '[unscaled' . $i . '_left]';
        $unscaledright = '[unscaled' . $i . '_right]';

        $fulltext = $intro . ' ' . $body;
        $icount = substr_count($fulltext, $norm) + substr_count($fulltext, $left) + substr_count($fulltext, $right);
        $icount = $icount + substr_count($fulltext, $unscalednorm) + substr_count($fulltext, $unscaledleft) + substr_count($fulltext, $unscaledright);
        if ($icount == 0) {
            // There is an image that wasn't used, create an error
            $errors[] = $LANG24[48] . " #$i, {$A['ai_filename']}, " . $LANG24[53];
        } else {
            // Only parse if we haven't encountered any error to this point
            if (count($errors) == 0) {
                if ($usage=='email') {  // image will be attached, no path necessary
                    $imgSrc = $A['ai_filename'];
                } elseif ($stdImageLoc) {
                    $imgpath = substr ($_CONF['path_images'],
                                       strlen ($_CONF['path_html']));
                    $imgSrc = $_CONF['site_url'] . '/' . $imgpath . 'articles/'
                            . $A['ai_filename'];
                } else {
                    $imgSrc = $_CONF['site_url'] . '/getimage.php?mode=articles&amp;image=' . $A['ai_filename'];
                }
                $intro = str_replace($norm, $lLinkPrefix . '<img ' . $sizeattributes . 'src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $intro);
                $body = str_replace($norm, $lLinkPrefix . '<img ' . $sizeattributes . 'src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $body);
                $intro = str_replace($left, $lLinkPrefix . '<img ' . $sizeattributes . 'align="left" src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $intro);
                $body = str_replace($left, $lLinkPrefix . '<img ' . $sizeattributes . 'align="left" src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $body);
                $intro = str_replace($right, $lLinkPrefix . '<img ' . $sizeattributes . 'align="right" src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $intro);
                $body = str_replace($right, $lLinkPrefix . '<img ' . $sizeattributes . 'align="right" src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $body);

                if (($_CONF['allow_user_scaling'] == 1) and
                    ($_CONF['keep_unscaled_image'] == 1)) {

                    if (file_exists ($lFilename_large_complete)) {
                        $imgSrc = $lFilename_large_URL;
                        $sizeattributes = COM_getImgSizeAttributes ($lFilename_large_complete);
                    }
                    $intro = str_replace($unscalednorm, '<img ' . $sizeattributes . 'src="' . $imgSrc . '" alt="">', $intro);
                    $body = str_replace($unscalednorm, '<img ' . $sizeattributes . 'src="' . $imgSrc . '" alt="">', $body);
                    $intro = str_replace($unscaledleft, '<img ' . $sizeattributes . 'align="left" src="' . $imgSrc . '" alt="">', $intro);
                    $body = str_replace($unscaledleft, '<img ' . $sizeattributes . 'align="left" src="' . $imgSrc . '" alt="">', $body);
                    $intro = str_replace($unscaledright, '<img ' . $sizeattributes . 'align="right" src="' . $imgSrc . '" alt="">', $intro);
                    $body = str_replace($unscaledright, '<img ' . $sizeattributes . 'align="right" src="' . $imgSrc . '" alt="">', $body);
                }

            }
        }
    }

    return array($errors, $intro, $body);
}

/**
* Delete a story.
*
* This is used to delete a story from the list of stories with the 'draft' flag
* set (see function draftlist() above).
*
* @sid      string      ID of the story to delete
*
*/
function STORY_deleteStory($sid)
{
    global $_CONF, $_TABLES, $_USER;

    $result = DB_query ("SELECT tid,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'");
    $A = DB_fetchArray ($result);
    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
            $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    $access = min ($access, SEC_hasTopicAccess ($A['tid']));
    if ($access < 3) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete story $sid.");
        return COM_refresh ($_CONF['site_admin_url'] . '/story.php');
    }

    STORY_deleteImages ($sid);
    DB_query("DELETE FROM {$_TABLES['comments']} WHERE sid = '$sid' AND type = 'article'");
    DB_delete ($_TABLES['stories'], 'sid', $sid);

    // delete Trackbacks
    DB_query ("DELETE FROM {$_TABLES['trackback']} WHERE sid = '$sid' AND type = 'article';");

    // update RSS feed and Older Stories block
    COM_rdfUpToDateCheck ();
    COM_olderStuff ();

    return COM_refresh ($_CONF['site_admin_url'] . '/story.php?msg=10');
}


?>
