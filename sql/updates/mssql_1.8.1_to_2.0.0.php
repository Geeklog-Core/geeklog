<?php

// Add Topic Assignment Table
$_SQL[] = "
CREATE TABLE  [dbo].[{$_TABLES['topic_assignments']}] (
  [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
  [type]  [varchar] (30) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
  [id]  [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL, 
  [inherit] [tinyint] NOT NULL, 
  [tdefault] [tinyint] NOT NULL
) ON [PRIMARY]
";

// Add new Topic Columns used for Child Topics
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD [parent_id] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL AFTER [archive_flag]";
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD [inherit] [tinyint] NOT NULL AFTER [parent_id]";
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD [hidden] [tinyint] NOT NULL AFTER [inherit]";

// Update Session Table
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} ADD [whos_online] [tinyint] NOT NULL AFTER [md5_sess_id]";
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} ADD [topic] [varchar] (20) NOT NULL AFTER [whos_online]";

// Password Updates
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ALTER COLUMN [passwd] [varchar] (128) NOT NULL default ''";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD [salt] [varchar] (64) NOT NULL default '' AFTER [passwd]";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD [algorithm] [tinyint] NOT NULL default '0' AFTER [salt]";
$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD [stretch] [int] NOT NULL default '1' AFTER [algorithm]";

/**
 * Create Story and Submission Topic assignments
 *
 */
function update_StoryTopicAssignmentsFor200()
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
function update_BlockTopicAssignmentsFor200()
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
    $sql = "ALTER TABLE {$_TABLES['blocks']} DROP tid";    
    DB_query($sql);
    
}


/**
 * Add new config options
 *
 */
function update_ConfValuesFor200()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';
    
    // Breadcrumbs
    $c->add('tab_topics', NULL, 'tab', 7, 45, NULL, 0, TRUE, $me, 45);
    $c->add('fs_breadcrumbs', NULL, 'fieldset', 7, 45, NULL, 0, TRUE, $me, 45);
    $c->add('multiple_breadcrumbs', 0, 'select', 7, 45, 0, 2000, TRUE, $me, 45);
    $c->add('disable_breadcrumbs_topics', 0, 'select', 7, 45, 0, 2010, TRUE, $me, 45);
    $c->add('disable_breadcrumbs_articles', 0, 'select', 7, 45, 0, 2020, TRUE, $me, 45);
    $c->add('disable_breadcrumbs_plugins', 0, 'select', 7, 45, 0, 2030, TRUE, $me, 45);  
    
    // Password Update
    $c->add('fs_pass', NULL, 'fieldset', 4, 42, NULL, 0, TRUE, $me, 18);
    $c->add('pass_alg', 1, 'select', 4, 42, 29, 800, TRUE, $me, 18);
    $c->add('pass_stretch', 4096, 'text', 4, 42, NULL, 810, TRUE, $me, 18);

    // Max Link Text
    $c->add('linktext_maxlen',50,'text',7,31,NULL,1754,TRUE, $me,31);   
    
    // Email CC settings
    $c->add('mail_cc_enabled', 1, 'select', 0, 1, 0, 180, TRUE, $me, 1);
    $c->add('mail_cc_default', 0, 'select', 0, 1, 0, 190, TRUE, $me, 1);

    // Comments    
    $c->add('comment_on_same_page',0,'select',4,21,0, 1690, TRUE, $me, 21);
    $c->add('show_comments_at_replying',0,'select',4,21,0, 1691, TRUE, $me, 21);      
    
    return true;
}

?>
