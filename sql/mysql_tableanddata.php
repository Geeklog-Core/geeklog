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
  blockorder tinyint(3) unsigned NOT NULL default '1',
  content text,
  rdfurl varchar(96) default NULL,
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
  uid mediumint(8) NOT NULL default '1',
  INDEX comments_cid(cid),
  INDEX comments_type(type),
  INDEX comments_sid(sid),
  INDEX comments_uid(uid),
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
  INDEX links_lid(lid),
  PRIMARY KEY  (lid)
) TYPE=MyISAM
";

$_SQL[16] = "
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
CREATE TABLE {$_TABLES['topics']} (
  tid varchar(20) NOT NULL default '',
  topic varchar(48) default NULL,
  imageurl varchar(96) default NULL,
  sortnum tinyint(3) default NULL,
  limitnews tinyint(3) default NULL,
  is_default tinyint(1) unsigned NOT NULL DEFAULT '0',
  group_id mediumint(8) unsigned NOT NULL default '1',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (tid)
) TYPE=MyISAM
";

$_SQL[31] = "
CREATE TABLE {$_TABLES['tzcodes']} (
  tz char(3) NOT NULL default '',
  offset int(1) default NULL,
  description varchar(64) default NULL,
  PRIMARY KEY  (tz)
) TYPE=MyISAM
";

$_SQL[32] = "
CREATE TABLE {$_TABLES['usercomment']} (
  uid mediumint(8) NOT NULL default '1',
  commentmode varchar(10) NOT NULL default 'threaded',
  commentorder varchar(4) NOT NULL default 'ASC',
  commentlimit mediumint(8) unsigned NOT NULL default '100',
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[33] = "
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

$_SQL[34] = "
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

$_SQL[35] = "
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

$_SQL[36] = "
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
  cookietimeout int(8) unsigned default '0',
  theme varchar(64) default NULL,
  language varchar(64) default NULL,
  pwrequestid varchar(16) default NULL,
  PRIMARY KEY  (uid),
  KEY LOGIN (uid,passwd,username)
) TYPE=MyISAM
";

$_SQL[37] = "
CREATE TABLE {$_TABLES['vars']} (
  name varchar(20) NOT NULL default '',
  value varchar(128) default NULL,
  PRIMARY KEY  (name)
) TYPE=MyISAM
";

$_SQL[38] = "
CREATE TABLE {$_TABLES['article_images']} (
  ai_sid varchar(20) NOT NULL,
  ai_img_num tinyint(2) unsigned NOT NULL,
  ai_filename varchar(128) NOT NULL,
  PRIMARY KEY (ai_sid,ai_img_num)
) TYPE=MyISAM
";

$_SQL[39] = "
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
  PRIMARY KEY  (sp_id),
  KEY staticpage_sp_uid (sp_uid),
  KEY staticpage_sp_date (sp_date),
  KEY staticpage_sp_onmenu (sp_onmenu),
  KEY staticpage_sp_centerblock (sp_centerblock),
  KEY staticpage_sp_tid (sp_tid),
  KEY staticpage_sp_where (sp_where)
) TYPE=MyISAM
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
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (22,14) ";

$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (3,'user_block','gldefault','User Functions','all',2,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (4,'admin_block','gldefault','Admins Only','all',1,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (5,'section_block','gldefault','Topics','all',0,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (6,'poll_block','gldefault','Poll','all',2,'','','0000-00-00 00:00:00',0,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (7,'events_block','gldefault','Events','all',4,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (8,'whats_new_block','gldefault','What\'s New','all',3,'','','0000-00-00 00:00:00',0,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (9,'first_block','normal','About GeekLog','all',1,'<b>Welcome to GeekLog!</b><br>If you\'re already familiar with GeekLog - and especially if you\'re not: There have been many improvements to GeekLog since earlier versions that you might want to read up on. Please read the release notes in the /docs directory and go over the install guide.','','0000-00-00 00:00:00',0,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (10,'whosonline_block','phpblock','Who\'s Online','all',0,'','','0000-00-00 00:00:00',0,'phpblock_whosonline',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (11,'older_stories','gldefault','Older Stories','all',5,'','','0000-00-00 00:00:00',1,'',1,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (12,'security_check','phpblock','Are you secure?','homeonly',3,'','','0000-00-00 00:00:00',1,'phpblock_getBent',1,2,3,3,0,0) ";

$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (0,'Comments Enabled') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (-1,'Comments Disabled') ";

$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('flat','Flat') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nested','Nested') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('threaded','Threaded') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nocomment','No Comments') ";

$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (3600,'1 Hour') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (7200,'2 Hours') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (10800,'3 Hours') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (28800,'8 Hours') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (86400,'1 Day') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (604800,'1 Week') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (2678400,'1 Month') ";
$_DATA[] = "INSERT INTO {$_TABLES['cookiecodes']} (cc_value, cc_descr) VALUES (31536000,'1 Year') ";

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

$_DATA[] = "INSERT INTO {$_TABLES['eventsubmission']} (eid, title, description, location, datestart, dateend, url, allday, zipcode, state, city, address2, address1, event_type, timestart, timeend) VALUES ('2001110114064662','Test event','test','Test','2001-11-02','2001-11-03','http://www.tonybibbs.com',0,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL) ";

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

$_DATA[] = "INSERT INTO {$_TABLES['links']} (lid, category, url, description, title, hits, date, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20030119095147683','Geeklog Sites','http://www.geeklog.net','All you ever need to know about GeekLog - and more ...','Geeklog Project Homepage',42,NULL,5,2,3,3,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (0,'Don\'t Email') ";
$_DATA[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (1,'Email Headlines Each Night') ";

$_DATA[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('staticpages', '1.3','1.3.8',1,'http://www.tonybibbs.com') ";

$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',1,'Static Pages plugin 1.3',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',2,'New Forgot Password function',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',3,'Users can delete their account',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',4,'Cloning of Events',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',5,'New privacy options',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',6,'Extended plugin API',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['pollanswers']} (qid, aid, answer, votes) VALUES ('geeklogfeaturepoll',7,'Other',0) ";

$_DATA[] = "INSERT INTO {$_TABLES['pollquestions']} (qid, question, voters, date, display, commentcode, statuscode, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklogfeaturepoll','What is the best new feature of Geeklog?',0,'2003-01-01 12:43:20',1,0,0,8,2,3,3,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('plaintext','Plain Old Text') ";
$_DATA[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('html','HTML Formatted') ";

$_DATA[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('ASC','Oldest First') ";
$_DATA[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('DESC','Newest First') ";

$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (1,'Refreshing') ";
$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (0,'Normal') ";
$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (10,'Archive') ";

$_DATA[] = "INSERT INTO {$_TABLES['stories']} (sid, uid, draft_flag, tid, date, title, introtext, bodytext, hits, numemails, comments, related, featured, commentcode, statuscode, postmode, frontpage, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20030101093000103',2,0,'GeekLog','2003-01-01 09:30:00','Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing GeekLog. Please take the time to read everything in the docs directory. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.\r\r<p>Below are a list of usernames that have access to a specific portion of the site. While Admin has access to everything, Moderator only has access to the areas related to stories, links, and events. The password for each account is <b>password</b>. \r\r<p>Accounts:\r<ul>\r<li>Admin</li>\r<li>Moderator</li>\r</ul>','',100,1,0,'<li><a href=\"/search.php?mode=search&amp;type=stories&amp;author=2\">More by Admin</a><li><a href=\"/search.php?mode=search&amp;type=stories&amp;topic=GeekLog\">More from GeekLog</a>',1,0,0,'html',1,2,3,3,3,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['storysubmission']} (sid, uid, tid, title, introtext, date, postmode) VALUES ('20030101120556538',2,'GeekLog','Are you secure?','<p>This is a reminder to secure your site once you have Geeklog up and running. What you should do:</p>\r\r<ol>\r<li>Change the default password for all Admin accounts.</li>\r<li>Remove the install directory (you won\'t need it any more).</li>\r</ol>','2003-01-01 12:05:56','html') ";

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

$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (1,'Anonymous','Anonymous','',NULL,NULL,'','2003-01-01 00:00:01',0,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (2,'Admin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','http://www.geeklog.net','','2003-01-01 00:00:02',0,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme) VALUES (3,'Moderator','Moderator','5f4dcc3b5aa765d61d8327deb882cf99','moderator','http://www.geeklog.net','','2003-01-01 00:00:03',NULL,NULL) ";

$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('totalhits','0') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastemailedstories','') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('rdf_sids','')";

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
