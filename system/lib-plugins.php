<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-plugins.php                                                           |
// |                                                                           |
// | This file implements plugin support in Geeklog.                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2019 by the following authors:                         |
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

/**
 * This is the plugin library for Geeklog.  This is the API that plugins can
 * implement to get tight integration with Geeklog.
 * See each function for more details.
 *
 * @link http://wiki.geeklog.net/index.php/Plugin_API
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

global $_TABLES;

/**
 * Response codes for the service invocation PLG_invokeService(). Note that
 * these are intentionally vague so as not to give away too much information.
 */
define('PLG_RET_OK', 0);  // success
define('PLG_RET_ERROR', -1);  // generic error
define('PLG_RET_PERMISSION_DENIED', -2);  // access to item or object denied
define('PLG_RET_AUTH_FAILED', -3);  // authentication failed
define('PLG_RET_PRECONDITION_FAILED', -4);  // a precondition was not met

// Response codes for checking for a SPAM
define('PLG_SPAM_NOT_FOUND', 0);
define('PLG_SPAM_FOUND', 1);
define('PLG_SPAM_UNSURE', 2);

// Constants for actions when a SPAM was found
define('PLG_SPAM_ACTION_NONE', 0);
define('PLG_SPAM_ACTION_NOTIFY', 8);
define('PLG_SPAM_ACTION_DELETE', 128);

// Global constants to show which reCAPTCHA version each plugin supports (since Geeklog 2.2.1)
define('RECAPTCHA_NO_SUPPORT', 0);
define('RECAPTCHA_SUPPORT_V2', 1);
define('RECAPTCHA_SUPPORT_V2_INVISIBLE', 2);

// Not supported as of v1.2.1 (Geeklog 2.2.1)
define('RECAPTCHA_SUPPORT_V3', 4);

// buffer for function names for the center block API
$PLG_bufferCenterAPI = array();
$PLG_buffered = false;

// buffer enabled plugins
$result = DB_query("SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_enabled = 1 ORDER BY pi_load ASC");

/**
 * @global array List of all active plugins
 */
global $_PLUGINS;
$_PLUGINS = array();
while ($A = DB_fetchArray($result)) {
    $_PLUGINS[] = $A['pi_name'];
}

/**
 * Calls a function for all enabled plugins
 *
 * @param    string $function_name holds name of function to call
 * @param    array  $args     arguments to send to function
 * @access   private
 * @internal not to be used by plugins
 */
function PLG_callFunctionForAllPlugins($function_name, array $args = array())
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_' . $function_name . '_' . $pi_name;
        if (function_exists($function)) {
            PLG_callFunctionForOnePlugin($function, $args);
        }
    }
    $function = 'CUSTOM_' . $function_name;
    if (function_exists($function)) {
        $function();
    }
}

/**
 * Calls a function for a single plugin
 * This is a generic function used by some of the other API functions to
 * call a function for a specific plugin and, optionally pass parameters.
 * This function can handle up to 7 arguments and if more exist it will
 * try to pass the entire args array to the function.
 *
 * @param    string $function holds name of function to call
 * @param    array  $args     arguments to send to function
 * @return   mixed            returns result of function call, otherwise false
 * @access   private
 * @internal not to be used by plugins
 */
function PLG_callFunctionForOnePlugin($function, array $args = array())
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
 * Tells a plugin to install itself. NOTE: not currently used any more
 *
 * @param       string $type Plugin name
 * @return      boolean             Returns true on success otherwise false
 * @deprecated  deprecated since Geeklog 1.6.0
 * @link        http://wiki.geeklog.net/index.php/Plugin_Autoinstall
 */
function PLG_install($type)
{
    COM_deprecatedLog(__FUNCTION__, '1.6.0', '3.0.0', 'plugin_install_' . $type);

    return PLG_callFunctionForOnePlugin('plugin_install_' . $type);
}

/**
 * Upgrades a plugin. Tells a plugin to upgrade itself.
 *
 * @param    string $type Plugin name
 * @return   mixed        true on success, false or error number on failure
 */
function PLG_upgrade($type)
{
    return PLG_callFunctionForOnePlugin('plugin_upgrade_' . $type);
}

/**
 * Called during site migration - let plugin handle changed URLs or paths
 *
 * @param    string $type     Plugin name
 * @param    array  $old_conf contents of $_CONF before the migration
 * @return   boolean             true on success, otherwise false
 * @link     http://wiki.geeklog.net/index.php/PLG_migrate
 * @since    Geeklog 1.6.0
 */
function PLG_migrate($type, $old_conf)
{
    if (!function_exists('plugin_migrate_' . $type)) {
        // since PLG_callFunctionForOnePlugin would return false ...
        return true;
    }

    $args[1] = $old_conf;

    return PLG_callFunctionForOnePlugin('plugin_migrate_' . $type, $args);
}

/**
 * Calls the plugin function to return the current version of code.
 * Used to indicate to admin if an update or upgrade is required.
 *
 * @param        string $type Plugin name
 * @return       boolean      Returns true on success otherwise false
 */
function PLG_chkVersion($type)
{
    return PLG_callFunctionForOnePlugin('plugin_chkVersion_' . $type);
}

/**
 * Tells a plugin to uninstall itself.
 *
 * @param    string $type Plugin to uninstall
 * @return   boolean             Returns true on success otherwise false
 * @link     http://wiki.geeklog.net/index.php/Plugin_Auto-Uninstall
 */
function PLG_uninstall($type)
{
    global $_PLUGINS, $_TABLES;

    if (empty($type)) {
        return false;
    }

    if (function_exists('plugin_autouninstall_' . $type)) {
        COM_errorLog("Auto-uninstalling plugin $type:", 1);
        $function = 'plugin_autouninstall_' . $type;
        $remvars = $function();

        if (empty($remvars) || $remvars == false) {
            return false;
        }

        // removing tables
        if (isset($remvars['tables'])) {
            $num_tables = count($remvars['tables']);
        } else {
            $num_tables = 0;
        }
        for ($i = 0; $i < $num_tables; $i++) {
            if (isset($_TABLES[$remvars['tables'][$i]])) {
                COM_errorLog("Dropping table {$_TABLES[$remvars['tables'][$i]]}", 1);
                DB_query("DROP TABLE {$_TABLES[$remvars['tables'][$i]]}", 1);
                COM_errorLog('...success', 1);
            }
        }

        // removing variables
        if (isset($remvars['vars'])) {
            $num_vars = count($remvars['vars']);
        } else {
            $num_vars = 0;
        }
        for ($i = 0; $i < $num_vars; $i++) {
            COM_errorLog("Removing variable {$remvars['vars'][$i]}", 1);
            DB_delete($_TABLES['vars'], 'name', $remvars['vars'][$i]);
            COM_errorLog('...success', 1);
        }

        // removing groups
        if (isset($remvars['groups'])) {
            $num_groups = count($remvars['groups']);
        } else {
            $num_groups = 0;
        }
        for ($i = 0; $i < $num_groups; $i++) {
            $grp_id = DB_getItem($_TABLES['groups'], 'grp_id',
                "grp_name = '{$remvars['groups'][$i]}'");
            if (!empty($grp_id)) {
                COM_errorLog("Attempting to remove the {$remvars['groups'][$i]} group", 1);
                DB_delete($_TABLES['groups'], 'grp_id', $grp_id);
                COM_errorLog('...success', 1);
                COM_errorLog("Attempting to remove the {$remvars['groups'][$i]} group from all groups.", 1);
                DB_delete($_TABLES['group_assignments'], 'ug_main_grp_id', $grp_id);
                COM_errorLog('...success', 1);
            }
        }

        // removing features
        if (isset($remvars['features'])) {
            $num_features = count($remvars['features']);
        } else {
            $num_features = 0;
        }
        for ($i = 0; $i < $num_features; $i++) {
            SEC_removeFeatureFromDB($remvars['features'][$i]);
        }

        // uninstall feeds
        $sql = "SELECT filename FROM {$_TABLES['syndication']} WHERE type = '$type';";
        $result = DB_query($sql);
        $numRows = DB_numRows($result);
        if ($numRows > 0) {
            COM_errorLog('removing feed files', 1);
            COM_errorLog($numRows . ' files stored in table.', 1);
            for ($i = 0; $i < $numRows; $i++) {
                $fcount = $i + 1;
                $A = DB_fetchArray($result);
                $fullpath = SYND_getFeedPath($A[0]);
                if (file_exists($fullpath)) {
                    unlink($fullpath);
                    COM_errorLog("removed file {$fcount} of {$numRows}: {$fullpath}", 1);
                } else {
                    COM_errorLog("cannot remove file {$fcount} of {$numRows}, it does not exist! ($fullpath)", 1);
                }
            }
            COM_errorLog('...success', 1);
            // Remove Links Feeds from syndiaction table
            COM_errorLog('removing links feeds from table', 1);
            DB_delete($_TABLES['syndication'], 'type', $type);
            COM_errorLog('...success', 1);
        }

        // remove comments for this plugin
        COM_errorLog("Attempting to remove comments for $type", 1);
        DB_delete($_TABLES['comments'], 'type', $type);
        COM_errorLog('...success', 1);

        // uninstall php-blocks
        if (isset($remvars['php_blocks'])) {
            $num_blocks = count($remvars['php_blocks']);
        } else {
            $num_blocks = 0;
        }
        for ($i = 0; $i < $num_blocks; $i++) {
            DB_delete($_TABLES['blocks'], array('type', 'phpblockfn'),
                array('phpblock', $remvars['php_blocks'][$i]));
        }

        // remove config table data for this plugin
        COM_errorLog("Attempting to remove config table records for group_name: $type", 1);
        DB_delete($_TABLES['conf_values'], 'group_name', $type);
        COM_errorLog('...success', 1);

        // remove topic assignment table data for this plugin
        COM_errorLog("Attempting to remove topic assignments table records for $type", 1);
        DB_delete($_TABLES['topic_assignments'], 'type', $type);
        COM_errorLog('...success', 1);

        // uninstall the plugin
        COM_errorLog("Attempting to unregister the $type plugin from Geeklog", 1);
        DB_delete($_TABLES['plugins'], 'pi_name', $type);
        COM_errorLog('...success', 1);

        COM_errorLog("Finished uninstalling the $type plugin.", 1);

        return true;
    } else {

        $retval = PLG_callFunctionForOnePlugin('plugin_uninstall_' . $type);

        if ($retval === true) {
            $plg = array_search($type, $_PLUGINS);
            if ($plg !== false) {
                unset($_PLUGINS[$plg]);
            }

            return true;

        }
    }

    return false;
}

/**
 * Inform plugin that it is either being enabled or disabled.
 *
 * @param    string  $type   Plugin name
 * @param    boolean $enable true if enabling, false if disabling
 * @return   boolean     Returns true on success otherwise false
 * @see      PLG_pluginStateChange
 */
function PLG_enableStateChange($type, $enable)
{
    global $_CONF;

    $args[1] = $enable;

    // IF we are enabling the plugin
    // THEN we must include its functions.inc so we have access to the function
    if ($enable) {
        require_once($_CONF['path'] . 'plugins/' . $type . '/functions.inc');
    }

    return PLG_callFunctionForOnePlugin('plugin_enablestatechange_' . $type, $args);
}

/**
 * Checks to see if user is a plugin moderator
 * Geeklog is asking if the user is a moderator for any installed plugins.
 *
 * @return bool
 */
function PLG_isModerator()
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $piName) {
        $function = 'plugin_ismoderator_' . $piName;
        if (is_callable($function) && $function()) {
            return true;
        }
    }

    $function = 'CUSTOM_ismoderator';
    if (is_callable($function) && $function()) {
        return true;
    }

    return false;
}

/**
 * Gives plugins a chance to print their menu items in header
 * Note that this is fairly unflexible.  This simply loops through the plugins
 * in the database in the order they were installed and get their menu items.
 * If you want more flexibility in your menu then you should hard code the menu
 * items in index.thtml for the theme(s) you are using.
 *
 * @return   array   Returns menu options for plugin
 */
function PLG_getMenuItems()
{
    global $_PLUGINS;

    $menu = array();
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getmenuitems_' . $pi_name;
        if (function_exists($function)) {
            $menuItems = $function();
            if (is_array($menuItems)) {
                $menu = array_merge($menu, $menuItems);
            }
        }
    }

    return $menu;
}

/**
 * Get URL where comments are viewed from for id
 * This also works for items (like articles) that are multipaged and the comments do not appear on the first page
 * NOTE: The Plugin API does not support $_CONF['url_rewrite'] here,
 *
 * @author  Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param   string $type Plugin of comment
 * @return  string string of URL of page with comments on it
 */
function PLG_getCommentUrlId($type, $id = '')
{
    global $_CONF;

    if (empty($id)) {
        // #Issue #1022 to fix articles with multiple pages and where comments are located
        // Need to add extra field to this function but still support old function until Geeklog v3.0.0. As of then $id will be required
        COM_deprecatedLog(__FUNCTION__, '2.2.1', '3.0.0', 'plugin_getcommenturlid_' . $type . " will require an id field passed to it");

        $ret = PLG_callFunctionForOnePlugin('plugin_getcommenturlid_' . $type);
        if (empty($ret[0])) {
            $ret[0] = $_CONF['site_url'] . "/$type/index.php";
        }
        if (empty($ret[1])) {
            $ret[1] = 'id';
        }

        // @return  array   string of URL of view page, name of unique identifier
        return $ret;
    } else {
        $args = array(
            1 => $id,
        );

        return PLG_callFunctionForOnePlugin('plugin_getcommenturlid_' . $type, $args);
    }
}

/**
 * Does the user have at least read access to this plugin item and are comments enabled for the item
 *
 * @param   string $type Plugin of comment
 * @param   string $id   Item id to which $cid belongs
 * @return  boolean      True if access granted or false
 * @since    Geeklog v2.2.1
 */
function PLG_commentEnabled($type, $id)
{
    global $_CONF;

    $args = array(
        1 => $id,
    );

    if ($type === 'article') {
        require_once $_CONF['path_system'] . 'lib-article.php';
    }

    return PLG_callFunctionForOnePlugin('plugin_commentenabled_' . $type, $args);
}

/**
 * Plugin should delete a comment
 *
 * @author  Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param   string $type Plugin to delete comment
 * @param   int    $cid  Comment to be deleted
 * @param   string $id   Item id to which $cid belongs
 * @param   boolean $returnOption  Either return a boolean on success or not, or redirect
 * @return  mixed        Based on $returnOption. false for failure or true for success, else a redirect for success or failure
 */
function PLG_commentDelete($type, $cid, $id, $returnBoolean = false)
{
    global $_CONF;

    if ($type === 'article') {
        require_once $_CONF['path_system'] . 'lib-article.php';
    }

    $function = 'plugin_deletecomment_' . $type;
    $numParameters = 2;
    if (function_exists($function)) {
        try {
            $info = new ReflectionFunction($function);
            $numParameters = $info->getNumberOfParameters();
        } catch (ReflectionException $e) {
            $numParameters = 0;
        }

        if ($numParameters == 3) {
            $args = array(
                1 => $cid,
                2 => $id,
                3 => $returnBoolean
            );
        }
    }

    if ($numParameters == 2) {
        // Issue #1035
        // Need to add extra field to this function but still support old function until Geeklog v3.0.0. As of then $returnBoolean will be required
        COM_deprecatedLog(__FUNCTION__, '2.2.1', '3.0.0', 'plugin_deletecomment_' . $type . " will require a returnBoolean field passed to it");

        $args = array(
            1 => $cid,
            2 => $id,
        );
    }

    return PLG_callFunctionForOnePlugin($function, $args);
}

/**
 * Plugin should save a comment
 *
 * @author Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param   string $type     Plugin to delete comment
 * @param   string $title    comment title
 * @param   string $comment  comment text
 * @param   string $id       Item id to which $cid belongs
 * @param   int    $pid      comment parent
 * @param   string $postMode 'html' or 'text'
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function PLG_commentSave($type, $title, $comment, $id, $pid, $postMode)
{
    global $_CONF;

    $args[1] = $title;
    $args[2] = $comment;
    $args[3] = $id;
    $args[4] = $pid;
    $args[5] = $postMode;

    if ($type === 'article') {
        require_once $_CONF['path_system'] . 'lib-article.php';
    }

    return PLG_callFunctionForOnePlugin('plugin_savecomment_' . $type, $args);
}

/**
 * Plugin should display [a] comment[s]
 *
 * @author Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param   string  $type   Plugin to display comment
 * @param   string  $id     Unique identifier for item comment belongs to
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
    global $_CONF;

    $args = array(
        1 => $id,
        2 => $cid,
        3 => $title,
        4 => $order,
        5 => $format,
        6 => $page,
        7 => $view,
    );

    if ($type === 'article') {
        require_once $_CONF['path_system'] . 'lib-article.php';
    }

    return PLG_callFunctionForOnePlugin('plugin_displaycomment_' . $type, $args);
}

/**
 * Allows plugins a chance to handle a comment before Geeklog does.
 * This is a first-come-first-serve affair so if a plugin returns an error, other
 * plugins wishing to handle comment preprocessing won't get called
 *
 * @author Tony Bibbs, tony AT tonybibbs DOT com
 * @access public
 * @param  int    $uid       User ID
 * @param  string &$title    Comment title
 * @param  string &$comment  Comment text
 * @param  string $sid       Story ID (not always a story, remember!)
 * @param  int    $pid       Parent comment ID
 * @param  string $type      Type of comment
 * @param  string &$postMode HTML or text
 * @return mixed     an error otherwise false if no errors were encountered
 * @see    PLG_itemPreSave
 */
function PLG_commentPreSave($uid, &$title, &$comment, $sid, $pid, $type, &$postMode)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_commentPreSave_' . $pi_name;
        if (function_exists($function)) {
            $someError = $function($uid, $title, $comment, $sid, $pid, $type, $postMode);
            if ($someError) {
                // Plugin doesn't want to save the comment
                return $someError;
            }
        }
    }

    $function = 'CUSTOM_commentPreSave';
    if (function_exists($function)) {
        $someError = $function($uid, $title, $comment, $sid, $pid, $type, $postMode);
        if ($someError) {
            // Custom function refused save:
            return $someError;
        }
    }

    return false;
}

/**
 * Allows plugins a chance to handle an item before Geeklog does. Modeled
 * after the PLG_commentPreSave() function.
 * This is a first-come-first-serve affair so if a plugin returns an error, other
 * plugins wishing to handle comment preprocessing won't get called
 *
 * @author Mark Evans, mevans AT ecsnet DOT com
 * @access public
 * @param string        $type     Type of item, i.e.; registration, contact ...
 * @param string|array  $content  item specific content
 * @return string                 empty is no error, error message if error was encountered
 * @see    PLG_commentPreSave
 */
function PLG_itemPreSave($type, $content)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_itemPreSave_' . $pi_name;
        if (function_exists($function)) {
            $msgError = $function ($type, $content);
            if (!empty($msgError)) {
                // Plugin doesn't want to save the item
                return $msgError;
            }
        }
    }

    $function = 'CUSTOM_itemPreSave';
    if (function_exists($function)) {
        $msgError = $function ($type, $content);
        if (!empty($msgError)) {
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
 * This plugin API function suffers from a variety of bugs and bad design
 * decisions for which we have to provide backward compatibility, so please
 * bear with us ...
 * The only parameter to this function, $showsitestats, was documented as being
 * being 1 for the site stats and 0 for the plugin-specific stats. However, the
 * latter was always called with a value of 2, so plugins only did a check for 1
 * and "else", which makes extensions somewhat tricky.
 * Furthermore, due to the original templates for the site stats, it has
 * become standard practice to hard-code a <table> in the plugins as the return
 * value for $showsitestats == 1. This table, however, didn't align properly
 * with the built-in site stats entries.
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
 * @param    int $showSiteStats value indicating type of stats to return
 * @return   array|string          array (for mode 3) or string
 */
function PLG_getPluginStats($showSiteStats)
{
    global $_PLUGINS;

    if ($showSiteStats == 3) {
        $retval = array();
    } else {
        $retval = '';
    }

    foreach ($_PLUGINS as $pi_name) {
        if ($showSiteStats == 3) {
            $function = 'plugin_statssummary_' . $pi_name;
            if (function_exists($function)) {
                $summary = $function ();
                if (is_array($summary)) {
                    $retval[$pi_name] = $summary;
                }
            }
        } elseif ($showSiteStats == 1) {
            $function1 = 'plugin_showstats_' . $pi_name;
            $function2 = 'plugin_statssummary_' . $pi_name;
            if (!function_exists($function2)) {
                if (function_exists($function1)) {
                    $retval .= $function1 ($showSiteStats);
                }
            }
        } elseif ($showSiteStats == 2) {
            $function = 'plugin_showstats_' . $pi_name;
            if (function_exists($function)) {
                $retval .= $function ($showSiteStats);
            }
        }
    }

    if ($showSiteStats == 3) {
        $function = 'CUSTOM_statssummary';
        if (function_exists($function)) {
            $summary = $function ();
            if (is_array($summary)) {
                $retval['Custom'] = $summary;
            }
        }
    } elseif ($showSiteStats == 1) {
        $function1 = 'CUSTOM_showstats';
        $function2 = 'CUSTOM_statssummary';
        if (!function_exists($function2)) {
            if (function_exists($function1)) {
                $retval .= $function1 ($showSiteStats);
            }
        }
    } elseif ($showSiteStats == 2) {
        $function = 'CUSTOM_showstats';
        if (function_exists($function)) {
            $retval .= $function ($showSiteStats);
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
 */
function PLG_getSearchTypes()
{
    global $_PLUGINS;

    $types = array();

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_searchtypes_' . $pi_name;
        if (function_exists($function)) {
            $currentTypes = $function ();
            if (is_array($currentTypes) && (count($currentTypes) > 0)) {
                $types = array_merge($types, $currentTypes);
            }
        } // no else because this is not a required API function
    }

    $function = 'CUSTOM_searchtypes';
    if (function_exists($function)) {
        $currentTypes = $function ();
        if (is_array($currentTypes) && (count($currentTypes) > 0)) {
            $types = array_merge($types, $currentTypes);
        }
    }

    asort($types);

    return $types;
}

/**
 * This function gives each plugin the opportunity to do their search
 * and return their results.  Results come back in an array of HTML
 * formatted table rows that can be quickly printed by search.php
 *
 * @param  string $query     What the user searched for
 * @param  string $dateStart beginning of date range to search for
 * @param  string $dateEnd   ending date range to search for
 * @param  string $topic     the topic the user searched within
 * @param  string $type      Type of items they are searching, or 'all'
 * @param  int    $author    UID...only return results for this person
 * @param  string $keyType   search key type: 'all', 'phrase', 'any'
 * @param  int    $page      page number of current search (deprecated)
 * @param  int    $perPage   number of results per page (deprecated)
 * @return array of SearchCriteria
 */
function PLG_doSearch($query, $dateStart, $dateEnd, $topic, $type, $author, $keyType = 'all', $page = 1, $perPage = 10)
{
    global $_PLUGINS;

    /**
     * The API, as of 1.6.0, does not use $page, $perpage
     * $type is now only used in the core and should not be passed to the plugin
     */

    $search_results = array();

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_dopluginsearch_' . $pi_name;
        if (function_exists($function)) {
            $result = $function($query, $dateStart, $dateEnd, $topic, $type, $author, $keyType, $page, $perPage);
            if (is_array($result)) {
                $search_results = array_merge($search_results, $result);
            } else {
                $search_results[] = $result;
            }
        }
        // no else because implementation of this API function not required
    }

    $function = 'CUSTOM_dopluginsearch';
    if (function_exists($function)) {
        $search_results[] = $function($query, $dateStart, $dateEnd, $topic, $type, $author, $keyType, $page, $perPage);
    }

    return $search_results;
}

/**
 * Asks each plugin to report any submissions they may have in their
 * submission queue
 *
 * @return   int     Number of submissions in queue for plugins
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
 * NOTE for plugin developers:
 * The plugin is responsible for its own security.
 * This supports a plugin having either a single menuitem or multiple menuitems.
 * The plugin has to provide an array for the menuitem of the format:
 * <code>
 * array(menuitem_title, item_url, submission_count)
 * </code>
 * or an array of arrays in case there are several entries:
 * <code>
 * array(
 *   array(menuitem1_title, item1_url, submission1_count),
 *   array(menuitem2_title, item2_url, submission2_count),
 *   array(menuitem3_title, item3_url, submission3_count))
 * </code>
 * Plugin function can return a single record array or multiple records
 *
 * @param    array  $var_names      An array of the variables that are retrieved.
 *                                  This has to match the named array that is used
 *                                  in the function returning the values
 * @param    array  $required_names An array of true/false-values, describing
 *                                  which of the above listed values is required
 *                                  to give a valid set of data.
 * @param    string $function_name  A string that gives the name of the function
 *                                  at the plugin that will return the values.
 * @return   array Returns options to add to the given menu that is calling this
 * @access   private
 * @internal not to be used by plugins
 */
function PLGINT_getOptionsforMenus($var_names, $required_names, $function_name)
{
    global $_PLUGINS;

    $pluginResults = array();

    $num_var_names = count($var_names);
    foreach ($_PLUGINS as $pi_name) {
        $function = $function_name . $pi_name;
        if (function_exists($function)) {
            $plg_array = $function();
            if (($plg_array !== false) && (is_array($plg_array) && count($plg_array) > 0)) {
                // Check if plugin is returning a single record array or multiple records
                $sets_array = array();
                $entries = 1;
                if (is_array($plg_array[0])) $entries = count($plg_array[0]);
                if ($entries == 1) {
                    // Single record - so we need to prepare the sets_array;
                    $sets_array[0] = $plg_array;
                } else {
                    // Multiple menu item records - in required format
                    $sets_array = $plg_array;
                }
                foreach ($sets_array as $val) {
                    $plugin = new Plugin();
                    $good_array = true;
                    for ($n = 0; $n < $num_var_names; $n++) {
                        if (isset($val[$n])) {
                            $plugin->{$var_names[$n]} = $val[$n];
                        } else {
                            $plugin->{$var_names[$n]} = '';
                        }
                        if (empty($plugin->{$var_names[$n]}) && $required_names[$n]) {
                            $good_array = false;
                        }
                    }

                    if ($good_array) {
                        $pluginResults[] = $plugin;
                    }
                }
            }
        }
    }

    return $pluginResults;
}

/**
 * This function shows the option for all plugins at the top of the
 * command and control center.
 * This supports that a plugin can have several lines in the CC menu.
 * The plugin has to provide simply a set arrays with 3 variables in order to
 * get n lines in the menu such as
 * <code>
 * array(
 *   array("first line", "url1", "1"),
 *   array("second line", "url2", "44"),
 *            etc, etc)
 * </code>
 * If there is only one item, a single array is enough:
 * <code>
 * array("first line", "url1", "1")
 * </code>
 *
 * @return   array   Returns Command and Control options for moderation.php
 */
function PLG_getCCOptions()
{
    $var_names = array('adminlabel', 'adminurl', 'plugin_image', 'admingroup');
    $required_names = array(true, true, true, false);
    $function_name = 'plugin_cclabel_';
    $pluginResults = PLGINT_getOptionsforMenus($var_names, $required_names, $function_name);

    return $pluginResults;
}

/**
 * This function will show any plugin administrative options in the
 * admin functions block on every page (assuming the user is an admin
 * and is logged in).
 * NOTE: the plugin is responsible for its own security.
 * This supports that a plugin can have several lines in the Admin menu.
 * The plugin has to provide simply a set arrays with 3 variables in order to
 * get n lines in the menu such as
 * <code>
 * array(
 *   array("first line", "url1", "1"),
 *   array("second line", "url2", "44"),,
 *            etc, etc)
 * </code>
 * If there is only one item, a single array is enough:
 * <code>
 * array("first line", "url1", "1")
 * </code>
 *
 * @return   array   Returns options to put in admin menu
 */
function PLG_getAdminOptions()
{
    $var_names = array('adminlabel', 'adminurl', 'numsubmissions', 'admingroup');
    $required_names = array(true, true, false, false);
    $function_name = 'plugin_getadminoption_';
    $pluginResults = PLGINT_getOptionsforMenus($var_names, $required_names, $function_name);

    return $pluginResults;
}

/**
 * This function will show any plugin user options in the
 * user block on every page
 * This supports that a plugin can have several lines in the User menu.
 * The plugin has to provide simply a set of arrays with 3 variables in order to
 * get n lines in the menu such as
 * <code>
 * array(
 *   array("first line", "url1", "1"),
 *   array("second line", "url2", "44"),
 *            etc, etc)
 * </code>
 * If there is only one item, a single array is enough:
 * <code>
 * array("first line", "url1", "1")
 * </code>
 * NOTE: the plugin is responsible for its own security.
 *
 * @return   array   Returns options to add to user menu
 */
function PLG_getUserOptions()
{
    // I know this uses the adminlabel, adminurl but who cares?
    $var_names = array('adminlabel', 'adminurl', 'numsubmissions');
    $required_names = array(true, true, false);
    $function_name = 'plugin_getuseroption_';
    $pluginResults = PLGINT_getOptionsforMenus($var_names, $required_names, $function_name);

    return $pluginResults;
}

/**
 * This function is responsible for calling
 * plugin_moderationapproves_<pluginname> which approves an item from the
 * submission queue for a plugin.
 *
 * @param        string $type Plugin name to do submission approval for
 * @param        string $id   used to identify the record to approve
 * @return       boolean     Returns true on success otherwise false
 */
function PLG_approveSubmission($type, $id)
{
    $args = array(1 => $id);

    return PLG_callFunctionForOnePlugin('plugin_moderationapprove_' . $type, $args);
}


/**
 * This function is responsible for calling
 * plugin_moderationcommentapprove_<pluginname> which allows plugins to update
 * the item related to the comment
 *
 * @param        string $type Plugin name related to the comment submission approval
 * @param        string $id   used to identify the record to approve
 * @return       boolean     Returns true on success otherwise false
 * @since    Geeklog v2.2.1
 */
function PLG_approveCommentSubmission($type, $id, $cid)
{
    global $_CONF;

    if ($type === 'article') {
        require_once $_CONF['path_system'] . 'lib-article.php';
    }

    $args = array(
        1 => $id,
        2 => $cid);

    return PLG_callFunctionForOnePlugin('plugin_moderationcommentapprove_' . $type, $args);
}

/**
 * This function is responsible for calling
 * plugin_moderationdelete_<pluginname> which deletes an item from the
 * submission queue for a plugin.
 *
 * @param        string $type Plugin to do submission deletion for
 * @param        string $id   used to identify the record for which to delete
 * @return       boolean     Returns true on success otherwise false
 */
function PLG_deleteSubmission($type, $id)
{
    $args = array(1 => $id);

    return PLG_callFunctionForOnePlugin('plugin_moderationdelete_' . $type, $args);
}

/**
 * This function calls the plugin_savesubmission_<pluginname> to save
 * a user submission
 *
 * @param        string $type Plugin to save submission for
 * @param        array  $A    holds plugin specific data to save
 * @return       boolean     Returns true on success otherwise false
 */
function PLG_saveSubmission($type, $A)
{
    $args = array(1 => $A);

    return PLG_callFunctionForOnePlugin('plugin_savesubmission_' . $type, $args);
}

/**
 * This function starts the chain of calls needed to show any submissions
 * needing moderation for the plugins.
 *
 * @param    string $token security token
 * @return   string          returns list of items needing moderation for plugins
 */
function PLG_showModerationList($token)
{
    global $_PLUGINS;

    $retval = '';

    foreach ($_PLUGINS as $pi_name) {
        $retval .= itemlist($pi_name, $token);
    }

    return $retval;
}

/**
 * This function is responsible for setting the plugin-specific values
 * needed by moderation.php to approve stuff.
 *
 * @param        string $type Plugin to call function for
 * @return       string
 */
function PLG_getModerationValues($type)
{
    return PLG_callFunctionForOnePlugin('plugin_moderationvalues_' . $type);
}

/**
 * This function is resonsible for calling plugin_submit_<pluginname> so
 * that the submission form for the plugin is displayed.
 *
 * @param        string $type Plugin to show submission form for
 * @return       string      HTML for submit form for plugin
 */
function PLG_showSubmitForm($type)
{
    return PLG_callFunctionForOnePlugin('plugin_submit_' . $type);
}

/**
 * This function will show the centerblock for any plugin.
 * Plugin can display some of their own content in a block on the index or any
 * topic index page. The block can be at the top or bottom of the page, after
 * the featured story or the plugin can take over the entire page.
 * The plugin is responsible to format the output correctly.
 *
 * @param    int    $where where 1 = top, 2 = after feat. story, 3 = bottom of page, 0 = entire page
 * @param    int    $page  page number (1, ...)
 * @param    string $topic topic ID or empty string == front page
 * @return   string          Formatted center block content
 * @since    Geeklog 1.3.8
 */
function PLG_showCenterblock($where = 1, $page = 1, $topic = '')
{
    global $PLG_bufferCenterAPI, $PLG_buffered, $_PLUGINS;

    $retval = '';

    // buffer function names since we're coming back for them two more times
    if (!$PLG_buffered) {
        $PLG_bufferCenterAPI = array();
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

        if (($where == 0) && !empty($retval)) {
            break;
        }
    }
    $function = 'CUSTOM_centerblock';
    if (function_exists($function)) {
        $retval .= $function($where, $page, $topic);
    }

    return $retval;
}

/**
 * This function will inform all plugins when a new user account is created.
 *
 * @param    int $uid user id of the new user account
 * @return   void
 */
function PLG_createUser($uid)
{
    global $_PLUGINS, $_CONF;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_create_' . $pi_name;
        if (function_exists($function)) {
            $function ($uid);
        }
    }

    if ($_CONF['custom_registration']) {
        // Check to see if user is a remote user. Cannot call custom user create function if a remote user
        if (!SEC_inGroup('Remote Users', $uid)) {
            if (is_callable('CUSTOM_userCreate')) {
                CUSTOM_userCreate($uid, false);
            } elseif (is_callable('CUSTOM_user_create')) {
                COM_errorLog(__FUNCTION__ . ': CUSTOM_user_create is deprecated as of Geeklog 2.1.2.  Please use CUSTOM_userCreate instead.');
                CUSTOM_user_create($uid);
            }
        }
    }
}

/**
 * This function will inform all plugins when a user account is deleted.
 *
 * @param    int $uid user id of the deleted user account
 * @return   void
 */
function PLG_deleteUser($uid)
{
    global $_PLUGINS, $_CONF;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_delete_' . $pi_name;
        if (function_exists($function)) {
            $function($uid);
        }
    }

    if ($_CONF['custom_registration']) {
        $function = 'CUSTOM_userDelete';
        if (function_exists($function)) {
            $function($uid);
        }
    }
}

/**
 * This function will inform all plugins when a user logs in
 * Note: This function is NOT called when users are re-authenticated by their
 * long-term cookie. The global variable $_USER['auto_login'] will be set to
 * 'true' in that case, however.
 *
 * @param    int $uid user id
 * @return   void
 */
function PLG_loginUser($uid)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_login_' . $pi_name;
        if (function_exists($function)) {
            $function($uid);
        }
    }

    $function = 'CUSTOM_user_login';
    if (function_exists($function)) {
        $function($uid);
    }
}

/**
 * This function will inform all plugins when a user account has reached the Max
 * number of invalid login attempts in the specified number of seconds.
 *
 * @param    int $uid user id of the user account with the max invalid logins
 * @return   void
 */
function PLG_invalidLoginsUser($uid)
{
    global $_PLUGINS, $_CONF;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_login_max_invalid_' . $pi_name;
        if (function_exists($function)) {
            $function($uid);
        }
    }

    if ($_CONF['custom_registration']) {
        $function = 'CUSTOM_user_login_max_invalid';
        if (function_exists($function)) {
            $function($uid);
        }
    }
}

/**
 * This function will inform all plugins when a user logs out.
 * Plugins should not rely on this ever being called, as the user may simply
 * close the browser instead of logging out.
 *
 * @param    int $uid user id
 * @return   void
 */
function PLG_logoutUser($uid)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_user_logout_' . $pi_name;
        if (function_exists($function)) {
            $function($uid);
        }
    }

    $function = 'CUSTOM_user_logout';
    if (function_exists($function)) {
        $function($uid);
    }
}

/**
 * This function is called to inform plugins when a user's information
 * (profile or preferences) has changed.
 *
 * @param    int $uid user id
 * @return   void
 */
function PLG_userInfoChanged($uid)
{
    global $_CONF, $_PLUGINS;

    $all_plugins = array_merge($_PLUGINS, array('topic'));

    foreach ($all_plugins as $pi_name) {
        $function = 'plugin_user_changed_' . $pi_name;
        if (function_exists($function)) {
            $function($uid);
        }
    }

    if ($_CONF['custom_registration']) {
        $function = 'CUSTOM_user_changed';
        if (function_exists($function)) {
            $function($uid);
        }
    }
}

/**
 * This function is called to inform plugins when a group's information has
 * changed or a new group has been created.
 *
 * @param    int    $grp_id Group ID
 * @param    string $mode   type of change: 'new', 'edit', or 'delete'
 * @return   void
 */
function PLG_groupChanged($grp_id, $mode)
{
    global $_PLUGINS;

    $all_plugins = array_merge($_PLUGINS, array('story', 'block', 'topic'));

    foreach ($all_plugins as $pi_name) {
        $function = 'plugin_group_changed_' . $pi_name;
        if (function_exists($function)) {
            $function($grp_id, $mode);
        }
    }

    $function = 'CUSTOM_group_changed';
    if (function_exists($function)) {
        $function($grp_id, $mode);
    }
}

/**
 * Geeklog is about to display the edit form for the user's profile. Plugins
 * now get a chance to add their own variables and input fields to the form.
 *
 * @param  int      $uid      user id of the user profile to be edited
 * @param  Template $template reference of the Template for the profile edit form
 */
function PLG_profileVariablesEdit($uid, &$template)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_profilevariablesedit_' . $pi_name;
        if (function_exists($function)) {
            $function ($uid, $template);
        }
    }

    $function = 'CUSTOM_profilevariablesedit';
    if (function_exists($function)) {
        $function($uid, $template);
    }
}

/**
 * Geeklog is about to display the edit form for the user's profile. Plugins
 * now get a chance to add their own blocks below the standard form.
 *
 * @param    int $uid user id of the user profile to be edited
 * @return   string          HTML for additional block(s)
 */
function PLG_profileBlocksEdit($uid)
{
    global $_PLUGINS;

    $retval = '';

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_profileblocksedit_' . $pi_name;
        if (function_exists($function)) {
            $retval .= $function ($uid);
        }
    }

    $function = 'CUSTOM_profileblocksedit';
    if (function_exists($function)) {
        $retval .= $function($uid);
    }

    return $retval;
}

/**
 * Geeklog is about to display the user's profile. Plugins now get a chance to
 * add their own variables to the profile.
 *
 * @param   int      $uid      user id of the user profile to be edited
 * @param   Template $template reference of the Template for the profile edit form
 * @return  void
 */
function PLG_profileVariablesDisplay($uid, $template)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_profilevariablesdisplay_' . $pi_name;
        if (function_exists($function)) {
            $function ($uid, $template);
        }
    }

    $function = 'CUSTOM_profilevariablesdisplay';
    if (function_exists($function)) {
        $function($uid, $template);
    }
}

/**
 * Geeklog is about to display the user's profile. Plugins now get a chance to
 * add their own blocks below the standard profile form.
 *
 * @param    int $uid user id of the user profile to be edited
 * @return   string               HTML for additional block(s)
 */
function PLG_profileBlocksDisplay($uid)
{
    global $_PLUGINS;

    $retval = '';

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_profileblocksdisplay_' . $pi_name;
        if (function_exists($function)) {
            $retval .= $function ($uid);
        }
    }

    $function = 'CUSTOM_profileblocksdisplay';
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
 * @param    string $plugin name of a specific plugin or empty(all plugins)
 * @return   void
 */
function PLG_profileExtrasSave($plugin = '', $uid = '')
{
    $args = array(
        1 => $uid
    );

    if (empty($plugin)) {
        PLG_callFunctionForAllPlugins('profileextrassave', $args);
    } else {
        PLG_callFunctionForOnePlugin('plugin_profileextrassave_' . $plugin, $args);
    }
}

/**
 * This function can be called to check if a plugin wants to set a template
 * variable
 * A plugin can check for $templatename == 'header' and then set additional
 * template variables
 * Called from within Geeklog for:
 * - 'header' (site header)
 * - 'footer' (site footer)
 * - 'storytext', 'featuredstorytext', 'archivestorytext' (story templates)
 * - 'story' (story submission)
 * - 'comment' (comment submission form)
 * - 'registration' (user registration form)
 * - 'contact' (email user form)
 * - 'emailstory' (email story to a friend)
 * - 'loginblock' (login form as a block)
 * - 'loginform' (both login form in the content area and login block since similar function and is only one checked by Geeklog login function)
 * - 'search' (advanced search form; simple search is usually part of 'header')
 *
 * @param    string   $templateName Name of calling template
 * @param    Template $template     reference for the Template
 * @return   void
 * @see      CUSTOM_templateSetVars
 */
function PLG_templateSetVars($templateName, $template)
{
    global $_PLUGINS;

    $all_plugins = array_merge($_PLUGINS, array('block'));

    foreach ($all_plugins as $pi_name) {
        $function = 'plugin_templatesetvars_' . $pi_name;
        if (function_exists($function)) {
            $function ($templateName, $template);
        }
    }

    if (function_exists('CUSTOM_templateSetVars')) {
        CUSTOM_templatesetvars($templateName, $template);
    }
}

/**
 * This function is called from COM_createHTMLDocument and will return additional header
 * information. This can be used for JavaScript functions required for the plugin
 * or extra Metatags
 *
 * @return   string      returns a concatenated string of all plugins extra header code
 * @since    Geeklog 1.3.8
 */
function PLG_getHeaderCode()
{
    global $_PLUGINS;

    $headerCode = '';

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getheadercode_' . $pi_name;
        if (function_exists($function)) {
            $headerCode .= $function();
        }
    }

    $function = 'CUSTOM_getheadercode';
    if (function_exists($function)) {
        $headerCode .= $function();
    }

    return $headerCode;
}

/**
 * This function is called from COM_createHTMLDocument and will return additional footer
 * information. This can be used for JavaScript functions required for the plugin
 *
 * @return   string      returns a concatenated string of all plugins extra footer code
 * @since    Geeklog 1.8.0
 */
function PLG_getFooterCode()
{
    global $_PLUGINS;

    $footerCode = '';

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getfootercode_' . $pi_name;
        if (function_exists($function)) {
            $footerCode .= $function();
        }
    }

    $function = 'CUSTOM_getfootercode';
    if (function_exists($function)) {
        $footerCode .= $function();
    }

    return $footerCode;
}

/**
 * Get a list of all currently supported autolink tags.
 * Returns an associative array where $A['tag-name'] = 'plugin-name'
 *
 * @param    string $type
 * @return   array   All currently supported autolink tags
 * @access   private
 * @internal not to be used by plugins
 */
function PLG_collectTags($type = 'tagname')
{
    global $_CONF, $_PLUGINS;

    if (isset($_CONF['disable_autolinks']) && ($_CONF['disable_autolinks'] == 1)) {
        // autolinks are disabled - return an empty array
        return array();
    }

    // ensure that we're picking up the Core autotags
    require_once $_CONF['path_system'] . 'lib-article.php';
    require_once $_CONF['path_system'] . 'lib-user.php';
    require_once $_CONF['path_system'] . 'lib-topic.php';
    require_once $_CONF['path_system'] . 'lib-block.php';
    require_once $_CONF['path_system'] . 'lib-structureddata.php';


    if (!is_array($_PLUGINS)) {
        /** as a side effect of parsing autotags in templates, we may end
         *  up here from a call to COM_errorLog() during the install, i.e.
         *  when Geeklog is not fully operational, so we need to catch this
         */
        $_PLUGINS = array();
    }
    $all_plugins = array_merge($_PLUGINS, array('article', 'user', 'topic', 'block', 'structureddata'));

    $autolinkModules = array();

    foreach ($all_plugins as $pi_name) {
        $function = 'plugin_autotags_' . $pi_name;
        if (function_exists($function)) {
            $autotag = $function($type);
            if ($type == 'tagname' || $type == 'permission' || $type == 'nopermission') {
                if ($type == 'permission') {
                    // Compare permission info if both blank then no permission info found so rerun for tagname (backwards compatible)
                    if (($function('permission') == '') && ($function('nopermission') == '')) {
                        $autotag = $function('tagname');
                    }
                }
                if (is_array($autotag)) {
                    foreach ($autotag as $tag) {
                        $autolinkModules[$tag] = $pi_name;
                    }
                } elseif ($autotag != '') { // If is now possible that a autotag function exists but will not return anything due to permissions
                    $autolinkModules[$autotag] = $pi_name;
                }
            } else {
                if (is_array($autotag)) {
                    foreach ($autotag as $key => $tag) {
                        $autolinkModules[$tag] = $key;
                    }
                } else {
                    $autolinkModules[$autotag] = '';
                }
            }
        }
    }

    return $autolinkModules;
}

/**
 * This function will allow plugins to support the use of custom autotags (use to be called autolinks)
 * in other site content. Plugins can now use this API when saving content
 * and have the content checked for any autotags before saving.
 * The autotag would be like:  [story:20040101093000103 here]
 *
 * @param   string $content Content that should be parsed for autotags
 * @param   string $parse_plugin    Optional if you only want to parse using a specific plugin
 * @param   bool   $remove          Optional if you want to remove the autotag from the content
 * @param   string $plugin          Optional plugin of content - requires id - New as of Geeklog 2.2.1
 *                                      Allows autotag to know what has called it (what content it is embedded in)
 *                                      so it can use functions like PLG_getItemInfo.
 *                                      Note: not supported for things like autotags in templates or blocks
 * @param   string $id              Optional id of content - requires plugin - New as of Geeklog 2.2.1
 * @return  string
 */
function PLG_replaceTags($content, $parse_plugin = '', $remove = false, $plugin = '', $id = '')
{
    global $_CONF, $LANG32;

    if (isset($_CONF['disable_autolinks']) && ($_CONF['disable_autolinks'] == 1)) {
        // autotags are disabled - return $content unchanged
        return $content;
    }

    if ($remove) {
        $autolinkModules = PLG_collectTags('nopermission');
        if (!is_array($autolinkModules)) { // a permission check may not return any data so no point parsing content
            return $content;
        }
    } else {
        $autolinkModules = PLG_collectTags();
    }

    //See if any tags require close tags
    $tags_requireclose = array();
    $collectclosetags = PLG_collectTags('closetag');
    $i = 0;
    foreach ($collectclosetags as $key => $val) {
        $tags_requireclose[$i] = $key;
        $i++;
    }

    for ($i = 1; $i <= 5; $i++) {
        // list($content, $markers) = GLText::protectJavascript($content);

        // For each supported module, scan the content looking for any autotags
        $tags = array();
        $contentLength = MBYTE_strlen($content);
        $content_lower = MBYTE_strtolower($content);
        foreach ($autolinkModules as $moduleTag => $module) {
            $autotag_prefix = '[' . $moduleTag . ':';
            $offset = 0;
            $prev_offset = 0;
            while ($offset < $contentLength) {
                $start_pos_tag = MBYTE_strpos($content_lower, $autotag_prefix, $offset);
                if ($start_pos_tag === false) {
                    break;
                } else {
                    $end_pos_tag = MBYTE_strpos($content_lower, ']', $start_pos_tag);
                    $next_tag = MBYTE_strpos($content_lower, '[', $start_pos_tag + 1);
                    if (($end_pos_tag > $start_pos_tag) && (($next_tag === false) || ($end_pos_tag < $next_tag))) {
                        $tagLength = $end_pos_tag - $start_pos_tag + 1;
                        $tag = MBYTE_substr($content, $start_pos_tag, $tagLength);
                        $params = explode(' ', $tag);

                        // Extra test to see if autotag was entered with a space
                        // after the module name
                        if (MBYTE_substr($params[0], -1) == ':') {
                            $startPos = MBYTE_strlen($params[0]) + MBYTE_strlen($params[1]) + 2;
                            $label = str_replace(']', '', MBYTE_substr($tag, $startPos));
                            $tagId = $params[1];
                        } else {
                            $label = str_replace(']', '', MBYTE_substr($tag, MBYTE_strlen($params[0]) + 1));
                            $params = explode(':', $params[0]);
                            if (count($params) > 2) {
                                // whoops, there was a ':' in the tag id ...
                                array_shift($params);
                                $tagId = implode(':', $params);
                            } else {
                                $tagId = $params[1];
                            }
                        }

                        // [tag:parameter1 And the rest here is parameter2]This is parameter3 if exist.[/tag]
                        $newTag = array(
                            'module'   => $module,
                            'tag'      => $moduleTag,
                            'tagstr'   => $tag,
                            'startpos' => $start_pos_tag,
                            'length'   => $tagLength,
                            'parm1'    => str_replace(']', '', $tagId),
                            'parm2'    => $label,
                        );

                        if (in_array($moduleTag, $tags_requireclose)) {
                            // Check for close tag after end of start tag. if exist we have a parm3
                            $close_tag = '[/' . $moduleTag . ']';
                            $start_pos_close_tag = MBYTE_strpos($content_lower, $close_tag, $end_pos_tag);
                            if ($start_pos_close_tag > $end_pos_tag) { // make sure close tag is after tag
                                $end_of_whole_tag_pos = $start_pos_close_tag + strlen($close_tag);
                                $wrapped_text_length = $start_pos_close_tag - ($end_pos_tag + 1);
                                $wrapped_text = MBYTE_substr($content, ($end_pos_tag + 1), $wrapped_text_length);

                                // New parm3
                                $newTag['parm3'] = $wrapped_text;
                                // Since parm3 now update tagstr and length as well
                                $newTag['tagstr'] = $tag . $wrapped_text . $close_tag;
                                $newTag['length'] = $end_of_whole_tag_pos - $start_pos_tag;

                                $tags[] = $newTag; // add completed tag to list
                            } else {
                                // Error: no close tag found - return with no changes
                                // return GLText::unprotectJavaScript($content, $markers) . $LANG32[32];
                                return $content . $LANG32[32];
                            }
                        } else {
                            $tags[] = $newTag; // add completed tag to list
                        }
                    } else {
                        // Error: tags do not match - return with no changes since error could cause loop if multiple autotags exist in content
                        // return GLText::unprotectJavaScript($content, $markers) . $LANG32[32];
                        return $content . $LANG32[32];
                    }
                    $prev_offset = $offset;
                    $offset = $end_pos_tag;
                }
            }
        }

        // If we have found 1 or more AutoLink tag
        if (count($tags) > 0) {       // Found the [tag] - Now process them all
            foreach ($tags as $autotag) {
                if ($remove) {
                    $content = str_replace($autotag['tagstr'], '', $content);
                } else {
                    $function = 'plugin_autotags_' . $autotag['module'];
                    if (function_exists($function) && (empty($parse_plugin) || ($parse_plugin == $autotag['module']))) {
                        try {
                            $info = new ReflectionFunction($function);
                            $numParameters = $info->getNumberOfParameters();
                        } catch (ReflectionException $e) {
                            $numParameters = 0;
                        }

                        if ($numParameters == 4) {
                            $parameters['type'] = $plugin;
                            $parameters['id'] = $id;
                            $content = $function('parse', $content, $autotag, $parameters);
                        } else {
                            $content = $function('parse', $content, $autotag);
                        }
                    }
                }
            }

            // $content = GLText::unprotectJavaScript($content, $markers);
        } else {
            // $content = GLText::unprotectJavaScript($content, $markers);
            break;
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
 */
function PLG_supportingFeeds()
{
    global $_CONF, $_PLUGINS;

    require_once $_CONF['path_system'] . 'lib-article.php';
    require_once $_CONF['path_system'] . 'lib-comment.php';

    $retval = array();

    $pluginTypes = array_merge(array('article', 'comment'), $_PLUGINS);

    foreach ($pluginTypes as $pi_name) {
        $function = 'plugin_getfeednames_' . $pi_name;
        if (function_exists($function)) {
            $feeds = $function();
            if (is_array($feeds) && (count($feeds) > 0)) {
                $retval[] = $pi_name;
            }
        }
    }

    $function = 'CUSTOM_getfeednames';
    if (function_exists($function)) {
        $feeds = $function();
        if (is_array($feeds) && (count($feeds) > 0)) {
            $retval[] = 'custom';
        }
    }

    return $retval;
}

/**
 * Ask the plugin for a list of feeds it supports. The plugin is expected to
 * return an array of id/name pairs where 'id' is the plugin's internal id
 * for the feed and 'name' is what will be presented to the user.
 *
 * @param    string $plugin plugin name
 * @return   array          array of id/name pairs
 */
function PLG_getFeedNames($plugin)
{
    global $_CONF, $_PLUGINS;

    $feeds = array();

    if ($plugin === 'custom') {
        $function = 'CUSTOM_getfeednames';
        if (function_exists($function)) {
            $feeds = $function();
        }
    } elseif ($plugin === 'article') {
        require_once $_CONF['path_system'] . 'lib-article.php';
        $feeds = plugin_getfeednames_article();
    } elseif ($plugin === 'comment') {
        require_once $_CONF['path_system'] . 'lib-comment.php';
        $feeds = plugin_getfeednames_comment();
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
 * @param    string $plugin       plugin name
 * @param    int    $feed         feed id
 * @param    string &$link        link to content on the site
 * @param    string &$update_data information for later up-to-date checks
 * @param    string $feedType     The type of feed (RSS/Atom etc)
 * @param    string $feedVersion  The version info of the feed.
 * @return   array                content of feed
 */
function PLG_getFeedContent($plugin, $feed, &$link, &$update_data, $feedType, $feedVersion)
{
    global $_CONF, $_PLUGINS;

    $content = array();

    if ($plugin == 'custom') {
        $function = 'CUSTOM_getfeedcontent';
        if (function_exists($function)) {
            $content = $function($feed, $link, $update_data, $feedType, $feedVersion);
        }
    } elseif ($plugin == 'article') {
        require_once $_CONF['path_system'] . 'lib-article.php';
        $content = plugin_getfeedcontent_article($feed, $link, $update_data, $feedType, $feedVersion);
    } elseif ($plugin == 'comment') {
        require_once $_CONF['path_system'] . 'lib-comment.php';
        $content = plugin_getfeedcontent_comment($feed, $link, $update_data, $feedType, $feedVersion);
    } else {
        if (in_array($plugin, $_PLUGINS)) {
            $function = 'plugin_getfeedcontent_' . $plugin;
            if (function_exists($function)) {
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
 * @param  string $contentType Type of feed content, article or a plugin specific type
 * @param  string $contentID   Unique identifier of content item to extend
 * @param  string $feedType    Type of feed format (RSS/Atom/etc)
 * @param  string $feedVersion Type of feed version (RSS 1.0 etc)
 * @param  string $topic       The topic for the feed.
 * @param  string $fid         The ID of the feed being fetched.
 * @return array               list of extension tags
 */
function PLG_getFeedElementExtensions($contentType, $contentID, $feedType, $feedVersion, $topic, $fid)
{
    global $_PLUGINS;

    $extensions = array();
    foreach ($_PLUGINS as $plugin) {
        $function = 'plugin_feedElementExtensions_' . $plugin;
        if (function_exists($function)) {
            $extensions = array_merge($extensions, $function($contentType, $contentID, $feedType, $feedVersion, $topic, $fid));
        }
    }

    $function = 'CUSTOM_feedElementExtensions';
    if (function_exists($function)) {
        $extensions = array_merge($extensions, $function($contentType, $contentID, $feedType, $feedVersion, $topic, $fid));
    }

    return $extensions;
}

/**
 * Get namespaces extensions for a feed. If a plugin has added extended tags
 * to a feed, then it may also need to insert some extensions to the name
 * spaces.
 *
 * @param  string $contentType Type of feed content, article or a plugin specific type
 * @param  string $feedType    Type of feed format (RSS/Atom/etc)
 * @param  string $feedVersion Type of feed version (RSS 1.0 etc)
 * @param  string $topic       The topic for the feed.
 * @param  string $fid         The ID of the feed being fetched.
 * @return array               list of extension namespaces
 */
function PLG_getFeedNSExtensions($contentType, $feedType, $feedVersion, $topic, $fid)
{
    global $_PLUGINS;

    $namespaces = array();
    foreach ($_PLUGINS as $plugin) {
        $function = 'plugin_feedNSExtensions_' . $plugin;
        if (function_exists($function)) {
            $namespaces = array_merge($namespaces, $function($contentType, $feedType, $feedVersion, $topic, $fid));
        }
    }

    $function = 'CUSTOM_feedNSExtensions';
    if (function_exists($function)) {
        $namespaces = array_merge($namespaces, $function($contentType, $feedType, $feedVersion, $topic, $fid));
    }

    return $namespaces;
}

/**
 * Get meta tag extensions for a feed. Add extended tags to the meta
 * area of a feed.
 *
 * @param  string $contentType Type of feed content, article or a plugin specific type
 * @param  string $feedType    Type of feed format (RSS/Atom/etc)
 * @param  string $feedVersion Type of feed version (RSS 1.0 etc)
 * @param  string $topic       The topic for the feed.
 * @param  string $fid         The ID of the feed being fetched.
 * @return array               list of meta tag extensions
 */
function PLG_getFeedExtensionTags($contentType, $feedType, $feedVersion, $topic, $fid)
{
    global $_PLUGINS;

    $tags = array();
    foreach ($_PLUGINS as $plugin) {
        $function = 'plugin_feedExtensionTags_' . $plugin;
        if (function_exists($function)) {
            $tags = array_merge($tags, $function($contentType, $feedType, $feedVersion, $topic, $fid));
        }
    }

    $function = 'CUSTOM_feedExtensionTags';
    if (function_exists($function)) {
        $tags = array_merge($tags, $function($contentType, $feedType, $feedVersion, $topic, $fid));
    }

    return $tags;
}

/**
 * The plugin is expected to check if the feed content needs to be updated.
 * This is called from COM_rdfUpToDateCheck() every time Geeklog's index.php
 * is displayed - it should try to be as efficient as possible ...
 * NOTE: The presence of non-empty $updated_XXX parameters indicates that an
 *       existing entry has been changed. The plugin may therefore apply a
 *       different method to check if its feed has to be updated.
 *
 * @param    string $plugin        plugin name
 * @param    int    $feed          feed id
 * @param    string $topic         "topic" of the feed - plugin specific
 * @param    string $update_data   comma-sep. list of updated ids
 * @param    string $limit         number of entries or number of hours
 * @param    string $updated_type  (optional) type of feed to update
 * @param    string $updated_topic (optional) topic to update
 * @param    string $updated_id    (optional) entry id to update
 * @return   boolean               false = feed has to be updated, true = ok
 */
function PLG_feedUpdateCheck($plugin, $feed, $topic, $update_data, $limit, $updated_type = '', $updated_topic = '', $updated_id = '')
{
    global $_CONF, $_PLUGINS;

    $is_current = true;

    if ($plugin === 'custom') {
        $function = 'CUSTOM_feedupdatecheck';
        if (function_exists($function)) {
            $is_current = $function ($feed, $topic, $update_data, $limit,
                $updated_type, $updated_topic, $updated_id);
        }
    } elseif ($plugin === 'article') {
        require_once $_CONF['path_system'] . 'lib-article.php';
        $is_current = plugin_feedupdatecheck_article($feed, $topic, $update_data, $limit,
            $updated_type, $updated_topic, $updated_id);
    } elseif ($plugin == 'comment') {
        require_once $_CONF['path_system'] . 'lib-comment.php';
        $is_current = plugin_feedupdatecheck_comment($feed, $topic, $update_data, $limit,
            $updated_type, $updated_topic, $updated_id);
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
 * Ask plugins if they want to add something to Geeklog's Related Items list.
 *
 * @param  array $types
 * @param  array $tids list of topic ids
 * @param  int   $max  maximum number of items to return
 * @param  int   $trim max length of text
 * @return array   A list of clickable links with the key being the timestamp
 */
function PLG_getRelatedItems($types, $tids, $max, $trim)
{
    global $_PLUGINS, $_CONF;

    $relatedItems = array();
    $returnedItems = array();

    $args = array(
        1 => $tids,
        2 => $max,
        3 => $trim,
    );

    if (in_array('article', $types) || in_array('story', $types) || empty($types)) {
        require_once $_CONF['path_system'] . 'lib-article.php';
        $returnedItems = plugin_getrelateditems_story($tids, $max, $trim);
    }

    foreach ($_PLUGINS as $pi_name) {
        // If no types (plugins) passed then assume all
        if (empty($types) OR in_array($pi_name, $types)) {
            $relatedItems = PLG_callFunctionForOnePlugin('plugin_getrelateditems_' . $pi_name, $args);
            if (is_array($relatedItems)) {
                $returnedItems = $returnedItems + $relatedItems;
            }
        }
    }

    $relatedItems = PLG_callFunctionForOnePlugin('CUSTOM_getrelateditems', $args);
    if (is_array($relatedItems)) {
        $returnedItems = $returnedItems + $relatedItems;
    }

    return $returnedItems;
}

/**
 * Ask plugins if they want to add something to Geeklog's What's New block.
 *
 * @return   array   array($headlines[], $bylines[], $content[$entries[]])
 */
function PLG_getWhatsNew()
{
    global $_PLUGINS;

    $newHeadlines = array();
    $newByLines = array();
    $newContent = array();

    foreach ($_PLUGINS as $pi_name) {
        $fn_head = 'plugin_whatsnewsupported_' . $pi_name;
        if (function_exists($fn_head)) {
            $supported = $fn_head();
            if (is_array($supported)) {
                list($headline, $byline) = $supported;

                $fn_new = 'plugin_getwhatsnew_' . $pi_name;
                if (function_exists($fn_new)) {
                    $whatsNew = $fn_new ();
                    $newContent[] = $whatsNew;
                    $newHeadlines[] = $headline;
                    $newByLines[] = $byline;
                }
            }
        }
    }

    $fn_head = 'CUSTOM_whatsnewsupported';
    if (function_exists($fn_head)) {
        $supported = $fn_head();
        if (is_array($supported)) {
            list($headline, $byline) = $supported;

            $fn_new = 'CUSTOM_getwhatsnew';
            if (function_exists($fn_new)) {
                $whatsNew = $fn_new ();
                $newContent[] = $whatsNew;
                $newHeadlines[] = $headline;
                $newByLines[] = $byline;
            }
        }
    }

    return array($newHeadlines, $newByLines, $newContent);
}

/**
 * Ask plugins if they want to add new comments to Geeklog's What's New block or
 * User Profile Page.
 *
 * @param    string $type        Plugin name. '' for all plugins.
 * @param    int    $numReturn   If 0 will return results for What's New Block.
 *                               If > 0 will return last X new comments for User Profile.
 * @param    int    $uid         ID of the user to return results for. 0 = all users.
 * @return   array list of new comments (dups, type, title, sid, lastdate) or (sid, title, cid, unixdate)
 * @since    Geeklog 1.7.0
 */
function PLG_getWhatsNewComment($type = '', $numReturn = 0, $uid = 0)
{
    global $_PLUGINS, $_CONF;

    $whatsNew = array();
    $pluginTypes = array();

    // Get Story new comment info first
    if (($type === 'article') || ($type === 'story') || ($type == '')) {
        require_once $_CONF['path_system'] . 'lib-article.php';
        $whatsNew = plugin_getwhatsnewcomment_story($numReturn, $uid);

        if ($type == '') {
            $pluginTypes = $_PLUGINS;
        }
    } else {
        $pluginTypes[] = $type;
    }

    if (!(($type === 'article') || ($type === 'story'))) {
        // Now check new comments for plugins
        foreach ($pluginTypes as $pi_name) {
            $fn_head = 'plugin_whatsnewsupported_' . $pi_name;
            if (function_exists($fn_head)) {
                $supported = $fn_head();
                if (is_array($supported) || ($numReturn > 0)) {
                    list($headline, $byline) = $supported;

                    $fn_new = 'plugin_getwhatsnewcomment_' . $pi_name;
                    if (function_exists($fn_new)) {
                        $tempWhatsNew = $fn_new ($numReturn, $uid);
                        if (!empty($tempWhatsNew) && is_array($tempWhatsNew)) {
                            if (!empty($whatsNew)) {
                                $whatsNew = array_merge($tempWhatsNew, $whatsNew);
                            } else {
                                $whatsNew = $tempWhatsNew;
                            }
                        }
                    }
                }
            }
        }
    }

    // Now check new comments for custom changes
    $fn_head = 'CUSTOM_whatsnewsupported';
    if (function_exists($fn_head)) {
        $supported = $fn_head();
        if (is_array($supported)) {
            list($headline, $byline) = $supported;

            $fn_new = 'CUSTOM_getwhatsnewcomment';
            if (function_exists($fn_new)) {
                $tempWhatsNew = $fn_new ($numReturn, $uid);
                if (!empty($tempWhatsNew) && is_array($tempWhatsNew)) {
                    $whatsNew = array_merge($tempWhatsNew, $whatsNew);
                }
            }
        }
    }

    return $whatsNew;

}

/**
 * Allows plugins and Core Geeklog Components to filter out spam.
 * The Spam-X Plugin is now part of the Geeklog Distribution
 * This plugin API will call the main function in the Spam-X plugin
 * but can also be used to call other plugins or custom functions
 * if available for filtering spam or content.
 * The caller should check for return values > 0 in which case spam has been
 * detected and the poster should be told, either via
 * <code>
 *   COM_redirect($_CONF['site_url'] . '/index.php?msg=' . $result . '&amp;plugin=spamx');
 * </code>
 * or by
 * <code>
 *   COM_displayMessageAndAbort($result, 'spamx', 403, 'Forbidden');
 * </code>
 * Where the former will only display a "spam detected" message while the latter
 * will also send an HTTP status code 403 with the message.
 *
 * @param  string $comment Text to be filtered or checked for spam
 * @param  int    $action  what to do if spam found
 * @param  string $permanentLink (since GL 2.2.0 for Akismet) - The full permanent URL of the entry the comment was submitted to
 * @param  string $commentType (since GL 2.2.0 for Akismet) - See system/classes/Akismet.php
 * @param  string $commentAuthor (since GL 2.2.0 for Akismet) - Name submitted with the comment (usually User Name)
 * @param  string $commentAuthorEmail (since GL 2.2.0 for Akismet) - User email address
 * @param  string $commentAuthorURL (since GL 2.2.0 for Akismet) - User Homepage or URL submitted with comment
 * @return int    either PLG_SPAM_NOT_FOUND, PLG_SPAM_FOUND or PLG_SPAM_UNSURE
 * @note   As for valid value for $commentType, see system/classes/Akismet.php
 * @link   http://wiki.geeklog.net/index.php/Filtering_Spam_with_Spam-X
 */
function PLG_checkForSpam($comment, $action = -1, $permanentLink = null,
                          $commentType = Geeklog\Akismet::COMMENT_TYPE_COMMENT,
                          $commentAuthor = null, $commentAuthorEmail = null, $commentAuthorURL = null)
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_checkforSpam_' . $pi_name;
        if (function_exists($function)) {
            $result = $function(
                $comment, $action, $permanentLink, $commentType,
                $commentAuthor, $commentAuthorEmail, $commentAuthorURL
            );

            if ($result > PLG_SPAM_NOT_FOUND) { // Plugin found a match for spam
                $result = PLG_spamAction($comment, $action);

                return $result;
            }
        }
    }

    $function = 'CUSTOM_checkforSpam';
    if (function_exists($function)) {
        $result = $function($comment, $action);

        if ($result > PLG_SPAM_NOT_FOUND) { // Plugin found a match for spam
            $result = PLG_spamAction($comment, $action);

            return $result;
        }
    }

    return 0;
}

/**
 * Act on spam
 * This is normally called from PLG_checkforSpam (see above) automatically when
 * spam has been detected. There may however be situations where spam has been
 * detected by some other means, in which case you may want to trigger the
 * spam action explicitly.
 *
 * @param    string $content Text to be filtered or checked for spam
 * @param    int    $action  what to do if spam found
 * @return   int                 > 0: spam detected, == 0: no spam detected
 * @see      PLG_checkForSpam
 * @since    Geeklog 1.4.1
 */
function PLG_spamAction($content, $action = -1)
{
    global $_PLUGINS;

    $result = PLG_SPAM_NOT_FOUND;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_spamaction_' . $pi_name;

        if (function_exists($function)) {
            $res = $function($content, $action);
            $result = max($result, $res);
        }
    }

    $function = 'CUSTOM_spamaction';

    if (function_exists($function)) {
        $res = $function($content, $action);
        $result = max($result, $res);
    }

    return $result;
}

/**
 * Ask plugin for information about one of its items
 * Item properties that can be requested:
 * - 'date-created'  - creation date, if available
 * - 'date-modified' - date of last modification, if available
 * - 'description'   - full description of the item
 * - 'excerpt'       - short description of the item
 * - 'id'            - ID of the item, e.g. sid for articles
 * - 'title'         - title of the item
 * - 'url'           - URL of the item
 * 'excerpt' and 'description' may return the same value. Properties should be
 * returned in the order they are listed in $what. Properties that are not
 * available should return an empty string.
 * Return false for errors (e.g. access denied, item does not exist, etc.).
 *
 * @param    string $type    plugin type (incl. 'article' for stories)
 * @param    string $id      ID of an item under the plugin's control or '*'
 * @param    string $what    comma-separated list of item properties
 * @param    int    $uid     user ID or 0 = current user
 * @param    array  $options not required and may not be supported.
 *           string $options['sub_type']               A sub type of type for when plugins have more than one item type. Added Geeklog v2.2.1
 *           string $options['filter']                 Filters work only for returning multiple items (using *). Allows filtering based on different supported properties. Unsupported filters are ignored
 *           string $options['filter']['topic-ids']    Comma separated list of topic ids in single quotes to be used in a sql statement ie: 'topicid1','topicid2'
 *           string $options['filter']['date-created'] Returns items created from this Unix timestamp till current date
 * @return   mixed               string or array of strings with the information
 * @link     http://wiki.geeklog.net/index.php/PLG_getItemInfo
 */
function PLG_getItemInfo($type, $id, $what, $uid = 0, $options = array())
{
    if (($type == 'article') || ($type == 'story')) {
        global $_CONF;

        require_once $_CONF['path_system'] . 'lib-article.php';

        $type = 'story';
    }

    $args = array(
        1 => $id,
        2 => $what,
        3 => $uid,
        4 => $options,
    );
    $function = 'plugin_getiteminfo_' . $type;

    return PLG_callFunctionForOnePlugin($function, $args);
}

/**
 * Asks each plugin tif they want to clear any cache of files they control
 * Used by clear cache in Geeklog Administration
 *
 * @return   array     Plugins that cleared their cache files and if they where successful or not
 */
function PLG_clearCache()
{
    global $_PLUGINS;

    $plugin_cache_name = array();
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_clearcache_' . $pi_name;
        if (function_exists($function)) {
            $plugin_cache_name[$pi_name] = $function(); // Should return true if success
        }
    }

    return $plugin_cache_name;
}

/**
 * Geeklog is about to perform an operation on a trackback or pingback comment
 * to one of the items under the plugin's control and asks for the plugin's
 * permission to continue.
 * Geeklog handles receiving and deleting trackback comments and pingbacks
 * for the plugin but since it doesn't know about the plugin's access control,
 * it has to ask the plugin to approve / reject such an operation.
 * $operation can be one of the following:
 * - 'acceptByID':  accept a trackback comment on item with ID $id
 *                  returns: true for accept, false for reject
 * - 'acceptByURI': accept a pingback comment on item at URL $id
 *                  returns: the item's ID for accept, false for reject
 * - 'delete':      is the current user allowed to delete item with ID $id?
 *                  returns: true for accept, false for reject
 *
 * @param    string $type      plugin type
 * @param    string $id        an ID or URL, depending on the operation
 * @param    string $operation operation to perform
 * @return   mixed               depends on $operation
 */
function PLG_handlePingComment($type, $id, $operation)
{
    $args = array(
        1 => $id,
        2 => $operation,
    );
    $function = 'plugin_handlepingoperation_' . $type;

    return PLG_callFunctionForOnePlugin($function, $args);
}

/**
 * Check if plugins have a scheduled task they want to run
 * The interval between runs is determined by $_CONF['cron_schedule_interval']
 *
 * @return void
 */
function PLG_runScheduledTask()
{
    global $_PLUGINS;

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_runScheduledTask_' . $pi_name;
        if (function_exists($function)) {
            $function ();
        }
    }

    if (function_exists('CUSTOM_runScheduledTask')) {
        CUSTOM_runScheduledTask();
    }
}

/**
 * "Generic" plugin API: Save submission
 * Called whenever Geeklog saves a submission into the database.
 * Plugins can define their own 'submissionsaved' function to be notified whenever
 * an submission is saved.
 *
 * @param  string $type type of the item, e.g. 'article'
 * @return void|bool
 */
function PLG_submissionSaved($type)
{
    global $_CONF, $_PLUGINS;

    $t = explode('.', $type);
    $plg_type = $t[0];

    // Treat template system like a plugin (since belong to core group)
    $pluginTypes = array('template');
    require_once $_CONF['path_system'] . 'lib-template.php';

    $pluginTypes = array_merge($pluginTypes, $_PLUGINS);

    foreach ($pluginTypes as $pi_name) {
        if ($pi_name != $plg_type) {
            $function = 'plugin_submissionsaved_' . $pi_name;
            if (function_exists($function)) {
                $function($type);
            }
        }
    }

    if (function_exists('CUSTOM_itemsaved')) {
        CUSTOM_itemsaved($type);
    }

    return false; // for backward compatibility
}

/**
 * "Generic" plugin API: Delete submission
 * Called whenever Geeklog removes a submission from the database.
 * Plugins can define their own 'submissiondeleted' function to be notified whenever
 * an submission is deleted.
 *
 * @param    string $type type of the item, e.g. 'article'
 */
function PLG_submissionDeleted($type)
{
    global $_CONF, $_PLUGINS;

    $t = explode('.', $type);
    $plg_type = $t[0];

    // Treat template system like a plugin (since belong to core group)
    $pluginTypes = array('template');
    require_once $_CONF['path_system'] . 'lib-template.php';

    $pluginTypes = array_merge($pluginTypes, $_PLUGINS);

    foreach ($pluginTypes as $pi_name) {
        if ($pi_name != $plg_type) {
            $function = 'plugin_submissiondeleted_' . $pi_name;
            if (function_exists($function)) {
                $function($type);
            }
        }
    }

    if (function_exists('CUSTOM_itemdeleted')) {
        CUSTOM_itemdeleted($type);
    }
}

/**
 * "Generic" plugin API: Save item
 * To be called (eventually) whenever Geeklog saves an item into the database.
 * Plugins can define their own 'itemsaved' function to be notified whenever
 * an item is saved or modified.
 * NOTE:     The behaviour of this API function changed in Geeklog 1.6.0
 *
 * @param    string $id     unique ID of the item
 * @param    string $type   type of the item, e.g. 'article'
 * @param    string $old_id (optional) old ID when the ID was changed
 * @return   void|bool      (actually: false, for backward compatibility)
 * @link     http://wiki.geeklog.net/index.php/PLG_itemSaved
 */
function PLG_itemSaved($id, $type, $old_id = '')
{
    global $_CONF, $_PLUGINS;

    $t = explode('.', $type);
    $plg_type = $t[0];

    // Treat template system like a plugin (since belong to core group)
    $pluginTypes = array('template');
    require_once $_CONF['path_system'] . 'lib-template.php';

    $pluginTypes = array_merge($pluginTypes, $_PLUGINS);

    foreach ($pluginTypes as $pi_name) {
        if ($pi_name != $plg_type) {
            $function = 'plugin_itemsaved_' . $pi_name;
            if (function_exists($function)) {
                $function($id, $type, $old_id);
            }
        }
    }

    if (function_exists('CUSTOM_itemsaved')) {
        CUSTOM_itemsaved($id, $type, $old_id);
    }

    return false; // for backward compatibility
}

/**
 * "Generic" plugin API: Delete item
 * To be called (eventually) whenever Geeklog removes an item from the database.
 * Plugins can define their own 'itemdeleted' function to be notified whenever
 * an item is deleted.
 *
 * @param    string $id   ID of the item
 * @param    string $type type of the item, e.g. 'article'
 * @return   void
 * @since    Geeklog 1.6.0
 */
function PLG_itemDeleted($id, $type)
{
    global $_CONF, $_PLUGINS;

    $t = explode('.', $type);
    $plg_type = $t[0];

    // Treat template system like a plugin (since belong to core group)
    $pluginTypes = array('template');
    require_once $_CONF['path_system'] . 'lib-template.php';

    $pluginTypes = array_merge($pluginTypes, $_PLUGINS);

    foreach ($pluginTypes as $pi_name) {
        if ($pi_name != $plg_type) {
            $function = 'plugin_itemdeleted_' . $pi_name;
            if (function_exists($function)) {
                $function($id, $type);
            }
        }
    }

    if (function_exists('CUSTOM_itemdeleted')) {
        CUSTOM_itemdeleted($id, $type);
    }
}

/**
 * "Generic" plugin API: Display item
 * To be called (eventually) whenever Geeklog displays an item.
 * Plugins can hook into this and add content to the displayed item, in the form
 * of an array (true, string1, string2...).
 * The object that called can then display one or several items with a
 * object-defined layout.
 * Plugins can signal an error by returning an array (false, 'Error Message')
 * In case of an error, the error message will be written to the error.log and
 * nothing will be displayed on the output.
 *
 * @param    string $id   unique ID of the item
 * @param    string $type type of the item, e.g. 'article'
 * @return   array        array with a status and one or several strings
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
                $result_arr = array_merge($result_arr, $result);
            }
        }
    }

    $function = 'CUSTOM_itemdisplay';
    if (function_exists($function)) {
        $result = $function ($id, $type);
        if ($result[0] == false) {
            // plugin reported a problem - do not add and continue
            COM_errorLog($result[1], 1);
        } else {
            array_shift($result);
            $result_arr = array_merge($result_arr, $result);
        }
    }

    return $result_arr;
}

/**
 * Get theme information for the request item location. For example CSS Classes or Styles
 * Introduced in Geeklog v2.2.1
 *
 * @param    string $id   unique ID of the item (either defined by core or a plugin)
 * @param    string $type type of the item or plugin, e.g. 'article'
 *
 * @return   string One or more CSS classes to be used in HTML
  */
function PLG_getThemeItem($id, $type)
{
    global $_CONF;

    $retval = '';

    switch($type)
    {
        case 'core';
        case 'article';
        case 'story';
        case 'comment';
        case 'topic';
            // Check theme for these types
            $function = 'theme_getThemeItem_' . $_CONF['theme'];
            if (function_exists($function)) {
                $retval = $function($id);
            } elseif (!empty($_CONF['theme_default'])) {
                // See if default theme if so check for it
                $function = 'theme_getThemeItem_' . $_CONF['theme_default'];
                if (function_exists($function)) {
                    $retval = $function($id);
                }
            }

            break;

        default;
            // Assume type is plugin so check plugin specific theme templates
            $function = $type . '_getThemeItem_' . $_CONF['theme'];
            if (function_exists($function)) {
                $retval = $function($id);
            } elseif (!empty($_CONF['theme_default'])) {
                // See if default theme if so check if plugin templates exist
                $function = $type . '_getThemeItem_' . $_CONF['theme_default'];
                if (function_exists($function)) {
                    $retval = $function($id);
                }
            }

            break;
    }

    return $retval;
}

/**
 * Get list of template locations where blocks can appear. This includes Themes, Plugins, and Plugin Templates
 * Introduced in Geeklog v2.2.0
 *
 * @return   array                  array of template names and variable names where blocks can appear
 * @See      PLG_templateSetVars    Block locations can only exist in templates that have been called with this function
 */
function PLG_getBlockLocations()
{
    global $_PLUGINS, $_CONF;

    $ret = array();

    // Include block locations on behalf of the theme
    $function = 'theme_getBlockLocations_' . $_CONF['theme'];
    if (function_exists($function)) {
        $items = $function();
        if (is_array($items)) {
            // Add type and type name for all elements
            foreach ($items as &$item) {
                $item['type'] = 'theme';
                $item['type_name'] = $_CONF['theme'];
            }
            $ret = array_merge($ret, $items);
        }
    } elseif (!empty($_CONF['theme_default'])) {
        // See if default theme if so check for it
        $function = 'theme_getBlockLocations_' . $_CONF['theme_default'];
        if (function_exists($function)) {
            $items = $function();
            if (is_array($items)) {
                // Add type and type name for all elements
                foreach ($items as &$item) {
                    $item['type'] = 'theme';
                    $item['type_name'] = $_CONF['theme_default'];
                }
                $ret = array_merge($ret, $items);
            }
        }
    }


    // Add in components so they can act like plugins
    require_once $_CONF['path_system'] . 'lib-article.php';
    require_once $_CONF['path_system'] . 'lib-comment.php';

    $pluginTypes = array_merge(array('article', 'comment'), $_PLUGINS);

    foreach ($pluginTypes as $pi_name) {
        // Check plugin itself (would cover all plugin theme templates)
        $function = 'plugin_getBlockLocations_' . $pi_name;
        if (function_exists($function)) {
            $items = $function();
            if (is_array($items)) {
                // Add type and type name for all elements
                foreach ($items as &$item) {
                    $item['type'] = 'plugin';
                    $item['type_name'] = $pi_name;
                }
                $ret = array_merge($ret, $items);
            }
        }

        // Now check plugin specific theme templates as it may only be assigned here
        $function = $pi_name . '_getBlockLocations_' . $_CONF['theme'];
        if (function_exists($function)) {
            $items = $function();
            if (is_array($items)) {
                // Add type and type name for all elements
                foreach ($items as &$item) {
                    $item['type'] = 'plugin';
                    $item['type_name'] = $pi_name;
                }
                $ret = array_merge($ret, $items);
            }
        } elseif (!empty($_CONF['theme_default'])) {
            // See if default theme if so check if plugin templates exist
            $function = $pi_name . '_getBlockLocations_' . $_CONF['theme_default'];
            if (function_exists($function)) {
                $items = $function();
                if (is_array($items)) {
                    // Add type and type name for all elements
                    foreach ($items as &$item) {
                        $item['type'] = 'plugin';
                        $item['type_name'] = $pi_name;
                    }
                    $ret = array_merge($ret, $items);
                }
            }
        }
    }

    if (function_exists('CUSTOM_getBlockLocations')) {
        $customBlocks = CUSTOM_getBlockLocations();
        if (is_array($customBlocks)) {
            $ret = array_merge($ret, $customBlocks);
        }
    }

    return $ret;
}

/**
 * Gets Geeklog blocks from plugins
 * Returns data for blocks on a given side and, potentially, for
 * a given topic.
 *
 * @param    string $side  Side to get blocks for (right or left for now)
 * @param    string $topic Only get blocks for this topic
 * @return   array           array of block data
 * @link     http://wiki.geeklog.net/index.php/Dynamic_Blocks
 */
function PLG_getBlocks($side, $topic = '')
{
    global $_PLUGINS;

    $ret = array();
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getBlocks_' . $pi_name;
        if (function_exists($function)) {
            $items = $function($side, $topic);
            if (is_array($items)) {
                $ret = array_merge($ret, $items);
            }
        }
    }

    if (function_exists('CUSTOM_getBlocks')) {
        $customItems = CUSTOM_getBlocks($side, $topic);
        if (is_array($customItems)) {
            $ret = array_merge($ret, $customItems);
        }
    }

    return $ret;
}

/**
 * Gets Geeklog blocks from plugins
 * Returns config data for blocks on a given side and, potentially, for
 * a given topic.
 *
 * @param    string $side  Side to get blocks for (right or left for now)
 * @param    string $topic Only get blocks for this topic
 * @return   array           array of block data
 * @link     http://wiki.geeklog.net/index.php/Dynamic_Blocks
 */
function PLG_getBlocksConfig($side, $topic = '')
{
    global $_PLUGINS;

    $ret = array();
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getBlocksConfig_' . $pi_name;
        if (function_exists($function)) {
            $items = $function($side, $topic);
            if (is_array($items)) {
                $ret = array_merge($ret, $items);
            }
        }
    }

    if (function_exists('CUSTOM_getBlocks')) {
        $customItems = CUSTOM_getBlocks($side, $topic);
        if (is_array($customItems)) {
            $ret = array_merge($ret, $customItems);
        }
    }

    return $ret;
}

/**
 * Get the URL of a plugin's icon
 *
 * @param    string $type plugin name
 * @return   string          URL of the icon
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
    if (empty($retval)) {
        $function = 'plugin_cclabel_' . $type;
        if (function_exists($function)) {
            $ccLabel = $function ();
            if (is_array($ccLabel)) {
                if (!empty($ccLabel[2])) {
                    $retval = $ccLabel[2];
                }
            }
        }
    }

    // lastly, search for the icon
    if (empty($retval)) {
        // create a list of possible icon locations
        $icons = array(
            '/' . $type . '/images/' . $type . '.gif',
            '/' . $type . '/images/' . $type . '.png',
            '/admin/plugins/' . $type . '/images/' . $type . '.gif',  // Hardcoding 'admin' here is not ideal, but we
            '/admin/plugins/' . $type . '/images/' . $type . '.png',
        ); // don't have a $_CONF['path_site_admin'] variable.

        // see if any of these files exists and is readable
        foreach ($icons as $key => $value) {
            if (is_readable($_CONF['path_html'] . $value)) { // search for the path (e.g.: '/home/user/example.com/foo')
                $retval = $_CONF['site_url'] . $value; // but return the URL (e.g.: 'http://example.com/foo')
                break;
            }
        }
    }

    // Still nothing? Give up and use a generic icon
    if (empty($retval)) {
        $retval = $_CONF['layout_url'] . '/images/icons/plugins.png';
    }

    return $retval;
}

/**
 * Asks plugins to return what the url parts are for any that support mutli language items
 *
 * @return   array      Array of array of url parts needed to determine if a url has an item id in it that contains a language id
 *                      URL parts of array include: plugin name, directory, filename, item id url variable name
 */
function PLG_getLanguageURL()
{
    global $_CONF, $_PLUGINS;

    // Don't use a plugin function or plugin config for this as plugins functions.inc is not loaded yet when COM_getLanguage is called in lib-common
    // Instead grab from a hidden Core conf_values (which are loaded)
    // See _getLanguageInfoFromURL in lib-common for a detailed explanation

    $retval = array();

    // Add article and topic to enabled plugins
    $pluginTypes = array_merge(array('article', 'topic'), $_PLUGINS);

    foreach ($pluginTypes as $pi_name) {
        $array_key = 'langurl_' . $pi_name;
        if (array_key_exists($array_key, $_CONF)) {
            if (is_array($_CONF[$array_key]) && (count($_CONF[$array_key]) > 0)) {
                $langurl = $_CONF[$array_key];
                array_unshift($langurl, $pi_name);
                $retval[] = $langurl;
            }
        }
    }

    return $retval;
}


/**
 * Invoke a service
 *
 * @param   string $type     The plugin type whose service is to be called
 * @param   string $action   The service action to be performed
 * @param   array  $args     The arguments to be passed to the service invoked
 * @param   array  &$output  The output variable that will contain the output after invocation
 * @param   array  &$svc_msg The output variable that will contain the service messages
 * @return  int              The result of the invocation
 * @link    http://wiki.geeklog.net/index.php/Webservices_API
 */
function PLG_invokeService($type, $action, $args, &$output, &$svc_msg)
{
    global $_CONF;

    $retval = PLG_RET_ERROR;

    if ($type === 'story') {
        // ensure we can see the service_XXX_story functions
        require_once $_CONF['path_system'] . 'lib-article.php';
    }

    $output = array();
    $svc_msg = array();

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
 * @param   string $type The plugin type that is to be checked
 * @return  boolean         true: enabled, false: disabled
 * @link    http://wiki.geeklog.net/index.php/Webservices_API
 */
function PLG_wsEnabled($type)
{
    global $_CONF;

    if ($type == 'story') {
        // ensure we can see the service_XXX_story functions
        require_once $_CONF['path_system'] . 'lib-article.php';
    }

    $function = 'plugin_wsEnabled_' . $type;
    if (function_exists($function)) {
        return $function();
    } else {
        return false;
    }
}

/**
 * Forward the user depending on config setting after saving something
 *
 * @param  string $target   where to redirect to
 * @param  string $item_url the url of the item saved
 * @param  string $plugin   the name of the plugin that saved the item
 * @param  string $message  (optional) message number to attach to url
 * @return string              the url where the user will be forwarded to
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
            if (!empty($msg) && ($plugin != 'story')) {
                if (strpos($url, '?') === false) {
                    $url .= '?' . $msg;
                } else {
                    $url .= '&amp;' . $msg;
                }
            }
            break;

        case 'home':
            $url = $_CONF['site_url'] . '/index.php';
            if (!empty($msg)) {
                $url .= '?' . $msg;
                if (($plugin != 'story') && ($plugin != 'user')) {
                    $url .= '&amp;plugin=' . $plugin;
                }
            }
            break;

        case 'admin':
            $url = $_CONF['site_admin_url'] . '/moderation.php';
            if (!empty($msg)) {
                $url .= '?' . $msg;
                if (($plugin != 'story') && ($plugin != 'user')) {
                    $url .= '&amp;plugin=' . $plugin;
                }
            }
            break;

        case 'plugin':
            $url = $_CONF['site_url'] . "/$plugin/index.php";
            if (!empty($msg)) {
                $url .= '?' . $msg;
            }
            break;

        case 'list':
        default:
            if ($plugin == 'story' OR $plugin == 'article') {
                $url = $_CONF['site_admin_url'] . "/article.php";
            } elseif ($plugin == 'user') {
                $url = $_CONF['site_admin_url'] . "/user.php";
            } else {
                $url = $_CONF['site_admin_url'] . "/plugins/$plugin/index.php";
            }
            if (!empty($msg)) {
                $url .= '?' . $msg;
            }
            break;
    }

    COM_redirect($url);
}

/**
 * Inform plugins of configuration changes
 * NOTE: Plugins will only be notified of details of changes in 'Core' and in
 *       their own configuration. For other plugins, they will only be notified
 *       of the fact that something in the other plugin's config changed.
 *
 * @param    string $group   plugin name or 'Core' for $_CONF changes
 * @param    array  $changes names of config values that changed
 * @return   void
 * @link     http://wiki.geeklog.net/index.php/PLG_configChange
 * @since    Geeklog 1.6.0
 */
function PLG_configChange($group, $changes)
{
    global $_CONF, $_PLUGINS;

    // Treat articles like a plugin (since belong to core group)
    $pluginTypes = array('article');
    require_once $_CONF['path_system'] . 'lib-article.php';
    // Treat template system like a plugin (since belong to core group)
    $pluginTypes[] = 'template';
    require_once $_CONF['path_system'] . 'lib-template.php';

    $pluginTypes = array_merge($pluginTypes, $_PLUGINS);

    foreach ($pluginTypes as $pi_name) {
        $args = array();
        $args[1] = $group;

        if (($group == 'Core') || ($group == $pi_name)) {
            $args[2] = $changes;
        }

        PLG_callFunctionForOnePlugin('plugin_configchange_' . $pi_name, $args);
    }

    $function = 'CUSTOM_configchange';
    if (function_exists($function)) {
        if ($group === 'Core') {
            $function($group, $changes);
        } else {
            $function($group);
        }
    }
}

/**
 * Ask plugin for the URL to its documentation
 *
 * @param    string $type plugin name
 * @param    string $file documentation file being requested, e.g. 'config'
 * @return   mixed           URL or false / empty string when not available
 * @link     http://wiki.geeklog.net/index.php/PLG_getDocumentationUrl
 * @since    Geeklog 1.6.0
 */
function PLG_getDocumentationUrl($type, $file)
{
    $args[1] = $file;
    $function = 'plugin_getdocumentationurl_' . $type;

    return PLG_callFunctionForOnePlugin($function, $args);
}

/**
 * Ask plugin for text for a Configuration tooltip
 *
 * @param    string $group   plugin name or 'Core'
 * @param    string $id      Id of config value
 * @return   mixed           Text to use regular tooltip, NULL to use config
 *                           tooltip hack, or empty string when not available
 * @link     http://wiki.geeklog.net/index.php/PLG_getConfigTooltip
 * @since    Geeklog 1.8.0
 */
function PLG_getConfigTooltip($group, $id)
{
    if ($group === 'Core') {
        $retval = false;
    } else {
        $args[1] = $id;
        $function = 'plugin_getconfigtooltip_' . $group;

        $retval = PLG_callFunctionForOnePlugin($function, $args);
    }

    return $retval;
}

/**
 * Inform plugins when another plugin's state changed
 * Unlike PLG_enableStateChange, this function is called after the state
 * change.
 * NOTE: You can not rely on being informed of state changes for 'installed',
 * 'uninstalled', and 'upgraded', as these may happen in the plugin's install
 * script, outside of Geeklog's control.
 *
 * @param    string $type   plugin name
 * @param    string $status new status: 'enabled', 'disabled', 'installed', 'uninstalled', 'upgraded'
 * @return   void
 * @see      PLG_enableStateChange
 * @since    Geeklog 1.6.0
 */
function PLG_pluginStateChange($type, $status)
{
    global $_PLUGINS;

    $args = array(
        1 => $type,
        2 => $status,
    );
    foreach ($_PLUGINS as $pi_name) {
        if ($pi_name != $type) {
            $function = 'plugin_pluginstatechange_' . $pi_name;
            PLG_callFunctionForOnePlugin($function, $args);
        }
    }

    $function = 'CUSTOM_pluginstatechange';
    if (function_exists($function)) {
        $function($type, $status);
    }
}

/**
 *  Disables all plugins with unresolved dependencies
 *  and resolves the load order for all enabled plugins.
 *
 * @return   bool    True or False, depending on whether it was
 *                   necessary to alter the load order of a plugin
 * @since            Geeklog 1.8.0
 */
function PLG_resolveDependencies()
{
    global $_PLUGINS, $_TABLES;

    $flag = true; // false means that all dependencies are resolved
    while ($flag) { // loop until ALL dependencies are satisfied
        $flag = false; // set this if any plugin has been disabled during the loop
        foreach ($_PLUGINS as $key => $pi_name) {
            if (!PLG_checkDependencies($pi_name)) { // plugin has unresolved dependencies
                // disable plugin;
                $flag = true; // disabling a plugin can break the dependencies of a plugin that has already been checked, remember to loop again
                PLG_enableStateChange($pi_name, false);
                DB_change($_TABLES['plugins'], 'pi_enabled', 0,
                    'pi_name', $pi_name);
                PLG_pluginStateChange($pi_name, 'disabled');
                unset($_PLUGINS[$key]);
            }
        }
    }
    // automatically resolve load order for enabled plugins
    $index = 2000; // how far through the load order to push back plugins
    $maxQueries = 50; // just in case...
    $globalFlag = false; // remember if we change the load order of any plugin
    $flag = true; // set true if we need another pass in the while loop
    while ($flag && $maxQueries) { // Now check if the load order is correct
        $flag = false;
        // get the load orders of all enabled plugins
        $q = DB_query("SELECT pi_name, pi_load FROM {$_TABLES['plugins']} WHERE pi_enabled='1'");
        $plo = array(); // Plugins Load Order
        while ($a = DB_fetchArray($q)) {
            $plo[] = $a;
        }

        foreach ($plo as $key => $value) { // for each available plugin
            $maxQueries--;
            $params = PLG_getParams($value['pi_name']); // get dependencies
            if (isset($params['requires']) && is_array($params['requires'])) { // if any
                foreach ($params['requires'] as $rkey => $rvalue) { // process each dependency
                    if (isset($rvalue['plugin'])) {
                        // get the load order of the required plugin
                        foreach ($plo as $new_key => $new_value) {
                            if ($new_value['pi_name'] == $rvalue['plugin']) {
                                $dep_load = $new_value['pi_load'];
                                break;
                            }
                        }
                        if ($dep_load > $value['pi_load']) { // incorrect load order
                            // move down the order
                            DB_query("UPDATE {$_TABLES['plugins']} SET pi_load = '{$index}' WHERE pi_name = '{$value['pi_name']}'");
                            $index++;
                            $flag = true;
                            $globalFlag = true;
                        }
                    }
                }
            }
        }
    }

    reorderplugins();

    if ($globalFlag == false) {
        return true; // no change
    } else {
        return false; // something changed
    }
}

/**
 * Returns a string with HTML that contains the dependency information of a plugin.
 *
 * @param    $pi_name        string     The short name of the plugin
 * @param    $pi_gl_version  string     Specify a minimum version of Geeklog to require.
 *                           (Optional and only for use with plugins that have the old-style install.)
 * @return   string         An string that contains HTML code.
 * @since    Geeklog 1.8.0
 */
function PLG_printDependencies($pi_name, $pi_gl_version = '')
{
    global $LANG32, $_DB_dbms;

    $retval = '';
    $params = PLG_getParams($pi_name);

    $dbAvailable = array(); // cache the databases that are supported by the plugin
    $dbSupported = false; // True if we support the database that the plugin is requiring

    if (isset($params['requires']) && count($params['requires']) > 0) { // new autoinstall type
        foreach ($params['requires'] as $key => $value) { // check every requirement that is imposed by the plugin
            $name = '';
            if (isset($value['plugin'])) {
                $name = $value['plugin'];
            } elseif (isset($value['core'])) {
                $name = 'geeklog';
            }
            $op = '>='; // set the default
            if (isset($value['operator'])) { // optional operator included
                $op = $value['operator']; // override default
            }
            $ver = '0.0.0'; // set the default version
            if (isset($value['version'])) { // the plugin is requiring a particular version
                $ver = $value['version']; // override the default
            }
            if (!empty($name)) { // check for a plugin or a core requirement
                $op = '>='; // set the default
                $retval .= "<b class=\"notbold\" style=\"display: block; padding: 2px; margin: 0;\">$name $op $ver ";
                $status = PLG_checkAvailable($name, $ver, $op);
                if (!$status) {
                    $retval .= "<b class='status_red'>{$LANG32[54]}</b>";
                } else if ($status == 'wrong_version') {
                    $retval .= "<b class='status_red'>{$LANG32[56]}</b>";
                } else if ($status == 'disabled') {
                    $retval .= "<b class='status_orange'>{$LANG32[53]}</b>";
                } else if ($status == 'uninstalled') {
                    $retval .= "<b class='status_orange'>{$LANG32[55]}</b>";
                } else if ($status == 'ok') {
                    $retval .= "<b class='status_green'>{$LANG32[51]}</b>";
                }
                $retval .= "</b>";
            } else if (isset($value['db'])) { // check for a database requirement
                $dbAvailable[] = array($value['db'], $op, $ver); // cache the database types
                if ($_DB_dbms == $value['db']) { // this db requirement matches the database that the site is run on
                    $name = $value['db'];
                    $retval .= "<b class=\"notbold\" style=\"display: block; padding: 2px; margin: 0;\">$name $op $ver ";
                    if (PLG_checkAvailableDb($name, $pi_name, $ver, $op)) {
                        $dbSupported = true; // the reuirement for the database is fullfilled
                        $retval .= "<b class='status_green'>{$LANG32[51]}</b>";
                    } else { // unsupported version
                        $retval .= "<b class='status_red'>{$LANG32[54]}</b>";
                    }
                    $retval .= "</b>";
                }
            }
        }
        if (count($dbAvailable) > 0 && !$dbSupported) {
            // the plugin requires a database, but this requirement is not fullfilled
            foreach ($dbAvailable as $key => $value) { // print every database that would satisfy this requirement
                $retval .= "<b class=\"notbold\" style=\"display: block; padding: 2px; margin: 0;\">{$value[0]} {$value[1]} {$value[2]} ";
                $retval .= "<b class='status_red'>{$LANG32[54]}</b>";
                $retval .= "</b>";
            }
        }
    } else if (!empty($pi_gl_version)) { // old plugin install
        $retval .= "geeklog >= $pi_gl_version ";
        if (PLG_checkAvailable('geeklog', $pi_gl_version)) {
            $retval .= "<b class='status_green'>{$LANG32[51]}</b>";
        } else {
            $retval .= "<b class='status_red'>{$LANG32[54]}</b>";
        }
    } else { // we're not too sure right now....
        $retval .= "<b class='status_black'>{$LANG32[57]}</b>";
    }

    return $retval;
}

/**
 * Given a plugin name see if ALL of it's dependencies are satisfied
 *
 * @param    string $pi_name  The short name of the plugin
 * @return   bool            True or False, depending on whether all of the
 *                            dependencies are satisfied for plugin $pi_name
 * @since    Geeklog 1.8.0
 */
function PLG_checkDependencies($pi_name)
{
    global $_TABLES, $_DB_dbms;

    $params = PLG_getParams($pi_name);

    $dbSupported = false; // True if we support the database that the plugin is requiring
    $dbRequired = false; // True if the plugin needs a database

    if (isset($params['requires']) && count($params['requires']) > 0) { // plugin exists and uses new installer
        foreach ($params['requires'] as $key => $value) { // check for requirements
            $name = '';
            if (isset($value['plugin'])) {
                $name = $value['plugin'];
            } elseif (isset($value['core'])) {
                $name = $value['core'];
            }
            $op = '>='; // set the default
            if (!empty($value['operator'])) { // optional operator included
                $op = $value['operator']; // override default
            }
            $ver = '0.0.0'; // set the default version
            if (isset($value['version'])) { // the plugin is requiring a particular version
                $ver = $value['version']; // override the default
            }
            if (!empty($name)) { // check for a plugin or a core requirement
                if (PLG_checkAvailable($name, $ver, $op) != 'ok') {
                    return false;
                }
            } elseif (isset($value['db'])) { // check for db requirements
                $dbRequired = true; // there is at least one database requirement
                if ($_DB_dbms == $value['db'] && PLG_checkAvailableDb($value['db'], $pi_name, $ver, $op)) {
                    $dbSupported = true;
                }
            }
        }
        if ($dbRequired && !$dbSupported) {
            // the plugin requires a database, but this requirement is not fullfilled
            return false;
        }
    } else { // maybe it's a plugin with a legacy installer
        $q = DB_query("SELECT * FROM {$_TABLES['plugins']} WHERE pi_name = '{$pi_name}'");
        if (DB_numRows($q)) {
            $A = DB_fetchArray($q);
            $status = PLG_checkAvailable('geeklog', $A['pi_gl_version']);
            if ($status != 'ok') {
                return false;
            }
        }
    }

    return true;
}

/**
 * Returns the status of a plugin or false if unavailable
 *
 * @param    $pi_name                    string     The short name of the plugin to look for
 * @param    $version                    string     A version to ask for, the default operator is '>='
 * @param    $operator                   string     Optional operator to override the default
 *                                       See COM_versionCompare() for all valid operators
 * @return                    mixed      false is returned if the plugin is unavailable
 *                                       other possible values are: 'ok', 'disabled', 'uninstalled', 'wrong_version'
 * @since    Geeklog 1.8.0
 */
function PLG_checkAvailable($pi_name, $version, $operator = '>=')
{
    global $_PLUGINS, $_TABLES, $_CONF;

    // not really a plugin
    if ($pi_name === 'geeklog') {
        if (COM_VersionCompare(VERSION, $version, $operator)) { // use default operator
            return 'ok';
        } else {
            return false;
        }
    }

    // real plugins
    $q = DB_query("SELECT pi_version FROM {$_TABLES['plugins']} WHERE pi_name = '{$pi_name}'");
    $A = DB_fetchArray($q); // access database
    if (DB_numRows($q)) {
        // an enabled plugin
        if (in_array($pi_name, $_PLUGINS)) {
            if (COM_VersionCompare($A['pi_version'], $version, $operator)) {
                return 'ok';
            } else {
                return 'wrong_version';
            }
        }
        // a disabled plugin
        if (COM_VersionCompare($A['pi_version'], $version, $operator)) {
            return 'disabled';
        }
    }

    // an uninstalled plugin
    $file1 = $_CONF['path'] . 'plugins/' . $pi_name . '/autoinstall.php';
    $file2 = $_CONF['path'] . 'plugins/' . $pi_name . '/config.php';
    if (file_exists($file1) || file_exists($file2)) {
        return 'uninstalled';
    }

    // 'unavailable'
    return false;
}

/**
 * Returns true if the database server version matches the criteria and the required
 * file is available in the plugin, false otherwise.
 *
 * @param    $db                         string     The name of the dbms to check for
 * @param    $pi_name                    string     The short name of the plugin for which to check support
 * @param    $version                    string     A version to ask for, the default operator is '>='
 * @param    $operator                   string     Optional operator to override the default
 *                                       See COM_versionCompare() for all valid operators
 * @return                               bool
 * @since    Geeklog 1.8.0
 */
function PLG_checkAvailableDb($db, $pi_name, $version, $operator = '>=')
{
    global $_CONF;

    // check if the plugin supports the dbms
    $dbFile = $_CONF['path'] . 'plugins/' . $pi_name . '/sql/' . strtolower($db) . '_install.php';

    // if both requirements are satisfied, return true
    if (file_exists($dbFile) && COM_versionCompare(DB_getVersion(), $version, $operator)) {
        return true;
    }

    return false;
}

/**
 * Get list of install parameters for a plugin (including dependencies)
 * For plugins with new install this works like a charm. For the older plugins, not so much.
 *
 * @param    $pi_name         string     The short name of the plugin
 * @return                    array      An array containing the installation parameters of a plugin
 * @since    Geeklog 1.8.0
 */
function PLG_getParams($pi_name)
{
    global $_CONF, $LANG_ADMIN, $_DB_table_prefix;
    $retval = array();
    $file = $_CONF['path'] . 'plugins/' . COM_sanitizeFilename($pi_name) . '/autoinstall.php';
    if (file_exists($file)) {
        // new install system
        include_once $file;
        $function = 'plugin_autoinstall_' . $pi_name;
        if (function_exists($function)) {
            $retval = $function($pi_name);
        }
    } else {
        // old install system
        $file = $_CONF['path'] . 'plugins/' . COM_sanitizeFilename($pi_name) . '/config.php';
        if (file_exists($file)) {
            // find out what variables are included by $file
            $ar1 = get_defined_vars();
            include_once $file;
            $ar2 = get_defined_vars();
            $ar3 = array();
            foreach ($ar2 as $key => $value) {
                if (empty($ar1[$key]) && $key != '_TABLES' && $key != 'ar1' && $key != 'retval') {
                    $ar3[] = $ar2[$key];
                }
            }
            // some of these included variables could be pi_version and pi_gl_version
            foreach ($ar3 as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $rkey => $rvalue) {
                        switch ($rkey) {
                            case 'version':
                                $retval['info']['pi_version'] = $rvalue;
                                break;
                            case 'gl_version':
                                $retval['info']['pi_gl_version'] = $rvalue;
                                break;
                        }
                    }
                }
            }
        }
    }
    // If we have a geeklog version requirement...
    if (!empty($retval['info']['pi_gl_version'])) {
        // treat it like a requirement for a plugin and use the "new-style" dependency array
        $retval['requires'][] = array('core' => 'geeklog', 'version' => $retval['info']['pi_gl_version']);
    } else {
        // We need to initialise this index of the array, so we place a string in it.
        $retval['info']['pi_gl_version'] = $LANG_ADMIN['na'];
    }
    // If we don't know the plugin version
    if (empty($retval['info']['pi_version'])) {
        // We need to initialise this index of the array, so we place a string in it.
        $retval['info']['pi_version'] = $LANG_ADMIN['na'];
    }

    return $retval;
}

/**
 * This function is called from COM_createHTMLDocument and other places where meta tags
 * are being built and will return additional meta tags.
 *
 * @param    string $type   item type of the caller, e.g. 'article', 'staticpages'
 * @param    string $id     id of the current item of the caller
 * @param    array  $myTags meta tags the caller wants to add (optional)
 * @return   string         all meta tags
 * @since    Geeklog 2.1.0
 */
function PLG_getMetaTags($type, $id, array $myTags = array())
{
    global $_CONF, $_PLUGINS;

    $type = strtolower(trim($type));
    $id = trim($id);

    require_once $_CONF['path_system'] . 'classes/metatags.class.php';

    $charset = COM_getCharset();
    $htmlVersion = ($_CONF['doctype'] === 'xhtml5') ? 5 : 4;
    $isXhtml = (stripos($_CONF['doctype'], 'xhtml') === 0);

    $obj = new Metatags($charset, $htmlVersion, $isXhtml);
    //  $obj->setLog($_CONF['path'] . 'logs/error.log');

    // First, adds meta tags plugins want to add (the lowest priority)
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getmetatags_' . $pi_name;

        if (($type !== $pi_name) && function_exists($function)) {
            $metaTags = $function($type, $id);

            if (is_array($metaTags) && (count($metaTags) > 0)) {
                foreach ($metaTags as $tag) {
                    $obj->addTag($tag);
                }
            }
        }
    }

    // Then, adds meta tags the custom function wants to add
    $function = 'CUSTOM_getmetatags';

    if (function_exists($function)) {
        $metaTags = $function($type, $id);

        if (is_array($metaTags) && (count($metaTags) > 0)) {
            foreach ($metaTags as $tag) {
                $obj->addTag($tag);
            }
        }
    }

    // Finally, adds meta tags the caller itself wants to add (the highest priority)
    if (count($myTags) > 0) {
        foreach ($myTags as $tag) {
            $obj->addTag($tag);
        }
    }

    return $obj->build();
}

/**
 * Ask plugins for items they want to include in an XML site map
 *
 * @param    string $type                               plugin type (incl. 'article' for stories)
 * @param    int    $uid                                user ID or 0 = current user; should be 1 (= anonymous user) in
 *                                                      most cases
 * @param    int    $limit                              the max number of items to be returned (0 = no limit)
 * @return   array              array of array(
 *                                                      'url'           => the URL of an item (mandatory),
 *                                                      'date-modified' => the UNIX timestamp when an item was last
 *                                                      modified (optional)
 *                                                      'change-freq'   => one of 'always', 'hourly', 'daily',
 *                                                      'weekly',
 *                                                      'monthly', 'yearly', 'never' (optional)
 *                                                      'priority'      => a float value showing the priority of an
 *                                                      item, must be between 0.0 (lowest) and 1.0 (highest) (optional)
 *                                                      )
 * @since    Geeklog-2.1.1
 * @link     http://wiki.geeklog.net/index.php/PLG_getSitemapItems
 */
function PLG_collectSitemapItems($type, $uid = 1, $limit = 0)
{
    global $_CONF;

    if (($type === 'article') || ($type === 'story')) {
        require_once $_CONF['path_system'] . 'lib-article.php';
        $type = 'story';
    }

    $uid = intval($uid, 10);
    $limit = intval($limit, 10);
    $args = array(
        1 => $uid,
        2 => $limit,
    );

    if ($type === 'CUSTOM') {
        // Collect sitemap items from custom function
        $function = 'CUSTOM_collectSitemapItems';
    } else {
        // Collect sitemap items from a plugin
        $function = 'plugin_collectSitemapItems_' . $type;
    }

    $result = PLG_callFunctionForOnePlugin($function, $args);

    if (!is_array($result) || (count($result) === 0)) {
        $result = array();
    }

    return $result;
}

/**
 * Prepare a list of all plugins that a user has contributed content too.
 * If plugin finds content for user then should return text else then nothing.
 * Used by User Batch Admin to show in user list if user has contributed
 *
 * @param    int    $uid                                user ID
 *
 * @return   array   array of plugin names with text (can be empty)
 *
 * @since    Geeklog-2.2.1
 * @link     NA
 */
function PLG_userContributed($uid)
{
    global $_CONF, $_PLUGINS;

    require_once $_CONF['path_system'] . 'lib-article.php';
    require_once $_CONF['path_system'] . 'lib-comment.php';

    $retval = array();

    $pluginTypes = array_merge(array('article', 'comment'), $_PLUGINS);

    foreach ($pluginTypes as $pi_name) {
        $function = 'plugin_usercontributed_' . $pi_name;
        if (function_exists($function)) {
            $contributed = $function($uid);
            if (!empty($contributed)) {
                $retval[$pi_name] = $contributed;
            }
        }
    }

    return $retval;
}

/**
 * This function will return an array of language variable names and arrays that can
 * be over written by Geeklog using the Language Override Manager
 *
 * @return   array      will be used by language class
 * @since    Geeklog 2.2.1
 */
function PLG_getLanguageOverrides()
{
    global $_PLUGINS;

    $overrides = array();

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getlanguageoverrides_' . $pi_name;
        if (function_exists($function)) {
            $retarray = $function();
            if (is_array($retarray)) {
                $overrides = array_merge($overrides, $retarray);
            }
        }
    }

    $function = 'CUSTOM_getlanguageoverrides';
    if (function_exists($function)) {
        $retarray = $function();
        if (is_array($retarray)) {
            $overrides = array_merge($overrides, $retarray);
        }
    }

    return $overrides;
}

/**
* See if Likes system enabled for a plugin
*
* @param    string  $type           plugin name
* @param    string  $sub_type Sub   type of plugin to allow plugins to have likes for more than one type of item (not required)
* @return   int                     0 = disabled, 1 = Likes and Dislikes, 2 = Likes only
* @since    Geeklog 2.2.1
*
*/
function PLG_typeLikesEnabled($type, $sub_type)
{
    global $_CONF;

    $retval = false;

    // ensure that we're picking up the comment library as it is not always loaded
    if ($type == 'comment') {
        require_once $_CONF['path_system'] . 'lib-comment.php';
    }

    if ($_CONF['likes_enabled']) {
        $args[1] = $sub_type;
        $function = 'plugin_likesenabled_' . $type;

        $retval = PLG_callFunctionForOnePlugin($function,$args);
    }

    return $retval;
}

/**
 * Checks to see if user can perform a likes action on a item
 *
 * @param   string $type     Plugin for which like is for
 * @param   string $sub_type Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
 * @param   string $id       Item id for which like is for
 * @param   int    $uid      User id who is liking item
 * @param   int    $ip       ip who is liking item
 *
 * @return   bool
 * @since    Geeklog 2.2.1
 */
function PLG_canUserLike($type, $sub_type, $id, $uid, $ip)
{
   global $_CONF, $_TABLES;

    $retval = false;

    // Check user requirement
    if ( $_CONF['likes_enabled'] != 0 ) {
        if ( $_CONF['likes_enabled'] == 1 ) { // Means both actual user accounts and anonymous users
            $retval = true;
        } else if ( !COM_isAnonUser() ) {
            $retval = true;
        } else {
            $retval = false;
        }
    }

    if ( $retval == true ) {
        $args[1] = $sub_type;
        $args[2] = $id;
        $args[3] = $uid;
        $args[4] = $ip;
        $function = 'plugin_canuserlike_' . $type;

        $retval = PLG_callFunctionForOnePlugin($function,$args);
    }

    return $retval;
}

/**
* An item has had a likes action, allow plugin to update their records
*
* @param    string  $type       plugin name
* @param    string  $sub_type   Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param    string  $item_id    the id of the item with the like action
* @param    int     $action     the like action for the item. If LIKES_ACTION_NONE (0) then considered a delete
*
* @return   void
* @since    Geeklog 2.2.1
*
*/
function PLG_itemLike($type, $sub_type, $item_id, $action)
{
    $retval = true;

    $args[1] = $sub_type;
    $args[2] = $item_id;
    $args[3] = $action;
    $function = 'plugin_itemlikesaction_' . $type;

    $retval = PLG_callFunctionForOnePlugin($function,$args);

    return $retval;
}

/**
* Return URL of item Like is for
*
* @param    string  $type       plugin name
* @param    string  $sub_type   Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param    string  $item_id    the id of the item with the like action
*
* @return   void
* @since    Geeklog 2.2.1
*
*/
function PLG_getItemLikeURL($type, $sub_type, $item_id)
{
    $retval = true;

    $args[1] = $sub_type;
    $args[2] = $item_id;
    $function = 'plugin_getItemLikeURL_' . $type;

    $retval = PLG_callFunctionForOnePlugin($function,$args);

    return $retval;
}

/**
 * Ask plugins which reCAPTCHA version they support and what the id attribute of
 * the form is to which reCAPTCHA will be attached.
 *
 * @return  array of type => [
 *              'type'     => type               // required, passed as the 1st parameter to plugin_templatesetvars_xxx()
 *              'version'  => reCAPTCHA version, // required: RECAPTCHA_NO_SUPPORT(0), RECAPTCHA_SUPPORT_V2(1), RECAPTCHA_SUPPORT_V2_INVISIBLE(2)
 *              'form_id'  => form id,           // required only for reCAPTCHA V2 Invisible
 *              'plugin'   => plugin name,       // added by the function for debugging
 *           ]
 */
function PLG_collectRecaptchaInfo()
{
    global $_PLUGINS;
    static $retval = null;

    // Use cached info if available
    if ($retval !== null) {
        return $retval;
    }

    $retval = [];

    if (!in_array('recaptcha', $_PLUGINS)) {
        return $retval;
    }

    foreach ($_PLUGINS as $pluginName) {
        $function = 'plugin_supportsRecaptcha_' . $pluginName;
        if (!is_callable($function)) {
            continue;
        }

        $items = $function();
        if (empty($items) || !is_array($items)) {
            continue;
        }

        foreach ($items as $item) {
            // Type
            if (empty($item['type'])) {
                COM_errorLog(__METHOD__ . ': type was empty for "' . $pluginName . '".');
                continue;
            }

            // Check which reCAPTCHA version each plugin supports.  Valid values are:
            // RECAPTCHA_NO_SUPPORT(0), RECAPTCHA_SUPPORT_V2(1), RECAPTCHA_SUPPORT_V2_INVISIBLE(2)
            if (isset($item['version'])) {
                $item['version'] = (int) $item['version'];

                if (($item['version'] < RECAPTCHA_NO_SUPPORT) ||
                        ($item['version'] > RECAPTCHA_SUPPORT_V2_INVISIBLE)) {
                    COM_errorLog(__METHOD__ . ': bad reCAPTCHA version for "' . $pluginName . '".');
                    continue;
                }
            } else {
                COM_errorLog(__METHOD__ . ': no reCAPTCHA version was given for "' . $pluginName . '".');
                continue;
            }

            // Check for the id attribute of a form to which reCAPTCHA will be attached
            if (empty($item['form_id'])) {
                $item['form_id'] = '';

                // reCAPTCHA V2 Invisible requires a form id, but none was given
                if ($item['version'] == RECAPTCHA_SUPPORT_V2_INVISIBLE) {
                    COM_errorLog(__METHOD__ . ': form id was not given.  reCAPTCHA is disabled for "' . $pluginName . '".');
                    continue;
                }
            }

            // For debugging
            $item['plugin'] = $pluginName;

            if (isset($retval[$item['type']] )) {
                COM_errorLog(
                    sprintf(
                        '%s: type "%s" was duplicated for "%s" and "%s".',
                        __METHOD__, $item['type'], $item['plugin'], $retval[$item['type']]['plugin']
                    )
                );
                continue;
            }

            $retval[$item['type']] = $item;
        }
    }

    return $retval;
}

/**
 * Gives plugins a chance to specify their own Strutured Data Types
 *
 * @return   array   Returns Strutured Data Types from plugins
 */
function PLG_getStructuredDataTypes()
{
    global $_PLUGINS;

    $structureddatatypes = array();

    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_getstructureddatatypes_' . $pi_name;
        if (function_exists($function)) {
            $plugin_structureddatatypes = $function();
            if (is_array($plugin_structureddatatypes)) {
                $structureddatatypes = array_merge($structureddatatypes, $plugin_structureddatatypes);
            }
        }
    }

    return $structureddatatypes;
}
