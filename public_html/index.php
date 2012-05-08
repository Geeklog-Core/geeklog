<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog homepage.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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

require_once 'lib-common.php';
require_once $_CONF['path_system'] . 'lib-story.php';

$newstories = false;
$displayall = false;
$microsummary = false;
if (isset ($_GET['display'])) {
    if (($_GET['display'] == 'new') && (empty ($topic))) {
        $newstories = true;
    } else if (($_GET['display'] == 'all') && (empty ($topic))) {
        $displayall = true;
    } else if ($_GET['display'] == 'microsummary') {
        $microsummary = true;
    }
}

// Retrieve the archive topic - currently only one supported
$archivetid = DB_getItem ($_TABLES['topics'], 'tid', "archive_flag=1");

// Microsummary support:
// see: http://wiki.mozilla.org/Microsummaries
if( $microsummary )
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
         
      $msql['pgsql']="SELECT s.title "
     . "FROM {$_TABLES['stories']} AS s, {$_TABLES['users']} AS u, "
     . "{$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (s.tid = t.tid) AND"
     . $sql . "ORDER BY featured DESC, date DESC LIMIT 1 OFFSET 0";
         
    $result = DB_query ($msql);

    if ( $A = DB_fetchArray( $result ) ) {
        $pagetitle = $_CONF['microsummary_short'].$A['title'];
    } else {
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
    header('Content-Type: text/plain; charset=' . COM_getCharset());
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
        COM_output($newcontent);
        exit;
    }
}

if (isset ($_GET['msg'])) {
    $plugin = '';
    if (isset ($_GET['plugin'])) {
        $plugin = COM_applyFilter ($_GET['plugin']);
    }
    $display .= COM_showMessage (COM_applyFilter ($_GET['msg'], true), $plugin);
}

if (SEC_inGroup('Root') && ($page == 1)) {
    $done = DB_getItem($_TABLES['vars'], 'value', "name = 'security_check'");
    if ($done != 1) {
        /**
         * we don't have the path to the admin directory, so try to figure it
         * out from $_CONF['site_admin_url']
         * @todo FIXME: this duplicates some code from admin/sectest.php
         */
        $adminurl = $_CONF['site_admin_url'];
        if (strrpos($adminurl, '/') == strlen($adminurl)) {
            $adminurl = substr($adminurl, 0, -1);
        }
        $pos = strrpos($adminurl, '/');
        if ($pos === false) {
            // only guessing ...
            $installdir = $_CONF['path_html'] . 'admin/install';
        } else {
            $installdir = $_CONF['path_html'] . substr($adminurl, $pos + 1)
                        . '/install';
        }

        if (is_dir($installdir)) {
            // deliberatly NOT print the actual path to the install dir
            $secmsg = sprintf($LANG_SECTEST['remove_inst'], '')
                    . ' ' . $MESSAGE[92];
            $display .= COM_showMessageText($secmsg);
        }
    }
}

// Show any Plugin formatted blocks
// Requires a plugin to have a function called plugin_centerblock_<plugin_name>
$displayBlock = PLG_showCenterblock (1, $page, $topic); // top blocks
if (!empty ($displayBlock)) {
    $display .= $displayBlock;
    // Check if theme has added the template which allows the centerblock
    // to span the top over the rightblocks
    if (file_exists($_CONF['path_layout'] . 'topcenterblock-span.thtml')) {
            $topspan = COM_newTemplate($_CONF['path_layout']);
            $topspan->set_file (array ('topspan'=>'topcenterblock-span.thtml'));
            $topspan->parse ('output', 'topspan');
            $display .= $topspan->finish ($topspan->get_var('output'));
            $GLOBALS['centerspan'] = true;
    }
}

if (COM_isAnonUser()) {
    $U['maxstories'] = 0;
} else {
    $result = DB_query("SELECT maxstories,tids,aids FROM {$_TABLES['userindex']} WHERE uid = '{$_USER['uid']}'");
    $U = DB_fetchArray($result);
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
if ($limit < 1) {
    $limit = 1;
}

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
$asql = "SELECT sid,ta.tid,title,expire,statuscode FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta ";
$asql .= "WHERE (expire <= NOW()) AND ta.type = 'article' AND ta.id = sid AND ta.tdefault = 1 AND (statuscode = " . STORY_DELETE_ON_EXPIRE;
if (empty ($archivetid)) {
    $asql .= ')';
} else {
    $asql .= ' OR statuscode = ' . STORY_ARCHIVE_ON_EXPIRE . ") AND ta.tid != '$archivetid'";
}
$expiresql = DB_query ($asql);
while (list ($sid, $expiretopic, $title, $expire, $statuscode) = DB_fetchArray ($expiresql)) {
    if ($statuscode == STORY_ARCHIVE_ON_EXPIRE) {
        if (!empty ($archivetid) ) {
            COM_errorLog("Archive Story: $sid, Topic: $archivetid, Title: $title, Expired: $expire");
            DB_query ("UPDATE {$_TABLES['stories']} SET tid = '$archivetid', frontpage = '0', featured = '0' WHERE sid='{$sid}'");
        }
    } else if ($statuscode == STORY_DELETE_ON_EXPIRE) {
        COM_errorLog("Delete Story and comments: $sid, Topic: $expiretopic, Title: $title, Expired: $expire");
        STORY_doDeleteThisStoryNow($sid);
    }
}

$sql = " (date <= NOW()) AND (draft_flag = 0)";

if (empty ($topic)) {
    $sql .= COM_getLangSQL ('ta.tid', 'AND', 'ta');
}

// if a topic was provided only select those stories.
if (!empty($topic)) {
    // Retrieve list of inherited topics
    $tid_list = TOPIC_getChildList($topic);
    // Get list of blocks to display (except for dynamic). This includes blocks for all topics, and child blocks that are inherited
    $sql .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$topic}')))";
} elseif (!$newstories) {
    $sql .= " AND frontpage = 1 AND ta.tdefault = 1";
}

if ($topic != $archivetid) {
    $sql .= " AND ta.tid != '{$archivetid}' ";
}

$sql .= COM_getPermSQL ('AND', 0, 2, 's');

if (!empty($U['aids'])) {
    $sql .= " AND s.uid NOT IN (" . str_replace( ' ', ",", $U['aids'] ) . ") ";
}

if (!empty($U['tids'])) {
    $sql .= " AND ta.tid NOT IN ('" . str_replace( ' ', "','", $U['tids'] ) . "') ";
}

$sql .= COM_getTopicSQL ('AND', 0, 'ta') . ' ';

if ($newstories) {
    switch ($_DB_dbms) {
    case 'mysql':
        $sql .= "AND (date >= (date_sub(NOW(), INTERVAL {$_CONF['newstoriesinterval']} SECOND))) ";
        break;
    case 'pgsql':
        $sql .= "AND (date >= (NOW() - INTERVAL '{$_CONF['newstoriesinterval']} SECOND')) ";
        break;
    case 'mssql':
        $sql .= "AND (date >= (date_sub(NOW(), INTERVAL {$_CONF['newstoriesinterval']} SECOND))) ";
        break;
    }
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
$msql['mysql']="SELECT STRAIGHT_JOIN s.*, ta.tid, UNIX_TIMESTAMP(s.date) AS unixdate, "
         . 'UNIX_TIMESTAMP(s.expire) as expireunix, '
         . $userfields . ", t.topic, t.imageurl "
         . "FROM {$_TABLES['stories']} AS s, {$_TABLES['topic_assignments']} AS ta,{$_TABLES['users']} AS u, "
         . "{$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (ta.tid = t.tid) AND"
         . " ta.type = 'article' AND ta.id = s.sid AND"
         . $sql . " GROUP BY s.sid ORDER BY featured DESC, date DESC LIMIT $offset, $limit";

$msql['mssql']="SELECT STRAIGHT_JOIN s.sid, s.uid, s.draft_flag, ta.tid, s.date, s.title, cast(s.introtext as text) as introtext, cast(s.bodytext as text) as bodytext, s.hits, s.numemails, s.comments, s.trackbacks, s.related, s.featured, s.show_topic_icon, s.commentcode, s.trackbackcode, s.statuscode, s.expire, s.postmode, s.frontpage, s.owner_id, s.group_id, s.perm_owner, s.perm_group, s.perm_members, s.perm_anon, s.advanced_editor_mode, "
         . " UNIX_TIMESTAMP(s.date) AS unixdate, "
         . 'UNIX_TIMESTAMP(s.expire) as expireunix, '
         . $userfields . ", t.topic, t.imageurl "
         . "FROM {$_TABLES['stories']} AS s, {$_TABLES['topic_assignments']} AS ta, {$_TABLES['users']} AS u, "
         . "{$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (ta.tid = t.tid) AND"
         . " ta.type = 'article' AND ta.id = s.sid AND"
         . $sql . " GROUP BY s.sid ORDER BY featured DESC, date DESC LIMIT $offset, $limit";
$msql['pgsql']="SELECT s.*, ta.tid, UNIX_TIMESTAMP(s.date) AS unixdate,
            UNIX_TIMESTAMP(s.expire) as expireunix,
            {$userfields}, t.topic, t.imageurl
            FROM {$_TABLES['stories']} AS s, {$_TABLES['topic_assignments']} AS ta, {$_TABLES['users']} AS u,
            {$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (ta.tid = t.tid) AND 
            ta.type = 'article' AND ta.id = s.sid AND 
            {$sql} GROUP BY s.sid ORDER BY featured DESC, date DESC LIMIT {$limit} OFFSET {$offset}";

$result = DB_query ($msql);

$nrows = DB_numRows ($result);

$data = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} AS s, {$_TABLES['topic_assignments']} AS ta WHERE ta.type = 'article' AND ta.id = s.sid AND $sql");
$D = DB_fetchArray ($data);
$num_pages = ceil ($D['count'] / $limit);

$breadcrumbs = '';

if ( $A = DB_fetchArray( $result ) ) {
    $story = new Story();
    $story->loadFromArray($A);
    if ( $_CONF['showfirstasfeatured'] == 1 ) {
        $story->_featured = 1;
    }

    
    // Display breadcrumb trail
    if (!empty($topic)) {
        $breadcrumbs = TOPIC_breadcrumbs('topic', $topic);
        if ($_CONF['supported_version_theme'] == '1.8.1') {
            $display .= $breadcrumbs;
        }
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

if ($topic)
{
    $header = '<link rel="microsummary" href="' . $_CONF['site_url']
            . '/index.php?display=microsummary&amp;topic=' . urlencode($topic)
            . '" title="Microsummary"' . XHTML . '>';

    // Meta Tags
    if ($_CONF['meta_tags'] > 0) {
        $result = DB_query ("SELECT meta_description, meta_keywords FROM {$_TABLES['topics']} WHERE tid = '{$topic}'");
        $A = DB_fetchArray ($result);

        $meta_description = stripslashes($A['meta_description']);
        $meta_keywords = stripslashes($A['meta_keywords']);
        $header .= COM_createMetaTags($meta_description, $meta_keywords);
    }
} else {
    $header = '<link rel="microsummary" href="' . $_CONF['site_url']
            . '/index.php?display=microsummary" title="Microsummary"' . XHTML
            . '>';
}

$display = COM_createHTMLDocument($display, array('breadcrumbs' => $breadcrumbs, 'headercode' => $header, 'rightblock' => true));

// Output page
COM_output($display);

?>
