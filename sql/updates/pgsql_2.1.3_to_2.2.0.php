<?php

// Add `meta_description` and `meta_keywords` columns to the `storysubmission` table
$_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD `meta_description` TEXT NULL AFTER `postmode`";
$_SQL[] = "ALTER TABLE {$_TABLES['storysubmission']} ADD `meta_keywords` TEXT NULL AFTER `meta_description`";

// Add `status_code` and `enabled` column to the `routes` table
$_SQL[] = "ALTER TABLE {$_TABLES['routes']} ADD `status_code` INT NOT NULL DEFAULT 200 AFTER `route`";
$_SQL[] = "ALTER TABLE {$_TABLES['routes']} ADD `enabled` tinyint(1) unsigned NOT NULL default '1' AFTER `priority`";
// Add new topic routes
$_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/topic/@topic', '/index.php?topic=@topic', 160)";
$_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/topic/@topic/@page', '/index.php?topic=@topic&page=@page', 170)";
$_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/page/@page/print', '/staticpages/index.php?page=@page&disp_mode=print', 180)";

// Add `css_id` and `css_classes` columns to the `blocks` table
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD `css_id` VARCHAR(255) NOT NULL DEFAULT '' AFTER `help`";
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD `css_classes` VARCHAR(255) NOT NULL DEFAULT '' AFTER `css_id`";
// Add column to enable/disable convert newlines for normal blocks
$_SQL[] = "ALTER TABLE `{$_TABLES['blocks']}` ADD `convert_newlines` smallint NOT NULL DEFAULT '0' AFTER `allow_autotags`";
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
$_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `twofactorauth_enabled` SMALLINT NOT NULL DEFAULT 0 AFTER `lastinvalid`";
$_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `twofactorauth_secret` VARCHAR(255) NOT NULL DEFAULT '' AFTER `twofactorauth_enabled`";

// Add a table to store backup codes for two factor authentication
$_SQL[] = "
CREATE TABLE {$_TABLES['backup_codes']} (
  code VARCHAR(16) NOT NULL UNIQUE,
  uid INT NOT NULL DEFAULT 0,
  is_used SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (code)
)
";

// Add column to confirm new email address
$_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `emailconfirmid` VARCHAR(16) NULL DEFAULT NULL AFTER `pwrequestid`";
$_SQL[] = "ALTER TABLE `{$_TABLES['users']}` ADD `emailtoconfirm` VARCHAR(96) NULL DEFAULT NULL AFTER `emailconfirmid`";

// Fix for password request id getting set to a string with the word "NULL" instead of actually NULL
$_SQL[] = "UPDATE `{$_TABLES['users']}` SET pwrequestid = NULL WHERE pwrequestid = 'NULL'";

// Add column for Topic Title
$_SQL[] = "ALTER TABLE `{$_TABLES['topics']}` ADD `title` VARCHAR(128) NULL DEFAULT NULL AFTER `topic`";

/**
 * Upgrade Messages
 */
function upgrade_message213()
{
    global $_TABLES;

    // 3 upgrade message types exist 'information', 'warning', 'error'
    // error type means the user cannot continue upgrade until fixed
    // array(error type, title, message)
    
    $upgradeMessages['2.1.3'] = array(
        1 => array('warning', 18, 19), // Comment signatures will be removed from old comments
        2 => array('warning', 20, 21) // Warning about COM_SiteHeader and COM_SiteFooter being dropped which will affect some older plugins
    );

    return $upgradeMessages;
}

/**
 * Add new config options
 */
function update_ConfValuesFor220()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';

    // Add switch language redirect option
    $c->add('switchlang_homepage',0,'select',6,28,0,370,TRUE, $me, 28);
    
    // Add the cache_mobile config option again since the config option may be missing for sites who upgraded from 2.1.2 (upgrade script had a bug in it)
    $c->add('cache_mobile',TRUE,'select',2,10,1,230,TRUE, $me, 10);    
    
    // Enable or disable Resource cache
    $c->add('cache_resource',TRUE,'select',2,10,1,240,TRUE, $me, 10);
    
    // Add config options to track invalid user login attempts
    $c->add('invalidloginattempts',7,'text',4,18,NULL,1710,TRUE, $me, 18);
    $c->add('invalidloginmaxtime',1200,'text',4,18,NULL,1720,TRUE, $me, 18);
    
    // Hidden config option for Core used to determine language of topic url (see _getLanguageInfoFromURL in lib-common)
    $c->add('langurl_topic',array('', 'index.php', 'topic'),'@hidden',7,31,1,1830,TRUE, $me, 31); 
    // Hidden config option for Core used to determine language of article url (see _getLanguageInfoFromURL in lib-common)
    $c->add('langurl_article',array('', 'article.php', 'story'),'@hidden',7,31,1,1830,TRUE, $me, 31);     

    // Add a config option to decide whether to globally allow two factor auth
    $c->add('enable_twofactorauth',0,'select',4,18,0,1730,TRUE, $me, 18);
    
    // Config option to force email to be required (used for all remote account types as some may not return email address)
    $c->add('require_user_email',1,'select',4,16,0,295,TRUE, $me, 16);
    
    // Config option for enable/disable logging of 404 errors
    $c->add('404_log',1,'select',7,31,1,1840,TRUE, $me, 31);
    
    // Config option to control how often the Article Topic List Block repeats on the page
    $c->add('blocks_article_topic_list_repeat_after',1,'text',1,7,NULL,1400,TRUE, $me, 7);

    // Config Option for max number of pages to display for the page navigation if the visitor is using a mobile device
    $c->add('page_navigation_mobile_max_pages',7,'text',7,31,NULL,1805,TRUE, $me, 31);

    return true;
}

/**
 * Add Theme Admin
 *
 * @return bool
 */
function addThemeAdminFor220()
{
    global $_CONF, $_TABLES;

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

        return false;
    }

    return true;
}

/**
 * Remove old Comment Signatures and User Edit Dates
 *
 * @return bool
 */
function removeCommentSig220()
{
    global $_TABLES;

    $sql = "SELECT cid, comment FROM {$_TABLES['comments']} 
        WHERE comment LIKE '%<!-- COMMENTSIG -->%' 
        OR  comment LIKE '%<!-- /COMMENTEDIT -->%'";
    
    $result = DB_query($sql);
    $numRows = DB_numRows($result);
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);
        
        $text = str_replace('<!-- COMMENTSIG --><div class="comment-sig">', '', $A['comment']);
        $text = str_replace('</div><!-- /COMMENTSIG -->', '', $text);
        $text = str_replace('<div class="comment-edit">', '', $text);
        $text = str_replace('</div><!-- /COMMENTEDIT -->', '', $text);        
        
        DB_query("UPDATE {$_TABLES['comments']} SET comment = '$text' WHERE cid = {$A['cid']}");
    }

    return true;
}
