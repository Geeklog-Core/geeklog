<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | install-plugins.php                                                       |
// |                                                                           |
// | Install plugins.                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Matt West - matt AT mattdanger DOT net                           |
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


// +---------------------------------------------------------------------------+
// | Main                                                                      |
// +---------------------------------------------------------------------------+

require_once '../../lib-common.php';
require_once 'lib-install.php';

// Set some vars
$html_path          = INST_getHtmlPath();
$siteconfig_path    = '../../siteconfig.php';

if ($_CONF['path'] == '/path/to/Geeklog/') { // If the Geeklog path has not been defined.

    // Attempt to locate Geeklog's path
    $gl_path = strtr(__FILE__, '\\', '/'); // replace all '\' with '/'
    for ($i = 0; $i < 4; $i++) {
        $remains = strrchr($gl_path, '/');
        if ($remains === false) {
            break;
        } else {
            $gl_path = substr($gl_path, 0, -strlen($remains));
        }
    }

    $_CONF['path'] = $gl_path;

} else {

    // TODO: Remove all references to $gl_path and use $_CONF['path'] for consistency.
    $gl_path = $_CONF['path'];

}

$dbconfig_path      = (isset($_POST['dbconfig_path'])) ? $_POST['dbconfig_path'] : ((isset($_GET['dbconfig_path'])) ? $_GET['dbconfig_path'] : $gl_path . '/db-config.php');
$dbconfig_path      = INST_sanitizePath($dbconfig_path);
$step               = isset($_GET['step']) ? $_GET['step'] : (isset($_POST['step']) ? $_POST['step'] : 1);

// $display holds all the outputted HTML and content
$display = INST_getHeader($LANG_PLUGINS[2] . ' 3 - ' . $LANG_PLUGINS[1]); // Grab the beginning HTML for the installer theme.

// Make sure the version of PHP is supported.
if (INST_phpOutOfDate()) {

    // If their version of PHP is not supported, print an error:
    $display .= '<h1>' . sprintf($LANG_INSTALL[4], SUPPORTED_PHP_VER) . '</h1>' . LB;
    $display .= '<p>' . sprintf($LANG_INSTALL[5], SUPPORTED_PHP_VER) . $phpv[0] . '.' . $phpv[1] . '.' . (int) $phpv[2] . $LANG_INSTALL[6] . '</p>' . LB;

} else {

    // Ok, the user's version of PHP is supported. Let's move on
    switch ($step) {

    /**
     * Step 1 - Display the upload form and allow
     * the user to select which plugins to install
     */
    case 1:

        // If 'file_uploads' is enabled in php.ini and the plugin directories are writable by the web server.
        $upload_enabled = (ini_get('file_uploads')
                            && is_writable($_CONF['path'] . 'plugins/') 
                            && is_writable($_CONF['path_html'])
                            && is_writable(INST_getAdminPath() . 'plugins/')) 
                                ? true
                                : false;

        $display .= '<p>' . $LANG_PLUGINS[3]
                 . ($upload_enabled ? ' ' . $LANG_PLUGINS[4] : '')
                 . '</p>' . LB;

        // Check if a plugin file was uploaded
        $upload_success = false;
        if (isset($_FILES['plugin'])) { 

            if ($error_msg = INST_getUploadError($_FILES['plugin'])) { // If an error occured while uploading the file.

                $display .= '<div class="notice"><span class="error">' . $LANG_INSTALL[38] . '</span> ' . $error_msg . '</div>' . LB;

            } else {

                $plugin_file = $_CONF['path_data'] . $_FILES['plugin']['name']; // Name the plugin file

                if ($_FILES['plugin']['type'] == 'application/zip') {

                    // Zip
                    require_once 'Archive/Zip.php';  // import Archive_Zip library
                    $archive = new Archive_Zip($_FILES['plugin']['tmp_name']); // Use PEAR's Archive_Zip to extract the package

                } else {

                    // Tarball
                    require_once 'Archive/Tar.php';  // import Archive_Tar library
                    $archive = new Archive_Tar($_FILES['plugin']['tmp_name']); // Use PEAR's Archive_Tar to extract the package

                }

                $tmp = $archive->listContent(); // Grab the contents of the tarball to see what the plugin name is
                $dirname = preg_replace('/\/.*$/', '', $tmp[0]['filename']);

                if (empty($dirname)) { // If $dirname is blank it's probably because the user uploaded a non Tarball file.

                    $display .= '<div class="notice"><span class="error">' . $LANG_INSTALL[38] . '</span> ' . $LANG_PLUGINS[5] . '</div>' . LB;

                } else if (file_exists($_CONF['path'] . 'plugins/' . $dirname)) { // If plugin directory already exists

                    $display .= '<div class="notice"><span class="error">' . $LANG_INSTALL[38] . '</span> ' . $LANG_PLUGINS[6] . '</div>' . LB;

                } else {

                    /** 
                     * Install the plugin
                     * This doesn't work if the public_html & public_html/admin/plugins directories aren't 777
                     */

                    // Extract the archive to data so we can get the $pi_name name from admin/install.php
                    if ($_FILES['plugin']['type'] == 'application/zip') {

                        // Zip
                        $archive->extract(array('add_path' => $_CONF['path'] . 'data/',
                                                'by_name' => $dirname . '/admin/install.php'));

                    } else {

                        // Tarball
                        $archive->extractList(array($dirname . '/admin/install.php'), $_CONF['path'] . 'data/');

                    }

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
                    if ($_FILES['plugin']['type'] == 'application/zip') {
    
                        // Zip
                        $upload_success = $archive->extract(array('add_path' => $_CONF['path'] . 'plugins/'));

                    } else {

                        // Tarball
                        $upload_success = $archive->extract($_CONF['path'] . 'plugins/');

                    }

                    $plg_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';
                    if ($upload_success) { 

                        if (file_exists($plg_path . 'public_html')) {
                            rename($plg_path . 'public_html',
                                   $_CONF['path_html'] . $pi_name);
                        }
                        if (file_exists($plg_path . 'admin')) {
                            rename($plg_path . 'admin',
                                   INST_getAdminPath() . 'plugins/' . $pi_name);
                        }

                    }

                    unset($archive); // Collect some garbage

                }

            }

        } // End check if a plugin file was uploaded

        // If the web server will allow the user to upload a plugin
        if ($upload_enabled) {

            // Show the upload form
            $display .= '<br' . XHTML . '>' . LB
                . (($upload_success) 
                    ? '<div class="notice"><span class="success">' . $LANG_PLUGINS[7] . '</span> ' . sprintf($LANG_PLUGINS[8], $pi_name) . '</div>' 
                    : '') . LB
                . '<h2>' . $LANG_PLUGINS[9] . '</h2>' . LB
                . '<form name="plugins_upload" action="install-plugins.php" method="POST" enctype="multipart/form-data">' . LB
                . '<input type="hidden" name="language" value="' . $language . '"' . XHTML . '>' . LB
                . '<p><label class="' . $form_label_dir . '">' . $LANG_PLUGINS[10] . ' ' . INST_helpLink('plugin_upload') . '</label> ' . LB
                . '<input type="file" name="plugin" size="25"' . XHTML . '></p>' . LB
                . '<p><input type="submit" class="button big-button" name="upload" value="' . $LANG_PLUGINS[11] . '"' . XHTML . '></p>' . LB
                . '</form>' . LB;

        }

        // Check if there are any plugins that need to be installed
        $plugins_dir = $_CONF['path'] . 'plugins/';
        $new_plugins = 0;
        $fd = opendir($plugins_dir);
        while (($plugin = @readdir($fd)) == TRUE) {

            if (($plugin <> '.') && ($plugin <> '..') && ($plugin <> 'CVS') &&
                    (substr($plugin, 0, 1) <> '.') &&
                    (substr($plugin, 0, 1) <> '_') &&
                    is_dir($plugins_dir . $plugin)) {

                clearstatcache ();

                // Check and see if this plugin is installed (if there is a record)
                // If no record exists in the plugins table then it's a new plugin
                if (DB_count($_TABLES['plugins'], 'pi_name', $plugin) == 0) {

                    $new_plugins++;

                }

            }

        }

        $display .= '<br' . XHTML . '><h2>' . $LANG_PLUGINS[12] . '</h2>' . LB;

        // If there are new plugins
        if ($new_plugins > 0) {

            // Form header
            $display .= '<p><form action="install-plugins.php" method="POST" name="plugin_list">' . LB
                . '<input type="hidden" name="language" value="' . $language . '"' . XHTML . '>' . LB
                . '<input type="hidden" name="step" value="2"' . XHTML . '>' . LB
                . '<table width="650px">' . LB
                . '<tr>' . LB
                    . '<th width="60">' . $LANG_PLUGINS[13] . '</th>' . LB
                    . '<th>' . $LANG_PLUGINS[14] . '</th>' . LB
                    . '<th width="75">' . $LANG_PLUGINS[15] . '</th>' . LB
                . '</tr>' . LB;

            /**
             * List plugins that are available for install
             */
            $fd = opendir($plugins_dir);
            while (($plugin = @readdir($fd)) == TRUE) {
    
                if (($plugin <> '.') && ($plugin <> '..') &&
                        ($plugin <> 'CVS') && (substr($plugin, 0, 1) <> '.') &&
                        (substr($plugin, 0, 1) <> '_') &&
                        is_dir($plugins_dir . $plugin)) {
    
                    clearstatcache ();
                    $plugin_dir = $plugins_dir . $plugin;

                    // Check and see if this plugin is installed (if there is a record)
                    // If no record exists in the plugins table then it's a new plugin
                    if (DB_count($_TABLES['plugins'], 'pi_name', $plugin) == 0) {

                        $pi_name            = '';
                        $pi_display_name    = '';
                        $pi_version         = $LANG_PLUGINS[16];
                        $gl_version         = $LANG_PLUGINS[16];
                        $pi_url             = '';

                        /**
                         * Make sure the plugin is installed in the correct locations
                         */
                        // If the plugin has a public_html directory 
                        // then it should have files in Geeklog's public_html
                        $missing_public_html = false;
                        if (file_exists($plugin_dir . '/public_html')) { // If it has a public_html

                            if (!file_exists($_CONF['path_html'] . $plugin)) { // If it doesn't have a folder in GL's public_html

                                $missing_public_html = true;
    
                            }

                        }

                        // Check if the plugin has been correctly installed to Geeklog's public_html/admin
                        $missing_admin = false;
                        // Exists in public_html/admin/plugins/
                        // Set up the path to the admin directory
                        $admin_url = $_CONF['site_admin_url'];
                        if (strrpos ($admin_url, '/') == strlen ($admin_url)) {
                            // Strip the trailing "/" if it exists
                            $admin_url = substr ($admin_url, 0, -1);
                        }
                        $pos = strrpos ($admin_url, '/');
                        if ($pos === false) {
                            // didn't work out - use the URL
                            $admin_dir = $_CONF['site_admin_url'];
                        } else {
                            $admin_dir = $_CONF['path_html']
                                       . substr ($admin_url, $pos + 1);
                        }

                        $missing_autoinstall = false;
                        $info = INST_getPluginInfo($plugin);
                        if ($info === false) {
                            $missing_autoinstall = true;
                        } else {
                            $pi_name         = $info['pi_name'];
                            $pi_display_name = $info['pi_display_name'];
                            $pi_version      = $info['pi_version'];
                            $gl_version      = $info['pi_gl_version'];
                            $pi_url          = $info['pi_homepage'];
                        }

                        // If the plugin has been installed to the admin directory
                        if (! file_exists($admin_dir . '/plugins/' . $plugin)) {

                            $missing_admin = true;

                        }
                        if (! $missing_admin && empty($pi_name)) {
                        
                            /**
                             * Plugins keep their config info in install.php
                             */
                            
                            $plugin_inst = $admin_dir . '/plugins/' . $plugin . '/install.php';
                            $fdata = '';
                            $fhandle = @fopen($plugin_inst, 'r');
                            if ($fhandle) {
                                $fdata = fread($fhandle, filesize($plugin_inst));
                                fclose($fhandle);
                            }
                            $fdata = preg_replace('/\n/', '', $fdata);
                            $fdata = preg_replace('/ /', '', $fdata);

                            // $pi_name
                            if (preg_match('/^.*\$pi\_name=\'/', $fdata)) {

                                $pi_name = preg_replace('/^.*\$pi\_name=\'/', '', $fdata);
                                $pi_name = preg_replace('/\'.*$/', '', $pi_name);

                            } else {

                                $pi_name = $plugin;

                            }

                            // $pi_display_name
                            if (preg_match('/^.*\$pi\_display\_name=\'/', $fdata)) {

                                $pi_display_name = preg_replace('/^.*\$pi\_display\_name=\'/', '', $fdata);
                                $pi_display_name = preg_replace('/\'.*$/', '', $pi_display_name);

                            } else {
                            
                                $pi_display_name = ucwords(str_replace('_', ' ',
                                                           $pi_name));

                            }

                            // $pi_version
                            if (preg_match('/^.*\$pi\_version=\'/', $fdata)) {

                                $pi_version = preg_replace('/^.*\$pi\_version=\'/', '', $fdata);
                                $pi_version = preg_replace('/\'.*$/', '', $pi_version);

                            }
                            
                            // $gl_version
                            if (preg_match('/^.*\$gl\_version=\'/', $fdata)) {

                                $gl_version = preg_replace('/^.*\$gl\_version=\'/', '', $fdata);
                                $gl_version = preg_replace('/\'.*$/', '', $gl_version);

                            }

                            // $pi_url
                            if (preg_match('/^.*\$pi\_url=\'/', $fdata)) {

                                $pi_url = preg_replace('/^.*\$pi\_url=\'/', '', $fdata);
                                $pi_url = preg_replace('/\'.*$/', '', $pi_url);

                            }                                

                        }

                        $display .= '<tr>' . LB
                            . '<td align="center"><input type="checkbox" name="plugins[' . $plugin . '][install]"'
                                . ($missing_autoinstall ? ' disabled="disabled"' : ' checked="checked"') . XHTML . '>' . LB
                            . '</td>' . LB
                            . '<td valign="top">' . LB
                                . '<input type="hidden" name="plugins[' . $plugin . '][name]" value="' . $plugin . '"' . XHTML . '>' 
                                . '<input type="hidden" name="plugins[' . $plugin . '][pi_url]" value="' . $pi_url . '"' . XHTML . '>'
                                . $pi_display_name . LB
                                . ($missing_autoinstall ? '<p><small><b>' . $LANG_PLUGINS[17] . ':</b> ' . $LANG_PLUGINS[18] . '</small></p>' : '')
                            . '</td>' . LB
                            . '<td align="center"><input type="hidden" name="plugins[' . $plugin . '][version]" value="' . $pi_version . '"' . XHTML . '>' 
                                . $pi_version 
                            . '</td>' . LB
                            . '</tr>' . LB;

                    }
                }
            }

            // Form footer
            $display .= '</table><br' . XHTML . '>' . LB
                . '<input type="button" class="button big-button" name="refresh" value="' . $LANG_PLUGINS[19] . '" onclick="javascript:document.location.reload()"' . XHTML . '>' . LB
                . '<input type="submit" class="button big-button" name="submit" value="' . $LANG_INSTALL[50] . ' &gt;&gt;"' . XHTML . '>' . LB
                . '</form></p>' . LB;
                
        } else {

            $display .= '<p>' . $LANG_PLUGINS[20] . '</p>' . LB
                . '<form action="install-plugins.php" method="POST">' . LB
                . '<input type="submit" class="button big-button" name="refresh" value="' . $LANG_PLUGINS[19] . '"' . XHTML . '>' . LB
                . '</form></p>' . LB;
        
        }

        break;

    /**
     * Step 2 - Install the selected plugins 
     */
    case 2:

        $error = 0;
        foreach ($_POST['plugins'] as $plugin) {

            // If the plugin was selected to be installed
            if (isset($plugin['install']) && ($plugin['install'] == 'on')) {

                $pi_name = COM_applyFilter($plugin['name']);
                $pi_name = COM_sanitizeFilename($pi_name);

                $plugin_inst = $_CONF['path'] . 'plugins/' . $pi_name
                             . '/autoinstall.php';
                if (file_exists($plugin_inst)) {

                    require_once $plugin_inst;

                    $check_compatible = 'plugin_compatible_with_this_version_'
                                      . $pi_name;
                    if (function_exists($check_compatible)) {
                        if (! $check_compatible($pi_name)) {
                            continue; // with next plugin
                        }
                    }

                    $auto_install = 'plugin_autoinstall_' . $pi_name;
                    if (! function_exists($auto_install)) {
                        continue; // with next plugin
                    }

                    $inst_parms = $auto_install($pi_name);
                    if (($inst_parms === false) || empty($inst_parms)) {
                        continue; // with next plugin
                    }

                    INST_pluginAutoinstall($pi_name, $inst_parms);
                }

            }

        }

        // Done!

        header('Location: success.php?language=' . $language);

        break;

    } // End switch ($step)
} // end if (php_v())

$display .= INST_getFooter();

header('Content-Type: text/html; charset=' . COM_getCharset());
echo $display;

?>
