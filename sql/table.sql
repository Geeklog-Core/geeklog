# MySQL dump 7.1
#
# Host: localhost    Database: geeklog 
#--------------------------------------------------------
# Server version	3.22.32

#
# Table structure for table 'blocks'
#
CREATE TABLE blocks (
  bid smallint(5) unsigned DEFAULT '0' NOT NULL auto_increment,
  title varchar(48),
  tid varchar(20) DEFAULT 'All' NOT NULL,
  seclev tinyint(3) unsigned DEFAULT '255' NOT NULL,
  blockorder tinyint(3) unsigned DEFAULT '1' NOT NULL,
  type varchar(20) DEFAULT 'normal' NOT NULL,
  rdfurl varchar(96),
  rdfupdated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  content text,
  onleft tinyint(3) unsigned DEFAULT '1' NOT NULL,
  phpblockfn varchar(64) DEFAULT '',
  PRIMARY KEY (bid)
);

#Mandatory Data for blocks
INSERT INTO blocks VALUES (1,'blockheader','all',255,0,'layout','','0000-00-00 00:00:00','<table border=0 cellpadding=1 cellspacing=0 width=\"100%\"><tr bgcolor=666666><td>\r\n<table width=\"100%\" border=0 cellspacing=0 cellpadding=2>\r\n<tr bgcolor=666666><td class=blocktitle>%title</td><td align=right>%help</td></tr>\r\n<tr><td bgcolor=FFFFFF colspan=2>','',1);
INSERT INTO blocks VALUES (2,'blockfooter','all',255,0,'layout','','0000-00-00 00:00:00','</td></tr></table>\r\n</td></tr></table><br>','',1);
INSERT INTO blocks VALUES (3,'Events Block','all',255,2,'gldefault','','0000-00-00 00:00:00','','',1);
INSERT INTO blocks VALUES (4,'Section Block','all',255,0,'gldefault','','0000-00-00 00:00:00','','',1);
INSERT INTO blocks VALUES (5,'Poll Block','all',255,2,'gldefault','','0000-00-00 00:00:00','','',0);
INSERT INTO blocks VALUES (6,'User Block','all',255,1,'gldefault','','0000-00-00 00:00:00','','',1);
INSERT INTO blocks VALUES (7,'Whats New Block','all',255,3,'gldefault','','0000-00-00 00:00:00','','',1);


#
# Table structure for table 'commentcodes'
#
CREATE TABLE commentcodes (
  code tinyint(4) DEFAULT '0' NOT NULL,
  name varchar(32),
  PRIMARY KEY (code)
);

#
# Table structure for table 'commentmodes'
#
CREATE TABLE commentmodes (
  mode varchar(10) DEFAULT '' NOT NULL,
  name varchar(32),
  PRIMARY KEY (mode)
);

#
# Table structure for table 'comments'
#
CREATE TABLE comments (
  cid int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
  sid varchar(20) DEFAULT '' NOT NULL,
  date datetime,
  title varchar(128),
  comment text,
  score tinyint(4) DEFAULT '0' NOT NULL,
  reason tinyint(4) DEFAULT '0' NOT NULL,
  pid int(10) unsigned DEFAULT '0' NOT NULL,
  uid mediumint(8) DEFAULT '1' NOT NULL,
  PRIMARY KEY (cid)
);

#
# Table structure for table 'commentspeedlimit'
#
CREATE TABLE commentspeedlimit (
  id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
  ipaddress varchar(15) DEFAULT '' NOT NULL,
  date int(10) unsigned,
  PRIMARY KEY (id)
);

#
# Table structure for table 'dateformats'
#
CREATE TABLE dateformats (
  dfid tinyint(4) DEFAULT '0' NOT NULL,
  format varchar(32),
  description varchar(64),
  PRIMARY KEY (dfid)
);

#
# Table structure for table 'events'
#
CREATE TABLE events (
  eid varchar(20) DEFAULT '' NOT NULL,
  title varchar(128),
  description text,
  location text,
  datestart date,
  dateend date,
  url varchar(128),
  PRIMARY KEY (eid)
);

#
# Table structure for table 'eventsubmission'
#
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

#
# Table structure for table 'featurecodes'
#
CREATE TABLE featurecodes (
  code tinyint(4) DEFAULT '0' NOT NULL,
  name varchar(32),
  PRIMARY KEY (code)
);

#
# Table structure for table 'frontpagecodes'
#
CREATE TABLE frontpagecodes (
  code tinyint(4) DEFAULT '0' NOT NULL,
  name varchar(32),
  PRIMARY KEY (code)
);

#
# Table structure for table 'links'
#
CREATE TABLE links (
  lid varchar(20) DEFAULT '' NOT NULL,
  category varchar(32),
  url varchar(96),
  description text,
  title varchar(96),
  hits int(11) DEFAULT '0' NOT NULL,
  date datetime,
  PRIMARY KEY (lid)
);

#
# Table structure for table 'linksubmission'
#
CREATE TABLE linksubmission (
  lid varchar(20) DEFAULT '' NOT NULL,
  category varchar(32),
  url varchar(96),
  description text,
  title varchar(96),
  hits int(11),
  date datetime,
  PRIMARY KEY (lid)
);

#
# Table structure for table 'maillist'
#
CREATE TABLE maillist (
  code int(1) DEFAULT '0' NOT NULL,
  name char(32),
  PRIMARY KEY (code)
);

#
# Table structure for table 'pollanswers'
#
CREATE TABLE pollanswers (
  qid varchar(20) DEFAULT '' NOT NULL,
  aid tinyint(3) unsigned DEFAULT '0' NOT NULL,
  answer varchar(255),
  votes mediumint(8) unsigned,
  PRIMARY KEY (qid,aid)
);

#
# Table structure for table 'pollquestions'
#
CREATE TABLE pollquestions (
  qid varchar(20) DEFAULT '' NOT NULL,
  question varchar(255),
  voters mediumint(8) unsigned,
  date datetime,
  display tinyint(4) DEFAULT '0' NOT NULL,
  commentcode tinyint(4) DEFAULT '0' NOT NULL,
  statuscode tinyint(4) DEFAULT '0' NOT NULL,
  PRIMARY KEY (qid)
);

#
# Table structure for table 'pollvoters'
#
CREATE TABLE pollvoters (
  id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
  qid varchar(20) DEFAULT '' NOT NULL,
  ipaddress varchar(15) DEFAULT '' NOT NULL,
  date int(10) unsigned,
  PRIMARY KEY (id)
);

#
# Table structure for table 'postmodes'
#
CREATE TABLE postmodes (
  code char(10) DEFAULT '' NOT NULL,
  name char(32),
  PRIMARY KEY (code)
);

#
# Table structure for table 'sessions'
#
CREATE TABLE sessions (
  sess_id int(10) unsigned DEFAULT '0' NOT NULL,
  start_time int(10) unsigned DEFAULT '0' NOT NULL,
  remote_ip varchar(15) DEFAULT '' NOT NULL,
  uid mediumint(8) DEFAULT '1' NOT NULL,
  md5_sess_id varchar(128),
  PRIMARY KEY (sess_id),
  KEY sess_id (sess_id),
  KEY start_time (start_time),
  KEY remote_ip (remote_ip)
);

#
# Table structure for table 'sortcodes'
#
CREATE TABLE sortcodes (
  code char(4) DEFAULT '0' NOT NULL,
  name char(32),
  PRIMARY KEY (code)
);

#
# Table structure for table 'statuscodes'
#
CREATE TABLE statuscodes (
  code int(1) DEFAULT '0' NOT NULL,
  name char(32),
  PRIMARY KEY (code)
);

#
# Table structure for table 'stories'
#
CREATE TABLE stories (
  sid varchar(20) DEFAULT '' NOT NULL,
  uid mediumint(8) DEFAULT '1' NOT NULL,
  tid varchar(20) DEFAULT 'General' NOT NULL,
  title varchar(128),
  introtext text,
  bodytext text,
  hits mediumint(8) unsigned DEFAULT '0' NOT NULL,
  date datetime,
  comments mediumint(8) unsigned DEFAULT '0' NOT NULL,
  related text,
  featured tinyint(3) unsigned DEFAULT '0' NOT NULL,
  commentcode tinyint(4) DEFAULT '0' NOT NULL,
  statuscode tinyint(4) DEFAULT '0' NOT NULL,
  postmode varchar(10) DEFAULT 'html' NOT NULL,
  frontpage tinyint(3) unsigned DEFAULT '0',
  draft_flag tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (sid)
);

#
# Table structure for table 'storysubmission'
#
CREATE TABLE storysubmission (
  sid varchar(20) DEFAULT '' NOT NULL,
  uid mediumint(8) DEFAULT '1' NOT NULL,
  tid varchar(20) DEFAULT 'General' NOT NULL,
  title varchar(128),
  introtext text,
  date datetime,
  postmode varchar(10) DEFAULT 'html' NOT NULL,
  PRIMARY KEY (sid)
);

#
# Table structure for table 'submitspeedlimit'
#
CREATE TABLE submitspeedlimit (
  id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
  ipaddress varchar(15) DEFAULT '' NOT NULL,
  date int(10) unsigned,
  PRIMARY KEY (id)
);

#
# Table structure for table 'topics'
#
CREATE TABLE topics (
  tid varchar(20) DEFAULT '' NOT NULL,
  topic varchar(48),
  imageurl varchar(96),
  sortnum tinyint(3),
  limitnews tinyint(3),
  PRIMARY KEY (tid)
);

#
# Table structure for table 'tzcodes'
#
CREATE TABLE tzcodes (
  tz char(3) DEFAULT '' NOT NULL,
  offset int(1),
  description varchar(64),
  PRIMARY KEY (tz)
);

#
# Table structure for table 'usercomment'
#
CREATE TABLE usercomment (
  uid mediumint(8) DEFAULT '1' NOT NULL,
  commentmode varchar(10) DEFAULT 'threaded' NOT NULL,
  commentorder varchar(4) DEFAULT 'ASC' NOT NULL,
  commentlimit mediumint(8) unsigned DEFAULT '100' NOT NULL,
  PRIMARY KEY (uid)
);

#
# Table structure for table 'userevent'
#
CREATE TABLE userevent (
  uid mediumint(8) DEFAULT '1' NOT NULL,
  eid varchar(20) DEFAULT '' NOT NULL,
  PRIMARY KEY (uid,eid)
);

#
# Table structure for table 'userindex'
#
CREATE TABLE userindex (
  uid mediumint(8) DEFAULT '1' NOT NULL,
  tids varchar(255) DEFAULT '' NOT NULL,
  aids varchar(255) DEFAULT '' NOT NULL,
  boxes varchar(255) DEFAULT '' NOT NULL,
  noboxes tinyint(4) DEFAULT '0' NOT NULL,
  maxstories tinyint(4),
  PRIMARY KEY (uid)
);

#
# Table structure for table 'userinfo'
#
CREATE TABLE userinfo (
  uid mediumint(8) DEFAULT '1' NOT NULL,
  about text,
  pgpkey text,
  userspace varchar(255) DEFAULT '' NOT NULL,
  tokens tinyint(3) unsigned DEFAULT '0' NOT NULL,
  totalcomments mediumint(9) DEFAULT '0' NOT NULL,
  lastgranted int(10) unsigned DEFAULT '0' NOT NULL,
  PRIMARY KEY (uid)
);

#
# Table structure for table 'userprefs'
#
CREATE TABLE userprefs (
  uid mediumint(8) DEFAULT '1' NOT NULL,
  noicons tinyint(3) unsigned DEFAULT '0' NOT NULL,
  willing tinyint(3) unsigned DEFAULT '1' NOT NULL,
  dfid tinyint(3) unsigned DEFAULT '0' NOT NULL,
  tzid char(3) DEFAULT 'edt' NOT NULL,
  emailstories tinyint(4) DEFAULT '1' NOT NULL,
  PRIMARY KEY (uid)
);

#
# Table structure for table 'users'
#
CREATE TABLE users (
  uid mediumint(8) DEFAULT '0' NOT NULL auto_increment,
  username varchar(16) DEFAULT '' NOT NULL,
  fullname varchar(80),
  passwd varchar(32) DEFAULT '' NOT NULL,
  seclev tinyint(3) unsigned DEFAULT '0' NOT NULL,
  email varchar(96),
  homepage varchar(96),
  sig varchar(160) DEFAULT '' NOT NULL,
  PRIMARY KEY (uid),
  KEY LOGIN (uid,passwd,username)
);

#
# Table structure for table 'vars'
#
CREATE TABLE vars (
  name varchar(20) DEFAULT '' NOT NULL,
  value varchar(128),
  PRIMARY KEY (name)
);

#
# Table structure for table 'plugins'
#
CREATE TABLE plugins(
        pi_name varchar(30) DEFAULT '' NOT NULL,
        pi_version varchar(20) DEFAULT '' NOT NULL,
        pi_gl_version varchar(20) DEFAULT '' NOT NULL,
        pi_enabled tinyint(3) unsigned DEFAULT '1' NOT NULL,
        pi_homepage varchar(128) DEFAULT '' NOT NULL,
        PRIMARY KEY(pi_name)
);
