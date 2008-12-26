<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog installation script.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Matt West         - matt AT mattdanger DOT net                   |
// |          Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Randy Kolenko     - randy AT nextide DOT ca                      |
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
// $Id: index.php,v 1.47 2008/06/15 06:41:26 mwest Exp $

require_once "lib-install.php";


/*
 * Installer engine
 *
 * The guts of the installation and upgrade package.
 *
 * @param   string  $install_type   'install' or 'upgrade'
 * @param   int     $install_step   1 - 3
 */
function INST_installEngine($install_type, $install_step)
{
    global $_CONF, $LANG_INSTALL, $LANG_CHARSET, $_DB, $_TABLES, $gl_path, $html_path, $dbconfig_path, $siteconfig_path, $display, $language, $form_label_dir;

    switch ($install_step) {

    /**
     * Page 1 - Enter Geeklog config information
     */
    case 1:
        require_once $dbconfig_path; // Get the current DB info

        if ($install_type == 'upgrade') {
            $v = INST_checkPost150Upgrade($dbconfig_path, $siteconfig_path);
            // will skip to step 3 if possible, otherwise return here

            if ($v == VERSION) {
                // looks like we're already up to date
                $display .= '<h2>' . $LANG_INSTALL[74] . '</h2>' . LB
                         . '<p>' . $LANG_INSTALL[75] . '</p>';
                return;
            }
        }

        $display .= '<h1 class="heading">' . 'Step' . ' ' . $_REQUEST['display_step'] . ' - Enter configuration information</h1>' . LB;


        // Set all the form values either with their defaults or with received POST data.
        // The only instance where you'd get POST data would be if the user has to
        // go back because they entered incorrect database information.
        $site_name = (isset($_POST['site_name'])) ? str_replace('\\', '', $_POST['site_name']) : $LANG_INSTALL[29];
        $site_slogan = (isset($_POST['site_slogan'])) ? str_replace('\\', '', $_POST['site_slogan']) : $LANG_INSTALL[30];
        $mysql_innodb_selected = '';
        $mysql_selected = '';
        $mssql_selected = '';
        if (isset($_POST['db_type'])) {
            switch ($_POST['db_type']) {
                case 'mysql-innodb':
                    $mysql_innodb_selected = ' selected="selected"';
                    break;
                case 'mssql':
                    $mssql_selected = ' selected="selected"';
                    break;
                default:
                    $mysql_selected = ' selected="selected"';
                    break;
            }
        } else {
            switch ($_DB_dbms) {
                case 'mssql':
                    $mssql_selected = ' selected="selected"';
                    break;
                default:
                    $mysql_selected = ' selected="selected"';
                    break;
            }
        }
        if (($_DB_host != 'localhost') || ($_DB_name != 'geeklog') ||
                ($_DB_user != 'username') || ($_DB_pass != 'password')) {
            // only display those if they all have their default values
            $_DB_host = '';
            $_DB_name = '';
            $_DB_user = '';
            $_DB_pass = '';
        }
        $db_host = isset($_POST['db_host']) ? $_POST['db_host']
                 : ($_DB_host != 'localhost' ? '' : $_DB_host);
        $db_name = isset($_POST['db_name']) ? $_POST['db_name']
                 : ($_DB_name != 'geeklog' ? '' : $_DB_name);
        $db_user = isset($_POST['db_user']) ? $_POST['db_user']
                 : ($_DB_user != 'username' ? '' : $_DB_user);
        $db_pass = isset($_POST['db_pass']) ? $_POST['db_pass'] : '';
        $db_prefix = isset($_POST['db_prefix']) ? $_POST['db_prefix']
                   : $_DB_table_prefix;

        $site_url = isset($_POST['site_url']) ? $_POST['site_url'] : 'http://' . $_SERVER['HTTP_HOST'] . preg_replace('/\/admin.*/', '', $_SERVER['PHP_SELF']) ;
        $site_admin_url = isset($_POST['site_admin_url']) ? $_POST['site_admin_url'] : 'http://' . $_SERVER['HTTP_HOST'] . preg_replace('/\/install.*/', '', $_SERVER['PHP_SELF']) ; 
        $host_name = explode(':', $_SERVER['HTTP_HOST']);
        $host_name = $host_name[0];
        if (empty($_CONF['site_mail'])) {
            $_CONF['site_mail'] = 'admin@example.com';
        }
        $site_mail = isset($_POST['site_mail']) ? $_POST['site_mail'] : ($_CONF['site_mail'] != 'admin@example.com' ? $_CONF['site_mail'] : 'admin@' . $host_name);
        if (empty($_CONF['noreply_mail'])) {
            $_CONF['noreply_mail'] = 'noreply@example.com';
        }
        $noreply_mail = isset($_POST['noreply_mail']) ? $_POST['noreply_mail'] : ($_CONF['noreply_mail'] != 'noreply@example.com' ? $_CONF['noreply_mail'] : 'noreply@' . $host_name);
        if (isset($_POST['utf8']) && ($_POST['utf8'] == 'on')) {
            $utf8 = true;
        } else {
            $utf8 = false;
            if (strcasecmp($LANG_CHARSET, 'utf-8') == 0) {
                $utf8 = true;
            }
        }

        if ($install_type == 'install') {
            $buttontext = $LANG_INSTALL[50];
        } else {
            $buttontext = $LANG_INSTALL[25];
        }

        $display .= '<h2>' . $LANG_INSTALL[31] . '</h2>
            <form action="index.php" method="post" name="install">
            <input type="hidden" name="mode" value="' . $install_type . '"' . XHTML . '>
            <input type="hidden" name="step" value="2"' . XHTML . '>
            <input type="hidden" name="display_step" value="' . $_REQUEST['display_step'] . '"' . XHTML . '>
            <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
            <input type="hidden" name="dbconfig_path" value="' . $dbconfig_path . '"' . XHTML . '>

            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[32] . ' ' . INST_helpLink('site_name') . '</label> <input type="text" name="site_name" value="' . $site_name . '" size="40"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[33] . ' ' . INST_helpLink('site_slogan') . '</label> <input type="text" name="site_slogan" value="' . $site_slogan . '" size="40"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[34] . ' ' . INST_helpLink('db_type') . '</label> <select name="db_type">
                <option value="mysql"' . $mysql_selected . '>' . $LANG_INSTALL[35] . '</option>
                ' . ($install_type == 'install' ? '<option value="mysql-innodb"' . $mysql_innodb_selected . '>' . $LANG_INSTALL[36] . '</option>' : '') . '
                <option value="mssql"' . $mssql_selected . '>' . $LANG_INSTALL[37] . '</option></select> ' . '</p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[39] . ' ' . INST_helpLink('db_host') . '</label> <input type="text" name="db_host" value="'. $db_host .'" size="20"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[40] . ' ' . INST_helpLink('db_name') . '</label> <input type="text" name="db_name" value="'. $db_name . '" size="20"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[41] . ' ' . INST_helpLink('db_user') . '</label> <input type="text" name="db_user" value="' . $db_user . '" size="20"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[42] . ' ' . INST_helpLink('db_pass') . '</label> <input type="password" name="db_pass" value="' . $db_pass . '" size="20"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[43] . ' ' . INST_helpLink('db_prefix') . '</label> <input type="text" name="db_prefix" value="' . $db_prefix . '" size="20"' . XHTML . '></p>

            <br' . XHTML . '>
            <h2>' . $LANG_INSTALL[44] . '</h2> 
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[45] . ' ' . INST_helpLink('site_url') . '</label> <input type="text" name="site_url" value="' . $site_url . '" size="50"' . XHTML . '>  &nbsp; ' . $LANG_INSTALL[46] . '</p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[47] . ' ' . INST_helpLink('site_admin_url') . '</label> <input type="text" name="site_admin_url" value="' . $site_admin_url . '" size="50"' . XHTML . '>  &nbsp; ' . $LANG_INSTALL[46] . '</p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[48] . ' ' . INST_helpLink('site_mail') . '</label> <input type="text" name="site_mail" value="' . $site_mail . '" size="50"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[49] . ' ' . INST_helpLink('noreply_mail') . '</label> <input type="text" name="noreply_mail" value="' . $noreply_mail . '" size="50"' . XHTML . '></p>';

        if ($install_type == 'install') {
            $display .= '
                <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[92] . ' ' . INST_helpLink('utf8') . '</label> <input type="checkbox" name="utf8"' . ($utf8 ? ' checked="checked"' : '') . XHTML . '></p>';
        }


        $display .='<br' . XHTML . '>
            <input type="submit" name="submit" class="submit" value="' . $buttontext . ' &gt;&gt;"' . XHTML . '>
            <input type="submit" name="install_plugins" class="submit" value="' . $buttontext . ' and configure additional plugins' . ' &gt;&gt;"' . XHTML . '>
            </form>' . LB;

        break;


    /**
     * Page 2 - Enter information into db-config.php
     * and ask about InnoDB tables (if supported)
     */
    case 2:

        // Set all the variables from the received POST data.
        $site_name = $_POST['site_name'];
        $site_slogan = $_POST['site_slogan'];
        $site_url = $_POST['site_url'];
        $site_admin_url = $_POST['site_admin_url'];
        $site_mail = $_POST['site_mail'];
        $noreply_mail = $_POST['noreply_mail'];
        $utf8 = (isset($_POST['utf8']) && ($_POST['utf8'] == 'on')) ? true : false;
        $install_plugins = (isset($_POST['install_plugins'])) ? true : false;
        $DB = array('type' => $_POST['db_type'],
                    'host' => $_POST['db_host'],
                    'name' => $_POST['db_name'],
                    'user' => $_POST['db_user'],
                    'pass' => $_POST['db_pass'],
                    'table_prefix' => $_POST['db_prefix']);

        // Check if $site_admin_url is correct
        if (!INST_urlExists($site_admin_url)) {

            $display .= '<h2>' . 'Incorrect Admin Directory Path' . '</h2><p>'
                     . 'Sorry, but the admin directory path you entered does not appear to be correct. Please go back and try again.' . '</p>'
                     . INST_showReturnFormData($_POST) . LB;

        // Check if we can connect to the database
        } else if (!INST_dbConnect($DB)) { 

            $display .= '<h2>' . $LANG_INSTALL[54] . '</h2><p>'
                     . $LANG_INSTALL[55] . '</p>'
                     . INST_showReturnFormData($_POST) . LB;

        // Check if the user's version of MySQL is out of date
        } else if (INST_mysqlOutOfDate($DB)) { 

            $display .= '<h1>' . $LANG_INSTALL[51] . '</h1>' . LB;
            $display .= '<p>' . $LANG_INSTALL[52] . $myv[0] . '.' . $myv[1] . '.' . $myv[2] . $LANG_INSTALL[53] . '</p>' . LB;

        // Check if database doesn't exist
        } else if (!INST_dbExists($DB)) {

            $display .= '<h2>' . $LANG_INSTALL[56] . '</h2>
                <p>' . $LANG_INSTALL[57] . '</p>' . INST_showReturnFormData($_POST) . LB;

        } else {

            // Write the database info to db-config.php
            if (!INST_writeConfig($dbconfig_path, $DB)) {

                exit($LANG_INSTALL[26] . ' ' . $dbconfig_path . $LANG_INSTALL[58]);

            }

            // for the default charset, patch siteconfig.php again
            if ($install_type != 'upgrade') {
                if (!INST_setDefaultCharset($siteconfig_path,
                        ($utf8 ? 'utf-8' : $LANG_CHARSET))) {
                    exit($LANG_INSTALL[26] . ' ' . $siteconfig_path
                         . $LANG_INSTALL[58]);
                }
            }

            require $dbconfig_path;
            require_once $siteconfig_path;
            require_once $_CONF['path_system'] . 'lib-database.php';
            $req_string = 'index.php?mode=' . $install_type . '&step=3&dbconfig_path=' . $dbconfig_path
                        . '&install_plugins=' . $install_plugins
                        . '&language=' . $language
                        . '&site_name=' . urlencode($site_name)
                        . '&site_slogan=' . urlencode($site_slogan)
                        . '&site_url=' . urlencode($site_url)
                        . '&site_admin_url=' . urlencode($site_admin_url)
                        . '&site_mail=' . urlencode($site_mail)
                        . '&noreply_mail=' . urlencode($noreply_mail);
            if ($utf8) {
                $req_string .= '&utf8=true';
            }

            switch ($install_type) {

            case 'install':
                $hidden_fields = '<input type="hidden" name="mode" value="' . $install_type . '"' . XHTML . '>
                            <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
                            <input type="hidden" name="dbconfig_path" value="' . urlencode($dbconfig_path) . '"' . XHTML . '>
                            <input type="hidden" name="site_name" value="' . urlencode($site_name) . '"' . XHTML . '>
                            <input type="hidden" name="site_slogan" value="' . urlencode($site_slogan) . '"' . XHTML . '>
                            <input type="hidden" name="site_url" value="' . urlencode($site_url) . '"' . XHTML . '>
                            <input type="hidden" name="site_admin_url" value="' . urlencode($site_admin_url) . '"' . XHTML . '>
                            <input type="hidden" name="site_mail" value="' . urlencode($site_mail) . '"' . XHTML . '>
                            <input type="hidden" name="noreply_mail" value="' . urlencode($noreply_mail) . '"' . XHTML . '>
                            <input type="hidden" name="utf8" value="' . ($utf8 ? 'true' : 'false') . '"' . XHTML . '>';

                // If using MySQL check to see if InnoDB is supported
                if ($DB['type'] == 'mysql-innodb' && !INST_innodbSupported()) {
                    // Warn that InnoDB tables are not supported
                    $display .= '<h2>' . $LANG_INSTALL[59] . '</h2>
                    <p>' . $LANG_INSTALL['60'] . '</p>

                    <br' . XHTML . '>
                    <div style="margin-left: auto; margin-right: auto; width: 125px">
                        <div style="position: relative; right: 10px">
                            <form action="index.php" method="post">
                            <input type="hidden" name="step" value="1"' . XHTML . '>
                            ' . $hidden_fields . '
                            <input type="submit" value="&lt;&lt; ' . $LANG_INSTALL[61] . '"' . XHTML . '>
                            </form>
                        </div>

                        <div style="position: relative; left: 65px; top: -27px">
                            <form action="index.php" method="post">
                            <input type="hidden" name="step" value="3"' . XHTML . '>
                            ' . $hidden_fields . '
                            <input type="hidden" name="innodb" value="false"' . XHTML . '>
                            <input type="submit" name="submit" value="' . $LANG_INSTALL[62] . ' &gt;&gt;"' . XHTML . '>
                            </form>
                        </div>
                    </div>' . LB;
                } else {
                    // Continue on to step 3 where the installation will happen
                    if ($DB['type'] == 'mysql-innodb') {
                        $req_string .= '&innodb=true';
                    }
                    header('Location: ' . $req_string);
                }
                break;

            case 'upgrade':
                // Try and find out what the current version of GL is
                $curv = INST_identifyGeeklogVersion ();
                if ($curv == VERSION) {
                    // If current version is the newest version
                    // then there's no need to update.
                    $display .= '<h2>' . $LANG_INSTALL[74] . '</h2>' . LB
                              . '<p>' . $LANG_INSTALL[75] . '</p>';
                } elseif ($curv == 'empty') {
                    $display .= '<h2>' . $LANG_INSTALL[90] . '</h2>' . LB
                              . '<p>' . $LANG_INSTALL[91] . '</p>';
                } else {

                    $old_versions = array('1.2.5-1','1.3','1.3.1','1.3.2','1.3.2-1','1.3.3','1.3.4','1.3.5','1.3.6','1.3.7','1.3.8','1.3.9','1.3.10','1.3.11','1.4.0','1.4.1','1.5.0','1.5.1');
                    if (empty($curv)) {
                        // If we were unable to determine the current GL
                        // version is then ask the user what it is
                        $display .= '<h2>' . $LANG_INSTALL[76] . '</h2>
                            <p>' . $LANG_INSTALL[77] . '</p>
                            <form action="index.php" method="post">
                            <input type="hidden" name="mode" value="upgrade"' . XHTML . '>
                            <input type="hidden" name="step" value="3"' . XHTML . '>
                            <input type="hidden" name="dbconfig_path" value="' . $dbconfig_path . '"' . XHTML . '>
                            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[89] . '</label> <select name="version">';
                        $tmp_counter = 0;
                        $ver_selected = '';
                        foreach ($old_versions as $version) {
                            if ($tmp_counter == (count($old_versions) - 1)) {
                                $ver_selected = ' selected="selected"';
                            }
                            $display .= LB . '<option' . $ver_selected . '>' . $version . '</option>';
                            $tmp_counter++;
                        }
                        $display .= '</select></p>
                            <br' . XHTML . '>
                            <input type="submit" name="submit" class="submit" value="Upgrade &gt;&gt;"' . XHTML . '>
                            </form>' . LB;

                        $curv = $old_versions[count($old_versions) - 1];
                    } else {
                        // Continue on to step 3 where the upgrade will happen
                        header('Location: ' . $req_string . '&version=' . $curv);
                    }
                }
                break;
            }
        }
        break;

    /**
     * Page 3 - Install
     */
    case 3:

        $gl_path        = str_replace('db-config.php', '', $dbconfig_path);
        $install_plugins= ((isset($_REQUEST['install_plugins']) && !empty($_REQUEST['install_plugins'])) 
                            ? true 
                            : false);
        $next_link      = ($install_plugins
                            ? 'install-plugins.php?language=' . $language
                            : 'success.php?type=' . $install_type . '&language=' . $language);

        switch ($install_type) {
            case 'install':
                if (isset($_POST['submit']) &&
                        ($_POST['submit'] == '<< ' . $LANG_INSTALL[61])) {
                    header('Location: index.php?mode=install');
                }

                // Check whether to use InnoDB tables
                $use_innodb = false;
                if ((isset($_POST['innodb']) && $_POST['innodb'] == 'true') || (isset($_GET['innodb']) && $_GET['innodb'] == 'true')) {
                    $use_innodb = true;
                }

                $utf8 = false;
                if ((isset($_POST['utf8']) && $_POST['utf8'] == 'true') || (isset($_GET['utf8']) && $_GET['utf8'] == 'true')) {
                    $utf8 = true;
                }

                // We need all this just to do one DB query
                require_once $dbconfig_path;
                require_once $siteconfig_path;
                require_once $_CONF['path_system'] . 'lib-database.php';

                // Check if GL is already installed
                if (INST_checkTableExists('vars')) {

                    $display .= '<p>' . $LANG_INSTALL[63] . '</p>
                        <ol>
                            <li>' . $LANG_INSTALL[64] . '</li>
                            <li>' . $LANG_INSTALL[65] . '</li>
                        </ol>

                        <div style="margin-left: auto; margin-right: auto; width: 125px">
                            <div style="position: absolute">
                                <form action="index.php" method="post">
                                <input type="hidden" name="mode" value="install"' . XHTML . '>
                                <input type="hidden" name="step" value="3"' . XHTML . '>
                                <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
                                <input type="hidden" name="dbconfig_path" value="' . $dbconfig_path . '"' . XHTML . '>
                                <input type="hidden" name="innodb" value="' . (($use_innodb) ? 'true' : 'false') . '"' . XHTML . '>
                                <input type="hidden" name="install_plugins" value="' . $install_plugins . '"' . XHTML . '>
                                <input type="submit" value="' . $LANG_INSTALL[66] . '"' . XHTML . '>
                                </form>
                            </div>

                            <div style="position: relative; left: 55px; top: 5px">
                                <form action="index.php" method="post">
                                <input type="hidden" name="mode" value="upgrade"' . XHTML . '>
                                <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
                                <input type="hidden" name="dbconfig_path" value="' . $dbconfig_path . '"' . XHTML . '>
                                <input type="submit" value="' . $LANG_INSTALL[25] . '"' . XHTML . '>
                                </form>
                            </div>
                        </div>
                        ' . LB;

                } else {

                    if (INST_createDatabaseStructures($use_innodb)) {
                        $site_name      = isset($_POST['site_name']) ? $_POST['site_name'] : (isset($_GET['site_name']) ? $_GET['site_name'] : '') ;
                        $site_slogan    = isset($_POST['site_slogan']) ? $_POST['site_slogan'] : (isset($_GET['site_slogan']) ? $_GET['site_slogan'] : '') ;
                        $site_url       = isset($_POST['site_url']) ? $_POST['site_url'] : (isset($_GET['site_url']) ? $_GET['site_url'] : '') ;
                        $site_admin_url = isset($_POST['site_admin_url']) ? $_POST['site_admin_url'] : (isset($_GET['site_admin_url']) ? $_GET['site_admin_url'] : '') ;
                        $site_mail      = isset($_POST['site_mail']) ? $_POST['site_mail'] : (isset($_GET['site_mail']) ? $_GET['site_mail'] : '') ;
                        $noreply_mail   = isset($_POST['noreply_mail']) ? $_POST['noreply_mail'] : (isset($_GET['noreply_mail']) ? $_GET['noreply_mail'] : '') ;

                        INST_personalizeAdminAccount($site_mail, $site_url);

                        // Insert the form data into the conf_values table

                        require_once $_CONF['path_system'] . 'classes/config.class.php';
                        require_once 'config-install.php';
                        install_config();

                        $config = config::get_instance();
                        $config->set('site_name', urldecode($site_name));
                        $config->set('site_slogan', urldecode($site_slogan));
                        $config->set('site_url', urldecode($site_url));
                        $config->set('site_admin_url', urldecode($site_admin_url));
                        $config->set('site_mail', urldecode($site_mail));
                        $config->set('noreply_mail', urldecode($noreply_mail));
                        $config->set('path_html', $html_path);
                        $config->set('path_log', $gl_path . 'logs/');
                        $config->set('path_language', $gl_path . 'language/');
                        $config->set('backup_path', $gl_path . 'backups/');
                        $config->set('path_data', $gl_path . 'data/');
                        $config->set('path_images', $html_path . 'images/');
                        $config->set('path_themes', $html_path . 'layout/');
                        $config->set('rdf_file', $html_path . 'backend/geeklog.rss');
                        $config->set('path_pear', $_CONF['path_system'] . 'pear/');
                        $config->set_default('default_photo', urldecode($site_url) . '/default.jpg');

                        $lng = INST_getDefaultLanguage($gl_path . 'language/', $language, $utf8);
                        if (!empty($lng)) {
                            $config->set('language', $lng);
                        }

                        DB_change($_TABLES['vars'], 'value', VERSION,
                                                    'name', 'database_version');

                        if (! $install_plugins) {
                            // do a default install of all available plugins
                            INST_defaultPluginInstall();
                        }

                        // Installation is complete. Continue onto either
                        // custom plugin installation page or success page
                        header('Location: ' . $next_link);

                    } else {
                        $display .= "<h2>" . $LANG_INSTALL[67] . "</h2><p>" . $LANG_INSTALL[68] . "</p>";
                    }

                }
                break;

            case 'upgrade':
                // Get and set which version to display
                $version = '';
                if (isset($_GET['version'])) {
                    $version = $_GET['version'];
                } else {
                    if (isset($_POST['version'])) {
                        $version = $_POST['version'];
                    }
                }

                // Let's do this
                require_once $dbconfig_path;
                require_once $siteconfig_path;
                require_once $_CONF['path_system'] . 'lib-database.php';

                // If this is a MySQL database check to see if it was
                // installed with InnoDB support
                if ($_DB_dbms == 'mysql') {
                    // Query `vars` and see if 'database_engine' == 'InnoDB'
                    $result = DB_query("SELECT `name`,`value` FROM {$_TABLES['vars']} WHERE `name`='database_engine'");
                    $row = DB_fetchArray($result);
                    if ($row['value'] == 'InnoDB') {
                       $use_innodb = true;
                    } else {
                       $use_innodb = false;
                    }
                }

                if (INST_doDatabaseUpgrades($version, $use_innodb)) {
                    if (version_compare($version, '1.5.0') == -1) {
                        // After updating the database we'll want to update some of the information from the form.
                        $site_name      = isset($_POST['site_name']) ? $_POST['site_name'] : (isset($_GET['site_name']) ? $_GET['site_name'] : '') ;
                        $site_slogan    = isset($_POST['site_slogan']) ? $_POST['site_slogan'] : (isset($_GET['site_slogan']) ? $_GET['site_slogan'] : '') ;
                        $site_url       = isset($_POST['site_url']) ? $_POST['site_url'] : (isset($_GET['site_url']) ? $_GET['site_url'] : '') ;
                        $site_admin_url = isset($_POST['site_admin_url']) ? $_POST['site_admin_url'] : (isset($_GET['site_admin_url']) ? $_GET['site_admin_url'] : '') ;
                        $site_mail      = isset($_POST['site_mail']) ? $_POST['site_mail'] : (isset($_GET['site_mail']) ? $_GET['site_mail'] : '') ;
                        $noreply_mail   = isset($_POST['noreply_mail']) ? $_POST['noreply_mail'] : (isset($_GET['noreply_mail']) ? $_GET['noreply_mail'] : '') ;

                        require_once $_CONF['path_system'] . 'classes/config.class.php';
                        $config = config::get_instance();
                        $config->set('site_name', urldecode($site_name));
                        $config->set('site_slogan', urldecode($site_slogan));
                        $config->set('site_url', urldecode($site_url));
                        $config->set('site_admin_url', urldecode($site_admin_url));
                        $config->set('site_mail', urldecode($site_mail));
                        $config->set('noreply_mail', urldecode($noreply_mail));
                        $config->set_default('default_photo', urldecode($site_url) . '/default.jpg');
                    }

                    INST_checkPlugins();

                    // Installation is complete. Continue onto either plugin installation or success page
                    header('Location: ' . $next_link);

                } else {
                    $display .= '<h2>' . $LANG_INSTALL[78] . '</h2>
                        <p>' . $LANG_INSTALL[79] . '</p>' . LB;
                }
                break;
        }
        break;
    }
}

/**
 * Check to see if required files are writable by the web server.
 *
 * @param   array   $files              list of files to check
 * @return  boolean                     true if all files are writable
 *
 */
function INST_checkIfWritable($files)
{
    $writable = true;
    foreach ($files as $file) {
        if (!$tmp_file = @fopen($file, 'a')) {
            // Unable to modify
            $writable = false;
        } else {
            fclose($tmp_file);
        }
    }

    return $writable;
}


/**
 * Returns an HTML formatted string containing a list of which files
 * have incorrect permissions.
 *
 * @param   array   $files  List of files to check
 * @return  string          HTML and permission warning message.
 *
 */
function INST_permissionWarning($files)
{
    global $LANG_INSTALL, $form_label_dir;
    $display .= '
        <div class="install-path-container-outer">
            <div class="install-path-container-inner">
                <h2>' . $LANG_INSTALL[81] . '</h2>

                <p>' . $LANG_INSTALL[82] . '</p>

                <br' . XHTML . '>
                <p><label class="' . $form_label_dir . '"><b>' . $LANG_INSTALL[10] . '</b></label> <b>' . $LANG_INSTALL[11] . '</b></p>
        ' . LB;

    foreach ($files as $file) {
        if (!$file_handler = @fopen ($file, 'a')) {
            $display .= '<p><label class="' . $form_label_dir . '"><code>' . $file . '</code></label>' ;
            $file_perms = sprintf ("%3o", @fileperms ($file) & 0777);
            $display .= '<span class="permissions-list">' . $LANG_INSTALL[12] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $file_perms . ')</p>' . LB ;
        } else {
            fclose ($file_handler);
        }
    }

    $display .= '
            </div>
        </div>

    <br' . XHTML . '><br' . XHTML . '>' . LB;

    return $display;

}


/**
 * Returns the HTML form to return the user's inputted data to the
 * previous page.
 *
 * @return  string  HTML form code.
 *
 */
function INST_showReturnFormData($post_data)
{
    global $mode, $dbconfig_path, $language, $LANG_INSTALL;

    $display = '
        <form action="index.php" method="post">
        <input type="hidden" name="mode" value="' . $mode . '"' . XHTML . '>
        <input type="hidden" name="step" value="1"' . XHTML . '>
        <input type="hidden" name="display_step" value="' . $_REQUEST['display_step'] . '"' . XHTML . '>
        <input type="hidden" name="dbconfig_path" value="' . $dbconfig_path . '"' . XHTML . '>
        <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
        <input type="hidden" name="site_name" value="' . $post_data['site_name'] . '"' . XHTML . '>
        <input type="hidden" name="site_slogan" value="' . $post_data['site_slogan'] . '"' . XHTML . '>
        <input type="hidden" name="db_type" value="' . $post_data['db_type'] . '"' . XHTML . '>
        <input type="hidden" name="db_host" value="' . $post_data['db_host'] . '"' . XHTML . '>
        <input type="hidden" name="db_name" value="' . $post_data['db_name'] . '"' . XHTML . '>
        <input type="hidden" name="db_user" value="' . $post_data['db_user'] . '"' . XHTML . '>
        <input type="hidden" name="db_prefix" value="' . $post_data['db_prefix'] . '"' . XHTML . '>
        <input type="hidden" name="site_url" value="' . $post_data['site_url'] . '"' . XHTML . '>
        <input type="hidden" name="site_admin_url" value="' . $post_data['site_admin_url'] . '"' . XHTML . '>
        <input type="hidden" name="site_mail" value="' . $post_data['site_mail'] . '"' . XHTML . '>
        <input type="hidden" name="noreply_mail" value="' . $post_data['noreply_mail'] . '"' . XHTML . '>
        <p align="center"><input type="submit" value="&lt;&lt; ' . $LANG_INSTALL[61] . '"' . XHTML . '></p>
        </form>';

    return $display;
}


/**
 * Get the current installed version of Geeklog
 *
 * @return Geeklog version in x.x.x format
 *
 */
function INST_identifyGeeklogVersion ()
{
    global $_TABLES, $_DB, $_DB_dbms, $dbconfig_path, $siteconfig_path;

    $_DB->setDisplayError(true);

    // simple tests for the version of the database:
    // "DESCRIBE sometable somefield", ''
    //  => just test that the field exists
    // "DESCRIBE sometable somefield", 'somefield,sometype'
    //  => test that the field exists and is of the given type
    //
    // Should always include a test for the current version so that we can
    // warn the user if they try to run the update again.


    switch ($_DB_dbms) {

    case 'mysql':
        $test = array(
            '1.5.1'  => array("SELECT name FROM {$_TABLES['vars']} WHERE name = 'database_version'", 'database_version'),
            '1.5.0'  => array("DESCRIBE {$_TABLES['storysubmission']} bodytext",''),
            '1.4.1'  => array("SELECT ft_name FROM {$_TABLES['features']} WHERE ft_name = 'syndication.edit'", 'syndication.edit'),
            '1.4.0'  => array("DESCRIBE {$_TABLES['users']} remoteusername",''),
            '1.3.11' => array("DESCRIBE {$_TABLES['comments']} sid", 'sid,varchar(40)'),
            '1.3.10' => array("DESCRIBE {$_TABLES['comments']} lft",''),
            '1.3.9'  => array("DESCRIBE {$_TABLES['syndication']} fid",''),
            '1.3.8'  => array("DESCRIBE {$_TABLES['userprefs']} showonline",'')
            // It's hard to (reliably) test for 1.3.7 - let's just hope
            // nobody uses such an old version any more ...
            );
        $firstCheck = "DESCRIBE {$_TABLES['access']} acc_ft_id";
        $result = DB_query($firstCheck, 1);
        if ($result === false) {
            // A check for the first field in the first table failed?
            // Sounds suspiciously like an empty table ...
            return 'empty';
        }
        break;

    case 'mssql':
	    $test = array(
            '1.5.1'  => array("SELECT name FROM {$_TABLES['vars']} WHERE name = 'database_version'", 'database_version'),
            '1.5.0'  => array("SELECT c.name FROM syscolumns c JOIN sysobjects o ON o.id = c.id WHERE c.name='bodytext' AND o.name='{$_TABLES['storysubmission']}'",'bodytext'),
            '1.4.1'  => array("SELECT ft_name FROM {$_TABLES['features']} WHERE ft_name = 'syndication.edit'", 'syndication.edit')
            // 1.4.1 was the first version with MS SQL support
            );
        $firstCheck = "SELECT 1 FROM sysobjects WHERE name='{$_TABLES['access']}'";
        $result = DB_query($firstCheck, 1);
        if (($result === false) || (DB_numRows($result) < 1)) {
            // a check for the first table returned nothing.
            // empty database?
            return 'empty';
        }
        break;

    }

    $version = '';

    foreach ($test as $v => $qarray) {
        $result = DB_query($qarray[0], 1);
        if ($result === false) {
            // error - continue with next test

        } else if (DB_numRows($result) > 0) {
            $A = DB_fetchArray($result);
            if (empty($qarray[1])) {
                // test only for existence of field - succeeded
                $version = $v;
                break;
            } else {
                if (substr($qarray[0], 0, 6) == 'SELECT') {
                    // text for a certain value
                    if ($A[0] == $qarray[1]) {
                        $version = $v;
                        break;
                    }
                } else {
                    // test for certain type of field
                    $tst = explode(',', $qarray[1]);
                    if (($A['Field'] == $tst[0]) && ($A['Type'] == $tst[1])) {
                        $version = $v;
                        break;
                    }
                }
            }
        }
    }

    return $version;
}


/**
* Checks for Static Pages Version
*
* @return   0 = not installed, 1 = original plugin, 2 = plugin by Phill or Tom, 3 = v1.3 (center block, etc.), 4 = 1.4 ('in block' flag)
*
* Note: Needed for upgrades from old versions - don't remove.
*
*/
function get_SP_ver()
{
    global $_TABLES;

    $retval = 0;

    if (DB_count ($_TABLES['plugins'], 'pi_name', 'staticpages') > 0) {
        $result = DB_query ("DESCRIBE {$_TABLES['staticpage']}");
        $numrows = DB_numRows ($result);

        $retval = 1; // assume v1.1 for now ...

        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray ($result, true);
            if ($A[0] == 'sp_nf') {
                $retval = 3; // v1.3
            } elseif ($A[0] == 'sp_pos') {
                $retval = 2; // v1.2
            } elseif ($A[0] == 'sp_inblock') {
                $retval = 4; // v1.4
                break;
            }
        }
    }

    return $retval;
}


/**
 * Sets up the database tables
 *
 * @param   boolean $use_innodb     Whether to use InnoDB table support if using MySQL
 * @return  boolean                 True if successful
 *
 */
function INST_createDatabaseStructures ($use_innodb = false)
{
    global $_CONF, $_TABLES, $_DB, $_DB_dbms, $_DB_host, $_DB_user, $_DB_pass, $site_url;

    $_DB->setDisplayError (true);

    // Because the create table syntax can vary from dbms-to-dbms we are
    // leaving that up to each database driver (e.g. mysql.class.php,
    // postgresql.class.php, etc)

    // Get DBMS-specific create table array and data array
    require_once $_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php';

    $progress = '';

    if (INST_checkTableExists ('access')) {
        return false;
    }

    switch($_DB_dbms){
        case 'mysql':
            INST_updateDB($_SQL);
            if ($use_innodb) {
                DB_query ("INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('database_engine', 'InnoDB')");
            }
            break;
        case 'mssql':
            foreach ($_SQL as $sql) {
                $_DB->dbQuery($sql, 0, 1);
            }
            break;
    }

    // Now insert mandatory data and a small subset of initial data
    foreach ($_DATA as $data) {
        $progress .= "executing " . $data . "<br" . XHTML . ">\n";
        DB_query ($data);
    }

    return true;
}

/**
 * On a fresh install, set the Admin's account email and homepage
 *
 * @param   string  $site_mail  email address, e.g. the site email
 * @param   string  $site_url   the site's URL
 * @return  void
 *
 */
function INST_personalizeAdminAccount($site_mail, $site_url)
{
    global $_TABLES, $_DB_dbms;

    if (($_DB_dbms == 'mysql') || ($_DB_dbms == 'mssql')) {

        // let's try and personalize the Admin account a bit ...

        if (!empty($site_mail)) {
            if (strpos($site_mail, 'example.com') === false) {
                DB_query("UPDATE {$_TABLES['users']} SET email = '" . addslashes($site_mail) . "' WHERE uid = 2");
            }
        }
        if (!empty($site_url)) {
            if (strpos($site_url, 'example.com') === false) {
                DB_query("UPDATE {$_TABLES['users']} SET homepage = '" . addslashes($site_url) . "' WHERE uid = 2");
            }
        }
    }
}

/**
* Derive site's default language from available information
*
* @param    string  $langpath   path where the language files are kept
* @param    string  $language   language used in the install script
* @param    boolean $utf8       whether to use UTF-8
* @return   string              name of default language (for the config)
*
*/
function INST_getDefaultLanguage($langpath, $language, $utf8 = false)
{
    $pos = strpos($language, '_utf-8');
    if ($pos !== false) {
        $language = substr($language, 0, $pos);
    }

    if ($utf8) {
        $lngname = $language . '_utf-8';
    } else {
        $lngname = $language;
    }
    $lngfile = $lngname . '.php';

    if (!file_exists($langpath . $lngfile)) {
        // doesn't exist - fall back to English
        if ($utf8) {
            $lngname = 'english_utf-8';
        } else {
            $lngname = 'english';
        }
    }

    return $lngname;
}


/**
 * Check for InnoDB table support (usually as of MySQL 4.0, but may be
 * available in earlier versions, e.g. "Max" or custom builds).
 *
 * @return  boolean     true = InnoDB tables supported, false = not supported
 *
 */
function INST_innodbSupported()
{
    $result = DB_query ("SHOW VARIABLES LIKE 'have_innodb'");
    $A = DB_fetchArray ($result, true);

    if (strcasecmp ($A[1], 'yes') == 0) {
        return true;
    } else {
        return false;
    }
}


/**
 * Check InnoDB Upgrade
 *
 * @param   array   $_SQL   List of SQL queries
 * @return  array           InnoDB table style if chosen
 *
 */
function INST_checkInnodbUpgrade($_SQL)
{
    global $use_innodb;

    if ($use_innodb) {
        $statements = count($_SQL);
        for ($i = 0; $i < $statements; $i++) {
            $_SQL[$i] = str_replace('MyISAM', 'InnoDB', $_SQL[$i]);
        }
    }

    return $_SQL;
}

/**
 * Perform database upgrades
 *
 * @param   string  $current_gl_version Current Geeklog version
 * @param   boolean $use_innodb         Whether or not to use InnoDB support with MySQL
 * @return  boolean                     True if successful
 *
 */
function INST_doDatabaseUpgrades($current_gl_version, $use_innodb = false)
{
    global $_TABLES, $_CONF, $_SP_CONF, $_DB, $_DB_dbms, $_DB_table_prefix,
           $dbconfig_path, $siteconfig_path, $html_path;

    $_DB->setDisplayError (true);

    // Because the upgrade sql syntax can vary from dbms-to-dbms we are
    // leaving that up to each Geeklog database driver

    $done = false;
    $progress = '';
    while ($done == false) {
        switch ($current_gl_version) {
        case '1.2.5-1':
            // Get DMBS-specific update sql
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.2.5-1_to_1.3.php');
            INST_updateDB($_SQL);

            // OK, now we need to add all users except anonymous to the All Users group and Logged in users group
            // I can hard-code these group numbers because the group table was JUST created with these numbers
            $result = DB_query("SELECT uid FROM {$_TABLES['users']} WHERE uid <> 1");
            $nrows = DB_numRows($result);
            for ($i = 1; $i <= $nrows; $i++) {
                $U = DB_fetchArray($result);
                DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES (2, {$U['uid']}, NULL)");
                DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES (13, {$U['uid']}, NULL)");
            }
            // Now take care of any orphans off the user table...and let me curse MySQL lack for supporting foreign
            // keys at this time ;-)
            $result = DB_query("SELECT MAX(uid) FROM {$_TABLES['users']}");
            $ITEM = DB_fetchArray($result);
            $max_uid = $ITEM[0];
            if (!empty($max_uid) AND $max_uid <> 0) {
                DB_query("DELETE FROM {$_TABLES['userindex']} WHERE uid > $max_uid");
                DB_query("DELETE FROM {$_TABLES['userinfo']} WHERE uid > $max_uid");
                DB_query("DELETE FROM {$_TABLES['userprefs']} WHERE uid > $max_uid");
                DB_query("DELETE FROM {$_TABLES['usercomment']} WHERE uid > $max_uid");
            }
            $current_gl_version = '1.3';
            $_SQL = '';
            break;
        case '1.3':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3_to_1.3.1.php');
            INST_updateDB($_SQL);
            $current_gl_version = '1.3.1';
            $_SQL = '';
            break;
        case '1.3.1':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.1_to_1.3.2.php');
            INST_updateDB($_SQL);
            $current_gl_version = '1.3.2-1';
            $_SQL = '';
            break;
        case '1.3.2':
        case '1.3.2-1':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.2-1_to_1.3.3.php');
            INST_updateDB($_SQL);
            // Now we need to switch how user blocks are stored.  Right now we only store the blocks the
            // user wants.  This will switch it to store the ones they don't want which allows us to add
            // new blocks and ensure they are shown to the user.
            $result = DB_query("SELECT {$_TABLES['users']}.uid,boxes FROM {$_TABLES['users']},{$_TABLES['userindex']} WHERE boxes IS NOT NULL AND boxes <> '' AND {$_TABLES['users']}.uid = {$_TABLES['userindex']}.uid");
            $nrows = DB_numRows($result);
            for ($i = 1; $i <= $nrows; $i++) {
                $row = DB_fetchArray($result);
                $ublocks = str_replace(' ',',',$row['boxes']);
                $result2 = DB_query("SELECT bid,name FROM {$_TABLES['blocks']} WHERE bid NOT IN ($ublocks)");
                $newblocks = '';
                for ($x = 1; $x <= DB_numRows($result2); $x++) {
                    $curblock = DB_fetchArray($result2);
                    if ($curblock['name'] <> 'user_block' AND $curblock['name'] <> 'admin_block' AND $curblock['name'] <> 'section_block') {
                        $newblocks .= $curblock['bid'];
                        if ($x <> DB_numRows($result2)) {
                            $newblocks .= ' ';
                        }
                    }
                }
                DB_query("UPDATE {$_TABLES['userindex']} SET boxes = '$newblocks' WHERE uid = {$row['uid']}");
            }
            $current_gl_version = '1.3.3';
            $_SQL = '';
            break;
        case '1.3.3':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.3_to_1.3.4.php');
            INST_updateDB($_SQL);
            $current_gl_version = '1.3.4';
            $_SQL = '';
            break;
        case '1.3.4':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.4_to_1.3.5.php');
            INST_updateDB($_SQL);
            $result = DB_query("SELECT ft_id FROM {$_TABLES['features']} WHERE ft_name = 'user.mail'");
            $row = DB_fetchArray($result);
            $mail_ft = $row['ft_id'];
            $result = DB_query("SELECT grp_id FROM {$_TABLES['groups']} WHERE grp_name = 'Mail Admin'");
            $row = DB_fetchArray($result);
            $group_id = $row['grp_id'];
            DB_query("INSERT INTO {$_TABLES['access']} (acc_grp_id, acc_ft_id) VALUES ($group_id, $mail_ft)");

            $current_gl_version = '1.3.5';
            $_SQL = '';
            break;
        case '1.3.5':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.5_to_1.3.6.php');
            INST_updateDB($_SQL);
            if (!empty ($_DB_table_prefix)) {
                DB_query ("RENAME TABLE staticpage TO {$_TABLES['staticpage']}");
            }

            $current_gl_version = '1.3.6';
            $_SQL = '';
            break;
        case '1.3.6':
            // fix wrong permissions value
            DB_query ("UPDATE {$_TABLES['topics']} SET perm_anon = 2 WHERE perm_anon = 3");

            // check for existence of 'date' field in gl_links table
            DB_query ("SELECT date FROM {$_TABLES['links']}", 1);
            $dterr = DB_error ();
            if (strpos ($dterr, 'date') > 0) {
                DB_query ("ALTER TABLE {$_TABLES['links']} ADD date datetime default NULL");
            }

            // Fix primary key so that more than one user can add an event
            // to his/her personal calendar.
            DB_query ("ALTER TABLE {$_TABLES['personal_events']} DROP PRIMARY KEY, ADD PRIMARY KEY (eid,uid)");

            $current_gl_version = '1.3.7';
            $_SQL = '';
            break;
        case '1.3.7':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.7_to_1.3.8.php');
            INST_updateDB($_SQL);

            // upgrade Static Pages plugin
            $spversion = get_SP_ver();
            if ($spversion == 1) { // original version
                DB_query ("ALTER TABLE {$_TABLES['staticpage']} "
                    . "ADD COLUMN group_id mediumint(8) unsigned DEFAULT '1',"
                    . "ADD COLUMN owner_id mediumint(8) unsigned DEFAULT '1',"
                    . "ADD COLUMN perm_owner tinyint(1) unsigned DEFAULT '3',"
                    . "ADD COLUMN perm_group tinyint(1) unsigned DEFAULT '2',"
                    . "ADD COLUMN perm_members tinyint(1) unsigned DEFAULT '2',"
                    . "ADD COLUMN perm_anon tinyint(1) unsigned DEFAULT '2',"
                    . "ADD COLUMN sp_php tinyint(1) unsigned DEFAULT '0',"
                    . "ADD COLUMN sp_nf tinyint(1) unsigned DEFAULT '0',"
                    . "ADD COLUMN sp_centerblock tinyint(1) unsigned NOT NULL default '0',"
                    . "ADD COLUMN sp_tid varchar(20) NOT NULL default 'none',"
                    . "ADD COLUMN sp_where tinyint(1) unsigned NOT NULL default '1'");
                DB_query ("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) VALUES ('staticpages.PHP','Ability to use PHP in static pages')");
                $php_id = DB_insertId ();
                $group_id = DB_getItem ($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin'");
                DB_query ("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($php_id, $group_id)");
            } elseif ($spversion == 2) { // extended version by Phill or Tom
                DB_query ("ALTER TABLE {$_TABLES['staticpage']} "
                    . "DROP COLUMN sp_pos,"
                    . "DROP COLUMN sp_search_keywords,"
                    . "ADD COLUMN sp_nf tinyint(1) unsigned DEFAULT '0',"
                    . "ADD COLUMN sp_centerblock tinyint(1) unsigned NOT NULL default '0',"
                    . "ADD COLUMN sp_tid varchar(20) NOT NULL default 'none',"
                    . "ADD COLUMN sp_where tinyint(1) unsigned NOT NULL default '1'");
            }

            if ($spversion > 0) {
                // update plugin version number
                DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '1.3', pi_gl_version = '1.3.8' WHERE pi_name = 'staticpages'");

                // remove Static Pages 'lock' flag
                DB_query ("DELETE FROM {$_TABLES['vars']} WHERE name = 'staticpages'");

                // remove Static Pages Admin group id
                DB_query ("DELETE FROM {$_TABLES['vars']} WHERE name = 'sp_group_id'");

                if ($spversion == 1) {
                    $result = DB_query ("SELECT DISTINCT sp_uid FROM {$_TABLES['staticpage']}");
                    $authors = DB_numRows ($result);
                    for ($i = 0; $i < $authors; $i++) {
                        $A = DB_fetchArray ($result);
                        DB_query ("UPDATE {$_TABLES['staticpage']} SET owner_id = '{$A['sp_uid']}' WHERE sp_uid = '{$A['sp_uid']}'");
                    }
                }

                $result = DB_query ("SELECT sp_label FROM {$_TABLES['staticpage']} WHERE sp_title = 'Frontpage'");
                if (DB_numRows ($result) > 0) {
                    $A = DB_fetchArray ($result);
                    if ($A['sp_label'] == 'nonews') {
                        DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_centerblock = 1, sp_where = 0 WHERE sp_title = 'Frontpage'");
                    } else if (!empty ($A['sp_label'])) {
                        DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_centerblock = 1, sp_title = '{$A['sp_label']}' WHERE sp_title = 'Frontpage'");
                    } else {
                        DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_centerblock = 1 WHERE sp_title = 'Frontpage'");
                    }
                }
            }

            $current_gl_version = '1.3.8';
            $_SQL = '';
            break;
        case '1.3.8':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.8_to_1.3.9.php');
            INST_updateDB($_SQL);

            $pos = strrpos ($_CONF['rdf_file'], '/');
            $filename = substr ($_CONF['rdf_file'], $pos + 1);
            $sitename = addslashes ($_CONF['site_name']);
            $siteslogan = addslashes ($_CONF['site_slogan']);
            DB_query ("INSERT INTO {$_TABLES['syndication']} (title, description, limits, content_length, filename, charset, language, is_enabled, updated, update_info) VALUES ('{$sitename}', '{$siteslogan}', '{$_CONF['rdf_limit']}', {$_CONF['rdf_storytext']}, '{$filename}', '{$_CONF['default_charset']}', '{$_CONF['rdf_language']}', {$_CONF['backend']}, '0000-00-00 00:00:00', NULL)");

            // upgrade static pages plugin
            $spversion = get_SP_ver();
            if ($spversion > 0) {
                if ($spversion < 4) {
                    if (!isset ($_SP_CONF['in_block'])) {
                        $_SP_CONF['in_block'] = 1;
                    } else if ($_SP_CONF['in_block'] > 1) {
                        $_SP_CONF['in_block'] = 1;
                    } else if ($_SP_CONF['in_block'] < 0) {
                        $_SP_CONF['in_block'] = 0;
                    }
                    DB_query ("ALTER TABLE {$_TABLES['staticpage']} ADD COLUMN sp_inblock tinyint(1) unsigned DEFAULT '{$_SP_CONF['in_block']}'");
                }
                DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '1.4', pi_gl_version = '1.3.9' WHERE pi_name = 'staticpages'");
            }

            // recreate 'date' field for old links
            $result = DB_query ("SELECT lid FROM {$_TABLES['links']} WHERE date IS NULL");
            $num = DB_numRows ($result);
            if ($num > 0) {
                for ($i = 0; $i < $num; $i++) {
                    $A = DB_fetchArray ($result);

                    $myyear = substr ($A['lid'], 0, 4);
                    $mymonth = substr ($A['lid'], 4, 2);
                    $myday = substr ($A['lid'], 6, 2);
                    $myhour = substr ($A['lid'], 8, 2);
                    $mymin = substr ($A['lid'], 10, 2);
                    $mysec = substr ($A['lid'], 12, 2);

                    $mtime = mktime ($myhour, $mymin, $mysec,
                                     $mymonth, $myday, $myyear);
                    $date = date ("Y-m-d H:i:s", $mtime);
                    DB_query ("UPDATE {$_TABLES['links']} SET date = '$date' WHERE lid = '{$A['lid']}'");
                }
            }

            // remove unused entries left over from deleted groups
            $result = DB_query ("SELECT grp_id FROM {$_TABLES['groups']}");
            $num = DB_numRows ($result);
            $groups = array ();
            for ($i = 0; $i < $num; $i++) {
                $A = DB_fetchArray ($result);
                $groups[] = $A['grp_id'];
            }
            $grouplist = '(' . implode (',', $groups) . ')';

            DB_query ("DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_main_grp_id NOT IN $grouplist) OR (ug_grp_id NOT IN $grouplist)");

            $current_gl_version = '1.3.9';
            $_SQL = '';
            break;
        case '1.3.9':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.9_to_1.3.10.php');
            INST_updateDB($_SQL);
            commentsToPreorderTree();

            $result = DB_query ("SELECT sid,introtext,bodytext FROM {$_TABLES['stories']}");
            $numStories = DB_numRows ($result);
            for ($i = 0; $i < $numStories; $i++) {
                $A = DB_fetchArray ($result);
                $related = addslashes (implode ("\n", UPDATE_extractLinks ($A['introtext'] . ' ' . $A['bodytext'])));
                if (empty ($related)) {
                    DB_query ("UPDATE {$_TABLES['stories']} SET related = NULL WHERE sid = '{$A['sid']}'");
                } else {
                    DB_query ("UPDATE {$_TABLES['stories']} SET related = '$related' WHERE sid = '{$A['sid']}'");
                }
            }

            $spversion = get_SP_ver();
            if ($spversion > 0) {
                // no database changes this time, but set new version number
                DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '1.4.1', pi_gl_version = '1.3.10' WHERE pi_name = 'staticpages'");
            }

            // install SpamX plugin
            // (also handles updates from version 1.0)
            install_spamx_plugin ();

            $current_gl_version = '1.3.10';
            $_SQL = '';
            break;
        case '1.3.10':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.10_to_1.3.11.php');
            INST_updateDB($_SQL);
            $current_gl_version = '1.3.11';
            $_SQL = '';
            break;

        case '1.3.11':
            require_once ($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.11_to_1.4.0.php');
            INST_updateDB($_SQL);
            upgrade_addFeature ();
            upgrade_uniqueGroupNames ();

            $current_gl_version = '1.4.0';
            $_SQL = '';
            break;

        case '1.4.0':
            require_once ($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.4.0_to_1.4.1.php');
            INST_updateDB($_SQL);
            upgrade_addSyndicationFeature ();
            upgrade_ensureLastScheduledRunFlag ();
            upgrade_plugins_141 ();

            $current_gl_version = '1.4.1';
            $_SQL = '';
            break;

        case '1.4.1':
            require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.4.1_to_1.5.0.php';
            INST_updateDB($_SQL);

            upgrade_addWebservicesFeature();

            create_ConfValues();
            require_once $_CONF['path_system'] . 'classes/config.class.php';
            $config = config::get_instance();

            if (file_exists($_CONF['path'] . 'config.php')) {
                // Read the values from config.php and use them to populate conf_values

                $tmp_path = $_CONF['path']; // We'll need this to remember what the correct path is.
                                            // Including config.php will overwrite all our $_CONF values.
                require($tmp_path . 'config.php');
                // Load some important values from config.php into conf_values
                foreach ($_CONF as $key => $val) {
                    $config->set($key, $val);
                }

                if (!INST_setDefaultCharset($siteconfig_path,
                                            $_CONF['default_charset'])) {
                    exit($LANG_INSTALL[26] . ' ' . $siteconfig_path
                         . $LANG_INSTALL[58]);
                }

                require $siteconfig_path;
                require $dbconfig_path;
            }

            // Update the GL configuration with the correct paths.
            $config->set('path_html', $html_path);
            $config->set('path_log', $_CONF['path'] . 'logs/');
            $config->set('path_language', $_CONF['path'] . 'language/');
            $config->set('backup_path', $_CONF['path'] . 'backups/');
            $config->set('path_data', $_CONF['path'] . 'data/');
            $config->set('path_images', $html_path . 'images/');
            $config->set('path_themes', $html_path . 'layout/');
            $config->set('rdf_file', $html_path . 'backend/geeklog.rss');
            $config->set('path_pear', $_CONF['path_system'] . 'pear/');


            if (INST_pluginExists('calendar')) {
                $check = upgrade_CalendarPlugin();
                if (!$check) {
                    echo "Error updating the calendar";
                    return false;
                }
            }
            if (INST_pluginExists('polls')) {
                $check = upgrade_PollsPlugin();
                if (!$check) {
                    echo "Error updating the polls";
                    return false;
                }
            }
            if (INST_pluginExists('staticpages')) {
                $check = upgrade_StaticpagesPlugin();
                if (!$check) {
                    echo "Error updating the staticpages";
                    return false;
                }
            }
            if (INST_pluginExists('links')) {
                $check = upgrade_LinksPlugin();
                if (!$check) {
                    echo "Error updating the links";
                    return false;
                }
            }
            if (INST_pluginExists('spamx')) {
                $check = upgrade_SpamXPlugin();
                if (!$check) {
                    echo "Error updating the spamx";
                    return false;
                }
            }

            $current_gl_version = '1.5.0';
            $_SQL = '';
            break;

        case '1.5.0':
            require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.5.0_to_1.5.1.php';
            INST_updateDB($_SQL);

            $current_gl_version = '1.5.1';
            $_SQL = '';
            break;

        case '1.5.1':
        case '1.5.2': // TBD
            require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.5.1_to_1.6.0.php';

            update_ConfValues();

            if (INST_pluginExists('polls')) {
                $check = upgrade_PollsPluginId();
                if (!$check) {
                    echo "Error updating the polls";
                    return false;
                }
            }

            $current_gl_version = '1.6.0';
            $_SQL = '';
            break;

        default:
            $done = true;
        }
    }

    INST_setVersion($siteconfig_path);

    // delete the security check flag on every update to force the user
    // to run admin/sectest.php again
    DB_delete($_TABLES['vars'], 'name', 'security_check');

    DB_change($_TABLES['vars'], 'value', VERSION, 'name', 'database_version');

    return true;
}


/**
 * Check if a current plugin is installed
 *
 * @param   string $plugin  Name of plugin to check
 *
 */
function INST_pluginExists($plugin)
{
    global $_DB, $_TABLES;
    $result = DB_query("SELECT `pi_name` FROM {$_TABLES['plugins']} WHERE `pi_name` = '$plugin'");
    if (DB_numRows($result) > 0) {
        return true;
    } else {
        return false;
    }
}


/**
 * Run all the database queries from the update file.
 *
 * @param   array $_SQL   Array of queries
 *
 */
function INST_updateDB($_SQL)
{
    global $progress, $_DB, $_DB_dbms;

    $_SQL = INST_checkInnodbUpgrade($_SQL);
    foreach ($_SQL as $sql) {
        $progress .= "executing " . $sql . "<br" . XHTML . ">\n";
        if ($_DB_dbms == 'mssql') {
            $_DB->dbQuery($sql, 0, 1);
        } else {
            DB_query($sql);
        }
    }
}

/**
* Change default character set to UTF-8
*
* @param   string   $siteconfig_path  complete path to siteconfig.php
* @param   string   $charset          default character set to use
* @return  boolean                    true: success; false: an error occured
* @note    Yes, this means that we need to patch siteconfig.php a second time.
*
*/
function INST_setDefaultCharset($siteconfig_path, $charset)
{
    $result = true;

    $siteconfig_file = fopen($siteconfig_path, 'r');
    $siteconfig_data = fread($siteconfig_file, filesize($siteconfig_path));
    fclose($siteconfig_file);

    $siteconfig_data = preg_replace
            (
             '/\$_CONF\[\'default_charset\'\] = \'[^\']*\';/',
             "\$_CONF['default_charset'] = '" . $charset . "';",
             $siteconfig_data
            );

    $siteconfig_file = fopen($siteconfig_path, 'w');
    if (!fwrite($siteconfig_file, $siteconfig_data)) {
        $result = false;
    }
    @fclose($siteconfig_file);

    return $result;
}

/**
* Handle default install of available plugins
*
* Picks up and installs all plugins with an autoinstall.php.
* Any errors are silently ignored ...
*
*/
function INST_defaultPluginInstall()
{
    global $_CONF, $_TABLES;

    if (! function_exists('COM_errorLog')) {
        // "Emergency" version of COM_errorLog
        function COM_errorLog($a, $b = '')
        {
            return '';
        }
    }

    $plugins_dir = $_CONF['path'] . 'plugins/';
    $fd = opendir($plugins_dir);
    while (($plugin = @readdir($fd)) == TRUE) {

        if (($plugin <> '.') && ($plugin <> '..') && ($plugin <> 'CVS') &&
                (substr($plugin, 0, 1) <> '.') &&
                (substr($plugin, 0, 1) <> '_') &&
                is_dir($plugins_dir . $plugin)) {

            clearstatcache ();
            $plugin_dir = $plugins_dir . $plugin;

            if (DB_count($_TABLES['plugins'], 'pi_name', $plugin) == 0) {

                $info = INST_getPluginInfo($plugin);
                if ($info !== false) {
                    $fn = 'plugin_autoinstall_' . $plugin;
                    $inst_parms = $fn($plugin);
                    INST_pluginAutoinstall($plugin, $inst_parms);
                }

            }

        }
    }
}


// +---------------------------------------------------------------------------+
// | Main                                                                      |
// +---------------------------------------------------------------------------+

// prepare some hints about what /path/to/geeklog might be ...
$gl_path    = strtr(__FILE__, '\\', '/'); // replace all '\' with '/'
for ($i = 0; $i < 4; $i++) {
    $remains = strrchr($gl_path, '/');
    if ($remains === false) {
        break;
    } else {
        $gl_path = substr($gl_path, 0, -strlen($remains));
    }
}

$html_path          = str_replace('admin/install/index.php', '', str_replace('admin\install\index.php', '', str_replace('\\', '/', __FILE__)));
$siteconfig_path    = '../../siteconfig.php';
$dbconfig_path      = (isset($_POST['dbconfig_path'])) ? $_POST['dbconfig_path'] : ((isset($_GET['dbconfig_path'])) ? $_GET['dbconfig_path'] : '');
$step               = isset($_GET['step']) ? $_GET['step'] : (isset($_POST['step']) ? $_POST['step'] : 1);
$mode               = isset($_GET['mode']) ? $_GET['mode'] : (isset($_POST['mode']) ? $_POST['mode'] : '');

// $display holds all the outputted HTML and content
if (defined('XHTML')) {
	$display = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">';
} else {
	$display = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>';
}

$display .= '<head>
<meta http-equiv="Content-Type" content="text/html;charset=' . $LANG_CHARSET . '"' . XHTML . '>
<link rel="stylesheet" type="text/css" href="layout/style.css"' . XHTML . '>
<meta name="robots" content="noindex,nofollow"' . XHTML . '>
<title>' . $LANG_INSTALL[0] . '</title>
</head>

<body dir="' . $LANG_DIRECTION . '">
    <div class="header-navigation-container">
        <div class="header-navigation-line">
            <a href="' . $LANG_INSTALL[87] . '" class="header-navigation">' . $LANG_INSTALL[1] . '</a>&nbsp;&nbsp;&nbsp;
        </div>
    </div>
    <div class="header-logobg-container-inner">
        <a class="header-logo" href="http://www.geeklog.net/">
            <img src="layout/logo.png"  width="151" height="56" alt="Geeklog"' . XHTML . '>
        </a>
        <div class="header-slogan">' . $LANG_INSTALL[2] . ' <br' . XHTML . '><br' . XHTML . '>' . LB;

// Show the language drop down selection on the first page
if ($mode == 'check_permissions') {
    $display .='<form action="index.php" method="post" style="display:inline;">' . LB;

    $_PATH = array('dbconfig', 'public_html');
    if (isset($_GET['mode']) || isset($_POST['mode'])) {
        $value = (isset($_POST['mode'])) ? $_POST['mode'] : $_GET['mode'];
        $display .= '<input type="hidden" name="mode" value="' . $value . '"' . XHTML . '>' . LB;
    }
    foreach ($_PATH as $name) {
        if (isset($_GET[$name . '_path']) || isset($_POST[$name . '_path'])) {
            $value = (isset($_POST[$name . '_path'])) ? $_POST[$name . '_path'] : $_GET[$name . '_path'];
            $display .= '<input type="hidden" name="' . $name .'_path" value="' . $value . '"' . XHTML . '>' . LB;
        }
    }

    $display .= $LANG_INSTALL[86] . ':  <select name="language">' . LB;

    foreach (glob('language/*.php') as $filename) {
        $filename = preg_replace('/.php/', '', preg_replace('/language\//', '', $filename));
        $display .= '<option value="' . $filename . '"' . (($filename == $language) ? ' selected="selected"' : '') . '>' . INST_prettifyLanguageName($filename) . '</option>' . LB;
    }

    $display .= '</select>
                    <input type="submit" value="' . $LANG_INSTALL[80] . '"' . XHTML . '>
            </form>';
}
$display .= '
        </div>
    </div>
    <div class="installation-container">
        <div class="installation-body-container">' . LB;

// Make sure the version of PHP is supported.
if (INST_phpOutOfDate()) {

    // If their version of PHP is not supported, print an error:
    $display .= '<h1 class="heading">' . $LANG_INSTALL[4] . '</h1>' . LB;
    $display .= '<p>' . $LANG_INSTALL[5] . $phpv[0] . '.' . $phpv[1] . '.' . (int) $phpv[2] . $LANG_INSTALL[6] . '</p>' . LB;

} else {

    // Ok, the user's version is supported. Let's move on
    switch ($mode) {

    /**
     * The script first checks the location of the db-config.php file. By default
     * the file is located in Geeklog-1.x/ but the script will also check the 
     * public_html/ directory. If the script can't find the file in either of these
     * two places, then it will ask the user to user its location.
     */
    default:

        // Check the location of db-config.php
        // We'll base our /path/to/geeklog on its location
        $gl_path        .= '/';
        $form_fields    = '';
        $num_errors     = 0;
        $dbconfig_path  = '';
        $dbconfig_file  = 'db-config.php';

        $display .= INST_printTab(2) . '<h1 class="heading">' . $LANG_INSTALL[3] . '</h1>' . LB;

        if (!file_exists($gl_path . $dbconfig_file) && !file_exists($gl_path . 'public_html/' . $dbconfig_file)) {
            // If the file/directory is not located in the default location
            // or in public_html have the user enter its location.
            $form_fields .= '<p><label class="' . $form_label_dir . '"><code>db-config.php</code></label> ' . LB
                        . '<input type="text" name="dbconfig_path" value="/path/to/'
                        . $dbconfig_file . '" size="25"' . XHTML . '></p>'  . LB;
            $num_errors++;
        } else {
            // See whether the file/directory is located in the default place or in public_html
            $dbconfig_path = file_exists($gl_path . $dbconfig_file)
                                ? $gl_path . $dbconfig_file
                                : $gl_path . 'public_html/' . $dbconfig_file;
        }

        if ($num_errors == 0) {
            // If the script was able to locate all the system files/directories move onto the next step
            header('Location: index.php?mode=check_permissions&dbconfig_path=' . urlencode($dbconfig_path));
        } else {
            // If the script was not able to locate all the system files/directories ask the user to enter their location
            $display .= '<h2>' . $LANG_INSTALL[7] . '</h2>
                <p>' . $LANG_INSTALL[8] . '</p>
                <form action="index.php" method="post">
                <input type="hidden" name="mode" value="check_permissions"' . XHTML . '>
                ' . $form_fields . '
                <input type="submit" name="submit" class="submit" value="Next &gt;&gt;"' . XHTML . '>
                </form>' . LB;
            $display .= '<p>' . $LANG_INSTALL[94] . '<p>' . LB
                     . '<ul><li>' . $LANG_INSTALL[95] . '<br' . XHTML . '>' . LB
                     . '<code>' . strtr(__FILE__, '\\', '/') . '</code></li>'
                     . '<li>' . sprintf($LANG_INSTALL[96],
                                        '<code>db-config.php</code>')
                     . '<br' . XHTML . '>' . LB . '<code>' . $gl_path
                     . '</code></li></ul>' . LB;
        }
        break;

    /**
     * The second step is to check permissions on the files/directories
     * that Geeklog needs to be able to write to. The script uses the location of
     * db-config.php from the previous step to determine location of everything.
     */
    case 'check_permissions':

        // Get the paths from the previous page
        $_PATH = array('db-config.php' => urldecode(isset($_GET['dbconfig_path'])
                                            ? $_GET['dbconfig_path'] : $_POST['dbconfig_path']),
                        'public_html/' => str_replace('admin/install/index.php', '', str_replace('admin\install\index.php', '', __FILE__)));

        // Be fault tolerant with the path the user enters
        if (!strstr($_PATH['db-config.php'], 'db-config.php')) {
            // If the user did not provide a trailing '/' then add one
            if (!preg_match('/^.*\/$/', $_PATH['db-config.php'])) {
                $_PATH['db-config.php'] .= '/';
            }
            $_PATH['db-config.php'] .= 'db-config.php';
        }

        // The path to db-config.php is what we'll use to generate our /path/to/geeklog so
        // we want to make sure it's valid and exists before we continue and create problems.
        if (!file_exists($_PATH['db-config.php'])) {
            $display .= INST_printTab(2) . '<h1 class="heading">' . $LANG_INSTALL[3] . '</h1>' . LB
                . INST_printTab(3) . '<p><span class="error">' . $LANG_INSTALL[38] . '</span>' . LB
                . INST_printTab(3) . $LANG_INSTALL[84] . '<code>' . $_PATH['db-config.php'] . '</code>' . $LANG_INSTALL[85] . LB
                . INST_printTab(3) . '</p>' . LB
                . INST_printTab(3) . '<div style="margin-left: auto; margin-right: auto; width: 1px">' . LB
                . INST_printTab(3) . '<form action="index.php" method="post">' . LB
                . INST_printTab(3) . '<input type="submit" value="&lt;&lt; ' . $LANG_INSTALL[61] . '"' . XHTML . '>' . LB
                . INST_printTab(3) . '</form>' . LB
                . INST_printTab(3) . '</div>' . LB;
        } else {

            require_once $_PATH['db-config.php'];  // We need db-config.php the current DB information
            require_once $siteconfig_path;         // We need siteconfig.php for core $_CONF values.

            $gl_path = str_replace('db-config.php', '', $_PATH['db-config.php']);
            $num_wrong = 0; // number of files with wrong permissions
            $display_permissions = INST_printTab(4) . '<p><label class="' . $perms_label_dir . '"><b>' . $LANG_INSTALL[10] . '</b></label> ' . LB
                                 . INST_printTab(5) . '<b>' . $LANG_INSTALL[11] . '</b></p>' . LB;
            $chmod_string = 'chmod -R 777 ';
            // Files to check if writable
            $file_list = array( $_PATH['db-config.php'],
                                $gl_path . (file_exists($gl_path . 'data') ? 'data/' : 'public_html/data/'),
                                $gl_path . 'logs/error.log',
                                $_PATH['public_html/'] . 'siteconfig.php',
                                $_PATH['public_html/'] . 'backend/geeklog.rss',
                                $_PATH['public_html/'] . 'images/articles/',
                                $_PATH['public_html/'] . 'images/topics/',
                                $_PATH['public_html/'] . 'images/userphotos' );

            if (!isset($_CONF['allow_mysqldump']) && $_DB_dbms == 'mysql') {
                array_splice($file_list, 1, 0, $gl_path . 'backups/');
            }

            foreach ($file_list as $file) {
                if (!is_writable($file)) {
                    $permission = sprintf("%3o", @fileperms($file) & 0777);
                    $display_permissions    .= INST_printTab(4) . '<p><label class="' . $perms_label_dir . '"><code>' . $file . '</code></label>' . LB
                                            . INST_printTab(5) . ' <span class="permissions-list">' . $LANG_INSTALL[12] . ' 777</span> ('
                                            . $LANG_INSTALL[13] . ' ' . $permission . ')</p>' . LB ;
                    $chmod_string .= $file . ' ' ;
                    $num_wrong++;
                }
            }

            $display_step = 1;

            /**
             * Display permissions, etc
             */
            if ($num_wrong) {
                // If any files have incorrect permissions.

                $display .= INST_printTab(2) . '<h1 class="heading">' . 'Step' . ' ' . $display_step . ' - ' . $LANG_INSTALL[14] . '</h1>' . LB;
                $display_step++;

                if (isset($_GET['install_type'])) {
                    // If the user tried to start an installation before setting file permissions
                    $display .= INST_printTab(3) . '<p><div class="notice"><span class="error">' . $LANG_INSTALL[38] . '</span> ' 
                                . $LANG_INSTALL[21] . '</div></p>' . LB;
                } else {
                    // The first page that is displayed during the "check_permissions" step
                    $display .= INST_printTab(3) . '<p>' . $LANG_INSTALL[9] . '</p>' . LB
                                . INST_printTab(3) . '<p>' . $LANG_INSTALL[19] . '</p>' . LB;
                }

                // List the files that have incorrect permissions and also what the permissions should be
                // Also, list the auto-generated chmod command for advanced users
                $display .= INST_printTab(3) . '<div class="file-permissions">' . LB
                    . $display_permissions . INST_printTab(3) . '</div>' . LB
                    . INST_printTab(3) . '<h2>' . 'Advanced Users' . '</h2>' . LB
                    . INST_printTab(3) . '<p>' . 'If you have command line (SSH) access to your web server then you can simple copy and paste the following command into your shell: ' . '</p>' . LB
                    . INST_printTab(3) . '<p><div class="codeblock"><code>' . $chmod_string . LB 
                    . INST_printTab(3) . '</code></div></p><br ' . XHTML . '>' . LB;
                $step++;

            } else {

                // Set the install type if the user clicked one
                $install_type = (isset($_REQUEST['install_type']) && !empty($_REQUEST['install_type'])) ? $_REQUEST['install_type'] : null ;

                // Check if the user clicked one of the install, upgrade, or migrate buttons
                if (isset($install_type)) { 

                    // If they did, determine which method they selected
                    switch ($install_type) {
                    case 'Migrate': 
                        $install_type = 'migrate';
                        break;
                    case $LANG_INSTALL[24]:
                        $install_type = 'install';
                        break;
                    case $LANG_INSTALL[25]:
                        $install_type = 'upgrade';
                        break;
                    }

                    // Go to the 'write_paths' step
                    header('Location: index.php?mode=write_paths'
                                . '&dbconfig_path=' . urlencode($_PATH['db-config.php'])
                                . '&public_html_path=' . urlencode($_PATH['public_html/'])
                                . '&language=' . $language
                                . '&op=' . $install_type
                                . '&display_step=' . ($display_step+1)); 

                }

            }

            // Show the "Select your installation method" buttons
            $upgr_class = ($LANG_DIRECTION == 'rtl') ? 'upgrade-rtl' : 'upgrade' ;
            $display .= INST_printTab(2) . '<h1 class="heading">' . 'Step' . ' ' . $display_step . ' - ' . $LANG_INSTALL[23] . '</h1>' . LB
                . INST_printTab(3) . '<p><form action="index.php" method="GET">' . LB
                . INST_printTab(3) . '<input type="hidden" name="dbconfig_path" value="' . $dbconfig_path . '"' . XHTML . '>' . LB
                . INST_printTab(3) . '<input type="hidden" name="mode" value="' . $mode . '"' . XHTML . '>' . LB
                . INST_printTab(3) . '<input type="hidden" name="display_step" value="' . ($display_step+1) . '"' . XHTML . '>' . LB
                . INST_printTab(3) . '<input type="submit" name="install_type" value="' . $LANG_INSTALL[24] . '"' . XHTML .'>' . LB
                . INST_printTab(3) . '<input type="submit" name="install_type" value="' . $LANG_INSTALL[25] . '"' . XHTML .'>' . LB
                . INST_printTab(3) . '<input type="submit" name="install_type" value="' . 'Migrate' . '"' . XHTML .'>' . LB
                . INST_printTab(3) . '</form> </p> <br' . XHTML . '>' . LB;
   
        }
        break;

    /**
     * Write the GL path to siteconfig.php
     */
    case 'write_paths':

        // Get the paths from the previous page
        $_PATH = array('db-config.php' => urldecode($_REQUEST['dbconfig_path']),
                        'public_html/' => urldecode($_REQUEST['public_html_path']));
        $dbconfig_path = str_replace('db-config.php', '', $_PATH['db-config.php']);

        // Edit siteconfig.php and enter the correct GL path and system directory path
        $siteconfig_path = $_PATH['public_html/'] . 'siteconfig.php';
        $siteconfig_file = fopen($siteconfig_path, 'r');
        $siteconfig_data = fread($siteconfig_file, filesize($siteconfig_path));
        fclose($siteconfig_file);

        // $_CONF['path']
        require_once $siteconfig_path;
        $siteconfig_data = str_replace("\$_CONF['path'] = '{$_CONF['path']}';",
                            "\$_CONF['path'] = '" . str_replace('db-config.php', '', $_PATH['db-config.php']) . "';",
                            $siteconfig_data);

        $siteconfig_file = fopen($siteconfig_path, 'w');
        if (!fwrite($siteconfig_file, $siteconfig_data)) {
            exit ($LANG_INSTALL[26] . ' ' . $_PATH['public_html/'] . $LANG_INSTALL[28]);
        }
        fclose ($siteconfig_file);

        // Continue onto the install, upgrade, or migration
        switch ($_GET['op']) {
        case 'migrate': 
            // migrate
            header('Location: migrate.php?'
                        . 'dbconfig_path=' . urlencode($_PATH['db-config.php'])
                        . '&public_html_path=' . urlencode($_PATH['public_html/'])
                        . '&language=' . $language);
            break;
        case $LANG_INSTALL[24] || $LANG_INSTALL[25]:
            // install or upgrade
            header('Location: index.php?mode=' . $_GET['op'] 
                . '&dbconfig_path=' . urlencode($_PATH['db-config.php']) 
                . '&language=' . $language
                . '&display_step=' . $_REQUEST['display_step']);
            break;
        default:
            $display .= '<p>Invalid mode specified</p>' . LB;
        
        }

        break;

    /**
     * Start the install/upgrade process
     */
    case 'install': // Deliberate fall-through, no "break"
    case 'upgrade':

        // Run the installation function
        INST_installEngine($mode, $step); 
        break;

    } // End switch ($mode)

} // end if (php_v())

$display .= INST_printTab(3) . '<br' . XHTML . '><br' . XHTML . '>' . LB
    . INST_printTab(2) . '</div>' . LB
    . INST_printTab(1) . '</div>' . LB
    . '</body>' . LB 
    . '</html>';

echo $display;

?>
