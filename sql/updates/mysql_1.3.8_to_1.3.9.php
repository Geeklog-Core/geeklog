<?php

$_SQL[] = "CREATE TABLE {$_TABLES['syndication']} (
  fid int unsigned NOT NULL auto_increment,
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
$_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} CHANGE sp_id sp_id VARCHAR(40) NOT NULL";

// change "remember me" option to 1 Month for those who had it at 1 Year
$_SQL[] = "UPDATE {$_TABLES['users']} SET cookietimeout = 2678400 WHERE cookietimeout = 31536000";

// remove '1 Year' option
$_SQL[] = "DELETE FROM {$_TABLES['cookiecodes']} WHERE cc_value = 31536000";

?>
