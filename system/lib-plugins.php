<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-plugins.php                                                           |
// |                                                                           |
// | This file implements plugin support in Geeklog.                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
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
// $Id: lib-plugins.php,v 1.57 2005/01/29 17:52:55 dhaun Exp $

/**
* This is the plugin library for Geeklog.  This is the API that plugins can
* implement to get tight integration with Geeklog.
* See each function for more details.
*
*/

if (eregi ('lib-plugins.php', $HTTP_SERVER_VARS['PHP_SELF'])) {
    die ('This file can not be used on its own.');
}

require_once($_CONF['path_system'] . 'classes/plugin.class.php');

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
        $function = $function_name . $pi_name;
        if (function_exists($function)) {
            $function();
        }
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
* Upgrades a plugin. Tells a plugin to upgrade itself. NOTE: not currently used
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
function PLG_uninstall($type)
{
    if (empty($type)) return false;
    $retval = PLG_callFunctionForOnePlugin('plugin_uninstall_' . $type);

    if (empty($retval)) {
        return false;
    } else { 
        return $retval;
    }
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
    return PLG_callFunctionForAllPlugins('plugin_ismoderator_');
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
 * Plugin should delete a comment
 *
 * @author Vincnet Furia <vinny01 AT users DOT sourceforge DOT net>
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
 * @author Vincnet Furia <vinny01 AT users DOT sourceforge DOT net>
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
 * @author Vincnet Furia <vinny01 AT users DOT sourceforge DOT net>
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
    return false;
}


/**
* The way this function works is very specific to how Geeklog shows it's
* statistics.  On stats.php, there is the top box which gives overall
* statistics for Geeklog and then there are blocks below it that give
* more specific statistics for various components of Geeklog.  If 
* $showsitestats is 1 then the plugins is to return the overall stats
* for the plugin.  If $showsitestats is 0 then it will return the plugin
* specific stats
*
* @param        boolean     $showsitestats      flag indicated type of stats to return 
*
*/
function PLG_getPluginStats($showsitestats) 
{
    global $_PLUGINS;

    $retval = '';

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_showstats_' . $pi_name;
        if (function_exists($function)) {
            //great, stats function is there, call it
            $retval .= $function($showsitestats);
        } // no else because this is not a required API function
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
        if (function_exists($function)) {
            //great, stats function is there, call it
            $cur_types = $function();
            $types = array_merge($types, $cur_types);
        } // no else because this is not a required API function
    }
    return $types;
}

/**
* Determines if s specific plugin supports Geeklog's
* expanded search results feature
*
* @author Tony Bibbs <tony AT geeklog DOT net>
* @access public
* @param string $type Plugin name
* @return boolean True if it is supported, otherwise false
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
* @return   array               Returns search results
*
*/
function PLG_doSearch($query, $datestart, $dateend, $topic, $type, $author, $keyType = 'all') 
{
    global $_PLUGINS;

    $search_results = array();

    $nrows_plugins = 0;
    $total_plugins = 0;
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_dopluginsearch_' . $pi_name;
        if (function_exists($function)) {
            $plugin_result = $function($query, $datestart, $dateend, $topic, $type, $author, $keyType);
            $nrows_plugins = $nrows_plugins + $plugin_result->num_searchresults;
            $total_plugins = $total_plugins + $plugin_result->num_itemssearched;
            $search_results[] = $plugin_result;
        } // no else because implementation of this API function not required
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
* This function will show any plugin user options in the
* user block on every page
* NOTE: the plugin is responsible for it's own security.
*
* @return   array   Returns options to add to user menu
*
*/
function PLG_getUserOptions() 
{
    global $_PLUGINS;

    $plgresults = array ();

    $counter = 0;
    foreach ($_PLUGINS as $pi_name) {
        $plugin = new Plugin();
        $function = 'plugin_getuseroption_' . $pi_name;
        if (function_exists($function)) {
            // I know this uses the adminlabel, adminurl but who cares?
            list($plugin->adminlabel, $plugin->adminurl, $plugin->numsubmissions) = $function();
            if (!empty ($plugin->adminlabel) && !empty ($plugin->adminurl)) {
                $counter++;
                $plgresults[$counter] = $plugin;
            }
        }
    }

    return $plgresults;
}

/** 
* This function will show any plugin adminstrative options in the
* admin functions block on every page (assuming the user is an admin
* and is logged in).
* NOTE: the plugin is responsible for it's own security. 
*
* @return   array   Returns options to put in admin menu
*
*/
function PLG_getAdminOptions() 
{
    global $_PLUGINS;

    $counter = 0;
    foreach ($_PLUGINS as $pi_name) {
        $plugin = new Plugin();
        $function = 'plugin_getadminoption_' . $pi_name;
        if (function_exists($function)) {
            list($plugin->adminlabel, $plugin->adminurl, $plugin->numsubmissions) = $function();
            if (!empty ($plugin->adminlabel) && !empty ($plugin->adminurl)) {
                $counter++;
                $plgresults[$counter] = $plugin;
            }
        }
    }
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
* This function shows the option for all plugins at the top of the 
* command and control center.
*
* @return   array   Returns Command and Control options for moderation.php
*
*/
function PLG_getCCOptions() 
{
    global $_PLUGINS;

    $plugins = array();
    foreach ($_PLUGINS as $pi_name) {
        $cur_plugin = new Plugin();
        $function = 'plugin_cclabel_' . $pi_name;
        if (function_exists($function)) {
            $cclabel = $function ();
            if ($cclabel !== false) {
                list($cur_plugin->adminlabel, $cur_plugin->adminurl, $cur_plugin->plugin_image) = $cclabel;
                if (!empty ($cur_plugin->adminlabel) &&
                    !empty ($cur_plugin->adminurl) &&
                    !empty ($cur_plugin->plugin_image)) {
                    $plugins[] = $cur_plugin; 
                }
            }
        }
    }
    return $plugins;
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
            if (function_exists ($function)) {
                $PLG_bufferCenterAPI[$pi_name] = $function;
            }
        }
        $PLG_buffered = true;
    }

    foreach ($PLG_bufferCenterAPI as $function) {
        $retval .= $function ($where, $page, $topic);

        if (($where == 0) && !empty ($retval)) {
            break;
        }
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
        if (function_exists ($function)) {
            $function ($uid);
        }
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
            $function ($uid);
        }
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
        if (function_exists ($function)) {
            $function ($uid);
        }
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
        if (function_exists ($function)) {
            $function ($uid);
        }
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
        if (function_exists ($function)) {
            $function ($uid);
        }
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
        if (function_exists ($function)) {
            $function ($grp_id, $mode);
        }
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

    return $retval;
}

/**
* The user wants to save changes to his/her profile. Any plugin that added its
* own variables or blocks to the profile input form will now have to extract
* its data and save it.
* Plugins will have to refer to the global $HTTP_POST_VARS array to get the
* actual data.
*
* @param   string   $plugin   name of a specific plugin or empty (all plugins)
*
*/
function PLG_profileExtrasSave ($plugin = '')
{
    if (empty ($plugin)) {
        PLG_callFunctionForAllPlugins ('plugin_profileextrassave_');
    } else {
        PLG_callFunctionForOnePlugin ('plugin_profileextrassave_' . $plugin);
    }
}

/**
* This function can be called to check if an plugin wants to set a template variable
* Example in COM_siteHeader, the API call is now added
* A plugin can now check for templatename == 'header' and then set additional template variables
*
* @param   string   $templatename     Name of calling template - used as test in plugin function
* @param   ref      $template         reference for the Template
*
*/
function PLG_templateSetVars ($templatename, &$template)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_templatesetvars_' . $pi_name;
        if (function_exists($function)) {
            $function ($templatename, $template);
        }
    }
}

/**
* This function is called from COM_siteHeader and will return additional Header information
* This can be Javascript functions required for the plugin or extra Metatags
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
function PLG_collectTags ()
{
    global $_CONF, $_PLUGINS;

    if (isset ($_CONF['disable_autolinks']) && ($_CONF['disable_autolinks'] == 1)) {
        // autolinks are disabled - return an empty array
        return array ();
    }

    // Determine which Core Modules and Plugins support AutoLinks
    //                        'tag'   => 'module'
    $autolinkModules = array ('story' => 'geeklog',
                              'event' => 'geeklog'
                             );

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_autotags_' . $pi_name;
        if (function_exists ($function)) {
            $autotag = $function ('tagname');
            if (is_array ($autotag)) {
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
*
*/
function PLG_replaceTags ($content)
{
    global $_CONF, $_TABLES, $_PLUGINS, $LANG32;

    if (isset ($_CONF['disable_autolinks']) && ($_CONF['disable_autolinks'] == 1)) {
        // autolinks are disabled - return $content unchanged
        return $content;
    }

    $autolinkModules = PLG_collectTags ();

    // For each supported module - scan the content looking for any AutoLink tags
    $tags = array ();
    foreach ($autolinkModules as $moduletag => $module) {
        $autotag_prefix = '['. $moduletag . ':';
        $offset = $prev_offset = 0;
        $strlen = strlen ($content);
        while ($offset < $strlen) {
            $start_pos = strpos (strtolower ($content), $autotag_prefix,
                                 $offset);
            if ($start_pos !== FALSE) {
               $end_pos = strpos (strtolower ($content), ']', $start_pos);
               $next_tag = strpos (strtolower ($content), '[', $start_pos + 1);
               if ($end_pos > $start_pos AND (($end_pos < $next_tag OR $next_tag == FALSE))) {
                    $taglength = $end_pos - $start_pos + 1;
                    $tag = substr ($content, $start_pos, $taglength);
                    $parms = explode (' ', $tag);
                    $label = str_replace (']', '',
                             substr ($tag, strlen ($parms[0]) + 1));
                    $parms = explode (':', $parms[0]);
                    $newtag = array (
                        'module'    => $module,
                        'tag'       => $moduletag,
                        'tagstr'    => $tag,
                        'startpos'  => $start_pos,
                        'length'    => $taglength,
                        'parm1'     => str_replace (']', '', $parms[1]),
                        'parm2'     => $label
                    );
                    $tags[] = $newtag;

                } else {
                    /* Error tags do not match - return with no changes */
                    return $content . $LANG32['32'];
                }
                $prev_offset = $offset;
                $offset = $end_pos;
            } else {
                $prev_offset = $end_pos;
                $end_pos = $strlen;
                $offset = $strlen;
            }
        }
    }

    // If we have found 1 or more AutoLink tag
    if (count ($tags) > 0) {       // Found the [tag] - Now process them all
        foreach ($tags as $autotag) {
            $function = 'plugin_autotags_' . $autotag['module'];
            if ($autotag['module'] == 'geeklog') {
                $url = '';
                $linktext = $autotag['parm2'];
                if ($autotag['tag'] == 'story') {
                    $autotag['parm1'] = COM_applyFilter ($autotag['parm1']);
                    $url = COM_buildUrl ($_CONF['site_url']
                         . '/article.php?story=' . $autotag['parm1']);
                    if (empty ($linktext)) {
                        $linktext = stripslashes (DB_getItem ($_TABLES['stories'], 'title', "sid = '{$autotag['parm1']}'"));
                    }
                } else if ($autotag['tag'] == 'event') {
                    $autotag['parm1'] = COM_applyFilter ($autotag['parm1']);
                    $url = $_CONF['site_url'] . '/calendar_event.php?eid='
                         . $autotag['parm1'];
                    if (empty ($linktext)) {
                        $linktext = stripslashes (DB_getItem ($_TABLES['events'], 'title', "eid = '{$autotag['parm1']}'"));
                    }
                }
                if (!empty ($url)) {
                    $filelink = '<a href="' . $url . '">' . $linktext . '</a>';
                    $content = str_replace ($autotag['tagstr'], $filelink,
                                            $content);
                }
            } else if (function_exists ($function)) {
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
function PLG_supportingFeeds ()
{
    global $_PLUGINS;

    $plugins = array ();

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getfeednames_' . $pi_name;
        if (function_exists ($function)) {
            $feeds = $function ();
            if (is_array ($feeds) && (sizeof ($feeds) > 0)) {
                $plugins[] = $pi_name;
            }
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
function PLG_getFeedNames ($plugin)
{
    global $_PLUGINS;

    $feeds = array ();

    if (in_array ($plugin, $_PLUGINS)) {
        $function = 'plugin_getfeednames_' . $plugin;
        if (function_exists ($function)) {
            $feeds = $function ();
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
* @return   array                  content of feed
*
*/
function PLG_getFeedContent ($plugin, $feed, &$link, &$update_data)
{
    global $_PLUGINS;

    $content = array ();

    if (in_array ($plugin, $_PLUGINS)) {
        $function = 'plugin_getfeedcontent_' . $plugin;
        if (function_exists ($function)) {
            $content = $function ($feed, $link, $update_data);
        }
    }

    return $content;
}

/**
* The plugin is expected to check if the feed content needs to be updated.
* This is called from COM_rdfUpToDateCheck() every time Geeklog's index.php
* is displayed - it should try to be as efficient as possible ...
*
* @param    string   plugin   plugin name
* @param    int      feed     feed id
* @param    string   topic    "topic" of the feed - plugin specific
* @param    string   limit    number of entries or number of hours
* @return   bool              false = feed has to be updated, true = ok
*
*/
function PLG_feedUpdateCheck ($plugin, $feed, $topic, $update_data, $limit)
{
    global $_PLUGINS;

    $is_current = true;

    if (in_array ($plugin, $_PLUGINS)) {
        $function = 'plugin_feedupdatecheck_' . $plugin;
        if (function_exists ($function)) {
            $is_current = $function ($feed, $topic, $update_data, $limit);
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
function PLG_getWhatsNew ()
{
    global $_PLUGINS;

    $newheadlines = array ();
    $newbylines   = array ();
    $newcontent   = array ();

    foreach ($_PLUGINS as $pi_name) {
        $fn_head = 'plugin_whatsnewsupported_' . $pi_name;
        if (function_exists ($fn_head)) {
            $supported = $fn_head ();
            if (is_array ($supported)) {
                list ($headline, $byline) = $supported;

                $fn_new = 'plugin_getwhatsnew_' . $pi_name;
                if (function_exists ($fn_new)) {
                    $whatsnew = $fn_new ();
                    $newcontent[] = $whatsnew;
                    $newheadlines[] = $headline;
                    $newbylines[] = $byline;
                }
            }
        }
    }

    return array ($newheadlines, $newbylines, $newcontent);
}

/**
* Allows plugins and Core GL Components to filter out spam.
* The SPAMX Plugin is now part of the Geeklog Distribution
* This plugin API will call the main function in the SPAMX plugin
* but can also be used to call other plugins or custom functions
* if available for filtering spam or content.
*
* @param string $content   Text to be filtered or checked for spam
* @param integer $action   what to do if comment found
* @return an error or formatted action HTML to return to calling program
* 
* Note: Examples for formatted action HTML are a redirect formatted by COM_refresh
* The spamx DeleteComment.Action does this.
*
*/
function PLG_checkforSpam($content, $action = -1)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_checkforSpam_' . $pi_name;
        if (function_exists($function)) {
            $someError = $function($content, $action);
            if ($someError) {
                // Plugin found a match for spam or else an error
                return $someError;
            }
        }
    }
    return false;
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
* Note: This API function has not been finalized yet ...
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
* Note: This API function has not been finalized yet ...
*
*/
function PLG_handlePingComment ($type, $id, $operation)
{
    $args[1] = $id;
    $args[2] = $operation;

    $function = 'plugin_handlepingoperation_' . $type;

    return PLG_callFunctionForOnePlugin ($function, $args);
}

?>
