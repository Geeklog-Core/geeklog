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
  is_enabled tinyint(1) unsigned NOT NULL DEFAULT '1',
  name varchar(48) NOT NULL default '',
  type varchar(20) NOT NULL default 'normal',
  title varchar(48) default NULL,
  tid varchar(20) NOT NULL default 'All',
  blockorder smallint(5) unsigned NOT NULL default '1',
  content text,
  rdfurl varchar(255) default NULL,
  rdfupdated datetime NOT NULL default '0000-00-00 00:00:00',
  onleft tinyint(3) unsigned NOT NULL default '1',
  phpblockfn varchar(64) default '',
  help varchar(128) default '',
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  INDEX blocks_bid(bid),
  INDEX blocks_is_enabled(is_enabled),
  INDEX blocks_tid(tid),
  INDEX blocks_type(type),
  INDEX blocks_name(name),
  INDEX blocks_onleft(onleft),
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
  type varchar(30) NOT NULL DEFAULT 'article',
  sid varchar(20) NOT NULL default '',
  date datetime default NULL,
  title varchar(128) default NULL,
  comment text,
  score tinyint(4) NOT NULL default '0',
  reason tinyint(4) NOT NULL default '0',
  pid int(10) unsigned NOT NULL default '0',
  lft mediumint(10) unsigned NOT NULL default '0',
  rht mediumint(10) unsigned NOT NULL default '0',
  indent mediumint(10) unsigned NOT NULL default '0',
  uid mediumint(8) NOT NULL default '1',
  ipaddress varchar(15) NOT NULL default '',
  INDEX comments_sid(sid),
  INDEX comments_uid(uid),
  INDEX comments_lft(lft),
  INDEX comments_rht(rht),
  PRIMARY KEY  (cid)
) TYPE=MyISAM
";

$_SQL[6] = "
CREATE TABLE {$_TABLES['cookiecodes']} (
  cc_value int(8) unsigned NOT NULL default '0',
  cc_descr varchar(20) NOT NULL default '',
  PRIMARY KEY  (cc_value)
) TYPE=MyISAM
";

$_SQL[7] = "
CREATE TABLE {$_TABLES['dateformats']} (
  dfid tinyint(4) NOT NULL default '0',
  format varchar(32) default NULL,
  description varchar(64) default NULL,
  PRIMARY KEY  (dfid)
) TYPE=MyISAM
";

$_SQL[8] = "
CREATE TABLE {$_TABLES['events']} (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  description text,
  datestart date default NULL,
  dateend date default NULL,
  url varchar(255) default NULL,
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
  INDEX events_eid(eid),
  INDEX events_event_type(event_type),
  PRIMARY KEY  (eid)
) TYPE=MyISAM
";

$_SQL[9] = "
CREATE TABLE {$_TABLES['eventsubmission']} (
  eid varchar(20) NOT NULL default '',
  title varchar(128) default NULL,
  description text,
  location varchar(128) default NULL,
  datestart date default NULL,
  dateend date default NULL,
  url varchar(255) default NULL,
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

$_SQL[10] = "
CREATE TABLE {$_TABLES['featurecodes']} (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[11] = "
CREATE TABLE {$_TABLES['features']} (
  ft_id mediumint(8) NOT NULL auto_increment,
  ft_name varchar(20) NOT NULL default '',
  ft_descr varchar(255) NOT NULL default '',
  ft_gl_core tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (ft_id),
  KEY ft_name (ft_name)
) TYPE=MyISAM
";

$_SQL[12] = "
CREATE TABLE {$_TABLES['frontpagecodes']} (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[13] = "
CREATE TABLE {$_TABLES['group_assignments']} (
  ug_main_grp_id mediumint(8) NOT NULL default '0',
  ug_uid mediumint(8) unsigned default NULL,
  ug_grp_id mediumint(8) unsigned default NULL,
  INDEX group_assignments_ug_main_grp_id(ug_main_grp_id),
  KEY ug_main_grp_id (ug_main_grp_id)
) TYPE=MyISAM
";

$_SQL[14] = "
CREATE TABLE {$_TABLES['groups']} (
  grp_id mediumint(8) NOT NULL auto_increment,
  grp_name varchar(50) NOT NULL default '',
  grp_descr varchar(255) NOT NULL default '',
  grp_gl_core tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (grp_id),
  KEY grp_name (grp_name)
) TYPE=MyISAM
";

$_SQL[15] = "
CREATE TABLE {$_TABLES['links']} (
  lid varchar(20) NOT NULL default '',
  category varchar(32) default NULL,
  url varchar(255) default NULL,
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
  INDEX links_lid(lid),
  PRIMARY KEY  (lid)
) TYPE=MyISAM
";

$_SQL[16] = "
CREATE TABLE {$_TABLES['linksubmission']} (
  lid varchar(20) NOT NULL default '',
  category varchar(32) default NULL,
  url varchar(255) default NULL,
  description text,
  title varchar(96) default NULL,
  hits int(11) default NULL,
  date datetime default NULL,
  PRIMARY KEY  (lid)
) TYPE=MyISAM
";

$_SQL[17] = "
CREATE TABLE {$_TABLES['maillist']} (
  code int(1) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[18] = "
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
  url varchar(255) default NULL,
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
  PRIMARY KEY  (eid,uid)
) TYPE=MyISAM
";

$_SQL[19] = "
CREATE TABLE {$_TABLES['plugins']} (
  pi_name varchar(30) NOT NULL default '',
  pi_version varchar(20) NOT NULL default '',
  pi_gl_version varchar(20) NOT NULL default '',
  pi_enabled tinyint(3) unsigned NOT NULL default '1',
  pi_homepage varchar(128) NOT NULL default '',
  INDEX plugins_enabled(pi_enabled),
  PRIMARY KEY  (pi_name)
) TYPE=MyISAM
";

$_SQL[20] = "
CREATE TABLE {$_TABLES['pollanswers']} (
  qid varchar(20) NOT NULL default '',
  aid tinyint(3) unsigned NOT NULL default '0',
  answer varchar(255) default NULL,
  votes mediumint(8) unsigned default NULL,
  PRIMARY KEY  (qid,aid)
) TYPE=MyISAM
";

$_SQL[21] = "
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
  INDEX pollquestions_qid(qid),
  INDEX pollquestions_display(display),
  INDEX pollquestions_commentcode(commentcode),
  INDEX pollquestions_statuscode(statuscode),
  PRIMARY KEY  (qid)
) TYPE=MyISAM
";

$_SQL[22] = "
CREATE TABLE {$_TABLES['pollvoters']} (
  id int(10) unsigned NOT NULL auto_increment,
  qid varchar(20) NOT NULL default '',
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM
";

$_SQL[23] = "
CREATE TABLE {$_TABLES['postmodes']} (
  code char(10) NOT NULL default '',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[24] = "
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

$_SQL[25] = "
CREATE TABLE {$_TABLES['sortcodes']} (
  code char(4) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[26] = "
CREATE TABLE {$_TABLES['speedlimit']} (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '', 
  date int(10) unsigned default NULL,
  type varchar(30) NOT NULL default 'submit',
  PRIMARY KEY (id) 
) TYPE = MyISAM
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
  show_topic_icon tinyint(1) unsigned NOT NULL default '1',
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  expire DATETIME NOT NULL,
  postmode varchar(10) NOT NULL default 'html',
  frontpage tinyint(3) unsigned default '1',
  owner_id mediumint(8) NOT NULL default '1',
  group_id mediumint(8) NOT NULL default '2',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  INDEX stories_sid(sid),
  INDEX stories_tid(tid),
  INDEX stories_uid(uid),
  INDEX stories_featured(featured),
  INDEX stories_hits(hits),
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
CREATE TABLE {$_TABLES['syndication']} (
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
  INDEX syndication_topic(topic),
  INDEX syndication_is_enabled(is_enabled),
  INDEX syndication_updated(updated)
) TYPE=MyISAM
";

$_SQL[31] = "
CREATE TABLE {$_TABLES['topics']} (
  tid varchar(20) NOT NULL default '',
  topic varchar(48) default NULL,
  imageurl varchar(255) default NULL,
  sortnum tinyint(3) default NULL,
  limitnews tinyint(3) default NULL,
  is_default tinyint(1) unsigned NOT NULL DEFAULT '0',
  archive_flag tinyint(1) unsigned NOT NULL DEFAULT '0',
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

$_SQL[34] = "
CREATE TABLE {$_TABLES['userindex']} (
  uid mediumint(8) NOT NULL default '1',
  tids varchar(255) NOT NULL default '',
  etids varchar(255) NOT NULL default '',
  aids varchar(255) NOT NULL default '',
  boxes varchar(255) NOT NULL default '',
  noboxes tinyint(4) NOT NULL default '0',
  maxstories tinyint(4) default NULL,
  INDEX userindex_uid(uid),
  INDEX userindex_noboxes(noboxes),
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[35] = "
CREATE TABLE {$_TABLES['userinfo']} (
  uid mediumint(8) NOT NULL default '1',
  about text,
  pgpkey text,
  userspace varchar(255) NOT NULL default '',
  tokens tinyint(3) unsigned NOT NULL default '0',
  totalcomments mediumint(9) NOT NULL default '0',
  lastgranted int(10) unsigned NOT NULL default '0',
  lastlogin VARCHAR(10) NOT NULL default '0',
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[36] = "
CREATE TABLE {$_TABLES['userprefs']} (
  uid mediumint(8) NOT NULL default '1',
  noicons tinyint(3) unsigned NOT NULL default '0',
  willing tinyint(3) unsigned NOT NULL default '1',
  dfid tinyint(3) unsigned NOT NULL default '0',
  tzid char(3) NOT NULL default 'edt',
  emailstories tinyint(4) NOT NULL default '1',
  emailfromadmin tinyint(1) NOT NULL default '1',
  emailfromuser tinyint(1) NOT NULL default '1',
  showonline tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[37] = "
CREATE TABLE {$_TABLES['users']} (
  uid mediumint(8) NOT NULL auto_increment,
  username varchar(16) NOT NULL default '',
  fullname varchar(80) default NULL,
  passwd varchar(32) NOT NULL default '',
  email varchar(96) default NULL,
  homepage varchar(96) default NULL,
  sig varchar(160) NOT NULL default '',
  regdate datetime NOT NULL default '0000-00-00 00:00:00',
  photo varchar(128) DEFAULT NULL,
  cookietimeout int(8) unsigned default '28800',
  theme varchar(64) default NULL,
  language varchar(64) default NULL,
  pwrequestid varchar(16) default NULL,
  PRIMARY KEY  (uid),
  KEY LOGIN (uid,passwd,username)
) TYPE=MyISAM
";

$_SQL[38] = "
CREATE TABLE {$_TABLES['vars']} (
  name varchar(20) NOT NULL default '',
  value varchar(128) default NULL,
  PRIMARY KEY  (name)
) TYPE=MyISAM
";

$_SQL[39] = "
CREATE TABLE {$_TABLES['article_images']} (
  ai_sid varchar(20) NOT NULL,
  ai_img_num tinyint(2) unsigned NOT NULL,
  ai_filename varchar(128) NOT NULL,
  PRIMARY KEY (ai_sid,ai_img_num)
) TYPE=MyISAM
";

$_SQL[40] = "
CREATE TABLE {$_TABLES['staticpage']} (
  sp_id varchar(20) NOT NULL default '',
  sp_uid mediumint(8) NOT NULL default '1',
  sp_title varchar(128) NOT NULL default '',
  sp_content text NOT NULL,
  sp_hits mediumint(8) unsigned NOT NULL default '0',
  sp_date datetime NOT NULL default '0000-00-00 00:00:00',
  sp_format varchar(20) NOT NULL default '',
  sp_onmenu tinyint(1) unsigned NOT NULL default '0',
  sp_label varchar(64) default NULL,
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  sp_centerblock tinyint(1) unsigned NOT NULL default '0',
  sp_tid varchar(20) NOT NULL default 'none',
  sp_where tinyint(1) unsigned NOT NULL default '1',
  sp_php tinyint(1) unsigned NOT NULL default '0',
  sp_nf tinyint(1) unsigned default '0',
  sp_inblock tinyint(1) unsigned default '1',
  PRIMARY KEY  (sp_id),
  KEY staticpage_sp_uid (sp_uid),
  KEY staticpage_sp_date (sp_date),
  KEY staticpage_sp_onmenu (sp_onmenu),
  KEY staticpage_sp_centerblock (sp_centerblock),
  KEY staticpage_sp_tid (sp_tid),
  KEY staticpage_sp_where (sp_where)
) TYPE=MyISAM
";
 
$_SQL[41] = "
CREATE TABLE {$_TABLES['spamx']} ("
	. " name varchar(20) NOT NULL default '',"
	. " value varchar(255) NOT NULL default '',"
	. " INDEX name (name)"
	. ") TYPE=MyISAM
";

$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (1,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (2,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (3,5) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (4,5) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,9) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,9) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES(7,12) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (8,7) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (9,7) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (10,4) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (11,6) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (12,8) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (13,10) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (14,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (15,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (16,4) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (17,14) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (18,14) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (23,15) ";

$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (1,'user_block','gldefault','User Functions','all',2,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (2,'admin_block','gldefault','Admins Only','all',1,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (3,'section_block','gldefault','Topics','all',0,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (4,'poll_block','gldefault','Poll','all',2,'','','0000-00-00 00:00:00',0,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (5,'events_block','gldefault','Events','all',4,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (6,'whats_new_block','gldefault','What\'s New','all',3,'','','0000-00-00 00:00:00',0,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (7,'first_block','normal','About GeekLog','all',1,'<b>Welcome to GeekLog!</b><br>If you\'re already familiar with GeekLog - and especially if you\'re not: There have been many improvements to GeekLog since earlier versions that you might want to read up on. Please read the release notes in the /docs directory and go over the install guide.','','0000-00-00 00:00:00',0,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (8,'whosonline_block','phpblock','Who\'s Online','all',0,'','','0000-00-00 00:00:00',0,'phpblock_whosonline',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (9,'older_stories','gldefault','Older Stories','all',5,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (10,'security_check','phpblock','Are you secure?','homeonly',3,'','','0000-00-00 00:00:00',1,'phpblock_getBent',1,2,3,3,0,0) ";

$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (0,'Comments Enabled') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (-1,'Comments Disabled') ";

$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('flat','Flat') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nested','Nested') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('threaded','Threaded') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nocomment','No Comments') ";

$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (0,'(don\'t)') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (3600,'1 Hour') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (7200,'2 Hours') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (10800,'3 Hours') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (28800,'8 Hours') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (86400,'1 Day') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (604800,'1 Week') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (2678400,'1 Month') ";

$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (0,'','System Default') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (1,'%A %B %d, %Y @%I:%M%p','Sunday March 21, 1999 @10:00PM') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (2,'%A %b %d, %Y @%H:%M','Sunday March 21, 1999 @22:00') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (4,'%A %b %d @%H:%M','Sunday March 21 @22:00') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (5,'%H:%M %d %B %Y','22:00 21 March 1999') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (6,'%H:%M %A %d %B %Y','22:00 Sunday 21 March 1999') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (7,'%I:%M%p - %A %B %d %Y','10:00PM -- Sunday March 21 1999') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (8,'%a %B %d, %I:%M%p','Sun March 21, 10:00PM') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (9,'%a %B %d, %H:%M','Sun March 21, 22:00') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (10,'%m-%d-%y %H:%M','3-21-99 22:00') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (11,'%d-%m-%y %H:%M','21-3-99 22:00') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (12,'%m-%d-%y %I:%M%p','3-21-99 10:00PM') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (13,'%I:%M%p  %B %D, %Y','10:00PM  March 21st, 1999') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (14,'%a %b %d, \'%y %I:%M%p','Sun Mar 21, \'99 10:00PM') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (15,'Day %j, %I ish','Day 80, 10 ish') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (16,'%y-%m-%d %I:%M','99-03-21 10:00') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (17,'%d/%m/%y %H:%M','21/03/99 22:00') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (18,'%a %d %b %I:%M%p','Sun 21 Mar 10:00PM') ";

$_DATA[] = "INSERT INTO {$_TABLES['eventsubmission']} (eid, title, description, location, datestart, dateend, url, allday, zipcode, state, city, address2, address1, event_type, timestart, timeend) VALUES ('2003110114064662','Test event','test','Test','2003-11-02','2003-11-03','http://www.tonybibbs.com',0,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL) ";

$_DATA[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (0,'Not Featured') ";
$_DATA[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (1,'Featured') ";

$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (1,'story.edit','Access to story editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (2,'story.moderate','Ablility to moderate pending stories',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (3,'link.moderate','Ablility to moderate pending links',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (4,'link.edit','Access to link editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (5,'user.edit','Access to user editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (6,'user.delete','Ablility to delete a user',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (7,'user.mail','Ablility to send email to members',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (8,'event.moderate','Ablility to moderate pending events',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (9,'event.edit','Access to event editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (10,'block.edit','Access to block editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (11,'topic.edit','Access to topic editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (12,'poll.edit','Access to poll editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (13,'plugin.edit','Access to plugin editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (14,'group.edit','Ability to edit groups',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (15,'group.delete','Ability to delete groups',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (16,'block.delete','Ability to delete a block',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (17,'staticpages.edit','Ability to edit a static page',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (18,'staticpages.delete','Ability to delete static pages',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (19,'story.submit','May skip the story submission queue',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (20,'link.submit','May skip the link submission queue',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (21,'event.submit','May skip the event submission queue',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (22,'staticpages.PHP','Ability use PHP in static pages',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (23,'spamx.admin', 'spamx Admin', 0) ";

$_DATA[] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (0,'Show Only in Topic') ";
$_DATA[] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (1,'Show on Front Page') ";

$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,1,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,12) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,10) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,9) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,8) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,7) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,6) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,5) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,4) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,3,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,3,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,3,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,3,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,3,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (7,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (14,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (15,NULL,1) ";

$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (1,'Root','Has full access to the site',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (2,'All Users','Group that a typical user is added to',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (3,'Story Admin','Has full access to story features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (4,'Block Admin','Has full access to block features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (5,'Link Admin','Has full access to link features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (6,'Topic Admin','Has full access to topic features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (7,'Event Admin','Has full access to event features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (8,'Poll Admin','Has full access to poll features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (9,'User Admin','Has full access to user features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (10,'Plugin Admin','Has full access to plugin features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (11,'Group Admin','Is a User Admin with Acces to Groups too',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (12,'Mail Admin','Can Use Mail Utility',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (13,'Logged-in Users','All Registered Members',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (14,'Static Page Admin','Can administer static pages',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (15,'spamx Admin', 'Users in this group can administer the spamx plugin',0) ";

$_DATA[] = "INSERT INTO {$_TABLES['links']} (lid, category, url, description, title, hits, date, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20040119095147683','Geeklog Sites','http://www.geeklog.net','All you ever need to know about GeekLog - and more ...','Geeklog Project Homepage',42,NULL,5,2,3,3,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (0,'Don\'t Email') ";
$_DATA[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (1,'Email Headlines Each Night') ";

$_DATA[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('staticpages', '1.4.1','1.3.9',1,'http://www.tonybibbs.com') ";
$_DATA[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('spamx', '1.0','1.3.9',1,'http://www.pigstye.net/gplugs/staticpages/index.php/spamx') ";

$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',1,'Static Pages plugin 1.3',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',2,'New Forgot Password function',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',3,'Users can delete their account',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',4,'Cloning of Events',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',5,'New privacy options',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',6,'Extended plugin API',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',7,'Other',0) ";

$_DATA[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, question, voters, date, display, commentcode, statuscode, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklogfeaturepoll','What is the best new feature of Geeklog?',0,'2004-01-01 12:43:20',1,0,0,8,2,3,3,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('plaintext','Plain Old Text') ";
$_DATA[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('html','HTML Formatted') ";

$_DATA[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('ASC','Oldest First') ";
$_DATA[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('DESC','Newest First') ";

$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (1,'Refreshing') ";
$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (0,'Normal') ";
$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (10,'Archive') ";

$_DATA[] = "INSERT INTO {$_TABLES['stories']} (sid, uid, draft_flag, tid, date, title, introtext, bodytext, hits, numemails, comments, related, featured, commentcode, statuscode, postmode, frontpage, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20040101093000103',2,0,'GeekLog','2004-01-01 09:30:00','Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing GeekLog. Please take the time to read everything in the docs directory. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.\r\r<p>Below are a list of usernames that have access to a specific portion of the site. While Admin has access to everything, Moderator only has access to the areas related to stories, links, and events. The password for each account is <b>password</b>. \r\r<p>Accounts:\r<ul>\r<li>Admin</li>\r<li>Moderator</li>\r</ul>','',100,1,0,'<li><a href=\"/search.php?mode=search&amp;type=stories&amp;author=2\">More by Admin</a><li><a href=\"/search.php?mode=search&amp;type=stories&amp;topic=GeekLog\">More from GeekLog</a>',1,0,0,'html',1,2,3,3,3,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['storysubmission']} (sid, uid, tid, title, introtext, date, postmode) VALUES ('20040101120556538',2,'GeekLog','Are you secure?','<p>This is a reminder to secure your site once you have Geeklog up and running. What you should do:</p>\r\r<ol>\r<li>Change the default password for all Admin accounts.</li>\r<li>Remove the install directory (you won\'t need it any more).</li>\r</ol>','2004-01-01 12:05:56','html') ";

$_DATA[] = "INSERT INTO {$_TABLES['syndication']} (type, topic, format, limits, content_length, title, description, filename, charset, language, is_enabled, updated, update_info) VALUES ('geeklog', '::all', 'rss', 10, 0, 'Geeklog Site', 'Another Nifty Geeklog Site', 'geeklog.rdf', 'UTF-8', 'en-gb', 1, '0000-00-00 00:00:00', NULL)";

$_DATA[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('General','General News','/images/topics/topic_news.gif',1,10,6,2,3,2,2,2)";
$_DATA[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('GeekLog','GeekLog','/images/topics/topic_gl.gif',2,10,6,2,3,2,2,2)";

$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ndt',-9000,'Newfoundland Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('adt',-10800,'Atlantic Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('edt',-14400,'Eastern Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cdt',-18000,'Central Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mdt',-21600,'Mountain Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('pdt',-25200,'Pacific Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ydt',-28800,'Yukon Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('hdt',-32400,'Hawaii Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('bst',3600,'British Summer') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mes',7200,'Middle European Summer') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('sst',7200,'Swedish Summer') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('fst',7200,'French Summer') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('wad',28800,'West Australian Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cad',37800,'Central Australian Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ead',39600,'Eastern Australian Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nzd',46800,'New Zealand Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('gmt',0,'Greenwich Mean') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('utc',0,'Universal (Coordinated)') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('wet',0,'Western European') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('wat',-3600,'West Africa') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('at',-7200,'Azores') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('gst',-10800,'Greenland Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nft',-12600,'Newfoundland') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nst',-12600,'Newfoundland Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ast',-14400,'Atlantic Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('est',-18000,'Eastern Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cst',-21600,'Central Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mst',-25200,'Mountain Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('pst',-28800,'Pacific Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('yst',-32400,'Yukon Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('hst',-36000,'Hawaii Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cat',-36000,'Central Alaska') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ahs',-36000,'Alaska-Hawaii Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nt',-39600,'Nome') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('idl',-43200,'International Date Line West') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cet',3600,'Central European') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('met',3600,'Middle European') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('mew',3600,'Middle European Winter') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('swt',3600,'Swedish Winter') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('fwt',3600,'French Winter') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('eet',7200,'Eastern Europe, USSR Zone 1') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('bt',10800,'Baghdad, USSR Zone 2') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('it',12600,'Iran') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('zp4',14400,'USSR Zone 3') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('zp5',18000,'USSR Zone 4') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('ist',19800,'Indian Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('zp6',21600,'USSR Zone 5') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('was',25200,'West Australian Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('jt',27000,'Java (3pm in Cronusland!)') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cct',28800,'China Coast, USSR Zone 7') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('jst',32400,'Japan Standard, USSR Zone 8') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('cas',34200,'Central Australian Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('eas',36000,'Eastern Australian Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nzt',43200,'New Zealand') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('nzs',43200,'New Zealand Standard') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('id2',43200,'International Date Line East') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('idt',10800,'Israel Daylight') ";
$_DATA[] = "INSERT INTO {$_TABLES['tzcodes']} (tz, offset, description) VALUES ('iss',7200,'Israel Standard') ";

$_DATA[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (1,'nested','ASC',100) ";
$_DATA[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (2,'threaded','ASC',100) ";
$_DATA[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (3,'threaded','ASC',100) ";

$_DATA[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (1,'','-','','',0,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (2,'','','','',0,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (3,'','','','',0,NULL) ";

$_DATA[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (1,NULL,NULL,'',0,0,0) ";
$_DATA[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (2,NULL,NULL,'',0,0,0) ";
$_DATA[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (3,NULL,NULL,'',0,0,0) ";

$_DATA[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (1,0,0,0,'',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (2,0,1,0,'edt',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (3,0,1,0,'edt',1) ";

#
# Dumping data for table 'users'
#

$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (1,'Anonymous','Anonymous','',NULL,NULL,'','2004-01-01 00:00:01',0,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (2,'Admin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','http://www.geeklog.net','','2004-01-01 00:00:02',28800,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (3,'Moderator','Moderator','5f4dcc3b5aa765d61d8327deb882cf99','moderator','http://www.geeklog.net','','2004-01-01 00:00:03',28800,NULL) ";

$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('totalhits','0') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastemailedstories','') ";

#
# Dumping data for spamx
#
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','([w-_.]+.)?(l(so|os)tr).[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(blow)[w-_.]*job[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(buy)[w-_.]*online[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(diet|penis)[w-_.]*(pills|enlargement)[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(i|la)-sonneries?[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(levitra|lolita|phentermine|viagra|vig-?rx|zyban|valtex|xenical|adipex|meridia\b)[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(magazine)[w-_.]*(finder|netfirms)[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(mike)[w-_.]*apartment[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(milf)[w-_.]*(hunter|moms|fucking)[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(online)[w-_.]*casino[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(prozac|zoloft|xanax|valium|hydrocodone|vicodin|paxil|vioxx)[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(ragazze)-?w+.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(ultram\b|\btenuate|tramadol|pheromones|phendimetrazine|ionamin|ortho.?tricyclen|retin.?a)[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','(valtrex|zyrtec|\bhgh\b|ambien\b|flonase|allegra|didrex|renova\b|bontril|nexium)[w-_.]*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-beltonen.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-klingeltoene.at')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-klingeltoene.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-loghi.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-logo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-logot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-logotyper.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-melodia.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-melodias.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-ringetone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-ringsignaler.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-ringtone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-ringtones.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-soittoaanet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-suonerie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01-toque.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','01ringtones.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0adult-cartoon.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0adult-manga.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0cartoon-porn.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0cartoon-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0cartoon.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0casino-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0casinoonline.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0catch.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0free-hentai.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0freehentai.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0hentai-anime.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0hentai-manga.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0hentaimanga.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0internet-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0livesex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0manga-porno.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0manga-sesso.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0manga.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0sesso-amatoriale.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0sesso-orale.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0sesso.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0sesso.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0sessoanale.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0sessogratis.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0sex-toons.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0sfondi-desktop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0sfondi.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0suonerie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0tatuaggi.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0toons.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0video-porno.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0virtual-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','0xxx-cartoon.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1-bignaturals.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1-cumfiesta.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1-klingeltone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1-online-poker.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1-welivetogether.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1-wholesale-distributor.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','100-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','100hgh.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','101pills.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','123sessogratis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','125mb.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','15668.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1concerttickets.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1footballtickets.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1st-auto-insurance-4u.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1st-host.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1st-payday-loans.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1st-phonecard.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1st-poker-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1st-printer-ink-cartridge.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1st-shemale-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1stlookcd.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1xp6z.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','216.130.167.230')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','24-hour-fitness-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','3-day-diet-plan.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','333-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','333-poker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','3333.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','365jp.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','3host.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','404host.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','42tower.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','444-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','444-poker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','4mg.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','4u-topshelfpussy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','4womenoftheworld.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','51asa.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','555-poker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','65.217.108.182')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','666-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','666-gambling.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','69.61.11.163')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','888-online-poker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','8k.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','8thS*streetS*latinaS*.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','\bby.ru\b')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','\bda.ru\b')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','\bde.tc\b')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','\bde.gg\b')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','\bde.nr\b')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','\bde.tp\b')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','\bgo.ro\b')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','a&#8212;e.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','a-1-versicherungsvergleich.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','a-pics.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','a-purfectdream-expression.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','a-stories.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','abc3x.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','abnehmen-ganz-sicher.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','abymetro.org.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','accompagnatrici.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','acornwebdesign.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','acyclovir.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adult-dvd-dot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adult-dvds-dot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adult-free-webcams.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adult-friend.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adult-manga.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adult-porno.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adultfreehosting.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adultfriendfinder.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adultfriendfindernow.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adultfriendfindersite.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adultfriendsite.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adulthostpro.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adultlingerieuk.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adultserviceproviders.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','adultshare.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','advantage-quotes.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','aektschen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','aesthetics.co.il')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','afreeserver.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','airshow-china.com.cn')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','all-debt-consolidation.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','all-fioricet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','all-gay-porn.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','all-we-live-together.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','allfind.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','allinsurancetype.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','allmagic.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','allohaweb.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','allthediets.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','amateur-lesbian.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','amateur-movie.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','amateur-naked.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','amateur-porn-gallery.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','amateur-porno.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','amateur-site.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','amateurs-xxx.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','amateursuite.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','american-single-dating.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','americancdduplication.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','americanpaydayloans.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','anal-sex-pictures.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','analloverz.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','andyedf.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','angenehmen-aufenthalt.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','animal-porn.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','animalsex-movies-archive.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','animalsex-pics-gallery.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','anime-adult.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','anime-hentai-porn.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','anime-manga.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','anime-porn-sex-xxx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','anime-porn.name')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','anime-sex-cartoon-porn.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','annunci-coppie.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','annunci-erotici.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','annunci-erotici.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','annunci-personali.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','annunci-sesso.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','annunci-sesso.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','annuncisesso.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','anti-exploit.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','anything4health.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ap8.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','apollopatch.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','apornhost.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','appollo.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','approval-loan.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','aquatyca.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','arcsecurity.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','area-code-npa-nxx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','argendrom.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','aromacc.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','asian-girls-porn-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','asian-girls.name')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','asian-sex-woman.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','asianbum.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ass-picture.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','atkins-diet-center.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','atkinsexpert.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','atlas-pharmacy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','auctionmoneymakers.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','auktions-uebersicht.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','auto-loans-usa.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','autodetailproducts.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','autodirektversicherung.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','autofinanzierung-autokredit.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','autofinanzierung-zum-festzins.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','autohandelsmarktplatz.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','autokredit-autofinanzierung.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','autokredit-tipp.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','automotive.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','autumn-jade.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','avon-one.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','b-witchedcentral.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','babes-d.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','babes-plus.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','baby-perfekt.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','babymarktplatz-aktiv.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bad-movies.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bad-passion.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bahraichfun.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bali-dewadewi-tours.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bali-hotels.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','balidiscovery.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','balivillas.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','banialoba3w.150m.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','banned-pics.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bannedhome.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','barcodes.cn')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bare.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','barely-legal-teenb.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','barely-legald.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bargeld-tipp.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','basi-musicali.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bast3.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','batukaru.[a-z]{2,}')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bccinet.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bdsm-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','beastiality-animal-sex-stories.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','beastiality-stories.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','beastsex-movies.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','beauty-farm.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','belle-donne.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','belle-ragazze.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','belle-ragazze.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','belleragazze.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','belleragazze.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bellissime-donne.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bellissime-donne.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bellissimedonne.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bellissimedonne.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','beltonen-logos-spel.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','benessere.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','best-buy-cialis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','best-gambling.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','best-high-speed-internet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','best-internet-bingo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','best-pharmacy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','best-result-fast.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bestasianteens.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bestdvdclubs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bestgamblinghouseonline.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','besthandever.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bestiality-pics.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bestits.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','beverlyhillspimpandhos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','beverlyhillspimpsandhos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','big-black-butts.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','big-breast-success.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','big-hooters.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','big-natural-boobs.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','big-naturals-4u.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','big-rant.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bigbras-club.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bigmag.com.ua')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bigmoms.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bigtitchaz.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','billigfluege-billige-fluege.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bio-snoop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bj-cas.cn')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bj-fyhj.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bj-hchy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bjerwai.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bjgift.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bjkhp.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bjxhjy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blackbusty.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blackjack-homepage.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blackjack-play-blackjack.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blackjack.fm')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blahblah.tk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blk-web.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bllogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blog-tips.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bloglabs.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blogman.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blogmen.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blogspam.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blonde-pussy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blonde-video.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blonde-xxx.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blumengruss-onlineshop.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','blumenshop-versand.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','body-jewelry.reestr.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','body-piercing.softinterop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bodyjock.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bon-referencement.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bondage-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','boobmorning.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','boobspost.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','breast-augmentation.top-big-tits.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bueroversand-xxl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','build-penis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bulkemailsoft.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','burningcar.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','business-grants.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','busty-models.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bustyangelique.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bustydustystash.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bustykerrymarie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','butalbital.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','buy-adult-sex-toys.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','buy-adult-toys.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','buy-computer-memory.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','buy-sex-toys.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','buycheappills.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','buystuffpayless.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','byronbayinternet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','calendari-donne.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','calendari-donne.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','calendaridonne.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','calendaridonne.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','callingcardchoice.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cambridgetherapynotebook.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cantwell2000.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzoni-italiane.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzoni-italiane.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzoni-italiane.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzoni-karaoke.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzoni-mp3.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzoni-mp3.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzoni-musica.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzoni.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzonisanremo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','canzonistraniere.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','capital-credit-cards.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','captain-stabbin-4u.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','captain-stabbin.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','car-financing-low-rates.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cardsloansmortgages.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','carnalhost.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','carnumbers.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cartoni-animati.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cartoni-hentai.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cartoni-hentai.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cartoni-hentai.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cartoni-porno.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cartonierotici.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cartonigiapponesi.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cartonihentai.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cartopia.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cash-advance-quick.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cashadvanceclub.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casino-en-ligne.fr.vu')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casino-games-4-us.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casino-in-linea.it.st')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casino-jp.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casino-online-on-line.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casino.150m.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casino.menegum.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casinochique.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casinolasvegas-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casinos-jp.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','casinos-plus.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','castingagentur2004.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cbitech.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ccie-ccnie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ccie130.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ccna-ccna.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ccna130.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ccnp-ccnp.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ccnp130.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cds-xxl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cdshop-guenstig.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','celebritylust.blog-city.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','celebritypics.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','celebskin.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','celebtastic.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','certificationking.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','certified-new-autos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','certified-new-cars.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','certified-new-suvs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','certified-used-cars.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','certified-used-suvs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','chat-l.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','chatten.bilder-j.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','chauffeurtours.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cheap-adult-sex-toys.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cheap-online-pharmacy.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cheap-pills-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cheap-web-hosting-companies.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cheapdrugpharmacy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cherrybrady.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','chickz.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','chinaaircatering.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','chloesworld.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','chrislaker.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cialis-buy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cialis-express.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cialis-weekend-pills.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cialis.homeip.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cialisapcalis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ciscochina.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','clamber.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','clanbov.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','classifiche-italiane.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','classifiche-musicali.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','classifiche-musicali.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','classifiche-musicali.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','classifichemusicali.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','claudiachristian.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cleannbright.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','click-or-not.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','clophillac.org.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','closed-network.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','club69.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','clubatlantiscasino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cmeontv.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cnbjflower.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cntoplead.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','college-girl-pic.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cometojapan.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cometomalaysia.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cometosingapore.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cometothailand.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','completelycars.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','completelyherbal.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','comptershops-online.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','computer-onlinebestellung.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','computer-und-erotische-spiele-download.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','computerversand-xxl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','container-partner.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','coolp.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','coolp.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','coolp.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','couponmountain.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cover-your-feet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','credit-factor.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','creditcardpost.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cum-facials.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cumfiesta-4u.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cutpricepills.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cyberfreehost.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cycatki.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cyclo-cross.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','cykanax.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dad-daughter-incest.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dailyliving.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','damianer.top-100.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','danni.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','darest.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','datestop.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dating-choice.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dating-harmony.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dating-online-dating.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dating-service-dating.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dating-services-dating-service.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dating999.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','davidtaylor.topcities.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','day4sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','de.sr')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','debt-consolidation-kick-a.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','debt-consolidation-low-rates.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','debt-solution-tips.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','debtconsolidationusa.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dedichepersonali.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','deep-ice.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','deikmann.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dentalinsurancehealth.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','department-storez.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','desiraesworld.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','deutschlandweite-immobilienangebote.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','devon-daniels.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dianepoppos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','diarypeople.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','diet-doctor.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dieta-dimagrante.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dieta-mediterranea.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dieta-zona.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dieta.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','diete-dimagranti.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','diete.bz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','diethost.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dieting-review.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dietpage.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dietrest.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','diets-health.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','diets-plan.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dietway.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','digital-projector.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','digitale-teile.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','direct-tv-for-free.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','directcarrental.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','directrape.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','directringtones.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dirty-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','discount-airfares-guide.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','discount-cheap-dental-insurance.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','discount-life-insurance.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','discoveryofusa.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','disney-hentai.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dlctc.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dns110.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dogolz.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','domkino.com.ua')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne-belle.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne-famose.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne-muscolose.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne-muscolose.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne-nere.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne-nere.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne-nude.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne-porche.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne-vogliose.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donne.bz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnebelle.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnefamose.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnegrasse.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnemature.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnemuscolose.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnenere.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnenere.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnenude.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donneporche.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnesexy.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnevogliose.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','donnevogliose.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','doo.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dotcomup.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','downloadzipcode.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dr.ag')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dragonball-porno.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dragonball-x.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dragonball-xxx.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dragonballporno.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dragonballx.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dragonballxxx.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dressagehorseinternational.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','drive-backup.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','drochka.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','drugsexperts.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','drugstore-online.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','drugstore.st')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','drunk-girls-flashing.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','drunk-girls-party.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dunecliffesaunton.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dvd-copier.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dwoq.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','dzwonki-polifoniczne-motorola.webpark.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e--pics.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-bookszone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-cialis.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-credit-card-debt.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-discus.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-fioricet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-news.host.sk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-online-bingo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-order-propecia.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-play-bingo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-southbeachdiet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-tutor.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e-virtual-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','e40.nl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','easyseek.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ebaybusiness.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ebony-xxx.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ecblast.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','eccentrix.com/members/casinotips')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','echofourdesign.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ecologix.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','edietplans.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','edrugstore.md')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','edwardbaskett.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','effexor.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','eggesfordhotel.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','einfach-wunschgewicht.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','elcenter-s.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','eldorado.com.ua')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','electromark-uk.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','elektronikshop-xxl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','elite-change.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','emmasarah.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','emmss.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','enacre.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','enlargement-for-penis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','envoyer-des-fleurs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','eonsystems.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','erotic-lesbian-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','erotic-video.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','erotische-geschichten-portal.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','esesso-gratis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','esmartdesign.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ethixsouthwest.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','evananderson.topcities.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','evanstonpl.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','event-kalendarium.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','evromaster.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','exoticdvds.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','exoticmoms.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','extrasms.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','extreme-rape.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','extreme-sex.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','f2s.be')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fabida.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fabulos.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fabuloussextoys.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','facial-skin-care-center.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','family-incest.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','familydiet.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','farm-beastiality.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','farmsx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fast-mortgage-4-u.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fat-cash.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fat-lesbians.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fat-pussy-sex.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fateback.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fatty-liver.cn')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fatwarfare.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','favilon.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fda.com.cn')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','female-orgasms.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fielit.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','figa.nu')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','film-porno.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','final-fantasy-hentai.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','finance-world.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','finanzen-marktplatz.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','find-cheap-dental-plans.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','find-lesbian-porn.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','find-u-that-mortgage.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','findbestpills.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','findbookmakers.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','finddatingsites.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','findsexxx.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fioricet-dot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fioricet-web.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fioricet.st')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','first-time-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fishoilmiracle.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fitnessx.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','flirt08.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','flowertobj.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fly-sky.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','forceful.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','forex.inc.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','foto-gay.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','foto-porno.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','foto-porno.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','frangelicasplace.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','frankpictures.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-adult-chat-room.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-adult-check.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-debt-consolidation-online.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-fast.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-gay-video-clip.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-hilton-paris-sex-video.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-horoscopes.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-incest-stories-site.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-net-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-paris-nikki-hilton.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-teens-galleries.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freehostingpeople.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freenetshopper.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freenudegallery.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freepicsdaily.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freepornday.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freeteenpicsandmovies.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freewebpage.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freewebs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freewhileshopping.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','freshsexhosting.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','friko.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fuck-animals.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fumetti-porno.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','fumettiporno.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','furrios.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gagnerargent.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gals4all.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gambling-a.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gambling-homepage.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gamblingSgames.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gamblingguidance.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gamefinder.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','games-advanced.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gang-rape.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','garment-china.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gartenshopper.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','garthfans.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gay-asian-porn.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gay-b.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gay-boy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gay-male-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gay-nude.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gay-sex-videos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gay-twinks-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gayfunplaces.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gays-porno-men-twinks-boys-sex.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gays-sex-gay-sex-gays.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gayx.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gdgc.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gem2.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gemtienda.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','generic-propecia.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','genimat.220v.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','genimat.cjb.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/alexgolddphumanrbriar')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/avbmaxtirodpaulmatt')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/brandtdleffmatthias7')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/cclibrannar_rover')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/constpolonskaalniko7')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/forestavmiagdust')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/free_satellite_tv_dish_system')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/ofconvbdemikqfolium')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/pashkabandtvcom')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/pautovalexasha_kagal')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/reutovoalexeypetrovseverin5')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','geocities.com/timryancompassmedius')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gesundheit-total.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gesundheitsshop-kosmetik.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','get-cell-phone-accessories.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','get-free-catalogs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','get-hardcore-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','get-insurance-quotes.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','get-zoo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','getaprescription.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','getdomainsandhosting.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','getmoregiveless.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','getrxscripts.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','getyourlyrics.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ghettoinc.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','giantipps.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gifs-clipart-smiley.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','giochi-hentai.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','giochi-online.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','giochix.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','give-u-the-perfect-mortgage.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','glendajackson.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','global-verreisen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','glory-vision.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','godere.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gogito.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gojerk.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','goldpills.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gongi.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','goodlife2000-geheimtipp.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','goodsexy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','google8.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','gotooa.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','government-grants.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','government-grants.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','grannysexthumbs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','great-cialis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','greatnow.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','greecehotels-discount.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','green-tx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','group-eurosex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','guardami.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','guenstige-krankenversicherung.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','guenstige-onlineshops.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','guenstige-sportartikel.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','guenstige-versicherungstarife.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','guttermag.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hair-loss-cure.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hairy-pussy-sex.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hallo-tierfreund.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hand-job.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','handwerksartikel-xxl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','handysprueche.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','handytone.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hangchen.cn')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hangchen.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','happy-shopping-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hard-sex-teen.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hardcore-jpg.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hardcore-junky.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hardcore-pictures.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hardcore-porn-links.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hardcore-pussy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hardcore-sex.bz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hardcore-video.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hardcorecash.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hautesavoieimmobilier.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','health-pills-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','health-pills.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','healthmore.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','healthrules.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','heartbeatofhealing.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentai-anime.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentai-gratis.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentai-hard.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentai-porno.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentai-xxx.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentaigratis.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentaimanga.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentaiplayground.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentaix.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentaixxx.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hentay.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hgxweb.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hilton-nicky-paris.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hion.cn')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hit-logo-klingelton.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hit-logo-ringetone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hit-logo-ringtone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hit-logo-suoneria.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hit-melodias.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hit-sonnerie.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hit-sonneries.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hits-logos-games.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hits-logos-klingeltone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hitslogosgames.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hobbs-farm.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','home-videos.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','home.ro\b')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','homelivecams.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','homenetworkingsolutions.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','horny-honey.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','horny-world.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hornymoms.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hornypages.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','horoskop-auswertung.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','horse-sex.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hostingplus.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hostultra.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hot-cialis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hot-escort-services.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hot-mates.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hotel-bordeaux.cjb.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hotelbookingserver.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hotelsplustours.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hotfunsingles.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hotsexys.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hotusa.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','how-quit-smoking.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hs168.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','huazhangmba.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','humangrowthhormone.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hunksandbabes.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hustler.bz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hustlerw.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','hypnobabies.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-black-jack.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-butalbital-fioricet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-buy-mortgage.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-directv.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-dish-network.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-flexeril.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-free-poker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-horny.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-mortgage-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-online-bingo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-online-poker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-play-bingo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-play-blackjack.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-play-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-play-poker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-skelaxin.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-texas-hold-em.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-texas-holdem.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-wellbutrin.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-will-find-the-best-mortgage-lead.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-win-bingo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','idebtconsolidation.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','illegalhome.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','illegalspace.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','im-naked.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','imess.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','imitrex-web.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','immagini-hentai.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','immobilien-auswaehlen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','immobilienangebote-auswahl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','immobilienmakler-angebote.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','immobilienmakler-l.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','immobilienmarkt-grundstuecke.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','immobilierdessavoie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','impotence-rx.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','in-the-vip.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','inc-magazine.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-movies-download.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-photo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-photos-archive.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-pics-gallery.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-reality.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-relations.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-stories-library.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-stories.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-taboo.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incest-videos-collection.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','inceststories.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','incredishop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','indian-sex-porno-movies-stories.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','indiasilk.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','indiasilktradition.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','industrial-testing-equipment.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','industrialresource.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','inescudna.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','inforceable.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','innfg.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','insatiablepussy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','insurance-quotes-fast.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','insurancehere.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','int-fed-aromatherapy.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','inter-ross.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','international-candle-shop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','international-cheese-shop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','internet-poker-online-4-u.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','internette-anbieter.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','interracial-sex.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','inthevip-4u.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','inthevip-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','intymnie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','inviare-mms.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','invio-mms.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ipaddressworld.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ipharmacy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ipmotor.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ipsnihongo.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','irianjaya.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','iul-online.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','iwebbroker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','jade.bilder-i.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','japan-partner.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','jewelry4navel.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','jinlong.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','job-interview-questions-tips.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','jokeria.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','jordanand.topcities.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','judahskateboards.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','juliamiles.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','jungfrauen-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kantorg.h10.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','karibubaskets.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','karmicdebtconsolidation.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kcufrecnac.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','keikoasura.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','keithandrew.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kewler.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kinkyhosting.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kiranthakrar.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kleinkinder-shop.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','klingeltoene-handylogos.de.be')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','klingeltone-logo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','klitoris.ca')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kmsenergy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kohost.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','koihoo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kontaktanzeigen-bild.de.ms')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kontaktlinsen-partner.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kostenlose-sexkontakte.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kraskidliavas.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kredit-ratenkredit-sofortkredit.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kredite-online.de.ms')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kredite-portal.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kredite-sofortzusage.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kreditkarten-sofort.de.ms')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','kupibuket.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lablog.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lach-ab.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','landscape-painting.as.ro')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lanreport.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','laptopy.biz.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','las-vegas-real-estate-1.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lastminute-blitz.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lasvegas-real-estate.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lasvegasrealtor.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lasvegastourfinder.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','latina-sex.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lavalifedating.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','leadbanx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lechery-family.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','legalblonde.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lesbian-girl.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lesbian-sex-porn-pics-stories.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lesbichex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','leseratten-wunderland.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','letemgo.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','life-insurance-advisor.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lingerie-land.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','link-dir.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','linkliste-geschenke.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','linseysworld.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','linuxwaves.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lipitordiscount.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','list1st.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','listbanx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','live-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','livetreff.tv')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','livevents.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lizziemills.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','loan-king.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','loan-superstore.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','loans-4all.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','loans.de.vu')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','locationcorse.free.fr')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-beltonen.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-free.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-klingeltone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-max.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-melodias.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-mobiel.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-mobile-repondeur.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-moviles.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-phones.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-repondeur-mobile.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-sonneries-sonnerie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-spiele.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logo-tones.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logod-helinad-mangud.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logoer-mobil.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-downloads.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-free.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-logos.be')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-melodijas-speles.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-mobile-repondeurs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-phones.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-repondeurs-mobile.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-sonneries-jeux.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-sonneries-jeuxmobiles.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-sonneries-sonnerie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logos-tone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logosik.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','logotyper-mobil.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lookforukhotels.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','loraxe.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lowclass.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','luffassociates.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','luxus-gourmetartikel.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lvrealty.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','lynskey-admiration.org.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','macinstruct.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mainentrypoint.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mainjob.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','male-enlargement.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mallorycoatings.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','manga-free.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','manga-free.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','manga-porn.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','manga-x.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','manga-xxx.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','marshallsupersoft.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','match-me-up.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mature-big-tits.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mature-sex-moms-porn.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','matureacts.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','maturefolk.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','medcenterstore.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mediaaustralia.com.au')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','medications-4all.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','medicine-supply.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','meds-pill.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mega-spass.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','megapornstation.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','melodias-logos-juegos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','members.fortunecity.com/kennetharmstrong')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','men-porn.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','men-sex.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mengfuxiang.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','menguma.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','menguma.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mens-health-pills.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','menzyme.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mesothelioma-asbestos-help.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mesothelioma-health.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','metroshopperguide.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','micrasci.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','midget-porn-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mietangebote-domain.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','migraine-relief.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mikebunton.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','milesscaffolding.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','milfporn.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','misterwolf.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mmsanimati.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mneuron.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mobile-repondeur-logo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mobile-repondeurs-logos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mobilequicksale.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mobilesandringtones.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mode-domain.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mode-einkaufsbummel.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','moltobene.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','money-room.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','moneybg.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mookyong.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mortage-4all.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mortgage-rates-guide.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mortloan.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mostika.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mother-son-incest-sex.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','motonet.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','movies6.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mp3download.bz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mp3x.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mrpiercing.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','multipurpose-plants.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','multiservers.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','musica-da-scaricare.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','musica-gratis.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','musica-gratis.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','musica-karaoke.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','musica-mp3.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','musicamp3.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','musicenergy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','muxa.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mxbearings.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','my-age.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','my-dating-agency.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','my-sex-toys-store.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','myasiahotels.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mybestcasinos.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mycasinohome.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mydatingagency.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mydietdoctor.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','myeuropehotels.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','myfavlinks.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','mygenericrx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','myslimpatch.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','naar.be')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nabm(il|li)or.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','naked-gay.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','naked-pussy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','naked-womens-wrestling-league-dvds.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','naked-womens-wrestling-league-videos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','narod.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nasty-pages.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','natel-mobiles.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','natural-barleygreen.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','natural-breasts-enhancement.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','naturalknockers.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','neiladams.org.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','net-mature.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','net-von-dir.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','netfirms.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','netizen.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','netlogo.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','neurogenics.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','new-cialis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','newfurnishing.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','newgallery.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','newsnewsmedia.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','newxwave.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nfl-football-tickets.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nice-pussy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nicepages.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nicepages.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nicepages.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','niceshemales.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nichehit.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nicolepeters.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nieruchomosci.biz.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nifty-erotic-story-archive.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','njhma.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','njunite.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','no-title.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','no1pics.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','noni-jungbrunnen.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','noni-top-chance.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','noni-vitalgetraenk.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','noniexpert.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nonstop-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nonstopsex.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','noslip-picks.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','notsure.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','novacspacetravel.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nr-challenges.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nude-black.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nude-movies.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nude-video.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nudevol.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nutritional-supplements.ws')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nwwl-dvds.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nwwl-videos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','nz.com.ua')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','officialdarajoy.com/wwwboard')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','officialdentalplan.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','officialsatellitetv.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','offseasonelves.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','oldgrannyfucking.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','omega-fatty-acid.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','on-line-casinos-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','on-line-casinos-online.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','one-cialis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','one-debt-consolidation.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','one-propecia.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','one-soma.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','onepiecex.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','oneseo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','onexone.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online--pharmacy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-auction-tricks.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-blackjack-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-buy-plavix.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-credit-report-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-dot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-escort-service.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-flexeril.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-gambling-online.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-photo-print.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-prescription.st')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-prescriptions-internet-pharmacy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-texas-hold-em.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-texas-hold-em.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','onlinehgh.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','opensorcerer.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','operazione-trionfo.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','optimumpenis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','oral-sex-cum.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','order-claritin.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','order-effexor.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ordernaturals.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','orlandodominguez.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','orospu.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ourhealthylife.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','outoff.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','overseaspharmacy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','owns1.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','p-reise.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','paperscn.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','paris-and-nicky-hilton-pictures.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','paris-hilton-video-blog.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','paris-movie-hilton.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','paris-naked-hilton.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','paris-nicky-hilton.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','paris-nikki-hilton.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','partnersmanager.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','partnersuche-partnervermittlung.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','partybingo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','partypoker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','passende-klamotten.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pastramisandwich.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','payday-loan-payday.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','paysites.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pc-choices.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pcdweb.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','peepissing.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','penis-enlargment.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','penisimprovement.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','penisresearch.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','perfect-dedicated-server.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','perfect-mortgage-lead-4-u.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','personal-finance-tips.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','personals-online-personals.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','petlesbians.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','petroglyphx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','phantadu.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pharmaceicall.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pharmacy2003.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pharmacyprices.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','phone-cards-globe.pushline.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','phono.co.il')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','photobloggy.buzznet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pics&#8212;movies.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pics-stories.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','picsfreesex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','picsteens.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pictures-movies.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','piercing-auswaehlen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','piercing-magic.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','piercingx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pill-buy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pillblue.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pillchart.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pillhub.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pillhunt.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pillinc.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pills-for-penis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pillsbestbuy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pillsupplier.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pilltip.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pimpcasino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pimphos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pimpspace.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pinkzoo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pj-city.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','planetluck.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','play-cash-bingo-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','play-poker-onlie-kick-ass.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','player-tech.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','playgay.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','playmydvd.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','playnowpoker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','plygms.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pokemon-hentai.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pokemon-hentai.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pokemonhentai.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pokemonx.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','poker-homepage.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pokerpage.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pokerpartnership.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','polifoniczne.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pompini.nu')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','porn-4u.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','porn-dvds-dot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','porn-house.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','porn-stars.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pornevalution.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','porngrub.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pornlane.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','porno-v.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pornogratis.bz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pornosexbest.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pornostars.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pornovideos-versand.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pornstar4all.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pornwww.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','power-rico.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pregnant-sex-free.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','prepaylegalinsurance.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','prescription-drugs.st')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','prescriptions.md')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','preteen-models.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','preteen-sex.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','preteen-young.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','prettypiste.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','prism-lupus.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','privacy-online.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','private-krankenversicherung-uebersicht.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','private-network.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','privatediet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','product-paradise.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','projector-me.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','prom-prepared.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','promindandbody.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','propecia-for-hair-loss.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','propecia-for-hair-loss.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','propecia-info.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','propecia-store.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','prosearchs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pryporn.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pseudobreccia60.tripod.com.ve')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','psites.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','psites.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','psites.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','psites.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','punksongslyrics.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pushline.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pussy-cum.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pussy-d.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','pussy-movies.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','qqba.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','quangoweb.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','quickdomainnameregistration.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','quickie-quotes.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','racconti-gay.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','radsport-artikel.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','raf-ranking.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ragazze.bz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rampantrabbitvibrator.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','randysrealtyreview.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rape-fantasy-pics.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rape-stories.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ratenkredit-center.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ratenkredit-shop.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','raw-pussy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','real-sex.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','reality-xxx.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rebjorn.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','refinance-mortgage-home-equity-loan.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','reisen-domain.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','repondeurs-logos-mobile.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','republika.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','restaurant-l.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ricettegolose.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','richshemales.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ringsignaler-ikon-spel.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ringtone-logo-game.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ringtoner-logoer-spill.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ringtonespy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rittenhouse.ca')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','roboticmilking.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','romane-buecher.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','romeo-ent.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','roulette---online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','royaladult.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','royalfreehost.com/teen/amymiller')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ru21.to')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rx-pills-r.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rx-store.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rxpainrelief.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rxweightloss.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','rydoncycles.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','s-fuck.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sailor-moon-hentai.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sailor-moon-hentai.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','salcia.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','salute-bellezza.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','salute-bellezza.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','salute-benessere.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','salute-e-benessere.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','salute-igiene.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','salute-malattie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','salute-malattie.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sandrabre.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sarennasworld.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','satellite-network-tv.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','satellite.bravehost.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','satellitetv-reviewed.tripod.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','saveonpills.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sbdforum.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sbt-scooter.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scarica-mp3.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scarica-mp3.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scarica-musica-mp3.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scarica-musica.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scarica-musica.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scaricamp3.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scaricare-canzoni.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scaricare-canzoni.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scaricare-canzoni.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scaricare-mp3.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scatporn.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scent-shopper.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','schanee.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','schmuck-domain.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','scottneiss.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','se-traf.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','search722.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','secureroot.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','security-result.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','seitensprung-gratis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','selectedsex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','selena-u.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','selten-angeklickt.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','seoy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sesso-gratis.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sesso-online.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sessoanalex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sessox.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sewilla.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-4you.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-bondagenet.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-friend.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-livecam-erotik.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-lover.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-manga.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-mates.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-photos.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-pussy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex-toys-next-day.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sex4dollar.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexbrides.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexcia.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexe.vc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexiestserver.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexingitup.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexmuch.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexo9.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexplanets.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexschlucht.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexshop-sexeshop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexshop.tk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sextoysportal.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexual-shemales.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexual-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexushost.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexwebclub.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexwebsites.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexy-ass.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexy-babes.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexy-celebrity-photos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexy-girls.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexy-lesbian.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexy-pussy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sexynudea.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sfondi--gratis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sfondi-desktop-gratis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shadowbaneguides.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shannon-e.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shemalesex.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shemalesland.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shemalezhost.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shemalki.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shfx-bj.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shirts-t-shirts.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shop-opyt.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shopping-liste.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shoppingideen-xxl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','shoppyix.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','showsontv.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','simple-pharmacy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','simpsonowen.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sinfree.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','site-mortgage.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sitesarchive.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','siti-porno.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ski-resorts-guide.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','skidman.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','slng.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','slot-machines-slots.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','slowdownrelax.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','slut-wife-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','slutcities.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','smartdot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','smartonlineshop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sms-sms-sms.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sms-sprueche-4fun.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sms-sprueche.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sms.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sofort-mitgewinnen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sofortkredit-tipps.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','soft-industry.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','soft.center.prv.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','software-einkaufsmarkt.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','software-linkliste.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','softwaredevelopmentindia.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','soittoaanet-logot-peli.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sol-web.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','soma-solution.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','soma.st')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','somaspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sommerreisen-2004.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-compositeur.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-hifi-sms.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-logo-jeu.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-logo-sonneries.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-logos-sonneries.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-logos.be')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-max.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-portable-composer.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-portable.be')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-sonneries-logo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-sonneries-logos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie-sonneries.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonnerie.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonneries-gsm-sms.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonneries-sonnerie-logo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonneries-sonnerie-logos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sonneries.fr')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sorglos-kredit.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','soulfulstencils.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','southbeachdietrecipe.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','spacige-domains.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','spannende-spiele.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','spassmaker.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','speedy-insurance-quotes.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','spiele-kostenlose.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','spiele-planet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sportartikel-auswahl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sportlich-chic.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sports---betting.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sports-inter-action.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','spp-net.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','spy-patrol.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','staffordshires.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','statusforsale.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','steelstockholder.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','stellenangebote-checken.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','stellenangebote-l.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','stevespoliceequipment.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sting.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','stolb.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','stopp-hier.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','stopthatfilthyhabit.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','stories-inc.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','striemline.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','strivectinsd.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','stunningsextoys.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','success-biz-replica.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','suma-eintragen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sumaeintrag-xxl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sunbandits.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sunnyby.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','suonerie-center.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','suonerie-download.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','suonerie-loghi-gratis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','suonerieloghix.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','suoneriex.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','suoyan.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','super-celebs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','surfe-und-staune.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','susiewildin.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sutra-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','svitonline.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sweet-horny.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sweethotgirls.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','swinger-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sylphiel.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sylviapanda.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','sysaud.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','t35.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','t3n.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tanganyikan-cichlids.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tapbuster.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','taremociecall.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','targetingpain.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tattoo-entwuerfe.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tatuaggi-gratis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tatuaggi-piercing.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tatuaggi-tribali.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tatuaggi.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tatuaggi.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tatuaggitribali.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tdk-n.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teen-babes.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teen-boys-fuck-paysite.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teen-d.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teen-hentai.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teen-movie.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teen-porn-movie.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teen-sex-porn-models.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teen-video.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teen-xxx.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teensluts.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','teenxxxpix.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','telechargement-logiciel.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','terminator-sales.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','testi-canzoni.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','testi-canzoni.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','testi-musicali.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','testi-musicali.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','testi.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tests-shop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tette.bz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tettone.cc')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','texasholdem-flip-flop.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','texasholdem-poker.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tgplist.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','the-boysfirsttime.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','the-date.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','the-hun-site.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','the-hun-yellow-page-tgp.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','the-pill-bottle.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','the-proxy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','the1930shome.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','theblackfoxes.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','theceleb.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','thefreecellphone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','thehadhams.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','bestialitylinks.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','themadpiper.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','thepurplepitch.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','therosygarden.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','thesoftwaregarage.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','thespecialweb.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','thewebbrains.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ticket-marktplatz.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tickets4events.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tiere-futter.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tiffany-towers.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tikattack.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','timescooter.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tits-center.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tits-cumshots.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','top-cialis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','top-dedicated-servers.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','top-fioricet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','top-internet-blackjack.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','top-milf.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','top-of-best.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','top-skelaxin.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','top-soma.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','top-the-best.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','topaktuelle-tattos.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','toques-logos-jogos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','toshain.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','total-verspielt.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','touchwoodmagazine.org.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tournamentpoker.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','training-one.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tranny-pic-free.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','trannysexmovie.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','transbestporn.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','transestore.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','transpire.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','traum-pcs.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','triadindustries.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','troggen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','troie.bz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','trolliges.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','trucchi-giochi.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','trueuninstall.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tt7.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tuff-enuff.fnpsites.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','tygef.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','u-w-m.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ufosearch.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ultracet-web.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','ultrampharmacy.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','unbeatablecellphones.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','unbeatablemobiles.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','unbeatablerx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','unccd.ch')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','underage-pussy.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','undonet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','uni-card.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','unterm-rock.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','urlaubssonne-tanken.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','us-cash.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','us-meds.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','v27.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','v29.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','v3.be')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','vacation-rentals-guide.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','venera-agency.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','veranstaltungs-tickets.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','vergleich-versicherungsangebote.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','versicherungsangebote-vergleichen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','versicherungsvergleiche-xxl.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','versteigerungs-festival.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','verybrowse.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','verycd.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','viaggix.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','viapaxton.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','video-n.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','video-porno.nu')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','videohentai.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','vilentium.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','villagesx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','vimax.topcities.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','vip-condom.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','w-ebony.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','waldner-msa.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','warblog.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','washere.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','watches-sales.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','waterbeds-dot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wblogs.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wcgaaa.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','we-live-together-4u.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','weareconfused.org.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','web-cialis.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','web-revenue.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','webanfragen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','webblogs.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','webcam-erotiche.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','webcenter.pl')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','webcopywizard.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','webrank.cn')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','websitedesigningpromotion.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','weighlessrx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','weight-loss-central.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','weitere-stellenangebote.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wellness-getraenk.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wet-4all.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wet-pussy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wethorny.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','white-shadow-nasty-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','whizzkidsuk.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wild-porno-girls.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','willcommen.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wincrestal.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','windcomesdown.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wiset-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','witch-watch.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','witz-net.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wizardsoul.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','world-candle.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','world-cheese.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','worldmusic.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','worldsexi.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','worldwidecasinosearch.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','wotcher.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','www-sesso')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','www-webspace.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','x-bingo.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','x-fioricet.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','x-free-casino-games.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','x-internet-casino.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','x-ring-tones.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','x-ringtones.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xaper.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xdolar.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xfreehosting.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xgsm.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xin-web.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xlboobs.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xmilf.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xnxxx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xpictx.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xprescription.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xratedcities.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xsesso.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxshopadult.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-alt-sex-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-database.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-dvd.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-erotic-sex-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-first-time-sex-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-free-erotic-sex-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-gay-sex-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-girls-sex.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-password-web.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-pussy.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-sex-movies.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-sex-story-post.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-spanking-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-stories.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxx-story.blogspot.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxxchan.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xxxwashington.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','xz9.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','yaninediaz.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','yoll.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','you-date.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','young-ass.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','your-tattoo.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','yourowncolours.co.uk')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','yourserver.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','yukka.inc.ru')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zfgfz.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zipcodedownload.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zipcodesmap.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zoo-sex-pics.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zoo-sex.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zoo-zone.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zoosex-motion-videos.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zoosex-pictures.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zoosx.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zpics.net')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zt148.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','zum-bestpreis.de')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','1asphost.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','buy-car-insurance-4-us.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-poker-kick-butt.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','search-engine-optimization-4-us.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','maxigenweb.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','saveondentalplans.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-satellite-tv-now.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','no-cavities.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','poker-texas-holdem.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-texas-holdem.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-texas-holdem.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','seven-card-stud.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-texas-holdem.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','seven-card-stud.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','online-texasholdem.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','play-7-card-stud-poker.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','play-7-card-stud-poker.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','customer-reviews.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-texasholdem.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','play-texas-hold-em.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','texasholdem-online.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-texashold-em.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','play-texas-holdem.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-texas-holdem-poker.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','free-texas-hold-em.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','poker-texas-hold-em.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-play-poker-online.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-play-poker-online.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','poker-texas-hold-em.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-play-poker-online.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-texas-hold-em.info')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','poker-texas-hold-em.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-texas-hold-em.biz')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('MTBlacklist','i-texas-hold-em.us')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Action','DeleteComment')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Examine','BlackList')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Examine','MTBlackList')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Personal','healz.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Personal','x-stories.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Personal','finance.resik.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Personal','mature-bitch.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Personal','maturefucked.com')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Personal','geocities.com/mac_user1979')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Personal','sexgirlz.org')";
$_DATA[] = "INSERT INTO gl_spamx VALUES ('Personal','bcure.com')";

$_INDEX[] = "ALTER TABLE {$_TABLES['comments']} ADD INDEX comments_date(date)";

$_INDEX[] = "ALTER TABLE {$_TABLES['events']} ADD INDEX events_datestart(datestart)";
$_INDEX[] = "ALTER TABLE {$_TABLES['events']} ADD INDEX events_dateend(dateend)";

$_INDEX[] = "ALTER TABLE {$_TABLES['group_assignments']} ADD INDEX group_assignments_ug_uid(ug_uid)";

$_INDEX[] = "ALTER TABLE {$_TABLES['links']} ADD INDEX links_category(category)";
$_INDEX[] = "ALTER TABLE {$_TABLES['links']} ADD INDEX links_date(date)";

$_INDEX[] = "ALTER TABLE {$_TABLES['pollquestions']} ADD INDEX pollquestions_date(date)";

$_INDEX[] = "ALTER TABLE {$_TABLES['stories']} ADD INDEX stories_date(date)";
$_INDEX[] = "ALTER TABLE {$_TABLES['stories']} ADD INDEX stories_frontpage(frontpage)";

$_INDEX[] = "ALTER TABLE {$_TABLES['userindex']} ADD INDEX userindex_maxstories(maxstories)";

?>
