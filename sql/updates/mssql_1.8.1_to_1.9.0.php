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
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD [featured_article] [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NULL AFTER [hidden]";

// Update Session Table
$_SQL[] = "ALTER TABLE {$_TABLES['sessions']} ADD [whos_online] [tinyint] NOT NULL AFTER [md5_sess_id]";

/**
 * Add new config options
 *
 */
function update_BlockTopicAssignmentsFor190()
{
    global $_TABLES;
    
    
    $sql = "SELECT * FROM {$_TABLES['blocks']}";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    for( $i = 0; $i < $nrows; $i++ ) {
        $A = DB_fetchArray($result);
        
        $sql = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id, inherit, tdefault) VALUES ('{$A['tid']}', 'block', '{$A['bid']}', 1, 0)";
        DB_query($sql);
    }

    // Remove Topic Id from blocks table
    $sql = "ALTER TABLE {$_TABLES['blocks']} DROP tid";    
    DB_query($sql);
    
}

?>
