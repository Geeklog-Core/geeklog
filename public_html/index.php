<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog homepage.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
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
// $Id: index.php,v 1.64 2004/08/25 21:25:46 blaine Exp $

require_once ('lib-common.php');
require_once ($_CONF['path_system'] . 'lib-story.php');

$newstories = false;
$displayall = false;
if (isset ($HTTP_GET_VARS['display']) && empty ($topic)) {
    if ($HTTP_GET_VARS['display'] == 'new') {
        $newstories = true;
    } else if ($HTTP_GET_VARS['display'] == 'all') {
        $displayall = true;
    }
}

$page = 1;
if (isset ($HTTP_GET_VARS['page'])) {
    $page = COM_applyFilter ($HTTP_GET_VARS['page'], true);
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

$display .= COM_siteHeader();
if (isset ($HTTP_GET_VARS['msg'])) {
    $display .= COM_showMessage (COM_applyFilter ($HTTP_GET_VARS['msg'], true),COM_applyFilter ($HTTP_GET_VARS['plugin']));
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

$maxstories = 0;

if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
    $result = DB_query("SELECT noboxes,maxstories,tids,aids FROM {$_TABLES['userindex']} WHERE uid = '{$_USER['uid']}'");
    $U = DB_fetchArray($result);
    if ($U['maxstories'] >= $_CONF['minnews']) {
        $maxstories = $U['maxstories'];
    }
    if ((!empty($topic)) && ($maxstories == 0)) {
        $tmp = DB_query("SELECT limitnews FROM {$_TABLES['topics']} WHERE tid = '{$topic}'");
        $T = DB_fetchArray($tmp);
        if ($T['limitnews'] >= $_CONF['minnews']) {
            $maxstories = $T['limitnews'];
        }
    }
    if ($maxstories == 0) {
        $maxstories = $_CONF['limitnews'];
    }
    $U['maxstories'] = $maxstories;
} else {
    $U['maxstories'] = $_CONF['limitnews'];
    /* HELPME: should we check for topic "limitnews" value? */
}

$limit = $U['maxstories'];

// Geeklog now allows for articles to be published in the future.  Because of
// this, we need to check to see if we need to rebuild the RDF file in the case
// that any such articles have now been published
COM_rdfUpToDateCheck();

// For similar reasons, we need to see if there are currently two featured
// articles.  Can only have one but you can have one current featured article
// and one for the future...this check will set the latest one as featured
// solely
COM_featuredCheck();

// Scan for any stories that have expired and should be deleted
// Retrieve the archive topic - currently only one supported
$archivetid = DB_getItem($_TABLES['topics'],'tid',"archive_flag='1'");
$expiresql = DB_query("SELECT sid,tid,title,expire,statuscode FROM {$_TABLES['stories']}"
            . " WHERE (expire <= NOW()) AND "
            . " ( statuscode = " .STORY_ARCHIVE_ON_EXPIRE." OR statuscode = ".STORY_DELETE_ON_EXPIRE." )");
while (list ($sid,$expiretopic,$title,$expire,$statuscode) = DB_fetchArray($expiresql)) {
    if ( $archivetid != '' AND $statuscode == STORY_ARCHIVE_ON_EXPIRE ) {
        COM_errorLOG("Archive Story: $sid, Topic:$archivetid, Title: $title. Expired :$expire");
        DB_query("UPDATE {$_TABLES['stories']} SET tid = '$archivetid' WHERE sid='{$sid}'");
    } elseif ($statuscode == STORY_DELETE_ON_EXPIRE) {
        COM_errorLOG("Delete Story and comments: $sid, Topic:$expiretopic, Title: $title. Expired :$expire");
        STORY_deleteImages ($sid);
        DB_query("DELETE FROM {$_TABLES['comments']} WHERE sid='{$sid}'");
        DB_query("DELETE FROM {$_TABLES['stories']} WHERE sid='{$sid}'");
    }
}
$sql = " (date <= NOW()) AND (draft_flag = 0)";

// if a topic was provided only select those stories.
if (!empty($topic)) {
    $sql .= " AND s.tid = '$topic' ";
} elseif (!$newstories) {
    $sql .= " AND frontpage = 1 ";
}
if ($topic != $_CONF['archivetopic']) {
    $sql .= " AND s.tid != '{$_CONF['archivetopic']}' ";
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
$sql .= "ORDER BY featured DESC, date DESC";

$result = DB_query ("SELECT STRAIGHT_JOIN s.*, UNIX_TIMESTAMP(s.date) as day, "
         . "u.username, u.fullname, u.photo, t.topic, t.imageurl "
         . "FROM {$_TABLES['stories']} as s, {$_TABLES['users']} as u, "
	 . "{$_TABLES['topics']} as t WHERE (s.uid = u.uid) AND (s.tid = t.tid) AND"
         . $sql . " LIMIT $offset, $limit");
$nrows = DB_numRows ($result);

$data = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} as s WHERE" . $sql);
$D = DB_fetchArray ($data);
$num_pages = ceil ($D['count'] / $limit);

if ( $A = DB_fetchArray( $result ) ) {

    if ( $_CONF['showfirstasfeatured'] == 1 ) {
        $A['featured'] = 1;
    }

    // display first article
    $display .= STORY_renderArticle ($A, 'y');

    // get plugin center blocks after featured article
    if ($A['featured'] == 1) {
        $display .= PLG_showCenterblock (2, $page, $topic);
    }

    // get reamaining stories
    while ( $A = DB_fetchArray($result) ) {
        $display .= STORY_renderArticle ($A, 'y');
    }

    // get plugin center blocks that follow articles
    $display .= PLG_showCenterblock (3, $page, $topic); // bottom blocks

    // Print Google-like paging navigation
    if (empty($topic)) {
        $base_url = $_CONF['site_url'] . '/index.php';
        if ($newstories) {
            $base_url .= '?display=new';
        }
    } else {
        $base_url = $_CONF['site_url'] . '/index.php?topic=' . $topic;
    }
    $display .= COM_printPageNavigation($base_url,$page, $num_pages);
} else { // no stories to display
    $display .= COM_startBlock ($LANG05[1], '',
                    COM_getBlockTemplate ('_msg_block', 'header')) . $LANG05[2];
    if (!empty($topic)) {
        $topicname = DB_getItem ($_TABLES['topics'], 'topic', "tid='{$topic}'");
        $display .= sprintf ($LANG05[3], $topicname);
    }
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

    $display .= PLG_showCenterblock (3, $page, $topic); // bottom blocks
}

$display .= COM_siteFooter (true); // The true value enables right hand blocks.

// Output page 
echo $display;

?>
