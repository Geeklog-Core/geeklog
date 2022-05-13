<?php

use Geeklog\DAO\UserAttributeDAO;
use Geeklog\Entity\UserAttributeEntity;

global $_DB_table_prefix, $_TABLES;

// The following entries are no longer defined in 'lib-database.php', so define them here
$_TABLES['cookiecodes'] = $_DB_table_prefix . 'cookiecodes';
$_TABLES['dateformats'] = $_DB_table_prefix . 'dateformats';
$_TABLES['maillist'] = $_DB_table_prefix . 'maillist';
$_TABLES['usercomment'] = $_DB_table_prefix . 'usercomment';
$_TABLES['userindex'] = $_DB_table_prefix . 'userindex';
$_TABLES['userinfo'] = $_DB_table_prefix . 'userinfo';
$_TABLES['userprefs'] = $_DB_table_prefix . 'userprefs';

// Add missing route into routing table for articles that have page breaks (issue #746)
$_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid/@page', '/article.php?story=@sid&page=@page', 1000)"; // Priority should default to 120 but we need to mage sure it comes after the route for article print

// Drop $_tables
$_SQL[] = "DROP TABLE {$_TABLES['cookiecodes']}";
$_SQL[] = "DROP TABLE {$_TABLES['dateformats']}";
$_SQL[] = "DROP TABLE {$_TABLES['maillist']}";

// Old VARS table variables for Database Backup that are not used anymore (but could still get created in some cases)
$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_files'";
$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_gzip'";
$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_allstructs'";
$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = 'db_backup_interval'";
$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = '_dbback_cron'";

/**
 * Add/Edit/Delete config options for new version
 */
function update_ConfValuesFor222()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();
    $me = 'Core';

    // Add IP anonymization policy
    $c->add('ip_anonymization', \Geeklog\IP::POLICY_NEVER_ANONYMIZE, 'text', 0, 0, null, 2070, true, $me, 0);
	
    // Add Likes System Tab and config options
    $sg  =  4;      // subgroup
    $fs  = 51;      // fieldset
    $tab = 51;      // tab
	$so  = 1740;    // sort
    $c->add('likes_users_listed', 5, 'text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
	$so += 10;
	
	$fs  = 52;      // fieldset
    $c->add('fs_likes_block_settings', NULL, 'fieldset', $sg, $fs, NULL, 0, TRUE, $me, $tab);
    $c->add('likes_block_enable',true, 'select', $sg, $fs, 0, $so, TRUE, $me, $tab);
	$so += 10;
    $c->add('likes_block_isleft', 1, 'select', $sg, $fs, 0, $so, TRUE, $me, $tab);
    $so += 10;
	$c->add('likes_block_order', 10, 'text', $sg, $fs, 0, $so, TRUE, $me, $tab);
    $so += 10;
	$c->add('likes_block_topic_option', TOPIC_ALL_OPTION,'select', $sg, $fs, 43, $so, TRUE, $me, $tab);
    $so += 10;
	$c->add('likes_block_topic', array(), '%select', $sg, $fs, NULL, $so, TRUE, $me, $tab);
	$so += 10;
    $c->add('likes_block_cache_time',3600,'text', $sg, $fs,NULL,$so,TRUE, $me, $tab);
    $so += 10;
    $c->add('likes_block_displayed_actions',LIKES_BLOCK_DISPLAY_ALL, 'select', $sg, $fs, 46, $so, TRUE, $me, $tab);
	$so += 10;	
    $c->add('likes_block_include_time',604800,'text', $sg, $fs,NULL,$so,TRUE, $me, $tab);
    $so += 10;
    $c->add('likes_block_max_items',10,'text', $sg, $fs,NULL,$so,TRUE, $me, $tab);
    $so += 10;
	$c->add('likes_block_title_trim_length',20,'text', $sg, $fs,NULL,$so,TRUE, $me, $tab);
	$so += 10;
	$c->add('likes_block_likes_new_line',true, 'select', $sg, $fs, 0, $so, TRUE, $me, $tab);
	$so += 10;
    $c->add('likes_block_type', '', 'text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
	$so += 10;	
    $c->add('likes_block_subtype', '', 'text', $sg, $fs, NULL, $so, TRUE, $me, $tab);
	$so += 10;	
	
	$fs  = 53;      // fieldset
    $c->add('fs_likes_block_permissions', NULL, 'fieldset', $sg, $fs, NULL, 0, TRUE, $me, $tab);
    $new_group_id = 0;
    if (isset($_GROUPS['Block Admin'])) {
        $new_group_id = $_GROUPS['Block Admin'];
    } else {
        $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Block Admin'");
        if ($new_group_id == 0) {
            if (isset($_GROUPS['Root'])) {
                $new_group_id = $_GROUPS['Root'];
            } else {
                $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
            }
        }
    }
    $c->add('likes_block_group_id', $new_group_id,'select', $sg, $fs, NULL, $so, TRUE, $me, $tab);
	$so += 10;
    $c->add('likes_block_permissions', array (2, 2, 2, 2), '@select', $sg, $fs, 44, $so, TRUE, $me, $tab);
	$so += 10;

    return true;
}

/**
 * Move IP addresses to the new 'ip_addresses' table
 *
 * @return bool
 */
function update_TablesContainingIPAddresses222()
{
    global $_TABLES;

    // New 'ip_addresses' table
    $sql = "
CREATE TABLE {$_TABLES['ip_addresses']} (
  seq SERIAL,
  ipaddress VARCHAR(39) NOT NULL DEFAULT '0.0.0.0',
  created_at INT NOT NULL DEFAULT 0,
  is_anonymized INT NOT NULL default 0,
  PRIMARY KEY (seq)
";
    DB_query($sql);

    $data = [
        'comments'           => ['cid', 'ipaddress'],
        'commentsubmissions' => ['cid', 'ipaddress'],
        'likes'              => ['lid', 'ipaddress'],
        'sessions'           => ['sess_id', 'remote_ip'],
        'trackback'          => ['cid', 'ipaddress'],
    ];

    foreach ($data as $table => $pair) {
        $primaryKeyColumn = $pair[0];
        $ipColumn = $pair[1];

        // Add 'seq' column
        DB_query("ALTER TABLE $_TABLES[$table] ADD COLUMN seq INT NOT NULL DEFAULT 0");

        // Collect primary key values and IP addresses
        $result = DB_query("SELECT $primaryKeyColumn, $ipColumn FROM $_TABLES[$table]");
        $rows = [];

        while (($A = DB_fetchArray($result, false)) != false) {
            $rows[] = $A;
        }

        \Geeklog\IP::init($_TABLES['ip_addresses'], \Geeklog\IP::POLICY_NEVER_ANONYMIZE);

        foreach ($rows as $row) {
            $primaryKeyValue = $row[$primaryKeyColumn];
            $ipAddress = $row[$ipColumn];

            // Move IP addresses to 'ip_addresses' table
            $seq = \Geeklog\IP::getSeq($ipAddress);

            // Update 'seq' column
            if ($table === 'sessions') {
                $primaryKeyValue = DB_escapeString($primaryKeyValue);
                DB_query("UPDATE $_TABLES[$table] SET seq = $seq WHERE $primaryKeyColumn = '$primaryKeyValue'");
            } else {
                DB_query("UPDATE $_TABLES[$table] SET seq = $seq WHERE $primaryKeyColumn = $primaryKeyValue");
            }
        }

        // Drop column 'ipaddress'
        DB_query("ALTER TABLE $_TABLES[$table] DROP COLUMN $ipColumn");
    }

    return true;
}

/**
 * Combine user tables into one
 *
 * Collect data from $_TABLES['usercomment'], $_TABLES['userindex'], $_TABLES['userinfo'] and $_TABLES['userprefs']
 * and insert them into $_TABLES['user_attributes']
 *
 * @return bool
 */
function update_CombineUserTables222()
{
    global $_TABLES;

    $sql1 = "
CREATE TABLE {$_TABLES['user_attributes']} (
  uid SMALLINT NOT NULL DEFAULT 1,
  commentmode VARCHAR(10) NOT NULL DEFAULT 'nested',
  commentorder VARCHAR(4) NOT NULL DEFAULT 'ASC',
  commentlimit SMALLINT NOT NULL DEFAULT 100,
  etids TEXT NOT NULL,
  noboxes SMALLINT NOT NULL DEFAULT 0,
  maxstories SMALLINT NOT NULL DEFAULT 0,
  about TEXT NOT NULL,
  location VARCHAR(96) NOT NULL DEFAULT '',
  pgpkey TEXT NOT NULL,
  tokens SMALLINT NOT NULL DEFAULT 0,
  lastgranted SMALLINT NOT NULL DEFAULT 0,
  lastlogin VARCHAR(10) NOT NULL DEFAULT '0',
  dfid SMALLINT NOT NULL DEFAULT 0,
  advanced_editor SMALLINT NOT NULL DEFAULT 1,
  tzid VARCHAR(125) NOT NULL DEFAULT '',
  emailfromadmin SMALLINT NOT NULL DEFAULT 1,
  emailfromuser SMALLINT NOT NULL DEFAULT 1,
  showonline SMALLINT NOT NULL DEFAULT 1,
  PRIMARY KEY (uid)
);";

    $sql2 = <<<SQL
INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit)
  VALUES (1, 'nested', 'ASC', 100)
SQL;

    $sql3 = <<<SQL
SELECT c.*, x.*, f.*, p.* 
  FROM {$_TABLES['usercomment']} AS c 
    LEFT JOIN {$_TABLES['userindex']} AS x ON c.uid = x.uid
    LEFT JOIN {$_TABLES['userinfo']} AS f ON c.uid = f.uid
    LEFT JOIN {$_TABLES['userprefs']} AS p ON c.uid = p.uid
SQL;

    // With PostgreSQL, we can use transaction
    if (DB_beginTransaction()) {
        // Create $_TABLES['user_attributes'] table
        DB_query($sql1);
        if (DB_error()) {
            DB_rollBack();

            return false;
        }

        // Insert dummy data for the guest user beforehand, to prevent column values becoming NULL
        DB_query($sql2);
        if (DB_error()) {
            DB_rollBack();

            return false;
        }

        // Collect data from old tables
        $result = DB_query($sql3);
        if (DB_error()) {
            DB_rollBack();

            return false;
        }

        $userAttributeDAO = new UserAttributeDAO($_TABLES['user_attributes']);

        // Insert the collected data into a new table
        while (!empty($A = DB_fetchArray($result, false))) {
            $entity = UserAttributeEntity::fromArray($A);
            $userAttributeDAO->create($entity);
        }

        // Drop old tables
        DB_query("DROP TABLE {$_TABLES['usercomment']}");
        DB_query("DROP TABLE {$_TABLES['userindex']}");
        DB_query("DROP TABLE {$_TABLES['userinfo']}");
        DB_query("DROP TABLE {$_TABLES['userprefs']}");
        DB_commit();

        return true;
    } else{
        return false;
    }
}
