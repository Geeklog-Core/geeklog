# MySQL dump 8.14
#
# Host: localhost    Database: lsw_dev
#--------------------------------------------------------
# Server version	3.23.39

#
# Table structure for table 'attribute'
#

CREATE TABLE attribute (
  att_id mediumint(10) unsigned NOT NULL auto_increment,
  att_type tinyint(3) unsigned NOT NULL default '0',
  att_parent_id mediumint(10) unsigned NOT NULL default '0',
  att_min_value varchar(10) default NULL,
  att_max_value varchar(10) default NULL,
  att_required tinyint(3) unsigned NOT NULL default '1',
  PRIMARY KEY  (att_id)
) TYPE=MyISAM;

#
# Dumping data for table 'attribute'
#


#
# Table structure for table 'attribute_value'
#

CREATE TABLE attribute_value (
  av_att_id mediumint(10) unsigned NOT NULL default '0',
  av_item_id mediumint(10) unsigned NOT NULL default '0',
  av_value varchar(10) default NULL,
  PRIMARY KEY  (av_att_id,av_item_id)
) TYPE=MyISAM;

#
# Dumping data for table 'attribute_value'
#


#
# Table structure for table 'blocks'
#

CREATE TABLE blocks (
  bid smallint(5) unsigned NOT NULL auto_increment,
  title varchar(48) default NULL,
  tid varchar(20) NOT NULL default 'All',
  seclev tinyint(3) unsigned NOT NULL default '255',
  blockorder tinyint(3) unsigned NOT NULL default '1',
  type varchar(20) NOT NULL default 'normal',
  rdfurl varchar(96) default NULL,
  rdfupdated datetime NOT NULL default '0000-00-00 00:00:00',
  content text,
  PRIMARY KEY  (bid)
) TYPE=MyISAM;

#
# Dumping data for table 'blocks'
#

INSERT INTO blocks VALUES (1,'GeekLog 1.2','all',200,1,'normal','','0000-00-00 00:00:00','Welcome to GeekLog 1.2!  There have been many improvments to GeekLog since 1.1.  Please read the release notes in the /docs directory and go over the install guide.');
INSERT INTO blocks VALUES (3,'blockheader','all',255,0,'layout','','0000-00-00 00:00:00','<table border=0 cellpadding=1 cellspacing=0 width=\"100%\"><tr bgcolor=666666><td>\r\n<table width=\"100%\" border=0 cellspacing=0 cellpadding=2>\r\n<tr bgcolor=666666><td class=blocktitle>%title</td><td align=right>%help</td></tr>\r\n<tr><td bgcolor=FFFFFF colspan=2>');
INSERT INTO blocks VALUES (4,'blockfooter','all',255,0,'layout','','0000-00-00 00:00:00','</td></tr></table>\r\n</td></tr></table><br>');

#
# Table structure for table 'catalog'
#

CREATE TABLE catalog (
  ctg_id mediumint(10) unsigned NOT NULL auto_increment,
  ctg_name varchar(50) default NULL,
  ctg_desc text,
  PRIMARY KEY  (ctg_id)
) TYPE=MyISAM;

#
# Dumping data for table 'catalog'
#


#
# Table structure for table 'category'
#

CREATE TABLE category (
  cg_id mediumint(10) unsigned NOT NULL auto_increment,
  cg_ctg_id mediumint(10) unsigned NOT NULL default '0',
  cg_name varchar(50) NOT NULL default '',
  cg_desc text,
  cg_text text,
  cg_isvisible tinyint(3) unsigned NOT NULL default '1',
  cg_sortnum mediumint(8) unsigned NOT NULL default '0',
  cg_alt_url varchar(100) default NULL,
  cg_parent_cg_id mediumint(10) unsigned default NULL,
  PRIMARY KEY  (cg_id)
) TYPE=MyISAM;

#
# Dumping data for table 'category'
#


#
# Table structure for table 'category_item'
#

CREATE TABLE category_item (
  ci_cg_id mediumint(10) unsigned NOT NULL default '0',
  ci_item_id mediumint(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (ci_cg_id,ci_item_id)
) TYPE=MyISAM;

#
# Dumping data for table 'category_item'
#


#
# Table structure for table 'commentcodes'
#

CREATE TABLE commentcodes (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Dumping data for table 'commentcodes'
#

INSERT INTO commentcodes VALUES (0,'Comments Enabled');
INSERT INTO commentcodes VALUES (1,'Read-Only');
INSERT INTO commentcodes VALUES (-1,'Comments Disabled');

#
# Table structure for table 'commentmodes'
#

CREATE TABLE commentmodes (
  mode varchar(10) NOT NULL default '',
  name varchar(32) default NULL,
  PRIMARY KEY  (mode)
) TYPE=MyISAM;

#
# Dumping data for table 'commentmodes'
#

INSERT INTO commentmodes VALUES ('flat','Flat');
INSERT INTO commentmodes VALUES ('nested','Nested');
INSERT INTO commentmodes VALUES ('threaded','Threaded');
INSERT INTO commentmodes VALUES ('nocomment','No Comments');

#
# Table structure for table 'comments'
#

CREATE TABLE comments (
  cid int(10) unsigned NOT NULL auto_increment,
  sid varchar(20) NOT NULL default '',
  date datetime default NULL,
  title varchar(128) default NULL,
  comment text,
  score tinyint(4) NOT NULL default '0',
  reason tinyint(4) NOT NULL default '0',
  pid int(10) unsigned NOT NULL default '0',
  uid mediumint(8) NOT NULL default '1',
  PRIMARY KEY  (cid)
) TYPE=MyISAM;

#
# Dumping data for table 'comments'
#

INSERT INTO comments VALUES (21,'geeklogpollquestion','2001-07-19 14:44:54','I love Geeklog!','I can\'t make up my mind...I love it all!',0,0,0,1);
INSERT INTO comments VALUES (22,'geeklogpollquestion','2001-07-19 14:48:23','We are glad you like it!','We are happy you like Geeklog.  Please be sure to join the <a   href=http://lists.sourceforge.net/lists/listinfo/geeklog-devel target=_new>geeklog mailing</a> list!',0,0,21,2);
INSERT INTO comments VALUES (23,'20010719095630103','2001-07-19 15:02:57','Other Admin accounts','Remember, the admin accounts that come with a fresh Geeklog installation are for demonstration purposes only.  You should delete them if you don\'t plan on using them or at least change their passwords.',0,0,0,2);
INSERT INTO comments VALUES (24,'20010719095630103','2001-07-19 15:07:14','Other Admin accounts','Thanks for the tip!',0,0,23,1);

#
# Table structure for table 'commentspeedlimit'
#

CREATE TABLE commentspeedlimit (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table 'commentspeedlimit'
#

INSERT INTO commentspeedlimit VALUES (1,'192.168.1.13',995557214);

#
# Table structure for table 'dateformats'
#

CREATE TABLE dateformats (
  dfid tinyint(4) NOT NULL default '0',
  format varchar(32) default NULL,
  description varchar(64) default NULL,
  PRIMARY KEY  (dfid)
) TYPE=MyISAM;

#
# Dumping data for table 'dateformats'
#

INSERT INTO dateformats VALUES (0,'','System Default');
INSERT INTO dateformats VALUES (1,'%A %B %d, %Y @%I:%M%p','Sunday March 21, 1999 @10:00PM');
INSERT INTO dateformats VALUES (2,'%A %b %d, %Y @%H:%M','Sunday March 21, 1999 @22:00');
INSERT INTO dateformats VALUES (4,'%A %b %d @%H:%M','Sunday March 21 @22:00');
INSERT INTO dateformats VALUES (5,'%H:%M %d %B %Y','22:00 21 March 1999');
INSERT INTO dateformats VALUES (6,'%H:%M %A %d %B %Y','22:00 Sunday 21 March 1999');
INSERT INTO dateformats VALUES (7,'%I:%M%p - %A %B %d %Y','10:00PM -- Sunday March 21 1999');
INSERT INTO dateformats VALUES (8,'%a %B %d, %I:%M%p','Sun March 21, 10:00PM');
INSERT INTO dateformats VALUES (9,'%a %B %d, %H:%M','Sun March 21, 22:00');
INSERT INTO dateformats VALUES (10,'%m-%d-%y %H:%M','3-21-99 22:00');
INSERT INTO dateformats VALUES (11,'%d-%m-%y %H:%M','21-3-99 22:00');
INSERT INTO dateformats VALUES (12,'%m-%d-%y %I:%M%p','3-21-99 10:00PM');
INSERT INTO dateformats VALUES (13,'%I:%M%p  %B %D, %Y','10:00PM  March 21st, 1999');
INSERT INTO dateformats VALUES (14,'%a %b %d, \'%y %I:%M%p','Sun Mar 21, \'99 10:00PM');
INSERT INTO dateformats VALUES (15,'Day %j, %I ish','Day 80, 10 ish');
INSERT INTO dateformats VALUES (16,'%y-%m-%d %I:%M','99-03-21 10:00');
INSERT INTO dateformats VALUES (17,'%d/%m/%y %H:%M','21/03/99 22:00');
INSERT INTO dateformats VALUES (18,'%a %d %b %I:%M%p','Sun 21 Mar 10:00PM');

#
# Table structure for table 'events'
#

CREATE TABLE events (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  description text,
  location text,
  datestart date default NULL,
  dateend date default NULL,
  url varchar(128) default NULL,
  PRIMARY KEY  (eid)
) TYPE=MyISAM;

#
# Dumping data for table 'events'
#

INSERT INTO events VALUES ('20010719094844825','Geeklog Conference','The greatest geek convention on the planet!','Des Moines, Iowa','2001-08-01','2001-08-04','http://www.geeklog.org');

#
# Table structure for table 'eventsubmission'
#

CREATE TABLE eventsubmission (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  description text,
  location text,
  datestart date default NULL,
  dateend date default NULL,
  url varchar(128) default NULL,
  PRIMARY KEY  (eid)
) TYPE=MyISAM;

#
# Dumping data for table 'eventsubmission'
#


#
# Table structure for table 'featurecodes'
#

CREATE TABLE featurecodes (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Dumping data for table 'featurecodes'
#

INSERT INTO featurecodes VALUES (0,'Not Featured');
INSERT INTO featurecodes VALUES (1,'Featured');

#
# Table structure for table 'frontpagecodes'
#

CREATE TABLE frontpagecodes (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Dumping data for table 'frontpagecodes'
#

INSERT INTO frontpagecodes VALUES (0,'Show Only in Topic');
INSERT INTO frontpagecodes VALUES (1,'Show on Front Page');

#
# Table structure for table 'item'
#

CREATE TABLE item (
  item_id mediumint(10) unsigned NOT NULL auto_increment,
  item_vd_id mediumint(10) unsigned NOT NULL default '0',
  item_name varchar(50) NOT NULL default '',
  item_desc text,
  item_text text,
  item_isvisible tinyint(3) unsigned NOT NULL default '1',
  item_url varchar(150) default NULL,
  PRIMARY KEY  (item_id)
) TYPE=MyISAM;

#
# Dumping data for table 'item'
#


#
# Table structure for table 'links'
#

CREATE TABLE links (
  lid varchar(20) NOT NULL default '',
  category varchar(32) default NULL,
  url varchar(96) default NULL,
  description text,
  title varchar(96) default NULL,
  hits int(11) NOT NULL default '0',
  date datetime default NULL,
  PRIMARY KEY  (lid)
) TYPE=MyISAM;

#
# Dumping data for table 'links'
#

INSERT INTO links VALUES ('20010719095147683','Geeklog Sites','http://www.geeklog.org','The source for stuff...nifty stuff','Geeklog.org',122,NULL);
INSERT INTO links VALUES ('20010719095621775','Geeklog Sites','http://www.devgeek.org','The place to talk about and contribute to the development of Geeklog','DevGeek',78,NULL);
INSERT INTO links VALUES ('2001071910450356','Geeklog Sites','http://www.iowaoutdoors.org','Your source for hunting and fishing information in Iowa.','Iowa Outdoors',1234,NULL);

#
# Table structure for table 'linksubmission'
#

CREATE TABLE linksubmission (
  lid varchar(20) NOT NULL default '',
  category varchar(32) default NULL,
  url varchar(96) default NULL,
  description text,
  title varchar(96) default NULL,
  hits int(11) default NULL,
  date datetime default NULL,
  PRIMARY KEY  (lid)
) TYPE=MyISAM;

#
# Dumping data for table 'linksubmission'
#

INSERT INTO linksubmission VALUES ('20010807144902816','Geeky Sites','http://www.phatgeeks.com','test','Phat Geeks',NULL,NULL);
INSERT INTO linksubmission VALUES ('20010807144933554','Geeklog Sites','http://www.tonybibbs.com','test','TBibbs.com',NULL,NULL);

#
# Table structure for table 'maillist'
#

CREATE TABLE maillist (
  code int(1) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Dumping data for table 'maillist'
#

INSERT INTO maillist VALUES (0,'Don\'t Email');
INSERT INTO maillist VALUES (1,'Email Headlines Each Night');

#
# Table structure for table 'photos'
#

CREATE TABLE photos (
  pid varchar(20) NOT NULL default '',
  uid mediumint(8) NOT NULL default '-1',
  category varchar(32) NOT NULL default '',
  isprivate tinyint(3) unsigned NOT NULL default '1',
  title varchar(128) default NULL,
  picturetext text,
  hits mediumint(8) unsigned NOT NULL default '0',
  date datetime default NULL,
  comments mediumint(8) unsigned NOT NULL default '0',
  related text,
  featured tinyint(3) unsigned NOT NULL default '0',
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  filename varchar(128) NOT NULL default '',
  postmode varchar(10) NOT NULL default 'html',
  PRIMARY KEY  (pid)
) TYPE=MyISAM;

#
# Dumping data for table 'photos'
#

INSERT INTO photos VALUES ('20000802190608154',2,'Deer Hunting',0,'Test Image','This is a test picture. It is a monster buck taken from central Iowa',13,'2000-08-02 19:06:08',0,NULL,1,0,0,'20000802190608154_iowabuck.jpg','html');
INSERT INTO photos VALUES ('20010808173907216',1,'Other',1,'test','test',2,'2001-08-08 17:39:07',0,NULL,0,0,0,'20010808173907216_big_creek_bass.JPG','html');

#
# Table structure for table 'photossubmission'
#

CREATE TABLE photossubmission (
  pid varchar(20) NOT NULL default '',
  uid mediumint(8) NOT NULL default '-1',
  category varchar(32) NOT NULL default '',
  isprivate tinyint(3) unsigned NOT NULL default '1',
  title varchar(128) default NULL,
  picturetext text,
  date datetime default NULL,
  postmode varchar(10) NOT NULL default 'html',
  filename varchar(128) NOT NULL default '',
  PRIMARY KEY  (pid)
) TYPE=MyISAM;

#
# Dumping data for table 'photossubmission'
#


#
# Table structure for table 'plugins'
#

CREATE TABLE plugins (
  pi_name varchar(30) NOT NULL default '',
  pi_version varchar(20) NOT NULL default '',
  pi_gl_version varchar(20) NOT NULL default '',
  pi_enabled tinyint(3) unsigned NOT NULL default '1',
  pi_homepage varchar(100) default NULL,
  PRIMARY KEY  (pi_name)
) TYPE=MyISAM;

#
# Dumping data for table 'plugins'
#

INSERT INTO plugins VALUES ('photos','0.1.0','1.2.2',1,'http://www.iowaoutdoors.org');

#
# Table structure for table 'pollanswers'
#

CREATE TABLE pollanswers (
  qid varchar(20) NOT NULL default '',
  aid tinyint(3) unsigned NOT NULL default '0',
  answer varchar(255) default NULL,
  votes mediumint(8) unsigned default NULL,
  PRIMARY KEY  (qid,aid)
) TYPE=MyISAM;

#
# Dumping data for table 'pollanswers'
#

INSERT INTO pollanswers VALUES ('geeklogpollquestion',3,'Polls',20);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',2,'Calendar',5);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',1,'Administration Tools',12);
INSERT INTO pollanswers VALUES ('geeklogpollquestion',4,'Other',7);

#
# Table structure for table 'pollquestions'
#

CREATE TABLE pollquestions (
  qid varchar(20) NOT NULL default '',
  question varchar(255) default NULL,
  voters mediumint(8) unsigned default NULL,
  date datetime default NULL,
  display tinyint(4) NOT NULL default '0',
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (qid)
) TYPE=MyISAM;

#
# Dumping data for table 'pollquestions'
#

INSERT INTO pollquestions VALUES ('geeklogpollquestion','What is the best feature of Geeklog?',44,'2001-07-19 09:43:50',1,0,1);

#
# Table structure for table 'pollvoters'
#

CREATE TABLE pollvoters (
  id int(10) unsigned NOT NULL auto_increment,
  qid varchar(20) NOT NULL default '',
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table 'pollvoters'
#


#
# Table structure for table 'postmodes'
#

CREATE TABLE postmodes (
  code char(10) NOT NULL default '',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Dumping data for table 'postmodes'
#

INSERT INTO postmodes VALUES ('plaintext','Plain Old Text');
INSERT INTO postmodes VALUES ('html','HTML Formatted');

#
# Table structure for table 'sessions'
#

CREATE TABLE sessions (
  sess_id int(10) unsigned NOT NULL default '0',
  start_time int(10) unsigned NOT NULL default '0',
  remote_ip varchar(15) NOT NULL default '',
  uid mediumint(8) NOT NULL default '1',
  md5_sess_id varchar(128) default NULL,
  PRIMARY KEY  (sess_id),
  KEY sess_id (sess_id),
  KEY start_time (start_time),
  KEY remote_ip (remote_ip)
) TYPE=MyISAM;

#
# Dumping data for table 'sessions'
#

INSERT INTO sessions VALUES (837358345,997459459,'127.0.0.1',2,'e029111d4cb2a2dc202e657cb702f6d8');

#
# Table structure for table 'sortcodes'
#

CREATE TABLE sortcodes (
  code char(4) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Dumping data for table 'sortcodes'
#

INSERT INTO sortcodes VALUES ('ASC','Oldest First');
INSERT INTO sortcodes VALUES ('DESC','Newest First');

#
# Table structure for table 'statuscodes'
#

CREATE TABLE statuscodes (
  code int(1) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Dumping data for table 'statuscodes'
#

INSERT INTO statuscodes VALUES (1,'Refreshing');
INSERT INTO statuscodes VALUES (0,'Normal');
INSERT INTO statuscodes VALUES (10,'Archive');

#
# Table structure for table 'stories'
#

CREATE TABLE stories (
  sid varchar(20) NOT NULL default '',
  uid mediumint(8) NOT NULL default '1',
  tid varchar(20) NOT NULL default 'General',
  title varchar(128) default NULL,
  introtext text,
  bodytext text,
  hits mediumint(8) unsigned NOT NULL default '0',
  date datetime default NULL,
  comments mediumint(8) unsigned NOT NULL default '0',
  related text,
  featured tinyint(3) unsigned NOT NULL default '0',
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  postmode varchar(10) NOT NULL default 'html',
  frontpage tinyint(3) unsigned default '0',
  draft_flag tinyint(3) unsigned default '0',
  PRIMARY KEY  (sid)
) TYPE=MyISAM;

#
# Dumping data for table 'stories'
#

INSERT INTO stories VALUES ('20010719095630103',2,'GeekLog','Welcome to Geeklog!','Welcome and let me be the first to congratulate you on installing GeekLog. Please take the time to read everything in the docs directory. To log in to the admin section click <a      href=admin/index.php>here</a>. The default username and password for the admin is: <br><br><b>username:</b> Admin<br><b>password:</b> password','',22,'2001-07-19 09:56:30',2,'<li><a     href=admin/index.php>here</a><li><a  href=http://gldevel.iowaoutdoors.org/search.php?mode=search&type=stories&author=2>More by Admin</a>\n<li><a  href=http://gldevel.iowaoutdoors.org/search.php?mode=search&type=stories&topic=GeekLog>More from GeekLog</a>\n',1,0,0,'html',1,0);

#
# Table structure for table 'storysubmission'
#

CREATE TABLE storysubmission (
  sid varchar(20) NOT NULL default '',
  uid mediumint(8) NOT NULL default '1',
  tid varchar(20) NOT NULL default 'General',
  title varchar(128) default NULL,
  introtext text,
  date datetime default NULL,
  postmode varchar(10) NOT NULL default 'html',
  PRIMARY KEY  (sid)
) TYPE=MyISAM;

#
# Dumping data for table 'storysubmission'
#

INSERT INTO storysubmission VALUES ('20010808121253441',2,'GeekLog','test','test','2001-08-08 12:12:53','html');

#
# Table structure for table 'submitspeedlimit'
#

CREATE TABLE submitspeedlimit (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table 'submitspeedlimit'
#


#
# Table structure for table 'topics'
#

CREATE TABLE topics (
  tid varchar(20) NOT NULL default '',
  topic varchar(48) default NULL,
  imageurl varchar(96) default NULL,
  sortnum tinyint(3) default NULL,
  limitnews tinyint(3) default NULL,
  PRIMARY KEY  (tid)
) TYPE=MyISAM;

#
# Dumping data for table 'topics'
#

INSERT INTO topics VALUES ('General','General News','',1,10);
INSERT INTO topics VALUES ('GeekLog','GeekLog','/images/topics/topic_gl.gif',2,NULL);

#
# Table structure for table 'tzcodes'
#

CREATE TABLE tzcodes (
  tz char(3) NOT NULL default '',
  offset int(1) default NULL,
  description varchar(64) default NULL,
  PRIMARY KEY  (tz)
) TYPE=MyISAM;

#
# Dumping data for table 'tzcodes'
#

INSERT INTO tzcodes VALUES ('ndt',-9000,'Newfoundland Daylight');
INSERT INTO tzcodes VALUES ('adt',-10800,'Atlantic Daylight');
INSERT INTO tzcodes VALUES ('edt',-14400,'Eastern Daylight');
INSERT INTO tzcodes VALUES ('cdt',-18000,'Central Daylight');
INSERT INTO tzcodes VALUES ('mdt',-21600,'Mountain Daylight');
INSERT INTO tzcodes VALUES ('pdt',-25200,'Pacific Daylight');
INSERT INTO tzcodes VALUES ('ydt',-28800,'Yukon Daylight');
INSERT INTO tzcodes VALUES ('hdt',-32400,'Hawaii Daylight');
INSERT INTO tzcodes VALUES ('bst',3600,'British Summer');
INSERT INTO tzcodes VALUES ('mes',7200,'Middle European Summer');
INSERT INTO tzcodes VALUES ('sst',7200,'Swedish Summer');
INSERT INTO tzcodes VALUES ('fst',7200,'French Summer');
INSERT INTO tzcodes VALUES ('wad',28800,'West Australian Daylight');
INSERT INTO tzcodes VALUES ('cad',37800,'Central Australian Daylight');
INSERT INTO tzcodes VALUES ('ead',39600,'Eastern Australian Daylight');
INSERT INTO tzcodes VALUES ('nzd',46800,'New Zealand Daylight');
INSERT INTO tzcodes VALUES ('gmt',0,'Greenwich Mean');
INSERT INTO tzcodes VALUES ('utc',0,'Universal (Coordinated)');
INSERT INTO tzcodes VALUES ('wet',0,'Western European');
INSERT INTO tzcodes VALUES ('wat',-3600,'West Africa');
INSERT INTO tzcodes VALUES ('at',-7200,'Azores');
INSERT INTO tzcodes VALUES ('gst',-10800,'Greenland Standard');
INSERT INTO tzcodes VALUES ('nft',-12600,'Newfoundland');
INSERT INTO tzcodes VALUES ('nst',-12600,'Newfoundland Standard');
INSERT INTO tzcodes VALUES ('ast',-14400,'Atlantic Standard');
INSERT INTO tzcodes VALUES ('est',-18000,'Eastern Standard');
INSERT INTO tzcodes VALUES ('cst',-21600,'Central Standard');
INSERT INTO tzcodes VALUES ('mst',-25200,'Mountain Standard');
INSERT INTO tzcodes VALUES ('pst',-28800,'Pacific Standard');
INSERT INTO tzcodes VALUES ('yst',-32400,'Yukon Standard');
INSERT INTO tzcodes VALUES ('hst',-36000,'Hawaii Standard');
INSERT INTO tzcodes VALUES ('cat',-36000,'Central Alaska');
INSERT INTO tzcodes VALUES ('ahs',-36000,'Alaska-Hawaii Standard');
INSERT INTO tzcodes VALUES ('nt',-39600,'Nome');
INSERT INTO tzcodes VALUES ('idl',-43200,'International Date Line West');
INSERT INTO tzcodes VALUES ('cet',3600,'Central European');
INSERT INTO tzcodes VALUES ('met',3600,'Middle European');
INSERT INTO tzcodes VALUES ('mew',3600,'Middle European Winter');
INSERT INTO tzcodes VALUES ('swt',3600,'Swedish Winter');
INSERT INTO tzcodes VALUES ('fwt',3600,'French Winter');
INSERT INTO tzcodes VALUES ('eet',7200,'Eastern Europe, USSR Zone 1');
INSERT INTO tzcodes VALUES ('bt',10800,'Baghdad, USSR Zone 2');
INSERT INTO tzcodes VALUES ('it',12600,'Iran');
INSERT INTO tzcodes VALUES ('zp4',14400,'USSR Zone 3');
INSERT INTO tzcodes VALUES ('zp5',18000,'USSR Zone 4');
INSERT INTO tzcodes VALUES ('ist',19800,'Indian Standard');
INSERT INTO tzcodes VALUES ('zp6',21600,'USSR Zone 5');
INSERT INTO tzcodes VALUES ('was',25200,'West Australian Standard');
INSERT INTO tzcodes VALUES ('jt',27000,'Java (3pm in Cronusland!)');
INSERT INTO tzcodes VALUES ('cct',28800,'China Coast, USSR Zone 7');
INSERT INTO tzcodes VALUES ('jst',32400,'Japan Standard, USSR Zone 8');
INSERT INTO tzcodes VALUES ('cas',34200,'Central Australian Standard');
INSERT INTO tzcodes VALUES ('eas',36000,'Eastern Australian Standard');
INSERT INTO tzcodes VALUES ('nzt',43200,'New Zealand');
INSERT INTO tzcodes VALUES ('nzs',43200,'New Zealand Standard');
INSERT INTO tzcodes VALUES ('id2',43200,'International Date Line East');
INSERT INTO tzcodes VALUES ('idt',10800,'Israel Daylight');
INSERT INTO tzcodes VALUES ('iss',7200,'Israel Standard');

#
# Table structure for table 'usercomment'
#

CREATE TABLE usercomment (
  uid mediumint(8) NOT NULL default '1',
  commentmode varchar(10) NOT NULL default 'threaded',
  commentorder varchar(4) NOT NULL default 'ASC',
  commentlimit mediumint(8) unsigned NOT NULL default '100',
  PRIMARY KEY  (uid)
) TYPE=MyISAM;

#
# Dumping data for table 'usercomment'
#

INSERT INTO usercomment VALUES (1,'nested','ASC',100);
INSERT INTO usercomment VALUES (-1,'threaded','ASC',100);
INSERT INTO usercomment VALUES (2,'threaded','ASC',100);
INSERT INTO usercomment VALUES (3,'threaded','ASC',100);
INSERT INTO usercomment VALUES (0,'threaded','ASC',100);
INSERT INTO usercomment VALUES (4,'threaded','ASC',100);
INSERT INTO usercomment VALUES (5,'threaded','ASC',99);
INSERT INTO usercomment VALUES (8,'threaded','ASC',100);
INSERT INTO usercomment VALUES (6,'threaded','ASC',100);
INSERT INTO usercomment VALUES (7,'nested','ASC',100);
INSERT INTO usercomment VALUES (9,'threaded','ASC',100);
INSERT INTO usercomment VALUES (10,'threaded','ASC',100);

#
# Table structure for table 'userevent'
#

CREATE TABLE userevent (
  uid mediumint(8) NOT NULL default '1',
  eid varchar(20) NOT NULL default '',
  PRIMARY KEY  (uid,eid)
) TYPE=MyISAM;

#
# Dumping data for table 'userevent'
#

INSERT INTO userevent VALUES (4,'20010717140232751');

#
# Table structure for table 'userindex'
#

CREATE TABLE userindex (
  uid mediumint(8) NOT NULL default '1',
  tids varchar(255) NOT NULL default '',
  aids varchar(255) NOT NULL default '',
  boxes varchar(255) NOT NULL default '',
  noboxes tinyint(4) NOT NULL default '0',
  maxstories tinyint(4) default NULL,
  PRIMARY KEY  (uid)
) TYPE=MyISAM;

#
# Dumping data for table 'userindex'
#

INSERT INTO userindex VALUES (-1,'','','',0,NULL);
INSERT INTO userindex VALUES (1,'','','',0,NULL);
INSERT INTO userindex VALUES (2,'','','',0,NULL);
INSERT INTO userindex VALUES (3,'','','',0,NULL);
INSERT INTO userindex VALUES (5,'','','1',0,10);
INSERT INTO userindex VALUES (0,'','','',0,NULL);
INSERT INTO userindex VALUES (4,'','','',0,NULL);
INSERT INTO userindex VALUES (8,'','','',0,NULL);
INSERT INTO userindex VALUES (6,'','','',0,NULL);
INSERT INTO userindex VALUES (7,'','','',0,NULL);
INSERT INTO userindex VALUES (9,'','','',0,NULL);
INSERT INTO userindex VALUES (10,'','','',0,NULL);

#
# Table structure for table 'userinfo'
#

CREATE TABLE userinfo (
  uid mediumint(8) NOT NULL default '1',
  about text,
  pgpkey text,
  userspace varchar(255) NOT NULL default '',
  tokens tinyint(3) unsigned NOT NULL default '0',
  totalcomments mediumint(9) NOT NULL default '0',
  lastgranted int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (uid)
) TYPE=MyISAM;

#
# Dumping data for table 'userinfo'
#

INSERT INTO userinfo VALUES (1,'Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner ','','',0,0,0);
INSERT INTO userinfo VALUES (-1,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (2,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (3,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (5,'','','',0,0,0);
INSERT INTO userinfo VALUES (0,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (4,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (8,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (6,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (7,'','','',0,0,0);
INSERT INTO userinfo VALUES (9,NULL,NULL,'',0,0,0);
INSERT INTO userinfo VALUES (10,NULL,NULL,'',0,0,0);

#
# Table structure for table 'userprefs'
#

CREATE TABLE userprefs (
  uid mediumint(8) NOT NULL default '1',
  noicons tinyint(3) unsigned NOT NULL default '0',
  willing tinyint(3) unsigned NOT NULL default '1',
  dfid tinyint(3) unsigned NOT NULL default '0',
  tzid char(3) NOT NULL default 'edt',
  emailstories tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (uid)
) TYPE=MyISAM;

#
# Dumping data for table 'userprefs'
#

INSERT INTO userprefs VALUES (1,0,0,0,'',0);
INSERT INTO userprefs VALUES (2,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (3,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (-1,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (5,0,0,0,'',0);
INSERT INTO userprefs VALUES (0,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (4,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (8,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (6,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (7,0,1,0,'edt',0);
INSERT INTO userprefs VALUES (9,0,1,0,'edt',1);
INSERT INTO userprefs VALUES (10,0,1,0,'edt',1);

#
# Table structure for table 'users'
#

CREATE TABLE users (
  uid mediumint(8) NOT NULL auto_increment,
  username varchar(16) NOT NULL default '',
  fullname varchar(80) default NULL,
  passwd varchar(32) NOT NULL default '',
  seclev tinyint(3) unsigned NOT NULL default '0',
  email varchar(96) default NULL,
  homepage varchar(96) default NULL,
  sig varchar(160) NOT NULL default '',
  PRIMARY KEY  (uid),
  KEY LOGIN (uid,passwd,username)
) TYPE=MyISAM;

#
# Dumping data for table 'users'
#

INSERT INTO users VALUES (1,'Anonymous','Anonymous','',0,NULL,NULL,'');
INSERT INTO users VALUES (3,'Admin2','GeekLog Junior Admin Account','5f4dcc3b5aa765d61d8327deb882cf99',150,'root','http://geeklog.newsgeeks.com','');
INSERT INTO users VALUES (4,'Admin3','GeekLog Story Reporter Account','5f4dcc3b5aa765d61d8327deb882cf99',100,'root','http://geeklog.newsgeeks.com','');
INSERT INTO users VALUES (2,'Admin','Geeklog Admin Account','5f4dcc3b5aa765d61d8327deb882cf99',255,'root@localhost.com','http://www.geeklog.org','');
INSERT INTO users VALUES (5,'tony',NULL,'7747d948d769eeeb4b82812490668d64',0,'tony@tonybibbs.com',NULL,'');

#
# Table structure for table 'valid_values'
#

CREATE TABLE valid_values (
  vv_att_id mediumint(10) unsigned NOT NULL default '0',
  vv_seq_num mediumint(8) unsigned NOT NULL default '0',
  vv_value varchar(10) default NULL,
  PRIMARY KEY  (vv_att_id,vv_seq_num)
) TYPE=MyISAM;

#
# Dumping data for table 'valid_values'
#


#
# Table structure for table 'vars'
#

CREATE TABLE vars (
  name varchar(20) NOT NULL default '',
  value varchar(128) default NULL,
  PRIMARY KEY  (name)
) TYPE=MyISAM;

#
# Dumping data for table 'vars'
#

INSERT INTO vars VALUES ('totalhits','3624');
INSERT INTO vars VALUES ('lastemailedstories','2001-04-18 22:29:29');

#
# Table structure for table 'vendor'
#

CREATE TABLE vendor (
  vd_id mediumint(10) unsigned NOT NULL auto_increment,
  vd_name varchar(50) default NULL,
  vd_desc text,
  vd_text text,
  vd_enabled tinyint(3) unsigned NOT NULL default '1',
  vd_contact_name varchar(75) default NULL,
  vd_contact_email varchar(150) default NULL,
  vd_homepage varchar(150) default NULL,
  vd_addr1 varchar(50) default NULL,
  vd_addr2 varchar(50) default NULL,
  vd_city varchar(50) default NULL,
  vd_state_cde char(2) default NULL,
  vd_zip varchar(9) default NULL,
  vd_phone varchar(10) default NULL,
  vd_fax varchar(10) default NULL,
  PRIMARY KEY  (vd_id)
) TYPE=MyISAM;

#
# Dumping data for table 'vendor'
#


