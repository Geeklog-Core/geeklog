# MySQL dump 8.14
#
# Host: localhost    Database: geeklog 
#--------------------------------------------------------
# Server version	3.23.41

#
# Table structure for table 'access'
#

CREATE TABLE access (
  acc_ft_id mediumint(8) NOT NULL default '0',
  acc_grp_id mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (acc_ft_id,acc_grp_id)
) TYPE=MyISAM;

#
# Table structure for table 'blocks'
#

CREATE TABLE blocks (
  bid smallint(5) unsigned NOT NULL auto_increment,
  name varchar(48) NOT NULL default '',
  type varchar(20) NOT NULL default 'normal',
  title varchar(48) default NULL,
  tid varchar(20) NOT NULL default 'All',
  blockorder tinyint(3) unsigned NOT NULL default '1',
  content text,
  rdfurl varchar(96) default NULL,
  rdfupdated datetime NOT NULL default '0000-00-00 00:00:00',
  help varchar(96) default NULL,
  onleft tinyint(3) unsigned NOT NULL default '1',
  phpblockfn varchar(64) default '',
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (bid)
) TYPE=MyISAM;

#
# Table structure for table 'commentcodes'
#

CREATE TABLE commentcodes (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Table structure for table 'commentmodes'
#

CREATE TABLE commentmodes (
  mode varchar(10) NOT NULL default '',
  name varchar(32) default NULL,
  PRIMARY KEY  (mode)
) TYPE=MyISAM;

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
# Table structure for table 'commentspeedlimit'
#

CREATE TABLE commentspeedlimit (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Table structure for table 'cookiecodes'
#

CREATE TABLE cookiecodes (
  cc_value int(8) unsigned NOT NULL default '0',
  cc_descr varchar(20) NOT NULL default '',
  PRIMARY KEY  (cc_value)
) TYPE=MyISAM;

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
# Table structure for table 'events'
#

CREATE TABLE events (
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
) TYPE=MyISAM;

#
# Table structure for table 'eventsubmission'
#

CREATE TABLE eventsubmission (
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
) TYPE=MyISAM;

#
# Table structure for table 'featurecodes'
#

CREATE TABLE featurecodes (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Table structure for table 'features'
#

CREATE TABLE features (
  ft_id mediumint(8) NOT NULL auto_increment,
  ft_name varchar(20) NOT NULL default '',
  ft_descr varchar(255) NOT NULL default '',
  ft_gl_core tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ft_id),
  KEY ft_name (ft_name)
) TYPE=MyISAM;

#
# Table structure for table 'frontpagecodes'
#

CREATE TABLE frontpagecodes (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Table structure for table 'group_assignments'
#

CREATE TABLE group_assignments (
  ug_main_grp_id mediumint(8) NOT NULL default '0',
  ug_uid mediumint(8) unsigned default NULL,
  ug_grp_id mediumint(8) unsigned default NULL,
  KEY ug_main_grp_id (ug_main_grp_id)
) TYPE=MyISAM;

#
# Table structure for table 'groups'
#

CREATE TABLE groups (
  grp_id mediumint(8) NOT NULL auto_increment,
  grp_name varchar(50) NOT NULL default '',
  grp_descr varchar(255) NOT NULL default '',
  grp_gl_core tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (grp_id),
  KEY grp_name (grp_name)
) TYPE=MyISAM;

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
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (lid)
) TYPE=MyISAM;

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
# Table structure for table 'maillist'
#

CREATE TABLE maillist (
  code int(1) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Table structure for table 'personal_events'
#

CREATE TABLE personal_events (
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
) TYPE=MyISAM;

#
# Table structure for table 'plugins'
#

CREATE TABLE plugins (
  pi_name varchar(30) NOT NULL default '',
  pi_version varchar(20) NOT NULL default '',
  pi_gl_version varchar(20) NOT NULL default '',
  pi_enabled tinyint(3) unsigned NOT NULL default '1',
  pi_homepage varchar(128) NOT NULL default '',
  PRIMARY KEY  (pi_name)
) TYPE=MyISAM;

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
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (qid)
) TYPE=MyISAM;

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
# Table structure for table 'postmodes'
#

CREATE TABLE postmodes (
  code char(10) NOT NULL default '',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

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
# Table structure for table 'sortcodes'
#

CREATE TABLE sortcodes (
  code char(4) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Table structure for table 'statuscodes'
#

CREATE TABLE statuscodes (
  code int(1) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM;

#
# Table structure for table 'stories'
#

CREATE TABLE stories (
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
  frontpage tinyint(3) unsigned default '1',
  owner_id mediumint(8) NOT NULL default '1',
  group_id mediumint(8) NOT NULL default '2',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (sid)
) TYPE=MyISAM;

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
# Table structure for table 'submitspeedlimit'
#

CREATE TABLE submitspeedlimit (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Table structure for table 'topics'
#

CREATE TABLE topics (
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
) TYPE=MyISAM;

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
# Table structure for table 'userindex'
#

CREATE TABLE userindex (
  uid mediumint(8) NOT NULL default '1',
  tids varchar(255) NOT NULL default '',
  etids varchar(255) NOT NULL default '',
  aids varchar(255) NOT NULL default '',
  boxes varchar(255) NOT NULL default '',
  noboxes tinyint(4) NOT NULL default '0',
  maxstories tinyint(4) default NULL,
  PRIMARY KEY  (uid)
) TYPE=MyISAM;

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
# Table structure for table 'users'
#

CREATE TABLE users (
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
) TYPE=MyISAM;

#
# Table structure for table 'vars'
#

CREATE TABLE vars (
  name varchar(20) NOT NULL default '',
  value varchar(128) default NULL,
  PRIMARY KEY  (name)
) TYPE=MyISAM;

