<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 0.1 for Geeklog - The Ultimate Weblog                 |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the Static     |
// | Pages' PHP files.                                                         |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
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
// $Id: functions.inc,v 1.6 2002/04/28 13:42:50 dhaun Exp $

include($_CONF['path'] . 'plugins/staticpages/lang.php');
include($_CONF['path'] . 'plugins/staticpages/staticpages.cfg');

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
function plugin_getmenuitems_staticpages()
{
    global $_CONF;

    $result = DB_query('SELECT sp_id, sp_label FROM staticpage WHERE sp_onmenu = 1 ORDER BY sp_label');
    $nrows = DB_numRows($result);
    $menuitems = array();
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        $menuitems[$A['sp_label']] = $_CONF['site_url'] . "/staticpages/index.php?page={$A['sp_id']}";
    }
    return $menuitems;
}

/**
* Geeklog is checking to see if this plugin supports comments, tell it yes!
* NOTE: to support comments you must used the same date/time based ID for your
* widget.  In otherwords, to make primary keys for your plugin you should call
* makesid().  Comments are keyed off of that...it is a limitation on how geeklog
* does comments.
*
*/
function plugin_commentsupport_staticpages() 
{
    // Static Pages will not use comments
    return false;
}

/**
* shows the statistics for the book review plugin on stats.php.  If $showsitestats
* is 1 then we are to only print the overall stats in the 'site statistics box'
* otherwise we show the detailed stats for the photo album
*
* @showsitestate        int         Flag to let us know which stats to get
*/
function plugin_showstats_staticpages($showsitestats) 
{
    // Code to come later
}

/**
* Geeklog is asking us to provide any new items that show up in the type drop-down
* on search.php.  Let's let users search static pages!
*
*/
function plugin_searchtypes_staticpages() 
{
    global $LANG_STATIC;

    $tmp['staticpages'] = $LANG_STATIC['staticpages'];
    return $tmp;
}

/**
* this searches for static pages matching the user query and returns an array of 
* for the header and table rows back to search.php where it will be formated and
* printed 
*
* @query            string          Keywords user is looking for
* @datestart        date/time       Start date to get results for
* @dateend          date/time       End date to get results for
* @topic            string          The topic they were searching in
* @type             string          Type of items they are searching
* @author           string          Get all results by this author
*
*/
function plugin_dopluginsearch_staticpages($query, $datestart, $dateend, $topic, $type, $author) 
{
	global $_TABLES, $_CONF, $LANG_STATIC;

    if (empty($type)) {
        $type = 'all';
    }
    
    // Bail if we aren't supppose to do our search
    if ($type <> 'all' AND $type <> 'staticpages') {
        $plugin_results = new Plugin();
        $plugin_results->plugin_name = 'staticpages';
        $plugin_results->searchlabel = $LANG_STATIC['results'];
        return $plugin_results;
    }

    // Build search SQL
	$sql = "SELECT sp_id,sp_content,sp_title,sp_hits,sp_uid,UNIX_TIMESTAMP(sp_date) as day FROM staticpage WHERE ";
    $sql .= "((sp_content like '%$query%' OR sp_content like '$query%' OR sp_content like '%$query') ";
    $sql .= "OR (sp_title like '%$query%' OR sp_title like '$query%' OR sp_title like '%$query')) ";

    if (!empty($datestart) && !empty($dateend)) {
        $delim = substr($datestart, 4, 1);
        $DS = explode($delim,$datestart);
        $DE = explode($delim,$dateend);
        $startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
        $enddate = mktime(0,0,0,$DE[1],$DE[2],$DE[0]) + 3600;
        $sql .= "AND (UNIX_TIMESTAMP(sp_date) BETWEEN '$startdate' AND '$enddate') ";
    }

    if (!empty($author)) {
        $sql .= "AND (sp_uid = '$author') ";
    }
    $sql    .= "ORDER BY sp_date desc";

    // Perform search
    $result = DB_query($sql);
    
    // OK, now return coma delmited string of table header labels
    require_once($_CONF['path_system'] . 'classes/plugin.class.php');
    $plugin_results = new Plugin();
    $plugin_results->plugin_name = 'staticpages';
    $plugin_results->searchlabel = $LANG_STATIC['results'];
    $plugin_results->addSearchHeading($LANG_STATIC['title']);
    $plugin_results->addSearchHeading($LANG_STATIC['date']);
    $plugin_results->addSearchHeading($LANG_STATIC['author']);
    $plugin_results->addSearchHeading($LANG_STATIC['hits']);
    $plugin_results->num_searchresults = DB_numRows($result);

    // NOTE if any of your data items need to be links then add them here! 
    // make sure data elements are in an array and in the same order as your
    // headings above!
	for ($i = 1; $i <= $plugin_results->num_searchresults; $i++) {
        $A = DB_fetchArray($result);
        $thetime = COM_getUserDateTimeFormat($A['day']);
        $row = array("<a href={$_CONF['site_url']}/staticpages/index.php?page={$A['sp_id']}>{$A['sp_title']}</a>",
                    $thetime[0],
                    DB_getItem($_TABLES['users'],'username',"uid = '{$A["sp_uid"]}'"),
                    $A['sp_hits']);
        $plugin_results->addSearchResult($row);
	}
    $plugin_results->num_itemssearched = DB_count('staticpage');

    return $plugin_results;
}

/**
* This will put an option for static pages in the command and control block on
* moderation.php
*
*/
function plugin_cclabel_staticpages() 
{
    global $LANG_STATIC, $_CONF;

    return array($LANG_STATIC['staticpages'],$_CONF['site_admin_url'] . '/plugins/staticpages/index.php',$_CONF['site_url'] . '/staticpages/images/staticpages.gif');
}

/**
* returns the administrative option for this plugin
*
*/
function plugin_getadminoption_staticpages() 
{
    global $_CONF, $LANG_STATIC;

    if (SEC_hasRights('staticpages.edit,staticpages.delete','OR')) {
        return array($LANG_STATIC[staticpages], $_CONF['site_admin_url'] . '/plugins/staticpages/index.php', DB_count(staticpage));
    }	
}

?>
