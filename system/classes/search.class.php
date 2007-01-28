<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | search.php                                                                |
// |                                                                           |
// | Geeklog search class.                                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT geeklog DOT net                       |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
// $Id: search.class.php,v 1.58 2007/01/28 10:15:03 dhaun Exp $

if (strpos ($_SERVER['PHP_SELF'], 'search.class.php') !== false) {
    die ('This file can not be used on its own.');
}

require_once ($_CONF['path_system'] . 'classes/plugin.class.php');

/**
* Geeklog Search Class
*
* @author Tony Bibbs <tony AT geeklog DOT net>
* @package net.geeklog.search
*
*/
class Search {
    /**
    * @access private
    * @var string
    */
    var $_query = '';

    /**
    * @access private
    * @var string
    */
    var $_topic = '';

    /**
    * @access private
    * @var string
    */
    var $_dateStart = null;

    /**
    * @access private
    * @var string
    */
    var $_dateEnd = null;

    /**
    * @access private
    * @var integer
    */
    var $_author = null;

    /**
    * @access private
    * @var string
    */
    var $_type = '';

    /**
    * @access private
    * @var string
    */
    var $_keyType = '';

    /**
    * @access private
    * @var integer
    */
    var $_page = 0;

    /**
    * @access private
    * @var integer
    */
    var $_per_page = 10;

    /**
    * Constructor
    *
    * Sets up private search variables
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access public
    *
    */
    function Search()
    {
        global $_CONF;

        // Set search criteria
        if (isset ($_REQUEST['query'])) {
            $this->_query = strip_tags (COM_stripslashes ($_REQUEST['query']));
        }
        if (isset ($_REQUEST['topic'])) {
            $this->_topic = COM_applyFilter ($_REQUEST['topic']);
        }
        if (isset ($_REQUEST['datestart'])) {
            $this->_dateStart = COM_applyFilter ($_REQUEST['datestart']);
        }
        if (isset ($_REQUEST['dateend'])) {
            $this->_dateEnd = COM_applyFilter ($_REQUEST['dateend']);
        }
        if (isset ($_REQUEST['author'])) {
            $this->_author = COM_applyFilter ($_REQUEST['author']);
        }
        if (isset ($_REQUEST['type'])) {
            $this->_type = COM_applyFilter ($_REQUEST['type']);
        }
        if (empty ($this->_type)) {
            $this->_type = 'all';
        }
        if (isset ($_REQUEST['keyType'])) {
            $this->_keyType = COM_applyFilter ($_REQUEST['keyType']);
        }
        if (isset ($_REQUEST['results'])) {
            $this->_per_page = COM_applyFilter ($_REQUEST['results'], true);
        }
        if ($this->_per_page < 1) {
            if (isset ($_CONF['num_search_results']) &&
                    ($_CONF['num_search_results'] > 0)) {
                $this->_per_page = $_CONF['num_search_results'];
            } else {
                $this->_per_page = 10;
            }
        }
        if (isset ($_REQUEST['page'])) {
            $this->_page = COM_applyFilter ($_REQUEST['page'], true);
        }
        if ($this->_page < 1) {
            $this->_page = 1;
        }

        // In case we got a username instead of uid, convert it.  This should
        // make custom themes for search page easier.
        $this->_convertAuthor();
    }

    /**
    * Converts a username to a uid
    *
    * @author Tony Bibbs <tony AT geeklog DOT net
    * @access private
    *
    */
    function _convertAuthor()
    {
        global $_TABLES;

        if (is_numeric ($this->_author) &&
                preg_match ('/^([0-9]+)$/', $this->_author)) {
            return;
        }

        if (!empty ($this->_author)) {
            $this->_author = DB_getItem ($_TABLES['users'], 'uid',
                    "username='" . addslashes ($this->_author) . "'");
        }
    }

    /**
    * Return the user's username or full name for display, depending
    * on the $_CONF['show_fullname'] config.php setting
    *
    * @author Dirk Haun <dirk AT haun-online DOT de
    * @access private
    *
    */
    function _displayName ($username, $fullname)
    {
        return COM_getDisplayName('', $username, $fullname);
    }

    /**
    * Performs search on all stories
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access private
    * @return object plugin object
    *
    */
    function _searchStories()
    {
        global $_CONF, $_TABLES, $_USER, $_GROUPS, $LANG09;

        $urlQuery = urlencode ($this->_query);

        if ($this->_type == 'all' OR $this->_type == 'stories') {

            $select = "SELECT u.username,u.fullname,s.uid,sid,title,introtext,bodytext,hits,UNIX_TIMESTAMP(date) AS day,'story' AS type";
            $sql = " FROM {$_TABLES['stories']} AS s,{$_TABLES['users']} AS u WHERE (draft_flag = 0) AND (date <= NOW()) AND (u.uid = s.uid) ";

            if (!empty ($this->_query)) {
                if($this->_keyType == 'phrase') {
                    // do an exact phrase search (default)
                    $mywords[] = $this->_query;
                    $mysearchterm = addslashes ($this->_query);
                    $sql .= "AND (introtext LIKE '%$mysearchterm%' ";
                    $sql .= "OR bodytext LIKE '%$mysearchterm%' ";
                    $sql .= "OR title LIKE '%$mysearchterm%') ";
                } elseif($this->_keyType == 'all') {
                    // must contain ALL of the keywords
                    $mywords = explode(' ', $this->_query);
                    $sql .= 'AND ';
                    $tmp = '';
                    foreach ($mywords AS $mysearchterm) {
                        $mysearchterm = addslashes (trim ($mysearchterm));
                        $tmp .= "(introtext LIKE '%$mysearchterm%' OR ";
                        $tmp .= "bodytext LIKE '%$mysearchterm%' OR ";
                        $tmp .= "title LIKE '%$mysearchterm%') AND ";
                    }
                    $tmp = substr($tmp, 0, strlen($tmp) - 4);
                    $sql .= $tmp;
                }
                elseif($this->_keyType == 'any') {
                    // must contain ANY of the keywords
                    $mywords = explode(' ', $this->_query);
                    $sql .= 'AND ';
                    $tmp = '';
                    foreach ($mywords AS $mysearchterm) {
                        $mysearchterm = addslashes (trim ($mysearchterm));
                        $tmp .= "(introtext LIKE '%$mysearchterm%' OR ";
                        $tmp .= "bodytext LIKE '%$mysearchterm%' OR ";
                        $tmp .= "title LIKE '%$mysearchterm%') OR ";
                    }
                    $tmp = substr($tmp, 0, strlen($tmp) - 3);
                    $sql .= "($tmp)";
                } else {
                    $mywords[] = $this->_query;
                    $mysearchterm = addslashes ($this->_query);
                    $sql .= "AND (introtext LIKE '%$mysearchterm%' ";
                    $sql .= "OR bodytext LIKE '%$mysearchterm%' ";
                    $sql .= "OR title LIKE '%$mysearchterm%') ";
                }
            }
            if (!empty($this->_dateStart) AND !empty($this->_dateEnd)) {
                $delim = substr($this->_dateStart, 4, 1);
                if (!empty($delim)) {
                    $DS = explode($delim, $this->_dateStart);
                    $DE = explode($delim, $this->_dateEnd);
                    $startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
                    $enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
                    $sql .= "AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate') ";
                }
            }
            if (!empty($this->_topic)) {
                $sql .= "AND (tid = '$this->_topic') ";
            }
            if (!empty($this->_author) && ($this->_author > 0)) {
                $sql .= "AND (s.uid = '$this->_author') ";
            }
            $sql .= COM_getPermSQL ('AND') . COM_getTopicSQL ('AND');
            $sql .= COM_getLangSQL ('sid', 'AND');
            $sql .= ' GROUP BY date, username, fullname, u.uid, s.uid, sid, title, hits , s.introtext, s.bodytext ORDER BY date DESC ';
            $l = ($this->_per_page * $this->_page) - $this->_per_page;
            $sql .= 'LIMIT ' . $l . ',' . $this->_per_page;

            $result_stories = DB_query ($select . $sql);
            $result_count = DB_query ('SELECT COUNT(*)' . $sql);
            $B = DB_fetchArray ($result_count, true);

            $story_results = new Plugin();
            $story_results->searchlabel = $LANG09[53];
            $story_results->addSearchHeading($LANG09[16]);
            $story_results->addSearchHeading($LANG09[17]);
            if ($_CONF['contributedbyline'] == 1) {
                $story_results->addSearchHeading($LANG09[18]);
            }
            if ($_CONF['hideviewscount'] == 0) {
                $story_results->addSearchHeading($LANG09[23]);
            }
            $story_results->num_searchresults = 0;
            $story_results->num_itemssearched = $B[0];
            $story_results->supports_paging = true;

            // NOTE if any of your data items need to be links then add them
            // here! Make sure data elements are in an array and in the same
            // order as your headings above!
            while ($A = DB_fetchArray($result_stories)) {
                // get rows
                $A['title'] = str_replace ('$', '&#36;', $A['title']);
                $thetime = COM_getUserDateTimeFormat ($A['day']);
                if (empty ($urlQuery)) {
                    $articleUrl = COM_buildUrl ($_CONF['site_url']
                                    . '/article.php?story=' . $A['sid']);
                } else {
                    $articleUrl = $_CONF['site_url'] . '/article.php?story='
                        . $A['sid'] . '&amp;query=' . urlencode ($urlQuery);
                }
                $author = $this->_displayName ($A['username'], $A['fullname']);
                if ($A['uid'] == 1) {
                    $profile = $author;
                } else {
                    $profile = '<a href="' . $_CONF['site_url']
                             . '/users.php?mode=profile&amp;uid=' . $A['uid']
                             . '">' . $author . '</a>';
                }
                $row = array ('<a href="' . $articleUrl . '">'
                                          . stripslashes ($A['title']) . '</a>',
                              $thetime[0]);
                if ($_CONF['contributedbyline'] == 1) {
                    $row[] = $profile;
                }
                if ($_CONF['hideviewscount'] == 0) {
                    $row[] = COM_NumberFormat ($A['hits']);
                }
                $story_results->addSearchResult ($row);
                $story_results->num_searchresults++;
            }
        } else {
            $story_results = new Plugin();
            $story_results->searchlabel = $LANG09[53];
            $story_results->num_itemssearched = 0;
        }

        return $story_results;
    }

    /**
    * Performs search on all comments
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access private
    * @return object plugin object
    *
    */
    function _searchComments()
    {
        global $_CONF, $_TABLES, $_USER, $_GROUPS, $LANG09;

        if ($this->_type == 'all' OR $this->_type == 'comments') {

            $stsql = COM_getPermSQL ('AND', 0, 2, $_TABLES['stories']);
            $stsql .= COM_getTopicSQL ('AND');
            $stsql .= COM_getLangSQL ('sid', 'AND', $_TABLES['stories']);

            $stwhere = '';

            if (empty ($_USER['uid']) || ($_USER['uid'] == 1)) {
                $stwhere .= "({$_TABLES['stories']}.perm_anon IS NOT NULL)";
            } else {
                $stwhere .= "({$_TABLES['stories']}.owner_id IS NOT NULL AND {$_TABLES['stories']}.perm_owner IS NOT NULL) OR ";
                $stwhere .= "({$_TABLES['stories']}.group_id IS NOT NULL AND {$_TABLES['stories']}.perm_group IS NOT NULL) OR ";
                $stwhere .= "({$_TABLES['stories']}.perm_members IS NOT NULL)";
            }

            $mysearchterm = addslashes ($this->_query);
            $select = "SELECT {$_TABLES['users']}.username,{$_TABLES['users']}.fullname,{$_TABLES['stories']}.sid,{$_TABLES['comments']}.title,comment,pid,cid,{$_TABLES['comments']}.uid,{$_TABLES['comments']}.sid AS qid,type as comment_type,UNIX_TIMESTAMP({$_TABLES['comments']}.date) as day,'comment' as type";
            $sql = " FROM {$_TABLES['users']},{$_TABLES['comments']} ";
            $sql .= "LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid)" . $stsql . ") ";
            $sql .= "WHERE ";
            $sql .= " {$_TABLES['users']}.uid = {$_TABLES['comments']}.uid AND ";
            $sql .= "({$_TABLES['stories']}.draft_flag = 0) AND ({$_TABLES['stories']}.commentcode >= 0) AND ({$_TABLES['stories']}.date <= NOW()) ";

            if (!empty ($this->_query)) {
                if($this->_keyType == 'phrase') {
                    // do an exact phrase search (default)
                    $mywords[] = $this->_query;
                    $mysearchterm = addslashes ($this->_query);
                    $sql .= "AND (comment LIKE '%$mysearchterm%' ";
                    $sql .= "OR {$_TABLES['comments']}.title LIKE '%$mysearchterm%') ";
                } elseif($this->_keyType == 'all') {
                    // must contain ALL of the keywords
                    $mywords = explode(' ', $this->_query);
                    $sql .= 'AND ';
                    $tmp = '';
                    foreach ($mywords AS $mysearchterm) {
                        $mysearchterm = addslashes (trim ($mysearchterm));
                        $tmp .= "(comment LIKE '%$mysearchterm%' OR ";
                        $tmp .= "{$_TABLES['comments']}.title LIKE '%$mysearchterm%') AND ";
                    }
                    $tmp = substr($tmp, 0, strlen($tmp) - 4);
                    $sql .= $tmp;
                } else if ($this->_keyType == 'any') {
                    // must contain ANY of the keywords
                    $mywords = explode(' ', $this->_query);
                    $sql .= 'AND ';
                    $tmp = '';
                    foreach ($mywords AS $mysearchterm) {
                        $mysearchterm = addslashes (trim ($mysearchterm));
                        $tmp .= "(comment LIKE '%$mysearchterm%' OR ";
                        $tmp .= "{$_TABLES['comments']}.title LIKE '%$mysearchterm%') OR ";
                    }
                    $tmp = substr($tmp, 0, strlen($tmp) - 3);
                    $sql .= "($tmp)";
                } else {
                    $mywords[] = $this->_query;
                    $mysearchterm = addslashes ($this->_query);
                    $sql .= "AND (comment LIKE '%$mysearchterm%' ";
                    $sql .= "OR {$_TABLES['comments']}.title LIKE '%$mysearchterm%') ";
                }
            }

            if (!empty($this->_dateStart) && !empty($this->_dateEnd)) {
                $delim = substr($this->_dateStart, 4, 1);
                if (!empty($delim)) {
                    $DS = explode($delim, $this->_dateStart);
                    $DE = explode($delim, $this->_dateEnd);
                    $startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
                    $enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
                    $sql .= "AND (UNIX_TIMESTAMP({$_TABLES['comments']}.date) BETWEEN '$startdate' AND '$enddate') ";
                }
            }
            if (!empty($this->_author)) {
                $sql .= "AND ({$_TABLES['comments']}.uid = '$this->_author') ";
            }
            $sql .= 'AND (' .  $stwhere . ') ';
            $sql .= " GROUP BY {$_TABLES['comments']}.date, {$_TABLES['comments']}.title, {$_TABLES['comments']}.comment, {$_TABLES['comments']}.pid, {$_TABLES['comments']}.cid, {$_TABLES['comments']}.uid, {$_TABLES['comments']}.sid, {$_TABLES['comments']}.type, {$_TABLES['stories']}.sid, {$_TABLES['users']}.fullname, {$_TABLES['users']}.username ORDER BY {$_TABLES['comments']}.date DESC ";
            $l = ($this->_per_page * $this->_page) - $this->_per_page;
            $sql .= 'LIMIT ' . $l . ',' . $this->_per_page;

            $result_comments = DB_query ($select . $sql);
            $result_count = DB_query ('SELECT COUNT(*)' . $sql);
            $B = DB_fetchArray ($result_count, true);

            $comment_results = new Plugin();
            $comment_results->searchlabel = $LANG09[54];
            $comment_results->addSearchHeading($LANG09[16]);
            $comment_results->addSearchHeading($LANG09[17]);
            $comment_results->addSearchHeading($LANG09[18]);
            $comment_results->num_searchresults = 0;
            $comment_results->num_itemssearched = $B[0];
            $comment_results->supports_paging = true;

            if (!empty ($this->_query)) {
                $querystring = '&amp;query=' . $this->_query;
            } else {
                $querystring = '';
            }

            // NOTE if any of your data items need to be links then add them
            // here! Make sure data elements are in an array and in the same
            // order as your headings above!
            $names = array ();
            while ($A = DB_fetchArray($result_comments)) {
                $A['title'] = str_replace('$','&#36;',$A['title']);
                $A['title'] = '<a href="' . $_CONF['site_url']
                            . '/comment.php?mode=view&amp;cid=' . $A['cid']
                            . $querystring . '">' . stripslashes ($A['title'])
                            . '</a>';
                $thetime = COM_getUserDateTimeFormat ($A['day']);
                if (empty ($names[$A['uid']])) {
                    $names[$A['uid']] = COM_getDisplayName ($A['uid']);
                }
                $author = $names[$A['uid']];
                if ($A['uid'] == 1) {
                    $profile = $author;
                } else {
                    $profile = '<a href="' . $_CONF['site_url']
                             . '/users.php?mode=profile&amp;uid=' . $A['uid']
                             . '">' . $author . '</a>';
                }
                $row = array ($A['title'], $thetime[0], $profile);
                $comment_results->addSearchResult($row);
                $comment_results->num_searchresults++;
            }
        } else {
            $comment_results = new Plugin();
            $comment_results->searchlabel = $LANG09[54];
            $comment_results->num_itemssearched = 0;
        }

        return $comment_results;
    }

    function _showPager($resultPage, $pages, $extra='')
    {
        global $_CONF, $LANG09;

        $urlQuery = urlencode($this->_query);
        $pager = '';
        if ($pages > 1) {
            if ($resultPage > 1) {
                $previous = $resultPage - 1;
                $pager .= ' <a href="' . $_CONF['site_url'] . '/search.php?query=' . $urlQuery . '&amp;keyType=' . $this->_keyType . '&amp;page=' . $previous . '&amp;type=' . $this->_type . '&amp;topic=' . $this->_topic . '&amp;mode=search' . $extra . '">' . $LANG09[47] . '</a> ';
            }
            if ($pages <= 20) {
                $startPage = 1;
                $endPage = $pages;
            } else {
                $startPage = $resultPage - 10;
                if ($startPage < 1) {
                    $startPage = 1;
                }
                $endPage = $resultPage + 9;
                if ($endPage > $pages) {
                    $endPage = $pages;
                }
            }
            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $resultPage) {
                    $pager .= " <b>$i</b> ";
                } else {
                    $pager .= " <a href = {$_CONF['site_url']}/search.php?query=$urlQuery&keyType=$this->_keyType&page=$i&type=$this->_type&topic=$this->_topic&mode=search$extra>$i</a> ";
                }
            }
            if ($resultPage < $pages) {
                $next = $resultPage+1;
                $pager .= " <a href = {$_CONF['site_url']}/search.php?query=$urlQuery&keyType=$this->_keyType&page=$next&type=$this->_type&topic=$this->_topic&mode=search$extra>{$LANG09[46]}</a> ";
            }
        }
        return $pager;
    }

    /**
    * Gets formatted output of all searches
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access private
    * @param integer $nrows_plugins Total number of search results
    * @param integer $total_plugins Total number of plugins
    * @param array $result_plugins Array of plugin results
    * @param string $searchtime Elapsed search time
    * @return string HTML output
    *
    */
    function _formatResults($nrows_plugins, $total_plugins, $result_plugins, $searchtime)
    {
        global $_CONF, $_USER, $LANG09;

        $retval = '';

        $searchmain = new Template ($_CONF['path_layout'] . 'search');
        $searchmain->set_file(array ('searchresults' => 'searchresults.thtml'));
        $searchmain->set_var ('num_matches', '');

        if ($this->_keyType == 'any') {
            $searchQuery = str_replace(' ', "</b>' " . $LANG09[57] . " '<b>",$this->_query);
            $searchQuery = "<b>'$searchQuery'</b>";
        } else {
            if ($this->_keyType == 'all') {
                $searchQuery = str_replace(' ', "</b>' " . $LANG09[56] . " '<b>",$this->_query);
                $searchQuery = "<b>'$searchQuery'</b>";
            } else {
                $searchQuery = $LANG09[55] . " '<b>$this->_query</b>'";
            }
        }
        $searchmain->set_var('lang_matchesfor', $LANG09[25] . " $searchQuery.");
        $searchmain->set_var('num_items_searched', 0);
        $searchmain->set_var('lang_itemsin', $LANG09[26]);
        $searchmain->set_var('search_time', $searchtime);
        $searchmain->set_var('lang_seconds', $LANG09[27]);
        $searchmain->set_var('lang_refine_search', $LANG09[61]);

        // Print plugins search results
        reset($result_plugins);
        $cur_plugin = new Plugin();
        $searchresults = new Template($_CONF['path_layout'] . 'search');

        $maxdisplayed = 0;
        $totalfound = 0;
        $searchblocks = '';
        for ($i = 1; $i <= count ($result_plugins); $i++) {
            $displayed = 0;
            $searchresults->set_file (array (
                'searchheading' => 'searchresults_heading.thtml',
                'searchrows'    => 'searchresults_rows.thtml',
                'searchblock'   => 'searchblock.thtml',
                'headingcolumn' => 'headingcolumn.thtml',
                'resultrow'     => 'resultrow.thtml',
                'resulttitle'   => 'resultcolumn.thtml',
                'resultcolumn'  => 'resultcolumn.thtml'
            ));
            if ($i == 1) {
                $searchresults->set_var ('data_cols', '');
                $searchresults->set_var ('headings', '');
            }
            $cur_plugin = current ($result_plugins);
            $start_results = (($this->_per_page * $this->_page) - $this->_per_page) + 1;
            if ($cur_plugin->supports_paging) {
                $start_results = 1;
                $end_results = $cur_plugin->num_searchresults;
                $totalfound += $cur_plugin->num_searchresults;
            } else {
                // this plugin doesn't know about paging - fake it
                if ($cur_plugin->num_searchresults < $start_results) {
                    $cur_plugin->num_searchresults = 0;
                } else if ($cur_plugin->num_searchresults >= $start_results) {
                    $end_results = ($start_results + $this->_per_page) - 1;
                    if ($end_results > $cur_plugin->num_searchresults) {
                        $end_results = $cur_plugin->num_searchresults;
                    }
                    $totalfound += ($end_results - $start_results) + 1;
                } else {
                    $start_results = 1;
                    $end_results = $cur_plugin->num_searchresults;
                    $totalfound += $cur_plugin->num_searchresults;
                }
            }
            if ($cur_plugin->num_searchresults > 0) {
                // Clear out data columns from previous result block
                $searchresults->set_var('data_cols','');
                $searchresults->set_var('start_block_results',COM_startBlock($cur_plugin->searchlabel));
                $searchresults->set_var('headings','');
                $searchresults->set_var('label', '#');
                $searchresults->parse('headings','headingcolumn',true);
                for ($j = 1; $j <= $cur_plugin->num_searchheadings; $j++) {
                    $searchresults->set_var('label', $cur_plugin->searchheading[$j]);
                    $searchresults->parse('headings','headingcolumn',true);
                }
                $searchresults->set_var('results','');
                $resultNumber = 0;
                for ($j = $start_results; $j <= $end_results; $j++) {
                    $columns = $cur_plugin->searchresults[$j - 1];
                    if ($cur_plugin->supports_paging) {
                        $searchresults->set_var('data', (($this->_per_page * $this->_page) - $this->_per_page) + $j . '.');
                    } else {
                        $searchresults->set_var('data', $j . '.');
                    }
                    $searchresults->parse('data_cols','resultcolumn',true);
                    for ($x = 1; $x <= count($columns); $x++) {
                        $searchresults->set_var('data', current($columns));
                        $searchresults->parse('data_cols','resultcolumn',true);
                        next($columns);
                    }
                    $resultNumber++;
                    $searchresults->set_var ('cssid', ($resultNumber % 2) + 1);
                    $searchresults->parse ('results', 'resultrow', true);
                    $searchresults->set_var ('data_cols', '');
                    $displayed++;
                }
                if ($cur_plugin->num_searchresults == 0) {
                    $searchresults->set_var('results',
                            '<tr><td colspan="4" align="center"><br>'
                            . $LANG09[31] . '</td></tr>');
                }
                $searchresults->set_var('end_block', COM_endBlock());
                $searchblocks .= $searchresults->parse('tmpoutput','searchblock');
            }
            next($result_plugins);
            if ($displayed > $maxdisplayed) {
                $maxdisplayed = $displayed;
            }
        }

        if ($maxdisplayed == 0) {
            $searchblocks .= '<p>' . $LANG09[13] . '</p>' . LB;
        }

        $searchmain->set_var ('search_blocks', $searchblocks);

        $searchUrl = $_CONF['site_url'] . '/search.php?mode=search';
        $queryUrl = '';
        if (!empty ($this->_query)) {
            $urlQuery = urlencode ($this->_query);
            $queryUrl .= '&amp;query=' . $urlQuery;
        }
        $queryUrl .= '&amp;keyType=' . $this->_keyType
                  . '&amp;type=' . $this->_type;
        if (!empty ($this->_dateStart)) {
            $queryUrl .= '&amp;datestart=' . $this->_dateStart;
        }
        if (!empty ($this->_dateEnd)) {
            $queryUrl .= '&amp;dateend=' . $this->_dateEnd;
        }
        if (!empty ($this->_topic)) {
            $queryUrl .= '&amp;topic=' . $this->_topic;
        }
        if (!empty ($this->_author) && ($this->_author > 0)) {
            $queryUrl .= '&amp;author=' . $this->_author;
        }
        $queryUrl .= '&amp;results=' . $this->_per_page;
        if ($this->_page > 1) {
            if ($maxdisplayed >= $this->_per_page) {
                $numpages = $this->_page + 1;
            } else {
                $numpages = $this->_page;
            }
        } else {
            if ($maxdisplayed >= $this->_per_page) {
                $numpages = 2;
            } else {
                $numpages = 1;
            }
        }
        if ($numpages > $this->_page) {
            $next = '<a href="' . $searchUrl . $queryUrl . '&amp;page='
                  . ($this->_page + 1) . '">' . $LANG09[58] . '</a>';
        } else {
            $next = $LANG09[58];
        }
        $searchUrl .= $queryUrl;
        $paging = COM_printPageNavigation ($searchUrl, $this->_page, $numpages,
                                           'page=', false, '', $next);
        $searchmain->set_var ('search_pager', $paging);
        $searchmain->set_var ('google_paging', $paging);
        $tmpTxt = sprintf ($LANG09[24], $totalfound);
        $searchmain->set_var ('lang_found', $tmpTxt);
        if (($totalfound == 0) && ($this->_page == 1)) {
            $searchmain->set_var ('refine_url', '');
            $searchmain->set_var ('start_refine_anchortag', '');
            $searchmain->set_var ('end_refine_anchortag', '');
            $searchmain->set_var ('refine_search', '');
        } else {
            $refineUrl = $_CONF['site_url'] . '/search.php?mode=refine'
                       . $queryUrl;
            $refineLink = '<a href="' . $refineUrl . '">';
            $searchmain->set_var ('refine_url', $refineUrl);
            $searchmain->set_var ('start_refine_anchortag', $refineLink);
            $searchmain->set_var ('end_refine_anchortag', '</a>');
            $searchmain->set_var ('refine_search',
                                  $refineLink . $LANG09[61] . '</a>');
        }
        $retval .= $searchmain->parse ('output', 'searchresults');

        if (($totalfound == 0) && ($this->_page == 1)) {
            $searchObj = new Search();
            $retval .=  $searchObj->showForm ();
        }

        return $retval;
    }

    /**
    * Determines if any advanced search criteria were supplied
    *
    * Geeklog allows admins to lock down the access anonymous users have
    * to the search page.  This method helps facilitate checking if an
    * anonymous user is attempting to illegally access privilege search
    * capabilities
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access private
    * @return boolean True if advanced criteria were supplied otherwise false
    *
    */
    function _hasAdvancedCriteria()
    {
        if (($this->_type != 'all') OR !empty($this->_dateStart) OR !empty($this->_dateEnd) OR
            ($this->_author > 0) OR !empty($topic)) {
            return true;
        }
        return false;
    }

    /**
    * Shows an error message to anonymous users
    *
    * This is called when anonymous users attempt to access search
    * functionality that has been locked down by the Geeklog admin.
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access private
    * @returns string HTML output for error message
    *
    */
    function _getAccessDeniedMessage()
    {
        global $_CONF, $LANG_LOGIN;

        $retval .= COM_startBlock ($LANG_LOGIN[1], '',
                           COM_getBlockTemplate ('_msg_block', 'header'));
        $login = new Template($_CONF['path_layout'] . 'submit');
        $login->set_file (array ('login'=>'submitloginrequired.thtml'));
        $login->set_var ('login_message', $LANG_LOGIN[2]);
        $login->set_var ('site_url', $_CONF['site_url']);
        $login->set_var ('lang_login', $LANG_LOGIN[3]);
        $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
        $login->parse ('output', 'login');
        $retval .= $login->finish ($login->get_var('output'));
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

        return $retval;
    }

    /**
    * Determines if user is allowed to perform a search
    *
    * Geeklog has a number of settings that may prevent
    * the access anonymous users have to the search engine.
    * This performs those checks
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access private
    * @return boolean True if search is allowed, otherwise false
    *
    */
    function _isSearchAllowed()
    {
        global $_USER, $_CONF;

        if (empty($_USER['username'])) {

            if ($this->_hasAdvancedCriteria ()) {

                if (($_CONF['loginrequired'] == 1) OR ($_CONF['searchloginrequired'] >= 1)) {
                    return false;
            }

            } else {

                if (($_CONF['loginrequired'] == 1) OR ($_CONF['searchloginrequired'] == 2)) {
                    return false;
                }

            }

        }

        return true;
    }

    /**
    * Determines if user is allowed to use the search form
    *
    * Geeklog has a number of settings that may prevent
    * the access anonymous users have to the search engine.
    * This performs those checks
    *
    * @author Dirk Haun <Dirk AT haun-online DOT de>
    * @access private
    * @return boolean True if form usage is allowed, otherwise false
    *
    */
    function _isFormAllowed ()
    {
        global $_CONF, $_USER;

        if (empty($_USER['username']) AND (($_CONF['loginrequired'] == 1) OR ($_CONF['searchloginrequired'] >= 1))) {
            return false;
        }

        return true;
    }

    /**
    * Shows search form
    *
    * Shows advanced search page
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access public
    * @return string HTML output for form
    *
    */
    function showForm ()
    {
        global $_CONF, $_TABLES, $LANG09;

        $retval = '';

        // Verify current user my use the search form
        if (!$this->_isFormAllowed()) {
            return $this->_getAccessDeniedMessage();
        }

        $retval .= COM_startBlock($LANG09[1],'advancedsearch.html');
        $searchform = new Template($_CONF['path_layout'].'search');
        $searchform->set_file (array ('searchform' => 'searchform.thtml',
                                      'authors'    => 'searchauthors.thtml'));
        $searchform->set_var('search_intro', $LANG09[19]);
        $searchform->set_var('site_url', $_CONF['site_url']);
        $searchform->set_var('lang_keywords', $LANG09[2]);
        $searchform->set_var('lang_date', $LANG09[20]);
        $searchform->set_var('lang_to', $LANG09[21]);
        $searchform->set_var('date_format', $LANG09[22]);
        $searchform->set_var('lang_topic', $LANG09[3]);
        $searchform->set_var('lang_all', $LANG09[4]);
        $searchform->set_var('topic_option_list',
                             COM_topicList ('tid,topic', $this->_topic));
        $searchform->set_var('lang_type', $LANG09[5]);
        $searchform->set_var('lang_stories', $LANG09[6]);
        $searchform->set_var('lang_comments', $LANG09[7]);
        $searchform->set_var('lang_links', $LANG09[39]);
        $searchform->set_var('lang_results', $LANG09[59]);
        $searchform->set_var('lang_per_page', $LANG09[60]);

        $searchform->set_var('lang_exact_phrase', $LANG09[43]);
        $searchform->set_var('lang_all_words', $LANG09[44]);
        $searchform->set_var('lang_any_word', $LANG09[45]);

        $searchform->set_var ('query', htmlspecialchars ($this->_query));
        $searchform->set_var ('datestart', $this->_dateStart);
        $searchform->set_var ('dateend', $this->_dateEnd);
        $searchform->set_var ($this->_per_page . '_selected',
                              'selected="selected"');

        $phrase_selected = '';
        $all_selected = '';
        $any_selected = '';
        if ($this->_keyType == 'phrase') {
            $phrase_selected = 'selected="selected"';
        } else if ($this->_keyType == 'all') {
            $all_selected = 'selected="selected"';
        } else if ($this->_keyType == 'any') {
            $any_selected = 'selected="selected"';
        }
        $searchform->set_var ('key_phrase_selected', $phrase_selected);
        $searchform->set_var ('key_all_selected', $all_selected);
        $searchform->set_var ('key_any_selected', $any_selected);

        $plugintypes = PLG_getSearchTypes();
        $pluginoptions = '';
        $plugin_selected = false;
        // Generally I don't like to hardcode HTML but this seems easiest
        for ($i = 0; $i < count ($plugintypes); $i++) {
            $pluginoptions .= '<option value="' . key ($plugintypes) . '"';
            if ($this->_type == key ($plugintypes)) {
                $pluginoptions .= ' selected="selected"';
                $plugin_selected = true;
            }
            $pluginoptions .= '>' . current ($plugintypes) . '</option>' . LB;
            next($plugintypes);
        }
        $searchform->set_var('plugin_types', $pluginoptions);

        $all_selected = '';
        $stories_selected = '';
        $comments_selected = '';
        if (!$plugin_selected) {
            if ($this->_type == 'stories') {
                $stories_selected = 'selected="selected"';
            } else if ($this->_type == 'comments') {
                $comments_selected = 'selected="selected"';
            } else {
                $all_selected = 'selected="selected"';
            }
        }
        $searchform->set_var ('type_all_selected', $all_selected);
        $searchform->set_var ('stories_selected', $stories_selected);
        $searchform->set_var ('comments_selected', $comments_selected);

        if ($_CONF['contributedbyline'] == 1) {
            $searchform->set_var('lang_authors', $LANG09[8]);
            $searchusers = array();
            $result = DB_query("SELECT DISTINCT uid FROM {$_TABLES['comments']}");
            while ($A = DB_fetchArray($result)) {
                $searchusers[$A['uid']] = $A['uid'];
            }
            $result = DB_query("SELECT DISTINCT uid FROM {$_TABLES['stories']} WHERE (date <= NOW()) AND (draft_flag = 0)");
            while ($A = DB_fetchArray($result)) {
                $searchusers[$A['uid']] = $A['uid'];
            }

            $inlist = implode(',', $searchusers);

            if (!empty ($inlist)) {
                $sql = "SELECT uid,username,fullname FROM {$_TABLES['users']} WHERE uid IN ($inlist)";
                if (isset ($_CONF['show_fullname']) &&
                        ($_CONF['show_fullname'] == 1)) {
                    /* Caveat: This will group all users with an emtpy fullname
                     *         together, so it's not exactly sorted by their
                     *         full name ...
                     */
                    $sql .= ' ORDER BY fullname,username';
                } else {
                    $sql .= ' ORDER BY username';
                }
                $result = DB_query ($sql);
                $useroptions = '';
                while ($A = DB_fetchArray($result)) {
                    $useroptions .= '<option value="' . $A['uid'] . '"';
                    if ($A['uid'] == $this->_author) {
                        $useroptions .= ' selected="selected"';
                    }
                    $useroptions .= '>' . $this->_displayName ($A['username'],
                                            $A['fullname']) . '</option>';
                }
                $searchform->set_var('author_option_list', $useroptions);
                $searchform->parse('author_form_element', 'authors', true);
            } else {
                $searchform->set_var('author_form_element', '<input type="hidden" name="author" value="0">');
            }
        } else {
            $searchform->set_var ('author_form_element',
                    '<input type="hidden" name="author" value="0">');
        }
        $searchform->set_var('lang_search', $LANG09[10]);
        $searchform->parse('output', 'searchform');

        $retval .= $searchform->finish($searchform->get_var('output'));
        $retval .= COM_endBlock();

        return $retval;
    }

    /**
    * Kicks off the appropriate search(es)
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access public
    *
    */
    function doSearch()
    {
        global $_CONF;

        // Verify current user can perform requested search
        if (!$this->_isSearchAllowed()) {
            return $this->_getAccessDeniedMessage();
        }

        // Start search timer
        $searchtimer = new timerobject();
        $searchtimer->setPercision(4);
        $searchtimer->startTimer();

        // Do searches
        $this->story_results = $this->_searchStories();
        $this->comment_results = $this->_searchComments();

        // Have plugins do their searches
        list($nrows_plugins, $total_plugins, $result_plugins) = PLG_doSearch($this->_query, $this->_dateStart, $this->_dateEnd, $this->_topic, $this->_type, $this->_author, $this->_keyType, $this->_page, $this->_per_page);

        // Add the core GL object search results to plugin results
        $nrows_plugins += $this->story_results->num_searchresults;
        $nrows_plugins += $this->comment_results->num_searchresults;
        $total_plugins += $this->story_results->num_itemssearched;
        $total_plugins += $this->comment_results->num_itemssearched;

        // Move GL core objects to front of array
        array_unshift ($result_plugins, $this->story_results,
                       $this->comment_results);

        // Searches are done, stop timer
        $searchtime = $searchtimer->stopTimer();

        // Format results
        $retval = $this->_formatResults ($nrows_plugins, $total_plugins,
                                         $result_plugins, $searchtime);

        return $retval;
    }

}

?>
