<?php

/**
 * File: functions.inc
 * This is the functions.inc for the Geeklog Spam-X plugin
 *
 * Copyright (C) 2004-2008 by the following authors:
 * Authors      Tom Willett     tomw AT pigstye DOT net
 *              Dirk Haun       dirk AT haun-online DOT de
 *
 * Licensed under GNU General Public License
 *
 * $Id: functions.inc,v 1.31 2008/01/26 17:17:41 dhaun Exp $
 */

if (strpos($_SERVER['PHP_SELF'], 'functions.inc') !== false) {
    die ('This file can not be used on its own.');
}

/**
 * Language file include
 */
$plugin_path = $_CONF['path'] . 'plugins/spamx/';
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
    include_once $langfile;
} else {
    include_once $plugin_path . 'language/english.php';
}

/*
* As of Geeklog 1.5, the plugin's config.php is not needed any more and
* should be removed after upgrading.
*/
if (file_exists($plugin_path . 'config.php')) {
    include_once $plugin_path . 'config.php';
}

/*
* Check and see if we need to load the plugin configuration
*/
if (!isset($_SPX_CONF['timeout'])) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $sp_config = config::get_instance();
    $_SPX_CONF = $sp_config->get_config('spamx');
}

$_SPX_CONF['version'] = '1.1.1';

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
 * Shows the statistics for the plugin on stats.php.  If
 * $showsitestats is 1 then we are to only print the overall stats in the 'site
 * statistics' box otherwise we show the detailed stats for the plugin
 *
 * @param   int     $showsitestats  Flag to let us know which stats to get
 * @return  string  returns formatted HTML to insert in stats page
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
            array('label' => $LANG_SX00['stats_pblacklist'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'Personal'))),
            array('label' => $LANG_SX00['stats_ip'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'IP'))),
            array('label' => $LANG_SX00['stats_ipofurl'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'IPofUrl'))),
            array('label' => $LANG_SX00['stats_header'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'HTTPHeader'))),
            array('label' => $LANG_SX00['slvwhitelist'],
                'stats' => COM_numberFormat (DB_count ($_TABLES['spamx'], 'name', 'SLVwhitelist')))
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
function plugin_upgrade_spamx()
{
    global $_CONF, $_TABLES, $_SPX_CONF, $plugin_path;

    if (!function_exists('PLG_spamAction')) {
        return 3002; // plugin not compatible with this Geeklog version
    }

    $v = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'spamx'");

    if ($v != $_SPX_CONF['version']) {
        switch ($v) {
        case '1.0.1':
            // Add the counter
            DB_query("INSERT INTO {$_TABLES['vars']} VALUES ('spamx.counter', '0')");
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '1.1.0', pi_gl_version = '1.4.1' WHERE pi_name = 'spamx'");
            break;

        case '1.1.0':
            if (file_exists($plugin_path . 'config.php')) {
                require_once $_CONF['path_system'] . 'classes/config.class.php';

                $spx_config = config::get_instance();
                $spx_config->initConfig();
                if (!$spx_config->group_exists('spamx')) {
                    $enable_email = true;
                    if (empty($_SPX_CONF['notification_email']) || ($_SPX_CONF['notification_email'] == $_CONF['site_mail'])) {
                        $enable_email = false;
                    }

                    $spx_config->add('logging', $_SPX_CONF['logging'], 'select', 0, 0, 1, 10, true, 'spamx');
                    $spx_config->add('admin_override', $_SPX_CONF['admin_override'], 'select', 0, 0, 1, 20, true, 'spamx');
                    $spx_config->add('timeout', $_SPX_CONF['timeout'], 'text', 0, 0, null, 30, true, 'spamx');
                    $spx_config->add('notification_email', $_SPX_CONF['notification_email'], 'text', 0, 0, null, 40, $enable_email, 'spamx');
                    $spx_config->add('action', $_SPX_CONF['action'], 'text', 0, 0, null, 50, false, 'spamx');

                    // rename plugin's config.php as it's not needed any more
                    $ret = @rename($plugin_path . 'config.php',
                                   $plugin_path . 'config-pre1.1.1.php');
                    if (!ret) {
                        COM_errorLog("Spam-X upgrade failed - unable to rename plugin's config.php to complete upgrade");
                        return 3002;
                    } elseif ($spx_config->group_exists('spamx')) {
                        DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_SPX_CONF['version']}', pi_gl_version = '1.5.0' WHERE pi_name = 'spamx'");
                    } else {
                        COM_errorLog("Spam-X upgrade failed.");
                        return 3002;
                    }
                }
            } else {
                COM_errorLog("Spam-X upgrade failed - did not find plugin's config.php");
                return 3002;
            }
            break;
        }

        // update version numbers

        // check if version number was updated successfully
        $v = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'spamx'");
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
 * Check a post for spam
 *
 * @param   string  $comment    comment text
 * @param   int     $action     (former spam action - not used any more)
 * @return  int                 > 0: spam detected, == 0: no spam
 *
 */
function plugin_checkforSpam_spamx ($comment, $action = -1)
{
    global $_CONF, $_SPX_CONF;

    // skip spam check for members of the 'spamx Admin' group, if enabled
    if (isset ($_SPX_CONF['admin_override']) && $_SPX_CONF['admin_override']) {
        if (SEC_inGroup ('spamx Admin')) {
            return 0;
        }
    }

    $spamx_path = $_CONF['path'] . 'plugins/spamx/';

    // Set up Spamx_Examine array
    $Spamx_Examine = array ();
    if ($dir = @opendir ($spamx_path)) {
        while (($file = readdir ($dir)) !== false) {
            if (is_file ($spamx_path . $file)) {
                if (substr ($file, -18) == '.Examine.class.php') {
                    $sfile = str_replace ('.Examine.class.php', '', $file);
                    $Spamx_Examine[] = $sfile;
                }
            }
        }
        closedir ($dir);
    }

    $res = 0;
    foreach ($Spamx_Examine as $Examine) {
        $filename = $Examine . '.Examine.class.php';
        require_once ($spamx_path . $filename);
        $EX = new $Examine;
        $res = $EX->execute ($comment);
        if ($res == 1) {
            break;
        }
    }

    return $res;
}

/**
 * Perform action after spam has been detected
 *
 * @param   string  $comment    comment text
 * @param   int     $action     which action modules to call (sum of module numbers)
 * @return  int                 number of message to display to the spammer
 *
 */
function plugin_spamaction_spamx ($comment, $action)
{
    global $_CONF, $_SPX_CONF;

    $res = 0;

    $spamx_path = $_CONF['path'] . 'plugins/spamx/';

    if (($action == -1) || ($action == '')) {
        $action = $_SPX_CONF['action'];
    }

    // Set up Spamx_Action array
    $Spamx_Action = array ();
    if ($dir = @opendir ($spamx_path)) {
        while (($file = readdir ($dir)) !== false) {
            if (is_file ($spamx_path . $file)) {
                if (substr ($file, -17) == '.Action.class.php') {
                    $sfile = str_replace ('.Action.class.php', '', $file);
                    require_once ($spamx_path . $file);
                    $CM = new $sfile;
                    $Spamx_Action[$sfile] = $CM->number ();
                }
            }
        }
        closedir ($dir);
    }

    foreach ($Spamx_Action as $Act => $Num) {
        if (($action & $Num) == $Num) {
            $AC = new $Act;
            $AC->execute ($comment);

            $res = max ($res, $AC->result ());
        }
    }

    return $res;
}

/**
 * Logs message to spamx.log
 *
 * This will print a message to the spamx log
 *
 * @param   string  $logentry   Message to write to log
 */
function SPAMX_log ($logentry)
{
    global $_CONF, $LANG01, $_SPX_CONF;

    if ((!isset ($_SPX_CONF['logging']) || ($_SPX_CONF['logging'] === true)) &&
            !empty ($logentry)) {
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
* Automatic uninstall function for plugins
*
* @return   array
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
*/
function plugin_autouninstall_spamx ()
{
    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array('spamx'),
        /* give the full name of the group, as in the db */
        'groups' => array('spamx Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('spamx.admin', 'spamx.view'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array(),
        /* give all vars with their name */
        'vars' => array('spamx_gid', 'spamx.counter')
    );

    return $out;
}

?>
