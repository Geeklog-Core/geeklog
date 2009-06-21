ALTER TABLE blocks MODIFY COLUMN bid smallint unsigned DEFAULT '0' NOT NULL auto_increment;
ALTER TABLE blocks MODIFY COLUMN tid varchar(20) DEFAULT 'All' NOT NULL;

ALTER TABLE comments MODIFY COLUMN cid int unsigned DEFAULT '0' NOT NULL auto_increment;
ALTER TABLE comments ADD COLUMN pid int unsigned;

ALTER TABLE calendar RENAME AS events;

ALTER TABLE pollanswers MODIFY COLUMN qid varchar(20) DEFAULT '' NOT NULL;
ALTER TABLE pollanswers MODIFY COLUMN aid tinyint unsigned DEFAULT '0' NOT NULL;
ALTER TABLE pollanswers MODIFY COLUMN answer varchar(255);
ALTER TABLE pollanswers MODIFY COLUMN votes mediumint unsigned;

ALTER TABLE pollquestions MODIFY COLUMN qid varchar(20) DEFAULT '' NOT NULL;
ALTER TABLE pollquestions MODIFY COLUMN question varchar(255);
ALTER TABLE pollquestions MODIFY COLUMN voters mediumint unsigned;

CREATE TABLE pollvoters (
  id int unsigned DEFAULT '0' NOT NULL auto_increment,
  qid varchar(20) DEFAULT '' NOT NULL,
  ipaddress char(15) DEFAULT '' NOT NULL,
  date int unsigned,
  PRIMARY KEY (id)
);

ALTER TABLE stories MODIFY COLUMN uid mediumint unsigned DEFAULT '0' NOT NULL;
ALTER TABLE stories CHANGE COLUMN content introtext text;
ALTER TABLE stories ADD COLUMN bodytext text;
ALTER TABLE stories MODIFY COLUMN hits mediumint unsigned DEFAULT '0' NOT NULL;
ALTER TABLE stories ADD COLUMN comments mediumint unsigned DEFAULT '0' NOT NULL;

ALTER TABLE users MODIFY COLUMN uid mediumint unsigned DEFAULT '0' NOT NULL auto_increment;