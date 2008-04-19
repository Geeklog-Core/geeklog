<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | lib-plugins.php                                                           |
// |                                                                           |
// | This file implements plugin support in Geeklog.                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Blaine Lang      - blaine AT portalparts DOT com                 |
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
// $Id: lib-plugins.php,v 1.143 2008/04/19 16:44:39 dhaun Exp $

/**
* This is the plugin library for Geeklog.  This is the API that plugins can
* implement to get tight integration with Geeklog.
* See each function for more details.
*
*/

if (strpos ($_SERVER['PHP_SELF'], 'lib-plugins.php') !== false) {
    die ('This file can not be used on its own!');
}

require_once $_CONF['path_system'] . 'classes/plugin.class.php';

// Response codes for the service invocation PLG_invokeService()
define('PLG_RET_OK',                   0);
define('PLG_RET_ERROR',               -1);
define('PLG_RET_PERMISSION_DENIED',   -2);
define('PLG_RET_AUTH_FAILED',         -3);
define('PLG_RET_PRECONDITION_FAILED', -4);

// buffer for function names for the center block API
$PLG_bufferCenterAPI = array ();
$PLG_buffered = false;

// buffer enabled plugins
$result = DB_query("SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
$_PLUGINS = array();
while ($A = DB_fetchArray($result)) {
    $_PLUGINS[] = $A['pi_name'];
}

/**
* Calls a function for all enabled plugins
*
* @param     string     $function_name      holds name of function to call
*
*/
function PLG_callFunctionForAllPlugins($function_name)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_' . $function_name . '_' . $pi_name;
        if (function_exists($function)) {
            $function();
        }
    }
    $function = 'custom_' . $function_name;
    if (function_exists($function)) {
        $function();
    }
}

/**
* Calls a function for a single plugin
*
* This is a generic function used by some of the other API functions to
* call a function for a specific plugin and, optionally pass parameters.
* This function can handle up to 5 arguments and if more exist it will
* try to pass the entire args array to the function.
*
* @param        string      $function       holds name of function to call
* @param        array       $args           arguments to send to function
* @return       mixed       returns result of function call, otherwise false
*
*/
function PLG_callFunctionForOnePlugin($function, $args='')
{
    if (function_exists($function)) {
        if (empty ($args)) {
            $args = array ();
        }

        // great, function exists, run it
        switch (count($args)) {
        case 0:
            return $function();
            break;
        case 1:
            return $function($args[1]);
            break;
        case 2:
            return $function($args[1], $args[2]);
            break;
        case 3:
            return $function($args[1], $args[2], $args[3]);
            break;
        case 4:
            return $function($args[1], $args[2], $args[3], $args[4]);
            break;
        case 5:
            return $function($args[1], $args[2], $args[3], $args[4], $args[5]);
            break;
        case 6:
            return $function($args[1], $args[2], $args[3], $args[4], $args[5], $args[6]);
            break;
        case 7:
            return $function($args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]);
            break;
        default:
            return $function($args);
            break;
        }
    } else {
        return false;
    }
}

/**
* Tells a plugin to install itself. NOTE: not currently used anymore
*
* @param        string      $type       Plugin name
* @return       boolean     Returns true on success otherwise false
*
*/
function PLG_install($type)
{
    return PLG_callFunctionForOnePlugin('plugin_install_' . $type);
}

/**
* Upgrades a plugin. Tells a plugin to upgrade itself.
*
* @param        string      $type       Plugin name
* @return       boolean     Returns true on success otherwise false
*
*/
function PLG_upgrade($type)
{
    return PLG_callFunctionForOnePlugin('plugin_upgrade_' . $type);
}

/**
* Calls the plugin function to return the current version of code.
* Used to indicate to admin if an update or upgrade is requied.
*
* @param        string      $type       Plugin name
* @return       boolean     Returns true on success otherwise false
*
*/
function PLG_chkVersion($type)
{
    return PLG_callFunctionForOnePlugin('plugin_chkVersion_' . $type);
}

/**
* Tells a plugin to uninstall itself.
*
* @param        string      $type       Plugin to uninstall
* @return       boolean     Returns true on success otherwise false
*
*/
function PLG_uninstall ($type)
{
    global $_PLUGINS, $_TABLES;

    if (empty ($type)) {
        return false;
    }

    if (function_exists('plugin_autouninstall_' . $type)) {
        COM_errorLog ("Auto-uninstalling plugin $type:", 1);
        $function = 'plugin_autouninstall_' . $type;
        $remvars = $function();

        if (empty ($remvars) || $remvars == false) {
            return false;
        }

        // removing tables
        for ($i=0; $i < count($remvars['tables']); $i++) {
            COM_errorLog ("Dropping table {$_TABLES[$remvars['tables'][$i]]}", 1);
            DB_query ("DROP TABLE {$_TABLES[$remvars['tables'][$i]]}");
            COM_errorLog ('...success', 1);
        }

        // removing variables
        for ($i = 0; $i < count($remvars['vars']); $i++) {
            COM_errorLog ("Removing variable {$remvars['vars'][$i]}", 1);
            DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = '{$remvars['vars'][$i]}'");
            COM_errorLog ('...success', 1);
        }

        // removing groups
        for ($i = 0; $i < count($remvars['groups']); $i++) {
            $grp_id = DB_getItem ($_TABLES['groups'], 'grp_id',
                                  "grp_name = '{$remvars['groups'][$i]}'");
            if (!empty ($grp_id)) {
                COM_errorLog ("Attempting to remove the {$remvars['groups'][$i]} group", 1);
                DB_query ("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id");
                COM_errorLog ('...success', 1);
                COM_errorLog ("Attempting to remove the {$remvars['groups'][$i]} group from all groups.", 1);
                DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id");
                COM_errorLog ('...success', 1);
            }
        }

        // removing features
        for ($i = 0; $i < count($remvars['features']); $i++) {
            $access_id = DB_getItem ($_TABLES['features'], 'ft_id',
                                    "ft_name = '{$remvars['features'][$i]}'");
            if (!empty ($access_id)) {
                COM_errorLog ("Attempting to remove {$remvars['features'][$i]} rights from all groups" ,1);
                DB_query ("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $access_id");
                COM_errorLog ('...success', 1);
                COM_errorLog ("Attempting to remove the {$remvars['features'][$i]} feature", 1);
                DB_query ("DELETE FROM {$_TABLES['features']} WHERE ft_name = '{$remvars['features'][$i]}'");
                COM_errorLog ('...success', 1);
            }
        }

        // uninstall feeds
        $sql = "SELECT filename FROM {$_TABLES['syndication']} WHERE type = '$type';";
        $result = DB_query( $sql );
        $nrows = DB_numRows( $result );
        if ( $nrows > 0 ) {
            COM_errorLog ('removing feed files', 1);
            COM_errorLog ($nrows. ' files stored in table.', 1);
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
            COM_errorLog ('...success', 1);
            // Remove Links Feeds from syndiaction table
            COM_errorLog ('removing links feeds from table', 1);
            DB_query ("DELETE FROM {$_TABLES['syndication']} WHERE `type` = '$type'");
            COM_errorLog ('...success', 1);
        }

        // remove comments for this plugin
        COM_errorLog ("Attempting to remove comments for $type", 1);
        DB_query ("DELETE FROM {$_TABLES['comments']} WHERE type = '$type'");
        COM_errorLog ('...success', 1);

        // uninstall php-blocks
        for ($i=0; $i <  count($remvars['php_blocks']); $i++) {
            DB_delete ($_TABLES['blocks'], array ('type',     'phpblockfn'),
                                           array ('phpblock', $remvars['php_blocks'][$i]));
        }

        // remove config table data for this plugin
        COM_errorLog ("Attempting to remove config table records for group_name: $type", 1);
        DB_query ("DELETE FROM {$_TABLES['conf_values']} WHERE group_name = '$type'");
        COM_errorLog ('...success', 1);

        // uninstall the plugin
        COM_errorLog ("Attempting to unregister the $type plugin from Geeklog", 1);
        DB_query ("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = '$type'");
        COM_errorLog ('...success',1);

        COM_errorLog ("Finished uninstalling the $type plugin.", 1);

        return true;
    } else {

        $retval = PLG_callFunctionForOnePlugin ('plugin_uninstall_' . $type);

        if ($retval === true) {
            $plg = array_search ($type, $_PLUGINS);
            if ($plg !== false) {
                unset ($_PLUGINS[$plg]);
            }

            return true;

        }
    }

    return false;
}

/**
* Inform plugin that it is either being enabled or disabled.
*
* @param    string      $type       Plugin name
* @param    boolean     $enable     true if enabling, false if disabling
* @return   boolean     Returns true on success otherwise false
*
*/
function PLG_enableStateChange ($type, $enable)
{
   global $_CONF, $_TABLES, $_DB_table_prefix;

    $args[1] = $enable;

    // IF we are enabling the plugin
    // THEN we must include its functions.inc so we have access to the function
    if ($enable) {
        require_once ($_CONF['path'] . 'plugins/' . $type . '/functions.inc');
    }

    return PLG_callFunctionForOnePlugin ('plugin_enablestatechange_' . $type,
                                         $args);
}

/**
* Checks to see if user is a plugin moderator
*
* Geeklog is asking if the user is a moderator for any installed plugins.
*
* @return   boolean     True if current user is moderator of plugin otherwise false
*
*/
function PLG_isModerator()
{
    return PLG_callFunctionForAllPlugins('ismoderator');
}

/**
* Gives plugins a chance to print their menu items in header
*
* Note that this is fairly unflexible.  This simply loops through the plugins
* in the database in the order they were installed and get their menu items.
* If you want more flexibility in your menu then you should hard code the menu
* items in header.thtml for the theme(s) you are using.
*
* @return   array   Returns menu options for plugin
*
*/
function PLG_getMenuItems()
{
    global $_PLUGINS;

    $menu = array();
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getmenuitems_' . $pi_name;
        if (function_exists($function)) {
            $menuitems = $function();
            if (is_array ($menuitems)) {
                $menu = array_merge ($menu, $menuitems);
            }
        }
    }

    return $menu;
}

/**
 * Get view URL and name of unique identifier
 *
 * @author Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @param   string  $type   Plugin to delete comment
 * @return  array   string of URL of view page, name of unique identifier
 */
function PLG_getCommentUrlId($type)
{
    global $_CONF;

    $ret = PLG_callFunctionForOnePlugin('plugin_getcommenturlid_' . $type);
    if (empty($ret[0])) {
        $ret[0] = $_CONF['site_url'] . "/$type/index.php";
    }
    if (empty($ret[1])) {
        $ret[1] = 'id';
    }

    return $ret;
}

/**
 * Plugin should delete a comment
 *
 * @author Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @param   string  $type   Plugin to delete comment
 * @param   int     $cid    Comment to be deleted
 * @param   string  $id     Item id to which $cid belongs
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function PLG_commentDelete($type, $cid, $id)
{
    $args[1] = $cid;
    $args[2] = $id;

    return PLG_callFunctionForOnePlugin('plugin_deletecomment_' . $type, $args);
}

/**
 * Plugin should save a comment
 *
 * @author Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @param   string  $type   Plugin to delete comment
 * @param   string  $title  comment title
 * @param   string  $comment comment text
 * @param   string  $id     Item id to which $cid belongs
 * @param   int     $pid    comment parent
 * @param   string  $postmode 'html' or 'text'
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function PLG_commentSave($type, $title, $comment, $id, $pid, $postmode)
{
    $args[1] = $title;
    $args[2] = $comment;
    $args[3] = $id;
    $args[4] = $pid;
    $args[5] = $postmode;

    return PLG_callFunctionForOnePlugin('plugin_savecomment_' . $type, $args);
}

/**
 * Plugin should display [a] comment[s]
 *
 * @author Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @param   string  $type   Plugin to display comment
 * @param   string  $id     Unique idenifier for item comment belongs to
 * @param   int     $cid    Comment id to display (possibly including sub-comments)
 * @param   string  $title  Page/comment title
 * @param   string  $order  'ASC' or 'DSC' or blank
 * @param   string  $format 'threaded', 'nested', or 'flat'
 * @param   int     $page   Page number of comments to display
 * @param   boolean $view   True to view comment (by cid), false to display (by $pid)
 * @return  mixed   results of calling the plugin_displaycomment_ function
 */
function PLG_displayComment($type, $id, $cid, $title, $order, $format, $page, $view)
{
    $args[1] = $id;
    $args[2] = $cid;
    $args[3] = $title;
    $args[4] = $order;
    $args[5] = $format;
    $args[6] = $page;
    $args[7] = $view;

    return PLG_callFunctionForOnePlugin('plugin_displaycomment_' . $type, $args);
}

/**
* Allows plugins a chance to handle a comment before GL does.

* This is a first-come-first-serve affair so if a plugin returns an error, other
* plugins wishing to handle comment preprocessing won't get called
*
* @author Tony Bibbs <tony@geeklog.net>
* @access public
* @param integer $uid User ID
* @param string $title Comment title
* @param string $sid Story ID (not always a story, remember!)
* @param integer $pid Parent comment ID
* @param string $type Type of comment
* @param string $postmode HTML or text
* @return an error otherwise false if no errors were encountered
*
*/
function PLG_commentPreSave($uid, &$title, &$comment, $sid, $pid, $type, &$postmode)
{
	global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_commentPreSave_' . $pi_name;
        if (function_exists($function)) {
            $someError = $function($uid, $title, $comment, $sid, $pid, $type, $postmode);
            if ($someError) {
            	// Plugin doesn't want to save the comment
            	return $someError;
            }
        }
    }

    $function = 'custom_commentPreSave';
    if (function_exists($function)) {
        $someError = $function($uid, $title, $comment, $sid, $pid, $type, $postmode);
        if ($someError) {
            // Custom function refused save:
            return $someError;
        }
    }

    return false;
}

/**
* Allows plugins a chance to handle an item before GL does. Modeled
* after the PLG_commentPreSave() function.
*
* This is a first-come-first-serve affair so if a plugin returns an error, other
* plugins wishing to handle comment preprocessing won't get called
*
* @author Mark Evans <mevans@ecsnet.com>
* @access public
* @param string $type Type of item, i.e.; registration, contact ...
* @param string $content item specific content
* @return string empty is no error, error message if error was encountered
*
*/
function PLG_itemPreSave($type, $content)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_itemPreSave_' . $pi_name;
        if (function_exists ($function)) {
            $msgError = $function ($type, $content);
            if (!empty ($msgError)) {
                // Plugin doesn't want to save the item
                return $msgError;
            }
        }
    }

    $function = 'custom_itemPreSave';
    if (function_exists ($function)) {
        $msgError = $function ($type, $content);
        if (!empty ($msgError)) {
            // Custom doesn't want to save the item
            return $msgError;
        }
    }

    return '';
}

/**
* The way this function works is very specific to how Geeklog shows its
* statistics.  On stats.php, there is the top box which gives overall
* statistics for Geeklog and then there are blocks below it that give
* more specific statistics for various components of Geeklog.
*
* This plugin API function suffers from a variety of bugs and bad design
* decisions for which we have to provide backward compatibility, so please
* bear with us ...
*
* The only parameter to this function, $showsitestats, was documented as being
* 1 for the site stats and 0 for the plugin-specific stats. However, the latter
* was always called with a value of 2, so plugins only did a check for 1 and
* "else", which makes extensions somewhat tricky.
* Furthermore, due to the original templates for the site stats, it has
* become standard practice to hard-code a <table> in the plugins as the return
* value for $showsitestats == 1. This table, however, didn't align properly
* with the built-in site stats entries.
*
* Because of all this, the new mode, 3, works differently:
* - for $showsitestats == 3, we call a new plugin API function,
*   plugin_statssummary_<plugin-name>, which is supposed to return the plugin's
*   entry for the site stats in an array which stats.php will then properly
*   format, alongside the entries for the built-in items.
* - for $showsitestats == 1, we only call those plugins that do NOT have a
*   plugin_statssummary_<plugin-name> function, thus providing backward
*   compatibility
* - for $showsitestats == 2, nothing has changed
*
* @param    int     $showsitestats      value indicating type of stats to return
* @return   mixed                       array (for mode 3) or string
*
*/
function PLG_getPluginStats ($showsitestats)
{
    global $_PLUGINS;

    if ($showsitestats == 3) {
        $retval = array ();
    } else {
        $retval = '';
    }

    foreach ($_PLUGINS as $pi_name) {
        if ($showsitestats == 3) {
            $function = 'plugin_statssummary_' . $pi_name;
            if (function_exists ($function)) {
                $summary = $function ();
                if (is_array ($summary)) {
                    $retval[$pi_name] = $summary;
                }
            }
        } else if ($showsitestats == 1) {
            $function1 = 'plugin_showstats_' . $pi_name;
            $function2 = 'plugin_statssummary_' . $pi_name;
            if (!function_exists ($function2)) {
                if (function_exists ($function1)) {
                    $retval .= $function1 ($showsitestats);
                }
            }
        } else if ($showsitestats == 2) {
            $function = 'plugin_showstats_' . $pi_name;
            if (function_exists ($function)) {
                $retval .= $function ($showsitestats);
            }
        }
    }

    if ($showsitestats == 3) {
        $function = 'custom_statssummary';
        if (function_exists ($function)) {
            $summary = $function ();
            if (is_array ($summary)) {
                $retval['Custom'] = $summary;
            }
        }
    } else if ($showsitestats == 1) {
        $function1 = 'custom_showstats';
        $function2 = 'custom_statssummary';
        if (!function_exists ($function2)) {
            if (function_exists ($function1)) {
                $retval .= $function1 ($showsitestats);
            }
        }
    } else if ($showsitestats == 2) {
        $function = 'custom_showstats';
        if (function_exists ($function)) {
            $retval .= $function ($showsitestats);
        }
    }

    return $retval;
}

/**
* This function gives each plugin the opportunity to put a value(s) in
* the 'Type' drop down box on the search.php page so that their plugin
* can be incorporated into searches.
*
* @return   array   String array of search types for plugin(s)
*
*/
function PLG_getSearchTypes()
{
    global $_PLUGINS;

    $types = array();
    $cur_types = array();

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_searchtypes_' . $pi_name;
        if (function_exists ($function)) {
            $cur_types = $function ();
            if (is_array ($cur_types) && (count ($cur_types) > 0)) {
                $types = array_merge ($types, $cur_types);
            }
        } // no else because this is not a required API function
    }

    $function = 'custom_searchtypes';
    if (function_exists ($function)) {
        $cur_types = $function ();
        if (is_array ($cur_types) && (count ($cur_types) > 0)) {
            $types = array_merge ($types, $cur_types);
        }
    }

    asort($types);
    return $types;
}

/**
* Determines if a specific plugin supports Geeklog's
* expanded search results feature
*
* @author Tony Bibbs <tony AT geeklog DOT net>
* @access public
* @param string $type Plugin name
* @return boolean True if it is supported, otherwise false
*
* NOTE: This function is not currently used
*
*/
function PLG_supportsExpandedSearch($type)
{
    $retval = '';
    $function = 'plugin_supportsexpandedsearch_' . $type;
    if (function_exists($function)) {
        $retval = $function();
    }
    if (empty($retval) OR !is_bool($retval)) {
        $retval = false;
    }

    return $retval;
}

/**
* This function gives each plugin the opportunity to do their search
* and return their results.  Results comeback in an array of HTML
* formatted table rows that can be quickly printed by search.php
*
* @param    string  $query      What the user searched for
* @param    date    $datestart  beginning of date range to search for
* @param    date    $dateend    ending date range to search for
* @param    string  $topic      the topic the user searched within
* @param    string  $type       Type of items they are searching, or 'all'
* @param    int     $author     UID...only return results for this person
* @param    string  $keyType    search key type: 'all', 'phrase', 'any'
* @param    int     $page       page number of current search
* @param    int     $perpage    number of results per page
* @return   array               Returns search results
*
*/
function PLG_doSearch($query, $datestart, $dateend, $topic, $type, $author, $keyType = 'all', $page = 1, $perpage = 10)
{
    global $_PLUGINS;

    $search_results = array();

    $nrows_plugins = 0;
    $total_plugins = 0;
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_dopluginsearch_' . $pi_name;
        if (function_exists($function)) {
            $plugin_result = $function($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage);
            $nrows_plugins = $nrows_plugins + $plugin_result->num_searchresults;
            $total_plugins = $total_plugins + $plugin_result->num_itemssearched;
            $search_results[] = $plugin_result;
        } // no else because implementation of this API function not required
    }

    $function = 'custom_dopluginsearch';
    if (function_exists($function)) {
        $plugin_result = $function($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage);
        $nrows_plugins = $nrows_plugins + $plugin_result->num_searchresults;
        $total_plugins = $total_plugins + $plugin_result->num_itemssearched;
        $search_results[] = $plugin_result;
    }

    return array($nrows_plugins, $total_plugins, $search_results);
}

/**
* Asks each plugin to report any submissions they may have in their
* submission queue
*
* @return   int     Number of submissions in queue for plugins
*
*/
function PLG_getSubmissionCount()
{
    global $_PLUGINS;

    $num = 0;
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_submissioncount_' . $pi_name;
        if (function_exists($function)) {
            $num = $num + $function();
        }
    }

    return $num;
}

/**
* This function will get & check user or admin options from plugins and check
* required ones for availability. This function is called by several other
* functions and is not to be called from the plugin directly. The function which
* call this here follow below.
*
* NOTE for plugin developers:
* The plugin is responsible for its own security.
* This supports a plugin having either a single menuitem or multiple menuitems.
* The plugin has to provide an array for the menuitem of the format:
* array (menuitem_title, item_url, submission_count)
* or an array of arrays in case there are several entries:
* array (
*   array (menuitem1_title, item1_url, submission1_count),
*   array (menuitem2_title, item2_url, submission2_count),
*   array (menuitem3_title, item3_url, submission3_count))
* Plugin function can return a single record array or multiple records
*
*
* @param    array $var_names    An array of the variables that are retrieved.
*                               This has to match the named array that is used
*                               in the function returning the values
* @param    array $required_names An array of true/false-values, describing
*                                 which of the above listed values is required
*                                 to give a valid set of data.
* @param    string $function_name A string that gives the name of the function
*                                 at the plugin that will return the values.
* @return   array Returns options to add to the given menu that is calling this
*
*/
function PLGINT_getOptionsforMenus($var_names, $required_names, $function_name)
{
    global $_PLUGINS;

    $plgresults = array ();

    $counter = 0;
    foreach ($_PLUGINS as $pi_name) {
        $function = $function_name . $pi_name;
        if (function_exists ($function)) {
            $plg_array = $function();
            if (($plg_array !== false) && (count ($plg_array) > 0)) {
                // Check if plugin is returning a single record array or multiple records
                $entries = count ($plg_array[0]);
                if ($entries == 0) {
                    $sets_array = array ();
                } else if ($entries == 1) {
                    // Single record - so we need to prepare the sets_array;
                    $sets_array[0] = $plg_array;
                } else {
                    // Multiple menuitem records - in required format
                    $sets_array = $plg_array;
                }
                foreach ($sets_array as $val) {
                    $plugin = new Plugin();
                    $good_array = true;
                    for ($n = 0; $n < count($var_names); $n++) {
                        if (isset ($val[$n])) {
                            $plugin->$var_names[$n] = $val[$n];
                        } else {
                            $plugin->$var_names[$n] = '';
                        }
                        if (empty ($plugin->$var_names[$n]) && $required_names[$n]) {
                            $good_array = false;
                        }
                    }
                    $counter++;
                    if ($good_array) {
                        $plgresults[$counter] = $plugin;
                    }
                }
            }
        }
    }

    return $plgresults;
}

/**
* This function shows the option for all plugins at the top of the
* command and control center.
*
* This supports that a plugin can have several lines in the CC menu.
* The plugin has to provide simply a set arrays with 3 variables in order to
* get n lines in the menu such as
* array(
*   array("first line", "url1", "1"),
*   array("second line", "url2", "44"),
*            etc, etc)
* If there is only one item, a single array is enough:
* array("first line", "url1", "1")
*
* @return   array   Returns Command and Control options for moderation.php
*
*/
function PLG_getCCOptions()
{
    $var_names = array('adminlabel', 'adminurl', 'plugin_image');
    $required_names = array(true, true, true);
    $function_name = 'plugin_cclabel_';
    $plgresults = PLGINT_getOptionsforMenus($var_names, $required_names, $function_name);

    return $plgresults;
}

/**
* This function will show any plugin adminstrative options in the
* admin functions block on every page (assuming the user is an admin
* and is logged in).
*
* NOTE: the plugin is responsible for its own security.
* This supports that a plugin can have several lines in the Admin menu.
* The plugin has to provide simply a set arrays with 3 variables in order to
* get n lines in the menu such as
* array(
*   array("first line", "url1", "1"),
*   array("second line", "url2", "44"),,
*            etc, etc)
* If there is only one item, a single array is enough:
* array("first line", "url1", "1")
*
* @return   array   Returns options to put in admin menu
*
*/
function PLG_getAdminOptions()
{
    $var_names = array('adminlabel', 'adminurl', 'numsubmissions');
    $required_names = array(true, true, false);
    $function_name = 'plugin_getadminoption_';
    $plgresults = PLGINT_getOptionsforMenus($var_names, $required_names, $function_name);

    return $plgresults;
}

/**
* This function will show any plugin user options in the
* user block on every page
*
* This supports that a plugin can have several lines in the User menu.
* The plugin has to provide simply a set of arrays with 3 variables in order to
* get n lines in the menu such as
* array(
*   array("first line", "url1", "1"),
*   array("second line", "url2", "44"),
*            etc, etc)
* If there is only one item, a single array is enough:
* array("first line", "url1", "1")
*
* NOTE: the plugin is responsible for its own security.
*
* @return   array   Returns options to add to user menu
*
*/
function PLG_getUserOptions()
{
    // I know this uses the adminlabel, adminurl but who cares?
    $var_names = array('adminlabel', 'adminurl', 'numsubmissions');
    $required_names = array(true, true, false);
    $function_name = 'plugin_getuseroption_';
    $plgresults = PLGINT_getOptionsforMenus($var_names, $required_names, $function_name);

    return $plgresults;
}

/**
* This function is responsible for calling
* plugin_moderationapproves_<pluginname> which approves an item from the
* submission queue for a plugin.
*
* @param        string      $type       Plugin name to do submission approval for
* @param        string      $id         used to identify the record to approve
* @return       boolean     Returns true on success otherwise false
*
*/
function PLG_approveSubmission($type, $id)
{
    $args[1] = $id;

    return PLG_callFunctionForOnePlugin('plugin_moderationapprove_' . $type, $args);
}

/**
* This function is responsible for calling
* plugin_moderationdelete_<pluginname> which deletes an item from the
* submission queue for a plugin.
*
* @param        string      $type       Plugin to do submission deletion for
* @param        string      $id         used to identify the record for which to delete
* @return       boolean     Returns true on success otherwise false
*
*/
function PLG_deleteSubmission($type, $id)
{
    $args[1] = $id;

    return PLG_callFunctionForOnePlugin('plugin_moderationdelete_' . $type, $args);
}

/**
* This function calls the plugin_savesubmission_<pluginname> to save
* a user submission
*
* @param        string      $type       Plugin to save submission for
* @param        array       $A          holds plugin specific data to save
* @return       boolean     Returns true on success otherwise false
*
*/
function PLG_saveSubmission($type, $A)
{
    $args[1] = $A;

    return PLG_callFunctionForOnePlugin('plugin_savesubmission_' . $type, $args);
}

/**
* This function starts the chain of calls needed to show any submissions
* needing moderation for the plugins.
*
* @return   string      returns list of items needing moderation for plugins
*
*/
function PLG_showModerationList()
{
    global $_PLUGINS;

    $retval = '';

    foreach ($_PLUGINS as $pi_name) {
        $retval .= itemlist($pi_name);
    }

    return $retval;
}

/**
* This function is responsible for setting the plugin-specific values
* needed by moderation.php to approve stuff.
*
* @param        string      $type       Plugin to call function for
* @return       string
*
*/
function PLG_getModerationValues($type)
{
    return PLG_callFunctionForOnePlugin('plugin_moderationvalues_' . $type);
}

/**
* This function is resonsible for calling plugin_submit_<pluginname> so
* that the submission form for the plugin is displayed.
*
* @param        string      $type       Plugin to show submission form for
* @return       string      HTML for submit form for plugin
*
*/
function PLG_showSubmitForm($type)
{
    return PLG_callFunctionForOnePlugin('plugin_submit_' . $type);
}

/**
* This function will show the centerblock for any plugin
* It will be display before any news and after any defined staticpage content.
* The plugin is responsible to format the output correctly.
*
* @param   where   int      1 = top, 2 = after feat. story, 3 = bottom of page
* @param   page    int      page number (1, ...)
* @param   topic   string   topic ID or empty string == front page
* @return  Formatted center block content
*
*/
function PLG_showCenterblock($where = 1, $page = 1, $topic = '')
{
    global $PLG_bufferCenterAPI, $PLG_buffered, $_PLUGINS;

    $retval = '';

    // buffer function names since we're coming back for them two more times
    if (!$PLG_buffered) {
        $PLG_bufferCenterAPI = array ();
        foreach ($_PLUGINS as $pi_name) {
            $function = 'plugin_centerblock_' . $pi_name;
            if (function_exists($function)) {
                $PLG_bufferCenterAPI[$pi_name] = $function;
            }
        }
        $PLG_buffered = true;
    }

    foreach ($PLG_bufferCenterAPI as $function) {
        $retval .= $function($where, $page, $topic);

        if (($where == 0) && !empty ($retval)) {
            break;
        }
    }
    $function = 'custom_centerblock';
    if (function_exists($function)) {
        $retval .= $function($where, $page, $topic);
    }

    return $retval;
}

/**
* This function will inform all plugins when a new user account is created.
*
* @param     int     $uid     user id of the new user account
*
*/
function PLG_createUser ($uid)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_create_' . $pi_name;
        if (function_exists($function)) {
            $function ($uid);
        }
    }

    $function = 'custom_user_create';
    if (function_exists($function)) {
        $function($uid);
    }
}

/**
* This function will inform all plugins when a user account is deleted.
*
* @param     int     $uid     user id of the deleted user account
*
*/
function PLG_deleteUser ($uid)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_delete_' . $pi_name;
        if (function_exists ($function)) {
            $function($uid);
        }
    }

    $function = 'custom_user_delete';
    if (function_exists($function)) {
        $function($uid);
    }
}

/**
* This function will inform all plugins when a user logs in
*
* Note: This function is NOT called when users are re-authenticated by their
* long-term cookie. The global variable $_USER['auto_login'] will be set to
* 'true' in that case, however.
*
* @param     int     $uid     user id
*
*/
function PLG_loginUser ($uid)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_login_' . $pi_name;
        if (function_exists($function)) {
            $function($uid);
        }
    }

    $function = 'custom_user_login';
    if (function_exists($function)) {
        $function($uid);
    }
}

/**
* This function will inform all plugins when a user logs out.
* Plugins should not rely on this ever being called, as the user may simply
* close the browser instead of logging out.
*
* @param     int     $uid     user id
*
*/
function PLG_logoutUser ($uid)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_logout_' . $pi_name;
        if (function_exists($function)) {
            $function($uid);
        }
    }

    $function = 'custom_user_logout';
    if (function_exists($function)) {
        $function($uid);
    }
}

/**
* This functions is called to inform plugins when a user's information
* (profile or preferences) has changed.
*
* @param    int     $uid    User ID
*
*/
function PLG_userInfoChanged ($uid)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_changed_' . $pi_name;
        if (function_exists($function)) {
            $function($uid);
        }
    }

    $function = 'custom_user_changed';
    if (function_exists($function)) {
        $function($uid);
    }
}

/**
* This functions is called to inform plugins when a group's information has
* changed or a new group has been created.
*
* @param    int     $grp_id     Group ID
* @param    string  $mode       type of change: 'new', 'edit', or 'delete'
*
*/
function PLG_groupChanged ($grp_id, $mode)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_group_changed_' . $pi_name;
        if (function_exists($function)) {
            $function($grp_id, $mode);
        }
    }

    $function = 'custom_group_changed';
    if (function_exists($function)) {
        $function($uid);
    }
}

/**
* Geeklog is about to display the edit form for the user's profile. Plugins
* now get a chance to add their own variables and input fields to the form.
*
* @param   int   $uid        user id of the user profile to be edited
* @param   ref   $template   reference of the Template for the profile edit form
*
*/
function PLG_profileVariablesEdit ($uid, &$template)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_profilevariablesedit_' . $pi_name;
        if (function_exists($function)) {
            $function ($uid, $template);
        }
    }

    $function = 'custom_profilevariablesedit';
    if (function_exists($function)) {
        $function($uid, $template);
    }
}

/**
* Geeklog is about to display the edit form for the user's profile. Plugins
* now get a chance to add their own blocks below the standard form.
*
* @param    int      $uid   user id of the user profile to be edited
* @return   string          HTML for additional block(s)
*
*/
function PLG_profileBlocksEdit ($uid)
{
    global $_PLUGINS;

    $retval = '';

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_profileblocksedit_' . $pi_name;
        if (function_exists($function)) {
            $retval .= $function ($uid);
        }
    }

    $function = 'custom_profileblocksedit';
    if (function_exists($function)) {
        $retval .= $function($uid);
    }

    return $retval;
}

/**
* Geeklog is about to display the user's profile. Plugins now get a chance to
* add their own variables to the profile.
*
* @param   int   $uid        user id of the user profile to be edited
* @param   ref   $template   reference of the Template for the profile edit form
*
*/
function PLG_profileVariablesDisplay ($uid, &$template)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_profilevariablesdisplay_' . $pi_name;
        if (function_exists($function)) {
            $function ($uid, $template);
        }
    }

    $function = 'custom_profilevariablesdisplay';
    if (function_exists($function)) {
        $function($uid, $template);
    }
}

/**
* Geeklog is about to display the user's profile. Plugins now get a chance to
* add their own blocks below the standard profile form.
*
* @param    int      $uid        user id of the user profile to be edited
* @return   string               HTML for additional block(s)
*
*/
function PLG_profileBlocksDisplay ($uid)
{
    global $_PLUGINS;

    $retval = '';

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_profileblocksdisplay_' . $pi_name;
        if (function_exists($function)) {
            $retval .= $function ($uid);
        }
    }

    $function = 'custom_profileblocksdisplay';
    if (function_exists($function)) {
        $retval .= $function($uid);
    }

    return $retval;
}

/**
* The user wants to save changes to his/her profile. Any plugin that added its
* own variables or blocks to the profile input form will now have to extract
* its data and save it.
* Plugins will have to refer to the global $_POST array to get the
* actual data.
*
* @param   string   $plugin   name of a specific plugin or empty (all plugins)
*
*/
function PLG_profileExtrasSave ($plugin = '')
{
    if (empty ($plugin)) {
        PLG_callFunctionForAllPlugins ('profileextrassave');
    } else {
        PLG_callFunctionForOnePlugin ('plugin_profileextrassave_' . $plugin);
    }
}

/**
* This function can be called to check if an plugin wants to set a template
* variable
* Example in COM_siteHeader, the API call is now added
* A plugin can now check for templatename == 'header' and then set additional
* template variables
*
* @param   string   $templatename     Name of calling template - used as test in plugin function
* @param   ref      $template         reference for the Template
*
*/
function PLG_templateSetVars ($templatename, &$template)
{
    global $_PLUGINS;

    if (function_exists ('CUSTOM_templateSetVars')) {
        CUSTOM_templatesetvars($templatename, $template);
    }

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_templatesetvars_' . $pi_name;
        if (function_exists($function)) {
            $function ($templatename, $template);
        }
    }
}

/**
* This function is called from COM_siteHeader and will return additional header
* information. This can be used for JavaScript functions required for the plugin
* or extra Metatags
*
* @return   string      returns a concatenated string of all plugins extra header code
*/
function PLG_getHeaderCode()
{
    global $_PLUGINS;

    $headercode = '';

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getheadercode_' . $pi_name;
        if (function_exists($function)) {
            $headercode .= $function();
        }
    }

    $function = 'custom_getheadercode';
    if (function_exists($function)) {
        $headercode .= $function();
    }

    return $headercode;
}

/**
* Get a list of all currently supported autolink tags.
*
* Returns an associative array where $A['tag-name'] = 'plugin-name'
*
* @return   array   All currently supported autolink tags
*
*/
function PLG_collectTags()
{
    global $_CONF, $_PLUGINS;

    if (isset($_CONF['disable_autolinks']) && ($_CONF['disable_autolinks'] == 1)) {
        // autolinks are disabled - return an empty array
        return array ();
    }

    // Determine which Core Modules and Plugins support AutoLinks
    //                        'tag'   => 'module'
    $autolinkModules = array ('story' => 'geeklog');

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_autotags_' . $pi_name;
        if (function_exists($function)) {
            $autotag = $function ('tagname');
            if (is_array($autotag)) {
                foreach ($autotag as $tag) {
                    $autolinkModules[$tag] = $pi_name;
                }
            } else {
                $autolinkModules[$autotag] = $pi_name;
            }
        }
    }

    return $autolinkModules;
}

/**
* This function will allow plugins to support the use of custom autolinks
* in other site content. Plugins can now use this API when saving content
* and have the content checked for any autolinks before saving.
* The autolink would be like:  [story:20040101093000103 here]
*
* @param   string   $content   Content that should be parsed for autolinks
* @param   string   $plugin    Optional if you only want to parse using a specific plugin
*
*/
function PLG_replaceTags($content, $plugin = '')
{
    global $_CONF, $_TABLES, $LANG32;

    if (isset ($_CONF['disable_autolinks']) && ($_CONF['disable_autolinks'] == 1)) {
        // autolinks are disabled - return $content unchanged
        return $content;
    }

    $autolinkModules = PLG_collectTags ();

    // For each supported module, scan the content looking for any AutoLink tags
    $tags = array ();
    $contentlen = MBYTE_strlen ($content);
    $content_lower = MBYTE_strtolower ($content);
    foreach ($autolinkModules as $moduletag => $module) {
        $autotag_prefix = '['. $moduletag . ':';
        $offset = 0;
        $prev_offset = 0;
        while ($offset < $contentlen) {
            $start_pos = MBYTE_strpos ($content_lower, $autotag_prefix,
                                       $offset);
            if ($start_pos === false) {
                break;
            } else {
                $end_pos  = MBYTE_strpos ($content_lower, ']', $start_pos);
                $next_tag = MBYTE_strpos ($content_lower, '[', $start_pos + 1);
                if (($end_pos > $start_pos) AND
                        (($next_tag === false) OR ($end_pos < $next_tag))) {
                    $taglength = $end_pos - $start_pos + 1;
                    $tag = MBYTE_substr ($content, $start_pos, $taglength);
                    $parms = explode (' ', $tag);

                    // Extra test to see if autotag was entered with a space
                    // after the module name
                    if (MBYTE_substr ($parms[0], -1) == ':') {
                        $startpos = MBYTE_strlen ($parms[0]) + MBYTE_strlen ($parms[1]) + 2;
                        $label = str_replace (']', '', MBYTE_substr ($tag, $startpos));
                        $tagid = $parms[1];
                    } else {
                        $label = str_replace (']', '',
                                 MBYTE_substr ($tag, MBYTE_strlen ($parms[0]) + 1));
                        $parms = explode (':', $parms[0]);
                        if (count ($parms) > 2) {
                            // whoops, there was a ':' in the tag id ...
                            array_shift ($parms);
                            $tagid = implode (':', $parms);
                        } else {
                            $tagid = $parms[1];
                        }
                    }

                    $newtag = array (
                        'module'    => $module,
                        'tag'       => $moduletag,
                        'tagstr'    => $tag,
                        'startpos'  => $start_pos,
                        'length'    => $taglength,
                        'parm1'     => str_replace (']', '', $tagid),
                        'parm2'     => $label
                    );
                    $tags[] = $newtag;
                } else {
                    // Error: tags do not match - return with no changes
                    return $content . $LANG32[32];
                }
                $prev_offset = $offset;
                $offset = $end_pos;
            }
        }
    }

    // If we have found 1 or more AutoLink tag
    if (count ($tags) > 0) {       // Found the [tag] - Now process them all
        foreach ($tags as $autotag) {
            $function = 'plugin_autotags_' . $autotag['module'];
            if (($autotag['module'] == 'geeklog') AND
                    (empty ($plugin) OR ($plugin == 'geeklog'))) {
                $url = '';
                $linktext = $autotag['parm2'];
                if ($autotag['tag'] == 'story') {
                    $autotag['parm1'] = COM_applyFilter ($autotag['parm1']);
                    $url = COM_buildUrl ($_CONF['site_url']
                         . '/article.php?story=' . $autotag['parm1']);
                    if (empty ($linktext)) {
                        $linktext = stripslashes (DB_getItem ($_TABLES['stories'], 'title', "sid = '{$autotag['parm1']}'"));
                    }
                }

                if (!empty ($url)) {
                    $filelink = COM_createLink($linktext, $url);
                    $content = str_replace ($autotag['tagstr'], $filelink,
                                            $content);
                }
            } else if (function_exists ($function) AND
                    (empty ($plugin) OR ($plugin == $autotag['module']))) {
                $content = $function ('parse', $content, $autotag);
            }
        }
    }

    return $content;
}


/**
* Prepare a list of all plugins that support feeds. To do this, we re-use
* plugin_getfeednames_<plugin name> and only keep the names of those plugins
* which support that function
*
* @return   array   array of plugin names (can be empty)
*
*/
function PLG_supportingFeeds()
{
    global $_PLUGINS;

    $plugins = array();

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getfeednames_' . $pi_name;
        if (function_exists($function)) {
            $feeds = $function();
            if (is_array($feeds) && (sizeof($feeds) > 0)) {
                $plugins[] = $pi_name;
            }
        }
    }

    $function = 'custom_getfeednames';
    if (function_exists($function)) {
        $feeds = $function();
        if (is_array($feeds) && (sizeof($feeds) > 0)) {
            $plugins[] = 'custom';
        }
    }

    return $plugins;
}

/**
* Ask the plugin for a list of feeds it supports. The plugin is expected to
* return an array of id/name pairs where 'id' is the plugin's internal id
* for the feed and 'name' is what will be presented to the user.
*
* @param    string   plugin   plugin name
* @return   array             array of id/name pairs
*
*/
function PLG_getFeedNames($plugin)
{
    global $_PLUGINS;

    $feeds = array ();

    if ($plugin == 'custom')
    {
        $function = 'custom_getfeednames';
        if (function_exists($function)) {
            $feeds = $function();
        }
    } else {
        if (in_array($plugin, $_PLUGINS)) {
            $function = 'plugin_getfeednames_' . $plugin;
            if (function_exists($function)) {
                $feeds = $function();
            }
        }
    }



    return $feeds;
}

/**
* Get the content of a feed from the plugin.
* The plugin is expected to return an array holding the content of the feed
* and to fill in 'link' (some link that represents the same content on the
* site as that in the feed) and 'update_data' (to be stored for later up-to-date
* checks.
*
* @param    string   plugin        plugin name
* @param    int      feed          feed id
* @param    string   link          link to content on the site
* @param    string   update_data   information for later up-to-date checks
* @param    string   feedType      The type of feed (RSS/Atom etc)
* @param    string   feedVersion   The version info of the feed.
* @return   array                  content of feed
*
*/
function PLG_getFeedContent($plugin, $feed, &$link, &$update_data, $feedType, $feedVersion)
{
    global $_PLUGINS;

    $content = array ();

    if ($plugin == 'custom') {
        $function = 'custom_getfeedcontent';
        if (function_exists($function)) {
            $content = $function($feed, $link, $update_data, $feedType, $feedVersion);
        }
    } else {
        if (in_array ($plugin, $_PLUGINS)) {
            $function = 'plugin_getfeedcontent_' . $plugin;
            if (function_exists ($function)) {
                $content = $function ($feed, $link, $update_data, $feedType, $feedVersion);
            }
        }
    }

    return $content;
}

/**
  * Get extension tags for a feed. For example, some plugins may extened the
  * available elements for an RSS 2.0 feed for articles. For some reason. This
  * function allows that.
  *
  * @param  string  contentType     Type of feed content, article or a plugin specific type
  * @param  string  contentID       Unique identifier of content item to extend
  * @param  string  feedType        Type of feed format (RSS/Atom/etc)
  * @param  string  feedVersion     Type of feed version (RSS 1.0 etc)
  * @param  string  topic           The topic for the feed.
  * @param  string  fid             The ID of the feed being fethed.
  */
function PLG_getFeedElementExtensions($contentType, $contentID, $feedType, $feedVersion, $topic, $fid)
{
    global $_PLUGINS;

    $extensions = array();
    foreach( $_PLUGINS as $plugin )
    {
        $function = 'plugin_feedElementExtensions_'.$plugin;
        if (function_exists($function))
        {
            $extensions = array_merge($extensions, $function($contentType, $contentID, $feedType, $feedVersion, $topic, $fid));
        }
    }

    $function = 'custom_feedElementExtensions';
    if (function_exists($function))
    {
        $extensions = array_merge($extensions, $function($contentType, $contentID, $feedType, $feedVersion, $topic, $fid));
    }

    return $extensions;
}

/**
  * Get namespaces extensions for a feed. If a plugin has added extended tags
  * to a feed, then it may also need to insert some extensions to the name
  * spaces.
  * @param string contentType   Type of feed content, article or a plugin specific type
  * @param  string  feedType        Type of feed format (RSS/Atom/etc)
  * @param  string  feedVersion     Type of feed version (RSS 1.0 etc)
  * @param  string  topic           The topic for the feed.
  * @param  string  fid             The ID of the feed being fethed.
  */
function PLG_getFeedNSExtensions($contentType, $feedType, $feedVersion, $topic, $fid)
{
    global $_PLUGINS;

    $namespaces = array();
    foreach( $_PLUGINS as $plugin )
    {
        $function = 'plugin_feedNSExtensions_'.$plugin;
        if (function_exists($function))
        {
            $namespaces = array_merge($namespaces, $function($contentType, $feedType, $feedVersion, $topic, $fid));
        }
    }

    $function = 'custom_feedNSExtensions';
    if (function_exists($function))
    {
        $namespaces = array_merge($namespaces, $function($contentType, $feedType, $feedVersion, $topic, $fid));
    }

    return $namespaces;
}

/**
  * Get meta tag extensions for a feed. Add extended tags to the meta
  * area of a feed.
  * @param  string contentType      Type of feed content, article or a plugin specific type
  * @param  string  feedType        Type of feed format (RSS/Atom/etc)
  * @param  string  feedVersion     Type of feed version (RSS 1.0 etc)
  * @param  string  topic           The topic for the feed.
  * @param  string  fid             The ID of the feed being fethed.
  */
function PLG_getFeedExtensionTags($contentType, $feedType, $feedVersion, $topic, $fid)
{
    global $_PLUGINS;

    $tags = array();
    foreach( $_PLUGINS as $plugin )
    {
        $function = 'plugin_feedExtensionTags_'.$plugin;
        if (function_exists($function))
        {
            $tags = array_merge($tags, $function($contentType, $feedType, $feedVersion, $topic, $fid));
        }
    }

    $function = 'custom_feedExtensionTags';
    if (function_exists($function))
    {
        $tags = array_merge($tags, $function($contentType, $feedType, $feedVersion, $topic, $fid));
    }

    return $tags;
}

/**
* The plugin is expected to check if the feed content needs to be updated.
* This is called from COM_rdfUpToDateCheck() every time Geeklog's index.php
* is displayed - it should try to be as efficient as possible ...
*
* @param    string  plugin          plugin name
* @param    int     feed            feed id
* @param    string  topic           "topic" of the feed - plugin specific
* @param    string  limit           number of entries or number of hours
* @param    string  updated_type    (optional) type of feed to update
* @param    string  updated_topic   (optional) topic to update
* @param    string  updated_id      (optional) entry id to update
* @return   bool                    false = feed has to be updated, true = ok
*
* @note The presence of non-empty $updated_XXX parameters indicates that an
*       existing entry has been changed. The plugin may therefore apply a
*       different method to check if its feed has to be updated.
*
*/
function PLG_feedUpdateCheck($plugin, $feed, $topic, $update_data, $limit, $updated_type = '', $updated_topic = '', $updated_id = '')
{
    global $_PLUGINS;

    $is_current = true;

    if ($plugin == 'custom') {
        $function = 'custom_feedupdatecheck';
        if (function_exists($function)) {
            $is_current = $function ($feed, $topic, $update_data, $limit,
                            $updated_type, $updated_topic, $updated_id);
        }
    } else {
        if (in_array($plugin, $_PLUGINS)) {
            $function = 'plugin_feedupdatecheck_' . $plugin;
            if (function_exists($function)) {
                $is_current = $function($feed, $topic, $update_data, $limit,
                                $updated_type, $updated_topic, $updated_id);
            }
        }
    }

    return $is_current;
}

/**
* Ask plugins if they want to add something to Geeklog's What's New block.
*
* @return   array   array($headlines[], $bylines[], $content[$entries[]])
*
*/
function PLG_getWhatsNew()
{
    global $_PLUGINS;

    $newheadlines = array();
    $newbylines   = array();
    $newcontent   = array();

    foreach ($_PLUGINS as $pi_name) {
        $fn_head = 'plugin_whatsnewsupported_' . $pi_name;
        if (function_exists($fn_head)) {
            $supported = $fn_head();
            if (is_array($supported)) {
                list($headline, $byline) = $supported;

                $fn_new = 'plugin_getwhatsnew_' . $pi_name;
                if (function_exists($fn_new)) {
                    $whatsnew = $fn_new ();
                    $newcontent[] = $whatsnew;
                    $newheadlines[] = $headline;
                    $newbylines[] = $byline;
                }
            }
        }
    }

    $fn_head = 'custom_whatsnewsupported';
    if (function_exists($fn_head)) {
        $supported = $fn_head();
        if (is_array($supported)) {
            list($headline, $byline) = $supported;

            $fn_new = 'custom_getwhatsnew';
            if (function_exists($fn_new)) {
                $whatsnew = $fn_new ();
                $newcontent[] = $whatsnew;
                $newheadlines[] = $headline;
                $newbylines[] = $byline;
            }
        }
    }

    return array($newheadlines, $newbylines, $newcontent);
}

/**
* Allows plugins and Core GL Components to filter out spam.
*
* The Spam-X Plugin is now part of the Geeklog Distribution
* This plugin API will call the main function in the Spam-X plugin
* but can also be used to call other plugins or custom functions
* if available for filtering spam or content.
*
* @param    string  $content    Text to be filtered or checked for spam
* @param    integer $action     what to do if spam found
* @return   integer             > 0: spam detected, == 0: no spam detected
*
* The caller should check for return values > 0 in which case spam has been
* detected and the poster should be told, either via
*
*   echo COM_refresh ($_CONF['site_url'] . '/index.php?msg=' . $result
*                     . '&amp;plugin=spamx');
*
* or by
*
*   COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
*
* Where the former will only display a "spam detected" message while the latter
* will also send an HTTP status code 403 with the message.
*
*/
function PLG_checkforSpam($content, $action = -1)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_checkforSpam_' . $pi_name;
        if (function_exists($function)) {
            $result = $function($content, $action);
            if ($result > 0) { // Plugin found a match for spam

                $result = PLG_spamAction($content, $action);

                return $result;
            }
        }
    }

    $function = 'custom_checkforSpam';
    if (function_exists($function)) {
        $result = $function($content, $action);
        if ($result > 0) { // Plugin found a match for spam

            $result = PLG_spamAction($content, $action);

            return $result;
        }
    }

    return 0;
}

/**
* Act on spam
*
* This is normally called from PLG_checkforSpam (see above) automatically when
* spam has been detected. There may however be situations where spam has been
* detected by some other means, in which case you may want to trigger the
* spam action explicitly.
*
* @param    string  $content    Text to be filtered or checked for spam
* @param    integer $action     what to do if spam found
* @return   integer             > 0: spam detected, == 0: no spam detected
*
*/
function PLG_spamAction($content, $action = -1)
{
    global $_PLUGINS;

    $result = 0;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_spamaction_' . $pi_name;
        if (function_exists($function)) {
            $res = $function($content, $action);
            $result = max($result, $res);
        }
    }

    $function = 'custom_spamaction';
    if (function_exists($function)) {
        $res = $function($content, $action);
        $result = max($result, $res);
    }

    return $result;
}

/**
* Ask plugin for information about one of its items
*
* @param    string  $type       plugin type
* @param    string  $id         ID of an item under the plugin's control
* @param    string  $what       comma-separated list of item properties
* @return   mixed               string or array of strings with the information
*
* Item properties that can be requested:
* 'url'         - URL of the item
* 'title'       - title of the item
* 'excerpt'     - short description of the item
* 'description' - full description of the item
*
* 'excerpt' and 'description' may return the same value. Properties should be
* returned in the order they are listed in $what. Properties that are not
* available should return an empty string.
* Return false for errors (e.g. access denied, item does not exist, etc.).
*
*/
function PLG_getItemInfo ($type, $id, $what)
{
    $args[1] = $id;
    $args[2] = $what;

    $function = 'plugin_getiteminfo_' . $type;

    return PLG_callFunctionForOnePlugin ($function, $args);
}

/**
* Geeklog is about to perform an operation on a trackback or pingback comment
* to one of the items under the plugin's control and asks for the plugin's
* permission to continue.
*
* Geeklog handles receiving and deleting trackback comments and pingbacks
* for the plugin but since it doesn't know about the plugin's access control,
* it has to ask the plugin to approve / reject such an operation.
*
* @param    string  $type       plugin type
* @param    string  $id         an ID or URL, depending on the operation
* @param    string  $operation  operation to perform
*
* $operation can be one of the following:
* 'acceptByID'  - accept a trackback comment on item with ID $id
*                 returns: true for accept, false for reject
* 'acceptByURI' - accept a pingback comment on item at URL $id
*                 returns: the item's ID for accept, false for reject
* 'delete'      - is the current user allowed to delete item with ID $id?
*                 returns: true for accept, false for reject
*
*/
function PLG_handlePingComment ($type, $id, $operation)
{
    $args[1] = $id;
    $args[2] = $operation;

    $function = 'plugin_handlepingoperation_' . $type;

    return PLG_callFunctionForOnePlugin ($function, $args);
}


/**
* Check if plugins have a scheduled task they want to run
* The interval between runs is determined by $_CONF['cron_schedule_interval']
*/
function PLG_runScheduledTask ()
{
    global $_PLUGINS;

    if (function_exists ('CUSTOM_runScheduledTask')) {
        CUSTOM_runScheduledTask();
    }
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_runScheduledTask_' . $pi_name;
        if (function_exists ($function)) {
            $function ();
        }
    }
}

/**
* "Generic" plugin API: Save item
*
* To be called (eventually) whenever Geeklog saves an item into the database.
* Plugins can hook into this and modify the item (which is already in the
* database but not visible on the site yet).
*
* Plugins can signal an error by returning an error message (otherwise, they
* should return 'false' to signal "no errors"). In case of an error, all the
* plugins called up to that point will be invoked through an "abort" call to
* undo their changes.
*
* @param    string  $id     unique ID of the item
* @param    string  $type   type of the item, e.g. 'article'
* @returns  mixed           Boolean false for "no error", or an error msg text
*
*/
function PLG_itemSaved($id, $type)
{
    global $_PLUGINS;

    $error = false;

    $plugins = count ($_PLUGINS);
    for ($save = 0; $save < $plugins; $save++) {
        $function = 'plugin_itemsaved_' . $_PLUGINS[$save];
        if (function_exists($function)) {
            $error = $function($id, $type);
            if ($error !== false) {
                // plugin reported a problem - abort

                for ($abort = 0; $abort < $save; $abort++) {
                    $function = 'plugin_abortsave_' . $_PLUGINS[$abort];
                    if (function_exists($function)) {
                        $function($id, $type);
                    }
                }
                break; // out of for($save) loop
            }
        }
    }

    return $error;
}

/**
* "Generic" plugin API: Display item
*
* To be called (eventually) whenever Geeklog displays an item.
* Plugins can hook into this and add content to the displayed item, in the form
* of an array (true, string1, string2...).
*
* The object that called can then display one or several items with a
* object-defined layout.
*
* Plugins can signal an error by returning an array (false, 'Error Message')
* In case of an error, the error message will be written to the error.log and
* nothing will be displayed on the output.
*
* @param    string  $id     unique ID of the item
* @param    string  $type   type of the item, e.g. 'article'
* @returns  array           array with a status and one or several strings
*
*/

function PLG_itemDisplay($id, $type)
{
    global $_PLUGINS;
    $result_arr = array();

    $plugins = count($_PLUGINS);
    for ($display = 0; $display < $plugins; $display++) {
        $function = 'plugin_itemdisplay_' . $_PLUGINS[$display];
        if (function_exists($function)) {
            $result = $function($id, $type);
            if ($result[0] == false) {
                // plugin reported a problem - do not add and continue
                COM_errorLog($result[1], 1);
            } else {
                array_shift($result);
                $result_arr = array_merge($result_arr,$result);
            }
        }
    }

    $function = 'custom_itemdisplay';
    if (function_exists ($function)) {
        $result = $function ($id, $type);
        if ($result[0] == false) {
            // plugin reported a problem - do not add and continue
            COM_errorLog( $result[1], 1);
        } else {
            array_shift($result);
            $result_arr = array_merge($result_arr,$result);
        }
    }

    return $result_arr;
}



/**
* Gets Geeklog blocks from plugins
*
* Returns data for blocks on a given side and, potentially, for
* a given topic.
*
* @param        string      $side       Side to get blocks for (right or left for now)
* @param        string      $topic      Only get blocks for this topic
* @return   array of block data
*
*/
function PLG_getBlocks($side, $topic='')
{
    global $_PLUGINS;

    $ret = array();
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getBlocks_' . $pi_name;
        if (function_exists($function)) {
            $items = $function($side, $topic='');
            if (is_array($items)) {
                $ret = array_merge($ret, $items);
            }
        }
    }

    if (function_exists('CUSTOM_getBlocks')) {
       $cust_items .= CUSTOM_getBlocks($side, $topic='');
       if (is_array($cust_items)) {
          $ret = array_merge($ret, $cust_items);
       }
    }

    return $ret;
}

/**
* Get the URL of a plugin's icon
*
* @param    string  $type   plugin name
* @return   string          URL of the icon
*
*/
function PLG_getIcon($type)
{
    global $_CONF;

    $retval = '';

    // try the "geticon" function first
    $function = 'plugin_geticon_' . $type;
    if (function_exists($function)) {
        $retval = $function ();
    }

    // if that didn't work, try the "cclabel" function
    if (empty ($retval)) {
        $function = 'plugin_cclabel_' . $type;
        if (function_exists($function)) {
            $cclabel = $function ();
            if (is_array($cclabel)) {
                if (!empty($cclabel[2])) {
                    $retval = $cclabel[2];
                }
            }
        }
    }

    // lastly, search for the icon (assuming it's a GIF)
    if (empty($retval)) {
        $icon = $_CONF['site_url'] . '/' . $type . '/images/' . $type . '.gif';
        $fh = @fopen ($icon, 'r');
        if ($fh === false) {
            $icon = $_CONF['site_admin_url'] . '/plugins/' . $type . '/images/'
                  . $type . '.gif';
            $fh = @fopen ($icon, 'r');
            if ($fh === false) {
                // give up and us a generic icon
                $retval = $_CONF['site_url'] . '/images/icons/plugins.gif';
            } else {
                $retval = $icon;
                fclose ($fh);
            }
        } else {
            $retval = $icon;
            fclose ($fh);
        }
    }

    return $retval;
}

/**
 * Invoke a service
 *
 * @param   string  type    The plugin type whose service is to be called
 * @param   string  action  The service action to be performed
 * @param   array   args    The arguments to be passed to the service invoked
 * @param   array   output  The output variable that will contain the output after invocation
 * @param   array   svc_msg The output variable that will contain the service messages
 * @return  int             The result of the invocation
 *
 */
function PLG_invokeService($type, $action, $args, &$output, &$svc_msg)
{
    global $_CONF;

    $retval = PLG_RET_ERROR;

    if ($type == 'story') {
        // ensure we can see the service_XXX_story functions
        require_once $_CONF['path_system'] . 'lib-story.php';
    }

    $output  = '';
    $svc_msg = '';

    // Check if the plugin type and action are valid
    $function = 'service_' . $action . '_' . $type;

    if (function_exists($function) && PLG_wsEnabled($type)) {
        if (!isset($args['gl_svc'])) {
            $args['gl_svc'] = false;
        }
        $retval = $function($args, $output, $svc_msg);
    }

    return $retval;
}

/**
 * Returns true if the plugin supports webservices
 *
 * @param   string  type    The plugin type that is to be checked
 */
function PLG_wsEnabled($type)
{
    global $_CONF;

    if ($type == 'story') {
        // ensure we can see the service_XXX_story functions
        require_once $_CONF['path_system'] . 'lib-story.php';
    }

    $function = 'plugin_wsEnabled_' . $type;
    if (function_exists($function)) {
        return $function();
    } else {
        return false;
    }
}

/**
* Forward the user depending on config.php-setting after saving something
*
* @param  string  $item_url   the url of the item saved
* @param  string  $plugin     the name of the plugin that saved the item
* @return the url where the user will be forwarded to
*
*/
function PLG_afterSaveSwitch($target, $item_url, $plugin, $message = '')
{
    global $_CONF;

    if (isset($message) && (!empty($message) || is_numeric($message))) {
        $msg = "msg=$message";
    } else {
        $msg = '';
    }

    switch ($target) {
    case 'item':
        $url = $item_url;
        if (!empty($msg)) {
            $url .= '&' . $msg;
        }
        break;

    case 'list':
        if ($plugin == 'story') {
            $url = $_CONF['site_admin_url'] . "/$plugin.php";
        } elseif ($plugin == 'user') {
            $url = $_CONF['site_admin_url'] . "/user.php";
        } else {
            $url = $_CONF['site_admin_url'] . "/plugins/$plugin/index.php";
        }
        if (!empty($msg)) {
            $url .= '?' . $msg;
        }
        break;

    case 'home':
        // the plugins messages are not available, use generic
        $url = $_CONF['site_url'] . '/index.php?msg=15';
        break;

    case 'admin':
        // the plugins messages are not available, use generic
        $url = $_CONF['site_admin_url'] . '/moderation.php?msg=15';
        break;

    case 'plugin':
        $url = $_CONF['site_url'] . "/$plugin/index.php";
        if (!empty($msg)) {
            $url .= '?' . $msg;
        }
        break;
    }

    return COM_refresh($url);
}

?>
