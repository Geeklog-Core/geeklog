<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog                                                                   |
// +---------------------------------------------------------------------------+
// | devel-db-update.php                                                       |
// |                                                                           |
// | Geeklog Developer Database update page.                                   |
// | Based in part on the glFusion Development SQL Updates.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 20016 by the following authors:                             |
// |                                                                           |
// | Authors: Tom Homer        - tomhomer AT esilverstrike DOT com             |
// |          Mark R. Evans    - mark AT glfusion DOT org                      |
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

/*
Notes:

For New Version Of Geeklog in Development
- Update variables $gl_prev_version and  $gl_devel_version to proper version numbers
- Add new function for database changes (used by core and core plugins) following format of function name "update_DatabaseFor212"
    - Remember to add checks to the script to see if the db change has already happen. We don't want to attempt to do it again as it could cause a SQL error
- New config options are taken automatically from appropriate update file, for example: \sql\updates\mysql_x.x.x_to_x.x.x.php file
- remove any $new_plugin_version = true for Core plugins

For New Version of Geeklog Core Plugin in Development
- Update version number for plugin with the new version found in switch statement for Core plugins below
- Add $new_plugin_version = true to plugin with new version
- Add appropriate database changes including updated version number to update_DatabaseForXXX function
    - Remember to add checks to the script to see if the db change has already happen. We don't want to attempt to do it again as it could cause a SQL error
- New config options are taken automatically from appropriate update file, for example: \plugins\plugin_name\sql\mysql_updates.php

*/

// Since Geeklog 2.2.1 - Should set this now in case Geeklog has issues loading page
define('GL_INSTALL_ACTIVE', true);

require_once '../../lib-common.php';

// For Root users only
if (!SEC_inGroup('Root')) {
    $display = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    if (isset($_USER['username'])) {
        $username = $_USER['username'];
    } else {
        $username = '';
    }
    COM_errorLog("Someone has tried to access the Geeklog Development Database Upgrade Routine without proper permissions.  User id: {$_USER['uid']}, Username: $username, IP: " . $_SERVER['REMOTE_ADDR'],1);
    COM_output($display);
    exit;
}

// Currently, database feature is supported with MySQL only
if ($_DB_dbms !== 'mysql') {
    $display = COM_showMessageText($MESSAGE[31], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    if (isset($_USER['username'])) {
        $username = $_USER['username'];
    } else {
        $username = '';
    }
    COM_errorLog("Someone has tried to access the Geeklog Development Database Upgrade Routine which is not supported by our {$_DB_dbms} database server .  User id: {$_USER['uid']}, Username: $username, IP: " . $_SERVER['REMOTE_ADDR'],1);
    COM_output($display);
    exit;
}

function update_DatabaseFor222()
{
    global $_TABLES, $_CONF, $_PLUGINS, $use_innodb, $_DB_table_prefix, $gl_devel_version;

    // ***************************************
    // Add database Geeklog Core updates here.
    // NOTE: Cannot use ones found in normal upgrade script as no checks are performed to see if already done.


	// Move IP addresses to the new 'ip_addresses' table
	// Check if table exists (Works only for MYSQL)
    $result = DB_query("SHOW TABLES LIKE '{$_TABLES['ip_addresses']}'");
    if ( DB_numRows($result) == 0 ) {
		/* DOES NOT WORK - when lib-common is included above around line 286, the function SESS_sessionCheck is called which requires the IP address. The code for this does not support the older table structure where IPs are stored with the session data and not in its own ip_addresses table
		$geeklog_sqlfile_upgrade = $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.2.1_to_2.2.2.php';
		if (file_exists ($geeklog_sqlfile_upgrade)) {
			require_once($geeklog_sqlfile_upgrade);
			
			update_TablesContainingIPAddresses222();
		}
		*/
	}
	
	// The following entries are no longer defined in 'lib-database.php', so define them here
	$_TABLES['cookiecodes'] = $_DB_table_prefix . 'cookiecodes';
	$_TABLES['dateformats'] = $_DB_table_prefix . 'dateformats';
	$_TABLES['maillist'] = $_DB_table_prefix . 'maillist';
	$_TABLES['usercomment'] = $_DB_table_prefix . 'usercomment';
	$_TABLES['userindex'] = $_DB_table_prefix . 'userindex';
	$_TABLES['userinfo'] = $_DB_table_prefix . 'userinfo';
	$_TABLES['userprefs'] = $_DB_table_prefix . 'userprefs';
	
	// Combine user tables into one and delete old tables
    $result = DB_query("SHOW TABLES LIKE '{$_TABLES['user_attributes']}'");
    if ( DB_numRows($result) == 0 ) {
		/* DOES NOT WORK - when lib-common is included above around line 286, the function SESS_sessionCheck is called which requires user information from a new table that hasn't been created yet or populated with data from old user tables. The code for this does not support the older table structure
		$geeklog_sqlfile_upgrade = $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.2.1_to_2.2.2.php';
		if (file_exists ($geeklog_sqlfile_upgrade)) {
			require_once($geeklog_sqlfile_upgrade);
			
			update_CombineUserTables222();
		}
		*/
	}
	
	// Add missing route into routing table for articles that have page breaks (issue #746)
    if (DB_count($_TABLES['routes'], 'route', '/article/@sid/@page') == 0) {
		$_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid/@page', '/article.php?story=@sid&page=@page', 1000)"; // Priority should default to 120 but we need to mage sure it comes after the route for article print
	}	
	
	// Old VARS table variables for Database Backup that are not used anymore (but could still get created in some cases)
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_files'";
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_gzip'";
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_allstructs'";
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = 'db_backup_interval'";
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_cron'";
	
	// Drop tables
	$_SQL[] = "DROP TABLE {$_TABLES['cookiecodes']}";
	$_SQL[] = "DROP TABLE {$_TABLES['dateformats']}";
	$_SQL[] = "DROP TABLE {$_TABLES['maillist']}";

	// Old VARS table variables for Database Backup that are not used anymore (but could still get created in some cases)
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_files'";
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_gzip'";
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_allstructs'";
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = 'db_backup_interval'";
	$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_cron'";

	// Clean orphan records from Comments and Likes
	// Delete comment edits with no existing comments or users
	$_SQL[] = "DELETE FROM {$_TABLES['commentedits']} ce WHERE cid NOT IN (SELECT cid FROM {$_TABLES['comments']} c WHERE c.cid = ce.cid)";	
	$_SQL[] = "DELETE FROM {$_TABLES['commentedits']} ce WHERE uid NOT IN (SELECT uid FROM {$_TABLES['users']} u WHERE u.uid = ce.uid)";	
	// Delete comment notifications with no existing comments or users
	$_SQL[] = "DELETE FROM {$_TABLES['commentnotifications']} cn WHERE cid NOT IN (SELECT cid FROM {$_TABLES['comments']} c WHERE c.cid = cn.cid)";	
	$_SQL[] = "DELETE FROM {$_TABLES['commentnotifications']} cn WHERE uid NOT IN (SELECT uid FROM {$_TABLES['users']} u WHERE u.uid = cn.uid)";	
	// Delete comment submissions whose parent comment does not exist and with no existing users
	$_SQL[] = "DELETE FROM {$_TABLES['commentsubmissions']} cs WHERE pid != 0 AND pid NOT IN (SELECT cid FROM {$_TABLES['comments']} c WHERE c.cid = cs.pid)";	
	$_SQL[] = "DELETE FROM {$_TABLES['commentsubmissions']} cs WHERE uid NOT IN (SELECT uid FROM {$_TABLES['users']} u WHERE u.uid = cs.uid)";	
	// Delete Comments that type and sid do not exist anymore
	$_SQL[] = "DELETE FROM {$_TABLES['comments']} c WHERE type = 'article' AND sid NOT IN (SELECT sid FROM {$_TABLES['stories']} s WHERE c.sid = s.sid)";
	$_SQL[] = "DELETE FROM {$_TABLES['comments']} c WHERE type = 'staticpages' AND sid NOT IN (SELECT sid FROM {$_TABLES['staticpage']} s WHERE c.sid = s.sp_id)";
	$_SQL[] = "DELETE FROM {$_TABLES['comments']} c WHERE type = 'polls' AND sid NOT IN (SELECT sid FROM {$_TABLES['polltopics']} pt WHERE c.sid = pt.pid)";
	// Set any likes missing user accounts to anonymous
	$_SQL[] = "UPDATE {$_TABLES['likes']} l SET uid = 1 WHERE uid NOT IN (SELECT uid FROM {$_TABLES['users']} u WHERE u.uid = l.uid)";	
	// Delete likes that type and id do not exist anymore
	$_SQL[] = "DELETE FROM {$_TABLES['likes']} l WHERE type = 'comment' AND id NOT IN (SELECT cid FROM {$_TABLES['comments']} s WHERE c.cid = l.id)";	
	$_SQL[] = "DELETE FROM {$_TABLES['likes']} l WHERE type = 'article' AND id NOT IN (SELECT sid FROM {$_TABLES['stories']} s WHERE s.sid = l.id)";		

    // ***************************************
    // Core Plugin Updates Here (including version update)

    // ReCaptcha
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.2.2', pi_gl_version='". VERSION ."', pi_homepage='https://github.com/Geeklog-Plugins/recaptcha' WHERE pi_name='recaptcha'";

    if ($use_innodb) {
        $statements = count($_SQL);
        for ($i = 0; $i < $statements; $i++) {
            $_SQL[$i] = str_replace('MyISAM', 'InnoDB', $_SQL[$i]);
        }
    }

    foreach ($_SQL as $sql) {
        DB_query($sql,1);
    }

    // update Geeklog version number
    DB_query("INSERT INTO {$_TABLES['vars']} SET value='$gl_devel_version',name='database_version'",1);
    DB_query("UPDATE {$_TABLES['vars']} SET value='$gl_devel_version' WHERE name='database_version'",1);

    return true;
}


function update_DatabaseFor221()
{
    global $_TABLES, $_CONF, $_PLUGINS, $use_innodb, $_DB_table_prefix, $gl_devel_version;

    // ***************************************
    // Add database Geeklog Core updates here.
    // NOTE: Cannot use ones found in normal upgrade script as no checks are performed to see if already done.

    // *************************************
    // Fix Group Assignments from Geeklog Install

    // Remove Admin User (2) from all default groups assignments from the install except Root (1), All Users (2), Logged-In Users (13)
    $_SQL[] = "DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_main_grp_id != 1 AND ug_main_grp_id != 2 AND ug_main_grp_id != 13) AND ug_uid = 2 AND ug_grp_id IS NULL";

    // Remove All Users (2) from any other group (should be just for users)
    $_SQL[] = "DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 2 AND ug_uid IS NULL AND ug_grp_id > 0";
    // Remove Root Group (1) from All Users Group (2) (which all users already belong too)
    $_SQL[] = "DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 2 AND ug_uid IS NULL AND ug_grp_id = 1";
    // *************************************

    // Remove unused Vars table record (originally inserted by devel-db-update script on previous version upgrades)
    $_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = 'geeklog'";

    // Add structured data type to article table and modified date
    $_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `structured_data_type` varchar(40) NOT NULL DEFAULT '' AFTER `commentcode`";
    $_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `modified` DATETIME NULL DEFAULT NULL AFTER `date`";
    // For number of pages in an article. Needed for when article is cached and we need to figure out what page to put the comments on
    $_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `numpages` tinyint(1) NOT NULL DEFAULT '1' AFTER `hits`";

    if (DB_count($_TABLES['features'], 'ft_name', 'structureddata.autotag') == 0) {
        // Add `structureddata.autotag` feature
        $sql = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('structureddata.autotag', 'Can use the Structured Data Autotag', 1)";
        DB_query($sql, 1);
        $featureId = DB_insertId();
        $storyAdminId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Story Admin' ");
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureId}, {$storyAdminId}) ");
    }

    // New Likes System table
    $_SQL[] = "
    CREATE TABLE IF NOT EXISTS {$_TABLES['likes']} (
      lid INT(11) NOT NULL AUTO_INCREMENT,
      type varchar(30) NOT NULL,
      subtype varchar(15) NOT NULL DEFAULT '',
      id varchar(128) NOT NULL,
      uid MEDIUMINT NOT NULL,
      ipaddress VARCHAR(39) NOT NULL,
      action TINYINT NOT NULL,
      created DATETIME NOT NULL,
      PRIMARY KEY (lid),
      KEY `type` (`type`,`subtype`,`id`),
      KEY `type_2` (`type`,`id`)
    ) ENGINE=MyISAM
    ";
    // used to fix earlier betas where subtype was 30
    $_SQL[] = "ALTER TABLE {$_TABLES['likes']} ADD `subtype` VARCHAR(15) NOT NULL DEFAULT '' AFTER `type`";

    // Add subtype column to topic assignments table to allow plugins to have topics specified for types of objects
    // Note: Subtype kept at 15 chars as max key length is approaching 1000 bytes for the primary key (for our minimum MySQL server requirements)
    $_SQL[] = "ALTER TABLE {$_TABLES['topic_assignments']} ADD `subtype` VARCHAR(15) NOT NULL DEFAULT '' AFTER `type`";
    $_SQL[] = "
    ALTER TABLE {$_TABLES['topic_assignments']}
      DROP PRIMARY KEY,
       ADD PRIMARY KEY(
         `tid`,
         `type`,
         `subtype`,
         `id`);
    ";
    // Other Keys needed to speed up SQL for items that do not use subtype
    $_SQL[] = "ALTER TABLE `gl_topic_assignments` ADD INDEX( `tid`, `type`, `id`)";
    $_SQL[] = "ALTER TABLE `gl_topic_assignments` ADD INDEX( `type`, `subtype`, `id`)";
    $_SQL[] = "ALTER TABLE `gl_topic_assignments` ADD INDEX( `type`, `id`)";

    // Modify `sessions` table
    $_SQL[] = "DELETE FROM {$_TABLES['sessions']}";
    $_SQL[] = "ALTER TABLE {$_TABLES['sessions']} MODIFY `sess_id` VARCHAR(250) NOT NULL default ''";
    $_SQL[] = "ALTER TABLE {$_TABLES['sessions']} DROP COLUMN `md5_sess_id`";
    $_SQL[] = "ALTER TABLE {$_TABLES['sessions']} DROP COLUMN `topic`";

    // Add `autologin_key` column to `sessions' table
    $_SQL[] = "ALTER TABLE {$_TABLES['users']} DROP COLUMN `autologin_key`"; // this was added and then taken away so make sure gone
    $_SQL[] = "ALTER TABLE {$_TABLES['sessions']} DROP COLUMN `autologin_key`"; // this was added and then taken away so make sure gone
    $_SQL[] = "ALTER TABLE {$_TABLES['sessions']} ADD COLUMN autologin_key_hash VARCHAR(190) NOT NULL DEFAULT ''";

    // Add `postmode` column to `users' table
    $_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD `postmode` VARCHAR(10) NOT NULL DEFAULT 'plaintext'";

    // Add user autologin table
    $_SQL[] = "
    CREATE TABLE IF NOT EXISTS {$_TABLES['userautologin']} (
      autologin_key_hash VARCHAR(190) NOT NULL DEFAULT '',
      expiry_time INT(10) unsigned NOT NULL DEFAULT '0',
      uid MEDIUMINT(8) NOT NULL,
      PRIMARY KEY  (autologin_key_hash),
      KEY expiry_time (expiry_time),
      KEY uid (uid)
    ) ENGINE=MyISAM
    ";

    // ***************************************
    // Core Plugin Updates Here (including version update)

    // Staticpages
    // Add column for structured data
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD `structured_data_type` varchar(40) NOT NULL DEFAULT '' AFTER `commentcode`";
    // Give "structureddata.autotag" feature to Static Page Admin
    $featureId = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'structureddata.autotag' ");
    $staticPageAdminId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin' ");
    if (DB_count($_TABLES['access'], array('acc_ft_id', 'acc_grp_id'), array($featureId, $staticPageAdminId)) == 0) {
        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureId}, {$staticPageAdminId}) ");
    }
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD page_data TEXT NOT NULL DEFAULT '' AFTER sp_content";
    $plugin_install_updates_file = $_CONF['path'] . 'plugins/staticpages/install_updates.php';
    if (file_exists($plugin_install_updates_file)) {
        require_once $plugin_install_updates_file;
        staticpages_update_search_cache_1_7_1();
    }
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.7.1', pi_gl_version='". VERSION ."' WHERE pi_name='staticpages'";

    // SpamX
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.3.6' WHERE pi_name='spamx'";

    // Links
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.1.7' WHERE pi_name='links'";

    // Polls
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.2.0' WHERE pi_name='polls'";

    // Calendar
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.1.8', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='calendar'";

    // XMLSiteMap
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.0.2', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='xmlsitemap'";

    // ReCaptcha
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.2.1', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='recaptcha'";

    if ($use_innodb) {
        $statements = count($_SQL);
        for ($i = 0; $i < $statements; $i++) {
            $_SQL[$i] = str_replace('MyISAM', 'InnoDB', $_SQL[$i]);
        }
    }

    foreach ($_SQL as $sql) {
        DB_query($sql,1);
    }

    // update Geeklog version number
    DB_query("INSERT INTO {$_TABLES['vars']} SET value='$gl_devel_version',name='database_version'",1);
    DB_query("UPDATE {$_TABLES['vars']} SET value='$gl_devel_version' WHERE name='database_version'",1);

    return true;
}

function update_DatabaseFor220()
{
    global $_TABLES, $_CONF, $_PLUGINS, $use_innodb, $_DB_table_prefix, $gl_devel_version;

    // ***************************************
    // Add database Geeklog Core updates here.
    // NOTE: Cannot use ones found in normal upgrade script as no checks are performed to see if already done.

    // Add `meta_description` and `meta_keywords` columns to the `storysubmission` table
    $_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD `meta_description` TEXT NULL AFTER `postmode`";
    $_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD `meta_keywords` TEXT NULL AFTER `meta_description`";

    // Add `status_code` and `enabled` column to the `routes` table
    $_SQL[] = "ALTER TABLE {$_TABLES['routes']} ADD `status_code` INT(11) NOT NULL DEFAULT 200 AFTER `route`";
    $_SQL[] = "ALTER TABLE {$_TABLES['routes']} ADD `enabled` tinyint(1) unsigned NOT NULL default '1' AFTER `priority`";
    // Add new topic routes
    // Add theme admin
    $result = DB_query("SELECT * FROM {$_TABLES['routes']} WHERE rule='/topic/@topic'");
    if ( DB_numRows($result) == 0 ) {
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/topic/@topic', '/index.php?topic=@topic', 160)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/topic/@topic/@page', '/index.php?topic=@topic&page=@page', 170)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/page/@page/print', '/staticpages/index.php?page=@page&disp_mode=print', 180)";
    }

    // Add `css_id` and `css_classes` columns to the `blocks` table
    $_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD `css_id` VARCHAR(255) NOT NULL DEFAULT '' AFTER `help`";
    $_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD `css_classes` VARCHAR(255) NOT NULL DEFAULT '' AFTER `css_id`";
    // Add column to enable/disable convert newlines for normal blocks
    $_SQL[] = "ALTER TABLE `{$_TABLES['blocks']}` ADD `convert_newlines` tinyint(1) unsigned NOT NULL DEFAULT '0' AFTER `allow_autotags`";
    // Add column to enable blocks appearing in other locations
    $_SQL[] = "ALTER TABLE `{$_TABLES['blocks']}` ADD `location` VARCHAR(48) NOT NULL DEFAULT '' AFTER `onleft`";

    // Drop small, read-only tables
    $_SQL[] = "DROP TABLE {$_TABLES['commentcodes']}";
    $_SQL[] = "DROP TABLE {$_TABLES['commentmodes']}";
    $_SQL[] = "DROP TABLE {$_TABLES['featurecodes']}";
    $_SQL[] = "DROP TABLE {$_TABLES['frontpagecodes']}";
    $_SQL[] = "DROP TABLE {$_TABLES['postmodes']}";
    $_SQL[] = "DROP TABLE {$_TABLES['sortcodes']}";
    $_SQL[] = "DROP TABLE {$_TABLES['statuscodes']}";
    $_SQL[] = "DROP TABLE {$_TABLES['trackbackcodes']}";

    // Add columns to track invalid user login attempts
    $_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `invalidlogins` SMALLINT NOT NULL DEFAULT '0' AFTER `num_reminders`";
    $_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `lastinvalid` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `invalidlogins`";

    // Add columns for two factor authentication
    $_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `twofactorauth_enabled` TINYINT(3) NOT NULL DEFAULT 0 AFTER `lastinvalid`";
    $_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `twofactorauth_secret` VARCHAR(255) NOT NULL DEFAULT '' AFTER `twofactorauth_enabled`";

    // Add a table to store backup codes for two factor authentication
    $_SQL[] = "
    CREATE TABLE IF NOT EXISTS {$_TABLES['backup_codes']} (
      code VARCHAR(16) NOT NULL UNIQUE,
      uid MEDIUMINT(8) NOT NULL DEFAULT 0,
      is_used TINYINT(1) NOT NULL DEFAULT 0,
      PRIMARY KEY (code)
    ) ENGINE=MyISAM
    ";

    // Add column to confirm new email address
    $_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `emailconfirmid` VARCHAR(16) NULL DEFAULT NULL AFTER `pwrequestid`";
    $_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `emailtoconfirm` VARCHAR(96) NULL DEFAULT NULL AFTER `emailconfirmid`";

    // Fix for password request id getting set to a string with the word "NULL" instead of actually NULL
    $_SQL[] = "UPDATE `{$_TABLES['users']}` SET pwrequestid = NULL WHERE pwrequestid = 'NULL'";

    // Add column for Topic Title
    $_SQL[] = "ALTER TABLE `{$_TABLES['topics']}` ADD `title` VARCHAR(128) NULL DEFAULT NULL AFTER `topic`";

    // Make sure any lastlogin in user info table that equals '' or NULL is 0
    $_SQL[] = "UPDATE `{$_TABLES['userinfo']}` SET `lastlogin` = '0' WHERE `lastlogin` = '' OR `lastlogin` IS NULL;";
    // Make sure User Info Last Login defaults to 0
    $_SQL[] = "ALTER TABLE `{$_TABLES['userinfo']}` CHANGE `lastlogin` `lastlogin` VARCHAR(10) NOT NULL DEFAULT '0';";

    // Add theme admin
    $result = DB_query("SELECT * FROM {$_TABLES['groups']} WHERE grp_name='Theme Admin'");
    if ( DB_numRows($result) == 0 ) {
        $sql1 = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) "
            . "VALUES (NULL, 'Theme Admin', 'Has full access to themes', 1)";
        $sql2 = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_grp_id) VALUES (%d, %d)";
        $sql3 = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) "
            . "VALUES (NULL, 'theme.edit', 'Access to theme settings', 1)";
        $sql4 = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (%d, %d)";

        try {
            DB_beginTransaction();

            // Add Theme Admin to groups
            if (!DB_query($sql1)) {
                throw new \Exception(DB_error());
            }

            // Add Root group to Theme Admin group
            $themeAdminGroupId = DB_insertId();
            $rootGroupId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
            $sql2 = sprintf($sql2, $themeAdminGroupId, $rootGroupId);
            if (!DB_query($sql2)) {
                throw new \Exception(DB_error());
            }

            // Add theme.edit feature
            if (!DB_query($sql3)) {
                throw new \Exception(DB_error());
            }

            // Assign theme.edit feature to Theme Admin
            $themeAdminFeatureId = DB_insertId();
            $sql4 = sprintf($sql4, $themeAdminFeatureId, $themeAdminGroupId);
            if (!DB_query($sql4)) {
                throw new \Exception(DB_error());
            }

            DB_commit();
        } catch (\Exception $e) {
            DB_rollBack();
        }
    }

    // ***************************************
    // Core Plugin Updates Here

    // Staticpages
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD `sp_prev` VARCHAR(128) NOT NULL DEFAULT '' AFTER `postmode`";
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD `sp_next` VARCHAR(128) NOT NULL DEFAULT '' AFTER `sp_prev`";
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD `sp_parent` VARCHAR(128) NOT NULL DEFAULT '' AFTER `sp_next`";
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.7.0', pi_gl_version='". VERSION ."' WHERE pi_name='staticpages'";


    // SpamX
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.3.5' WHERE pi_name='spamx'";


    // Links
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.1.6' WHERE pi_name='links'";


    // Polls
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.1.9' WHERE pi_name='polls'";

    // XMLSiteMap
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.0.1', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='xmlsitemap'";

    // Calendar
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.1.6', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='calendar'";



    if ($use_innodb) {
        $statements = count($_SQL);
        for ($i = 0; $i < $statements; $i++) {
            $_SQL[$i] = str_replace('MyISAM', 'InnoDB', $_SQL[$i]);
        }
    }

    foreach ($_SQL as $sql) {
        DB_query($sql,1);
    }

    // update Geeklog version number
    DB_query("INSERT INTO {$_TABLES['vars']} SET value='$gl_devel_version',name='geeklog'",1);
    DB_query("UPDATE {$_TABLES['vars']} SET value='$gl_devel_version' WHERE name='geeklog'",1);

    return true;
}

function update_DatabaseFor213()
{
    global $_TABLES, $_CONF, $_PLUGINS, $use_innodb, $_DB_table_prefix, $gl_devel_version;

    // ***************************************
    // Add database Geeklog Core updates here.
    // NOTE: Cannot use ones found in normal upgrade script as no checks are performed to see if already done.





    // ***************************************
    // Core Plugin Updates Here

    // Staticpages
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.6.9', pi_gl_version='". VERSION ."' WHERE pi_name='staticpages'";


    // SpamX
    $_SQL[] = "ALTER TABLE {$_TABLES['spamx']} DROP PRIMARY KEY";
    $_SQL[] = "ALTER TABLE {$_TABLES['spamx']} MODIFY COLUMN `value` VARCHAR(191)";
    $_SQL[] = "ALTER TABLE {$_TABLES['spamx']} ADD PRIMARY KEY (name, value)";
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.3.4' WHERE pi_name='spamx'";


    // Links
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.1.5' WHERE pi_name='links'";


    // Polls
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.1.8' WHERE pi_name='polls'";




    if ($use_innodb) {
        $statements = count($_SQL);
        for ($i = 0; $i < $statements; $i++) {
            $_SQL[$i] = str_replace('MyISAM', 'InnoDB', $_SQL[$i]);
        }
    }

    foreach ($_SQL as $sql) {
        DB_query($sql,1);
    }

    // update Geeklog version number
    DB_query("INSERT INTO {$_TABLES['vars']} SET value='$gl_devel_version',name='geeklog'",1);
    DB_query("UPDATE {$_TABLES['vars']} SET value='$gl_devel_version' WHERE name='geeklog'",1);

    return true;
}

function update_DatabaseFor212()
{
    global $_TABLES, $_CONF, $_PLUGINS, $use_innodb, $_DB_table_prefix, $gl_devel_version;

    // ***************************************
    // Add database Geeklog Core updates here.
    // NOTE: Cannot use ones found in normal upgrade script as no checks are performed to see if already done.

    // Modify DATETIME columns with '0000-00-00 00:00:00' being the default value to DATETIME DEFAULT NULL
    // to make Geeklog compatible with MySQL-5.7 with NO_ZERO_DATE in sql_mode
    $_SQL[] = "ALTER TABLE {$_TABLES['blocks']} MODIFY COLUMN `rdfupdated` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['stories']} MODIFY COLUMN `comment_expire` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['stories']} MODIFY COLUMN `expire` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['syndication']} MODIFY COLUMN `updated` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['users']} MODIFY COLUMN `regdate` DATETIME DEFAULT NULL";

    // Add device type to blocks table
    $_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD `device` VARCHAR( 15 ) NOT NULL DEFAULT 'all' AFTER `blockorder`";

    // Check for language group
    $result = DB_query("SELECT * FROM {$_TABLES['groups']} WHERE grp_name='Language Admin'");
    if ( DB_numRows($result) == 0 ) {
        // Add `language_items` table
        $_SQL[] = "
        CREATE TABLE IF NOT EXISTS {$_TABLES['language_items']} (
          id INT(11) NOT NULL AUTO_INCREMENT,
          var_name VARCHAR(30) NOT NULL,
          language VARCHAR(30) NOT NULL,
          name VARCHAR(30) NOT NULL,
          value VARCHAR(255) NOT NULL DEFAULT '',
          PRIMARY KEY (id)
        ) ENGINE=MyISAM
        ";

        // Add `Language Admin` group
        $_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (18, 'Language Admin', 'Has full access to language', 1);";

        // Add `language.edit` feature
        $_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (68, 'language.edit', 'Can manage Language Settings', 1)";

        // Give `language.edit` feature to `Language Admin` group
        $_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (68,18) ";
    }

    // Check for language group
    $result = DB_query("SELECT * FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 18 AND ug_grp_id = 1");
    if ( DB_numRows($result) == 0 ) {
        // Add Root users to `Language Admin`
        $_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (18,NULL,1) ";

        // Add 'Routes' table
        $_SQL[] = "CREATE TABLE IF NOT EXISTS {$_TABLES['routes']} (
            rid INT(11) NOT NULL AUTO_INCREMENT,
            method INT(11) NOT NULL DEFAULT 1,
            rule VARCHAR(255) NOT NULL DEFAULT '',
            route VARCHAR(255) NOT NULL DEFAULT '',
            priority INT(11) NOT NULL DEFAULT 100,
            PRIMARY KEY (rid)
        ) ENGINE=MyISAM
        ";

        // Add sample routes
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid/print', '/article.php?story=@sid&mode=print', 100)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid', '/article.php?story=@sid', 110)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/archives/@topic/@year/@month', '/directory.php?topic=@topic&year=@year&month=@month', 120)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/page/@page', '/staticpages/index.php?page=@page', 130)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/links/portal/@item', '/links/portal.php?what=link&item=@item', 140)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/links/category/@cat', '/links/index.php?category=@cat', 150)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/topic/@topic', '/index.php?topic=@topic', 160)";
    }

    // Change Topic Id (and Name) from 128 to 75 since we have an issue with the primary key on the topic_assignments table since it has too many bytes for tables with a utf8mb4 collation
    $_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE `tid` `tid` VARCHAR(75) NOT NULL default ''";
    $_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE `topic` `topic` VARCHAR(75) NOT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['topic_assignments']} CHANGE `tid` `tid` VARCHAR(75) NOT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['sessions']} CHANGE `topic` `topic` VARCHAR(75) NOT NULL default ''";
    $_SQL[] = "ALTER TABLE {$_TABLES['syndication']} CHANGE `topic` `topic` VARCHAR(75) NOT NULL default '::all'";
    $_SQL[] = "ALTER TABLE {$_TABLES['syndication']} CHANGE `header_tid` `header_tid` VARCHAR(75) NOT NULL default 'none'";

    // Change Url from 255 to 250 since the field has too many bytes for tables with a utf8mb4 collation
    $_SQL[] = "ALTER TABLE {$_TABLES['trackback']} CHANGE `url` `url` VARCHAR(250) DEFAULT NULL";

    // Change the type of `value' column of `vars` table from VARCHAR(128) to TEXT
    $_SQL[] = "ALTER TABLE {$_TABLES['vars']} CHANGE `value` `value` text NULL AFTER `name`";


    // ***************************************
    // Core Plugin Updates Here

    // Staticpages
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} MODIFY COLUMN `created` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} MODIFY COLUMN `modified` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD `sp_onhits` TINYINT NOT NULL DEFAULT '1' AFTER `sp_onmenu`";
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD `sp_onlastupdate` TINYINT NOT NULL DEFAULT '1' AFTER `sp_onhits`";
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.6.8', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='staticpages'";

    // SpamX
    $_SQL[] = "ALTER TABLE {$_TABLES['spamx']} MODIFY COLUMN regdate DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['spamx']} DROP PRIMARY KEY";
    $_SQL[] = "DROP INDEX `spamx_name` ON {$_TABLES['spamx']}";
    $_SQL[] = "ALTER TABLE {$_TABLES['spamx']} ADD PRIMARY KEY (name)";
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.3.3', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='spamx'";

    // Links
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.1.6', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='links'";

    // Polls
    $_SQL[] = "ALTER TABLE {$_TABLES['pollquestions']} ADD `allow_multipleanswers` TINYINT(1) NULL DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['pollquestions']} ADD `description` MEDIUMTEXT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['polltopics']} ADD `description` MEDIUMTEXT NULL";
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.1.7', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='polls'";

    // Calendar
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.1.6', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='calendar'";

    // XMLSiteMap
    // $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.0.0', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='xmlsitemap'";


    if ($use_innodb) {
        $statements = count($_SQL);
        for ($i = 0; $i < $statements; $i++) {
            $_SQL[$i] = str_replace('MyISAM', 'InnoDB', $_SQL[$i]);
        }
    }

    foreach ($_SQL as $sql) {
        DB_query($sql,1);
    }

    // update Geeklog version number
    DB_query("INSERT INTO {$_TABLES['vars']} SET value='$gl_devel_version',name='geeklog'",1);
    DB_query("UPDATE {$_TABLES['vars']} SET value='$gl_devel_version' WHERE name='geeklog'",1);

    return true;
}

$display = '<h2>Development Database Update</h2>';

$gl_prev_version = "2.2.1";
$gl_devel_version = "2.2.2";

$display .= "<p>This update is for Geeklog Core and Core Plugins. Can include changes to database structure and data, along with configuration options. All Core plugins must be installed when you run this script.</p>
             <p>Update works for Geeklog $gl_prev_version up to latest Geeklog development version for $gl_devel_version.</p>";


// ***************************************
// Geeklog Core Updates
$display .= '<ul><li>Performing Geeklog Core configuration upgrades if necessary...<ul><li>';


$geeklog_sqlfile_upgrade = $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_' . $gl_prev_version . '_to_' . $gl_devel_version . '.php';
if (file_exists ($geeklog_sqlfile_upgrade)) {
    require_once($geeklog_sqlfile_upgrade);
}

$short_version = str_replace(".","", $gl_devel_version);
$function = 'update_ConfValuesFor' . $short_version;
if (function_exists($function)) {
    if ($function()) {
        $display .= 'Configuration settings updated successfully.';
    } else {
        $display .= 'There was problems updating the configuration settings.';
    }
} else {
    $display .= 'No configuration settings found to update.';
}
$display .= '</li></ul>';

// Reset rest of config
//resetConfig();

// ***************************************
// Geeklog Core Plugins
$display .= '<li>Performing Geeklog Core Plugin configuration upgrades if necessary...<ul>';
// Loop through core plugin config updates
$corePlugins = array('staticpages','spamx','links','polls','calendar', 'xmlsitemap', 'recaptcha');
foreach ($corePlugins AS $pi_name) {
    $new_plugin_version = false;
    switch ($pi_name) {
        case 'staticpages':
            $new_plugin_version = true;
            $plugin_version = '1.7.3'; // Current Geeklog v2.2.2 for plugin
            break;
        case 'spamx':
            $new_plugin_version = false;
            $plugin_version = '1.3.6'; // Current Geeklog v2.2.1 for plugin
            break;
        case 'links':
            $new_plugin_version = true;
            $plugin_version = '2.1.8'; // Current Geeklog v2.2.2 for plugin
            break;
        case 'polls':
            $new_plugin_version = true;
            $plugin_version = '2.2.1'; // Current Geeklog v2.2.2 for plugin
            break;
        case 'calendar':
            $new_plugin_version = true;
            $plugin_version = '1.1.9'; // Current Geeklog v2.2.2 for plugin
            break;
        case 'xmlsitemap':
            $new_plugin_version = true;
            $plugin_version = '2.0.3'; // Current Geeklog v2.2.2 for plugin
            break;
        case 'recaptcha':
            $new_plugin_version = true;
            $plugin_version = '1.2.4'; // Current Geeklog v2.2.2 for plugin
            break;
    }

    $display .= "<li>";
    if ($new_plugin_version) {
        $plugin_install_updates_file = $_CONF['path'] . 'plugins/' . $pi_name . '/install_updates.php';
        if (file_exists($plugin_install_updates_file)) {
            require_once $plugin_install_updates_file;

            $function = $pi_name . '_update_ConfValues_' . str_replace(".","_", $plugin_version);

            if (function_exists($function)) {
                if ($function()) {;
                    $display .= "Configuration settings updated successfully for $pi_name plugin.";
                } else {
                    $display .= "There was problems updating the configuration settings for $pi_name plugin.";
                }
            } else {
                $display .= "No configuration settings found for updating $pi_name plugin.";
            }
        } else {
            $display .= "No configuration settings found for updating $pi_name plugin.";
        }
    } else {
        $display .= "No new version found for $pi_name plugin.";
    }
    $display .= "</li>";
}
$display .= "</ul></li>";

$display .= '<li>Performing Geeklog Core and Geeklog Core Plugin database upgrades if necessary...<ul><li>';

// InnoDB?
$use_innodb = false;
if (($_DB_dbms == 'mysql') && (DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'") == 'InnoDB')) {
    $use_innodb = true;
}

$function = 'update_DatabaseFor' . $short_version;
if (function_exists($function)) {
    if ($function()) {;
        $display .= 'Database updated successfully.';
    } else {
        $display .= 'There was problems updating the database settings.';
    }
} else {
    $display .= 'No database settings found to updated.';
}
$display .= "</li></ul></li></ul>";

foreach ($corePlugins AS $pi_name) {
    DB_query("UPDATE {$_TABLES['plugins']} SET pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='".$pi_name."'",1);
}

// ***************************************
// need to clear the template cache so do it here
CTL_clearCache();

$display .= '<p>The Geeklog Core Development Database Update has completed.</p>
             <p>Please visit the <a href="' . $_CONF['site_admin_url'] . '/plugins.php">Plugin Admin page</a> and validate if any other plugins needs to be updated.</p>';

$display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[40]));
COM_output($display);

exit;
?>
