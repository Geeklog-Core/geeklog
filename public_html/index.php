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
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
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
// $Id: index.php,v 1.18 2002/04/10 20:33:27 tony_bibbs Exp $

include_once('lib-common.php');

$display = '';
$display .= COM_siteHeader();

$maxstories = 0;
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

// Show any messages that may need to be displayed
$display .= COM_showMessage($msg);

// Geeklog now allows for articles to be published in the future.  Because of this, we need to check
// to see if we need to rebuild the RDF file in the case that any such articles have now been published
COM_rdfUpToDateCheck();


$sql = "SELECT *,unix_timestamp(date) AS day FROM {$_TABLES['stories']} WHERE date <= NOW() AND draft_flag = 0";

// if a topic was provided only select those stories.
if (!empty($topic)) {
    $sql .= " AND tid = '$topic' ";
} else {
    $sql .= " AND frontpage = 1 ";
}

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

$offset = ($page - 1) * $limit;
$sql .= "ORDER BY featured DESC, date DESC LIMIT $offset, $limit";

$result = DB_query($sql);
$nrows = DB_numRows($result);

$countsql = "SELECT count(*) count FROM {$_TABLES['stories']} WHERE draft_flag = 0";
if (!empty($topic)) {
    $countsql = $countsql . " AND tid='$topic'";
} else {
    $countsql = $countsql . ' AND frontpage = 1';
}
$data = DB_query($countsql);
$D = DB_fetchArray($data);
$num_pages = ceil($D['count'] / $limit);

if ($nrows > 0) {
    for ($x = 1; $x <= $nrows; $x++) {
        $A	= DB_fetchArray($result);
        if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
            if ($A['featured'] == 1) {
                $display .= '<b>'.$LANG05[4].':</b>';
                $A['title'] = '<big>'.$A['title'].'</big>';
                $feature = 'true';
            }
            $display .= COM_article($A,'y');
        }
    }
    
    // Print Google-like paging navigation
    if (empty($topic)) {
        $base_url = $_CONF['site_url'] . '/index.php';
    } else {
        $base_url = $_CONf['site_url'] . '/index.php?topic=' . $topic;
    }
    $display .= COM_printPageNavigation($base_url,$page, $num_pages);
} else {
    if ($A['featured'] == 1) {
        $display .= COM_startBlock($LANG05[1]) . $LANG05[2];
        if (!empty($topic)) {
            $display .= $LANG05[3]; 
        }
        $display .= COM_endBlock();
    }
}

// Display any blocks, polls, olderstuff configured for this page
// </td> removed from lines 136 and 138, since closing </td> already exists in footer.php
if ($U['noboxes'] != 1) {
    $display .= '</td><td><img src="' . $_CONF['site_url'] . '/images/speck.gif" height="1" width="10" alt=""></td>' . LB
        . '<td valign="top" width="180">' . LB . COM_showBlocks('right',$topic)
        . '<br><img src="' . $_CONF['site_url'] . '/images/speck.gif" width="180" height="1" alt="">' . LB;
}

// Get footer
$display .= COM_siteFooter();

// Output page 
echo $display;

?>