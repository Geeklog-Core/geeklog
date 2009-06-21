<?php

$_SQL[] = "ALTER TABLE {$_TABLES['topics']} ADD is_default tinyint(1) unsigned NOT NULL DEFAULT '0'";

$_SQL[] = "ALTER TABLE {$_TABLES['users']} ADD pwrequestid varchar(16) DEFAULT NULL";

$_SQL[] = "ALTER TABLE {$_TABLES['userinfo']} ADD lastlogin VARCHAR( 10 ) NOT NULL";

$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} ADD emailfromuser tinyint(1) NOT NULL default '1'";
$_SQL[] = "ALTER TABLE {$_TABLES['userprefs']} ADD showonline tinyint(1) NOT NULL default '1'";

$_SQL[] = "CREATE TABLE {$_TABLES['speedlimit']} (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  type varchar(30) NOT NULL default 'submit',
  PRIMARY KEY (id)
) TYPE = MyISAM";

$_SQL[] = "DROP TABLE {$_TABLES['commentspeedlimit']}";
$_SQL[] = "DROP TABLE {$_TABLES['submitspeedlimit']}";

?>
