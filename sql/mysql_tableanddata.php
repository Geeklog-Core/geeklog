<?php

$_SQL[1] = "
CREATE TABLE {$_TABLES['access']} (
  acc_ft_id mediumint(8) NOT NULL default '0',
  acc_grp_id mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (acc_ft_id,acc_grp_id)
) TYPE=MyISAM
";

$_SQL[2] = "
CREATE TABLE {$_TABLES['blocks']} (
  bid smallint(5) unsigned NOT NULL auto_increment,
  name varchar(48) NOT NULL default '',
  type varchar(20) NOT NULL default 'normal',
  title varchar(48) default NULL,
  tid varchar(20) NOT NULL default 'All',
  blockorder tinyint(3) unsigned NOT NULL default '1',
  content text,
  rdfurl varchar(96) default NULL,
  rdfupdated datetime NOT NULL default '0000-00-00 00:00:00',
  onleft tinyint(3) unsigned NOT NULL default '1',
  phpblockfn varchar(64) default '',
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (bid)
) TYPE=MyISAM
";

$_SQL[3] = "
CREATE TABLE {$_TABLES['commentcodes']} (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[4] = "
CREATE TABLE {$_TABLES['commentmodes']} (
  mode varchar(10) NOT NULL default '',
  name varchar(32) default NULL,
  PRIMARY KEY  (mode)
) TYPE=MyISAM
";

$_SQL[5] = "
CREATE TABLE {$_TABLES['comments']} (
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
) TYPE=MyISAM
";

$_SQL[6] = "
CREATE TABLE {$_TABLES['commentspeedlimit']} (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM
";

$_SQL[7] = "
CREATE TABLE {$_TABLES['cookiecodes']} (
  cc_value int(8) unsigned NOT NULL default '0',
  cc_descr varchar(20) NOT NULL default '',
  PRIMARY KEY  (cc_value)
) TYPE=MyISAM
";

$_SQL[8] = "
CREATE TABLE {$_TABLES['dateformats']} (
  dfid tinyint(4) NOT NULL default '0',
  format varchar(32) default NULL,
  description varchar(64) default NULL,
  PRIMARY KEY  (dfid)
) TYPE=MyISAM
";

$_SQL[9] = "
CREATE TABLE {$_TABLES['events']} (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  description text,
  datestart date default NULL,
  dateend date default NULL,
  url varchar(128) default NULL,
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  address1 varchar(40) default NULL,
  address2 varchar(40) default NULL,
  city varchar(60) default NULL,
  state char(2) default NULL,
  zipcode varchar(5) default NULL,
  allday tinyint(1) NOT NULL default '0',
  event_type varchar(40) NOT NULL default '',
  location varchar(128) default NULL,
  timestart time default NULL,
  timeend time default NULL,
  PRIMARY KEY  (eid)
) TYPE=MyISAM
";

$_SQL[10] = "
CREATE TABLE {$_TABLES['eventsubmission']} (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  description text,
  location varchar(128) default NULL,
  datestart date default NULL,
  dateend date default NULL,
  url varchar(128) default NULL,
  allday tinyint(1) NOT NULL default '0',
  zipcode varchar(5) default NULL,
  state char(2) default NULL,
  city varchar(60) default NULL,
  address2 varchar(40) default NULL,
  address1 varchar(40) default NULL,
  event_type varchar(40) NOT NULL default '',
  timestart time default NULL,
  timeend time default NULL,
  PRIMARY KEY  (eid)
) TYPE=MyISAM
";

$_SQL[11] = "
CREATE TABLE {$_TABLES['featurecodes']} (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[12] = "
CREATE TABLE {$_TABLES['features']} (
  ft_id mediumint(8) NOT NULL auto_increment,
  ft_name varchar(20) NOT NULL default '',
  ft_descr varchar(255) NOT NULL default '',
  ft_gl_core tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ft_id),
  KEY ft_name (ft_name)
) TYPE=MyISAM
";

$_SQL[13] = "
CREATE TABLE {$_TABLES['frontpagecodes']} (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[14] = "
CREATE TABLE {$_TABLES['group_assignments']} (
  ug_main_grp_id mediumint(8) NOT NULL default '0',
  ug_uid mediumint(8) unsigned default NULL,
  ug_grp_id mediumint(8) unsigned default NULL,
  INDEX group_assignments_ug_grp_id(ug_grp_id),
  KEY ug_main_grp_id (ug_main_grp_id)
) TYPE=MyISAM
";

$_SQL[15] = "
CREATE TABLE {$_TABLES['groups']} (
  grp_id mediumint(8) NOT NULL auto_increment,
  grp_name varchar(50) NOT NULL default '',
  grp_descr varchar(255) NOT NULL default '',
  grp_gl_core tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (grp_id),
  KEY grp_name (grp_name)
) TYPE=MyISAM
";

$_SQL[16] = "
CREATE TABLE {$_TABLES['links']} (
  lid varchar(20) NOT NULL default '',
  category varchar(32) default NULL,
  url varchar(96) default NULL,
  description text,
  title varchar(96) default NULL,
  hits int(11) NOT NULL default '0',
  date datetime default NULL,
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (lid)
) TYPE=MyISAM
";

$_SQL[17] = "
CREATE TABLE {$_TABLES['linksubmission']} (
  lid varchar(20) NOT NULL default '',
  category varchar(32) default NULL,
  url varchar(96) default NULL,
  description text,
  title varchar(96) default NULL,
  hits int(11) default NULL,
  date datetime default NULL,
  PRIMARY KEY  (lid)
) TYPE=MyISAM
";

$_SQL[18] = "
CREATE TABLE {$_TABLES['maillist']} (
  code int(1) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[19] = "
CREATE TABLE {$_TABLES['personal_events']} (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  event_type varchar(40) NOT NULL default '',
  datestart date default NULL,
  dateend date default NULL,
  address1 varchar(40) default NULL,
  address2 varchar(40) default NULL,
  city varchar(60) default NULL,
  state char(2) default NULL,
  zipcode varchar(5) default NULL,
  allday tinyint(1) NOT NULL default '0',
  url varchar(128) default NULL,
  description text,
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  uid mediumint(8) NOT NULL default '0',
  location varchar(128) default NULL,
  timestart time default NULL,
  timeend time default NULL,
  PRIMARY KEY  (eid)
) TYPE=MyISAM
";

$_SQL[20] = "
CREATE TABLE {$_TABLES['plugins']} (
  pi_name varchar(30) NOT NULL default '',
  pi_version varchar(20) NOT NULL default '',
  pi_gl_version varchar(20) NOT NULL default '',
  pi_enabled tinyint(3) unsigned NOT NULL default '1',
  pi_homepage varchar(128) NOT NULL default '',
  PRIMARY KEY  (pi_name)
) TYPE=MyISAM
";

$_SQL[21] = "
CREATE TABLE {$_TABLES['pollanswers']} (
  qid varchar(20) NOT NULL default '',
  aid tinyint(3) unsigned NOT NULL default '0',
  answer varchar(255) default NULL,
  votes mediumint(8) unsigned default NULL,
  PRIMARY KEY  (qid,aid)
) TYPE=MyISAM
";

$_SQL[22] = "
CREATE TABLE {$_TABLES['pollquestions']} (
  qid varchar(20) NOT NULL default '',
  question varchar(255) default NULL,
  voters mediumint(8) unsigned default NULL,
  date datetime default NULL,
  display tinyint(4) NOT NULL default '0',
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (qid)
) TYPE=MyISAM
";

$_SQL[23] = "
CREATE TABLE {$_TABLES['pollvoters']} (
  id int(10) unsigned NOT NULL auto_increment,
  qid varchar(20) NOT NULL default '',
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM
";

$_SQL[24] = "
CREATE TABLE {$_TABLES['postmodes']} (
  code char(10) NOT NULL default '',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[25] = "
CREATE TABLE {$_TABLES['sessions']} (
  sess_id int(10) unsigned NOT NULL default '0',
  start_time int(10) unsigned NOT NULL default '0',
  remote_ip varchar(15) NOT NULL default '',
  uid mediumint(8) NOT NULL default '1',
  md5_sess_id varchar(128) default NULL,
  PRIMARY KEY  (sess_id),
  KEY sess_id (sess_id),
  KEY start_time (start_time),
  KEY remote_ip (remote_ip)
) TYPE=MyISAM
";

$_SQL[26] = "
CREATE TABLE {$_TABLES['sortcodes']} (
  code char(4) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[27] = "
CREATE TABLE {$_TABLES['statuscodes']} (
  code int(1) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[28] = "
CREATE TABLE {$_TABLES['stories']} (
  sid varchar(20) NOT NULL default '',
  uid mediumint(8) NOT NULL default '1',
  draft_flag tinyint(3) unsigned default '0',
  tid varchar(20) NOT NULL default 'General',
  date datetime default NULL,
  title varchar(128) default NULL,
  introtext text,
  bodytext text,
  hits mediumint(8) unsigned NOT NULL default '0',
  numemails mediumint(8) unsigned NOT NULL default '0',
  comments mediumint(8) unsigned NOT NULL default '0',
  related text,
  featured tinyint(3) unsigned NOT NULL default '0',
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  postmode varchar(10) NOT NULL default 'html',
  frontpage tinyint(3) unsigned default '0',
  owner_id mediumint(8) NOT NULL default '1',
  group_id mediumint(8) NOT NULL default '2',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  INDEX stories_tid(tid),
  PRIMARY KEY  (sid)
) TYPE=MyISAM
";

$_SQL[29] = "
CREATE TABLE {$_TABLES['storysubmission']} (
  sid varchar(20) NOT NULL default '',
  uid mediumint(8) NOT NULL default '1',
  tid varchar(20) NOT NULL default 'General',
  title varchar(128) default NULL,
  introtext text,
  date datetime default NULL,
  postmode varchar(10) NOT NULL default 'html',
  PRIMARY KEY  (sid)
) TYPE=MyISAM
";

$_SQL[30] = "
CREATE TABLE {$_TABLES['submitspeedlimit']} (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM
";

$_SQL[31] = "
CREATE TABLE {$_TABLES['topics']} (
  tid varchar(20) NOT NULL default '',
  topic varchar(48) default NULL,
  imageurl varchar(96) default NULL,
  sortnum tinyint(3) default NULL,
  limitnews tinyint(3) default NULL,
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (tid)
) TYPE=MyISAM
";

$_SQL[32] = "
CREATE TABLE {$_TABLES['tzcodes']} (
  tz char(3) NOT NULL default '',
  offset int(1) default NULL,
  description varchar(64) default NULL,
  PRIMARY KEY  (tz)
) TYPE=MyISAM
";

$_SQL[33] = "
CREATE TABLE {$_TABLES['usercomment']} (
  uid mediumint(8) NOT NULL default '1',
  commentmode varchar(10) NOT NULL default 'threaded',
  commentorder varchar(4) NOT NULL default 'ASC',
  commentlimit mediumint(8) unsigned NOT NULL default '100',
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[35] = "
CREATE TABLE {$_TABLES['userindex']} (
  uid mediumint(8) NOT NULL default '1',
  tids varchar(255) NOT NULL default '',
  eids varchar(255) NOT NULL default '',
  aids varchar(255) NOT NULL default '',
  boxes varchar(255) NOT NULL default '',
  noboxes tinyint(4) NOT NULL default '0',
  maxstories tinyint(4) default NULL,
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[36] = "
CREATE TABLE {$_TABLES['userinfo']} (
  uid mediumint(8) NOT NULL default '1',
  about text,
  pgpkey text,
  userspace varchar(255) NOT NULL default '',
  tokens tinyint(3) unsigned NOT NULL default '0',
  totalcomments mediumint(9) NOT NULL default '0',
  lastgranted int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[37] = "
CREATE TABLE {$_TABLES['userprefs']} (
  uid mediumint(8) NOT NULL default '1',
  noicons tinyint(3) unsigned NOT NULL default '0',
  willing tinyint(3) unsigned NOT NULL default '1',
  dfid tinyint(3) unsigned NOT NULL default '0',
  tzid char(3) NOT NULL default 'edt',
  emailstories tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[38] = "
CREATE TABLE {$_TABLES['users']} (
  uid mediumint(8) NOT NULL auto_increment,
  username varchar(16) NOT NULL default '',
  fullname varchar(80) default NULL,
  passwd varchar(32) NOT NULL default '',
  email varchar(96) default NULL,
  homepage varchar(96) default NULL,
  sig varchar(160) NOT NULL default '',
  regdate datetime NOT NULL default '0000-00-00 00:00:00',
  cookietimeout int(8) unsigned default '0',
  theme varchar(64) default NULL,
  language varchar(64) default NULL,
  PRIMARY KEY  (uid),
  KEY LOGIN (uid,passwd,username)
) TYPE=MyISAM
";

$_SQL[39] = "
CREATE TABLE {$_TABLES['vars']} (
  name varchar(20) NOT NULL default '',
  value varchar(128) default NULL,
  PRIMARY KEY  (name)
) TYPE=MyISAM
";

$_DATA[1] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (1,3) ";
$_DATA[2] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (2,3) ";
$_DATA[3] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (3,5) ";
$_DATA[4] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (4,5) ";
$_DATA[5] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,9) ";
$_DATA[6] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,11) ";
$_DATA[7] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,9) ";
$_DATA[8] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,11) ";
$_DATA[9] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (8,7) ";
$_DATA[10] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (9,7) ";
$_DATA[11] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (10,4) ";
$_DATA[12] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (11,6) ";
$_DATA[13] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (12,8) ";
$_DATA[14] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (13,10) ";
$_DATA[15] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (14,11) ";
$_DATA[16] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (15,11) ";
$_DATA[17] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (16,4) ";

$_DATA[18] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (3,'user_block','gldefault','User Block','all',2,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[19] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (4,'admin_block','gldefault','Admin Block','all',1,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[20] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (5,'section_block','gldefault','Section Block','all',0,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[21] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (6,'poll_block','gldefault','Poll Block','all',2,'','','0000-00-00 00:00:00',0,'0',1,2,3,3,2,2) ";
$_DATA[22] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (7,'events_block','gldefault','Events Block','all',3,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[23] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (8,'whats_new_block','gldefault','Whats New Block','all',3,'','','0000-00-00 00:00:00',0,'1',1,2,3,3,2,2) ";
$_DATA[24] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (9,'first_block','normal','GeekLog 1.3','all',1,'Welcome to GeekLog 1.3!  There have been many improvments to GeekLog since 1.2.5-1, namely the addition of plug-in support, improved security, flexible database abstraction layer, themes and a new installation script.  Please read the release notes in the /docs directory and go over the install guide.','','0000-00-00 00:00:00',0,'',4,2,3,3,2,2) ";
$_DATA[25] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (10,'whosonline_block','phpblock','Who\'s Online','all',0,'','','0000-00-00 00:00:00',0,'phpblock_whosonline',4,2,3,3,2,2) ";
$_DATA[26] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (0,'Comments Enabled') ";
$_DATA[27] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (1,'Read-Only') ";
$_DATA[28] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (-1,'Comments Disabled') ";

$_DATA[29] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('flat','Flat') ";
$_DATA[30] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nested','Nested') ";
$_DATA[31] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('threaded','Threaded') ";
$_DATA[32] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nocomment','No Comments') ";

$_DATA[33] = "INSERT INTO {$_TABLES['comments']} (cid, sid, date, title, comment, score, reason, pid, uid) VALUES (21,'geeklogpollquestion','2001-07-19 14:44:54','I love Geeklog!','I can\'t make up my mind...I love it all!',0,0,0,1) ";
$_DATA[34] = "INSERT INTO {$_TABLES['comments']} (cid, sid, date, title, comment, score, reason, pid, uid) VALUES (22,'geeklogpollquestion','2001-07-19 14:48:23','We are glad you like it!','We are happy you like Geeklog.  Please be sure to join the <a   href=http://lists.sourceforge.net/lists/listinfo/geeklog-devel target=_new>geeklog mailing</a> list!',0,0,21,2) ";
$_DATA[35] = "INSERT INTO {$_TABLES['comments']} (cid, sid, date, title, comment, score, reason, pid, uid) VALUES (23,'20010719095630103','2001-07-19 15:02:57','Other Admin accounts','Remember, the admin accounts that come with a fresh Geeklog installation are for demonstration purposes only.  You should delete them if you don\'t plan on using them or at least change their passwords.',0,0,0,2) ";
$_DATA[36] = "INSERT INTO {$_TABLES['comments']} (cid, sid, date, title, comment, score, reason, pid, uid) VALUES (24,'20011115154118159','2001-11-15 16:50:09','test comment','will this work?',0,0,0,2) ";
$_DATA[37] = "INSERT INTO {$_TABLES['comments']} (cid, sid, date, title, comment, score, reason, pid, uid) VALUES (25,'20011115154118159','2001-11-15 16:51:13','test comment','will this work?',0,0,0,2) ";
$_DATA[38] = "INSERT INTO {$_TABLES['comments']} (cid, sid, date, title, comment, score, reason, pid, uid) VALUES (26,'20011029162602450','2001-12-03 14:36:21','Test','Test',0,0,0,2) ";

$_DATA[39] = "INSERT INTO {$_TABLES['commentspeedlimit']} (id, ipaddress, date) VALUES (3,'127.0.0.1',1007411781) ";

$_DATA[40] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (3600,'1 Hour') ";
$_DATA[41] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (7200,'2 Hours') ";
$_DATA[42] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (10800,'3 Hours') ";
$_DATA[43] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (28800,'8 Hours') ";
$_DATA[44] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (86400,'1 Day') ";
$_DATA[45] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (604800,'1 Week') ";
$_DATA[46] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (2678400,'1 Month') ";
$_DATA[47] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (31536000,'1 Year') ";

$_DATA[48] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (0,'','System Default') ";
$_DATA[49] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (1,'%A %B %d, %Y @%I:%M%p','Sunday March 21, 1999 @10:00PM') ";
$_DATA[50] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (2,'%A %b %d, %Y @%H:%M','Sunday March 21, 1999 @22:00') ";
$_DATA[51] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (4,'%A %b %d @%H:%M','Sunday March 21 @22:00') ";
$_DATA[52] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (5,'%H:%M %d %B %Y','22:00 21 March 1999') ";
$_DATA[53] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (6,'%H:%M %A %d %B %Y','22:00 Sunday 21 March 1999') ";
$_DATA[54] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (7,'%I:%M%p - %A %B %d %Y','10:00PM -- Sunday March 21 1999') ";
$_DATA[55] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (8,'%a %B %d, %I:%M%p','Sun March 21, 10:00PM') ";
$_DATA[56] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (9,'%a %B %d, %H:%M','Sun March 21, 22:00') ";
$_DATA[57] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (10,'%m-%d-%y %H:%M','3-21-99 22:00') ";
$_DATA[58] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (11,'%d-%m-%y %H:%M','21-3-99 22:00') ";
$_DATA[59] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (12,'%m-%d-%y %I:%M%p','3-21-99 10:00PM') ";
$_DATA[60] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (13,'%I:%M%p  %B %D, %Y','10:00PM  March 21st, 1999') ";
$_DATA[61] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (14,'%a %b %d, \'%y %I:%M%p','Sun Mar 21, \'99 10:00PM') ";
$_DATA[62] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (15,'Day %j, %I ish','Day 80, 10 ish') ";
$_DATA[63] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (16,'%y-%m-%d %I:%M','99-03-21 10:00') ";
$_DATA[64] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (17,'%d/%m/%y %H:%M','21/03/99 22:00') ";
$_DATA[65] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (18,'%a %d %b %I:%M%p','Sun 21 Mar 10:00PM') ";

$_DATA[66] = "INSERT INTO {$_TABLES['eventsubmission']} (eid, title, description, location, datestart, dateend, url, allday, zipcode, state, city, address2, address1, event_type, timestart, timeend) VALUES ('2001110114064662','Test event','test','Test','2001-11-02','2001-11-03','http://www.tonybibbs.com',0,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL) ";

$_DATA[67] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (0,'Not Featured') ";
$_DATA[68] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (1,'Featured') ";

$_DATA[69] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (1,'story.edit','Access to story editor',1) ";
$_DATA[70] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (2,'story.moderate','Ablility to moderate pending stories',1) ";
$_DATA[71] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (3,'link.moderate','Ablility to moderate pending links',1) ";
$_DATA[72] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (4,'link.edit','Access to link editor',1) ";
$_DATA[73] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (5,'user.edit','Access to user editor',1) ";
$_DATA[74] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (6,'user.delete','Ablility to delete a user',1) ";
$_DATA[75] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (7,'user.mail','Ablility to send email to members',1) ";
$_DATA[76] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (8,'event.moderate','Ablility to moderate pending events',1) ";
$_DATA[77] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (9,'event.edit','Access to event editor',1) ";
$_DATA[78] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (10,'block.edit','Access to block editor',1) ";
$_DATA[79] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (11,'topic.edit','Access to topic editor',1) ";
$_DATA[80] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (12,'poll.edit','Access to poll editor',1) ";
$_DATA[81] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (13,'plugin.edit','Access to plugin editor',1) ";
$_DATA[82] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (14,'group.edit','Ability to edit groups',1) ";
$_DATA[83] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (15,'group.delete','Ability to delete groups',1) ";
$_DATA[84] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (16,'block.delete','Ability to delete a block',1) ";

$_DATA[85] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (0,'Show Only in Topic') ";
$_DATA[86] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (1,'Show on Front Page') ";

$_DATA[87] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,1,NULL) ";
$_DATA[88] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,1) ";
$_DATA[89] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,NULL,1) ";
$_DATA[90] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,NULL,1) ";
$_DATA[91] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,NULL,1) ";
$_DATA[92] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,NULL,1) ";
$_DATA[93] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,NULL,1) ";
$_DATA[94] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,NULL,1) ";
$_DATA[95] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,1) ";
$_DATA[96] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,NULL,1) ";
$_DATA[97] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,NULL,1) ";
$_DATA[98] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,2,NULL) ";
$_DATA[99] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,2,NULL) ";
$_DATA[100] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,2,NULL) ";
$_DATA[101] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,12) ";
$_DATA[102] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,10) ";
$_DATA[103] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,9) ";
$_DATA[104] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,8) ";
$_DATA[105] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,7) ";
$_DATA[106] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,6) ";
$_DATA[107] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,5) ";
$_DATA[108] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,4) ";
$_DATA[109] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,3) ";
$_DATA[110] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,NULL,1) ";
$_DATA[111] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,11) ";
$_DATA[112] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,11) ";
$_DATA[113] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,9,NULL) ";
$_DATA[114] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,5,NULL) ";
$_DATA[115] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,8,NULL) ";
$_DATA[116] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,6,NULL) ";
$_DATA[117] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,10,NULL) ";
$_DATA[118] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,11,NULL) ";
$_DATA[119] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,3,NULL) ";
$_DATA[120] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,5,NULL) ";
$_DATA[121] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,6,NULL) ";
$_DATA[122] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,7,NULL) ";
$_DATA[123] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,8,NULL) ";
$_DATA[124] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,9,NULL) ";
$_DATA[125] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,10,NULL) ";
$_DATA[126] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,11,NULL) ";
$_DATA[127] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,3,NULL) ";
$_DATA[128] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,7,NULL) ";
$_DATA[128] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,3,NULL) ";
$_DATA[129] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,5,NULL) ";
$_DATA[130] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,6,NULL) ";
$_DATA[131] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,7,NULL) ";
$_DATA[132] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,8,NULL) ";
$_DATA[133] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,9,NULL) ";
$_DATA[134] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,10,NULL) ";
$_DATA[135] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,11,NULL) ";
$_DATA[138] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,2,NULL) ";
$_DATA[139] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,2,NULL) ";
$_DATA[140] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,2,NULL) ";
$_DATA[141] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,2,NULL) ";
$_DATA[142] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,2,NULL) ";
$_DATA[143] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,2,NULL) ";
$_DATA[144] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,2,NULL) ";
$_DATA[145] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,2,NULL) ";
$_DATA[146] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,2,NULL) ";
$_DATA[147] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,2,NULL) ";

$_DATA[151] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (1,'Root','Has full access to the site',1) ";
$_DATA[152] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (2,'All Users','Group that a typical user is added to',1) ";
$_DATA[153] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (3,'Story Admin','Has full access to story features',1) ";
$_DATA[154] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (4,'Block Admin','Has full access to block features',1) ";
$_DATA[155] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (5,'Link Admin','Has full access to link features',1) ";
$_DATA[156] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (6,'Topic Admin','Has full access to topic features',1) ";
$_DATA[157] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (7,'Event Admin','Has full access to event features',1) ";
$_DATA[158] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (8,'Poll Admin','Has full access to poll features',1) ";
$_DATA[159] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (9,'User Admin','Has full access to user features',1) ";
$_DATA[160] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (10,'Plugin Admin','Has full access to plugin features',1) ";
$_DATA[161] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (11,'Group Admin','Is a User Admin with Acces to Groups too',1) ";
$_DATA[162] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (12,'Mail Admin','Can Use Mail Utility',1) ";
$_DATA[163] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (13,'Logged-in Users','All users except anonymous should belong to this group',1) ";

$_DATA[164] = "INSERT INTO {$_TABLES['links']} (lid, category, url, description, title, hits, date, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20010719095147683','Geeklog Sites','http://geeklog.sourceforge.net','The source for stuff...nifty stuff','Geeklog Project',52,NULL,5,2,3,3,2,2) ";
$_DATA[165] = "INSERT INTO {$_TABLES['links']} (lid, category, url, description, title, hits, date, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20010719095621775','Geeklog Sites','http://www.devgeek.org','The place to talk about and contribute to the development of Geeklog','DevGeek',78,NULL,5,2,3,3,2,2) ";
$_DATA[166] = "INSERT INTO {$_TABLES['links']} (lid, category, url, description, title, hits, date, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('2001071910450356','Geeklog Sites','http://www.iowaoutdoors.org','Your source for hunting and fishing information in Iowa.','Iowa Outdoors',10,NULL,5,2,3,3,2,2) ";

$_DATA[168] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (0,'Don\'t Email') ";
$_DATA[169] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (1,'Email Headlines Each Night') ";

$_DATA[171] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',5,'Installation Script',0) ";
$_DATA[172] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',4,'User-Defined Themes',0) ";
$_DATA[173] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',3,'Plugin-Support',0) ";
$_DATA[174] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',2,'Improved Calendar',0) ";
$_DATA[175] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',1,'New Security Model',0) ";
$_DATA[176] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',6,'Database Abstraction',0) ";
$_DATA[177] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',7,'Other',0) ";

$_DATA[178] = "INSERT INTO {$_TABLES['pollquestions']} (qid, question, voters, date, display, commentcode, statuscode, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklogfeaturepoll','What is the best new feature of Geeklog?',0,'2001-12-04 12:43:20',1,0,0,8,2,3,3,2,2) ";

$_DATA[179] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('plaintext','Plain Old Text') ";
$_DATA[180] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('html','HTML Formatted') ";

$_DATA[181] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('ASC','Oldest First') ";
$_DATA[182] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('DESC','Newest First') ";

$_DATA[183] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (1,'Refreshing') ";
$_DATA[184] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (0,'Normal') ";
$_DATA[185] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (10,'Archive') ";

$_DATA[186] = "INSERT INTO {$_TABLES['stories']} (sid, uid, draft_flag, tid, date, title, introtext, bodytext, hits, numemails, comments, related, featured, commentcode, statuscode, postmode, frontpage, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20010719095630103',2,0,'GeekLog','2001-07-19 09:56:30','Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing GeekLog. Please take the time to read everything in the docs directory. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.\r\r<p>Below are a list of usernames that have access to a specific portion of the site with the exception of Admin who has access to everything.  The password for each account is <b>password</b>. \r\r<P>\r<ul>Accounts:\r<li>Admin</li>\r<li>StoryAdmin</li>\r<li>LinkAdmin</li>\r<li>BlockAdmin</li>\r<li>EventAdmin</li>\r<li>TopicAdmin</li>\r<li>MailAdmin</li>\r<li>PollAdmin</li>\r<li>UserAdmin</li>\r<li>GroupAdmin</li>\r</ul>','',173,1,1,'<li><a href=http://tbibbs/search.php?mode=search&type=stories&author=2>More by Admin</a><li><a href=http://tbibbs/search.php?mode=search&type=stories&topic=GeekLog>More from GeekLog</a>',1,0,0,'html',1,2,3,3,3,2,2) ";

$_DATA[187] = "INSERT INTO {$_TABLES['storysubmission']} (sid, uid, tid, title, introtext, date, postmode) VALUES ('20011018120556538',2,'GeekLog','Test','Test','2001-10-18 12:05:56','html') ";

$_DATA[188] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('General','General News','',1,10,2,2,3,3,2,3) ";
$_DATA[189] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('GeekLog','GeekLog','/images/topics/topic_gl.gif',2,0,2,2,3,3,2,3) ";

$_DATA[190] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ndt',-9000,'Newfoundland Daylight') ";
$_DATA[191] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('adt',-10800,'Atlantic Daylight') ";
$_DATA[192] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('edt',-14400,'Eastern Daylight') ";
$_DATA[193] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cdt',-18000,'Central Daylight') ";
$_DATA[194] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mdt',-21600,'Mountain Daylight') ";
$_DATA[195] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('pdt',-25200,'Pacific Daylight') ";
$_DATA[196] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ydt',-28800,'Yukon Daylight') ";
$_DATA[197] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('hdt',-32400,'Hawaii Daylight') ";
$_DATA[198] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('bst',3600,'British Summer') ";
$_DATA[199] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mes',7200,'Middle European Summer') ";
$_DATA[200] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('sst',7200,'Swedish Summer') ";
$_DATA[201] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('fst',7200,'French Summer') ";
$_DATA[202] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('wad',28800,'West Australian Daylight') ";
$_DATA[203] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cad',37800,'Central Australian Daylight') ";
$_DATA[204] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ead',39600,'Eastern Australian Daylight') ";
$_DATA[205] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nzd',46800,'New Zealand Daylight') ";
$_DATA[206] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('gmt',0,'Greenwich Mean') ";
$_DATA[207] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('utc',0,'Universal (Coordinated)') ";
$_DATA[208] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('wet',0,'Western European') ";
$_DATA[209] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('wat',-3600,'West Africa') ";
$_DATA[210] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('at',-7200,'Azores') ";
$_DATA[211] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('gst',-10800,'Greenland Standard') ";
$_DATA[212] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nft',-12600,'Newfoundland') ";
$_DATA[213] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nst',-12600,'Newfoundland Standard') ";
$_DATA[214] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ast',-14400,'Atlantic Standard') ";
$_DATA[215] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('est',-18000,'Eastern Standard') ";
$_DATA[216] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cst',-21600,'Central Standard') ";
$_DATA[217] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mst',-25200,'Mountain Standard') ";
$_DATA[218] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('pst',-28800,'Pacific Standard') ";
$_DATA[219] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('yst',-32400,'Yukon Standard') ";
$_DATA[220] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('hst',-36000,'Hawaii Standard') ";
$_DATA[221] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cat',-36000,'Central Alaska') ";
$_DATA[222] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ahs',-36000,'Alaska-Hawaii Standard') ";
$_DATA[223] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nt',-39600,'Nome') ";
$_DATA[224] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('idl',-43200,'International Date Line West') ";
$_DATA[225] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cet',3600,'Central European') ";
$_DATA[226] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('met',3600,'Middle European') ";
$_DATA[227] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mew',3600,'Middle European Winter') ";
$_DATA[228] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('swt',3600,'Swedish Winter') ";
$_DATA[229] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('fwt',3600,'French Winter') ";
$_DATA[230] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('eet',7200,'Eastern Europe, USSR Zone 1') ";
$_DATA[231] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('bt',10800,'Baghdad, USSR Zone 2') ";
$_DATA[232] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('it',12600,'Iran') ";
$_DATA[233] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('zp4',14400,'USSR Zone 3') ";
$_DATA[234] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('zp5',18000,'USSR Zone 4') ";
$_DATA[235] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ist',19800,'Indian Standard') ";
$_DATA[236] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('zp6',21600,'USSR Zone 5') ";
$_DATA[237] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('was',25200,'West Australian Standard') ";
$_DATA[238] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('jt',27000,'Java (3pm in Cronusland!)') ";
$_DATA[239] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cct',28800,'China Coast, USSR Zone 7') ";
$_DATA[240] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('jst',32400,'Japan Standard, USSR Zone 8') ";
$_DATA[241] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cas',34200,'Central Australian Standard') ";
$_DATA[242] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('eas',36000,'Eastern Australian Standard') ";
$_DATA[243] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nzt',43200,'New Zealand') ";
$_DATA[244] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nzs',43200,'New Zealand Standard') ";
$_DATA[245] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('id2',43200,'International Date Line East') ";
$_DATA[246] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('idt',10800,'Israel Daylight') ";
$_DATA[247] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('iss',7200,'Israel Standard') ";

$_DATA[248] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (1,'nested','ASC',100) ";
$_DATA[249] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (2,'threaded','ASC',100) ";
$_DATA[250] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (3,'threaded','ASC',100) ";
$_DATA[251] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (0,'threaded','ASC',100) ";
$_DATA[253] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (5,'threaded','ASC',100) ";
$_DATA[254] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (8,'threaded','ASC',100) ";
$_DATA[255] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (6,'threaded','ASC',100) ";
$_DATA[256] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (7,'threaded','ASC',100) ";
$_DATA[257] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (9,'threaded','ASC',100) ";
$_DATA[258] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (10,'threaded','ASC',100) ";
$_DATA[259] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (11,'threaded','ASC',100) ";
$_DATA[260] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (12,'threaded','ASC',100) ";


$_DATA[266] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (1,'','','','',0,NULL) ";
$_DATA[267] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (2,'','','','',0,NULL) ";
$_DATA[268] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (3,'','','','',0,NULL) ";
$_DATA[269] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (5,'','','','',0,NULL) ";
$_DATA[270] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (0,'','','','',0,NULL) ";
$_DATA[272] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (8,'','','','',0,NULL) ";
$_DATA[273] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (6,'','','','',0,NULL) ";
$_DATA[273] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (7,'','','','',0,NULL) ";
$_DATA[274] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (9,'','','','',0,NULL) ";
$_DATA[275] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (10,'','','','',0,NULL) ";
$_DATA[276] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (11,'','','','',0,NULL) ";
$_DATA[277] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, eids, aids, boxes, noboxes, maxstories) VALUES (12,'','','','',0,NULL) ";

$_DATA[283] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (1,'Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner Owner ','','',0,0,0) ";
$_DATA[284] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (2,NULL,NULL,'',0,0,0) ";
$_DATA[285] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (3,NULL,NULL,'',0,0,0) ";
$_DATA[286] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (5,NULL,NULL,'',0,0,0) ";
$_DATA[287] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (0,NULL,NULL,'',0,0,0) ";
$_DATA[288] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (4,NULL,NULL,'',0,0,0) ";
$_DATA[289] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (8,NULL,NULL,'',0,0,0) ";
$_DATA[290] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (6,NULL,NULL,'',0,0,0) ";
$_DATA[291] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (7,NULL,NULL,'',0,0,0) ";
$_DATA[292] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (9,NULL,NULL,'',0,0,0) ";
$_DATA[293] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (10,NULL,NULL,'',0,0,0) ";
$_DATA[294] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (11,NULL,NULL,'',0,0,0) ";
$_DATA[295] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (12,NULL,NULL,'',0,0,0) ";
$_DATA[301] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (1,0,0,0,'',0) ";
$_DATA[302] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (2,0,1,0,'edt',1) ";
$_DATA[303] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (3,0,1,0,'edt',1) ";
$_DATA[304] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (5,0,1,0,'edt',1) ";
$_DATA[305] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (0,0,1,0,'edt',1) ";
$_DATA[307] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (8,0,1,0,'edt',1) ";
$_DATA[308] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (6,0,1,0,'edt',1) ";
$_DATA[309] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (7,0,1,0,'edt',1) ";
$_DATA[310] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (9,0,1,0,'edt',1) ";
$_DATA[311] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (10,0,1,0,'edt',1) ";
$_DATA[312] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (11,0,1,0,'edt',1) ";
$_DATA[313] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (12,0,1,0,'edt',1) ";

#
# Dumping data for table 'users'
#

$_DATA[319] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (1,'Anonymous','Anonymous','',NULL,NULL,'','2001-09-28 13:36:52',0,NULL) ";
$_DATA[320] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (2,'Admin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','http://geekog.sourceforge.net','','0000-00-00 00:00:00',0,NULL) ";
$_DATA[321] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (3,'StoryAdmin','Story Admin','5f4dcc3b5aa765d61d8327deb882cf99','root','http://geeklog.sourceforge.net','','2001-09-28 13:36:56',NULL,NULL) ";
$_DATA[322] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (5,'PollAdmin','Poll Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL) ";
$_DATA[323] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (6,'TopicAdmin','Topic Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL) ";
$_DATA[324] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (7,'BlockAdmin','Block Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL) ";
$_DATA[325] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (8,'LinkAdmin','Link Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL) ";
$_DATA[326] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (9,'EventAdmin','Event Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL) ";
$_DATA[327] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (10,'UserAdmin','User Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL) ";
$_DATA[328] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (11,'MailAdmin','Mail Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL) ";
$_DATA[329] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (12,'GroupAdmin','Group Administrator','5f4dcc3b5aa765d61d8327deb882cf99','root','','','2001-09-28 13:36:56',NULL,NULL) ";

$_DATA[330] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('totalhits','0') ";
$_DATA[331] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastemailedstories','') ";

?>
