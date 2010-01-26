<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | stats.php                                                                 |
// |                                                                           |
// | Geeklog system statistics page.                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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
require_once $_CONF['path_system'] . 'lib-admin.php';

$display = '';

if (COM_isAnonUser() &&
    (($_CONF['loginrequired'] == 1) || ($_CONF['statsloginrequired'] == 1))) {
    $display = COM_siteHeader('menu', $LANG10[1]);
    $display .= SEC_loginRequiredForm();
    $display .= COM_siteFooter();
    COM_output($display);
    exit;
}

// MAIN

$display .= COM_siteHeader('menu', $LANG10[1]);

// Overall Site Statistics

$header_arr = array(
    array('text' => $LANG10[1], 'field' => 'title', 'header_class' => 'stats-header-title'),
    array('text' => "", 'field' => 'stats', 'header_class' => 'stats-header-count', 'field_class' => 'stats-list-count'),
);
$data_arr = array();
$text_arr = array('has_menu'     =>  false,
                  'title'        => $LANG10[1],
);

$totalhits = DB_getItem ($_TABLES['vars'], 'value', "name = 'totalhits'");
$data_arr[] = array('title' => $LANG10[2], 'stats' => COM_NumberFormat ($totalhits));

if ($_CONF['lastlogin']) {
    // if we keep track of the last login date, count the number of users
    // that have logged in during the last 4 weeks 
    $sql = array();
    $sql['pgsql'] = "SELECT COUNT(*) AS count FROM {$_TABLES['users']} AS u,{$_TABLES['userinfo']} AS i WHERE (u.uid > 1) AND (u.uid = i.uid) AND (lastlogin <> '') AND (lastlogin::int4 >= date_part('epoch', INTERVAL '28 DAY'))";
    $sql['mysql'] = "SELECT COUNT(*) AS count FROM {$_TABLES['users']} AS u,{$_TABLES['userinfo']} AS i WHERE (u.uid > 1) AND (u.uid = i.uid) AND (lastlogin <> '') AND (lastlogin >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 28 DAY)))";
    $sql['mssql'] = "SELECT COUNT(*) AS count FROM {$_TABLES['users']} AS u,{$_TABLES['userinfo']} AS i WHERE (u.uid > 1) AND (u.uid = i.uid) AND (lastlogin <> '') AND (lastlogin >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 28 DAY)))";
    $result = DB_query ($sql);
    list($active_users) = DB_fetchArray ($result);
} else {
    // otherwise, just count all users with status 'active'
    // (i.e. those that logged in at least once and have not been banned since)
    $active_users = DB_count ($_TABLES['users'], 'status', 3);
    $active_users--; // don't count the anonymous user account
}
$data_arr[] = array('title' => $LANG10[27], 'stats' => COM_NumberFormat ($active_users));

$topicsql = COM_getTopicSql ('AND');

$id = array ('draft_flag', 'date');
$values = array ('0', 'NOW()');
$result = DB_query ("SELECT COUNT(*) AS count,SUM(comments) AS ccount FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND') . $topicsql);
$A = DB_fetchArray ($result);
if (empty ($A['ccount'])) {
    $A['ccount'] = 0;
}
$data_arr[] = array('title' => $LANG10[3],
                    'stats' => COM_NumberFormat ($A['count'])
                           . " (". COM_NumberFormat ($A['ccount']) . ")");

// new stats plugin API call
$plg_stats = PLG_getPluginStats (3);
if (count ($plg_stats) > 0) {
    foreach ($plg_stats as $pstats) {
        if (is_array ($pstats[0])) {
            foreach ($pstats as $pmstats) {
                $data_arr[] = array('title' => $pmstats[0], 'stats' => $pmstats[1]);
            }
        } else {
            $data_arr[] = array('title' => $pstats[0], 'stats' => $pstats[1]);
        }
    }
}

$display .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);

// old stats plugin API call, for backward compatibilty
$display .= PLG_getPluginStats (1);

// Detailed story statistics

$result = DB_query("SELECT sid,title,hits FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) AND (Hits > 0)" . COM_getPermSQL ('AND') . $topicsql . " ORDER BY hits DESC LIMIT 10");
$nrows  = DB_numRows($result);

if ($nrows > 0) {
    $header_arr = array(
        array('text' => $LANG10[8], 'field' => 'sid', 'header_class' => 'stats-header-title'),
        array('text' => $LANG10[9], 'field' => 'hits', 'header_class' => 'stats-header-count', 'field_class' => 'stats-list-count'),
    );
    $data_arr = array();
    $text_arr = array('has_menu'     =>  false,
                      'title'        => $LANG10[7],
    );

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $A['title'] = stripslashes(str_replace('$','&#36;',$A['title']));
        $A['sid'] = COM_createLink($A['title'],  COM_buildUrl ($_CONF['site_url']
                  . "/article.php?story={$A['sid']}"));
        $A['hits'] = COM_NumberFormat ($A['hits']);
        $data_arr[$i] = $A;

    }
    $display .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);
} else {
    $display .= COM_startBlock($LANG10[7]);
    $display .= $LANG10[10];
    $display .= COM_endBlock();
}

// Top Ten Commented Stories

$result = DB_query("SELECT sid,title,comments FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) AND (comments > 0)" . COM_getPermSQL ('AND') . $topicsql . " ORDER BY comments DESC LIMIT 10");
$nrows  = DB_numRows($result);
if ($nrows > 0) {
    $header_arr = array(
        array('text' => $LANG10[8], 'field' => 'sid', 'header_class' => 'stats-header-title'),
        array('text' => $LANG10[12], 'field' => 'comments', 'header_class' => 'stats-header-count', 'field_class' => 'stats-list-count'),
    );
    $data_arr = array();
    $text_arr = array('has_menu'     =>  false,
                      'title'        => $LANG10[11],
    );
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $A['title'] = stripslashes(str_replace('$','&#36;',$A['title']));
        $A['sid'] = COM_createLink($A['title'], COM_buildUrl ($_CONF['site_url']
                  . "/article.php?story={$A['sid']}"));
        $A['comments'] = COM_NumberFormat ($A['comments']);
        $data_arr[$i] = $A;
    }
    $display .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);

} else {
    $display .= COM_startBlock($LANG10[11]);
    $display .= $LANG10[13];
    $display .= COM_endBlock();
}

// Top Ten Trackback Comments

if ($_CONF['trackback_enabled'] || $_CONF['pingback_enabled']) {
    $result = DB_query ("SELECT {$_TABLES['stories']}.sid,{$_TABLES['stories']}.title,COUNT(*) AS count FROM {$_TABLES['stories']},{$_TABLES['trackback']} AS t WHERE (draft_flag = 0) AND ({$_TABLES['stories']}.date <= NOW()) AND ({$_TABLES['stories']}.sid = t.sid) AND (t.type = 'article')" . COM_getPermSql ('AND') . $topicsql . " GROUP BY t.sid,{$_TABLES['stories']}.sid,{$_TABLES['stories']}.title ORDER BY count DESC LIMIT 10");
    $nrows = DB_numRows ($result);
    if ($nrows > 0) {
        $header_arr = array(
            array('text' => $LANG10[8], 'field' => 'sid', 'header_class' => 'stats-header-title'),
            array('text' => $LANG10[12], 'field' => 'count', 'header_class' => 'stats-header-count', 'field_class' => 'stats-list-count'),
        );
        $data_arr = array();
        $text_arr = array('has_menu'     =>  false,
                          'title'        => $LANG10[25],
        );
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray ($result);
            $A['title'] = stripslashes(str_replace('$','&#36;',$A['title']));
            $A['sid'] = COM_createLink($A['title'], COM_buildUrl ($_CONF['site_url']
                      . "/article.php?story={$A['sid']}"));
            $A['count'] = COM_NumberFormat ($A['count']);
            $data_arr[$i] = $A;
        }
        $display .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);

    } else {
        $display .= COM_startBlock ($LANG10[25]);
        $display .= $LANG10[26];
        $display .= COM_endBlock ();
    }
}

// Top Ten Emailed Stories

$result = DB_query("SELECT sid,title,numemails FROM {$_TABLES['stories']} WHERE (numemails > 0) AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND') . $topicsql . " ORDER BY numemails DESC LIMIT 10");
$nrows = DB_numRows($result);

if ($nrows > 0) {
    $header_arr = array(
        array('text' => $LANG10[8], 'field' => 'sid', 'header_class' => 'stats-header-title'),
        array('text' => $LANG10[23], 'field' => 'numemails', 'header_class' => 'stats-header-count', 'field_class' => 'stats-list-count'),
    );
    $data_arr = array();
    $text_arr = array('has_menu'     =>  false,
                      'title'        => $LANG10[22],
    );
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $A['title'] = stripslashes(str_replace('$','&#36;',$A['title']));
        $A['sid'] = COM_createLink($A['title'], COM_buildUrl ($_CONF['site_url']
                  . "/article.php?story={$A['sid']}"));
        $A['numemails'] = COM_NumberFormat ($A['numemails']);
        $data_arr[$i] = $A;

    }
    $display .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);
} else {
    $display .= COM_startBlock($LANG10[22]);
    $display .= $LANG10[24];
    $display .= COM_endBlock();
}

// Now show stats for any plugins that want to be included
$display .= PLG_getPluginStats(2);
$display .= COM_siteFooter();

COM_output($display);

?>
