<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.3 for Geeklog - The Ultimate Weblog                 |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the Static     |
// | Pages' PHP files.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Tom Willett      - twillett@users.sourceforge.net                |
// |          Blaine Lang      - langmail@sympatico.ca                         |
// |          Dirk Haun        - dirk@haun-online.de                           |
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
// $Id: functions.inc,v 1.24 2003/06/27 13:44:49 dhaun Exp $

$langfile = $_CONF['path'] . 'plugins/staticpages/language/' . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    include ($langfile);
} else {
    include ($_CONF['path'] . 'plugins/staticpages/language/english.php');
}

include ($_CONF['path'] . 'plugins/staticpages/config.php');

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
    global $_CONF, $_TABLES;

    $result = DB_query ('SELECT sp_id, sp_label, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon FROM ' . $_TABLES['staticpage'] . ' WHERE sp_onmenu = 1');
    $nrows = DB_numRows ($result);
    $menuitems = array ();
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray ($result);
        if (SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon'])) {
            $menuitems[$A['sp_label']] = COM_buildURL ($_CONF['site_url'] . "/staticpages/index.php?page={$A['sp_id']}");
    	}
    }
    return $menuitems;
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
function plugin_commentsupport_staticpages() 
{
    // Static Pages will not use comments
    return false;
}

/**
* Shows the statistics for the Static Pages plugin on stats.php.
* If $showsitestats is 1 then we are to only print the overall stats in the
* 'site statistics box' otherwise we show the detailed stats
*
* @showsitestate        int         Flag to let us know which stats to get
*/
function plugin_showstats_staticpages($showsitestats) 
{
    global $LANG_STATIC, $_CONF, $_TABLES;

    $stat_templates = new Template ($_CONF['path_layout'] . 'stats');
    $stat_templates->set_file (array ('itemstats'=>'itemstatistics.thtml',
                                      'statrow'=>'singlestat.thtml'));
    if ($showsitestats == 1) {
        $perms = SP_getPerms ();
        if (!empty ($perms)) {
            $perms = ' WHERE ' . $perms;
        }
        $result = DB_query ("SELECT count(*) AS cnt FROM {$_TABLES['staticpage']}" . $perms);
        $A = DB_fetchArray ($result);
        $total_pages = $A['cnt'];
        $retval = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
        $retval .= '<tr><td>' . $LANG_STATIC['staticpages'] . '</td>';
        $retval .= '<td align="right">' . $total_pages . '&nbsp;&nbsp;</td></tr></table>';
    } else {
        $perms = SP_getPerms ();
        if (!empty ($perms)) {
            $perms = ' AND ' . $perms;
        }
        $result = DB_query ("SELECT sp_id,sp_title,sp_hits FROM {$_TABLES['staticpage']} WHERE sp_hits > 0" . $perms . ' ORDER BY sp_hits DESC LIMIT 10');
        $nrows  = DB_numRows ($result);
        $retval .= COM_startBlock ($LANG_STATIC['stats_headline']);
        if ($nrows > 0) {
            $stat_templates->set_var ('item_label', $LANG_STATIC['stats_page_title']);
            $stat_templates->set_var ('stat_name', $LANG_STATIC['stats_hits']);
            for ($i = 0; $i < $nrows; $i++) {
                $A = DB_fetchArray ($result);
                $stat_templates->set_var ('item_url', COM_buildURL ($_CONF['site_url'] . '/staticpages/index.php?page=' . $A['sp_id']));
                $stat_templates->set_var ('item_text', stripslashes ($A['sp_title']));
                $stat_templates->set_var ('item_stat', $A['sp_hits']);
                $stat_templates->parse ('stat_row','statrow',true); 
            }
            $stat_templates->parse ('output','itemstats');
            $retval .= $stat_templates->finish ($stat_templates->get_var ('output'));
        } else {
            $retval .= $LANG_STATIC['stats_no_hits'];
        }	
        $retval .= COM_endBlock();
    }
    return $retval;
}

/**
* Geeklog is asking us to provide any new items that show up in the type
* drop-down on search.php.  Let's let users search static pages!
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
* Oct 05/2002: Blaine Lang, Corrected bug with SQL Search string. 
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

    // Build search SQL - Modified to exclude static PHP pages from search.
    $sql = "SELECT *,UNIX_TIMESTAMP(sp_date) as day FROM " . $_TABLES['staticpage'] . " WHERE (sp_php != '1' AND";
    $sql .= "((sp_content like '%$query%' OR sp_content like '$query%' OR sp_content like '%$query') ";
    $sql .= "OR (sp_title like '%$query%' OR sp_title like '$query%' OR sp_title like '%$query'))";

    if (!empty ($datestart) && !empty ($dateend)) {
        $delim = substr ($datestart, 4, 1);
        $DS = explode ($delim, $datestart);
        $DE = explode ($delim, $dateend);
        $startdate = mktime (0, 0, 0, $DS[1], $DS[2], $DS[0]);
        $enddate = mktime (23, 59, 59, $DE[1], $DE[2], $DE[0]);
        $sql .= " AND (UNIX_TIMESTAMP(sp_date) BETWEEN '$startdate' AND '$enddate')";
    }

    if (!empty ($author)) {
        $sql .= "AND (sp_uid = '$author') ";
    }
    $sql    .= ") ORDER BY sp_date desc";

    // Perform search
    $result = DB_query ($sql);

    // OK, now return coma delmited string of table header labels
    require_once($_CONF['path_system'] . 'classes/plugin.class.php');
    $plugin_results = new Plugin();
    $plugin_results->plugin_name = 'staticpages';
    $plugin_results->searchlabel = $LANG_STATIC['results'];
    $plugin_results->addSearchHeading ($LANG_STATIC['title']);
    $plugin_results->addSearchHeading ($LANG_STATIC['date']);
    $plugin_results->addSearchHeading ($LANG_STATIC['author']);
    $plugin_results->addSearchHeading ($LANG_STATIC['hits']);
    $mycount = DB_numRows ($result);

    // NOTE if any of your data items need to be links then add them here! 
    // make sure data elements are in an array and in the same order as your
    // headings above!
    for ($i = 1; $i <= $mycount; $i++) {
        $A = DB_fetchArray ($result);

        if (SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon'])) {
            $rcnt++;
            $thetime = COM_getUserDateTimeFormat ($A['day']);
            $A['sp_title'] = stripslashes ($A['sp_title']);
            $row = array ('<a href="' . COM_buildURL ($_CONF['site_url'] . '/staticpages/index.php?page=' . $A['sp_id']) . '">' . $A['sp_title'] . '</a>',
                    $thetime[0],
                    '<a href="' . $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['sp_uid'] . '">' . DB_getItem ($_TABLES['users'], 'username', "uid = '{$A['sp_uid']}'") . '</a>',
                    $A['sp_hits']);
            $plugin_results->addSearchResult ($row);
        }
    }
    $plugin_results->num_searchresults = $rcnt;
    $plugin_results->num_itemssearched = DB_count ($_TABLES['staticpage']);

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

    if (SEC_hasRights ('staticpages.edit,staticpages.delete', 'OR')) {
        return array ($LANG_STATIC['staticpages'],
                $_CONF['site_admin_url'] . '/plugins/staticpages/index.php',
                $_CONF['site_url'] . '/staticpages/images/staticpages.gif');
    }

    return false;
}

/**
* returns the administrative option for this plugin
*
*/
function plugin_getadminoption_staticpages() 
{
    global $_CONF, $LANG_STATIC, $_TABLES;

    if (SEC_hasRights ('staticpages.edit,staticpages.delete', 'OR')) {
        $perms = SP_getPerms ('', '3');
        if (!empty ($perms)) {
            $perms = ' WHERE ' . $perms;
        }
        $result = DB_query ("SELECT count(*) AS cnt FROM {$_TABLES['staticpage']}" . $perms);
        $A = DB_fetchArray ($result);
        $total_pages = $A['cnt'];
        return array ($LANG_STATIC[staticpages], $_CONF['site_admin_url'] . '/plugins/staticpages/index.php', $total_pages);
    }	
}

/**
* Return SQL where statement with appropriate permissions
*
* Takes User id and permission and returns SQL where clause which will return
* the appropriate objects.
* This assumes that the table has the following security structure:
* owner_id        | mediumint(8)          
* group_id        | mediumint(8)          
* perm_owner      | tinyint(1) unsigned   
* perm_group      | tinyint(1) unsigned   
* perm_members    | tinyint(1) unsigned  
* perm_anon       | tinyint(1) unsigned  
* This will work with the standard GL tables
*
* @table	str	Table name (used in joins)
* @access	int	Access if blank read access  2 = read 3 = read/edit
* @u_id int     User ID if blank current user
*
* @return string	Where clause of sql statement
*
*/
function SP_getPerms ($table = '', $access = '2', $u_id = '')
{
    global $_USER, $_GROUPS;

    if ($table != '') { $table .= '.'; }

    if ($u_id == '') {
        $uid = $_USER['uid'];
        $GROUPS = $_GROUPS;
    } else {
        $uid = $u_id;
        $GROUPS = SEC_getUserGroups ($uid);
	}

    if (SEC_inGroup ('Root', $uid)) {
        return '';
    }

    $sql = '(';

    if ($uid > 1) {
        $sql .= "((owner_id = '{$uid}') AND (perm_owner >= $access)) OR ";

        $groupList = '';
        foreach ($GROUPS as $grp) {
            $groupList .= $grp . ',';
        }
        $groupList = substr ($groupList, 0, -1);
        $sql .= "((group_id IN ($groupList)) AND (perm_group >= $access)) OR ";

        $sql .= "(perm_members >= $access)";
    } else {
        $sql .= "perm_anon >= $access";
    }

    $sql .= ')';

    return $sql;
}

/**
* Display static pages in the center block.
*
* @param   where   int      where the static page will be displayed (0..2)
* @param   page    int      page number
* @param   topic   string   topic ID
* @return          string   HTML for the static page (can be empty)
*/
function plugin_centerblock_staticpages ($where = 1, $page = 1, $topic ='')
{
    global $_CONF, $_TABLES, $_SP_CONF, $HTTP_GET_VARS;

    $retval = '';

    if ($page > 1) {
        return $retval; // we only support page 1 at the moment ...
    }

    $moresql = "(sp_where = $where) AND ";
    if (empty ($topic)) {
        $moresql .= "((sp_tid = 'none') OR (sp_tid = 'all'))";
    } else {
        $moresql .= "((sp_tid = '{$topic}') OR (sp_tid = 'all'))";
    }

    if ($_SP_CONF['sort_by'] == 'date') {
        $sort = 'sp_date DESC';
    } else if ($_SP_CONF['sort_by'] == 'title') {
        $sort = 'sp_title';
    } else { // default to "sort by id"
        $sort = 'sp_id';
    }

    $perms = SP_getPerms ();
    if (!empty ($perms)) {
        $perms = ' AND ' . $perms;
    }
    $spsql = "SELECT sp_id,sp_content,sp_title,sp_format,sp_php FROM {$_TABLES['staticpage']} WHERE (sp_centerblock = 1) AND " . $moresql . $perms . " ORDER BY " . $sort;
    $result = DB_query ($spsql);

    $pages = DB_numRows ($result);
    if ($pages > 0) {
        for ($i = 0; $i < $pages; $i++) {
            $spresult = DB_fetchArray ($result);

            if ($where == 0) {
                switch ($spresult['sp_format']) {
                    case 'noblocks':
                        $retval .= COM_siteHeader ('none');
                        break;
                    case 'allblocks':
                    case 'leftblocks':
                        $retval .= COM_siteHeader ('menu');
                        break;
                }
                $retval .= COM_showMessage ($HTTP_GET_VARS['msg']);
            }

            if (($_SP_CONF['in_block'] == 1) && !empty ($spresult['sp_title'])) {
                $retval .= COM_startBlock ($spresult['sp_title']);
            }

            // Check for type (ie html or php)
            if ($spresult['sp_php'] == 1) {
                $retval .= eval (stripslashes ($spresult['sp_content']));
            } else {
                $retval .= stripslashes ($spresult['sp_content']);
            }

            if (($_SP_CONF['in_block'] == 1) && !empty ($spresult['sp_title'])) {
                $retval .= COM_endBlock ();
            }

            if ($where == 0) {
                if ($spresult['sp_format'] == 'allblocks') {
                    $retval .= COM_siteFooter (true);
                } else if ($spresult['sp_format'] != 'blankpage') {
                    $retval .= COM_siteFooter ();
                }
            }

            // increment hit counter for page
            DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_hits = sp_hits + 1 WHERE sp_id = '{$spresult['sp_id']}'");
        }
    }

    return $retval;
}


/**
* Removes the datastructures for this plugin from the Geeklog database
*
* This may get called by the install routine to undo anything done to this
* point.  To do that, $steps will have a list of steps to undo
*
* @steps   Array    Holds all the steps that have been completed by the install
*
*/  
function plugin_uninstall_staticpages($steps = '')
{
    global $_TABLES;

    // Uninstalls the static pages plugin

    if (empty($steps) OR $steps['createtable'] == 1) {
        // Remove the staticpage table 
        COM_errorLog('Dropping staticpage table',1);
        DB_query("DROP TABLE {$_TABLES['staticpage']}");
        COM_errorLog('...success',1);
    }

    // Remove security for this plugin

    // Remove the static page admin group
    $grp_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin'");

    if (empty($steps) OR $steps['insertgroup'] == 1) {
        COM_errorLog('Attempting to remove the Static Page Admin Group', 1);
        DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id");
        COM_errorLog('...success',1);
    }

    // Remove related features
    $edit_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'staticpages.edit'");
    $delete_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'staticpages.delete'");
    $php_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'staticpages.PHP'");

    if (empty($steps) OR $steps['addededittogroup'] == 1) {
        // Remove access to those features 
        COM_errorLog('Attempting to remove rights to staticpage.edit from all groups',1);
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $edit_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['addeddeletetogroup'] == 1) {
        // Remove access to those features 
        COM_errorLog('Attempting to remove rights to staticpage.delete from all groups',1);
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $delete_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['addedphptogroup'] == 1) {
        // Remove access to those features 
        COM_errorLog('Attempting to remove rights to staticpage.PHP from all groups',1);
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $php_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['addedrootuserstogroup'] == 1) {
        // Remove root users from the group
        COM_errorLog('Attempting to remove root users from admin of static pages');
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['insertedfeatureedit'] == 1) {
        COM_errorLog('Attempting to remove the staticpage.edit feature',1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $edit_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['insertedfeaturedelete'] == 1) {
        COM_errorLog('Attempting to remove the staticpage.delete feature',1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $delete_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['insertedphpfeature'] == 1) {
        COM_errorLog('Attempting to remove the staticpage.PHP feature',1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $php_id");
        COM_errorLog('...success',1);
    }

    // Unregister the plugin with Geeklog
    // Always attempt to remove these entries or lib-common.php would still
    // try and read our functions.inc file ...
    COM_errorLog('Attempting to unregister the plugin from Geeklog',1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'staticpages'");
    COM_errorLog('...success',1);

    COM_errorLog('leaving plugin_uninstall_staticpages',1);

    return true;
}

?>
