<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// |                                                                           |
// | Geeklog installation script.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
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
// | You don't need to change anything in this file.                           |
// | Please read docs/install.html which describes how to install Geeklog.     |
// +---------------------------------------------------------------------------+
//
// $Id: install.php,v 1.78 2005/08/09 17:30:27 dhaun Exp $

// this should help expose parse errors (e.g. in config.php) even when
// display_errors is set to Off in php.ini
if (function_exists ('ini_set')) {
    ini_set ('display_errors', '1');
}
error_reporting (E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);

if (!defined ("LB")) {
    define("LB", "\n");
}
if (!defined ('VERSION')) {
    define('VERSION', '1.3.12');
}


/**
* Returns the PHP version
*
* Note: Removes appendices like 'rc1', etc.
*
* @return   array   the 3 separate parts of the PHP version number
*
*/
function php_v ()
{
    $phpv = explode ('.', phpversion ());
                                                                                
    return array ($phpv[0], $phpv[1], (int) $phpv[2]);
}

/**
* Returns the MySQL version
*
* @return   array   the 3 separate parts of the MySQL version number
*
*/
function mysql_v ()
{
    global $_DB_host, $_DB_user, $_DB_pass;

    mysql_connect ($_DB_host, $_DB_user, $_DB_pass);
    $mysqlv = '';

    // mysql_get_server_info() is only available as of PHP 4.0.5
    $phpv = php_v ();
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
    mysql_close ();

    return array ($mysqlmajorv, $mysqlminorv, $mysqlrev);
}

/**
* Shows welcome page and gets location of /path/to/geeklog/. NOTE: this
* Doesn't use the template class because we need to know the path to geeklog
* before we can include it.
*
*/
function INST_welcomePage()
{
    global $_DB_dbms;

    $retval = '';

    $retval .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . LB;
    $retval .= '<html>' . LB;
    $retval .= '<head>' . LB;
    $retval .= '<title>Geeklog ' . VERSION . ' Installation</title>' . LB;
    $retval .= '</head>' . LB;
    $retval .= '<body>' . LB;

    // check the minimum requirements

    $phpv = php_v ();
    if (($phpv[0] < 4) || (($phpv[0] == 4) && ($phpv[1] < 1))) {
        $retval .= '<h1>PHP 4.1.0 required</h1>' . LB;
        $retval .= '<p>Sorry, but Geeklog now requires at least PHP 4.1.0 to run. Please upgrade your PHP install or ask your hosting service to do it for you.</p>' . LB;
        $retval .= '</body>' . LB . '</html>' . LB;

        return $retval;
    }

    if ($_DB_dbms == 'mysql') {
        $myv = mysql_v ();
        if (($myv[0] < 3) || (($myv[0] == 3) && ($myv[1] < 23)) ||
                (($myv[0] == 3) && ($myv[1] == 23) && ($myv[2] < 2))) {
            $retval .= '<h1>MySQL 3.23.2 required</h1>' . LB;
            $retval .= '<p>Sorry, but Geeklog now requires at least MySQL 3.23.2 to run. Please upgrade your MySQL install or ask your hosting service to do it for you.</p>' . LB;
            $retval .= '</body>' . LB . '</html>' . LB;

            return $retval;
        }
    }

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
    if (empty ($glPath) && !empty ($_POST['geeklog_path'])) {
        $glPath = $_POST['geeklog_path'];
        $posted = true;
    }

    $retval .= '<h1>Geeklog Installation (Step 1 of 2)</h1>' . LB;
    $retval .= '<p><strong>Welcome and thank you for choosing Geeklog.</strong> You are only 2 steps away from having Geeklog ' . VERSION . ' running on your system.</p>' . LB;
    $retval .= "<p>If you haven't already done so, you should <strong>edit config.php prior to running this script</strong>. This script will then apply the database structures for both fresh installations and upgrades.</p>" . LB;

    $retval .= '<h2>Upgrading</h2>' . LB;
    $retval .= '<p>Before we get started it is important that if you are upgrading an existing Geeklog installation you back up your database AND your file system.  <strong>This installation script will alter your Geeklog database.</strong> Also, if you are upgrading from version 1.3 or older you may need your old lib-database.php file so be sure to save a copy of this file. <strong>YOU HAVE BEEN WARNED</strong>!</p>' . LB;
    $retval .= '<p>Please make sure to select the correct Geeklog version you are coming from on the next screen. This script will do incremental upgrades after this version (i.e. you can upgrade directly from any old version to ' . VERSION . ').</p>' . LB;
    $retval .= '<p>Please note this script will <strong>not upgrade</strong> any beta or release candidate versions of Geeklog.</p>' . LB;

    $globals_off     = false;
    $long_arrays_off = false;
    $warn_message    = '';
    $help_message    = '';

    if (!ini_get ('register_globals')) {
        $globals_off = true;
        $warn_message .= '<code>register_globals = Off</code>';
        $help_message .= '<code>register_globals = On</code>';
    }

    $phpv = php_v ();
    if (($phpv[0] >= 5) && !ini_get ('register_long_arrays')) {
        $long_arrays_off = true;
        if (!empty ($warn_message)) {
            $warn_message .= ' and ';
        }
        $warn_message .= '<code>register_long_arrays = Off</code>';
        if (!empty ($help_message)) {
            $help_message .= ' and ';
        }
        $help_message .= '<code>register_long_arrays = On</code>';
    }

    if ($globals_off || $long_arrays_off) {
        $retval .= '<h1>Important Note</h1>' . LB;

        $retval .= '<p><font color="red"><strong>Note:</strong> You have '
                . $warn_message .' in your <tt>php.ini</tt>. While Geeklog itself will work just fine with that setting, many of the available plugins and add-ons may not. You may want to set '
                . $help_message . ' (and restart your webserver) if you plan to install any of those add-ons.</font></p>' . LB;
        $retval .= '<p>If you don\'t know where your <tt>php.ini</tt> file is located, please <a href="info.php">click here</a>.</p>' . LB;
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

function INST_identifyGeeklogVersion ()
{
    global $_TABLES, $_DB_dbms;

    // simple tests for the version of the database:
    // "DESCRIBE sometable somefield", ''
    //  => just test that the field exists
    // "DESCRIBE sometable somefield", 'somefield,sometype'
    //  => test that the field exists and is of the given type
    //
    // Should always include a test for the current version so that we can
    // warn the user if they try to run the update again.

    $test = array(
        '1.3.12' => array("DESCRIBE {$_TABLES['users']} remoteusername",''),
        '1.3.11' => array("DESCRIBE {$_TABLES['comments']} sid", 'sid,varchar(40)'),
        '1.3.10' => array("DESCRIBE {$_TABLES['comments']} lft",''),
        '1.3.9'  => array("DESCRIBE {$_TABLES['blocks']} blockorder",'blockorder,smallint(5)'),
        '1.3.8'  => array("DESCRIBE {$_TABLES['userprefs']} showonline",'')

        // It's hard to (reliably) test for 1.3.7 - let's just hope nobody uses
        // such an old version any more ...
    );

    $version = '';

    if ($_DB_dbms == 'mysql') {
        foreach ($test as $v => $qarray) {
            $result = DB_query ($qarray[0]);
            if ($result === false) {
                // error - get out of here
                break;
            }
            if (DB_numRows ($result) > 0) {
                $A = DB_fetchArray ($result);
                if (empty ($qarray[1])) {
                    // test only for existence of field - succeeded
                    $version = $v;
                    break;
                } else {
                    // test for certain type of field
                    $tst = explode (',', $qarray[1]);

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

function INST_getDatabaseSettings($install_type, $geeklog_path)
{
    global $_CONF, $_TABLES;

    $db_templates = new Template ($_CONF['path_system'] . 'install_templates');
    $db_templates->set_file (array ('db' => 'databasesettings.tpl'));
    $db_templates->set_var ('geeklog_path', $geeklog_path);

    if ($install_type == 'upgrade_db') {
        $db_templates->set_var ('upgrade', 1);

        $old_versions = array('1.2.5-1','1.3','1.3.1','1.3.2','1.3.2-1','1.3.3','1.3.4','1.3.5','1.3.6','1.3.7','1.3.8','1.3.9','1.3.10','1.3.11');

        $curv = INST_identifyGeeklogVersion ();
        if (empty ($curv)) {
            $curv = $old_versions[count ($old_versions) - 1];
        }
        if ($curv == VERSION) {
            $versiondd = '<tr><td align="left"><b>Database already up to date!</b>' . LB
                       . '<p>It looks like your database is already up to date. You probably ran the upgrade before. If you need to run the upgrade again, please re-install your database backup first!</td></tr>';
            $nextbutton = '';
        } else {
            $versiondd = '<tr><td align="right"><b>Current Geeklog Version:</b></td><td><select name="version">';
            foreach ($old_versions as $version) {
                $versiondd .= '<option';
                if ($version == $curv) {
                    $versiondd .= ' selected="selected"';
                }
                $versiondd .= '>' . $version . '</option>';
            }
            $versiondd .= '</select></td></tr>';
            $nextbutton = '<input type="submit" name="action" value="Next &gt;&gt;">';
        }
        $db_templates->set_var ('UPGRADE_OPTIONS', $versiondd);
        $db_templates->set_var ('DB_TABLE_OPTIONS', '');
        $db_templates->set_var ('NEXT_BUTTON', $nextbutton);

    } else {

        // This is a fresh installation
        $db_templates->set_var ('upgrade', 0);

        if (innodb_supported ()) {
            $innodb_option = '<tr><td align="left">';
            $innodb_option .= '<p>Using InnoDB tables may improve performance on (very) large sites, but makes database backups more complicated. Leave the option unchecked unless you know what you\'re doing.</p>';
            $innodb_option .= '<input type="checkbox" name="innodb"> Use InnoDB tables';
            $innodb_option .= '</td></tr>';
            $db_templates->set_var ('UPGRADE_OPTIONS', $innodb_option);
        } else {
            $db_templates->set_var ('UPGRADE_OPTIONS',
                                    '<tr><td>&nbsp;</td></tr>');
        }
        $nextbutton = '<input type="submit" name="action" value="Next &gt;&gt;">';
        $db_templates->set_var ('NEXT_BUTTON', $nextbutton);
    }

    return $db_templates->parse('output','db');
}

function INST_createDatabaseStructures ($use_innodb = false)
{
    global $_CONF, $_DB, $_DB_dbms, $_DB_host, $_DB_user, $_DB_pass, $_TABLES;

    $_DB->setDisplayError (true);

    // Because the create table syntax can vary from dbms-to-dbms we are
    // leaving that up to each database driver (e.g. mysql.class.php, 
    // postgresql.class.php, etc)

    // Get DBMS-specific create table array and data array
    require_once($_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php');

    $progress = '';

    if ($_DB_dbms == 'mysql') {

        for ($i = 1; $i <= count ($_SQL); $i++) {
            $sql = current ($_SQL);

            if ($use_innodb) {
                $sql = str_replace ('MyISAM', 'InnoDB', $sql);
            }

            DB_query ($sql);
            next ($_SQL);
        }

    } else { // in the highly unlikely event that we're not on MySQL ...

        for ($i = 1; $i <= count ($_SQL); $i++) {
            DB_query (current ($_SQL));
            next ($_SQL);
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

/**
* Check for InnoDB table support (usually as of MySQL 4.0, but may be
* available in earlier versions, e.g. "Max" or custom builds).
*
* @return   true = InnoDB tables supported, false = not supported
*
*/
function innodb_supported()
{
    $result = DB_query ("SHOW VARIABLES LIKE 'have_innodb'");
    $A = DB_fetchArray ($result, true);

    if (strcasecmp ($A[1], 'yes') == 0) {
        $retval = true;
    } else {
        $retval = false;
    }

    return $retval;
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
* Check if the SpamX plugin is already installed
*
* @return   int     1 = is installed, 0 = not installed
*
*/
function get_SPX_Ver()
{
    global $_TABLES;

    $retval = 0;

    if (DB_count ($_TABLES['plugins'], 'pi_name', 'spamx') == 1) {
        $retval = 1;
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
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }
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

            $spversion = get_SP_ver ();
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
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }

            $current_gl_version = '1.3.11';
            $_SQL = '';
            break;

    case '1.3.11':
            require_once ($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.11_to_1.3.12.php');
            for ($i = 0; $i < count ($_SQL); $i++) {
                DB_query (current ($_SQL));
                next ($_SQL);
            }

            upgrade_addFeature ();

            $current_gl_version = '1.3.12';
            $_SQL = '';
            break;

        default:
            $done = true;
        }
    }
    return true;
}

// Main
if (isset ($_POST['page'])) {
    $page = $_POST['page'];
} else {
    $page = 0;
}

if (isset ($_POST['action']) && ($_POST['action'] == '<< Previous')) {
    $page = 0;
}

// If possible, load the config file so we can get current settings.  If we
// can't then that means this is a fresh installation OR they want to start
// with our system defaults.

// Include template class if we got it
if ($page > 0) {
    $geeklog_path = trim ($_POST['geeklog_path']);
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
            $display .= '<p><b>' . $_POST['geeklog_path'] . '</b> is not a path.<br>Please enter the path to where config.php can be found on your webserver\'s file system.</p>';
        } else {
            $display .= '<p>Geeklog could not find config.php in the path you just entered: <b>' . $_POST['geeklog_path'] . '</b><br>' . LB;
            $display .= 'Please check this path and try again. Remember that you should be using absolute paths, starting at the root of your file system.</p>' . LB;
        }
        $display .= '<form action="install.php" method="post">' . LB;
        $display .= '<p align="center"><input type="submit" name="action" value="<< Previous"><input type="hidden" name="geeklog_path" value="' . $_POST['geeklog_path'] . '"></p>' . LB . '</form>';
        $display .= '</body>' . LB . '</html>';
        echo $display;
        exit;
    }
}

$display = '';

switch ($page) {
case 1:
    if ($_POST['install_type'] == 'complete_upgrade') {
        $upgrade = 1;
    } else {
        $upgrade = 0;
    }
    $display .= INST_getDatabaseSettings ($_POST['install_type'],
                                          $_POST['geeklog_path']); 
    break;

case 2:
    if (!empty($_POST['version'])) {
        if (INST_doDatabaseUpgrades ($_POST['version'], $_POST['prefix'])) {
            // Great, installation is complete
            // Done with installation...redirect to success page
            echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_CONF['site_admin_url'] . '/install/success.php"></head></html>';
        }
    } else {
        $use_innodb = false;
        if (isset ($_POST['innodb']) && ($_POST['innodb'] == 'on')) {
            $use_innodb = true;
        }
        if (INST_createDatabaseStructures ($use_innodb)) {
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
