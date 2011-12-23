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

?>
