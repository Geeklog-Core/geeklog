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
// $Id: search.php,v 1.44 2002/11/09 20:23:14 dhaun Exp $

require_once('lib-common.php');

// echo COM_debug($HTTP_POST_VARS);

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
    $searchform->set_var('topic_option_list', COM_topicList('tid,topic'));
    $searchform->set_var('lang_type', $LANG09[5]);
    $searchform->set_var('lang_stories', $LANG09[6]);
    $searchform->set_var('lang_comments', $LANG09[7]);
    $searchform->set_var('lang_links', $LANG09[39]);
    $searchform->set_var('lang_events', $LANG09[40]);
    $plugintypes = PLG_getSearchTypes();
    $pluginoptions = '';
    // Generally I don't like to hardcode HTML but this seems easiest
    for ($i = 1; $i <= count($plugintypes); $i++) {
        $pluginoptions .= '<option value="' . key($plugintypes) . '">' . current($plugintypes) . '</option>' . LB; 
        next($plugintypes);
    }
    $searchform->set_var('plugin_types', $pluginoptions);

    if ($_CONF['contributedbyline'] == 1) {
        $searchform->set_var('lang_authors', $LANG09[8]);
        $searchusers = array();
        $result = DB_query("SELECT DISTINCT uid FROM {$_TABLES['comments']}");
        for ($i = 1; $i <= DB_numRows($result); $i++) {
            $A = DB_fetchArray($result);
            $searchusers[$A['uid']] = $A['uid'];
        }
        $result = DB_query("SELECT DISTINCT uid FROM {$_TABLES['stories']} WHERE (date <= NOW()) AND (draft_flag = 0)");
        for ($i = 1; $i <= DB_numRows($result); $i++) {
            $A = DB_fetchArray($result);
            $searchusers[$A['uid']] = $A['uid'];
        }
        for ($i = 1; $i <= count($searchusers); $i++) {
            $inlist .= current($searchusers);
            if ($i < count($searchusers)) {
                $inlist .= ',';
            }
            next($searchusers);
        }
        if (!empty ($inlist)) {
            $result = DB_query("SELECT uid,username FROM {$_TABLES['users']} WHERE uid in ($inlist) ORDER by username");
            $useroptions = '';
            for ($i = 1; $i <= DB_numRows($result); $i++) {
                $A = DB_fetchArray($result);
                $useroptions .= '<option value="' . $A['uid'] . '">' . $A['username'] . '</option>';
            }
            $searchform->set_var('author_option_list', $useroptions);
            $searchform->parse('author_form_element', 'authors', true);
        } else {
            $searchform->set_var('author_form_element', '<input type="hidden" name="author" value="0">');
        }
    } else {
        $searchform->set_var('author_form_element', '<input type="hidden" name="author" value="0">');
    }
    $searchform->set_var('lang_search', $LANG09[10]);	
    $searchform->parse('output', 'searchform');

    $retval .= $searchform->finish($searchform->get_var('output'));
    $retval .= COM_endBlock();

    return $retval;
}

function searchlinks($query, $topic, $datestart, $dateend, $author, $type='all')
{
    global $LANG09, $_CONF, $_TABLES;

    if (empty($type)) {
        $type = 'all';
    }

    // Note: When searching for "all" with an empty query string and any of
    // the author, date start or date end fields NOT empty, we just skip the
    // search, since links don't have an author or a date.
    if (($type == 'links') || !(($type == 'all') && empty ($query) && (!empty ($author) || !empty ($datestart) || !empty ($dateend)))) {
        $sql = "SELECT lid,title,url,hits,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']} WHERE ";
		$sql .= " (title like '%$query%' ";
		$sql .= " OR description like '%$query%') ";
        if (!empty($datestart) && !empty($dateend)) {
			$delim = substr($datestart, 4, 1);
			$DS = explode($delim,$datestart);
			$DE = explode($delim,$dateend);
			$startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
			$enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
			$sql .= "AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate') ";
		}
        $sql .= "ORDER BY title ASC";
		$result_links = DB_query($sql);
		$nrows_links = DB_numRows($result_links);
        require_once($_CONF['path_system'] . 'classes/plugin.class.php');
        $link_results = new Plugin();
        $link_results->searchlabel = $LANG09[38];
        $link_results->addSearchHeading($LANG09[16]);
        $link_results->addSearchHeading($LANG09[33]);
        $link_results->addSearchHeading($LANG09[23]);
        $link_results->num_searchresults = 0;
        $link_results->num_itemssearched = DB_count($_TABLES['links']);

        // NOTE if any of your data items need to be links then add them here! 
        // make sure data elements are in an array and in the same order as your
        // headings above!
        $numRows = DB_numRows($result_links);
        for ($i = 1; $i <= $numRows; $i++) {
            $A = DB_fetchArray($result_links);
            if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
                $thetime = COM_getUserDateTimeFormat($A['day']);
                $row = array($A['title'], '<a href="' . $_CONF['site_url']
                     . '/portal.php?url=' . urlencode ($A['url'])
                     . '&amp;what=link&amp;item=' . $A['lid'] . '">' . $A['url']
                     . '</a>', $A['hits']);
                $link_results->addSearchResult($row);
                $link_results->num_searchresults++;
            } else {
                // user is not allowed to see this item so don't count it either
                $link_results->num_itemssearched--;
            }
        }
    } else {
        $link_results = new Plugin();
        $link_results->searchlabel = $LANG09[38];
        $link_results->num_itemssearched = DB_count($_TABLES['links']);
    }

    return $link_results;
}

function searchevents($query, $topic, $datestart, $dateend, $author, $type='all') {
    global $LANG09, $_CONF, $_TABLES;

    if (empty($type)) {
        $type = 'all';
    }

    if (($type == 'events') || (($type == 'all') && empty ($author))) {
		$sql = "SELECT eid,title,location,datestart,dateend,timestart,timeend,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon,UNIX_TIMESTAMP(datestart) as day FROM {$_TABLES['events']} WHERE ";
        $sql .= "(title like '%$query%' OR ";
        $sql .= "location like '%$query%' ";
		$sql .= "OR description like '%$query%') ";
        if (!empty($datestart) && !empty($dateend)) {
            $delim = substr($datestart, 4, 1);
            $DS = explode($delim,$datestart);
            $DE = explode($delim,$dateend);
            $startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
			$enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
            $sql .= "AND (UNIX_TIMESTAMP(datestart) BETWEEN '$startdate' AND '$enddate') ";
		}
        $sql .= "ORDER BY datestart desc";
        $result_events = DB_query($sql);
        $nrows_events = DB_numRows($result_events);
        require_once($_CONF['path_system'] . 'classes/plugin.class.php');
        $event_results = new Plugin();
        $event_results->searchresults = array();
        $event_results->searchlabel = $LANG09[37];
        $event_results->addSearchHeading($LANG09[16]);
        $event_results->addSearchHeading($LANG09[17]);
        $event_results->addSearchHeading($LANG09[34]);
        $event_results->num_searchresults = 0;
        $event_results->num_itemssearched = DB_count($_TABLES['events']);

        // NOTE if any of your data items need to be links then add them here! 
        // make sure data elements are in an array and in the same order as your
        // headings above!
        $numRows = DB_numRows($result_events);
        for ($i = 1; $i <= $numRows; $i++) {
            $A = DB_fetchArray($result_events);
            if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
                if ($A['allday'] == 0) {
                    $fulldate = $A['datestart'] . ' ' . $A['timestart'] . ' - ' . $A['dateend'] . ' ' . $A['timeend'];
                } else {
                    if ($A['datestart'] <> $A['dateend']) {
                        $fulldate = $A['datestart'] . ' - ' . $A['dateend'] . ' ' . $LANG09[35];
                    } else {
                        $fulldate = $A['datestart'] . ' ' . $LANG09[35];
                    }
                }
                $thetime = COM_getUserDateTimeFormat($A['day']);
                $A['title'] = str_replace('$','&#36;',$A['title']);
                $row = array('<a href="' . $_CONF['site_url'] . '/calendar_event.php?eid=' . $A['eid'] . '">' . $A['title'] . '</a>',
                            $fulldate,
                            $A['location']);
                $event_results->addSearchResult($row);
                $event_results->num_searchresults++;
            } else {
                // user is not allowed to see this item so don't count it either
                $event_results->num_itemssearched--;
            }
        }
    } else {
        $event_results = new Plugin();
        $event_results->searchlabel = $LANG09[37];
    }
    return $event_results;
}

function searchstories($query,$topic,$datestart,$dateend, $author, $type='all') 
{
    global $LANG09, $_CONF, $_TABLES, $_USER, $_GROUPS;

    require_once($_CONF['path_system'] . 'classes/plugin.class.php');

    $searchtimer = new timerobject();
    $searchtimer->setPercision(4);
    $searchtimer->startTimer();

    $groupList = '';
    if (!empty ($_USER['uid'])) {
        foreach ($_GROUPS as $grp) {
            $groupList .= $grp . ',';
        }
        $groupList = substr ($groupList, 0, -1);
    }

	if ($type == 'all' OR $type == 'stories') {
		$sql = "SELECT sid,title,hits,uid,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon,UNIX_TIMESTAMP(date) as day,'story' as type FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) ";
        if (!empty ($query)) {
		    $sql .= "AND (introtext like '%$query%'  ";
		    $sql .= "OR bodytext like '%$query%' ";
		    $sql .= "OR title like '%$query%')  ";
        }
		if (!empty($datestart) && !empty($dateend)) {
			$delim = substr($datestart, 4, 1);
			$DS = explode($delim,$datestart);
			$DE = explode($delim,$dateend);
			$startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
			$enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
			$sql .= "AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate') ";
		}
		if (!empty($topic)) {
			$sql .= "AND (tid = '$topic') ";
		}
		if (!empty($author)) {
			$sql .= "AND (uid = '$author') ";
		}
        $permsql .= 'AND (';
        if (!empty ($_USER['uid'])) {
            $permsql .= "(owner_id = {$_USER['uid']} AND perm_owner >= 2) OR ";
            $permsql .= "(group_id IN ($groupList) AND perm_group >= 2) OR ";
            $permsql .= "(perm_members >= 2) OR ";
        }
        $permsql .= "(perm_anon >= 2)) ";
        $sql .= $permsql;
		$sql .= "ORDER BY date desc";

		$result_stories = DB_query($sql);
		$nrows_stories = DB_numRows($result_stories);
		$result_count = DB_query("SELECT count(*) FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) " . $permsql);
		$B = DB_fetchArray($result_count);
		$total_stories = $B[0];
		$A = DB_fetchArray($result_stories);
	}

	if ($type == 'all' OR $type == 'comments') {

        $stsql = '';
        $stwhere = '';
        if (!empty ($_USER['uid'])) {
            $stsql .= "({$_TABLES['stories']}.owner_id = {$_USER['uid']} AND {$_TABLES['stories']}.perm_owner >= 2) OR ";
            $stsql .= "({$_TABLES['stories']}.group_id IN ($groupList) AND {$_TABLES['stories']}.perm_group >= 2) OR ";
            $stsql .= "({$_TABLES['stories']}.perm_members >= 2) OR ";
            $stwhere .= "({$_TABLES['stories']}.owner_id IS NOT NULL AND {$_TABLES['stories']}.perm_owner IS NOT NULL) OR ";
            $stwhere .= "({$_TABLES['stories']}.group_id IS NOT NULL AND {$_TABLES['stories']}.perm_group IS NOT NULL) OR ";
            $stwhere .= "({$_TABLES['stories']}.perm_members IS NOT NULL) OR ";
        }
        $stsql .= "({$_TABLES['stories']}.perm_anon >= 2)";
        $stwhere .= "({$_TABLES['stories']}.perm_anon IS NOT NULL)";

        $posql = '';
        $powhere = '';
        if (!empty ($_USER['uid'])) {
            $posql .= "({$_TABLES['pollquestions']}.owner_id = {$_USER['uid']} AND {$_TABLES['pollquestions']}.perm_owner >= 2) OR ";
            $posql .= "({$_TABLES['pollquestions']}.group_id IN ($groupList) AND {$_TABLES['pollquestions']}.perm_group >= 2) OR ";
            $posql .= "({$_TABLES['pollquestions']}.perm_members >= 2) OR ";
            $powhere .= "({$_TABLES['pollquestions']}.owner_id IS NOT NULL AND {$_TABLES['pollquestions']}.perm_owner IS NOT NULL) OR ";
            $powhere .= "({$_TABLES['pollquestions']}.group_id IS NOT NULL AND {$_TABLES['pollquestions']}.perm_group IS NOT NULL) OR ";
            $powhere .= "({$_TABLES['pollquestions']}.perm_members IS NOT NULL) OR ";
        }
        $posql .= "({$_TABLES['pollquestions']}.perm_anon >= 2)";
        $powhere .= "({$_TABLES['pollquestions']}.perm_anon IS NOT NULL)";

		$sql = "SELECT {$_TABLES['stories']}.sid,{$_TABLES['comments']}.title,comment,pid,{$_TABLES['comments']}.uid,type as comment_type,UNIX_TIMESTAMP({$_TABLES['comments']}.date) as day,'comment' as type FROM {$_TABLES['comments']} ";
        $sql .= "LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid) AND (" . $stsql . ")) ";
        $sql .= "LEFT JOIN {$_TABLES['pollquestions']} ON ((qid = {$_TABLES['comments']}.sid) AND (" . $posql . ")) ";
        $sql .= "WHERE ";
		$sql .= " (comment like '%$query%' ";
		$sql .= "OR {$_TABLES['comments']}.title like '%$query%') ";
		if (!empty($datestart) && !empty($dateend)) {
			$delim = substr($datestart, 4, 1);
			$DS = explode($delim,$datestart);
			$DE = explode($delim,$dateend);
			$startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
			$enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
			$sql .= "AND (UNIX_TIMESTAMP({$_TABLES['comments']}.date) BETWEEN '$startdate' AND '$enddate') ";
		}
		if (!empty($author)) {
			$sql .= "AND ({$_TABLES['comments']}.uid = '$author') ";
		}
        $sql .= "AND ((" .  $stwhere . ") OR (" . $powhere . ")) ";
		$sql .= "ORDER BY {$_TABLES['comments']}.date DESC";
		$result_comments = DB_query($sql);
		$nrows_comments  = DB_numRows($result_comments);
        $sql = "SELECT count(*) FROM {$_TABLES['comments']} LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid) AND (" . $stsql . ")) LEFT JOIN {$_TABLES['pollquestions']} ON ((qid = {$_TABLES['comments']}.sid) AND (" . $posql . ")) WHERE ((" .  $stwhere . ") OR (" . $powhere . "))";
        $result_count = DB_query ($sql);
        $B = DB_fetchArray ($result_count);
        $total_comments = $B[0];
		$C = DB_fetchArray($result_comments);
	}

    // Have plugins do their searches
    list($nrows_plugins, $total_plugins, $result_plugins) = PLG_doSearch($query, $datestart, $dateend, $topic, $type, $author);

    // Search Links and Events
    $link_results = searchlinks($query, $topic, $datestart, $dateend, $author, $type);
    $event_results = searchevents($query, $topic, $datestart, $dateend, $author, $type);

    // OK, we now have the header items and results needed to 
    $total = $total_stories + $total_comments + $total_plugins + $link_results->num_itemssearched + $event_results->num_itemssearched;
    $nrows = $nrows_stories + $nrows_comments + $nrows_plugins + $link_results->num_searchresults + $event_results->num_searchresults;

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

        if (($nrows_stories + $nrows_comments > 0) ||
		      $_CONF['showemptysearchresults']) {

            // Print heading for story/comment results
            $searchresults->set_var('label', $LANG09[16]);
            $searchresults->parse('headings','headingcolumn',true);
            $searchresults->set_var('label', $LANG09[17]);
            $searchresults->parse('headings','headingcolumn',true);
            $searchresults->set_var('label', $LANG09[18]);
            $searchresults->parse('headings','headingcolumn',true);
            $searchresults->set_var('label', $LANG09[23]);
            $searchresults->parse('headings','headingcolumn',true);

            $searchresults->set_var('start_block_results',
                COM_startBlock($LANG09[29]));
            if ($nrows_stories + $nrows_comments > 0) {
                for ($i=1; $i <= $nrows; $i++) {
                    if ($A['day'] > $C['day']) {
                        // print row
                        $A['title'] = str_replace('$','&#36;',$A['title']);
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
                        $searchresults->set_var('data_cols','');

                        $A = DB_fetchArray($result_stories);
                    } else if (strlen($C['day']) > 0) {
                        $C['title'] = str_replace('$','&#36;',$C['title']);
                        if ($C['comment_type'] == 'article') {
                            $searchresults->set_var('data', '<a href="article.php?story=' . $C['sid'] . '">' . stripslashes($C['title']) . '</a>');
                        } else {
                            $searchresults->set_var('data', '<a href="pollbooth.php?qid=' . $C['sid'] . '&amp;aid=-1#comments">' . stripslashes($C['title']) . '</a>');
                        }
                        $searchresults->parse('data_cols','resultcolumn',true);

                        $thetime = COM_getUserDateTimeFormat($C['day']);
                        $searchresults->set_var('data', $thetime[0]);
                        $searchresults->parse('data_cols','resultcolumn',true);

                        $searchresults->set_var('data', DB_getItem($_TABLES['users'],'username',"uid = '{$C['uid']}'"));
                        $searchresults->parse('data_cols','resultcolumn',true);

                        $searchresults->set_var('data', $C['hits']);
                        $searchresults->parse('data_cols','resultcolumn',true);

                        $searchresults->parse('results','resultrow',true);
                        $searchresults->set_var('data_cols','');

                        $C = DB_fetchArray($result_comments);
                    }
                }
            } else {
                $searchresults->set_var('results','<tr><td colspan="4" align="center"><br>' . $LANG09[28] . '</td></tr>');
            }

            $searchresults->set_var('end_block', COM_endBlock());
            $searchresults->parse('search_blocks','searchblock',true);
        }

        // Print link results
        if (($link_results->num_searchresults > 0) ||
		          $_CONF['showemptysearchresults']) {
            $searchresults->set_var('data_cols','');
            $searchresults->set_var('start_block_results',
				    COM_startBlock($link_results->searchlabel));
            $searchresults->set_var('headings','');
            for ($j = 1; $j <= $link_results->num_searchheadings; $j++) {
                $searchresults->set_var('label', $link_results->searchheading[$j]);
                $searchresults->parse('headings','headingcolumn',true);
            }
            $searchresults->set_var('results','');
            if ($link_results->num_searchresults > 0) {
                for ($j = 1; $j <= $link_results->num_searchresults; $j++) {
                    $columns = current ($link_results->searchresults);
                    for ($x = 1; $x <= count($columns); $x++) {
                        $searchresults->set_var('data', current($columns));
                        $searchresults->parse('data_cols','resultcolumn',true);
                        next($columns);
                    }
                    $searchresults->parse('results','resultrow',true);
                    $searchresults->set_var('data_cols','');
                    next($link_results->searchresults);
                }
            } else {
                $searchresults->set_var ('results',
					     '<tr><td colspan="4" align="center"><br>' . $LANG09[30] .
						  '</td></tr>');
            }
            $searchresults->parse('results','resultrow',true);
            $searchresults->set_var('end_block', COM_endBlock());
            $searchresults->parse('search_blocks','searchblock',true);
        }

        // Print event results
        if (($event_results->num_searchresults > 0) ||
		          $_CONF['showemptysearchresults']) {
            $searchresults->set_var('data_cols','');
            $searchresults->set_var('start_block_results',
				    COM_startBlock($event_results->searchlabel));
            $searchresults->set_var('headings','');
            for ($j = 1; $j <= $event_results->num_searchheadings; $j++) {
                $searchresults->set_var('label', $event_results->searchheading[$j]);
                $searchresults->parse('headings','headingcolumn',true);
            }
            $searchresults->set_var('results','');
            if ($event_results->num_searchresults > 0) {
                for ($j = 1; $j <= $event_results->num_searchresults; $j++) {
                    $columns = current ($event_results->searchresults);
                    for ($x = 1; $x <= count($columns); $x++) {
                        $searchresults->set_var('data', current($columns));
                        $searchresults->parse('data_cols','resultcolumn',true);
                        next($columns);
                    }
                    $searchresults->parse('results','resultrow',true);
                    $searchresults->set_var('data_cols','');
                    next($event_results->searchresults);
                }
            } else {
                $searchresults->set_var ('results',
					     '<tr><td colspan="4" align="center"><br>' . $LANG09[36] .
						  '</td></tr>');
            }
            $searchresults->parse('results','resultrow',true);
            $searchresults->set_var('end_block', COM_endBlock());
            $searchresults->parse('search_blocks','searchblock',true);
        }

        // Print plugins search results
        reset($result_plugins);
        $cur_plugin = new Plugin();
        $searchresults->set_var('data_cols','');
        $searchresults->set_var('headings','');
        for ($i = 1; $i <= count($result_plugins); $i++) {
            $cur_plugin = current($result_plugins);
		      if (($cur_plugin->num_searchresults > 0) ||
		              $_CONF['showemptysearchresults']) {
                // Clear out data columns from previous result block
                $searchresults->set_var('data_cols','');
                $searchresults->set_var('start_block_results',
					     COM_startBlock($cur_plugin->searchlabel));
                $searchresults->set_var('headings','');
                for ($j = 1; $j <= $cur_plugin->num_searchheadings; $j++) {
                    $searchresults->set_var('label', $cur_plugin->searchheading[$j]);
                    $searchresults->parse('headings','headingcolumn',true);
                }
                $searchresults->set_var('results','');
                for ($j = 1; $j <= $cur_plugin->num_searchresults; $j++) {
                    $columns = current($cur_plugin->searchresults);
                    for ($x = 1; $x <= count($columns); $x++) {
                        $searchresults->set_var('data', current($columns));
                        $searchresults->parse('data_cols','resultcolumn',true);
                        next($columns);
                    }
                    $searchresults->parse('results','resultrow',true);
                    $searchresults->set_var('data_cols','');
                    next($cur_plugin->searchresults);
                }
                if ($cur_plugin->num_searchresults == 0) {
                    $searchresults->set_var('results',
						      '<tr><td colspan="4" align="center"><br>' . $LANG09[31]
								. '</td></tr>');
                }
                $searchresults->set_var('end_block', COM_endBlock());
                $searchresults->parse('search_blocks','searchblock',true);
            }
            next($result_plugins);
        }

        $retval .= $searchresults->parse('output','searchresults');
	} else {
        $retval .= COM_startBlock($LANG09[13])
                    . $LANG09[14] . ' <b>' . $query . '</b>. ' . $LANG09[15]
			        . COM_endBlock();
        if (advsearchAllowed ()) {
            $retval .= searchform ();
        }
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

    $A['title'] = str_replace('$','&#36;',$A['title']);
	$retval .= '<tr align="center">'.LB
		.'<td align="left"><a href="article.php?story='.$A['sid'].'">'.stripslashes($A['title']).'</a></td>'.LB
		.'<td>'.strftime($_CONF['shortdate'],$A['day']).'</td>'.LB
		.'<td>'.DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'").'</td>'.LB
		.'<td>'.$A['hits'].'</td>'.LB
		.'</tr>'.LB;
	
	return $retval;
}

/**
* Does a check of the date format (should be YYYY-MM-DD).
*
* @param  string  $date  date string to check
* @return bool    true if correct, false if not
*/
function simpleDateCheck ($date)
{
    $ok = true;

    if (!empty ($date)) {
        $ok = false;
        if (strlen ($date) == 10) {
            $delim1 = substr ($date, 4, 1);
            $delim2 = substr ($date, 7, 1);
            if (($delim1 == $delim2) && ($delim1 == '-')) {
                $dt = explode ($delim1, $date);
                if (($dt[0] >= 1970) && (($dt[1] >= 1) && ($dt[1] <= 12)) &&
                        (($dt[2] >= 1) && ($dt[2] <= 31))) {
                    $ok = checkdate ($dt[1], $dt[2], $dt[0]);
                }
            }
        }
    }

    return $ok;
}

/*
* display "login required" message
*/
function loginRequired ()
{
    global $_CONF, $LANG_LOGIN;

    $retval .= COM_startBlock($LANG_LOGIN[1]);
    $login = new Template($_CONF['path_layout'] . 'submit');
    $login->set_file (array ('login'=>'submitloginrequired.thtml'));
    $login->set_var ('login_message', $LANG_LOGIN[2]);
    $login->set_var ('site_url', $_CONF['site_url']);
    $login->set_var ('lang_login', $LANG_LOGIN[3]);
    $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
    $login->parse ('output', 'login');
    $retval .= $login->finish ($login->get_var('output'));
    $retval .= COM_endBlock();

    return $retval;
}

/*
* check if advanced search is allowed for the current user
*/
function advsearchAllowed ()
{
    global $_CONF, $_USER;

    if (empty ($_USER['username']) && (($_CONF['loginrequired'] == 1) ||
            ($_CONF['searchloginrequired'] >= 1))) {
        return false;
    }

    return true;
}

// MAIN
$display .= COM_siteHeader();

if ($mode == 'search') // search query
{
    if (empty ($_USER['username']) && (($_CONF['loginrequired'] == 1) ||
            ($_CONF['searchloginrequired'] == 2))) {
        $display .= loginRequired ();
    } else {
        $query = strip_tags ($query);

        if (!advsearchAllowed ($query)) {
            // if advanced search is not allowed for the current user
            // then just ignore the advanced options
            $type = 'all';
            unset ($datestart);
            unset ($dateend);
            unset ($author);
            unset ($topic);
        }

        // check for minimal length of the query
        if ((strlen ($query) < 3) && (empty ($topic) || ($topic == '0')) &&
                (empty ($datestart) && empty ($dateend)) && (empty ($type) ||
                ($type == 'all')) && (empty ($author) || ($author == '0'))) {
            $display .= COM_startBlock ($LANG09[13])
                     . $LANG09[41] . ' ' . $LANG09[15]
                     . COM_endBlock();
            if (advsearchAllowed ()) {
                $display .= searchform ();
            }
        } else if (!simpleDateCheck($datestart) || !simpleDateCheck($dateend)) {
            // invalid date format
            $display .= COM_startBlock ($LANG09[13])
                     . $LANG09[42] . ' ' . $LANG09[15]
                     . COM_endBlock();
            if (advsearchAllowed ()) {
                $display .= searchform ();
            }
        } else {
            $display .= searchstories($query,$topic,$datestart,$dateend,$author,$type);
        }
    }
}
else // display advanced search form
{
    if (advsearchAllowed ()) {
        $display .= searchform ();
    } else {
        $display .= loginRequired ();
    }
}

$display .= COM_siteFooter();
echo $display;

?>
