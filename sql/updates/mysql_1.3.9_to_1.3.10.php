<?php

function commentsToPreorderTreeHelper(&$tP, $left, $indent = 0)
{
    global $_TABLES;

    // start with the right terminal value = left terminal value + 1
    $right = $left + 1;
    
    //foreach child (if any) run the recursive function
    if ( isset( $tP['children'] ))
    {
	    while( list( $k, $A ) = each( $tP['children'] ) )
    	{
        	//DEBUG: print("calling recurisive($k, $right)\n");
        	$right = commentsToPreorderTreeHelper($A, $right, $indent + 1);
        	$right++;   
    	}
    }
    
    //Update the comment, set lft = $left and rht = return value + 1
    $q = "UPDATE {$_TABLES['comments']} SET lft = $left, rht = $right, "
       . "indent = $indent WHERE cid = " . $tP['cid'];
    DB_query($q);
    
    //DEBUG: print $q."<br>";
    
    //return right
    return $right;
}

function commentsToPreorderTree()
{
    global $_TABLES;
    
    // Get all the unique sid's from the database
    $q = "SELECT sid FROM {$_TABLES['comments']} group by sid";
    $result = DB_query($q);

    // Loop through every sid supplementing comments with new rows
    //   'lft', 'rht', and 'indent'
    while ( $A = DB_fetchArray($result) )
    {
        // build a tree
    	$aP = array();
    	$tP = array();
    	
        // grab comments associated with the current 'sid'
        $qC = "SELECT cid,pid FROM {$_TABLES['comments']} "
           	. "WHERE sid = '{$A['sid']}' ORDER BY cid ASC";
        $rC = DB_query( $qC ); 
        
        // put the comments in a usefull array
        while ( $dC = DB_fetchArray( $rC ) )
        {
        	if ( $dC['pid'] == 0 )
        	{
        		// Root comment
        		$tP[$dC['cid']] = $dC;
        		$aP[$dC['cid']] =& $tP[$dC['cid']];
        	}
        	else
        	{
        		// Child comment
        		$aP[$dC['pid']]['children'][$dC['cid']] = $dC;
       			$aP[$dC['cid']] =& $aP[$dC['pid']]['children'][$dC['cid']];	
       		}
        }
        
        unset ($aP);
        
        // initialize left terminal value, this starts with 1 for every
        //   set of comments associated with a 'sid'
        $left = 1;
        
        // Foreach toplevel comment run the recursive funtion
        while( list( $k, $B ) = each( $tP ) )
        {
        	//DEBUG: print("calling recurisive({$B['cid']}, $left)\n");
            $left = commentsToPreorderTreeHelper($B, $left);
            $left++;   
        }
        
        /* Print results to error log for DEBUGing
         * $left = ($left-1)/2;
         * COM_errorLog("$left comments in story {$A['sid']} converted");
         */
    }
}

// modify the comments table to speed things up
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD lft mediumint(10) unsigned NOT NULL default '0' AFTER pid";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD rht mediumint(10) unsigned NOT NULL default '0' AFTER lft";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD indent mediumint(10) unsigned NOT NULL default '0' AFTER rht";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD ipaddress varchar(15) NOT NULL default '' AFTER uid";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD INDEX comments_lft(lft)";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD INDEX comments_rht(rht)";

// make sure the older_stories block is of type "gldefault"
$_SQL[] = "UPDATE {$_TABLES['blocks']} SET type = 'gldefault' WHERE name = 'older_stories'";

// remove obsolete "layout" blocks from _very_ old databases ...
$_SQL[] = "DELETE FROM {$_TABLES['blocks']} WHERE type = 'layout'";

// add an index on the 'topic' field of the syndication table
$_SQL[] = "ALTER TABLE {$_TABLES['syndication']} ADD INDEX syndication_topic(topic)";

// make sure old links have a proper owner (user "anonymous")
$_SQL[] = "UPDATE {$_TABLES['links']} SET owner_id = 1 WHERE owner_id = 0";

// Add new fields for Story Archive feature 
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD expire DATETIME NOT NULL AFTER statuscode";
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD archive_flag tinyint(1) unsigned NOT NULL DEFAULT '0' AFTER is_default";

?>
