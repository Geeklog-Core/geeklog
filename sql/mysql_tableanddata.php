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
  allow_autotags tinyint(1) unsigned NOT NULL DEFAULT '0',
  rdfurl varchar(255) default NULL,
  rdfupdated datetime NOT NULL default '0000-00-00 00:00:00',
  rdf_last_modified varchar(40) default NULL,
  rdf_etag varchar(40) default NULL,
  rdflimit smallint(5) unsigned NOT NULL default '0',
  onleft tinyint(3) unsigned NOT NULL default '1',
  phpblockfn varchar(128) default '',
  help varchar(255) default '',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
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
  sid varchar(40) NOT NULL default '',
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
  INDEX comments_date(date),
  PRIMARY KEY  (cid)
) TYPE=MyISAM
";

$_SQL[6] = "
CREATE TABLE {$_TABLES['conf_values']} (
  name varchar(50) NOT NULL,
  value text,
  type varchar(50) default NULL,
  group_name varchar(50) default NULL,
  default_value text,
  display_name varchar(50) default NULL,
  subgroup varchar(50) default NULL,
  selectionArray text default NULL,
  sort_order int(11) default NULL,
  fieldset varchar(30) default NULL
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
  postmode varchar(10) NOT NULL default 'plaintext',
  datestart date default NULL,
  dateend date default NULL,
  url varchar(255) default NULL,
  hits mediumint(8) unsigned NOT NULL default '0',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
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
  INDEX events_datestart(datestart),
  INDEX events_dateend(dateend),
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
  INDEX group_assignments_ug_main_grp_id(ug_main_grp_id),
  INDEX group_assignments_ug_uid(ug_uid),
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
  UNIQUE grp_name (grp_name)
) TYPE=MyISAM
";

$_SQL[16] = "
CREATE TABLE {$_TABLES['links']} (
  lid varchar(20) NOT NULL default '',
  cid varchar(32) default NULL,
  url varchar(255) default NULL,
  description text,
  title varchar(96) default NULL,
  hits int(11) NOT NULL default '0',
  date datetime default NULL,
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  INDEX links_category(cid),
  INDEX links_date(date),
  PRIMARY KEY (lid)
) TYPE=MyISAM
";

$_SQL[17] = "
CREATE TABLE {$_TABLES['linksubmission']} (
  lid varchar(20) NOT NULL default '',
  cid varchar(32) default NULL,
  url varchar(255) default NULL,
  description text,
  title varchar(96) default NULL,
  hits int(11) default NULL,
  date datetime default NULL,
  owner_id mediumint(8) unsigned NOT NULL default '1',
  PRIMARY KEY (lid)
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
  url varchar(255) default NULL,
  description text,
  postmode varchar(10) NOT NULL default 'plaintext',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
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

$_SQL[20] = "
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

$_SQL[21] = "
CREATE TABLE {$_TABLES['pollanswers']} (
  pid varchar(20) NOT NULL default '',
  qid mediumint(9) NOT NULL default '0',
  aid tinyint(3) unsigned NOT NULL default '0',
  answer varchar(255) default NULL,
  votes mediumint(8) unsigned default NULL,
  remark varchar(255) NULL,
  PRIMARY KEY  (qid,aid)
) TYPE=MyISAM
";

$_SQL[22] = "
CREATE TABLE {$_TABLES['pollquestions']} (
  qid mediumint(9) NOT NULL auto_increment,
  pid varchar(20) NOT NULL,
  question varchar(255) NOT NULL,
  PRIMARY KEY (qid)
) TYPE=MyISAM
";

$_SQL[23] = "
CREATE TABLE {$_TABLES['polltopics']} (
  pid varchar(20) NOT NULL,
  topic varchar(255) default NULL,
  voters mediumint(8) unsigned default NULL,
  questions int(11) NOT NULL default '0',
  date datetime default NULL,
  display tinyint(4) NOT NULL default '0',
  open tinyint(4) NOT NULL default '1',
  hideresults tinyint(1) NOT NULL default '1' ,
  commentcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  INDEX pollquestions_pid(pid),
  INDEX pollquestions_date(date),
  INDEX pollquestions_display(display),
  INDEX pollquestions_commentcode(commentcode),
  INDEX pollquestions_statuscode(statuscode),
  PRIMARY KEY  (pid)
) TYPE=MyISAM
";

$_SQL[24] = "
CREATE TABLE {$_TABLES['pollvoters']} (
  id int(10) unsigned NOT NULL auto_increment,
  pid varchar(20) NOT NULL default '',
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  PRIMARY KEY (id)
) TYPE=MyISAM
";

$_SQL[25] = "
CREATE TABLE {$_TABLES['postmodes']} (
  code char(10) NOT NULL default '',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[26] = "
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

$_SQL[27] = "
CREATE TABLE {$_TABLES['sortcodes']} (
  code char(4) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[28] = "
CREATE TABLE {$_TABLES['speedlimit']} (
  id int(10) unsigned NOT NULL auto_increment,
  ipaddress varchar(15) NOT NULL default '',
  date int(10) unsigned default NULL,
  type varchar(30) NOT NULL default 'submit',
  PRIMARY KEY (id),
  KEY type_ipaddress (type,ipaddress),
  KEY date (date)
) TYPE = MyISAM
";

$_SQL[29] = "
CREATE TABLE {$_TABLES['statuscodes']} (
  code int(1) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[30] = "
CREATE TABLE {$_TABLES['stories']} (
  sid varchar(40) NOT NULL default '',
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
  trackbacks mediumint(8) unsigned NOT NULL default '0',
  related text,
  featured tinyint(3) unsigned NOT NULL default '0',
  show_topic_icon tinyint(1) unsigned NOT NULL default '1',
  commentcode tinyint(4) NOT NULL default '0',
  trackbackcode tinyint(4) NOT NULL default '0',
  statuscode tinyint(4) NOT NULL default '0',
  expire DATETIME NOT NULL default '0000-00-00 00:00:00',
  postmode varchar(10) NOT NULL default 'html',
  advanced_editor_mode tinyint(1) unsigned default '0',
  frontpage tinyint(3) unsigned default '1',
  in_transit tinyint(1) unsigned default '0',
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
  INDEX stories_statuscode(statuscode),
  INDEX stories_expire(expire),
  INDEX stories_date(date),
  INDEX stories_frontpage(frontpage),
  INDEX stories_in_transit(in_transit),
  PRIMARY KEY  (sid)
) TYPE=MyISAM
";

$_SQL[31] = "
CREATE TABLE {$_TABLES['storysubmission']} (
  sid varchar(20) NOT NULL default '',
  uid mediumint(8) NOT NULL default '1',
  tid varchar(20) NOT NULL default 'General',
  title varchar(128) default NULL,
  introtext text,
  bodytext text,
  date datetime default NULL,
  postmode varchar(10) NOT NULL default 'html',
  PRIMARY KEY  (sid)
) TYPE=MyISAM
";

$_SQL[32] = "
CREATE TABLE {$_TABLES['syndication']} (
  fid int(10) unsigned NOT NULL auto_increment,
  type varchar(30) NOT NULL default 'geeklog',
  topic varchar(48) NOT NULL default '::all',
  header_tid varchar(48) NOT NULL default 'none',
  format varchar(20) NOT NULL default 'RSS-2.0',
  limits varchar(5) NOT NULL default '10',
  content_length smallint(5) unsigned NOT NULL default '0',
  title varchar(40) NOT NULL default '',
  description text,
  feedlogo varchar(255),
  filename varchar(40) NOT NULL default 'geeklog.rss',
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

$_SQL[33] = "
CREATE TABLE {$_TABLES['topics']} (
  tid varchar(20) NOT NULL default '',
  topic varchar(48) default NULL,
  imageurl varchar(255) default NULL,
  sortnum tinyint(3) default NULL,
  limitnews tinyint(3) default NULL,
  is_default tinyint(1) unsigned NOT NULL DEFAULT '0',
  archive_flag tinyint(1) unsigned NOT NULL DEFAULT '0',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '3',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY  (tid)
) TYPE=MyISAM
";

$_SQL[34] = "
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
  etids text,
  aids varchar(255) NOT NULL default '',
  boxes varchar(255) NOT NULL default '',
  noboxes tinyint(4) NOT NULL default '0',
  maxstories tinyint(4) default NULL,
  INDEX userindex_uid(uid),
  INDEX userindex_noboxes(noboxes),
  INDEX userindex_maxstories(maxstories),
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[36] = "
CREATE TABLE {$_TABLES['userinfo']} (
  uid mediumint(8) NOT NULL default '1',
  about text,
  location varchar(96) NOT NULL default '',
  pgpkey text,
  userspace varchar(255) NOT NULL default '',
  tokens tinyint(3) unsigned NOT NULL default '0',
  totalcomments mediumint(9) NOT NULL default '0',
  lastgranted int(10) unsigned NOT NULL default '0',
  lastlogin VARCHAR(10) NOT NULL default '0',
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[37] = "
CREATE TABLE {$_TABLES['userprefs']} (
  uid mediumint(8) NOT NULL default '1',
  noicons tinyint(3) unsigned NOT NULL default '0',
  willing tinyint(3) unsigned NOT NULL default '1',
  dfid tinyint(3) unsigned NOT NULL default '0',
  tzid varchar(125) NOT NULL default '',
  emailstories tinyint(4) NOT NULL default '1',
  emailfromadmin tinyint(1) NOT NULL default '1',
  emailfromuser tinyint(1) NOT NULL default '1',
  showonline tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (uid)
) TYPE=MyISAM
";

$_SQL[38] = "
CREATE TABLE {$_TABLES['users']} (
  uid mediumint(8) NOT NULL auto_increment,
  username varchar(16) NOT NULL default '',
  remoteusername varchar(60) NULL,
  remoteservice varchar(60) NULL,
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
  status smallint(5) unsigned NOT NULL default '1',
  PRIMARY KEY  (uid),
  KEY LOGIN (uid,passwd,username),
  INDEX users_username(username),
  INDEX users_fullname(fullname),
  INDEX users_email(email),
  INDEX users_passwd(passwd),
  INDEX users_pwrequestid(pwrequestid)
) TYPE=MyISAM
";

$_SQL[39] = "
CREATE TABLE {$_TABLES['vars']} (
  name varchar(20) NOT NULL default '',
  value varchar(128) default NULL,
  PRIMARY KEY  (name)
) TYPE=MyISAM
";

$_SQL[40] = "
CREATE TABLE {$_TABLES['article_images']} (
  ai_sid varchar(40) NOT NULL,
  ai_img_num tinyint(2) unsigned NOT NULL,
  ai_filename varchar(128) NOT NULL,
  PRIMARY KEY (ai_sid,ai_img_num)
) TYPE=MyISAM
";

$_SQL[41] = "
CREATE TABLE {$_TABLES['trackback']} (
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
  INDEX trackback_url(url),
  INDEX trackback_type(type),
  INDEX trackback_date(date)
) TYPE=MyISAM
";

$_SQL[42] = "
CREATE TABLE {$_TABLES['pingservice']} (
  pid smallint(5) unsigned NOT NULL auto_increment,
  name varchar(128) default NULL,
  ping_url varchar(255) default NULL,
  site_url varchar(255) default NULL,
  method varchar(80) default NULL,
  is_enabled tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (pid),
  INDEX pingservice_is_enabled(is_enabled)
) TYPE=MyISAM
";

$_SQL[43] = "
CREATE TABLE {$_TABLES['staticpage']} (
  sp_id varchar(40) NOT NULL default '',
  sp_uid mediumint(8) NOT NULL default '1',
  sp_title varchar(128) NOT NULL default '',
  sp_content text NOT NULL,
  sp_hits mediumint(8) unsigned NOT NULL default '0',
  sp_date datetime NOT NULL default '0000-00-00 00:00:00',
  sp_format varchar(20) NOT NULL default '',
  sp_onmenu tinyint(1) unsigned NOT NULL default '0',
  sp_label varchar(64) default NULL,
  commentcode tinyint(4) NOT NULL default '0',
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  sp_centerblock tinyint(1) unsigned NOT NULL default '0',
  sp_help varchar(255) default '',
  sp_tid varchar(20) NOT NULL default 'none',
  sp_where tinyint(1) unsigned NOT NULL default '1',
  sp_php tinyint(1) unsigned NOT NULL default '0',
  sp_nf tinyint(1) unsigned default '0',
  sp_inblock tinyint(1) unsigned default '1',
  postmode varchar(16) NOT NULL default 'html',
  PRIMARY KEY  (sp_id),
  KEY staticpage_sp_uid (sp_uid),
  KEY staticpage_sp_date (sp_date),
  KEY staticpage_sp_onmenu (sp_onmenu),
  KEY staticpage_sp_centerblock (sp_centerblock),
  KEY staticpage_sp_tid (sp_tid),
  KEY staticpage_sp_where (sp_where)
) TYPE=MyISAM
";

$_SQL[44] = "
CREATE TABLE {$_TABLES['spamx']} (
  name varchar(20) NOT NULL default '',
  value varchar(255) NOT NULL default '',
  INDEX spamx_name(name)
) TYPE=MyISAM
";

$_SQL[45] = "
CREATE TABLE {$_TABLES['trackbackcodes']} (
  code tinyint(4) NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) TYPE=MyISAM
";

$_SQL[46] = "
CREATE TABLE {$_TABLES['linkcategories']} (
  cid varchar(20) NOT NULL,
  pid varchar(20) NOT NULL,
  category varchar(32) NOT NULL,
  description text DEFAULT NULL,
  tid varchar(20) DEFAULT NULL,
  created datetime DEFAULT NULL,
  modified datetime DEFAULT NULL,
  owner_id mediumint(8) unsigned NOT NULL default '1',
  group_id mediumint(8) unsigned NOT NULL default '1',
  perm_owner tinyint(1) unsigned NOT NULL default '3',
  perm_group tinyint(1) unsigned NOT NULL default '2',
  perm_members tinyint(1) unsigned NOT NULL default '2',
  perm_anon tinyint(1) unsigned NOT NULL default '2',
  PRIMARY KEY (cid),
  KEY links_pid (pid)
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
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (23,15) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (24,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (25,17) ";

$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (1,1,'user_block','gldefault','User Functions','all',2,'','','0000-00-00 00:00:00',1,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (2,1,'admin_block','gldefault','Admins Only','all',1,'','','0000-00-00 00:00:00',1,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (3,1,'section_block','gldefault','Topics','all',0,'','','0000-00-00 00:00:00',1,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (4,1,'polls_block','phpblock','Poll','all',2,'','','0000-00-00 00:00:00',0,'phpblock_polls',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (5,1,'events_block','phpblock','Events','all',4,'','','0000-00-00 00:00:00',1,'phpblock_calendar',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (6,1,'whats_new_block','gldefault','What\'s New','all',3,'','','0000-00-00 00:00:00',0,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (7,1,'first_block','normal','About Geeklog','homeonly',1,'<p><b>Welcome to Geeklog!</b><p>If you\'re already familiar with Geeklog - and especially if you\'re not: There have been many improvements to Geeklog since earlier versions that you might want to read up on. Please read the <a href=\"docs/changes.html\">release notes</a>. If you need help, please see the <a href=\"docs/support.html\">support options</a>.','','0000-00-00 00:00:00',0,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (8,1,'whosonline_block','phpblock','Who\'s Online','all',0,'','','0000-00-00 00:00:00',0,'phpblock_whosonline',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES (9,1,'older_stories','gldefault','Older Stories','all',5,'','','0000-00-00 00:00:00',1,'',4,2,3,3,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (0,'Comments Enabled') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (-1,'Comments Disabled') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (1,'Comments Closed') ";

$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('flat','Flat') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nested','Nested') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('threaded','Threaded') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentmodes']} (mode, name) VALUES ('nocomment','No Comments') ";

$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_html','s:0:\"\";','text','Core','s:0:\"\";','HTML Path','Site','',10,'Paths')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_url','s:0:\"\";','text','Core','s:0:\"\";','Site URL','Site','',20,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_admin_url','s:0:\"\";','text','Core','s:0:\"\";','Admin URL','Site','',30,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_mail','s:0:\"\";','text','Core','s:0:\"\";','Site E-Mail','Site','',40,'Mail')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('noreply_mail','s:0:\"\";','text','Core','s:0:\"\";','No-Reply E-Mail','Site','',50,'Mail')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_name','s:0:\"\";','text','Core','s:0:\"\";','Site Name','Site','',60,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_slogan','s:0:\"\";','text','Core','s:0:\"\";','Slogan','Site','',70,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('microsummary_short','s:4:\"GL: \";','text','Core','s:4:\"GL: \";','Microsummary','Site','',80,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_log','s:0:\"\";','text','Core','s:0:\"\";','Log','Site','',90,'Paths')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_language','s:0:\"\";','text','Core','s:0:\"\";','Language','Site','',100,'Paths')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('backup_path','s:0:\"\";','text','Core','s:0:\"\";','Backup','Site','',110,'Paths')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_data','s:0:\"\";','text','Core','s:0:\"\";','Data','Site','',120,'Paths')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_images','s:0:\"\";','text','Core','s:0:\"\";','Images','Site','',130,'Paths')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_pear','s:0:\"\";','text','Core','s:0:\"\";','Path Pear','Site','',140,'Pear')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('have_pear','b:0;','select','Core','b:0;','Have Pear?','Site','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',145,'Pear')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('mail_settings','a:8:{s:7:\"backend\";s:4:\"mail\";s:13:\"sendmail_path\";s:17:\"/usr/bin/sendmail\";s:13:\"sendmail_args\";s:0:\"\";s:4:\"host\";s:16:\"smtp.example.com\";s:4:\"port\";s:2:\"25\";s:4:\"auth\";b:0;s:8:\"username\";s:13:\"smtp-username\";s:8:\"password\";s:13:\"smtp-password\";}','@text','Core','a:8:{s:7:\"backend\";s:4:\"mail\";s:13:\"sendmail_path\";s:17:\"/usr/bin/sendmail\";s:13:\"sendmail_args\";s:0:\"\";s:4:\"host\";s:16:\"smtp.example.com\";s:4:\"port\";s:2:\"25\";s:4:\"auth\";b:0;s:8:\"username\";s:13:\"smtp-username\";s:8:\"password\";s:13:\"smtp-password\";}','Mail Settings','Site','',160,'Mail')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_mysqldump','i:1;','select','Core','i:1;','Allow MySQL Dump','Site','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',170,'MySQL')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('mysqldump_options','s:2:\"-Q\";','text','Core','s:2:\"-Q\";','MySQL Dump Options','Site','',180,'MySQL')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('theme','s:12:\"professional\";','text','Core','s:12:\"professional\";','Theme','Theme','',190,'Theme')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('menu_elements','a:5:{i:0;s:10:\"contribute\";i:1;s:6:\"search\";i:2;s:5:\"stats\";i:3;s:9:\"directory\";i:4;s:7:\"plugins\";}','%text','Core','a:5:{i:0;s:10:\"contribute\";i:1;s:6:\"search\";i:2;s:5:\"stats\";i:3;s:9:\"directory\";i:4;s:7:\"plugins\";}','Menu Elements','Theme','',200,'Theme')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_themes','s:0:\"\";','text','Core','s:0:\"\";','Themes Path','Theme','',210,'Theme')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('disable_new_user_registration','b:0;','select','Core','b:0;','Disable New Users','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',220,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_user_themes','i:1;','select','Core','i:1;','User Themes','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',230,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_user_language','i:1;','select','Core','i:1;','User Language','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',240,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_user_photo','i:1;','select','Core','i:1;','User Photo','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',250,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_username_change','i:0;','select','Core','i:0;','Username Changes','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',260,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_account_delete','i:0;','select','Core','i:0;','Account Deletion','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',270,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hide_author_exclusion','i:0;','select','Core','i:0;','Hide Author','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',280,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('show_fullname','i:0;','select','Core','i:0;','Show Fullname','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',290,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('show_servicename','b:1;','select','Core','b:1;','Show Service Name','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',300,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('custom_registration','b:0;','select','Core','b:0;','Custom Registration','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',310,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('user_logging_method','a:3:{s:8:\"standard\";b:1;s:6:\"openid\";b:0;s:8:\"3rdparty\";b:0;}','@select','Core','a:3:{s:8:\"standard\";b:1;s:6:\"openid\";b:0;s:8:\"3rdparty\";b:0;}','User Logging Method','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',320,'Users')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('spamx','i:128;','text','Core','i:128;','Spam-X','Users_and_Submissions','',330,'Spam-X')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('sort_admin','b:1;','select','Core','b:1;','Sort Links','Miscellaneous','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',340,'Admin')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('language','s:7:\"english\";','text','Core','s:7:\"english\";','Language','Language_and_Locale','',350,'Language')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('locale','s:5:\"en_GB\";','text','Core','s:5:\"en_GB\";','Locale','Language_and_Locale','',360,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('date','s:26:\"%A, %B %d %Y @ %I:%M %p %Z\";','text','Core','s:26:\"%A, %B %d %Y @ %I:%M %p %Z\";','Date','Language_and_Locale','',370,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('daytime','s:13:\"%m/%d %I:%M%p\";','text','Core','s:13:\"%m/%d %I:%M%p\";','Daytime','Language_and_Locale','',380,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('shortdate','s:2:\"%x\";','text','Core','s:2:\"%x\";','Short Date','Language_and_Locale','',390,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('dateonly','s:5:\"%d-%b\";','text','Core','s:5:\"%d-%b\";','Date Only','Language_and_Locale','',400,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('timeonly','s:7:\"%I:%M%p\";','text','Core','s:7:\"%I:%M%p\";','Time Only','Language_and_Locale','',410,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('week_start','s:3:\"Sun\";','text','Core','s:3:\"Sun\";','Week Start','Language_and_Locale','',420,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hour_mode','i:12;','select','Core','i:12;','Hour Mode','Language_and_Locale','a:2:{i:12;s:2:\"12\";i:24;s:2:\"24\";}',430,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('thousand_separator','s:1:\",\";','text','Core','s:1:\",\";','Thousand Separator','Language_and_Locale','',440,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('decimal_separator','s:1:\".\";','text','Core','s:1:\".\";','Decimal Separator','Language_and_Locale','',450,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('decimal_count','s:1:\"2\";','text','Core','s:1:\"2\";','Decimal Count','Language_and_Locale','',460,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('language_files','a:2:{s:2:\"en\";s:13:\"english_utf-8\";s:2:\"de\";s:19:\"german_formal_utf-8\";}','*text','Core','a:2:{s:2:\"en\";s:13:\"english_utf-8\";s:2:\"de\";s:19:\"german_formal_utf-8\";}','Language Files','Language_and_Locale','',470,'Language')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('languages','a:2:{s:2:\"en\";s:7:\"English\";s:2:\"de\";s:7:\"Deutsch\";}','*text','Core','a:2:{s:2:\"en\";s:7:\"English\";s:2:\"de\";s:7:\"Deutsch\";}','Languages','Language_and_Locale','',480,'Language')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('timezone','s:9:\"Etc/GMT-6\";','text','Core','s:9:\"Etc/GMT-6\";','Timezone','Language_and_Locale','',490,'Locale')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_enabled','b:1;','select','Core','b:1;','Site Enabled','Site','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',500,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('site_disabled_msg','s:44:\"Geeklog Site is down. Please come back soon.\";','text','Core','s:44:\"Geeklog Site is down. Please come back soon.\";','Disabled Message','Site','',510,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rootdebug','b:0;','select','Core','b:0;','Root Debugging','Miscellaneous','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',520,'Debug')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_session','s:10:\"gl_session\";','text','Core','s:10:\"gl_session\";','Cookie Session','Miscellaneous','',530,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_name','s:7:\"geeklog\";','text','Core','s:7:\"geeklog\";','Cookie Name','Miscellaneous','',540,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_password','s:8:\"password\";','text','Core','s:8:\"password\";','Cookie Password','Miscellaneous','',550,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_theme','s:5:\"theme\";','text','Core','s:5:\"theme\";','Cookie Theme','Miscellaneous','',560,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_language','s:8:\"language\";','text','Core','s:8:\"language\";','Cookie Language','Miscellaneous','',570,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_ip','i:0;','select','Core','i:0;','Cookies embed IP?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',580,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_perm_cookie_timeout','i:28800;','text','Core','i:28800;','Permanent Timeout','Miscellaneous','',590,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('session_cookie_timeout','i:7200;','text','Core','i:7200;','Session Timeout','Miscellaneous','',600,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookie_path','s:1:\"/\";','text','Core','s:1:\"/\";','Cookie Path','Miscellaneous','',610,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookiedomain','s:0:\"\";','text','Core','s:0:\"\";','Cookie Domain','Miscellaneous','',620,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cookiesecure','i:0;','text','Core','i:0;','Cookie Secure','Miscellaneous','',630,'Cookies')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('lastlogin','b:1;','select','Core','b:1;','Store Last Login?','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',640,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('ostype','s:5:\"Linux\";','text','Core','s:5:\"Linux\";','OS Type','Miscellaneous','',650,'Miscellaneous')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('pdf_enabled','i:0;','select','Core','i:0;','PDF Enabled?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',660,'Miscellaneous')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('num_search_results','i:10;','text','Core','i:10;','Number of Search Results','Site','',670,'Search')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('loginrequired','i:0;','select','Core','i:0;','Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',680,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('submitloginrequired','i:0;','select','Core','i:0;','Submit Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',690,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('commentsloginrequired','i:0;','select','Core','i:0;','Comment Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',700,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('statsloginrequired','i:0;','select','Core','i:0;','Stats Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',710,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('searchloginrequired','i:0;','select','Core','i:0;','Search Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',720,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('profileloginrequired','i:0;','select','Core','i:0;','Profile Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',730,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailuserloginrequired','i:0;','select','Core','i:0;','E-Mail User Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',740,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailstoryloginrequired','i:0;','select','Core','i:0;','E-Mail Story Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',750,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('directoryloginrequired','i:0;','select','Core','i:0;','Directory Login Required?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',760,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('storysubmission','i:1;','select','Core','i:1;','Story Submission Queue?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',770,'Submission Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('usersubmission','i:0;','select','Core','i:0;','User Submission Queue?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',780,'User Submission')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('listdraftstories','i:0;','select','Core','i:0;','List Draft Stories?','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',790,'Submission Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('notification','a:0:{}','%text','Core','a:0:{}','Notifications','Miscellaneous','',800,'Miscellaneous')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('postmode','s:9:\"plaintext\";','select','Core','s:9:\"plaintext\";','Post Mode','Users_and_Submissions','a:2:{s:5:\"Plain\";s:9:\"plaintext\";s:4:\"HTML\";s:4:\"html\";}',810,'Submission Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('speedlimit','i:45;','text','Core','i:45;','Post Speed Limit','Users_and_Submissions','',820,'Submission Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('skip_preview','i:0;','text','Core','i:0;','Skip Preview in Posts','Users_and_Submissions','',830,'Submission Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('advanced_editor','b:0;','select','Core','b:0;','Advanced Editor?','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',840,'Submission Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('wikitext_editor','b:0;','select','Core','b:0;','Wikitext Editor?','Users_and_Submissions','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',850,'Submission Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('cron_schedule_interval','i:86400;','text','Core','i:86400;','Cron Schedule Interval','Miscellaneous','',860,'Miscellaneous')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('sortmethod','s:7:\"sortnum\";','text','Core','s:7:\"sortnum\";','Topic Sort Method','Topics_and_Daily_Digest','',870,'Topic')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('showstorycount','i:1;','select','Core','i:1;','Show Story Count?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',880,'Topic')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('showsubmissioncount','i:1;','select','Core','i:1;','Show Submission Count?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',890,'Topic')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hide_home_link','i:0;','select','Core','i:0;','Hide Home Link?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',900,'Topic')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('whosonline_threshold','i:300;','text','Core','i:300;','Threshold','Topics_and_Daily_Digest','',910,'Who\'s Online')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('whosonline_anonymous','i:0;','select','Core','i:0;','Anonymous?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',920,'Who\'s Online')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailstories','i:0;','select','Core','i:0;','E-Mail Stories?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',930,'Daily Digest')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailstorieslength','i:1;','text','Core','i:1;','E-Mail Stories Length','Topics_and_Daily_Digest','',940,'Daily Digest')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('emailstoriesperdefault','i:0;','select','Core','i:0;','E-Mail Stories Default?','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',950,'Daily Digest')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_domains','s:0:\"\";','text','Core','s:0:\"\";','Automatic Allow Domains','Users_and_Submissions','',960,'User Submission')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('disallow_domains','s:0:\"\";','text','Core','s:0:\"\";','Automatic Disallow Domains','Users_and_Submissions','',970,'User Submission')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('newstoriesinterval','i:86400;','text','Core','i:86400;','New Stories Interval','Topics_and_Daily_Digest','',980,'What\'s New')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('newcommentsinterval','i:172800;','text','Core','i:172800;','New Comments Interval','Topics_and_Daily_Digest','',990,'What\'s New')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('newtrackbackinterval','i:172800;','text','Core','i:172800;','New Trackback Interval','Topics_and_Daily_Digest','',1000,'What\'s New')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hidenewstories','i:0;','select','Core','i:0;','Hide New Stories','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1010,'What\'s New')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hidenewcomments','i:0;','select','Core','i:0;','Hide New Comments','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1020,'What\'s New')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hidenewtrackbacks','i:0;','select','Core','i:0;','Hide New Trackbacks','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1030,'What\'s New')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hidenewplugins','i:0;','select','Core','i:0;','Hide New Plugins','Topics_and_Daily_Digest','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1040,'What\'s New')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('title_trim_length','i:20;','text','Core','i:20;','Title Trim','Topics_and_Daily_Digest','',1050,'What\'s New')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('trackback_enabled','b:1;','select','Core','b:1;','Trackback?','Stories_and_Trackback','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1060,'Trackback')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('pingback_enabled','b:1;','select','Core','b:1;','Pingback?','Stories_and_Trackback','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1070,'Pingback')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('ping_enabled','b:1;','select','Core','b:1;','Ping Enabled?','Stories_and_Trackback','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1080,'Pingback')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('trackback_code','i:0;','select','Core','i:0;','Trackback Default','Stories_and_Trackback','a:2:{s:4:\"True\";i:0;s:5:\"False\";i:-1;}',1090,'Trackback')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('multiple_trackbacks','i:0;','select','Core','i:0;','Multiple Trackbacks','Stories_and_Trackback','a:3:{s:6:\"Reject\";i:0;s:16:\"Only Keep Latest\";i:1;s:20:\"Allow Multiple Posts\";i:2;}',1100,'Trackback')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('trackbackspeedlimit','i:300;','text','Core','i:300;','Trackback Speed Limit','Stories_and_Trackback','',1110,'Trackback')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('check_trackback_link','i:2;','select','Core','i:2;','Check Trackbacks','Stories_and_Trackback','',1120,'Trackback')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('pingback_self','i:0;','select','Core','i:0;','Pingback Self?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1130,'Pingback')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('pingback_excerpt','b:1;','select','Core','b:1;','Pingback Excerpt?','Stories_and_Trackback','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1140,'Pingback')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('link_documentation','i:1;','select','Core','i:1;','Link Documentation?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1150,'Admin')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('link_versionchecker','i:1;','select','Core','i:1;','Link Version Checker?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1160,'Admin')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('maximagesperarticle','i:5;','text','Core','i:5;','Max Images per Article','Stories_and_Trackback','',1170,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('limitnews','i:10;','text','Core','i:10;','Limit News','Stories_and_Trackback','',1180,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('minnews','i:1;','text','Core','i:1;','Minimum News','Stories_and_Trackback','',1190,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('contributedbyline','i:1;','select','Core','i:1;','Show Contributed By?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1200,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hideviewscount','i:0;','select','Core','i:0;','Hide Views Count?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1210,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hideemailicon','i:0;','select','Core','i:0;','Hide E-Mail Icon?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1220,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hideprintericon','i:0;','select','Core','i:0;','Hide Print Icon?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1230,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_page_breaks','i:1;','select','Core','i:1;','Allow Page Breaks?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1240,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('page_break_comments','s:4:\"last\";','select','Core','s:4:\"last\";','Comments on Page Breaks','Stories_and_Trackback','a:3:{s:4:\"Last\";s:4:\"last\";s:5:\"First\";s:5:\"first\";s:3:\"All\";s:3:\"all\";}',1250,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('article_image_align','s:5:\"right\";','select','Core','s:5:\"right\";','Article Image Align','Stories_and_Trackback','a:2:{s:5:\"Right\";s:5:\"right\";s:4:\"Left\";s:4:\"left\";}',1260,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('show_topic_icon','i:1;','select','Core','i:1;','Show Topic Icon?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1270,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('draft_flag','i:0;','select','Core','i:0;','Draft Flag?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1280,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('frontpage','i:1;','select','Core','i:1;','Frontpage?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1290,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hide_no_news_msg','i:0;','select','Core','i:0;','Hide No News Message?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1300,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('hide_main_page_navigation','i:0;','select','Core','i:0;','Hide Main Page Navigation?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1310,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('onlyrootfeatures','i:0;','select','Core','i:0;','Only Root can Feature?','Stories_and_Trackback','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1320,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('aftersave_story','s:4:\"item\";','select','Core','s:4:\"item\";','After Saving Story','Stories_and_Trackback','a:4:{s:15:\"Forward to page\";s:4:\"item\";s:12:\"Display List\";s:4:\"list\";s:12:\"Display Home\";s:4:\"home\";s:18:\"Display Admin\";s:5:\"admin\";}',1330,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('aftersave_user','s:4:\"item\";','select','Core','s:4:\"item\";','After Saving User','Stories_and_Trackback','a:4:{s:15:\"Forward to page\";s:4:\"item\";s:12:\"Display List\";s:4:\"list\";s:12:\"Display Home\";s:4:\"home\";s:18:\"Display Admin\";s:5:\"admin\";}',1340,'Story')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('show_right_blocks','b:0;','select','Core','b:0;','Show Right Blocks?','Theme','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1350,'Advanced Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('showfirstasfeatured','i:0;','select','Core','i:0;','Show First as Featured?','Theme','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1360,'Advanced Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('left_blocks_in_footer','i:0;','select','Core','i:0;','Left Blocks in Footer?','Theme','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1370,'Advanced Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('backend','i:1;','select','Core','i:1;','Backend?','Site','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1380,'RSS')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rdf_file','s:0:\"\";','text','Core','s:0:\"\";','RDF File','Site','',1390,'RSS')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rdf_limit','i:10;','text','Core','i:10;','RDF Limit','Site','',1400,'RSS')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rdf_storytext','i:1;','text','Core','i:1;','RDF Storytext','Site','',1410,'RSS')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('rdf_language','s:5:\"en-gb\";','text','Core','s:5:\"en-gb\";','RDF Language','Site','',1420,'RSS')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('syndication_max_headlines','i:0;','text','Core','i:0;','Maximum Headlines','Site','',1430,'RSS')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('copyright','s:4:\"2007\";','text','Core','s:4:\"2007\";','Copyright Year','Site','',1440,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('image_lib','s:0:\"\";','select','Core','s:0:\"\";','Image Library','Images','a:4:{s:4:\"None\";s:0:\"\";s:6:\"Netpbm\";s:6:\"netpbm\";s:11:\"ImageMagick\";s:11:\"imagemagick\";s:5:\"gdLib\";s:5:\"gdlib\";}',1450,'Image Library')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_to_mogrify','s:0:\"\";','text','Core','s:0:\"\";','Path to Mogrify','Images','',1460,'Image Library')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('path_to_netpbm','s:0:\"\";','text','Core','s:0:\"\";','Path to Netpbm','Images','',1470,'Image Library')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('debug_image_upload','b:1;','select','Core','b:1;','Debug Image Uploading?','Images','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1480,'Upload')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('keep_unscaled_image','i:0;','select','Core','i:0;','Keep Unscaled Image?','Images','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1490,'Upload')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allow_user_scaling','i:1;','select','Core','i:1;','Allow User Scaling?','Images','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1500,'Upload')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_image_width','i:160;','text','Core','i:160;','Max Image Width?','Images','',1510,'Image')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_image_height','i:160;','text','Core','i:160;','Max Image Height?','Images','',1520,'Image')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_image_size','i:1048576;','text','Core','i:1048576;','Max Image Size?','Images','',1530,'Image')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_topicicon_width','i:48;','text','Core','i:48;','Max Topic Icon Width?','Images','',1540,'Topic Icons')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_topicicon_height','i:48;','text','Core','i:48;','Max Topic Icon Height?','Images','',1550,'Topic Icons')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_topicicon_size','i:65536;','text','Core','i:65536;','Max Topic Icon Size?','Images','',1560,'Topic Icons')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_photo_width','i:128;','text','Core','i:128;','Max Photo Width?','Images','',1570,'Photos')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_photo_height','i:128;','text','Core','i:128;','Max Photo Height?','Images','',1580,'Photos')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('max_photo_size','i:65536;','text','Core','i:65536;','Max Photo Size?','Images','',1590,'Photos')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('use_gravatar','b:0;','select','Core','b:0;','Use Gravatar?','Images','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1600,'Gravatar')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('gravatar_rating','s:1:\"R\";','text','Core','s:1:\"R\";','Gravatar Rating Allowed','Images','',1610,'Gravatar')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('force_photo_width','i:75;','text','Core','i:75;','Force Photo Width','Images','',1620,'Photos')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_photo','s:30:\"http://example.com/default.jpg\";','text','Core','s:30:\"http://example.com/default.jpg\";','Default Photo','Images','',1630,'Photos')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('commentspeedlimit','i:45;','text','Core','i:45;','Comment Speed Limit','Users_and_Submissions','',1640,'Comments')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('comment_limit','i:100;','text','Core','i:100;','Comment Limit','Users_and_Submissions','',1650,'Comments')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('comment_mode','s:8:\"threaded\";','select','Core','s:8:\"threaded\";','Comment Mode','Users_and_Submissions','a:4:{s:8:\"Threaded\";s:8:\"threaded\";s:6:\"Nested\";s:6:\"nested\";s:11:\"No Comments\";s:10:\"nocomments\";s:4:\"Flat\";s:4:\"flat\";}:',1660,'Comments')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('comment_code','i:0;','select','Core','i:0;','Comment Code','Users_and_Submissions','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1670,'Comments')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('passwordspeedlimit','i:300;','text','Core','i:300;','Password Speed Limit','Users_and_Submissions','',1680,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('login_attempts','i:3;','text','Core','i:3;','Login Attempts','Users_and_Submissions','',1690,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('login_speedlimit','i:300;','text','Core','i:300;','Login Speed Limit','Users_and_Submissions','',1700,'Login Settings')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('user_html','a:14:{s:1:\"p\";a:0:{}s:1:\"b\";a:0:{}s:6:\"strong\";a:0:{}s:1:\"i\";a:0:{}s:1:\"a\";a:3:{s:4:\"href\";i:1;s:5:\"title\";i:1;s:3:\"rel\";i:1;}s:2:\"em\";a:0:{}s:2:\"br\";a:0:{}s:2:\"tt\";a:0:{}s:2:\"hr\";a:0:{}s:2:\"li\";a:0:{}s:2:\"ol\";a:0:{}s:2:\"ul\";a:0:{}s:4:\"code\";a:0:{}s:3:\"pre\";a:0:{}}','**placeholder','Core','a:14:{s:1:\"p\";a:0:{}s:1:\"b\";a:0:{}s:6:\"strong\";a:0:{}s:1:\"i\";a:0:{}s:1:\"a\";a:3:{s:4:\"href\";i:1;s:5:\"title\";i:1;s:3:\"rel\";i:1;}s:2:\"em\";a:0:{}s:2:\"br\";a:0:{}s:2:\"tt\";a:0:{}s:2:\"hr\";a:0:{}s:2:\"li\";a:0:{}s:2:\"ol\";a:0:{}s:2:\"ul\";a:0:{}s:4:\"code\";a:0:{}s:3:\"pre\";a:0:{}}','User HTML','Miscellaneous','',1710,'HTML Filtering')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('admin_html','a:7:{s:1:\"p\";a:3:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;}s:3:\"div\";a:2:{s:5:\"class\";i:1;s:2:\"id\";i:1;}s:4:\"span\";a:2:{s:5:\"class\";i:1;s:2:\"id\";i:1;}s:5:\"table\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"width\";i:1;s:6:\"border\";i:1;s:11:\"cellspacing\";i:1;s:11:\"cellpadding\";i:1;}s:2:\"tr\";a:4:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;}s:2:\"th\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;s:7:\"colspan\";i:1;s:7:\"rowspan\";i:1;}s:2:\"td\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;s:7:\"colspan\";i:1;s:7:\"rowspan\";i:1;}}','**placeholder','Core','a:7:{s:1:\"p\";a:3:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;}s:3:\"div\";a:2:{s:5:\"class\";i:1;s:2:\"id\";i:1;}s:4:\"span\";a:2:{s:5:\"class\";i:1;s:2:\"id\";i:1;}s:5:\"table\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"width\";i:1;s:6:\"border\";i:1;s:11:\"cellspacing\";i:1;s:11:\"cellpadding\";i:1;}s:2:\"tr\";a:4:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;}s:2:\"th\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;s:7:\"colspan\";i:1;s:7:\"rowspan\";i:1;}s:2:\"td\";a:6:{s:5:\"class\";i:1;s:2:\"id\";i:1;s:5:\"align\";i:1;s:6:\"valign\";i:1;s:7:\"colspan\";i:1;s:7:\"rowspan\";i:1;}}','Admin HTML','Miscellaneous','',1720,'HTML Filtering')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('skip_html_filter_for_root','i:0;','select','Core','i:0;','Skip HTML Filter for Root?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1730,'HTML Filtering')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('allowed_protocols','a:3:{i:0;s:4:\"http\";i:1;s:3:\"ftp\";i:2;s:5:\"https\";}','%text','Core','a:3:{i:0;s:4:\"http\";i:1;s:3:\"ftp\";i:2;s:5:\"https\";}','Allowed Protocols','Site','',1740,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('disable_autolinks','i:0;','select','Core','i:0;','Disable Autolinks?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1750,'Miscellaneous')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('censormode','i:1;','select','Core','i:1;','Censor Mode?','Miscellaneous','a:2:{s:4:\"True\";i:1;s:5:\"False\";i:0;}',1760,'Censoring')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('censorreplace','s:12:\"*censormode*\";','text','Core','s:12:\"*censormode*\";','Censor Replace','Miscellaneous','',1770,'Censoring')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('censorlist','a:14:{i:0;s:4:\"fuck\";i:1;s:4:\"cunt\";i:2;s:6:\"fucker\";i:3;s:7:\"fucking\";i:4;s:5:\"pussy\";i:5;s:4:\"cock\";i:6;s:4:\"c0ck\";i:7;s:5:\" cum \";i:8;s:4:\"twat\";i:9;s:4:\"clit\";i:10;s:5:\"bitch\";i:11;s:3:\"fuk\";i:12;s:6:\"fuking\";i:13;s:12:\"motherfucker\";}','%text','Core','a:14:{i:0;s:4:\"fuck\";i:1;s:4:\"cunt\";i:2;s:6:\"fucker\";i:3;s:7:\"fucking\";i:4;s:5:\"pussy\";i:5;s:4:\"cock\";i:6;s:4:\"c0ck\";i:7;s:5:\" cum \";i:8;s:4:\"twat\";i:9;s:4:\"clit\";i:10;s:5:\"bitch\";i:11;s:3:\"fuk\";i:12;s:6:\"fuking\";i:13;s:12:\"motherfucker\";}','Censor List','Miscellaneous','',1780,'Censoring')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('ip_lookup','s:28:\"/nettools/whois.php?domain=*\";','text','Core','s:28:\"/nettools/whois.php?domain=*\";','IP Lookup','Miscellaneous','',1790,'IP Lookup')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('url_rewrite','b:0;','select','Core','b:0;','URL Rewrite','Site','a:2:{s:4:\"True\";b:1;s:5:\"False\";b:0;}',1800,'Site')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_permissions_block','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','@select','Core','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','Block Default Permissions','Miscellaneous','a:3:{s:9:\"No access\";i:0;s:9:\"Read-Only\";i:2;s:10:\"Read-Write\";i:3;}',1810,'Default Permission')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_permissions_story','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','@select','Core','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','Story Default Permissions','Miscellaneous','a:3:{s:9:\"No access\";i:0;s:9:\"Read-Only\";i:2;s:10:\"Read-Write\";i:3;}',1820,'Default Permission')";
$_DATA[] = "INSERT INTO `{$_TABLES['conf_values']}` VALUES ('default_permissions_topic','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','@select','Core','a:4:{i:0;i:3;i:1;i:2;i:2;i:2;i:3;i:2;}','Topic Default Permissions','Miscellaneous','a:3:{s:9:\"No access\";i:0;s:9:\"Read-Only\";i:2;s:10:\"Read-Write\";i:3;}',1830,'Default Permission')";

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

$_DATA[] = "INSERT INTO {$_TABLES['eventsubmission']} (eid, title, description, location, datestart, dateend, url, allday, zipcode, state, city, address2, address1, event_type, timestart, timeend) VALUES ('2006051410130162','Geeklog installed','Today, you successfully installed this Geeklog site.','Your webserver',CURDATE(),CURDATE(),'http://www.geeklog.net/',1,NULL,NULL,NULL,NULL,NULL,'',NULL,NULL) ";

$_DATA[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (0,'Not Featured') ";
$_DATA[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (1,'Featured') ";

$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (1,'story.edit','Access to story editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (2,'story.moderate','Ability to moderate pending stories',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (3,'links.moderate','Ability to moderate pending links',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (4,'links.edit','Access to links editor',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (5,'user.edit','Access to user editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (6,'user.delete','Ability to delete a user',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (7,'user.mail','Ability to send email to members',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (8,'calendar.moderate','Ability to moderate pending events',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (9,'calendar.edit','Access to event editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (10,'block.edit','Access to block editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (11,'topic.edit','Access to topic editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (12,'polls.edit','Access to polls editor',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (13,'plugin.edit','Access to plugin editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (14,'group.edit','Ability to edit groups',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (15,'group.delete','Ability to delete groups',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (16,'block.delete','Ability to delete a block',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (17,'staticpages.edit','Ability to edit a static page',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (18,'staticpages.delete','Ability to delete static pages',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (19,'story.submit','May skip the story submission queue',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (20,'links.submit','May skip the links submission queue',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (21,'calendar.submit','May skip the event submission queue',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (22,'staticpages.PHP','Ability use PHP in static pages',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (23,'spamx.admin', 'Full access to Spam-X plugin', 0) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (24,'story.ping', 'Ability to send pings, pingbacks, or trackbacks for stories', 1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (25,'syndication.edit', 'Access to Content Syndication', 1) ";

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
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (17,NULL,1) ";

$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (1,'Root','Has full access to the site',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (2,'All Users','Group that a typical user is added to',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (3,'Story Admin','Has full access to story features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (4,'Block Admin','Has full access to block features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (5,'Links Admin','Has full access to links features',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (6,'Topic Admin','Has full access to topic features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (7,'Calendar Admin','Has full access to calendar features',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (8,'Polls Admin','Has full access to polls features',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (9,'User Admin','Has full access to user features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (10,'Plugin Admin','Has full access to plugin features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (11,'Group Admin','Is a User Admin with access to groups, too',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (12,'Mail Admin','Can use Mail Utility',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (13,'Logged-in Users','All registered members',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (14,'Static Page Admin','Can administer static pages',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (15,'spamx Admin', 'Users in this group can administer the Spam-X plugin',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (16,'Remote Users', 'Users in this group can have authenticated against a remote server.',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (17,'Syndication Admin', 'Can create and modify web feeds for the site',1) ";

$_DATA[] = "INSERT INTO {$_TABLES['links']} (lid, cid, url, description, title, hits, date, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('geeklog.net', '20070828065220743', 'http://www.geeklog.net/', 'Visit the Geeklog homepage for support, FAQs, updates, add-ons, and a great community.', 'Geeklog Project Homepage', 0, '2007-08-28 14:52:13', 1, 5, 3, 2, 2, 2);";
$_DATA[] = "INSERT INTO {$_TABLES['linkcategories']} (cid, pid, category, description, tid, created, modified, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('20070828065220743', 'site', 'Geeklog Sites', NULL, NULL, '2007-08-28 14:52:20', '2007-08-28 14:52:20', 2, 5, 3, 2, 2, 2);";
$_DATA[] = "INSERT INTO {$_TABLES['linkcategories']} (cid, pid, category, description, tid, created, modified, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('site', 'root', 'Root', 'Website root', '', '2007-08-28 14:52:21', '2007-08-28 14:52:21', 2, 5, 3, 3, 2, 2);";

$_DATA[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (0,'Don\'t Email') ";
$_DATA[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES (1,'Email Headlines Each Night') ";

$_DATA[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, site_url, ping_url, method, is_enabled) VALUES (1, 'Ping-O-Matic', 'http://pingomatic.com/', 'http://rpc.pingomatic.com/', 'weblogUpdates.ping', 1)";

$_DATA[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('staticpages', '1.4.4','1.4.1',1,'http://www.geeklog.net/') ";
$_DATA[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('spamx', '1.1.1','1.4.1',1,'http://www.pigstye.net/gplugs/staticpages/index.php/spamx') ";
$_DATA[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('links', '2.0', '1.4.1', 1, 'http://www.geeklog.net/')";
$_DATA[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('polls', '2.0.1', '1.4.1', '1', 'http://www.geeklog.net/')";
$_DATA[] = "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage) VALUES ('calendar', '1.0.2', '1.4.1', '1', 'http://www.geeklog.net/')";

$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 1, 'MS SQL support', 0, '');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 2, 'Multi-language support', 0, '');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 3, 'Calendar as a plugin', 0, '');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 4, 'SLV spam protection', 0, '');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 5, 'Mass-delete users', 0, '');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 1, 6, 'Other', 0, '');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 2, 1, 'Story-Images', 0, '');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 2, 2, 'User-Rights handling', 0, '');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 2, 3, 'The Support', 0, '');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollanswers']}` (`pid`, `qid`, `aid`, `answer`, `votes`, `remark`) VALUES ('geeklogfeaturepoll', 2, 4, 'Plugin Availability', 0, '');";

$_DATA[] = "INSERT INTO `{$_TABLES['pollquestions']}` (`pid`, `question`) VALUES ('geeklogfeaturepoll', 'What is the best new feature of Geeklog?');";
$_DATA[] = "INSERT INTO `{$_TABLES['pollquestions']}` (`pid`, `question`) VALUES ('geeklogfeaturepoll', 'What is the all-time best feature of Geeklog?');";

$_DATA[] = "INSERT INTO `{$_TABLES['polltopics']}` (`pid`, `topic`, `voters`, `questions`, `date`, `display`, `open`, `hideresults`, `commentcode`, `statuscode`, `owner_id`, `group_id`, `perm_owner`, `perm_group`, `perm_members`, `perm_anon`) VALUES ('geeklogfeaturepoll', 'Tell us your opinion about Geeklog', 0, 2, '2007-01-16 12:24:22', 1, 1, 1, 0, 0, 2, 8, 3, 2, 2, 2);";

$_DATA[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('plaintext','Plain Old Text') ";
$_DATA[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('html','HTML Formatted') ";

$_DATA[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('ASC','Oldest First') ";
$_DATA[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('DESC','Newest First') ";

$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (1,'Refreshing') ";
$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (0,'Normal') ";
$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (10,'Archive') ";

$_DATA[] = "INSERT INTO {$_TABLES['stories']} (sid, uid, draft_flag, tid, date, title, introtext, bodytext, hits, numemails, comments, related, featured, commentcode, statuscode, postmode, frontpage, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('welcome',2,0,'Geeklog',NOW(),'Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing Geeklog. Please take the time to read everything in the <a href=\"docs/index.html\">docs directory</a>. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.\r\r<p>To log into your new Geeklog site, please use this account:\r<p>Username: <b>Admin</b><br>\rPassword: <b>password</b><p><b>And don\'t forget to <a href=\"{$_CONF['site_url']}/usersettings.php?mode=edit\">change your password</a> after logging in!</b>','',100,1,0,'',1,0,0,'html',1,2,3,3,2,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['storysubmission']} (sid, uid, tid, title, introtext, date, postmode) VALUES ('security-reminder',2,'Geeklog','Are you secure?','<p>This is a reminder to secure your site once you have Geeklog up and running. What you should do:</p>\r\r<ol>\r<li>Change the default password for the Admin account.</li>\r<li>Remove the install directory (you won\'t need it any more).</li>\r</ol>',NOW(),'html') ";

$_DATA[] = "INSERT INTO {$_TABLES['syndication']} (type, topic, header_tid, format, limits, content_length, title, description, filename, charset, language, is_enabled, updated, update_info) VALUES ('geeklog', '::all', 'all', 'RSS-2.0', 10, 1, 'Geeklog Site', 'Another Nifty Geeklog Site', 'geeklog.rss', 'iso-8859-1', 'en-gb', 1, '0000-00-00 00:00:00', NULL)";

$_DATA[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('General','General News','/images/topics/topic_news.gif',1,10,6,2,3,2,2,2)";
$_DATA[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('Geeklog','Geeklog','/images/topics/topic_gl.gif',2,10,6,2,3,2,2,2)";

$_DATA[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (1,'nested','ASC',100) ";
$_DATA[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (2,'threaded','ASC',100) ";

$_DATA[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (1,'','-','','',0,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (2,'','','','',0,NULL) ";

$_DATA[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (1,NULL,NULL,'',0,0,0) ";
$_DATA[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (2,NULL,NULL,'',0,0,0) ";

$_DATA[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (1,0,0,0,'',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (2,0,1,0,'',1) ";

#
# Dumping data for table 'users'
#

$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status) VALUES (1,'Anonymous','Anonymous','',NULL,NULL,'',NOW(),0,NULL,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status) VALUES (2,'Admin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','http://www.geeklog.net/','',NOW(),28800,NULL,3) ";

$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('totalhits','0') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastemailedstories','') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('last_scheduled_run','') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('spamx.counter','0') ";

$_DATA[] = "INSERT INTO {$_TABLES['trackbackcodes']} (code, name) VALUES (0,'Trackback Enabled') ";
$_DATA[] = "INSERT INTO {$_TABLES['trackbackcodes']} (code, name) VALUES (-1,'Trackback Disabled') ";

?>
