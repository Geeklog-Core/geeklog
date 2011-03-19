<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | search.class.php                                                          |
// |                                                                           |
// | Geeklog search class.                                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT geeklog DOT net                       |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
// |          Sami Barakat     - sami AT sbarakat DOT co DOT uk                |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'search.class.php') !== false) {
    die('This file can not be used on its own.');
}

require_once $_CONF['path_system'] . 'classes/plugin.class.php';
require_once $_CONF['path_system'] . 'classes/searchcriteria.class.php';
require_once $_CONF['path_system'] . 'classes/listfactory.class.php';

/**
* Geeklog Search Class
*
* @author Tony Bibbs, tony AT geeklog DOT net
* @package net.geeklog.search
*
*/
class Search {

    // PRIVATE VARIABLES
    private $_query = '';
    private $_topic = '';
    private $_dateStart = null;
    private $_dateEnd = null;
    private $_author = '';
    private $_type = '';
    private $_keyType = '';
    private $_names = array();
    private $_url_rewrite = array();
    private $_append_query = array();
    private $_searchURL = '';
    private $_wordlength;
    private $_verbose = false; // verbose logging
    private $_titlesOnly = false;

    /**
    * Constructor
    *
    * Sets up private search variables
    *
    * @author Tony Bibbs, tony AT geeklog DOT net
    * @access public
    *
    */
    function Search()
    {
        global $_CONF, $_TABLES;

        // Set search criteria
        if (isset ($_GET['query'])) {
            $this->_query = strip_tags (COM_stripslashes ($_GET['query']));
        }
        if (isset ($_GET['topic'])) {
            $this->_topic = COM_applyFilter ($_GET['topic']);
        }
        if (isset ($_GET['datestart'])) {
            $this->_dateStart = COM_applyFilter ($_GET['datestart']);
        }
        if (isset ($_GET['dateend'])) {
            $this->_dateEnd = COM_applyFilter ($_GET['dateend']);
        }
        if (isset ($_GET['author'])) {
            $this->_author = COM_applyFilter($_GET['author']);

            // In case we got a username instead of uid, convert it.  This should
            // make custom themes for search page easier.
            if (!is_numeric($this->_author) && !preg_match('/^([0-9]+)$/', $this->_author) && $this->_author != '') {
                $this->_author = DB_getItem($_TABLES['users'], 'uid', 'username=\'' . addslashes ($this->_author) . '\'');
            }

            if ($this->_author < 1) {
                $this->_author = '';
            }
        }
        $this->_type = isset($_GET['type']) ? COM_applyFilter($_GET['type']) : 'all';
        $this->_keyType = isset($_GET['keyType']) ? COM_applyFilter($_GET['keyType']) : $_CONF['search_def_keytype'];

        $this->_titlesOnly = isset($_GET['title']) ? true : false;
    }

    /**
    * Determines if user is allowed to perform a search
    *
    * Geeklog has a number of settings that may prevent
    * the access anonymous users have to the search engine.
    * This performs those checks
    *
    * @author Tony Bibbs, tony AT geeklog DOT net
    * @access private
    * @return boolean True if search is allowed, otherwise false
    *
    */
    function _isSearchAllowed()
    {
        global $_CONF;

        if (COM_isAnonUser()) {
            //check if an anonymous user is attempting to illegally access privilege search capabilities
            if (($this->_type != 'all') OR !empty($this->_dateStart) OR !empty($this->_dateEnd) OR ($this->_author > 0) OR !empty($topic)) {
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
    * @author Dirk Haun, dirk AT haun-online DOT de
    * @access private
    * @return boolean True if form usage is allowed, otherwise false
    *
    */
    function _isFormAllowed ()
    {
        global $_CONF;

        if (COM_isAnonUser() AND (($_CONF['loginrequired'] == 1) OR ($_CONF['searchloginrequired'] >= 1))) {
            return false;
        }

        return true;
    }

    /**
    * Shows search form
    *
    * Shows advanced search page
    *
    * @author Tony Bibbs, tony AT geeklog DOT net
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
            return SEC_loginRequiredForm();
        }

        $retval .= COM_startBlock($LANG09[1],'advancedsearch.html');
        $searchform = COM_newTemplate($_CONF['path_layout'].'search');
        $searchform->set_file (array ('searchform' => 'searchform.thtml',
                                      'authors'    => 'searchauthors.thtml'));
        $searchform->set_var('search_intro', $LANG09[19]);
        $searchform->set_var('lang_keywords', $LANG09[2]);
        $searchform->set_var('lang_date', $LANG09[20]);
        $searchform->set_var('lang_to', $LANG09[21]);
        $searchform->set_var('date_format', $LANG09[22]);
        $searchform->set_var('lang_topic', $LANG09[3]);
        $searchform->set_var('lang_all', $LANG09[4]);
        $searchform->set_var('topic_option_list',
                            COM_topicList ('tid,topic', $this->_topic));
        $searchform->set_var('lang_type', $LANG09[5]);
        $searchform->set_var('lang_results', $LANG09[59]);
        $searchform->set_var('lang_per_page', $LANG09[60]);

        $searchform->set_var('lang_exact_phrase', $LANG09[43]);
        $searchform->set_var('lang_all_words', $LANG09[44]);
        $searchform->set_var('lang_any_word', $LANG09[45]);
        $searchform->set_var('lang_titles', $LANG09[69]);

        $escquery = htmlspecialchars($this->_query);
        $escquery = str_replace(array('{', '}'), array('&#123;', '&#125;'),
                                $escquery);
        $searchform->set_var ('query', $escquery);
        $searchform->set_var ('datestart', $this->_dateStart);
        $searchform->set_var ('dateend', $this->_dateEnd);
        if ($this->_titlesOnly) {
            $searchform->set_var('title_checked', ' checked="checked"');
        } else {
            $searchform->set_var('title_checked', '');
        }

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

        $options = '';
        $plugintypes = array('all' => $LANG09[4], 'stories' => $LANG09[6], 'comments' => $LANG09[7]);
        $plugintypes = array_merge($plugintypes, PLG_getSearchTypes());
        // Generally I don't like to hardcode HTML but this seems easiest
        foreach ($plugintypes as $key => $val) {
            $options .= "<option value=\"$key\"";
            if ($this->_type == $key)
                $options .= ' selected="selected"';
            $options .= ">$val</option>".LB;
        }
        $searchform->set_var('plugin_types', $options);

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
                if (isset ($_CONF['show_fullname']) && ($_CONF['show_fullname'] == 1)) {
                    /* Caveat: This will group all users with an emtpy fullname
                     *         together, so it's not exactly sorted by their
                     *         full name ...
                     */
                    $sql .= ' ORDER BY fullname,username';
                } else {
                    $sql .= ' ORDER BY username';
                }
                $result = DB_query ($sql);
                $options = '';
                while ($A = DB_fetchArray($result)) {
                    $options .= '<option value="' . $A['uid'] . '"';
                    if ($A['uid'] == $this->_author) {
                        $options .= ' selected="selected"';
                    }
                    $options .= '>' . htmlspecialchars(COM_getDisplayName('', $A['username'], $A['fullname'])) . '</option>';
                }
                $searchform->set_var('author_option_list', $options);
                $searchform->parse('author_form_element', 'authors', true);
            } else {
                $searchform->set_var('author_form_element', '<input type="hidden" name="author" value="0"' . XHTML . '>');
            }
        } else {
            $searchform->set_var ('author_form_element',
                    '<input type="hidden" name="author" value="0"' . XHTML . '>');
        }

        // Results per page
        $options = '';
        $limits = explode(',', $_CONF['search_limits']);
        foreach ($limits as $limit) {
            $options .= "<option value=\"$limit\"";
            if ($_CONF['num_search_results'] == $limit) {
                $options .= ' selected="selected"';
            }
            $options .= ">$limit</option>" . LB;
        }
        $searchform->set_var('search_limits', $options);

        $searchform->set_var('lang_search', $LANG09[10]);
        PLG_templateSetVars('search', $searchform);
        $searchform->parse('output', 'searchform');

        $retval .= $searchform->finish($searchform->get_var('output'));
        $retval .= COM_endBlock();

        return $retval;
    }

    /**
    * Performs search on all stories
    *
    * @access private
    * @return object plugin object
    *
    */
    function _searchStories()
    {
        global $_TABLES, $_DB_dbms, $LANG09;

        // Make sure the query is SQL safe
        $query = trim(addslashes($this->_query));

        $sql = 'SELECT s.sid AS id, s.title AS title, s.introtext AS description, ';
        $sql .= 'UNIX_TIMESTAMP(s.date) AS date, s.uid AS uid, s.hits AS hits, ';
        $sql .= 'CONCAT(\'/article.php?story=\',s.sid) AS url ';
        $sql .= 'FROM '.$_TABLES['stories'].' AS s, '.$_TABLES['users'].' AS u ';
        $sql .= 'WHERE (draft_flag = 0) AND (date <= NOW()) AND (u.uid = s.uid) ';
        $sql .= COM_getPermSQL('AND') . COM_getTopicSQL('AND') . COM_getLangSQL('sid', 'AND') . ' ';

        if (!empty($this->_topic)) {
            $sql .= 'AND (s.tid = \''.$this->_topic.'\') ';
        }
        if (!empty($this->_author)) {
            $sql .= 'AND (s.uid = \''.$this->_author.'\') ';
        }

        $search_s = new SearchCriteria('stories', $LANG09[65]);

        $columns = array('title' => 'title', 'introtext', 'bodytext');
        $sql .= $search_s->getDateRangeSQL('AND', 'date', $this->_dateStart, $this->_dateEnd);
        list($sql, $ftsql) = $search_s->buildSearchSQL($this->_keyType, $query, $columns, $sql);

        $search_s->setSQL($sql);
        $search_s->setFTSQL($ftsql);
        $search_s->setRank(5);
        $search_s->setURLRewrite(true);

        // Search Story Comments
        $sql = 'SELECT c.cid AS id, c.title AS title, c.comment AS description, ';
        $sql .= 'UNIX_TIMESTAMP(c.date) AS date, c.uid AS uid, \'0\' AS hits, ';

        // MSSQL has a problem when concatenating numeric values
        if ($_DB_dbms == 'mssql') {
            $sql .= '\'/comment.php?mode=view&amp;cid=\' + CAST(c.cid AS varchar(10)) AS url ';
        } else {
            $sql .= 'CONCAT(\'/comment.php?mode=view&amp;cid=\',c.cid) AS url ';
        }

        $sql .= 'FROM '.$_TABLES['users'].' AS u, '.$_TABLES['comments'].' AS c ';
        $sql .= 'LEFT JOIN '.$_TABLES['stories'].' AS s ON ((s.sid = c.sid) ';
        $sql .= COM_getPermSQL('AND',0,2,'s').COM_getTopicSQL('AND',0,'s').COM_getLangSQL('sid','AND','s').') ';
        $sql .= 'WHERE (u.uid = c.uid) AND (s.draft_flag = 0) AND (s.commentcode >= 0) AND (s.date <= NOW()) ';

        if (!empty($this->_topic)) {
            $sql .= 'AND (s.tid = \''.$this->_topic.'\') ';
        }
        if (!empty($this->_author)) {
            $sql .= 'AND (c.uid = \''.$this->_author.'\') ';
        }

        $search_c = new SearchCriteria('comments', array($LANG09[65],$LANG09[66]));

        $columns = array('title' => 'c.title', 'comment');
        $sql .= $search_c->getDateRangeSQL('AND', 'c.date', $this->_dateStart, $this->_dateEnd);
        list($sql, $ftsql) = $search_c->buildSearchSQL($this->_keyType, $query, $columns, $sql);

        $search_c->setSQL($sql);
        $search_c->setFTSQL($ftsql);
        $search_c->setRank(2);

        return array($search_s, $search_c);
    }

    /**
    * Kicks off the appropriate search(es)
    *
    * Initiates the search engine and returns HTML formatted
    * results. It also provides support to plugins using a
    * search API. Backwards compatibility has been incorporated
    * in this function to allow legacy support to plugins using
    * the old API calls defined versions prior to Geeklog 1.5.1
    *
    * @access public
    * @return string HTML output for search results
    *
    */
    function doSearch()
    {
        global $_CONF, $LANG01, $LANG09, $LANG31;

        // Verify current user can perform requested search
        if (!$this->_isSearchAllowed()) {
            return SEC_loginRequiredForm();
        }

        // Make sure there is a query string
        // Full text searches have a minimum word length of 3 by default
        if ((empty($this->_query) && empty($this->_author) && empty($this->_topic)) || ($_CONF['search_use_fulltext'] && strlen($this->_query) < 3))
        {
            $retval = '<p>' . $LANG09[41] . '</p>' . LB;
            $retval .= $this->showForm();

            return $retval;
        }

        // Build the URL strings
        $this->_searchURL = $_CONF['site_url'] . '/search.php?query=' . urlencode($this->_query) .
            ((!empty($this->_keyType))    ? '&amp;keyType=' . $this->_keyType : '' ) .
            ((!empty($this->_dateStart))  ? '&amp;datestart=' . $this->_dateStart : '' ) .
            ((!empty($this->_dateEnd))    ? '&amp;dateend=' . $this->_dateEnd : '' ) .
            ((!empty($this->_topic))      ? '&amp;topic=' . $this->_topic : '' ) .
            ((!empty($this->_author))     ? '&amp;author=' . $this->_author : '' ) .
            ($this->_titlesOnly           ? '&amp;title=true' : '');

        $url = "{$this->_searchURL}&amp;type={$this->_type}&amp;mode=";
        $obj = new ListFactory($url.'search', $_CONF['search_limits'], $_CONF['num_search_results']);
        $obj->setField('ID', 'id', false);
        $obj->setField('URL', 'url', false);

        $show_num  = $_CONF['search_show_num'];
        $show_type = $_CONF['search_show_type'];
        $show_user = $_CONF['contributedbyline'];
        $show_hits = !$_CONF['hideviewscount'];
        $style = isset($_CONF['search_style']) ? $_CONF['search_style'] : 'google';

        if ($style == 'table')
        {
            $obj->setStyle('table');
            //             Title        Name            Display     Sort   Format
            $obj->setField($LANG09[62], LF_ROW_NUMBER,  $show_num,  false, '<b>%d.</b>');
            $obj->setField($LANG09[5],  LF_SOURCE_TITLE,$show_type, true,  '<b>%s</b>');
            $obj->setField($LANG09[16], 'title',        true,       true);
            $obj->setField($LANG09[63], 'description',  true,       false);
            $obj->setField($LANG09[17], 'date',         true,       true);
            $obj->setField($LANG09[18], 'uid',          $show_user, true);
            $obj->setField($LANG09[50], 'hits',         $show_hits, true);
            $this->_wordlength = 7;
        }
        else if ($style == 'google')
        {
            $sort_uid = $this->_author == '' ? true : false;
            $sort_date = empty($this->_dateStart) || empty($this->_dateEnd) || $this->_dateStart != $this->_dateEnd ? true : false;
            $sort_type = $this->_type == 'all' ? true : false;
            $obj->setStyle('inline');
            $obj->setField('',          LF_ROW_NUMBER,  $show_num,  false, '<b>%d.</b>');
            $obj->setField($LANG09[16], 'title',        true,       true,  '%s<br' . XHTML . '>');
            $obj->setField('',          'description',  true,       false, '%s<br' . XHTML . '>');
            $obj->setField('',          '_html',        true,       false, '<span class="searchresult-byline">');
            $obj->setField($LANG09[18], 'uid',          $show_user, $sort_uid,  $LANG01[104].' %s ');
            $obj->setField($LANG09[17], 'date',         true,       $sort_date,  $LANG01[36].' %s');
            $obj->setField($LANG09[5],  LF_SOURCE_TITLE,$show_type, $sort_type,  ' - %s');
            $obj->setField($LANG09[50], 'hits',         $show_hits, true,  ' - %s '.$LANG09[50]);
            $obj->setField('',          '_html',        true,       false, '</span>');
            $this->_wordlength = 50;
        }

        // get default sort order
        $default_sort = explode('|', $_CONF['search_def_sort']);
        $obj->setDefaultSort($default_sort[0], $default_sort[1]);

        // set this only now, for compatibility with PHP 4
        $obj->setRowFunction(array($this, 'searchFormatCallback'));

        // Start search timer
        $searchtimer = new timerobject();
        $searchtimer->setPrecision(4);
        $searchtimer->startTimer();

        // Have plugins do their searches
        $page = isset($_GET['page']) ? COM_applyFilter($_GET['page'], true) : 1;
        $result_plugins = PLG_doSearch($this->_query, $this->_dateStart,
            $this->_dateEnd, $this->_topic, $this->_type,
            $this->_author, $this->_keyType, $page, 5);

        // Add core searches
        $result_plugins = array_merge($result_plugins, $this->_searchStories());

        // Loop through all plugins separating the new API from the old
        $new_api = 0;
        $old_api = 0;
        $num_results = 0;

        foreach ($result_plugins as $result)
        {
            if (is_a($result, 'SearchCriteria'))
            {
                $debug_info = $result->getName().' using APIv2';

                if ($this->_type != 'all' && $this->_type != $result->getName())
                {
                    if ($this->_verbose) {
                        $new_api++;
                        COM_errorLog($debug_info.'. Skipped as type is not '.$this->_type);
                    }
                    continue;
                }

                $api_results = $result->getResults();
                if (!empty($api_results)) {
                    $obj->addResultArray($api_results);
                }

                $api_callback_func = $result->getCallback();
                if (!empty($api_callback_func))
                {
                    $debug_info .= ' with Callback Function.';
                    $obj->setCallback($result->getLabel(), $result->getName(), $api_callback_func, $result->getRank(), $result->getTotal());
                }
                else if ($result->getSQL() != '' || $result->getFTSQL()  != '')
                {
                    if ($_CONF['search_use_fulltext'] == true && $result->getFTSQL() != '') {
                        $sql = $result->getFTSQL();
                    } else {
                        $sql = $result->getSQL();
                    }

                    $sql = $this->_convertsql($sql);
                    $debug_info .= ' with SQL = '.print_r($sql,1);
                    $obj->setQuery($result->getLabel(), $result->getName(), $sql, $result->getRank());
                }

                $this->_url_rewrite[ $result->getName() ] = $result->UrlRewriteEnable();
                $this->_append_query[ $result->getName() ] = $result->AppendQueryEnable();

                if ($this->_verbose) {
                    $new_api++;
                    COM_errorLog($debug_info);
                }
            }
            else if (is_a($result, 'Plugin') && $result->num_searchresults != 0)
            {
                // Some backwards compatibility
                if ($this->_verbose) {
                    $old_api++;
                    $debug_info = $result->plugin_name.' using APIv1 with backwards compatibility.';
                    $debug_info .= ' Count: ' . $result->num_searchresults;
                    $debug_info .= ' Headings: ' . implode(',', $result->searchheading);
                    COM_errorLog($debug_info);
                }

                // Find the column heading names that closely match what we are looking for
                // There may be issues here on different languages, but this _should_ capture most of the data
                $col_title = $this->_findColumn($result->searchheading, array($LANG09[16],$LANG31[4],'Question', 'Site Page'));//Title,Subject
                $col_desc = $this->_findColumn($result->searchheading, array($LANG09[63],'Answer'));
                $col_date = $this->_findColumn($result->searchheading, array($LANG09[17]));//'Date','Date Added','Last Updated','Date & Time'
                $col_user = $this->_findColumn($result->searchheading, array($LANG09[18],'Submited by'));
                $col_hits = $this->_findColumn($result->searchheading, array($LANG09[50],$LANG09[23],'Downloads','Clicks'));//'Hits','Views'

                $label = str_replace($LANG09[59], '', $result->searchlabel);
                $num_results += $result->num_itemssearched;

                // Extract the results
                for ($i = 0; $i < 5; $i++)
                {
                    // If the plugin does not repect the $perpage perameter force it here.
                    $j = ($i + ($page * 5)) - 5;
                    if ($j >= count($result->searchresults))
                        break;

                    $old_row = $result->searchresults[$j];
                    if ($col_date != -1)
                    {
                        // Convert the date back to a timestamp
                        $date = $old_row[ $col_date ];
                        $date = substr($date, 0, strpos($date, '@'));
                        $date = ($date == '' ? $old_row[$col_date] : strtotime($date));
                    }

                    $api_results = array(
                                LF_SOURCE_NAME =>   $result->plugin_name,
                                LF_SOURCE_TITLE =>  $label,
                                'title' =>        $col_title == -1 ? '<i>' . $LANG09[70] . '</i>' : $old_row[$col_title],
                                'description' =>  $col_desc == -1 ? '<i>' . $LANG09[70] . '</i>' : $old_row[$col_desc],
                                'date' =>         $col_date == -1 ? '&nbsp;' : $date,
                                'uid' =>          $col_user == -1 ? '&nbsp;' : $old_row[$col_user],
                                'hits' =>         $col_hits == -1 ? '0' : str_replace(',', '', $old_row[$col_hits])
                            );
                    preg_match('/href="([^"]+)"/i', $api_results['title'], $links);
                    $api_results['url'] = empty($links) ? '#' : $links[1];

                    $obj->addResult($api_results);
                }
            }
        }

        // Find out how many plugins are on the old/new system
        if ($this->_verbose) {
            COM_errorLog('Search Plugins using APIv1: '.$old_api.' APIv2: '.$new_api);
        }

        // Execute the queries
        $results = $obj->ExecuteQueries();

        // Searches are done, stop timer
        $searchtime = $searchtimer->stopTimer();

        $escquery = htmlspecialchars($this->_query);
        $escquery = str_replace(array('{', '}'), array('&#123;', '&#125;'),
                                $escquery);
        if ($this->_keyType == 'any')
        {
            $searchQuery = str_replace(' ', "</b>' " . $LANG09[57] . " '<b>", $escquery);
            $searchQuery = "<b>'$searchQuery'</b>";
        }
        else if ($this->_keyType == 'all')
        {
            $searchQuery = str_replace(' ', "</b>' " . $LANG09[56] . " '<b>", $escquery);
            $searchQuery = "<b>'$searchQuery'</b>";
        }
        else
        {
            $searchQuery = $LANG09[55] . " '<b>$escquery</b>'";
        }

        // Clean the query string so that sprintf works as expected
        $searchQuery = str_replace('%', '%%', $searchQuery);

        $retval = "{$LANG09[25]} $searchQuery. ";
        if (count($results) == 0)
        {
            $retval .= sprintf($LANG09[24], 0);
            $retval = '<p>' . $retval . '</p>' . LB;
            $retval .= '<p>' . $LANG09[13] . '</p>' . LB;
            $retval .= $this->showForm();
        }
        else
        {
            $retval .= $LANG09[64] . " ($searchtime {$LANG09[27]}). ";
            $retval .= str_replace('%', '%%', COM_createLink($LANG09[61], $url.'refine'));
            $retval = '<p>' . $retval . '</p>' . LB;
            $retval = $obj->getFormattedOutput($results, $LANG09[11], $retval, '',
                $_CONF['search_show_sort'], $_CONF['search_show_limit']);
        }

        return $retval;
    }

    /**
    * Callback function for the ListFactory class
    *
    * This function gets called by the ListFactory class and formats
    * each row accordingly for example pulling usernames from the
    * users table and displaying a link to their profile.
    *
    * @access public
    * @param array $row An array of plain data to format
    * @return array A reformatted version of the input array
    *
    */
    function searchFormatCallback( $preSort, $row )
    {
        global $_CONF, $LANG09;

        if ($preSort)
        {
            if (is_array($row[LF_SOURCE_TITLE])) {
                $row[LF_SOURCE_TITLE] = implode($_CONF['search_separator'], $row[LF_SOURCE_TITLE]);
            }

            if (is_numeric($row['uid']))
            {
                if (empty($this->_names[ $row['uid'] ]))
                {
                    $this->_names[ $row['uid'] ] = htmlspecialchars(COM_getDisplayName( $row['uid'] ));
                    if ($row['uid'] != 1)
                    {
                        $this->_names[$row['uid']] = COM_createLink($this->_names[ $row['uid'] ],
                                    $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $row['uid']);
                    }
                }
                $row['uid'] = $this->_names[ $row['uid'] ];
            }
        }
        else
        {
            $row[LF_SOURCE_TITLE] = COM_createLink($row[LF_SOURCE_TITLE],
                $this->_searchURL.'&amp;type='.$row[LF_SOURCE_NAME].'&amp;mode=search');

            if ($row['url'] != '#')
            {
                $row['url'] = ($row['url'][0] == '/' ? $_CONF['site_url'] : '') . $row['url'];
                if (isset($this->_url_rewrite[$row[LF_SOURCE_NAME]]) &&
                        $this->_url_rewrite[$row[LF_SOURCE_NAME]]) {
                    $row['url'] = COM_buildUrl($row['url']);
                }
                if (isset($this->_append_query[$row[LF_SOURCE_NAME]]) &&
                        $this->_append_query[$row[LF_SOURCE_NAME]]) {
                    if (! empty($this->_query)) {
                        $row['url'] .= (strpos($row['url'],'?') ? '&amp;' : '?') . 'query=' . urlencode($this->_query);
                    }
                }
            }

            $row['title'] = $this->_shortenText($this->_query, $row['title'], 8);
            $row['title'] = stripslashes(str_replace('$', '&#36;', $row['title']));
            $row['title'] = COM_createLink($row['title'], $row['url']);

            if ($row['description'] == 'LF_NULL') {
                $row['description'] = '<i>' . $LANG09[70] . '</i>';
            } elseif ($row['description'] != '<i>' . $LANG09[70] . '</i>') {
                $row['description'] = stripslashes($this->_shortenText($this->_query, PLG_replaceTags($row['description']), $this->_wordlength));
            }

            if ($row['date'] != 'LF_NULL') {
                $dt = COM_getUserDateTimeFormat(intval($row['date']));
                $row['date'] = $dt[0];
            }

            if ($row['hits'] != 'LF_NULL') {
                $row['hits'] = COM_NumberFormat($row['hits']) . ' '; // simple solution to a silly problem!
            }
        }

        return $row;
    }

    /**
    * Shortens a long text string to only a few words
    *
    * Returns a shorter version of the in putted text centred
    * around the keyword. The keyword is highlighted in bold.
    * Adds '...' to the beginning or the end of the shortened
    * version depending where the text was cut. Works on a
    * word basis, so long words wont get cut.
    *
    * @access private
    * @param string $keyword The word to centre around
    * @param string $text The complete text string
    * @param int $num_words The number of words to display, best to use an odd number
    * @return string A short version of the text
    *
    */
    function _shortenText($keyword, $text, $num_words = 7)
    {
        $text = COM_getTextContent($text);
        $words = explode(' ', $text);
        $word_count = count($words);
        if ($word_count <= $num_words) {
            return COM_highlightQuery($text, $keyword, 'b');
        }

        $rt = '';
        $pos = stripos($text, $keyword);
        if ($pos !== false)
        {
            $pos_space = strpos($text, ' ', $pos);
            if (empty($pos_space))
            {
                // Keyword at the end of text
                $key = $word_count - 1;
                $start = 0 - $num_words;
                $end = 0;
                $rt = '<b>...</b> ';
            }
            else
            {
                $str = substr($text, $pos, $pos_space - $pos);
                $m = (int) (($num_words - 1) / 2);
                $key = $this->_arraySearch($keyword, $words);
                if ($key === false) {
                    // Keyword(s) not found - show start of text
                    $key = 0;
                    $start = 0;
                    $end = $num_words - 1;
                } elseif ($key <= $m) {
                    // Keyword at the start of text
                    $start = 0 - $key;
                    $end = $num_words - 1;
                    $end = ($key + $m <= $word_count - 1)
                         ? $key : $word_count - $m - 1;
                    $abs_length = abs($start) + abs($end) + 1;
                    if ($abs_length < $num_words) {
                        $end += ($num_words - $abs_length);
                    }
                } else {
                    // Keyword in the middle of text
                    $start = 0 - $m;
                    $end = ($key + $m <= $word_count - 1)
                         ? $m : $word_count - $key - 1;
                    $abs_length = abs($start) + abs($end) + 1;
                    if ($abs_length < $num_words) {
                        $start -= ($num_words - $abs_length);
                    }
                    $rt = '<b>...</b> ';
                }
            }
        }
        else
        {
            $key = 0;
            $start = 0;
            $end = $num_words - 1;
        }

        for ($i = $start; $i <= $end; $i++) {
            $rt .= $words[$key + $i] . ' ';
        }
        if ($key + $i != $word_count) {
            $rt .= ' <b>...</b>';
        }

        return COM_highlightQuery($rt, $keyword, 'b');
    }

    /**
    * Search array of words for keyword(s)
    *
    * @param   string  $needle    keyword(s), separated by spaces
    * @param   array   $haystack  array of words to search through
    * @return  mixed              index in $haystack or false when not found
    * @access  private
    *
    */
    function _arraySearch($needle, $haystack)
    {
        $keywords = explode(' ', $needle);
        $num_keywords = count($keywords);

        foreach ($haystack as $key => $value) {
            if (stripos($value, $keywords[0]) !== false) {
                if ($num_keywords == 1) {
                    return $key;
                } else {
                    $matched_all = true;
                    for ($i = 1; $i < $num_keywords; $i++) {
                        if (stripos($haystack[$key + $i], $keywords[$i]) === false) {
                            $matched_all = false;
                            break;
                        }
                    }
                    if ($matched_all) {
                        return $key;
                    }
                }
            }
        }

        return false;
    }

    /**
    * Finds the similarities between heading names
    *
    * Returns the index of a heading that matches a
    * number of similar heading names. Used for backwards
    * compatibility in the doSearch() function.
    *
    * @access private
    * @param array $headings All the headings
    * @param array $find An array of alternative headings to find
    * @return int The index of the alternative heading
    *
    */
    function _findColumn( $headings, $find )
    {
        // We can't use normal for loops here as some of the
        // heading indexes start from 1, so foreach works better
        foreach ($find as $fh)
        {
            $j = 0;
            foreach ($headings as $h)
            {
                if (preg_match("/$fh/i", $h) > 0) {
                    return $j;
                }
                $j++;
            }
        }
        return -1;
    }

    /**
    * Converts the MySQL CONCAT function to the MS SQL / Postgres equivalents
    *
    * @access private
    * @param  string $sql The SQL to convert
    * @return string      MS SQL or PostgreSQL friendly SQL
    *
    */
    function _convertsql($sql)
    {
        global $_DB_dbms;

        if ($_DB_dbms == 'mssql') {
            if (is_string($sql)) {
                $sql = preg_replace("/CONCAT\(([^\)]+)\)/ie", "preg_replace('/,?(\'[^\']+\'|[^,]+),/i', '\\\\1 + ', '\\1')", $sql);
            } elseif (is_array($sql)) {
                $sql['mssql'] = preg_replace("/CONCAT\(([^\)]+)\)/ie", "preg_replace('/,?(\'[^\']+\'|[^,]+),/i', '\\\\1 + ', '\\1')", $sql['mssql']);
            }
        } elseif ($_DB_dbms == 'pgsql') {
            if (is_string($sql)) {
                $sql = preg_replace("/CONCAT\(([^\)]+)\)/ie", "preg_replace('/,?(\'[^\']+\'|[^,]+),/i', '\\\\1 || ', '\\1')", $sql);
            } elseif (is_array($sql)) {
                $sql['pgsql'] = preg_replace("/CONCAT\(([^\)]+)\)/ie", "preg_replace('/,?(\'[^\']+\'|[^,]+),/i', '\\\\1 || ', '\\1')", $sql['pgsql']);
            }
        }

        return $sql;
    }
}

?>
