<?php

function commentsToPreorderTreeHelper($commentid, $left)
{
    global $_TABLES;
    $right = $left + 1;
    
    //get all children of the comment
    $q = "SELECT cid FROM {$_TABLES['comments']} WHERE pid = $commentid";
    $result = DB_query($q);
    
    //foreach child run the recursive function
    while ( $A = DB_fetchArray($result) )
    {
        //DEBUG: print("calling recurisive({$A['cid']}, $right)\n");
        $right = commentsToPreorderTreeHelper($A['cid'], $right);
        $right++;   
    }
    
    //Update the comment, set lft = $left and rht = return value + 1
    $q = "UPDATE {$_TABLES['comments']} SET lft = $left, rht = $right "
       . "WHERE cid = $commentid";
    DB_query($q);
    //DEBUG: print "$q\n";
    
    //return rht
    return $right;
}

function commentsToPreorderTree()
{
    global $_TABLES;
    
    //Get all the unique sid's from the database
    $q = "SELECT sid FROM {$_TABLES['comments']} group by sid";
    $result = DB_query($q);

    //Foreach sid, get all the top level comments
    // begin with $left = 1
    while ( $A = DB_fetchArray($result) )
    {
        // initialize left terminal value
        $left = 1;
        
        // get top level comments
        $q = "SELECT cid FROM {$_TABLES['comments']} "
           . "WHERE sid = '{$A['sid']}' AND pid = 0";
        $res2 = DB_query($q); 
        
        //Foreach toplevel comment run the recursive funtion
        while ( $B = DB_fetchArray($res2) ) 
        {
            //DEBUG: print("calling recurisive({$B['cid']}, $left)\n");
            $left = commentsToPreorderTreeHelper($B['cid'], $left);
            $left++;   
        }
        
        //Print results to error log
        $left = ($left-1)/2;
    }
}

// modify the comments table to speed things up
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD lft int(10) unsigned NOT NULL default '0' AFTER pid";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD rht int(10) unsigned NOT NULL default '0' AFTER lft";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD INDEX comments_lft(lft)";
$_SQL[] = "ALTER TABLE {$_TABLES['comments']} ADD INDEX comments_rht(rht)";

?>
