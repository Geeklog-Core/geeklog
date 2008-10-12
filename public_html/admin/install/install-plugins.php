<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | install-plugins.php                                                       |
// |                                                                           |
// | Install plugins.                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008 by the following authors:                              |
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
// | You don't need to change anything in this file.                           |
// | Please read docs/install.html which describes how to install Geeklog.     |
// +---------------------------------------------------------------------------+
//

// +---------------------------------------------------------------------------+
// | Main                                                                      |
// +---------------------------------------------------------------------------+

require_once '../../lib-common.php';
require_once 'lib-install.php';

// Set some vars
$html_path          = str_replace('admin/install/install-plugins.php', '', str_replace('admin\install\install-plugins.php', '', str_replace('\\', '/', __FILE__)));
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

$dbconfig_path      = (isset($_REQUEST['dbconfig_path'])) ? $_REQUEST['dbconfig_path'] : $gl_path . '/db-config.php';
$step               = (isset($_REQUEST['step'])) ? $_REQUEST['step'] : 1;

// $display holds all the outputted HTML and content
$display = INST_getHeader('Step' . ' 3 - Plugin Installation'); // Grab the beginning HTML for the installer theme.

// Make sure the version of PHP is supported.
if (INST_phpOutOfDate()) {

    // If their version of PHP is not supported, print an error:
    $display .= '<h1>' . $LANG_INSTALL[4] . '</h1>' . LB;
    $display .= '<p>' . $LANG_INSTALL[5] . $phpv[0] . '.' . $phpv[1] . '.' . (int) $phpv[2] . $LANG_INSTALL[6] . '</p>' . LB;

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
                            && is_writable($_CONF['path_html'] . 'admin/plugins/')) 
                                ? true
                                : false;

        $display .= '<p>Geeklog plugins are addon components that provide new functionality and leverage the internal services of Geeklog. Plugins are different then blocks which normally do not use any of the internal Geeklog services. By default, Geeklog includes a few useful plugins that you may want to install. ' 
            . ($upload_enabled ? 'You can also choose to upload additional plugins.' : '')
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

                    $display .= '<div class="notice"><span class="error">' . $LANG_INSTALL[38] . '</span> The file you uploaded was not a GZip compressed plugin file.</div>' . LB;

                } else if (file_exists($_CONF['path'] . 'plugins/' . $dirname)) { // If plugin directory already exists

                    $display .= '<div class="notice"><span class="error">' . $LANG_INSTALL[38] . '</span> The plugin you uploaded already exists!</div>' . LB;

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
                    $fhandle = fopen($plugin_inst, 'r');
                    $fdata = fread($fhandle, filesize($plugin_inst));
                    fclose($fhandle);

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

                    }

                    // Extract the uploaded archive to the plugins directory
                    if ($_FILES['plugin']['type'] == 'application/zip') {
    
                        // Zip
                        $upload_success = $archive->extract(array('add_path' => $_CONF['path'] . 'plugins/'));

                    } else {

                        // Tarball
                        $upload_success = $archive->extract($_CONF['path'] . 'plugins/');

                    }
                    if ($upload_success) { 

                        if (file_exists($_CONF['path'] . 'plugins/' . $pi_name . '/public_html')) {
                            rename($_CONF['path'] . 'plugins/' . $pi_name . '/public_html', $_CONF['path_html'] . $pi_name);
                        }
                        rename($_CONF['path'] . 'plugins/' . $pi_name . '/admin', $_CONF['path_html'] . 'admin/plugins/' . $pi_name);

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
                    ? '<div class="notice"><span class="success">Success!</span> The ' . $pi_name . ' plugin was uploaded successfully.</div>' 
                    : '') . LB
                . '<h2>Upload a plugin</h2>' . LB
                . '<form name="plugins_upload" action="install-plugins.php" method="POST" enctype="multipart/form-data">' . LB
                . '<input type="hidden" name="language" value="' . $language . '"' . XHTML . '>' . LB
                . '<p><label class="' . $form_label_dir . '">Select plugin file ' . INST_helpLink('plugin_upload') . '</label> ' . LB
                . '<input type="file" name="plugin" size="25"' . XHTML . '></p>' . LB
                . '<p><input type="submit" name="upload" value="Upload"' . XHTML . '></p>' . LB
                . '</form>' . LB;

        }

        // Check if there are any plugins that need to be installed
        $plugins_dir = $_CONF['path'] . 'plugins/';
        $new_plugins = 0;
        $fd = opendir($plugins_dir);
        while (($plugin = @readdir($fd)) == TRUE) {

            if (is_dir ($plugins_dir . $plugin) && ($plugin != '.') && ($plugin != '..') &&
                    ($plugin != 'CVS') && (substr ($plugin, 0 , 1) != '.')) {

                clearstatcache ();

                // Check and see if this plugin is installed (if there is a record)
                // If no record exists in the plugins table then it's a new plugin
                if (DB_count($_TABLES['plugins'], 'pi_name', $plugin) == 0) {

                    $new_plugins++;

                }

            }

        }

        $display .= '<br' . XHTML . '><h2>Select which plugins to install</h2>' . LB;

        // If there are new plugins
        if ($new_plugins > 0) {

            // Form header
            $display .= '<p><form action="install-plugins.php" method="POST" name="plugin_list">' . LB
                . '<input type="hidden" name="language" value="' . $language . '"' . XHTML . '>' . LB
                . '<input type="hidden" name="step" value="2"' . XHTML . '>' . LB
                . '<table width="650px">' . LB
                . '<tr>' . LB
                    . '<th width="60">Install?</th>' . LB
                    . '<th>Plugin</th>' . LB
                    . '<th width="75">Version</th>' . LB
                . '</tr>' . LB;

            /**
             * List plugins that are available for install
             */
            $fd = opendir($plugins_dir);
            while (($plugin = @readdir($fd)) == TRUE) {
    
                if (is_dir ($plugins_dir . $plugin) && ($plugin != '.') && ($plugin != '..') &&
                        ($plugin != 'CVS') && (substr ($plugin, 0 , 1) != '.') && ($plugin != '__MACOSX')) {
    
                    clearstatcache ();
                    $plugin_dir = $plugins_dir . $plugin;

                    // Check and see if this plugin is installed (if there is a record)
                    // If no record exists in the plugins table then it's a new plugin
                    if (DB_count($_TABLES['plugins'], 'pi_name', $plugin) == 0) {

                        $pi_display_name    = '';
                        $pi_version         = 'Unknown';
                        $gl_version         = 'Unknown';
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

                        // If the plugin has been installed to the admin directory
                        if (!file_exists($admin_dir . '/plugins/' . $plugin)) {

                            $missing_admin = true;

                        } else {
                        
                            /**
                             * Plugins keep their config info in install.php
                             */
                            $plugin_inst = $admin_dir . '/plugins/' . $plugin . '/install.php';
                            $fhandle = fopen($plugin_inst, 'r');
                            $fdata = fread($fhandle, filesize($plugin_inst));
                            fclose($fhandle);
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
                            
                                $pi_display_name = $pi_name;

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
                                . ($missing_public_html || $missing_admin ? ' disabled="true"' : ' checked="checked"') . XHTML . '>' . LB
                            . '</td>' . LB
                            . '<td valign="top">' . LB
                                . '<input type="hidden" name="plugins[' . $plugin . '][name]" value="' . $plugin . '"' . XHTML . '>' 
                                . '<input type="hidden" name="plugins[' . $plugin . '][pi_url]" value="' . $pi_url . '"' . XHTML . '>'
                                . $pi_display_name . LB
                                . ($missing_public_html || $missing_admin 
                                    ? '<br' . XHTML . '><br' . XHTML . '><p><small><span class="error">Warning:</span> This plugin is not fully installed. Check that the plugin has been correctly installed to:<br' . XHTML . '><br' . XHTML . '>' 
                                        . ($missing_public_html ? '<code>' . $_CONF['path_html'] . '</code><br' . XHTML . '>' : '') 
                                        . ($missing_admin ? '<code>' . $admin_dir . '</code><br' . XHTML . '>' : '') . '</small></p>'
                                    : '')
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
                . '<input type="button" name="refresh" value="' . 'Refresh' . '" onclick="javascript:document.location.reload()"' . XHTML . '>' . LB
                . '<input type="submit" name="submit" value="' . $LANG_INSTALL[50] . ' &gt;&gt;"' . XHTML . '>' . LB
                . '</form></p>' . LB;
                
        } else {

            $display .= '<p>There are no new plugins to install.</p>' . LB
                . '<form action="install-plugins.php" method="POST">' . LB
                . '<input type="submit" name="refresh" value="' . 'Refresh' . '"' . XHTML . '>' . LB
                . '</form></p>' . LB;
        
        }

        break;

    /**
     * Step 2 - Install the selected plugins 
     */
    case 2:

        $error = 0;
/*
        foreach ($_POST['plugins'] as $plugin) {

            // If the plugin was selected to be installed
            if (isset($plugin['install']) && ($plugin['install'] == 'on')) {
*/
                /**
                 * Install the plugin by including & executing the database queries for each plugin
                 * Start by looking for the database install file.
                 */
/*
                $plugin_sql = '';
                if (file_exists($_CONF['path'] . 'plugins/' . $plugin['name'] . '/sql/' . $_DB_dbms . '_install.php')) {

                    $plugin_sql = $_CONF['path'] . 'plugins/' . $plugin['name'] . '/sql/' . $_DB_dbms . '_install.php'; 
                
                } else if (file_exists($_CONF['path'] . 'plugins/' . $plugin['name'] . '/sql/install.php')) {
                
                    $plugin_sql = $_CONF['path'] . 'plugins/' . $plugin['name'] . '/sql/install.php';
                
                }

                $plugin_func = $_CONF['path'] . 'plugins/' . $plugin['name'] . '/functions.inc';

                if (file_exists($plugin_sql)) { // If database table and/or data exists for this plugin

                    $plugin_conf = $_CONF['path'] . 'plugins/' . $plugin['name'] . '/config.php';
                    if (file_exists($plugin_conf)) {

                        require_once $plugin_conf;

                    }

                    $_SQL   = array();          // Initialize for each plugin, otherwise the queries for the first plugin
                    $_DATA  = array();          // will execute twice if more than one plugin is being installed.
                    require_once $plugin_sql;   // Include $_SQL and $_DATA for each plugin, 
                                                // these arrays contain the DB structures and data.


                    foreach ($_SQL as $sql) {   

                        DB_query($sql);     // Create the table structures, if necessary
                        //sanity($sql);

                    }

                    foreach ($_DATA as $data) {

                        DB_query($data);    // Insert necessary data, if any
                        //sanity($data);

                    }

                    // Enable the plugin in the plugins table
                    // Todo: This should be checked for injection attempts or does DB_query() do that automatically?
                    DB_query("INSERT INTO {$_TABLES['plugins']} (`pi_name`, `pi_version`, `pi_gl_version`, `pi_enabled`, `pi_homepage`) VALUES ( '{$plugin['name']}', '{$plugin['version']}', '" . VERSION . "', 1, '{$plugin['pi_url']}')");

                } 

            }

        }
*/
        // Done!
//            $display .= '<p>Done doing stuff</p>' . LB;
        header('Location: success.php?language=' . $language);

        break;

    } // End switch ($step)
} // end if (php_v())

$display .= INST_getFooter();

echo $display;

?>
