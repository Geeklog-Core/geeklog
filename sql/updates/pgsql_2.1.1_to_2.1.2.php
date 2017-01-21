<?php

// Add device type to blocks table
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD `device` VARCHAR( 15 ) NOT NULL DEFAULT 'all' AFTER `blockorder`";

// Change Topic Id (and Name) from 128 to 75 since we have an issue with the primary key on the topic_assignments table since it has to many bytes for tables with a utf8mb4 collation
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE `tid` `tid` VARCHAR(75) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE `topic` `topic` VARCHAR(75) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['topic_assignments']} CHANGE `tid` `tid` VARCHAR(75) NOT NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} CHANGE `topic` `topic` VARCHAR(75) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['syndication']} CHANGE `topic` `topic` VARCHAR(75) NOT NULL default '::all'";
$_SQL[] = "ALTER TABLE {$_TABLES['syndication']} CHANGE `header_tid` `header_tid` VARCHAR(75) NOT NULL default 'none'";

// Change the type of `value' column of `vars` table from VARCHAR(128) to TEXT
$_SQL[] = "ALTER TABLE {$_TABLES['vars']} CHANGE `value` `value` text NULL AFTER `name`";
$_SQL[] = "ALTER TABLE {$_TABLES['vars']} ALTER value TYPE text, ALTER value SET DEFAULT NULL";

/**
 * Upgrade Messages
 */
function upgrade_message211()
{
    global $_TABLES;

    // 3 upgrade message types exist 'information', 'warning', 'error'
    // error type means the user cannot continue upgrade until fixed

    /*
    // INCOMPLETE should check if user needs to change topic ids if changle length to 75 produces duplicate ids
    // Topic IDs and Names have changed from 128 to 75 
    if (Check if shortening ids creates duplicate ids) {
        $upgradeMessages['2.1.1'] = array('error' => 16);
    } else {
        $upgradeMessages['2.1.1'] = array('warning' => 15);
    }
    */

    // Dropped Support for Professional theme
    $upgradeMessages['2.1.1'] = array(
        'information' => 17,    // Dropped Support for Professional theme
        'warning'     => 15,    // Topic IDs and Names have changed from 128 to 75
    );

    return $upgradeMessages;
}

/**
 * Add Language feature
 */
function update_addLanguage()
{
    global $_TABLES;

    // Add `language_items` table
    $sql = "
CREATE TABLE {$_TABLES['language_items']} (
  id SERIAL NOT NULL,
  var_name VARCHAR(30) NOT NULL,
  language VARCHAR(30) NOT NULL,
  name VARCHAR(30) NOT NULL,
  value VARCHAR(255) DEFAULT '' NOT NULL,
  PRIMARY KEY (id)
)
";
    DB_query($sql);

    // Add `Language Admin` group
    $sql = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')), 'Language Admin', 'Has full access to language', 1);";
    DB_query($sql, 1);
    $grpId = DB_insertId(null, $_TABLES['groups'] . '_grp_id_seq');

    // Add `language.edit` feature
    $sql = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'language.edit', 'Can manage Language Settings', 1)";
    DB_query($sql, 1);
    $ftId = DB_insertId(null, $_TABLES['features'] . '_ft_id_seq');

    // Give `language.edit` feature to `Language Admin` group
    $sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$ftId}, {$grpId}) ";
    DB_query($sql, 1);

    // Add Root users to `Language Admin`
    $sql = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES ({$grpId}, NULL, 1) ";
    DB_query($sql, 1);
}

/**
 * Add Routing feature
 */
function update_addRouting()
{
    global $_TABLES;

    $_SQL = array();

    // Add `routes` table
    $_SQL[] = "
CREATE TABLE {$_TABLES['routes']} (
  rid SERIAL,
  method int NOT NULL DEFAULT 1,
  rule varchar(255) NOT NULL DEFAULT '',
  route varchar(255) NOT NULL DEFAULT '',
  priority int NOT NULL DEFAULT 100,
  PRIMARY KEY (rid)
)
";

    // Add sample routes
    $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid/print', '/article.php?story=@sid&mode=print', 100)";
    $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid', '/article.php?story=@sid', 110)";
    $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/archives/@topic/@year/@month', '/directory.php?topic=@topic&year=@year&month=@month', 120)";
    $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/page/@page', '/staticpages/index.php?page=@page', 130)";
    $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/links/portal/@item', '/links/portal.php?what=link&item=@item', 140)";
    $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/links/category/@cat', '/links/index.php?category=@cat', 150)";

    foreach ($_SQL as $sql) {
        DB_query($sql, 1);
    }
}

/**
 * Change users' theme to 'denim'
 */
function updateUserTheme212()
{
    global $_TABLES;

    $sql = "UPDATE {$_TABLES['users']} SET theme = 'denim' "
        . "WHERE (theme = 'professional') OR (theme = 'professional_css')";
    DB_query($sql);
}

/**
 * Add new config options
 */
function update_ConfValuesFor212()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';

    // Add extra setting to hide_main_page_navigation
    $c->del('hide_main_page_navigation', $me);
    $c->add('hide_main_page_navigation', 'false', 'select', 1, 7, 36, 1310, true, $me, 7);

    // New OAuth Service
    $c->add('github_login', 0, 'select', 4, 16, 1, 368, true, $me, 16);
    $c->add('github_consumer_key', '', 'text', 4, 16, null, 369, true, $me, 16);
    $c->add('github_consumer_secret', '', 'text', 4, 16, null, 370, true, $me, 16);

    // New mobile cache
    $c->add('cache_templates', true, 'select', 2, 10, 1, 220, true, $me, 10);

    // New Block Autotag permissions
    $c->add('autotag_permissions_block', array(2, 2, 0, 0), '@select', 7, 41, 28, 1920, true, $me, 37);

    // New search config option
    $c->add('search_use_topic', false, 'select', 0, 6, 1, 677, true, $me, 6);

    // New url routing option
    $c->add('url_routing', 0, 'select', 0, 0, 37, 1850, true, $me, 0);

    // Add mail charset
    $c->add('mail_charset', '', 'text', 0, 1, null, 195, true, $me, 1);

    // Delete MYSQL Dump Tab, section, and config options
    $c->del('tab_mysql', $me);
    $c->del('fs_mysql', $me);
    $c->del('allow_mysqldump', $me);
    $c->del('mysqldump_path', $me);
    $c->del('mysqldump_options', $me);
    $c->del('mysqldump_filename_mask', $me);

    // Add Database Backup config options
    $c->add('tab_database', null, 'tab', 0, 5, null, 0, true, $me, 5);
    $c->add('fs_database_backup', null, 'fieldset', 0, 5, null, 0, true, $me, 5);
    $c->add('dbdump_filename_prefix', 'geeklog_db_backup', 'text', 0, 5, null, 170, true, $me, 5);
    $c->add('dbdump_tables_only', 0, 'select', 0, 5, 0, 175, true, $me, 5);
    $c->add('dbdump_gzip', 1, 'select', 0, 5, 0, 180, true, $me, 5);
    $c->add('dbdump_max_files', 10, 'text', 0, 5, null, 185, true, $me, 5);

    // Add gravatar_identicon
    $c->add('gravatar_identicon', 'identicon', 'select', 5, 27, 38, 1620, false, $me, 27);

    // Delete PEAR Tab, section and config options
    $c->del('tab_pear', $me);
    $c->del('fs_pear', $me);
    $c->del('have_pear', $me);
    $c->del('path_pear', $me);

    // Add a flag whether to filter utf-8 4-byte character
    $c->add('remove_4byte_chars', true, 'select', 4, 20, 1, 855, true, $me, 20);

    // Change default theme to denim
    $c->set('theme', 'denim', 'Core');

    return true;
}
