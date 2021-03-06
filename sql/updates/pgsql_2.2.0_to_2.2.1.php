<?php

// *************************************
// Fix Group Assignments from Geeklog Install

// Remove Admin User (2) from all default groups assignments from the install except Root (1), All Users (2), Logged-In Users (13)
// Decided to delete all groups except listed above instead of original groups assigned since bug in previous user editor added inherited groups as actual group assignments
$_SQL[] = "DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_main_grp_id != 1 AND ug_main_grp_id != 2 AND ug_main_grp_id != 13) AND ug_uid = 2 AND ug_grp_id IS NULL";
// Remove All Users (2) from any other group (should be just for users)
$_SQL[] = "DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 2 AND ug_uid IS NULL AND ug_grp_id > 0";
// Remove Root Group (1) from All Users Group (2) (which all users already belong too)
$_SQL[] = "DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 2 AND ug_uid IS NULL AND ug_grp_id = 1";
// *************************************

// Remove unused Vars table record (originally inserted by devel-db-update script)
$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = 'geeklog'";

// Add structured data type to article table and modified date
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `structured_data_type` varchar(40) NOT NULL DEFAULT '' AFTER `commentcode`";
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `modified` timestamp default NULL AFTER `date`";
// For number of pages in an article. Needed for when article is cached and we need to figure out what page to put the comments on
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `numpages` tinyint(1) NOT NULL DEFAULT '1' AFTER `hits`";

// Language Override value can now be longer than 255 characters
$_SQL[] = "ALTER TABLE {$_TABLES['language_items']} CHANGE `value` `value` TEXT";

// New Likes System table
$_SQL[] = "
CREATE TABLE {$_TABLES['likes']} (
  lid INT(11) NOT NULL AUTO_INCREMENT,
  type varchar(30) NOT NULL,
  subtype varchar(15) NOT NULL DEFAULT '',
  id varchar(128) NOT NULL,
  uid MEDIUMINT NOT NULL,
  ipaddress VARCHAR(39) NOT NULL,
  action TINYINT NOT NULL,
  created DATETIME NOT NULL,
  PRIMARY KEY (lid)
)
";

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
     `id`)
";
// Other Keys needed to speed up SQL for items that do not use subtype
$_SQL[] = "ALTER TABLE {$_TABLES['topic_assignments']} ADD INDEX( `tid`, `type`, `id`)";
$_SQL[] = "ALTER TABLE {$_TABLES['topic_assignments']} ADD INDEX( `type`, `subtype`, `id`)";
$_SQL[] = "ALTER TABLE {$_TABLES['topic_assignments']} ADD INDEX( `type`, `id`)";

// Modify `sessions` table
$_SQL[] = "DELETE FROM {$_TABLES['sessions']}";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} ALTER COLUMN sess_id TYPE VARCHAR(190) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} DROP COLUMN md5_sess_id";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} DROP COLUMN topic";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} ADD COLUMN autologin_key_hash VARCHAR(190) NOT NULL DEFAULT ''";

// Add `postmode` column to `users' table
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD COLUMN postmode VARCHAR(10) NOT NULL DEFAULT 'plaintext'";

// Add User Autologin table
$_SQL[] = "
CREATE TABLE {$_TABLES['userautologin']} (
  autologin_key_hash VARCHAR(190) NOT NULL DEFAULT '',
  expiry_time int NOT NULL default '0',
  uid smallint NOT NULL default '1',
  PRIMARY KEY (autologin_key_hash)
);
  CREATE INDEX {$_TABLES['userautologin']}_expiry_time ON {$_TABLES['userautologin']} (expiry_time);
  CREATE INDEX {$_TABLES['userautologin']}_uid ON {$_TABLES['userautologin']}(uid);
";

/**
 * Upgrade Messages
 */
function upgrade_message220()
{
    global $_DB_charset;

    // 3 upgrade message types exist 'information', 'warning', 'error'
    // error type means the user cannot continue upgrade until fixed

    // Fix User Security Group assignments for Groups: Root, Admin, All Users
    // Fix User Security Group assignments for Users: Admin
    $upgradeMessages['2.2.0'] = array(
        1 => array('warning', 22, 23),  // Fix User Security Group assignments for Groups: Root, Admin, All Users - Fix User Security Group assignments for Users: Admin
        2 => array('warning', 24, 25),  // FCKEditor removed
        3 => array('warning', 26, 27),  // Google+ OAuth Login switched to Google OAuth Login
        4 => array('warning', 28, 29),   // Fixed spaces around user names and removed duplicate usernames
        5 => array('warning', 30, 31),   // Warning of Submitted Articles may have incorrect group and permissions saved
        6 => array('warning', 32, 33)   // Warning of Static pages that are templates or use PHP must evalute successful or upgrade will fail
    );

    if (empty($_DB_charset)) {
        $upgradeMessages['2.2.0'][7] = array('error', 34, 35); // Error out if $_DB_charset is empty
    }

    return $upgradeMessages;
}

/**
 * Add/Edit/Delete config options for new version
 */
function update_ConfValuesFor221()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';

    // FCKEditor removed so make sure config is not set to use it. If is switch advance editor to CKEditor
    if (isset($_CONF['advanced_editor_name']) && $_CONF['advanced_editor_name'] == 'fckeditor') {
        $c->add('advanced_editor_name','ckeditor','select',4,20,NULL,845,TRUE, $me, 20);
    }

    // Default Structured Data type for new articles
    $c->add('structured_data_type_default','core-article','select',1,7,39,1275,TRUE, $me, 7); // Setting article as the default

	// Structured Data of Articles in Topics
	$c->add('structured_data_article_topic',0,'select',1,7,42,1277,TRUE, $me, 7);

    // Add absolute path for logo image which is used by the Publisher property with Structured Data
    $c->add('path_site_logo','','text',0,0,NULL,65,TRUE, $me, 0);

    // Add switch to enable setting of language id for item if Geeklog Multi Language is setup
    $c->add('new_item_set_current_lang',0,'select',6,28,0,380,TRUE, $me, 28);

    // Add Structured Data Autotag usuage permissions
    $c->add('autotag_permissions_structureddata', array(2, 2, 0, 0), '@select', 7, 41, 28, 1930, TRUE, $me, 37);

    // Add Likes System Tab and config options
    $sg  =  4;      // subgroup
    $fs  = 51;      // fieldset
    $tab = 51;      // tab
    $so  = 1700;    // sort
    $c->add('tab_likes', NULL, 'tab', $sg, $fs, NULL, 0, TRUE, $me, $tab);
    $c->add('fs_likes', NULL, 'fieldset', $sg, $fs, NULL, 0, TRUE, $me, $tab);
    $c->add('likes_enabled',1,'select',$sg,$fs,40,$so,TRUE, $me, $tab);
    $so += 10;
    $c->add('likes_articles',1,'select',$sg,$fs,41,$so,TRUE, $me, $tab);
    $so += 10;
    $c->add('likes_comments',1,'select',$sg,$fs,41,$so,TRUE, $me, $tab);
    $so += 10;
    $c->add('likes_speedlimit',45,'text',$sg,$fs,NULL,$so,TRUE, $me, $tab);
    $so += 10;

    // Delete some cookie-related settings
    $c->del('cookie_password', $me);
    $c->del('cookie_ip', $me);

    // Add cookie consent
    $c->add('cookie_consent',true,'select',0,0,1,2030,true, $me, 0);

    // Change some Filemanager settings
    $c->del('filemanager_upload_restrictions', 'Core');
    $c->del('filemanager_upload_images_only', 'Core');
    $c->del('filemanager_unallowed_files', 'Core');
    $c->del('filemanager_unallowed_dirs', 'Core');
    $c->del('filemanager_unallowed_files_regexp', 'Core');
    $c->del('filemanager_unallowed_dirs_regexp', 'Core');
    $c->set('filemanager_date_format', 'yMMMdHm', 'Core');

    // Add generate user icon option
    $c->add('generate_user_icon',true,'select',5,26,1,1640,true, $me, 26);

    // Add Links to legal Terms and Policies
    $c->add('about_cookies_link','','text',0,0,NULL,2040,TRUE, $me, 0);
    $c->add('terms_of_use_link','','text',0,0,NULL,2050,TRUE, $me, 0);
    $c->add('privacy_policy_link','','text',0,0,NULL,2060,TRUE, $me, 0);

    // Update default theme and reset to original value
    // Since actual Core config not loaded yet by installer lets load it into temp value so we don't mess things up
    $c->initConfig();
    $_TEMP_CONF = $c->get_config('Core');
    $c->add('theme','denim_three','select',2,10,NULL,190,TRUE, $me, 10);
    $c->set('theme',$_TEMP_CONF['theme'], $me);

    return true;
}

/**
 * Remove blank username accounts and update any duplicate username accounts with new names
 * Add Unique index to username column
 *
 * @return bool
 */
function fixDuplicateUsernames221()
{
    global $_TABLES;

    // Delete blank usernames first
    // Left users that are just spaces... hopefully none of these
    $sql = "SELECT uid, username FROM {$_TABLES['users']} WHERE username = ''";
    $result = DB_query($sql);
    $numRows = DB_numRows($result);
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);

        $uid = $A['uid'];

        // Blank usernames were sometimes generated via new Facebook Oauth accounts for Geeklog 2.2.0 and older.
        // See: https://github.com/Geeklog-Core/geeklog/issues/861
        // Should be only 1 record in user table (all our tests showed this) but lets delete anything just in case.. since we cannot call USER_deleteAccount($uid) here
        // remove from all security groups
        DB_delete($_TABLES['group_assignments'], 'ug_uid', $uid);

        // remove user information and preferences
        DB_delete($_TABLES['userprefs'], 'uid', $uid);
        DB_delete($_TABLES['userindex'], 'uid', $uid);
        DB_delete($_TABLES['usercomment'], 'uid', $uid);
        DB_delete($_TABLES['userinfo'], 'uid', $uid);
        DB_delete($_TABLES['backup_codes'], 'uid', $uid);

        // avoid having orphand stories/comments by making them anonymous posts
        DB_query("UPDATE {$_TABLES['comments']} SET uid = 1 WHERE uid = $uid");
        DB_query("UPDATE {$_TABLES['stories']} SET uid = 1 WHERE uid = $uid");
        DB_query("UPDATE {$_TABLES['stories']} SET owner_id = 1 WHERE owner_id = $uid");

        // delete submissions
        DB_delete($_TABLES['storysubmission'], 'uid', $uid);
        DB_delete($_TABLES['commentsubmissions'], 'uid', $uid); // Includes article and plugin submissions

        // now delete the user itself
        DB_delete($_TABLES['users'], 'uid', $uid);
    }

    // Must find and remove all duplicate usernames before adding index
	// NOTE: Depending on the database collation, MySQL may be setup to not differentiate trailing spaces, be case insensitive and accent insensitive which can create problems because PHP functions may see them as different. So group by username trimmed and already lower case
	// For example the grouping below could and should see "Nina", "Nina  ", "nina", and "Niña" as the same
	$sql = "SELECT username, COUNT(*) c FROM {$_TABLES['users']} GROUP BY TRIM(LOWER(username)) HAVING c > 1";
    $result = DB_query($sql);
    $numRows = DB_numRows($result);
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);

        $dup_username = DB_escapeString($A['username']);

        // Now fix if possible. List local account last as it will be not considered dup since all others have been changed
        $sql_B = "SELECT uid, username FROM {$_TABLES['users']} WHERE TRIM(LOWER(username)) = TRIM(LOWER('$dup_username')) ORDER BY remoteservice DESC";
        $result_B = DB_query($sql_B);
        $numRows_B = DB_numRows($result_B);
        for ($i_B = 0; $i_B < $numRows_B; $i_B++) {
            $B = DB_fetchArray($result_B);

            $uid = $B['uid'];
            $username = $B['username'];

			// Now see if same name is used by different id
            $checkName = DB_getItem($_TABLES['users'], 'username', "TRIM(LOWER(username)) = TRIM(LOWER('" . DB_escapeString($username) . "')) AND uid != $uid");
            if (!empty($checkName)) {
                /*
                // Cannot call CUSTOM_uniqueRemoteUsername since in install
                if (function_exists('CUSTOM_uniqueRemoteUsername')) {
                    $username = CUSTOM_uniqueRemoteUsername($username, $remoteService);
                }
                */

				// Cannot call USER_uniqueUsername so took code from function
				// $username = USER_uniqueUsername($username);

				$try = $username;
				do {
					$try = DB_escapeString($try);
					$test_uid = DB_getItem($_TABLES['users'], 'uid', "TRIM(LOWER(username)) = TRIM(LOWER('$try'))");
					if (!empty($test_uid)) {
						$r = rand(2, 9999);
						if (strlen($username) > 12) {
							$try = sprintf('%s%d', substr($username, 0, 12), $r);
						} else {
							$try = sprintf('%s%d', $username, $r);
						}
					}
				} while (!empty($test_uid));
				$username = $try;

                // Save new name
                DB_query("UPDATE {$_TABLES['users']} SET username = '" . DB_escapeString($username) . "' WHERE uid=$uid");
            }
        }
    }

    // Remove old username index and add unique index on username
    $sql = "ALTER TABLE {$_TABLES['users']} DROP INDEX users_username;";
    DB_query($sql);
    $sql = "ALTER TABLE {$_TABLES['users']} ADD UNIQUE KEY users_username (username);";
    DB_query($sql);

    return true;
}

function addStructuredDataSecurityRight221()
{
    global $_TABLES;

    // Add `structureddata.autotag` feature
    $sql = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'structureddata.autotag', 'Can use the Structured Data Autota', 1)";
    DB_query($sql, 1);
    $ftId = DB_insertId(null, $_TABLES['features'] . '_ft_id_seq');

    // Get `Story Admin` group id
    if (isset($_GROUPS['Story Admin'])) {
        $grpId = $_GROUPS['Story Admin'];
    } else {
        $grpId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Story Admin'");
    }

    // Give `structureddata.autotag` feature to `Story Admin` group
    $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$ftId}, {$grpId}) ";
    DB_query($sql, 1);

    return true;
}

function calculateNumPagesArticles221()
{
    global $_TABLES;

    // Calculate number of pages for articles (that have [page_break] in body text)
    $sql = "SELECT sid, bodytext FROM {$_TABLES['stories']} WHERE bodytext != ''";
    $result = DB_query($sql);
    $numRows = DB_numRows($result);
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);

        $numpages = (count(explode('[page_break]', $A['bodytext'])));

        // Save new name
        DB_query("UPDATE {$_TABLES['stories']} SET numpages = $numpages WHERE sid = '" . DB_escapeString($A['sid']) . "'");
    }

    return true;
}
