<?php

$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD is_default tinyint(1) unsigned NOT NULL DEFAULT '0'";

$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD pwrequestid varchar(16) DEFAULT NULL";

$_SQL[] = "CREATE TABLE {$_TABLES['speedlimit']} (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  type varchar(30) NOT NULL default 'submit',
  PRIMARY KEY (id)
) TYPE = MyISAM";

$_SQL[] = "DROP TABLES {$_TABLES['commentspeedlimit']}";
$_SQL[] = "DROP TABLES {$_TABLES['submitspeedlimit']}";

?>
