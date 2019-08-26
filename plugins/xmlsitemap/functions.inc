<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 2.0                                                     |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the XMLSitemap |
// | Plugin's PHP files.                                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2014 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
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

/**
* Implementation of the Plugin API for the XMLSitemap plugin
*
* @package XMLSitemap
*/

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die ('This file can not be used on its own.');
}

// Language file Include
$langfile = $_CONF['path'] . 'plugins/xmlsitemap/language/' . $_CONF['language'] . '.php';
clearstatcache();

if (file_exists($langfile)) {
    include_once $langfile;
} else {
    include_once $_CONF['path'] . 'plugins/xmlsitemap/language/english.php';
}

Language::override(array(
    'LANG_XMLSMAP',
));

// Load the plugin configuration
$_XMLSMAP_CONF = XMLSMAP_loadConfig();

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Return the version for this plugin
*
* @return string VersionNo
*/
function plugin_chkVersion_xmlsitemap()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/xmlsitemap/autoinstall.php';

    $inst_parms = plugin_autoinstall_xmlsitemap('xmlsitemap');

    return $inst_parms['info']['pi_version'];
}

/**
* Upgrade the plugin
*
* @return   boolean true (= success)
*/
function plugin_upgrade_xmlsitemap()
{
    global $_CONF, $_TABLES, $_DB_dbms, $_XMLSMAP_DEFAULT;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                    "pi_name = 'xmlsitemap'");
    $code_version = plugin_chkVersion_xmlsitemap();

    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/xmlsitemap/autoinstall.php';

    if (! plugin_compatible_with_this_version_xmlsitemap('xmlsitemap')) {
        return 3002;
    }
    
    // Retrieve other plugin info like min geeklog version and homepage 
    $inst_parms = plugin_autoinstall_xmlsitemap('xmlsitemap');        

    require_once $_CONF['path'] . 'plugins/xmlsitemap/sql/' . $_DB_dbms . '_updates.php';
    require_once $_CONF['path'] . 'plugins/xmlsitemap/install_updates.php';

    $current_version = $installed_version;
    $done = false;

    while (! $done) {
        switch ($current_version) {
        case '1.0.0':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }

            xmlsitemap_update_ConfValues_1_0_0();
            xmlsitemap_update_ConfigSecurity_1_0_0();

            $current_version = '1.0.1';
            break;

        case '1.0.1':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }
            xmlsitemap_update_ConfValues_1_0_1();
            xmlsitemap_update_ConfigSecurity_1_0_1();

            $current_version = '2.0.0';
            break;
            
        case '2.0.0':
            // Only code changes

            $current_version = '2.0.1';
            break;  

        case '2.0.1':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }        
            xmlsitemap_update_ConfValues_2_0_1();

            $current_version = '2.0.2';
            break;             

        default:
            $done = true;
            break;
        }
    }

    // update plugin version number and other info
    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '{$inst_parms['info']['pi_gl_version']}', pi_homepage = '{$inst_parms['info']['pi_homepage']}' WHERE pi_name = 'xmlsitemap'");
    
    COM_errorLog( "Updated xmlsitemap plugin from v$installed_version to v$code_version", 1 );    

    return true;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*/
function plugin_autouninstall_xmlsitemap()
{
    global $_XMLSMAP_CONF;

    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array(),
        /* give the full name of the group, as in the db */
        'groups' => array('XMLSitemap Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('config.xmlsitemap.tab_main',
                            'config.xmlsitemap.tab_pri',
                            'config.xmlsitemap.tab_freq',
                            'config.xmlsitemap.tab_ping'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array(),
        /* give all vars with their name */
        'vars' => array('xmlsitemap_filename', 'xmlsitemap_mobile', 'xmlsitemap_news', 'xmlsitemap.pings'),
    );

    XMLSITEMAP_removeSitemapFiles();

    return $out;
}

/**
* Loads config infor with config.class.php
*
* @return   mixed   XMLSitemap config array or false
*/
function XMLSMAP_loadConfig()
{
    global $_CONF;

    $config = config::get_instance();
    if ($config->group_exists('xmlsitemap')) {
        return $config->get_config('xmlsitemap');
    } else {
        return false;
    }
}

/**
* Return a string escaped for HTML output
*
* Escapes special characters so $str can be used in XML
*
* @param    string  $str    string to encode
* @return   string          encoded string
*/
function XMLSMAP_esc($str)
{
    static $encoding = null;

    if ($encoding === null) {
        $encoding = COM_getCharset();;
    }

    $str = str_replace(
        array('&lt;', '&gt;', '&amp;', '&quot;', '&#039;'),
        array(   '<',    '>',     '&',      '"',      "'"),
        $str
    );

    return htmlspecialchars($str, ENT_QUOTES, $encoding);
}

/**
* Create XML sitemap(s) or update existing one(s)
*
* @param    string  $type       plugin name
* @param    string  $include    plugin to add after install/enabled
* @param    string  $exclude    plugin to remove after uninstall/disabled
* @return   boolean             true = success, false = otherwise
*/
function XMLSMAP_update($type = null, $include = null, $exclude = null)
{
    global $_CONF, $_XMLSMAP_CONF;

    if (($type !== null) && !in_array($type, $_XMLSMAP_CONF['types'])) {
        // Notified about content change, but from an irrelevant plugin, one
        // that doesn't implement 'plugin_getiteminfo_xxx' function.
        return true;
    }

    if (($type !== null) && in_array($type, $_XMLSMAP_CONF['exclude'])) {
        // plugin is on our exclude list, so ignore
        return true;
    }

    require_once $_CONF['path'] . 'plugins/xmlsitemap/xmlsitemap.class.php';

    $charset = COM_getCharset();
    $sitemap = new SitemapXML($charset);

    // Set sitemap file names
    $sitemap_file = isset($_XMLSMAP_CONF['sitemap_file']) ? $_XMLSMAP_CONF['sitemap_file']                      : '';
    $mobile_sitemap_file = isset($_XMLSMAP_CONF['mobile_sitemap_file']) ? $_XMLSMAP_CONF['mobile_sitemap_file'] : '';
    $news_sitemap_file = isset($_XMLSMAP_CONF['news_sitemap_file']) ? $_XMLSMAP_CONF['news_sitemap_file']       : '';
    $sitemap->setFileNames(
        $sitemap_file,
        $mobile_sitemap_file,
        $news_sitemap_file
    );

    // Set types
    $types = array_diff($_XMLSMAP_CONF['types'], $_XMLSMAP_CONF['exclude']);
    if ($include !== null) {
        if (($index = array_search($exclude, $types)) === false) {
            $types[] = $include;
        }
    }
    if ($exclude !== null) {
        if (($index = array_search($exclude, $types)) !== false) {
            unset($types[$index]);
        }
    }

    $sitemap->setTypes($types);

    // Set priorities
    foreach ($_XMLSMAP_CONF['priorities'] as $type => $pri) {
        $sitemap->setPriority($type, $pri);
    }

    // Set update frequencies
    foreach ($_XMLSMAP_CONF['frequencies'] as $type => $freq) {
        $sitemap->setChangeFreq($type, $freq);
    }

    // News Sitemap settings
    if (isset($_XMLSMAP_CONF['news_sitemap_file']) && !empty($_XMLSMAP_CONF['news_sitemap_file'])) {
        // Article topics to include
        if (isset($_XMLSMAP_CONF['news_sitemap_topics']) && $_XMLSMAP_CONF['news_sitemap_topics']) {
            $sitemap->setNewsTopics($_XMLSMAP_CONF['news_sitemap_topics']);
        }
        // Max article age in seconds
        if (isset($_XMLSMAP_CONF['news_sitemap_age']) && $_XMLSMAP_CONF['news_sitemap_age']) {
            $sitemap->setNewsAge($_XMLSMAP_CONF['news_sitemap_age']);
        }
    }

    $retval = $sitemap->create();

    // Send ping to search engines
    $pingTargets = array();

    if (isset($_XMLSMAP_CONF['ping_google']) && $_XMLSMAP_CONF['ping_google']) {
        $pingTargets[] = 'google';
    }

    if (isset($_XMLSMAP_CONF['ping_bing']) && $_XMLSMAP_CONF['ping_bing']) {
        $pingTargets[] = 'bing';
    }

    if (!COM_isDemoMode()) {
        if (count($pingTargets) > 0) {
            $sitemap->sendPing($pingTargets);
        }
    }

    return $retval;
}

/**
* Callback function when an item was saved
*
* @param    string  $id     (unused) ID of item being saved
* @param    string  $type   type of item ('article', 'staticpages', ...)
* @param    string  $old_id (unused) previous ID of item, if != $id
* @return   void
* @see      PLG_itemSaved
*/
function plugin_itemsaved_xmlsitemap($id, $type, $old_id)
{
    XMLSMAP_update($type);
}

/**
* Callback function when an item was deleted
*
* @param    string  $id     (unused) ID of item being deleted
* @param    string  $type   type of item ('article', 'staticpages', ...)
* @return   void
* @see      PLG_itemDeleted
*/
function plugin_itemdeleted_xmlsitemap($id, $type)
{
    global $_XMLSMAP_CONF;

    // we're really only interested in Topic Deletes because of the News Sitemap
    if ($type == 'topic') {
        $key = array_search($id, $_XMLSMAP_CONF['news_sitemap_topics']);

        if ($key > 0) {
            // delete item from config
            unset($_XMLSMAP_CONF['news_sitemap_topics'][$key]);

            // Now save it to the configuration
            $c = config::get_instance();
            $c->set('news_sitemap_topics', $_XMLSMAP_CONF['news_sitemap_topics'], 'xmlsitemap');
        }
    }
    
    // Rewrite all sitmap files
    XMLSMAP_update($type);
}

/**
* Callback function when this plugin is being enabled/disabled
*
* @param    boolean $enable     true: we're being enabled, false: disabled
* @return   void
* @see      PLG_enableStateChange
*/
function plugin_enablestatechange_xmlsitemap($enable)
{
    global $_CONF, $_XMLSMAP_CONF;

    if ($enable) {
        /**
        * At this time, $_XMLSMAP_CONF is visible only in
        * PLG_enableStateChange().  So we have to reload them from DB.
        */
        $_XMLSMAP_CONF = XMLSMAP_loadConfig();

        XMLSMAP_update();
    } else {
        XMLSITEMAP_removeSitemapFiles();
    }
}

/**
* Check if changed types, priorities, or frequencies are valid
*
* @param  string    $name   either 'types', 'priorities' or 'frequencies'
* @return void
*/
function XMLSITEMAP_checkChange($name)
{
    global $_CONF, $_PLUGINS, $_TABLES, $_XMLSMAP_CONF;

    if (!in_array($name, array('types', 'priorities', 'frequencies')) ||
            (count($_XMLSMAP_CONF[$name]) === 0)) {
        return;
    }

    $enabled_plugins = $_PLUGINS;
    $enabled_plugins[] = 'article';
    $valids = array();

    // Check and add a valid value to $valids
    foreach ($_XMLSMAP_CONF[$name] as $key => $value) {
        switch ($name) {
            case 'types':
                if (in_array($value, $enabled_plugins)) {
                    $valids[] = $value;
                }
                break;

            case 'priorities':
                if (!is_numeric($key) && in_array($key, $enabled_plugins)) {
                    $value = (float) $value;

                    if (($value < 0.0) || ($value > 1.0)) {
                        $value = 0.5;
                    }

                     $valids[$key] = $value;
                }
                break;

            case 'frequencies':
                $value = strtolower(trim($value));
                $valid_change_freqs = array('always', 'hourly', 'daily',
                        'weekly', 'monthly', 'yearly', 'never', 'hidden');

                if (!is_numeric($key) && in_array($key, $enabled_plugins)
                        && in_array($value, $valid_change_freqs)) {
                    $valids[$key] = $value;
                }
                break;

            default:
                trigger_error('XMLSITEMAP_checkChange: "' . $name
                              . '" not implemented');
                break;
        }
    }

    ksort($_XMLSMAP_CONF[$name]);
    ksort($valids);

    // If $valids is different from the current value, we have to update config
    if ($_XMLSMAP_CONF[$name] != $valids) {
        $_XMLSMAP_CONF[$name] = $valids;
        $config = config::get_instance();
        $config->set($name, $valids, 'xmlsitemap');
    }

    if ($name == 'types') {
        /**
        * The list of plugins in the sitemap changed. Make sure we have
        * priorities and frequencies for all active plugins and remove
        * those for inactive plugins.
        */
        $priorities  = array();
        $frequencies = array();

        foreach ($enabled_plugins as $plugin) {
            if (in_array($plugin, $_XMLSMAP_CONF['types'])) {
                // plugin is active: ensure we have prio. + freq. entries
                if (isset($_XMLSMAP_CONF['priorities'][$plugin])) {
                    $priorities[$plugin] = $_XMLSMAP_CONF['priorities'][$plugin];
                } else {
                    $priorities[$plugin] = 0.5;
                }
                if (isset($_XMLSMAP_CONF['frequencies'][$plugin])) {
                    $frequencies[$plugin] = $_XMLSMAP_CONF['frequencies'][$plugin];
                } else {
                    $frequencies[$plugin] = 'daily';
                }
            }
        }

        $config = config::get_instance();
        ksort($priorities);
        $config->set('priorities',  $priorities, 'xmlsitemap');
        ksort($frequencies);
        $config->set('frequencies', $frequencies, 'xmlsitemap');
    }
}

/**
* Delete an old sitemap file and update $_TABLES['vars']
*
* @param  string    $key        config key
* @param  string    $varname    name field of $_TABLES['vars']
* @return void
*/
function XMLSITEMAP_changeFile($key, $varname)
{
    global $_CONF, $_TABLES, $_XMLSMAP_CONF;

    $old_file = basename(DB_getItem($_TABLES['vars'], 'value', "name= '{$varname}'"));

    if ($old_file != '') {
        $old_file = $_CONF['path_html'] . $old_file;
        clearstatcache();

        if (file_exists($old_file)) {
            if (!@unlink($old_file)) {
                COM_errorLog('Xmlsitemap: cannot delete a sitemap: ' . $old_file);
            }
        }
    }

    if (isset($_XMLSMAP_CONF[$key])) { // need to check incase enabling or not
        $_XMLSMAP_CONF[$key] = basename(trim($_XMLSMAP_CONF[$key]));
        $sql = "UPDATE {$_TABLES['vars']} "
             . "SET value = '" . DB_escapeString($_XMLSMAP_CONF[$key]) . "' "
             . "WHERE (name = '{$varname}') ";
        DB_query($sql);
    }
}

/**
* Callback function when configuration was changed
*
* @param    string  $group      'Core' or 'xmlsitemap'
* @param    array   $changes    array of strings: config var key
* @return   void
* @see      PLG_configChange
*/
function plugin_configchange_xmlsitemap($group, $changes = array())
{
    global $_XMLSMAP_CONF;

    $need_update = false;

    if ($group == 'xmlsitemap') {
        if (is_array($changes) && (count($changes) > 0)) {
            /**
            * At this time, changes in configuration is not reflected in
            * $_XMLSMAP_CONF yet.  So we have to reload them from DB.
            */
            $_XMLSMAP_CONF = XMLSMAP_loadConfig();

            foreach ($changes as $name) {
                if ($name == 'sitemap_file') {
                    XMLSITEMAP_changeFile($name, 'xmlsitemap_filename');
                } elseif ($name == 'mobile_sitemap_file') {
                    XMLSITEMAP_changeFile($name, 'xmlsitemap_mobile');
                } elseif ($name == 'news_sitemap_file') {
                    XMLSITEMAP_changeFile($name, 'xmlsitemap_news');
                    
                } elseif ($name != 'exclude') {
                    XMLSITEMAP_checkChange($name);
                }
            }

            $need_update = true;
        }
    } else {
        if (in_array($group, $_XMLSMAP_CONF['types'])) {
            $need_update = true;
        }
    }

    if ($need_update) {
        XMLSMAP_update();
    }
}

/**
* Callback function when another plugin was installed/uninstalled/upgarded/
* enabled/disabled
*
* @param    string  $type   plugin name
* @param    string  $status 'installed', 'uninstalled', 'upgraded', 'enabled',
*                           or 'disabled'
* @return   void
* @see      PLG_pluginStateChange
*/
function plugin_pluginstatechange_xmlsitemap($type, $status)
{
    global $_CONF, $_XMLSMAP_CONF;

    $need_update = false;
    $include     = null;
    $exclude     = null;

    switch ($status) {
        case 'installed':
            if (is_callable('plugin_getiteminfo_' . $type) &&
                    !in_array($type, $_XMLSMAP_CONF['exclude'])) {
                // A new plugin supporting plugin_getiteminfo_xxx() was
                // installed
                $_XMLSMAP_CONF['types'][]            = $type;
                $_XMLSMAP_CONF['priorities'][$type]  = 0.5;
                $_XMLSMAP_CONF['frequencies'][$type] = 'daily';

                $config = config::get_instance();
                $config->set('types', $_XMLSMAP_CONF['types'], 'xmlsitemap');
                $config->set('priorities', $_XMLSMAP_CONF['priorities'], 'xmlsitemap');
                $config->set('frequencies', $_XMLSMAP_CONF['frequencies'], 'xmlsitemap');
                $need_update = true;
            }

            break;

        case 'uninstalled':
            if (($pos = array_search($type, $_XMLSMAP_CONF['types'])) !== false) {

                // A plugin supporting plugin_getiteminfo_xxx() was uninstalled.
                unset($_XMLSMAP_CONF['types'][$pos]);
                unset($_XMLSMAP_CONF['priorities'][$type]);
                unset($_XMLSMAP_CONF['frequencies'][$type]);

                $config = config::get_instance();
                $config->set('types', $_XMLSMAP_CONF['types'], 'xmlsitemap');
                $config->set('priorities', $_XMLSMAP_CONF['priorities'], 'xmlsitemap');
                $config->set('frequencies', $_XMLSMAP_CONF['frequencies'], 'xmlsitemap');
                $need_update = true;
            }
            break;

        case 'upgraded':
            // Probably we don't have to handle this.
            break;

        case 'enabled':
        case 'disabled':
            /**
            * Here change in plugin state is not reflected in $_PLUGINS yet.
            * So we have to handle this case in a peculiar way
            */
            if (in_array($type, $_XMLSMAP_CONF['types'])) {
                if ($status == 'enabled') {
                    $include = $type;
                } elseif ($status == 'disabled') {
                    $exclude = $type;
                }

                // A plugin supporting plugin_getiteminfo_xxx() was
                // enabled/disabled.
                $need_update = true;
            }
            break;
    }

    if ($need_update) {
        XMLSMAP_update(null, $include, $exclude);
    }
}

/**
* Provide URL of a documentation file
*
* @param    string  $file   documentation file being requested, e.g. 'config'
* @return   mixed           URL or false when not available
*
*/
function plugin_getdocumentationurl_xmlsitemap($file)
{
    static $docUrl;

    switch ($file) {
    case 'index':
    case 'config':
        if (isset($docUrl)) {
            $retval = $docUrl;
        } else {
            $retval = COM_getDocumentUrl('docs', 'xmlsitemap.html');
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
* @param    string  $id     Id of config value
* @return   mixed           Text to use regular tooltip, NULL to use config
*                           tooltip hack, or empty string when not available
*
*/
function plugin_getconfigtooltip_xmlsitemap($id)
{
    // Use config tooltip hack where tooltip is read from the config documentation
    return;
}

/**
* Remove the sitemap file(s)
*
* @return void
*/
function XMLSITEMAP_removeSitemapFiles()
{
    global $_CONF, $_XMLSMAP_CONF;

    $filenames = array('sitemap_file', 'mobile_sitemap_file', 'news_sitemap_file');

    foreach ($filenames as $filename) {
        if (! empty($_XMLSMAP_CONF[$filename])) {
            $sitemap = $_CONF['path_html'] . $_XMLSMAP_CONF[$filename];
            if (file_exists($sitemap)) {
                if (! @unlink($sitemap)) {
                    COM_errorLog('XMLSitemap: cannot delete a sitemap: '
                                 . $sitemap);
                }
            }
        }
    }
}
