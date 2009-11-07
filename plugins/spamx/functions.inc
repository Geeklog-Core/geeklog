<?php

/**
 * File: functions.inc
 * This is the functions.inc for the Geeklog Spam-X plugin
 *
 * Copyright (C) 2004-2009 by the following authors:
 * Authors      Tom Willett     tomw AT pigstye DOT net
 *              Dirk Haun       dirk AT haun-online DOT de
 *
 * Licensed under GNU General Public License
 *
 * @package Spam-X
 */

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
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

/**
* Check and see if we need to load the plugin configuration
*/
if (!isset($_SPX_CONF['timeout'])) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $spx_config = config::get_instance();
    $_SPX_CONF = $spx_config->get_config('spamx');
}


// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Shows the statistics for the plugin on stats.php.  If $showsitestats is 1
* then we are to only print the overall stats in the 'site statistics' box
* otherwise we show the detailed stats for the plugin
*
* @param    int     $showsitestats  Flag to let us know which stats to get
* @return   string  returns formatted HTML to insert in stats page
* @see      plugin_statssummary_spamx
*
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
* @see      plugin_showstats_spamx
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
            $_CONF['site_admin_url'] . '/plugins/spamx/index.php', '');
    }
}

/**
 * Returns the current plugin code version
 *
 * @return string    plugin version
 */
function plugin_chkVersion_spamx()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/spamx/autoinstall.php';          

    $inst_parms = plugin_autoinstall_spamx('spamx'); 

    return $inst_parms['info']['pi_version'];
}

/**
* Update the Spam-X plugin
*
* @return   int     Number of message to display
*
*/
function plugin_upgrade_spamx()
{
    global $_CONF, $_TABLES;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                    "pi_name = 'spamx'");
    $code_version = plugin_chkVersion_spamx();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/spamx/autoinstall.php';

    if (! plugin_compatible_with_this_version_spamx('spamx')) {
        return 3002;
    }

    $inst_parms = plugin_autoinstall_spamx('spamx');
    $pi_gl_version = $inst_parms['info']['pi_gl_version'];

    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '$pi_gl_version' WHERE pi_name = 'spamx'");

    return true;
}

/**
* Called during site migration - handle changed URLs or paths
*
* @param    array   $old_conf   contents of the $_CONF array on the old site
* @param    boolean             true on success, otherwise false
*
*/
function plugin_migrate_spamx($old_conf)
{
    global $_CONF, $_TABLES;

    // only update the SLV whitelist, so we don't use INST_updateSiteUrl
    $old_url = addslashes($old_conf['site_url']);
    $result = DB_query("SELECT name, value FROM {$_TABLES['spamx']} WHERE name = 'SLVwhitelist' AND value LIKE '{$old_url}%'");
    $num = DB_numRows($result);

    for ($i = 0; $i < $num; $i++) {
        list($name, $value) = DB_fetchArray($result);
        $new_value = addslashes(str_replace($old_conf['site_url'],
                                            $_CONF['site_url'], $value));
        $old_value = addslashes($value);

        DB_query("UPDATE {$_TABLES['spamx']} SET value = '$new_value' WHERE name = 'SLVwhitelist' AND value = '$old_value'");
    }

    return true;
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
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
* @return   array   Plugin information
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

/**
* Provide URL of a documentation file
*
* @param    string  $file   documentation file being requested, e.g. 'config'
* @return   mixed           URL or false when not available
*
*/
function plugin_getdocumentationurl_spamx($file)
{
    global $_CONF;

    static $docurl;

    switch ($file) {
    case 'index':
    case 'config':
        if (isset($docurl)) {
            $retval = $docurl;
        } else {
            $doclang = COM_getLanguageName();
            $docs = 'docs/' . $doclang . '/spamx.html';
            if (file_exists($_CONF['path_html'] . $docs)) {
                $retval = $_CONF['site_url'] . '/' . $docs;
            } else {
                $retval = $_CONF['site_url'] . '/docs/english/spamx.html';
            }
            $docurl = $retval;
        }
        break;

    default:
        $retval = false;
        break;
    }

    return $retval;
}

?>
