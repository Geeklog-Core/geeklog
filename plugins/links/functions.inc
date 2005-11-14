<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | links Plugin 1.0                                                          |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the links      |
// | Plugins' PHP files.                                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Tom Willett      - twillett@users.sourceforge.net                |
// |          Blaine Lang      - langmail@sympatico.ca                         |
// |          Dirk Haun        - dirk@haun-online.de                           |
// |          Trinity Bays     - trinity@steubentech.com                       |
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
// $Id: functions.inc,v 1.35 2005/11/14 10:36:02 ospiess Exp $

$langfile = $_CONF['path'] . 'plugins/links/language/'
          . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    require_once ($langfile);
} else {
    require_once ($_CONF['path'] . 'plugins/links/language/english.php');
}

require_once ($_CONF['path'] . 'plugins/links/config.php');

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
*/
function plugin_getmenuitems_links()
{
    global $_CONF, $LANG_LINKS;

    $menuitems[$LANG_LINKS[114]] = $_CONF['site_url'] . '/links/index.php';

    return $menuitems;
}

function plugin_whatsnewsupported_links()
{
    global $_TABLES, $_LI_CONF, $LANG_LINKS, $WHATS_NEW_LAST;

    $hidewhatsnew = $_LI_CONF['hidenewlinks'];
    if ( $hidewhatsnew == 0 ) {
        $retval = array ( $LANG_LINKS[84],
                          '<small>' . COM_formatTimeString( $WHATS_NEW_LAST,
                                            $_LI_CONF['newlinksinterval'] )
                          . '</small>'
                        );
    } else {
        $retval = false;
    }

    return $retval;
}

function plugin_getwhatsnew_links()
{
    global $_CONF, $_TABLES, $_USER, $_LI_CONF, $LANG_LINKS;

    $retval = '';

    // Get newest links
    $sql = "SELECT lid,title FROM {$_TABLES['links']} WHERE (date >= (date_sub(NOW(), INTERVAL {$_LI_CONF['newlinksinterval']} SECOND)))" . COM_getPermSQL( 'AND' ) . ' ORDER BY date DESC LIMIT 15';
    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    if( $nrows > 0 )
    {
        $newlinks = array();
        for( $x = 0; $x < $nrows; $x++ )
        {
            $A = DB_fetchArray( $result );
            $A['title'] = stripslashes( $A['title'] );

            // redirect link via portal.php so we can count the clicks
            $lcount = COM_buildUrl( $_CONF['site_url']
                    . '/links/portal.php?what=link&amp;item=' . $A['lid'] );

            // Trim the length if over 16 characters
            $itemlen = strlen( $A['title'] );
            if( $itemlen > 16 )
            {
                $newlinks [] = '<a href="' . $lcount . '" title="'
                    . $A['title'] . '">' . substr( $A['title'], 0, 16 )
                    . '...</a>' . LB;
            }
            else
            {
                $newlinks[] = '<a href="' . $lcount . '">'
                    . substr( $A['title'], 0, $itemlen ) . '</a>' . LB;
            }
        }

        $retval .= COM_makeList( $newlinks, 'list-new-links' );
    }
    else
    {
        $retval .= $LANG_LINKS[88] . '<br>' . LB;
    }

    return $retval;
}

/**
* Implements the [link:] autotag.
*
*/
function plugin_autotags_links ($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES;

    if ($op == 'tagname' ) {
        return 'link';
    } else if ($op == 'parse') {
        $lid = COM_applyFilter ($autotag['parm1']);
        $url = COM_buildUrl ($_CONF['site_url'] . '/links/portal.php?what=link&item='
                             . $lid);
        if (empty ($autotag['parm2'])) {
            $linktext = stripslashes (DB_getItem ($_TABLES['links'],
                                      'title', "lid = '$lid'"));
        } else {
            $linktext = $autotag['parm2'];
        }
        $link = '<a href="' . $url . '">' . $linktext . '</a>';
        $content = str_replace ($autotag['tagstr'], $link, $content);

        return $content;
    }
}

/**
* Geeklog is checking to see if this plugin supports comments, tell it no.
*
* NOTE: to support comments you must used the same date/time based ID for your
* widget.  In other words, to make primary keys for your plugin you should call
* makesid().  Comments are keyed off of that...it is a limitation on how Geeklog
* does comments.
*
*/
function plugin_commentsupport_links()
{
    // links will not use comments
    return false;
}


/**
* Called by the plugin Editor to display the current plugin code version
* This may be different then the version installed and registered currently.
* If newer then you may want to run the update
*/
function plugin_chkVersion_links ()
{
    global $_LI_CONF;

    return $_LI_CONF['version'];
}

/**
* Helper function: count number of links and total number of clicks
*
* @return   array(number of links, number of clicks);
*
*/
function LINKS_countLinksAndClicks ()
{
    global $_TABLES;

    $result = DB_query ("SELECT COUNT(*) AS count,SUM(hits) AS clicks FROM {$_TABLES['links']}" . COM_getPermSQL ());
    $A = DB_fetchArray($result);
    $total_links = $A['count'];
    $total_clicks = $A['clicks'];
    if (empty ($total_clicks)) {
        $total_clicks = 0;
    }

    return array ($total_links, $total_clicks);
}

/**
* Shows the statistics for the links plugin on stats.php.
* If $showsitestats is 1 then we are to only print the overall stats in the
* 'site statistics box' otherwise we show the detailed stats
*
* @param    int     showsitestate   Flag to let us know which stats to get
*/
function plugin_showstats_links ($showsitestats)
{
    global $_CONF, $_TABLES, $LANG_LINKS_STATS;

    $retval = '';

    $result = DB_query("SELECT lid,url,title,hits FROM {$_TABLES['links']} WHERE (hits > 0)" . COM_getPermSQL ('AND') . " ORDER BY hits DESC LIMIT 10");
    $nrows  = DB_numRows ($result);
    if ($nrows > 0) {
        $header_arr = array(
            array('text' => $LANG_LINKS_STATS['stats_page_title'], 'field' => 'sid'),
            array('text' => $LANG_LINKS_STATS['stats_hits'], 'field' => 'links'),
        );
        $data_arr = array();
        $text_arr = array('has_menu'     =>  false,
                          'title'        => $LANG_LINKS_STATS['stats_headline'],
        );
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $A['title'] = stripslashes(str_replace('$','&#36;',$A['title']));
            $A['sid'] = "<a href=\"" . COM_buildUrl ($_CONF['site_url']
                      . "/links/portal.php?what=link&amp;item={$A['lid']}"). "\">{$A['title']}</a>";
            $A['links'] = COM_NumberFormat ($A['links']);
            $data_arr[$i] = $A;
        }
        $display .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);
    } else {
        $display .= COM_startBlock($LANG_LINKS_STATS['stats_headline']);
        $display .= $LANG_LINKS_STATS['stats_no_hits'];
        $display .= COM_endBlock();
    }

    return $display;
}

/**
* New stats plugin API function for proper integration with the site stats
*
* @return   array(item text, item count);
*
*/
function plugin_statssummary_links ()
{
    global $LANG_LINKS_STATS;

    list($total_links, $total_clicks) = LINKS_countLinksAndClicks ();

    $item_count = COM_NumberFormat ($total_links)
                . ' (' . COM_NumberFormat ($total_clicks) . ')';


    return array ($LANG_LINKS_STATS['links'], $item_count);
}

/**
* Geeklog is asking us to provide any new items that show up in the type
* drop-down on search.php.  Let's users search for links.
*
*/
function plugin_searchtypes_links()
{
    global $LANG_LINKS;

    $tmp['links'] = $LANG_LINKS[14];

    return $tmp;
}


/**
* This searches for links matching the user query and returns an array of
* for the header and table rows back to search.php where it will be formated and
* printed
*
* @param    string  $query      Keywords user is looking for
* @param    date    $datestart  Start date to get results for
* @param    date    $dateend    End date to get results for
* @param    string  $topic      The topic they were searching in
* @param    string  $type       Type of items they are searching, or 'all'
* @param    int     $author     Get all results by this author
* @param    string  $keyType    search key type: 'all', 'phrase', 'any'
* @param    int     $page       page number of current search
* @param    int     $perpage    number of results per page
*
*/
function plugin_dopluginsearch_links($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $_CONF, $_TABLES, $LANG_LINKS_SEARCH;

    if (empty($type)) {
        $type = 'all';
    }

    // Bail if we aren't supppose to do our search
    if ($type <> 'all' AND $type <> 'links') {
        $plugin_results = new Plugin();
        $plugin_results->plugin_name = 'links';
        $plugin_results->searchlabel = $LANG_LINKS_SEARCH['results'];
        return $plugin_results;
    }

    $select = "SELECT *,UNIX_TIMESTAMP(date) AS day";
    $sql = " FROM {$_TABLES['links']} WHERE date <> 1 ";

    if (!empty ($query)) {
        if ($keyType == 'phrase') {
            $mysearchterm = addslashes ($query);
            $sql .= " AND (description LIKE '%$mysearchterm%')"
                 . " OR (title LIKE '%$mysearchterm%')";
        } else if ($keyType == 'all') {
            $mywords = explode (' ', $query);
            $sql .= ' AND (';
            $tmp = '';
            foreach ($mywords AS $mysearchterm) {
                $mysearchterm = addslashes (trim ($mysearchterm));
                if (!empty ($mysearchterm)) {
                    $tmp .= "(description LIKE '%$mysearchterm%')"
                         . " OR (title LIKE '%$mysearchterm%') AND ";
                }
            }
            $tmp = substr ($tmp, 0, strlen ($tmp) - 5);
            $sql .= $tmp . ')';
        } else if ($keyType == 'any') {
            $mywords = explode (' ', $query);
            $sql .= ' AND (';
            $tmp = '';
            foreach ($mywords AS $mysearchterm) {
                $mysearchterm = addslashes (trim ($mysearchterm));
                if (!empty ($mysearchterm)) {
                    $tmp .= "(description LIKE '%$mysearchterm%')"
                         . " OR (title LIKE '%$mysearchterm%') OR ";
                }
            }
            $tmp = substr ($tmp, 0, strlen ($tmp) - 4);
            $sql .= $tmp . ')';
        } else {  // quick search
            $mysearchterm = addslashes ($query);
            $sql .= " AND (description LIKE '%$mysearchterm%')"
                 . " OR (title LIKE '%$mysearchterm%')";
        }
    }

    if (!empty ($datestart) && !empty ($dateend)) {
        $delim = substr ($datestart, 4, 1);
        $DS = explode ($delim, $datestart);
        $DE = explode ($delim, $dateend);
        $startdate = mktime (0, 0, 0, $DS[1], $DS[2], $DS[0]);
        $enddate = mktime (23, 59, 59, $DE[1], $DE[2], $DE[0]);
        $sql .= " AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate')";
    }

    if (!empty ($author)) {
        $sql .= "AND (owner_id = '$author')";
    }
    $sql .= " ORDER BY date DESC ";
    $l = ($perpage * $page) - $perpage;
    $sql .= 'LIMIT ' . $l . ',' . $perpage;

    // Perform search
    $result = DB_query ($select . $sql);
    $mycount = DB_numRows ($result);
    $result_count = DB_query ('SELECT COUNT(*)' . $sql);
    $B = DB_fetchArray ($result_count, true);

    $plugin_results = new Plugin();
    $plugin_results->plugin_name = 'links';
    $plugin_results->searchlabel = $LANG_LINKS_SEARCH['results'];
    $plugin_results->addSearchHeading ($LANG_LINKS_SEARCH['title']);
    $plugin_results->addSearchHeading ($LANG_LINKS_SEARCH['date']);
    $plugin_results->addSearchHeading ($LANG_LINKS_SEARCH['author']);
    $plugin_results->addSearchHeading ($LANG_LINKS_SEARCH['hits']);
    $plugin_results->num_searchresults = 0;
    $plugin_results->num_itemssearched = $B[0];
    $plugin_results->supports_paging = true;

    // NOTE if any of your data items need to be links then add them here!
    // make sure data elements are in an array and in the same order as your
    // headings above!
    for ($i = 0; $i < $mycount; $i++) {
        $A = DB_fetchArray ($result);

        if (SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon'])) {
            $thetime = COM_getUserDateTimeFormat ($A['day']);
            $A['title'] = stripslashes ($A['title']);
            $submitter = COM_getDisplayName ($A['owner_id']);
            if ($A['owner_id'] > 1) {
                $profile = '<a href="' . $_CONF['site_url']
                         . '/users.php?mode=profile&amp;uid=' . $A['owner_id']
                         . '">' . $submitter . '</a>';
            } else {
                $profile = $submitter;
            }
            $linkUrl = COM_buildURL ($_CONF['site_url']
                                     . '/links/index.php?page=' . $A['lid']);
            $row = array ('<a href="' . $linkUrl . '">' . $A['title'] . '</a>',
                    $thetime[0], $profile, COM_NumberFormat ($A['hits']));
            $plugin_results->addSearchResult ($row);
            $plugin_results->num_searchresults++;
        }
    }

    return $plugin_results;
}


/**
* This will put an option for links in the command and control block on
* moderation.php
*
*/
function plugin_cclabel_links()
{
    global $_CONF, $LANG_LINKS;

    if (SEC_hasRights ('links.edit')) {
        return array ($LANG_LINKS[14],
                      $_CONF['site_admin_url'] . '/plugins/links/index.php',
                      plugin_geticon_links ());
    }

    return false;
}

/**
* returns the administrative option for this plugin
*
*/
function plugin_getadminoption_links()
{
    global $_CONF, $_TABLES, $LANG_LINKS;

    if (SEC_hasRights ('links.edit,links.delete', 'OR')) {
        $total_links = DB_getItem ($_TABLES['links'], 'COUNT(*)',
                                   COM_getPermSql (''));

        return array ($LANG_LINKS[14],
                      $_CONF['site_admin_url'] . '/plugins/links/index.php',
                      $total_links);
    }
}

/**
* A user is about to be deleted. Update ownership of any links owned
* by that user or delete them.
*
* @param   uid   int   User id of deleted user
*
*/
function plugin_user_delete_links ($uid)
{
    global $_TABLES, $_LI_CONF;

    if (DB_count ($_TABLES['links'], "owner_id = $uid") == 0) {
        return;
    }

    if ($_LI_CONF['delete_links'] == 1) {
        // delete the pages
        DB_query ("DELETE FROM {$_TABLES['links']} WHERE owner_id = $uid");
    } else {
        // assign ownership to a user from the Root group
        $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id',
                                 "grp_name = 'Root'");
        $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
        $A = DB_fetchArray ($result);
        $rootuser = $A['ug_uid'];
        DB_query ("UPDATE {$_TABLES['links']} SET owner_id = $rootuser WHERE owner_id = $uid");
    }
}

/*
* Do we support feeds?
*/
function plugin_getfeednames_links()
{
    global $_TABLES;

    $feeds = array ();

    $result = DB_query ("SELECT lid,category FROM {$_TABLES['links']} GROUP BY category ORDER BY category ASC");
    $num = DB_numRows ($result);

    if ($num > 0) {
        $feeds[] = array ('id' => 'all', 'name' => 'all categories');
    }

    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray ($result);
        $feeds[] = array ('id' => $A['category'], 'name' => $A['category']);
    }

    return $feeds;
}

/*
* Provide feed data
*/
function plugin_getfeedcontent_links ($feed, &$link, &$update)
{
    global $_CONF, $_TABLES;

    $result = DB_query( "SELECT topic,limits,content_length FROM {$_TABLES['syndication']} WHERE fid = '$feed'" );
    $S = DB_fetchArray( $result );


    $result = DB_query( "SELECT lid,owner_id,title,description,UNIX_TIMESTAMP(date) AS modified FROM " . $_TABLES['links'] . links_buildSql ($S['topic'], $S['limits']) );

    $content = array();
    $lids = array();
    $nrows = DB_numRows( $result );

    for( $i = 0; $i < $nrows; $i++ )
    {
        $row = DB_fetchArray( $result );
        $lids[] = $row['lid'];

        $linktitle = stripslashes( $row['title'] );
        $linklink = COM_buildUrl( $_CONF['site_url']
                  . '/links/portal.php?what=link&item=' . $row['lid'] );

        $content[] = array( 'title'   => $linktitle,
                            'summary' => $linkdesc,
                            'link'    => $linklink,
                            'uid'     => $row['owner_id'],
                            'author'  => COM_getDisplayName( $row['owner_id'] ),
                            'date'    => $row['modified'],
                            'format'  => 'plaintext'
                          );
    }

    $link = $_CONF['site_url'] . '/links/index.php';
    $update = implode( ',', $lids );

    return $content;
}

function links_buildSql ($category, $limits)
{
    $where = '';
    if ($category != 'all') {
        $where = "category='" . $category . "'";
    }

    $limitsql = '';
    if (!empty ($limits)) {
        if (substr ($limits, -1) == 'h') { // last xx hours
            $limitsql = '';
            $hours = substr ($limits, 0, -1);
            if (!empty ($where)) {
                $where .= ' AND ';
            }
            $where .= "date >= DATE_SUB(NOW(),INTERVAL $hours HOUR)";
        } else {
            $limitsql = ' LIMIT ' . $limits;
        }
    }
    else
    {
        $limitsql = ' LIMIT 10';
    }

    if (!empty ($where)) {
        $where = ' WHERE ' . $where;
    }

    $sql = $where . ' ORDER BY date DESC' . $limitsql;

    return $sql;
}

/**
* Checking if links feeds are up to date
*
* @param    int     $feed           id of feed to be checked
* @param    string  $topic          topic (actually: category)
* @param    string  $update_data    data describing current feed contents
* @param    string  $limit          number of entries or number of hours
* @param    string  $updated_type   (optional) type of feed to be updated
* @param    string  $updated_topic  (optional) feed's "topic" to be updated
* @param    string  $updated_id     (optional) id of entry that has changed
*
*/
function plugin_feedupdatecheck_links ($feed, $topic, $update_data, $limit, $updated_type = '', $updated_topic = '', $updated_id = '')
{
    global $_TABLES;

    $is_current = true;

    if ($updated_type != 'links') {
        // we're not interested
        $updated_type = '';
        $updated_topic = '';
        $updated_id = '';
    }

    $sql = "SELECT lid FROM {$_TABLES['links']}" . links_buildSql ($category, $limits);
    $result = DB_query ($sql);
    $num = DB_numRows ($result);

    $lids = array ();
    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray ($result);

        if ($A['lid'] == $updated_id) {
            // this feed has to be updated - no further checks needed
            return false;
        }

        $lids[] = $A['lid'];
    }
    $current = implode (',', $lids);

    return ($current != $update_data) ? false : true;
}

/**
* Removes the datastructures for this plugin from the Geeklog database
*
* This may get called by the install routine to undo anything done to this
* point.
*
* @steps   Array    Holds all the steps that have been completed by the install
*
*/
function plugin_uninstall_links ()
{
    global $_TABLES, $_CONF;

    // Uninstalls the links plugin

    // Remove the linksubmisssion table
    COM_errorLog ('Dropping linksubmission table', 1);
    DB_query ("DROP TABLE {$_TABLES['linksubmission']}");
    COM_errorLog ('...success', 1);

    // Remove the links table
    COM_errorLog ('Dropping links table', 1);
    DB_query ("DROP TABLE {$_TABLES['links']}");
    COM_errorLog ('...success', 1);

    // Remove feed files
    COM_errorLog ('removing links feed files', 1);
    $sql = "SELECT filename FROM {$_TABLES['syndication']} WHERE type = 'links';";
    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );
    COM_errorLog ($nrows. ' files stored in table.', 1);
    if ( $nrows > 0 ) {
        for ( $i = 0; $i < $nrows; $i++ ) {
            $fcount = $i + 1;
            $A = DB_fetchArray( $result );
            $fullpath = SYND_getFeedPath( $A[0] );
            if ( file_exists( $fullpath ) ) {
                unlink ($fullpath);
                COM_errorLog ("removed file $fcount of $nrows: $fullpath", 1);
            } else {
                COM_errorLog ("cannot remove file $fcount of $nrows, it does not exist! ($fullpath)", 1);
            }
        }
    }
    COM_errorLog ('...success', 1);

    // Remove Links Feeds from syndiaction table
    COM_errorLog ('removing links feeds from table', 1);
    DB_query ("DELETE FROM {$_TABLES['syndication']} WHERE `type` = 'links'");
    COM_errorLog ('...success', 1);

    // Remove security for this plugin

    // Remove the links admin group
    $grp_id = DB_getItem ($_TABLES['groups'], 'grp_id',
                          "grp_name = 'Links Admin'");

    if (!empty ($grp_id)) {
        COM_errorLog ('Attempting to remove the Links Admin group', 1);
        DB_query ("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id");
        COM_errorLog ('...success', 1);
    }

    // Remove related features
    $edit_id = DB_getItem ($_TABLES['features'], 'ft_id',
                           "ft_name = 'links.edit'");
    $moderate_id = DB_getItem ($_TABLES['features'], 'ft_id',
                               "ft_name = 'links.moderate'");
    $submit_id = DB_getItem ($_TABLES['features'], 'ft_id',
                             "ft_name = 'links.submit'");

    // Remove access to those features
    if (!empty ($edit_id)) {
        COM_errorLog ('Attempting to remove links.edit rights from all groups' ,1);
        DB_query ("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $edit_id");
        COM_errorLog ('...success', 1);
    }

    if (!empty ($moderate_id)) {
        COM_errorLog ('Attempting to remove links.moderate rights from all groups', 1);
        DB_query ("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $moderate_id");
        COM_errorLog ('...success', 1);
    }

    if (!empty ($submit_id)) {
        COM_errorLog ('Attempting to remove links.submit rights from all groups', 1);
        DB_query ("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $submit_id");
        COM_errorLog ('...success', 1);
    }

    // Remove Links Admin group from all other groups
    if (!empty ($grp_id)) {
        COM_errorLog ('Attempting to Links Admin group from all groups.', 1);
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id");
        COM_errorLog ('...success', 1);
    }

    // remove features
    if (!empty ($edit_id)) {
        COM_errorLog ('Attempting to remove the links.edit feature', 1);
        DB_query ("DELETE FROM {$_TABLES['features']} WHERE ft_id = $edit_id");
        COM_errorLog ('...success', 1);
    }

    if (!empty ($moderate_id)) {
        COM_errorLog ('Attempting to remove the links.moderate feature', 1);
        DB_query ("DELETE FROM {$_TABLES['features']} WHERE ft_id = $moderate_id");
        COM_errorLog ('...success', 1);
    }

    if (!empty ($submit_id)) {
        COM_errorLog ('Attempting to remove the links.submit feature', 1);
        DB_query ("DELETE FROM {$_TABLES['features']} WHERE ft_id = $submit_id");
        COM_errorLog ('...success', 1);
    }

    // Unregister the plugin with Geeklog
    // Always attempt to remove these entries or lib-common.php would still
    // try and read our functions.inc file ...
    COM_errorLog ('Attempting to unregister the plugin from Geeklog', 1);
    DB_query ("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'links'");
    COM_errorLog ('...success',1);

    COM_errorLog ('Finished uninstalling the Links plugin.', 1);

    return true;
}

/**
*
* Counts the items that are submitted
*
*/
function plugin_submissioncount_links()
{
   global $_TABLES;

   return DB_count ($_TABLES['linksubmission']);
}

/**
*
* Checks that the current user has the rights to moderate the
* plugin, returns true if this is the case, false otherwise
*
* @return        boolean       Returns true if moderator
*
*/
function plugin_ismoderator_links()
{
    return SEC_hasRights ('links.moderate');
}


/**
* Returns SQL & Language texts to moderation.php
*/
function plugin_itemlist_links()
{
    global $_TABLES, $LANG_LINKS_SUBMIT;

    if (plugin_ismoderator_links()) {
        $plugin = new Plugin();
        $plugin->submissionlabel = $LANG_LINKS_SUBMIT[11];
        $plugin->submissionhelpfile = 'cclinksubmission.html';
        $plugin->getsubmissionssql = "SELECT lid AS id,title,category,url FROM {$_TABLES['linksubmission']} ORDER BY title ASC";
        $plugin->addSubmissionHeading($LANG_LINKS_SUBMIT[8]);
        $plugin->addSubmissionHeading($LANG_LINKS_SUBMIT[10]);
        $plugin->addSubmissionHeading($LANG_LINKS_SUBMIT[9]);

        return $plugin;
    }
}

/**
* returns list of moderation values
*
* The array returned contains (in order): the row 'id' label, main plugin
* table, moderation fields (comma seperated), and plugin submission table
*
* @return       array        Returns array of useful moderation values
*
*/
function plugin_moderationvalues_links()
{
    global $_TABLES;

    return array ('lid',
                  $_TABLES['links'],
                  'lid,category,url,description,title,date',
                  $_TABLES['linksubmission']);
}


/**
* Performs plugin exclusive work for items approved by moderation
*
* While moderation.php handles the actual move from linkssubmission
* to links tables, within the function we handle all other approval
* relate tasks
*
* @param      string       $id      Identifying string
* @return     string       Any wanted HTML output
*
*/
function plugin_moderationapprove_links ($id)
{
    global $_TABLES, $_USER, $_GROUPS, $_LI_CONF;

    $A = array ();
    SEC_setDefaultPermissions ($A, $_LI_CONF['default_permissions']);

    // Since the linksubmission table does not contain fields for the owner
    // and group, we set those to the current user. Also set the default
    // permissions as specified in the plugin's config.php
    if (isset ($_GROUPS['Links Admin'])) {
        $group_id = $_GROUPS['Links Admin'];
    } else {
        $group_id = SEC_getFeatureGroup ('links.moderate');
    }
    DB_query ("UPDATE {$_TABLES['links']} SET owner_id = '{$_USER['uid']}', group_id = '$group_id', perm_owner = '{$A['perm_owner']}', perm_group = '{$A['perm_group']}', perm_members = '{$A['perm_members']}', perm_anon = '{$A['perm_anon']}' WHERE lid = '$id'");

    return '';
}

/**
* Performs plugin exclusive work for items deleted by moderation
*
* While moderation.php handles the actual removal from <plugin>submission
* table, within this function we handle all other deletion
* relate tasks
*
* @param      string       $id      Identifying string
* @return     string       Any wanted HTML output
*
*/
function plugin_moderationdelete_links($id)
{
    global $_TABLES;

    // these tables should not contain any rows with ml_id = $id
    // this is done 'just in case'
    DB_delete ($_TABLES['linksubmission'], 'lid', $id);

    return '';
}

/**
* Shows link submission form
*
*/
function plugin_savesubmission_links($A)
{
    global $_CONF, $_TABLES, $LANG12;

    if (!empty ($A['title']) && !empty ($A['description']) &&
                !empty ($A['url'])) {
        $retval = plugin_save_submit_links ($A);
    } else {
        $retval .= COM_siteHeader()
            . COM_startBlock ($LANG12[22], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[23]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
            . submissionform($type)
            . COM_siteFooter ();
    }

    return $retval;
}

/**
* Shows link submission form
*
*/
function plugin_submit_links()
{
    global $_CONF, $_TABLES, $LANG_LINKS_SUBMIT, $LANG12;

    $retval = COM_startBlock ($LANG_LINKS_SUBMIT[1], 'submitlink.html');

    $linkform = new Template($_CONF['path'] . '/plugins/links/templates');
    $linkform->set_file('linkform', 'submitlink.thtml');
    $linkform->set_var('site_url', $_CONF['site_url']);
    $linkform->set_var('layout_url', $_CONF['layout_url']);
    $linkform->set_var('lang_title', $LANG12[10]);
    $linkform->set_var('lang_link', $LANG_LINKS_SUBMIT[2]);
    $linkform->set_var('lang_category', $LANG_LINKS_SUBMIT[3]);
    $linkform->set_var('link_category_options',
        COM_optionList($_TABLES['links'],'DISTINCT category,category', '', 0));
    $linkform->set_var('lang_other', $LANG_LINKS_SUBMIT[4]);
    $linkform->set_var('lang_ifother', $LANG_LINKS_SUBMIT[5]);
    $linkform->set_var('lang_description', $LANG12[15]);
    $linkform->set_var('lang_htmlnotallowed', $LANG12[35]);
    $linkform->set_var('lang_submit', $LANG12[8]);
    $linkform->set_var('max_url_length', 255);
    $linkform->parse('theform', 'linkform');
    $retval .= $linkform->finish($linkform->get_var('theform'));
    $retval .= COM_endBlock();

    return $retval;
}

/**
* Saves a link submission
*
* @param    array   $A  Data for that submission
* @return   string      HTML redirect
*
*/
function plugin_save_submit_links ($A)
{
    global $_CONF, $_TABLES, $_USER, $_LI_CONF, $LANG_LINKS_SUBMIT;

    $retval = '';

    $A['category'] = strip_tags (COM_stripslashes ($A['category']));
    $A['categorydd'] = strip_tags (COM_stripslashes ($A['categorydd']));
    if ($A['categorydd'] != $LANG_LINKS_SUBMIT[4] && !empty ($A['categorydd'])) {
        $A['category'] = $A['categorydd'];
    } else if ($A['categorydd'] != $LANG_LINKS_SUBMIT[4]) {
        $retval .= COM_startBlock ($LANG_LINKS_SUBMIT[6], '',
                       COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG_LINKS_SUBMIT[7]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                . submissionform ($type)
                . COM_siteFooter ();

        return $retval;
    }

    // pseudo-formatted link description for the spam check
    $spamcheck = '<p><a href="' . $A['url'] . '">' . $A['title'] . '</a> ('
               . $A['category'] . ', ' . $A['categorydd'] . ')<br>'
               . $A['description'] . '</p>';
    $result = PLG_checkforSpam ($spamcheck, $_CONF['spamx']);
    if ($result > 0) {
        COM_updateSpeedlimit ('submit');
        COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
    }

    $A['category'] = addslashes ($A['category']);
    $A['description'] = addslashes (htmlspecialchars (COM_checkWords ($A['description'])));
    $A['title'] = addslashes (strip_tags (COM_checkWords ($A['title'])));

    $A['url'] = strip_tags ($A['url']);
    if (!empty ($A['url'])) {
        $pos = strpos ($A['url'], ':');
        if ($pos === false) {
            $A['url'] = 'http://' . $A['url'];
        } else {
            $prot = substr ($A['url'], 0, $pos + 1);
            if (($prot != 'http:') && ($prot != 'https:')) {
                $A['url'] = 'http:' . substr ($A['url'], $pos + 1);
            }
        }
        $A['url'] = addslashes ($A['url']);
    }
    $A['lid'] = addslashes (COM_makeSid ());
    COM_updateSpeedlimit ('submit');

    if (($_LI_CONF['linksubmission'] == 1) && !SEC_hasRights ('links.submit')) {
        $result = DB_save ($_TABLES['linksubmission'],
                    'lid,category,url,description,title,date',
                    "{$A['lid']},'{$A['category']}','{$A['url']}','{$A['description']}','{$A['title']}',NOW()");

        if (isset ($_LI_CONF['notification']) && ($_LI_CONF['notification']==1)) {
            LINKS_sendNotification ($_TABLES['linksubmission'], $A);
        }

        $retval = COM_refresh ($_CONF['site_url'] . '/index.php?msg=1&plugin=links');
    } else { // add link directly
        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            $owner_id = $_USER['uid'];
        } else {
            $owner_id = 1; // anonymous user
        }
        $result = DB_save ($_TABLES['links'], 'lid,category,url,description,title,date,owner_id', "{$A['lid']},'{$A['category']}','{$A['url']}','{$A['description']}','{$A['title']}',NOW(),$owner_id");
        if (isset ($_LI_CONF['notification']) && ($_LI_CONF['notification']==1)) {
            LINKS_sendNotification ($_TABLES['links'], $A);
        }
        COM_rdfUpToDateCheck ();

        $retval = COM_refresh ($_CONF['site_url'] . '/index.php?msg=4&plugin=links');
    }

    return $retval;
}

/**
* Send an email notification for a new submission.
*
* @param    string  $table  Table where the new submission can be found
* @param    array   $A      submission data
*
*/
function LINKS_sendNotification ($table, $A)
{
    global $_CONF, $_TABLES, $LANG_LINKS, $LANG_LINKS_SUBMIT,
           $LANG08;
    $title = stripslashes ($A['title']);
    $description = stripslashes ($A['description']);

    $mailbody = "$LANG_LINKS_SUBMIT[8]: $title\n"
              . "$LANG_LINKS_SUBMIT[9]: <{$A['url']}>\n"
              . "$LANG_LINKS_SUBMIT[3]: {$A['category']}\n\n"
              . $description . "\n\n";
    if ($table == $_TABLES['linksubmission']) {
        $mailbody .= "$LANG_LINKS[10] <{$_CONF['site_admin_url']}/moderation.php>\n\n";
    } else {
        $mailbody .= "$LANG_LINKS[114] <{$_CONF['site_url']}/links/index.php?category=" . urlencode ($A['category']) . ">\n\n";
    }
    $mailsubject = $_CONF['site_name'] . ' ' . $LANG_LINKS_SUBMIT[11];

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
* Returns the URL of the plugin's icon
*
* @return   string      URL of the icon
*
*/
function plugin_geticon_links ()
{
    global $_CONF;

    return $_CONF['site_url'] . '/links/images/links.png';
}

function plugin_getListField_links($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_ADMIN, $LANG_ACCESS;
    $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
    if ($access > 0) {
        switch($fieldname) {
            case "edit":
                $retval = "<a href=\"{$_CONF[site_admin_url]}/plugins/links/index.php?mode=edit&amp;lid={$A['lid']}\">{$icon_arr['edit']}</a>";
                break;
            case "access":
                if ($access == 3) {
                   $retval = $LANG_ACCESS['edit'];
                } else {
                   $retval = $LANG_ACCESS['readonly'];
                }
                break;
            case "title":
                $title = stripslashes($A['title']);
                $retval = "<a href=\"{$A['url']}\">$title</a>";
                break;
            default:
                $retval = $fieldvalue;
                break;
        }
    }
    return $retval;
}

?>
