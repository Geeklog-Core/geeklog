CREATE TABLE {$_TABLES['spamx']} (
  name varchar(20) NOT NULL default '',
  value varchar(255) NOT NULL default '',
  INDEX blocks_type(type)
) TYPE=MyISAM;