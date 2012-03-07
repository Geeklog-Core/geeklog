<?php

// Add Topic Assignment Table
$_SQL[] = "
CREATE TABLE `{$_TABLES['topic_assignments']}` (
  `tid` varchar(20) NOT NULL,
  `type` varchar(30) NOT NULL,
  `id` varchar(40) NOT NULL,
  `inherit` tinyint(1) NOT NULL default '1',
  `tdefault` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`tid`,`type`,`id`)
) ENGINE=MyISAM";

// Add new Topic Columns used for Child Topics
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD parent_id varchar(20) NOT NULL default 'root' AFTER archive_flag";
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD inherit tinyint(1) NOT NULL default '1' AFTER parent_id";
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD hidden tinyint(1) NOT NULL default '0' AFTER inherit";

// Update Session Table
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} ADD whos_online tinyint(1) NOT NULL default '1' AFTER md5_sess_id";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} ADD topic varchar(20) NOT NULL default '' AFTER whos_online";

// Password Updates
$_SQL[] = "ALTER TABLE {$_TABLES['users']} MODIFY passwd varchar(128) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD salt varchar(64) NOT NULL default '' AFTER passwd";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD algorithm tinyint(3) NOT NULL default 0 AFTER salt";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD stretch int(8) unsigned NOT NULL default 1 AFTER algorithm";

/**
 * Create Story and Submission Topic assignments
 *
 */
function update_StoryTopicAssignmentsFor190()
{
    global $_TABLES;
    
    $story_tables[] = $_TABLES['stories'];
    $story_tables[] = $_TABLES['storysubmission'];

    foreach ($story_tables as $story_table) {
        $sql = "SELECT * FROM $story_table";
        $result = DB_query($sql);
        $nrows = DB_numRows($result);
    
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            
            $sql = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('{$A['tid']}', 'article', '{$A['sid']}', 1, 1)";
            DB_query($sql);
        }
        
        // Remove tid from table
        $sql = "ALTER TABLE $story_table DROP tid";
        DB_query($sql);
    }

}

/**
 * Create Block Topic assignments
 *
 */
function update_BlockTopicAssignmentsFor190()
{
    global $_TABLES;
    
    $sql = "SELECT * FROM {$_TABLES['blocks']}";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        
        $sql = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('{$A['tid']}', 'block', '{$A['bid']}', 1, 0)";
        DB_query($sql);
    }

    // Remove Topic Id from blocks table
    $sql = "ALTER TABLE {$_TABLES['blocks']} DROP `tid`";    
    DB_query($sql);
    
}

/**
 * Add new config options
 *
 */
function update_ConfValuesFor190()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';
    
    // Breadcrumbs
    $c->add('tab_topics', NULL, 'tab', 7, 45, NULL, 0, TRUE, $me, 45);
    $c->add('fs_breadcrumbs', NULL, 'fieldset', 7, 45, NULL, 0, TRUE, $me, 45);
    $c->add('disable_breadcrumbs_topics', 0, 'select', 7, 45, 0, 2000, TRUE, $me, 45);
    $c->add('disable_breadcrumbs_articles', 0, 'select', 7, 45, 0, 2010, TRUE, $me, 45);
    $c->add('disable_breadcrumbs_plugins', 0, 'select', 7, 45, 0, 2020, TRUE, $me, 45);  
    
    // Max Link Text
    $c->add('linktext_maxlen',50,'text',7,31,NULL,1754,TRUE, $me,31);    

    // Email CC settings
    $c->add('mail_cc_enabled', 1, 'select', 0, 1, 0, 180, TRUE, $me, 1);
    $c->add('mail_cc_default', 0, 'select', 0, 1, 0, 190, TRUE, $me, 1);
    
    // Password Update
    $c->add('fs_pass', NULL, 'fieldset', 4, 42, NULL, 0, TRUE, $me, 18);
    $c->add('pass_alg', 1, 'select', 4, 42, 29, 800, TRUE, $me, 18);
    $c->add('pass_stretch', 4096, 'text', 4, 42, NULL, 810, TRUE, $me, 18);

    // Comments    
    $c->add('comment_on_same_page',0,'select',4,21,0, 1690, TRUE, $me, 21);
    $c->add('show_comments_at_replying',0,'select',4,21,0, 1691, TRUE, $me, 21);    

    return true;
}

?>