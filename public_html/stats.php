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
// $Id: stats.php,v 1.10 2001/12/19 17:50:01 tony_bibbs Exp $

include_once('lib-common.php');

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
	
$total_stories = DB_count($_TABLES['stories'],'draft_flag','0');
$comments = DB_count($_TABLES['comments']);
$stat_templates->set_var('lang_stories_comments',$LANG10[3]);
$stat_templates->set_var('total_stories',$total_stories);
$stat_templates->set_var('total_comments',$comments);

$total_polls = DB_count($_TABLES['pollquestions']);
$total_answers = DB_getItem($_TABLES['pollanswers'],'SUM(votes)');
$stat_templates->set_var('lang_polls_answers',$LANG10[4]);
$stat_templates->set_var('total_polls',$total_polls);
$stat_templates->set_var('total_answers', $total_answers);

$total_links = DB_count($_TABLES['links']);
$total_clicks = DB_getItem($_TABLES['links'],'SUM(hits)');
$stat_templates->set_var('lang_links_clicks',$LANG10[5]);
$stat_templates->set_var('total_links',$total_links);
$stat_templates->set_var('total_clicks',$total_clicks);

$total_events = DB_count($_TABLES['events']);
$stat_templates->set_var('lang_events',$LANG10[6]);
$stat_templates->set_var('total_events',$total_events);

$stat_templates->parse('site_statistics','sitestats',true);
$stat_templates->parse('output','stats');
$display .= $stat_templates->finish($stat_templates->get_var('output'));

// Get overall plugin statistics for inclusion
$display .= PLG_getPluginStats(1);

$display .= COM_endBlock();

// Detailed story statistics
		
$result = DB_query("SELECT sid,title,hits FROM {$_TABLES["stories"]} WHERE draft_flag = 0 AND Hits > 0 ORDER BY Hits desc LIMIT 10");
$nrows  = DB_numRows($result);

$display .= COM_startBlock($LANG10[7]);
if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[8]);
    $stat_templates->set_var('stat_name',$LANG10[9]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $stat_templates->set_var('item_url', 'article.php?story=' . $A['sid']);
        $stat_templates->set_var('item_text', $A['title']);
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
	
$result = DB_query("SELECT sid,title,comments from {$_TABLES['stories']} WHERE draft_flag = 0 AND uid > 1 and comments > 0 ORDER BY comments desc LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[11]);
if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[8]);
    $stat_templates->set_var('stat_name',$LANG10[12]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);	
        $stat_templates->set_var('item_url', 'article.php?story=' . $A['sid']);
        $stat_templates->set_var('item_text', $A['title']);
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
	
$result = DB_query("SELECT sid,title,numemails FROM {$_TABLES["stories"]} WHERE numemails > 0 ORDER BY numemails desc LIMIT 10");
$nrows = DB_numRows($result);
$display .= COM_startBlock($LANG10[22]);
	
if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[8]);
    $stat_templates->set_var('stat_name',$LANG10[23]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $stat_templates->set_var('item_url', 'article.php?story=' . $A['sid']);
        $stat_templates->set_var('item_text', $A['title']);
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
	
$result = DB_query("SELECT qid,question,voters from {$_TABLES['pollquestions']} WHERE voters > 0 ORDER BY voters desc LIMIT 10");
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
$result = DB_query("SELECT lid,url,title,hits from {$_TABLES['links']} WHERE hits > 0 ORDER BY hits desc LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[18]);
if ($nrows > 0) {
    $stat_templates->set_var('item_label',$LANG10[19]);
    $stat_templates->set_var('stat_name',$LANG10[20]);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $stat_templates->set_var('item_url', '/portal.php?url=' . $A['url'] . '&what=link&item=' . $A['lid']);
        $stat_templates->set_var('item_text', $A['title']);
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
