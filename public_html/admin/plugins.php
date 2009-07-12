<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | plugins.php                                                               |
// |                                                                           |
// | Geeklog plugin administration page.                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Matt West         - matt AT mattdanger DOT net                   |
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
*
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
if (!defined('UPLOAD_ERR_NO_TMP_DIR')) { define('UPLOAD_ERR_NO_TMP_DIR', 6); }
if (!defined('UPLOAD_ERR_CANT_WRITE')) { define('UPLOAD_ERR_CANT_WRITE', 7); }
if (!defined('UPLOAD_ERR_EXTENSION'))  { define('UPLOAD_ERR_EXTENSION',  8); }

$display = '';

if (!SEC_hasRights('plugin.edit')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the plugin administration screen.");
    COM_output($display);
    exit;
}
       
/**
* Shows the plugin editor form
*
* @param    string  $pi_name    Plugin name
* @param    int     $confirmed  Flag indicated the user has confirmed an action
* @return   string              HTML for plugin editor form or error message
*
*/
function plugineditor($pi_name, $confirmed = 0)
{
    global $_CONF, $_TABLES, $_USER, $LANG32, $LANG_ADMIN;

    $retval = '';

    if (strlen($pi_name) == 0) {
        $retval .= COM_showMessageText($LANG32[12], $LANG32[13]);

        return $retval;
    }

    $result = DB_query("SELECT pi_homepage,pi_version,pi_gl_version,pi_enabled FROM {$_TABLES['plugins']} WHERE pi_name = '$pi_name'");
    if (DB_numRows($result) <> 1) {
        // Serious problem, we got a pi_name that doesn't exist
        // or returned more than one row
        $retval .= COM_startBlock ($LANG32[13], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= COM_errorLog ('Error in editing plugin ' . $pi_name
                . '. Either the plugin does not exist or there is more than one row with with same pi_name.  Bailing out to prevent trouble.');
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

        return $retval;
    }

    $A = DB_fetchArray($result);

    $plg_templates = new Template($_CONF['path_layout'] . 'admin/plugins');
    $plg_templates->set_file('editor', 'editor.thtml');
    $plg_templates->set_var('xhtml', XHTML);
    $plg_templates->set_var('site_url', $_CONF['site_url']);
    $plg_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $plg_templates->set_var('layout_url', $_CONF['layout_url']);
    $plg_templates->set_var('start_block_editor', COM_startBlock ($LANG32[13],
            '', COM_getBlockTemplate ('_admin_block', 'header')));
    $plg_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $plg_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $plg_templates->set_var('lang_delete', $LANG_ADMIN['delete']);
    $plg_templates->set_var('pi_icon', PLG_getIcon($pi_name));
    if (SEC_hasRights('plugin.install')) {
        $plg_templates->set_var('delete_option', '<input type="submit" value="'
                . $LANG_ADMIN['delete'] . '" name="mode"' . XHTML . '>');
    } else {
        $plg_templates->set_var('delete_option', '');
    }
    $plugin_code_version = PLG_chkVersion($pi_name);
    if (empty($plugin_code_version)) {
        $code_version = 'N/A';
    } else {
        $code_version = $plugin_code_version;
    }
    $pi_installed_version = $A['pi_version'];
    if (empty ($plugin_code_version) ||
            ($pi_installed_version == $code_version)) {
        $plg_templates->set_var ('update_option', '');
    } else {
        $plg_templates->set_var ('update_option', '<input type="submit" value="'
                                 . $LANG32[34] . '" name="mode"' . XHTML . '>');
    }
    $plg_templates->set_var('confirmed', $confirmed);
    $plg_templates->set_var('lang_pluginname', $LANG32[26]);
    $plg_templates->set_var('pi_name', $pi_name);
    $plg_templates->set_var('pi_display_name', plugin_get_pluginname($pi_name));
    $plg_templates->set_var('lang_pluginhomepage', $LANG32[27]);
    $plg_templates->set_var('pi_homepage', $A['pi_homepage']);
    $plg_templates->set_var('lang_pluginversion', $LANG32[28]);
    $plg_templates->set_var('lang_plugincodeversion', $LANG32[33]);
    $plg_templates->set_var('pi_version', $A['pi_version']);
    $plg_templates->set_var('lang_geeklogversion', $LANG32[29]);
    $plg_templates->set_var('pi_gl_version', $A['pi_gl_version']);
    $plg_templates->set_var('pi_codeversion', $code_version );
    $plg_templates->set_var('lang_enabled', $LANG32[19]);
    if ($A['pi_enabled'] == 1) {
        $plg_templates->set_var('enabled_checked', 'checked="checked"');
    } else {
        if (file_exists($_CONF['path'] . 'plugins/' . $pi_name
                        . '/functions.inc')) {
            $plg_templates->set_var('enabled_checked', '');
        } else {
            $plg_templates->set_var('enabled_checked', 'disabled="disabled"');
        }
    }
    $plg_templates->set_var('gltoken', SEC_createToken());
    $plg_templates->set_var('gltoken_name', CSRF_TOKEN);
    $plg_templates->set_var('end_block',
            COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));

    $retval .= $plg_templates->finish($plg_templates->parse('output', 'editor'));

    return $retval;
}

/**
* Toggle plugin status from enabled to disabled and back
*
* @param    array   $pi_name_arr    array of plugin states
* @return   void
*
*/
function changePluginStatus($pi_name_arr)
{
    global $_TABLES, $_DB_table_prefix;

    // first, get a list of all plugins
    $rst = DB_query("SELECT pi_name, pi_enabled FROM {$_TABLES['plugins']}");
    $plg_count = DB_numRows($rst);
    for ($i = 0; $i < $plg_count; $i++) { // iterate and check/change match with array
        $P = DB_fetchArray($rst);
        if (isset($pi_name_arr[$P['pi_name']]) && ($P['pi_enabled'] == 0)) { // enable it
            PLG_enableStateChange($P['pi_name'], true);
            DB_change($_TABLES['plugins'], 'pi_enabled', 1,
                                           'pi_name', $P['pi_name']);
            PLG_pluginStateChange($P['pi_name'], 'enabled');
        } elseif (!isset($pi_name_arr[$P['pi_name']]) && $P['pi_enabled'] == 1) {  // disable it
            PLG_enableStateChange($P['pi_name'], false);
            DB_change($_TABLES['plugins'], 'pi_enabled', 0,
                                           'pi_name', $P['pi_name']);
            PLG_pluginStateChange($P['pi_name'], 'disabled');
        }
    }
}


/**
* Saves a plugin
*
* @param    string  $pi_name        Plugin name
* @param    string  $pi_version     Plugin version number
* @param    string  $pi_gl_version  Geeklog version plugin is compatible with
* @param    int     $enabled        Flag that indicates if plugin is enabled
* @param    string  $pi_homepage    URL to homepage for plugin
* @return   string                  HTML redirect or error message
*
*/
function saveplugin($pi_name, $pi_version, $pi_gl_version, $enabled, $pi_homepage)
{
    global $_CONF, $_TABLES, $LANG32;

    $retval = '';

    if (!empty ($pi_name)) {
        if ($enabled == 'on') {
            $enabled = 1;
        } else {
            $enabled = 0;
        }
        $pi_name = addslashes ($pi_name);
        $pi_version = addslashes ($pi_version);
        $pi_gl_version = addslashes ($pi_gl_version);
        $pi_homepage = addslashes ($pi_homepage);

        $currentState = DB_getItem($_TABLES['plugins'], 'pi_enabled',
                                   "pi_name= '{$pi_name}' LIMIT 1");
        if ($currentState != $enabled) {
            PLG_enableStateChange($pi_name, ($enabled == 1) ? true : false);
        }

        DB_save($_TABLES['plugins'], 'pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage', "'$pi_name', '$pi_version', '$pi_gl_version', $enabled, '$pi_homepage'");

        if ($currentState != $enabled) {
            PLG_pluginStateChange($pi_name,
                                  ($enabled == 1) ? 'enabled' : 'disabled');
        }

        $retval = COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=28');
    } else {
        $retval .= COM_siteHeader('menu', $LANG32[13]);
        $retval .= COM_startBlock ($LANG32[13], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= COM_errorLog ('error saving plugin, no pi_name provided', 1);
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval .= plugineditor ($pi_name);
        $retval .= COM_siteFooter ();
    }

    return $retval;
}

/**
* Creates list of uninstalled plugins (if any) and offers install link to them.
*
* @param    string  $token  Security token to use in list
* @return   string          HTML containing list of uninstalled plugins
*
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
    while (($dir = @readdir($fd)) == TRUE) {
        if (($dir <> '.') && ($dir <> '..') && ($dir <> 'CVS') &&
                (substr($dir, 0 , 1) <> '.') && is_dir($plugins_dir . $dir)) {
            clearstatcache ();
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
                            'pi_name'      => plugin_get_pluginname($dir),
                            'number'       => $index,
                            'install_link' => COM_createLink($LANG32[22], $url)
                        );
                        $index++;
                    }
                }
            }
        }
    }

    $header_arr = array(      # display 'text' and use table field 'field'
                    array('text' => '#', 'field' => 'number'),
                    array('text' => $LANG32[16], 'field' => 'pi_name'),
                    array('text' => '', 'field' => 'install_link')
    );

    $text_arr = array('title' => $LANG32[14]);
    $retval .= ADMIN_simpleList('', $header_arr, $text_arr, $data_arr);

    return $retval;
}

/**
* Updates a plugin (call its upgrade function).
*
* @param    string  $pi_name    name of the plugin to uninstall
* @return   string              HTML for error or success message
*
*/
function do_update($pi_name)
{
    global $_CONF, $LANG32;

    $retval = '';

    if (strlen($pi_name) == 0) {
        $retval .= COM_showMessageText($LANG32[12], $LANG32[13]);

        return $retval;
    }

    $result = PLG_upgrade($pi_name);
    if ($result > 0 ) {
        if ($result === TRUE) { // Catch returns that are just true/false
            PLG_pluginStateChange($pi_name, 'upgraded');
            $retval .= COM_refresh($_CONF['site_admin_url']
                    . '/plugins.php?msg=60');
        } else {  // Plugin returned a message number
            $retval = COM_refresh($_CONF['site_admin_url']
                    . '/plugins.php?msg=' . $result . '&amp;plugin='
                    . $pi_name);
        }
    } else {  // Plugin function returned a false
        $retval .= COM_showMessage(95);
    }

    return $retval;
}


/**
* Uninstall a plugin (call its uninstall function).
*
* @param    string  $pi_name    name of the plugin to uninstall
* @return   string              HTML for error or success message
*
*/
function do_uninstall($pi_name)
{
    global $_CONF;

    $retval = false;

    if (empty($pi_name) || (strlen($pi_name) == 0)) {
        return false;
    }

    // if the plugin is disabled, load the functions.inc now
    if (!function_exists('plugin_uninstall_' . $pi_name) &&
        !function_exists('plugin_autouninstall_' . $pi_name)) {
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
* @param    string  $token  Security token
* @return   string          formatted list of plugins
*
*/
function listplugins($token)
{
    global $_CONF, $_TABLES, $LANG32, $LANG_ADMIN, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG32[16], 'field' => 'pi_name', 'sort' => true),
        array('text' => $LANG32[17], 'field' => 'pi_version', 'sort' => true),
        array('text' => $LANG32[18], 'field' => 'pi_gl_version', 'sort' => true),
        array('text' => $LANG_ADMIN['enabled'], 'field' => 'enabled', 'sort' => false)
    );

    $defsort_arr = array('field' => 'pi_name', 'direction' => 'asc');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home']));

    $retval .= COM_startBlock($LANG32[5], '',
                              COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG32[11],
        $_CONF['layout_url'] . '/images/icons/plugins.' . $_IMAGE_TYPE
    );

    $text_arr = array(
        'has_extras'   => true,
        'instructions' => $LANG32[11],
        'form_url'     => $_CONF['site_admin_url'] . '/plugins.php'
    );

    $query_arr = array(
        'table' => 'plugins',
        'sql' => "SELECT pi_name, pi_version, pi_gl_version, "
                ."pi_enabled, pi_homepage FROM {$_TABLES['plugins']} WHERE 1=1",
        'query_fields' => array('pi_name'),
        'default_filter' => ''
    );

    // this is a dummy variable so we know the form has been used if all plugins
    // should be disabled in order to disable the last one.
    $form_arr = array('bottom' => '<input type="hidden" name="pluginenabler" value="true"' . XHTML . '>');

    $retval .= ADMIN_list('plugins', 'ADMIN_getListField_plugins', $header_arr,
                $text_arr, $query_arr, $defsort_arr, '', $token, '', $form_arr);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
 * Check if an error occured while uploading a file
 *
 * @param   array   $mFile  $_FILE['uploaded_file']
 * @return  mixed           Returns the error string if an error occured,
 *                          returns false if no error occured
 *
 */
function plugin_getUploadError($mFile) 
{
    global $LANG32;

    $retval = '';

    if (isset($mFile['error']) && ($mFile['error'] !== UPLOAD_ERR_OK)) { // If an error occured while uploading the file.

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
* @return   boolean     true: uploads possible; false: not possible
*
*/
function plugin_upload_enabled()
{
    global $_CONF;

    $path_admin = $_CONF['path_html'] . substr($_CONF['site_admin_url'],
            strlen($_CONF['site_url']) + 1) . '/';

    // If 'file_uploads' is enabled in php.ini
    // and the plugin directories are writable by the web server.
    $upload_enabled = (ini_get('file_uploads')
                        && is_writable($_CONF['path'] . 'plugins/') 
                        && is_writable($_CONF['path_html'])
                        && is_writable($path_admin . 'plugins/')) 
                            ? true
                            : false;

    return $upload_enabled;
}

/**
* Display upload form
*
* @param    string  $token  Security token
* @return   string          HTML for the upload form
*
*/
function plugin_show_uploadform($token)
{
    global $_CONF, $LANG28, $LANG32;

    $retval = '';

    $retval .= COM_startBlock($LANG32[39], '',
                              COM_getBlockTemplate('_admin_block', 'header'));

    // Show the upload form
    $retval .= '<p>' . $LANG32[40] . '</p>' . LB
            . '<form name="plugins_upload" action="' . $_CONF['site_admin_url']             . '/plugins.php" method="post" enctype="multipart/form-data">' . LB
            . '<div>' . $LANG28[29] . ': '
            . '<input type="file" dir="ltr" name="plugin" size="40"' . XHTML
            . '> ' . LB
            . '<input type="submit" name="upload" value="' . $LANG32[41] . '"'
            . XHTML . '>' . LB
            . '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $token
            . '"' . XHTML . '>' . '</div>' . LB . '</form>' . LB;

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
* Handle uploaded plugin
*
* @return   string      HTML: redirect or main plugin screen + error message
*
*/
function plugin_upload()
{
    global $_CONF, $_TABLES;

    $retval = '';

    $path_admin = $_CONF['path_html'] . substr($_CONF['site_admin_url'],
            strlen($_CONF['site_url']) + 1) . '/';

    $upload_success = false;

    // If an error occured while uploading the file.
    $error_msg = plugin_getUploadError($_FILES['plugin']);
    if (!empty($error_msg)) {

        $retval .= plugin_main($error_msg);

    } else {

        require_once $_CONF['path_system'] . 'classes/unpacker.class.php';

        $plugin_file = $_CONF['path_data'] . $_FILES['plugin']['name']; // Name the plugin file

        $archive = new unpacker($_FILES['plugin']['tmp_name'],
                                $_FILES['plugin']['type']);
        $tmp = $archive->getlist(); // Grab the contents of the tarball to see what the plugin name is
        $dirname = preg_replace('/\/.*$/', '', $tmp[0]['filename']);

        if (empty($dirname)) { // If $dirname is blank it's probably because the user uploaded a non Tarball file.

            $retval = COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=100');

        } else {

            $pi_did_exist   = false; // plugin directory already existed
            $pi_had_entry   = false; // plugin had an entry in the database
            $pi_was_enabled = false; // plugin was enabled

            if (file_exists($_CONF['path'] . 'plugins/' . $dirname)) {
                $pi_did_exist = true;

                // plugin directory already exists
                $pstatus = DB_query("SELECT pi_name, pi_enabled FROM {$_TABLES['plugins']} WHERE pi_name = '$dirname'");
                $A = DB_fetchArray($pstatus);
                if (isset($A['pi_name'])) {
                    $pi_had_entry = true;
                    $pi_was_enabled = ($A['pi_enabled'] == 1);
                }

                if ($pi_was_enabled) {
                    // disable temporarily while we move the files around
                    DB_change($_TABLES['plugins'], 'pi_enabled', 0,
                                                   'pi_name', $dirname);
                }

                require_once 'System.php';

                $plugin_dir = $_CONF['path'] . 'plugins/' . $dirname;
                if (file_exists($plugin_dir . '.previous')) {
                    @System::rm('-rf ' . $plugin_dir . '.previous');
                }
                if (file_exists($plugin_dir)) {
                    rename($plugin_dir, $plugin_dir . '.previous');
                }

                $public_dir = $_CONF['path_html'] . $dirname;
                if (file_exists($public_dir . '.previous')) {
                    @System::rm('-rf ' . $public_dir . '.previous');
                }
                if (file_exists($public_dir)) {
                    rename($public_dir, $public_dir . '.previous');
                }

                $admin_dir = $path_admin . 'plugins/' . $dirname;
                if (file_exists($admin_dir . '.previous')) {
                    @System::rm('-rf ' . $admin_dir . '.previous');
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
            $archive->unpack($_CONF['path'] . 'data/',
                             array($dirname . '/admin/install.php'));
            $plugin_inst = $_CONF['path'] . 'data/' . $dirname . '/admin/install.php';
            $fdata = '';
            $fhandle = @fopen($plugin_inst, 'r');
            if ($fhandle) {
                $fdata = fread($fhandle, filesize($plugin_inst));
                fclose($fhandle);
            }

            // Remove the plugin from data/
            require_once 'System.php';
            @System::rm('-rf ' . $_CONF['path'] . 'data/' . $dirname);

            /**
             * One time I wanted to install a muffler on my car and
             * needed to match up the outside diameter of the car's
             * exhaust pipe to the inside diameter of the muffler. 
             * Unfortunately, when I went to the auto parts store they
             * didn't have a coupling adapter that would perfectly
             * match the two pipes, only a bunch of smaller adapters.
             * I ended up using about 4 small adapters to step down 
             * one size at a time to the size of the muffler's input.
             *
             * It's kind of like this regular expression:
             *
             */
            $fdata = preg_replace('/\n/', '', $fdata);
            $fdata = preg_replace('/ /', '', $fdata);
            $pi_name = preg_replace('/^.*\$pi\_name=\'/', '', $fdata);
            $pi_name = preg_replace('/\'.*$/', '', $pi_name);

            // Some plugins don't have $pi_name set in their install.php file,
            // This means our regex won't work and we should just use $dirname
            if (preg_match('/\<\?php/', $pi_name) || preg_match('/--/', $pi_name)) {

                $pi_name = $dirname;

            } elseif (empty($pi_name)) {

                $pi_name = $dirname;

            }

            // Extract the uploaded archive to the plugins directory
            $upload_success = $archive->unpack($_CONF['path'] . 'plugins/');

            $plg_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';
            if ($upload_success) {

                if (file_exists($plg_path . 'public_html')) {
                    rename($plg_path . 'public_html',
                           $_CONF['path_html'] . $pi_name);
                }
                if (file_exists($plg_path . 'admin')) {
                    rename($plg_path . 'admin',
                           $path_admin . 'plugins/' . $pi_name);
                }

            }

            unset($archive); // Collect some garbage

            // cleanup when uploading a new version
            if ($pi_did_exist) {
                $plugin_dir = $_CONF['path'] . 'plugins/' . $dirname;
                if (file_exists($plugin_dir . '.previous')) {
                    @System::rm('-rf ' . $plugin_dir . '.previous');
                }

                $public_dir = $_CONF['path_html'] . $dirname;
                if (file_exists($public_dir . '.previous')) {
                    @System::rm('-rf ' . $public_dir . '.previous');
                }

                $admin_dir = $path_admin . 'plugins/' . $dirname;
                if (file_exists($admin_dir . '.previous')) {
                    @System::rm('-rf ' . $admin_dir . '.previous');
                }

                if ($pi_was_enabled) {
                    DB_change($_TABLES['plugins'], 'pi_enabled', 1,
                                                   'pi_name', $dirname);
                }
            }

            $msg_with_plugin_name = false;
            if ($pi_did_exist) {
                if ($pi_was_enabled) {
                    // check if we have to perform an update
                    $pi_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                             "pi_name = '$dirname'");
                    $code_version = PLG_chkVersion($dirname);
                    if (! empty($code_version) &&
                            ($code_version != $pi_version)) {
                        $result = PLG_upgrade($dirname);
                        if ($result === true) {
                            PLG_pluginStateChange($dirname, 'upgraded');
                            $msg = 60; // successfully updated
                        } else {
                            $msg_with_plugin_name = true;
                            $msg = $result; // message provided by the plugin
                        }
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
                    $msg = 72; // an error occured while installing the plugin
                }
            } else {
                $msg = 98; // successfully uploaded
            }

            $url = $_CONF['site_admin_url'] . '/plugins.php?msg=' . $msg;
            if ($msg_with_plugin_name) {
                $url .= '&amp;plugin=' . $dirname;
            }
            $retval = COM_refresh($url);
        }
    }

    return $retval;
}

/**
* Show main plugin screen: installed and uninstalled plugins, upload form
*
* @param    string  $message    (optional) message to display
* @return   string              HTML for the plugin screen
*
*/
function plugin_main($message = '')
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
    $retval .= listplugins($token);
    if (SEC_hasRights('plugin.install')) {
        $retval .= show_newplugins($token);
    }

    // If the web server will allow the user to upload a plugin
    if (plugin_upload_enabled() &&
            SEC_hasRights('plugin.install,plugin.upload')) {
        $retval .= plugin_show_uploadform($token);
    }

    $retval .= COM_siteFooter();

    return $retval;
}

/**
* Prepare and perform plugin auto install
*
* @param    string  $plugin     Plugin name (internal name, i.e. directory name)
* @return   boolean             true on success, false otherwise
*
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
        if (! $check_compatible($plugin)) {
            COM_errorLog($LANG32[9]);

            return false;
        }
    }

    $auto_install = 'plugin_autoinstall_' . $plugin;
    if (! function_exists($auto_install)) {
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
*
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
        $pi_name       = $inst_parms['info']['pi_name'];
        $pi_version    = $inst_parms['info']['pi_version'];
        $pi_gl_version = $inst_parms['info']['pi_gl_version'];
        $pi_homepage   = $inst_parms['info']['pi_homepage'];
    }
    if (empty($pi_name) || ($pi_name != $plugin) || empty($pi_version) ||
            empty($pi_gl_version) || empty($pi_homepage)) {
        COM_errorLog('Incomplete plugin info', 1);

        return false;
    }

    // add plugin tables, if any
    if (! empty($inst_parms['tables'])) {
        $tables = $inst_parms['tables'];
        foreach ($tables as $table) {
            $_TABLES[$table] = $_DB_table_prefix . $table;
        }
    }

    // Create the plugin's group(s), if any
    $groups = array();
    $admin_group_id = 0;
    if (! empty($inst_parms['groups'])) {
        $groups = $inst_parms['groups'];
        foreach ($groups as $name => $desc) {
            if ($verbose) {
                COM_errorLog("Attempting to create '$name' group", 1);
            }

            $grp_name = addslashes($name);
            $grp_desc = addslashes($desc);
            if($_DB_dbms=='pgsql')
            {
                DB_query("INSERT INTO {$_TABLES['groups']} (grp_id,grp_name, grp_descr) VALUES ((SELECT NEXTVAL('groups_grp_id_seq')),'$grp_name', '$grp_desc')", 1);
            }
            else
            {
                DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) VALUES ('$grp_name', '$grp_desc')", 1);
            }
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
                == 'InnoDB')) {
            $use_innodb = true;
        }

        foreach ($_SQL as $sql) {
            $sql = str_replace('#group#', $admin_group_id, $sql);
            if ($use_innodb) {
                $sql = str_replace('MyISAM', 'InnoDB', $sql);
            }
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
            $ft_name = addslashes($feature);
            $ft_desc = addslashes($desc);
            if($_DB_dbms=='pgsql')
            {
             DB_query("INSERT INTO {$_TABLES['features']} (ft_id,ft_name, ft_descr) "
                     . "VALUES ((SELECT nextval('ft_id_seq'))'$ft_name', '$ft_desc')", 1);   
            }
            else {
            DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
                     . "VALUES ('$ft_name', '$ft_desc')", 1);
            }
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
    if ($admin_group_id > 1) {
        if ($verbose) {
            COM_errorLog("Attempting to give all users in the Root group access to the '$plugin' Admin group", 1);
        }

        DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES "
                 . "($admin_group_id, NULL, 1)");
        if (DB_error()) {
            COM_errorLog('Error adding plugin admin group to Root group', 1);
            PLG_uninstall($plugin);

            return false;
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
        if (! $load_config($plugin)) {
            COM_errorLog('Error loading plugin configuration', 1);
            PLG_uninstall($plugin);

            return false;
        }
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
        if (! $post_install($plugin)) {
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
* @param    string  $plugin     internal name / directory name
* @return   string              real or beautified name
*
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
                    isset($info['info']['pi_display_name'])) {
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


// MAIN
$display = '';
if (isset($_POST['pluginenabler']) && SEC_checkToken()) {
    if (isset($_POST['enabledplugins'])) {
        changePluginStatus($_POST['enabledplugins']);
    } else {
        changePluginStatus(array());
    }

    // force a refresh so that the information of the plugin that was just
    // enabled / disabled (menu entries, etc.) is displayed properly
    header('Location: ' . $_CONF['site_admin_url'] . '/plugins.php');
    exit;
}

$mode = '';
if (isset($_POST['mode'])) {
    $mode = $_POST['mode'];
} elseif (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
}
if (($mode == $LANG_ADMIN['delete']) && !empty($LANG_ADMIN['delete'])) {
    $pi_name = COM_applyFilter($_POST['pi_name']);
    if ((! empty($pi_name)) && SEC_hasRights('plugin.install')) {
        if (($_POST['confirmed'] == 1) && SEC_checkToken()) {
            $msg = do_uninstall($pi_name);
            if ($msg === false) {
                echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php');
            } else {
                echo COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg='
                                                          . $msg);
            }
            exit;
        } else { // ask user for confirmation
            $display .= COM_siteHeader('menu', $LANG32[30]);
            $display .= COM_startBlock($LANG32[30], '',
                                COM_getBlockTemplate('_msg_block', 'header'));
            $display .= $LANG32[31];
            $display .= COM_endBlock(COM_getBlockTemplate('_msg_block',
                                                          'footer'));
            $display .= plugineditor($pi_name, 1);
            $display .= COM_siteFooter();
        }
    } else {
        $display = COM_refresh($_CONF['site_admin_url'] . '/plugins.php');
    }

} elseif ((($mode == $LANG32[34]) && !empty($LANG32[34])) && SEC_checkToken()) { // update
    $pi_name = COM_applyFilter($_POST['pi_name']);
    $display .= COM_siteHeader('menu', $LANG32[13]);
    $display .= do_update($pi_name);
    $display .= COM_siteFooter();

} elseif ($mode == 'edit') {
    $display .= COM_siteHeader('menu', $LANG32[13]);
    $display .= plugineditor(COM_applyFilter($_GET['pi_name']));
    $display .= COM_siteFooter();

} elseif ((($mode == $LANG_ADMIN['save']) && !empty($LANG_ADMIN['save'])) && SEC_checkToken()) {
    $enabled = '';
    if (isset($_POST['enabled'])) {
        $enabled = COM_applyFilter($_POST['enabled']);
    }
    $display .= saveplugin (COM_applyFilter($_POST['pi_name']),
                            COM_applyFilter($_POST['pi_version']),
                            COM_applyFilter($_POST['pi_gl_version']),
                            $enabled, COM_applyFilter($_POST['pi_homepage']));

} elseif (($mode == 'autoinstall') && SEC_checkToken()) {
    if (SEC_hasRights('plugin.install')) {
        $plugin = '';
        if (isset($_GET['plugin'])) {
            $plugin = COM_applyFilter($_GET['plugin']);
        }
        if (plugin_autoinstall($plugin)) {
            PLG_pluginStateChange($plugin, 'installed');
            $display .= COM_refresh($_CONF['site_admin_url']
                                    . '/plugins.php?msg=44');
        } else {
            $display .= COM_refresh($_CONF['site_admin_url']
                                    . '/plugins.php?msg=72');
        }
    } else {
        $display = COM_refresh($_CONF['site_admin_url'] . '/plugins.php');
    }

} elseif (isset($_FILES['plugin']) && SEC_checkToken() &&
        SEC_hasRights('plugin.install,plugin.upload')) { 
    $display .= plugin_upload();

} else { // 'cancel' or no mode at all
    $display .= plugin_main();

}

COM_output($display);

?>
