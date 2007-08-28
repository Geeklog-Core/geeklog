<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Links Plugin 1.0.1  functions.inc                                         |
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
// $Id: functions.inc,v 1.82 2007/08/28 07:52:25 ospiess Exp $


/**
 * This file does two things: 1) it implements the necessary Geeklog Plugin
 * API method and 2) implements all the common code needed by the links
 * Plugins' PHP files.
 *
 * @package Links
 * @filesource
 * @version 1.0.1
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2006
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Trinity Bays <trinity93 AT steubentech DOT com>
 * @author Tony Bibbs <tony AT tonybibbs DOT com>
 * @author Tom Willett <tom AT pigstye DOT net>
 * @author Blaine Lang <langmail AT sympatico DOT ca>
 * @author Dirk Haun <dirk AT haun-online DOT de>
 *
 */


if (strpos ($_SERVER['PHP_SELF'], 'functions.inc') !== false) {
    die ('This file can not be used on its own.');
}

$langfile = $_CONF['path'] . 'plugins/links/language/'
          . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    require_once ($langfile);
} else {
    require_once ($_CONF['path'] . 'plugins/links/language/english.php');
}

require_once ($_CONF['path'] . 'plugins/links/config.php');

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementation                                         |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
* @return   mixed   menu entry, or boolean false if disabled / hidden
*
*/
function plugin_getmenuitems_links()
{
    global $_CONF, $_USER, $_LI_CONF, $LANG_LINKS;

    $anon = (empty ($_USER['uid']) || ($_USER['uid'] <= 1)) ? true : false;
    if (($_LI_CONF['hidelinksmenu'] == 1) || ($anon &&
                ($_CONF['loginrequired'] || $_LI_CONF['linksloginrequired']))) {
        return false;
    }

    $menuitems[$LANG_LINKS[114]] = $_CONF['site_url'] . '/links/index.php';

    return $menuitems;
}

/**
* Return headlines for New Links section in the What's New block, if enabled
*
* @return   mixed       array(headline, byline), or boolean false is disabled
*
*/
function plugin_whatsnewsupported_links()
{
    global $_TABLES, $_LI_CONF, $LANG_LINKS, $LANG_WHATSNEW;

    if ( $_LI_CONF['hidenewlinks'] == 0 ) {
        $retval = array( $LANG_LINKS[84],
                         COM_formatTimeString( $LANG_WHATSNEW['new_last'],
                                               $_LI_CONF['newlinksinterval'] )
                       );
    } else {
        $retval = false;
    }

    return $retval;
}

/**
* Return new links for the What's New block
*
* @return   string  HTML list of new links
*
*/
function plugin_getwhatsnew_links()
{
    global $_CONF, $_TABLES, $_USER, $_LI_CONF, $LANG_LINKS;

    $retval = '';

    // Get newest links
    $sql = "SELECT lid,title FROM {$_TABLES['links']} WHERE (date >= (DATE_SUB(NOW(), INTERVAL {$_LI_CONF['newlinksinterval']} SECOND)))" . COM_getPermSQL( 'AND' ) . ' ORDER BY date DESC LIMIT 15';
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

            $title = COM_truncate( $A['title'], $_CONF['title_trim_length'],
                                   '...' );
            if( $title != $A['title'] )
            {
                $newlinks[] = '<a href="' . $lcount . '" title="'
                            . $A['title'] . '">' . $title . '</a>' . LB;
            }
            else
            {
                $newlinks[] = '<a href="' . $lcount . '">' . $A['title']
                            . '</a>' . LB;
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
* @param    string  $op         operation to perform
* @param    string  $content    item (e.g. story text), including the autotag
* @param    array   $autotag    parameters used in the autotag
* @param    mixed               tag names (for $op='tagname') or formatted content
*
*/
function plugin_autotags_links ($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES;

    if ($op == 'tagname' ) {
        return array('link','category');
    } else if ($op == 'parse') {
        switch( $autotag['tag'] ) {
            case 'link':
                $lid = COM_applyFilter ($autotag['parm1']);
                $url = COM_buildUrl ($_CONF['site_url']
                                     . '/links/portal.php?what=link&item=' . $lid);
                if (empty ($autotag['parm2'])) {
                    $linktext = stripslashes (DB_getItem ($_TABLES['links'],
                                              'title', "lid = '$lid'"));
                } else {
                    $linktext = $autotag['parm2'];
                }
                $link = '<a href="' . $url . '">' . $linktext . '</a>';
                $content = str_replace ($autotag['tagstr'], $link, $content);
                break;
            case 'category':
                $cid = COM_applyFilter ($autotag['parm1']);
                $url = COM_buildUrl ($_CONF['site_url']
                                     . '/links/index.php?cid=' . $cid);
                if (empty ($autotag['parm2'])) {
                    $linktext = stripslashes (DB_getItem ($_TABLES['linkcategories'],
                                              'category', "cid = '$cid'"));
                } else {
                    $linktext = $autotag['parm2'];
                }
                $link = '<a href="' . $url . '">' . $linktext . '</a>';
                $content = str_replace ($autotag['tagstr'], $link, $content);
                break;
            }
        return $content;
    }
}

/**
* Called by the plugin Editor to display the current plugin code version
* This may be different than the version installed and registered currently.
* If newer then you may want to run the update
*
* @return   string  version number
*
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
    $A = DB_fetchArray ($result);
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
* @param    int     $showsitestate  Flag to let us know which stats to get
* @param    string                  HTML for the stats section
*
*/
function plugin_showstats_links ($showsitestats)
{
    global $_CONF, $_TABLES, $LANG_LINKS_STATS;

    require_once ($_CONF['path_system'] . 'lib-admin.php');

    $retval = '';

    $result = DB_query ("SELECT lid,url,title,hits FROM {$_TABLES['links']} WHERE (hits > 0)" . COM_getPermSQL ('AND') . " ORDER BY hits DESC LIMIT 10");
    $nrows  = DB_numRows ($result);
    if ($nrows > 0) {
        $header_arr = array(
            array('text'         => $LANG_LINKS_STATS['stats_page_title'],
                  'field'        => 'sid',
                  'header_class' => 'stats-header-title'
            ),
            array('text'         => $LANG_LINKS_STATS['stats_hits'],
                  'field'        => 'hits',
                  'header_class' => 'stats-header-count',
                  'field_class'  => 'stats-list-count'
            )
        );
        $data_arr = array();
        $text_arr = array('has_menu' => false,
                          'title'    => $LANG_LINKS_STATS['stats_headline'],
        );
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray ($result);
            $title = stripslashes (str_replace ('$', '&#36;', $A['title']));
            $url = COM_buildUrl ($_CONF['site_url']
                        . '/links/portal.php?what=link&amp;item=' . $A['lid']);
            $sid = '<a href="' . $url . '" title="' . $A['url'] . '">' . $title
                 . '</a>';
            $hits = COM_numberFormat ($A['hits']);
            $data_arr[] = array('title' => $title,
                                'sid' => $sid,
                                'hits' => $hits
                          );
        }
        $retval .= ADMIN_simpleList ('', $header_arr, $text_arr, $data_arr);
    } else {
        $retval .= COM_startBlock ($LANG_LINKS_STATS['stats_headline']);
        $retval .= $LANG_LINKS_STATS['stats_no_hits'];
        $retval .= COM_endBlock ();
    }

    return $retval;
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
* Geeklog is asking us to provide any items that show up in the type
* drop-down on search.php.  Let's users search for links.
*
* @return   array   (plugin name/entry title) pair for the dropdown
*
*/
function plugin_searchtypes_links()
{
    global $LANG_LINKS;

    $tmp['links'] = $LANG_LINKS[14];

    return $tmp;
}


/**
* This searches for links matching the user query and returns an array for the
* header and table rows back to search.php where it will be formated and printed
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
* @return   object              search result object
*
*/
function plugin_dopluginsearch_links($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $_CONF, $_TABLES, $LANG_LINKS_SEARCH;

    if (empty ($type)) {
        $type = 'all';
    }

    // Bail if we aren't supppose to do our search
    if ($type <> 'all' AND $type <> 'links') {
        $plugin_results = new Plugin();
        $plugin_results->plugin_name = 'links';
        $plugin_results->searchlabel = $LANG_LINKS_SEARCH['results'];

        return $plugin_results;
    }

    $select = 'SELECT lid,title,url,owner_id,hits,UNIX_TIMESTAMP(date) AS day';
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
        if (!empty($delim)) {
            $DS = explode ($delim, $datestart);
            $DE = explode ($delim, $dateend);
            $startdate = mktime (0, 0, 0, $DS[1], $DS[2], $DS[0]);
            $enddate = mktime (23, 59, 59, $DE[1], $DE[2], $DE[0]);
            $sql .= " AND (UNIX_TIMESTAMP(date) BETWEEN '$startdate' AND '$enddate')";
        }
    }

    if (!empty ($author)) {
        $sql .= "AND (owner_id = '$author')";
    }
    $sql .= COM_getPermSQL ('AND');
    $sql .= ' GROUP BY date, lid, cid, url, description, title, hits, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon ORDER BY date DESC';
    $l = ($perpage * $page) - $perpage;
    $sql .= ' LIMIT ' . $l . ',' . $perpage;

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
                                 . '/links/portal.php?what=link&amp;item='
                                 . $A['lid']);
        $anchor = '<a href="' . $linkUrl . '" title="' . $A['url'] . '">';
        $row = array ($anchor . $A['title'] . '</a>', $thetime[0], $profile,
                      COM_NumberFormat ($A['hits']));
        $plugin_results->addSearchResult ($row);
        $plugin_results->num_searchresults++;
    }

    return $plugin_results;
}


/**
* This will put an option for links in the command and control block on
* moderation.php
*
* @return   mixed   array(title, url, icon), or boolean false when not allowed
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
* @return   mixed   array(title, url, num. links), or void when not allowed
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
* @param    int     $uid    User id of deleted user
* @return   void
*
*/
function plugin_user_delete_links ($uid)
{
    global $_TABLES, $_LI_CONF;

    if (DB_count ($_TABLES['links'], 'owner_id', $uid) == 0) {
        return;
    }

    if ($_LI_CONF['delete_links'] == 1) {
        // delete the links
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

/**
* Do we support feeds?
*
* @return   array   id/name pairs of all supported feeds
*
*/
function plugin_getfeednames_links()
{
    global $_TABLES;

    $feeds = array ();

    $result = DB_query ("SELECT cid,category FROM {$_TABLES['linkcategories']} GROUP BY category ORDER BY category ASC");
    $num = DB_numRows ($result);

    if ($num > 0) {
        $feeds[] = array ('id' => 'all', 'name' => 'all categories');

        for ($i = 0; $i < $num; $i++) {
            $A = DB_fetchArray ($result);
            $feeds[] = array ('id' => $A['cid'], 'name' => $A['category']);
        }
    }

    return $feeds;
}

/**
* Provide feed data
*
* @param    int     $feed       feed ID
* @param    ref     $link
* @param    ref     $update
* @return   array               feed entries
*
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
        $linkdesc = stripslashes( $row['description'] );

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

/**
* Helper function: Build part of an SQL request
*
* @param    string  $cid        category id
* @param    string  $limits     limit (number of entries or number of hours)
* @return   string              part of an SQL request
*
*/
function links_buildSql ($cid, $limits)
{
    $where = '';
    if ($cid != 'all') {
        $where = "cid='" . $cid . "'";
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
* @param    string  $topic          topic (actually: cid)
* @param    string  $update_data    data describing current feed contents
* @param    string  $limit          number of entries or number of hours
* @param    string  $updated_type   (optional) type of feed to be updated
* @param    string  $updated_topic  (optional) feed's "topic" to be updated
* @param    string  $updated_id     (optional) id of entry that has changed
* @return   boolean                 true: feed data is up to date; false: isn't
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

    $sql = "SELECT lid FROM {$_TABLES['links']}" . links_buildSql ($topic, $limit);
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
* Update the Links plugin
*
* @return   int     Number of message to display (true = generic success msg)
*
*/
function plugin_upgrade_links ()
{
    global $_CONF, $_TABLES, $_LI_CONF, $_DB_dbms;

    // the plugin needs these functions so complain when they doesn't exist
    if (!function_exists ('COM_truncate') ||
        !function_exists ('MBYTE_strpos')) {
        return 3002;
    }

    // include SQL required for upgrade
    $blockadmin_id = DB_GetItem ($_TABLES['groups'], 'grp_id', "grp_name='Block Admin'");
    include ($_CONF['path'] . 'plugins/links/sql/upgrade_1.0.1_2.'.$_DB_dbms.'.php');


    // get current version
    $currentVersion = DB_getItem($_TABLES['plugins'],'pi_version',"pi_name='links'");

    switch( $currentVersion ) {

        case "1.0" :
        case "1.0.1" :

        // do DB changes:

        // create categories table

        COM_errorLog ("Adding categories table to the links plugin", 1);
        DB_Query($LINKS_SQL['linkcategories'],1);
        if (DB_error ()) {
            COM_errorLog ("There was an error adding categories table to the links plugin", 1);
            return false;
        }

        // move categories across:

        // get category data
        COM_errorLog("Selecting category data from links table",1);
        $result = DB_query($LINKS_SQL['getcategories']);
        if (DB_error()) {
            COM_errorLog("Error selecting categories from links table",1);
            return false;
        }
        COM_errorLog("Success - selected categories from links table",1);

        // get Links admin group number
        $group_id = DB_getItem($_TABLES['groups'],'grp_id',"grp_name='Links Admin'");

        // loop through adding to category table, then update links table with cids
        $nrows = DB_numRows($result);
        if ($nrows > 0) {
            for ($i = 1; $i <= $nrows; $i++) {
                $A = DB_fetchArray($result);
                $category = $A['category'];
                $cid = COM_makeSID ();
                DB_query ("INSERT INTO {$_TABLES['linkcategories']} (cid,pid,category,owner_id,group_id,created,modified) VALUES ('{$cid}','site','{$category}','2','{$group_id}',NOW(),NOW())",1);
                DB_query ("UPDATE {$_TABLES['links']} SET category='{$cid}' WHERE category='{$category}'",1);
                if (DB_error()) {
                    COM_errorLog("Error inserting categories into linkcategories table",1);
                    return false;
                }
            }
        }
        COM_errorLog("Success - inserted categories into linkcategories table",1);

        // update the links and linksubmission table structures
        COM_errorLog ("Updating linksubmission table for the links plugin (a)", 1);
        DB_Query($LINKS_SQL['linksubmission1'],1);
        if (DB_error ()) {
            COM_errorLog ("There was an error updating the linksubmission table of the links plugin (a)", 1);
            return false;
        }
        COM_errorLog ("Updating linksubmission table for the links plugin (b)", 1);
        DB_Query($LINKS_SQL['linksubmission2'],1);
        if (DB_error ()) {
            COM_errorLog ("There was an error updating the linksubmission table of the links plugin (b)", 1);
            return false;
        }
        COM_errorLog("Success - updated linksubmission table for the links plugin",1);

        COM_errorLog ("Updating links table for the links plugin", 1);
        DB_Query($LINKS_SQL['links'],1);
        if (DB_error ()) {
            COM_errorLog ("There was an error updating the links table of the links plugin", 1);
            return false;
        }
        COM_errorLog("Success - updated links table for the links plugin",1);

        // add root category
        DB_Query($LINKS_SQL['root'],1);
        if (DB_error ()) {
            COM_errorLog ("There was an error adding the root category to the links plugin", 1);
            return false;
        }
        COM_errorLog("Success - added root category to the links plugin",1);

        // add php links block
        DB_Query($LINKS_SQL['linksblock'],1);
        if (DB_error ()) {
            COM_errorLog ("There was an error adding the phplinksblock to the links plugin", 1);
            return false;
        }
        COM_errorLog("Success - added phplinksblock to the links plugin",1);

        // add php categories block
        DB_Query($LINKS_SQL['categoriesblock'],1);
        if (DB_error ()) {
            COM_errorLog ("There was an error adding the phpcategoriesblock to the links plugin", 1);
            return false;
        }
        COM_errorLog("Success - added phpcategoriesblock to the links plugin",1);

        // update the version numbers
        DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_LI_CONF['version']}', pi_gl_version='" . VERSION . "' WHERE pi_name='links'");

    default :
    // do nothing
    break;
    }

    return true;
}

/**
* Geeklog informs us that we're about to be enabled or disabled
*
* @param    boolean     $enable     true = we're being enabled, false = disabled
* @return   void
*
*/
function plugin_enablestatechange_links ($enable)
{
    global $_TABLES;

    $is_enabled = $enable ? 1 : 0;

    // toggle links feeds
    DB_query ("UPDATE {$_TABLES['syndication']} SET is_enabled = $is_enabled WHERE type = 'links'");
}

/**
* Removes the datastructures for this plugin from the Geeklog database
*
* This may get called by the install routine to undo anything done to this
* point.
*
* @return   boolean     true: uninstalled successfully
*
*/
function plugin_uninstall_links ()
{
    global $_CONF, $_TABLES;

    // Uninstalls the links plugin

    // Remove the linksubmisssion table
    COM_errorLog ('Dropping linksubmission table', 1);
    DB_query ("DROP TABLE {$_TABLES['linksubmission']}");
    COM_errorLog ('...success', 1);

    // Remove the links table
    COM_errorLog ('Dropping links table', 1);
    DB_query ("DROP TABLE {$_TABLES['links']}");
    COM_errorLog ('...success', 1);

    // Remove the categories table
    COM_errorLog ('Dropping categories table', 1);
    DB_query ("DROP TABLE {$_TABLES['linkcategories']}");
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

    // Remove Links Feeds from syndication table
    COM_errorLog ('removing links feeds from table', 1);
    DB_query ("DELETE FROM {$_TABLES['syndication']} WHERE type = 'links'");
    COM_errorLog ('...success', 1);

    // Remove Links phpblocks from the blocks table
    COM_errorLog ('removing links phpblock from table', 1);
    DB_query ("DELETE FROM {$_TABLES['blocks']} WHERE name = 'links_topic_links'");
    DB_query ("DELETE FROM {$_TABLES['blocks']} WHERE name = 'links_topic_categories'");
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
* Counts the items that are submitted
*
* @return   int     number of items in submission queue
*
*/
function plugin_submissioncount_links()
{
    global $_TABLES;

    $retval = 0;

    if (plugin_ismoderator_links ()) {
        $retval = DB_count ($_TABLES['linksubmission']);
    }

    return $retval;
}

/**
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
*
* @return   mixed   plugin object or void if not allowed
*
*/
function plugin_itemlist_links()
{
    global $_TABLES, $LANG_LINKS_SUBMIT;

    if (plugin_ismoderator_links()) {
        $plugin = new Plugin();
        $plugin->submissionlabel = $LANG_LINKS_SUBMIT[11];
        $plugin->submissionhelpfile = 'cclinksubmission.html';
        $plugin->getsubmissionssql = "SELECT lid AS id,title,cid AS category,url FROM {$_TABLES['linksubmission']} ORDER BY title ASC";
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
                  'lid,cid,url,description,title,date',
                  $_TABLES['linksubmission']);
}


/**
* Performs plugin exclusive work for items approved by moderation
*
* While moderation.php handles the actual move from linkssubmission
* to links tables, within the function we handle all other approval
* relate tasks
*
* @param    string  $id     Identifying string
* @return   string          Any wanted HTML output
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
* related tasks
*
* @param    string  $id     Identifying string
* @return   string          Any wanted HTML output
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
* Check submission form values and save if OK. Else show form again
*
* @param    array   $A  The link record
* @return   string      Any wanted HTML output
*
*/
function plugin_savesubmission_links($A)
{
    global $LANG12;

    $retval = '';

    if (!empty ($A['title']) && !empty ($A['description']) &&
                !empty ($A['url'])) {
        $retval = plugin_save_submit_links ($A);
    } else {
        $retval .= COM_siteHeader()
            . COM_startBlock ($LANG12[22], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
            . $LANG12[23]
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
            . submissionform('links')
            . COM_siteFooter ();
    }

    return $retval;
}

/**
* Shows link submission form
*
* @return   string  HTML for the link submission form
*
*/
function plugin_submit_links()
{
    global $_CONF, $LANG_LINKS_SUBMIT, $LANG12;

    $retval = COM_startBlock ($LANG_LINKS_SUBMIT[1], 'submitlink.html');

    $linkform = new Template($_CONF['path'] . 'plugins/links/templates');
    $linkform->set_file('linkform', 'submitlink.thtml');
    $linkform->set_var('site_url', $_CONF['site_url']);
    $linkform->set_var('layout_url', $_CONF['layout_url']);
    $linkform->set_var('lang_title', $LANG12[10]);
    $linkform->set_var('lang_link', $LANG_LINKS_SUBMIT[2]);
    $linkform->set_var('lang_category', $LANG_LINKS_SUBMIT[3]);
    $dummycategory = '';
    $linkform->set_var('link_category_options',
                       links_select_box (2,$dummycategory));
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
        $A['cid'] = $A['categorydd'];
    } else if ($A['categorydd'] != $LANG_LINKS_SUBMIT[4]) {
        $retval .= COM_startBlock ($LANG_LINKS_SUBMIT[6], '',
                       COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG_LINKS_SUBMIT[7]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
                . submissionform ('links')
                . COM_siteFooter ();

        return $retval;
    }

    // pseudo-formatted link description for the spam check
    $spamcheck = '<p><a href="' . $A['url'] . '">' . $A['title'] . '</a> ('
               . $A['cid'] . ', ' . $A['categorydd'] . ')<br>'
               . $A['description'] . '</p>';
    $result = PLG_checkforSpam ($spamcheck, $_CONF['spamx']);
    if ($result > 0) {
        COM_updateSpeedlimit ('submit');
        COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
    }

    $A['cid'] = addslashes ($A['cid']);
    $A['description'] = addslashes (htmlspecialchars (COM_checkWords ($A['description'])));
    $A['title'] = addslashes (strip_tags (COM_checkWords ($A['title'])));
    $A['url'] = addslashes (COM_sanitizeUrl ($A['url']));
    $A['lid'] = addslashes (COM_makeSid ());
    COM_updateSpeedlimit ('submit');

    if (($_LI_CONF['linksubmission'] == 1) && !SEC_hasRights ('links.submit')) {
        $result = DB_save ($_TABLES['linksubmission'],
                    'lid,cid,url,description,title,date',
                    "{$A['lid']},'{$A['cid']}','{$A['url']}','{$A['description']}','{$A['title']}',NOW()");

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
        $result = DB_save ($_TABLES['links'], 'lid,cid,url,description,title,date,owner_id', "{$A['lid']},'{$A['cid']}','{$A['url']}','{$A['description']}','{$A['title']}',NOW(),$owner_id");
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
    global $_CONF, $_TABLES, $LANG_LINKS, $LANG_LINKS_SUBMIT, $LANG08;

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
    global $_CONF, $LANG_ACCESS;

    $retval = '';

    $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
    if ($access > 0) {
        switch($fieldname) {
            case 'edit':
                if ($access == 3) {
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php?mode=edit&amp;lid={$A['lid']}\">{$icon_arr['edit']}</a>";
                }
                break;
            case 'access':
                if ($access == 3) {
                   $retval = $LANG_ACCESS['edit'];
                } else {
                   $retval = $LANG_ACCESS['readonly'];
                }
                break;
            case 'htmlcode';
                $retval = links_validateUrl($A['url']);
                break;
            case 'title':
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

/**
* Return a list of all link categories
*
* @param    ref     $current_category   currently selected category
* @return   string                      <option> list containing all categories
*
* Note: $current_category will be returned as an empty string when found in the
*       current list of categories and left untouched when it's a new category,
*       i.e. the user selected "Other". This is needed for moderating link
*       submissions.


function links_getCategoryList (&$current_category)
{
    global $_TABLES, $LANG_LINKS_ADMIN;

    $retval = '';

    $result = DB_query("SELECT DISTINCT category FROM {$_TABLES['links']}" . COM_getPermSQL () . " GROUP BY category");
    $nrows = DB_numRows($result);

    $retval = '<option value="' . $LANG_LINKS_ADMIN[7] . '">'
            . $LANG_LINKS_ADMIN[7] . '</option>';
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray ($result);
        $category = $A['category'];
        $retval .= '<option value="' . $category . '"';
        if ($category == $current_category) {
            $retval .= ' selected="selected"';
            $current_category = '';
        }
        $retval .= '>' . $category . '</option>';
    }

    return $retval;
}
*/

/**
* Set template variables
*
* @param    string  $templatename   name of template, e.g. 'header'
* @param    ref     $template       reference of actual template
* @return   void
*
* Note: A plugin should use its name as a prefix for the names of its
* template variables, e.g. 'links_xxx' and 'lang_links_xxx'.
* 'button_links' is an exception, as such a variable existed for header.thtml
* in Geeklog 1.3.11 and earlier, where the Links section was an integral part
* of Geeklog. It is added here for backward-compatibility.
*
*/
function plugin_templatesetvars_links ($templatename, &$template)
{
    global $LANG_LINKS;

    if ($templatename == 'header') {
        $template->set_var ('button_links', $LANG_LINKS[14]);
    }
}




// +-----------------------------------------------------------------------------------------------+
// | Category HTML functions                                                                       |
// | Functions for building select boxes and breadcrumb trails etc.                                |
// +-----------------------------------------------------------------------------------------------+

/*
* Build selection list
*/
function links_select_box ($access, $sel = '') {
    global $_CONF, $LANG_LINKS;
    // root category is 'site' in database
    $root = 'site';
    // set root value
    $menu = '<option value="'.$root.'">'.$LANG_LINKS['root'].'</option>';
    // get option values
    $list = links_select_box_recursive($menu,$root,$sel,'&nbsp;&nbsp;',$access);
    // return list of options
    return $list;
}


/*
* Build recursive tree
*/
function links_select_box_recursive (&$menu, $cid, $sel, $indent, $access) {
    global $_CONF, $_TABLES;
    $sql = "SELECT cid,category
            FROM {$_TABLES['linkcategories']}
            WHERE (pid='{$cid}') " . COM_getPermSQL('AND',0,$access) . "
            ORDER BY category";
    $query = DB_QUERY($sql);
    while ( list($cid,$category) = DB_fetchARRAY($query) ) {
        // set selected item
        if ($cid==$sel) {
            // yes, selected
            $menu .= '<option value="'.$cid.'" SELECTED="SELECTED">'.$indent.$category.'</option>';
        } else {
            // no, not selected
            $menu .= '<option value="'.$cid.'">'.$indent.$category.'</option>';
        }
        // Check and see if this category has any sub categories
        if (DB_COUNT($_TABLES['linkcategories'], 'pid', $cid) > 0) {
            // yes, call self
            $dum = links_select_box_recursive (&$menu,$cid,$sel,$indent.'&nbsp;&nbsp;',$access);
        }
   }
   return $menu;
}


/*
* Build breadcrumb trail
*
* Breadcrumb trail does not use the "root" category in the database: the top level category is
* set from the language file using $LANG_LINKS['root']
*/
function links_breadcrumbs ($root,$cid) {
    global $_CONF, $_TABLES, $LANG_LINKS;
    $breadcrumb = '';
    $c = $cid;
    if ($root <> $cid) {
        while (!($pid == $root)) {
            $parent = DB_query("SELECT cid,pid,category FROM {$_TABLES['linkcategories']}
                                WHERE cid='{$c}'");
            $A = DB_fetchArray($parent);
            if ($cid<>$c) {
                $breadcrumb = '<a href="' . $_CONF['site_url'] . '/links/index.php?cid='
                       . $A['cid'] . '">' . $A['category'] . '</a> : ' . $breadcrumb;
            } else {
                $breadcrumb = $A['category'] . $breadcrumb;
            }
            $pid = $A['pid'];
            $c = $A['pid'];
        }
    }
    $breadcrumb = '<a href="' . $_CONF['site_url'] . '/links/index.php">' . $LANG_LINKS['root']
                . '</a> : ' . $breadcrumb;

    return $breadcrumb;
}



// +-----------------------------------------------------------------------------------------------+
// | Category administration functions                                                             |
// | Located here so that in the future, users can also have their own link collections with       |
// | categories over which they have edit access.                                                  |
// +-----------------------------------------------------------------------------------------------+



// Returns a category tree of categories in the database to which
// the user has edit access

function links_list_categories ($root) {

    global $_TABLES, $LANG_LINKS, $LANG_LINKS_ADMIN, $LANG_ADMIN, $_CONF, $_USER, $_LI_CONF;

    $retval = COM_startBlock ($LANG_LINKS[24], '',
                COM_getBlockTemplate ('_admin_block', 'header'));

    // set template vars
    $T = new Template($_CONF['path'] . 'plugins/links/templates/admin');
    $T->set_file('page','categorylist.thtml');
    $T->set_var('site_url', $_CONF['site_url']);
    $T->set_var('site_admin_url', $_CONF['site_admin_url']);
    $T->set_var('layout_url', $_CONF['layout_url']);
    $T->set_var('lang_pagetitle', $LANG_LINKS_ADMIN[24]);
    $T->set_var('lang_link_list', $LANG_LINKS_ADMIN[27]);
    $T->set_var('lang_new_link', $LANG_LINKS_ADMIN[25]);
    $T->set_var('lang_list_categories', $LANG_LINKS_ADMIN[24]);
    $T->set_var('lang_new_category', $LANG_LINKS_ADMIN[26]);
    $T->set_var('lang_admin_home', $LANG_ADMIN['admin_home']);
    $T->set_var('lang_sitecategories', $LANG_LINKS_ADMIN[43]);
    $T->set_var('lang_category', $LANG_LINKS_ADMIN[30]);
    $T->set_var('lang_topic', $LANG_LINKS_ADMIN[33]);
    $T->set_var('edit_text', $LANG_ADMIN['edit']);
    $T->set_var('add_text', $LANG_LINKS_ADMIN[44]);
    $T->set_var('delete_text', $LANG_ADMIN['delete']);
    $T->set_var('lang_root', $LANG_LINKS['root']);
    $T->set_var('root_cid', $root);

    // get list of categories
    $list = links_list_categories_recursive($root, $indent);
    if (strlen($list) == 0) {
        $list = '<br><a href="' . $_CONF['site_admin_url'] .
                 '/plugins/links/category.php?mode=edit">' . $LANG_LINKS_ADMIN[26] . '</a>';
    }
    $T->set_var('sitelist', $list);
    $T->parse('output','page');
    $retval .= $T->finish($T->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}


//
// Build recursive list for function links_list_categories above
//

function links_list_categories_recursive ($cid,$indent='',$colour='') {

    global $_CONF, $_TABLES, $_LI_CONF, $LANG_LINKS_ADMIN;

    // get all children of present category
    $sql = "SELECT cid,category,tid,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['linkcategories']}
            WHERE (pid='{$cid}')" . COM_getPermSQL('AND',0,2) . "ORDER BY pid,category";
    $query = DB_QUERY($sql);
    $indent .= $_LI_CONF['indent'];
    $colour1 = ' class="pluginRow1" onMouseOver="className=\'pluginRollOver\';" onMouseOut="className=\'pluginRow1\';"';
    $colour2 = ' class="pluginRow2" onMouseOver="className=\'pluginRollOver\';" onMouseOut="className=\'pluginRow2\';"';

    // loop through results, setting to template, and calling self if children exist
    while ( list($cid,$category,$tid,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) = DB_fetchARRAY($query) ) {
        if ($colour==$colour2) {
            $colour = $colour1;
        } else {
            $colour = $colour2;
        }
        $topic = DB_getItem($_TABLES['topics'], 'topic', "tid='{$tid}'");
        $L = new Template($_CONF['path'] . 'plugins/links/templates/admin');
        $L->set_file( array( 'item' => 'catitem.thtml' ) );
        $L->set_var('site_admin_url', $_CONF['site_admin_url']);
        $L->set_var('site_url', $_CONF['site_url']);
        $L->set_var('layout_url', $_CONF['layout_url']);
        $L->set_var('rowcolor', $colour);
        $L->set_var('category', $category);
        $L->set_var('topic_text', $topic);
        $L->set_var('cid', $cid);
        $L->set_var('indent', $indent);

        $access = SEC_hasAccess($owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
        if ($access==3) {
            $editlink = '<a href="' . $_CONF['site_admin_url'] . '/plugins/links/category.php?mode=edit&amp;cid=' . $cid . '" title="' . $LANG_LINKS_ADMIN[40] . '"><img src="' . $_CONF['layout_url'] . '/images/edit.png" alt="' . $LANG_LINKS_ADMIN[40] . '"></a>';
            $childlink = '<a href="'.$_CONF['site_admin_url'].'/plugins/links/category.php?mode=edit&amp;pid='.$cid.'" title="'.$LANG_LINKS_ADMIN[41].'"><img src="'.$_CONF['layout_url'].'/images/addchild.png" alt="'.$LANG_LINKS_ADMIN[41].'"></a>';
            $deletelink = '<a href="'.$_CONF['site_admin_url'].'/plugins/links/category.php?mode=delete&amp;cid='.$cid.'" title="'.$LANG_LINKS_ADMIN[42].'"><img src="'.$_CONF['layout_url'].'/images/deleteitem.png" alt="'.$LANG_LINKS_ADMIN[42].'"></a>';
        } else {
            $editlink = '-';
            $childlink = '-';
            $deletelink = '-';
        }
        $L->set_var('edit_text', $editlink);
        $L->set_var('add_text', $childlink);
        $L->set_var('delete_text', $deletelink);
        $L->parse('output','item');
        $list .= $L->finish($L->get_var('output'));
        if (DB_COUNT($_TABLES['linkcategories'], 'pid', $cid) > 0) {
            $list .= links_list_categories_recursive($cid, $indent, $colour);
        }
    }
    return $list;
}


// Returns form to create a new category or edit an existing one

function links_edit_category ($cid,$pid) {

    global $_TABLES, $LANG_LINKS_ADMIN, $LANG_ADMIN, $LANG_ACCESS, $_CONF, $_USER;

    if ($pid <> '') {
        // have parent id, so making a new subcategory
        // get parent access rights
        $result = DB_Query("SELECT group_id,perm_owner,perm_group, perm_members,perm_anon
                            FROM {$_TABLES['linkcategories']} WHERE cid='{$pid}'");
        $A = DB_fetchArray($result);
        $A['username'] = DB_getItem ($_TABLES['users'], 'username', "uid={$_USER['uid']}");
        $A['owner_id'] = $_USER['uid'];
        $A['pid'] = $pid;
    } elseif ($cid <> '') {
        // have category id, so editing a category
        $sql = "SELECT * FROM {$_TABLES['linkcategories']}
                WHERE cid='{$cid}'" . COM_getPermSQL('AND');
        $result = DB_Query($sql);
        $A = DB_fetchArray($result);
        $A['username'] = DB_getItem ($_TABLES['users'], 'username', "uid={$A['owner_id']}");
    } else {
        // nothing, so making a new top-level category
        // get default access rights
        $A['group_id']     = DB_getItem ($_TABLES['groups'], 'grp_id', "grp_name='Links Admin'");
        SEC_setDefaultPermissions ($A, $_LI_CONF['default_permissions']);
        $A['username']     = DB_getItem ($_TABLES['users'], 'username', "uid={$_USER['uid']}");
        $A['owner_id']     = $_USER['uid'];
        $A['pid']          = 'site';

    }

    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
                             $A['perm_group'], $A['perm_members'], $A['perm_anon']);

    if ($access < 3) {
        return $LANG_LINKS[47];
    }

    $retval = COM_startBlock ($LANG_LINKS[24], '', COM_getBlockTemplate ('_admin_block', 'header'));

    $T = new Template($_CONF['path'] . 'plugins/links/templates/admin');
    $T->set_file(array('page'=>'categoryeditor.thtml'));

    $T->set_var('site_url', $_CONF['site_url']);
    $T->set_var('site_admin_url', $_CONF['site_admin_url']);
    $T->set_var('layout_url', $_CONF['layout_url']);
    $T->set_var('lang_pagetitle', $LANG_LINKS_ADMIN[28]);
    $T->set_var('lang_link_list', $LANG_LINKS_ADMIN[27]);
    $T->set_var('lang_new_link', $LANG_LINKS_ADMIN[25]);
    $T->set_var('lang_list_categories', $LANG_LINKS_ADMIN[24]);
    $T->set_var('lang_new_category', $LANG_LINKS_ADMIN[26]);
    $T->set_var('lang_admin_home', $LANG_ADMIN['admin_home']);
    $T->set_var('instructions', $LANG_LINKS_ADMIN[29]);
    $T->set_var('lang_category', $LANG_LINKS_ADMIN[30]);
    $T->set_var('lang_cid', $LANG_LINKS_ADMIN[32]);
    $T->set_var('lang_description', $LANG_LINKS_ADMIN[31]);
    $T->set_var('lang_topic', $LANG_LINKS_ADMIN[33]);
    $T->set_var('lang_parent', $LANG_LINKS_ADMIN[34]);
    $T->set_var('lang_save', $LANG_ADMIN['save']);
    $T->set_var('lang_delete', $LANG_ADMIN['delete']);
    $T->set_var('lang_cancel', $LANG_ADMIN['cancel']);

    if ($cid <> '') {
        $T->set_var('cid_value', $A['cid']);
        $T->set_var('old_cid_value', $A['cid']);
        $T->set_var('title_id', $A['title_id']);
        $T->set_var('desc_id', $A['desc_id']);
        $T->set_var('category_options', links_select_box (3,$A['pid']));
        $T->set_var('category_value', $A['category']);
        $T->set_var('description_value', $A['description']);
        $T->set_var('icon_value', $A['icon']);
        $T->set_var('topic_list', COM_topicList ('tid,topic', $A['tid'],1,true));
        $T->set_var('delete_button', "<input type=\"submit\" value=\"{$LANG_ADMIN['delete']}\" name=\"mode\">");
    } else {
        $A['cid'] = COM_makeSID ();
        $T->set_var('cid_value', $A['cid']);
        $T->set_var('category_options', links_select_box (3,$A['pid']));
        $T->set_var('category_value', '');
        $T->set_var('description_value', '');
        $T->set_var('icon_value', '');
        $T->set_var('topic_list', COM_topicList ('tid,topic','',1,true));
        $T->set_var('delete_button', '');
    }

    // user access info
    $T->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $T->set_var('lang_owner', $LANG_ACCESS['owner']);
    $T->set_var('owner_name', COM_getDisplayName ($A['owner_id']));
    $T->set_var('cat_ownerid', $A['owner_id']);
    $T->set_var('lang_group', $LANG_ACCESS['group']);
    $T->set_var('group_dropdown', SEC_getGroupDropdown ($A['group_id'], $access));
    $T->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $T->set_var('lang_permissionskey', $LANG_ACCESS['permissionskey']);
    $T->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $T->set_var('lang_lockmsg', $LANG_ACCESS['permmsg']);

    $T->parse('output','page');
    $retval .= $T->finish($T->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;

}



/*
* Save changes to category information
* input     array       values from form (unvalidated, unsafe)
* output    string      message giving outcome status of requested operation
*/

function links_save_category ($cid, $old_cid, $pid, $category, $description, $tid, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon) {
    global $_TABLES, $_CONF, $_USER, $LANG_LINKS, $LANG_LINKS_ADMIN;

    // Convert array values to numeric permission values
    if (is_array($perm_owner) OR is_array($perm_group) OR is_array($perm_members) OR is_array($perm_anon)) {
        list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
    }

    // clean 'em up
    $description = addslashes (COM_checkHTML (COM_checkWords ($description)));
    $category = addslashes (COM_checkHTML (COM_checkWords ($category)));

    // Check cid to make sure not illegal
    if (($cid=='site') || ($cid=='user')) {
        $result = $LANG_LINKS_ADMIN[35];
        return $result;
    }
    // check that they didn't delete the cid. If so, get the hidden one
    if ($cid=='' && $old_cid<>'') {
        $cid = $old_cid;
    }
    // Make sure they aren't making a parent category child of one of it's own children
    // This would create orphans
    if ($cid==DB_getItem($_TABLES['linkcategories'], 'pid',"cid='{$pid}'")) {
        return $LANG_LINKS_ADMIN['48'];
    }

    $access = 0;
    if (DB_count ($_TABLES['linkcategories'], 'cid', $old_cid) > 0) {
        // update existing item, but new cid so get access from database with old cid
        $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,
            perm_members,perm_anon FROM {$_TABLES['linkcategories']}
            WHERE cid='{$old_cid}'");
        $A = DB_fetchArray ($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],
            $A['perm_group'],$A['perm_members'],$A['perm_anon']);
        // set flag
        $update = "existing";
    } else if (DB_count ($_TABLES['linkcategories'], 'cid', $cid) > 0) {
        // update existing item, same cid, so get access from database with existing cid
        $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,
            perm_members,perm_anon FROM {$_TABLES['linkcategories']}
            WHERE cid='{$cid}'");
        $A = DB_fetchArray ($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],
            $A['perm_group'],$A['perm_members'],$A['perm_anon']);
        // set flag
        $update = "same";
    } else {
        // new item, so use passed values
        $access = SEC_hasAccess($owner_id,$group_id,$perm_owner,
            $perm_group,$perm_members,$perm_anon);
        // set flag
        $update = "new";
    }

    if ($access < 3) {
        // no access rights: user should not be here
        $display .= COM_siteHeader ('menu');
        $display .= COM_startBlock ($LANG_LINKS[41], '',
            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $LANG_LINKS[44];
        $display .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= COM_siteFooter ();
        COM_accessLog(sprintf($LANG_LINKS[45], $_USER['username']));
        echo $display;
        exit;
    } else {
        // save item
        if ($update=="existing") {
            // update an existing item but new cid
            $sql = "UPDATE {$_TABLES['linkcategories']}
                    SET cid='{$cid}',
                        pid='{$pid}',
                        tid='{$tid}',category='{$category}',
                        description='{$description}',
                        modified=NOW(),
                        owner_id='{$owner_id}',group_id='{$group_id}',
                        perm_owner='{$perm_owner}',perm_group='{$perm_group}',
                        perm_members='{$perm_members}',perm_anon='{$perm_anon}'
                    WHERE cid = '{$old_cid}'";
            $result = DB_query($sql);
            // Also need to update links for this category
            $sql = "UPDATE {$_TABLES['links']} SET cid='{$cid}' WHERE cid='{$old_cid}'";
            $result = DB_query($sql);
        } else if ($update=="same") {
            // update an existing item
            $sql = "UPDATE {$_TABLES['linkcategories']}
                    SET pid='{$pid}',
                        tid='{$tid}',category='{$category}',
                        description='{$description}',
                        modified=NOW(),
                        owner_id='{$owner_id}',group_id='{$group_id}',
                        perm_owner='{$perm_owner}',perm_group='{$perm_group}',
                        perm_members='{$perm_members}',perm_anon='{$perm_anon}'
                    WHERE cid = '{$cid}'";
            $result = DB_query($sql);
        } else {
            // insert a new item
            $cid = COM_makesid();
            $sql = "INSERT INTO {$_TABLES['linkcategories']}
                    (cid, pid, category, description, tid,
                    created,modified,
                    owner_id, group_id, perm_owner, perm_group,
                    perm_members, perm_anon)
                    VALUES
                    ('{$cid}','{$pid}','{$category}',
                    '{$description}','{$tid}',
                    NOW(),NOW(),
                    '{$owner_id}','{$group_id}','{$perm_owner}',
                    '{$perm_group}','{$perm_members}','{$perm_anon}')";
            $result = DB_query($sql);
        }
    }
    return $result;
}


/*
* Delete a category
* input     $cid    string      category id number
* output            string      message about success of requested operation
*/

function links_delete_category ($cid)
{
    global $_TABLES, $LANG_LINKS_ADMIN;

    if (DB_count ($_TABLES['linkcategories'], 'cid', $cid) > 0) {
        // item exists so check access rights
        $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,
            perm_members,perm_anon FROM {$_TABLES['linkcategories']}
            WHERE cid='{$cid}'");
        $A = DB_fetchArray ($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],
            $A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access>2) {
            // has edit rights
            // Check for subfolders and sublinks
            $sf = DB_count ($_TABLES['linkcategories'], 'pid', $cid);
            $sl = DB_count ($_TABLES['links'], 'cid', $cid);
            if (($sf=='0') && ($sl=='0')) {
                // No subfolder/links so OK to delete
                DB_delete ( $_TABLES['linkcategories'], 'cid', $cid);
                return $LANG_LINKS_ADMIN[37];
            } else {
                // Subfolders and/or sublinks exist so return a message
                return $LANG_LINKS_ADMIN[38];
            }
        } else {
            // no access
            return $LANG_LINKS_ADMIN[45];
            COM_accessLog(sprintf($LANG_LINKS_ADMIN[46], $_USER['username']));
        }
    } else {
        // no such category
        return $LANG_LINKS_ADMIN[47];
    }
}

/**
 * returns a list of links that belong to categories associated with the current topic
 */
function phpblock_topic_links ()
{
    global $_TABLES, $LANG_LINKS, $_CONF;
    $retval = '';
    $tid = links_get_tid();
    $result = DB_query("SELECT l.lid, l.title, c.cid FROM {$_TABLES['links']} AS l
                        LEFT JOIN {$_TABLES['linkcategories']} AS c
                        ON l.cid=c.cid
                        WHERE c.tid='{$tid}'" . COM_getPermSQL('AND', 0, 2, 'c'));
    $nrows = DB_numRows($result);
    if ($nrows>0) {
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray ($result);
            $retval .= '<a href="'.$_CONF['site_url'].'/links/portal.php?what=link&item='.$A['lid'];
            $retval .= '">'.$A['title'].'</a><br>';
        }
    }
    return $retval;
}


/**
 * returns a list of categories that are associated with the current topic
 */
function phpblock_topic_categories ()
{
    global $_TABLES, $LANG_LINKS, $_CONF;
    $retval = '';
    $tid = links_get_tid();
    if (isset($tid)) {
        $result = DB_query("SELECT category, cid FROM {$_TABLES['linkcategories']}
                            WHERE tid='{$tid}'" . COM_getPermSQL('AND'));
        $nrows = DB_numRows($result);
        if ($nrows>0) {
            for ($i = 0; $i < $nrows; $i++) {
                $A = DB_fetchArray ($result);
                $retval .= '<a href="'.$_CONF['site_url'].'/links/index.php?cid='.$A['cid'];
                $retval .= '">'.$A['category'].'</a><br>';
            }
        }
    }
    return $retval;
}


/**
 * tries to establish the current topic and return tid
 */
function links_get_tid ()
{
    global $_TABLES;
    if (isset($_REQUEST['tid'])) {
        return $_REQUEST['tid'];
    } elseif (isset($_REQUEST['topic'])) {
        return DB_getItem($_TABLES['topics'], 'tid',  "topic='{$_REQUEST['topic']}'");
    } elseif (isset($_REQUEST['story'])) {
        return DB_getItem($_TABLES['stories'], 'tid',  "sid='{$_REQUEST['story']}'");
    } else {
        return;
    }
}

function links_validateUrl($url) {
    global $LANG_LINKS_STATUS;
    $header_str = '';
    $url_arr = parse_url($url);
    $socket = @fsockopen($url_arr['host'], 80, $err_no, $err_txt, 10);
    if ($socket) {
        if (empty($url_arr['path'])) {
            $url_arr['path'] = "/";
        }
        $query = '';
        if (isset($url_arr['query'])) {
            $query = "?{$url_arr['query']}";
        }
        $send_header = "HEAD {$url_arr['path']} HTTP/1.1\r\n"
            . "User-Agent: Geeklog Link Checker\r\n"
            . "Host: {$url_arr['host']}\r\n"
            . "Connection: close\r\n\r\n";
        fputs($socket, $send_header);
        while($str = fgets($socket, 1024)) {
            if (eregi("^http/[0-9]+.[0-9]+ ([0-9]{3}) [a-z ]*", $str)) {
                $status_code = trim(eregi_replace("^http/[0-9]+.[0-9]+ ([0-9]{3}) [a-z ]*", "\\1", $str));
            }
        }
        fclose($socket);
        $status_code = $status_code . ": " . $LANG_LINKS_STATUS[$status_code];
    }
    if (!isset($status_code)) {
        $status_code = $LANG_LINKS_STATUS[999];
    }
    return $status_code;
}

?>
