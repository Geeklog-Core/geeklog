<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// | Geeklog homepage.                                                         |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@users.sourceforge.net                |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
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
// $Id: index.php,v 1.51 2003/07/01 17:48:56 dhaun Exp $

if (isset ($HTTP_GET_VARS['topic'])) {
    $topic = strip_tags ($HTTP_GET_VARS['topic']);
}
else {
    $topic = '';
}

$newstories = false;
$displayall = false;
if (isset ($HTTP_GET_VARS['display']) && empty ($topic)) {
    if ($HTTP_GET_VARS['display'] == 'new') {
        $newstories = true;
    } else if ($HTTP_GET_VARS['display'] == 'all') {
        $displayall = true;
    }
}

if (isset ($HTTP_GET_VARS['page'])) {
    $page = $HTTP_GET_VARS['page'];
}
if (empty ($page)) {
    // If no page sent then assume the first.
    $page = 1;
}

require_once('lib-common.php');

$display = '';

if (!$newstories && !$displayall) {
    // give plugins a chance to replace this page entirely
    $newcontent = PLG_showCenterblock (0, $page, $topic);
    if (!empty ($newcontent)) {
        echo $newcontent;
        exit;
    }
}

$display .= COM_siteHeader() . COM_showMessage ($HTTP_GET_VARS['msg']);



// Show any Plugin formatted blocks
// Requires a plugin to have a function called plugin_centerblock_<plugin_name>
$display .= PLG_showCenterblock (1, $page, $topic); // top blocks

$maxstories = 0;

if (!empty($_USER['uid'])) {
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

$sql = "FROM {$_TABLES['stories']} WHERE (date <= NOW()) AND (draft_flag = 0)";

// if a topic was provided only select those stories.
if (!empty($topic)) {
    $sql .= " AND tid = '$topic' ";
} elseif (!$newstories) {
    $sql .= " AND frontpage = 1 ";
}

$sql .= COM_getPermSQL ('AND');

if (!empty($U['aids'])) {
    $sql .= ' ';
    $AIDS = explode(' ',$U['aids']);
    for ($z = 0; $z < sizeof($AIDS); $z++) {
        $sql .= "AND uid != '$AIDS[$z]' ";
    }
}

if (!empty($U['tids'])) {
    $sql .= ' ';
    $TIDS = explode(' ',$U['tids']);
    for ($z = 0; $z < sizeof($TIDS); $z++) {
        $sql .= "AND tid != '$TIDS[$z]' ";
    }
}

$tresult = DB_query ("SELECT tid FROM {$_TABLES['topics']}" . COM_getPermSQL());
$trows = DB_numRows ($tresult);
if ($trows > 0) {
    $tids = array ();
    for ($i = 0; $i < $trows; $i++) {
        $T = DB_fetchArray ($tresult);
        $tids[] = $T['tid'];
    }
    if (sizeof ($tids) > 0) {
        $sql .= "AND (tid IN ('" . implode ("','", $tids) . "')) ";
    }
}

if ($newstories) {
    $sql .= "AND (date >= (date_sub(NOW(), INTERVAL {$_CONF['newstoriesinterval']} SECOND))) ";
}

$offset = ($page - 1) * $limit;
$sql .= "ORDER BY featured DESC, date DESC";

$result = DB_query ("SELECT *,unix_timestamp(date) AS day " . $sql
        . " LIMIT $offset, $limit");
$nrows = DB_numRows ($result);

$data = DB_query ("SELECT count(*) AS count " . $sql);
$D = DB_fetchArray ($data);
$num_pages = ceil ($D['count'] / $limit);

if ($nrows > 0) {
    for ($x = 1; $x <= $nrows; $x++) {
        $A = DB_fetchArray($result);
        if ($A['featured'] == 1) {
            $feature = 'true';
        } elseif (($x == 1) && ($_CONF['showfirstasfeatured'] == 1)) {
            $feature = 'true';
            $A['featured'] = 1;
        }
        $display .= COM_article($A,'y');
        if ($A['featured'] == 1) {
            $display .= PLG_showCenterblock (2, $page, $topic);
        }
    }

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
