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
// $Id: index.php,v 1.38 2002/12/01 10:12:18 dhaun Exp $

if (isset ($HTTP_GET_VARS['topic'])) {
    $topic = strip_tags ($HTTP_GET_VARS['topic']);
}
else {
    $topic = '';
}
if (isset ($HTTP_GET_VARS['display']) && ($HTTP_GET_VARS['display'] == 'new') && empty ($topic)) {
    $newstories = true;
} else {
    $newstories = false;
}
require_once('lib-common.php');

preg_match ("/\/\/([^\/]*)/", $_CONF['site_url'], $server);
if ($HTTP_SERVER_VARS['HTTP_HOST'] != $server[1]) {
    // this may be a case of a www. vs. non-www. URL ...
    if (!empty ($QUERY_STRING)) {
        $query = '?' . $QUERY_STRING;
    } else {
        $query = '';
    }
    echo COM_refresh ($_CONF['site_url'] . '/index.php' . $query);
    exit;
}

$display = '';

/*
 *  Staticpage on Frontpage Addon (Hacked together by MLimburg)
 *
 *  If a staticpage with the title 'frontpage' exists, then it is shown before
 *  the news messages.  If this staticpage has the label 'nonews', then it is
 *  shown INSTEAD of news messages.
 *  This will only occur on the basic index.php page, and not on the $topic
 *  pages.
 */

$shownews = true;

if (empty ($topic)) {

    // check if static pages plugin is installed and enabled
    if (DB_getItem ($_TABLES['plugins'], 'pi_enabled', "pi_name = 'staticpages'") == 1) {

        $spsql = "SELECT sp_content,sp_label,sp_format FROM {$_TABLES['staticpage']} WHERE sp_title = 'frontpage'";
        $spresult = DB_fetchArray (DB_query ($spsql));

        if ($spresult['sp_label'] == 'nonews') { // replace news entirely
            $shownews = false;
            switch ($spresult['sp_format']) {
                case 'noblocks':
                    $display .= COM_siteHeader ('none');
                    break;
                case 'allblocks':
                case 'leftblocks':
                    $display .= COM_siteHeader ('menu');
                    break;
            }

            $display .= stripslashes ($spresult['sp_content']);

            if ($spresult['sp_format'] == 'allblocks') {
                $display .= COM_siteFooter (true);
            } else if ($spresult['sp_format'] != 'blankpage') {
                $display .= COM_siteFooter ();
            }
        } else { // display static page content before the news
            $display .= COM_siteHeader();
            if (($_SP_CONF['in_block'] == 1) && !empty ($spresult['sp_label'])) {
                $display .= COM_startBlock ($spresult['sp_label']);
            }
            $display .= stripslashes ($spresult['sp_content']);
            if (($_SP_CONF['in_block'] == 1) && !empty ($spresult['sp_label'])) {
                $display .= COM_endBlock ();
            }
        }
    } else {
        $display .= COM_siteHeader();
    }
} else {
    $display .= COM_siteHeader();
}

if ($shownews) {

$maxstories = 0;

if (isset ($HTTP_GET_VARS['page'])) {
    $page = $HTTP_GET_VARS['page'];
}

if (empty($page)) {
    // If no page sent then assume the first.
    $page = 1;
}

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

$display .= COM_showMessage($HTTP_GET_VARS['msg']);

// Geeklog now allows for articles to be published in the future.  Because of
// this, we need to check to see if we need to rebuild the RDF file in the case
// that any such articles have now been published
COM_rdfUpToDateCheck();

// For similar reasons, we need to see if there are currently two featured
// articles.  Can only have one but you can have one current featured article
// and one for the future...this check will set the latest one as featured
// solely
COM_featuredCheck();

$sql = "SELECT *,unix_timestamp(date) AS day FROM {$_TABLES['stories']} WHERE (date <= NOW()) AND (draft_flag = 0)";

// if a topic was provided only select those stories.
if (!empty($topic)) {
    $sql .= " AND tid = '$topic' ";
} elseif (!$newstories) {
    $sql .= " AND frontpage = 1 ";
}

$sql .= " AND (";
if (!empty ($_USER['uid'])) {
    $groupList = '';
    foreach ($_GROUPS as $grp) {
        $groupList .= $grp . ',';
    }
    $groupList = substr ($groupList, 0, -1);
    $sql .= "(owner_id = {$_USER['uid']} AND perm_owner >= 2) OR ";
    $sql .= "(group_id IN ($groupList) AND perm_group >= 2) OR ";
    $sql .= "(perm_members >= 2) OR ";
}
$sql .= "(perm_anon >= 2))";

if (!empty($U['aids'])) {
    $AIDS = explode(' ',$U['aids']);
    for ($z = 0; $z < sizeof($AIDS); $z++) {
        $sql .= "AND uid != '$AIDS[$z]' ";
    }
}

if (!empty($U['tids'])) {
    $TIDS = explode(' ',$U['tids']);
    for ($z = 0; $z < sizeof($TIDS); $z++) {
        $sql .= "AND tid != '$TIDS[$z]' ";
    }
}

if ($newstories) {
    $sql .= "AND (date >= (NOW() - INTERVAL {$_CONF['newstoriesinterval']} SECOND))";
}

$offset = ($page - 1) * $limit;
$sql .= "ORDER BY featured DESC, date DESC LIMIT $offset, $limit";

$result = DB_query($sql);
$nrows = DB_numRows($result);

$countsql = "SELECT count(*) AS count FROM {$_TABLES['stories']} WHERE (date <= NOW()) AND (draft_flag = 0)";
if (!empty($topic)) {
    $countsql = $countsql . " AND tid='$topic'";
} elseif (!$newstories) {
    $countsql = $countsql . ' AND frontpage = 1';
}

$countsql .= " AND (";
if (!empty ($_USER['uid'])) {
    // Note: $groupList re-used from above
    $countsql .= "(owner_id = {$_USER['uid']} AND perm_owner >= 2) OR ";
    $countsql .= "(group_id IN ($groupList) AND perm_group >= 2) OR ";
    $countsql .= "(perm_members >= 2) OR ";
}
$countsql .= "(perm_anon >= 2))";

if ($newstories) {
    $countsql .= " AND (date >= (NOW() - INTERVAL {$_CONF['newstoriesinterval']} SECOND))";
}

$data = DB_query($countsql);
$D = DB_fetchArray($data);
$num_pages = ceil($D['count'] / $limit);

if ($nrows > 0) {
    for ($x = 1; $x <= $nrows; $x++) {
        $A = DB_fetchArray($result);
        if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
            if ($A['featured'] == 1) {
                $feature = 'true';
            } elseif (($x == 1) && ($_CONF['showfirstasfeatured'] == 1)) {
                $feature = 'true';
                $A['featured'] = 1;
            }
            $display .= COM_article($A,'y');
        }
    }
    
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
} else {
    $display .= COM_startBlock($LANG05[1]) . $LANG05[2];
    if (!empty($topic)) {
        $result = DB_query ("SELECT topic FROM {$_TABLES['topics']} WHERE tid='$topic'");
        $A = DB_fetchArray ($result);
        if (!empty ($A['topic'])) {
            $topic = $A['topic'];
        }
        $display .= $LANG05[3];
    }
    $display .= COM_endBlock();
}

$display .= COM_siteFooter(true); // The true value enables right hand blocks.

}

// Output page 
echo $display;

?>
