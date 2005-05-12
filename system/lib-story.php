<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-story.php                                                             |
// |                                                                           |
// | Story-related functions needed in more than one place.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
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
// $Id: lib-story.php,v 1.27 2005/05/12 10:40:50 ospiess Exp $

if (eregi ('lib-story.php', $_SERVER['PHP_SELF'])) {
    die ('This file can not be used on its own.');
}


/**
* Returns the array (created from db record) passed to it as formated HTML
*
* Formats the given article data into HTML.  Called by index.php, article.php,
* submit.php, and admin/story.php (when previewing)
*
* @param    array       $A      Data to display as an article (associative array from record from gl_stories)
* @param    string      $index  whether or not this is the index page if 'n' then compact display for index page else display full article, also: 'p' = preview
* @return   string      Article as formated HTML
*
* Note: Formerly named COM_article
*
*/
function STORY_renderArticle( $A, $index='', $storytpl='storytext.thtml' )
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG05, $LANG11, $LANG_TRB,
           $_THEME_URL, $mode;

    $curtime = COM_getUserDateTimeFormat( $A['day'] );
    $A['day'] = $curtime[0];

    // If plain text then replace newlines with <br> tags
    if( $A['postmode'] == 'plaintext' )
    {
        $A['introtext'] = nl2br( $A['introtext'] );
        $A['bodytext'] = nl2br( $A['bodytext'] );
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
    if( $_CONF['viewscountline'] == 1 ) {
        $article->set_var( 'lang_views', $LANG01[106] );
        $article->set_var( 'story_hits', COM_NumberFormat( $A['hits'] ) );
    }
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
                $article->set_var( 'camera_icon', '<a href="'
                        . $_CONF['site_url']
                        . '/users.php?mode=profile&amp;uid=' . $A['uid']
                        . '"><img src="' . $_CONF['layout_url']
                        . '/images/smallcamera.gif" border="0" alt=""></a>' );
            }
            else
            {
                $article->set_var( 'contributedby_photo', '' );
                $article->set_var( 'camera_icon', '' );
            }
        }
        else
        {
            $article->set_var( 'contributedby_photo', '' );
            $article->set_var( 'camera_icon', '' );
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
    $introtext = PLG_replacetags($introtext);   // Replace any plugin autolink tags

    if(( $index == 'n' ) || ( $index == 'p' ))
    {
        $article->set_var( 'story_title', stripslashes( $A['title'] ));
        if( empty( $A['bodytext'] ))
        {
            $article->set_var( 'story_introtext', $introtext );
            $article->set_var( 'story_text_no_br', $introtext );
        }
        else
        {
            $bodytext = stripslashes( $A['bodytext'] );
            // Replace any plugin autolink tags
            $bodytext = PLG_replacetags( $bodytext );
            
                        # page selector --------------------------------------------------------
                $page=$_REQUEST['page'];
                if (!isset($page)) {$page=1;}
                $article_array=explode('[page_break]',$bodytext);
            $pagelinks = COM_printPageNavigation( $articleUrl, $page, 
                                                                                      count($article_array));
                if (count($article_array)>1) {
                        $bodytext=$article_array[($page-1)];                        
                if ($page>1) {$introtext=$pagelinks;}
                }
                $article->set_var( 'page_selector',$pagelinks);        
                # page selector end ----------------------------------------------------

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
                 . '/trackback.php?mode=sendall&amp;id=' . $A['sid'];
            $article->set_var( 'send_trackback_link', '<a href="' . $url . '">'
                 . $LANG_TRB['send_trackback'] . '</a>' );
            $article->set_var( 'send_trackback_url', $url );
            $article->set_var( 'lang_send_trackback_text',
                               $LANG_TRB['send_trackback'] );
        }
    }
    else
    {
        $article->set_var( 'story_title', stripslashes( $A['title'] ));
        $article->set_var( 'story_introtext', $introtext );
        $article->set_var( 'story_text_no_br', $introtext );

        if( !empty( $A['bodytext'] ))
        {
            $article->set_var( 'lang_readmore', $LANG01[2] );
            $article->set_var( 'lang_readmore_words', $LANG01[62] );
            $numwords = COM_NumberFormat (sizeof( explode( ' ', strip_tags( $A['bodytext'] ))));
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
            $article->set_var( 'comments_count', COM_NumberFormat ( $A['comments'] ));
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

        if( $_CONF['trackback_enabled'] || $_CONF['pingback_enabled'] )
        {
            $num_trackbacks = COM_NumberFormat ( DB_count( $_TABLES['trackback'],
                    array( 'sid', 'type' ), array( $A['sid'], 'article' )));
            $trackbacksUrl = COM_buildUrl( $_CONF['site_url']
                    . '/article.php?story=' . $A['sid'] ) . '#trackback';
            $article->set_var( 'trackbacks_url', $trackbacksUrl );
            $article->set_var( 'trackbacks_text', $num_trackbacks . ' '
                                                  . $LANG_TRB['trackbacks'] );
            $article->set_var( 'trackbacks_count', $num_trackbacks );
            $article->set_var( 'lang_trackbacks', $LANG_TRB['trackbacks'] );

            if( $num_trackbacks > 0 )
            {
                $article->set_var( 'start_trackbacks_anchortag', '<a href="'
                        . $trackbacksUrl . '">' );
                $article->set_var( 'end_trackbacks_anchortag', '</a>' );
            }
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

    if( SEC_hasAccess( $A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon'] ) == 3 AND SEC_hasrights( 'story.edit' ) AND ( $index != 'p' ))
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

    $t = explode(' ',$A['expire']);     // Need to convert text date/time to a timestamp
    $archiveDateTime = COM_convertDate2Timestamp($t[0],$t[1]);
    if( $A['featured'] == 1 )
    {
        $article->set_var( 'lang_todays_featured_article', $LANG05[4] );
        $article->parse( 'story_bodyhtml', 'featuredbodytext', true );
        $article->parse( 'finalstory', 'featuredarticle' );
    }
    elseif ($A['statuscode'] == 10 AND $archiveDateTime <= time() )
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
                $retval[] = trim (stripslashes ($A['introtext']) . ' '
                                  . stripslashes ($A['bodytext']));
                break;
            case 'excerpt':
                $retval[] = trim (stripslashes ($A['introtext']) . "\n\n"
                                  . stripslashes ($A['bodytext']));
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
                    $feedpath = $_CONF['rdf_file'];
                    $pos = strrpos ($feedpath, '/');
                    $feed = substr ($feedpath, 0, $pos + 1);
                    $url = substr_replace ($feed, $_CONF['site_url'], 0,
                            strlen ($_CONF['path_html']) - 1);
                    $retval[] = $url . $feedfile;
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

        $dimensions = GetImageSize($_CONF['path_images'] . 'articles/' . $A['ai_filename']);
        if (!empty($dimensions[0]) AND !empty($dimensions[1])) {
            $sizeattributes = 'width="' . $dimensions[0] . '" height="' . $dimensions[1] . '" ';
        } else {
            $sizeattributes = '';
        }

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
        $count = substr_count($fulltext, $norm) + substr_count($fulltext, $left) + substr_count($fulltext, $right);
        $intro = str_replace ($norm,  $imageX,       $intro);
        $body  = str_replace ($norm,  $imageX,       $body);
        $intro = str_replace ($left,  $imageX_left,  $intro);
        $body  = str_replace ($left,  $imageX_left,  $body);
        $intro = str_replace ($right, $imageX_right, $intro);
        $body  = str_replace ($right, $imageX_right, $body);
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
        $dimensions = GetImageSize($_CONF['path_images'] . 'articles/' . $A['ai_filename']);
        if (!empty($dimensions[0]) AND !empty($dimensions[1])) {
            $sizeattributes = 'width="' . $dimensions[0] . '" height="' . $dimensions[1] . '" ';
        } else {
            $sizeattributes = '';
        }

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

        $norm  = '[image' . $i . ']';
        $left  = '[image' . $i . '_left]';
        $right = '[image' . $i . '_right]';

        $fulltext = $intro . ' ' . $body;
        $icount = substr_count($fulltext, $norm) + substr_count($fulltext, $left) + substr_count($fulltext, $right);
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
            }
        }
    }

    return array($errors, $intro, $body);
}

?>