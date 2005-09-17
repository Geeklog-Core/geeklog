<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | stats.php                                                                 |
// |                                                                           |
// | Geeklog system statistics page.                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
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
//
// $Id: stats.php,v 1.39 2005/09/17 12:59:19 dhaun Exp $

require_once('lib-common.php');

$display = '';

if (empty ($_USER['username']) &&
    (($_CONF['loginrequired'] == 1) || ($_CONF['statsloginrequired'] == 1))) {
    $display = COM_siteHeader('');
    $display .= COM_startBlock ($LANG_LOGIN[1], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $login = new Template($_CONF['path_layout'] . 'submit');
    $login->set_file (array ('login'=>'submitloginrequired.thtml'));
    $login->set_var ('login_message', $LANG_LOGIN[2]);
    $login->set_var ('site_url', $_CONF['site_url']);
    $login->set_var ('lang_login', $LANG_LOGIN[3]);
    $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
    $login->parse ('output', 'login');
    $display .= $login->finish ($login->get_var('output'));
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter();
    echo $display; 
    exit;
}

// MAIN

$display .= COM_siteHeader ('menu', $LANG10[1]) . COM_startBlock ($LANG10[1]);

$stat_templates = new Template($_CONF['path_layout'] . 'stats');
$stat_templates->set_file (array ('sitestats' => 'sitestatistics.thtml',
                                  'itemstats' => 'itemstatistics.thtml',
                                  'statrow'   => 'singlestat.thtml',
                                  'summary'   => 'singlesummary.thtml'));

// Overall Site Statistics

$totalhits = DB_getItem ($_TABLES['vars'], 'value', "name = 'totalhits'");
$stat_templates->set_var ('lang_totalhitstosystem', $LANG10[2]);
$stat_templates->set_var ('total_hits', COM_NumberFormat ($totalhits));

if ($_CONF['lastlogin']) {
    // if we keep track of the last login date, count the number of users
    // that have logged in during the last 4 weeks
    $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['users']} AS u,{$_TABLES['userinfo']} AS i WHERE (u.uid > 1) AND (u.uid = i.uid) AND (lastlogin <> '') AND (lastlogin >= UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 28 DAY)))");
    list($active_users) = DB_fetchArray ($result);
} else {
    // otherwise, just count all users with status 'active'
    // (i.e. those that logged in at least once and have not been banned since)
    $active_users = DB_count ($_TABLES['users'], 'status', 3);
    $active_users--; // don't count the anonymous user account
}
$stat_templates->set_var ('lang_active_users', $LANG10[27]);
$stat_templates->set_var ('active_users', COM_NumberFormat ($active_users));

$topicsql = COM_getTopicSql ('AND');

$id = array ('draft_flag', 'date');
$values = array ('0', 'NOW()');	
$result = DB_query ("SELECT COUNT(*) AS count,SUM(comments) AS ccount FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND') . $topicsql);
$A = DB_fetchArray ($result);
$total_stories = $A['count'];
$comments = $A['ccount'];
if (empty ($comments)) {
    $comments = 0;
}
$stat_templates->set_var ('lang_stories_comments', $LANG10[3]);
$stat_templates->set_var ('total_stories', COM_NumberFormat ($total_stories));
$stat_templates->set_var ('total_comments', COM_NumberFormat ($comments));

$result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['events']}" . COM_getPermSQL ());
$A = DB_fetchArray ($result);
$total_events = $A['count'];
$stat_templates->set_var ('lang_events', $LANG10[6]);
$stat_templates->set_var ('total_events', COM_NumberFormat ($total_events));

// new stats plugin API call
$plg_stats = PLG_getPluginStats (3);
if (count ($plg_stats) > 0) {
    foreach ($plg_stats as $pstats) {
        if (is_array ($pstats[0])) {
            foreach ($pstats as $pmstats) {
                $stat_templates->set_var ('item_text', $pmstats[0]);
                $stat_templates->set_var ('item_stat', $pmstats[1]);
                $stat_templates->parse ('summary_row', 'summary', true);
            }
        } else {
            $stat_templates->set_var ('item_text', $pstats[0]);
            $stat_templates->set_var ('item_stat', $pstats[1]);
            $stat_templates->parse ('summary_row', 'summary', true);
        }
    }
}

$stat_templates->parse ('output', 'sitestats');
$display .= $stat_templates->finish ($stat_templates->get_var ('output'));

// old stats plugin API call, for backward compatibilty
$display .= PLG_getPluginStats (1);

$display .= COM_endBlock ();

// Detailed story statistics

$result = DB_query("SELECT sid,title,hits FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) AND (Hits > 0)" . COM_getPermSQL ('AND') . $topicsql . " ORDER BY hits DESC LIMIT 10");
$nrows  = DB_numRows($result);

$display .= COM_startBlock($LANG10[7]);
if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[8]);
    $stat_templates->set_var('stat_name',$LANG10[9]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $stat_templates->set_var ('item_url', COM_buildUrl ($_CONF['site_url']
                                    . '/article.php?story=' . $A['sid']));
        $stat_templates->set_var('item_text', stripslashes(str_replace('$','&#36;',$A['title'])));
        $stat_templates->set_var('item_stat', COM_NumberFormat ($A['hits']) );
        $stat_templates->parse('stat_row','statrow',true); 
    }
    $stat_templates->parse('output','itemstats');
    $display .= $stat_templates->finish($stat_templates->get_var('output'));
} else {
    $display .= $LANG10[10];
}

$display .= COM_endBlock();
$stat_templates->set_var('stat_row','');

// Top Ten Commented Stories

$result = DB_query("SELECT sid,title,comments FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) AND (comments > 0)" . COM_getPermSQL ('AND') . $topicsql . " ORDER BY comments DESC LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[11]);
if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[8]);
    $stat_templates->set_var('stat_name',$LANG10[12]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);	
        $stat_templates->set_var ('item_url', COM_buildUrl ($_CONF['site_url']
                                    . '/article.php?story=' . $A['sid']));
        $stat_templates->set_var('item_text', stripslashes(str_replace('$','&#36;',$A['title'])));
        $stat_templates->set_var('item_stat', COM_NumberFormat ($A['comments']) );
        $stat_templates->parse('stat_row','statrow',true); 
    }
    $stat_templates->parse('output','itemstats');
    $display .= $stat_templates->finish($stat_templates->get_var('output'));
} else {
    $display .= $LANG10[13];
}
$display .= COM_endBlock();
$stat_templates->set_var('stat_row','');

// Top Ten Trackback Comments

$result = DB_query ("SELECT {$_TABLES['stories']}.sid,{$_TABLES['stories']}.title,COUNT(*) AS count FROM {$_TABLES['stories']},{$_TABLES['trackback']} AS t WHERE (draft_flag = 0) AND ({$_TABLES['stories']}.date <= NOW()) AND ({$_TABLES['stories']}.sid = t.sid) AND (t.type = 'article')" . COM_getPermSql ('AND') . $topicsql . " GROUP BY t.sid ORDER BY count DESC LIMIT 10");
$nrows = DB_numRows ($result);
$display .= COM_startBlock ($LANG10[25]);
if ($nrows > 0) {
    $stat_templates->set_var ('item_label', $LANG10[8]);
    $stat_templates->set_var ('stat_name', $LANG10[12]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray ($result);
        $stat_templates->set_var ('item_url', COM_buildUrl ($_CONF['site_url']
                                        . '/article.php?story=' . $A['sid']));
        $stat_templates->set_var ('item_text',
                stripslashes (str_replace ('$', '&#36;', $A['title'])));
        $stat_templates->set_var ('item_stat', COM_NumberFormat ( $A['count']) );
        $stat_templates->parse ('stat_row', 'statrow', true);
    }
    $stat_templates->parse ('output', 'itemstats');
    $display .= $stat_templates->finish ($stat_templates->get_var ('output'));
} else {
    $display .= $LANG10[26];
}
$display .= COM_endBlock ();
$stat_templates->set_var ('stat_row', '');

// Top Ten Emailed Stories

$result = DB_query("SELECT sid,title,numemails FROM {$_TABLES['stories']} WHERE (numemails > 0) AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND') . $topicsql . " ORDER BY numemails DESC LIMIT 10");
$nrows = DB_numRows($result);
$display .= COM_startBlock($LANG10[22]);

if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[8]);
    $stat_templates->set_var('stat_name',$LANG10[23]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $stat_templates->set_var ('item_url', COM_buildUrl ($_CONF['site_url']
                                    . '/article.php?story=' . $A['sid']));
        $stat_templates->set_var('item_text', stripslashes(str_replace('$','&#36;',$A['title'])));
        $stat_templates->set_var('item_stat', COM_NumberFormat ( $A['numemails']) );
        $stat_templates->parse('stat_row','statrow',true); 
    }
    $stat_templates->parse('output','itemstats');
    $display .= $stat_templates->finish($stat_templates->get_var('output'));
} else {
    $display .= $LANG10[24];
}
$display .= COM_endBlock();
$stat_templates->set_var('stat_row','');


// Now show stats for any plugins that want to be included
$display .= PLG_getPluginStats(2);
$display .= COM_siteFooter();

echo $display;

?>
