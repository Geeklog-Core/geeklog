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


// Note: this is the exact same function as STORY_extractLinks
function UPDATE_extractLinks( $fulltext, $maxlength = 26 )
{
    $rel = array();

    /* Only match anchor tags that contain 'href="<something>"'
     */
    preg_match_all( "/<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)<\/a>/i", $fulltext, $matches );
    for ( $i=0; $i< count( $matches[0] ); $i++ )
    {
        $matches[2][$i] = strip_tags( $matches[2][$i] );
        if ( !strlen( trim( $matches[2][$i] ) ) ) {
            $matches[2][$i] = strip_tags( $matches[1][$i] );
        }

        // if link is too long, shorten it and add ... at the end
        if ( ( $maxlength > 0 ) && ( strlen( $matches[2][$i] ) > $maxlength ) )
        {
            $matches[2][$i] = substr( $matches[2][$i], 0, $maxlength - 3 ) . '...';
        }

        $rel[] = '<a href="' . $matches[1][$i] . '">'
               . str_replace ("/(\015\012)|(\015)|(\012)/", '', $matches[2][$i])
               . '</a>';
    }

    return( $rel );
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

// add index for 'onleft' and 'name' to speed up themes with different left and right block templates
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD INDEX blocks_onleft(onleft)";
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD INDEX blocks_name(name)";

// remove unused entry (moved to 'syndication' table)
// (this is obsolete since 1.3.9 but was still present in fresh 1.3.9 installs)
$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = 'rdf_sids'";

// Time to add the SpamX table
$_SQL[] = "CREATE TABLE {$_TABLES['spamx']} ("
	. " name varchar(20) NOT NULL default '',"
	. " value varchar(255) NOT NULL default '',"
	. " INDEX name (name)"
	. ") TYPE=MyISAM
";

// Ok, the rest of the file is data
$_DATA[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('spamx', '1.0.1','1.3.10',1,'http://www.pigstye.net/gplugs/staticpages/index.php/spamx') ";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Action','DeleteComment')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Examine','BlackList')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Examine','MTBlackList')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Personal','zaraz.com')";

?>
