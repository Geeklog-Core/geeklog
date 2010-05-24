<?php

$_SQL[] = "
CREATE TABLE {$_TABLES['access']} (
  acc_ft_id smallint NOT NULL default '0',
  acc_grp_id smallint NOT NULL default '0',
  PRIMARY KEY  (acc_ft_id,acc_grp_id)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['article_images']} (
  ai_sid varchar(40) NOT NULL,
  ai_img_num smallint NULL,
  ai_filename varchar(128) NOT NULL,
  PRIMARY KEY (ai_sid,ai_img_num)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['blocks']} (
  bid SERIAL ,
  is_enabled smallint NOT NULL DEFAULT '1',
  name varchar(48) NOT NULL default '',
  type varchar(20) NOT NULL default 'normal',
  title varchar(48) default NULL,
  tid varchar(20) NOT NULL default 'All',
  blockorder smallint  NOT NULL default '1',
  content text,
  allow_autotags smallint  NOT NULL DEFAULT '0',
  rdfurl varchar(255) default NULL,
  rdfupdated timestamp  default NULL,
  rdf_last_modified varchar(40) default NULL,
  rdf_etag varchar(40) default NULL,
  rdflimit smallint  NOT NULL default '0',
  onleft smallint NOT NULL default '1',
  phpblockfn varchar(128) default '',
  help varchar(255) default '',
  owner_id smallint  NOT NULL default '1',
  group_id smallint  NOT NULL default '1',
  perm_owner smallint  NOT NULL default '3',
  perm_group smallint  NOT NULL default '3',
  perm_members smallint  NOT NULL default '2',
  perm_anon smallint  NOT NULL default '2',
  PRIMARY KEY  (bid)
);
  CREATE INDEX blocks_bid ON {$_TABLES['blocks']}(bid);
  CREATE INDEX blocks_is_enabled ON {$_TABLES['blocks']}(is_enabled);
  CREATE INDEX blocks_tid ON {$_TABLES['blocks']}(tid);
  CREATE INDEX blocks_type ON {$_TABLES['blocks']}(type);
  CREATE INDEX blocks_name ON {$_TABLES['blocks']}(name);
  CREATE INDEX blocks_onleft ON {$_TABLES['blocks']}(onleft); 
";

$_SQL[] = "
CREATE TABLE {$_TABLES['commentcodes']} (
  code smallint NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
) 
";

$_SQL[] = "
CREATE TABLE {$_TABLES['commentedits']} (
  cid int NOT NULL,
  uid smallint NOT NULL,
  time timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (cid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['commentmodes']} (
  mode varchar(10) NOT NULL default '',
  name varchar(32) default NULL,
  PRIMARY KEY  (mode)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['commentnotifications']} (
  cid int default NULL,
  uid smallint NOT NULL,
  deletehash varchar(32) NOT NULL,
  mid int default NULL,
  PRIMARY KEY  (deletehash)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['comments']} (
  cid SERIAL,
  type varchar(30) NOT NULL DEFAULT 'article',
  sid varchar(40) NOT NULL default '',
  date timestamp NOT NULL DEFAULT current_timestamp,
  title varchar(128) default NULL,
  comment text,
  score smallint NOT NULL default '0',
  reason smallint NOT NULL default '0',
  pid int NOT NULL default '0',
  lft smallint NOT NULL default '0',
  rht smallint NOT NULL default '0',
  indent smallint  NOT NULL default '0',
  name varchar(32) default NULL,
  uid smallint NOT NULL default '1',
  ipaddress varchar(39) NOT NULL default '',
  PRIMARY KEY  (cid)
);
  CREATE INDEX comments_sid ON {$_TABLES['comments']}(sid);
  CREATE INDEX comments_uid ON {$_TABLES['comments']}(uid);
  CREATE INDEX comments_lft ON {$_TABLES['comments']}(lft);
  CREATE INDEX comments_rht ON {$_TABLES['comments']}(rht);
  CREATE INDEX comments_date ON {$_TABLES['comments']}(date); 
";

$_SQL[] = "
CREATE TABLE {$_TABLES['commentsubmissions']} (
  cid SERIAL,
  type varchar(30) NOT NULL default 'article',
  sid varchar(40) NOT NULL,
  date timestamp NOT NULL default current_timestamp,
  title varchar(128) default NULL,
  comment text,
  uid smallint NOT NULL default '1',
  name varchar(32) default NULL,
  pid int NOT NULL default '0',
  ipaddress varchar(39) NOT NULL,
  PRIMARY KEY  (cid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['conf_values']} (
  name varchar(50) default NULL,
  value text,
  type varchar(50) default NULL,
  group_name varchar(50) default NULL,
  default_value text,
  subgroup int default NULL,
  selectionArray int default NULL,
  sort_order int default NULL,
  fieldset int default NULL
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['cookiecodes']} (
  cc_value int NOT NULL default '0',
  cc_descr varchar(20) NOT NULL default '',
  PRIMARY KEY  (cc_value)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['dateformats']} (
  dfid smallint NOT NULL default '0',
  format varchar(32) default NULL,
  description varchar(64) default NULL,
  PRIMARY KEY  (dfid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['featurecodes']} (
  code smallint NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['features']} (
  ft_id SERIAL ,
  ft_name varchar(20) NOT NULL default '',
  ft_descr varchar(255) NOT NULL default '',
  ft_gl_core smallint NOT NULL default '0',
  PRIMARY KEY  (ft_id));
  CREATE INDEX ft_name ON {$_TABLES['features']}(ft_name);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['frontpagecodes']} (
  code smallint NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['group_assignments']} (
  ug_main_grp_id smallint NOT NULL default '0',
  ug_uid smallint  default NULL,
  ug_grp_id smallint  default NULL
);
  CREATE INDEX group_assignments_ug_main_grp_id ON {$_TABLES['group_assignments']}(ug_main_grp_id);
  CREATE INDEX group_assignments_ug_uid ON {$_TABLES['group_assignments']}(ug_uid);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['groups']} (
  grp_id SERIAL,
  grp_name varchar(50) NOT NULL default '',
  grp_descr varchar(255) NOT NULL default '',
  grp_gl_core smallint  NOT NULL default '0',
  grp_default smallint  NOT NULL default '0',
  PRIMARY KEY  (grp_id)
);
CREATE UNIQUE INDEX grp_name ON {$_TABLES['groups']}(grp_name);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['maillist']} (
  code SERIAL, 
  name char(32) default NULL,
  PRIMARY KEY  (code)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['pingservice']} (
  pid SERIAL,
  name varchar(128) default NULL,
  ping_url varchar(255) default NULL,
  site_url varchar(255) default NULL,
  method varchar(80) default NULL,
  is_enabled smallint  NOT NULL DEFAULT '1',
  PRIMARY KEY (pid));
  CREATE INDEX pingservice_is_enabled ON {$_TABLES['pingservice']}(is_enabled);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['plugins']} (
  pi_name varchar(30) NOT NULL default '',
  pi_version varchar(20) NOT NULL default '',
  pi_gl_version varchar(20) NOT NULL default '',
  pi_enabled smallint  NOT NULL default '1',
  pi_homepage varchar(128) NOT NULL default '',
  PRIMARY KEY  (pi_name)
  );
  CREATE INDEX plugins_enabled ON {$_TABLES['plugins']}(pi_enabled);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['postmodes']} (
  code char(10) NOT NULL default '',
  name char(32) default NULL,
  PRIMARY KEY  (code)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['sessions']} (
  sess_id int NOT NULL default '0',
  start_time int NOT NULL default '0',
  remote_ip varchar(39) NOT NULL default '',
  uid smallint NOT NULL default '1',
  md5_sess_id varchar(128) default NULL,
  PRIMARY KEY  (sess_id)
);
  CREATE INDEX start_time ON {$_TABLES['sessions']} (start_time);
  CREATE INDEX remote_ip ON {$_TABLES['sessions']}(remote_ip);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['sortcodes']} (
  code char(4) NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['speedlimit']} (
  id SERIAL,
  ipaddress varchar(39) NOT NULL default '',
  date int default NULL,
  type varchar(30) NOT NULL default 'submit',
  PRIMARY KEY (id));
  CREATE UNIQUE INDEX type_ipaddress on {$_TABLES['speedlimit']}(type,ipaddress);
  CREATE UNIQUE INDEX  date on {$_TABLES['speedlimit']}(date);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['statuscodes']} (
  code int NOT NULL default '0',
  name char(32) default NULL,
  PRIMARY KEY  (code)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['stories']} (
  sid varchar(40) NOT NULL default '',
  uid smallint NOT NULL default '1',
  draft_flag smallint default '0',
  tid varchar(20) NOT NULL default 'General',
  date timestamp NOT NULL default current_timestamp,
  title varchar(128) default NULL,
  page_title varchar(128) default NULL,
  introtext text,
  bodytext text,
  hits smallint NOT NULL default '0',
  numemails smallint NOT NULL default '0',
  comments smallint NOT NULL default '0',
  comment_expire timestamp default NULL,
  trackbacks smallint NOT NULL default '0',
  related text,
  featured smallint NOT NULL default '0',
  show_topic_icon smallint NOT NULL default '1',
  commentcode smallint NOT NULL default '0',
  trackbackcode smallint NOT NULL default '0',
  statuscode smallint NOT NULL default '0',
  expire timestamp default NULL,
  postmode varchar(10) NOT NULL default 'html',
  advanced_editor_mode smallint  default '0',
  frontpage smallint default '1',
  meta_description TEXT NULL,
  meta_keywords TEXT NULL,
  owner_id smallint NOT NULL default '1',
  group_id smallint NOT NULL default '2',
  perm_owner smallint NOT NULL default '3',
  perm_group smallint NOT NULL default '3',
  perm_members smallint NOT NULL default '2',
  perm_anon smallint NOT NULL default '2',
  PRIMARY KEY  (sid)
);
CREATE INDEX stories_sid ON {$_TABLES['stories']}(sid);
CREATE INDEX stories_tid ON {$_TABLES['stories']}(tid);
CREATE INDEX stories_uid ON {$_TABLES['stories']}(uid);
CREATE INDEX stories_featured ON {$_TABLES['stories']}(featured);
CREATE INDEX stories_hits ON {$_TABLES['stories']}(hits);
CREATE INDEX stories_statuscode ON {$_TABLES['stories']}(statuscode);
CREATE INDEX stories_expire ON {$_TABLES['stories']}(expire);
CREATE INDEX stories_date ON {$_TABLES['stories']}(date);
CREATE INDEX stories_frontpage ON {$_TABLES['stories']}(frontpage);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['storysubmission']} (
  sid varchar(20) NOT NULL default '',
  uid smallint NOT NULL default '1',
  tid varchar(20) NOT NULL default 'General',
  title varchar(128) default NULL,
  introtext text,
  bodytext text,
  date timestamp default NULL,
  postmode varchar(10) NOT NULL default 'html',
  PRIMARY KEY  (sid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['syndication']} (
  fid SERIAL,
  type varchar(30) NOT NULL default 'article',
  topic varchar(48) NOT NULL default '::all',
  header_tid varchar(48) NOT NULL default 'none',
  format varchar(20) NOT NULL default 'RSS-2.0',
  limits varchar(5) NOT NULL default '10',
  content_length smallint NOT NULL default '0',
  title varchar(40) NOT NULL default '',
  description text,
  feedlogo varchar(255),
  filename varchar(40) NOT NULL default 'geeklog.rss',
  charset varchar(20) NOT NULL default 'UTF-8',
  language varchar(20) NOT NULL default 'en-gb',
  is_enabled smallint NOT NULL default '1',
  updated timestamp default NULL,
  update_info text,
  PRIMARY KEY (fid)
);
CREATE INDEX syndication_type on {$_TABLES['syndication']}(type);
CREATE INDEX syndication_topic ON {$_TABLES['syndication']}(topic);
CREATE INDEX syndication_is_enabled ON {$_TABLES['syndication']}(is_enabled);
CREATE INDEX syndication_updated ON {$_TABLES['syndication']}(updated);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['tokens']} (
  token varchar(32) NOT NULL,
  created timestamp  default NULL,
  owner_id smallint NOT NULL,
  urlfor varchar(255) NOT NULL,
  ttl smallint NOT NULL default '1',
  PRIMARY KEY (token)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['topics']} (
  tid varchar(20) NOT NULL default '',
  topic varchar(48) default NULL,
  imageurl varchar(255) default NULL,
  meta_description TEXT NULL,
  meta_keywords TEXT NULL,
  sortnum smallint default NULL,
  limitnews smallint default NULL,
  is_default smallint  NOT NULL DEFAULT '0',
  archive_flag smallint NOT NULL DEFAULT '0',
  owner_id smallint NOT NULL default '1',
  group_id smallint NOT NULL default '1',
  perm_owner smallint NOT NULL default '3',
  perm_group smallint NOT NULL default '3',
  perm_members smallint NOT NULL default '2',
  perm_anon smallint NOT NULL default '2',
  PRIMARY KEY  (tid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['trackback']} (
  cid SERIAL,
  sid varchar(40) NOT NULL,
  url varchar(255) default NULL,
  title varchar(128) default NULL,
  blog varchar(80) default NULL,
  excerpt text,
  date timestamp default NULL,
  type varchar(30) NOT NULL default 'article',
  ipaddress varchar(39) NOT NULL default '',
  PRIMARY KEY (cid)
);

  CREATE INDEX trackback_sid ON {$_TABLES['trackback']}(sid);
  CREATE INDEX trackback_url ON {$_TABLES['trackback']}(url);
  CREATE INDEX trackback_type ON {$_TABLES['trackback']}(type);
  CREATE INDEX trackback_date ON {$_TABLES['trackback']}(date);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['trackbackcodes']} (
  code smallint NOT NULL default '0',
  name varchar(32) default NULL,
  PRIMARY KEY  (code)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['usercomment']} (
  uid smallint NOT NULL default '1',
  commentmode varchar(10) NOT NULL default 'nested',
  commentorder varchar(4) NOT NULL default 'ASC',
  commentlimit smallint NOT NULL default '100',
  PRIMARY KEY  (uid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['userindex']} (
  uid smallint NOT NULL default '1',
  tids varchar(255) NOT NULL default '',
  etids text,
  aids varchar(255) NOT NULL default '0',
  boxes varchar(255) NOT NULL default '0',
  noboxes smallint NOT NULL default '0',
  maxstories smallint default NULL,
  PRIMARY KEY  (uid)
);
CREATE INDEX userindex_uid ON {$_TABLES['userindex']}(uid);
CREATE INDEX userindex_noboxes ON {$_TABLES['userindex']}(noboxes);
CREATE INDEX userindex_maxstories ON {$_TABLES['userindex']}(maxstories);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['userinfo']} (
  uid smallint NOT NULL default '1',
  about text,
  location varchar(96) NOT NULL default '',
  pgpkey text,
  userspace varchar(255) NOT NULL default '',
  tokens smallint NOT NULL default '0',
  totalcomments smallint NOT NULL default '0',
  lastgranted smallint NOT NULL default '0',
  lastlogin VARCHAR(10) NOT NULL default '0',
  PRIMARY KEY  (uid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['userprefs']} (
  uid smallint NOT NULL default '1',
  noicons smallint NOT NULL default '0',
  willing smallint NOT NULL default '1',
  dfid smallint NOT NULL default '0',
  advanced_editor smallint NOT NULL default '1',
  tzid varchar(125) NOT NULL default '',
  emailstories smallint NOT NULL default '1',
  emailfromadmin smallint NOT NULL default '1',
  emailfromuser smallint NOT NULL default '1',
  showonline smallint NOT NULL default '1',
  PRIMARY KEY  (uid)
)
";

$_SQL[] = "
CREATE TABLE {$_TABLES['users']} (
  uid SERIAL,
  username varchar(16) NOT NULL default '',
  remoteusername varchar(60) NULL,
  remoteservice varchar(60) NULL,
  fullname varchar(80) default NULL,
  passwd varchar(32) NOT NULL default '',
  email varchar(96) default NULL,
  homepage varchar(96) default NULL,
  sig varchar(160) NOT NULL default '',
  regdate timestamp NOT NULL default NULL,
  photo varchar(128) DEFAULT NULL,
  cookietimeout int default '28800',
  theme varchar(64) default NULL,
  language varchar(64) default NULL,
  pwrequestid varchar(16) default NULL,
  status smallint  NOT NULL default '1',
  num_reminders smallint NOT NULL default 0,
  PRIMARY KEY  (uid)
);
  CREATE INDEX LOGIN ON {$_TABLES['users']}(uid,passwd,username);
  CREATE INDEX users_username ON {$_TABLES['users']}(username);
  CREATE INDEX users_fullname ON {$_TABLES['users']}(fullname);
  CREATE INDEX users_email ON {$_TABLES['users']}(email);
  CREATE INDEX users_passwd ON {$_TABLES['users']}(passwd);
  CREATE INDEX users_pwrequestid ON {$_TABLES['users']}(pwrequestid);
";

$_SQL[] = "
CREATE TABLE {$_TABLES['vars']} (
  name varchar(20) NOT NULL default '',
  value text default NULL,
  PRIMARY KEY  (name)
)
";

$_SQL[] = "
CREATE OR REPLACE FUNCTION UNIX_TIMESTAMP(timestamp with time zone) RETURNS integer AS '
SELECT ROUND(EXTRACT(EPOCH FROM ABSTIME($1)))::int4 AS result;
' LANGUAGE 'SQL';
";

$_SQL[] = "
CREATE OR REPLACE FUNCTION UNIX_TIMESTAMP() RETURNS integer AS '
SELECT ROUND(EXTRACT(EPOCH FROM ABSTIME(NOW())))::int4 AS result;
' LANGUAGE 'SQL';
";

$_SQL[] = "CREATE OR REPLACE FUNCTION FROM_UNIXTIME(integer) RETURNS timestamp AS '
SELECT $1::ABSTIME::TIMESTAMP AS result;
' LANGUAGE 'SQL';
";

$_SQL[] = "CREATE OR REPLACE FUNCTION CURDATE() RETURNS date AS 'SELECT current_date AS result' LANGUAGE 'SQL';";

$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (1,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (2,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (4,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,9) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (5,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,9) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (6,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (7,12) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (8,5) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (9,8) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (10,4) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (11,6) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (13,10) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (14,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (15,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (16,4) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (17,10) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (18,10) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (19,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (20,14) ";
$_DATA[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (21,15) ";

$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'user_block','gldefault','User Functions','all',20,'','','epoch',1,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'admin_block','gldefault','Admins Only','all',20,'','','epoch',1,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'section_block','gldefault','Topics','all',10,'','','epoch',1,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'whats_new_block','gldefault','What\'s New','all',30,'','','epoch',0,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'first_block','normal','About Geeklog','homeonly',20,'<p><b>Welcome to Geeklog!</b></p><p>If you\'re already familiar with Geeklog - and especially if you\'re not: There have been many improvements to Geeklog since earlier versions that you might want to read up on. Please read the <a href=\"docs/english/changes.html\">release notes</a>. If you need help, please see the <a href=\"docs/english/support.html\">support options</a>.</p>','','epoch',0,'',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'whosonline_block','phpblock','Who\'s Online','all',10,'','','epoch',0,'phpblock_whosonline',4,2,3,3,2,2) ";
$_DATA[] = "INSERT INTO {$_TABLES['blocks']} (bid, is_enabled, name, type, title, tid, blockorder, content, rdfurl, rdfupdated, onleft, phpblockfn, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ((SELECT NEXTVAL('{$_TABLES['blocks']}_bid_seq')),1,'older_stories','gldefault','Older Stories','all',40,'','','epoch',1,'',4,2,3,3,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (0,'Comments Enabled') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (-1,'Comments Disabled') ";
$_DATA[] = "INSERT INTO {$_TABLES['commentcodes']} (code, name) VALUES (1,'Comments Closed') ";

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
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (13,'%I:%M%p  %B %e, %Y','10:00PM  March 21, 1999') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (14,'%a %b %d, \'%y %I:%M%p','Sun Mar 21, \'99 10:00PM') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (15,'Day %j, %I ish','Day 80, 10 ish') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (16,'%y-%m-%d %I:%M','99-03-21 10:00') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (17,'%d/%m/%y %H:%M','21/03/99 22:00') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (18,'%a %d %b %I:%M%p','Sun 21 Mar 10:00PM') ";
$_DATA[] = "INSERT INTO {$_TABLES['dateformats']} (dfid, format, description) VALUES (19,'%Y-%m-%d %H:%M','1999-03-21 22:00') ";

$_DATA[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (0,'Not Featured') ";
$_DATA[] = "INSERT INTO {$_TABLES['featurecodes']} (code, name) VALUES (1,'Featured') ";

$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'story.edit','Access to story editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'story.moderate','Ability to moderate pending stories',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'story.submit','May skip the story submission queue',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'story.ping', 'Ability to send pings, pingbacks, or trackbacks for stories', 1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'user.edit','Access to user editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'user.delete','Ability to delete a user',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'user.mail','Ability to send email to members',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'syndication.edit', 'Access to Content Syndication', 1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'webservices.atompub', 'May use Atompub Webservices (if restricted)', 1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'block.edit','Access to block editor',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'topic.edit','Access to topic editor',1) ";
$_DATA[] = "SELECT nextval('{$_TABLES['features']}_ft_id_seq')";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'plugin.edit','Can change plugin status',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'group.edit','Ability to edit groups',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'group.delete','Ability to delete groups',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'block.delete','Ability to delete a block',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'plugin.install','Can install/uninstall plugins',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'plugin.upload','Can upload new plugins',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')),'group.assign','Ability to assign users to groups',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'comment.moderate', 'Ability to moderate comments', 1)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'comment.submit', 'Comments are automatically published', 1)";
$_DATA[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES ((SELECT nextval('{$_TABLES['features']}_ft_id_seq')), 'htmlfilter.skip', 'Skip filtering posts for HTML', 1)";

$_DATA[] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (0,'Show Only in Topic') ";
$_DATA[] = "INSERT INTO {$_TABLES['frontpagecodes']} (code, name) VALUES (1,'Show on Front Page') ";

$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,1,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (13,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (11,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,12) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,10) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,9) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,6) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,4) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (12,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,NULL,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,NULL,11) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (10,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (9,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (6,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (4,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (3,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (2,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (1,2,NULL) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (5,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (8,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (14,NULL,1) ";
$_DATA[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (15,NULL,1) ";

// Traditionally, grp_id 1 = Root, 2 = All Users, 13 = Logged-In Users
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Root','Has full access to the site',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'All Users','Group that a typical user is added to',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Story Admin','Has full access to story features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Block Admin','Has full access to block features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Syndication Admin', 'Can create and modify web feeds for the site',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Topic Admin','Has full access to topic features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Remote Users', 'Users in this group can have authenticated against a remote server.',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Webservices Users', 'Can use the Webservices API (if restricted)',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'User Admin','Has full access to user features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Plugin Admin','Has full access to plugin features',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Group Admin','Is a User Admin with access to groups, too',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Mail Admin','Can use Mail Utility',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')),'Logged-in Users','All registered members',1) ";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')), 'Comment Admin', 'Can moderate comments', 1)";
$_DATA[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ((SELECT nextval('{$_TABLES['groups']}_grp_id_seq')), 'Comment Submitters', 'Can submit comments', 0);";

$_DATA[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES ((SELECT nextval('{$_TABLES['maillist']}_code_seq')),'Don\'t Email') ";
$_DATA[] = "INSERT INTO {$_TABLES['maillist']} (code, name) VALUES ((SELECT nextval('{$_TABLES['maillist']}_code_seq')),'Email Headlines Each Night') ";

$_DATA[] = "INSERT INTO {$_TABLES['pingservice']} (pid, name, site_url, ping_url, method, is_enabled) VALUES ((SELECT nextval('{$_TABLES['pingservice']}_pid_seq')), 'Ping-O-Matic', 'http://pingomatic.com/', 'http://rpc.pingomatic.com/', 'weblogUpdates.ping', 1)";

$_DATA[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('plaintext','Plain Old Text') ";
$_DATA[] = "INSERT INTO {$_TABLES['postmodes']} (code, name) VALUES ('html','HTML Formatted') ";

$_DATA[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('ASC','Oldest First') ";
$_DATA[] = "INSERT INTO {$_TABLES['sortcodes']} (code, name) VALUES ('DESC','Newest First') ";

$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (1,'Refreshing') ";
$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (0,'Normal') ";
$_DATA[] = "INSERT INTO {$_TABLES['statuscodes']} (code, name) VALUES (10,'Archive') ";

$_DATA[] = "INSERT INTO {$_TABLES['stories']} (sid, uid, draft_flag, tid, date, title, introtext, bodytext, hits, numemails, comments, related, featured, commentcode, statuscode, postmode, frontpage, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('welcome',2,0,'Geeklog',NOW(),'Welcome to Geeklog!','<p>Welcome and let me be the first to congratulate you on installing Geeklog. Please take the time to read everything in the <a href=\"docs/english/index.html\">docs directory</a>. Geeklog now has enhanced, user-based security.  You should thoroughly understand how these work before you run a production Geeklog Site.</p>\r<p>To log into your new Geeklog site, please use this account:</p>\r<p>Username: <b>Admin</b><br />\rPassword: <b>password</b></p><p><b>And don\'t forget to <a href=\"usersettings.php\">change your password</a> after logging in!</b></p>','',100,1,0,'',1,0,0,'html',1,2,3,3,2,2,2) ";

$_DATA[] = "INSERT INTO {$_TABLES['storysubmission']} (sid, uid, tid, title, introtext, date, postmode) VALUES ('security-reminder',2,'Geeklog','Are you secure?','<p>This is a reminder to secure your site once you have Geeklog up and running. What you should do:</p>\r\r<ol>\r<li>Change the default password for the Admin account.</li>\r<li>Remove the install directory (you won\'t need it any more).</li>\r</ol>',NOW(),'html') ";

$_DATA[] = "INSERT INTO {$_TABLES['syndication']} (type, topic, header_tid, format, limits, content_length, title, description, filename, charset, language, is_enabled, updated, update_info) VALUES ('article', '::all', 'all', 'RSS-2.0', 10, 1, 'Geeklog Site', 'Another Nifty Geeklog Site', 'geeklog.rss', 'iso-8859-1', 'en-gb', 1, 'epoch', NULL)";

$_DATA[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, meta_description, meta_keywords, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('General','General News','/images/topics/topic_news.gif','A topic that contains general news related posts.','News, Post, Information',1,10,6,2,3,2,2,2)";
$_DATA[] = "INSERT INTO {$_TABLES['topics']} (tid, topic, imageurl, meta_description, meta_keywords, sortnum, limitnews, group_id, owner_id, perm_owner, perm_group, perm_members, perm_anon) VALUES ('Geeklog','Geeklog','/images/topics/topic_gl.gif','A topic that contains posts about Geeklog.','Geeklog, Posts, Information',2,10,6,2,3,2,2,2)";

$_DATA[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (1,'nested','ASC',100) ";
$_DATA[] = "INSERT INTO {$_TABLES['usercomment']} (uid, commentmode, commentorder, commentlimit) VALUES (2,'nested','ASC',100) ";

$_DATA[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (1,'','-','0','0',0,0) ";
$_DATA[] = "INSERT INTO {$_TABLES['userindex']} (uid, tids, etids, aids, boxes, noboxes, maxstories) VALUES (2,'','','0','0',0,0) ";

$_DATA[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (1,NULL,NULL,'',0,0,0) ";
$_DATA[] = "INSERT INTO {$_TABLES['userinfo']} (uid, about, pgpkey, userspace, tokens, totalcomments, lastgranted) VALUES (2,NULL,NULL,'',0,0,0) ";

$_DATA[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (1,0,0,0,'',0) ";
$_DATA[] = "INSERT INTO {$_TABLES['userprefs']} (uid, noicons, willing, dfid, tzid, emailstories) VALUES (2,0,1,0,'',1) ";

#
# Dumping data for table 'users'
#

$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status) VALUES ((SELECT NEXTVAL('{$_TABLES['users']}_uid_seq')),'Anonymous','Anonymous','',NULL,NULL,'',NOW(),0,NULL,3) ";
$_DATA[] = "INSERT INTO {$_TABLES['users']} (uid, username, fullname, passwd, email, homepage, sig, regdate, cookietimeout, theme, status) VALUES ((SELECT NEXTVAL('{$_TABLES['users']}_uid_seq')),'Admin','Geeklog SuperUser','5f4dcc3b5aa765d61d8327deb882cf99','root@localhost','http://www.geeklog.net/','',NOW(),28800,NULL,3) ";

$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('totalhits','0') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('lastemailedstories','') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('last_scheduled_run','') ";
$_DATA[] = "INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('database_version','0.0.0') ";

$_DATA[] = "INSERT INTO {$_TABLES['trackbackcodes']} (code, name) VALUES (0,'Trackback Enabled') ";
$_DATA[] = "INSERT INTO {$_TABLES['trackbackcodes']} (code, name) VALUES (-1,'Trackback Disabled') ";
?>
