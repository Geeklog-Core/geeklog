<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | search.php                                                                |
// |                                                                           |
// | Geeklog search class.                                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
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
// $Id: search.class.php,v 1.36 2005/07/24 08:22:49 dhaun Exp $

if (eregi ('search.class.php', $_SERVER['PHP_SELF'])) {
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
    var $_per_page = $_CONF['num_search_results'];

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
        // Set search criteria
        $this->_query = strip_tags (COM_stripslashes ($_REQUEST['query']));
        $this->_topic = COM_applyFilter ($_REQUEST['topic']);
        $this->_dateStart = COM_applyFilter ($_REQUEST['datestart']);
        $this->_dateEnd = COM_applyFilter ($_REQUEST['dateend']);
        $this->_author = COM_applyFilter ($_REQUEST['author']);
        $this->_type = COM_applyFilter ($_REQUEST['type']);
        if (empty ($this->_type)) {
            $this->_type = 'all';
        }
        $this->_keyType = COM_applyFilter ($_REQUEST['keyType']);
        $this->_page = COM_applyFilter ($_REQUEST['page']);
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
        global $LANG09, $_CONF, $_TABLES, $_USER, $_GROUPS;

        $urlQuery = urlencode($this->_query);

        $resultPage = 1;

        if ($this->_page > 1) {
            $resultPage = $this->_page;
        }

        if ($this->_type == 'all' OR $this->_type == 'stories') {
            $sql = "SELECT u.username,u.fullname,s.uid,sid,title,introtext,bodytext,hits,UNIX_TIMESTAMP(date) AS day,'story' AS type FROM {$_TABLES['stories']} AS s,{$_TABLES['users']} AS u WHERE (draft_flag = 0) AND (date <= NOW()) AND (u.uid = s.uid) ";
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
                $DS = explode($delim, $this->_dateStart);
                $DE = explode($delim, $this->_dateEnd);
                $startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
                $enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
                $sql .= "AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate') ";
            }
            if (!empty($this->_topic)) {
                $sql .= "AND (tid = '$this->_topic') ";
            }
            if (!empty($this->_author) && ($this->_author > 0)) {
                $sql .= "AND (s.uid = '$this->_author') ";
            }
            $permsql = COM_getPermSQL ('AND') . COM_getTopicSQL ('AND');
            $sql .= $permsql;
            $sql .= "ORDER BY date desc";

            $result_stories = DB_query($sql);
            $nrows_stories = DB_numRows($result_stories);
            $result_count = DB_query("SELECT COUNT(*) FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW())" . $permsql);
            $B = DB_fetchArray($result_count, true);
            $story_results = new Plugin();
            $story_results->searchlabel = $LANG09[53];
            $story_results->addSearchHeading($LANG09[16]);
            $story_results->addSearchHeading($LANG09[17]);
            $story_results->addSearchHeading($LANG09[18]);
            $story_results->addSearchHeading($LANG09[23]);
            $story_results->num_searchresults = 0;
            $story_results->num_itemssearched = $B[0];
    
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
                              $thetime[0], $profile, COM_NumberFormat($A['hits']) );
                $story_results->addSearchResult ($row);
                $story_results->num_searchresults++;
            }
        } else {
            $story_results = new Plugin();
            $story_results->searchlabel = $LANG09[37];
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
            $sql = " FROM {$_TABLES['comments']},{$_TABLES['users']} ";
            $sql .= "LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid)" . $stsql . ") ";
            $sql .= "WHERE ";
            $sql .= " {$_TABLES['users']}.uid = {$_TABLES['comments']}.uid AND ";
            $sql .= "({$_TABLES['stories']}.draft_flag = 0) AND ({$_TABLES['stories']}.date <= NOW()) AND ";
            $sql .= " (comment like '%$mysearchterm%' ";
            $sql .= "OR {$_TABLES['comments']}.title like '%$mysearchterm%') ";
            if (!empty($this->_dateStart) && !empty($this->_dateEnd)) {
                $delim = substr($this->_dateStart, 4, 1);
                $DS = explode($delim, $this->_dateStart);
                $DE = explode($delim, $this->_dateEnd);
                $startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
                $enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
                $sql .= "AND (UNIX_TIMESTAMP({$_TABLES['comments']}.date) BETWEEN '$startdate' AND '$enddate') ";
            }
            if (!empty($this->_author)) {
                $sql .= "AND ({$_TABLES['comments']}.uid = '$this->_author') ";
            }
            $sql .= "AND (" .  $stwhere . ") ";
            $order = "ORDER BY {$_TABLES['comments']}.date DESC ";
            $l = ($this->_per_page * $this->_page) - $this->_per_page;
            $limit = 'LIMIT ' . $l . ',' . $this->_per_page;

            $result_comments = DB_query ($select . $sql . $order . $limit);

            $result_count = DB_query ("SELECT COUNT(*)" . $sql);
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

            // NOTE if any of your data items need to be links then add them here! 
            // make sure data elements are in an array and in the same order as
            // your headings above!
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
    
    /**
    * Performs search on all events
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access private
    *
    */
    function _searchEvents()
    {
        global $_CONF, $_TABLES, $LANG09, $LANG12;

        if (($this->_type == 'events') OR
            (($this->_type == 'all') AND empty($this->_author))) {
            $sql = "SELECT eid,title,description,location,datestart,dateend,timestart,timeend,UNIX_TIMESTAMP(datestart) AS day FROM {$_TABLES['events']} WHERE ";

            if($this->_keyType == 'phrase') {
                // do an exact phrase search (default)
                $mywords[] = $this->_query;
                $mysearchterm = addslashes ($this->_query);
                $sql .= "(location LIKE '%$mysearchterm%'  ";
                $sql .= "OR description LIKE '%$mysearchterm%' ";
                $sql .= "OR title LIKE '%$mysearchterm%') ";
            } 
            elseif($this->_keyType == 'all') {
                //must contain ALL of the keywords
                $mywords = explode(' ', $this->_query);
                $tmp = '';
                foreach ($mywords AS $mysearchterm) {
                    $mysearchterm = addslashes (trim ($mysearchterm));
                    $tmp .= "(location LIKE '%$mysearchterm%' OR ";
                    $tmp .= "description LIKE '%$mysearchterm%' OR ";
                    $tmp .= "title LIKE '%$mysearchterm%') AND ";
                }
                $tmp = substr($tmp, 0, strlen($tmp) - 4);
                $sql .= $tmp;
            } elseif($this->_keyType == 'any') {
                //must contain ANY of the keywords
                $mywords = explode(' ', $this->_query);
                $tmp = '';
                foreach ($mywords AS $mysearchterm) {
                    $mysearchterm = addslashes (trim ($mysearchterm));
                    $tmp .= "(location LIKE '%$mysearchterm%' OR ";
                    $tmp .= "description LIKE '%$mysearchterm%' OR ";
                    $tmp .= "title LIKE '%$mysearchterm%') OR ";
                }
                $tmp = substr($tmp, 0, strlen($tmp) - 3);
                $sql .= "($tmp)";
            }
            else
            {
                $mywords[] = $this->_query;
                $mysearchterm = addslashes ($this->_query);
                $sql .= "(location LIKE '%$mysearchterm%' ";
                $sql .= "OR description LIKE '%$mysearchterm%' ";
                $sql .= "OR title LIKE '%$mysearchterm%') ";
            }

            if (!empty($this->_dateStart) AND !empty($this->_dateEnd)) {
                $delim = substr($this->_dateStart, 4, 1);
                $DS = explode($delim, $this->_dateStart);
                $DE = explode($delim, $this->_dateEnd);
                $startdate = mktime(0, 0, 0, $DS[1], $DS[2], $DS[0]);
                $enddate = mktime(23, 59, 59, $DE[1], $DE[2], $DE[0]);
                $sql .= "AND (UNIX_TIMESTAMP(datestart) BETWEEN '$startdate' AND '$enddate') ";
            }
            $sql .= COM_getPermSQL ('AND');
            $sql .= "ORDER BY datestart desc";
            $result_events = DB_query($sql);
            $nrows_events = DB_numRows($result_events);
            $event_results = new Plugin();
            $event_results->searchresults = array();
            $event_results->searchlabel = $LANG09[37];
            $event_results->addSearchHeading($LANG09[16]);
            $event_results->addSearchHeading($LANG09[49]);
            $event_results->addSearchHeading($LANG09[34]);
            $event_results->addSearchHeading($LANG12[15]);
            $event_results->num_searchresults = 0;
            $event_results->num_itemssearched = DB_count($_TABLES['events']);
    
            // NOTE if any of your data items need to be links then add them here! 
            // make sure data elements are in an array and in the same order as your
            // headings above!
            while ($A = DB_fetchArray($result_events)) {
                if ($A['allday'] == 0) {
                    $fulldate = $A['datestart'] . ' ' . $A['timestart'] . ' - '
                              . $A['dateend'] . ' ' . $A['timeend'];
                } else {
                    if ($A['datestart'] <> $A['dateend']) {
                        $fulldate = $A['datestart'] . ' - ' . $A['dateend']
                                  . ' ' . $LANG09[35];
                    } else {
                        $fulldate = $A['datestart'] . ' ' . $LANG09[35];
                    }
                }
                $thetime = COM_getUserDateTimeFormat ($A['day']);
                $A['title'] = str_replace ('$', '&#36;', $A['title']);
                $row = array ('<a href="' . $_CONF['site_url']
                              . '/calendar_event.php?eid=' . $A['eid'] . '">'
                              . $A['title'] . '</a>',
                              $fulldate, $A['location'], $A['description']);
                $event_results->addSearchResult($row);
                $event_results->num_searchresults++;
            }
        } else {
            $event_results = new Plugin();
            $event_results->searchlabel = $LANG09[37];
            $event_results->num_itemssearched = 0;
        }
        return $event_results;
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

        $searchmain = new Template($_CONF['path_layout'] . 'search');
        $searchmain->set_file(array('searchresults'=>'searchresults.thtml'));
        $tmpTxt = sprintf($LANG09[24], $nrows_plugins);
        $searchmain->set_var('lang_found', $tmpTxt);
        $searchmain->set_var('num_matches', '');

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
        $searchmain->set_var('num_items_searched', $total);
        $searchmain->set_var('lang_itemsin', $LANG09[26]);
        $searchmain->set_var('search_time', $searchtime);
        $searchmain->set_var('lang_seconds', $LANG09[27]);

        // Print plugins search results
        reset($result_plugins);
        $cur_plugin = new Plugin();
        $searchresults = new Template($_CONF['path_layout'] . 'search');

        $maxdisplayed = 0;
        for ($i = 1; $i <= count($result_plugins); $i++) {
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
                $searchresults->set_var('data_cols','');
                $searchresults->set_var('headings','');
            }
            $cur_plugin = current($result_plugins);
            $start_results = (($this->_per_page * $this->_page) - $this->_per_page) + 1;
            if ($cur_plugin->supports_paging) {
                $start_results = 1;
                $end_results = $cur_plugin->num_searchresults;
            } else {
                // this plugin doesn't know about paging - fake it
                if ($cur_plugin->num_searchresults < $start_results) {
                    $cur_plugin->num_searchresults = 0;
                } else if ($cur_plugin->num_searchresults >= $start_results) {
                    $end_results = ($start_results + $this->_per_page) - 1;
                    if ($end_results > $cur_plugin->num_searchresults) {
                        $end_results = $cur_plugin->num_searchresults;
                    }
                } else {
                    $start_results = 1;
                    $end_results = $cur_plugin->num_searchresults;
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
                    $searchresults->parse('results','resultrow',true);
                    $searchresults->set_var('data_cols','');
                    $resultNumber++;
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

        $searchmain->set_var('search_blocks', $searchblocks);

        $urlQuery = urlencode ($this->_query);
        $baseurl = $_CONF['site_url'] . '/search.php?query=' . $urlQuery . '&amp;keyType=' . $this->_keyType . '&amp;type=' . $this->_type . '&amp;topic=' . $this->_topic . '&amp;mode=search';
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
            $next = '<a href="' . $baseurl . '&amp;page=' . ($this->_page + 1)
                  . '">' . $LANG09[58] . '</a>';
        } else {
            $next = $LANG09[58];
        }
        $searchmain->set_var ('search_pager',
                COM_printPageNavigation ($baseurl, $this->_page, $numpages,
                                         'page=', false, '', $next));
        $retval .= $searchmain->parse('output','searchresults');

        reset($result_plugins);
        $totalfound = 0;
        foreach ($result_plugins as $key) {
            $totalfound += $key->num_searchresults;
        }
        if ($totalfound == 0) {
            $searchObj = new Search();
            $retval .=  $searchObj->showForm();
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
    function showForm()
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
        $searchform->set_var('topic_option_list', COM_topicList('tid,topic'));
        $searchform->set_var('lang_type', $LANG09[5]);
        $searchform->set_var('lang_stories', $LANG09[6]);
        $searchform->set_var('lang_comments', $LANG09[7]);
        $searchform->set_var('lang_links', $LANG09[39]);
        $searchform->set_var('lang_events', $LANG09[40]);
        
        $searchform->set_var('lang_exact_phrase', $LANG09[43]);
        $searchform->set_var('lang_all_words', $LANG09[44]);
        $searchform->set_var('lang_any_word', $LANG09[45]);
        
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
                    $useroptions .= '<option value="' . $A['uid'] . '">'
                        . $this->_displayName ($A['username'], $A['fullname'])
                        . '</option>';
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

    /**
    * Kicks off the appropriate search(es)
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access public
    *
    */
    function doSearch()
    {
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
        $this->event_results = $this->_searchEvents();

        // Have plugins do their searches
        list($nrows_plugins, $total_plugins, $result_plugins) = PLG_doSearch($this->_query, $this->_dateStart, $this->_dateEnd, $this->_topic, $this->_type, $this->_author, $this->_keyType);

        // Add the core GL object search results to plugin results
        $nrows_plugins = $nrows_plugins + $this->story_results->num_searchresults;
        $nrows_plugins = $nrows_plugins + $this->comment_results->num_searchresults;
        $nrows_plugins = $nrows_plugins + $this->event_results->num_searchresults;

        $total_plugins = $total_plugins + $this->story_results->num_itemssearched;
        $total_plugins = $total_plugins + $this->comment_results->num_itemssearched;
        $total_plugins = $total_plugins + $this->event_results->num_itemssearched;

        // Move GL core objects to front of array
        array_unshift($result_plugins, $this->story_results, $this->comment_results, $this->event_results);

        // Searches are done, stop timer
        $searchtime = $searchtimer->stopTimer();

        // Format results
        $retval = $this->_formatResults($nrows_plugins, $total_plugins, $result_plugins, $searchtime);

        return $retval;
    }

}

?>
