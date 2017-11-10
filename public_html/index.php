<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog homepage.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
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
require_once $_CONF['path_system'] . 'lib-article.php';

/**
 * Update array if need be with correct topic.
 *
 * @param    array  $A        Array of articles from db
 * @param    string $tid_list List of child topics of current topic
 */
function fixTopic(&$A, $tid_list)
{
    global $_TABLES, $topic;

    // This case may happen if a article belongs to the current topic but the default topic for the article is a child  of the current topic.
    $sql = "SELECT t.tid, t.topic, t.imageurl
        FROM {$_TABLES['topics']} t, {$_TABLES['topic_assignments']} ta
        WHERE t.tid = ta.tid";
    // If all topics (blank) then find default topic
    if (!empty($topic)) {
        $sql .= " AND ta.type = 'article' AND ta.id = '{$A['sid']}' AND ta.tid = '$topic'";
    } else {
        $sql .= " AND ta.type = 'article' AND ta.id = '{$A['sid']}'";
    }
    $sql .= COM_getLangSQL('tid', 'AND', 't') . COM_getPermSQL('AND', 0, 2, 't');
    $sql .= " GROUP BY tid, topic, imageurl, ta.tdefault ";
    $sql .= " ORDER BY ta.tdefault DESC"; // Do this just in case story doesn't have a default (it always should) and the current topic is all

    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        $B = DB_fetchArray($result);
        $A['tid'] = $B['tid'];
        $A['topic'] = $B['topic'];
        $A['imageurl'] = $B['imageurl'];
    } else {
        if (!empty($topic)) {
            // Does not belong to current topic so check inherited
            // Make sure sort order the same as in TOPIC_getTopic or articles with multiple topics might not display in the right topic when clicked
            $sql = "SELECT t.tid, t.topic, t.imageurl
                FROM {$_TABLES['topics']} t, {$_TABLES['topic_assignments']} ta
                WHERE t.tid = ta.tid
                AND ta.type = 'article' AND ta.id = '{$A['sid']}'
                AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$topic}')))
                " . COM_getLangSQL('tid', 'AND', 't') . COM_getPermSQL('AND', 0, 2, 't') . "
                GROUP BY t.tid, topic, imageurl, ta.tdefault, ta.tid
                ORDER BY ta.tdefault DESC, ta.tid ASC";

            $result = DB_query($sql);
            $nrows = DB_numRows($result);
            if ($nrows > 0) {
                $B = DB_fetchArray($result);
                $A['tid'] = $B['tid'];
                $A['topic'] = $B['topic'];
                $A['imageurl'] = $B['imageurl'];
            }
        } else {
            // This should not happen as every article should have at least 1 default topic
            $A['tid'] = '';
            $A['topic'] = '';
            $A['imageurl'] = '';
        }
    }
}

// Main
// If URL routing is enabled, then let the router handle the request
if ($_CONF['url_rewrite'] && isset($_CONF['url_routing']) && !empty($_CONF['url_routing'])) {
    \Geeklog\Router::dispatch();
}

// See if user has access to view topic else display message.
// This check has already been done in lib-common so re-check to figure out if
// 404 message needs to be displayed.
$topic_check = '';
$page = 0;
if ($_CONF['url_rewrite']) {
    COM_setArgNames(array(TOPIC_PLACEHOLDER, 'topic', 'page'));
    if (strcasecmp(COM_getArgument(TOPIC_PLACEHOLDER), 'topic') === 0) {
        $topic_check = COM_getArgument('topic');
        $page = (int) COM_getArgument('page');
    }
} else {
    $topic_check = Geeklog\Input::fGet('topic', Geeklog\Input::fPost('topic', ''));
    $page = (int) Geeklog\Input::get('page', 0);
}

if ($topic_check === '-') {
    $topic_check = '';
}

if ($topic_check != '') {
    if (strtolower($topic_check) != strtolower(DB_getItem($_TABLES['topics'], 'tid', "tid = '" . DB_escapeString($topic_check) . "' " . COM_getPermSQL('AND')))) {
        COM_handle404();
    }
}

if ($page == 0) {
    $page = 1;
}

$displayAll = (Geeklog\Input::get('display') === 'all') && empty($topic);

// Retrieve the archive topic - currently only one supported
$archiveTid = DB_getItem($_TABLES['topics'], 'tid', "archive_flag=1");

$display = '';

if (!$displayAll) {
    // give plugins a chance to replace this page entirely
    $newContent = PLG_showCenterblock(0, $page, $topic);
    if (!empty($newContent)) {
        COM_output($newContent);
        exit;
    }
}

if (isset($_GET['msg'])) {
    $plugin = Geeklog\Input::fGet('plugin', '');
    $display .= COM_showMessage((int) Geeklog\Input::fGet('msg'), $plugin);
}

if (SEC_inGroup('Root') && ($page === 1)) {
    $done = DB_getItem($_TABLES['vars'], 'value', "name = 'security_check'");
    if ($done != 1) {
        /**
         * we don't have the path to the admin directory, so try to figure it
         * out from $_CONF['site_admin_url']
         *
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
$displayBlock = PLG_showCenterblock(1, $page, $topic); // top blocks
if (!empty($displayBlock)) {
    $display .= $displayBlock;
    // Check if theme has added the template which allows the centerblock
    // to span the top over the rightblocks
    if (file_exists($_CONF['path_layout'] . 'topcenterblock-span.thtml')) {
        $topspan = COM_newTemplate($_CONF['path_layout']);
        $topspan->set_file(array('topspan' => 'topcenterblock-span.thtml'));
        $topspan->parse('output', 'topspan');
        $display .= $topspan->finish($topspan->get_var('output'));
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
if ((!empty($topic)) && ($maxstories == 0)) {
    $topiclimit = DB_getItem($_TABLES['topics'], 'limitnews', "tid = '" . DB_escapeString($topic) . "'");
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

// Scan for any stories that have expired and should be archived or deleted
$asql = "SELECT sid,ta.tid,title,expire,statuscode FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta ";
$asql .= "WHERE (expire <= NOW()) AND ta.type = 'article' AND ta.id = sid AND ta.tdefault = 1 AND (statuscode = " . STORY_DELETE_ON_EXPIRE;
if (empty($archiveTid)) {
    $asql .= ')';
} else {
    $asql .= ' OR statuscode = ' . STORY_ARCHIVE_ON_EXPIRE . ") AND ta.tid != '" . DB_escapeString($archiveTid) . "'";
}
$expiresql = DB_query($asql);
while (list($sid, $expiretopic, $title, $expire, $statuscode) = DB_fetcharray($expiresql)) {
    if ($statuscode == STORY_ARCHIVE_ON_EXPIRE) {
        if (!empty($archiveTid)) {
            COM_errorLog("Archive Story: $sid, Topic: $archiveTid, Title: $title, Expired: $expire");

            // Delete all topic references to story except topic default
            $asql = "DELETE FROM {$_TABLES['topic_assignments']} "
                . "WHERE type = 'article' AND id = '" . DB_escapeString($sid) . "' AND tdefault = 0";
            DB_query($asql);

            // Now move over story to archive topic
            $asql = "UPDATE {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta
                    SET ta.tid = '" . DB_escapeString($archiveTid) . "', s.frontpage = '0', s.featured = '0'
                    WHERE s.sid='" . DB_escapeString($sid) . "' AND ta.type = 'article' AND ta.id = s.sid AND ta.tdefault = 1";
            DB_query($asql);
        }
    } elseif ($statuscode == STORY_DELETE_ON_EXPIRE) {
        COM_errorLog("Delete Story and comments: $sid, Topic: $expiretopic, Title: $title, Expired: $expire");
        STORY_doDeleteThisStoryNow($sid);
    }
}

// Figure out different settings to display stories in a topic
$sql = " (date <= NOW()) AND (draft_flag = 0)";

if (empty($topic)) {
    $sql .= COM_getLangSQL('tid', 'AND', 'ta');
}

// if a topic was provided only select those stories.
$tid_list = '';
if (!empty($topic)) {
    // Retrieve list of inherited topics
    $tid_list = TOPIC_getChildList($topic);

    // Could have empty list if $topic does not exist or does not have permission so let it equal topic and will error out properly at end
    if (empty($tid_list)) {
        $tid_list = "'" . DB_escapeString($topic) . "'";
    }
    $sql .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '" . DB_escapeString($topic) . "')))";
} else {
    $sql .= " AND frontpage = 1 AND ta.tdefault = 1";
}

if (strtolower($topic) != strtolower($archiveTid)) {
    $sql .= " AND ta.tid != '" . DB_escapeString($archiveTid) . "' ";
}

$sql .= COM_getPermSQL('AND', 0, 2, 's');

if (!empty($U['aids'])) {
    $sql .= " AND s.uid NOT IN (" . str_replace(' ', ",", $U['aids']) . ") ";
}

if (!empty($U['tids'])) {
    $sql .= " AND ta.tid NOT IN ('" . str_replace(' ', "','", $U['tids']) . "') ";
}

$sql .= COM_getTopicSQL('AND', 0, 'ta') . ' ';

$offset = ($page - 1) * $limit;
$userfields = 'u.uid, u.username, u.fullname';
if ($_CONF['allow_user_photo'] == 1) {
    $userfields .= ', u.photo';
    if ($_CONF['use_gravatar']) {
        $userfields .= ', u.email';
    }
}

// The incorrect t.topic, t.imageurl will most likely be returned so removed from this statement
// and added later in fixTopic function. (also because of MySQL 5.7 default install support)
$msql = "SELECT s.*, UNIX_TIMESTAMP(s.date) AS unixdate,
            UNIX_TIMESTAMP(s.expire) as expireunix,
            {$userfields}
            FROM {$_TABLES['stories']} AS s, {$_TABLES['topic_assignments']} AS ta, {$_TABLES['users']} AS u,
            {$_TABLES['topics']} AS t WHERE (s.uid = u.uid) AND (ta.tid = t.tid) AND
            ta.type = 'article' AND ta.id = s.sid " . COM_getLangSQL('sid', 'AND', 's') . " AND
            {$sql} GROUP BY s.sid, s.uid, s.draft_flag, s.date, s.title, s.page_title, s.introtext,  
            s.bodytext, s.text_version, s.hits, s.numemails, s.comments, s.comment_expire, s.trackbacks, 
            s.related, s.featured, s.show_topic_icon, s.commentcode, s.trackbackcode, s.statuscode, s.expire, 
            s.postmode, s.advanced_editor_mode, s.frontpage, s.meta_description, s.meta_keywords,  
            s.cache_time, s.owner_id, s.group_id, s.perm_owner, s.perm_group, s.perm_members, s.perm_anon,  
            expireunix, {$userfields}, date 
            ORDER BY featured DESC, date DESC LIMIT {$offset}, {$limit}";

$result = DB_query($msql);

// Figure out number of total pages
$data = DB_query("SELECT s.sid FROM {$_TABLES['stories']} AS s, {$_TABLES['topic_assignments']} AS ta WHERE ta.type = 'article' AND ta.id = s.sid AND $sql GROUP BY s.sid");
$nrows = DB_numRows($data);
$num_pages = ceil($nrows / $limit);

$breadcrumbs = '';

if ($A = DB_fetchArray($result)) {
    fixTopic($A, $tid_list);
    $story = new Article();
    $story->loadFromArray($A);
    if ($_CONF['showfirstasfeatured'] == 1) {
        $story->_featured = 1;
    }

    // Display breadcrumb trail
    if (!empty($topic)) {
        $breadcrumbs = TOPIC_breadcrumbs('topic', $topic);
        if ($_CONF['supported_version_theme'] === '1.8.1') {
            $display .= $breadcrumbs;
        }
    }

    // display first article
    $display .= STORY_renderArticle($story, 'y');

    // get plugin center blocks after featured article
    if ($story->DisplayElements('featured') == 1) {
        $display .= PLG_showCenterblock(2, $page, $topic);
    }

    // get remaining stories
    while ($A = DB_fetcharray($result)) {
        fixTopic($A, $tid_list);
        $story = new Article();
        $story->loadFromArray($A);
        $display .= STORY_renderArticle($story, 'y');
    }

    // get plugin center blocks that follow articles
    $display .= PLG_showCenterblock(3, $page, $topic); // bottom blocks

    // Print Google-like paging navigation
    if (!isset($_CONF['hide_main_page_navigation']) ||
        ($_CONF['hide_main_page_navigation'] == 'false') ||
        ($_CONF['hide_main_page_navigation'] === 'frontpage' && !empty($topic))) {
        if ($_CONF['url_rewrite']) {
            $tempTopic = empty($topic) ? '-' : $topic;
            $base_url = COM_buildURL(
                $_CONF['site_url'] . '/index.php?'
                . http_build_query(array(
                    TOPIC_PLACEHOLDER => 'topic',
                    'topic'           => $tempTopic,
                ))
            );
        } else {
            if (!empty($topic)) {
                $base_url = COM_buildURL(
                    $_CONF['site_url'] . '/index.php?'
                    . http_build_query(array(
                        'topic' => $topic,
                    ))
                );
            } else {
                $base_url = $_CONF['site_url'] . '/index.php';
            }
        }

        $display .= COM_printPageNavigation($base_url, $page, $num_pages, 'page=', (bool) $_CONF['url_rewrite']);
    }
} else { // no stories to display
    if ($page == 1) {
        if (!isset($_CONF['hide_no_news_msg']) || ($_CONF['hide_no_news_msg'] == 0)) {
            $display .= COM_startBlock($LANG05[1], '',
                    COM_getBlockTemplate('_msg_block', 'header')) . $LANG05[2];
            $display .= COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
        }

        $display .= PLG_showCenterblock(3, $page, $topic); // bottom blocks
    } else {
        $topic_url = '';
        if (!empty($topic)) {
            $topic_url = TOPIC_getUrl($topic);
        }
        COM_handle404($topic_url);
    }
}

$header = '';

if ($topic) {
    // Meta Tags
    if ($_CONF['meta_tags'] > 0) {
        $result = DB_query("SELECT meta_description, meta_keywords FROM {$_TABLES['topics']} WHERE tid = '" . DB_escapeString($topic) . "'");
        $A = DB_fetcharray($result);
        $header .= LB . PLG_getMetaTags(
                'homepage', '',
                array(
                    array(
                        'name'    => 'description',
                        'content' => stripslashes($A['meta_description']),
                    ),
                    array(
                        'name'    => 'keywords',
                        'content' => stripslashes($A['meta_keywords']),
                    ),
                )
            );
    }
}

$display = COM_createHTMLDocument(
    $display,
    array(
        'breadcrumbs' => $breadcrumbs,
        'headercode'  => $header,
        'rightblock'  => true,
    )
);

// Output page
COM_output($display);
