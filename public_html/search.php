<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | search.php                                                                |
// | Geeklog search tool.                                                      |
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
// $Id: search.php,v 1.9 2001/11/16 18:39:11 tony_bibbs Exp $

include_once('lib-common.php');

#debug($HTTP_POST_VARS);

/**
* Shows search form
*
*/
function searchform() 
{
    global $_TABLES, $LANG09, $_CONF;
	
    $retval .= COM_startBlock($LANG09[1],'advancedsearch.html');
    $searchform = new Template($_CONF['path_layout'].'search');
    $searchform->set_file(array('searchform'=>'searchform.thtml', 'authors'=>'searchauthors.thtml'));
    $searchform->set_var('search_intro', $LANG09[19]);
    $searchform->set_var('site_url', $_CONF['site_url']);
    $searchform->set_var('lang_keywords', $LANG09[2]);
    $searchform->set_var('lang_date', $LANG09[20]);
    $searchform->set_var('lang_to', $LANG09[21]);
    $searchform->set_var('date_format', $LANG09[22]);	
    $searchform->set_var('lang_topic', $LANG09[3]);
    $searchform->set_var('lang_all', $LANG09[4]);
    $searchform->set_var('topic_option_list', COM_optionList($_TABLES['topics'],'tid,topic'));
    $searchform->set_var('lang_type', $LANG09[5]);
    $searchform->set_var('lang_stories', $LANG09[6]);
    $searchform->set_var('lang_comments', $LANG09[7]);
    $plugintypes = PLG_getSearchTypes();
    $pluginoptions = '';
    // Generally I don't like to hardcode HTML but this seems easiest
    for ($i = 1; $i <= count($plugintypes); $i++) {
        $pluginoptions .= '<option value="' . key($plugintypes) . '">' . current($plugintypes) . '</option>' . LB; 
    }
    $searchform->set_var('plugin_types', $pluginoptions);

	if ($_CONF['contributedbyline'] == 1) {
        $searchform->set_var('lang_authors', $LANG09[8]);
        $searchform->set_var('author_option_list', COM_optionList($_TABLES['users'],'uid,username'));
        $searchform->parse('author_form_element', 'authors', true);
	} else {
		$searchform->set_var('author_form_element', '<input type="hidden" name="author" value="0">');
	}
    $searchform->set_var('lang_search', $LANG09[10]);	
    $searchform->parse('output', 'searchform');

    $retval .= $searchform->finish($searchform->get_var('output'));
    $retval .= COM_endBlock();
	
	return $retval;
}

###############################################################################
# The Search!
function searchstories($query,$topic,$datestart,$dateend, $author,$type) {
	
    global $LANG09, $_CONF, $_TABLES;

    include_once($_CONF['path_system'] . 'classes/plugin.class.php');
	
    $searchtimer = new timerobject();
    $searchtimer->setPercision(4);
    $searchtimer->startTimer();
	if ($type == 'all' OR $type == 'stories') {
		$sql = "SELECT sid,title,hits,uid,UNIX_TIMESTAMP(date) as day,'story' as type FROM {$_CONF['db_prefix']}stories WHERE (draft_flag = 0) AND ";
		$sql .= "((introtext like '%$query%' OR introtext like '$query%' OR introtext like '%$query') ";
		$sql .= "OR (bodytext like '%$query%' OR bodytext like '$query%' OR bodytext like '%$query') ";
		$sql .= "OR (title like '%$query%' OR title like '$query%' OR title like '%$query')) ";
		if (!empty($datestart) && !empty($dateend)) {
			$delim = substr($datestart, 4, 1);
			$DS = explode($delim,$datestart);
			$DE = explode($delim,$dateend);
			$startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
			$enddate = mktime(0,0,0,$DE[1],$DE[2],$DE[0]) + 3600;
			$sql .= "AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate') ";
		}
		if (!empty($topic)) {
			$sql .= "AND (tid = '$topic') ";
		}
		if (!empty($author)) {
			$sql .= "AND (uid = '$author') ";
		}
		$sql .= "ORDER BY date desc";
		$result_stories = DB_query($sql);
		$nrows_stories = DB_numRows($result_stories);
		$result_count = DB_query("select count(*) from stories where draft_flag = 0");
		$B = DB_fetchArray($result_count);
		$total_stories = $B[0];
		$A = DB_fetchArray($result_stories);
	}
	
	if ($type == 'all' OR $type == 'comments') {
		$sql = "SELECT sid,title,comment,pid,uid,UNIX_TIMESTAMP(date) as day,'comment' as type FROM {$_CONF['db_prefix']}comments WHERE ";
		$sql .= "((comment like '%$query%' OR comment like '$query%' OR comment like '%$query') ";
		$sql .= "OR (title like '%$query%' OR title like '$query%' OR title like '%$query')) ";
		if (!empty($datestart) && !empty($dateend)) {
			$delim = substr($datestart, 4, 1);
			$DS = explode($delim,$datestart);
			$DE = explode($delim,$dateend);
			$startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
			$enddate = mktime(0,0,0,$DE[1],$DE[2],$DE[0]) + 3600;
			$sql .= "AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate') ";
		}
		
		if (!empty($author)) {
			$sql .= "AND (sp_uid = '$author}') ";
		}
		$sql .= "ORDER BY date desc";
		$result_comments = DB_query($sql);
		$nrows_comments  = DB_numRows($result_comments);
		$total_comments = DB_count("comments");
		$C = DB_fetchArray($result_comments);
	}

    // Have plugins do their searches
    list($nrows_plugins, $total_plugins, $result_plugins) = PLG_doSearch($query, $datestart, $dateend, $topic, $type, $author);

    // OK, we now have the header items and results needed to 
    $total = $total_stories + $total_comments + $total_plugins;
    $nrows = $nrows_stories + $nrows_comments + $nrows_plugins;

    $searchtime = $searchtimer->stopTimer();
    $searchtimer->setPercision(4);

	$cur_plugin_recordset = 1;
	$cur_plugin_index = 1;
	if ($nrows > 0) {
        $searchresults = new Template($_CONF['path_layout'] . 'search');
        $searchresults->set_file(array('searchresults'=>'searchresults.thtml',
                                        'searchheading'=>'searchresults_heading.thtml',
                                        'searchrows'=>'searchresults_rows.thtml',
                                        'searchblock' => 'searchblock.thtml',
                                        'headingcolumn'=>'headingcolumn.thtml',
                                        'resultrow'=>'resultrow.thtml',
                                        'resultcolumn'=>'resultcolumn.thtml'));
        $searchresults->set_var('lang_found', $LANG09[24]);
        $searchresults->set_var('num_matches', $nrows);
        $searchresults->set_var('lang_matchesfor', $LANG09[25]);
        $searchresults->set_var('num_items_searched', $total);
        $searchresults->set_var('lang_itemsin', $LANG09[26]);
        $searchresults->set_var('search_time', $searchtime);
        $searchresults->set_var('lang_seconds', $LANG09[27]);

        // Print heading for story/comment results
        $searchresults->set_var('label', $LANG09[16]);
        $searchresults->parse('headings','headingcolumn',true);
        $searchresults->set_var('label', $LANG09[17]);
        $searchresults->parse('headings','headingcolumn',true);
        $searchresults->set_var('label', $LANG09[18]);
        $searchresults->parse('headings','headingcolumn',true);
        $searchresults->set_var('label', $LANG09[23]);
        $searchresults->parse('headings','headingcolumn',true);

        $searchresults->set_var('start_block_results', COM_startBlock($LANG09[29]));
        if ($nrows_stories + $nrows_comments > 0) {
		    for ($i=1; $i <= $nrows; $i++) {
			    if ($A['day'] > $C['day']) {
                    // print row
                    $searchresults->set_var('data', '<a href="article.php?story=' . $A['sid'] . '">' . stripslashes($A['title']) . '</a>');
                    $searchresults->parse('data_cols','resultcolumn',true);

                    $thetime = COM_getUserDateTimeFormat($A['day']);
                    $searchresults->set_var('data', $thetime[0]);
                    $searchresults->parse('data_cols','resultcolumn',true);

                    $searchresults->set_var('data', DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'"));
                    $searchresults->parse('data_cols','resultcolumn',true);

                    $searchresults->set_var('data', $A['hits']);
                    $searchresults->parse('data_cols','resultcolumn',true);

                    $searchresults->parse('results','resultrow',true);
	
				    $A = DB_fetchArray($result_stories);
			    } else if (strlen($C['day']) > 0) {
                    // print row
                    $searchresults->set_var('data', '<a href="article.php?story=' . $C['sid'] . '">' . stripslashes($C['title']) . '</a>');
                    $searchresults->parse('data_cols','resultcolumn',true);

                    $thetime = COM_getUserDateTimeFormat($C['day']);
                    $searchresults->set_var('data', $thetime[0]);
                    $searchresults->parse('data_cols','resultcolumn',true);

                    $searchresults->set_var('data', DB_getItem($_TABLES['users'],'username',"uid = '{$C['uid']}'"));
                    $searchresults->parse('data_cols','resultcolumn',true);

                    $searchresults->set_var('data', $C['hits']);
                    $searchresults->parse('data_cols','resultcolumn',true);

                    $searchresults->parse('results','resultrow',true);

				    $C = DB_fetchArray($result_comments);
			    } 
		    }
        } else {
            $searchresults->set_var('results','<tr><td colspan="4" align="center"><br>' . $LANG09[28] . '</td></tr>');
        }

        $searchresults->set_var('end_block', COM_endBlock());
        $searchresults->parse('search_blocks','searchblock',true);

        reset($result_plugins);
        $cur_plugin = new Plugin();
        for ($i = 1; $i <= count($result_plugins); $i++) {
            // Clear out data columns from previous result block
            $searchresults->set_var('data_cols','');
            $cur_plugin = current($result_plugins);
            $searchresults->set_var('start_block_results', COM_startBlock($cur_plugin->searchlabel));
            $searchresults->set_var('headings','');
            for ($j = 1; $j <= $cur_plugin->num_searchheadings; $j++) {
                $searchresults->set_var('label', $cur_plugin->searchheading[$j]);
                $searchresults->parse('headings','headingcolumn',true);
            }
            $searchresults->set_var('results','');
            for ($j = 1; $j <= $cur_plugin->num_searchresults; $j++) {
                $columns = $cur_plugin->searchresults[$j];
                for ($x = 1; $x <= count($columns); $x++) {
                    COM_errorLog('column val = ' . current($columns),1);
                    $searchresults->set_var('data', current($columns));
                    $searchresults->parse('data_cols','resultcolumn',true);
                    next($columns);
                }
                $searchresults->parse('results','resultrow',true);
            }
            $searchresults->set_var('end_block', COM_endBlock());
            $searchresults->parse('search_blocks','searchblock',true);
            next($result_plugins);
        }

        $retval .= $searchresults->parse('output','searchresults');
	} else {
		$retval .= COM_startBlock($LANG09[13])
                    . $LANG09[14].' <b>'.$query.'</b> '.$LANG09[15]
			        . COM_endBlock();
	}
			
	return $retval;
}

/**
* Show search results
*
* Shows results for one row
*
* @A        array      data to show 
*
*/
function searchresults($A) 
{
	global $_CONF, $_TABLES;
	
	$retval .= '<tr align="center">'.LB
		.'<td align="left"><a href="article.php?story='.$A['sid'].'">'.stripslashes($A['title']).'</a></td>'.LB
		.'<td>'.strftime($_CONF['shortdate'],$A['day']).'</td>'.LB
		.'<td>'.DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'").'</td>'.LB
		.'<td>'.$A['hits'].'</td>'.LB
		.'</tr>'.LB;
	
	return $retval;
}

###############################################################################
# MAIN
$display .= COM_siteHeader();
if ($mode == 'search') {
	$display .= searchstories($query,$topic,$datestart,$dateend,$author,$type);
} else {
	$display .= searchform();
}
$display .= COM_siteFooter();
echo $display;
?>
