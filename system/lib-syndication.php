<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | lib-syndication.php                                                       |
// |                                                                           |
// | Geeklog syndication library.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun        - dirk AT haun-online DOT de                    |
// |          Michael Jervis   - mike AT fuckingbrit DOT com                   |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-syndication.php') !== false) {
    die('This file can not be used on its own!');
}

if ($_CONF['trackback_enabled']) {
    require_once $_CONF['path_system'] . 'lib-trackback.php';
}

// set to true to enable debug output in error.log
$_SYND_DEBUG = false;

/**
* Check if a feed for all stories needs to be updated.
*
* @param    boolean $frontpage_only true: only articles shown on the frontpage
* @param    string  $update_info    list of story ids
* @param    string  $limit          number of entries or number of hours
* @param    string  $updated_topic  (optional) topic to be updated
* @param    string  $updated_id     (optional) entry id to be updated
* @return   boolean                 false = feed needs to be updated
*
*/
function SYND_feedUpdateCheckAll( $frontpage_only, $update_info, $limit, $updated_topic = '', $updated_id = '' )
{
    global $_CONF, $_TABLES, $_SYND_DEBUG;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // last xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    $sids = array ();

    // get list of topics that anonymous users have access to
    $tresult = DB_query( "SELECT tid FROM {$_TABLES['topics']}"
                         . COM_getPermSQL( 'WHERE', 1 ));
    $tnumrows = DB_numRows( $tresult );
    $topiclist = array();
    for( $i = 0; $i < $tnumrows; $i++ )
    {
        $T = DB_fetchArray( $tresult );
        $topiclist[] = $T['tid'];
    }
    if( count( $topiclist ) > 0 )
    {
        $tlist = "'" . implode( "','", $topiclist ) . "'";
        $where .= " AND ta.type = 'article' AND ta.id = sid AND (ta.tid IN ($tlist))";

        if ($frontpage_only) {
            $where .= ' AND frontpage = 1';
        }

        $result = DB_query( "SELECT sid FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta WHERE draft_flag = 0 AND date <= NOW() $where AND perm_anon > 0 GROUP BY sid ORDER BY date DESC $limitsql" );
        $nrows = DB_numRows( $result );

        for( $i = 0; $i < $nrows; $i++ )
        {
            $A = DB_fetchArray( $result );

            if( $A['sid'] == $updated_id )
            {
                // no need to look any further - this feed has to be updated
                return false;
            }

            $sids[] = $A['sid'];
        }
    }
    $current = implode( ',', $sids );

    if ($_SYND_DEBUG) {
        COM_errorLog ("Update check for all stories: comparing new list ($current) with old list ($update_info)", 1);
    }

    return ( $current != $update_info ) ? false : true;
}

/**
* Check if a feed for stories from a topic needs to be updated.
*
* @param    string  $tid            topic id
* @param    string  $update_info    list of story ids
* @param    string  $limit          number of entries or number of hours
* @param    string  $updated_topic  (optional) topic to be updated
* @param    string  $updated_id     (optional) entry id to be updated
* @return   boolean                 false = feed needs to be updated
*
*/
function SYND_feedUpdateCheckTopic( $tid, $update_info, $limit, $updated_topic = '', $updated_id = '' )
{
    global $_CONF, $_TABLES, $_SYND_DEBUG;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // last xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    // "SELECT sid FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() AND tid = '$tid'" . COM_getTopicSQL('AND', 1) . " AND perm_anon > 0 ORDER BY date DESC $limitsql"
    $sql = "SELECT sid 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
        WHERE draft_flag = 0 AND date <= NOW() AND perm_anon > 0
        AND ta.type = 'article' AND ta.id = sid  
        AND ta.tid = '$tid'" . COM_getTopicSQL('AND', 1, 'ta') . "
        GROUP BY sid
        ORDER BY date DESC $limitsql";
        
    $result = DB_query($sql);
    $nrows = DB_numRows( $result );

    $sids = array ();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );

        if( $A['sid'] == $updated_id )
        {
            // no need to look any further - this feed has to be updated
            return false;
        }

        $sids[] = $A['sid'];
    }
    $current = implode( ',', $sids );

    if ($_SYND_DEBUG) {
        COM_errorLog ("Update check for topic $tid: comparing new list ($current) with old list ($update_info)", 1);
    }

    return ( $current != $update_info ) ? false : true;
}

/**
* Check if the contents of Geeklog's built-in feeds need to be updated.
*
* @param    string  $topic          indicator of the feed's "topic"
* @param    string  $update_data    comma-sep. list of updated ids
* @param    string  $limit          number of entries or number of hours
* @param    string  $updated_topic  (optional) specific topic to update
* @param    string  $updated_id     (optional) specific id to update
* @return   boolean                 false = feed has to be updated, true = ok
*
*/
function SYND_feedUpdateCheck($topic, $update_data, $limit, $updated_topic = '', $updated_id = '')
{
    $is_current = true; 

    switch($topic) {
    case '::all':
        $is_current = SYND_feedUpdateCheckAll(false, $update_data, $limit,
                            $updated_topic, $updated_id);
        break;

    case '::frontpage':
        $is_current = SYND_feedUpdateCheckAll(true, $update_data, $limit,
                            $updated_topic, $updated_id);
        break;

    default:
        $is_current = SYND_feedUpdateCheckTopic($topic, $update_data,
                            $limit, $updated_topic, $updated_id);
        break;
    }

    return $is_current;
}

/**
* Get content for a feed that holds stories from one topic.
*
* @param    string   $tid      topic id
* @param    string   $limit    number of entries or number of stories
* @param    string   $link     link to topic
* @param    string   $update   list of story ids
* @return   array              content of the feed
*
*/
function SYND_getFeedContentPerTopic( $tid, $limit, &$link, &$update, $contentLength, $feedType, $feedVersion, $fid )
{
    global $_TABLES, $_CONF, $LANG01;

    $content = array ();
    $sids = array();

    if( DB_getItem( $_TABLES['topics'], 'perm_anon', "tid = '$tid'") >= 2)
    {
        $where = '';
        if( !empty( $limit ))
        {
            if( substr( $limit, -1 ) == 'h' ) // last xx hours
            {
                $limitsql = '';
                $hours = substr( $limit, 0, -1 );
                $where = " AND date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
            }
            else
            {
                $limitsql = ' LIMIT ' . $limit;
            }
        }
        else
        {
            $limitsql = ' LIMIT 10';
        }

        $topic = stripslashes( DB_getItem( $_TABLES['topics'], 'topic',
                               "tid = '$tid'" ));
        
        // Retrieve list of inherited topics for anonymous user
        $tid_list = TOPIC_getChildList($tid, 1);        

        //$sql = "SELECT sid,uid,title,introtext,bodytext,postmode,UNIX_TIMESTAMP(date) AS modified,commentcode,trackbackcode FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() AND tid = '$tid' AND perm_anon > 0 ORDER BY date DESC $limitsql";
        $sql = "SELECT sid,uid,title,introtext,bodytext,postmode,UNIX_TIMESTAMP(date) AS modified,commentcode,trackbackcode 
            FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
            WHERE draft_flag = 0 AND date <= NOW() AND perm_anon > 0 
            AND ta.type = 'article' AND ta.id = sid 
            AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '$tid'))) 
            GROUP BY sid 
            ORDER BY date DESC $limitsql";
        
        $result = DB_query($sql);

        $nrows = DB_numRows( $result );

        for( $i = 1; $i <= $nrows; $i++ )
        {
            $row = DB_fetchArray( $result );
            $sids[] = $row['sid'];

            $storytitle = stripslashes( $row['title'] );
            $fulltext = stripslashes( $row['introtext']."\n".$row['bodytext'] );
            $fulltext = PLG_replaceTags( $fulltext );
            $storytext = ($contentLength == 1) ? $fulltext : COM_truncateHTML ($fulltext, $contentLength, ' ...');
 

            $fulltext = trim( $fulltext );
            $fulltext = str_replace(array("\015\012", "\015"), "\012", $fulltext);

            if( $row['postmode'] == 'plaintext' ) 
            {
                if( !empty($storytext) )
                {
                    $storytext = nl2br($storytext);
                }
                if( !empty($fulltext) )
                {
                    $fulltext = nl2br($fulltext);
                }
            }

            $storylink = COM_buildUrl( $_CONF['site_url']
                                       . '/article.php?story=' . $row['sid'] );
            $extensionTags = PLG_getFeedElementExtensions('article', $row['sid'], $feedType, $feedVersion, $tid, $fid);
            if( $_CONF['trackback_enabled'] && ($feedType == 'RSS') && ($row['trackbackcode'] >= 0))
            {
                $trbUrl = TRB_makeTrackbackUrl( $row['sid'] );
                $extensionTags['trackbacktag'] = '<trackback:ping>'.htmlspecialchars($trbUrl).'</trackback:ping>';
            }
            $article = array( 'title'      => $storytitle,
                                'summary'    => $storytext,
                                'text'       => $fulltext,
                                'link'       => $storylink,
                                'uid'        => $row['uid'],
                                'author'     => COM_getDisplayName( $row['uid'] ),
                                'date'       => $row['modified'],
                                'format'     => $row['postmode'],
                                'topic'      => $topic,
                                'extensions' => $extensionTags
                              );
            if($row['commentcode'] >= 0)
            {
                $article['commenturl'] = $storylink . '#comments';
            }
            $content[] = $article;
        }
    }

    $link = $_CONF['site_url'] . '/index.php?topic=' . $tid;
    $update = implode( ',', $sids );

    return $content;
}

/**
* Get content for a feed that holds all stories.
*
* @param    boolean  $frontpage_only true: only articles shown on the frontpage
* @param    string   $limit    number of entries or number of stories
* @param    string   $link     link to homepage
* @param    string   $update   list of story ids
* @param    int      $contentLength Length of summary to allow.
* @param    int      $fid       the id of the feed being fetched
* @return   array              content of the feed
*
*/
function SYND_getFeedContentAll($frontpage_only, $limit, &$link, &$update, $contentLength, $feedType, $feedVersion, $fid)
{
    global $_TABLES, $_CONF, $LANG01;

    $link = $_CONF['site_url'];

    $where = '';
    
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // last xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    // get list of topics that anonymous users have access to
    $topics = array();
    $tresult = DB_query( "SELECT tid,topic FROM {$_TABLES['topics']}"
                         . COM_getPermSQL( 'WHERE', 1 ));
    $tnumrows = DB_numRows( $tresult );

    if ($tnumrows == 0) {
        // no public topics
        $update = '';

        return array();
    }

    $tlist = '';
    for( $i = 1; $i <= $tnumrows; $i++ )
    {
        $T = DB_fetchArray( $tresult );
        $tlist .= "'" . $T['tid'] . "'";
        if( $i < $tnumrows )
        {
            $tlist .= ',';
        }
        $topics[$T['tid']] = stripslashes( $T['topic'] );
    }
    if( !empty( $tlist ))
    {
        $where .= " AND (ta.tid IN ($tlist))";
    }
    if ($frontpage_only) {
        $where .= ' AND frontpage = 1';
    }

    $sql = "SELECT sid,ta.tid,uid,title,introtext,bodytext,postmode,UNIX_TIMESTAMP(date) AS modified,commentcode,trackbackcode 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
        WHERE draft_flag = 0 AND date <= NOW() AND ta.type = 'article' AND ta.id = sid $where AND perm_anon > 0 
        GROUP BY sid
        ORDER BY date DESC $limitsql";
    
    $result = DB_query($sql);

    $content = array();
    $sids = array();
    $nrows = DB_numRows( $result );

    for( $i = 1; $i <= $nrows; $i++ )
    {
        $row = DB_fetchArray( $result );
        $sids[] = $row['sid'];

        $storytitle = stripslashes( $row['title'] );

        $fulltext = stripslashes( $row['introtext']."\n".$row['bodytext'] );
        $fulltext = PLG_replaceTags( $fulltext );
        $storytext = ($contentLength == 1) ? $fulltext : COM_truncateHTML ($fulltext, $contentLength, ' ...');
        $fulltext = trim( $fulltext );
        $fulltext = str_replace(array("\015\012", "\015"), "\012", $fulltext);

        if( $row['postmode'] == 'plaintext' ) 
        {
            if( !empty($storytext) )
            {
                $storytext = nl2br($storytext);
            }
            if( !empty($fulltext) )
            {
                $fulltext = nl2br($fulltext);
            }
        }
        
        $storylink = COM_buildUrl( $_CONF['site_url'] . '/article.php?story='
                                   . $row['sid'] );
        $extensionTags = PLG_getFeedElementExtensions('article', $row['sid'], $feedType, $feedVersion, $fid, ($frontpage_only ? '::frontpage' : '::all'));
        if( $_CONF['trackback_enabled'] && ($feedType == 'RSS') && ($row['trackbackcode'] >= 0))
        {
            $trbUrl = TRB_makeTrackbackUrl( $row['sid'] );
            $extensionTags['trackbacktag'] = '<trackback:ping>'.htmlspecialchars($trbUrl).'</trackback:ping>';
        }
        $article = array( 'title'      => $storytitle,
                          'summary'    => $storytext,
                          'text'       => $fulltext,
                          'link'       => $storylink,
                          'uid'        => $row['uid'],
                          'author'     => COM_getDisplayName( $row['uid'] ),
                          'date'       => $row['modified'],
                          'format'     => $row['postmode'],
                          'topic'      => $topics[$row['tid']],
                          'extensions' => $extensionTags
                        );
        if($row['commentcode'] >= 0)
        {
            $article['commenturl'] = $storylink . '#comments';
        }
        $content[] = $article;
    }

    $update = implode( ',', $sids );

    return $content;
}

/**
* Update a feed.
* Re-written by Michael Jervis (mike AT fuckingbrit DOT com)
* to use the new architecture
*
* @param   int   $fid   feed id
*
*/
function SYND_updateFeed( $fid )
{
    global $_CONF, $_TABLES, $_SYND_DEBUG;

    $result = DB_query( "SELECT * FROM {$_TABLES['syndication']} WHERE fid = $fid");
    $A = DB_fetchArray( $result );
    if( $A['is_enabled'] == 1 )
    {
        // Import the feed handling classes:
        require_once $_CONF['path_system']
                     . '/classes/syndication/parserfactory.class.php';
        require_once $_CONF['path_system']
                     . '/classes/syndication/feedparserbase.class.php';

        // Load the actual feed handlers:
        $factory = new FeedParserFactory( $_CONF['path_system']
                                          . '/classes/syndication/' );
        $format = explode( '-', $A['format'] );
        $feed = $factory->writer( $format[0], $format[1] );
        
        if( $feed )
        {
            $feed->encoding = $A['charset'];
            $feed->lang = $A['language'];

            if ($A['type'] == 'article') {
                if ($A['topic'] == '::all') {
                    $content = SYND_getFeedContentAll(false, $A['limits'],
                                    $link, $data, $A['content_length'],
                                    $format[0], $format[1], $fid);
                } elseif ($A['topic'] == '::frontpage') {
                    $content = SYND_getFeedContentAll(true, $A['limits'],
                                    $link, $data, $A['content_length'],
                                    $format[0], $format[1], $fid);
                } else { // feed for a single topic only
                    $content = SYND_getFeedContentPerTopic($A['topic'],
                                    $A['limits'], $link, $data,
                                    $A['content_length'], $format[0],
                                    $format[1], $fid);
                }
            } else {
                $content = PLG_getFeedContent($A['type'], $fid, $link, $data, $format[0], $format[1]);

                // can't randomly change the api to send a max length, so
                // fix it here:
                if ($A['content_length'] != 1) {
                    $count = count($content);
                    for ($i = 0; $i < $count; $i++ ) {
                        $content[$i]['summary'] = ($A['content_length'] == 1) ? $content[$i]['text'] : COM_truncateHTML ($content[$i]['text'], $A['content_length'], ' ...');
                    }
                }
            }
            if (empty($link)) {
                $link = $_CONF['site_url'];
            }

            $feed->title = $A['title'];
            $feed->description = $A['description'];
            if( empty( $A['feedlogo'] ))
            {
                $feed->feedlogo = '';
            }
            else
            {
                $feed->feedlogo = $_CONF['site_url'] . $A['feedlogo'];
            }
            $feed->sitelink = $link;
            $feed->copyright = 'Copyright ' . strftime( '%Y' ) . ' '
                             . $_CONF['site_name'];
            $feed->sitecontact = $_CONF['site_mail'];
            $feed->system = 'Geeklog';

            /* Gather any other stuff */
            $feed->namespaces = PLG_getFeedNSExtensions($A['type'], $format[0], $format[1], $A['topic'], $fid);
            /* If the feed is RSS, and trackback is enabled */
            if( $_CONF['trackback_enabled'] && ($format[0] == 'RSS') )
            {
                /* Check to see if an article has trackbacks enabled, and if
                 * at least one does, then include the trackback namespace:
                 */
                $trackbackenabled = false;
                foreach ($content as $item)
                {
                    if( array_key_exists('extensions', $item) &&
                        array_key_exists('trackbacktag', $item['extensions'])
                        )
                    {
                        // Found at least one article, with a trackbacktag
                        // in it's extensions tag.
                        $trackbackenabled = true;
                        break;
                    }
                }
                if( $trackbackenabled )
                {
                    $feed->namespaces[] = 'xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/"';
                }
            }

            /* Inject the namespace for Atom into RSS feeds. Illogical?
             * Well apparantly not:
             * http://feedvalidator.org/docs/warning/MissingAtomSelfLink.html
             */
            if( $format[0] == 'RSS' )
            {
                $feed->namespaces[] = 'xmlns:atom="http://www.w3.org/2005/Atom"';
            }

            if( !empty( $A['filename'] ))
            {
                $filename = $A['filename'];
            }
            else
            {
                $pos = strrpos( $_CONF['rdf_file'], '/' );
                $filename = substr( $_CONF['rdf_file'], $pos + 1 );
            }
            $feed->url = SYND_getFeedUrl( $filename );
            
            $feed->extensions = PLG_getFeedExtensionTags($A['type'], $format[0], $format[1], $A['topic'], $fid, $feed);

            /* Inject the self reference for Atom into RSS feeds. Illogical?
             * Well apparantly not:
             * http://feedvalidator.org/docs/warning/MissingAtomSelfLink.html
             */
            if( $format[0] == 'RSS' )
            {
                $feed->extensions[] = '<atom:link href="' . $feed->url .'" rel="self" type="application/rss+xml" />';
            }
            $feed->articles = $content;

            $feed->createFeed( SYND_getFeedPath( $filename ));
        }
        else
        {
            COM_errorLog( "Unable to get a feed writer for {$format[0]} version {$format[1]}.", 1);
        }

        if( empty( $data ))
        {
            $data = 'NULL';
        }
        else
        {
            $data = "'" . $data . "'";
        }

        if ($_SYND_DEBUG)
        {
            COM_errorLog ("update_info for feed $fid is $data", 1);
        }

        DB_query( "UPDATE {$_TABLES['syndication']} SET updated = NOW(), update_info = $data WHERE fid = $fid");
    }
}

/**
* Truncate a feed item's text to a given max. length of characters
*
* @param    string  $text       the item's text
* @param    int     $length     max. length
* @return   string              truncated text
*
* Note: Use COM_truncateHTML from now on.
*
*/
function SYND_truncateSummary($text, $length)
{
    $storytext = ($length == 1) ? $text : COM_truncateHTML ($text, $length, ' ...');
    
    return $storytext;
}


/**
* Get the path of the feed directory or a specific feed file
*
* @param    string  $feedfile   (option) feed file name
* @return   string              path of feed directory or file
*
*/
function SYND_getFeedPath( $feedfile = '' )
{
    global $_CONF;

    $feedpath = $_CONF['rdf_file'];
    $pos = strrpos( $feedpath, '/' );
    $feed = substr( $feedpath, 0, $pos + 1 );
    $feed .= $feedfile;

    return $feed;
}

/**
* Get the URL of the feed directory or a specific feed file
*
* @param    string  $feedfile   (option) feed file name
* @return   string              URL of feed directory or file
*
*/
function SYND_getFeedUrl( $feedfile = '' )
{
    global $_CONF;

    $feedpath = SYND_getFeedPath();
    $url = substr_replace ($feedpath, $_CONF['site_url'], 0,
                           strlen ($_CONF['path_html']) - 1);
    $url .= $feedfile;

    return $url;
}

/**
* Helper function: Return MIME type for a feed format
*
* @param    string  $format     internal name of the feed format, e.g. Atom-1.0
* @return   string              MIME type, e.g. application/atom+xml
*
*/
function SYND_getMimeType($format)
{
    $fmt = explode('-', $format);
    $type = strtolower($fmt[0]);

    return 'application/' . $type . '+xml';
}

/**
* Helper function: Derive printable feed format name
*
* @param    string  $format     internal name of the feed format, e.g. Atom-1.0
* @return   string              MIME type, e.g. application/atom+xml
*
*/
function SYND_getFeedType($format)
{
    $fmt = explode('-', $format);

    return ucwords($fmt[0]);
}

/**
* Helper function: Get default feed URL
*
* This is mostly for backward compatibility: Back in the dark ages, Geeklog
* only had one RSS feed and its URL was available as a template variable.
* Moved that code here from COM_siteHeader/Footer for better encapsulation.
*
* @return   string      URL of the feed
*
*/
function SYND_getDefaultFeedUrl()
{
    global $_CONF;

    $feed = '';

    if ($_CONF['backend'] > 0) {
        $feed = substr_replace($_CONF['rdf_file'], $_CONF['site_url'], 0,
                               strlen($_CONF['path_html']) - 1);
    }

    return $feed;
}

?>
