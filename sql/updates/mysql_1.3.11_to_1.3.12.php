<?php

$_SQL[] = "CREATE TABLE {$_TABLES['trackback']} (
  cid int(10) unsigned NOT NULL auto_increment, 
  sid varchar(40) NOT NULL, 
  url varchar(255) default NULL,
  title varchar(128) default NULL,
  blog varchar(80) default NULL, 
  excerpt text,
  date datetime default NULL,
  type varchar(30) NOT NULL default 'article',
  ipaddress varchar(15) NOT NULL default '',
  PRIMARY KEY (cid),
  INDEX trackback_sid(sid), 
  INDEX trackback_date(date), 
  INDEX trackback_type(type)
) TYPE=MyISAM";

?>
