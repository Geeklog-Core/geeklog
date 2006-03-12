<?php

/**
 * File: functions.inc
 * This is the functions.inc for the Geeklog Spam-X Plug-in!
 * 
 * Copyright (C) 2004-2006 by the following authors:
 * Authors      Tom Willett     tomw AT pigstye DOT net
 *              Dirk Haun       dirk AT haun-online DOT de
 * 
 * Licensed under GNU General Public License
 *
 * $Id: functions.inc,v 1.21 2006/03/12 09:02:06 dhaun Exp $
 */

/**
 * Language file Include
 */
$langfile = $_CONF['path'] . 'plugins/spamx/language/' . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    include_once ($langfile);
} else {
    include_once ($_CONF['path'] . 'plugins/spamx/language/english.php');
} 

/*
* Include spamx config files
*/
require_once ($_CONF['path'] . 'plugins/spamx/config.php');

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
 * Shows the statistics for the plugin on stats.php.  If
 * $showsitestats is 1 then we are to only print the overall stats in the 'site
 * statistics' box otherwise we show the detailed stats for the plugin
 * 
 * Universal Plugin:  Modify/uncomment use it
 * 
 * @param int $ showsitestate   Flag to let us know which stats to get
 * @return string returns formatted HTML to insert in stats page
 */
function plugin_showstats_spamx($showsitestats)
{
    global $_CONF, $_TABLES, $LANG_SX00;
    $retval = '';

    if (SEC_hasRights('spamx.admin')) {
        // detailed stats are only visible to Spam-X admins
        require_once( $_CONF['path_system'] . 'lib-admin.php' );
        $header_arr = array(
            array('text' => $LANG_SX00['stats_page_title'], 'field' => 'label', 'header_class' => 'stats-header-title'),
            array('text' => $LANG_SX00['stats_entries'], 'field' => 'stats', 'header_class' => 'stats-header-count', 'field_class' => 'stats-list-count'),
        );
        $data_arr = array();
        $text_arr = array('has_menu'     => false,
                          'title'        => $LANG_SX00['stats_headline'],
        );
        $data_arr = array(
            array('label' => $LANG_SX00['stats_mtblacklist'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'MTBlacklist'))),
            array('label' => $LANG_SX00['stats_pblacklist'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'Personal'))),
            array('label' => $LANG_SX00['stats_ip'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'IP'))),
            array('label' => $LANG_SX00['stats_ipofurl'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'IPofUrl'))),
            array('label' => $LANG_SX00['stats_header'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'HTTPHeader')))
        );
        $retval .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);
    }

    return $retval;
}

/**
* New stats plugin API function for proper integration with the site stats
* 
* @return   array(item text, item count);
* 
*/
function plugin_statssummary_spamx ()
{
    global $_TABLES, $LANG_SX00;

    $counter = DB_getItem ($_TABLES['vars'], 'value', "name = 'spamx.counter'");

    return array ($LANG_SX00['stats_deleted'], COM_numberFormat ($counter));
}

/**
 * This will put an option for the plugin in the command and control block on moderation.php
 * 
 * Add the plugin name, icon and link to the command and control block in moderation.php
 * 
 * @return array Array containing (plugin name, admin url, url of plugin icon)
 */
function plugin_cclabel_spamx()
{
    global $_CONF, $LANG_SX00;

    $retval = array();
    if (SEC_hasRights('spamx.admin')) {
        $retval = array($LANG_SX00['plugin_name'],
            $_CONF['site_admin_url'] . '/plugins/spamx/index.php',
            plugin_geticon_spamx ());
    } 

    return $retval;
} 

/**
 * Returns the administrative option for this plugin
 * 
 * Adds the plugin to the Admin menu
 * 
 * Universal Plugin:  Modify/Uncomment use it
 * 
 * @return array Array containing (plugin name, plugin admin url, # of items in plugin or '')
 */
function plugin_getadminoption_spamx()
{
    global $_CONF, $LANG_SX00;

    if (SEC_hasRights('spamx.admin')) {
        return array($LANG_SX00['plugin_name'],
            $_CONF['site_admin_url'] . '/plugins/spamx/index.php', 0);
    } 
}

/**
 * Returns the current plugin code version
 * 
 * @return string    plugin version
 */
function plugin_chkVersion_spamx ()
{
    global $_SPX_CONF;

    return $_SPX_CONF['version'];
}

/**
* Update the Spam-X plugin
*
* @return   int     Number of message to display
*
*/
function plugin_upgrade_spamx ()
{
    global $_TABLES, $_SPX_CONF;

    $v = DB_getItem ($_TABLES['plugins'], 'pi_version', "pi_name = 'spamx'");

    if ($v != $_SPX_CONF['version']) {
        switch ($v) {
            case '1.0.1':
                // Add the counter
                DB_query ("INSERT INTO {$_TABLES['vars']} VALUES ('spamx.counter', '0')");
                break;
        }

        // update version number
        DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_SPX_CONF['version']}' WHERE pi_name = 'spamx'");

        // check if version number was updated successfully
        $v = DB_getItem ($_TABLES['plugins'], 'pi_version', "pi_name = 'spamx'");
    }

    if ($v == $_SPX_CONF['version']) {
        return 3001;
    }

    return 3002;
}

/**
 * Actual Plugin Functions here.
 */

/**
 * Called by the Plugin API PLG_checkforSpam
 * param string $comment  comment text
 * param int    $action   which action modules to call if spam found (sum of module numbers)
 */

function plugin_checkforSpam_spamx($comment, $action)
{
    global $_CONF, $_TABLES, $_SPX_CONF; 

    // skip spam check for members of the 'spamx Admin' group, if enabled
    if (isset ($_SPX_CONF['admin_override']) && $_SPX_CONF['admin_override']) {
        if (SEC_inGroup ('spamx Admin')) {
            return 0;
        }
    }

    // Set up Spamx_Action and Spamx_Examine arrays
    $Spamx_Action = array();
    $Spamx_Examine = array();
    if ($dir = @opendir($_CONF['path'] . 'plugins/spamx/')) {
        while (($file = readdir($dir)) !== false) {
            if (is_file($_CONF['path'] . 'plugins/spamx/' . $file)) {
                if (substr($file, -17) == '.Action.class.php') {
                    $sfile = str_replace('.Action.class.php', '', $file);
                    require_once ($_CONF['path'] . 'plugins/spamx/' . $file);
                    $CM = new $sfile;
                    $Spamx_Action[$CM->number()] = $sfile;
                }
                if (substr($file, -18) == '.Examine.class.php') {
                    $sfile = str_replace('.Examine.class.php', '', $file);
                    $Spamx_Examine[] = $sfile;
                }
            }
        }
        closedir($dir);
    }
    $res = 0;
    foreach ($Spamx_Examine as $Examine) {
        $filename = $Examine . '.Examine.class.php';
        require_once $_CONF['path'] . 'plugins/spamx/' . $filename;
        $EX = new $Examine;
        $res = $EX->execute($comment);
        if ($res == 1) {
            break;
        }
    }

    if ($res == 1) { // Examine Class found a match - spam detected
        if ($action == -1 or $action == '') {
            $action = $_SPX_CONF['action'];
        }
        foreach($Spamx_Action as $Num => $Act) {
            if (($action & $Num) == $Num) {
                $filename = $Act . '.Action.class.php';
                require_once($_CONF['path'] . 'plugins/spamx/' . $filename);
                $AC = new $Act;
                $AC->execute($comment);
            }
        }

        return $AC->result();
    }

    return $res;
}

/**
 * Logs message to spamx.log
 * 
 * This will print a message to the spamx log
 * 
 * @logentry string      $string         Message to write to log
 */

$_SPAMX_log_flg = true; // Set to false to turn of logging

function SPAMX_log ($logentry)
{
    global $_CONF, $LANG01, $_SPAMX_log_flg;

    if ($_SPAMX_log_flg && !empty ($logentry)) {
        $logentry = str_replace( array( '<?', '?>' ), array( '(@', '@)' ),
                                 $logentry );

        $timestamp = strftime ('%c');
        $logfile = $_CONF['path_log'] . 'spamx.log';

        if (!$file = fopen ($logfile, 'a')) {
            COM_errorLog ($LANG01[33] . $logfile . ' (' . $timestamp . ')', 1);
        } 

        fputs ($file, "$timestamp - $logentry \n");
    } 
} 

/**
* Returns the URL of the plugin's icon
*
* @return   string      URL of the icon
*
*/
function plugin_geticon_spamx ()
{
    global $_CONF;

    return $_CONF['site_admin_url'] . '/plugins/spamx/images/spamx.png';
}

/**
 * Removes the datastructures for this plugin from the Geeklog database.
 * This routine will get called from the Plugin install program if user select De-Install or if Delete is used in the Plugin Editor.
 * The Plugin Installer will also call this routine upon and install error to remove anything it has created.
 * The Plugin installer will pass the optional parameter which will then double check that plugin has first been disabled. 
 * 
 * For this plugin, this routine will also remove the Block definition.
 * 
 * Returns True if all Plugin related data is removed without error
 * 
 * @param string $installCheck Defult is blank but if set, check if plugin is disabled first
 * @return boolean True if successful false otherwise
 */
function plugin_uninstall_spamx($installCheck = '')
{
    global $_TABLES, $LANG_SX00;

    $pi_name = 'spamx';
    $FEATURES = array ('spamx.admin', 'spamx.view');
    $admin_group = 'spamx Admin'; 
    // Check and see if plugin is still enabled - if so display warning and exit
    if ($installCheck != '' && DB_getItem($_TABLES['plugins'], 'pi_enabled', 'pi_name = "' . $pi_name . '"')) {
        COM_errorLog("Plugin is installed and enabled. Disable first if you want to de-install it", 1);
        $display .= COM_startBlock($LANG_SX00['warning']);
        $display .= $LANG_SX00['enabled'];
        $display .= COM_endBlock();
        echo $display;
        return false;
        exit;
    } 
    // Ok to proceed and delete plugin
    // Unregister the plugin with Geeklog
    COM_errorLog('Attempting to unregister the spamx plugin from Geeklog', 1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'spamx'", 1); 
    // Remove Security for this plugin
    $grp_id = DB_getItem ($_TABLES['groups'], 'grp_id', "grp_name = '{$admin_group}'");

    COM_errorLog("Removing $pi_name Admin Group", 1);
    DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id", 1);
    DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = '{$pi_name}_gid'");
    DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = 'spamx.counter'");
    COM_errorLog("Removing root users from admin of $pi_name");
    DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id", 1); 
    // Remove all the associated features -- access rights
    foreach ($FEATURES as $feature) {
        COM_errorLog("Removing $feature feature and rights to it", 1);
        $feat_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$feature'");
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id", 1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $feat_id", 1);
    } 

    COM_errorLog ('Dropping ' . $_TABLES['spamx'] . ' table.', 1);
    DB_query ("DROP TABLE {$_TABLES['spamx']}", 1);

    COM_errorLog('...success', 1);
    return true;
} 

?>
