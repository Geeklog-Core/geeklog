<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog homepage.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: index.php,v 1.90 2007/01/11 20:40:40 mjervis Exp $

require_once ('lib-common.php');
require_once ($_CONF['path_system'] . 'lib-story.php');

$newstories = false;
$displayall = false;
if (isset ($_GET['display']) && empty ($topic)) {
    if ($_GET['display'] == 'new') {
        $newstories = true;
    } else if ($_GET['display'] == 'all') {
        $displayall = true;
    }
}

// Retrieve the archive topic - currently only one supported
$archivetid = DB_getItem ($_TABLES['topics'], 'tid', "archive_flag=1");

// Microsummary support:
// see: http://wiki.mozilla.org/Microsummaries
if( array_key_exists('microsummary',$_GET) )
{   
    $sql = " (date <= NOW()) AND (draft_flag = 0)";

    if (empty ($topic)) {
        $sql .= COM_getLangSQL ('tid', 'AND', 's');
    }
    
    // if a topic was provided only select those stories.
    if (!empty($topic)) {
        $sql .= " AND s.tid = '$topic' ";
    } elseif (!$newstories) {
        $sql .= " AND frontpage = 1 ";
    }
    
    if ($topic != $archivetid) {
        $sql .= " AND s.tid != '{$archivetid}' ";
    }
    
    $sql .= COM_getPermSQL ('AND', 0, 2, 's');
    $sql .= COM_getTopicSQL ('AND', 0, 's') . ' ';
    $msql = array();
    $msql['mysql']="SELECT STRAIGHT_JOIN s.title "
         . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, "
         . "{$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (s.tid = t.tid) AND"
         . $sql . "ORDER BY featured DESC, date DESC LIMIT 0, 1";

    $msql['mssql']="SELECT STRAIGHT_JOIN s.title "
         . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, "
         . "{$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (s.tid = t.tid) AND"
         . $sql . "ORDER BY featured DESC, date DESC LIMIT 0, 1";
    $result = DB_query ($msql);

    if ( $A = DB_fetchArray( $result ) ) {
        $pagetitle = $_CONF['microsummary_short'].$A['title'];
    } else {
        if(isset( $_CONF['pagetitle'] ))
        {
            $pagetitle = $_CONF['pagetitle'];
        }
        if( empty( $pagetitle ))
        {
            if( empty( $topic ))
            {
                $pagetitle = $_CONF['site_slogan'];
            }
            else
            {
                $pagetitle = stripslashes( DB_getItem( $_TABLES['topics'], 'topic',
                                                       "tid = '$topic'" ));
            }
        }
        $pagetitle = $_CONF['site_name'] . ' - ' . $pagetitle;
    }    
    die($pagetitle);
}


$page = 1;
if (isset ($_GET['page'])) {
    $page = COM_applyFilter ($_GET['page'], true);
    if ($page == 0) {
        $page = 1;
    }
}

$display = '';

if (!$newstories && !$displayall) {
    // give plugins a chance to replace this page entirely
    $newcontent = PLG_showCenterblock (0, $page, $topic);
    if (!empty ($newcontent)) {
        echo $newcontent;
        exit;
    }
}

if($topic)
{
    $header = '<link rel="microsummary" href="index.php?topic='
                . urlencode($topic) . '&amp;microsummary" />';
} else {
    $header = '<link rel="microsummary" href="index.php?microsummary" />';
}
$display .= COM_siteHeader('menu', '', $header);
if (isset ($_GET['msg'])) {
    $plugin = '';
    if (isset ($_GET['plugin'])) {
        $plugin = COM_applyFilter ($_GET['plugin']);
    }
    $display .= COM_showMessage (COM_applyFilter ($_GET['msg'], true), $plugin);
}


// Show any Plugin formatted blocks
// Requires a plugin to have a function called plugin_centerblock_<plugin_name>
$displayBlock = PLG_showCenterblock (1, $page, $topic); // top blocks
if (!empty ($displayBlock)) {
    $display .= $displayBlock;
    // Check if theme has added the template which allows the centerblock
    // to span the top over the rightblocks
    if (file_exists($_CONF['path_layout'] . 'topcenterblock-span.thtml')) {
            $topspan = new Template($_CONF['path_layout']);
            $topspan->set_file (array ('topspan'=>'topcenterblock-span.thtml'));
            $topspan->parse ('output', 'topspan');
            $display .= $topspan->finish ($topspan->get_var('output'));
            $GLOBALS['centerspan'] = true;
    }
}

if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
    $result = DB_query("SELECT maxstories,tids,aids FROM {$_TABLES['userindex']} WHERE uid = '{$_USER['uid']}'");
    $U = DB_fetchArray($result);
} else {
    $U['maxstories'] = 0;
}

$maxstories = 0;
if ($U['maxstories'] >= $_CONF['minnews']) {
    $maxstories = $U['maxstories'];
}
if ((!empty ($topic)) && ($maxstories == 0)) {
    $topiclimit = DB_getItem ($_TABLES['topics'], 'limitnews',
                              "tid = '{$topic}'");
    if ($topiclimit >= $_CONF['minnews']) {
        $maxstories = $topiclimit;
    }
}
if ($maxstories == 0) {
    $maxstories = $_CONF['limitnews'];
}

$limit = $maxstories;

// Geeklog now allows for articles to be published in the future.  Because of
// this, we need to check to see if we need to rebuild the RDF file in the case
// that any such articles have now been published
COM_rdfUpToDateCheck();

// For similar reasons, we need to see if there are currently two featured
// articles.  Can only have one but you can have one current featured article
// and one for the future...this check will set the latest one as featured
// solely
COM_featuredCheck();

// Scan for any stories that have expired and should be archived or deleted
$asql = "SELECT sid,tid,title,expire,statuscode FROM {$_TABLES['stories']} ";
$asql .= 'WHERE (expire <= NOW()) AND (statuscode = ' . STORY_DELETE_ON_EXPIRE;
if (empty ($archivetid)) {
    $asql .= ')';
} else {
    $asql .= ' OR statuscode = ' . STORY_ARCHIVE_ON_EXPIRE . ") AND tid != '$archivetid'";
}
$expiresql = DB_query ($asql);
while (list ($sid, $expiretopic, $title, $expire, $statuscode) = DB_fetchArray ($expiresql)) {
    if ($statuscode == STORY_ARCHIVE_ON_EXPIRE) {
        if (!empty ($archivetid) ) {
            COM_errorLOG("Archive Story: $sid, Topic: $archivetid, Title: $title, Expired: $expire");
            DB_query ("UPDATE {$_TABLES['stories']} SET tid = '$archivetid', frontpage = '0', featured = '0' WHERE sid='{$sid}'");
        }
    } else if ($statuscode == STORY_DELETE_ON_EXPIRE) {
        COM_errorLOG("Delete Story and comments: $sid, Topic: $expiretopic, Title: $title, Expired: $expire");
        STORY_deleteImages ($sid);
        DB_query("DELETE FROM {$_TABLES['comments']} WHERE sid='{$sid}' AND type = 'article'");
        DB_query("DELETE FROM {$_TABLES['stories']} WHERE sid='{$sid}'");
    }
}

$sql = " (date <= NOW()) AND (draft_flag = 0)";

if (empty ($topic)) {
    $sql .= COM_getLangSQL ('tid', 'AND', 's');
}

// if a topic was provided only select those stories.
if (!empty($topic)) {
    $sql .= " AND s.tid = '$topic' ";
} elseif (!$newstories) {
    $sql .= " AND frontpage = 1 ";
}

if ($topic != $archivetid) {
    $sql .= " AND s.tid != '{$archivetid}' ";
}

$sql .= COM_getPermSQL ('AND', 0, 2, 's');

if (!empty($U['aids'])) {
    $sql .= " AND s.uid NOT IN (" . str_replace( ' ', ",", $U['aids'] ) . ") ";
}

if (!empty($U['tids'])) {
    $sql .= " AND s.tid NOT IN ('" . str_replace( ' ', "','", $U['tids'] ) . "') ";
}

$sql .= COM_getTopicSQL ('AND', 0, 's') . ' ';

if ($newstories) {
    $sql .= "AND (date >= (date_sub(NOW(), INTERVAL {$_CONF['newstoriesinterval']} SECOND))) ";
}

$offset = ($page - 1) * $limit;
$userfields = 'u.uid, u.username, u.fullname';
if ($_CONF['allow_user_photo'] == 1) {
    $userfields .= ', u.photo';
    if ($_CONF['use_gravatar']) {
        $userfields .= ', u.email';
    }
}

$msql = array();
$msql['mysql']="SELECT STRAIGHT_JOIN s.*, UNIX_TIMESTAMP(s.date) AS unixdate, "
         . $userfields . ", t.topic, t.imageurl "
         . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, "
         . "{$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (s.tid = t.tid) AND"
         . $sql . "ORDER BY featured DESC, date DESC LIMIT $offset, $limit";

$msql['mssql']="SELECT STRAIGHT_JOIN s.sid, s.uid, s.draft_flag, s.tid, s.date, s.title, cast(s.introtext as text) as introtext, cast(s.bodytext as text) as bodytext, s.hits, s.numemails, s.comments, s.trackbacks, s.related, s.featured, s.show_topic_icon, s.commentcode, s.trackbackcode, s.statuscode, s.expire, s.postmode, s.frontpage, s.in_transit, s.owner_id, s.group_id, s.perm_owner, s.perm_group, s.perm_members, s.perm_anon, s.advanced_editor_mode, "
         . " UNIX_TIMESTAMP(s.date) AS unixdate, "
         . $userfields . ", t.topic, t.imageurl "
         . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, "
         . "{$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (s.tid = t.tid) AND"
         . $sql . "ORDER BY featured DESC, date DESC LIMIT $offset, $limit";

$result = DB_query ($msql);

$nrows = DB_numRows ($result);

$data = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} AS s WHERE" . $sql);
$D = DB_fetchArray ($data);
$num_pages = ceil ($D['count'] / $limit);

if ( $A = DB_fetchArray( $result ) ) {

    $story = new Story();
    $story->loadFromArray($A);
    if ( $_CONF['showfirstasfeatured'] == 1 ) {
        $story->_featured = 1;
    }

    // display first article
    $display .= STORY_renderArticle ($story, 'y');

    // get plugin center blocks after featured article
    if ($story->DisplayElements('featured') == 1) {
        $display .= PLG_showCenterblock (2, $page, $topic);
    }

    // get remaining stories
    while ($A = DB_fetchArray ($result)) {
        $story = new Story();
        $story->loadFromArray($A);
        $display .= STORY_renderArticle ($story, 'y');
    }

    // get plugin center blocks that follow articles
    $display .= PLG_showCenterblock (3, $page, $topic); // bottom blocks

    // Print Google-like paging navigation
    if (!isset ($_CONF['hide_main_page_navigation']) ||
            ($_CONF['hide_main_page_navigation'] == 0)) {
        if (empty ($topic)) {
            $base_url = $_CONF['site_url'] . '/index.php';
            if ($newstories) {
                $base_url .= '?display=new';
            }
        } else {
            $base_url = $_CONF['site_url'] . '/index.php?topic=' . $topic;
        }
        $display .= COM_printPageNavigation ($base_url, $page, $num_pages);
    }
} else { // no stories to display
    if (!isset ($_CONF['hide_no_news_msg']) ||
            ($_CONF['hide_no_news_msg'] == 0)) {
        $display .= COM_startBlock ($LANG05[1], '',
                    COM_getBlockTemplate ('_msg_block', 'header')) . $LANG05[2];
        if (!empty ($topic)) {
            $topicname = DB_getItem ($_TABLES['topics'], 'topic',
                                     "tid = '$topic'");
            $display .= sprintf ($LANG05[3], $topicname);
        }
        $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    $display .= PLG_showCenterblock (3, $page, $topic); // bottom blocks
}

$display .= COM_siteFooter (true); // The true value enables right hand blocks.

// Output page
echo $display;

?>
