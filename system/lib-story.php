<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-story.php                                                             |
// |                                                                           |
// | Story-related functions needed in more than one place.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
// |          Vincent Furia     - vinny01@users.sourceforge.net                |
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
// $Id: lib-story.php,v 1.8 2004/09/04 19:29:18 dhaun Exp $

if (eregi ('lib-story.php', $HTTP_SERVER_VARS['PHP_SELF'])) {
    die ('This file can not be used on its own.');
}


/**
* Returns the array (created from db record) passed to it as formated HTML
*
* Formats the given article data into HTML.  Called by index.php, article.php,
* submit.php, and admin/story.php (when previewing)
*
* @param    array       $A      Data to display as an article (associative array from record from gl_stories)
* @param    string      $index  whether or not this is the index page if 'n' then compact display for index page else display full article
* @return   string      Article as formated HTML
*
* Note: Formerly named COM_article
*
*/
function STORY_renderArticle( $A, $index='', $storytpl='storytext.thtml' )
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG05, $LANG11, $_THEME_URL, $mode;

    $curtime = COM_getUserDateTimeFormat( $A['day'] );
    $A['day'] = $curtime[0];

    // If plain text then replace newlines with <br> tags
    if( $A['postmode'] == 'plaintext' )
    {
        $A['introtext'] = nl2br( COM_makeClickableLinks( $A['introtext'] ));
        $A['bodytext'] = nl2br( COM_makeClickableLinks( $A['bodytext'] ));
    }

    $A['introtext'] = str_replace( '{', '&#123;', $A['introtext'] );
    $A['introtext'] = str_replace( '}', '&#125;', $A['introtext'] );
    $A['bodytext'] = str_replace( '{', '&#123;', $A['bodytext'] );
    $A['bodytext'] = str_replace( '}', '&#125;', $A['bodytext'] );

    $article = new Template( $_CONF['path_layout'] );
    $article->set_file( array(
            'article'          => $storytpl,
            'bodytext'         => 'storybodytext.thtml',
            'featuredarticle'  => 'featuredstorytext.thtml',
            'featuredbodytext'=>'featuredstorybodytext.thtml',
            'archivearticle'=>'archivestorytext.thtml',
            'archivebodytext'=>'archivestorybodytext.thtml'
            ));

    $article->set_var( 'layout_url', $_CONF['layout_url'] );
    $article->set_var( 'site_url', $_CONF['site_url'] );
    $article->set_var( 'story_date', $A['day'] );
    $article->set_var( 'lang_views', $LANG01[106] );
    $article->set_var( 'story_hits', $A['hits'] );
    $article->set_var( 'story_id', $A['sid'] );

    if( $_CONF['contributedbyline'] == 1 )
    {
        $article->set_var( 'lang_contributed_by', $LANG01[1] );
        $article->set_var( 'contributedby_uid', $A['uid'] );
        $username = $A['username'];
        $article->set_var( 'contributedby_user', $username );

        $fullname = $A['fullname'];
        if( empty( $fullname ))
        {
            $article->set_var( 'contributedby_fullname', $username );
        }
        else
        {
            $article->set_var( 'contributedby_fullname', $fullname );
        }

        if( $A['uid'] > 1 )
        {
            $article->set_var( 'start_contributedby_anchortag',
                    '<a class="storybyline" href="' . $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $A['uid'] . '">' );
            $article->set_var( 'end_contributedby_anchortag', '</a>' );
            $article->set_var( 'contributedby_url', $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $A['uid'] );

            $photo = $A['photo'];
            if( !empty( $photo ))
            {
                if( empty( $fullname ))
                {
                    $altname = $username;
                }
                else
                {
                    $altname = $fullname;
                }
                $article->set_var( 'contributedby_photo', '<img src="'
                        . $_CONF['site_url'] . '/images/userphotos/' . $photo
                        . '" alt="' . $altname . '">' );
            }
        }
    }

    $topicname = htmlspecialchars( stripslashes( $A['topic'] ));
    $article->set_var( 'story_topic_id', $A['tid'] );
    $article->set_var( 'story_topic_name', $topicname );

    if( $_USER['noicons'] != 1 AND $A['show_topic_icon'] == 1 )
    {
        $topicurl = $_CONF['site_url'] . '/index.php?topic=' . $A['tid'];
        if( !empty( $A['imageurl'] ))
        {
            if( isset( $_THEME_URL ))
            {
                $imagebase = $_THEME_URL;
            }
            else
            {
                $imagebase = $_CONF['site_url'];
            }
            $topicimage = '<img align="' . $_CONF['article_image_align']
                    . '" src="' . $imagebase . $A['imageurl'] . '" alt="'
                    . $topicname . '" title="' . $topicname . '" border="0">';
            $article->set_var( 'story_anchortag_and_image', '<a href="'
                    . $topicurl . '">' . $topicimage . '</a>' );
            $article->set_var( 'story_topic_image', $topicimage );
        }
        $article->set_var( 'story_topic_url', $topicurl );
    }

    $A['title'] = str_replace( '$', '&#36;', $A['title'] );
    $A['introtext'] = str_replace( '$', '&#36;', $A['introtext'] );
    $A['bodytext'] = str_replace( '$', '&#36;', $A['bodytext'] );

    $recent_post_anchortag = '';
    $articleUrl = COM_buildUrl( $_CONF['site_url'] . '/article.php?story='
                                . $A['sid'] );
    $introtext = stripslashes( $A['introtext'] );
    if( $index == 'n' )
    {
        $article->set_var( 'story_title', stripslashes( $A['title'] ));
        if( empty( $A['bodytext'] ))
        {
            $article->set_var( 'story_introtext', $introtext );
        }
        else
        {
            $bodytext = stripslashes( $A['bodytext'] );
            $article->set_var( 'story_introtext', $introtext . '<br><br>'
                               . $bodytext );
            $article->set_var( 'story_text_no_br', $introtext . $bodytext );
        }
    }
    else
    {
        $article->set_var( 'story_title', stripslashes( $A['title'] ));
        $article->set_var( 'story_introtext', $introtext );

        if( !empty( $A['bodytext'] ))
        {
            $article->set_var( 'lang_readmore', $LANG01[2] );
            $article->set_var( 'lang_readmore_words', $LANG01[62] );
            $numwords = sizeof( explode( ' ', $A['bodytext'] ));
            $article->set_var( 'readmore_words', $numwords );

            $article->set_var( 'readmore_link', '<a href="' . $articleUrl . '">'
                    . $LANG01[2] . '</a> (' . $numwords . ' ' . $LANG01[62]
                    . ') ' );
            $article->set_var( 'start_readmore_anchortag', '<a href="'
                    . $articleUrl . '">' );
            $article->set_var( 'end_readmore_anchortag', '</a>' );
        }

        if( $A['commentcode'] >= 0 )
        {
            $commentsUrl = COM_buildUrl( $_CONF['site_url']
                    . '/article.php?story=' . $A['sid'] ) . '#comments';
            $article->set_var( 'comments_url', $commentsUrl );
            $article->set_var( 'comments_text', $A['comments'] . ' '
                                                . $LANG01[3] );
            $article->set_var( 'comments_count', $A['comments'] );
            $article->set_var( 'lang_comments', $LANG01[3] );

            if( $A['comments'] > 0 )
            {
                $result = DB_query( "SELECT UNIX_TIMESTAMP(date) AS day,username FROM {$_TABLES['comments']},{$_TABLES['users']} WHERE {$_TABLES['users']}.uid = {$_TABLES['comments']}.uid AND sid = '{$A['sid']}' ORDER BY date desc LIMIT 1" );
                $C = DB_fetchArray( $result );

                $recent_post_anchortag = '<span class="storybyline">'
                        . $LANG01[27] . ': '
                        . strftime( $_CONF['daytime'], $C['day'] ) . ' '
                        . $LANG01[104] . ' ' . $C['username'] . '</span>';
                $article->set_var( 'start_comments_anchortag', '<a href="'
                        . $commentsUrl . '">' );
                $article->set_var( 'end_comments_anchortag', '</a>' );
            }
            else
            {
                $recent_post_anchortag = ' <a href="' . $_CONF['site_url']
                        . '/comment.php?sid=' . $A['sid']
                        . '&amp;pid=0&amp;type=article">' . $LANG01[60] . '</a>';
            }
            $postCommentUrl = $_CONF['site_url'] . '/comment.php?sid='
                            . $A['sid'] . '&amp;pid=0&amp;type=article';
            $article->set_var( 'post_comment_link',' <a href="'
                    . $postCommentUrl . '">' . $LANG01[60] . '</a>' );
            $article->set_var( 'lang_post_comment', $LANG01[60] );
            $article->set_var( 'start_post_comment_anchortag',
                               ' <a href="' . $postCommentUrl . '">' );
            $article->set_var( 'end_post_comment_anchortag', '</a>' );
        }

        if( $_CONF['hideemailicon'] == 1 )
        {
            $article->set_var( 'email_icon', '' );
        }
        else
        {
            $emailUrl = $_CONF['site_url'] . '/profiles.php?sid=' . $A['sid']
                      . '&amp;what=emailstory';
            $article->set_var( 'email_icon', '<a href="' . $emailUrl . '">'
                . '<img src="' . $_CONF['layout_url']
                . '/images/mail.gif" alt="' . $LANG01[64]
                . '" title="' . $LANG11[2] . '" border="0"></a>' );
            $article->set_var( 'email_story_url', $emailUrl );
            $article->set_var( 'lang_email_story', $LANG11[2] );
            $article->set_var( 'lang_email_story_alt', $LANG01[64] );
        }
        $printUrl = COM_buildUrl( $_CONF['site_url'] . '/article.php?story='
                                  . $A['sid'] . '&amp;mode=print' );
        if( $_CONF['hideprintericon'] == 1 )
        {
            $article->set_var( 'print_icon', '' );
        }
        else
        {
            $article->set_var( 'print_icon', '<a href="' . $printUrl . '">'
                . '<img border="0" src="' . $_CONF['layout_url']
                . '/images/print.gif" alt="' . $LANG01[65] . '" title="'
                . $LANG11[3] . '"></a>' );
            $article->set_var( 'print_story_url', $printUrl );
            $article->set_var( 'lang_print_story', $LANG11[3] );
            $article->set_var( 'lang_print_story_alt', $LANG01[65] );
        }
        if( $_CONF['pdf_enabled'] == 1 )
        {
            $pdfUrl = $_CONF['site_url'] . '/pdfgenerator.php?pageType=2&amp;'
                    . 'pageData=' . urlencode( $printUrl );
            $article->set_var( 'pdf_icon',
                sprintf( '<a href="%s"><img border="0" src="%s/images/pdf.gif" alt="%s" title="%s"></a>', $pdfUrl, $_CONF['layout_url'], $LANG01[111], $LANG11[5] ));
            $article->set_var( 'pdf_story_url', $pdfUrl );
            $article->set_var( 'lang_pdf_story', $LANG11[5] );
            $article->set_var( 'lang_pdf_story_alt', $LANG01[111] );
        }
        else
        {
            $article->set_var( 'pdf_icon', '' );
        }
    }
    $article->set_var( 'article_url', $articleUrl );
    $article->set_var( 'recent_post_anchortag', $recent_post_anchortag );

    if( SEC_hasAccess( $A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon'] ) == 3 AND SEC_hasrights( 'story.edit' ))
    {
        $article->set_var( 'edit_link', '<a href="' . $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $A['sid'] . '">'
                . $LANG01[4] . '</a>' );
        $article->set_var( 'edit_url', $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $A['sid'] );
        $article->set_var( 'lang_edit_text',  $LANG01[4] );
        $article->set_var( 'edit_icon', '<a href="' . $_CONF['site_admin_url']
                . '/story.php?mode=edit&amp;sid=' . $A['sid'] . '"><img src="'
                . $_CONF['layout_url'] . '/images/edit.gif" alt="' . $LANG01[4]
                . '" title="' . $LANG01[4] . '" border="0"></a>' );
        $article->set_var( 'edit_image',  '<img src="' . $_CONF['layout_url']
                . '/images/edit.gif" alt="' . $LANG01[4] . '" title="'
                . $LANG01[4] . '" border="0">' );
    }

    if( $A['featured'] == 1 )
    {
        $article->set_var( 'lang_todays_featured_article', $LANG05[4] );
        $article->parse( 'story_bodyhtml', 'featuredbodytext', true );
        $article->parse( 'finalstory', 'featuredarticle' );
    }
    elseif ($A['statuscode'] == 10)
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
        if ( !strlen( trim( $matches[2][$i] ) ) ) {
            $matches[2][$i] = strip_tags( $matches[1][$i] );
        }

        // if link is too long, shorten it and add ... at the end
        if ( ( $maxlength > 0 ) && ( strlen( $matches[2][$i] ) > $maxlength ) )
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
            $author = DB_getItem( $_TABLES['users'], 'username', "uid = $uid" );
            $rel[] = "<a href=\"{$_CONF['site_url']}/search.php?mode=search&amp;type=stories&amp;author=$uid\">{$LANG24[37]} $author</a>";
        }

        // add a link to "search by topic"
        $topic = DB_getItem( $_TABLES['topics'], 'topic', "tid = '$tid'" );
        $rel[] = "<a href=\"{$_CONF['site_url']}/search.php?mode=search&amp;type=stories&amp;topic=$tid\">{$LANG24[38]} $topic</a>";
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

?>
