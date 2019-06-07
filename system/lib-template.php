<?php
// +--------------------------------------------------------------------------+
// | Geeklog 2.0                                                              |
// +--------------------------------------------------------------------------+
// | lib-template.php                                                         |
// |                                                                          |
// | Geeklog Caching Template Library (CTL)                                   |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2008-2009 by the following authors:                        |
// |                                                                          |
// | Mark R. Evans          mark AT glfusion DOT org                          |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | This program is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU General Public License              |
// | as published by the Free Software Foundation; either version 2           |
// | of the License, or (at your option) any later version.                   |
// |                                                                          |
// | This program is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with this program; if not, write to the Free Software Foundation,  |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.          |
// |                                                                          |
// +--------------------------------------------------------------------------+

// this file can't be used on its own
if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

/**
 * Returns possible theme template directories.
 *
 * @param    string or array    $root Path to template root. 
                                If Root is string then assumes it is a call from Geeklog Core or older plugin that does not use CTL_plugin_templatePath
                                If Root is an array assume plugin supports CTL_plugin_templatePath
 * @return   array              Theme template directories
 */
function CTL_setTemplateRoot($root)
{
    global $_CONF;
    
    COM_deprecatedLog(__FUNCTION__, '2.2.0', '3.0.0', 'CTL_core_templatePath. Setting template class directly has been depreciated. See COM_newTemplate, CTL_core_templatePath, and CTL_plugin_templatePath for more info.');

    $retval = array();

    if (!is_array($root)) {
        // If here either Geeklog Core Template or Old way for plugins before using CTL_plugin_templatePath
        // Lets add any additional root directories we need then
        $root = array($root);

        foreach ($root as $r) {
            if (substr($r, -1) == '/') {
                $r = substr($r, 0, -1);
            }
            /* REMOVED as not sure purpose and mangles correct directories with "plugins" in the directory path
            if (strpos($r, "plugins") != 0) {
                $p = str_replace($_CONF['path'], $_CONF['path_themes'] . $_CONF['theme'] . '/', $r);
                $x = str_replace("/templates", "", $p);
                $retval[] = $x;
            }
            */
            if ($r != '') {
                // $retval[] = $r . '/custom'; NEVER HEARD OF THIS BEING USED SO REMOVING as of Geeklog v2.2.0
                $retval[] = $r;
                if (!empty($_CONF['theme_default'])) {
                    // This line should only get added for Geeklog Core but it gets added for plugins that don't pass in an array. Not much we can do about this...
                    $retval[] = $_CONF['path_themes'] . $_CONF['theme_default'] . '/' .
                        substr($r, strlen($_CONF['path_layout']));
                }
            }
        }
    } else {
        // Array so must be plugin which supports multiple locations for template files
        // So just pass through since it already contains all locations
        $retval = $root;
    }
    
    return $retval;
}

/**
 * Clear cache directories recursively
 *
 * @param  string $path
 * @param  string $needle
 */
function CTL_clearCacheDirectories($path, $needle = '')
{
    $path = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;

    if ($dir = @opendir($path)) {
        while ($entry = readdir($dir)) {
            if ($entry === '.' || $entry === '..' || is_link($entry) || $entry === '.svn' || $entry === 'index.html') {
                continue;
            } elseif (is_dir($path . $entry)) {
                CTL_clearCacheDirectories($path . $entry, $needle);
                @rmdir($path . $entry);
            } elseif (empty($needle) || strpos($entry, $needle) !== false) {
                @unlink($path . $entry);
            }
        }

        @closedir($dir);
    }
}

/**
 * Clear cached data
 *
 * @param string $plugin
 */
function CTL_clearCache($plugin = '')
{
    global $_CONF;

    if (!empty($plugin)) {
        $plugin = '__' . $plugin . '__';
    }

    CTL_clearCacheDirectories($_CONF['path_data'] . 'layout_cache/', $plugin);
    CTL_clearCacheDirectories($_CONF['path_data'] . 'layout_css/', $plugin);
}

/**
 * Returns possible theme template directories for Core only (not any plugins, see CTL_plugin_templatePath).
 *
 * @since  v2.2.0 
 * @param    string or array    $root Path to template root. 
 * @return   array              Theme template directories
 */
function CTL_core_templatePath($root)
{
    global $_CONF;

    $retval = array();

    if (!is_array($root)) {
        $root = array($root);
    }

    foreach ($root as $r) {
        if (substr($r, -1) == '/') {
            $r = substr($r, 0, -1);
        }

        if ($r != '') {
            // $retval[] = $r . '/custom'; NEVER HEARD OF THIS BEING USED SO REMOVING as of Geeklog v2.2.0
            $retval[] = $r;
            if (!empty($_CONF['theme_default'])) {
                $retval[] = $_CONF['path_themes'] . $_CONF['theme_default'] . '/' . substr($r, strlen($_CONF['path_layout']));
            }
        }
    }
    
    return $retval;
}

/**
 * Get path for the plugin template files.
 *
 * @param  string   $plugin
 * @param    string $path subdirectory within the base template path
 * @return   array           full path to possible template directories
 */
function CTL_plugin_templatePath($plugin, $path = '')
{
    global $_CONF;

    // Needs to be in this order as this is the order that will be checked by the caching template library

    $retval = array();

    $subdir = !empty($path) ? '/' . $path : '';

    // See if plugin templates exist in current theme
    $retval[] = "{$_CONF['path_layout']}{$plugin}{$subdir}";

    // Now Check to see if default theme exists, if so add it to the mix
    $retval[] = "{$_CONF['path_layout_default']}{$plugin}{$subdir}";

    // See if current theme templates stored with plugin
    $layout_path = "{$_CONF['path']}plugins/$plugin/templates/{$_CONF['theme']}$subdir";
    if (is_dir($layout_path)) {
        $retval[] = $layout_path;
    }

    // Check to see if compatible theme templates specified in theme's functions.php
    if (!empty($_CONF['theme_plugins'])) {
        $layout_path = "{$_CONF['path']}plugins/$plugin/templates/{$_CONF['theme_plugins']}$subdir";
        if (is_dir($layout_path)) {
            $retval[] = $layout_path;
        }
    }

    // Now Check to see if default theme exists for templates stored with plugin
    if (!empty($_CONF['theme_default'])) {
        $layout_path = "{$_CONF['path']}plugins/$plugin/templates/{$_CONF['theme_default']}$subdir";
        if (is_dir($layout_path)) {
            $retval[] = $layout_path;
        }
    }

    // Use default templates then
    $layout_path = "{$_CONF['path']}plugins/$plugin/templates/default$subdir";

    $retval[] = $layout_path;

    return $retval;
}

/**
 * Get HTML path for a plugin file (url or physical file location).
 * Usually used to find .css, .js files needed by plugin 
 * Order of checking is:
 * - theme path/plugin/file
 * - html path/plugin/directory/file
 * - html path/plugin/directory/theme_plugins/file - ie $_CONF['theme_plugins']
 * - html path/plugin/directory/theme/file
 * - html path/plugin/directory/theme_default/file * if default theme exists
 * - html path/plugin/directory/default/file
 * - html path/plugin/file (url path only)
 * - plugin path/plugin/directory/theme_plugins/file (physical path only) - ie $_CONF['theme_plugins']
 * - plugin path/plugin/directory/theme/file (physical path only) - ie $_CONF['theme']
 * - plugin path/plugin/directory/theme_default/file (physical path only) * if default theme exists - ie $_CONF['theme_default']
 * - plugin path/plugin/directory/default/file (physical path only)
 *
 * @param    string  $plugin            name of plugin
 * @param    string  $directory         name of directory
 * @param    string  $filename          name of file
 * @param    boolean $return_url        return url path or file path
 * @param    boolean $include_filename  if true returns path with filename, false returns jsut path
 * @return   string              full HTML path to file
 */
function CTL_plugin_themeFindFile($plugin, $directory, $filename, $return_url = true, $include_filename = true)
{
    global $_CONF;

    $retval = "";

    // See if plugin file exist in current theme
    $file = "{$_CONF['path_layout']}$plugin/$filename";
    if (file_exists($file)) {
        if ($return_url) {
            $retval = "{$_CONF['layout_url']}/$plugin/$filename";
        } else {
            $retval = $file;
        }
    } else {
        // Check to see if theme has theme_plugins specified. If so check there
        $file = "{$_CONF['path_html']}/$plugin/$directory/{$_CONF['theme_plugins']}/$filename";
        if (file_exists($file)) {
            if ($return_url) {
                $retval = "/$plugin/$directory/{$_CONF['theme_plugins']}/$filename";
            } else {
                $retval = $file;
            }
        } else {
            // See if current theme templates stored with plugin
            $file = "{$_CONF['path_html']}/$plugin/$directory/{$_CONF['theme']}/$filename";
            if (file_exists($file)) {
                if ($return_url) {
                    $retval = "/$plugin/$directory/{$_CONF['theme']}/$filename";
                } else {
                    $retval = $file;
                }
            } else {
                // Check to see if theme has theme_default. If so check there
                $file = "{$_CONF['path_html']}/$plugin/$directory/{$_CONF['theme_default']}/$filename";
                if (!empty($_CONF['theme_default']) && file_exists($file)) {
                    if ($return_url) {
                        $retval = "/$plugin/$directory/{$_CONF['theme_default']}/$filename";
                    } else {
                        $retval = $file;
                    }
                } else {
                    // Use default templates then. This should always exist
                    $file = "{$_CONF['path_html']}/$plugin/$directory/default/$filename";
                    if (file_exists($file)) {
                        if ($return_url) {
                            $retval = "/$plugin/$directory/default/$filename";
                        } else {
                            $retval = $file;
                        }
                    } else {
                        if ($return_url) {
                            // Last guess for URL file location
                            $retval = "/$plugin/$filename";
                        } else {
                            // Check to see if theme has theme_plugins specified. If so check there
                            $file = "{$_CONF['path']}plugins/$plugin/$directory/{$_CONF['theme_plugins']}/$filename";
                            if (file_exists($file)) {
                                $retval = $file;
                            } else {                        
                                // See if current theme templates stored with plugin
                                $file = "{$_CONF['path']}plugins/$plugin/$directory/{$_CONF['theme']}/$filename";
                                if (file_exists($file)) {
                                    $retval = $file;
                                } else {
                                    // Check to see if theme has theme_default. If so check there
                                    $file = "{$_CONF['path']}plugins/$plugin/$directory/{$_CONF['theme_default']}/$filename";
                                    if (!empty($_CONF['theme_default']) && file_exists($file)) {
                                        $retval = $file;
                                    } else {
                                        // Use default templates then. This should always exist
                                        $file = "{$_CONF['path']}plugins/$plugin/$directory/default/$filename";
                                        if (file_exists($file)) {
                                            $retval = $file;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    // Remove filename if needed
    if (!empty($retval) && !$include_filename) {
        $dirname = pathinfo($file, PATHINFO_DIRNAME); 
    }

    return $retval;
}

/**
 * Get physical path or url for plugin directory that could be located either in
 * the theme layout directory or the plugins directory
 *
 * @param    string  $plugin     name of plugin
 * @param    string  $directory  name of directory
 * @param    boolean $return_url flag to return url
 * @return   string              url or physical path
 */
function CTL_plugin_dirLocation($plugin, $directory = 'images', $return_url = true)
{
    global $_CONF;

    // See if plugin image files exist in current theme
    $path = "{$_CONF['path_layout']}$plugin/$directory";
    if (is_dir($path)) {
        if ($return_url) {
            $retval = "{$_CONF['layout_url']}/$plugin/$directory";
        } else {
            $retval = $path;
        }
    } else {
        // Use default location then. This should always exist
        if ($return_url) {
            $retval = "{$_CONF['site_url']}/$plugin/$directory";
        } else {
            $retval = "{$_CONF['path_html']}/$plugin/$directory";
        }
    }

    return $retval;
}

/**
 * Include plugin template functions file (functions.php) which may/may not do anything or exist.
 * This will currently set any additional css and javascript that is theme specific for a plugin templates
 * Usually called by plugin_getheadercode_foo so can set required javascript and css files needed by plugin
 *
 * @param    string $plugin name of plugin
 */
function CTL_plugin_setTemplatesFunctions($plugin)
{
    global $_SCRIPTS, $_CONF;

    $templateFuncutionsLocation = CTL_plugin_themeFindFile($plugin, 'templates', 'functions.php', false);
    if (!empty($templateFuncutionsLocation) && file_exists($templateFuncutionsLocation)) {
        /** @noinspection PhpIncludeInspection */
        require_once $templateFuncutionsLocation;

        // Workaround since we don't know the theme name of the functions.php file we are using
        // It would have been checked in the following order. When found then quit
        $themes = array();
        if (isset($_CONF['theme_plugins']) AND ($_CONF['theme_plugins'] !='')) {;
            // EXPERIMENTAL - Not required - Is used by all plugins - You can specify a COMPATIBLE theme (not a child theme) to use templates stored with some plugins. Can have problems if plugins include css and js files via their own functions.php            
            // Problem is that $_CONF['theme'] can be set in functions.php. With $_CONF['theme_plugins'] set files will not be loaded as the wrong dir is used. $_CONF['theme'] needs to be used in functions.php for fallback with child themes
            $themes[] = $_CONF['theme_plugins']; // Override of theme to set which theme template files to use for plugins (if found)
        }
        $themes[] = $_CONF['theme'];
        $themes[] = $_CONF['theme_default'];
        $themes[] = 'default';

        $function_found = false;
        
        foreach ($themes as $theme) {
            // Include scripts on behalf of plugin template files that are theme specific
            $func = $plugin . '_css_' . $theme;
            if (function_exists($func)) {
                $function_found = true;
                foreach ($func() as $info) {
                    $file = (!empty($info['file'])) ? $info['file'] : '';
                    $name = (!empty($info['name'])) ? $info['name'] : md5(!empty($file) ? $file : strval(time()));
                    $constant = (!empty($info['constant'])) ? $info['constant'] : true;
                    $attributes = (!empty($info['attributes'])) ? $info['attributes'] : array();
                    $priority = (!empty($info['priority'])) ? $info['priority'] : 100;
                    $_SCRIPTS->setCssFile($name, $file, $constant, $attributes, $priority, 'theme');
                }
            }
            $func = $plugin . '_js_libs_' . $theme;
            if (function_exists($func)) {
                $function_found = true;
                foreach ($func() as $info) {
                    $footer = true;
                    if (isset($info['footer']) && !$info['footer']) {
                        $footer = false;
                    }
                    $_SCRIPTS->setJavaScriptLibrary($info['library'], $footer);
                }
            }
            $func = $plugin . '_js_files_' . $theme;
            if (function_exists($func)) {
                $function_found = true;
                foreach ($func() as $info) {
                    $footer = true;
                    if (isset($info['footer']) && !$info['footer']) {
                        $footer = false;
                    }
                    $priority = (!empty($info['priority'])) ? $info['priority'] : 100;
                    $_SCRIPTS->setJavaScriptFile(md5($info['file']), $info['file'], $footer, $priority);
                }
            }

            if ($function_found) {
                break;
            }

        }
    }
}

/*
 * Implement *some* of the Plugin API functions for templates. While templates
 * aren't a plugin (and likely never will be), implementing some of the API
 * functions here will save us from doing special handling elsewhere.
 */

/**
 * Config Option has changed. (use plugin api)
 *
 * @param  string $group
 * @param  array  $changes
 * @return void
 */
function plugin_configchange_template($group, $changes = array())
{
    global $_CONF;

    if (($group === 'Core') && (in_array('cache_templates', $changes)
            || in_array('cache_mobile', $changes)
            || in_array('cache_resource', $changes)
            || in_array('template_comments', $changes)
            || in_array('language', $changes)
            || in_array('language_files', $changes)
            || in_array('languages', $changes)
            || in_array('url_rewrite', $changes)
            || in_array('url_routing', $changes)
        )
    ) {
        // To be safe clear cache on enabling and disabling of cache
        // If template comments disabled or enabled clear all cached templates
        // Also clear on config language changes since some cache instances may get messed up going from a single language to multi language setup
        // Clear cache on change of URL Rewrite and URL Rewriting
        CTL_clearCache();
    } elseif (($group === 'Core') &&
        (in_array('sortmethod', $changes) ||
            in_array('showstorycount', $changes) ||
            in_array('showsubmissioncount', $changes) ||
            in_array('hide_home_link', $changes))
    ) {
        // If Topics Block options changed then delete it's cache
        $cacheInstance = 'topicsblock__';
        CACHE_remove_instance($cacheInstance);
    } elseif (($group === 'Core') &&
        (in_array('newstoriesinterval', $changes) ||
            in_array('newcommentsinterval', $changes) ||
            in_array('newtrackbackinterval', $changes) ||
            in_array('hidenewstories', $changes) ||
            in_array('hidenewcomments', $changes) ||
            in_array('hidenewtrackbacks', $changes) ||
            in_array('hidenewplugins', $changes) ||
            in_array('title_trim_length', $changes) ||
            in_array('whatsnew_cache_time', $changes))
    ) {
        // Probably not really necessary but clear cache if enabled on these other settings that can have cache files
        // These are from the What's New Block
        if ($_CONF['whatsnew_cache_time'] > 0) {
            $cacheInstance = 'whatsnew__'; // remove all what's new instances
            CACHE_remove_instance($cacheInstance);
        }
    }
}

/**
 * Submission by a user
 *
 * @param   string $type
 * @return  void
 */
function plugin_submissionsaved_template($type)
{
    global $_CONF;

    if (($type === 'article' || $type === 'story') && $_CONF['showsubmissioncount']) {
        // Just call item delete since same functionality and doesn't need id
        plugin_itemdeleted_template('', $type);
    }
}

/**
 * Submission deleted by Admin
 *
 * @param   string $type
 * @return  void
 */
function plugin_submissiondeleted_template($type)
{
    global $_CONF;

    if (($type === 'article' || $type === 'story') && $_CONF['showsubmissioncount']) {
        // Just call item delete since same functionality and doesn't need id
        plugin_itemdeleted_template('', $type);
    }
}

/**
 * To be called (eventually) whenever Geeklog saves an item into the database.
 * Plugins can define their own 'itemsaved' function to be notified whenever
 * an item is saved or modified.
 * NOTE:     The behaviour of this API function changed in Geeklog 1.6.0
 *
 * @param    string $id     unique ID of the item
 * @param    string $type   type of the item, e.g. 'article'
 * @param    string $old_id (optional) old ID when the ID was changed
 * @return   void            (actually: false, for backward compatibility)
 * @link     http://wiki.geeklog.net/index.php/PLG_itemSaved
 */
function plugin_itemsaved_template($id, $type, $old_id = '')
{
    // Just call item delete since same functionality
    if (empty($old_id)) {
        plugin_itemdeleted_template($id, $type);
    } else {
        plugin_itemdeleted_template($old_id, $type);
    }
}

/**
 * To be called (eventually) whenever Geeklog removes an item from the database.
 * Plugins can define their own 'itemdeleted' function to be notified whenever
 * an item is deleted.
 *
 * @param    string $id   ID of the item
 * @param    string $type type of the item, e.g. 'article'
 * @return   void
 * @since    Geeklog 1.6.0
 */
function plugin_itemdeleted_template($id, $type)
{
    global $_STRUCT_DATA;
    
    // See if uses what's new block then delete cache of whatsnew
    // This will not catch everything though like trackbacks, comments, and
    // plugins that do not use itemsaved but let's delete the cache when we can

    // Also delete cache for topics block and topic_tree when topic or article is updated or deleted

    // Also delete article cache on article save and delete

    $article = false;
    $block = false;
    $whatsnew = false;
    $olderstories = false;
    $topicsblock = false;
    $topic_tree = false;

    if ($type === 'article' || $type === 'story') {
        $article = true;
        $whatsnew = true;
        $olderstories = true;
        $topicsblock = true;
    } elseif ($type == 'topic') {
        $topicsblock = true;
        $topic_tree = true;
        // These items use topics and may display info about topics
        $article = true;
        $block = true;
    } else {
        // hack to see if plugin supports what's new
        $fn_head = 'plugin_whatsnewsupported_' . $type;
        if (function_exists($fn_head)) {
            if (is_array($fn_head())) { // if array then supported
                $whatsnew = true;
            }
        }
    }

    if ($article) {
        $cacheInstance = 'article__' . $id; // remove all article instances
        CACHE_remove_instance($cacheInstance);
        $_STRUCT_DATA->clear_cachedScript('article');
    }
    if ($block) {
        $cacheInstance = 'block__' . $id; // remove all block instances
        CACHE_remove_instance($cacheInstance);
    }
    if ($whatsnew) {
        $cacheInstance = 'whatsnew__'; // remove all whatsnew instances
        CACHE_remove_instance($cacheInstance);
    }
    if ($olderstories) {
        $cacheInstance = 'olderarticles__'; // remove all olderarticles instances
        CACHE_remove_instance($cacheInstance);
    }
    if ($topicsblock) {
        $cacheInstance = 'topicsblock__';
        CACHE_remove_instance($cacheInstance);
    }
    if ($topic_tree) {
        $cacheInstance = 'topic_tree__';
        CACHE_remove_instance($cacheInstance);
    }
}
