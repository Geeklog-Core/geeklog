<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | search.class.php                                                          |
// |                                                                           |
// | Geeklog search class.                                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2018 by the following authors:                         |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

/**
 * Geeklog Search Class
 *
 * @author  Tony Bibbs, tony AT geeklog DOT net
 * @package net.geeklog.search
 */
class Search
{
    /**
     * @var string
     */
    private $_query = '';

    /**
     * @var string
     */
    private $_topic = '';

    /**
     * @var array|null|string
     */
    private $_dateStart = null;

    /**
     * @var array|null|string
     */
    private $_dateEnd = null;

    /**
     * @var string
     */
    private $_author = '';

    /**
     * @var array|null|string
     */
    private $_type = '';

    /**
     * @var array|null|string
     */
    private $_keyType = '';

    /**
     * @var array
     */
    private $_names = array();

    /**
     * @var array
     */
    private $_url_rewrite = array();

    /**
     * @var array
     */
    private $_append_query = array();

    /**
     * @var string
     */
    private $_searchURL = '';

    /**
     * @var
     */
    private $_wordLength;

    /**
     * @var bool
     */
    private $_verbose = false; // verbose logging

    /**
     * @var bool
     */
    private $_titlesOnly = false;

    /**
     * Constructor
     * Sets up private search variables
     *
     * @author Tony Bibbs, tony AT geeklog DOT net
     */
    public function __construct()
    {
        global $_CONF, $_TABLES;

        // Set search criteria
        if (isset($_GET['query'])) {
            $query = Geeklog\Input::fGet('query');
            $query = urldecode($query);
            $query = GLText::remove4byteUtf8Chars($query);
            $this->_query = GLText::stripTags($query);
        }

        if (isset($_GET['topic'])) {
            // see if topic exists
            $tid = Geeklog\Input::fGet('topic');

            // If it exists and user has access to it, it will return itself else an empty string
            $tid = DB_getItem($_TABLES['topics'], 'tid', "tid = '" . DB_escapeString($tid) . "'" . COM_getPermSQL('AND', 0, 2));
            $this->_topic = $tid;
        } else {
            if ($_CONF['search_use_topic']) {
                $current_topic = TOPIC_currentTopic();
                if (!empty($current_topic)) {
                    $this->_topic = $current_topic;
                }
            }
        }
        if (isset($_GET['datestart'])) {
            $this->_dateStart = Geeklog\Input::fGet('datestart');
        }
        if (isset($_GET['dateend'])) {
            $this->_dateEnd = Geeklog\Input::fGet('dateend');
        }
        if (isset($_GET['author'])) {
            $this->_author = Geeklog\Input::fGet('author');

            // In case we got a username instead of uid, convert it.  This should
            // make custom themes for search page easier.
            if (!is_numeric($this->_author) && !preg_match('/^([0-9]+)$/', $this->_author) && $this->_author != '') {
                $this->_author = DB_getItem($_TABLES['users'], 'uid', "username='" . DB_escapeString($this->_author) . "'");
            }

            if ($this->_author < 1) {
                $this->_author = '';
            }
        }

        $this->_type = Geeklog\Input::fGet('type', 'all');
        $this->_keyType = Geeklog\Input::fGet('keyType', $_CONF['search_def_keytype']);
        $this->_titlesOnly = isset($_GET['title']);
    }

    /**
     * Determines if user is allowed to perform a search
     * Geeklog has a number of settings that may prevent
     * the access anonymous users have to the search engine.
     * This performs those checks
     *
     * @author Tony Bibbs, tony AT geeklog DOT net
     * @return boolean True if search is allowed, otherwise false
     */
    private function _isSearchAllowed()
    {
        global $_CONF;

        if (COM_isAnonUser()) {
            //check if an anonymous user is attempting to illegally access privilege search capabilities
            if (($this->_type !== 'all') || !empty($this->_dateStart) || !empty($this->_dateEnd) || ($this->_author > 0) || !empty($topic)) {
                if (($_CONF['loginrequired'] == 1) || ($_CONF['searchloginrequired'] >= 1)) {
                    return false;
                }
            } else {
                if (($_CONF['loginrequired'] == 1) || ($_CONF['searchloginrequired'] == 2)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Determines if user is allowed to use the search form
     * Geeklog has a number of settings that may prevent
     * the access anonymous users have to the search engine.
     * This performs those checks
     *
     * @author Dirk Haun, dirk AT haun-online DOT de
     * @return boolean True if form usage is allowed, otherwise false
     */
    private function _isFormAllowed()
    {
        global $_CONF;

        if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) || ($_CONF['searchloginrequired'] >= 1))) {
            return false;
        }

        return true;
    }

    /**
     * Shows search form
     * Shows advanced search page
     *
     * @author Tony Bibbs, tony AT geeklog DOT net
     * @return string HTML output for form
     */
    public function showForm()
    {
        global $_CONF, $_TABLES, $LANG09;

        $retval = '';

        // Verify current user my use the search form
        if (!$this->_isFormAllowed()) {
            return SEC_loginRequiredForm();
        }

        $retval .= COM_startBlock($LANG09[1], 'advancedsearch.html');
        $searchForm = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'search'));
        $searchForm->set_file(array(
            'searchform' => 'searchform.thtml',
            'authors'    => 'searchauthors.thtml',
        ));
        $searchForm->set_var('search_intro', $LANG09[19]);
        $searchForm->set_var('lang_keywords', $LANG09[2]);
        $searchForm->set_var('lang_keytype', $LANG09[36]);
        $searchForm->set_var('lang_date', $LANG09[20]);
        $searchForm->set_var('lang_to', $LANG09[21]);
        $searchForm->set_var('date_format', $LANG09[22]);
        $searchForm->set_var('lang_topic', $LANG09[3]);
        $searchForm->set_var('lang_all', $LANG09[4]);
        $searchForm->set_var('topic_option_list', TOPIC_getTopicListSelect($this->_topic, 2, true));
        $searchForm->set_var('lang_type', $LANG09[5]);
        $searchForm->set_var('lang_results', $LANG09[59]);
        $searchForm->set_var('lang_per_page', $LANG09[60]);

        $searchForm->set_var('lang_exact_phrase', $LANG09[43]);
        $searchForm->set_var('lang_all_words', $LANG09[44]);
        $searchForm->set_var('lang_any_word', $LANG09[45]);
        $searchForm->set_var('lang_titles', $LANG09[69]);

        $escQuery = htmlspecialchars($this->_query);
        $escQuery = str_replace(array('{', '}'), array('&#123;', '&#125;'), $escQuery);
        $searchForm->set_var('query', $escQuery);
        $searchForm->set_var('datestart', $this->_dateStart);
        $searchForm->set_var('dateend', $this->_dateEnd);
        if ($this->_titlesOnly) {
            $searchForm->set_var('title_checked', ' checked="checked"');
        } else {
            $searchForm->set_var('title_checked', '');
        }

        $phrase_selected = '';
        $all_selected = '';
        $any_selected = '';
        if ($this->_keyType === 'phrase') {
            $phrase_selected = 'selected="selected"';
        } elseif ($this->_keyType === 'all') {
            $all_selected = 'selected="selected"';
        } elseif ($this->_keyType === 'any') {
            $any_selected = 'selected="selected"';
        }
        $searchForm->set_var('key_phrase_selected', $phrase_selected);
        $searchForm->set_var('key_all_selected', $all_selected);
        $searchForm->set_var('key_any_selected', $any_selected);

        $options = '';
        $pluginTypes = array(
            'all' => $LANG09[4],
            'stories' => $LANG09[6],
            'comments' => $LANG09[7]
        );
        $pluginTypes = array_merge($pluginTypes, PLG_getSearchTypes());

        // Generally I don't like to hardcode HTML but this seems easiest
        foreach ($pluginTypes as $key => $val) {
            $options .= "<option value=\"$key\"";
            if ($this->_type == $key) {
                $options .= ' selected="selected"';
            }
            $options .= ">$val</option>" . LB;
        }
        $searchForm->set_var('plugin_types', $options);

        if ($_CONF['contributedbyline'] == 1) {
            $searchForm->set_var('lang_authors', $LANG09[8]);
            $searchUsers = array();
            $result = DB_query("SELECT DISTINCT uid FROM {$_TABLES['comments']}");
            while ($A = DB_fetchArray($result)) {
                $searchUsers[$A['uid']] = $A['uid'];
            }

            $result = DB_query("SELECT DISTINCT uid FROM {$_TABLES['stories']} WHERE (date <= NOW()) AND (draft_flag = 0)");
            while ($A = DB_fetchArray($result)) {
                $searchUsers[$A['uid']] = $A['uid'];
            }

            $inList = implode(',', $searchUsers);

            if (!empty ($inList)) {
                $sql = "SELECT uid,username,fullname FROM {$_TABLES['users']} WHERE uid IN ($inList)";
                if (isset($_CONF['show_fullname']) && ($_CONF['show_fullname'] == 1)) {
                    /* Caveat: This will group all users with an empty fullname
                     *         together, so it's not exactly sorted by their
                     *         full name ...
                     */
                    $sql .= ' ORDER BY fullname,username';
                } else {
                    $sql .= ' ORDER BY username';
                }
                $result = DB_query($sql);
                $options = '';
                while ($A = DB_fetchArray($result)) {
                    $options .= '<option value="' . $A['uid'] . '"';
                    if ($A['uid'] == $this->_author) {
                        $options .= ' selected="selected"';
                    }
                    $options .= '>' . htmlspecialchars(COM_getDisplayName('', $A['username'], $A['fullname'])) . '</option>';
                }
                $searchForm->set_var('author_option_list', $options);
                $searchForm->parse('author_form_element', 'authors', true);
            } else {
                $searchForm->set_var('author_form_element', '<input type="hidden" name="author" value="0"' . XHTML . '>');
            }
        } else {
            $searchForm->set_var('author_form_element',
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
        $searchForm->set_var('search_limits', $options);

        $searchForm->set_var('lang_search', $LANG09[10]);
        PLG_templateSetVars('search', $searchForm);
        $searchForm->parse('output', 'searchform');

        $retval .= $searchForm->finish($searchForm->get_var('output'));
        $retval .= COM_endBlock();

        return $retval;
    }

    /**
     * Performs search on all stories
     *
     * @return array of SearchCriteria
     */
    private function _searchStories()
    {
        global $_TABLES, $LANG09;

        // Make sure the query is SQL safe
        $query = trim(DB_escapeString($this->_query));

        $sql = 'SELECT s.sid AS id, s.title AS title, s.introtext AS description, ';
        $sql .= 'UNIX_TIMESTAMP(s.date) AS date, s.uid AS uid, s.hits AS hits, ';
        $sql .= "CONCAT('/article.php?story=', s.sid) AS url ";
        $sql .= 'FROM ' . $_TABLES['stories'] . ' AS s, ' . $_TABLES['users'] . ' AS u, ' . $_TABLES['topic_assignments'] . ' AS ta ';
        $sql .= 'WHERE (draft_flag = 0) AND (date <= NOW()) AND (u.uid = s.uid) ';
        $sql .= 'AND ta.type = \'article\' AND ta.id = sid ';
        $sql .= COM_getPermSQL('AND') . COM_getTopicSQL('AND', 0, 'ta') . COM_getLangSQL('sid', 'AND') . ' ';

        if (!empty($this->_topic)) {
            // Retrieve list of inherited topics
            if ($this->_topic == TOPIC_ALL_OPTION) {
                // Stories do not have an all option so just return all stories that meet the requirements and permissions
                //$sql .= "AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '".$this->_topic."')) ";
            } else {
                $tid_list = TOPIC_getChildList($this->_topic);
                $sql .= "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '" . $this->_topic . "'))) ";
            }
        }
        if (!empty($this->_author)) {
            $sql .= 'AND (s.uid = \'' . $this->_author . '\') ';
        }

        $search_s = new SearchCriteria('stories', $LANG09[65]);

        $columns = array('title' => 'title', 'introtext', 'bodytext');
        $sql .= $search_s->getDateRangeSQL('AND', 'date', $this->_dateStart, $this->_dateEnd);
        list($sql, $ftSql) = $search_s->buildSearchSQL($this->_keyType, $query, $columns, $sql);

        $sql .= " GROUP BY s.sid, s.title, s.introtext, date, s.uid, s.hits ";

        $search_s->setSQL($sql);
        $search_s->setFtSQL($ftSql);
        $search_s->setRank(5);
        $search_s->setURLRewrite(true);

        // Search Story Comments
        $sql = 'SELECT c.cid AS id, c.title AS title, c.comment AS description, ';
        $sql .= 'UNIX_TIMESTAMP(c.date) AS date, c.uid AS uid, \'0\' AS hits, ';
        $sql .= 'CONCAT(\'/comment.php?mode=view&amp;cid=\',c.cid) AS url ';
        $sql .= 'FROM ' . $_TABLES['users'] . ' AS u, ' . $_TABLES['topic_assignments'] . ' AS ta, ' . $_TABLES['comments'] . ' AS c ';
        $sql .= 'LEFT JOIN ' . $_TABLES['stories'] . ' AS s ON ((s.sid = c.sid) ';
        $sql .= COM_getPermSQL('AND', 0, 2, 's') . COM_getLangSQL('sid', 'AND', 's') . ') ';
        $sql .= 'WHERE (u.uid = c.uid) AND (s.draft_flag = 0) AND (s.commentcode >= 0) AND (s.date <= NOW()) ';
        $sql .= 'AND ta.type = \'article\' AND ta.id = s.sid ' . COM_getTopicSQL('AND', 0, 'ta');

        if (!empty($this->_topic)) {
            if ($this->_topic == TOPIC_ALL_OPTION) {
                // Stories do not have an all option so just return all story comments that meet the requirements and permissions
                //$sql .= "AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '".$this->_topic."')) ";
            } else {
                $sql .= "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '" . $this->_topic . "'))) ";
            }
        }
        if (!empty($this->_author)) {
            $sql .= 'AND (c.uid = \'' . $this->_author . '\') ';
        }

        $search_c = new SearchCriteria('comments', $LANG09[66]);

        $columns = array('title' => 'c.title', 'comment');
        $sql .= $search_c->getDateRangeSQL('AND', 'c.date', $this->_dateStart, $this->_dateEnd);
        list($sql, $ftSql) = $search_c->buildSearchSQL($this->_keyType, $query, $columns, $sql);

        $sql .= " GROUP BY c.cid, c.title, c.comment, c.date, c.uid ";

        $search_c->setSQL($sql);
        $search_c->setFtSQL($ftSql);
        $search_c->setRank(2);

        return array($search_s, $search_c);
    }

    /**
     * Kicks off the appropriate search(es)
     * Initiates the search engine and returns HTML formatted
     * results. It also provides support to plugins using a
     * search API. Backwards compatibility has been incorporated
     * in this function to allow legacy support to plugins using
     * the old API calls defined versions prior to Geeklog 1.5.1
     *
     * @return string HTML output for search results
     */
    public function doSearch()
    {
        global $_CONF, $LANG01, $LANG09, $LANG31;

        // Verify current user can perform requested search
        if (!$this->_isSearchAllowed()) {
            return SEC_loginRequiredForm();
        }

        // When full text searches are enabled, make sure the min. query length
        // is 3 characters. Otherwise, make sure at least one of query string,
        // author, or topic is not empty.
        if ((empty($this->_query) && empty($this->_author) && empty($this->_topic)) ||
            ($_CONF['search_use_fulltext'] && strlen($this->_query) < 3)
        ) {
            $retval = '<p>' . $LANG09[41] . '</p>' . LB;
            $retval .= $this->showForm();

            return $retval;
        }

        // Build the URL strings
        $this->_searchURL = $_CONF['site_url'] . '/search.php?query=' . urlencode($this->_query) .
            ((!empty($this->_keyType)) ? '&amp;keyType=' . $this->_keyType : '') .
            ((!empty($this->_dateStart)) ? '&amp;datestart=' . $this->_dateStart : '') .
            ((!empty($this->_dateEnd)) ? '&amp;dateend=' . $this->_dateEnd : '') .
            ((!empty($this->_topic)) ? '&amp;topic=' . $this->_topic : '') .
            ((!empty($this->_author)) ? '&amp;author=' . $this->_author : '') .
            ($this->_titlesOnly ? '&amp;title=true' : '');

        $url = "{$this->_searchURL}&amp;type={$this->_type}&amp;mode=";
        $obj = new ListFactory($url . 'search', $_CONF['search_limits'], $_CONF['num_search_results']);
        $obj->setField('ID', 'id', false);
        $obj->setField('URL', 'url', false);

        $show_num = $_CONF['search_show_num'];
        $show_type = $_CONF['search_show_type'];
        $show_user = $_CONF['contributedbyline'];
        $show_hits = !$_CONF['hideviewscount'];
        $style = isset($_CONF['search_style']) ? $_CONF['search_style'] : 'google';

        if ($style === 'table') {
            $obj->setStyle('table');
            //             Title        Name            Display     Sort   Format
            $obj->setField($LANG09[62], LF_ROW_NUMBER, $show_num, false, '<b>%d.</b>');
            $obj->setField($LANG09[5], LF_SOURCE_TITLE, $show_type, true, '<b>%s</b>');
            $obj->setField($LANG09[16], 'title', true, true);
            $obj->setField($LANG09[63], 'description', true, false);
            $obj->setField($LANG09[17], 'date', true, true);
            $obj->setField($LANG09[18], 'uid', $show_user, true);
            $obj->setField($LANG09[50], 'hits', $show_hits, true);
            $this->_wordLength = 7;
        } elseif ($style === 'google') {
            $sort_uid = $this->_author == '' ? true : false;
            $sort_date = empty($this->_dateStart) || empty($this->_dateEnd) || $this->_dateStart != $this->_dateEnd ? true : false;
            $sort_type = $this->_type == 'all' ? true : false;
            $obj->setStyle('inline');
            $obj->setField('', LF_ROW_NUMBER, $show_num, false, '<b>%d.</b>');
            $obj->setField($LANG09[16], 'title', true, true, '%s<br' . XHTML . '>');
            $obj->setField('', 'description', true, false, '%s<br' . XHTML . '>');
            $obj->setField('', '_html', true, false, '<span class="searchresult-byline">');
            $obj->setField($LANG09[18], 'uid', $show_user, $sort_uid, $LANG01[104] . ' %s ');
            $obj->setField($LANG09[17], 'date', true, $sort_date, $LANG01[36] . ' %s');
            $obj->setField($LANG09[5], LF_SOURCE_TITLE, $show_type, $sort_type, ' - %s');
            $obj->setField($LANG09[50], 'hits', $show_hits, true, ' - %s ' . $LANG09[50]);
            $obj->setField('', '_html', true, false, '</span>');
            $this->_wordLength = 50;
        }

        // get default sort order
        $default_sort = explode('|', $_CONF['search_def_sort']);
        $obj->setDefaultSort($default_sort[0], $default_sort[1]);

        // set this only now, for compatibility with PHP 4
        $obj->setRowFunction(array($this, 'searchFormatCallback'));

        // Start search timer
        $searchTimer = new timerobject();
        $searchTimer->setPrecision(4);
        $searchTimer->startTimer();

        // Have plugins do their searches
        $page = (int) Geeklog\Input::fGet('page', 1);
        $result_plugins = PLG_doSearch($this->_query, $this->_dateStart,
            $this->_dateEnd, $this->_topic, $this->_type,
            $this->_author, $this->_keyType, $page, 5
        );

        // Add core searches
        $result_plugins = array_merge($result_plugins, $this->_searchStories());

        // Loop through all plugins separating the new API from the old
        $new_api = 0;
        $old_api = 0;
        $num_results = 0;

        foreach ($result_plugins as $result) {
            if ($result instanceof SearchCriteria) {
                $debug_info = $result->getName() . ' using APIv2';

                if ($this->_type !== 'all' && $this->_type != $result->getName()) {
                    if ($this->_verbose) {
                        $new_api++;
                        COM_errorLog($debug_info . '. Skipped as type is not ' . $this->_type);
                    }
                    continue;
                }

                $api_results = $result->getResults();
                if (!empty($api_results)) {
                    $obj->addResultArray($api_results);
                }

                $api_callback_func = $result->getCallback();
                if (!empty($api_callback_func)) {
                    $debug_info .= ' with Callback Function.';
                    $obj->setCallback($result->getLabel(), $result->getName(), $api_callback_func, $result->getRank(), $result->getTotal());
                } elseif ($result->getSQL() != '' || $result->getFTSQL() != '') {
                    if ($_CONF['search_use_fulltext'] == true && $result->getFTSQL() != '') {
                        $sql = $result->getFTSQL();
                    } else {
                        $sql = $result->getSQL();
                    }

                    $sql = $this->_convertSql($sql);
                    $debug_info .= ' with SQL = ' . print_r($sql, 1);
                    $obj->setQuery($result->getLabel(), $result->getName(), $sql, $result->getRank());
                }

                $this->_url_rewrite[$result->getName()] = $result->isURLRewrite();
                $this->_append_query[$result->getName()] = $result->isAppendQuery();

                if ($this->_verbose) {
                    $new_api++;
                    COM_errorLog($debug_info);
                }
            } elseif (is_a($result, 'Plugin') && $result->num_searchresults != 0) {
                // Some backwards compatibility
                if ($this->_verbose) {
                    $old_api++;
                    $debug_info = $result->plugin_name . ' using APIv1 with backwards compatibility.';
                    $debug_info .= ' Count: ' . $result->num_searchresults;
                    $debug_info .= ' Headings: ' . implode(',', $result->searchheading);
                    COM_errorLog($debug_info);
                }

                // Find the column heading names that closely match what we are looking for
                // There may be issues here on different languages, but this _should_ capture most of the data
                $col_title = $this->_findColumn($result->searchheading, array($LANG09[16], $LANG31[4], 'Question', 'Site Page'));//Title,Subject
                $col_desc = $this->_findColumn($result->searchheading, array($LANG09[63], 'Answer'));
                $col_date = $this->_findColumn($result->searchheading, array($LANG09[17]));//'Date','Date Added','Last Updated','Date & Time'
                $col_user = $this->_findColumn($result->searchheading, array($LANG09[18], 'Submited by'));
                $col_hits = $this->_findColumn($result->searchheading, array($LANG09[50], $LANG09[23], 'Downloads', 'Clicks'));//'Hits','Views'

                $label = str_replace($LANG09[59], '', $result->searchlabel);
                $num_results += $result->num_itemssearched;

                // Extract the results
                for ($i = 0; $i < 5; $i++) {
                    // If the plugin does not respect the $perpage parameter, then force it here.
                    $j = ($i + ($page * 5)) - 5;
                    if ($j >= count($result->searchresults)) {
                        break;
                    }

                    $old_row = $result->searchresults[$j];
                    if ($col_date != -1) {
                        // Convert the date back to a timestamp
                        $date = $old_row[$col_date];
                        $date = substr($date, 0, strpos($date, '@'));
                        $date = ($date == '' ? $old_row[$col_date] : strtotime($date));
                    }

                    $api_results = array(
                        LF_SOURCE_NAME  => $result->plugin_name,
                        LF_SOURCE_TITLE => $label,
                        'title'         => $col_title == -1 ? '<i>' . $LANG09[70] . '</i>' : $old_row[$col_title],
                        'description'   => $col_desc == -1 ? '<i>' . $LANG09[70] . '</i>' : $old_row[$col_desc],
                        'date'          => $col_date == -1 ? '&nbsp;' : $date,
                        'uid'           => $col_user == -1 ? '&nbsp;' : $old_row[$col_user],
                        'hits'          => $col_hits == -1 ? '0' : str_replace(',', '', $old_row[$col_hits]),
                    );
                    preg_match('/href="([^"]+)"/i', $api_results['title'], $links);
                    $api_results['url'] = empty($links) ? '#' : $links[1];

                    $obj->addResult($api_results);
                }
            }
        }

        // Find out how many plugins are on the old/new system
        if ($this->_verbose) {
            COM_errorLog('Search Plugins using APIv1: ' . $old_api . ' APIv2: ' . $new_api);
        }

        // Execute the queries
        $results = $obj->ExecuteQueries();

        // Searches are done, stop timer
        $searchTime = $searchTimer->stopTimer();

        $escQuery = htmlspecialchars($this->_query);
        $escQuery = str_replace(array('{', '}'), array('&#123;', '&#125;'), $escQuery);

        if ($this->_keyType == 'any' OR $this->_keyType == 'all') {
            $words = array_unique(explode(' ', $escQuery));
            $words = array_filter($words); // filter out empty strings
            $escQuery = implode(' ', $words);
            if ($this->_keyType == 'any') {
                $lang_search_op = $LANG09[57];
            } elseif ($this->_keyType == 'all') {
                $lang_search_op = $LANG09[56];
            }
            $searchQuery = str_replace(' ', "</b>' " . $lang_search_op . " '<b>", $escQuery);
            $searchQuery = "<b>'$searchQuery'</b>";
        } else {
            $searchQuery = $LANG09[55] . " '<b>$escQuery</b>'";
        }

        // Clean the query string so that sprintf works as expected
        $searchQuery = str_replace('%', '%%', $searchQuery);

        $retval = "{$LANG09[25]} $searchQuery. ";
        if (count($results) == 0) {
            $retval .= sprintf($LANG09[24], 0);
            $retval = '<p>' . $retval . '</p>' . LB;
            $retval .= '<p>' . $LANG09[13] . '</p>' . LB;
            $retval .= $this->showForm();
        } else {
            $retval .= $LANG09[64] . " ($searchTime {$LANG09[27]}). ";
            $retval .= str_replace('%', '%%', COM_createLink($LANG09[61], $url . 'refine'));
            $retval = '<p>' . $retval . '</p>' . LB;

            // Make GET params array
            $params_arr = array();
            $params_arr['query'] = urlencode($this->_query);
            if (!empty($this->_keyType)) {
                $params_arr['keyType'] = $this->_keyType;
            }
            if (!empty($this->_dateStart)) {
                $params_arr['datestart'] = $this->_dateStart;
            }
            if (!empty($this->_dateEnd)) {
                $params_arr['dateend'] = $this->_dateEnd;
            }
            if (!empty($this->_topic)) {
                $params_arr['topic'] = $this->_topic;
            }
            if (!empty($this->_author)) {
                $params_arr['author'] = $this->_author;
            }
            if ($this->_titlesOnly) {
                $params_arr['title'] = true;
            }
            $params_arr['type'] = $this->_type;
            $params_arr['mode'] = 'search';

            $retval = $obj->getFormattedOutput2($results, $LANG09[11], $retval, '',
                $_CONF['search_show_sort'], $_CONF['search_show_limit'], $params_arr);
        }

        return $retval;
    }

    /**
     * Callback function for the ListFactory class
     * This function gets called by the ListFactory class and formats
     * each row accordingly for example pulling usernames from the
     * users table and displaying a link to their profile.
     *
     * @param  bool  $preSort
     * @param  array $row An array of plain data to format
     * @return array      A reformatted version of the input array
     */
    public function searchFormatCallback($preSort, $row)
    {
        global $_CONF, $LANG09;

        if ($preSort) {
            if (is_array($row[LF_SOURCE_TITLE])) {
                $row[LF_SOURCE_TITLE] = implode($_CONF['search_separator'], $row[LF_SOURCE_TITLE]);
            }

            if (is_numeric($row['uid'])) {
                if (empty($this->_names[$row['uid']])) {
                    $this->_names[$row['uid']] = htmlspecialchars(COM_getDisplayName($row['uid']));
                    if ($row['uid'] > 1) {
                        $this->_names[$row['uid']] = COM_getProfileLink($row['uid'], $this->_names[$row['uid']]);
                    }
                }
                $row['uid'] = $this->_names[$row['uid']];
            }
        } else {
            $row[LF_SOURCE_TITLE] = COM_createLink($row[LF_SOURCE_TITLE],
                $this->_searchURL . '&amp;type=' . $row[LF_SOURCE_NAME] . '&amp;mode=search');

            if ($row['url'] != '#') {
                $row['url'] = ($row['url'][0] == '/' ? $_CONF['site_url'] : '') . $row['url'];
                if (isset($this->_url_rewrite[$row[LF_SOURCE_NAME]]) &&
                    $this->_url_rewrite[$row[LF_SOURCE_NAME]]
                ) {
                    $row['url'] = COM_buildUrl($row['url']);
                }
                if (isset($this->_append_query[$row[LF_SOURCE_NAME]]) &&
                    $this->_append_query[$row[LF_SOURCE_NAME]]
                ) {
                    if (!empty($this->_query)) {
                        $row['url'] .= (strpos($row['url'], '?') ? '&amp;' : '?') . 'query=' . urlencode($this->_query);
                    }
                }
            }

            $row['title'] = $this->_shortenText($this->_query, $row['title'], 8);
            $row['title'] = stripslashes(str_replace('$', '&#36;', $row['title']));
            $row['title'] = COM_createLink($row['title'], $row['url']);

            if ($row['description'] == 'LF_NULL') {
                $row['description'] = '<i>' . $LANG09[70] . '</i>';
            } elseif ($row['description'] != '<i>' . $LANG09[70] . '</i>') {
                $row['description'] = stripslashes($this->_shortenText($this->_query, PLG_replaceTags($row['description'], '', false, $row[LF_SOURCE_NAME], $row['id']), $this->_wordLength));
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
     * Returns a shorter version of the in putted text centred
     * around the keyword. The keyword is highlighted in bold.
     * Adds '...' to the beginning or the end of the shortened
     * version depending where the text was cut. Works on a
     * word basis, so long words wont get cut.
     *
     * @param string $keyword   The word to centre around
     * @param string $text      The complete text string
     * @param int    $num_words The number of words to display, best to use an odd number
     * @return string A short version of the text
     */
    private function _shortenText($keyword, $text, $num_words = 7)
    {
        $text = COM_getTextContent($text);
        $words = explode(' ', $text);
        $word_count = count($words);
        if ($word_count <= $num_words) {
            return COM_highlightQuery($text, $keyword, 'b');
        }

        $rt = '';
        $pos = stripos($text, $keyword);
        if ($pos !== false) {
            $pos_space = strpos($text, ' ', $pos);
            if (empty($pos_space)) {
                // Keyword at the end of text
                $key = $word_count - 1;
                $start = 0 - $num_words;
                $end = 0;
                $rt = '<b>...</b> ';
            } else {
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
                    $end = ($key + $m <= $word_count - 1)
                        ? $key
                        : $word_count - $m - 1;
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
        } else {
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
     * @param   string $needle   keyword(s), separated by spaces
     * @param   array  $haystack array of words to search through
     * @return  mixed            index in $haystack or false when not found
     */
    private function _arraySearch($needle, $haystack)
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
     * Returns the index of a heading that matches a
     * number of similar heading names. Used for backwards
     * compatibility in the doSearch() function.
     *
     * @param array $headings All the headings
     * @param array $find     An array of alternative headings to find
     * @return int The index of the alternative heading
     */
    private function _findColumn($headings, $find)
    {
        // We can't use normal for loops here as some of the
        // heading indexes start from 1, so foreach works better
        foreach ($find as $fh) {
            $j = 0;
            foreach ($headings as $h) {
                if (preg_match("/$fh/i", $h) > 0) {
                    return $j;
                }
                $j++;
            }
        }

        return -1;
    }

    /**
     * Converts the MySQL CONCAT function to the Postgres equivalents
     *
     * @param  string $sql The SQL to convert
     * @return string      PostgreSQL friendly SQL
     */
    private function _convertSql($sql)
    {
        global $_DB_dbms;

        if ($_DB_dbms === 'pgsql') {
            $callBack = function ($match) {
                return preg_replace('/,?(\'[^\']+\'|[^,]+),/i', '\\1 || ', $match[1]);
            };

            if (is_string($sql)) {
                $sql = preg_replace_callback("/CONCAT\(([^\)]+)\)/i", $callBack, $sql);
            } elseif (is_array($sql)) {
                $sql['pgsql'] = preg_replace_callback("/CONCAT\(([^\)]+)\)/i", $callBack, $sql['pgsql']);
            }
        }

        return $sql;
    }
}
