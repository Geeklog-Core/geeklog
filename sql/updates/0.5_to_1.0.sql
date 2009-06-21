ALTER TABLE links MODIFY lid varchar(20) DEFAULT '' NOT NULL;
ALTER TABLE links MODIFY hits int(11) DEFAULT '0' NOT NULL;
ALTER TABLE comments ADD uid mediumint(8) DEFAULT '-1' NOT NULL;
ALTER TABLE comments DROP name;
ALTER TABLE comments DROP email;
ALTER TABLE comments DROP url;
ALTER TABLE stories DROP author;
ALTER TABLE stories DROP authoremail;
ALTER TABLE stories DROP authorurl;
ALTER TABLE stories MODIFY uid mediumint(8) DEFAULT '-1' NOT NULL;
ALTER TABLE users MODIFY uid mediumint(8) DEFAULT '-1' NOT NULL auto_increment;
INSERT INTO users VALUES (-1,'Anonymous','Anonymous',NULL,NULL,NULL,NULL);
INSERT INTO blocks VALUES (0,'blockheader','all',255,0,'layout','','0000-00-00 00:00:00','<table border=0 cellpadding=1 cellspacing=0 width=\"100%\"><tr bgcolor=666666><td>\r\n<table width=\"100%\" border=0 cellspacing=0 cellpadding=2>\r\n<tr bgcolor=666666><td class=blocktitle>%title</td><td align=right>%help</td></tr>\r\n<tr><td bgcolor=FFFFFF colspan=2>');
INSERT INTO blocks VALUES (0,'blockfooter','all',255,0,'layout','','0000-00-00 00:00:00','</td></tr></table>\r\n</td></tr></table><br>');

CREATE TABLE eventsubmission (
  eid varchar(20) DEFAULT '' NOT NULL,
  title varchar(128),
  description text,
  location text,
  datestart date,
  dateend date,
  url varchar(128),
  PRIMARY KEY (eid)
);

CREATE TABLE linksubmission (
  lid varchar(20) DEFAULT '' NOT NULL,
  category varchar(32),
  url varchar(96),
  description text,
  title varchar(96),
  hits int(11),
  PRIMARY KEY (lid)
);

CREATE TABLE storysubmission (
  sid varchar(20) DEFAULT '' NOT NULL,
  uid mediumint(8) DEFAULT '-1' NOT NULL,
  tid varchar(20) DEFAULT 'General' NOT NULL,
  title varchar(128),
  introtext text,
  date datetime,
  PRIMARY KEY (sid)
);

CREATE TABLE vars (
  name varchar(20) DEFAULT '' NOT NULL,
  value varchar(128),
  PRIMARY KEY (name)
);

CREATE TABLE userinfo (
  uid mediumint(8) unsigned DEFAULT '0' NOT NULL,
  about text,
  pgpkey text,
  PRIMARY KEY (uid)
);

CREATE TABLE userprefs (
  uid mediumint(8) unsigned DEFAULT '0' NOT NULL,
  emailstories tinyint(3),
  PRIMARY KEY (uid)
);

CREATE TABLE submitspeedlimit (
  id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
  ipaddress varchar(15) DEFAULT '' NOT NULL,
  date int(10) unsigned,
  PRIMARY KEY (id)
);

CREATE TABLE commentspeedlimit (
  id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
  ipaddress varchar(15) DEFAULT '' NOT NULL,
  date int(10) unsigned,
  PRIMARY KEY (id)
);