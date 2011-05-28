<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog installation script.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Matt West         - matt AT mattdanger DOT net                   |
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
// | You don't need to change anything in this file.  Please read              |
// | docs/english/install.html which describes how to install Geeklog.         |
// +---------------------------------------------------------------------------+

require_once 'lib-install.php';
require_once 'lib-upgrade.php';


/**
 * Installer engine
 *
 * The guts of the installation and upgrade package.
 *
 * @param   string  $install_type   'install' or 'upgrade'
 * @param   int     $install_step   1 - 4
 */
function INST_installEngine($install_type, $install_step)
{
    global $_CONF, $_TABLES, $LANG_INSTALL, $LANG_CHARSET, $_DB, $_DB_dbms, $_DB_table_prefix, $_URL, $gl_path, $html_path, $dbconfig_path, $siteconfig_path, $display, $language, $form_label_dir, $use_innodb;

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

        $display .= '<h1 class="heading">' . $LANG_INSTALL[101] . ' ' . htmlspecialchars($_REQUEST['display_step']) . ' - ' . $LANG_INSTALL[102] . '</h1>' . LB;


        // Set all the form values either with their defaults or with received POST data.
        // The only instance where you'd get POST data would be if the user has to
        // go back because they entered incorrect database information.
        $site_name = (isset($_POST['site_name'])) ? str_replace('\\', '', $_POST['site_name']) : $LANG_INSTALL[29];
        $site_slogan = (isset($_POST['site_slogan'])) ? str_replace('\\', '', $_POST['site_slogan']) : $LANG_INSTALL[30];
        $db_selected = '';
        if (isset($_POST['db_type'])) {
            switch ($_POST['db_type']) {
                case 'mysql-innodb':
                    $db_selected = 'mysql-innodb';
                    break;
                case 'mssql':
                    $db_selected = 'mssql';
                    break;
                case 'pgsql':
                    $db_selected = 'pgsql';
                    break;
                default:
                    $db_selected = 'mysql';
                    break;
            }
        } else {
            switch ($_DB_dbms) {
                case 'mssql':
                    $db_selected = 'mssql';
                    break;
                case 'pgsql':
                    $db_selected = 'pgsql';
                    break;
                default:
                    $db_selected = 'mysql';
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

        $site_url = isset($_POST['site_url']) ? $_POST['site_url'] : INST_getSiteUrl();
        $site_admin_url = isset($_POST['site_admin_url']) ? $_POST['site_admin_url'] : INST_getSiteAdminUrl();
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
            <input type="hidden" name="mode" value="' . htmlspecialchars($install_type) . '"' . XHTML . '>
            <input type="hidden" name="step" value="2"' . XHTML . '>
            <input type="hidden" name="display_step" value="' . htmlspecialchars($_REQUEST['display_step']) . '"' . XHTML . '>
            <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
            <input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($dbconfig_path) . '"' . XHTML . '>

            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[32] . ' ' . INST_helpLink('site_name') . '</label> <input type="text" name="site_name" value="' . htmlspecialchars($site_name) . '" size="40"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[33] . ' ' . INST_helpLink('site_slogan') . '</label> <input type="text" name="site_slogan" value="' . htmlspecialchars($site_slogan) . '" size="40"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[34] . ' ' . INST_helpLink('db_type') . '</label> '

            . INST_listOfSupportedDBs($dbconfig_path, $db_selected,
                    ($install_type == 'install' ? true : false)) .

           '</p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[39] . ' ' . INST_helpLink('db_host') . '</label> <input type="text" name="db_host" value="'. htmlspecialchars($db_host) .'" size="20"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[40] . ' ' . INST_helpLink('db_name') . '</label> <input type="text" name="db_name" value="'. htmlspecialchars($db_name) . '" size="20"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[41] . ' ' . INST_helpLink('db_user') . '</label> <input type="text" name="db_user" value="' . htmlspecialchars($db_user) . '" size="20"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[42] . ' ' . INST_helpLink('db_pass') . '</label> <input type="password" name="db_pass" value="' . $db_pass . '" size="20"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[43] . ' ' . INST_helpLink('db_prefix') . '</label> <input type="text" name="db_prefix" value="' . htmlspecialchars($db_prefix) . '" size="20"' . XHTML . '></p>

            <br' . XHTML . '>
            <h2>' . $LANG_INSTALL[44] . '</h2> 
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[45] . ' ' . INST_helpLink('site_url') . '</label> <input type="text" name="site_url" value="' . htmlspecialchars($site_url) . '" size="50"' . XHTML . '>  &nbsp; ' . $LANG_INSTALL[46] . '</p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[47] . ' ' . INST_helpLink('site_admin_url') . '</label> <input type="text" name="site_admin_url" value="' . htmlspecialchars($site_admin_url) . '" size="50"' . XHTML . '>  &nbsp; ' . $LANG_INSTALL[46] . '</p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[48] . ' ' . INST_helpLink('site_mail') . '</label> <input type="text" name="site_mail" value="' . htmlspecialchars($site_mail) . '" size="50"' . XHTML . '></p>
            <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[49] . ' ' . INST_helpLink('noreply_mail') . '</label> <input type="text" name="noreply_mail" value="' . htmlspecialchars($noreply_mail) . '" size="50"' . XHTML . '></p>';

        if ($install_type == 'install') {
            $display .= '
                <p><label class="' . $form_label_dir . '">' . $LANG_INSTALL[92] . ' ' . INST_helpLink('utf8') . '</label> <input type="checkbox" name="utf8"' . ($utf8 ? ' checked="checked"' : '') . XHTML . '></p>';
        }


        $display .='<br' . XHTML . '>
            <input type="submit" name="submit" class="submit button big-button" value="' . $buttontext . ' &gt;&gt;"' . XHTML . '>
            <input type="submit" name="install_plugins" class="submit button big-button" value="' . $buttontext . ' ' . $LANG_INSTALL[103] . ' &gt;&gt;"' . XHTML . '>
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

            $display .= '<h2>' . $LANG_INSTALL[104] . '</h2><p>'
                     . $LANG_INSTALL[105] . '</p>'
                     . INST_showReturnFormData($_POST) . LB;
        // Check for blank password in production environment
        } else if (!INST_dbPasswordCheck($site_url, $DB)) {
            $display .= '<h2>' . $LANG_INSTALL[54] . '</h2><p>'
                     . $LANG_INSTALL[107] . '</p>'
                     . INST_showReturnFormData($_POST) . LB;
        // Check if we can connect to the database
        } else if (!INST_dbConnect($DB)) { 
            $display .= '<h2>' . $LANG_INSTALL[54] . '</h2><p>'
                     . $LANG_INSTALL[55] . '</p>'
                     . INST_showReturnFormData($_POST) . LB;

        // Check if the user's version of MySQL is out of date
        } else if (INST_mysqlOutOfDate($DB)) { 

            $myv = mysql_v($DB['host'], $DB['user'], $DB['pass']);
            $display .= '<h1>' . sprintf($LANG_INSTALL[51], SUPPORTED_MYSQL_VER)
                     . '</h1>' . LB;
            $display .= '<p>' . sprintf($LANG_INSTALL[52], SUPPORTED_MYSQL_VER)
                     . $myv[0] . '.' . $myv[1] . '.' . $myv[2]
                     . $LANG_INSTALL[53] . '</p>' . LB;

        // Check if database doesn't exist
        } else if (!INST_dbExists($DB)) {

            $display .= '<h2>' . $LANG_INSTALL[56] . '</h2><p>'
                     . $LANG_INSTALL[57] . '</p>'
                     . INST_showReturnFormData($_POST) . LB;

        } else {

            // Write the database info to db-config.php
            if (!INST_writeConfig($dbconfig_path, $DB)) {

                exit($LANG_INSTALL[26] . ' ' . htmlspecialchars($dbconfig_path)
                     . $LANG_INSTALL[58]);

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

            $req_string = 'index.php?mode=' . $install_type
                        . '&step=3&dbconfig_path=' . $dbconfig_path
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
                            <input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($dbconfig_path) . '"' . XHTML . '>
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
                            <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
                            <input type="hidden" name="step" value="1"' . XHTML . '>
                            ' . $hidden_fields . '
                            <input type="submit" class="button big-button" value="&lt;&lt; ' . $LANG_INSTALL[61] . '"' . XHTML . '>
                            </form>
                        </div>

                        <div style="position: relative; left: 65px; top: -27px">
                            <form action="index.php" method="post">
                            <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
                            <input type="hidden" name="step" value="3"' . XHTML . '>
                            ' . $hidden_fields . '
                            <input type="hidden" name="innodb" value="false"' . XHTML . '>
                            <input type="submit" class="button big-button" name="submit" value="' . $LANG_INSTALL[62] . ' &gt;&gt;"' . XHTML . '>
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
                $curv = INST_identifyGeeklogVersion();
                if ($curv == VERSION) {
                    // If current version is the newest version
                    // then there's no need to update.
                    $display .= '<h2>' . $LANG_INSTALL[74] . '</h2>' . LB
                              . '<p>' . $LANG_INSTALL[75] . '</p>';
                } elseif ($curv == 'empty') {
                    $display .= '<h2>' . $LANG_INSTALL[90] . '</h2>' . LB
                              . '<p>' . $LANG_INSTALL[91] . '</p>';
                } else {

                    $old_versions = array('1.2.5-1','1.3','1.3.1','1.3.2','1.3.2-1','1.3.3','1.3.4','1.3.5','1.3.6','1.3.7','1.3.8','1.3.9','1.3.10','1.3.11','1.4.0','1.4.1','1.5.0','1.5.1','1.5.2','1.6.0','1.6.1','1.7.0','1.7.1','1.7.2');
                    if (empty($curv)) {
                        // If we were unable to determine the current GL
                        // version is then ask the user what it is
                        $display .= '<h2>' . $LANG_INSTALL[76] . '</h2>
                            <p>' . $LANG_INSTALL[77] . '</p>
                            <form action="index.php" method="post">
                            <input type="hidden" name="mode" value="upgrade"' . XHTML . '>
                            <input type="hidden" name="step" value="3"' . XHTML . '>
                            <input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($dbconfig_path) . '"' . XHTML . '>
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
                            <input type="submit" name="submit" class="submit button big-button" value="' . $LANG_INSTALL[25] . ' &gt;&gt;"' . XHTML . '>
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
                
                if($_DB_dbms=='pgsql')
                {
                    //Create a func to check if plpgsql is already installed
                    DB_query("CREATE OR REPLACE FUNCTION make_plpgsql() 
                    RETURNS VOID LANGUAGE SQL AS $$
                    CREATE LANGUAGE plpgsql;
                    $$;
                    SELECT
                        CASE
                        WHEN EXISTS( SELECT 1 FROM pg_catalog.pg_language WHERE lanname='plpgsql')
                        THEN NULL
                        ELSE make_plpgsql() END;");
                    //Create a function to check if table exists
                    DB_query("CREATE OR REPLACE FUNCTION check_table(varchar, varchar) 
                        RETURNS boolean AS $$ 
                         DECLARE 
                           v_cnt integer; 
                           v_tbl boolean; 
                         BEGIN 
                           SELECT count(1) INTO v_cnt FROM pg_tables where tablename = $1 and 
                        schemaname = $2; 
                            IF v_cnt > 0 THEN 
                             v_tbl = 'true'; 
                            END IF; 
                        return v_tbl; 
                        END; 
                        $$ LANGUAGE 'plpgsql'");
                }

                // Check if GL is already installed
                if (INST_checkTableExists('vars')) {

                    $display .= '<p>' . $LANG_INSTALL[63] . '</p>
                        <ol>
                            <li>' . $LANG_INSTALL[64] . '</li>
                            <li>' . $LANG_INSTALL[65] . '</li>
                        </ol>

                        <div style="margin-left: auto; margin-right: auto; width: 175px">
                            <div style="position: absolute">
                                <form action="index.php" method="post">
                                <input type="hidden" name="mode" value="install"' . XHTML . '>
                                <input type="hidden" name="step" value="3"' . XHTML . '>
                                <input type="hidden" value="' . $language . '"' . XHTML . '>
                                <input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($dbconfig_path) . '"' . XHTML . '>
                                <input type="hidden" name="innodb" value="' . (($use_innodb) ? 'true' : 'false') . '"' . XHTML . '>
                                <input type="hidden" name="install_plugins" value="' . $install_plugins . '"' . XHTML . '>
                                <input type="submit" class="button big-button" value="' . $LANG_INSTALL[66] . '"' . XHTML . '>
                                </form>
                            </div>

                            <div style="position: relative; left: 105px; top: 5px">
                                <form action="index.php" method="post">
                                <input type="hidden" name="mode" value="upgrade"' . XHTML . '>
                                <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
                                <input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($dbconfig_path) . '"' . XHTML . '>
                                <input type="submit" class="button big-button" value="' . $LANG_INSTALL[25] . '"' . XHTML . '>
                                </form>
                            </div>
                        </div>
                        ' . LB;

                } else {

                    if (INST_createDatabaseStructures()) {
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

                        INST_setVersion($siteconfig_path);

                        if (! $install_plugins) {
                            // do a default install of all available plugins

                            /**
                            * For the plugin install we would actually need
                            * lib-common.php in the global namespace. Since
                            * we're in a function, we need to hack a few
                            * things and rely on a few global declarations
                            * (see beginning of function).
                            */

                            // Hack: not needed here - avoid notice
                            $_DB_mysqldump_path = '';

                            // Hack: lib-common will overwrite $language
                            $lx_inst = $language;
                            require_once '../../lib-common.php';
                            $language = $lx_inst;

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

                if (INST_doDatabaseUpgrades($version)) {
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
                    } else {
                        $site_url       = isset($_POST['site_url']) ? $_POST['site_url'] : (isset($_GET['site_url']) ? $_GET['site_url'] : '') ;
                        $site_admin_url = isset($_POST['site_admin_url']) ? $_POST['site_admin_url'] : (isset($_GET['site_admin_url']) ? $_GET['site_admin_url'] : '') ;
                    }

                    INST_fixPathsAndUrls($_CONF['path'], $html_path,
                            urldecode($site_url), urldecode($site_admin_url));

                    // disable plugins for which we don't have the source files
                    INST_checkPlugins();

                    // extra step 4: upgrade plugins
                    $next_link = 'index.php?step=4&mode=' . $install_type
                               . '&language=' . $language;
                    if ($install_plugins) {
                        $next_link .= '&install_plugins=true';
                    }

                    header('Location: ' . $next_link);

                } else {
                    $display .= '<h2>' . $LANG_INSTALL[78] . '</h2>
                        <p>' . $LANG_INSTALL[79] . '</p>' . LB;
                }
                break;
        }
        break;

    /**
    * Extra Step 4 - Upgrade plugins
    */
    case 4:

        INST_pluginUpgrades();

        $install_plugins = ((isset($_GET['install_plugins']) &&
                                !empty($_GET['install_plugins'])) 
                         ? true 
                         : false);

        if (! $install_plugins) {
            // if we don't do the manual selection, install all new plugins now
            INST_autoinstallNewPlugins();
        }

        $next_link = ($install_plugins
                   ? 'install-plugins.php?language=' . $language
                   : 'success.php?type=' . $install_type
                                         . '&language=' . $language);

        header('Location: ' . $next_link);

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
        <input type="hidden" name="mode" value="' . htmlspecialchars($mode) . '"' . XHTML . '>
        <input type="hidden" name="step" value="1"' . XHTML . '>
        <input type="hidden" name="display_step" value="' . htmlspecialchars($_REQUEST['display_step']) . '"' . XHTML . '>
        <input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($dbconfig_path) . '"' . XHTML . '>
        <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
        <input type="hidden" name="site_name" value="' . htmlspecialchars($post_data['site_name']) . '"' . XHTML . '>
        <input type="hidden" name="site_slogan" value="' . htmlspecialchars($post_data['site_slogan']) . '"' . XHTML . '>
        <input type="hidden" name="db_type" value="' . htmlspecialchars($post_data['db_type']) . '"' . XHTML . '>
        <input type="hidden" name="db_host" value="' . htmlspecialchars($post_data['db_host']) . '"' . XHTML . '>
        <input type="hidden" name="db_name" value="' . htmlspecialchars($post_data['db_name']) . '"' . XHTML . '>
        <input type="hidden" name="db_user" value="' . htmlspecialchars($post_data['db_user']) . '"' . XHTML . '>
        <input type="hidden" name="db_prefix" value="' . htmlspecialchars($post_data['db_prefix']) . '"' . XHTML . '>
        <input type="hidden" name="site_url" value="' . htmlspecialchars($post_data['site_url']) . '"' . XHTML . '>
        <input type="hidden" name="site_admin_url" value="' . htmlspecialchars($post_data['site_admin_url']) . '"' . XHTML . '>
        <input type="hidden" name="site_mail" value="' . htmlspecialchars($post_data['site_mail']) . '"' . XHTML . '>
        <input type="hidden" name="noreply_mail" value="' . htmlspecialchars($post_data['noreply_mail']) . '"' . XHTML . '>
        <p align="center"><input type="submit" class="button big-button" value="&lt;&lt; ' . $LANG_INSTALL[61] . '"' . XHTML . '></p>
        </form>';

    return $display;
}


/**
 * Sets up the database tables
 *
 * @return  boolean                 True if successful
 *
 */
function INST_createDatabaseStructures()
{
    global $_CONF, $_TABLES, $_DB, $_DB_dbms, $_DB_host, $_DB_user, $_DB_pass,
           $site_url, $use_innodb;

    $_DB->setDisplayError(true);

    // Because the create table syntax can vary from dbms-to-dbms we are
    // leaving that up to each database driver (e.g. mysql.class.php,
    // postgresql.class.php, etc)

    // Get DBMS-specific create table array and data array
    require_once $_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php';

    $progress = '';

    if (INST_checkTableExists('access')) {
        return false;
    }

    switch($_DB_dbms){
    case 'mysql':
        INST_updateDB($_SQL);
        if ($use_innodb) {
            DB_query("INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('database_engine', 'InnoDB')");
        }
        break;

    case 'mssql':
        foreach ($_SQL as $sql) {
            $_DB->dbQuery($sql, 0, 1);
        }
        break;

    case 'pgsql':
        foreach ($_SQL as $sql) {
            $_DB->dbQuery($sql, 0, 1);
        }
        break;

    default:
        die("Unknown DB type '$_DB_dbms'");
        break;
    }

    // Now insert mandatory data and a small subset of initial data
    foreach ($_DATA as $data) {
        $progress .= "executing " . $data . "<br" . XHTML . ">\n";
        DB_query($data);
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

    if (($_DB_dbms == 'mysql') || ($_DB_dbms == 'mssql') || ($_DB_dbms== 'pgsql')) {

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
* Handle default install of available plugins
*
* Picks up and installs all plugins with an autoinstall.php.
* Any errors are silently ignored ...
*
*/
function INST_defaultPluginInstall()
{
    global $_CONF, $_TABLES, $_DB_dbms, $_DB_table_prefix;

    if (! function_exists('COM_errorLog')) {
        // "Emergency" version of COM_errorLog
        function COM_errorLog($a, $b = '')
        {
            return '';
        }
    }

    INST_autoinstallNewPlugins();
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

$html_path          = INST_getHtmlPath();
$siteconfig_path    = '../../siteconfig.php';
$dbconfig_path      = (isset($_POST['dbconfig_path'])) ? $_POST['dbconfig_path'] : ((isset($_GET['dbconfig_path'])) ? $_GET['dbconfig_path'] : '');
$dbconfig_path      = INST_sanitizePath($dbconfig_path);
$step               = isset($_GET['step']) ? $_GET['step'] : (isset($_POST['step']) ? $_POST['step'] : 1);
$mode               = isset($_GET['mode']) ? $_GET['mode'] : (isset($_POST['mode']) ? $_POST['mode'] : '');
$use_innodb = false;

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
if (empty($mode) || ($mode == 'check_permissions')) {
    $display .='<form action="index.php" method="post" style="display:inline;">' . LB;

    $_PATH = array('dbconfig', 'public_html');
    if (isset($_GET['mode']) || isset($_POST['mode'])) {
        $value = (isset($_POST['mode'])) ? $_POST['mode'] : $_GET['mode'];
        $display .= '<input type="hidden" name="mode" value="' . htmlspecialchars($value) . '"' . XHTML . '>' . LB;
    }
    foreach ($_PATH as $name) {
        if (isset($_GET[$name . '_path']) || isset($_POST[$name . '_path'])) {
            $value = (isset($_POST[$name . '_path'])) ? $_POST[$name . '_path'] : $_GET[$name . '_path'];
            $value = INST_sanitizePath($value);
            $display .= '<input type="hidden" name="' . $name .'_path" value="' . htmlspecialchars($value) . '"' . XHTML . '>' . LB;
        }
    }

    $display .= $LANG_INSTALL[86] . ':  <select name="language">' . LB;

    foreach (glob('language/*.php') as $filename) {
        $filename = preg_replace('/.php/', '', preg_replace('/language\//', '', $filename));
        $display .= '<option value="' . $filename . '"' . (($filename == $language) ? ' selected="selected"' : '') . '>' . INST_prettifyLanguageName($filename) . '</option>' . LB;
    }

    $display .= '</select>
                    <input type="submit" class="language-button button" value="' . $LANG_INSTALL[80] . '"' . XHTML . '>
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
    $display .= '<h1 class="heading">' . sprintf($LANG_INSTALL[4], SUPPORTED_PHP_VER) . '</h1>' . LB;
    $display .= '<p>' . sprintf($LANG_INSTALL[5], SUPPORTED_PHP_VER) . phpversion() . $LANG_INSTALL[6] . '</p>' . LB;

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

        $display .= '<h1 class="heading">' . $LANG_INSTALL[3] . '</h1>' . LB;

        if (!file_exists($gl_path . $dbconfig_file) && !file_exists($gl_path . 'public_html/' . $dbconfig_file)) {
            // If the file/directory is not located in the default location
            // or in public_html have the user enter its location.
            $form_fields .= '<p><label class="' . $form_label_dir . '"><code>db-config.php</code></label> ' . LB
                        . '<input type="text" name="dbconfig_path" value="/path/to/'
                        . htmlspecialchars($dbconfig_file) . '" size="50"' . XHTML . '></p>'  . LB;
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
                <input type="hidden" name="language" value="' . $language . '"' . XHTML . '>
                <input type="hidden" name="mode" value="check_permissions"' . XHTML . '>
                ' . $form_fields . '
                <input type="submit" name="submit" class="submit button big-button" value="' . $LANG_INSTALL[62] . ' &gt;&gt;"' . XHTML . '>
                </form>' . LB;
            $display .= '<p>' . $LANG_INSTALL[94] . '</p>' . LB
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
        $_PATH = array('db-config.php' => INST_sanitizePath(urldecode(isset($_GET['dbconfig_path']) ? $_GET['dbconfig_path'] : $_POST['dbconfig_path'])),
                        'public_html/' => INST_getHtmlPath());

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
            $display .= '<h1 class="heading">' . $LANG_INSTALL[3] . '</h1>' . LB
                . '<p><span class="error">' . $LANG_INSTALL[38] . '</span>' . LB
                . $LANG_INSTALL[84] . '<code>' . htmlspecialchars($_PATH['db-config.php']) . '</code>' . $LANG_INSTALL[85] . LB
                . '</p>' . LB
                . '<div style="margin-left: auto; margin-right: auto; width: 1px">' . LB
                . '<form action="index.php" method="post">' . LB
                . '<input type="hidden" name="language" value="' . $language . '"' . XHTML . '>' . LB
                . '<input type="submit" class="button big-button" value="&lt;&lt; ' . $LANG_INSTALL[61] . '"' . XHTML . '>' . LB
                . '</form>' . LB
                . '</div>' . LB;
        } else {

            require_once $_PATH['db-config.php'];  // We need db-config.php the current DB information
            require_once $siteconfig_path;         // We need siteconfig.php for core $_CONF values.

            $gl_path = str_replace('db-config.php', '', $_PATH['db-config.php']);
            $num_wrong = 0; // number of files with wrong permissions
            $display_permissions = '<p><label class="' . $perms_label_dir . '"><b>' . $LANG_INSTALL[10] . '</b></label> ' . LB
                                 . '<b>' . $LANG_INSTALL[11] . '</b></p>' . LB;
            $chmod_string = 'chmod -R 777 ';
            // Files to check if writable
            $file_list = array( $_PATH['db-config.php'],
                                $gl_path . 'data/',
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
                    if (is_file($file)) {
                        $perm_should_be = '666';
                    } else {
                        $perm_should_be = '777';
                    }
                    $permission = sprintf("%3o", @fileperms($file) & 0777);
                    $display_permissions    .= '<p><label class="' . $perms_label_dir . '"><code>' . $file . '</code></label>' . LB
                                            . ' <span class="permissions-list">' . $LANG_INSTALL[12] . ' '. $perm_should_be .'</span> ('
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

                $display .= '<h1 class="heading">' . $LANG_INSTALL[101] . ' ' . $display_step . ' - ' . $LANG_INSTALL[97] . '</h1>' . LB;
                $display_step++;

                if (isset($_GET['install_type'])) {
                    // If the user tried to start an installation before setting file permissions
                    $display .= '<p><div class="notice"><span class="error">' . $LANG_INSTALL[38] . '</span> ' 
                                . $LANG_INSTALL[21] . '</div></p>' . LB;
                } else {
                    // The first page that is displayed during the "check_permissions" step
                    $display .= '<p>' . $LANG_INSTALL[9] . '</p>' . LB
                                . '<p>' . $LANG_INSTALL[19] . '</p>' . LB;
                }

                // List the files that have incorrect permissions and also what the permissions should be
                // Also, list the auto-generated chmod command for advanced users
                $display .= '<div class="file-permissions">' . LB
                    . $display_permissions . '</div>' . LB
                    . '<h2>' . $LANG_INSTALL[98] . '</h2>' . LB
                    . '<p>' . $LANG_INSTALL[99] . '</p>' . LB
                    . '<p class="codeblock"><code>' . $chmod_string . LB 
                    . '</code></p><br ' . XHTML . '>' . LB;
                $step++;

            } else {

                // Set the install type if the user clicked one
                $install_type = (isset($_REQUEST['install_type']) && !empty($_REQUEST['install_type'])) ? $_REQUEST['install_type'] : null ;

                // Check if the user clicked one of the install, upgrade, or migrate buttons
                if (isset($install_type)) { 

                    // If they did, determine which method they selected
                    switch ($install_type) {
                    case $LANG_INSTALL[16]:
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
            $display .= '<h1 class="heading">' . $LANG_INSTALL[101] . ' ' . $display_step . ' - ' . $LANG_INSTALL[23] . '</h1>' . LB
                . '<div><form action="index.php" method="get">' . LB
                . '<input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($dbconfig_path) . '"' . XHTML . '>' . LB
                . '<input type="hidden" name="mode" value="' . htmlspecialchars($mode) . '"' . XHTML . '>' . LB
                . '<input type="hidden" name="language" value="' . $language . '"' . XHTML . '>' . LB
                . '<input type="hidden" name="display_step" value="' . ($display_step+1) . '"' . XHTML . '>' . LB
                . '<input type="submit" name="install_type" class="button big-button" value="' . $LANG_INSTALL[24] . '"' . XHTML .'>' . LB
                . '<input type="submit" name="install_type" class="button big-button" value="' . $LANG_INSTALL[25] . '"' . XHTML .'>' . LB
                . '<input type="submit" name="install_type" class="button big-button" value="' . $LANG_INSTALL[16] . '"' . XHTML .'>' . LB
                . '</form> </div> <br' . XHTML . '>' . LB;
   
        }
        break;

    /**
     * Write the GL path to siteconfig.php
     */
    case 'write_paths':

        // Get the paths from the previous page
        $_PATH = array('db-config.php' => INST_sanitizePath(urldecode($_REQUEST['dbconfig_path'])),
                        'public_html/' => INST_sanitizePath(urldecode($_REQUEST['public_html_path'])));
        $dbconfig_path = str_replace('db-config.php', '', $_PATH['db-config.php']);

        // Edit siteconfig.php and enter the correct GL path and system directory path
        clearstatcache();
        $siteconfig_path = $_PATH['public_html/'] . 'siteconfig.php';
        $siteconfig_file = fopen($siteconfig_path, 'rb');
        $siteconfig_data = fread($siteconfig_file, filesize($siteconfig_path));
        fclose($siteconfig_file);

        // $_CONF['path']
        require_once $siteconfig_path;
        $siteconfig_data = str_replace("\$_CONF['path'] = '{$_CONF['path']}';",
                            "\$_CONF['path'] = '" . str_replace('db-config.php', '', $_PATH['db-config.php']) . "';",
                            $siteconfig_data);

        $siteconfig_file = fopen($siteconfig_path, 'wb');
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
            $display .= '<p>' . $LANG_INSTALL[100] . '</p>' . LB;
            break;
        }

        break;

    /**
     * Start the install/upgrade process
     */
    case 'install': // Deliberate fall-through, no "break"
    case 'upgrade':

        if ($step == 4) {
            // for the plugin install and upgrade,
            // we need lib-common.php in the global(!) namespace
            $lx_inst = $language; // Hack: lib-common will overwrite $language
            require_once '../../lib-common.php';
            $language = $lx_inst;
        }

        // Run the installation function
        INST_installEngine($mode, $step); 
        break;

    } // End switch ($mode)

} // end if (php_v())

$display .= '<br' . XHTML . '><br' . XHTML . '>' . LB
    . '</div>' . LB
    . '</div>' . LB
    . '</body>' . LB 
    . '</html>';

header('Content-Type: text/html; charset=' . $LANG_CHARSET);
echo $display;

?>
