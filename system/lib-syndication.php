<?php 

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-syndication.php                                                       |
// |                                                                           |
// | Geeklog syndication library.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003 by the following authors:                              |
// |                                                                           |
// | Authors: Dirk Haun        - dirk@haun-online.de                           |
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
// $Id: lib-syndication.php,v 1.5 2003/12/28 18:48:05 dhaun Exp $

// set to true to enable debug output in error.log
$_SYND_DEBUG = false;

if (eregi ('lib-syndication.php', $PHP_SELF)) {
    die ('This file can not be used on its own.');
}

/**
* Check if a feed for all stories needs to be updated.
*
* @param    string   $update_info   list of story ids
* @param    string   $limit         number of entries or number of hours
* @return   bool                    false = feed needs to be updated
*
*/
function SYND_feedUpdateCheckAll( $update_info, $limit )
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

    // get list of topics that anonymous users have access to
    $tresult = DB_query( "SELECT tid FROM {$_TABLES['topics']}"
                         . COM_getPermSQL( 'WHERE', 1 ));
    $tnumrows = DB_numRows( $tresult );
    $tlist = '';
    for( $i = 1; $i <= $tnumrows; $i++ )
    {
        $T = DB_fetchArray( $tresult );
        $tlist .= "'" . $T['tid'] . "'";
        if( $i < $tnumrows )
        {
            $tlist .= ',';
        }
    }
    if( !empty( $tlist ))
    {
        $where .= " AND (tid IN ($tlist))";
    }

    $result = DB_query( "SELECT sid FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() $where AND perm_anon > 0 ORDER BY date DESC $limitsql" );
    $nrows = DB_numRows( $result );

    $sids = array ();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );
        $sids[] = $A['sid'];
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
* @param    string   $tid           topic id
* @param    string   $update_info   list of story ids
* @param    string   $limit         number of entries or number of hours
* @return   bool                    false = feed needs to be updated
*
*/
function SYND_feedUpdateCheckTopic( $tid, $update_info, $limit )
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

    $result = DB_query( "SELECT sid FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() AND tid = '$tid' AND perm_anon > 0 ORDER BY date DESC $limitsql" );
    $nrows = DB_numRows( $result );

    $sids = array ();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );
        $sids[] = $A['sid'];
    }
    $current = implode( ',', $sids );

    if ($_SYND_DEBUG) {
        COM_errorLog ("Update check for topic $tid: comparing new list ($current) with old list ($update_info)", 1);
    }

    return ( $current != $update_info ) ? false : true;
}

/**
* Check if a feed for the links needs to be updated.
*
* @param    string   $update_info   list of link ids
* @param    string   $limit         number of entries or number of hours
* @return   bool                    false = feed needs to be updated
*
*/
function SYND_feedUpdateCheckLinks( $update_info, $limit )
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

    $result = DB_query( "SELECT lid FROM {$_TABLES['links']} WHERE perm_anon > 0 $where ORDER BY date DESC $limitsql" );
    $nrows = DB_numRows( $result );

    $lids = array();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );
        $lids[] = $A['lid'];
    }
    $current = implode( ',', $lids );

    if ($_SYND_DEBUG) {
        COM_errorLog ("Update check for links: comparing new list ($current) with old list ($update_info)", 1);
    }

    return ( $current != $update_info ) ? false : true;
}

/**
* Check if a feed for the events needs to be updated.
*
* @param    string   $update_info   list of event ids
* @param    string   $limit         number of entries or number of hours
* @return   bool                    false = feed needs to be updated
*
*/
function SYND_feedUpdateCheckEvents( $update_info, $limit )
{
    global $_CONF, $_TABLES, $_SYND_DEBUG;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // next xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND (datestart <= DATE_ADD(NOW(), INTERVAL $hours HOUR))";
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

    $result = DB_query( "SELECT eid FROM {$_TABLES['events']} WHERE perm_anon > 0 AND dateend >= NOW()$where ORDER BY datestart,timestart $limitsql" );

    $eids = array();
    for( $i = 0; $i < $nrows; $i++ )
    {
        $A = DB_fetchArray( $result );
        $eids[] = $A['eid'];
    }
    $current = implode( ',', $eids );

    if ($_SYND_DEBUG) {
        COM_errorLog ("Update check for events: comparing new list ($current) with old list ($update_info)", 1);
    }

    return ( $current != $update_info ) ? false : true;
}

/**
* Check if the feed contents need to be updated.
*
* @param    string   plugin   plugin name
* @param    int      feed     feed id
* @param    string   topic    "topic" of the feed - plugin specific
* @param    string   limit    number of entries or number of hours
* @return   bool              false = feed has to be updated, true = ok
*
*/
function SYND_feedUpdateCheck( $plugin, $feed, $topic, $update_data, $limit )
{
    $is_current = true;

    switch( $topic )
    {
        case '::all':
        {
            $is_current = SYND_feedUpdateCheckAll( $update_data, $limit );
        }
        break;

        case '::links':
        {
            $is_current = SYND_feedUpdateCheckLinks( $update_data, $limit );
        }
        break;

        case '::events':
        {
            $is_current = SYND_feedUpdateCheckEvents( $update_data, $limit );
        }
        break;

        default:
        {
            $is_current = SYND_feedUpdateChecktopic( $topic, $update_data,
                                                     $limit );
        }
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
function SYND_getFeedContentPerTopic( $tid, $limit, &$link, &$update )
{
    global $_TABLES, $_CONF, $LANG01;

    $content = array ();

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

        $result = DB_query( "SELECT sid,uid,title,introtext,postmode,UNIX_TIMESTAMP(date) AS modified FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() AND tid = '$tid' AND perm_anon > 0 ORDER BY date DESC $limitsql" );

        $sids = array();
        $nrows = DB_numRows( $result );

        for( $i = 1; $i <= $nrows; $i++ )
        {
            $row = DB_fetchArray( $result );
            $sids[] = $row['sid'];

            $storytitle = stripslashes( $row['title'] );

            $storytext = stripslashes( $row['introtext'] );
            $storytext = trim( $storytext );
            $storytext = preg_replace( "/(\015)/", "", $storytext );

            $storylink = $_CONF['site_url'] . '/article.php?story='
                       . $row['sid'];

            $content[] = array( 'title'  => $storytitle,
                                'text'   => $storytext,
                                'link'   => $storylink,
                                'uid'    => $row['uid'],
                                'date'   => $row['modified'],
                                'format' => $row['postmode']
                              );
        }
    }

    $link = $_CONF['site_url'] . '/index.php?topic=' . $tid;
    $update = implode( ',', $sids );

    return $content;
}

/**
* Get content for a feed that holds all stories.
*
* @param    string   $limit    number of entries or number of stories
* @param    string   $link     link to homepage
* @param    string   $update   list of story ids
* @return   array              content of the feed
*
*/
function SYND_getFeedContentAll( $limit, &$link, &$update )
{
    global $_TABLES, $_CONF, $LANG01;

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
    $tresult = DB_query( "SELECT tid FROM {$_TABLES['topics']}"
                         . COM_getPermSQL( 'WHERE', 1 ));
    $tnumrows = DB_numRows( $tresult );
    $tlist = '';
    for( $i = 1; $i <= $tnumrows; $i++ )
    {
        $T = DB_fetchArray( $tresult );
        $tlist .= "'" . $T['tid'] . "'";
        if( $i < $tnumrows )
        {
            $tlist .= ',';
        }
    }
    if( !empty( $tlist ))
    {
        $where .= " AND (tid IN ($tlist))";
    }

    $result = DB_query( "SELECT sid,uid,title,introtext,postmode,UNIX_TIMESTAMP(date) AS modified FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() $where AND perm_anon > 0 ORDER BY date DESC $limitsql" );

    $content = array();
    $sids = array();
    $nrows = DB_numRows( $result );

    for( $i = 1; $i <= $nrows; $i++ )
    {
        $row = DB_fetchArray( $result );
        $sids[] = $row['sid'];

        $storytitle = stripslashes( $row['title'] );

        $storytext = stripslashes( $row['introtext'] );
        $storytext = trim( $storytext );
        $storytext = preg_replace( "/(\015)/", "", $storytext );

        $storylink = $_CONF['site_url'] . '/article.php?story=' . $row['sid'];

        $content[] = array( 'title'  => $storytitle,
                            'text'   => $storytext,
                            'link'   => $storylink,
                            'uid'    => $row['uid'],
                            'date'   => $row['modified'],
                            'format' => $row['postmode']
                          );
    }

    $link = $_CONF['site_url'];
    $update = implode( ',', $sids );

    return $content;
}

/**
* Get content for a feed that holds all links.
*
* @param    string   $limit    number of entries or number of stories
* @param    string   $link     link to homepage
* @param    string   $update   list of story ids
* @return   array              content of the feed
*
*/
function SYND_getFeedContentLinks( $limit, &$link, &$update )
{
    global $_TABLES, $_CONF, $LANG01;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // last xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND date >= DATE_SUB(NOW(),INTERVAL $hours HOUR) ORDER BY date DESC";
        }
        else
        {
            $limitsql = ' LIMIT ' . $limit;
            $where = ' ORDER BY lid DESC';
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
        $where = ' ORDER BY lid DESC';
    }

    $result = DB_query( "SELECT lid,owner_id,title,description,UNIX_TIMESTAMP(date) AS modified FROM {$_TABLES['links']} WHERE perm_anon > 0 $where $limitsql" );

    $content = array();
    $lids = array();
    $nrows = DB_numRows( $result );

    for( $i = 1; $i <= $nrows; $i++ )
    {
        $row = DB_fetchArray( $result );
        $lids[] = $row['lid'];

        $linktitle = stripslashes( $row['title'] );
        $linkdesc = stripslashes( $row['description'] );

        $linklink = $_CONF['site_url'] . '/portal.php?what=link&item='
                  . $row['lid'];

        $content[] = array( 'title'  => $linktitle,
                            'text'   => $linkdesc,
                            'link'   => $linklink,
                            'uid'    => $row['owner_id'],
                            'date'   => $row['modified'],
                            'format' => 'plaintext'
                          );
    }

    $link = $_CONF['site_url'] . '/links.php';
    $update = implode( ',', $lids );

    return $content;
}

/**
* Get content for a feed that holds all links.
*
* @param    string   $limit    number of entries or number of stories
* @param    string   $link     link to homepage
* @param    string   $update   list of story ids
* @return   array              content of the feed
*
*/
function SYND_getFeedContentEvents( $limit, &$link, &$update )
{
    global $_TABLES, $_CONF, $LANG01;

    $where = '';
    if( !empty( $limit ))
    {
        if( substr( $limit, -1 ) == 'h' ) // next xx hours
        {
            $limitsql = '';
            $hours = substr( $limit, 0, -1 );
            $where = " AND (datestart <= DATE_ADD(NOW(), INTERVAL $hours HOUR))";
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

    $result = DB_query( "SELECT eid,owner_id,title,description FROM {$_TABLES['events']} WHERE perm_anon > 0 AND dateend >= NOW()$where ORDER BY datestart,timestart $limitsql" );

    $content = array();
    $eids = array();
    $nrows = DB_numRows( $result );

    for( $i = 1; $i <= $nrows; $i++ )
    {
        $row = DB_fetchArray( $result );
        $eids[] = $row['eid'];

        $eventtitle = stripslashes( $row['title'] );
        $eventtext  = stripslashes( $row['description'] );
        $eventlink  = $_CONF['site_url'] . '/calendar_event.php?eid='
                    . $row['eid'];

        // Need to reparse the date from the event id
        $myyear = substr( $row['eid'], 0, 4 );
        $mymonth = substr( $row['eid'], 4, 2 );
        $myday = substr( $row['eid'], 6, 2 );
        $myhour = substr( $row['eid'], 8, 2 );
        $mymin = substr( $row['eid'], 10, 2 );
        $mysec = substr( $row['eid'], 12, 2 );
        $newtime = "{$mymonth}/{$myday}/{$myyear} {$myhour}:{$mymin}:{$mysec}";
        $creationtime = strtotime( $newtime );

        $content[] = array( 'title'  => $eventtitle,
                            'text'   => $eventtext,
                            'link'   => $eventlink,
                            'uid'    => $row['owner_id'],
                            'date'   => $creationtime,
                            'format' => 'plaintext'
                          );
    }

    $link = $_CONF['site_url'] . '/calendar.php';
    $update = implode( ',', $eids );

    return $content;
}

/**
* Update a feed.
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
        require_once( $_CONF['path_system'] . 'classes/' . $A['format']
                      . '.feed.class.php' );
        $feed = new $A['format']();
        $feed->setFeedfile( $A['filename'] );
        $feed->setFeedformats( $A['content_length'], $A['language'],
                               $A['charset'] );

        $link = '';
        $data = '';
        if( $A['type'] == 'geeklog' )
        {
            if( $A['topic'] == '::all')
            {
                $content = SYND_getFeedContentAll( $A['limits'], $link, $data );
            }
            elseif( $A['topic'] == '::links')
            {
                $content = SYND_getFeedContentLinks( $A['limits'], $link,
                                                     $data );
            }
            elseif( $A['topic'] == '::events')
            {
                $content = SYND_getFeedContentEvents( $A['limits'], $link,
                                                      $data );
            }
            else // feed for a single topic only
            {
                $content = SYND_getFeedContentPerTopic( $A['topic'],
                        $A['limits'], $link, $data );
            }
        }
        else
        {
            $content = PLG_getFeedContent( $A['type'], $fid, $link, $data );
        }
        if( empty( $link ))
        {
            $link = $_CONF['site_url'];
        }
        $feed->setFeedinfo( $link, $A['title'], $A['description'] );
        $feed->write( $content );

        if( empty( $data ))
        {
            $data = 'NULL';
        }
        else
        {
            $data = "'" . $data . "'";
        }

        if ($_SYND_DEBUG) {
            COM_errorLog ("update_info for feed $fid is $data", 1);
        }

        DB_query( "UPDATE {$_TABLES['syndication']} SET updated = NOW(), update_info = $data WHERE fid = $fid");
    }
}

?>
