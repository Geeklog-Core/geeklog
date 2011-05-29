<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | lib-upgrade.php                                                           |
// |                                                                           |
// | Functions needed to perform a database update.                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Matt West         - matt.danger.west AT gmail DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
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


/**
 * Perform database upgrades
 *
 * @param   string  $current_gl_version Current Geeklog version
 * @return  boolean                     True if successful
 *
 */
function INST_doDatabaseUpgrades($current_gl_version)
{
    global $_TABLES, $_CONF, $_SP_CONF, $_DB, $_DB_dbms, $_DB_table_prefix,
           $dbconfig_path, $siteconfig_path, $html_path;

    $_DB->setDisplayError(true);

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
                require $tmp_path . 'config.php';

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

            // core plugin updates are done in the plugins themselves

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
            // there were no core database changes in 1.5.2
            $current_gl_version = '1.5.2';
            $_SQL = '';
            break;

        case '1.5.2':
            require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.5.2_to_1.6.0.php';
            INST_updateDB($_SQL);

            update_ConfValues();
            upgrade_addNewPermissions();
            upgrade_addIsoFormat();

            INST_fixOptionalConfig();

            $current_gl_version = '1.6.0';
            $_SQL = '';
            break;

        case '1.6.0':
            require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.6.0_to_1.6.1.php';
            INST_updateDB($_SQL);

            update_ConfValuesFor161();

            $current_gl_version = '1.6.1';
            $_SQL = '';
            break;

        case '1.6.1':
            require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.6.1_to_1.7.0.php';
            INST_updateDB($_SQL);

            update_ConfValuesFor170();

            $current_gl_version = '1.7.0';
            $_SQL = '';
            break;

        case '1.7.0':
            $current_gl_version = '1.7.2'; // skip ahead
            $_SQL = '';
            break;

        case '1.7.1':
            // there were no database changes in 1.7.1
        case '1.7.2':
            require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.7.2_to_1.8.0.php';
            INST_updateDB($_SQL);

            update_ConfValuesFor180();

            update_ConfigSecurityFor180();
            
            update_UsersFor180();

            $current_gl_version = '1.8.0';
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

    return true;
}


/**
 * Get the current installed version of Geeklog
 *
 * @return  string  Geeklog version in x.x.x format
 *
 */
function INST_identifyGeeklogVersion()
{
    global $_TABLES, $_DB, $_DB_dbms;

    $_DB->setDisplayError(true);

    $version = '';

    /**
    * First check for 'database_version' in gl_vars. If that exists, assume
    * it's the correct version. Else, try some heuristics (below).
    * Note: Need to handle 'sr1' etc. appendices.
    */
    $db_v = DB_getItem($_TABLES['vars'], 'value', "name = 'database_version'");
    if (! empty($db_v)) {
        $v = explode('.', $db_v);
        if (count($v) == 3) {
            $v[2] = (int) $v[2];
            $version = implode('.', $v);

            return $version;
        }
    }


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
            // as of 1.5.1, we should have the 'database_version' entry
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
            // as of 1.5.1, we should have the 'database_version' entry
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
* Change default character set to UTF-8
*
* NOTE:    Yes, this means that we need to patch siteconfig.php a second time.
*
* @param   string   $siteconfig_path  complete path to siteconfig.php
* @param   string   $charset          default character set to use
* @return  boolean                    true: success; false: an error occured
*
*/
function INST_setDefaultCharset($siteconfig_path, $charset)
{
    $result = true;

    clearstatcache();
    $siteconfig_file = fopen($siteconfig_path, 'rb');
    $siteconfig_data = fread($siteconfig_file, filesize($siteconfig_path));
    fclose($siteconfig_file);

    $siteconfig_data = preg_replace
            (
             '/\$_CONF\[\'default_charset\'\] = \'[^\']*\';/',
             "\$_CONF['default_charset'] = '" . $charset . "';",
             $siteconfig_data
            );

    $siteconfig_file = fopen($siteconfig_path, 'wb');
    if (!fwrite($siteconfig_file, $siteconfig_data)) {
        $result = false;
    }
    @fclose($siteconfig_file);

    return $result;
}



/**
* Checks for Static Pages Version
*
* Note: Needed for upgrades from old versions - don't remove.
*
* @return int indicates which version of the plugin we're dealing with:
*             - 0 = not installed,
*             - 1 = original plugin,
*             - 2 = version by Phill or Tom,
*             - 3 = v1.3 (center block, etc.),
*             - 4 = v1.4 ('in block' flag)
*
*/
function get_SP_ver()
{
    global $_TABLES;

    $retval = 0;

    if (DB_count($_TABLES['plugins'], 'pi_name', 'staticpages') > 0) {
        $result = DB_query("DESCRIBE {$_TABLES['staticpage']}");
        $numrows = DB_numRows($result);

        $retval = 1; // assume v1.1 for now ...

        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray($result, true);
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
* Check if the Spam-X plugin is already installed
*
* Note: Needed for upgrades from old versions - don't remove.
*
* @return   int     1 = is installed, 0 = not installed
*
*/
function get_SPX_Ver()
{
    global $_TABLES;

    $retval = 0;

    if (DB_count($_TABLES['plugins'], 'pi_name', 'spamx') == 1) {
        $retval = 1;
    }

    return $retval;
}

/**
 * Run all the database queries from the update file.
 *
 * @param   array $_SQL   Array of queries to perform
 *
 */
function INST_updateDB($_SQL)
{
    global $progress, $use_innodb, $_DB, $_DB_dbms;

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
 * Check for InnoDB table support (usually as of MySQL 4.0, but may be
 * available in earlier versions, e.g. "Max" or custom builds).
 *
 * @return  boolean     true = InnoDB tables supported, false = not supported
 *
 */
function INST_innodbSupported()
{
    $retval = false;

    $result = DB_query("SHOW TABLE TYPES");
    $numEngines = DB_numRows($result);
    for ($i = 0; $i < $numEngines; $i++) {
        $A = DB_fetchArray($result);

        if (strcasecmp($A['Engine'], 'InnoDB') == 0) {
            if (strcasecmp($A['Support'], 'yes') == 0) {
                $retval = true;
            }
            break;
        }
    }

    return $retval;
}


/**
 * Check if a current plugin is installed
 *
 * @param   string  $plugin     Name of plugin to check
 * @return  boolean             true if plugin exists in db, false otherwise
 *
 */
function INST_pluginExists($plugin)
{
    global $_TABLES;

    $plugin = addslashes($plugin);
    $result = DB_query("SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_name = '$plugin'");
    if (DB_numRows($result) > 0) {
        return true;
    }

    return false;
}


/**
* Upgrade any enabled plugins
*
* NOTE: Needs a fully working Geeklog, so can only be done late in the upgrade
*       process!
*
* @param    boolean $migration  whether the upgrade is part of a site migration
* @param    array   $old_conf   old $_CONF values before the migration
* @return   int     number of failed plugin updates (0 = everything's fine)
* @see      PLG_upgrade
* @see      PLG_migrate
*
*/
function INST_pluginUpgrades($migration = false, $old_conf = array())
{
    global $_CONF, $_TABLES;

    $failed = 0;

    $result = DB_query("SELECT pi_name, pi_version FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
    $numPlugins = DB_numRows($result);

    for ($i = 0; $i < $numPlugins; $i++) {
        list($pi_name, $pi_version) = DB_fetchArray($result);

        $success = true;
        if ($migration) {
            $success = PLG_migrate($pi_name, $old_conf);
        }

        if ($success === true) {
            $code_version = PLG_chkVersion($pi_name);
            if (! empty($code_version) && ($code_version != $pi_version)) {
                $success = PLG_upgrade($pi_name);
            }
        }

        if ($success !== true) {
            // migration or upgrade failed - disable plugin
            DB_change($_TABLES['plugins'], 'pi_enabled', 0,
                                           'pi_name', $pi_name);
            COM_errorLog("Migration or upgrade for '$pi_name' plugin failed - plugin disabled");
            $failed++;
        }
    }

    return $failed;
}

/**
* Pick up and install any new plugins
*
* Search for plugins that exist in the filesystem but are not registered with
* Geeklog. If they support auto install, install them now.
*
* @return void
*
*/
function INST_autoinstallNewPlugins()
{
    global $_CONF, $_TABLES, $_DB_dbms, $_DB_table_prefix;

    $newplugins = array();

    clearstatcache ();
    $plugins_dir = $_CONF['path'] . 'plugins/';
    $fd = opendir($plugins_dir);
    while (($plugin = @readdir($fd)) == TRUE) {

        if (($plugin <> '.') && ($plugin <> '..') && ($plugin <> 'CVS') &&
                (substr($plugin, 0, 1) <> '.') &&
                (substr($plugin, 0, 1) <> '_') &&
                is_dir($plugins_dir . $plugin)) {

            if (DB_count($_TABLES['plugins'], 'pi_name', $plugin) == 0) {

                // found a new plugin: remember name, keep on searching
                $newplugins[] = $plugin;

            }
        }
    }

    // automatically install all new plugins that come with a autoinstall.php
    foreach ($newplugins as $pi_name) {
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

/**
* Make sure optional config options can be disabled
*
* Back when Geeklog used a config.php file, some of the comment options were
* commented out, i.e. they were optional. Make sure those options can still be
* disabled from the Configuration admin panel.
*
* @return void
*
*/
function INST_fixOptionalConfig()
{
    global $_TABLES;

    // list of optional config options
    $optional_config = array(
        'copyrightyear', 'debug_image_upload', 'default_photo',
        'force_photo_width', 'gravatar_rating', 'ip_lookup', 'language_files',
        'languages', 'path_to_mogrify', 'path_to_netpbm'
    );

    foreach ($optional_config as $name) {
        $result = DB_query("SELECT value, default_value FROM {$_TABLES['conf_values']} WHERE name = '$name'");
        list($value, $default_value) = DB_fetchArray($result);
        if ($value != 'unset') {
            if (substr($default_value, 0, 6) != 'unset:') {
                $unset = addslashes('unset:' . $default_value);
                DB_query("UPDATE {$_TABLES['conf_values']} SET default_value = '$unset' WHERE name = '$name'");
            }
        }
    }
}

?>
