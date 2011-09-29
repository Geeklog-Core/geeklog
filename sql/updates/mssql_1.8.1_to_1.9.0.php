<?php

// Add Topic Assignment Table
$_SQL[] = "
CREATE TABLE  [dbo].[{$_TABLES['topic_assignments']}] (
  [tid] [varchar] (20) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
  [type]  [varchar] (30) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
  [id]  [varchar] (40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL
) ON [PRIMARY]
";


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
        
        $sql = "INSERT INTO {$_TABLES['topic_assignments']} (tid, type, id) VALUES ('{$A['tid']}', 'block', '{$A['bid']}')";
        DB_query($sql);
    }

    // Remove Topic Id from blocks table
    $sql = "ALTER TABLE {$_TABLES['blocks']} DROP tid";    
    DB_query($sql);
    
}

?>
