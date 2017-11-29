<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | plugins.php                                                               |
// |                                                                           |
// | Geeklog plugin administration page.                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Matt West         - matt AT mattdanger DOT net                   |
// |          Rouslan Placella  - rouslan {at} placella {dot} com              |
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
 * This is the plugin administration page. Here you can install, uninstall,
 * upgrade, enable, disable, and upload plugins.
 */

/**
 * Geeklog common function library
 */
require_once '../lib-common.php';

/**
 * Security check to ensure user even belongs on this page
 */
require_once 'auth.inc.php';

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

// define upload error codes introduced in later PHP versions
if (!defined('UPLOAD_ERR_NO_TMP_DIR')) {
    define('UPLOAD_ERR_NO_TMP_DIR', 6);
}
if (!defined('UPLOAD_ERR_CANT_WRITE')) {
    define('UPLOAD_ERR_CANT_WRITE', 7);
}
if (!defined('UPLOAD_ERR_EXTENSION')) {
    define('UPLOAD_ERR_EXTENSION', 8);
}

$display = '';

if (!SEC_hasRights('plugin.edit')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the plugin administration screen.");
    COM_output($display);
    exit;
}

/**
 * Shows the plugin information center for installed plugins
 *
 * @param    string $pi_name Plugin name
 * @return   string              HTML for plugin editor form or error message
 * @todo     FIXME   Move that COM_errorLog message to the language files ...
 */
function plugin_info_installed($pi_name)
{
    global $_CONF, $_TABLES, $_USER, $LANG32, $LANG_ADMIN;

    $retval = '';

    if (strlen($pi_name) == 0) {
        $retval .= COM_showMessageText($LANG32[12], $LANG32[13]);

        return $retval;
    }

    $result = DB_query("SELECT pi_homepage,pi_version,pi_gl_version,pi_enabled,pi_load FROM {$_TABLES['plugins']} WHERE pi_name = '$pi_name'");
    if (DB_numRows($result) <> 1) {
        // Serious problem, we got a pi_name that doesn't exist
        // or returned more than one row
        $msg = COM_errorLog('Error in editing plugin ' . $pi_name
            . '. Either the plugin does not exist or there is more than one row with with same pi_name.  Bailing out to prevent trouble.');
        $retval .= COM_showMessageText($msg, $LANG32[13]);

        return $retval;
    }

    $A = DB_fetchArray($result);

    $plg_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/plugins');
    $plg_templates->set_file('editor', 'editor.thtml');
    $plg_templates->set_var('start_block_editor', COM_startBlock('', '', COM_getBlockTemplate('_admin_block', 'header')));
    $plg_templates->set_var('title', $LANG32[13]);
    $plg_templates->set_var('pi_icon', PLG_getIcon($pi_name));
    $plugin_code_version = PLG_chkVersion($pi_name);
    if (empty($plugin_code_version)) {
        $code_version = $LANG_ADMIN['na'];
    } else {
        $code_version = $plugin_code_version;
    }
    $pi_installed_version = $A['pi_version'];
    if (empty ($plugin_code_version) ||
        ($pi_installed_version == $code_version)
    ) {
        $plg_templates->set_var('update_option', '');
    } else {
        $plg_templates->set_var('update_option', '<button type="submit" value="'
            . $LANG32[34] . '" name="mode" class="uk-form">' . $LANG32[34] . '</button>');
    }
    $plg_templates->set_var('lang_pluginname', $LANG32[26]);
    $plg_templates->set_var('pi_name', $pi_name);
    $plg_templates->set_var('pi_display_name', plugin_get_pluginname($pi_name));
    $plg_templates->set_var('lang_pluginhomepage', $LANG32[27]);
    $plg_templates->set_var('pi_homepage', $A['pi_homepage']);
    $plg_templates->set_var('lang_pluginversion', $LANG32[28]);
    $plg_templates->set_var('pi_version', $A['pi_version']);
    $plg_templates->set_var('lang_plugincodeversion', $LANG32[33]);
    $plg_templates->set_var('pi_codeversion', $code_version);
    $plg_templates->set_var('lang_load', $LANG32[43]);
    $plg_templates->set_var('pi_load', $A['pi_load']);
    $plg_templates->set_var('lang_dependencies', $LANG32[50]);
    $plg_templates->set_var('pi_dependencies', PLG_printDependencies($pi_name, $A['pi_gl_version']));
    $plg_templates->set_var('lang_enabled', $LANG32[19]);
    if ($A['pi_enabled'] == 1) {
        $plg_templates->set_var('pi_enabled', $LANG32[20]);
    } else {
        if (file_exists($_CONF['path'] . 'plugins/' . $pi_name
            . '/functions.inc')) {
            $plg_templates->set_var('pi_enabled', $LANG32[21]);
        } else {
            $plg_templates->set_var('pi_enabled', '<div class="status_red">' . $LANG32[54] . '</div>');
        }
    }
    $plg_templates->set_var('back', $LANG32[60]);
    $plg_templates->set_var('gltoken', SEC_createToken());
    $plg_templates->set_var('gltoken_name', CSRF_TOKEN);
    $plg_templates->set_var('end_block',
        COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer')));

    $retval .= $plg_templates->finish($plg_templates->parse('output', 'editor'));

    return $retval;
}

/**
 * Shows the plugin information center for uninstalled plugins
 *
 * @param    string $pi_name Plugin name
 * @return   string              HTML for plugin editor form or error message
 */
function plugin_info_uninstalled($pi_name)
{
    global $_CONF, $_TABLES, $_USER, $LANG32, $LANG_ADMIN;

    $retval = '';
    if (strlen($pi_name) == 0) {
        $retval .= COM_showMessageText($LANG32[12], $LANG32[13]);

        return $retval;
    }
    // Get data
    $params = PLG_getParams($pi_name);

    // Do template stuff
    $plg_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/plugins');
    $plg_templates->set_file('editor', 'info.thtml');
    $plg_templates->set_var('start_block_editor', COM_startBlock('',
        '', COM_getBlockTemplate('_admin_block', 'header')));
    $plg_templates->set_var('pi_icon', PLG_getIcon($pi_name));
    $plg_templates->set_var('title', $LANG32[13]);
    $plg_templates->set_var('lang_pluginname', $LANG32[26]);
    $plg_templates->set_var('pi_display_name', plugin_get_pluginname($pi_name));
    $plg_templates->set_var('lang_pluginversion', $LANG32[17]);
    $plg_templates->set_var('pi_version', $params['info']['pi_version']);
    $plg_templates->set_var('lang_pluginhomepage', $LANG32[27]);
    if (!empty($params['info']['pi_homepage'])) {
        $plg_templates->set_var('pi_homepage', COM_CreateLink($params['info']['pi_homepage'], $params['info']['pi_homepage']));
    } else {
        $plg_templates->set_var('pi_homepage', $LANG_ADMIN['na']);
    }
    $pi_deps = PLG_printDependencies($pi_name, $params['info']['pi_gl_version']);
    $plg_templates->set_var('lang_dependencies', $LANG32[50]);
    $plg_templates->set_var('pi_dependencies', $pi_deps);
    $plg_templates->set_var('back', $LANG32[60]);
    $plg_templates->set_var('end_block',
        COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer')));
    $retval .= $plg_templates->finish($plg_templates->parse('output', 'editor'));

    return $retval;
}

/**
 * Toggle plugin status from enabled to disabled and back
 *
 * @param    array $plugin_name name of the plugin to be toggled
 * @return   void
 */
function changePluginStatus($plugin_name)
{
    global $_TABLES, $_DB_table_prefix;

    if (!empty($plugin_name)) {
        // First find out the current state of the plugin
        $plugin_is_enabled = '';
        $sql = "SELECT pi_enabled FROM {$_TABLES['plugins']} WHERE pi_name = ('{$plugin_name}')";
        $result = DB_query($sql);
        if (DB_numRows($result) > 0) {
            list($plugin_is_enabled) = DB_fetchArray($result);
        }
        // Then toggle the state of the plugin
        if ($plugin_is_enabled == '1') {
            // Disable plugin
            PLG_enableStateChange($plugin_name, false);
            DB_change($_TABLES['plugins'], 'pi_enabled', 0,
                'pi_name', $plugin_name);
            PLG_pluginStateChange($plugin_name, 'disabled');
        } elseif ($plugin_is_enabled === '0') {
            // Enable plugin
            PLG_enableStateChange($plugin_name, true);
            DB_change($_TABLES['plugins'], 'pi_enabled', 1,
                'pi_name', $plugin_name);
            PLG_pluginStateChange($plugin_name, 'enabled');
        }
    }
}

/**
 * Creates list of uninstalled plugins (if any) and offers install link to them.
 *
 * @param    string $token Security token to use in list
 * @return   string          HTML containing list of uninstalled plugins
 */
function show_newplugins($token)
{
    global $_CONF, $_TABLES, $LANG32;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $plugins = array();
    $plugins_dir = $_CONF['path'] . 'plugins/';
    $fd = opendir($plugins_dir);
    $index = 1;
    $retval = '';
    $data_arr = array();

    while (($dir = @readdir($fd)) == true) {
        if (($dir !== '.') && ($dir !== '..') && ($dir !== 'CVS') &&
            (substr($dir, 0, 1) !== '.') && is_dir($plugins_dir . $dir)
        ) {
            clearstatcache();
            // Check and see if this plugin is installed - if there is a record.
            // If not then it's a new plugin
            if (DB_count($_TABLES['plugins'], 'pi_name', $dir) == 0) {
                $plugin_ok = false;
                $plugin_new_style = false;
                // additionally, check if a 'functions.inc' exists
                if (file_exists($plugins_dir . $dir . '/functions.inc')) {
                    // new plugins will have a autoinstall.php
                    if (file_exists($plugins_dir . $dir . '/autoinstall.php')) {
                        $plugin_ok = true;
                        $plugin_new_style = true;
                    } else {
                        // and finally, since we're going to link to it, check
                        // if an install script exists
                        $adminurl = $_CONF['site_admin_url'];
                        if (strrpos($adminurl, '/') == strlen($adminurl)) {
                            $adminurl = substr($adminurl, 0, -1);
                        }
                        $pos = strrpos($adminurl, '/');
                        if ($pos === false) {
                            // didn't work out - use the URL
                            $admindir = $_CONF['site_admin_url'];
                        } else {
                            $admindir = $_CONF['path_html']
                                . substr($adminurl, $pos + 1);
                        }
                        $fh = @fopen($admindir . '/plugins/' . $dir
                            . '/install.php', 'r');
                        if ($fh) {
                            fclose($fh);
                            $plugin_ok = true;
                            $plugin_new_style = false;
                        }
                    }
                    if ($plugin_ok) {
                        if ($plugin_new_style) {
                            $url = $_CONF['site_admin_url'] . '/plugins.php'
                                . '?mode=autoinstall&amp;plugin=' . $dir;
                        } else {
                            $url = $_CONF['site_admin_url'] . '/plugins/' . $dir
                                . '/install.php?action=install';
                        }
                        $url .= '&amp;' . CSRF_TOKEN . '=' . $token;
                        $data_arr[] = array(
                            'pi_name'         => $dir,
                            'pi_display_name' => plugin_get_pluginname($dir),
                            'pi_gl_version'   => '',
                            'number'          => $index,
                            'install_link'    => $url,
                        );
                        $index++;
                    }
                }
            }
        }
    }

    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG32[59], 'field' => 'info_uninstalled'),
        array('text' => $LANG32[16], 'field' => 'pi_display_name'),
        array('text' => $LANG32[17], 'field' => 'pi_version'),
        array('text' => $LANG32[50], 'field' => 'pi_dependencies'),
        array('text' => $LANG32[22], 'field' => 'install_link'),
    );

    $text_arr = array('title'    => $LANG32[14],
                      'form_url' => $_CONF['site_admin_url'] . '/plugins.php',
    );
    $retval .= ADMIN_simpleList('ADMIN_getListField_newplugins', $header_arr, $text_arr, $data_arr);

    return $retval;
}

/**
 * Updates a plugin (call its upgrade function).
 *
 * @param    string $pi_name name of the plugin to uninstall
 * @return   string              HTML for error or success message
 */
function do_update($pi_name)
{
    global $_CONF, $LANG32;

    $retval = '';

    if (!empty($pi_name)) {
        $result = PLG_upgrade($pi_name);
        if ($result > 0) {
            if ($result === true) { // Catch returns that are just true/false
                PLG_pluginStateChange($pi_name, 'upgraded');
                COM_redirect($_CONF['site_admin_url'] . '/plugins.php?msg=60');
            } else {    // Plugin returned a message number
                COM_redirect($_CONF['site_admin_url']
                    . '/plugins.php?msg=' . $result . '&amp;plugin='
                    . $pi_name
                );
            }
        } else {  // Plugin function returned a false
            $retval = COM_showMessage(95);
        }
    } else { // no plugin name given
        $retval = COM_showMessageText($LANG32[12], $LANG32[13]);
    }

    $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG32[13]));

    return $retval;
}


/**
 * Uninstall a plugin (call its uninstall function).
 *
 * @param    string $pi_name name of the plugin to uninstall
 * @return   string              HTML for error or success message
 */
function do_uninstall($pi_name)
{
    global $_CONF, $_TABLES, $_DB_table_prefix;

    $retval = false;

    if (empty($pi_name) || (strlen($pi_name) == 0)) {
        return false;
    }

    // if the plugin is disabled, load the functions.inc now
    if (!function_exists('plugin_uninstall_' . $pi_name) &&
        !function_exists('plugin_autouninstall_' . $pi_name)
    ) {
        require_once $_CONF['path'] . 'plugins/' . $pi_name . '/functions.inc';
    }

    if (PLG_uninstall($pi_name)) {
        PLG_pluginStateChange($pi_name, 'uninstalled');

        $retval = 45; // success msg
    } else {
        $retval = 95; // error msg
    }

    return $retval;
}

/**
 * List available plugins
 *
 * @param    string $token Security token
 * @return   string          formatted list of plugins
 */
function listplugins($token)
{
    global $_CONF, $_TABLES, $LANG32, $LANG_ADMIN, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $outcome = PLG_resolveDependencies();

    $retval = '';
    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG32[59], 'field' => 'info_installed', 'sort' => false),
        array('text' => $LANG32[43], 'field' => 'pi_load', 'sort' => true),
        array('text' => $LANG32[16], 'field' => 'pi_name', 'sort' => true),
        array('text' => $LANG32[17], 'field' => 'pi_version', 'sort' => true),
        array('text' => $LANG32[50], 'field' => 'pi_dependencies', 'sort' => true),
        array('text' => $LANG_ADMIN['enabled'], 'field' => 'pi_enabled', 'sort' => true),
        array('text' => $LANG32[25], 'field' => 'delete', 'sort' => false),
    );

    $defsort_arr = array('field' => 'pi_load', 'direction' => 'asc');

    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']),
        
        array('url' => 'plugins.php?mode=chkupdates',
              'text' => $LANG32[301]),
        array('url' => 'plugins.php?mode=lstrepo',
              'text' => $LANG32[302]),
        array('url' => 'plugins.php?mode=updatelist',
              'text' => $LANG32[304])
    );    

    // JS required by the delete feature
    $retval .= '<script type="text/javascript">/* quick Javascript confirmation function */';
    $retval .= 'function confirm_action(msg,url){if(confirm(msg)){location.href=url;}}';
    $retval .= '</script>';

    $retval .= COM_startBlock($LANG32[5], '',
        COM_getBlockTemplate('_admin_block', 'header'));

    if ($outcome == false) {
        $retval .= COM_showMessageText($LANG32[58]);
    }

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG32[11],
        $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE
    );

    $text_arr = array(
        'has_extras'   => true,
        'instructions' => $LANG32[11],
        'form_url'     => $_CONF['site_admin_url'] . '/plugins.php',
    );

    $query_arr = array(
        'table'          => 'plugins',
        'sql'            => "SELECT pi_name, pi_version, pi_gl_version, pi_load, "
            . "pi_enabled, pi_homepage FROM {$_TABLES['plugins']} WHERE 1=1",
        'query_fields'   => array('pi_name'),
        'default_filter' => '',
    );

    // this is a dummy variable so we know the form has been used if all plugins
    // should be disabled in order to disable the last one.
    $form_arr = array(
        'top'    => '<div><input type="hidden" name="' . CSRF_TOKEN . '" value="'
            . $token . '"' . XHTML . '></div>',
        'bottom' => '<div><input type="hidden" name="pluginenabler" value="true"'
            . XHTML . '></div>',
    );

    $retval .= ADMIN_list('plugins', 'ADMIN_getListField_plugins', $header_arr,
        $text_arr, $query_arr, $defsort_arr, '', $token, '', $form_arr, false);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
 * Re-orders all plugins by load order in increments of 10
 *
 * @return   void
 */
function reorderplugins()
{
    global $_TABLES;

    $pluginOrd = 10;
    $stepNumber = 10;

    $sql = "SELECT * FROM {$_TABLES['plugins']} ORDER BY pi_load ASC;";
    $result = DB_query($sql);
    while ($A = DB_fetchArray($result)) {
        if ($A['pi_load'] != $pluginOrd) {  // only update incorrect ones
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_load = '{$pluginOrd}' WHERE pi_name = '{$A['pi_name']}'");
        }
        $pluginOrd += $stepNumber;
    }
}

/**
 * Change the load order of a plugin
 *
 * @param    string $pi_name     Name of the plugin
 * @param    mixed  $where       Where to move the plugin specified by $pi_name.
 *                               Valid values are "up" and "dn", which stand for
 *                               "Move 'Up' or 'Down' through the load order"
 *                               or any integer between 0 and 10000.
 * @return   void
 */
function change_load_order($pi_name = '', $where = '')
{
    if (!empty($pi_name) && !empty($where)) {
        global $_CONF, $_TABLES;
        $q = "SELECT pi_load FROM {$_TABLES['plugins']} WHERE pi_name = '$pi_name'";
        $q = DB_query($q);
        if (DB_numRows($q) == 1) { // if the plugin exists
            $query = '';
            switch ($where) {
                case "up":
                    $A = DB_fetchArray($q);
                    if ($A['pi_load'] > 10) { // no negative values
                        $query = "UPDATE {$_TABLES['plugins']} SET pi_load = pi_load-11 WHERE pi_name = '{$pi_name}'";
                    }
                    break;

                case "dn":
                    $query = "UPDATE {$_TABLES['plugins']} SET pi_load = pi_load+11 WHERE pi_name = '{$pi_name}'";
                    break;

                default:
                    if (is_numeric($where) && $where >= 0 && $where <= 10000) {
                        $where = (int) $where;
                        $query = "UPDATE {$_TABLES['plugins']} SET pi_load = {$where} WHERE pi_name = '{$pi_name}'";
                    } else {
                        COM_errorLog("plugins admin error: Attempt to assign an invalid load order '$where' to plugin '$pi_name'");
                    }
                    break;
            }
            if (!empty($query)) {
                DB_query($query);
                reorderplugins();
            }
        } else {
            COM_errorLog("plugins admin error: Attempt to move a non existent plugin: $pi_name");
        }
    }
}

/**
 * Check if an error occurred while uploading a file
 *
 * @param   array $mFile    $_FILE['uploaded_file']
 * @return  mixed           Returns the error string if an error occurred,
 *                          returns false if no error occurred
 */
function plugin_getUploadError($mFile)
{
    global $LANG32;

    $retval = '';

    if (isset($mFile['error']) && ($mFile['error'] !== UPLOAD_ERR_OK)) { // If an error occurred while uploading the file.
        if ($mFile['error'] > UPLOAD_ERR_EXTENSION) { // If the error code isn't known
            $retval = $LANG32[99]; // Unknown error
        } else {
            $retval = $LANG32[$mFile['error'] + 100]; // Print the error
        }
    } else { // If no upload error occurred
        $retval = false;
    }

    return $retval;
}

/**
 * Check if uploads are possible
 *
 * @return   array     a list of errors or an empty array, if there weren't any.
 */
function plugin_upload_enabled()
{
    global $_CONF, $LANG32;

    $path_admin = $_CONF['path_html'] . substr($_CONF['site_admin_url'],
            strlen($_CONF['site_url']) + 1) . '/';

    // If 'file_uploads' is enabled in php.ini
    // and the plugin directories are writable by the web server.
    $errors = array();
    
    if (isset($_CONF['demo_mode']) && $_CONF['demo_mode']) {
        $errors[] = $LANG32[69];
    }
    if (!ini_get('file_uploads')) {
        $errors[] = $LANG32[66];
    }
    if (!is_writable($_CONF['path'] . 'plugins/')) {
        $errors[] = sprintf($LANG32[67], $_CONF['path'] . 'plugins/');
    }
    if (!is_writable($_CONF['path_html'])) {
        $errors[] = sprintf($LANG32[67], $_CONF['path_html']);
    }
    if (!is_writable($path_admin . 'plugins/')) {
        $errors[] = sprintf($LANG32[67], $path_admin . 'plugins/');
    }
    if (!SEC_hasRights('plugin.install')) {
        $errors[] = $LANG32[68];
    }
    if (!SEC_hasRights('plugin.upload')) {
        $errors[] = $LANG32[69];
    }

    return $errors;
}

/**
 * Display upload form
 *
 * @param    string $token Security token
 * @return   string          HTML for the upload form
 */
function plugin_show_uploadform($token)
{
    global $_CONF, $LANG28, $LANG32;

    $retval = '';

    $retval .= COM_startBlock($LANG32[39], '',
        COM_getBlockTemplate('_admin_block', 'header'));

    // Check if all the requirements needed to upload a plugin are met
    $errors = plugin_upload_enabled();
    if (count($errors) == 0) {
        // Show the upload form
        $retval .= '<p>' . $LANG32[40] . '</p>' . LB
            . '<form name="plugins_upload" action="' . $_CONF['site_admin_url']
            . '/plugins.php" method="post" enctype="multipart/form-data">' . LB
            . '<div>' . $LANG28[29] . ': '
            . '<input type="file" dir="ltr" name="plugin" size="40"' . XHTML . '> ' . LB
            . '<button type="submit" name="upload" value="' . $LANG32[41] . '" class="uk-form">' . $LANG32[41] . '</button>' . LB
            . '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $token . '"' . XHTML . '>'
            . '</div>' . LB . '</form>' . LB;
    } else {
        // Show the errors
        $retval .= '<p>' . $LANG32[65] . '</p>' . LB . '<div><ul>' . LB;
        foreach ($errors as $key => $value) {
            $retval .= "<li class=\"url\">$value</li>";
        }
        $retval .= '</ul></div>' . LB;
    }
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
 * Handle uploaded plugin
 *
 * @return   string      HTML: redirect or main plugin screen + error message
 */
function plugin_upload($fpath = null)
{
    global $_CONF, $_TABLES;

    $retval = '';

    $path_admin = $_CONF['path_html'] . substr($_CONF['site_admin_url'],
            strlen($_CONF['site_url']) + 1) . '/';

    $upload_success = false;
    
    if ($fpath === NULL) {
        // If an error occured while uploading the file.
        $error_msg = plugin_getUploadError($_FILES['plugin']);
        $plugin_name = $_FILES['plugin']['name'];
        $fpath = $_FILES['plugin']['tmp_name'];
        $plugin_type = $_FILES['plugin']['type'];
    }
    else {
        $error_msg = NULL;
    }    

    // If an error occurred while uploading the file.
    //$error_msg = plugin_getUploadError($_FILES['plugin']);
    if (!empty($error_msg)) {
        $retval .= plugin_main($error_msg);
    } else {
        //$plugin_file = $_CONF['path_data'] . $_FILES['plugin']['name']; // Name the plugin file
        $plugin_file = $_CONF['path_data'] . $plugin_name; // Name the plugin file

        //$archive = new Unpacker($_FILES['plugin']['tmp_name'], $_FILES['plugin']['type']);
        $archive = new unpacker($fpath, $plugin_type);
        $tmp = $archive->getList(); // Grab the contents of the tarball to see what the plugin name is
        $dirName = preg_replace('/\/.*$/', '', $tmp[0]['filename']);

        if (empty($dirName)) { // If $dirname is blank it's probably because the user uploaded a non Tarball file.
            COM_redirect($_CONF['site_admin_url'] . '/plugins.php?msg=100');
        } else {
            $pi_did_exist = false; // plugin directory already existed
            $pi_had_entry = false; // plugin had an entry in the database
            $pi_was_enabled = false; // plugin was enabled

            if (file_exists($_CONF['path'] . 'plugins/' . $dirName)) {
                $pi_did_exist = true;

                // plugin directory already exists
                $pstatus = DB_query("SELECT pi_name, pi_enabled FROM {$_TABLES['plugins']} WHERE pi_name = '$dirName'");
                $A = DB_fetchArray($pstatus);
                if (isset($A['pi_name'])) {
                    $pi_had_entry = true;
                    $pi_was_enabled = ($A['pi_enabled'] == 1);
                }

                $callback = 'plugin_enablestatechange_' . $dirName;

                if ($pi_was_enabled) {
                    // disable temporarily while we move the files around
                    if (is_callable($callback)) {
                        changePluginStatus($dirName);
                    } else {
                        DB_change($_TABLES['plugins'], 'pi_enabled', 0,
                            'pi_name', $dirName);
                    }
                }

                $plugin_dir = $_CONF['path'] . 'plugins/' . $dirName;
                if (file_exists($plugin_dir . '.previous')) {
                    Geeklog\FileSystem::remove($plugin_dir . '.previous');
                }
                if (file_exists($plugin_dir)) {
                    rename($plugin_dir, $plugin_dir . '.previous');
                }

                $public_dir = $_CONF['path_html'] . $dirName;
                if (file_exists($public_dir . '.previous')) {
                    Geeklog\FileSystem::remove($public_dir . '.previous');
                }
                if (file_exists($public_dir)) {
                    rename($public_dir, $public_dir . '.previous');
                }

                $admin_dir = $path_admin . 'plugins/' . $dirName;
                if (file_exists($admin_dir . '.previous')) {
                    Geeklog\FileSystem::remove($admin_dir . '.previous');
                }
                if (file_exists($admin_dir)) {
                    rename($admin_dir, $admin_dir . '.previous');
                }
            }

            /**
             * Install the plugin
             * This doesn't work if the public_html & public_html/admin/plugins directories aren't 777
             */

            // Extract the tarball to data so we can get the $pi_name name from admin/install.php
            $archive->unpack($_CONF['path'] . 'data/', '|' . preg_quote($dirName . '/admin/install.php', '|') . '|');
            $plugin_inst = $_CONF['path'] . 'data/' . $dirName . '/admin/install.php';
            $fileData = @file_get_contents($plugin_inst);
            /*
                        // Remove the plugin from data/
                        Geeklog\FileSystem::remove($_CONF['path'] . 'data/' . $dirname);
            */
            // Some plugins seem to expect files under the data directory to
            // be unchanged while they are disabled.  Let's leave the files untouched.

            /**
             * One time I wanted to install a muffler on my car and
             * needed to match up the outside diameter of the car's
             * exhaust pipe to the inside diameter of the muffler.
             * Unfortunately, when I went to the auto parts store they
             * didn't have a coupling adapter that would perfectly
             * match the two pipes, only a bunch of smaller adapters.
             * I ended up using about 4 small adapters to step down
             * one size at a time to the size of the muffler's input.
             * It's kind of like this regular expression:
             */
            $fileData = str_replace(array("\n", ' '), '', $fileData);
            $pi_name = preg_replace('/^.*\$pi\_name=\'/', '', $fileData);
            $pi_name = preg_replace('/\'.*$/', '', $pi_name);

            // Some plugins don't have $pi_name set in their install.php file,
            // This means our regex won't work and we should just use $dirname
            if (empty($pi_name) || preg_match('/\<\?php/', $pi_name) || preg_match('/--/', $pi_name)) {
                $pi_name = $dirName;
            }

            // Extract the uploaded archive to the plugins directory
            $upload_success = $archive->unpack($_CONF['path'] . 'plugins/');

            $plg_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';
            if ($upload_success) {
                if (file_exists($plg_path . 'public_html')) {
                    rename($plg_path . 'public_html', $_CONF['path_html'] . $pi_name);
                }
                if (file_exists($plg_path . 'admin')) {
                    rename($plg_path . 'admin', $path_admin . 'plugins/' . $pi_name);
                }
            }

            unset($archive); // Collect some garbage

            // cleanup when uploading a new version
            if ($pi_did_exist) {
                $plugin_dir = $_CONF['path'] . 'plugins/' . $dirName;
                if (file_exists($plugin_dir . '.previous')) {
                    Geeklog\FileSystem::remove($plugin_dir . '.previous');
                }

                $public_dir = $_CONF['path_html'] . $dirName;
                if (file_exists($public_dir . '.previous')) {
                    Geeklog\FileSystem::remove($public_dir . '.previous');
                }

                $admin_dir = $path_admin . 'plugins/' . $dirName;
                if (file_exists($admin_dir . '.previous')) {
                    Geeklog\FileSystem::remove($admin_dir . '.previous');
                }

                if ($pi_was_enabled) {
                    // Enable the plugin again
                    if (is_callable($callback)) {
                        changePluginStatus($dirName);
                    } else {
                        DB_change($_TABLES['plugins'], 'pi_enabled', 1, 'pi_name', $dirName);
                    }
                }
            }

            $msg_with_plugin_name = false;
            if ($pi_did_exist) {
                if ($pi_was_enabled) {
                    // check if we have to perform an update
                    $pi_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                        "pi_name = '$dirName'");
                    $code_version = PLG_chkVersion($dirName);
                    if (!empty($code_version) &&
                        ($code_version != $pi_version)
                    ) {
                        /**
                         * At this point, we would have to call PLG_upgrade().
                         * However, we've loaded the plugin's old functions.inc
                         * (in lib-common.php). We can't load the new one here
                         * now since that would result in duplicate function
                         * definitions. Solution: Trigger a reload (with the new
                         * functions.inc) and continue there.
                         */
                        $url = $_CONF['site_admin_url'] . '/plugins.php'
                            . '?mode=continue_upgrade'
                            . '&amp;codeversion=' . urlencode($code_version)
                            . '&amp;piversion=' . urlencode($pi_version)
                            . '&amp;plugin=' . urlencode($dirName);
                        COM_redirect($url);
                    } else {
                        $msg = 98; // successfully uploaded
                    }
                } else {
                    $msg = 98; // successfully uploaded
                }
            } elseif (file_exists($plg_path . 'autoinstall.php')) {
                // if the plugin has an autoinstall.php, install it now
                if (plugin_autoinstall($pi_name)) {
                    PLG_pluginStateChange($pi_name, 'installed');
                    $msg = 44; // successfully installed
                } else {
                    $msg = 72; // an error occurred while installing the plugin
                }
            } else {
                $msg = 98; // successfully uploaded
            }

            $url = $_CONF['site_admin_url'] . '/plugins.php?msg=' . $msg;
            if ($msg_with_plugin_name) {
                $url .= '&amp;plugin=' . $dirName;
            }
            COM_redirect($url);
        }
    }

    return $retval;
}

/**
 * Continue a plugin upgrade that started in plugin_upload()
 *
 * @param    string $plugin       plugin name
 * @param    string $pi_version   current plugin version
 * @param    string $code_version plugin version to be upgraded to
 * @return   string                  HTML refresh
 * @see      function plugin_upload
 */
function continue_upgrade($plugin, $pi_version, $code_version)
{
    global $_CONF, $_TABLES;

    $retval = '';
    $msg_with_plugin_name = false;

    // simple sanity checks
    if (empty($plugin) || empty($pi_version) || empty($code_version) ||
        ($pi_version == $code_version)
    ) {
        $msg = 72;
    } else {
        // more sanity checks
        $result = DB_query("SELECT pi_version, pi_enabled FROM {$_TABLES['plugins']} WHERE pi_name = '" . DB_escapeString($plugin) . "'");
        $A = DB_fetchArray($result);
        if (!empty($A['pi_version']) && ($A['pi_enabled'] == 1) &&
            ($A['pi_version'] == $pi_version) &&
            ($A['pi_version'] != $code_version)
        ) {
            // continue upgrade process that started in plugin_upload()
            $result = PLG_upgrade($plugin);
            if ($result === true) {
                PLG_pluginStateChange($plugin, 'upgraded');
                $msg = 60; // successfully updated
            } else {
                $msg_with_plugin_name = true;
                $msg = $result; // message provided by the plugin
            }
        } else {
            $msg = 72;
        }
    }

    $url = $_CONF['site_admin_url'] . '/plugins.php?msg=' . $msg;
    if ($msg_with_plugin_name) {
        $url .= '&amp;plugin=' . $plugin;
    }

    COM_redirect($url);
}

/**
 * Show main plugin screen: installed and uninstalled plugins, upload form
 *
 * @param    string $message (optional) message to display
 * @param    string $token   an optional csrf token
 * @return   string              HTML for the plugin screen
 */
function plugin_main($message = '', $token = '')
{
    global $LANG32;

    $retval = '';

    if (!empty($message)) {
        $retval .= COM_showMessageText($message);
    } else {
        $retval .= COM_showMessageFromParameter();
    }

    if (empty($token)) {
        $token = SEC_createToken();
    }

    $retval .= listplugins($token);
    if (SEC_hasRights('plugin.install')) {
        $retval .= show_newplugins($token);
    }

    // Show the upload form or an error message
    $retval .= plugin_show_uploadform($token);
    
    $retval .= pluginsearch($token);

    $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG32[5]));

    return $retval;
}

/**
 * Prepare and perform plugin auto install
 *
 * @param    string $plugin Plugin name (internal name, i.e. directory name)
 * @return   boolean             true on success, false otherwise
 */
function plugin_autoinstall($plugin)
{
    global $_CONF, $LANG32;

    $plugin = COM_applyFilter($plugin);
    $plugin = COM_sanitizeFilename($plugin);
    $autoinstall = $_CONF['path'] . 'plugins/' . $plugin . '/autoinstall.php';

    if (empty($plugin) || !file_exists($autoinstall)) {
        COM_errorLog('autoinstall.php not found', 1);

        return false;
    }

    require_once $autoinstall;

    $check_compatible = 'plugin_compatible_with_this_version_' . $plugin;
    if (function_exists($check_compatible)) {
        if (!$check_compatible($plugin)) {
            COM_errorLog($LANG32[9]);

            return false;
        }
    }

    $auto_install = 'plugin_autoinstall_' . $plugin;
    if (!function_exists($auto_install)) {
        COM_errorLog("Function '$auto_install' not found", 1);

        return false;
    }

    $inst_parms = $auto_install($plugin);
    if (($inst_parms === false) || empty($inst_parms)) {
        COM_errorLog('No install parameters', 1);

        return false;
    }

    return plugin_do_autoinstall($plugin, $inst_parms);
}

/**
 * Do the actual plugin auto install
 *
 * @param    string  $plugin     Plugin name
 * @param    array   $inst_parms Installation parameters for the plugin
 * @param    boolean $verbose    true: enable verbose logging
 * @return   boolean             true on success, false otherwise
 */
function plugin_do_autoinstall($plugin, $inst_parms, $verbose = true)
{
    global $_CONF, $_TABLES, $_USER, $_DB_dbms, $_DB_table_prefix;

    $base_path = $_CONF['path'] . 'plugins/' . $plugin . '/';

    if ($verbose) {
        COM_errorLog("Attempting to install the '$plugin' plugin", 1);
    }

    // sanity checks in $inst_parms
    if (isset($inst_parms['info'])) {
        $pi_name = $inst_parms['info']['pi_name'];
        $pi_version = $inst_parms['info']['pi_version'];
        $pi_gl_version = $inst_parms['info']['pi_gl_version'];
        $pi_homepage = $inst_parms['info']['pi_homepage'];
    }
    if (empty($pi_name) || ($pi_name != $plugin) || empty($pi_version) ||
        empty($pi_gl_version) || empty($pi_homepage)
    ) {
        COM_errorLog('Incomplete plugin info', 1);

        return false;
    }

    // add plugin tables, if any
    if (!empty($inst_parms['tables'])) {
        $tables = $inst_parms['tables'];
        foreach ($tables as $table) {
            $_TABLES[$table] = $_DB_table_prefix . $table;
        }
    }

    // Create the plugin's group(s), if any
    $groups = array();
    $admin_group_id = 0;
    if (!empty($inst_parms['groups'])) {
        $groups = $inst_parms['groups'];
        foreach ($groups as $name => $desc) {
            if ($verbose) {
                COM_errorLog("Attempting to create '$name' group", 1);
            }

            $grp_name = DB_escapeString($name);
            $grp_desc = DB_escapeString($desc);
            $sql = array();

            $sql['pgsql'] = "INSERT INTO {$_TABLES['groups']} (grp_id,grp_name, grp_descr) VALUES ((SELECT NEXTVAL('{$_TABLES['groups']}_grp_id_seq')),'$grp_name', '$grp_desc')";
            $sql['mysql'] = "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) VALUES ('$grp_name', '$grp_desc')";

            DB_query($sql, 1);
            if (DB_error()) {
                COM_errorLog('Error creating plugin group', 1);
                PLG_uninstall($plugin);

                return false;
            }

            // keep the new group's ID for use in the mappings section (below)
            $groups[$name] = DB_insertId();

            // assume that the first group is the plugin's Admin group
            if ($admin_group_id == 0) {
                $admin_group_id = $groups[$name];
            }
        }
    }

    // Create the plugin's table(s)
    $_SQL = array();
    $DEFVALUES = array();
    if (file_exists($base_path . 'sql/' . $_DB_dbms . '_install.php')) {
        require_once $base_path . 'sql/' . $_DB_dbms . '_install.php';
    }

    if (count($_SQL) > 0) {
        $use_innodb = false;
        if (($_DB_dbms == 'mysql') &&
            (DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'")
                == 'InnoDB')
        ) {
            $use_innodb = true;
        }

        foreach ($_SQL as $sql) {
            $sql = str_replace('#group#', $admin_group_id, $sql);
            DB_query($sql);
            if (DB_error()) {
                COM_errorLog('Error creating plugin table', 1);
                PLG_uninstall($plugin);

                return false;
            }
        }
    }

    // Add the plugin's features
    if ($verbose) {
        COM_errorLog("Attempting to add '$plugin' features", 1);
    }

    $features = array();
    $mappings = array();
    if (!empty($inst_parms['features'])) {
        $features = $inst_parms['features'];
        if (!empty($inst_parms['mappings'])) {
            $mappings = $inst_parms['mappings'];
        }

        foreach ($features as $feature => $desc) {
            $ft_name = DB_escapeString($feature);
            $ft_desc = DB_escapeString($desc);
            $sql = array();

            $sql['pgsql'] = "INSERT INTO {$_TABLES['features']} (ft_id,ft_name, ft_descr)
                     VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'$ft_name', '$ft_desc')";

            $sql['mysql'] = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr)
                    VALUES ('$ft_name', '$ft_desc')";

            DB_query($sql, 1);
            if (DB_error()) {
                COM_errorLog('Error adding plugin feature', 1);
                PLG_uninstall($plugin);

                return false;
            }

            $feat_id = DB_insertId();

            if (isset($mappings[$feature])) {
                foreach ($mappings[$feature] as $group) {
                    if ($verbose) {
                        COM_errorLog("Adding '$feature' feature to the '$group' group", 1);
                    }

                    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($feat_id, {$groups[$group]})");
                    if (DB_error()) {
                        COM_errorLog('Error mapping plugin feature', 1);
                        PLG_uninstall($plugin);

                        return false;
                    }
                }
            }
        }
    }

    // Add plugin's Admin group to the Root user group
    // (assumes that the Root group's ID is always 1)
    if (count($groups) > 0) {
        if ($verbose) {
            COM_errorLog("Attempting to give all users in the Root group access to the '$plugin' Admin group", 1);
        }

        foreach ($groups as $key => $value) {
            DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES "
                . "($value, NULL, 1)");
            if (DB_error()) {
                COM_errorLog('Error adding plugin admin group to Root group', 1);
                PLG_uninstall($plugin);

                return false;
            }
        }
    }

    // Pre-populate tables or run any other SQL queries
    if (count($DEFVALUES) > 0) {
        if ($verbose) {
            COM_errorLog('Inserting default data', 1);
        }
        foreach ($DEFVALUES as $sql) {
            $sql = str_replace('#group#', $admin_group_id, $sql);
            DB_query($sql, 1);
            if (DB_error()) {
                COM_errorLog('Error adding plugin default data', 1);
                PLG_uninstall($plugin);

                return false;
            }
        }
    }

    // Load the online configuration records
    $load_config = 'plugin_load_configuration_' . $plugin;
    if (function_exists($load_config)) {
        if (!$load_config($plugin)) {
            COM_errorLog('Error loading plugin configuration', 1);
            PLG_uninstall($plugin);

            return false;
        }

        require_once $_CONF['path'] . 'system/classes/config.class.php';
        $config = config::get_instance();
        $config->initConfig(); // force re-reading, including new plugin conf
    }

    // Finally, register the plugin with Geeklog
    if ($verbose) {
        COM_errorLog("Registering '$plugin' plugin", 1);
    }

    // silently delete an existing entry
    DB_delete($_TABLES['plugins'], 'pi_name', $plugin);

    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) VALUES "
        . "('$plugin', '$pi_version', '$pi_gl_version', '$pi_homepage', 1)");

    if (DB_error()) {
        COM_errorLog('Failed to register plugin', 1);
        PLG_uninstall($plugin);

        return false;
    }

    // give the plugin a chance to perform any post-install operations
    $post_install = 'plugin_postinstall_' . $plugin;
    if (function_exists($post_install)) {
        if (!$post_install($plugin)) {
            COM_errorLog('Plugin postinstall failed', 1);
            PLG_uninstall($plugin);

            return false;
        }
    }

    if ($verbose) {
        COM_errorLog("Successfully installed the '$plugin' plugin!", 1);
    }

    // load plugin here already, for any plugins wanting to act on
    // PLG_pluginStateChange($plugin, 'installed') when we return from here
    require_once $_CONF['path'] . 'plugins/' . $plugin . '/functions.inc';

    return true;
}

/**
 * See if we can figure out the plugin's real name
 *
 * @param    string $plugin internal name / directory name
 * @return   string              real or beautified name
 */
function plugin_get_pluginname($plugin)
{
    global $_CONF;

    $retval = '';

    $plugins_dir = $_CONF['path'] . 'plugins/';
    $autoinstall = $plugins_dir . $plugin . '/autoinstall.php';

    // for new plugins, get the name from the autoinstall.php
    if (file_exists($autoinstall)) {
        require_once $autoinstall;

        $fn = 'plugin_autoinstall_' . $plugin;
        if (function_exists($fn)) {
            $info = $fn($plugin);
            if (is_array($info) && isset($info['info']) &&
                isset($info['info']['pi_display_name'])
            ) {
                $retval = $info['info']['pi_display_name'];
            }
        }
    }

    if (empty($retval)) {
        // give up and fake it
        $retval = ucwords(str_replace('_', ' ', $plugin));
    }

    return $retval;
}



















/**
* Bring up plugin search 
*
*/
function pluginsearch($token=null)
{
    global $_CONF, $_TABLES, $_USER, $LANG32, $LANG_ADMIN, $_IMAGE_TYPE;

    $retval = '';
    
    $plg_templates = new Template($_CONF['path_layout'] . 'admin/plugins');
    $plg_templates->set_file('search', 'search.thtml');
    $plg_templates->set_var('xhtml', XHTML);
    $plg_templates->set_var('site_url', $_CONF['site_url']);
    $plg_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $plg_templates->set_var('layout_url', $_CONF['layout_url']);
    $plg_templates->set_var('start_block_editor', COM_startBlock ($LANG32[305],
            '', COM_getBlockTemplate ('_admin_block', 'header')));
    $plg_templates->set_var('lang_search', $LANG_ADMIN['search']);
    $plg_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $plg_templates->set_var('lang_306', $LANG32[306]);
    $plg_templates->set_var('lang_307', $LANG32[307]);
    $plg_templates->set_var('lang_308', $LANG32[308]);
    $plg_templates->set_var('lang_309', $LANG32[309]);
    $plg_templates->set_var('lang_310', $LANG32[310]);
    $plg_templates->set_var('lang_320', $LANG32[320]);
    $plg_templates->set_var('gltoken', $token);
    $plg_templates->set_var('gltoken_name', CSRF_TOKEN);

    // Get DB info about current repositories
    $result = DB_query("SELECT * FROM {$_TABLES['plugin_repository']};");
    $d2 = "";
    
    while ( ($result2 = DB_fetchArray($result)) !== FALSE) {
        $d2 .= "<option value=\"{$result2['repository_url']}\">{$result2['repository_url']}</option>";
    }
    
    $plg_templates->set_var('value_0', $d2);
    
    /**
    * @todo Not sure where $pi_name comes from - use default icon for now
    * $plg_templates->set_var('pi_icon', PLG_getIcon($pi_name));
    */
    $plg_templates->set_var('pi_icon',
            $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE);
    $plg_templates->set_var('end_block',
            COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));

    $retval .= $plg_templates->finish($plg_templates->parse('output', 'search'));

    return $retval;
}


/**
* Show plugin results from search
*
* @param    string  $message    (optional) message to display
* @return   string              HTML for the plugin screen
*
*/
function plugin_showresults($message = '')
{
    global $LANG32;

    $retval = '';

    $retval .= COM_siteHeader('menu', $LANG32[5]);
    if (!empty($message)) {
        $retval .= COM_showMessageText($message);
    } else {
        $retval .= COM_showMessageFromParameter();
    }

    $token = SEC_createToken();
    $retval .= listsearchedplugins($token);

    $retval .= COM_siteFooter();

    return $retval;
}

/**
* List search results
*
* @param    string  $token  Security token
* @return   string          formatted list of plugins
*
*/
$REPOSITORY = array();
function listsearchedplugins($token)
{
    global $_CONF, $_TABLES, $LANG32, $LANG_ADMIN, $_IMAGE_TYPE, $REPOSITORY;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG32[16], 'field' => 'name', 'sort' => false),
        array('text' => $LANG32[17], 'field' => 'version', 'sort' => false),
        array('text' => $LANG32[318], 'field' => 'repository_name', 'sort' => false),
        array('text' => $LANG32[313], 'field' => 'state', 'sort' => false),
        array('text' => $LANG32[312], 'field' => 'downloads', 'sort' => false),
        array('text' => $LANG32[311], 'field' => 'install', 'sort' => false)
    );

    $defsort_arr = array('field' => 'name', 'direction' => 'asc');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home']),
                    
                    array('url' => 'plugins.php?mode=chkupdates',
                          'text' => $LANG32[301]),
                    array('url' => 'plugins.php?mode=lstrepo',
                          'text' => $LANG32[302]),
                    array('url' => 'plugins.php?mode=updatelist',
                          'text' => $LANG32[304])
                                                );

    $retval .= COM_startBlock($LANG32[5], '',
                              COM_getBlockTemplate('_admin_block', 'header'));
                              
    $retval  .= "<script type='text/javascript'>var MALICIOUS_PLUGIN_WARN = Array(); MALICIOUS_PLUGIN_WARN['warning'] = '{$LANG32[321]}';MALICIOUS_PLUGIN_WARN['msg'] = '{$LANG32[322]}'; MALICIOUS_PLUGIN_WARN['msg2'] = '{$LANG32[323]}';MALICIOUS_PLUGIN_WARN['cancel'] = '{$LANG32[324]}';MALICIOUS_PLUGIN_WARN['install'] = '{$LANG32[325]}';</script><div id='MALICIOUS_PLUGIN_WARN' class='pluginfo' style='display:none'></div>";
    
    // Get all repositories, get types (1 = banned, 2 = no idea, 3 = white listed)
    $result = DB_query("SELECT * FROM {$_TABLES['plugin_repository']} WHERE enabled = 1;");
    
    while ( ($result2 = DB_fetchArray($result)) !== FALSE) {
        // Set data = value
        $REPOSITORY[$result2['repository_url']] = $result2['status'];
    }

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG32[314],
        $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE
    );

    $text_arr = array(
        'has_extras'   => false,
        'instructions' => $LANG32[314],
        'form_url'     => $_CONF['site_admin_url'] . '/plugins.php'
    );
    
    // Get POST values
    $name = (isset($_POST['plugin_name'])) ? COM_applyFilter($_POST['plugin_name']) : "";
    $version = (isset($_POST['plugin_version'])) ? COM_applyFilter($_POST['plugin_version']) : "";
    $repository = (isset($_POST['plugin_repo'])) ? COM_applyFilter($_POST['plugin_repo']) : "";
    
    // Parse name field, take out AND, strip white space around AND signs, and each plus sign is exploded making it an array
    $n_array = explode("AND", $name);
    $count = 0;
    $name_str = "";
    $count_or = 0;
    
    // Tims parsing algorithm. Nothing to look at, moving on...
    foreach ($n_array as $value) {
        // Trim whitespace
        $trimmed = trim($value);
        
        // Explode value again, and check for ORS
        $ors = explode("OR", $trimmed);
        // Ham OR Chili AND Bacon OR Eggs OR Tim is hungry
        // Above evaluated as: (Ham OR Chili) AND (Bacon OR Eggs OR Tim is hungry)
        // Are there any ors, nors, or xors?
        // And why are you still reading this - Move Along!
        if (count($ors) > 1) {
            foreach ($ors as $jors) {
                $jors = trim($jors);
                if ( ($count_or === 0) and ($count === 0)) {
                    $name_str .= " name LIKE '%{$jors}%'";
                    $count_or++;
                    $count++;
                }
                else {
                    $name_str .= " OR name LIKE '%{$jors}%'";
                }
            }
            
            // Move Along
            continue;
        }
        
        // Moving along means SKIPPING from one brace of the first foreach to the last brace
        if ($count === 0) {
            // Start off the string with no AND
            $name_str .= " name LIKE '%{$trimmed}%'";
            $count++;
        }
                
        $name_str .= " AND name LIKE '%{$trimmed}%'";
        
    }
    
    // Yay you have moved along, and I have wasted precious time writing nonsense comments :P
    $query_arr = array(
        'table' => 'plugin_repository_list',
        'sql' => "SELECT * FROM {$_TABLES['plugin_repository_list']} WHERE {$name_str} AND version LIKE '%{$version}%' AND repository_name LIKE '%{$repository}%'",
        'query_fields' => array('name'),
        'default_filter' => ''
    );

    // this is a dummy variable so we know the form has been used if all plugins
    // should be disabled in order to disable the last one.
    $form_arr = array('bottom' => '<input type="hidden" name="pluginenabler" value="true"' . XHTML . '>');

    $retval .= ADMIN_list('plugin_repository_list', 'ADMIN_getListField_repository', $header_arr,
                $text_arr, $query_arr, $defsort_arr, '', $token, '', $form_arr, true);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
* Show repository listing
*
* @param    string  $message    (optional) message to display
* @return   string              HTML for the plugin screen
*
*/
function plugin_showrepos($message = '')
{
    global $LANG32;

    $retval = '';

    if (!empty($message)) {
        $retval .= COM_showMessageText($message);
    } else {
        $retval .= COM_showMessageFromParameter();
    }

    $token = SEC_createToken();

    $retval .= listrepositories($token);

    $retval .= COM_siteFooter();

    return $retval;
}

/**
* Lists repositories
*
* @param    string  $token  Security token
* @return   string          formatted list of repositories
*
*/
function listrepositories($token)
{
    global $_CONF, $_TABLES, $LANG32, $LANG_ADMIN, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG32[319], 'field' => 'repository_url', 'sort' => false),
        array('text' => $LANG_ADMIN['enabled'] . ' / ' . $LANG_ADMIN['delete'], 'field' => 'enabled', 'sort' => false)
    );

    $defsort_arr = array('field' => 'repository_url', 'direction' => 'asc');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home']),
                    
                    array('url' => 'plugins.php?mode=chkupdates',
                          'text' => $LANG32[301]),
                    array('url' => 'plugins.php?mode=lstrepo',
                          'text' => $LANG32[302]),
                    array('url' => 'plugins.php?mode=updatelist',
                          'text' => $LANG32[304])
                                                );

    $retval .= COM_startBlock($LANG32[348], '',
                              COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG32[349],
        $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE
    );
    
    $text_arr = array(
        'has_extras'   => false,
        'instructions' => $LANG32[314],
        'form_url'     => $_CONF['site_admin_url'] . '/plugins.php?cmd=lstrepo'
    );
        
    $query_arr = array(
        'table' => 'plugin_repository',
        'sql' => "SELECT repository_url, enabled FROM {$_TABLES['plugin_repository']}",
        'query_fields' => array('repository_url'),
        'default_filter' => ''
    );

    // this is a dummy variable so we know the form has been used if all plugins
    // should be disabled in order to disable the last one.
    $form_arr = array('bottom' => '<input type="hidden" name="pluginenabler" value="true"' . XHTML . '>');

    $retval .= ADMIN_list('plugin_repository', 'ADMIN_getListField_repositorylisting', $header_arr,
                $text_arr, $query_arr, $defsort_arr, '', $token, '', $form_arr, false);
                
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
    
    $retval .= show_add_repo();

    return $retval;
}

/**
* Show the add repository template
*
*/
function show_add_repo()
{
    global $_CONF, $LANG_ADMIN, $LANG32, $_IMAGE_TYPE;

    $retval = '';
    
    // Templates
    $plg_templates = new Template($_CONF['path_layout'] . 'admin/plugins');
    $plg_templates->set_file('add_repo', 'add_repo.thtml');
    $plg_templates->set_var('xhtml', XHTML);
    $plg_templates->set_var('site_url', $_CONF['site_url']);
    $plg_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $plg_templates->set_var('layout_url', $_CONF['layout_url']);
    $plg_templates->set_var('start_block_editor', COM_startBlock ($LANG32[303],
            '', COM_getBlockTemplate ('_admin_block', 'header')));
    $plg_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $plg_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    /**
    * @todo Not sure where $pi_name comes from - use default icon for now
    * $plg_templates->set_var('pi_icon', PLG_getIcon($pi_name));
    */
    $plg_templates->set_var('pi_icon',
            $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE);
    $plg_templates->set_var('lang_repourl', $LANG32[319]);
    $plg_templates->set_var('gltoken', SEC_createToken());
    $plg_templates->set_var('gltoken_name', CSRF_TOKEN);
    $plg_templates->set_var('end_block',
            COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer')));

    $retval .= $plg_templates->finish($plg_templates->parse('output', 'add_repo'));

    return $retval;
}

/**
* Add repository listing
*
*/
function add_repository()
{
    // Globals 
    global $_TABLES, $_CONF;
    
    // Get POST value
    $repository_url = (isset($_POST['repository_url'])) ? COM_applyFilter($_POST['repository_url']) : null;
    
    // Cannot be false, must be valid page http://geeklog.tim/geeklog-1.6.0b1/public_html/repository/main
    if ( ($repository_url === NULL) or (ereg('^http://[a-zA-Z0-9\-\./_\-]+/repository/main', $repository_url) === FALSE) ) {
        header("Location: plugins.php?mode=lstrepo&msg=504");
        return;
    }

    // Now check validate repository
    include "HTTP/Request.php";
    $a = new HTTP_Request( $_CONF['geeklog_auth_service'] . 'repositorylisting/check_repository.php?repository='.rawurlencode($repository_url));
    $a->sendRequest();
    
    // If the content-length is 0, it looks like an error occurred
    $header = $a->getResponseHeader();

   if ( ($header['content-length'] == 0) or ($a->getResponseCode() != 200)) {
        // Error, redirect
        header("Location: plugins.php?mode=lstrepo&msg=507");
        return;
    }

    $body = $a->getResponseBody();
    $status = unserialize($body);
    
    if ($status == FALSE) {
        header("Location: plugins.php?mode=lstrepo&msg=507");
        return;
    }
    else if ($status == 3) {
        $status = 3;
    }
    else if ($status == 1) {
        header("Location: plugins.php?mode=lstrepo&msg=506");
        return;
    }
    else
    {
        $status = 2;
    }

    // Now lets see if the repository actually exists - if not, then we will notify the user that they may have made an error
    $a = new HTTP_Request($repository_url. '/status.rep');
    $a->sendRequest();
   
    // It must be 200 to exist (and status.rep must hold 200 to exist)
    $code = $a->getResponseCode();
    $body = unserialize($a->getResponseBody());
    
    if ( ($code != 200) or ($body !== 200)) {
        header("Location: plugins.php?tmsg=508&enable_spf=1&code={$code}&host=".rawurlencode($repository_url));
        return;    
    }
    
 
    // Add to database
    DB_query("INSERT INTO {$_TABLES['plugin_repository']}(repository_url, enabled, status) VALUES('{$repository_url}',1, {$status});");
    
    header("Location: plugins.php?mode=lstrepo&msg=505");
}

/**
* Check for updates to repository (reload)
*
*/
function updaterepositorylist()
{
    global $_CONF, $_TABLES, $_USER, $LANG32, $LANG_ADMIN;
    
    // For each repository listing
    $query = "SELECT * FROM {$_TABLES['plugin_repository']} WHERE enabled = 1;";
    $result = DB_query($query);
    
    // Truncate Table
    DB_query("TRUNCATE {$_TABLES['plugin_repository_list']};");
    $some_repos = array();
    
    // Loop through listings
    while ( ($result2 = DB_fetchArray($result)) !== FALSE) {
        // XML Pull
        $reader = new XMLReader();

        $boolean = @$reader->open($result2['repository_url']. '/cmd/list.php');
        if ($boolean === FALSE) {
            $some_repos[] = $result2['repository_url'];
            continue;
        }
        
        $plugin = false;
        $array_of_values = array();
        $array_of_key_gen = array(
            'id' => false,
            'name' => false,
            'version' => false, 
            'db' => false, 
            'dependencies' => false, 
            'soft_dep' => false, 
            'short_des' => false, 
            'credits' => false, 
            'vett' => false, 
            'downloads' => false, 
            'install' => false, 
            'state' => false, 
            'ext' => false,
            'fname' => false

        );
 
        while ($reader->read()) {
              // Process 
              
              if($reader->name == "plugin") {
                  // New plugin section
                  if($plugin == false) {
                      $plugin = true;
            
                  }
                  else {  
                      $plugin = false; 
                      
                      // Insert into the repository listing database the values
                      $query = "INSERT INTO {$_TABLES['plugin_repository_list']} (plugin_id, name, repository_name, version, db, dependencies, soft_dep, short_des, credits, vett, downloads, install, state, ext, fname) VALUES('{$array_of_values['id']}','{$array_of_values['name']}', '{$result2['repository_url']}', '{$array_of_values['version']}','{$array_of_values['db']}','{$array_of_values['dependencies']}','{$array_of_values['soft_dep']}','{$array_of_values['short_des']}','{$array_of_values['credits']}','{$array_of_values['vett']}','{$array_of_values['downloads']}','{$array_of_values['install']}','{$array_of_values['state']}','{$array_of_values['ext']}', '{$array_of_values['fname']}');";
                      
                      // Insert into database
                      DB_query($query);
                      
                      foreach ($array_of_key_gen as $key => $value) {
                          $array_of_key_gen[$key] = false;  
                      }
              
                  }
              }

              switch ($reader->name) {
                  case "id":
                  case "name":
                  case "fname":
                  case "version":
                  case "db":
                  case "dependencies":
                  case "soft_dep":
                  case "short_des":
                  case "credits":
                  case "vett":
                  case "downloads":
                  case "install":
                  case "state":
                  case "ext":
                      $name = $reader->name;
                      if ($array_of_key_gen[$name] == false) {
                          $reader->read();
                          $array_of_values[$name] = $reader->value;
                          $array_of_key_gen[$name] = true;
                      }
                      break;
                  default:

                      break;
              }

        }

        $reader->close();

    }
    
    return $some_repos;
}

/** 
* Set uploaded plugin for install, and download to tmp directory, for unpacking purposes
* @param    int    $id    Plugin ID from the repository
* @param    boolean $value  TRUE if ok repository, FALSE if unknown repository
* @return    RESULT from plugin_upload():HTML      
*/
function plugin_install_repo($id, &$value)
{
    global $_CONF, $_TABLES;
    
    // Get the plugin file name, download it, and move it to the /data folder for processing.
    $id = (int)$id; 

     $result = DB_query("SELECT repository_name, name, version, state, ext FROM {$_TABLES['plugin_repository_list']} WHERE plugin_id = {$id};");
    
    // Loop until we receive false
    $result2 = DB_fetchArray($result);

    // Did it succeed
    if ($result2 === FALSE) {
        // Cannot install, error message, exit
        header("Location: plugins.php?msg=501");
    }

    // Download the file
    $get_path = $result2['repository_name'] . '/get.php?pid='.$id;
    $local = $_CONF['path_data'] . $result2['name'] . '_' . $result2['version'] . '_' . $result2['state'] . '_' . $result2['plugin_id'] . $result2['ext'];

    // We want to download the file to the /data folder
    $fresult = download_file($get_path, $local);
    
    // Error?
    if ($fresult === FALSE) {
        // Error downloading file, may not exist, may be moved. Notify user that they may need to refresh their repository listing
        header("Location: plugins.php?msg=501");
    }
    
    // It worked, now lets send the path to the plugin_install utility
    return plugin_upload($local);
}


/** 
* This function downloads the plugin from the repository to the user
* @param    int    $id    Plugin ID from the repository
* 
* @return    false   
*/
function plugin_download_repo($id)
{
    global $_CONF, $_TABLES;
    
    // Get the plugin file name, download it, and move it to the /data folder for processing.
    $id = (int)$id; 

    $result = DB_query("SELECT repository_name FROM {$_TABLES['plugin_repository_list']} WHERE plugin_id = {$id};");
    
    // Loop until we receive false
    $result2 = DB_fetchArray($result);

    // Did it succeed
    if ($result2 === FALSE) {
        // Cannot install, error message, exit
        header("Location: plugins.php?msg=501");
    }

    // Download the file
    $get_path = $result2['repository_name'] . '/get.php?pid='.$id;
    header("Location: {$get_path}");
 
 }

/** 
* Download file from the repository, or any place for that matter
* @param    string    $file: The URI to the file to download
* @param    string    $local_file: The file name for the download to be saved as, including extension, and path
* @param    &integer  $curl_error: A reference to a local variable, where, if not null, will hold the curl_error in case of an error, for trouble shooting 
*                                  Note: The value of the local variable must NOT be null
*
* @return   boolean   true: Success, false, error     
*/

function download_file($file, $local_file, &$curl_error = null)
{
    // Attempt file out write (on local disk, writing as binary to protect data)
    $out = fopen($local_file, 'wb'); 
    // In case of errors, bail out
    if ($out === FALSE){
        return false; 
    } 
    
    // Now we need to see if we need to use HTTP_REQUEST over CURL (which is better in so many ways - faster, better memory usage, etc)
    // The ideal solution is to use CURL, so we check to see if curl functions are ready enabled
    if (function_exists(curl_init)) {
        // It exist, the best thing to do is to use it
            
        // Start CURL
        $ch = curl_init(); 
    
        // Set handles   
        // My reasoning for using CURL is well its better than HTTP_REQUEST :D
        curl_setopt($ch, CURLOPT_FILE, $out); 
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); // This is essential as I found out since the server redirects. This is supposed to be defaulted to true I thought in PHP5.. Hmm the surprises of coding :P
        curl_setopt($ch, CURLOPT_URL, $file); 
    
        // Execute              
        curl_exec($ch); 
    
        // In case of any errors
        $errno = curl_errno($ch);
        if (!$errno) {
            // Only if curl_error is set, then do we set the error value to it
            if ($curl_error !== NULL) {
                // Set value
                $curl_error = $errno;
        
                curl_close($ch); 
                fclose($out); 
                return false;
            }
        }
    
        curl_close($ch); 
    }
    else
    {
        // Oops - Curl is not enabled. This sucks so we use the slower HTTP_REQUEST, which is also depreciated in favor of HTTP_REQUEST2, 
        // which at the time of writing is still in alpha release.. but it fixes this mess
        include "HTTP/Request.php";
        
        // Due to HTTP_REQUESTS horrible redirect support, we keep allowRedirects false, and do it ourselves
        $a = new HTTP_Request('', $param);
        $a->setUrl($get_path); 
        $a->sendRequest();
        
        // Failure to get anything.. does not exist
        if ($a->getResponseCode() != 200) {
            return false;
        }
        
        // Get the redirect response, and store the array in a variable, so we can then re send a request to that new URL
        $headers = $a->getResponseHeader();
        $a->setURL($result2['repository_name'] . '/' . rawurlencode($headers['location']));
        $a->sendRequest();
        
        // Write out binary output to a file
        $fvalue = fwrite($out, $a->getResponseBody());
        
        if ($fvalue === FALSE) {
            fclose($out);
            return false;
        }
    }
    
    fclose($out);
    
    return true; 

}
/**
* Show updates available
*
*/
function show_available_updates($message=false)
{
    global $_CONF, $_TABLES, $LANG32, $LANG_ADMIN, $_IMAGE_TYPE, $REPOSITORY, $LANG09;

    require_once $_CONF['path_system'] . 'lib-admin.php';
    
    // Check repository
    check_repository_lists();
    
    // We need to connect to the XML file, and return the data dictating the 
    $retval = '';
    
    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home']),                    
                    array('url' => 'plugins.php?mode=chkupdates',
                          'text' => $LANG32[301]),
                    array('url' => 'plugins.php?mode=lstrepo',
                          'text' => $LANG32[302]),
                    array('url' => 'plugins.php?mode=updatelist',
                          'text' => $LANG32[304])
                                                );

    $retval .= COM_startBlock($LANG32[329], '',
                              COM_getBlockTemplate('_admin_block', 'header'));
                              
    if ($message) {
        $retval .= COM_showMessageText($message);
    }

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG32[350],
        $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE
    );
    
    $form = '<input type="submit" name="install_updates" value="'. $LANG32[332] .'" />';
    
    // Heading 
    $heading = '<th class="admin-list-headerfield">'. $LANG32[16] .'</th><th class="admin-list-headerfield">'. $LANG32[330] .'</th><th class="admin-list-headerfield">'. $LANG32[331] .'</th><th class="admin-list-headerfield">'. $LANG32[22] .'</th>';
    $data = '';
    $data_up = '';
    $heading_up = '<th class="admin-list-headerfield">'. $LANG32[16] .'</th><th class="admin-list-headerfield">'. $LANG32[17] .'</th><th class="admin-list-headerfield">'. $LANG32[22] .'</th>';
    
    // And now check for updates
    $ap = array();
    $update_count = 0;
    $upgrade_count = 0;
    $final_array = array();
 
    // For each plugin in the plugins table
    $result = DB_query("SELECT pi_name, pi_version, pi_update_count FROM {$_TABLES['plugins']} WHERE pi_enabled = '1';");
    
    // Loop for each installed plugin, until FALSE reached
    while ( ($result2 = DB_fetchArray($result)) !== FALSE) {
        // Attempt to retreive the listing from the repository local copy, to get the plugin ID
        $result3 = DB_query("SELECT plugin_id, repository_name FROM {$_TABLES['plugin_repository_list']} WHERE fname = '{$result2['pi_name']}' AND version = '{$result2['pi_version']}';");
    
        // Do query
        $result4 = DB_fetchArray($result3);
        
        // Plugin must not exist in the repository anymore.. how sad
        if ($result4 === FALSE) {
            continue;
        }
        
        // Load up array with repository_name, and the plugin_id, and version
        $ap[$result4['repository_name']][$result4['plugin_id']] = array($result2['pi_version'], $result2['pi_update_count']); 
        
    }

    // Get all repositories, get types (1 = banned, 2 = no idea, 3 = white listed)
    $result = DB_query("SELECT * FROM {$_TABLES['plugin_repository']} WHERE enabled = 1;");
    
    while ( ($result2 = DB_fetchArray($result)) !== FALSE) {
        // Set data = value
        $REPOSITORY[$result2['repository_url']] = $result2['status'];
    }

    // Read through XML
    // For each repository listing
    $css_style = 1;
    $css_style2 = 1;
    
    // Loop through listings
    foreach ($ap as $repository => $plugin_value) {
        // XML Pull
        $data = "REPOSITORY_ARRAY_PATCHES=".rawurlencode(serialize($plugin_value));
        
        $result = do_post_request($repository. '/cmd/nchkpdate.php?cmd=2', $data);        

        // Did it fail (if so, we don't do anything)
        if ( ($result === FALSE) ) {
            continue;
        } 
        $data = '';
        
        // Check repository
        if ($REPOSITORY[$repository] == 3) {
            $st_repo = '';
            $titular = '';
        }
        else {
            $st_repo = '<span style="color:red">' . $LANG32[336] . '</span>';
            $titular = "<span style='color:red'>&nbsp;{$LANG32[346]}</span>";
        }
        
        $reader = new XMLReader();
       
        $reader->xml($result);
        $plugin = false;
        $array_of_values = array();
        $array_of_key_gen = array(
            'id' => false,
            'name' => false,
            'applies_num' => false, 
            'version' => false, 
            'severity' => false, 
            'plugin_id' => false, 
            'severity' => false, 
            'automatic_install' => false, 
            'ext' => false, 
            'description' => false, 
            'update_number' => false

        );
        
        // And now for upgrades
        $upgrade = false;
        $array_of_uvalues = array();
        $array_of_up_gen = array(
            'upgrade_version' => false,
            'upgrade_name' => false,
            'upgrade_id' => false,
            'upgrade_pluginid' => false,
            'upgrade_version2' => false,
            'upgrade_autoinstall' => false,
            'upgrade_ext' => false,
            'upgrade_des' => false
        );

         while ($reader->read()) {
              // Process 
              
              if($reader->name == "patch") {
                  // New plugin section
                  if($plugin == false) {
                      $plugin = true;
            
                  }
                  else {  
                      $plugin = false; 
                      
                      // What CSS style is it
                      if ($css_style === 1) {
                          $css_style = 2;
                      }
                      else {
                          $css_style = 1;
                      }
                      
                      if ($array_of_values['automatic_install'] == '1') {
                          $fsn = "<input type='checkbox' name='{$array_of_values['id']}' value='{$repository},{$array_of_values['ext']},{$array_of_values['name']},{$array_of_values['update_number']},update' checked='checked' />";
                          $psg = '';
                      }
                      else {
                          $fsn =  "<input type='button' name='postmsg' value='{$LANG32[316]}' />";                  
                          $psg = $LANG32[335];
                      }
 
                      // Insert into variable
                      $des = ($array_of_values['description'] == '') ? '('. $LANG32[345] .')' : $array_of_values['description'];
                      $data .= <<<MONSTERS
<tr class="pluginRow{$css_style}" onmouseover="className='pluginRollOver';" onmouseout="className='pluginRow{$css_style}';">
<td class="admin-list-field"><a href='javascript:void();' onclick='javascript:smart_toggle_datalink("DISPLAY_DATA{$array_of_values['id']}",event);'>{$array_of_values['name']}</a> <div class='plugin_data' style='display:none' id='DISPLAY_DATA{$array_of_values['id']}'><img style='float:right' onclick='javascriprt:hide_datalink("DISPLAY_DATA{$array_of_values['id']}");' alt='Close' src='{$_CONF['site_url']}/images/close.gif' /><b>{$array_of_values['name']}</b><br /><br />{$titular}<br /><br /><b>{$LANG32[340]}</b><br />{$des}<br /><br /><input type="button" name='bargain' onclick="window.location = '{$repository}/patches/get_patch.php?pid={$array_of_values['id']}';" value='{$LANG32[316]}' /></div> {$psg} {$st_repo}</td>      
<td class="admin-list-field">{$array_of_values['version']}</td>
<td class="admin-list-field">{$array_of_values['severity']}</td>
<td class="admin-list-field">{$fsn}</td>
</tr>                      
MONSTERS;
                      foreach ($array_of_key_gen as $key => $value) {
                          $array_of_key_gen[$key] = false;  
                      }
              
                  }
              }
              else if ($reader->name == "upgrade") {
                  if ($upgrade == FALSE) {
                      $upgrade = true;
                  }
                  else {
                      $upgrade = false;
                      
                      if ($css_style2 === 1) {
                          $css_style2 = 2;
                      }
                      else {
                          $css_style2 = 1;
                      }

                      if ($array_of_uvalues['upgrade_autoinstall'] == '1') {
                          $fsn2 = "<input type='checkbox' name='{$array_of_uvalues['upgrade_id']}' value='{$repository},{$array_of_uvalues['upgrade_ext']},{$array_of_uvalues['upgrade_name']},{$array_of_uvalues['upgrade_version']},upgrade' checked='checked' />";
                          $psg2 = '';
                      }
                      else {
                          $fsn2 =  "<input type='button' name='postmsg' value='{$LANG32[316]}' />";                  
                          $psg2 = $LANG32[335];
                      }

                      $data_up .= <<<UPGRADE
<tr class="pluginRow{$css_style2}" onmouseover="className='pluginRollOver';" onmouseout="className='pluginRow{$css_style2}';">
<td class="admin-list-field"><a href='javascript:void();' onclick='javascript:smart_toggle_datalink("DISPLAY_DATA2{$array_of_uvalues['upgrade_id']}",event);'>{$array_of_uvalues['upgrade_name']}</a> <div class='plugin_data' style='display:none' id='DISPLAY_DATA2{$array_of_uvalues['upgrade_id']}'><img style='float:right' onclick='javascriprt:hide_datalink("DISPLAY_DATA2{$array_of_uvalues['upgrade_id']}");' alt='Close' src='{$_CONF['site_url']}/images/close.gif' /><b>{$array_of_uvalues['upgrade_name']}</b><br /><br />{$titular}<br /><br /><b>{$LANG32[340]}</b><br />{$array_of_uvalues['upgrade_des']}<br /><br /><input type="button" name='bargain' onclick="window.location = '{$repository}/upgrades/get_upgrade.php?pid={$array_of_uvalues['upgrade_id']}';" value='{$LANG32[316]}' /></div> {$psg2} {$st_repo}</td>      
<td class="admin-list-field">{$array_of_uvalues['upgrade_version2']} {$LANG09[21]} {$array_of_uvalues['upgrade_version']}</td>
<td class="admin-list-field">{$fsn2}</td></tr>                  
UPGRADE;

                      foreach ($array_of_up_gen as $key => $value) {
                          $array_of_up_gen[$key] = false;  
                      }
                      
                  }
              }

              switch ($reader->name) {
                  case "id":
                  case "name":
                  case "plugin_id":
                  case "applies_num":
                  case "version":
                  case "severity":
                  case "automatic_install":
                  case "ext":
                  case "description":
                  case "update_number":
                      $name = $reader->name;
                      if ($array_of_key_gen[$name] == false) {
                          $reader->read();
                          $array_of_values[$name] = $reader->value;
                          $array_of_key_gen[$name] = true;
                      }      
                      break;
                  case "upgrade_id":
                  case "upgrade_pluginid":
                  case "upgrade_version2":
                  case "upgrade_name":
                  case "upgrade_version":
                  case "upgrade_autoinstall":
                  case "upgrade_ext":
                  case "upgrade_des":
                      $name = $reader->name;
                      if ($array_of_up_gen[$name] == false) {
                          $reader->read();
                          $array_of_uvalues[$name] = $reader->value;
                          $array_of_up_gen[$name] = true;
                      }                                    
                      break; 
                  default:

                      break;
              }

        }

        $reader->close();

    }
   
   $msg = '<br /><div class="alignleft"><div class="block-divider"></div><div class="aligncenter"><div class="block-divider"></div></div>' . $LANG32[328] . '<br /><br />';
    // No updates, no heading
    if ($data == "") {
        $data = '';
        $heading = '';
        $rbb = '';
        $msg = '';
    }
    
    $msg2 = '<br /><div class="block-divider"></div></div><div class="alignleft"><div class="block-divider"></div>'.$LANG32[334].'<br /><br />';
    // No upgrades, no heading
    if ($data_up == "") {
        $heading_up = '';
        $msg2 = '';
    }
    
    // Should we display that there are none of either available?
    if ( ($data == '') and ($data_up == '')) {
        $data = '<br />'.$LANG32[333].'<br /><br />';
        $form = '';
    }

    $admin_templates = new Template($_CONF['path_layout'] . 'admin/lists');
    $admin_templates->set_file (array (
        'list'   => 'list2.thtml')
    );
    # insert std. values into the template
    $admin_templates->set_var('xhtml', XHTML);
    $admin_templates->set_var('site_url', $_CONF['site_url']);
    $admin_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $admin_templates->set_var('layout_url', $_CONF['layout_url']);
    $admin_templates->set_var('header_row', $heading);
    $admin_templates->set_var('header_row2', $heading_up);
    $admin_templates->set_var('install_button', $form);
    $admin_templates->set_var('form_url', 'plugins.php');
    $admin_templates->set_var('msg1', $msg);
    $admin_templates->set_var('msg2', $msg2);    
    $admin_templates->set_var('item_row', $data);
    $admin_templates->set_var('item_row2', $data_up);
    $admin_templates->parse('output', 'list');
    $retval .= $admin_templates->finish($admin_templates->get_var('output'));

    return $retval;
}

$PLUGIN_UPDATE_SQL = array();
$PLUGIN_UPDATE_ERROR = false;

/**
  * Handle errors.
  *
  * This function handles errors when the update process is in session
  *
  * @param  int     $errno      Error Number.
  * @param  string  $errstr     Error Message.
  * @param  string  $errfile    The file the error was raised in.
  * @param  int     $errline    The line of the file that the error was raised at.
  * @param  array   $errcontext An array that points to the active symbol table at the point the error occurred.
  */
$ERROR_NOW = false;
function plugin_update_error_handler($errno, $errstr, $errfile='', $errline=0, $errcontext='')
{
   global $ERROR_NOW, $_CONF;
   echo $errstr, 'ON', $errline , ' IN ', $errfile;exit;
   // Doesn't know what to do here atm 
   $ERROR_NOW = true;   
   return true;
}

/**
* Function checks for updates to the REPOSITORY blacklist, and updates accordingly 
* @return void
*/
function check_repository_lists()
{
    // Declare Variables
    global $_CONF, $_TABLES;    
    
    // Do a repository listing update
    $list_repo = array();
    
    $result = DB_query("SELECT repository_url FROM {$_TABLES['plugin_repository']};");
    
    // Loop through results, storing them in an array to be sent off
    while ( ($result2 = DB_fetchArray($result)) !== FALSE) {
        $list_repo[] = $result2['repository_url'];
    }
    
    // Send off post data
    $data = "REPOSITORIES=".rawurlencode(serialize($list_repo));    
    $result = do_post_request($_CONF['geeklog_auth_service'] . 'repositorylisting/check_repository.php?cmd=update', $data);    
    $return_array = unserialize($result);
    // Did it return false, its ok
    if ( ($result === FALSE) or ($return_array === FALSE) or (count($return_array) < 1)) {
        
    }
    else {
        // We should get back an array like so:
        // ARRAY [repository_name] => state
        foreach ($return_array as $key => $value) {
            // Update DB
            $state = (int)$value;
            
            // Validate state
            if ($state === 1) {
                // Banned URL, must delete
                DB_query("DELETE FROM {$_TABLES['plugin_repository']} WHERE repository_name = '{$url}';");
            }
            else {
                $state = ($state === 3) ? 3 : 2;
                $url = COM_applyFilter($key);
                DB_query("UPDATE {$_TABLES['plugin_repository']} SET state = '{$state}' WHERE repository_name = '{$url}';");
            }
        }
    }
}

/**
* Function starts the update process
* @return return value
*/
function start_update_process()
{
    global $ERROR_NOW, $_CONF, $LANG32;
    require_once $_CONF['path_system'] . 'classes/pluginupdater.class.php';

    $PLUGIN_UPDATE = true;

    // Create instance of update class
    $update = new pluginupdater();

    // We loop over the POST values, for each one being an update
    foreach ($_POST as $name => $value) {
        // Since this will also pick up the submit button, we need to exclude it
        if ( ($name == "install_updates") or ($name == "bargain")) {
            continue;
        }

        $ERROR_NOW = false;
        
        // The way the POST values are set up is that the names are the patch_id.. Since checkboxes are only returned as POST values if they are not checked, then we are good to go as all coming here are checked.
        $id = (int)$name;
        $arr = explode(",", $value); // The value is : 
        // Get GETPATH, depending on whether update or upgrade
        if ($arr[4] == 'update') {
            $get_path = $arr[0] . '/patches/get_patch.php?pid='.$id;
        }
        else {
            $get_path = $arr[0] . '/upgrades/get_upgrade.php?pid='.$id;
        }
        
        $local =  $_CONF['path_data'] . 'patch_pid' . $id . COM_applyFilter($arr[1]);
        // Lets make a send request to the update page
        $fresult = download_file($get_path, $local);

        // Error?
        if ($fresult === FALSE) {
            // Error downloading file, may not exist, may be moved. Notify user that they may need to refresh their repository listing
            header("Location: plugins.php?tmsg=509&enable_spf=1&name=".$arr[2]);
            return;
        }    
        
        // Since it succeeded, lets keep on going
        // Try to unpack tarball, and get information about it
        
        // First thing is to do a full backup of the plugin's MYSQL data and the plugin's files
        
        // Now start unpack
        require_once $_CONF['path_system'] . 'classes/unpacker.class.php';
        require_once 'System.php';
        
        $archive = new unpacker($local);
        $tmp = $archive->getlist();
        $dirname = preg_replace('/\/.*$/', '', $tmp[0]['filename']); // Thanks matt for this regex :P
        
        if (empty($dirname)) { 
            PLData::failedupdate($arr[2], 100);
            continue;
        }
        
        // Install the update
        $archive->unpack($_CONF['path'].'data/');
        
echo "test";        
        // So all is good, we need to include the class file
        if (file_exists($_CONF['path'].'data/'.$dirname.'/update.php')) {
            require_once $_CONF['path'].'data/'.$dirname.'/update.php';
            
        }
        else {
            PLData::failedupdate($arr[2], 103);
            continue;
        }
echo "ha";
        // Include the class file that should exist, but first we need to make sure that the class even exists
        if ( (!class_exists('UpdatePlugin')) or (!(method_exists('UpdatePlugin', 'init')))) {
            PLData::failedupdate($arr[2], 101);
            continue;         
        }
        
        // Now we need to get the list of tables this plugin requires, the plugin name, and the SQL to perform
        $update->set_var($arr[4],'type');
        $update->set_var(UpdatePlugin::$_SQL_PTABLES, 'tbl');
        $update->set_var(UpdatePlugin::$_SQL_DATA, 'sql');
        $update->set_var(UpdatePlugin::$PLUGIN_NAME, 'pn');
        $update->set_var($dirname, 'dir');
        
        // And now we call the update process to start backups. As well, SQL will be performed, and files will be moved
        $result = $update->start();

        if ( ($result === FALSE) or ($ERROR_NOW === TRUE)) {
            $update->restore();
            $update->cleanup($local);
            PLData::failedupdate($arr[2], 102);
            continue;               
        }

        // Call the remaining Update::function if the update plugin user has any extra stuff to change
        $result = UpdatePlugin::init();
        
        if ( ($result === FALSE) or ($ERROR_NOW === TRUE)) {
            $update->restore();
            $update->cleanup($local);
            PLData::failedupdate($arr[2], 102);
            continue;               
        }

        $result = $update->finish($arr[3]);

        if ( ($result === FALSE) or ($ERROR_NOW === TRUE)) {
            $update->restore();
            $update->cleanup($local);
            PLData::failedupdate($arr[2], 102);
            continue;               
        }
 
        $update->cleanup($local);
        
    }

    // Now the updates have either been installed, or installation has failed
    $retval_tmp = PLData::report($LANG32[338] . '<br />');
    $retval = COM_siteHeader('menu', $LANG32[13]);
    $retval .= show_available_updates($retval_tmp);
    $retval .= COM_siteFooter();   
    return $retval;
}





































// MAIN
$display = '';
$mode = Geeklog\Input::postOrGet('mode', '');

if ($mode === 'delete') {
    $pi_name = Geeklog\Input::fGet('pi_name');
    if ((!empty($pi_name)) && SEC_hasRights('plugin.install')) {
        if ((Geeklog\Input::get('confirmed') == 1) && SEC_checkToken()) {
            $msg = do_uninstall($pi_name);
            if ($msg === false) {
                COM_redirect($_CONF['site_admin_url'] . '/plugins.php');
            } else {
                COM_redirect($_CONF['site_admin_url'] . '/plugins.php?msg=' . $msg);
            }
        } else { // ask user for confirmation
            $token = SEC_CreateToken();
            $message = $LANG32[31];
            $message .= "<form action='{$_CONF['site_admin_url']}/plugins.php' method='GET'><div>";
            $message .= "<input type='hidden' name='pi_name' value='" . $pi_name . "'" . XHTML . ">";
            $message .= "<input type='hidden' name='mode' value='delete'" . XHTML . ">";
            $message .= "<input type='hidden' name='confirmed' value='1'" . XHTML . ">";
            $message .= "<input type='hidden' name='" . CSRF_TOKEN . "' value='" . $token . "'" . XHTML . ">";
            $message .= "<input type='submit' value='{$LANG32[25]}'" . XHTML . ">";
            $message .= "</div></form><p>";
            $display = plugin_main($message, $token);
        }
    } else {
        //COM_redirect($_CONF['site_admin_url'] . '/plugins.php');
    }
} elseif (($mode === 'updatethisplugin') && SEC_checkToken()) { // update
    $pi_name = Geeklog\Input::fGet('pi_name');
    $display .= do_update($pi_name);

} elseif ($mode === 'info_installed') {
    $display .= plugin_info_installed(Geeklog\Input::fGet('pi_name'));
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG32[13]));

} elseif ($mode === 'info_uninstalled') {
    $display .= plugin_info_uninstalled(Geeklog\Input::fGet('pi_name'));
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG32[13]));
} elseif ($mode === 'toggle') {
    SEC_checkToken();
    $pi_name = Geeklog\Input::fGet('pi_name', '');
    changePluginStatus($pi_name);
    $sorting = '';
    if (!empty($_GET['order']) && !empty($_GET['direction'])) { // Remember how the list was sorted
        $ord = trim($_GET['order']);
        $dir = trim($_GET['direction']);
        $old = trim($_GET['prevorder']);
        $sorting = "?order=$ord&amp;direction=$dir&amp;prevorder=$old";
    }
    COM_redirect($_CONF['site_admin_url'] . '/plugins.php' . $sorting);
} elseif (($mode === 'change_load_order') && SEC_checkToken()) {
    change_load_order(Geeklog\Input::fGet('pi_name'), Geeklog\Input::fGet('where'));
    COM_redirect($_CONF['site_admin_url'] . '/plugins.php');
} elseif (($mode === 'autoinstall') && SEC_checkToken()) {
    if (SEC_hasRights('plugin.install')) {
        $plugin = Geeklog\Input::fGet('plugin', '');
        if (plugin_autoinstall($plugin)) {
            PLG_pluginStateChange($plugin, 'installed');
            COM_redirect($_CONF['site_admin_url'] . '/plugins.php?msg=44');
        } else {
            COM_redirect($_CONF['site_admin_url'] . '/plugins.php?msg=72');
        }
    } else {
        COM_redirect($_CONF['site_admin_url'] . '/plugins.php');
    }
} elseif ($mode === 'continue_upgrade') {
    $display .= continue_upgrade(
        COM_sanitizeFilename(Geeklog\Input::Get('plugin')),
        Geeklog\Input::Get('piversion'), Geeklog\Input::Get('codeversion')
    );
} elseif (isset($_FILES['plugin']) && SEC_checkToken() && SEC_hasRights('plugin.install,plugin.upload')) {
    $display .= plugin_upload();
    
    


    
} elseif ((($mode == $LANG32[34]) && !empty($LANG32[34])) && SEC_checkToken()) { // update
    $pi_name = COM_applyFilter($_POST['pi_name']);
    $display .= do_update($pi_name);

} elseif ( ( isset($_POST['add_repo'])) && SEC_checkToken()) {
    $display .= COM_siteHeader('menu', $LANG32[13]);
    $display .= add_repository();
    $display .= COM_siteFooter();

} elseif ($mode == 'edit') {
    $display .= COM_siteHeader('menu', $LANG32[13]);
    $display .= plugineditor(COM_applyFilter($_GET['pi_name']));
    $display .= COM_siteFooter();

} elseif ($mode == 'chkupdates') {
    $display .= COM_siteHeader('menu', $LANG32[13]);
    $display .= show_available_updates();
    $display .= COM_siteFooter();


} elseif ($mode == 'updatelist') {
    // Call do update list
    $array_of_failed = updaterepositorylist();
    
    if (count($array_of_failed) > 0) {
        $str = ':nl:' . $LANG32[347] . ':nl:';
        foreach ($array_of_failed as $key) {
            $str .= $key . ":nl:";
        }
    }
    else {
        $str = "";
    }
    $str = rawurlencode($str);
    // Say msg
    $display = COM_refresh($_CONF['site_admin_url'] . '/plugins.php?tmsg=500&enable_spf=1&str='.$str);
} elseif ($mode == 'lstrepo') {
    $display .= COM_siteHeader('menu', $LANG32[304]);
    $display .= plugin_showrepos();
    $display .= COM_siteFooter();
    
} elseif ($mode == 'addrepo') {
    $display .= COM_siteHeader('menu', $LANG32[304]);
    $display .= show_add_repo();
    $display .= COM_siteFooter();
    
} elseif (isset($_POST['install_updates'])) {
    $display .= start_update_process();
    
} elseif (isset($_POST['search'])) {
    $display .= plugin_showresults();

} elseif ( (isset($_GET['cmd'])) and ($_GET['cmd'] == 'install') and SEC_hasRights('plugin.install,plugin.upload')) {
    
    $display .= plugin_install_repo((isset($_GET['id'])) ? $_GET['id'] : null, $bool);
    
} elseif ( (isset($_GET['cmd'])) and ($_GET['cmd'] == 'download') ) {
        plugin_download_repo((isset($_GET['id'])) ? $_GET['id'] : null);
    
} elseif ( (isset($_GET['cmd'])) and ($_GET['cmd'] == 'del_rep')and SEC_hasRights('plugin.install,plugin.upload') ) {
        plugin_delete_repositorylisting((isset($_GET['rname'])) ? $_GET['rname'] : "");

} elseif ( (isset($_GET['cmd'])) and ($_GET['cmd'] == 'toggle_repo')and SEC_hasRights('plugin.install,plugin.upload') ) {
        plugin_toggle_repositorylisting((isset($_GET['rname'])) ? $_GET['rname'] : "", (isset($_GET['enabled'])) ? $_GET['enabled'] : false);
  


    
    
    
} else { // 'cancel' or no mode at all
    $display .= plugin_main();
}

COM_output($display);
