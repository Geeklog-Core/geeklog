<?php

// +---------------------------------------------------------------------------+
// | Spam-X Plugin 1.3                                                         |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tom Willett       - tomw AT pigstye DOT net                      |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die ('This file can not be used on its own.');
}

// Language file include
$plugin_path = $_CONF['path'] . 'plugins/spamx/';
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
    include_once $langfile;
} else {
    include_once $plugin_path . 'language/english.php';
}

Language::override(array(
    'LANG_SX00', 'PLG_spamx_MESSAGE128', 'PLG_spamx_MESSAGE8',
));

// Check and see if we need to load the plugin configuration
if (!isset($_SPX_CONF['timeout'])) {
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
 * @param   int    $showSiteStats Flag to let us know which stats to get
 * @return  string                returns formatted HTML to insert in stats page
 * @see     plugin_statssummary_spamx
 */
function plugin_showstats_spamx($showSiteStats)
{
    global $_CONF, $_TABLES, $LANG_SX00;

    $retval = '';

    if (SEC_hasRights('spamx.admin')) {
        // detailed stats are only visible to Spam-X admins
        require_once($_CONF['path_system'] . 'lib-admin.php');
        $header_arr = array(
            array(
                'text' => $LANG_SX00['stats_page_title'],
                'field' => 'label',
                'header_class' => 'stats-header-title'
            ),
            array(
                'text' => $LANG_SX00['stats_entries'],
                'field' => 'stats',
                'header_class' => 'stats-header-count',
                'field_class' => 'stats-list-count'
            ),
        );
        $data_arr = array();
        $text_arr = array(
            'has_menu' => false,
            'title'    => $LANG_SX00['stats_headline'],
            'form_url' => $_CONF['site_url'] . '/stats.php',
        );
        $data_arr = array(
            array(
                'label' => $LANG_SX00['stats_pblacklist'],
                'stats' => COM_numberFormat(DB_count($_TABLES['spamx'], 'name', 'Personal')),
            ),
            array(
                'label' => $LANG_SX00['stats_ip'],
                'stats' => COM_numberFormat(DB_count($_TABLES['spamx'], 'name', 'IP')),
            ),
            array(
                'label' => $LANG_SX00['stats_ipofurl'],
                'stats' => COM_numberFormat(DB_count($_TABLES['spamx'], 'name', 'IPofUrl')),
            ),
            array(
                'label' => $LANG_SX00['stats_header'],
                'stats' => COM_numberFormat(DB_count($_TABLES['spamx'], 'name', 'HTTPHeader')),
            ),
            array(
                'label' => $LANG_SX00['slvwhitelist'],
                'stats' => COM_numberFormat(DB_count($_TABLES['spamx'], 'name', 'SLVwhitelist')),
            ),
        );
        $retval .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);
    }

    return $retval;
}

/**
 * New stats plugin API function for proper integration with the site stats
 *
 * @return array(item text, item count);
 * @see     plugin_showstats_spamx
 */
function plugin_statssummary_spamx()
{
    global $_TABLES, $LANG_SX00;

    $counter = DB_getItem($_TABLES['vars'], 'value', "name = 'spamx.counter'");

    return array($LANG_SX00['stats_deleted'], COM_numberFormat($counter));
}

/**
 * This will put an option for the plugin in the command and control block on moderation.php
 * Add the plugin name, icon and link to the command and control block in moderation.php
 *
 * @return array Array containing (plugin name, admin url, url of plugin icon)
 */
function plugin_cclabel_spamx()
{
    global $_CONF, $LANG_SX00;

    $retval = array();
    if (SEC_hasRights('spamx.admin')) {
        $retval = array(
            $LANG_SX00['plugin_name'],
            $_CONF['site_admin_url'] . '/plugins/spamx/index.php',
            plugin_geticon_spamx(), 'tools'
        );
    }

    return $retval;
}

/**
 * Returns the administrative option for this plugin
 * Adds the plugin to the Admin menu
 *
 * @return array Array containing (plugin name, plugin admin url, # of items in plugin or '')
 */
function plugin_getadminoption_spamx()
{
    global $_CONF, $LANG_SX00, $_TABLES;

    if (SEC_hasRights('spamx.admin')) {
        $result = DB_query("SELECT count(*) AS cnt FROM {$_TABLES['spamx']}");
        $A = DB_fetchArray($result);
        $count = $A['cnt'];

        return array($LANG_SX00['plugin_name'], $_CONF['site_admin_url'] . '/plugins/spamx/index.php', $count, 'tools');
    } else {
        return array();
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
 */
function plugin_upgrade_spamx()
{
    global $_CONF, $_TABLES, $_DB_dbms;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'spamx'");
    $code_version = plugin_chkVersion_spamx();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/spamx/autoinstall.php';

    if (!plugin_compatible_with_this_version_spamx('spamx')) {
        return 3002;
    }

    $inst_parms = plugin_autoinstall_spamx('spamx');

    require_once $_CONF['path'] . 'plugins/spamx/sql/' . $_DB_dbms . '_updates.php';
    require_once $_CONF['path'] . 'plugins/spamx/install_updates.php';

    $current_version = $installed_version;
    $done = false;
    $current_config = false;

    while (!$done) {
        switch ($current_version) {
            case '1.1.0':
                $plugin_path = $_CONF['path'] . 'plugins/spamx/';
                require_once $plugin_path . 'install_defaults.php';

                if (file_exists($plugin_path . 'config.php')) {
                    global $_DB_table_prefix, $_SPX_CONF;

                    require_once $plugin_path . 'config.php';
                }

                if (!plugin_initconfig_spamx()) {
                    echo 'There was an error upgrading the Spam-X plugin';

                    return false;
                }
                $current_config = true;

                $current_version = '1.1.1';
                break;

            case '1.1.1':
                // no db changes
                $current_version = '1.1.2';
                break;

            case '1.1.2':
                // no db changes
                $current_version = '1.2.0';
                break;

            case '1.2.0':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                if (!$current_config) {
                    // Remove admin override since not needed anymore
                    $c = config::get_instance();
                    $c->del('admin_override', 'spamx');

                    // late fix: ensure 'notification_email' option can be disabled
                    $result = DB_query("SELECT value, default_value FROM {$_TABLES['conf_values']} WHERE name = 'notification_email' AND group_name = 'spamx'");
                    list($value, $default_value) = DB_fetchArray($result);
                    if ($value != 'unset') {
                        if (substr($default_value, 0, 6) != 'unset:') {
                            $unset = DB_escapeString('unset:' . $default_value);
                            DB_query("UPDATE {$_TABLES['conf_values']} SET default_value = '$unset' WHERE name = 'notification_email' AND group_name = 'spamx'");
                        }
                    }
                }

                $current_version = '1.2.1';
                break;

            case '1.2.1':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                if (!$current_config) {
                    spamx_update_ConfValues_1_2_1();
                }

                spamx_update_ConfigSecurity_1_2_1();

                $current_version = '1.2.2';
                break;

            case '1.2.2':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                if (!$current_config) {
                    // Update to Config Tables must be performed here and not in regular SQL update array since if config is current then they shouldn't be run
                    // Set new Tab column to whatever fieldset is
                    $sql = "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'spamx'";
                    DB_query($sql);

                    // Rename the action config option since it is causes JavaScript issues in the config and IE 8
                    $sql = "UPDATE {$_TABLES['conf_values']} SET name = 'spamx_action' WHERE name = 'action' AND group_name = 'spamx'";
                    DB_query($sql);

                    // in an earlier update we accidentally renamed the 'action' option to 'spamx_name' - fix that
                    $sql = "UPDATE {$_TABLES['conf_values']} SET name = 'spamx_action' WHERE name = 'spamx_name' AND group_name = 'spamx'";
                    DB_query($sql);

                    spamx_update_ConfValues_1_2_2();
                }

                spamx_update_ConfigSecurity_1_2_2();

                $current_version = '1.3.0';
                break;

            case '1.3.0':   // Shipped with Geeklog-2.0.0
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                spamx_update_ConfValues_1_3_0();

                $current_version = '1.3.1';
                break;

            case '1.3.1':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }
                
                $current_version = '1.3.2'; // Shipped with Geeklog-2.1.1
                break;

            case '1.3.2':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                } 
                
                $current_version = '1.3.3'; // Shipped with Geeklog-2.1.2
                break;
                
            case '1.3.3':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }            
            
                $current_version = '1.3.4'; // Shipped with Geeklog-2.1.3
                break;

            case '1.3.4':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                spamx_update_ConfValues_1_3_4();

                $current_version = '1.3.5'; // Shipped with Geeklog-2.2.0
                break;

            default:
                $done = true;
        }
    }

    // update plugin version number and other info
    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '{$inst_parms['info']['pi_gl_version']}', pi_homepage = '{$inst_parms['info']['pi_homepage']}' WHERE pi_name = 'spamx'");

    COM_errorLog( "Updated spamx plugin from v$installed_version to v$code_version", 1 );      

    return true;
}

/**
 * Called during site migration - handle changed URLs or paths
 *
 * @param  array $old_conf contents of the $_CONF array on the old site
 * @return boolean         true on success, otherwise false
 */
function plugin_migrate_spamx($old_conf)
{
    global $_CONF, $_TABLES;

    // only update the SLV whitelist, so we don't use Installer::updateSiteUrl
    $old_url = DB_escapeString($old_conf['site_url']);
    $result = DB_query("SELECT name, value FROM {$_TABLES['spamx']} WHERE name = 'SLVwhitelist' AND value LIKE '{$old_url}%'");
    $num = DB_numRows($result);

    for ($i = 0; $i < $num; $i++) {
        list($name, $value) = DB_fetchArray($result);
        $new_value = DB_escapeString(str_replace($old_conf['site_url'], $_CONF['site_url'], $value));
        $old_value = DB_escapeString($value);

        DB_query("UPDATE {$_TABLES['spamx']} SET value = '$new_value' WHERE name = 'SLVwhitelist' AND value = '$old_value'");
    }

    COM_errorLog('Successfully migrated the "spamx" plugin');

    return true;
}

/**
 * Actual Plugin Functions here.
 */

/**
 * Check a post for spam
 *
 * @param  string $comment comment text
 * @param  int    $action  (former spam action - not used any more)
 * @param  string $permanentLink (since GL 2.2.0)
 * @param  string $commentType (since GL 2.2.0)
 * @param  string $commentAuthor (since GL 2.2.0)
 * @param  string $commentAuthorEmail (since GL 2.2.0)
 * @param  string $commentAuthorURL (since GL 2.2.0)
 * @return int    either PLG_SPAM_NOT_FOUND, PLG_SPAM_FOUND or PLG_SPAM_UNSURE
 * @note As for valid value for $commentType, see system/classes/Akismet.php
 */
function plugin_checkforSpam_spamx($comment, $action, $permanentLink,
                                   $commentType = Geeklog\Akismet::COMMENT_TYPE_COMMENT,
                                   $commentAuthor = null, $commentAuthorEmail = null, $commentAuthorURL = null)
{
    global $_CONF, $_SPX_CONF, $_TABLES;

    // skip spam check for members of a group that has the spamx.skip right.
    if (SEC_hasRights('spamx.skip')) {
        return PLG_SPAM_NOT_FOUND;
    }


    if (!isset($_SPX_CONF['max_age'])) {
        $_SPX_CONF['max_age'] = 0;
    }

    // Clear out any old records
    $deleteList = '';
    if (is_array($_SPX_CONF['records_delete'])) {
        foreach ($_SPX_CONF['records_delete'] as $record) {
            if (!empty($record)) {
                $record = DB_escapeString($record);
                if ($deleteList == '') {
                    $deleteList = "'$record'";
                } else {
                    $deleteList .= ", '$record'";
                }
            }
        }
    }
    if ($_SPX_CONF['max_age'] > 1 && $deleteList != '') {
        $timestamp = DB_escapeString(date('Y-m-d'));
        $sql = "DELETE FROM {$_TABLES['spamx']}
            WHERE DATE_ADD(regdate,INTERVAL {$_SPX_CONF['max_age']} DAY) < '$timestamp'
            AND name IN ($deleteList)";
        DB_query($sql);
    }

    $spamx_path = $_CONF['path'] . 'plugins/spamx/';

    // Set up SpamxExaminer array
    $spamxExaminerSources = array();
    if ($dir = @opendir($spamx_path)) {
        while (($file = readdir($dir)) !== false) {
            if (is_file($spamx_path . $file)) {
                if ((strpos($file, 'SLV.') !== 0) &&
                    (substr($file, -18) === '.Examine.class.php')) {
                    $sourceFile = str_replace('.Examine.class.php', '', $file);
                    $spamxExaminerSources[] = $sourceFile;
                }
            }
        }
        closedir($dir);
    }

    // Sort the files. IP Class needs to execute before Stop Forum Spam class yo save on calls to stopforumspam.com
    asort($spamxExaminerSources);
    $answer = PLG_SPAM_NOT_FOUND;

    foreach ($spamxExaminerSources as $spamxExaminerSource) {
        $filename = $spamxExaminerSource . '.Examine.class.php';
        require_once $spamx_path . $filename;

        $examiner = new $spamxExaminerSource;
        $answer = $examiner->execute(
            $comment, $permanentLink, $commentType, $commentAuthor, $commentAuthorEmail, $commentAuthorURL
        );

        if ($answer != PLG_SPAM_NOT_FOUND) {
            break;
        }
    }

    return $answer;
}

/**
 * Perform action after spam has been detected
 *
 * @param   string $comment comment text
 * @param   int    $action  which action modules to call (sum of module numbers)
 * @return  int                 number of message to display to the spammer
 */
function plugin_spamaction_spamx($comment, $action)
{
    global $_CONF, $_SPX_CONF;

    $res = PLG_SPAM_NOT_FOUND;

    $spamx_path = $_CONF['path'] . 'plugins/spamx/';

    if (($action == -1) || ($action == '')) {
        $action = $_SPX_CONF['spamx_action'];
    }

    // Set up Spamx_Action array
    $Spamx_Action = array();
    if ($dir = @opendir($spamx_path)) {
        while (($file = readdir($dir)) !== false) {
            if (is_file($spamx_path . $file)) {
                if (substr($file, -17) == '.Action.class.php') {
                    $sfile = str_replace('.Action.class.php', '', $file);
                    require_once $spamx_path . $file;
                    $CM = new $sfile;
                    $Spamx_Action[$sfile] = $CM->getActionCode();
                }
            }
        }
        closedir($dir);
    }

    foreach ($Spamx_Action as $Act => $actionCode) {
        if (($action & $actionCode) == $actionCode) {
            $AC = new $Act;
            $AC->execute($comment);
            $res = max($res, $AC->getResult());
        }
    }

    return $res;
}

/**
 * Logs message to spamx.log
 * This will print a message to the spamx log
 *
 * @param   string $logEntry Message to write to log
 */
function SPAMX_log($logEntry)
{
    global $_CONF, $LANG01, $_SPX_CONF;

    if ((!isset($_SPX_CONF['logging']) || ($_SPX_CONF['logging'] === true)) && !empty($logEntry)) {
        $logEntry = str_replace(array('<?', '?>'), array('(@', '@)'), $logEntry);
        $timestamp = strftime('%c');
        $logfile = $_CONF['path_log'] . 'spamx.log';

        if (!$file = fopen($logfile, 'a')) {
            COM_errorLog($LANG01[33] . $logfile . ' (' . $timestamp . ')', 1);
        }

        fputs($file, "$timestamp - $logEntry \n");
        fclose($file);
    }
}

/**
 * Returns the URL of the plugin's icon
 *
 * @return   string      URL of the icon
 */
function plugin_geticon_spamx()
{
    global $_CONF;

    return $_CONF['site_admin_url'] . '/plugins/spamx/images/spamx.png';
}

/**
 * Automatic uninstall function for plugins
 * This code is automatically uninstalling the plugin.
 * It passes an array to the core code function that removes
 * tables, groups, features and php blocks from the tables.
 * Additionally, this code can perform special actions that cannot be
 * foreseen by the core code (interactions with other plugins for example)
 *
 * @return   array   Plugin information
 */
function plugin_autouninstall_spamx()
{
    $out = array(
        /* give the name of the tables, without $_TABLES[] */
        'tables'     => array('spamx'),
        /* give the full name of the group, as in the db */
        'groups'     => array('spamx Admin'),
        /* give the full name of the feature, as in the db */
        'features'   => array('spamx.admin',
            'spamx.view',
            'spamx.skip',
            'config.spamx.tab_main'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array(),
        /* give all vars with their name */
        'vars'       => array('spamx_gid', 'spamx.counter'),
    );

    return $out;
}

/**
 * Provide URL of a documentation file
 *
 * @param    string $file documentation file being requested, e.g. 'config'
 * @return   mixed           URL or false when not available
 */
function plugin_getdocumentationurl_spamx($file)
{
    static $docUrl;

    switch ($file) {
        case 'index':
        case 'config':
            if (isset($docUrl)) {
                $retval = $docUrl;
            } else {
                $retval = COM_getDocumentUrl('docs', 'spamx.html');
                $docUrl = $retval;
            }
            break;

        default:
            $retval = false;
            break;
    }

    return $retval;
}

/**
 * Provides text for a Configuration tooltip
 *
 * @param    string $id      Id of config value
 * @return   mixed           Text to use regular tooltip, NULL to use config
 *                           tooltip hack, or empty string when not available
 */
function plugin_getconfigtooltip_spamx($id)
{
    // Use config tooltip hack where tooltip is read from the config documentation
    return;
}

/**
 * Checks user registrations against stopforumspam.com to validate email and IP addresses
 *
 * @param    string $type     Type of item
 * @param    string $username Type of item
 * @return   string
 */
function plugin_itemPreSave_spamx($type, $username)
{
    global $_CONF, $LANG_SX00;

    if ($type == 'registration') {
        require_once $_CONF['path'] . '/plugins/spamx/SFS.Misc.class.php';
        $EX = new SFS;
        $res = $EX->execute(null, null, Geeklog\Akismet::COMMENT_TYPE_COMMENT, null, Geeklog\Input::post('email'));
        if ($res > 0) {
            return $LANG_SX00['invalid_email_or_ip'];
        }
    }

    return '';
}

/**
 * Lets Geeklog know the names of language variables and arrays that can be overridden if need be
 *
 * @return   array
 */
function plugin_getlanguageoverrides_spamx()
{

    return array('LANG_SX00', 'PLG_spamx_MESSAGE128', 'PLG_spamx_MESSAGE8');
}

/**
 * Public APIs to provide the information the Spam-X has stored or to manipulate the data it has
 *
 * @since v2.2.0
 */

/**
 * @param  string $ipToCheck (IPv4 or IPv6)
 * @return bool
 */
function SPAMX_isIPBanned($ipToCheck)
{
    global $_TABLES;

    $ipToCheck = trim($ipToCheck);
    $ipToCheck = strtolower($ipToCheck);

    if ($ipToCheck !== '') {
        $sql = "SELECT value FROM {$_TABLES['spamx']} WHERE (name = 'IP')";
        $result = DB_query($sql);

        if (!DB_error()) {
            while (($A = DB_fetchArray($result, false)) !== false) {
                $target = strtolower($A['value']);

                if (strpos($target, '/') !== false) {
                    $check = Geeklog\IP::matchCIDR($ipToCheck, $target);
                } elseif (strpos($target, '-') !== false) {
                    $check = Geeklog\IP::matchRange($ipToCheck, $target);
                } else {
                    $target = '/' . preg_quote($target, '/') . '/';
                    $check = (preg_match($target, $ipToCheck) == 1);
                }

                if ($check) {
                    return true;
                }
            }
        }
    }

    return false;
}

/**
 * Return an array of banned IPs
 *
 * @return array of string representing an IP
 */
function SPAMX_getBannedIPs()
{
    global $_TABLES;

    $retval = array();
    $sql = "SELECT value FROM {$_TABLES['spamx']} WHERE name = 'IP'";
    $result = DB_query($sql);

    if (!DB_error()) {
        while (($A = DB_fetchArray($result, false)) !== false) {
            $retval[] = $A['value'];
        }
    }

    return $retval;
}

/**
 * Register or update banned IPs
 *
 * @param  string|array $ips
 */
function SPAMX_registerBannedIPs($ips)
{
    global $_TABLES;

    $ips = (array) $ips;

    foreach ($ips as $ip) {
        $ip = trim($ip);

        if ($ip !== '') {
            $ip = DB_escapeString($ip);

            if (DB_count($_TABLES['spamx'], array('name', 'value'), array('IP', $ip)) == 1) {
                // The IP given already exists
                $sql = "UPDATE {$_TABLES['spamx']} SET counter = counter + 1 "
                    . "WHERE (name = 'IP') AND (value = '{$ip}')";
            } else {
                // The IP given not found
                $timestamp = DB_escapeString(date('Y-m-d H:i:s'));
                $sql = "INSERT INTO {$_TABLES['spamx']} (name, value, counter, regdate) "
                    . "VALUES('IP', '{$ip}', 1, '{$timestamp}')";
            }

            DB_query($sql);
        }
    }
}

/**
 * Delete IPs from the database
 *
 * @param  string|array $ips
 */
function SPAMX_deleteBannedIPs($ips)
{
    global $_TABLES;

    $ips = (array) $ips;

    foreach ($ips as $ip) {
        $ip = trim($ip);

        if ($ip !== '') {
            $ip = DB_escapeString($ip);
            $sql = "DELETE FROM {$_TABLES['spamx']} WHERE (name = 'IP') AND (value = '{$ip}') LIMIT 1";
            DB_query($sql);
        }
    }
}
