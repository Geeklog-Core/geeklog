<?php

$_SQL[] = "CREATE TABLE {$_TABLES['syndication']} (
  fid int(10) unsigned NOT NULL auto_increment,
  type varchar(30) NOT NULL default 'geeklog',
  topic varchar(48) NOT NULL default '::all',
  format varchar(20) NOT NULL default 'rss',
  limits varchar(5) NOT NULL default '10',
  content_length smallint(5) unsigned NOT NULL default '0',
  title varchar(40) NOT NULL default '',
  description text,
  filename varchar(40) NOT NULL default 'geeklog.rdf',
  charset varchar(20) NOT NULL default 'UTF-8',
  language varchar(20) NOT NULL default 'en-gb',
  is_enabled tinyint(1) unsigned NOT NULL default '1',
  updated datetime NOT NULL default '0000-00-00 00:00:00',
  update_info text,
  PRIMARY KEY (fid),
  INDEX syndication_type(type),
  INDEX syndication_is_enabled(is_enabled),
  INDEX syndication_updated(updated)
) TYPE=MyISAM";

// remove unused entry (moved to 'syndication' table)
$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = 'rdf_sids'";

// extend max. length of static page IDs to 40 characters
$_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} CHANGE sp_id sp_id varchar(40) NOT NULL";

// change "remember me" option to 1 Month for those who had it at 1 Year
$_SQL[] = "UPDATE {$_TABLES['users']} SET cookietimeout = 2678400 WHERE cookietimeout = 31536000";

// remove '1 Year' option, add "(don't)" option, sort table
$_SQL[] = "DELETE FROM {$_TABLES['cookiecodes']} WHERE cc_value = 31536000";
$_SQL[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (0,'(don\'t)')";
$_SQL[] = "ALTER TABLE {$_TABLES['cookiecodes']} ORDER BY cc_value";

// extend max. length of all URL fields to 255 characters
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} CHANGE rdfurl rdfurl varchar(255) default NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['events']} CHANGE url url varchar(255) default NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['eventsubmission']} CHANGE url url varchar(255) default NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['links']} CHANGE url url varchar(255) default NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['linksubmission']} CHANGE url url varchar(255) default NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['personal_events']} CHANGE url url varchar(255) default NULL";
$_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE imageurl imageurl varchar(255) default NULL";

// change 'blockorder' to accept values > 255 (added in 1.3.9rc2)
$_SQL[] = "ALTER TABLE {$_TABLES['blocks']} CHANGE blockorder blockorder smallint(5) unsigned NOT NULL default '1'";

?>
