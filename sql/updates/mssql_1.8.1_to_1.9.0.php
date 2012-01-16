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
    $sql = "ALTER TABLE {$_TABLES['blocks']} DROP tid";    
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
    
    return true;
}

?>
