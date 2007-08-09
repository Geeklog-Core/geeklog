<?php

// remove time zone table since its included into PEAR now
$_SQL[] = "DROP TABLE " . $_DB_table_prefix . 'tzcodes';
$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} CHANGE `tzid` `tzid` VARCHAR(125) NOT NULL DEFAULT ''";
// change former default values to '' so users dont all have edt for no reason
$_SQL[] = "UPDATE `{$_TABLES['userprefs']}` set tzid = ''";
// User submissions may have body text.
$_SQL[] = "ALTER TABLE `{$_TABLES['storysubmission']}` ADD bodytext TEXT AFTER introtext";

// new comment code: close comments
$_SQL[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (1,'Comments Closed')";

// add owner-field to links-submission
$_SQL[] = "ALTER TABLE {$_TABLES['linksubmission']} ADD owner_id mediumint(8) unsigned NOT NULL default '1';";

// update plugin version numbers
$_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '1.1', pi_gl_version = '1.4.1' WHERE pi_name = 'links'";

// Increase block function size to accept arguments:
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} CHANGE phpblockfn phpblockfn VARCHAR(128)";

// New fields to store HTTP Last-Modified and ETag headers
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdf_last_modified VARCHAR(40) DEFAULT NULL AFTER rdfupdated";
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD rdf_etag VARCHAR(40) DEFAULT NULL AFTER rdf_last_modified";

function upgrade_PollsPlugin()
{
    global $_TABLES;

    // Polls plugin updates
    $check_sql = "SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_name = 'polls';";
    $check_rst = DB_query ($check_sql);
    if (DB_numRows($check_rst) == 1) {
        $P_SQL = array();
        $P_SQL[] = "RENAME TABLE `{$_TABLES['pollquestions']}` TO `{$_TABLES['polltopics']}`;";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` CHANGE `question` `topic` VARCHAR( 255 )  NULL DEFAULT NULL";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` CHANGE `qid` `pid` VARCHAR( 20 ) NOT NULL";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` ADD questions int(11) default '0' NOT NULL AFTER voters";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` ADD open tinyint(4) NOT NULL default '1' AFTER display";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` ADD hideresults tinyint(1) NOT NULL default '1' AFTER open";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` CHANGE `qid` `pid` VARCHAR( 20 ) NOT NULL";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` ADD `qid` VARCHAR( 20 ) NOT NULL DEFAULT '0' AFTER `pid`;";
        $P_SQL[] = "ALTER TABLE `{$_TABLES['pollvoters']}` CHANGE `qid` `pid` VARCHAR( 20 ) NOT NULL";
        $P_SQL[] = "CREATE TABLE {$_TABLES['pollquestions']} (
              qid mediumint(9) NOT NULL auto_increment,
              pid varchar(20) NOT NULL,
              question varchar(255) NOT NULL,
              PRIMARY KEY (qid)
            ) TYPE=MyISAM
            ";
        $P_SQL = INST_checkInnodbUpgrade($P_SQL);
        for ($i = 0; $i < count ($P_SQL); $i++) {
            DB_query (current ($P_SQL));
            next ($P_SQL);
        }
        $P_SQL = array();
        $move_sql = "SELECT pid, topic FROM {$_TABLES['polltopics']}";
        $move_rst = DB_query ($move_sql);
        $count_move = DB_numRows($move_rst);
        for ($i=0; $i<$count_move; $i++) {
            $A = DB_fetchArray($move_rst);
            $P_SQL[] = "INSERT INTO {$_TABLES['pollquestions']} (pid, question) VALUES ('{$A[0]}','{$A[1]}');";
        }
        $P_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version = '2.0', pi_gl_version = '1.4.1' WHERE pi_name = 'polls'";
        //var_dump($P_SQL);
        for ($i = 0; $i < count ($P_SQL); $i++) {
            DB_query (current ($P_SQL));
            next ($P_SQL);
        }
    }
}

function upgrade_StaticpagesPlugin()
{
    global $_TABLES;

    // Polls plugin updates
    $check_sql = "SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_name = 'staticpages';";
    $check_rst = DB_query ($check_sql);
    if (DB_numRows($check_rst) == 1) {
        $P_SQL = array();
        $P_SQL[] = "ALTER TABLE `{$_TABLES['staticpage']}` ADD commentcode tinyint(4) NOT NULL default '0' AFTER sp_label";

        $P_SQL = INST_checkInnodbUpgrade($P_SQL);
        for ($i = 0; $i < count ($P_SQL); $i++) {
            DB_query (current ($P_SQL));
            next ($P_SQL);
        }
    }
}

?>
