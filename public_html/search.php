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
// $Id: search.php,v 1.6 2001/10/17 23:35:47 tony_bibbs Exp $

include_once('lib-common.php');

#debug($HTTP_POST_VARS);

/**
* Shows search form
*
*/
function searchform() 
{
    global $_TABLES, $LANG09, $_CONF;
	
	$retval .= COM_startBlock($LANG09[1],'advancedsearch.html')
		.$LANG09[19]
		.'<form action="'.$_CONF['site_url'].'/search.php" method="get">'.LB
		.'<table border="0" cellspacing="0" cellpadding="3">'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG09[2].':</td>'.LB
		.'<td><input type="text" name="query" size="35" maxlength="35"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG09[20].':</td>'.LB
		.'<td><input type="text" name="datestart" size="10" maxlength="10"> '.$LANG09[21].' <input type="text" name="dateend" size="10" maxlength="10"> '.$LANG09[22].'</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG09[3].':</td>'.LB
		.'<td><select name="topic">'.LB
		.'<option selected="selected" value="0">'.$LANG09[4].'</option>'.LB
		.COM_optionList($_TABLES['topics'],'tid,topic')
		.'</select></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG09[5].':</td>'.LB
		.'<td><select name="type">'.LB
		.'<option selected="selected" value="all">'.$LANG09[9].'</option>'.LB
		.'<option value="stories">'.$LANG09[6].'</option>'.LB
		.GetPluginSearchTypes()
		.'<option value="comments">'.$LANG09[7].'</option>'.LB
		.'</select></td>'.LB
		.'</tr>'.LB;
		
	if ($_CONF['contributedbyline'] == 1) {
		$retval .= '<tr>'.LB
			.'<td align="right">'.$LANG09[8].':</td>'.LB
			.'<td><select name="author">'.LB
			.'<option selected="selected" value="0">'.$LANG09[9].'</option>'.LB
			.COM_optionList($_TABLES['users'],'uid,username')
			.'</select></td>'.LB
			.'</tr>'.LB;
	} else {
		$retval .= '<input type="hidden" name="author" value="0">'.LB;
	}
	
	$retval .= '<tr>'.LB
		.'<td colspan="2"><input type="submit" value="'.$LANG09[10].'">'
		.'<input type="hidden" name="mode" value="search"></td>'.LB
		.'</tr>'.LB
		.'</table>'.LB
		.'</form>'
		.COM_endBlock();
	
	return $retval;
}

###############################################################################
# The Search!
function searchstories($query,$topic,$datestart,$dateend,$author,$type) {
	global $LANG09;
	
	
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
		
		/*
		if (!empty($topic)) {
			$sql .= "AND (tid = '$topic') ";
		}
		*/
		
		if (!empty($author)) {
			$sql .= "AND (uid = '$author}') ";
		}
		$sql .= "ORDER BY date desc";
		$result_comments = DB_query($sql);
		$nrows_comments  = DB_numRows($result_comments);
		$total_comments = DB_count("comments");
		$C = DB_fetchArray($result_comments);
	}
	// Have plugins do their searches
	list($nrows_plugins, $total_plugins, $result_plugins) = DoPluginSearches($query, $datestart, $dateend, $topic, $author);
	$total = $total_stories + $total_comments + $total_plugins;
	$nrows = $nrows_stories + $nrows_comments + $nrows_plugins;
	$cur_plugin_recordset = 1;
	$cur_plugin_index = 1;
	if ($nrows > 0) {
		$retval .= COM_startBlock("$for " . $LANG09[11] . ": $nrows " . $LANG09[12])
			.'Found <b>'.$nrows.'</b> matches for <b>'.$total.'</b> items'
			.'<table cellpadding="0" cellspacing="1" border="0" width="99%">'.LB
			.'<tr>'.LB
			.'<td><b>'.$LANG09[16].'</b></td>'.LB
			.'<td align="center"><b>'.$LANG09[17].'</b></td>'.LB
			.'<td align="center"><b>'.$LANG09[18].'</b></td>'.LB
			.'<td align="center"><b>'.$LANG09[23].'</b></td>'.LB
			.'</tr>'.LB;
			
		for ($i=1; $i <= $nrows; $i++) {
			if ($A['day'] > $C['day']) {
				$retval .= searchresults($A);
				$A = DB_fetchArray($result_stories);
			} else if (strlen($C['day']) > 0) {
				$retval .= searchresults($C);
				$C = DB_fetchArray($result_comments);
			} else {
				if ($cur_plugin_index <= $nrows_plugins) {
					print $result_plugins[$cur_plugin_recordset][$cur_plugin_index];
					$cur_plugin_index++;
					if ($cur_plugin_index > count($result_plugins[$cur_plugin_recordset])) {
						$cur_plugin_index = 1;
						$cur_plugin_recordset++;
					}
				}
			}
		}
		$retval .= '</table>'
			.COM_endBlock();
			
	} else {
		$retval .= COM_startBlock($LANG09[13])
			.$LANG09[14].' <b>'.$query.'</b> '.$LANG09[15]
			.COM_endBlock();
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
$display .= site_header();
if ($mode == 'search') {
	$display .= searchstories($query,$topic,$datestart,$dateend,$author,$type);
} else {
	$display .= searchform();
}
$display .= site_footer();
echo $display;
?>
