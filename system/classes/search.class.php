<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | search.php                                                                |
// | Geeklog search class.                                                     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
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
// $Id: search.class.php,v 1.12 2003/08/02 22:07:42 blaine Exp $

require_once($_CONF['path_system'] . 'classes/plugin.class.php');

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
    var $_page = null;
    
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
        global $HTTP_POST_VARS, $HTTP_GET_VARS;
        
        // This page is register_globals friendly.  Because I
        // can't gaurantee a version of PHP > 4.1 I can't simply
        // reference $_REQUEST so $input_vars simulates this.
        $input_vars = array();
        if (count($HTTP_POST_VARS) == 0) {
            $input_vars = $HTTP_GET_VARS;
        } else {
            $input_vars = $HTTP_POST_VARS;
        }
        
        // Set search criteria
        $this->_query = strip_tags($input_vars['query']);
        $this->_topic = $input_vars['topic'];
        $this->_dateStart = $input_vars['datestart'];
        $this->_dateEnd = $input_vars['dateend'];
        $this->_author = $input_vars['author'];
        if (empty($input_vars['type'])) {
            $this->_type = 'all';
        } else {
            $this->_type = $input_vars['type'];
        }
        $this->_keyType = $input_vars['keyType'];
        $this->_page = $input_vars['page'];
        
        // In case we got a username instead of uid, converit.  This should
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
        
        if (is_numeric($this->_author)) {
            return;
        }
        
        $this->_author = DB_getItem($_TABLES['users'],'uid',"username='" . $this->_author . "'");
    }

    /**
    * Create SQL to check the topic permissions of the current user.
    *
    * @author Dirk Haun <dirk AT haun-online DOT de>
    * @access private
    *
    */
    function _checkTopicPermissions ()
    {
        global $_TABLES;

        $topicsql = '';

        $tresult = DB_query ("SELECT tid FROM {$_TABLES['topics']}"
                             . COM_getPermSQL ());
        $trows = DB_numRows ($tresult);
        if ($trows > 0) {
            $tids = array ();
            for ($i = 0; $i < $trows; $i++) {
                $T = DB_fetchArray ($tresult);
                $tids[] = $T['tid'];
            }
            if (sizeof ($tids) > 0) {
                $topicsql = "AND (tid IN ('" . implode ("','", $tids) . "')) ";
            }
        }

        return $topicsql;
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
    
        if ($_CONF['max_search_results'] > 0) {
            $resultLimit = $_CONF['max_search_results'];
        }
                
        $resultPage = 1;
        
        if($this->_page > 1) {
            $resultPage = $this->_page;
        }
        
        $groupList = '';
        if (!empty ($_USER['uid'])) {
            foreach ($_GROUPS AS $grp) {
                $groupList .= $grp . ',';
            }
            $groupList = substr($groupList, 0, -1);
        }
    
        if ($this->_type == 'all' OR $this->_type == 'stories') {
            $sql = "SELECT sid,title,introtext,bodytext,hits,uid,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon,UNIX_TIMESTAMP(date) as day,'story' as type FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW()) " . $this->_checkTopicPermissions ();
            if (!empty ($this->_query)) {
                if($this->_keyType == 'phrase') {
                    // do an exact phrase search (default)
                    $mywords[] = $this->_query;
                    $sql .= "AND (introtext like '%$this->_query%'  ";
                    $sql .= "OR bodytext like '%$this->_query%' ";
                    $sql .= "OR title like '%$this->_query%')  ";
                } elseif($this->_keyType == 'all') {
                    //must contain ALL of the keywords
                    $mywords = explode(' ', $this->_query);
                    $sql .= 'AND ';
                    $tmp = '';
                    foreach ($mywords AS $mysearchterm) {
                        $tmp .= "(introtext like '%" . trim($mysearchterm) . "%' OR ";
                        $tmp .= "bodytext like '%" . trim($mysearchterm) . "%' OR ";
                        $tmp .= "title like '%" . trim($mysearchterm) . "%') AND ";
                    }
                    $tmp = substr($tmp, 0, strlen($tmp) - 4);
                    $sql .= $tmp;
                }
                elseif($this->_keyType == 'any') {
                    //must contain ANY of the keywords
                    $mywords = explode(' ', $this->_query);
                    $sql .= 'AND ';
                    $tmp = '';
                    foreach ($mywords AS $mysearchterm) {
                        $tmp .= "(introtext like '%" . trim($mysearchterm) . "%' OR ";
                        $tmp .= "bodytext like '%" . trim($mysearchterm) . "%' OR ";
                        $tmp .= "title like '%" . trim($mysearchterm) . "%') OR ";
                    }
                    $tmp = substr($tmp, 0, strlen($tmp) - 3);
                    $sql .= "($tmp)";
                } else {
                    $mywords[] = $this->_query;
                    $sql .= "AND (introtext like '%$this->_query%'  ";
                    $sql .= "OR bodytext like '%$this->_query%' ";
                    $sql .= "OR title like '%$this->_query%')  ";
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
            if (!empty($this->_author)) {
                $sql .= "AND (uid = '$this->_author') ";
            }
            $permsql = COM_getPermSQL ('AND');
            $sql .= $permsql;
            $sql .= "ORDER BY date desc";
    
            $result_stories = DB_query($sql);
            $nrows_stories = DB_numRows($result_stories);
            $result_count = DB_query("SELECT count(*) FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW())" . $permsql);
            $B = DB_fetchArray($result_count);
            $story_results = new Plugin();
            $story_results->searchlabel = $LANG09[53];
            $story_results->addSearchHeading($LANG09[16]);
            $story_results->addSearchHeading($LANG09[17]);
            $story_results->addSearchHeading($LANG09[18]);
            $story_results->addSearchHeading($LANG09[23]);
            $story_results->num_searchresults = 0;
            $story_results->num_itemssearched = $B[0];
    
            // NOTE if any of your data items need to be links then add them here! 
            // make sure data elements are in an array and in the same order as your
            // headings above!
            while ($A = DB_fetchArray($result_stories)) {
                if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
                    // get rows    
                    $A['title'] = str_replace('$','&#36;',$A['title']);
                    $thetime = COM_getUserDateTimeFormat($A['day']);
                    $articleUrl = 'article.php?story=' . $A['sid'];
                    if (!empty ($urlQuery)) {
                        $articleUrl .= '&amp;query=' . $urlQuery;
                    }
                    $row = array('<a href="' . $articleUrl . '">' . stripslashes($A['title']) . '</a>',$thetime[0], DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'"), $A['hits']);
                    $story_results->addSearchResult($row);
                    $story_results->num_searchresults++;
                } else {
                    // user is not allowed to see this item so don't count it either
                    $story_results->num_itemssearched--;
                }
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
        global $LANG09, $_CONF, $_TABLES, $_USER, $_GROUPS;

        if ($this->_type == 'all' OR $this->_type == 'comments') {

            $stsql = COM_getPermSQL ('AND', 0, 2, $_TABLES['stories']);
            $stsql .= $this->_checkTopicPermissions ();

            $stwhere = '';

            $groupList = '';
            if (!empty ($_USER['uid'])) {
                foreach ($_GROUPS as $grp) {
                    $groupList .= $grp . ',';
                }
                $groupList = substr($groupList, 0, -1);
            }
            if (!empty ($_USER['uid'])) {
                $stwhere .= "({$_TABLES['stories']}.owner_id IS NOT NULL AND {$_TABLES['stories']}.perm_owner IS NOT NULL) OR ";
                $stwhere .= "({$_TABLES['stories']}.group_id IS NOT NULL AND {$_TABLES['stories']}.perm_group IS NOT NULL) OR ";
                $stwhere .= "({$_TABLES['stories']}.perm_members IS NOT NULL) OR ";
            }
            $stwhere .= "({$_TABLES['stories']}.perm_anon IS NOT NULL)";
    
            $posql = COM_getPermSQL ('AND', 0, 2, $_TABLES['pollquestions']);
            $powhere = '';
            if (!empty ($_USER['uid'])) {
                $powhere .= "({$_TABLES['pollquestions']}.owner_id IS NOT NULL AND {$_TABLES['pollquestions']}.perm_owner IS NOT NULL) OR ";
                $powhere .= "({$_TABLES['pollquestions']}.group_id IS NOT NULL AND {$_TABLES['pollquestions']}.perm_group IS NOT NULL) OR ";
                $powhere .= "({$_TABLES['pollquestions']}.perm_members IS NOT NULL) OR ";
            }
            $powhere .= "({$_TABLES['pollquestions']}.perm_anon IS NOT NULL)";
    
            $sql = "SELECT {$_TABLES['stories']}.sid,{$_TABLES['comments']}.title,comment,pid,{$_TABLES['comments']}.uid,type as comment_type,UNIX_TIMESTAMP({$_TABLES['comments']}.date) as day,'comment' as type FROM {$_TABLES['comments']} ";
            $sql .= "LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid)" . $stsql . ") ";
            $sql .= "LEFT JOIN {$_TABLES['pollquestions']} ON ((qid = {$_TABLES['comments']}.sid)" . $posql . ") ";
            $sql .= "WHERE ";
            $sql .= " (comment like '%$this->_query%' ";
            $sql .= "OR {$_TABLES['comments']}.title like '%$this->_query%') ";
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
            $sql .= "AND ((" .  $stwhere . ") OR (" . $powhere . ")) ";
            $sql .= "ORDER BY {$_TABLES['comments']}.date DESC";
            $result_comments = DB_query($sql);
            $sql = "SELECT count(*) FROM {$_TABLES['comments']} LEFT JOIN {$_TABLES['stories']} ON (({$_TABLES['stories']}.sid = {$_TABLES['comments']}.sid)" . $stsql . ") LEFT JOIN {$_TABLES['pollquestions']} ON ((qid = {$_TABLES['comments']}.sid)" . $posql . ") WHERE ((" .  $stwhere . ") OR (" . $powhere . "))";
            $result_count = DB_query($sql);
            $B = DB_fetchArray ($result_count);
            $comment_results = new Plugin();
            $comment_results->searchlabel = $LANG09[54];
            $comment_results->addSearchHeading($LANG09[16]);
            $comment_results->addSearchHeading($LANG09[17]);
            $comment_results->addSearchHeading($LANG09[18]);
            $comment_results->num_searchresults = 0;
            $comment_results->num_itemssearched = $B[0];
    
            // NOTE if any of your data items need to be links then add them here! 
            // make sure data elements are in an array and in the same order as your
            // headings above!
            while ($A = DB_fetchArray($result_comments)) {
                $A['title'] = str_replace('$','&#36;',$A['title']);
                if ($A['comment_type'] == 'article') {
                    $A['title'] = '<a href="article.php?story=' . $A['sid'] . '#comments">' . stripslashes($A['title']) . '</a>';
                } else {
                    $A['title'] = '<a href="pollbooth.php?qid=' . $A['sid'] . '&amp;aid=-1#comments">' . stripslashes($A['title']) . '</a>';
                }
                
                $thetime = COM_getUserDateTimeFormat($A['day']);
                $row = array($A['title'], $thetime[0],DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'"));
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
    * Performs search on all links
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access private
    * @return object Plugin object
    *
    */
    function _searchLinks()
    {
        global $LANG09, $_CONF, $_TABLES;

        // Build SQL
        if (($this->_type == 'links') OR ($this->_type == 'all')) {
            $sql = "SELECT lid,title,description,url,hits,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']} WHERE ";
    
            if ($this->_keyType == 'phrase') {
                // do an exact phrase search (default)
                $mywords[] = $this->_query;
                $sql .= "(description like '%$this->_query%' ";
                $sql .= "OR title like '%$this->_query%')  ";
            } else if ($this->_keyType == 'all')  { 
                //must contain ALL of the keywords
                $mywords = explode(' ' ,$this->_query);
                $tmp = '';
                foreach ($mywords AS $mysearchterm) {
                    $tmp .= "(description like '%" . trim($mysearchterm) . "%' OR ";
                    $tmp .= "title like '%" . trim($mysearchterm) . "%') AND ";
                }
                $tmp = substr($tmp, 0, strlen($tmp) - 4);
                $sql .= $tmp;
            } elseif($this->_keyType == 'any') {
                // need to do WORD searches
                $mywords = explode(' ' ,$query);
                $tmp = '';
                foreach ($mywords AS $mysearchterm) {
                    $tmp .= "(description like '%" . trim($mysearchterm) . "%' OR ";
                    $tmp .= "title like '%" . trim($mysearchterm) . "%') OR ";
                }
                $tmp = substr($tmp,0,strlen($tmp)-3);
                $sql .= "($tmp)";
            } else {
                $mywords[] = $this->_query;
                $sql .= "(description like '%$this->_query%' ";
                $sql .= "OR title like '%$this->_query%')  ";
            }
    
            if (!empty($this->_dateStart) AND !empty($this->_dateEnd)) {
                $delim = substr($this->_dateStart, 4, 1);
                $DS = explode($delim, $$this->_dateStart);
                $DE = explode($delim, $$this->_dateEnd);
                $startdate = mktime(0, 0, 0, $DS[1], $DS[2], $DS[0]);
                $enddate = mktime(23, 59, 59, $DE[1], $DE[2], $DE[0]);
                $sql .= "AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate') ";
            }
            $sql .= "ORDER BY title ASC";
            $result_links = DB_query($sql);
            $nrows_links = DB_numRows($result_links);
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
            while ($A = DB_fetchArray($result_links)) {
                if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
                    $thetime = COM_getUserDateTimeFormat($A['day']);
                    $row = array($A['title'], '<a href="' . $_CONF['site_url']
                            . '/portal.php?what=link&amp;item=' . $A['lid'] . '">'
                            . $A['url'] . '</a>', $A['hits']);
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
            $link_results->num_itemssearched = 0;
        }

        return $link_results;
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
        global $LANG09, $_CONF, $_TABLES;
    
        if (($this->_type == 'events') OR
            (($this->_type == 'all') AND empty($this->_author))) {
            $sql = "SELECT eid,title,description,location,datestart,dateend,timestart,timeend,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon,UNIX_TIMESTAMP(datestart) as day FROM {$_TABLES['events']} WHERE ";
    
            if($this->_keyType == 'phrase') {
                // do an exact phrase search (default)
                $mywords[] = $this->_query;
                $sql .= "(location like '%$this->_query%'  ";
                $sql .= "OR description like '%$this->_query%' ";
                $sql .= "OR title like '%$this->_query%')  ";
            } 
            elseif($this->_keyType == 'all') {
                //must contain ALL of the keywords
                $mywords = explode(' ', $this->_query);
                $tmp = '';
                foreach ($mywords AS $mysearchterm) {
                    $tmp .= "(location like '%" . trim($mysearchterm) . "%' OR ";
                    $tmp .= "description like '%" . trim($mysearchterm) . "%' OR ";
                    $tmp .= "title like '%" . trim($mysearchterm) . "%') AND ";
                }
                $tmp = substr($tmp, 0, strlen($tmp) - 4);
                $sql .= $tmp;
            } elseif($this->_keyType == 'any') {
                //must contain ANY of the keywords
                $mywords = explode(' ', $this->_query);
                $tmp = '';
                foreach ($mywords AS $mysearchterm) {
                    $tmp .= "(location like '%" . trim($mysearchterm) . "%' OR ";
                    $tmp .= "description like '%" . trim($mysearchterm) . "%' OR ";
                    $tmp .= "title like '%" . trim($mysearchterm) . "%') OR ";
                }
                $tmp = substr($tmp, 0, strlen($tmp) - 3);
                $sql .= "($tmp)";
            }
            else
            {
                $mywords[] = $this->_query;
                $sql .= "(location like '%$this->_query%'  ";
                $sql .= "OR description like '%$this->_query%' ";
                $sql .= "OR title like '%$this->_query%')  ";
            }
     
            if (!empty($this->_dateStart) AND !empty($this->_dateEnd)) {
                $delim = substr($this->_dateStart, 4, 1);
                $DS = explode($delim, $this->_dateStart);
                $DE = explode($delim, $this->_dateEnd);
                $startdate = mktime(0, 0, 0, $DS[1], $DS[2], $DS[0]);
                $enddate = mktime(23, 59, 59, $DE[1], $DE[2], $DE[0]);
                $sql .= "AND (UNIX_TIMESTAMP(datestart) BETWEEN '$startdate' AND '$enddate') ";
            }
            $sql .= "ORDER BY datestart desc";
            $result_events = DB_query($sql);
            $nrows_events = DB_numRows($result_events);
            $event_results = new Plugin();
            $event_results->searchresults = array();
            $event_results->searchlabel = $LANG09[37];
            if (!$_CONF['expanded_search_results']) 
            {
                $event_results->addSearchHeading($LANG09[16]);
                $event_results->addSearchHeading($LANG09[37]);
                $event_results->addSearchHeading($LANG09[34]);
            }
            $event_results->num_searchresults = 0;
            $event_results->num_itemssearched = DB_count($_TABLES['events']);
    
            // NOTE if any of your data items need to be links then add them here! 
            // make sure data elements are in an array and in the same order as your
            // headings above!
            while ($A = DB_fetchArray($result_events)) {
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
                                $A['location'],$A['description']);
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
                $previous = $resultPage-1;
                $pager .= " <a href = {$_CONF['site_url']}/search.php?query=$urlQuery&keyType=$this->_keyType&page=$previous&type=$this->_type&topic=$this->_topic&mode=search$extra>{$LANG09[47]}</a> ";
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
        global $_CONF, $LANG09, $_USER;
        
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
                
        for ($i = 1; $i <= count($result_plugins); $i++) {
            $searchresults->set_file(array('searchheading'=>'searchresults_heading.thtml',
                                            'searchrows'=>'searchresults_rows.thtml',
                                            'searchblock' => 'searchblock.thtml',
                                            'headingcolumn'=>'headingcolumn.thtml',
                                            'resultrow'=>'resultrow.thtml',
                                            'resulttitle'=>'resultcolumn.thtml',
                                            'resultcolumn'=>'resultcolumn.thtml'));
            if ($i == 1) {
                $searchresults->set_var('data_cols','');
                $searchresults->set_var('headings','');
            }
            $cur_plugin = current($result_plugins);
            if (($cur_plugin->num_searchresults > 0) OR $_CONF['showemptysearchresults']) {
                // Clear out data columns from previous result block
                $searchresults->set_var('data_cols','');
                $searchresults->set_var('start_block_results',COM_startBlock($cur_plugin->searchlabel));
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
                    $resultNumber++;
                }
                if ($cur_plugin->num_searchresults == 0) {
                    $searchresults->set_var('results',
                                '<tr><td colspan="4" align="center"><br>' . $LANG09[31]
                                . '</td></tr>');
                }
                $searchresults->set_var('end_block', COM_endBlock());
                $searchblocks .= $searchresults->parse('tmpoutput','searchblock');
            }
            next($result_plugins);
        }
        $searchmain->set_var('search_blocks', $searchblocks);
        $searchmain->set_var('search_pager', $this->_showPager($resultPage, $pages, ''));
        $retval .= $searchmain->parse('output','searchresults');

        reset($result_plugins);
        $totalfound = 0;
        foreach ($result_plugins as $key) {
            $totalfound .= $key->num_searchresults;
        }
        if ( $totalfound == 0) {
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
        global $_USER, $_CONF;

        if (empty($_USER['username']) AND (($_CONF['loginrequired'] == 1) OR ($_CONF['searchloginrequired'] >= 1))) {
            return false;
        }

        return true;
    }

    function _getSummary($query,$fullText)
    {
        global $_CONF;
        
        if ($query) {
            $mywords = explode(' ',$query);
            $position = 0;
            
            // Find the first keyword in our text
            foreach ($mywords as $searchword) {
                $temp = stristr($fullText, $searchword);
                $pos = strlen($fullText) - strlen($temp);
                
                if($pos < $position OR $position == 0) {
                    $position = $pos;
                }
            }    
            // Make sure we aren't beyond the end of the string
            if ($position >= strlen($fullText)) {
                $position = 0;
            }
        
            //provide a buffer for content
            $position = $position - 50;
            
            // Make sure we aren't before the beginning of the string
            if ($position < 0) {
                $position = 0;
            }
                
            $summary = substr( $fullText,$position,$_CONF['summary_length']);  
            
            //remove unnecessary tags
            $summary = strip_tags($summary,'<ol><ul><li><br>');
            $summary = preg_replace ("/^.*\">/i", "", $summary);
            
            //Dress it up a little                      
            if (strlen($summary) != strlen($fullText)) {
                if ($position > 0) {
                    $summary = "&hellip; $summary";
                }
                if (($position + $_CONF['summary_length']) < strlen($fullText)) {
                    $summary = "$summary &hellip;";
                }
            }
            
            //highlight the key words
            foreach ($mywords as $searchword) {
                $summary = preg_replace ("/($searchword)/i", "<b>\\1</b>", "$summary");
            }
        } else {
            $summary = substr($fullText, 0, $_CONF['summary_length']);
            if (strlen($fullText) > $_CONF['summary_length']) {
                $summary = "$summary &hellip;";
            }
        }
        return $summary;
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
        global $_TABLES, $LANG09, $_CONF;

        // Verify current user my use the search form
        if (!$this->_isFormAllowed()) {
            return $this->_getAccessDeniedMessage();
        }

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
                $result = DB_query("SELECT uid,username FROM {$_TABLES['users']} WHERE uid in ($inlist) ORDER by username");
                $useroptions = '';
                while ($A = DB_fetchArray($result)) {
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
        $this->link_results = $this->_searchLinks();
        $this->event_results = $this->_searchEvents();
        
        // Have plugins do their searches
        list($nrows_plugins, $total_plugins, $result_plugins) = PLG_doSearch($this->_query, $this->_dateStart, $this->_dateEnd, $this->_topic, $this->_type, $this->_author);
        
        // Add the core GL object search results to plugin results
        $nrows_plugins = $nrows_plugins + $this->story_results->num_searchresults;
        $nrows_plugins = $nrows_plugins + $this->comment_results->num_searchresults;
        $nrows_plugins = $nrows_plugins + $this->link_results->num_searchresults;
        $nrows_plugins = $nrows_plugins + $this->event_results->num_searchresults;
        
        $total_plugins = $total_plugins + $this->story_results->num_itemssearched;
        $total_plugins = $total_plugins + $this->comment_results->num_itemssearched;
        $total_plugins = $total_plugins + $this->link_results->num_itemssearched;
        $total_plugins = $total_plugins + $this->event_results->num_itemssearched;
        
        // Move GL core objects to front of array
        array_unshift($result_plugins, $this->story_results, $this->comment_results, $this->link_results, $this->event_results);
        
        // Searches are done, stop timer
        $searchtime = $searchtimer->stopTimer();
      
        // Format results
        $retval = $this->_formatResults($nrows_plugins, $total_plugins, $result_plugins, $searchtime);
        
        return $retval;
    }
    
}

?>
