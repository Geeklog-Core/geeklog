<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// |                                                                           |
// | Geeklog installation script.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: install.php,v 1.61 2004/02/19 12:31:34 dhaun Exp $

// this should help expose parse errors (e.g. in config.php) even when
// display_errors is set to Off in php.ini
@ini_set ("display_errors", "1");
error_reporting (E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);

if (!defined ("LB")) {
    define("LB", "\n");
}
if (!defined ('VERSION')) {
    define('VERSION', '1.3.9');
}

// Turn this on to have the install process print debug messages.  NOTE: these
// message will get written to installerrors.log as this file may not know
// anything about error.log (the Geeklog error log file)
$_INST_DEBUG = false;

/**
* Shows welcome page and gets location of /path/to/geeklog/. NOTE: this
* Doesn't use the template class because we need to know the path to geeklog
* before we can include it.
*
*/
function INST_welcomePage()
{
    global $HTTP_POST_VARS;

    // prepare some hints about what /path/to/geeklog might be ...
    $thisFile = __FILE__;
    $thisFile = strtr ($thisFile, '\\', '/'); // replace all '\' with '/'
    $glPath = $thisFile;
    $posted = false;
    for ($i = 0; $i < 4; $i++) {
        $remains = strrchr ($glPath, '/');
        if ($remains === false) {
            break;
        } else {
            $glPath = substr ($glPath, 0, -strlen ($remains));
        }
    }
    if (!file_exists ($glPath . '/config.php')) {
        $glPath = '';
    }
    if (empty ($glPath) && !empty ($HTTP_POST_VARS['geeklog_path'])) {
        $glPath = $HTTP_POST_VARS['geeklog_path'];
        $posted = true;
    }

    $retval = '';

    $retval .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . LB;
    $retval .= '<html>' . LB;
    $retval .= '<head>' . LB;
    $retval .= '<title>Geeklog ' . VERSION . ' Installation</title>' . LB;
    $retval .= '</head>' . LB;
    $retval .= '<body text="#000000" bgcolor="#ffffff">' . LB;
    $retval .= '<h1>Geeklog Installation (Step 1 of 2)</h1>' . LB;
    $retval .= '<p><strong>Welcome to Geeklog ' . VERSION . '</strong>.  Of all the choices of open-source weblogs we are glad you have chosen to install Geeklog.  With Geeklog version ' . VERSION . ' you will be able to experience rich features, easy administration and an extendable platform that is fast and, most importantly, secure!  Ok, enough of the marketing rant...now for the installation! You are only 3 short steps from having Geeklog running on your system.' . LB;
    $retval .= "<p>If you haven't already done so, you should <strong>edit config.php prior to running this script</strong>. This script will then apply the database structures for both fresh installations and upgrades." . LB;
    $retval .= '<h2>Upgrading</h2>' . LB;
    $retval .= '<p>Before we get started it is important that if you are upgrading an existing Geeklog installation you back up your database AND your file system.  This installation script will alter your Geeklog database. Also, if you are upgrading from version 1.3 or older you may need your old lib-database.php file so be sure to save a copy of this file. <strong>YOU HAVE BEEN WARNED</strong>! <p> Also, this script will only upgrade you from 1.2.5-1 or later to version ' . VERSION . '.  If you are running a version of Geeklog older than 1.2.5-1 then you will need to manually upgrade to 1.2.5-1 using the scripts in /path/to/geeklog/sql/updates/. This script will do incremental upgrades after this version (i.e. when 1.4 comes out this script will be able to upgrade from 1.2.5-1, 1.3.x directly to 1.4).<p>Please note this script will not upgrade any beta or release candidate versions of Geeklog. ';
    if (!ini_get ('register_globals')) {
        $retval .= '<h1>Important!</h1>' . LB;
        $retval .= '<p><font color="red"><strong>Warning:</strong> You have <code>register_globals = Off</code> in your <tt>php.ini</tt>. However, Geeklog requires <code>register_globals</code> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.</font></p>' . LB;
    }
    $retval .= '<h2>Installation Options</h2>' . LB;
    $install_options = '<option value="new_db">New Database</option>'.LB;
    $install_options .= '<option value="upgrade_db">Upgrade Database</option>'.LB;
    $retval .= '<form action="install.php" method="post">' . LB;
    $retval .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">' . LB;
    $retval .= '<tr><td align="right">Installation Type:&nbsp;</td><td><select name="install_type">'. LB;
    $retval .= $install_options;
    $retval .= '</select></td></tr>'.LB;
    $retval .= '<tr><td align="right">Path to Geeklog\'s config.php:&nbsp;</td><td><input type="text" name="geeklog_path" value="' . $glPath . '" size="40"></td></tr>'.LB;
    $retval .= '<tr><td colspan="2" align="left"><p><br><strong>Hint:</strong> The complete path to this file is <b>' . $thisFile;
    if (!empty ($glPath) && !$posted) {
        $retval .= '</b><br>and it appears your Path to Geeklog is <b>' . $glPath;
    }
    $retval .= '</b></p></td></tr>';
    $retval .= '<tr><td colspan="2" align="center"><input type="submit" value="Next &gt;&gt;"></td></tr>' . LB;
    $retval .= '</table>' . LB;
    $retval .= '<input type="hidden" name="page" value="1">' . LB;
    $retval .= '</form>' . LB;
    $retval .= '</body>' . LB;
    $retval .= '</html>' . LB;

    return $retval;
}

function INST_getDatabaseSettings($install_type, $geeklog_path)
{
    global $_CONF, $_TABLES;

    $db_templates = new Template ($_CONF['path_system'] . 'install_templates');
    $db_templates->set_file (array ('db' => 'databasesettings.tpl'));
    $db_templates->set_var ('geeklog_path', $geeklog_path);

    if ($install_type == 'upgrade_db') {
        $db_templates->set_var('upgrade',1);
        // They already have a lib-database file...they can't change their tables names
        $old_versions = array('1.2.5-1','1.3','1.3.1','1.3.2','1.3.2-1','1.3.3','1.3.4','1.3.5','1.3.6','1.3.7','1.3.8');
        $versiondd = '<tr><td align="right"><b>Current Geeklog Version:</b></td><td><select name="version">';
        $cnt = count ($old_versions);
        for ($j = 1; $j <= $cnt; $j++) {
           $versiondd .= '<option';
           if ($j == $cnt) {
               $versiondd .= ' selected="selected"';
           }
           $versiondd .= '>' . current ($old_versions) . '</option>';
           next($old_versions);
        }
        $versiondd .= '</select></td></tr>';
        $db_templates->set_var('UPGRADE_OPTIONS', $versiondd);
        $db_templates->set_var('DB_TABLE_OPTIONS', '');
    } else {
        // This is a fresh installation, let them change their table settings
        $db_templates->set_var('upgrade',0);
        $db_templates->set_var('UPGRADE_OPTIONS','<tr><td>&nbsp;</td></tr>');
    }

    return $db_templates->parse('output','db');
}

function INST_createDatabaseStructures()
{
    global $_CONF, $_DB, $_DB_dbms, $_DB_host, $_DB_user, $_DB_pass, $_TABLES;

    $_DB->setDisplayError (true);

    // Because the create table syntax can vary from dbms-to-dbms we are
    // leaving that up to each database driver (e.g. mysql.class.php, 
    // postgresql.class.php, etc)

    // Get DBMS-specific create table array and data array
    require_once($_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php');

    $progress = '';

    for ($i = 1; $i <= count($_SQL); $i++) {
        DB_query(current($_SQL));
        next($_SQL);
    }

    if ($_DB_dbms == 'mysql') {
        mysql_connect ($_DB_host, $_DB_user, $_DB_pass);
        $mysqlv = '';

        // mysql_get_server_info() is only available as of PHP 4.0.5
        $phpv = explode ('.', phpversion ());
        $phpv[2] = substr ($phpv[2], 0, 1); // get rid of 'pl1' etc.
        if (($phpv[0] > 4) || (($phpv[0] == 4) && ($phpv[1] > 0)) ||
            (($phpv[0] == 4) && ($phpv[1] == 0) && ($phpv[2] > 4))) {
            $mysqlv = mysql_get_server_info();
        }

        if (!empty ($mysqlv)) {
            preg_match ('/^([0-9]+).([0-9]+).([0-9]+)/', $mysqlv, $match);
            $mysqlmajorv = $match[1];
            $mysqlminorv = $match[2];
            $mysqlrev = $match[3];
        } else {
            $mysqlmajorv = 0;
            $mysqlminorv = 0;
            $mysqlrev = 0;
        }
        mysql_close();

        if ((($mysqlmajorv == 3) && ($mysqlminorv >= 23) && ($mysqlrev >= 2)) ||
             ($mysqlmajorv > 3)) {
            // http://www.mysql.com/doc/en/Problems_with_NULL.html
            // Note that you can only add an index on a column that can have
            // NULL values if you are using MySQL Version 3.23.2 or newer
            for ($i = 1; $i <= count ($_INDEX); $i++) {
                DB_query (current ($_INDEX));
                next ($_INDEX);
            }
        }
    }

    // Now insert mandatory data and a small subset of initial data
    for ($i = 1; $i <= count($_DATA); $i++) {
        $progress .= "executing " . current($_DATA) . "<br>\n";
        DB_query(current($_DATA));
        next($_DATA);
    }

    return true;
}


/*
* Checks for Static Pages Version
*
* @return   0 = not installed, 1 = original plugin, 2 = plugin by Phill or Tom, 3 = v1.3 (center block, etc.), 4 = 1.4 ('in block' flag)
*
*/
function get_SP_Ver()
{
    global $_TABLES;

    $retval = 0;

    if (DB_count ($_TABLES['plugins'], 'pi_name', 'staticpages') > 0) {
        $result = DB_query ("DESCRIBE {$_TABLES['staticpage']}");
        $numrows = DB_numRows ($result);

        $retval = 1; // assume v1.1 for now ...

        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray ($result);
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

function INST_doDatabaseUpgrades($current_gl_version, $table_prefix)
{
    global $_TABLES, $_CONF, $_SP_CONF, $_DB, $_DB_dbms, $_DB_table_prefix;

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
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL));
                next($_SQL);
            }
            // OK, now we need to add all users except anonymous to the All Users group and Logged in users group
            // I can hard-code these group numbers because the group table was JUST created with these numbers
            $result = DB_query("SELECT uid FROM {$_TABLES['users']} WHERE uid <> 1");
            $nrows = DB_numRows($result);
            for ($i = 1; $i <= $nrows; $i++) {
                $U = DB_fetchArray($result);
                DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES (2, {$U['uid']}, NULL)");
                DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES (13, {$U['uid']}, NULL)");
            }
            // Now take care of any orphans off the user table...and let me curse MySQL lack for supporint foreign
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
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL));
                next($_SQL);
            }
            $current_gl_version = '1.3.1';
            $_SQL = '';
            break;
        case '1.3.1':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.1_to_1.3.2.php');
             for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL));
                next($_SQL);
            }
            $current_gl_version = '1.3.2-1';
            $_SQL = '';
            break;
        case '1.3.2':
        case '1.3.2-1':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.2-1_to_1.3.3.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL));
                next($_SQL);
            }
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
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }

            $current_gl_version = '1.3.4';
            $_SQL = '';
            break;
	case '1.3.4':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.4_to_1.3.5.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }
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
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }

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
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }

            // upgrade Static Pages plugin
            $spversion = get_SP_ver ();
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
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }

            $pos = strrpos ($_CONF['rdf_file'], '/');
            $filename = substr ($_CONF['rdf_file'], $pos + 1);
            $sitename = addslashes ($_CONF['site_name']);
            $siteslogan = addslashes ($_CONF['site_slogan']);
            DB_query ("INSERT INTO {$_TABLES['syndication']} (title, description, limits, content_length, filename, charset, language, is_enabled, updated, update_info) VALUES ('{$sitename}', '{$siteslogan}', '{$_CONF['rdf_limit']}', {$_CONF['rdf_storytext']}, '{$filename}', '{$_CONF['default_charset']}', '{$_CONF['rdf_language']}', {$_CONF['backend']}, '0000-00-00 00:00:00', NULL)");

            // upgrade static pages plugin
            $spversion = get_SP_ver ();
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
        default:
            $done = true;
        }
    }
    return true;
}

// Main
if (isset ($HTTP_POST_VARS['page'])) {
    $page = $HTTP_POST_VARS['page'];
}
else {
    $page = 0;
}

if (isset ($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == '<< Previous')) {
    $page = 0;
}

// If possible, load the config file so we can get current settings.  If we
// can't then that means this is a fresh installation OR they want to start
// with our system defaults.

// Include template class if we got it
if ($page > 0) {
    $geeklog_path = trim ($HTTP_POST_VARS['geeklog_path']);
    $notapath = false;
    if (!empty ($geeklog_path)) {
        // do some sanity checks ...

        if (strpos ($geeklog_path, 'http:') !== false) {
            $notapath = true;
        }
        if (strpos ($geeklog_path, 'config.php') !== false) {
            $pos = strpos ($geeklog_path, 'config.php');
            if ($pos + strlen ('config.php') == strlen ($geeklog_path)) {
                // strip 'config.php' silently ...
                $geeklog_path = substr ($geeklog_path, 0, $pos);
            }
        }

        // silently fix the usual problems with slashes ...
        $geeklog_path = str_replace ('\\', '/', $geeklog_path);
        $geeklog_path = str_replace ('//', '/', $geeklog_path);
        while (substr ($geeklog_path, -1) == '/') {
            $geeklog_path = substr ($geeklog_path, 0, -1);
        }
    }

    if (!$notapath && !empty ($geeklog_path) && file_exists ($geeklog_path . '/config.php')) {
        require_once($geeklog_path . '/system/classes/template.class.php');
        require_once($geeklog_path . '/config.php');
        require_once($geeklog_path . '/system/lib-database.php');
    } else {
        $display = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . LB;
        $display .= '<html>' . LB;
        $display .= '<head><title>Geeklog Installation - Error</title></head>' . LB;
        $display .= '<body bgcolor="#ffffff">' . LB;
        $display .= '<h2>Geeklog Installation - Error</h2>' . LB;
        if ($notapath) {
            $display .= '<p><b>' . $HTTP_POST_VARS['geeklog_path'] . '</b> is not a path.<br>Please enter the path to where config.php can be found on your webserver\'s file system.</p>';
        } else {
            $display .= '<p>Geeklog could not find config.php in the path you just entered: <b>' . $HTTP_POST_VARS['geeklog_path'] . '</b><br>' . LB;
            $display .= 'Please check this path and try again. Remember that you should be using absolute paths, starting at the root of your file system.</p>' . LB;
        }
        $display .= '<form action="install.php" method="post">' . LB;
        $display .= '<p align="center"><input type="submit" name="action" value="<< Previous"><input type="hidden" name="geeklog_path" value="' . $HTTP_POST_VARS['geeklog_path'] . '"></p>' . LB . '</form>';
        $display .= '</body>' . LB . '</html>';
        echo $display;
        exit;
    }
}

$display = '';

switch ($page) {
case 1:
    if ($HTTP_POST_VARS['install_type'] == 'complete_upgrade') {
        $upgrade = 1;
    } else {
        $upgrade = 0;
    }
    $display .= INST_getDatabaseSettings ($HTTP_POST_VARS['install_type'],
                                          $HTTP_POST_VARS['geeklog_path']); 
    break;

case 2:
    if (!empty($HTTP_POST_VARS['version'])) {
        if (INST_doDatabaseUpgrades ($HTTP_POST_VARS['version'],
                                     $HTTP_POST_VARS['prefix'])) {
            // Great, installation is complete
            // Done with installation...redirect to success page
            echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_CONF['site_admin_url'] . '/install/success.php"></head></html>';
        }
    } else {
        if (INST_createDatabaseStructures()) {
            // Done with installation...redirect to success page
            echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_CONF['site_admin_url'] . '/install/success.php"></head></html>';
            // Great, installation is complete
        }
    }
    break;

default:
    // Ok, let's display a welcome page
    $display .= INST_welcomePage();
    break;
}

echo $display;

?>
