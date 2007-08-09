<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// |                                                                           |
// | Geeklog installation script.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Randy Kolenko     - randy AT nextide DOT ca
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
// | You don't need to change anything in this file.                           |
// | Please read docs/install.html which describes how to install Geeklog.     |
// +---------------------------------------------------------------------------+
//
// $Id: index.php,v 1.4 2007/08/09 18:04:02 dhaun Exp $

// this should help expose parse errors (e.g. in config.php) even when
// display_errors is set to Off in php.ini

if (function_exists ( 'ini_set' )) {
    ini_set ( 'display_errors', '1' );
}
error_reporting (E_ERROR | E_WARNING | E_PARSE | E_COMPILE_ERROR);

if (!defined ("LB")) {
    define("LB", "\n");
}
if (!defined ('VERSION')) {
    define('VERSION', '1.4.2');
}

/**
 * Returns the PHP version
 *
 * Note: Removes appendices like 'rc1', etc.
 * @return array the 3 separate parts of the PHP version number
 */
function php_v ()
{
    $phpv = explode ('.', phpversion ());
    return array ($phpv[0], $phpv[1], (int) $phpv[2]);
}


/**
 * Returns the MySQL version
 *
 * @return array the 3 separate parts of the MySQL version number
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
 * Get the current installed version of Geeklog
 *
 * @return Geeklog version in x.x.x format
 */
function INST_identifyGeeklogVersion ()
{
    global $_TABLES, $_DB, $_DB_dbms;

    $_DB->setDisplayError (true);

    // simple tests for the version of the database:
    // "DESCRIBE sometable somefield", ''
    //  => just test that the field exists
    // "DESCRIBE sometable somefield", 'somefield,sometype'
    //  => test that the field exists and is of the given type
    //
    // Should always include a test for the current version so that we can
    // warn the user if they try to run the update again.

    $test = array(
        '1.4.2'  => array("DESCRIBE {$_TABLES['storysubmission']} bodytext",''),
        '1.4.1'  => array("SELECT ft_name FROM {$_TABLES['features']} WHERE ft_name = 'syndication.edit'", 'syndication.edit'),
        '1.4.0'  => array("DESCRIBE {$_TABLES['users']} remoteusername",''),
        '1.3.11' => array("DESCRIBE {$_TABLES['comments']} sid", 'sid,varchar(40)'),
        '1.3.10' => array("DESCRIBE {$_TABLES['comments']} lft",''),
        '1.3.9'  => array("DESCRIBE {$_TABLES['syndication']} fid",''),
        '1.3.8'  => array("DESCRIBE {$_TABLES['userprefs']} showonline",'')

        // It's hard to (reliably) test for 1.3.7 - let's just hope nobody uses
        // such an old version any more ...
   );

    $version = '';

    if ($_DB_dbms == 'mysql') {
        foreach ($test as $v => $qarray) {
            $result = DB_query ($qarray[0], 1);
            if ($result === false) {
                // error - continue with next test
            } else if (DB_numRows ($result) > 0) {
                $A = DB_fetchArray ($result);
                if (empty ($qarray[1])) {
                    // test only for existence of field - succeeded
                    $version = $v;
                    break;
                } else {
                    if (substr ($qarray[0], 0, 6) == 'SELECT') {
                        // text for a certain value
                        if($A[0] == $qarray[1]) {
                            $version = $v;
                            break;
                        }
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
    }

    return $version;
}


/**
 * Check if a table exists
 *
 * @param  string $table Table name
 * @return bool          True if table exists, false if it does not
 */
function INST_checkTableExists ($table)
{
    global $_TABLES, $_DB_dbms;

    $exists = false;

    if ($_DB_dbms == 'mysql') {
        $result = DB_query ("SHOW TABLES LIKE '{$_TABLES[$table]}'");
        if (DB_numRows ($result) > 0) {
            $exists = true;
        }
    }

    return $exists;
}


/**
 * Sets up the database tables
 *
 * @param  bool $use_innodb Whether to use InnoDB table support if using MySQL
 * @return bool             True if successful
 *
 */
function INST_createDatabaseStructures ($use_innodb = false)
{
    global $_CONF, $_TABLES, $_DB, $_DB_dbms, $_DB_host, $_DB_user, $_DB_pass;

    $_DB->setDisplayError (true);

    // Because the create table syntax can vary from dbms-to-dbms we are
    // leaving that up to each database driver (e.g. mysql.class.php,
    // postgresql.class.php, etc)

    // Get DBMS-specific create table array and data array
    require_once ($_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php');

    $progress = '';

    if (INST_checkTableExists ('access')) {
        return false;
    }

    switch($_DB_dbms){
        case 'mysql':
            foreach ($_SQL as $sql) {
                if ($use_innodb) {
                    $sql = str_replace ('MyISAM', 'InnoDB', $sql);
                }

                DB_query ($sql);
            }
            if ($use_innodb) {
                DB_query ("INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('database_engine', 'InnoDB')");
            }
            break;
        case 'mssql';
            foreach ($_SQL as $sql) {
                DB_query ($sql);
            }
            break;
    }

    // Now insert mandatory data and a small subset of initial data
    foreach ($_DATA as $data) {
        $progress .= "executing " . $data . "<br>\n";
        DB_query ($data);
    }

    if ($_DB_dbms == 'mysql' || $_DB_dbms == 'mssql') {

        // let's try and personalize the Admin account a bit ...

        if (strpos ($_CONF['site_mail'], 'example.com') === false) {
            DB_query ("UPDATE {$_TABLES['users']} SET email = '" . addslashes ($_CONF['site_mail']) . "' WHERE uid = 2");
        }
        if (strpos ($_CONF['site_url'], 'example.com') === false) {
            DB_query ("UPDATE {$_TABLES['users']} SET homepage = '" . addslashes ($_CONF['site_url']) . "' WHERE uid = 2");
        }
    }

    return true;
}


/**
 * Check InnoDB Upgrade
 *
 * @param    array $_SQL    List of SQL queries
 * @return   array          InnoDB table style if chosen
 */
function INST_checkInnodbUpgrade($_SQL)
{
    global $use_innodb;
    for ($i=0; $i<sizeof($_SQL); $i++) {
        if ($use_innodb) {
            $_SQL[$i] = str_replace('MyISAM', 'InnoDB', $_SQL[$i]);
        }
    }
    return $_SQL;
}

/**
 * Perform database upgrades
 *
 * @param    string $current_gl_version Current Geeklog version
 * @param    bool   $use_innodb         Whether or not to use InnoDB support with MySQL
 * @return   bool                       True if successful
 *
 */
function INST_doDatabaseUpgrades($current_gl_version, $use_innodb = false)
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }

            $current_gl_version = '1.3.4';
            $_SQL = '';
            break;
        case '1.3.4':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.4_to_1.3.5.php');
            $_SQL = INST_checkInnodbUpgrade($_SQL);
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
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
            $_SQL = INST_checkInnodbUpgrade($_SQL);
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }

            $current_gl_version = '1.3.11';
            $_SQL = '';
            break;

        case '1.3.11':
            require_once ($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.11_to_1.4.0.php');
            $_SQL = INST_checkInnodbUpgrade($_SQL);
            for ($i = 0; $i < count ($_SQL); $i++) {
                DB_query (current ($_SQL));
                next ($_SQL);
            }

            upgrade_addFeature ();
            upgrade_uniqueGroupNames ();

            $current_gl_version = '1.4.0';
            $_SQL = '';
            break;

        case '1.4.0':
            require_once ($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.4.0_to_1.4.1.php');
            $_SQL = INST_checkInnodbUpgrade($_SQL);
            for ($i = 0; $i < count ($_SQL); $i++) {
                DB_query (current ($_SQL));
                next ($_SQL);
            }

            upgrade_addSyndicationFeature ();
            upgrade_ensureLastScheduledRunFlag ();
            upgrade_plugins_141 ();

            $current_gl_version = '1.4.1';
            $_SQL = '';
            break;

        case '1.4.1':
            require_once ($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.4.1_to_1.4.2.php');
            $_SQL = INST_checkInnodbUpgrade($_SQL);
            for ($i = 0; $i < count ($_SQL); $i++) {
                DB_query (current ($_SQL));
                next ($_SQL);
            }
            upgrade_PollsPlugin();
            upgrade_StaticpagesPlugin();
            $current_gl_version = '1.4.2';
            $_SQL = '';
            break;

        default:
            $done = true;
        }
    }

    // delete the security check flag on every update to force the user
    // to run admin/sectest.php again
    DB_delete ($_TABLES['vars'], 'name', 'security_check');

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


/**
 * Check to see if config.php and lib-common.php are writeable by the web
 * server. If they aren't display a warning message.
 *
 * @param  string $config_path    Path to config.php
 * @param  string $libcommon_path Path to lib-common.php
 * @return bool                  true if both files are writeable
 * @author Matt West             matt AT mattdanger DOT net
 *
 */
function INST_checkRequiredPerms($config_path, $libcommon_path)
{

    if ((!$config_file = @fopen ($config_path . 'config.php', 'a')) || (!$libcommon_file = @fopen ($libcommon_path . 'lib-common.php', 'a'))) {

        // Can't modify config.php or lib-common.php
        return false;

    } else {

        // Able to modify, all is well
        return true;

    }

}

/**
 * Returns the permission warning for config.php and lib-common.php
 *
 * @return   string   HTML and permission warning message.
 * @author   Matt West   matt AT mattdanger DOT net
 *
 */
function INST_permissionWarning($config_path, $libcommon_path)
{

    $display .= '
        <div class="install-path-container-outer">
            <div class="install-path-container-inner">
                <h2>Stop!</h2>

                <p>It is critical that you change permissions on the files listed below. Geeklog will not be able to be installed until you do so.</p>

                <br />
                <p><label class="file-permission-list"><b>File/Directory</b></label> <b>Permissions</b></p>
        ' . LB;

    // config.php
    if (!$config_file = @fopen ($config_path . 'config.php', 'a')) {
        $display .= '<p><label class="file-permission-list"><code>' . $config_path . 'config.php' . '</code></label>' ;
        $config_perms = sprintf ("%3o", @fileperms ($config_path . 'config.php') & 0777);
        $display .= '<span class="error">Change to 777</span> (Currently ' . $config_perms . ')</p>' . LB ;
    } else {
        fclose ($config_file);
    }

    // lib-common.php
    if (!$libcommon_file = @fopen ($libcommon_path . 'lib-common.php', 'a')) {
        $display .= '<p><label class="file-permission-list"><code>' . $libcommon_path . 'lib-common.php' . '</code></label>' ;
        $libcommonPerms = sprintf ("%3o", @fileperms ($libcommon_path . 'lib-common.php') & 0777);
        $display .= '<span class="error">Change to 777</span> (Currently ' . $libcommonPerms . ')</p>' . LB ;
    } else {
        fclose ($libcommon_file);
    }

    $display .= '
            </div>
        </div>

    <br /><br />
    ' . LB;

    return $display;

}

/**
 * Returns the HTML form to return the user's inputted data to the
 * previous page.
 *
 * @return   string   HTML form code.
 *
 */
function INST_showReturnFormData()
{
    global $site_name, $site_slogan, $db_type, $db_host, $db_name,
        $db_user, $db_prefix, $site_url, $site_admin_url, $site_mail,
        $noreply_mail;
    $display = '
        <form action="index.php" method="POST">
        <input type="hidden" name="mode" value="install">
        <input type="hidden" name="step" value="1">
        <input type="hidden" name="site_name" value="' . $site_name . '">
        <input type="hidden" name="site_slogan" value="' . $site_slogan . '">
        <input type="hidden" name="db_type" value="' . $db_type . '">
        <input type="hidden" name="db_host" value="' . $db_host . '">
        <input type="hidden" name="db_name" value="' . $db_name . '">
        <input type="hidden" name="db_user" value="' . $db_user . '">
        <input type="hidden" name="db_prefix" value="' . $db_prefix . '">
        <input type="hidden" name="site_url" value="' . $site_url . '">
        <input type="hidden" name="site_admin_url" value="' . $site_admin_url . '">
        <input type="hidden" name="site_mail" value="' . $site_mail . '">
        <input type="hidden" name="noreply_mail" value="' . $noreply_mail . '">
        <p align="center"><input type="submit" value="&lt;&lt; Back"></p>
        </form>';
    return $display;
}


/**
 * Main
 */

// prepare some hints about what /path/to/geeklog might be ...
$thisFile = __FILE__;
$thisFile = strtr( $thisFile, '\\', '/' ); // replace all '\' with '/'
$gl_path = $thisFile;
$posted = false;
for ($i = 0; $i < 4; $i++) {
    $remains = strrchr( $gl_path, '/' );
    if ($remains === false) {
        break;
    } else {
        $gl_path = substr( $gl_path, 0, -strlen( $remains ) );
    }
}

// Set the language if the form is sent.
$language = (isset( $_POST['language'] )) ? $_POST['language'] : 'english';
require_once('language/' . $language . '.php');

// $display holds all the outputted HTML and content
$display = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>' . $LANG_INSTALL[0] . '</title>
<link rel="stylesheet" type="text/css" href="layout/style.css">
</head>

<body dir="ltr">
    <div class="header-navigation-container">
        <div class="header-navigation-line">
            <a href="http://www.geeklog.net/forum/index.php?forum=1" class="header-navigation">' . $LANG_INSTALL[1] . '</a>&nbsp;&nbsp;&nbsp;

    </div>
    <div class="header-logobg-container-outer">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="header-logobg-container-inner">
            <tr>
                <td class="header-logobg-left">
                    <a href="http://www.geeklog.net/"><img src="layout/logo.png" width="151" height="56" alt="Geeklog" border="0"></a>
                </td>
                <td class="header-logobg-right">
                    <span class="site-slogan">' . $LANG_INSTALL[2] . ' <br /><br />
                    <form action="index.php" method="POST">' . LB;

$_PATH = array( 'config', 'public_html', 'backups', 'data', 'language', 'logs', 'system');
if (isset( $_GET['mode'] ) || isset( $_POST['mode'] )) {
    $value = (isset( $_POST['mode'] )) ? $_POST['mode'] : $_GET['mode'];
    $display .= '<input type="hidden" name="mode" value="' . $value . '">' . LB;
}
foreach ($_PATH as $name) {
    if (isset( $_GET[$name . '_path'] ) || isset( $_POST[$name . '_path'] )) {
        $value = (isset( $_POST[$name . '_path'] )) ? $_POST[$name . '_path'] : $_GET[$name . '_path'];
        $display .= '<input type="hidden" name="' . $name .'_path" value="' . $value . '">' . LB;
    }
}

$display .= 'Language:  <select name="language">' . LB;

foreach (glob( 'language/*.php' ) as $filename) {
    $filename = preg_replace( '/.php/', '', preg_replace( '/language\//', '', $filename ) );
    $display .= '<option value="' . $filename . '"' . (($filename == $language) ? ' selected="selected"' : '') . '>' . ucfirst($filename) . '</option>' . LB;
}

$display .= '</select>
                    <input type="submit" value="' . $LANG_INSTALL[100] . '">
                    </form></span>
                </td>
            </tr>
        </table>
    </div>
    <div class="installation-container">
        <div class="installation-body-container">
            <h1 class="heading">' . $LANG_INSTALL[3] . '</h1>' . LB;


// Get and set our install method ('install' or 'upgrade')
$mode = '';
if (isset( $_GET['mode'] )) {
    $mode = $_GET['mode'];
} else {
    if (isset( $_POST['mode'] )) {
        $mode = $_POST['mode'];
    }
}

switch ($mode) {

    /**
     * The first thing the script does is to check for the location of
     * critical Geeklog system files. It checks the default location
     * and the public_html/ directory. If it can't find the files in
     * either of those places it will ask the user to specify their location.
     */
    default:

        // Make sure the version of PHP is supported.
        $phpv = php_v ();
        if (($phpv[0] < 4) || (($phpv[0] == 4) && ($phpv[1] < 1))) {
            $display .= '<h1>' . $LANG_INSTALL[4] . '</h1>' . LB;
            $display .= '<p>' . $LANG_INSTALL[5] . $phpv[0] . '.' . $phpv[1] . '.' . (int) $phpv[2] . $LANG_INSTALL[6] . '</p>' . LB;
        } else {

            /**
             * There is a known issue with Mac OS X if config.php is not in the default location. This script will then try to find
             * directories in the root of the OS's filesystem. Since OS X has a /System directory this script locates that by mistake
             * and sets the path to "/system/". Manually editing config.php solves this issue.
             */

            // Check the location of each file/directory
            $gl_path .= '/';
            $form_fields = '';
            $num_errors = 0;
            $_PATH = array( 'config.php'   => '',
                            'public_html/' => '',
                            'backups/'     => '',
                            'data/'        => '',
                            'language/'    => '',
                            'logs/'        => '',
                            'system/'      => '');

            foreach ($_PATH as $name => $path) {
                if ( !file_exists( $gl_path . $name ) && !file_exists( $gl_path . 'public_html/' . $name ) ) {
                    // If the file/directory is not located in the default location
                    // or in public_html have the user enter its location.
                    $form_fields .= '<p><label>' . $name . '</label> <input type="text" name="'
                                  . str_replace( '/', '', str_replace( '.php', '', $name ) )
                                  . '_path" value="/path/to/' . $name . '" size="25"></p>'  . LB;
                    $num_errors++;
                } else {
                    // See whether the file/directory is located in the default place or in public_html
                    $_PATH[$name] = (file_exists( $gl_path . $name )) ? $gl_path . $name : $gl_path . 'public_html/' . $name;

                    // Create a hidden form value incase the form has to be displayed
                    $form_fields .= '<input type="hidden" name="' . str_replace('/', '', str_replace('.php', '', $name))
                                  . '_path" value="' . $_PATH[$name] . '">' . LB;
                }
            }

            if ($num_errors == 0) {
                // If the script was able to locate all the system files/directories move onto the next step
                $req_string = 'index.php?mode=check_permissions' .
                            '&config_path=' . $_PATH['config.php'] .
                            '&public_html_path=' . $_PATH['public_html/'] .
                            '&backups_path=' . $_PATH['backups/'] .
                            '&data_path=' . $_PATH['data/'] .
                            '&language_path=' . $_PATH['language/'] .
                            '&logs_path=' . $_PATH['logs/'] .
                            '&system_path=' . $_PATH['system/'];
                header( 'Location: ' . $req_string );
            } else {
                // If the script was not able to locate all the system files/directories ask the user to enter their location
                $display .= '<h2>' . $LANG_INSTALL[7] . '</h2>
                    <p>' . $LANG_INSTALL[8] . '</p>
                    <form action="index.php" method="POST">
                    <input type="hidden" name="mode" value="check_permissions">
                    ' . $form_fields . '
                    <br />
                    <input type="submit" name="submit" class="submit" value="Next &gt;&gt;">
                    </form>' . LB;
            }
        }
        break;

    /**
     * The second step is to check permissions on the files/directories
     * that Geeklog needs to be able to write to. The script uses some of
     * the paths from the previous screen to determine file/directory locations.
     */
    case 'check_permissions':

        // Get the paths from the previous page
        $_PATH = array( 'config.php' => ((isset( $_GET['config_path'] )) ? $_GET['config_path'] : $_POST['config_path']),
                        'public_html/' => ((isset( $_GET['public_html_path'] )) ? $_GET['public_html_path'] : $_POST['public_html_path']),
                        'backups/'   => ((isset( $_GET['backups_path'] )) ? $_GET['backups_path'] : $_POST['backups_path']),
                        'data/'      => ((isset( $_GET['data_path'] )) ? $_GET['data_path'] : $_POST['data_path']),
                        'language/'  => ((isset( $_GET['language_path'] )) ? $_GET['language_path'] : $_POST['language_path']),
                        'logs/'      => ((isset( $_GET['logs_path'] )) ? $_GET['logs_path'] : $_POST['logs_path']),
                        'system/'    => ((isset( $_GET['system_path'] )) ? $_GET['system_path'] : $_POST['system_path']) );

        require_once( $_PATH['config.php'] ); // We need config.php for a few things.

        if ($_CONF['path'] == '/path/to/geeklog/') {
            $_CONF['path'] = $gl_path . '/';
        }

        $failed          = 0; // number of failed tests
        $display_permissions = '<br /><p><label class="file-permission-list"><b>' . $LANG_INSTALL[10] . '</b></label> <b>' . $LANG_INSTALL[11] . '</b></p>' . LB;
        $_PERMS = array('config.php', 'lib-common.php', 'error.log', 'access.log', 'rdf', 'userphotos', 'articles', 'topics', 'backups', 'data');

        // config.php
        if (!$config_file = @fopen( $_PATH['config.php'], 'a' )) {
            $display_permissions .= '<p><label class="file-permission-list"><code>' . $_PATH['config.php'] . '</code></label>' ;
            $_PERMS['config.php']      = sprintf( "%3o", @fileperms( $_PATH['config.php'] ) & 0777 );
            $display_permissions .= '<span class="error">' . $LANG_INSTALL[12] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['config.php'] . ')</p>' . LB ;
            $failed++;
        } else {
            fclose( $config_file );
        }

        // lib-common.php
        if (!$libcommon_file = @fopen( $_PATH['public_html/'] . 'lib-common.php', 'a' )) {
            $display_permissions .= '<p><label class="file-permission-list"><code>' . $_PATH['public_html/'] . 'lib-common.php' . '</code></label>' ;
            $_PERMS['lib-common.php']   = sprintf( "%3o", @fileperms( $_PATH['public_html/'] . 'lib-common.php' ) & 0777 );
            $display_permissions .= '<span class="error">' . $LANG_INSTALL[12] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['lib-common.php'] . ')</p>' . LB ;
            $failed++;
        } else {
            fclose( $libcommon_file );
        }

        // error.log
        if (!$err_file = @fopen( $_PATH['logs/'] . 'error.log', 'a' )) {
            // Permissions are incorrect
            $_PERMS['error.log'] = sprintf( "%3o", @fileperms( $_PATH['logs/'] . 'error.log' ) & 0777 );
            $display_permissions .= '<p><label class="file-permission-list"><code>' . $_PATH['logs/'] . 'error.log' . '</code></label>' ;
            $display_permissions .= '<span class="error">' . $LANG_INSTALL[14] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['error.log'] . ')</p>' . LB ;
            $failed++;
        } else {
            // Permissions are correct
            fclose( $err_file );
        }

        // access.log
        if (!$accfile = @fopen( $_PATH['logs/'] . 'access.log', 'a' )) {
            // Permissions are incorrect
            $_PERMS['access.log'] = sprintf( "%3o", @fileperms( $_PATH['logs/'] . 'access.log' ) & 0777 );
            $display_permissions .= '<p><label class="file-permission-list"><code>' . $_PATH['logs/'] . 'access.log' . '</code></label>' ;
            $display_permissions .= '<span class="error">' . $LANG_INSTALL[14] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['access.log'] . ')</p> ' . LB ;
            $failed++;
        } else {
            // Permissions are correct
            fclose( $accfile );
        }

        // backend directory & geeklog.rss
        $_CONF['rdf_file'] = $_PATH['public_html/'] . 'backend/geeklog.rss';
        if ($_CONF['backend'] > 0) {
            // If GL headlines are enabled
            if (!$file = @fopen( $_CONF['rdf_file'], 'w' )) {
                // Permissions are incorrect
                $_PERMS['rdf'] = sprintf( "%3o", @fileperms( $_CONF['rdf_file'] ) & 0777 );
                $display_permissions .= '<p><label class="file-permission-list"><code>' . $_CONF['rdf_file'] . '</code></label>' ;
                $display_permissions .= '<span class="error">' . $LANG_INSTALL[14] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['rdf'] . ') </p>' . LB;
                $failed++;
            } else {
                // Permissions are correct
                fclose ($file);
            }
        } else {
            // If GL headlines are disabled
            $display_permissions .= '<p><label class="file-permission-list"><code>' . $_CONF['path'] . 'public_html/backend' . '</code></label> ' ;
            $display_permissions .= $LANG_INSTALL[14] . '</p>' . LB;
        }


        // userphotos directory
        $_CONF['path_images'] = $_PATH['public_html/'] . 'images/';
        if ($_CONF['allow_user_photo'] > 0) {
            // If user photos are enabled
            if (!$file = @fopen($_CONF['path_images'] . 'userphotos/test.gif', 'w' )) {
                // Permissions are incorrect
                $_PERMS['userphoto'] = sprintf( "%3o", @fileperms( $_CONF['path_images'] . 'userphotos/' ) & 0777 );
                $display_permissions .= '<p><label class="file-permission-list"><code>' . $_CONF['path_images'] . 'userphotos/</code></label>' ;
                $display_permissions .= '<span class="error">' . $LANG_INSTALL[14] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['userphoto'] . ') </p>' . LB;
            } else {
                // Permissions are correct
                fclose( $file );
                unlink( $_CONF['path_images'] . 'userphotos/test.gif' );
                $successful++;
            }
        } else {
            // If user photos are disabled
            $display_permissions .= '<p><label class="file-permission-list"><code>' . $_CONF['path_images'] . 'userphotos/</code></label> ' ;
            $display_permissions .= $LANG_INSTALL[17] . '</p>' . LB;
        }


        // articles directory
        if ($_CONF['maximagesperarticle'] > 0) {
            // If articles are enabled
            if (!$file = @fopen( $_CONF['path_images'] . 'articles/test.gif', 'w' )) {
                // Permissions are incorrect
                $_PERMS['articles'] = sprintf( "%3o", @fileperms( $_CONF['path_images'] . 'articles/' ) & 0777 );
                $display_permissions .= '<p><label class="file-permission-list"><code>' . $_CONF['path_images'] . 'articles/</code></label>' ;
                $display_permissions .= '<span class="error">' . $LANG_INSTALL[14] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['articles'] . ') </p>' . LB;
                $failed++;
            } else {
                // Permissions are correct
                fclose( $file );
                unlink( $_CONF['path_images'] . 'articles/test.gif' );
            }
        } else {
            // If articles are disabled
            $display_permissions .= '<p><label class="file-permission-list"><code>' . $_CONF['path_images'] . 'articles/</code></label> ' ;
            $display_permissions .= $LANG_INSTALL[18] . '</p>' . LB;
        }


        // topics directory
        if (!$file = @fopen( $_CONF['path_images'] . 'topics/test.gif', 'w' )) {
            // Permissions are incorrect
            $_PERMS['topics'] = sprintf( "%3o", @fileperms( $_CONF['path_images'] . 'topics/' ) & 0777 );
            $display_permissions .= '<p><label class="file-permission-list"><code>' . $_CONF['path_images'] . 'topics/</code></label>' ;
            $display_permissions .= '<span class="error">' . $LANG_INSTALL[14] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['topics'] . ') </p>' . LB;
            $failed++;
        } else {
            // Permissions are correct
            fclose( $file );
            unlink( $_CONF['path_images'] . 'topics/test.gif' );
        }


        // backups directory
        if ($_CONF['allow_mysqldump'] == 1) {
            // If backups are enabled
            if (!$file = @fopen($_PATH['backups/'] . 'test.txt', 'w' )) {
                // Permissions are incorrect
                $_PERMS['backups'] = sprintf( "%3o", @fileperms( $_PATH['backups/'] ) & 0777 );
                $display_permissions .= '<p><label class="file-permission-list"><code>' . $_PATH['backups/'] . '</code></label>' ;
                $display_permissions .= '<span class="error">' . $LANG_INSTALL[14] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['backups'] . ') </p>' . LB;
                $failed++;
            } else {
                // Permissions are correct
                fclose( $file );
                unlink( $_PATH['backups/'] . 'test.txt' );
            }
        }

        // data directory
        if (!$file = @fopen( $_PATH['data/'] . 'test.txt', 'w' )) {
            // Permissions are incorrect
            $_PERMS['data'] = sprintf( "%3o", @fileperms( $_PATH['data/'] ) & 0777 );
            $display_permissions .= '<p><label class="file-permission-list"><code>' . $_PATH['data/'] . '</code></label>' ;
            $display_permissions .= '<span class="error">' . $LANG_INSTALL[14] . ' 777</span> (' . $LANG_INSTALL[13] . ' ' . $_PERMS['data'] . ') </p>' . LB;
            $failed++;
        } else {
            // Permissions are correct
            fclose( $file );
            unlink( $_PATH['data/'] . 'test.txt' );
        }

        $display .= $LANG_INSTALL[9] . '<br /><br />' . LB;

        if ($failed > 0) {

            $display .= '
            <p>' . $LANG_INSTALL[19] . '</p>
            ' . $display_permissions . '<br /><p><strong><span class="error">' . $LANG_INSTALL[20] . '</span></strong>
            ' . $LANG_INSTALL[21] . '</p>
            <p>' . $LANG_INSTALL[22] . '</p>
            <br /><br />' . LB;

        }

        // If the script was able to locate all the system files/directories move onto the next step
        $req_string = 'index.php?mode=write_paths' .
                    '&config_path=' . $_PATH['config.php'] .
                    '&public_html_path=' . $_PATH['public_html/'] .
                    '&backups_path=' . $_PATH['backups/'] .
                    '&data_path=' . $_PATH['data/'] .
                    '&language_path=' . $_PATH['language/'] .
                    '&logs_path=' . $_PATH['logs/'] .
                    '&system_path=' . $_PATH['system/'];

       $display .= '
       <div class="install-type-container-outer">
           <div class="install-type-container-inner">
               <h2>' . $LANG_INSTALL[23] . '</h2>
               <div class="install" onmouseover="this.style.background=\'#BBB\'" onmouseout="this.style.background=\'#CCC\'"><a id="install" href="'. $req_string . '&op=install">' . $LANG_INSTALL[24] . '</a></div>
               <div class="upgrade" onmouseover="this.style.background=\'#BBB\'" onmouseout="this.style.background=\'#CCC\'"><a id="install" href="'. $req_string . '&op=upgrade">' . $LANG_INSTALL[25] . '</a></div>
           </div>
       </div>' . LB;

        break;

    /**
     * Write the file/directory paths to config.php and lib-common.php
     */
    case 'write_paths':

        // Get the paths from the previous page
        $_PATH = array( 'config.php' => ((isset( $_GET['config_path'] )) ? $_GET['config_path'] : $_POST['config_path']),
                        'public_html/' => ((isset( $_GET['public_html_path'] )) ? $_GET['public_html_path'] : $_POST['public_html_path']),
                        'backups/'   => ((isset( $_GET['backups_path'] )) ? $_GET['backups_path'] : $_POST['backups_path']),
                        'data/'      => ((isset( $_GET['data_path'] )) ? $_GET['data_path'] : $_POST['data_path']),
                        'language/'  => ((isset( $_GET['language_path'] )) ? $_GET['language_path'] : $_POST['language_path']),
                        'logs/'      => ((isset( $_GET['logs_path'] )) ? $_GET['logs_path'] : $_POST['logs_path']),
                        'system/'    => ((isset( $_GET['system_path'] )) ? $_GET['system_path'] : $_POST['system_path']) );
        $config_path = str_replace( 'config.php', '', $_PATH['config.php']  );

        if (!INST_checkRequiredPerms( $config_path, $_PATH['public_html/'] )) { // Can't write to config.php or lib-common.php

            $display .= INST_permissionWarning( $config_path, $_PATH['public_html/'] );

        } else { // Permissions are ok

            // Edit config.php and set the correct file/directory paths
            $config_file = fopen( $config_path . 'config.php', 'r' );
            $config_data = fread( $config_file, filesize( $config_path . 'config.php' ) );
            fclose( $config_file );

            // /path/to/geeklog
            $config_data = str_replace( "\$_CONF['path']            = '/path/to/geeklog/'", "\$_CONF['path']            = '"
                                    . str_replace( 'config.php', '', $_PATH['config.php'] ) . "'", $config_data );

            // public_html/
            $config_data = str_replace( "\$_CONF['path_html']         = \$_CONF['path'] . 'public_html/';", "\$_CONF['path_html']         = '" . $_PATH['public_html/'] . "';", $config_data );
            // backups/
            $config_data = str_replace( "\$_CONF['backup_path']   = \$_CONF['path'] . 'backups/';", "\$_CONF['backup_path']   = '" . $_PATH['backups/'] . "';", $config_data );
            // data/
            $config_data = str_replace( "\$_CONF['path_data']     = \$_CONF['path'] . 'data/';", "\$_CONF['path_data']     = '" . $_PATH['data/'] . "';", $config_data );
            // language/
            $config_data = str_replace( "\$_CONF['path_language'] = \$_CONF['path'] . 'language/';", "\$_CONF['path_language'] = '" . $_PATH['language/'] . "';", $config_data );
            // logs/
            $config_data = str_replace( "\$_CONF['path_log']      = \$_CONF['path'] . 'logs/';", "\$_CONF['path_log']      = '" . $_PATH['logs/'] . "';", $config_data );
            // system/
            $config_data = str_replace( "\$_CONF['path_system']   = \$_CONF['path'] . 'system/';", "\$_CONF['path_system']   = '" . $_PATH['system/'] . "';", $config_data );

            $config_file = fopen( $config_path . 'config.php', 'w' );
            if (!fwrite( $config_file, $config_data )) {
                exit ( $LANG_INSTALL[26] . ' ' . $_PATH['config.php'] . $LANG_INSTALL[27] );
            }
            fclose( $config_file );

            // Edit lib-common.php and enter the correct /path/to/geeklog/config.php
            $libcommon_path = $_PATH['public_html/'] . 'lib-common.php';
            $libcommon_file = fopen( $libcommon_path, 'r' );
            $libcommon_data = fread( $libcommon_file, filesize( $libcommon_path ) );
            fclose( $libcommon_file );
            $libcommon_data = str_replace( 'require_once( \'/path/to/geeklog/config.php\' );', 'require_once( \'' . $config_path . 'config.php\' );', $libcommon_data ); // Set path
            $libcommon_file = fopen( $libcommon_path, 'w' );
            if (!fwrite($libcommon_file, $libcommon_data)) {
                exit ( $LANG_INSTALL[26] . ' ' . $_PATH['public_html/'] . $LANG_INSTALL[28] );
            }
            fclose ( $libcommon_file );

            // Continue to the next step: Fresh install or Upgrade
            header( 'Location: index.php?mode=' . $_GET['op'] . '&config_path=' . $_PATH['config.php'] );

        }
        break;

    /**
     * Start the fresh install process
     */
    case 'install':

        if (!isset( $_POST['step'] )) {
            $_POST['step'] = 1;
        }

        $config_path = (isset( $_POST['config_path'] )) ? $_POST['config_path'] : ((isset( $_GET['config_path'] )) ? $_GET['config_path'] : '');

        // Get and set which step to display
        $step = '';
        if (isset( $_GET['step']) ) {
            $step = $_GET['step'];
        } else {
            if (isset( $_POST['step']) ) {
                $step = $_POST['step'];
            }
        }

        switch ($step) {

            /**
             * Page 1 - Enter Geeklog config information
             */
            case 1:

                // Set all the form values either with their defaults or with received POST data.
                // The only instance where you'd get POST data would be if the user has to
                // go back because they entered incorrect database information.
                $site_name = (isset( $_POST['site_name'] )) ? str_replace( '\\', '', $_POST['site_name'] ) : $LANG_INSTALL[29];
                $site_slogan = (isset( $_POST['site_slogan'] )) ? str_replace( '\\', '', $_POST['site_slogan'] ) : $LANG_INSTALL[30];
                $mysql_innodb_selected = '';
                $mysql_selected = '';
                $mssql_selected = '';
                if (isset( $_POST['db_type'] )) {
                    switch ($_POST['db_type']) {
                        case 'mysql-innodb':
                            $msyql_innodb_selected = ' selected="selected"';
                            break;
                        case 'mssql':
                            $mssql_selected = ' selected="selected"';
                            break;
                        default:
                            $mysql_selected = ' selected="selected"';
                            break;
                    }
                } else {
                    $mysql_selected = ' selected="selected"';
                }
                $db_host = (isset( $_POST['db_host'] )) ? $_POST['db_host'] : 'localhost';
                $db_name = (isset( $_POST['db_name'] )) ? $_POST['db_name'] : 'geeklog';
                $db_user = (isset( $_POST['db_user'] )) ? $_POST['db_user'] : '';
                $db_prefix = (isset( $_POST['db_prefix'] )) ? $_POST['db_prefix'] : 'gl_';
                $site_url = (isset( $_POST['site_url'] )) ? $_POST['site_url'] : 'http://' . $_SERVER['HTTP_HOST'] . preg_replace( '/\/admin.*/', '', $_SERVER['PHP_SELF'] ) ;
                $site_admin_url = (isset( $_POST['site_admin_url'] )) ? $_POST['site_admin_url'] : preg_replace( '/\/install.*/', '', $_SERVER['PHP_SELF'] );
                $site_mail = (isset( $_POST['site_mail'] )) ? $_POST['site_mail'] : 'admin@' . $_SERVER['HTTP_HOST'];
                $noreply_mail = (isset( $_POST['noreply_mail'] )) ? $_POST['noreply_mail'] : 'noreply@' . $_SERVER['HTTP_HOST'];

                $display .= '
                    <h2>' . $LANG_INSTALL[31] . '</h2>
                    <form action="index.php" method="POST">
                    <input type="hidden" name="mode" value="install">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="config_path" value="' . $config_path . '">

                    <p><label>' . $LANG_INSTALL[32] . '</label> <input type="text" name="site_name" value="' . $site_name . '" size="25"></p>
                    <p><label>' . $LANG_INSTALL[33] . '</label> <input type="text" name="site_slogan" value="' . $site_slogan . '" size="25"></p><br />
                    <p><label>' . $LANG_INSTALL[34] . '</label> <select name="db_type">
                        <option value="mysql"' . $mysql_selected . '>' . $LANG_INSTALL[35] . '</option>
                        <option value="mysql-innodb"' . $msyql_innodb_selected . '>' . $LANG_INSTALL[36] . '</option>
                        <option value="mssql"' . $mssql_selected . '>' . $LANG_INSTALL[37] . '</option></select> <small>' . $LANG_INSTALL[38] . '</small></p>
                    <p><label>' . $LANG_INSTALL[39] . '</label> <input type="text" name="db_host" value="'. $db_host .'" size="10"></p>
                    <p><label>' . $LANG_INSTALL[40] . '</label> <input type="text" name="db_name" value="'. $db_name . '" size="10"></p>
                    <p><label>' . $LANG_INSTALL[41] . '</label> <input type="text" name="db_user" value="' . $db_user . '" size="10"></p>
                    <p><label>' . $LANG_INSTALL[42] . '</label> <input type="password" name="db_pass" size="10"></p>
                    <p><label>' . $LANG_INSTALL[43] . '</label> <input type="text" name="db_prefix" value="' . $db_prefix . '" size="10"></p>

                    <br />
                    <h2>' . $LANG_INSTALL[44] . '</h2>

                    <p><label>' . $LANG_INSTALL[45] . '</label> <input type="text" name="site_url" value="' . $site_url . '" size="30">  &nbsp; ' . $LANG_INSTALL[46] . '</p>

                    <p><label>' . $LANG_INSTALL[47] . '</label> <input type="text" name="site_admin_url" value="' . $site_admin_url . '" size="30">  &nbsp; ' . $LANG_INSTALL[46] . '</p>

                    <p><label>' . $LANG_INSTALL[48] . '</label> <input type="text" name="site_mail" value="' . $site_mail . '" size="30"></p>

                    <p><label>' . $LANG_INSTALL[49] . '</label> <input type="text" name="noreply_mail" value="' . $noreply_mail . '" size="30"></p>

                    <br />
                    <input type="submit" name="submit" class="submit" value="' . $LANG_INSTALL[50] . ' &gt;&gt;">
                    </form>' . LB;

                break;


            /**
             * Page 2 - Enter information into config.php
             * and ask about InnoDB tables (if supported)
             */
            case 2:

                // Set all the variables from the received POST data.
                $site_name = addslashes( $_POST['site_name'] );
                $site_slogan = addslashes( $_POST['site_slogan'] );
                $db_type = $_POST['db_type'];
                $db_host = $_POST['db_host'];
                $db_name = $_POST['db_name'];
                $db_user = $_POST['db_user'];
                $db_pass = $_POST['db_pass'];
                $db_prefix = $_POST['db_prefix'];
                $site_url = $_POST['site_url'];
                $site_admin_url = $_POST['site_admin_url'];
                $site_mail = $_POST['site_mail'];
                $noreply_mail = $_POST['noreply_mail'];

                // Check if you can connect to database
                $invalid_db_auth = false;
                $db_handle = null;
                $innodb = false;
                switch ($db_type) {
                    case 'mysql-innodb':
                        $innodb = true;
                        $db_type = 'mysql';
                    case 'mysql':
                        if (!$db_handle = @mysql_connect( $db_host, $db_user, $db_pass )) {
                            $invalid_db_auth = true;
                        }
                        break;
                    case 'mssql':
                        if (!$db_handle = @mssql_connect( $db_host, $db_user, $db_pass )) {
                            $invalid_db_auth = true;
                        }
                        break;
                }

                // If using MySQL check to make sure the version is supported
                $outdated_mysql = false;
                if ($_DB_dbms == 'mysql') {
                    $myv = mysql_v();
                    if (($myv[0] < 3) || (($myv[0] == 3) && ($myv[1] < 23)) ||
                            (($myv[0] == 3) && ($myv[1] == 23) && ($myv[2] < 2))) {
                                $outdated_mysql = true;
                    }
                }
                if ($outdated_mysql === true) { // If MySQL is out of date
                    $display .= '<h1>' . $LANG_INSTALL[51] . '</h1>' . LB;
                    $display .= '<p>' . $LANG_INSTALL[52] . $myv[0] . '.' . $myv[1] . '.' . $myv[2] . $LANG_INSTALL[53] . '</p>' . LB;
                } else if ($invalid_db_auth === true) { // If we can't connect to the database server
                    $display .= '<h2>' . $LANG_INSTALL['54'] . '</h2>
                        <p>' . $LANG_INSTALL[55] . '</p>' . INST_showReturnFormData() . LB;
                } else { // If we can connect

                    // Check if the database exists
                    $db_exists = false;
                    switch ($db_type) {
                        case 'mysql':
                            if (@mysql_select_db( $db_name, $db_handle )) {
                                $db_exists = true;
                            }
                            break;
                        case 'mssql':
                            if (@mssql_select_db( $db_name, $db_handle )) {
                                $db_exists = true;
                            }
                            break;
                    }
                    if ($db_exists === false) { // If database doesn't exist
                        $display .= '<h2>' . $LANG_INSTALL[56] . '</h2>
                        <p>' . $LANG_INSTALL[57] . '</p>' . INST_showReturnFormData() . LB;
                    } else { // If database does exist

                        // Read in config.php so we can insert the information
                        $config_file = fopen( $config_path, 'r' );
                        $config_data = fread( $config_file, filesize( $config_path ) );
                        fclose( $config_file );

                        // Basic Information
                        $config_data = str_replace( '$_CONF[\'site_name\']         = \'Geeklog Site\';', '$_CONF[\'site_name\']         = \'' . $site_name . '\';', $config_data ); // Set GL Site Name
                        $config_data = str_replace( '$_CONF[\'site_slogan\']       = \'Another Nifty Geeklog Site\';', '$_CONF[\'site_slogan\']       = \'' . $site_slogan . '\';', $config_data ); // Set GL Site Slogan

                        // DB information
                        $config_data = str_replace( '$_DB_dbms = \'mysql\'', '$_DB_dbms = \'' . $db_type . '\'', $config_data ); // Set DB type
                        $config_data = str_replace( '$_DB_dbms = \'\'', '$_DB_dbms = \'' . $db_type . '\'', $config_data ); // Set DB type
                        $config_data = str_replace( '$_DB_host         = \'localhost\'', '$_DB_host         = \'' . $db_host . '\'', $config_data ); // Set DB Host
                        $config_data = str_replace( '$_DB_name         = \'geeklog\'', '$_DB_name         = \'' . $db_name . '\'', $config_data ); // Set DB name
                        $config_data = str_replace( '$_DB_user         = \'username\'', '$_DB_user         = \'' . $db_user . '\'', $config_data ); // Set DB user
                        $config_data = str_replace( '$_DB_pass         = \'password\'', '$_DB_pass         = \'' . $db_pass . '\'', $config_data ); // Set DB pass
                        $config_data = str_replace( '$_DB_table_prefix = \'gl_\'', '$_DB_table_prefix = \'' . $db_prefix . '\'', $config_data ); // Set DB prefix

                        // Optional information
                        $config_data = str_replace( '$_CONF[\'site_url\']          = \'http://www.example.com\'', '$_CONF[\'site_url\']          = \'' . $site_url . '\'', $config_data ); // Set site_url
                        $config_data = str_replace( '$_CONF[\'site_admin_url\']    = $_CONF[\'site_url\'] . \'/admin\'', '$_CONF[\'site_admin_url\']    = $_CONF[\'site_url\'] . \'' . $site_admin_url . '\'', $config_data ); // Set site_admin_url
                        $config_data = str_replace( '$_CONF[\'site_mail\']         = \'admin@example.com\'', '$_CONF[\'site_mail\']          = \'' . $site_mail . '\'', $config_data ); // Set site_mail
                        $config_data = str_replace( '$_CONF[\'noreply_mail\']         = \'noreply@example.com\'', '$_CONF[\'noreply_mail\']         = \'' . $noreply_mail . '\'', $config_data ); // Set site_mail

                        // Write our changes to config.php
                        $config_file = fopen( $config_path, 'w' );
                        if (!fwrite( $config_file, $config_data )) {
                            exit( $LANG_INSTALL[26] . ' ' . $config_path . $LANG_INSTALL[58] );
                        }
                        fclose( $config_file );

                        // If using MySQL check to see if InnoDB is supported
                        require_once( $config_path );
                        require_once( $_CONF['path_system'] . 'lib-database.php' );

                        if ($innodb === true && !innodb_supported()) {
                            // Warn that InnoDB tables are not supported
                            $display .= '<h2>' . $LANG_INSTALL[59] . '</h2>
                            <p>' . $LANG_INSTALL['60'] . '</p>

                            <br />
                            <div style="margin-left: auto; margin-right: auto; width: 125px">
                                <div style="position: relative; right: 10px">
                                    <form action="index.php" method="POST">
                                    <input type="hidden" name="mode" value="install">
                                    <input type="hidden" name="step" value="1">
                                    <input type="hidden" name="config_path" value="' . $config_path . '">
                                    <input type="submit" value="&lt;&lt; ' . $LANG_INSTALL[61] . '">
                                    </form>
                                </div>

                                <div style="position: relative; left: 65px; top: -27px">
                                    <form action="index.php" method="POST">
                                    <input type="hidden" name="mode" value="install">
                                    <input type="hidden" name="step" value="3">
                                    <input type="hidden" name="config_path" value="' . $config_path . '">
                                    <input type="hidden" name="innodb" value="false">
                                    <input type="submit" name="submit" value="' . $LANG_INSTALL[62] . ' &gt;&gt;">
                                    </form>
                                </div>
                            </div>' . LB;
                        } else {
                            // Continue on to step 3 where the installation will happen
                            $req_string = 'index.php?mode=install&step=3&config_path=' . $config_path;
                            if ($innodb === true) {
                                $req_string .= '&innodb=true';
                            }
                            header( 'Location: ' . $req_string );
                        }

                    }
                }

                break;


            /**
             * Page 3 - Install
             */
            case 3:

                if ($_POST['submit'] == '<< ' . $LANG_INSTALL[61]) {
                    header( 'Location: index.php?mode=install' );
                }

                // Check whether to use InnoDB tables
                $use_innodb = false;
                if ((isset( $_POST['innodb'] ) && $_POST['innodb'] == 'true') || (isset($_GET['innodb']) && $_GET['innodb'] == 'true')) {
                    $use_innodb = true;
                }

                // Let's do this
                require_once( $config_path );
                require_once( $_CONF['path_system'] . 'lib-database.php' );

                // Check if GL is already installed
                if (INST_checkTableExists( 'vars' )) {

                    $display .= '<p>' . $LANG_INSTALL[63] . '</p>
                        <ol>
                            <li>' . $LANG_INSTALL[64] . '</li>
                            <li>' . $LANG_INSTALL[65] . '</li>
                        </ol>

                        <div style="margin-left: auto; margin-right: auto; width: 125px">
                            <div style="position: absolute">
                                <form action="index.php" method="POST">
                                <input type="hidden" name="mode" value="install">
                                <input type="hidden" name="step" value="3">
                                <input type="hidden" name="config_path" value="' . $config_path . '">
                                <input type="hidden" name="innodb" value="' . (($use_innodb) ? 'true' : 'false') . '">
                                <input type="submit" value="' . $LANG_INSTALL[66] . '">
                                </form>
                            </div>

                            <div style="position: relative; left: 55px; top: 5px">
                                <form action="index.php" method="POST">
                                <input type="hidden" name="mode" value="upgrade">
                                <input type="submit" value="' . $LANG_INSTALL[25] . '">
                                </form>
                            </div>
                        </div>
                        ' . LB;

                } else {

                    if (INST_createDatabaseStructures( $use_innodb )) {
                        // Done with installation... redirect to success page
                        header( 'Location: success.php?type=install&language=' . $language );
                    } else {
                        $display .= "<h2>" . $LANG_INSTALL[67] . "</h2><p>" . $LANG_INSTALL[68] . "</p>"; // Yeah, this isn't a very helpful error...
                    }

                }
                break;

        } // End switch (fresh install steps)

        break;


    /**
     * Start the upgrade process
     */
    case 'upgrade':

        if (!isset( $_POST['step'] )) {
            $_POST['step'] = 1;
        }

        $config_path = (isset( $_POST['config_path'] )) ? $_POST['config_path'] : ((isset( $_GET['config_path'] )) ? $_GET['config_path'] : '');

        // Get and set which step to display
        $step = '';
        if (isset( $_GET['step'] )) {
            $step = $_GET['step'];
        } else {
            if (isset( $_POST['step'] )) {
                $step = $_POST['step'];
            }
        }

        switch ($step) {

            /**
             * Page 1 - Enter Geeklog config information
             */
            case 1:

                // Set all the form values either with their defaults or with received POST data.
                // The only instance where you'd get POST data would be if the user has to
                // go back because they entered incorrect database information.
                require_once( $config_path );

                $site_name = $_CONF['site_name'];
                $site_slogan = $_CONF['site_slogan'];
                $mysql_selected = '';
                $mssql_selected = '';
                switch ($_DB_dbms) {
                    case 'mysql':
                        $mysql_selected = ' selected="selected"';
                        break;
                    case 'mssql':
                        $mssql_selected = ' selected="selected"';
                        break;
                }

                $db_host = $_DB_host;
                $db_name = $_DB_name;
                $db_user = ($_DB_user == 'username') ? '' : $_DB_user;
                $db_pass = ($_DB_pass == 'password') ? '' : $_DB_pass;
                $db_prefix = $_DB_table_prefix;

                $site_url = ($_CONF['site_url'] == 'http://www.example.com') ? 'http://' . $_SERVER['HTTP_HOST'] . preg_replace( '/\/admin.*/', '', $_SERVER['PHP_SELF'] ) : $_CONF['site_url'];
                $site_admin_url = ($_CONF['site_admin_url'] == 'http://www.example.com/admin') ? preg_replace( '/\/install.*/', '', $_SERVER['PHP_SELF'] ) : $_CONF['site_admin_url'];
                $site_mail = ($_CONF['site_mail'] == 'admin@example.com') ? 'admin@' . $_SERVER['HTTP_HOST'] : $_CONF['site_mail'];
                $noreply_mail = ($_CONF['noreply_mail'] == 'noreply@example.com') ? 'noreply@' . $_SERVER['HTTP_HOST'] : $_CONF['noreply_mail'];

                $display .= '
                    <h2>' . $LANG_INSTALL[69] . '</h2>

                    <p>' . $LANG_INSTALL[70] . '</p>

                    <p>' . $LANG_INSTALL[71] . VERSION . $LANG_INSTALL[72] . '</p>

                    <p>' . $LANG_INSTALL[73] . '</p>

                    <br />
                    <h2>' . $LANG_INSTALL[31] . '</h2>
                    <form action="index.php" method="POST">
                    <input type="hidden" name="mode" value="upgrade">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="config_path" value="' . $config_path . '">
                    <input type="hidden" name="old_site_name" value="' . $site_name .'">
                    <input type="hidden" name="old_site_slogan" value="' . $site_slogan . '">
                    <input type="hidden" name="old_db_type" value="' . $_DB_dbms . '">
                    <input type="hidden" name="old_db_host" value="' . $db_host . '">
                    <input type="hidden" name="old_db_name" value="' . $db_name . '">
                    <input type="hidden" name="old_db_user" value="' . $db_user . '">
                    <input type="hidden" name="old_db_pass" value="' . $db_pass . '">
                    <input type="hidden" name="old_db_prefix" value="' . $db_prefix . '">
                    <input type="hidden" name="old_site_url" value="' . $site_url . '">
                    <input type="hidden" name="old_site_admin_url" value="' . str_replace( $site_url, '', $site_admin_url ) . '">
                    <input type="hidden" name="old_site_mail" value="' . $site_mail . '">
                    <input type="hidden" name="old_noreply_mail" value="' . $noreply_mail . '">
                    <p><label>' . $LANG_INSTALL[32] . '</label> <input type="text" name="site_name" value="' . $site_name . '" size="25"></p>
                    <p><label>' . $LANG_INSTALL[33] . '</label> <input type="text" name="site_slogan" value="' . $site_slogan . '" size="25"></p><br />
                    <p><label>' . $LANG_INSTALL[34] . '</label> <select name="db_type">
                        <option value="mysql"' . $msyql_selected . '>' . $LANG_INSTALL[35] . '</option>
                        <option value="mssql"' . $mssql_selected . '>' . $LANG_INSTALL[37] . '</option></select></p>
                    <p><label>' . $LANG_INSTALL[39] . '</label> <input type="text" name="db_host" value="'. $db_host .'" size="10"></p>
                    <p><label>' . $LANG_INSTALL[40] . '</label> <input type="text" name="db_name" value="'. $db_name . '" size="10"></p>
                    <p><label>' . $LANG_INSTALL[41] . '</label> <input type="text" name="db_user" value="' . $db_user . '" size="10"></p>
                    <p><label>' . $LANG_INSTALL[42] . '</label> <input type="password" name="db_pass" value="' . $db_pass . '" size="10"></p>
                    <p><label>' . $LANG_INSTALL[43] . '</label> <input type="text" name="db_prefix" value="' . $db_prefix . '" size="10"></p>

                    <br />
                    <h2>' . $LANG_INSTALL[44] . '</h2>

                    <p><label>' . $LANG_INSTALL[45] . '</label> <input type="text" name="site_url" value="' . $site_url . '" size="30">  &nbsp; ' . $LANG_INSTALL[46] . '</p>

                    <p><label>' . $LANG_INSTALL[47] . '</label> <input type="text" name="site_admin_url" value="' . str_replace( $site_url, '', $site_admin_url ) . '" size="30">  &nbsp; ' . $LANG_INSTALL[46] . '</p>

                    <p><label>' . $LANG_INSTALL[48] . '</label> <input type="text" name="site_mail" value="' . $site_mail . '" size="30"></p>

                    <p><label>' . $LANG_INSTALL[49] . '</label> <input type="text" name="noreply_mail" value="' . $noreply_mail . '" size="30"></p>

                    <br />
                    <input type="submit" name="submit" class="submit" value="' . $LANG_INSTALL[25] . ' &gt;&gt;">
                    </form>' . LB;

                break;

            case 2:

                // Set all the variables from the received POST data.
                $site_name = addslashes( $_POST['site_name'] );
                $site_slogan = addslashes( $_POST['site_slogan'] );
                $db_type = $_POST['db_type'];
                $db_host = $_POST['db_host'];
                $db_name = $_POST['db_name'];
                $db_user = $_POST['db_user'];
                $db_pass = $_POST['db_pass'];
                $db_prefix = $_POST['db_prefix'];
                $site_url = $_POST['site_url'];
                $site_admin_url = $_POST['site_admin_url'];
                $site_mail = $_POST['site_mail'];
                $noreply_mail = $_POST['noreply_mail'];

                $old_site_name = $_POST['old_site_name'];
                $old_site_slogan = $_POST['old_site_slogan'];
                $old_db_type = $_POST['old_db_type'];
                $old_db_host = $_POST['old_db_host'];
                $old_db_name = $_POST['old_db_name'];
                $old_db_user = $_POST['old_db_user'];
                $old_db_pass = $_POST['old_db_pass'];
                $old_db_prefix = $_POST['old_db_prefix'];
                $old_site_url = $_POST['old_site_url'];
                $old_site_admin_url = $_POST['old_site_admin_url'];
                $old_site_mail = $_POST['old_site_mail'];
                $old_noreply_mail = $_POST['old_noreply_mail'];

                // Check if you can connect to database
                $invalid_db_auth = false;
                $db_handle = null;
                switch ($db_type) {
                    case 'mysql':
                        if (!$db_handle = @mysql_connect( $db_host, $db_user, $db_pass )) {
                            $invalid_db_auth = true;
                        }
                        break;
                    case 'mssql':
                        if (!$db_handle = @mssql_connect( $db_host, $db_user, $db_pass )) {
                            $invalid_db_auth = true;
                        }
                        break;
                }

                if ($invalid_db_auth === true) { // If we can't connect to the database server
                    $display .= '<h2>' . $LANG_INSTALL[54] . '</h2>
                        <p>' . $LANG_INSTALL[55] . '</p>' . INST_showReturnFormData() . LB;
                } else { // If we can connect

                    // Check if the database exists
                    $db_exists = false;
                    switch ($db_type) {
                        case 'mysql':
                            if (@mysql_select_db( $db_name, $db_handle )) {
                                $db_exists = true;
                            }
                            break;
                        case 'mssql':
                            if (@mssql_select_db( $db_name, $db_handle )) {
                                $db_exists = true;
                            }
                            break;
                    }

                    if ($db_exists === false) { // If database doesn't exist
                        $display .= '<h2>' . $LANG_INSTALL[56] . '</h2>
                        <p>' . $LANG_INSTALL[57] . '</p>' . INST_showReturnFormData() . LB;
                    } else { // If database does exist

                        // Read in config.php so we can insert the information
                        $config_file = fopen( $config_path, 'r');
                        $config_data = fread( $config_file, filesize( $config_path ) );
                        fclose( $config_file );

                        // Basic Information
                        $config_data = str_replace( '$_CONF[\'site_name\']         = \'' . $old_site_name . '\';', '$_CONF[\'site_name\']         = \'' . $site_name . '\';', $config_data ); // Set GL Site Name
                        $config_data = str_replace( '$_CONF[\'site_slogan\']       = \'' . $old_site_slogan . '\';', '$_CONF[\'site_slogan\']       = \'' . $site_slogan . '\';', $config_data ); // Set GL Site Slogan

                        // DB information
                        $config_data = str_replace( '$_DB_dbms = \'' . $old_db_type . '\'', '$_DB_dbms = \'' . $db_type . '\'', $config_data ); // Set DB type
                        $config_data = str_replace( '$_DB_host         = \'' . $old_db_host . '\'', '$_DB_host         = \'' . $db_host . '\'', $config_data ); // Set DB Host
                        $config_data = str_replace( '$_DB_name         = \'' . $old_db_name . '\'', '$_DB_name         = \'' . $db_name . '\'', $config_data ); // Set DB name
                        $config_data = str_replace( '$_DB_user         = \'' . $old_db_user . '\'', '$_DB_user         = \'' . $db_user . '\'', $config_data ); // Set DB user
                        $config_data = str_replace( '$_DB_pass         = \'' . $old_db_pass . '\'', '$_DB_pass         = \'' . $db_pass . '\'', $config_data ); // Set DB pass
                        $config_data = str_replace( '$_DB_table_prefix = \'' . $old_db_prefix . '\'', '$_DB_table_prefix = \'' . $db_prefix . '\'', $config_data ); // Set DB prefix

                        // Optional information
                        $config_data = str_replace( '$_CONF[\'site_url\']          = \'' . $old_site_url . '\'', '$_CONF[\'site_url\']          = \'' . $site_url . '\'', $config_data ); // Set site_url
                        $config_data = str_replace( '$_CONF[\'site_admin_url\']    = $_CONF[\'site_url\'] . \'' . $old_site_admin_url . '\'', '$_CONF[\'site_admin_url\']    = $_CONF[\'site_url\'] . \'' . $site_admin_url . '\'', $config_data ); // Set site_admin_url
                        $config_data = str_replace( '$_CONF[\'site_mail\']          = \'' . $old_site_mail . '\'', '$_CONF[\'site_mail\']          = \'' . $site_mail . '\'', $config_data ); // Set site_mail
                        $config_data = str_replace( '$_CONF[\'noreply_mail\']         = \'' . $old_noreply_mail . '\'', '$_CONF[\'noreply_mail\']         = \'' . $noreply_mail . '\'', $config_data ); // Set site_mail

                        // Write our changes to config.php
                        $config_file = fopen( $config_path, 'w' );
                        if (!fwrite( $config_file, $config_data) ) {
                            exit ( $LANG_INSTALL[26] . ' ' . $config_path . $LANG_INSTALL[58] );
                        }
                        fclose ( $config_file );

                        // Try and find out what the current version of GL is
                        require_once($config_path);
                        require_once($_CONF['path_system'] . 'lib-database.php');
                        $curv = INST_identifyGeeklogVersion ();
                        if ($curv == VERSION) {
                            // If current version is the newest version
                            // then there's no need to update.
                            $display .= '<h2>' . $LANG_INSTALL[74] . '</h2>' . LB
                                      . '<p>' . $LANG_INSTALL[75] . '</p>';
                        } else {

                            $old_versions = array('1.2.5-1','1.3','1.3.1','1.3.2','1.3.2-1','1.3.3','1.3.4','1.3.5','1.3.6','1.3.7','1.3.8','1.3.9','1.3.10','1.3.11','1.4.0','1.4.1');
                            if (empty( $curv )) {
                                // If we were unable to determine the current GL
                                // version is then ask the user what it is
                                $display .= '<h2>' . $LANG_INSTALL[76] . '</h2>
                                    <p>' . $LANG_INSTALL[77] . '</p>
                                    <form action="index.php" method="POST">
                                    <input type="hidden" name="mode" value="upgrade">
                                    <input type="hidden" name="step" value="3">
                                    <input type="hidden" name="config_path" value="' . $config_path . '">
                                    <p><label>Current Version:</label> <select name="version">';
                                $tmp_counter = 0;
                                $ver_selected = '';
                                foreach ($old_versions as $version) {
                                    if ($tmp_counter == (count( $old_versions ) - 1)) {
                                        $ver_selected = ' selected="selected"';
                                    }
                                    $display .= LB . '<option' . $ver_selected . '>' . $version . '</option>';
                                    $tmp_counter++;
                                }
                                $display .= '</select></p>
                                    <br />
                                    <input type="submit" name="submit" class="submit" value="Upgrade &gt;&gt;">
                                    </form>' . LB;

                                $curv = $old_versions[count( $old_versions ) - 1];
                            } else {
                                // Continue on to step 3 where the upgrade will happen
                                $req_string = 'index.php?mode=upgrade&step=3&config_path=' . $config_path . '&version=' . $curv;
                                header( 'Location: ' . $req_string );
                            }
                        }
                    }
                }
                break;


            /**
             * Page 3 - Install
             */
            case 3:

                // Get and set which step to display
                $version = '';
                if (isset( $_GET['version'] )) {
                    $version = $_GET['version'];
                } else {
                    if (isset( $_POST['version'] )) {
                        $version = $_POST['version'];
                    }
                }

                // Let's do this
                require_once( $config_path );
                require_once( $_CONF['path_system'] . 'lib-database.php' );

                // If this is a MySQL database check to see if it was
                // installed with InnoDB support
                if ($_DB_dbms == 'mysql') {
                    // Query `vars` and see if 'database_engine' == 'InnoDB'
                    $result = DB_query( "SELECT `name`,`value` FROM {$_TABLES['vars']} WHERE `name`='database_engine'" );
                    $row = DB_fetchArray( $result );
                    if ($row['value'] == 'InnoDB') {
                       $use_innodb = true;
                    } else {
                       $use_innodb = false;
                    }
                }

                if (INST_doDatabaseUpgrades( $version, $use_innodb )) {
                    // Great, installation is complete
                    // Done with installation...redirect to success page
                    header('Location: success.php?type=upgrade&language=' . $language);
                } else {
                    $display .= '<h2>' . $LANG_INSTALL[78] . '</h2>
                        <p>' . $LANG_INSTALL[79] . '</p>' . LB;
                }

                break;

        } // End switch (Upgrade steps)

        break;

} // end switch (fresh install or upgrade)

$display .= '
    <br /><br />
        </div>
    </div>

</body>
</html>' . LB;

echo $display;

?>
