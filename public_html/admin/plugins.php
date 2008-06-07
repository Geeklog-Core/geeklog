<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | plugins.php                                                               |
// |                                                                           |
// | Geeklog plugin administration page.                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
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
//
// $Id: plugins.php,v 1.83 2008/06/07 12:41:44 dhaun Exp $

require_once '../lib-common.php';
require_once 'auth.inc.php';

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

// Number of plugins to list per page
// We use 25 here instead of the 50 entries in other lists to leave room
// for the list of uninstalled plugins.
define ('PLUGINS_PER_PAGE', 25);

$display = '';

if (!SEC_hasrights ('plugin.edit')) {
    $display .= COM_siteHeader ('menu', $MESSAGE[30]);
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[38];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    COM_accessLog ("User {$_USER['username']} tried to illegally access the plugin administration screen.");
    echo $display;
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
function plugineditor ($pi_name, $confirmed = 0)
{
    global $_CONF, $_TABLES, $_USER, $LANG32, $LANG_ADMIN;

    $retval = '';

    if (strlen ($pi_name) == 0) {
        $retval .= COM_startBlock ($LANG32[13], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= COM_errorLog ($LANG32[12]);
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

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
    $plg_templates->set_var( 'xhtml', XHTML );
    $plg_templates->set_var('site_url', $_CONF['site_url']);
    $plg_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $plg_templates->set_var('layout_url', $_CONF['layout_url']);
    $plg_templates->set_var('start_block_editor', COM_startBlock ($LANG32[13],
            '', COM_getBlockTemplate ('_admin_block', 'header')));
    $plg_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $plg_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $plg_templates->set_var('lang_delete', $LANG_ADMIN['delete']);
    $plg_templates->set_var ('pi_icon', PLG_getIcon ($pi_name));
    if (!empty($pi_name)) {
        $plg_templates->set_var ('delete_option', '<input type="submit" value="'
                                 . $LANG_ADMIN['delete'] . '" name="mode"' . XHTML . '>');
    }
    $plugin_code_version = PLG_chkVersion($pi_name);
    if (empty ($plugin_code_version)) {
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
        $plg_templates->set_var('enabled_checked', '');
    }
    $plg_templates->set_var('gltoken', SEC_createToken());
    $plg_templates->set_var('gltoken_name', CSRF_TOKEN);
    $plg_templates->set_var('end_block',
            COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));

    $retval .= $plg_templates->parse('output', 'editor');

    return $retval;
}

/**
* Toggle status of a plugin from enabled to disabled and back
*
* @param    string  $pi_name    name of the plugin
* @return   void
*
*/
function changePluginStatus ($pi_name_arr)
{
    global $_TABLES, $_DB_table_prefix;
    // first, get a list of all plugins
    $rst = DB_query ("SELECT pi_name, pi_enabled FROM {$_TABLES['plugins']}");
    $plg_count = DB_numRows($rst);
    for ($i=0; $i<$plg_count; $i++) { // iterate and check/change match with array
        $P = DB_fetchArray($rst);
        if (isset($pi_name_arr[$P['pi_name']]) && $P['pi_enabled'] == 0) { // enable it
            PLG_enableStateChange ($P['pi_name'], true);
            DB_query ("UPDATE {$_TABLES['plugins']} SET pi_enabled = '1' WHERE pi_name = '{$P['pi_name']}'");
        } else if (!isset($pi_name_arr[$P['pi_name']]) && $P['pi_enabled'] == 1) {  // disable it
            PLG_enableStateChange ($P['pi_name'], false);
            DB_query ("UPDATE {$_TABLES['plugins']} SET pi_enabled = '0' WHERE pi_name = '{$P['pi_name']}'");
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

        $currentState = DB_getItem ($_TABLES['plugins'], 'pi_enabled',
                                    "pi_name= '{$pi_name}' LIMIT 1");
        if ($currentState != $enabled) {
            PLG_enableStateChange ($pi_name, ($enabled == 1) ? true : false);
        }

        DB_save ($_TABLES['plugins'], 'pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage', "'$pi_name', '$pi_version', '$pi_gl_version', $enabled, '$pi_homepage'");

        $retval = COM_refresh($_CONF['site_admin_url'] . '/plugins.php?msg=28');
    } else {
        $retval .= COM_siteHeader ('menu', $LANG32[13]);
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
* @return   string      HTML containing list of uninstalled plugins
*
*/
function show_newplugins ($token)
{
    global $_CONF, $_TABLES, $LANG32;
    require_once( $_CONF['path_system'] . 'lib-admin.php' );
    $plugins = array ();
    $plugins_dir = $_CONF['path'] . 'plugins/';
    $fd = opendir ($plugins_dir);
    $index = 1;
    $retval = '';
    $data_arr = array();
    while (($dir = @readdir ($fd)) == TRUE) {
        if (is_dir ($plugins_dir . $dir) && ($dir <> '.') && ($dir <> '..') &&
                ($dir <> 'CVS') && (substr ($dir, 0 , 1) <> '.')) {
            clearstatcache ();
            // Check and see if this plugin is installed - if there is a record.
            // If not then it's a new plugin
            if (DB_count($_TABLES['plugins'],'pi_name',$dir) == 0) {
                // additionally, check if a 'functions.inc' exists
                if (file_exists ($plugins_dir . $dir . '/functions.inc')) {
                    // and finally, since we're going to link to it, check if
                    // an install script exists
                    $adminurl = $_CONF['site_admin_url'];
                    if (strrpos ($adminurl, '/') == strlen ($adminurl)) {
                        $adminurl = substr ($adminurl, 0, -1);
                    }
                    $pos = strrpos ($adminurl, '/');
                    if ($pos === false) {
                        // didn't work out - use the URL
                        $admindir = $_CONF['site_admin_url'];
                    } else {
                        $admindir = $_CONF['path_html']
                                  . substr ($adminurl, $pos + 1);
                    }
                    $fh = @fopen ($admindir . '/plugins/' . $dir
                        . '/install.php', 'r');
                    if ($fh) {
                        fclose ($fh);
                        $data_arr[] = array(
                            'pi_name' => $dir,
                            'number' => $index,
                            'install_link'=> COM_createLink($LANG32[22],
                                $_CONF['site_admin_url'] . '/plugins/' . $dir
                                . '/install.php?action=install&amp;'.CSRF_TOKEN.'='.$token)
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
    $retval .= ADMIN_simpleList('', $header_arr, $text_arr,
                           $data_arr);
    return $retval;
}

/**
* Updates a plugin (call its upgrade function).
*
* @param    pi_name   string   name of the plugin to uninstall
* @return             string   HTML for error or success message
*
*/
function do_update ($pi_name)
{
    global $_CONF, $LANG32, $LANG08, $MESSAGE, $_IMAGE_TYPE;

    $retval = '';

    if (strlen ($pi_name) == 0) {
        $retval .= COM_startBlock ($LANG32[13], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= COM_errorLog ($LANG32[12]);
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

        return $retval;
    }
    $result = PLG_upgrade ($pi_name);
    if ($result > 0 ) {
        if ($result === TRUE) { // Catch returns that are just true/false
            $retval .= COM_refresh ($_CONF['site_admin_url']
                    . '/plugins.php?msg=60');
        } else {  // Plugin returned a message number
            $retval = COM_refresh ($_CONF['site_admin_url']
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
* @param    pi_name   string   name of the plugin to uninstall
* @return             string   HTML for error or success message
*
*/
function do_uninstall ($pi_name)
{
    global $_CONF, $LANG32, $LANG08, $MESSAGE, $_IMAGE_TYPE;

    $retval = '';

    if (strlen ($pi_name) == 0) {
        $retval .= COM_startBlock ($LANG32[13], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= COM_errorLog ($LANG32[12]);
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

        return $retval;
    }

    // if the plugin is disabled, load the functions.inc now
    if (!function_exists ('plugin_uninstall_' . $pi_name)) {
        require_once ($_CONF['path'] . 'plugins/' . $pi_name . '/functions.inc');
    }

    if (PLG_uninstall ($pi_name)) {
        $retval .= COM_showMessage (45);
    } else {
        $retval .= COM_showMessage (95);
    }

    return $retval;
}

/**
* List available plugins
*
* @return   string                  formatted list of plugins
*
*/
function listplugins ($token)
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
    //  should be disabled in order to disable the last one.
    $form_arr = array('bottom' => '<input type="hidden" name="pluginenabler" value="true"' . XHTML . '>');

    $retval .= ADMIN_list('plugins', 'ADMIN_getListField_plugins', $header_arr,
                $text_arr, $query_arr, $defsort_arr, '', $token, '', $form_arr);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

// MAIN
$display = '';
if (isset ($_POST['pluginenabler']) && SEC_checkToken()) {
    changePluginStatus ($_POST['enabledplugins']);

    // force a refresh so that the information of the plugin that was just
    // enabled / disabled (menu entries, etc.) is displayed properly
    header ('Location: ' . $_CONF['site_admin_url'] . '/plugins.php');
    exit;
}

$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}
if (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) {
    $pi_name = COM_applyFilter ($_POST['pi_name']);
    if (($_POST['confirmed'] == 1) && (SEC_checkToken())) {
        $display .= COM_siteHeader ('menu', $LANG32[30]);
        $display .= do_uninstall ($pi_name);
        $token = SEC_createToken();
        $display .= listplugins ($token);
        $display .= show_newplugins($token);
        $display .= COM_siteFooter ();
    } else { // ask user for confirmation
        $display .= COM_siteHeader ('menu', $LANG32[30]);
        $display .= COM_startBlock ($LANG32[30], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $LANG32[31];
        $display .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= plugineditor ($pi_name, 1);
        $display .= COM_siteFooter ();
    }

} else if (($mode == $LANG32[34]) && !empty ($LANG32[34]) && SEC_checkToken()) { // update
        $pi_name = COM_applyFilter ($_POST['pi_name']);
        $display .= COM_siteHeader ('menu', $LANG32[13]);
        $display .= do_update ($pi_name);
        $display .= COM_siteFooter ();

} else if ($mode == 'edit') {
    $display .= COM_siteHeader ('menu', $LANG32[13]);
    $display .= plugineditor (COM_applyFilter ($_GET['pi_name']));
    $display .= COM_siteFooter ();

} else if (($mode == $LANG_ADMIN['save']) && !empty ($LANG_ADMIN['save']) && SEC_checkToken()) {
    $enabled = '';
    if (isset($_POST['enabled'])) {
        $enabled = COM_applyFilter($_POST['enabled']);
    }
    $display .= saveplugin (COM_applyFilter ($_POST['pi_name']),
                            COM_applyFilter ($_POST['pi_version']),
                            COM_applyFilter ($_POST['pi_gl_version']),
                            $enabled, COM_applyFilter ($_POST['pi_homepage']));

} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader ('menu', $LANG32[5]);
    if (isset ($_REQUEST['msg'])) {
        $msg = COM_applyFilter ($_REQUEST['msg'], true);
        if (!empty ($msg)) {
            $plugin = '';
            if (isset ($_REQUEST['plugin'])) {
                $plugin = COM_applyFilter ($_REQUEST['plugin']);
            }
            $display .= COM_showMessage ($msg, $plugin);
        }
    }
    $token = SEC_createToken();
    $display .= listplugins ($token);
    $display .= show_newplugins($token);
    $display .= COM_siteFooter();
}

echo $display;
?>
