<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | stats.php                                                                 |
// | Geeklog system statistics page.                                           |
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
// $Id: stats.php,v 1.24 2003/06/25 08:39:02 dhaun Exp $

require_once('lib-common.php');

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

$display .= COM_siteHeader() . COM_startBlock($LANG10[1]);


$stat_templates = new Template($_CONF['path_layout'] . 'stats');
$stat_templates->set_file(array('stats'=>'stats.thtml',
                            'sitestats'=>'sitestatistics.thtml',
                            'itemstats'=>'itemstatistics.thtml',
                            'statrow'=>'singlestat.thtml'));

// Overall Site Statistics

$totalhits = DB_getItem($_TABLES['vars'],'value',"name = 'totalhits'");
$stat_templates->set_var('lang_totalhitstosystem',$LANG10[2]);
$stat_templates->set_var('total_hits', $totalhits);

$id = array('draft_flag','date');
$values = array('0','NOW()');	
$result = DB_query("SELECT count(*) AS count,SUM(comments) as ccount FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND'));
$A = DB_fetchArray($result);
$total_stories = $A['count'];
$comments = $A['ccount'];
if (empty ($comments)) {
    $comments = 0;
}
$stat_templates->set_var('lang_stories_comments',$LANG10[3]);
$stat_templates->set_var('total_stories',$total_stories);
$stat_templates->set_var('total_comments',$comments);

$result = DB_query ("SELECT count(*) AS count FROM {$_TABLES['pollquestions']}" . COM_getPermSQL ());
$A = DB_fetchArray($result);
$total_polls = $A['count'];
$result = DB_query ("SELECT qid FROM {$_TABLES['pollquestions']}" . COM_getPermSQL ());
$nrows = DB_numRows ($result);
if ($nrows > 0) {
    $questions = '';
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        if ($i > 1) {
            $questions .= ',';
        }
        $questions .= "'" . $A['qid'] . "'";
    }
    $result = DB_query ("SELECT SUM(votes) FROM {$_TABLES['pollanswers']} WHERE qid IN ({$questions})");
    $A = DB_fetchArray($result);
    $total_answers = $A[0];
} else {
    $total_answers = 0;
}
$stat_templates->set_var('lang_polls_answers',$LANG10[4]);
$stat_templates->set_var('total_polls',$total_polls);
$stat_templates->set_var('total_answers', $total_answers);

$result = DB_query ("SELECT count(*) AS count,SUM(hits) AS clicks FROM {$_TABLES['links']}" . COM_getPermSQL ());
$A = DB_fetchArray($result);
$total_links = $A['count'];
$total_clicks = $A['clicks'];
if (empty ($total_clicks)) {
    $total_clicks = 0;
}
$stat_templates->set_var('lang_links_clicks',$LANG10[5]);
$stat_templates->set_var('total_links',$total_links);
$stat_templates->set_var('total_clicks',$total_clicks);

$result = DB_query ("SELECT count(*) AS count FROM {$_TABLES['events']}" . COM_getPermSQL ());
$A = DB_fetchArray($result);
$total_events = $A['count'];
$stat_templates->set_var('lang_events',$LANG10[6]);
$stat_templates->set_var('total_events',$total_events);

$stat_templates->parse('site_statistics','sitestats',true);
$stat_templates->parse('output','stats');
$display .= $stat_templates->finish($stat_templates->get_var('output'));

// Get overall plugin statistics for inclusion
$display .= PLG_getPluginStats(1);

$display .= COM_endBlock();

// Detailed story statistics

$result = DB_query("SELECT sid,title,hits FROM {$_TABLES["stories"]} WHERE (draft_flag = 0) AND (date <= NOW()) AND (Hits > 0)" . COM_getPermSQL ('AND') . " ORDER BY Hits desc LIMIT 10");
$nrows  = DB_numRows($result);

$display .= COM_startBlock($LANG10[7]);
if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[8]);
    $stat_templates->set_var('stat_name',$LANG10[9]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $stat_templates->set_var('item_url', 'article.php?story=' . $A['sid']);
        $stat_templates->set_var('item_text', stripslashes(str_replace('$','&#36;',$A['title'])));
        $stat_templates->set_var('item_stat', $A['hits']);
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

$result = DB_query("SELECT sid,title,comments from {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) AND (comments > 0)" . COM_getPermSQL ('AND') . " ORDER BY comments desc LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[11]);
if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[8]);
    $stat_templates->set_var('stat_name',$LANG10[12]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);	
        $stat_templates->set_var('item_url', 'article.php?story=' . $A['sid']);
        $stat_templates->set_var('item_text', stripslashes(str_replace('$','&#36;',$A['title'])));
        $stat_templates->set_var('item_stat', $A['comments']);
        $stat_templates->parse('stat_row','statrow',true); 
    }
    $stat_templates->parse('output','itemstats');
    $display .= $stat_templates->finish($stat_templates->get_var('output'));
} else {
    $display .= $LANG10[13];
}
$display .= COM_endBlock();
$stat_templates->set_var('stat_row','');

// Top Ten Emailed Stories

$result = DB_query("SELECT sid,title,numemails FROM {$_TABLES["stories"]} WHERE (numemails > 0) AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND') . " ORDER BY numemails desc LIMIT 10");
$nrows = DB_numRows($result);
$display .= COM_startBlock($LANG10[22]);

if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[8]);
    $stat_templates->set_var('stat_name',$LANG10[23]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $stat_templates->set_var('item_url', 'article.php?story=' . $A['sid']);
        $stat_templates->set_var('item_text', stripslashes(str_replace('$','&#36;',$A['title'])));
        $stat_templates->set_var('item_stat', $A['numemails']);
        $stat_templates->parse('stat_row','statrow',true); 
    }
    $stat_templates->parse('output','itemstats');
    $display .= $stat_templates->finish($stat_templates->get_var('output'));
} else {
    $display .= $LANG10[24];
}
$display .= COM_endBlock();
$stat_templates->set_var('stat_row','');

// Top Ten Polls

$result = DB_query("SELECT qid,question,voters from {$_TABLES['pollquestions']} WHERE (voters > 0)" . COM_getPermSQL ('AND') . " ORDER BY voters desc LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[14]);
if ($nrows>0) {
    $stat_templates->set_var('item_label',$LANG10[15]);
    $stat_templates->set_var('stat_name',$LANG10[16]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $stat_templates->set_var('item_url', 'pollbooth.php?qid=' . $A['qid']);
        $stat_templates->set_var('item_text', $A['question']);
        $stat_templates->set_var('item_stat', $A['voters']);
        $stat_templates->parse('stat_row','statrow',true); 
    }
    $stat_templates->parse('output','itemstats');
    $display .= $stat_templates->finish($stat_templates->get_var('output'));
} else {
    $display .= $LANG10[17];
}	

$display .= COM_endBlock();
$stat_templates->set_var('stat_row','');

// Top Ten Links

$result = DB_query("SELECT lid,url,title,hits from {$_TABLES['links']} WHERE (hits > 0)" . COM_getPermSQL ('AND') . " ORDER BY hits desc LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[18]);
if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[19]);
    $stat_templates->set_var('stat_name',$LANG10[20]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $stat_templates->set_var('item_url', $_CONF['site_url'] . '/portal.php?what=link&amp;item=' . $A['lid']);
        $stat_templates->set_var('item_text', stripslashes(str_replace('$','&#36;',$A['title'])));
        $stat_templates->set_var('item_stat', $A['hits']);
        $stat_templates->parse('stat_row','statrow',true); 
    }
    $stat_templates->parse('output','itemstats');
    $display .= $stat_templates->finish($stat_templates->get_var('output'));
} else {
    $display .= $LANG10[21];
}	
$display .= COM_endBlock();

// Now show stats for any plugins that want to be included
$display .= PLG_getPluginStats(2);
$display .= COM_siteFooter();
	
echo $display;

?>
