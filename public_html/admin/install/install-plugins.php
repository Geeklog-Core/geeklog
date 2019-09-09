<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | install-plugins.php                                                       |
// |                                                                           |
// | Install plugins.                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2017 by the following authors:                         |
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

global $_CONF, $_TABLES, $LANG_INSTALL, $LANG_PLUGINS;

if (!defined('BASE_FILE')) {
    define(
        'BASE_FILE',
        str_replace('\\', '/', str_replace(basename(__FILE__), 'index.php', __FILE__))
    );
}

if (!defined('PATH_INSTALL')) {
    define('PATH_INSTALL', __DIR__ . '/');
}

if (!defined('PATH_LAYOUT')) {
    define('PATH_LAYOUT', PATH_INSTALL . 'layout');
}

require_once '../../lib-common.php';
require_once './classes/micro_template.class.php';
require_once './classes/installer.class.php';
$installer = new Installer();

// Set some vars
$html_path = $installer->getHtmlPath();
$language = $installer->get('language', $installer->post('language', Installer::DEFAULT_LANGUAGE));
$siteconfig_path = '../../siteconfig.php';
$pi_name = '';

if ($_CONF['path'] === '/path/to/Geeklog/') { // If the Geeklog path has not been defined.
    // Attempt to locate Geeklog's path
    $gl_path = str_replace('\\', '/', __FILE__);

    for ($i = 0; $i < 4; $i++) {
        $remains = strrchr($gl_path, '/');
        if ($remains === false) {
            break;
        } else {
            $gl_path = substr($gl_path, 0, -strlen($remains));
        }
    }

    $_CONF['path'] = $gl_path;
}

$dbconfig_path = isset($_POST['dbconfig_path'])
    ? $_POST['dbconfig_path']
    : (isset($_GET['dbconfig_path']) ? $_GET['dbconfig_path'] : $_CONF['path'] . '/db-config.php');
$dbconfig_path = $installer->sanitizePath($dbconfig_path);
$step = isset($_GET['step'])
    ? $_GET['step']
    : (isset($_POST['step']) ? $_POST['step'] : 1);

if (file_exists(PATH_INSTALL . 'language/' . $language . '.php')) {
    include_once PATH_INSTALL . 'language/' . $language . '.php';
} else {
    include_once PATH_INSTALL . 'language/' . Installer::DEFAULT_LANGUAGE . '.php';
}

if (!isset($LANG_DIRECTION)) {
    $LANG_DIRECTION = 'ltr';
}
if ($LANG_DIRECTION === 'rtl') {
    $icon_arrow_next = '<span uk-icon="icon: chevron-double-left"></span>';
} else {
    $icon_arrow_next = '<span uk-icon="icon: chevron-double-right"></span>';
}

// $content holds all the outputted HTML and content
$content = '<h1>' . $LANG_PLUGINS[2] . ' 3 - ' . $LANG_PLUGINS[1] . '</h1>' . PHP_EOL;

// Make sure the version of PHP is supported.
$installer->checkPhpVersion();

// Ok, the user's version of PHP is supported. Let's move on
switch ($step) {
    /**
     * Step 1 - Display the upload form and allow
     * the user to select which plugins to install
     */
    case 1:
        // If 'file_uploads' is enabled in php.ini and the plugin directories are writable by the web server.
        $upload_enabled = ini_get('file_uploads')
            && is_writable($_CONF['path'] . 'plugins/')
            && is_writable($_CONF['path_html'])
            && is_writable($installer->getAdminPath() . 'plugins/');
        $content .= '<p>' . $LANG_PLUGINS[3]
            . ($upload_enabled ? ' ' . $LANG_PLUGINS[4] : '')
            . '</p>' . PHP_EOL;

        // Check if a plugin file was uploaded
        $upload_success = false;

        if (isset($_FILES['plugin'])) {
            if ($error_msg = $installer->getUploadError($_FILES['plugin'])) { // If an error occurred while uploading the file.
                $content .= '
                    <div class="uk-alert-danger" uk-alert>
                        <p><span class="uk-label uk-label-danger">
                            ' . $LANG_INSTALL[38] . '</span> ' . $error_msg . '
                        </p>
                    </div>' . PHP_EOL;
            } else {
                $plugin_file = $_CONF['path_data'] . $_FILES['plugin']['name']; // Name the plugin file
                $archive = new Unpacker($_CONF['path_data'] . $_FILES['plugin']['name'], $_FILES['plugin']['type']);
                $contents = $archive->getList();
                $dirName = preg_replace('/\/.*$/', '', $contents[0]['filename']);

                if (empty($dirName)) { // If $dirname is blank it's probably because the user uploaded a non Tarball file.
                    $content .= '
                        <div class="uk-alert-danger" uk-alert>
                            <p><span class="uk-label uk-label-danger">
                                ' . $LANG_INSTALL[38] . '</span> ' . $LANG_PLUGINS[5] . '
                            </p>
                        </div>' . PHP_EOL;
                } elseif (file_exists($_CONF['path'] . 'plugins/' . $dirName)) { // If plugin directory already exists
                    $content .= '
                        <div class="uk-alert-danger" uk-alert>
                            <p><span class="uk-label uk-label-danger">
                                ' . $LANG_INSTALL[38] . '</span> ' . $LANG_PLUGINS[6] . '
                            </p>
                        </div>' . PHP_EOL;
                } else {
                    /**
                     * Install the plugin
                     * This doesn't work if the public_html & public_html/admin/plugins directories aren't 777
                     */

                    // Extract the archive to data so we can get the $pi_name name from admin/install.php
                    $archive->unpack($_CONF['path'] . 'data/', '|' . preg_quote($dirName . '/admin/install.php', '|') . '|');
                    $plugin_inst = $_CONF['path'] . 'data/' . $dirName . '/admin/install.php';
                    $fileData = @file_get_contents($plugin_inst);

                    // Remove the plugin from data/
                    Geeklog\FileSystem::remove($_CONF['path'] . 'data/' . $dirName);

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
                    $archive->unpack($_CONF['path'] . 'plugins/');
                    $plg_path = $_CONF['path'] . 'plugins/' . $pi_name . '/';

                    if ($upload_success) {
                        if (file_exists($plg_path . 'public_html')) {
                            rename($plg_path . 'public_html', $_CONF['path_html'] . $pi_name);
                        }

                        if (file_exists($plg_path . 'admin')) {
                            rename($plg_path . 'admin', $installer->getAdminPath() . 'plugins/' . $pi_name);
                        }
                    }

                    unset($archive);
                }
            }
        } // End check if a plugin file was uploaded

        // If the web server will allow the user to upload a plugin
        if ($upload_enabled) {
            // Show the upload form
            $content .= 
                  ($upload_success
                    ? '<div class="uk-alert-success" uk-alert><p><span class="uk-label uk-label-success">' . $LANG_PLUGINS[7] . '</span> ' . sprintf($LANG_PLUGINS[8], $pi_name) . '</p></div>'
                    : '') . PHP_EOL
                . '<h2>' . $LANG_PLUGINS[9] . '</h2>' . PHP_EOL
                . '<form name="plugins_upload" action="install-plugins.php" method="post" enctype="multipart/form-data">' . PHP_EOL
                . '<input type="hidden" name="language" value="' . $language . '">' . PHP_EOL
                
                . ' <div class="uk-margin" uk-margin>
                        <div uk-form-custom="target: true">
                            <input type="file" name="plugin">
                            <input class="uk-input uk-form-width-medium" type="text" placeholder="' . $LANG_PLUGINS[10] . '" disabled>
                        </div>
                        <button type="submit" class="uk-button uk-button-primary uk-margin-small" name="upload" value="' . $LANG_PLUGINS[11] . '">' . $LANG_PLUGINS[11] . '</button>
                    </div>'                
                . '</form>' . PHP_EOL;
        }

        // Check if there are any plugins that need to be installed
        $plugins_dir = $_CONF['path'] . 'plugins/';
        $numNewPlugins = 0;
        $newPlugins = array();

        foreach (scandir($_CONF['path'] . 'plugins/') as $plugin) {
            if (($plugin !== '.') && ($plugin !== '..') && ($plugin !== 'CVS')) {
                $firstLetter = substr($plugin, 0, 1);

                if (($firstLetter !== '.') && ($firstLetter !== '_')) {
                    // Check and see if this plugin is installed (if there is a record)
                    // If no record exists in the plugins table then it's a new plugin
                    if (DB_count($_TABLES['plugins'], 'pi_name', $plugin) == 0) {
                        $newPlugins[] = $plugin;
                        $numNewPlugins++;
                    }
                }
            }
        }

        $content .= '<h2>' . $LANG_PLUGINS[12] . '</h2>' . PHP_EOL;

        // If there are new plugins
        if ($numNewPlugins > 0) {
            // Form header
            $content .= '<form action="install-plugins.php" method="post" name="plugin_list">' . PHP_EOL
                . '<input type="hidden" name="language" value="' . $language . '">' . PHP_EOL
                . '<input type="hidden" name="step" value="2">' . PHP_EOL

                . '<div class="uk-overflow-auto">' . PHP_EOL
                
                . '<table class="uk-table uk-table-small uk-table-middle">' . PHP_EOL
                . '<thead>' . PHP_EOL
                . '<tr>' . PHP_EOL
                . '<th class="uk-text-center">' . $LANG_PLUGINS[13] . '</th>' . PHP_EOL
                . '<th>' . $LANG_PLUGINS[14] . '</th>' . PHP_EOL
                . '<th class="uk-text-center">' . $LANG_PLUGINS[15] . '</th>' . PHP_EOL
                . '</tr>' . PHP_EOL
                . '</thead>' . PHP_EOL;

            // List plugins that are available for install
            $content .= '<tbody>' . PHP_EOL;
            foreach ($newPlugins as $plugin) {
                $pi_name = '';
                $pi_display_name = '';
                $pi_version = $LANG_PLUGINS[16];
                $gl_version = $LANG_PLUGINS[16];
                $pi_url = '';
                $plugin_dir = $plugins_dir . $plugin;

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
                $admin_url = rtrim($admin_url, '/');
                $pos = strrpos($admin_url, '/');

                if ($pos === false) {
                    // didn't work out - use the URL
                    $admin_dir = $_CONF['site_admin_url'];
                } else {
                    $admin_dir = $_CONF['path_html'] . substr($admin_url, $pos + 1);
                }

                $missing_autoinstall = false;
                $info = $installer->getPluginInfo($plugin);

                if ($info === false) {
                    $missing_autoinstall = true;
                } else {
                    $pi_name = $info['pi_name'];
                    $pi_display_name = $info['pi_display_name'];
                    $pi_version = $info['pi_version'];
                    $gl_version = $info['pi_gl_version'];
                    $pi_url = $info['pi_homepage'];
                }

                // If the plugin has been installed to the admin directory
                if (!file_exists($admin_dir . '/plugins/' . $plugin)) {
                    $missing_admin = true;
                }

                if (!$missing_admin && empty($pi_name)) {
                    // Plugins keep their config info in install.php
                    $plugin_inst = $admin_dir . '/plugins/' . $plugin . '/install.php';
                    $fileData = @file_get_contents($plugin_inst);
                    $fileData = str_replace(array("\n", ' '), '', $fileData);

                    // $pi_name
                    if (preg_match('/^.*\$pi\_name=\'/', $fileData)) {
                        $pi_name = preg_replace('/^.*\$pi\_name=\'/', '', $fileData);
                        $pi_name = preg_replace('/\'.*$/', '', $pi_name);
                    } else {
                        $pi_name = $plugin;
                    }

                    // $pi_display_name
                    if (preg_match('/^.*\$pi\_display\_name=\'/', $fileData)) {
                        $pi_display_name = preg_replace('/^.*\$pi\_display\_name=\'/', '', $fileData);
                        $pi_display_name = preg_replace('/\'.*$/', '', $pi_display_name);
                    } else {
                        $pi_display_name = ucwords(str_replace('_', ' ', $pi_name));
                    }

                    // $pi_version
                    if (preg_match('/^.*\$pi\_version=\'/', $fileData)) {
                        $pi_version = preg_replace('/^.*\$pi\_version=\'/', '', $fileData);
                        $pi_version = preg_replace('/\'.*$/', '', $pi_version);
                    }

                    // $gl_version
                    if (preg_match('/^.*\$gl\_version=\'/', $fileData)) {
                        $gl_version = preg_replace('/^.*\$gl\_version=\'/', '', $fileData);
                        $gl_version = preg_replace('/\'.*$/', '', $gl_version);
                    }

                    // $pi_url
                    if (preg_match('/^.*\$pi\_url=\'/', $fileData)) {
                        $pi_url = preg_replace('/^.*\$pi\_url=\'/', '', $fileData);
                        $pi_url = preg_replace('/\'.*$/', '', $pi_url);
                    }
                }

                $content .= '<tr>' . PHP_EOL
                    . '<td><input type="checkbox" class="uk-check uk-align-center" name="plugins[' . $plugin . '][install]"'
                    . ($missing_autoinstall ? ' disabled="disabled"' : ' checked="checked"') . '>' . PHP_EOL
                    . '</td>' . PHP_EOL
                    . '<td>' . PHP_EOL
                    . '<input type="hidden" name="plugins[' . $plugin . '][name]" value="' . $plugin . '">'
                    . '<input type="hidden" name="plugins[' . $plugin . '][pi_url]" value="' . $pi_url . '">'
                    . $pi_display_name . PHP_EOL
                    . ($missing_autoinstall ? '<div class="uk-alert-warning" uk-alert><p><span class="uk-label uk-label-warning">' . $LANG_PLUGINS[17] . '</span> ' . $LANG_PLUGINS[18] . '</p></div>' : '')
                    . '</td>' . PHP_EOL
                    . '<td class="uk-text-center"><input type="hidden" name="plugins[' . $plugin . '][version]" value="' . $pi_version . '">'
                    . $pi_version
                    . '</td>' . PHP_EOL
                    . '</tr>' . PHP_EOL;
            }
            $content .= '</tbody>' . PHP_EOL;

            // Form footer
            $content .= '</table>' . PHP_EOL
                . '</div>' . PHP_EOL
                . '<button type="button" class="uk-button uk-button-secondary uk-margin-small" name="refresh" value="' . $LANG_PLUGINS[19] . '" onclick="javascript:document.location.reload()">' . $LANG_PLUGINS[19] . '</button>' . PHP_EOL
                . '<button type="submit" class="uk-button uk-button-primary uk-margin-small" name="submit" value="' . $LANG_INSTALL[50] . '">'
                . $LANG_INSTALL[50] . '&nbsp;&nbsp;' . $icon_arrow_next . '</button>'  . PHP_EOL
                . '</form>' . PHP_EOL;
        } else {
            $content .= '<p>' . $LANG_PLUGINS[20] . '</p>' . PHP_EOL
                . '<form action="install-plugins.php" method="post">' . PHP_EOL
                . '<button type="submit" class="uk-button uk-button-primary uk-margin-small" name="refresh" value="' 
                . $LANG_PLUGINS[19] . '">' . $LANG_INSTALL[50] . '</button>' . PHP_EOL
                . '</form>' . PHP_EOL;
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
                $plugin_inst = $_CONF['path'] . 'plugins/' . $pi_name . '/autoinstall.php';

                if (file_exists($plugin_inst)) {
                    require_once $plugin_inst;

                    $check_compatible = 'plugin_compatible_with_this_version_' . $pi_name;

                    if (function_exists($check_compatible)) {
                        if (!$check_compatible($pi_name)) {
                            continue; // with next plugin
                        }
                    }

                    $auto_install = 'plugin_autoinstall_' . $pi_name;

                    if (!function_exists($auto_install)) {
                        continue; // with next plugin
                    }

                    $inst_params = $auto_install($pi_name);

                    if (($inst_params === false) || empty($inst_params)) {
                        continue; // with next plugin
                    }

                    $installer->pluginAutoInstall($pi_name, $inst_params);
                }
            }
        }

        // Done!
        header('Location: success.php?language=' . $language);
        break;
} // End switch ($step)

$installer->display($content);
