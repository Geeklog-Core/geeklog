<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 1.0                                                          |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the Static     |
// | Pages' PHP files.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
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
// $Id: functions.inc,v 1.4 2005/06/15 19:57:56 trinity Exp $

$langfile = $_CONF['path'] . 'plugins/polls/language/'
          . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    include ($langfile);
} else {
    include ($_CONF['path'] . 'plugins/polls/language/english.php');
}

include ($_CONF['path'] . 'plugins/polls/config.php');

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
function plugin_getmenuitems_polls()
{
    if( $anon && $_PO_CONF['pollsloginrequired'] ) {
        exit;
    } else {
        $menuitems['Polls'] = '/polls/index.php';
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
function plugin_commentsupport_polls() 
{
    // polls will use comments
    return true;
}

/**
* Shows the statistics for the Polls plugin on stats.php.
* If $showsitestats is 1 then we are to only print the overall stats in the
* 'site statistics box' otherwise we show the detailed stats
*
* @param    int     showsitestate   Flag to let us know which stats to get
*/
/*
function plugin_showstats_polls($showsitestats) 
{
    global $_CONF, $_TABLES, $LANG_POLLS;

    $retval = '';

    $stat_templates = new Template ($_CONF['path_layout'] . 'stats');
    $stat_templates->set_file (array ('itemstats' => 'itemstatistics.thtml',
                                      'statrow'   => 'singlestat.thtml'));
    if ($showsitestats == 1) {
        $perms = SP_getPerms ();
        if (!empty ($perms)) {
            $perms = ' WHERE ' . $perms;
        }
        $result = DB_query ("SELECT count(*) AS cnt FROM {$_TABLES['staticpage']}" . $perms);
        $A = DB_fetchArray ($result);
        $total_pages = $A['cnt'];
        $retval = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';
        $retval .= '<tr><td>' . $LANG_STATIC['polls'] . '</td>';
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
                $stat_templates->set_var ('item_url', COM_buildURL ($_CONF['site_url'] . '/polls/index.php?page=' . $A['sp_id']));
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
*/


/*

whats new block

    $powhere = '';

    if( !empty( $_USER['uid'] ))
    {
        $powhere .= "({$_TABLES['pollquestions']}.owner_id IS NOT NULL AND {$_TABLES['pollquestions']}.perm_owner IS NOT NULL) OR ";
        $powhere .= "({$_TABLES['pollquestions']}.group_id IS NOT NULL AND {$_TABLES['pollquestions']}.perm_group IS NOT NULL) OR ";
        $powhere .= "({$_TABLES['pollquestions']}.perm_members IS NOT NULL)";
    }
    else
    {
        $powhere .= "({$_TABLES['pollquestions']}.perm_anon IS NOT NULL)";
        }

*/


/**
* Geeklog is asking us to provide any new items that show up in the type
* drop-down on search.php.  Let's let users search static pages!
*
*/
function plugin_searchtypes_polls() 
{
    global $LANG_POLLS;

    $tmp['polls'] = $LANG_POLLS['polls'];

    return $tmp;
}


/**
* this searches for static pages matching the user query and returns an array of
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
*
* Oct 05/2002: Blaine Lang, Corrected bug with SQL Search string. 
*/
/*
function plugin_dopluginsearch_polls($query, $datestart, $dateend, $topic, $type, $author, $keyType) 
{
    global $_CONF, $_TABLES, $LANG_POLLS;

    if (empty($type)) {
        $type = 'all';
    }

    // Bail if we aren't supppose to do our search
    if ($type <> 'all' AND $type <> 'polls') {
        $plugin_results = new Plugin();
        $plugin_results->plugin_name = 'polls';
        $plugin_results->searchlabel = $LANG_STATIC['results'];
        return $plugin_results;
    }

    // Build search SQL - exclude static PHP pages from search.
    $sql = "SELECT *,UNIX_TIMESTAMP(sp_date) AS day FROM " . $_TABLES['staticpage'] . " WHERE (sp_php != 1)";

    if (!empty ($query)) {
        if ($keyType == 'phrase') {
            $mysearchterm = addslashes ($query);
            $sql .= " AND ((sp_content LIKE '%$mysearchterm%')"
                 . " OR (sp_title LIKE '%$mysearchterm%'))";
        } else if ($keyType == 'all') {
            $mywords = explode (' ', $query);
            $sql .= ' AND (';
            $tmp = '';
            foreach ($mywords AS $mysearchterm) {
                $mysearchterm = addslashes (trim ($mysearchterm));
                if (!empty ($mysearchterm)) {
                    $tmp .= "(sp_content LIKE '%$mysearchterm%')"
                         . " OR (sp_title LIKE '%$mysearchterm%') AND ";
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
                    $tmp .= "(sp_content LIKE '%$mysearchterm%')"
                         . " OR (sp_title LIKE '%$mysearchterm%') OR ";
                }
            }
            $tmp = substr ($tmp, 0, strlen ($tmp) - 4);
            $sql .= $tmp . ')';
        } else {
            $mysearchterm = addslashes ($query);
            $sql .= " AND ((sp_content LIKE '%$mysearchterm%')"
                 . " OR (sp_title LIKE '%$mysearchterm%'))";
        }
    }

    if (!empty ($datestart) && !empty ($dateend)) {
        $delim = substr ($datestart, 4, 1);
        $DS = explode ($delim, $datestart);
        $DE = explode ($delim, $dateend);
        $startdate = mktime (0, 0, 0, $DS[1], $DS[2], $DS[0]);
        $enddate = mktime (23, 59, 59, $DE[1], $DE[2], $DE[0]);
        $sql .= " AND (UNIX_TIMESTAMP(sp_date) BETWEEN '$startdate' AND '$enddate')";
    }

    if (!empty ($author)) {
        $sql .= "AND (sp_uid = '$author')";
    }
    $sql    .= " ORDER BY sp_date desc";

    // Perform search
    $result = DB_query ($sql);

    // OK, now return coma delmited string of table header labels
    $plugin_results = new Plugin();
    $plugin_results->plugin_name = 'polls';
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
            $row = array ('<a href="' . COM_buildURL ($_CONF['site_url'] . '/polls/index.php?page=' . $A['sp_id']) . '">' . $A['sp_title'] . '</a>',
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

*/
/**
* This will put an option for polls in the command and control block on
* moderation.php
*
*/
function plugin_cclabel_polls() 
{
    global $LANG_POLLS, $_CONF;

    if (SEC_hasRights ('polls.edit,polls.delete', 'OR')) {
        return array ($LANG_POLLS[16],
                $_CONF['site_admin_url'] . '/plugins/polls/index.php',
                $_CONF['site_url'] . '/polls/images/polls.gif');
    }

    return false;
}

/**
* returns the administrative option for this plugin
*
*/

function plugin_getadminoption_polls()
{
    global $_CONF, $LANG_POLLS, $_TABLES;

    if (SEC_hasRights ('polls.edit,polls.delete', 'OR')) {
        $result = DB_query ("SELECT count(*) AS cnt FROM {$_TABLES['pollquestions']}" . COM_getPermSQL ());
        $A = DB_fetchArray ($result);
        $total_pages = $A['cnt'];
        return array ($LANG_POLLS[1], $_CONF['site_admin_url'] . '/plugins/polls/index.php', $total_pages);
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
* @param    string  $table  Table name (used in joins)
* @param    int     $access Access if blank read access  2 = read 3 = read/edit
* @param    int     $u_id   User ID if blank current user
* @return   string          Where clause of sql statement
*
*/
/*
function POLLS_getPerms ($table = '', $access = '2', $u_id = '')
{
    global $_USER, $_GROUPS;

    if ($table != '') { $table .= '.'; }

    if ($u_id == '') {
        if (isset ($_USER['uid'])) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }
        $GROUPS = $_GROUPS;
    } else {
        $uid = $u_id;
        $GROUPS = SEC_getUserGroups ($uid);
	}

    $sql = '(';

    if ($uid > 1) {
        $sql .= "((owner_id = '{$uid}') AND (perm_owner >= $access)) OR ";

        $sql .= "((group_id IN (" . implode (',', $GROUPS) . ")) "
             . "AND (perm_group >= $access)) OR (perm_members >= $access)";
    } else {
        $sql .= "perm_anon >= $access";
    }

    $sql .= ')';

    return $sql;
}
*/
/**
* Display static pages in the center block.
*
* @param   where   int      where the static page will be displayed (0..3)
* @param   page    int      page number
* @param   topic   string   topic ID
* @return          string   HTML for the static page (can be empty)
*/
/*
function plugin_centerblock_polls ($where = 1, $page = 1, $topic ='')
{
    global $_CONF, $_TABLES, $_POLLS_CONF, $LANG_STATIC, $HTTP_GET_VARS;

    $retval = '';

    if ($page > 1) {
        return $retval; // we only support page 1 at the moment ...
    }

    $moresql = "(sp_where = $where) AND ";
    $displayFeatured = false;

    // If there are no featured stories, we won't be called with $where == 2.
    // So, if asked to display pages for the top of the page, check if we
    // have pages to be displayed after the featured story and if there is
    // no featured story, display those pages as well.
    if (($where == 1) && ($_CONF['showfirstasfeatured'] == 0)) {
        if (DB_count ($_TABLES['stories'], 'featured', 1) == 0) {
            // no featured story found - redefine $moresql
            $moresql = "(sp_where = 1 OR sp_where = 2) AND ";
            $displayFeatured = true;
        }
    }

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
    if ($displayFeatured) {
        $sort = 'sp_where,' . $sort;
    }

    $perms = SP_getPerms ();
    if (!empty ($perms)) {
        $perms = ' AND ' . $perms;
    }
    $spsql = "SELECT sp_id,sp_content,sp_title,sp_format,sp_php,sp_inblock FROM {$_TABLES['staticpage']} WHERE (sp_centerblock = 1) AND " . $moresql . $perms . " ORDER BY " . $sort;
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

            if (($spresult['sp_inblock'] == 1) && !empty ($spresult['sp_title'])
                && (($where != 0) || ($spresult['sp_format'] != 'blankpage'))) {
                $retval .= COM_startBlock ($spresult['sp_title'], '',
                    COM_getBlockTemplate ('_polls_centerblock', 'header'));
            }

            if ($_SP_CONF['allow_php'] == 1) {
                // Check for type (ie html or php)
                if ($spresult['sp_php'] == 1) {
                    $retval .= eval (stripslashes ($spresult['sp_content']));
                } else if ($spresult['sp_php'] == 2) {
                    ob_start ();
                    eval (stripslashes ($spresult['sp_content']));
                    $retval .= ob_get_contents ();
                    ob_end_clean ();
                } else {
                    $retval .= PLG_replacetags (stripslashes ($spresult['sp_content']));
                }
            } else {
                if ($spresult['sp_php'] != 0) {
                    COM_errorLog ("PHP in static pages is disabled. Can not display page '$sp_id'.", 1);
                    $retval .= $LANG_STATIC['deny_msg'];
                } else {
                    $retval .= stripslashes ($spresult['sp_content']);
                }
            }

            if (($spresult['sp_inblock'] == 1) && !empty ($spresult['sp_title'])
                && (($where != 0) || ($spresult['sp_format'] != 'blankpage'))) {
                $retval .= COM_endBlock (COM_getBlockTemplate ('_polls_centerblock', 'footer'));
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
*/
/**
* A user is about to be deleted. Update ownership of any static pages owned
* by that user or delete them.
*
* @param   uid   int   User id of deleted user
*
*/
/*
function plugin_user_delete_polls($uid)
{
    global $_TABLES, $_POLLS_CONF;

    if (DB_count ($_TABLES['staticpage'],
            "(sp_uid = $uid) OR (owner_id = $uid)") == 0) {
        return;
    }

    if ($_SP_CONF['delete_pages'] == 1) {
        // delete the pages
        DB_query ("DELETE FROM {$_TABLES['staticpage']} WHERE (sp_uid = $uid) OR (owner_id = $uid)");
    } else {
        // assign ownership to a user from the Root group
        $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id',
                                 "grp_name = 'Root'");
        $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
        $A = DB_fetchArray ($result);
        $rootuser = $A['ug_uid'];

        DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_uid = $rootuser WHERE sp_uid = $uid");
        DB_query ("UPDATE {$_TABLES['staticpage']} SET owner_id = $rootuser WHERE owner_id = $uid");
    }
}
*/

/**
* Return the current version of code. 
* Used in the Plugin Editor to show the registered version and code version
*/
function plugin_chkVersion_polls()
{
    global $_POLLS_CONF;

    return $_POLLS_CONF['version'];
}

/**
* Implements the [staticpage:] autotag.
*
*/
/*
function plugin_autotags_polls ($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES;

    if ($op == 'tagname' ) {
        return 'staticpage';
    } else if ($op == 'parse') {
        $sp_id = COM_applyFilter ($autotag['parm1']);
        $url = COM_buildUrl ($_CONF['site_url'] . '/polls/index.php?page='
                             . $sp_id);
        if (empty ($autotag['parm2'])) {
            $linktext = stripslashes (DB_getItem ($_TABLES['polls'],
                                      'sp_title', "sp_id = '$sp_id'"));
        } else {
            $linktext = $autotag['parm2'];
        }
        $link = '<a href="' . $url . '">' . $linktext . '</a>';
        $content = str_replace ($autotag['tagstr'], $link, $content);

        return $content;
    }
}
*/
/**
* Removes the datastructures for this plugin from the Geeklog database
*
* This may get called by the install routine to undo anything done to this
* point.  To do that, $steps will have a list of steps to undo
*
* @steps   Array    Holds all the steps that have been completed by the install
*
*/  
function plugin_uninstall_polls($steps = '')
{
    global $_TABLES;

    // Uninstalls the static pages plugin

    if (empty($steps) OR $steps['createtable'] == 1) {
        // Remove the staticpage table 
        COM_errorLog('Dropping staticpage table',1);
        //DB_query("DROP TABLE {$_TABLES['staticpage']}");
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
    $edit_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'polls.edit'");
    $delete_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'polls.delete'");
    $php_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'polls.PHP'");

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
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'polls'");
    COM_errorLog('...success',1);

    COM_errorLog('leaving plugin_uninstall_polls',1);

    return true;
}

/**
* Get path for the template files.
*
* @param    string  $path   subdirectory within the base template path
* @return   string          full path to template directory
*
*/
function polls_templatePath ($path = '')
{
    global $_CONF;

    if (empty ($path)) {
        $layout_path = $_CONF['path_layout'] . polls;
    } else {
        $layout_path = $_CONF['path_layout'] . polls . '/' . $path;
    }

    if (is_dir ($layout_path)) {
        $retval = $layout_path;
    } else {
        $retval = $_CONF['path'] . 'plugins/polls/templates';
        if (!empty ($path)) {
            $retval .= '/' . $path;
        }
    }

    return $retval;
}



 
/**
* Shows a poll form
*
* Shows an HTML formatted poll for the given question ID
*
* @param      string      $qid      ID for poll question
* @see function COM_pollResults
* @see function COM_showPoll
* @return       string  HTML Formatted Poll
*
*/

function POLLS_pollVote( $qid )
{
    global $_CONF, $_TABLES, $LANG01, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS;

    $retval = '';

    $question = DB_query( "SELECT question,voters,commentcode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid='$qid'" );
    $Q = DB_fetchArray( $question );

    if( SEC_hasAccess( $Q['owner_id'], $Q['group_id'], $Q['perm_owner'], $Q['perm_group'], $Q['perm_members'], $Q['perm_anon'] ) == 0 )
    {
        return $retval;
    }

    $nquestion = DB_numRows( $question );
    $fields = array( 'ipaddress', 'qid' );
    $values = array( $HTTP_SERVER_VARS['REMOTE_ADDR'], $qid );
    $id = DB_count( $_TABLES['pollvoters'], $fields, $values );

    if( empty( $HTTP_COOKIE_VARS[$qid] ) && $id == 0 )
    {
        if( $nquestion == 1 )
        {
            $answers = DB_query( "SELECT answer,aid FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY aid" );
            $nanswers = DB_numRows( $answers );

            if( $nanswers > 0 )
            {
                $poll = new Template( $_CONF['path'] . 'plugins/polls/templates/' );
                $poll->set_file( array( 'panswer' => 'pollanswer.thtml',
                                        'block' => 'pollblock.thtml',
                                        'comments' => 'pollcomments.thtml' ));
                $poll->set_var( 'site_url', $_CONF['site_url'] );
                $poll->set_var( 'layout_url', $_CONF['layout_url'] );

                $poll->set_var( 'poll_question', $Q['question'] );
                $poll->set_var( 'poll_id', $qid );
                $poll->set_var( 'num_votes', $Q['voters'] );
                $poll->set_var( 'poll_vote_url', $_CONF['site_url']
                        . '/polls/index.php');
                $poll->set_var( 'poll_results_url', $_CONF['site_url']
                        . '/polls/index.php?qid=' . $qid . '&amp;aid=-1');

                $poll->set_var( 'lang_vote', $LANG01[56] );
                $poll->set_var( 'lang_votes', $LANG01[8] );
                $poll->set_var( 'lang_results', $LANG01[6] );

                for( $i = 1; $i <= $nanswers; $i++ )
                {
                    $A = DB_fetchArray( $answers );
                    $poll->set_var( 'answer_id', $A['aid'] );
                    $poll->set_var( 'answer_text', $A['answer'] );
                    $poll->parse( 'poll_answers', 'panswer', true );
                }

                if( $Q['commentcode'] >= 0 )
                {
                    $poll->set_var( 'num_comments',
                            DB_count( $_TABLES['comments'], 'sid', $qid ));
                    $poll->set_var( 'lang_comments', $LANG01[3] );
                    $poll->set_var( 'poll_comments_url', $_CONF['site_url'] .
                        '/polls/index.php?qid=' . $qid . '&amp;aid=-1#comments');
                    $poll->parse( 'poll_comments', 'comments', true );
                }
                else
                {
                    $poll->set_var( 'poll_comments', '' );
                    $poll->set_var( 'poll_comments_url', '' );
                }

                $title = DB_getItem( $_TABLES['blocks'], 'title', "name='poll_block'" );
                $retval =  $poll->finish( $poll->parse( 'output', 'block' )) . LB;
            }
        }
    }
    else
    {
        $retval .= POLLS_pollResults( $qid );
    }

    return $retval;
}

/**
* This shows a poll
*
* This will determine if a user needs to see the poll form OR the poll
* result.
*
* @param        int        $sise       Size in pixels of poll results
* @param        string     $qid        Question ID to show (optional)
* @see function COM_pollVote
* @see function COM_pollResults
* @return    String  HTML Formated string of Poll
*
*/

function POLLS_showPoll( $size, $qid='' )
{
    global $_CONF, $_PO_CONF, $_TABLES, $HTTP_COOKIE_VARS, $HTTP_SERVER_VARS;

    $retval = '';

    DB_query( "DELETE FROM {$_TABLES['pollvoters']} WHERE date < unix_timestamp() - {$_PO_CONF['polladdresstime']}" );

    if( !empty( $qid ))
    {
        $pcount = DB_count( $_TABLES['pollvoters'], array( 'ipaddress', 'qid' ),
                            array( $HTTP_SERVER_VARS['REMOTE_ADDR'], $qid ));

        if( empty( $HTTP_COOKIE_VARS[$qid]) && $pcount == 0 )
        {
            $retval .= POLLS_pollVote( $qid );
        }
        else
        {
            $retval .= POLLS_pollResults( $qid, $size );
        }
    }
    else
    {
        $result = DB_query( "SELECT qid from {$_TABLES['pollquestions']} WHERE display = 1 ORDER BY date DESC" );
        $nrows = DB_numRows( $result );

        if( $nrows > 0 )
        {
            for( $i = 1; $i <= $nrows; $i++ )
            {
                $Q = DB_fetchArray( $result );
                $qid = $Q['qid'];
                $id = array( 'ipaddress', 'qid' );
                $value = array( $HTTP_SERVER_VARS['REMOTE_ADDR'], $qid );
                $pcount = DB_count( $_TABLES['pollvoters'], $id, $value );

                if( !isset( $HTTP_COOKIE_VARS[$qid]) && $pcount == 0 )
                {
                    $retval .= POLLS_pollVote( $qid );
                }
                else
                {
                    $retval .= POLLS_pollResults( $qid, $size );
                }
            }
        }
    }

    return $retval;
}

/**
* Shows the results of a poll
*
* Shows the poll results for a give poll question
*
* @param        string      $qid        ID for poll question to show
* @param        int         $scale      Size in pixels to scale formatted results to
* @param        string      $order      'ASC' or 'DESC' for Comment ordering (SQL statment ordering)
* @param        string      $mode       Comment Mode possible values 'nocomment', 'flat', 'nested', 'threaded'
* @see COM_pollVote
* @see COM_showPoll
* @return     string   HTML Formated Poll Results
*
*/
function POLLS_pollResults( $qid, $scale=400, $order='', $mode='' )
{
    global $_TABLES, $LANG01, $LANG07, $_CONF, $_COM_VERBOSE;

    $retval = '';

    $question = DB_query( "SELECT question,voters,commentcode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid='$qid'" );
    $Q = DB_fetchArray( $question );

    if( SEC_hasAccess( $Q['owner_id'], $Q['group_id'], $Q['perm_owner'], $Q['perm_group'], $Q['perm_members'], $Q['perm_anon']) == 0 )
    {
        return $retval;
    }

    $nquestion = DB_numRows( $question );

    if( $nquestion == 1 )
    {
        if( $_PO_CONF['answerorder'] == 'voteorder' )
        {
            $answers = DB_query( "SELECT votes,answer FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY votes DESC" );
        }
        else
        {
            $answers = DB_query( "SELECT votes,answer FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY aid" );
        }

        $nanswers = DB_numRows( $answers );

        if( $_COM_VERBOSE )
        {
            COM_errorLog( "got $answers answers in COM_pollResults", 1 );
        }

        if( $nanswers > 0 )
        {
            $title = DB_getItem( $_TABLES['blocks'], 'title', "name='poll_block'" );

            if( $scale < 120 ) // assume we're in the poll block
            {
                //$retval .= COM_startBlock( $title, '',
                 //       COM_getBlockTemplate( 'poll_block', 'header' ));
            }
            else // assume we're in pollbooth.php
            {
                $retval .= COM_startBlock( $title );
            }

            $poll = new Template( $_CONF['path'] . 'plugins/polls/templates/' );
            $poll->set_file( array( 'result' => 'pollresult.thtml',
                                    'comments' => 'pollcomments.thtml',
                                    'votes_bar' => 'pollvotes_bar.thtml',
                                    'votes_num' => 'pollvotes_num.thtml' ));
            $poll->set_var( 'site_url', $_CONF['site_url'] );
            $poll->set_var( 'layout_url', $_CONF['layout_url'] );

            $poll->set_var( 'poll_question', $Q['question'] );
            $poll->set_var( 'poll_id', $qid );
            $poll->set_var( 'num_votes', $Q['voters'] );

            $poll->set_var( 'lang_votes', $LANG01[8] );

            for( $i = 1; $i <= $nanswers; $i++ )
            {
                $A = DB_fetchArray( $answers );

                if( $Q['voters'] == 0 )
                {
                    $percent = 0;
                }
                else
                {
                    $percent = $A['votes'] / $Q['voters'];
                }

                $poll->set_var( 'answer_text', $A['answer'] );
                $poll->set_var( 'answer_counter', $i );
                $poll->set_var( 'answer_odd', (( $i - 1 ) % 2 ));
                $poll->set_var( 'answer_num', $A['votes'] );
                $poll->set_var( 'answer_percent',
                                sprintf( '%.2f', $percent * 100 ));
                if( $scale < 120 )
                {
                    $poll->parse( 'poll_votes', 'votes_num', true );
                }
                else
                {
                    $width = $percent * $scale;
                    $poll->set_var( 'bar_width', $width );
                    $poll->parse( 'poll_votes', 'votes_bar', true );
                }
            }

            if( $Q['commentcode'] >= 0 )
            {
                $poll->set_var( 'num_comments',
                        DB_count( $_TABLES['comments'], 'sid', $qid ));
                $poll->set_var( 'lang_comments', $LANG01[3] );
                $poll->set_var( 'poll_comments_url', $_CONF['site_url'] .
                        '/polls/index.php?qid=' . $qid . '&amp;aid=-1#comments');
                $poll->parse( 'poll_comments', 'comments', true );
            }
            else
            {
                $poll->set_var( 'poll_comments_url', '' );
                $poll->set_var( 'poll_comments', '' );
            }

            $poll->set_var( 'lang_pollquestions', $LANG07[6] );

            $retval .= $poll->finish( $poll->parse( 'output', 'result' ));

            if( $scale < 120)
            {
                $retval .= COM_endBlock( COM_getBlockTemplate( 'poll_block',
                        'footer' ));
            }
            else
            {
                $retval .= COM_endBlock();
            }
            if( $scale > 399 && $Q['commentcode'] >= 0 )
            {
                $delete_option = ( SEC_hasRights( 'poll.edit' ) &&
                    SEC_hasAccess( $Q['owner_id'], $Q['group_id'],
                    $Q['perm_owner'], $Q['perm_group'], $Q['perm_members'],
                    $Q['perm_anon'] ) == 3 ? true : false );
                $retval .= COM_userComments( $qid, $Q['question'], 'poll',
                                             $order, $mode, 0, 1, false, $delete_option ); 
            }
        }
    }

    return $retval;
}

Function phpblock_polls(){


$retval = POLLS_showPoll( 60 );

return $retval;

}
?>
