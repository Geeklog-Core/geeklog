<?php

// remove time zone table since its included into PEAR now
$_SQL[] = "DROP TABLE " . $_DB_table_prefix . 'tzcodes';
$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} CHANGE `tzid` `tzid` VARCHAR(125) NOT NULL DEFAULT ''";
// change former default values to '' so users dont all have edt for no reason
$_SQL[] = "UPDATE `{$_TABLES['userprefs']}` set tzid = ''";
// User submissions may have body text.
$_SQL[] = "ALTER TABLE `{$_TABLES['storysubmission']}` ADD bodytext TEXT AFTER introtext";
?>
