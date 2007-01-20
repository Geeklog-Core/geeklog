<?php

// remove time zone table since its included into PEAR now
$_SQL[] = "DROP TABLE " . $_DB_table_prefix . 'tzcodes';
$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} CHANGE `tzid` `tzid` VARCHAR(125) NOT NULL DEFAULT ''";
// change former default values to '' so users dont all have edt for no reason
$_SQL[] = "UPDATE `{$_TABLES['userprefs']}` set tzid = ''";
// User submissions may have body text.
$_SQL[] = "ALTER TABLE `{$_TABLES['storysubmission']}` ADD bodytext TEXT AFTER introtext";

// Poll plugin updates
$_SQL[] = "RENAME TABLE `{$_TABLES['pollquestions']}` TO `{$_TABLES['polltopics']}`;";
$_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` CHANGE `question` `topic` VARCHAR( 255 )  NULL DEFAULT NULL";
$_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` CHANGE `qid` `pid` VARCHAR( 20 ) NOT NULL";
$_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` ADD questions int(11) NOT NULL AFTER voters";
$_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` ADD open tinyint(4) NOT NULL AFTER display";
$_SQL[] = "ALTER TABLE `{$_TABLES['polltopics']}` ADD hideresults tinyint(1) NOT NULL AFTER open";
$_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` CHANGE `qid` `pid` VARCHAR( 20 ) NOT NULL";
$_SQL[] = "ALTER TABLE `{$_TABLES['pollanswers']}` ADD `qid` VARCHAR( 20 ) NOT NULL DEFAULT '0' AFTER `pid`;";
$_SQL[] = "ALTER TABLE `{$_TABLES['pollvoters']}` CHANGE `qid` `pid` VARCHAR( 20 ) NOT NULL";
$_SQL[] = "CREATE TABLE {$_TABLES['pollquestions']} (
      qid mediumint(9) NOT NULL DEFAULT '0',
      pid varchar(20) NOT NULL,
      question varchar(255) NOT NULL,
      PRIMARY KEY (qid)
    ) TYPE=MyISAM
    ";

$_SQL[] = "INSERT INTO {$_TABLES['pollquestions']} (pid, question) SELECT pid, topic FROM {$_TABLES['polltopics']}";

?>
